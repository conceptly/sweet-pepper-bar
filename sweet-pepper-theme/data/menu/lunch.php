<?php
/**
 * Menu data: Lunch — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'salads',
        'title_ru' => 'салаты',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Cobb Salad',
                'price'       => '285-.',
                'description' => 'with chicken breast, bacon & signature sauce',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Кобб салат', 'description' => 'С куриной грудкой, беконом и фирменным соусом' ],
            ],
            [
                'dish_name'   => 'Classic Caesar',
                'price'       => '265-.',
                'description' => 'with chicken, croutons & signature sauce',
                'ru'          => [ 'dish_name' => 'Классический Цезарь', 'description' => 'С цыплёнком, гренками, салатом айсберг и фирменным соусом' ],
            ],
            [
                'dish_name'      => 'Summer salad',
                'price'          => '265-.',
                'description'    => 'with brynza, cherry tomatoes & basil-walnut pesto',
                'icons'          => [ 'veg' ],
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'ru'             => [ 'dish_name' => 'Летний салат с брынзой', 'description' => 'С черри, болгарским перцем и зелёным песто с базиликом и грецким орехом', 'seasonal_label' => 'Лето’26!' ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'lunch hits',
        'title_ru' => 'ланч-хиты',
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Quesadilla',
                'price'       => '265-.',
                'description' => 'Chicken & cheese / or Double cheese',
                'ru'          => [ 'dish_name' => 'Кесадилья', 'description' => 'Цыплёнок и сыр / или двойной сыр' ],
            ],
            [
                'dish_name'   => 'Signature Broccoli',
                'price'       => '190-.',
                'description' => 'Breaded with parmesan',
                'icons'       => [ 'veg' ],
                'ru'          => [ 'dish_name' => 'Фирменная брокколи', 'description' => 'В сухарях с пармезаном' ],
            ],
            [
                'dish_name'   => 'Farfalle with chicken',
                'price'       => '245-.',
                'description' => 'bow-tie pasta with mushrooms & broccoli in cream sauce',
                'ru'          => [ 'dish_name' => 'Фарфалле с курицей и брокколи', 'description' => 'Итальянская паста «бантики» с грибами в сливочном соусе' ],
            ],
        ],
    ],
    [
        'title'    => 'first course',
        'title_ru' => 'на первое',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Borscht',
                'price'       => '225-.',
                'description' => 'A classic, with garlic toast & salo on the side',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Борщ', 'description' => 'Классика жанра с чесночным тостом и салом на гарнир' ],
            ],
            [
                'dish_name'   => 'Pumpkin soup',
                'price'       => '195-.',
                'description' => 'Creamy with chicken',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'Тыквенный суп', 'description' => 'Сливочный с цыплёнком' ],
            ],
            [
                'dish_name'      => 'Summer soup of the day',
                'price'          => '235-.',
                'quantity'       => '250 g',
                'seasonal_label' => "Summer'26!",
                'highlight'      => true,
                'options'        => [
                    "Pepper's Okroshka",
                    'Tomato Gazpacho',
                ],
                'ru'             => [ 'dish_name' => 'Летний супчик дня', 'seasonal_label' => 'Лето’26!', 'options' => [ 'Окрошка', 'Гаспачо' ] ], // draft — not in menu.md
            ],
        ],
    ],
    [
        'title'    => 'sandwich sets',
        'title_ru' => 'сэндвич-сеты',
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Chicken Club',
                'price'       => '335-.',
                'description' => 'on crispy toasts with French fries and sauce',
                'icons'       => [ 'fire' ],
                'ru'          => [ 'dish_name' => 'С цыплёнком', 'description' => 'И картошкой фри' ],
            ],
            [
                'dish_name'   => 'Turkey Club',
                'price'       => '345-.',
                'description' => 'on crispy toasts with potato wedges and sauce',
                'ru'          => [ 'dish_name' => 'С индейкой', 'description' => 'И картофельными дольками' ],
            ],
            [
                'dish_name'   => 'Bagel with a patty',
                'price'       => '355-.',
                'description' => 'Home-made buns, a beef patty, veggies, pickles, with potato wedges and sauce',
                'ru'          => [ 'dish_name' => 'Бейгл с котлетой', 'description' => 'С сочной котлетой, сыром, солёными огурцами и томатами, с гарниром из картофельных долек' ],
            ],
        ],
    ],
];
