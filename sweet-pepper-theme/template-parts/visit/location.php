<?php
/**
 * Visit Location Section
 *
 * Light section (Parchment bg). Composes:
 *  - Section title: eyebrow + two-line H1 + "Good to know" deal chip
 *  - Full-width map (geo-detected: Yandex for RU, Google otherwise)
 *  - Address bar with copy/directions chips
 *
 * Phones (mapDirections-mobile 1472:75760): title → Good-to-know slip → map (the same chip
 * bar, brand names only) → the landmark badges in a 2 × 3 grid (CSS order).
 * Open items live in visit-page-copy.md → Getting here — mobile.
 *
 * Words come as args from sweet_pepper_visit_location() (inc/visit-data.php) — the Visit
 * page's «Как добраться» tab; the headline is shared (inc/location.php). The route maps
 * (`mid`) and the map-app links are structure and stay here.
 *
 * @param array $args eyebrow · note_title · note_main · note_sub · landmarks (slot → name ·
 *                    hint · distance · aria).
 *
 * @package Sweet_Pepper
 */

$landmarks = $args['landmarks'];
?>
<section class="visit-location" id="visit-map">
    <?php get_template_part( 'template-parts/visit/connector', null, [ 'word' => 'yourRouteToPepper', 'position' => 'head', 'alt' => 'Your route to Pepper' ] ); ?>
    <div class="container">

        <?php // ── Section header with deal chip ── ?>
        <div class="visit-location__header">
            <div class="visit-location__title-block">
                <span class="visit-location__eyebrow molot-text"><?php echo esc_html( $args['eyebrow'] ); ?></span>
                <h2 class="visit-location__headline molot-text">
                    <?php [ $line_1, $line_2 ] = sweet_pepper_location_headline(); // one headline for About, Menu and Visit (inc/location.php) ?>
                    <span class="visit-location__headline-line1"><?php echo esc_html( $line_1 ); ?></span>
                    <span class="visit-location__headline-line2"><?php echo esc_html( $line_2 ); ?></span>
                </h2>
            </div>
            <div class="menu-section__deal">
                <div class="menu-section__deal-inner">
                    <div class="menu-section__deal-card">
                        <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'parchment' ] ); ?>
                        <div class="menu-section__deal-title molot-text"><?php echo esc_html( $args['note_title'] ); ?></div>
                        <div class="menu-section__deal-divider"></div>
                        <div class="menu-section__deal-desc">
                            <span class="menu-section__deal-desc-main"><?php echo esc_html( $args['note_main'] ); ?></span>
                            <span class="menu-section__deal-desc-sub"><?php echo esc_html( $args['note_sub'] ); ?></span>
                        </div>
                    </div>
                </div>
                <div class="menu-section__deal-shadow"></div>
            </div>
        </div>

        <?php // ── Map + directions (mapDirections 2385:76419 desktop / mapDirections-mobile 1472:75760) ──
              // Desktop: a 360 column of landmark badges beside a 736 × 400 map; phones: the map,
              // then the chips, then the badges in a 2 × 3 grid (CSS order). Each badge with a
              // `mid` is a route switch: tapping it swaps the embed for a Google My Map whose
              // walking-route layer is on by default (location-map.js → initVisitMapRoutes). A My
              // Maps embed is a cross-origin iframe, so its layer checkboxes cannot be driven from
              // the page — one map per route is the only handle. The door is the base map. Badges
              // without a mid render as plain items until their maps exist. Google only: the
              // Yandex widget (RU guests) has no My Maps equivalent — visit-page-copy.md. ?>
        <div class="visit-location__map-container">

            <ul class="visit-location__badges" data-visit-routes>
                <?php
                // Names, hints, distances: the «Как добраться» tab, one slot per landmark
                // (data/visit/location.php); only the route maps are typed here.
                // Measured in the 360 badge column (Sep 2026), where the name cell is 172px:
                // "Bogoyavlenskaya Square" needs 195 and genuinely does not fit, so its "sq."
                // is a necessity. "Sovetskaya Square" needs only 148 and fits with room — its
                // "sq." is the author's consistency call, not a constraint (Sep 2026). If both
                // should read in full, a 384px badge column clears the 195 and the abbreviation
                // can go; that trades the Figma 360 for correct copy.
                $maps = [
                    'door'    => '1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY',
                    'tower'   => '10nBfo6r5KxVQxL0r8j3u5IfewvWk018',
                    'square'  => '1GCDw6ITCA26G1nj1Ub7xouCDKuO4RFE',
                    'strelka' => '1zdP5MzrWfNpHRWaNHh6Q1PGDNI9mx20',
                    'kremlin' => '1u85NgL4hQm7nABY9OXsCI3fJCJddPEA',
                    // Bus stop stands in for parking for now (parking has several options to embed — open).
                    // Its 250 m · 4 min is COMPUTED, not measured: the stop's coordinates (57.624665,
                    // 39.886781, from the author's Google link) are 203 m from the door in a straight
                    // line, ×1.25 for the street grid, at the set's own ~4.5 km/h. Read the real figure
                    // off the badge's own My Map route layer and replace it.
                    'stop'    => '1oKv3Vz2bIR_nG6Dk3JIje4AyeN17aQw',
                ];
                foreach ( $landmarks as $slot => $b ) :
                    $b['mid']  = $maps[ $slot ] ?? '';
                    $b['door'] = 'door' === $slot;
                    $is_door = ! empty( $b['door'] );
                    $classes = 'visit-location__badge' . ( $is_door ? ' visit-location__badge--door is-active' : '' ) . ( $b['mid'] ? '' : ' visit-location__badge--static' );
                    $inner   = '<span class="visit-location__badge-icon" aria-hidden="true">' . sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ) . '</span>'
                             . '<span class="visit-location__badge-text">'
                             .   '<span class="visit-location__badge-name">' . esc_html( $b['name'] ) . '</span>'
                             .   ( $b['hint'] ? '<span class="visit-location__badge-hint">' . esc_html( $b['hint'] ) . '</span>' : '' )
                             . '</span>'
                             . ( $b['distance'] ? '<span class="visit-location__badge-distance">' . esc_html( $b['distance'] ) . '</span>' : '' );
                ?>
                <li class="visit-location__badge-item">
                    <?php if ( $b['mid'] ) : ?>
                    <button type="button" class="<?php echo esc_attr( $classes ); ?>" data-map-mid="<?php echo esc_attr( $b['mid'] ); ?>" aria-pressed="<?php echo $is_door ? 'true' : 'false'; ?>" aria-label="<?php echo esc_attr( $b['aria'] ); ?>">
                        <?php echo $inner; ?>
                    </button>
                    <?php else : ?>
                    <span class="<?php echo esc_attr( $classes ); ?>"><?php echo $inner; ?></span>
                    <?php endif; ?>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="visit-location__map-column">
                <div class="visit-location__map">
                    <div class="visit-location__map-embed location__map">
                        <?php // Hydrated by location-map.js (geo-detection) ?>
                    </div>
                    <?php // Chip bar on the map's foot (map variant "labels" 2391:76528), in the chip
                          // component's own style on Paper. No address line — the badges carry the
                          // address and the hints. Two map apps + Copy address: the apps follow the page
                          // language, as the hero CTA does (Instagram / VK) — RU guests get Yandex and
                          // 2GIS (the country's first and second map services), everyone else Google and
                          // Yandex. Phones show the two apps only, in the 13px chip style — "Copy address"
                          // does not fit the row at 370 and "Copy" misreads beside the route badges. ?>
                    <?php
                    // Names: 'Yandex' + ' Maps' / 'Яндекс' + ' Карты' — the long part drops on phones.
                    $is_ru = ( 'ru' === sweet_pepper_lang() );
                    $map_apps  = $is_ru
                        ? [
                            [ 'Яндекс', ' Карты', 'https://yandex.ru/maps/?rtext=~57.626100%2C39.884500' ],
                            [ '2ГИС',   '',       'https://2gis.ru/yaroslavl/search/sweet%20pepper%20bar/firm/70000001006986694/39.888955%2C57.626074?m=39.888937%2C57.626099%2F17.62' ],
                        ]
                        : [
                            [ 'Google', ' Maps', 'https://maps.google.com/?q=Yaroslavl,+Kirova+10/25' ],
                            [ 'Yandex', ' Maps', 'https://yandex.ru/maps/?rtext=~57.626100%2C39.884500' ],
                        ];
                    ?>
                    <div class="visit-location__map-bar">
                        <?php foreach ( $map_apps as $app ) : ?>
                        <a class="contacts-chip" href="<?php echo esc_url( $app[2] ); ?>" target="_blank" rel="noopener noreferrer">
                            <span class="chip-label"><?php echo esc_html( $app[0] ); ?><?php if ( $app[1] ) : ?><span class="visit-location__chip-long"><?php echo esc_html( $app[1] ); ?></span><?php endif; ?></span>
                            <span class="chip-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                        </a>
                        <?php endforeach; ?>
                        <button class="contacts-chip js-copy" data-copy-text="Ярославль, ул. Кирова, 10/25" data-copied-label="<?php esc_attr_e( 'Address copied', 'sweet-pepper' ); ?>" type="button" aria-label="<?php esc_attr_e( 'Copy address', 'sweet-pepper' ); ?>">
                            <?php // 'Copy' + ' address' — the long part drops on phones; Russian has no long part (Скопировать). ?>
                            <span class="chip-label"><?php esc_html_e( 'Copy', 'sweet-pepper' ); ?><?php if ( ! $is_ru ) : ?><span class="visit-location__chip-long"> address</span><?php endif; ?></span>
                            <span class="chip-icon chip-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                            <span class="chip-icon chip-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php get_template_part( 'template-parts/visit/connector', null, [ 'word' => 'dropALittleNote', 'position' => 'foot', 'alt' => 'Drop a little note' ] ); ?>
</section>
