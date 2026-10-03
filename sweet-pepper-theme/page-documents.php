<?php
/**
 * Template Name: Documents
 *
 * The documents hub — /documents/ (inc/documents.php; words data/documents.php; built 3 Oct
 * 2026 from the contact sheet's B + C, author). Follows the day / night theme like the legal
 * pages it points at: the privacy page's head, then the short version (three lines, each
 * ending in its document), the cards (one per published legal page, the card recipe) and the
 * privacy settings.
 *
 * @package Sweet_Pepper
 */

$hub   = sweet_pepper_documents();
$words = $hub['words'];
get_header();
?>

<main id="primary" class="site-main page-privacy page-documents">

    <section class="privacy-head">
        <div class="container privacy-head__inner">
            <p class="section-eyebrow molot-text"><?php echo esc_html( $words['eyebrow'] ); ?></p>
            <h1 class="section-headline privacy-head__title molot-text"><?php echo esc_html( $words['title'] ); ?></h1>
            <p class="documents-lead"><?php echo esc_html( $words['show_lines'] ? $words['lead'] : $words['lead_cards'] ); ?></p>
        </div>
    </section>

    <section class="documents-body">
        <div class="container">

            <?php if ( $words['show_lines'] ) : // off for now (author, 3 Oct 2026): data/documents.php ?>
            <ul class="documents-lines">
                <?php foreach ( $hub['lines'] as $line ) : ?>
                    <li class="documents-line">
                        <span class="documents-line__icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/' . $line['icon'] ); ?></span>
                        <div class="documents-line__copy">
                            <h2 class="documents-line__title"><?php echo esc_html( $line['title'] ); ?></h2>
                            <p class="documents-line__text"><?php echo esc_html( $line['text'] ); ?><?php if ( $line['url'] ) : ?> <a href="<?php echo esc_url( $line['url'] ); ?>"><?php echo esc_html( $line['link'] ); ?></a><?php endif; ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <?php if ( $hub['cards'] ) : ?>
                <?php if ( $words['show_lines'] ) : // the heading parts the cards from the lines; alone, the page title says it ?>
                    <h2 class="documents-full privacy-toc__title"><?php echo esc_html( $words['full'] ); ?></h2>
                <?php endif; ?>
                <ul class="documents-cards<?php echo sweet_pepper_documents_tone(); ?>">
                    <?php foreach ( $hub['cards'] as $card ) : ?>
                        <li>
                            <a class="documents-card" href="<?php echo esc_url( $card['url'] ); ?>">
                                <span class="documents-card__kind molot-text"><?php echo esc_html( $card['kind'] ); ?></span>
                                <span class="documents-card__name molot-text"><?php echo esc_html( $card['name'] ); ?></span>
                                <span class="documents-card__text"><?php echo esc_html( $card['text'] ); ?></span>
                                <span class="documents-card__foot">
                                    <span class="documents-card__date"><?php echo $card['updated'] ? esc_html( sprintf( $words['version'], $card['updated'] ) ) : ''; ?></span>
                                    <span class="documents-card__arrow"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); // the links' outline arrow (author, 3 Oct 2026) ?></span>
                                </span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="documents-settings">
                <p><?php echo esc_html( $words['settings'] ); ?></p>
                <?php // Shown by privacy-preferences.js, as the footer's link: without the script it opens nothing ?>
                <button type="button" class="btn btn-secondary" data-privacy-settings hidden><?php echo esc_html( $words['button'] ); ?></button>
            </div>

        </div>
    </section>

</main>

<?php
get_footer();
