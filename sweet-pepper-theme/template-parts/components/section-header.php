<?php
/**
 * Template part for displaying a section header
 *
 * Maps to Figma: sectionTitleContainer + sectionTitle.
 *
 * @param array $args {
 *     @type string $eyebrow       The eyebrow/subtitle text (e.g. "YOU CAN'T MISS IT").
 *     @type string $headline      The main headline line (Chili colour).
 *     @type string $headline_2    Optional second headline line (Paprika colour). Omit to hide.
 *     @type string $description   The description paragraph. Omit to hide.
 *     @type string $description_mobile  Optional shorter paragraph for phones (≤ 767px); when set it
 *                                       replaces $description there (components.css → Section header on phones).
 *     @type array  $ctas          Array of CTA arrays to pass to button component.
 * }
 */

$eyebrow     = $args['eyebrow'] ?? '';
$headline    = $args['headline'] ?? '';
$headline_2  = $args['headline_2'] ?? '';
$description = $args['description'] ?? '';
$description_mobile = $args['description_mobile'] ?? '';
$ctas        = $args['ctas'] ?? [];
?>
<div class="section-header">
    <div class="section-title-block">
        <?php if ( $eyebrow ) : ?>
            <span class="section-eyebrow molot-text"><?php echo wp_kses_post( $eyebrow ); ?></span>
        <?php endif; ?>
        
        <div class="section-headline-group">
            <?php if ( $headline ) : ?>
                <h2 class="section-headline molot-text"><?php echo wp_kses_post( $headline ); ?></h2>
            <?php endif; ?>
            
            <?php if ( $headline_2 ) : ?>
                <p class="section-headline-2 molot-text"><?php echo wp_kses_post( $headline_2 ); ?></p>
            <?php endif; ?>
        </div>
        
        <?php if ( $description ) : ?>
            <p class="section-description"><?php echo wp_kses_post( $description ); ?></p>
        <?php endif; ?>

        <?php if ( $description_mobile ) : ?>
            <p class="section-description section-description--mobile"><?php echo wp_kses_post( $description_mobile ); ?></p>
        <?php endif; ?>
    </div>
    
    <?php if ( ! empty( $ctas ) ) : ?>
        <div class="section-ctas">
            <?php 
            foreach ( $ctas as $cta ) {
                get_template_part( 'template-parts/components/button', null, $cta );
            }
            ?>
        </div>
    <?php endif; ?>
</div>
