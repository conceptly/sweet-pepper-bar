<?php
/**
 * Home data: What's on — the social entrance's header, the five cards and the «More on VK»
 * tile as typed before the page moved into WordPress. Fallback for sweet_pepper_home_events()
 * and the seed source.
 *
 * The typed cards are the ENGLISH page's (website-brief.md → News/social feed → Current
 * decision: `/` imports the VK wall, inc/vk-feed.php; `/en/` keeps hand-made cards, edited in
 * admin). Real Instagram posts since 28 Sep 2026, each with its own date and link; the database
 * copy came by tools/field-updates/2026-09-28-home-events-en-instagram.json.
 *
 *   ru — home-copy-ru-draft.md → 6. Что нового (the header and the tile; the RU cards are VK's).
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
    // The bar's Instagram posts, picked from eight the author supplied (28 Sep 2026; the three
    // spares, the titles and the tags: home-copy-en.md → 6. Social entrance). Photos in
    // assets/images/social-en/; the date is the post's. English only — the RU page is VK's.
    'cards'       => [
        [ 'cover' => 'social-en/artyom.jpg',                  'alt' => "Artyom in a black zip-up, a Maker's Mark bottle in a knitted jumper under his arm", 'title' => 'Stay for Artyom',       'date' => '2026-09-26', 'category' => 'community', 'source' => 'instagram', 'pinned' => true,  'url' => 'https://www.instagram.com/barsweetpepper/p/Ddv8UagilvD/' ],
        [ 'cover' => 'social-en/birthday-anya.jpg',           'alt' => 'Anya, laughing, hugs a bottle of Jägermeister under the Sweet Pepper sign',            'title' => "Anya's Birthday!",  'date' => '2026-08-02', 'category' => 'community', 'source' => 'instagram', 'pinned' => false, 'url' => 'https://www.instagram.com/barsweetpepper/p/DbhlIriqPjY/' ],
        [ 'cover' => 'social-en/bucephalus.jpg',              'alt' => 'Katya at the bar with the Bucephalus cocktail and a bottle of Pogues whiskey',         'title' => 'Taming Bucephalus',     'date' => '2026-07-31', 'category' => 'promo',     'source' => 'instagram', 'pinned' => false, 'url' => 'https://www.instagram.com/barsweetpepper/p/Dbc4o3JCt3N/' ],
        [ 'cover' => 'social-en/magnolia.jpg',                'alt' => 'The Magnolia cocktail beside a bottle of Pogues cinnamon liqueur, a peach and magnolia petals', 'title' => 'Magnolia in Bloom', 'date' => '2026-07-24', 'category' => 'promo', 'source' => 'instagram', 'pinned' => false, 'url' => 'https://www.instagram.com/barsweetpepper/p/DbLFWiCCpE1/' ],
        [ 'cover' => 'social-en/wedding-anton-alexandra.jpg', 'alt' => 'Anton and Alexandra show their wedding rings outside the bar',                         'title' => 'It Started Here', 'date' => '2026-07-04', 'category' => 'community', 'source' => 'instagram', 'pinned' => false, 'url' => 'https://www.instagram.com/barsweetpepper/p/DaX520xCnyQ/' ],
    ],
    'more'        => [
        'photo' => 'bar/cocktails/shots-3.jpg',
        'alt'   => 'See all events at Sweet Pepper',
        'label' => 'More on Instagram →', // the English page's feed side (author, 25 Sep 2026); the URL is Bar Settings'
        'ru'    => [ 'label' => 'Ещё во ВКонтакте →', 'alt' => 'Все события Sweet Pepper' ],
    ],
];
