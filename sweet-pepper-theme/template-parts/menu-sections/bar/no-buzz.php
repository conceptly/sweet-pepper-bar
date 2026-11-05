<?php
/**
 * Menu Section — No Buzz
 *
 * @package Sweet_Pepper
 */
?>

<?php $sec = sweet_pepper_menu_section( 'no-buzz' ); // this section's words, in the request's language (inc/menu-sections.php) ?>
<section id="no-buzz" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( $sec['band_image'] ); ?>"<?php echo sweet_pepper_menu_band_style( $sec ); // the page's photo + slider (inc/menu-sections.php) ?>
                 alt="<?php echo esc_attr( $sec['alt'] ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( $sec['pill'] ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( $sec['eyebrow'] ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'no-buzz' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'no-buzz' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: CLEAR HEADS WELCOME -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/clearHeadsWelcome.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/clearHeadsWelcome.svg',
            'alt'       => 'CLEAR HEADS WELCOME',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
