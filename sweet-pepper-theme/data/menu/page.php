<?php
/**
 * Menu data: the two menu pages' own words — what is neither a section's (data/menu/
 * sections-copy.php, on «Разделы меню») nor a dish's (the store). Per page: the door to
 * the other menu, the Highlights header, the browser title, and the six typed highlight
 * cards the strip showed before it read the store.
 *
 * The typed fallback and the seed source for the fields on the two pages
 * (acf-json/group_sp_menu_food.json / _bar.json → tabs «Сезонное меню», the door, «Поиск»;
 * tools/page-seed.php menu), read by inc/menu-page.php. English from the templates as
 * they were (menu-hero.php, highlights.php, Sep 2026); Russian: the door words and the
 * Highlights heading from menu-copy-ru-draft.md («Навигация и подписи», «Подборка и
 * подписи фотографий»), the rest marked `// draft` — mine, to refine in admin.
 *
 *   door       — the hero's door to the other menu: the word on the block, and the
 *                preview it opens on hover (photo, its caption, a paragraph)
 *   door_night — the kitchen page only: the same preview after dark (author, 24 Sep 2026:
 *                cocktails at night, coffee by day); the word stays
 *   highlights — the strip's header: eyebrow, headline line 1, line 2
 *   seo        — the page's name in the browser tab (the site name is added), and the
 *                description search engines show
 *   cards      — the last resort while the store has no seasonal dish: title, photo,
 *                the section the card links to
 *
 * @package Sweet_Pepper
 */

$cards = [
    [ 'title' => 'Gazpacho',           'image' => 'food/lunch/pumpkin.png',      'section' => 'soups',      'ru' => [ 'title' => 'Гаспачо' ] ],
    [ 'title' => 'Okroshka',           'image' => 'food/lunch/cobb-1.jpg',       'section' => 'soups',      'ru' => [ 'title' => 'Окрошка' ] ],
    [ 'title' => 'Summer Salad',       'image' => 'food/lunch/bagel-lunch-1.jpg', 'section' => 'salads',     'ru' => [ 'title' => 'Летний салат с брынзой' ] ],
    [ 'title' => 'Fettuccine Corfu',   'image' => 'food/dinner/zharkoe-1.jpg',   'section' => 'hot-dishes', 'ru' => [ 'title' => 'Фетучини Корфу' ] ],
    [ 'title' => 'Ravioli',            'image' => 'food/dinner/wings-2.jpg',     'section' => 'hot-dishes', 'ru' => [ 'title' => 'Равиоли' ] ],
    [ 'title' => 'Caramel Cheesecake', 'image' => 'food/dessert/napoleon-1.jpg', 'section' => 'desserts',   'ru' => [ 'title' => 'Карамельный чизкейк' ] ],
];

$highlights = [
    'eyebrow'    => 'delicious & refreshing',
    'headline'   => 'Summer Menu',
    'headline_2' => 'Highlights',
    'ru'         => [
        'eyebrow'    => 'вкусно и свежо', // draft — the RU draft has no eyebrow here
        'headline'   => 'Сезонные новинки',
        'headline_2' => '', // one line in Russian (author, 23 Sep 2026); «Что попробовать» was the draft's evergreen heading
    ],
];

return [
    'food' => [
        'door' => [
            'label'       => 'Drinks',
            'image'       => 'bar/coffee/cappuccino-icecream-1.jpg',
            'focus'       => '50% 50%',
            'caption'     => 'Cappuccino & Gelato',
            'description' => 'House-made infusions, natural cocktails, local wines, and craft beer — the bar is a destination on its own. No syrup shortcuts.',
            'ru'          => [
                'label'       => 'Напитки',
                'caption'     => 'Капучино с мороженым', // draft
                'description' => 'Фирменные настойки, коктейли, вино и пиво. А ещё кофе, чай и всё без градуса.', // navigation-drawers-copy-ru-draft.md → 3 (author, 25 Sep 2026)
            ],
        ],
        'door_night' => [
            'image'       => 'bar/cocktails/manhattan-3-2.jpg',
            'focus'       => '50% 40%',
            'caption'     => 'Manhattan',
            'description' => 'Classics poured straight and twists poured loud — plus a new one on the board every week. The bar is at its best after dark.', // draft
            'ru'          => [
                'caption'     => 'Манхэттен',
                'description' => 'Классика без фокусов и авторские твисты — плюс новый коктейль на доске каждую неделю. После заката бар в своей стихии.', // draft
            ],
        ],
        'highlights' => $highlights,
        'seo'        => [
            'title'       => 'Food menu',
            'description' => 'Breakfast to dinner at Sweet Pepper, Yaroslavl: soups, salads, sandwiches and bagels, hot dishes, desserts and a kids’ menu.', // draft
            'ru'          => [
                'title'       => 'Меню кухни', // draft
                'description' => 'Кухня Sweet Pepper в Ярославле: завтраки весь день, обеды, супы, салаты, сэндвичи и бейглы, горячее, десерты и детское меню.', // draft
            ],
        ],
        'cards'      => $cards,
    ],
    'drinks' => [
        'door' => [
            'label'       => 'Food',
            'image'       => 'food/breakfast/pepper-breakfast-2.jpg',
            'focus'       => '50% 60%',
            'caption'     => "Pepper's Breakfast",
            'description' => 'The full kitchen — breakfast to dinner, soups to desserts, all cooked fresh and served at the bar or the table.',
            'ru'          => [
                'label'       => 'Еда',
                'caption'     => 'Завтрак от Перцев',
                'description' => 'От завтрака до сытного ужина. Супы, сэндвичи, горячее и что-нибудь на сладкое.', // navigation-drawers-copy-ru-draft.md → 3 (author, 25 Sep 2026)
            ],
        ],
        'highlights' => $highlights,
        'seo'        => [
            'title'       => 'Drinks menu',
            'description' => 'The bar at Sweet Pepper, Yaroslavl: house infusions, cocktails, wine, beer, spirits, drinks without alcohol, tea and coffee.', // draft
            'ru'          => [
                'title'       => 'Барное меню', // draft
                'description' => 'Бар Sweet Pepper в Ярославле: фирменные настойки, коктейли, вино, пиво, крепкое, напитки без алкоголя, чай и кофе.', // draft
            ],
        ],
        'cards'      => $cards, // the kitchen's picks on the bar page too, as the strip showed them (Sep 2026)
    ],
];
