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
 * Every inlined icon sits beside words that already say what it means (a button's label, a
 * contact line), so by default it is hidden from screen readers — `aria-hidden` +
 * `focusable="false"` (old Edge / IE tabbed into bare SVGs). An icon that is the only carrier
 * of its meaning (a dish's vegetarian leaf) passes $label and is announced as an image instead.
 *
 * @param string $rel_path Path relative to the theme root, e.g. 'assets/icons/Pepper.svg'.
 * @param string $label    Accessible name for a meaningful icon; '' (default) = decorative.
 * @return string SVG markup, or '' when the file is missing.
 */
function sweet_pepper_inline_svg( string $rel_path, string $label = '' ): string {
    static $instance = 0;

    $abs = get_template_directory() . '/' . ltrim( $rel_path, '/' );
    if ( ! file_exists( $abs ) ) {
        return '';
    }
    $svg = sweet_pepper_svg_a11y( (string) file_get_contents( $abs ), $label );

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

/**
 * Mark an SVG's root element decorative (no label) or as a named image (label).
 *
 * @param string $svg   SVG markup.
 * @param string $label Accessible name, or '' for decorative.
 */
function sweet_pepper_svg_a11y( string $svg, string $label = '' ): string {
    $attrs = '' === $label
        ? ' aria-hidden="true" focusable="false"'
        : ' role="img" aria-label="' . esc_attr( $label ) . '" focusable="false"';
    return (string) preg_replace( '/<svg\b(?![^>]*\baria-hidden=)/', '<svg' . $attrs, $svg, 1 );
}
