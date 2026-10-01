<?php
/**
 * The 404 page's number (PROTOTYPE, 1 Oct 2026). Decorative: the headline is the page's
 * title, so the digits are hidden from screen readers.
 *
 * @param array $args {
 *     @type string $mode 'pop'  — Figma lettersSize 2807:77957: each digit swells in turn and
 *                                 the set changes colour with it (one span per digit);
 *                        'sunk' — the giant number standing in the footer, a Chili level
 *                                 rising in it (one text run; the fill is its ::after).
 * }
 */

$mode = 'sunk' === ( $args['mode'] ?? '' ) ? 'sunk' : 'pop';
?>
<?php if ( 'pop' === $mode ) : ?>
    <p class="not-found__digits not-found__digits--pop molot-text" aria-hidden="true"><span>4</span><span>0</span><span>4</span></p>
<?php else : ?>
    <p class="not-found__digits not-found__digits--sunk molot-text" aria-hidden="true" data-text="404">404</p>
<?php endif; ?>
