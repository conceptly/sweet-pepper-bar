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
    if ( '' === $name || '' === trim( $message ) || ! ( $has_email || $has_phone ) ) {
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
