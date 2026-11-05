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
 *                the section the card links to (either menu page's)
 *
 * @package Sweet_Pepper
 */

// The fall 2026 strips, six per page, the kitchen's with the bar's lighter drinks (author, 28 Sep
// 2026: "6 cards by default, a bar/food mix is fine"). Photos: the team's autumn shoot, cropped
// 3:2 into assets/images/fall-2026/ — the same files tools/menu-updates/2026-09-28-fall-photos.php
// gives the dishes' «Фото», as placeholders the team replaces.
$cards_food = [
    [ 'title' => 'Autumn sweet potato salad', 'image' => 'fall-2026/autumn-salad.jpg',      'section' => 'salads',     'ru' => [ 'title' => 'Осенний салат с бататом' ] ],
    [ 'title' => 'Caponata with feta',        'image' => 'fall-2026/caponata.jpg',          'section' => 'salads',     'ru' => [ 'title' => 'Капоната с фетой' ] ],
    [ 'title' => 'Autumn soup of the day',    'image' => 'fall-2026/autumn-soup.jpg',       'section' => 'lunch',      'ru' => [ 'title' => 'Осенний супчик дня' ] ],
    [ 'title' => 'Seasonal Lemonade',         'image' => 'fall-2026/seasonal-lemonade.jpg', 'section' => 'no-buzz',    'ru' => [ 'title' => 'Сезонный лимонад' ] ],
    [ 'title' => 'Melon & Strawberry Raf',    'image' => 'fall-2026/melon-raf.jpg',         'section' => 'tea-coffee', 'ru' => [ 'title' => 'Дынный раф с клубникой' ] ],
    [ 'title' => 'Barberry Tea',              'image' => 'fall-2026/barberry-tea.jpg',      'section' => 'tea-coffee', 'ru' => [ 'title' => 'Барбарисовый' ] ],
];
$cards_bar = [
    [ 'title' => 'Barberry',                     'image' => 'fall-2026/barberry-infusion.jpg', 'section' => 'infusions', 'ru' => [ 'title' => 'Барбариска' ] ],
    [ 'title' => 'Coquette',                     'image' => 'fall-2026/coquette.jpg',          'section' => 'cocktails', 'ru' => [ 'title' => 'Кокетка' ] ],
    [ 'title' => 'Red Moscow',                   'image' => 'fall-2026/red-moscow.jpg',        'section' => 'cocktails', 'ru' => [ 'title' => 'Красная Москва' ] ],
    [ 'title' => 'Barbara Collins',              'image' => 'fall-2026/barbara-collins.jpg',   'section' => 'cocktails', 'ru' => [ 'title' => 'Барбара Коллинз' ] ],
    [ 'title' => 'Melon & Strawberry Milkshake', 'image' => 'fall-2026/melon-milkshake.jpg',   'section' => 'no-buzz',   'ru' => [ 'title' => 'Дынный с клубникой' ] ],
    [ 'title' => 'Seasonal Lemonade',            'image' => 'fall-2026/seasonal-lemonade.jpg', 'section' => 'no-buzz',   'ru' => [ 'title' => 'Сезонный лимонад' ] ],
];

$highlights = [
    'eyebrow'    => 'delicious & refreshing',
    'headline'   => 'Autumn Menu', // the fall menu's heading (tools/menu-updates/2026-09-25-fall.php wrote it to the pages)
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
        'cards'      => $cards_food,
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
        'cards'      => $cards_bar,
    ],
];
