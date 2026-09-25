<?php
/**
 * Language on the URL — `/` is Russian, `/en/` is English.
 *
 * One document, two languages (website-brief.md → Content editing & languages →
 * Language model): every page exists once, holds both languages in its fields, and
 * PHP prints ONE language per request, chosen by the URL segment. No plugin: what
 * Polylang did by itself is the five small jobs in this file —
 *
 *   1. sweet_pepper_lang() — the one answer to "which language", read from the request
 *      URI (needed before WordPress has parsed the request: the locale is set first).
 *   2. Rewrite rules — every rule WordPress has gets an `en/` twin, so `/en/about/`
 *      resolves to the About page (the same trick Polylang uses). Flushed once per
 *      SWEET_PEPPER_REWRITE_VERSION; bump it when the rules change.
 *   3. The `locale` filter — `.po` strings and <html lang> follow the URL, not the
 *      admin's site language.
 *   4. The `home_url` filter — on an English request every internal link
 *      (`home_url( '/menu' )`, permalinks, canonical) carries `/en/`. Admin, REST,
 *      login and uploads are left alone.
 *   5. Head tags — hreflang for both languages and x-default; the twin URL for the
 *      EN / RU pill (sweet_pepper_lang_url()).
 *
 * Cache-safe: the language is on the URL, so a page cache holds one copy per language
 * and never serves the wrong one (the first-visit `navigator.language` nudge stays
 * client-side — website-brief.md → Top nav → EN/RU switch).
 *
 * @package Sweet_Pepper
 */

const SWEET_PEPPER_LANGS           = [ 'ru' => 'ru_RU', 'en' => 'en_US' ];
const SWEET_PEPPER_DEFAULT_LANG    = 'ru'; // the unprefixed URL
const SWEET_PEPPER_REWRITE_VERSION = 2; // 2: the `news` type stopped being public (inc/cpt.php, VK feed)

/**
 * The request path relative to the site's home path, without the language prefix:
 * `/en/about/` → `/about/`, `/about/` → `/about/`, `/en` → `/`.
 *
 * @return array{0:string, 1:string} [ lang, path ]
 */
function sweet_pepper_request_lang_path() {
    static $result = null;
    if ( null !== $result ) {
        return $result;
    }
    $home = rtrim( (string) parse_url( get_option( 'home' ), PHP_URL_PATH ), '/' );
    $path = (string) parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH );
    if ( '' !== $home && 0 === strpos( $path, $home ) ) {
        $path = substr( $path, strlen( $home ) );
    }
    $path = '/' . ltrim( $path, '/' );

    $lang = SWEET_PEPPER_DEFAULT_LANG;
    foreach ( array_keys( SWEET_PEPPER_LANGS ) as $code ) {
        if ( $code !== SWEET_PEPPER_DEFAULT_LANG && preg_match( '#^/' . $code . '(/|$)#', $path ) ) {
            $lang = $code;
            $path = '/' . ltrim( substr( $path, strlen( $code ) + 1 ), '/' );
            break;
        }
    }
    return $result = [ $lang, $path ];
}

/**
 * Language of the current request: 'ru' | 'en'. Read by sp_field(), the menu rows,
 * every template that prints one language. Outside a request (CLI, cron) it is the
 * default language.
 */
function sweet_pepper_lang() {
    return sweet_pepper_request_lang_path()[0];
}

/**
 * The site root for a language, with no filter in the way: `https://…/` or `https://…/en/`.
 */
function sweet_pepper_lang_root( $lang ) {
    $root = trailingslashit( get_option( 'home' ) );
    return $lang === SWEET_PEPPER_DEFAULT_LANG ? $root : $root . $lang . '/';
}

/**
 * The current page in another language — what the EN / RU pill links to.
 */
function sweet_pepper_lang_url( $lang ) {
    [ , $path ] = sweet_pepper_request_lang_path();
    $query      = (string) parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_QUERY );
    return sweet_pepper_lang_root( $lang ) . ltrim( $path, '/' ) . ( '' !== $query ? "?{$query}" : '' );
}

/**
 * 2. Every rewrite rule gets an `en/` twin in front of it, plus `/en/` itself as the home.
 */
add_filter( 'rewrite_rules_array', function ( $rules ) {
    $twins = [];
    foreach ( SWEET_PEPPER_LANGS as $code => $locale ) {
        if ( $code === SWEET_PEPPER_DEFAULT_LANG ) {
            continue;
        }
        $twins[ "^{$code}/?$" ] = "index.php?sp_lang={$code}";
        foreach ( $rules as $regex => $query ) {
            $twins[ "{$code}/" . ltrim( $regex, '^' ) ] = $query . "&sp_lang={$code}";
        }
    }
    return $twins + $rules;
} );

add_filter( 'query_vars', function ( $vars ) {
    $vars[] = 'sp_lang';
    return $vars;
} );

