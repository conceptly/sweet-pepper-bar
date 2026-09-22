<?php
/**
 * Location headline — one for About, Menu and Visit, as typed before it moved into
 * Bar Settings. The fallback sweet_pepper_location_headline() renders until the fields
 * are saved, and the source tools/page-seed.php reads.
 *
 * Always two lines, the same break at every width. Wording: about-page-copy.md →
 * Location ("very" and "best city" are the author's, 16 Sep 2026); the Russian line
 * is the author's direction, not a translation.
 *
 * @package Sweet_Pepper
 */

return [
    'headline'   => 'IN THE VERY HEART',
    'headline_2' => 'OF THE BEST CITY',
    'ru'         => [
        'headline'   => 'В САМОМ СЕРДЦЕ',
        'headline_2' => 'ЛЮБИМОГО ГОРОДА',
    ],
];
