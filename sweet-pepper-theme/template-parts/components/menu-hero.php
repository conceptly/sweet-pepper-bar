<?php
/**
 * Menu Hero Component — "Side-Nav Poster" (Concept B)
 *
 * Left nav panel with section word list + right photo stack with FOOD/DRINKS wordmark.
 * Maps to Figma:
 *   Food day:   menu-one-photo-hero-kitchen-day-stacked (708:19545)
 *   Food night: menu-one-photo-hero-kitchen-night-stacked (734:20685)
 *   Bar:        menu-one-photo-hero-bar-stacked (735:22582)
 *
 * @param array $args {
 *     @type string $section      Active nav section slug (default: 'breakfast' for food, 'infusions' for drinks).
 *     @type string $menu_state   'food' or 'drinks' (default: 'food').
 * }
 */

$menu_state = $args['menu_state'] ?? 'food';
$images_uri = get_template_directory_uri() . '/assets/images/';

// ── Section word lists — inc/menu-sections.php (shared with the jump-nav and the mobile rail) ──
$food_sections = sweet_pepper_menu_sections( 'food' );
$bar_sections  = sweet_pepper_menu_sections( 'drinks' );

// ── Pick the active sections based on menu state ──
$is_drinks    = ( $menu_state === 'drinks' );
$sections     = $is_drinks ? $bar_sections : $food_sections;
$section      = $args['section'] ?? ( $is_drinks ? 'infusions' : 'breakfast' );

// Build JSON data for the JS module (active sections + door target)
$sections_json = [];
foreach ( $sections as $slug => $sec ) {
    $sections_json[ $slug ] = [
        'label'       => $sec['label'],
        'ctaLabel'    => $sec['cta_label'] ?? $sec['label'],
        'iconSvg'     => sweet_pepper_inline_svg( 'assets/icons/c-' . ( $sec['icon'] ?? 'food' ) . '.svg' ),
        'image'       => $images_uri . $sec['image'],
        'caption'     => $sec['caption'],
        'description' => $sec['description'],
        'focus'       => $sec['focus'] ?? '50% 50%', // tablet 21:9 crop — inc/menu-sections.php
    ];
}

// Add the cross-menu door hover entry
if ( $is_drinks ) {
    // FOOD door on bar page → show kitchen intro
    $sections_json['food'] = [
        'label'       => 'Food',
        'image'       => $images_uri . 'food/breakfast/pepper-breakfast-2.jpg',
        'focus'       => '50% 60%',
        'caption'     => "Pepper's Breakfast",
        'description' => "The full kitchen — breakfast to dinner, soups to desserts, all cooked fresh and served at the bar or the table.",
    ];
} else {
    // DRINKS door on food page → show bar intro
    $sections_json['drinks'] = [
        'label'       => 'Drinks',
        'image'       => $images_uri . 'bar/coffee/cappuccino-icecream-1.jpg',
        'focus'       => '50% 50%',
        'caption'     => 'Cappuccino & Gelato',
        'description' => "House-made infusions, natural cocktails, local wines, and craft beer — the bar is a destination on its own. No syrup shortcuts.",
    ];
}

// Arrow glyph: inlined per instance via sweet_pepper_inline_svg() (unique clipPath ids —
// a shared id resolves to the first copy in the document, which on phones sits inside
// the hidden hero nav, so every later arrow clipped to nothing). $arrow_svg stays for
// the jump-nav's signature but is no longer echoed.
$arrow_svg = '';

$default_sec   = $sections[ $section ];
$default_image = $images_uri . $default_sec['image'];
$default_focus = $default_sec['focus'] ?? '50% 50%';

// Phone and tablet strings (≤ 991px, Figma menu-one-photo-hero-kitchen-day-stacked-mobile 2109:130201).
// The nav panel is gone there; a flush-left Lime button opens the jump-nav panel instead
// ("More plates" as drawn; the drinks twin is a placeholder — see website-brief.md → Mobile — Menu page),
// and a full-width primary commits to the default section (the touch exception: preview and
// commit are two objects on touch). Connector SVGs: foodMenu / drinksMenu.
$open_label   = $is_drinks ? 'More pours' : 'More plates';
$connector    = $is_drinks
    ? [ 'day' => 'assets/sectionLinks/menu/bar/drinksMenu.svg', 'night' => 'assets/sectionLinks/menu/bar/drinksMenu.svg', 'alt' => 'DRINKS MENU' ]
    : [ 'day' => 'assets/sectionLinks/menu/kitchen-day/foodMenu.svg', 'night' => 'assets/sectionLinks/menu/kitchen-night/foodMenu.svg', 'alt' => 'FOOD MENU' ];

// Door config
$door_label = $is_drinks ? 'Food' : 'Drinks';
$door_href  = $is_drinks ? home_url( '/menu/' ) : home_url( '/menu/?menu=drinks' );
$door_slug  = $is_drinks ? 'food' : 'drinks';
?>

