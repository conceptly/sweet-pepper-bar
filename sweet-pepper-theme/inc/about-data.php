<?php
/**
 * About data — where the About template parts get their content.
 *
 * The About page's fields (acf-json/group_sp_about.json, one tab per section), read
 * into template-part args in one language. Until a tab is saved the typed copy in
 * data/about/<section>.php renders instead, so a section converts without the page
 * ever going blank (the row and prose helpers — sweet_pepper_page_rows(),
 * sweet_pepper_page_text() — live in inc/fields.php, shared with the home page).
 *
 * @package Sweet_Pepper
 */


/**
 * Departments of an open role. The team picks one from a dropdown; the twins live here.
 */
function sweet_pepper_about_departments() {
    return [
        'service' => [ 'ru' => 'Зал',   'en' => 'Service' ],
        'kitchen' => [ 'ru' => 'Кухня', 'en' => 'Kitchen' ],
        'bar'     => [ 'ru' => 'Бар',   'en' => 'Bar' ],
    ];
}

/**
 * Careers: section header, open roles, the CV row and the no-openings box.
 *
 * No "we are hiring" switch: no visible role IS the empty state.
 *
 * The roles are `vacancy` records since 25 Sep 2026 (inc/vacancies.php → the open ones,
 * each card linking to its page) as soon as one record exists, whatever its state. Before
 * that — a site the seeder has not reached — the tab's «Вакансии» repeater still renders,
 * and before the tab was ever saved, the typed roles ("never saved" and "saved with no
 * roles" differ). The repeater is retired once the records are in: the tab keeps the
 * header, the CV row and the no-openings texts.
 *
 * @param int $page_id The About page.
 * @return array Args of template-parts/about/careers.php.
 */
function sweet_pepper_about_careers( $page_id ) {
    $typed = require get_template_directory() . '/data/about/careers.php';
    $lang  = sweet_pepper_lang();
    $text  = fn( $key ) => sp_field( "about_careers_{$key}", sweet_pepper_typed( $typed, $key ), $page_id );

    if ( function_exists( 'sweet_pepper_vacancies_exist' ) && sweet_pepper_vacancies_exist() ) {
        [ $headline, $headline_2 ] = sp_headline( 'about_careers_headline', $typed, $page_id );
        return [
            'eyebrow'     => $text( 'eyebrow' ),
            'headline'    => $headline,
            'headline_2'  => $headline_2,
            'description' => $text( 'description' ),
            'positions'   => sweet_pepper_vacancy_positions(),
            'cta_title'   => $text( 'cta_title' ),
            'cta_text'    => $text( 'cta_text' ),
            'empty_title' => $text( 'empty_title' ),
            'empty_text'  => $text( 'empty_text' ),
        ];
    }

    $saved = function_exists( 'get_field' ) && metadata_exists( 'post', $page_id, 'about_positions' );
    $rows  = $saved ? ( get_field( 'about_positions', $page_id ) ?: [] ) : []; // no rows comes back as false
    if ( ! $saved ) {
        // Typed rows, in the shape of a repeater row.
        foreach ( $typed['positions'] as $row ) {
            $twins = [];
            foreach ( [ 'title', 'meta', 'description' ] as $key ) {
                $twins[ "{$key}_en" ] = $row[ $key ] ?? '';
                $twins[ "{$key}_ru" ] = $row['ru'][ $key ] ?? '';
            }
            $rows[] = $twins + [ 'department' => $row['department'], 'url' => $row['url'] ];
        }
    }

    $departments = sweet_pepper_about_departments();
    $positions   = [];
    foreach ( $rows as $row ) {
        if ( ! empty( $row['hidden'] ) || '' === sweet_pepper_pick( $row, 'title' ) ) {
            continue;
        }
        $positions[] = [
            'department' => $departments[ $row['department'] ?? '' ][ $lang ] ?? '',
            'title'      => sweet_pepper_pick( $row, 'title' ),
            'meta'       => sweet_pepper_pick( $row, 'meta' ),
            'desc'       => sweet_pepper_pick( $row, 'description' ),
            'url'        => (string) ( $row['url'] ?? '' ),
            'link_label' => __( 'View role on hh.ru', 'sweet-pepper' ),
            'external'   => true,
        ];
    }

    [ $headline, $headline_2 ] = sp_headline( 'about_careers_headline', $typed, $page_id );

    return [
        'eyebrow'     => $text( 'eyebrow' ),
        'headline'    => $headline,
        'headline_2'  => $headline_2,
        'description' => $text( 'description' ),
        'positions'   => $positions,
        'cta_title'   => $text( 'cta_title' ),
        'cta_text'    => $text( 'cta_text' ),
        'empty_title' => $text( 'empty_title' ),
        'empty_text'  => $text( 'empty_text' ),
    ];
}

