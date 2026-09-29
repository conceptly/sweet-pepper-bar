/**
 * Form delivery — shared by contact-form.js and team-form.js.
 *
 * Posts the form's fields as JSON to its data-endpoint (inc/forms.php → hello@sweetpepper.bar).
 * The submit button is disabled while the request runs; the delivery error (.form-send-error)
 * is hidden on each try and shown on failure, leaving the typed text for another try
 * (forms-copy-ru-draft.md §6).
 *
 * @module form-send
 */

/** Render time, sent as `t`: the server drops sends faster than a person could type. */
const renderedAt = Date.now();

/**
 * @param {HTMLFormElement} form
 * @param {object} extra       fields beyond the form's own inputs (form id, recipients)
 * @param {HTMLElement} submit the submit button
 * @param {HTMLElement} error  the .form-send-error paragraph
 * @returns {Promise<boolean>} true once the server confirms the message was sent
 */
export async function sendForm(form, extra, submit, error) {
    if (submit?.disabled) return false; // Enter pressed again while the first send runs
    const data = Object.fromEntries(new FormData(form));
    const payload = {
        ...data,
        ...extra,
        t: renderedAt,
        page: location.href,
        lang: document.documentElement.lang.startsWith('en') ? 'en' : 'ru',
    };

    if (error) error.hidden = true;
    if (submit) {
        submit.disabled = true;
        submit.setAttribute('aria-busy', 'true');
    }

    try {
        const res = await fetch(form.dataset.endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        });
        const json = await res.json().catch(() => ({}));
        if (res.ok && json.ok) return true;
        throw new Error(json.code || res.status);
    } catch {
        if (error) error.hidden = false;
        return false;
    } finally {
        if (submit) {
            submit.disabled = false;
            submit.removeAttribute('aria-busy');
        }
    }
}
