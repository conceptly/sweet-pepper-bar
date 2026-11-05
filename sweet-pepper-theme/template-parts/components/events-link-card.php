<?php
/**
 * Template part for the "See all events" link card
 *
 * Occupies the 6th slot in the events grid.
 * Background photo with dark overlay and centered text.
 *
 * @param array $args {
 *     @type string $image_url  URL of the background photo.
 *     @type string $image_alt  Unused: the photo is a backdrop for the link's own words, so it is
 *                              decorative (alt="") — an alt would be read before the label.
 *     @type string $label      Link text (e.g. "See all events →").
 *     @type string $url        Link to VK community page.
 * }
 */

$image_url = $args['image_url'] ?? '';
$image_alt = $args['image_alt'] ?? '';
$label     = $args['label'] ?? 'See all events →';
$url       = $args['url'] ?? '#';
?>
<a class="events-link-card" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
    <?php if ( $image_url ) : ?>
        <img src="<?php echo esc_url( $image_url ); ?>" alt="" class="events-link-card-img" loading="lazy">
    <?php endif; ?>

    <div class="events-link-card-overlay"></div>

    <span class="events-link-card-text"><?php echo esc_html( $label ); ?></span>
</a>
