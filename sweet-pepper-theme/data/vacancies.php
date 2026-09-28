<?php
/**
 * Vacancy seed — the team's three templates (28 Sep 2026): waiter, bartender, cook. One is
 * posted, the other two wait in the archive; the team republishes, changes the pay or the
 * schedule and posts again («На сайте» → a term). Read by tools/page-seed.php vacancies;
 * the theme never falls back to this file — no records, no roles.
 *
 * RU — the bar's own postings (`Job descriptions examples.md`, author, 28 Sep 2026): the
 * newer VK posts (by the author's trainee, with the author) for the waiter and the bartender,
 * the older hh.ru posting for the cook; the words kept, the emojis and the «звони 911-202»
 * lines left out (the contact card on the page does that job). The pay and the schedules are
 * the hh.ru figures, years old on purpose (author: the team updates them before posting).
 * EN — a draft, mine; the author refines it.
 *
 *   department — 'service' | 'kitchen' | 'bar'
 *   show       — 'archive' | '1' | '2' | '4' weeks
 *   lists      — one item per line, as typed into the textarea
 *   photo      — [ asset under assets/images/, RU alt ] — the VK poster, Russian page only
 *   spare      — more posters for the Media Library, not attached (the team can swap)
 *
 * `retired` — the placeholder records of 25 Sep 2026; `page-seed.php vacancies --force`
 * moves them to the trash.
 *
 * @package Sweet_Pepper
 */

