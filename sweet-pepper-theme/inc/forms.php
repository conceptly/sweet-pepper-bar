<?php
/**
 * Forms — the contact form (home, Visit) and the About team form, delivered by email.
 *
 * One REST route, POST /wp-json/sweet-pepper/v1/message, takes both forms and sends a plain
 * text letter to hello@sweetpepper.bar with wp_mail() — no forms plugin (website-brief.md →
 * Plugin cap). The visitor's email is the letter's Reply-To, so «Ответить» in the mailbox
 * writes back to them; a phone-only message carries the number in the body.
 *
 * Spam without a nonce: a nonce baked into a cached page goes stale within a day and would
 * fail real visitors, so the route relies on a honeypot field (`website`), a minimum fill
 * time (the form's render timestamp, `t`) and a per-IP limit. A caught bot is answered
 * "ok" and nothing is sent, so it learns nothing.
 *
 * Settings, all optional, in wp-config.php (each install has its own):
 *   SWEET_PEPPER_FORMS_TO     — recipient; default hello@sweetpepper.bar
 *   SWEET_PEPPER_SMTP_HOST    — when set, mail leaves through this SMTP server instead of the
 *   SWEET_PEPPER_SMTP_PORT      host's sendmail (465 → SSL, otherwise STARTTLS); the letter's
 *   SWEET_PEPPER_SMTP_USER      From is then the SMTP login, which is what lets it pass SPF /
 *   SWEET_PEPPER_SMTP_PASS      DKIM checks at the receiving end.
 *
 * The success screen shows only after the route answers ok; a failure keeps the typed text
 * and shows the delivery error (forms-copy-ru-draft.md §6).
 *
 * Consent (29 Sep 2026, privacy policy §4.2): both forms carry an unticked, required checkbox
 * linking to the consent page, /consent/ (page-privacy.php, seeded from consent-ru-draft.md).
 * The route refuses a message without it, and the letter's last line is the record that it
 * was given — the consent text's version date, the time and the IP (author: the letter is the
 * record; the mailbox keeps letters, the policy states for how long).
 *
 * @package Sweet_Pepper
 */

const SWEET_PEPPER_FORMS_TO_DEFAULT = 'hello@sweetpepper.bar';
const SWEET_PEPPER_FORMS_MIN_SECONDS = 3;  // faster than this from render to send is a script
const SWEET_PEPPER_FORMS_PER_HOUR    = 10; // per IP, both forms together

function sweet_pepper_forms_to() {
    return defined( 'SWEET_PEPPER_FORMS_TO' ) && is_email( SWEET_PEPPER_FORMS_TO )
        ? SWEET_PEPPER_FORMS_TO
        : SWEET_PEPPER_FORMS_TO_DEFAULT;
}

/**
 * The route's URL, for the forms' data-endpoint.
 */
function sweet_pepper_forms_endpoint() {
    return rest_url( 'sweet-pepper/v1/message' );
}

/**
 * The consent page, once it is published: [ url, version date 'd.m.Y' ]; [ '', '' ] before.
 */
function sweet_pepper_consent_page() {
    $page = get_page_by_path( 'consent', OBJECT, 'page' );
    if ( ! $page || 'publish' !== $page->post_status ) {
        return [ '', '' ];
    }
    $ymd = function_exists( 'get_field' ) ? (string) get_field( 'privacy_updated', $page->ID ) : '';
    $ts  = $ymd ? strtotime( $ymd . ' 12:00:00' ) : 0;
    return [ get_permalink( $page ), $ts ? wp_date( 'd.m.Y', $ts ) : '' ];
}

/**
 * The consent page's address, published or not — /consent/, /en/consent/ on English pages. The
 * checkbox and the footer link to it even while it is a draft (author, 29 Sep 2026: to see the
 * link's room and states; a guest gets the 404 page until the owner publishes it).
 */
function sweet_pepper_consent_url() {
    return home_url( '/consent/' );
}

