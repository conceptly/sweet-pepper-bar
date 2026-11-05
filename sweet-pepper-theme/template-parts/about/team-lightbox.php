<?php
/**
 * About page — The Dream Team wall lightbox: the wall, closer.
 *
 * The drift strip's prints at lightbox scale, one per year, each with its pin, its tilt and
 * the Lemon year pill. A fixed overlay, hidden until a print on the strip is clicked
 * (team-lightbox.js, team-lightbox.css); without JS it never shows and the strip's photos
 * stay photos.
 *
 * The photos are not in the markup as images: each print carries the strip's own crop
 * (data-src) and the larger file (data-full), and the script loads them on the first
 * opening — a guest who never opens the wall downloads nothing for it.
 *
 * @param array $args wall[] (src, full, label) — the strip's photos, in the strip's order
 *                    (template-parts/about/team.php passes its own)
 *
 * @package Sweet_Pepper
 */

$wall_photos = $args['wall'] ?? [];
if ( ! $wall_photos ) {
    return;
}
?>

<div class="team-lightbox" id="team-lightbox" role="dialog" aria-modal="true" tabindex="-1" aria-label="<?php esc_attr_e( 'Team photos by year', 'sweet-pepper' ); ?>">
    <div class="team-lightbox__view">
        <div class="team-lightbox__track">
            <?php foreach ( $wall_photos as $i => $photo ) :
                $v    = $i % 2 ? 2 : 1; // pin colour and tilt alternate, as on the strip
                $vmod = $v === 2 ? 'team-lightbox__card--v2' : 'team-lightbox__card--v1';
                $pin  = $v === 2 ? 'team-lightbox__pin--paprika' : 'team-lightbox__pin--lime';
            ?>
                <button type="button" class="team-lightbox__card <?php echo esc_attr( $vmod ); ?>" tabindex="-1"
                        aria-label="<?php echo esc_attr( sprintf( __( 'Sweet Pepper team group photo, %s', 'sweet-pepper' ), $photo['label'] ) ); ?>">
                    <span class="team-lightbox__print">
                        <span class="team-lightbox__pin <?php echo esc_attr( $pin ); ?>"></span>
                        <span class="team-lightbox__photo"
                              data-src="<?php echo esc_url( $photo['src'] ); ?>"
                              data-full="<?php echo esc_url( $photo['full'] ); ?>">
                            <span class="team-lightbox__pill"><?php echo esc_html( $photo['label'] ); ?></span>
                        </span>
                    </span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>

    <button class="team-lightbox__close" type="button" aria-label="<?php esc_attr_e( 'Close', 'sweet-pepper' ); ?>">
        <?php echo sweet_pepper_ph( 'x' ); ?>
    </button>
</div>