return [
    'retired' => [ 'Менеджер зала', 'Сотрудник по уборке', 'Су-шеф' ],
    'roles'   => [
        [
            'title'        => 'Waiter',
            'department'   => 'service',
            'show'         => '4',
            'schedule'     => '2/2 · from 8:30 am or 6 pm',
            'pay'          => '90–120 ₽ an hour + tips + daily bonuses',
            'card'         => 'Not just a waiter — a master of hospitality who makes our cosy gastrobar even warmer.',
            'lead'         => "Sweet Pepper is looking for that one person. Not just a waiter — a true master of hospitality who helps our cosy gastrobar on Kirova keep its warm, particular atmosphere. No experience? No problem: we'll teach you everything and make you an expert.",
            'duties'       => '',
            'requirements' => "You win a guest over from the very first hello\nYou're genuinely hospitable and believe the atmosphere matters as much as the menu\nYou know that real care and attention are what a perfect evening is built on\nYou want to be part of the friendliest, closest team in town",
            'offer'        => "A place where work feels like a celebration of flavour, conversation and good vibes\nPeople who become a second family and always have your back\nLots of new faces, favourite regulars and loyal guests who keep coming back for the atmosphere\nGood pay (and good tips), training and room to grow\nA flexible schedule: 2 on, 2 off; 8:30 am till 2 am, 6 pm till 2 am and more to choose from",
            'ru'           => [
                'title'        => 'Официант',
                'schedule'     => '2/2 · с 8:30 или с 18:00',
                'pay'          => 'от 90 до 120 ₽ в час + чаевые + ежедневные премии',
                'card'         => 'ПЕРЧИК ищет не просто официанта, а мастера гостеприимства, который сделает наш уютный гастробар ещё теплее.',
                'lead'         => 'ПЕРЧИК ищет того самого человека. А ищет он не просто официанта, а настоящего мастера гостеприимства, который поможет создавать в уютном гастробаре на Кирова особую, тёплую атмосферу. Нет опыта? Не беда — всему обучим, научим и сделаем экспертом своего дела.',
                'requirements' => "Умеет расположить к себе гостя с первой же встречи!\nПо-настоящему гостеприимен и считает, что атмосфера — это не менее важно, чем меню!\nПонимает, что искренняя забота и внимание — это база безупречного вечера для наших гостей!\nХочет стать частью самой дружелюбной и сплочённой команды!",
                'offer'        => "Уникальную атмосферу, где работа — это праздник вкуса, общения и вайбовых эмоций!\nКлассных ребят, которые станут для Вас второй семьёй и всегда поддержат!\nМного знакомств, любимых постояшек и лояльных гостей, которые ценят атмосферу бара и приходят снова и снова!\nОтличную заработную плату (и хорошие чаевые), обучения для получения новых знаний и возможности для карьерного роста!\nГибкий график: 2/2, с 08:30 до 2 ночи, с 6 вечера до 2 ночи и др. на выбор",
            ],
            'photo'        => [ 'vacancies/waiter-poster-sign.jpg', 'Официант смотрит в бинокль у вывески Sweet Pepper, в облачке — «Где ты, наш официант?»' ],
            'spare'        => [
                [ 'vacancies/waiter-poster-cardigan.jpg', 'Официант в бордовом кардигане смотрит в бинокль, надпись — «Где же ты, наш официант?»' ],
            ],
        ],
        [
            'title'        => 'Bartender',
            'department'   => 'bar',
            'show'         => 'archive',
            'schedule'     => '2/2 or 4/2 · from 8 am or 5 pm',
            'pay'          => '120–150 ₽ an hour + bonuses + a share of the floor tips',
            'card'         => 'Looking for a bartender who feels the rhythm of the bar like their own pulse.',
            'lead'         => "We need you. Sweet Pepper is looking for a bartender who feels the rhythm of bar life like their own pulse. If reading this made something flutter in your chest, that's the right kind of nerves — your road leads here.",
            'duties'       => '',
            'requirements' => "Warmth, hospitality and a good mood\nThe wish to learn and to love the craft\nWe'll teach you the rest — what matters is the spark, the drive to grow and the joy of the job",
            'offer'        => "A team that feels like family and will always support, inspire and help\nOur own recipes, the little secrets and years of know-how\nGood money — for inspiration and for the nice things\nDozens of new people and great stories\nShifts 2 on, 2 off or 4 on, 2 off: 8 am to 5 pm or 5 pm to 2 am",
            'ru'           => [
                'title'        => 'Бармен',
                'schedule'     => '2/2 или 4/2 · с 8:00 или с 17:00',
                'pay'          => '120–150 ₽ в час + премии + % чая с зала',
                'card'         => 'ПЕРЧИК ищет бармена, для которого ритм барной жизни — как свой пульс.',
                'lead'         => 'Ты нам нужен! ПЕРЧИК ищет бармена, для которого ритм барной жизни — как свой пульс. Если ты прочитал это и почувствовал небольшое колыхание и трепет в груди — это признак правильного волнения: твой путь лежит к нам.',
                'requirements' => "Радушие, гостеприимство и позитивный настрой!\nЖелание учиться и гореть делом!\nВсему остальному научим, ведь главное — горящие глаза, стремление развиваться и наслаждаться профессией",
                'offer'        => "Команда-семья, где всегда поддержат, вдохновят и помогут!\nДоступ к авторским рецептам, секретным фишкам и базе знаний с многолетним опытом!\nДостойный доход для вдохновения и приятных трат!\nДесятки новых знакомств и классных историй!\nСменный график 2/2 или 4/2: с 8:00 утра до 17:00 или с 17:00 до 2:00 ночи",
            ],
            'photo'        => [ 'vacancies/bartender-poster.jpg', 'Бармен наливает тоник в бокал с красным коктейлем, надпись — «В поисках бармена!»' ],
        ],
        [
            'title'        => 'Cook',
            'department'   => 'kitchen',
            'show'         => 'archive',
            'schedule'     => '2/2 or 5/2 · from 8 am or noon',
            'pay'          => 'from 200 ₽ an hour + bonuses (about +30%)',
            'card'         => 'An all-round cook for European and signature dishes — for people who hold themselves to high standards.',
            'lead'         => 'We are taking on an all-round cook, European and signature cuisine, on a competitive basis. We want people who are ready to keep to our standards of quality and service. Sweet Pepper holds high standards for service, the kitchen and hygiene — we want everyone here to be proud of their work.',
            'duties'       => '',
            'requirements' => "At least a year of experience\nA culinary education\nCare, reliability, the will to learn\nAn understanding of hospitality and your own high standards for your work\nKnowing the hygiene rules, following them and understanding why they matter",
            'offer'        => "Work in the very centre of town (Kirova St.)\nA comfortable atmosphere, a close team and room to grow\nProfessional development: regular staff training, trips to national trade fairs (PIR, Metro Expo)\nOfficial employment and a career path\nA ride home after night shifts, staff meals, staff discounts\nShifts 2 on, 2 off: 8 am to 10 pm or noon to 2 am; 5 on, 2 off by agreement",
            'ru'           => [
                'title'        => 'Повар-универсал',
                'schedule'     => '2/2 или 5/2 · с 8:00 или с 12:00',
                'pay'          => 'от 200 ₽ в час + премии (~+30% к зп)',
                'card'         => 'Возьмём в команду повара-универсала: европейская и авторская кухня.',
                'lead'         => 'Возьмём в команду повара-универсала, на конкурсной основе, европейская и авторская кухня. Нужны достойные люди в нашу команду, которые готовы придерживаться стандартов качества и сервиса. В Sweet Pepper высокие стандарты сервиса, кухни, санитарии, мы стремимся сделать так, чтобы сотрудники гордились своей работой.',
                'requirements' => "Опыт работы от 1 года\nПрофильное образование\nАккуратность, исполнительность, обучаемость\nПонимание задач сферы гостеприимства, собственные высокие стандарты качества работы\nЗнание санитарных норм, умение им следовать, понимание необходимости этого",
                'offer'        => "Работа в центре города (ул. Кирова)\nКомфортная рабочая атмосфера, дружный коллектив, возможность для самореализации\nПрофессиональное развитие: в Sweet Pepper регулярно проводятся тренинги для персонала, поездки на общероссийские выставки (ПИР, Метро Экспо)\nОфициальное трудоустройство, карьерный рост\nРазвозка ночью, питание, скидки сотрудникам\nГрафик 2/2 с 08 утра до 10 вечера / с 12 дня до 2 ночи, либо 5/2 по договорённости",
            ],
        ],
    ],
];
