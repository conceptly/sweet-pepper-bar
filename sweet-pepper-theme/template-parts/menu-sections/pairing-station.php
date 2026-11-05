<?php
/**
 * Pairing Station — "Find Your Match!"
 *
 * The menu page's one interactive element, at the food → drinks seam.
 * Pick a dish, the bar answers with a printed ticket.
 *
 * Figma: picker-day (708:19997)
 * Brief: website-brief.md § "Bar's notes & the pairing station"
 *
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/';

// One list for both pickers — inc/pairings.php.
$pairings = sweet_pepper_food_pairings();
?>

<!-- ═══════════════════════════════════════════════════════════════
     PAIRING STATION — Find Your Match
     Figma: picker-day (708:19997)
     The page's one interactive element, at the food → drinks seam.
     ═══════════════════════════════════════════════════════════════ -->
<section id="pairing-station" class="menu-pairing-station">
    <div class="container pairing-station__inner">

        <!-- The reflection of the connector that ends the section above, at every width (author, 23 Sep 2026;
             phones only before — Figma Picker 2109:130226) -->
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/tryTheMatchMaker-reflection.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/tryTheMatchMaker-reflection.svg',
            'alt'       => 'TRY THE MATCH MAKER',
            'class'     => 'section-link-word--reflection pairing-station__top-word',
        ] );
        ?>

        <!-- Content block: header + picker (gap-24 between header and picker) -->
        <div class="pairing-station__content">
            <!-- Section header -->
            <div class="pairing-station__header">
                <h2 class="pairing-station__title molot-text"><?php esc_html_e( 'Find Your Match!', 'sweet-pepper' ); ?></h2>
                <p class="pairing-station__subtitle"><?php esc_html_e( 'Pick a plate — the bar takes care of the rest.', 'sweet-pepper' ); ?></p>
            </div>

            <!-- Dish Picker component -->
            <?php
            get_template_part( 'template-parts/components/dish-picker', null, [
                'pairings'      => $pairings,
                'default_index' => sweet_pepper_pairing_index( $pairings, 'roast' ), // matches Figma default
            ] );
            ?>
        </div>

        <!-- Bottom link word: YOU'LL LIKE IT -->
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/youllLikeIt.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/youllLikeIt.svg',
            'alt'       => "YOU'LL LIKE IT",
            'class'     => 'section-link-word--reflection pairing-station__link-word',
        ] );
        ?>

    </div>
</section>
