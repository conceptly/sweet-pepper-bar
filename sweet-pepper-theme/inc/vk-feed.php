<?php
/**
 * The VK feed — the Russian home page's «Что нового» cards, imported from the community wall.
 *
 * Decision (website-brief.md → News/social feed → Current decision, 24 Sep 2026): `/` shows
 * the community's latest posts by itself; `/en/` keeps the hand-made cards in the front page's
 * «Что нового» tab (inc/home-data.php). Publishing in VK IS the approval step — no draft
 * queue here. A guest's request never calls VK: the importer runs on a schedule and saves each
 * post as a `news` record («Посты ВКонтакте», inc/cpt.php); the page reads the records.
 *
 * The importer — sweet_pepper_vk_import():
 *   - wall.get, the community's own posts, the newest SWEET_PEPPER_VK_FETCH of them, with the
 *     mini-app's service key: SWEET_PEPPER_VK_SERVICE_KEY in wp-config.php (or the environment
 *     for a CLI run) — never in the theme, never printed, never in an error message.
 *   - Eligible: an ordinary post (not a repost, not an ad) with text and at least one photo.
 *     The first SWEET_PEPPER_VK_KEEP eligible posts are stored: five show, the spares stand in
 *     for a hidden one.
 *   - One record per VK post, keyed by `_sp_vk_id` (owner_post) — a re-run updates, never
 *     duplicates. The cover is the post's first photo at its largest size, downloaded into the
 *     media library once per photo id (an edited photo replaces it); the caption is the opening
 *     text, shortened (sweet_pepper_vk_title()); the date is the post's publication date.
 *   - A caption the team retyped in the record stays: the importer rewrites only a caption it
 *     wrote itself (`_sp_vk_title` remembers its own). «Скрыть с сайта» (news_hidden,
 *     acf-json/group_sp_news.json) survives every run.
 *   - A record newer than the oldest fetched post yet absent from a SUCCESSFUL fetch is marked
 *     `_sp_vk_missing_since`; absent from a second successful run, it goes to Draft. A failed
 *     request changes nothing — the last successful feed stays on the page.
 *   - Status, without secrets: options sp_vk_last_success, sp_vk_last_error, sp_vk_last_summary;
 *     shown above the «Посты ВКонтакте» list.
 *
 * Schedule: one WP-Cron event, hourly, scheduled once a key exists. On hosting, DISABLE_WP_CRON
 * and a system cron calling wp-cron.php hourly, so the run does not wait for a guest
 * (website-brief.md → News/social feed → Next steps → 5). Locally: tools/vk-import.php.
 *
 * @package Sweet_Pepper
 */

const SWEET_PEPPER_VK_COMMUNITY = 64582467;
const SWEET_PEPPER_VK_API       = '5.199';
const SWEET_PEPPER_VK_FETCH     = 20; // posts asked for per run
const SWEET_PEPPER_VK_KEEP      = 8;  // eligible posts stored (five show; the rest cover hides)
const SWEET_PEPPER_VK_TITLE_MAX = 60; // characters — the card body is a fixed 98px, two lines of H3 at most
const SWEET_PEPPER_VK_TITLE_MIN = 20; // a first sentence shorter than this takes the next one along
const SWEET_PEPPER_VK_EVENT     = 'sweet_pepper_vk_import';

/** The service key: wp-config.php's constant, else the environment (a CLI run); '' when neither. */
function sweet_pepper_vk_key() {
    if ( defined( 'SWEET_PEPPER_VK_SERVICE_KEY' ) && '' !== (string) SWEET_PEPPER_VK_SERVICE_KEY ) {
        return (string) SWEET_PEPPER_VK_SERVICE_KEY;
    }
    return (string) getenv( 'SWEET_PEPPER_VK_SERVICE_KEY' );
}

/** The post's address on VK — what the whole card links to. */
function sweet_pepper_vk_post_url( $item ) {
    return sprintf( 'https://vk.com/wall%d_%d', (int) $item['owner_id'], (int) $item['id'] );
}

/** The record key of a post: `-64582467_123`. */
function sweet_pepper_vk_post_key( $item ) {
    return (int) $item['owner_id'] . '_' . (int) $item['id'];
}

