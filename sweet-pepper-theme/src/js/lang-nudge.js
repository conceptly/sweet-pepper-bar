/**
 * Language nudge — «Удобнее по-русски? Переключить →» (inc/lang.php → sweet_pepper_lang_nudge).
 *
 * Whether it shows is decided before paint by the head script (the `lang-nudge-on` class on
 * <html>: English page, no choice stored, the landing page of the visit, no × in 30 days).
 * This handles what follows:
 *
 *   ×       remembered for 30 days (localStorage `sp-nudge-off`) — the guest turned down the
 *           question, not a language. The hero's nudge slides out right and its row collapses
 *           so the foot word rides up; the floating card slides out right.
 *   Scroll  the floating card is a question for the top of the page: once the guest has read
 *           on (half a screen), it leaves the same way, without remembering anything.
 *
 * The link itself is stored as a choice by the head script's click listener, like the pill.
 */

const OFF_KEY = 'sp-nudge-off';

function leave(nudge) {
    nudge.classList.add('is-dismissed');
    const wrapper = nudge.closest('.lang-nudge-wrapper');
    if (!wrapper) return;
    nudge.addEventListener('transitionend', () => {
        wrapper.style.height = `${wrapper.offsetHeight}px`;
        wrapper.offsetHeight; // reflow, so the height animates from here
        wrapper.style.transition = 'height 0.3s ease, margin 0.3s ease';
        wrapper.style.height = '0';
        wrapper.style.marginBottom = '0';
    }, { once: true });
}

export function initLangNudge() {
    if (!document.documentElement.classList.contains('lang-nudge-on')) return;

    document.querySelectorAll('[data-lang-nudge]').forEach((nudge) => {
        nudge.querySelector('[data-lang-nudge-close]')?.addEventListener('click', () => {
            try { localStorage.setItem(OFF_KEY, String(Date.now())); } catch (e) { /* private mode */ }
            leave(nudge);
        });
    });

    const float = document.querySelector('.lang-nudge--float');
    if (!float) return;
    const onScroll = () => {
        if (window.scrollY < window.innerHeight * 0.5) return;
        leave(float);
        window.removeEventListener('scroll', onScroll);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
}
