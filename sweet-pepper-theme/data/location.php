<?php
/**
 * Location headline — one for About, Menu and Visit, as typed before it moved into
 * Bar Settings. The fallback sweet_pepper_location_headline() renders until the fields
 * are saved, and the source tools/page-seed.php reads.
 *
 * Always two lines, the same break at every width. Wording: IN THE HEART / OF THE CITY —
 * the author dropped "very" and "best" (23 Sep 2026; chosen as IN THE VERY HEART OF THE BEST
 * CITY on 16 Sep) so the headline holds its two lines; the Russian line is the author's
 * direction, not a translation.
 *
 * @package Sweet_Pepper
 */

return [
    'headline'   => 'IN THE HEART',
    'headline_2' => 'OF THE CITY',
    'ru'         => [
        'headline'   => 'В САМОМ СЕРДЦЕ',
        'headline_2' => 'ЛЮБИМОГО ГОРОДА',
    ],
];
