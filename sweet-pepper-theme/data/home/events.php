<?php
/**
 * Home data: What's on — the social entrance's header, the five cards and the «More on VK»
 * tile as typed before the page moved into WordPress. Fallback for sweet_pepper_home_events()
 * and the seed source.
 *
 * The typed cards are the ENGLISH page's placeholders (website-brief.md → News/social feed →
 * Current decision: `/` imports the VK wall, inc/vk-feed.php; `/en/` keeps hand-made cards, the
 * team pastes real posts in admin). The first card's date is today,
 * so the "Today!" state shows in the fallback; the SEEDED cards carry no date and name VK as
 * the source, as their links do (home-copy-ru-review.md → 6: no invented dates, one platform
 * per card) — the team fills in real posts.
 *
 *   ru — home-copy-ru-draft.md → 6. Что нового; the card captions are mine (`// draft`).
 *
 * @package Sweet_Pepper
 */

return [
    'eyebrow'     => 'MAKE YOUR NEXT PLAN',
    'headline'    => "WHAT'S ON",
    'headline_2'  => 'AT PEPPER',
    'description' => 'Your next night out starts here. Check VK for news, parties and specials, or take a look on Instagram.',
    'ru'          => [
        'eyebrow'     => 'ПОВОД ЗАГЛЯНУТЬ',
        'headline'    => 'ЧТО НОВОГО',
        'headline_2'  => 'В SWEET PEPPER',
        'description' => 'Что нового в меню, какие акции действуют и когда следующая вечеринка? Всё, ради чего стоит заглянуть в Перец, — в соцсетях. Выбирайте, где удобнее следить за новостями.',
    ],
    'cards'       => [
        [ 'cover' => 'bar/cocktails/moscow-mull-2.jpg', 'alt' => 'Live DJ set at Sweet Pepper', 'title' => 'Live DJ Set: Friday Night', 'date' => 'today', 'category' => 'event',     'source' => 'instagram', 'pinned' => true,  'url' => 'https://vk.com/sweet_pepper_bar', 'ru' => [ 'title' => 'DJ-сет: вечер пятницы' ] ], // draft
        [ 'cover' => 'bar/cocktails/shot-drinks.jpg',   'alt' => 'Shot drinks promo',          'title' => 'Live DJ Set: Friday Night', 'date' => '12 Oct', 'category' => 'promo',     'source' => 'instagram', 'pinned' => false, 'url' => 'https://vk.com/sweet_pepper_bar', 'ru' => [ 'title' => 'DJ-сет: вечер пятницы' ] ],
        [ 'cover' => 'bar/cocktails/mulled-2.jpg',      'alt' => 'Community night at Sweet Pepper', 'title' => 'Live DJ Set: Friday Night', 'date' => '12 Oct', 'category' => 'community', 'source' => 'instagram', 'pinned' => false, 'url' => 'https://vk.com/sweet_pepper_bar', 'ru' => [ 'title' => 'DJ-сет: вечер пятницы' ] ],
        [ 'cover' => 'bar/cocktails/students-2.jpg',    'alt' => 'Community event',            'title' => 'Live DJ Set: Friday Night', 'date' => '12 Oct', 'category' => 'community', 'source' => 'instagram', 'pinned' => false, 'url' => 'https://vk.com/sweet_pepper_bar', 'ru' => [ 'title' => 'DJ-сет: вечер пятницы' ] ],
        [ 'cover' => 'bar/cocktails/shots-2.jpg',       'alt' => 'Community shots night',      'title' => 'Live DJ Set: Friday Night', 'date' => '12 Oct', 'category' => 'community', 'source' => 'instagram', 'pinned' => false, 'url' => 'https://vk.com/sweet_pepper_bar', 'ru' => [ 'title' => 'DJ-сет: вечер пятницы' ] ],
    ],
    'more'        => [
        'photo' => 'bar/cocktails/shots-3.jpg',
        'alt'   => 'See all events at Sweet Pepper',
        'label' => 'More on Instagram →', // the English page's feed side (author, 25 Sep 2026); the URL is Bar Settings'
        'ru'    => [ 'label' => 'Ещё во ВКонтакте →', 'alt' => 'Все события Sweet Pepper' ],
    ],
];
