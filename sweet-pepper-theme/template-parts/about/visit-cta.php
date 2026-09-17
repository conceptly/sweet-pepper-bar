<?php
/**
 * About page — Visit CTA section
 *
 * Dark section (Peppercorn bg). Centered Lime headline (display 76px),
 * Lime subtitle body text, and two CTA buttons:
 * - ButtonPrimary-Green-Dark: "Get your table" + phone icon (🔶 label under consideration)
 * - ButtonSecondary-Dark:     "See the menu" + arrow icon
 *
 * @package Sweet_Pepper
 */
?>

<section class="about-section about-section--dark about-visit-cta">
    <div class="container">
        <h1 class="about-visit-cta__headline molot-text"><?php echo esc_html__( 'COME SIT WITH US', 'sweet-pepper' ); ?></h1>
        <p class="about-visit-cta__body"><?php echo esc_html__( 'The room is small and fills up — book ahead for evenings and weekends. Or just walk in and take your chances; the bar seats are for exactly that.', 'sweet-pepper' ); ?></p>
        <div class="about-visit-cta__buttons">
            <?php
            get_template_part( 'template-parts/components/button', null, [
                'label'          => __( 'Get your table', 'sweet-pepper' ), // 🔶 under consideration vs "Reserve a table" (website-brief.md → Mobile About → Open)
                'variant'        => 'primary-green',
                'type'           => 'primary-green',
                'class'          => 'js-reserve-trigger',
                'icon_right_svg' => 'icons/c-phone.svg',
            ] );

            get_template_part( 'template-parts/components/button', null, [
                'label'          => __( 'See the menu', 'sweet-pepper' ),
                'url'            => home_url( '/menu' ),
                'variant'        => 'secondary',
                'type'           => 'secondary',
                'class'          => 'btn-secondary--dark',
                'icon_right_svg' => 'icons/c-arrow-right-outline.svg',
            ] );
            ?>
        </div>
    </div>
</section>
