<?php
/**
 * Search and sharing — what a search engine, a link preview and a screen reader's page list
 * learn about a page before anyone reads it (SEO & accessibility pass, 25 Sep 2026).
 *
 *   1. The «Поиск» words: every page's title and description in the request's language. The
 *      home and menu pages had them already (inc/home-data.php, inc/menu-page.php); About and
 *      Visit get the same tab (about_seo_* / visit_seo_*, typed fallback data/<page>/seo.php),
 *      so their tabs stop reading "About" / "Visit" on the Russian site.
 *   2. One meta description printer for every page.
 *   3. Open Graph + Twitter tags: the preview VK, Telegram and WhatsApp draw for a shared link.
 *   4. The bar as schema.org data (home and Visit): name, address, hours, menus, accounts — the
 *      facts the page already prints. The phone and e-mail stay out until they are confirmed
 *      for publishing (inc/visit-data.php); adding one is a line in sweet_pepper_seo_bar_schema().
 *
 * @package Sweet_Pepper
 */

/**
 * 'about' | 'visit' when the request is one of the two pages whose «Поиск» lives here.
 */
function sweet_pepper_seo_page_slug() {
    if ( is_page_template( 'page-about.php' ) ) {
        return 'about';
    }
    if ( is_page_template( 'page-visit.php' ) ) {
        return 'visit';
    }
    return '';
}

/**
 * The request's «Поиск» word in its language: 'title' | 'description'. '' where no page
 * defines one (WordPress's own title stands).
 *
 * @param string $key 'title' | 'description'.
 */
function sweet_pepper_seo_text( $key ) {
    if ( is_front_page() ) {
        $typed = sweet_pepper_home_typed( 'seo' );
        return sp_field( "home_seo_{$key}", sweet_pepper_typed( $typed, $key ), sweet_pepper_home_id() );
    }
    $state = function_exists( 'sweet_pepper_menu_state' ) ? sweet_pepper_menu_state() : '';
    if ( $state ) {
        return sweet_pepper_menu_page_text( $state, 'seo', $key );
    }
    $slug = sweet_pepper_seo_page_slug();
    if ( $slug ) {
        static $typed = [];
        $typed[ $slug ] ??= require get_template_directory() . "/data/{$slug}/seo.php";
        return sp_field( "{$slug}_seo_{$key}", sweet_pepper_typed( $typed[ $slug ], $key ), get_queried_object_id() );
    }
    return '';
}

/**
 * About and Visit: the «Поиск» title stands in for the page's WordPress title (one language).
 */
add_filter( 'document_title_parts', function ( $parts ) {
    if ( sweet_pepper_seo_page_slug() ) {
        $title = sweet_pepper_seo_text( 'title' );
        if ( '' !== $title ) {
            $parts['title'] = $title;
        }
    }
    return $parts;
} );

/**
 * The current page's address in the request's language, without a query string.
 */
function sweet_pepper_seo_url() {
    [ $lang, $path ] = sweet_pepper_request_lang_path();
    return sweet_pepper_lang_root( $lang ) . ltrim( $path, '/' );
}

/**
 * The picture a shared link shows: a photo from the page itself, at its real size.
 *
 * @return array{url:string, width:int, height:int, alt:string}
 */
function sweet_pepper_seo_image() {
    $state = function_exists( 'sweet_pepper_menu_state' ) ? sweet_pepper_menu_state() : '';
    if ( 'food' === $state ) {
        $pick = [ 'food/breakfast/pepper-breakfast-2.jpg', 1080, 720, __( 'Pepper’s Breakfast — fried eggs, a patty, toast and salad', 'sweet-pepper' ) ];
    } elseif ( 'drinks' === $state ) {
        $pick = [ 'bar/infusions/infusions-lenya-11.jpg', 1080, 718, __( 'Cranberry infusion in three shot glasses with berries and mint', 'sweet-pepper' ) ];
    } elseif ( 'about' === sweet_pepper_seo_page_slug() ) {
        $pick = [ 'team/group/2025.jpg', 1080, 720, __( 'The Sweet Pepper team behind the bar, 2025', 'sweet-pepper' ) ];
    } elseif ( is_front_page() ) {
        $pick = [ 'bar/cocktails/shot-drinks.jpg', 1080, 715, __( 'Five layered shots lined up on the lit bar', 'sweet-pepper' ) ];
    } else {
        $pick = [ 'sweet-space/door-entrance.jpg', 1280, 853, __( 'The Sweet Pepper entrance: a glass door with the pepper logo', 'sweet-pepper' ) ];
    }
    return [
        'url'    => get_template_directory_uri() . '/assets/images/' . $pick[0],
        'width'  => $pick[1],
        'height' => $pick[2],
        'alt'    => $pick[3],
    ];
}

