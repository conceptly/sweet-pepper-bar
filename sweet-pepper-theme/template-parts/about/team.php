<?php
/**
 * About page — The Dream Team section
 *
 * Light section (Parchment bg).
 * Section header: eyebrow, headline, "Write to the team" CTA.
 * Drift strip: horizontally scrolling row of pinned wall/group photos
 *   + "To be continued…" end card.
 * Team card grid: 4×2, each card has default (photo + name + role + chip)
 *   and active (message reveal) states toggled by JS.
 *
 * Content comes as args from sweet_pepper_about_team() (inc/about-data.php) — the About
 * page's «Команда» tab: 6 or 8 members (an even count is validated on save), tenure
 * printed from the year each joined, the chip's wording from a preset.
 *
 * @param array $args eyebrow · headline · headline_2 · wall[] (src, label) ·
 *                    members[] (name, role, photo, chip, message)
 *
 * @package Sweet_Pepper
 */

$wall_photos  = $args['wall'];
$team_members = $args['members'];
?>

<section id="team" class="about-section about-section--light about-section--surface about-team">
    <?php // Section connector (about.css → Connectors)
    get_template_part( 'template-parts/about/connector', null, [ 'word' => 'theUsualSuspects', 'position' => 'head', 'alt' => 'The usual suspects' ] ); ?>

    <div class="container">
        <?php
        get_template_part( 'template-parts/components/section-header', null, [
            'eyebrow'    => $args['eyebrow'],
            'headline'   => $args['headline'],
            'headline_2' => $args['headline_2'],
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
            <?php foreach ( $wall_photos as $i => $photo ) :
                $v     = $i % 2 ? 2 : 1; // pin colour and tilt alternate down the strip
                $vmod  = $v === 2 ? 'about-team__wall-card--v2' : 'about-team__wall-card--v1';
                $pin   = $v === 2 ? 'about-team__wall-pin--paprika' : 'about-team__wall-pin--lime';
            ?>
                <div class="about-team__wall-card <?php echo esc_attr( $vmod ); ?>">
                    <div class="about-team__wall-pin <?php echo esc_attr( $pin ); ?>"></div>
                    <div class="about-team__wall-photo-wrap">
                        <img src="<?php echo esc_url( $photo['src'] ); ?>"
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
                            <img src="<?php echo esc_url( $member['photo'] ); ?>"
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
                                <img src="<?php echo esc_url( $member['photo'] ); ?>"
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
