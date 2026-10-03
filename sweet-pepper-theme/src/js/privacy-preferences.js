import { analyticsChoice, setAnalyticsPermission } from './analytics';
import { mapChoice, setMapPermission } from './map-permission';

export function privacyChoiceComplete() {
    return analyticsChoice() !== null && mapChoice() !== null;
}

export function initPrivacyPreferences() {
    const dialog = document.getElementById('privacy-preferences');
    if (!dialog) return;
    const analytics = dialog.querySelector('[name="analytics"]');
    const maps = dialog.querySelector('[name="maps"]');
    let opener;
    let byPointer = false; // opened with a tap or click (event.detail > 0), not the keyboard
    function save(allowAnalytics, allowMaps) {
        // Maps first: analytics may reload after a previous recorder was destroyed.
        setMapPermission(allowMaps);
        setAnalyticsPermission(allowAnalytics);
    }
    document.querySelectorAll('[data-privacy-settings]').forEach(button => {
        button.hidden = false;
        button.addEventListener('click', event => {
            opener = button;
            byPointer = event.detail > 0;
            analytics.checked = analyticsChoice()?.allowed === true;
            maps.checked = mapChoice()?.allowed === true;
            dialog.showModal(); // focus lands on the first switch (the × is last in the markup)
            // Opened by a click, the dialog itself takes focus: Chrome rings an auto-focused switch
            // even after a mouse click (author, 3 Oct 2026). From the keyboard the ring stays; Tab
            // from the dialog reaches the first switch either way.
            if (event.detail > 0) dialog.focus({ preventScroll: true });
            document.body.style.overflow = 'hidden'; // the page holds still behind it, as under the reserve drawer
        });
    });
    document.querySelectorAll('[data-privacy-choice]').forEach(button => {
        button.addEventListener('click', () => {
            const allowed = button.dataset.privacyChoice === 'allow';
            save(allowed, allowed);
        });
    });
    dialog.querySelector('[data-privacy-form]').addEventListener('submit', event => {
        event.preventDefault();
        if (opener?.closest('.cookie-notice')) {
            opener = document.querySelector('.footer-legal [data-privacy-settings]');
        }
        dialog.close('saved');
        // Before the save, so the notice can tell this save from one in another tab (cookie-notice.js)
        window.dispatchEvent(new CustomEvent('sp:privacy-saving', { detail: { analytics: analytics.checked, maps: maps.checked } }));
        save(analytics.checked, maps.checked);
    });
    dialog.querySelector('[data-privacy-close]').addEventListener('click', () => dialog.close());

    // The sheet (default; `?sheet=0` turns it off): mark the dialog while its body has more text below the visible part
    if (dialog.classList.contains('privacy-preferences--sheet')) {
        const body = dialog.querySelector('.privacy-preferences__body');
        const more = () => dialog.classList.toggle('has-more', body.scrollTop + body.clientHeight < body.scrollHeight - 2);
        body.addEventListener('scroll', more, { passive: true });
        window.addEventListener('resize', more);
        dialog.querySelector('details')?.addEventListener('toggle', more);
        new MutationObserver(more).observe(dialog, { attributes: true, attributeFilter: ['open'] });
    }
    dialog.addEventListener('close', () => {
        document.body.style.overflow = '';
        if (opener && !opener.closest('[hidden]')) {
            // Focus goes back to the opener (keyboard users continue from there), but after a tap or
            // click Safari — and Chrome after Escape — ring it as if by keyboard (author, 3 Oct 2026):
            // the ring stays off until focus moves on
            if (byPointer) {
                opener.classList.add('is-quiet-focus');
                opener.addEventListener('blur', () => opener.classList.remove('is-quiet-focus'), { once: true });
            }
            opener.focus({ preventScroll: true });
        }
    });
}
