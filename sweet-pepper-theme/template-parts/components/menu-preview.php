<?php
/**
 * Template part for displaying a menu preview section (bar or kitchen)
 *
 * Maps to Figma: menuBarSection / menuKitchenSection.
 * Layout flips between text-left (bar) and image-left (kitchen).
 *
 * @param array $args {
 *     @type string $layout       "text-left" or "image-left". Default: "text-left".
 *     @type string $title        Section title (Molot H2), e.g. "HOME MADE INFUSIONS".
 *     @type array  $dishes       Array of dish arrays to pass to dish-row component.
 *     @type array  $cta          CTA button args array (label, url, icon_left, icon_right, type).
 *     @type string $cta_align    "left" or "right". Default: "left".
 *     @type string $image_url    Image URL.
 *     @type string $image_alt    Image alt text.
 *     @type string $image_badge  Badge text overlaid on image (e.g. "Community hit!"). Optional.
 * }
 */

$layout      = $args['layout'] ?? 'text-left';
$title       = $args['title'] ?? '';
$dishes      = $args['dishes'] ?? [];
$cta         = $args['cta'] ?? [];
$cta_align   = $args['cta_align'] ?? 'left';
$image_url   = $args['image_url'] ?? '';
$image_alt   = $args['image_alt'] ?? '';
$image_badge = $args['image_badge'] ?? '';

$layout_class = ( $layout === 'image-left' ) ? 'menu-preview--image-left' : 'menu-preview--text-left';
$cta_class    = ( $cta_align === 'right' ) ? 'menu-preview-cta--right' : '';
?>
<div class="menu-preview-content <?php echo esc_attr( $layout_class ); ?>">
    <!-- Text Side -->
    <div class="menu-preview-split menu-preview-text">
        <div class="menu-preview-menu">
            <?php if ( $title ) : ?>
                <h2 class="menu-preview-title molot-text"><?php echo wp_kses_post( $title ); ?></h2>
            <?php endif; ?>
            
            <div class="dishes-container">
                <?php foreach ( $dishes as $dish ) {
                    get_template_part( 'template-parts/components/dish-row', null, $dish );
                } ?>
            </div>
        </div>
        
        <?php if ( ! empty( $cta ) ) : ?>
            <div class="menu-preview-cta <?php echo esc_attr( $cta_class ); ?>">
                <?php get_template_part( 'template-parts/components/button', null, $cta ); ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Image Side -->
    <div class="menu-preview-split menu-preview-image">
        <div class="menu-preview-img-wrap">
            <img class="menu-preview-img" 
                 src="<?php echo esc_url( $image_url ); ?>" 
                 alt="<?php echo esc_attr( $image_alt ); ?>"
                 loading="lazy">
            
            <?php if ( $image_badge ) : ?>
                <span class="menu-preview-badge"><?php echo esc_html( $image_badge ); ?></span>
            <?php endif; ?>
        </div>
    </div>
</div>
