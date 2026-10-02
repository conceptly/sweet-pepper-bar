<?php
/**
 * Button Component
 * 
 * @param array $args {
 *     @type string $label   Button text
 *     @type string $label_mobile  Shorter text shown ≤ 767px (the two-up messenger rows); the full
 *                                 label stays the accessible name. Ignored when equal to $label.
 *     @type string $url     Button link URL (if empty, renders a <button>)
 *     @type string $type    'primary' | 'secondary'
 *     @type string $icon    Name of Phosphor icon to include on the right
 *     @type string $class   Extra CSS classes
 *     @type string $id      Optional ID
 *     @type string $secondary  The classes that make it a secondary when a script hands the Chili
 *                              role elsewhere (data-secondary; reserve-drawer.js → setRole — the
 *                              booking blocks' VK button). Defaults to the script's `btn-secondary`.
 * }
 */

$label      = $args['label'] ?? 'Button';
$url        = $args['url'] ?? '';
$type       = $args['variant'] ?? ( $args['type'] ?? 'primary' );
$icon_left  = $args['icon_left'] ?? ( $args['icon'] ?? '' );
$icon_right = $args['icon_right'] ?? '';
$icon_set   = $args['icon_set'] ?? []; // several left glyphs, one shown by the button's data-icon (the home hero's menu button)
$icon_left_svg  = $args['icon_left_svg'] ?? '';
$icon_right_svg = $args['icon_right_svg'] ?? '';
$class      = $args['class'] ?? '';
$id         = $args['id'] ?? '';
$aria_label = $args['aria_label'] ?? ''; // an accessible name fuller than the label (the drawer's phone button)
$label_mobile = $args['label_mobile'] ?? '';
$secondary  = $args['secondary'] ?? '';
if ( $label_mobile === $label ) {
    $label_mobile = '';
}
if ( $label_mobile && empty( $aria_label ) ) {
    $aria_label = $label; // the phone sees "Написать" beside the logo; the name stays "Написать в ВК"
}

$classes = ['btn', 'btn-' . $type];
if ( ! empty( $class ) ) {
    $classes[] = $class;
}

$class_attr = 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
$id_attr    = ! empty( $id ) ? 'id="' . esc_attr( $id ) . '"' : '';
$id_attr   .= ! empty( $aria_label ) ? ' aria-label="' . esc_attr( $aria_label ) . '"' : '';
$id_attr   .= ! empty( $icon_set ) ? ' data-icon="' . esc_attr( $icon_left ) . '"' : '';
$id_attr   .= $secondary ? ' data-secondary="' . esc_attr( $secondary ) . '"' : '';

// A link that leaves the site — VK, Instagram, a messenger, a map — opens in a new tab, so the
// guest's place here stays one tab away (author, 30 Sep 2026; the site's hand-written external
// links already did). Our own pages, tel: and mailto: keep the tab.
$host     = $url ? wp_parse_url( $url, PHP_URL_HOST ) : '';
$external = $host && preg_match( '#^https?://#i', $url ) && strcasecmp( $host, (string) wp_parse_url( home_url(), PHP_URL_HOST ) ) !== 0;
$link_attr = $external ? 'target="_blank" rel="noopener"' : '';

$icon_left_html = '';
if ( ! empty( $icon_left_svg ) ) {
    $svg = sweet_pepper_inline_svg( 'assets/' . $icon_left_svg );
    if ( $svg ) {
        $icon_left_html = '<span class="btn-icon btn-icon-left">' . $svg . '</span>';
    }
} elseif ( ! empty( $icon_set ) ) {
    // Every glyph inlined, CSS shows the one data-icon names (buttons.css): an icon changes by
    // CSS showing one of its SVGs, never by JS editing it (design.md → Icons → Delivery)
    $icon_left_html = '<span class="btn-icon btn-icon-left btn-icon-set">';
    foreach ( $icon_set as $icon_name ) {
        $icon_left_html .= sweet_pepper_ph( $icon_name, 'fill', 'ph-icon--' . $icon_name );
    }
    $icon_left_html .= '</span>';
} elseif ( ! empty( $icon_left ) ) {
    $icon_left_html = '<span class="btn-icon btn-icon-left">' . sweet_pepper_ph( $icon_left, 'fill' ) . '</span>';
}

$icon_right_html = '';
if ( ! empty( $icon_right_svg ) ) {
    $svg = sweet_pepper_inline_svg( 'assets/' . $icon_right_svg );
    if ( $svg ) {
        $icon_right_html = '<span class="btn-icon btn-icon-right">' . $svg . '</span>';
    }
} elseif ( ! empty( $icon_right ) ) {
    $icon_right_html = '<span class="btn-icon btn-icon-right">' . sweet_pepper_ph( $icon_right, 'fill' ) . '</span>';
}

$label_html = $label_mobile
    ? '<span class="btn-label btn-label--desktop">' . esc_html( $label ) . '</span>'
      . '<span class="btn-label btn-label--mobile">' . esc_html( $label_mobile ) . '</span>'
    : '<span class="btn-label">' . esc_html( $label ) . '</span>';

if ( ! empty( $url ) ) {
    ?>
    <a href="<?php echo esc_url( $url ); ?>" <?php echo $id_attr; ?> <?php echo $class_attr; ?> <?php echo $link_attr; ?>>
        <?php echo $icon_left_html; ?>
        <?php echo $label_html; ?>
        <?php echo $icon_right_html; ?>
    </a>
    <?php
} else {
    ?>
    <button <?php echo $id_attr; ?> <?php echo $class_attr; ?>>
        <?php echo $icon_left_html; ?>
        <?php echo $label_html; ?>
        <?php echo $icon_right_html; ?>
    </button>
    <?php
}
