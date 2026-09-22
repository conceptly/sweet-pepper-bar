<?php
/**
 * Fields in two languages — one record, an `_ru` / `_en` twin per text
 * (website-brief.md → Content editing & languages → Language model).
 *
 * The theme prints ONE language per request — sweet_pepper_lang() (inc/lang.php) says which. Templates never read a twin by name:
 * prose comes through sp_field(), rows through a named function in inc/ that hands
 * back one language (inc/menu-data.php, inc/about-data.php).
 *
 * @package Sweet_Pepper
 */

/**
 * A row's text in the request's language. The other language stands in for a twin
 * left empty, rather than a blank.
 *
 * @param array  $row A repeater row, or any array holding "{$key}_ru" / "{$key}_en".
 * @param string $key Field name without the language suffix.
 */
function sweet_pepper_pick( $row, $key ) {
    $lang  = sweet_pepper_lang();
    $other = 'ru' === $lang ? 'en' : 'ru';
    return trim( (string) ( $row[ "{$key}_{$lang}" ] ?? '' ) ) ?: trim( (string) ( $row[ "{$key}_{$other}" ] ?? '' ) );
}

/**
 * A prose field in the request's language: the field, else its twin, else $fallback —
 * the copy as typed before the page moved into WordPress, so a page converts without
 * ever going blank.
 *
 * @param string     $name     Field name without the language suffix.
 * @param string     $fallback Typed copy.
 * @param int|string $post_id  Page ID, or 'option' for Bar Settings.
 */
function sp_field( $name, $fallback = '', $post_id = false ) {
    if ( ! function_exists( 'get_field' ) ) {
        return $fallback;
    }
    $value = sweet_pepper_pick( [
        "{$name}_ru" => get_field( "{$name}_ru", $post_id ),
        "{$name}_en" => get_field( "{$name}_en", $post_id ),
    ], $name );
    return '' !== $value ? $value : $fallback;
}

/**
 * A two-line headline, both lines from the SAME language: a headline can be two lines
 * in one language and one in the other (WANT TO JOIN / THE FAMILY? · ХОТИТЕ В СЕМЬЮ?),
 * so an empty line 2 must not borrow its twin.
 *
 * @param string     $name    Field name of line 1 without the suffix; line 2 is "{$name}_2".
 * @param array      $typed   Typed copy holding 'headline' / 'headline_2' (and 'ru' twins).
 * @param int|string $post_id Page ID, or 'option'.
 * @return string[] [ line 1, line 2 ]
 */
function sp_headline( $name, $typed, $post_id = false ) {
    $lang = sweet_pepper_lang();
    if ( function_exists( 'get_field' ) ) {
        foreach ( [ $lang, 'ru' === $lang ? 'en' : 'ru' ] as $l ) {
            $line = trim( (string) get_field( "{$name}_{$l}", $post_id ) );
            if ( '' !== $line ) {
                return [ $line, trim( (string) get_field( "{$name}_2_{$l}", $post_id ) ) ];
            }
        }
    }
    $from = ( 'ru' === $lang && ! empty( $typed['ru']['headline'] ) ) ? $typed['ru'] : $typed;
    return [ (string) ( $from['headline'] ?? '' ), (string) ( $from['headline_2'] ?? '' ) ];
}

/**
 * Typed copy in the request's language: $typed['ru'][ $key ] when the request is
 * Russian and a twin was typed, else $typed[ $key ] (data/about/*.php, data/location.php).
 */
function sweet_pepper_typed( $typed, $key ) {
    $ru = 'ru' === sweet_pepper_lang() ? trim( (string) ( $typed['ru'][ $key ] ?? '' ) ) : '';
    return '' !== $ru ? $ru : (string) ( $typed[ $key ] ?? '' );
}
