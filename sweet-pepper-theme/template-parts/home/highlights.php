<?php
/**
 * Home — Highlights: the section header and three cards that point at menu dishes
 * (website-brief.md → Mobile — Highlights).
 *
 * Content comes as args from sweet_pepper_home_highlights() (inc/home-data.php) — the front
 * page's «Что попробовать» tab. The two menu buttons and the connectors are the part's.
 *
 * @param array $args eyebrow · headline · headline_2 · description · cards[] (highlight-card args)
 *
 * @package Sweet_Pepper
 */
?>

    <!-- Menu Highlights Section -->
    <section id="menu-highlights" class="home-highlights">
        <div class="container">
            <!-- Top Section Link Word (AT SWEET PEPPER — reflection variant) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/atSweetPepper-top.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/atSweetPepper-top.svg',
                'alt'       => 'AT SWEET PEPPER',
                'class'     => 'section-link-word--reflection',
            ] ); 
            ?>

            <!-- 1. Section Header Component -->
            <?php 
            get_template_part( 'template-parts/components/section-header', null, [
                'eyebrow'     => $args['eyebrow'],
                'headline'    => $args['headline'],
                'headline_2'  => $args['headline_2'],
                'description' => $args['description'],
                'ctas'        => [
                    [
                        'label'      => __( 'Drinks menu', 'sweet-pepper' ),
                        'type'       => 'secondary',
                        'icon_left'  => 'martini',
                        'icon_right' => 'arrow-right',
                        'url'        => sweet_pepper_menu_url( 'drinks' )
                    ],
                    [
                        'label'      => __( 'Food menu', 'sweet-pepper' ),
                        'type'       => 'secondary',
                        'icon_left'  => 'fork-knife',
                        'icon_right' => 'arrow-right',
                        'url'        => sweet_pepper_menu_url( 'food' )
                    ]
                ]
            ] ); 
            ?>

            <!-- 2. Highlight Cards Grid -->
            <div class="highlights-grid">
                <?php
                foreach ( $args['cards'] as $card ) {
                    get_template_part( 'template-parts/components/highlight-card', null, $card );
                }
                ?>
            </div>

            <!-- 3. Section Link Word Component (Bottom) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/forAWellEarnedPour-bottom.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/forAWellEarnedPour-bottom.svg',
                'alt'       => 'FOR A WELL-EARNED POUR'
            ] ); 
            ?>
        </div>
    </section>
