<?php
/**
 * About page — The Dream Team section
 *
 * Light section (Parchment bg).
 * Section header: eyebrow, headline, "Write to the team" CTA.
 * Drift strip: horizontally scrolling row of pinned wall/group photos (2019–2025)
 *   + "To be continued…" end card.
 * Team card grid: 4×2, each card has default (photo + name + role + chip)
 *   and active (message reveal) states toggled by JS.
 *
 * @package Sweet_Pepper
 */

$img_base = get_template_directory_uri() . '/assets/images/';

// ── Drift strip: wall photos (2019–2025) ──────────────────────────────────

$wall_photos = [
    [ 'src' => 'team/group/2019.jpg', 'label' => '2019', 'variant' => 1 ],
    [ 'src' => 'team/group/2020.jpg', 'label' => '2020', 'variant' => 2 ],
    [ 'src' => 'team/group/2021.jpg', 'label' => '2021', 'variant' => 1 ],
    [ 'src' => 'team/group/2022.jpg', 'label' => '2022', 'variant' => 2 ],
    [ 'src' => 'team/group/2023-1.jpg', 'label' => '2023', 'variant' => 1 ],
    [ 'src' => 'team/group/2024.jpg', 'label' => '2024', 'variant' => 2 ],
    [ 'src' => 'team/group/2025.jpg', 'label' => '2025', 'variant' => 1 ],
];

// ── Team members (longest-tenured first) ──────────────────────────────────
// Lines other than Lera's are PLACEHOLDERS (Sep 2026) so every row/card has a chip and a
// reveal to judge the layout by; replace with the members' own words (about-page-copy.md).

$team_members = [
    [
        'name'    => 'Kostya',
        'role'    => __( 'General Manager · 8 years', 'sweet-pepper' ),
        'photo'   => 'team/kostya.jpg',
        'chip'    => __( 'Ask me about…', 'sweet-pepper' ),
        'message' => __( 'Ask me about the terrace swing-chairs. I know which one doesn\'t squeak.', 'sweet-pepper' ),
    ],
    [
        'name'    => 'Lera',
        'role'    => __( 'Floor · 7 years', 'sweet-pepper' ),
        'photo'   => 'team/lera.jpg',
        'chip'    => __( 'Ask me about…', 'sweet-pepper' ),
        'message' => __( 'Start with the salted caramel infusion. If you don\'t like it, I\'ll drink it — hasn\'t happened yet.', 'sweet-pepper' ),
    ],
    [
        'name'    => 'Lenya',
        'role'    => __( 'Floor Manager · 6 years', 'sweet-pepper' ),
        'photo'   => 'team/lenya.jpg',
        'chip'    => __( 'What I pick at the bar', 'sweet-pepper' ),
        'message' => __( 'Pumpkin soup at noon, a sour after eight. Yes, both on the same shift.', 'sweet-pepper' ),
    ],
    [
        'name'    => 'Anton',
        'role'    => __( 'Bar chef · 5 years', 'sweet-pepper' ),
        'photo'   => 'team/anton.jpg',
        'chip'    => __( 'Ask me about…', 'sweet-pepper' ),
        'message' => __( 'Tell me what you drank last night and I\'ll fix it. The drink, not the night.', 'sweet-pepper' ),
    ],
    [
        'name'    => 'Stas',
        'role'    => __( 'Unforgettable waiter · 8 years', 'sweet-pepper' ),
        'photo'   => 'team/stas.jpg',
        'chip'    => __( 'Ask me about…', 'sweet-pepper' ),
        'message' => __( 'I remember your order from 2019. Don\'t test me — I will bring it.', 'sweet-pepper' ),
    ],
    [
        'name'    => 'Alex',
        'role'    => __( 'Bartender · 5 years', 'sweet-pepper' ),
        'photo'   => 'team/alex.jpg',
        'chip'    => __( 'Ask me about…', 'sweet-pepper' ),
        'message' => __( 'The infusions rotate. Ask what\'s in the jar today, not what\'s on the list.', 'sweet-pepper' ),
    ],
    [
        'name'    => 'Max',
        'role'    => __( 'Chef · 8 years', 'sweet-pepper' ),
        'photo'   => 'team/iura/iura-1.jpg',
        'chip'    => __( 'Ask me about…', 'sweet-pepper' ),
        'message' => __( 'Breakfast ends at noon. The eggs don\'t know that, so ask.', 'sweet-pepper' ),
    ],
    [
        'name'    => 'Johnny',
        'role'    => __( 'Sous-chef · 12 years', 'sweet-pepper' ),
        'photo'   => 'team/iura/iura-1.jpg',
        'chip'    => __( 'Ask me about…', 'sweet-pepper' ),
        'message' => __( 'Twelve years, one recipe I still won\'t write down. It\'s the pepper one.', 'sweet-pepper' ),
    ],
];
?>

