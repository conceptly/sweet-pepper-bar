/**
 * Daypart Engine — switches hero content/theme based on time of day
 * and handles tile click interactions for the image grid.
 */
export function initDaypartEngine() {
    const tiles = document.querySelectorAll('.daypart-tile');
    const html = document.documentElement;

    // Elements to update
    const headline = document.getElementById('hero-headline');
    const subhead = document.getElementById('hero-subhead');
    const menuBtn = document.getElementById('hero-menu-btn');

    /* Daypart content dictionary.
       btnHref (Sep 2026): the hero button used to point at a dead `#menu` anchor that
       exists nowhere on the page. Each daypart now lands on its own section of the menu
       page; the bar state travels with the anchor because only one state renders per
       request (see highlight-card usage in front-page.php). Every anchor here was checked
       against the rendered menu page. */
    const daypartData = {
        breakfast: {
            mode: 'day',
            headline: 'YUMMY MORNING!',
            subhead: 'Coffee, eggs and a good reason to get out of bed.',
            btnText: 'Breakfast menu',
            btnIcon: 'coffee',
            btnHref: '/menu/#breakfast',
        },
        lunch: {
            mode: 'day',
            headline: 'PUMPKIN SOUP TIME!',
            subhead: 'Soup, something hearty, a little break in your day.',
            btnText: 'Lunch menu',
            btnIcon: 'fork-knife',
            btnHref: '/menu/#lunch',
        },
        dinner: {
            mode: 'night',
            headline: 'READY FOR TONIGHT?',
            subhead: 'Comfort food, cocktails and a table for your kind of evening.',
            btnText: 'Dinner menu',
            btnIcon: 'wine',
            btnHref: '/menu/#hot-dishes',
        },
        party: {
            mode: 'night',
            headline: "IT'S COCKTAIL TIME!",
            subhead: 'Start with your favourite cocktail. See where the evening goes.',
            btnText: 'Drinks menu',
            btnIcon: 'martini',
            btnHref: '/menu/?menu=drinks#cocktails',
        },
    };

    const mobileBento = window.matchMedia('(max-width: 767px)');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    /* ── Mobile bento: FLIP the re-placement ──────────
       The grid re-places tiles instantly when the active one changes; this makes every
       tile start from its old box (position via translate, size via inline width/height)
       and lets the CSS transitions in hero.css carry it to the new one on the Gentle
       spring — the tapped tile visibly moves into the large slot (website-brief.md →
       Mobile — home hero → Behaviour), nothing crossfades. */
    function flipTiles(mutate) {
        if (!mobileBento.matches || reducedMotion.matches) { mutate(); return; }

        const parts = [];
        tiles.forEach(t => {
            const w = t.querySelector('.tile-img-wrapper');
            parts.push({ el: t, first: t.getBoundingClientRect() });
            if (w) parts.push({ el: w, first: w.getBoundingClientRect(), inner: true });
        });

        parts.forEach(p => { p.el.style.transition = 'none'; });
        mutate();

        // Old sizes first: a tile landing in a narrow column is centred there, so where it
        // sits depends on its width — measure the landing box with the old size in place.
        parts.forEach(p => {
            p.el.style.width = p.first.width + 'px';
            p.el.style.height = p.first.height + 'px';
        });
        parts.forEach(p => {
            if (p.inner) return;
            const last = p.el.getBoundingClientRect(); // transitions are off, sizes are the old ones
            const dx = p.first.left - last.left;
            const dy = p.first.top - last.top;
            p.el.style.transform = `translate(${dx}px, ${dy}px)`;
        });

        // Two frames: one to commit the start state, one to release it into the transitions
        requestAnimationFrame(() => requestAnimationFrame(() => {
            parts.forEach(p => {
                p.el.style.transition = '';
                p.el.style.width = '';
                p.el.style.height = '';
                if (!p.inner) p.el.style.transform = '';
            });
        }));
    }

    /* ── Activate a tile ─────────────────────────────── */
    function activateTile(tile) {
        const dp = tile.dataset.daypart;
        const data = daypartData[dp];
        if (!data) return;

        flipTiles(() => {
            // Toggle active class
            tiles.forEach(t => t.classList.remove('is-active'));
            tile.classList.add('is-active');
            // Mobile bento picks its grid geometry from this (hero.css ≤ 767px)
            const grid = tile.closest('.daypart-grid');
            if (grid) grid.dataset.active = dp;
        });

        // Switch day/night theme
        if (data.mode === 'night') {
            html.setAttribute('data-theme', 'night');
        } else {
            html.removeAttribute('data-theme');
        }

        // Update hero copy
        if (headline) headline.textContent = data.headline;
        if (subhead) subhead.textContent = data.subhead;

        // Update menu button label + icon
        if (menuBtn) {
            const labelSpan = menuBtn.querySelector('.btn-label');
            const iconSpan = menuBtn.querySelector('.btn-icon i');
            if (labelSpan) labelSpan.textContent = data.btnText;
            if (iconSpan) iconSpan.className = `ph-fill ph-${data.btnIcon}`;
            if (data.btnHref) menuBtn.href = data.btnHref;
        }
    }

    /* ── Click handlers ──────────────────────────────── */
    tiles.forEach(tile => {
        tile.addEventListener('click', () => activateTile(tile));
    });

    /* ── Determine real-time daypart ─────────────────── */
    const hour = new Date().getHours();
    let currentDP;
    if (hour < 12) currentDP = 'breakfast';
    else if (hour < 17) currentDP = 'lunch';
    else if (hour < 21) currentDP = 'dinner';
    else currentDP = 'party';

    // Mark the real-time daypart tile with .is-now-daypart (for the Now badge)
    const nowTile = document.querySelector(`.daypart-tile[data-daypart="${currentDP}"]`);
    if (nowTile) {
        nowTile.classList.add('is-now-daypart');
    }

    /* ── URL override (?theme=night, ?daypart=dinner, ?menu=drinks) ── */
    const params = new URLSearchParams(window.location.search);
    const themeOverride = params.get('theme');
    const daypartOverride = params.get('daypart');
    const menuOverride = params.get('menu');

    // Bar menu is always dark (website-brief.md: "Menu — drinks state: Always dark")
    if (menuOverride === 'drinks') {
        html.setAttribute('data-theme', 'night');
    } else if (themeOverride === 'night' || ['dinner', 'party'].includes(daypartOverride)) {
        // Force night mode from URL
        const overrideDP = daypartOverride && daypartData[daypartOverride] ? daypartOverride : 'dinner';
        const overrideTile = document.querySelector(`.daypart-tile[data-daypart="${overrideDP}"]`);
        if (overrideTile) {
            activateTile(overrideTile);
        } else {
            // No tiles on this page (e.g. menu page) — just set the theme
            html.setAttribute('data-theme', 'night');
        }
    } else if (daypartOverride && daypartData[daypartOverride]) {
        // Explicit daypart override (day mode: breakfast/lunch)
        const overrideTile = document.querySelector(`.daypart-tile[data-daypart="${daypartOverride}"]`);
        if (overrideTile) {
            activateTile(overrideTile);
        }
    } else {
        // Auto-activate the current daypart on page load
        if (nowTile) {
            activateTile(nowTile);
        }
    }

    /* ── Lang nudge — slide-out dismiss ────────────── */
    const langNudge = document.getElementById('lang-nudge');
    const langNudgeClose = document.getElementById('lang-nudge-close');
    if (langNudge && langNudgeClose) {
        langNudgeClose.addEventListener('click', () => {
            // Add dismiss class to trigger slide-out
            langNudge.classList.add('is-dismissed');
            // After animation, collapse the wrapper
            langNudge.addEventListener('transitionend', () => {
                const wrapper = langNudge.closest('.lang-nudge-wrapper');
                if (wrapper) {
                    wrapper.style.height = wrapper.offsetHeight + 'px';
                    // Force reflow
                    wrapper.offsetHeight;
                    wrapper.style.transition = 'height 0.3s ease, margin 0.3s ease';
                    wrapper.style.height = '0';
                    wrapper.style.marginBottom = '0';
                    wrapper.style.overflow = 'hidden';
                }
            }, { once: true });
        });
    }
}
