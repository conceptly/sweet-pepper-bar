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
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/';

// Pairings — subset of the menu page's data, matches Figma variants
$pairings = [
    [
        'slug'        => 'roast',
        'dish'        => 'Yaroslavl Roast',
        'card_name'   => 'Yaroslavl Roast',
        'description' => 'A Kirova Street favourite',
        'food_img'    => 'food/dinner/zharkoe-1.jpg',
        'bar_img'     => 'bar/hard-drinks/finlandia-3.jpg',
        'pairing'     => 'A shot of Finlandia vodka',
        'bar_section' => 'spirits',
    ],
    [
        'slug'        => 'pasta',
        'dish'        => 'Chicken Pasta',
        'card_name'   => 'Chicken Pasta',
        'description' => 'A Kirova Street favourite',
        'food_img'    => 'food/lunch/chicken-pasta-1.jpg',
        'bar_img'     => 'bar/hard-drinks/ararat-1.jpg',
        'pairing'     => 'A glass of Ararat brandy',
        'bar_section' => 'spirits',
    ],
    [
        'slug'        => 'pumpkin',
        'dish'        => 'Pumpkin Soup',
        'card_name'   => 'Pumpkin Soup',
        'description' => 'Started as a special. Stayed by popular demand.',
        'food_img'    => 'food/lunch/pumpkin.png',
        'bar_img'     => 'bar/infusions/infusions-lenya-02.jpg',
        'pairing'     => 'A shot of sea buckthorn infusion',
        'bar_section' => 'infusions',
    ],
];
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
                    'eyebrow'     => __( 'BAR × KITCHEN', 'sweet-pepper' ),
                    'headline'    => __( 'YOUR LOCAL', 'sweet-pepper' ),
                    'headline_2'  => __( 'GASTROBAR', 'sweet-pepper' ),
                    'description' => __( 'Eggs and coffee, a proper lunch or a cocktail with something to share. Here, the kitchen and bar belong at the same table. Every dish has a drink to go with it — with or without alcohol.', 'sweet-pepper' ),
                ] );
                ?>

                <div class="about-concept__cta">
                    <?php
                    get_template_part( 'template-parts/components/button', null, [
                        'label'          => __( 'See the full menu', 'sweet-pepper' ),
                        'url'            => home_url( '/menu' ),
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
                    'default_index' => 0,
                ] );
                ?>
            </div>
        </div>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'wordOfMouth', 'position' => 'foot', 'alt' => 'Word of mouth' ] ); ?>
</section>
