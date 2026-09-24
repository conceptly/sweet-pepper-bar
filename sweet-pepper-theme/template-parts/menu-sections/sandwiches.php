<?php
/**
 * Menu Section: Sandwiches & Bagels
 *
 * @package Sweet_Pepper
 */
?>

<?php $sec = sweet_pepper_menu_section( 'sandwiches' ); // this section's words, in the request's language (inc/menu-sections.php) ?>
<section id="sandwiches" class="menu-section">

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
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'sandwiches' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'sandwiches' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: STACKED WITH LOVE -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/stackedWithLove.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/stackedWithLove.svg',
            'alt'       => 'STACKED WITH LOVE',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
