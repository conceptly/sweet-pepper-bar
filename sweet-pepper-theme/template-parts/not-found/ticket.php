<?php
/**
 * The 404 page's ticket (PROTOTYPE, 1 Oct 2026) — the dish picker's card with other words
 * in it: the same wrap, edges, card and type classes (dish-picker.css), so the slip is the
 * site's one ticket. It prints on arrival (data-reveal="mask-down", reveal.js).
 *
 * @param array $args {
 *     @type array  $ticket label · note · says · reply · cta (data/not-found.php)
 *     @type string $asked  The address the guest asked for (inc/not-found.php)
 * }
 */

$ticket = $args['ticket'] ?? [];
$asked  = $args['asked'] ?? '/';
?>
<div class="dish-picker__card-wrap not-found__ticket" data-reveal="mask-down">
    <div class="dish-picker__card-edge-top" aria-hidden="true">
        <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'peppercorn' ] ); ?>
    </div>

    <div class="dish-picker__card">
        <p class="dish-picker__card-label molot-text"><?php echo esc_html( $ticket['label'] ); ?></p>

        <div class="dish-picker__dish">
            <p class="dish-picker__dish-name not-found__asked"><?php echo esc_html( $asked ); ?></p>
            <p class="dish-picker__dish-desc"><?php echo esc_html( $ticket['note'] ); ?></p>
        </div>

        <div class="dish-picker__pairing">
            <p class="dish-picker__pairing-slogan"><?php echo esc_html( $ticket['says'] ); ?></p>
            <p class="dish-picker__pairing-name"><?php echo esc_html( $ticket['reply'] ); ?></p>
        </div>

        <a class="dish-picker__cta" href="<?php echo esc_url( sweet_pepper_menu_url( 'food', 'hot-dishes' ) ); ?>">
            <span><?php echo esc_html( $ticket['cta'] ); ?></span>
            <span class="dish-picker__cta-icon" aria-hidden="true">
                <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 6H11M11 6L6.5 1.5M11 6L6.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        </a>
    </div>

    <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'paper' ] ); ?>
</div>
