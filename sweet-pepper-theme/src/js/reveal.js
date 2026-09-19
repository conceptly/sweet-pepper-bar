/**
 * Reveal — scroll-in entrances, once per element (website-brief.md → Motion language →
 * Scroll-in entrances).
 *
 * Same contract as the Story entrance (about-story.js): the server renders the finished
 * state; pre-entrance states exist only once this script has ARMED an element, and an
 * element that has played is handed back to its own CSS untouched (hover lifts, shadows).
 * No exits — scrolling back up finds everything where it landed.
 *
 * Replay (trial, 18 Sep 2026): containers — the mask-* effects — re-park once they are a
 * full screen BELOW the fold, so coming back down deals them again. Nothing ever re-parks
 * above you or in view, so scrolling up still finds a finished page; copy (rise, mask-up)
 * plays once and stays. REPLAY = null turns it off.
 *
 * Templates stay untouched: each page has a PLAN below (effect → selectors). Markup can
 * also opt in directly with data-reveal="…"; the engine arms whatever carries it.
 *
 * Effects (reveal.css):
 *   rise        copy, chips, buttons — 16px lift + fade, Gentle
 *   mask-up     Molot headlines — rise behind a stationary mask (the hero headline's move)
 *   mask-left   containers entering from the left, masked by their own box
 *   mask-right  … from the right
 *   mask-down   … from above — the bartender's ticket PRINTS out from under the photos
 *   pop         pills — Bouncy scale-in
 *
 * Stagger is by batch: whatever crosses the line in the same check plays in document
 * order, 120 ms apart (the Story's stagger). A row of cards deals left to right without
 * anyone numbering them.
 *
 * Triggering is by LAYOUT position (offsetTop up the offsetParent chain), not by
 * IntersectionObserver. A parked element is translated a full width away and clipped to
 * nothing, often inside an overflow: hidden parent — an observer sees it as not there, or
 * there, depending on a pixel of clip margin (the About pairing photo never played once its
 * parked clip was tightened, 18 Sep 2026). Layout boxes ignore transforms and clips, so
 * the line means the same thing for every effect. One passive scroll listener, one rAF.
 */

const HOME = {
    scope: '.home-highlights, .home-bar-preview, .home-kitchen-preview, .home-about-preview, .home-events, .home-contacts',
    plan: {
        'mask-up':    '.section-headline, .section-headline-2, .menu-preview-title',
        'rise':       '.section-eyebrow, .section-description, .section-ctas, .dish-row, .menu-preview-cta, ' +
                      '.about-preview-stats, .about-preview-cta, ' +
                      '.contacts-reserve, .contacts-map-wrap, .contacts-form-wrap, .contacts-more',
        // Bar is text-left, Kitchen is image-left: their photos come in from opposite sides
        // and meet down the page — the kitchen–bar handshake
        'mask-left':  '.highlight-card, .event-card, .events-link-card, .menu-preview--image-left .menu-preview-img-wrap',
        'mask-right': '.menu-preview--text-left .menu-preview-img-wrap, .about-preview-image',
        'pop':        '.menu-preview-badge',
    },
};

/* About — a fixed composition, so one plan for day and night. The Story timeline and ledger
   keep their own entrance (about-story.js) and How it feels its own clock; this plan only
   touches what those scripts don't move. `delays` are added to the batch stagger:
   the × lands as the two photos meet, the ticket prints once they have. */
const ABOUT = {
    scope: '.page-about .about-section:not(.about-hero), .page-about .menu-location, .page-about .menu-entrance-img',
    plan: {
        'mask-up':    '.section-headline, .section-headline-2, .location__title, .about-visit-cta__headline',
        'rise':       '.section-eyebrow, .section-description, .section-ctas, ' +
                      '.about-concept__cta, .about-concept__picker-header, .dish-picker__labels-row, ' +
                      '.about-how-it-feels__cloud, .about-how-it-feels__quotes, .about-how-it-feels__cta, ' +
                      '.about-perks__detail, .about-story__body, .about-story__founder-quote-wrap, ' +
                      '.about-careers__card, .about-careers__cta, .about-careers__empty, ' +
                      '.location__subheading, .location__description, .location__cta, ' +
                      '.about-visit-cta__body, .about-visit-cta__buttons',
        // The pairing: plate from the left, glass from the right — the handshake, literally
        'mask-left':  '.dish-picker__photo-food, .about-guests__card, .about-team__card',
        'mask-right': '.dish-picker__photo-bar, .about-story__founder-img-wrap, .about-team__drift, .location__map',
        'mask-down':  '.dish-picker__card-wrap',
        'pop':        '.dish-picker__shake, .about-perks__stamp, .about-guests__card-pill, .menu-entrance-img__pill',
    },
    delays: { '.dish-picker__shake': 350, '.dish-picker__card-wrap': 500 },
};

