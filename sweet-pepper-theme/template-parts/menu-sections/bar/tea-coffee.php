<?php
/**
 * Menu Section — Tea & Coffee
 *
 * @package Sweet_Pepper
 */
?>

<section id="tea-coffee" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/coffee/cappuccino-icecream-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Cappuccino' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Cappuccino' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'brewed with love' ); ?></span>
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
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( 'Lunch Offer!' ); ?></div>
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

        <!-- Coffee Columns -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Black Coffee + Iced Coffee + Vegan Milk Addons -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: black coffee -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'black coffee' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Espresso',
                            'price'       => '140-.',
                            'quantity'    => '30 ml',
                            'description' => 'Single shot.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Double Espresso',
                            'price'       => '180-.',
                            'quantity'    => '60 ml',
                            'description' => 'Double shot.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Americano',
                            'price'       => '140-.',
                            'quantity'    => '200 ml',
                            'description' => 'Espresso with hot water.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Americano XXL',
                            'price'       => '180-.',
                            'quantity'    => '300 ml',
                            'description' => 'Large americano.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Arabica Filter',
                            'price'       => '130-.',
                            'quantity'    => '200 ml',
                            'description' => 'Filter-brewed single origin.',
                            'icons'       => [ 'fire' ],
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: iced coffee -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'iced coffee' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bumble Fresh',
                            'price'       => '235-.',
                            'quantity'    => '250 ml',
                            'description' => 'Fresh orange juice, espresso, caramel topping.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Espresso Tonic',
                            'price'       => '180-.',
                            'quantity'    => '250 ml',
                            'description' => 'Espresso over tonic water.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Addons: Vegan Milk -->
                <div class="menu-section__addons">
                    <div class="menu-section__addons-card">
                        <div class="menu-section__subsection-header">
                            <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'Vegan Milk' ); ?></h3>
                        </div>
                        <div class="menu-section__dishes">
                            <?php
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Add any',
                                'price'       => '65-.',
                                'description' => 'Oatmeal, almond, coconut',
                            ] );
                            ?>
                        </div>
                        <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: With Milk + Chocolate & Cocoa -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: with milk -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'with milk' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cappuccino',
                            'price'       => '175-.',
                            'quantity'    => '200 ml',
                            'description' => 'Classic or iced version.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cappuccino XXL',
                            'price'       => '245-.',
                            'quantity'    => '300 ml',
                            'description' => 'Large cappuccino.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Latte',
                            'price'       => '190-.',
                            'quantity'    => '300 ml',
                            'description' => 'Smooth espresso with steamed milk.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Flat White',
                            'price'       => '195-.',
                            'quantity'    => '200 ml',
                            'description' => 'Velvety microfoam, double shot.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Spiced Raf',
                            'price'       => '205-.',
                            'quantity'    => '250 ml',
                            'description' => 'Creamy espresso with spiced syrup.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Cheese Raf',
                            'price'          => '225-.',
                            'quantity'       => '250 ml',
                            'description'    => 'Creamy cheese-flavoured raf.',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: chocolate & cocoa -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'chocolate & cocoa' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cocoa',
                            'price'       => '295-.',
                            'quantity'    => '200 ml',
                            'description' => 'With marshmallows.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Hot Chocolate',
                            'price'       => '295-.',
                            'quantity'    => '120 ml',
                            'description' => 'Rich and creamy.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

        <!-- Divider -->
        <div class="menu-section__coffee-tea-divider"></div>

        <!-- Tea Columns -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Yaroslavl Style Tea -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: yaroslavl style tea -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'yaroslavl style tea' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cranberry Tea',
                            'price'       => '290-.',
                            'quantity'    => '600 ml',
                            'description' => 'With ginger.',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Raspberry Tea',
                            'price'       => '290-.',
                            'quantity'    => '600 ml',
                            'description' => 'With anise.',
                            'icons'       => [ 'fire' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Sea Buckthorn Tea',
                            'price'       => '290-.',
                            'quantity'    => '600 ml',
                            'description' => 'With orange.',
                            'icons'       => [ 'fire' ],
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: Freshly Brewed Tea -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: freshly brewed tea -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'freshly brewed tea' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Black Tea',
                            'price'       => '180-.',
                            'quantity'    => '600 ml',
                            'description' => 'Assam, Earl Grey, Wild Cherry, or Taiga Blend.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Green Tea',
                            'price'       => '180-.',
                            'quantity'    => '600 ml',
                            'description' => 'Mango, Jasmine, Milk Oolong, or Gunpowder.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Pu-erh',
                            'price'       => '180-.',
                            'quantity'    => '600 ml',
                            'description' => 'Aged 3 years, earthy and deep.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'NOtea',
                            'price'       => '180-.',
                            'quantity'    => '600 ml',
                            'description' => 'Strawberries & Cream, Fruit Rooibos, Buckwheat, or Ivan-chai.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: SURPRISINGLY GOOD -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/surprisinglyGood.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/surprisinglyGood.svg',
            'alt'       => 'SURPRISINGLY GOOD',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
