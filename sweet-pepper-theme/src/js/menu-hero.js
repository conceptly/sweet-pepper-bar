/**
 * Menu Hero — Nav hover ↔ photo/copy swap
 *
 * On hover:  active state transfers to the hovered nav item,
 *            photo crossfades (a ghost of the outgoing photo fades over the incoming
 *            one, as the dish picker's roll), the stack flips its tilt and fan,
 *            caption + description update.
 * On leave:  reverts to the default (server-rendered) section.
 * On click:  smooth-scrolls to the section anchor on the page.
 * On load:   the opening frame is the daypart answer, not the server's default.
 * Idle:      desktop only — the highlight sweeps the word list until the guest
 *            touches the hero, then never again (website-brief.md → Menu page →
 *            Idle behaviour).
 *
 * Figma interaction: Smart animate, Bouncy easing, 800ms.
 * Click-to-section scrolls on the house Gentle spring (gentle-scroll.js).
 */

import { gentleScrollTo } from './gentle-scroll';

// Opening frame by daypart (<html data-now>, inc/daypart-head.php). The bar row is the
// brief's; the kitchen's dinner and party are a PROPOSAL — the brief stops at "lunch midday…".
const OPENING = {
    food:   { breakfast: 'breakfast',  lunch: 'lunch',   dinner: 'hot-dishes', party: 'bar-snacks' },
    drinks: { breakfast: 'tea-coffee', lunch: 'no-buzz', dinner: 'infusions',  party: 'cocktails' },
};

// Idle sweep: one word per step; the first frame holds 2× (brief). PROPOSAL — the brief
// gives no number; the Story ledger runs 4 s, the How it feels heartbeat 5 s.
const SWEEP_STEP = 4000;

