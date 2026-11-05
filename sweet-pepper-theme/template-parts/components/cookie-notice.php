<?php
/** Shared optional-service notice. ?notice=corner and &pos=top retain preview variants.
 * Allow/refuse applies to both services; the underlined settings control opens independent switches.
 * An old Got it dismissal is never permission.
 *
 * Tone (author, 2 Oct 2026; Figma noticeContent-lime 2842:73295 / noticeContent-theme 2845:73553):
 * the Lime band is the default; `?noticetone=theme` follows the theme instead — Parchment with an
 * Avocado top line by day, Soft Peppercorn with a Lime one at night and on the fixed dark pages.
 * After a choice made in the band, a short confirmation takes its place (cookie-notice.js);
 * `?noticedone=0` closes the band at once instead, to compare. */

$variant = isset( $_GET['notice'] ) ? sanitize_key( wp_unslash( $_GET['notice'] ) ) : 'band';
if ( ! in_array( $variant, [ 'corner', 'band' ], true ) ) {
    return; // `?notice=off` (or anything else): no note
}

// About, Visit and a vacancy are fixed dark compositions: the note takes the dark recipe there
// whatever the hour, as the header does (header.css).
$pos  = ( isset( $_GET['pos'] ) && 'top' === $_GET['pos'] ) ? 'top' : 'bottom'; // the foot of the viewport by default (author, 27 Sep 2026 — the top band had gone default by mistake); `&pos=top` to compare
$dark = is_page_template( 'page-about.php' ) || is_page_template( 'page-visit.php' ) || is_singular( 'vacancy' );
$tone = ( isset( $_GET['noticetone'] ) && 'theme' === $_GET['noticetone'] ) ? 'theme' : 'lime';

