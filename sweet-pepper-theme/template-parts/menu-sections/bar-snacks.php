<?php
/**
 * Menu Section — Bar Snacks
 *
 * Figma: menuSection (775:22873)
 *
 * @package Sweet_Pepper
 */
?>

<section id="bar-snacks" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/dinner/wings-2.jpg' ); ?>"
                 alt="<?php echo esc_attr( "Pepper's Stuffed Chicken" ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( "Pepper's Stuffed Chicken" ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'share with friends' ); ?></span>
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
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( 'perfect together' ); ?></div>
                            <div class="menu-section__deal-divider"></div>
                            <div class="menu-section__deal-desc">
                                <span class="menu-section__deal-desc-main"><?php echo esc_html( 'Infusions 3+1' ); ?></span>
                                <a href="#bar-menu" class="menu-section__deal-link">
                                    <span><?php echo esc_html( 'See it in the Bar menu!' ); ?></span>
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

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: fried bites + hot bites -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: fried bites -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'fried bites' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Mozzarella fries',
                            'price'       => '335-.',
                            'quantity'    => '130 g',
                            'description' => 'Breaded, with lingonberry sauce',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Onion rings',
                            'price'       => '325-.',
                            'quantity'    => '180 g',
                            'description' => 'Deep fried with a sauce of your choice',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Borodinsky croutons',
                            'price'       => '180-.',
                            'quantity'    => '150 g',
                            'description' => 'Deep fried with fresh garlic and sour cream',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: hot bites -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'hot bites' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name' => 'Quesadilla',
                            'price'     => '295-.',
                            'quantity'  => '130 g',
                            'options'   => [
                                'Chicken & cheese',
                                'Double cheese',
                            ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cauliflower',
                            'price'       => '245-.',
                            'quantity'    => '250 g',
                            'description' => 'with chili & honey',
                            'icons'       => [ 'veg', 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name' => 'Breaded broccoli',
                            'price'     => '255-.',
                            'quantity'  => '200 g',
                            'icons'     => [ 'veg' ],
                            'options'   => [
                                'with parmesan',
                                'veggie with home-made pesto',
                            ],
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: wings & meat + draniki + Favorite Sauces Addons -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: wings & meat -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'wings & meat' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Grilled wings',
                            'price'       => '455-./ 645-.',
                            'quantity'    => '270 g / 540 g',
                            'description' => 'For one, 5 pcs. In honey glaze',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Meat Set 2026',
                            'price'       => '595-.',
                            'quantity'    => '285 g',
                            'description' => 'With beef, salami, pork, pickles, and croutons',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: draniki -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'draniki' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Classic draniki',
                            'price'       => '225-.',
                            'quantity'    => '250 g',
                            'description' => 'Served with sour cream',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Signature draniki',
                            'price'       => '315-.',
                            'quantity'    => '250 g',
                            'description' => 'With bacon & tomatoes',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Royal draniki',
                            'price'       => '395-.',
                            'quantity'    => '250 g',
                            'description' => 'With salmon and butter or cream cheese',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Addons: Favorite Sauces -->
                <div class="menu-section__addons">
                    <div class="menu-section__addons-card">
                        <div class="menu-section__subsection-header">
                            <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'Favorite Sauces' ); ?></h3>
                        </div>
                        <div class="menu-section__dishes">
                            <?php
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Add any',
                                'price'       => '65-.',
                                'quantity'    => '50 g',
                                'description' => 'Cheese, Caesar, BBQ, Tartar, Sour cream, Sicilian, Mustard',
                            ] );
                            ?>
                        </div>
                        <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

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
