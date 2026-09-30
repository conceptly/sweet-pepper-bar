<?php
/**
 * The missing descriptions (author, 30 Sep 2026) — on the site for the author to review with
 * the team, from `menu-missing-descriptions-ru-review.md` (the bold line of each row; the
 * kitchen's and the bar's autumn recipe sheets in `menu-source/` behind them). «+ растительное
 * молоко?» stays without one, as the file says. English is a translation of the Russian so the
 * English page doesn't fall back to it (the menu reads the other language when one is empty).
 * The sherries' English names were typed «Xepec» — Latin letters that look like «Херес» — and
 * become "Sherry Tio Toto Cream" / "Sherry Tio Toto Fino".
 *
 * A dish is found by type + Russian name + English name; where two records share both names
 * (Кесадилья, Кобб салат — the lunch rows carry their own text) the one whose description is
 * empty, or already the new one, is taken. A description someone has typed since is left alone.
 * Safe to run twice.
 *
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-updates/2026-09-30-missing-descriptions.php [--dry-run]
 *   servers: WP_ROOT=~/SweetPepper-test/public_html php tools/menu-updates/2026-09-30-missing-descriptions.php
 */

$dry     = in_array( '--dry-run', $argv, true );
$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

$tag = $dry ? '[dry run] ' : '';

// [ type, RU name, EN name, RU description, EN description ]
$rows = [
    // Kitchen
    [ 'dish', 'Фетучини alla Norma', 'Fettuccine alla Norma',
      'Паста с баклажанами, рикоттой, свежими и вялеными томатами и базиликом.',
      'Pasta with eggplant, ricotta, fresh and sun-dried tomatoes and basil.' ],
    [ 'dish', 'Осенний супчик дня', 'Autumn soup of the day',
      'Мексиканский — с индейкой, овощами и пшеничной тортильей. Сливочный — с охотничьими колбасками, сыром и песто.',
      'Mexican — with turkey, vegetables and a wheat tortilla. Creamy — with hunter’s sausages, cheese and pesto.' ],
    [ 'dish', 'Кесадилья', 'Quesadilla',
      'Тортилья с сыром гауда, томатами черри и соусом на выбор.',
      'Tortilla with gouda, cherry tomatoes and a sauce of your choice.' ],
    [ 'dish', 'Брокколи в сухарях', 'Breaded broccoli',
      'С пармезаном или песто из базилика и грецкого ореха.',
      'With parmesan or basil and walnut pesto.' ],
    [ 'dish', 'Кобб салат', 'Cobb Salad',
      'Айсберг, томаты и авокадо — с цыплёнком, беконом, гаудой и яйцом или с моцареллой, брокколи, огурцом и морковью.',
      'Iceberg, tomatoes and avocado — with chicken, bacon, gouda and egg, or with mozzarella, broccoli, cucumber and carrot.' ],
    [ 'dish', 'Сэндвич-сет', 'Sandwich set',
      'Сэндвич, картофель и соус на выбор — всё на одной тарелке.',
      'A sandwich, potatoes and a sauce of your choice — all on one plate.' ],
    [ 'dish', 'Фетучини Альфредо', 'Fettuccine Alfredo',
      'Паста с тигровыми креветками и цукини в сливочном соусе с креметте и пармезаном.',
      'Pasta with tiger shrimp and zucchini in a cream sauce with cremette and parmesan.' ],
    [ 'dish', 'Пельмешки', 'Pelmeni',
      'С начинкой из свинины и говядины.',
      'Filled with pork and beef.' ],
    // Bar
    [ 'drink', 'Барбариска', 'Barberry',
      'Яркая, насыщенная, с выразительной барбарисовой кислинкой.',
      'Bright and full, with a bold barberry tang.' ],
    [ 'drink', 'Херес Tio Toto Cream', 'Sherry Tio Toto Cream',
      'Сладкий херес с ореховыми и карамельными нотами.',
      'Sweet sherry with nutty, caramel notes.' ],
    [ 'drink', 'Крушовице', 'Krušovice',
      'Светлый лагер с мягкой солодовой нотой и лёгкой горчинкой.',
      'Pale lager with a soft malt note and a light bitterness.' ],
    [ 'drink', 'Woodford Reserve', 'Woodford Reserve',
      'Бурбон из Кентукки с нотами карамели, какао и пряностей.',
      'Kentucky bourbon with notes of caramel, cocoa and spice.' ],
    [ 'drink', 'Absolut', 'Absolut',
      'Шведская пшеничная водка.',
      'Swedish wheat vodka.' ],
    [ 'drink', 'Дынный с клубникой', 'Melon & Strawberry Milkshake',
      'Молочный шейк с мороженым и пюре из дыни и клубники.',
      'Milkshake with ice cream and melon and strawberry purée.' ],
    [ 'drink', 'Дынный раф с клубникой', 'Melon & Strawberry Raf',
      'Эспрессо со сливками и пюре из дыни и клубники.',
      'Espresso with cream and melon and strawberry purée.' ],
];

