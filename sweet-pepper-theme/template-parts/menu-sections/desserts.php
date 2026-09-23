<?php
/**
 * Menu Section — Desserts
 *
 * @package Sweet_Pepper
 */
?>

<section id="desserts" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/dessert/napoleon-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Raspberry Mille-Feuille' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Raspberry Mille-Feuille' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'always room for something sweet' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'desserts' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'desserts' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: SWEET LIKE PEPPER -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/sweetLikePepper.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/sweetLikePepper.svg',
            'alt'       => 'SWEET LIKE PEPPER',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
