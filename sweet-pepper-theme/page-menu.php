<?php
/**
 * Template Name: Menu
 *
 * The kitchen menu page — «Меню — кухня», /menu/food/ under the «Меню» folder page
 * (page-menu-index.php). The bar is its own page, /menu/bar/ (page-menu-bar.php); both
 * render template-parts/menu-page.php. `?menu=drinks` here is a 301 to the bar page once
 * that page exists — and renders the bar until then (inc/menu-page.php).
 *
 * @package Sweet_Pepper
 */

get_header();

get_template_part( 'template-parts/menu-page', null, [ 'menu_state' => sweet_pepper_menu_state() ?: 'food' ] );

get_footer();
