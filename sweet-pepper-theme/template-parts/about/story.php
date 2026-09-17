<?php
/**
 * About page — The Pepper Story section
 *
 * Light section (Parchment/surface bg). Two-column layout:
 * - Left: Story narrative (3 paragraphs) with section-header
 * - Right: Square founder photo + quote card
 * - Below columns: 3-milestone timeline (heat line, outline→fill) and counter ledger
 *   Motion lives in src/js/about-story.js; no-JS state is the finished state.
 *
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/';

$milestones = [
    [
        'year'  => '2009',
        'name'  => 'TABASCO BAR',
        'wit'   => 'Where the heat started',
        'class' => 'about-story__milestone--1 about-story__milestone--past',
        'left'  => '24px',
        'dims'  => true, // hovering it dims the ledger: no Sweet Pepper orders yet
    ],
    [
        'year'  => '2014',
        'name'  => 'SWEET PEPPER',
        'wit'   => 'Kept the heat, made it delicious',
        'class' => 'about-story__milestone--2 about-story__milestone--past',
        'left'  => 34,
        'dims'  => false,
    ],
    [
        'year'  => '2026',
        'name'  => 'STILL HERE',
        'wit'   => 'Same table, probably yours',
        'class' => 'about-story__milestone--3 about-story__milestone--now',
        'left'  => 77,
        'dims'  => false,
    ],
];

// The heat line starts at the first marker and runs to the arrowhead.
$heat_start_raw = $milestones[0]['left'];
$heat_start     = is_numeric( $heat_start_raw ) ? $heat_start_raw . '%' : $heat_start_raw;

/*
 * Counter pool — kitchen-approved estimates, integers only (formatted below).
 * Three slots are shown; if the pool grows past three, JS rotates one slot
 * at a time (~4 s) per about-page-copy.md → Counter ledger.
 */
$counters = [
    [ 'number' => 128400, 'label' => 'cappuccinos served' ],
    [ 'number' => 41200,  'label' => 'pumpkin soups served' ],
    [ 'number' => 96700,  'label' => 'salted caramel shots poured' ],
];
$counter_slots = array_slice( $counters, 0, 3 );
?>

