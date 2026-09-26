<?php
/**
 * Home — What's on: the social entrance (website-brief.md → News/social feed → Launch phasing;
 * Mobile — Events / social entrance).
 *
 * Content comes as args from sweet_pepper_home_events() (inc/home-data.php) — the front page's
 * «Что нового» tab: header, up to five cards, the «More on VK» tile. The two Follow buttons
 * and their destinations are the part's.
 *
 * @param array $args eyebrow · headline · headline_2 · description · cards[] (event-card args) · more (image_url, image_alt, label, url)
 *
 * @package Sweet_Pepper
 */
?>

    <?php
    // Trial flag (25 Sep 2026): `?title-lines=2` lets the card captions run to two lines instead of
    // one, to judge on the live page; remove with the decision (events.css → Title).
    $title_lines = isset( $_GET['title-lines'] ) ? max( 1, min( 3, (int) $_GET['title-lines'] ) ) : 1;
    ?>
    <!-- Events / News Section -->
    <section id="events" class="home-events"<?php echo 1 !== $title_lines ? ' style="--event-title-lines: ' . (int) $title_lines . '"' : ''; ?>>
        <div class="container">
            <!-- Top Section Link Word (SEE WHAT'S NEW — reflection, shared seam with About) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/seeWhatsNew-top.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/seeWhatsNew-top.svg',
                'alt'       => 'SEE WHAT\'S NEW',
                'class'     => 'section-link-word--reflection',
            ] ); 
            ?>

            <!-- Section Header -->
            <?php 
            get_template_part( 'template-parts/components/section-header', null, [
                'eyebrow'     => $args['eyebrow'],
                'headline'    => $args['headline'],
                'headline_2'  => $args['headline_2'],
                'description' => $args['description'],
                'ctas'        => [
                    [
                        'label'         => __( "See what's on VK", 'sweet-pepper' ),
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/vk.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://vk.com/sweet_pepper_bar',
                    ],
                    [
                        'label'         => __( 'View Instagram', 'sweet-pepper' ),
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/insta.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://www.instagram.com/barsweetpepper/', // was /sweet_pepper_bar/ — not the account (author, 25 Sep 2026)
                    ],
                ]
            ] ); 
            ?>

            <!-- Events Grid: 5 cards + link tile -->
            <div class="events-grid">
                <?php
                foreach ( $args['cards'] as $event_card ) {
                    get_template_part( 'template-parts/components/event-card', null, $event_card );
                }

                // 6th slot: "See all events" link tile
                get_template_part( 'template-parts/components/events-link-card', null, $args['more'] );
                ?>
            </div>

            <!-- Bottom Section Link Word (JOIN THE PARTY) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/joinTheParty-bottom.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/joinTheParty-bottom.svg',
                'alt'       => 'JOIN THE PARTY'
            ] ); 
            ?>
        </div>
    </section>
