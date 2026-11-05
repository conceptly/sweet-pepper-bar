<?php
/**
 * Menu data: Salads — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'signature salads',
        'title_ru' => 'фирменные салаты', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name' => 'Cobb Salad',
                'price'     => '355-.',
                'quantity'  => '270 g',
                'options'   => [
                    'Classic with chicken, bacon, cheese, avocado and veggies',
                    'Vegetarian with mozzarella, avocado and veggies',
                ],
                'ru'        => [ 'dish_name' => 'Кобб салат', 'options' => [ 'С цыплёнком и беконом', 'С сыром моцарелла и авокадо' ] ],
            ],
            [
                'dish_name'   => 'Sicilian',
                'price'       => '335-.',
                'quantity'    => '210 g',
                'description' => 'with chicken, oranges & arugula',
                'ru'          => [ 'dish_name' => 'Сицилийский', 'description' => 'С цыплёнком, апельсинами и рукколой' ],
            ],
            [
                'dish_name'   => 'Summer salad with brynza',
                'price'       => '285-.',
                'quantity'    => '250 g',
                'description' => 'cherry tomatoes, bell pepper & basil-walnut pesto',
                'ru'          => [ 'dish_name' => 'Летний салат с брынзой', 'description' => 'С черри, болгарским перцем и зелёным песто с базиликом и грецким орехом' ],
            ],
        ],
    ],
    [
        'title'    => 'caesar collection',
        'title_ru' => 'коллекция цезарей', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'Classic Caesar',
                'price'       => '325-.',
                'quantity'    => '210 g',
                'description' => 'with chicken',
                'ru'          => [ 'dish_name' => 'Классический цезарь', 'description' => 'С курицей' ],
            ],
            [
                'dish_name'   => 'Mediterranean Caesar',
                'price'       => '475-.',
                'quantity'    => '210 g',
                'description' => 'with shrimp',
                'ru'          => [ 'dish_name' => 'Средиземноморский цезарь', 'description' => 'С креветками' ], // draft — not in menu.md (dish_name)
            ],
            [
                'dish_name'   => 'Scandinavian Caesar',
                'price'       => '445-.',
                'quantity'    => '210 g',
                'description' => 'with salmon',
                'ru'          => [ 'dish_name' => 'Скандинавский цезарь', 'description' => 'С лососем' ], // draft — not in menu.md (dish_name)
            ],
        ],
    ],
];
