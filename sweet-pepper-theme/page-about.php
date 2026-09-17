<?php
/**
 * Template Name: About
 *
 * The about page — a fixed composition (no daypart theming).
 * Dark and light sections alternate in a set order per website-brief.md.
 *
 * @package Sweet_Pepper
 */

get_header();
?>

<main id="primary" class="site-main page-about">

    <?php // 1. Hero — dark section (Peppercorn bg) ?>
    <?php get_template_part( 'template-parts/about/hero' ); ?>

    <?php // 2. The Concept — light section ?>
    <?php get_template_part( 'template-parts/about/concept' ); ?>

    <?php // 3. How It Feels — light section ?>
    <?php get_template_part( 'template-parts/about/how-it-feels' ); ?>

    <?php // 4. Beyond Shake & Cook — dark section ?>
    <?php get_template_part( 'template-parts/about/perks' ); ?>

    <?php // 5. The Pepper Story — light section ?>
    <?php get_template_part( 'template-parts/about/story' ); ?>

    <?php // 6. The Dream Guests — dark section ?>
    <?php get_template_part( 'template-parts/about/guests' ); ?>

    <?php // 7. The Dream Team — dark section ?>
    <?php get_template_part( 'template-parts/about/team' ); ?>

    <?php // 8. Careers — dark section ?>
    <?php get_template_part( 'template-parts/about/careers' ); ?>

    <?php // 9. Location — light section ?>
    <?php get_template_part( 'template-parts/about/location' ); ?>

    <?php // 10. Entrance photo — full-width image ?>
    <?php get_template_part( 'template-parts/about/entrance' ); ?>

    <?php // 11. Visit CTA — dark section ?>
    <?php get_template_part( 'template-parts/about/visit-cta' ); ?>

</main>

<?php
get_footer();
