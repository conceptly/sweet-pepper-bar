<?php
/**
 * Menu data — where the section templates get their rows.
 *
 * One `menu_section` record per menu section (inc/cpt.php), slug = the section
 * slug in inc/menu-sections.php. Its SCF repeater (acf-json/group_sp_menu_section.json)
 * holds subsections → dishes. Templates never read fields: they loop over
 * sweet_pepper_menu_subsections(), which hands back dish-row args in one language.
 * While a record is missing or empty the typed rows in data/menu/<slug>.php render
 * instead, so a section converts without the page ever going blank.
 *
 * While Menu storage is under test, `?menu_store=dishes` renders a section from the
 * other store instead — `dish` posts placed by a `menu_list` record
 * (inc/menu-data-dishes.php). The flag goes when the test is decided.
 *
 * website-brief.md → Content editing & languages → Menu storage.
 *
 * @package Sweet_Pepper
 */

/**
 * Language of the current request — the site's (inc/fields.php).
 */
function sweet_pepper_menu_lang() {
    return sweet_pepper_lang();
}

/**
 * Which store the request renders from: 'repeater' (default) | 'dishes'.
 */
function sweet_pepper_menu_store() {
    return ( isset( $_GET['menu_store'] ) && 'dishes' === $_GET['menu_store'] ) ? 'dishes' : 'repeater';
}

/**
 * Units of a dish's quantity. The team picks one from a dropdown; the twins live here.
 */
function sweet_pepper_menu_units() {
    return [
        'g'   => [ 'ru' => 'г',  'en' => 'g' ],
        'ml'  => [ 'ru' => 'мл', 'en' => 'ml' ],
        'l'   => [ 'ru' => 'л',  'en' => 'L' ],
        'pcs' => [ 'ru' => 'шт', 'en' => 'pcs' ],
    ];
}

/**
 * A dish has one size or two (40 ml / 500 ml → 150-. / 1300-.). The team types
 * numbers only; the "-." and the unit are set here, so they can't be forgotten.
 *
 * @param array  $dish Row of the dishes repeater.
 * @param string $lang 'ru' | 'en'.
 * @return array [ price string, quantity string ]
 */
function sweet_pepper_menu_format_sizes( $dish, $lang ) {
    $units  = sweet_pepper_menu_units();
    $number = fn( $n ) => str_replace( '.', 'ru' === $lang ? ',' : '.', (string) ( 0 + $n ) );
    $prices = $quantities = [];
    foreach ( [ '', '_2' ] as $size ) {
        $price  = $dish[ "price{$size}" ] ?? '';
        $amount = $dish[ "amount{$size}" ] ?? '';
        if ( is_numeric( $price ) ) {
            $prices[] = ( 0 + $price ) . '-.';
        }
        if ( is_numeric( $amount ) && $amount > 0 ) {
            $unit         = $units[ $dish[ "unit{$size}" ] ?? '' ][ $lang ] ?? '';
            $quantities[] = trim( $number( $amount ) . ' ' . $unit );
        }
    }
    return [ implode( ' / ', $prices ), implode( ' / ', $quantities ) ];
}

/**
 * @param string $slug Section slug, e.g. 'soups'.
 * @return WP_Post|null The published record for the section.
 */
function sweet_pepper_menu_section_post( $slug ) {
    $post = get_page_by_path( $slug, OBJECT, 'menu_section' );
    return ( $post && 'publish' === $post->post_status ) ? $post : null;
}

/**
 * @param string $slug Section slug.
 * @return array The typed rows from data/menu/<slug>.php, or [].
 */
function sweet_pepper_menu_fallback( $slug ) {
    $file = get_template_directory() . '/data/menu/' . sanitize_key( $slug ) . '.php';
    return file_exists( $file ) ? (array) require $file : [];
}

/**
 * Subsections of a section, ready to render.
 *
 * @param string $slug Section slug.
 * @return array[] Each: [ title, column ('left'|'right'), style ('list'|'card'), dishes => dish-row args[] ].
 */
