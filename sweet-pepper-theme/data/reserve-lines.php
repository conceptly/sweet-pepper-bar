<?php
/**
 * The reserve drawer's ready-made booking messages — the lines a guest copies from the ticket
 * and sends by phone message or VK. Written as the guest, not as the bar: a real message with a
 * light touch of the house voice («партер» at the bar, «Перцы», «местечко» —
 * russian-website-voice.md). Each is a different occasion, so a guest picks the one nearest their
 * own and edits less. Times and party sizes are examples, never a promise of a free table.
 *
 * Fallback for sweet_pepper_reserve_lines() while Bar Settings → «Бронь — сообщения» is empty,
 * and the seed for tools/reserve-lines-seed.php. Author's pick, 3 Oct 2026; the first line is
 * the one the ticket carried alone until then.
 *
 * @package Sweet_Pepper
 */

return [
    [ 'line_ru' => 'Здравствуйте! Можно столик на двоих завтра около 21:00?',
      'line_en' => 'Hi! A table for two, tomorrow around 21:00 — doable?' ],
    [ 'line_ru' => 'Здравствуйте! Можно два места в партере — у стойки, в пятницу к 20:00?',
      'line_en' => 'Hi! Two front-row seats at the bar, Friday at 20:00?' ],
    [ 'line_ru' => 'Привет, Перцы! Нас четверо, придём после работы, к семи. Придержите столик?',
      'line_en' => 'Hi, Peppers! Four of us after work today, around 7. Hold us a table?' ],
    [ 'line_ru' => 'Добрый день! Отмечаем день рождения: нас шестеро, суббота, 19:00. Найдётся местечко?',
      'line_en' => 'Hi! A birthday — six of us, Saturday at 19:00. Room for us?' ],
    [ 'line_ru' => 'Здравствуйте! В воскресенье к 11:00 на завтрак, с нами ребёнок. Найдётся столик?',
      'line_en' => 'Hi! Sunday breakfast at 11:00, with a little one. A table for us?' ],
];
