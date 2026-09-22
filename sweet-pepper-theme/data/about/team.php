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
 *   photo    — under assets/images/; two members reuse the founder's portrait (placeholders)
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'    => 'THE ONES WHO KNOW YOUR ORDER',
    'headline'   => 'THE DREAM TEAM',
    'headline_2' => '',
    'ru'         => [
        'eyebrow'    => 'ЗНАЮТ ВАШ ЛЮБИМЫЙ ЗАКАЗ',
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
            'name'    => 'Kostya',
            'role'    => 'General Manager',
            'since'   => 2018,
            'photo'   => 'team/kostya.jpg',
            'chip'    => 'ask',
            'message' => 'Ask me about the terrace swing-chairs. I know which one doesn\'t squeak.',
            'ru'      => [ 'name' => 'Костя', 'name_gen' => 'Кости', 'role' => 'Управляющий' ],
        ],
        [
            'name'    => 'Lera',
            'role'    => 'Floor',
            'since'   => 2019,
            'photo'   => 'team/lera.jpg',
            'chip'    => 'ask',
            'message' => 'Start with the salted caramel infusion. If you don\'t like it, I\'ll drink it — hasn\'t happened yet.',
            'ru'      => [ 'name' => 'Лера', 'name_gen' => 'Леры', 'role' => 'Зал' ],
        ],
        [
            'name'    => 'Lenya',
            'role'    => 'Floor Manager',
            'since'   => 2020,
            'photo'   => 'team/lenya.jpg',
            'chip'    => 'pick',
            'message' => 'Pumpkin soup at noon, a sour after eight. Yes, both on the same shift.',
            'ru'      => [ 'name' => 'Лёня', 'name_gen' => 'Лёни', 'role' => 'Менеджер зала' ],
        ],
        [
            'name'    => 'Anton',
            'role'    => 'Bar chef',
            'since'   => 2021,
            'photo'   => 'team/anton.jpg',
            'chip'    => 'ask',
            'message' => 'Tell me what you drank last night and I\'ll fix it. The drink, not the night.',
            'ru'      => [ 'name' => 'Антон', 'name_gen' => 'Антона', 'role' => 'Шеф-бармен' ],
        ],
        [
            'name'    => 'Stas',
            'role'    => 'Unforgettable waiter',
            'since'   => 2018,
            'photo'   => 'team/stas.jpg',
            'chip'    => 'ask',
            'message' => 'I remember your order from 2019. Don\'t test me — I will bring it.',
            'ru'      => [ 'name' => 'Стас', 'name_gen' => 'Стаса', 'role' => 'Незабываемый официант' ],
        ],
        [
            'name'    => 'Alex',
            'role'    => 'Bartender',
            'since'   => 2021,
            'photo'   => 'team/alex.jpg',
            'chip'    => 'ask',
            'message' => 'The infusions rotate. Ask what\'s in the jar today, not what\'s on the list.',
            'ru'      => [ 'name' => 'Алекс', 'name_gen' => 'Алекса', 'role' => 'Бармен' ],
        ],
        [
            'name'    => 'Max',
            'role'    => 'Chef',
            'since'   => 2018,
            'photo'   => 'team/iura/iura-1.jpg',
            'chip'    => 'ask',
            'message' => 'Breakfast ends at noon. The eggs don\'t know that, so ask.',
            'ru'      => [ 'name' => 'Макс', 'name_gen' => 'Макса', 'role' => 'Шеф-повар' ],
        ],
        [
            'name'    => 'Johnny',
            'role'    => 'Sous-chef',
            'since'   => 2014,
            'photo'   => 'team/iura/iura-1.jpg',
            'chip'    => 'ask',
            'message' => 'Twelve years, one recipe I still won\'t write down. It\'s the pepper one.',
            'ru'      => [ 'name' => 'Джонни', 'name_gen' => 'Джонни', 'role' => 'Су-шеф' ],
        ],
    ],
];
