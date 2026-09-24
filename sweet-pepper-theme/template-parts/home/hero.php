<?php
/**
 * Home — the hero: the daypart tile grid (website-brief.md → Desktop — home hero, Mobile — home hero).
 *
 * The words come as args from sweet_pepper_home_hero() (inc/home-data.php) — the front page's
 * «Первый экран» tab: the eyebrow, and per daypart the tile photo, headline, body and the menu
 * button's text; plus the closed-hours lines. The server renders breakfast; the engine
 * (src/js/daypart-engine.js) swaps in the real daypart before the tiles show, reading the
 * other sets from the JSON printed at the end of the section. The clock, the theme, the
 * tile order, the button's glyph and destination stay the engine's.
 *
 * @param array $args eyebrow · dayparts[ dp => photo, alt, headline, body, button ] · closed[ window => headline, body ]
 *
 * @package Sweet_Pepper
 */

$dayparts = $args['dayparts'];
$first    = $dayparts['breakfast'];
$json     = [ 'dayparts' => [], 'closed' => [] ];
foreach ( $dayparts as $dp => $d ) {
    $json['dayparts'][ $dp ] = [ 'headline' => $d['headline'], 'subhead' => $d['body'], 'btnText' => $d['button'] ];
}
foreach ( $args['closed'] as $window => $c ) {
    $json['closed'][ $window ] = [ 'headline' => $c['headline'], 'subhead' => $c['body'] ];
}
$other_lang = 'ru' === sweet_pepper_lang() ? 'en' : 'ru'; // the nudge proposes the OTHER language
?>

    <!-- Hero Section with Daypart Tile Grid -->
    <section class="home-hero">
        <div class="container hero-container">
            <div class="hero-content">
                <span class="hero-eyebrow molot-text"><?php echo esc_html( $args['eyebrow'] ); ?></span>
                <h1 id="hero-headline" class="hero-headline"><?php echo esc_html( $first['headline'] ); ?></h1>
                <p id="hero-subhead" class="hero-subhead"><?php echo esc_html( $first['body'] ); ?></p>
                
                <div class="daypart-grid">
                    <?php foreach ( $dayparts as $dp => $meta ) : ?>
                        <button class="daypart-tile<?php echo $dp === 'breakfast' ? ' is-active' : ''; ?>" data-daypart="<?php echo esc_attr( $dp ); ?>">
                            <!-- Color stack — 3 rotated sheets (visible only when active).
                                 Slots carry geometry (far / mid / near); colours per daypart come from hero.css -->
                            <div class="tile-color-stack">
                                <div class="tile-bg tile-bg--far"></div>
                                <div class="tile-bg tile-bg--mid"></div>
                                <div class="tile-bg tile-bg--near"></div>
                            </div>
                            <!-- Image -->
                            <div class="tile-img-wrapper">
                                <img src="<?php echo esc_url( $meta['photo'] ); ?>" 
                                     alt="<?php echo esc_attr( $meta['alt'] ); ?>"
                                     class="tile-img" loading="eager" decoding="async">
                                <div class="tile-overlay"></div>
                            </div>
                            <!-- Now badge (dot when inactive, label when active) -->
                            <span class="now-badge"><?php esc_html_e( 'Now', 'sweet-pepper' ); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="hero-ctas">
                    <?php 
                    get_template_part('template-parts/components/button', null, [
                        'label' => __( 'Reserve', 'sweet-pepper' ),
                        'type'  => 'primary',
                        'icon'  => 'bell',
                        'class' => 'js-reserve-trigger'
                    ]); 
                    
                    get_template_part('template-parts/components/button', null, [
                        'label' => $first['button'],
                        'type'  => 'secondary',
                        'icon'  => 'coffee',
                        'id'    => 'hero-menu-btn',
                        // Matches the server-rendered breakfast label; daypart-engine.js
                        // swaps both label and href once it knows the real daypart.
                        'url'   => sweet_pepper_menu_url( 'food', 'breakfast' )
                    ]); 
                    ?>
                </div>
            </div>
            
            <!-- Hero footer: lang-nudge (in flow, right-aligned) + section link word -->
            <div class="hero-footer">
                <div class="lang-nudge-wrapper">
                    <div class="lang-nudge" id="lang-nudge">
                        <?php // The twin language's own words (home-copy-en.md → 8; the draft's RU counterpart), a link to this page in it ?>
                        <a class="lang-nudge__link" href="<?php echo esc_url( sweet_pepper_lang_url( $other_lang ) ); ?>" hreflang="<?php echo esc_attr( $other_lang ); ?>" lang="<?php echo esc_attr( $other_lang ); ?>">
                            <?php if ( 'ru' === $other_lang ) : ?>
                                Удобнее по-русски? <strong>Переключить &rarr;</strong>
                            <?php else : ?>
                                Prefer English? <strong>Switch to English &rarr;</strong>
                            <?php endif; ?>
                        </a>
                        <button id="lang-nudge-close" aria-label="<?php esc_attr_e( 'Close', 'sweet-pepper' ); ?>">&times;</button>
                    </div>
                </div>
                
                <?php 
                get_template_part( 'template-parts/components/section-link-word', null, [
                    'day_img'   => 'assets/sectionLinks/home/dayMode/atSweetPepper-bottom.svg',
                    'night_img' => 'assets/sectionLinks/home/nightMode/atSweetPepperBottom.svg',
                    'alt'       => 'AT SWEET PEPPER',
                    'loading'   => 'eager', // first viewport, and the entrance parks it outside its clip
                ] ); 
                ?>
            </div>
        </div>
        <?php // The other dayparts' words and the closed-hours lines, for the engine ?>
        <script type="application/json" class="home-hero__data"><?php echo wp_json_encode( $json ); ?></script>
    </section>
