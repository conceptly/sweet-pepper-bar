<?php
/**
 * Vacancies — one record per job opening, with its own page (built 25 Sep 2026).
 *
 * The team posts an opening on the website to share it with their own network first,
 * hh.ru when needed (website-brief.md → Content editing → *Vacancies*). A `vacancy` post
 * («Вакансии», inc/cpt.php; fields acf-json/group_sp_vacancy.json) holds the role in two
 * languages; single-vacancy.php renders it at /vacancies/<slug>/ (and /en/…); the About
 * page's Careers section lists the open ones (inc/about-data.php reads
 * sweet_pepper_vacancy_positions()).
 *
 * ONE CONTROL — «На сайте» (vacancy_show: 'archive' | '1' | '2' | '4' weeks) — posts, closes
 * and republishes. The theme keeps the dates as post meta and never asks the team for one:
 *   _sp_vacancy_until   when the posting closes (0 = archived)
 *   _sp_vacancy_opened  when the current term started — "open since" on the page
 *   _sp_vacancy_closed  when it went to the archive — "в архиве с" in admin
 *   _sp_vacancy_weeks   the term `until` was computed from
 * Rules (sweet_pepper_vacancy_apply_show()): a term counts from the save; saving an open
 * posting again with the same term changes nothing (a typo fix never extends it); changing
 * the term on an open posting counts again from today; «В архиве» closes now; a term on an
 * archived record opens it again. The daily sweep (WP-Cron, the mechanism the VK importer
 * uses; on hosting a system cron calls wp-cron.php) flips a posting whose date passed to
 * «В архиве» and purges the page cache — otherwise a cached page would keep showing it.
 * The page and the About list also check the date at render time, so the hour between the
 * date and the sweep never shows a closed role.
 *
 * A closed posting keeps its URL — links shared on VK outlive the term. Its page keeps the
 * head, says the role is filled, shows the open roles and the CV row, and is `noindex`.
 *
 * Contact: the bar's channels (inc/contacts.php) by default, or a person from Bar Settings →
 * «Кто отвечает за вакансии», picked in the record's «Контакт» select. With a person, the
 * bar's phone and email stay as a second block on the page.
 *
 * @package Sweet_Pepper
 */

const SWEET_PEPPER_VACANCY_SWEEP = 'sweet_pepper_vacancy_sweep';

// ── State ────────────────────────────────────────────────────────────────────────────────
/**
 * The posting's dates, as stored.
 *
 * @return array{until:int, opened:int, closed:int, weeks:int}
 */
function sweet_pepper_vacancy_meta( $post_id ) {
    return [
        'until'  => (int) get_post_meta( $post_id, '_sp_vacancy_until', true ),
        'opened' => (int) get_post_meta( $post_id, '_sp_vacancy_opened', true ),
        'closed' => (int) get_post_meta( $post_id, '_sp_vacancy_closed', true ),
        'weeks'  => (int) get_post_meta( $post_id, '_sp_vacancy_weeks', true ),
    ];
}

/** The «На сайте» value: 'archive', or the term in weeks as a string. */
function sweet_pepper_vacancy_show( $post_id ) {
    $show = function_exists( 'get_field' ) ? (string) get_field( 'vacancy_show', $post_id ) : '';
    return in_array( $show, [ '1', '2', '4' ], true ) ? $show : 'archive';
}

/** Published, with a term, and the date not yet passed — the render-time truth. */
function sweet_pepper_vacancy_is_open( $post_id ) {
    if ( 'publish' !== get_post_status( $post_id ) || 'archive' === sweet_pepper_vacancy_show( $post_id ) ) {
        return false;
    }
    return sweet_pepper_vacancy_meta( $post_id )['until'] > time();
}

/**
 * «На сайте» → the dates. Runs on every save of a vacancy (after SCF has written the fields).
 */
function sweet_pepper_vacancy_apply_show( $post_id ) {
    $show = sweet_pepper_vacancy_show( $post_id );
    $meta = sweet_pepper_vacancy_meta( $post_id );
    $now  = time();

    if ( 'archive' === $show ) {
        if ( $meta['until'] ) {
            update_post_meta( $post_id, '_sp_vacancy_closed', $now );
        }
        update_post_meta( $post_id, '_sp_vacancy_until', 0 );
        update_post_meta( $post_id, '_sp_vacancy_weeks', 0 );
        return;
    }

    $weeks = (int) $show;
    if ( $meta['until'] > $now && $meta['weeks'] === $weeks ) {
        return; // open, same term — an edit, not a republish
    }
    update_post_meta( $post_id, '_sp_vacancy_until', $now + $weeks * WEEK_IN_SECONDS );
    update_post_meta( $post_id, '_sp_vacancy_opened', $now );
    update_post_meta( $post_id, '_sp_vacancy_weeks', $weeks );
    update_post_meta( $post_id, '_sp_vacancy_closed', 0 );
}

