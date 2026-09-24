<?php
/**
 * Seed a page section's fields in WordPress from the typed copy in
 * sweet-pepper-theme/data/ — so the admin form opens filled in, not empty over a page
 * that is visibly full (the templates fall back to the same typed copy until then).
 *
 * Run with Local's PHP and database socket — there is no `wp` on PATH:
 *
 *   PHP=~/Library/Application\ Support/Local/lightning-services/php-8.2.30+1/bin/darwin-arm64/bin/php
 *   SOCK=~/Library/Application\ Support/Local/run/1tx2Lcx_A/mysql/mysqld.sock
 *   "$PHP" -d mysqli.default_socket="$SOCK" tools/page-seed.php about location [--force]
 *
 *   about         — every tab of the About page from data/about/*.php (or one: about-hero,
 *                   about-concept, about-reviews, about-perks, about-story, about-guests,
 *                   about-team, about-careers, about-location, about-cta). Photos go into the
 *                   media library (assets/images/… → uploads), once — a re-seed finds them by
 *                   their source path and does not upload twice.
 *   visit         — every tab of the Visit page from data/visit/*.php (or one: visit-hero,
 *                   visit-status, visit-hours, visit-contacts, visit-location, visit-cta). The six
 *                   landmark slots are group fields; the entrance photo goes into the media library
 *                   as About's photos do.
 *   location      — data/location.php → Bar Settings → «Локация — заголовок»
 *   pairings      — data/pairings.php → the one «Гастробот» record (created if missing)
 *   menu          — the menu pages (inc/menu-page.php). First the shape: the kitchen page (template
 *                   Menu) becomes «Меню — кухня» at /menu/food/ under a new «Меню» folder page
 *                   (/menu/, template Menu — Index) when it still sits at /menu/ itself, and the
 *                   bar page — «Меню — бар», /menu/bar/, template Menu — Bar — is created when
 *                   missing. Then every SECTION tab: words from data/menu/sections-copy.php and
 *                   inc/menu-sections.php (only empty fields), the two photos as attachments, and
 *                   the subsections → dish lists — copied once from the section's old «Разделы меню»
 *                   record where one exists (the store before 24 Sep 2026; words edited there come
 *                   along), else left for tools/menu-seed.php. Then data/menu/page.php → the
 *                   «Сезонное меню», door and «Поиск» tabs; the seasonal list is seeded with what
 *                   the empty list shows anyway (the seasonal-labelled dishes), so form and page agree.
 *
 *   home          — the home page (inc/home-data.php). First the page: «Главная» is created when no
 *                   page is the front page yet, and Settings → Reading is set to open the site on
 *                   it (the theme's front-page.php renders it at / and /en/). Then every tab from
 *                   data/home/*.php — the hero's four dayparts and the closed-hours lines, the
 *                   highlight cards (two of them pointing at menu dishes found by their Russian
 *                   title and section), the two previews' three menu items each, the About
 *                   preview, the social cards (no dates — the team fills in real posts), contacts,
 *                   «Поиск»; photos as attachments. Also, once: the seed's placeholders on the
 *                   three infusions the bar preview points at give way to the home copy's lines.
 *
 * A target that already holds a value is left alone unless --force is given: after the
 * first seed the database is the source, and the team's edits live there.
 * Field keys: tools/page-field-groups.py.
 */

$args    = array_slice( $argv, 1 );
$force   = in_array( '--force', $args, true );
$targets = array_values( array_diff( $args, [ '--force' ] ) );
if ( ! $targets ) {
    exit( "Usage: page-seed.php <about|about-<section>|visit|visit-<section>|location|pairings|menu|home> [...] [--force]\n" );
}

$wp_root = getenv( 'WP_ROOT' ) ?: getenv( 'HOME' ) . '/Local Sites/sweet-pepper-bar/app/public';
require $wp_root . '/wp-load.php';

$data = get_template_directory() . '/data/';

/**
 * A theme photo as a media-library attachment: uploaded on the first call, found by its
 * source path (`_sp_source` meta) after that. Returns the attachment ID.
 */
function sp_seed_attachment( $asset ) {
    $found = get_posts( [ 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => 1, 'fields' => 'ids',
                          'meta_key' => '_sp_source', 'meta_value' => $asset ] );
    if ( $found ) {
        return (int) $found[0];
    }
    require_once ABSPATH . 'wp-admin/includes/image.php';
    $file = get_template_directory() . '/assets/images/' . $asset;
    $up   = wp_upload_bits( basename( $asset ), null, file_get_contents( $file ) );
    if ( ! empty( $up['error'] ) ) {
        exit( "upload failed for {$asset}: {$up['error']}\n" );
    }
    $id = wp_insert_attachment( [
        'post_mime_type' => $up['type'],
        'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $asset ) ),
        'post_status'    => 'inherit',
    ], $up['file'] );
    wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $up['file'] ) );
    update_post_meta( $id, '_sp_source', $asset );
    return (int) $id;
}

