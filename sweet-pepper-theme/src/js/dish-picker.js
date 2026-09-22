/**
 * Dish Picker — Interactive pairing component
 *
 * Reads pairings data from an inline <script type="application/json">,
 * handles tag selection, the photo roll, the ticket re-print and Shake It!.
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

    // Reduced motion only: the old crossfade — fade out → swap at midpoint → fade in
    const FADE_MIDPOINT = 175; // ms

    /**
     * Phones: the tags are a gutter-to-gutter scroll rail (dish-picker.css ≤ 767px),
     * so the picked
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

    /* ── The photos roll (website-brief.md → Pairing station → Motion) ──
       A pick rolls both frames like a rail, in opposite directions — the plate comes down
       from the top, the glass up from the bottom: the two hands of a shake. The frame is
       the mask (overflow: hidden), so only the images move, on `translate`; the frames
       stay the reveal engine's. The old photo leaves as a clone (already decoded, so it
       covers while the new one decodes) and the real <img> takes the new src and rolls in
       behind it, 8px apart like frames on a strip. --ease-out-expo, the curve the photos
       entered on: a spring's overshoot would cross the mask's edge and show the ground.
       Interruptible like the ticket — a new pick takes over from wherever the strip is. */
    const ROLL_MS = 900;
    const ROLL_GAP = 8;
    const ROLL_EASE = rootStyle.getPropertyValue('--ease-out-expo').trim() || 'cubic-bezier(0.16, 1, 0.3, 1)';

    function rollPhoto(img, src, alt, dir, delay) {
        const frame = img.parentElement;
        let ghost = frame.querySelector('.dish-picker__photo-ghost');
        let from;

        if (img._parked && ghost) {
            // A second pick before the first had decoded: the old photo is still the one on
            // show — keep it, and just change what is coming.
            from = img._from;
        } else {
            from = paperY(img); // mid-roll if a pick interrupts
            img.getAnimations().forEach((a) => a.cancel());
            if (ghost) ghost.remove();

            ghost = img.cloneNode(false);
            ghost.classList.add('dish-picker__photo-ghost');
            ghost.alt = '';
            ghost.setAttribute('aria-hidden', 'true');
            ghost.removeAttribute('loading');
            ghost.style.translate = `0 ${from}px`;
            frame.appendChild(ghost);
        }
        img._parked = true;
        img._from = from;

        const travel = frame.offsetHeight + ROLL_GAP;
        const start = from - dir * travel;
        img.style.translate = `0 ${start}px`; // parked behind the mask while it decodes
        img.src = src;
        img.alt = alt;

        const run = (img._rollRun = (img._rollRun || 0) + 1);
        const ready = img.decode ? img.decode().catch(() => {}) : Promise.resolve();
        ready.then(() => {
            if (run !== img._rollRun) return; // a newer pick took over
            img._parked = false;
            const timing = { duration: ROLL_MS, delay, easing: ROLL_EASE, fill: 'backwards' };
            img.style.translate = '';
            img.animate({ translate: [`0 ${start}px`, '0 0px'] }, timing);
            ghost.style.translate = `0 ${dir * travel}px`;
            ghost.animate({ translate: [`0 ${from}px`, `0 ${dir * travel}px`] }, timing)
                .finished.then(() => ghost.remove()).catch(() => {});
        });
    }

    function selectPairing(index) {
        if (index === currentIndex) return;
        if (index < 0 || index >= pairings.length) return;

        currentIndex = index; // the last pick always wins — nothing is dropped mid-motion
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
                // The drinks page in the request's language (inc/lang.php prints spLang.root) — not the
                // current path, which on About sent the link to /about/?menu=drinks (fixed 21 Sep 2026).
                ctaLink.href = ((window.spLang && window.spLang.root) || '') + '/menu/?menu=drinks#' + pairing.barSection;
            }
        });

        if (!reducedMotion.matches && foodImg.animate) {
            rollPhoto(foodImg, pairing.foodImg, pairing.dish, 1, 0);      // plate: down from the top
            rollPhoto(barImg, pairing.barImg, pairing.pairing, -1, 80);   // glass: up from the bottom, a beat later
            return;
        }

        // Reduced motion: crossfade in place
        foodImg.classList.add('is-fading');
        barImg.classList.add('is-fading');
        setTimeout(() => {
            if (pairings[currentIndex] !== pairing) return; // a newer pick took over
            foodImg.src = pairing.foodImg;
            foodImg.alt = pairing.dish;
            barImg.src  = pairing.barImg;
            barImg.alt  = pairing.pairing;
            foodImg.classList.remove('is-fading');
            barImg.classList.remove('is-fading');
        }, FADE_MIDPOINT);
    }

    /* ── Shake It! — the shaker between the plate and the glass ──
       (website-brief.md → Pairing station; Figma 2437:71646 / 2437:72125.)
       Tap: the shaker spins once on the house spring while the ticket re-prints.
       Touch only: the "delay" state as an idle hint — a swell on the 5 s heartbeat, the
       section's one clock. Any pick seizes it for 8 s; the first Shake ends it for the
       visit (the guest has found it). Hover-capable pointers get the hover state instead. */
    const shakeIcon = shakeBtn && shakeBtn.querySelector('.dish-picker__shake-icon');
    const HEARTBEAT = 5000, SEIZE = 8000, FIRST = 2500;
    let hintTimer = 0;
    let hintInView = false;
    let hintDone = !shakeBtn || !window.matchMedia('(hover: none)').matches;

    function hintBeat() {
        if (hintDone || reducedMotion.matches) return;
        if (hintInView) {
            shakeBtn.classList.remove('is-hinting');
            void shakeBtn.offsetWidth; // restart the keyframes
            shakeBtn.classList.add('is-hinting');
        }
        hintWait(HEARTBEAT);
    }

    function hintWait(ms) {
        clearTimeout(hintTimer);
        if (!hintDone) hintTimer = setTimeout(hintBeat, ms);
    }

    if (!hintDone && 'IntersectionObserver' in window) {
        let started = false;
        new IntersectionObserver(([entry]) => {
            hintInView = entry.isIntersecting;
            if (hintInView && !started) { started = true; hintWait(FIRST); }
        }, { threshold: 0.6 }).observe(picker.querySelector('.dish-picker__photos'));
    }

    /* The tag rail (phones) fades at an end only while there is more that way. */
    function markRail() {
        if (!labelsRail) return;
        const max = labelsRail.scrollWidth - labelsRail.clientWidth;
        labelsRail.classList.toggle('has-more-start', labelsRail.scrollLeft > 1);
        labelsRail.classList.toggle('has-more-end', labelsRail.scrollLeft < max - 1);
    }
    if (labelsRail) {
        labelsRail.addEventListener('scroll', markRail, { passive: true });
        window.addEventListener('resize', markRail);
        if (document.fonts && document.fonts.ready) document.fonts.ready.then(markRail);
        markRail();
    }

    // ── Tag clicks ───────────────────────────────────
    tags.forEach((tag) => {
        tag.addEventListener('click', () => {
            const index = parseInt(tag.dataset.index, 10);
            selectPairing(index);
            if (shakeBtn) shakeBtn.classList.remove('is-hinting');
            hintWait(SEIZE);
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

            // Found: the idle hint has done its job for this visit.
            hintDone = true;
            clearTimeout(hintTimer);
            shakeBtn.classList.remove('is-hinting');

            // One full turn on the house spring — it overshoots and settles, like a wrist.
            if (shakeIcon && shakeIcon.animate && !reducedMotion.matches) {
                shakeIcon.getAnimations().forEach((a) => a.cancel());
                shakeIcon.animate({ rotate: ['0deg', '360deg'] }, { duration: 900, easing: PRINT_EASE });
            }
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
