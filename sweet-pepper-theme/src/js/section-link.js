/**
 * Section link — fit the live-text connector to its container width.
 *
 * The Figma SectionLink sets Molot at 122px in a fixed 1100 box; on the site the word
 * spans the content container (website-brief.md → Section connectors → Width matching),
 * so each word gets the font size at which its measured width equals the container's.
 * Runs after fonts load and again on resize; the CSS size is the no-JS fallback.
 */

const PROBE = 100; // px — measure at a known size, scale linearly (tracking is em-based)

function fit(link) {
    const text = link.querySelector('.section-link__text');
    if (!text) return;
    const width = link.clientWidth;
    if (!width) return;
    text.style.setProperty('font-size', `${PROBE}px`);
    text.style.setProperty('width', 'max-content');
    const measured = text.getBoundingClientRect().width;
    text.style.removeProperty('font-size');
    text.style.removeProperty('width');
    if (!measured) return;
    const size = Math.floor((PROBE * width / measured) * 100) / 100;
    link.style.setProperty('--section-link-size', `${size}px`);
}

function fitAll() {
    document.querySelectorAll('.section-link').forEach(fit);
}

export function initSectionLinks() {
    const links = document.querySelectorAll('.section-link');
    if (!links.length) return;
    const run = () => fitAll();
    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(run);
    } else {
        run();
    }
    if ('ResizeObserver' in window) {
        const ro = new ResizeObserver(() => fitAll());
        links.forEach((l) => ro.observe(l));
    } else {
        window.addEventListener('resize', run);
    }
}
