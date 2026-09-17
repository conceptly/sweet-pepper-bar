/**
 * How It Feels — quote wheel + Layout B (Field) word cloud.
 *
 * ── Quote Wheel ──────────────────────────────────────────────
 * Viewport shows exactly 3 cards. CSS scroll-snap handles drag/snap.
 * Infinite loop via 3N cloned cards.
 *
 * ── Cloud (Field) ────────────────────────────────────────────
 * Words spiral-placed from centre (largest first, no overlaps).
 * Idle: orbit homes + lean toward pointer.
 * Click: word fills, centres in column, others make room (relaxation).
 * Clock: heartbeat fills the next word (no centring) + scrolls quote.
 * Only a human click earns centring (word moves to column middle).
 *
 * @package Sweet_Pepper
 */

const CLOCK_INTERVAL = 5000;  // was 3500 — slower heartbeat (author, Sep 2026)
const SEIZED_PAUSE   = 8000;  // after a human touch: the visual release (undim / ease home); the clock never restarts
const ROLL_MS        = 900;   // quote roll duration, on the house spring (--ease-gentle)

// cubic-bezier(0.33, 0.57, 0.08, 1.19) — the --ease-gentle token, solved for scrollTop
// tweens (a scroll can't take a CSS easing). Overshoots past 1, so the roll lands with a
// small settle like the FLIPs elsewhere.
function gentleEase( t ) {
    const x1 = 0.33, y1 = 0.57, x2 = 0.08, y2 = 1.19;
    const bx = ( u ) => 3 * x1 * u * ( 1 - u ) * ( 1 - u ) + 3 * x2 * u * u * ( 1 - u ) + u * u * u;
    const by = ( u ) => 3 * y1 * u * ( 1 - u ) * ( 1 - u ) + 3 * y2 * u * u * ( 1 - u ) + u * u * u;
    let u = t;
    for ( let i = 0; i < 6; i++ ) {
        const dx = 3 * x1 * ( 1 - u ) * ( 1 - 3 * u ) + 3 * x2 * u * ( 2 - 3 * u ) + 3 * u * u;
        if ( Math.abs( dx ) < 1e-6 ) break;
        u -= ( bx( u ) - t ) / dx;
        u = Math.min( 1, Math.max( 0, u ) );
    }
    return by( u );
}
const GAP            = 24;
const FIELD_INSET    = 16;   // px inset from container edges
const WORD_GAP       = 12;   // px gap between placed words
const COMMIT_MARGIN  = 28;   // px margin around the committed word's zone
const MOBILE_BP      = 768;  // below this, fall back to rows
// Below this the quote viewport shows ONE card instead of three (author, Sep 2026).
// Separate from MOBILE_BP on purpose: the band keeps the desktop cloud behaviour
// (drift amplitude, centring on commit) and only changes how many quotes are in view,
// because the cloud now sits above the rail in a portrait column rather than beside it.
const ONE_CARD_BP    = 992;
const FIELD_MIN_H    = 480;  // px floor for the field height (a spiral needs area)
const FIELD_MIN_H_PHONE = 380; // phones: 16 words at 40/26/18 fit; keeps cloud + one card on an SE

