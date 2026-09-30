/**
 * Page loader — the heat slider while the next page is slow (inc/page-loader.php; its
 * switches for checking are listed there).
 *
 * The page being LEFT: a click on an ordinary link arms a timer; if the navigation is still
 * pending after SHOW_AFTER, the loader fades in and the knob creeps along the track. There
 * is no real progress to read — the browser doesn't give one — so the creep slows as it
 * goes (CAP · (1 − e^(−t/TAU))) and never arrives on its own. The knob changes its daypart
 * on the way (breakfast → lunch → dinner → party, a quarter each) with a small pop, and a new
 * line takes the right side after FIRST_FOR, then every LINE_EVERY.
 * On pagehide it leaves its place in sessionStorage for the next page.
 *
 * The page ARRIVED AT: the part's inline script has already opened the loader in the same
 * place; here it keeps creeping until the page has loaded (at most FINISH_BY), then runs to
 * the end — «Подано!», its letters going outline → fill one after another (the hero slider's
 * stop-label transition, website-brief.md) — holds a beat and lifts.
 *
 * REPLAY (the footer's «Поддать жару!», any [data-loader-replay]): the whole show on the spot,
 * no navigation — REPLAY_FOR of creep and lines, then «Подано!» and it lifts. A click on it
 * or Esc ends it early; focus goes back to the button.
 *
 * A navigation that never leaves (a download, a stopped load) would strand it: SAFETY after
 * showing, it lifts on its own.
 *
 * Reduced motion: no creep and one line; the knob waits at the middle and jumps to the end.
 */

const KEY = 'spLoader';
const SHOW_AFTER = 700;   // ms — a navigation faster than this never sees the loader
const CAP = 0.9;          // the creep's ceiling: the last tenth is the page's to give
const TAU = 3000;         // ms — the creep's pace (half the track ≈ 3 s)
const FIRST_FOR = 1200;   // ms on the first line — a 3 s wait still reaches a second one (author, 30 Sep 2026)
const LINE_EVERY = 2200;  // ms per line after it
const FINISH_BY = 2500;   // ms — the new page lifts the loader by then, loaded or not
const RUN_OUT = 450;      // ms — the knob's run to the end
const HOLD = 650;         // ms on «Подано!» before it lifts — the letters fill in this time
const LETTER = 40;        // ms between the letters of «Подано!»
const SAFETY = 20000;     // ms — the leaving page gives up and lifts it
const REPLAY_FOR = 6500;  // ms of creep before a replay serves — long enough for three lines

const reduced = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;
const stopFor = (p) => (p < 0.25 ? 'breakfast' : p < 0.5 ? 'lunch' : p < 0.75 ? 'dinner' : 'party');

function shuffle(a) {
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}

/* A shuffled order of line positions in which each chain (data-chains: runs of positions,
   data/page-loader.php → an array) stays whole and in order. `avoid` is a position that
   must not come first — the line just shown, so no line appears twice in a row. */
function lineOrder(n, chains, avoid = -1) {
    const head = new Map();
    const tail = new Set();
    chains.forEach((c) => { head.set(c[0], c); c.slice(1).forEach((i) => tail.add(i)); });
    const units = [];
    for (let i = 0; i < n; i++) {
        if (tail.has(i)) continue;
        units.push(head.get(i) || [i]);
    }
    for (let tries = 0; tries < 5; tries++) {
        const order = shuffle(units.slice()).flat();
        if (order[0] !== avoid || units.length < 2) return order;
    }
    return shuffle(units.slice()).flat();
}

