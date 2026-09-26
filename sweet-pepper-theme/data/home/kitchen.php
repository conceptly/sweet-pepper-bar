<?php
/**
 * Home data: the kitchen preview (Your lunch sorted) — as typed before the page moved into
 * WordPress. Fallback for sweet_pepper_home_preview( …, 'kitchen' ) and the seed source;
 * the same shape as data/home/bar.php.
 *
 *   ru — home-copy-ru-draft.md → 4. Обед.
 *
 * @package Sweet_Pepper
 */

return [
    'title' => 'YOUR LUNCH SORTED',
    'photo' => 'food/lunch/bagel-lunch-1.jpg',
    'alt'   => 'Bagel with a patty, potato wedges and fresh vegetables',
    'badge' => '',
    'ru'    => [ 'alt' => 'Бейгл с котлетой, картофель по-деревенски и свежие овощи', 'title' => 'С ОБЕДОМ РЕШЕНО' ],
    'items' => [
        [ 'dish', 'Тыквенный суп', 'lunch' ],
        [ 'dish', 'Кесадилья', 'lunch' ],
        [ 'dish', 'Бейгл с котлетой', 'lunch' ],
    ],
    'rows'  => [
        [ 'dish_name' => 'Pumpkin soup', 'price' => '195-.', 'description' => 'Creamy pumpkin soup with chicken.', 'icons' => [ 'veg' ], 'highlight' => true,
          'ru' => [ 'dish_name' => 'Тыквенный суп', 'description' => 'Сливочный, с цыплёнком.' ] ],
        [ 'dish_name' => 'Quesadilla', 'price' => '265-.', 'description' => 'Chicken and cheese, or double cheese.', 'highlight' => true,
          'ru' => [ 'dish_name' => 'Кесадилья', 'description' => 'С курицей и сыром или с двойным сыром.' ] ],
        [ 'dish_name' => 'Beef patty bagel', 'price' => '355-.', 'description' => 'A beef patty, vegetables and pickles in a house-made bagel, with potato wedges and sauce.', 'highlight' => true,
          'ru' => [ 'dish_name' => 'Бейгл с говяжьей котлетой', 'description' => 'Котлета, овощи и маринованные огурчики в домашнем бейгле. С картофельными дольками и соусом.' ] ],
    ],
];
