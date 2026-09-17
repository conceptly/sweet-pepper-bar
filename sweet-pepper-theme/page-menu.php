<?php
/**
 * Template Name: Menu
 * 
 * The menu page template — kitchen & bar menus.
 *
 * @package Sweet_Pepper
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Menu Hero Section -->
    <?php
    // Determine menu state from URL: /menu/?menu=drinks → bar hero
    $menu_state = ( isset( $_GET['menu'] ) && $_GET['menu'] === 'drinks' ) ? 'drinks' : 'food';

    get_template_part( 'template-parts/components/menu-hero', null, [
        'menu_state' => $menu_state,
    ] );

    // Phone only (≤ 767px): the hero connector's reflection, on the next section's ground
    // (Highlights → surface; Infusions → bg). Figma: SectionLinkMobile at the top of Highlights (2125:67676).
    $reflection = ( $menu_state === 'drinks' )
        ? [ 'day' => 'assets/sectionLinks/menu/bar/drinksMenu-reflection.svg', 'night' => 'assets/sectionLinks/menu/bar/drinksMenu-reflection.svg', 'alt' => 'DRINKS MENU' ]
        : [ 'day' => 'assets/sectionLinks/menu/kitchen-day/foodMenu-reflection.svg', 'night' => 'assets/sectionLinks/menu/kitchen-night/foodMenu-reflection.svg', 'alt' => 'FOOD MENU' ];
    ?>
    <div class="container menu-hero-reflection menu-hero-reflection--<?php echo esc_attr( $menu_state ); ?>">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => $reflection['day'],
            'night_img' => $reflection['night'],
            'alt'       => $reflection['alt'],
            'class'     => 'section-link-word--reflection',
        ] );
        ?>
    </div>

    <?php if ( $menu_state === 'food' ) : ?>

    <?php get_template_part( 'template-parts/menu-sections/highlights', null, [ 'menu_state' => 'food' ] ); ?>

    <!-- ═══════════════════════════════════════════════════════════════
         BREAKFAST — Menu Section
         Figma: menuSection (766:23756)
         ═══════════════════════════════════════════════════════════════ -->
    <section id="breakfast" class="menu-section">

        <!-- Section Content -->
        <div class="container menu-section__content">

            <!-- Hero Image -->
            <div class="menu-section__hero">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/breakfast/pepper-breakfast-2.jpg' ); ?>"
                     alt="Pepper's Breakfast — fried eggs with vegetables, toast and a patty"
                     loading="lazy">
                <span class="menu-section__hero-pill">Pepper's Breakfast</span>
            </div>

            <!-- Title Row: eyebrow + headline + deal -->
            <div class="menu-section__title-row">
                <div class="menu-section__title-text">
                    <div class="section-title">
                        <span class="section-eyebrow molot-text">whenever your morning starts</span>
                        <?php // Headline + phone rail (template-parts/components/menu-section-rail.php)
                        get_template_part( 'template-parts/components/menu-section-rail', null, [ 'current' => 'breakfast' ] ); ?>
                    </div>
                </div>
                <div class="menu-section__title-right">
                    <!-- Deal: Morning Bubbles -->
                    <div class="menu-section__deal">
                        <div class="menu-section__deal-inner">
                            <div class="menu-section__deal-card">
                                <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                                <div class="menu-section__deal-title molot-text">Morning Bubbles!</div>
                                <div class="menu-section__deal-divider"></div>
                                <div class="menu-section__deal-desc">
                                    <span class="menu-section__deal-desc-main">A glass of Bio Bio</span>
                                    <span class="menu-section__deal-desc-sub">for 260-. with any breakfast!</span>
                                </div>
                            </div>
                        </div>
                        <div class="menu-section__deal-shadow"></div>
                    </div>
                </div>
            </div>

            <!-- Two-Column Dish Layout -->
            <div class="menu-section__columns">

                <!-- LEFT COLUMN: Eggs + Pancakes + Addons -->
                <div class="menu-section__column menu-section__column--left">

                    <!-- Subsection: Eggs -->
                    <div class="menu-section__subsection">
                        <div class="menu-section__subsection-header">
                            <h3 class="menu-section__subsection-title molot-text">Eggs</h3>
                        </div>
                        <div class="menu-section__dishes">
                            <?php
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => "Peppers' Breakfast",
                                'price'       => '345-.',
                                'quantity'    => '280 g',
                                'description' => 'Fried eggs with vegetables, toast & a patty',
                                'icons'       => ['egg'],
                                'highlight'   => true,
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Fried eggs',
                                'price'       => '245-.',
                                'quantity'    => '180 g',
                                'description' => 'with tomatoes & herbs',
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Omelette',
                                'price'       => '315-.',
                                'quantity'    => '230 g',
                                'description' => 'with cheese & mushrooms',
                            ] );
                            ?>
                        </div>
                    </div>

                    <!-- Subsection: Pancakes -->
                    <div class="menu-section__subsection">
                        <div class="menu-section__subsection-header">
                            <h3 class="menu-section__subsection-title molot-text">Pancakes</h3>
                        </div>
                        <div class="menu-section__dishes">
                            <?php
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'With jam',
                                'price'       => '170-.',
                                'quantity'    => '3 pcs / 150 g',
                                'description' => 'or topping',
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'With cottage cheese',
                                'price'       => '195-.',
                                'quantity'    => '2 pcs / 180 g',
                                'description' => '& jam',
                                'icons'       => ['spicy-1'],
                                'highlight'   => true,
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'With salmon',
                                'price'       => '425-.',
                                'quantity'    => '2 pcs / 180 g',
                                'description' => '& cream cheese',
                                'icons'       => ['fish'],
                            ] );
                            ?>
                        </div>
                    </div>

                    <!-- Addons: Favorite Sauces -->
                    <div class="menu-section__addons">
                        <div class="menu-section__addons-card">
                            <div class="menu-section__subsection-header">
                                <h3 class="menu-section__subsection-title molot-text">Favorite Sauces</h3>
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

                <!-- RIGHT COLUMN: Porridge + Morning Sandwiches -->
                <div class="menu-section__column menu-section__column--right">

                    <!-- Subsection: Porridge -->
                    <div class="menu-section__subsection">
                        <div class="menu-section__subsection-header">
                            <h3 class="menu-section__subsection-title molot-text">Porridge</h3>
                        </div>
                        <div class="menu-section__dishes">
                            <?php
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Oatmeal',
                                'price'       => '205-. / 265-.',
                                'quantity'    => '280 g / 320 g',
                                'description' => 'Freshly cooked, in milk or water',
                                'options'     => [
                                    'with your favorite topping',
                                    'with seasonal fruits',
                                ],
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => '+ veggie milk?',
                                'price'       => '+65-.',
                            ] );
                            ?>
                        </div>
                    </div>

                    <!-- Subsection: Morning Sandwiches -->
                    <div class="menu-section__subsection">
                        <div class="menu-section__subsection-header">
                            <h3 class="menu-section__subsection-title molot-text">Morning Sandwiches</h3>
                        </div>
                        <div class="menu-section__dishes">
                            <?php
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Bacon roll',
                                'price'       => '305-.',
                                'quantity'    => '280 g',
                                'description' => 'omelette, tomato & bacon filling',
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Chicken roll',
                                'price'       => '325-.',
                                'quantity'    => '280 g',
                                'description' => 'omelette, tomato & chicken filling',
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Turkey roll',
                                'price'       => '325-.',
                                'quantity'    => '280 g',
                                'description' => 'omelette, tomato & chicken filling',
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Shrimp roll',
                                'price'       => '325-.',
                                'quantity'    => '280 g',
                                'description' => 'omelette, tomato & chicken filling',
                            ] );
                            get_template_part( 'template-parts/components/dish-row', null, [
                                'dish_name'   => 'Morning egg bagel',
                                'price'       => '325-.',
                                'quantity'    => '220 g',
                                'description' => 'with bacon, fried egg & tomato',
                            ] );
                            ?>
                        </div>
                    </div>

                </div><!-- /.menu-section__column--right -->

            </div><!-- /.menu-section__columns -->

        </div><!-- /.container .menu-section__content -->

        <!-- Bottom Link Word: YUMMY MORNING -->
        <div class="container">
            <?php
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/menu/kitchen-day/yummyMorning.svg',
                'night_img' => 'assets/sectionLinks/menu/kitchen-night/yummyMorning.svg',
                'alt'       => 'YUMMY MORNING',
                'class'     => 'section-link-word--reflection menu-section__bottom-link-word',
            ] );
            ?>
        </div>

    </section>

    <?php get_template_part( 'template-parts/menu-sections/lunch' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/bar-snacks' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/salads' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/sandwiches' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/soups' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/hot-dishes' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/desserts' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/kids' ); ?>

    <?php
    // Phones only: the page shows one section at a time (menu-single-section.js), and
    // whichever it is ends on the picker — so one connector serves them all, as the
    // Figma frame draws (menu-food-mobile-day 2109:130225 → "try the match maker").
    // The per-section words stay in their sections for desktop.
    get_template_part( 'template-parts/components/menu-sections-tail', null, [ 'menu_state' => 'food' ] );
    ?>

    <?php get_template_part( 'template-parts/menu-sections/pairing-station' ); ?>

    <?php else : ?>

    <?php // Seasonal highlights in the bar state too — same cards for now (see highlights.php) ?>
    <?php get_template_part( 'template-parts/menu-sections/highlights', null, [ 'menu_state' => 'drinks' ] ); ?>

    <?php get_template_part( 'template-parts/menu-sections/bar/infusions' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/bar/cocktails' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/bar/wine' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/bar/beer' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/bar/spirits' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/bar/no-buzz' ); ?>

    <?php get_template_part( 'template-parts/menu-sections/bar/tea-coffee' ); ?>

    <?php get_template_part( 'template-parts/components/menu-sections-tail', null, [ 'menu_state' => 'drinks' ] ); ?>

    <?php get_template_part( 'template-parts/menu-sections/pairing-station-bar' ); ?>

    <?php endif; ?>

    <?php get_template_part( 'template-parts/menu-sections/location' ); ?>

    <?php // Phones only: the reserve invitation that closes the page (Figma 2109:130264) ?>
    <?php get_template_part( 'template-parts/menu-sections/visit-cta' ); ?>

</main>

<?php
get_footer();
