<?php
/**
 * Team-replaceable photos — the ratios are enforced by hard-cropped theme sizes, not by
 * the picker (website-brief.md → Content editing → in-place editor → images). A field
 * holds an attachment ID; templates get a URL at the size the component draws.
 *
 * @package Sweet_Pepper
 */

add_action( 'after_setup_theme', function () {
    add_image_size( 'sp-square', 600, 600, true ); // team cards, the picker (1:1)
    add_image_size( 'sp-3x2', 900, 600, true );    // the team wall, dish photos, guests (3:2)
} );

/**
 * A field's photo at a theme size, or the typed asset path while the field is empty.
 *
 * @param int|string $id       Attachment ID from an image field (empty = not set).
 * @param string     $size     'sp-square' | 'sp-3x2'.
 * @param string     $fallback Path under assets/images/, or ''.
 */
function sweet_pepper_photo_url( $id, $size, $fallback = '' ) {
    if ( $id && ( $url = wp_get_attachment_image_url( (int) $id, $size ) ) ) {
        return $url;
    }
    return $fallback ? get_template_directory_uri() . '/assets/images/' . ltrim( $fallback, '/' ) : '';
}
