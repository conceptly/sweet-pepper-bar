<?php
/**
 * The front page template
 *
 * @package Sweet_Pepper
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Hero Section with Daypart Tile Grid -->
    <section class="home-hero">
        <div class="container hero-container">
            <div class="hero-content">
                <span class="hero-eyebrow molot-text">SHAKE & COOK · YAROSLAVL</span>
                <h1 id="hero-headline" class="hero-headline">YUMMY MORNING!</h1>
                <p id="hero-subhead" class="hero-subhead">Coffee, eggs and a good reason to get out of bed.</p>
                
                <div class="daypart-grid">
                    <?php 
                    $dayparts = [
                        'breakfast' => ['img' => 'food/breakfast/pepper-breakfast-2.jpg', 'alt' => 'Sweet Pepper breakfast plate'],
                        'lunch'     => ['img' => 'food/lunch/pumpkin.png',               'alt' => 'Pumpkin soup'],
                        'dinner'    => ['img' => 'food/dinner/zharkoe-1.jpg',            'alt' => 'Zharkoe stew'],
                        'party'     => ['img' => 'bar/cocktails/moscow-mull-2.jpg',      'alt' => 'Cocktail'],
                    ];
                    foreach ($dayparts as $dp => $meta) : ?>
                        <button class="daypart-tile<?php echo $dp === 'breakfast' ? ' is-active' : ''; ?>" data-daypart="<?php echo $dp; ?>">
                            <!-- Color stack — 3 rotated sheets (visible only when active).
                                 Slots carry geometry (far / mid / near); colours per daypart come from hero.css -->
                            <div class="tile-color-stack">
                                <div class="tile-bg tile-bg--far"></div>
                                <div class="tile-bg tile-bg--mid"></div>
                                <div class="tile-bg tile-bg--near"></div>
                            </div>
                            <!-- Image -->
                            <div class="tile-img-wrapper">
                                <img src="<?php echo get_template_directory_uri() . '/assets/images/' . $meta['img']; ?>" 
                                     alt="<?php echo esc_attr($meta['alt']); ?>"
                                     class="tile-img" loading="eager" decoding="async">
                                <div class="tile-overlay"></div>
                            </div>
                            <!-- Now badge (dot when inactive, label when active) -->
                            <span class="now-badge">Now</span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="hero-ctas">
                    <?php 
                    get_template_part('template-parts/components/button', null, [
                        'label' => 'Reserve',
                        'type'  => 'primary',
                        'icon'  => 'bell',
                        'class' => 'js-reserve-trigger'
                    ]); 
                    
                    get_template_part('template-parts/components/button', null, [
                        'label' => 'Breakfast menu',
                        'type'  => 'secondary',
                        'icon'  => 'coffee',
                        'id'    => 'hero-menu-btn',
                        // Matches the server-rendered 'Breakfast menu' label; daypart-engine.js
                        // swaps both label and href once it knows the real daypart.
                        'url'   => home_url( '/menu/#breakfast' )
                    ]); 
                    ?>
                </div>
            </div>
            
            <!-- Hero footer: lang-nudge (in flow, right-aligned) + section link word -->
            <div class="hero-footer">
                <div class="lang-nudge-wrapper">
                    <div class="lang-nudge" id="lang-nudge">
                        Удобнее по-русски? <strong>Переключить &rarr;</strong>
                        <button id="lang-nudge-close" aria-label="Close">&times;</button>
                    </div>
                </div>
                
                <?php 
                get_template_part( 'template-parts/components/section-link-word', null, [
                    'day_img'   => 'assets/sectionLinks/home/dayMode/atSweetPepper-bottom.svg',
                    'night_img' => 'assets/sectionLinks/home/nightMode/atSweetPepperBottom.svg',
                    'alt'       => 'AT SWEET PEPPER',
                    'loading'   => 'eager', // first viewport, and the entrance parks it outside its clip
                ] ); 
                ?>
            </div>
        </div>
    </section>

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
                'eyebrow'     => 'A GOOD PLACE TO START',
                'headline'    => 'HOUSE SPECIALS',
                'headline_2'  => '& LOCAL HITS',
                'description' => 'A little sweet, a little heat. Start with house infusions, grilled wings or Pepper\'s pot roast.',
                'ctas'        => [
                    [
                        'label'      => 'Drinks menu',
                        'type'       => 'secondary',
                        'icon_left'  => 'martini',
                        'icon_right' => 'arrow-right',
                        'url'        => home_url( '/menu/?menu=drinks' )
                    ],
                    [
                        'label'      => 'Food menu',
                        'type'       => 'secondary',
                        'icon_left'  => 'fork-knife',
                        'icon_right' => 'arrow-right',
                        'url'        => home_url( '/menu/' )
                    ]
                ]
            ] ); 
            ?>

            <!-- 2. Highlight Cards Grid -->
            <div class="highlights-grid">
                <?php
                $highlights = [
                    [
                        'image_url'   => get_template_directory_uri() . '/assets/images/bar/cocktails/shot-drinks.jpg',
                        'image_alt'   => 'House Infusions',
                        'title'       => 'HOUSE INFUSIONS',
                        // Category card, not a dish: the range starts at 150 (raspberry gin is 190),
                        // so the price reads "From" — home-copy-review-en.md. Serving size is still
                        // unconfirmed, so the doc's "· {serving size}" half is not rendered yet.
                        'price'       => 'From 150 ₽',
                        'description' => 'From cranberry to raspberry gin.',
                        'tag_icon'    => 'star',
                        'tag_label'   => 'Seasonal hits',
                        // Bar state renders only in ?menu=drinks, so the state travels with the
                        // anchor (same pattern as dish-picker.js builds for the pairing CTA).
                        'url'         => home_url( '/menu/?menu=drinks#infusions' )
                    ],
                    [
                        'image_url'   => get_template_directory_uri() . '/assets/images/food/dinner/wings-2.jpg',
                        'image_alt'   => 'Grilled Wings',
                        'title'       => 'GRILLED WINGS',
                        'price'       => '455-.',
                        'description' => 'Honey-glazed wings with sour cream, carrot and celery sticks.',
                        'tag_icon'    => 'fire',
                        'tag_label'   => 'Spicy',
                        'url'         => home_url( '/menu/#bar-snacks' )
                    ],
                    [
                        'image_url'   => get_template_directory_uri() . '/assets/images/food/dinner/zharkoe-1.jpg',
                        'image_alt'   => 'Pot roast',
                        // Shortened from "Pepper's pot roast" (author, Sep 2026) so the title
                        // holds one line. A stopgap, not the fix — see website-brief.md →
                        // Mobile — Highlights → Open → card row alignment.
                        'title'       => 'POT ROAST',
                        'price'       => '365-.',
                        'description' => 'Pork, potato wedges and vegetables in a spicy cream sauce.',
                        'tag_icon'    => 'yaroslavl-logo',
                        'tag_label'   => 'Yaroslavl-style',
                        'url'         => home_url( '/menu/#hot-dishes' )
                    ],
                ];

                foreach ( $highlights as $card ) {
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
                'title'       => 'HOUSE INFUSIONS',
                'image_url'   => get_template_directory_uri() . '/assets/images/bar/cocktails/shot-drinks.jpg',
                'image_alt'   => 'Home made infusions — colourful shots and cocktails',
                'image_badge' => 'Community hit!',
                'dishes'      => [
                    [
                        'dish_name'   => 'Salted Caramel',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Sweet, salty, irresistible.',
                        'icons'       => ['veg'],
                        'highlight'   => true,
                    ],
                    [
                        'dish_name'   => 'Horseradish',
                        'price'       => '150-. / 1300-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'For the brave — a taste of Yaroslavl\'s hot side.',
                        'icons'       => ['veg', 'fire'],
                        'highlight'   => true,
                    ],
                    [
                        'dish_name'   => 'Raspberry Gin',
                        'price'       => '190-. / 1800-.',
                        'quantity'    => '40 ml / 500 ml',
                        'description' => 'Gin infused with raspberries.',
                        'highlight'   => true,
                    ],
                ],
                'cta'         => [
                    'label'          => 'Explore the drinks menu',
                    'type'           => 'secondary',
                    'icon_right_svg' => 'icons/Pepper.svg',
                    'url'            => home_url( '/menu/?menu=drinks' ),
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
                'title'       => 'YOUR LUNCH SORTED',
                'image_url'   => get_template_directory_uri() . '/assets/images/food/lunch/bagel-lunch-1.jpg',
                'image_alt'   => 'Bagel with a patty, potato wedges and fresh vegetables',
                'dishes'      => [
                    [
                        'dish_name'   => 'Pumpkin soup',
                        'price'       => '195-.',
                        'description' => 'Creamy pumpkin soup with chicken.',
                        'icons'       => ['veg'],
                        'highlight'   => true,
                    ],
                    [
                        'dish_name'   => 'Quesadilla',
                        'price'       => '265-.',
                        'description' => 'Chicken and cheese, or double cheese.',
                        'highlight'   => true,
                    ],
                    [
                        'dish_name'   => 'Beef patty bagel',
                        'price'       => '355-.',
                        'description' => 'A beef patty, vegetables and pickles in a house-made bagel, with potato wedges and sauce.',
                        'highlight'   => true,
                    ],
                ],
                'cta'         => [
                    'label'          => 'Explore the food menu',
                    'type'           => 'secondary',
                    'icon_right_svg' => 'icons/food.svg',
                    'url'            => home_url( '/menu/' ),
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
                    <span class="section-eyebrow molot-text">THE PEPPER STORY</span>
                    
                    <div class="section-headline-group">
                        <h2 class="section-headline molot-text">SHAKE &amp; COOK</h2>
                        <p class="section-headline-2 molot-text">SINCE 2014</p>
                    </div>
                    
                    <p class="section-description">From Tabasco Bar next door to Sweet Pepper: the same edge, a warmer welcome. A proper meal and a good drink belong at the same table — yours.</p>

                    <div class="about-preview-stats">
                        <span class="stat-chip">
                            <i class="ph-fill ph-pepper stat-chip-icon"></i>
                            <span class="stat-chip-label" data-count-up>12 years</span>
                        </span>
                        <span class="stat-chip">
                            <i class="ph-fill ph-star stat-chip-icon"></i>
                            <span class="stat-chip-label">5.0 on Yandex</span>
                        </span>
                    </div>

                    <div class="about-preview-cta">
                        <?php 
                        get_template_part( 'template-parts/components/button', null, [
                            'label'      => 'Read the full story',
                            'type'       => 'secondary',
                            'icon_right' => 'pepper',
                            'url'        => home_url( '/about' ),
                        ] ); 
                        ?>
                    </div>
                </div>

                <div class="about-preview-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bar/cocktails/shots-2.jpg" 
                         alt="Bartender pouring green cocktail shots at Sweet Pepper bar" 
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

    <!-- Events / News Section -->
    <section id="events" class="home-events">
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
                'eyebrow'     => 'MAKE YOUR NEXT PLAN',
                'headline'    => 'WHAT\'S ON',
                'headline_2'  => 'AT PEPPER',
                'description' => 'Your next night out starts here. Check VK for news, parties and specials, or take a look on Instagram.',
                'ctas'        => [
                    [
                        'label'         => 'See what\'s on VK',
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/vk.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://vk.com/sweet_pepper_bar',
                    ],
                    [
                        'label'         => 'View Instagram',
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/insta.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://www.instagram.com/sweet_pepper_bar/',
                    ],
                ]
            ] ); 
            ?>

            <!-- Events Grid: 5 cards + link tile -->
            <div class="events-grid">
                <?php
                $events = [
                    [
                        'image_url' => get_template_directory_uri() . '/assets/images/bar/cocktails/moscow-mull-2.jpg',
                        'image_alt' => 'Live DJ set at Sweet Pepper',
                        'title'     => 'Live DJ Set: Friday Night',
                        'date'      => date('j M'), // Today's date — triggers "Today!" state
                        'category'  => 'event',
                        'source'    => 'instagram',
                        'pinned'    => true,
                        'url'       => 'https://vk.com/sweet_pepper_bar',
                    ],
                    [
                        'image_url' => get_template_directory_uri() . '/assets/images/bar/cocktails/shot-drinks.jpg',
                        'image_alt' => 'Shot drinks promo',
                        'title'     => 'Live DJ Set: Friday Night',
                        'date'      => '12 Oct',
                        'category'  => 'promo',
                        'source'    => 'instagram',
                        'url'       => 'https://vk.com/sweet_pepper_bar',
                    ],
                    [
                        'image_url' => get_template_directory_uri() . '/assets/images/bar/cocktails/mulled-2.jpg',
                        'image_alt' => 'Community night at Sweet Pepper',
                        'title'     => 'Live DJ Set: Friday Night',
                        'date'      => '12 Oct',
                        'category'  => 'community',
                        'source'    => 'instagram',
                        'url'       => 'https://vk.com/sweet_pepper_bar',
                    ],
                    [
                        'image_url' => get_template_directory_uri() . '/assets/images/bar/cocktails/students-2.jpg',
                        'image_alt' => 'Community event',
                        'title'     => 'Live DJ Set: Friday Night',
                        'date'      => '12 Oct',
                        'category'  => 'community',
                        'source'    => 'instagram',
                        'url'       => 'https://vk.com/sweet_pepper_bar',
                    ],
                    [
                        'image_url' => get_template_directory_uri() . '/assets/images/bar/cocktails/shots-2.jpg',
                        'image_alt' => 'Community shots night',
                        'title'     => 'Live DJ Set: Friday Night',
                        'date'      => '12 Oct',
                        'category'  => 'community',
                        'source'    => 'instagram',
                        'url'       => 'https://vk.com/sweet_pepper_bar',
                    ],
                ];

                foreach ( $events as $event_card ) {
                    get_template_part( 'template-parts/components/event-card', null, $event_card );
                }

                // 6th slot: "See all events" link tile
                get_template_part( 'template-parts/components/events-link-card', null, [
                    'image_url' => get_template_directory_uri() . '/assets/images/bar/cocktails/shots-3.jpg',
                    'image_alt' => 'See all events at Sweet Pepper',
                    'label'     => 'More on VK →',
                    'url'       => 'https://vk.com/sweet_pepper_bar',
                ] );
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

    <!-- Contacts Section -->
    <section class="home-contacts" id="contacts">
        <div class="container">

            <!-- Top Section Link Word (JOIN THE PARTY — reflection, shared seam with Events) -->
            <?php 
            get_template_part( 'template-parts/components/section-link-word', null, [
                'day_img'   => 'assets/sectionLinks/home/dayMode/joinTheParty-top.svg',
                'night_img' => 'assets/sectionLinks/home/nightMode/joinTheParty-top.svg',
                'alt'       => 'JOIN THE PARTY',
                'class'     => 'section-link-word--reflection',
            ] ); 
            ?>

            <!-- Section Header -->
            <?php 
            get_template_part( 'template-parts/components/section-header', null, [
                'eyebrow'     => 'YOUR NEXT STOP: KIROVA',
                'headline'    => 'SEE YOU SOON?',
                'description' => 'Drop in, or arrange a table by phone or message. Planning a Friday or Saturday evening? Book ahead.',
                'description_mobile' => 'Drop in, or book ahead for Friday and Saturday evenings.',
                'ctas'        => [
                    [
                        'label'         => 'vk.com/sweetpepperbar',
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/vk.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://vk.com/sweetpepperbar',
                    ],
                    [
                        'label'         => 'instagram.com/barsweetpepper',
                        'type'          => 'secondary',
                        'icon_left_svg' => 'icons/insta.svg',
                        'icon_right_svg'=> 'icons/c-arrow-right-outline.svg',
                        'url'           => 'https://www.instagram.com/barsweetpepper/',
                    ],
                ]
            ] ); 
            ?>

            <!-- Phones only (Figma Contacts 1198:53132): the reserve drawer's booking block in the
                 flow — phone leads, messengers second. Same classes as the drawer, so the bar-state
                 engine (reserve-drawer.js) and the copy buttons drive it. -->
            <div class="contacts-reserve">
                <div class="phone-cta-wrapper" data-bar-state="available">
                    <button type="button" class="btn-call js-copy" data-copy-text="+74852911202">
                        <span class="btn-call-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-phone.svg' ); ?></span>
                        <span class="btn-call-label">+7 (4852) 911-202</span>
                        <span class="btn-copy-icon btn-copy-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                        <span class="btn-copy-icon btn-copy-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                    </button>
                    <div class="call-status">
                        <span class="call-status-icon">
                            <span class="call-status-icon--available"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                            <span class="call-status-icon--busy" aria-hidden="true"></span>
                            <span class="call-status-icon--closed"><?php echo sweet_pepper_inline_svg( 'assets/icons/sleep.svg' ); ?></span>
                        </span>
                        <span class="call-status-text"></span>
                    </div>
                </div>
                <div class="contacts-reserve__social">
                    <div class="contacts-reserve__row">
                        <?php
                        get_template_part( 'template-parts/components/button', null, [
                            // Short labels, the drawers' and the Visit CTA's: the long pair ("Message on …")
                            // overflowed the two-up row on phones (Sep 2026)
                            'label'         => 'VK message',
                            'type'          => 'secondary',
                            'icon_left_svg' => 'icons/vk.svg',
                            'url'           => 'https://vk.me/barsweetpepper',
                        ] );
                        get_template_part( 'template-parts/components/button', null, [
                            'label'         => 'Instagram DM',
                            'type'          => 'secondary',
                            'icon_left_svg' => 'icons/insta.svg',
                            'url'           => 'https://ig.me/m/barsweetpepper',
                        ] );
                        ?>
                    </div>
                    <div class="call-status contacts-reserve__status">
                        <span class="call-status-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                        <span class="call-status-text">Usually answer in 20 minutes</span>
                    </div>
                </div>
            </div>

            <!-- Map + Form Split -->
            <div class="contacts-split">

                <!-- Map Column — on phones a "Get directions" band: title + 240px map + chips
                     (the address bar and the form are desktop-only) -->
                <div class="contacts-map-wrap">
                    <h2 class="contacts-subtitle contacts-subtitle--directions molot-text">Your route to Pepper</h2>
                    <div class="contacts-map">
                        <div class="contacts-map__embed">
                            <iframe 
                                src="https://www.google.com/maps/d/embed?mid=1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY&hl=en&ehbc=2E312F" 
                                title="Sweet Pepper Bar on the map"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                allowfullscreen
                            ></iframe>
                        </div>
                        <div class="contacts-map__bar">
                            <div class="contacts-map__address">
                                <span class="contacts-map__pin-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-pin.svg' ); ?></span>
                                <span class="contacts-map__address-text">Kirova 10/25, Yaroslavl</span>
                            </div>
                            <div class="contacts-map__chips">
                                <?php // The bar is 534 wide and the address already ellipsises, so the two
                                      // chips carry the short labels and the full action names sit in the
                                      // accessible name (home-copy-en.md → Actions). The phone chip row below
                                      // has the width for the long labels. ?>
                                <button class="contacts-chip js-copy" data-copy-text="Ярославль, ул. Кирова, 10/25" data-copied-label="Copied" type="button" aria-label="Copy address">
                                    <span class="chip-label">Copy</span>
                                    <span class="chip-icon chip-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                                    <span class="chip-icon chip-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                                </button>
                                <a class="contacts-chip" href="https://maps.google.com/?q=Yaroslavl,+Kirova+10/25" target="_blank" rel="noopener noreferrer" aria-label="Get directions">
                                    Directions <span class="chip-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-navigate.svg' ); ?></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="contacts-map__chips contacts-map__chips--phone">
                        <button class="contacts-chip js-copy" data-copy-text="Ярославль, ул. Кирова, 10/25" data-copied-label="Address copied" type="button" aria-label="Copy address">
                            <span class="chip-label">Copy address</span>
                            <span class="chip-icon chip-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                            <span class="chip-icon chip-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                        </button>
                        <a class="contacts-chip" href="https://yandex.ru/maps/?rtext=~57.626100%2C39.884500" target="_blank" rel="noopener noreferrer">
                            Yandex Maps <span class="chip-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                        </a>
                    </div>
                </div>

                <!-- Form Column -->
                <div class="contacts-form-wrap">
                    <?php get_template_part( 'template-parts/components/contact-form' ); ?>
                </div>

            </div>

            <!-- Phones only: the Visit page carries the rest -->
            <div class="contacts-more">
                <h2 class="contacts-subtitle molot-text">Plan your visit</h2>
                <div class="contacts-more__row">
                    <p class="contacts-more__lead">Hours, parking and the way in.</p>
                    <a class="contacts-more__link" href="<?php echo esc_url( home_url( '/visit/' ) ); ?>">
                        Plan your visit <span class="contacts-more__link-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
                    </a>
                </div>
            </div>

        </div>
    </section>

</main>

<?php
get_footer();
