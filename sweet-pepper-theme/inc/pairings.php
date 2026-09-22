<?php
/**
 * Food → drink pairings for the dish picker.
 *
 * One list, two homes: the menu page's pairing station and the About page's Concept
 * picker (website-brief.md → Picker pairings: the surfaces that show a dish reference one
 * record, they never hold their own copy). The record is the one `pairings` post
 * («Подбор пары», acf-json/group_sp_pairings.json); until it has rows, the typed list in
 * data/pairings.php renders.
 *
 * Temporary shape (author, 21 Sep 2026): the dish and the drink are typed into the row —
 * name, description, photo — because the menu is not in the database yet. When it is,
 * those columns become references to menu dishes and this file reads the dish instead.
 *
 * @package Sweet_Pepper
 */

/**
 * The record. Made by the seeder; the post type allows no second one.
 */
function sweet_pepper_pairings_post() {
    $posts = get_posts( [ 'post_type' => 'pairings', 'post_status' => 'publish', 'posts_per_page' => 1 ] );
    return $posts[0] ?? null;
}

/**
 * Each entry: slug, dish (tag label), card_name (ticket name), description,
 * food_img / bar_img (URLs), pairing (the bar's reply), bar_section (drinks anchor),
 * default (opens first). One language, the request's.
 */
function sweet_pepper_food_pairings() {
    static $pairings = null;
    if ( null !== $pairings ) {
        return $pairings;
    }
    $post = sweet_pepper_pairings_post();
    $rows = ( $post && function_exists( 'get_field' ) ) ? ( get_field( 'pairs', $post->ID ) ?: [] ) : [];
    $saved = (bool) $rows;
    if ( ! $saved ) {
        foreach ( require get_template_directory() . '/data/pairings.php' as $row ) {
            $rows[] = [
                'slug'                => $row['slug'],
                'dish_name_en'        => $row['dish'],
                'dish_name_ru'        => $row['ru']['dish'] ?? '',
                'dish_short_en'       => $row['dish_short'],
                'dish_short_ru'       => $row['ru']['dish_short'] ?? '',
                'dish_description_en' => $row['description'],
                'dish_description_ru' => $row['ru']['description'] ?? '',
                'reply_en'            => $row['reply'],
                'reply_ru'            => $row['ru']['reply'] ?? '',
                'drink_section'       => $row['drink_section'],
                'default'             => $row['default'],
                'food_fallback'       => $row['food_img'],
                'bar_fallback'        => $row['bar_img'],
            ];
        }
    }

    $pairings = [];
    foreach ( $rows as $i => $row ) {
        $dish = sweet_pepper_pick( $row, 'dish_name' );
        if ( '' === $dish || ! empty( $row['hidden'] ) ) {
            continue;
        }
        $pairings[] = [
            'slug'        => $row['slug'] ?? sanitize_title( $row['dish_name_en'] ?: $dish ) ?: 'pair-' . $i,
            'dish'        => $dish,
            'card_name'   => sweet_pepper_pick( $row, 'dish_short' ) ?: $dish,
            'description' => sweet_pepper_pick( $row, 'dish_description' ),
            'food_img'    => sweet_pepper_photo_url( $row['dish_photo'] ?? '', 'sp-square', $row['food_fallback'] ?? '' ),
            'bar_img'     => sweet_pepper_photo_url( $row['drink_photo'] ?? '', 'sp-square', $row['bar_fallback'] ?? '' ),
            'pairing'     => sweet_pepper_pick( $row, 'reply' ),
            'bar_section' => (string) ( $row['drink_section'] ?? 'infusions' ),
            'default'     => ! empty( $row['default'] ),
        ];
    }
    return $pairings;
}

/**
 * The row the picker opens on: the first marked «Открывается первой», else the first.
 * ($slug is kept for the two callers; a saved record decides by the switch.)
 */
function sweet_pepper_pairing_index( $pairings, $slug = '' ) {
    foreach ( $pairings as $i => $p ) {
        if ( ! empty( $p['default'] ) ) {
            return $i;
        }
    }
    $index = array_search( $slug, array_column( $pairings, 'slug' ), true );
    return false === $index ? 0 : $index;
}
