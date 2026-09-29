<?php
/**
 * Writes sweet-pepper-theme/data/geo-ru.php — Russia's IP blocks, for inc/geo.php (Instagram
 * is hidden from Russian IPs on the English page).
 *
 * Source: the RIPE NCC's public delegation file (every block RIPE registered, with the
 * holder's country). Free, no account, no attribution owed. Russian blocks registered by
 * another registry are rare and are not covered.
 *
 * Blocks change slowly; re-run it before a deploy once a month or so and commit the result:
 *
 *     php tools/geo-ru-ranges.php
 *
 * Offline: php tools/geo-ru-ranges.php path/to/delegated-ripencc-extended-latest
 */

const SOURCE = 'https://ftp.ripe.net/pub/stats/ripencc/delegated-ripencc-extended-latest';
$out = dirname( __DIR__ ) . '/sweet-pepper-theme/data/geo-ru.php';

$text = file_get_contents( $argv[1] ?? SOURCE );
if ( false === $text || ! str_contains( $text, '|RU|' ) ) {
    fwrite( STDERR, "Could not read the delegation file.\n" );
    exit( 1 );
}

$v4 = [];
$v6 = [];
foreach ( explode( "\n", $text ) as $line ) {
    // registry|cc|type|start|value|date|status|opaque-id
    $f = explode( '|', trim( $line ) );
    if ( count( $f ) < 7 || 'RU' !== $f[1] || ! in_array( $f[6], [ 'allocated', 'assigned' ], true ) ) {
        continue;
    }
    if ( 'ipv4' === $f[2] ) {
        $start = ip2long( $f[3] );
        $v4[]  = [ $start, $start + (int) $f[4] - 1 ]; // value = number of addresses
    } elseif ( 'ipv6' === $f[2] ) {
        $len  = (int) $f[4]; // value = prefix length
        $mask = str_repeat( "\xff", intdiv( $len, 8 ) ) . ( $len % 8 ? chr( 0xff << ( 8 - $len % 8 ) & 0xff ) : '' );
        $mask = str_pad( $mask, 16, "\0" );
        $net  = inet_pton( $f[3] ) & $mask;
        $v6[] = [ bin2hex( $net ), bin2hex( $net | ~$mask ) ];
    }
}

/**
 * Sort and merge touching or overlapping ranges; $next gives the address after an end. IPv6
 * compares with strcmp: PHP would read an all-digit hex string as a number.
 */
$merge = function ( array $ranges, callable $next, callable $cmp ) {
    usort( $ranges, fn( $a, $b ) => $cmp( $a[0], $b[0] ) );
    $merged = [];
    foreach ( $ranges as $r ) {
        $last = count( $merged ) - 1;
        if ( $last >= 0 && $cmp( $r[0], $next( $merged[ $last ][1] ) ) <= 0 ) {
            if ( $cmp( $r[1], $merged[ $last ][1] ) > 0 ) {
                $merged[ $last ][1] = $r[1];
            }
        } else {
            $merged[] = $r;
        }
    }
    return $merged;
};
$v4 = $merge( $v4, fn( $end ) => $end + 1, fn( $a, $b ) => $a <=> $b );
$v6 = $merge( $v6, function ( $end ) {
    $b = hex2bin( $end ); // + 1, byte by byte from the right
    for ( $i = 15; $i >= 0; $i-- ) {
        $c     = ( ord( $b[ $i ] ) + 1 ) & 0xff;
        $b[ $i ] = chr( $c );
        if ( $c ) {
            return bin2hex( $b );
        }
    }
    return str_repeat( 'f', 32 ); // past the last address
}, 'strcmp' );

$php  = "<?php\n// Russia's IP blocks (RIPE NCC delegation file), for inc/geo.php.\n";
$php .= '// Written by tools/geo-ru-ranges.php on ' . gmdate( 'j M Y' ) . ' — ' . count( $v4 ) . ' IPv4 and ' . count( $v6 ) . " IPv6 ranges. Do not edit by hand.\n";
$list = fn( array $values, bool $quote ) => '[' . implode( ',', $quote ? array_map( fn( $v ) => "'$v'", $values ) : $values ) . ']';
$php .= "return [\n"
      . "'v4_start' => " . $list( array_column( $v4, 0 ), false ) . ",\n"
      . "'v4_end' => " . $list( array_column( $v4, 1 ), false ) . ",\n"
      . "'v6_start' => " . $list( array_column( $v6, 0 ), true ) . ",\n"
      . "'v6_end' => " . $list( array_column( $v6, 1 ), true ) . ",\n"
      . "];\n";
file_put_contents( $out, $php );
printf( "%s: %d IPv4 and %d IPv6 ranges, %d KB\n", $out, count( $v4 ), count( $v6 ), filesize( $out ) / 1024 );
