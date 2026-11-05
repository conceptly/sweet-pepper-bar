<?php
/**
 * Menu data: No Buzz — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'virgin cocktails',
        'title_ru' => 'невинные коктейли',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Singapore Sling',
                'price'       => '270-.',
                'quantity'    => '300 ml',
                'description' => 'Non-alc gin, fresh lemon, grenadine, pineapple juice.',
                'ru'          => [ 'dish_name' => 'Сингапурский слинг', 'description' => 'Безалкогольный джин, лимонный фреш, сироп гренадин, ананасовый сок.' ],
            ],
            [
                'dish_name'   => 'Salty Dog',
                'price'       => '270-.',
                'quantity'    => '250 ml',
                'description' => 'Non-alc gin, fresh lemon, sugar syrup, grapefruit juice.',
                'ru'          => [ 'dish_name' => 'Солти дог', 'description' => 'Безалкогольный джин, лимонный фреш, сахарный сироп, сок грейпфрут.' ],
            ],
            [
                'dish_name'   => 'Negroni',
                'price'       => '270-.',
                'quantity'    => '150 ml',
                'description' => 'Non-alc gin, non-alc bitter.',
                'ru'          => [ 'dish_name' => 'Негрони', 'description' => 'Безалкогольный джин, безалкогольный биттер.' ],
            ],
            [
                'dish_name'   => 'Mojito',
                'price'       => '270-.',
                'quantity'    => '300 ml',
                'description' => 'Non-alc rum, fresh lemon, sugar syrup, lime, mint, soda.',
                'ru'          => [ 'dish_name' => 'Мохито', 'description' => 'Безалкогольный ром, лимонный фреш, сахарный сироп, лайм, мята, содовая.' ],
            ],
            [
                'dish_name'   => 'Rongo',
                'price'       => '270-.',
                'quantity'    => '300 ml',
                'description' => 'Non-alc rum, passion fruit, fresh lemon, peach & pineapple juice.',
                'ru'          => [ 'dish_name' => 'Ронго', 'description' => 'Безалкогольный ром, лимонный фреш, сироп маракуйя, сок персик, сок ананас.' ],
            ],
            [
                'dish_name'   => 'Piña Colada',
                'price'       => '270-.',
                'quantity'    => '300 ml',
                'description' => 'Non-alc rum, pineapple juice, coconut cream.',
                'ru'          => [ 'dish_name' => 'Пина колада', 'description' => 'Безалкогольный ром, сок ананас, кокосовые сливки.' ],
            ],
        ],
    ],
    [
        'title'    => 'milkshakes',
        'title_ru' => 'молочные коктейли',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'      => 'Cheese Milkshake',
                'price'          => '255-.',
                'quantity'       => '250 ml',
                'description'    => 'Unique cheese-flavoured milkshake.',
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'ru'             => [ 'dish_name' => 'Сырный', 'description' => 'Молочный коктейль с необычным сырным вкусом.', 'seasonal_label' => 'Лето’26!' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Classic Milkshake',
                'price'       => '255-.',
                'quantity'    => '250 ml',
                'description' => 'Chocolate, banana, banana-chocolate, or vanilla.',
                'ru'          => [ 'dish_name' => 'Классика жанра', 'description' => 'Шоколадный, банановый, бананово-шоколадный или ванильный.' ],
            ],
            [
                'dish_name'   => 'Classic Milkshake XL',
                'price'       => '325-.',
                'quantity'    => '400 ml',
                'description' => 'Chocolate, banana, banana-chocolate, or vanilla.',
                'ru'          => [ 'dish_name' => 'Классика жанра XL', 'description' => 'Шоколадный, банановый, бананово-шоколадный или ванильный.' ],
            ],
        ],
    ],
    [
        'title'    => 'smoothies',
        'title_ru' => 'смузи',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Berry Blast',
                'price'       => '255-.',
                'quantity'    => '250 ml',
                'description' => 'Cranberry, blackcurrant, honey, berry juice.',
                'ru'          => [ 'dish_name' => 'Ягодный взрыв', 'description' => 'Клюква, чёрная смородина, мёд, морс.' ],
            ],
            [
                'dish_name'   => "Robinson's Breakfast",
                'price'       => '335-.',
                'quantity'    => '250 ml',
                'description' => 'Banana, pineapple, ice cream, milk.',
                'ru'          => [ 'dish_name' => 'Завтрак Робинзона', 'description' => 'Банан, ананас, пломбир, молоко.' ],
            ],
        ],
    ],
    [
        'title'    => 'juices & lemonades',
        'title_ru' => 'соки и лимонады', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Classic Juice',
                'price'       => '95-.',
                'quantity'    => '250 ml',
                'description' => 'Pineapple, orange, apple, peach, grapefruit, tomato, or cherry.',
                'ru'          => [ 'dish_name' => 'Классический сок', 'description' => 'Ананас, апельсин, яблоко, персик, грейпфрут, томат или вишня.' ],
            ],
            [
                'dish_name'   => 'Fresh Squeezed Juice',
                'price'       => '265-.',
                'quantity'    => '200 ml',
                'description' => 'Orange or grapefruit.',
                'ru'          => [ 'dish_name' => 'Свежевыжатый сок', 'description' => 'Апельсин или грейпфрут.' ],
            ],
            [
                'dish_name'   => 'Signature Lemonade',
                'price'       => '170-. / 455-.',
                'quantity'    => '350 ml / 1 L',
                'description' => 'Raspberry & mint, sea buckthorn, or juicy orange.',
                'ru'          => [ 'dish_name' => 'Фирменный лимонад', 'description' => 'Малина с мятой, яркая облепиха или сочный апельсин.' ],
            ],
            [
                'dish_name'      => 'Seasonal Lemonade',
                'price'          => '170-.',
                'quantity'       => '350 ml',
                'description'    => 'Apple-sorrel or watermelon-cucumber.',
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'ru'             => [ 'dish_name' => 'Сезонный лимонад', 'description' => 'Яблоко-щавель или арбуз-огурец.', 'seasonal_label' => 'Лето’26!' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'soft drinks',
        'title_ru' => 'софт напитки',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Cola (on tap)',
                'price'       => '90-.',
                'quantity'    => '250 ml',
                'description' => 'Classic cola, served fresh.',
                'ru'          => [ 'dish_name' => 'Кола (на разлив)', 'description' => 'Классическая кола, свежая из крана.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Coca-Cola',
                'price'       => '255-.',
                'quantity'    => '330 ml',
                'description' => 'Glass bottle.',
                'ru'          => [ 'dish_name' => 'Coca-Cola', 'description' => 'В стекле.' ],
            ],
            [
                'dish_name'   => 'Bon Aqua',
                'price'       => '150-.',
                'quantity'    => '330 ml',
                'description' => 'Still water, glass bottle.',
                'ru'          => [ 'dish_name' => 'Bon Aqua', 'description' => 'Негазированная вода, в стекле.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Energy Drink',
                'price'       => '235-.',
                'quantity'    => '250 ml',
                'description' => 'Energy boost, adults only.',
                'ru'          => [ 'dish_name' => 'Энергетик', 'description' => 'Заряд бодрости, строго 18+.' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'kids drinks',
        'title_ru' => 'детские напитки', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => "Kids' Milkshake",
                'price'       => '210-.',
                'description' => 'Vanilla, banana, or chocolate.',
                'ru'          => [ 'dish_name' => 'Молочный коктейль', 'description' => 'Ванильный, банановый или шоколадный.' ],
            ],
            [
                'dish_name'   => "Kids' Juice",
                'price'       => '70-.',
                'description' => 'Any flavour of choice.',
                'ru'          => [ 'dish_name' => 'Сок', 'description' => 'На выбор.' ],
            ],
            [
                'dish_name'   => "Kids' Latte",
                'price'       => '80-.',
                'description' => 'Caffeine-free — nut, vanilla, or caramel.',
                'ru'          => [ 'dish_name' => 'Детский латте', 'description' => 'Без кофе — ореховый, ванильный или карамельный.' ],
            ],
        ],
    ],
];
