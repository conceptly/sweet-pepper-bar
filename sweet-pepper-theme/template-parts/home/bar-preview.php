<?php
/**
 * Home — the bar preview (House infusions): text left, photo right
 * (website-brief.md → Mobile — Bar & Kitchen previews).
 *
 * Content comes as args from sweet_pepper_home_preview( …, 'bar' ) (inc/home-data.php) — the
 * front page's «Настойки» tab: title, photo + caption, three rows from the drinks store.
 *
 * @param array $args title · image_url · image_alt · image_badge · dishes[] (dish-row args)
 *
 * @package Sweet_Pepper
 */
?>

    <!-- Bar Preview Section -->
    <section id="bar-preview" class="home-bar-preview">
        <div class="container">
            <!-- Top Section Link Word (FOR A WELL-EARNED POUR — reflection, shared with highlights bottom; adopted from the Figma night frame, Sep 2026) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/forAWellEarnedPour-top.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/forAWellEarnedPour-top.svg',
                'alt'       => 'FOR A WELL-EARNED POUR',
                'class'     => 'section-link-word--reflection',
            ] ); 
            ?>

            <?php 
            get_template_part( 'template-parts/components/menu-preview', null, [
                'layout'      => 'text-left',
                'title'       => $args['title'],
                'image_url'   => $args['image_url'],
                'image_alt'   => $args['image_alt'],
                'image_badge' => $args['image_badge'],
                'dishes'      => $args['dishes'],
                'cta'         => [
                    'label'          => __( 'Explore the drinks menu', 'sweet-pepper' ),
                    'type'           => 'secondary',
                    'icon_right_svg' => 'icons/Pepper.svg',
                    'url'            => sweet_pepper_menu_url( 'drinks' ),
                ],
                'cta_align'   => 'left',
            ] ); 
            ?>

            <!-- Bottom Section Link Word (FOR A PROPER APPETITE) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/forAProperAppetite-bottom.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/forAProperAppetite-bottom.svg',
                'alt'       => 'FOR A PROPER APPETITE'
            ] ); 
            ?>
        </div>
    </section>
