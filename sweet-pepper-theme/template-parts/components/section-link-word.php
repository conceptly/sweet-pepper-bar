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

// A food-menu connector on a Russian request swaps to its RU twin (inc/menu-sections.php).
if ( function_exists( 'sweet_pepper_menu_connector_lang' ) ) {
    [ $day_img, $night_img, $alt ] = sweet_pepper_menu_connector_lang( $day_img, $night_img, $alt );
}

$link_word_images = [
    'link-word-day'   => $day_img,
    'link-word-night' => $night_img,
];
?>
<div class="section-link-word <?php echo esc_attr( $class ); ?>">
    <?php foreach ( $link_word_images as $img_class => $img_path ) : ?>
        <?php
        if ( ! $img_path ) {
            continue;
        }
        $dims = function_exists( 'sweet_pepper_svg_dimensions' ) ? sweet_pepper_svg_dimensions( $img_path ) : null;
        ?>
        <img src="<?php echo esc_url( get_template_directory_uri() . '/' . $img_path ); ?>"
             alt="<?php echo esc_attr( $alt ); ?>"
             class="<?php echo esc_attr( $img_class ); ?>"
             <?php if ( $dims ) : ?>width="<?php echo (int) $dims['width']; ?>" height="<?php echo (int) $dims['height']; ?>"<?php endif; ?>
             loading="<?php echo esc_attr( $loading ); ?>">
    <?php endforeach; ?>
</div>
