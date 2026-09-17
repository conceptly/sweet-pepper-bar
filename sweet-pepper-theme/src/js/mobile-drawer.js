/**
 * Mobile navigation drawer (template-parts/components/mobile-drawer.php).
 * Open: .js-drawer-open (header hamburger). Close: .js-drawer-close, Escape,
 * or the viewport growing past the nav breakpoint. Focus is trapped while
 * open, body scroll is locked, and focus returns to the opener on close.
 */
const NAV_BREAKPOINT = '(min-width: 992px)';

export function initMobileDrawer() {
    const drawer = document.getElementById('mobile-drawer');
    if (!drawer) return;

    const openers = document.querySelectorAll('.js-drawer-open');
    const closeBtn = drawer.querySelector('.js-drawer-close');
    let lastFocused = null;

    function focusables() {
        return Array.from(drawer.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'))
            .filter((el) => el.offsetParent !== null);
    }

    function setExpanded(state) {
        openers.forEach((btn) => btn.setAttribute('aria-expanded', state ? 'true' : 'false'));
    }

    function open() {
        if (drawer.classList.contains('is-open')) return;
        lastFocused = document.activeElement;
        drawer.removeAttribute('inert');
        drawer.setAttribute('aria-hidden', 'false');
        drawer.classList.add('is-open');
        setExpanded(true);
        document.body.style.overflow = 'hidden';
        document.addEventListener('keydown', onKeydown);
        if (closeBtn) closeBtn.focus();
    }

    function close() {
        if (!drawer.classList.contains('is-open')) return;
        drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        drawer.setAttribute('inert', '');
        setExpanded(false);
        document.body.style.overflow = '';
        document.removeEventListener('keydown', onKeydown);
        if (lastFocused && typeof lastFocused.focus === 'function' && lastFocused !== document.body) {
            lastFocused.focus();
        }
    }

    function onKeydown(e) {
        if (e.key === 'Escape') {
            e.preventDefault();
            close();
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

    openers.forEach((btn) => btn.addEventListener('click', open));
    if (closeBtn) closeBtn.addEventListener('click', close);

    // Desktop nav takes over past the breakpoint — never leave the sheet open under it.
    const mq = window.matchMedia(NAV_BREAKPOINT);
    mq.addEventListener('change', (e) => { if (e.matches) close(); });
}
