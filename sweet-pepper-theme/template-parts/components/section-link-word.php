<?php
/**
 * Template part for displaying a section link word (outline SVG text)
 *
 * website-brief.md → Section connectors: always an SVG, full container width.
 * Each <img> carries the SVG's intrinsic width/height so the band reserves
 * its height before the (lazy) file loads — anchor scrolls on the menu page
 * would otherwise land short by the height of every connector above the target.
 *
 * @param array $args {
 *     @type string $day_img   Path relative to theme root for the day mode image.
 *     @type string $night_img Path relative to theme root for the night mode image.
 *     @type string $alt       Alt text for the image.
 *     @type string $class     Optional extra CSS class.
 *     @type string $loading   'lazy' (default) or 'eager' — eager for a word in the first viewport.
 * }
 */

$day_img   = $args['day_img'] ?? '';
$night_img = $args['night_img'] ?? '';
$alt       = $args['alt'] ?? '';
$class     = $args['class'] ?? '';
$loading   = ( $args['loading'] ?? 'lazy' ) === 'eager' ? 'eager' : 'lazy';

// A menu or home connector on a Russian request swaps to its RU twin (inc/menu-sections.php, inc/home-data.php).
// Either swap may add a shorter phone word (RU, 6 Oct 2026): a <source> for ≤ 767px, so a phone loads only it
$phone_imgs = [];
foreach ( [ 'sweet_pepper_menu_connector_lang', 'sweet_pepper_home_connector_lang' ] as $swap ) {
    if ( ! function_exists( $swap ) ) {
        continue;
    }
    $swapped = $swap( $day_img, $night_img, $alt );
    [ $day_img, $night_img, $alt ] = $swapped;
    if ( isset( $swapped[3], $swapped[4] ) ) {
        $phone_imgs = [ 'link-word-day' => $swapped[3], 'link-word-night' => $swapped[4] ];
    }
}

// A reflection repeats the word just read above it — it is drawn, not said again.
$is_reflection = false !== strpos( $class, 'section-link-word--reflection' );
if ( $is_reflection ) {
    $alt = '';
}

$link_word_images = [
    'link-word-day'   => $day_img,
    'link-word-night' => $night_img,
];
?>
<div class="section-link-word <?php echo esc_attr( $class ); ?>"<?php echo $is_reflection ? ' aria-hidden="true"' : ''; ?>>
    <?php foreach ( $link_word_images as $img_class => $img_path ) : ?>
        <?php
        if ( ! $img_path ) {
            continue;
        }
        $dims = function_exists( 'sweet_pepper_svg_dimensions' ) ? sweet_pepper_svg_dimensions( $img_path ) : null;
        $phone = $phone_imgs[ $img_class ] ?? '';
        $phone_dims = $phone && function_exists( 'sweet_pepper_svg_dimensions' ) ? sweet_pepper_svg_dimensions( $phone ) : null;
        ?>
        <?php if ( $phone ) : // width/height on the <source> give the phone file its own aspect ratio ?>
        <picture>
        <source media="(max-width: 767px)" srcset="<?php echo esc_url( get_template_directory_uri() . '/' . $phone ); ?>"<?php if ( $phone_dims ) : ?> width="<?php echo (int) $phone_dims['width']; ?>" height="<?php echo (int) $phone_dims['height']; ?>"<?php endif; ?>>
        <?php endif; ?>
        <img src="<?php echo esc_url( get_template_directory_uri() . '/' . $img_path ); ?>"
             alt="<?php echo esc_attr( $alt ); ?>"
             class="<?php echo esc_attr( $img_class ); ?>"
             <?php if ( $dims ) : ?>width="<?php echo (int) $dims['width']; ?>" height="<?php echo (int) $dims['height']; ?>"<?php endif; ?>
             loading="<?php echo esc_attr( $loading ); ?>">
        <?php if ( $phone ) : ?>
        </picture>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
