<?php
/**
 * Menu data: Kids — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => "kids' breakfast",
        'title_ru' => 'детский завтрак', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Pancakes with jam',
                'price'       => '120-.',
                'quantity'    => '2 pcs',
                'description' => 'Thin, warm, and gone in a minute.',
                'ru'          => [ 'dish_name' => 'Блинчики с вареньем', 'description' => 'Тонкие, тёплые — и исчезают за минуту.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Oatmeal with fruit',
                'price'       => '160-.',
                'description' => 'Impossible to leave unfinished.',
                'ru'          => [ 'dish_name' => 'Каша овсяная с фруктами', 'description' => 'Её просто невозможно не доесть.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Syrniki with jam',
                'price'       => '195-.',
                'quantity'    => '2 pcs',
                'description' => 'A kids portion, with the jam of their choice.',
                'ru'          => [ 'dish_name' => 'Сырники с вареньем', 'description' => 'Детская порция, варенье — на выбор.' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => "kids' sides",
        'title_ru' => 'детские гарниры', // draft — not in menu.md
        'column'   => 'left',
        'note'     => "If you'd like to order from the Kids' Menu for an adult, adult pricing applies at Pepper.",
        'note_ru'  => 'Если вы хотите сделать заказ по детскому меню для взрослого, в Перце действует взрослая цена.',
        'dishes'   => [
            [
                'dish_name'   => 'Fresh vegetable salad',
                'price'       => '90-.',
                'description' => 'A light mix of seasonal vegetables.',
                'icons'       => [ 'veg' ],
                'ru'          => [ 'dish_name' => 'Салат из свежих овощей', 'description' => 'Лёгкий микс из сезонных овощей.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Fettuccine',
                'price'       => '80-.',
                'description' => 'A kids portion of plain pasta.',
                'ru'          => [ 'dish_name' => 'Фетучини', 'description' => 'Детская порция пасты, без соуса.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Potato wedges',
                'price'       => '120-.',
                'description' => 'Golden crispy wedges.',
                'icons'       => [ 'veg' ],
                'ru'          => [ 'dish_name' => 'Картофельные дольки', 'description' => 'Золотистые и хрустящие.' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => "kids' lunch",
        'title_ru' => 'детский обед', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Nuggets',
                'price'       => '165 / 225-.',
                'quantity'    => '3 / 5 pcs',
                'description' => 'Home-made from coarse-chopped chicken breast.',
                'ru'          => [ 'dish_name' => 'Наггетсы', 'description' => 'Домашние, из рубленой куриной грудки.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => "Peppers' pelmeni",
                'price'       => '180-.',
                'description' => 'Pork and beef, a kids portion with broth and fresh herbs.',
                'ru'          => [ 'dish_name' => 'Пельмешки от Перцев', 'description' => 'Свинина и говядина, детская порция с бульоном и свежей зеленью.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Fettuccine with cheese',
                'price'       => '150-.',
                'description' => 'A kids portion of the favourite pasta in cream sauce.',
                'ru'          => [ 'dish_name' => 'Фетучини с сыром', 'description' => 'Детская порция любимой пасты в сливочном соусе.' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => "kids' dessert",
        'title_ru' => 'детский десерт', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Ice cream',
                'price'       => '90-.',
                'description' => 'Vanilla, chocolate, pistachio.',
                'ru'          => [ 'dish_name' => 'Мороженое', 'description' => 'Ванильное, шоколадное, фисташковое' ],
            ],
            [
                'dish_name'   => 'Berry shortbread',
                'price'       => '60-.',
                'description' => 'A soft shortcake with berries.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Ягодный коржик', 'description' => 'Мягкий коржик с ягодами.' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'Kids Sauces',
        'title_ru' => 'Детские соусы', // draft — not in menu.md
        'column'   => 'right',
        'style'    => 'card',
        'dishes'   => [
            [
                'dish_name'   => 'Add any',
                'price'       => '50-.',
                'quantity'    => '50 g',
                'description' => 'Ketchup, cheese, Caesar, sour cream',
                'ru'          => [ 'dish_name' => 'Соус на выбор', 'description' => 'Кетчуп, сырный, цезарь, сметана' ],
            ],
        ],
    ],
];
