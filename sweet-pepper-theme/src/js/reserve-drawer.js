/**
 * Reserve Drawer — open/close, copy-to-clipboard, bar state engine
 */

/* ── Bar state definitions ─────────────────────────────────── */
const BAR_STATES = {
    available: {
        subtitle: 'We\u2019re open \u2014 tonight, just walk in or write ahead.',
        statusText: 'All good \u2014 admin is on the phone',
        btnClass: 'btn-call--available',
    },
    busy: {
        subtitle: 'Full house tonight \u2014 writing beats calling.',
        statusText: 'Might take a minute, it\u2019s loud in here.',
        btnClass: 'btn-call--busy',
    },
    closed: {
        subtitle: 'Closed for the night. Send a message, we\u2019ll respond from 8:30!',
        statusText: 'We\u2019ll pick up from 8:30.',
        btnClass: 'btn-call--closed',
    },
};

/**
 * Determine the current bar state based on day/time.
 * Mon–Sat 08:30–02:00, Sunday 10:00–02:00
 * "Busy" on Fri/Sat after 22:00
 */
function getBarState() {
    const now = new Date();
    const day = now.getDay(); // 0=Sun … 6=Sat
    const h = now.getHours();
    const m = now.getMinutes();
    const mins = h * 60 + m; // minutes since midnight

    const openMon = 8 * 60 + 30;  // 08:30
    const openSun = 10 * 60;      // 10:00
    const close = 2 * 60;         // 02:00 (next day)
    const rushStart = 22 * 60;    // 22:00

    const isSunday = day === 0;
    const isFriSat = day === 5 || day === 6;
    const openTime = isSunday ? openSun : openMon;

    // Open window: openTime … 23:59 + 00:00 … 02:00
    const isOpen = mins >= openTime || mins < close;

    if (!isOpen) return 'closed';
    if (isFriSat && mins >= rushStart) return 'busy';
    return 'available';
}

/* ── Copy to clipboard ─────────────────────────────────────── */
function copyToClipboard(text) {
    if (navigator.clipboard && navigator.clipboard.writeText) {
        return navigator.clipboard.writeText(text);
    }
    // Fallback for older browsers
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.style.position = 'fixed';
    ta.style.left = '-9999px';
    document.body.appendChild(ta);
    ta.select();
    document.execCommand('copy');
    document.body.removeChild(ta);
    return Promise.resolve();
}

function initCopyButtons() {
    document.querySelectorAll('.js-copy').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();

            // Determine what to copy
            let textToCopy;
            const targetSel = btn.dataset.copyTarget;
            if (targetSel) {
                const el = document.querySelector(targetSel);
                textToCopy = el ? el.textContent.trim() : '';
            } else {
                textToCopy = btn.dataset.copyText || '';
            }
            if (!textToCopy) return;

            const label = btn.querySelector('.btn-copy-label');
            const callLabel = btn.querySelector('.btn-call-label');

            copyToClipboard(textToCopy).then(() => {
                // ── Visual feedback ──
                // Only the label changes here: both icons are inline library SVGs in the
                // markup and CSS swaps them on .is-copied (contacts.css → chip success
                // state). JS must never rewrite an icon — that is how the copy chips ended
                // up with a typeface tick in place of the glyph (Sep 2026).
                btn.classList.add('is-copied');

                if (label) {
                    label.textContent = 'Copied!';           // ticket "Copy" → "Copied!"
                } else if (callLabel) {
                    callLabel.textContent = 'Copied to your clipboard!';
                }

                // Reset after 2s
                setTimeout(() => {
                    btn.classList.remove('is-copied');
                    if (label) {
                        label.textContent = 'Copy';
                    } else if (callLabel) {
                        callLabel.textContent = '+7 (4852) 911-202';
                    }
                }, 2000);
            });
        });
    });
}

/* ── Bar state rendering ───────────────────────────────────── */
function applyBarState() {
    const state = getBarState();
    const cfg = BAR_STATES[state];
    if (!cfg) return;

    // Subtitle
    const subtitle = document.querySelector('.reserve-subtitle');
    if (subtitle) subtitle.textContent = cfg.subtitle;

    // Every phone CTA on the page (the drawer, and the home Contacts block on phones)
    document.querySelectorAll('.phone-cta-wrapper').forEach((wrapper) => {
        wrapper.dataset.barState = state;

        const btnCall = wrapper.querySelector('.btn-call');
        if (btnCall) {
            btnCall.classList.remove('btn-call--available', 'btn-call--busy', 'btn-call--closed');
            btnCall.classList.add(cfg.btnClass);
        }

        // The status icon needs no work: all three ship in the markup and CSS shows the one
        // this wrapper's data-bar-state names (reserve-drawer.css → Bar-state icons).

        const statusText = wrapper.querySelector('.call-status-text');
        if (statusText) statusText.textContent = cfg.statusText;
    });
}

/* ── Init ──────────────────────────────────────────────────── */
/**
 * Open: .js-reserve-trigger (hero button, Visit CTA, the desktop edge tab).
 * Close: .js-reserve-close (× and the scrim) or Escape. The panel is a dialog:
 * inert + aria-hidden while shut, focus moves to the × on open and returns to
 * the opener on close, body scroll is locked. Slide-in is CSS on `.is-open`
 * (right edge on desktop, bottom sheet on phones — reserve-drawer.css).
 */
export function initReserveDrawer() {
    const triggers = document.querySelectorAll('.js-reserve-trigger');
    const drawer = document.getElementById('reserve-drawer');
    const overlay = document.querySelector('.reserve-drawer-overlay');
    const closeBtns = document.querySelectorAll('.js-reserve-close');
    const closeBtn = drawer ? drawer.querySelector('.reserve-drawer-close') : null;
    let lastFocused = null;

    if (!drawer) return;

    function focusables() {
        return Array.from(drawer.querySelectorAll('a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])'))
            .filter((el) => el.offsetParent !== null);
    }

    function open() {
        if (drawer.classList.contains('is-open')) return;
        lastFocused = document.activeElement;
        drawer.removeAttribute('inert');
        drawer.setAttribute('aria-hidden', 'false');
        drawer.classList.add('is-open');
        if (overlay) overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        document.addEventListener('keydown', onKeydown);
        if (closeBtn) closeBtn.focus({ preventScroll: true });
    }

    function close() {
        if (!drawer.classList.contains('is-open')) return;
        drawer.classList.remove('is-open');
        if (overlay) overlay.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        drawer.setAttribute('inert', '');
        document.body.style.overflow = '';
        document.removeEventListener('keydown', onKeydown);
        if (lastFocused && typeof lastFocused.focus === 'function' && lastFocused !== document.body) {
            lastFocused.focus({ preventScroll: true });
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

    // Open
    triggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            open();
        });
    });

    // Close
    closeBtns.forEach(btn => btn.addEventListener('click', close));

    // Copy buttons
    initCopyButtons();

    // Bar state
    applyBarState();
}
