<?php
/**
 * Home — the kitchen preview (Your lunch sorted): photo left, text right.
 *
 * Content comes as args from sweet_pepper_home_preview( …, 'kitchen' ) (inc/home-data.php) —
 * the front page's «Обед» tab: title, photo + caption, three rows from the dishes store.
 *
 * @param array $args title · image_url · image_alt · image_badge · dishes[] (dish-row args)
 *
 * @package Sweet_Pepper
 */
?>

    <!-- Kitchen Preview Section -->
    <section id="kitchen-preview" class="home-kitchen-preview">
        <div class="container">
            <!-- Top Section Link Word (FOR A PROPER APPETITE — reflection) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/forAProperAppetite-top.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/forAProperAppetite-top.svg',
                'alt'       => 'FOR A PROPER APPETITE',
                'class'     => 'section-link-word--reflection',
            ] ); 
            ?>

            <?php 
            get_template_part( 'template-parts/components/menu-preview', null, [
                'layout'      => 'image-left',
                'title'       => $args['title'],
                'image_url'   => $args['image_url'],
                'image_alt'   => $args['image_alt'],
                'image_badge' => $args['image_badge'],
                'dishes'      => $args['dishes'],
                'cta'         => [
                    'label'          => __( 'Explore the food menu', 'sweet-pepper' ),
                    'type'           => 'secondary',
                    'icon_right_svg' => 'icons/food.svg',
                    'url'            => sweet_pepper_menu_url( 'food' ),
                ],
                'cta_align'   => 'right',
            ] ); 
            ?>

            <!-- Bottom Section Link Word (MORE THAN A MENU) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/moreThanAMenu-bottom.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/moreThanAMenu-bottom.svg',
                'alt'       => 'MORE THAN A MENU'
            ] ); 
            ?>
        </div>
    </section>
