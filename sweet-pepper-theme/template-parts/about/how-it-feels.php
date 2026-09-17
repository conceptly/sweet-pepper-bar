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
 * @package Sweet_Pepper
 */

// Word cloud: words sourced from about-reviews.md (English display equivalents).
// Rows are the no-JS / pre-hydration fallback; JS spiral-places them.
// Tiers by review frequency: top = 2+ reviews, mid = 1, low = 1 (supporting).
// Sizes tied 1:1 to tiers: top = 56, mid = 36, low = 24.
$cloud_rows = [
    [
        [ 'text' => 'cosy',      'tier' => 'top', 'size' => 56 ],  // Y01, G05
        [ 'text' => 'welcoming', 'tier' => 'top', 'size' => 56 ],  // Y03, G03
        [ 'text' => 'beloved',   'tier' => 'mid', 'size' => 36 ],  // Y05
    ],
    [
        [ 'text' => 'friendly',  'tier' => 'top', 'size' => 56 ],  // Y07, G01
        [ 'text' => 'happy',     'tier' => 'mid', 'size' => 36 ],  // Y02
        [ 'text' => 'attentive', 'tier' => 'low', 'size' => 24 ],  // G02
    ],
    [
        [ 'text' => 'perfect',   'tier' => 'mid', 'size' => 36 ],  // Y08
        [ 'text' => 'inviting',  'tier' => 'top', 'size' => 56 ],  // Y04, G04
        [ 'text' => 'magnetic',  'tier' => 'mid', 'size' => 36 ],  // Y09
    ],
    [
        [ 'text' => 'sociable',  'tier' => 'mid', 'size' => 36 ],  // Y06
        [ 'text' => 'wonderful', 'tier' => 'mid', 'size' => 36 ],  // Y11
        [ 'text' => 'lively',    'tier' => 'low', 'size' => 24 ],  // Y10
    ],
    [
        [ 'text' => 'pleasant',  'tier' => 'mid', 'size' => 36 ],  // Y12
        [ 'text' => 'charming',  'tier' => 'mid', 'size' => 36 ],  // Y13
        [ 'text' => 'kind',      'tier' => 'low', 'size' => 24 ],  // Y14
        [ 'text' => 'inclusive', 'tier' => 'low', 'size' => 24 ],  // Y15
    ],
];

// The default active word (filled on load, before JS takes over).
$default_active = 'welcoming';

