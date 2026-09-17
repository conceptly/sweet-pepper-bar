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
 *   Success  — "Copied!" + fire icon, auto-reverts after 2s
 *
 * @param array $args {
 *     @type string $icon_svg        Path (from assets/) to the leading icon SVG. Required.
 *     @type string $contact         Contact text (e.g. "hello@sweetpepperbar.ru"). Required.
 *     @type string $copy_text       Text to copy to clipboard. Defaults to $contact.
 *     @type string $supportive_text Secondary line of text. Omit to hide.
 * }
 */

$icon_svg        = $args['icon_svg'] ?? '';
$contact         = $args['contact'] ?? '';
$copy_text       = $args['copy_text'] ?? $contact;
$supportive_text = $args['supportive_text'] ?? '';
?>
<div class="contact-item js-contact-item">
    <?php if ( $icon_svg ) : ?>
        <span class="contact-item__icon"><?php echo sweet_pepper_inline_svg( 'assets/' . $icon_svg ); ?></span>
    <?php endif; ?>
    <div class="contact-item__body">
        <div class="contact-item__main">
            <span class="contact-item__text"><?php echo esc_html( $contact ); ?></span>
            <button
                class="contact-item__copy-chip js-contact-copy"
                data-copy-text="<?php echo esc_attr( $copy_text ); ?>"
                type="button"
            >
                <span class="contact-item__chip-label">Copy</span>
                <span class="contact-item__chip-icon contact-item__chip-icon--copy"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                <span class="contact-item__chip-icon contact-item__chip-icon--done"><?php echo sweet_pepper_inline_svg( 'assets/icons/fire.svg' ); ?></span>
            </button>
        </div>
        <?php if ( $supportive_text ) : ?>
            <span class="contact-item__supportive"><?php echo esc_html( $supportive_text ); ?></span>
        <?php endif; ?>
    </div>
</div>
