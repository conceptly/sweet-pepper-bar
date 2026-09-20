<?php
/**
 * Menu data, dishes store — the second candidate of the Menu storage test.
 *
 * One `dish` post per dish (title = the Russian name, fields in
 * acf-json/group_sp_dish.json) and one `menu_list` record per section, slug = the
 * section slug, holding subsections → ordered Relationship lists of dishes
 * (acf-json/group_sp_menu_list.json). Rendered with `?menu_store=dishes`
 * (inc/menu-data.php → sweet_pepper_menu_store()); seeded by tools/menu-seed.php --dishes.
 *
 * If the repeater store wins, this file goes, with its require in functions.php, the
 * `dish` and `menu_list` post types (inc/cpt.php), the two field groups and their
 * block in tools/menu-field-group.py, and the --dishes branch of the seeder.
 *
 * website-brief.md → Content editing & languages → Menu storage.
 *
 * @package Sweet_Pepper
 */

/**
 * A section's rows in the shape the repeater store saves them, so
 * sweet_pepper_menu_subsections() renders both stores through one loop.
 * A dish's post supplies what a repeater row carries as fields: the Russian name
 * (title), hidden (any status but Published) and the stable id (post ID).
 *
 * @param string $slug Section slug, e.g. 'soups'.
 * @return array[] Rows of `menu_subsections`, each `dishes` a list of dish field arrays.
 */
function sweet_pepper_menu_list_rows( $slug ) {
    $list = get_page_by_path( $slug, OBJECT, 'menu_list' );
    if ( ! $list || 'publish' !== $list->post_status || ! function_exists( 'get_field' ) ) {
        return [];
    }

    $rows = (array) get_field( 'menu_subsections', $list->ID );
    foreach ( $rows as &$sub ) {
        $dishes = [];
        foreach ( (array) ( $sub['dishes'] ?? [] ) as $dish_id ) {
            $dish = get_post( $dish_id );
            // A deleted dish drops out of its list silently.
            if ( ! $dish || 'dish' !== $dish->post_type ) {
                continue;
            }
            $dishes[] = [
                'name_ru' => $dish->post_title,
                'hidden'  => 'publish' !== $dish->post_status,
                'dish_id' => (string) $dish->ID,
            ] + (array) get_fields( $dish->ID );
        }
        $sub['dishes'] = $dishes;
    }
    unset( $sub );

    return $rows;
}

/**
 * "220 г · 255-." — tells two dishes of one name apart wherever admin lists them
 * (Soups has two «Тыквенный суп» and two «Грибная кружка»).
 */
function sweet_pepper_dish_sizes_label( $dish_id ) {
    [ $price, $quantity ] = sweet_pepper_menu_format_sizes( (array) get_fields( $dish_id ), 'ru' );
    return implode( ' · ', array_filter( [ $quantity, $price ] ) );
}

/**
 * The Relationship picker shows the size, the price and the start of the description
 * beside each dish's name — the description is what tells the two mushroom mugs apart
 * (same name, same leaf icon, same subsection).
 */
function sweet_pepper_dish_relationship_result( $title, $post ) {
    $about = array_filter( [
        sweet_pepper_dish_sizes_label( $post->ID ),
        wp_html_excerpt( (string) get_field( 'description_ru', $post->ID ), 40, '…' ),
    ] );
    return $about ? $title . ' — ' . esc_html( implode( ' · ', $about ) ) : $title;
}
add_filter( 'acf/fields/relationship/result/key=field_sp_list_dishes', 'sweet_pepper_dish_relationship_result', 10, 2 );

/**
 * Which section lists place a dish: dish ID → [ list ID => 'Section · subsection' ].
 * A dish in no list is on no page — the Dishes table says so.
 */
function sweet_pepper_dish_placements() {
    static $map = null;
    if ( null !== $map ) {
        return $map;
    }
    $map   = [];
    $lists = get_posts( [ 'post_type' => 'menu_list', 'post_status' => 'any', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ] );
    foreach ( $lists as $list ) {
        foreach ( (array) get_field( 'menu_subsections', $list->ID ) as $sub ) {
            foreach ( (array) ( $sub['dishes'] ?? [] ) as $dish_id ) {
                $map[ (int) $dish_id ][ $list->ID ] = implode( ' · ', array_filter( [ $list->post_title, $sub['title_ru'] ?? '' ] ) );
            }
        }
    }
    return $map;
}

/**
 * The Dishes table reads like the menu: name · description · size and price · section; A–Z, not by date.
 */
function sweet_pepper_dish_admin_columns( $columns ) {
    unset( $columns['date'] );
    return $columns + [ 'sp_description' => 'Описание', 'sp_sizes' => 'Выход и цена', 'sp_section' => 'Раздел меню', 'date' => 'Дата' ];
}
add_filter( 'manage_dish_posts_columns', 'sweet_pepper_dish_admin_columns' );

function sweet_pepper_dish_admin_column( $column, $post_id ) {
    if ( 'sp_description' === $column ) {
        echo esc_html( (string) get_field( 'description_ru', $post_id ) ?: '—' );
    }
    if ( 'sp_sizes' === $column ) {
        echo esc_html( sweet_pepper_dish_sizes_label( $post_id ) ?: '—' );
    }
    if ( 'sp_section' === $column ) {
        $links = [];
        foreach ( sweet_pepper_dish_placements()[ $post_id ] ?? [] as $list_id => $title ) {
            $links[] = sprintf( '<a href="%s">%s</a>', esc_url( get_edit_post_link( $list_id ) ), esc_html( $title ) );
        }
        echo $links ? implode( ', ', $links ) : '— не в меню';
    }
}
add_action( 'manage_dish_posts_custom_column', 'sweet_pepper_dish_admin_column', 10, 2 );

function sweet_pepper_dish_admin_order( $query ) {
    if ( is_admin() && $query->is_main_query() && 'dish' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'sweet_pepper_dish_admin_order' );

// Two icons at most, as in the repeater store (inc/menu-data.php).
add_filter( 'acf/validate_value/key=field_sp_dish_dish_icons', 'sweet_pepper_menu_validate_icons', 10, 2 );
