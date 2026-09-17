/**
 * About Perks — Interactive rubber stamp strip
 *
 * Reads perk data from inline <script type="application/json">,
 * handles stamp selection and updates the detail area (title and description).
 */

export function initAboutPerks() {
    const perksSection = document.querySelector('.about-perks');
    if (!perksSection) return;

    const dataEl = perksSection.querySelector('.about-perks__data');
    if (!dataEl) return;

    let perksData;
    try {
        perksData = JSON.parse(dataEl.textContent);
    } catch (e) {
        console.error('[about-perks] Failed to parse perk data:', e);
        return;
    }

    const stamps  = perksSection.querySelectorAll('.about-perks__stamp');
    const titleEl = perksSection.querySelector('.about-perks__detail-title');
    const descEl  = perksSection.querySelector('.about-perks__detail-desc');

    stamps.forEach((stamp) => {
        stamp.addEventListener('click', () => {
            const perkId = stamp.dataset.perk;
            const data = perksData[perkId];
            if (!data) return;

            stamps.forEach((s) => {
                s.classList.remove('is-active');
                s.setAttribute('aria-selected', 'false');
            });

            stamp.classList.add('is-active');
            stamp.setAttribute('aria-selected', 'true');

            if (titleEl) titleEl.textContent = data.title;
            if (descEl) descEl.textContent = data.description;
        });
    });
}
