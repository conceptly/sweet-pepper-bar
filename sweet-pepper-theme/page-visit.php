<?php
/**
 * Template Name: Visit
 *
 * The Visit page — a fixed composition (dark · light · dark).
 * No daypart theming. Sections don't swap between day/night.
 *
 * @package Sweet_Pepper
 */

get_header();
?>

<main id="primary" class="site-main page-visit">

    <?php // 1. Hero — dark section (Peppercorn bg): status band + hours card + contact card ?>
    <?php get_template_part( 'template-parts/visit/hero' ); ?>

    <?php // 2. Location — light section (Parchment bg): map + directions ?>
    <?php get_template_part( 'template-parts/visit/location' ); ?>

    <?php // 3. Visit CTA — dark section (Peppercorn bg): "We're All Ears" + form ?>
    <?php get_template_part( 'template-parts/visit/cta' ); ?>

</main>

<?php
get_footer();
