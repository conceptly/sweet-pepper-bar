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

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Salads + Lunch Hits -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: salads -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'salads' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cobb Salad',
                            'price'       => '285-.',
                            'description' => 'with chicken breast, bacon & signature sauce',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Classic Caesar',
                            'price'       => '265-.',
                            'description' => 'with chicken, croutons & signature sauce',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Summer salad',
                            'price'          => '265-.',
                            'description'    => 'with brynza, cherry tomatoes & basil-walnut pesto',
                            'icons'          => [ 'veg' ],
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: lunch hits -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'lunch hits' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Quesadilla',
                            'price'       => '265-.',
                            'description' => 'Chicken & cheese / or Double cheese',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Signature Broccoli',
                            'price'       => '190-.',
                            'description' => 'Breaded with parmesan',
                            'icons'       => [ 'veg' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Farfalle with chicken',
                            'price'       => '245-.',
                            'description' => 'bow-tie pasta with mushrooms & broccoli in cream sauce',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: First Course + Sandwich Sets -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: first course -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'first course' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Borscht',
                            'price'       => '225-.',
                            'description' => 'A classic, with garlic toast & salo on the side',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Pumpkin soup',
                            'price'       => '195-.',
                            'description' => 'Creamy with chicken',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Summer soup of the day',
                            'price'          => '235-.',
                            'quantity'       => '250 g',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                            'options'        => [
                                "Pepper's Okroshka",
                                'Tomato Gazpacho',
                            ],
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: sandwich sets -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'sandwich sets' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Chicken Club',
                            'price'       => '335-.',
                            'description' => 'on crispy toasts with French fries and sauce',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Turkey Club',
                            'price'       => '345-.',
                            'description' => 'on crispy toasts with potato wedges and sauce',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bagel with a patty',
                            'price'       => '355-.',
                            'description' => 'Home-made buns, a beef patty, veggies, pickles, with potato wedges and sauce',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

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