/** Write an RU / EN pair by field key; an untyped twin is stored empty and borrows the other. */
function sp_seed_twins( $key, $typed, $name, $post_id ) {
    update_field( "{$key}_en", $typed[ $name ] ?? '', $post_id );
    update_field( "{$key}_ru", $typed['ru'][ $name ] ?? '', $post_id );
}

/**
 * Typed rows → repeater rows keyed by field key. $twins are RU / EN pairs, $plain the rest;
 * a 'photo' column is an asset path and becomes an attachment ID.
 */
function sp_seed_rows( $typed_rows, $prefix, $twins, $plain ) {
    $rows = [];
    foreach ( $typed_rows as $row ) {
        $out = [];
        foreach ( $twins as $key ) {
            $out[ "{$prefix}{$key}_ru" ] = $row['ru'][ $key ] ?? '';
            $out[ "{$prefix}{$key}_en" ] = $row[ $key ] ?? '';
        }
        foreach ( $plain as $key ) {
            // a Russian-only column (the genitive name) sits under 'ru'
            $out[ "{$prefix}{$key}" ] = 'photo' === $key ? sp_seed_attachment( $row['photo'] ) : ( $row[ $key ] ?? $row['ru'][ $key ] ?? '' );
        }
        $rows[] = $out;
    }
    return $rows;
}

/**
 * One tab of a page (About, and the home page since 25 Sep 2026): `marker` is the field that
 * says "saved"; `twins` the prose pairs (field-key prefix → typed key); `rows` the repeaters;
 * `extra` a closure for what is neither (a photo, a picked dish). Returns a one-line report.
 */
function sp_seed_about_tab( $page_id, $force, $name, $typed, $marker, $twins, $rows = [], $extra = null ) {
    if ( metadata_exists( 'post', $page_id, $marker ) && ! $force ) {
        return "{$name}: already saved — left alone (--force to overwrite)";
    }
    foreach ( $twins as $key => $typed_key ) {
        sp_seed_twins( $key, $typed, $typed_key, $page_id );
    }
    $counts = [];
    foreach ( $rows as $field_key => [ $typed_key, $prefix, $pairs, $plain ] ) {
        $data = sp_seed_rows( $typed[ $typed_key ], $prefix, $pairs, $plain );
        update_field( $field_key, $data, $page_id );
        $counts[] = count( $data ) . " {$typed_key}";
    }
    if ( $extra ) {
        $extra( $page_id );
    }
    return "{$name}: seeded" . ( $counts ? ' ' . implode( ', ', $counts ) : '' );
}

/**
 * A menu item named by the typed copy — [ 'dish' | 'drink', its Russian title, the section that
 * places it ] — as a post ID; 0 (and a line) when the store has no such item. Two dishes may share
 * a name (three «Тыквенный суп»), so the section decides.
 */
function sp_seed_menu_item( $seed ) {
    [ $type, $title, $section ] = $seed;
    $found = get_posts( [ 'post_type' => $type, 'post_status' => 'any', 'numberposts' => -1, 'title' => $title, 'fields' => 'ids' ] );
    foreach ( $found as $id ) {
        if ( isset( sweet_pepper_dish_placements()[ $id ][ $section ] ) ) {
            return (int) $id;
        }
    }
    echo "  ! no {$type} «{$title}» placed in «{$section}» — left unpicked\n";
    return 0;
}