$policy_page = get_page_by_path( 'privacy-policy' );
$policy_url = $policy_page && 'publish' === $policy_page->post_status ? get_permalink( $policy_page ) : '';
// «Документы» opens the documents hub once it is published (author, 3 Oct 2026); the policy until then.
// English says “Documents” with the hub too — “Privacy policy” would name one of three texts.
$docs_url = sweet_pepper_documents_url();
$ru = 'ru' === sweet_pepper_lang();
// No lone word on a sentence's last line (author, 3 Oct 2026): the last two words are glued with
// a no-break space, whatever the viewport; the links after it wrap as one (cookie-notice.css)
$glue = static function ( $text ) { return preg_replace( '/ (\S+)$/u', "\u{00A0}$1", $text ); };
$settings_link = '<button type="button" class="map-settings-link" data-privacy-settings hidden>' . ( $ru ? 'Настроить' : 'Settings' ) . '</button>';
?>
<aside class="cookie-notice<?php echo $dark ? ' cookie-notice--dark' : ''; ?>" data-variant="<?php echo esc_attr( $variant ); ?>" data-pos="<?php echo esc_attr( $pos ); ?>" data-tone="<?php echo esc_attr( $tone ); ?>" role="region" aria-labelledby="cookie-notice-title" hidden>
    <div class="cookie-notice__box"><?php // display: contents, except the desktop bottom card, where the aside is a glass strip and this is the card ?>
    <p class="cookie-notice__title" id="cookie-notice-title"><?php echo $ru ? 'Все карты<br class="cookie-notice__br"> на стол' : 'Cards on<br class="cookie-notice__br"> the table'; // the break only on the desktop band ?></p>
    <div class="cookie-notice__ask"><?php // the question; display: contents, so its parts lay out as the box's own ?>
        <?php foreach ( [ 'full', 'short' ] as $length ) : ?>
        <p class="cookie-notice__text cookie-notice__text--<?php echo $length; ?>">
            <?php // The sentence carries the wider gap at its end, so links that wrap start flush; the links wrap as one ?>
            <span class="cookie-notice__sentence"><?php echo $glue( $ru ? 'Запоминаем язык. Карты Google и Яндекс Метрика — с вашего разрешения. Метрика использует cookies и анализирует действия на сайте — помогает ПЕРЦАМ сделать его удобнее!' : 'We remember your language. Google Maps and Yandex Metrica need your permission. Metrica uses cookies and analyses how you use the site — helping the PEPPERS make it better!' ); ?></span>
            <span class="cookie-notice__links"><?php if ( $docs_url || $policy_url ) : ?><a href="<?php echo esc_url( $docs_url ?: $policy_url ); ?>"><?php echo $ru ? 'Документы' : ( $docs_url ? 'Documents' : 'Privacy policy' ); // «Подробнее» read as a twin of «Настроить»; RU short as the policy page's eyebrow (author, 3 Oct 2026) ?></a> <?php endif; ?><?php echo $settings_link; ?></span>
        </p>
        <?php endforeach; ?>
        <div class="cookie-notice__actions">
            <button type="button" class="btn btn-secondary" data-privacy-choice="allow"><?php echo $ru ? 'На здоровье!' : 'Go ahead!'; ?></button>
            <button type="button" class="btn btn-secondary" data-privacy-choice="block"><?php echo $ru ? 'Нет, спасибо' : 'No, thanks'; ?></button>
        </div>
    </div>
    <?php // The confirmation after a choice in the band: one way back (Настроить), one way out (Закрыть).
          // The sentence is written into the live region only once it is shown, so it is announced. ?>
    <div class="cookie-notice__done">
        <p class="cookie-notice__text cookie-notice__text--short cookie-notice__text--done">
            <span class="cookie-notice__sentence" role="status"
                data-allow="<?php echo esc_attr( $glue( $ru ? 'Готово! Карты Google и Яндекс Метрика включены: маршрут к нам теперь прямо на сайте, а ПЕРЦЫ увидят, что сделать удобнее. Передумаете?' : 'Done! Google Maps and Yandex Metrica are on: the route to us now shows right on the site, and the PEPPERS see what to make easier. Changed your mind?' ) ); ?>"
                data-block="<?php echo esc_attr( $glue( $ru ? 'Как скажете! Карты Google и Яндекс Метрика выключены, сайт работает как обычно — запомним только язык. Маршрут к нам откроется по ссылке в Google Картах.' : 'As you wish! Google Maps and Yandex Metrica are off, and the site works as usual — we’ll only remember your language. The route to us opens by link in Google Maps.' ) ); ?>"
                data-saved-both="<?php echo esc_attr( $glue( $ru ? 'Сохранили! Карты Google и Яндекс Метрика включены. Изменить выбор можно в любой момент внизу сайта.' : 'Saved! Google Maps and Yandex Metrica are on. You can change your choice at any time at the foot of the site.' ) ); ?>"
                data-saved-none="<?php echo esc_attr( $glue( $ru ? 'Сохранили! Карты Google и Яндекс Метрика выключены — запомним только язык. Изменить выбор можно в любой момент внизу сайта.' : 'Saved! Google Maps and Yandex Metrica are off — we’ll only remember your language. You can change your choice at any time at the foot of the site.' ) ); ?>"
                data-saved-maps="<?php echo esc_attr( $glue( $ru ? 'Сохранили! Карты Google включены, Яндекс Метрика выключена. Изменить выбор можно в любой момент внизу сайта.' : 'Saved! Google Maps is on, Yandex Metrica is off. You can change your choice at any time at the foot of the site.' ) ); ?>"
                data-saved-metrica="<?php echo esc_attr( $glue( $ru ? 'Сохранили! Яндекс Метрика включена, карты Google выключены. Изменить выбор можно в любой момент внизу сайта.' : 'Saved! Yandex Metrica is on, Google Maps is off. You can change your choice at any time at the foot of the site.' ) ); ?>"></span>
            <span class="cookie-notice__links"><?php echo $settings_link; ?></span>
        </p>
        <div class="cookie-notice__actions">
            <button type="button" class="btn btn-secondary" data-notice-close><?php echo $ru ? 'Закрыть' : 'Close'; ?></button>
        </div>
    </div>
    </div>
</aside>