/**
 * The checkbox row, shared by both forms: «Даю согласие на обработку персональных данных»,
 * «согласие» linking to the consent page in a new tab, so the typed message stays.
 *
 * @param string $id      the checkbox id, unique on the page
 * @param string $form_id the form it belongs to — the row sits outside the <form>, in the send block
 */
function sweet_pepper_consent_field( $id, $form_id ) {
    $word = esc_html_x( 'consent', 'the forms consent checkbox, the linked word', 'sweet-pepper' );
    $link = '<a href="' . esc_url( sweet_pepper_consent_url() ) . '" target="_blank" rel="noopener">' . $word . '</a>';
    ?>
    <div class="contact-field contact-consent" data-field="consent">
        <label class="contact-consent__label" for="<?php echo esc_attr( $id ); ?>">
            <input class="contact-consent__input" type="checkbox" id="<?php echo esc_attr( $id ); ?>" form="<?php echo esc_attr( $form_id ); ?>" name="consent" value="1" required>
            <span class="contact-consent__box" aria-hidden="true"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
            <span class="contact-consent__text"><?php
                /* translators: %s: the word "consent", linked to the consent page */
                printf( esc_html__( 'I give my %s to the processing of my personal data', 'sweet-pepper' ), $link ); // $link is escaped above
            ?></span>
        </label>
        <span class="contact-field__error-text"><?php esc_html_e( 'Please tick to agree', 'sweet-pepper' ); ?></span>
    </div>
    <?php
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'sweet-pepper/v1', '/message', [
        'methods'             => 'POST',
        'callback'            => 'sweet_pepper_forms_handle',
        'permission_callback' => '__return_true',
    ] );
} );

/**
 * One line of visitor text: no line breaks (they would split a mail header), trimmed, capped.
 */
function sweet_pepper_forms_line( $value, $max = 100 ) {
    $value = sanitize_text_field( (string) $value );
    return mb_substr( $value, 0, $max );
}

function sweet_pepper_forms_handle( WP_REST_Request $request ) {
    $p = $request->get_json_params() ?: $request->get_body_params();

    // Honeypot and fill time — answer as if sent.
    $rendered = (int) ( $p['t'] ?? 0 );
    if ( ! empty( $p['website'] ) || ( $rendered && time() - (int) ( $rendered / 1000 ) < SWEET_PEPPER_FORMS_MIN_SECONDS ) ) {
        return [ 'ok' => true ];
    }

    $form    = 'team' === ( $p['form'] ?? '' ) ? 'team' : 'contact';
    $name    = sweet_pepper_forms_line( $p['name'] ?? '' );
    $email   = sanitize_email( (string) ( $p['email'] ?? '' ) );
    $phone   = sweet_pepper_forms_line( $p['phone'] ?? '', 40 );
    $message = mb_substr( sanitize_textarea_field( (string) ( $p['message'] ?? '' ) ), 0, 2000 );
    $topic   = sweet_pepper_forms_line( $p['topic'] ?? '' );
    $page    = esc_url_raw( (string) ( $p['page'] ?? '' ) );
    $lang    = 'en' === ( $p['lang'] ?? '' ) ? 'EN' : 'RU';

    // The same rules as the browser's checks (field-state.js); the team form has no phone.
    $has_email = '' !== $email && is_email( $email );
    $has_phone = 'contact' === $form && preg_match_all( '/\d/', $phone ) >= 6;
    if ( '' === $name || '' === trim( $message ) || ! ( $has_email || $has_phone ) || empty( $p['consent'] ) ) {
        return new WP_Error( 'sp_form_invalid', 'Missing or invalid fields.', [ 'status' => 400 ] );
    }

    $ip  = (string) ( $_SERVER['REMOTE_ADDR'] ?? '' );
    $key = 'sp_form_' . md5( $ip );
    $hits = (int) get_transient( $key );
    if ( $hits >= SWEET_PEPPER_FORMS_PER_HOUR ) {
        return new WP_Error( 'sp_form_limit', 'Too many messages.', [ 'status' => 429 ] );
    }
    set_transient( $key, $hits + 1, HOUR_IN_SECONDS );

    // Team form: who the visitor picked. Ids are the chips' data-recipient values.
    $team = [ 'lera' => 'Лера', 'lenya' => 'Лёня', 'iura' => 'Юра', 'anton' => 'Антон' ];
    $to_names = [];
    if ( 'team' === $form ) {
        $picked   = array_intersect( array_keys( $team ), (array) ( $p['recipients'] ?? [] ) );
        $to_names = count( $picked ) && count( $picked ) < count( $team )
            ? array_values( array_intersect_key( $team, array_flip( $picked ) ) )
            : [ 'вся команда' ];
    }

    $subject = 'team' === $form
        ? sprintf( 'Сайт · команде (%s): %s', implode( ', ', $to_names ), $name )
        : sprintf( 'Сайт · %s: %s', '' !== $topic ? $topic : 'сообщение', $name );

    $lines = [
        'Имя: ' . $name,
        $has_email ? 'Почта: ' . $email : null,
        $has_phone ? 'Телефон: ' . $phone : null,
        'team' === $form ? 'Кому: ' . implode( ', ', $to_names ) : null,
        '' !== $topic ? 'Тема: ' . $topic : null,
        '',
        $message,
        '',
        '—',
        'Форма: ' . ( 'team' === $form ? 'команде (О баре)' : 'обратная связь' ) . ', язык страницы ' . $lang,
        '' !== $page ? 'Страница: ' . $page : null,
        $has_email ? 'Ответ на это письмо уйдёт на почту гостя.' : 'Гость оставил только телефон.',
        sweet_pepper_forms_consent_line( $ip ),
    ];
    $body = implode( "\n", array_filter( $lines, fn( $l ) => null !== $l ) );

    $headers = [ 'Content-Type: text/plain; charset=UTF-8' ];
    if ( $has_email ) {
        $headers[] = sprintf( 'Reply-To: %s <%s>', str_replace( [ '"', '<', '>', ',' ], '', $name ), $email );
    }

    if ( ! wp_mail( sweet_pepper_forms_to(), $subject, $body, $headers ) ) {
        return new WP_Error( 'sp_form_send', 'The message could not be sent.', [ 'status' => 500 ] );
    }
    return [ 'ok' => true ];
}

