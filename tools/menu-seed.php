<?php
/**
 * Seed menu sections in WordPress from the typed rows in
 * sweet-pepper-theme/data/menu/<slug>.php (website-brief.md → Menu storage:
 * "Migration is a script that parses the arrays, not hand entry").
 *
 * Run with Local's PHP and database socket — there is no `wp` on PATH:
 *
 *   PHP=~/Library/Application\ Support/Local/lightning-services/php-8.2.30+1/bin/darwin-arm64/bin/php
 *   SOCK=~/Library/Application\ Support/Local/run/1tx2Lcx_A/mysql/mysqld.sock
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-seed.php soups [--force]
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-seed.php all
 *
 * Each row becomes a post — a `dish` («Блюда») in a kitchen section, a `drink` («Напитки»)
 * in a bar section — and the section's tab on its menu page places them: the
 * `sec_<slug>_subsections` repeater (inc/menu-data-dishes.php; the pages themselves come from
 * tools/page-seed.php menu — run that first). `all` = every section that has a data file.
 *
 * A section that already has rows on the page is left alone unless --force is given:
 * after the first seed the database is the source, and the team's edits live there.
 * --force deletes the section's posts and creates new ones (new IDs) — don't use it once
 * the seasonal strip or the picker reference dishes.
 *
 * The section's words and photos are page-seed.php's job (menu), not this script's.
 */

$args  = array_slice( $argv, 1 );
$force = in_array( '--force', $args, true );
$slugs = array_values( array_diff( $args, [ '--force' ] ) );
if ( ! $slugs ) {
    exit( "Usage: menu-seed.php <section-slug> [<section-slug> …] | all [--force]\n" );
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

$sections = sweet_pepper_menu_sections_typed( 'food' ) + sweet_pepper_menu_sections_typed( 'drinks' );
$order    = array_flip( array_keys( $sections ) );
if ( [ 'all' ] === $slugs ) {
    $slugs = array_keys( $sections );
}
foreach ( $slugs as $slug ) {
    $source = sweet_pepper_menu_fallback( $slug );
    if ( ! $source ) {
        echo "$slug: no data/menu/$slug.php — skipped\n";
        continue;
    }

    $item_type = sweet_pepper_menu_item_type( $slug );
    $state     = sweet_pepper_menu_state_for( $slug );
    $page      = sweet_pepper_menu_page( $state );
    if ( ! $page ) {
        echo "$slug: no {$state} menu page — run tools/page-seed.php menu first\n";
        continue;
    }
    $post_id = $page->ID;
    $k       = 'food' === $state ? 'field_sp_mfood_' : 'field_sp_mbar_'; // tools/page-field-groups.py
    $n       = 'sec_' . str_replace( '-', '_', $slug ) . '_';
    if ( get_field( "{$n}subsections", $post_id ) && ! $force ) {
        echo "$slug: already has rows on the page — skipped (--force overwrites them)\n";
        continue;
    }

    $rows  = [];
    $count = 0;
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
            ];
            $count++;
        }
        $rows[] = [
            'title_ru' => $sub['title_ru'] ?? '',
            'title_en' => $sub['title'] ?? '',
            'column'   => $sub['column'] ?? 'left',
            'style'    => $sub['style'] ?? 'list',
            'dishes'   => $dishes,
            'note_ru'  => $sub['note_ru'] ?? '',
            'note_en'  => $sub['note'] ?? '',
            'divider'  => empty( $sub['divider'] ) ? 0 : 1,
        ];
    }

    if ( $force ) {
        foreach ( (array) get_field( "{$n}subsections", $post_id ) as $old ) {
            foreach ( (array) ( $old['dishes'] ?? [] ) as $old_dish ) {
                wp_delete_post( $old_dish, true );
            }
        }
        // Start clean: rows written under an older field shape would otherwise linger as orphan meta.
        global $wpdb;
        $like = str_replace( '_', '\\_', "{$n}subsections" );
        $wpdb->query( $wpdb->prepare(
            "DELETE FROM $wpdb->postmeta WHERE post_id = %d AND ( meta_key LIKE %s OR meta_key LIKE %s )",
            $post_id, "{$like}%", "\\_{$like}%"
        ) );
        wp_cache_delete( $post_id, 'post_meta' );
    }
    // Each row becomes a post: the RU name is its title, hidden is Draft, its ID is the id.
    foreach ( $rows as &$row ) {
        foreach ( $row['dishes'] as &$dish ) {
            $dish_id = wp_insert_post( [
                'post_type'   => $item_type,
                'post_status' => 'publish',
                'post_title'  => $dish['name_ru'] ?: $dish['name_en'],
            ] );
            foreach ( array_diff_key( $dish, array_flip( [ 'name_ru', 'hidden' ] ) ) as $name => $value ) {
                update_field( "field_sp_dish_dish_{$name}", $value, $dish_id );
            }
            $dish = $dish_id;
        }
    }
    unset( $row, $dish );
    $rows = array_map( fn( $row ) => [
        "{$k}{$n}sub_title_ru" => $row['title_ru'], "{$k}{$n}sub_title_en" => $row['title_en'],
        "{$k}{$n}sub_column"   => $row['column'],   "{$k}{$n}sub_style"    => $row['style'],
        "{$k}{$n}sub_dishes"   => $row['dishes'],
        "{$k}{$n}sub_note_ru"  => $row['note_ru'],  "{$k}{$n}sub_note_en"  => $row['note_en'],
        "{$k}{$n}sub_divider"  => $row['divider'],
    ], $rows );
    update_field( "{$k}{$n}subsections", $rows, $post_id );

    echo "$slug: page $post_id — " . count( $rows ) . " subsections, $count {$item_type} posts\n";
}
