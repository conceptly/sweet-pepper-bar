<?php
/**
 * Bar hours — the one place the theme learns when the doors open and close.
 *
 * Values come from Bar Settings (SCF options page, acf-json/group_sp_bar_hours.json).
 * Until someone saves that page the fields are empty, so the DEFAULTS below ARE the
 * hours — a field's own default only pre-fills the admin form. A value that is missing
 * or makes no sense falls back to its default rather than shutting the site at lunch.
 *
 * Read by: inc/daypart-head.php (hands the hours to every script as window.spBar),
 * footer.php and template-parts/visit/hero.php (the printed hours).
 *
 * Dated exceptions (holidays) are not built yet — website-brief.md → Bar hours settings.
 * When they are, they slot in behind sweet_pepper_bar_hours(); nothing that reads it
 * should need a second pass.
 *
 * @package Sweet_Pepper
 */

/**
 * "08:30" → minutes since midnight, or null.
 */
function sweet_pepper_time_to_mins( $value ) {
    if ( ! is_string( $value ) || ! preg_match( '/^([01]?\d|2[0-3]):([0-5]\d)/', trim( $value ), $m ) ) {
        return null;
    }
    return (int) $m[1] * 60 + (int) $m[2];
}

/**
 * The regular week, in minutes since midnight.
 *
 * A closing time is the end of the night that STARTED that day, so it is stored past
 * 24:00 when it falls after midnight: 02:00 → 1560.
 *
 * @return array{open:int, openSun:int, close:int, closeWeekend:int}
 */
function sweet_pepper_bar_hours() {
    static $hours = null;
    if ( null !== $hours ) {
        return $hours;
    }

    $defaults = array(
        'open'         => '08:30', // Mon–Sat
        'openSun'      => '10:00', // Sunday — the general cleaning
        'close'        => '02:00', // the nights of Sun–Thu
        'closeWeekend' => '02:00', // the nights of Fri and Sat
    );
    $fields = array(
        'open'         => 'bar_opens',
        'openSun'      => 'bar_opens_sunday',
        'close'        => 'bar_closes',
        'closeWeekend' => 'bar_closes_weekend',
    );

    $hours = array();
    foreach ( $fields as $key => $field ) {
        $mins    = function_exists( 'get_field' ) ? sweet_pepper_time_to_mins( get_field( $field, 'option' ) ) : null;
        $is_open = 'open' === $key || 'openSun' === $key;

        // Doors open between 05:00 and 18:00; a night ends between 22:00 and 07:00.
        // Opening after 04:00 also keeps the hero's 04:00 night → morning switch meaningful.
        $sane = null !== $mins && ( $is_open
            ? ( $mins >= 300 && $mins <= 1080 )
            : ( $mins >= 1320 || $mins <= 420 ) );

        if ( ! $sane ) {
            $mins = sweet_pepper_time_to_mins( $defaults[ $key ] );
        }
        if ( ! $is_open && $mins <= 420 ) {
            $mins += 1440; // after midnight
        }
        $hours[ $key ] = $mins;
    }

    return $hours;
}

/**
 * Minutes → "08:30", the printed-hours format (footer, Visit hours card).
 */
function sweet_pepper_format_hours_time( $mins ) {
    $mins %= 1440;
    return sprintf( '%02d:%02d', intdiv( $mins, 60 ), $mins % 60 );
}

/**
 * The printed week: rows of [ days, "08:30 — 02:00" ]. Friday–Saturday only gets its
 * own row when its night ends at a different time.
 *
 * @return array<int, array{0:string, 1:string}>
 */
function sweet_pepper_bar_hours_rows() {
    $h   = sweet_pepper_bar_hours();
    $row = function ( $open, $close ) {
        return sweet_pepper_format_hours_time( $open ) . ' — ' . sweet_pepper_format_hours_time( $close );
    };

    if ( $h['close'] === $h['closeWeekend'] ) {
        return array(
            array( 'Mon–Sat', $row( $h['open'], $h['close'] ) ),
            array( 'Sunday', $row( $h['openSun'], $h['close'] ) ),
        );
    }

    return array(
        array( 'Mon–Thu', $row( $h['open'], $h['close'] ) ),
        array( 'Fri–Sat', $row( $h['open'], $h['closeWeekend'] ) ),
        array( 'Sunday', $row( $h['openSun'], $h['close'] ) ),
    );
}
