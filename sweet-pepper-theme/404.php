<?php
/**
 * The 404 page — PROTOTYPE, 1 Oct 2026: three layouts on trial, `?nf=0|a|b|bt`
 * (inc/not-found.php; words: data/not-found.php; styles: src/css/not-found.css).
 * Always dark. Figma: "Lost in the Sauce-404" 2803:78133, digits lettersSize 2807:77957.
 *
 * @package Sweet_Pepper
 */

$nf = sweet_pepper_not_found();
get_header();
?>

<main id="primary" class="site-main not-found not-found--<?php echo esc_attr( $nf['pick'] ); ?>">
    <section class="not-found__theater">
        <div class="container not-found__inner">

            <div class="not-found__copy">
                <?php // Layout 0: the number opens the page and the notice line sits under it (author, 1 Oct 2026 — above it, the line argued with the top nav) ?>
                <?php if ( 'pop' === $nf['digits'] ) : ?>
                    <?php get_template_part( 'template-parts/not-found/digits', null, [ 'mode' => 'pop' ] ); ?>
                <?php endif; ?>

                <p class="not-found__eyebrow molot-text"><span class="not-found__dot" aria-hidden="true"></span><?php echo esc_html( $nf['copy']['eyebrow'] ); ?></p>

                <h1 class="not-found__headline molot-text"><?php echo esc_html( $nf['copy']['headline'] ); ?></h1>
                <p class="not-found__body"><?php echo esc_html( $nf['copy']['body'] ); ?></p>

                <div class="not-found__actions">
                    <?php foreach ( $nf['actions'] as $i => $action ) : ?>
                        <?php
                        get_template_part( 'template-parts/components/button', null, [
                            'label'          => $action['label'],
                            'url'            => $action['url'],
                            'type'           => 0 === $i ? 'primary-green' : 'secondary',
                            'class'          => $action['back'] ? 'not-found__back' : '',
                            // one arrow glyph: the way back shows it mirrored (not-found.css)
                            'icon_left_svg'  => $action['back'] ? 'icons/c-arrow-right-outline.svg' : '',
                            'icon_right_svg' => $action['back'] ? '' : 'icons/c-arrow-right-outline.svg',
                        ] );
                        ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <?php if ( $nf['has_ticket'] ) : ?>
                <?php get_template_part( 'template-parts/not-found/ticket', null, [ 'ticket' => $nf['ticket'], 'asked' => $nf['asked'] ] ); ?>
            <?php endif; ?>

            <?php if ( 'sunk' === $nf['digits'] ) : ?>
                <?php get_template_part( 'template-parts/not-found/digits', null, [ 'mode' => 'sunk' ] ); ?>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php
get_footer();