/**
 * The chip on a team card. The team picks one; the twins live here. `{name}` is the
 * member's name — in Russian the genitive the row carries («Пара слов от Леры»).
 */
function sweet_pepper_team_chips() {
    return [
        'ask'  => [ 'ru' => 'Спросите меня…',      'en' => 'Ask me about…' ],
        'word' => [ 'ru' => 'Пара слов от {name}', 'en' => 'A word from {name}' ],
        'pick' => [ 'ru' => 'Мой выбор',           'en' => 'My pick' ],
    ];
}

/**
 * "8 years" / «8 лет» from the year someone joined — printed, never typed, so it is
 * right next year too. Russian counts: 1 год · 2–4 года · 5–20 лет · 21 год …
 */
function sweet_pepper_years_since( $since, $lang ) {
    $n = (int) date( 'Y' ) - (int) $since;
    if ( ! $since || $n < 1 ) {
        return '';
    }
    if ( 'ru' === $lang ) {
        $mod10 = $n % 10;
        $mod100 = $n % 100;
        $word = ( 1 === $mod10 && 11 !== $mod100 ) ? 'год' : ( ( $mod10 >= 2 && $mod10 <= 4 && ( $mod100 < 12 || $mod100 > 14 ) ) ? 'года' : 'лет' );
        return "{$n} {$word}";
    }
    return 1 === $n ? '1 year' : "{$n} years";
}

/**
 * The Dream Team: section header, the photo wall, the members.
 *
 * @param int $page_id The About page.
 * @return array Args of template-parts/about/team.php.
 */
function sweet_pepper_about_team( $page_id ) {
    $typed = require get_template_directory() . '/data/about/team.php';
    $lang  = sweet_pepper_lang();
    $text  = fn( $key ) => sp_field( "about_team_{$key}", sweet_pepper_typed( $typed, $key ), $page_id );

    $saved = function_exists( 'get_field' ) && metadata_exists( 'post', $page_id, 'about_team_members' );

    $wall = [];
    $rows = $saved ? ( get_field( 'about_team_wall', $page_id ) ?: [] ) : [];
    if ( ! $saved ) {
        foreach ( $typed['wall'] as $row ) {
            $rows[] = [ 'photo' => '', 'year' => $row['year'], 'fallback' => $row['photo'] ];
        }
    }
    foreach ( $rows as $row ) {
        $src = sweet_pepper_photo_url( $row['photo'] ?? '', 'sp-3x2', $row['fallback'] ?? '' );
        if ( ! $src ) {
            continue;
        }
        $wall[] = [ 'src' => $src, 'label' => (string) ( $row['year'] ?? '' ) ];
    }

    $chips   = sweet_pepper_team_chips();
    $members = [];
    $rows    = $saved ? ( get_field( 'about_team_members', $page_id ) ?: [] ) : [];
    if ( ! $saved ) {
        foreach ( $typed['members'] as $row ) {
            $rows[] = [
                'photo'      => '',
                'fallback'   => $row['photo'],
                'name_en'    => $row['name'],
                'name_ru'    => $row['ru']['name'] ?? '',
                'name_gen'   => $row['ru']['name_gen'] ?? '',
                'since'      => $row['since'],
                'chip'       => $row['chip'],
                'role_en'    => $row['role'],
                'role_ru'    => $row['ru']['role'] ?? '',
                'message_en' => $row['message'],
                'message_ru' => $row['ru']['message'] ?? '',
            ];
        }
    }
    foreach ( $rows as $row ) {
        $name = sweet_pepper_pick( $row, 'name' );
        if ( '' === $name ) {
            continue;
        }
        $role  = sweet_pepper_pick( $row, 'role' );
        $years = sweet_pepper_years_since( $row['since'] ?? 0, $lang );
        $chip  = $chips[ $row['chip'] ?? 'ask' ] ?? $chips['ask'];
        $gen   = ( 'ru' === $lang && ! empty( $row['name_gen'] ) ) ? $row['name_gen'] : $name;

        $members[] = [
            'name'    => $name,
            'role'    => $role . ( $years ? " · {$years}" : '' ),
            'photo'   => sweet_pepper_photo_url( $row['photo'] ?? '', 'sp-square', $row['fallback'] ?? '' ),
            'chip'    => str_replace( '{name}', $gen, $chip[ $lang ] ),
            'message' => sweet_pepper_pick( $row, 'message' ),
        ];
    }

    [ $headline, $headline_2 ] = sp_headline( 'about_team_headline', $typed, $page_id );

    return [
        'eyebrow'    => $text( 'eyebrow' ),
        'headline'   => $headline,
        'headline_2' => $headline_2,
        'wall'       => $wall,
        'members'    => $members,
    ];
}

