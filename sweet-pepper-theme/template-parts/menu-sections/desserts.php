<?php
/**
 * Menu Section — Desserts
 *
 * @package Sweet_Pepper
 */
?>

<section id="desserts" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/dessert/napoleon-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Raspberry Mille-Feuille' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Raspberry Mille-Feuille' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'always room for something sweet' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'desserts' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Pastries -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: pastries -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'pastries' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Signature apple strudel',
                            'price'       => '255-.',
                            'quantity'    => '180 g',
                            'description' => 'with a scoop of ice cream',
                            'icons'       => [ 'fire' ],
                            'highlight'   => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Raspberry Napoleon',
                            'price'       => '215-.',
                            'quantity'    => '150 g',
                            'description' => 'with jam & almonds',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Ice cream',
                            'price'       => '95-.',
                            'quantity'    => '50 g',
                            'description' => 'Cream; or Chocolate; or Pistachio',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: Cheesecakes -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: cheesecakes -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'cheesecakes' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'San Sebastian',
                            'price'       => '335-.',
                            'quantity'    => '240 g',
                            'description' => 'Creamy with a baked crust',
                            'icons'       => [ 'fire' ],
                            'highlight'   => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Blueberry cheesecake',
                            'price'       => '215-.',
                            'quantity'    => '175 g',
                            'description' => 'No-bake, with natural berries',
                            'icons'       => [ 'fire' ],
                            'highlight'   => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Caramel cheesecake',
                            'price'       => '325-.',
                            'quantity'    => '200 g',
                            'description' => 'Creamy with peanuts',
                            'icons'       => [ 'fire' ],
                            'highlight'   => true,
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: SWEET LIKE PEPPER -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/sweetLikePepper.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/sweetLikePepper.svg',
            'alt'       => 'SWEET LIKE PEPPER',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