/**
 * wall.get → the posts, newest first; a WP_Error when VK could not be read. The key travels in
 * the POST body, not the URL, and is scrubbed from any message VK returns.
 *
 * @return array|WP_Error
 */
function sweet_pepper_vk_fetch() {
    $key = sweet_pepper_vk_key();
    if ( '' === $key ) {
        return new WP_Error( 'vk_no_key', 'Ключ VK не задан: SWEET_PEPPER_VK_SERVICE_KEY в wp-config.php.' );
    }
    $response = wp_remote_post( 'https://api.vk.com/method/wall.get', [
        'timeout' => 15,
        'body'    => [
            'owner_id'     => -SWEET_PEPPER_VK_COMMUNITY,
            'filter'       => 'owner',
            'count'        => SWEET_PEPPER_VK_FETCH,
            'v'            => SWEET_PEPPER_VK_API,
            'access_token' => $key,
        ],
    ] );
    $scrub = fn( $s ) => str_replace( $key, '[ключ]', (string) $s );
    if ( is_wp_error( $response ) ) {
        return new WP_Error( 'vk_http', 'VK недоступен: ' . $scrub( $response->get_error_message() ) );
    }
    $code = (int) wp_remote_retrieve_response_code( $response );
    $data = json_decode( wp_remote_retrieve_body( $response ), true );
    if ( isset( $data['error'] ) ) {
        return new WP_Error( 'vk_api', sprintf( 'Ошибка VK %d: %s', (int) ( $data['error']['error_code'] ?? 0 ), $scrub( $data['error']['error_msg'] ?? '' ) ) );
    }
    if ( 200 !== $code || ! isset( $data['response']['items'] ) || ! is_array( $data['response']['items'] ) ) {
        return new WP_Error( 'vk_shape', "Неожиданный ответ VK (HTTP {$code})." );
    }
    return $data['response']['items'];
}

/**
 * The post's first photo at its largest size, or null when it has none.
 *
 * @return array|null [ id, url, width, height ]
 */
function sweet_pepper_vk_photo( $item ) {
    $rank = [ 's' => 1, 'm' => 2, 'x' => 3, 'o' => 4, 'p' => 5, 'q' => 6, 'r' => 7, 'y' => 8, 'z' => 9, 'w' => 10 ];
    foreach ( (array) ( $item['attachments'] ?? [] ) as $att ) {
        if ( 'photo' !== ( $att['type'] ?? '' ) || empty( $att['photo']['sizes'] ) || ! is_array( $att['photo']['sizes'] ) ) {
            continue;
        }
        $best = null;
        foreach ( $att['photo']['sizes'] as $size ) {
            if ( empty( $size['url'] ) ) {
                continue;
            }
            $score = [ (int) ( $size['width'] ?? 0 ), $rank[ $size['type'] ?? '' ] ?? 0 ];
            if ( ! $best || $score > $best['score'] ) {
                $best = [ 'score' => $score, 'size' => $size ];
            }
        }
        if ( $best ) {
            return [
                'id'     => (int) ( $att['photo']['id'] ?? 0 ),
                'url'    => (string) $best['size']['url'],
                'width'  => (int) ( $best['size']['width'] ?? 0 ),
                'height' => (int) ( $best['size']['height'] ?? 0 ),
            ];
        }
    }
    return null;
}

/**
 * The card's caption from the post's text: the first line that says something (emoji dropped —
 * Molot has no glyphs for them — bullets and hashtags skipped; VK's [id|Name] links reduced to
 * Name), then the first
 * sentence — or two, when the first is very short — while that fits SWEET_PEPPER_VK_TITLE_MAX;
 * else the line cut on a word with an ellipsis. '' for a post with no words.
 */
