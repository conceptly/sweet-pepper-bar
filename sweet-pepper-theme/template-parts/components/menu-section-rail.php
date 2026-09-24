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
 *     @type string $headline  Headline text if it differs from the nav word. Optional — by
 *                             default the section's own (sweet_pepper_menu_sections() →
 *                             headline: "For Little Peppers", «На первое»; field or typed).
 *                             Desktop only: in the rail (≤ 991px) the current word is the
 *                             nav word, like every other word in it — a tab that renames
 *                             itself when chosen reads as a different place, and the long
 *                             headlines ("Sandwiches & Bagels") filled the row, so the next
 *                             word never peeked (author, 20 Sep 2026).
 * }
 */

$current  = $args['current'] ?? '';
$state    = sweet_pepper_menu_state_for( $current );
$sections = sweet_pepper_menu_sections( $state );

if ( ! isset( $sections[ $current ] ) ) {
    return;
}

$label    = $sections[ $current ]['label'];
$headline = $args['headline'] ?? ( $sections[ $current ]['headline'] ?? $label );

// Canonical order, the current word in place: the rail is scrolled so the current word
// sits at the left gutter and the sections before it are reachable by scrolling left
// (menu-single-section.js → alignRail()). Figma carousel-food 1409:50231.
?>
<div class="menu-section-rail" data-menu-state="<?php echo esc_attr( $state ); ?>">
    <nav class="menu-section-rail__nav" aria-label="<?php esc_attr_e( 'Menu sections', 'sweet-pepper' ); ?>">
        <?php foreach ( $sections as $slug => $sec ) : ?>
            <?php if ( $slug === $current ) : ?>
                <h2 class="section-headline molot-text menu-section-rail__item menu-section-rail__current">
                    <?php if ( $headline !== $label ) : // one is display: none at any width (menu-section.css) ?>
                        <span class="menu-section-rail__long"><?php echo esc_html( $headline ); ?></span><span class="menu-section-rail__short"><?php echo esc_html( $label ); ?></span>
                    <?php else : ?>
                        <?php echo esc_html( $headline ); ?>
                    <?php endif; ?>
                </h2>
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
