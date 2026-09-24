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
 * Sources: about-page-copy-ru-draft.md (buttons, marked ✔), home-copy-ru-draft.md; the
 * accessibility boilerplate (skip link, open / close, back) is conventional wording, not
 * voice. Not translated on purpose: the nav (no Russian in the drafts yet), the team
 * form (deferred by the draft), the Visit CTA buttons (its block is deferred), image alt
 * texts, "Says".
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
