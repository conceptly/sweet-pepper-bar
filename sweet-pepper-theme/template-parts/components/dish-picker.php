<?php
/**
 * Dish Picker Component
 *
 * A reusable interactive component: the guest picks a dish tag,
 * the bar answers with a drink pairing on a "printed" ticket card.
 * Used on the menu page (pairing station) and planned for the About page.
 *
 * Figma: picker-day (860:29520), picker-night; Shake It! states 2437:71646 / 2437:72125
 *
 * @param array $args {
 *     @type array  $pairings       Array of pairing data. Each entry:
 *           - slug          (string) Unique identifier
 *           - dish          (string) Dish name displayed on tag + card
 *           - description   (string) Short dish description
 *           - food_img      (string) Path relative to assets/images/
 *           - bar_img       (string) Path relative to assets/images/
 *           - pairing       (string) Drink pairing text
 *           - bar_section   (string) Bar section anchor (e.g. 'infusions')
 *     @type int    $default_index  Index of the initially selected pairing. Default: 0.
 * }
 */

$pairings      = $args['pairings'] ?? [];
$default_index = $args['default_index'] ?? 0;

if ( empty( $pairings ) ) {
    return;
}

$img_base   = get_template_directory_uri() . '/assets/images/';
$theme_dir  = get_template_directory();
$default    = $pairings[ $default_index ];
?>

<div class="dish-picker" data-default-index="<?php echo esc_attr( $default_index ); ?>">

    <!-- Inline JSON data for JS -->
    <script class="dish-picker__data" type="application/json"><?php
        echo wp_json_encode( array_map( function ( $p ) use ( $img_base ) {
            return [
                'slug'        => $p['slug'],
                'dish'        => $p['dish'],
                'cardName'    => $p['card_name'] ?? $p['dish'],
                'description' => $p['description'],
                'foodImg'     => $img_base . $p['food_img'],
                'barImg'      => $img_base . $p['bar_img'],
                'pairing'     => $p['pairing'],
                'barSection'  => $p['bar_section'],
            ];
        }, $pairings ) );
    ?></script>

    <!-- Labels row: the dish tags (Shake It! lives between the photos) -->
    <div class="dish-picker__labels-row">
        <div class="dish-picker__labels">
            <?php foreach ( $pairings as $i => $p ) : ?>
                <button
                    class="dish-picker__tag<?php echo $i === $default_index ? ' is-active' : ''; ?>"
                    type="button"
                    data-index="<?php echo esc_attr( $i ); ?>"
                    aria-pressed="<?php echo $i === $default_index ? 'true' : 'false'; ?>"
                >
                    <?php echo esc_html( $p['dish'] ); ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Result: photos + card -->
    <div class="dish-picker__result">

        <!-- Photo pair -->
        <div class="dish-picker__photos">
            <div class="dish-picker__photo-food">
                <img src="<?php echo esc_url( $img_base . $default['food_img'] ); ?>"
                     alt="<?php echo esc_attr( $default['dish'] ); ?>"
                     loading="lazy">
            </div>
            <!-- Shake It! — the shaker joins the plate and the glass (it replaced the "x").
                 Figma: shakeItContainer-desktop / -mobile (2437:71646 / 2437:72125) -->
            <div class="dish-picker__shake">
                <button class="dish-picker__shake-it" type="button" aria-label="Shake it — pick a random dish">
                    <span class="dish-picker__shake-disc">
                        <span class="dish-picker__shake-icon">
                            <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/icons/sweetPepperLogo.svg' ); ?>"
                                 alt="" width="24" height="24">
                        </span>
                    </span>
                </button>
            </div>
            <div class="dish-picker__photo-bar">
                <img src="<?php echo esc_url( $img_base . $default['bar_img'] ); ?>"
                     alt="<?php echo esc_attr( $default['pairing'] ); ?>"
                     loading="lazy">
            </div>
        </div>

        <!-- Ticket card — follows reserve-drawer rugged edge pattern:
             wrapper = overflow:hidden (clip), top edge = absolute, card = in flow, bottom edge = in flow -->
        <div class="dish-picker__card-wrap">
            <!-- Top rugged edge: abs positioned, floats over card from above -->
            <div class="dish-picker__card-edge-top" aria-hidden="true">
                <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'surface' ] ); ?>
            </div>

            <!-- Card: in normal flow, top padding absorbs the rugged edge overlap -->
            <div class="dish-picker__card">
                <h3 class="dish-picker__card-label molot-text">Your Match</h3>

                <div class="dish-picker__dish">
                    <p class="dish-picker__dish-name"><?php echo esc_html( $default['card_name'] ?? $default['dish'] ); ?></p>
                    <p class="dish-picker__dish-desc"><?php echo esc_html( $default['description'] ); ?></p>
                </div>

                <div class="dish-picker__pairing">
                    <p class="dish-picker__pairing-slogan">+ unforgettable with</p>
                    <p class="dish-picker__pairing-name"><?php echo esc_html( $default['pairing'] ); ?></p>
                </div>

                <a class="dish-picker__cta"
                   href="<?php echo esc_url( home_url( '/menu/?menu=drinks#' . $default['bar_section'] ) ); ?>">
                    <span>See this drink</span>
                    <span class="dish-picker__cta-icon" aria-hidden="true">
                        <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 6H11M11 6L6.5 1.5M11 6L6.5 10.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            </div>

            <!-- Bottom rugged edge: in normal flow, flush with card -->
            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'paper' ] ); ?>
        </div>

    </div><!-- /.dish-picker__result -->

</div><!-- /.dish-picker -->
