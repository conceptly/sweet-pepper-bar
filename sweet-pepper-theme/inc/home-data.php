<?php
/**
 * Home data — where the home page's template parts get their content.
 *
 * The front page's fields (acf-json/group_sp_home.json, one tab per section, located on
 * whichever page Settings → Reading names as the front page — tools/page-seed.php home makes
 * «Главная» and sets it), read into template-part args in one language. Until a tab is
 * saved the typed copy in data/home/<section>.php renders instead, so a section converts
 * without the page ever going blank — the About page's shape (inc/about-data.php).
 *
 * What stays in code (website-brief.md → Content editing → tier 3): the daypart engine and
 * its clock, the tile order and where the menu button goes, the connectors, the contact
 * channels and the map. A card or a preview row never retypes a dish: it points at a
 * `dish` / `drink` post and prints its record (Menu storage → Settled).
 *
 * @package Sweet_Pepper
 */

/**
 * The front page — a page only when Settings → Reading says so; null while the site still
 * opens on the posts index (a fresh site before the seeder runs — the typed copy renders).
 *
 * @return WP_Post|null
 */
function sweet_pepper_home_page() {
    static $page = false;
    if ( false !== $page ) {
        return $page;
    }
    $id   = 'page' === get_option( 'show_on_front' ) ? (int) get_option( 'page_on_front' ) : 0;
    $post = $id ? get_post( $id ) : null;
    return $page = ( $post && 'page' === $post->post_type ) ? $post : null;
}

/** The front page's ID, or 0. */
function sweet_pepper_home_id() {
    $page = sweet_pepper_home_page();
    return $page ? $page->ID : 0;
}

/** A section's typed copy (data/home/<section>.php), loaded once. */
function sweet_pepper_home_typed( $section ) {
    static $typed = [];
    return $typed[ $section ] ??= require get_template_directory() . "/data/home/{$section}.php";
}

/** A photo field's URL at a theme size, else the typed asset. */
function sweet_pepper_home_photo( $page_id, $name, $size, $fallback ) {
    $id = $page_id && function_exists( 'get_field' ) ? get_field( $name, $page_id ) : '';
    return sweet_pepper_photo_url( $id, $size, $fallback );
}

/**
 * The hero: the eyebrow, the four dayparts' words and tile photos, the closed-hours words.
 * The engine (src/js/daypart-engine.js) reads the words from the JSON the part prints and
 * keeps the clock, the theme and the button's destination.
 *
 * @return array [ eyebrow, dayparts => dp => [ photo, alt, headline, body, button ], closed => window => [ headline, body ] ]
 */
function sweet_pepper_home_hero( $page_id ) {
    $typed = sweet_pepper_home_typed( 'hero' );
    $text  = sweet_pepper_page_text( $page_id, 'home_hero', $typed );

    $dayparts = [];
    foreach ( $typed['dayparts'] as $dp => $t ) {
        $tx = sweet_pepper_page_text( $page_id, "home_hero_{$dp}", $t );
        $dayparts[ $dp ] = [
            'photo'    => sweet_pepper_home_photo( $page_id, "home_hero_{$dp}_photo", 'sp-3x2', $t['photo'] ),
            'alt'      => $tx( 'alt' ),
            'headline' => $tx( 'headline' ),
            'body'     => $tx( 'body' ),
            'button'   => $tx( 'button' ),
        ];
    }
    $closed = [];
    foreach ( $typed['closed'] as $window => $t ) {
        $tx = sweet_pepper_page_text( $page_id, "home_hero_closed_{$window}", $t );
        $closed[ $window ] = [ 'headline' => $tx( 'headline' ), 'body' => $tx( 'body' ) ];
    }
    return [ 'eyebrow' => $text( 'eyebrow' ), 'dayparts' => $dayparts, 'closed' => $closed ];
}

/**
 * The section a dish or drink post is placed in — the first section that lists it — and
 * the menu page it lives on. Null for a post no list places.
 *
 * @return array|null [ slug, state ]
 */
