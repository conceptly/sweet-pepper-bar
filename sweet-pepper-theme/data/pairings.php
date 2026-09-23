<?php
/**
 * Pairings — the dish picker's six rows as typed before they moved into WordPress.
 * Fallback for sweet_pepper_food_pairings() while the «Гастробот» record is empty, and
 * the seed source (tools/page-seed.php pairings — photos → media library).
 *
 *   dish        — the tag label · dish_short — the ticket's shorter name (optional)
 *   description — the ticket's line about the dish (a placeholder on every row but the soup)
 *   reply       — the bar's answer · drink_section — the drinks-page anchor
 *   ru          — Russian twins: dish names from menu.md; the pumpkin soup's line, the
 *                 Finlandia / Ararat / sea-buckthorn replies from about-page-copy-ru-draft.md
 *                 → Подбор пары; the other three replies follow their pattern (mine, to review).
 *
 * @package Sweet_Pepper
 */

return [
    [
        'slug'          => 'pumpkin-soup',
        'dish'          => 'Pumpkin Soup',
        'dish_short'    => '',
        'description'   => 'The legend of the Kirova street',
        'food_img'      => 'food/lunch/pumpkin.png',
        'bar_img'       => 'bar/infusions/infusions-lenya-11.jpg',
        'reply'         => 'A shot of the buckthorn infusion',
        'drink_section' => 'infusions',
        'default'       => false,
        'ru'            => [ 'dish' => 'Тыквенный суп', 'description' => 'Был сезонным. Остался по вашим просьбам.', 'reply' => 'Стопка облепиховой настойки' ],
    ],
    [
        'slug'          => 'draniki',
        'dish'          => 'Signature Draniki',
        'dish_short'    => '',
        'description'   => 'The legend of the Kirova street',
        'food_img'      => 'food/dinner/draniki-2.jpg',
        'bar_img'       => 'bar/infusions/infusions-lenya-09.jpg',
        'reply'         => 'A shot of the cranberry infusion',
        'drink_section' => 'infusions',
        'default'       => false,
        'ru'            => [ 'dish' => 'Фирменные драники', 'reply' => 'Стопка клюквенной настойки' ],
    ],
    [
        'slug'          => 'beefsteak',
        'dish'          => 'Beefsteak with Egg',
        'dish_short'    => '',
        'description'   => 'The legend of the Kirova street',
        'food_img'      => 'food/dinner/minced-beefsteak-07.jpg',
        'bar_img'       => 'bar/hard-drinks/jim-beam-1.jpg',
        'reply'         => 'Jack Daniels on ice',
        'drink_section' => 'spirits',
        'default'       => false,
        'ru'            => [ 'dish' => 'Бифштекс с яйцом', 'reply' => 'Jack Daniels со льдом' ],
    ],
    [
        'slug'          => 'roast',
        'dish'          => 'Yaroslavl Pork Roast',
        'dish_short'    => 'Yaroslavl Roast',
        'description'   => 'The legend of the Kirova street',
        'food_img'      => 'food/dinner/zharkoe-1.jpg',
        'bar_img'       => 'bar/hard-drinks/finlandia-3.jpg',
        'reply'         => 'A shot of the Finlandia',
        'drink_section' => 'spirits',
        'default'       => true,
        'ru'            => [ 'dish' => 'Жаркое по-ярославски', 'dish_short' => 'Жаркое', 'reply' => 'Стопка водки Finlandia' ],
    ],
    [
        'slug'          => 'wings',
        'dish'          => 'Smoked Pepper Wings',
        'dish_short'    => 'Chicken Wings',
        'description'   => 'The legend of the Kirova street',
        'food_img'      => 'food/dinner/wings-2.jpg',
        'bar_img'       => 'bar/hard-drinks/ararat-1.jpg',
        'reply'         => 'A shot of the Ararat cognac',
        'drink_section' => 'spirits',
        'default'       => false,
        'ru'            => [ 'dish' => 'Крылышки-гриль', 'dish_short' => 'Крылышки', 'reply' => 'Бокал коньяка «Арарат»' ],
    ],
    [
        'slug'          => 'pasta',
        'dish'          => 'Chicken Pasta',
        'dish_short'    => '',
        'description'   => 'The legend of the Kirova street',
        'food_img'      => 'food/lunch/chicken-pasta-1.jpg',
        'bar_img'       => 'bar/wine/red-2.jpg',
        'reply'         => 'Jim Beam on ice',
        'drink_section' => 'spirits',
        'default'       => false,
        'ru'            => [ 'dish' => 'Фарфалле с курицей', 'reply' => 'Jim Beam со льдом' ],
    ],
];
