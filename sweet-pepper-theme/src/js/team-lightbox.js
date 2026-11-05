/**
 * About — Dream Team wall lightbox: the wall, closer (author, 1 Oct 2026).
 *
 * A click on a print of the wall strip (.about-team__drift) opens the same prints at lightbox
 * scale on a dark see-through ground, each with its pin, tilt and year pill — sideways from
 * 768 up, a column on phones with the open print edge to edge (team-lightbox.css). The dialog
 * is in the page (template-parts/about/team-lightbox.php); this script makes the strip's
 * prints the way in, so without it they stay photos.
 *
 *   Opening   The print flies from its place on the strip to the middle; on closing the strip
 *             is rolled to the year the guest was looking at and the print flies back onto
 *             its own pin. Under prefers-reduced-motion it is simply there.
 *   Moving    The scroller is native (scroll-snap): a swipe, a trackpad and a touch drag work
 *             by themselves. A click on a waiting year, the arrow keys, Home / End and a
 *             mouse wheel (one year per gesture) roll to it on the house spring.
 *   Closing   Esc, the ×, a click on the ground. Focus goes to the strip's print of the year
 *             last looked at.
 *   Photos    Nothing loads until the first opening. Phones show the strip's own crop
 *             (already in the cache); from 768 up the larger file, lazily — the open year
 *             and its neighbours first — over the crop until it arrives.
 *
 * @module team-lightbox
 */

import { gentleEase } from './gentle-ease';

const ROLL_MS = 700;
const CLOSE_MS = 400; // team-lightbox.css → .is-closing

