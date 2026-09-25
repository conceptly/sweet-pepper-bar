<?php
/**
 * Template part for displaying a menu highlight card (seasonal strip)
 *
 * Maps to Figma: menuHighlightCard (812:25373).
 * A tilted dish card with photo, title, and cross-link to the menu section.
 * Different from highlight-card.php (home page) — no price/description/tag,
 * playful tilt, smaller shadow, section-link instead.
 *
 * @param array $args {
 *     @type string $image_url   URL of the dish image.
 *     @type string $image_alt   Alt text for the image.
 *     @type string $title       Dish title (e.g. "Gazpacho").
 *     @type string $link_label  Link text (e.g. "Show in Soups").
 *     @type string $link_label_mobile  Shorter link text for the phone 2-up grid (e.g. "In Soups"); shown ≤ 767px. Optional.
 *     @type string $link_url    Anchor link (e.g. "#soups"). With a label, the whole card is the
 *                               link (author, 25 Sep 2026) and takes the card states (components.css
 *                               → Card states); without one it is a plain card — no pressed state.
 *     @type string $tilt        Tilt direction: 'left' (default, -1deg) or 'right' (+1deg).
 * }
 */

$image_url  = $args['image_url'] ?? '';
$image_alt  = $args['image_alt'] ?? '';
$title      = $args['title'] ?? '';
$link_label = $args['link_label'] ?? '';
$link_label_mobile = $args['link_label_mobile'] ?? '';
$link_url   = $args['link_url'] ?? '';
$tilt       = $args['tilt'] ?? 'left';

$tilt_class = $tilt === 'right' ? 'menu-highlight-card__inner--tilt-right' : 'menu-highlight-card__inner--tilt-left';
$is_link    = $link_label && $link_url && '#' !== $link_url;
$inner_tag  = $is_link ? 'a' : 'div';
?>
<div class="menu-highlight-card">
    <<?php echo $inner_tag; ?> class="menu-highlight-card__inner <?php echo esc_attr( $tilt_class ); ?><?php echo $is_link ? ' is-link' : ''; ?>"<?php echo $is_link ? ' href="' . esc_url( $link_url ) . '"' : ''; ?>>
        <div class="menu-highlight-card__img-wrap">
            <?php if ( $image_url ) : ?>
                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="menu-highlight-card__img" loading="lazy">
            <?php endif; ?>
        </div>

        <div class="menu-highlight-card__content">
            <h3 class="menu-highlight-card__title molot-text"><?php echo esc_html( $title ); ?></h3>

            <?php if ( $link_label ) : // the card is the <a>; the line keeps its link look ?>
                <span class="menu-highlight-card__link">
                    <span class="menu-highlight-card__link-label<?php echo $link_label_mobile ? ' menu-highlight-card__link-label--desktop' : ''; ?>"><?php echo esc_html( $link_label ); ?></span>
                    <?php if ( $link_label_mobile ) : ?>
                        <span class="menu-highlight-card__link-label menu-highlight-card__link-label--mobile"><?php echo esc_html( $link_label_mobile ); ?></span>
                    <?php endif; ?>
                    <span class="menu-highlight-card__link-icon">
                        <?php
                        // Per-instance ids (inc/inline-svg.php) — a shared clipPath id clips to nothing
                        // when its first copy on the page is hidden (the phone nav drawer).
                        echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' );
                        ?>
                    </span>
                </span>
            <?php endif; ?>
        </div>
    </<?php echo $inner_tag; ?>>
</div>
