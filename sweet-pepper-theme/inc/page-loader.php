<?php
/**
 * Page loader — the heat slider while the next page is slow (live since 30 Sep 2026;
 * words: data/page-loader.php, markup: template-parts/components/page-loader.php).
 *
 * The retired hero heat slider as the screen a guest sees while the NEXT page is slow.
 * The wait on a WordPress site is the server's (the old page stays on screen until the new
 * one answers), so the loader starts on the page being LEFT: a click on a link arms a timer,
 * and only a navigation still pending after 700 ms shows it (src/js/page-loader.js). The new
 * page picks it up where it stopped (the inline script in the part), runs the knob to the
 * end — «Подано!» — and lifts it. The footer's «Поддать жару!» / "Heat it up!" replays
 * it on the spot. The markup is the same for every guest, so a page cache can keep it.
 *
 * Switches for checking it — the slow one only locally or for a logged-in editor, since
 * it holds a server worker for the wait:
 *
 *   ?loader=slow           every page takes 3 s longer on the server, for this browser
 *                          (a session cookie), so the loader can be watched
 *   ?loader=slow&wait=6    …6 s longer (1–15)
 *   ?loader=off            back to normal speed
 *   ?loader=stay           this page opens under the loader and keeps it (no cookie);
 *                          &p=0.5 parks the knob, &done runs it to the end and holds
 *                          «Подано!», Esc lifts it
 *   &mode=day|night|auto   pins the loader's day / night for this tab (the part's script)
 *   ?pick=a…f|auto         TRIAL (1 Oct 2026): one look of the name on every screen, for
 *                          this tab (the part's script; the table is in page-loader.css)
 *
 * @package Sweet_Pepper
 */

const SWEET_PEPPER_LOADER_COOKIE = 'sp_loader';

/** May this request slow itself down — the local site, or an editor on any other. */
function sweet_pepper_page_loader_may_slow() {
    return 'local' === wp_get_environment_type() || current_user_can( 'edit_posts' );
}

/**
 * Seconds of added server wait for this request: 0 (normal) or 1–15.
 */
function sweet_pepper_page_loader_wait() {
    static $wait = null;
    if ( null !== $wait ) {
        return $wait;
    }
    $wait = (int) ( $_COOKIE[ SWEET_PEPPER_LOADER_COOKIE ] ?? 0 );
    $ask  = sanitize_key( $_GET['loader'] ?? '' );
    if ( 'off' === $ask ) {
        $wait = 0;
    } elseif ( 'slow' === $ask ) {
        $wait = (int) ( $_GET['wait'] ?? 3 );
    }
    return $wait = sweet_pepper_page_loader_may_slow() ? max( 0, min( 15, $wait ) ) : 0;
}

// The slow switch: store or clear the cookie, and hold a flagged page on the server.
add_action( 'template_redirect', function () {
    $ask = $_GET['loader'] ?? '';
    if ( in_array( $ask, [ 'slow', 'off' ], true ) && ! headers_sent() ) {
        $wait = sweet_pepper_page_loader_wait();
        setcookie( SWEET_PEPPER_LOADER_COOKIE, (string) $wait, [
            'expires'  => $wait ? 0 : time() - 3600, // a session cookie: the next browser start is clean
            'path'     => '/',
            'samesite' => 'Lax',
        ] );
        return; // the page that turns it on answers at once
    }
    $wait = sweet_pepper_page_loader_wait();
    if ( $wait > 0 ) {
        sleep( $wait );
    }
}, 0 );

/** The loader's words in the request's language. */
function sweet_pepper_page_loader_copy() {
    $copy = require get_template_directory() . '/data/page-loader.php';
    $ru   = $copy['ru'];
    unset( $copy['ru'] );
    return 'ru' === sweet_pepper_lang() ? array_merge( $copy, $ru ) : $copy;
}

add_action( 'wp_body_open', function () {
    get_template_part( 'template-parts/components/page-loader', null, sweet_pepper_page_loader_copy() );
} );