/* Visit — a service page: the quietest plan. Text and controls rise, the two pictures
   (map, room photo) are the only masks, the Good-to-know slip pops. The route badges are
   controls, so they rise as rows and never slide. */
const VISIT = {
    scope: '.visit-location, .visit-cta',
    plan: {
        'mask-up':    '.visit-location__headline, .visit-cta__headline',
        'rise':       '.visit-location__eyebrow, .visit-location__badges > li, ' +
                      '.visit-cta__body, .visit-cta__buttons, .visit-cta__booking, .visit-cta__form-wrap',
        // The room photo is .visit-cta__photo on desktop and the full-bleed .visit-band below it
        // (phones, tablets) — one is always display: none and is skipped
        'mask-left':  '.visit-cta__photo, .visit-band',
        'mask-right': '.visit-location__map-column',
        'pop':        '.menu-section__deal',
    },
};

/* Menu (food and drinks) — header furniture moves, the dish lists never do: 253 rows, and
   time-to-dish is the page's KPI (website-brief.md → Menu lists: "a fast reading surface").
   Each section's photo band slides in with its pill, the eyebrow rises, the title rises
   behind its mask, the deal slip pops — and the rows are simply there. The Seasonal rail is
   a horizontal scroller, so it rises as one piece. The pairing station is About's Concept
   again. On phones only the section on show has a box, so the others are never armed:
   switching sections shows them finished. */
const MENU = {
    scope: '.menu-highlights, .menu-section, .menu-pairing-station, .menu-visit-cta, ' +
           '.page-template-page-menu .menu-location, .page-template-page-menu .menu-entrance-img',
    plan: {
        'mask-up':    '.section-headline, .pairing-station__title, .location__title',
        'rise':       '.section-eyebrow, .menu-highlights-grid, ' +
                      '.pairing-station__subtitle, .dish-picker__labels-row, ' +
                      '.location__subheading, .location__description, .location__cta, ' +
                      '.menu-visit-cta__body, .menu-visit-cta__actions',
        'mask-left':  '.menu-section__hero, .dish-picker__photo-food',
        'mask-right': '.dish-picker__photo-bar, .location__map',
        'mask-down':  '.dish-picker__card-wrap',
        'pop':        '.menu-section__hero-pill, .menu-section__deal, .dish-picker__shake, .menu-entrance-img__pill',
    },
    delays: { '.dish-picker__shake': 350, '.dish-picker__card-wrap': 500 },
};

const PLANS = [HOME, ABOUT, VISIT, MENU];

const REPLAY = /^mask-(left|right)$/; // containers re-park a screen below the fold — not mask-up (headlines are copy); null = once only
const STAGGER = 120;      // ms
const NESTED_AFTER = 550; // ms — a nested reveal plays as its parent lands
const FALLBACK = 2400;    // ms — hand the element back even if transitionend never comes

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

const LINE = 0.88;        // of the viewport height: the element is on its way in, not merely touching the fold
const WAKE = 2.5;         // viewports below the top of the screen: lazy photos inside parked elements start loading
const REPARK = 2;         // … a finished container this far down (a full screen below the fold) re-parks
const RIDE = 4;           // viewports per second: faster than this is a ride (a jump-nav pick, an anchor), not a scroll

function isRail(el) {
    const p = el.parentElement;
    return !!p && p.scrollWidth > p.clientWidth + 1 && /(auto|scroll)/.test(getComputedStyle(p).overflowX);
}

// Document-space top of the element's LAYOUT box: no transforms, no clips
function layoutTop(el) {
    let y = 0;
    for (let n = el; n; n = n.offsetParent) y += n.offsetTop;
    return y;
}

