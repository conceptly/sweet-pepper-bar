<?php
/**
 * About page — The Dream Guests section
 *
 * Dark section (Soft Peppercorn bg).
 * Section header: eyebrow, headline, description, VK photo albums CTA.
 * 4×2 grid of photo cards — each links to a VK album, carries a Lemon caption pill.
 *
 * Content comes as args from sweet_pepper_about_guests() (inc/about-data.php) — the About page's «Гости» tab.
 *
 * @param array $args eyebrow · headline · headline_2 · description · cards[] (src, label, alt, url)
 *
 * @package Sweet_Pepper
 */

$guest_cards = $args['cards'];
?>

<section id="guests" class="about-section about-section--dark about-section--surface-dark about-guests">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'inGoodCompany', 'position' => 'head', 'alt' => 'In good company' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'     => $args['eyebrow'],
            'headline'    => $args['headline'],
            'headline_2'  => $args['headline_2'],
            'description' => $args['description'],
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
