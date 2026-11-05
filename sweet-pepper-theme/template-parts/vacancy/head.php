<?php
/**
 * Vacancy page — the head (Peppercorn).
 *
 * No section connector (author, 28 Sep 2026: the reflection, then the word, tried and
 * dropped — "it doesn't work here"); the Careers eyebrow ties the page to About. Back link → the
 * About list · eyebrow (the Careers section's own) · H1 · the ticket (department pill, open
 * since, schedule and pay). Closed: the ticket gives way to one line.
 *
 * The photo (28 Sep 2026, author): the posting's VK poster, shot in the bar by the team, in
 * the last four columns beside the text — whole, never cropped, because the words are part
 * of the picture. Russian words, so the Russian page only (sweet_pepper_vacancy() → photo);
 * no photo, or a closed posting, and the head is text only, as before.
 *
 * No close date and no countdown for guests: the term is housekeeping, not a deadline
 * (website-brief.md → The no-clock rule).
 *
 * @param array $args vacancy (sweet_pepper_vacancy()) · eyebrow
 */

$v       = $args['vacancy'];
$eyebrow = $args['eyebrow'] ?? '';
$photo   = $v['open'] && ! empty( $v['photo'] ) ? $v['photo'] : 0;
?>
<section class="vacancy-head">
    <div class="container<?php echo $photo ? ' vacancy-head__grid' : ''; ?>">
        <div class="vacancy-head__inner">
            <a class="vacancy-head__back" href="<?php echo esc_url( home_url( '/about/#careers' ) ); ?>">
                <span class="vacancy-head__back-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
                <span><?php esc_html_e( 'All roles', 'sweet-pepper' ); ?></span>
            </a>

            <div class="vacancy-head__heading">
                <?php if ( $eyebrow ) : ?>
                    <p class="vacancy-head__eyebrow molot-text"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>

                <h1 class="vacancy-head__title molot-text"><?php echo esc_html( $v['title'] ); ?></h1>
            </div>

            <?php if ( $v['open'] ) : ?>
                <?php // The facts on the bartender's ticket (author's pick, 28 Sep 2026): Parchment, the
                      // rugged edges, pill + date over a rule, schedule and pay as menu rows. ?>
                <div class="vacancy-ticket">
                    <div class="vacancy-ticket__edge vacancy-ticket__edge--top" aria-hidden="true"><?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'peppercorn' ] ); ?></div>
                    <?php if ( $v['department'] || $v['opened'] ) : ?>
                        <div class="vacancy-ticket__top">
                            <?php if ( $v['department'] ) : ?>
                                <span class="vacancy-ticket__pill"><?php echo esc_html( $v['department'] ); ?></span>
                            <?php endif; ?>
                            <?php if ( $v['opened'] ) : ?>
                                <span class="vacancy-ticket__since"><?php echo esc_html( sprintf( __( 'Open since %s', 'sweet-pepper' ), $v['opened'] ) ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php foreach ( [
                        [ __( 'Schedule', 'sweet-pepper' ), $v['schedule'], '' ],
                        [ __( 'Pay', 'sweet-pepper' ), $v['pay'], ' vacancy-ticket__row--pay' ],
                    ] as [ $label, $value, $mod ] ) : ?>
                        <?php if ( $value ) : ?>
                            <p class="vacancy-ticket__row<?php echo $mod; ?>"><span class="vacancy-ticket__label"><?php echo esc_html( $label ); ?></span><span class="vacancy-ticket__wrap"><span class="vacancy-ticket__value"><?php echo esc_html( $value ); ?></span></span></p>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <div class="vacancy-ticket__edge vacancy-ticket__edge--bottom" aria-hidden="true"><?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'parchment' ] ); ?></div>
                </div>
            <?php else : ?>
                <p class="vacancy-head__closed"><?php esc_html_e( 'This role is filled. Have a look at the open ones below.', 'sweet-pepper' ); ?></p>
            <?php endif; ?>
        </div>

        <?php if ( $photo ) : ?>
            <figure class="vacancy-head__photo">
                <?php echo wp_get_attachment_image( $photo, 'large', false, [
                    'class'   => 'vacancy-head__photo-img',
                    'sizes'   => '(max-width: 767px) calc(100vw - 32px), 360px',
                    'loading' => 'eager',
                ] ); ?>
            </figure>
        <?php endif; ?>
    </div>
</section>
