/**
 * Menu nav bar — the phone menu page's navigation (default since 1 Oct 2026, on trial).
 *
 * Phones and tablets (≤ 991px): the jump-nav drawer gets an opener that stays in reach —
 * the drawer's own sheet, peeking at the foot of the screen: the Lime edge, the hero's
 * opener (kebab + label) at the left edge, where the hero has it and where the drawer
 * comes in from, and the word of the section on show at the right. One target; it opens
 * the same drawer (menu-jump-nav.js), which from here marks the section on show and lands
 * on the section picked. Each section's headline is a plain headline (menu-nav-bar.css).
 *
 * The house yield rule (website-brief.md → Top nav → Mobile): the bar waits while the
 * hero's own opener is in view, and leaves with the last menu block (the pairing station) —
 * the entrance photo, Location, the closer's Reserve and the footer never share the screen
 * with it.
 *
 * DRAFT kept for the device comparison — `?nav=rail`: the earlier navigation, the sticky
 * rail of section words in every headline, with its entrance and nudge (menu-section.css,
 * menu-rail-nudge.js) and no bar. Remembered for the visit (sessionStorage), so it
 * survives the door to the other menu; `?nav=edge` returns to the default. It is switched
 * by `html.nav-rail`, set here — so this must run before initMenuRailNudge (it runs only
 * under that class) and before initMenuJumpNav (it binds the openers it finds).
 */

const KEY = 'spNavDraft';
const HEADER = 76; // the fixed header (≤ 991px)

export function initMenuNavBar() {
    const hero = document.querySelector('.menu-hero');
    const heroOpener = hero && hero.querySelector('.menu-hero__open');
    if (!hero || !heroOpener) return;

    const asked = new URLSearchParams(window.location.search).get('nav');
    let rail = asked === 'rail';
    try {
        if (asked === 'rail') sessionStorage.setItem(KEY, 'rail');
        else if (asked) sessionStorage.removeItem(KEY);
        else rail = sessionStorage.getItem(KEY) === 'rail';
    } catch (e) { /* private mode: the flag lives on the URL only */ }
    if (rail) {
        document.documentElement.classList.add('nav-rail');
        return;
    }

    const kebab = heroOpener.querySelector('svg');
    const bar = document.createElement('button');
    bar.type = 'button';
    bar.className = 'menu-nav-bar js-menu-jump-open';
    bar.setAttribute('aria-haspopup', 'dialog');
    bar.setAttribute('aria-controls', 'menu-jump-panel');
    bar.setAttribute('aria-expanded', 'false');
    bar.innerHTML =
        '<span class="menu-nav-bar__more">' + (kebab ? kebab.outerHTML : '') +
        '<span class="menu-nav-bar__label"></span></span>' +
        '<span class="menu-nav-bar__word molot-text"></span>';
    const word = bar.querySelector('.menu-nav-bar__word');
    const label = bar.querySelector('.menu-nav-bar__label');
    label.textContent = heroOpener.textContent.trim();
    document.body.appendChild(bar);

    // ── The word: the section on show (Chili — a headline's first line, menu-nav-bar.css) ──
    function sync() {
        const sec = document.querySelector('section.menu-section.is-current');
        const h2 = sec && sec.querySelector('.menu-section-rail__current');
        if (!h2) return;
        const short = h2.querySelector('.menu-section-rail__short');
        word.textContent = (short || h2).textContent.trim();
        // A long word beside a long label (БЕЗ АЛКОГОЛЯ · Вся барная карта): the label steps
        // aside and the kebab alone says "more"
        bar.classList.remove('is-tight');
        bar.classList.toggle('is-tight', word.scrollWidth > word.clientWidth);
    }

    // ── Yield: after the hero's opener, until the last menu block has gone up ──
    const blocks = document.querySelectorAll('main section.menu-section, main section.menu-pairing-station');
    const lastBlock = () => {
        for (let i = blocks.length - 1; i >= 0; i--) if (blocks[i].offsetParent) return blocks[i];
        return null;
    };

    function place() {
        const last = lastBlock();
        const past = heroOpener.getBoundingClientRect().bottom < HEADER;
        const more = last && last.getBoundingClientRect().bottom > window.innerHeight - bar.offsetHeight;
        bar.classList.toggle('is-visible', !!(past && more));
    }

    let queued = false;
    const look = () => {
        if (queued) return;
        queued = true;
        requestAnimationFrame(() => { queued = false; place(); });
    };

    document.addEventListener('menu-section:change', () => { sync(); look(); });
    window.addEventListener('scroll', look, { passive: true });
    window.addEventListener('resize', () => { sync(); look(); });
    if (document.fonts && document.fonts.ready) document.fonts.ready.then(sync); // Molot's width decides is-tight
    sync();
    look();
}
