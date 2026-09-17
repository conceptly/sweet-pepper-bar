/**
 * Visit Hero — Status Band State Engine
 *
 * Determines bar / kitchen state based on current time (Moscow tz)
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
 *
 * URL override: ?visit-state=open|last-orders|bar-snacks|last-call|closed
 *
 * @package Sweet_Pepper
 */

/**
 * Get the current Moscow-time hours and minutes.
 * Uses Intl API to reliably read Moscow time regardless of user's locale.
 */
function getMoscowTime() {
    const now = new Date();

    // Format in Moscow timezone
    const parts = new Intl.DateTimeFormat('en-GB', {
        timeZone: 'Europe/Moscow',
        hour: 'numeric',
        minute: 'numeric',
        hour12: false,
    }).formatToParts(now);

    const hour = parseInt(parts.find(p => p.type === 'hour').value, 10);
    const minute = parseInt(parts.find(p => p.type === 'minute').value, 10);

    return { hour, minute };
}

/**
 * Convert hour:minute to a decimal for easier range checks.
 * e.g. 13:30 → 13.5, 01:00 → 1.0
 */
function timeToDecimal(h, m) {
    return h + m / 60;
}

/**
 * Determine bar and kitchen state from current Moscow time.
 *
 * @returns {{ bar: string, kitchen: string, bandLead: string }}
 */
function getVenueState() {
    // Allow URL override for testing: ?visit-state=closed
    const params = new URLSearchParams(window.location.search);
    const override = params.get('visit-state');
    if (override) {
        return getStateFromOverride(override);
    }

    const { hour, minute } = getMoscowTime();
    const t = timeToDecimal(hour, minute);

    // 08:30 – 22:00  →  bar open, kitchen on
    if (t >= 8.5 && t < 22) {
        return { bar: 'open', kitchen: 'open', bandLead: 'Good news!' };
    }
    // 22:00 – 01:00  →  bar open, kitchen last-orders
    if (t >= 22 || (t >= 0 && t < 1)) {
        return { bar: 'open', kitchen: 'last-orders', bandLead: 'Still time to eat' };
    }
    // 01:00 – 01:30  →  bar wrapping, kitchen bar-snacks
    if (t >= 1 && t < 1.5) {
        return { bar: 'wrapping', kitchen: 'bar-snacks', bandLead: 'Winding down' };
    }
    // 01:30 – 02:00  →  bar wrapping, kitchen closed
    if (t >= 1.5 && t < 2) {
        return { bar: 'wrapping', kitchen: 'closed', bandLead: 'Winding down' };
    }
    // 02:00 – 08:30  →  closed
    return { bar: 'closed', kitchen: 'closed', bandLead: 'See you soon' };
}

/**
 * Manual state override for testing (URL param).
 */
function getStateFromOverride(key) {
    const states = {
        'open':         { bar: 'open',     kitchen: 'open',        bandLead: 'Good news!' },
        'last-orders':  { bar: 'open',     kitchen: 'last-orders', bandLead: 'Still time to eat' },
        'bar-snacks':   { bar: 'open',     kitchen: 'bar-snacks',  bandLead: 'Something to nibble' },
        'last-call':    { bar: 'wrapping', kitchen: 'bar-snacks',  bandLead: 'Winding down' },
        'closed':       { bar: 'closed',   kitchen: 'closed',      bandLead: 'See you soon' },
    };
    return states[key] || states['open'];
}

/**
 * Bar state → label text.
 */
const BAR_LABELS = {
    'open':     "bar's open",
    'wrapping': "bar's winding down",
    'closed':   "bar's closed",
};

/**
 * Kitchen state → label text.
 */
const KITCHEN_LABELS = {
    'open':        "kitchen's on",
    'last-orders': "kitchen last orders",
    'bar-snacks':  "bar snacks only",
    'closed':      "kitchen's closed",
};

/**
 * Apply the current state to the DOM.
 */
function updateVisitHero() {
    const band = document.querySelector('[data-visit-band]');
    if (!band) return;

    const state = getVenueState();

    // Band lead word
    const leadEl = band.querySelector('[data-band-lead]');
    if (leadEl) leadEl.textContent = state.bandLead;

    // Bar / kitchen pills — the desktop band and every group of the phone rail
    // (the rail repeats the pair three times so it can run), so query the whole hero.
    const hero = band.closest('.visit-hero') || band;

    hero.querySelectorAll('[data-bar-state]').forEach((barPill) => {
        barPill.dataset.barState = state.bar;
        const label = barPill.querySelector('[data-bar-label]');
        if (label) label.textContent = BAR_LABELS[state.bar] || BAR_LABELS['open'];
    });

    hero.querySelectorAll('[data-kitchen-state]').forEach((kitchenPill) => {
        kitchenPill.dataset.kitchenState = state.kitchen;
        const label = kitchenPill.querySelector('[data-kitchen-label]');
        if (label) label.textContent = KITCHEN_LABELS[state.kitchen] || KITCHEN_LABELS['open'];
    });
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
    initRailPause();
    initCardSettle();

    // Refresh every 60 seconds so the band stays current during long sessions
    setInterval(updateVisitHero, 60_000);
}
