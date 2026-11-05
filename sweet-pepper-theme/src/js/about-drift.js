/**
 * About — Dream Team drift strip: a mouse can move it, and it shows that it moves.
 *
 * The strip (.about-team__drift) is an overflow-x: auto box with its scrollbar hidden and
 * nothing behind it. A touchpad sends horizontal deltas, so it scrolled; a mouse wheel sends
 * vertical ones only, and browsers never turn those sideways — a mouse had no handle at all
 * (author, 27 Sep 2026: "scroll works well with the touchpad, but I couldn't scroll it with
 * a mouse").
 *
 *   Wheel   A vertical wheel over the strip scrolls it sideways while it can still move that
 *           way; at either end the event passes and the page scrolls on, so the strip never
 *           traps the reader. Horizontal deltas (a touchpad's own swipe) pass untouched.
 *           The cost, on record: a two-finger vertical swipe over the strip moves the strip
 *           until it reaches an end. That is the trade of every horizontal-on-wheel rail.
 *
 *   Drag    A mouse grabs the strip and pulls it sideways; let go mid-pull and it glides on
 *           and slows to a stop. The wheel alone was not found by testers with a mouse
 *           (author, 2 Oct 2026: "discovering that you need to use a wheel for this is very
 *           difficult"). Mouse only — touch and pen keep the browser's own scroll. A press
 *           that travels under DRAG_SLOP px is still a click, so a print still opens the
 *           lightbox (team-lightbox.js); a real pull swallows the click it ends in. The
 *           hand: grab on the strip's ground, grabbing while pulling; a print keeps its
 *           pointer (team-lightbox.css). No glide under prefers-reduced-motion.
 *
 *   Drift   Once, when the strip crosses into the top two thirds of the screen: it drifts
 *           one small step and settles back — the menu rail's idle nudge, once, on the strip
 *           itself (menu-rail-nudge.js). Stops at the first wheel, touch, pointer or key on
 *           the strip; never under prefers-reduced-motion, in a hidden tab, or once the guest
 *           has moved the strip. Without this script the strip is simply there.
 *
 * @module about-drift
 */

const STEP = 96;       // px of drift, about a third of a wall card
const DURATION = 1400; // ms, there and back
const LINE = 0.66;     // of the viewport height (menu-rail-nudge.js → LINE)
const DRAG_SLOP = 6;   // px a mouse press may travel and still be a click
const FRICTION = 0.94; // glide speed kept per 16 ms frame after a throw

