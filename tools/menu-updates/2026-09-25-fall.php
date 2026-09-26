<?php
/**
 * Fall 2026 menu — the summer records in the database brought up to the team's fall menu
 * (menu-source/menu_fall-2026.md; the diff against the site is in report.md → 25 Sep 2026).
 *
 * The author's rules for this pass (25 Sep 2026):
 * - Continuing dishes and drinks keep their descriptions — only prices and portions change.
 *   Recipe differences in the team's file (New York Sour, Mai Tai, Coco Mademoiselle, borscht)
 *   are reported, not written.
 * - New items take their ingredients from the team's file; nothing is invented (Alfredo and
 *   alla Norma have none yet, so they have no description).
 * - Photos: none attached. The seasonal strip keeps its placeholders (the section's band photo)
 *   until the new photos come.
 * - Retired items are taken off every list and set to Draft, never deleted.
 * - Items the site already left out in summer (fries, baked cod, syrniki…) stay out.
 *
 * Records are found by section + Russian name + English name, never by ID, so the same file
 * runs on the test site. Safe to run twice: whatever is already done is reported as such.
 *
 *   PHP=~/Library/Application\ Support/Local/lightning-services/php-8.2.30+1/bin/darwin-arm64/bin/php
 *   SOCK=~/Library/Application\ Support/Local/run/1tx2Lcx_A/mysql/mysqld.sock
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-updates/2026-09-25-fall.php [--dry-run]
 *   test site: WP_ROOT=~/SweetPepper-test/public_html php tools/menu-updates/2026-09-25-fall.php
 */

$dry     = in_array( '--dry-run', $argv, true );
$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

const SP_SUMMER = [ 'Лето’26!', "Summer'26!" ];
const SP_AUTUMN = [ 'Осень’26!', "Autumn'26!" ];

// ---------------------------------------------------------------------------------------------
// The changes
// ---------------------------------------------------------------------------------------------

// [ section, RU name, EN name ] => [ field => [ old, new ] ]
$updates = [
    [ 'breakfast', 'Утренний ролл с индейкой', 'Turkey roll', [ 'price' => [ 325, 345 ] ] ],
    [ 'breakfast', 'Утренний ролл с креветками', 'Shrimp roll', [ 'price' => [ 325, 425 ] ] ],
    [ 'lunch', 'Классический Цезарь', 'Classic Caesar', [ 'price' => [ 265, 285 ] ] ],
    [ 'lunch', 'Фирменная брокколи', 'Signature Broccoli', [ 'price' => [ 190, 215 ] ] ],
    [ 'lunch', 'Фарфалле с курицей и брокколи', 'Farfalle with chicken', [ 'price' => [ 245, 285 ] ] ],
    [ 'lunch', 'Тыквенный суп', 'Pumpkin soup', [ 'price' => [ 195, 205 ] ] ],
    [ 'desserts', 'Чизкейк Сан-Себастьян', 'San Sebastian', [ 'amount' => [ 240, 150 ] ] ],
    [ 'desserts', 'Карамельный чизкейк', 'Caramel cheesecake', [ 'amount' => [ 200, 130 ] ] ],
    [ 'spirits', 'Whitley Artisanal Gold', 'Whitley Artisanal Gold', [ 'price' => [ 155, 165 ] ] ],
    [ 'no-buzz', 'Завтрак Робинзона', "Robinson's Breakfast", [ 'price' => [ 335, 325 ] ] ],
    // Stay on the fall menu, no longer summer specials.
    [ 'hot-dishes', 'Жаркое с треской', 'Cod roast', [ 'seasonal_ru' => [ SP_SUMMER[0], '' ], 'seasonal_en' => [ SP_SUMMER[1], '' ] ] ],
    [ 'infusions', 'Ледяная лимонная', 'Icy Lemon', [ 'seasonal_ru' => [ SP_SUMMER[0], '' ], 'seasonal_en' => [ SP_SUMMER[1], '' ] ] ],
];