export function initReveal() {
    if (reducedMotion.matches) return;

    // Plan → data-reveal. Cards inside a swipe rail (phones) are not dealt one by one —
    // the rail would reveal them mid-swipe; the rail itself rises instead.
    const extraDelay = new WeakMap(); // el → ms added to its batch stagger (a plan's `delays`)

    PLANS.forEach((page) => {
        document.querySelectorAll(page.scope).forEach((section) => {
            Object.entries(page.plan).forEach(([effect, selector]) => {
                section.querySelectorAll(selector).forEach((el) => {
                    if (el.dataset.reveal) return;
                    if (effect.startsWith('mask-') && isRail(el)) {
                        el.parentElement.dataset.reveal = 'rise';
                    } else if (getComputedStyle(el).display === 'inline') {
                        // A two-part title flowing as one line (phones, tablets): inline boxes
                        // take neither translate nor clip-path, so the line's block plays instead
                        if (!el.parentElement.dataset.reveal) el.parentElement.dataset.reveal = effect;
                    } else {
                        el.dataset.reveal = effect;
                    }
                });
            });
            Object.entries(page.delays || {}).forEach(([selector, ms]) => {
                section.querySelectorAll(selector).forEach((el) => extraDelay.set(el, ms));
            });
        });
    });

    // A reveal inside a reveal (the pill on a sliding photo) is never tracked on its own:
    // it is armed with its parent and played off it, so it can't pop while the parent's
    // clip still hides it.
    const roots = [...document.querySelectorAll('[data-reveal]')]
        .filter((el) => !el.parentElement.closest('[data-reveal]'));
    if (!roots.length) return;

    const state = new WeakMap();  // root → 'armed' | 'playing' | 'done'
    const timers = new WeakMap(); // el → fallback timeout, so a stale one can't release a re-parked element
    const hasBox = (el) => el.getClientRects().length > 0;

    function wake(el) {
        el.querySelectorAll('img[loading="lazy"]').forEach((img) => { img.loading = 'eager'; });
    }

    function arm(root) {
        [root, ...root.querySelectorAll('[data-reveal]')].forEach((el) => el.classList.add('is-armed'));
        // A parked mask-right element reaches past the viewport: keep it out of the scroll width
        root.closest('section')?.classList.add('has-reveal');
        state.set(root, 'armed');
    }

    // Hand a root back without playing it (it was passed during a ride, or never seen)
    function release(root) {
        [root, ...root.querySelectorAll('[data-reveal]')].forEach((el) => el.classList.remove('is-armed', 'is-in'));
        state.set(root, 'done');
    }

    function finish(el) {
        clearTimeout(timers.get(el));
        if (!el.classList.contains('is-in')) return;
        el.classList.remove('is-armed', 'is-in');
        el.style.removeProperty('--reveal-delay');
        if (state.has(el)) state.set(el, 'done');
    }

    function play(el, delay) {
        delay += extraDelay.get(el) || 0;
        el.style.setProperty('--reveal-delay', `${delay}ms`);
        el.classList.add('is-in');
        el.dispatchEvent(new CustomEvent('reveal:in', { detail: { delay } })); // count-up.js listens

        el.querySelectorAll('[data-reveal].is-armed:not(.is-in)').forEach((child) => play(child, delay + NESTED_AFTER));

        const onEnd = (e) => {
            if (e.target !== el || !/^(translate|scale)$/.test(e.propertyName)) return;
            el.removeEventListener('transitionend', onEnd);
            finish(el);
        };
        el.addEventListener('transitionend', onEnd);
        clearTimeout(timers.get(el));
        timers.set(el, setTimeout(() => {
            el.removeEventListener('transitionend', onEnd);
            finish(el);
        }, delay + FALLBACK));
    }

    let lastTop = window.scrollY;
    let lastTime = performance.now();

    function check() {
        const top = window.scrollY;
        const vh = window.innerHeight;
        const batch = [];

        // A ride — a jump-nav pick crossing thousands of pixels on the scroll spring — must
        // not deal every section it flies over. While the page moves faster than RIDE
        // nothing plays; whatever ends up entirely above the screen is handed back unplayed;
        // and when the spring slows at its target, that section plays as an arrival.
        const now = performance.now();
        const riding = Math.abs(top - lastTop) / Math.max(1, now - lastTime) * 1000 > vh * RIDE;
        lastTop = top;
        lastTime = now;
        // The last frame of a ride can be a fast one: look again once the page has stopped
        if (riding) { clearTimeout(rideEnd); rideEnd = setTimeout(schedule, 120); }

        roots.forEach((root) => {
            const st = state.get(root);
            if (st === 'playing' || !hasBox(root)) return;
            const y = layoutTop(root);

            if (st === 'armed') {
                if (y + root.offsetHeight < top) release(root);
                else if (y < top + vh * LINE) { if (!riding) batch.push(root); else wake(root); }
                else if (y < top + vh * WAKE) wake(root);
            } else if (st === 'done' && REPLAY && REPLAY.test(root.dataset.reveal) && y > top + vh * REPARK) {
                // Replay: a finished container that is now a full screen below the fold
                // re-parks, unseen. Nothing re-parks in view or above it.
                arm(root);
            }
        });

        batch.forEach((root, i) => {
            state.set(root, 'playing');
            wake(root);
            play(root, i * STAGGER);
        });
    }

    roots.forEach((root) => {
        // No box (the other breakpoint's variant of a line): nothing to reveal; if a resize
        // shows it later, it is simply there
        if (!hasBox(root)) return;
        // Already scrolled past (restored scroll, anchor arrival): it is simply there —
        // but a container can still replay once it is far enough below
        if (layoutTop(root) + root.offsetHeight < window.scrollY) { state.set(root, 'done'); return; }
        arm(root);
    });

    let queued = false;
    let rideEnd = 0;
    const schedule = () => {
        if (queued) return;
        queued = true;
        requestAnimationFrame(() => { queued = false; check(); });
    };
    window.addEventListener('scroll', schedule, { passive: true });
    window.addEventListener('resize', schedule);
    window.addEventListener('load', schedule);
    check();
}
