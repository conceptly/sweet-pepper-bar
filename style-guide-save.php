<?php
/**
 * Sweet Pepper style guide — save endpoint for the in-page edit mode (style-guide-edit.js).
 *
 * The password is NOT in this file. It lives as a bcrypt hash in style-guide-config.php, which git ignores.
 *
 * Setup (once):
 *   1. On the Mac, make the hash (prompts for the password twice, prints one line starting with $2y$):
 *        htpasswd -nBC 10 x | cut -d: -f2
 *   2. Copy style-guide-config.example.php to style-guide-config.php and paste the hash into it.
 *   3. Upload style-guide.html, style-guide-edit.js, this file and style-guide-config.php to the same folder.
 *      (style-guide-config.php may also sit one folder above the web root — this script looks there too.)
 *   4. The web server user must be able to write style-guide.html and create style-guide-backups/ in that folder.
 *
 * What it does: verifies the password against the hash, checks the file did not change between the editor's
 * re-fetch and this write (Last-Modified; the editor itself verifies every edited block against the current file
 * first), keeps a timestamped copy of the current file in style-guide-backups/ (last SP_GUIDE_KEEP), then writes
 * the new file atomically. The file name is fixed here on purpose — the client never chooses what gets written.
 */

define( 'SP_GUIDE_FILE',    __DIR__ . '/style-guide.html' );
define( 'SP_GUIDE_BACKUPS', __DIR__ . '/style-guide-backups' );
define( 'SP_GUIDE_KEEP',    30 );

header( 'Content-Type: application/json; charset=utf-8' );
header( 'Cache-Control: no-store' );

function sp_out( $code, $data ) {
	http_response_code( $code );
	echo json_encode( $data, JSON_UNESCAPED_UNICODE );
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
	sp_out( 405, array( 'error' => 'POST only' ) );
}

// Password hash: style-guide-config.php next to this script, or one level up (outside the web root).
foreach ( array( __DIR__ . '/style-guide-config.php', dirname( __DIR__ ) . '/style-guide-config.php' ) as $sp_cfg ) {
	if ( is_file( $sp_cfg ) ) {
		require $sp_cfg;
		break;
	}
}
if ( ! defined( 'SP_GUIDE_PASSWORD_HASH' ) || strpos( SP_GUIDE_PASSWORD_HASH, '$2y$' ) !== 0 ) {
	sp_out( 500, array( 'error' => 'style-guide-config.php is missing or has no bcrypt hash — see the setup notes in style-guide-save.php' ) );
}

$in = json_decode( file_get_contents( 'php://input' ), true );
if ( ! is_array( $in ) ) {
	sp_out( 400, array( 'error' => 'Bad request body' ) );
}
if ( ! isset( $in['password'] ) || ! password_verify( (string) $in['password'], SP_GUIDE_PASSWORD_HASH ) ) {
	usleep( 500000 ); // slow down guessing
	sp_out( 401, array( 'error' => 'Wrong password' ) );
}

$html = isset( $in['html'] ) ? $in['html'] : '';
if ( ! is_string( $html ) || strpos( ltrim( $html ), '<!DOCTYPE html>' ) !== 0 || strpos( $html, '</html>' ) === false ) {
	sp_out( 400, array( 'error' => 'Payload is not the guide' ) );
}
if ( ! file_exists( SP_GUIDE_FILE ) ) {
	sp_out( 500, array( 'error' => 'style-guide.html not found next to this script' ) );
}

clearstatcache();
$cur = filesize( SP_GUIDE_FILE );
$new = strlen( $html );
if ( $new < $cur * 0.5 || $new > $cur * 2 ) {
	sp_out( 400, array( 'error' => "Size sanity check failed ($new vs $cur bytes)" ) );
}
if ( ! empty( $in['lastModified'] ) ) {
	$seen = strtotime( $in['lastModified'] );
	if ( $seen && $seen !== filemtime( SP_GUIDE_FILE ) ) {
		sp_out( 409, array( 'error' => 'The file changed on the server since you opened it. Reload the page and redo your edits.' ) );
	}
}
if ( ! is_writable( SP_GUIDE_FILE ) || ! is_writable( __DIR__ ) ) {
	sp_out( 500, array( 'error' => 'The server cannot write style-guide.html — check file permissions' ) );
}

// Backup the current file, keep the last SP_GUIDE_KEEP copies.
$backup = null;
if ( ! is_dir( SP_GUIDE_BACKUPS ) ) {
	@mkdir( SP_GUIDE_BACKUPS, 0755 );
}
if ( is_dir( SP_GUIDE_BACKUPS ) ) {
	$backup = 'style-guide-' . date( 'Ymd-His' ) . '.html';
	if ( ! @copy( SP_GUIDE_FILE, SP_GUIDE_BACKUPS . '/' . $backup ) ) {
		$backup = null;
	}
	$list = glob( SP_GUIDE_BACKUPS . '/style-guide-*.html' );
	sort( $list );
	while ( count( $list ) > SP_GUIDE_KEEP ) {
		@unlink( array_shift( $list ) );
	}
}

// Atomic write: temp file in the same folder, then rename over the original.
$tmp = SP_GUIDE_FILE . '.tmp';
if ( file_put_contents( $tmp, $html ) === false ) {
	sp_out( 500, array( 'error' => 'Write failed' ) );
}
if ( ! rename( $tmp, SP_GUIDE_FILE ) ) {
	@unlink( $tmp );
	sp_out( 500, array( 'error' => 'Could not replace style-guide.html' ) );
}
clearstatcache();

sp_out( 200, array(
	'ok'     => true,
	'bytes'  => $new,
	'backup' => $backup,
) );
