<?php
/**
 * Seasonal Menu Highlights — the strip after the hero, both menu pages.
 *
 * Figma: SeasonalMenuSection (781:24689 day, 833:34450 night); phones 2109:130202 / 2194:70367.
 * Rendered by template-parts/menu-page.php for the kitchen and the bar. Header and cards
 * come from the page's «Сезонное меню» tab through sweet_pepper_menu_highlights()
 * (inc/menu-page.php): the cards REFERENCE dishes — name, photo (the dish's featured
 * image) and the section link all come from the dish's own record, never copied here.
 * While the page's list is empty the strip shows the menu's seasonal-labelled dishes
 * (drinks on the bar page), and while the store has none, the typed cards in
 * data/menu/page.php — it never goes blank. A card links to its section: an anchor on
 * this page, a full URL to the other menu page (so the phone single-section interceptor
 * leaves it alone).
 *
 * @param array $args { @type string $menu_state 'food' | 'drinks' }
 */

$menu_state = $args['menu_state'] ?? 'food';
$is_drinks  = ( $menu_state === 'drinks' );
$strip      = sweet_pepper_menu_highlights( $menu_state );
?>
<section class="menu-highlights">
    <div class="container">
        <?php
        // Section Header — title-only variant (no CTAs, no description)
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'  => $strip['eyebrow'],
            // The phone night frame (menuSection 2194:70367) sets the second line in Paprika on its own line;
            // the span is inert everywhere else (menu-highlights.css).
            'headline' => esc_html( $strip['headline'] )
                . ( '' !== $strip['headline_2'] ? ' <span class="menu-highlights__headline-2">' . esc_html( $strip['headline_2'] ) . '</span>' : '' ),
        ] );
        ?>

        <!-- Horizontal scrolling card grid -->
        <div class="menu-highlights-grid">
            <?php
            foreach ( $strip['cards'] as $card ) {
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
