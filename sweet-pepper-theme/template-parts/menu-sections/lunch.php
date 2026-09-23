<?php
/**
 * Lunch Menu Section
 *
 * Maps to Figma: menuSection (745:22513).
 *
 * @package Sweet_Pepper
 */
?>

<section id="lunch" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/lunch/bagel-lunch-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Yaroslavl Bagel Lunch' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Yaroslavl Bagel Lunch' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'weekdays 12pm – 4pm' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'lunch' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right">
                <!-- Deal: Drinks deal! -->
                <div class="menu-section__deal">
                    <div class="menu-section__deal-inner">
                        <div class="menu-section__deal-card">
                            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( 'Drinks deal!' ); ?></div>
                            <div class="menu-section__deal-divider"></div>
                            <div class="menu-section__deal-desc">
                                <span class="menu-section__deal-desc-main"><?php echo esc_html( 'Tea, Coffee, Juice & more' ); ?></span>
                                <span class="menu-section__deal-desc-sub"><?php echo esc_html( '50% off with any hot dish!' ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="menu-section__deal-shadow"></div>
                </div>
            </div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'lunch' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: THE BEST IN THE CITY -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/theBestInTheCity.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/theBestInTheCity.svg',
            'alt'       => 'THE BEST IN THE CITY',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
