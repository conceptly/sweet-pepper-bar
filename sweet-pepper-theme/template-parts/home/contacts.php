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
                'ctas'        => [
                    [
                        'label'         => 'vk.com/sweetpepperbar',
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/vk.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://vk.com/sweetpepperbar',
                    ],
                    [
                        'label'         => 'instagram.com/barsweetpepper',
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/insta.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://www.instagram.com/barsweetpepper/',
                    ],
                ]
            ] ); 
            ?>

            <!-- Phones only (Figma Contacts 1198:53132): the reserve drawer's booking block in the
                 flow — phone leads, messengers second. Same classes as the drawer, so the bar-state
                 engine (reserve-drawer.js) and the copy buttons drive it. -->
            <div class="contacts-reserve">
                <div class="phone-cta-wrapper" data-bar-state="available">
                    <button type="button" class="btn-call js-copy" data-copy-text="+74852911202">
                        <span class="btn-call-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-phone.svg' ); ?></span>
                        <span class="btn-call-label">+7 (4852) 911-202</span>
                        <span class="btn-copy-icon btn-copy-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                        <span class="btn-copy-icon btn-copy-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                    </button>
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
                            'type'          => 'secondary',
                            'icon_left_svg' => 'icons/vk.svg',
                            'url'           => 'https://vk.me/barsweetpepper',
                        ] );
                        get_template_part( 'template-parts/components/button', null, [
                            'label'         => __( 'Instagram DM', 'sweet-pepper' ),
                            'type'          => 'secondary',
                            'icon_left_svg' => 'icons/insta.svg',
                            'url'           => 'https://ig.me/m/barsweetpepper',
                        ] );
                        ?>
                    </div>
                    <div class="call-status contacts-reserve__status">
                        <span class="call-status-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
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
                            <iframe 
                                src="https://www.google.com/maps/d/embed?mid=1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY&hl=en&ehbc=2E312F" 
                                title="<?php esc_attr_e( 'Sweet Pepper Bar location map', 'sweet-pepper' ); ?>"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                            ></iframe>
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
                    <?php get_template_part( 'template-parts/components/contact-form' ); ?>
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