// Retired: off every list, set to Draft. A 'with' item takes the retired one's place in its list.
$retire = [
    [ 'lunch', 'Летний салат с брынзой', 'Summer salad', 'with' => 'dakk-lunch' ],
    [ 'lunch', 'Летний супчик дня', 'Summer soup of the day', 'with' => 'soup-lunch' ],
    [ 'salads', 'Летний салат с брынзой', 'Summer salad with brynza', 'with' => 'dakk' ],
    [ 'hot-dishes', 'Фетучини Корфу', 'Fettuccine Corfu', 'with' => 'alfredo' ],
    [ 'hot-dishes', 'Равиоли', 'Ravioli' ],
    [ 'desserts', 'Черничный чизкейк', 'Blueberry cheesecake' ],
    [ 'infusions', 'Клубничка', 'Strawberry', 'with' => 'barberry' ],
    [ 'cocktails', 'Палома', 'Paloma', 'with' => 'eugenie' ],
    [ 'cocktails', 'Лилиан', 'Lilian', 'with' => 'coquette' ],
    [ 'cocktails', 'Эммануэль', 'Emmanuelle', 'with' => 'red-moscow' ],
    [ 'cocktails', 'Гемини', 'Gemini', 'with' => 'barbara' ],
    [ 'wine', 'Lakky Шираз', 'Lakky Shiraz', 'with' => 'camden' ],
    [ 'spirits', 'Белуга Нобл', 'Beluga Noble', 'with' => 'absolut' ],
    [ 'spirits', 'Bankhall Sweet Mash', 'Bankhall Sweet Mash' ],
    [ 'no-buzz', 'Сырный', 'Cheese Milkshake', 'with' => 'melon-shake' ],
    [ 'no-buzz', 'Сезонный лимонад', 'Seasonal Lemonade', 'with' => 'lemonade', 'seasonal_ru' => SP_SUMMER[0] ],
    [ 'tea-coffee', 'Сырный раф', 'Cheese Raf', 'with' => 'melon-raf' ],
];

