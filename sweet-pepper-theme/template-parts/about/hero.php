<?php
/**
 * About page — Hero section
 *
 * Dark background (Peppercorn). Content aligned to the bottom of the viewport.
 * Contains "SHAKE & COOK SINCE 2014" hero and a filmstrip index nav
 * with 5 photo-card thumbnails (each: image + 50% dark overlay + pill label).
 *
 * Header sits over this section transparently (see header.css overrides).
 *
 * Content comes as args from sweet_pepper_about_hero() (inc/about-data.php) — the About page's «Первый экран» tab.
 *
 * @param array $args eyebrow · headline · lead
 *
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/';


// Filmstrip nav items — about-page-copy.md → Hero: Food & drink · Story · People · Careers · Location
// (the doc flags the longer first label for a mobile fit check).
$filmstrip = [
    [
        'label' => 'Food & drink',
        'image' => $img_base . 'bar/cocktails/cocktail-5.jpg',
        'href'  => '#concept',
    ],
    [
        'label' => 'Story',
        'image' => $img_base . 'food/lunch/pumpkin.png',
        'href'  => '#story',
    ],
    [
        'label' => 'People',
        'image' => $img_base . 'bar/cocktails/moscow-mull-2.jpg',
        'href'  => '#guests',
    ],
    [
        'label' => 'Careers',
        'image' => $img_base . 'food/dinner/zharkoe-1.jpg',
        'href'  => '#careers',
    ],
    [
        'label' => 'Location',
        'image' => $img_base . 'sweet-space/door-entrance.jpg',
        'href'  => '#location',
    ],
];
?>

<section class="about-section about-section--dark about-hero">
    <div class="container">
        <div class="about-hero__content">
            <span class="about-hero__eyebrow molot-text"><?php echo esc_html( $args['eyebrow'] ); ?></span>
            <h1 class="about-hero__headline"><?php echo esc_html( $args['headline'] ); ?></h1>
            <p class="about-hero__lead"><?php echo esc_html( $args['lead'] ); ?></p>
        </div>

        <nav class="about-hero__filmstrip" aria-label="<?php esc_attr_e( 'Page sections', 'sweet-pepper' ); ?>">
            <?php foreach ( $filmstrip as $item ) : ?>
                <a href="<?php echo esc_attr( $item['href'] ); ?>" class="about-hero__filmstrip-item">
                    <div class="about-hero__filmstrip-img-wrap" aria-hidden="true">
                        <img src="<?php echo esc_url( $item['image'] ); ?>"
                             alt=""
                             class="about-hero__filmstrip-img"
                             loading="eager" decoding="async">
                        <div class="about-hero__filmstrip-overlay"></div>
                    </div>
                    <div class="about-hero__filmstrip-pill-area">
                        <div class="about-hero__filmstrip-pill">
                            <span class="about-hero__filmstrip-label"><?php echo esc_html( $item['label'] ); ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </nav>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'betterTogether', 'position' => 'foot', 'alt' => 'Better together' ] ); ?>
</section>
