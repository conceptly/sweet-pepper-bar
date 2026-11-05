<?php
/**
 * About data: Careers — the copy as typed before the page moved into WordPress.
 *
 * Two jobs: the fallback sweet_pepper_about_careers() renders until the About page's
 * «Вакансии» tab is saved, and the source tools/page-seed.php reads.
 *
 *   ru — the Russian twins, from about-page-copy-ru-draft.md → 8. Работа, as the default
 *        copy (author, 21 Sep 2026); still a draft — the final wording is edited in admin.
 *        ХОТИТЕ В СЕМЬЮ? is one line, so `headline_2` is empty on purpose. The schedules
 *        are not in the draft (it leaves them "to confirm") — placeholders, like the roles.
 *   department — 'service' | 'kitchen' | 'bar' (inc/about-data.php → sweet_pepper_about_departments())
 *   url — the role on hh.ru; a card without one prints no link
 *
 * The three positions are placeholder content (about-page-copy.md → Careers).
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'     => 'WORK AT SWEET PEPPER',
    'headline'    => 'WANT TO JOIN',
    'headline_2'  => 'THE FAMILY?',
    'description' => "A small team, familiar faces and room to learn. Take a look at the roles below — or get in touch about the work you'd like to do.",
    'cta_title'   => 'No opening with your name on it?',
    'cta_text'    => "Send a little about yourself and the work you'd like to do.",
    'empty_title' => 'NO OPEN ROLES JUST NOW',
    'empty_text'  => "Interested in a future role? Send your CV and a little about the work you'd like to do.",
    'ru'          => [
        'eyebrow'     => 'РАБОТА В SWEET PEPPER',
        'headline'    => 'ХОТИТЕ В СЕМЬЮ?',
        'headline_2'  => '',
        'description' => 'Здесь работают, учатся друг у друга и быстро становятся своими. Посмотрите открытые вакансии ниже — или просто напишите нам, чем хотели бы заниматься в баре.',
        'cta_title'   => 'Не нашли свою вакансию?', // the draft types it in capitals; the line is Golos 600, sentence case like its English twin
        'cta_text'    => 'Расскажите немного о себе и о том, чем хотели бы заниматься.',
        'empty_title' => 'ПОКА БЕЗ ВАКАНСИЙ',
        'empty_text'  => 'Хотели бы работать здесь в будущем? Отправьте резюме и пару слов о том, какая работа вам интересна.',
    ],
    'positions'   => [
        [
            'department'  => 'service',
            'title'       => 'Floor manager',
            'meta'        => 'Full-time · 2 days on, 2 days off',
            'description' => 'Keep service running smoothly, support the floor team and make every welcome count.',
            'url'         => '',
            'ru'          => [ 'title' => 'Менеджер зала', 'meta' => 'Полный день · график 2/2', 'description' => 'Помогать команде в зале, следить за ходом смены и встречать гостей так, чтобы хотелось вернуться.' ],
        ],
        [
            'department'  => 'service',
            'title'       => 'Cleaner',
            'meta'        => 'Full-time',
            'description' => 'Help keep the rooms ready for the next guests, from the first table to the last detail.',
            'url'         => '',
            'ru'          => [ 'title' => 'Сотрудник по уборке', 'meta' => 'Полный день', 'description' => 'Поддерживать чистоту и порядок, чтобы к приходу гостей всё было готово.' ],
        ],
        [
            'department'  => 'kitchen',
            'title'       => 'Sous-chef',
            'meta'        => 'Full-time',
            'description' => 'Support the chef, keep the kitchen organised and help every plate leave as it should.',
            'url'         => '',
            'ru'          => [ 'title' => 'Су-шеф', 'meta' => 'Полный день', 'description' => 'Помогать шефу, организовывать работу кухни и следить за каждой тарелкой на выдаче.' ],
        ],
    ],
];
