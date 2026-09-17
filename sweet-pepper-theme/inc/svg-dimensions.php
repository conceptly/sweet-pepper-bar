<?php
/**
 * Intrinsic dimensions of theme SVG assets
 *
 * Used by the section connector ("link word") component so each <img> can
 * carry width/height attributes. Browsers derive an aspect-ratio from those
 * attributes and reserve the band's height before the file loads — without
 * it a lazy-loaded connector is 0px tall until fetched, the page grows as
 * connectors load, and anchor scrolls land short of their target.
 *
 * @package Sweet_Pepper
 */

/**
 * Read the intrinsic width/height of an SVG in the theme.
 *
 * Prefers the viewBox (the true drawing box); falls back to the width/height
 * attributes on the root element. Only the head of the file is read. Results
 * are memoised per request and in the object cache, keyed on the file's mtime
 * so re-exported assets are picked up automatically.
 *
 * @param string $rel_path Path relative to the theme root, e.g. 'assets/sectionLinks/menu/bar/houseSecret.svg'.
 * @return array{width:int,height:int}|null Integer dimensions, or null if the file is missing or unparsable.
 */
function sweet_pepper_svg_dimensions( string $rel_path ): ?array {
    static $memo = [];

    $rel_path = ltrim( $rel_path, '/' );
    if ( isset( $memo[ $rel_path ] ) ) {
        return $memo[ $rel_path ] ?: null;
    }

    $file  = get_template_directory() . '/' . $rel_path;
    $mtime = @filemtime( $file );
    if ( ! $mtime ) {
        $memo[ $rel_path ] = false;
        return null;
    }

    $cache_key = 'svg_dims_' . md5( $rel_path . '|' . $mtime );
    $cached    = wp_cache_get( $cache_key, 'sweet_pepper' );
    if ( is_array( $cached ) ) {
        $memo[ $rel_path ] = $cached;
        return $cached;
    }

    $dims = sweet_pepper_parse_svg_dimensions( (string) @file_get_contents( $file, false, null, 0, 2048 ) );

    $memo[ $rel_path ] = $dims ?: false;
    if ( $dims ) {
        wp_cache_set( $cache_key, $dims, 'sweet_pepper', DAY_IN_SECONDS );
    }
    return $dims;
}

/**
 * Parse width/height out of the opening <svg> tag.
 *
 * @param string $head The start of an SVG document (needs to include the root tag).
 * @return array{width:int,height:int}|null
 */
function sweet_pepper_parse_svg_dimensions( string $head ): ?array {
    if ( ! preg_match( '/<svg\b[^>]*>/i', $head, $m ) ) {
        return null;
    }
    $tag = $m[0];

    $w = $h = 0.0;

    if ( preg_match( '/\bviewBox\s*=\s*["\']\s*([-\d.eE+]+)[\s,]+([-\d.eE+]+)[\s,]+([-\d.eE+]+)[\s,]+([-\d.eE+]+)\s*["\']/i', $tag, $vb ) ) {
        $w = (float) $vb[3];
        $h = (float) $vb[4];
    } elseif (
        preg_match( '/\bwidth\s*=\s*["\']\s*([\d.]+)(?:px)?\s*["\']/i', $tag, $wm ) &&
        preg_match( '/\bheight\s*=\s*["\']\s*([\d.]+)(?:px)?\s*["\']/i', $tag, $hm )
    ) {
        $w = (float) $wm[1];
        $h = (float) $hm[1];
    }

    if ( $w <= 0 || $h <= 0 ) {
        return null;
    }

    // HTML width/height attributes must be integers. Scale fractional boxes up
    // so the ratio survives rounding (the CSS sizes the image anyway).
    $scale = ( floor( $w ) === $w && floor( $h ) === $h ) ? 1 : 100;

    return [
        'width'  => (int) round( $w * $scale ),
        'height' => (int) round( $h * $scale ),
    ];
}