// Quote cards: all 20 review excerpts from about-reviews.md (15 Yandex + 5 Google).
// Each quote links to a cloud word via 'word' key.
// Words with multiple reviews (cosy, welcoming, inviting, friendly) cycle on repeat-click.
// text = Russian original; text_en = English translation.
$quotes = [
    [
        'id'        => 'y01',
        'text'      => 'Атмосфера здесь очень уютная, а время пролетает незаметно.',
        'text_en'   => 'It\'s so cosy here, and time flies without you noticing.',
        'platform'  => 'Yandex',
        'footnote'  => 'time flies when the room is right',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=tj62avucx3mh98fvxwv7hrfb20&utm_source=review',
        'word'      => 'cosy',
    ],
    [
        'id'        => 'y02',
        'text'      => 'Очень рада, что знакомство с городом состоялось именно здесь.',
        'text_en'   => 'I\'m so glad this was my introduction to the city.',
        'platform'  => 'Yandex',
        'footnote'  => 'Yaroslavl, first stop',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=3grnhd9fggfg68khmptdmh9jbr&utm_source=review',
        'word'      => 'happy',
    ],
    [
        'id'        => 'y03',
        'text'      => 'Классный персонал, собакоориентированность и игристое по утрам окончательно укрепили меня в мысли, что место годное!',
        'text_en'   => 'Great staff, a welcome for dogs and sparkling wine in the morning sealed it for me: this place is a find!',
        'platform'  => 'Yandex',
        'footnote'  => 'dogs welcome, bubbles before noon',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=7cnpwx4y36r9fkz4x7k7f8rcdw&utm_source=review',
        'word'      => 'welcoming',
    ],
    [
        'id'        => 'y04',
        'text'      => 'Внутри очень уютно, атмосфера располагающая, а цены приятно удивили.',
        'text_en'   => 'It\'s very cosy inside, the atmosphere is inviting, and the prices were a pleasant surprise.',
        'platform'  => 'Yandex',
        'footnote'  => 'stepped in from the rain, stayed for dinner',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=8ec8jnaf6k7cg6ta3pq7bbyvy8&utm_source=review',
        'word'      => 'inviting',
    ],
    [
        'id'        => 'y05',
        'text'      => 'Самый любимый бар, дружелюбное обслуживание, вкусная еда, а главное — отменные коктейли!',
        'text_en'   => 'My favourite bar! Friendly service, delicious food and, most importantly, excellent cocktails!',
        'platform'  => 'Yandex',
        'footnote'  => 'cocktails first, apparently',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=kqhgu3gzgemq8m85hha1g9g0vr&utm_source=review',
        'word'      => 'beloved',
    ],
    [
        'id'        => 'y06',
        'text'      => 'В общем отличное заведение, и если не знаете куда сходить с друзьями? Вам точно сюда!',
        'text_en'   => 'A great place all round. If you\'re wondering where to go with friends, this is definitely the place!',
        'platform'  => 'Yandex',
        'footnote'  => 'bring friends, noted',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=116n4gwqek9rkuuxv433kr4tm4&utm_source=review',
        'word'      => 'sociable',
    ],
    [
        'id'        => 'y07',
        'text'      => 'Харизматичная и очень приветливая официантка',
        'text_en'   => 'A waitress with loads of personality, and so friendly',
        'platform'  => 'Yandex',
        'footnote'  => 'warmth isn\'t confined to longstanding staff',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=qk4qq7r8qh0x4wdf4t0wemey4m&utm_source=review',
        'word'      => 'friendly',
    ],
    [
        'id'        => 'y08',
        'text'      => 'Это был идеальный вечер! Неплохая музыка, по еде всё идеально…',
        'text_en'   => 'It was the perfect evening! Decent music, and all the food was spot on…',
        'platform'  => 'Yandex',
        'footnote'  => 'an evening they remember',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=jku9021x8da61k7wv6qumgmfag&utm_source=review',
        'word'      => 'perfect',
    ],
    [
        'id'        => 'y09',
        'text'      => 'За 3 дня в Ярославле дважды посетили данное заведение, настолько понравилось 💕🔥',
        'text_en'   => 'We came here twice in three days in Yaroslavl — that\'s how much we loved it 💕🔥',
        'platform'  => 'Yandex',
        'footnote'  => 'twice in three days says it all',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=r0uqpfbnw82jrfdf78k6k7r2c8&utm_source=review',
        'word'      => 'magnetic',
    ],
    [
        'id'        => 'y10',
        'text'      => 'У меня Sweet Pepper ассоциируется со студенческими веселыми временами',
        'text_en'   => 'Sweet Pepper brings back the good times from my student days',
        'platform'  => 'Yandex',
        'footnote'  => 'memories from a regular',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=yxdkf33f3va31b5fuu82meey30&utm_source=review',
        'word'      => 'lively',
    ],
    [
        'id'        => 'g01',
        'text'      => 'Уютный гастрономический бар со своей атмосферой, персонал всегда приветливый и дружелюбный.',
        'text_en'   => 'A cosy gastrobar with an atmosphere all its own. The staff are always welcoming and friendly.',
        'platform'  => 'Google',
        'footnote'  => 'the staff make the place',
        'link'      => 'https://share.google/O0vFa1GqwJs2HfwQm',
        'word'      => 'friendly',
    ],
    [
        'id'        => 'g02',
        'text'      => 'Классно, уютно, внимательный персонал, вкусная еда.',
        'text_en'   => 'A lovely, cosy place. Attentive staff, delicious food.',
        'platform'  => 'Google',
        'footnote'  => 'repeat lunches and dinners',
        'link'      => 'https://share.google/1Ah8c3kMf2iKOQ91l',
        'word'      => 'attentive',
    ],
    [
        'id'        => 'g03',
        'text'      => 'Отдельное спасибо милым и приветливым официантам!',
        'text_en'   => 'A special thank-you to the lovely, welcoming waiting staff!',
        'platform'  => 'Google',
        'footnote'  => 'the team, by name',
        'link'      => 'https://share.google/oqgrJEVNwQU6QOAk1',
        'word'      => 'welcoming',
    ],
    [
        'id'        => 'g04',
        'text'      => 'В этот раз в очередной раз убедилась, что это место стоит того, чтобы ходить туда чаще.',
        'text_en'   => 'This visit reminded me once again that this place deserves more frequent visits.',
        'platform'  => 'Google',
        'footnote'  => 'a returning guest, convinced',
        'link'      => 'https://share.google/HL3nbzdA4vm4AAdax',
        'word'      => 'inviting',
    ],
    [
        'id'        => 'g05',
        'text'      => 'Уютная обстановка, хотя низкие столы и правда на любителя.',
        'text_en'   => 'A cosy setting, though the low tables really aren\'t for everyone.',
        'platform'  => 'Google',
        'footnote'  => 'honest and still five stars',
        'link'      => 'https://share.google/bf6H7c6KbKvqLYJrw',
        'word'      => 'cosy',
    ],
    [
        'id'        => 'y11',
        'text'      => 'Посещаю это место несколько лет и каждый раз восхищаюсь атмосферой.',
        'text_en'   => 'I\'ve visited for years, and the atmosphere still amazes me.',
        'platform'  => 'Yandex',
        'footnote'  => 'years of visits, still amazed',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=gtxmue6w93e45qgpammaufgv6m&utm_source=review',
        'word'      => 'wonderful',
    ],
    [
        'id'        => 'y12',
        'text'      => 'Приятная атмосфера дня и ночи',
        'text_en'   => 'A lovely atmosphere, day and night',
        'platform'  => 'Yandex',
        'footnote'  => 'day and night, both work',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=tm3zudznnxwm8jft7u9zhf9d3r&utm_source=review',
        'word'      => 'pleasant',
    ],
    [
        'id'        => 'y13',
        'text'      => 'Еше тут приветливый и обаятельный персонал.',
        'text_en'   => 'The staff are welcoming and charming, too.',
        'platform'  => 'Yandex',
        'footnote'  => 'took an infusion home for friends',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=basun.av&utm_source=review',
        'word'      => 'charming',
    ],
    [
        'id'        => 'y14',
        'text'      => 'вежливый,доброжелательный персонал и быстрое обслуживание',
        'text_en'   => 'Polite, friendly staff and quick service',
        'platform'  => 'Yandex',
        'footnote'  => 'quick even when full',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=irinkakashina94&utm_source=review',
        'word'      => 'kind',
    ],
    [
        'id'        => 'y15',
        'text'      => 'даже моим родителям Sweet Pepper очень понравился.',
        'text_en'   => 'Even my parents really liked Sweet Pepper.',
        'platform'  => 'Yandex',
        'footnote'  => 'a family endorsement',
        'link'      => 'https://yandex.com/maps/org/237019392845/reviews?reviews%5BpublicId%5D=g50a6ate397davtyxe8htap8dc&utm_source=review',
        'word'      => 'inclusive',
    ],
];

