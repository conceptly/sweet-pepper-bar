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
        'image'       => $sec['image_url'],
        'caption'     => $sec['caption'],
        'description' => $sec['description'],
        'focus'       => $sec['focus'] ?? '50% 50%', // tablet 21:9 crop — inc/menu-sections.php
    ];
}

// The cross-menu door's hover entry: the page's own «Первый экран» fields — the word, the
// photo, its caption and the paragraph (inc/menu-page.php → sweet_pepper_menu_door()).
$door = sweet_pepper_menu_door( $menu_state );
$sections_json[ $door['slug'] ] = [
    'label'       => $door['label'],
    'image'       => $door['image'],
    'focus'       => $door['focus'],
    'caption'     => $door['caption'],
    'description' => $door['description'],
];
if ( ! empty( $door['night'] ) ) { // the night set — menu-hero.js swaps it in when <html data-theme="night">
    $sections_json[ $door['slug'] ]['night'] = $door['night'];
}

// Arrow glyph: inlined per instance via sweet_pepper_inline_svg() (unique clipPath ids —
// a shared id resolves to the first copy in the document, which on phones sits inside
// the hidden hero nav, so every later arrow clipped to nothing). $arrow_svg stays for
// the jump-nav's signature but is no longer echoed.
$arrow_svg = '';

$default_sec   = $sections[ $section ];
$default_image = $default_sec['image_url'];
$default_focus = $default_sec['focus'] ?? '50% 50%';

// The photo stack's direction for the first frame (menu-hero.css → Photo Stack, the home
// tile's --dir): the tilt and fan alternate with the word's position in the list, so
// neighbours lean apart; menu-hero.js keeps it in step with every swap.
$default_index = (int) array_search( $section, array_keys( $sections ), true );
$default_dir   = ( $default_index % 2 ) ? -1 : 1;

// Phone and tablet strings (≤ 991px, Figma menu-one-photo-hero-kitchen-day-stacked-mobile 2109:130201).
// The nav panel is gone there; a flush-left Lime button opens the jump-nav panel instead
// ("More plates" as drawn; the drinks twin is a placeholder — see website-brief.md → Mobile — Menu page),
// and a full-width primary commits to the default section (the touch exception: preview and
// commit are two objects on touch). Connector SVGs: foodMenu / drinksMenu.
$open_label   = $is_drinks ? __( 'More pours', 'sweet-pepper' ) : __( 'More plates', 'sweet-pepper' );
$connector    = $is_drinks
    ? [ 'day' => 'assets/sectionLinks/menu/bar/drinksMenu.svg', 'night' => 'assets/sectionLinks/menu/bar/drinksMenu.svg', 'alt' => __( 'Drinks menu', 'sweet-pepper' ) ]
    : [ 'day' => 'assets/sectionLinks/menu/kitchen-day/foodMenu.svg', 'night' => 'assets/sectionLinks/menu/kitchen-night/foodMenu.svg', 'alt' => __( 'Food menu', 'sweet-pepper' ) ];

// The room wordmark (desktop): FOOD / DRINKS, in Russian КУХНЯ ОТ ПЕРЦЕВ / БАР ОТ ПЕРЦЕВ
// (languages/ru_RU.l10n.php). Below 992px the foot connector stands in for it — an SVG pair
// like every connector; the Russian twins come from the author's exports through
// sweet_pepper_menu_connector_lang() (inc/menu-sections.php) once the files exist.
$wordmark = $is_drinks ? __( 'DRINKS', 'sweet-pepper' ) : __( 'FOOD', 'sweet-pepper' );

// Door config — the other menu's page (inc/menu-page.php: /menu/ ⇄ /menu/bar/)
$door_label = $door['label'];
$door_href  = $door['href'];
$door_slug  = $door['slug'];
?>

<section class="menu-hero"
         data-dir="<?php echo (int) $default_dir; ?>"
         data-menu-state="<?php echo esc_attr( $menu_state ); ?>"
         data-default-section="<?php echo esc_attr( $section ); ?>">

    <?php // The page's one <h1>: the hero shows a word list, a photo and the FOOD / DRINKS wordmark,
    // none of them a heading, so the page's search title («Меню кухни» / «Барное меню») names the
    // page for screen readers and search engines without changing the design. ?>
    <h1 class="screen-reader-text"><?php echo esc_html( sweet_pepper_menu_page_text( $menu_state, 'seo', 'title' ) ?: ( $is_drinks ? __( 'Drinks menu', 'sweet-pepper' ) : __( 'Food menu', 'sweet-pepper' ) ) ); ?></h1>

    <!-- Section data for JS -->
    <script type="application/json" class="menu-hero__data"><?php echo wp_json_encode( $sections_json ); ?></script>

    <!-- Preload all section images -->
    <?php foreach ( $sections as $slug => $sec ) :
        if ( $slug === $section ) continue; // Default image loads eagerly
    ?>
        <link rel="prefetch" href="<?php echo esc_url( $sec['image_url'] ); ?>" as="image">
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
            <nav class="menu-hero__nav-list" aria-label="<?php esc_attr_e( 'Menu sections', 'sweet-pepper' ); ?>">
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
              <div class="menu-hero__stack">
                <!-- Colour sheets (behind the photo) — the home tile's stack: three slots, far →
                     near; the colour in each slot and the fan's direction are the section's
                     recipe (menu-hero.css → Photo Stack) -->
                <div class="menu-hero__photo-sheet menu-hero__photo-sheet--far" aria-hidden="true"></div>
                <div class="menu-hero__photo-sheet menu-hero__photo-sheet--mid" aria-hidden="true"></div>
                <div class="menu-hero__photo-sheet menu-hero__photo-sheet--near" aria-hidden="true"></div>

                <!-- Photo with keyline — the card is the link to the section on show (brief → Menu
                     page → Hero → Anatomy); menu-hero.js keeps href and label in step with the swap.
                     The caption pill stays inert inside it: one tap target. -->
                <a class="menu-hero__photo-frame"
                   href="#<?php echo esc_attr( $section ); ?>"
                   aria-label="<?php echo esc_attr( $default_sec['label'] ); ?>">
                    <img src="<?php echo esc_url( $default_image ); ?>"
                         alt="<?php echo esc_attr( $default_sec['caption'] ); ?>"
                         class="menu-hero__photo-img"
                         style="object-position: <?php echo esc_attr( $default_focus ); ?>"
                         loading="eager">
                    <span class="menu-hero__photo-pill">
                        <?php echo esc_html( $default_sec['caption'] ); ?>
                    </span>
                </a>
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
            'loading'   => 'eager', // first viewport on phones, and the entrance parks it under a clip
        ] );
        ?>
    </div>

    <!-- FOOD/DRINKS wordmark — positioned absolute at bottom of hero -->
    <div class="menu-hero__wordmark">
        <span class="molot-text"><?php echo esc_html( $wordmark ); ?></span>
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
