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
 * }
 */

$label      = $args['label'] ?? 'Button';
$url        = $args['url'] ?? '';
$type       = $args['variant'] ?? ( $args['type'] ?? 'primary' );
$icon_left  = $args['icon_left'] ?? ( $args['icon'] ?? '' );
$icon_right = $args['icon_right'] ?? '';
$icon_left_svg  = $args['icon_left_svg'] ?? '';
$icon_right_svg = $args['icon_right_svg'] ?? '';
$class      = $args['class'] ?? '';
$id         = $args['id'] ?? '';
$aria_label = $args['aria_label'] ?? ''; // an accessible name fuller than the label (the drawer's phone button)
$label_mobile = $args['label_mobile'] ?? '';
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

$icon_left_html = '';
if ( ! empty( $icon_left_svg ) ) {
    $svg = sweet_pepper_inline_svg( 'assets/' . $icon_left_svg );
    if ( $svg ) {
        $icon_left_html = '<span class="btn-icon btn-icon-left">' . $svg . '</span>';
    }
} elseif ( ! empty( $icon_left ) ) {
    $icon_left_html = '<span class="btn-icon btn-icon-left"><i class="ph-fill ph-' . esc_attr( $icon_left ) . '" aria-hidden="true"></i></span>';
}

$icon_right_html = '';
if ( ! empty( $icon_right_svg ) ) {
    $svg = sweet_pepper_inline_svg( 'assets/' . $icon_right_svg );
    if ( $svg ) {
        $icon_right_html = '<span class="btn-icon btn-icon-right">' . $svg . '</span>';
    }
} elseif ( ! empty( $icon_right ) ) {
    $icon_right_html = '<span class="btn-icon btn-icon-right"><i class="ph-fill ph-' . esc_attr( $icon_right ) . '" aria-hidden="true"></i></span>';
}

$label_html = $label_mobile
    ? '<span class="btn-label btn-label--desktop">' . esc_html( $label ) . '</span>'
      . '<span class="btn-label btn-label--mobile">' . esc_html( $label_mobile ) . '</span>'
    : '<span class="btn-label">' . esc_html( $label ) . '</span>';

if ( ! empty( $url ) ) {
    ?>
    <a href="<?php echo esc_url( $url ); ?>" <?php echo $id_attr; ?> <?php echo $class_attr; ?>>
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
