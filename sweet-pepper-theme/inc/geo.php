<?php
/**
 * Instagram, only outside Russia (the team's lawyer, 28 Sep 2026).
 *
 * The Russian page never shows Instagram — no icon, no CTA, no link, no schema.org sameAs.
 * The English page shows it unless the visitor's IP is Russian. The author ruled out the
 * other two options: the account name without a link plus a required note, and one
 * «Соцсети» contact with the shared handle over a VK link.
 *
 * The country check stays on this server: the IP the request already carries is looked up
 * in data/geo-ru.php (Russia's address blocks from the RIPE NCC registry, written by
 * tools/geo-ranges.php) and forgotten — no third-party service, no cookie, nothing
 * stored. VPN visitors get what their exit country gets; the author accepted that.
 *
 * Because the English page now differs by visitor, it is never page-cached (DONOTCACHEPAGE,
 * which WP Super Cache honours) — a cached copy would hand one visitor's version to all.
 * The Russian page is the same for everyone and caches as before.
 *
 * Maps without asking, for the US and Canada (author, 29 Sep 2026). The English page is the
 * author's portfolio, read mostly by clients there: on /en/ from a US or Canadian IP
 * (data/geo-na.php, ARIN) the Google maps load with the page — no placeholder, no Map
 * settings — and the cookie notice says so in a line. The Russian page and every other
 * visitor keep the permission step.
 *
 * @package Sweet_Pepper
 */

/**
 * The visitor's IP. REMOTE_ADDR, unless it is the host's own proxy (a private or loopback
 * address) — then the proxy's X-Real-IP / first X-Forwarded-For. A forged header can only
 * hide Instagram from the one who forged it.
 */
function sweet_pepper_client_ip() {
    $ip = (string) ( $_SERVER['REMOTE_ADDR'] ?? '' );
    if ( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE ) ) {
        return $ip;
    }
    foreach ( [ 'HTTP_X_REAL_IP', 'HTTP_X_FORWARDED_FOR' ] as $header ) {
        $candidate = trim( explode( ',', (string) ( $_SERVER[ $header ] ?? '' ) )[0] );
        if ( filter_var( $candidate, FILTER_VALIDATE_IP ) ) {
            return $candidate;
        }
    }
    return $ip;
}

/**
 * Whether an IP falls in one of a country list's registered blocks (data/geo-{list}.php:
 * 'ru', 'na'). Binary search over sorted, merged ranges: IPv4 as integers, IPv6 as 32-digit
 * hex (fixed length, so string order is address order).
 */
function sweet_pepper_ip_in( $list, $ip ) {
    static $lists = [];
    $packed = @inet_pton( (string) $ip );
    if ( false === $packed ) {
        return false;
    }
    if ( ! isset( $lists[ $list ] ) ) {
        $file           = get_template_directory() . "/data/geo-$list.php";
        $lists[ $list ] = is_readable( $file ) ? require $file : [];
    }
    $ranges = $lists[ $list ];
    if ( 4 === strlen( $packed ) ) {
        [ $starts, $ends, $key ] = [ $ranges['v4_start'] ?? [], $ranges['v4_end'] ?? [], unpack( 'N', $packed )[1] ];
        $cmp = fn( $a, $b ) => $a <=> $b;
    } else {
        [ $starts, $ends, $key ] = [ $ranges['v6_start'] ?? [], $ranges['v6_end'] ?? [], bin2hex( $packed ) ];
        $cmp = 'strcmp'; // PHP would compare an all-digit hex string as a number
    }
    // The last range starting at or below the key; the key is inside it or in no range.
    [ $lo, $hi, $hit ] = [ 0, count( $starts ) - 1, -1 ];
    while ( $lo <= $hi ) {
        $mid = ( $lo + $hi ) >> 1;
        if ( $cmp( $starts[ $mid ], $key ) <= 0 ) {
            [ $hit, $lo ] = [ $mid, $mid + 1 ];
        } else {
            $hi = $mid - 1;
        }
    }
    return $hit >= 0 && $cmp( $key, $ends[ $hit ] ) <= 0;
}

function sweet_pepper_ip_in_russia( $ip ) {
    return sweet_pepper_ip_in( 'ru', $ip );
}

/**
 * Whether this request may show Instagram at all. Every Instagram icon, CTA, link and
 * mention in the theme goes through this.
 */
function sweet_pepper_show_instagram() {
    static $show = null;
    if ( null === $show ) {
        // ?ru-test — any page as a Russian IP sees it, to check the layout from abroad. It can
        // only hide Instagram, never show it, so it is safe on the live site.
        $show = 'ru' !== sweet_pepper_lang() && ! isset( $_GET['ru-test'] ) && ! sweet_pepper_ip_in_russia( sweet_pepper_client_ip() );
        /** Tests: force either answer (tools, a local wp-config line). */
        $show = (bool) apply_filters( 'sweet_pepper_show_instagram', $show );
    }
    return $show;
}

/** Privacy choices now apply in every language and country (2 October 2026).
 * Retained for the existing admin diagnostic below; never bypass visitor choice. */
function sweet_pepper_maps_open() { return false; }

/**
 * Typed text without its Instagram mention where Instagram may not show. A trailing clause
 * goes on its own ("…and specials, or take a look on Instagram." → "…and specials."); any
 * other sentence naming Instagram goes whole. Text with no mention comes back as typed.
 */
function sweet_pepper_without_instagram( $text ) {
    if ( sweet_pepper_show_instagram() || false === stripos( (string) $text, 'instagram' ) ) {
        return $text;
    }
    $kept = [];
    foreach ( preg_split( '/(?<=[.!?])\s+/u', trim( (string) $text ) ) as $sentence ) {
        $sentence = preg_replace( '/,\s*(?:or|and|или|и)\s+[^.,!?]*instagram[^.,!?]*(?=[.!?]?$)/iu', '', $sentence );
        if ( false === stripos( $sentence, 'instagram' ) ) {
            $kept[] = $sentence;
        }
    }
    return implode( ' ', $kept );
}

/**
 * The English page is per-visitor now: never page-cached, never kept by a shared cache.
 */
add_action( 'template_redirect', function () {
    if ( is_admin() || 'ru' === sweet_pepper_lang() ) {
        return;
    }
    if ( ! defined( 'DONOTCACHEPAGE' ) ) {
        define( 'DONOTCACHEPAGE', true );
    }
    header( 'Cache-Control: private, max-age=0' );
}, 0 );

/**
 * For a signed-in admin, the verdict as an HTML comment at the foot of the page — to check
 * on the live host which IP the server sees and what it decided (view source, search
 * "sp-geo"). Visitors never get it.
 */
add_action( 'wp_footer', function () {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    $ip = sweet_pepper_client_ip();
    printf(
        "\n<!-- sp-geo: ip %s, Russian IP: %s, US/Canadian IP: %s, Instagram shown: %s, maps without asking: %s -->\n",
        esc_html( $ip ),
        sweet_pepper_ip_in_russia( $ip ) ? 'yes' : 'no',
        sweet_pepper_ip_in( 'na', $ip ) ? 'yes' : 'no',
        sweet_pepper_show_instagram() ? 'yes' : 'no',
        sweet_pepper_maps_open() ? 'yes' : 'no'
    );
}, 99 );
