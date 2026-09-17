<?php
/**
 * About page — The Dream Guests section
 *
 * Dark section (Soft Peppercorn bg).
 * Section header: eyebrow, headline, description, VK photo albums CTA.
 * 4×2 grid of photo cards — each links to a VK album, carries a Lemon caption pill.
 *
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/eventCovers/';

$guest_cards = [
    // Row 1
    [
        'src'   => $img_base . '12y.jpg',
        'alt'   => __( 'Guests celebrating Sweet Pepper\'s 12th birthday party', 'sweet-pepper' ),
        'label' => __( '12th Bday!', 'sweet-pepper' ),
        'url'   => 'https://vk.ru/album-64582467_308753763',
    ],
    [
        'src'   => $img_base . 'mex-25.jpg',
        'alt'   => __( 'Mexican party night at Sweet Pepper', 'sweet-pepper' ),
        'label' => __( 'Mexican Party', 'sweet-pepper' ),
        'url'   => 'https://vk.ru/album-64582467_306320532',
    ],
    [
        'src'   => $img_base . 'halloween-25.jpg',
        'alt'   => __( 'Halloween 2025 costumes and fun at Sweet Pepper', 'sweet-pepper' ),
        'label' => __( 'Halloween 2025', 'sweet-pepper' ),
        'url'   => 'https://vk.ru/album-64582467_307968926',
    ],
    [
        'src'   => $img_base . 'val-25.jpg',
        'alt'   => __( 'St. Valentine\'s Day 2025 at Sweet Pepper', 'sweet-pepper' ),
        'label' => __( 'Valentine\'s 2025', 'sweet-pepper' ),
        'url'   => 'https://vk.ru/album-64582467_305100418',
    ],
    // Row 2
    [
        'src'   => $img_base . '9years.jpg',
        'alt'   => __( 'Guests at Sweet Pepper\'s 9th birthday celebration', 'sweet-pepper' ),
        'label' => __( '9th Bday!', 'sweet-pepper' ),
        'url'   => 'https://vk.ru/album-64582467_289731109',
    ],
    [
        'src'   => $img_base . 'teachers-24.jpg',
        'alt'   => __( 'Teachers Day celebration at Sweet Pepper', 'sweet-pepper' ),
        'label' => __( 'Teachers\' Day', 'sweet-pepper' ),
        'url'   => 'https://vk.ru/album-64582467_296448131',
    ],
    [
        'src'   => $img_base . 'bartenders-2022.jpg',
        'alt'   => __( 'Bartenders Day party at Sweet Pepper', 'sweet-pepper' ),
        'label' => __( 'Bartenders\' Day', 'sweet-pepper' ),
        'url'   => 'https://vk.ru/album-64582467_281391602',
    ],
    [
        'src'   => $img_base . 'Halloween-23.jpg',
        'alt'   => __( 'Halloween 2023 night at Sweet Pepper', 'sweet-pepper' ),
        'label' => __( 'Halloween 2023', 'sweet-pepper' ),
        'url'   => 'https://vk.ru/album-64582467_297622926',
    ],
];
?>

<section id="guests" class="about-section about-section--dark about-section--surface-dark about-guests">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'inGoodCompany', 'position' => 'head', 'alt' => 'In good company' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'     => __( 'GOOD TO SEE YOU AGAIN', 'sweet-pepper' ),
            'headline'    => __( 'THE DREAM', 'sweet-pepper' ),
            'headline_2'  => __( 'GUESTS', 'sweet-pepper' ),
            'description' => __( 'Some faces have been here since the early days; others are here for the first time. Together, they make the place. Take a look through the nights, celebrations and familiar faces — you might spot yourself.', 'sweet-pepper' ),
            'ctas'        => [
                [
                    'label'          => __( 'Browse the photo albums', 'sweet-pepper' ),
                    'url'            => 'https://vk.ru/albums-64582467',
                    'variant'        => 'secondary',
                    'type'           => 'secondary',
                    'icon_left_svg'  => 'icons/vk.svg',
                    'icon_right_svg' => 'icons/c-arrow-right-outline.svg',
                ],
            ],
        ] );
        ?>

        <div class="about-guests__grid">
            <?php foreach ( $guest_cards as $card ) : ?>
                <a class="about-guests__card"
                   href="<?php echo esc_url( $card['url'] ); ?>"
                   target="_blank"
                   rel="noopener noreferrer">
                    <img src="<?php echo esc_url( $card['src'] ); ?>"
                         alt="<?php echo esc_attr( $card['alt'] ); ?>"
                         class="about-guests__card-img"
                         loading="lazy">
                    <div class="about-guests__card-pill">
                        <span><?php echo esc_html( $card['label'] ); ?></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'theUsualSuspects', 'position' => 'foot', 'alt' => 'The usual suspects' ] ); ?>
</section>
