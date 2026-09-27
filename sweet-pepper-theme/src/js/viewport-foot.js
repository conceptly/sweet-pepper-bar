/**
 * Viewport foot — a ground under Safari's floating bar (prototype, 27 Sep 2026).
 *
 * Safari 26 on the iPhone runs the page under its glass tab bar: whatever sits at the fold
 * shows through the bar (the author's screenshots — a map card, the Lime notice, the next
 * section's headline). Chrome for iOS ends the page above its own bar instead. A page cannot
 * reach the browser chrome, but it can own the strip beneath it: a fixed band at the foot of
 * the viewport, in the ground of the section that is passing under it.
 *
 * Behind URL switches until the author has judged it on the phone (the house way — the rail
 * tremble, the language switch, the cookie notice):
 *   ?foot=solid   the band in the section's ground — the page appears to end above the bar
 *   ?foot=glass   the same ground at 70% over a blur — the bar's own glass, one tone darker
 *   &h=<px>       the band's height, when the browser reports no bottom safe area
 *                 (without it: env(safe-area-inset-bottom), which is what Safari says)
 *   &cover=1      adds viewport-fit=cover to the viewport meta — on iOS the safe-area insets
 *                 are only reported with it; the switch tests whether Safari 26 then names
 *                 the bar's height
 *   &tint=1       also keeps <meta name="theme-color"> at the sampled ground (Safari tints
 *                 its chrome from it on some versions)
 *
 * The ground is sampled, not typed: on every scroll the element at the band's top edge is
 * asked for the first opaque background up its ancestor chain (the section's, under a photo
 * or a headline alike), so the band follows the page's alternating grounds and the day /
 * night theme without a table. Nothing runs without the switch.
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

    // The first opaque background up from the element at the band's top edge
    function groundAt(x, y) {
        let el = document.elementFromPoint(x, y);
        while (el && el !== html) {
            const bg = getComputedStyle(el).backgroundColor;
            const m = bg.match(/rgba?\(([^)]+)\)/);
            if (m) {
                const parts = m[1].split(',').map(parseFloat);
                if (parts.length < 4 || parts[3] > 0.9) return bg;
            }
            el = el.parentElement;
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
    look();
    setTimeout(look, 600); // after the page-load entrances have settled
}
