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

// The kitchen picker's pairs (inc/pairings.php — the «Гастробот» record), seen from the bar:
// the drink is the tag and the first photo, the dish the reply and the second (author, 28 Sep
// 2026: "all the pickers have the same pairs, only the order changes on the bar page"). It kept
// its own typed copy until then, which had drifted — two infusions swapped, red wine for
// Jim Beam — and printed its photo paths without the theme URL, so no photo loaded.
//
// Only the drink's tag name is this picker's own, keyed on the row's English dish name
// (EN tag · EN ticket · RU tag · RU ticket, from menu-copy-ru-draft.md → Подбор пары) and
// the kitchen section its link opens. A row the table doesn't know (a pair added in admin)
// shows the bar's reply as the tag and links to hot dishes.
$drinks = [
    'Pumpkin Soup'         => [ 'Buckthorn Infusion', 'Buckthorn Infusion', 'Облепиховая настойка', 'Облепиховая настойка', 'soups' ],
    'Signature Draniki'    => [ 'Cranberry Infusion', 'Cranberry Infusion', 'Клюквенная настойка', 'Клюквенная настойка', 'hot-dishes' ],
    'Beefsteak with Egg'   => [ 'Jack Daniels on Ice', 'Jack Daniels on Ice', "Jack Daniel's со льдом", "Jack Daniel's со льдом", 'hot-dishes' ],
    'Yaroslavl Pork Roast' => [ 'A Shot of Finlandia', 'Shot of Finlandia', 'Стопка водки Finlandia', 'Стопка Finlandia', 'hot-dishes' ],
    'Smoked Pepper Wings'  => [ 'Ararat Cognac', 'Ararat Cognac', 'Коньяк «Арарат»', 'Коньяк «Арарат»', 'hot-dishes' ],
    'Chicken Pasta'        => [ 'Jim Beam on Ice', 'Jim Beam on Ice', 'Jim Beam со льдом', 'Jim Beam со льдом', 'hot-dishes' ],
];
$ru       = 'ru' === sweet_pepper_lang();
$pairings = [];
foreach ( sweet_pepper_food_pairings() as $p ) {
    $d          = $drinks[ $p['dish_en'] ] ?? null;
    $pairings[] = [
        'slug'        => $p['slug'],
        'dish'        => $d ? $d[ $ru ? 2 : 0 ] : $p['pairing'],
        'card_name'   => $d ? $d[ $ru ? 3 : 1 ] : $p['pairing'],
        'description' => $ru ? 'Легенда улицы Кирова' : 'The legend of the Kirova street',
        'food_img'    => $p['bar_img'],
        'bar_img'     => $p['food_img'],
        'pairing'     => $p['card_name'],
        'bar_section' => $d ? $d[4] : 'hot-dishes',
        'default'     => $p['default'],
    ];
}
?>

<!-- ═══════════════════════════════════════════════════════════════
     PAIRING STATION (BAR) — Find Your Match
     Figma: picker-night (735:21620)
     The bar menu's interactive element — pick a drink, get a food pairing.
     ═══════════════════════════════════════════════════════════════ -->
<section id="pairing-station-bar" class="menu-pairing-station">
    <div class="container pairing-station__inner">

        <!-- The reflection of the connector that ends the section above, at every width (author, 23 Sep 2026;
             phones only before — Figma Picker 2109:130226) -->
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/tryTheMatchMaker-reflection.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/tryTheMatchMaker-reflection.svg',
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
                'default_index' => sweet_pepper_pairing_index( $pairings ), // the record's first row (Finlandia — matches Figma)
                'link_menu'     => 'food',
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