// New items. 'after' = [ RU, EN ] of the item it follows in its list (the retired item's
// place is given by $retire instead). Sizes: [ amount, unit, price ], optional second.
$items = [
    // Kitchen
    'dakk'        => [ 'salads', 'Дакк салат', 'Dakk Salad', [ 250, 'g', 325 ], 'desc' => [ 'С сыром рикотта, запечённым бататом, грушей, грецким орехом и рукколой в соусе из мёда и бальзамика', 'with ricotta, roasted sweet potato, pear, walnut & arugula in a honey-balsamic dressing' ] ],
    'sweet-potato'=> [ 'salads', 'Осенний салат с бататом', 'Autumn sweet potato salad', [ '', 'g', 295 ], 'after' => [ 'Дакк салат', 'Dakk Salad' ], 'season' => 1, 'desc' => [ 'С брынзой, рукколой, салатом айсберг и черри', 'with brynza, arugula, iceberg lettuce & cherry tomatoes' ] ],
    'caponata'    => [ 'salads', 'Капоната с фетой', 'Caponata with feta', [ '', 'g', 295 ], 'after' => [ 'Осенний салат с бататом', 'Autumn sweet potato salad' ], 'season' => 1, 'desc' => [ 'Запечённые баклажаны, болгарский перец, цукини и руккола в томатном соусе из бальзамика и горчицы', 'roasted aubergine, bell pepper, zucchini & arugula in a tomato sauce with balsamic & mustard' ] ],
    'dakk-lunch'  => [ 'lunch', 'Дакк салат', 'Dakk Salad', [ '', 'g', 285 ], 'desc' => [ 'С сыром рикотта, запечённым бататом, грушей, грецким орехом и рукколой в соусе из мёда и бальзамика', 'with ricotta, roasted sweet potato, pear, walnut & arugula in a honey-balsamic dressing' ] ],
    'norma'       => [ 'lunch', 'Фетучини alla Norma', 'Fettuccine alla Norma', [ '', 'g', 285 ], 'after' => [ 'Фарфалле с курицей и брокколи', 'Farfalle with chicken' ] ],
    'soup-lunch'  => [ 'lunch', 'Осенний супчик дня', 'Autumn soup of the day', [ '', 'g', 235 ], 'season' => 1, 'options' => [ "Мексиканский с индейкой\nСливочный с колбасками", "Mexican-style with turkey\nCreamy sausage soup" ] ],
    'alfredo'     => [ 'hot-dishes', 'Фетучини Альфредо', 'Fettuccine Alfredo', [ 250, 'g', 465 ] ],
    'peanut-cake' => [ 'desserts', 'Арахисовый торт', 'Peanut cake', [ 125, 'g', 325 ], 'after' => [ 'Малиновый наполеон', 'Raspberry Napoleon' ], 'desc' => [ 'С какао и сметанным кремом', 'with cocoa & sour-cream frosting' ] ],
    'kids-dessert'=> [ 'desserts', 'Детский десерт', "Kids' dessert", [ 110, 'g', 175 ], 'after' => [ 'Арахисовый торт', 'Peanut cake' ], 'desc' => [ 'С сезонными ягодами и кремом', 'with seasonal berries & cream' ] ],
    // Bar
    'barberry'    => [ 'infusions', 'Барбариска', 'Barberry', [ 40, 'ml', 150 ], [ 500, 'ml', 1300 ], 'season' => 1 ],
    'eugenie'     => [ 'cocktails', 'Эжени', 'Eugénie', [ 120, 'ml', 445 ], 'desc' => [ 'Коньяк Roulette, кордиал ежевика-лаванда, лимонный фреш, сахар, виски Laphroaig.', 'Roulette cognac, blackberry-lavender cordial, fresh lemon, sugar, Laphroaig whisky.' ] ],
    'coquette'    => [ 'cocktails', 'Кокетка', 'Coquette', [ 250, 'ml', 355 ], 'season' => 1, 'desc' => [ 'Джин Whitley Neill, вишня, лимонный фреш, сахарный сироп, пена дыня-клубника.', 'Whitley Neill gin, cherry, fresh lemon, sugar syrup, melon-strawberry foam.' ] ],
    'red-moscow'  => [ 'cocktails', 'Красная Москва', 'Red Moscow', [ 250, 'ml', 355 ], 'season' => 1, 'desc' => [ 'Настойка Барбариска, лимонный фреш, сахар, пена ежевика-лаванда.', 'Barberry infusion, fresh lemon, sugar, blackberry-lavender foam.' ] ],
    'barbara'     => [ 'cocktails', 'Барбара Коллинз', 'Barbara Collins', [ 250, 'ml', 355 ], 'season' => 1, 'desc' => [ 'Водка, кордиал барбарис-лемонграсс, содовая.', 'Vodka, barberry-lemongrass cordial, soda.' ] ],
    'camden'      => [ 'wine', 'Camden Park Шираз', 'Camden Park Shiraz', [ 125, 'ml', 315 ], [ 750, 'ml', 2050 ], 'desc' => [ 'Полусухое.', 'Semi-dry.' ] ],
    'absolut'     => [ 'spirits', 'Absolut', 'Absolut', [ 40, 'ml', 245 ] ],
    'woodford'    => [ 'spirits', 'Woodford Reserve', 'Woodford Reserve', [ 40, 'ml', 485 ], 'after' => [ 'Wild Turkey 81', 'Wild Turkey 81' ] ],
    'melon-shake' => [ 'no-buzz', 'Дынный с клубникой', 'Melon & Strawberry Milkshake', [ 250, 'ml', 255 ], 'season' => 1 ],
    'lemonade'    => [ 'no-buzz', 'Сезонный лимонад', 'Seasonal Lemonade', [ 350, 'ml', 170 ], 'season' => 1, 'desc' => [ 'Дыня-клубника или барбарис-лемонграсс.', 'Melon-strawberry or barberry-lemongrass.' ] ],
    'melon-raf'   => [ 'tea-coffee', 'Дынный раф с клубникой', 'Melon & Strawberry Raf', [ 250, 'ml', 225 ], 'season' => 1 ],
    'barberry-tea'=> [ 'tea-coffee', 'Барбарисовый', 'Barberry Tea', [ 600, 'ml', 290 ], 'after' => [ 'Малиновый', 'Raspberry Tea' ], 'season' => 1, 'desc' => [ 'С лемонграссом.', 'With lemongrass.' ] ],
];

// The «Сезонное меню» strip of each page, in order — the summer picks' shape kept.
$highlights = [
    'food'   => [ 'sweet-potato', 'caponata', 'soup-lunch', 'dakk', 'peanut-cake' ],
    'drinks' => [ 'barberry', 'coquette', 'red-moscow', 'barbara', 'melon-shake', 'lemonade', 'melon-raf' ],
];
$page_fields = [ 'menu_highlights_headline_en' => [ 'Summer Menu', 'Autumn Menu' ] ];

// ---------------------------------------------------------------------------------------------
// The machinery
// ---------------------------------------------------------------------------------------------

function sp_fall_lists( $slug ) {
    $page = sweet_pepper_menu_page( sweet_pepper_menu_state_for( $slug ) );
    $n    = 'sec_' . str_replace( '-', '_', $slug ) . '_subsections';
    $rows = (int) get_post_meta( $page->ID, $n, true );
    $out  = [];
    for ( $i = 0; $i < $rows; $i++ ) {
        $out[ "{$n}_{$i}_dishes" ] = array_map( 'intval', (array) get_post_meta( $page->ID, "{$n}_{$i}_dishes", true ) );
    }
    return [ $page->ID, $out ];
}

