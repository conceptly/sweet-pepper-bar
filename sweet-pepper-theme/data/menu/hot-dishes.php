<?php
/**
 * Menu data: Hot Dishes — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'pastas',
        'title_ru' => 'пасты',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Fettuccine Carbonara',
                'price'       => '365-.',
                'quantity'    => '250 g',
                'description' => 'with bacon in cream sauce',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Фетучини карбонара', 'description' => 'Итальянская паста «гнёзда» с беконом в сливочном соусе' ],
            ],
            [
                'dish_name'   => 'Farfalle with chicken',
                'price'       => '345-.',
                'quantity'    => '300 g',
                'description' => 'bow-tie pasta with mushrooms & broccoli in cream sauce',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Фарфалле с цыплёнком', 'description' => 'Традиционная итальянская паста «бантики» с грибами и брокколи в сливочном соусе' ],
            ],
            [
                'dish_name'      => 'Fettuccine Corfu',
                'price'          => '465-.',
                'quantity'       => '250 g',
                'description'    => 'with brynza, shrimp & zucchini in basil-walnut pesto',
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'ru'             => [ 'dish_name' => 'Фетучини Корфу', 'description' => 'Итальянская паста «гнёзда» с брынзой, креветками и цукини с зелёным песто с базиликом и грецким орехом', 'seasonal_label' => 'Лето’26!' ], // draft — not in menu.md (seasonal_label)
            ],
            [
                'dish_name'   => 'Napolitana with meatballs',
                'price'       => '395-.',
                'quantity'    => '300 g',
                'description' => 'nest pasta in a spicy tomato sauce',
                'ru'          => [ 'dish_name' => 'Неаполитана с фрикадельками', 'description' => 'Традиционная итальянская паста «гнёзда» в пряном томатном соусе, можно сделать острее' ],
            ],
            [
                'dish_name'   => 'Napolitana with shrimp',
                'price'       => '445-.',
                'quantity'    => '300 g',
                'description' => 'nest pasta in a spicy tomato sauce',
                'ru'          => [ 'dish_name' => 'Неаполитана с креветками', 'description' => 'Традиционная итальянская паста «гнёзда» в пряном томатном соусе, можно сделать острее' ],
            ],
            [
                'dish_name'   => 'Napolitana with turkey',
                'price'       => '385-.',
                'quantity'    => '300 g',
                'description' => 'nest pasta in a spicy tomato sauce',
                'ru'          => [ 'dish_name' => 'Неаполитана с индейкой', 'description' => 'Традиционная итальянская паста «гнёзда» в пряном томатном соусе, можно сделать острее' ],
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
                'ru'          => [ 'dish_name' => 'Любой на выбор', 'description' => 'Сырный, Цезарь, Барбекю, Тартар, Сметана, Сицилийский, Горчица' ], // draft — not in menu.md (dish_name)
            ],
        ],
    ],
    [
        'title'    => 'mains',
        'title_ru' => 'горячие блюда',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Yaroslavl-style roast',
                'price'       => '365-.',
                'quantity'    => '300 g',
                'description' => 'potato wedges, pork & vegetables in spicy cream sauce',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Жаркое по-ярославски', 'description' => 'С картофельными дольками, свининой и овощами в остром сливочном соусе' ],
            ],
            [
                'dish_name'      => 'Cod roast',
                'price'          => '365-.',
                'quantity'       => '300 g',
                'description'    => 'potato wedges, cod & vegetables in cream-oyster sauce',
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'ru'             => [ 'dish_name' => 'Жаркое с треской', 'description' => 'С картофельными дольками, треской и овощами в сливочно-устричном соусе', 'seasonal_label' => 'Лето’26!' ], // draft — not in menu.md (seasonal_label)
            ],
            [
                'dish_name'      => 'Ravioli',
                'price'          => '325-.',
                'quantity'       => '300 g',
                'description'    => 'description',
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'ru'             => [ 'dish_name' => 'Равиоли', 'description' => 'описание', 'seasonal_label' => 'Лето’26!' ], // draft — not in menu.md (description mirrors the English placeholder; seasonal_label)
            ],
            [
                'dish_name' => 'Pelmeni',
                'price'     => '305-.',
                'quantity'  => '180 g',
                'icons'     => [ 'fire' ],
                'options'   => [
                    'Pepper-style baked with cheese',
                    'Classic style in broth with sour cream',
                ],
                'ru'        => [ 'dish_name' => 'Пельмешки', 'options' => [ 'Запечённые с сыром', 'С бульоном' ] ],
            ],
        ],
    ],
    [
        'title'    => 'grill',
        'title_ru' => 'гриль',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Chicken steak',
                'price'       => '435-.',
                'quantity'    => '350 g',
                'description' => 'with mashed potato & sauce',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Стейк из цыплёнка', 'description' => 'С гарниром из картофельного пюре и соусом' ],
            ],
            [
                'dish_name'   => 'Turkey steak',
                'price'       => '585-.',
                'quantity'    => '320 g',
                'description' => 'with potato wedges, carrot & pumpkin',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Стейк из индейки', 'description' => 'С гарниром из картофельных долек, моркови и тыквы' ],
            ],
            [
                'dish_name'   => 'Pork steak',
                'price'       => '695-.',
                'quantity'    => '450 g',
                'description' => 'with country-style potatoes',
                'ru'          => [ 'dish_name' => 'Стейк из свинины', 'description' => 'С гарниром из картофеля по-деревенски' ],
            ],
        ],
    ],
];
