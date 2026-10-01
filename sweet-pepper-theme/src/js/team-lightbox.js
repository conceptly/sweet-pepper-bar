/**
 * About — Dream Team wall lightbox. PROTOTYPE behind ?lightbox (1 Oct 2026).
 *
 * A click on a print of the wall strip (.about-team__drift) opens the wall, closer: the same
 * prints at lightbox scale on a dark see-through ground, each with its pin, tilt and year pill
 * (team-lightbox.css). Sideways from 768 up, a column on phones (author). Without the flag the
 * page is untouched — no listener, no markup.
 *
 *   ?lightbox            the defaults: a1 · p4 on the cord · grow (author, 1 Oct 2026)
 *   ?lightbox=a2         the page blurred behind the ground (a1: the ground alone)
 *   ?lightbox=p3         phone column with every print 16px in from the edges, on the cord
 *                        (p4: the open print edge to edge, the neighbours at 80%, on the cord;
 *                        nocord takes the cord away)
 *   ?lightbox=fade       the open print settles in the middle
 *                        (grow: it grows from its own place on the strip, and goes back there)
 *   Combine with a dash: ?lightbox=a1-p3-fade
 *
 * Moving: a swipe or a trackpad scrolls the wall natively (scroll-snap); a click on a waiting
 * year, the arrow keys, Home / End and a mouse wheel roll to it. Esc, the × and a click on
 * the ground close; the strip is left on the year the guest was looking at, and focus goes
 * to that print.
 *
 * Prototype shortcuts, to settle in the real build: the markup is made here (the labels are
 * typed in both languages below, not in the .po), the larger file is guessed from the crop's
 * name, and this is wired from about-drift.js so main.js stays untouched.
 *
 * @module team-lightbox
 */

import '../css/team-lightbox.css';

const ROLL_MS = 700;
const CLOSE_MS = 400; // team-lightbox.css → .is-closing

const X = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 5l14 14M19 5L5 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';

// --ease-gentle, solved for a scroll tween (how-it-feels.js → gentleEase; one copy when this is built)
function gentleEase(t) {
    const x1 = 0.33, y1 = 0.57, x2 = 0.08, y2 = 1.19;
    const bx = (u) => 3 * x1 * u * (1 - u) * (1 - u) + 3 * x2 * u * u * (1 - u) + u * u * u;
    const by = (u) => 3 * y1 * u * (1 - u) * (1 - u) + 3 * y2 * u * u * (1 - u) + u * u * u;
    let u = t;
    for (let i = 0; i < 6; i++) {
        const dx = 3 * x1 * (1 - u) * (1 - 3 * u) + 3 * x2 * u * (2 - 3 * u) + 3 * u * u;
        if (Math.abs(dx) < 1e-6) break;
        u = Math.min(1, Math.max(0, u - (bx(u) - t) / dx));
    }
    return by(u);
}

function readFlag() {
    const raw = new URLSearchParams(window.location.search).get('lightbox');
    if (raw === null) return null;
    const tokens = raw.toLowerCase().split(/[^a-z0-9]+/);
    return {
        blur: tokens.includes('a2'),
        bleed: !tokens.includes('p3'),
        cord: !tokens.includes('nocord'),
        grow: !tokens.includes('fade'),
    };
}

