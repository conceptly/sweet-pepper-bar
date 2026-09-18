/**
 * Scramble text — swap one string for another through a run of scrambled glyphs,
 * resolving left to right.
 *
 * Built for Molot, which is not monospaced: a pool of arbitrary characters would make
 * the line's width jump on every tick (and re-wrap a headline near its container's
 * width). So the pool is the TARGET's own letters minus the narrow ones — the scramble
 * is made of the word it is becoming, which also makes it work for RU with no charset
 * to maintain. Spaces stay where the target has them, so word shapes hold.
 *
 * - State change only, never idle: call it when the text changes, not on a clock.
 * - Interruptible: a second call starts from whatever is on screen.
 * - prefers-reduced-motion: writes the target directly.
 * - Screen readers get the target at once (aria-label for the ride, then removed).
 */

const NARROW = /[\s.,:;!?'’"“”·\-–—Iil1|]/;
const TICK = 50; // ms between re-rolls of the unresolved glyphs — faster reads as noise

const running = new WeakMap();
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
const easeOut = (p) => 1 - Math.pow(1 - p, 3);

export function scrambleTo(el, target, duration = 600) {
    if (!el) return;
    cancelAnimationFrame(running.get(el));

    const from = el.textContent;
    if (from === target || reducedMotion.matches) {
        el.textContent = target;
        el.removeAttribute('aria-label');
        return;
    }

    const pool = [...new Set([...target].filter((c) => !NARROW.test(c)))];
    if (!pool.length) { el.textContent = target; return; }
    const pick = () => pool[Math.floor(Math.random() * pool.length)];

    el.setAttribute('aria-label', target);

    // Hold the box: measure the target's height (same frame, never painted) and keep the
    // taller of the two for the ride, so what sits below doesn't bob. When both ends are
    // one line, the ride stays one line — a wide roll runs past the box instead of wrapping.
    const fromH = el.offsetHeight;
    el.textContent = target;
    const targetH = el.offsetHeight;
    el.textContent = from;
    el.style.minHeight = `${Math.max(fromH, targetH)}px`;
    const oneLine = Math.max(fromH, targetH) < parseFloat(getComputedStyle(el).fontSize) * 1.5;
    if (oneLine) el.style.whiteSpace = 'nowrap';
    const release = () => {
        el.style.minHeight = '';
        el.style.whiteSpace = '';
        el.removeAttribute('aria-label');
    };

    const start = performance.now();
    let lastRoll = -Infinity;
    let noise = [];

    function frame(nowT) {
        const p = Math.min(1, (nowT - start) / duration);
        if (p === 1) {
            el.textContent = target;
            release();
            running.delete(el);
            return;
        }

        // The line grows or shrinks from the old length to the new one as it resolves
        const length = Math.round(from.length + (target.length - from.length) * p);
        const resolved = Math.floor(easeOut(p) * target.length);

        if (nowT - lastRoll >= TICK) {
            lastRoll = nowT;
            noise = Array.from({ length }, (_, i) => (target[i] === ' ' ? ' ' : pick()));
        }

        el.textContent = target.slice(0, resolved) + noise.slice(resolved, length).join('');
        running.set(el, requestAnimationFrame(frame));
    }

    running.set(el, requestAnimationFrame(frame));
}
