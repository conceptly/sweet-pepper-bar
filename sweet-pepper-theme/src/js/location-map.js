/**
 * Location Map — geo-detected provider (Google Maps vs Yandex Maps)
 *
 * Selects map provider based on user's timezone and language:
 * - Russian timezones or ru-* language → Yandex Maps
 * - Everyone else → Google Maps (custom styled map)
 *
 * Google uses a custom "My Maps" embed (same as home page).
 * Yandex uses the map-widget embed. No API keys needed.
 */

const MAP_URLS = {
    // Custom-styled Google My Map (matches home page contacts section)
    google: 'https://www.google.com/maps/d/embed?mid=1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY&ehbc=2E312F',
    // Yandex Maps widget — Kirova 10/25, Yaroslavl
    yandex: 'https://yandex.ru/map-widget/v1/?ll=39.8845%2C57.6261&z=16&pt=39.8845%2C57.6261%2Cpm2rdm',
};

/**
 * Detect whether the user is likely Russian based on timezone and language.
 */
function isRussianLocale() {
    // Check timezone
    const tz = Intl.DateTimeFormat().resolvedOptions().timeZone || '';
    const russianTZPrefixes = [
        'Europe/Moscow', 'Europe/Samara', 'Europe/Volgograd',
        'Europe/Kaliningrad', 'Europe/Kirov', 'Europe/Saratov',
        'Europe/Astrakhan', 'Europe/Ulyanovsk',
        'Asia/Yekaterinburg', 'Asia/Omsk', 'Asia/Krasnoyarsk',
        'Asia/Irkutsk', 'Asia/Yakutsk', 'Asia/Vladivostok',
        'Asia/Magadan', 'Asia/Kamchatka', 'Asia/Sakhalin',
        'Asia/Srednekolymsk', 'Asia/Anadyr',
    ];
    if (russianTZPrefixes.some(p => tz.startsWith(p))) return true;

    // Fallback: navigator.language
    const lang = (navigator.language || '').toLowerCase();
    return lang.startsWith('ru');
}

/**
 * Initialize the location map.
 * Finds the map container and injects the appropriate iframe.
 */
export function initLocationMap() {
    const containers = document.querySelectorAll('.location__map, #about-map, .about-location__map');
    if (!containers.length) return;

    containers.forEach(container => {
        if (container.querySelector('iframe')) return;

        const provider = isRussianLocale() ? 'yandex' : 'google';
        const url = MAP_URLS[provider];

        const iframe = document.createElement('iframe');
        // Eager on purpose (Sep 2026): a script-inserted iframe with loading="lazy"
        // is only fetched once the browser decides it is near the viewport, and that
        // check is unreliable for inserted frames (WebKit) and stalls entirely in a
        // hidden document — the container then shows as an empty dark box. The map is
        // the page's last block; one eager embed per view is what the home page's
        // Contacts map already costs.
        iframe.src = url;
        iframe.allowFullscreen = true;
        iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
        // The page's language, not a string from PHP: the embed is built here (25 Sep 2026)
        iframe.setAttribute('title', document.documentElement.lang.startsWith('ru') ? 'Sweet Pepper на карте' : 'Sweet Pepper Bar on the map');

        container.dataset.provider = provider;
        container.appendChild(iframe);
    });
}

/**
 * Visit page — landmark badges swap the map for a route (Sep 2026).
 *
 * Each badge carries the mid of a Google My Map whose walking-route layer is on by
 * default; tapping it reloads the embed with that map. A My Maps iframe is
 * cross-origin, so its own layer checkboxes cannot be toggled from the page — one
 * map per route is the only handle there is. Google embeds only: when the map is
 * the Yandex widget (RU guests) the badges stay as they are and do nothing.
 */
export function initVisitMapRoutes() {
    const list = document.querySelector('[data-visit-routes]');
    const map  = document.querySelector('.visit-location .location__map');
    if (!list || !map) return;

    const buttons = list.querySelectorAll('button[data-map-mid]');
    if (!buttons.length) return;

    buttons.forEach((btn) => {
        btn.addEventListener('click', () => {
            const iframe = map.querySelector('iframe');
            if (!iframe || map.dataset.provider !== 'google') return;
            if (btn.classList.contains('is-active')) return;

            buttons.forEach((b) => {
                const on = b === btn;
                b.classList.toggle('is-active', on);
                b.setAttribute('aria-pressed', on ? 'true' : 'false');
            });

            map.setAttribute('aria-busy', 'true');
            iframe.addEventListener('load', () => map.removeAttribute('aria-busy'), { once: true });
            iframe.src = 'https://www.google.com/maps/d/embed?mid=' + encodeURIComponent(btn.dataset.mapMid) + '&ehbc=2E312F';
        });
    });
}
