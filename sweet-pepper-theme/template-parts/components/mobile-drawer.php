<?php
/**
 * Mobile navigation drawer (Figma: Drawer-4-Home-Day 1341:51991, Drawer-4-Menu-Night 1341:51696)
 *
 * Full-screen, themed by day/night via the semantic tokens, under the site header: the
 * header stays where it is and its hamburger (`.js-drawer-toggle`) turns into the × that
 * closes — so the sheet has no header row, logo or × of its own (1 Oct 2026; the mockup
 * draws them). Also closed by the Escape key or resizing past the nav breakpoint
 * (mobile-drawer.js). Not a dialog: its close control lives outside it, in the header, so it
 * is the menu button's disclosure — the script makes the rest of the page inert while open.
 *
 * @package Sweet_Pepper
 */

$icons = get_template_directory() . '/assets/icons/';
$uri   = get_template_directory_uri() . '/assets/icons/';

// Order: Home · Menu · About · Visit — the header's and the footer's, the order website-brief.md
// → Top nav → Mobile decided (the Figma mockup drew Home · About · Menu · Visit; reordered 25 Sep
// 2026 with the Russian drawer copy, navigation-drawers-copy-ru-draft.md → 1).
// "late\u{2011}night": a non-breaking hyphen, so the description never splits there when it wraps.
$items = [
    [ 'label' => __( 'Home', 'sweet-pepper' ),  'desc' => __( 'A taste of Sweet Pepper', 'sweet-pepper' ),          'url' => home_url( '/' ),      'current' => is_front_page() ],
    [ 'label' => __( 'Menu', 'sweet-pepper' ),  'desc' => __( "From breakfast to late\u{2011}night drinks", 'sweet-pepper' ), 'url' => sweet_pepper_menu_url( 'food' ),  'current' => sweet_pepper_is_menu_page() ],
    [ 'label' => __( 'About', 'sweet-pepper' ), 'desc' => __( 'The place, the people, the story', 'sweet-pepper' ), 'url' => home_url( '/about' ), 'current' => is_page_template( 'page-about.php' ) || is_singular( 'vacancy' ) ],
    [ 'label' => __( 'Visit', 'sweet-pepper' ), 'desc' => __( 'Hours, directions and contacts', 'sweet-pepper' ),   'url' => home_url( '/visit' ), 'current' => is_page_template( 'page-visit.php' ) ],
];

// About and Visit are fixed compositions with a dark hero (website-brief.md → What themes
// and what doesn't), so their drawer is dark in every theme; Home and Menu follow data-theme.
// A vacancy page is About's child (its Careers section, /vacancies/…): dark too, with About
// lit as the section you are in (author, 28 Sep 2026).
$is_dark = is_page_template( 'page-about.php' ) || is_page_template( 'page-visit.php' ) || is_singular( 'vacancy' );

