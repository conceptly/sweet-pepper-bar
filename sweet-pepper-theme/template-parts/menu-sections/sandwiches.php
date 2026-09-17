<?php
/**
 * Menu Section: Sandwiches & Bagels
 *
 * @package Sweet_Pepper
 */
?>

<section id="sandwiches" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/lunch/sweet-130.jpg' ); ?>"
                 alt="<?php echo esc_attr( "Pepper's Stuffed Chicken" ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( "Pepper's Stuffed Chicken" ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'house-made sesame bagels' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'sandwiches', 'headline' => 'Sandwiches & Bagels' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Sandwiches -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: Sandwiches -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'Sandwiches' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Chicken Club',
                            'price'       => '305-.',
                            'quantity'    => '210 g',
                            'description' => 'with chicken breast, caesar sauce, cheese and pickles',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Turkey Club',
                            'price'       => '325-.',
                            'quantity'    => '210 g',
                            'description' => 'with turkey',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Salmon Club',
                            'price'       => '385-.',
                            'quantity'    => '210 g',
                            'description' => 'with salmon, cream cheese, and fresh cucumber',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name' => 'Sandwich set',
                            'price'     => '435-.',
                            'quantity'  => '290 g',
                            'icons'     => [ 'fire' ],
                            'options'   => [
                                'Chicken & Fries',
                                'Turkey & Potato Wedges',
                            ],
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: Bagels -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: Bagels -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'Bagels' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Pepper bagel',
                            'price'       => '335-.',
                            'quantity'    => '240 g',
                            'description' => 'with spiced beef, gouda & tomato',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Caesar bagel',
                            'price'       => '325-.',
                            'quantity'    => '240 g',
                            'description' => 'with chicken, parmesan & tomato',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Salmon bagel',
                            'price'       => '395-.',
                            'quantity'    => '240 g',
                            'description' => 'cream cheese, cucumber, capers & red onion',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Morning egg bagel',
                            'price'       => '325-.',
                            'quantity'    => '240 g',
                            'description' => 'with bacon, fried egg & tomato',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bagel set with a patty',
                            'price'       => '435-.',
                            'quantity'    => '350 g',
                            'description' => 'patty, cheese, pickles & tomatoes with potato wedges',
                            'icons'       => [ 'fire' ],
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: STACKED WITH LOVE -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/stackedWithLove.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/stackedWithLove.svg',
            'alt'       => 'STACKED WITH LOVE',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
