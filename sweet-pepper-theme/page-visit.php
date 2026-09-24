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
$visit_id = get_queried_object_id(); // the page's fields → each part's args (inc/visit-data.php)
?>

<main id="primary" class="site-main page-visit">

    <?php // 1. Hero — dark section (Peppercorn bg): status band + hours card + contact card ?>
    <?php get_template_part( 'template-parts/visit/hero', null, [
        'hero'     => sweet_pepper_visit_hero( $visit_id ),
        'status'   => sweet_pepper_visit_status( $visit_id ),
        'hours'    => sweet_pepper_visit_hours( $visit_id ),
        'contacts' => sweet_pepper_visit_contacts( $visit_id ),
    ] ); ?>

    <?php // 2. Location — light section (Parchment bg): map + directions ?>
    <?php get_template_part( 'template-parts/visit/location', null, sweet_pepper_visit_location( $visit_id ) ); ?>

    <?php // 3. Visit CTA — dark section (Peppercorn bg): "We're All Ears" + form ?>
    <?php get_template_part( 'template-parts/visit/cta', null, sweet_pepper_visit_cta( $visit_id ) ); ?>

</main>

<?php
get_footer();
