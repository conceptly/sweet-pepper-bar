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
 *   Drift   Once, when the strip crosses into the top two thirds of the screen: it drifts
 *           one small step and settles back — the menu rail's idle nudge, once, on the strip
 *           itself (menu-rail-nudge.js). Stops at the first wheel, touch, pointer or key on
 *           the strip; never under prefers-reduced-motion, in a hidden tab, or once the guest
 *           has moved the strip. Without this script the strip is simply there.
 *
 * @module about-drift
 */

import { initTeamLightbox } from './team-lightbox'; // PROTOTYPE behind ?lightbox — wired here so main.js stays untouched

const STEP = 96;       // px of drift, about a third of a wall card
const DURATION = 1400; // ms, there and back
const LINE = 0.66;     // of the viewport height (menu-rail-nudge.js → LINE)

export function initAboutDrift() {
    const strip = document.querySelector('.about-team__drift');
    if (!strip) return;

    initTeamLightbox();

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
