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
 * the call label (deferred by visit-page-copy-ru-draft.md), "Says". Image alt texts joined on
 * 25 Sep 2026 (the SEO & accessibility pass).
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
        "short label, phone two-up row\4VK message"   => 'ВКонтакте', // author, 25 Sep 2026; the full «Написать в …» stays in aria-label
        "short label, phone two-up row\4Instagram DM" => 'Instagram',
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

        // Forms — forms-copy-ru-draft.md (25 Sep 2026): the Visit and home contact form, the About
        // team form. Home title and subtitle from home-copy-ru-review.md §9. The success words are
        // written for a confirmed send; the forms do not send yet (draft §6).
        'Send a message'                             => 'Написать сообщение',
        "the Visit page form\4Send a message"        => 'Написать Перцам',
        "the Visit form title, phones\4or "          => 'или ',
        "We'll get back to you within 24 hours."     => 'Выберите, как вам удобнее получить ответ.',
        "Feedback, partnerships, events, or anything that's not a reservation. We'll get back to you within 24 hours!" => 'Отзыв, идея, праздник в Перце или предложение о сотрудничестве? Рассказывайте. А о столике лучше договориться по телефону или в сообщениях.',
        'What is it about?'                          => 'О чём сообщение?',
        'Private event'                              => 'Мероприятие', // draft: «Праздник в Перце» is the open alternative
        'Press & Partners'                           => 'Пресса и партнёры',
        'Feedback'                                   => 'Отзыв',
        'Any questions'                              => 'Вопрос',
        "contact form\4Name"                         => 'Ваше имя',
        'Your name'                                  => 'Ваше имя',
        "contact form\4Email"                        => 'Почта',
        'Your Email'                                 => 'Почта',
        "contact form\4Phone"                        => 'Телефон',
        "contact form\4Message"                      => 'Сообщение',
        'Please, pick the preferred contact method'  => 'Как с вами связаться?',
        "contact form\4Submit"                       => 'Отправить',
        "contact form\4Send"                         => 'Отправить',
        'Please enter your name'                     => 'Укажите имя',
        'Please enter a valid email'                 => 'Проверьте адрес почты',
        'Please enter your phone number'             => 'Укажите номер телефона',
        'Please enter a message'                     => 'Напишите сообщение',
        'Message has been sent!'                     => 'Сообщение отправлено!',
        'message has been sent!'                     => 'Сообщение отправлено!',
        'We appreciate you taking the time to write to us. A real human from the bar will read your message and respond directly to your inbox within 24 hours.' => 'Спасибо, что написали Перцам. Если понадобится ответ, команда свяжется с вами по оставленным контактам.',
        'Direct contact email'                       => 'Можно написать и на почту:',
        'Need instant assistance? Give us a call!'   => 'Вопрос срочный? Лучше позвонить.',
        'need instant assistance? give us a call!'   => 'Вопрос срочный? Лучше позвонить.',
        'Send another message'                       => 'Написать ещё',
        'WRITE TO THE TEAM'                          => 'Пара слов команде',
        'To:'                                        => 'Кому:',
        "team form recipients\4All"                  => 'Всей команде',
        "team form recipient\4Lera"                  => 'Лере',
        "team form recipient\4Lenya"                 => 'Лёне',
        "team form recipient\4Iura"                  => 'Юре',
        "team form recipient\4Anton"                 => 'Антону',
        'We answer within a day — faster by DM (VK / Telegram).' => 'Оставьте почту для ответа.', // the draft drops the unconfirmed day / Telegram promise
        "team form\4Close"                           => 'Закрыть форму',

        // The rest of the English on Russian pages (25 Sep 2026). Filmstrip: the author's; the
        // contact-row actions, alts and the entrance alt: mine, for review.
        "About filmstrip\4Gastrobar"                 => 'Гастробар', // author's second option: «Идея»
        "About filmstrip\4Story"                     => 'История',
        "About filmstrip\4People"                    => 'Люди',
        "About filmstrip\4Careers"                   => 'Работа',
        "About filmstrip\4Location"                  => 'Адрес',
        'Sweet Pepper team group photo, %s'          => 'Команда Sweet Pepper, %s',
        'Photo of %s'                                => 'Фото: %s',
        'Entrance to Sweet Pepper Gastrobar, Kirova St. 10/25' => 'Вход в гастробар Sweet Pepper, ул. Кирова, 10/25',
        "a contact row action\4Message"              => 'Написать',
        "a contact row action\4DM"                   => 'Написать',
        "a contact row action\4Write"                => 'Написать',
        'Call %s'                                    => 'Позвонить: %s',

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
        // Image alt texts and icon names (SEO & accessibility pass, 25 Sep 2026) — descriptive, not voice
        'Vegetarian'                                 => 'Вегетарианское',
        'House hit'                                  => 'Хит',
        'Spicy'                                      => 'Острое',
        'Local Yaroslavl dish'                       => 'Ярославское блюдо',
        'Sweet Pepper — Good Food & Drink Since 2014' => 'Sweet Pepper — вкусная еда и напитки с 2014 года',
        'Photo of %s'                                => 'Фото: %s',
        'Sweet Pepper team group photo, %s'          => 'Команда Sweet Pepper, %s',
        'Entrance to Sweet Pepper Gastrobar, Kirova St. 10/25' => 'Вход в гастробар Sweet Pepper, Кирова, 10/25',
        'Pepper’s Breakfast — fried eggs, a patty, toast and salad' => 'Завтрак от Перцев: глазунья, котлета, тосты и салат',
        'Cranberry infusion in three shot glasses with berries and mint' => 'Клюквенная настойка в трёх стопках с ягодами и мятой',
        'The Sweet Pepper team behind the bar, 2025'  => 'Команда Sweet Pepper за стойкой, 2025',
        'Five layered shots lined up on the lit bar'  => 'Пять слоёных шотов на подсвеченной стойке',
        'The Sweet Pepper entrance: a glass door with the pepper logo' => 'Вход в Sweet Pepper: стеклянная дверь с логотипом-перцем',
    ],
];
