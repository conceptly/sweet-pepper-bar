<?php
/**
 * About page — section connector. Thin wrapper: the shared part
 * (template-parts/components/connector.php) does the work with set 'about';
 * kept so the About templates' calls and the CSS class names stay as they are.
 *
 * The templates name the English word; on a Russian request it is swapped here for
 * its RU twin (connector-copy.md → About page) — the stem points into
 * assets/sectionLinks/about/ru/, the alt drives the live-text prototype. Structure,
 * not a field (website-brief.md → Content editing: connectors stay in code).
 *
 * @param array $args  word · position · alt — see the shared part.
 */

$args = array_merge( (array) $args, [ 'set' => 'about' ] );

if ( 'ru' === sweet_pepper_lang() ) {
    $ru = [
        'betterTogether'     => [ 'здесьМожноВсё', 'Здесь можно всё' ],
        'wordOfMouth'        => [ 'словоЛюбимымГостям', 'Слово любимым гостям' ],
        'littleThingsMatter' => [ 'продуманоДоМелочей', 'Продумано до мелочей' ],
        'backToTheFirstPour' => [ 'сагаОПерцахИНастойках', 'Сага о перцах и настойках' ],
        'inGoodCompany'      => [ 'главныеГероиЗаСтоликами', 'Главные герои за столиками' ],
        'theUsualSuspects'   => [ 'звёздыКаждойСмены', 'Звёзды каждой смены' ],
        'RoomForOneMore'     => [ 'твоёМестоВКоманде', 'Твоё место в команде' ],
        'makeYourselfAtHome' => [ 'всеДорогиВедутВПерец', 'Все дороги ведут в Перец' ],
        'NowItsYourTurn'     => [ 'забегайтеНаОгонёк', 'Забегайте на огонёк' ],
    ][ $args['word'] ?? '' ] ?? null;

    if ( $ru ) {
        $args['word'] = 'ru/' . $ru[0];
        $args['alt']  = $ru[1];
    }
}

get_template_part( 'template-parts/components/connector', null, $args );
