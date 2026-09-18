/**
 * Count-up — a number that counts to its value once, as its block reveals.
 *
 * Markup opts in: <span data-count-up>12 years</span>. The server prints the final text,
 * so with no JS, with reduced motion, or when the block was already scrolled past (reveal.js
 * arms none of those) the number is simply there. Otherwise it starts from 0 when the
 * nearest [data-reveal] ancestor plays — the Story ledger's gesture (about-story.js), the home
 * page quoting the page it links to. Not the ledger's numbers, though: those count tens of
 * thousands, where 1.4 s of ease-out cubic is a blur that lands. Twelve steps on that curve
 * are over before the row has faded in (author, 18 Sep 2026: barely noticeable). So it waits
 * until the row is fully there, then takes 2.4 s on ease-out quad — every step readable,
 * the last ones slowest.
 *
 * The number keeps its final width from the first frame (right-aligned in it), so the
 * words after it don't shuffle as digits are added.
 */

const COUNT_MS = 2400;
const WAIT_MS = 600; // after the reveal starts: the row's 400 ms fade has finished
const easeOutQuad = (t) => 1 - Math.pow(1 - t, 2);

export function initCountUp() {
    document.querySelectorAll('[data-count-up]').forEach((el) => {
        const host = el.closest('[data-reveal].is-armed');
        const m = el.textContent.match(/^(\D*?)(\d+)([\s\S]*)$/);
        if (!host || !m) return;

        const target = parseInt(m[2], 10);
        const num = document.createElement('span');
        num.className = 'count-up__n';
        num.textContent = m[2];
        el.replaceChildren(m[1], num, m[3]);
        num.style.minWidth = `${num.getBoundingClientRect().width}px`;

        host.addEventListener('reveal:in', (e) => {
            num.textContent = '0'; // the block is still invisible at this point
            setTimeout(() => {
                const start = performance.now();
                (function tick(now) {
                    const p = Math.min(1, (now - start) / COUNT_MS);
                    num.textContent = Math.round(target * easeOutQuad(p));
                    if (p < 1) requestAnimationFrame(tick);
                    else num.style.minWidth = '';
                })(start);
            }, e.detail.delay + WAIT_MS);
        }, { once: true });
    });
}