/**
 * Six or eight members, never seven: the grid is four across (two on tablets), and an odd
 * count leaves a hole (author, 21 Sep 2026). The repeater's min / max hold the range; this
 * holds the parity.
 */
add_filter( 'acf/validate_value/name=about_team_members', function ( $valid, $value ) {
    if ( true !== $valid ) {
        return $valid;
    }
    $count = is_array( $value ) ? count( $value ) : 0;
    return ( $count % 2 ) ? 'Шесть или восемь человек — чётное число, иначе в сетке остаётся пустое место.' : $valid;
}, 10, 2 );

/**
 * Hero: eyebrow, headline, lead. The filmstrip is structure (the template's).
 */
function sweet_pepper_about_hero( $page_id ) {
    $typed = require get_template_directory() . '/data/about/hero.php';
    $text  = sweet_pepper_page_text( $page_id, 'about_hero', $typed );
    [ $headline, $headline_2 ] = sp_headline( 'about_hero_headline', $typed, $page_id );
    return [ 'eyebrow' => $text( 'eyebrow' ), 'headline' => $headline, 'headline_2' => $headline_2, 'lead' => $text( 'lead' ) ];
}

/**
 * The Concept's section header. The picker is fed by inc/pairings.php.
 */
function sweet_pepper_about_concept( $page_id ) {
    $typed = require get_template_directory() . '/data/about/concept.php';
    $text  = sweet_pepper_page_text( $page_id, 'about_concept', $typed );
    [ $headline, $headline_2 ] = sp_headline( 'about_concept_headline', $typed, $page_id );
    return [ 'eyebrow' => $text( 'eyebrow' ), 'headline' => $headline, 'headline_2' => $headline_2, 'description' => $text( 'description' ) ];
}

/**
 * How it feels: the header and the quote cards, in the template's own shape (text = the
 * Russian original, text_en = the English — the card shows one and links the other).
 * The words are the template's until the tally pipeline lands.
 */
function sweet_pepper_about_reviews( $page_id ) {
    $typed = require get_template_directory() . '/data/about/reviews.php';
    $text  = sweet_pepper_page_text( $page_id, 'about_reviews', $typed );
    [ $saved, $rows ] = sweet_pepper_page_rows( $page_id, 'about_quotes', $typed['quotes'], [] );
    $quotes = [];
    foreach ( $rows as $i => $row ) {
        $ru = trim( (string) ( $row[ $saved ? 'text_ru' : 'text' ] ?? '' ) );
        $en = trim( (string) ( $row['text_en'] ?? '' ) );
        if ( '' === $ru && '' === $en ) {
            continue;
        }
        $quotes[] = [
            'id'       => $row[ $saved ? 'quote_id' : 'id' ] ?: 'q' . ( $i + 1 ),
            'text'     => $ru ?: $en,
            'text_en'  => $en,
            'platform' => (string) ( $row['platform'] ?? 'Yandex' ),
            'date'     => (string) ( $row['date'] ?? '' ),
            'footnote' => $saved ? sweet_pepper_pick( $row, 'footnote' ) : (string) ( $row['footnote'] ?? '' ),
            'link'     => (string) ( $row['link'] ?? '' ),
            'word'     => (string) ( $row['word'] ?? '' ),
        ];
    }
    [ $headline, $headline_2 ] = sp_headline( 'about_reviews_headline', $typed, $page_id );
    return [ 'eyebrow' => $text( 'eyebrow' ), 'headline' => $headline, 'headline_2' => $headline_2, 'quotes' => $quotes ];
}

