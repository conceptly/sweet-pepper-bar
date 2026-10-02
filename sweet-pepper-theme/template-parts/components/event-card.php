<?php
/**
 * Template part for displaying an event/news card
 *
 * Card with 4:5 image and a fixed-height body overlay (98px, absolute bottom).
 * One copy stack — date, title, CTA — that re-arranges on hover (no layout shift):
 *   - Rest: date + title; the CTA waits below the band, transparent
 *   - Hover: the date fades, the title and the CTA rise 26px
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
 *     @type bool   $plain_date  The date is when the post was published, not an event's day: no "Today!" (the VK feed).
 * }
 */

$image_url = $args['image_url'] ?? '';
$image_alt = $args['image_alt'] ?? '';
$title     = $args['title'] ?? '';
$date      = $args['date'] ?? '';
$category  = $args['category'] ?? '';
$url       = $args['url'] ?? '#'; // '' = no link: an Instagram post where Instagram may not show (inc/geo.php)
$source    = $args['source'] ?? 'instagram'; // '' with no link: no brand mark, no CTA
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
if ( $date && empty( $args['plain_date'] ) ) {
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
if ( '' === $url ) {
    $card_classes .= ' event-card--static';
}
?>
<?php if ( '' === $url ) : ?>
<div class="<?php echo esc_attr( $card_classes ); ?>">
<?php else : ?>
<a class="<?php echo esc_attr( $card_classes ); ?>" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer">
<?php endif; ?>
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

    <!-- Body overlay (absolute bottom, fixed 98px). One stack, as in Figma's auto layout: on hover
         the date fades, the title rises into its place and the CTA rises in from below the band
         (Smart Animate, Gentle — events.css → Hover motion). -->
    <div class="event-card-body">
        <div class="event-card-copy">
            <?php if ( $date ) : ?>
                <div class="event-card-date<?php echo $is_today ? ' event-card-date--today' : ''; ?>">
                    <span><?php echo $display_date; ?></span>
                    <?php // Touch has no hover layer: the source's brand mark rides the date row instead
                          // (Figma instagram-feed-cards-mobile 1260:40711, day + pinned states). Shown where the card
                          // takes the phone body — up to 991 wide and on any screen with no hover (events.css → The
                          // touch card); hidden on the desktop card;
                          // decorative — the whole card is the link. A PHP comment, so the page's source never names Instagram where it may not show. ?>
                    <?php if ( $source ) : ?>
                        <img class="event-card-source" src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/' . ( $source === 'vk' ? 'vk.svg' : 'insta.svg' ) ); ?>" alt="" width="16" height="16" aria-hidden="true">
                    <?php endif; ?>
                </div>
            <?php else : ?>
                <!-- No date: the row still holds its line + 8px, so the title sits where the hover expects it -->
                <div class="event-card-date event-card-date--empty" aria-hidden="true"></div>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <p class="event-card-title molot-text"><?php echo esc_html( $title ); ?></p>
            <?php endif; ?>

            <?php if ( '' !== $url ) : ?>
            <div class="event-card-cta">
                <span class="event-card-cta-text"><?php echo esc_html( $cta_text ); ?></span>
                <svg class="event-card-cta-arrow" width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                    <path d="M2.5 6H9.5M9.5 6L6.5 3M9.5 6L6.5 9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <?php endif; ?>
        </div>
    </div>
<?php echo '' === $url ? '</div>' : '</a>'; ?>
