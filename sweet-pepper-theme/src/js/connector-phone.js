/**
 * Phone connectors — on trial (2 Oct 2026): `?conn=0` hides the section connectors on phones
 * (a 24px rest keeps the seam's breathing room); `?conn=fit` returns to the width-matching
 * default. Remembered for the visit, as the menu page's `?nav=` is. Rules: components.css →
 * Phone connectors — on trial. website-brief.md → Section connectors → Phones — on trial.
 * The crop looks (one display height, the word running off the edge) were tried the same
 * day and turned down — "awkward" unless animated, perhaps on scroll (author).
 */

const KEY = 'sp-conn';

export function initConnectorPhoneTrial() {
    const asked = new URLSearchParams(window.location.search).get('conn');
    let look = asked;
    try {
        if (asked === 'fit') sessionStorage.removeItem(KEY);
        else if (asked) sessionStorage.setItem(KEY, asked);
        else look = sessionStorage.getItem(KEY);
    } catch (e) { /* private mode: the flag lives on the URL only */ }
    if (look !== '0') return;
    document.documentElement.classList.add('conn-0');
}
