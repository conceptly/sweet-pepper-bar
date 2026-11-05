<?php
/**
 * Rugged Edge Component
 * Renders a row of downward-facing half circles, mimicking the Figma 'ruggedEdge' component.
 * 
 * @param array $args {
 *     @type string $color   The color token name (e.g., 'surface', 'paper', 'soft-peppercorn').
 *                           Defaults to 'surface'.
 *                           Inside a .menu-section use 'section-bg': the section exposes its
 *                           striped ground as --section-bg (menu-section.css), so the edge
 *                           follows the alternation instead of guessing --bg / --surface.
 * }
 */

$color = $args['color'] ?? 'surface';
?>
<div class="rugged-edge" style="--rugged-color: var(--<?php echo esc_attr($color); ?>);" aria-hidden="true"></div>
