/**
 * --ease-gentle — cubic-bezier(0.33, 0.57, 0.08, 1.19) — solved in JS for scroll tweens: a
 * scrollTop / scrollLeft animation can't take a CSS easing (website-brief.md → Motion
 * language → Scroll tweens take the spring too). Overshoots past 1, so a roll lands with a
 * small settle like the FLIPs elsewhere.
 *
 * Used by the quote wheel (how-it-feels.js) and the team wall lightbox (team-lightbox.js).
 *
 * @param {number} t Progress, 0 → 1.
 * @returns {number} Eased progress.
 */
export function gentleEase(t) {
    const x1 = 0.33, y1 = 0.57, x2 = 0.08, y2 = 1.19;
    const bx = (u) => 3 * x1 * u * (1 - u) * (1 - u) + 3 * x2 * u * u * (1 - u) + u * u * u;
    const by = (u) => 3 * y1 * u * (1 - u) * (1 - u) + 3 * y2 * u * u * (1 - u) + u * u * u;
    let u = t;
    for (let i = 0; i < 6; i++) {
        const dx = 3 * x1 * (1 - u) * (1 - 3 * u) + 3 * x2 * u * (2 - 3 * u) + 3 * u * u;
        if (Math.abs(dx) < 1e-6) break;
        u -= (bx(u) - t) / dx;
        u = Math.min(1, Math.max(0, u));
    }
    return by(u);
}
