/** Optional Google embeds. A dismissed notice is never treated as permission. */
export const MAP_PERMISSION_KEY = 'spMapPermission';
const VERSION = 1;
const LIFETIME = 180 * 24 * 60 * 60 * 1000;
let memory = null;
let storageFailed = false;

export function mapAllowed() {
    let value = memory;
    if (!storageFailed) {
        let raw;
        try { raw = localStorage.getItem(MAP_PERMISSION_KEY); } catch { /* blocked storage */ }
        if (raw !== undefined) {
            try { value = JSON.parse(raw); } catch { value = null; }
        }
    }
    return value?.version === VERSION && value.allowed === true &&
        Number.isFinite(value.expires) && value.expires > Date.now();
}

export function setMapPermission(allowed) {
    memory = { version: VERSION, allowed: allowed === true, expires: Date.now() + LIFETIME };
    try {
        localStorage.setItem(MAP_PERMISSION_KEY, JSON.stringify(memory));
        storageFailed = false;
    } catch { storageFailed = true; /* this page only */ }
    window.dispatchEvent(new Event('sp:map-permission'));
}

export function initMapPreferences() {
    const dialog = document.getElementById('map-preferences');
    if (!dialog) return;
    let opener;
    const status = dialog.querySelector('[data-map-status]');
    const update = () => {
        status.textContent = mapAllowed() ? status.dataset.allowed : status.dataset.blocked;
    };
    document.querySelectorAll('[data-map-settings]').forEach(button => {
        button.hidden = false;
        button.addEventListener('click', () => {
            opener = button;
            update();
            dialog.showModal();
        });
    });
    dialog.querySelectorAll('[data-map-choice]').forEach(button => {
        button.addEventListener('click', () => {
            setMapPermission(button.dataset.mapChoice === 'allow');
            dialog.close();
        });
    });
    dialog.addEventListener('close', () => opener?.focus());
    window.addEventListener('sp:map-permission', update);
    window.addEventListener('storage', event => {
        if (event.key === MAP_PERMISSION_KEY || event.key === null) {
            memory = null;
            storageFailed = false;
            window.dispatchEvent(new Event('sp:map-permission'));
        }
    });
    // A background tab must also drop embeds once the stored permission expires.
    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) window.dispatchEvent(new Event('sp:map-permission'));
    });
}