/**
 * The address stays Latin: the slug comes from the English title (WordPress would make it
 * from the Russian one, percent-encoded). Set whenever the current slug is not a Latin word.
 */
function sweet_pepper_vacancy_slug( $post_id ) {
    $post = get_post( $post_id );
    if ( ! $post || in_array( $post->post_status, [ 'auto-draft', 'trash' ], true ) ) {
        return;
    }
    $en   = function_exists( 'get_field' ) ? (string) get_field( 'vacancy_title_en', $post_id ) : '';
    $want = sanitize_title( $en );
    if ( '' === $want || false !== strpos( $want, '%' ) ) {
        $want = 'role-' . $post_id;
    }
    $current = $post->post_name;
    $is_placeholder = (bool) preg_match( '/^role-\d+$/', $current );
    if ( '' !== $current && false === strpos( $current, '%' ) && ! ( $is_placeholder && 'role-' . $post_id !== $want ) ) {
        return; // a Latin slug the team may have typed — leave it
    }
    remove_action( 'save_post_vacancy', 'sweet_pepper_vacancy_on_save', 20 );
    wp_update_post( [ 'ID' => $post_id, 'post_name' => wp_unique_post_slug( $want, $post_id, $post->post_status, 'vacancy', 0 ) ] );
    add_action( 'save_post_vacancy', 'sweet_pepper_vacancy_on_save', 20 );
}

function sweet_pepper_vacancy_on_save( $post_id ) {
    if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
        return;
    }
    sweet_pepper_vacancy_apply_show( $post_id );
    sweet_pepper_vacancy_slug( $post_id );
}
add_action( 'save_post_vacancy', 'sweet_pepper_vacancy_on_save', 20 ); // 20: after SCF wrote the fields

// ── The sweep ────────────────────────────────────────────────────────────────────────────
/**
 * Every posting whose date has passed goes to «В архиве»; the page cache is purged once.
 *
 * @return int Postings closed.
 */
function sweet_pepper_vacancy_sweep() {
    $expired = get_posts( [
        'post_type'      => 'vacancy',
        'post_status'    => 'any',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'meta_query'     => [ [ 'key' => '_sp_vacancy_until', 'value' => [ 1, time() ], 'compare' => 'BETWEEN', 'type' => 'NUMERIC' ] ],
    ] );
    foreach ( $expired as $id ) {
        $until = sweet_pepper_vacancy_meta( $id )['until'];
        if ( function_exists( 'update_field' ) ) {
            update_field( 'field_sp_vacancy_show', 'archive', $id );
        }
        update_post_meta( $id, '_sp_vacancy_closed', $until );
        update_post_meta( $id, '_sp_vacancy_until', 0 );
        update_post_meta( $id, '_sp_vacancy_weeks', 0 );
    }
    if ( $expired && function_exists( 'wp_cache_clear_cache' ) ) {
        wp_cache_clear_cache();
    }
    return count( $expired );
}
add_action( SWEET_PEPPER_VACANCY_SWEEP, 'sweet_pepper_vacancy_sweep' );
add_action( 'init', function () {
    if ( wp_installing() ) {
        return;
    }
    if ( ! wp_next_scheduled( SWEET_PEPPER_VACANCY_SWEEP ) ) {
        wp_schedule_event( time() + HOUR_IN_SECONDS, 'daily', SWEET_PEPPER_VACANCY_SWEEP );
    }
} );
add_action( 'switch_theme', function () {
    wp_clear_scheduled_hook( SWEET_PEPPER_VACANCY_SWEEP );
} );

// ── Reading ──────────────────────────────────────────────────────────────────────────────
/**
 * "24 сентября" / "24 September" — the day and the month in the request's language.
 */
function sweet_pepper_vacancy_date( $timestamp ) {
    if ( ! $timestamp ) {
        return '';
    }
    $locale = $GLOBALS['wp_locale'] ?? null;
    $month  = wp_date( 'm', $timestamp );
    $name   = $locale ? ( 'ru' === sweet_pepper_lang() ? $locale->get_month_genitive( $month ) : $locale->get_month( $month ) ) : wp_date( 'F', $timestamp );
    return wp_date( 'j', $timestamp ) . ' ' . $name;
}

