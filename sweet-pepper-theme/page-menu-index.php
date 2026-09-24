<?php
/**
 * Template Name: Menu — Index
 *
 * The «Меню» page at /menu/ — the folder that holds the two menu pages, «Меню — кухня»
 * (/menu/food/, page-menu.php) and «Меню — бар» (/menu/bar/, page-menu-bar.php). It has
 * no content of its own: inc/menu-page.php sends it to the kitchen with a 301, or to the
 * bar for the old `?menu=drinks`. WordPress needs the parent for the child URLs; the team
 * sees the two menus under one folder in admin (author, 24 Sep 2026).
 *
 * Reached only if the redirect did not run (a page cache serving a stale copy): print the
 * kitchen menu rather than a blank page.
 *
 * @package Sweet_Pepper
 */

get_header();

get_template_part( 'template-parts/menu-page', null, [ 'menu_state' => 'food' ] );

get_footer();
