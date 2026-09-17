<?php
/**
 * Menu Section: Kids Menu
 *
 * @package Sweet_Pepper
 */
?>

<section id="kids" class="menu-section">

    <!-- Section Content -->
    <div class="container menu-section__content">

        <!-- Hero Image -->
        <div class="menu-section__hero">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/kids/kids-nuggets-2.jpg' ); ?>"
                 alt="<?php echo esc_attr( 'Home-Made Nuggets' ); ?>"
                 loading="lazy">
            <span class="menu-section__hero-pill"><?php echo esc_html( 'Home-Made Nuggets' ); ?></span>
        </div>

        <!-- Title Row: eyebrow + headline -->
        <div class="menu-section__title-row">
            <div class="menu-section__title-text">
                <div class="section-title">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( 'favorites they finish' ); ?></span>
                    <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                    get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'kids', 'headline' => 'For Little Peppers' ] ); ?>
                </div>
            </div>
            <div class="menu-section__title-right"></div>
        </div>

        <!-- Two-Column Dish Layout -->
        <div class="menu-section__columns">

            <!-- LEFT COLUMN: Breakfast & Sides -->
            <div class="menu-section__column menu-section__column--left">

                <!-- Subsection: kids' breakfast -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( "kids' breakfast" ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Pancakes with jam',
                            'price'       => '120-.',
                            'quantity'    => '2 pcs',
                            'description' => 'Thin, warm, and gone in a minute.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Oatmeal with fruit',
                            'price'       => '160-.',
                            'description' => 'Impossible to leave unfinished.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Syrniki with jam',
                            'price'       => '195-.',
                            'quantity'    => '2 pcs',
                            'description' => 'A kids portion, with the jam of their choice.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: kids' sides -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( "kids' sides" ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Fresh vegetable salad',
                            'price'       => '90-.',
                            'description' => 'A light mix of seasonal vegetables.',
                            'icons'       => [ 'veg' ],
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Fettuccine',
                            'price'       => '80-.',
                            'description' => 'A kids portion of plain pasta.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Potato wedges',
                            'price'       => '120-.',
                            'description' => 'Golden crispy wedges.',
                            'icons'       => [ 'veg' ],
                        ] );
                        ?>
                    </div>
                </div>

                <p class="menu-section__remark"><?php echo esc_html( "If you'd like to order from the Kids' Menu for an adult, adult pricing applies at Pepper." ); ?></p>

            </div><!-- /.menu-section__column--left -->

            <!-- RIGHT COLUMN: Lunch, Dessert & Sauces -->
            <div class="menu-section__column menu-section__column--right">

                <!-- Subsection: kids' lunch -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( "kids' lunch" ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Nuggets',
                            'price'       => '165 / 225-.',
                            'quantity'    => '3 / 5 pcs',
                            'description' => 'Home-made from coarse-chopped chicken breast.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => "Peppers' pelmeni",
                            'price'       => '180-.',
                            'description' => 'Pork and beef, a kids portion with broth and fresh herbs.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Fettuccine with cheese',
                            'price'       => '150-.',
                            'description' => 'A kids portion of the favourite pasta in cream sauce.',
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Subsection: kids' dessert -->
                <div class="menu-section__subsection">
                    <div class="menu-section__subsection-header">
                        <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( "kids' dessert" ); ?></h3>
                    </div>
                    <div class="menu-section__dishes">
                        <?php
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Ice cream',
                            'price'       => '90-.',
                            'description' => 'Vanilla, chocolate, pistachio.',
                        ] );
                        get_template_part( 'template-parts/components/dish-row', null, [
                            'dish_name'   => 'Berry shortbread',
                            'price'       => '60-.',
                            'description' => 'A soft shortcake with berries.',
                            'icons'       => [ 'fire' ],
                        ] );
                        ?>
                    </div>
                </div>

                <!-- Addons: Kids Sauces -->
                <div class="menu-section__addons">
                    <div class="menu-section__addons-card">
                        <div class="menu-section__subsection-header">
                            <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( 'Kids Sauces' ); ?></h3>
                        </div>
                        <div class="menu-section__dishes">
                            <?php
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Add any',
                                'price'       => '50-.',
                                'quantity'    => '50 g',
                                'description' => 'Ketchup, cheese, Caesar, sour cream',
                            ] );
                            ?>
                        </div>
                        <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                    </div>
                </div>

            </div><!-- /.menu-section__column--right -->

        </div><!-- /.menu-section__columns -->

    </div><!-- /.container .menu-section__content -->

    <!-- Bottom Link Word: TRY THE MATCH MAKER — the last food section sits on the picker,
         so its connector points at it (the other sections' words sit over the next section's
         photo). Non-interactive, per website-brief.md → Section connectors. Was FAVORITES THEY'LL FINISH. -->
    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => 'assets/sectionLinks/menu/kitchen-day/tryTheMatchMaker.svg',
            'night_img' => 'assets/sectionLinks/menu/kitchen-night/tryTheMatchMaker.svg',
            'alt'       => 'TRY THE MATCH MAKER',
            'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
        ] );
        ?>
    </div>

</section>
