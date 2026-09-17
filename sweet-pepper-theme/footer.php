<?php
/**
 * The template for displaying the footer
 *
 * @package Sweet_Pepper
 */
?>

    <footer id="colophon" class="site-footer">
        <!-- Rugged edge top — color matches the preceding section's background -->
        <div class="footer-rugged-top">
            <?php get_template_part('template-parts/components/rugged-edge', null, ['color' => 'parchment']); ?>
        </div>
        
        <div class="footer-main">
            <div class="container footer-main-container">
                <!-- Phones only (Figma footer-mobile 1245:39505): 24px Symbol + Molot wordmark, "Top" link -->
                <div class="footer-mobile-top">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="footer-mini-brand">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/symbol.svg" alt="" width="24" height="24" class="footer-mini-brand__symbol" aria-hidden="true">
                        <span class="footer-mini-brand__name molot-text">Sweet Pepper Bar</span>
                    </a>
                    <a href="#page" class="footer-top-link">
                        <span class="footer-top-link__icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/arrow-up.svg' ); ?></span>
                        Top
                    </a>
                </div>

                <!-- Stamp Logo -->
                <div class="footer-stamp">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/stamp.svg" alt="Sweet Pepper — Good Food & Drink Since 2014" class="stamp-img">
                </div>
                
                <!-- Navigation Columns -->
                <div class="footer-nav">
                    <!-- Go To -->
                    <div class="footer-col footer-col--nav">
                        <h3 class="footer-col-title">GO TO</h3>
                        <ul class="footer-links">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/menu' ) ); ?>">Menu</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a></li>
                            <li><a href="<?php echo esc_url( home_url( '/visit' ) ); ?>">Visit</a></li>
                        </ul>
                    </div>
                    
                    <!-- Hours -->
                    <div class="footer-col footer-col--hours">
                        <h3 class="footer-col-title">HOURS</h3>
                        <div class="footer-hours-list">
                            <div class="hours-item">
                                <span class="hours-day">Mon–Sat</span>
                                <span class="hours-time">08:30 — 02:00</span>
                            </div>
                            <div class="hours-item">
                                <span class="hours-day">Sunday</span>
                                <span class="hours-time">10:00 — 02:00</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Visit — on phones a full-width contacts row: phone + address left, socials right -->
                    <div class="footer-col footer-col--visit">
                        <h3 class="footer-col-title">VISIT</h3>
                        <div class="footer-contact-list">
                            <div class="contact-item contact-item--address">
                                <i class="ph ph-map-pin"></i>
                                <span>Kirova 10/25, Yaroslavl</span>
                            </div>
                            <div class="contact-item contact-item--phone">
                                <i class="ph ph-phone"></i>
                                <a href="tel:+74852911202">+7 (4852) 911-202</a>
                            </div>
                            <div class="contact-item contact-item--email">
                                <i class="ph ph-envelope-simple"></i>
                                <a href="mailto:hello@sweetpepper.ru">hello@sweetpepper.ru</a>
                            </div>
                            <!-- VK leads (website-brief.md → News/social feed: chips out to VK (leading) and Instagram) -->
                            <div class="footer-socials">
                                <a href="https://vk.ru/barsweetpepper" target="_blank" rel="noopener">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/vk.svg" alt="VK" width="24" height="24">
                                </a>
                                <a href="https://instagram.com/barsweetpepper" target="_blank" rel="noopener">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/insta.svg" alt="Instagram" width="24" height="24">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="container footer-bottom-container">
                <p class="footer-copyright">© <?php echo date('Y'); ?> Sweet Pepper Bar</p>
                <a href="#page" class="footer-back-to-top">
                    Back to top <i class="ph-bold ph-arrow-up"></i>
                </a>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php get_template_part('template-parts/components/reserve-drawer'); ?>

<?php wp_footer(); ?>
</body>
</html>
