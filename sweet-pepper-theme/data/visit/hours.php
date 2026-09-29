<?php
/**
 * Visit data: the hours card's words — its two headings and the evergreen social slot. The
 * hours themselves are Bar Settings' (inc/bar-hours.php). Fallback for
 * sweet_pepper_visit_hours() and the seed source.
 *
 *   ru — from visit-page-copy-ru-draft.md → Часы работы / Постоянный блок соцсетей. The link
 *        text: «Афиша ВКонтакте» since 29 Sep 2026 (was the placeholder Friday Cocktail Hour).
 *
 * @package Sweet_Pepper
 */

return [
    'hours_title'  => 'Opening hours',
    'social_title' => "What's on",
    'social_text'  => 'News, parties and specials — on social.',
    'social_link'  => "See what's new",
    'ru'           => [
        'hours_title'  => 'ЧАСЫ РАБОТЫ',
        'social_title' => 'АКЦИИ, НОВОСТИ, ВЕЧЕРИНКИ',
        'social_text'  => 'Что нового, что выгодного и когда следующая вечеринка — в соцсетях.',
        'social_link'  => 'Афиша ВКонтакте', // the Russian page's link always opens VK (author, 29 Sep 2026)
    ],
];
