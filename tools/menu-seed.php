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
 * in a bar section — and the section's `menu_list` record («Разделы меню») places them
 * (inc/menu-data-dishes.php). `all` = every section that has a data file, in menu order.
 *
 * A section that already has rows in admin is left alone unless --force is given:
 * after the first seed the database is the source, and the team's edits live there.
 * --force deletes the section's posts and creates new ones (new IDs) — don't use it once
 * highlights or the picker reference dishes.
 *
 * --copy seeds the section's own words instead — the «Тексты раздела» fields (headline,
 * eyebrow, hero text, captions, deal; RU + EN) from data/menu/sections-copy.php and the
 * section list. Only empty fields are written: text edited in admin is never overwritten.
 */

$args  = array_slice( $argv, 1 );
$force = in_array( '--force', $args, true );
$copy  = in_array( '--copy', $args, true );
$slugs = array_values( array_diff( $args, [ '--force', '--copy' ] ) );
if ( ! $slugs ) {
    exit( "Usage: menu-seed.php <section-slug> [<section-slug> …] | all [--force | --copy]\n" );
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
// A record's title is what the team reads in admin («Разделы меню», the tables' «Раздел меню»
// column), so it is Russian — the section names of menu-copy-ru-draft.md. The page never prints it.
$titles_ru = [
    'breakfast' => 'Завтраки', 'lunch' => 'Обеды', 'bar-snacks' => 'Закуски', 'salads' => 'Салаты',
    'sandwiches' => 'Сэндвичи и бейглы', 'soups' => 'Супы', 'hot-dishes' => 'Горячее', 'desserts' => 'Десерты',
    'kids' => 'Детям', 'infusions' => 'Домашние настойки', 'cocktails' => 'Коктейли', 'wine' => 'Вино',
    'beer' => 'Пиво', 'spirits' => 'Крепкое', 'no-buzz' => 'Без алкоголя', 'tea-coffee' => 'Чай и кофе',
];

if ( $copy ) {
    foreach ( $slugs as $slug ) {
        $post = get_page_by_path( $slug, OBJECT, 'menu_list' );
        if ( ! $post ) {
            echo "$slug: no «Разделы меню» record — seed the dishes first\n";
            continue;
        }
        $written = 0;
        foreach ( sweet_pepper_menu_section_copy_typed( $slug ) as $lang => $words ) {
            foreach ( $words as $key => $value ) {
                if ( '' === trim( (string) $value ) || '' !== trim( (string) get_field( "sec_{$key}_{$lang}", $post->ID ) ) ) {
                    continue;
                }
                update_field( "field_sp_list_sec_{$key}_{$lang}", $value, $post->ID );
                $written++;
            }
        }
        echo "$slug: $written section fields written\n";
    }
    exit;
}

foreach ( $slugs as $slug ) {
    $source = sweet_pepper_menu_fallback( $slug );
    if ( ! $source ) {
        echo "$slug: no data/menu/$slug.php — skipped\n";
        continue;
    }

    $item_type = sweet_pepper_menu_item_type( $slug );
    $post      = get_page_by_path( $slug, OBJECT, 'menu_list' );
    // A record seeded before the titles were Russian (Soups, 20 Sep 2026) is renamed, nothing else.
    if ( $post && isset( $titles_ru[ $slug ] ) && $post->post_title === ( $sections[ $slug ]['label'] ?? '' ) ) {
        wp_update_post( [ 'ID' => $post->ID, 'post_title' => $titles_ru[ $slug ] ] );
    }
    if ( $post && get_field( 'menu_subsections', $post->ID ) && ! $force ) {
        echo "$slug: already has rows in admin — skipped (--force overwrites them)\n";
        continue;
    }

    $post_id = $post ? $post->ID : wp_insert_post( [
        'post_type'   => 'menu_list',
        'post_status' => 'publish',
        'post_name'   => $slug,
        'post_title'  => $titles_ru[ $slug ] ?? $sections[ $slug ]['label'] ?? ucfirst( $slug ),
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
            ];
            $n++;
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
        foreach ( (array) get_field( 'menu_subsections', $post_id ) as $old ) {
            foreach ( (array) ( $old['dishes'] ?? [] ) as $old_dish ) {
                wp_delete_post( $old_dish, true );
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
    update_field( 'field_sp_list_subsections', $rows, $post_id );

    echo "$slug: post $post_id — " . count( $rows ) . " subsections, $n {$item_type} posts\n";
}