function sweet_pepper_vk_title( $text ) {
    $text = preg_replace( '/\[[^\]|]+\|([^\]]+)\]/u', '$1', str_replace( [ "\r\n", "\r" ], "\n", (string) $text ) );
    $text = preg_replace( '/[\p{So}\p{Sk}\p{Cn}\x{FE0F}\x{200D}\x{20E3}\x{1F3FB}-\x{1F3FF}]/u', ' ', $text ); // emoji, skin tones, joiners
    $line = '';
    foreach ( explode( "\n", $text ) as $candidate ) {
        $candidate = preg_replace( '/(^|\s)#[\p{L}\p{N}_]+/u', ' ', $candidate );   // hashtags, anywhere
        $candidate = preg_replace( '/^[^\p{L}\p{N}«"(]+/u', '', trim( $candidate ) ); // leading emoji, bullets, dashes
        $candidate = rtrim( trim( preg_replace( '/\s+/u', ' ', $candidate ) ), " :;,—–-" ); // what an emoji used to close
        if ( preg_match( '/\p{L}/u', $candidate ) ) {
            $line = $candidate;
            break;
        }
    }
    if ( '' === $line ) {
        return '';
    }
    $max = SWEET_PEPPER_VK_TITLE_MAX;
    if ( mb_strlen( $line ) <= $max ) {
        return rtrim( $line, '.' );
    }
    $acc = '';
    foreach ( preg_split( '/(?<=[.!?…])\s+/u', $line ) as $sentence ) {
        $try = '' === $acc ? $sentence : "{$acc} {$sentence}";
        if ( mb_strlen( $try ) > $max ) {
            break;
        }
        $acc = $try;
        if ( mb_strlen( $acc ) >= SWEET_PEPPER_VK_TITLE_MIN ) {
            break;
        }
    }
    if ( mb_strlen( $acc ) >= SWEET_PEPPER_VK_TITLE_MIN ) {
        return rtrim( $acc, '.' );
    }
    $cut = preg_replace( '/\s+\S*$/u', '', mb_substr( $line, 0, $max ) );
    return rtrim( $cut, " ,;:—–-" ) . '…';
}

/** An ordinary post by the community with words and a photo. */
function sweet_pepper_vk_eligible( $item ) {
    if ( 'post' !== ( $item['post_type'] ?? 'post' ) || ! empty( $item['copy_history'] ) || ! empty( $item['marked_as_ads'] ) ) {
        return false;
    }
    return '' !== sweet_pepper_vk_title( $item['text'] ?? '' ) && null !== sweet_pepper_vk_photo( $item );
}

/** The record of a VK post, or null. */
function sweet_pepper_vk_record( $vk_id ) {
    $found = get_posts( [
        'post_type'      => 'news',
        'post_status'    => [ 'publish', 'draft' ],
        'posts_per_page' => 1,
        'meta_key'       => '_sp_vk_id',
        'meta_value'     => $vk_id,
        'no_found_rows'  => true,
    ] );
    return $found ? $found[0] : null;
}

/** Every imported record in a status. */
function sweet_pepper_vk_records( $status = 'publish' ) {
    return get_posts( [
        'post_type'      => 'news',
        'post_status'    => $status,
        'posts_per_page' => -1,
        'meta_key'       => '_sp_vk_id',
        'no_found_rows'  => true,
    ] );
}

/**
 * The post's photo as the record's featured image: an attachment already holding this photo id
 * is reused; otherwise the file is downloaded (VK's URL carries the largest size). The previous
 * cover, when it was another photo, is deleted from the library.
 *
 * @return int|WP_Error Attachment ID.
 */
function sweet_pepper_vk_cover( $post_id, $photo ) {
    $found = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => 1, 'fields' => 'ids',
                          'meta_key' => '_sp_vk_photo', 'meta_value' => (string) $photo['id'], 'no_found_rows' => true ] );
    $att   = $found ? (int) $found[0] : 0;
    if ( ! $att ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $tmp = download_url( $photo['url'], 30 );
        if ( is_wp_error( $tmp ) ) {
            return new WP_Error( 'vk_photo', "Фото {$photo['id']} не скачалось: " . $tmp->get_error_message() );
        }
        $att = media_handle_sideload( [ 'name' => "vk-{$photo['id']}.jpg", 'tmp_name' => $tmp ], $post_id, "VK {$photo['id']}" );
        if ( is_wp_error( $att ) ) {
            @unlink( $tmp );
            return new WP_Error( 'vk_photo', "Фото {$photo['id']} не сохранилось: " . $att->get_error_message() );
        }
        update_post_meta( $att, '_sp_vk_photo', (string) $photo['id'] );
    }
    $old = (int) get_post_thumbnail_id( $post_id );
    set_post_thumbnail( $post_id, $att );
    update_post_meta( $post_id, '_sp_vk_photo', (string) $photo['id'] );
    if ( $old && $old !== $att ) {
        wp_delete_attachment( $old, true );
    }
    return $att;
}

