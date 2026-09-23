<?php
/**
 * Menu data: Beer — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'bottled',
        'title_ru' => 'в стекле',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name' => 'Krušovice',
                'price'     => '225-.',
                'quantity'  => '450 ml',
                'ru'        => [ 'dish_name' => 'Крушовице' ],
            ],
            [
                'dish_name'   => 'Krušovice Non-Alc',
                'price'       => '195-.',
                'quantity'    => '330 ml',
                'description' => 'All the taste, zero alcohol.',
                'ru'          => [ 'dish_name' => 'Крушовице', 'description' => 'Безалкогольное.' ],
            ],
            [
                'dish_name'   => 'Craft',
                'price'       => '450-.',
                'quantity'    => '450 ml',
                'description' => "Can or bottle — ask your server for today's selection.",
                'ru'          => [ 'dish_name' => 'Крафт', 'description' => 'Банка или бутылка.' ],
            ],
        ],
    ],
    [
        'title'    => 'on tap',
        'title_ru' => 'разливное',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Oklers Weizen',
                'price'       => '235-. / 365-.',
                'quantity'    => '250 ml / 400 ml',
                'description' => 'OG 11%, ABV 4.5%. Bavarian-style wheat beer.',
                'ru'          => [ 'dish_name' => 'Оклерс Вайцен', 'description' => 'Пл. 11%, алк. 4.5%. Пшеничное пиво в баварском стиле.' ], // second sentence draft — not in menu.md
            ],
            [
                'dish_name'   => 'Soviet Pilsner',
                'price'       => '235-. / 365-.',
                'quantity'    => '250 ml / 400 ml',
                'description' => 'OG 11%, ABV 4.3%. Crisp lager, local brew.',
                'ru'          => [ 'dish_name' => 'Советский Пилснер', 'description' => 'Пл. 11%, алк. 4.3%. Бодрый лагер местной варки.' ], // second sentence draft — not in menu.md
            ],
        ],
    ],
];
