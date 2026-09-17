<?php
/**
 * About page — Entrance photo section
 *
 * Reuses the menu-page entrance image pattern (location.css)
 * with shared class names: .menu-entrance-img, .menu-entrance-img__inner.
 *
 * On the About page this sits between Location (light) and Visit CTA (dark),
 * so it uses a dark bg variant instead of the menu page's Paper bg.
 *
 * @package Sweet_Pepper
 */
?>

<section class="menu-entrance-img menu-entrance-img--dark" aria-hidden="true">
    <div class="container">
        <div class="menu-entrance-img__inner">
            <?php // Image caption label — the img component's pill, top-left (frame 1490:78532;
                  // website-brief.md → Image caption label). Wording: about-page-copy.md → Location and entrance. ?>
            <span class="menu-entrance-img__pill"><?php esc_html_e( 'The way in', 'sweet-pepper' ); ?></span>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/sweet-space/door-entrance.jpg' ); ?>"
                 alt="<?php echo esc_attr__( 'Entrance to Sweet Pepper Gastrobar, Kirova St. 10/25', 'sweet-pepper' ); ?>"
                 loading="lazy">
        </div>
    </div>
</section>