function sweet_pepper_home_item_section( $post_id ) {
    $placed = sweet_pepper_dish_placements()[ $post_id ] ?? [];
    if ( ! $placed ) {
        return null;
    }
    $slug = array_key_first( $placed );
    return [ $slug, sweet_pepper_menu_state_for( $slug ) ];
}

/**
 * One highlight card, one language. A card that points at a dish prints the dish's record —
 * name, the first size's price, description, its photo (else the photo of its section's hero) —
 * and links to its section; the card's own short name and line, where typed, stand in for the
 * dish's name and description (the copy doc's card lines are shorter than the menu's rows). A
 * card with no dish is a category typed by hand. Null for a card with nothing to show.
 *
 * @param array $row   A row of «Карточки» (saved, or typed in the row's shape).
 * @param bool  $saved Whether the row is the form's (its photo is an attachment ID).
 * @return array|null Args of template-parts/components/highlight-card.php.
 */
function sweet_pepper_home_highlight_card( $row, $saved ) {
    $lang    = sweet_pepper_lang();
    $dish_id = $saved ? (int) ( ( (array) ( $row['dish'] ?? [] ) )[0] ?? 0 ) : 0;
    $dish    = $dish_id ? sweet_pepper_menu_item_row( $dish_id ) : null;
    $tag     = [
        'tag_icon'  => preg_replace( '/[^A-Za-z-]/', '', (string) ( $row['tag_icon'] ?? '' ) ),
        'tag_label' => sweet_pepper_pick( $row, 'tag_label' ),
    ];

    if ( $dish && empty( $dish['hidden'] ) ) {
        $args  = sweet_pepper_menu_dish_args( $dish, $lang );
        // The card's own words in THIS language only — an empty twin falls back to the dish's
        // name in the request's language, never to the other language's short name.
        $own   = fn( $key ) => trim( (string) ( $row[ "{$key}_{$lang}" ] ?? '' ) );
        $title = $own( 'title' ) ?: $args['dish_name'];
        $where = sweet_pepper_home_item_section( $dish_id );
        $typed = $where ? ( sweet_pepper_menu_sections_typed( $where[1] )[ $where[0] ] ?? [] ) : [];
        return [
            'image_url'   => sweet_pepper_photo_url( get_post_thumbnail_id( $dish_id ), 'sp-3x2', $typed['image'] ?? '' ),
            'image_alt'   => $title,
            'title'       => $title,
            'price'       => explode( ' / ', $args['price'] )[0], // a card is a door, not a menu row: one price
            'description' => $own( 'description' ) ?: $args['description'],
            'url'         => $where ? sweet_pepper_menu_url( $where[1], $where[0] ) : '',
        ] + $tag;
    }
    if ( $dish ) {
        return null; // a dish in draft is off the site
    }
    $title = sweet_pepper_pick( $row, 'title' );
    if ( '' === $title ) {
        return null;
    }
    $slug = sanitize_key( (string) ( $row['section'] ?? '' ) );
    return [
        'image_url'   => sweet_pepper_photo_url( $saved ? ( $row['photo'] ?? '' ) : '', 'sp-3x2', $saved ? '' : (string) ( $row['photo'] ?? '' ) ),
        'image_alt'   => $saved ? $title : (string) ( $row['alt'] ?? $title ),
        'title'       => $title,
        'price'       => sweet_pepper_pick( $row, 'price' ),
        'description' => sweet_pepper_pick( $row, 'description' ),
        'url'         => $slug ? sweet_pepper_menu_url( sweet_pepper_menu_state_for( $slug ), $slug ) : '',
    ] + $tag;
}

/**
 * Highlights: the section header and the three cards.
 */
