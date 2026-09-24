<?php
/**
 * Home — the About preview (website-brief.md → Mobile — About preview).
 *
 * Content comes as args from sweet_pepper_home_about() (inc/home-data.php) — the front page's
 * «О баре» tab. The years are counted by the site; the button is a UI string.
 *
 * @param array $args eyebrow · headline · headline_2 · description · image_url · image_alt · years ("12 years") · rating
 *
 * @package Sweet_Pepper
 */
?>

    <!-- About Preview Section -->
    <section id="about-preview" class="home-about-preview">
        <div class="container">
            <!-- Top Section Link Word (MORE THAN A MENU — reflection, shared seam with Kitchen) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/moreThanAMenu-top.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/moreThanAMenu-top.svg',
                'alt'       => 'MORE THAN A MENU',
                'class'     => 'section-link-word--reflection',
            ] ); 
            ?>

            <div class="about-preview-content">
                <div class="about-preview-text">
                    <span class="section-eyebrow molot-text"><?php echo esc_html( $args['eyebrow'] ); ?></span>
                    
                    <div class="section-headline-group">
                        <h2 class="section-headline molot-text"><?php echo esc_html( $args['headline'] ); ?></h2>
                        <?php if ( '' !== $args['headline_2'] ) : ?>
                        <p class="section-headline-2 molot-text"><?php echo esc_html( $args['headline_2'] ); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <p class="section-description"><?php echo esc_html( $args['description'] ); ?></p>

                    <div class="about-preview-stats">
                        <?php if ( '' !== $args['years'] ) : ?>
                        <span class="stat-chip">
                            <i class="ph-fill ph-pepper stat-chip-icon"></i>
                            <span class="stat-chip-label" data-count-up><?php echo esc_html( $args['years'] ); ?></span>
                        </span>
                        <?php endif; ?>
                        <?php if ( '' !== $args['rating'] ) : ?>
                        <span class="stat-chip">
                            <i class="ph-fill ph-star stat-chip-icon"></i>
                            <span class="stat-chip-label"><?php echo esc_html( $args['rating'] ); ?></span>
                        </span>
                        <?php endif; ?>
                    </div>

                    <div class="about-preview-cta">
                        <?php 
                        get_template_part( 'template-parts/components/button', null, [
                            'label'      => __( 'Read the full story', 'sweet-pepper' ),
                            'type'       => 'secondary',
                            'icon_right' => 'pepper',
                            'url'        => home_url( '/about' ),
                        ] ); 
                        ?>
                    </div>
                </div>

                <div class="about-preview-image">
                    <img src="<?php echo esc_url( $args['image_url'] ); ?>" 
                         alt="<?php echo esc_attr( $args['image_alt'] ); ?>" 
                         loading="lazy">
                </div>
            </div>

            <!-- Bottom Section Link Word (SEE WHAT'S NEW) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/seeWhatsNew-bottom.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/seeWhatsNew-bottom.svg',
                'alt'       => 'SEE WHAT\'S NEW'
            ] ); 
            ?>
        </div>
    </section>
