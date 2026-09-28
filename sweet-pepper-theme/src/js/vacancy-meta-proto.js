/**
 * PROTOTYPE (28 Sep 2026) — the vacancy page's meta row, candidates behind a URL flag:
 *
 *   ?meta=ticket — B: the facts on a ticket with rugged edges (the About ledger's phone
 *                  motif), pill and date over a Mushroom rule, schedule and pay as
 *                  menu rows with dotted leaders
 *   ?meta=parchment — B on a Parchment ticket, as the dark pages' other tickets (author,
 *                  28 Sep 2026: "just a try, for consistency")
 *   ?meta=stats  — C: schedule and pay as two Molot numbers with captions, pill and date
 *                  as a footnote
 *
 * Without a flag C (stats) is shown — the author's default while the options stay testable;
 * ?meta=list keeps the built meta row. The markup is rebuilt
 * from the printed meta row, so C parses the free-text pay («от 90 до 120 ₽ в час + …») —
 * the real build would need pay as numbers. Styles: vacancy.css → Meta prototype.
 * Remove this file (and its import) once a variant is chosen and moved into head.php.
 */

const esc = (s) => s.replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));

export function initVacancyMetaProto() {
    // Two numbers is the default for now (author, 28 Sep 2026); ?meta=list shows the built row
    const variant = new URLSearchParams(location.search).get('meta') || 'stats';
    const meta = document.querySelector('.vacancy-head__meta');
    if (!meta || !['ticket', 'parchment', 'stats'].includes(variant)) {
        return;
    }

    const ru = document.documentElement.lang.startsWith('ru');
    const pill = meta.querySelector('.vacancy-pill')?.textContent.trim() || '';
    const [schedule = '', pay = '', since = ''] = [...meta.querySelectorAll('.vacancy-head__meta-item')].map((e) => e.textContent.trim());
    const pillHtml = pill ? `<span class="vacancy-pill">${esc(pill)}</span>` : '';
    const sinceHtml = since ? `<span class="vm-since">${esc(since)}</span>` : '';
    const box = document.createElement('div');

    if (variant === 'ticket' || variant === 'parchment') {
        const ground = variant === 'parchment' ? 'parchment' : 'soft-peppercorn';
        const row = (label, value, cls = '') => value
            ? `<div class="vm-ticket__row ${cls}"><span class="vm-ticket__label">${label}</span><span class="vm-ticket__wrap"><span class="vm-ticket__value">${esc(value)}</span></span></div>`
            : '';
        box.className = 'vm-ticket' + (variant === 'parchment' ? ' vm-ticket--parchment' : '');
        box.innerHTML = `
            <div class="rugged-edge vm-ticket__edge vm-ticket__edge--top" style="--rugged-color: var(--peppercorn);" aria-hidden="true"></div>
            <div class="vm-ticket__top">${pillHtml}${sinceHtml}</div>
            ${row(ru ? 'График' : 'Schedule', schedule)}
            ${row(ru ? 'Оплата' : 'Pay', pay, 'vm-ticket__row--pay')}
            <div class="rugged-edge vm-ticket__edge vm-ticket__edge--bottom" style="--rugged-color: var(--${ground});" aria-hidden="true"></div>`;
    } else {
        const [shifts, hours = ''] = schedule.split(' · ');
        const head = (pay.match(/^[^+]+/) || [''])[0].trim();
        const extras = pay.slice(head.length).trim();
        const nums = head.match(/\d[\d\s]*/g) || [];
        const money = nums.length ? nums.map((n) => n.trim()).join('–') + ' ₽' : head;
        const unit = /в час|an hour|\/час/.test(head) ? (ru ? 'в час' : 'an hour') : '';
        const from = nums.length === 1 && /^от|^from/i.test(head) ? (ru ? 'от ' : 'from ') : '';
        box.className = 'vm-stats';
        box.innerHTML = `
            <div class="vm-stats__pair">
                ${shifts ? `<div class="vm-stats__item"><strong class="vm-stats__num molot-text">${esc(shifts)}</strong><span class="vm-stats__cap">${esc(hours)}</span></div>` : ''}
                ${pay ? `<div class="vm-stats__item"><strong class="vm-stats__num molot-text">${esc(from + money)}</strong><span class="vm-stats__cap">${esc([unit, extras].filter(Boolean).join(' '))}</span></div>` : ''}
            </div>
            <p class="vm-stats__foot">${pillHtml}${sinceHtml}</p>`;
    }

    meta.replaceWith(box);
}