// Arrows go through sweet_pepper_inline_svg() per instance: this drawer is on every
// page, sits before the content, and is visibility: hidden on phones — a raw copy here
// owned the shared clipPath id and clipped every later raw copy on the page to nothing
// (menu highlight cards, Sep 2026). $arrow is rendered per item below.
$arrow  = '';
$marker = sweet_pepper_inline_svg( 'assets/icons/c-Pepper.svg' ); // "you are here" — the mockup's bare chili
?>
<div id="mobile-drawer" class="mobile-drawer<?php echo $is_dark ? ' mobile-drawer--dark' : ''; ?>" aria-hidden="true" inert>

    <nav class="mobile-drawer__nav" aria-label="<?php echo esc_attr( _x( 'Main', 'the navigation drawer nav', 'sweet-pepper' ) ); ?>">
        <ul class="mobile-drawer__list">
            <?php foreach ( $items as $item ) : ?>
            <li class="mobile-drawer__item">
                <a href="<?php echo esc_url( $item['url'] ); ?>" class="mobile-drawer__link<?php echo $item['current'] ? ' is-current' : ''; ?>"<?php echo $item['current'] ? ' aria-current="' . ( is_singular( 'vacancy' ) ? 'true' : 'page' ) . '"' : ''; ?>>
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
            <span class="mobile-drawer__card-label"><?php esc_html_e( 'Get Directions', 'sweet-pepper' ); ?></span>
            <a href="https://yandex.ru/maps/?rtext=~57.626100%2C39.884500" target="_blank" rel="noopener" class="mobile-drawer__card-link">
                <?php esc_html_e( 'Kirova 10/25', 'sweet-pepper' ); ?>
                <span class="mobile-drawer__card-link-icon" aria-hidden="true"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-navigate.svg' ); ?></span>
            </a>
        </div>
        <div class="mobile-drawer__card-row">
            <span class="mobile-drawer__card-label"><?php esc_html_e( 'News & Events', 'sweet-pepper' ); ?></span>
            <?php if ( sweet_pepper_show_instagram() ) : // inc/geo.php ?>
            <span class="mobile-drawer__socials">
                <?php // The icons open the pages; the buttons below write. The names say which (navigation-drawers-copy-ru-draft.md → 5). ?>
                <a href="https://vk.ru/barsweetpepper" target="_blank" rel="noopener" class="mobile-drawer__icon-btn" aria-label="<?php esc_attr_e( 'Sweet Pepper on VK', 'sweet-pepper' ); ?>">
                    <img src="<?php echo $uri; ?>vk.svg" alt="" width="24" height="24">
                </a>
                <a href="https://instagram.com/barsweetpepper" target="_blank" rel="noopener" class="mobile-drawer__icon-btn" aria-label="<?php esc_attr_e( 'Sweet Pepper on Instagram', 'sweet-pepper' ); ?>">
                    <img src="<?php echo $uri; ?>insta.svg" alt="" width="24" height="24">
                </a>
            </span>
            <?php else : // VK alone names itself, as «Маршрут» names its street (author, 28 Sep 2026): «ВКонтакте» fits one row in both languages, the handle does not in English ?>
            <a href="https://vk.ru/barsweetpepper" target="_blank" rel="noopener" class="mobile-drawer__card-link mobile-drawer__card-link--vk">
                <?php esc_html_e( 'VKontakte', 'sweet-pepper' ); ?>
                <img src="<?php echo $uri; ?>vk.svg" alt="" width="24" height="24">
            </a>
            <?php endif; ?>
        </div>
    </div>

    <?php sweet_pepper_lang_switch( 'lang-switch--green' ); ?>

    <div class="mobile-drawer__cta">
        <h2 class="mobile-drawer__cta-title"><?php esc_html_e( 'Book your table', 'sweet-pepper' ); ?></h2>
        <?php
        get_template_part( 'template-parts/components/button', null, [
            'label'         => __( 'Call 911-202', 'sweet-pepper' ),
            'aria_label'    => __( 'Call Sweet Pepper', 'sweet-pepper' ),
            'type'          => 'primary-green',
            'icon_left_svg' => 'icons/c-phone.svg',
            'url'           => 'tel:+74852911202',
        ] );
        ?>
        <div class="mobile-drawer__cta-row">
            <?php
            get_template_part( 'template-parts/components/button', null, [
                'label'         => __( 'VK message', 'sweet-pepper' ),
                'label_mobile'  => sweet_pepper_show_instagram() ? _x( 'VK message', 'short label, phone two-up row', 'sweet-pepper' ) : __( 'VK message', 'sweet-pepper' ), // the short one only beside Instagram
                'type'          => 'secondary',
                'icon_left_svg' => 'icons/vk.svg',
                'url'           => 'https://vk.me/barsweetpepper',
            ] );
            if ( sweet_pepper_show_instagram() ) { // alone, VK takes the row (flex: 1)
                get_template_part( 'template-parts/components/button', null, [
                    'label'         => __( 'Instagram DM', 'sweet-pepper' ),
                    'label_mobile'  => _x( 'Instagram DM', 'short label, phone two-up row', 'sweet-pepper' ),
                    'type'          => 'secondary',
                    'icon_left_svg' => 'icons/insta.svg',
                    'url'           => 'https://ig.me/m/barsweetpepper',
                ] );
            }
            ?>
        </div>
    </div>

</div><!-- #mobile-drawer -->
