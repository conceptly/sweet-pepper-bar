<?php
/**
 * Menu data — where the section templates get their rows.
 *
 * The menu store (website-brief.md → Content editing & languages → Menu storage,
 * decided 23 Sep 2026): one `dish` or `drink` post per item, placed by the section's
 * `menu_list` record — slug = the section slug in inc/menu-sections.php
 * (inc/menu-data-dishes.php). Templates never read fields: they loop over
 * sweet_pepper_menu_subsections(), which hands back dish-row args in one language.
 * While a record is missing or empty the typed rows in data/menu/<slug>.php render
 * instead, so a section converts without the page ever going blank.
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
    if ( isset( $cache[ $slug ] ) ) {
        return $cache[ $slug ];
    }

    $rows = sweet_pepper_menu_list_rows( $slug );
    if ( empty( $rows ) ) {
        return $cache[ $slug ] = sweet_pepper_menu_fallback( $slug );
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
            'title'   => $pick( $sub, 'title' ),
            'column'  => 'right' === ( $sub['column'] ?? '' ) ? 'right' : 'left',
            'style'   => 'card' === ( $sub['style'] ?? '' ) ? 'card' : 'list',
            'divider' => ! empty( $sub['divider'] ),
            'note'    => $pick( $sub, 'note' ),
            'dishes'  => $dishes,
        ];
    }

    return $cache[ $slug ] = $subsections;
}

/**
 * A dish carries two icons at most, never the same one twice (author, Sep 2026).
 */
function sweet_pepper_menu_validate_icons( $valid, $value ) {
    if ( true === $valid && is_array( $value ) && count( $value ) > 2 ) {
        return 'Не больше двух значков на блюдо.';
    }
    return $valid;
}
