/**
 * Location Map — Google My Maps for every guest (27 Sep 2026).
 *
 * Until this date the provider was picked by the visitor's timezone and language: Russian
 * zones and ru-* got the Yandex widget, everyone else the custom Google My Map. The team
 * checked the Google embed from Russia on 27 Sep 2026 and it works, and the walking routes
 * on the Visit page are Google My Maps (one map per landmark, initVisitMapRoutes below),
 * which the Yandex widget could never show — so Google is the one map, on both languages.
 * The `TEST_PROVIDER` switch and the `?map=` override that carried the test are gone.
 */

const MAP_URL = 'https://www.google.com/maps/d/embed?mid=1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY&ehbc=2E312F';

/**
 * Initialize the location map.
 * Finds the map container and injects the iframe.
 */
export function initLocationMap() {
    const containers = document.querySelectorAll('.location__map, #about-map, .about-location__map');
    if (!containers.length) return;

    containers.forEach(container => {
        if (container.querySelector('iframe')) return;

        const iframe = document.createElement('iframe');
        // Eager on purpose (Sep 2026): a script-inserted iframe with loading="lazy"
        // is only fetched once the browser decides it is near the viewport, and that
        // check is unreliable for inserted frames (WebKit) and stalls entirely in a
        // hidden document — the container then shows as an empty dark box. The map is
        // the page's last block; one eager embed per view is what the home page's
        // Contacts map already costs.
        iframe.src = MAP_URL;
        iframe.allowFullscreen = true;
        iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');
        // The page's language, not a string from PHP: the embed is built here (25 Sep 2026)
        iframe.setAttribute('title', document.documentElement.lang.startsWith('ru') ? 'Sweet Pepper на карте' : 'Sweet Pepper Bar on the map');

        container.dataset.provider = 'google';
        container.appendChild(iframe);
    });
}

/**
 * Visit page — landmark badges swap the map for a route (Sep 2026).
 *
 * Each badge carries the mid of a Google My Map whose walking-route layer is on by
 * default; tapping it reloads the embed with that map. A My Maps iframe is
 * cross-origin, so its own layer checkboxes cannot be toggled from the page — one
 * map per route is the only handle there is. (Google embeds only — the Yandex widget
 * that Russian guests got until 27 Sep 2026 had no routes; the map is Google for
 * everyone now.)
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
