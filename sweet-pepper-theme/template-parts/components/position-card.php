<?php
/**
 * Position card — one open role (the About page's Careers section; the "other open roles"
 * row on a vacancy page). The markup that lived in template-parts/about/careers.php until
 * 25 Sep 2026; the classes stay `about-careers__card…` (about.css → Careers).
 *
 * The link at the foot is the card's one action: the posting's page («Подробнее» / See the
 * role) for a `vacancy` record, hh.ru for a legacy repeater row. A card without a link
 * prints none.
 *
 * @param array $args {
 *     @type string $department Printed in the pill.
 *     @type string $title      The role.
 *     @type string $meta       Schedule.
 *     @type string $desc       One or two lines (clamped to two).
 *     @type string $url        Where the link goes ('' = no link).
 *     @type string $link_label The link's words. Default "View role on hh.ru".
 *     @type bool   $external   Opens in a new tab (hh.ru).
 * }
 */

$pos      = $args;
$label    = $pos['link_label'] ?? __( 'View role on hh.ru', 'sweet-pepper' );
$external = ! empty( $pos['external'] );
?>
<div class="about-careers__card">
    <div class="about-careers__card-top">
        <div class="about-careers__card-header">
            <span class="about-careers__pill"><?php echo esc_html( $pos['department'] ?? '' ); ?></span>
            <span class="about-careers__card-meta"><?php echo esc_html( $pos['meta'] ?? '' ); ?></span>
        </div>
        <div class="about-careers__card-body">
            <h3 class="about-careers__card-title molot-text"><?php echo esc_html( $pos['title'] ?? '' ); ?></h3>
            <p class="about-careers__card-desc"><?php echo esc_html( $pos['desc'] ?? '' ); ?></p>
        </div>
    </div>
    <?php if ( ! empty( $pos['url'] ) ) : ?>
        <a href="<?php echo esc_url( $pos['url'] ); ?>" class="about-careers__card-link"<?php echo $external ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
            <span><?php echo esc_html( $label ); ?></span>
            <span class="about-careers__card-link-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
        </a>
    <?php endif; ?>
</div>
