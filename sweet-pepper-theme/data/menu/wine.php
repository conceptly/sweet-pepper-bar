<?php
/**
 * Menu data: Wine — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'white wine',
        'title_ru' => 'белое вино', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Cape Original Muscat',
                'price'       => '325-. / 2050-.',
                'quantity'    => '125 ml / 750 ml',
                'description' => 'Sweet — South Africa. Striking fruit & floral, tangerine sweetness.',
                'ru'          => [ 'dish_name' => 'Cape Original Мускат', 'description' => 'Сладкое — ЮАР, Вестерн Кейп. Взрыв удивительных фруктовых и цветочных нот, а на языке ощущается мандариновая сладость леденца.' ],
            ],
            [
                'dish_name'   => 'Riesling Sturmwolken',
                'price'       => '325-. / 2050-.',
                'quantity'    => '125 ml / 750 ml',
                'description' => 'Semi-dry — Germany, Pfalz. Ripe apple & honeysuckle, fruity notes.',
                'ru'          => [ 'dish_name' => 'Рислинг Sturmwolken', 'description' => 'Полусухое — Германия, Пфальц. Насыщенный вкус спелого яблока и нежной жимолости с яркими фруктовыми оттенками.' ],
            ],
            [
                'dish_name'   => 'Sauvignon Blanc Arco Bay',
                'price'       => '475-. / 2750-.',
                'quantity'    => '125 ml / 750 ml',
                'description' => 'Dry — New Zealand. Blackcurrant leaf, tropical, gooseberry finish.',
                'ru'          => [ 'dish_name' => 'Совиньон Блан Arco Bay', 'description' => 'Сухое — Новая Зеландия, Мальборо. Свежий лист смородины с яркими тропиками, оставляет приятное послевкусие крыжовника.' ],
            ],
        ],
    ],
    [
        'title'    => 'red wine',
        'title_ru' => 'красное вино', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Tarapaca Merlot',
                'price'       => '315-. / 2050-.',
                'quantity'    => '125 ml / 750 ml',
                'description' => 'Dry — Chile. Spiced cherry, ripe plum chords.',
                'ru'          => [ 'dish_name' => 'Tarapaca Мерло', 'description' => 'Сухое — Чили, Центральная Долина. Окутывает пряной вишней, раскрывается во вкусе аккордами спелой сливы.' ],
            ],
            [
                'dish_name'   => 'Garnacha Celebrities',
                'price'       => '315-. / 2050-.',
                'quantity'    => '125 ml / 750 ml',
                'description' => 'Dry — Spain. Wild berries, dark fruit, chokeberry note.',
                'ru'          => [ 'dish_name' => 'Гарнача Celebrities', 'description' => 'Сухое — Испания, Кариньен. Богато лесными ягодами и спелыми тёмными фруктами с обволакивающей черноплодкой во вкусе.' ],
            ],
            [
                'dish_name'   => 'Lakky Shiraz',
                'price'       => '315-. / 2050-.',
                'quantity'    => '125 ml / 750 ml',
                'description' => 'Semi-dry — Australia. Raspberry jam, tobacco, spiced finish.',
                'ru'          => [ 'dish_name' => 'Lakky Шираз', 'description' => 'Полусухое — Австралия. Сочный малиновый джем переплетается с табачным листом и долгим, пряным послевкусием.' ],
            ],
        ],
    ],
    [
        'title'    => 'sparkling wine',
        'title_ru' => 'игристое', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Bio Bio Bubbles',
                'price'       => '345-. / 2250-.',
                'quantity'    => '125 ml / 750 ml',
                'description' => 'Extra dry — Italy, Sicily. Citrus & green fruit, invigorating freshness.',
                'ru'          => [ 'dish_name' => 'Cielo Bio Bio Bubbles', 'description' => 'Экстра драй — Италия, Сицилия. Соблазнительный аромат цитрусов и зелёных фруктов с бодрящей свежестью во вкусе.' ],
            ],
        ],
    ],
    [
        'title'    => 'sherry & fortified',
        'title_ru' => 'херес и креплёное', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name' => 'Xepec Tio Toto Cream',
                'price'     => '455-.',
                'quantity'  => '100 ml',
                'ru'        => [ 'dish_name' => 'Херес Tio Toto Cream' ],
            ],
            [
                'dish_name'   => 'Xepec Tio Toto Fino',
                'price'       => '455-.',
                'quantity'    => '100 ml',
                'description' => 'Light and dry sherry.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Херес Tio Toto Fino', 'description' => 'Лёгкий сухой херес.' ], // draft description — not in menu.md
            ],
            [
                'dish_name'   => 'Port',
                'price'       => '365-.',
                'quantity'    => '100 ml',
                'description' => 'World famous Portugal fortified wine',
                'ru'          => [ 'dish_name' => 'Порто', 'description' => 'Знаменитое португальское креплёное вино.' ], // draft description — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'vermouths',
        'title_ru' => 'вермуты', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Atxa Vermouth',
                'price'       => '150-.',
                'quantity'    => '40 ml',
                'description' => 'Aromatic Spanish vermouth.',
                'ru'          => [ 'dish_name' => 'Atxa Vermouth', 'description' => 'Ароматный испанский вермут.' ], // draft description — not in menu.md
            ],
        ],
    ],
];
