<?php
/**
 * Breakfast toppings; salads regrouped with the kitchen's promise (author, 29–30 Sep 2026).
 *
 * 1. Breakfast: its add-ons card showed the sauces by mistake — it becomes «Топпинги» /
 *    Toppings, one row at 65-. The list is the author's old print menu until the team sends
 *    the current one (nearly the same): Nutella, varenye, jam of choice, condensed milk,
 *    honey, sour cream. Free on some dishes (pancakes), an add-on for an extra topping or
 *    one that isn't included (Nutella usually isn't). The sauces' 50 g is cleared — no
 *    portion yet.
 * 2. Salads: the two fall salads leave «фирменные салаты» for their own «осень’26» subsection
 *    under the Caesars (right column); their «Осень’26!» tags go — the heading says it.
 * 3. Salads: under «фирменные салаты», the add-ons card as the kitchen's rule — «так, как вы
 *    любите» / "the way you like it": one row, no price.
 * 4. Desserts (author, 30 Sep 2026): «Детский десерт» came in with the fall pass by mistake —
 *    off every list and set to Draft, not deleted; «Арахисовый торт» takes the fall badge
 *    (and the fall items' Olive name); «Мороженое» leaves «выпечка» for its own «мороженое» /
 *    ice cream subsection, right column, under the cheesecakes; the dish itself is renamed
 *    «Пломбир» (the English name stays Ice cream).
 *
 * Records are found by section + Russian name + English name, never by ID, so the same file
 * runs on the test and main sites. Safe to run twice: what is already done is reported so.
 *
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-updates/2026-09-30-toppings-salads.php [--dry-run]
 *   servers: WP_ROOT=~/SweetPepper-test/public_html php tools/menu-updates/2026-09-30-toppings-salads.php
 */

$dry     = in_array( '--dry-run', $argv, true );
$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

$tag = $dry ? '[dry run] ' : '';

