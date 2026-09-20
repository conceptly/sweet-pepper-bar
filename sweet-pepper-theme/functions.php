<?php
/**
 * Sweet Pepper theme functions and definitions
 *
 * @package Sweet_Pepper
 */

if ( ! defined( 'SWEET_PEPPER_VERSION' ) ) {
    define( 'SWEET_PEPPER_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function sweet_pepper_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Register navigation menus.
    register_nav_menus(
        array(
            'primary' => esc_html__( 'Primary Menu', 'sweet-pepper' ),
            'footer'  => esc_html__( 'Footer Menu', 'sweet-pepper' ),
        )
    );

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );
}
add_action( 'after_setup_theme', 'sweet_pepper_setup' );

/**
 * Enqueue scripts and styles using Vite
 */
require_once get_template_directory() . '/inc/vite-enqueue.php';

/**
 * Bar hours: Bar Settings values with the fallback defaults (read by daypart-head, footer, Visit hero).
 */
require_once get_template_directory() . '/inc/bar-hours.php';

/**
 * Daypart: first-paint theme + the hour thresholds (inline, top of <head>).
 */
require_once get_template_directory() . '/inc/daypart-head.php';

/**
 * Intrinsic SVG dimensions (section connectors reserve their height)
 */
require_once get_template_directory() . '/inc/svg-dimensions.php';

/**
 * Inline SVGs with per-instance unique ids (clipPath/gradient collisions).
 */
require_once get_template_directory() . '/inc/inline-svg.php';

/**
 * Menu page section word lists (hero nav, jump-nav, mobile rail).
 */
require_once get_template_directory() . '/inc/menu-sections.php';

/**
 * Menu rows: the section records in admin → dish-row args (fallback: data/menu/).
 */
require_once get_template_directory() . '/inc/menu-data.php';

/**
 * Menu storage test: the dishes store (`dish` posts + `menu_list` records). Goes if the repeater wins.
 */
require_once get_template_directory() . '/inc/menu-data-dishes.php';

/**
 * Dish picker pairings — one list for the menu page and About.
 */
require_once get_template_directory() . '/inc/pairings.php';

/**
 * Custom Post Types
 */
require_once get_template_directory() . '/inc/cpt.php';

/**
 * Load ACF Configuration
 */
require_once get_template_directory() . '/inc/acf-setup.php';

/**
 * Disable the block editor (Gutenberg) for pages so only ACF fields show.
 * ACF experiment — remove to restore the block editor on pages.
 */
add_filter( 'use_block_editor_for_post_type', fn( $use, $type ) => $type === 'page' ? false : $use, 10, 2 );

// Also drop the classic content box so pages show only the title and ACF fields.
add_action( 'init', fn() => remove_post_type_support( 'page', 'editor' ) );

/**
 * Auto-create required pages if they don't exist.
 * Runs once on `init` — skips if the page already exists.
 */
function sweet_pepper_create_pages() {
    $pages = [
        'menu' => [
            'title'    => 'Menu',
            'template' => 'page-menu.php',
        ],
        'about' => [
            'title'    => 'About',
            'template' => 'page-about.php',
        ],
        'visit' => [
            'title'    => 'Visit',
            'template' => 'page-visit.php',
        ],
    ];

    foreach ( $pages as $slug => $page ) {
        $existing = get_page_by_path( $slug );
        if ( ! $existing ) {
            $page_id = wp_insert_post( [
                'post_title'   => $page['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ] );
            if ( $page_id && ! is_wp_error( $page_id ) ) {
                update_post_meta( $page_id, '_wp_page_template', $page['template'] );
            }
        }
    }
}
add_action( 'init', 'sweet_pepper_create_pages' );
