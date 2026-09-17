/**
 * Menu Jump-Nav — edge tab + slide-in panel
 *
 * website-brief.md → Menu page → Sticky jump-nav:
 * - Tab appears only once the hero's side-nav has scrolled away
 *   (while it is on screen the tab would duplicate it).
 * - Panel slides in from the left; dismiss by ×, scrim, Esc, or picking a
 *   word — picking scrolls to the anchor and closes. Focus is trapped.
 * - Active word tracks the section currently in view (outline → fill).
 */

import { gentleScrollTo } from './gentle-scroll';

export function initMenuJumpNav() {
    const tabWrap = document.querySelector('.menu-jump__tab-wrap');
    const panel   = document.getElementById('menu-jump-panel');
    const scrim   = document.querySelector('.menu-jump__scrim');
    if (!tabWrap || !panel) return;

    const tabBtn    = tabWrap.querySelector('.btn');
    const closeBtns = document.querySelectorAll('.js-menu-jump-close');
    const navItems  = panel.querySelectorAll('.menu-hero__nav-item');
    const heroNav   = document.querySelector('.menu-hero__nav');
    const hero      = document.querySelector('.menu-hero');

    // Phones and tablets (≤ 991px): the panel opens only from the hero, and a word
    // previews the hero instead of jumping — the full-width button under the
    // description commits (website-brief.md → Mobile — Menu page → Jump-nav on
    // phones; the band runs the same hero, menu-hero.css).
    const phoneMq  = window.matchMedia('(max-width: 991px)');
    const isPhone  = () => phoneMq.matches;

    if (tabBtn) {
        tabBtn.setAttribute('aria-controls', 'menu-jump-panel');
        tabBtn.setAttribute('aria-expanded', 'false');
    }

    // ── Tab visibility: show once the hero nav is above the viewport ──
    function setTabVisible(visible) {
        tabWrap.classList.toggle('is-visible', visible);
    }

    if (heroNav && 'IntersectionObserver' in window) {
        const heroObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                // Gone above the fold → show the tab; visible or below → hide it
                const scrolledPast = !entry.isIntersecting && entry.boundingClientRect.bottom < 0;
                setTabVisible(scrolledPast);
                if (!scrolledPast && isOpen) close();
            });
        }, { threshold: 0 });
        heroObserver.observe(heroNav);
    } else {
        // No hero nav on the page (or no IO) — nothing to duplicate, show it
        setTabVisible(true);
    }

    // ── Open / close ──
    let isOpen = false;
    let lastFocused = null;

    function focusables() {
        return Array.from(
            panel.querySelectorAll('a[href], button:not([disabled])')
        ).filter((el) => el.offsetParent !== null);
    }

    function open() {
        if (isOpen) return;
        isOpen = true;
        lastFocused = document.activeElement;

        // On a phone the panel mirrors the hero's section on show, not the
        // section in view (the guest is at the hero when it opens).
        if (isPhone() && hero && hero.dataset.currentSection) {
            setActive(hero.dataset.currentSection);
        }

        panel.classList.add('is-open');
        panel.setAttribute('aria-hidden', 'false');
        if (scrim) scrim.classList.add('is-open');
        if (tabBtn) tabBtn.setAttribute('aria-expanded', 'true');
        document.body.style.overflow = 'hidden';

        const closeBtn = panel.querySelector('.menu-jump__close');
        if (closeBtn) closeBtn.focus();

        document.addEventListener('keydown', onKeydown);
    }

    function close() {
        if (!isOpen) return;
        isOpen = false;

        panel.classList.remove('is-open');
        panel.setAttribute('aria-hidden', 'true');
        if (scrim) scrim.classList.remove('is-open');
        if (tabBtn) tabBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';

        document.removeEventListener('keydown', onKeydown);

        // Hand focus back to the tab (it opened the panel); if the tab has
        // since slid away (or is hidden on a phone), fall back to whatever
        // was focused before — on phones that is the hero's open button.
        if (tabBtn && tabWrap.classList.contains('is-visible') && tabWrap.offsetParent !== null) {
            tabBtn.focus();
        } else if (lastFocused && typeof lastFocused.focus === 'function' && lastFocused !== document.body) {
            lastFocused.focus();
        }
    }

    function onKeydown(e) {
        if (e.key === 'Escape') {
            e.preventDefault();
            close();
            return;
        }
        if (e.key !== 'Tab') return;

        // Focus trap
        const items = focusables();
        if (!items.length) return;
        const first = items[0];
        const last  = items[items.length - 1];

        if (e.shiftKey && document.activeElement === first) {
            e.preventDefault();
            last.focus();
        } else if (!e.shiftKey && document.activeElement === last) {
            e.preventDefault();
            first.focus();
        }
    }

    // Openers: the edge tab, and on phones the hero's flush-left button (the tab is
    // hidden below 768px — no room on a phone edge, same finding as the Reserve tab).
    document.querySelectorAll('.js-menu-jump-open').forEach((opener) => {
        opener.addEventListener('click', (e) => {
            e.preventDefault();
            open();
        });
    });

    closeBtns.forEach((btn) => btn.addEventListener('click', close));

    // ── Picking a word ──
    // Desktop: close, then scroll to the anchor.
    // Phone: close and preview the section in the hero (no scroll, no hash).
    navItems.forEach((item) => {
        item.addEventListener('click', (e) => {
            const slug = item.dataset.section;
            if (isPhone() && hero) {
                e.preventDefault();
                close();
                setActive(slug);
                hero.dispatchEvent(new CustomEvent('menu-hero:preview', { detail: { slug } }));
                return;
            }
            const target = document.getElementById(slug);
            if (!target) return; // let the default anchor behaviour handle it
            e.preventDefault();
            close();
            gentleScrollTo(target); // instant under prefers-reduced-motion
        });
    });

    // ── Active word tracks the section in view ──
    function setActive(slug) {
        navItems.forEach((item) => {
            const on = item.dataset.section === slug;
            item.classList.toggle('is-active', on);
            if (on) {
                item.setAttribute('aria-current', 'true');
            } else {
                item.removeAttribute('aria-current');
            }
        });
    }

    const slugs = Array.from(navItems).map((item) => item.dataset.section);
    const sections = slugs
        .map((slug) => document.getElementById(slug))
        .filter(Boolean);

    if (sections.length && 'IntersectionObserver' in window) {
        // A thin band just above the vertical centre: whichever section
        // crosses it is "current". Sections are taller than the band, so at
        // most one intersects at a time.
        const sectionObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) setActive(entry.target.id);
            });
        }, { rootMargin: '-45% 0px -50% 0px', threshold: 0 });
        sections.forEach((sec) => sectionObserver.observe(sec));
    }
}
