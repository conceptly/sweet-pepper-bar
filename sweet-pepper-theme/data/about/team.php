<?php
/**
 * About data: The Dream Team — as typed before the page moved into WordPress.
 *
 * Two jobs: the fallback sweet_pepper_about_team() renders until the About page's
 * «Команда» tab is saved, and the source tools/page-seed.php reads (it imports the
 * photos into the media library).
 *
 *   ru       — the Russian twins, from about-page-copy-ru-draft.md → 7. Команда. Roles are
 *              the draft's guidance (Зал for Floor, Шеф-бармен kept), still to be confirmed
 *              by each person; messages have NO Russian — Lera's line waits for its Russian
 *              source and the other seven are placeholders (the draft: don't back-translate).
 *   since    — the year the person joined; the theme prints the tenure ("· 8 years")
 *   chip     — 'ask' | 'word' | 'pick' (inc/about-data.php → sweet_pepper_team_chips())
 *   name_gen — the Russian name in the genitive, for the «Пара слов от …» chip
 *   photo    — under assets/images/
 *
 * 18 Oct 2026: ten cards — Anton's new portrait, Max (a placeholder) → Sofia, Veronika and
 * Ekaterina added, and the first lines in the team's own words (Ira, Stas, Johnny, Sofia,
 * Veronika, Ekaterina; tools/field-updates/2026-10-18-about-team-ten.json). First drafts —
 * the author shortens them in admin. 19 Oct: Ekaterina next to Stas (the waiters together),
 * Stas's new portrait, Alex is «Саня» in Russian, four buttons shortened by the author.
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'    => 'THE ONES WHO KNOW YOUR ORDER',
    'headline'   => 'THE DREAM TEAM',
    'headline_2' => '',
    'ru'         => [
        'eyebrow'    => 'ЗНАЮТ, ЧТО ВЫ ЛЮБИТЕ',
        'headline'   => 'КОМАНДА МЕЧТЫ',
        'headline_2' => '',
    ],
    'wall'       => [
        [ 'photo' => 'team/group/2019.jpg',   'year' => 2019 ],
        [ 'photo' => 'team/group/2020.jpg',   'year' => 2020 ],
        [ 'photo' => 'team/group/2021.jpg',   'year' => 2021 ],
        [ 'photo' => 'team/group/2022.jpg',   'year' => 2022 ],
        [ 'photo' => 'team/group/2023-1.jpg', 'year' => 2023 ],
        [ 'photo' => 'team/group/2024.jpg',   'year' => 2024 ],
        [ 'photo' => 'team/group/2025.jpg',   'year' => 2025 ],
    ],
    // Longest-tenured first. Lines other than Lera's are PLACEHOLDERS (about-page-copy.md → Team).
    'members'    => [
        [
            // Was Kostya, General Manager, 2018 (author, 30 Sep 2026: the first card is Ira's —
            // Figma 326:14845; her own message still to come)
            'name'    => 'Ira',
            'role'    => 'Floor Manager',
            'since'   => 2023,
            'photo'   => 'team/ira.jpg',
            'chip'    => 'word',
            'message' => 'Cold? I\'ll be waiting with a cosy blanket. Fancy something special? Just ask!',
            'chip_label' => 'Fancy a chat?', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Поболтаем?', 'name' => 'Ира', 'name_gen' => 'Иры', 'role' => 'Менеджер зала',
                           'message' => 'Замёрзли — жду с уютным пледом. Хочется чего-то особенного? Подскажу!' ],
        ],
        [
            'name'    => 'Lera',
            'role'    => 'Host & storyteller', // author, 2 Oct 2026 (was Floor / Зал)
            'since'   => 2019,
            'photo'   => 'team/lera.jpg',
            'chip'    => 'ask',
            'message' => 'Start with the salted caramel infusion. If you don\'t like it, I\'ll drink it — hasn\'t happened yet.',
            'chip_label' => 'My standing tip', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Всегда советую', 'name' => 'Лера', 'name_gen' => 'Леры', 'role' => 'Душа зала, голос Перца' ],
        ],
        [
            'name'    => 'Lenya',
            'role'    => 'Floor Manager',
            'since'   => 2020,
            'photo'   => 'team/lenya.jpg',
            'chip'    => 'pick',
            'message' => 'Pumpkin soup at noon, a sour after eight. Yes, both on the same shift.',
            'chip_label' => 'Insiders only', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Только для своих', 'name' => 'Лёня', 'name_gen' => 'Лёни', 'role' => 'Менеджер зала' ],
        ],
        [
            'name'    => 'Anton',
            'role'    => 'Bar chef',
            'since'   => 2021,
            'photo'   => 'team/anton-2.jpg',
            'chip'    => 'ask',
            'message' => 'Tell me what you drank last night and I\'ll fix it. The drink, not the night.',
            'chip_label' => 'My pick at the bar', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Мне как всегда', 'name' => 'Антон', 'name_gen' => 'Антона', 'role' => 'Шеф-бармен' ],
        ],
        [
            'name'    => 'Stas',
            'role'    => 'Unforgettable waiter',
            'since'   => 2018,
            'photo'   => 'team/stas-2.jpg', // 19 Oct 2026
            'chip'    => 'word',
            'message' => 'One beer is no beer. Two, half a beer. Four, one beer. But one is no beer!',
            'chip_label' => 'My maths', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Моя арифметика', 'name' => 'Стас', 'name_gen' => 'Стаса', 'role' => 'Незабываемый официант',
                           'message' => 'Одно пиво — не пиво. Два — полпива. Четыре — одно пиво. Но одно — не пиво!' ],
        ],
        [
            'name'    => 'Ekaterina',
            'role'    => 'Waiter',
            'since'   => 2025,
            'photo'   => 'team/ekaterina.jpg',
            'chip'    => 'word',
            'message' => 'How many seconds does it take you to down a shot?',
            'chip_label' => 'Quick question?', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Можно вопрос?', 'name' => 'Екатерина', 'name_gen' => 'Екатерины', 'role' => 'Официант',
                           'message' => 'За сколько секунд выпьете шот?' ],
        ],
        [
            'name'    => 'Alex',
            'role'    => 'Bartender',
            'since'   => 2021,
            'photo'   => 'team/alex.jpg',
            'chip'    => 'ask',
            'message' => 'The infusions rotate. Ask what\'s in the jar today, not what\'s on the list.',
            'chip_label' => 'Favourite cocktail', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Мой коктейль', 'name' => 'Саня', 'name_gen' => 'Сани', 'role' => 'Бармен' ],
        ],
        [
            'name'    => 'Sofia',
            'role'    => 'Cook',
            'since'   => 0, // not given yet
            'photo'   => 'team/sofia.jpg',
            'chip'    => 'pick',
            'message' => 'The Yaroslavl-style roast — I eat it myself, happily. And the pork steak.',
            'chip_label' => 'My lunch go-to', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Беру на ланч', 'name' => 'Софья', 'name_gen' => 'Софьи', 'role' => 'Повар',
                           'message' => 'Жаркое по-ярославски — сама его с удовольствием ем. И ещё стейк из свинины.' ],
        ],
        [
            'name'    => 'Johnny',
            'role'    => 'Sous-chef',
            'since'   => 2014,
            'photo'   => 'team/johnny.jpg',
            'chip'    => 'pick',
            'message' => 'The Napolitana, the borscht, and San Sebastián cheesecake for dessert.',
            'chip_label' => 'My dinner hits', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'В планах на ужин', 'name' => 'Джонни', 'name_gen' => 'Джонни', 'role' => 'Су-шеф',
                           'message' => 'Неаполитана, борщ, а на десерт — Сан-Себастьян.' ],
        ],
        [
            'name'    => 'Veronika',
            'role'    => 'Cook',
            'since'   => 0, // not given yet
            'photo'   => 'team/veronika.jpg',
            'chip'    => 'pick',
            'message' => 'I really love our borscht. The Caesar bagel\'s a fun one too.',
            'chip_label' => 'My favourites', // the button's own text (19 Oct 2026)
            'ru'      => [ 'chip_label' => 'Мои любимчики', 'name' => 'Вероника', 'name_gen' => 'Вероники', 'role' => 'Повар',
                           'message' => 'Очень люблю наш борщ. А ещё Цезарь-бейгл — он прикольный.' ],
        ],
    ],
];