/**
 * Every quote gets a stable id on save (the JS keys cards by it), like the menu's dish rows.
 */
function sweet_pepper_about_fill_quote_ids( $post_id ) {
    if ( 'page' !== get_post_type( $post_id ) || 'page-about.php' !== get_page_template_slug( $post_id ) ) {
        return;
    }
    $seen = [];
    foreach ( (array) get_field( 'about_quotes', $post_id ) as $i => $row ) {
        $id = $row['quote_id'] ?? '';
        if ( '' === $id || isset( $seen[ $id ] ) ) {
            $id = 'q-' . bin2hex( random_bytes( 3 ) );
            update_sub_field( [ 'about_quotes', $i + 1, 'quote_id' ], $id, $post_id );
        }
        $seen[ $id ] = true;
    }
}
add_action( 'acf/save_post', 'sweet_pepper_about_fill_quote_ids', 20 );

/**
 * Beyond Shake & Cook: the six stamps. Colour is dealt here (Lime → Lemon → Paprika), so it
 * never depends on the form.
 */
function sweet_pepper_about_perks( $page_id ) {
    $typed = require get_template_directory() . '/data/about/perks.php';
    $text  = sweet_pepper_page_text( $page_id, 'about_perks', $typed );
    [ , $rows ] = sweet_pepper_page_rows( $page_id, 'about_perks', $typed['perks'], [ 'label', 'word', 'title', 'description' ] );
    $palette = [ 'lime', 'lemon', 'paprika' ];
    $perks   = [];
    foreach ( array_slice( $rows, 0, 6 ) as $i => $row ) {
        $label = sweet_pepper_pick( $row, 'label' );
        if ( '' === $label ) {
            continue;
        }
        $icon    = preg_replace( '/[^a-z-]/', '', (string) ( $row['icon'] ?? '' ) ) ?: 'star';
        $perks[] = [
            'id'          => $icon . '-' . $i,
            'label'       => $label,
            'word'        => sweet_pepper_pick( $row, 'word' ) ?: $label,
            'icon'        => $icon,
            'color'       => $palette[ $i % 3 ],
            'title'       => sweet_pepper_pick( $row, 'title' ),
            'description' => sweet_pepper_pick( $row, 'description' ),
        ];
    }
    [ $headline, $headline_2 ] = sp_headline( 'about_perks_headline', $typed, $page_id );
    return [ 'eyebrow' => $text( 'eyebrow' ), 'headline' => $headline, 'headline_2' => $headline_2, 'perks' => $perks ];
}

/**
 * The Pepper Story: prose, the founder card, three milestones, the counter ledger.
 */
