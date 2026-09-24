<?php
/**
 * The menu page's body — the kitchen (page-menu.php) and the bar (page-menu-bar.php)
 * render this one part; $args['menu_state'] says which menu (inc/menu-page.php).
 *
 * @param array $args { @type string $menu_state 'food' | 'drinks' }
 * @package Sweet_Pepper
 */

$menu_state = ( $args['menu_state'] ?? 'food' ) === 'drinks' ? 'drinks' : 'food';
?>

<main id="primary" class="site-main">

    <!-- Menu Hero Section -->
    <?php
    get_template_part( 'template-parts/components/menu-hero', null, [
        'menu_state' => $menu_state,
    ] );

    // Phones and tablets (≤ 991px): the hero connector's reflection, on the next section's ground
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
    <?php $sec = sweet_pepper_menu_section( 'breakfast' ); // this section's words, in the request's language (inc/menu-sections.php) ?>
    <section id="breakfast" class="menu-section">

        <!-- Section Content -->
        <div class="container menu-section__content">

            <!-- Hero Image -->
            <div class="menu-section__hero">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/food/breakfast/pepper-breakfast-2.jpg' ); ?>"
                     alt="<?php echo esc_attr( $sec['alt'] ); ?>"
                     loading="lazy">
                <span class="menu-section__hero-pill"><?php echo esc_html( $sec['pill'] ); ?></span>
            </div>

            <!-- Title Row: eyebrow + headline + deal -->
            <div class="menu-section__title-row">
                <div class="menu-section__title-text">
                    <div class="section-title">
                        <span class="section-eyebrow molot-text"><?php echo esc_html( $sec['eyebrow'] ); ?></span>
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
                                <div class="menu-section__deal-title molot-text"><?php echo esc_html( $sec['deal']['title'] ?? '' ); ?></div>
                                <div class="menu-section__deal-divider"></div>
                                <div class="menu-section__deal-desc">
                                    <span class="menu-section__deal-desc-main"><?php echo esc_html( $sec['deal']['main'] ?? '' ); ?></span>
                                    <span class="menu-section__deal-desc-sub"><?php echo esc_html( $sec['deal']['sub'] ?? '' ); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="menu-section__deal-shadow"></div>
                    </div>
                </div>
            </div>

            <!-- Two-Column Dish Layout: rows from the menu store (inc/menu-data.php) -->
            <?php get_template_part( 'template-parts/components/menu-section-columns', null, [ 'section' => 'breakfast' ] ); ?>

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
    // Phones and tablets (≤ 991px): the page shows one section at a time (menu-single-section.js), and
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
