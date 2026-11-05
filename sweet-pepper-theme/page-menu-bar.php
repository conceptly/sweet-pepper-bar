<?php
/**
 * Template Name: Menu — Bar
 *
 * The bar menu page (/menu/bar/) — the drinks state of the menu. The state IS the
 * template (inc/menu-page.php): this file and page-menu.php share one body,
 * template-parts/menu-page.php, and differ only in the state they hand it.
 *
 * @package Sweet_Pepper
 */

get_header();

get_template_part( 'template-parts/menu-page', null, [ 'menu_state' => 'drinks' ] );

get_footer();
