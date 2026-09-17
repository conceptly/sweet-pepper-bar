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
 *     @type array    $options         Array of option strings (bulleted sub-items). Optional.
 *     @type bool     $highlight       Whether the dish name is highlighted (olive/lime). Default false.
 *                                     Set to true for hits, seasonal items, or featured dishes.
 * }
 */

$dish_name      = $args['dish_name'] ?? '';
$price          = $args['price'] ?? '';
$quantity       = $args['quantity'] ?? '';
$description    = $args['description'] ?? '';
$icons          = $args['icons'] ?? [];
$seasonal_label = $args['seasonal_label'] ?? '';
$options        = $args['options'] ?? [];
$highlight      = $args['highlight'] ?? false;

$row_class  = 'dish-row' . ( $highlight ? ' dish-row--highlight' : '' );
$name_class = 'dish-name' . ( $highlight ? ' dish-name--highlight' : '' );
?>
<div class="<?php echo esc_attr( $row_class ); ?>">
    <div class="dish-info">
        <div class="dish-name-row">
            <span class="<?php echo esc_attr( $name_class ); ?>"><?php echo esc_html( $dish_name ); ?></span>
            
            <?php foreach ( $icons as $icon_name ) : 
                $icon_path = get_template_directory() . '/assets/icons/' . $icon_name . '.svg';
                if ( file_exists( $icon_path ) ) : ?>
                    <span class="dish-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/' . $icon_name . '.svg' ); ?></span>
                <?php endif;
            endforeach; ?>
            
            <?php if ( $seasonal_label ) : ?>
                <span class="dish-seasonal-badge"><?php echo esc_html( $seasonal_label ); ?></span>
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
