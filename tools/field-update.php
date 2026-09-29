<?php
/**
 * Apply a dated set of field changes to a page — the database half of a deploy, since
 * SCF values do not travel with the theme. Each group is all-or-nothing and applies only
 * where every field still holds its expected old value, so text edited in admin since is
 * left alone (and reported). Safe to run twice: a group already applied reports "done".
 *
 * Run with PHP from the WordPress root's parent folder, or point WP_ROOT at it:
 *
 *   WP_ROOT=~/SweetPepper-test/public_html php tools/field-update.php tools/field-updates/2026-09-22-about-ru.json
 *   (Local: see tools/page-seed.php for the PHP binary and the socket)
 *
 * File shape: { "page": "<slug>", "groups": [ { "note": "…", "set": [ [ field, old, new ], … ] } ] }.
 * For a one-record type (the «Гастробот» pairings) give "post_type" instead of "page";
 * for Bar Settings (the options page — hours, the location headline) give "option": true.
 * Field keys follow tools/page-field-groups.py: key = "field_sp_" . name. A field inside a
 * repeater row has no key of its own — name it as saved, row index included
 * ("about_perks_5_title_ru"); it is then written by name, as the row stores it.
 *
 * An image field is named by its theme asset, "asset:bar/wine/red-2.jpg", because attachment
 * IDs differ between installs: the current value is the attachment's `_sp_source` (what
 * tools/page-seed.php stamps), the new one is found by it or uploaded from the theme's
 * assets/images/ as the seeder does. A photo the team replaced in admin has no source, so its
 * group is skipped. An upload takes its Media Library alt (Russian) and «Тема» from the file's
 * optional "uploads": { "<asset>": { "alt": "…", "topic": "Бар" } }. Posts only, not the
 * options page (28 Sep 2026, the Гастробот drink photos). Every "uploads" entry is uploaded,
 * even one no field names yet — spares for the team to pick in admin. A date picker is written
 * as stored, "20260926".
 */

$file = $argv[1] ?? '';
if ( ! is_file( $file ) ) {
    exit( "Usage: field-update.php <tools/field-updates/*.json>\n" );
}
$spec = json_decode( file_get_contents( $file ), true );

/** The value to compare: the text, or for an "asset:" field the attachment's theme source. */
function sp_update_current( $name, $post_id, $asset ) {
    if ( ! $asset ) {
        return trim( (string) get_field( $name, $post_id ) );
    }
    $id = (int) get_post_meta( $post_id, $name, true );
    return $id ? 'asset:' . get_post_meta( $id, '_sp_source', true ) : '';
}

/** "asset:<path>" → the attachment ID, uploading the theme file the first time (page-seed.php's sp_seed_attachment). */
function sp_update_attachment( $value, $uploads = [] ) {
    $asset = substr( $value, 6 );
    $found = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => 1, 'fields' => 'ids',
                          'meta_key' => '_sp_source', 'meta_value' => $asset ] );
    if ( $found ) {
        return (int) $found[0];
    }
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $file = get_template_directory() . '/assets/images/' . $asset;
    if ( ! is_file( $file ) ) {
        exit( "No theme asset {$asset}.\n" );
    }
    $up = wp_upload_bits( basename( $asset ), null, file_get_contents( $file ) );
    if ( ! empty( $up['error'] ) ) {
        exit( "upload failed for {$asset}: {$up['error']}\n" );
    }
    $id = wp_insert_attachment( [
        'post_mime_type' => $up['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $asset ) ),
        'post_status'    => 'inherit',
    ], $up['file'] );
    wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $up['file'] ) );
    update_post_meta( $id, '_sp_source', $asset );
    if ( ! empty( $uploads[ $asset ]['alt'] ) ) {
        update_post_meta( $id, '_wp_attachment_image_alt', $uploads[ $asset ]['alt'] );
    }
    if ( ! empty( $uploads[ $asset ]['topic'] ) && taxonomy_exists( 'media_topic' ) ) {
        wp_set_object_terms( $id, $uploads[ $asset ]['topic'], 'media_topic' );
    }
    echo "uploaded {$asset} as attachment {$id}\n";
    return (int) $id;
}

$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

if ( ! empty( $spec['option'] ) ) {
    $page = (object) [ 'ID' => 'option' ];
} elseif ( ! empty( $spec['post_type'] ) ) {
    $page = get_posts( [ 'post_type' => $spec['post_type'], 'post_status' => 'any', 'numberposts' => 1, 'orderby' => 'ID', 'order' => 'ASC' ] )[0] ?? null;
    if ( ! $page ) {
        exit( "No '{$spec['post_type']}' record.\n" );
    }
} else {
    $page = get_page_by_path( $spec['page'] );
    if ( ! $page ) {
        exit( "No page with the slug '{$spec['page']}'.\n" );
    }
}

foreach ( $spec['groups'] as $group ) {
    $label = $group['note'] . ' — ' . implode( ', ', array_column( $group['set'], 0 ) );
    $cur   = [];
    foreach ( $group['set'] as [ $name, $old, $new ] ) {
        $cur[ $name ] = sp_update_current( $name, $page->ID, 0 === strpos( (string) $new, 'asset:' ) );
    }
    // A date picker reads back formatted ("2026-09-26") but is written as stored ("20260926"):
    // the raw row counts as done too, so a second run says "done", not SKIPPED.
    $is_new = fn( $r ) => $cur[ $r[0] ] === $r[2] || ( is_int( $page->ID ) && (string) get_post_meta( $page->ID, $r[0], true ) === (string) $r[2] );
    if ( array_filter( $group['set'], $is_new ) === $group['set'] ) {
        echo "done     {$label}\n";
        continue;
    }
    $stale = array_filter( $group['set'], fn( $r ) => $cur[ $r[0] ] !== $r[1] );
    if ( $stale ) {
        echo "SKIPPED  {$label}\n";
        foreach ( $stale as [ $name ] ) {
            echo "         {$name} now holds: " . ( '' === $cur[ $name ] ? '(empty)' : $cur[ $name ] ) . "\n";
        }
        continue;
    }
    foreach ( $group['set'] as [ $name, , $new ] ) {
        // A field that has been saved carries a reference (_name → key): write it BY NAME, so
        // SCF keeps the saved name. Writing a group's sub-field by its key saves it under the
        // bare sub-field name ("name_ru", not "visit_landmark_door_name_ru") — 27 Sep 2026, the
        // landmark names reported "applied" twice and never changed. The key is for a field
        // never saved on this page (no reference yet); a repeater row's field has neither.
        if ( 0 === strpos( (string) $new, 'asset:' ) ) {
            $new = sp_update_attachment( $new, $spec['uploads'] ?? [] );
        }
        $key = 'field_sp_' . $name;
        $ref = function_exists( 'acf_get_reference' ) ? acf_get_reference( $name, $page->ID ) : '';
        update_field( ( ! $ref && acf_get_field( $key ) ) ? $key : $name, $new, $page->ID );
    }
    echo "applied  {$label}\n";
}

// Every "uploads" entry reaches the Media Library, used or not — spare photos the team can pick
// in admin (28 Sep 2026, the English page's Instagram posts: eight supplied, five cards).
if ( empty( $spec['option'] ) ) {
    foreach ( array_keys( $spec['uploads'] ?? [] ) as $asset ) {
        sp_update_attachment( 'asset:' . $asset, $spec['uploads'] );
    }
}