function sweet_pepper_home_highlights( $page_id ) {
    $typed = sweet_pepper_home_typed( 'highlights' );
    $text  = sweet_pepper_page_text( $page_id, 'home_highlights', $typed );
    [ $saved, $rows ] = sweet_pepper_page_rows( $page_id, 'home_highlight_cards', $typed['cards'], [ 'title', 'price', 'description', 'tag_label' ] );
    $cards = [];
    foreach ( array_slice( $rows, 0, 3 ) as $row ) {
        if ( $card = sweet_pepper_home_highlight_card( $row, $saved ) ) {
            $cards[] = $card;
        }
    }
    [ $headline, $headline_2 ] = sp_headline( 'home_highlights_headline', $typed, $page_id );
    return [ 'eyebrow' => $text( 'eyebrow' ), 'headline' => $headline, 'headline_2' => $headline_2, 'description' => $text( 'description' ), 'cards' => $cards ];
}

/**
 * A menu preview — the bar's (House infusions) or the kitchen's (Your lunch sorted): title,
 * photo with its caption, and three rows that point at menu items. Every row is highlighted:
 * they are the preview's picks. A hidden item drops out; while the list has never been saved
 * the typed rows render.
 *
 * @param string $key 'bar' | 'kitchen'
 * @return array Args of template-parts/components/menu-preview.php (layout and CTA are the part's).
 */
function sweet_pepper_home_preview( $page_id, $key ) {
    $typed = sweet_pepper_home_typed( $key );
    $text  = sweet_pepper_page_text( $page_id, "home_{$key}", $typed );
    $lang  = sweet_pepper_lang();
    $saved = $page_id && function_exists( 'get_field' ) && metadata_exists( 'post', $page_id, "home_{$key}_items" );

    $dishes = [];
    if ( $saved ) {
        foreach ( array_map( 'intval', array_filter( (array) get_field( "home_{$key}_items", $page_id, false ) ) ) as $id ) {
            $dish = sweet_pepper_menu_item_row( $id );
            if ( $dish && empty( $dish['hidden'] ) ) {
                $dishes[] = [ 'highlight' => true ] + sweet_pepper_menu_dish_args( $dish, $lang );
            }
        }
    } else {
        foreach ( $typed['rows'] as $row ) {
            $dishes[] = [ 'dish_name' => sweet_pepper_typed( $row, 'dish_name' ), 'description' => sweet_pepper_typed( $row, 'description' ) ] + $row;
        }
    }
    return [
        'title'       => $text( 'title' ),
        'image_url'   => sweet_pepper_home_photo( $page_id, "home_{$key}_photo", 'sp-3x2', $typed['photo'] ),
        'image_alt'   => $text( 'alt' ),
        'image_badge' => $text( 'badge' ),
        'dishes'      => $dishes,
    ];
}

/**
 * The About preview: header, photo, the two stat chips — the years counted from the founding
 * year (sweet_pepper_years_since, the team tenure's rule), the rating as typed.
 */
function sweet_pepper_home_about( $page_id ) {
    $typed = sweet_pepper_home_typed( 'about' );
    $text  = sweet_pepper_page_text( $page_id, 'home_about', $typed );
    $since = $page_id && function_exists( 'get_field' ) ? (int) get_field( 'home_about_since', $page_id ) : 0;
    [ $headline, $headline_2 ] = sp_headline( 'home_about_headline', $typed, $page_id );
    return [
        'eyebrow'     => $text( 'eyebrow' ),
        'headline'    => $headline,
        'headline_2'  => $headline_2,
        'description' => $text( 'description' ),
        'image_url'   => sweet_pepper_home_photo( $page_id, 'home_about_photo', 'sp-3x2', $typed['photo'] ),
        'image_alt'   => $text( 'alt' ),
        'years'       => sweet_pepper_years_since( $since ?: (int) $typed['since'], sweet_pepper_lang() ),
        'rating'      => $text( 'rating' ),
    ];
}

/**
 * What's on: header, the cards (five at most) and the «More on VK» tile.
 */
