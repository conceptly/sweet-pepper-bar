<?php
/**
 * About page — How It Feels section
 *
 * Light section (surface bg). Two-column: word cloud left, quote wheel right.
 * Words are row-grouped to form a tapered diamond shape per Figma.
 * Each word carries a tier (top/mid/low) and a per-word font size from the design.
 *
 * Outline → fill state: all words idle as outlined Molot text; the active word
 * fills with its tier colour. One clock drives the fill + quote wheel (JS).
 *
 * Quote data: real excerpts from Yandex and Google reviews (about-reviews.md).
 * Each quote links to a cloud word via data-word attribute.
 *
 * Content comes as args from sweet_pepper_about_reviews() (inc/about-data.php) — the About page's «Отзывы» tab.
 *
 * @param array $args eyebrow · headline · headline_2 · quotes[] (id, text, text_en, platform, footnote, link, word)
 *
 * @package Sweet_Pepper
 */

// Word cloud: words sourced from about-reviews.md. 'text' is the English display word AND the
// key the quotes link to (data-key / data-word) — it never changes with the language; 'ru' is
// the Russian display word (the ledger's RU heading word, 22 Sep 2026: adverbs, so the cloud
// answers КАК ЗДЕСЬ БЫВАЕТ). A word without 'ru' shows its English on the Russian page.
// Rows are the no-JS / pre-hydration fallback; JS spiral-places them.
// Tiers by review frequency: top = 2+ reviews, mid = 1, low = 1 (supporting).
// Sizes tied 1:1 to tiers: top = 56, mid = 36, low = 24.
// 'phone' => false keeps a word — and the quotes linked to it — off phones (< 768), where the
// field is 328–370px wide and WIDE words are what cost height: the four widest mid-tier words
// are out (author, 21 Sep 2026; website-brief.md → Mobile — About → How it feels). Dropping the
// small ones instead saves nothing — they fill the gaps. how-it-feels.js removes the flagged
// nodes at load; its FIELD_AREA_PHONE is tuned to this list.
$cloud_rows = [
    [
        [ 'text' => 'cosy',     'ru' => 'уютно',          'tier' => 'top', 'size' => 56 ],  // Y01, G05
        [ 'text' => 'welcoming','ru' => 'радушно',        'tier' => 'top', 'size' => 56 ],  // Y03, G03
        [ 'text' => 'beloved',  'ru' => 'душевно',        'tier' => 'mid', 'size' => 36 ],  // Y05
    ],
    [
        [ 'text' => 'friendly', 'ru' => 'дружелюбно',     'tier' => 'top', 'size' => 56 ],  // Y07, G01
        [ 'text' => 'happy',    'ru' => 'радостно',       'tier' => 'mid', 'size' => 36 ],  // Y02
        [ 'text' => 'attentive','ru' => 'внимательно',    'tier' => 'low', 'size' => 24 ],  // G02
    ],
    [
        [ 'text' => 'perfect',  'ru' => 'идеально',       'tier' => 'mid', 'size' => 36 ],  // Y08
        [ 'text' => 'inviting', 'ru' => 'тепло',          'tier' => 'top', 'size' => 56 ],  // Y04, G04
        [ 'text' => 'magnetic', 'ru' => 'притягательно',  'tier' => 'mid', 'size' => 36, 'phone' => false ],  // Y09
    ],
    [
        [ 'text' => 'sociable', 'ru' => 'дружно',         'tier' => 'mid', 'size' => 36 ],  // Y06
        [ 'text' => 'wonderful','ru' => 'чудесно',        'tier' => 'mid', 'size' => 36, 'phone' => false ],  // Y11
        [ 'text' => 'lively',   'ru' => 'весело',         'tier' => 'low', 'size' => 24 ],  // Y10
    ],
    [
        [ 'text' => 'pleasant', 'ru' => 'приятно',        'tier' => 'mid', 'size' => 36, 'phone' => false ],  // Y12
        [ 'text' => 'charming', 'ru' => 'обаятельно',     'tier' => 'mid', 'size' => 36, 'phone' => false ],  // Y13
        [ 'text' => 'kind',     'ru' => 'вежливо',        'tier' => 'low', 'size' => 24 ],  // Y14
        [ 'text' => 'inclusive','ru' => 'для всех',       'tier' => 'low', 'size' => 24 ],  // Y15
    ],
];

// Words flagged off phones, for the markup below.
$phone_off = [];
foreach ( $cloud_rows as $row ) {
    foreach ( $row as $word ) {
        if ( isset( $word['phone'] ) && false === $word['phone'] ) {
            $phone_off[] = $word['text'];
        }
    }
}

// The default active word (filled on load, before JS takes over).
$default_active = 'welcoming';

// Quote cards — the About page's «Отзывы» tab (sweet_pepper_about_reviews()); each links to a
// cloud word via 'word'. text = the Russian original; text_en = the English.
$quotes = $args['quotes'];

// One language per request (inc/lang.php): the cloud's display words and the quote text follow it.
$is_ru = ( 'ru' === sweet_pepper_lang() );

// CTA link.
$yandex_reviews_url = 'https://yandex.com/maps/org/sweet_pepper/237019392845/reviews/?ll=39.888343%2C57.626024&z=17';
?>

