<?php
/**
 * Location Section — "Find the Pepper"
 *
 * The last section before the footer on the menu page.
 * Split layout: copy left, interactive map right.
 * Map provider (Google/Yandex) is selected client-side by JS.
 *
 * Figma: Location (797:22992)
 *
 * @package Sweet_Pepper
 */
?>

<!-- ═══════════════════════════════════════════════════════════════
     ENTRANCE IMAGE
     Figma: img (S6), 21:9 aspect, pillTop
     Full-width photo of the restaurant entrance above the location section.
     ═══════════════════════════════════════════════════════════════ -->
<section class="menu-entrance-img" aria-hidden="true">
    <div class="container">
        <div class="menu-entrance-img__inner">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/sweet-space/door-entrance.jpg' ); ?>"
                 alt="<?php esc_attr_e( 'Sweet Pepper restaurant entrance on Kirova Street', 'sweet-pepper' ); ?>"
                 loading="lazy">
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     LOCATION — Find the Pepper
     Figma: Location (797:22992)
     ═══════════════════════════════════════════════════════════════ -->
<section id="location" class="menu-location">
    <div class="container location__inner">

        <!-- Left: copy -->
        <div class="location__copy">
            <div class="location__title-block">
                <p class="location__subheading molot-text"><?php esc_html_e( 'Find the Pepper', 'sweet-pepper' ); ?></p>
                <h2 class="location__title">
                    <?php [ $line_1, $line_2 ] = sweet_pepper_location_headline(); // one headline for About, Menu and Visit (inc/location.php) ?>
                    <span class="location__title-line1 molot-text"><?php echo esc_html( $line_1 ); ?></span>
                    <span class="location__title-line2 molot-text"><?php echo esc_html( $line_2 ); ?></span>
                </h2>
            </div>

            <?php
            // Russian: the About page's «Адрес» paragraph — one place, one approved Russian text
            // (the English here is the menu's own; author, 23 Sep 2026: reuse About's Russian).
            $about_page  = 'ru' === sweet_pepper_lang() ? get_page_by_path( 'about' ) : null;
            $description = $about_page ? sweet_pepper_about_location( $about_page->ID )['description'] : '';
            ?>
            <p class="location__description"><?php echo esc_html( $description ?: "Find us on Kirova Street 10 — Yaroslavl's pedestrian Arbat, a few minutes from the Church of Elijah the Prophet and the Monument to Yaroslav the Wise. Two halls inside, each with its own feel, and a summer terrace with swing-chairs that people remember long after the drink." ); ?></p>
        </div>

        <!-- Right: map (iframe injected by JS based on user locale) -->
        <div class="location__map" aria-label="<?php esc_attr_e( 'Restaurant location map', 'sweet-pepper' ); ?>"></div>

    </div>
</section>
