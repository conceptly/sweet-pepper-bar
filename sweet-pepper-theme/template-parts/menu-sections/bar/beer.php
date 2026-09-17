<?php
/**
 * Menu Section — Beer
 *
 * @package Sweet_Pepper
 */
?>

<section id="beer" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/beer/beer-05.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Iconic Cobb Salad' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Iconic Cobb Salad' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'cold & crisp' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'beer' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Bottled -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: bottled -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'bottled' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name' => 'Krušovice',
                            'price'     => '225-.',
                            'quantity'  => '450 ml',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Krušovice Non-Alc',
                            'price'       => '195-.',
                            'quantity'    => '330 ml',
                            'description' => 'All the taste, zero alcohol.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Craft',
                            'price'       => '450-.',
                            'quantity'    => '450 ml',
                            'description' => "Can or bottle — ask your server for today's selection.",
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: On Tap -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: on tap -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'on tap' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Oklers Weizen',
                            'price'       => '235-. / 365-.',
                            'quantity'    => '250 ml / 400 ml',
                            'description' => 'OG 11%, ABV 4.5%. Bavarian-style wheat beer.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Soviet Pilsner',
                            'price'       => '235-. / 365-.',
                            'quantity'    => '250 ml / 400 ml',
                            'description' => 'OG 11%, ABV 4.3%. Crisp lager, local brew.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: COLD AND HONEST -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/coldAndHonest.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/coldAndHonest.svg',
            'alt'       => 'COLD AND HONEST',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
