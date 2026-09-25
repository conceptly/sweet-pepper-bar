<?php
/**
 * Vacancy seed — the three placeholder roles of data/about/careers.php (about-page-copy.md →
 * Careers), each with the texts a posting's page prints, so the admin form and the page can
 * be looked at with something on them. PLACEHOLDER content in both languages, mine (26 Sep
 * 2026): the team replaces it with real openings. Read by tools/page-seed.php vacancies;
 * the theme never falls back to this file — no records, no roles.
 *
 *   department — 'service' | 'kitchen' | 'bar'
 *   show       — '1' | '2' | '4' weeks
 *   lists      — one item per line, as typed into the textarea
 *
 * @package Sweet_Pepper
 */

return [
    [
        'title'        => 'Floor manager',
        'department'   => 'service',
        'show'         => '2',
        'schedule'     => 'Full-time · 2 days on, 2 days off',
        'pay'          => '',
        'card'         => 'Keep service running smoothly, support the floor team and make every welcome count.',
        'lead'         => "The floor is where the bar happens. You keep the shift steady, the team supported and every guest met the way we would meet a friend.",
        'duties'       => "Run the shift: seating, pace, the handover to the kitchen and the bar\nLook after the floor team — schedules, training, the small things that keep a shift calm\nMeet guests, solve what needs solving, remember the regulars",
        'requirements' => "Two years on a floor, a year of running one\nA calm head at full house and a warm one at 4 pm\nRussian fluent; English enough to seat a traveller",
        'offer'        => "2 on, 2 off; the schedule set a month ahead\nStaff meals, a share of the tips\nA small team that stays — most of us have been here for years",
        'ru'           => [
            'title'        => 'Менеджер зала',
            'schedule'     => 'Полный день · график 2/2',
            'card'         => 'Помогать команде в зале, следить за ходом смены и встречать гостей так, чтобы хотелось вернуться.',
            'lead'         => 'Зал — это и есть бар. Вы держите смену ровной, команду — в форме, а гостей встречаете так, как встретили бы друзей.',
            'duties'       => "Вести смену: посадка, темп, связка с кухней и баром\nЗаботиться о команде зала — графики, обучение, мелочи, от которых смена спокойная\nВстречать гостей, решать, что нужно решить, помнить постоянных",
            'requirements' => "Два года в зале, год — во главе смены\nСпокойная голова при полной посадке и тёплая — в четыре дня\nРусский свободно; английский — чтобы усадить путешественника",
            'offer'        => "2/2, график известен за месяц\nПитание, доля чаевых\nМаленькая команда, которая остаётся — большинство из нас здесь годами",
        ],
    ],
    [
        'title'        => 'Cleaner',
        'department'   => 'service',
        'show'         => '2',
        'schedule'     => 'Full-time',
        'pay'          => '',
        'card'         => 'Help keep the rooms ready for the next guests, from the first table to the last detail.',
        'lead'         => 'Two rooms, a bar and a kitchen that never quite stop. You are the reason they look ready every time the door opens.',
        'duties'       => "The rooms before opening and between the sittings\nThe bar and kitchen surfaces to the chef's standard\nSupplies noticed before they run out",
        'requirements' => "Care for the details and a steady pace\nMornings work for you",
        'offer'        => "Full-time, a fixed schedule\nStaff meals\nA team that says thank you",
        'ru'           => [
            'title'        => 'Сотрудник по уборке',
            'schedule'     => 'Полный день',
            'card'         => 'Поддерживать чистоту и порядок, чтобы к приходу гостей всё было готово.',
            'lead'         => 'Два зала, бар и кухня, которые почти не останавливаются. Благодаря вам они выглядят готовыми каждый раз, когда открывается дверь.',
            'duties'       => "Залы перед открытием и между посадками\nПоверхности бара и кухни — по стандарту шефа\nЗамечать, что заканчивается, до того как закончилось",
            'requirements' => "Внимание к мелочам и ровный темп\nУтро — ваше время",
            'offer'        => "Полный день, постоянный график\nПитание\nКоманда, которая говорит спасибо",
        ],
    ],
    [
        'title'        => 'Sous-chef',
        'department'   => 'kitchen',
        'show'         => '4',
        'schedule'     => 'Full-time',
        'pay'          => '',
        'card'         => 'Support the chef, keep the kitchen organised and help every plate leave as it should.',
        'lead'         => "An all-day kitchen with a short, changing menu. You are the chef's second pair of hands and the first person the line looks to when the chef is out.",
        'duties'       => "Run the line with the chef and without\nPrep lists, orders, the walk-in in order\nTeach the cooks the dishes as they change with the season",
        'requirements' => "Three years in a kitchen, a year as a sous or senior cook\nA hand for both a breakfast rush and a Friday night\nCare for the product — we cook from what the market has",
        'offer'        => "Full-time; the schedule agreed with the chef\nStaff meals, the kitchen's own tips\nA say in the menu",
        'ru'           => [
            'title'        => 'Су-шеф',
            'schedule'     => 'Полный день',
            'card'         => 'Помогать шефу, организовывать работу кухни и следить за каждой тарелкой на выдаче.',
            'lead'         => 'Кухня на весь день с коротким меню, которое меняется. Вы — вторая пара рук шефа и первый, к кому обращается линия, когда шефа нет.',
            'duties'       => "Вести линию с шефом и без него\nЗаготовки, заказы, порядок в холодильной\nУчить поваров новым блюдам, когда меню меняется с сезоном",
            'requirements' => "Три года на кухне, год су-шефом или старшим поваром\nОдинаково уверенно — утренний час и пятничный вечер\nБережное отношение к продукту: готовим из того, что есть на рынке",
            'offer'        => "Полный день; график — по договорённости с шефом\nПитание, чаевые кухни\nГолос в меню",
        ],
    ],
];
