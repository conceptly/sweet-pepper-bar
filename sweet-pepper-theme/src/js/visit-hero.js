/**
 * Visit Hero — Status Band State Engine
 *
 * Determines bar / kitchen state based on the bar's clock (bar-clock.js)
 * and updates the status band, state pills, and hours card heading.
 *
 * State matrix (from Figma statesContainer variants):
 *
 * Leads and labels: visit-page-copy-en.md → Desktop status lead / Bar and kitchen labels.
 * (The doc still flags the state timings themselves as needing reconciliation.)
 *
 *   Time          Bar           Kitchen          Band Lead
 *   08:30–22:00   open          on               Good news!
 *   22:00–01:00   open          last-orders      Still time to eat
 *   01:00–01:30   wrapping      bar-snacks       Winding down
 *   01:30–02:00   wrapping      closed           Winding down
 *   02:00–08:30   closed        closed           See you soon
 *   Sunday: closed till 10:00 (general cleaning)
 *
 * The door times above are the defaults; the real ones come from Bar Settings through
 * bar-clock.js, the same answer the reserve drawer and the home hero get.
 *
 * URL override: ?visit-state=open|last-orders|bar-snacks|last-call|closed
 *
 * The words are the page's (the Visit page's «Статус бара» tab, inc/visit-data.php →
 * sweet_pepper_visit_status()), handed over in the band's data-visit-words in the
 * request's language; the English below stands in if the attribute is missing.
 *
 * @package Sweet_Pepper
 */

import { getBarStatus } from './bar-clock.js';

/**
 * Determine bar and kitchen state from current Moscow time.
 *
 * @returns {{ bar: string, kitchen: string, lead: string }}
 */
function getVenueState() {
    // Allow URL override for testing: ?visit-state=closed
    const params = new URLSearchParams(window.location.search);
    const override = params.get('visit-state');
    if (override) {
        return getStateFromOverride(override);
    }

    // Doors: the bar's clock and the bar's hours (bar-clock.js ← Bar Settings).
    // Kitchen stages are still stated here.
    const { mins, open, opens } = getBarStatus();
    const t = mins / 60;

    if (!open) {
        return { bar: 'closed', kitchen: 'closed', lead: 'closed' };
    }
    // Open before today's opening = last night is still on
    const lastNight = mins < opens;

    // 22:00 – 01:00  →  bar open, kitchen last-orders
    if (t >= 22 || (lastNight && t < 1)) {
        return { bar: 'open', kitchen: 'last-orders', lead: 'last-orders' };
    }
    // 01:00 – 01:30  →  bar wrapping, kitchen bar-snacks
    if (lastNight && t < 1.5) {
        return { bar: 'wrapping', kitchen: 'bar-snacks', lead: 'winding' };
    }
    // 01:30 – close  →  bar wrapping, kitchen closed
    if (lastNight) {
        return { bar: 'wrapping', kitchen: 'closed', lead: 'winding' };
    }
    // opening – 22:00  →  bar open, kitchen on
    return { bar: 'open', kitchen: 'open', lead: 'open' };
}

/**
 * Manual state override for testing (URL param).
 */
function getStateFromOverride(key) {
    const states = {
        'open':         { bar: 'open',     kitchen: 'open',        lead: 'open' },
        'last-orders':  { bar: 'open',     kitchen: 'last-orders', lead: 'last-orders' },
        'bar-snacks':   { bar: 'open',     kitchen: 'bar-snacks',  lead: 'bar-snacks' },
        'last-call':    { bar: 'wrapping', kitchen: 'bar-snacks',  lead: 'winding' },
        'closed':       { bar: 'closed',   kitchen: 'closed',      lead: 'closed' },
    };
    return states[key] || states['open'];
}

/**
 * State → words: the band lead, the bar label, the kitchen label. English stand-ins for
 * a page without data-visit-words.
 */
const WORDS = {
    lead: {
        'open':        'Good news!',
        'last-orders': 'Still time to eat',
        'bar-snacks':  'Something to nibble',
        'winding':     'Winding down',
        'closed':      'See you soon',
    },
    bar: {
        'open':     "bar's open",
        'wrapping': "bar's winding down",
        'closed':   "bar's closed",
    },
    kitchen: {
        'open':        "kitchen's on",
        'last-orders': "last orders",
        'bar-snacks':  "bar snacks only",
        'closed':      "kitchen's closed",
    },
};

