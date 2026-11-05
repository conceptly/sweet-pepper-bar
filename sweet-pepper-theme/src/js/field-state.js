/**
 * Live field state for `.contact-field` inputs — shared by contact-form.js and team-form.js.
 *
 * Figma field-singleLine (265:3459 night / 466:19366 day): a value that passes shows the
 * trailing checkmark and keeps the accent icon (state=focused-text → filled-passed); an error
 * clears the moment the value passes. contacts.css draws both from the classes set here:
 *   `.is-valid`             — the value passes the field's validator
 *   `.contact-field--error` — set by the form's submit handler, removed here once the value passes
 *
 * The validators are exported so the submit handlers judge a field exactly as the checkmark does.
 *
 * @module field-state
 */

const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

export function isValidEmail(value) {
    return EMAIL_RE.test(value.trim());
}

/** Six digits is the shortest number the bar could call back (a local Yaroslavl line). */
export function isValidPhone(value) {
    return (value.match(/\d/g) || []).length >= 6;
}

export function isFilled(value) {
    return value.trim() !== '';
}

function validatorFor(input) {
    if (input.type === 'email') return isValidEmail;
    if (input.type === 'tel') return isValidPhone;
    return isFilled;
}

/**
 * Watch every `.contact-field` under `root`.
 * Returns a `refresh()` for the moments a script changes a value without an event
 * (the email ↔ phone swap, form.reset()).
 */
export function watchFieldState(root) {
    const updates = [];

    root.querySelectorAll('.contact-field').forEach((field) => {
        const input = field.querySelector('.contact-field__input');
        if (!input) return;
        const passes = validatorFor(input);

        const update = () => {
            const ok = passes(input.value);
            field.classList.toggle('is-valid', ok);
            if (ok) field.classList.remove('contact-field--error');
        };

        input.addEventListener('input', update);
        input.addEventListener('change', update); // Safari's AutoFill Contact fires change, not always input
        updates.push(update);
        update(); // a value the browser restored or filled before the script ran
    });

    // The consent checkbox: its error clears once ticked (form-send.js → checkConsent)
    root.querySelectorAll('.contact-consent__input').forEach((box) => {
        box.addEventListener('change', () => {
            if (box.checked) box.closest('.contact-field').classList.remove('contact-field--error');
        });
    });

    const refresh = () => updates.forEach((u) => u());

    // form.reset() fires the event before the values clear
    const form = root.querySelector('form');
    if (form) form.addEventListener('reset', () => setTimeout(refresh, 0));

    return refresh;
}
