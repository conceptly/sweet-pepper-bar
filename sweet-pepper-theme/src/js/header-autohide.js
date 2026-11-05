/**
 * Phone header that steps aside on scroll (default since 20 Oct 2026).
 *
 * Phones and tablets (≤ 991px), where the header is fixed (header.css → Mobile header):
 * scrolling down slides it up out of view, scrolling up brings it back, on the house spring.
 * The author's usual pattern, picked on an iPhone from a `?hdr=` trial (the spring over a
 * quick 300ms slide); the switch is gone.
 *
 * The header stays shown at the top of the page (until it has scrolled its own height),
 * while the hamburger menu, the reserve sheet or the menu's jump panel is open, while focus
 * is inside it, and at the foot of the page (iOS bounces there and would read the rebound
 * as a scroll up). Small wobbles are ignored: a direction counts once it has run 8px.
 */
const RUN = 8; // px of travel in one direction before the header reacts

export function initHeaderAutohide() {
    const header = document.querySelector('.site-header');
    if (!header) return;

    // The trial's memory (sessionStorage 'spHeaderTrial', 20 Oct 2026) — nothing reads it now
    try { sessionStorage.removeItem('spHeaderTrial'); } catch (e) { /* private mode */ }

    const root = document.documentElement;
    root.classList.add('hdr-autohide');

    const phone = window.matchMedia('(max-width: 991px)');
    let lastY = window.scrollY;
    let run = 0;      // travel in the current direction (+ down, − up)
    let hidden = false;
    let ticking = false;

    const mustShow = () =>
        root.classList.contains('drawer-open') ||
        !!document.querySelector('.reserve-drawer.is-open, #menu-jump-panel.is-open') ||
        header.contains(document.activeElement);

    const set = (hide) => {
        if (hide === hidden) return;
        hidden = hide;
        header.classList.toggle('is-tucked', hide);
        root.classList.toggle('hdr-tucked', hide); // for anything that sits under the header
    };

    const update = () => {
        ticking = false;
        const y = window.scrollY;
        const delta = y - lastY;
        lastY = y;
        if (!phone.matches || mustShow() || y <= header.offsetHeight) {
            run = 0;
            set(false);
            return;
        }
        // The foot of the page: iOS rubber-banding reads as a scroll up — hold still
        if (y + window.innerHeight >= document.documentElement.scrollHeight - 2) return;
        if (delta === 0) return;
        run = Math.sign(delta) === Math.sign(run) ? run + delta : delta;
        if (run > RUN) set(true);
        else if (run < -RUN) set(false);
    };

    const onScroll = () => {
        if (!ticking) {
            ticking = true;
            requestAnimationFrame(update);
        }
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    phone.addEventListener('change', update);
    // Opening the drawer, the reserve sheet or tabbing into the header brings it back at once
    root.addEventListener('focusin', () => { if (hidden && mustShow()) set(false); });
    new MutationObserver(() => { if (hidden && mustShow()) set(false); })
        .observe(root, { attributes: true, attributeFilter: ['class'] });
}
