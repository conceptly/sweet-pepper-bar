<?php
/**
 * The header for our theme
 *
 * @package Sweet_Pepper
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'sweet-pepper' ); ?></a>

    <header id="masthead" class="site-header">
        <div class="container header-container">
            <div class="site-branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="logo-link">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/symbol.svg" alt="Sweet Pepper" width="38" height="53" class="logo-symbol">
                    <!-- Mobile only: flat Chili wordmark (Figma topNavContainer breakpoint=mobile, logo=full) -->
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/wordmark.svg" alt="" width="159" height="16" class="logo-wordmark" aria-hidden="true">
                </a>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
                <ul>
                    <li<?php if ( is_front_page() ) echo ' class="current-menu-item"'; ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                    <li<?php if ( is_page_template( 'page-menu.php' ) ) echo ' class="current-menu-item"'; ?>><a href="<?php echo esc_url( home_url( '/menu' ) ); ?>">Menu</a></li>
                    <li<?php if ( is_page_template( 'page-about.php' ) ) echo ' class="current-menu-item"'; ?>><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
                    <li<?php if ( is_page_template( 'page-visit.php' ) ) echo ' class="current-menu-item"'; ?>><a href="<?php echo esc_url( home_url( '/visit' ) ); ?>">Visit</a></li>
                </ul>
            </nav><!-- #site-navigation -->

            <div class="header-utils">
                <div class="whats-on-chip">
                    <span class="label">What's new</span>
                    <div class="social-icons">
                        <a href="https://instagram.com/barsweetpepper" target="_blank" rel="noopener" class="social-icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/insta.svg" alt="Instagram" width="24" height="24">
                        </a>
                        <a href="https://vk.ru/barsweetpepper" target="_blank" rel="noopener" class="social-icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/vk.svg" alt="VK" width="24" height="24">
                        </a>
                    </div>
                </div>
                <div class="lang-switch">
                    <button class="lang-option">РУС</button>
                    <button class="lang-option active">EN</button>
                </div>
            </div>

            <!-- Mobile Menu Toggle -->
            <button class="menu-toggle js-drawer-open" aria-controls="mobile-drawer" aria-expanded="false" aria-label="<?php esc_attr_e( 'Open menu', 'sweet-pepper' ); ?>">
                <?php echo file_get_contents( get_template_directory() . '/assets/icons/c-hamburger.svg' ); ?>
            </button>
        </div><!-- .header-container -->
    </header><!-- #masthead -->

    <?php get_template_part( 'template-parts/components/mobile-drawer' ); ?>


