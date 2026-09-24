<?php
/**
 * Visit page — section connector. Thin wrapper, as About's (template-parts/about/connector.php):
 * the shared part (template-parts/components/connector.php) does the work with set 'visit'.
 *
 * The templates name the English word; on a Russian request it is swapped here for its RU
 * twin (visit-page-copy-ru-draft.md → Коннекторы; connector-copy.md → Visit page) — the stem
 * points into assets/sectionLinks/visit/ru/, the alt drives the live-text prototype.
 * Structure, not a field (website-brief.md → Content editing: connectors stay in code).
 *
 * @param array $args  word · position · alt — see the shared part.
 */

$args = array_merge( (array) $args, [ 'set' => 'visit' ] );

if ( 'ru' === sweet_pepper_lang() ) {
    $ru = [
        'yourRouteToPepper' => [ 'всеДорогиВедутВПерец', 'Все дороги ведут в Перец' ],
        'dropALittleNote'   => [ 'сказатьПаруЛасковых', 'Сказать пару ласковых' ],
    ][ $args['word'] ?? '' ] ?? null;

    if ( $ru ) {
        $args['word'] = 'ru/' . $ru[0];
        $args['alt']  = $ru[1];
    }
}

get_template_part( 'template-parts/components/connector', null, $args );
