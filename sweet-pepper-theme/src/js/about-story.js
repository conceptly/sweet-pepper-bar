/**
 * About — The Pepper Story: timeline heat line + counter ledger
 *
 * Spec: about-page-copy.md → The Story; website-brief.md → Motion language.
 *
 * Entrance (once, on scroll): axis draws → ticks pop → arrowhead lands →
 * heat runs from the first marker to the arrowhead → counters roll up from
 * zero (odometer.js) → slot rotation begins (only if the pool has more
 * entries than slots).
 *
 * The ledger (29 Sep 2026, author's pick of three prototypes): the pool is
 * the «История» repeater, drawn in random order from a shuffle bag — every
 * figure once before any repeats, never one already on screen. Every 4 s one
 * random slot rolls to the next figure. Hovering a figure (a tap on phones)
 * rolls that one on; the idle clock is seized while the pointer is on the
 * ledger and resumes ~8 s after it leaves.
 *
 * Hover a marker: it fills (outline → fill), the heat retracts to it; the
 * ledger dims on markers flagged data-dims-ledger.
 *
 * No-JS / pre-hydration state is the finished state — the server renders
 * final numbers and the CSS only sets pre-entrance states once .is-armed.
 */

import { odometer } from './odometer';
import { scrambleTo } from './scramble-text';

const ROTATE_MS   = 4000;
const SEIZE_MS    = 8000;
const ROLL_BUSY   = 1700; // one roll (odometer.js: 1.3 s + stagger), then the slot listens again
const SWAP_MS     = 260;
const HEAT_DELAY  = 500;
const COUNT_DELAY = 1300;

