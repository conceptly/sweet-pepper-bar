<?php
/**
 * Menu Section: Sandwiches & Bagels
 *
 * @package Sweet_Pepper
 */
?>

<section id="sandwiches" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/lunch/sweet-130.jpg' ); ?>"
                 alt="<?php echo esc_attr( "Pepper's Stuffed Chicken" ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( "Pepper's Stuffed Chicken" ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'house-made sesame bagels' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'sandwiches', 'headline' => 'Sandwiches & Bagels' ] ); ?>
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
