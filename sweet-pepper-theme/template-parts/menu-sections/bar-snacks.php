<?php
/**
 * Menu Section — Bar Snacks
 *
 * Figma: menuSection (775:22873)
 *
 * @package Sweet_Pepper
 */
?>

<?php $sec = sweet_pepper_menu_section( 'bar-snacks' ); // this section's words, in the request's language (inc/menu-sections.php) ?>
<section id="bar-snacks" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/dinner/wings-2.jpg' ); ?>"
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
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'bar-snacks' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right">
                <!-- Deal: perfect together -->
                <div class="menu-section__deal">
                    <div class="menu-section__deal-inner">
                        <div class="menu-section__deal-card">
                            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( $sec['deal']['title'] ?? '' ); ?></div>
                            <div class="menu-section__deal-divider"></div>
                            <div class="menu-section__deal-desc">
                                <span class="menu-section__deal-desc-main"><?php echo esc_html( $sec['deal']['main'] ?? '' ); ?></span>
                                <a href="#bar-menu" class="menu-section__deal-link">
                                    <span><?php echo esc_html( $sec['deal']['link'] ?? '' ); ?></span>
                                    <span class="menu-section__deal-link-icon">
                                        <?php
                                        echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' );
                                        ?>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="menu-section__deal-shadow"></div>
                </div>
            </div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'bar-snacks' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: FINGER-LICKING FOOD -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/fingerLickingFood.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/fingerLickingFood.svg',
            'alt'       => 'FINGER-LICKING FOOD',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
