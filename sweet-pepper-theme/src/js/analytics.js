/** Metrica is optional: no script, pixel or queued hit before explicit consent. */
export const ANALYTICS_KEY = 'spAnalyticsPermission';
const VERSION = 1;
const LIFETIME = 180 * 24 * 60 * 60 * 1000;
const COUNTER = 113329976;
let memory = null;
let storageFailed = false;

export function analyticsChoice() {
    let value = memory;
    if (!storageFailed) {
        try { value = JSON.parse(localStorage.getItem(ANALYTICS_KEY)); }
        catch { value = null; }
    }
    return value?.version === VERSION && typeof value.allowed === 'boolean' &&
        Number.isFinite(value.expires) && value.expires > Date.now() ? value : null;
}

export function setAnalyticsPermission(allowed) {
    memory = { version: VERSION, allowed: allowed === true, expires: Date.now() + LIFETIME };
    try {
        localStorage.setItem(ANALYTICS_KEY, JSON.stringify(memory));
        storageFailed = false;
    } catch { storageFailed = true; }
    window.dispatchEvent(new Event('sp:analytics-permission'));
}

export function initAnalytics() {
    // Local/staging and logged-in pages never send production statistics.
    const production = location.hostname === 'sweetpepper.bar' && !document.body.classList.contains('logged-in');
    let loading = false;
    let ready = false;
    let active = false;
    let stopped = false;
    let expiryTimer;

    function maskFields(root = document) {
        const fields = root.matches?.('input, textarea') ? [root] : root.querySelectorAll('input, textarea');
        fields.forEach(field => {
            field.classList.remove('ym-record-keys');
            field.classList.add('ym-disable-keys');
        });
    }
    // Fields added later are masked too, but only while Metrica can record: the clock, the
    // odometers and the scrambles mutate the DOM every frame, so only added elements are read.
    let observer;
    function watchFields() {
        if (observer) return;
        observer = new MutationObserver(records => records.forEach(record => {
            record.addedNodes.forEach(node => { if (node.nodeType === 1) maskFields(node); });
        }));
        observer.observe(document.body, { childList: true, subtree: true });
    }

    function start() {
        if (active || !production || !analyticsChoice()?.allowed) return;
        // A fresh page is more reliable than restarting a destroyed third-party recorder.
        if (stopped) { location.reload(); return; }
        if (!ready) {
            if (loading) return;
            loading = true;
            const script = document.createElement('script');
            script.async = true;
            script.src = `https://mc.yandex.ru/metrika/tag.js?id=${COUNTER}`;
            window.ym = window.ym || function () { (window.ym.a = window.ym.a || []).push(arguments); };
            window.ym.l = Date.now();
            script.onload = () => { ready = true; loading = false; start(); };
            script.onerror = () => { loading = false; script.remove(); };
            document.head.append(script);
            return;
        }
        maskFields();
        watchFields();
        window.ym(COUNTER, 'init', {
            ssr: true, webvisor: true, clickmap: true,
            referrer: document.referrer, url: location.href,
            accurateTrackBounce: true, trackLinks: true,
            ecommerce: false, disableYtm: true,
        });
        active = true;
    }

    function update() {
        const choice = analyticsChoice();
        clearTimeout(expiryTimer);
        if (choice?.allowed) {
            start();
            // setTimeout is capped at ~24 days; recheck long-lived tabs in daily slices.
            expiryTimer = setTimeout(update, Math.min(choice.expires - Date.now() + 1, 86400000));
        } else if (active) {
            window.ym(COUNTER, 'destruct');
            active = false;
            stopped = true;
        }
    }
    window.addEventListener('sp:analytics-permission', update);
    window.addEventListener('storage', event => {
        if (event.key === ANALYTICS_KEY || event.key === null) {
            memory = null;
            storageFailed = false;
            window.dispatchEvent(new Event('sp:analytics-permission'));
        }
    });
    document.addEventListener('visibilitychange', () => { if (!document.hidden) update(); });
    window.addEventListener('pageshow', update);
    update();
}
