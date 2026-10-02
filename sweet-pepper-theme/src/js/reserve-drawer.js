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
    },
    busy: {
        subtitle: 'Full house tonight \u2014 writing beats calling.',
        statusText: 'Might take a minute, it\u2019s loud in here.',
    },
    closed: {
        // {opens} — the next opening, from Bar Settings (applyBarState fills it in)
        subtitle: 'Closed for the night. Send a message, we\u2019ll respond from {opens}!',
        statusText: 'We\u2019ll pick up from {opens}.',
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
    // ?barstate=available|busy|closed — shows a booking block's other layouts without waiting
    // for Friday night or 2 a.m. (a testing switch; the page is unchanged without it)
    const forced = new URLSearchParams(location.search).get('barstate');
    if (forced && BAR_STATES[forced]) return forced;

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

// A mouse can't dial: there the drawer's phone link copies the number, a finger dials it
// (the same <a href="tel:">; reserve-drawer.css shows the copy glyph only under a fine pointer)
const finePointer = window.matchMedia('(hover: hover) and (pointer: fine)');

function initCopyButtons() {
    document.querySelectorAll('.js-copy').forEach(btn => {
        btn.addEventListener('click', (e) => {
            if (btn.matches('a[href^="tel:"]') && !finePointer.matches) return;
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

    // Every booking block — the reserve drawer, the nav drawer, home Contacts and the Visit
    // CTA on phones (2 Oct 2026). The Chili button is "the best way to reach us right now":
    // the phone while the bar is open (busy included — the status line warns), the VK
    // message while it is closed, the phone stepping down to a secondary. The layout swap
    // is CSS (reserve-drawer.css → Booking blocks); the roles swap here. A button's
    // secondary classes are its data-secondary (default `btn-secondary`).
    const closed = state === 'closed';
    document.querySelectorAll('.booking-block').forEach((block) => {
        block.dataset.barState = state;
        block.querySelectorAll('.btn-call').forEach((btn) => setRole(btn, !closed));
        block.querySelectorAll('.js-booking-lead').forEach((btn) => setRole(btn, closed));
    });

    // Every phone line's status (icon + words)
    document.querySelectorAll('.phone-cta-wrapper').forEach((wrapper) => {
        wrapper.dataset.barState = state;

        // The status icon needs no work: all three ship in the markup and CSS shows the one
        // this wrapper's data-bar-state names (reserve-drawer.css → Bar-state icons).

        const statusText = wrapper.querySelector('.call-status-text');
        if (statusText) statusText.textContent = fill(cfg.statusText);
    });

    // The messenger line under VK / Instagram: the reply time while the bar is open (busy
    // included), the next opening while it is closed
    const reply = { open: 'Usually answer in 20 minutes', closed: 'We’ll reply from {opens}.', ...WORDS.reply };
    document.querySelectorAll('.contacts-reserve__status').forEach((line) => {
        line.dataset.barState = closed ? 'closed' : 'available';
        const text = line.querySelector('.call-status-text');
        if (text) text.textContent = fill(closed ? reply.closed : reply.open);
    });
}

/**
 * The fixed Reserve tab on the home page (.btn-fixed-wrapper--after-hero, set by
 * reserve-drawer.php): shown only while the hero's Reserve button is out of view, so one
 * Chili Reserve is on screen at a time. A hero too tall for a short laptop puts its button
 * below the fold, and then the tab shows from the start — there is no other Reserve in view.
 */
function initFixedTab() {
    const tab = document.querySelector('.btn-fixed-wrapper--after-hero');
    const heroBtn = document.querySelector('.hero-ctas .js-reserve-trigger');
    if (!tab) return;
    if (!heroBtn || !('IntersectionObserver' in window)) {
        tab.classList.add('is-shown');
        return;
    }
    new IntersectionObserver(([entry]) => {
        tab.classList.toggle('is-shown', !entry.isIntersecting);
    }).observe(heroBtn);
}

/** Chili primary, or the button's own secondary */
function setRole(btn, primary) {
    const secondary = (btn.dataset.secondary || 'btn-secondary').split(' ');
    btn.classList.toggle('btn-primary', primary);
    secondary.forEach((c) => btn.classList.toggle(c, !primary));
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

    // The fixed tab on the home page
    initFixedTab();

    // Bar state
    applyBarState();
}
