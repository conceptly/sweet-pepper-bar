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
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/';

// Headline from ACF (Pages → About), with the hardcoded copy as fallback.
$headline = function_exists( 'get_field' ) ? get_field( 'about_hero_headline' ) : '';
$headline = $headline ?: 'Shake & Cook Since 2014';

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
            <span class="about-hero__eyebrow molot-text">Kirova St. 10/25, Yaroslavl</span>
            <h1 class="about-hero__headline"><?php echo esc_html( $headline ); ?></h1>
            <p class="about-hero__lead">A proper meal, a favourite drink and a place to settle in. Get to know the people, the stories and the room behind Sweet Pepper.</p>
        </div>

        <nav class="about-hero__filmstrip" aria-label="Page sections">
            <?php foreach ( $filmstrip as $item ) : ?>
                <a href="<?php echo esc_attr( $item['href'] ); ?>" class="about-hero__filmstrip-item">
                    <div class="about-hero__filmstrip-img-wrap" aria-hidden="true">
                        <img src="<?php echo esc_url( $item['image'] ); ?>"
                             alt=""
                             class="about-hero__filmstrip-img"
                             loading="lazy">
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
