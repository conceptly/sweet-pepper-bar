/**
 * Gentle scroll — spring-driven in-page anchor scrolling
 *
 * Browsers own the timing of `scroll-behavior: smooth` (Chrome: a short,
 * fixed ease that stops abruptly), so it can never match a Figma spring.
 * This drives window scroll with the same physics Figma uses for its
 * "Gentle" preset (mass 1, stiffness 100, damping 15) — the house easing
 * for prints, rolls and snap-backs (website-brief.md → Motion language).
 *
 * - Interrupted by any user scroll (wheel / touch / keys) — never fights.
 * - `prefers-reduced-motion`: instant jump.
 * - Updates the URL hash on arrival so the anchor stays deep-linkable.
 */

const GENTLE = { mass: 1, stiffness: 100, damping: 15 };

/* Gentle overshoots by ~2.8% of the distance. On a screen-sized transition
   that is a soft landing; on a 7000px jump down the menu it is a 200px lurch.
   Cap the landing at this many pixels by raising the damping on long rides —
   the spring keeps its attack and settle time, only the overshoot shrinks. */
const MAX_OVERSHOOT_PX = 24;

function dampingForOvershoot(spring, distance) {
    const zeta0 = spring.damping / (2 * Math.sqrt(spring.stiffness * spring.mass));
    const f0    = Math.exp(-Math.PI * zeta0 / Math.sqrt(1 - zeta0 * zeta0)); // overshoot fraction
    const fMax  = MAX_OVERSHOOT_PX / Math.max(1, Math.abs(distance));
    if (zeta0 >= 1 || f0 <= fMax) return spring.damping;
    const L    = -Math.log(fMax) / Math.PI;
    const zeta = Math.min(1, L / Math.sqrt(1 + L * L));
    return 2 * zeta * Math.sqrt(spring.stiffness * spring.mass);
}

/** Scroll the window so `target` lands at the top, on a spring. */
export function gentleScrollTo(target, spring = GENTLE) {
    const el = typeof target === 'string' ? document.querySelector(target) : target;
    if (!el) return Promise.resolve(false);

    // Honour the target's scroll-margin-top, as native anchor scrolling does —
    // main.css gives sections 76px of it below 992px, where the header is fixed.
    const margin = parseFloat(getComputedStyle(el).scrollMarginTop) || 0;
    const maxY = document.documentElement.scrollHeight - window.innerHeight;
    const to   = Math.max(0, Math.min(maxY, el.getBoundingClientRect().top + window.scrollY - margin));

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
        window.scrollTo({ top: to, behavior: 'instant' });
        return Promise.resolve(true);
    }

    return new Promise((resolve) => {
        const { mass, stiffness } = spring;
        const damping = dampingForOvershoot(spring, to - window.scrollY);
        let y = window.scrollY;
        let v = 0;
        let last = performance.now();
        let cancelled = false;

        // A real user scroll cancels the ride.
        const cancel = () => { cancelled = true; };
        const opts = { passive: true, once: true };
        window.addEventListener('wheel', cancel, opts);
        window.addEventListener('touchstart', cancel, opts);
        window.addEventListener('keydown', cancel, opts);

        const cleanup = () => {
            window.removeEventListener('wheel', cancel);
            window.removeEventListener('touchstart', cancel);
            window.removeEventListener('keydown', cancel);
        };

        const step = (now) => {
            if (cancelled) { cleanup(); resolve(false); return; }

            // Semi-implicit Euler in fixed 1ms sub-steps: stable at any frame rate.
            const frame = Math.min(64, now - last);
            last = now;
            const dt = 0.001;
            for (let t = 0; t < frame; t += 1) {
                const a = (-stiffness * (y - to) - damping * v) / mass;
                v += a * dt;
                y += v * dt;
            }

            const settled = Math.abs(y - to) < 0.5 && Math.abs(v) < 5;
            window.scrollTo({ top: settled ? to : y, behavior: 'instant' });

            if (settled) { cleanup(); resolve(true); } else { requestAnimationFrame(step); }
        };
        requestAnimationFrame(step);
    });
}

/**
 * Bind every same-page anchor matching `selector` to the spring scroll.
 * Site-wide default (Sep 2026): footer "Back to top" (#page), Visit's
 * Directions (#visit-map), in-list shortcuts like #bar-menu. Components
 * that run their own click logic (menu hero, jump-nav) call gentleScrollTo()
 * directly and are excluded here so they aren't bound twice.
 * The skip link stays native — it must move focus, not animate.
 */
export function initGentleScroll(selector = 'a[href^="#"]:not(.skip-link):not(.menu-hero__nav-item)') {
    document.querySelectorAll(selector).forEach((link) => {
        const hash = link.getAttribute('href');
        if (!hash || hash === '#') return;
        let target = null;
        try { target = document.querySelector(hash); } catch (e) { return; }
        if (!target) return; // let the browser handle unknown anchors

        link.addEventListener('click', (e) => {
            e.preventDefault();
            gentleScrollTo(target).then((arrived) => {
                if (arrived && window.location.hash !== hash) {
                    history.pushState(null, '', hash);
                }
            });
        });
    });
}
