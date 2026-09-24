<?php
/**
 * Visit data — where the Visit template parts get their words.
 *
 * The Visit page's fields (acf-json/group_sp_visit.json, one tab per section, the About
 * shape), read into template-part args in one language. Until a tab is saved the typed copy
 * in data/visit/<section>.php renders instead, so the page never goes blank. Facts that are
 * not confirmed for publishing (the phone, the accounts, the email address), the map links
 * and the form stay in the templates (visit-page-copy-ru-draft.md → Карточка контактов,
 * 3. Обратная связь).
 *
 * @package Sweet_Pepper
 */

/**
 * The Visit page's words for one section: every key of the typed copy through sp_field()
 * as visit_<section>_<key>, the typed copy as the fallback.
 *
 * @param int    $page_id The Visit page.
 * @param string $section Section slug — data/visit/<section>.php.
 * @param array  $keys    Keys to read; default every text key of the typed copy.
 * @return array key → text in the request's language.
 */
function sweet_pepper_visit_words( $page_id, $section, $keys = null ) {
    $typed = require get_template_directory() . "/data/visit/{$section}.php";
    $keys  = $keys ?? array_keys( array_filter( $typed, 'is_string' ) );
    $out   = [];
    foreach ( $keys as $key ) {
        $out[ $key ] = sp_field( "visit_{$section}_{$key}", sweet_pepper_typed( $typed, $key ), $page_id );
    }
    return $out;
}

/**
 * Hero: eyebrow, headline, description.
 */
function sweet_pepper_visit_hero( $page_id ) {
    return sweet_pepper_visit_words( $page_id, 'hero' );
}

/**
 * The status band's words, grouped as src/js/visit-hero.js reads them (data-visit-words):
 * lead / bar / kitchen → engine state → text. The first of each is also what the page
 * prints before the script runs.
 */
function sweet_pepper_visit_status( $page_id ) {
    $w = sweet_pepper_visit_words( $page_id, 'status' );
    return [
        'lead'    => [
            'open'        => $w['lead_open'],
            'last-orders' => $w['lead_last_orders'],
            'bar-snacks'  => $w['lead_bar_snacks'],
            'winding'     => $w['lead_winding'],
            'closed'      => $w['lead_closed'],
        ],
        'bar'     => [
            'open'     => $w['bar_open'],
            'wrapping' => $w['bar_wrapping'],
            'closed'   => $w['bar_closed'],
        ],
        'kitchen' => [
            'open'        => $w['kitchen_open'],
            'last-orders' => $w['kitchen_last_orders'],
            'bar-snacks'  => $w['kitchen_bar_snacks'],
            'closed'      => $w['kitchen_closed'],
        ],
    ];
}

/**
 * The hours card's headings and the evergreen social slot. The hours are Bar Settings'.
 */
function sweet_pepper_visit_hours( $page_id ) {
    return sweet_pepper_visit_words( $page_id, 'hours' );
}

/**
 * The contact card's words (headings and the notes under each contact).
 */
function sweet_pepper_visit_contacts( $page_id ) {
    return sweet_pepper_visit_words( $page_id, 'contacts' );
}

/**
 * Getting here: eyebrow, the "Good to know" slip, the six landmarks. The landmarks are
 * fixed slots (each has its own route map in the template), one group field per slot:
 * visit_landmark_<slot> → name / hint / distance twins. The screen-reader name of each
 * route button is the typed copy's — it needs the genitive, and it follows the slot.
 */
function sweet_pepper_visit_location( $page_id ) {
    $typed = require get_template_directory() . '/data/visit/location.php';
    $words = sweet_pepper_visit_words( $page_id, 'location' );
    $lang  = sweet_pepper_lang();

    $words['landmarks'] = [];
    foreach ( $typed['landmarks'] as $slot => $t ) {
        $saved = function_exists( 'get_field' ) ? get_field( "visit_landmark_{$slot}", $page_id ) : null;
        $row   = [];
        foreach ( [ 'name', 'hint', 'distance' ] as $key ) {
            $value       = is_array( $saved ) ? sweet_pepper_pick( $saved, $key ) : '';
            $row[ $key ] = '' !== $value ? $value : ( ( 'ru' === $lang && '' !== ( $t['ru'][ $key ] ?? '' ) ) ? $t['ru'][ $key ] : $t[ $key ] );
        }
        $row['aria'] = ( 'ru' === $lang ) ? $t['ru']['aria'] : $t['aria'];
        $words['landmarks'][ $slot ] = $row;
    }
    return $words;
}

/**
 * The closing section around the form: headline, text, the entrance photo and its alt
 * (the photo also runs as the phone band above the section).
 */
function sweet_pepper_visit_cta( $page_id ) {
    $typed = require get_template_directory() . '/data/visit/cta.php';
    $words = sweet_pepper_visit_words( $page_id, 'cta', [ 'headline', 'body', 'alt' ] );
    $photo = function_exists( 'get_field' ) ? get_field( 'visit_cta_photo', $page_id ) : '';
    $words['photo'] = sweet_pepper_photo_url( $photo, 'sp-3x2', $typed['photo'] );
    return $words;
}
