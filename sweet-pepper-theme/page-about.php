<?php
/**
 * Template Name: About
 *
 * The about page — a fixed composition (no daypart theming).
 * Dark and light sections alternate in a set order per website-brief.md.
 *
 * @package Sweet_Pepper
 */

$about_id = get_queried_object_id(); // the page's fields → each part's args (inc/about-data.php)
get_header();
?>

<main id="primary" class="site-main page-about">

    <?php // 1. Hero — dark section (Peppercorn bg) ?>
    <?php get_template_part( 'template-parts/about/hero', null, sweet_pepper_about_hero( $about_id ) ); ?>

    <?php // 2. The Concept — light section ?>
    <?php get_template_part( 'template-parts/about/concept', null, sweet_pepper_about_concept( $about_id ) ); ?>

    <?php // 3. How It Feels — light section ?>
    <?php get_template_part( 'template-parts/about/how-it-feels', null, sweet_pepper_about_reviews( $about_id ) ); ?>

    <?php // 4. Beyond Shake & Cook — dark section ?>
    <?php get_template_part( 'template-parts/about/perks', null, sweet_pepper_about_perks( $about_id ) ); ?>

    <?php // 5. The Pepper Story — light section ?>
    <?php get_template_part( 'template-parts/about/story', null, sweet_pepper_about_story( $about_id ) ); ?>

    <?php // 6. The Dream Guests — dark section ?>
    <?php get_template_part( 'template-parts/about/guests', null, sweet_pepper_about_guests( $about_id ) ); ?>

    <?php // 7. The Dream Team — dark section ?>
    <?php get_template_part( 'template-parts/about/team', null, sweet_pepper_about_team( $about_id ) ); ?>

    <?php // 8. Careers — dark section ?>
    <?php get_template_part( 'template-parts/about/careers', null, sweet_pepper_about_careers( $about_id ) ); ?>

    <?php // 9. Location — light section ?>
    <?php get_template_part( 'template-parts/about/location', null, sweet_pepper_about_location( $about_id ) ); ?>

    <?php // 10. Entrance photo — full-width image ?>
    <?php get_template_part( 'template-parts/about/entrance' ); ?>

    <?php // 11. Visit CTA — dark section ?>
    <?php get_template_part( 'template-parts/about/visit-cta', null, sweet_pepper_about_cta( $about_id ) ); ?>

</main>

<?php
get_footer();
