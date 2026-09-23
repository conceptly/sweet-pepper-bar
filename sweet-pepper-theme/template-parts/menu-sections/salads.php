<?php
/**
 * Menu Section — Salads
 *
 * Figma: menuSection (781:24143)
 *
 * @package Sweet_Pepper
 */
?>

<section id="salads" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/lunch/cobb-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Iconic Cobb Salad' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Iconic Cobb Salad' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'fresh & crisp' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'salads', 'headline' => "Pepper's Salads" ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'salads' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: FRESH AS IT GETS -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/freshAsItGets.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/freshAsItGets.svg',
            'alt'       => 'FRESH AS IT GETS',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
