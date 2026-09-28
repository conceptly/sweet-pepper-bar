import { mapAllowed, setMapPermission } from './map-permission';

const MAP_URL = 'https://www.google.com/maps/d/embed?mid=1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY&ehbc=2E312F';

export function initLocationMap() {
    const containers = [...document.querySelectorAll('.location__map, .contacts-map__embed')];
    const title = document.documentElement.lang.startsWith('ru') ? 'Sweet Pepper на карте' : 'Sweet Pepper Bar on the map';
    containers.forEach(container => {
        const button = container.querySelector('[data-map-allow]');
        if (button) {
            button.hidden = false;
            button.addEventListener('click', () => {
                setMapPermission(true);
                container.querySelector('iframe')?.focus();
            });
        }
    });
    // The message fades rather than cuts (privacy.css → states and easing): out once the map is
    // allowed, back in if maps are switched off; `hidden` follows when the fade has run.
    const fade = (placeholder, show) => {
        if (!placeholder || placeholder.hidden === !show && !placeholder.classList.contains('is-leaving')) return;
        if (show) {
            placeholder.hidden = false;
            placeholder.classList.add('is-leaving');
            placeholder.getBoundingClientRect(); // commit the faded state, then transition from it
            placeholder.classList.remove('is-leaving');
            return;
        }
        placeholder.classList.add('is-leaving');
        const done = () => { if (placeholder.classList.contains('is-leaving')) placeholder.hidden = true; };
        placeholder.addEventListener('transitionend', done, { once: true });
        setTimeout(done, 1200); // no transition (reduced motion) → no transitionend
    };
    function sync(event) {
        const allowed = mapAllowed();
        containers.forEach(container => {
            const placeholder = container.querySelector('.map-placeholder');
            const existing = container.querySelector('iframe');
            // On load the stored choice applies at once (no fade of a message the guest already
            // answered); a choice made on the page fades
            if (!event && placeholder) placeholder.hidden = allowed;
            else fade(placeholder, !allowed);
            if (!allowed) {
                existing?.remove();
                container.removeAttribute('aria-busy');
                document.querySelectorAll('[data-visit-routes] button').forEach(button => {
                    button.classList.remove('is-active');
                    button.setAttribute('aria-pressed', 'false');
                });
                return;
            }
            if (existing) return;
            const iframe = document.createElement('iframe');
            iframe.src = MAP_URL;
            iframe.title = title;
            iframe.referrerPolicy = 'no-referrer';
            iframe.allowFullscreen = true;
            // Fades in once Google's map has painted; a load that never reports still shows it
            iframe.classList.add('is-loading');
            const shown = () => iframe.classList.remove('is-loading');
            iframe.addEventListener('load', shown, { once: true });
            setTimeout(shown, 4000);
            container.dataset.provider = 'google';
            container.appendChild(iframe);
        });
    }
    window.addEventListener('sp:map-permission', sync);
    sync();
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
            if (!mapAllowed() || !iframe || map.dataset.provider !== 'google') {
                map.querySelector('[data-map-allow]')?.focus();
                return;
            }
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
