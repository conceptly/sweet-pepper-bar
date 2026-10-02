/**
 * The 404 page, layout b: the scroll carries the number (author, 2 Oct 2026; not-found.css →
 * layout b answers the scroll). `--nf-p` on the digits is the scroll's share, 0 at the top of
 * the page and 1 when the number would have reached the header — or at the page's end, where
 * that comes first (a wide screen scrolls only 135–172px here, so there it is the whole
 * scroll). The styles turn it into the Chili level and, on wide screens, the climb to the
 * middle of the column. `.is-scrolled` stops the level's idle loop, which holds only at the
 * very top. A page that doesn't scroll shows the end.
 */
export function initNotFound() {
    const digits = document.querySelector('.not-found--b .not-found__digits--sunk');
    if (!digits) return;

    // where the number stands in the page, without the transform the scroll gives it
    const home = () => {
        let y = 0;
        for (let el = digits; el; el = el.offsetParent) y += el.offsetTop;
        return y;
    };

    let raf = 0;
    const set = () => {
        raf = 0;
        const max = document.documentElement.scrollHeight - window.innerHeight;
        const header = parseFloat(getComputedStyle(digits).getPropertyValue('--nf-header')) || 76;
        const full = Math.min(max, home() - header);
        const p = full > 0 ? Math.max(0, Math.min(1, window.scrollY / full)) : 1;
        digits.style.setProperty('--nf-p', p.toFixed(3));
        digits.classList.toggle('is-scrolled', p > 0);
    };
    const ask = () => { if (!raf) raf = requestAnimationFrame(set); };

    window.addEventListener('scroll', ask, { passive: true });
    window.addEventListener('resize', ask);
    set();
}
