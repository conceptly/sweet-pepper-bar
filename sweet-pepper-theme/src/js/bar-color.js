/**
 * Bar colour — <meta name="theme-color"> follows the theme (27 Sep 2026).
 *
 * inc/daypart-head.php prints the meta and sets it for the first paint; this keeps it in step
 * when the theme changes afterwards (the daypart engine flipping at an hour, ?theme= on a
 * later navigation, the bar menu page). Safari 26 on the iPhone fills its floating bar from
 * the document's ground once the page scrolls, and Chrome for Android colours its chrome from
 * this meta — so the browser's frame is Paper by day and Peppercorn by night, never a
 * section's colour caught at the fold (the sliver band of the earlier prototype, retired the
 * same day). The fixed dark pages carry data-bar="fixed" on the meta and are left alone;
 * ?bar=dark (html[data-bar="dark"]) holds Peppercorn whatever the theme.
 *
 * @module bar-color
 */

const NIGHT = '#151317'; // Peppercorn
const DAY   = '#FCF7E8'; // Paper

export function initBarColor() {
    const meta = document.querySelector('meta[name="theme-color"]');
    if (!meta || meta.dataset.bar === 'fixed') return;
    const html = document.documentElement;

    const sync = () => {
        meta.content = (html.dataset.theme === 'night' || html.dataset.bar === 'dark') ? NIGHT : DAY;
    };

    new MutationObserver(sync).observe(html, { attributes: true, attributeFilter: ['data-theme', 'data-bar'] });
    sync();
}
