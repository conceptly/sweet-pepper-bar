/**
 * Menu page on phones and tablets — one section at a time
 *
 * website-brief.md → Mobile — Menu page → Sections. Below 992px the page shows
 * a single menu section; the others stay in the DOM (server-rendered, one URL,
 * deep-linkable) but are display: none until chosen. The section on show
 * follows, in order of arrival:
 *   1. the URL hash on load (#soups),
 *   2. the hero's section on show (the jump-nav drawer previews it),
 *   3. any same-page anchor to a section: the rail in the section headline,
 *      the hero's commit button, the highlight card links.
 * Switching keeps the URL hash current (replaceState, no history entry) and
 * scrolls to the section on the house spring when the tap came from a link.
 * Desktop is untouched: this module does nothing above 991px, and switching
 * the viewport across the breakpoint shows every section again.
 */

import { gentleScrollTo } from './gentle-scroll';

export function initMenuSingleSection() {
    const hero = document.querySelector('.menu-hero');
    const sections = Array.from(document.querySelectorAll('main section.menu-section[id]'));
    if (!hero || sections.length < 2) return;

    const phoneMq = window.matchMedia('(max-width: 991px)');
    const isPhone = () => phoneMq.matches;
    const slugs = new Set(sections.map((s) => s.id));

    let current = null;

    /** Scroll the section's rail so its current word sits at the left gutter (the rail's own lead-in). */
    function alignRail(sec) {
        const rail = sec.querySelector('.menu-section-rail');
        const word = rail && rail.querySelector('.menu-section-rail__current');
        if (!rail || !word) return;
        const gutter = parseFloat(getComputedStyle(rail).paddingLeft) || 16;
        rail.scrollLeft = Math.max(0, word.offsetLeft - gutter);
    }

    function show(slug, { scroll = false, hash = true } = {}) {
        if (!slugs.has(slug)) return false;
        sections.forEach((sec) => sec.classList.toggle('is-current', sec.id === slug));
        current = slug;
        alignRail(document.getElementById(slug));
        if (hash && window.location.hash !== '#' + slug) {
            history.replaceState(null, '', '#' + slug);
        }
        if (scroll) {
            const target = document.getElementById(slug);
            if (target) gentleScrollTo(target); // instant under prefers-reduced-motion
        }
        return true;
    }

    function initial() {
        const fromHash = window.location.hash.slice(1);
        if (slugs.has(fromHash)) {
            show(fromHash, { hash: false });
            // The browser could not scroll to a hidden anchor on load — do it now.
            const target = document.getElementById(fromHash);
            if (target) window.scrollTo({ top: target.getBoundingClientRect().top + window.scrollY - 76, behavior: 'instant' });
            return;
        }
        show(hero.dataset.currentSection || sections[0].id, { hash: false });
    }

    function enable() {
        document.body.classList.add('menu-single-section');
        initial();
    }

    function disable() {
        document.body.classList.remove('menu-single-section');
        sections.forEach((sec) => sec.classList.remove('is-current'));
        current = null;
    }

    if (isPhone()) enable();
    phoneMq.addEventListener('change', (e) => (e.matches ? enable() : disable()));

    // ── Any same-page anchor to a section (rail, commit button, highlight cards) ──
    // Capture phase, so this runs before gentle-scroll.js's own binder on the
    // same anchors; on phones the switch replaces the plain scroll.
    document.addEventListener('click', (e) => {
        if (!isPhone()) return;
        const link = e.target.closest('a[href^="#"]');
        if (!link) return;
        // The jump-nav drawer handles its own words (they preview the hero, and the
        // hero's menu-hero:preview event brings the section along — no scroll).
        if (link.closest('#menu-jump-panel')) return;
        const slug = link.getAttribute('href').slice(1);
        if (!slugs.has(slug)) return;
        e.preventDefault();
        e.stopImmediatePropagation();
        show(slug, { scroll: true });
    }, true);

    // ── The hero previews a section (drawer word tapped): the page follows ──
    hero.addEventListener('menu-hero:preview', (e) => {
        if (!isPhone()) return;
        const slug = e.detail && e.detail.slug;
        if (slug && slug !== current) show(slug);
    });

    // ── Back/forward or a manual hash edit ──
    window.addEventListener('hashchange', () => {
        if (!isPhone()) return;
        const slug = window.location.hash.slice(1);
        if (slugs.has(slug) && slug !== current) show(slug, { scroll: true, hash: false });
    });
}
