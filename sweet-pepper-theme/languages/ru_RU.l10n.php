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
 * voice. The nav, the drawers and the footer follow navigation-drawers-copy-ru-draft.md
 * (25 Sep 2026). Not translated on purpose: the team
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
        // The room wordmark (desktop hero) says the place, as the phone's hero connector does —
        // the author's connector words (menu-copy-ru-draft.md → Коннекторы; author, 24 Sep 2026).
        // The doors below stay «Еда» / «Напитки»: doors name contents, wordmarks name places
        // (website-brief.md → Doors).
        'FOOD'                                       => 'КУХНЯ ОТ ПЕРЦЕВ',
        'DRINKS'                                     => 'БАР ОТ ПЕРЦЕВ',
        'More plates'                                => 'Разделы меню', // the button opens the list of sections (navigation-drawers-copy-ru-draft.md → 3)
        'More pours'                                 => 'Разделы меню',
        'Menu sections'                              => 'Разделы меню',
        'Food Menu'                                  => 'Меню кухни', // mine — the desktop jump-nav tab
        'Drinks Menu'                                => 'Барное меню', // mine
        'Food Menu sections'                         => 'Разделы меню кухни',
        'Drinks Menu sections'                       => 'Разделы барного меню',
        'Jump to a menu section'                     => 'Перейти к разделу меню', // mine
        'Close menu sections'                        => 'Закрыть список разделов', // navigation-drawers-copy-ru-draft.md → 3
        // Menu page — location and the phone closer (headline + body come from About's fields)
        'Find the Pepper'                            => 'ВАМ СЮДА',
        'Sweet Pepper restaurant entrance on Kirova Street' => 'Вход в Sweet Pepper',
        'Restaurant location map'                    => 'Карта: где находится Sweet Pepper',
        'join the party'                             => 'ждём в гости', // mine
        'Reserve a table'                            => 'Забронировать',
        // Header and drawer (✔ home-copy-ru-draft.md)
        "What's new"                                 => 'Что нового',
        'Book your table'                            => 'Ваш столик', // the drawer's booking heading (navigation-drawers-copy-ru-draft.md → 2)
        // Visit page (✔ visit-page-copy-ru-draft.md, 24 Sep 2026)
        'More about Sweet Pepper'                    => 'Больше о Sweet Pepper',
        'Directions'                                 => 'К карте',
        'Route in Yandex Maps'                       => 'Построить маршрут в Яндекс Картах',
        'Copy email address'                         => 'Скопировать email',
        'Email address copied'                       => 'Email скопирован',
        'Copy'                                       => 'Скопировать',
        'Copy address'                               => 'Скопировать адрес',
        'Address copied'                             => 'Адрес скопирован',
        'Copied!'                                    => 'Скопировано', // the contact chip and the ticket (navigation-drawers-copy-ru-draft.md → 4)
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
        'VK message'                                 => 'Написать в ВК',
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
        // Navigation and the drawers (✔ navigation-drawers-copy-ru-draft.md, the author's first draft, 25 Sep 2026)
        'Home'                                       => 'Главная',
        'Menu'                                       => 'Меню',
        'About'                                      => 'О баре',
        'Visit'                                      => 'В гости', // author, 25 Sep 2026 — was «Как добраться»
        'A taste of Sweet Pepper'                    => 'Коротко о самом важном',
        "From breakfast to late\u{2011}night drinks" => 'Кухня, бар и сезонные новинки',
        'The place, the people, the story'           => 'Люди, идея и немного истории',
        'Hours, directions and contacts'             => 'Часы работы, карта, контакты', // author, 25 Sep 2026
        "the navigation drawer dialog\4Menu"         => 'Меню сайта',
        "the navigation drawer nav\4Main"            => 'Основная навигация',
        'Get Directions'                             => 'Маршрут',
        'Kirova 10/25'                               => 'Кирова, 10/25',
        'News & Events'                              => 'Что нового',
        'Sweet Pepper on VK'                         => 'Sweet Pepper во ВКонтакте',
        'Sweet Pepper on Instagram'                  => 'Sweet Pepper в Instagram',
        'Call 911-202'                               => 'Позвонить 911-202',
        'Call Sweet Pepper'                          => 'Позвонить в Sweet Pepper',
        'Close drawer'                               => 'Закрыть бронирование',
        'YOUR TABLE'                                 => 'ВАШ СТОЛИК',
        'STEAL THE LINE'                             => 'СКОПИРОВАТЬ СООБЩЕНИЕ!',
        'Hi! A table for two, tomorrow around 21:00 — doable?' => 'Здравствуйте! Можно столик на двоих завтра около 21:00?',
        'Copied to your clipboard!'                  => 'Номер скопирован',
        'Walk-ins always welcome — booking matters Friday–Saturday evenings.' => 'Можно и без брони. На вечер пятницы и субботы лучше договориться о столике заранее.',
        'We’re open — tonight, just walk in or write ahead.' => 'Бар открыт. Заглядывайте или напишите заранее.',
        'Full house tonight — writing beats calling.' => 'Собираетесь в гости? Вечером пятницы и субботы лучше написать заранее.',
        'Closed for the night. Send a message, we’ll respond from {opens}!' => 'Бар спит. Написать можно уже сейчас, а позвонить — с {opens}.',
        'All good — admin is on the phone'           => 'Можно позвонить',
        'Might take a minute, it’s loud in here.'    => 'Не дозвонились? Напишите сообщение.',
        'We’ll pick up from {opens}.'                => 'Звонки — с {opens}',
        'GO TO'                                      => 'На сайте',
        'HOURS'                                      => 'Часы работы',
        'VISIT'                                      => 'Контакты', // the footer column — not the nav word again (author, 25 Sep 2026)
        'Top'                                        => 'Наверх',
        'Back to top'                                => 'Наверх',
        // Vacancy page (single-vacancy.php, 25 Sep 2026) — mine, for the author's pass; the
        // card's verbs Message / DM / Write follow the Visit card's pending decision
        'See the role'                               => 'Подробнее',
        'All roles'                                  => 'Все вакансии',
        'Open since %s'                              => 'Открыта с %s',
        'This role is filled. Have a look at the open ones below.' => 'Вакансия закрыта — посмотрите открытые ниже.',
        "What you'll do"                             => 'Что делать',
        "Who we're looking for"                      => 'Кого ищем',
        'What you get'                               => 'Что предлагаем',
        'Your contact'                               => 'Ваш контакт',
        'Or the bar'                                 => 'Или в бар',
        'Call'                                       => 'Позвонить',
        'Write to %s'                                => 'Написать: %s',
        "the vacancy page's bottom bar\4Write"     => 'Написать', // context: the Visit card's own Write is left English by the draft
        'Apply on hh.ru'                             => 'Откликнуться на hh.ru',
        'Other open roles'                           => 'Другие вакансии',

        // Accessibility boilerplate — conventional, not voice
        'Skip to content'                            => 'Перейти к содержимому',
        'Open menu'                                  => 'Открыть меню сайта',
        'Close menu'                                 => 'Закрыть меню сайта',
        'Close'                                      => 'Закрыть',
        'Back'                                       => 'Назад',
        'Language'                                   => 'Язык',
        'Page sections'                              => 'Разделы страницы',
        'Sweet Pepper perks'                         => 'Что есть в Sweet Pepper',
        'Sweet Pepper Bar location map'              => 'Карта: где находится Sweet Pepper',
    ],
];
