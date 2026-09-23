<?php
/**
 * Template part: the two-column dish layout of a menu section.
 *
 * Loops over sweet_pepper_menu_subsections() (inc/menu-data.php) — the rows come
 * from the section's record in admin, or from data/menu/<slug>.php until it is filled.
 * A subsection is a header + dish rows; style 'card' wraps it as the add-ons card
 * (e.g. Favorite Sauces). A list subsection without a title is a bare run of rows
 * (Infusions). A subsection marked `divider` starts a new pair of columns under a
 * rule (Tea & Coffee: coffee above, tea below); `note` prints a remark under it (Kids).
 *
 * @param array $args {
 *     @type string $section Section slug, e.g. 'soups' (required).
 * }
 */

// Split into blocks of columns at each divider.
$blocks = [];
foreach ( sweet_pepper_menu_subsections( $args['section'] ?? '' ) as $sub ) {
    if ( ! $blocks || ! empty( $sub['divider'] ) ) {
        $blocks[] = [];
    }
    $blocks[ count( $blocks ) - 1 ][] = $sub;
}
?>
<?php foreach ( $blocks as $b => $subsections ) : ?>
<?php if ( $b ) : ?>
<div class="menu-section__coffee-tea-divider"></div>
<?php endif; ?>
<div class="menu-section__columns">

    <?php foreach ( [ 'left', 'right' ] as $side ) : ?>
        <div class="menu-section__column menu-section__column--<?php echo esc_attr( $side ); ?>">

            <?php foreach ( $subsections as $sub ) :
                if ( ( $sub['column'] ?? 'left' ) !== $side ) {
                    continue;
                }
                $is_card = 'card' === ( $sub['style'] ?? 'list' );
                $is_bare = ! $is_card && empty( $sub['title'] );
                ?>

                <?php if ( $is_card ) : ?>
                <div class="menu-section__addons">
                    <div class="menu-section__addons-card">
                <?php elseif ( ! $is_bare ) : ?>
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
                <?php elseif ( ! $is_bare ) : ?>
                </div>
                <?php endif; ?>

                <?php if ( ! empty( $sub['note'] ) ) : ?>
                <p class="menu-section__remark"><?php echo esc_html( $sub['note'] ); ?></p>
                <?php endif; ?>

            <?php endforeach; ?>

        </div><!-- /.menu-section__column--<?php echo esc_attr( $side ); ?> -->
    <?php endforeach; ?>

</div><!-- /.menu-section__columns -->
<?php endforeach; ?>
