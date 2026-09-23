<?php
/**
 * Label unlabelled images with a media topic by where the site uses them
 * (sweet-pepper-theme/inc/media-topics.php). Images that already carry a topic are
 * left alone, so the team's choices win; an image used nowhere is listed, not guessed.
 *
 *   PHP=~/Library/Application\ Support/Local/lightning-services/php-8.2.30+1/bin/darwin-arm64/bin/php
 *   SOCK=~/Library/Application\ Support/Local/run/1tx2Lcx_A/mysql/mysqld.sock
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/media-topics.php [--dry-run]
 *
 * On the test site: WP_ROOT=~/SweetPepper-test/public_html php tools/media-topics.php
 */

$dry     = in_array( '--dry-run', $argv, true );
$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

sweet_pepper_media_topics_ensure(); // the default topics, if this install has never opened admin

// The field an image sits in → its topic. Keys are matched whole (row numbers stripped),
// never by value alone: an attachment ID can equal a price.
$by_field = [
    '/^pairs_\d+_dish_photo$/'            => 'food',
    '/^pairs_\d+_drink_photo$/'           => 'bar',
    '/^about_team_members_\d+_photo$/'    => 'team',
    '/^about_founder_photo$/'             => 'team',
    '/^about_team_wall_\d+_photo$/'       => 'team',
    '/^about_guest_cards_\d+_photo$/'     => 'guests',
];
$by_name = [ '/logo|symbol/i' => 'brand' ];

global $wpdb;
$images = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'inherit', 'numberposts' => -1, 'post_mime_type' => 'image' ] );
$done = $skipped = [];
$none = [];
foreach ( $images as $img ) {
    $name = basename( (string) get_attached_file( $img->ID ) );
    if ( wp_get_object_terms( $img->ID, 'media_topic', [ 'fields' => 'ids' ] ) ) {
        $skipped[] = $name;
        continue;
    }
    $topics = [];
    $keys   = $wpdb->get_col( $wpdb->prepare( "SELECT meta_key FROM $wpdb->postmeta WHERE meta_value = %s", (string) $img->ID ) );
    foreach ( $keys as $key ) {
        foreach ( $by_field as $re => $slug ) {
            if ( preg_match( $re, $key ) ) {
                $topics[ $slug ] = true;
            }
        }
    }
    foreach ( $by_name as $re => $slug ) {
        if ( preg_match( $re, $name . ' ' . $img->post_title ) ) {
            $topics[ $slug ] = true;
        }
    }
    if ( ! $topics ) {
        $none[] = $name;
        continue;
    }
    if ( ! $dry ) {
        wp_set_object_terms( $img->ID, array_keys( $topics ), 'media_topic' );
    }
    $done[] = "$name → " . implode( ', ', array_keys( $topics ) );
}

echo ( $dry ? "would label:\n  " : "labelled:\n  " ) . ( $done ? implode( "\n  ", $done ) : '—' ) . "\n";
echo 'already labelled, left alone: ' . count( $skipped ) . "\n";
echo 'used nowhere the rules know — label by hand: ' . ( $none ? implode( ', ', $none ) : '—' ) . "\n";