/**
 * The page's words over the stand-ins, group by group.
 */
function readWords(band) {
    try {
        const page = JSON.parse(band.dataset.visitWords || '{}');
        return {
            lead:    { ...WORDS.lead, ...page.lead },
            bar:     { ...WORDS.bar, ...page.bar },
            kitchen: { ...WORDS.kitchen, ...page.kitchen },
        };
    } catch (e) {
        return WORDS;
    }
}

/**
 * Apply the current state to the DOM.
 */
function updateVisitHero() {
    const band = document.querySelector('[data-visit-band]');
    if (!band) return;

    const state = getVenueState();
    const words = readWords(band);

    // Band lead word, and its copies in the phone rail
    const lead = words.lead[state.lead] || words.lead['open'];
    const leadEl = band.querySelector('[data-band-lead]');
    if (leadEl) leadEl.textContent = lead;
    document.querySelectorAll('[data-rail-lead]').forEach((el) => { el.textContent = lead; });

    // Bar / kitchen pills — the desktop band and every group of the phone rail
    // (the rail repeats the pair three times so it can run), so query the whole hero.
    const hero = band.closest('.visit-hero') || band;

    hero.querySelectorAll('[data-bar-state]').forEach((barPill) => {
        barPill.dataset.barState = state.bar;
        const label = barPill.querySelector('[data-bar-label]');
        if (label) label.textContent = words.bar[state.bar] || words.bar['open'];
    });

    hero.querySelectorAll('[data-kitchen-state]').forEach((kitchenPill) => {
        kitchenPill.dataset.kitchenState = state.kitchen;
        const label = kitchenPill.querySelector('[data-kitchen-label]');
        if (label) label.textContent = words.kitchen[state.kitchen] || words.kitchen['open'];
    });
}

/**
 * Phone rail speed: the loop runs a constant ~17 px/s — the pace the 22 s loop had with the
 * Russian daytime pair — whatever its words. The lead phrase (29 Sep 2026) and the state
 * labels change a group's width, so the duration follows the width. A no-op on desktop,
 * where the rail is display: none (width 0).
 */
const RAIL_SPEED = 17; // px per second
let railWidth = 0;
function syncRailSpeed() {
    const track = document.querySelector('[data-visit-rail] .visit-hero__rail-track');
    const group = track && track.querySelector('.visit-hero__rail-group');
    if (!group) return;
    const width = group.getBoundingClientRect().width;
    if (!width || Math.abs(width - railWidth) < 2) return;
    railWidth = width;
    track.style.animationDuration = `${(width / RAIL_SPEED).toFixed(2)}s`;
}

/**
 * Phone rail: any touch pauses the run for ~8s, then it resumes (idle-clock rule,
 * website-brief.md → Motion language). The CSS owns the animation; this only toggles
 * the class. Under prefers-reduced-motion the CSS never animates, so nothing to do.
 */
function initRailPause() {
    const rail = document.querySelector('[data-visit-rail]');
    if (!rail) return;

    let timer = null;
    rail.addEventListener('pointerdown', () => {
        rail.classList.add('is-paused');
        clearTimeout(timer);
        timer = setTimeout(() => rail.classList.remove('is-paused'), 8000);
    });
}

/**
 * Contact card: rests at 1° on phones and settles to 0° once it scrolls in
 * (visit-page-copy.md → Contact card → Motion). One-shot; the CSS transition does the move.
 * Desktop keeps its -1° / hover-to-0° in CSS — the class is harmless there.
 */
function initCardSettle() {
    const card = document.querySelector('.visit-hero__contacts-card');
    if (!card || !('IntersectionObserver' in window)) return;

    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            card.classList.add('is-settled');
            io.disconnect();
        });
    }, { threshold: 0.4 });

    io.observe(card);
}

/**
 * Public init function — called from main.js.
 */
export function initVisitHero() {
    // Only run on the Visit page
    if (!document.querySelector('.page-visit')) return;

    updateVisitHero();
    syncRailSpeed();
    initRailPause();
    initCardSettle();

    // Refresh every 60 seconds so the band stays current during long sessions
    setInterval(() => { updateVisitHero(); syncRailSpeed(); }, 60_000);
}
