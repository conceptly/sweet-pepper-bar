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
}
add_action( 'init', 'sweet_pepper_register_cpt', 0 );

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
