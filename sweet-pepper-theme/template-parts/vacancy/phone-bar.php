<?php
/**
 * Vacancy page — the contact bar, phones only (≤ 767px, vacancy.css).
 *
 * Pinned to the bottom of the screen while the posting is open: Call · Write, the way
 * the home Contacts section keeps the booking block at hand on phones. Both go to the
 * chosen person when the record names one, else to the bar: Write takes Telegram first,
 * then email; the bar's VK when it has neither.
 *
 * @param array $args vacancy (sweet_pepper_vacancy())
 */

$v      = $args['vacancy'];
$bar    = $v['contact']['bar'];
$person = $v['contact']['person'];
$who    = $person ?: $bar;

$tel   = $who['tel'] ?: $bar['tel'];
$write = $who['telegram_url'] ?: ( $who['email'] ? 'mailto:' . $who['email'] : '' );
$write = $write ?: ( $bar['telegram_url'] ?: ( $bar['vk'] ?: ( $bar['email'] ? 'mailto:' . $bar['email'] : '' ) ) );
if ( ! $tel && ! $write ) {
    return;
}
$name = $person ? $person['name'] : '';
?>
<div class="vacancy-bar">
    <?php if ( $tel ) : ?>
        <a class="btn btn-secondary vacancy-bar__btn" href="tel:<?php echo esc_attr( $tel ); ?>">
            <span class="btn-icon btn-icon-left"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-phone.svg' ); ?></span>
            <span class="btn-label"><?php esc_html_e( 'Call', 'sweet-pepper' ); ?></span>
        </a>
    <?php endif; ?>
    <?php if ( $write ) : ?>
        <a class="btn btn-primary-green vacancy-bar__btn" href="<?php echo esc_url( $write ); ?>"<?php echo 0 === strpos( $write, 'http' ) ? ' target="_blank" rel="noopener"' : ''; ?>>
            <span class="btn-icon btn-icon-left"><?php echo sweet_pepper_inline_svg( 'assets/icons/send.svg' ); ?></span>
            <span class="btn-label"><?php echo esc_html( $name ? sprintf( __( 'Write to %s', 'sweet-pepper' ), $name ) : _x( 'Write', 'the vacancy page\'s bottom bar', 'sweet-pepper' ) ); ?></span>
        </a>
    <?php endif; ?>
</div>
