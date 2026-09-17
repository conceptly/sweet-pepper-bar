<?php
/**
 * Seasonal Menu Highlights — the strip after the hero, both menu states.
 *
 * Figma: SeasonalMenuSection (781:24689 day, 833:34450 night); phones 2109:130202 / 2194:70367.
 * Rendered by page-menu.php for food and drinks. The cards are the kitchen's seasonal
 * picks in both states for now (Sep 2026) — the bar's own seasonal cards are the team's
 * job; the data shape is the same. On the drinks page the card links go to the food
 * page's sections (full URLs, so the phone single-section interceptor leaves them alone).
 *
 * @param array $args { @type string $menu_state 'food' | 'drinks' }
 */

$menu_state = $args['menu_state'] ?? 'food';
$is_drinks  = ( $menu_state === 'drinks' );
$img_base   = get_template_directory_uri() . '/assets/images/';
// Same-page anchor on the food page; a full URL from the drinks page.
$section_url = function ( $slug ) use ( $is_drinks ) {
    return $is_drinks ? home_url( '/menu/#' . $slug ) : '#' . $slug;
};
?>
<section class="menu-highlights">
    <div class="container">
        <?php
        // Section Header — title-only variant (no CTAs, no description)
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'  => 'delicious & refreshing',
            // The phone night frame (menuSection 2194:70367) sets "Highlights" in Paprika on its own line;
            // the span is inert everywhere else (menu-highlights.css).
            'headline' => 'Summer Menu <span class="menu-highlights__headline-2">Highlights</span>',
        ] );
        ?>

        <!-- Horizontal scrolling card grid -->
        <div class="menu-highlights-grid">
            <?php
            $highlights = [
                [
                    'image_url'  => $img_base . 'food/lunch/pumpkin.png',
                    'image_alt'  => 'Gazpacho soup',
                    'title'      => 'Gazpacho',
                    'link_label' => 'Show in Soups',
                    'link_label_mobile' => 'In Soups',
                    'link_url'   => $section_url( 'soups' ),
                    'tilt'       => 'left',
                ],
                [
                    'image_url'  => $img_base . 'food/lunch/cobb-1.jpg',
                    'image_alt'  => 'Okroshka',
                    'title'      => 'Okroshka',
                    'link_label' => 'Show in Soups',
                    'link_label_mobile' => 'In Soups',
                    'link_url'   => $section_url( 'soups' ),
                    'tilt'       => 'right',
                ],
                [
                    'image_url'  => $img_base . 'food/lunch/bagel-lunch-1.jpg',
                    'image_alt'  => 'Summer Salad',
                    'title'      => 'Summer Salad',
                    'link_label' => 'Show in salads',
                    'link_label_mobile' => 'In Salads',
                    'link_url'   => $section_url( 'salads' ),
                    'tilt'       => 'left',
                ],
                [
                    'image_url'  => $img_base . 'food/dinner/zharkoe-1.jpg',
                    'image_alt'  => 'Fettuccine Corfu',
                    'title'      => 'Fettuccine Corfu',
                    'link_label' => 'Show in pastas',
                    'link_label_mobile' => 'In Pastas',
                    'link_url'   => $section_url( 'hot-dishes' ),
                    'tilt'       => 'right',
                ],
                [
                    'image_url'  => $img_base . 'food/dinner/wings-2.jpg',
                    'image_alt'  => 'Ravioli',
                    'title'      => 'Raviolli',
                    'link_label' => 'Show in pastas',
                    'link_label_mobile' => 'In Pastas',
                    'link_url'   => $section_url( 'hot-dishes' ),
                    'tilt'       => 'left',
                ],
                [
                    'image_url'  => $img_base . 'food/dessert/napoleon-1.jpg',
                    'image_alt'  => 'Caramel Cheesecake',
                    'title'      => 'Caramel Cheesecake',
                    'link_label' => 'Show in desserts',
                    'link_label_mobile' => 'In Desserts',
                    'link_url'   => $section_url( 'desserts' ),
                    'tilt'       => 'right',
                ],
            ];

            foreach ( $highlights as $card ) {
                get_template_part( 'template-parts/components/menu-highlight-card', null, $card );
            }
            ?>
        </div>

        <!-- Bottom link word: GET IT WHILE IT LASTS -->
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => $is_drinks ? 'assets/sectionLinks/menu/bar/getItWhileItLasts.svg' : 'assets/sectionLinks/menu/kitchen-day/getItWhileItLasts.svg',
            'night_img' => $is_drinks ? 'assets/sectionLinks/menu/bar/getItWhileItLasts.svg' : 'assets/sectionLinks/menu/kitchen-night/getItWhileItLasts.svg',
            'alt'       => 'GET IT WHILE IT LASTS',
            'class'     => 'section-link-word--reflection menu-highlights__link-word',
        ] );
        ?>
    </div>
</section>

