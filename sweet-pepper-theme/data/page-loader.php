<?php
/**
 * Page loader — the words (PROTOTYPE, 30 Sep 2026; inc/page-loader.php).
 *
 * The heat slider, back as the screen a guest sees while the next page is slow to come.
 * The bar is answering here, so the lines speak as "we" (design.md §1.1 → status messages).
 *
 *   label  — Molot, under the track's left end, while the page is on its way
 *   done   — the same label once the page is ready and the knob reaches the end
 *   first  — always the first line: the Figma frame's line, the reassurance
 *   lines  — the Sims-style pool, shown in a random order after `first`, one every few
 *            seconds. Each must stand alone: most waits show one or two of them. An array is
 *            a chain — its lines always come together, in order (the team's «Пересолили…»
 *            after «Солим…», 30 Sep 2026). Keep RU and EN in the same shape: the language
 *            switch carries a line by its position. One row each: ~30 characters (a line that
 *            wraps makes the slider jump; measured at 375–1280).
 *   word   — the outline wordmark along the bottom edge (the home connector and its Russian
 *            twin, inc/home-data.php → sweet_pepper_home_connectors_ru)
 *   status — for screen readers only: the one thing announced
 *
 *   ru — first draft, register twins rather than translations (30 Sep 2026).
 *
 * @package Sweet_Pepper
 */

return [
    'label'  => 'Heating up!',
    'done'   => 'Served!',
    'first'  => 'the kitchen’s on — no rush',
    'lines'  => [
        'Reticulating peppers',
        'Convincing the cranberries to infuse',
        'Letting the infusions think it over',
        'Warming the pots for the pot roast',
        'Negotiating with the Yaroslavl bear',
        'Counting peppercorns in the shaker',
        'Reassuring the chicken wings',
        'Polishing the glasses twice',
        [ 'Salting to taste. Tasting. Salting again', 'Oversalted. Starting over', 'This may take a little longer' ],
        'Asking the chef nicely',
        'Rehearsing “the usual?”',
        'Turning the heat up a notch',
        'Ignoring the thermostat since 2009',
        'Waking the hungover bartender',
    ],
    'word'   => 'at Sweet Pepper',
    'status' => 'Loading the page',
    'ru'     => [
        'label'  => 'Разогреваем!',
        'done'   => 'Подано!',
        'first'  => 'кухня работает — не спешите',
        'lines'  => [
            'Ретикулируем перчики',
            'Уговариваем клюкву настояться',
            'Даём настойкам подумать',
            'Прогреваем горшочки по-ярославски',
            'Договариваемся с медведем с герба',
            'Пересчитываем горошины в перечнице',
            'Успокаиваем крылышки',
            'Натираем бокалы до скрипа',
            [ 'Солим по вкусу. Пробуем. Солим ещё', 'Пересолили. Готовим заново', 'Придётся немного подождать' ], // the team's, 30 Sep 2026
            'Вежливо просим шефа',
            'Репетируем «вам как обычно?»',
            'Прибавляем огоньку',
            'Не трогаем термостат с 2009 года',
            'Будим бармена с бодуна', // the team's, 30 Sep 2026
        ],
        'word'   => 'Sweet Pepper Bar',
        'status' => 'Загружаем страницу',
    ],
];
