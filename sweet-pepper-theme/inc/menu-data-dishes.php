<?php
/**
 * Menu data — the menu store (website-brief.md → Content editing & languages →
 * Menu storage; option Б, decided 23 Sep 2026 after the team test).
 *
 * One post per item — `dish` («Блюда») for the kitchen, `drink` («Напитки») for the bar;
 * title = the Russian name, fields in acf-json/group_sp_dish.json — and one `menu_list`
 * record per section («Разделы меню»), slug = the section slug, holding subsections →
 * ordered Relationship lists (acf-json/group_sp_menu_list.json). Seeded by
 * tools/menu-seed.php. Also here: the two lists' admin tables.
 *
 * @package Sweet_Pepper
 */

/** The menu's two item types. */
function sweet_pepper_menu_item_types() {
    return [ 'dish', 'drink' ];
}

/**
 * Which type a section lists: bar sections list drinks, the kitchen's list dishes.
 *
 * @param string $slug Section slug.
 */
function sweet_pepper_menu_item_type( $slug ) {
    return isset( sweet_pepper_menu_sections( 'drinks' )[ $slug ] ) ? 'drink' : 'dish';
}

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
            if ( ! $dish || ! in_array( $dish->post_type, sweet_pepper_menu_item_types(), true ) ) {
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
 * A section's picker offers only its own kind: a bar section drinks, a kitchen section dishes.
 */
function sweet_pepper_dish_relationship_query( $args, $field, $post_id ) {
    $slug = get_post_field( 'post_name', $post_id );
    if ( $slug ) {
        $args['post_type'] = sweet_pepper_menu_item_type( $slug );
    }
    return $args;
}
add_filter( 'acf/fields/relationship/query/key=field_sp_list_dishes', 'sweet_pepper_dish_relationship_query', 10, 3 );

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
 * The Dishes and Drinks tables read like the menu: name · description · size and price · section; A–Z, not by date.
 */
function sweet_pepper_dish_admin_columns( $columns ) {
    unset( $columns['date'] );
    return $columns + [ 'sp_description' => 'Описание', 'sp_sizes' => 'Выход и цена', 'sp_section' => 'Раздел меню', 'date' => 'Дата' ];
}
foreach ( sweet_pepper_menu_item_types() as $sp_type ) {
    add_filter( "manage_{$sp_type}_posts_columns", 'sweet_pepper_dish_admin_columns' );
    add_action( "manage_{$sp_type}_posts_custom_column", 'sweet_pepper_dish_admin_column', 10, 2 );
}
unset( $sp_type );

function sweet_pepper_dish_admin_column( $column, $post_id ) {
    if ( 'sp_description' === $column ) {
        echo esc_html( (string) get_field( 'description_ru', $post_id ) ?: '—' );
    }
    if ( 'sp_sizes' === $column ) {
        echo esc_html( sweet_pepper_dish_sizes_label( $post_id ) ?: '—' );
        echo sweet_pepper_dish_quick_data( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped there; Quick Edit starts from it (inc/dish-quick-edit.php)
    }
    if ( 'sp_section' === $column ) {
        $links = [];
        foreach ( sweet_pepper_dish_placements()[ $post_id ] ?? [] as $list_id => $title ) {
            $links[] = sprintf( '<a href="%s">%s</a>', esc_url( get_edit_post_link( $list_id ) ), esc_html( $title ) );
        }
        echo $links ? implode( ', ', $links ) : '— не в меню';
    }
}

/**
 * A «Раздел» dropdown above each table: a long list narrowed to one section, for when
 * search isn't the way in (the drinks list alone is ~160 items).
 */
function sweet_pepper_dish_admin_filter( $post_type ) {
    if ( ! in_array( $post_type, sweet_pepper_menu_item_types(), true ) ) {
        return;
    }
    $current = isset( $_GET['sp_section'] ) ? absint( $_GET['sp_section'] ) : 0; // phpcs:ignore WordPress.Security.NonceVerification -- a list filter
    $lists   = get_posts( [ 'post_type' => 'menu_list', 'post_status' => 'any', 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ] );
    echo '<label class="screen-reader-text" for="sp-section">Раздел меню</label>';
    echo '<select name="sp_section" id="sp-section"><option value="0">Все разделы</option>';
    foreach ( $lists as $list ) {
        if ( sweet_pepper_menu_item_type( $list->post_name ) !== $post_type ) {
            continue;
        }
        printf( '<option value="%d"%s>%s</option>', (int) $list->ID, selected( $current, $list->ID, false ), esc_html( $list->post_title ) );
    }
    echo '<option value="-1"' . selected( $current, -1, false ) . '>— не в меню</option></select>';
}
add_action( 'restrict_manage_posts', 'sweet_pepper_dish_admin_filter' );

function sweet_pepper_dish_admin_order( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() || ! in_array( $query->get( 'post_type' ), sweet_pepper_menu_item_types(), true ) ) {
        return;
    }
    if ( ! $query->get( 'orderby' ) ) {
        $query->set( 'orderby', 'title' );
        $query->set( 'order', 'ASC' );
    }
    $section = isset( $_GET['sp_section'] ) ? (int) $_GET['sp_section'] : 0; // phpcs:ignore WordPress.Security.NonceVerification -- a list filter
    if ( $section ) {
        $placed = array_keys( array_filter( sweet_pepper_dish_placements(), fn( $lists ) => isset( $lists[ $section ] ) ) );
        if ( $section > 0 ) {
            $query->set( 'post__in', $placed ?: [ 0 ] );
        } else {
            $query->set( 'post__not_in', array_keys( sweet_pepper_dish_placements() ) );
        }
    }
}
add_action( 'pre_get_posts', 'sweet_pepper_dish_admin_order' );

// Two icons at most, as in the repeater store (inc/menu-data.php).
add_filter( 'acf/validate_value/key=field_sp_dish_dish_icons', 'sweet_pepper_menu_validate_icons', 10, 2 );
