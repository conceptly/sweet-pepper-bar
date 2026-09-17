<?php
/**
 * About page — Careers section
 *
 * Dark section (Peppercorn bg).
 * Section header with eyebrow, headline, and description.
 * Two-state jobsContainer component:
 *   - Default ($has_openings = true): 3 position cards + bottom CTA row.
 *   - Empty  ($has_openings = false): single bordered box with "not hiring" message.
 *
 * @package Sweet_Pepper
 */

// ── Toggle: flip to false when there are no openings ─────────────────────
$has_openings = true;

// ── Position data (placeholder content) ──────────────────────────────────
$positions = [
    [
        'department' => __( 'Service', 'sweet-pepper' ),
        'title'      => __( 'Floor manager', 'sweet-pepper' ),
        'meta'       => __( 'Full-time · 2 days on, 2 days off', 'sweet-pepper' ),
        'desc'       => __( 'Keep service running smoothly, support the floor team and make every welcome count.', 'sweet-pepper' ),
        'url'        => '#',
    ],
    [
        'department' => __( 'Service', 'sweet-pepper' ),
        'title'      => __( 'Cleaner', 'sweet-pepper' ),
        'meta'       => __( 'Full-time', 'sweet-pepper' ),
        'desc'       => __( 'Help keep the rooms ready for the next guests, from the first table to the last detail.', 'sweet-pepper' ),
        'url'        => '#',
    ],
    [
        'department' => __( 'Kitchen', 'sweet-pepper' ),
        'title'      => __( 'Sous-chef', 'sweet-pepper' ),
        'meta'       => __( 'Full-time', 'sweet-pepper' ),
        'desc'       => __( 'Support the chef, keep the kitchen organised and help every plate leave as it should.', 'sweet-pepper' ),
        'url'        => '#',
    ],
];

// ── Icon paths (inline SVG via file_get_contents) ────────────────────────
$icon_dir       = get_template_directory() . '/assets/icons/';
// arrow: sweet_pepper_inline_svg() per instance (see mobile-drawer.php)
$mail_svg       = file_exists( $icon_dir . 'c-mail.svg' ) ? file_get_contents( $icon_dir . 'c-mail.svg' ) : '';
?>

<section id="careers" class="about-section about-section--dark about-careers">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'RoomForOneMore', 'position' => 'head', 'alt' => 'Room for one more' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'     => __( 'WORK AT SWEET PEPPER', 'sweet-pepper' ),
            'headline'    => __( 'WANT TO JOIN', 'sweet-pepper' ),
            'headline_2'  => __( 'THE FAMILY?', 'sweet-pepper' ),
            'description' => __( "A small team, familiar faces and room to learn. Take a look at the roles below — or get in touch about the work you'd like to do.", 'sweet-pepper' ),
        ] );
        ?>

        <!-- jobsContainer -->
        <div class="about-careers__content">

            <?php if ( $has_openings ) : ?>

                <!-- Default state: job cards -->
                <div class="about-careers__jobs">
                    <?php foreach ( $positions as $pos ) : ?>
                        <div class="about-careers__card">
                            <div class="about-careers__card-top">
                                <div class="about-careers__card-header">
                                    <span class="about-careers__pill"><?php echo esc_html( $pos['department'] ); ?></span>
                                    <span class="about-careers__card-meta"><?php echo esc_html( $pos['meta'] ); ?></span>
                                </div>
                                <div class="about-careers__card-body">
                                    <h3 class="about-careers__card-title molot-text"><?php echo esc_html( $pos['title'] ); ?></h3>
                                    <p class="about-careers__card-desc"><?php echo esc_html( $pos['desc'] ); ?></p>
                                </div>
                            </div>
                            <a href="<?php echo esc_url( $pos['url'] ); ?>" class="about-careers__card-link" target="_blank" rel="noopener noreferrer">
                                <span><?php esc_html_e( 'View role on hh.ru', 'sweet-pepper' ); ?></span>
                                <span class="about-careers__card-link-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- CTA row -->
                <div class="about-careers__cta">
                    <div class="about-careers__cta-text">
                        <p class="about-careers__cta-bold"><?php esc_html_e( "No opening with your name on it?", 'sweet-pepper' ); ?></p>
                        <p class="about-careers__cta-regular"><?php esc_html_e( "Send a little about yourself and the work you'd like to do.", 'sweet-pepper' ); ?></p>
                    </div>
                    <?php
                    get_template_part( 'template-parts/components/button', null, [
                        'label'          => __( 'Send your CV', 'sweet-pepper' ),
                        'url'            => 'mailto:hello@sweetpepper.bar',
                        'variant'        => 'secondary',
                        'icon_right_svg' => 'icons/c-mail.svg',
                    ] );
                    ?>
                </div>

            <?php else : ?>

                <!-- Empty state: not hiring -->
                <div class="about-careers__empty">
                    <div class="about-careers__empty-text">
                        <h3 class="about-careers__empty-title molot-text"><?php esc_html_e( 'NO OPEN ROLES JUST NOW', 'sweet-pepper' ); ?></h3>
                        <p class="about-careers__empty-desc"><?php esc_html_e( "Interested in a future role? Send your CV and a little about the work you'd like to do.", 'sweet-pepper' ); ?></p>
                    </div>
                    <?php
                    get_template_part( 'template-parts/components/button', null, [
                        'label'          => __( 'Send your CV', 'sweet-pepper' ),
                        'url'            => 'mailto:hello@sweetpepper.bar',
                        'variant'        => 'primary-green',
                        'icon_right_svg' => 'icons/c-arrow-right-outline.svg',
                    ] );
                    ?>
                </div>

            <?php endif; ?>

        </div>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'makeYourselfAtHome', 'position' => 'foot', 'alt' => 'Make yourself at home' ] ); ?>
</section>