export function initTeamLightbox() {
    const flag = readFlag();
    const strip = document.querySelector('.about-team__drift');
    if (!flag || !strip) return;

    const sources = [...strip.querySelectorAll('.about-team__wall-card:not(.about-team__wall-card--tbc)')];
    if (!sources.length) return;

    const ru = document.documentElement.lang.toLowerCase().startsWith('ru');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    const column = window.matchMedia('(max-width: 767px)');

    let box = null;     // the dialog, made on the first opening
    let view = null;    // its scroller
    let cards = [];
    let current = -1;
    let isOpen = false;
    let rollRaf = 0;
    let wheelLock = 0;

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

    function build() {
        box = document.createElement('div');
        box.className = 'team-lightbox'
            + (flag.blur ? ' team-lightbox--blur' : '')
            + (flag.bleed ? ' team-lightbox--bleed' : '')
            + (flag.cord ? ' team-lightbox--cord' : '')
            + (flag.grow ? ' team-lightbox--grow' : ' team-lightbox--fade');
        box.setAttribute('role', 'dialog');
        box.setAttribute('aria-modal', 'true');
        box.setAttribute('aria-label', ru ? 'Командные фото по годам' : 'Team photos by year');
        box.tabIndex = -1; // a pointer's opening parks focus here: no ring lit by a click (mail-chooser.js)

        view = document.createElement('div');
        view.className = 'team-lightbox__view';
        const track = document.createElement('div');
        track.className = 'team-lightbox__track';

        cards = sources.map((source, i) => {
            const img = source.querySelector('img');
            const year = source.querySelector('.about-team__wall-pill span');
            const paprika = source.querySelector('.about-team__wall-pin--paprika');
            const card = document.createElement('button');
            card.type = 'button';
            card.className = 'team-lightbox__card ' + (source.classList.contains('about-team__wall-card--v2') ? 'team-lightbox__card--v2' : 'team-lightbox__card--v1');
            card.setAttribute('aria-label', img.alt);
            // The print is its own box inside the button: the flight below transforms it, and a
            // transformed snap target would drag the scroller after it
            card.innerHTML = `<span class="team-lightbox__print"><span class="team-lightbox__pin team-lightbox__pin--${paprika ? 'paprika' : 'lime'}"></span>`
                + `<span class="team-lightbox__photo"><img alt="" decoding="async"><span class="team-lightbox__pill"></span></span></span>`;
            card.querySelector('.team-lightbox__pill').textContent = year ? year.textContent.trim() : '';

            // The strip's crop is already in the cache: it is the picture on phones, and the
            // ground under the larger file elsewhere (the upload itself — guessed from the
            // crop's -WxH name, kept only if it loads)
            const small = img.currentSrc || img.src;
            const photo = card.querySelector('.team-lightbox__photo');
            const big = card.querySelector('img');
            const full = small.replace(/-\d+x\d+(?=\.\w+$)/, '');
            photo.style.backgroundImage = `url("${small}")`;
            if (column.matches || full === small) {
                big.src = small;
            } else {
                big.loading = 'lazy';
                big.addEventListener('error', () => { big.src = small; }, { once: true });
                big.src = full;
            }

            card.addEventListener('click', () => { if (i !== current) go(i); });
            track.append(card);
            return card;
        });

        const closeBtn = document.createElement('button');
        closeBtn.type = 'button';
        closeBtn.className = 'team-lightbox__close';
        closeBtn.setAttribute('aria-label', ru ? 'Закрыть' : 'Close');
        closeBtn.innerHTML = X;
        closeBtn.addEventListener('click', close);

        view.append(track);
        box.append(view, closeBtn);
        document.body.append(box);

        // A click on the ground — anywhere that is not a print — closes
        view.addEventListener('click', (e) => { if (!e.target.closest('.team-lightbox__card')) close(); });
        view.addEventListener('scroll', onScroll, { passive: true });
        view.addEventListener('wheel', onWheel, { passive: false });
        ['touchstart', 'pointerdown'].forEach((type) => view.addEventListener(type, cancelRoll, { passive: true }));
        box.addEventListener('keydown', onKey);
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
            const stops = [cards[current], box.querySelector('.team-lightbox__close')];
            const at = stops.indexOf(document.activeElement);
            e.preventDefault();
            stops[(at + (e.shiftKey ? stops.length - 1 : 1) + stops.length) % stops.length].focus({ preventScroll: true });
        }
    }

    // ── grow: the open print leaves from, and returns to, its place on the strip ──
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
        if (!box) build();
        isOpen = true;
        document.body.style.overflow = 'hidden';
        measure();
        current = -1;
        jump(i);

        box.classList.remove('is-closing');
        const card = cards[i];
        const print = printOf(card);
        if (flag.grow && !reducedMotion.matches) {
            print.classList.add('is-flying');
            print.style.transform = flightFrom(print, sources[i]);
            void print.offsetWidth; // the start is painted before the print lets go
            box.classList.add('is-open');
            requestAnimationFrame(() => {
                print.classList.remove('is-flying');
                print.style.transform = '';
            });
        } else {
            box.classList.add('is-open', 'is-opening');
            setTimeout(() => box.classList.remove('is-opening'), 900);
        }
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

        box.classList.remove('is-open', 'is-opening');
        if (flag.grow && !reducedMotion.matches) {
            box.classList.add('is-closing');
            print.style.transform = flightFrom(print, sources[i]);
            setTimeout(() => {
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
