<?php
/**
 * Template part for displaying an event/news card
 *
 * Card with 4:5 image and a fixed-height body overlay (98px, absolute bottom).
 * Two content layers crossfade on hover (no layout shift):
 *   - Default layer: date + title
 *   - Hover layer: title + CTA link
 *
 * Supports 3 states: default (CSS), hover (CSS), pinned (class).
 *
 * @param array $args {
 *     @type string $image_url   URL of the event photo.
 *     @type string $image_alt   Alt text for the image.
 *     @type string $title       Event title (displayed in Molot H3).
 *     @type string $date        Date string (e.g. "12 Oct").
 *     @type string $category    One of: 'event', 'promo', 'community' — pill badge.
 *     @type string $url         Link to VK/IG post.
 *     @type string $source      'instagram' or 'vk' — drives CTA text.
 *     @type bool   $pinned      Whether the card is in the pinned (featured) state.
 * }
 */

$image_url = $args['image_url'] ?? '';
$image_alt = $args['image_alt'] ?? '';
$title     = $args['title'] ?? '';
$date      = $args['date'] ?? '';
$category  = $args['category'] ?? '';
$url       = $args['url'] ?? '#';
$source    = $args['source'] ?? 'instagram';
$pinned    = $args['pinned'] ?? false;

// Category labels for the image pill
$category_labels = [
    'event'     => __( 'Event', 'sweet-pepper' ),
    'promo'     => __( 'Promo', 'sweet-pepper' ),
    'community' => __( 'Community', 'sweet-pepper' ),
];
$badge_label = $category_labels[ $category ] ?? '';

// CTA text based on source
$cta_text = $source === 'vk' ? __( 'See it on VK', 'sweet-pepper' ) : __( 'See it on Instagram', 'sweet-pepper' );

// "Today!" detection
$is_today = false;
if ( $date ) {
    $date_timestamp = strtotime( $date );
    if ( $date_timestamp && date( 'Y-m-d', $date_timestamp ) === date( 'Y-m-d' ) ) {
        $is_today = true;
    }
}
$display_date = $is_today ? esc_html__( 'Today!', 'sweet-pepper' ) : esc_html( $date );

// Card classes
$card_classes = 'event-card';
if ( $pinned ) {
    $card_classes .= ' event-card--pinned';
}
?>
<a class="<?php echo esc_attr( $card_classes ); ?>" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
    <!-- Image (drives card height via 4:5 aspect ratio) -->
    <div class="event-card-img-wrap">
        <?php if ( $image_url ) : ?>
            <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="event-card-img" loading="lazy">
        <?php endif; ?>

        <?php if ( $badge_label ) : ?>
            <span class="event-card-pill event-card-pill--<?php echo esc_attr( $category ); ?>">
                <?php echo esc_html( $badge_label ); ?>
            </span>
        <?php endif; ?>
    </div>

    <!-- Body overlay (absolute bottom, fixed 98px) -->
    <div class="event-card-body">
        <!-- Default layer: date + title (fades out on hover) -->
        <div class="event-card-default">
            <?php if ( $date ) : ?>
                <div class="event-card-date<?php echo $is_today ? ' event-card-date--today' : ''; ?>">
                    <span><?php echo $display_date; ?></span>
                    <!-- Phones have no hover layer: the source's brand mark rides the date row instead
                         (Figma instagram-feed-cards-mobile 1260:40711, day + pinned states). Hidden on desktop;
                         decorative — the whole card is the link. -->
                    <img class="event-card-source" src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/' . ( $source === 'vk' ? 'vk.svg' : 'insta.svg' ) ); ?>" alt="" width="16" height="16" aria-hidden="true">
                </div>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <p class="event-card-title molot-text"><?php echo esc_html( $title ); ?></p>
            <?php endif; ?>
        </div>

        <!-- Hover layer: title + CTA (fades in on hover) -->
        <div class="event-card-hover">
            <?php if ( $title ) : ?>
                <p class="event-card-title molot-text"><?php echo esc_html( $title ); ?></p>
            <?php endif; ?>

            <div class="event-card-cta">
                <span class="event-card-cta-text"><?php echo esc_html( $cta_text ); ?></span>
                <svg class="event-card-cta-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.5 6H9.5M9.5 6L6.5 3M9.5 6L6.5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
    </div>
</a>