function sweet_pepper_home_events( $page_id ) {
    $typed = sweet_pepper_home_typed( 'events' );
    $text  = sweet_pepper_page_text( $page_id, 'home_events', $typed );
    [ $saved, $rows ] = sweet_pepper_page_rows( $page_id, 'home_event_cards', $typed['cards'], [ 'title', 'alt' ] );
    $cards = [];
    foreach ( array_slice( $rows, 0, 5 ) as $row ) {
        $title = sweet_pepper_pick( $row, 'title' );
        $src   = sweet_pepper_photo_url( $saved ? ( $row['cover'] ?? '' ) : '', 'sp-4x5', $saved ? '' : (string) ( $row['cover'] ?? '' ) );
        if ( '' === $title || ! $src ) {
            continue;
        }
        $date = (string) ( $row['date'] ?? '' );
        if ( 'today' === $date ) {
            $date = date( 'j M' ); // the typed placeholder's "Today!" state
        } elseif ( $saved && $date ) {
            $date = date_i18n( 'j M', strtotime( $date ) );
        }
        $cards[] = [
            'image_url' => $src,
            'image_alt' => sweet_pepper_pick( $row, 'alt' ) ?: $title,
            'title'     => $title,
            'date'      => $date,
            'category'  => sanitize_key( (string) ( $row['category'] ?? '' ) ),
            'source'    => 'vk' === ( $row['source'] ?? '' ) ? 'vk' : 'instagram',
            'pinned'    => ! empty( $row['pinned'] ),
            'url'       => (string) ( $row['url'] ?? '' ),
        ];
    }
    $more = sweet_pepper_page_text( $page_id, 'home_events_more', $typed['more'] );
    $url  = $page_id && function_exists( 'get_field' ) ? (string) get_field( 'home_events_more_url', $page_id ) : '';
    [ $headline, $headline_2 ] = sp_headline( 'home_events_headline', $typed, $page_id );
    return [
        'eyebrow'     => $text( 'eyebrow' ),
        'headline'    => $headline,
        'headline_2'  => $headline_2,
        'description' => $text( 'description' ),
        'cards'       => $cards,
        'more'        => [
            'image_url' => sweet_pepper_home_photo( $page_id, 'home_events_more_photo', 'sp-4x5', $typed['more']['photo'] ),
            'image_alt' => $typed['more']['alt'],
            'label'     => $more( 'label' ),
            'url'       => $url ?: $typed['more']['url'],
        ],
    ];
}

/**
 * Contacts: the section's words. The channels are the part's.
 */
function sweet_pepper_home_contacts( $page_id ) {
    $typed = sweet_pepper_home_typed( 'contacts' );
    $text  = sweet_pepper_page_text( $page_id, 'home_contacts', $typed );
    [ $headline, $headline_2 ] = sp_headline( 'home_contacts_headline', $typed, $page_id );
    return [
        'eyebrow'            => $text( 'eyebrow' ),
        'headline'           => $headline,
        'headline_2'         => $headline_2,
        'description'        => $text( 'description' ),
        'description_mobile' => $text( 'description_mobile' ),
        'map_title'          => $text( 'map_title' ),
        'more_title'         => $text( 'more_title' ),
        'more_text'          => $text( 'more_text' ),
    ];
}

/**
 * The browser tab on the front page: the «Поиск» title in the request's language, the site
 * name after it as on every other page (WordPress's own front-page title is the site name +
 * tagline, one language).
 */
function sweet_pepper_home_document_title( $parts ) {
    if ( ! is_front_page() ) {
        return $parts;
    }
    $typed = sweet_pepper_home_typed( 'seo' );
    $title = sp_field( 'home_seo_title', sweet_pepper_typed( $typed, 'title' ), sweet_pepper_home_id() );
    if ( '' !== $title ) {
        $parts = [ 'title' => $title, 'site' => get_bloginfo( 'name', 'display' ) ];
    }
    return $parts;
}
add_filter( 'document_title_parts', 'sweet_pepper_home_document_title' );

/**
 * The description search engines show for the front page.
 */
