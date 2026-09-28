<?php
/**
 * Fall 2026 photos — the seasonal strips at six cards each, every card with a photo from the
 * team's autumn shoot (photos/website-ready/fall-2026, cropped 3:2 into the theme's
 * assets/images/fall-2026/). Author, 28 Sep 2026: "6 cards by default, a bar/food mix is fine;
 * the new photos as placeholders — the team will change them, but they need to see what goes
 * where".
 *
 * - A photo goes into the item's «Фото» (the featured image mirrors it), and only where the
 *   item has none — a photo the team already chose is kept and reported.
 * - Uploads are found again by `_sp_source` (as tools/page-seed.php stamps them), so a second
 *   run uploads nothing; each takes a Russian Media Library alt and its «Тема».
 * - The strips are written only while they still hold the 25 Sep fall picks (by name); a
 *   strip the team has edited is left alone and reported.
 *
 * Records are found by post type + Russian name + English name, never by ID, so the same file
 * runs on the test and main sites. Safe to run twice.
 *
 *   PHP=~/Library/Application\ Support/Local/lightning-services/php-8.2.30+1/bin/darwin-arm64/bin/php
 *   SOCK=~/Library/Application\ Support/Local/run/1tx2Lcx_A/mysql/mysqld.sock
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/menu-updates/2026-09-28-fall-photos.php [--dry-run]
 *   test site: WP_ROOT=~/SweetPepper-test/public_html php tools/menu-updates/2026-09-28-fall-photos.php
 */

$dry     = in_array( '--dry-run', $argv, true );
$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';
$tag = $dry ? '[dry] ' : '';

// key => [ RU name, EN name, asset (assets/images/), Media Library alt (RU), «Тема» ]
$items = [
    'sweet-potato' => [ 'Осенний салат с бататом', 'Autumn sweet potato salad', 'fall-2026/autumn-salad.jpg', 'Осенний салат с бататом, брынзой, рукколой и черри', 'Еда' ],
    'caponata'     => [ 'Капоната с фетой', 'Caponata with feta', 'fall-2026/caponata.jpg', 'Капоната с фетой: баклажаны, перец, цукини и руккола', 'Еда' ],
    'soup-lunch'   => [ 'Осенний супчик дня', 'Autumn soup of the day', 'fall-2026/autumn-soup.jpg', 'Сливочный суп с колбасками в жёлтой миске', 'Еда' ],
    'lemonade'     => [ 'Сезонный лимонад', 'Seasonal Lemonade', 'fall-2026/seasonal-lemonade.jpg', 'Сезонный лимонад со льдом и листом лемонграсса, за ним дыня', 'Бар' ],
    'melon-raf'    => [ 'Дынный раф с клубникой', 'Melon & Strawberry Raf', 'fall-2026/melon-raf.jpg', 'Дынный раф с клубникой в высоком стакане', 'Бар' ],
    'barberry-tea' => [ 'Барбарисовый', 'Barberry Tea', 'fall-2026/barberry-tea.jpg', 'Барбарисовый чай с лимоном в стеклянной кружке', 'Бар' ],
    'barberry'     => [ 'Барбариска', 'Barberry', 'fall-2026/barberry-infusion.jpg', 'Настойка «Барбариска» в графине и стопке', 'Бар' ],
    'coquette'     => [ 'Кокетка', 'Coquette', 'fall-2026/coquette.jpg', 'Коктейль «Кокетка» в бокале-купе с пеной и цветком василька', 'Бар' ],
    'red-moscow'   => [ 'Красная Москва', 'Red Moscow', 'fall-2026/red-moscow.jpg', 'Коктейль «Красная Москва» с пеной и цветком василька', 'Бар' ],
    'barbara'      => [ 'Барбара Коллинз', 'Barbara Collins', 'fall-2026/barbara-collins.jpg', 'Коктейль «Барбара Коллинз» с лимоном и лемонграссом', 'Бар' ],
    'melon-shake'  => [ 'Дынный с клубникой', 'Melon & Strawberry Milkshake', 'fall-2026/melon-milkshake.jpg', 'Дынный молочный коктейль со сливками и красным листиком', 'Бар' ],
];

// The strips: [ the 25 Sep fall picks (RU names — what is expected now), the six new keys ].
$strips = [
    'food'   => [ [ 'Осенний салат с бататом', 'Капоната с фетой', 'Осенний супчик дня', 'Дакк салат', 'Арахисовый торт' ],
                  [ 'sweet-potato', 'caponata', 'soup-lunch', 'lemonade', 'melon-raf', 'barberry-tea' ] ],
    'drinks' => [ [ 'Барбариска', 'Кокетка', 'Красная Москва', 'Барбара Коллинз', 'Дынный с клубникой', 'Сезонный лимонад', 'Дынный раф с клубникой' ],
                  [ 'barberry', 'coquette', 'red-moscow', 'barbara', 'melon-shake', 'lemonade' ] ],
];

