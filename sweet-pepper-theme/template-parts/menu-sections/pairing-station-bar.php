<?php
/**
 * Pairing Station (Bar version) — "Find Your Match!"
 *
 * The bar menu's interactive element — pick a drink, get a food pairing.
 * Mirror of the kitchen version (pairing-station.php) with swapped content:
 * tags show drinks, the card shows the paired food dish.
 *
 * Figma: picker-night (735:21620) — always renders in night/dark mode
 * Brief: website-brief.md § "Bar's notes & the pairing station"
 *
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/';

// Same pairings as the kitchen version, but viewed from the bar side:
// the "dish" (tag label) is the drink, the "pairing" is the food.
$pairings = [
    [
        'slug'        => 'buckthorn-infusion',
        'dish'        => 'Buckthorn Infusion',    // tag label (the drink)
        'card_name'   => 'Buckthorn Infusion',     // card display name
        'description' => 'The legend of the Kirova street',
        'food_img'    => 'bar/infusions/infusions-lenya-11.jpg',   // left photo (drink)
        'bar_img'     => 'food/lunch/pumpkin.png',                  // right photo (food)
        'pairing'     => 'Pumpkin Soup',                            // the food pairing
        'bar_section' => 'soups',                                   // links to food section
    ],
    [
        'slug'        => 'cranberry-infusion',
        'dish'        => 'Cranberry Infusion',
        'card_name'   => 'Cranberry Infusion',
        'description' => 'The legend of the Kirova street',
        'food_img'    => 'bar/infusions/infusions-lenya-09.jpg',
        'bar_img'     => 'food/dinner/draniki-2.jpg',
        'pairing'     => 'Signature Draniki',
        'bar_section' => 'hot-dishes',
    ],
    [
        'slug'        => 'jim-beam',
        'dish'        => 'Jack Daniels on Ice',
        'card_name'   => 'Jack Daniels on Ice',
        'description' => 'The legend of the Kirova street',
        'food_img'    => 'bar/hard-drinks/jim-beam-1.jpg',
        'bar_img'     => 'food/dinner/minced-beefsteak-07.jpg',
        'pairing'     => 'Beefsteak with Egg',
        'bar_section' => 'hot-dishes',
    ],
    [
        'slug'        => 'finlandia',
        'dish'        => 'A Shot of Finlandia',
        'card_name'   => 'Shot of Finlandia',
        'description' => 'The legend of the Kirova street',
        'food_img'    => 'bar/hard-drinks/finlandia-3.jpg',
        'bar_img'     => 'food/dinner/zharkoe-1.jpg',
        'pairing'     => 'Yaroslavl Roast',
        'bar_section' => 'hot-dishes',
    ],
    [
        'slug'        => 'ararat',
        'dish'        => 'Ararat Cognac',
        'card_name'   => 'Ararat Cognac',
        'description' => 'The legend of the Kirova street',
        'food_img'    => 'bar/hard-drinks/ararat-1.jpg',
        'bar_img'     => 'food/dinner/wings-2.jpg',
        'pairing'     => 'Chicken Wings',
        'bar_section' => 'hot-dishes',
    ],
    [
        'slug'        => 'red-wine',
        'dish'        => 'Red Wine',
        'card_name'   => 'Red Wine',
        'description' => 'The legend of the Kirova street',
        'food_img'    => 'bar/wine/red-2.jpg',
        'bar_img'     => 'food/lunch/chicken-pasta-1.jpg',
        'pairing'     => 'Chicken Pasta',
        'bar_section' => 'hot-dishes',
    ],
];

// Russian twins (23 Sep 2026): drink names from menu-copy-ru-draft.md → Подбор пары, dish
// names as the «Гастробот» record has them, the dish line the same placeholder as the
// kitchen picker's. Typed here while this picker's rows are typed (the reversed-pairs
// question: website-brief.md → Picker pairings).
if ( 'ru' === sweet_pepper_lang() ) {
    $ru = [
        'buckthorn-infusion' => [ 'Облепиховая настойка', 'Облепиховая настойка', 'Тыквенный суп' ],
        'cranberry-infusion' => [ 'Клюквенная настойка', 'Клюквенная настойка', 'Фирменные драники' ],
        'jim-beam'           => [ "Jack Daniel's со льдом", "Jack Daniel's со льдом", 'Бифштекс с яйцом' ],
        'finlandia'          => [ 'Стопка водки Finlandia', 'Стопка Finlandia', 'Жаркое по-ярославски' ],
        'ararat'             => [ 'Коньяк «Арарат»', 'Коньяк «Арарат»', 'Крылышки-гриль' ],
        'red-wine'           => [ 'Красное вино', 'Красное вино', 'Фарфалле с курицей' ],
    ];
    foreach ( $pairings as &$p ) {
        if ( isset( $ru[ $p['slug'] ] ) ) {
            [ $p['dish'], $p['card_name'], $p['pairing'] ] = $ru[ $p['slug'] ];
            $p['description'] = 'Легенда улицы Кирова';
        }
    }
    unset( $p );
}
?>

<!-- ═══════════════════════════════════════════════════════════════
     PAIRING STATION (BAR) — Find Your Match
     Figma: picker-night (735:21620)
     The bar menu's interactive element — pick a drink, get a food pairing.
     ═══════════════════════════════════════════════════════════════ -->
<section id="pairing-station-bar" class="menu-pairing-station">
    <div class="container pairing-station__inner">

        <!-- Phones only: the reflection of the section connector above (Figma Picker 2109:130226) -->
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-night/tryTheMatchMaker-reflection.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/tryTheMatchMaker-reflection.svg',
            'alt'       => 'TRY THE MATCH MAKER',
            'class'     => 'section-link-word--reflection pairing-station__top-word',
        ] );
        ?>

        <!-- Content block: header + picker -->
        <div class="pairing-station__content">
            <!-- Section header -->
            <div class="pairing-station__header">
                <h2 class="pairing-station__title molot-text"><?php esc_html_e( 'Find Your Match!', 'sweet-pepper' ); ?></h2>
                <p class="pairing-station__subtitle"><?php esc_html_e( 'Pick a drink — the kitchen takes care of the rest.', 'sweet-pepper' ); ?></p>
            </div>

            <!-- Dish Picker component (same component, swapped data) -->
            <?php
            get_template_part( 'template-parts/components/dish-picker', null, [
                'pairings'      => $pairings,
                'default_index' => 3, // Finlandia — matches Figma default
            ] );
            ?>
        </div>

        <!-- Bottom link word: YOU'LL LIKE IT (placeholder until BROWSE THE BAR SVG is exported) -->
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
