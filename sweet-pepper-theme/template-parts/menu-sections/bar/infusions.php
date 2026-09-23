<?php
/**
 * Menu Section — Infusions (Bar)
 *
 * @package Sweet_Pepper
 */
?>

<section id="infusions" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/infusions/infusions-lenya-11-4-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Home-Made Infusions' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Home-Made Infusions' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'Home-made, since 2014' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'infusions' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right">
                <!-- Deal: 3+1 Deal! -->
                <div class="menu-section__deal">
                    <div class="menu-section__deal-inner">
                        <div class="menu-section__deal-card">
                            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( '3+1 Deal!' ); ?></div>
                            <div class="menu-section__deal-divider"></div>
                            <div class="menu-section__deal-desc">
                                <span class="menu-section__deal-desc-main"><?php echo esc_html( 'Order 3 infusions,' ); ?></span>
                                <span class="menu-section__deal-desc-sub"><?php echo esc_html( 'get the 4th free!' ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="menu-section__deal-shadow"></div>
                </div>
            </div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'infusions' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: THE HOUSE SECRET -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/houseSecret.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/houseSecret.svg',
            'alt'       => 'THE HOUSE SECRET',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