foreach ( $targets as $target ) {
    switch ( $target ) {
        case 'about':
        case 'about-hero':
        case 'about-concept':
        case 'about-reviews':
        case 'about-perks':
        case 'about-story':
        case 'about-guests':
        case 'about-team':
        case 'about-careers':
        case 'about-location':
        case 'about-cta':
            $page = get_page_by_path( 'about' );
            if ( ! $page ) {
                echo "{$target}: no page with the slug `about`\n";
                break;
            }
            $id  = $page->ID;
            $k   = 'field_sp_about_';
            $all = 'about' === $target;
            $t   = fn( $section ) => require $data . "about/{$section}.php";
            $hdr = fn( $s, $with_description = true ) => [ "{$k}{$s}_eyebrow" => 'eyebrow', "{$k}{$s}_headline" => 'headline', "{$k}{$s}_headline_2" => 'headline_2' ]
                + ( $with_description ? [ "{$k}{$s}_description" => 'description' ] : [] );

            if ( $all || 'about-hero' === $target ) {
                echo sp_seed_about_tab( $id, $force, 'about-hero', $t( 'hero' ), 'about_hero_lead_en',
                    [ "{$k}hero_eyebrow" => 'eyebrow', "{$k}hero_headline" => 'headline', "{$k}hero_lead" => 'lead' ] ), "\n";
            }
            if ( $all || 'about-concept' === $target ) {
                echo sp_seed_about_tab( $id, $force, 'about-concept', $t( 'concept' ), 'about_concept_headline_en', $hdr( 'concept' ) ), "\n";
            }
            if ( $all || 'about-reviews' === $target ) {
                $typed = $t( 'reviews' );
                foreach ( $typed['quotes'] as &$q ) { // the template's shape → the row's
                    $q['text_ru'] = $q['text'];
                    $q['ru']      = [ 'footnote' => '' ];
                }
                unset( $q );
                echo sp_seed_about_tab( $id, $force, 'about-reviews', $typed, 'about_quotes', $hdr( 'reviews', false ),
                    [ "{$k}quotes" => [ 'quotes', "{$k}quote_", [ 'footnote' ], [ 'text_ru', 'text_en', 'word', 'platform', 'link', 'id' ] ] ] ), "\n";
            }
            if ( $all || 'about-perks' === $target ) {
                echo sp_seed_about_tab( $id, $force, 'about-perks', $t( 'perks' ), 'about_perks', $hdr( 'perks', false ),
                    [ "{$k}perks" => [ 'perks', "{$k}perk_", [ 'label', 'word', 'title', 'description' ], [ 'icon' ] ] ] ), "\n";
            }
            if ( $all || 'about-story' === $target ) {
                $typed = $t( 'story' );
                echo sp_seed_about_tab( $id, $force, 'about-story', $typed, 'about_milestones',
                    $hdr( 'story', false ) + [
                        "{$k}story_p1" => 'p1', "{$k}story_p2" => 'p2', "{$k}story_p3" => 'p3',
                        "{$k}founder_alt" => 'founder_alt', "{$k}founder_quote" => 'founder_quote',
                        "{$k}founder_name" => 'founder_name', "{$k}founder_title" => 'founder_title',
                        "{$k}counters_label" => 'counters_label', "{$k}counters_label_2" => 'counters_label_2',
                    ],
                    [
                        "{$k}milestones" => [ 'milestones', "{$k}milestone_", [ 'name', 'wit' ], [ 'year' ] ],
                        "{$k}counters"   => [ 'counters', "{$k}counter_", [ 'label' ], [ 'number' ] ],
                    ],
                    fn( $id ) => update_field( "{$k}founder_photo", sp_seed_attachment( $typed['founder_photo'] ), $id ) ), "\n";
            }
            if ( $all || 'about-guests' === $target ) {
                echo sp_seed_about_tab( $id, $force, 'about-guests', $t( 'guests' ), 'about_guest_cards', $hdr( 'guests' ),
                    [ "{$k}guest_cards" => [ 'cards', "{$k}guest_", [ 'label', 'alt' ], [ 'photo', 'url' ] ] ] ), "\n";
            }
            if ( $all || 'about-team' === $target ) {
                echo sp_seed_about_tab( $id, $force, 'about-team', $t( 'team' ), 'about_team_members', $hdr( 'team', false ), [
                    "{$k}team_wall"    => [ 'wall', "{$k}wall_", [], [ 'photo', 'year' ] ],
                    "{$k}team_members" => [ 'members', "{$k}member_", [ 'name', 'role', 'message' ], [ 'photo', 'since', 'chip', 'name_gen' ] ],
                ] ), "\n";
            }
            if ( $all || 'about-careers' === $target ) {
                echo sp_seed_about_tab( $id, $force, 'about-careers', $t( 'careers' ), 'about_positions', $hdr( 'careers' ) + [
                    "{$k}careers_cta_title" => 'cta_title', "{$k}careers_cta_text" => 'cta_text',
                    "{$k}careers_empty_title" => 'empty_title', "{$k}careers_empty_text" => 'empty_text',
                ], [ "{$k}positions" => [ 'positions', "{$k}position_", [ 'title', 'meta', 'description' ], [ 'department', 'url' ] ] ] ), "\n";
            }
            if ( $all || 'about-location' === $target ) {
                echo sp_seed_about_tab( $id, $force, 'about-location', $t( 'location' ), 'about_location_description_en', [ "{$k}location_description" => 'description' ] ), "\n";
            }
            if ( $all || 'about-cta' === $target ) {
                echo sp_seed_about_tab( $id, $force, 'about-cta', $t( 'cta' ), 'about_cta_headline_en', [ "{$k}cta_headline" => 'headline', "{$k}cta_body" => 'body' ] ), "\n";
            }
            break;

        case 'visit':
        case 'visit-hero':
        case 'visit-status':
        case 'visit-hours':
        case 'visit-contacts':
        case 'visit-location':
        case 'visit-cta':
            $page = get_page_by_path( 'visit' );
            if ( ! $page ) {
                echo "{$target}: no page with the slug `visit`\n";
                break;
            }
            $id = $page->ID;
            $k  = 'field_sp_visit_';
            foreach ( [ 'hero', 'status', 'hours', 'contacts', 'location', 'cta' ] as $section ) {
                if ( 'visit' !== $target && "visit-{$section}" !== $target ) {
                    continue;
                }
                $typed = require $data . "visit/{$section}.php";
                $keys  = array_keys( array_filter( $typed, 'is_string' ) );
                $keys  = array_values( array_diff( $keys, [ 'photo' ] ) ); // the CTA photo is an attachment, below
                $twins = [];
                foreach ( $keys as $key ) {
                    $twins[ "{$k}{$section}_{$key}" ] = $key;
                }
                $extra = null;
                if ( 'location' === $section ) {
                    // One group field per landmark slot, keyed by sub-field key.
                    $extra = function ( $id ) use ( $typed, $k ) {
                        foreach ( $typed['landmarks'] as $slot => $l ) {
                            $value = [];
                            foreach ( [ 'name', 'hint', 'distance' ] as $key ) {
                                $value[ "{$k}landmark_{$slot}_{$key}_ru" ] = $l['ru'][ $key ] ?? '';
                                $value[ "{$k}landmark_{$slot}_{$key}_en" ] = $l[ $key ] ?? '';
                            }
                            update_field( "{$k}landmark_{$slot}", $value, $id );
                        }
                    };
                } elseif ( 'cta' === $section ) {
                    $extra = fn( $id ) => update_field( "{$k}cta_photo", sp_seed_attachment( $typed['photo'] ), $id );
                }
                echo sp_seed_about_tab( $id, $force, "visit-{$section}", $typed, "visit_{$section}_{$keys[0]}_en", $twins, [], $extra ), "\n";
            }
            break;

        case 'location':
            if ( '' !== trim( (string) get_field( 'location_headline_en', 'option' ) . get_field( 'location_headline_ru', 'option' ) ) && ! $force ) {
                echo "location: already saved — left alone (--force to overwrite)\n";
                break;
            }
            $typed = require $data . 'location.php';
            sp_seed_twins( 'field_sp_location_headline', $typed, 'headline', 'option' );
            sp_seed_twins( 'field_sp_location_headline_2', $typed, 'headline_2', 'option' );
            echo "location: seeded\n";
            break;

        case 'pairings':
            $post = sweet_pepper_pairings_post();
            if ( ! $post ) {
                $id = wp_insert_post( [ 'post_type' => 'pairings', 'post_status' => 'publish', 'post_title' => 'Гастробот' ] );
                echo "pairings: record {$id} created\n";
            } else {
                $id = $post->ID;
                // Renamed «Гастробот» on 23 Sep 2026: a record made before that is renamed, nothing else.
                if ( 'Подбор пары' === $post->post_title ) {
                    wp_update_post( [ 'ID' => $id, 'post_title' => 'Гастробот' ] );
                    echo "pairings: record {$id} renamed «Гастробот»\n";
                }
                if ( get_field( 'pairs', $id ) && ! $force ) {
                    echo "pairings: already saved — left alone (--force to overwrite)\n";
                    break;
                }
            }
            $k    = 'field_sp_pair_';
            $rows = [];
            foreach ( require $data . 'pairings.php' as $row ) {
                $rows[] = [
                    "{$k}dish_photo"          => sp_seed_attachment( $row['food_img'] ),
                    "{$k}dish_name_ru"        => $row['ru']['dish'] ?? '',
                    "{$k}dish_name_en"        => $row['dish'],
                    "{$k}default"             => $row['default'] ? 1 : 0,
                    "{$k}hidden"              => 0,
                    "{$k}dish_short_ru"       => $row['ru']['dish_short'] ?? '',
                    "{$k}dish_short_en"       => $row['dish_short'],
                    "{$k}dish_description_ru" => $row['ru']['description'] ?? '',
                    "{$k}dish_description_en" => $row['description'],
                    "{$k}drink_photo"         => sp_seed_attachment( $row['bar_img'] ),
                    "{$k}drink_section"       => $row['drink_section'],
                    "{$k}reply_ru"            => $row['ru']['reply'] ?? '',
                    "{$k}reply_en"            => $row['reply'],
                ];
            }
            update_field( "{$k}rows", $rows, $id );
            echo 'pairings: seeded ' . count( $rows ) . " pairs on record {$id}\n";
            break;

        case 'menu':
            $typed = require $data . 'menu/page.php';
            $pages = [ 'food' => sweet_pepper_menu_page( 'food' ) ];
            if ( ! $pages['food'] ) {
                echo "menu: no page with the template Menu (page-menu.php)\n";
                break;
            }
            // The folder: the kitchen page moves from /menu/ to /menu/food/ under a new «Меню»
            // page (author, 24 Sep 2026: the address bar says which menu, and the team sees
            // both menus under one folder). Idempotent — a kitchen page already under the folder is left alone.
            // wp_update_post() re-validates a page's template against the served theme's files and
            // resets an unknown one to "default" — so after every update the template is set again by
            // meta, which skips the check (bitten locally, where the served theme lagged the branch).
            $move = function ( $id, $fields ) {
                $template = get_post_meta( $id, '_wp_page_template', true );
                wp_update_post( [ 'ID' => $id ] + $fields );
                update_post_meta( $id, '_wp_page_template', $template );
                clean_post_cache( $id );
            };
            $folder = sweet_pepper_menu_page( 'index' );
            if ( ! $folder ) {
                $food = $pages['food'];
                $slug = 'menu' === $food->post_name ? 'menu' : $food->post_name;
                if ( 'menu' === $food->post_name ) {
                    // free the slug first, or the folder gets menu-2
                    $move( $food->ID, [ 'post_name' => 'food', 'post_title' => 'Menu' === $food->post_title ? 'Меню — кухня' : $food->post_title ] );
                }
                $id = wp_insert_post( [
                    'post_type'   => 'page',
                    'post_status' => 'publish',
                    'post_title'  => 'Меню',
                    'post_name'   => $slug,
                    'post_parent' => $food->post_parent,
                    'menu_order'  => $food->menu_order,
                    'meta_input'  => [ '_wp_page_template' => 'page-menu-index.php' ],
                ], true );
                if ( is_wp_error( $id ) ) {
                    exit( 'menu: could not create the folder page — ' . $id->get_error_message() . "\n" );
                }
                $move( $food->ID, [ 'post_parent' => $id, 'menu_order' => 1 ] );
                $folder = get_post( $id );
                echo "menu: folder page {$id} created — " . get_permalink( $id ) . "; kitchen page {$food->ID} → " . get_permalink( $food->ID ) . "\n";
                $pages['food'] = get_post( $food->ID );
            }
            $pages['drinks'] = sweet_pepper_menu_page( 'drinks' );
            if ( ! $pages['drinks'] ) {
                $id = wp_insert_post( [
                    'post_type'    => 'page',
                    'post_status'  => 'publish',
                    'post_title'   => 'Меню — бар',
                    'post_name'    => 'bar',
                    'post_parent'  => $folder->ID,
                    'menu_order'   => 2,
                    'meta_input'   => [ '_wp_page_template' => 'page-menu-bar.php' ],
                ], true );
                if ( is_wp_error( $id ) ) {
                    exit( 'menu: could not create the bar page — ' . $id->get_error_message() . "\n" );
                }
                $pages['drinks'] = get_post( $id );
                echo "menu: bar page {$id} created — " . get_permalink( $id ) . "\n";
            } elseif ( (int) $pages['drinks']->post_parent !== (int) $folder->ID ) {
                // a bar page made before the folder existed (24 Sep 2026, first shape) moves under it
                $move( $pages['drinks']->ID, [ 'post_parent' => $folder->ID, 'menu_order' => 2 ] );
                echo "menu: bar page {$pages['drinks']->ID} moved under the folder — " . get_permalink( $pages['drinks']->ID ) . "\n";
            }
            foreach ( $pages as $state => $page ) {
                $id = $page->ID;
                $k  = 'food' === $state ? 'field_sp_mfood_' : 'field_sp_mbar_'; // tools/page-field-groups.py
                // ── The section tabs ──
                foreach ( sweet_pepper_menu_sections_typed( $state ) as $slug => $sec ) {
                    $n       = 'sec_' . str_replace( '-', '_', $slug ) . '_';
                    $written = [];
                    $set     = function ( $key, $value ) use ( $id, $k, $n, &$written ) {
                        $current = get_field( "{$n}{$key}", $id );
                        if ( '' === trim( (string) ( is_scalar( $current ) ? $current : '' ) ) && ( ! is_array( $current ) || ! $current ) && '' !== trim( (string) ( is_scalar( $value ) ? $value : '1' ) ) ) {
                            update_field( "{$k}{$n}{$key}", $value, $id );
                            $written[] = $key;
                        }
                    };
                    // 1. What the old «Разделы меню» record holds: its lists, and words edited there.
                    $record = get_page_by_path( $slug, OBJECT, 'menu_list' );
                    if ( $record ) {
                        $rows = get_field( 'menu_subsections', $record->ID );
                        if ( $rows ) {
                            $set( 'subsections', array_map( fn( $row ) => [
                                "{$k}{$n}sub_title_ru" => $row['title_ru'] ?? '', "{$k}{$n}sub_title_en" => $row['title_en'] ?? '',
                                "{$k}{$n}sub_column"   => $row['column'] ?? 'left', "{$k}{$n}sub_style" => $row['style'] ?? 'list',
                                "{$k}{$n}sub_dishes"   => array_map( 'intval', (array) ( $row['dishes'] ?? [] ) ),
                                "{$k}{$n}sub_note_ru"  => $row['note_ru'] ?? '', "{$k}{$n}sub_note_en" => $row['note_en'] ?? '',
                                "{$k}{$n}sub_divider"  => empty( $row['divider'] ) ? 0 : 1,
                            ], $rows ) );
                        }
                        foreach ( sweet_pepper_menu_section_copy_keys() as $key ) {
                            foreach ( [ 'ru', 'en' ] as $lang ) {
                                $set( "{$key}_{$lang}", (string) get_field( "sec_{$key}_{$lang}", $record->ID ) );
                            }
                        }
                    }
                    // 2. The typed words and photos for whatever is still empty.
                    foreach ( sweet_pepper_menu_section_copy_typed( $slug ) as $lang => $words ) {
                        foreach ( $words as $key => $value ) {
                            $set( "{$key}_{$lang}", $value );
                        }
                    }
                    $set( 'hero_photo', sp_seed_attachment( $sec['image'] ) );
                    if ( preg_match( '/^\S+ (\d+)%$/', (string) ( $sec['focus'] ?? '' ), $m ) ) {
                        $set( 'hero_focus', (int) $m[1] );
                    }
                    if ( ! empty( $sec['band'] ) ) {
                        $set( 'photo', sp_seed_attachment( $sec['band'] ) );
                    }
                    echo "menu ({$state}, page {$id}) {$slug}: " . ( $written ? count( $written ) . ' fields written' . ( in_array( 'subsections', $written, true ) ? ' (lists from the old record)' : '' ) : 'nothing to write' ) . "\n";
                }
                // ── «Сезонное меню», the door, «Поиск» ──
                if ( metadata_exists( 'post', $id, 'menu_highlights' ) && ! $force ) {
                    echo "menu ({$state}, page {$id}): seasonal / door / search already saved — left alone (--force to overwrite)\n";
                    continue;
                }
                $t = $typed[ $state ];
                sp_seed_twins( "{$k}door_label", $t['door'], 'label', $id );
                sp_seed_twins( "{$k}door_caption", $t['door'], 'caption', $id );
                sp_seed_twins( "{$k}door_description", $t['door'], 'description', $id );
                update_field( "{$k}door_photo", sp_seed_attachment( $t['door']['image'] ), $id );
                if ( ! empty( $t['door_night'] ) ) { // the kitchen page's night set
                    sp_seed_twins( "{$k}door_night_caption", $t['door_night'], 'caption', $id );
                    sp_seed_twins( "{$k}door_night_description", $t['door_night'], 'description', $id );
                    update_field( "{$k}door_night_photo", sp_seed_attachment( $t['door_night']['image'] ), $id );
                }
                foreach ( [ 'eyebrow', 'headline', 'headline_2' ] as $key ) {
                    sp_seed_twins( "{$k}highlights_{$key}", $t['highlights'], $key, $id );
                }
                sp_seed_twins( "{$k}seo_title", $t['seo'], 'title', $id );
                sp_seed_twins( "{$k}seo_description", $t['seo'], 'description', $id );
                // The list: what the empty list shows — the menu's seasonal-labelled items, in menu order.
                $ids = [];
                foreach ( sweet_pepper_menu_items_in_order( $state ) as $item ) {
                    if ( '' !== trim( (string) get_field( 'seasonal_ru', $item ) . get_field( 'seasonal_en', $item ) ) ) {
                        $ids[] = $item;
                    }
                }
                $ids = array_slice( $ids, 0, 8 );
                update_field( "{$k}highlights", $ids, $id );
                echo "menu ({$state}, page {$id}): seeded — door, header, title, " . count( $ids ) . " highlights\n";
            }
            break;

        case 'home':
            // The seeder reads the SERVED theme (get_template_directory): until the branch that built the
            // home page is merged and served, there is nothing to seed with — say so instead of a fatal.
            if ( ! function_exists( 'sweet_pepper_home_page' ) || ! is_dir( $data . 'home' ) ) {
                echo "home: the served theme (" . get_template_directory() . ") has no home page reader or data/home/ yet — merge and deploy the branch first, then run this again\n";
                break;
            }
            // The page. The theme renders the home page from front-page.php whatever Settings → Reading
            // says, but the FIELDS need a page to sit on: a static front page, «Главная».
            $page = sweet_pepper_home_page();
            if ( ! $page ) {
                $page = get_page_by_path( 'home' );
                if ( ! $page ) {
                    $id = wp_insert_post( [ 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Главная', 'post_name' => 'home' ], true );
                    if ( is_wp_error( $id ) ) {
                        exit( 'home: could not create the page — ' . $id->get_error_message() . "\n" );
                    }
                    $page = get_post( $id );
                    echo "home: page {$id} «Главная» created\n";
                }
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $page->ID );
                echo "home: page {$page->ID} is the front page now (Settings → Reading) — " . get_permalink( $page->ID ) . "\n";
            }
            $id  = $page->ID;
            $k   = 'field_sp_home_';
            $t   = fn( $section ) => require $data . "home/{$section}.php";
            $hdr = fn( $s ) => [ "{$k}{$s}_eyebrow" => 'eyebrow', "{$k}{$s}_headline" => 'headline', "{$k}{$s}_headline_2" => 'headline_2', "{$k}{$s}_description" => 'description' ];

            $typed = $t( 'hero' );
            echo sp_seed_about_tab( $id, $force, 'home-hero', $typed, 'home_hero_eyebrow_en', [ "{$k}hero_eyebrow" => 'eyebrow' ], [], function ( $id ) use ( $k, $typed ) {
                foreach ( $typed['dayparts'] as $dp => $d ) {
                    foreach ( [ 'alt', 'headline', 'body', 'button' ] as $key ) {
                        sp_seed_twins( "{$k}hero_{$dp}_{$key}", $d, $key, $id );
                    }
                    update_field( "{$k}hero_{$dp}_photo", sp_seed_attachment( $d['photo'] ), $id );
                }
                foreach ( $typed['closed'] as $window => $c ) {
                    sp_seed_twins( "{$k}hero_closed_{$window}_headline", $c, 'headline', $id );
                    sp_seed_twins( "{$k}hero_closed_{$window}_body", $c, 'body', $id );
                }
            } ), "\n";

            $typed = $t( 'highlights' );
            echo sp_seed_about_tab( $id, $force, 'home-highlights', $typed, 'home_highlight_cards', $hdr( 'highlights' ), [], function ( $id ) use ( $k, $typed ) {
                $rows = [];
                foreach ( $typed['cards'] as $card ) {
                    // A dish card points at the store (found by title + section) and types only what is the
                    // card's — its short name, its line, the tag; a category card (no `seed`) types it all.
                    $dish = ! empty( $card['seed'] ) ? sp_seed_menu_item( $card['seed'] ) : 0;
                    if ( $dish && ! get_field( 'photo', $dish ) ) {
                        // The dish has no photo of its own yet: the card's typed photo becomes the dish's
                        // («Фото» + the featured image it mirrors), so the card — and the menu's strip — show it.
                        $photo = sp_seed_attachment( $card['photo'] );
                        update_field( 'photo', $photo, $dish );
                        update_post_meta( $dish, '_thumbnail_id', $photo );
                        echo "  dish {$dish} «{$card['seed'][1]}»: photo set from the card's ({$card['photo']})\n";
                    }
                    $rows[] = [
                        "{$k}card_dish"           => $dish ? [ $dish ] : [],
                        "{$k}card_title_ru"       => $dish ? '' : ( $card['ru']['title'] ?? '' ),
                        "{$k}card_title_en"       => $dish ? ( $card['short'] ?? '' ) : $card['title'],
                        "{$k}card_photo"          => $dish ? '' : sp_seed_attachment( $card['photo'] ),
                        "{$k}card_price_ru"       => $dish ? '' : ( $card['ru']['price'] ?? '' ),
                        "{$k}card_price_en"       => $dish ? '' : $card['price'],
                        "{$k}card_section"        => $card['section'],
                        "{$k}card_description_ru" => $card['ru']['description'] ?? '',
                        "{$k}card_description_en" => $card['description'],
                        "{$k}card_tag_icon"       => $card['tag_icon'],
                        "{$k}card_tag_label_ru"   => $card['ru']['tag_label'] ?? '',
                        "{$k}card_tag_label_en"   => $card['tag_label'],
                    ];
                }
                update_field( "{$k}highlight_cards", $rows, $id );
                echo '  ' . count( $rows ) . ' cards, ' . count( array_filter( array_column( $rows, "{$k}card_dish" ) ) ) . " of them menu dishes\n";
            } ), "\n";

            foreach ( [ 'bar', 'kitchen' ] as $key ) {
                $typed = $t( $key );
                echo sp_seed_about_tab( $id, $force, "home-{$key}", $typed, "home_{$key}_items", [ "{$k}{$key}_title" => 'title', "{$k}{$key}_alt" => 'alt', "{$k}{$key}_badge" => 'badge' ], [], function ( $id ) use ( $k, $key, $typed ) {
                    update_field( "{$k}{$key}_photo", sp_seed_attachment( $typed['photo'] ), $id );
                    $ids = array_values( array_filter( array_map( 'sp_seed_menu_item', $typed['items'] ) ) );
                    update_field( "{$k}{$key}_items", $ids, $id );
                    echo '  ' . count( $ids ) . ' of ' . count( $typed['items'] ) . " menu items picked\n";
                } ), "\n";
            }

            $typed = $t( 'about' );
            echo sp_seed_about_tab( $id, $force, 'home-about', $typed, 'home_about_since', $hdr( 'about' ) + [ "{$k}about_alt" => 'alt', "{$k}about_rating" => 'rating' ], [], function ( $id ) use ( $k, $typed ) {
                update_field( "{$k}about_photo", sp_seed_attachment( $typed['photo'] ), $id );
                update_field( "{$k}about_since", (int) $typed['since'], $id );
            } ), "\n";

            $typed = $t( 'events' );
            echo sp_seed_about_tab( $id, $force, 'home-events', $typed, 'home_event_cards', $hdr( 'events' ), [], function ( $id ) use ( $k, $typed ) {
                $rows = [];
                foreach ( $typed['cards'] as $card ) {
                    // Placeholders until the team pastes real posts: no invented date, the source the link names.
                    $rows[] = [
                        "{$k}event_cover"    => sp_seed_attachment( $card['cover'] ),
                        "{$k}event_title_ru" => $card['ru']['title'] ?? '',
                        "{$k}event_title_en" => $card['title'],
                        "{$k}event_date"     => '',
                        "{$k}event_category" => $card['category'],
                        "{$k}event_source"   => 'vk',
                        "{$k}event_url"      => $card['url'],
                        "{$k}event_pinned"   => empty( $card['pinned'] ) ? 0 : 1,
                        "{$k}event_alt_ru"   => '',
                        "{$k}event_alt_en"   => $card['alt'],
                    ];
                }
                update_field( "{$k}event_cards", $rows, $id );
                update_field( "{$k}events_more_photo", sp_seed_attachment( $typed['more']['photo'] ), $id );
                sp_seed_twins( "{$k}events_more_label", $typed['more'], 'label', $id );
                update_field( "{$k}events_more_url", $typed['more']['url'], $id );
                echo '  ' . count( $rows ) . " cards (placeholders, no dates)\n";
            } ), "\n";

            $typed = $t( 'contacts' );
            echo sp_seed_about_tab( $id, $force, 'home-contacts', $typed, 'home_contacts_headline_en', $hdr( 'contacts' ) + [
                "{$k}contacts_description_mobile" => 'description_mobile', "{$k}contacts_map_title" => 'map_title',
                "{$k}contacts_more_title" => 'more_title', "{$k}contacts_more_text" => 'more_text',
            ] ), "\n";

            $typed = $t( 'seo' );
            echo sp_seed_about_tab( $id, $force, 'home-seo', $typed, 'home_seo_title_en', [ "{$k}seo_title" => 'title', "{$k}seo_description" => 'description' ] ), "\n";

            // The bar preview prints three infusion records; two still held the seed's placeholders
            // where the home copy has the approved line (home-copy-en.md → 3; data/menu/infusions.php
            // says the same now). Written only while the old value is still there — an edit in admin wins.
            foreach ( [
                [ 'Хреновуха',       'name_en',        'Horseraddish',                  'Horseradish' ],
                [ 'Хреновуха',       'description_en', 'description',                   "For the brave — a taste of Yaroslavl's hot side." ],
                [ 'Малина на Джине', 'description_en', 'Fruity gin infusion, premium.', 'Gin infused with raspberries.' ],
            ] as [ $title, $field, $old, $new ] ) {
                $item = sp_seed_menu_item( [ 'drink', $title, 'infusions' ] );
                if ( $item && trim( (string) get_field( $field, $item ) ) === $old ) {
                    update_field( $field, $new, $item );
                    echo "home: drink {$item} «{$title}» {$field}: «{$old}» → «{$new}»\n";
                }
            }
            break;

        default:
            echo "{$target}: unknown target\n";
    }
}
