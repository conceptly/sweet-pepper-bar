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
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-seed.php soups [--dishes] [--force]
 *
 * --dishes seeds the other store of the Menu storage test instead: one `dish` post per
 * row and the section's `menu_list` record placing them (inc/menu-data-dishes.php).
 * The two stores are independent — seed both to compare them.
 *
 * A section that already has rows in admin is left alone unless --force is given:
 * after the first seed the database is the source, and the team's edits live there.
 * --force also re-issues every dish_id (with --dishes: deletes the section's dish posts
 * and creates new ones) — don't use it once highlights or the picker reference dishes.
 */

$args         = array_slice( $argv, 1 );
$force        = in_array( '--force', $args, true );
$dishes_store = in_array( '--dishes', $args, true );
$slugs        = array_values( array_diff( $args, [ '--force', '--dishes' ] ) );
if ( ! $slugs ) {
    exit( "Usage: menu-seed.php <section-slug> [<section-slug> …] [--dishes] [--force]\n" );
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

    $record_type = $dishes_store ? 'menu_list' : 'menu_section';
    $post        = get_page_by_path( $slug, OBJECT, $record_type );
    if ( $post && get_field( 'menu_subsections', $post->ID ) && ! $force ) {
        echo "$slug: already has rows in admin — skipped (--force overwrites them)\n";
        continue;
    }

    $post_id = $post ? $post->ID : wp_insert_post( [
        'post_type'   => $record_type,
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
        if ( $dishes_store ) {
            foreach ( (array) get_field( 'menu_subsections', $post_id ) as $old ) {
                foreach ( (array) ( $old['dishes'] ?? [] ) as $old_dish ) {
                    wp_delete_post( $old_dish, true );
                }
            }
        }
        // Start clean: rows written under an older field shape would otherwise linger as orphan meta.
        global $wpdb;
        $wpdb->query( $wpdb->prepare(
            "DELETE FROM $wpdb->postmeta WHERE post_id = %d AND ( meta_key LIKE %s OR meta_key LIKE %s )",
            $post_id, 'menu\\_subsections%', '\\_menu\\_subsections%'
        ) );
        wp_cache_delete( $post_id, 'post_meta' );
    }
    if ( $dishes_store ) {
        // Each row becomes a `dish` post: the RU name is its title, hidden is Draft, its ID is the id.
        foreach ( $rows as &$row ) {
            foreach ( $row['dishes'] as &$dish ) {
                $dish_id = wp_insert_post( [
                    'post_type'   => 'dish',
                    'post_status' => 'publish',
                    'post_title'  => $dish['name_ru'] ?: $dish['name_en'],
                ] );
                foreach ( array_diff_key( $dish, array_flip( [ 'name_ru', 'hidden', 'dish_id' ] ) ) as $name => $value ) {
                    update_field( "field_sp_dish_dish_{$name}", $value, $dish_id );
                }
                $dish = $dish_id;
            }
        }
        unset( $row, $dish );
        update_field( 'field_sp_list_subsections', $rows, $post_id );
    } else {
        update_field( 'field_sp_menu_subsections', $rows, $post_id );
        sweet_pepper_menu_fill_dish_ids( $post_id ); // update_field() does not fire acf/save_post
    }

    echo "$slug: post $post_id — " . count( $rows ) . " subsections, $n dishes\n";
}
