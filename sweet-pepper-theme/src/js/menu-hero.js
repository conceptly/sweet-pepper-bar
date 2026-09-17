/**
 * Menu Hero — Nav hover ↔ photo/copy swap
 *
 * On hover:  active state transfers to the hovered nav item,
 *            photo cross-fades, caption + description update.
 * On leave:  reverts to the default (server-rendered) section.
 * On click:  smooth-scrolls to the section anchor on the page.
 *
 * Figma interaction: Smart animate, Bouncy easing, 800ms.
 * Click-to-section scrolls on the house Gentle spring (gentle-scroll.js).
 */

import { gentleScrollTo } from './gentle-scroll';

export function initMenuHero() {
    const hero = document.querySelector('.menu-hero');
    if (!hero) return;

    // ── Parse section data from inline JSON ──
    const dataEl = hero.querySelector('.menu-hero__data');
    if (!dataEl) return;

    let sections;
    try {
        sections = JSON.parse(dataEl.textContent);
    } catch (e) {
        console.warn('[menu-hero] Could not parse section data', e);
        return;
    }

    const defaultSection = hero.dataset.defaultSection || 'breakfast';

    // ── DOM references ──
    const navItems    = hero.querySelectorAll('.menu-hero__nav-item');
    const photoImg    = hero.querySelector('.menu-hero__photo-img');
    const photoPill   = hero.querySelector('.menu-hero__photo-pill');
    const description = hero.querySelector('.menu-hero__description');
    const photoFrame  = hero.querySelector('.menu-hero__photo-frame');
    const commitBtn   = hero.querySelector('.menu-hero__commit-btn');       // phones only
    const commitLabel = commitBtn ? commitBtn.querySelector('.btn-label') : null;
    const commitIcon  = commitBtn ? commitBtn.querySelector('.btn-icon-left') : null;

    if (!photoImg || !photoPill || !description) return;

    // ── Preload images into browser cache ──
    Object.values(sections).forEach(sec => {
        const img = new Image();
        img.src = sec.image;
    });

    // ── State ──
    let currentSection = defaultSection;
    let hoverTimeout   = null;
    hero.dataset.currentSection = currentSection;

    /** Phones: the full-width commit button follows the section on show. */
    function updateCommit(slug) {
        const sec = sections[slug];
        if (!commitBtn || !sec) return;
        if (commitLabel) commitLabel.textContent = sec.ctaLabel || sec.label;
        if (commitIcon && sec.iconSvg) commitIcon.innerHTML = sec.iconSvg;
        commitBtn.setAttribute('href', '#' + slug);
    }

    /**
     * Swap the hero content to a given section with cross-fade.
     */
    function showSection(slug, animate = true) {
        const sec = sections[slug];
        if (!sec || slug === currentSection) return;

        currentSection = slug;
        hero.dataset.currentSection = slug;

        if (animate && photoFrame) {
            // Fade out
            photoFrame.classList.add('is-fading');

            // Swap content mid-fade (at ~half the CSS transition duration)
            setTimeout(() => {
                photoImg.src = sec.image;
                photoImg.style.objectPosition = sec.focus || ''; // tablet 21:9 crop
                photoImg.alt = sec.caption;
                photoPill.textContent = sec.caption;
                description.textContent = sec.description;

                // Fade in
                photoFrame.classList.remove('is-fading');
            }, 250); // Swap at mid-point of the 500ms CSS fade
        } else {
            photoImg.src = sec.image;
            photoImg.style.objectPosition = sec.focus || '';
            photoImg.alt = sec.caption;
            photoPill.textContent = sec.caption;
            description.textContent = sec.description;
        }
    }

    /**
     * Transfer the active class to a specific nav item (or null to deactivate all).
     */
    function setActiveNav(slug) {
        navItems.forEach(item => {
            const isTarget = slug !== null && item.dataset.section === slug;
            item.classList.toggle('is-active', isTarget);
            if (isTarget) {
                item.setAttribute('aria-current', 'true');
            } else {
                item.removeAttribute('aria-current');
            }
        });
    }

    // ── Event listeners ──
    navItems.forEach(item => {
        const slug = item.dataset.section;

        item.addEventListener('mouseenter', () => {
            clearTimeout(hoverTimeout);
            setActiveNav(slug);
            showSection(slug);
        });

        item.addEventListener('mouseleave', () => {
            // Small delay before reverting — prevents flicker between items
            hoverTimeout = setTimeout(() => {
                setActiveNav(defaultSection);
                showSection(defaultSection);
            }, 200);
        });

        // Click → Gentle spring scroll to the section anchor
        item.addEventListener('click', (e) => {
            const target = document.getElementById(slug);
            if (target) {
                e.preventDefault();
                gentleScrollTo(target);
            }
            // If no target element, let the default anchor behavior handle it
        });
    });

    // Keep hover state when moving between nav items (cancel revert)
    const navList = hero.querySelector('.menu-hero__nav-list');
    if (navList) {
        navList.addEventListener('mouseenter', () => {
            clearTimeout(hoverTimeout);
        });
    }

    // ── Door hover → show cross-menu intro content ──
    const door = hero.querySelector('.menu-hero__door');
    if (door) {
        const doorTarget = door.dataset.doorTarget || 'drinks';

        door.addEventListener('mouseenter', () => {
            clearTimeout(hoverTimeout);
            // Deactivate all nav items
            setActiveNav(null);
            showSection(doorTarget);
        });

        door.addEventListener('mouseleave', () => {
            hoverTimeout = setTimeout(() => {
                setActiveNav(defaultSection);
                showSection(defaultSection);
            }, 200);
        });
    }

    // ── Phones: a word picked in the jump-nav panel previews here ──
    // (menu-jump-nav.js dispatches; the panel closes, the page does not scroll,
    // and the commit button below the description takes the new section.)
    // The preview sticks — it is a choice, not a hover — so no revert timer.
    hero.addEventListener('menu-hero:preview', (e) => {
        const slug = e.detail && e.detail.slug;
        if (!slug || !sections[slug]) return;
        clearTimeout(hoverTimeout);
        setActiveNav(slug);
        showSection(slug);
        updateCommit(slug);
    });
}
