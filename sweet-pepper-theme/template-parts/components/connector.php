<?php
/**
 * Section connector — the word at a section's foot, its reflection opening the next
 * (website-brief.md → Section connectors). Shared by the fixed compositions: About
 * (assets/sectionLinks/about/) and Visit (assets/sectionLinks/visit/). Each set is
 * desktop-width exports (~1090 wide) of the Figma `SectionLink` component with the
 * colours baked per ground — one file per word/state serves day and night — and scales
 * to 370 on phones exactly like the home files, which keeps the stroke weight equal
 * across pages. The page's CSS owns the rhythm and the reflection opacity
 * (about.css → Connectors; visit.css → Connectors).
 *
 * PROTOTYPE (Sep 2026): with $live_text = true the connector renders the Figma
 * component as HTML text instead (template-parts/components/section-link.php), the
 * wording taken from $alt, the ground taken from the section it sits in. One flag for
 * every page that uses this part, so the SVG-vs-text decision lands everywhere at once.
 *
 * @param array $args {
 *     @type string $set      Export set: 'about' | 'visit'. Default 'about'.
 *     @type string $word     File stem in assets/sectionLinks/{set}/ (e.g. 'betterTogether').
 *     @type string $position 'foot' (the word, end of this section) or 'head' (its reflection,
 *                            start of the next section). Default 'foot'.
 *     @type string $alt      Alt text — the words as written.
 * }
 */

$set      = preg_replace( '/[^a-z]/', '', strtolower( $args['set'] ?? 'about' ) ) ?: 'about';
$word     = $args['word'] ?? '';
$position = ( $args['position'] ?? 'foot' ) === 'head' ? 'head' : 'foot';
$alt      = $args['alt'] ?? '';

// ── Prototype switch: live text (Figma component rebuilt) vs the SVG exports ──
$live_text = true;

if ( ! $word ) {
    return;
}

// .{set}-connector is what the page stylesheet targets (about.css / visit.css)
$classes = sprintf( 'container %1$s-connector %1$s-connector--%2$s', $set, $position );

if ( $live_text ) :
    ?>
    <div class="<?php echo esc_attr( $classes ); ?>">
        <?php
        get_template_part( 'template-parts/components/section-link', null, [
            'text'  => $alt ?: $word,
            'state' => 'head' === $position ? 'reflection' : 'word',
            'theme' => 'auto',
        ] );
        ?>
    </div>
    <?php
    return;
endif;

$file = 'assets/sectionLinks/' . $set . '/' . $word . ( 'head' === $position ? '-reflection' : '' ) . '.svg';

if ( ! file_exists( get_template_directory() . '/' . $file ) ) {
    return;
}
?>
<div class="<?php echo esc_attr( $classes ); ?>">
    <?php
    get_template_part( 'template-parts/components/section-link-word', null, [
        'day_img'   => $file,
        'night_img' => $file,
        'alt'       => $alt,
        'class'     => 'head' === $position ? 'section-link-word--reflection' : '',
    ] );
    ?>
</div>