/** A textarea's lines as list items: blank lines dropped, a typed bullet stripped. */
function sweet_pepper_vacancy_lines( $text ) {
    $items = [];
    foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
        $line = trim( preg_replace( '/^\s*[-–—•·*]\s*/u', '', $line ) );
        if ( '' !== $line ) {
            $items[] = $line;
        }
    }
    return $items;
}

/** Any record at all (drafts too): once one exists, the records rule the About list. */
function sweet_pepper_vacancies_exist() {
    static $exists = null;
    if ( null === $exists ) {
        $exists = (bool) get_posts( [ 'post_type' => 'vacancy', 'post_status' => [ 'publish', 'draft', 'pending', 'private', 'future' ],
                                      'posts_per_page' => 1, 'fields' => 'ids' ] );
    }
    return $exists;
}

/**
 * The open postings, newest term first, as IDs.
 *
 * @param int $exclude A posting to leave out (the page's own).
 */
function sweet_pepper_open_vacancy_ids( $exclude = 0 ) {
    $ids = get_posts( [
        'post_type'      => 'vacancy',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'fields'         => 'ids',
        'post__not_in'   => $exclude ? [ (int) $exclude ] : [],
        'meta_key'       => '_sp_vacancy_opened',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
        'meta_query'     => [ [ 'key' => '_sp_vacancy_until', 'value' => time(), 'compare' => '>', 'type' => 'NUMERIC' ] ],
    ] );
    return array_values( array_filter( $ids, 'sweet_pepper_vacancy_is_open' ) );
}

/**
 * The words a card needs — the About Careers card and the "other roles" row on a posting's page.
 *
 * @return array department · title · meta · desc · url · link_label
 */
function sweet_pepper_vacancy_card( $post_id ) {
    $lang = sweet_pepper_lang();
    $dept = function_exists( 'get_field' ) ? (string) get_field( 'vacancy_department', $post_id ) : '';
    $get  = fn( $key ) => function_exists( 'get_field' ) ? get_field( "vacancy_{$key}", $post_id ) : '';
    return [
        'department' => sweet_pepper_about_departments()[ $dept ][ $lang ] ?? '',
        'title'      => sweet_pepper_pick( [ 'title_ru' => get_the_title( $post_id ), 'title_en' => $get( 'title_en' ) ], 'title' ),
        'meta'       => sweet_pepper_pick( [ 'meta_ru' => $get( 'schedule_ru' ), 'meta_en' => $get( 'schedule_en' ) ], 'meta' ),
        'desc'       => sweet_pepper_pick( [ 'd_ru' => $get( 'card_ru' ), 'd_en' => $get( 'card_en' ) ], 'd' ),
        'url'        => get_permalink( $post_id ),
        'link_label' => __( 'See the role', 'sweet-pepper' ),
    ];
}

/** The open postings as card args (the About Careers section). */
function sweet_pepper_vacancy_positions( $exclude = 0 ) {
    return array_map( 'sweet_pepper_vacancy_card', sweet_pepper_open_vacancy_ids( $exclude ) );
}

/**
 * Who answers: the bar's channels, and the chosen person when the record names one who is
 * still on the list.
 *
 * @return array{bar:array, person:?array}
 */
function sweet_pepper_vacancy_contact( $post_id ) {
    $pick   = function_exists( 'get_field' ) ? (string) get_field( 'vacancy_contact', $post_id ) : 'bar';
    $people = sweet_pepper_hiring_contacts();
    return [
        'bar'    => sweet_pepper_bar_contacts(),
        'person' => ( 'bar' !== $pick && isset( $people[ $pick ] ) ) ? $people[ $pick ] : null,
    ];
}

/**
 * Everything the posting's page prints, in one language.
 *
 * @return array id · open · title · department · schedule · pay · lead · lists[] (title, items[]) ·
 *               hh · opened · until · contact · others[] (card args)
 */
