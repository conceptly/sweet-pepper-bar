/**
 * Contact Form — Email ↔ Phone toggle, validation, char counter, clipboard, success state.
 *
 * Manages [data-form-state] on #contact-form:
 *   "email"   → default, email field visible
 *   "phone"   → phone field visible
 *   "success" → confirmation view
 */

export function initContactForm() {
    const root = document.getElementById('contact-form');
    if (!root) return;

    const form        = document.getElementById('contact-form-el');
    const textarea    = root.querySelector('#contact-message');
    const charCount   = root.querySelector('.js-char-count');
    const togglePills = root.querySelectorAll('.contact-toggle__pill');
    const emailField  = root.querySelector('[data-contact-type="email"]');
    const phoneField  = root.querySelector('[data-contact-type="phone"]');
    const resetBtn    = root.querySelector('.js-form-reset');

    // ── Topic chips (Visit page on phones) — one active, mirrored into the hidden field
    //    that becomes the email subject for triage (visit-page-copy.md → Strategy) ──
    const topicChips  = root.querySelectorAll('.contact-form__topic');
    const topicInput  = root.querySelector('.js-topic-input');
    topicChips.forEach((chip) => {
        chip.addEventListener('click', () => {
            topicChips.forEach((c) => {
                const on = c === chip;
                c.classList.toggle('is-active', on);
                c.setAttribute('aria-pressed', on ? 'true' : 'false');
            });
            if (topicInput) topicInput.value = chip.dataset.topic || '';
        });
    });

    // ── Email / Phone Toggle ────────────────────
    togglePills.forEach(pill => {
        pill.addEventListener('click', () => {
            const target = pill.dataset.toggle; // "email" or "phone"
            root.dataset.formState = target;

            // Swap active pill
            togglePills.forEach(p => p.classList.remove('contact-toggle__pill--active'));
            pill.classList.add('contact-toggle__pill--active');

            // Show/hide fields
            if (target === 'email') {
                emailField.hidden = false;
                phoneField.hidden = true;
                phoneField.querySelector('input').value = '';
            } else {
                phoneField.hidden = false;
                emailField.hidden = true;
                emailField.querySelector('input').value = '';
            }

            // Clear any error states on the swapped field
            clearFieldError(emailField);
            clearFieldError(phoneField);
        });
    });

    // ── Character Counter ────────────────────────
    if (textarea && charCount) {
        textarea.addEventListener('input', () => {
            const len = textarea.value.length;
            charCount.textContent = len;
        });
    }

    // ── Form Submission & Validation ─────────────
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            // Clear previous errors
            root.querySelectorAll('.contact-field--error').forEach(f => {
                f.classList.remove('contact-field--error');
            });

            let valid = true;
            const currentMode = root.dataset.formState || 'email';

            // Validate name
            const nameInput = root.querySelector('#contact-name');
            if (!nameInput.value.trim()) {
                setFieldError(nameInput.closest('.contact-field'));
                valid = false;
            }

            // Validate email or phone
            if (currentMode === 'email') {
                const emailInput = root.querySelector('#contact-email');
                if (!emailInput.value.trim() || !isValidEmail(emailInput.value)) {
                    setFieldError(emailInput.closest('.contact-field'));
                    valid = false;
                }
            } else {
                const phoneInput = root.querySelector('#contact-phone');
                if (!phoneInput.value.trim()) {
                    setFieldError(phoneInput.closest('.contact-field'));
                    valid = false;
                }
            }

            // Validate message
            const messageInput = root.querySelector('#contact-message');
            if (!messageInput.value.trim()) {
                setFieldError(messageInput.closest('.contact-field'));
                valid = false;
            }

            if (valid) {
                // Transition to success state
                root.dataset.formState = 'success';
            }
        });
    }

    // ── "Send another message" Reset ─────────────
    if (resetBtn) {
        resetBtn.addEventListener('click', () => {
            // Reset form values
            if (form) form.reset();

            // Reset char counter
            if (charCount) charCount.textContent = '0';

            // Reset to email mode
            root.dataset.formState = 'email';
            togglePills.forEach(p => p.classList.remove('contact-toggle__pill--active'));
            const emailPill = root.querySelector('[data-toggle="email"]');
            if (emailPill) emailPill.classList.add('contact-toggle__pill--active');
            if (emailField) emailField.hidden = false;
            if (phoneField) phoneField.hidden = true;

            // Clear errors
            root.querySelectorAll('.contact-field--error').forEach(f => {
                f.classList.remove('contact-field--error');
            });
        });
    }

    // ── Copy Buttons (address bar chips) ──────────
    initCopyButtons();

    // ── Contact-item copy interaction ──────────────
    initContactItemCopy();
}

// ── Helpers ──────────────────────────────────────

function setFieldError(fieldEl) {
    if (fieldEl) fieldEl.classList.add('contact-field--error');
}

function clearFieldError(fieldEl) {
    if (fieldEl) {
        const field = fieldEl.querySelector('.contact-field') || fieldEl;
        field.classList.remove('contact-field--error');
    }
}

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

/**
 * Clipboard copy for the map address bar chips.
 */
function initCopyButtons() {
    document.querySelectorAll('.home-contacts .js-copy, .page-visit .js-copy').forEach(btn => {
        btn.addEventListener('click', async () => {
            const text = btn.dataset.copyText || btn.closest('[data-copy-text]')?.dataset.copyText;
            if (!text) return;
            await copyToClipboard(text);

            // Success state: "Copied!" in the label, the checkmark icon in place of the copy
            // icon (contacts.css → .contacts-chip.is-copied swaps the two .chip-icon spans).
            // Never rewrite the chip's HTML — that dropped the inline SVG and left a text ✓.
            // The confirmation names what was copied where the chip does
            // ("Address copied"), falling back to the generic word — home-copy-en.md
            // → Generic copy control, visit-page-copy-en.md → Copy feedback.
            const label = btn.querySelector('.chip-label');
            const originalLabel = label ? label.textContent : '';
            if (label) label.textContent = btn.dataset.copiedLabel || 'Copied';
            btn.classList.add('is-copied');
            btn.style.pointerEvents = 'none';

            setTimeout(() => {
                if (label) label.textContent = originalLabel;
                btn.classList.remove('is-copied');
                btn.style.pointerEvents = '';
            }, 2000);
        });
    });
}

/**
 * Contact-item component copy interaction.
 * Matches Figma: contactItem-day success state (1819-128718).
 *
 * States: Default → Hover (chip visible) → Click (Copied! + pepper icon) → Revert
 */
function initContactItemCopy() {
    document.querySelectorAll('.js-contact-copy').forEach(btn => {
        const item = btn.closest('.js-contact-item');
        const label = btn.querySelector('.contact-item__chip-label');
        if (!item || !label) return;

        btn.addEventListener('click', async () => {
            const text = btn.dataset.copyText;
            if (!text) return;
            await copyToClipboard(text);

            // Enter success state
            label.textContent = btn.dataset.copiedLabel || 'Copied';
            item.classList.add('is-copied');
            btn.style.pointerEvents = 'none';

            setTimeout(() => {
                label.textContent = 'Copy';
                item.classList.remove('is-copied');
                btn.style.pointerEvents = '';
            }, 2000);
        });
    });
}

/**
 * Clipboard helper with fallback.
 */
async function copyToClipboard(text) {
    try {
        await navigator.clipboard.writeText(text);
    } catch {
        const ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.left = '-9999px';
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        document.body.removeChild(ta);
    }
}
