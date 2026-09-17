<?php
/**
 * Menu Section — Infusions (Bar)
 *
 * @package Sweet_Pepper
 */
?>

<section id="infusions" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/infusions/infusions-lenya-11-4-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Home-Made Infusions' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Home-Made Infusions' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'Home-made, since 2014' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'infusions' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right">
                <!-- Deal: 3+1 Deal! -->
                <div class="menu-section__deal">
                    <div class="menu-section__deal-inner">
                        <div class="menu-section__deal-card">
                            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                            <div class="menu-section__deal-title molot-text"><?php echo esc_html( '3+1 Deal!' ); ?></div>
                            <div class="menu-section__deal-divider"></div>
                            <div class="menu-section__deal-desc">
                                <span class="menu-section__deal-desc-main"><?php echo esc_html( 'Order 3 infusions,' ); ?></span>
                                <span class="menu-section__deal-desc-sub"><?php echo esc_html( 'get the 4th free!' ); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="menu-section__deal-shadow"></div>
                </div>
            </div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN -->
            <div class="menu-section__column menu-section__column--left">
                <div class="menu-section__dishes">
                    <?php
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'      => 'Icy Lemon',
                        'price'          => '150-. / 1300-.',
                        'quantity'       => '40 ml / 500 ml',
                        'description'    => 'Crisp and zesty, served chilled.',
                        'seasonal_label' => "Summer'26!",
                        'highlight'      => true,
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Strawberry',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Sweet and fruity, a crowd favourite.',
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Legendary Blackcurrant',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Deep berry flavor, our signature.',
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Cranberry',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Bold and refreshing classic.',
                        'icons'       => [ 'fire' ],
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Sea buckthorn',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Bright citrusy tartness.',
                        'icons'       => [ 'fire' ],
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Yaroslavl Blueberry',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Local berries, smooth finish.',
                    ] );
                    ?>
                </div>
            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN -->
            <div class="menu-section__column menu-section__column--right">
                <div class="menu-section__dishes">
                    <?php
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Salted Caramel',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Sweet, salty, irresistible.',
                        'icons'       => [ 'fire' ],
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'She-Devil',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Prune & spices, bold warmth.',
                        'icons'       => [ 'fire' ],
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Horseraddish',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'description',
                        'icons'       => [ 'fire', 'fire' ],
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Raspberry Gin',
                        'price'       => '190-. / 1800-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Fruity gin infusion, premium.',
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Cherry Cognac',
                        'price'       => '190-. / 1800-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Rich cherry with cognac warmth.',
                    ] );
                    get_template_part( 'template-parts/components/dish-row', null, [
                        'dish_name'   => 'Yaroslavl Advocaat',
                        'price'       => '150-.',
                        'quantity'    => '40 ml',
                        'description' => 'Creamy egg liqueur, shot only.',
                    ] );
                    ?>
                </div>
            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: THE HOUSE SECRET -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/houseSecret.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/houseSecret.svg',
            'alt'       => 'THE HOUSE SECRET',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