function sweet_pepper_vacancy( $post_id ) {
    $card = sweet_pepper_vacancy_card( $post_id );
    $meta = sweet_pepper_vacancy_meta( $post_id );
    $get  = fn( $key ) => function_exists( 'get_field' ) ? get_field( "vacancy_{$key}", $post_id ) : '';
    $pick = fn( $key ) => sweet_pepper_pick( [ "{$key}_ru" => $get( "{$key}_ru" ), "{$key}_en" => $get( "{$key}_en" ) ], $key );

    $lists = [];
    foreach ( [
        'duties'       => __( "What you'll do", 'sweet-pepper' ),
        'requirements' => __( "Who we're looking for", 'sweet-pepper' ),
        'offer'        => __( 'What you get', 'sweet-pepper' ),
    ] as $key => $title ) {
        $items = sweet_pepper_vacancy_lines( $pick( $key ) );
        if ( $items ) {
            $lists[] = [ 'key' => $key, 'title' => $title, 'items' => $items ];
        }
    }

    return [
        'id'         => (int) $post_id,
        'open'       => sweet_pepper_vacancy_is_open( $post_id ),
        'title'      => $card['title'],
        'department' => $card['department'],
        'schedule'   => $card['meta'],
        'pay'        => $pick( 'pay' ),
        'card'       => $card['desc'],
        'lead'       => $pick( 'lead' ),
        'lists'      => $lists,
        'hh'         => trim( (string) $get( 'hh' ) ),
        'opened'     => sweet_pepper_vacancy_date( $meta['opened'] ),
        'until'      => $meta['until'],
        'contact'    => sweet_pepper_vacancy_contact( $post_id ),
        'others'     => sweet_pepper_vacancy_positions( $post_id ),
    ];
}

// ── The page's head ──────────────────────────────────────────────────────────────────────
/** The browser tab carries the role in the request's language. */
add_filter( 'document_title_parts', function ( $parts ) {
    if ( is_singular( 'vacancy' ) ) {
        $parts['title'] = sweet_pepper_vacancy_card( get_queried_object_id() )['title'];
    }
    return $parts;
} );

/** A closed posting stays reachable but leaves the index; an open one carries JobPosting data. */
add_action( 'wp_head', function () {
    if ( ! is_singular( 'vacancy' ) ) {
        return;
    }
    $id = get_queried_object_id();
    if ( ! sweet_pepper_vacancy_is_open( $id ) ) {
        echo '<meta name="robots" content="noindex, follow">' . "\n";
        return;
    }
    $v    = sweet_pepper_vacancy( $id );
    $meta = sweet_pepper_vacancy_meta( $id );
    $text = [ $v['lead'] ];
    foreach ( $v['lists'] as $list ) {
        $text[] = $list['title'] . ': ' . implode( '; ', $list['items'] ) . '.';
    }
    $data = [
        '@context'           => 'https://schema.org',
        '@type'              => 'JobPosting',
        'title'              => $v['title'],
        'description'        => trim( implode( "\n", array_filter( $text ) ) ),
        'datePosted'         => wp_date( 'Y-m-d', $meta['opened'] ),
        'validThrough'       => wp_date( 'Y-m-d\TH:i', $meta['until'] ),
        'hiringOrganization' => [ '@type' => 'Organization', 'name' => 'Sweet Pepper', 'sameAs' => home_url( '/' ) ],
        'jobLocation'        => [ '@type' => 'Place', 'address' => [ '@type' => 'PostalAddress',
            'streetAddress' => 'ул. Кирова, 10/25', 'addressLocality' => 'Ярославль', 'addressCountry' => 'RU' ] ],
        'directApply'        => false,
    ];
    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}, 5 );

// ── Admin ────────────────────────────────────────────────────────────────────────────────
/** The «Контакт» dropdown: the bar, then the people on Bar Settings → «Контакты». */
add_filter( 'acf/load_field/key=field_sp_vacancy_contact', function ( $field ) {
    $choices = [ 'bar' => 'Бар — контакты как на странице «Как добраться»' ];
    foreach ( sweet_pepper_hiring_contacts() as $id => $p ) {
        $choices[ $id ] = $p['name'] . ( $p['role'] ? ' · ' . $p['role'] : '' );
    }
    $field['choices'] = $choices;
    return $field;
} );

/** The «На сайте» note says where the posting stands: open until …, or in the archive since …. */
add_filter( 'acf/prepare_field/key=field_sp_vacancy_show', function ( $field ) {
    $post_id = (int) ( $GLOBALS['post']->ID ?? 0 );
    if ( ! $post_id || 'vacancy' !== get_post_type( $post_id ) ) {
        return $field;
    }
    $meta = sweet_pepper_vacancy_meta( $post_id );
    $date = fn( $t ) => wp_date( 'j F', $t );
    if ( $meta['until'] > time() ) {
        $field['instructions'] = 'Открыта с ' . $date( $meta['opened'] ) . ' до ' . $date( $meta['until'] ) . '. Другой срок считается заново с сегодня.';
    } elseif ( $meta['closed'] || $meta['opened'] ) {
        $field['instructions'] = 'В архиве с ' . $date( $meta['closed'] ?: $meta['opened'] ) . '. Выберите срок и нажмите «Обновить», чтобы открыть заново.';
    } else {
        $field['instructions'] = 'Срок считается с сохранения.';
    }
    return $field;
} );

