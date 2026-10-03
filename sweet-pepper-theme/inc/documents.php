<?php
/**
 * The documents hub — /documents/ and /en/documents/ (page-documents.php, built 3 Oct 2026;
 * words: data/documents.php; styles: src/css/privacy-page.css → Documents hub).
 *
 * One page that points at every legal text: the short version in three lines, a card per
 * published legal page (privacy-policy, consent, consent-analytics — they keep their own
 * addresses: the Metrica consent cites /privacy-policy/ in its text, the forms link /consent/),
 * and the privacy settings. The cookie notice's «Документы» opens it once it is published.
 *
 * @package Sweet_Pepper
 */

/** The hub's address once it is published, '' before. */
function sweet_pepper_documents_url() {
    $page = get_page_by_path( 'documents', OBJECT, 'page' );
    return $page && 'publish' === $page->post_status ? get_permalink( $page ) : '';
}

/**
 * The cards' colour balance (author, 3 Oct 2026 — Chili names read as too much): decided — the
 * names Deep Chili by day (Paprika at night), the kind Olive / Lime. Kept as a flag on purpose
 * (author): `?doctone=olive` — the kind Ash, the names Olive (Mushroom / Lime by night). Returns the class suffix for the card list.
 */
function sweet_pepper_documents_tone() {
    return ( isset( $_GET['doctone'] ) && 'olive' === $_GET['doctone'] ) ? ' documents-cards--olive' : '';
}

/**
 * Everything page-documents.php prints, in the request's language.
 *
 * @return array{words:array, lines:array, cards:array}
 */
function sweet_pepper_documents() {
    $words = require get_template_directory() . '/data/documents.php';
    $ru    = $words['ru'];
    unset( $words['ru'] );
    if ( 'ru' === sweet_pepper_lang() ) {
        $words = array_merge( $words, $ru );
    }

    // The legal pages that are live, with their address and version date
    $docs = [];
    foreach ( array_keys( $words['cards'] ) as $slug ) {
        $page = get_page_by_path( $slug, OBJECT, 'page' );
        if ( ! $page || 'publish' !== $page->post_status ) {
            continue;
        }
        $ymd          = function_exists( 'get_field' ) ? (string) get_field( 'privacy_updated', $page->ID ) : '';
        $docs[ $slug ] = [
            'url'     => get_permalink( $page ),
            'updated' => sweet_pepper_privacy_date( $ymd ),
        ];
    }

    $cards = [];
    foreach ( $words['cards'] as $slug => $card ) {
        if ( isset( $docs[ $slug ] ) ) {
            $cards[] = $card + $docs[ $slug ];
        }
    }
    // A line whose document is not live keeps its words and loses the link
    $lines = array_map( fn( $l ) => $l + [ 'url' => $docs[ $l['doc'] ]['url'] ?? '' ], $words['lines'] );

    return [ 'words' => $words, 'lines' => $lines, 'cards' => $cards ];
}
