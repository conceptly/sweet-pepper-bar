<?php
/**
 * Template part for displaying a highlight dish card
 *
 * @param array $args {
 *     @type string $image_url   URL of the dish image.
 *     @type string $image_alt   Alt text for the image.
 *     @type string $title       Dish title.
 *     @type string $price       Dish price (e.g. "150-.").
 *     @type string $description Dish description.
 *     @type string $tag_icon    Name of custom SVG icon in assets/icons/ (e.g. "star").
 *     @type string $tag_label   Text for the tag (e.g. "Seasonal hits").
 *     @type string $url         Destination on the menu page. When set the card renders
 *                               as an <a> rather than a <div>; see the note below.
 * }
 */

$image_url   = $args['image_url'] ?? '';
$image_alt   = $args['image_alt'] ?? '';
$title       = $args['title'] ?? '';
$price       = $args['price'] ?? '';
$description = $args['description'] ?? '';
$tag_icon    = $args['tag_icon'] ?? '';
$tag_label   = $args['tag_label'] ?? '';
$url         = $args['url'] ?? '';

/* A card is a door (website-brief.md → Typography on the web → Interaction rule), so when
   it has somewhere to go it is a real <a>. It used to be a <div> carrying cursor: pointer —
   it looked clickable, was not, and no keyboard could reach it. Cards without a url keep the
   <div> so the component stays usable for a display-only card. */
$card_tag        = $url ? 'a' : 'div';
$card_attributes = $url ? ' href="' . esc_url( $url ) . '"' : '';
?>
<<?php echo $card_tag . $card_attributes; ?> class="highlight-card">
    <div class="highlight-card-img-wrap">
        <?php if ( $image_url ) : ?>
            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="highlight-card-img" loading="lazy">
        <?php endif; ?>
    </div>
    
    <div class="highlight-card-content">
        <div class="highlight-card-header">
            <h3 class="highlight-card-title molot-text"><?php echo esc_html( $title ); ?></h3>
            <?php if ( $price ) : ?>
                <span class="highlight-card-price"><?php echo esc_html( $price ); ?></span>
            <?php endif; ?>
        </div>
        
        <?php if ( $description ) : ?>
            <p class="highlight-card-desc"><?php echo wp_kses_post( $description ); ?></p>
        <?php endif; ?>
        
        <?php if ( $tag_label ) : ?>
            <div class="highlight-card-tag">
                <?php if ( $tag_icon ) : 
                    $icon_path = get_template_directory() . '/assets/icons/' . $tag_icon . '.svg';
                    if ( file_exists( $icon_path ) ) : ?>
                        <span class="tag-icon"><?php echo file_get_contents( $icon_path ); ?></span>
                    <?php endif;
                endif; ?>
                <span class="tag-label"><?php echo esc_html( $tag_label ); ?></span>
            </div>
        <?php endif; ?>
    </div>
</<?php echo $card_tag; ?>>
