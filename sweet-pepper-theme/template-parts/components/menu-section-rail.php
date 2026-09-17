<?php
/**
 * Menu Section Rail — the section headline plus, on phones, the other sections.
 *
 * Replaces the plain <h2> in every menu section. On desktop only the headline
 * renders (the other words are display: none). On phones (≤ 767px) it becomes a
 * horizontal snap rail in canonical order: the current section's word filled, the
 * others outlined links — the one-state vocabulary (outline = not current, fill =
 * current) already used by the hero nav. The rail is scrolled so the current word
 * sits at the left gutter; earlier sections are reachable by scrolling left, later
 * ones peek at the right edge (Figma carousel-food 1409:50231). On phones the rail
 * is sticky under the header (menu-section.css) and switches the section on show
 * (menu-single-section.js).
 *
 * @param array $args {
 *     @type string $current   Slug of this section (required; matches the <section id>).
 *     @type string $headline  Headline text if it differs from the nav word
 *                             (e.g. "For Little Peppers" for kids). Optional.
 * }
 */

$current  = $args['current'] ?? '';
$state    = sweet_pepper_menu_state_for( $current );
$sections = sweet_pepper_menu_sections( $state );

if ( ! isset( $sections[ $current ] ) ) {
    return;
}

$headline = $args['headline'] ?? $sections[ $current ]['label'];

// Canonical order, the current word in place: the rail is scrolled so the current word
// sits at the left gutter and the sections before it are reachable by scrolling left
// (menu-single-section.js → alignRail()). Figma carousel-food 1409:50231.
?>
<div class="menu-section-rail" data-menu-state="<?php echo esc_attr( $state ); ?>">
    <nav class="menu-section-rail__nav" aria-label="<?php esc_attr_e( 'Menu sections', 'sweet-pepper' ); ?>">
        <?php foreach ( $sections as $slug => $sec ) : ?>
            <?php if ( $slug === $current ) : ?>
                <h2 class="section-headline molot-text menu-section-rail__item menu-section-rail__current"><?php echo esc_html( $headline ); ?></h2>
            <?php else : ?>
                <a href="#<?php echo esc_attr( $slug ); ?>"
                   class="menu-section-rail__item menu-section-rail__link molot-text"
                   data-section="<?php echo esc_attr( $slug ); ?>"
                   data-nav-variant="<?php echo esc_attr( $sec['nav_variant'] ?? 'default' ); ?>">
                    <?php echo esc_html( $sec['label'] ); ?>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </nav>
</div>
