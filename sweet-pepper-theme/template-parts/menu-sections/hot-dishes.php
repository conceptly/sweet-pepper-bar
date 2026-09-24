<?php
/**
 * Menu Section — Hot Dishes
 *
 * @package Sweet_Pepper
 */
?>

<?php $sec = sweet_pepper_menu_section( 'hot-dishes' ); // this section's words, in the request's language (inc/menu-sections.php) ?>
<section id="hot-dishes" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/dinner/zharkoe-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( $sec['alt'] ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( $sec['pill'] ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + empty right slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( $sec['eyebrow'] ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'hot-dishes' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'hot-dishes' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: COMFORT FOOD -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/comfortFood.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/comfortFood.svg',
            'alt'       => 'COMFORT FOOD',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