/** Draws from `pool` in random order: all once before any repeats, never one in `showing`. */
function shuffleBag( pool ) {
    let bag = [];
    const refill = () => {
        bag = [ ...pool ];
        for ( let i = bag.length - 1; i > 0; i-- ) {
            const j = Math.floor( Math.random() * ( i + 1 ) );
            [ bag[ i ], bag[ j ] ] = [ bag[ j ], bag[ i ] ];
        }
    };
    return ( showing = [] ) => {
        if ( ! bag.length ) refill();
        let i = bag.findIndex( ( p ) => ! showing.includes( p ) );
        if ( i < 0 ) { refill(); i = bag.findIndex( ( p ) => ! showing.includes( p ) ); }
        return bag.splice( i, 1 )[ 0 ];
    };
}

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
       Phones and tablets: the ticket (tilted 1°, about.css) straightens
       while its middle is in the middle band of the screen — 25–75% of
       the height — and tilts back when it leaves (author, 30 Sep 2026).
       Class-only: above 991 the CSS has no tilt, so the class does nothing.
       Position, not IntersectionObserver: the reveal engine parks
       elements (local-dev notes → reveal.js triggers by layout too).
       --------------------------------------------------------------- */
    if ( ! prefersReduced ) {
        let queued = false;
        const level = () => {
            queued = false;
            const box = ledger.getBoundingClientRect();
            const mid = box.top + box.height / 2;
            const h   = window.innerHeight;
            ledger.classList.toggle( 'is-straight', mid > h * 0.25 && mid < h * 0.75 );
        };
        const look = () => {
            if ( queued ) return;
            queued = true;
            requestAnimationFrame( level );
        };
        window.addEventListener( 'scroll', look, { passive: true } );
        window.addEventListener( 'resize', look );
        look();
    }

    /* ---------------------------------------------------------------
       Phones: the timeline is a segmented year control showing one
       milestone at a time (about.css → Story, phones). The control *is*
       the state — the filled segment is the current year. Starts on the
       "now" marker (STILL HERE); a tap on a year makes it current.
       Class-only: on desktop the CSS ignores it.

       On a tap the new name scrambles out of the old one (scramble-text.js,
       the day-part headlines' change — author, 29 Sep 2026) and the wit
       line rises in (about.css → .has-switched). The first state is set
       without either.
       --------------------------------------------------------------- */
    const nowMilestone = milestones.find( ( m ) => m.classList.contains( 'about-story__milestone--now' ) )
        || milestones[ milestones.length - 1 ];
    const nameOf  = ( m ) => m.querySelector( '.about-story__milestone-name' );
    const names   = new Map( milestones.map( ( m ) => [ m, nameOf( m )?.textContent ?? '' ] ) );
    let current = null;
    const setCurrent = ( target, animate = false ) => {
        if ( target === current ) return;
        const prev = current;
        current = target;
        milestones.forEach( ( m ) => m.classList.toggle( 'is-current', m === target ) );
        ledger.classList.toggle( 'is-dim', target.dataset.dimsLedger === '1' && window.innerWidth < 768 );
        // Only where one milestone shows at a time (≤ 991: display: contents); on desktop
        // all three names are always there and none of them changes.
        if ( ! animate || ! prev || getComputedStyle( target ).display !== 'contents' ) return;
        section.classList.add( 'has-switched' );
        // The one that left finishes at once (it is hidden); the new one starts from the old word.
        scrambleTo( nameOf( prev ), names.get( prev ), 1 );
        const el = nameOf( target );
        if ( ! el ) return;
        el.textContent = names.get( prev );
        scrambleTo( el, names.get( target ), 520 );
    };
    if ( nowMilestone ) setCurrent( nowMilestone );
    milestones.forEach( ( m ) => {
        const year = m.querySelector( '.about-story__milestone-year' );
        if ( ! year ) return;
        year.addEventListener( 'click', () => setCurrent( m, true ) );
    } );

    /* ---------------------------------------------------------------
       Counters
       --------------------------------------------------------------- */
    const slotNumber = ( slot ) => slot.querySelector( '.about-story__counter-number' );
    const slotLabel  = ( slot ) => slot.querySelector( '.about-story__counter-label' );

    const canRotate = () => pool.length > slots.length && ! prefersReduced;
    const draw = shuffleBag( pool );
    const odos = slots.map( ( slot ) => odometer( slotNumber( slot ) ) );
    let showing = [];

    // With more figures than slots, the first three come from the bag too; otherwise the
    // server's rows stay where they are.
    slots.forEach( ( slot, i ) => {
        const item = canRotate() ? draw( showing ) : pool[ i ];
        showing[ i ] = item;
        const n = item ? item.number : parseInt( slotNumber( slot ).dataset.count, 10 );
        if ( item ) slotLabel( slot ).textContent = item.label;
        odos[ i ].set( Number.isNaN( n ) ? 0 : n, { instant: true } );
    } );

    // Section clock — the ledger rotation is the section's only idle motion.
    let clock = null;
    let resumeTimer = null;
    let entranceDone = false;
    let lastSlot = -1;

    // Roll slot i to the next figure from the bag; the label fades across meanwhile.
    const rollSlot = ( i ) => {
        const slot = slots[ i ];
        if ( slot.dataset.busy ) return;
        slot.dataset.busy = '1';
        setTimeout( () => { delete slot.dataset.busy; }, ROLL_BUSY );
        const item = draw( showing );
        showing[ i ] = item;
        const label = slotLabel( slot );
        label.classList.add( 'is-out' );
        odos[ i ].set( item.number );
        setTimeout( () => { label.textContent = item.label; label.classList.remove( 'is-out' ); }, SWAP_MS );
    };

    const rotate = () => {
        let i;
        do { i = Math.floor( Math.random() * slots.length ); } while ( slots.length > 1 && i === lastSlot );
        lastSlot = i;
        rollSlot( i );
    };

    const startClock = () => {
        if ( clock || ! entranceDone || ! canRotate() ) return;
        clock = setInterval( rotate, ROTATE_MS );
    };
    const stopClock = () => {
        if ( clock ) clearInterval( clock );
        clock = null;
    };

    // The guest drives it too: hovering a figure (a tap on phones) rolls that one on.
    // The pepper cursor marks a rollable figure (about.css → .is-rollable), and a click rolls
    // it again — one roll at a time, so the click right after the hover roll waits its turn.
    if ( canRotate() ) {
        ledger.classList.add( 'is-rollable' );
        slots.forEach( ( slot, i ) => {
            slot.addEventListener( 'click', ( e ) => {
                if ( e.pointerType !== 'touch' && entranceDone ) rollSlot( i ); // a tap already rolls on pointerup
            } );
        } );
    }
    slots.forEach( ( slot, i ) => {
        slot.addEventListener( 'pointerenter', ( e ) => {
            if ( e.pointerType === 'mouse' && entranceDone && canRotate() ) rollSlot( i );
        } );
        slot.addEventListener( 'pointerup', ( e ) => {
            if ( e.pointerType !== 'mouse' && entranceDone && canRotate() ) rollSlot( i );
        } );
    } );

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
        showing.forEach( ( item, i ) => {
            if ( ! item ) return;
            setTimeout( () => odos[ i ].set( item.number, prefersReduced ? { instant: true } : { fromZero: true } ), prefersReduced ? 0 : i * 120 );
        } );
        setTimeout( done, prefersReduced ? 0 : 1800 );
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
        odos.forEach( ( o ) => o.zero() );
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