<section id="story" class="about-section about-section--light about-section--surface about-story">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'backToTheFirstPour', 'position' => 'head', 'alt' => 'Back to the first pour' ] ); ?>

    <div class="container">
        <!-- Two-column narrative & founder block -->
        <div class="about-story__inner">
            <!-- Left Column: Story text -->
            <div class="about-story__text">
                <?php
                get_template_part( 'template-parts/components/section-header', null, [
                    'eyebrow'    => __( 'SINCE 2014', 'sweet-pepper' ),
                    'headline'   => __( 'THE PEPPER', 'sweet-pepper' ),
                    'headline_2' => __( 'STORY', 'sweet-pepper' ),
                ] );
                ?>

                <div class="about-story__body">
                    <?php // The naming sentence opens ¶2, so on phones it follows the timeline (author, Sep 2026; about-page-copy.md → The Story) ?>
                    <p><?php esc_html_e( 'Before Sweet Pepper, there was Tabasco Bar on Kirova Street. The next chapter kept the edge and added warmth, with a kitchen given as much care as the bar.', 'sweet-pepper' ); ?></p>
                    <p><?php esc_html_e( 'The name says it: still pepper, a little sweeter. Breakfast, lunch and cocktails became parts of the same place, with room for an ordinary Tuesday as well as a big night out.', 'sweet-pepper' ); ?></p>
                    <p><?php esc_html_e( 'The regulars helped shape what followed. Pumpkin soup, berry cheesecake and berry korzhik started as seasonal specials. Guests kept asking for them, so they stayed. Some of the best things on the menu are there because someone didn\'t want to say goodbye to them.', 'sweet-pepper' ); ?></p>
                </div>
            </div>

            <!-- Right Column: Founder photo + quote card -->
            <div class="about-story__founder">
                <div class="about-story__founder-img-wrap">
                    <img src="<?php echo esc_url( $img_base . 'team/iura/iura-1.jpg' ); ?>"
                         alt="<?php esc_attr_e( 'Iurii Primyshev behind the bar at Sweet Pepper', 'sweet-pepper' ); ?>"
                         class="about-story__founder-img"
                         width="436"
                         height="436"
                         loading="lazy">
                </div>

                <div class="about-story__founder-quote-wrap">
                    <div class="about-quote-card about-story__founder-quote">
                        <span class="about-quote-card__mark" aria-hidden="true">&ldquo;</span>
                        <div class="about-quote-card__content">
                            <p class="about-quote-card__text"><?php esc_html_e( 'The main thing is to always know your limit. Otherwise you might drink less.', 'sweet-pepper' ); ?></p>
                            <span class="about-quote-card__source">
                                <span class="about-quote-card__source-name"><?php esc_html_e( 'Iurii Primyshev.', 'sweet-pepper' ); ?></span>
                                <span class="about-quote-card__source-title"><?php esc_html_e( 'Founder, still behind the bar.', 'sweet-pepper' ); ?></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Timeline: 3 milestones along axis. Heat line = outline→fill grammar (website-brief → Motion language) -->
        <div class="about-story__timeline">
            <div class="about-story__timeline-line" aria-hidden="true"></div>
            <div class="about-story__timeline-heat" aria-hidden="true" style="<?php echo esc_attr( '--heat-start: ' . $heat_start . ';' ); ?>"></div>
            <span class="about-story__timeline-cap" aria-hidden="true"></span>
            <span class="about-story__timeline-arrow" aria-hidden="true"></span>

            <?php foreach ( $milestones as $i => $milestone ) :
                $left_val = is_numeric( $milestone['left'] ) ? $milestone['left'] . '%' : $milestone['left'];
            ?>
                <div class="about-story__milestone <?php echo esc_attr( $milestone['class'] ); ?>"
                     style="<?php echo esc_attr( 'left: ' . $left_val . '; --enter-delay: ' . ( $i * 120 ) . 'ms;' ); ?>"
                     data-left="<?php echo esc_attr( $milestone['left'] ); ?>"
                     <?php echo $milestone['dims'] ? 'data-dims-ledger="1"' : ''; ?>>
                    <span class="about-story__milestone-year"><?php echo esc_html( $milestone['year'] ); ?></span>
                    <span class="about-story__milestone-tick" aria-hidden="true"></span>
                    <span class="about-story__milestone-name molot-text"><?php echo esc_html( $milestone['name'] ); ?></span>
                    <span class="about-story__milestone-wit"><?php echo esc_html( $milestone['wit'] ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Counter Ledger -->
        <div class="about-story__counters">
            <?php // Phones only: the ledger keeps the bartender's-ticket *edge* as a motif (website-brief.md →
                  // The Pepper Story → Why not C). Top scallops in the section ground, bottom in the card colour. ?>
            <div class="about-story__counters-edge about-story__counters-edge--top" aria-hidden="true">
                <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'parchment' ] ); ?>
            </div>
            <div class="about-story__counters-edge about-story__counters-edge--bottom" aria-hidden="true">
                <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'paper' ] ); ?>
            </div>
            <h3 class="about-story__counters-label molot-text"><?php esc_html_e( 'TWELVE YEARS,', 'sweet-pepper' ); ?> <br aria-hidden="true"><?php esc_html_e( 'COUNTED IN ORDERS', 'sweet-pepper' ); ?></h3>

            <div class="about-story__counters-row">
                <?php foreach ( $counter_slots as $counter ) : ?>
                    <div class="about-story__counter">
                        <span class="about-story__counter-number molot-text" data-count="<?php echo esc_attr( $counter['number'] ); ?>"><?php echo esc_html( number_format( $counter['number'], 0, '', ' ' ) ); ?></span>
                        <span class="about-story__counter-label"><?php echo esc_html( $counter['label'] ); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <script type="application/json" class="about-story__counter-pool"><?php echo wp_json_encode( $counters ); ?></script>
        </div>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'inGoodCompany', 'position' => 'foot', 'alt' => 'In good company' ] ); ?>
</section>
