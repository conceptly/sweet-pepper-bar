/**
 * Viewport foot — a ground under Safari's floating bar (prototype, 27 Sep 2026).
 *
 * Safari 26 on the iPhone runs the page under its glass tab bar: whatever sits at the fold
 * shows through the bar (the author's screenshots — a map card, the Lime notice, the next
 * section's headline). Chrome for iOS ends the page above its own bar instead. A page cannot
 * reach the browser chrome, but it can own the strip beneath it: a fixed band at the foot of
 * the viewport, in the ground of the section that is passing under it.
 *
 * What the phone showed (author, 27 Sep 2026, three screenshots): Safari 26 anchors
 * `bottom: 0` at the TOP of its bar and then extends the page's bottom-most colour under the
 * bar by itself. So a 4px sliver is all the band needs — Safari copies its colour down; a 90px
 * band stood 90px above the bar with the copy beneath. Safari's copy is solid, so a blur on
 * the band reaches the sliver only — the glass switch cannot cover the bar's area and stays
 * for the record. `env(safe-area-inset-bottom)` reported nothing, with or without
 * viewport-fit=cover (`&cover=1`), hence the fixed default.
 *
 * Behind URL switches until the author has judged it on the phone (the house way — the rail
 * tremble, the language switch, the cookie notice):
 *   ?foot=solid   the sliver in the section's ground — the page appears to end above the bar
 *   ?foot=glass   the same ground at 70% over a blur (the sliver only — see above)
 *   &h=<px>       the band's height (default 4; `env(safe-area-inset-bottom)` when it says more)
 *   &cover=1      adds viewport-fit=cover to the viewport meta (did nothing on iOS 26)
 *   &tint=1       also keeps <meta name="theme-color"> at the sampled ground
 *
 * The ground is sampled, not typed: on every scroll the layers under the band's top edge are
 * asked for the first opaque background that is a GROUND — at least 90% of the viewport wide,
 * so a button, a card or a chip at the fold never lends its colour (the Paprika band in the
 * author's first screenshot was the Reserve button's) — and fixed layers (the cookie notice,
 * the header) are skipped so the band shows the page's ground even while a note is up. The
 * band follows the alternating grounds and the day / night theme without a table. Nothing
 * runs without the switch.
 */

export function initViewportFoot() {
    const q = new URLSearchParams(window.location.search);
    const mode = q.get('foot');
    if (mode !== 'solid' && mode !== 'glass') return;

    const html = document.documentElement;
    html.dataset.foot = mode;

    const h = parseInt(q.get('h') || '', 10);
    if (h > 0) html.style.setProperty('--foot-h', h + 'px');

    if (q.get('cover') === '1') {
        const meta = document.querySelector('meta[name="viewport"]');
        if (meta && !/viewport-fit/.test(meta.content)) meta.content += ', viewport-fit=cover';
    }

    const band = document.createElement('div');
    band.className = 'viewport-foot';
    band.setAttribute('aria-hidden', 'true');
    document.body.appendChild(band);

    let tint = null;
    if (q.get('tint') === '1') {
        tint = document.querySelector('meta[name="theme-color"]') || document.createElement('meta');
        tint.name = 'theme-color';
        if (!tint.parentNode) document.head.appendChild(tint);
    }

    const opaque = (el) => {
        const bg = getComputedStyle(el).backgroundColor;
        const m = bg.match(/rgba?\(([^)]+)\)/);
        if (!m) return null;
        const parts = m[1].split(',').map(parseFloat);
        return parts.length < 4 || parts[3] > 0.9 ? bg : null;
    };
    // A ground is full-width and not a control: on phones a button spans the gutters too
    // (the Visit booking block's Call), and its Chili is not the page's ground
    const isGround = (el) => el.getBoundingClientRect().width >= window.innerWidth * 0.9
        && !el.matches('a, button, [role="button"], input, select, textarea, label');
    const inFixedLayer = (el) => {
        for (let e = el; e && e !== document.body; e = e.parentElement) {
            const pos = getComputedStyle(e).position;
            if (pos === 'fixed' || pos === 'sticky') return true;
        }
        return false;
    };

    // The first opaque, full-width background up from the first in-flow element under the
    // band's top edge (fixed layers — the notice, the header, the band itself — skipped)
    function groundAt(x, y) {
        const layers = document.elementsFromPoint(x, y);
        const start = layers.find((el) => el !== band && !inFixedLayer(el)) || document.body;
        for (let el = start; el && el !== html; el = el.parentElement) {
            const bg = opaque(el);
            if (bg && isGround(el)) return bg;
        }
        return getComputedStyle(document.body).backgroundColor;
    }

    let queued = false;
    function sample() {
        queued = false;
        const bandH = band.getBoundingClientRect().height;
        if (!bandH) return;
        const y = Math.max(0, window.innerHeight - bandH - 1);
        const ground = groundAt(Math.round(window.innerWidth / 2), y);
        band.style.setProperty('--foot-ground', ground);
        if (tint) tint.content = ground;
    }
    function look() {
        if (queued) return;
        queued = true;
        requestAnimationFrame(sample);
    }

    window.addEventListener('scroll', look, { passive: true });
    window.addEventListener('resize', look);
    window.addEventListener('reveal:check', look);
    document.addEventListener('visibilitychange', look);
    document.addEventListener('transitionend', look); // a note sliding in or out, a theme fade
    look();
    setTimeout(look, 600); // after the page-load entrances have settled
}
