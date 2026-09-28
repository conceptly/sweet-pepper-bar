<?php
/**
 * Vacancy page — the contact bar, phones only (≤ 767px, vacancy.css).
 *
 * Pinned to the bottom of the screen while the posting is open: Call · Write, the way
 * the home Contacts section keeps the booking block at hand on phones. Both go to the
 * chosen person when the record names one (Write: their Telegram, then email), else to the
 * bar — and the bar's Write takes **VK first** (the team, 28 Sep 2026: applicants should
 * call or message on VK) — the community's messages, not the profile — then Telegram, then email. The icon follows the destination: the
 * VK badge for VK, the send glyph in the button's own ink otherwise (it was baked Lemon on
 * the Lime button).
 *
 * @param array $args vacancy (sweet_pepper_vacancy())
 */

$v      = $args['vacancy'];
$bar    = $v['contact']['bar'];
$person = $v['contact']['person'];
$who    = $person ?: $bar;

$tel   = $who['tel'] ?: $bar['tel'];
$write = $person ? ( $person['telegram_url'] ?: ( $person['email'] ? 'mailto:' . $person['email'] : '' ) ) : '';
$write = $write ?: ( $bar['vk_write'] ?: ( $bar['telegram_url'] ?: ( $bar['email'] ? 'mailto:' . $bar['email'] : '' ) ) );
$is_vk = $write && $write === $bar['vk_write'];
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
            <span class="btn-icon btn-icon-left<?php echo $is_vk ? '' : ' vacancy-bar__icon-ink'; ?>"><?php echo sweet_pepper_inline_svg( 'assets/icons/' . ( $is_vk ? 'vk.svg' : 'send.svg' ) ); ?></span>
            <span class="btn-label"><?php echo esc_html( $name ? sprintf( __( 'Write to %s', 'sweet-pepper' ), $name ) : _x( 'Write', 'the vacancy page\'s bottom bar', 'sweet-pepper' ) ); ?></span>
        </a>
    <?php endif; ?>
</div>
