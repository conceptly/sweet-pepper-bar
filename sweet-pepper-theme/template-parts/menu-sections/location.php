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
                 alt="Sweet Pepper restaurant entrance on Kirova Street"
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
                <p class="location__subheading molot-text">Find the Pepper</p>
                <h2 class="location__title">
                    <!-- Desktop breaks after "of the" (Chili | Paprika); phones after "heart"
                         (Figma 2109:130246) — the middle span changes side per breakpoint. -->
                    <span class="location__title-line1 molot-text">at the very heart </span><span class="location__title-mid molot-text">of the </span><span class="location__title-line2 molot-text">best city</span>
                </h2>
            </div>

            <p class="location__description">Find us on Kirova Street 10 — Yaroslavl's pedestrian Arbat, a few minutes from the Church of Elijah the Prophet and the Monument to Yaroslav the Wise. Two halls inside, each with its own feel, and a summer terrace with swing-chairs that people remember long after the drink.</p>
        </div>

        <!-- Right: map (iframe injected by JS based on user locale) -->
        <div class="location__map" aria-label="Restaurant location map"></div>

    </div>
</section>
