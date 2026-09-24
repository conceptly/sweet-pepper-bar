<?php
/**
 * Russian for the theme's UI strings — every `__( '…', 'sweet-pepper' )`: buttons,
 * labels, aria text. Prose and lists live in fields, not here (website-brief.md →
 * Content editing → tier 2: "Strings that are UI are neither").
 *
 * A plain PHP translation file (WordPress 6.5+), edited by hand — no .po / .mo tooling.
 * Loaded by load_theme_textdomain() when the request is Russian (inc/lang.php sets the
 * locale from the URL). A string missing here prints in English.
 *
 * Sources: about-page-copy-ru-draft.md (buttons, marked ✔), home-copy-ru-draft.md (the home
 * page's buttons and chips, 25 Sep 2026); the
 * accessibility boilerplate (skip link, open / close, back) is conventional wording, not
 * voice. Not translated on purpose: the nav (no Russian in the drafts yet), the team
 * form (deferred by the draft), the Visit contact card's booking group — Message, DM, Write,
 * the call label (deferred by visit-page-copy-ru-draft.md), image alt texts, "Says".
 */
return [
    'domain'       => 'sweet-pepper',
    'language'     => 'ru_RU',
    'plural-forms' => 'nplurals=3; plural=(n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<12 || n%100>14) ? 1 : 2);',
    'messages'     => [
        // About — buttons and labels (✔ about-page-copy-ru-draft.md)
        'See the full menu'                          => 'Всё меню',
        'Try it yourself'                            => 'Спросите Гастробота',
        'Pick a plate — see what the bar suggests.'  => 'Выберите блюдо — и получите рекомендацию от бара!',
        'Add your word'                              => 'Добавить свой отзыв',
        'Get your table'                             => 'Забронировать',
        'See the menu'                               => 'Смотреть меню',
        'Read the review'                            => 'Читать в источнике',
        'Browse the photo albums'                    => 'Фото в VK',
        'Write to the team'                          => 'Написать команде',
        'To be continued…'                           => 'Продолжение следует…',
        'View role on hh.ru'                         => 'Вакансия на hh.ru',
        'Send your CV'                               => 'Отправить резюме',
        'YOUR DESTINATION'                           => 'ВАМ СЮДА',
        'Get directions'                             => 'Построить маршрут',
        'The way in'                                 => 'Здесь вход',
        // The dish picker (✔ about-page-copy-ru-draft.md → Подбор пары; «Ваш выбор» — author, 23 Sep 2026)
        'Your Match'                                 => 'Ваш выбор',
        'Shake it — pick a random dish'              => 'Выбрать случайное блюдо',
        '+ unforgettable with'                       => 'К этому блюду',
        // Menu page pickers — the same name as About's (author, 23 Sep 2026)
        'Find Your Match!'                           => 'Спросите Гастробота',
        'Pick a plate — the bar takes care of the rest.'     => 'Выберите блюдо — и получите рекомендацию от бара!',
        'Pick a drink — the kitchen takes care of the rest.' => 'Выберите напиток — и получите рекомендацию от кухни!',
        'See this drink'                             => 'О напитке',
        // Menu page (✔ menu-copy-ru-draft.md → Навигация и подписи, 23 Sep 2026; «mine» = not in the draft)
        'Food'                                       => 'Еда',
        'Drinks'                                     => 'Напитки',
        'FOOD'                                       => 'ЕДА',
        'DRINKS'                                     => 'НАПИТКИ',
        'More plates'                                => 'Ещё блюда',
        'More pours'                                 => 'Ещё напитки',
        'Menu sections'                              => 'Разделы меню',
        'Food Menu'                                  => 'Меню кухни', // mine — the desktop jump-nav tab
        'Drinks Menu'                                => 'Барное меню', // mine
        'Food Menu sections'                         => 'Разделы меню кухни',
        'Drinks Menu sections'                       => 'Разделы барного меню',
        'Jump to a menu section'                     => 'Перейти к разделу меню', // mine
        'Close menu sections'                        => 'Закрыть разделы меню', // mine
        // The hero's door to the other menu — mine, the draft has none
        "Pepper's Breakfast"                         => 'Завтрак от Перцев',
        'Cappuccino & Gelato'                        => 'Капучино с мороженым',
        'The full kitchen — breakfast to dinner, soups to desserts, all cooked fresh and served at the bar or the table.' => 'Вся кухня — от завтрака до ужина, от супов до десертов. Готовим сами и подаём к стойке или к столику.',
        'House-made infusions, natural cocktails, local wines, and craft beer — the bar is a destination on its own. No syrup shortcuts.' => 'Домашние настойки, коктейли, вино и крафтовое пиво — в бар стоит прийти ради самого бара. Без сиропов-полуфабрикатов.',
        // Menu page — location and the phone closer (headline + body come from About's fields)
        'Find the Pepper'                            => 'ВАМ СЮДА',
        'Sweet Pepper restaurant entrance on Kirova Street' => 'Вход в Sweet Pepper',
        'Restaurant location map'                    => 'Карта: где находится Sweet Pepper',
        'join the party'                             => 'ждём в гости', // mine
        'Reserve a table'                            => 'Забронировать',
        // Header and drawer (✔ home-copy-ru-draft.md)
        "What's new"                                 => 'Что нового',
        'Book your table'                            => 'Забронировать',
        // Visit page (✔ visit-page-copy-ru-draft.md, 24 Sep 2026)
        'More about Sweet Pepper'                    => 'Больше о Sweet Pepper',
        'Directions'                                 => 'К карте',
        'Route in Yandex Maps'                       => 'Построить маршрут в Яндекс Картах',
        'Copy email address'                         => 'Скопировать email',
        'Email address copied'                       => 'Email скопирован',
        'Copy'                                       => 'Скопировать',
        'Copy address'                               => 'Скопировать адрес',
        'Address copied'                             => 'Адрес скопирован',
        'Copied!'                                    => 'Скопировано!', // mine — the contact chip's success state
        // Opening hours rows — Visit hours card and the footer (✔ visit-page-copy-ru-draft.md → Часы работы;
        // the Mon–Thu / Fri–Sat split is mine, for a weekend with its own closing time)
        'Mon–Sat'                                    => 'Пн–сб',
        'Sunday'                                     => 'Воскресенье',
        'Mon–Thu'                                    => 'Пн–чт',
        'Fri–Sat'                                    => 'Пт–сб',
        // Home page (✔ home-copy-ru-draft.md; «mine» = not in the draft) — 25 Sep 2026; Copy / Copy address / Address copied are above, the Visit page's
        'Now'                                        => 'Сейчас',
        'Reserve'                                    => 'Забронировать',
        'Drinks menu'                                => 'Барное меню',
        'Food menu'                                  => 'Меню кухни',
        'Explore the drinks menu'                    => 'Посмотреть барное меню',
        'Explore the food menu'                      => 'Посмотреть меню кухни',
        'Read the full story'                        => 'Больше о Перце',
        "See what's on VK"                           => 'Новости в VK',
        'View Instagram'                             => 'Новости в Instagram',
        'VK message'                                 => 'Написать во ВКонтакте',
        'Instagram DM'                               => 'Написать в Instagram',
        'Usually answer in 20 minutes'               => 'Обычно отвечаем в течение 20 минут', // mine — the RU review asks not to promise a time until the team confirms one
        'Copied'                                     => 'Скопировано',
        "home map chip — opens directions to the bar\4Directions" => 'Маршрут', // mine — the desktop chip is short (the full action, «Построить маршрут», is its aria name); a context, because "Directions" means «К карте» on the Visit page
        'Yandex Maps'                                => 'Яндекс Карты',
        'Plan your visit'                            => 'Спланировать визит',
        'Kirova 10/25, Yaroslavl'                    => 'Ярославль, ул. Кирова, 10/25',
        'Event'                                      => 'Событие',    // mine — the social cards' pills
        'Promo'                                      => 'Акция',      // mine
        'Community'                                  => 'Наши гости', // mine
        'See it on VK'                               => 'Смотреть во ВКонтакте', // mine
        'See it on Instagram'                        => 'Смотреть в Instagram',  // mine
        'Today!'                                     => 'Сегодня!',
        // Accessibility boilerplate — conventional, not voice
        'Skip to content'                            => 'Перейти к содержимому',
        'Open menu'                                  => 'Открыть меню',
        'Close menu'                                 => 'Закрыть меню',
        'Close'                                      => 'Закрыть',
        'Back'                                       => 'Назад',
        'Language'                                   => 'Язык',
        'Page sections'                              => 'Разделы страницы',
        'Sweet Pepper perks'                         => 'Что есть в Sweet Pepper',
        'Sweet Pepper Bar location map'              => 'Карта: где находится Sweet Pepper',
    ],
];
