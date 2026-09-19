<?php
/**
 * Template part: the two-column dish layout of a menu section.
 *
 * Loops over sweet_pepper_menu_subsections() (inc/menu-data.php) — the rows come
 * from the section's record in admin, or from data/menu/<slug>.php until it is filled.
 * A subsection is a header + dish rows; style 'card' wraps it as the add-ons card
 * (e.g. Favorite Sauces).
 *
 * @param array $args {
 *     @type string $section Section slug, e.g. 'soups' (required).
 * }
 */

$subsections = sweet_pepper_menu_subsections( $args['section'] ?? '' );
?>
<div class="menu-section__columns">

    <?php foreach ( [ 'left', 'right' ] as $side ) : ?>
        <div class="menu-section__column menu-section__column--<?php echo esc_attr( $side ); ?>">

            <?php foreach ( $subsections as $sub ) :
                if ( ( $sub['column'] ?? 'left' ) !== $side ) {
                    continue;
                }
                $is_card = 'card' === ( $sub['style'] ?? 'list' );
                ?>

                <?php if ( $is_card ) : ?>
                <div class="menu-section__addons">
                    <div class="menu-section__addons-card">
                <?php else : ?>
                <div class="menu-section__subsection">
                <?php endif; ?>

                    <?php if ( ! empty( $sub['title'] ) ) : ?>
                        <div class="menu-section__subsection-header">
                            <h3 class="menu-section__subsection-title molot-text"><?php echo esc_html( $sub['title'] ); ?></h3>
                        </div>
                    <?php endif; ?>
                    <div class="menu-section__dishes">
                        <?php foreach ( $sub['dishes'] as $dish ) {
                            get_template_part( 'template-parts/components/dish-row', null, $dish );
                        } ?>
                    </div>

                <?php if ( $is_card ) : ?>
                        <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'section-bg' ] ); ?>
                    </div>
                </div>
                <?php else : ?>
                </div>
                <?php endif; ?>

            <?php endforeach; ?>

        </div><!-- /.menu-section__column--<?php echo esc_attr( $side ); ?> -->
    <?php endforeach; ?>

</div><!-- /.menu-section__columns -->
