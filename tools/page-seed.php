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
 *   location      — data/location.php → Bar Settings → «Локация — заголовок»
 *   pairings      — data/pairings.php → the one «Гастробот» record (created if missing)
 *
 * A target that already holds a value is left alone unless --force is given: after the
 * first seed the database is the source, and the team's edits live there.
 * Field keys: tools/page-field-groups.py.
 */

$args    = array_slice( $argv, 1 );
$force   = in_array( '--force', $args, true );
$targets = array_values( array_diff( $args, [ '--force' ] ) );
if ( ! $targets ) {
    exit( "Usage: page-seed.php <about|about-<section>|location|pairings> [...] [--force]\n" );
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
 * One About tab: `marker` is the field that says "saved"; `twins` the prose pairs
 * (field-key prefix → typed key); `rows` the repeaters. Returns a one-line report.
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

        default:
            echo "{$target}: unknown target\n";
    }
}