export function initPageLoader() {
    const el = document.querySelector('[data-page-loader]');
    if (!el) return;

    const knob = el.querySelector('.page-loader__knob');
    const romb = el.querySelector('.page-loader__romb');
    const lineEl = el.querySelector('.page-loader__line');
    const labelEl = el.querySelector('.page-loader__label');
    const lines = JSON.parse(el.dataset.lines || '[]');
    const chains = JSON.parse(el.dataset.chains || '[]');

    let p = 0;
    let t0 = 0;            // the creep's clock: performance.now() at p = 0
    let raf = 0;
    let lineTimer = 0;
    let order = lineOrder(lines.length, chains);
    let k = -1;            // position in `order`; −1 = the first line
    let shown = false;
    let armTimer = 0;
    let replay = null;     // { timer, from } while a replay runs

    function setP(v) {
        p = v;
        el.style.setProperty('--p', v.toFixed(4));
        const stop = stopFor(v);
        if (knob.dataset.stop !== stop) {
            knob.dataset.stop = stop;
            // the new daypart arrives with a pop (not in reduced motion)
            if (!reduced()) {
                romb.classList.remove('is-popping');
                romb.offsetWidth;
                romb.classList.add('is-popping');
            }
        }
    }

    function creep(now) {
        setP(CAP * (1 - Math.exp(-(now - t0) / TAU)));
        raf = requestAnimationFrame(creep);
    }

    function startCreep(from = 0) {
        if (reduced()) { setP(0.5); return; }
        // pick the clock up where `from` sits on the curve
        t0 = performance.now() + TAU * Math.log(1 - Math.min(from, CAP - 0.001) / CAP);
        cancelAnimationFrame(raf);
        raf = requestAnimationFrame(creep);
    }

    function nextLine() {
        if (!lines.length) return;
        k = (k + 1) % order.length;
        if (k === 0 && order.length > 1) {
            order = lineOrder(lines.length, chains, order[order.length - 1]); // no line twice in a row
        }
        const text = lines[order[k]];
        lineEl.classList.add('is-leaving');
        setTimeout(() => {
            lineEl.textContent = text;
            lineEl.classList.remove('is-leaving');
            lineEl.classList.add('is-entering');
            lineEl.offsetHeight; // commit the start before sliding in
            lineEl.classList.remove('is-entering');
        }, 180);
    }

    function startLines(first = FIRST_FOR) {
        clearTimeout(lineTimer);
        if (reduced()) return;
        const tick = (wait) => { lineTimer = setTimeout(() => { nextLine(); tick(LINE_EVERY); }, wait); };
        tick(first);
    }

    // «Подано!»: each letter its own span, outline first, then filled one after another
    function serve() {
        const text = el.dataset.done;
        labelEl.textContent = '';
        labelEl.setAttribute('aria-label', text);
        [...text].forEach((ch, i) => {
            const span = document.createElement('span');
            span.className = 'page-loader__letter';
            span.textContent = ch;
            span.style.transitionDelay = `${i * LETTER}ms`;
            span.setAttribute('aria-hidden', 'true');
            labelEl.append(span);
        });
        labelEl.classList.add('is-served');
        labelEl.offsetWidth;
        requestAnimationFrame(() => labelEl.classList.add('is-filled'));
    }

    function show({ fade = true, from = 0 } = {}) {
        shown = true;
        if (el.spMode) el.dataset.mode = el.spMode(); // the hour may have turned since the page opened
        el.hidden = false;
        el.classList.add('is-owned');
        if (fade) {
            el.offsetHeight;
            el.classList.add('is-shown');
        }
        startCreep(from);
        startLines(k < 0 ? FIRST_FOR : LINE_EVERY); // a carried page is past its first line
    }

    function hide() {
        shown = false;
        if (replay) {
            clearTimeout(replay.timer);
            const back = replay.from;
            replay = null;
            back?.focus({ preventScroll: true });
        }
        cancelAnimationFrame(raf);
        clearTimeout(lineTimer);
        clearTimeout(armTimer);
        el.classList.remove('is-shown', 'is-carried');
        document.documentElement.classList.remove('is-page-loading');
        setTimeout(() => { if (!shown) el.hidden = true; }, 260);
    }

    function finish() {
        cancelAnimationFrame(raf);
        clearTimeout(lineTimer);
        serve();
        const from = p;
        const start = performance.now();
        const run = (now) => {
            const x = Math.min(1, (now - start) / (reduced() ? 1 : RUN_OUT));
            setP(from + (1 - from) * (1 - Math.pow(1 - x, 3)));
            if (x < 1) requestAnimationFrame(run);
            else if (!stay) setTimeout(hide, HOLD); // `?loader=stay&done` keeps «Подано!» up
        };
        requestAnimationFrame(run);
    }

    /* ── This page opened under the loader (the part's inline script) ── */
    let carried = null;
    try { carried = JSON.parse(sessionStorage.getItem(KEY) || 'null'); } catch (e) { /* private mode */ }
    try { sessionStorage.removeItem(KEY); } catch (e) { /* private mode */ }

    const params = new URLSearchParams(location.search);
    const stay = params.get('loader') === 'stay';
    if (stay) {
        // a look at the design: open, creep (or park at &p=), never finish; Esc lifts it
        el.classList.add('is-carried');
        show({ fade: false });
        el.classList.add('is-shown');
        if (params.has('p')) { cancelAnimationFrame(raf); setP(Math.max(0, Math.min(1, Number(params.get('p'))))); }
        if (params.has('done')) setTimeout(finish, 1200); // run to the end and hold «Подано!»
    } else if (el.classList.contains('is-carried') && carried) {
        if (Array.isArray(carried.order) && carried.order.length === lines.length) {
            order = carried.order;
            k = carried.k ?? -1;
        }
        show({ fade: false, from: Number(carried.p) || 0 });
        el.classList.add('is-shown');
        const began = performance.now();
        const done = () => setTimeout(finish, Math.max(0, 300 - (performance.now() - began)));
        const by = setTimeout(done, FINISH_BY);
        if (document.readyState === 'complete') { clearTimeout(by); done(); }
        else window.addEventListener('load', () => { clearTimeout(by); done(); }, { once: true });
    }

    // Back to the words a run starts with (a finished run leaves «Подано!» letters behind)
    function resetWords() {
        labelEl.classList.remove('is-served', 'is-filled');
        labelEl.removeAttribute('aria-label');
        labelEl.textContent = labelEl.dataset.label;
    }

    /* ── Replay: the footer's button ── */
    function play(from) {
        if (shown) return;
        clearTimeout(lineTimer);
        resetWords();
        k = -1;
        lineEl.classList.remove('is-leaving', 'is-entering');
        lineEl.textContent = lineEl.dataset.first;
        setP(0);
        replay = { from, timer: setTimeout(finish, reduced() ? 3000 : REPLAY_FOR) };
        show();
    }
    document.querySelectorAll('[data-loader-replay]').forEach((btn) => {
        btn.addEventListener('click', () => play(btn));
    });
    // a click on it serves at once
    el.addEventListener('click', () => {
        if (!replay || labelEl.classList.contains('is-served')) return;
        clearTimeout(replay.timer);
        finish();
    });

    /* ── Leaving: arm on a click that will navigate ── */
    window.addEventListener('click', (e) => {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        const a = e.target.closest?.('a[href]');
        if (!a || a.hasAttribute('download') || (a.target && a.target !== '_self')) return;
        const url = new URL(a.href, location.href);
        if (!/^https?:$/.test(url.protocol) || url.origin !== location.origin) return;
        if (url.pathname === location.pathname && url.search === location.search && url.hash) return; // same page, an anchor
        clearTimeout(armTimer);
        armTimer = setTimeout(() => {
            resetWords();
            show();
            armTimer = setTimeout(() => { if (shown && !replay) hide(); }, SAFETY);
        }, SHOW_AFTER);
    });

    labelEl.dataset.label = labelEl.textContent;
    lineEl.dataset.first = lineEl.textContent;

    window.addEventListener('pagehide', () => {
        clearTimeout(armTimer);
        try {
            if (shown && !stay && p < 1) {
                sessionStorage.setItem(KEY, JSON.stringify({ p, stop: stopFor(p), line: order[k] ?? -1, order, k, at: Date.now() }));
            }
        } catch (e) { /* private mode */ }
    });

    // Back / Forward restores this page from memory with the loader still up: lift it
    window.addEventListener('pageshow', (e) => { if (e.persisted && shown) hide(); });

    // Esc: the guest stopped the navigation (or wants the page back)
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && shown) hide(); });
}
