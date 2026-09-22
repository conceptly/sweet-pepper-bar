<?php
/**
 * About page — Careers section
 *
 * Dark section (Peppercorn bg).
 * Section header with eyebrow, headline, and description.
 * Two-state jobsContainer component:
 *   - Default (there are positions): position cards + bottom CTA row.
 *   - Empty  (no positions): single bordered box with "not hiring" message.
 *
 * Content comes as args from sweet_pepper_about_careers() (inc/about-data.php) — the
 * About page's «Вакансии» tab. There is no hiring switch: no visible role is the empty state.
 *
 * @param array $args eyebrow · headline · headline_2 · description · positions[] (department,
 *                    title, meta, desc, url) · cta_title · cta_text · empty_title · empty_text
 *
 * @package Sweet_Pepper
 */

$positions = $args['positions'];
?>

<section id="careers" class="about-section about-section--dark about-careers">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'RoomForOneMore', 'position' => 'head', 'alt' => 'Room for one more' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'     => $args['eyebrow'],
            'headline'    => $args['headline'],
            'headline_2'  => $args['headline_2'],
            'description' => $args['description'],
        ] );
        ?>

        <!-- jobsContainer -->
        <div class="about-careers__content">

            <?php if ( $positions ) : ?>

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
                            <?php if ( $pos['url'] ) : ?>
                                <a href="<?php echo esc_url( $pos['url'] ); ?>" class="about-careers__card-link" target="_blank" rel="noopener noreferrer">
                                    <span><?php esc_html_e( 'View role on hh.ru', 'sweet-pepper' ); ?></span>
                                    <span class="about-careers__card-link-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- CTA row -->
                <div class="about-careers__cta">
                    <div class="about-careers__cta-text">
                        <p class="about-careers__cta-bold"><?php echo esc_html( $args['cta_title'] ); ?></p>
                        <p class="about-careers__cta-regular"><?php echo esc_html( $args['cta_text'] ); ?></p>
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
                        <h3 class="about-careers__empty-title molot-text"><?php echo esc_html( $args['empty_title'] ); ?></h3>
                        <p class="about-careers__empty-desc"><?php echo esc_html( $args['empty_text'] ); ?></p>
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
