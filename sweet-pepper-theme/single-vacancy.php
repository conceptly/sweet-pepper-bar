<?php
/**
 * A job opening — /vacancies/<slug>/ (inc/vacancies.php; the record's fields in
 * acf-json/group_sp_vacancy.json).
 *
 * A fixed composition, like About and Visit: Peppercorn head → Soft Peppercorn body
 * (the copy in 7 of 12 columns, the contact card sticky in the last 4) → Peppercorn foot
 * (the other open roles, the CV row) → the Lime footer. No daypart theming.
 *
 * Open: head · body · foot, and on phones a contact bar pinned to the bottom.
 * Closed: head (with the "filled" line) · foot — the URL outlives the term
 * (website-brief.md → Content editing → *Vacancies*).
 *
 * @package Sweet_Pepper
 */

$vacancy_id = get_queried_object_id();
$vacancy    = sweet_pepper_vacancy( $vacancy_id );
$about      = get_page_by_path( 'about' );
$careers    = sweet_pepper_about_careers( $about ? $about->ID : 0 ); // the eyebrow and the CV row are the About page's words
get_header();
?>

<main id="primary" class="site-main page-vacancy<?php echo $vacancy['open'] ? ' page-vacancy--open' : ' page-vacancy--closed'; ?>">

    <?php get_template_part( 'template-parts/vacancy/head', null, [ 'vacancy' => $vacancy, 'eyebrow' => $careers['eyebrow'] ] ); ?>

    <?php if ( $vacancy['open'] ) : ?>
        <?php get_template_part( 'template-parts/vacancy/body', null, [ 'vacancy' => $vacancy ] ); ?>
    <?php endif; ?>

    <?php get_template_part( 'template-parts/vacancy/foot', null, [ 'vacancy' => $vacancy, 'careers' => $careers ] ); ?>

    <?php if ( $vacancy['open'] ) : ?>
        <?php get_template_part( 'template-parts/vacancy/phone-bar', null, [ 'vacancy' => $vacancy ] ); ?>
    <?php endif; ?>

</main>

<?php
get_footer();
