/**
 * Menu section rail — making it discoverable (phones and tablets, ≤ 991px).
 *
 * The rail is the phone menu page's tab bar, but an outlined word at the right edge
 * doesn't say "swipe me". So the rail says it twice (author, 20 Sep 2026 — tried as
 * ?rail= prototypes first):
 *
 *   Entrance  The first time each section's rail crosses into the top two thirds of the
 *             screen, the words after the current one arrive from the right, one after
 *             another — the rail shows where it comes from, once, and then is still.
 *   Nudge     For a guest who still hasn't touched it: every 2.5 s the rail of the section
 *             on show starts a swipe by itself — the words slide 14px left and spring back.
 *
 * Both stop for good at the first touch, scroll or key on any rail (remembered for the
 * visit): a guest who has found the interaction must not be interrupted by its demo
 * (website-brief.md → Motion language → Idle self-demo, human seizure — the fourth
 * "stops for good" exception).
 *
 * The motion is CSS (menu-section.css → .is-parked / .is-entering / .is-nudging); this
 * keeps the clock. Nothing runs under prefers-reduced-motion, above 991px, while the tab
 * is hidden or while the rail is off-screen. Without this script the rail is simply there.
 */

const LEARNED = 'spRailLearned';
const EVERY = 2500; // was 5000: on a phone the pauses read as longer than on a desktop (author, 21 Sep 2026)

export function initMenuRailNudge() {
    if (document.documentElement.classList.contains('debug-norail')) return; // diagnostic — inc/daypart-head.php
    const rails = Array.from(document.querySelectorAll('.menu-section-rail'));
    if (!rails.length) return;

    const phoneMq = window.matchMedia('(max-width: 991px)');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let learned = false;
    try { learned = sessionStorage.getItem(LEARNED) === '1'; } catch (e) { /* private mode */ }
    if (learned) return;

    let timer = null;
    const entered = new WeakMap(); // rail → when its entrance played
    const idle = () => phoneMq.matches && !reducedMotion.matches && !document.hidden;

    function stopForGood() {
        learned = true;
        clearTimeout(timer);
        rails.forEach((r) => r.classList.remove('is-nudging', 'is-entering', 'is-parked'));
        try { sessionStorage.setItem(LEARNED, '1'); } catch (e) { /* private mode */ }
    }

    // The rail of the section on show, if any part of it is in the viewport
    function railOnShow() {
        return rails.find((r) => {
            if (!r.offsetParent) return false; // its section is display: none
            const box = r.getBoundingClientRect();
            return box.bottom > 0 && box.top < window.innerHeight;
        });
    }

    // ── Idle nudge ──
    function tick() {
        timer = setTimeout(tick, EVERY);
        if (!idle()) return;
        const rail = railOnShow();
        // Before or during its entrance, or nothing to the right to point at
        if (!rail || rail.classList.contains('is-entering') || rail.classList.contains('is-parked')) return;
        const row = rail.querySelector('.menu-section-rail__nav'); // the scroller is the row, not the sticky bar
        if (!row || row.scrollWidth - row.clientWidth - row.scrollLeft < 8) return;
        // The entrance has just said it: give the guest a full beat before repeating
        if (performance.now() - (entered.get(rail) || 0) < EVERY) return;
        rail.classList.add('is-nudging');
    }

    // ── Entrance: once per section — when the guest is looking at it, not when it first
    // touches the fold: it plays as the rail crosses into the top two thirds of the screen,
    // while the section's photo above it is still in view. Until then the words that will
    // arrive are parked out of sight (.is-parked), so nothing blinks away before it enters.
    // (First it also waited for the scroll to rest. Fine with a mouse wheel; on a phone a
    // fling keeps scrolling on momentum for a second or two, so the entrance played after the
    // rail had already stuck under the header and the photo was gone — author, 21 Sep 2026.)
    const LINE = 0.66;  // of the viewport height

    function enter() {
        if (learned || !idle()) return;
        const rail = railOnShow();
        if (!rail || entered.has(rail)) return;
        if (rail.getBoundingClientRect().top > window.innerHeight * LINE) return;
        entered.set(rail, performance.now());
        let i = 0;
        let after = false;
        rail.querySelectorAll('.menu-section-rail__item').forEach((item) => {
            if (item.classList.contains('menu-section-rail__current')) { after = true; return; }
            if (after) item.style.setProperty('--rail-i', i++);
        });
        rail.classList.remove('is-parked');
        if (!i) return; // the last section: nothing arrives
        rail.classList.add('is-entering');
        setTimeout(() => rail.classList.remove('is-entering'), 900 + i * 80);
    }

    let queued = false;
    const lookForEntrance = () => {
        if (queued) return;
        queued = true;
        requestAnimationFrame(() => { queued = false; enter(); });
    };

    rails.forEach((rail) => {
        rail.addEventListener('animationend', (e) => {
            if (e.animationName === 'rail-nudge') rail.classList.remove('is-nudging');
        });
        ['pointerdown', 'touchstart', 'wheel', 'keydown'].forEach((type) =>
            rail.addEventListener(type, stopForGood, { passive: true, once: true }));
    });

    if (idle()) rails.forEach((r) => r.classList.add('is-parked'));
    window.addEventListener('scroll', lookForEntrance, { passive: true });
    window.addEventListener('reveal:check', lookForEntrance); // a section switch
    lookForEntrance();
    timer = setTimeout(tick, EVERY);
}
