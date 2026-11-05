<?php
/**
 * Menu data — the menu store (website-brief.md → Content editing & languages →
 * Menu storage; option Б, decided 23 Sep 2026 after the team test).
 *
 * One post per item — `dish` («Блюда») for the kitchen, `drink` («Напитки») for the bar;
 * title = the Russian name, fields in acf-json/group_sp_dish.json — placed by the section's
 * tab on its menu page (since 24 Sep 2026; acf-json/group_sp_menu_food.json / _bar.json):
 * `sec_<slug>_subsections`, subsections → ordered Relationship lists. Until then the lists
 * sat on «Разделы меню» records (`menu_list`), migrated by tools/page-seed.php menu. Seeded
 * by tools/menu-seed.php. Also here: the two item types' admin tables.
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
    return isset( sweet_pepper_menu_sections_typed( 'drinks' )[ $slug ] ) ? 'drink' : 'dish';
}

/**
 * A section's rows in the shape the repeater store saves them, so
 * sweet_pepper_menu_subsections() renders both stores through one loop.
 * A dish's post supplies what a repeater row carries as fields: the Russian name
 * (title), hidden (any status but Published) and the stable id (post ID).
 *
 * @param string $slug Section slug, e.g. 'soups'.
 * @return array[] Rows of the section's `subsections` repeater, each `dishes` a list of dish field arrays.
 */
function sweet_pepper_menu_list_rows( $slug ) {
    $rows = function_exists( 'get_field' ) ? sweet_pepper_menu_section_value( $slug, 'subsections' ) : [];
    $rows = is_array( $rows ) ? $rows : [];
    foreach ( $rows as &$sub ) {
        $dishes = [];
        foreach ( (array) ( $sub['dishes'] ?? [] ) as $dish_id ) {
            $dish = sweet_pepper_menu_item_row( $dish_id );
            // A deleted dish drops out of its list silently.
            if ( $dish ) {
                $dishes[] = $dish;
            }
        }
        $sub['dishes'] = $dishes;
    }
    unset( $sub );

    return $rows;
}

/**
 * A dish or drink post in the shape a list row carries — what the repeater store's row held as
 * fields: the Russian name (title), hidden (any status but Published), the stable id (post ID),
 * then its fields. Null for a deleted post or one of another type. The section lists read it
 * through sweet_pepper_menu_list_rows(); the home page's previews read it for their picks.
 *
 * @param int $post_id
 * @return array|null
 */
