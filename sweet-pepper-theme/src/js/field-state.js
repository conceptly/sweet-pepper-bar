/**
 * Live field state for `.contact-field` inputs — shared by contact-form.js and team-form.js.
 *
 * Figma field-singleLine (265:3459 night / 466:19366 day): a value that passes shows the
 * trailing checkmark and keeps the accent icon (state=focused-text → filled-passed); an error
 * clears the moment the value passes. contacts.css draws both from the classes set here:
 *   `.is-valid`             — the value passes the field's validator (name: a letter; email; phone ≥ 6 digits;
 *                             message: not blank)
 *   `.contact-field--error` — set here when the visitor leaves a field they typed in and it fails
 *                             (blur), and by the form's submit handler for every field; removed here
 *                             the moment the value passes
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

/**
 * A name has at least one letter, in any alphabet — rejects "123" or "---", never a real name.
 * No minimum length: Ян, Ли, Al and an initial are all names (9 Nov 2026).
 */
export function isValidName(value) {
    return /\p{L}/u.test(value);
}

function validatorFor(input) {
    if (input.type === 'email') return isValidEmail;
    if (input.type === 'tel') return isValidPhone;
    if (input.name === 'name') return isValidName;
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

        // Typed in at least once. A field the visitor only tabs or clicks through stays quiet
        // until Submit — "reward early, punish late" (9 Nov 2026).
        let touched = false;

        const update = () => {
            const ok = passes(input.value);
            field.classList.toggle('is-valid', ok);
            if (ok) field.classList.remove('contact-field--error');
        };

        const touch = () => { touched = true; update(); };
        input.addEventListener('input', touch);
        input.addEventListener('change', touch); // Safari's AutoFill Contact fires change, not always input

        // Leaving a touched field judges it: the error shows now, not at Submit. While typing,
        // an error only ever clears (update above) — it never appears mid-word.
        input.addEventListener('blur', () => {
            if (!touched || field.closest('[hidden]')) return;
            if (!document.hasFocus()) return; // switching windows or apps is not leaving the field
            field.classList.toggle('contact-field--error', !passes(input.value));
        });

        updates.push(() => {
            if (input.value === '') touched = false; // reset, or the email ↔ phone swap emptied it
            update();
        });
        if (input.value !== '') touched = true; // a value the browser restored or filled before the script ran
        update();
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

/**
 * After a submit that failed validation: move focus to the first field showing an error, so a
 * keyboard or screen-reader visitor lands on what to fix (the Submit button stays enabled).
 */
export function focusFirstError(root) {
    const first = root.querySelector('.contact-field--error');
    const target = first?.querySelector('.contact-field__input, .contact-consent__input');
    if (target) target.focus();
}
