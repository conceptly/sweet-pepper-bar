<?php
/**
 * Food → drink pairings for the dish picker.
 *
 * One list, two homes: the menu page's pairing station and the About page's Concept
 * picker (website-brief.md: the surfaces that show a dish reference one record, they
 * never hold their own copy). Until 18 Sep 2026 About carried a three-dish copy with
 * its own wording, and the two had drifted.
 * Phase 2: pull from an ACF repeater or a dish CPT relationship field.
 *
 * @package Sweet_Pepper
 */

/**
 * Each entry: slug, dish (tag label), card_name (ticket name), description,
 * food_img / bar_img (relative to assets/images/), pairing, bar_section (drinks anchor).
 */
function sweet_pepper_food_pairings() {
    return [
        [
            'slug'        => 'pumpkin-soup',
            'dish'        => 'Pumpkin Soup',         // tag label
            'card_name'   => 'Pumpkin Soup',          // card display name
            'description' => 'The legend of the Kirova street',
            'food_img'    => 'food/lunch/pumpkin.png',
            'bar_img'     => 'bar/infusions/infusions-lenya-11.jpg',
            'pairing'     => 'A shot of the buckthorn infusion',
            'bar_section' => 'infusions',
        ],
        [
            'slug'        => 'draniki',
            'dish'        => 'Signature Draniki',
            'card_name'   => 'Signature Draniki',
            'description' => 'The legend of the Kirova street',
            'food_img'    => 'food/dinner/draniki-2.jpg',
            'bar_img'     => 'bar/infusions/infusions-lenya-09.jpg',
            'pairing'     => 'A shot of the cranberry infusion',
            'bar_section' => 'infusions',
        ],
        [
            'slug'        => 'beefsteak',
            'dish'        => 'Beefsteak with Egg',
            'card_name'   => 'Beefsteak with Egg',
            'description' => 'The legend of the Kirova street',
            'food_img'    => 'food/dinner/minced-beefsteak-07.jpg',
            'bar_img'     => 'bar/hard-drinks/jim-beam-1.jpg',
            'pairing'     => 'Jack Daniels on ice',
            'bar_section' => 'spirits',
        ],
        [
            'slug'        => 'roast',
            'dish'        => 'Yaroslavl Pork Roast',  // tag label (longer)
            'card_name'   => 'Yaroslavl Roast',        // card display name (shorter, per Figma)
            'description' => 'The legend of the Kirova street',
            'food_img'    => 'food/dinner/zharkoe-1.jpg',
            'bar_img'     => 'bar/hard-drinks/finlandia-3.jpg',
            'pairing'     => 'A shot of the Finlandia',
            'bar_section' => 'spirits',
        ],
        [
            'slug'        => 'wings',
            'dish'        => 'Smoked Pepper Wings',   // tag label
            'card_name'   => 'Chicken Wings',          // card display name (per Figma)
            'description' => 'The legend of the Kirova street',
            'food_img'    => 'food/dinner/wings-2.jpg',
            'bar_img'     => 'bar/hard-drinks/ararat-1.jpg',
            'pairing'     => 'A shot of the Ararat cognac',
            'bar_section' => 'spirits',
        ],
        [
            'slug'        => 'pasta',
            'dish'        => 'Chicken Pasta',
            'card_name'   => 'Chicken Pasta',
            'description' => 'The legend of the Kirova street',
            'food_img'    => 'food/lunch/chicken-pasta-1.jpg',
            'bar_img'     => 'bar/wine/red-2.jpg',
            'pairing'     => 'Jim Beam on ice',
            'bar_section' => 'spirits',
        ],
    ];
}

/**
 * Index of a pairing by slug — the picker's default pick, without counting by hand.
 */
function sweet_pepper_pairing_index( $pairings, $slug ) {
    $index = array_search( $slug, array_column( $pairings, 'slug' ), true );
    return false === $index ? 0 : $index;
}
