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
 * A Phosphor icon, drawn from the theme's own copy (assets/icons/ph/<weight>/<name>.svg, MIT —
 * assets/icons/ph/LICENSE, from @phosphor-icons/core 2.1.1).
 *
 * Until 30 Sep 2026 these came from Phosphor's web font: a blocking script from unpkg.com in
 * <head> that pulled six stylesheets (every weight, thousands of glyphs) from jsdelivr — ahead
 * of every first paint, from abroad, for 13 glyphs. Same glyphs, same sizes: the SVG is 1em
 * square inside the old <i>, so every `font-size` rule written for the font still sizes it
 * (.ph-icon in components.css). Add a glyph by copying it from the package into its weight
 * folder. A glyph that changes with state is several SVGs, CSS showing one (button.php → icon_set).
 *
 * @param string $name   Phosphor name without the weight suffix, e.g. 'map-pin'.
 * @param string $weight 'regular' | 'bold' | 'fill'.
 * @param string $class  Extra classes for the <i>.
 * @return string <i class="ph-icon …"><svg…></i>, or '' when the file is missing.
 */
function sweet_pepper_ph( string $name, string $weight = 'regular', string $class = '' ): string {
    $svg = sweet_pepper_inline_svg( "assets/icons/ph/{$weight}/{$name}.svg" );
    if ( '' === $svg ) {
        return '';
    }
    return '<i class="ph-icon' . ( '' !== $class ? ' ' . esc_attr( $class ) : '' ) . '" aria-hidden="true">' . $svg . '</i>';
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
