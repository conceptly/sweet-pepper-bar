/** The shared banner stays until both optional services have a saved choice. */
import { privacyChoiceComplete } from './privacy-preferences';

const DELAY = 2000; // ms after load — 12 s at first; 1–2 s read better on the author's test (27 Sep 2026)
// The confirmation after a choice in the band (author, 2 Oct 2026): long enough to catch what
// happened and see «Настроить», short enough not to sit on the page; hover holds it, a keyboard choice keeps it
// until Закрыть / Escape (WCAG 2.2.1). `?noticedone=0` closes the band at once, to compare.
const DONE_TIME = 4500; // 6000 at first; 6 s (~7 with the slide-out) felt long — the line confirms a choice just made (author, 3 Oct 2026)
// `?savedmsg=1` — PROTOTYPE (author, 3 Oct 2026): a save in the settings dialog is confirmed too,
// by the same band, with a sentence that says what was saved — also when the dialog was opened
// from the footer and the band had long gone. Without the flag a dialog save just closes the band.

export function initCookieNotice() {
    const note = document.querySelector('.cookie-notice');
    if (!note) return;

    const params = new URLSearchParams(location.search);
    const seen = privacyChoiceComplete();
    const savedMsg = params.get('savedmsg') === '1';
    if (seen && !params.has('again') && !savedMsg) return;

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
        if (privacyChoiceComplete() && !params.has('again')) return;
        place();
        note.hidden = false;
        note.offsetHeight; // commit the parked transform before the transition starts
        note.classList.add('is-shown');
        if (band && !bottom) window.addEventListener('scroll', place, { passive: true });
        window.addEventListener('resize', place);
    }

    let hideTimer;
    function dismiss() {
        clearTimeout(timer);
        const hadFocus = note.contains(document.activeElement);
        note.classList.remove('is-shown');
        if (hadFocus) document.activeElement.blur();
        const end = () => { note.hidden = true; note.classList.remove('is-done'); };
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) end();
        else hideTimer = setTimeout(end, 1100);
        window.removeEventListener('scroll', place);
        window.removeEventListener('resize', place);
    }

    // A choice made with the band's own buttons is confirmed in place; one saved in the dialog
    // (which already showed what was saved), in another tab or by expiry just closes the band.
    // Capture phase: this runs before privacy-preferences.js saves and sends the events.
    const confirm = params.get('noticedone') !== '0';
    const done = note.querySelector('.cookie-notice__done');
    let pending = null; // { choice, keyboard } while a band button's save is in flight
    let timer;
    let hovered = false;
    let engaged = false; // tabbed into the confirmation: it stays until closed
    let settling = false; // the second event of the press that was just confirmed
    note.addEventListener('click', event => {
        const button = event.target.closest('[data-privacy-choice]');
        if (button && confirm && done) pending = { choice: button.dataset.privacyChoice, keyboard: event.detail === 0 };
    }, true);

    // The confirmation's timer: held while hovered, stopped for good once the visitor tabs in. The
    // cursor that pressed the button rests on the band, so that doesn't count (author, 3 Oct 2026,
    // a touchpad: it never left) — only a pointer that comes back after the confirmation appeared.
    const run = () => { clearTimeout(timer); if (!hovered && !engaged) timer = setTimeout(dismiss, DONE_TIME); };
    note.addEventListener('pointerenter', () => { if (!note.classList.contains('is-done')) return; hovered = true; clearTimeout(timer); });
    note.addEventListener('pointerleave', () => { hovered = false; if (note.classList.contains('is-done')) run(); });
    note.addEventListener('focusin', () => { if (note.classList.contains('is-done')) { engaged = true; clearTimeout(timer); } });

    function showDone({ choice, keyboard }) {
        const status = done.querySelector('[role="status"]');
        engaged = false;
        hovered = false; // the pressing cursor is still there; it isn't a request to read
        note.classList.add('is-done');
        // A dialog save's sentence says where to change the choice; «Настроить» would repeat it
        note.classList.toggle('is-saved', choice.startsWith('saved'));
        if (!note.classList.contains('is-shown')) {
            // A footer save: the band rises again, straight into its confirmation
            clearTimeout(hideTimer);
            place();
            note.hidden = false;
            note.offsetHeight;
            note.classList.add('is-shown');
            window.addEventListener('resize', place);
        }
        // Into the live region after it is rendered, so screen readers announce it
        status.textContent = '';
        setTimeout(() => { status.textContent = status.dataset[choice]; }, 50);
        const close = done.querySelector('[data-notice-close]');
        if (keyboard) {
            close.focus({ preventScroll: true }); // the pressed button is gone; focus must not fall to the page
            return; // no timer: the keyboard user closes it
        }
        run();
    }

    if (savedMsg && done) {
        window.addEventListener('sp:privacy-saving', ({ detail }) => {
            const choice = detail.analytics && detail.maps ? 'savedBoth'
                : detail.maps ? 'savedMaps' : detail.analytics ? 'savedMetrica' : 'savedNone';
            pending = { choice, keyboard: false };
            if (note.classList.contains('is-shown') && !note.classList.contains('is-done')) return; // the band's own event path confirms
            // The band is down (a footer save) or already confirming: show it now; the save's
            // events that follow are this press's, not another tab's
            const p = pending;
            pending = null;
            settling = true;
            setTimeout(() => { settling = false; });
            engaged = false;
            showDone(p);
        });
    }

    done?.querySelector('[data-notice-close]').addEventListener('click', () => dismiss());
    note.addEventListener('keydown', event => {
        if (event.key === 'Escape' && note.classList.contains('is-done')) dismiss();
    });

    ['sp:analytics-permission', 'sp:map-permission'].forEach(event => {
        // Only a shown note leaves: pageshow re-sends these events, which would otherwise hide
        // the `&again` preview the moment it appears
        window.addEventListener(event, () => {
            if (!note.classList.contains('is-shown') || !privacyChoiceComplete()) return;
            if (pending) {
                // Both services send an event for one press; the first one that completes the choice confirms
                const p = pending;
                pending = null;
                settling = true;
                setTimeout(() => { settling = false; });
                showDone(p);
            } else if (!settling) {
                dismiss(); // the dialog (also from the confirmation's Настроить), another tab, expiry
            }
        });
    });

    const start = () => setTimeout(show, delay);
    if (document.readyState === 'complete') start();
    else window.addEventListener('load', start, { once: true });
}
