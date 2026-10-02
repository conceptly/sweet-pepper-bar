<?php
/**
 * The 404 page — the words (PROTOTYPE, 1 Oct 2026; inc/not-found.php, 404.php).
 *
 * Two sets of copy for the three layouts on trial:
 *
 *   sauce  — layouts 0 and b: the author's Figma draft ("Lost in the Sauce-404", 2803:78133)
 *   menu   — layout a: the bar answers on a ticket
 *   ticket — the slip itself, in the dish picker's card: label · the address asked for
 *            (printed by the template) with `note` under it · `says` over `reply` · `cta`
 *
 * The bar is answering here, so the lines may speak as "we" (design.md §1.1 → status
 * messages). EN is the author's draft and Claude's suggestions; RU is Claude's first draft,
 * register twins rather than translations — the author's pass is owed on both (the Russian
 * body lines have had it: 2 Oct 2026).
 *
 * @package Sweet_Pepper
 */

return [
    'sauce'  => [
        'eyebrow'  => 'Kitchen notice · Table 404',
        'headline' => 'This page got lost in the sauce.',
        'body'     => 'The kitchen looked everywhere. Pick a familiar route and we’ll get something good in front of you.',
    ],
    'menu'   => [
        'eyebrow'  => 'Kitchen notice · Order 404',
        'headline' => 'That one’s off the menu.',
        'body'     => 'The kitchen looked everywhere. Everything else is still on.',
    ],
    'ticket' => [
        'label' => 'Order 404',
        'note'  => 'No page by that name — not in the kitchen, not at the bar.',
        'says'  => 'The bar says',
        'reply' => 'Check the spelling — or take the pot roast, it never gets lost.',
        'cta'   => 'Hot dishes',
    ],
    'home'   => 'Back to home',
    'view'   => 'View the menu',
    'ru'     => [
        'sauce'  => [
            'eyebrow'  => 'Кухня сообщает · Столик 404',
            'headline' => 'Эта страница в стоп-листе.',
            'body'     => 'Искали и на кухне, и в подсобке, и за баром. Выберите знакомый маршрут — и закажите что-нибудь вкусное!', // the author's, 2 Oct 2026
        ],
        'menu'   => [
            'eyebrow'  => 'Кухня сообщает · Заказ 404',
            'headline' => 'Такого в меню нет.',
            'body'     => 'Искали и на кухне, и в подсобке, и за баром. Всё остальное — в меню.', // the first sentence is the author's (2 Oct 2026), carried from the line above
        ],
        'ticket' => [
            'label' => 'Заказ 404',
            'note'  => 'Такой страницы нет ни на кухне, ни в баре.',
            'says'  => 'Бар отвечает',
            'reply' => 'Проверьте адрес — или берите жаркое по-ярославски: оно не теряется.',
            'cta'   => 'Горячие блюда',
        ],
        'home'   => 'На главную',
        'view'   => 'Смотреть меню',
    ],
];
