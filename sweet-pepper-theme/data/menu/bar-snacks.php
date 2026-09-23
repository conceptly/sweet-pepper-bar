<?php
/**
 * Menu data: Bar Snacks — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'fried bites',
        'title_ru' => 'во фритюре', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Mozzarella fries',
                'price'       => '335-.',
                'quantity'    => '130 g',
                'description' => 'Breaded, with lingonberry sauce',
                'ru'          => [ 'dish_name' => 'Сыр моцарелла фри', 'description' => 'В панировке с брусничным соусом' ],
            ],
            [
                'dish_name'   => 'Onion rings',
                'price'       => '325-.',
                'quantity'    => '180 g',
                'description' => 'Deep fried with a sauce of your choice',
                'ru'          => [ 'dish_name' => 'Луковые кольца', 'description' => 'Во фритюре, с соусом на выбор' ], // draft — not in menu.md (description)
            ],
            [
                'dish_name'   => 'Borodinsky croutons',
                'price'       => '180-.',
                'quantity'    => '150 g',
                'description' => 'Deep fried with fresh garlic and sour cream',
                'ru'          => [ 'dish_name' => 'Бородинские гренки', 'description' => 'Во фритюре, со свежим чесноком и сметаной' ], // draft — not in menu.md (description)
            ],
        ],
    ],
    [
        'title'    => 'hot bites',
        'title_ru' => 'горячие закуски', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name' => 'Quesadilla',
                'price'     => '295-.',
                'quantity'  => '130 g',
                'options'   => [
                    'Chicken & cheese',
                    'Double cheese',
                ],
                'ru'        => [ 'dish_name' => 'Кесадилья', 'options' => [ 'Цыплёнок и сыр', 'Двойной сыр' ] ],
            ],
            [
                'dish_name'   => 'Cauliflower',
                'price'       => '245-.',
                'quantity'    => '250 g',
                'description' => 'with chili & honey',
                'icons'       => [ 'veg', 'fire' ],
                'ru'          => [ 'dish_name' => 'Цветная капуста', 'description' => 'С чили и мёдом' ],
            ],
            [
                'dish_name' => 'Breaded broccoli',
                'price'     => '255-.',
                'quantity'  => '200 g',
                'icons'     => [ 'veg' ],
                'options'   => [
                    'with parmesan',
                    'veggie with home-made pesto',
                ],
                'ru'        => [ 'dish_name' => 'Брокколи в сухарях', 'options' => [ 'С сыром', 'С песто с базиликом и грецким орехом' ] ],
            ],
        ],
    ],
    [
        'title'    => 'wings & meat',
        'title_ru' => 'крылышки и мясо', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Grilled wings',
                'price'       => '455-./ 645-.',
                'quantity'    => '270 g / 540 g',
                'description' => 'For one, 5 pcs. In honey glaze',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Крылышки-гриль', 'description' => 'На одного 5 штук. В медовой глазури' ],
            ],
            [
                'dish_name'   => 'Meat Set 2026',
                'price'       => '595-.',
                'quantity'    => '285 g',
                'description' => 'With beef, salami, pork, pickles, and croutons',
                'ru'          => [ 'dish_name' => 'Мясной сет 2026', 'description' => 'С говядиной, салями, свининой, солёными огурцами и гренками' ], // draft — not in menu.md (description)
            ],
        ],
    ],
    [
        'title'    => 'draniki',
        'title_ru' => 'драники', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Classic draniki',
                'price'       => '225-.',
                'quantity'    => '250 g',
                'description' => 'Served with sour cream',
                'ru'          => [ 'dish_name' => 'Классические драники', 'description' => 'Со сметаной' ], // draft — not in menu.md (description)
            ],
            [
                'dish_name'   => 'Signature draniki',
                'price'       => '315-.',
                'quantity'    => '250 g',
                'description' => 'With bacon & tomatoes',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Фирменные драники', 'description' => 'С беконом и томатами' ],
            ],
            [
                'dish_name'   => 'Royal draniki',
                'price'       => '395-.',
                'quantity'    => '250 g',
                'description' => 'With salmon and butter or cream cheese',
                'ru'          => [ 'dish_name' => 'Королевские драники', 'description' => 'С лососем и сливочным маслом или сливочным сыром' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'Favorite Sauces',
        'title_ru' => 'Любимые соусы',
        'column'   => 'right',
        'style'    => 'card',
        'dishes'   => [
            [
                'dish_name'   => 'Add any',
                'price'       => '65-.',
                'quantity'    => '50 g',
                'description' => 'Cheese, Caesar, BBQ, Tartar, Sour cream, Sicilian, Mustard',
                'ru'          => [ 'dish_name' => 'Любой на выбор', 'description' => 'Сырный, Цезарь, Барбекю, Тартар, Сметана, Сицилийский, Горчица' ], // draft — not in menu.md (dish_name)
            ],
        ],
    ],
];
