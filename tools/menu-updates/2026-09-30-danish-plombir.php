<?php
/**
 * Desserts, second pass (author, 30 Sep 2026).
 *
 * 1. «Детский десерт» was a typo in the name, not a wrong dish: it is «Датский десерт» /
 *    Danish dessert. Back in «выпечка» after «Арахисовый торт», where the fall pass put it,
 *    and published again (2026-09-30-toppings-salads.php had taken it off and set it to Draft).
 *    Portion, price and description unchanged.
 * 2. The ice cream's English name follows the Russian «Пломбир»: Ice cream → Plombir.
 *
 * Run after 2026-09-30-toppings-salads.php. Records are found by names, never by ID, so the
 * same file runs on the test and main sites. Safe to run twice.
 *
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-updates/2026-09-30-danish-plombir.php [--dry-run]
 *   servers: WP_ROOT=~/SweetPepper-test/public_html php tools/menu-updates/2026-09-30-danish-plombir.php
 */

$dry     = in_array( '--dry-run', $argv, true );
$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

$tag = $dry ? '[dry run] ' : '';

/** A section's subsection rows as saved: [ page ID, repeater name, rows[ field => value ] ]. */
function sp_dp_rows( $slug ) {
    $page = sweet_pepper_menu_page( sweet_pepper_menu_state_for( $slug ) );
    $n    = 'sec_' . str_replace( '-', '_', $slug ) . '_subsections';
    $rows = [];
    for ( $i = 0, $c = (int) get_post_meta( $page->ID, $n, true ); $i < $c; $i++ ) {
        $row = [];
        foreach ( [ 'title_ru', 'title_en', 'column', 'style', 'dishes', 'note_ru', 'note_en', 'divider' ] as $f ) {
            $row[ $f ] = get_post_meta( $page->ID, "{$n}_{$i}_{$f}", true );
        }
        $row['dishes'] = array_map( 'intval', (array) ( $row['dishes'] ?: [] ) );
        $rows[]        = $row;
    }
    return [ $page->ID, $n, $rows ];
}

/** Write the rows back, each field with its SCF reference, as the admin saves them. */
function sp_dp_put_rows( $page_id, $n, $slug, $rows ) {
    $key = 'field_sp_mfood_sec_' . str_replace( '-', '_', $slug ) . '_sub';
    update_post_meta( $page_id, $n, count( $rows ) );
    update_post_meta( $page_id, "_{$n}", "field_sp_mfood_sec_" . str_replace( '-', '_', $slug ) . '_subsections' );
    foreach ( $rows as $i => $row ) {
        foreach ( $row as $f => $v ) {
            if ( 'dishes' === $f ) {
                $v = array_map( 'strval', $v );
            }
            update_post_meta( $page_id, "{$n}_{$i}_{$f}", $v );
            update_post_meta( $page_id, "_{$n}_{$i}_{$f}", "{$key}_{$f}" );
        }
    }
}

/** A dish record, any status, with one of these RU names and one of these EN names. */
function sp_dp_find( $ru, $en ) {
    foreach ( get_posts( [ 'post_type' => 'dish', 'post_status' => 'any', 'numberposts' => -1, 'orderby' => 'ID', 'order' => 'ASC' ] ) as $p ) {
        if ( in_array( html_entity_decode( $p->post_title ), $ru, true ) && in_array( get_field( 'name_en', $p->ID ), $en, true ) ) {
            return $p->ID;
        }
    }
    return 0;
}

[ $page, $n, $rows ] = sp_dp_rows( 'desserts' );

// ---------------------------------------------------------------------------------------------
// 1. «Детский десерт» → «Датский десерт», back in «выпечка»
// ---------------------------------------------------------------------------------------------
$danish = sp_dp_find( [ 'Детский десерт', 'Датский десерт' ], [ "Kids' dessert", 'Danish dessert' ] );
if ( ! $danish ) {
    echo "  ? desserts: «Детский / Датский десерт» not found — skipped\n";
} else {
    if ( 'Датский десерт' === html_entity_decode( get_the_title( $danish ) ) && 'publish' === get_post_status( $danish ) ) {
        echo "{$tag}desserts: #{$danish} is already «Датский десерт», published\n";
    } else {
        $dry || wp_update_post( [ 'ID' => $danish, 'post_title' => 'Датский десерт', 'post_status' => 'publish' ] );
        echo "{$tag}desserts: #{$danish} → «Датский десерт», published\n";
    }
    if ( 'Danish dessert' === get_field( 'name_en', $danish ) ) {
        echo "{$tag}desserts: English name already Danish dessert\n";
    } else {
        $dry || update_field( 'field_sp_dish_dish_name_en', 'Danish dessert', $danish );
        echo "{$tag}desserts: English name → Danish dessert\n";
    }

    $listed = (bool) array_filter( $rows, fn( $r ) => in_array( $danish, $r['dishes'], true ) );
    if ( $listed ) {
        echo "{$tag}desserts: already on the list\n";
    } else {
        $peanut = sp_dp_find( [ 'Арахисовый торт' ], [ 'Peanut cake' ] );
        $placed = false;
        foreach ( $rows as &$row ) {
            if ( 'выпечка' !== $row['title_ru'] ) {
                continue;
            }
            $at = array_search( $peanut, $row['dishes'], true );
            array_splice( $row['dishes'], false === $at ? count( $row['dishes'] ) : $at + 1, 0, [ $danish ] );
            $placed = true;
            break;
        }
        unset( $row );
        if ( $placed ) {
            $dry || sp_dp_put_rows( $page, $n, 'desserts', $rows );
            echo "{$tag}desserts: «Датский десерт» back in «выпечка» after «Арахисовый торт»\n";
        } else {
            echo "  ? desserts: no «выпечка» subsection — «Датский десерт» not placed\n";
        }
    }
}

// ---------------------------------------------------------------------------------------------
// 2. Пломбир: Ice cream → Plombir
// ---------------------------------------------------------------------------------------------
$ice = sp_dp_find( [ 'Пломбир' ], [ 'Ice cream', 'Plombir' ] );
if ( ! $ice ) {
    echo "  ? desserts: «Пломбир» not found (run 2026-09-30-toppings-salads.php first) — skipped\n";
} elseif ( 'Plombir' === get_field( 'name_en', $ice ) ) {
    echo "{$tag}desserts: «Пломбир» already Plombir in English\n";
} else {
    $dry || update_field( 'field_sp_dish_dish_name_en', 'Plombir', $ice );
    echo "{$tag}desserts: «Пломбир» English name Ice cream → Plombir\n";
}
