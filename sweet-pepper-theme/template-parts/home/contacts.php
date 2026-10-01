<?php
/**
 * Home — Contacts (website-brief.md → Mobile — Contacts).
 *
 * The words come as args from sweet_pepper_home_contacts() (inc/home-data.php) — the front
 * page's «Визит и связь» tab. The channels — phone, VK, Instagram, the address, the map — are
 * typed here until Bar Settings holds them; the chips and buttons are UI strings.
 *
 * @param array $args eyebrow · headline · headline_2 · description · description_mobile · map_title · more_title · more_text
 *
 * @package Sweet_Pepper
 */
?>

    <!-- Contacts Section -->
    <section class="home-contacts" id="contacts">
        <div class="container">

            <!-- Top Section Link Word (JOIN THE PARTY — reflection, shared seam with Events) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/joinTheParty-top.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/joinTheParty-top.svg',
                'alt'       => 'JOIN THE PARTY',
                'class'     => 'section-link-word--reflection',
            ] ); 
            ?>

            <!-- Section Header -->
            <?php 
            get_template_part( 'template-parts/components/section-header', null, [
                'eyebrow'     => $args['eyebrow'],
                'headline'    => $args['headline'],
                'headline_2'  => $args['headline_2'],
                'description' => $args['description'],
                'description_mobile' => $args['description_mobile'],
                'ctas'        => array_filter( [ // Instagram only outside Russia (inc/geo.php)
                    [
                        'label'         => 'vk.com/sweetpepperbar',
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/vk.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://vk.com/sweetpepperbar',
                    ],
                    sweet_pepper_show_instagram() ? [
                        'label'         => 'instagram.com/barsweetpepper',
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/insta.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://www.instagram.com/barsweetpepper/',
                    ] : null,
                ] )
            ] ); 
            ?>

            <!-- Phones only (Figma Contacts 1198:53132): the reserve drawer's booking block in the
                 flow — phone leads, messengers second. Same classes as the drawer, so the bar-state
                 engine (reserve-drawer.js) drives it. The phone button is a call, not a copy
                 (author, 27 Sep 2026): on a phone the number is dialled, as the nav drawer's
                 «Позвонить» and the Visit booking block do — a tel: link with the number as its
                 label, no copy icon. -->
            <div class="contacts-reserve">
                <div class="phone-cta-wrapper" data-bar-state="available">
                    <a href="tel:+74852911202" class="btn-call" aria-label="<?php echo esc_attr( sprintf( __( 'Call %s', 'sweet-pepper' ), '+7 (4852) 911-202' ) ); ?>">
                        <span class="btn-call-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-phone.svg' ); ?></span>
                        <span class="btn-call-label">+7 (4852) 911-202</span>
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
                <div class="contacts-reserve__social">
                    <div class="contacts-reserve__row">
                        <?php
                        get_template_part( 'template-parts/components/button', null, [
                            // Short labels, the drawers' and the Visit CTA's: the long pair ("Message on …")
                            // overflowed the two-up row on phones (Sep 2026)
                            'label'         => __( 'VK message', 'sweet-pepper' ),
                            'label_mobile'  => sweet_pepper_show_instagram() ? _x( 'VK message', 'short label, phone two-up row', 'sweet-pepper' ) : __( 'VK message', 'sweet-pepper' ), // the short one only beside Instagram
                            'type'          => 'secondary',
                            'icon_left_svg' => 'icons/vk.svg',
                            'url'           => 'https://vk.me/barsweetpepper',
                        ] );
                        if ( sweet_pepper_show_instagram() ) { // alone, VK takes the row (flex: 1)
                            get_template_part( 'template-parts/components/button', null, [
                                'label'         => __( 'Instagram DM', 'sweet-pepper' ),
                                'label_mobile'  => _x( 'Instagram DM', 'short label, phone two-up row', 'sweet-pepper' ),
                                'type'          => 'secondary',
                                'icon_left_svg' => 'icons/insta.svg',
                                'url'           => 'https://ig.me/m/barsweetpepper',
                            ] );
                        }
                        ?>
                    </div>
                    <?php // The reply time is a daytime promise: while the bar is closed the line says when
                          // the answers start (reserve-drawer.js → applyBarState; author, 30 Sep 2026 — it
                          // read "answer in 20 minutes" at night). Busy keeps the daytime line. ?>
                    <div class="call-status contacts-reserve__status" data-bar-state="available">
                        <span class="call-status-icon">
                            <span class="call-status-icon--available"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                            <span class="call-status-icon--closed"><?php echo sweet_pepper_inline_svg( 'assets/icons/sleep.svg' ); ?></span>
                        </span>
                        <span class="call-status-text"><?php esc_html_e( 'Usually answer in 20 minutes', 'sweet-pepper' ); ?></span>
                    </div>
                </div>
            </div>

            <!-- Map + Form Split -->
            <div class="contacts-split">

                <!-- Map Column — on phones a "Get directions" band: title + 240px map + chips
                     (the address bar and the form are desktop-only) -->
                <div class="contacts-map-wrap">
                    <h2 class="contacts-subtitle contacts-subtitle--directions molot-text"><?php echo esc_html( $args['map_title'] ); ?></h2>
                    <div class="contacts-map">
                        <div class="contacts-map__embed">
                            <?php get_template_part( 'template-parts/components/map-placeholder' ); ?>
                        </div>
                        <div class="contacts-map__bar">
                            <div class="contacts-map__address">
                                <span class="contacts-map__pin-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-pin.svg' ); ?></span>
                                <span class="contacts-map__address-text"><?php esc_html_e( 'Kirova 10/25, Yaroslavl', 'sweet-pepper' ); ?></span>
                            </div>
                            <div class="contacts-map__chips">
                                <?php // The bar is 534 wide and the address already ellipsises, so the two
                                      // chips carry the short labels and the full action names sit in the
                                      // accessible name (home-copy-en.md → Actions). The phone chip row below
                                      // has the width for the long labels. ?>
                                <button class="contacts-chip js-copy" data-copy-text="Ярославль, ул. Кирова, 10/25" data-copied-label="<?php esc_attr_e( 'Copied', 'sweet-pepper' ); ?>" type="button" aria-label="<?php esc_attr_e( 'Copy address', 'sweet-pepper' ); ?>">
                                    <span class="chip-label"><?php esc_html_e( 'Copy', 'sweet-pepper' ); ?></span>
                                    <span class="chip-icon chip-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                                    <span class="chip-icon chip-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                                </button>
                                <a class="contacts-chip" href="https://maps.google.com/?q=Yaroslavl,+Kirova+10/25" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Get directions', 'sweet-pepper' ); ?>">
                                    <?php echo esc_html( _x( 'Directions', 'home map chip — opens directions to the bar', 'sweet-pepper' ) ); ?> <span class="chip-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-navigate.svg' ); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="contacts-map__chips contacts-map__chips--phone">
                        <button class="contacts-chip js-copy" data-copy-text="Ярославль, ул. Кирова, 10/25" data-copied-label="<?php esc_attr_e( 'Address copied', 'sweet-pepper' ); ?>" type="button" aria-label="<?php esc_attr_e( 'Copy address', 'sweet-pepper' ); ?>">
                            <span class="chip-label"><?php esc_html_e( 'Copy address', 'sweet-pepper' ); ?></span>
                            <span class="chip-icon chip-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                            <span class="chip-icon chip-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                        </button>
                        <a class="contacts-chip" href="https://yandex.ru/maps/?rtext=~57.626100%2C39.884500" target="_blank" rel="noopener noreferrer">
                            <?php esc_html_e( 'Yandex Maps', 'sweet-pepper' ); ?> <span class="chip-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                        </a>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="contacts-form-wrap">
                    <?php get_template_part( 'template-parts/components/contact-form', null, [
                        // The Visit form's three (visit/cta.php), since 29 Sep 2026 — the chosen one is the letter's subject
                        'topics' => [ __( 'Feedback', 'sweet-pepper' ), __( 'Press & Partners', 'sweet-pepper' ), __( 'Other questions', 'sweet-pepper' ) ],
                    ] ); ?>
                </div>

            </div>

            <!-- Phones only: the Visit page carries the rest -->
            <div class="contacts-more">
                <h2 class="contacts-subtitle molot-text"><?php echo esc_html( $args['more_title'] ); ?></h2>
                <div class="contacts-more__row">
                    <p class="contacts-more__lead"><?php echo esc_html( $args['more_text'] ); ?></p>
                    <a class="contacts-more__link" href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">
                        <?php esc_html_e( 'Plan your visit', 'sweet-pepper' ); ?> <span class="contacts-more__link-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
                    </a>
                </div>
            </div>

        </div>
    </section>