/**
 * One eligible post → its record, created or brought up to date.
 *
 * @return string|WP_Error 'created' | 'updated' | 'unchanged'
 */
function sweet_pepper_vk_save( $item ) {
    $vk_id  = sweet_pepper_vk_post_key( $item );
    $title  = sweet_pepper_vk_title( $item['text'] ?? '' );
    $photo  = sweet_pepper_vk_photo( $item );
    $stamp  = (int) $item['date'];
    $pinned = empty( $item['is_pinned'] ) ? 0 : 1;
    $hash   = md5( implode( '|', [ $title, $photo['id'], $stamp, $pinned ] ) );
    $dates  = [ 'post_date_gmt' => gmdate( 'Y-m-d H:i:s', $stamp ), 'post_date' => get_date_from_gmt( gmdate( 'Y-m-d H:i:s', $stamp ) ) ];

    $record = sweet_pepper_vk_record( $vk_id );
    if ( ! $record ) {
        $id = wp_insert_post( [ 'post_type' => 'news', 'post_status' => 'publish', 'post_title' => $title ] + $dates, true );
        if ( is_wp_error( $id ) ) {
            return $id;
        }
        update_post_meta( $id, '_sp_vk_id', $vk_id );
        update_post_meta( $id, '_sp_vk_url', sweet_pepper_vk_post_url( $item ) );
        update_post_meta( $id, '_sp_vk_title', $title );
        update_post_meta( $id, '_sp_vk_pinned', $pinned );
        $cover = sweet_pepper_vk_cover( $id, $photo );
        if ( is_wp_error( $cover ) ) {
            return $cover; // no hash: the next run tries the photo again
        }
        update_post_meta( $id, '_sp_vk_hash', $hash );
        return 'created';
    }

    $id = $record->ID;
    delete_post_meta( $id, '_sp_vk_missing_since' );
    if ( $hash === get_post_meta( $id, '_sp_vk_hash', true ) && 'publish' === $record->post_status ) {
        return 'unchanged';
    }
    $update = [ 'ID' => $id, 'post_status' => 'publish' ] + $dates;
    if ( $record->post_title === get_post_meta( $id, '_sp_vk_title', true ) ) {
        $update['post_title'] = $title; // the importer's own caption follows the post; a retyped one stays
    }
    wp_update_post( $update );
    update_post_meta( $id, '_sp_vk_title', $title );
    update_post_meta( $id, '_sp_vk_pinned', $pinned );
    update_post_meta( $id, '_sp_vk_url', sweet_pepper_vk_post_url( $item ) );
    if ( (string) $photo['id'] !== (string) get_post_meta( $id, '_sp_vk_photo', true ) ) {
        $cover = sweet_pepper_vk_cover( $id, $photo );
        if ( is_wp_error( $cover ) ) {
            return $cover;
        }
    }
    update_post_meta( $id, '_sp_vk_hash', $hash );
    return 'updated';
}

/**
 * The run: fetch (or take $items — a saved response, for a test), save the eligible posts,
 * mark and retire the ones that left the wall, record the status. Nothing is written when the
 * request fails.
 *
 * @param array|null $items A wall.get `items` array instead of a live request.
 * @return array|WP_Error The run's summary.
 */