/**
 * The description, Open Graph and Twitter tags.
 */
function sweet_pepper_seo_head() {
    if ( is_admin() || is_feed() ) {
        return;
    }
    $description = sweet_pepper_seo_text( 'description' );
    $title       = sweet_pepper_seo_text( 'title' ) ?: wp_get_document_title();
    $lang        = sweet_pepper_lang();
    $image       = sweet_pepper_seo_image();

    if ( '' !== $description ) {
        printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
    }

    $og = [
        'og:type'         => 'website',
        'og:site_name'    => get_bloginfo( 'name', 'display' ),
        'og:title'        => $title,
        'og:description'  => $description,
        'og:url'          => sweet_pepper_seo_url(),
        'og:locale'       => SWEET_PEPPER_LANGS[ $lang ] ?? 'ru_RU',
        'og:image'        => $image['url'],
        'og:image:width'  => (string) $image['width'],
        'og:image:height' => (string) $image['height'],
        'og:image:alt'    => $image['alt'],
    ];
    foreach ( $og as $property => $content ) {
        if ( '' !== $content ) {
            printf( '<meta property="%s" content="%s">' . "\n", esc_attr( $property ), esc_attr( $content ) );
        }
    }
    foreach ( SWEET_PEPPER_LANGS as $code => $locale ) {
        if ( $code !== $lang ) {
            printf( '<meta property="og:locale:alternate" content="%s">' . "\n", esc_attr( $locale ) );
        }
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'sweet_pepper_seo_head', 1 );

/**
 * The bar as schema.org data — a gastrobar is both a bar and a restaurant. Printed on the home
 * page and on Visit, the two pages that carry the address and the hours.
 */
function sweet_pepper_seo_bar_schema() {
    if ( ! is_front_page() && 'visit' !== sweet_pepper_seo_page_slug() ) {
        return;
    }
    $ru    = 'ru' === sweet_pepper_lang();
    $hours = sweet_pepper_bar_hours();
    $time  = 'sweet_pepper_format_hours_time';
    $spec  = function ( $days, $open, $close ) use ( $time ) {
        return [ '@type' => 'OpeningHoursSpecification', 'dayOfWeek' => $days, 'opens' => $time( $open ), 'closes' => $time( $close ) ];
    };
    // A closing time after midnight ends the night that started that day, as the site prints it.
    $week = $hours['close'] === $hours['closeWeekend']
        ? [ $spec( [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ], $hours['open'], $hours['close'] ) ]
        : [
            $spec( [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday' ], $hours['open'], $hours['close'] ),
            $spec( [ 'Friday', 'Saturday' ], $hours['open'], $hours['closeWeekend'] ),
        ];
    $week[] = $spec( [ 'Sunday' ], $hours['openSun'], $hours['close'] );

    $data = [
        '@context'                  => 'https://schema.org',
        '@type'                     => [ 'BarOrPub', 'Restaurant' ],
        '@id'                       => sweet_pepper_lang_root( SWEET_PEPPER_DEFAULT_LANG ) . '#bar',
        'name'                      => 'Sweet Pepper',
        'alternateName'             => 'Sweet Pepper Bar',
        'url'                       => sweet_pepper_lang_root( sweet_pepper_lang() ),
        'image'                     => get_template_directory_uri() . '/assets/images/sweet-space/door-entrance.jpg',
        'logo'                      => get_template_directory_uri() . '/assets/icons/symbol.svg',
        'description'               => sweet_pepper_seo_text( 'description' ),
        'foundingDate'              => '2014',
        'address'                   => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $ru ? 'ул. Кирова, 10/25' : 'Kirova St. 10/25',
            'addressLocality' => $ru ? 'Ярославль' : 'Yaroslavl',
            'addressCountry'  => 'RU',
        ],
        'hasMenu'                   => [ sweet_pepper_menu_url( 'food' ), sweet_pepper_menu_url( 'drinks' ) ],
        'acceptsReservations'       => true,
        'openingHoursSpecification' => $week,
        'sameAs'                    => [ 'https://vk.ru/barsweetpepper', 'https://instagram.com/barsweetpepper' ],
    ];
    echo '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
}
add_action( 'wp_head', 'sweet_pepper_seo_bar_schema', 20 );
