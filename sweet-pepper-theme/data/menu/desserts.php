<?php
/**
 * Menu data: Desserts — the rows as typed before the menu moved into WordPress.
 *
 * Moved here from the section template on 23 Sep 2026; the fallback and the seeder's
 * source, as data/menu/soups.php describes. `ru` twins from menu.md.
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'    => 'pastries',
        'title_ru' => 'выпечка', // draft — not in menu.md
        'column'   => 'left',
        'dishes'   => [
            [
                'dish_name'   => 'Signature apple strudel',
                'price'       => '255-.',
                'quantity'    => '180 g',
                'description' => 'with a scoop of ice cream',
                'icons'       => [ 'fire' ],
                'highlight'   => true,
                'ru'          => [ 'dish_name' => 'Фирменный яблочный штрудель', 'description' => 'С шариком пломбира' ],
            ],
            [
                'dish_name'   => 'Raspberry Napoleon',
                'price'       => '215-.',
                'quantity'    => '150 g',
                'description' => 'with jam & almonds',
                'ru'          => [ 'dish_name' => 'Малиновый наполеон', 'description' => 'С джемом и миндалём' ],
            ],
            [
                'dish_name'   => 'Ice cream',
                'price'       => '95-.',
                'quantity'    => '50 g',
                'description' => 'Cream; or Chocolate; or Pistachio',
                'ru'          => [ 'dish_name' => 'Мороженое', 'description' => 'Сливочное; или Шоколадное; или Фисташковое' ],
            ],
        ],
    ],
    [
        'title'    => 'cheesecakes',
        'title_ru' => 'чизкейки', // draft — not in menu.md
        'column'   => 'right',
        'dishes'   => [
            [
                'dish_name'   => 'San Sebastian',
                'price'       => '335-.',
                'quantity'    => '240 g',
                'description' => 'Creamy with a baked crust',
                'icons'       => [ 'fire' ],
                'highlight'   => true,
                'ru'          => [ 'dish_name' => 'Чизкейк Сан-Себастьян', 'description' => 'Сливочный с запечённой корочкой' ],
            ],
            [
                'dish_name'   => 'Blueberry cheesecake',
                'price'       => '215-.',
                'quantity'    => '175 g',
                'description' => 'No-bake, with natural berries',
                'icons'       => [ 'fire' ],
                'highlight'   => true,
                'ru'          => [ 'dish_name' => 'Черничный чизкейк', 'description' => 'С натуральными ягодами без выпечки' ],
            ],
            [
                'dish_name'   => 'Caramel cheesecake',
                'price'       => '325-.',
                'quantity'    => '200 g',
                'description' => 'Creamy with peanuts',
                'icons'       => [ 'fire' ],
                'highlight'   => true,
                'ru'          => [ 'dish_name' => 'Карамельный чизкейк', 'description' => 'Сливочный с арахисом' ],
            ],
        ],
    ],
];