<section id="team" class="about-section about-section--light about-section--surface about-team">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'theUsualSuspects', 'position' => 'head', 'alt' => 'The usual suspects' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'    => __( 'THE ONES WHO KNOW YOUR ORDER', 'sweet-pepper' ),
            'headline'   => __( 'THE DREAM TEAM', 'sweet-pepper' ),
            'ctas'       => [
                [
                    'label'          => __( 'Write to the team', 'sweet-pepper' ),
                    'variant'        => 'primary-green',
                    'type'           => 'primary-green',
                    'icon_right_svg' => 'icons/c-arrow-right-outline.svg',
                    'class'          => 'js-team-form-trigger',
                ],
            ],
        ] );
        ?>
    </div>

    <!-- Drift strip: horizontal scroll of pinned wall photos -->
    <div class="about-team__drift">
        <div class="about-team__drift-track">
            <?php foreach ( $wall_photos as $photo ) :
                $v     = (int) $photo['variant'];
                $vmod  = $v === 2 ? 'about-team__wall-card--v2' : 'about-team__wall-card--v1';
                $pin   = $v === 2 ? 'about-team__wall-pin--paprika' : 'about-team__wall-pin--lime';
            ?>
                <div class="about-team__wall-card <?php echo esc_attr( $vmod ); ?>">
                    <div class="about-team__wall-pin <?php echo esc_attr( $pin ); ?>"></div>
                    <div class="about-team__wall-photo-wrap">
                        <img src="<?php echo esc_url( $img_base . $photo['src'] ); ?>"
                             alt="<?php echo esc_attr( sprintf( __( 'Sweet Pepper team group photo, %s', 'sweet-pepper' ), $photo['label'] ) ); ?>"
                             class="about-team__wall-photo"
                             loading="lazy">
                        <div class="about-team__wall-pill">
                            <span><?php echo esc_html( $photo['label'] ); ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- "To be continued…" end card -->
            <div class="about-team__wall-card about-team__wall-card--tbc">
                <div class="about-team__wall-pin about-team__wall-pin--paprika"></div>
                <span class="about-team__wall-tbc-text molot-text"><?php esc_html_e( 'To be continued…', 'sweet-pepper' ); ?></span>
            </div>
        </div>
    </div>

    <!-- Team card grid: 4×2 -->
    <div class="container">
        <div class="about-team__grid">
            <?php foreach ( $team_members as $member ) :
                $has_msg = ! empty( $member['message'] );
            ?>
                <div class="about-team__card<?php echo $has_msg ? ' about-team__card--has-message' : ''; ?>">
                    <!-- Default state -->
                    <div class="about-team__card-default">
                        <div class="about-team__card-photo-wrap">
                            <img src="<?php echo esc_url( $img_base . $member['photo'] ); ?>"
                                 alt="<?php echo esc_attr( sprintf( __( 'Photo of %s', 'sweet-pepper' ), $member['name'] ) ); ?>"
                                 class="about-team__card-photo"
                                 loading="lazy">
                        </div>
                        <div class="about-team__card-info">
                            <div class="about-team__card-member-info">
                                <span class="about-team__card-name molot-text"><?php echo esc_html( $member['name'] ); ?></span>
                                <span class="about-team__card-role"><?php echo esc_html( $member['role'] ); ?></span>
                            </div>
                            <button class="about-team__card-chip" type="button">
                                    <span><?php echo esc_html( $member['chip'] ); ?></span>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <path d="M4.5 2.5L8 6L4.5 9.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </button>
                        </div>
                    </div>

                    <?php if ( $has_msg ) : ?>
                        <!-- Active state (message reveal) — hidden by default, toggled by JS -->
                        <div class="about-team__card-active" hidden>
                            <div class="about-team__card-photo-wrap">
                                <img src="<?php echo esc_url( $img_base . $member['photo'] ); ?>"
                                     alt="<?php echo esc_attr( sprintf( __( 'Photo of %s', 'sweet-pepper' ), $member['name'] ) ); ?>"
                                     class="about-team__card-photo"
                                     loading="lazy">
                            </div>
                            <div class="about-team__card-info">
                                <div class="about-team__card-member-info">
                                    <div class="about-team__card-name-row">
                                        <button class="about-team__card-back" type="button" aria-label="<?php esc_attr_e( 'Back', 'sweet-pepper' ); ?>">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                        <span class="about-team__card-name molot-text"><?php echo esc_html( $member['name'] ); ?></span>
                                        <span class="about-team__card-says molot-text"><?php esc_html_e( 'Says', 'sweet-pepper' ); ?></span>
                                    </div>
                                    <p class="about-team__card-message"><?php echo esc_html( $member['message'] ); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'RoomForOneMore', 'position' => 'foot', 'alt' => 'Room for one more' ] ); ?>
</section>

<?php // Render the "Write to the Team" form modal (fixed-position overlay)
get_template_part( 'template-parts/components/team-form' );
?>
