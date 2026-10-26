<?php
/**
 * The team's notes on the kitchen menu (author, 26 Oct 2026):
 *   - onion rings come with the sour cream and herb sauce (the default), the Borodinsky
 *     croutons with Caesar sauce;
 *   - the quesadilla no longer has cherry tomatoes;
 *   - the wings come as 5 or 10 pieces — the two weights and prices are those portions;
 *   - the royal draniki's salmon is served with butter only, no cream cheese.
 * (The note «финляндии у нас нет» was the Гастробот's roast pairing — moved to the cranberry
 * infusion on 25 Oct, tools/field-updates/2026-10-25-gastrobot-draniki-roast.json.)
 *
 * A dish is found by type + Russian name + English name; where two records share both names
 * (Кесадилья — the lunch row carries its own text) the one holding the old description is
 * taken. A description someone has typed since is left alone and reported. Safe to run twice.
 *
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-updates/2026-10-26-team-notes.php [--dry-run]
 *   servers: WP_ROOT=~/SweetPepper-test/public_html php tools/menu-updates/2026-10-26-team-notes.php
 */

$dry     = in_array( '--dry-run', $argv, true );
$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

$tag = $dry ? '[dry run] ' : '';

// [ RU name, EN name, [ old RU, old EN ], [ new RU, new EN ] ]
$rows = [
    [ 'Луковые кольца', 'Onion rings',
      [ 'Во фритюре, с соусом на выбор', 'Deep fried with a sauce of your choice' ],
      [ 'Во фритюре, с соусом сметана-зелень', 'Deep fried with a sour cream and herb sauce' ] ],
    [ 'Бородинские гренки', 'Borodinsky croutons',
      [ 'Во фритюре, со свежим чесноком и сметаной', 'Deep fried with fresh garlic and sour cream' ],
      [ 'Во фритюре, со свежим чесноком и соусом «Цезарь»', 'Deep fried with fresh garlic and Caesar sauce' ] ],
    [ 'Кесадилья', 'Quesadilla',
      [ 'Тортилья с сыром гауда, томатами черри и соусом на выбор.', 'Tortilla with gouda, cherry tomatoes and a sauce of your choice.' ],
      [ 'Тортилья с сыром гауда и соусом на выбор.', 'Tortilla with gouda and a sauce of your choice.' ] ],
    [ 'Крылышки-гриль', 'Grilled wings',
      [ 'На одного 5 штук. В медовой глазури', 'For one, 5 pcs. In honey glaze' ],
      [ '5 или 10 штук. В медовой глазури', '5 or 10 pcs. In honey glaze' ] ],
    [ 'Королевские драники', 'Royal draniki',
      [ 'С лососем и сливочным маслом или сливочным сыром', 'With salmon and butter or cream cheese' ],
      [ 'С лососем и сливочным маслом', 'With salmon and butter' ] ],
];

foreach ( $rows as [ $ru, $en, $old, $new ] ) {
    $ids = [];
    foreach ( get_posts( [ 'post_type' => 'dish', 'post_status' => 'any', 'numberposts' => -1, 'title' => $ru ] ) as $p ) {
        if ( html_entity_decode( $p->post_title ) === $ru && (string) get_field( 'name_en', $p->ID ) === $en ) {
            $ids[] = $p->ID;
        }
    }
    if ( ! $ids ) {
        echo "{$tag}{$ru} / {$en}: not found — skipped\n";
        continue;
    }
    $now = function ( $id ) {
        return [ trim( (string) get_field( 'description_ru', $id ) ), trim( (string) get_field( 'description_en', $id ) ) ];
    };
    $done = array_filter( $ids, function ( $id ) use ( $now, $new ) { return $now( $id ) === $new; } );
    if ( $done ) {
        echo "{$tag}{$ru}: done\n";
        continue;
    }
    $open = array_values( array_filter( $ids, function ( $id ) use ( $now, $old ) { return $now( $id ) === $old; } ) );
    if ( 1 !== count( $open ) ) {
        echo "{$tag}{$ru} / {$en}: " . count( $open ) . ' records with the old description (of ' . count( $ids ) . ") — skipped, check by hand\n";
        continue;
    }
    $id = $open[0];
    if ( ! $dry ) {
        update_field( 'field_sp_dish_dish_description_ru', $new[0], $id );
        update_field( 'field_sp_dish_dish_description_en', $new[1], $id );
    }
    echo "{$tag}{$ru} ({$id}): «{$old[0]}» → «{$new[0]}»; “{$old[1]}” → “{$new[1]}”\n";
}