export function initTeamLightbox() {
    const strip = document.querySelector('.about-team__drift');
    const box = document.getElementById('team-lightbox');
    if (!strip || !box) return;

    const sources = [...strip.querySelectorAll('.about-team__wall-card:not(.about-team__wall-card--tbc)')];
    const view = box.querySelector('.team-lightbox__view');
    const cards = [...box.querySelectorAll('.team-lightbox__card')];
    const closeBtn = box.querySelector('.team-lightbox__close');
    if (!sources.length || sources.length !== cards.length) return;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const column = window.matchMedia('(max-width: 767px)');

    let current = -1;
    let isOpen = false;
    let loaded = false;
    let rollRaf = 0;
    let wheelLock = 0;
    let closeTimer = 0;

    // ── The strip's prints are the way in ──
    strip.classList.add('has-lightbox');
    sources.forEach((card, i) => {
        const img = card.querySelector('img');
        card.setAttribute('role', 'button');
        card.setAttribute('tabindex', '0');
        card.setAttribute('aria-haspopup', 'dialog');
        if (img) card.setAttribute('aria-label', img.alt);
        card.addEventListener('click', () => open(i, false));
        card.addEventListener('keydown', (e) => {
            if (e.key !== 'Enter' && e.key !== ' ') return;
            e.preventDefault();
            open(i, true);
        });
    });

    cards.forEach((card, i) => card.addEventListener('click', () => { if (i !== current) go(i); }));
    closeBtn.addEventListener('click', close);
    // A click on the ground — anywhere that is not a print — closes
    view.addEventListener('click', (e) => { if (!e.target.closest('.team-lightbox__card')) close(); });
    view.addEventListener('scroll', onScroll, { passive: true });
    view.addEventListener('wheel', onWheel, { passive: false });
    ['touchstart', 'pointerdown'].forEach((type) => view.addEventListener(type, cancelRoll, { passive: true }));
    box.addEventListener('keydown', onKey);

    // The photos, on the first opening. The strip's crop is the ground under the larger file
    // and takes its place if that one fails.
    function loadPhotos() {
        if (loaded) return;
        loaded = true;
        cards.forEach((card) => {
            const photo = card.querySelector('.team-lightbox__photo');
            const { src, full } = photo.dataset;
            const img = document.createElement('img');
            img.alt = ''; // the button carries the name
            img.decoding = 'async';
            photo.style.backgroundImage = `url("${src}")`;
            if (column.matches || !full || full === src) {
                img.src = src;
            } else {
                img.loading = 'lazy'; // the open year and its neighbours now, the rest as the wall is rolled to them
                img.addEventListener('error', () => { img.src = src; }, { once: true });
                img.src = full;
            }
            photo.prepend(img);
        });
    }

    // ── Where a print sits in the scroller ──
    function offsetFor(i) {
        const card = cards[i];
        return column.matches
            ? card.offsetTop - (view.clientHeight - card.offsetHeight) / 2
            : card.offsetLeft - (view.clientWidth - card.offsetWidth) / 2;
    }
    const getPos = () => (column.matches ? view.scrollTop : view.scrollLeft);
    const setPos = (v) => { if (column.matches) view.scrollTop = v; else view.scrollLeft = v; };

    function setCurrent(i) {
        if (i === current) return;
        current = i;
        cards.forEach((card, k) => {
            card.classList.toggle('is-current', k === i);
            card.tabIndex = k === i ? 0 : -1;
            if (k === i) card.setAttribute('aria-current', 'true'); else card.removeAttribute('aria-current');
        });
    }

    function nearest() {
        const pos = getPos();
        let best = 0;
        let bestD = Infinity;
        cards.forEach((card, i) => {
            const d = Math.abs(offsetFor(i) - pos);
            if (d < bestD) { bestD = d; best = i; }
        });
        return best;
    }

    let scrollQueued = false;
    function onScroll() {
        if (scrollQueued || rollRaf) return; // a roll names its own target
        scrollQueued = true;
        requestAnimationFrame(() => { scrollQueued = false; if (isOpen && !rollRaf) setCurrent(nearest()); });
    }

    function cancelRoll() {
        if (!rollRaf) return;
        cancelAnimationFrame(rollRaf);
        rollRaf = 0;
        view.style.scrollSnapType = '';
    }

    function jump(i) {
        cancelRoll();
        view.style.scrollSnapType = 'none';
        setPos(offsetFor(i));
        setCurrent(i);
        requestAnimationFrame(() => { view.style.scrollSnapType = ''; });
    }

    // Roll to a year on the house spring; snap is off while the tween runs (website-brief.md →
    // Motion language → Scroll tweens take the spring too)
    function go(i) {
        i = Math.max(0, Math.min(cards.length - 1, i));
        if (i === current && !rollRaf) return;
        if (reducedMotion.matches) { jump(i); return; }
        cancelRoll();
        setCurrent(i);
        const from = getPos();
        const delta = offsetFor(i) - from;
        if (Math.abs(delta) < 1) return;
        view.style.scrollSnapType = 'none';
        const t0 = performance.now();
        const step = (now) => {
            const p = Math.min(1, (now - t0) / ROLL_MS);
            setPos(from + delta * gentleEase(p));
            if (p < 1) { rollRaf = requestAnimationFrame(step); return; }
            rollRaf = 0;
            setPos(from + delta);
            requestAnimationFrame(() => { view.style.scrollSnapType = ''; });
        };
        rollRaf = requestAnimationFrame(step);
    }

    // A mouse wheel is one step per gesture (snap and wheel deltas fight otherwise); a
    // sideways swipe on a trackpad, and everything in the column, stays native
    function onWheel(e) {
        if (column.matches) return;
        if (Math.abs(e.deltaX) > Math.abs(e.deltaY) || e.deltaY === 0) return;
        e.preventDefault();
        const now = performance.now();
        if (now < wheelLock) { wheelLock = Math.max(wheelLock, now + 160); return; } // the same gesture, still coasting
        wheelLock = now + 450;
        go(current + (e.deltaY > 0 ? 1 : -1));
    }

    function onKey(e) {
        if (e.key === 'Escape') { e.preventDefault(); close(); return; }
        const to = e.key === 'ArrowRight' || e.key === 'ArrowDown' ? current + 1
            : e.key === 'ArrowLeft' || e.key === 'ArrowUp' ? current - 1
            : e.key === 'Home' ? 0
            : e.key === 'End' ? cards.length - 1
            : null;
        if (to !== null) {
            e.preventDefault();
            const onPrint = cards.includes(document.activeElement);
            go(to);
            if (onPrint) cards[current].focus({ preventScroll: true }); // focus follows the open year
            return;
        }
        if (e.key === 'Tab') {
            // two stops: the open print and the ×
            const stops = [cards[current], closeBtn];
            const at = stops.indexOf(document.activeElement);
            e.preventDefault();
            stops[(at + (e.shiftKey ? stops.length - 1 : 1) + stops.length) % stops.length].focus({ preventScroll: true });
        }
    }

    // ── The flight: the open print leaves from, and returns to, its place on the strip. It
    //    moves the print inside the button — a transformed snap target would drag the
    //    scroller after it ──
    const printOf = (card) => card.querySelector('.team-lightbox__print');

    function flightFrom(print, source) {
        const a = source.getBoundingClientRect();
        const b = print.getBoundingClientRect();
        const dx = a.left + a.width / 2 - (b.left + b.width / 2);
        const dy = a.top + a.height / 2 - (b.top + b.height / 2);
        return `translate(${dx}px, ${dy}px) scale(${a.width / b.width})`;
    }

    // Bring a year's print into the strip's window, as near its middle as the strip allows
    function showOnStrip(i) {
        const source = sources[i];
        const max = strip.scrollWidth - strip.clientWidth;
        strip.scrollLeft = Math.max(0, Math.min(max, source.offsetLeft - (strip.clientWidth - source.offsetWidth) / 2));
    }

    function measure() {
        box.style.setProperty('--lb-vh', `${box.clientHeight}px`);
    }

    function open(i, byKey) {
        if (isOpen) return;
        isOpen = true;
        loadPhotos();
        document.body.style.overflow = 'hidden';
        measure();
        current = -1;
        jump(i);

        clearTimeout(closeTimer); // a reopening inside the closing flight
        box.classList.remove('is-closing');
        cards.forEach((c) => { printOf(c).style.transform = ''; });
        const card = cards[i];
        const print = printOf(card);
        if (!reducedMotion.matches) {
            print.classList.add('is-flying');
            print.style.transform = flightFrom(print, sources[i]);
            void print.offsetWidth; // the start is painted before the print lets go
        }
        box.classList.add('is-open');
        requestAnimationFrame(() => {
            print.classList.remove('is-flying');
            print.style.transform = '';
        });
        // A pointer's opening parks focus on the dialog: no ring lit by a click (mail-chooser.js)
        (byKey ? card : box).focus({ preventScroll: true });
    }

    function close() {
        if (!isOpen) return;
        isOpen = false;
        cancelRoll();
        document.body.style.overflow = '';
        const i = current;
        const print = printOf(cards[i]);
        showOnStrip(i); // the strip is left on the year the guest was looking at

        box.classList.remove('is-open');
        if (!reducedMotion.matches) {
            box.classList.add('is-closing');
            print.style.transform = flightFrom(print, sources[i]);
            closeTimer = setTimeout(() => {
                box.classList.remove('is-closing');
                print.style.transform = '';
            }, CLOSE_MS + 20);
        }
        sources[i].focus({ preventScroll: true });
    }

    window.addEventListener('resize', () => {
        if (!isOpen) return;
        measure();
        jump(current);
    });
}
