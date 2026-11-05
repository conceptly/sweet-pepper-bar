<?php
/**
 * Menu data: Soups — the rows as typed before the menu moved into WordPress.
 *
 * Two jobs: the fallback sweet_pepper_menu_subsections() renders while the
 * Soups record in admin is empty, and the source tools/menu-seed.php reads.
 * Rows are dish-row args (template-parts/components/dish-row.php).
 *
 *   ru / title_ru — the Russian twins, from menu.md; read by the seeder only
 *   column — 'left' | 'right'
 *   style  — 'list' (default) | 'card' (the add-ons card, e.g. Favorite Sauces)
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'classics',
        'title_ru' => 'классика', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Light chicken broth',
                'price'       => '185-.',
                'quantity'    => '300 g',
                'description' => 'with egg',
                'ru'          => [ 'dish_name' => 'Лёгкий куриный бульон', 'description' => 'С яйцом' ],
            ],
            [
                'dish_name'   => 'Signature borscht',
                'price'       => '260-.',
                'quantity'    => '350 g',
                'description' => 'with beef & croutons with salo',
                'ru'          => [ 'dish_name' => 'Фирменный борщ', 'description' => 'С говядиной и гренками с салом' ],
                'icons'       => [ 'fire' ],
            ],
            [
                'dish_name'   => 'Pumpkin soup',
                'price'       => '255-.',
                'quantity'    => '220 g',
                'description' => 'Creamy with chicken & basil-walnut pesto',
                'ru'          => [ 'dish_name' => 'Тыквенный суп', 'description' => 'Сливочный с цыплёнком и зелёным песто с базиликом и грецкими орехами' ],
                'icons'       => [ 'fire' ],
            ],
        ],
    ],
    [
        'title'    => 'veggie',
        'title_ru' => 'вегетарианские', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Pumpkin soup',
                'price'       => '215-.',
                'quantity'    => '180 g',
                'description' => 'Vegetarian version with vegetable broth and home-made pesto',
                'ru'          => [ 'dish_name' => 'Тыквенный суп', 'description' => 'Вегетарианская версия' ],
                'icons'       => [ 'veg' ],
            ],
            [
                'dish_name'   => 'Mushroom mug',
                'price'       => '295-.',
                'quantity'    => '220 g',
                'description' => 'On cream',
                'ru'          => [ 'dish_name' => 'Грибная кружка', 'description' => 'На сливках' ],
                'icons'       => [ 'veg' ],
            ],
            [
                'dish_name'   => 'Vegan mushroom mug',
                'price'       => '255-.',
                'quantity'    => '190 g',
                'description' => 'Vegan version with mushroom broth',
                'ru'          => [ 'dish_name' => 'Грибная кружка', 'description' => 'Вегетарианская версия' ],
                'icons'       => [ 'veg' ],
            ],
        ],
    ],
];