export function initMenuHero() {
    const hero = document.querySelector('.menu-hero');
    if (!hero) return;

    // ── Parse section data from inline JSON ──
    const dataEl = hero.querySelector('.menu-hero__data');
    if (!dataEl) return;

    let sections;
    try {
        sections = JSON.parse(dataEl.textContent);
    } catch (e) {
        console.warn('[menu-hero] Could not parse section data', e);
        return;
    }

    // The section the hero rests on: the server's until the daypart answer replaces it below
    let defaultSection = hero.dataset.defaultSection || 'breakfast';

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const desktopMq     = window.matchMedia('(min-width: 992px)'); // below it there is no word list to sweep

    // ── DOM references ──
    const navItems    = hero.querySelectorAll('.menu-hero__nav-item');
    const photoImg    = hero.querySelector('.menu-hero__photo-img');
    const photoPill   = hero.querySelector('.menu-hero__photo-pill');
    const description = hero.querySelector('.menu-hero__description');
    const photoFrame  = hero.querySelector('.menu-hero__photo-frame');
    const commitBtn   = hero.querySelector('.menu-hero__commit-btn');       // phones only
    const commitLabel = commitBtn ? commitBtn.querySelector('.btn-label') : null;
    const commitIcon  = commitBtn ? commitBtn.querySelector('.btn-icon-left') : null;

    if (!photoImg || !photoPill || !description) return;

    const cssMs = (name) => { // the minifier rewrites 1100ms as 1.1s, so read the unit
        const v = getComputedStyle(hero).getPropertyValue(name).trim();
        return (parseFloat(v) || 0) * (/\d\s*s$/.test(v) && !v.endsWith('ms') ? 1000 : 1);
    };
    const cssEase = (name) => getComputedStyle(hero).getPropertyValue(name).trim() || 'ease';

    // ── Preload images into browser cache ──
    Object.values(sections).forEach(sec => {
        const img = new Image();
        img.src = sec.image;
        if (sec.night) { new Image().src = sec.night.image; }
    });

    // The door's preview has a night set (photo, caption, paragraph — the kitchen page's
    // «Дверь в бар» tab, author 24 Sep 2026): cocktails after dark, coffee by day. Read at
    // swap time, so the theme the daypart engine set on <html> is the one that answers.
    const atTheme = (sec) => (sec.night && document.documentElement.dataset.theme === 'night') ? { ...sec, ...sec.night } : sec;

    // ── Page-load entrance gate (menu-hero.css → PAGE-LOAD ENTRANCE) ──
    // The opening word's outline → fill is a load animation tied to .is-active, and hover
    // moves .is-active from word to word: once the guest touches the nav, or the entrance
    // is over, the hero is settled and a hovered word just fills.
    const settle = () => {
        hero.classList.add('is-settled');
        navItems.forEach((item) => item.style.removeProperty('--in-fill'));
    };
    ['pointerenter', 'focusin', 'touchstart'].forEach((type) => {
        hero.querySelector('.menu-hero__nav')?.addEventListener(type, settle, { once: true, passive: true });
    });
    setTimeout(settle, 2600);

    // ── State ──
    let currentSection = defaultSection;
    let hoverTimeout   = null;
    let sweepTimer     = null;
    let demoOver       = false;
    hero.dataset.currentSection = currentSection;

    // ── The stack's direction (menu-hero.css → Photo Stack, the home tile's --dir) ──
    // Alternates with the word's position in the list, so the sweep and a hover down the
    // list lean each photo against the last; the door's preview (not in the list) leans
    // against whatever was up. The PHP prints the first frame's (data-dir on the section;
    // the CSS derives --dir and the colour recipe from it).
    const order = Array.from(navItems, (item) => item.dataset.section);
    let dir = hero.dataset.dir === '-1' ? -1 : 1;
    function setDir(slug) {
        const i = order.indexOf(slug);
        dir = i >= 0 ? (i % 2 ? -1 : 1) : -dir;
        hero.dataset.dir = dir;
    }

    /** Phones: the full-width commit button follows the section on show. */
    function updateCommit(slug) {
        const sec = sections[slug];
        if (!commitBtn || !sec) return;
        if (commitLabel) commitLabel.textContent = sec.ctaLabel || sec.label;
        if (commitIcon && sec.iconSvg) commitIcon.innerHTML = sec.iconSvg;
        commitBtn.setAttribute('href', '#' + slug);
    }

    /**
     * Swap the hero content to a given section with a crossfade.
     *
     * The outgoing photo is cloned as a ghost over the incoming one and fades out on the
     * flat curve over --menu-photo-dur once the new file has decoded (the dish picker's
     * roll does the same with a slide). Ghosts stack under rapid hovers — each is a
     * snapshot of what was on show — and all of them fade when the newest photo is
     * ready. The pill dips for 300 ms around its text change; the description changes
     * when the new photo starts to show. Reduced motion, or the silent daypart swap
     * during the entrance: everything changes at once.
     */
    let swapRun   = 0;
    let pillTimer = null;
    const GHOSTS  = 3; // ghosts kept at most — more than this and the oldest just goes

    function fadeGhost(ghost) {
        ghost.classList.add('is-fading');
        ghost.animate({ opacity: [1, 0] }, {
            duration: cssMs('--menu-photo-dur'),
            easing:   cssEase('--ease-gentle-flat'),
            fill:     'forwards',
        }).finished.then(() => ghost.remove()).catch(() => {});
    }

    function showSection(slug, animate = true) {
        const sec = sections[slug] && atTheme(sections[slug]);
        if (!sec || slug === currentSection) return;

        currentSection = slug;
        hero.dataset.currentSection = slug;
        setDir(slug);

        const setPhoto = () => {
            photoImg.src = sec.image;
            photoImg.style.objectPosition = sec.focus || ''; // tablet 21:9 crop
            photoImg.alt = sec.caption;
            // The card links to what it shows. The door's preview is not a section of this
            // page, so the link keeps its last section through it.
            if (photoFrame && document.getElementById(slug)) {
                photoFrame.setAttribute('href', '#' + slug);
                photoFrame.setAttribute('aria-label', sec.label);
            }
        };
        const setWords = () => {
            photoPill.textContent = sec.caption;
            description.textContent = sec.description;
        };

        if (!animate || reducedMotion.matches || !photoFrame) {
            clearTimeout(pillTimer);
            photoFrame?.classList.remove('is-swapping');
            setPhoto();
            setWords();
            return;
        }

        // Snapshot what is on show, newest ghost lowest (right after the img, under the
        // older ghosts and under the pill)
        const ghost = photoImg.cloneNode(false);
        ghost.className = 'menu-hero__photo-ghost';
        ghost.alt = '';
        ghost.setAttribute('aria-hidden', 'true');
        ghost.removeAttribute('loading');
        photoImg.after(ghost);
        const ghosts = photoFrame.querySelectorAll('.menu-hero__photo-ghost');
        for (let i = 0; i < ghosts.length - GHOSTS; i++) ghosts[i].remove();

        setPhoto(); // parked under the ghost while it decodes

        // Pill: out over 300 ms, the caption changes, back in
        photoFrame.classList.add('is-swapping');
        clearTimeout(pillTimer);
        pillTimer = setTimeout(() => {
            photoPill.textContent = sec.caption;
            photoFrame.classList.remove('is-swapping');
        }, 300);

        const run   = ++swapRun;
        const ready = photoImg.decode ? photoImg.decode().catch(() => {}) : Promise.resolve();
        ready.then(() => {
            if (run !== swapRun) return; // a newer swap fades this ghost with its own
            description.textContent = sec.description;
            photoFrame.querySelectorAll('.menu-hero__photo-ghost:not(.is-fading)').forEach(fadeGhost);
        });
    }

    /**
     * Transfer the active class to a specific nav item (or null to deactivate all).
     * The idle sweep passes visualOnly: the demo moves the fill, never aria-current.
     */
    function setActiveNav(slug, visualOnly = false) {
        navItems.forEach(item => {
            const isTarget = slug !== null && item.dataset.section === slug;
            item.classList.toggle('is-active', isTarget);
            if (visualOnly) return;
            if (isTarget) {
                item.setAttribute('aria-current', 'true');
            } else {
                item.removeAttribute('aria-current');
            }
        });
    }

    // ── Event listeners ──
    navItems.forEach(item => {
        const slug = item.dataset.section;

        item.addEventListener('mouseenter', () => {
            stopDemo();
            clearTimeout(hoverTimeout);
            setActiveNav(slug);
            showSection(slug);
        });

        item.addEventListener('mouseleave', () => {
            // Small delay before reverting — prevents flicker between items
            hoverTimeout = setTimeout(() => {
                setActiveNav(defaultSection);
                showSection(defaultSection);
            }, 200);
        });

        // Click → Gentle spring scroll to the section anchor
        item.addEventListener('click', (e) => {
            const target = document.getElementById(slug);
            if (target) {
                e.preventDefault();
                gentleScrollTo(target);
            }
            // If no target element, let the default anchor behavior handle it
        });
    });

    // Photo card → the section it shows, on the same spring as the words. Below 992px
    // menu-single-section.js takes the click first (capture) and switches the section.
    photoFrame?.addEventListener('click', (e) => {
        const target = document.getElementById((photoFrame.getAttribute('href') || '').slice(1));
        if (target) {
            e.preventDefault();
            gentleScrollTo(target);
        }
    });

    // Keep hover state when moving between nav items (cancel revert)
    const navList = hero.querySelector('.menu-hero__nav-list');
    if (navList) {
        navList.addEventListener('mouseenter', () => {
            clearTimeout(hoverTimeout);
        });
    }

    // ── Door hover → show cross-menu intro content ──
    const door = hero.querySelector('.menu-hero__door');
    if (door) {
        const doorTarget = door.dataset.doorTarget || 'drinks';

        door.addEventListener('mouseenter', () => {
            stopDemo();
            clearTimeout(hoverTimeout);
            // Deactivate all nav items
            setActiveNav(null);
            showSection(doorTarget);
        });

        door.addEventListener('mouseleave', () => {
            hoverTimeout = setTimeout(() => {
                setActiveNav(defaultSection);
                showSection(defaultSection);
            }, 200);
        });
    }

    // ── Phones: a word picked in the jump-nav panel previews here ──
    // (menu-jump-nav.js dispatches; the panel closes, the page does not scroll,
    // and the commit button below the description takes the new section.)
    // The preview sticks — it is a choice, not a hover — so no revert timer.
    hero.addEventListener('menu-hero:preview', (e) => {
        const slug = e.detail && e.detail.slug;
        if (!slug || !sections[slug]) return;
        stopDemo();
        clearTimeout(hoverTimeout);
        setActiveNav(slug);
        showSection(slug);
        updateCommit(slug);
    });

    // ── Opening frame = the daypart answer (brief → Menu page → Idle behaviour) ──
    // Client-side because of the page cache. Same deal as the home engine: if the script
    // beats the photo's entrance the swap is silent and the word's fill stays on schedule;
    // if it arrives late, the swap plays as an ordinary preview.
    // ?daypart= is honoured so every frame can be checked at any hour.
    const sinceFirstPaint = () => {
        const fcp = performance.getEntriesByName('first-contentful-paint')[0];
        return fcp ? performance.now() - fcp.startTime : 0;
    };

    const daypart = new URLSearchParams(window.location.search).get('daypart')
        || document.documentElement.dataset.now;
    const opening = (OPENING[hero.dataset.menuState] || {})[daypart];

    if (opening && sections[opening] && opening !== defaultSection) {
        defaultSection = opening;
        const elapsed = sinceFirstPaint();
        const silent  = reducedMotion.matches || elapsed <= cssMs('--in-photo');

        if (!silent) settle();
        setActiveNav(opening);
        showSection(opening, !silent);
        updateCommit(opening);

        if (silent && !reducedMotion.matches) {
            // On the word, not the hero: the door's pop reads --in-fill too and has already started
            const word = hero.querySelector(`.menu-hero__nav-item[data-section="${opening}"]`);
            word?.style.setProperty('--in-fill', `${Math.max(0, cssMs('--in-fill') - elapsed)}ms`);
        }
    }

    // ── Idle sweep (desktop; brief → Menu page → Idle behaviour) ──
    // The highlight walks the word list in order, wrapping; the door is not a section and
    // is skipped. Any touch of the nav, the photo or the keyboard ends it for the visit —
    // no 8 s resume, nav must not wander after use. It never scrolls, never writes the URL,
    // and holds still while the hero is off-screen or the tab is hidden.
    function stopDemo() {
        demoOver = true;
        clearTimeout(sweepTimer);
    }

    if (desktopMq.matches && !reducedMotion.matches && navItems.length > 1) {
        let inView = true;

        new IntersectionObserver(([entry]) => { inView = entry.isIntersecting; }, { threshold: 0.5 })
            .observe(hero);

        const step = () => {
            if (demoOver) return;
            if (!desktopMq.matches) { stopDemo(); return; }
            if (inView && !document.hidden) {
                const next = order[(order.indexOf(currentSection) + 1) % order.length];
                setActiveNav(next, true);
                showSection(next);
            }
            sweepTimer = setTimeout(step, SWEEP_STEP);
        };

        ['.menu-hero__nav', '.menu-hero__photo'].forEach((sel) => {
            hero.querySelector(sel)?.addEventListener('pointerenter', stopDemo, { once: true, passive: true });
        });
        ['focusin', 'touchstart', 'keydown'].forEach((type) => {
            hero.addEventListener(type, stopDemo, { once: true, passive: true });
        });

        // The first frame holds 2× the step, counted from the end of the entrance (2.6 s gate above)
        sweepTimer = setTimeout(step, 2600 + SWEEP_STEP * 2);
    }
}
