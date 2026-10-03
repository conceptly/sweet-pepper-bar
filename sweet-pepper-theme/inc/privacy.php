<?php
/**
 * The privacy policy page — /privacy-policy/ and /en/privacy-policy/ (page-privacy.php, built
 * 28 Sep 2026). A page, not a document: 152-ФЗ ст. 18.1 ч. 2 asks an operator collecting
 * data online to publish its policy with unrestricted access, the cookie notice already
 * links here (Д10 in privacy-policy-review.md), and the team edits it in admin.
 *
 * Fields (acf-json/group_sp_privacy.json, generator): the English title twin, the version
 * date, the text in two languages (the one rich-text field on the site). The Russian text
 * is the legal one; the English is a translation for information, and while it is empty
 * /en/ prints the Russian with a note saying so. The contents list is built from the
 * text's section headings (Заголовок 2), which get ids here.
 *
 * Seeded by tools/page-seed.php privacy from privacy-policy-ru-draft.markdown, as a DRAFT:
 * publishing the page in admin is the owner's approval (author, 28 Sep 2026).
 *
 * @package Sweet_Pepper
 */

/**
 * "28 сентября 2026" / "28 September 2026" in the request's language.
 */
function sweet_pepper_privacy_date( $ymd ) {
    $ts = $ymd ? strtotime( $ymd . ' 12:00:00' ) : 0;
    if ( ! $ts ) {
        return '';
    }
    $locale = $GLOBALS['wp_locale'] ?? null;
    $month  = wp_date( 'm', $ts );
    $name   = $locale ? ( 'ru' === sweet_pepper_lang() ? $locale->get_month_genitive( $month ) : $locale->get_month( $month ) ) : wp_date( 'F', $ts );
    return wp_date( 'j', $ts ) . ' ' . $name . ' ' . wp_date( 'Y', $ts );
}

/**
 * Everything the page prints, in one language.
 *
 * @return array{title:string, short:string, full:string, updated:string, body:string, toc:array<int,array{id:string,label:string}>, fallback:bool}
 */
function sweet_pepper_privacy( $page_id ) {
    $get  = fn( $key ) => function_exists( 'get_field' ) ? (string) get_field( "privacy_{$key}", $page_id ) : '';
    $lang = sweet_pepper_lang();

    $body     = 'en' === $lang ? $get( 'body_en' ) : $get( 'body_ru' );
    $fallback = 'en' === $lang && '' === trim( wp_strip_all_tags( $body ) );
    if ( $fallback ) {
        $body = $get( 'body_ru' );
    }

    // Section headings → ids for the contents list; tables → a scroll box on narrow screens
    $toc  = [];
    $body = preg_replace_callback( '#<h2([^>]*)>(.*?)</h2>#su', function ( $m ) use ( &$toc ) {
        // Entities decoded, as esc_html() escapes the label again (an &apos; showed in the list, 3 Oct 2026)
        $label = trim( html_entity_decode( wp_strip_all_tags( $m[2] ), ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
        $id    = 'section-' . ( count( $toc ) + 1 );
        $toc[] = [ 'id' => $id, 'label' => $label ];
        $attrs = preg_replace( '#\sid="[^"]*"#', '', $m[1] );
        return '<h2 id="' . $id . '"' . $attrs . '>' . $m[2] . '</h2>';
    }, $body );
    $body = preg_replace( '#<table\b#', '<div class="privacy-doc__table"><table', $body );
    $body = str_replace( '</table>', '</table></div>', $body );

    $title_en = $get( 'title_en' );
    $title    = 'en' === $lang && '' !== $title_en ? $title_en : get_the_title( $page_id );

    // The short headline over the full title (author, 3 Oct 2026 — the legal titles ran four
    // Molot lines at 64, seven on a phone): data/documents.php → headlines, by slug
    $words = require get_template_directory() . '/data/documents.php';
    $heads = 'ru' === $lang ? $words['ru']['headlines'] : $words['headlines'];
    $short = $heads[ get_post_field( 'post_name', $page_id ) ] ?? '';

    return [
        'title'    => $title,
        'short'    => $short,
        // The full title under it: a one-letter Russian word keeps to the next one, so «с» or «в»
        // never ends a line (U+00A0)
        'full'     => 'ru' === $lang ? preg_replace( '/(?<=^|\s)([а-яё])\s/iu', "$1\u{00A0}", $title ) : $title,
        'updated'  => sweet_pepper_privacy_date( $get( 'updated' ) ),
        'body'     => $body,
        'toc'      => $toc,
        'fallback' => $fallback,
    ];
}

/** The browser tab carries the title in the request's language. */
add_filter( 'document_title_parts', function ( $parts ) {
    if ( is_page_template( 'page-privacy.php' ) && 'en' === sweet_pepper_lang() ) {
        $en = function_exists( 'get_field' ) ? (string) get_field( 'privacy_title_en', get_queried_object_id() ) : '';
        if ( '' !== $en ) {
            $parts['title'] = $en;
        }
    }
    return $parts;
} );