// `sp_lang` has done its job once the rule matched (the language is read from the URI); it
// leaves the query so `/en/` is the same empty query as `/` — WordPress turns an EMPTY home
// query into the static front page (Settings → Reading, set by tools/page-seed.php home), and
// any other var in it would leave `/en/` on the posts index instead of the home page.
add_filter( 'request', function ( $vars ) {
    unset( $vars['sp_lang'] );
    return $vars;
} );

// The rules live in the database: rebuild them once when this file's version changes
// (a new site, the test site after a sync, a future rule change) — no Permalinks visit.
add_action( 'init', function () {
    if ( (int) get_option( 'sweet_pepper_rewrite_version' ) !== SWEET_PEPPER_REWRITE_VERSION ) {
        flush_rewrite_rules( false );
        update_option( 'sweet_pepper_rewrite_version', SWEET_PEPPER_REWRITE_VERSION );
    }
}, 99 );

/**
 * 3. The front end's locale follows the URL. Admin keeps the site language.
 */
add_filter( 'locale', function ( $locale ) {
    if ( is_admin() || wp_doing_ajax() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
        return $locale;
    }
    return SWEET_PEPPER_LANGS[ sweet_pepper_lang() ];
} );

// WordPress loaded its OWN strings — the month and weekday names a date prints through
// get_the_date() / date_i18n() — for the site language, long before functions.php could say
// which language the request is in (wp-settings.php loads the default text domain first).
// Reload them for the request's locale and rebuild WP_Locale, which copied the names at load;
// otherwise a Russian page prints «17 Sep» (the VK cards, 25 Sep 2026).
add_action( 'after_setup_theme', function () {
    if ( is_admin() || wp_doing_ajax() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
        return;
    }
    $wanted = SWEET_PEPPER_LANGS[ sweet_pepper_lang() ];
    $loaded = get_option( 'WPLANG' ) ?: 'en_US';
    if ( $wanted === $loaded ) {
        return;
    }
    unload_textdomain( 'default' );
    load_default_textdomain( $wanted );
    $GLOBALS['wp_locale'] = new WP_Locale();
}, 0 );

/**
 * 4. Internal links carry the language: `home_url( '/menu' )` → `/en/menu` on `/en/…`.
 * Not in admin, and never for the parts of WordPress that are not pages.
 */
add_filter( 'home_url', function ( $url, $path ) {
    $lang = sweet_pepper_lang();
    if ( $lang === SWEET_PEPPER_DEFAULT_LANG || is_admin() ) {
        return $url;
    }
    if ( preg_match( '#^/?(wp-json|wp-admin|wp-login|wp-content|wp-includes|xmlrpc\.php|\?)#', ltrim( (string) $path, '/' ) ) ) {
        return $url;
    }
    $root = untrailingslashit( get_option( 'home' ) );
    if ( 0 !== strpos( $url, $root ) ) {
        return $url; // another scheme or host — leave it
    }
    $rest = substr( $url, strlen( $root ) );
    if ( preg_match( '#^/' . $lang . '(/|$)#', $rest ) ) {
        return $url; // already prefixed
    }
    return $root . '/' . $lang . ( '' === $rest ? '/' : $rest );
}, 10, 2 );

/**
 * 5. hreflang: the same page in every language, and the default as x-default.
 */
add_action( 'wp_head', function () {
    if ( is_404() ) {
        return;
    }
    foreach ( array_keys( SWEET_PEPPER_LANGS ) as $code ) {
        printf( '<link rel="alternate" hreflang="%s" href="%s">' . "\n", esc_attr( $code ), esc_url( sweet_pepper_lang_url( $code ) ) );
    }
    printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( sweet_pepper_lang_url( SWEET_PEPPER_DEFAULT_LANG ) ) );
}, 2 );

/**
 * The EN / RU pill — both codes always visible, the active one filled (website-brief.md
 * → Top nav → EN/RU switch). Links to the twin URL; the active language is text, not a link.
 *
 * @param string $class Extra class on the switch (the drawer's `lang-switch--green`).
 */
function sweet_pepper_lang_switch( $class = '' ) {
    $current = sweet_pepper_lang();
    $labels  = [ 'ru' => 'РУС', 'en' => 'EN' ];
    echo '<nav class="lang-switch' . ( $class ? ' ' . esc_attr( $class ) : '' ) . '" aria-label="' . esc_attr__( 'Language', 'sweet-pepper' ) . '">';
    foreach ( $labels as $code => $label ) {
        if ( $code === $current ) {
            echo '<span class="lang-option active" lang="' . esc_attr( $code ) . '" aria-current="true">' . esc_html( $label ) . '</span>';
        } else {
            echo '<a class="lang-option" lang="' . esc_attr( $code ) . '" hreflang="' . esc_attr( $code ) . '" href="' . esc_url( sweet_pepper_lang_url( $code ) ) . '">' . esc_html( $label ) . '</a>';
        }
    }
    echo '</nav>';
}