<section id="how-it-feels" class="about-section about-section--light about-section--surface about-how-it-feels">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'wordOfMouth', 'position' => 'head', 'alt' => 'Word of mouth' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'    => $args['eyebrow'],
            'headline'   => $args['headline'],
            'headline_2' => $args['headline_2'],
        ] );
        ?>

        <div class="about-how-it-feels__inner">
            <!-- Word Cloud (left column) -->
            <div class="about-how-it-feels__cloud">
                <div class="about-cloud about-cloud--field">
                    <?php
                    /*
                     * Hue is decoupled from tier (author, Sep 2026): six stops across the red and
                     * green ramps plus Ash, dealt round-robin in template order so the mix is even,
                     * stable across visits, and no longer puts every red at the field's centre
                     * (the field seats the largest words first, and the largest were all Chili).
                     * Paprika only clears contrast on Parchment at display size, so it is kept for
                     * the top tier and swapped for Chili below it. Size = tier is untouched — that is
                     * the honesty carrier.
                     */
                    $hues     = [ 'chili', 'deep-chili', 'olive', 'paprika', 'avocado', 'ash' ];
                    $hue_i    = 0;
                    foreach ( $cloud_rows as $row ) : ?>
                        <div class="about-cloud__row">
                            <?php foreach ( $row as $word ) :
                                $is_active = ( $word['text'] === $default_active );
                                $hue       = $hues[ $hue_i++ % count( $hues ) ];
                                if ( 'paprika' === $hue && 'top' !== $word['tier'] ) {
                                    $hue = 'chili';
                                }
                            ?>
                                <span
                                    class="about-cloud-word<?php echo $is_active ? ' is-active' : ''; ?>"
                                    data-tier="<?php echo esc_attr( $word['tier'] ); ?>"
                                    data-hue="<?php echo esc_attr( $hue ); ?>"
                                    data-key="<?php echo esc_attr( $word['text'] ); ?>"
                                    <?php if ( in_array( $word['text'], $phone_off, true ) ) : ?>data-phone="off"<?php endif; ?>
                                    style="--cloud-size: <?php echo esc_attr( $word['size'] ); ?>px"
                                >
                                    <?php echo esc_html( ( $is_ru && ! empty( $word['ru'] ) ) ? $word['ru'] : $word['text'] ); ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Quote Wheel (right column) -->
            <div class="about-how-it-feels__quotes">
                <div class="about-how-it-feels__quotes-viewport">
                    <div class="about-how-it-feels__quotes-track">
                        <?php
                        foreach ( $quotes as $i => $quote ) :
                            // Pick quote text by locale.
                            $display_text = $is_ru
                                ? $quote['text']
                                : ( ! empty( $quote['text_en'] ) ? $quote['text_en'] : $quote['text'] );

                            // Alternating tilt: -1, +1, -1…
                            $rotation = ( $i % 2 === 0 ) ? -1 : 1;
                        ?>
                            <div
                                class="about-quote-card__wrap"
                                style="--card-rotate: <?php echo $rotation; ?>deg"
                                data-quote-id="<?php echo esc_attr( $quote['id'] ); ?>"
                                data-word="<?php echo esc_attr( $quote['word'] ); ?>"
                                <?php if ( in_array( $quote['word'], $phone_off, true ) ) : ?>data-phone="off"<?php endif; ?>
                            >
                                <div class="about-quote-card">
                                    <span class="about-quote-card__mark" aria-hidden="true">&ldquo;</span>
                                    <div class="about-quote-card__content">
                                        <p class="about-quote-card__text"><?php echo esc_html( $display_text ); ?></p>
                                        <span class="about-quote-card__source">
                                            <?php echo esc_html( $quote['platform'] ); ?>
                                            <?php if ( ! empty( $quote['link'] ) ) :
                                                // EN: the card is a translation, so the link offers the original.
                                                // RU: the card IS the original, so the link just opens the review
                                                // (about-page-copy-ru-draft.md → 3. Отзывы: «Читать в источнике»).
                                                if ( $is_ru ) : ?>
                                                · <a href="<?php echo esc_url( $quote['link'] ); ?>" class="about-quote-card__original" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Read the review', 'sweet-pepper' ); ?></a>
                                                <?php else : ?>
                                                · <a href="<?php echo esc_url( $quote['link'] ); ?>" class="about-quote-card__original" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Read the Russian original', 'sweet-pepper' ); ?>"><?php esc_html_e( 'Russian original', 'sweet-pepper' ); ?></a>
                                                <?php endif;
                                            endif; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="about-how-it-feels__cta">
                    <?php
                    get_template_part( 'template-parts/components/button', null, [
                        'label'          => __( 'Add your word', 'sweet-pepper' ),
                        'url'            => esc_url( $yandex_reviews_url ),
                        'variant'        => 'primary-green',
                        'type'           => 'primary-green',
                        'icon_right_svg' => 'icons/c-arrow-out.svg',
                    ] );
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'littleThingsMatter', 'position' => 'foot', 'alt' => 'Little things matter' ] ); ?>
</section>
