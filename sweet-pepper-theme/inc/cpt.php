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
    // A dish is placed on the page by its section's tab on the menu page (inc/menu-data-dishes.php);
    // Draft takes it off the site. Never a public URL — the menu page renders it.
    // Its PHOTO is the post's featured image (3:2, the `sp-3x2` crop — inc/images.php): the
    // Highlights strip prints it (inc/menu-page.php); the pickers and previews will.
    $dish_type = function ( $labels, $position, $icon ) {
        $photo = 'Напиток' === $labels['singular_name'] ? 'напитка' : 'блюда';
        return array(
            'label'         => $labels['singular_name'],
            'labels'        => $labels + array(
                'featured_image'        => "Фото {$photo}",
                'set_featured_image'    => 'Выбрать фото',
                'remove_featured_image' => 'Убрать фото',
                'use_featured_image'    => 'Сделать фото ' . $photo,
            ),
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

    // 3. Pairings — ONE record («Гастробот»; «Подбор пары» until 23 Sep 2026 — a team member's name for it): the dish picker's rows, for the menu page's
    // pairing station and the About page's Concept picker at once (inc/pairings.php,
    // acf-json/group_sp_pairings.json). A post for the same reasons as a menu list:
    // revisions, the edit lock, the cache purge on save. Never a public URL.
    register_post_type( 'pairings', array(
        'label'        => 'Гастробот',
        'labels'       => array( 'name' => 'Гастробот', 'singular_name' => 'Гастробот', 'menu_name' => 'Гастробот', 'edit_item' => 'Гастробот', 'all_items' => 'Гастробот' ),
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

    // (4. «Разделы меню» — `menu_list`, one record per section holding its subsections and
    // words — was retired on 24 Sep 2026: the sections live as tabs on the two menu pages,
    // inc/menu-page.php. The old records stay in the database, unregistered, until the author
    // deletes them; tools/page-seed.php menu read them once into the pages.)
}
add_action( 'init', 'sweet_pepper_register_cpt', 0 );
