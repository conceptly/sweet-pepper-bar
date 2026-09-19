<?php
/**
 * Register Custom Post Types and Taxonomies
 *
 * @package Sweet_Pepper
 */

function sweet_pepper_register_cpt() {
    // 1. Dish CPT
    $labels_dish = array(
        'name'                  => _x( 'Dishes', 'Post Type General Name', 'sweet-pepper' ),
        'singular_name'         => _x( 'Dish', 'Post Type Singular Name', 'sweet-pepper' ),
        'menu_name'             => __( 'Dishes', 'sweet-pepper' ),
        'all_items'             => __( 'All Dishes', 'sweet-pepper' ),
        'add_new_item'          => __( 'Add New Dish', 'sweet-pepper' ),
        'add_new'               => __( 'Add New', 'sweet-pepper' ),
        'edit_item'             => __( 'Edit Dish', 'sweet-pepper' ),
    );
    $args_dish = array(
        'label'                 => __( 'Dish', 'sweet-pepper' ),
        'labels'                => $labels_dish,
        'supports'              => array( 'title', 'thumbnail' ), // Name and Photo
        'taxonomies'            => array( 'dish_category', 'dietary_tag' ),
        'public'                => true,
        'has_archive'           => true,
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
        'menu_name'             => 'Меню',
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
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-book-alt',
        'show_in_rest'          => false,
        'map_meta_cap'          => true,
        // The list of sections is structure: the team edits them, only an admin adds one.
        'capabilities'          => array( 'create_posts' => 'manage_options' ),
    );
    register_post_type( 'menu_section', $args_section );
}
add_action( 'init', 'sweet_pepper_register_cpt', 0 );

/**
 * List menu sections in menu order (Breakfast … Spirits), not by date.
 */
function sweet_pepper_menu_section_admin_order( $query ) {
    if ( is_admin() && $query->is_main_query() && 'menu_section' === $query->get( 'post_type' ) && ! $query->get( 'orderby' ) ) {
        $query->set( 'orderby', 'menu_order' );
        $query->set( 'order', 'ASC' );
    }
}
add_action( 'pre_get_posts', 'sweet_pepper_menu_section_admin_order' );

function sweet_pepper_register_taxonomies() {
    // 1. Dish Category
    $labels_cat = array(
        'name'              => _x( 'Dish Categories', 'taxonomy general name', 'sweet-pepper' ),
        'singular_name'     => _x( 'Dish Category', 'taxonomy singular name', 'sweet-pepper' ),
        'menu_name'         => __( 'Categories', 'sweet-pepper' ),
    );
    $args_cat = array(
        'hierarchical'      => true,
        'labels'            => $labels_cat,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
    );
    register_taxonomy( 'dish_category', array( 'dish' ), $args_cat );

    // 2. Dietary Tags
    $labels_tag = array(
        'name'              => _x( 'Dietary Tags', 'taxonomy general name', 'sweet-pepper' ),
        'singular_name'     => _x( 'Dietary Tag', 'taxonomy singular name', 'sweet-pepper' ),
        'menu_name'         => __( 'Dietary Tags', 'sweet-pepper' ),
    );
    $args_tag = array(
        'hierarchical'      => false,
        'labels'            => $labels_tag,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
    );
    register_taxonomy( 'dietary_tag', array( 'dish' ), $args_tag );
}
add_action( 'init', 'sweet_pepper_register_taxonomies', 0 );
