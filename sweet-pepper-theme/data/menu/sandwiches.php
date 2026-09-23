<?php
/**
 * Menu data: Sandwiches — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'Sandwiches',
        'title_ru' => 'Сэндвичи',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Chicken Club',
                'price'       => '305-.',
                'quantity'    => '210 g',
                'description' => 'with chicken breast, caesar sauce, cheese and pickles',
                'ru'          => [ 'dish_name' => 'Классика жанра', 'description' => 'С куриной грудкой, соусом цезарь, сыром и солёными огурцами' ], // draft — not in menu.md (description)
            ],
            [
                'dish_name'   => 'Turkey Club',
                'price'       => '325-.',
                'quantity'    => '210 g',
                'description' => 'with turkey',
                'ru'          => [ 'dish_name' => 'Классика жанра', 'description' => 'С индейкой' ],
            ],
            [
                'dish_name'   => 'Salmon Club',
                'price'       => '385-.',
                'quantity'    => '210 g',
                'description' => 'with salmon, cream cheese, and fresh cucumber',
                'ru'          => [ 'dish_name' => 'Классика жанра', 'description' => 'С лососем, сливочным сыром и свежим огурцом' ], // draft — not in menu.md (description)
            ],
            [
                'dish_name' => 'Sandwich set',
                'price'     => '435-.',
                'quantity'  => '290 g',
                'icons'     => [ 'fire' ],
                'options'   => [
                    'Chicken & Fries',
                    'Turkey & Potato Wedges',
                ],
                'ru'        => [ 'dish_name' => 'Сэндвич-сет', 'options' => [ 'С цыплёнком и фри', 'С индейкой и картофельными дольками' ] ],
            ],
        ],
    ],
    [
        'title'    => 'Bagels',
        'title_ru' => 'Бейглы',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Pepper bagel',
                'price'       => '335-.',
                'quantity'    => '240 g',
                'description' => 'with spiced beef, gouda & tomato',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Пеппер-бейгл', 'description' => 'С пряной говядиной, гаудой и томатом' ],
            ],
            [
                'dish_name'   => 'Caesar bagel',
                'price'       => '325-.',
                'quantity'    => '240 g',
                'description' => 'with chicken, parmesan & tomato',
                'ru'          => [ 'dish_name' => 'Цезарь-бейгл', 'description' => 'С цыплёнком, пармезаном и томатом' ],
            ],
            [
                'dish_name'   => 'Salmon bagel',
                'price'       => '395-.',
                'quantity'    => '240 g',
                'description' => 'cream cheese, cucumber, capers & red onion',
                'ru'          => [ 'dish_name' => 'Бейгл с лососем', 'description' => 'Со сливочным сыром, огурцом, каперсами и красным луком' ],
            ],
            [
                'dish_name'   => 'Morning egg bagel',
                'price'       => '325-.',
                'quantity'    => '240 g',
                'description' => 'with bacon, fried egg & tomato',
                'ru'          => [ 'dish_name' => 'Утренний бейгл с яйцом', 'description' => 'С беконом, глазуньей и томатом' ],
            ],
            [
                'dish_name'   => 'Bagel set with a patty',
                'price'       => '435-.',
                'quantity'    => '350 g',
                'description' => 'patty, cheese, pickles & tomatoes with potato wedges',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Бейгл-сет с котлетой', 'description' => 'С сочной котлетой, сыром, солёными огурцами и томатами с гарниром из картофельных долек' ],
            ],
        ],
    ],
];
