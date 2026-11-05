/** Optional Google embeds. A dismissed notice is never treated as permission. */
export const MAP_PERMISSION_KEY = 'spMapPermission';
const VERSION = 1;
const LIFETIME = 180 * 24 * 60 * 60 * 1000;
let memory = null;
let storageFailed = false;

export function mapChoice() {
    let value = memory;
    if (!storageFailed) {
        let raw;
        try { raw = localStorage.getItem(MAP_PERMISSION_KEY); } catch { /* blocked storage */ }
        if (raw !== undefined) {
            try { value = JSON.parse(raw); } catch { value = null; }
        }
    }
    return value?.version === VERSION && typeof value.allowed === 'boolean' &&
        Number.isFinite(value.expires) && value.expires > Date.now() ? value : null;
}

export function mapAllowed() { return mapChoice()?.allowed === true; }

export function setMapPermission(allowed) {
    memory = { version: VERSION, allowed: allowed === true, expires: Date.now() + LIFETIME };
    try {
        localStorage.setItem(MAP_PERMISSION_KEY, JSON.stringify(memory));
        storageFailed = false;
    } catch { storageFailed = true; /* this page only */ }
    window.dispatchEvent(new Event('sp:map-permission'));
}

export function initMapPreferences() {
    let expiryTimer;
    const update = () => {
        clearTimeout(expiryTimer);
        const choice = mapChoice();
        if (choice?.allowed) expiryTimer = setTimeout(() => {
            window.dispatchEvent(new Event('sp:map-permission'));
        }, Math.min(choice.expires - Date.now() + 1, 86400000));
    };
    window.addEventListener('sp:map-permission', update);
    update();
    window.addEventListener('storage', event => {
        if (event.key === MAP_PERMISSION_KEY || event.key === null) {
            memory = null;
            storageFailed = false;
            window.dispatchEvent(new Event('sp:map-permission'));
        }
    });
    window.addEventListener('pageshow', () => window.dispatchEvent(new Event('sp:map-permission')));
    // A background tab must also drop embeds once the stored permission expires.
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) window.dispatchEvent(new Event('sp:map-permission'));
    });
}