/** The record in a section's lists with this RU + EN name (and, if given, this seasonal label). */
function sp_fall_find( $slug, $ru, $en, $season_ru = null, $status = null ) {
    [ , $lists ] = sp_fall_lists( $slug );
    foreach ( $lists as $key => $ids ) {
        foreach ( $ids as $pos => $id ) {
            if ( html_entity_decode( get_the_title( $id ) ) === $ru && get_field( 'name_en', $id ) === $en
                && ( null === $season_ru || get_field( 'seasonal_ru', $id ) === $season_ru ) ) {
                return [ $id, $key, $pos ];
            }
        }
    }
    return null;
}

function sp_fall_put_list( $page_id, $key, $ids, $dry ) {
    if ( ! $dry ) {
        update_post_meta( $page_id, $key, array_map( 'strval', array_values( $ids ) ) );
    }
}

function sp_fall_create( $item, $dry ) {
    [ $slug, $ru, $en, $one ] = $item;
    $two    = isset( $item[4] ) && is_array( $item[4] ) ? $item[4] : [ '', 'g', '' ];
    $season = ! empty( $item['season'] );
    $fields = [
        'name_en'        => $en,
        'amount'         => $one[0], 'unit' => $one[1], 'price' => $one[2],
        'amount_2'       => $two[0], 'unit_2' => $two[1], 'price_2' => $two[2],
        'description_ru' => $item['desc'][0] ?? '', 'description_en' => $item['desc'][1] ?? '',
        'icons'          => [],
        'highlight'      => $season ? 1 : 0,
        'seasonal_ru'    => $season ? SP_AUTUMN[0] : '', 'seasonal_en' => $season ? SP_AUTUMN[1] : '',
        'options_ru'     => $item['options'][0] ?? '', 'options_en' => $item['options'][1] ?? '',
    ];
    if ( $dry ) {
        return -1;
    }
    $id = wp_insert_post( [
        'post_type'   => sweet_pepper_menu_item_type( $slug ),
        'post_status' => 'publish',
        'post_title'  => $ru,
    ] );
    foreach ( $fields as $name => $value ) {
        update_field( "field_sp_dish_dish_{$name}", $value, $id ); // tools/menu-seed.php
    }
    return $id;
}

$tag = $dry ? '[dry run] ' : '';
$ids = []; // new-item key => post ID

// 1. Prices, portions, labels.
foreach ( $updates as [ $slug, $ru, $en, $set ] ) {
    $hit = sp_fall_find( $slug, $ru, $en );
    if ( ! $hit ) {
        echo "  ? $slug: «{$ru}» / {$en} not on the page — skipped\n";
        continue;
    }
    $id   = $hit[0];
    $done = [];
    foreach ( $set as $field => [ $old, $new ] ) {
        $now = (string) get_field( $field, $id );
        if ( (string) $new === $now ) {
            $done[] = "$field already " . ( '' === $new ? '(empty)' : $new );
        } elseif ( (string) $old === $now ) {
            $dry || update_field( "field_sp_dish_dish_{$field}", $new, $id );
            $done[] = "$field $old → " . ( '' === $new ? '(empty)' : $new );
        } else {
            $done[] = "$field is «{$now}», expected «{$old}» — left alone";
        }
    }
    echo "{$tag}$slug: «{$ru}» — " . implode( '; ', $done ) . "\n";
}

// 2. Replacements and retirements.
$retired = [];
foreach ( $retire as $r ) {
    [ $slug, $ru, $en ] = $r;
    $hit = sp_fall_find( $slug, $ru, $en, $r['seasonal_ru'] ?? null );
    $with = $r['with'] ?? null;
    if ( ! $hit ) {
        echo "  $slug: «{$ru}» already off the page\n";
        continue;
    }
    [ $id, $key, $pos ] = $hit;
    [ $page_id, $lists ] = sp_fall_lists( $slug );
    $list = $lists[ $key ];
    if ( $with ) {
        $new_id       = sp_fall_create( $items[ $with ], $dry );
        $ids[ $with ] = $new_id;
        $list[ $pos ] = $new_id;
        echo "{$tag}$slug: «{$ru}» → «{$items[ $with ][1]}» (#$new_id) in its place\n";
    } else {
        unset( $list[ $pos ] );
        echo "{$tag}$slug: «{$ru}» off the list\n";
    }
    sp_fall_put_list( $page_id, $key, $list, $dry );
    $dry || wp_update_post( [ 'ID' => $id, 'post_status' => 'draft' ] );
    $retired[] = $id;
}

