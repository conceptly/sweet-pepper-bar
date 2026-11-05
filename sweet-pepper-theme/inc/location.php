<?php
/**
 * The location headline — one for About, Menu and Visit.
 *
 * Bar Settings → «Локация — заголовок» (acf-json/group_sp_location.json), with the typed
 * copy in data/location.php until the fields are saved.
 *
 * @package Sweet_Pepper
 */

/**
 * @return string[] [ line 1, line 2 ] in the request's language.
 */
function sweet_pepper_location_headline() {
    static $lines = null;
    if ( null === $lines ) {
        $lines = sp_headline( 'location_headline', require get_template_directory() . '/data/location.php', 'option' );
    }
    return $lines;
}
