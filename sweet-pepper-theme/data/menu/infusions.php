<?php
/**
 * Menu data: Infusions — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => '',
        'title_ru' => '',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'      => 'Icy Lemon',
                'price'          => '150-. / 1300-.',
                'quantity'       => '40 ml / 500 ml',
                'description'    => 'Crisp and zesty, served chilled.',
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'ru'             => [ 'dish_name' => 'Ледяная лимонная', 'description' => 'Свежая и цитрусовая, подаётся охлаждённой.', 'seasonal_label' => 'Лето’26!' ], // description + seasonal label draft — not in menu.md
            ],
            [
                'dish_name'   => 'Strawberry',
                'price'       => '150-. / 1300-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Sweet and fruity, a crowd favourite.',
                'ru'          => [ 'dish_name' => 'Клубничка', 'description' => 'Сладкая и ягодная — любимица гостей.' ], // description draft — not in menu.md
            ],
            [
                'dish_name'   => 'Legendary Blackcurrant',
                'price'       => '150-. / 1300-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Deep berry flavor, our signature.',
                'ru'          => [ 'dish_name' => 'Легендарная Смородина', 'description' => 'Глубокий ягодный вкус — визитная карточка Перца.' ], // description draft — not in menu.md
            ],
            [
                'dish_name'   => 'Cranberry',
                'price'       => '150-. / 1300-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Bold and refreshing classic.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Клюковка', 'description' => 'Яркая и освежающая классика.' ], // description draft — not in menu.md
            ],
            [
                'dish_name'   => 'Sea buckthorn',
                'price'       => '150-. / 1300-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Bright citrusy tartness.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Облепиховая', 'description' => 'Солнечная, с цитрусовой кислинкой.' ], // description draft — not in menu.md
            ],
            [
                'dish_name'   => 'Yaroslavl Blueberry',
                'price'       => '150-. / 1300-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Local berries, smooth finish.',
                'ru'          => [ 'dish_name' => 'Ярославская Черника', 'description' => 'Местная ягода, мягкое послевкусие.' ], // description draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => '',
        'title_ru' => '',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Salted Caramel',
                'price'       => '150-. / 1300-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Sweet, salty, irresistible.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Солёная Карамель', 'description' => 'Сладкая, солёная, неотразимая.' ], // description draft — not in menu.md
            ],
            [
                'dish_name'   => 'She-Devil',
                'price'       => '150-. / 1300-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Prune & spices, bold warmth.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Чертовка', 'description' => 'Чернослив и специи.' ],
            ],
            [
                'dish_name'   => 'Horseradish',
                'price'       => '150-. / 1300-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => "For the brave — a taste of Yaroslavl's hot side.", // home-copy-en.md → 3 (was the placeholder «description», 25 Sep 2026)
                'icons'       => [ 'fire', 'yaroslavl-logo' ],
                'ru'          => [ 'dish_name' => 'Хреновуха', 'description' => 'Ядрёная и бодрящая — по-ярославски.' ], // description draft — not in menu.md
            ],
            [
                'dish_name'   => 'Raspberry Gin',
                'price'       => '190-. / 1800-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Gin infused with raspberries.', // home-copy-en.md → 3 (was a draft, 25 Sep 2026)
                'ru'          => [ 'dish_name' => 'Малина на Джине', 'description' => 'Ягодная настойка на джине.' ], // description draft — not in menu.md
            ],
            [
                'dish_name'   => 'Cherry Cognac',
                'price'       => '190-. / 1800-.',
                'quantity'    => '40 ml / 500 ml',
                'description' => 'Rich cherry with cognac warmth.',
                'ru'          => [ 'dish_name' => 'Вишня на коньяке', 'description' => 'Спелая вишня и тепло коньяка.' ], // description draft — not in menu.md
            ],
            [
                'dish_name'   => 'Yaroslavl Advocaat',
                'price'       => '150-.',
                'quantity'    => '40 ml',
                'description' => 'Creamy egg liqueur, shot only.',
                'ru'          => [ 'dish_name' => 'Наш Адвокат', 'description' => 'Сливочный яичный ликёр, только шотом.' ], // description draft — not in menu.md
            ],
        ],
    ],
];
