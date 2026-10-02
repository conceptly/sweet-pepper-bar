<?php
/**
 * The 404 page — PROTOTYPE, 1 Oct 2026 (404.php; words: data/not-found.php; styles:
 * src/css/not-found.css). Always dark, like the bar menu: a page that isn't there has no
 * daypart (inc/daypart-head.php sets night before paint).
 *
 * Three layouts on trial, picked on the URL of any address that doesn't exist:
 *
 *   (nothing) / ?nf=0   the author's Figma draft — the number, the notice line under it, the
 *                       centred stack; the digits pop in turn
 *   ?nf=a               the bar answers: copy left, the dish picker's ticket right
 *   ?nf=b               the draft's copy left, the number standing in the footer — and the
 *                       scroll carries it out, to the middle of its column, filling it
 *                       (author, 2 Oct 2026; not-found.css → layout b answers the scroll,
 *                       src/js/not-found.js). Narrow screens: the level alone follows
 *   ?nf=bt              b with the ticket as well (the number stays in the footer)
 *
 * `?nf=`, not `?pick=` (its first hour): the page loader reads `?pick=a…f` on every page and
 * keeps it for the tab (template-parts/components/page-loader.php), so a 404 opened with
 * `?pick=a` also pinned the loader's look a. A tab that did: `?pick=auto` lets it go.
 *
 * @package Sweet_Pepper
 */

/**
 * The layout on trial for this request: '0' | 'a' | 'b' | 'bt'.
 */
function sweet_pepper_not_found_pick() {
    $pick = sanitize_key( $_GET['nf'] ?? '' );
    return in_array( $pick, [ 'a', 'b', 'bt' ], true ) ? $pick : '0';
}

/**
 * The address the guest asked for, as the ticket prints it: the path without the language
 * prefix and without the query (a query can carry anything), readable Cyrillic, 60
 * characters at most. Escape on output.
 */
function sweet_pepper_not_found_asked() {
    [ , $path ] = sweet_pepper_request_lang_path();
    $path = rawurldecode( $path );
    if ( ! wp_check_invalid_utf8( $path ) ) {
        $path = '/';
    }
    $path = preg_replace( '/[\x00-\x1F\x7F]+/u', '', $path );
    $path = '/' . trim( (string) $path, '/' );
    return mb_strlen( $path ) > 60 ? mb_substr( $path, 0, 59 ) . '…' : $path;
}

/**
 * Everything 404.php prints, in the request's language.
 *
 * @return array{pick:string, copy:array, ticket:array, actions:array, asked:string, digits:string, has_ticket:bool}
 */
function sweet_pepper_not_found() {
    $words = require get_template_directory() . '/data/not-found.php';
    $ru    = $words['ru'];
    unset( $words['ru'] );
    if ( 'ru' === sweet_pepper_lang() ) {
        $words = array_merge( $words, $ru );
    }

    $pick = sweet_pepper_not_found_pick();
    $home = [ 'label' => $words['home'], 'url' => home_url( '/' ), 'back' => true ];
    $menu = [ 'label' => $words['view'], 'url' => sweet_pepper_menu_url( 'food' ), 'back' => false ];

    return [
        'pick'       => $pick,
        'copy'       => 'a' === $pick ? $words['menu'] : $words['sauce'],
        'ticket'     => $words['ticket'],
        // The filled button comes first: Home in the draft, the menu where the bar answers
        'actions'    => 'a' === $pick ? [ $menu, $home ] : [ $home, $menu ],
        'asked'      => sweet_pepper_not_found_asked(),
        'digits'     => [ '0' => 'pop', 'a' => '', 'b' => 'sunk', 'bt' => 'sunk' ][ $pick ],
        'has_ticket' => in_array( $pick, [ 'a', 'bt' ], true ),
    ];
}

// The footer's scalloped edge needs to know the layout (not-found.css)
add_filter( 'body_class', function ( $classes ) {
    if ( is_404() ) {
        $classes[] = 'not-found-pick-' . sweet_pepper_not_found_pick();
    }
    return $classes;
} );