function sweet_pepper_home_meta_description() {
    if ( ! is_front_page() ) {
        return;
    }
    $typed = sweet_pepper_home_typed( 'seo' );
    $text  = sp_field( 'home_seo_description', sweet_pepper_typed( $typed, 'description' ), sweet_pepper_home_id() );
    if ( '' !== $text ) {
        echo '<meta name="description" content="' . esc_attr( $text ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'sweet_pepper_home_meta_description', 1 );

// The pickers show size, price and the start of the description beside a name, as the
// menu pages' do (inc/menu-data-dishes.php).
foreach ( [ 'dish', 'home_bar_items', 'home_kitchen_items' ] as $sp_name ) {
    add_filter( "acf/fields/relationship/result/name={$sp_name}", 'sweet_pepper_dish_relationship_result', 10, 2 );
}
unset( $sp_name );

/**
 * The home page's connectors in Russian — the author's exports in assets/sectionLinks/home/
 * {dayMode,nightMode}/ru/ (23 Sep 2026; wording: home-copy-ru-draft.md → 9. Коннекторы).
 * English stem → [ RU stem, alt ]. Structure, not a field (the connectors stay in code).
 */
function sweet_pepper_home_connectors_ru() {
    return [
        'atSweetPepper'      => [ 'sweetPepperBar',          'Sweet Pepper Bar' ],
        'forAWellEarnedPour' => [ 'отКапучиноДоНастойки',    'От капучино до настойки' ], // author, 25 Sep 2026 — was ЗДЕСЬ ДРИНКИ С ПЕРЧИНКОЙ
        'forAProperAppetite' => [ 'отОмлетаДоЖаркого',       'От омлета до жаркого' ],    // author, 25 Sep 2026 — was ЗДЕСЬ НЕПРИЛИЧНО ВКУСНО
        'moreThanAMenu'      => [ 'людиИдеяХарактер',        'Люди, идея, характер' ],
        'seeWhatsNew'        => [ 'акцииНовостиВечеринки',   'Акции, новости, вечеринки' ],
        'joinTheParty'       => [ 'всеДорогиВедутВПерец',    'Все дороги ведут в Перец' ],
    ];
}

/**
 * Swap a home connector's day / night files and alt for the Russian twins on a Russian request
 * — the menu's rule (sweet_pepper_menu_connector_lang), for the home set: the English pair is
 * `<stem>-bottom.svg` (the word) / `<stem>-top.svg` (its reflection) per theme folder, the Russian
 * `ru/<stem>.svg` / `ru/<stem>-reflection.svg`. Both files must exist, or the English pair stays.
 * Called by template-parts/components/section-link-word.php.
 *
 * @return array [ day path, night path, alt ]
 */
function sweet_pepper_home_connector_lang( $day, $night, $alt ) {
    if ( 'ru' !== sweet_pepper_lang() ) {
        return [ $day, $night, $alt ];
    }
    // the night AT SWEET PEPPER word is atSweetPepperBottom.svg — the one file named without the dash
    $pattern = '~^assets/sectionLinks/home/(dayMode|nightMode)/([A-Za-z]+?)(-bottom|Bottom|-top)\.svg$~';
    if ( ! preg_match( $pattern, (string) $day, $d ) || ! preg_match( $pattern, (string) $night, $n ) || $d[2] !== $n[2] ) {
        return [ $day, $night, $alt ];
    }
    $twin = sweet_pepper_home_connectors_ru()[ $d[2] ] ?? null;
    if ( ! $twin ) {
        return [ $day, $night, $alt ];
    }
    $ru = [];
    foreach ( [ 'day' => $d, 'night' => $n ] as $mode => $m ) {
        $ru[ $mode ] = "assets/sectionLinks/home/{$m[1]}/ru/{$twin[0]}" . ( '-top' === $m[3] ? '-reflection' : '' ) . '.svg';
        if ( ! file_exists( get_template_directory() . '/' . $ru[ $mode ] ) ) {
            return [ $day, $night, $alt ];
        }
    }
    return [ $ru['day'], $ru['night'], $twin[1] ];
}
