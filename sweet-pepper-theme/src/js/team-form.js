/**
 * Dream Team — "Write to the Team" form modal
 *
 * Open/close: .js-team-form-trigger → .is-open on overlay + dialog.
 * Name chips: toggle active state ("All" toggles all individual chips).
 * Validation: mirrors contact-form.js (name required, email regex, message required).
 * Counter: textarea character count.
 * Submit: client-side only → success state.
 * Reset: "Send another message" → compose state.
 *
 * @module team-form
 */

export function initTeamForm() {
    const overlay  = document.querySelector('.team-form-overlay');
    const dialog   = document.getElementById('team-form-dialog');
    const triggers = document.querySelectorAll('.js-team-form-trigger');
    const closeBtns = document.querySelectorAll('.js-team-form-close');

    if (!dialog || !overlay) return;

    const form       = document.getElementById('team-form-el');
    const nameInput  = document.getElementById('team-name');
    const emailInput = document.getElementById('team-email');
    const msgInput   = document.getElementById('team-message');
    const charCount  = dialog.querySelector('.js-team-char-count');
    const chips      = dialog.querySelectorAll('.team-form__chip');
    const allChip    = dialog.querySelector('.team-form__chip[data-recipient="all"]');
    const resetBtn   = dialog.querySelector('.js-team-form-reset');

    // ── Open / close ──────────────────────────────────────────────────────

    function open() {
        overlay.classList.add('is-open');
        dialog.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        // Focus first input after transition
        setTimeout(() => nameInput && nameInput.focus(), 350);
    }

    function close() {
        overlay.classList.remove('is-open');
        dialog.classList.remove('is-open');
        document.body.style.overflow = '';
    }

    triggers.forEach(t => t.addEventListener('click', (e) => {
        e.preventDefault();
        open();
    }));

    closeBtns.forEach(b => b.addEventListener('click', close));

    // Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && dialog.classList.contains('is-open')) {
            close();
        }
    });

    // ── Name chips ────────────────────────────────────────────────────────

    const individualChips = [...chips].filter(c => c.dataset.recipient !== 'all');

    function updateAllChipState() {
        const allActive = individualChips.every(c => c.classList.contains('is-active'));
        allChip.classList.toggle('is-active', allActive);
    }

    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            if (chip === allChip) {
                // "All" → toggle all individuals to match
                const shouldActivate = !allChip.classList.contains('is-active');
                if (shouldActivate) {
                    allChip.classList.add('is-active');
                    individualChips.forEach(c => c.classList.add('is-active'));
                } else {
                    // Don't deselect all — keep at least "All" active
                    // (clicking × on "All" when it's the only one selected does nothing)
                    const anyIndividualActive = individualChips.some(c => c.classList.contains('is-active'));
                    if (anyIndividualActive) {
                        allChip.classList.remove('is-active');
                        individualChips.forEach(c => c.classList.remove('is-active'));
                        // Reactivate "All" since we can't have none
                        allChip.classList.add('is-active');
                        individualChips.forEach(c => c.classList.add('is-active'));
                    }
                }
            } else {
                // Individual chip toggle
                chip.classList.toggle('is-active');
                // Ensure at least one is active
                const anyActive = [...chips].some(c => c.classList.contains('is-active'));
                if (!anyActive) {
                    allChip.classList.add('is-active');
                    individualChips.forEach(c => c.classList.add('is-active'));
                } else {
                    updateAllChipState();
                }
            }
        });
    });

    // ── Textarea counter ──────────────────────────────────────────────────

    if (msgInput && charCount) {
        msgInput.addEventListener('input', () => {
            charCount.textContent = msgInput.value.length;
        });
    }

    // ── Validation + submit ───────────────────────────────────────────────

    const EMAIL_RE = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function setFieldError(field) {
        field.classList.add('contact-field--error');
    }

    function clearAllErrors() {
        dialog.querySelectorAll('.contact-field').forEach(f =>
            f.classList.remove('contact-field--error')
        );
    }

    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            clearAllErrors();

            let valid = true;

            // Name
            if (!nameInput.value.trim()) {
                setFieldError(nameInput.closest('.contact-field'));
                valid = false;
            }

            // Email
            if (!emailInput.value.trim() || !EMAIL_RE.test(emailInput.value)) {
                setFieldError(emailInput.closest('.contact-field'));
                valid = false;
            }

            // Message
            if (!msgInput.value.trim()) {
                setFieldError(msgInput.closest('.contact-field'));
                valid = false;
            }

            if (valid) {
                dialog.dataset.formState = 'success';
            }
        });
    }

    // ── Reset ("Send another message") ────────────────────────────────────

    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            if (form) form.reset();
            if (charCount) charCount.textContent = '0';
            clearAllErrors();

            // Reset chips to "All" active
            allChip.classList.add('is-active');
            individualChips.forEach(c => c.classList.remove('is-active'));

            dialog.dataset.formState = 'compose';
        });
    }
}