<section class="menu-hero"
         data-menu-state="<?php echo esc_attr( $menu_state ); ?>"
         data-default-section="<?php echo esc_attr( $section ); ?>">

    <!-- Section data for JS -->
    <script type="application/json" class="menu-hero__data"><?php echo wp_json_encode( $sections_json ); ?></script>

    <!-- Preload all section images -->
    <?php foreach ( $sections as $slug => $sec ) :
        if ( $slug === $section ) continue; // Default image loads eagerly
    ?>
        <link rel="prefetch" href="<?php echo esc_url( $images_uri . $sec['image'] ); ?>" as="image">
    <?php endforeach; ?>

    <!-- Phones and tablets: opens the jump-nav panel (the hero's word list has no room below 992px) -->
    <div class="menu-hero__page-nav">
        <?php
        get_template_part( 'template-parts/components/button', null, [
            'label'     => $open_label,
            'type'      => 'primary-green',
            'icon_left_svg' => 'icons/c-kebab.svg', // the author's kebab (assets/icons/kebab.svg) as a currentColor twin
            'class'     => 'menu-hero__open js-menu-jump-open',
        ] );
        ?>
    </div>

    <div class="menu-hero__inner">

        <!-- ═══ LEFT: Nav Panel ═══ -->
        <div class="menu-hero__nav">
            <!-- Background layers -->
            <div class="menu-hero__nav-bg menu-hero__nav-bg--lime" aria-hidden="true"></div>
            <div class="menu-hero__nav-bg menu-hero__nav-bg--parchment" aria-hidden="true"></div>

            <!-- Section word list -->
            <nav class="menu-hero__nav-list" aria-label="Menu sections">
                <?php foreach ( $sections as $slug => $sec ) :
                    $is_active   = ( $slug === $section );
                    $nav_variant = $sec['nav_variant'] ?? 'default';
                ?>
                    <a href="#<?php echo esc_attr( $slug ); ?>"
                       class="menu-hero__nav-item<?php echo $is_active ? ' is-active' : ''; ?>"
                       data-section="<?php echo esc_attr( $slug ); ?>"
                       data-nav-variant="<?php echo esc_attr( $nav_variant ); ?>"
                       <?php echo $is_active ? 'aria-current="true"' : ''; ?>>
                        <span class="menu-hero__nav-label molot-text"><?php echo esc_html( $sec['label'] ); ?></span>
                        <span class="menu-hero__nav-arrow" aria-hidden="true">
                            <?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
            </nav>

            <!-- Door: links to the other menu (DRINKS ↔ FOOD) -->
            <a href="<?php echo esc_url( $door_href ); ?>"
               class="menu-hero__door"
               data-door-target="<?php echo esc_attr( $door_slug ); ?>">
                <span class="menu-hero__door-hinge" aria-hidden="true"></span>
                <span class="menu-hero__door-icon" aria-hidden="true">
                    <?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?>
                </span>
                <span class="menu-hero__door-label molot-text"><?php echo esc_html( $door_label ); ?></span>
            </a>
        </div>

        <!-- ═══ RIGHT: Content ═══ -->
        <div class="menu-hero__content">

            <!-- Photo stack -->
            <div class="menu-hero__photo">
                <!-- Colored offset sheets (behind the photo) -->
                <div class="menu-hero__photo-sheet menu-hero__photo-sheet--chili" aria-hidden="true"></div>
                <div class="menu-hero__photo-sheet menu-hero__photo-sheet--lime" aria-hidden="true"></div>
                <div class="menu-hero__photo-sheet menu-hero__photo-sheet--lemon" aria-hidden="true"></div>

                <!-- Photo with keyline -->
                <div class="menu-hero__photo-frame">
                    <img src="<?php echo esc_url( $default_image ); ?>"
                         alt="<?php echo esc_attr( $default_sec['caption'] ); ?>"
                         class="menu-hero__photo-img"
                         style="object-position: <?php echo esc_attr( $default_focus ); ?>"
                         loading="eager">
                    <span class="menu-hero__photo-pill">
                        <?php echo esc_html( $default_sec['caption'] ); ?>
                    </span>
                </div>
            </div>

            <!-- Description -->
            <p class="menu-hero__description"><?php echo esc_html( $default_sec['description'] ); ?></p>

            <!-- Phones and tablets: the commit action for the section on show (touch exception —
                 website-brief.md → Menu page → Hero → Touch exception). A word picked in the
                 jump-nav panel previews here (menu-hero.js listens for menu-hero:preview) and
                 this button follows it. -->
            <div class="menu-hero__commit">
                <?php
                get_template_part( 'template-parts/components/button', null, [
                    'label'         => $default_sec['cta_label'] ?? $default_sec['label'],
                    'url'           => '#' . $section,
                    'type'          => 'primary',
                    'icon_left_svg' => 'icons/c-' . ( $default_sec['icon'] ?? 'food' ) . '.svg',
                    'class'         => 'menu-hero__commit-btn',
                ] );
                ?>
            </div>

        </div>
    </div>

    <!-- Phones and tablets: connector at the hero's foot (its reflection opens the next section —
         page-menu.php). Replaces the room wordmark below 992px. -->
    <div class="container menu-hero__connector">
        <?php
        get_template_part( 'template-parts/components/section-link-word', null, [
            'day_img'   => $connector['day'],
            'night_img' => $connector['night'],
            'alt'       => $connector['alt'],
            'class'     => 'section-link-word--reflection',
        ] );
        ?>
    </div>

    <!-- FOOD/DRINKS wordmark — positioned absolute at bottom of hero -->
    <div class="menu-hero__wordmark">
        <span class="molot-text"><?php echo $is_drinks ? 'DRINKS' : 'FOOD'; ?></span>
    </div>
</section>

<?php
// Sticky jump-nav (edge tab + panel) — same word list and door as the hero,
// shown by JS once the hero nav has scrolled away. website-brief.md → Sticky jump-nav.
get_template_part( 'template-parts/components/menu-jump-nav', null, [
    'sections'   => $sections,
    'section'    => $section,
    'menu_state' => $menu_state,
    'door_label' => $door_label,
    'door_href'  => $door_href,
    'door_slug'  => $door_slug,
    'arrow_svg'  => $arrow_svg,
] );
