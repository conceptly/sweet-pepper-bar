<?php
/**
 * Cookie notice — PROTOTYPE behind a URL flag (cookie-notice-plan.md, 27 Sep 2026).
 *
 * `?notice=corner` — a card under the language switch (B); `?notice=band` — a band under
 * the header (C). Both fixed; cookie-notice.js slides them in after the page has loaded and
 * a delay (`&delay=<seconds>` to shorten it; `&again` re-shows a dismissed note).
 * **The band at the foot of the viewport is the site's default since 27 Sep 2026 (author)**
 * — it prints without a flag; `?notice=corner` still shows the card while it is being judged,
 * `&pos=top` hangs either note under the header to compare, `?notice=off` prints nothing. The copy is the draft's working choice; "maps load when you ask" is a promise the
 * maps do not keep yet (К01 — plan §3).
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

$policy_url  = sweet_pepper_lang_root( sweet_pepper_lang() ) . 'privacy-policy/'; // Д10 — the page does not exist yet
$policy_link = '<a href="' . esc_url( $policy_url ) . '">' . esc_html__( 'privacy policy', 'sweet-pepper' ) . '</a>';
?>
<aside class="cookie-notice<?php echo $dark ? ' cookie-notice--dark' : ''; ?>" data-variant="<?php echo esc_attr( $variant ); ?>" data-pos="<?php echo esc_attr( $pos ); ?>" role="region" aria-labelledby="cookie-notice-title" hidden>
    <div class="cookie-notice__box"><?php // display: contents, except the desktop bottom card, where the aside is a glass strip and this is the card ?>
    <p class="cookie-notice__title" id="cookie-notice-title"><?php esc_html_e( 'No one’s keeping tabs', 'sweet-pepper' ); ?></p>
    <p class="cookie-notice__text cookie-notice__text--full">
        <?php
        /* translators: %s: link to the privacy policy */
        echo wp_kses( sprintf( __( 'This site sets no tracking cookies and remembers only your choice, in this browser. Yandex and Google maps load when you ask for them. Details in the %s.', 'sweet-pepper' ), $policy_link ), [ 'a' => [ 'href' => [] ] ] );
        ?>
    </p>
    <p class="cookie-notice__text cookie-notice__text--short">
        <?php esc_html_e( 'No tracking cookies. Maps load only when you ask.', 'sweet-pepper' ); ?>
        <a href="<?php echo esc_url( $policy_url ); ?>"><?php esc_html_e( 'Details', 'sweet-pepper' ); ?></a>
    </p>
    <button type="button" class="btn btn-secondary cookie-notice__ok"><?php esc_html_e( 'Got it', 'sweet-pepper' ); ?></button>
    </div>
</aside>
