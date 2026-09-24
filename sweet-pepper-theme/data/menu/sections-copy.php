<?php
/**
 * Menu data: each section's own copy — headline, eyebrow, the section photo's caption and
 * the deal card — in both languages, plus the Russian twins of the section words in
 * inc/menu-sections.php (nav label, hero button, hero caption, hero paragraph).
 *
 * The typed fallback and the seed source for the section fields on «Разделы меню»
 * (acf-json/group_sp_menu_list.json → «Тексты раздела»; tools/menu-seed.php --copy),
 * read by sweet_pepper_menu_sections() (inc/menu-sections.php). Russian from
 * menu-copy-ru-draft.md (the ### headings, eyebrows and hero paragraphs, author, 23 Sep
 * 2026); lines marked `// draft` are mine where the draft has no Russian — refine in admin.
 *
 *   headline — the desktop <h2>; empty = the nav label
 *   pill     — the section photo's caption (Lemon pill) and its alt; names what the photo shows
 *   alt      — optional longer alt, when the pill is too short to describe the photo
 *   deal     — the deal card: title · main · sub, or a link label instead of sub
 *
 * @package Sweet_Pepper
 */

return [
    'breakfast'  => [
        'headline' => '',
        'eyebrow'  => 'whenever your morning starts',
        'pill'     => "Pepper's Breakfast",
        'alt'      => "Pepper's Breakfast — fried eggs with vegetables, toast and a patty",
        'deal'     => [ 'title' => 'Morning Bubbles!', 'main' => 'A glass of Bio Bio', 'sub' => 'for 260-. with any breakfast!' ],
        'ru'       => [
            'label'       => 'Завтраки',
            'cta_label'   => 'Завтраки',
            'headline'    => 'На завтрак',
            'eyebrow'     => 'Когда бы ни началось утро',
            'description' => 'Проснулись к обеду? Завтраки — весь день, цены — те же. Выбирайте любимое.',
            'caption'     => 'Завтрак от Перцев',
            'pill'        => 'Завтрак от Перцев',
            'alt'         => 'Завтрак от Перцев — глазунья с овощами, тост и котлета', // draft
            // The offers table (menu-copy-ru-draft.md → Предложения): volume, price and times to confirm.
            'deal'        => [ 'title' => 'Немного игристого', 'main' => 'Бокал Bio Bio', 'sub' => 'по специальной цене к завтраку' ],
        ],
    ],
    'lunch'      => [
        'headline' => '',
        'eyebrow'  => 'weekdays 12pm – 4pm',
        'pill'     => 'Yaroslavl Bagel Lunch',
        'deal'     => [ 'title' => 'Drinks deal!', 'main' => 'Tea, Coffee, Juice & more', 'sub' => '50% off with any hot dish!' ],
        'ru'       => [
            'label'       => 'Обеды',
            'cta_label'   => 'Обеды',
            'headline'    => 'Ланчи от Перцев',
            'eyebrow'     => 'По будням с 12 до 16',
            'description' => 'Салат, суп, горячее и напиток — соберите свой обед. Небольшая пауза среди буднего дня, в вашем темпе.',
            'caption'     => 'Ланч с бейглом', // draft
            'pill'        => 'Ланч с бейглом', // draft
            'deal'        => [ 'title' => 'Напитки к обеду', 'main' => 'Скидка 50% на напитки', 'sub' => 'при заказе горячего' ],
        ],
    ],
    'bar-snacks' => [
        'headline' => '',
        'eyebrow'  => 'share with friends',
        'pill'     => 'Grilled wings', // was "Pepper's Stuffed Chicken" — a placeholder on the wings photo
        'deal'     => [ 'title' => 'perfect together', 'main' => 'Infusions 3+1', 'link' => 'See it in the Bar menu!' ],
        'ru'       => [
            'label'       => 'Закуски',
            'cta_label'   => 'Закуски',
            'headline'    => 'Для аппетита и на закуску',
            'eyebrow'     => 'На всю компанию',
            'description' => 'Ассорти, соленья, крылышки и что-нибудь в центр стола. К ним найдётся свой напиток — бар поможет выбрать.',
            'caption'     => 'Мясной сет 2026',
            'pill'        => 'Крылышки-гриль',
            'deal'        => [ 'title' => 'Идеальная пара', 'main' => 'Настойки 3 + 1', 'link' => 'Смотреть в барном меню' ], // draft
        ],
    ],
    'salads'     => [
        'headline' => "Pepper's Salads",
        'eyebrow'  => 'fresh & crisp',
        'pill'     => 'Iconic Cobb Salad',
        'ru'       => [
            'label'       => 'Салаты',
            'cta_label'   => 'Салаты',
            'headline'    => 'Салаты от Перцев',
            'eyebrow'     => 'На любой вкус',
            'description' => 'Кобб, сицилийский с апельсинами или любимый цезарь. Что-нибудь свежее к основному блюду — или вместо него.',
            'caption'     => 'Кобб салат',
            'pill'        => 'Кобб салат',
        ],
    ],
    'sandwiches' => [
        'headline' => 'Sandwiches & Bagels',
        'eyebrow'  => 'house-made sesame bagels',
        'pill'     => "Pepper's chicken club", // was "Pepper's Stuffed Chicken" — a placeholder on the club photo
        'ru'       => [
            'label'       => 'Сэндвичи',
            'cta_label'   => 'Сэндвичи и бейглы',
            'headline'    => 'Сэндвичи и бейглы',
            'eyebrow'     => 'На булочках от Перцев',
            'description' => 'Сэндвичи и домашние бейглы с сытной начинкой. Хочется всего сразу? Попробуйте сэндвич-сет: сэндвич на выбор, картошка фри и любимый соус.',
            'caption'     => 'Клаб-сэндвич с цыплёнком', // draft — the menu calls all three clubs «Классика жанра»
            'pill'        => 'Клаб-сэндвич с цыплёнком', // draft
        ],
    ],
    'soups'      => [
        'headline' => '',
        'eyebrow'  => 'warm & comforting',
        'pill'     => 'Iconic Pumpkin Soup',
        'ru'       => [
            'label'       => 'Супы',
            'cta_label'   => 'Супы',
            'headline'    => 'На первое',
            'eyebrow'     => 'Согреться и подкрепиться',
            'description' => 'Борщ с гренками и салом, тыквенный или грибной суп. Что-нибудь горячее для начала — или то, ради чего вы пришли.',
            'caption'     => 'Тыквенный суп',
            'pill'        => 'Тыквенный суп',
        ],
    ],
    'hot-dishes' => [
        'headline' => '',
        'eyebrow'  => 'from the kitchen',
        'pill'     => 'Yaroslavl-Style Roast',
        'ru'       => [
            'label'       => 'Горячее',
            'cta_label'   => 'Горячее',
            'headline'    => 'На горячее',
            'eyebrow'     => 'самые сытные',
            'description' => 'Паста, стейки, блюда с гриля и жаркое по-ярославски. Когда хочется поесть основательно.',
            'caption'     => 'Жаркое по-ярославски',
            'pill'        => 'Жаркое по-ярославски',
        ],
    ],
    'desserts'   => [
        'headline' => '',
        'eyebrow'  => 'always room for something sweet',
        'pill'     => 'Raspberry Mille-Feuille',
        'ru'       => [
            'label'       => 'Десерты',
            'cta_label'   => 'Десерты',
            'headline'    => 'На сладкое',
            'eyebrow'     => 'Для полного счастья',
            'description' => 'Яблочный штрудель с мороженым, малиновый наполеон или кусочек чизкейка. Вам можно! А если сейчас уже некуда — возьмите с собой.',
            'caption'     => 'Малиновый наполеон',
            'pill'        => 'Малиновый наполеон',
        ],
    ],
    'kids'       => [
        'headline' => 'For Little Peppers',
        'eyebrow'  => 'favorites they finish',
        'pill'     => 'Home-Made Nuggets',
        'ru'       => [
            'label'       => 'Детям',
            'cta_label'   => 'Детям',
            'headline'    => 'Детское Меню',
            'eyebrow'     => 'Для маленьких Перцев',
            'description' => 'Блинчики, сырники, наггетсы и паста с той же кухни, только порции поменьше. Знакомые блюда для самых маленьких за столом.',
            'caption'     => 'Домашние наггетсы',
            'pill'        => 'Домашние наггетсы',
        ],
    ],
    'infusions'  => [
        'headline' => '',
        'eyebrow'  => 'Home-made, since 2014',
        'pill'     => 'Home-Made Infusions',
        'deal'     => [ 'title' => '3+1 Deal!', 'main' => 'Order 3 infusions,', 'sub' => 'get the 4th free!' ],
        'ru'       => [
            'label'       => 'Настойки',
            'cta_label'   => 'Фирменные настойки', // the draft's «Домашние настойки» predates the heading's rename
            'headline'    => 'Фирменные настойки',
            'eyebrow'     => 'Собственного приготовления',
            'description' => 'Клюква, солёная карамель, малиновый джин — знакомьтесь с любимчиками. А для смельчаков найдётся хреновуха: у Ярославля тоже есть горячий характер.',
            'caption'     => 'Ягодный фестиваль', // draft
            'pill'        => 'Фирменные настойки',
            'deal'        => [ 'title' => '3 + 1 в подарок', 'main' => 'Закажите три —', 'sub' => 'четвёртая в подарок!' ],
        ],
    ],
    'cocktails'  => [
        'headline' => '',
        'eyebrow'  => 'shake & stir',
        'pill'     => 'Manhattan',
        'deal'     => [ 'title' => 'Spritz Time!', 'main' => 'Aperol, Campari or Sarti', 'sub' => 'any spritz — 425-.' ],
        'ru'       => [
            'label'       => 'Коктейли',
            'cta_label'   => 'Коктейли',
            'headline'    => 'Коктейли',
            'eyebrow'     => 'Классика и авторские миксы',
            'description' => 'Любимая классика и коктейли с перцевским характером. Уже знаете, чего хочется? Отлично. Пока нет? Расскажите, что любите — смешаем специально для вас!',
            'caption'     => 'Манхэттен',
            'pill'        => 'Манхэттен',
            'deal'        => [ 'title' => 'Время спритца!', 'main' => 'Aperol, Campari или Sarti', 'sub' => 'любой спритц — 425-.' ], // draft
        ],
    ],
    'wine'       => [
        'headline' => '',
        'eyebrow'  => 'by the glass or bottle',
        'pill'     => "Tonight's red", // was "Pepper's Stuffed Chicken" — a placeholder on the red wine photo
        'deal'     => [ 'title' => "It's Wine O'Clock!", 'main' => 'Every Wednesday', 'sub' => '10% off bottles all day' ],
        'ru'       => [
            'label'       => 'Вино',
            'cta_label'   => 'Вино',
            'headline'    => 'Винная карта',
            'eyebrow'     => 'По бокалам и бутылкам',
            'description' => 'Бокал к обычному ужину тоже заслуживает внимания. Каждый сезон в карте появляются новые вина, а на дегустациях — новые любимчики. Команда поможет найти вашего!',
            'caption'     => 'Красное на вечер', // draft
            'pill'        => 'Красное на вечер', // draft
            // The offers table: «Скидка 10% на вино из открытых бутылок» — the EN card says "bottles all day"; conditions to confirm.
            'deal'        => [ 'title' => 'Винная среда', 'main' => 'Каждую среду', 'sub' => 'скидка 10% на вино из открытых бутылок' ],
        ],
    ],
    'beer'       => [
        'headline' => '',
        'eyebrow'  => 'cold & crisp',
        'pill'     => 'Ring for a beer', // was "Iconic Cobb Salad" — a placeholder on the beer photo
        'ru'       => [
            'label'       => 'Пиво',
            'cta_label'   => 'Пиво',
            'headline'    => 'Пиво',
            'eyebrow'     => 'Холодное и освежающее',
            'description' => 'Пенная классика и крафт, в бутылках и на кранах. А звонок на стойке — не для красоты. Хочется пенного? Вы знаете, что делать.',
            'caption'     => 'Звонок на стойке', // draft
            'pill'        => 'Звонок на стойке', // draft
        ],
    ],
    'spirits'    => [
        'headline' => '',
        'eyebrow'  => 'neat or on the rocks',
        'pill'     => 'Jim Beam White Label',
        'ru'       => [
            'label'       => 'Крепкое',
            'cta_label'   => 'Крепкое',
            'headline'    => 'Напитки покрепче',
            'eyebrow'     => 'В чистом виде или со льдом',
            'description' => 'Виски, текила, джин и другие серьёзные знакомые. Любимый — вы узнаете. С остальными познакомит бармен.',
            'caption'     => 'Полка с бурбоном', // draft
            'pill'        => 'Jim Beam White Label',
        ],
    ],
    'no-buzz'    => [
        'headline' => '',
        'eyebrow'  => 'zero proof, full flavour',
        'pill'     => 'Berry smoothie',
        'ru'       => [
            'label'       => 'Без алкоголя',
            'cta_label'   => 'Без алкоголя',
            'headline'    => 'Без алкоголя',
            'eyebrow'     => 'Вкус и кураж на трезвую',
            'description' => 'Лимонады, смузи, молочные шейки и коктейли без алкоголя. Выбирайте любимое — градус здесь не главное.',
            'caption'     => 'Ягодный смузи',
            'pill'        => 'Ягодный смузи',
        ],
    ],
    'tea-coffee' => [
        'headline' => '',
        'eyebrow'  => 'brewed with love',
        'pill'     => 'Cappuccino',
        'deal'     => [ 'title' => 'Lunch Offer!', 'main' => 'Tea, Coffee, Juice & more', 'sub' => '50% off with any hot dish!' ],
        'ru'       => [
            'label'       => 'Чай и кофе',
            'cta_label'   => 'Чай и кофе',
            'headline'    => 'Чай и кофе',
            'eyebrow'     => 'Для разговоров по душам',
            'description' => 'Первый кофеёк с утра, чашка после обеда или чайник на долгий разговор. Эспрессо, капучино и авторские чаи — повод немного задержаться.',
            'caption'     => 'Капучино от Перцев', // draft
            'pill'        => 'Капучино',
            'deal'        => [ 'title' => 'Напитки к обеду', 'main' => 'Скидка 50% на напитки', 'sub' => 'при заказе горячего' ],
        ],
    ],
];