/** The published menu item with this RU + EN name. */
function sp_photos_find( $ru, $en ) {
    $found = get_posts( [ 'post_type' => sweet_pepper_menu_item_types(), 'post_status' => 'publish', 'title' => $ru,
                          'posts_per_page' => -1, 'fields' => 'ids' ] );
    $found = array_values( array_filter( $found, fn( $id ) => get_field( 'name_en', $id ) === $en ) );
    return 1 === count( $found ) ? $found[0] : ( $found ? -count( $found ) : 0 );
}

/** The theme asset as an attachment: found by `_sp_source`, else uploaded with its alt and topic. */
function sp_photos_attachment( $asset, $alt, $topic, $dry ) {
    $found = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => 1, 'fields' => 'ids',
                          'meta_key' => '_sp_source', 'meta_value' => $asset ] );
    if ( $found ) {
        return (int) $found[0];
    }
    if ( $dry ) {
        return -1;
    }
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $file = get_template_directory() . '/assets/images/' . $asset;
    if ( ! is_file( $file ) ) {
        exit( "No theme asset {$asset} — sync the theme first.\n" );
    }
    $up = wp_upload_bits( basename( $asset ), null, file_get_contents( $file ) );
    if ( ! empty( $up['error'] ) ) {
        exit( "upload failed for {$asset}: {$up['error']}\n" );
    }
    $id = wp_insert_attachment( [
        'post_mime_type' => $up['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $asset ) ),
        'post_status'    => 'inherit',
    ], $up['file'] );
    wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $up['file'] ) );
    update_post_meta( $id, '_sp_source', $asset );
    update_post_meta( $id, '_wp_attachment_image_alt', $alt );
    if ( taxonomy_exists( 'media_topic' ) ) {
        wp_set_object_terms( $id, $topic, 'media_topic' );
    }
    return (int) $id;
}

// 1. The photos.
$ids = [];
foreach ( $items as $key => [ $ru, $en, $asset, $alt, $topic ] ) {
    $id = sp_photos_find( $ru, $en );
    if ( $id <= 0 ) {
        echo '  ! «' . $ru . '»: ' . ( $id ? ( -$id ) . ' published records' : 'no published record' ) . " — skipped\n";
        continue;
    }
    $ids[ $key ] = $id;
    $now = (int) get_field( 'photo', $id, false );
    $att = sp_photos_attachment( $asset, $alt, $topic, $dry );
    if ( $now && $now === $att ) {
        echo "  «{$ru}» (#$id): already {$asset}\n";
    } elseif ( $now ) {
        echo "  «{$ru}» (#$id) has its own photo (#$now " . basename( (string) get_attached_file( $now ) ) . ") — kept\n";
    } else {
        if ( ! $dry ) {
            update_field( 'field_sp_dish_dish_photo', $att, $id );
            update_post_meta( $id, '_thumbnail_id', $att ); // what acf/save_post mirrors (inc/menu-data-dishes.php)
        }
        echo "{$tag}«{$ru}» (#$id): photo {$asset}" . ( $att > 0 ? " (attachment #$att)" : '' ) . "\n";
    }
}

// 2. The strips.
foreach ( $strips as $state => [ $expected, $keys ] ) {
    $page = sweet_pepper_menu_page( $state );
    if ( ! $page ) {
        echo "  ! no $state menu page\n";
        continue;
    }
    $new = array_values( array_filter( array_map( fn( $k ) => $ids[ $k ] ?? 0, $keys ) ) );
    $cur = array_map( 'intval', array_filter( (array) get_post_meta( $page->ID, 'menu_highlights', true ) ) );
    $cur_names = array_map( fn( $id ) => html_entity_decode( get_the_title( $id ) ), $cur );
    if ( count( $new ) !== count( $keys ) ) {
        echo "  ! $state strip: " . ( count( $keys ) - count( $new ) ) . " item(s) not found — left as it is\n";
    } elseif ( $cur === $new ) {
        echo "  $state strip: already the six\n";
    } elseif ( $cur_names !== $expected ) {
        echo "  $state strip holds «" . implode( '», «', $cur_names ) . "» — not the fall picks, left alone\n";
    } else {
        $dry || update_post_meta( $page->ID, 'menu_highlights', array_map( 'strval', $new ) );
        echo "{$tag}$state strip: «" . implode( '», «', array_map( fn( $id ) => html_entity_decode( get_the_title( $id ) ), $new ) ) . "»\n";
    }
}

if ( function_exists( 'wp_cache_clear_cache' ) && ! $dry ) {
    wp_cache_clear_cache();
}
echo $dry ? "Dry run — nothing written.\n" : "Done.\n";