function sweet_pepper_menu_item_row( $post_id ) {
    $dish = get_post( $post_id );
    if ( ! $dish || ! in_array( $dish->post_type, sweet_pepper_menu_item_types(), true ) ) {
        return null;
    }
    return [
        'name_ru' => $dish->post_title,
        'hidden'  => 'publish' !== $dish->post_status,
        'dish_id' => (string) $dish->ID,
    ] + (array) get_fields( $dish->ID );
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

// The section lists' pickers (every `dishes` sub-field) show the same label.
add_filter( 'acf/fields/relationship/result/name=dishes', 'sweet_pepper_dish_relationship_result', 10, 2 );

/**
 * Which sections place a dish: dish ID → [ section slug => 'Раздел · подраздел' ], in menu
 * order. A dish in no section is on no page — the Dishes table says so.
 */
function sweet_pepper_dish_placements() {
    static $map = null;
    if ( null !== $map ) {
        return $map;
    }
    $map = [];
    foreach ( [ 'food', 'drinks' ] as $state ) {
        if ( ! sweet_pepper_menu_page( $state ) ) {
            continue;
        }
        foreach ( sweet_pepper_menu_sections( $state ) as $slug => $sec ) {
            foreach ( (array) sweet_pepper_menu_section_value( $slug, 'subsections' ) as $sub ) {
                foreach ( (array) ( $sub['dishes'] ?? [] ) as $dish_id ) {
                    $map[ (int) $dish_id ][ $slug ] = implode( ' · ', array_filter( [ $sec['label'], $sub['title_ru'] ?? '' ] ) );
                }
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
    // The photo first: the strip and the pickers print it, and a table shows at a glance which dishes have none yet.
    $out = [ 'cb' => $columns['cb'] ?? '', 'sp_photo' => 'Фото', 'title' => $columns['title'] ?? 'Название' ];
    return $out + $columns + [ 'sp_description' => 'Описание', 'sp_sizes' => 'Выход и цена', 'sp_section' => 'Раздел меню', 'date' => 'Дата' ];
}
foreach ( sweet_pepper_menu_item_types() as $sp_type ) {
    add_filter( "manage_{$sp_type}_posts_columns", 'sweet_pepper_dish_admin_columns' );
    add_action( "manage_{$sp_type}_posts_custom_column", 'sweet_pepper_dish_admin_column', 10, 2 );
}
unset( $sp_type );

function sweet_pepper_dish_admin_column( $column, $post_id ) {
    if ( 'sp_photo' === $column ) {
        echo has_post_thumbnail( $post_id ) ? get_the_post_thumbnail( $post_id, [ 60, 40 ] ) : '<span aria-hidden="true">—</span>';
    }
    if ( 'sp_description' === $column ) {
        echo esc_html( (string) get_field( 'description_ru', $post_id ) ?: '—' );
    }
    if ( 'sp_sizes' === $column ) {
        echo esc_html( sweet_pepper_dish_sizes_label( $post_id ) ?: '—' );
        echo sweet_pepper_dish_quick_data( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped there; Quick Edit starts from it (inc/dish-quick-edit.php)
    }
    if ( 'sp_section' === $column ) {
        $links = [];
        foreach ( sweet_pepper_dish_placements()[ $post_id ] ?? [] as $slug => $title ) {
            $page    = sweet_pepper_menu_page( sweet_pepper_menu_state_for( $slug ) );
            $links[] = sprintf( '<a href="%s">%s</a>', esc_url( $page ? get_edit_post_link( $page->ID ) : '' ), esc_html( $title ) );
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
    $current = isset( $_GET['sp_section'] ) ? sanitize_key( $_GET['sp_section'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification -- a list filter
    echo '<label class="screen-reader-text" for="sp-section">Раздел меню</label>';
    echo '<select name="sp_section" id="sp-section"><option value="">Все разделы</option>';
    foreach ( sweet_pepper_menu_sections( 'dish' === $post_type ? 'food' : 'drinks' ) as $slug => $sec ) {
        printf( '<option value="%s"%s>%s</option>', esc_attr( $slug ), selected( $current, $slug, false ), esc_html( $sec['label'] ) );
    }
    echo '<option value="none"' . selected( $current, 'none', false ) . '>— не в меню</option></select>';
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
    $section = isset( $_GET['sp_section'] ) ? sanitize_key( $_GET['sp_section'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification -- a list filter
    if ( 'none' === $section ) {
        $query->set( 'post__not_in', array_keys( sweet_pepper_dish_placements() ) );
    } elseif ( '' !== $section ) {
        $placed = array_keys( array_filter( sweet_pepper_dish_placements(), fn( $sections ) => isset( $sections[ $section ] ) ) );
        $query->set( 'post__in', $placed ?: [ 0 ] );
    }
}
add_action( 'pre_get_posts', 'sweet_pepper_dish_admin_order' );

// Two icons at most, as in the repeater store (inc/menu-data.php).
add_filter( 'acf/validate_value/key=field_sp_dish_dish_icons', 'sweet_pepper_menu_validate_icons', 10, 2 );

/**
 * The «Фото» field is the dish's photo; the post's featured image mirrors it on every save, so
 * the Relationship pickers' thumbnails, the tables and the seasonal strip all read
 * get_post_thumbnail_id() and never diverge from the form.
 */
function sweet_pepper_dish_sync_photo( $post_id ) {
    if ( ! in_array( get_post_type( $post_id ), sweet_pepper_menu_item_types(), true ) ) {
        return;
    }
    $photo = (int) get_field( 'photo', $post_id );
    if ( $photo ) {
        update_post_meta( $post_id, '_thumbnail_id', $photo );
    } else {
        delete_post_meta( $post_id, '_thumbnail_id' );
    }
}
add_action( 'acf/save_post', 'sweet_pepper_dish_sync_photo', 20 );
