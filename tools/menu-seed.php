<?php
/**
 * Seed a menu section's record in WordPress from the typed rows in
 * sweet-pepper-theme/data/menu/<slug>.php (website-brief.md → Menu storage:
 * "Migration is a script that parses the arrays, not hand entry").
 *
 * Run with Local's PHP and database socket — there is no `wp` on PATH:
 *
 *   PHP=~/Library/Application\ Support/Local/lightning-services/php-8.2.30+1/bin/darwin-arm64/bin/php
 *   SOCK=~/Library/Application\ Support/Local/run/1tx2Lcx_A/mysql/mysqld.sock
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-seed.php soups [--force]
 *
 * A section that already has rows in admin is left alone unless --force is given:
 * after the first seed the database is the source, and the team's edits live there.
 * --force also re-issues every dish_id — don't use it once highlights or the picker reference dishes.
 */

$args  = array_slice( $argv, 1 );
$force = in_array( '--force', $args, true );
$slugs = array_values( array_diff( $args, [ '--force' ] ) );
if ( ! $slugs ) {
    exit( "Usage: menu-seed.php <section-slug> [<section-slug> …] [--force]\n" );
}

$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

/**
 * '150-. / 1300-.' + '40 ml / 500 ml' → two sizes of [ amount, unit, price ].
 * Tolerates the typed variants ('165 / 225-.', '455-./ 645-.') and a unit written
 * once for both sizes ('2 / 4 pcs').
 */
function sp_seed_sizes( $price, $quantity ) {
    preg_match_all( '/\d+/', (string) $price, $p );
    preg_match_all( '/(\d+(?:[.,]\d+)?)\s*(g|ml|l|pcs)?/i', (string) $quantity, $q, PREG_SET_ORDER );
    $last_unit = '';
    foreach ( array_reverse( $q, true ) as $i => $m ) {
        $last_unit       = strtolower( $m[2] ?? '' ) ?: $last_unit;
        $q[ $i ]['unit'] = $last_unit;
    }
    $sizes = [];
    foreach ( [ 0, 1 ] as $i ) {
        $sizes[] = [
            'amount' => isset( $q[ $i ] ) ? (float) str_replace( ',', '.', $q[ $i ][1] ) : '',
            'unit'   => $q[ $i ]['unit'] ?? 'g',
            'price'  => $p[0][ $i ] ?? '',
        ];
    }
    return $sizes;
}

$icon_order = [ 'veg', 'fire', 'Pepper', 'yaroslavl-logo' ]; // as in tools/menu-field-group.py

$sections = sweet_pepper_menu_sections( 'food' ) + sweet_pepper_menu_sections( 'drinks' );
$order    = array_flip( array_keys( $sections ) );

foreach ( $slugs as $slug ) {
    $source = sweet_pepper_menu_fallback( $slug );
    if ( ! $source ) {
        echo "$slug: no data/menu/$slug.php — skipped\n";
        continue;
    }

    $post = get_page_by_path( $slug, OBJECT, 'menu_section' );
    if ( $post && get_field( 'menu_subsections', $post->ID ) && ! $force ) {
        echo "$slug: already has rows in admin — skipped (--force overwrites them)\n";
        continue;
    }

    $post_id = $post ? $post->ID : wp_insert_post( [
        'post_type'   => 'menu_section',
        'post_status' => 'publish',
        'post_name'   => $slug,
        'post_title'  => $sections[ $slug ]['label'] ?? ucfirst( $slug ),
        'menu_order'  => $order[ $slug ] ?? 0,
    ], true );
    if ( is_wp_error( $post_id ) ) {
        echo "$slug: " . $post_id->get_error_message() . "\n";
        continue;
    }

    $rows = [];
    $n    = 0;
    foreach ( $source as $sub ) {
        $dishes = [];
        foreach ( $sub['dishes'] as $dish ) {
            [ $one, $two ] = sp_seed_sizes( $dish['price'] ?? '', $dish['quantity'] ?? '' );
            // Two different icons at most, in the page's fixed order.
            $icons    = array_slice( array_values( array_intersect( $icon_order, $dish['icons'] ?? [] ) ), 0, 2 );
            $dishes[] = [
                'name_ru'        => $dish['ru']['dish_name'] ?? '',
                'name_en'        => $dish['dish_name'] ?? '',
                'hidden'         => 0,
                'amount'         => $one['amount'],
                'unit'           => $one['unit'],
                'price'          => $one['price'],
                'amount_2'       => $two['amount'],
                'unit_2'         => $two['unit'],
                'price_2'        => $two['price'],
                'description_ru' => $dish['ru']['description'] ?? '',
                'description_en' => $dish['description'] ?? '',
                'icons'          => $icons,
                'highlight'      => empty( $dish['highlight'] ) ? 0 : 1,
                'seasonal_ru'    => $dish['ru']['seasonal_label'] ?? '',
                'seasonal_en'    => $dish['seasonal_label'] ?? '',
                'options_ru'     => implode( "\n", $dish['ru']['options'] ?? [] ),
                'options_en'     => implode( "\n", $dish['options'] ?? [] ),
                'dish_id'        => '',
            ];
            $n++;
        }
        $rows[] = [
            'title_ru' => $sub['title_ru'] ?? '',
            'title_en' => $sub['title'] ?? '',
            'column'   => $sub['column'] ?? 'left',
            'style'    => $sub['style'] ?? 'list',
            'dishes'   => $dishes,
        ];
    }

    if ( $force ) {
        // Start clean: rows written under an older field shape would otherwise linger as orphan meta.
        global $wpdb;
        $wpdb->query( $wpdb->prepare(
            "DELETE FROM $wpdb->postmeta WHERE post_id = %d AND ( meta_key LIKE %s OR meta_key LIKE %s )",
            $post_id, 'menu\\_subsections%', '\\_menu\\_subsections%'
        ) );
        wp_cache_delete( $post_id, 'post_meta' );
    }
    update_field( 'field_sp_menu_subsections', $rows, $post_id );
    sweet_pepper_menu_fill_dish_ids( $post_id ); // update_field() does not fire acf/save_post

    echo "$slug: post $post_id — " . count( $rows ) . " subsections, $n dishes\n";
}
