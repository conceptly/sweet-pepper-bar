<?php
/**
 * Mobile navigation drawer (Figma: Drawer-4-Home-Day 1341:51991, Drawer-4-Menu-Night 1341:51696)
 *
 * Full-screen, themed by day/night via the semantic tokens. Opened by
 * `.js-drawer-open` (the header hamburger), closed by `.js-drawer-close`,
 * the Escape key, or resizing past the nav breakpoint (mobile-drawer.js).
 *
 * @package Sweet_Pepper
 */

$icons = get_template_directory() . '/assets/icons/';
$uri   = get_template_directory_uri() . '/assets/icons/';

// Order follows the Figma mockup (Home · About · Menu · Visit).
// website-brief.md → Top nav → Mobile lists this as open: decided order is Home · Menu · About · Visit.
// "late\u{2011}night": a non-breaking hyphen, so the description never splits there when it wraps.
$items = [
    [ 'label' => __( 'Home', 'sweet-pepper' ),  'desc' => __( 'A taste of Sweet Pepper', 'sweet-pepper' ),          'url' => home_url( '/' ),      'current' => is_front_page() ],
    [ 'label' => __( 'About', 'sweet-pepper' ), 'desc' => __( 'The place, the people, the story', 'sweet-pepper' ), 'url' => home_url( '/about' ), 'current' => is_page_template( 'page-about.php' ) ],
    [ 'label' => __( 'Menu', 'sweet-pepper' ),  'desc' => __( "From breakfast to late\u{2011}night drinks", 'sweet-pepper' ), 'url' => sweet_pepper_menu_url( 'food' ),  'current' => sweet_pepper_is_menu_page() ],
    [ 'label' => __( 'Visit', 'sweet-pepper' ), 'desc' => __( 'Hours, directions and contacts', 'sweet-pepper' ),   'url' => home_url( '/visit' ), 'current' => is_page_template( 'page-visit.php' ) ],
];

// About and Visit are fixed compositions with a dark hero (website-brief.md → What themes
// and what doesn't), so their drawer is dark in every theme; Home and Menu follow data-theme.
$is_dark = is_page_template( 'page-about.php' ) || is_page_template( 'page-visit.php' );

// Arrows and × go through sweet_pepper_inline_svg() per instance: this drawer is on every
// page, sits before the content, and is visibility: hidden on phones — a raw copy here
// owned the shared clipPath id and clipped every later raw copy on the page to nothing
// (menu highlight cards, Sep 2026). $arrow is rendered per item below.
$arrow  = '';
$marker = sweet_pepper_inline_svg( 'assets/icons/c-Pepper.svg' ); // "you are here" — the mockup's bare chili
?>
<div id="mobile-drawer" class="mobile-drawer<?php echo $is_dark ? ' mobile-drawer--dark' : ''; ?>" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Menu', 'sweet-pepper' ); ?>" aria-hidden="true" inert>

    <div class="mobile-drawer__header">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="mobile-drawer__logo">
            <img src="<?php echo $uri; ?>symbol.svg" alt="Sweet Pepper" width="23" height="32" class="mobile-drawer__symbol">
            <img src="<?php echo $uri; ?>wordmark.svg" alt="" width="159" height="16" class="mobile-drawer__wordmark" aria-hidden="true">
        </a>
        <button type="button" class="mobile-drawer__close js-drawer-close" aria-label="<?php esc_attr_e( 'Close menu', 'sweet-pepper' ); ?>">
            <?php echo sweet_pepper_inline_svg( 'assets/icons/c-close.svg' ); ?>
        </button>
    </div>

    <nav class="mobile-drawer__nav" aria-label="<?php esc_attr_e( 'Main', 'sweet-pepper' ); ?>">
        <ul class="mobile-drawer__list">
            <?php foreach ( $items as $item ) : ?>
            <li class="mobile-drawer__item">
                <a href="<?php echo esc_url( $item['url'] ); ?>" class="mobile-drawer__link<?php echo $item['current'] ? ' is-current' : ''; ?>"<?php echo $item['current'] ? ' aria-current="page"' : ''; ?>>
                    <span class="mobile-drawer__link-title"><?php echo esc_html( $item['label'] ); ?></span>
                    <span class="mobile-drawer__link-meta">
                        <span class="mobile-drawer__link-desc"><?php echo esc_html( $item['desc'] ); ?></span>
                        <span class="mobile-drawer__link-icon" aria-hidden="true"><?php echo $item['current'] ? $marker : sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
                    </span>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <div class="mobile-drawer__card">
        <div class="mobile-drawer__card-row mobile-drawer__card-row--directions">
            <span class="mobile-drawer__card-label">Get Directions</span>
            <a href="https://yandex.ru/maps/?rtext=~57.626100%2C39.884500" target="_blank" rel="noopener" class="mobile-drawer__card-link">
                Kirova 10/25
                <span class="mobile-drawer__card-link-icon" aria-hidden="true"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-navigate.svg' ); ?></span>
            </a>
        </div>
        <div class="mobile-drawer__card-row">
            <span class="mobile-drawer__card-label">News &amp; Events</span>
            <span class="mobile-drawer__socials">
                <a href="https://vk.ru/barsweetpepper" target="_blank" rel="noopener" class="mobile-drawer__icon-btn" aria-label="VK">
                    <img src="<?php echo $uri; ?>vk.svg" alt="" width="24" height="24">
                </a>
                <a href="https://instagram.com/barsweetpepper" target="_blank" rel="noopener" class="mobile-drawer__icon-btn" aria-label="Instagram">
                    <img src="<?php echo $uri; ?>insta.svg" alt="" width="24" height="24">
                </a>
            </span>
        </div>
    </div>

    <?php sweet_pepper_lang_switch( 'lang-switch--green' ); ?>

    <div class="mobile-drawer__cta">
        <h2 class="mobile-drawer__cta-title"><?php esc_html_e( 'Book your table', 'sweet-pepper' ); ?></h2>
        <?php
        get_template_part( 'template-parts/components/button', null, [
            'label'         => 'Call 911-202',
            'type'          => 'primary-green',
            'icon_left_svg' => 'icons/c-phone.svg',
            'url'           => 'tel:+74852911202',
        ] );
        ?>
        <div class="mobile-drawer__cta-row">
            <?php
            get_template_part( 'template-parts/components/button', null, [
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
    </div>

</div><!-- #mobile-drawer -->
