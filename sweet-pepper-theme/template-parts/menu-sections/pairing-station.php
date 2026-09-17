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

// Hardcoded pairing data — each food dish matched to a bar recommendation.
// Phase 2: pull from ACF repeater or dish CPT relationship field.
$pairings = [
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
?>

<!-- ═══════════════════════════════════════════════════════════════
     PAIRING STATION — Find Your Match
     Figma: picker-day (708:19997)
     The page's one interactive element, at the food → drinks seam.
     ═══════════════════════════════════════════════════════════════ -->
<section id="pairing-station" class="menu-pairing-station">
    <div class="container pairing-station__inner">

        <!-- Phones only: the reflection of the section connector above (Figma Picker 2109:130226) -->
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
                <h2 class="pairing-station__title molot-text">Find Your Match!</h2>
                <p class="pairing-station__subtitle">Pick a plate — the bar takes care of the rest.</p>
            </div>

            <!-- Dish Picker component -->
            <?php
            get_template_part( 'template-parts/components/dish-picker', null, [
                'pairings'      => $pairings,
                'default_index' => 3, // Yaroslavl Pork Roast — matches Figma default
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
