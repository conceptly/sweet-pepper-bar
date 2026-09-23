<?php
/**
 * Register Custom Post Types
 *
 * @package Sweet_Pepper
 */

function sweet_pepper_register_cpt() {
    // 1. Dishes and drinks — the menu store (website-brief.md → Content editing → Menu storage,
    // decided 23 Sep 2026): one post per dish, title = the Russian name, fields in
    // acf-json/group_sp_dish.json (one group for both types). Two types, not one with a
    // filter, so the kitchen and the bar each get their own list in the sidebar — «Блюда»
    // and «Напитки» (author, after the team test) — and a picker can ask for one or the other.
    // A dish is placed on the page by its section's `menu_list` record (4, below);
    // Draft takes it off the site. Never a public URL — the menu page renders it.
    $dish_type = function ( $labels, $position, $icon ) {
        return array(
            'label'         => $labels['singular_name'],
            'labels'        => $labels,
            'supports'      => array( 'title', 'thumbnail', 'revisions' ), // Name and Photo
            'public'        => false,
            'show_ui'       => true,
            'menu_position' => $position, // own slots: a taken one (Posts is 5) gets bumped past its neighbours
            'menu_icon'     => $icon,
            'show_in_rest'  => false, // Using classic theme, not relying on Gutenberg
        );
    };
    register_post_type( 'dish', $dish_type( array(
        'name'          => 'Блюда',
        'singular_name' => 'Блюдо',
        'menu_name'     => 'Блюда',
        'all_items'     => 'Все блюда',
        'add_new'       => 'Добавить блюдо',
        'add_new_item'  => 'Новое блюдо',
        'edit_item'     => 'Блюдо',
        'search_items'  => 'Найти блюдо',
        'not_found'     => 'Блюд нет',
    ), 6, 'dashicons-food' ) );
    register_post_type( 'drink', $dish_type( array(
        'name'          => 'Напитки',
        'singular_name' => 'Напиток',
        'menu_name'     => 'Напитки',
        'all_items'     => 'Все напитки',
        'add_new'       => 'Добавить напиток',
        'add_new_item'  => 'Новый напиток',
        'edit_item'     => 'Напиток',
        'search_items'  => 'Найти напиток',
        'not_found'     => 'Напитков нет',
    ), 7, 'dashicons-coffee' ) );

    // 2. News CPT (Phase 2)
    $labels_news = array(
        'name'                  => _x( 'News', 'Post Type General Name', 'sweet-pepper' ),
        'singular_name'         => _x( 'News Item', 'Post Type Singular Name', 'sweet-pepper' ),
        'menu_name'             => __( 'News', 'sweet-pepper' ),
        'all_items'             => __( 'All News', 'sweet-pepper' ),
        'add_new_item'          => __( 'Add New News Item', 'sweet-pepper' ),
    );
    $args_news = array(
        'label'                 => __( 'News Item', 'sweet-pepper' ),
        'labels'                => $labels_news,
        'supports'              => array( 'title', 'thumbnail' ), // Photo and caption (ACF)
        'public'                => true,
        'has_archive'           => true,
        'menu_icon'             => 'dashicons-megaphone',
        'show_in_rest'          => false,
    );
    register_post_type( 'news', $args_news );

    // 3. Pairings — ONE record («Подбор пары»): the dish picker's rows, for the menu page's
    // pairing station and the About page's Concept picker at once (inc/pairings.php,
    // acf-json/group_sp_pairings.json). A post for the same reasons as a menu list:
    // revisions, the edit lock, the cache purge on save. Never a public URL.
    register_post_type( 'pairings', array(
        'label'        => 'Подбор пары',
        'labels'       => array( 'name' => 'Подбор пары', 'singular_name' => 'Подбор пары', 'menu_name' => 'Подбор пары', 'edit_item' => 'Подбор пары', 'all_items' => 'Подбор пары' ),
        'supports'     => array( 'title', 'revisions' ),
        'public'       => false,
        'show_ui'      => true,
        'menu_position' => 9,
        'menu_icon'    => 'dashicons-randomize',
        'show_in_rest' => false,
        'map_meta_cap' => true,
        // One record, made by the seeder: the team edits it, nobody adds a second.
        'capabilities' => array( 'create_posts' => 'do_not_allow' ),
    ) );

    // 4. Menu sections — one `menu_list` record per section of the menu page (Soups,
    // Cocktails, …), slug = the section slug: its subsections → ordered Relationship lists of
    // dishes or drinks (acf-json/group_sp_menu_list.json, read by inc/menu-data-dishes.php).
    // A post rather than an options page for what a post brings: revisions, the "someone is
    // editing" lock, and a cache purge on save. The type keeps its test-era name `menu_list`
    // (renaming it would move the saved records); only the labels changed.
    register_post_type( 'menu_list', array(
        'label'         => 'Раздел меню',
        'labels'        => array(
            'name'          => 'Разделы меню',
            'singular_name' => 'Раздел меню',
            'menu_name'     => 'Разделы меню',
            'all_items'     => 'Все разделы',
            'add_new'       => 'Добавить раздел',
            'add_new_item'  => 'Новый раздел меню',
            'edit_item'     => 'Раздел меню',
            'search_items'  => 'Найти раздел',
            'not_found'     => 'Разделов нет',
        ),
        'supports'      => array( 'title', 'revisions' ),
        'public'        => false,
        'show_ui'       => true,
        'menu_position' => 8,
        'menu_icon'     => 'dashicons-book-alt',
        'show_in_rest'  => false,
        'map_meta_cap'  => true,
        // The list of sections is structure: the team edits them, only an admin adds one.
        'capabilities'  => array( 'create_posts' => 'manage_options' ),
    ) );
}
add_action( 'init', 'sweet_pepper_register_cpt', 0 );

/**
 * List menu sections in menu order (Breakfast … Spirits), not by date.
 */
function sweet_pepper_menu_section_admin_order( $query ) {
    if ( is_admin() && $query->is_main_query() && 'menu_list' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'sweet_pepper_menu_section_admin_order' );
