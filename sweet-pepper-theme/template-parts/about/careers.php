<?php
/**
 * About page — Careers section
 *
 * Dark section (Peppercorn bg).
 * Section header with eyebrow, headline, and description.
 * The jobsContainer, four states (Figma jobContent 1970:123894, author, 28 Sep 2026):
 *   - 3 roles: three cards + the CV row under them.
 *   - 2 roles: two cards + the CV card in the third column; no row.
 *   - 1 role:  one card + the CV card across the other two columns (the H2 title); no row —
 *     "a row with one card will look empty".
 *   - none:    the single bordered "not hiring" box.
 * More than three: the rule behind the drawn states — the CV card fills what the last row
 * of cards leaves (one column or two); a full last row gets the CV row instead.
 *
 * Content comes as args from sweet_pepper_about_careers() (inc/about-data.php) — the
 * About page's «Вакансии» tab; the roles are the open `vacancy` records since 25 Sep 2026
 * (inc/vacancies.php), each card linking to its own page. There is no hiring switch: no
 * open role is the empty state. The card itself: template-parts/components/position-card.php.
 *
 * @param array $args eyebrow · headline · headline_2 · description · positions[] (position-card
 *                    args) · cta_title · cta_text · empty_title · empty_text
 *
 * @package Sweet_Pepper
 */

$positions = $args['positions'];
$left      = ( 3 - count( $positions ) % 3 ) % 3; // columns the last row of cards leaves: 0 · 1 · 2
$cv        = [
    'label'          => __( 'Send your CV', 'sweet-pepper' ),
    'url'            => 'mailto:hello@sweetpepper.bar',
    'variant'        => 'secondary',
];
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

                <!-- Job cards; the CV card fills the last row's free columns -->
                <div class="about-careers__jobs">
                    <?php foreach ( $positions as $pos ) {
                        get_template_part( 'template-parts/components/position-card', null, $pos );
                    } ?>

                    <?php if ( $left ) : ?>
                        <div class="about-careers__cv<?php echo 2 === $left ? ' about-careers__cv--wide' : ''; ?>">
                            <div class="about-careers__cv-text">
                                <h3 class="about-careers__cv-title<?php echo 2 === $left ? ' molot-text' : ''; ?>"><?php echo esc_html( $args['cta_title'] ); ?></h3>
                                <p class="about-careers__cv-desc"><?php echo esc_html( $args['cta_text'] ); ?></p>
                            </div>
                            <?php get_template_part( 'template-parts/components/button', null, $cv + [ 'icon_right_svg' => 'icons/c-arrow-right-outline.svg' ] ); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( ! $left ) : ?>
                    <!-- CTA row: under a full row of cards -->
                    <div class="about-careers__cta">
                        <div class="about-careers__cta-text">
                            <p class="about-careers__cta-bold"><?php echo esc_html( $args['cta_title'] ); ?></p>
                            <p class="about-careers__cta-regular"><?php echo esc_html( $args['cta_text'] ); ?></p>
                        </div>
                        <?php get_template_part( 'template-parts/components/button', null, $cv + [ 'icon_right_svg' => 'icons/c-mail.svg' ] ); ?>
                    </div>
                <?php endif; ?>

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
