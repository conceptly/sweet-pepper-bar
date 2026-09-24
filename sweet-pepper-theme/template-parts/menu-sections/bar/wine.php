<?php
/**
 * Menu Section — Wine
 *
 * @package Sweet_Pepper
 */
?>

<?php $sec = sweet_pepper_menu_section( 'wine' ); // this section's words, in the request's language (inc/menu-sections.php) ?>
<section id="wine" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/wine/red-2.jpg' ); ?>"
                 alt="<?php echo esc_attr( $sec['alt'] ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( $sec['pill'] ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( $sec['eyebrow'] ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'wine' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right">
                <!-- Deal: It's Wine O'Clock! -->
                <div class="menu-section__deal">
                    <div class="menu-section__deal-inner">
                        <div class="menu-section__deal-card">
                            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( $sec['deal']['title'] ?? '' ); ?></div>
                            <div class="menu-section__deal-divider"></div>
                            <div class="menu-section__deal-desc">
                                <span class="menu-section__deal-desc-main"><?php echo esc_html( $sec['deal']['main'] ?? '' ); ?></span>
                                <span class="menu-section__deal-desc-sub"><?php echo esc_html( $sec['deal']['sub'] ?? '' ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="menu-section__deal-shadow"></div>
                </div>
            </div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'wine' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: UNCORK THE MOMENT -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/uncorkTheMoment.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/uncorkTheMoment.svg',
            'alt'       => 'UNCORK THE MOMENT',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