export function initAboutDrift() {
    const strip = document.querySelector('.about-team__drift');
    if (!strip) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const maxLeft = () => strip.scrollWidth - strip.clientWidth;

    // ── Wheel → sideways ──
    strip.addEventListener('wheel', (e) => {
        if (!e.cancelable) return;                              // mid-sequence, the browser has latched
        if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) return;    // a horizontal swipe: native
        if (e.deltaY === 0) return;
        const unit = e.deltaMode === 1 ? 16 : e.deltaMode === 2 ? strip.clientWidth : 1;
        const delta = e.deltaY * unit;
        const left = strip.scrollLeft;
        const canMove = delta > 0 ? left < maxLeft() - 1 : left > 1;
        if (!canMove) return;                                   // at an end: the page scrolls on
        e.preventDefault();
        strip.scrollLeft = left + delta;
    }, { passive: false });

    // ── Mouse drag → sideways, with a glide on release ──
    let press = null;   // { id, x, left, dragging, samples: [[t, x]] }
    let glideRaf = 0;
    let swallowClick = false;

    function stopGlide() {
        if (glideRaf) { cancelAnimationFrame(glideRaf); glideRaf = 0; }
    }

    function glide(velocity) {                                  // px per ms, + = content moves left
        if (reducedMotion.matches || Math.abs(velocity) < 0.1) return;
        let v = velocity;
        let last = performance.now();
        const frame = (now) => {
            const dt = Math.min(48, now - last);
            last = now;
            const before = strip.scrollLeft;
            strip.scrollLeft = before + v * dt;
            v *= Math.pow(FRICTION, dt / 16);
            const stuck = Math.abs(strip.scrollLeft - before) < 0.5 && Math.abs(v * dt) >= 0.5; // an end
            glideRaf = Math.abs(v) < 0.02 || stuck ? 0 : requestAnimationFrame(frame);
        };
        glideRaf = requestAnimationFrame(frame);
    }

    strip.addEventListener('pointerdown', (e) => {
        stopGlide();
        swallowClick = false;
        if (e.pointerType !== 'mouse' || e.button !== 0 || maxLeft() < 1) return;
        press = { id: e.pointerId, x: e.clientX, left: strip.scrollLeft, dragging: false, samples: [[e.timeStamp, e.clientX]] };
    });

    strip.addEventListener('pointermove', (e) => {
        if (!press || e.pointerId !== press.id) return;
        const dx = e.clientX - press.x;
        if (!press.dragging) {
            if (Math.abs(dx) < DRAG_SLOP) return;
            press.dragging = true;
            strip.setPointerCapture(e.pointerId);
            strip.classList.add('is-dragging');
        }
        strip.scrollLeft = press.left - dx;
        press.samples.push([e.timeStamp, e.clientX]);
        if (press.samples.length > 6) press.samples.shift();
    });

    function release(e) {
        if (!press || e.pointerId !== press.id) return;
        const { dragging, samples } = press;
        press = null;
        if (!dragging) return;
        strip.classList.remove('is-dragging');
        swallowClick = true;                                    // the click this pull ends in is not a click
        // Throw speed from the last ~100 ms of the pull; a pause before letting go throws nothing
        const now = e.timeStamp;
        const recent = samples.filter(([t]) => now - t < 100);
        if (e.type === 'pointerup' && recent.length > 1) {
            const [t0, x0] = recent[0];
            const [t1, x1] = recent[recent.length - 1];
            if (t1 > t0) glide(-(x1 - x0) / (t1 - t0));
        }
    }

    strip.addEventListener('pointerup', release);
    strip.addEventListener('pointercancel', release);
    strip.addEventListener('lostpointercapture', (e) => { if (press && press.dragging) release(e); });
    strip.addEventListener('click', (e) => {
        if (!swallowClick) return;
        swallowClick = false;
        e.preventDefault();
        e.stopPropagation();                                    // before a print's own listener
    }, true);
    strip.addEventListener('dragstart', (e) => e.preventDefault()); // no ghost image of a photo
    strip.addEventListener('wheel', stopGlide, { passive: true });

    // ── Entrance drift, once ──
    let done = false;
    let raf = 0;

    function stop() {
        done = true;
        if (raf) { cancelAnimationFrame(raf); raf = 0; }
    }

    ['pointerdown', 'touchstart', 'wheel', 'keydown'].forEach((type) =>
        strip.addEventListener(type, stop, { passive: true, once: true }));

    function drift() {
        if (done || reducedMotion.matches || document.hidden) return;
        if (strip.scrollLeft > 0 || maxLeft() < STEP) return;   // already moved, or nothing to show
        const box = strip.getBoundingClientRect();
        if (box.bottom <= 0 || box.top > window.innerHeight * LINE) return;
        done = true;
        window.removeEventListener('scroll', look);
        const start = performance.now();
        const ease = (t) => 0.5 - Math.cos(Math.PI * t) / 2;     // in-out, one sine hump there and back
        const frame = (now) => {
            const t = Math.min(1, (now - start) / DURATION);
            strip.scrollLeft = STEP * Math.sin(Math.PI * ease(t));
            if (t < 1) raf = requestAnimationFrame(frame); else { raf = 0; strip.scrollLeft = 0; }
        };
        raf = requestAnimationFrame(frame);
    }

    let queued = false;
    function look() {
        if (queued) return;
        queued = true;
        requestAnimationFrame(() => { queued = false; drift(); });
    }

    window.addEventListener('scroll', look, { passive: true });
    window.addEventListener('reveal:check', look);
    look();
}
