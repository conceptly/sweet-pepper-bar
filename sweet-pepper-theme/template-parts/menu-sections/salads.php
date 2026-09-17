<?php
/**
 * Menu Section — Salads
 *
 * Figma: menuSection (781:24143)
 *
 * @package Sweet_Pepper
 */
?>

<section id="salads" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/lunch/cobb-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Iconic Cobb Salad' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Iconic Cobb Salad' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'fresh & crisp' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'salads', 'headline' => "Pepper's Salads" ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Signature Salads -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: signature salads -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'signature salads' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name' => 'Cobb Salad',
                            'price'     => '355-.',
                            'quantity'  => '270 g',
                            'options'   => [
                                'Classic with chicken, bacon, cheese, avocado and veggies',
                                'Vegetarian with mozzarella, avocado and veggies',
                            ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Sicilian',
                            'price'       => '335-.',
                            'quantity'    => '210 g',
                            'description' => 'with chicken, oranges & arugula',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Summer salad with brynza',
                            'price'       => '285-.',
                            'quantity'    => '250 g',
                            'description' => 'cherry tomatoes, bell pepper & basil-walnut pesto',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: Caesar Collection -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: caesar collection -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'caesar collection' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Classic Caesar',
                            'price'       => '325-.',
                            'quantity'    => '210 g',
                            'description' => 'with chicken',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Mediterranean Caesar',
                            'price'       => '475-.',
                            'quantity'    => '210 g',
                            'description' => 'with shrimp',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Scandinavian Caesar',
                            'price'       => '445-.',
                            'quantity'    => '210 g',
                            'description' => 'with salmon',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: FRESH AS IT GETS -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/freshAsItGets.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/freshAsItGets.svg',
            'alt'       => 'FRESH AS IT GETS',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
