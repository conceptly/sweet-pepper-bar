<?php
/**
 * The fall badge on every fall item (author, 30 Sep 2026: "yesterday some of them were missed").
 *
 * The fall menu is the «Сезонка Осень 2026» sheet of the kitchen's and the bar's recipe files
 * (menu-source/Raskladki_kukhni_Osen.xlsx, Raskladka_bara_Osen_2026.xlsx — the bar's other
 * «Сезонка Осень» sheet is an older autumn). Checked against the site: every item there had
 * «Осень’26!» / "Autumn'26!" and the Olive name except these five records, which get both.
 *   Kitchen: Дакк салат (lunch and salads), Фетучини Альфредо, Фетучини alla Norma.
 *   Bar:     Эжени.
 * Left as they are: the two salads under the «осень’26» heading (Осенний салат с бататом,
 * Капоната с фетой) — their tags went on 30 Sep 2026 because the heading says it
 * (2026-09-30-toppings-salads.php).
 *
 * Also «Барбара Коллинз»'s description, to the fall sheet's recipe (A10: house vodka, fresh, syrup,
 * lemon-lime soda); the bar confirmed the syrup is barberry and the fresh is lemon (30 Sep 2026).
 * The barberry-lemongrass cordial it named belongs to the seasonal lemonade.
 *
 * Records are found by type + Russian name + English name, published only, never by ID, so the
 * same file runs on the test and main sites. A badge someone typed differently is left alone.
 * Safe to run twice.
 *
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-updates/2026-09-30-fall-badges.php [--dry-run]
 *   servers: WP_ROOT=~/SweetPepper-test/public_html php tools/menu-updates/2026-09-30-fall-badges.php
 */

$dry     = in_array( '--dry-run', $argv, true );
$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

$tag = $dry ? '[dry run] ' : '';

$items = [
    [ 'dish', 'Дакк салат', 'Dakk Salad' ],              // both records: lunch and salads
    [ 'dish', 'Фетучини Альфредо', 'Fettuccine Alfredo' ],
    [ 'dish', 'Фетучини alla Norma', 'Fettuccine alla Norma' ],
    [ 'drink', 'Эжени', 'Eugénie' ],
];
$set = [ 'seasonal_ru' => 'Осень’26!', 'seasonal_en' => "Autumn'26!", 'highlight' => 1 ];

foreach ( $items as [ $type, $ru, $en ] ) {
    $ids = [];
    foreach ( get_posts( [ 'post_type' => $type, 'post_status' => 'publish', 'numberposts' => -1, 'title' => $ru ] ) as $p ) {
        if ( html_entity_decode( $p->post_title ) === $ru && (string) get_field( 'name_en', $p->ID ) === $en ) {
            $ids[] = $p->ID;
        }
    }
    if ( ! $ids ) {
        echo "{$tag}{$ru} / {$en}: not found — skipped\n";
        continue;
    }
    foreach ( $ids as $id ) {
        $out = [];
        foreach ( $set as $f => $new ) {
            $now = get_field( $f, $id );
            if ( 'highlight' === $f ? (bool) $now : (string) $new === trim( (string) $now ) ) {
                $out[] = "$f already set";
            } elseif ( 'highlight' === $f || '' === trim( (string) $now ) ) {
                $dry || update_field( "field_sp_dish_dish_{$f}", $new, $id );
                $out[] = "$f set";
            } else {
                $out[] = "$f is «{$now}» — left alone";
            }
        }
        echo "{$tag}{$ru} ({$id}): " . implode( '; ', $out ) . "\n";
    }
}

// «Барбара Коллинз» — the description, only while it still reads as before.
$barbara = [
    'description_ru' => [ 'Водка, кордиал барбарис-лемонграсс, содовая.', 'Водка, барбарисовый сироп, лимонный фреш, лимонад лимон-лайм.' ],
    'description_en' => [ 'Vodka, barberry-lemongrass cordial, soda.', 'Vodka, barberry syrup, fresh lemon, lemon-lime soda.' ],
];
foreach ( get_posts( [ 'post_type' => 'drink', 'post_status' => 'publish', 'numberposts' => -1, 'title' => 'Барбара Коллинз' ] ) as $p ) {
    if ( 'Barbara Collins' !== (string) get_field( 'name_en', $p->ID ) ) {
        continue;
    }
    $out = [];
    foreach ( $barbara as $f => [ $old, $new ] ) {
        $now = trim( (string) get_field( $f, $p->ID ) );
        if ( $new === $now ) {
            $out[] = "$f already set";
        } elseif ( $old === $now ) {
            $dry || update_field( "field_sp_dish_dish_{$f}", $new, $p->ID );
            $out[] = "$f updated";
        } else {
            $out[] = "$f is «{$now}» — left alone";
        }
    }
    echo "{$tag}Барбара Коллинз ({$p->ID}): " . implode( '; ', $out ) . "\n";
}
