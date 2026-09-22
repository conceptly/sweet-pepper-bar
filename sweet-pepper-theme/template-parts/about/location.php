<?php
/**
 * About page — Location section
 *
 * Light section (Paper bg). Reuses the menu-page location pattern
 * (location.css) with shared class names.
 *
 * Two-column layout: copy left (subheading, 2-line headline, description),
 * map right (geo-detected iframe injection by location-map.js).
 *
 * Content comes as args from sweet_pepper_about_location() (inc/about-data.php) — the About page's «Адрес» tab.
 *
 * @param array $args description — the headline is the shared one (inc/location.php)
 *
 * @package Sweet_Pepper
 */
?>

<section id="location" class="menu-location">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'makeYourselfAtHome', 'position' => 'head', 'alt' => 'Make yourself at home' ] ); ?>

    <div class="container location__inner">

        <!-- Left: copy -->
        <div class="location__copy">
            <div class="location__title-block">
                <p class="location__subheading molot-text"><?php esc_html_e( 'YOUR DESTINATION', 'sweet-pepper' ); ?></p>
                <h2 class="location__title">
                    <?php [ $line_1, $line_2 ] = sweet_pepper_location_headline(); // one headline for About, Menu and Visit (inc/location.php) ?>
                    <span class="location__title-line1 molot-text"><?php echo esc_html( $line_1 ); ?></span>
                    <span class="location__title-line2 molot-text"><?php echo esc_html( $line_2 ); ?></span>
                </h2>
            </div>

            <p class="location__description"><?php echo esc_html( $args['description'] ); ?></p>

            <div class="location__cta">
                <?php
                get_template_part( 'template-parts/components/button', null, [
                    'label'          => __( 'Get directions', 'sweet-pepper' ),
                    'url'            => 'https://maps.google.com/?q=Yaroslavl,+Kirova+10/25',
                    'variant'        => 'primary-green',
                    'type'           => 'primary-green',
                    'icon_right_svg' => 'icons/c-arrow-right-outline.svg',
                ] );
                ?>
            </div>
        </div>

        <!-- Right: map (iframe injected by location-map.js based on geo-detection) -->
        <div class="location__map" id="about-map" aria-label="<?php esc_attr_e( 'Sweet Pepper Bar location map', 'sweet-pepper' ); ?>"></div>

    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'NowItsYourTurn', 'position' => 'foot', 'alt' => 'Now it\'s your turn' ] ); ?>
</section>
