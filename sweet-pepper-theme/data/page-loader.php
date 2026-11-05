<?php
/**
 * Page loader — the words (PROTOTYPE, 30 Sep 2026; inc/page-loader.php).
 *
 * The heat slider, back as the screen a guest sees while the next page is slow to come.
 * The bar is answering here, so the lines speak as "we" (design.md §1.1 → status messages).
 *
 *   label  — Molot, under the track's left end, while the page is on its way
 *   done   — the same label once the page is ready and the knob reaches the end
 *   lines  — SINCE 1 OCT 2026 THE SEED AND THE FALLBACK: the team keeps the pool in admin,
 *            «Пасхалка» (inc/page-loader.php; seeded from here by tools/page-seed.php
 *            loader), and these lists render only while a site has no record or the record
 *            shows nothing. label, done and status are still read from here.
 *            The Sims-style pool, shown in a random order, one every few seconds; a run
 *            opens on whichever comes first (no fixed opener since 30 Sep 2026 — «кухня
 *            работает — не спешите» showed while the kitchen was closed, author). Each must stand alone: most waits show one or two of them. An array is
 *            a chain — its lines always come together, in order (the team's «Пересолили…»
 *            after «Солим…», 30 Sep 2026). Keep RU and EN in the same shape: the language
 *            switch carries a line by its position. One row each: up to ~35 characters (a
 *            line that wraps makes the slider jump; 34 RU / 40 EN fit from 375 up, 46 didn't).
 *            The readable copy for review: page-loader-copy.md (repo root).
 *   status — for screen readers only: the one thing announced
 *
 *   ru — first draft, register twins rather than translations (30 Sep 2026).
 *
 * @package Sweet_Pepper
 */

return [
    'label'  => 'Heating up!',
    'done'   => 'Served!',
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
    'status' => 'Loading the page',
    'ru'     => [
        'label'  => 'Разогреваем!',
        'done'   => 'Подано!',
        'lines'  => [
            'Ретикулируем перчики',
            'Уговариваем клюкву настояться',
            'Даём настойкам подумать',
            'Прогреваем горшочки по-ярославски',
            'Договариваемся с медведем с герба',
            'Считаем горошины в перечнице', // was «Пересчитываем…»: 333px, two rows on a 390–393 phone (1 Oct 2026)
            'Успокаиваем крылышки',
            'Натираем бокалы до скрипа',
            [ 'Солим по вкусу. Пробуем. Солим ещё', 'Пересолили. Готовим заново', 'Придётся немного подождать' ], // the team's, 30 Sep 2026
            'Вежливо просим шефа',
            'Репетируем «вам как обычно?»',
            'Прибавляем огоньку',
            'Не трогаем термостат с 2009 года',
            'Будим бармена с бодуна', // the team's, 30 Sep 2026
        ],
        'status' => 'Загружаем страницу',
    ],
];
