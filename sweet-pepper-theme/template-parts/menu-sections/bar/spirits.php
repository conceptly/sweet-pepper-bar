<?php
/**
 * Menu Section — Spirits
 *
 * @package Sweet_Pepper
 */
?>

<section id="spirits" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/hard-drinks/jim-beam-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Jim Beam White Label' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Jim Beam White Label' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'neat or on the rocks' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'spirits' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'spirits' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: WORLD AND LOCAL HITS -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/worldAndLocalHits.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/worldAndLocalHits.svg',
            'alt'       => 'WORLD AND LOCAL HITS',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
