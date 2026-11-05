<?php
/**
 * Menu data: Breakfast — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'Eggs',
        'title_ru' => 'Яйца',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => "Peppers' Breakfast",
                'price'       => '345-.',
                'quantity'    => '280 g',
                'description' => 'Fried eggs with vegetables, toast & a patty',
                'icons'       => [ 'egg' ],
                'highlight'   => true,
                'ru'          => [ 'dish_name' => 'Завтрак от Перцев', 'description' => 'Глазунья с овощами, тостами и котлетой' ],
            ],
            [
                'dish_name'   => 'Fried eggs',
                'price'       => '245-.',
                'quantity'    => '180 g',
                'description' => 'with tomatoes & herbs',
                'ru'          => [ 'dish_name' => 'Глазунья', 'description' => 'С томатами и зеленью' ],
            ],
            [
                'dish_name'   => 'Omelette',
                'price'       => '315-.',
                'quantity'    => '230 g',
                'description' => 'with cheese & mushrooms',
                'ru'          => [ 'dish_name' => 'Омлет', 'description' => 'С сыром и грибами' ],
            ],
        ],
    ],
    [
        'title'    => 'Pancakes',
        'title_ru' => 'Блины',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'With jam',
                'price'       => '170-.',
                'quantity'    => '3 pcs / 150 g',
                'description' => 'or topping',
                'ru'          => [ 'dish_name' => 'С вареньем', 'description' => 'Или топпингом' ],
            ],
            [
                'dish_name'   => 'With cottage cheese',
                'price'       => '195-.',
                'quantity'    => '2 pcs / 180 g',
                'description' => '& jam',
                'icons'       => [ 'spicy-1' ],
                'highlight'   => true,
                'ru'          => [ 'dish_name' => 'С творогом', 'description' => 'И вареньем' ],
            ],
            [
                'dish_name'   => 'With salmon',
                'price'       => '425-.',
                'quantity'    => '2 pcs / 180 g',
                'description' => '& cream cheese',
                'icons'       => [ 'fish' ],
                'ru'          => [ 'dish_name' => 'С лососем', 'description' => 'И сливочным сыром' ],
            ],
        ],
    ],
    [
        'title'    => 'Favorite Sauces',
        'title_ru' => 'Любимые соусы',
        'column'   => 'left',
        'style'    => 'card',
        'dishes'   => [
            [
                'dish_name'   => 'Add any',
                'price'       => '65-.',
                'quantity'    => '50 g',
                'description' => 'Cheese, Caesar, BBQ, Tartar, Sour cream, Sicilian, Mustard',
                'ru'          => [ 'dish_name' => 'Любой на выбор', 'description' => 'Сырный, Цезарь, Барбекю, Тартар, Сметана, Сицилийский, Горчица' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'Porridge',
        'title_ru' => 'Каша',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Oatmeal',
                'price'       => '205-. / 265-.',
                'quantity'    => '280 g / 320 g',
                'description' => 'Freshly cooked, in milk or water',
                'options'     => [
                    'with your favorite topping',
                    'with seasonal fruits',
                ],
                'ru'          => [ 'dish_name' => 'Овсянка', 'description' => 'Свежесваренная, на молоке или на воде', 'options' => [ 'С топпингом', 'С фруктами' ] ], // draft — not in menu.md
            ],
            [
                'dish_name' => '+ veggie milk?',
                'price'     => '+65-.',
                'ru'        => [ 'dish_name' => '+ растительное молоко?' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'Morning Sandwiches',
        'title_ru' => 'Утренние сэндвичи', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Bacon roll',
                'price'       => '305-.',
                'quantity'    => '280 g',
                'description' => 'omelette, tomato & bacon filling',
                'ru'          => [ 'dish_name' => 'Утренний ролл с беконом', 'description' => 'С омлетом, томатом и беконом' ],
            ],
            [
                'dish_name'   => 'Chicken roll',
                'price'       => '325-.',
                'quantity'    => '280 g',
                'description' => 'omelette, tomato & chicken filling',
                'ru'          => [ 'dish_name' => 'Утренний ролл с цыплёнком', 'description' => 'С омлетом, томатом и цыплёнком' ],
            ],
            [
                'dish_name'   => 'Turkey roll',
                'price'       => '325-.',
                'quantity'    => '280 g',
                'description' => 'omelette, tomato & chicken filling',
                'ru'          => [ 'dish_name' => 'Утренний ролл с индейкой', 'description' => 'С омлетом, томатом и индейкой' ],
            ],
            [
                'dish_name'   => 'Shrimp roll',
                'price'       => '325-.',
                'quantity'    => '280 g',
                'description' => 'omelette, tomato & chicken filling',
                'ru'          => [ 'dish_name' => 'Утренний ролл с креветками', 'description' => 'С омлетом, томатом и креветками' ],
            ],
            [
                'dish_name'   => 'Morning egg bagel',
                'price'       => '325-.',
                'quantity'    => '220 g',
                'description' => 'with bacon, fried egg & tomato',
                'ru'          => [ 'dish_name' => 'Утренний бейгл с яйцом', 'description' => 'С беконом, глазуньей и томатом' ],
            ],
        ],
    ],
];
