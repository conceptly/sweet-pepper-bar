<?php
/**
 * ACF Configuration and Options Pages
 *
 * @package Sweet_Pepper
 */

// Add ACF Options Page for Hours
if ( function_exists( 'acf_add_options_page' ) ) {
    acf_add_options_page( array(
        'page_title'    => 'Bar Hours & Settings',
        'menu_title'    => 'Bar Settings',
        'menu_slug'     => 'sweet-pepper-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ) );
}

// Ensure ACF saves JSON to the theme directory to track fields in Git
add_filter( 'acf/settings/save_json', 'sweet_pepper_acf_json_save_point' );
function sweet_pepper_acf_json_save_point( $path ) {
    // update path
    $path = get_template_directory() . '/acf-json';
    return $path;
}

// Ensure ACF loads JSON from the theme directory
add_filter( 'acf/settings/load_json', 'sweet_pepper_acf_json_load_point' );
function sweet_pepper_acf_json_load_point( $paths ) {
    // remove original path
    unset( $paths[0] );
    // append path
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}

// Fields the theme fills in itself (a dish row's stable id) stay out of the form.
add_action( 'acf/input/admin_head', function () {
    echo '<style>.acf-field.sp-field-hidden { display: none !important; }</style>';
} );

// A page cache purges on a post save by itself, not on an options-page save — and Bar
// Settings prints into every page (hours, the location headline). WP Super Cache, when
// it is installed (website-brief.md → Plugin cap → 3).
add_action( 'acf/save_post', function ( $post_id ) {
    if ( 'options' === $post_id && function_exists( 'wp_cache_clear_cache' ) ) {
        wp_cache_clear_cache();
    }
}, 20 );
