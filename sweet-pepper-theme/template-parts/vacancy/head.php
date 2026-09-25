<?php
/**
 * Vacancy page — the head (Peppercorn).
 *
 * Opened by the Careers connector's reflection (ROOM FOR ONE MORE · ТВОЁ МЕСТО В КОМАНДЕ),
 * so the page reads as a continuation of the About page's Careers section. Text only — no
 * photo: a photo per posting would be a field the team cannot keep (design.md §7 shoots in
 * the bar; a stock image is a "don't"). Back link → the About list · eyebrow (the Careers
 * section's own) · H1 · the meta row (department pill, schedule, pay, open since).
 * Closed: the meta row gives way to one line.
 *
 * No close date and no countdown for guests: the term is housekeeping, not a deadline
 * (website-brief.md → The no-clock rule).
 *
 * @param array $args vacancy (sweet_pepper_vacancy()) · eyebrow
 */

$v       = $args['vacancy'];
$eyebrow = $args['eyebrow'] ?? '';
?>
<section class="vacancy-head">
    <?php get_template_part( 'template-parts/about/connector', null, [ 'word' => 'RoomForOneMore', 'position' => 'head', 'alt' => 'Room for one more' ] ); ?>

    <div class="container vacancy-head__inner">
        <a class="vacancy-head__back" href="<?php echo esc_url( home_url( '/about/#careers' ) ); ?>">
            <span class="vacancy-head__back-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
            <span><?php esc_html_e( 'All roles', 'sweet-pepper' ); ?></span>
        </a>

        <?php if ( $eyebrow ) : ?>
            <p class="vacancy-head__eyebrow molot-text"><?php echo esc_html( $eyebrow ); ?></p>
        <?php endif; ?>

        <h1 class="vacancy-head__title molot-text"><?php echo esc_html( $v['title'] ); ?></h1>

        <?php if ( $v['open'] ) : ?>
            <ul class="vacancy-head__meta">
                <?php if ( $v['department'] ) : ?>
                    <li class="vacancy-pill"><?php echo esc_html( $v['department'] ); ?></li>
                <?php endif; ?>
                <?php if ( $v['schedule'] ) : ?>
                    <li class="vacancy-head__meta-item"><?php echo esc_html( $v['schedule'] ); ?></li>
                <?php endif; ?>
                <?php if ( $v['pay'] ) : ?>
                    <li class="vacancy-head__meta-item"><?php echo esc_html( $v['pay'] ); ?></li>
                <?php endif; ?>
                <?php if ( $v['opened'] ) : ?>
                    <li class="vacancy-head__meta-item vacancy-head__meta-item--since"><?php echo esc_html( sprintf( __( 'Open since %s', 'sweet-pepper' ), $v['opened'] ) ); ?></li>
                <?php endif; ?>
            </ul>
        <?php else : ?>
            <p class="vacancy-head__closed"><?php esc_html_e( 'This role is filled. Have a look at the open ones below.', 'sweet-pepper' ); ?></p>
        <?php endif; ?>
    </div>
</section>