/**
 * The letter's consent record: which text, when, from where.
 */
function sweet_pepper_forms_consent_line( $ip ) {
    [ $url, $version ] = sweet_pepper_consent_page();
    $text = $url
        ? sprintf( 'текст %s%s', $version ? 'от ' . $version . ', ' : '', $url )
        : 'текст согласия ещё не опубликован на сайте';
    return sprintf( 'Согласие на обработку персональных данных: дано %s (МСК) · %s · IP %s',
        wp_date( 'd.m.Y H:i', null, new DateTimeZone( 'Europe/Moscow' ) ), $text, $ip ?: '—' );
}

/**
 * SMTP from wp-config.php, when configured (see the file header).
 */
add_action( 'phpmailer_init', function ( $mailer ) {
    if ( ! defined( 'SWEET_PEPPER_SMTP_HOST' ) || '' === (string) SWEET_PEPPER_SMTP_HOST ) {
        return;
    }
    $port = defined( 'SWEET_PEPPER_SMTP_PORT' ) ? (int) SWEET_PEPPER_SMTP_PORT : 465;
    $user = defined( 'SWEET_PEPPER_SMTP_USER' ) ? (string) SWEET_PEPPER_SMTP_USER : '';

    $mailer->isSMTP();
    $mailer->Host       = SWEET_PEPPER_SMTP_HOST;
    $mailer->Port       = $port;
    $mailer->SMTPSecure = 465 === $port ? 'ssl' : 'tls';
    $mailer->SMTPAuth   = '' !== $user;
    $mailer->Username   = $user;
    $mailer->Password   = defined( 'SWEET_PEPPER_SMTP_PASS' ) ? (string) SWEET_PEPPER_SMTP_PASS : '';
    if ( is_email( $user ) ) {
        $mailer->setFrom( $user, 'Sweet Pepper · сайт', false );
    }
} );
