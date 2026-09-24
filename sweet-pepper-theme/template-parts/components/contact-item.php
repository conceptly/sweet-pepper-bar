<?php
/**
 * Reusable contact-item component.
 *
 * Matches Figma: contactItem-day (1819-128718)
 *
 * 4 states managed via hover interaction (CSS + JS):
 *   Default  — icon + contact text + supportive text, copy chip hidden
 *   Hover    — copy chip slides in (cream bg)
 *   Hover2   — copy chip bg → lemon when chip itself is hovered
 *   Success  — "Copied!" + checkmark, auto-reverts after 2s (the fire until 24 Sep 2026 — the
 *              address chips' checkmark is the one success glyph now)
 *
 * On Russian pages the chip is the icon alone (author, 24 Sep 2026): «Скопировать» is 11
 * letters against "Copy" at 4 and ran into the row's action link. The word stays in the
 * button, visually hidden, so it still names the chip; the label is a live region, so the
 * success word is read out; `title` gives mouse users the word on hover.
 *
 * @param array $args {
 *     @type string $icon_svg        Path (from assets/) to the leading icon SVG. Required.
 *     @type string $contact         Contact text (e.g. "hello@sweetpepper.bar"). Required.
 *     @type string $copy_text       Text to copy to clipboard. Defaults to $contact.
 *     @type string $supportive_text Secondary line of text. Omit to hide.
 * }
 */

$icon_svg        = $args['icon_svg'] ?? '';
$contact         = $args['contact'] ?? '';
$copy_text       = $args['copy_text'] ?? $contact;
$supportive_text = $args['supportive_text'] ?? '';
$icon_only       = ( 'ru' === sweet_pepper_lang() );
?>
<div class="contact-item js-contact-item">
    <?php if ( $icon_svg ) : ?>
        <span class="contact-item__icon"><?php echo sweet_pepper_inline_svg( 'assets/' . $icon_svg ); ?></span>
    <?php endif; ?>
    <div class="contact-item__body">
        <div class="contact-item__main">
            <span class="contact-item__text"><?php echo esc_html( $contact ); ?></span>
            <button
                class="contact-item__copy-chip js-contact-copy<?php echo $icon_only ? ' contact-item__copy-chip--icon' : ''; ?>"
                data-copy-text="<?php echo esc_attr( $copy_text ); ?>"
                data-copied-label="<?php esc_attr_e( 'Copied!', 'sweet-pepper' ); ?>"
                <?php if ( $icon_only ) : ?>title="<?php esc_attr_e( 'Copy', 'sweet-pepper' ); ?>"<?php endif; ?>
                type="button"
            >
                <span class="contact-item__chip-label" aria-live="polite"><?php esc_html_e( 'Copy', 'sweet-pepper' ); ?></span>
                <span class="contact-item__chip-icon contact-item__chip-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                <span class="contact-item__chip-icon contact-item__chip-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
            </button>
        </div>
        <?php if ( $supportive_text ) : ?>
            <span class="contact-item__supportive"><?php echo esc_html( $supportive_text ); ?></span>
        <?php endif; ?>
    </div>
</div>
