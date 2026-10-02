<?php
/**
 * Template part for displaying a dish row
 *
 * Maps to Figma: dishRow component (219:2737).
 * Reusable across bar/kitchen/menu pages.
 *
 * @param array $args {
 *     @type string   $dish_name       Dish name (required).
 *     @type string   $price           Price string, e.g. "150-. / 1300-.".
 *     @type string   $quantity        Quantity/volume, e.g. "40 ml / 500 ml". Optional.
 *     @type string   $description     Short dish description. Optional.
 *     @type array    $icons           Array of icon SVG filenames from assets/icons/. Optional.
 *     @type string   $seasonal_label  Seasonal badge text, e.g. "Summer'26!". Optional.
 *     @type string   $season          'summer' | 'fall' | 'winter' — the badge's colours. Optional:
 *                                     read from the label when absent (sweet_pepper_badge_season()).
 *     @type array    $options         Array of option strings (bulleted sub-items). Optional.
 * }
 *
 * No highlighted names since 2 Oct 2026 (author, after testing; Figma dishRow 219:2737 draws
 * highlight On and Off alike): a hit is said by the star, not by an Avocado / Lime name. A
 * `highlight` arg still passed by older data is ignored.
 */

$dish_name      = $args['dish_name'] ?? '';
$price          = $args['price'] ?? '';
$quantity       = $args['quantity'] ?? '';
$description    = $args['description'] ?? '';
$icons          = $args['icons'] ?? [];
$seasonal_label = $args['seasonal_label'] ?? '';
$season         = $args['season'] ?? ( function_exists( 'sweet_pepper_badge_season' ) ? sweet_pepper_badge_season( $seasonal_label ) : '' );
$options        = $args['options'] ?? [];

// The four dish icons have fixed meanings (design.md → Dish icons) and nothing else on the
// row says them, so each is announced by name. Each takes its own colour (Figma dishRowIcons
// 2831:73579) through `.dish-icon--<value>`.
$icon_labels = [
    'veg'            => __( 'Vegetarian', 'sweet-pepper' ),
    'fire'           => __( 'House hit', 'sweet-pepper' ),
    'Pepper'         => __( 'Spicy', 'sweet-pepper' ),
    'yaroslavl-logo' => __( 'Local Yaroslavl dish', 'sweet-pepper' ),
];

// The hit is drawn as a star since 2 Oct 2026 (author: fire read as spicy too). The saved value
// stays `fire` on every site — no migration; only the file and the admin label changed.
$icon_files = [ 'fire' => 'star' ];
?>
<div class="dish-row">
    <div class="dish-info">
        <div class="dish-name-row">
            <span class="dish-name"><?php echo esc_html( $dish_name ); ?></span>
            
            <?php foreach ( $icons as $icon_name ) : 
                $icon_file = $icon_files[ $icon_name ] ?? $icon_name;
                $icon_path = get_template_directory() . '/assets/icons/' . $icon_file . '.svg';
                if ( file_exists( $icon_path ) ) : ?>
                    <span class="dish-icon dish-icon--<?php echo esc_attr( $icon_name ); ?>"><?php echo sweet_pepper_inline_svg( 'assets/icons/' . $icon_file . '.svg', $icon_labels[ $icon_name ] ?? '' ); ?></span>
                <?php endif;
            endforeach; ?>
            
            <?php if ( $seasonal_label ) : ?>
                <span class="dish-seasonal-badge<?php echo $season ? ' dish-seasonal-badge--' . esc_attr( $season ) : ''; ?>"><?php echo esc_html( $seasonal_label ); ?></span>
            <?php endif; ?>
            
            <?php if ( $quantity ) : ?>
                <span class="dish-quantity"><?php echo esc_html( $quantity ); ?></span>
            <?php endif; ?>
        </div>
        
        <?php if ( $description ) : ?>
            <p class="dish-description"><?php echo esc_html( $description ); ?></p>
        <?php endif; ?>
        
        <?php if ( ! empty( $options ) ) : ?>
            <div class="dish-options">
                <?php foreach ( $options as $option ) : ?>
                    <div class="dish-option">
                        <span class="dish-option-bullet"></span>
                        <span class="dish-option-text"><?php echo esc_html( $option ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <span class="dish-price"><?php echo esc_html( $price ); ?></span>
</div>