function sweet_pepper_vk_import( $items = null ) {
    if ( null === $items ) {
        $items = sweet_pepper_vk_fetch();
    }
    if ( is_wp_error( $items ) ) {
        update_option( 'sp_vk_last_error', [ 'time' => time(), 'message' => $items->get_error_message() ], false );
        return $items;
    }
    $eligible = array_slice( array_values( array_filter( $items, 'sweet_pepper_vk_eligible' ) ), 0, SWEET_PEPPER_VK_KEEP );
    $summary  = [ 'time' => time(), 'fetched' => count( $items ), 'eligible' => count( $eligible ),
                  'created' => 0, 'updated' => 0, 'unchanged' => 0, 'missing' => 0, 'unpublished' => 0, 'errors' => [] ];
    $seen     = [];
    foreach ( $eligible as $item ) {
        $seen[] = sweet_pepper_vk_post_key( $item );
        $result = sweet_pepper_vk_save( $item );
        if ( is_wp_error( $result ) ) {
            $summary['errors'][] = $result->get_error_message();
        } else {
            $summary[ $result ]++;
        }
    }
    // Gone from the wall: a published record among the fetched posts' range, not seen this run.
    if ( $items ) {
        $oldest = min( array_map( fn( $i ) => (int) $i['id'], $items ) );
        foreach ( sweet_pepper_vk_records( 'publish' ) as $record ) {
            $vk_id = (string) get_post_meta( $record->ID, '_sp_vk_id', true );
            if ( in_array( $vk_id, $seen, true ) || (int) substr( $vk_id, strpos( $vk_id, '_' ) + 1 ) < $oldest ) {
                continue;
            }
            if ( get_post_meta( $record->ID, '_sp_vk_missing_since', true ) ) {
                wp_update_post( [ 'ID' => $record->ID, 'post_status' => 'draft' ] );
                $summary['unpublished']++;
            } else {
                update_post_meta( $record->ID, '_sp_vk_missing_since', time() );
                $summary['missing']++;
            }
        }
    }
    update_option( 'sp_vk_last_success', $summary['time'], false );
    update_option( 'sp_vk_last_summary', $summary, false );
    delete_option( 'sp_vk_last_error' );
    if ( $summary['created'] || $summary['updated'] || $summary['unpublished'] ) {
        if ( function_exists( 'wp_cache_clear_cache' ) ) {
            wp_cache_clear_cache(); // WP Super Cache, when installed: the front page holds the cards
        }
    }
    return $summary;
}

/**
 * The Russian home page's cards, newest first, the pinned post ahead — args for
 * template-parts/components/event-card.php. Hidden records and records without a cover are
 * passed over; [] before the first import, when the typed cards render instead.
 */
function sweet_pepper_vk_cards( $limit = 5 ) {
    $cards = [];
    foreach ( sweet_pepper_vk_records( 'publish' ) as $record ) {
        if ( function_exists( 'get_field' ) && get_field( 'news_hidden', $record->ID ) ) {
            continue;
        }
        $src = sweet_pepper_photo_url( get_post_thumbnail_id( $record->ID ), 'sp-4x5' );
        if ( ! $src || '' === trim( $record->post_title ) ) {
            continue;
        }
        // The card's own «Описание фото», else the photo's alt in the Media Library, else the caption.
        $alt     = function_exists( 'get_field' ) ? trim( (string) get_field( 'news_alt', $record->ID ) ) : '';
        $alt     = $alt ?: trim( (string) get_post_meta( get_post_thumbnail_id( $record->ID ), '_wp_attachment_image_alt', true ) );
        $cards[] = [
            'image_url'  => $src,
            'image_alt'  => $alt ?: $record->post_title,
            'title'      => $record->post_title,
            'date'       => get_the_date( 'j M', $record ),
            'plain_date' => true, // a publication date, never «Сегодня!»
            'category'   => '',
            'source'     => 'vk',
            'pinned'     => (bool) get_post_meta( $record->ID, '_sp_vk_pinned', true ),
            'url'        => (string) get_post_meta( $record->ID, '_sp_vk_url', true ),
        ];
    }
    usort( $cards, fn( $a, $b ) => $b['pinned'] <=> $a['pinned'] ); // stable: newest first within each
    return array_slice( $cards, 0, $limit );
}

// ── Schedule ──────────────────────────────────────────────────────────────────────────────
add_action( SWEET_PEPPER_VK_EVENT, 'sweet_pepper_vk_import' );
add_action( 'init', function () {
    if ( wp_installing() || '' === sweet_pepper_vk_key() ) {
        return;
    }
    if ( ! wp_next_scheduled( SWEET_PEPPER_VK_EVENT ) ) {
        wp_schedule_event( time() + MINUTE_IN_SECONDS, 'hourly', SWEET_PEPPER_VK_EVENT );
    }
} );
add_action( 'switch_theme', function () {
    wp_clear_scheduled_hook( SWEET_PEPPER_VK_EVENT );
} );

