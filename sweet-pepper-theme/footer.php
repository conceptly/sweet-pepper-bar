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
                        <?php esc_html_e( 'Top', 'sweet-pepper' ); ?>
                    </a>
                </div>

                <!-- Stamp Logo -->
                <div class="footer-stamp">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/stamp.svg" alt="<?php esc_attr_e( 'Sweet Pepper — Good Food & Drink Since 2014', 'sweet-pepper' ); ?>" class="stamp-img">
                </div>
                
                <!-- Navigation Columns -->
                <div class="footer-nav">
                    <!-- Go To -->
                    <div class="footer-col footer-col--nav">
                        <h3 class="footer-col-title"><?php esc_html_e( 'GO TO', 'sweet-pepper' ); ?></h3>
                        <?php
                        // The page you're on is the active item (Figma NavItem, mode=footer, 57:3227) —
                        // the same tests as the header nav.
                        $sp_here = static function ( $is ) {
                            return $is ? ' class="is-current" aria-current="page"' : '';
                        };
                        ?>
                        <ul class="footer-links">
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo $sp_here( is_front_page() ); ?>><?php esc_html_e( 'Home', 'sweet-pepper' ); ?></a></li>
                            <li><a href="<?php echo esc_url( sweet_pepper_menu_url( 'food' ) ); ?>"<?php echo $sp_here( sweet_pepper_is_menu_page() ); ?>><?php esc_html_e( 'Menu', 'sweet-pepper' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"<?php echo $sp_here( is_page_template( 'page-about.php' ) || is_singular( 'vacancy' ) ); ?>><?php esc_html_e( 'About', 'sweet-pepper' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/visit' ) ); ?>"<?php echo $sp_here( is_page_template( 'page-visit.php' ) ); ?>><?php esc_html_e( 'Visit', 'sweet-pepper' ); ?></a></li>
                            <?php // the list's one voiced name: replays the page loader here (inc/page-loader.php); the flame opens on hover ?>
                            <li><button type="button" class="footer-links__replay" data-loader-replay><span class="footer-links__flame"><?php echo sweet_pepper_inline_svg( 'assets/icons/fire.svg' ); ?></span><?php esc_html_e( 'Heat it up!', 'sweet-pepper' ); ?></button></li>
                        </ul>
                    </div>
                    
                    <!-- Hours -->
                    <div class="footer-col footer-col--hours">
                        <h3 class="footer-col-title"><?php esc_html_e( 'HOURS', 'sweet-pepper' ); ?></h3>
                        <div class="footer-hours-list">
                            <?php foreach ( sweet_pepper_bar_hours_rows() as $hours_row ) : // Bar Settings — inc/bar-hours.php ?>
                            <div class="hours-item">
                                <span class="hours-day"><?php echo esc_html( $hours_row[0] ); ?></span>
                                <span class="hours-time"><?php echo esc_html( $hours_row[1] ); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <!-- Visit — on phones a full-width contacts row: phone + address left, socials right -->
                    <div class="footer-col footer-col--visit">
                        <h3 class="footer-col-title"><?php esc_html_e( 'VISIT', 'sweet-pepper' ); ?></h3>
                        <div class="footer-contact-list">
                            <div class="contact-item contact-item--address">
                                <i class="ph ph-map-pin" aria-hidden="true"></i>
                                <span><?php esc_html_e( 'Kirova 10/25, Yaroslavl', 'sweet-pepper' ); ?></span>
                            </div>
                            <div class="contact-item contact-item--phone">
                                <i class="ph ph-phone" aria-hidden="true"></i>
                                <a href="tel:+74852911202">+7 (4852) 911-202</a>
                            </div>
                            <div class="contact-item contact-item--email">
                                <i class="ph ph-envelope-simple" aria-hidden="true"></i>
                                <a href="mailto:hello@sweetpepper.bar">hello@sweetpepper.bar</a>
                            </div>
                            <?php // VK leads (website-brief.md → News/social feed: chips out to VK (leading) and Instagram — inc/geo.php decides) ?>
                            <?php if ( sweet_pepper_show_instagram() ) : // inc/geo.php ?>
                            <div class="footer-socials">
                                <a href="https://vk.ru/barsweetpepper" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Sweet Pepper on VK', 'sweet-pepper' ); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/vk.svg" alt="" width="24" height="24">
                                </a>
                                <a href="https://instagram.com/barsweetpepper" target="_blank" rel="noopener" aria-label="<?php esc_attr_e( 'Sweet Pepper on Instagram', 'sweet-pepper' ); ?>">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/insta.svg" alt="" width="24" height="24">
                                </a>
                            </div>
                            <?php else : // VK alone names its address — a lone mark looked empty and hinted at a missing one (author, 28 Sep 2026) ?>
                            <div class="footer-socials footer-socials--handle">
                                <a href="https://vk.ru/barsweetpepper" target="_blank" rel="noopener">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/vk.svg" alt="" width="24" height="24">
                                    <span>vk.com/barsweetpepper</span>
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="container footer-bottom-container">
                <p class="footer-copyright">© <?php echo date('Y'); ?> Sweet Pepper Bar</p>
                <?php
                // The policy beside the map settings (author, 28 Sep 2026) — once the page is published, as in the cookie note
                $policy_page = get_page_by_path( 'privacy-policy' );
                $policy_url  = $policy_page && 'publish' === $policy_page->post_status ? get_permalink( $policy_page ) : '';
                ?>
                <span class="footer-legal">
                    <?php if ( $policy_url ) : ?>
                        <a href="<?php echo esc_url( $policy_url ); ?>" class="footer-legal__link"><?php echo 'ru' === sweet_pepper_lang() ? 'Политика конфиденциальности' : 'Privacy policy'; ?></a>
                    <?php endif; ?>
                    <?php // The consent text beside the policy (author, 29 Sep 2026) — shown before the page is published, on purpose, to judge its room and states ?>
                    <a href="<?php echo esc_url( sweet_pepper_consent_url() ); ?>" class="footer-legal__link"><?php echo 'ru' === sweet_pepper_lang() ? 'Согласие на обработку данных' : 'Consent to data processing'; ?></a>
                    <?php if ( ! sweet_pepper_maps_open() ) : ?>
                        <button type="button" class="map-settings-link" data-map-settings hidden><?php echo 'ru' === sweet_pepper_lang() ? 'Настройки карт' : 'Map settings'; ?></button>
                    <?php endif; ?>
                </span>
                <a href="#page" class="footer-back-to-top">
                    <?php esc_html_e( 'Back to top', 'sweet-pepper' ); ?> <i class="ph-bold ph-arrow-up" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </footer><!-- #colophon -->
</div><!-- #page -->

<?php get_template_part('template-parts/components/reserve-drawer'); ?>
<?php get_template_part('template-parts/components/map-preferences'); ?>

<?php get_template_part( 'template-parts/components/cookie-notice' ); // the bottom band by default (27 Sep 2026); ?notice=corner for the card, &pos=top to compare, ?notice=off for none ?>
<?php // Viewport foot (27 Sep 2026): Safari 26 on the iPhone extends the colour of the fixed element
      // that touches the viewport's bottom edge under its floating bar — nothing fixed there, and
      // the page shows through the glass. A 4px strip in the page's canvas colour is that element
      // (main.css → Viewport foot); touch screens only. ?>
<div class="viewport-foot" aria-hidden="true"></div>

<?php wp_footer(); ?>
</body>
</html>
