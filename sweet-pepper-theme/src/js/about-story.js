/**
 * About — The Pepper Story: timeline heat line + counter ledger
 *
 * Spec: about-page-copy.md → The Story; website-brief.md → Motion language.
 *
 * Entrance (once, on scroll): axis draws → ticks pop → arrowhead lands →
 * heat runs from the first marker to the arrowhead → counters count up →
 * slot rotation begins (only if the pool has more entries than slots).
 *
 * Hover a marker: it fills (outline → fill), the heat retracts to it; the
 * ledger dims on markers flagged data-dims-ledger. Hovering the ledger seizes
 * the section clock; it resumes ~8 s after the pointer leaves.
 *
 * No-JS / pre-hydration state is the finished state — the server renders
 * final numbers and the CSS only sets pre-entrance states once .is-armed.
 */

const ROTATE_MS   = 4000;
const SEIZE_MS    = 8000;
const COUNT_MS    = 1400;
const SWAP_MS     = 260;
const HEAT_DELAY  = 500;
const COUNT_DELAY = 1300;

const formatCount = ( n ) => Math.round( n ).toString().replace( /\B(?=(\d{3})+(?!\d))/g, ' ' );
const easeOutCubic = ( t ) => 1 - Math.pow( 1 - t, 3 );

export function initAboutStory() {
    const section = document.querySelector( '.about-story' );
    if ( ! section ) return;

    const timeline   = section.querySelector( '.about-story__timeline' );
    const heat       = section.querySelector( '.about-story__timeline-heat' );
    const milestones = [ ...section.querySelectorAll( '.about-story__milestone' ) ];
    const ledger     = section.querySelector( '.about-story__counters' );
    const slots      = [ ...section.querySelectorAll( '.about-story__counter' ) ];
    const poolEl     = section.querySelector( '.about-story__counter-pool' );

    if ( ! timeline || ! heat || ! ledger ) return;

    const prefersReduced = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

    let pool = [];
    try {
        pool = poolEl ? JSON.parse( poolEl.textContent ) : [];
    } catch ( e ) {
        console.error( '[about-story] Failed to parse counter pool:', e );
    }

    /* ---------------------------------------------------------------
       Timeline hover: fill + heat retract
       --------------------------------------------------------------- */
    const restHeat = () => {
        heat.style.removeProperty( '--heat-end' );
        milestones.forEach( ( m ) => m.classList.remove( 'is-lit' ) );
        ledger.classList.remove( 'is-dim' );
    };

    milestones.forEach( ( m ) => {
        m.addEventListener( 'mouseenter', () => {
            const raw  = m.dataset.left;
            const num  = parseFloat( raw );
            if ( ! Number.isNaN( num ) ) {
                // If the value already contains a unit (e.g. '24px'), use it as-is; otherwise append '%'.
                const val = /[a-z]/i.test( raw ) ? raw : num + '%';
                heat.style.setProperty( '--heat-end', val );
            }
            milestones.forEach( ( x ) => x.classList.toggle( 'is-lit', x === m ) );
            ledger.classList.toggle( 'is-dim', m.dataset.dimsLedger === '1' );
        } );
        m.addEventListener( 'mouseleave', restHeat );
    } );

    /* ---------------------------------------------------------------
       Phones: the timeline is a segmented year control showing one
       milestone at a time (about.css → Story, phones). The control *is*
       the state — the filled segment is the current year. Starts on the
       "now" marker (STILL HERE); a tap on a year makes it current.
       Class-only: on desktop the CSS ignores it.
       --------------------------------------------------------------- */
    const nowMilestone = milestones.find( ( m ) => m.classList.contains( 'about-story__milestone--now' ) )
        || milestones[ milestones.length - 1 ];
    const setCurrent = ( target ) => {
        milestones.forEach( ( m ) => m.classList.toggle( 'is-current', m === target ) );
        ledger.classList.toggle( 'is-dim', target.dataset.dimsLedger === '1' && window.innerWidth < 768 );
    };
    if ( nowMilestone ) setCurrent( nowMilestone );
    milestones.forEach( ( m ) => {
        const year = m.querySelector( '.about-story__milestone-year' );
        if ( ! year ) return;
        year.addEventListener( 'click', () => setCurrent( m ) );
    } );

    /* ---------------------------------------------------------------
       Counters
       --------------------------------------------------------------- */
    const countUp = ( el, target, duration, done ) => {
        if ( prefersReduced || duration <= 0 ) {
            el.textContent = formatCount( target );
            if ( done ) done();
            return;
        }
        const t0 = performance.now();
        const step = ( now ) => {
            const p = Math.min( 1, ( now - t0 ) / duration );
            el.textContent = formatCount( target * easeOutCubic( p ) );
            if ( p < 1 ) requestAnimationFrame( step ); else if ( done ) done();
        };
        requestAnimationFrame( step );
    };

    const slotNumber = ( slot ) => slot.querySelector( '.about-story__counter-number' );
    const slotLabel  = ( slot ) => slot.querySelector( '.about-story__counter-label' );

    // Section clock — the ledger rotation is the section's only idle motion.
    let clock = null;
    let resumeTimer = null;
    let entranceDone = false;
    let nextIdx = slots.length;
    let slotIdx = 0;

    const canRotate = () => pool.length > slots.length && ! prefersReduced;

    const rotate = () => {
        const slot = slots[ slotIdx ];
        const item = pool[ nextIdx % pool.length ];
        nextIdx++;
        slotIdx = ( slotIdx + 1 ) % slots.length;
        slot.classList.add( 'is-out' );
        setTimeout( () => {
            slotLabel( slot ).textContent = item.label;
            slotNumber( slot ).textContent = '0';
            slot.classList.remove( 'is-out' );
            countUp( slotNumber( slot ), item.number, 1000 );
        }, SWAP_MS );
    };

    const startClock = () => {
        if ( clock || ! entranceDone || ! canRotate() ) return;
        clock = setInterval( rotate, ROTATE_MS );
    };
    const stopClock = () => {
        if ( clock ) clearInterval( clock );
        clock = null;
    };

    // Human seizure: hover pauses the clock, it resumes ~8 s after leaving.
    ledger.addEventListener( 'mouseenter', () => {
        stopClock();
        if ( resumeTimer ) clearTimeout( resumeTimer );
    } );
    ledger.addEventListener( 'mouseleave', () => {
        if ( resumeTimer ) clearTimeout( resumeTimer );
        resumeTimer = setTimeout( startClock, SEIZE_MS );
    } );

    /* ---------------------------------------------------------------
       Entrance
       --------------------------------------------------------------- */
    const fillCounters = ( done ) => {
        let left = slots.length;
        slots.forEach( ( slot, i ) => {
            const el = slotNumber( slot );
            const target = parseInt( el.dataset.count, 10 );
            if ( Number.isNaN( target ) ) { left--; return; }
            setTimeout( () => countUp( el, target, COUNT_MS, () => {
                if ( --left <= 0 && done ) done();
            } ), prefersReduced ? 0 : i * 120 );
        } );
        if ( left === 0 && done ) done();
    };

    const runEntrance = () => {
        section.classList.add( 'is-in' );
        setTimeout( () => section.classList.add( 'is-heated' ), prefersReduced ? 0 : HEAT_DELAY );
        setTimeout( () => fillCounters( () => {
            entranceDone = true;
            startClock();
        } ), prefersReduced ? 0 : COUNT_DELAY );
    };

    if ( ! ( 'IntersectionObserver' in window ) ) {
        // No observer: keep the server-rendered finished state, hover still works.
        entranceDone = true;
        startClock();
        return;
    }

    // Arm pre-entrance states only now that JS is guaranteed to finish them.
    section.classList.add( 'is-armed' );
    if ( ! prefersReduced ) {
        slots.forEach( ( slot ) => { slotNumber( slot ).textContent = '0'; } );
    }

    // The entrance keys off the timeline, not the section: on phones the section is
    // ~2000px tall, so a 35% section threshold never fired on a 667px viewport and the
    // counters stayed at 0. Half the timeline in view works at any width.
    let played = false;
    const entranceObs = new IntersectionObserver( ( entries ) => {
        entries.forEach( ( entry ) => {
            if ( entry.isIntersecting && ! played ) {
                played = true;
                runEntrance();
                entranceObs.disconnect();
            }
        } );
    }, { threshold: 0.5 } );
    entranceObs.observe( timeline );

    // The clock runs only while the ledger is on screen.
    const clockObs = new IntersectionObserver( ( entries ) => {
        entries.forEach( ( entry ) => {
            if ( entry.isIntersecting ) {
                if ( ! resumeTimer ) startClock();
            } else {
                stopClock();
            }
        } );
    }, { threshold: 0.2 } );
    clockObs.observe( ledger );
}
