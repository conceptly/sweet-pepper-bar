<?php
/**
 * Import the community's VK posts into «Посты ВКонтакте» — the Russian home page's
 * «Что нового» cards — by hand, outside the hourly schedule (inc/vk-feed.php).
 *
 * Run with Local's PHP and database socket — there is no `wp` on PATH:
 *
 *   PHP=~/Library/Application\ Support/Local/lightning-services/php-8.2.30+1/bin/darwin-arm64/bin/php
 *   SOCK=~/Library/Application\ Support/Local/run/1tx2Lcx_A/mysql/mysqld.sock
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/vk-import.php [--dry-run] [--from <wall.get.json>]
 *
 *   (no option)   — one run: fetch, save, retire; then the five cards the Russian page shows.
 *   --dry-run     — fetch and list what a run would do (created / updated / unchanged, the
 *                   caption each post would get) without writing anything.
 *   --from FILE   — a saved wall.get response (the whole JSON, or just its `items`) instead of
 *                   a live request: repeat runs, an edited caption, a post that left the wall,
 *                   all without touching VK. With --dry-run, listed only.
 *
 * The key: SWEET_PEPPER_VK_SERVICE_KEY in wp-config.php, or in the environment for this run
 * (`SWEET_PEPPER_VK_SERVICE_KEY=… "$PHP" … tools/vk-import.php`). Never on the command line
 * of a shared server, never in a file in the repository.
 *
 * On hosting (the theme is a copy there): `WP_ROOT=~/SweetPepper-test/public_html php tools/vk-import.php`.
 */

$args    = array_slice( $argv, 1 );
$dry_run = in_array( '--dry-run', $args, true );
$from    = ( $i = array_search( '--from', $args, true ) ) !== false ? ( $args[ $i + 1 ] ?? '' ) : '';

$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

// The active theme may be another copy of the repository (a worktree build): this checkout's feed code.
if ( ! function_exists( 'sweet_pepper_vk_import' ) ) {
    require __DIR__ . '/../sweet-pepper-theme/inc/vk-feed.php';
}

$items = null;
if ( '' !== $from ) {
    $json = json_decode( (string) file_get_contents( $from ), true );
    $items = $json['response']['items'] ?? $json['items'] ?? $json;
    if ( ! is_array( $items ) ) {
        exit( "{$from}: not a wall.get response\n" );
    }
    echo count( $items ) . " posts from {$from}\n";
} elseif ( '' === sweet_pepper_vk_key() ) {
    exit( "No key: define SWEET_PEPPER_VK_SERVICE_KEY in wp-config.php or the environment.\n" );
}

if ( $dry_run ) {
    $items = $items ?? sweet_pepper_vk_fetch();
    if ( is_wp_error( $items ) ) {
        exit( 'fetch failed: ' . $items->get_error_message() . "\n" );
    }
    $eligible = array_slice( array_values( array_filter( $items, 'sweet_pepper_vk_eligible' ) ), 0, SWEET_PEPPER_VK_KEEP );
    printf( "%d posts fetched, %d eligible (stored: the first %d)\n\n", count( $items ), count( $eligible ), SWEET_PEPPER_VK_KEEP );
    foreach ( $items as $item ) {
        $key   = sweet_pepper_vk_post_key( $item );
        $photo = sweet_pepper_vk_photo( $item );
        $title = sweet_pepper_vk_title( $item['text'] ?? '' );
        $why   = ! sweet_pepper_vk_eligible( $item )
            ? ( ! empty( $item['copy_history'] ) ? 'repost' : ( ! empty( $item['marked_as_ads'] ) ? 'ad' : ( ! $photo ? 'no photo' : ( '' === $title ? 'no words' : 'post_type ' . $item['post_type'] ) ) ) )
            : ( in_array( $item, $eligible, true ) ? ( ( $r = sweet_pepper_vk_record( $key ) ) ? "record #{$r->ID}" : 'new' ) : 'beyond the kept ' . SWEET_PEPPER_VK_KEEP );
        printf( "%-16s %s  %-22s %s%s\n  %s\n", $key, wp_date( 'd.m.Y', (int) $item['date'] ), $why, empty( $item['is_pinned'] ) ? '' : '[pinned] ', $photo ? "{$photo['width']}×{$photo['height']}" : '—', $title ?: '(no caption)' );
    }
    exit;
}

$summary = sweet_pepper_vk_import( $items );
if ( is_wp_error( $summary ) ) {
    exit( 'run failed: ' . $summary->get_error_message() . "\n" );
}
printf( "fetched %d, eligible %d — created %d, updated %d, unchanged %d, missing %d, unpublished %d\n",
    $summary['fetched'], $summary['eligible'], $summary['created'], $summary['updated'], $summary['unchanged'], $summary['missing'], $summary['unpublished'] );
foreach ( $summary['errors'] as $error ) {
    echo "  ! {$error}\n";
}
echo "\nThe Russian page's cards:\n";
foreach ( sweet_pepper_vk_cards( 5 ) as $n => $card ) {
    printf( "%d. %s%s — %s\n   %s\n   %s\n", $n + 1, $card['pinned'] ? '[pinned] ' : '', $card['title'], $card['date'], $card['url'], $card['image_url'] );
}