function sweet_pepper_about_story( $page_id ) {
    $typed = require get_template_directory() . '/data/about/story.php';
    $text  = sweet_pepper_page_text( $page_id, 'about_story', $typed );
    $fnd   = fn( $key ) => sp_field( "about_founder_{$key}", sweet_pepper_typed( $typed, "founder_{$key}" ), $page_id );

    $saved = function_exists( 'get_field' ) && metadata_exists( 'post', $page_id, 'about_milestones' );
    $photo = sweet_pepper_photo_url( $saved ? get_field( 'about_founder_photo', $page_id ) : '', 'sp-square', $typed['founder_photo'] );

    [ , $rows ] = sweet_pepper_page_rows( $page_id, 'about_milestones', $typed['milestones'], [ 'name', 'wit' ] );
    $milestones = [];
    foreach ( array_slice( $rows, 0, 3 ) as $i => $row ) {
        $milestones[] = [
            'year' => 2 === $i ? date( 'Y' ) : (string) ( $row['year'] ?? '' ), // the last marker is now
            'name' => sweet_pepper_pick( $row, 'name' ),
            'wit'  => sweet_pepper_pick( $row, 'wit' ),
        ];
    }

    [ , $rows ] = sweet_pepper_page_rows( $page_id, 'about_counters', $typed['counters'], [ 'label' ] );
    $counters = [];
    foreach ( $rows as $row ) {
        if ( (int) ( $row['number'] ?? 0 ) > 0 && '' !== sweet_pepper_pick( $row, 'label' ) ) {
            $counters[] = [ 'number' => (int) $row['number'], 'label' => sweet_pepper_pick( $row, 'label' ) ];
        }
    }

    [ $headline, $headline_2 ] = sp_headline( 'about_story_headline', $typed, $page_id );
    [ $label, $label_2 ]       = sp_headline( 'about_counters_label', [ 'headline' => $typed['counters_label'], 'headline_2' => $typed['counters_label_2'], 'ru' => [ 'headline' => $typed['ru']['counters_label'] ?? '', 'headline_2' => $typed['ru']['counters_label_2'] ?? '' ] ], $page_id );

    return [
        'eyebrow'          => $text( 'eyebrow' ),
        'headline'         => $headline,
        'headline_2'       => $headline_2,
        'paragraphs'       => [ $text( 'p1' ), $text( 'p2' ), $text( 'p3' ) ],
        'founder_photo'    => $photo,
        'founder_alt'      => $fnd( 'alt' ),
        'founder_quote'    => $fnd( 'quote' ),
        'founder_name'     => $fnd( 'name' ),
        'founder_title'    => $fnd( 'title' ),
        'milestones'       => $milestones,
        'counters_label'   => $label,
        'counters_label_2' => $label_2,
        'counters'         => $counters,
    ];
}

/**
 * The Dream Guests: header and the first eight album cards.
 */
function sweet_pepper_about_guests( $page_id ) {
    $typed = require get_template_directory() . '/data/about/guests.php';
    $text  = sweet_pepper_page_text( $page_id, 'about_guests', $typed );
    [ , $rows ] = sweet_pepper_page_rows( $page_id, 'about_guest_cards', $typed['cards'], [ 'label', 'alt' ] );
    $cards = [];
    foreach ( $rows as $row ) {
        $src = sweet_pepper_photo_url( $row['photo'] ?? '', 'sp-square', is_string( $row['photo'] ?? null ) ? $row['photo'] : '' );
        if ( ! $src || '' === sweet_pepper_pick( $row, 'label' ) ) {
            continue;
        }
        $cards[] = [ 'src' => $src, 'label' => sweet_pepper_pick( $row, 'label' ), 'alt' => sweet_pepper_pick( $row, 'alt' ), 'url' => (string) ( $row['url'] ?? '' ) ];
        if ( 8 === count( $cards ) ) {
            break;
        }
    }
    [ $headline, $headline_2 ] = sp_headline( 'about_guests_headline', $typed, $page_id );
    return [ 'eyebrow' => $text( 'eyebrow' ), 'headline' => $headline, 'headline_2' => $headline_2, 'description' => $text( 'description' ), 'cards' => $cards ];
}

/**
 * Location: the description under the shared headline (inc/location.php).
 */
function sweet_pepper_about_location( $page_id ) {
    $typed = require get_template_directory() . '/data/about/location.php';
    return [ 'description' => sp_field( 'about_location_description', sweet_pepper_typed( $typed, 'description' ), $page_id ) ];
}

/**
 * Visit CTA: headline and body.
 */
function sweet_pepper_about_cta( $page_id ) {
    $typed = require get_template_directory() . '/data/about/cta.php';
    $text  = sweet_pepper_page_text( $page_id, 'about_cta', $typed );
    return [ 'headline' => $text( 'headline' ), 'body' => $text( 'body' ) ];
}

/**
 * The hand-clicked "About" group (one field, `about_hero_headline`, 9 Sep 2026) is folded
 * into the Hero tab's `about_hero_headline_ru` / `_en`; its JSON is deleted, and a copy
 * SCF had imported into the database is removed once so the page does not show two groups.
 */
add_action( 'init', function () {
    if ( get_option( 'sweet_pepper_about_group_folded' ) || ! function_exists( 'acf_get_field_group' ) ) {
        return;
    }
    $old = acf_get_field_group( 'group_6aa221f88c4c6' );
    if ( $old && ! empty( $old['ID'] ) ) {
        acf_delete_field_group( $old['ID'] );
    }
    update_option( 'sweet_pepper_about_group_folded', 1 );
}, 20 );
