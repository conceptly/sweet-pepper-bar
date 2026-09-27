/**
 * Cookie notice — PROTOTYPE (`?notice=corner` | `?notice=band`; cookie-notice-plan.md).
 *
 * The note waits for the page to finish loading (window load — photos, the map iframes) and
 * then DELAY more, so the guest meets the page first and the note arrives as an aside
 * (author, 27 Sep 2026). Fixed at every width; it never pushes content. «Понятно» sets
 * localStorage `spNoticeSeen` (the rail's naming) — never a cookie, or the note's own words
 * would be false — and slides it out. `&delay=<s>` shortens the wait, `&again` re-shows a
 * dismissed note. Without this script the note stays `hidden`.
 *
 * `--cookie-top` is the header's bottom edge: the band hangs from the header and takes the
 * top of the viewport once the desktop header has scrolled away; the corner card keeps the
 * value it was shown with.
 */

const KEY = 'spNoticeSeen';
const DELAY = 2000; // ms after load — 12 s at first; 1–2 s read better on the author's test (27 Sep 2026)

export function initCookieNotice() {
    const note = document.querySelector('.cookie-notice');
    if (!note) return;

    const params = new URLSearchParams(location.search);
    let seen = false;
    try { seen = localStorage.getItem(KEY) === '1'; } catch (e) { /* private mode */ }
    if (seen && !params.has('again')) return;

    const header = document.querySelector('.site-header');
    const band = note.dataset.variant === 'band';
    const bottom = note.dataset.pos === 'bottom'; // `&pos=bottom`: no top to track
    const delay = params.has('delay') ? Number(params.get('delay')) * 1000 : DELAY;

    function place() {
        if (!header) return;
        // The band keeps 12px of air under the desktop header (77 touched the logo on a wide
        // screen — author, 27 Sep 2026); the air closes as the header scrolls off, then top: 0.
        const gap = band && window.innerWidth >= 992 ? 12 : 0;
        const edge = header.getBoundingClientRect().bottom + gap;
        note.style.setProperty('--cookie-top', `${Math.max(0, Math.round(edge))}px`);
    }

    function show() {
        place();
        note.hidden = false;
        note.offsetHeight; // commit the parked transform before the transition starts
        note.classList.add('is-shown');
        if (band && !bottom) window.addEventListener('scroll', place, { passive: true });
        window.addEventListener('resize', place);
    }

    function dismiss() {
        try { localStorage.setItem(KEY, '1'); } catch (e) { /* private mode */ }
        note.classList.remove('is-shown');
        const end = () => { note.hidden = true; };
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) end();
        else note.addEventListener('transitionend', end, { once: true });
        window.removeEventListener('scroll', place);
        window.removeEventListener('resize', place);
    }

    note.querySelector('.cookie-notice__ok').addEventListener('click', dismiss);

    const start = () => setTimeout(show, delay);
    if (document.readyState === 'complete') start();
    else window.addEventListener('load', start, { once: true });
}
