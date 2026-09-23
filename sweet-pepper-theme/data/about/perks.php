<?php
/**
 * About data: Beyond Shake & Cook — the six stamps as typed before the page moved into
 * WordPress. Fallback for sweet_pepper_about_perks() and the seed source. The colour deal
 * (Lime → Lemon → Paprika) and the tilt are the theme's.
 *
 *   label — the desktop word in the stamp · word — the phone word · icon — assets/icons/<icon>.svg
 *   ru — from about-page-copy-ru-draft.md → 4. Удобства (one word for both stamp sizes;
 *        the draft flags the Russian lengths for a check in the component)
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'    => 'WHAT TO EXPECT',
    'headline'   => 'BEYOND SHAKE',
    'headline_2' => '& COOK',
    'ru'         => [ 'eyebrow' => 'ЧТО ВАС ЖДЁТ', 'headline' => 'НЕ ТОЛЬКО', 'headline_2' => 'ЕДА И НАПИТКИ' ],
    'perks'      => [
        [ 'icon' => 'wifi',       'label' => 'Wi-Fi',            'word' => 'Wi-Fi',     'title' => 'WI-FI & POWER',            'description' => 'Plug in, get comfortable. Wi-Fi and power sockets are available, with chargers at the bar.',
          'ru' => [ 'label' => 'Wi-Fi',        'word' => 'Wi-Fi',        'title' => 'WI-FI И РОЗЕТКИ',       'description' => 'Устраивайтесь поудобнее: есть Wi-Fi и розетки, а зарядку можно попросить у бара.' ] ],
        [ 'icon' => 'kids',       'label' => 'Kids Welcome',     'word' => 'Kids',      'title' => 'KIDS\' MENU & ACTIVITIES',  'description' => 'A menu for smaller appetites, colouring books and cartoons at weekends.',
          'ru' => [ 'label' => 'С детьми',     'word' => 'С детьми',     'title' => 'ДЛЯ МАЛЕНЬКИХ ГОСТЕЙ',  'description' => 'Детское меню, раскраски и мультфильмы по выходным.' ] ],
        [ 'icon' => 'dog',        'label' => 'Dog-friendly',     'word' => 'Dogs',      'title' => 'DOGS WELCOME',             'description' => 'Your dog is welcome too. Water bowls are on the house.',
          'ru' => [ 'label' => 'С собакой',    'word' => 'С собакой',    'title' => 'СОБАКАМ ТОЖЕ РАДЫ',     'description' => 'Приходите с собакой. Миска с водой найдётся и для неё.' ] ],
        [ 'icon' => 'sun',        'label' => 'Terrace',          'word' => 'Terrace',   'title' => 'SUMMER TERRACE',           'description' => 'Take your drink outside and settle into a swing chair.',
          'ru' => [ 'label' => 'Веранда',      'word' => 'Веранда',      'title' => 'ЛЕТНЯЯ ВЕРАНДА',        'description' => 'Любимый напиток, свежий воздух и кресло-качели.' ] ],
        [ 'icon' => 'star',       'label' => 'The Way You Like', 'word' => 'Your way',  'title' => 'JUST THE WAY YOU LIKE IT', 'description' => 'Something to leave out or add? Ask the team about making it your way.',
          'ru' => [ 'label' => 'По вкусу',     'word' => 'По вкусу',     'title' => 'ТАК, КАК ВЫ ЛЮБИТЕ',    'description' => 'Что-то убрать или добавить? Спросите команду, как можно изменить блюдо под ваш вкус.' ] ],
        [ 'icon' => 'accessible', 'label' => 'Accessible',       'word' => 'Step-free', 'title' => 'STEP-FREE ENTRANCE',       'description' => 'A step-free way in, with a ramp and help from the team if you need it.',
          'ru' => [ 'label' => 'Без ступенек', 'word' => 'Без ступенек', 'title' => 'ВХОД БЕЗ СТУПЕНЕК',     'description' => 'На входе есть пандус. Если понадобится помощь, обратитесь к команде.' ] ],
    ],
];