/** A section's subsection rows as saved: [ page ID, repeater name, rows[ field => value ] ]. */
function sp_ts_rows( $slug ) {
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
function sp_ts_put_rows( $page_id, $n, $slug, $rows ) {
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

/** The dish with this RU + EN name in any of the section's lists. */
function sp_ts_find( $rows, $ru, $en ) {
    foreach ( $rows as $row ) {
        foreach ( $row['dishes'] as $id ) {
            if ( html_entity_decode( get_the_title( $id ) ) === $ru && get_field( 'name_en', $id ) === $en ) {
                return $id;
            }
        }
    }
    return 0;
}

/** Set dish fields from old to new; report what was done. */
function sp_ts_fields( $id, $set, $dry ) {
    $out = [];
    foreach ( $set as $f => [ $old, $new ] ) {
        $now = (string) get_field( $f, $id );
        if ( (string) $new === $now ) {
            $out[] = "$f already set";
        } elseif ( (string) $old === $now ) {
            $dry || update_field( "field_sp_dish_dish_{$f}", $new, $id );
            $out[] = "$f updated";
        } else {
            $out[] = "$f is «{$now}», expected «{$old}» — left alone";
        }
    }
    return implode( '; ', $out );
}

// ---------------------------------------------------------------------------------------------
// 1. Breakfast — sauces → toppings
// ---------------------------------------------------------------------------------------------
[ $page, $n, $rows ] = sp_ts_rows( 'breakfast' );
$changed = false;
foreach ( $rows as &$row ) {
    if ( 'card' !== $row['style'] ) {
        continue;
    }
    if ( 'Топпинги' === $row['title_ru'] ) {
        echo "{$tag}breakfast: the card is already «Топпинги»\n";
    } elseif ( 'Любимые соусы' === $row['title_ru'] ) {
        $row['title_ru'] = 'Топпинги';
        $row['title_en'] = 'Toppings';
        $changed         = true;
        echo "{$tag}breakfast: card «Любимые соусы» → «Топпинги» / Toppings\n";
    }
}
unset( $row );
if ( $changed && ! $dry ) {
    sp_ts_put_rows( $page, $n, 'breakfast', $rows );
}
$topping = sp_ts_find( $rows, 'Любой на выбор', 'Add any' );
if ( $topping ) {
    echo "{$tag}breakfast: «Любой на выбор» — " . sp_ts_fields( $topping, [
        'description_ru' => [ 'Сырный, Цезарь, Барбекю, Тартар, Сметана, Сицилийский, Горчица', 'Нутелла, варенье, джем на выбор, сгущёнка, мёд, сметана' ],
        'description_en' => [ 'Cheese, Caesar, BBQ, Tartar, Sour cream, Sicilian, Mustard', 'Nutella, varenye, jam of your choice, condensed milk, honey, sour cream' ],
        'amount'         => [ '50', '' ],
    ], $dry ) . "\n";
} else {
    echo "  ? breakfast: «Любой на выбор» / Add any not found — skipped\n";
}

// ---------------------------------------------------------------------------------------------
// 2–3. Salads — «осень’26» under the Caesars; the kitchen's promise under the signature salads
// ---------------------------------------------------------------------------------------------
[ $page, $n, $rows ] = sp_ts_rows( 'salads' );
$fall = array_filter( [
    sp_ts_find( $rows, 'Осенний салат с бататом', 'Autumn sweet potato salad' ),
    sp_ts_find( $rows, 'Капоната с фетой', 'Caponata with feta' ),
] );
$has = fn( $title ) => (bool) array_filter( $rows, fn( $r ) => $title === $r['title_ru'] );
$changed = false;

if ( $has( 'осень’26' ) ) {
    echo "{$tag}salads: «осень’26» already there\n";
} elseif ( count( $fall ) === 2 ) {
    foreach ( $rows as &$row ) {
        $row['dishes'] = array_values( array_diff( $row['dishes'], $fall ) );
    }
    unset( $row );
    $rows[]  = [ 'title_ru' => 'осень’26', 'title_en' => 'autumn’26', 'column' => 'right', 'style' => 'list', 'dishes' => array_values( $fall ), 'note_ru' => '', 'note_en' => '', 'divider' => '0' ];
    $changed = true;
    echo "{$tag}salads: the two fall salads → their own «осень’26» / autumn’26 under the Caesars\n";
} else {
    echo "  ? salads: the fall salads not found — «осень’26» skipped\n";
}
foreach ( $fall as $id ) {
    echo "{$tag}salads: «" . get_the_title( $id ) . '» — ' . sp_ts_fields( $id, [
        'seasonal_ru' => [ 'Осень’26!', '' ],
        'seasonal_en' => [ "Autumn'26!", '' ],
    ], $dry ) . "\n";
}

if ( $has( 'так, как вы любите' ) ) {
    echo "{$tag}salads: «так, как вы любите» already there\n";
    // The first wording (29 Sep, local only) → the author's (30 Sep): «приготовим на ваш вкус».
    $promise = sp_ts_find( $rows, 'Острее или мягче, без лука, другая заправка', 'Spicier or milder, hold the onion, another dressing' );
    if ( $promise ) {
        echo "{$tag}salads: the promise's line — " . sp_ts_fields( $promise, [
            'description_ru' => [ 'Скажите официанту — кухня соберёт салат по-вашему.', 'Скажите официанту — приготовим на ваш вкус.' ],
            'description_en' => [ 'Tell your server, and the kitchen will make it your way.', 'Tell your server, and we’ll make it to your taste.' ],
        ], $dry ) . "\n";
    }
} else {
    $promise = 0;
    if ( ! $dry ) {
        $promise = wp_insert_post( [ 'post_type' => 'dish', 'post_status' => 'publish', 'post_title' => 'Острее или мягче, без лука, другая заправка' ] );
        foreach ( [
            'name_en'        => 'Spicier or milder, hold the onion, another dressing',
            'description_ru' => 'Скажите официанту — приготовим на ваш вкус.',
            'description_en' => 'Tell your server, and we’ll make it to your taste.',
            'amount'         => '', 'unit' => 'g', 'price' => '',
            'amount_2'       => '', 'unit_2' => 'g', 'price_2' => '',
            'icons'          => [], 'highlight' => 0, 'seasonal_ru' => '', 'seasonal_en' => '',
            'options_ru'     => '', 'options_en' => '',
        ] as $f => $v ) {
            update_field( "field_sp_dish_dish_{$f}", $v, $promise ); // tools/menu-seed.php
        }
    }
    // Left column, after the signature salads: before any later left row.
    $at = count( $rows );
    foreach ( $rows as $i => $row ) {
        if ( 'фирменные салаты' === $row['title_ru'] ) {
            $at = $i + 1;
        }
    }
    array_splice( $rows, $at, 0, [ [ 'title_ru' => 'так, как вы любите', 'title_en' => 'the way you like it', 'column' => 'left', 'style' => 'card', 'dishes' => $promise ? [ $promise ] : [], 'note_ru' => '', 'note_en' => '', 'divider' => '0' ] ] );
    $changed = true;
    echo "{$tag}salads: the add-ons card «так, как вы любите» / the way you like it under the signature salads" . ( $promise ? " (dish #{$promise})" : '' ) . "\n";
}
if ( $changed && ! $dry ) {
    sp_ts_put_rows( $page, $n, 'salads', $rows );
}

// ---------------------------------------------------------------------------------------------
// 4. Desserts — kids' dessert off, the peanut cake's fall badge, ice cream on its own
// ---------------------------------------------------------------------------------------------
[ $page, $n, $rows ] = sp_ts_rows( 'desserts' );
$changed = false;

$kids = sp_ts_find( $rows, 'Детский десерт', "Kids' dessert" );
if ( $kids ) {
    // Off every list of its menu page, then Draft (tools/menu-updates/2026-09-25-fall.php's rule).
    foreach ( sweet_pepper_menu_sections_typed( 'food' ) as $slug => $unused ) {
        [ $p, $sn, $srows ] = sp_ts_rows( $slug );
        $hit = false;
        foreach ( $srows as &$row ) {
            if ( in_array( $kids, $row['dishes'], true ) ) {
                $row['dishes'] = array_values( array_diff( $row['dishes'], [ $kids ] ) );
                $hit           = true;
            }
        }
        unset( $row );
        if ( $hit && ! $dry ) {
            sp_ts_put_rows( $p, $sn, $slug, $srows );
        }
    }
    $dry || wp_update_post( [ 'ID' => $kids, 'post_status' => 'draft' ] );
    echo "{$tag}desserts: «Детский десерт» off the lists, set to Draft\n";
    [ $page, $n, $rows ] = sp_ts_rows( 'desserts' );
} else {
    echo "{$tag}desserts: «Детский десерт» already off\n";
}

$peanut = sp_ts_find( $rows, 'Арахисовый торт', 'Peanut cake' );
if ( $peanut ) {
    echo "{$tag}desserts: «Арахисовый торт» — " . sp_ts_fields( $peanut, [
        'seasonal_ru' => [ '', 'Осень’26!' ],
        'seasonal_en' => [ '', "Autumn'26!" ],
        'highlight'   => [ '', '1' ],
    ], $dry ) . "\n";
} else {
    echo "  ? desserts: «Арахисовый торт» / Peanut cake not found — skipped\n";
}

$ice = sp_ts_find( $rows, 'Мороженое', 'Ice cream' ) ?: sp_ts_find( $rows, 'Пломбир', 'Ice cream' );
if ( $has = (bool) array_filter( $rows, fn( $r ) => 'мороженое' === $r['title_ru'] ) ) {
    echo "{$tag}desserts: «мороженое» already its own subsection\n";
} elseif ( $ice ) {
    foreach ( $rows as &$row ) {
        $row['dishes'] = array_values( array_diff( $row['dishes'], [ $ice ] ) );
    }
    unset( $row );
    $rows[]  = [ 'title_ru' => 'мороженое', 'title_en' => 'ice cream', 'column' => 'right', 'style' => 'list', 'dishes' => [ $ice ], 'note_ru' => '', 'note_en' => '', 'divider' => '0' ];
    $changed = true;
    echo "{$tag}desserts: «Мороженое» → its own «мороженое» / ice cream, right column, under the cheesecakes\n";
} else {
    echo "  ? desserts: «Мороженое» / Ice cream not found — skipped\n";
}
if ( $changed && ! $dry ) {
    sp_ts_put_rows( $page, $n, 'desserts', $rows );
}
if ( $ice && 'Пломбир' === html_entity_decode( get_the_title( $ice ) ) ) {
    echo "{$tag}desserts: the dish is already «Пломбир»\n";
} elseif ( $ice ) {
    $dry || wp_update_post( [ 'ID' => $ice, 'post_title' => 'Пломбир' ] );
    echo "{$tag}desserts: «Мороженое» (the dish) → «Пломбир»\n";
}