function sweet_pepper_menu_subsections( $slug ) {
    static $cache = [];
    $store = sweet_pepper_menu_store();
    $key   = "{$store}:{$slug}";
    if ( isset( $cache[ $key ] ) ) {
        return $cache[ $key ];
    }

    if ( 'dishes' === $store ) {
        $rows = sweet_pepper_menu_list_rows( $slug );
    } else {
        $post = sweet_pepper_menu_section_post( $slug );
        $rows = ( $post && function_exists( 'get_field' ) ) ? get_field( 'menu_subsections', $post->ID ) : [];
    }

    if ( empty( $rows ) ) {
        return $cache[ $key ] = sweet_pepper_menu_fallback( $slug );
    }

    $lang  = sweet_pepper_menu_lang();
    $other = 'ru' === $lang ? 'en' : 'ru';
    // The other language stands in for a twin left empty, rather than a blank row.
    $pick  = fn( $row, $key ) => trim( (string) ( $row[ "{$key}_{$lang}" ] ?? '' ) ) ?: trim( (string) ( $row[ "{$key}_{$other}" ] ?? '' ) );
    $lines = fn( $text ) => array_values( array_filter( array_map( 'trim', preg_split( '/\R/', (string) $text ) ) ) );

    $subsections = [];
    foreach ( $rows as $sub ) {
        $dishes = [];
        foreach ( (array) ( $sub['dishes'] ?? [] ) as $dish ) {
            if ( ! empty( $dish['hidden'] ) ) {
                continue;
            }
            [ $price, $quantity ] = sweet_pepper_menu_format_sizes( $dish, $lang );
            $dishes[] = [
                'dish_id'        => $dish['dish_id'] ?? '',
                'dish_name'      => $pick( $dish, 'name' ),
                'price'          => $price,
                'quantity'       => $quantity,
                'description'    => $pick( $dish, 'description' ),
                'icons'          => array_slice( (array) ( $dish['icons'] ?? [] ), 0, 2 ),
                'seasonal_label' => $pick( $dish, 'seasonal' ),
                'options'        => $lines( $pick( $dish, 'options' ) ),
                'highlight'      => ! empty( $dish['highlight'] ),
            ];
        }
        // A subsection with every dish hidden takes its header with it.
        if ( ! $dishes ) {
            continue;
        }
        $subsections[] = [
            'title'  => $pick( $sub, 'title' ),
            'column' => 'right' === ( $sub['column'] ?? '' ) ? 'right' : 'left',
            'style'  => 'card' === ( $sub['style'] ?? '' ) ? 'card' : 'list',
            'dishes' => $dishes,
        ];
    }

    return $cache[ $key ] = $subsections;
}

/**
 * Give every dish row a stable id on save — highlights, previews and the dish
 * picker will reference a dish by it. Random, not built from the name: names get
 * edited, and Soups alone has two "Pumpkin soup" rows. A duplicated row arrives
 * with its source's id, so repeats are re-issued too.
 */
function sweet_pepper_menu_fill_dish_ids( $post_id ) {
    if ( 'menu_section' !== get_post_type( $post_id ) ) {
        return;
    }
    $seen = [];
    foreach ( (array) get_field( 'menu_subsections', $post_id ) as $i => $sub ) {
        foreach ( (array) ( $sub['dishes'] ?? [] ) as $j => $dish ) {
            $id = $dish['dish_id'] ?? '';
            if ( '' === $id || isset( $seen[ $id ] ) ) {
                $id = 'd-' . bin2hex( random_bytes( 4 ) );
                update_sub_field( [ 'menu_subsections', $i + 1, 'dishes', $j + 1, 'dish_id' ], $id, $post_id );
            }
            $seen[ $id ] = true;
        }
    }
}
add_action( 'acf/save_post', 'sweet_pepper_menu_fill_dish_ids', 20 );

/**
 * A dish carries two icons at most, never the same one twice (author, Sep 2026).
 */
function sweet_pepper_menu_validate_icons( $valid, $value ) {
    if ( true === $valid && is_array( $value ) && count( $value ) > 2 ) {
        return 'Не больше двух значков на блюдо.';
    }
    return $valid;
}
add_filter( 'acf/validate_value/key=field_sp_menu_dish_icons', 'sweet_pepper_menu_validate_icons', 10, 2 );
