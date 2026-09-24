<?php
/**
 * Menu page — "Come sit with us" (phones only)
 *
 * Figma: Visit CTA (2109:130264) in menu-browser-day. The phone menu page ends on a
 * reserve invitation before the footer; the desktop menu page has no such section, so
 * this renders ≤ 767px only (location.css). Copy is the About page's visit CTA; one
 * action, the reserve drawer (js-reserve-trigger), with the phone glyph as drawn.
 *
 * @package Sweet_Pepper
 */

// Russian headline and body: the About page's «Приглашение» fields — the same invitation
// (author, 23 Sep 2026: reuse About's Russian). English stays the strings below.
$about_page = 'ru' === sweet_pepper_lang() ? get_page_by_path( 'about' ) : null;
$about_cta  = $about_page ? sweet_pepper_about_cta( $about_page->ID ) : [];
?>

<section class="menu-visit-cta">
    <div class="container menu-visit-cta__inner">
        <div class="menu-visit-cta__text">
            <div class="section-title">
                <span class="section-eyebrow molot-text menu-visit-cta__eyebrow"><?php echo esc_html__( 'join the party', 'sweet-pepper' ); ?></span>
                <h2 class="section-headline molot-text menu-visit-cta__headline"><?php echo esc_html( ( $about_cta['headline'] ?? '' ) ?: __( 'Come sit with us', 'sweet-pepper' ) ); ?></h2>
            </div>
            <p class="menu-visit-cta__body"><?php echo esc_html( ( $about_cta['body'] ?? '' ) ?: __( 'The room is small and fills up — book ahead for evenings and weekends. Or just walk in and take your chances; the bar seats are for exactly that.', 'sweet-pepper' ) ); ?></p>
        </div>
        <div class="menu-visit-cta__actions">
            <?php
            get_template_part( 'template-parts/components/button', null, [
                'label'          => __( 'Reserve a table', 'sweet-pepper' ),
                'type'           => 'primary-green',
                'class'          => 'js-reserve-trigger',
                'icon_right_svg' => 'icons/c-phone.svg',
            ] );
            ?>
        </div>
    </div>
</section>
