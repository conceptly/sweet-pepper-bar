/**
 * Reserve Drawer — open/close, copy-to-clipboard, bar state engine
 */

import { getBarStatus, formatBarTime } from './bar-clock.js';

/* ── Bar state definitions ─────────────────────────────────── */
/* The WORDS come from the page (25 Sep 2026): reserve-drawer.php prints them as JSON in the
   request's language (.reserve-drawer__strings); the typed English below is the fallback. */
const drawerEl = document.querySelector('.reserve-drawer__strings');
let WORDS = {};
if (drawerEl) {
    try { WORDS = JSON.parse(drawerEl.textContent) || {}; } catch (e) { console.warn('[reserve] Could not parse the drawer strings', e); }
}
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
        // {opens} — the next opening, from Bar Settings (applyBarState fills it in)
        subtitle: 'Closed for the night. Send a message, we\u2019ll respond from {opens}!',
        statusText: 'We\u2019ll pick up from {opens}.',
        btnClass: 'btn-call--closed',
    },
};
Object.keys(BAR_STATES).forEach((state) => {
    if (WORDS.states && WORDS.states[state]) Object.assign(BAR_STATES[state], WORDS.states[state]);
});
const COPY_WORDS = { copy: 'Copy', copied: 'Copied!', phoneCopied: 'Copied to your clipboard!', ...WORDS };

/**
 * The current bar state, on the bar's clock and the bar's hours (bar-clock.js — by default
 * Mon–Sat 08:30–02:00, Sunday 10:00–02:00).
 * "Busy" on Fri/Sat after 22:00
 */
function getBarState() {
    const { day, mins, open } = getBarStatus(); // day: 0=Sun … 6=Sat
    const rushStart = 22 * 60; // 22:00
    const isFriSat = day === 5 || day === 6;

    if (!open) return 'closed';
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
                    label.textContent = COPY_WORDS.copied;   // ticket "Copy" → "Copied!"
                } else if (callLabel) {
                    callLabel.textContent = COPY_WORDS.phoneCopied;
                }

                // Reset after 2s
                setTimeout(() => {
                    btn.classList.remove('is-copied');
                    if (label) {
                        label.textContent = COPY_WORDS.copy;
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
    const fill = (text) => text.replace('{opens}', formatBarTime(getBarStatus().opens));

    // Subtitle
    const subtitle = document.querySelector('.reserve-subtitle');
    if (subtitle) subtitle.textContent = fill(cfg.subtitle);

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
        if (statusText) statusText.textContent = fill(cfg.statusText);
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
