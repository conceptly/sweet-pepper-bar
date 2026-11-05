/**
 * Mobile navigation drawer (template-parts/components/mobile-drawer.php).
 * One button opens and closes it: .js-drawer-toggle, the header's hamburger, which the
 * header keeps on screen over the open sheet (header.css → Menu toggle) — its bars cross
 * into the × off `aria-expanded`, and its name swaps between the two labels it carries.
 * Also closed by Escape or the viewport growing past the nav breakpoint. While open the
 * body scroll is locked, everything but the header and the sheet is inert, and Tab runs
 * round the header's links and the sheet's; focus stays on the button throughout.
 *
 * Trial switch (1 Oct 2026): the sheet and the bars run on the site's Gentle; `?drawer=quick`
 * brings back the first build's 200ms for the visit (sessionStorage), `?drawer=gentle` clears
 * it. Remove with the decision (mobile-drawer.css → html.drawer-quick).
 */
const NAV_BREAKPOINT = '(min-width: 992px)';
const FOCUSABLE = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';
const TRIAL_KEY = 'spDrawerTrial';

function drawerTrial() {
    let asked = new URLSearchParams(window.location.search).get('drawer');
    try {
        if (asked === 'gentle' || asked === 'off') sessionStorage.removeItem(TRIAL_KEY);
        else if (asked === 'quick') sessionStorage.setItem(TRIAL_KEY, asked);
        else asked = sessionStorage.getItem(TRIAL_KEY);
    } catch (e) { /* private mode: the address alone decides */ }
    document.documentElement.classList.toggle('drawer-quick', asked === 'quick');
}

export function initMobileDrawer() {
    const drawer = document.getElementById('mobile-drawer');
    const toggle = document.querySelector('.js-drawer-toggle');
    if (!drawer || !toggle) return;
    drawerTrial();

    const header = toggle.closest('.site-header');
    let inerted = [];

    function focusables() {
        return [...(header ? header.querySelectorAll(FOCUSABLE) : [toggle]), ...drawer.querySelectorAll(FOCUSABLE)]
            .filter((el) => el.offsetParent !== null);
    }

    // The sheet is not a dialog (its close control is in the header), so the page behind it
    // is taken out of reach by hand: every sibling of the header and the sheet, up to <body>.
    function setPageInert(on) {
        if (!on) {
            inerted.forEach((el) => el.removeAttribute('inert'));
            inerted = [];
            return;
        }
        const keep = [header, drawer];
        const page = drawer.parentElement;
        const around = [...(page ? page.children : []), ...(page && page !== document.body ? document.body.children : [])];
        inerted = around.filter((el) => el !== page && !keep.includes(el) && el.id !== 'wpadminbar'
            && !['SCRIPT', 'STYLE', 'LINK'].includes(el.tagName) && !el.hasAttribute('inert'));
        inerted.forEach((el) => el.setAttribute('inert', ''));
    }

    function setState(open) {
        drawer.classList.toggle('is-open', open);
        drawer.toggleAttribute('inert', !open);
        drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.documentElement.classList.toggle('drawer-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', (open ? toggle.dataset.labelClose : toggle.dataset.labelOpen) || toggle.getAttribute('aria-label'));
        document.body.style.overflow = open ? 'hidden' : '';
        setPageInert(open);
    }

    function open() {
        if (drawer.classList.contains('is-open')) return;
        drawer.scrollTop = 0;
        setState(true);
        document.addEventListener('keydown', onKeydown);
    }

    function close() {
        if (!drawer.classList.contains('is-open')) return;
        const within = drawer.contains(document.activeElement);
        setState(false);
        document.removeEventListener('keydown', onKeydown);
        if (within) toggle.focus();
    }

    function onKeydown(e) {
        if (e.key === 'Escape') {
            e.preventDefault();
            close();
            toggle.focus();
            return;
        }
        if (e.key !== 'Tab') return;
        const items = focusables();
        if (!items.length) return;
        const first = items[0];
        const last = items[items.length - 1];
        if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    }

    toggle.addEventListener('click', () => (drawer.classList.contains('is-open') ? close() : open()));

    // Desktop nav takes over past the breakpoint — never leave the sheet open under it.
    const mq = window.matchMedia(NAV_BREAKPOINT);
    mq.addEventListener('change', (e) => { if (e.matches) close(); });
}
