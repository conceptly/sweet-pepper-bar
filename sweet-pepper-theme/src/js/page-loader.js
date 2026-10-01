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
const FIRST_FOR = 1200;   // ms on a run's opening line — a 3 s wait still reaches a second one (author, 30 Sep 2026)
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
    const ru = document.documentElement.lang.toLowerCase().startsWith('ru');

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
    let k = -1;            // position in `order` of the line on show
    let opening = true;    // that line opened the run: it gets FIRST_FOR, every later one LINE_EVERY
    let shown = false;
    let armTimer = 0;
    let replay = null;     // { timer, from } while a replay runs
    let egg = 3;           // ON TRIAL: the replay is a toy (below) — 3 by default, `?egg=0|1|2` for the others
    let held = false;      // …and the guest has touched it: it no longer lifts by itself
    let dragging = false;
    let touched = false;   // …the slider itself: the hint has done its job
    let hintTimer = 0;

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
        opening = false;
        lineEl.classList.add('is-leaving');
        setTimeout(() => {
            lineEl.textContent = text;
            lineEl.classList.remove('is-leaving');
            lineEl.classList.add('is-entering');
            lineEl.offsetHeight; // commit the start before sliding in
            lineEl.classList.remove('is-entering');
        }, 180);
    }

    // A run opens on a pool line — the shuffled order's first (no fixed opener: «кухня работает»
    // showed while the kitchen was closed, author 30 Sep 2026), never the line just shown
    function openLine() {
        if (!lines.length) return;
        if (k >= 0) order = lineOrder(lines.length, chains, order[k]);
        k = 0;
        opening = true;
        lineEl.textContent = lines[order[0]];
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
        startLines(opening ? FIRST_FOR : LINE_EVERY); // a carried page is past its opening line
    }

    function hide() {
        shown = false;
        if (replay) {
            clearTimeout(replay.timer);
            const back = replay.from;
            replay = null;
            back?.focus({ preventScroll: true });
        }
        held = false;
        dragging = false;
        touched = false;
        clearTimeout(hintTimer);
        knob.classList.remove('is-hinting');
        cancelAnimationFrame(raf);
        clearTimeout(lineTimer);
        clearTimeout(armTimer);
        el.classList.remove('is-shown', 'is-carried', 'is-egg', 'is-egg-cta', 'is-egg-big', 'is-ready', 'is-dragging');
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
            else if (egg && replay) eggReady();              // the toy stays, and says it can be played with
            else if (!stay && !held) setTimeout(hide, HOLD); // `?loader=stay&done` keeps «Подано!» up
        };
        requestAnimationFrame(run);
    }

    /* ── This page opened under the loader (the part's inline script) ── */
    let carried = null;
    try { carried = JSON.parse(sessionStorage.getItem(KEY) || 'null'); } catch (e) { /* private mode */ }
    try { sessionStorage.removeItem(KEY); } catch (e) { /* private mode */ }

    // A carried run already shows the line it left on (the part's inline script); any other
    // run starts on a pool line
    const carriedRun = el.classList.contains('is-carried') && carried && carried.k >= 0
        && Array.isArray(carried.order) && carried.order.length === lines.length;
    if (!carriedRun) openLine();

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
        if (carriedRun) {
            order = carried.order;
            k = carried.k;
            opening = false;
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
        // PROTOTYPE `?egg=2|3`: once the guest plays, the label invites (Figma 2792:75652)
        labelEl.textContent = egg >= 2 && held ? (ru ? 'Выбирай огонёк!' : 'Pick your heat!') : labelEl.dataset.label;
    }

    /* ── ON TRIAL (1 Oct 2026): the footer's replay as a toy ──
       A tester tried to drag the knob in the replay — "like an Easter egg" (author). The
       replay can be played with. Layout 3 is the default (author); `?egg=1` and `?egg=2` show
       the other two for this browser tab, `?egg=0` the plain replay, `?egg=auto` lets go:
         · the show plays as before, but it stays on «Подано!»: the shaker and the × slide in
           and the knob nudges left and back — the hint, repeated until the slider is touched;
         · the knob drags at any time (or the track is tapped; ← → Home End): the name heats,
           the knob changes its daypart, every new daypart brings a new line, the end serves
           «Подано!», dragging back takes it off again. Touching it brings the controls in early;
         · the shaker (the dish picker's Shake It!, with its states), above the words at the
           column's left end, starts the show over with other lines; × (or Esc) goes back to
           the page — at the row's right end on desktops and tablets, in the top corner on
           phones;
         · `?egg=2`, wide screens only: instead of the row, two buttons under the name —
           «Назад» and «Встряхнуть!» — and the label turns to «Выбирай огонёк!» once the
           guest plays (the author's Figma frame 2792:75652); upright screens keep the row;
         · `?egg=3`, wide screens only: a big shaker centred above the slider, one button
           under the name — «Вернуться на сайт» — and × in the top corner (Figma 2792:75651);
         · on a touch screen or a phone-wide window, the footer's item turns to its heat look
           0.8 s after it comes into view (Figma NavItemsFooter → delay-mobile).
       Real waits between pages are not affected. The log is testing.md → Page loader. */
    try {
        const ask = params.get('egg');
        if (ask === 'auto') sessionStorage.removeItem('spLoaderEgg');
        else if (/^[0-3]$/.test(ask || '')) sessionStorage.setItem('spLoaderEgg', ask);
        const kept = sessionStorage.getItem('spLoaderEgg');
        if (kept !== null) egg = Number(kept);
    } catch (e) { /* private mode: the default */ }

    const slider = el.querySelector('.page-loader__slider');
    const SERVED_AT = 0.995;
    const HINT_EVERY = 4000;  // ms between the knob's nudges while nobody has touched it

    // The show is over (or the guest is already playing): bring the controls in
    function reveal() { el.classList.add('is-ready'); }

    function hint() {
        clearTimeout(hintTimer);
        if (touched || reduced() || !replay) return;
        knob.classList.remove('is-hinting');
        knob.offsetWidth;
        knob.classList.add('is-hinting');
        hintTimer = setTimeout(hint, HINT_EVERY);
    }

    function eggReady() {
        reveal();
        hintTimer = setTimeout(hint, 500); // after «Подано!» has filled
    }

    // The guest takes over: the show stops running itself
    function take() {
        held = true;
        cancelAnimationFrame(raf);
        clearTimeout(lineTimer);
        if (replay) clearTimeout(replay.timer);
        reveal();
        if (egg >= 2 && !labelEl.classList.contains('is-served')) resetWords();
    }

    // …by the slider: no more hints
    function takeSlider() {
        take();
        touched = true;
        clearTimeout(hintTimer);
        knob.classList.remove('is-hinting');
    }

    function drive(v) {
        const stop = knob.dataset.stop;
        const served = labelEl.classList.contains('is-served');
        setP(Math.max(0, Math.min(1, v)));
        if (knob.dataset.stop !== stop) nextLine();
        if (p >= SERVED_AT && !served) serve();
        else if (p < SERVED_AT && served) resetWords();
    }

    function again(btn) {
        take();
        clearTimeout(hintTimer);
        knob.classList.remove('is-hinting');
        resetWords();
        nextLine();
        btn.classList.remove('is-spinning');
        btn.offsetWidth;
        btn.classList.add('is-spinning');
        // the knob runs home, then the show plays again — and holds on «Подано!»
        const from = p;
        const start = performance.now();
        const home = (now) => {
            const x = Math.min(1, (now - start) / (reduced() ? 1 : 350));
            setP(from * Math.pow(1 - x, 3));
            if (x < 1) { raf = requestAnimationFrame(home); return; }
            if (!replay) return;
            startCreep(0);
            startLines(LINE_EVERY);
            replay.timer = setTimeout(finish, reduced() ? 3000 : REPLAY_FOR);
        };
        raf = requestAnimationFrame(home);
    }

    let controls = null;
    function eggControls() {
        if (controls) return;
        const main = [...document.scripts].find((sc) => /\/dist\/assets\/main-/.test(sc.src));
        const symbol = `${main ? main.src.split('/dist/assets/')[0] : ''}/assets/icons/sweetPepperLogo.svg`;
        const cross = '<svg viewBox="0 0 256 256" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M205.66,194.34a8,8,0,0,1-11.32,11.32L128,139.31,61.66,205.66a8,8,0,0,1-11.32-11.32L116.69,128,50.34,61.66A8,8,0,0,1,61.66,50.34L128,116.69l66.34-66.35a8,8,0,0,1,11.32,11.32L139.31,128Z"/></svg>';
        const arrow = '<svg viewBox="0 0 256 256" width="16" height="16" fill="currentColor" aria-hidden="true"><path d="M224,128a8,8,0,0,1-8,8H59.31l58.35,58.34a8,8,0,0,1-11.32,11.32l-72-72a8,8,0,0,1,0-11.32l72-72a8,8,0,0,1,11.32,11.32L59.31,120H216A8,8,0,0,1,224,128Z"/></svg>';
        const back = ru ? 'Вернуться на страницу' : 'Back to the page';
        // the row above the words: the shaker (the dish picker's markup, so its states) and the ×
        controls = document.createElement('div');
        controls.className = 'page-loader__again';
        controls.innerHTML =
            `<button type="button" class="dish-picker__shake-it page-loader__shake" aria-label="${ru ? 'Ещё раз' : 'Once more'}">`
            + `<span class="dish-picker__shake-disc"><span class="dish-picker__shake-icon"><img src="${symbol}" alt="" width="24" height="24"></span></span></button>`
            + `<button type="button" class="page-loader__close" aria-label="${back}">${cross}</button>`;
        el.querySelector('.page-loader__stage').before(controls);
        const [shake, close] = controls.children;
        shake.addEventListener('click', () => again(shake));
        close.addEventListener('click', hide);
        if (egg < 2) return;
        // the Figma buttons under the name (wide screens): 2 — back and shake; 3 — back alone
        const cta = document.createElement('div');
        cta.className = 'page-loader__cta';
        const backLabel = egg === 3 ? (ru ? 'Вернуться на сайт' : 'Back to the website') : (ru ? 'Назад' : 'Go back');
        cta.innerHTML =
            `<button type="button" class="btn btn-secondary${el.dataset.mode === 'night' ? ' btn-secondary--dark' : ''} page-loader__cta-back"><span class="btn-icon">${arrow}</span>${backLabel}</button>`
            + (egg === 2 ? `<button type="button" class="btn btn-primary-green page-loader__cta-shake"><span class="btn-icon"><img src="${symbol}" alt="" width="16" height="16"></span>${ru ? 'Встряхнуть!' : 'Shake it!'}</button>` : '');
        el.querySelector('.page-loader__word').after(cta);
        cta.children[0].addEventListener('click', hide);
        if (cta.children[1]) cta.children[1].addEventListener('click', () => again(cta.children[1]));
    }

    const at = (e) => { const r = slider.getBoundingClientRect(); return (e.clientX - r.left) / r.width; };
    slider.addEventListener('pointerdown', (e) => {
        if (!egg || !replay || e.button > 0) return;
        e.preventDefault();
        takeSlider();
        dragging = true;
        el.classList.add('is-dragging');
        try { slider.setPointerCapture(e.pointerId); } catch (err) { /* a synthetic pointer */ }
        drive(at(e));
    });
    slider.addEventListener('pointermove', (e) => { if (dragging) drive(at(e)); });
    ['pointerup', 'pointercancel'].forEach((type) => slider.addEventListener(type, () => {
        dragging = false;
        el.classList.remove('is-dragging');
    }));
    document.addEventListener('keydown', (e) => {
        if (!egg || !replay || !shown) return;
        const step = { ArrowLeft: -0.05, ArrowDown: -0.05, ArrowRight: 0.05, ArrowUp: 0.05 }[e.key];
        if (step) { e.preventDefault(); takeSlider(); drive(p + step); }
        else if (e.key === 'Home' || e.key === 'End') { e.preventDefault(); takeSlider(); drive(e.key === 'End' ? 1 : 0); }
    });

    // The footer's item where there is no hover to show its heat look — a touch screen, or a
    // phone-wide window (so a desktop's responsive mode shows it too): a beat after it shows.
    // Asked when it comes into view, not at load: the window may have been resized since.
    if (egg && 'IntersectionObserver' in window) {
        const heats = () => !window.matchMedia('(any-hover: hover)').matches || window.matchMedia('(max-width: 767px)').matches;
        document.querySelectorAll('[data-loader-replay]').forEach((btn) => {
            const io = new IntersectionObserver((entries) => {
                if (!entries[0].isIntersecting || !heats()) return;
                io.disconnect();
                setTimeout(() => btn.classList.add('is-heated'), 800);
            }, { threshold: 1 });
            io.observe(btn);
        });
    }

    /* ── Replay: the footer's button ── */
    function play(from) {
        if (shown) return;
        clearTimeout(lineTimer);
        resetWords();
        lineEl.classList.remove('is-leaving', 'is-entering');
        openLine();
        setP(0);
        replay = { from, timer: setTimeout(finish, reduced() ? 3000 : REPLAY_FOR) };
        show();
        if (egg) { eggControls(); el.classList.add('is-egg'); el.classList.toggle('is-egg-cta', egg >= 2); el.classList.toggle('is-egg-big', egg === 3); }
    }
    document.querySelectorAll('[data-loader-replay]').forEach((btn) => {
        btn.addEventListener('click', () => play(btn));
    });
    // a click on it serves at once
    el.addEventListener('click', () => {
        if (egg || !replay || labelEl.classList.contains('is-served')) return; // the toy closes by its ×
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
