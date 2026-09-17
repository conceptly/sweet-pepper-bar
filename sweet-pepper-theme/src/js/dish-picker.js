/**
 * Dish Picker — Interactive pairing component
 *
 * Reads pairings data from an inline <script type="application/json">,
 * handles tag selection, photo crossfade, and card content swap.
 *
 * Pattern follows menu-hero.js (inline JSON data, crossfade transitions).
 */

export function initDishPicker() {
    const pickers = document.querySelectorAll('.dish-picker');
    pickers.forEach(initSinglePicker);
}

function initSinglePicker(picker) {

    // ── Data ──────────────────────────────────────────
    const dataEl = picker.querySelector('.dish-picker__data');
    if (!dataEl) return;

    let pairings;
    try {
        pairings = JSON.parse(dataEl.textContent);
    } catch (e) {
        console.error('[dish-picker] Failed to parse pairing data:', e);
        return;
    }

    // ── DOM refs ──────────────────────────────────────
    const tags       = picker.querySelectorAll('.dish-picker__tag');
    const shakeBtn   = picker.querySelector('.dish-picker__shake-it');
    const foodImg    = picker.querySelector('.dish-picker__photo-food img');
    const barImg     = picker.querySelector('.dish-picker__photo-bar img');
    const dishName   = picker.querySelector('.dish-picker__dish-name');
    const dishDesc   = picker.querySelector('.dish-picker__dish-desc');
    const pairingName = picker.querySelector('.dish-picker__pairing-name');
    const ctaLink    = picker.querySelector('.dish-picker__cta');

    let currentIndex = parseInt(picker.dataset.defaultIndex, 10) || 0;
    let isTransitioning = false;

    // ── Crossfade helper ─────────────────────────────
    // Same pattern as menu-hero.js: fade out → swap at midpoint → fade in
    const FADE_DURATION = 350; // ms — total crossfade
    const FADE_MIDPOINT = FADE_DURATION / 2;

    /**
     * Phones: the tags are a scroll rail with "or Shake It!" pinned beside it
     * (dish-picker.css ≤ 767px), so the picked
     * tag must be brought into view — to the 16px gutter, like the section rail —
     * or a "Shake It!" pick and the server-rendered default can sit off-screen.
     * Smooth on a tap, instant on load; a no-op when the row doesn't scroll.
     */
    const labelsRail = picker.querySelector('.dish-picker__labels');
    function alignTags(tag, behavior = 'smooth') {
        if (!labelsRail || !tag || labelsRail.scrollWidth <= labelsRail.clientWidth) return;
        const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        labelsRail.scrollTo({ left: Math.max(0, tag.offsetLeft - 16), behavior: reduced ? 'instant' : behavior });
    }
    alignTags(tags[currentIndex], 'instant');
    // Golos arrives after DOMContentLoaded; the fallback face is narrower, so re-measure once it's in.
    if (document.fonts && document.fonts.ready) {
        document.fonts.ready.then(() => alignTags(tags[currentIndex], 'instant'));
    }

    function selectPairing(index) {
        if (index === currentIndex || isTransitioning) return;
        if (index < 0 || index >= pairings.length) return;

        isTransitioning = true;
        const pairing = pairings[index];

        // Update tag states
        tags.forEach((tag, i) => {
            const active = i === index;
            tag.classList.toggle('is-active', active);
            tag.setAttribute('aria-pressed', active ? 'true' : 'false');
        });
        alignTags(tags[index]);

        // Fade out photos
        foodImg.classList.add('is-fading');
        barImg.classList.add('is-fading');

        // Swap content at midpoint
        setTimeout(() => {
            // Swap images
            foodImg.src = pairing.foodImg;
            foodImg.alt = pairing.dish;
            barImg.src  = pairing.barImg;
            barImg.alt  = pairing.pairing;

            // Swap card content
            dishName.textContent    = pairing.cardName || pairing.dish;
            dishDesc.textContent    = pairing.description;
            pairingName.textContent = pairing.pairing;

            // Update CTA link
            if (ctaLink) {
                const baseUrl = window.location.pathname.replace(/\/$/, '');
                ctaLink.href = baseUrl + '/?menu=drinks#' + pairing.barSection;
            }

            // Fade in
            foodImg.classList.remove('is-fading');
            barImg.classList.remove('is-fading');
        }, FADE_MIDPOINT);

        // Allow next transition after full duration
        setTimeout(() => {
            currentIndex = index;
            isTransitioning = false;
        }, FADE_DURATION);
    }

    // ── Tag clicks ───────────────────────────────────
    tags.forEach((tag) => {
        tag.addEventListener('click', () => {
            const index = parseInt(tag.dataset.index, 10);
            selectPairing(index);
        });
    });

    // ── Shake It! ────────────────────────────────────
    if (shakeBtn) {
        shakeBtn.addEventListener('click', () => {
            // Pick a random index different from current
            let randomIndex;
            do {
                randomIndex = Math.floor(Math.random() * pairings.length);
            } while (randomIndex === currentIndex && pairings.length > 1);

            selectPairing(randomIndex);

            // Add a micro-bounce to the button
            shakeBtn.style.transform = 'scale(1.1) rotate(-3deg)';
            setTimeout(() => {
                shakeBtn.style.transform = '';
            }, 300);
        });
    }

    // ── Preload images ───────────────────────────────
    pairings.forEach((p) => {
        const img1 = new Image();
        img1.src = p.foodImg;
        const img2 = new Image();
        img2.src = p.barImg;
    });
}
