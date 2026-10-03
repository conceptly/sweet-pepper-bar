<?php
/**
 * Template Name: Privacy policy
 *
 * The privacy policy — /privacy-policy/ (inc/privacy.php; fields acf-json/group_sp_privacy.json).
 * Also the consent to personal data processing, /consent/ (29 Sep 2026): the same fields and
 * layout, a second page on this template (inc/forms.php links the forms to it).
 *
 * A document to read, so it follows the day / night theme like Home and Menu rather than
 * a fixed dark composition: a head (eyebrow · the title as the site's section headline ·
 * the version date), then the text in the copy measure (7 of 12 columns) with the contents
 * list sticky in the first three; tablets and phones put the list above the text.
 * Since 3 Oct 2026 the headline is a short name (data/documents.php → headlines) over the full
 * legal title, which is the <h1> — the long titles ran four Molot lines at 64.
 *
 * @package Sweet_Pepper
 */

$policy = sweet_pepper_privacy( get_queried_object_id() );
get_header();
?>

<main id="primary" class="site-main page-privacy">

    <section class="privacy-head">
        <div class="container privacy-head__inner">
            <?php $hub_url = sweet_pepper_documents_url(); // the eyebrow leads back to the hub once it is published (author, 3 Oct 2026) ?>
            <p class="section-eyebrow molot-text"><?php if ( $hub_url ) : ?><a class="privacy-head__back" href="<?php echo esc_url( $hub_url ); ?>"><span class="privacy-head__back-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span><?php endif; ?><?php echo esc_html_x( 'Documents', 'the privacy page eyebrow', 'sweet-pepper' ); ?><?php if ( $hub_url ) : ?></a><?php endif; ?></p>
            <?php if ( $policy['short'] ) : // the short name is the display line; the full legal title stays the <h1> (author, 3 Oct 2026) ?>
                <p class="section-headline privacy-head__title molot-text" aria-hidden="true"><?php echo esc_html( $policy['short'] ); ?></p>
                <h1 class="privacy-head__full"><?php echo esc_html( $policy['full'] ); ?></h1>
            <?php else : ?>
                <h1 class="section-headline privacy-head__title molot-text"><?php echo esc_html( $policy['title'] ); ?></h1>
            <?php endif; ?>
            <?php if ( $policy['updated'] ) : ?>
                <p class="privacy-head__meta"><?php echo esc_html( sprintf( __( 'Version of %s', 'sweet-pepper' ), $policy['updated'] ) ); ?></p>
            <?php endif; ?>
            <?php if ( $policy['fallback'] ) : ?>
                <p class="privacy-head__note" lang="en"><?php esc_html_e( 'This document is published in Russian, and the Russian text is the binding one. An English translation will follow.', 'sweet-pepper' ); ?></p>
            <?php endif; ?>
        </div>
    </section>

    <section class="privacy-body">
        <div class="container privacy-body__grid">
            <?php if ( count( $policy['toc'] ) > 1 ) : ?>
                <nav class="privacy-toc" aria-label="<?php echo esc_attr_x( 'Contents', 'the privacy page contents list', 'sweet-pepper' ); ?>">
                    <p class="privacy-toc__title"><?php echo esc_html_x( 'Contents', 'the privacy page contents list', 'sweet-pepper' ); ?></p>
                    <ol class="privacy-toc__list">
                        <?php foreach ( $policy['toc'] as $item ) : ?>
                            <li><a href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a></li>
                        <?php endforeach; ?>
                    </ol>
                </nav>
            <?php endif; ?>

            <div class="privacy-doc"<?php echo $policy['fallback'] ? ' lang="ru"' : ''; ?>>
                <?php echo wp_kses_post( $policy['body'] ); ?>
            </div>
        </div>
    </section>

</main>

<?php
get_footer();