/** Every record of this type with this Russian title (drafts included — the team may have parked one). */
function sp_md_by_title( $type, $ru ) {
    $out = [];
    foreach ( get_posts( [ 'post_type' => $type, 'post_status' => 'any', 'numberposts' => -1, 'title' => $ru ] ) as $p ) {
        if ( html_entity_decode( $p->post_title ) === $ru ) {
            $out[] = $p->ID;
        }
    }
    return $out;
}

// The sherries' English names first (Cream and Fino both read «Xepec»), so the lookup below
// finds the Cream by the right one.
foreach ( get_posts( [ 'post_type' => 'drink', 'post_status' => 'any', 'numberposts' => -1 ] ) as $p ) {
    $en = (string) get_field( 'name_en', $p->ID );
    if ( 0 === strpos( $en, 'Xepec ' ) ) {
        $new = 'Sherry ' . substr( $en, 6 );
        $dry || update_field( 'field_sp_dish_dish_name_en', $new, $p->ID );
        echo "{$tag}" . html_entity_decode( $p->post_title ) . " ({$p->ID}): English name «{$en}» → «{$new}»\n";
    }
}

foreach ( $rows as [ $type, $ru, $en, $desc_ru, $desc_en ] ) {
    $ids = array_filter( sp_md_by_title( $type, $ru ), function ( $id ) use ( $en, $dry ) {
        $name = (string) get_field( 'name_en', $id );
        // In a dry run the sherry still holds its old name.
        return $name === $en || ( $dry && 'Sherry Tio Toto Cream' === $en && 'Xepec Tio Toto Cream' === $name );
    } );
    if ( ! $ids ) {
        echo "{$tag}{$ru} / {$en}: not found — skipped\n";
        continue;
    }
    $open = array_filter( $ids, function ( $id ) use ( $desc_ru ) {
        $now = trim( (string) get_field( 'description_ru', $id ) );
        return '' === $now || $desc_ru === $now;
    } );
    if ( 1 !== count( $open ) ) {
        $n = count( $open );
        echo "{$tag}{$ru} / {$en}: {$n} records without a description (of " . count( $ids ) . ") — skipped, check by hand\n";
        continue;
    }
    $id  = reset( $open );
    $out = [];
    foreach ( [ 'description_ru' => $desc_ru, 'description_en' => $desc_en ] as $f => $new ) {
        $now = trim( (string) get_field( $f, $id ) );
        if ( $new === $now ) {
            $out[] = "$f already set";
        } elseif ( '' === $now ) {
            $dry || update_field( "field_sp_dish_dish_{$f}", $new, $id );
            $out[] = "$f added";
        } else {
            $out[] = "$f is «{$now}» — left alone";
        }
    }
    echo "{$tag}{$ru} ({$id}): " . implode( '; ', $out ) . "\n";
}
