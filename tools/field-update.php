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
 */

$file = $argv[1] ?? '';
if ( ! is_file( $file ) ) {
    exit( "Usage: field-update.php <tools/field-updates/*.json>\n" );
}
$spec = json_decode( file_get_contents( $file ), true );

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
        $cur[ $name ] = trim( (string) get_field( $name, $page->ID ) );
    }
    if ( array_filter( $group['set'], fn( $r ) => $cur[ $r[0] ] === $r[2] ) === $group['set'] ) {
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
        $key = 'field_sp_' . $name;
        $ref = function_exists( 'acf_get_reference' ) ? acf_get_reference( $name, $page->ID ) : '';
        update_field( ( ! $ref && acf_get_field( $key ) ) ? $key : $name, $new, $page->ID );
    }
    echo "applied  {$label}\n";
}