/** The list: role, department, where it stands, who answers. */
add_filter( 'manage_vacancy_posts_columns', function ( $columns ) {
    $out = [];
    foreach ( $columns as $key => $label ) {
        if ( 'date' === $key ) {
            continue; // the term matters, not the WordPress date
        }
        $out[ $key ] = 'title' === $key ? 'Должность' : $label;
        if ( 'title' === $key ) {
            $out['sp_dept']    = 'Отдел';
            $out['sp_state']   = 'На сайте';
            $out['sp_contact'] = 'Контакт';
        }
    }
    return $out;
} );
add_action( 'manage_vacancy_posts_custom_column', function ( $column, $post_id ) {
    if ( 'sp_dept' === $column ) {
        $dept = function_exists( 'get_field' ) ? (string) get_field( 'vacancy_department', $post_id ) : '';
        echo esc_html( sweet_pepper_about_departments()[ $dept ]['ru'] ?? '' );
    } elseif ( 'sp_state' === $column ) {
        $meta = sweet_pepper_vacancy_meta( $post_id );
        if ( 'publish' !== get_post_status( $post_id ) ) {
            echo '—';
        } elseif ( $meta['until'] > time() ) {
            echo 'до ' . esc_html( wp_date( 'j F', $meta['until'] ) );
        } elseif ( $meta['closed'] || $meta['until'] ) {
            echo 'в архиве с ' . esc_html( wp_date( 'j F', $meta['closed'] ?: $meta['until'] ) );
        } else {
            echo 'в архиве';
        }
    } elseif ( 'sp_contact' === $column ) {
        $c = sweet_pepper_vacancy_contact( $post_id );
        echo esc_html( $c['person'] ? $c['person']['name'] : 'бар' );
    }
}, 10, 2 );

/** Two views above the list — «Открытые» and «Архив» — and the filter behind them. */
add_filter( 'views_edit-vacancy', function ( $views ) {
    $count = fn( $state ) => count( get_posts( [ 'post_type' => 'vacancy', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids',
        'meta_query' => sweet_pepper_vacancy_state_query( $state ) ] ) );
    $current = $_GET['sp_state'] ?? '';
    $link    = fn( $state, $label ) => sprintf( '<a href="%s"%s>%s <span class="count">(%d)</span></a>',
        esc_url( add_query_arg( [ 'post_type' => 'vacancy', 'sp_state' => $state ], admin_url( 'edit.php' ) ) ),
        $current === $state ? ' class="current" aria-current="page"' : '', $label, $count( $state ) );
    $out = [];
    foreach ( $views as $key => $view ) {
        if ( 'all' === $key && '' !== $current ) {
            $view = str_replace( ' class="current" aria-current="page"', '', $view );
        }
        $out[ $key ] = $view;
        if ( 'all' === $key ) {
            $out['sp_open']    = $link( 'open', 'Открытые' );
            $out['sp_archive'] = $link( 'archive', 'Архив' );
        }
    }
    return $out;
} );
function sweet_pepper_vacancy_state_query( $state ) {
    if ( 'open' === $state ) {
        return [ [ 'key' => '_sp_vacancy_until', 'value' => time(), 'compare' => '>', 'type' => 'NUMERIC' ] ];
    }
    return [ 'relation' => 'OR',
        [ 'key' => '_sp_vacancy_until', 'value' => time(), 'compare' => '<=', 'type' => 'NUMERIC' ],
        [ 'key' => '_sp_vacancy_until', 'compare' => 'NOT EXISTS' ],
    ];
}
add_action( 'pre_get_posts', function ( $query ) {
    if ( ! is_admin() || ! $query->is_main_query() || 'vacancy' !== $query->get( 'post_type' ) ) {
        return;
    }
    $state = $_GET['sp_state'] ?? '';
    if ( in_array( $state, [ 'open', 'archive' ], true ) ) {
        $query->set( 'meta_query', sweet_pepper_vacancy_state_query( $state ) );
        if ( ! $query->get( 'post_status' ) ) {
            $query->set( 'post_status', 'publish' );
        }
    }
} );