// CTA link.
$yandex_reviews_url = 'https://yandex.com/maps/org/sweet_pepper/237019392845/reviews/?ll=39.888343%2C57.626024&z=17';
?>

<section id="how-it-feels" class="about-section about-section--light about-section--surface about-how-it-feels">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'wordOfMouth', 'position' => 'head', 'alt' => 'Word of mouth' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'  => __( 'IN YOUR WORDS', 'sweet-pepper' ),
            'headline' => __( 'HOW IT FEELS', 'sweet-pepper' ),
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
                                    style="--cloud-size: <?php echo esc_attr( $word['size'] ); ?>px"
                                >
                                    <?php echo esc_html( $word['text'] ); ?>
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
                        // Detect whether the site is running in Russian.
                        $is_ru = ( strpos( get_locale(), 'ru' ) === 0 );

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
                            >
                                <div class="about-quote-card">
                                    <span class="about-quote-card__mark" aria-hidden="true">&ldquo;</span>
                                    <div class="about-quote-card__content">
                                        <p class="about-quote-card__text"><?php echo esc_html( $display_text ); ?></p>
                                        <span class="about-quote-card__source">
                                            <?php echo esc_html( $quote['platform'] ); ?>
                                            <?php if ( ! $is_ru && ! empty( $quote['link'] ) ) : ?>
                                                · <a href="<?php echo esc_url( $quote['link'] ); ?>" class="about-quote-card__original" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Read the Russian original', 'sweet-pepper' ); ?>"><?php esc_html_e( 'Russian original', 'sweet-pepper' ); ?></a>
                                            <?php endif; ?>
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
