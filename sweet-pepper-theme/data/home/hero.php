<?php
/**
 * Home data: the hero — as typed before the page moved into WordPress (front-page.php and
 * src/js/daypart-engine.js, Sep 2026). Fallback for sweet_pepper_home_hero() and the seed source.
 *
 * The daypart engine keeps the clock, the theme, the tile order and where the menu button
 * goes; this holds the words and the tile photos. Four sets, one per daypart, and the three
 * closed-hours sets (website-brief.md → Desktop — home hero → Closed state): «{time}» is the
 * opening time, filled in by the engine from Bar Settings.
 *
 *   ru — home-copy-ru-draft.md → 1. Первый экран; the closed lines are the author's drafts
 *        (website-brief.md → Closed lines), split at their dash into headline + body as the
 *        English were — the split is mine, marked `// draft`.
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'  => 'SHAKE & COOK · YAROSLAVL',
    'ru'       => [ 'eyebrow' => 'SHAKE & COOK · ЯРОСЛАВЛЬ' ],
    'dayparts' => [
        'breakfast' => [
            'photo'    => 'food/breakfast/pepper-breakfast-2.jpg',
            'alt'      => 'Pepper’s Breakfast: fried eggs, a patty, toast and salad',
            'headline' => 'YUMMY MORNING!',
            'body'     => 'Coffee, eggs and a good reason to get out of bed.',
            'button'   => 'Breakfast menu',
            'ru'       => [ 'alt' => 'Завтрак от Перцев: глазунья, котлета, тосты и салат', 'headline' => 'ВКУСНОЕ УТРО!', 'body' => 'Кофе, яйца и хороший повод выбраться из-под одеяла.', 'button' => 'Меню завтраков' ],
        ],
        'lunch'     => [
            'photo'    => 'food/lunch/pumpkin.png',
            'alt'      => 'Pumpkin cream soup with chicken and croutons',
            'headline' => 'PUMPKIN SOUP TIME!',
            'body'     => 'Soup, something hearty, a little break in your day.',
            'button'   => 'Lunch menu',
            'ru'       => [ 'alt' => 'Тыквенный крем-суп с курицей и гренками', 'headline' => 'ВРЕМЯ ТЫКВЕННОГО СУПА!', 'body' => 'Тыквенный суп, что-нибудь сытное — и пусть дела немного подождут.', 'button' => 'Обеденное меню' ],
        ],
        'dinner'    => [
            'photo'    => 'food/dinner/zharkoe-1.jpg',
            'alt'      => 'Yaroslavl-style pot roast in a red clay pot',
            'headline' => 'READY FOR TONIGHT?',
            'body'     => 'Comfort food, cocktails and a table for your kind of evening.',
            'button'   => 'Dinner menu',
            'ru'       => [ 'alt' => 'Жаркое по-ярославски в красном горшочке', 'headline' => 'ПЛАНЫ НА ВЕЧЕР?', 'body' => 'Начните с ужина. А там, глядишь, и на коктейль останетесь.', 'button' => 'Меню ужина' ],
        ],
        'party'     => [
            'photo'    => 'bar/cocktails/moscow-mull-2.jpg',
            'alt'      => 'Bartender garnishing a copper-mug cocktail with lime',
            'headline' => "IT'S COCKTAIL TIME!",
            'body'     => 'Start with your favourite cocktail. See where the evening goes.',
            'button'   => 'Drinks menu',
            'ru'       => [ 'alt' => 'Бармен украшает лаймом коктейль в медной кружке', 'headline' => 'ВРЕМЯ КОКТЕЙЛЕЙ!', 'body' => 'Начните с любимого коктейля. А дальше — как пойдёт.', 'button' => 'Барное меню' ],
        ],
    ],
    // The bar is shut: the parked tile carries these instead of its own; no "closed" in the hero.
    'closed'   => [
        'night'   => [ // close → 04:00, the party tile
            'headline' => 'GOOD NIGHT, YAROSLAVL',
            'body'     => 'See you for breakfast at {time}.',
            'ru'       => [ 'headline' => 'ДОБРОЙ НОЧИ', 'body' => 'До встречи за завтраком в {time}.' ], // draft — «доброй ночи — до встречи за завтраком в …», split
        ],
        'morning' => [ // 04:00 → opening, the breakfast tile
            'headline' => "YOU'RE UP BEFORE THE BAR!",
            'body'     => 'Eggs and coffee from {time}.',
            'ru'       => [ 'headline' => 'УЖЕ НА НОГАХ?', 'body' => 'Перчик ждёт на завтрак с кофе с {time}.' ], // draft — «уже на ногах? Перчик ждёт на завтрак с кофе с 8:30», split; the double «с» is the brief's open note
        ],
        'sunday'  => [ // Sunday 04:00 → 10:00
            'headline' => 'A LITTLE SUNDAY POLISH',
            'body'     => 'Back at {time}, spotless.',
            'ru'       => [ 'headline' => 'ВОСКРЕСНАЯ УБОРКА!', 'body' => 'Ждём на завтрак и кофеёк с {time}.' ], // draft — «воскресная уборка! ждём на завтрак и кофеёк с 10», split
        ],
    ],
];
