<?php
/**
 * Section link — live-text connector (prototype, Sep 2026).
 *
 * A one-to-one build of the Figma `SectionLink` component set (212:2442) as HTML text
 * instead of an exported SVG, so the component can be judged and refined in the browser.
 * website-brief.md → Section connectors still says "must be SVG"; this part exists to
 * test that rule, not to replace it yet. Anatomy from the component:
 *
 *   frame   1252 wide, 80px gutters (= the page container), text left, bottom-aligned
 *   text    Molot 122 / 75% / 4% tracking, fixed 1100 box
 *   Default    frame at 50% with a 0.5px Mushroom rule under the word
 *              dark:  Cream 1px outside stroke + Peppercorn→transparent fill (bottom→top)
 *              light: Olive 2px outside stroke, no fill
 *   reflection the same text flipped vertically, no rule
 *              dark:  Paper 1px outside stroke, same gradient fill, frame at 30%
 *              light: Lime 1px outside stroke, no fill, frame at 100%
 *
 * On the site the word is sized to span the container (the width-matching rule the
 * SVGs followed), so `section-link.js` fits the font size to the container width;
 * 122px is the no-JS fallback (34 on phones, from SectionLinkMobile).
 *
 * @param array $args {
 *     @type string $text   The words, as written (Molot sets them in caps).
 *     @type string $state  'word' (Figma "Default") | 'reflection'. Default 'word'.
 *     @type string $theme  'dark' | 'light' — the ground it sits on. Default 'dark'.
 *     @type string $class  Optional extra classes.
 * }
 */

$text  = $args['text'] ?? '';
$state = ( $args['state'] ?? 'word' ) === 'reflection' ? 'reflection' : 'word';
$theme = $args['theme'] ?? 'dark';
$theme = in_array( $theme, [ 'light', 'dark', 'auto' ], true ) ? $theme : 'dark'; // 'auto': the page's CSS reads the ground from the section (about.css)
$class = $args['class'] ?? '';

if ( '' === $text ) {
    return;
}
?>
<div class="section-link section-link--<?php echo esc_attr( $state ); ?> section-link--<?php echo esc_attr( $theme ); ?> <?php echo esc_attr( $class ); ?>" aria-hidden="<?php echo 'reflection' === $state ? 'true' : 'false'; ?>">
    <span class="section-link__text molot-text"><?php echo esc_html( $text ); ?></span>
</div>
