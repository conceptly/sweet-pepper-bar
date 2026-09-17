<?php
/**
 * Menu Section — Wine
 *
 * @package Sweet_Pepper
 */
?>

<section id="wine" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/wine/red-2.jpg' ); ?>"
                 alt="<?php echo esc_attr( "Pepper's Stuffed Chicken" ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( "Pepper's Stuffed Chicken" ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'by the glass or bottle' ); ?></span>
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
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( "It's Wine O'Clock!" ); ?></div>
                            <div class="menu-section__deal-divider"></div>
                            <div class="menu-section__deal-desc">
                                <span class="menu-section__deal-desc-main"><?php echo esc_html( 'Every Wednesday' ); ?></span>
                                <span class="menu-section__deal-desc-sub"><?php echo esc_html( '10% off bottles all day' ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="menu-section__deal-shadow"></div>
                </div>
            </div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: white wine + red wine -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: white wine -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'white wine' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cape Original Muscat',
                            'price'       => '325-. / 2050-.',
                            'quantity'    => '125 ml / 750 ml',
                            'description' => 'Sweet — South Africa. Striking fruit & floral, tangerine sweetness.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Riesling Sturmwolken',
                            'price'       => '325-. / 2050-.',
                            'quantity'    => '125 ml / 750 ml',
                            'description' => 'Semi-dry — Germany, Pfalz. Ripe apple & honeysuckle, fruity notes.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Sauvignon Blanc Arco Bay',
                            'price'       => '475-. / 2750-.',
                            'quantity'    => '125 ml / 750 ml',
                            'description' => 'Dry — New Zealand. Blackcurrant leaf, tropical, gooseberry finish.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: red wine -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'red wine' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Tarapaca Merlot',
                            'price'       => '315-. / 2050-.',
                            'quantity'    => '125 ml / 750 ml',
                            'description' => 'Dry — Chile. Spiced cherry, ripe plum chords.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Garnacha Celebrities',
                            'price'       => '315-. / 2050-.',
                            'quantity'    => '125 ml / 750 ml',
                            'description' => 'Dry — Spain. Wild berries, dark fruit, chokeberry note.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Lakky Shiraz',
                            'price'       => '315-. / 2050-.',
                            'quantity'    => '125 ml / 750 ml',
                            'description' => 'Semi-dry — Australia. Raspberry jam, tobacco, spiced finish.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: sparkling wine + sherry & fortified + vermouths -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: sparkling wine -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'sparkling wine' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bio Bio Bubbles',
                            'price'       => '345-. / 2250-.',
                            'quantity'    => '125 ml / 750 ml',
                            'description' => 'Extra dry — Italy, Sicily. Citrus & green fruit, invigorating freshness.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: sherry & fortified -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'sherry & fortified' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name' => 'Xepec Tio Toto Cream',
                            'price'     => '455-.',
                            'quantity'  => '100 ml',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Xepec Tio Toto Fino',
                            'price'       => '455-.',
                            'quantity'    => '100 ml',
                            'description' => 'Light and dry sherry.',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Port',
                            'price'       => '365-.',
                            'quantity'    => '100 ml',
                            'description' => 'World famous Portugal fortified wine',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: vermouths -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'vermouths' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Atxa Vermouth',
                            'price'       => '150-.',
                            'quantity'    => '40 ml',
                            'description' => 'Aromatic Spanish vermouth.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

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
