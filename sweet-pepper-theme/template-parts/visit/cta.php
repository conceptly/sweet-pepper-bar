<?php
/**
 * Visit CTA Section — "We're All Ears"
 *
 * Dark section (Peppercorn bg). Composes:
 *  - Left: closure block (headline + photo + body + CTA buttons)
 *  - Right: contact form (dark variant — reuses contact-form.php)
 *
 * Phones (Form 1477:76522): the photo leaves the closure (the 21:9 band in page-visit.php
 * carries it), the two page links give way to the booking block — "Book your table",
 * Call on the bar-state engine, VK / Instagram half-width — and the form runs full-bleed on
 * Soft Peppercorn with topic chips. The booking block stays ABOVE the form (fast lane first,
 * visit-page-copy.md → Strategy).
 *
 * Words and the photo come as args from sweet_pepper_visit_cta() (inc/visit-data.php) — the
 * Visit page's «Обратная связь» tab. The booking block and the form's words go through the
 * dictionary (25 Sep 2026 — the drawer's booking words; forms-copy-ru-draft.md §2).
 *
 * @param array $args headline · body · photo (URL) · alt.
 *
 * @package Sweet_Pepper
 */
?>
<section class="visit-cta">
    <?php get_template_part( 'template-parts/visit/connector', null, [ 'word' => 'dropALittleNote', 'position' => 'head', 'alt' => 'Drop a little note' ] ); ?>

    <?php // Phones only (img 1441:72476): the entrance photo as a 21:9 band — the band ratio, not a
          // content card; the desktop keeps the 3:2 photo inside the closure. It sits INSIDE this
          // section, under the reflection, so the connector's word and reflection stay adjacent on
          // the seam (the frame drew the band as the seam itself, before the connectors landed).
          // Decorative: the closure's alt text already names the photo. ?>
    <figure class="visit-band" aria-hidden="true">
        <img src="<?php echo esc_url( $args['photo'] ); ?>" alt="" loading="lazy">
    </figure>

    <div class="container">
        <div class="visit-cta__split">

            <?php // ── Left: Closure ── ?>
            <div class="visit-cta__closure">
                <div class="visit-cta__text">
                    <h2 class="visit-cta__headline molot-text"><?php echo esc_html( $args['headline'] ); ?></h2>
                    <div class="visit-cta__photo">
                        <img
                            src="<?php echo esc_url( $args['photo'] ); ?>"
                            alt="<?php echo esc_attr( $args['alt'] ); ?>"
                            loading="lazy"
                        >
                    </div>
                    <p class="visit-cta__body">
                        <?php echo esc_html( $args['body'] ); ?>
                    </p>
                </div>
                <div class="visit-cta__buttons">
                    <?php
                    get_template_part( 'template-parts/components/button', null, [
                        'label'          => __( 'See the menu', 'sweet-pepper' ),
                        'url'            => sweet_pepper_menu_url( 'food' ),
                        'variant'        => 'primary-green',
                        'type'           => 'primary-green',
                        'icon_left_svg'  => 'icons/c-book-open.svg',
                        'icon_right_svg' => 'icons/c-arrow-right-outline.svg',
                    ] );

                    get_template_part( 'template-parts/components/button', null, [
                        'label'          => __( 'More about Sweet Pepper', 'sweet-pepper' ),
                        'url'            => home_url( '/about' ),
                        'variant'        => 'secondary',
                        'type'           => 'secondary',
                        'class'          => 'btn-secondary--dark',
                        'icon_right_svg' => 'icons/c-arrow-right-outline.svg',
                    ] );
                    ?>
                </div>

                <?php // Phones only — the booking block. .phone-cta-wrapper is the bar-state hook
                      // (reserve-drawer.js applyBarState sets data-bar-state on every wrapper). ?>
                <div class="visit-cta__booking phone-cta-wrapper" data-bar-state="available">
                    <h3 class="visit-cta__booking-title molot-text"><?php esc_html_e( 'Book your table', 'sweet-pepper' ); ?></h3>
                    <a href="tel:+74852911202" class="btn btn-primary-green visit-cta__call">
                        <span class="btn-icon btn-icon-left"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-phone.svg' ); ?></span>
                        <span class="btn-label"><?php esc_html_e( 'Call 911-202', 'sweet-pepper' ); ?></span>
                    </a>
                    <div class="visit-cta__booking-row">
                        <?php
                        get_template_part( 'template-parts/components/button', null, [
                            'label'         => __( 'VK message', 'sweet-pepper' ),
                            'label_mobile'  => _x( 'VK message', 'short label, phone two-up row', 'sweet-pepper' ),
                            'type'          => 'secondary',
                            'class'         => 'btn-secondary--dark',
                            'icon_left_svg' => 'icons/vk.svg',
                            'url'           => 'https://vk.me/barsweetpepper',
                        ] );
                        get_template_part( 'template-parts/components/button', null, [
                            'label'         => __( 'Instagram DM', 'sweet-pepper' ),
                            'label_mobile'  => _x( 'Instagram DM', 'short label, phone two-up row', 'sweet-pepper' ),
                            'type'          => 'secondary',
                            'class'         => 'btn-secondary--dark',
                            'icon_left_svg' => 'icons/insta.svg',
                            'url'           => 'https://ig.me/m/barsweetpepper',
                        ] );
                        ?>
                    </div>
                </div>
            </div>

            <?php // ── Right: Contact form (dark variant) ── ?>
            <div class="visit-cta__form-wrap">
                <?php get_template_part( 'template-parts/components/contact-form', null, [
                    'title'               => _x( 'Send a message', 'the Visit page form', 'sweet-pepper' ),
                    'subtitle'            => __( "Feedback, partnerships, events, or anything that's not a reservation. We'll get back to you within 24 hours!", 'sweet-pepper' ),
                    'title_prefix_mobile' => _x( 'or ', 'the Visit form title, phones', 'sweet-pepper' ),
                    'topics'              => [ __( 'Private event', 'sweet-pepper' ), __( 'Press & Partners', 'sweet-pepper' ), __( 'Feedback', 'sweet-pepper' ), __( 'Any questions', 'sweet-pepper' ) ],
                ] ); ?>
            </div>

        </div>
    </div>
</section>
