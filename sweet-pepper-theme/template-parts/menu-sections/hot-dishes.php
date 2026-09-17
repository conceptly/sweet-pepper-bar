<?php
/**
 * Menu Section — Hot Dishes
 *
 * @package Sweet_Pepper
 */
?>

<section id="hot-dishes" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/dinner/zharkoe-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Yaroslavl-Style Roast' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Yaroslavl-Style Roast' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + empty right slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'from the kitchen' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'hot-dishes' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Pastas + Favorite Sauces Addons -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: pastas -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'pastas' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Fettuccine Carbonara',
                            'price'       => '365-.',
                            'quantity'    => '250 g',
                            'description' => 'with bacon in cream sauce',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Farfalle with chicken',
                            'price'       => '345-.',
                            'quantity'    => '300 g',
                            'description' => 'bow-tie pasta with mushrooms & broccoli in cream sauce',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Fettuccine Corfu',
                            'price'          => '465-.',
                            'quantity'       => '250 g',
                            'description'    => 'with brynza, shrimp & zucchini in basil-walnut pesto',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Napolitana with meatballs',
                            'price'       => '395-.',
                            'quantity'    => '300 g',
                            'description' => 'nest pasta in a spicy tomato sauce',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Napolitana with shrimp',
                            'price'       => '445-.',
                            'quantity'    => '300 g',
                            'description' => 'nest pasta in a spicy tomato sauce',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Napolitana with turkey',
                            'price'       => '385-.',
                            'quantity'    => '300 g',
                            'description' => 'nest pasta in a spicy tomato sauce',
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

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: Mains + Grill -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: mains -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'mains' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Yaroslavl-style roast',
                            'price'       => '365-.',
                            'quantity'    => '300 g',
                            'description' => 'potato wedges, pork & vegetables in spicy cream sauce',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Cod roast',
                            'price'          => '365-.',
                            'quantity'       => '300 g',
                            'description'    => 'potato wedges, cod & vegetables in cream-oyster sauce',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Ravioli',
                            'price'          => '325-.',
                            'quantity'       => '300 g',
                            'description'    => 'description',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name' => 'Pelmeni',
                            'price'     => '305-.',
                            'quantity'  => '180 g',
                            'icons'     => [ 'fire' ],
                            'options'   => [
                                'Pepper-style baked with cheese',
                                'Classic style in broth with sour cream',
                            ],
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: grill -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'grill' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Chicken steak',
                            'price'       => '435-.',
                            'quantity'    => '350 g',
                            'description' => 'with mashed potato & sauce',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Turkey steak',
                            'price'       => '585-.',
                            'quantity'    => '320 g',
                            'description' => 'with potato wedges, carrot & pumpkin',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Pork steak',
                            'price'       => '695-.',
                            'quantity'    => '450 g',
                            'description' => 'with country-style potatoes',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: COMFORT FOOD -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/comfortFood.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/comfortFood.svg',
            'alt'       => 'COMFORT FOOD',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
