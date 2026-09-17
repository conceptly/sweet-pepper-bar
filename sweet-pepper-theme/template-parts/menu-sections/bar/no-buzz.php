<?php
/**
 * Menu Section — No Buzz
 *
 * @package Sweet_Pepper
 */
?>

<section id="no-buzz" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/bar/cocktails-non-alco/smoothie-1.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Berry smoothie' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Berry smoothie' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline + deal slot -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'zero proof, full flavour' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'no-buzz' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: virgin cocktails + milkshakes + smoothies -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: virgin cocktails -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'virgin cocktails' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Singapore Sling',
                            'price'       => '270-.',
                            'quantity'    => '300 ml',
                            'description' => 'Non-alc gin, fresh lemon, grenadine, pineapple juice.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Salty Dog',
                            'price'       => '270-.',
                            'quantity'    => '250 ml',
                            'description' => 'Non-alc gin, fresh lemon, sugar syrup, grapefruit juice.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Negroni',
                            'price'       => '270-.',
                            'quantity'    => '150 ml',
                            'description' => 'Non-alc gin, non-alc bitter.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Mojito',
                            'price'       => '270-.',
                            'quantity'    => '300 ml',
                            'description' => 'Non-alc rum, fresh lemon, sugar syrup, lime, mint, soda.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Rongo',
                            'price'       => '270-.',
                            'quantity'    => '300 ml',
                            'description' => 'Non-alc rum, passion fruit, fresh lemon, peach & pineapple juice.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Piña Colada',
                            'price'       => '270-.',
                            'quantity'    => '300 ml',
                            'description' => 'Non-alc rum, pineapple juice, coconut cream.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: milkshakes -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'milkshakes' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Cheese Milkshake',
                            'price'          => '255-.',
                            'quantity'       => '250 ml',
                            'description'    => 'Unique cheese-flavoured milkshake.',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Classic Milkshake',
                            'price'       => '255-.',
                            'quantity'    => '250 ml',
                            'description' => 'Chocolate, banana, banana-chocolate, or vanilla.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Classic Milkshake XL',
                            'price'       => '325-.',
                            'quantity'    => '400 ml',
                            'description' => 'Chocolate, banana, banana-chocolate, or vanilla.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: smoothies -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'smoothies' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Berry Blast',
                            'price'       => '255-.',
                            'quantity'    => '250 ml',
                            'description' => 'Cranberry, blackcurrant, honey, berry juice.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => "Robinson's Breakfast",
                            'price'       => '335-.',
                            'quantity'    => '250 ml',
                            'description' => 'Banana, pineapple, ice cream, milk.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: juices & lemonades + soft drinks + kids drinks -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: juices & lemonades -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'juices & lemonades' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Classic Juice',
                            'price'       => '95-.',
                            'quantity'    => '250 ml',
                            'description' => 'Pineapple, orange, apple, peach, grapefruit, tomato, or cherry.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Fresh Squeezed Juice',
                            'price'       => '265-.',
                            'quantity'    => '200 ml',
                            'description' => 'Orange or grapefruit.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Signature Lemonade',
                            'price'       => '170-. / 455-.',
                            'quantity'    => '350 ml / 1 L',
                            'description' => 'Raspberry & mint, sea buckthorn, or juicy orange.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'      => 'Seasonal Lemonade',
                            'price'          => '170-.',
                            'quantity'       => '350 ml',
                            'description'    => 'Apple-sorrel or watermelon-cucumber.',
                            'seasonal_label' => "Summer'26!",
                            'highlight'      => true,
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: soft drinks -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'soft drinks' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Cola (on tap)',
                            'price'       => '90-.',
                            'quantity'    => '250 ml',
                            'description' => 'Classic cola, served fresh.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Coca-Cola',
                            'price'       => '255-.',
                            'quantity'    => '330 ml',
                            'description' => 'Glass bottle.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Bon Aqua',
                            'price'       => '150-.',
                            'quantity'    => '330 ml',
                            'description' => 'Still water, glass bottle.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Energy Drink',
                            'price'       => '235-.',
                            'quantity'    => '250 ml',
                            'description' => 'Energy boost, adults only.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: kids drinks -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'kids drinks' ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => "Kids' Milkshake",
                            'price'       => '210-.',
                            'description' => 'Vanilla, banana, or chocolate.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => "Kids' Juice",
                            'price'       => '70-.',
                            'description' => 'Any flavour of choice.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => "Kids' Latte",
                            'price'       => '80-.',
                            'description' => 'Caffeine-free — nut, vanilla, or caramel.',
                        ] );
                        ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: CLEAR HEADS WELCOME -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/bar/clearHeadsWelcome.svg',
            'night_img' => 'assets/sectionLinks/menu/bar/clearHeadsWelcome.svg',
            'alt'       => 'CLEAR HEADS WELCOME',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