// 3. New items placed after an anchor.
foreach ( $items as $k => $item ) {
    [ $slug, $ru, $en ] = $item;
    if ( isset( $ids[ $k ] ) ) {
        continue; // placed by a replacement above
    }
    if ( $hit = sp_fall_find( $slug, $ru, $en, ! empty( $item['season'] ) ? SP_AUTUMN[0] : null ) ) {
        $ids[ $k ] = $hit[0];
        echo "  $slug: «{$ru}» already on the page (#{$hit[0]})\n";
        continue;
    }
    if ( empty( $item['after'] ) ) {
        echo "  ! $slug: «{$ru}» has no place (its predecessor was not found) — not created\n";
        continue;
    }
    $anchor = sp_fall_find( $slug, $item['after'][0], $item['after'][1] );
    if ( ! $anchor && $dry ) { // the anchor may be a new item this dry run did not create
        echo "{$tag}$slug: «{$ru}» after «{$item['after'][0]}»\n";
        continue;
    }
    if ( ! $anchor ) {
        echo "  ! $slug: «{$item['after'][0]}» not found — «{$ru}» not created\n";
        continue;
    }
    [ , $key, $pos ] = $anchor;
    [ $page_id, $lists ] = sp_fall_lists( $slug );
    $new_id    = sp_fall_create( $item, $dry );
    $ids[ $k ] = $new_id;
    $list      = $lists[ $key ];
    array_splice( $list, $pos + 1, 0, [ $new_id ] );
    sp_fall_put_list( $page_id, $key, $list, $dry );
    echo "{$tag}$slug: «{$ru}» (#$new_id) after «{$item['after'][0]}»\n";
}

// 4. The seasonal strips and their heading.
foreach ( $highlights as $state => $keys ) {
    $page = sweet_pepper_menu_page( $state );
    $list = array_values( array_filter( array_map( fn( $k ) => $ids[ $k ] ?? 0, $keys ) ) );
    if ( count( $list ) !== count( $keys ) ) {
        echo "  ! $state strip: " . ( count( $keys ) - count( $list ) ) . " item(s) missing — left as it is\n";
    } elseif ( array_map( 'intval', (array) get_post_meta( $page->ID, 'menu_highlights', true ) ) === $list ) {
        echo "  $state strip: already the fall picks\n";
    } else {
        $dry || update_post_meta( $page->ID, 'menu_highlights', array_map( 'strval', $list ) );
        echo "{$tag}$state strip: " . implode( ', ', array_map( fn( $id ) => $id > 0 ? '«' . get_the_title( $id ) . '»' : '(new)', $list ) ) . "\n";
    }
    foreach ( $page_fields as $field => [ $old, $value ] ) {
        $now = (string) get_post_meta( $page->ID, $field, true );
        if ( $now === $value ) {
            echo "  $state $field: already «{$value}»\n";
        } elseif ( $now === $old ) {
            $dry || update_post_meta( $page->ID, $field, $value );
            echo "{$tag}$state $field: «{$old}» → «{$value}»\n";
        } else {
            echo "  $state $field is «{$now}», expected «{$old}» — left alone\n";
        }
    }
}

// 5. Anything else still pointing at a retired record (the pickers, the home page).
global $wpdb;
foreach ( $retired as $id ) {
    $refs = $wpdb->get_results( $wpdb->prepare(
        "SELECT m.post_id, m.meta_key FROM $wpdb->postmeta m JOIN $wpdb->posts p ON p.ID = m.post_id
         WHERE m.meta_key NOT LIKE '\\_%%' AND m.meta_value LIKE %s
           AND p.post_type NOT IN ( 'revision', 'menu_list' ) AND p.post_status <> 'trash'",
        '%"' . $id . '"%'
    ) ); // relationship fields store serialized string IDs; the retired menu_list records are ignored
    foreach ( $refs as $ref ) {
        if ( (int) $ref->post_id === $id ) {
            continue;
        }
        echo "  ! «" . get_the_title( $id ) . "» (#$id) is still referenced by #{$ref->post_id} " . get_the_title( $ref->post_id ) . " → {$ref->meta_key}\n";
    }
}
if ( function_exists( 'wp_cache_clear_cache' ) && ! $dry ) {
    wp_cache_clear_cache();
}
echo $dry ? "Dry run — nothing written.\n" : "Done.\n";
