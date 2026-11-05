<?php
/**
 * Menu sections tail — phone-only connector after the menu sections.
 *
 * On phones the menu page shows one section at a time (src/js/menu-single-section.js),
 * so whichever section is on show ends on the pairing station; this single connector
 * ("try the match maker") replaces the nine per-section words, which stay in their
 * sections for desktop (hidden ≤ 767px in menu-section.css). The bar is always dark,
 * so it uses its bar/ file in both themes (a copy of the kitchen-night export, 23 Sep 2026).
 *
 * Figma: SectionLinkMobile at the foot of menu-food-mobile-day (2109:130225).
 *
 * @param array $args { @type string $menu_state 'food' | 'drinks' }
 */

$menu_state = $args['menu_state'] ?? 'food';
$night      = ( $menu_state === 'drinks' ) ? 'assets/sectionLinks/menu/bar/tryTheMatchMaker.svg' : 'assets/sectionLinks/menu/kitchen-night/tryTheMatchMaker.svg';
$day        = ( $menu_state === 'drinks' ) ? $night : 'assets/sectionLinks/menu/kitchen-day/tryTheMatchMaker.svg';
?>
<div class="container menu-sections-tail">
    <?php
    get_template_part( 'template-parts/components/section-link-word', null, [
        'day_img'   => $day,
        'night_img' => $night,
        'alt'       => 'TRY THE MATCH MAKER',
        'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
    ] );
    ?>
</div>
