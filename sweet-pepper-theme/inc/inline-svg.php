<?php
/**
 * Inline an SVG file with per-instance unique ids.
 *
 * Figma exports carry ids like `clip0_52_3199`; the same icon inlined twice — or two
 * icons exported from the same frame — put duplicate ids in the DOM, and every
 * `url(#…)` then resolves to the first copy. Seen Sep 2026: the home bar-preview CTA's
 * pepper (`Pepper.svg`) vanished on phones because the mobile drawer's marker
 * (`c-Pepper.svg`) defines the same clipPath id earlier in the document.
 *
 * @param string $rel_path Path relative to the theme root, e.g. 'assets/icons/Pepper.svg'.
 * @return string SVG markup, or '' when the file is missing.
 */
function sweet_pepper_inline_svg( string $rel_path ): string {
    static $instance = 0;

    $abs = get_template_directory() . '/' . ltrim( $rel_path, '/' );
    if ( ! file_exists( $abs ) ) {
        return '';
    }
    $svg = (string) file_get_contents( $abs );

    if ( ! preg_match_all( '/\bid="([^"]+)"/', $svg, $m ) ) {
        return $svg;
    }
    $instance++;
    $ids = array_unique( $m[1] );
    foreach ( $ids as $id ) {
        $new = $id . '-i' . $instance;
        $svg = str_replace(
            [ 'id="' . $id . '"', 'url(#' . $id . ')', 'href="#' . $id . '"' ],
            [ 'id="' . $new . '"', 'url(#' . $new . ')', 'href="#' . $new . '"' ],
            $svg
        );
    }
    return $svg;
}
