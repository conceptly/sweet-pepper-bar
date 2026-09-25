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
    // Its PHOTO is the «Фото» field at the top of its form (group_sp_dish.json), copied into
    // the post's featured image on save (inc/menu-data-dishes.php) so the pickers' thumbnails
    // and the seasonal strip read one thing. No featured-image box: the team looked for the
    // photo in the form and not in the sidebar (author, 24 Sep 2026).
    $dish_type = function ( $labels, $position, $icon ) {
        return array(
            'label'         => $labels['singular_name'],
            'labels'        => $labels,
            'supports'      => array( 'title', 'revisions' ), // the name; everything else is a field
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

    // 2. «Посты ВКонтакте» — one record per post imported from the community wall
    // (inc/vk-feed.php): the Russian home page's «Что нового» cards. Made by the importer,
    // never by hand; the team can hide one («Скрыть с сайта», acf-json/group_sp_news.json) or
    // retype its caption. Draft is the importer's own state for a post that left the wall.
    // Never a public URL — the card links to the post on VK. (The `news` slug is the old
    // Phase-2 News CPT's; the records stay in that table.)
    register_post_type( 'news', array(
        'label'         => 'Пост ВКонтакте',
        'labels'        => array(
            'name'          => 'Посты ВКонтакте',
            'singular_name' => 'Пост ВКонтакте',
            'menu_name'     => 'Посты ВКонтакте',
            'all_items'     => 'Все посты',
            'edit_item'     => 'Пост ВКонтакте',
            'search_items'  => 'Найти пост',
            'not_found'     => 'Постов нет — импорт ещё не запускался',
        ),
        'supports'      => array( 'title', 'thumbnail' ), // the caption; the cover is the featured image
        'public'        => false,
        'show_ui'       => true,
        'menu_position' => 8,
        'menu_icon'     => 'dashicons-megaphone',
        'show_in_rest'  => false,
        'map_meta_cap'  => true,
        // Records come from the importer: the team edits them, nobody adds one by hand.
        'capabilities'  => array( 'create_posts' => 'do_not_allow' ),
    ) );

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
