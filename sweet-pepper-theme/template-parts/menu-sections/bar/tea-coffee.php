<?php
/**
 * Menu Section — Tea & Coffee
 *
 * @package Sweet_Pepper
 */
?>

<?php $sec = sweet_pepper_menu_section( 'tea-coffee' ); // this section's words, in the request's language (inc/menu-sections.php) ?>
<section id="tea-coffee" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( $sec['band_image'] ); ?>"<?php echo sweet_pepper_menu_band_style( $sec ); // the page's photo + slider (inc/menu-sections.php) ?>
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
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'tea-coffee' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right">
                <!-- Deal: Lunch Offer! -->
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
        <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'tea-coffee' ] ); ?>

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: TRY THE MATCH MAKER — the bar's last section, so its word is the
         one the picker below reflects, as Kids on the food page (author, 23 Sep 2026; was
         SURPRISINGLY GOOD, which the reflection never repeated). bar/ holds its pair (copies of
         the kitchen-night files — the bar's colours). In Russian it becomes
         bar/ru/параОтБараВместеВкуснее (inc/menu-sections.php). -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/tryTheMatchMaker.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/tryTheMatchMaker.svg',
            'alt'       => 'TRY THE MATCH MAKER',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