export function initHowItFeels() {
    const section = document.querySelector('.about-how-it-feels');
    if ( ! section ) return;

    const cloud    = section.querySelector('.about-cloud');
    const words    = [ ...section.querySelectorAll('.about-cloud-word') ];
    const viewport = section.querySelector('.about-how-it-feels__quotes-viewport');
    const track    = section.querySelector('.about-how-it-feels__quotes-track');

    if ( ! cloud || ! viewport || ! track || words.length === 0 ) return;

    const isField = cloud.classList.contains('about-cloud--field');

    // ══════════════════════════════════════════════════════════
    //  QUOTE WHEEL (unchanged — infinite loop, scroll-snap)
    // ══════════════════════════════════════════════════════════

    const origWraps = [ ...track.querySelectorAll('.about-quote-card__wrap') ];
    const N = origWraps.length;
    if ( N === 0 ) return;

    // Clone for infinite loop.
    origWraps.forEach( el => {
        const clone = el.cloneNode( true );
        clone.dataset.clone = 'append';
        track.appendChild( clone );
    });
    const frag = document.createDocumentFragment();
    origWraps.forEach( el => {
        const clone = el.cloneNode( true );
        clone.dataset.clone = 'prepend';
        frag.appendChild( clone );
    });
    track.insertBefore( frag, track.firstChild );

    let allCards = [ ...track.querySelectorAll('.about-quote-card__wrap') ];

    const wordToOrigIndex = {};
    origWraps.forEach( ( card, i ) => {
        const w = card.dataset.word;
        if ( ! w ) return;
        if ( ! wordToOrigIndex[ w ] ) wordToOrigIndex[ w ] = [];
        wordToOrigIndex[ w ].push( N + i );
    });

    let clockTimer   = null;
    let seizedTimer  = null;
    let currentWord  = null;
    let currentIndex = N;
    let jumping      = false;

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // ── Quote viewport sizing ─────────────────────────────────
    function sizeViewport() {
        if ( N < 3 ) return;
        let h = 0;
        if ( window.innerWidth < ONE_CARD_BP ) {
            // Phones and tablets: one card, sized to the tallest quote so none ever crops
            // (the cards vary 130–170px; a viewport cut to the first three clipped
            // the taller ones as the rail turned).
            //
            // Measured off the CARD's bounding rect, not the wrapper's offsetHeight: the
            // card sits 1° off true, and a rotation's vertical overhang is a function of
            // WIDTH — about 3px on a 364px phone card but 8px on a 897px one in the band,
            // against the viewport's fixed 4px padding. offsetHeight ignores the transform
            // and the tilted top-right and bottom-left corners were being clipped
            // (author, Sep 2026). getBoundingClientRect() returns the rotated box, so the
            // room scales with the card by itself at any width.
            for ( let i = N; i < 2 * N && i < allCards.length; i++ ) {
                const face = allCards[ i ].querySelector('.about-quote-card') || allCards[ i ];
                h = Math.max( h, Math.ceil( face.getBoundingClientRect().height ) );
            }
            h += 16;
        } else {
            for ( let i = N; i < N + 3 && i < allCards.length; i++ ) {
                h += allCards[ i ].offsetHeight;
            }
            h += 2 * GAP + 8;
        }
        viewport.style.height = h + 'px';
    }

    function findCentredIndex() {
        const vpRect   = viewport.getBoundingClientRect();
        const vpCentre = vpRect.top + vpRect.height / 2;
        let best = 0, minDist = Infinity;
        allCards.forEach( ( card, i ) => {
            const rect = card.getBoundingClientRect();
            const dist = Math.abs( ( rect.top + rect.height / 2 ) - vpCentre );
            if ( dist < minDist ) { minDist = dist; best = i; }
        });
        return best;
    }

    function syncQuoteState( idx ) {
        const card = allCards[ idx ];
        if ( ! card ) return;
        allCards.forEach( c => c.classList.remove('is-centred') );
        card.classList.add('is-centred');
        currentIndex = idx;
    }

    function scrollToQuote( idx, instant = false ) {
        const card = allCards[ idx ];
        if ( ! card ) return;
        const cr = card.getBoundingClientRect();
        const vr = viewport.getBoundingClientRect();
        const offset = ( cr.top + cr.height / 2 ) - ( vr.top + vr.height / 2 );
        const target = viewport.scrollTop + offset;
        if ( instant || prefersReduced ) {
            viewport.style.scrollSnapType = 'none';
            viewport.style.scrollBehavior = 'auto';
            viewport.scrollTop = target;
            requestAnimationFrame( () => {
                viewport.style.scrollSnapType = '';
                viewport.style.scrollBehavior = '';
            });
        } else {
            tweenScroll( target );
        }
        syncQuoteState( idx );
    }

    // ── Quote roll: a scrollTop tween on the house spring ─────
    // Native smooth scrolling runs the browser's own ease-in-out over its own
    // duration — the "harsh" roll (author, Sep 2026). Snap is off while the tween
    // runs so it can't fight the motion; a wheel or touch cancels it.
    let rollRaf = null;
    function cancelRoll() {
        if ( rollRaf ) { cancelAnimationFrame( rollRaf ); rollRaf = null; }
        viewport.style.scrollSnapType = '';
        viewport.style.scrollBehavior = '';
    }
    function tweenScroll( target ) {
        cancelRoll();
        const from  = viewport.scrollTop;
        const delta = target - from;
        if ( Math.abs( delta ) < 1 ) return;
        viewport.style.scrollSnapType = 'none';
        viewport.style.scrollBehavior = 'auto';
        const t0 = performance.now();
        const step = ( now ) => {
            const p = Math.min( 1, ( now - t0 ) / ROLL_MS );
            viewport.scrollTop = from + delta * gentleEase( p );
            if ( p < 1 ) {
                rollRaf = requestAnimationFrame( step );
            } else {
                rollRaf = null;
                viewport.scrollTop = target;
                requestAnimationFrame( () => {
                    viewport.style.scrollSnapType = '';
                    viewport.style.scrollBehavior = '';
                });
            }
        };
        rollRaf = requestAnimationFrame( step );
    }

    function checkLoop() {
        if ( jumping ) return;
        const idx = findCentredIndex();
        if ( idx < N ) jumpToOriginal( idx + N );
        else if ( idx >= 2 * N ) jumpToOriginal( idx - N );
    }

    function jumpToOriginal( origIdx ) {
        jumping = true;
        viewport.style.scrollSnapType = 'none';
        viewport.style.scrollBehavior = 'auto';
        const card = allCards[ origIdx ];
        const cr = card.getBoundingClientRect();
        const vr = viewport.getBoundingClientRect();
        viewport.scrollTop += ( cr.top + cr.height / 2 ) - ( vr.top + vr.height / 2 );
        syncQuoteState( origIdx );
        requestAnimationFrame( () => {
            requestAnimationFrame( () => {
                viewport.style.scrollSnapType = '';
                viewport.style.scrollBehavior = '';
                jumping = false;
            });
        });
    }

    // ── Clock ─────────────────────────────────────────────────
    // Human-action priority (author, Sep 2026): the heartbeat is a self-demo for
    // an untouched section. The first touch — a word, a card, a wheel or finger on
    // the rail — stops it for the rest of the visit, the same documented exception
    // the menu hero's idle sweep has. The 8 s pause now only times the visual
    // release (undim, ease home); nothing auto-advances again.
    let userTookOver = false;
    function startClock() {
        if ( prefersReduced || userTookOver ) return;
        stopClock();
        clockTimer = setInterval( advanceNext, CLOCK_INTERVAL );
    }
    function stopClock() {
        if ( clockTimer ) { clearInterval( clockTimer ); clockTimer = null; }
    }
    function seizeClock() {
        stopClock();
        userTookOver = true;
        if ( seizedTimer ) clearTimeout( seizedTimer );
        seizedTimer = setTimeout( () => {
            seizedTimer = null;
            // Release: field words ease back to homes; rows (phones) un-dim.
            if ( isField && fieldReady ) releaseField();
            else cloud.classList.remove('has-focus');
        }, SEIZED_PAUSE );
    }

    function advanceNext() {
        // Heartbeat fills the next word + scrolls its quote.
        // In field mode: fill only, NO centring (only click centres).
        const next = currentIndex + 1;
        const card = allCards[ next ];
        if ( ! card ) return;

        const linkedWord = card.dataset.word;
        if ( linkedWord ) {
            // Fill the word (no field commit — heartbeat doesn't centre).
            words.forEach( w => w.classList.remove('is-active') );
            const tw = words.find( w => w.dataset.key === linkedWord );
            if ( tw ) tw.classList.add('is-active');
            currentWord = linkedWord;

            // Release the field (others un-dim, ease home) on heartbeat fill.
            cloud.classList.remove('has-focus');
            if ( isField && fieldReady ) {
                committedIdx = -1;
                fieldBodies.forEach( b => { b.target = [ b.home[0], b.home[1] ]; });
            }
        }

        scrollToQuote( next );
    }

    // ── Activate a word (fill + scroll quote) ─────────────────
    function activateWord( key, commit = false ) {
        words.forEach( w => w.classList.remove('is-active') );
        const tw = words.find( w => w.dataset.key === key );
        if ( tw ) tw.classList.add('is-active');
        currentWord = key;

        if ( wordToOrigIndex[ key ] && wordToOrigIndex[ key ].length > 0 ) {
            scrollToQuote( wordToOrigIndex[ key ][ 0 ] );
        }

        if ( commit && isField && fieldReady && window.innerWidth >= MOBILE_BP ) {
            commitField( words.indexOf( tw ) );
        } else if ( commit ) {
            // Phones (field or rows): a tap commits by fill + dimming the others;
            // the heartbeat or the 8 s release un-dims. Nothing moves — a 370px
            // field has no room to clear a zone around the word.
            cloud.classList.add('has-focus');
        }
    }

    // ── Word click ────────────────────────────────────────────
    words.forEach( ( word, i ) => {
        word.addEventListener('click', () => {
            activateWord( word.dataset.key, true );
            seizeClock();
        });
    });

    // ── Card click ────────────────────────────────────────────
    track.addEventListener('click', ( e ) => {
        if ( e.target.closest('.about-quote-card__original') ) return;
        const wrap = e.target.closest('.about-quote-card__wrap');
        if ( ! wrap ) return;
        const idx = allCards.indexOf( wrap );
        const centredIdx = findCentredIndex();
        if ( idx !== centredIdx ) {
            scrollToQuote( idx );
            // Also fill the linked word + commit in field.
            const lw = wrap.dataset.word;
            if ( lw ) activateWord( lw, true );
            seizeClock();
        }
    });

    // ── Quote scroll detection ────────────────────────────────
    let scrollRaf = null;
    viewport.addEventListener('scroll', () => {
        if ( jumping ) return;
        if ( scrollRaf ) return;
        scrollRaf = requestAnimationFrame( () => {
            scrollRaf = null;
            const idx = findCentredIndex();
            syncQuoteState( idx );
            // Sync word fill from quote scroll.
            const card = allCards[ idx ];
            if ( card ) {
                const lw = card.dataset.word;
                if ( lw && lw !== currentWord ) {
                    words.forEach( w => w.classList.remove('is-active') );
                    const tw = words.find( w => w.dataset.key === lw );
                    if ( tw ) tw.classList.add('is-active');
                    currentWord = lw;
                }
            }
        });
    }, { passive: true });

    if ( 'onscrollend' in viewport ) {
        viewport.addEventListener('scrollend', () => { if ( ! jumping ) checkLoop(); });
    } else {
        let seTimer = null;
        viewport.addEventListener('scroll', () => {
            if ( seTimer ) clearTimeout( seTimer );
            seTimer = setTimeout( () => { if ( ! jumping ) checkLoop(); seTimer = null; }, 150 );
        }, { passive: true });
    }

    viewport.addEventListener('pointerdown', () => { cancelRoll(); seizeClock(); } );
    viewport.addEventListener('wheel', () => { cancelRoll(); seizeClock(); }, { passive: true });

    // ══════════════════════════════════════════════════════════
    //  LAYOUT B — FIELD CLOUD
    // ══════════════════════════════════════════════════════════

    let fieldReady   = false;
    let fieldBodies  = [];       // { el, w, h, home: [x,y], pos: [x,y], target: [x,y], orbitA, orbitB, phaseA, phaseB }
    let committedIdx = -1;
    let pointerX     = -9999;
    let pointerY     = -9999;
    let rafId        = null;
    let cloudW       = 0;
    let cloudH       = 0;

    if ( isField ) {
        initFieldCloud();
    }

    async function initFieldCloud() {
        // Gate on Molot font.
        try {
            await Promise.race([
                document.fonts.load('56px Molot'),
                new Promise( r => setTimeout( r, 1500 ) ),
            ]);
        } catch(e) { /* proceed anyway */ }

        // Gate on container having width.
        if ( cloud.offsetWidth === 0 ) return;

        // Phones run the field too (author, Sep 2026) — the orbit is the thing to keep;
        // only the click-to-centre commit is desktop (see activateWord).
        measureAndPlace();
    }

    function measureAndPlace() {
        // Measure words while still in row layout.
        cloud.classList.add('is-placing');
        const measured = words.map( el => ({
            el,
            w: el.offsetWidth,
            h: el.offsetHeight,
        }));

        cloudW = cloud.offsetWidth;
        // Field height = the column's height (the wrapper stretches to the quote
        // rail's height), never the row layout's: rows pack words tightly, a
        // spiral needs ~2x that area or most words find no legal spot and fall
        // back to the centre — that is the "pile" failure.
        const column = cloud.parentElement;
        const rowsH  = cloud.offsetHeight;
        const isPhone = window.innerWidth < MOBILE_BP;
        cloudH = Math.max( column ? column.clientHeight : 0, rowsH, isPhone ? FIELD_MIN_H_PHONE : FIELD_MIN_H );

        // Sort largest first (by area) for spiral.
        const sorted = measured
            .map( ( m, i ) => ({ ...m, origIdx: i }) )
            .sort( ( a, b ) => ( b.w * b.h ) - ( a.w * a.h ) );

        // Spiral placement.
        const placed = []; // { x, y, w, h } of placed boxes (top-left coords)
        const cx = cloudW / 2;
        const cy = cloudH / 2;
        // Shape the spiral to the container: squash the longer axis so the
        // walk fills a portrait column as well as a landscape one.
        const kx = Math.min( 1, cloudW / cloudH );
        const ky = Math.min( 1, cloudH / cloudW );

        // Deterministic seed angle from the word list.
        let seed = 0;
        words.forEach( w => {
            const t = w.dataset.key || '';
            for ( let j = 0; j < t.length; j++ ) seed = ( seed * 31 + t.charCodeAt(j) ) | 0;
        });
        const theta0 = ( Math.abs( seed ) % 628 ) / 100; // 0..2π

        // Walk the spiral for one word; returns [x, y] or null.
        const findSpot = ( item, gap, inset ) => {
            const hw = item.w / 2;
            const hh = item.h / 2;
            for ( let s = 0; s < 3000; s++ ) {
                const r = s * 0.9;
                const theta = theta0 + s * 0.35;
                const tx = cx + r * Math.cos( theta ) * kx - hw;
                const ty = cy + r * Math.sin( theta ) * ky - hh;

                if ( tx < inset || ty < inset ||
                     tx + item.w > cloudW - inset ||
                     ty + item.h > cloudH - inset ) continue;

                let overlaps = false;
                for ( const p of placed ) {
                    if ( tx < p.x + p.w + gap &&
                         tx + item.w + gap > p.x &&
                         ty < p.y + p.h + gap &&
                         ty + item.h + gap > p.y ) {
                        overlaps = true;
                        break;
                    }
                }
                if ( ! overlaps ) return [ tx, ty ];
            }
            return null;
        };

        sorted.forEach( item => {
            // Full gap first; if the field is crowded, tighten the gap, then the
            // inset, before ever stacking a word on the centre.
            const spot = findSpot( item, WORD_GAP, FIELD_INSET )
                      || findSpot( item, WORD_GAP / 2, FIELD_INSET )
                      || findSpot( item, 0, FIELD_INSET )
                      || findSpot( item, 0, 0 );
            let bestX, bestY;
            if ( spot ) {
                [ bestX, bestY ] = spot;
            } else {
                bestX = cx - item.w / 2;
                bestY = cy - item.h / 2;
                console.warn( '[how-it-feels] no room in the field for "' + item.el.dataset.key + '" — cloud is ' + cloudW + '×' + cloudH + 'px; fewer or smaller words, or a taller column.' );
            }

            placed.push({ x: bestX, y: bestY, w: item.w, h: item.h });
            item.homeX = bestX;
            item.homeY = bestY;
        });

        // Build bodies array in original word order.
        fieldBodies = new Array( words.length );
        // Phones orbit at half the desktop amplitude: the field is 370 wide with
        // 12px gaps, and two neighbours at ±12 would touch.
        const ampBase = window.innerWidth < MOBILE_BP ? 3 : 6;
        sorted.forEach( item => {
            const rndA = 9 + Math.random() * 10;  // 9–19s period
            const rndB = 11 + Math.random() * 8;
            const ampA = ampBase + Math.random() * ampBase;   // 6–12px desktop, 3–6 phones
            const ampB = ampBase + Math.random() * ampBase;
            fieldBodies[ item.origIdx ] = {
                el: item.el,
                w: item.w,
                h: item.h,
                home: [ item.homeX, item.homeY ],
                pos: [ item.homeX, item.homeY ],
                target: [ item.homeX, item.homeY ],
                orbitA: rndA,
                orbitB: rndB,
                ampA: ampA,
                ampB: ampB,
                phaseA: Math.random() * Math.PI * 2,
                phaseB: Math.random() * Math.PI * 2,
            };
        });

        // Switch to absolute positioning.
        cloud.style.height = cloudH + 'px';

        // Apply transforms WHILE words are still hidden (is-placing),
        // then reveal in the next frame to prevent 0,0 flash.
        cloud.classList.add('is-placed');
        fieldBodies.forEach( b => {
            b.el.style.transform = `translate(${ b.pos[0] }px, ${ b.pos[1] }px)`;
        });

        // Now remove is-placing to reveal — after transforms are set.
        requestAnimationFrame( () => {
            cloud.classList.remove('is-placing');
        });

        fieldReady = true;

        // Pointer tracking.
        cloud.addEventListener('pointermove', ( e ) => {
            const rect = cloud.getBoundingClientRect();
            pointerX = e.clientX - rect.left;
            pointerY = e.clientY - rect.top;
        });
        cloud.addEventListener('pointerleave', () => {
            pointerX = -9999;
            pointerY = -9999;
        });

        // Start the rAF loop.
        if ( ! prefersReduced ) startFieldLoop();
    }

    // ── rAF animation loop ────────────────────────────────────
    let lastTime = 0;
    function startFieldLoop() {
        lastTime = performance.now();
        fieldTick();
    }
    function stopFieldLoop() {
        if ( rafId ) { cancelAnimationFrame( rafId ); rafId = null; }
    }

    function fieldTick( now = performance.now() ) {
        rafId = requestAnimationFrame( fieldTick );
        const t = now / 1000; // time in seconds

        fieldBodies.forEach( ( b, i ) => {
            if ( i === committedIdx ) {
                // Committed word: ease toward target (column centre).
                b.pos[0] += ( b.target[0] - b.pos[0] ) * 0.08;
                b.pos[1] += ( b.target[1] - b.pos[1] ) * 0.08;
            } else {
                // Idle: orbit home + lean toward pointer.
                let tx = b.target[0] + Math.sin( t / b.orbitA * Math.PI * 2 + b.phaseA ) * b.ampA;
                let ty = b.target[1] + Math.sin( t / b.orbitB * Math.PI * 2 + b.phaseB ) * b.ampB;

                // Pointer lean.
                if ( pointerX > 0 && pointerY > 0 ) {
                    const bcx = b.target[0] + b.w / 2;
                    const bcy = b.target[1] + b.h / 2;
                    const dx = pointerX - bcx;
                    const dy = pointerY - bcy;
                    const dist = Math.sqrt( dx * dx + dy * dy );
                    if ( dist < 170 && dist > 1 ) {
                        const pull = ( 170 - dist ) / 170 * 12;
                        tx += ( dx / dist ) * pull;
                        ty += ( dy / dist ) * pull;
                    }
                }

                b.pos[0] += ( tx - b.pos[0] ) * 0.08;
                b.pos[1] += ( ty - b.pos[1] ) * 0.08;
            }

            b.el.style.transform = `translate(${ b.pos[0] }px, ${ b.pos[1] }px)`;
        });
    }

    // ── Commit: make room ─────────────────────────────────────
    function commitField( wordIdx ) {
        if ( wordIdx < 0 || wordIdx >= fieldBodies.length ) return;

        committedIdx = wordIdx;
        cloud.classList.add('has-focus');

        const b = fieldBodies[ wordIdx ];

        // Centre the committed word in the column.
        const centredX = ( cloudW - b.w ) / 2;
        const centredY = ( cloudH - b.h ) / 2;
        b.target = [ centredX, centredY ];

        // Cleared zone: the word's box + COMMIT_MARGIN, centred.
        const zone = {
            x: centredX - COMMIT_MARGIN,
            y: centredY - COMMIT_MARGIN,
            w: b.w + COMMIT_MARGIN * 2,
            h: b.h + COMMIT_MARGIN * 2,
        };

        // Run relaxation on copies of the homes.
        const targets = fieldBodies.map( fb => [ fb.home[0], fb.home[1] ] );
        const count = fieldBodies.length;

        for ( let iter = 0; iter < 200; iter++ ) {
            const pullStrength = iter < 120 ? 0.04 : 0;

            for ( let i = 0; i < count; i++ ) {
                if ( i === wordIdx ) continue;
                const fb = fieldBodies[ i ];

                // 1. Pull toward home.
                if ( pullStrength > 0 ) {
                    targets[i][0] += ( fb.home[0] - targets[i][0] ) * pullStrength;
                    targets[i][1] += ( fb.home[1] - targets[i][1] ) * pullStrength;
                }

                // 2. Push out of the cleared zone.
                const bx = targets[i][0], by = targets[i][1];
                if ( bx < zone.x + zone.w && bx + fb.w > zone.x &&
                     by < zone.y + zone.h && by + fb.h > zone.y ) {
                    const bcx = bx + fb.w / 2;
                    const bcy = by + fb.h / 2;
                    const zcx = zone.x + zone.w / 2;
                    const zcy = zone.y + zone.h / 2;
                    const dx = bcx - zcx;
                    const dy = bcy - zcy;
                    const dist = Math.sqrt( dx * dx + dy * dy ) || 1;
                    targets[i][0] += ( dx / dist ) * 8;
                    targets[i][1] += ( dy / dist ) * 8;
                }

                // 3. Clamp to inset.
                targets[i][0] = Math.max( FIELD_INSET, Math.min( cloudW - FIELD_INSET - fb.w, targets[i][0] ) );
                targets[i][1] = Math.max( FIELD_INSET, Math.min( cloudH - FIELD_INSET - fb.h, targets[i][1] ) );

                // 3b. If still inside zone after clamping, step vertically.
                const bx2 = targets[i][0], by2 = targets[i][1];
                if ( bx2 < zone.x + zone.w && bx2 + fb.w > zone.x &&
                     by2 < zone.y + zone.h && by2 + fb.h > zone.y ) {
                    const bcy2 = by2 + fb.h / 2;
                    const zcy2 = zone.y + zone.h / 2;
                    targets[i][1] += ( bcy2 >= zcy2 ? 8 : -8 );
                }
            }

            // 4. Pairwise AABB separation (must be last per the spec).
            for ( let i = 0; i < count; i++ ) {
                if ( i === wordIdx ) continue;
                for ( let j = i + 1; j < count; j++ ) {
                    if ( j === wordIdx ) continue;
                    const ai = fieldBodies[i], aj = fieldBodies[j];
                    const ax = targets[i][0], ay = targets[i][1];
                    const bx = targets[j][0], by = targets[j][1];

                    const overlapX = ( ax + ai.w + WORD_GAP ) - bx;
                    const overlapY = ( ay + ai.h + WORD_GAP ) - by;
                    const overlapXn = ( bx + aj.w + WORD_GAP ) - ax;
                    const overlapYn = ( by + aj.h + WORD_GAP ) - ay;

                    if ( overlapX > 0 && overlapXn > 0 && overlapY > 0 && overlapYn > 0 ) {
                        // Find smallest overlap axis.
                        const minOx = Math.min( overlapX, overlapXn );
                        const minOy = Math.min( overlapY, overlapYn );

                        if ( minOx < minOy ) {
                            const push = ( overlapX < overlapXn ? overlapX : -overlapXn ) / 2;
                            targets[i][0] -= push;
                            targets[j][0] += push;
                        } else {
                            const push = ( overlapY < overlapYn ? overlapY : -overlapYn ) / 2;
                            targets[i][1] -= push;
                            targets[j][1] += push;
                        }
                    }
                }
            }

            // 5. Final clamp.
            for ( let i = 0; i < count; i++ ) {
                if ( i === wordIdx ) continue;
                const fb = fieldBodies[i];
                targets[i][0] = Math.max( FIELD_INSET, Math.min( cloudW - FIELD_INSET - fb.w, targets[i][0] ) );
                targets[i][1] = Math.max( FIELD_INSET, Math.min( cloudH - FIELD_INSET - fb.h, targets[i][1] ) );
            }
        }

        // Apply targets.
        targets[ wordIdx ] = [ centredX, centredY ];
        fieldBodies.forEach( ( fb, i ) => {
            fb.target = targets[i];
        });
    }

    // ── Release: ease back to homes ───────────────────────────
    function releaseField() {
        committedIdx = -1;
        cloud.classList.remove('has-focus');
        fieldBodies.forEach( b => {
            b.target = [ b.home[0], b.home[1] ];
        });
    }

    // ══════════════════════════════════════════════════════════
    //  INIT
    // ══════════════════════════════════════════════════════════

    sizeViewport();
    // Golos swaps in after init and the cards re-wrap — at phone widths that is a line
    // or two per card, and the third card ended up clipped. Measure again once the
    // fonts are in.
    if ( document.fonts && document.fonts.ready ) {
        document.fonts.ready.then( () => sizeViewport() );
    }

    const defaultWord = section.querySelector('.about-cloud-word.is-active');
    const defaultKey  = defaultWord ? defaultWord.dataset.key : null;

    requestAnimationFrame( () => {
        if ( defaultKey && wordToOrigIndex[ defaultKey ] ) {
            scrollToQuote( wordToOrigIndex[ defaultKey ][ 0 ], true );
        } else {
            scrollToQuote( N, true );
        }
        currentWord = defaultKey;
        startClock();
    });

    // Pause clock + field loop when off-screen.
    if ( 'IntersectionObserver' in window ) {
        const obs = new IntersectionObserver( entries => {
            entries.forEach( entry => {
                if ( entry.isIntersecting ) {
                    if ( ! seizedTimer ) startClock();
                    if ( isField && fieldReady && ! prefersReduced && ! rafId ) startFieldLoop();
                } else {
                    stopClock();
                    if ( isField ) stopFieldLoop();
                }
            });
        }, { threshold: 0.2 });
        obs.observe( section );
    }

    // Resize.
    let resizeTimer = null;
    window.addEventListener('resize', () => {
        if ( resizeTimer ) clearTimeout( resizeTimer );
        resizeTimer = setTimeout( () => {
            sizeViewport();
            scrollToQuote( currentIndex, true );

            if ( isField ) {
                if ( ! fieldReady ) {
                    initFieldCloud();
                } else {
                    // Re-measure and re-place.
                    cloud.classList.remove('is-placed');
                    cloud.style.height = '';
                    words.forEach( w => { w.style.transform = ''; });
                    fieldReady = false;
                    committedIdx = -1;
                    initFieldCloud();
                }
            }

            resizeTimer = null;
        }, 200 );
    });
}
