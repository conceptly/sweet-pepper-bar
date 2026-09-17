<?php
/**
 * Menu Section: Soups
 *
 * @package Sweet_Pepper
 */
?>

<section id="soups" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/lunch/pumpkin.png' ); ?>"
                 alt="<?php echo esc_attr( 'Iconic Pumpkin Soup' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Iconic Pumpkin Soup' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'warm & comforting' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'soups' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Classics -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: classics -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'classics' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Light chicken broth',
                            'price'       => '185-.',
                            'quantity'    => '300 g',
                            'description' => 'with egg',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Signature borscht',
                            'price'       => '260-.',
                            'quantity'    => '350 g',
                            'description' => 'with beef & croutons with salo',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Pumpkin soup',
                            'price'       => '255-.',
                            'quantity'    => '220 g',
                            'description' => 'Creamy with chicken & basil-walnut pesto',
                            'icons'       => [ 'fire' ],
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: Veggie -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: veggie -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'veggie' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Pumpkin soup',
                            'price'       => '215-.',
                            'quantity'    => '180 g',
                            'description' => 'Vegetarian version with vegetable broth and home-made pesto',
                            'icons'       => [ 'veg' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Mushroom mug',
                            'price'       => '295-.',
                            'quantity'    => '220 g',
                            'description' => 'On cream',
                            'icons'       => [ 'veg' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Vegan mushroom mug',
                            'price'       => '255-.',
                            'quantity'    => '190 g',
                            'description' => 'Vegan version with mushroom broth',
                            'icons'       => [ 'veg' ],
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: SPOON THERAPY -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/spoonTherapy.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/spoonTherapy.svg',
            'alt'       => 'SPOON THERAPY',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
