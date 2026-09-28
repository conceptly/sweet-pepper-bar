<?php
/**
 * Cookie notice — PROTOTYPE behind a URL flag (cookie-notice-plan.md, 27 Sep 2026).
 *
 * `?notice=corner` — a card under the language switch (B); `?notice=band` — a band under
 * the header (C). Both fixed; cookie-notice.js slides them in after the page has loaded and
 * a delay (`&delay=<seconds>` to shorten it; `&again` re-shows a dismissed note).
 * **The band at the foot of the viewport is the site's default since 27 Sep 2026 (author)**
 * — it prints without a flag; `?notice=corner` still shows the card while it is being judged,
 * `&pos=top` hangs either note under the header to compare, `?notice=off` prints nothing. Map permission is separate from dismissing this notice (28 Sep 2026).
 *
 * Voice: the bar speaking first person — sanctioned for status messages (design.md §1.1).
 */

$variant = isset( $_GET['notice'] ) ? sanitize_key( wp_unslash( $_GET['notice'] ) ) : 'band';
if ( ! in_array( $variant, [ 'corner', 'band' ], true ) ) {
    return; // `?notice=off` (or anything else): no note
}

// About, Visit and a vacancy are fixed dark compositions: the note takes the dark recipe there
// whatever the hour, as the header does (header.css).
$pos  = ( isset( $_GET['pos'] ) && 'top' === $_GET['pos'] ) ? 'top' : 'bottom'; // the foot of the viewport by default (author, 27 Sep 2026 — the top band had gone default by mistake); `&pos=top` to compare
$dark = is_page_template( 'page-about.php' ) || is_page_template( 'page-visit.php' ) || is_singular( 'vacancy' );

$policy_page = get_page_by_path( 'privacy-policy' );
$policy_url = $policy_page && 'publish' === $policy_page->post_status ? get_permalink( $policy_page ) : '';
$ru = 'ru' === sweet_pepper_lang();
?>
<aside class="cookie-notice<?php echo $dark ? ' cookie-notice--dark' : ''; ?>" data-variant="<?php echo esc_attr( $variant ); ?>" data-pos="<?php echo esc_attr( $pos ); ?>" role="region" aria-labelledby="cookie-notice-title" hidden>
    <div class="cookie-notice__box"><?php // display: contents, except the desktop bottom card, where the aside is a glass strip and this is the card ?>
    <p class="cookie-notice__title" id="cookie-notice-title"><?php echo $ru ? 'Все карты на стол' : 'Cards on the table'; ?></p>
    <p class="cookie-notice__text cookie-notice__text--full">
        <?php echo $ru ? 'Запоминаем язык и настройки интерфейса в этом браузере. Карты Google загружаем только с вашего разрешения. Изменить выбор можно внизу сайта.' : 'We remember your language and interface settings in this browser. Google maps load only with your permission. Change your choice in the footer.'; ?>
        <?php if ( $policy_url ) : ?><a href="<?php echo esc_url( $policy_url ); ?>"><?php esc_html_e( 'privacy policy', 'sweet-pepper' ); ?></a><?php endif; ?>
    </p>
    <p class="cookie-notice__text cookie-notice__text--short">
        <?php echo $ru ? 'Запоминаем язык. Карты Google — с вашего разрешения. Настройки карт — внизу сайта.' : 'We remember your language. Google maps need your permission. Map settings are in the footer.'; ?>
        <?php if ( $policy_url ) : ?><a href="<?php echo esc_url( $policy_url ); ?>"><?php esc_html_e( 'Details', 'sweet-pepper' ); ?></a><?php endif; ?>
    </p>
    <button type="button" class="btn btn-secondary cookie-notice__ok"><?php esc_html_e( 'Got it', 'sweet-pepper' ); ?></button>
    </div>
</aside>
