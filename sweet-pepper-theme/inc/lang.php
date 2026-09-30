<?php
/**
 * Language on the URL — `/` is Russian, `/en/` is English.
 *
 * One document, two languages (website-brief.md → Content editing & languages →
 * Language model): every page exists once, holds both languages in its fields, and
 * PHP prints ONE language per request, chosen by the URL segment. No plugin: what
 * Polylang did by itself is the small jobs in this file —
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
 *   6. The guest's language — the browser's proposes on entry, a tap on the pill is
 *      remembered (localStorage) and wins from then on; a tiny head script.
 *
 * Cache-safe: the language is on the URL, so a page cache holds one copy per language
 * and never serves the wrong one (the language redirect in 6 stays
 * client-side — website-brief.md → Top nav → EN/RU switch).
 *
 * @package Sweet_Pepper
 */

const SWEET_PEPPER_LANGS           = [ 'ru' => 'ru_RU', 'en' => 'en_US' ];
const SWEET_PEPPER_DEFAULT_LANG    = 'ru'; // the unprefixed URL
const SWEET_PEPPER_REWRITE_VERSION = 3; // 3: the `vacancy` type, public at /vacancies/ (inc/cpt.php); 2: `news` stopped being public

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
 * 6. The guest's language, remembered (website-brief.md → Top nav → EN/RU switch): "the
 * system proposes, memory disposes". A tiny inline script, first thing in <head>, so the
 * wrong page never paints:
 *
 *   - a tap on the EN / RU pill is stored (localStorage `sp-lang`) and wins from then on;
 *   - with nothing stored, the browser's languages propose one — Russian or a neighbouring
 *     language where Russian is widely read (be, uk, kk, ky) → RU, anything else → EN;
 *   - if that answer is not the page's language, the twin URL replaces this one.
 *
 * Never on back/forward (the guest went there on purpose, and a redirect would trap the
 * Back button), never for crawlers and headless tools (each URL must stay indexable in its
 * own language — hreflang does that job for them), never in the Customizer. Nothing is
 * stored until the guest taps: a proposal is not a choice.
 *
 * The language nudge (author, 29 Sep 2026) — asked only when the site guessed: on the
 * English page, with no choice stored, on the page where the guest first lands this
 * session (sessionStorage `sp-landed`), and not within 30 days of a × (localStorage
 * `sp-nudge-off`). That is the case the browser can't see — a Russian reader behind an
 * English system. The Russian page never asks: the browser already said Russian. A tap on
 * «Переключить» is a choice like the pill; the × turns down the question, not a language.
 * The answer is a class on <html> (`lang-nudge-on`), set before paint, so the in-flow hero
 * nudge never shifts the page. Markup: sweet_pepper_lang_nudge() below.
 *
 * Cache-safe: both twin URLs are a function of the URL, so the cached page is the same for
 * everyone and the decision is made in the browser.
 */
add_action( 'wp_head', function () {
    if ( is_customize_preview() ) {
        return;
    }
    $twins = [];
    foreach ( array_keys( SWEET_PEPPER_LANGS ) as $code ) {
        $twins[ $code ] = sweet_pepper_lang_url( $code );
    }
    ?>
<script>
(function () {
    var here = <?php echo wp_json_encode( sweet_pepper_lang() ); ?>, twins = <?php echo wp_json_encode( $twins ); ?>, KEY = 'sp-lang';
    function get() { try { return localStorage.getItem(KEY); } catch (e) { return null; } }
    document.addEventListener('click', function (e) {
        var a = e.target.closest && e.target.closest('a.lang-option[hreflang], a.lang-nudge__link[hreflang]');
        if (a) { try { localStorage.setItem(KEY, a.getAttribute('hreflang')); } catch (e2) {} }
    });
    if (/bot|crawl|spider|slurp|yandex|googl|bing|baidu|duckduck|lighthouse|headless|preview/i.test(navigator.userAgent) || navigator.webdriver) return;
    var nav = performance.getEntriesByType && performance.getEntriesByType('navigation')[0];
    if (nav && nav.type === 'back_forward') return;
    var want = get();
    if (!twins[want]) {
        var list = navigator.languages && navigator.languages.length ? navigator.languages : [navigator.language || ''];
        want = 'en';
        for (var i = 0; i < list.length; i++) {
            var l = String(list[i]).toLowerCase().split('-')[0];
            if (/^(ru|be|uk|kk|ky)$/.test(l)) { want = 'ru'; break; }
            if (l === 'en') break;
        }
    }
    if (want !== here && twins[want]) { location.replace(twins[want] + location.hash); return; }
    if (!<?php echo sweet_pepper_lang_nudge_here() ? 'true' : 'false'; ?>) return; // pages without the nudge don't use up the visit's one ask
    var first = false, off = 0;
    try { first = !sessionStorage.getItem('sp-landed'); sessionStorage.setItem('sp-landed', '1'); } catch (e) {}
    try { off = +localStorage.getItem('sp-nudge-off') || 0; } catch (e) {}
    if (first && here === 'en' && !twins[get()] && Date.now() - off > 2592e6) document.documentElement.classList.add('lang-nudge-on');
})();
</script>
    <?php
}, -1 );

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

/**
 * Where the nudge may ask. The rule is "wherever the guest first lands", but for now the
 * home page only (author, 29 Sep 2026: the floating card's spacing on the other pages needs
 * refining before it goes out). Set to true to ask on every page again. Elsewhere nothing
 * prints and the visit's one ask is kept for the home page — a guest landing on /en/about/
 * is asked when they reach /en/.
 */
const SWEET_PEPPER_NUDGE_EVERYWHERE = false;

function sweet_pepper_lang_nudge_here() {
    return SWEET_PEPPER_NUDGE_EVERYWHERE || is_front_page();
}

/**
 * The language nudge — «Удобнее по-русски? Переключить →» and a ×, on the English page only
 * (the rule is in the head script above). Hidden until <html> carries `lang-nudge-on`.
 * Two places: in the home hero's footer on desktop (template-parts/home/hero.php, in flow),
 * and floating under the header's language switch everywhere else (header.php), which the
 * CSS hides on the home page wherever the hero's own is showing — one nudge per page.
 * Behaviour: src/js/lang-nudge.js.
 *
 * @param bool $float The header's floating card, rather than the hero's.
 */
function sweet_pepper_lang_nudge( $float = false ) {
    if ( 'en' !== sweet_pepper_lang() || ! sweet_pepper_lang_nudge_here() ) {
        return;
    }
    ?>
<div class="lang-nudge<?php echo $float ? ' lang-nudge--float' : ''; ?>" data-lang-nudge>
    <a class="lang-nudge__link" href="<?php echo esc_url( sweet_pepper_lang_url( 'ru' ) ); ?>" hreflang="ru" lang="ru">Удобнее по-русски? <strong>Переключить &rarr;</strong></a>
    <button type="button" class="lang-nudge__close" data-lang-nudge-close aria-label="<?php esc_attr_e( 'Close', 'sweet-pepper' ); ?>">&times;</button>
</div>
    <?php
}
