import { scrambleTo } from './scramble-text';
import { getBarStatus, getBarHours, formatBarTime } from './bar-clock.js';

/**
 * Daypart Engine — switches hero content/theme based on time of day
 * and handles tile click interactions for the image grid.
 */
/* ── PROTOTYPE — the "now" word (author's idea, 21 Sep 2026). ?hl=1 [&hlday=…] [&hld=…]
   One word of the hero headline — the one the clock chose — takes the louder colour of a
   pair (hero.css → PROTOTYPE lists the pairs). Closed-hours headlines carry no `now`:
   nothing is on, nothing lit. The scramble writes plain text, so the word lights when the
   ride has resolved (600 ms). Delete with the CSS block, or promote: the split then belongs
   in the copy, per language. */
const hlParams = new URLSearchParams(window.location.search);
const HL = hlParams.get('hl');
if (HL) {
    const cl = document.documentElement.classList;
    cl.add('hl-on');
    if (hlParams.get('hlday')) cl.add(`hl-day-${hlParams.get('hlday')}`);
    if (hlParams.get('hld')) cl.add(`hl-d-${hlParams.get('hld')}`);
}
let markTimer = null;

function markNowWord(el, data, delay) {
    clearTimeout(markTimer);
    if (!HL || !data.now) return;
    markTimer = setTimeout(() => {
        const at = data.headline.indexOf(data.now);
        if (at < 0 || el.textContent !== data.headline) return; // another swap is under way
        const word = document.createElement('span');
        word.className = 'hero-headline__now';
        word.textContent = data.now;
        el.replaceChildren(
            data.headline.slice(0, at),
            word,
            data.headline.slice(at + data.now.length),
        );
    }, delay);
}

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
            now: 'MORNING', // PROTOTYPE ?hl= — the word the clock chose
            subhead: 'Coffee, eggs and a good reason to get out of bed.',
            btnText: 'Breakfast menu',
            btnIcon: 'coffee',
            btnHref: '/menu/#breakfast',
        },
        lunch: {
            mode: 'day',
            headline: 'PUMPKIN SOUP TIME!',
            now: 'PUMPKIN SOUP', // PROTOTYPE ?hl= — the word the clock chose
            subhead: 'Soup, something hearty, a little break in your day.',
            btnText: 'Lunch menu',
            btnIcon: 'fork-knife',
            btnHref: '/menu/#lunch',
        },
        dinner: {
            mode: 'night',
            headline: 'READY FOR TONIGHT?',
            now: 'TONIGHT', // PROTOTYPE ?hl= — the word the clock chose
            subhead: 'Comfort food, cocktails and a table for your kind of evening.',
            btnText: 'Dinner menu',
            btnIcon: 'wine',
            btnHref: '/menu/#hot-dishes',
        },
        party: {
            mode: 'night',
            headline: "IT'S COCKTAIL TIME!",
            now: 'COCKTAIL', // PROTOTYPE ?hl= — the word the clock chose
            subhead: 'Start with your favourite cocktail. See where the evening goes.',
            btnText: 'Drinks menu',
            btnIcon: 'martini',
            btnHref: '/menu/?menu=drinks#cocktails',
        },
    };

    /* Closed state — bar and kitchen shut (by default 02:00 → 08:30, Sundays → 10:00; the
       hours come from Bar Settings through bar-clock.js, and so do the times in this copy). inc/daypart-head.php sets <html data-closed="night|morning|sunday"> and parks
       data-now: party till 04:00, breakfast after. The parked tile stays lit and carries
       this copy instead of its own; every other tile previews its daypart as usual, and
       tapping the parked tile brings the closed copy back. No Now marker while closed.
       The word "closed" stays out of the hero (website-brief.md → Closed lines).
       ?closed=night|morning|sunday shows a window at any hour. */
    // ?closed=sunday on a weekday still speaks of Sunday's doors
    const opensAt = formatBarTime(html.dataset.closed === 'sunday' && getBarHours()
        ? getBarHours().openSun
        : getBarStatus().opens);
    const closedCopy = {
        night:   { headline: 'GOOD NIGHT, YAROSLAVL', subhead: `See you for breakfast at ${opensAt}.` },
        morning: { headline: "YOU'RE UP BEFORE THE BAR!", subhead: `Eggs and coffee from ${opensAt}.` },
        sunday:  { headline: 'A LITTLE SUNDAY POLISH', subhead: `Back at ${opensAt}, spotless.` },
    }[html.dataset.closed];

    // Same query as the bento block in hero.css: phones, and portrait tablets in the band
    const mobileBento = window.matchMedia('(max-width: 767px), (min-width: 768px) and (max-width: 991px) and (min-height: 1000px)');
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

    /* ── Page-load entrance (hero.css → Page-load entrance) ──
       The entrance itself is CSS and starts with the first paint. The engine's part:
       swap the server-rendered tile for the real daypart while the tiles are still
       hidden (transitions off, no FLIP), keep the lighting on schedule for the tile it
       just activated, and settle the hero afterwards so taps don't replay the lighting. */
    const hero = document.querySelector('.home-hero');
    // The build's minifier rewrites 1100ms as 1.1s, so read the unit
    const cssMs = (name) => {
        const v = getComputedStyle(hero).getPropertyValue(name).trim();
        return (parseFloat(v) || 0) * (/\d\s*s$/.test(v) && !v.endsWith('ms') ? 1000 : 1);
    };

    function sinceFirstPaint() {
        const fcp = performance.getEntriesByName('first-contentful-paint')[0];
        return fcp ? performance.now() - fcp.startTime : 0;
    }

    function settle() {
        if (!hero || hero.classList.contains('is-settled')) return;
        hero.classList.add('is-settled');
        hero.style.removeProperty('--in-light');
    }

    function activateOnLoad(tile) {
        if (!hero) { activateTile(tile); return; }

        const elapsed = sinceFirstPaint();
        // Script arrived after the tiles began to show: the entrance is the server's; this is a tap
        if (!reducedMotion.matches && elapsed > cssMs('--in-tiles')) {
            activateTile(tile); // settles first
            return;
        }

        hero.classList.add('is-booting');
        activateTile(tile, true);
        hero.style.setProperty('--in-light', `${Math.max(0, cssMs('--in-light') - elapsed)}ms`);

        requestAnimationFrame(() => requestAnimationFrame(() => {
            hero.classList.remove('is-booting');
            if (reducedMotion.matches || !hero.getAnimations) { settle(); return; }
            const running = hero.getAnimations({ subtree: true }).map((a) => a.finished);
            Promise.allSettled(running).then(settle);
        }));
    }

    /* ── Activate a tile ─────────────────────────────── */
    function activateTile(tile, onLoad = false) {
        const dp = tile.dataset.daypart;
        if (!daypartData[dp]) return;
        const data = closedCopy && dp === html.dataset.now
            ? { ...daypartData[dp], ...closedCopy }
            : daypartData[dp];

        // A tap during the entrance seizes it: everything lands, then the tap plays
        if (!onLoad) settle();

        (onLoad ? (mutate) => mutate() : flipTiles)(() => {
            // Toggle active class
            tiles.forEach(t => t.classList.remove('is-active'));
            tile.classList.add('is-active');
            // The bento picks its grid geometry from this (hero.css — phones and portrait tablets)
            const grid = tile.closest('.daypart-grid');
            if (grid) grid.dataset.active = dp;
        });

        // Switch day/night theme
        if (data.mode === 'night') {
            html.setAttribute('data-theme', 'night');
        } else {
            html.removeAttribute('data-theme');
        }

        // Update hero copy — a tap scrambles the headline into the next one; the load swap
        // is written directly (the entrance is already moving it)
        if (headline) {
            if (onLoad) headline.textContent = data.headline;
            else scrambleTo(headline, data.headline);
            markNowWord(headline, data, onLoad ? 0 : 680);
        }
        if (subhead) subhead.textContent = data.subhead;

        // Update menu button label + icon
        if (menuBtn) {
            const labelSpan = menuBtn.querySelector('.btn-label');
            const iconSpan = menuBtn.querySelector('.btn-icon i');
            if (labelSpan) labelSpan.textContent = data.btnText;
            if (iconSpan) iconSpan.className = `ph-fill ph-${data.btnIcon}`;
            if (data.btnHref) menuBtn.href = ((window.spLang && window.spLang.root) || '') + data.btnHref; // the language prefix (inc/lang.php)
        }
    }

    /* ── Click handlers ──────────────────────────────── */
    tiles.forEach(tile => {
        tile.addEventListener('click', () => activateTile(tile));
    });

    /* ── Real-time daypart ─────────────────────────────
       Worked out before first paint by the inline script in inc/daypart-head.php, which
       also sets the night theme so the page never paints in the wrong clothes. The hour
       thresholds live there and only there. */
    const currentDP = html.dataset.now;

    // Mark the real-time daypart tile with .is-now-daypart (for the Now badge)
    const nowTile = document.querySelector(`.daypart-tile[data-daypart="${currentDP}"]`);
    // — unless the bar is closed: there is no "now" when the room is dark
    if (nowTile && !closedCopy) {
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
            activateOnLoad(overrideTile);
        } else {
            // No tiles on this page (e.g. menu page) — just set the theme
            html.setAttribute('data-theme', 'night');
        }
    } else if (daypartOverride && daypartData[daypartOverride]) {
        // Explicit daypart override (day mode: breakfast/lunch)
        const overrideTile = document.querySelector(`.daypart-tile[data-daypart="${daypartOverride}"]`);
        if (overrideTile) {
            activateOnLoad(overrideTile);
        }
    } else {
        // Auto-activate the current daypart on page load
        if (nowTile) {
            activateOnLoad(nowTile);
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
