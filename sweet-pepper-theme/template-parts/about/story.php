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
 * Content comes as args from sweet_pepper_about_story() (inc/about-data.php) — the About page's «История» tab.
 *
 * @param array $args eyebrow · headline · headline_2 · paragraphs[3] · founder_photo · founder_alt · founder_quote ·
 *                    founder_name · founder_title · milestones[3] (year, name, wit) · counters_label · counters_label_2 · counters[] (number, label)
 *
 * @package Sweet_Pepper
 */


// The three markers' places on the axis and their states are the theme's; year, name and
// wit come from the «История» tab (the third year is always the current one).
$marker_layout = [
    [ 'class' => 'about-story__milestone--1 about-story__milestone--past', 'left' => '24px', 'dims' => true ], // hovering it dims the ledger: no Sweet Pepper orders yet
    [ 'class' => 'about-story__milestone--2 about-story__milestone--past', 'left' => 34,     'dims' => false ],
    [ 'class' => 'about-story__milestone--3 about-story__milestone--now',  'left' => 77,     'dims' => false ],
];
$milestones = [];
foreach ( $args['milestones'] as $i => $m ) {
    $milestones[] = $m + $marker_layout[ $i ];
}

// The heat line starts at the first marker and runs to the arrowhead.
$heat_start_raw = $milestones[0]['left'];
$heat_start     = is_numeric( $heat_start_raw ) ? $heat_start_raw . '%' : $heat_start_raw;

/*
 * Counter pool — kitchen-approved estimates, integers only (formatted below).
 * Three slots are shown; if the pool grows past three, JS rotates one slot
 * at a time (~4 s) per about-page-copy.md → Counter ledger.
 */
$counters = $args['counters'];
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
                    'eyebrow'    => $args['eyebrow'],
                    'headline'   => $args['headline'],
                    'headline_2' => $args['headline_2'],
                ] );
                ?>

                <div class="about-story__body">
                    <?php // The naming sentence opens ¶2, so on phones it follows the timeline (author, Sep 2026; about-page-copy.md → The Story) ?>
                    <?php foreach ( $args['paragraphs'] as $paragraph ) : ?>
                        <p><?php echo esc_html( $paragraph ); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Right Column: Founder photo + quote card -->
            <div class="about-story__founder">
                <div class="about-story__founder-img-wrap">
                    <img src="<?php echo esc_url( $args['founder_photo'] ); ?>"
                         alt="<?php echo esc_attr( $args['founder_alt'] ); ?>"
                         class="about-story__founder-img"
                         width="436"
                         height="436"
                         loading="lazy">
                </div>

                <div class="about-story__founder-quote-wrap">
                    <div class="about-quote-card about-story__founder-quote">
                        <span class="about-quote-card__mark" aria-hidden="true">&ldquo;</span>
                        <div class="about-quote-card__content">
                            <p class="about-quote-card__text"><?php echo esc_html( $args['founder_quote'] ); ?></p>
                            <span class="about-quote-card__source">
                                <span class="about-quote-card__source-name"><?php echo esc_html( $args['founder_name'] ); ?></span>
                                <span class="about-quote-card__source-title"><?php echo esc_html( $args['founder_title'] ); ?></span>
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
            <h3 class="about-story__counters-label molot-text"><?php echo esc_html( $args['counters_label'] ); ?><?php if ( $args['counters_label_2'] ) : ?> <br aria-hidden="true"><?php echo esc_html( $args['counters_label_2'] ); ?><?php endif; ?></h3>

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