// ── Admin ─────────────────────────────────────────────────────────────────────────────────
/** The status line above the «Посты ВКонтакте» list — and a warning when no key is set. */
add_action( 'admin_notices', function () {
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    if ( ! $screen || 'news' !== $screen->post_type ) {
        return;
    }
    $format  = fn( $t ) => wp_date( 'j F, H:i', (int) $t );
    $success = (int) get_option( 'sp_vk_last_success' );
    $error   = get_option( 'sp_vk_last_error' );
    $summary = (array) get_option( 'sp_vk_last_summary', [] );
    if ( '' === sweet_pepper_vk_key() ) {
        echo '<div class="notice notice-warning"><p>Ключ VK не задан — карточки не обновляются. SWEET_PEPPER_VK_SERVICE_KEY в wp-config.php.</p></div>';
    }
    if ( $error ) {
        printf( '<div class="notice notice-error"><p>Последняя попытка (%s) не удалась: %s На сайте остаются карточки прошлого удачного обновления%s.</p></div>',
            esc_html( $format( $error['time'] ?? 0 ) ), esc_html( $error['message'] ?? '' ), $success ? ' — ' . esc_html( $format( $success ) ) : '' );
    } elseif ( $success ) {
        printf( '<div class="notice notice-info"><p>Обновлено из ВКонтакте: %s. Постов получено %d, подходящих %d; новых %d, изменённых %d, снятых со стены %d.</p></div>',
            esc_html( $format( $success ) ), (int) ( $summary['fetched'] ?? 0 ), (int) ( $summary['eligible'] ?? 0 ),
            (int) ( $summary['created'] ?? 0 ), (int) ( $summary['updated'] ?? 0 ), (int) ( $summary['unpublished'] ?? 0 ) );
    }
} );

/** The record's side box: the post on VK, its date, the caption the importer took from it. */
add_action( 'add_meta_boxes_news', function ( $post ) {
    add_meta_box( 'sp-vk-post', 'ВКонтакте', function ( $post ) {
        $url   = (string) get_post_meta( $post->ID, '_sp_vk_url', true );
        $title = (string) get_post_meta( $post->ID, '_sp_vk_title', true );
        if ( ! $url ) {
            echo '<p>Эта запись не из импорта.</p>';
            return;
        }
        printf( '<p><a href="%s" target="_blank" rel="noopener">Открыть пост</a> · %s</p>', esc_url( $url ), esc_html( get_the_date( 'j F Y', $post ) ) );
        printf( '<p class="description">Подпись из поста: «%s». Переписанная подпись выше остаётся; удалите свою, чтобы вернуть эту.</p>', esc_html( $title ) );
        if ( get_post_meta( $post->ID, '_sp_vk_missing_since', true ) ) {
            echo '<p><strong>Пост не найден на стене</strong> — уйдёт в черновики после следующего обновления.</p>';
        }
    }, 'news', 'side', 'high' );
} );

/** The list's columns: hidden or not, the post on VK. */
add_filter( 'manage_news_posts_columns', function ( $columns ) {
    $out = [];
    foreach ( $columns as $key => $label ) {
        $out[ $key ] = $key === 'title' ? 'Подпись' : $label;
        if ( 'title' === $key ) {
            $out['sp_vk'] = 'На сайте';
        }
    }
    return $out;
} );
add_action( 'manage_news_posts_custom_column', function ( $column, $post_id ) {
    if ( 'sp_vk' !== $column ) {
        return;
    }
    $hidden  = function_exists( 'get_field' ) && get_field( 'news_hidden', $post_id );
    $missing = get_post_meta( $post_id, '_sp_vk_missing_since', true );
    $url     = (string) get_post_meta( $post_id, '_sp_vk_url', true );
    echo $hidden ? 'скрыта' : ( $missing ? 'не найдена на стене' : 'да' );
    if ( $url ) {
        printf( ' · <a href="%s" target="_blank" rel="noopener">пост</a>', esc_url( $url ) );
    }
}, 10, 2 );
