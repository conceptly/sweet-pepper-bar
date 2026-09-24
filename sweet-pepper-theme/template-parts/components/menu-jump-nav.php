<?php
/**
 * Menu Jump-Nav — edge tab + slide-in panel
 *
 * website-brief.md → Menu page → Sticky jump-nav (decided Jul 2026).
 * Figma: btnFixed-left (820:29398) for the tab; the panel is a reprise of
 * the hero nav panel (menu-hero__nav), so it reuses those classes verbatim
 * and inherits every day / night / drinks override from menu-hero.css.
 *
 * Rendered by menu-hero.php right after the hero section, which passes the
 * same section data it uses for its own word list (single source).
 *
 * The tab slides in only once the hero's side-nav has scrolled away
 * (src/js/menu-jump-nav.js) — while the hero nav is on screen it would
 * duplicate it.
 *
 * @param array $args {
 *     @type array  $sections    slug => [ label, nav_variant ] (same array as the hero).
 *     @type string $section     Default active slug.
 *     @type string $menu_state  'food' | 'drinks'.
 *     @type string $door_label  'Drinks' | 'Food'.
 *     @type string $door_href   URL of the other menu.
 *     @type string $door_slug   'drinks' | 'food'.
 *     @type string $arrow_svg   Inline SVG for the arrow glyph.
 * }
 */

$sections   = $args['sections']   ?? [];
$section    = $args['section']    ?? '';
$menu_state = $args['menu_state'] ?? 'food';
$door_label = $args['door_label'] ?? 'Drinks';
$door_href  = $args['door_href']  ?? sweet_pepper_menu_url( 'drinks' );
$door_slug  = $args['door_slug']  ?? 'drinks';
$arrow_svg  = $args['arrow_svg']  ?? '';

if ( empty( $sections ) ) {
    return;
}

$is_drinks = ( $menu_state === 'drinks' );
$tab_label = $is_drinks ? __( 'Drinks Menu', 'sweet-pepper' ) : __( 'Food Menu', 'sweet-pepper' );
$tab_aria  = $is_drinks ? __( 'Drinks Menu sections', 'sweet-pepper' ) : __( 'Food Menu sections', 'sweet-pepper' );
$tab_icon  = $is_drinks ? 'martini' : 'fork-knife';
?>

<!-- Jump-nav edge tab (left edge; twin of the Reserve tab on the right) -->
<div class="menu-jump__tab-wrap js-menu-jump-open" data-menu-state="<?php echo esc_attr( $menu_state ); ?>">
    <?php
    get_template_part( 'template-parts/components/button', null, [
        'label'      => $tab_label,
        'type'       => 'primary-green',
        'icon_right' => $tab_icon,
        'class'      => 'menu-jump__tab',
        'id'         => 'menu-jump-tab',
    ] );
    ?>
</div>

<!-- Scrim -->
<div class="menu-jump__scrim js-menu-jump-close" aria-hidden="true"></div>

<!-- Panel -->
<div class="menu-jump__panel"
     id="menu-jump-panel"
     role="dialog"
     aria-modal="true"
     aria-label="<?php echo esc_attr( $tab_aria ); ?>"
     aria-hidden="true"
     data-menu-state="<?php echo esc_attr( $menu_state ); ?>"
     data-default-section="<?php echo esc_attr( $section ); ?>">

    <div class="menu-hero__nav menu-jump__sheet">
        <div class="menu-hero__nav-bg menu-hero__nav-bg--lime" aria-hidden="true"></div>
        <div class="menu-hero__nav-bg menu-hero__nav-bg--parchment" aria-hidden="true"></div>

        <button type="button" class="menu-jump__close js-menu-jump-close" aria-label="<?php esc_attr_e( 'Close menu sections', 'sweet-pepper' ); ?>">
            <i class="ph ph-x" aria-hidden="true"></i>
        </button>

        <!-- Scroll region: word list + door. Centred when there is room,
             top-aligned (and scrollable) on short viewports. -->
        <div class="menu-jump__scroll">
        <nav class="menu-hero__nav-list" aria-label="<?php esc_attr_e( 'Jump to a menu section', 'sweet-pepper' ); ?>">
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

        <!-- Door: last item, mirroring rule (DRINKS exits →, FOOD returns ←) -->
        <a href="<?php echo esc_url( $door_href ); ?>"
           class="menu-hero__door"
           data-door-target="<?php echo esc_attr( $door_slug ); ?>">
            <span class="menu-hero__door-hinge" aria-hidden="true"></span>
            <span class="menu-hero__door-icon" aria-hidden="true">
                <?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?>
            </span>
            <span class="menu-hero__door-label molot-text"><?php echo esc_html( $door_label ); ?></span>
        </a>
        </div><!-- /.menu-jump__scroll -->
    </div>
</div>
