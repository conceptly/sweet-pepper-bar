<?php
/**
 * Vacancy page — the contact card.
 *
 * The Visit page's contact card, row for row: the contact-item component (text + copy
 * chip) with the action link beside it — Call · Write · Message · DM. Same anatomy,
 * its own class names (vacancy.css), so a change to the Visit card never reaches this
 * one by accident (the footer / contacts `contact-item` trap, website-brief.md → Grid →
 * Icon beside text).
 *
 * Two states (inc/vacancies.php → sweet_pepper_vacancy_contact()):
 *   the bar   — the bar's channels: phone, Telegram, VK, Instagram, email.
 *   a person  — name and role, their phone / Telegram / email, then the bar's phone and
 *               email as a second block: a chef mid-service does not pick up, and the
 *               applicant still has a door.
 * hh.ru, when the record has the link, is the last row — a secondary button out.
 *
 * @param array $args contact (bar, person) · hh
 */

$bar    = $args['contact']['bar'];
$person = $args['contact']['person'] ?? null;
$hh     = $args['hh'] ?? '';

/**
 * One row: the contact item and its action.
 *
 * @param string $icon     Icon file under assets/icons/.
 * @param string $text     The printed contact.
 * @param string $copy     What the chip copies.
 * @param string $label    The action's verb.
 * @param string $href     The action's link ('' = no action).
 * @param bool   $external Opens in a new tab.
 */
$row = function ( $icon, $text, $copy, $label, $href, $external = false ) {
    if ( '' === $text ) {
        return;
    }
    ?>
    <div class="vacancy-card__row">
        <?php get_template_part( 'template-parts/components/contact-item', null, [ 'icon_svg' => 'icons/' . $icon, 'contact' => $text, 'copy_text' => $copy ] ); ?>
        <?php if ( $href ) : ?>
            <a href="<?php echo esc_url( $href ); ?>" class="vacancy-card__action"<?php echo $external ? ' target="_blank" rel="noopener"' : ''; ?> aria-label="<?php echo esc_attr( $label . ' · ' . $text ); ?>">
                <span class="vacancy-card__action-label"><?php echo esc_html( $label ); ?></span>
                <span class="vacancy-card__action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
            </a>
        <?php endif; ?>
    </div>
    <?php
};

$phone_row = fn( $c ) => $row( 'c-phone.svg', $c['phone'], $c['tel'] ?: $c['phone'], __( 'Call', 'sweet-pepper' ), $c['tel'] ? 'tel:' . $c['tel'] : '' );
$tg_row    = fn( $c ) => $row( 'send.svg', $c['telegram'], $c['telegram_url'] ?: $c['telegram'], __( 'Write', 'sweet-pepper' ), $c['telegram_url'], true );
$mail_row  = fn( $c ) => $row( 'c-mail.svg', $c['email'], $c['email'], __( 'Write', 'sweet-pepper' ), $c['email'] ? 'mailto:' . $c['email'] : '' );
?>
<div class="vacancy-card">
    <h2 class="vacancy-card__title molot-text"><?php esc_html_e( 'Your contact', 'sweet-pepper' ); ?></h2>

    <?php if ( $person ) : ?>
        <div class="vacancy-card__section">
            <p class="vacancy-card__person">
                <span class="vacancy-card__name"><?php echo esc_html( $person['name'] ); ?></span>
                <?php if ( $person['role'] ) : ?>
                    <span class="vacancy-card__role"><?php echo esc_html( $person['role'] ); ?></span>
                <?php endif; ?>
            </p>
            <?php $phone_row( $person ); $tg_row( $person ); $mail_row( $person ); ?>
        </div>

        <?php if ( $bar['phone'] || $bar['email'] ) : ?>
            <div class="vacancy-card__section">
                <h3 class="vacancy-card__heading molot-text"><?php esc_html_e( 'Or the bar', 'sweet-pepper' ); ?></h3>
                <?php $phone_row( $bar ); $mail_row( $bar ); ?>
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="vacancy-card__section">
            <?php
            $phone_row( $bar );
            $tg_row( $bar );
            $row( 'vk.svg', $bar['vk_label'], $bar['vk'], __( 'Message', 'sweet-pepper' ), $bar['vk'], true );
            $row( 'insta.svg', $bar['instagram_label'], $bar['instagram'], __( 'DM', 'sweet-pepper' ), $bar['instagram'], true );
            $mail_row( $bar );
            ?>
        </div>
    <?php endif; ?>

    <?php if ( $hh ) : ?>
        <div class="vacancy-card__hh">
            <?php get_template_part( 'template-parts/components/button', null, [
                'label'          => __( 'Apply on hh.ru', 'sweet-pepper' ),
                'url'            => $hh,
                'variant'        => 'secondary',
                'icon_right_svg' => 'icons/c-arrow-out.svg',
                'class'          => 'vacancy-card__hh-btn',
            ] ); ?>
        </div>
    <?php endif; ?>
</div>
