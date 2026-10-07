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
 * A third item is a shorter phone wording (≤ 767px), word and reflection alike — the
 * author's phone set, 6 Oct 2026 (assets/sectionLinks/about/mobile/ru/ gives the words):
 * the fit pass sizes each connector to the container width, so a shorter line stands taller.
 *
 * @param array $args  word · position · alt — see the shared part.
 */

$args = array_merge( (array) $args, [ 'set' => 'about' ] );

if ( 'ru' === sweet_pepper_lang() ) {
    $ru = [
        'betterTogether'     => [ 'здесьМожноВсё', 'Здесь можно всё' ],
        'wordOfMouth'        => [ 'словоЛюбимымГостям', 'Слово любимым гостям', 'Слово за гостями' ],
        'littleThingsMatter' => [ 'продуманоДоМелочей', 'Продумано до мелочей' ],
        'backToTheFirstPour' => [ 'сагаОПерцахИНастойках', 'Сага о перцах и настойках', 'О перцах и настойках' ],
        'inGoodCompany'      => [ 'главныеГероиЗаСтоликами', 'Главные герои за столиками', 'Герои за столиками' ],
        'theUsualSuspects'   => [ 'звёздыКаждойСмены', 'Звёзды каждой смены' ],
        'RoomForOneMore'     => [ 'твоёМестоВКоманде', 'Твоё место в команде' ],
        'makeYourselfAtHome' => [ 'всеДорогиВедутВПерец', 'Все дороги ведут в Перец', 'Карты, явки, пароли' ],
        'NowItsYourTurn'     => [ 'забегайтеНаОгонёк', 'Забегайте на огонёк' ],
    ][ $args['word'] ?? '' ] ?? null;

    if ( $ru ) {
        $args['word'] = 'ru/' . $ru[0];
        $args['alt']  = $ru[1];
        if ( ! empty( $ru[2] ) ) {
            $args['alt_mobile'] = $ru[2];
        }
    }
}

get_template_part( 'template-parts/components/connector', null, $args );
