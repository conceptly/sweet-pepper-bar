<?php
/**
 * Register Custom Post Types
 *
 * @package Sweet_Pepper
 */

function sweet_pepper_register_cpt() {
    // 1. Dishes — the dishes store under test on Soups (website-brief.md → Menu storage):
    // one post per dish, title = the Russian name, fields in acf-json/group_sp_dish.json.
    // A dish is placed on the page by its section's `menu_list` record (4, below);
    // Draft takes it off the site. Never a public URL — the menu page renders it.
    // Removed, with `menu_list` and inc/menu-data-dishes.php, if the repeater store wins.
    $labels_dish = array(
        'name'                  => 'Блюда',
        'singular_name'         => 'Блюдо',
        'menu_name'             => 'Б - Блюда', // А / Б: the Menu storage test's sidebar labels (author, 20 Sep 2026)
        'all_items'             => 'Все блюда',
        'add_new'               => 'Добавить блюдо',
        'add_new_item'          => 'Новое блюдо',
        'edit_item'             => 'Блюдо',
        'search_items'          => 'Найти блюдо',
        'not_found'             => 'Блюд нет',
    );
    $args_dish = array(
        'label'                 => 'Блюдо',
        'labels'                => $labels_dish,
        'supports'              => array( 'title', 'thumbnail', 'revisions' ), // Name and Photo
        'public'                => false,
        'show_ui'               => true,
        'menu_position'         => 7, // А 6 · Б 7, 8 — own slots: a taken one (Posts is 5) gets bumped past its neighbours
        'menu_icon'             => 'dashicons-food',
        'show_in_rest'          => false, // Using classic theme, not relying on Gutenberg
    );
    register_post_type( 'dish', $args_dish );

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

    // 3. Menu sections — one record per section of the menu page (Soups, Cocktails, …),
    // holding that section's dishes in an SCF repeater (inc/menu-data.php). A post rather
    // than an options page for what a post brings: revisions, the "someone is editing"
    // lock, and a cache purge on save. Never a public URL — the menu page renders them.
    // Labels are typed in Russian, like the field labels (website-brief.md → Content editing).
    $labels_section = array(
        'name'                  => 'Разделы меню',
        'singular_name'         => 'Раздел меню',
        'menu_name'             => 'А - Меню Все в одном', // plain «Меню» again once the test is decided
        'all_items'             => 'Все разделы',
        'add_new'               => 'Добавить раздел',
        'add_new_item'          => 'Новый раздел меню',
        'edit_item'             => 'Раздел меню',
        'search_items'          => 'Найти раздел',
        'not_found'             => 'Разделов нет',
    );
    $args_section = array(
        'label'                 => 'Раздел меню',
        'labels'                => $labels_section,
        'supports'              => array( 'title', 'revisions' ),
        'public'                => false,
        'show_ui'               => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-book-alt',
        'show_in_rest'          => false,
        'map_meta_cap'          => true,
        // The list of sections is structure: the team edits them, only an admin adds one.
        'capabilities'          => array( 'create_posts' => 'manage_options' ),
    );
    register_post_type( 'menu_section', $args_section );

    // 4. Menu lists — the dishes store's twin of `menu_section`: one record per section,
    // holding subsections → ordered Relationship lists of `dish` posts
    // (acf-json/group_sp_menu_list.json, read by inc/menu-data-dishes.php).
    $labels_list = array(
        'name'                  => 'Б - Меню Макет',
        'menu_name'             => 'Б - Меню Макет',
    ) + $labels_section;
    // 5. Pairings — ONE record («Подбор пары»): the dish picker's rows, for the menu page's
    // pairing station and the About page's Concept picker at once (inc/pairings.php,
    // acf-json/group_sp_pairings.json). A post for the same reasons as a menu section:
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

    register_post_type( 'menu_list', array(
        'label'                 => 'Б - Меню Макет',
        'labels'                => $labels_list,
        'menu_position'         => 8,
    ) + $args_section );
}
add_action( 'init', 'sweet_pepper_register_cpt', 0 );

/**
 * List menu sections in menu order (Breakfast … Spirits), not by date.
 */
function sweet_pepper_menu_section_admin_order( $query ) {
    if ( is_admin() && $query->is_main_query() && in_array( $query->get( 'post_type' ), array( 'menu_section', 'menu_list' ), true ) && ! $query->get( 'orderby' ) ) {
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'sweet_pepper_menu_section_admin_order' );
