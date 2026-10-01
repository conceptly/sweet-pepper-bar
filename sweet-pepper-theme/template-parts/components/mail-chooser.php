<?php
/**
 * Mail chooser — what an e-mail link does on a desktop (live since 30 Sep 2026;
 * src/js/mail-chooser.js, src/css/mail-chooser.css; Figma draft mailto-popup 2756:75238, built
 * as a popover under the clicked link — the author's pick over a centred modal).
 *
 * `mailto:` on a desktop does nothing on a Windows machine with no mail client, and opens Apple
 * Mail / Outlook — often the guest's work mail — on a Mac (the team's testing, 30 Sep 2026).
 * Here a desktop click on any `mailto:` link opens this instead: the webmails the guest likely
 * uses, each opening a new letter already addressed, the computer's own mail app, and the
 * address itself with the site's copy chip. Phones and tablets keep `mailto:` (the script only
 * runs for a mouse or trackpad).
 *
 * Russian page: Яндекс Почта · Mail.ru · Gmail; English page: Gmail (author: a list per
 * audience). The app row is ONE row named by the computer — Apple Mail on a Mac, Outlook on
 * Windows — because `mailto:` can only open the default app, whichever it is; two rows would
 * be one action under two names. Icons: the author's Figma exports (assets/icons/mail/).
 *
 * The compose links are filled in by the script from the clicked link (address, subject).
 * Gmail's is long-standing; Yandex's and Mail.ru's are unofficial — drop a row that stops working.
 * Tested by the author (30 Sep 2026), signed in: Gmail, **Yandex** (the composer, the address in
 * «Кому»; not signed in to Yandex Mail → Yandex 360's mail page, i.e. sign-in) and **Mail.ru**
 * (the composer, addressed) — all ✓.
 *
 * @package Sweet_Pepper
 */

$ru = 'ru' === sweet_pepper_lang();
$services = $ru
    ? [ 'yandex' => [ 'Яндекс Почта', 'yandex-mail' ], 'mailru' => [ 'Mail.ru', 'mail-ru' ], 'gmail' => [ 'Gmail', 'gmail' ] ]
    : [ 'gmail' => [ 'Gmail', 'gmail' ] ];
$out = sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' );
?>
<div class="mail-chooser" data-mail-chooser hidden role="dialog" aria-modal="false" aria-labelledby="mail-chooser-title">
    <button type="button" class="mail-chooser__close" data-mail-close aria-label="<?php esc_attr_e( 'Close', 'sweet-pepper' ); ?>">
        <?php echo sweet_pepper_ph( 'x' ); ?>
    </button>

    <div class="mail-chooser__head">
        <p class="mail-chooser__title" id="mail-chooser-title"><?php esc_html_e( 'Write from…', 'sweet-pepper' ); ?></p>
        <p class="mail-chooser__line"><?php esc_html_e( 'A new letter opens there, already addressed.', 'sweet-pepper' ); ?></p>
    </div>

    <ul class="mail-chooser__list">
        <?php foreach ( $services as $key => [ $name, $icon ] ) : ?>
            <li>
                <a class="mail-chooser__option" data-mail-service="<?php echo esc_attr( $key ); ?>" href="#" target="_blank" rel="noopener">
                    <span class="mail-chooser__logo"><?php echo sweet_pepper_inline_svg( "assets/icons/mail/{$icon}.svg" ); ?></span>
                    <span class="mail-chooser__name"><?php echo esc_html( $name ); ?></span>
                    <span class="mail-chooser__out"><?php echo $out; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
        <?php // The computer's own mail app — named by the computer (the script shows one of the two) ?>
        <li data-mail-app="mac" hidden>
            <a class="mail-chooser__option" data-mail-service="app" href="#">
                <span class="mail-chooser__logo"><?php echo sweet_pepper_inline_svg( 'assets/icons/mail/apple-mail.svg' ); ?></span>
                <span class="mail-chooser__name">Apple Mail</span>
                <span class="mail-chooser__out"><?php echo $out; ?></span>
            </a>
        </li>
        <li data-mail-app="windows" hidden>
            <a class="mail-chooser__option" data-mail-service="app" href="#">
                <span class="mail-chooser__logo"><?php echo sweet_pepper_inline_svg( 'assets/icons/mail/outlook.svg' ); ?></span>
                <span class="mail-chooser__name">Outlook</span>
                <span class="mail-chooser__out"><?php echo $out; ?></span>
            </a>
        </li>
    </ul>

    <?php // The address: the site's contact item (the Visit card's), its copy chip icon-only in
          // both languages — the word didn't fit beside the address (author, 30 Sep 2026). Its
          // states are the item's: the chip slides in on hover, Lemon on its own hover, the
          // checkmark when copied (website-brief.md → Chip success state). ?>
    <div class="mail-chooser__address">
        <?php get_template_part( 'template-parts/components/contact-item', null, [
            'icon_svg'  => 'icons/c-mail.svg',
            'contact'   => 'hello@sweetpepper.bar',
            'icon_only' => true,
        ] ); ?>
    </div>
</div>
