<?php
/**
 * Home data: the bar preview (House infusions) — as typed before the page moved into
 * WordPress. Fallback for sweet_pepper_home_preview( …, 'bar' ) and the seed source.
 *
 * `items` names the three drinks for the seeder — [ type, Russian title, section ]; the
 * seeded page prints their records (name, size, price, description). `rows` are the typed
 * dish-row args the preview showed until then (every row highlighted: the preview's picks).
 *
 *   ru — home-copy-ru-draft.md → 3. Настойки (the rows' Russian is the store's once seeded).
 *
 * @package Sweet_Pepper
 */

return [
    'title' => 'HOUSE INFUSIONS',
    'photo' => 'bar/cocktails/shot-drinks.jpg',
    'alt'   => 'Home made infusions — colourful shots and cocktails',
    'badge' => 'Community hit!',
    'ru'    => [ 'title' => 'ДОМАШНИЕ НАСТОЙКИ', 'badge' => 'Хит у гостей!' ],
    'items' => [
        [ 'drink', 'Солёная Карамель', 'infusions' ],
        [ 'drink', 'Хреновуха', 'infusions' ],
        [ 'drink', 'Малина на Джине', 'infusions' ],
    ],
    'rows'  => [
        [ 'dish_name' => 'Salted Caramel', 'price' => '150-. / 1300-.', 'quantity' => '40 ml / 500 ml', 'description' => 'Sweet, salty, irresistible.', 'icons' => [ 'veg' ], 'highlight' => true,
          'ru' => [ 'dish_name' => 'Солёная карамель', 'description' => 'Сладкая? Солёная? Всё вместе — в одной рюмке.' ] ],
        [ 'dish_name' => 'Horseradish', 'price' => '150-. / 1300-.', 'quantity' => '40 ml / 500 ml', 'description' => "For the brave — a taste of Yaroslavl's hot side.", 'icons' => [ 'veg', 'fire' ], 'highlight' => true,
          'ru' => [ 'dish_name' => 'Хреновуха', 'description' => 'Для смельчаков, готовых познакомиться с горячим характером Ярославля.' ] ],
        [ 'dish_name' => 'Raspberry Gin', 'price' => '190-. / 1800-.', 'quantity' => '40 ml / 500 ml', 'description' => 'Gin infused with raspberries.', 'highlight' => true,
          'ru' => [ 'dish_name' => 'Малиновый джин', 'description' => 'Джин, настоянный на малине.' ] ],
    ],
];
