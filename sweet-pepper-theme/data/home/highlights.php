<?php
/**
 * Home data: Highlights — the section header and the three cards as typed before the page
 * moved into WordPress. Fallback for sweet_pepper_home_highlights() and the seed source.
 *
 * A card normally points at a menu dish (website-brief.md → Menu storage → Settled: surfaces
 * reference dishes, never copy). `seed` names the dish for the seeder — [ type, its Russian
 * title, the section that places it ] — and the typed columns are what the card shows until
 * the page is seeded. The House infusions card is a CATEGORY, not a dish, so it stays typed
 * ("From 150-." — the range starts at 150, home-copy-review-en.md; ₽ until 28 Sep 2026). On a dish card `short` is
 * the card's name where the menu's is longer ("Pot roast" — author, Sep 2026; the dish picker's
 * short ticket name is the precedent) and `description` the card's own line (the copy doc's,
 * shorter than the menu row's); name, price and photo are the dish's.
 *
 *   ru — home-copy-ru-draft.md → 2. Что попробовать; the tag words are mine (`// draft`).
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'     => 'A GOOD PLACE TO START',
    'headline'    => 'HOUSE SPECIALS',
    'headline_2'  => '& LOCAL HITS',
    'description' => "A little sweet, a little heat. Start with house infusions, grilled wings or Pepper's pot roast.",
    'ru'          => [
        'eyebrow'     => 'С ЧЕГО НАЧАТЬ',
        'headline'    => 'ФИРМЕННОЕ',
        'headline_2'  => 'И ЛЮБИМОЕ',
        'description' => 'Первый раз в Перце? Вот с чего можно начать: домашние настойки, крылышки на гриле и жаркое в горшочке. А если уже есть любимое — вы знаете, что делать.',
    ],
    'cards'       => [
        [ // a category card — typed, no dish
            'photo'       => 'bar/infusions/infusions-lenya-02.jpg', // was the layered shots (author, 28 Sep 2026)
            'alt'         => 'House Infusions',
            'title'       => 'HOUSE INFUSIONS',
            'price'       => 'From 150-.', // the menu's price mark, as every other card (author, 28 Sep 2026)
            'description' => 'From cranberry and sea buckthorn to horseradish and raspberry gin.', // two lines, as the dish cards' (author, 28 Sep 2026)
            'tag_icon'    => 'star',
            'tag_label'   => 'Seasonal hits',
            'section'     => 'infusions',
            'ru'          => [ 'title' => 'ДОМАШНИЕ НАСТОЙКИ', 'price' => 'От 150-.', 'description' => 'От клюквы и облепихи до хреновухи и малины на джине.', 'tag_label' => 'Сезонный хит' ], // tag: draft
        ],
        [
            'seed'        => [ 'dish', 'Крылышки-гриль', 'bar-snacks' ],
            'photo'       => 'food/dinner/wings-2.jpg',
            'alt'         => 'Grilled Wings',
            'title'       => 'GRILLED WINGS',
            'price'       => '455-.',
            'description' => 'Honey-glazed wings with sour cream, carrot and celery sticks.',
            'tag_icon'    => 'fire',
            'tag_label'   => 'Spicy', // fire = hit in the icon legend (website-brief.md → Menu storage) — the author's leftover to decide
            'section'     => 'bar-snacks',
            'ru'          => [ 'title' => 'КРЫЛЫШКИ НА ГРИЛЕ', 'description' => 'В медовой глазури, со сметаной, морковью и сельдереем.', 'tag_label' => 'Острое' ], // tag: draft
        ],
        [
            'seed'        => [ 'dish', 'Жаркое по-ярославски', 'hot-dishes' ],
            'short'       => 'Pot roast', // the card's short name, kept on the seeded card (the menu says "Yaroslavl-style roast")
            'photo'       => 'food/dinner/zharkoe-1.jpg',
            'alt'         => 'Pot roast',
            'title'       => 'POT ROAST',
            'price'       => '365-.',
            'description' => 'Pork, potato wedges and vegetables in a spicy cream sauce.',
            'tag_icon'    => 'yaroslavl-logo',
            'tag_label'   => 'Yaroslavl-style',
            'section'     => 'hot-dishes',
            'ru'          => [ 'title' => 'ЖАРКОЕ', 'description' => 'Свинина, картофельные дольки и овощи в пряном сливочном соусе.', 'tag_label' => 'По-ярославски' ], // tag: draft · «ЖАРКОЕ»: one line at every width; «Жаркое в горшочке» wraps at 768–1024. Same dish as «по-ярославски» — the season decides the name (author, 28 Sep 2026)
        ],
    ],
];
