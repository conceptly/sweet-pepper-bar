<?php
/**
 * Visit data: the contact card's words. The phone, the accounts and the email address are
 * facts, not copy — they stay in the template until they are confirmed for publishing
 * (visit-page-copy-ru-draft.md → Карточка контактов). Fallback for
 * sweet_pepper_visit_contacts() and the seed source.
 *
 *   ru — from visit-page-copy-ru-draft.md → Карточка контактов. The booking group's heading is
 *        the author's (24 Sep 2026); the phone / VK / Instagram notes are mine (25 Sep 2026, for
 *        the draft's final pass) — no response time promised (home-copy-ru-review.md §8).
 *
 * @package Sweet_Pepper
 */

return [
    'title'         => 'get in touch',
    'book_heading'  => 'Book or Feedback',
    'phone_note'    => 'can take longer during party hours',
    'vk_note'       => 'fastest reply — usually minutes',
    'ig_note'       => 'DM & latest updates',
    'email_heading' => 'email',
    'email_note'    => 'Feedback, ideas, partnerships.',
    'place_heading' => 'your way here',
    'address'       => 'Kirova 10/25, Yaroslavl',
    'address_note'  => "On Kirova's pedestrian street.",
    'ru'            => [
        'title'         => 'НА СВЯЗИ',
        'book_heading'  => 'СТОЛИКИ И ОТЗЫВЫ',
        'phone_note'    => 'Вечером бывает шумно — можно и написать',
        'vk_note'       => 'Обычно так быстрее всего',
        'ig_note'       => 'Сообщения и свежие новости',
        'email_heading' => 'НАПИСАТЬ ПИСЬМО',
        'email_note'    => 'Отзывы, идеи, сотрудничество.',
        'place_heading' => 'ВАМ СЮДА',
        'address'       => 'Ярославль, ул. Кирова, 10/25',
        'address_note'  => 'На пешеходной улице Кирова.',
    ],
];
