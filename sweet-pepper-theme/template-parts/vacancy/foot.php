<?php
/**
 * Vacancy page — the foot (Peppercorn): the other open roles as the Careers cards, then
 * the CV row — the About page's own words (its «Вакансии» tab), so a closed posting still
 * converts: an old link lands on what is open now.
 *
 * @param array $args vacancy (sweet_pepper_vacancy()) · careers (sweet_pepper_about_careers())
 */

$v       = $args['vacancy'];
$careers = $args['careers'];
$others  = $v['others'];
$email   = sweet_pepper_bar_contacts()['email'] ?: 'hello@sweetpepper.bar';
?>
<section class="vacancy-foot">
    <div class="container vacancy-foot__inner">

        <?php if ( $others ) : ?>
            <h2 class="vacancy-foot__title molot-text"><?php esc_html_e( 'Other open roles', 'sweet-pepper' ); ?></h2>
            <div class="about-careers__jobs vacancy-foot__jobs">
                <?php foreach ( $others as $pos ) {
                    get_template_part( 'template-parts/components/position-card', null, $pos );
                } ?>
            </div>
        <?php endif; ?>

        <div class="about-careers__cta vacancy-foot__cta">
            <div class="about-careers__cta-text">
                <p class="about-careers__cta-bold"><?php echo esc_html( $careers['cta_title'] ); ?></p>
                <p class="about-careers__cta-regular"><?php echo esc_html( $careers['cta_text'] ); ?></p>
            </div>
            <?php get_template_part( 'template-parts/components/button', null, [
                'label'          => __( 'Send your CV', 'sweet-pepper' ),
                'url'            => 'mailto:' . $email,
                'variant'        => $others ? 'secondary' : 'primary-green',
                'icon_right_svg' => 'icons/c-mail.svg',
            ] ); ?>
        </div>

    </div>
</section>
