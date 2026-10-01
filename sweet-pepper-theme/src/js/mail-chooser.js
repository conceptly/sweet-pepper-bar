/**
 * Mail chooser — what an e-mail link does on a desktop (live since 30 Sep 2026;
 * template-parts/components/mail-chooser.php has the why).
 *
 * A desktop click on any `mailto:` link opens the chooser instead of the mail app: a compact
 * list hung under the clicked link, the page still in view (the author's pick over a centred
 * modal of the Figma frame, 30 Sep 2026 — "less distracting"). Each webmail opens a new
 * letter in a new tab, addressed (and with the link's subject); the app row is the original
 * `mailto:` under the name of this computer's default app; the address row is the site's
 * contact item, whose chip copies (contact-form.js → initContactItemCopy). Phones and tablets
 * keep `mailto:` — the chooser needs a mouse or trackpad.
 */

const COMPOSE = {
    gmail: (to, su) => `https://mail.google.com/mail/?view=cm&fs=1&to=${to}${su ? `&su=${su}` : ''}`,
    // unofficial links — both tested by the author, 30 Sep 2026 (the composer opens, addressed)
    yandex: (to, su) => `https://mail.yandex.ru/compose?to=${to}${su ? `&subject=${su}` : ''}`,
    mailru: (to, su) => `https://e.mail.ru/compose/?To=${to}${su ? `&Subject=${su}` : ''}`,
};

export function initMailChooser() {
    const box = document.querySelector('[data-mail-chooser]');
    if (!box) return;
    const desktop = window.matchMedia('(hover: hover) and (pointer: fine)');

    const addressEl = box.querySelector('.contact-item__text');
    const copyBtn = box.querySelector('.js-contact-copy'); // the contact item's chip copies (contact-form.js)

    // The app row takes this computer's name; elsewhere (Linux, …) it stays out
    const ua = navigator.userAgent;
    const os = /Mac/.test(ua) ? 'mac' : /Windows/.test(ua) ? 'windows' : '';
    box.querySelectorAll('[data-mail-app]').forEach((li) => { li.hidden = li.dataset.mailApp !== os; });

    let trigger = null;
    let address = '';

    function place() {
        if (!trigger) return;
        const r = trigger.getBoundingClientRect();
        const w = box.offsetWidth;
        const h = box.offsetHeight;
        const gap = 8;
        let left = Math.min(Math.max(16, r.left), window.innerWidth - w - 16);
        let top = r.bottom + gap;
        if (top + h > window.innerHeight - 16 && r.top - gap - h > 16) top = r.top - gap - h; // flip above
        box.style.left = `${Math.round(left + window.scrollX)}px`;
        box.style.top = `${Math.round(top + window.scrollY)}px`;
    }

    function open(link) {
        trigger = link;
        const url = new URL(link.href);
        address = decodeURIComponent(url.pathname);
        const subject = url.searchParams.get('subject') || '';
        const to = encodeURIComponent(address);
        const su = subject ? encodeURIComponent(subject) : '';
        box.querySelectorAll('[data-mail-service]').forEach((a) => {
            const s = a.dataset.mailService;
            a.href = s === 'app' ? link.href : COMPOSE[s](to, su);
        });
        addressEl.textContent = address;
        copyBtn.dataset.copyText = address; // a vacancy's person may have their own address
        box.hidden = false;
        place();
        requestAnimationFrame(() => box.classList.add('is-open'));
        box.querySelector('li:not([hidden]) .mail-chooser__option')?.focus({ preventScroll: true });
    }

    function close(returnFocus = true) {
        if (box.hidden) return;
        box.classList.remove('is-open');
        box.hidden = true;
        if (returnFocus) trigger?.focus({ preventScroll: true });
        trigger = null;
    }

    document.addEventListener('click', (e) => {
        const link = e.target.closest?.('a[href^="mailto:"]');
        if (link && !box.contains(link)) {
            if (!desktop.matches || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
            e.preventDefault();
            if (trigger === link) { close(); return; }
            close(false);
            open(link);
            return;
        }
        if (!box.hidden && !box.contains(e.target)) close(false);
    });

    // A choice made: the new tab (or the app) takes over, the chooser steps aside
    box.querySelectorAll('[data-mail-service]').forEach((a) => a.addEventListener('click', () => setTimeout(() => close(false), 0)));
    box.querySelector('[data-mail-close]').addEventListener('click', () => close());
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !box.hidden) close(); });
    window.addEventListener('resize', place);
    window.addEventListener('scroll', place, { passive: true });
}
