<?php
/**
 * Writes the country IP lists inc/geo.php reads:
 *
 *   sweet-pepper-theme/data/geo-ru.php — Russia (RIPE NCC): Instagram is hidden from Russian IPs
 *   sweet-pepper-theme/data/geo-na.php — the US and Canada (ARIN): the English page loads its
 *                                        Google maps there without asking (29 Sep 2026)
 *
 * Source: each registry's public delegation file (every block it registered, with the
 * holder's country). Free, no account, no attribution owed. Blocks another registry
 * registered for these countries are rare and are not covered.
 *
 * Blocks change slowly; re-run it before a deploy once a month or so and commit the result:
 *
 *     php tools/geo-ranges.php
 *
 * Offline: php tools/geo-ranges.php path/to/delegated-ripencc-extended-latest path/to/delegated-arin-extended-latest
 */

const LISTS = [
    'ru' => [ 'https://ftp.ripe.net/pub/stats/ripencc/delegated-ripencc-extended-latest', [ 'RU' ], "Russia's IP blocks (RIPE NCC delegation file)" ],
    'na' => [ 'https://ftp.arin.net/pub/stats/arin/delegated-arin-extended-latest', [ 'US', 'CA' ], 'US and Canadian IP blocks (ARIN delegation file)' ],
];

$i = 0;
foreach ( LISTS as $name => [ $source, $countries, $label ] ) {
    write_list( $argv[ ++$i ] ?? $source, $countries, $label, dirname( __DIR__ ) . "/sweet-pepper-theme/data/geo-$name.php" );
}

function write_list( $source, array $countries, $label, $out ) {
    $text = file_get_contents( $source );
    if ( false === $text || ! str_contains( $text, '|' . $countries[0] . '|' ) ) {
        fwrite( STDERR, "Could not read the delegation file $source.\n" );
        exit( 1 );
    }

    $v4 = [];
    $v6 = [];
    foreach ( explode( "\n", $text ) as $line ) {
        // registry|cc|type|start|value|date|status|opaque-id
        $f = explode( '|', trim( $line ) );
        if ( count( $f ) < 7 || ! in_array( $f[1], $countries, true ) || ! in_array( $f[6], [ 'allocated', 'assigned' ], true ) ) {
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

    $php  = "<?php\n// $label, for inc/geo.php.\n";
    $php .= '// Written by tools/geo-ranges.php on ' . gmdate( 'j M Y' ) . ' — ' . count( $v4 ) . ' IPv4 and ' . count( $v6 ) . " IPv6 ranges. Do not edit by hand.\n";
    $list = fn( array $values, bool $quote ) => '[' . implode( ',', $quote ? array_map( fn( $v ) => "'$v'", $values ) : $values ) . ']';
    $php .= "return [\n"
          . "'v4_start' => " . $list( array_column( $v4, 0 ), false ) . ",\n"
          . "'v4_end' => " . $list( array_column( $v4, 1 ), false ) . ",\n"
          . "'v6_start' => " . $list( array_column( $v6, 0 ), true ) . ",\n"
          . "'v6_end' => " . $list( array_column( $v6, 1 ), true ) . ",\n"
          . "];\n";
    file_put_contents( $out, $php );
    printf( "%s: %d IPv4 and %d IPv6 ranges, %d KB\n", $out, count( $v4 ), count( $v6 ), filesize( $out ) / 1024 );
}
