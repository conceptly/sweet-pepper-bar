<!-- Fixed Reserve Button -->
<div class="btn-fixed-wrapper js-reserve-trigger">
    <?php 
    get_template_part('template-parts/components/button', null, [
        'label' => __( 'Reserve', 'sweet-pepper' ),
        'type'  => 'primary',
        'icon'  => 'bell',
        'class' => 'btn-fixed'
    ]); 
    ?>
</div>

<!-- Reserve Drawer Overlay -->
<div class="reserve-drawer-overlay js-reserve-close"></div>

<?php
// The script's words — the state lines and the copy feedback — in the request's language
// (navigation-drawers-copy-ru-draft.md → 4); reserve-drawer.js merges them over its typed English.
// {opens} is the next opening, filled in by the script from Bar Settings.
$reserve_strings = [
    'states'      => [
        'available' => [ 'subtitle' => __( 'We’re open — tonight, just walk in or write ahead.', 'sweet-pepper' ), 'statusText' => __( 'All good — admin is on the phone', 'sweet-pepper' ) ],
        'busy'      => [ 'subtitle' => __( 'Full house tonight — writing beats calling.', 'sweet-pepper' ), 'statusText' => __( 'Might take a minute, it’s loud in here.', 'sweet-pepper' ) ],
        'closed'    => [ 'subtitle' => __( 'Closed for the night. Send a message, we’ll respond from {opens}!', 'sweet-pepper' ), 'statusText' => __( 'We’ll pick up from {opens}.', 'sweet-pepper' ) ],
    ],
    'copy'        => __( 'Copy', 'sweet-pepper' ),
    'copied'      => __( 'Copied!', 'sweet-pepper' ),
    'phoneCopied' => __( 'Copied to your clipboard!', 'sweet-pepper' ),
];
?>
<!-- Reserve Drawer
     Desktop: 420px panel from the right edge (Figma reserveModal-day/night).
     Phones (≤ 767px): bottom sheet, Figma reserveModal-mobile 1198:53322 — same content,
     ticket moves to the end. Messenger links draw ↗ (they leave the site) at every width. Open/close, focus and Escape
     handling live in src/js/reserve-drawer.js; slide-in is CSS (reserve-drawer.css). -->
<div class="reserve-drawer" id="reserve-drawer" role="dialog" aria-modal="true" aria-labelledby="reserve-title" aria-hidden="true" inert>
    <div class="reserve-drawer-accent-line"></div>
    
    <script type="application/json" class="reserve-drawer__strings"><?php echo wp_json_encode( $reserve_strings ); ?></script>
    <button type="button" class="reserve-drawer-close js-reserve-close" aria-label="<?php esc_attr_e( 'Close drawer', 'sweet-pepper' ); ?>">
        <i class="ph ph-x" aria-hidden="true"></i>
    </button>
    
    <div class="reserve-drawer-content">
        <div class="reserve-header">
            <h2 class="reserve-title" id="reserve-title"><?php esc_html_e( 'YOUR TABLE', 'sweet-pepper' ); ?></h2>
            <!-- Subtitle text is updated by JS based on bar state -->
            <p class="reserve-subtitle"><?php echo esc_html( $reserve_strings['states']['available']['subtitle'] ); ?></p>
        </div>
        
        <div class="reserve-ticket-wrapper">
            <!-- Top edge: absolutely positioned, bites into card from above.
                 Colours come from the drawer's own tokens (reserve-drawer.css) so the
                 edges follow the ground on every breakpoint and theme. -->
            <div class="ticket-top-edge">
                <?php get_template_part('template-parts/components/rugged-edge', null, ['color' => 'reserve-ground']); ?>
            </div>
            
            <!-- Card: in flow, padding handles space for the top edge -->
            <div class="reserve-ticket">
                <h3 class="ticket-title"><?php esc_html_e( 'STEAL THE LINE', 'sweet-pepper' ); ?></h3>
                <p class="ticket-text" id="ticket-message"><?php esc_html_e( 'Hi! A table for two, tomorrow around 21:00 — doable?', 'sweet-pepper' ); ?></p>
                <button type="button" class="btn-copy-ticket js-copy" data-copy-target="#ticket-message">
                    <span class="btn-copy-label"><?php echo esc_html( $reserve_strings['copy'] ); ?></span>
                    <span class="btn-copy-icon btn-copy-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                    <span class="btn-copy-icon btn-copy-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                </button>
            </div>
            
            <!-- Bottom edge: in flow, flush with card (0 gap via flex) -->
            <?php get_template_part('template-parts/components/rugged-edge', null, ['color' => 'reserve-card']); ?>
        </div>
        
        <div class="reserve-actions">
            <!-- Phone CTA: 3 bar states (available/busy/closed) -->
            <div class="phone-cta-wrapper" data-bar-state="available">
                <button type="button" class="btn-call js-copy" data-copy-text="+74852911202">
                    <span class="btn-call-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-phone.svg' ); ?></span>
                    <span class="btn-call-label">+7 (4852) 911-202</span>
                    <span class="btn-copy-icon btn-copy-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                    <span class="btn-copy-icon btn-copy-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                </button>
                <?php // All three status icons ship in the markup; CSS shows the one the
                      // wrapper's [data-bar-state] names (reserve-drawer.js sets that). The busy
                      // state is a CSS dot — the library has no plain circle, and the house already
                      // draws status dots that way (the Visit rail). ?>
                <div class="call-status">
                    <span class="call-status-icon">
                        <span class="call-status-icon--available"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
                        <span class="call-status-icon--busy" aria-hidden="true"></span>
                        <span class="call-status-icon--closed"><?php echo sweet_pepper_inline_svg( 'assets/icons/sleep.svg' ); ?></span>
                    </span>
                    <span class="call-status-text"></span>
                </div>
            </div>
            
            <a href="https://vk.me/barsweetpepper" class="btn-social btn-social-vk" target="_blank" rel="noopener">
                <div class="btn-social-left">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/vk.svg" alt="VK" width="20" height="20" class="btn-social-icon">
                    <?php esc_html_e( 'VK message', 'sweet-pepper' ); ?>
                </div>
                <span class="btn-social-arrow"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
            </a>
            
            <a href="https://ig.me/m/barsweetpepper" class="btn-social btn-social-ig" target="_blank" rel="noopener">
                <div class="btn-social-left">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/insta.svg" alt="Instagram" width="20" height="20" class="btn-social-icon">
                    <?php esc_html_e( 'Instagram DM', 'sweet-pepper' ); ?>
                </div>
                <span class="btn-social-arrow"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
            </a>
        </div>
        
        <p class="reserve-footer-text">
            <?php esc_html_e( 'Walk-ins always welcome — booking matters Friday–Saturday evenings.', 'sweet-pepper' ); ?>
        </p>
    </div>
</div>
