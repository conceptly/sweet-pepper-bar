<?php
/**
 * Visit data: Getting here — the eyebrow, the "Good to know" slip and the six landmark
 * badges. The headline is shared (Bar Settings, inc/location.php). Fallback for
 * sweet_pepper_visit_location() and the seed source.
 *
 * Each landmark has its own route map (the `mid` in template-parts/visit/location.php), so
 * the six are fixed slots, not a list. `aria` names the route button for a screen reader
 * (Russian needs the genitive, so it is written out, not built).
 *
 *   ru — from visit-page-copy-ru-draft.md → 2. Как добраться. Distances: the English figures
 *        in Russian units — the draft's {расстояние} placeholders, still to measure (the bus
 *        stop's is computed, not measured). The stop's name, Первомайская, is the English
 *        hint's; the draft left it open.
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'   => 'your destination',
    'note_title' => 'Good to know',
    'note_main' => 'Kirova is pedestrian-only.',
    'note_sub'  => 'The last part of the journey is on foot.',
    'landmarks' => [
        'door'   => [ 'name' => 'The door', 'hint' => 'Kirova 10/25', 'distance' => '', 'aria' => 'Show the entrance on the map',
                      'ru' => [ 'name' => 'Вход', 'hint' => 'Кирова, 10/25', 'distance' => '', 'aria' => 'Показать вход на карте' ] ],
        'tower'  => [ 'name' => 'Znamenskaya Tower', 'hint' => 'Towards Pervomaiskaya', 'distance' => '350 m · 5 min', 'aria' => 'Show the walking route from Znamenskaya Tower',
                      'ru' => [ 'name' => 'Знаменская башня', 'hint' => 'В сторону Первомайской', 'distance' => '350 м · 5 мин', 'aria' => 'Показать пеший маршрут от Знаменской башни' ] ],
        'square' => [ 'name' => 'Sovetskaya sq.', 'hint' => 'Past the fountains', 'distance' => '350 m · 5 min', 'aria' => 'Show the walking route from Sovetskaya Square',
                      'ru' => [ 'name' => 'Советская площадь', 'hint' => 'Через Андропова, мимо фонтанов', 'distance' => '350 м · 5 мин', 'aria' => 'Показать пеший маршрут от Советской площади' ] ],
        'strelka' => [ 'name' => 'Strelka', 'hint' => 'Where the rivers meet', 'distance' => '1.3 km · 16 min', 'aria' => 'Show the walking route from Strelka',
                      'ru' => [ 'name' => 'Стрелка', 'hint' => 'Там, где встречаются реки', 'distance' => '1,3 км · 16 мин', 'aria' => 'Показать пеший маршрут от Стрелки' ] ],
        'kremlin' => [ 'name' => 'Bogoyavlenskaya sq.', 'hint' => 'And the old Kremlin', 'distance' => '900 m · 12 min', 'aria' => 'Show the walking route from Bogoyavlenskaya Square',
                      'ru' => [ 'name' => 'Богоявленская площадь', 'hint' => 'Старый Кремль', 'distance' => '900 м · 12 мин', 'aria' => 'Показать пеший маршрут от Богоявленской площади' ] ],
        // Stands in for parking for now (several car parks — open). 250 m · 4 min is computed, not measured.
        'stop'   => [ 'name' => 'Nearest bus stop', 'hint' => 'Pervomayskaya', 'distance' => '250 m · 4 min', 'aria' => 'Show the walking route from the nearest bus stop',
                      'ru' => [ 'name' => 'Ближайшая остановка', 'hint' => 'Первомайская', 'distance' => '250 м · 4 мин', 'aria' => 'Показать пеший маршрут от ближайшей остановки' ] ],
    ],
    'ru'        => [
        'eyebrow'    => 'ВАМ СЮДА',
        'note_title' => 'ПОЛЕЗНО ЗНАТЬ',
        'note_main'  => 'Кирова — пешеходная улица.',
        'note_sub'   => 'Идеальна для прогулок, встреч с друзьями и свиданий!',
    ],
];
