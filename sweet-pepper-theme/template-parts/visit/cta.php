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

                <?php // Phones only — a booking block (reserve-drawer.js → applyBarState): the phone is the
                      // Chili button while the bar is open, VK while it is closed (the messenger group moves
                      // up, reserve-drawer.css → Booking blocks). On the dark ground the secondaries are the
                      // --dark ones, so the swap hands both classes over (data-secondary).
                      // Each action with its status line under it, as on home (template-parts/home/contacts.php)
                      // and in the drawer — author, 2 Oct 2026. The call line is filled by reserve-drawer.js
                      // (empty without JS). ?>
                <div class="visit-cta__booking booking-block" data-bar-state="available">
                    <h3 class="visit-cta__booking-title molot-text"><?php esc_html_e( 'Book your table', 'sweet-pepper' ); ?></h3>
                    <div class="visit-cta__booking-group phone-cta-wrapper" data-bar-state="available">
                        <a href="tel:+74852911202" class="btn btn-primary btn-call visit-cta__call" data-secondary="btn-secondary btn-secondary--dark">
                            <span class="btn-icon btn-icon-left"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-phone.svg' ); ?></span>
                            <span class="btn-label"><?php esc_html_e( 'Call 911-202', 'sweet-pepper' ); ?></span>
                        </a>
                        <div class="call-status">
                            <span class="call-status-icon">
                                <span class="call-status-icon--available"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                                <span class="call-status-icon--busy" aria-hidden="true"></span>
                                <span class="call-status-icon--closed"><?php echo sweet_pepper_inline_svg( 'assets/icons/sleep.svg' ); ?></span>
                            </span>
                            <span class="call-status-text"></span>
                        </div>
                    </div>
                    <div class="visit-cta__booking-group booking-block__write">
                        <div class="visit-cta__booking-row">
                            <?php
                            get_template_part( 'template-parts/components/button', null, [
                                'label'         => __( 'VK message', 'sweet-pepper' ),
                                'label_mobile'  => sweet_pepper_show_instagram() ? _x( 'VK message', 'short label, phone two-up row', 'sweet-pepper' ) : __( 'VK message', 'sweet-pepper' ), // the short one only beside Instagram
                                'type'          => 'secondary',
                                'class'         => 'btn-secondary--dark js-booking-lead', // the Chili one while the bar is closed
                                'secondary'     => 'btn-secondary btn-secondary--dark',
                                'icon_left_svg' => 'icons/vk.svg',
                                'url'           => 'https://vk.me/barsweetpepper',
                            ] );
                            if ( sweet_pepper_show_instagram() ) { // alone, VK takes the row (flex: 1)
                                get_template_part( 'template-parts/components/button', null, [
                                    'label'         => __( 'Instagram DM', 'sweet-pepper' ),
                                    'label_mobile'  => _x( 'Instagram DM', 'short label, phone two-up row', 'sweet-pepper' ),
                                    'type'          => 'secondary',
                                    'class'         => 'btn-secondary--dark',
                                    'icon_left_svg' => 'icons/insta.svg',
                                    'url'           => 'https://ig.me/m/barsweetpepper',
                                ] );
                            }
                            ?>
                        </div>
                        <?php // The messenger line: the reply time while open, the next opening while closed.
                              // .contacts-reserve__status is the engine's hook for it (reserve-drawer.js). ?>
                        <div class="call-status contacts-reserve__status" data-bar-state="available">
                            <span class="call-status-icon">
                                <span class="call-status-icon--available"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                                <span class="call-status-icon--closed"><?php echo sweet_pepper_inline_svg( 'assets/icons/sleep.svg' ); ?></span>
                            </span>
                            <span class="call-status-text"><?php esc_html_e( 'Usually answer in 20 minutes', 'sweet-pepper' ); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <?php // ── Right: Contact form (dark variant) ── ?>
            <div class="visit-cta__form-wrap">
                <?php get_template_part( 'template-parts/components/contact-form', null, [
                    'title'               => _x( 'Send a message', 'the Visit page form', 'sweet-pepper' ),
                    // Author, 29 Sep 2026: tables (and events) by phone or message; Instagram named only where
                    // it is shown (inc/geo.php — never on the Russian page, not for Russian IPs on /en/)
                    'subtitle'            => sweet_pepper_show_instagram()
                        ? __( 'Feedback, a question, an idea? Tell us. For a table, please call or message us on Instagram or VK.', 'sweet-pepper' )
                        : __( 'Feedback, a question, an idea? Tell us. For a table, please call or message us on VK.', 'sweet-pepper' ),
                    'title_prefix_mobile' => _x( 'or ', 'the Visit form title, phones', 'sweet-pepper' ),
                    'topics'              => /* The team's three (29 Sep 2026): events stay on the phone and VK for now */ [ __( 'Feedback', 'sweet-pepper' ), __( 'Press & Partners', 'sweet-pepper' ), __( 'Other questions', 'sweet-pepper' ) ],
                ] ); ?>
            </div>

        </div>
    </div>
</section>
