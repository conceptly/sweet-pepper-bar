<?php
/**
 * Menu Section: Soups
 *
 * @package Sweet_Pepper
 */
?>

<?php $sec = sweet_pepper_menu_section( 'soups' ); // this section's words, in the request's language (inc/menu-sections.php) ?>
<section id="soups" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( $sec['band_image'] ); ?>"<?php echo sweet_pepper_menu_band_style( $sec ); // the page's photo + slider (inc/menu-sections.php) ?>
                 alt="<?php echo esc_attr( $sec['alt'] ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( $sec['pill'] ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( $sec['eyebrow'] ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'soups' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout: rows from the Soups record in admin (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'soups' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: SPOON THERAPY -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/spoonTherapy.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/spoonTherapy.svg',
            'alt'       => 'SPOON THERAPY',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
