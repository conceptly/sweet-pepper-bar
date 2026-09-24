<?php
/**
 * Visit data: the status band — the desktop lead line and the bar / kitchen labels for each
 * state of the bar's clock (src/js/visit-hero.js decides the state; these are its words).
 * Fallback for sweet_pepper_visit_status() and the seed source.
 *
 *   ru — from visit-page-copy-ru-draft.md → Вводная строка статуса / Состояния бара и кухни.
 *
 * Keys are the engine's states: lead_<scene>, bar_<state>, kitchen_<state>.
 *
 * @package Sweet_Pepper
 */

return [
    'lead_open'           => 'Good news!',
    'lead_last_orders'    => 'Still time to eat',
    'lead_bar_snacks'     => 'Something to nibble',
    'lead_winding'        => 'Winding down',
    'lead_closed'         => 'See you soon',
    'bar_open'            => "bar's open",
    'bar_wrapping'        => "bar's winding down",
    'bar_closed'          => "bar's closed",
    'kitchen_open'        => "kitchen's on",
    'kitchen_last_orders' => 'kitchen last orders',
    'kitchen_bar_snacks'  => 'bar snacks only',
    'kitchen_closed'      => "kitchen's closed",
    'ru'                  => [
        'lead_open'           => 'ХОРОШИЕ НОВОСТИ!',
        'lead_last_orders'    => 'ЕЩЁ МОЖНО ПОЕСТЬ',
        'lead_bar_snacks'     => 'ЕСТЬ ЧЕМ ЗАКУСИТЬ',
        'lead_winding'        => 'ПОТИХОНЬКУ ЗАКРУГЛЯЕМСЯ',
        'lead_closed'         => 'ДО СКОРОЙ ВСТРЕЧИ',
        'bar_open'            => 'БАР ОТКРЫТ',
        'bar_wrapping'        => 'БАР СКОРО ЗАКРОЕТСЯ',
        'bar_closed'          => 'БАР ЗАКРЫТ',
        'kitchen_open'        => 'КУХНЯ РАБОТАЕТ',
        'kitchen_last_orders' => 'ПОСЛЕДНИЕ ЗАКАЗЫ НА КУХНЮ',
        'kitchen_bar_snacks'  => 'ТОЛЬКО ЗАКУСКИ',
        'kitchen_closed'      => 'КУХНЯ ЗАКРЫТА',
    ],
];
