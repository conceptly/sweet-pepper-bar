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
                    <?php // Desktop breaks after "of the" (Chili | Paprika); phones after "heart" (frame
                          // 1490:78527) — the middle span changes side per breakpoint (location.css). ?>
                    <span class="location__title-line1 molot-text"><?php esc_html_e( 'IN THE VERY HEART ', 'sweet-pepper' ); ?></span><span class="location__title-mid molot-text"><?php esc_html_e( 'OF THE ', 'sweet-pepper' ); ?></span><span class="location__title-line2 molot-text"><?php esc_html_e( 'BEST CITY', 'sweet-pepper' ); ?></span>
                </h2>
            </div>

            <p class="location__description"><?php esc_html_e( "Your stop on Kirova Street: 10/25, in Yaroslavl's pedestrian centre. Two rooms with their own character, plus a summer terrace with swing chairs. A place to pause between a walk through the city and whatever comes next.", 'sweet-pepper' ); ?></p>

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
