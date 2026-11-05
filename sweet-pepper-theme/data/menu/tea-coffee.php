<?php
/**
 * Menu data: Tea & Coffee — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'black coffee',
        'title_ru' => 'чёрный кофе', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Espresso',
                'price'       => '140-.',
                'quantity'    => '30 ml',
                'description' => 'Single shot.',
                'ru'          => [ 'dish_name' => 'Эспрессо', 'description' => 'Одна порция.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Double Espresso',
                'price'       => '180-.',
                'quantity'    => '60 ml',
                'description' => 'Double shot.',
                'ru'          => [ 'dish_name' => 'Двойной эспрессо', 'description' => 'Двойная порция.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Americano',
                'price'       => '140-.',
                'quantity'    => '200 ml',
                'description' => 'Espresso with hot water.',
                'ru'          => [ 'dish_name' => 'Американо', 'description' => 'Эспрессо с горячей водой.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Americano XXL',
                'price'       => '180-.',
                'quantity'    => '300 ml',
                'description' => 'Large americano.',
                'ru'          => [ 'dish_name' => 'Американо XXL', 'description' => 'Большой американо.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Arabica Filter',
                'price'       => '130-.',
                'quantity'    => '200 ml',
                'description' => 'Filter-brewed single origin.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Арабика', 'description' => 'На фильтре.' ],
            ],
        ],
    ],
    [
        'title'    => 'iced coffee',
        'title_ru' => 'холодный кофе', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Bumble Fresh',
                'price'       => '235-.',
                'quantity'    => '250 ml',
                'description' => 'Fresh orange juice, espresso, caramel topping.',
                'ru'          => [ 'dish_name' => 'Бамбл фреш', 'description' => 'Апельсиновый фреш, эспрессо, карамельный топпинг.' ],
            ],
            [
                'dish_name'   => 'Espresso Tonic',
                'price'       => '180-.',
                'quantity'    => '250 ml',
                'description' => 'Espresso over tonic water.',
                'ru'          => [ 'dish_name' => 'Эспрессо-тоник', 'description' => 'Эспрессо поверх тоника.' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'Vegan Milk',
        'title_ru' => 'Растительное молоко', // draft — not in menu.md
        'column'   => 'left',
        'style'    => 'card',
        'dishes'   => [
            [
                'dish_name'   => 'Add any',
                'price'       => '65-.',
                'description' => 'Oatmeal, almond, coconut',
                'ru'          => [ 'dish_name' => 'Добавьте любое', 'description' => 'Овсяное, миндальное, кокосовое' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'with milk',
        'title_ru' => 'с молоком', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Cappuccino',
                'price'       => '175-.',
                'quantity'    => '200 ml',
                'description' => 'Classic or iced version.',
                'ru'          => [ 'dish_name' => 'Капучино', 'description' => 'Классический или холодный.' ],
            ],
            [
                'dish_name'   => 'Cappuccino XXL',
                'price'       => '245-.',
                'quantity'    => '300 ml',
                'description' => 'Large cappuccino.',
                'ru'          => [ 'dish_name' => 'Капучино XXL', 'description' => 'Большой капучино.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Latte',
                'price'       => '190-.',
                'quantity'    => '300 ml',
                'description' => 'Smooth espresso with steamed milk.',
                'ru'          => [ 'dish_name' => 'Латте', 'description' => 'Эспрессо с нежным вспененным молоком.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Flat White',
                'price'       => '195-.',
                'quantity'    => '200 ml',
                'description' => 'Velvety microfoam, double shot.',
                'ru'          => [ 'dish_name' => 'Флэт уайт', 'description' => 'Бархатная микропена, двойной эспрессо.' ], // draft — not in menu.md
            ],
            [
                'dish_name'   => 'Spiced Raf',
                'price'       => '205-.',
                'quantity'    => '250 ml',
                'description' => 'Creamy espresso with spiced syrup.',
                'ru'          => [ 'dish_name' => 'Пряный раф', 'description' => 'Сливочный кофе с пряным сиропом.' ], // draft — not in menu.md
            ],
            [
                'dish_name'      => 'Cheese Raf',
                'price'          => '225-.',
                'quantity'       => '250 ml',
                'description'    => 'Creamy cheese-flavoured raf.',
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'ru'             => [ 'dish_name' => 'Сырный раф', 'description' => 'Сливочный раф с сырным вкусом.', 'seasonal_label' => 'Лето’26!' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'chocolate & cocoa',
        'title_ru' => 'шоколад и какао',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Cocoa',
                'price'       => '295-.',
                'quantity'    => '200 ml',
                'description' => 'With marshmallows.',
                'ru'          => [ 'dish_name' => 'Какао', 'description' => 'С зефирками.' ],
            ],
            [
                'dish_name'   => 'Hot Chocolate',
                'price'       => '295-.',
                'quantity'    => '120 ml',
                'description' => 'Rich and creamy.',
                'ru'          => [ 'dish_name' => 'Горячий шоколад', 'description' => 'Густой и сливочный.' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'yaroslavl style tea',
        'title_ru' => 'фирменный чай',
        'column'   => 'left',
        'divider'  => true,
        'dishes'   => [
            [
                'dish_name'   => 'Cranberry Tea',
                'price'       => '290-.',
                'quantity'    => '600 ml',
                'description' => 'With ginger.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Клюквенный', 'description' => 'С имбирём.' ],
            ],
            [
                'dish_name'   => 'Raspberry Tea',
                'price'       => '290-.',
                'quantity'    => '600 ml',
                'description' => 'With anise.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Малиновый', 'description' => 'С анисом.' ],
            ],
            [
                'dish_name'   => 'Sea Buckthorn Tea',
                'price'       => '290-.',
                'quantity'    => '600 ml',
                'description' => 'With orange.',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Облепиховый', 'description' => 'С апельсином.' ],
            ],
        ],
    ],
    [
        'title'    => 'freshly brewed tea',
        'title_ru' => 'чай',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Black Tea',
                'price'       => '180-.',
                'quantity'    => '600 ml',
                'description' => 'Assam, Earl Grey, Wild Cherry, or Taiga Blend.',
                'ru'          => [ 'dish_name' => 'Чёрный', 'description' => 'Ассам, Эрл Грей, Дикая вишня или Таёжный сбор.' ],
            ],
            [
                'dish_name'   => 'Green Tea',
                'price'       => '180-.',
                'quantity'    => '600 ml',
                'description' => 'Mango, Jasmine, Milk Oolong, or Gunpowder.',
                'ru'          => [ 'dish_name' => 'Зелёный', 'description' => 'С манго, жасминовый, Молочный улун или Порох.' ],
            ],
            [
                'dish_name'   => 'Pu-erh',
                'price'       => '180-.',
                'quantity'    => '600 ml',
                'description' => 'Aged 3 years, earthy and deep.',
                'ru'          => [ 'dish_name' => 'Пуэр', 'description' => '3 года выдержки.' ],
            ],
            [
                'dish_name'   => 'NOtea',
                'price'       => '180-.',
                'quantity'    => '600 ml',
                'description' => 'Strawberries & Cream, Fruit Rooibos, Buckwheat, or Ivan-chai.',
                'ru'          => [ 'dish_name' => 'НЕчай', 'description' => 'Клубника и сливки, Ройбуш с фруктами, Гречишный или Иван-чай.' ],
            ],
        ],
    ],
];
