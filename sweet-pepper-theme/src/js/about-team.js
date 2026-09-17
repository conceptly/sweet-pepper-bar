/**
 * About — Dream Team card message toggle
 *
 * Clicking the chip button on a team card reveals the member's personal
 * message (active state). Clicking the back arrow returns to the default
 * state. Only one card can be active at a time.
 *
 * @module about-team
 */

export function initAboutTeam() {
    const section = document.querySelector('.about-team');
    if (!section) return;

    const cards = section.querySelectorAll('.about-team__card--has-message');

    // The class drives both layouts (about.css → Team; phones keep the default row
    // and reveal the active layer under it), so only the active layer's `hidden` moves.
    function closeAll() {
        cards.forEach(card => {
            card.classList.remove('is-active');
            const active = card.querySelector('.about-team__card-active');
            const chip = card.querySelector('.about-team__card-chip');
            if (active) active.hidden = true;
            if (chip) chip.setAttribute('aria-expanded', 'false');
        });
    }

    cards.forEach(card => {
        const chip = card.querySelector('.about-team__card-chip');
        const back = card.querySelector('.about-team__card-back');

        if (chip) {
            chip.setAttribute('aria-expanded', 'false');
            chip.addEventListener('click', () => {
                const wasActive = card.classList.contains('is-active');
                closeAll();
                if (!wasActive) {
                    card.classList.add('is-active');
                    const active = card.querySelector('.about-team__card-active');
                    if (active) active.hidden = false;
                    chip.setAttribute('aria-expanded', 'true');
                }
            });
        }

        if (back) {
            back.addEventListener('click', () => {
                closeAll();
            });
        }
    });
}
