/**
 * Vacancy page (single-vacancy.php) — the ticket and the contact card rest 1° off on phones
 * and settle to 0° once they scroll in: the Visit contact card's move (visit-hero.js →
 * initCardSettle), author, 28 Sep 2026. One-shot per element; the CSS transition does the
 * move, and the class only means something inside the phone block of vacancy.css — desktop
 * keeps its tilt and its hover-to-0°. Reduced motion: the CSS leaves both flat anyway.
 */
export function initVacancy() {
    if (!document.querySelector('.page-vacancy') || !('IntersectionObserver' in window)) return;

    const io = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            // The ticket prints on load first (vacancy.css → entrance); settle after it lands
            const wait = entry.target.classList.contains('vacancy-ticket') ? 1200 : 0;
            setTimeout(() => entry.target.classList.add('is-settled'), wait);
            io.unobserve(entry.target);
        });
    }, { threshold: 0.4 });

    document.querySelectorAll('.vacancy-ticket, .vacancy-card').forEach((el) => io.observe(el));
}
