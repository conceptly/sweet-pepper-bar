<?php
/**
 * About page — section connector. Thin wrapper: the shared part
 * (template-parts/components/connector.php) does the work with set 'about';
 * kept so the About templates' calls and the CSS class names stay as they are.
 *
 * @param array $args  word · position · alt — see the shared part.
 */

get_template_part( 'template-parts/components/connector', null, array_merge( (array) $args, [ 'set' => 'about' ] ) );
