<?php
/**
 * The front page template — the home page, one part per section in page order.
 *
 * The words and the team-replaceable photos come from the front page's fields
 * (acf-json/group_sp_home.json → inc/home-data.php; typed fallback data/home/) — one tab per
 * section, the About page's shape. The composition, the daypart engine, the connectors and
 * the contact channels are the parts' own.
 *
 * @package Sweet_Pepper
 */

$home_id = sweet_pepper_home_id(); // the front page's fields → each part's args (inc/home-data.php)
get_header();
?>

<main id="primary" class="site-main">

    <?php // 1. Hero — the daypart tile grid ?>
    <?php get_template_part( 'template-parts/home/hero', null, sweet_pepper_home_hero( $home_id ) ); ?>

    <?php // 2. Highlights — three cards into the menu ?>
    <?php get_template_part( 'template-parts/home/highlights', null, sweet_pepper_home_highlights( $home_id ) ); ?>

    <?php // 3. Bar preview — House infusions ?>
    <?php get_template_part( 'template-parts/home/bar-preview', null, sweet_pepper_home_preview( $home_id, 'bar' ) ); ?>

    <?php // 4. Kitchen preview — Your lunch sorted ?>
    <?php get_template_part( 'template-parts/home/kitchen-preview', null, sweet_pepper_home_preview( $home_id, 'kitchen' ) ); ?>

    <?php // 5. About preview ?>
    <?php get_template_part( 'template-parts/home/about-preview', null, sweet_pepper_home_about( $home_id ) ); ?>

    <?php // 6. What's on — the social entrance ?>
    <?php get_template_part( 'template-parts/home/events', null, sweet_pepper_home_events( $home_id ) ); ?>

    <?php // 7. Contacts ?>
    <?php get_template_part( 'template-parts/home/contacts', null, sweet_pepper_home_contacts( $home_id ) ); ?>

</main>

<?php
get_footer();
