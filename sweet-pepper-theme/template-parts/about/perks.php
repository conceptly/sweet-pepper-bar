<?php
/**
 * About page — Beyond Shake & Cook (Perks / Services) section
 *
 * Dark section. Stamp strip with 6 rubber stamps + expandable detail message.
 * Per-stamp colour coding: Lime → Lemon → Paprika, repeating (re-dealt per row on phones).
 * States: tilt ±4° at rest → halfway straight on hover → straight, solid ring, ink fill when
 * active; a press scales down (about.css → 4. Beyond Shake & Cook).
 *
 * @param array $args eyebrow · headline · headline_2 · perks[] (id, label, word, icon, color, title, description)
 *
 * @package Sweet_Pepper
 */

/*
 * Icons are the Figma `Icons` set exported to assets/icons/ (12px artboards, scaled by CSS)
 * and inlined so they take the stamp colour via currentColor. `label` is the desktop word,
 * `word` the phone word (About-mobile-opt2 1490:78394), where the long labels wrapped.
 * The six stamps come as args from sweet_pepper_about_perks() (inc/about-data.php) — the
 * About page's «Удобства» tab; the colour deal (Lime → Lemon → Paprika) is made there.
 */
$perks = $args['perks'];

/*
 * Phones deal the three colours so no column repeats (frame 1490:78394: row two starts
 * on Paprika). Six in a row on desktop has no columns, so `color` stays as dealt.
 */
$palette = [ 'lime', 'lemon', 'paprika' ];

$default_perk = $perks[0];

// Prepare JSON map for JS interaction
$perks_json_data = [];
foreach ( $perks as $p ) {
    $perks_json_data[ $p['id'] ] = [
        'id'          => $p['id'],
        'label'       => $p['label'],
        'title'       => $p['title'],
        'description' => $p['description'],
    ];
}

// Map colour names to CSS variable values
$color_map = [
    'lime'    => 'var(--lime)',
    'lemon'   => 'var(--lemon)',
    'paprika' => 'var(--paprika)',
];
?>

<section id="perks" class="about-section about-section--dark about-perks">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'littleThingsMatter', 'position' => 'head', 'alt' => 'Little things matter' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'    => $args['eyebrow'],
            'headline'   => $args['headline'],
            'headline_2' => $args['headline_2'],
        ] );
        ?>

        <div class="about-perks__stamps" role="tablist" aria-label="<?php echo esc_attr__( 'Sweet Pepper perks', 'sweet-pepper' ); ?>">
            <?php foreach ( $perks as $index => $perk ) :
                $is_active   = ( $index === 0 );
                $stamp_color = isset( $color_map[ $perk['color'] ] ) ? $color_map[ $perk['color'] ] : 'var(--lime)';
                $phone_color = $color_map[ $palette[ ( $index - intdiv( $index, 3 ) + 3 ) % 3 ] ];
            ?>
                <button type="button"
                        class="about-perks__stamp<?php echo $is_active ? ' is-active' : ''; ?>"
                        data-perk="<?php echo esc_attr( $perk['id'] ); ?>"
                        data-color="<?php echo esc_attr( $perk['color'] ); ?>"
                        style="--stamp-color: <?php echo $stamp_color; ?>; --stamp-color-phone: <?php echo $phone_color; ?>"
                        role="tab"
                        aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
                        aria-controls="about-perks-detail"
                        id="perk-tab-<?php echo esc_attr( $perk['id'] ); ?>">
                    <span class="about-perks__stamp-icon" aria-hidden="true"><?php echo sweet_pepper_inline_svg( 'assets/icons/' . $perk['icon'] . '.svg' ); ?></span>
                    <span class="about-perks__stamp-label about-perks__stamp-label--long"><?php echo esc_html( $perk['label'] ); ?></span>
                    <span class="about-perks__stamp-label about-perks__stamp-label--short"><?php echo esc_html( $perk['word'] ); ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <div id="about-perks-detail" class="about-perks__detail" role="tabpanel" aria-live="polite">
            <div class="about-perks__detail-header">
                <span class="about-perks__detail-line about-perks__detail-line--solid" aria-hidden="true"></span>
                <span class="about-perks__detail-title"><?php echo esc_html( $default_perk['title'] ); ?></span>
                <span class="about-perks__detail-line about-perks__detail-line--dashed" aria-hidden="true"></span>
            </div>
            <span class="about-perks__detail-desc"><?php echo esc_html( $default_perk['description'] ); ?></span>
        </div>

        <script type="application/json" class="about-perks__data"><?php
            echo wp_json_encode( $perks_json_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
        ?></script>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'backToTheFirstPour', 'position' => 'foot', 'alt' => 'Back to the first pour' ] ); ?>
</section>
