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
    const cardWrap   = picker.querySelector('.dish-picker__card-wrap');

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

    /* ── The ticket prints (website-brief.md → The bartender's ticket → Motion) ──
       A pick is an order: the slip pulls back up into its slot, the reply is written while
       it is out of sight, and it prints again on the house spring — never a text swap in
       place, never a fade. The slot is .dish-picker__card-wrap itself (overflow: hidden),
       so the paper — both scalloped edges and the card — moves inside it and nothing else
       needs a mask. `translate`, so it composes with the phone ticket's 1° tilt.
       Interruptible: a new pick starts from wherever the paper is. Reduced motion: the
       text is swapped in place, as before. */
    const RETRACT_MS = 220;
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const rootStyle = getComputedStyle(document.documentElement);
    const dur = rootStyle.getPropertyValue('--dur-gentle').trim(); // the minifier may write 800ms as .8s
    const PRINT_MS = (parseFloat(dur) || 0.8) * (dur.endsWith('ms') ? 1 : 1000);
    const PRINT_EASE = rootStyle.getPropertyValue('--ease-gentle').trim() || 'cubic-bezier(0.33, 0.57, 0.08, 1.19)';
    let printRun = 0;

    function paperY(el) {
        const t = getComputedStyle(el).translate; // "none" | "0px -120px"
        return t === 'none' ? 0 : parseFloat(t.split(' ')[1]) || 0;
    }

    function reprint(write) {
        const paper = cardWrap ? [...cardWrap.children] : [];
        if (!paper.length || reducedMotion.matches || !paper[0].animate) { write(); return; }

        const run = ++printRun;
        const from = paperY(paper[0]);
        const out = -(cardWrap.offsetHeight + 8);
        paper.forEach((el) => el.getAnimations().forEach((a) => a.cancel()));

        const retract = paper.map((el) => el.animate(
            { translate: [`0 ${from}px`, `0 ${out}px`] },
            { duration: RETRACT_MS, easing: 'cubic-bezier(0.4, 0, 1, 1)', fill: 'forwards' }
        ));

        Promise.all(retract.map((a) => a.finished)).then(() => {
            if (run !== printRun) return; // a newer pick took over
            write();
            const height = -(cardWrap.offsetHeight + 8); // the new reply may be a line longer
            paper.forEach((el) => {
                el.getAnimations().forEach((a) => a.cancel());
                el.animate({ translate: [`0 ${height}px`, '0 0px'] }, { duration: PRINT_MS, easing: PRINT_EASE });
            });
        }).catch(() => {}); // cancelled by a newer pick
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

        // The ticket: retract → write the reply out of sight → print
        reprint(() => {
            dishName.textContent    = pairing.cardName || pairing.dish;
            dishDesc.textContent    = pairing.description;
            pairingName.textContent = pairing.pairing;

            // Update CTA link
            if (ctaLink) {
                const baseUrl = window.location.pathname.replace(/\/$/, '');
                ctaLink.href = baseUrl + '/?menu=drinks#' + pairing.barSection;
            }
        });

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
