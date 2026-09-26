import './css/main.css';
import './css/variables.css';
import './css/header.css';
import './css/mobile-drawer.css';
import './css/hero.css';
import './css/components.css';
import './css/buttons.css';
import './css/highlights.css';
import './css/menu-preview.css';
import './css/about-preview.css';
import './css/events.css';
import './css/reserve-drawer.css';
import './css/contacts.css';
import './css/footer.css';
import './css/menu-hero.css';
import './css/menu-jump-nav.css';
import './css/menu-highlights.css';
import './css/menu-section.css';
import './css/dish-picker.css';
import './css/location.css';
import './css/about.css';
import './css/visit.css';
import './css/vacancy.css';
import './css/reveal.css';
// iOS Safari fires :active only when the page listens for touches — without this every pressed
// state (cards, buttons, the language switch) was invisible on an iPhone (25 Sep 2026).
document.addEventListener('touchstart', () => {}, { passive: true });
import { initDaypartEngine } from './js/daypart-engine';
import { initMobileDrawer } from './js/mobile-drawer';
import { initReserveDrawer } from './js/reserve-drawer';
import { initContactForm } from './js/contact-form';
import { initMenuHero } from './js/menu-hero';
import { initMenuJumpNav } from './js/menu-jump-nav';
import { initMenuSingleSection } from './js/menu-single-section';
import { initMenuRailNudge } from './js/menu-rail-nudge';
import { initDishPicker } from './js/dish-picker';
import { initLocationMap, initVisitMapRoutes } from './js/location-map';
import { initAboutPerks } from './js/about-perks';
import { initHowItFeels } from './js/how-it-feels';
import { initAboutStory } from './js/about-story';
import { initAboutTeam } from './js/about-team';
import { initTeamForm } from './js/team-form';
import { initVisitHero } from './js/visit-hero';
import { initGentleScroll } from './js/gentle-scroll';
import { initSectionLinks } from './js/section-link';
import { initReveal } from './js/reveal';
import { initCountUp } from './js/count-up';

document.addEventListener('DOMContentLoaded', () => {
    // Initialize daypart logic and interactions
    initDaypartEngine();
    
    // Initialize mobile navigation drawer
    initMobileDrawer();
    
    // Initialize reserve drawer
    initReserveDrawer();

    // Initialize contact form
    initContactForm();

    // Initialize menu hero hover interactions
    initMenuHero();

    // Initialize menu jump-nav (edge tab + panel, menu page only)
    initMenuJumpNav();

    // Menu page on phones: one section at a time (menu page only)
    initMenuSingleSection();
    initMenuRailNudge(); // the phone rail's entrance + idle nudge

    // Initialize dish picker (pairing station)
    initDishPicker();

    // Initialize location map (geo-detected provider)
    initLocationMap();

    // Visit page: landmark badges swap the map for a walking route
    initVisitMapRoutes();

    // Initialize about perks stamp strip
    initAboutPerks();

    // Initialize how it feels word cloud + quote wheel
    initHowItFeels();

    // Initialize the Pepper Story timeline heat line + counter ledger
    initAboutStory();

    // Initialize Dream Team card message toggle
    initAboutTeam();

    // Initialize "Write to the team" form modal
    initTeamForm();

    // Initialize Visit hero status band state engine
    initVisitHero();

    // Spring-driven in-page anchors (Visit: Directions → #visit-map)
    initGentleScroll();

    // Live-text section connectors (About prototype): fit each word to its container
    initSectionLinks();

    // Scroll-in entrances (home page plan; any [data-reveal] in markup)
    initReveal();

    // Numbers that count up once as their block reveals (after initReveal: it needs the arming)
    initCountUp();
});
