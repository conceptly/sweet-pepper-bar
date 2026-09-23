<?php
/**
 * About data: The Pepper Story — as typed before the page moved into WordPress. Fallback
 * for sweet_pepper_about_story() and the seed source. The milestone positions, the heat
 * line and the ledger's motion are the theme's; the third milestone's year is the current
 * year, printed, never typed.
 *
 *   ru — from about-page-copy-ru-draft.md → 5. История. No Russian eyebrow in the draft;
 *        the founder's name waits for its confirmed Russian spelling (the draft: not a
 *        transliteration) — empty, borrows the English.
 *
 * 🔶 Counter numbers: the template carried 128 400 / 41 200 / 96 700; the brief says confirm
 * the kitchen-approved set with Iurii before launch.
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'          => 'SINCE 2014',
    'headline'         => 'THE PEPPER',
    'headline_2'       => 'STORY',
    'p1'               => 'Before Sweet Pepper, there was Tabasco Bar on Kirova Street. The next chapter kept the edge and added warmth, with a kitchen given as much care as the bar.',
    'p2'               => 'The name says it: still pepper, a little sweeter. Breakfast, lunch and cocktails became parts of the same place, with room for an ordinary Tuesday as well as a big night out.',
    'p3'               => 'The regulars helped shape what followed. Pumpkin soup, berry cheesecake and berry korzhik started as seasonal specials. Guests kept asking for them, so they stayed. Some of the best things on the menu are there because someone didn\'t want to say goodbye to them.',
    'founder_photo'    => 'team/iura/iura-1.jpg',
    'founder_alt'      => 'Iurii Primyshev behind the bar at Sweet Pepper',
    'founder_quote'    => 'The main thing is to always know your limit. Otherwise you might drink less.',
    'founder_name'     => 'Iurii Primyshev.',
    'founder_title'    => 'Founder, still behind the bar.',
    'counters_label'   => 'TWELVE YEARS,',
    'counters_label_2' => 'COUNTED IN ORDERS',
    'ru'               => [
        'eyebrow'          => '',
        'headline'         => 'ИСТОРИЯ SWEET PEPPER',
        'headline_2'       => '',
        'p1'               => 'До Sweet Pepper на Кирова был Tabasco Bar. Название изменилось, характер остался. Стало чуть слаще, а кухня получила столько же внимания, сколько и бар.',
        'p2'               => 'Название говорит само за себя: всё ещё с перцем, но чуть слаще. Завтраки, обеды и коктейли сошлись в одном месте — для обычного вторника и для вечера, который хочется запомнить.',
        'p3'               => 'Продолжение во многом написали постоянные гости. Тыквенный суп, ягодный чизкейк и ягодный коржик появились в сезонном меню. Гости просили их снова и снова — и они остались. Иногда блюдо становится постоянным просто потому, что с ним не хотят прощаться.',
        'founder_alt'      => '',
        'founder_quote'    => 'Главное — всегда знать свою меру. Иначе можно выпить меньше.',
        'founder_name'     => '',
        'founder_title'    => 'Основатель, 18 лет за баром.',
        'counters_label'   => 'ДВЕНАДЦАТЬ ЛЕТ',
        'counters_label_2' => 'В ЗАКАЗАХ',
    ],
    'milestones'       => [
        [ 'year' => 2009, 'name' => 'TABASCO BAR',  'wit' => 'Where the heat started',            'ru' => [ 'name' => 'TABASCO BAR',  'wit' => 'Здесь всё и зажглось' ] ],
        [ 'year' => 2014, 'name' => 'SWEET PEPPER', 'wit' => 'Kept the heat, made it delicious', 'ru' => [ 'name' => 'SWEET PEPPER', 'wit' => 'С тем же перцем. Ещё вкуснее' ] ],
        [ 'year' => 0,    'name' => 'STILL HERE',   'wit' => 'Same table, probably yours',        'ru' => [ 'name' => 'ВСЁ ТАМ ЖЕ',   'wit' => 'За знакомым столиком. Может, за вашим' ] ],
    ],
    'counters'         => [
        [ 'number' => 128400, 'label' => 'cappuccinos served',          'ru' => [ 'label' => 'чашек капучино' ] ],
        [ 'number' => 41200,  'label' => 'pumpkin soups served',        'ru' => [ 'label' => 'порций тыквенного супа' ] ],
        [ 'number' => 96700,  'label' => 'salted caramel shots poured', 'ru' => [ 'label' => 'стопок «Солёной карамели»' ] ],
    ],
];
