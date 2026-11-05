<?php
/**
 * About page — The Concept section
 *
 * Dark section (soft-peppercorn bg). Two-column layout:
 * - Left: section header (BAR × KITCHEN / YOUR LOCAL GASTROBAR) + CTA
 * - Right: portrait-orientation pairing picker (reuses dish-picker component + JS)
 *
 * The picker is identical to the menu page's — same component, same JS.
 * The only difference is a vertical layout (CSS modifier) and dark color context.
 *
 * Figma: 323:6755
 *
 * Content comes as args from sweet_pepper_about_concept() (inc/about-data.php) — the About page's «Бар и кухня» tab.
 *
 * @param array $args eyebrow · headline · headline_2 · description
 *
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/';

// The menu page's pairings — one list for both pickers (inc/pairings.php)
$pairings = sweet_pepper_food_pairings();
?>

<section id="concept" class="about-section about-section--dark about-concept">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'betterTogether', 'position' => 'head', 'alt' => 'Better together' ] ); ?>

    <div class="container">
        <div class="about-concept__inner">
            <!-- Left column: text + CTA -->
            <div class="about-concept__text">
                <?php
                get_template_part( 'template-parts/components/section-header', null, [
                    'eyebrow'     => $args['eyebrow'],
                    'headline'    => $args['headline'],
                    'headline_2'  => $args['headline_2'],
                    'description' => $args['description'],
                ] );
                ?>

                <div class="about-concept__cta">
                    <?php
                    get_template_part( 'template-parts/components/button', null, [
                        'label'          => __( 'See the full menu', 'sweet-pepper' ),
                        'url'            => sweet_pepper_menu_url( 'food' ),
                        'variant'        => 'primary-green',
                        'type'           => 'primary-green',
                        'icon_right_svg' => 'icons/food.svg',
                    ] );
                    ?>
                </div>
            </div>

            <!-- Right column: portrait pairing picker -->
            <div class="about-concept__picker">
                <div class="about-concept__picker-header">
                    <h3 class="about-concept__picker-title molot-text"><?php esc_html_e( 'Try it yourself', 'sweet-pepper' ); ?></h3>
                    <p class="about-concept__picker-subtitle"><?php esc_html_e( 'Pick a plate — see what the bar suggests.', 'sweet-pepper' ); ?></p>
                </div>

                <?php
                get_template_part( 'template-parts/components/dish-picker', null, [
                    'pairings'      => $pairings,
                    'default_index' => sweet_pepper_pairing_index( $pairings, 'roast' ),
                ] );
                ?>
            </div>
        </div>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'wordOfMouth', 'position' => 'foot', 'alt' => 'Word of mouth' ] ); ?>
</section>
