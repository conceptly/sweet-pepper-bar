<?php
/**
 * Sweet Pepper style guide — save endpoint for the in-page edit mode (style-guide-edit.js).
 *
 * Two modes, chosen by style-guide-config.php (git-ignored; template: style-guide-config.example.php):
 *   GitHub mode — SP_GUIDE_GITHUB_TOKEN is set: Save commits style-guide.html to the repo through the GitHub API.
 *                 The host's cron then pulls and deploys it (a few minutes). Every edit is a commit; git is the source.
 *   Local mode  — no token: Save writes style-guide.html next to this script and keeps rotating backups.
 *                 Only for hosts that are not deployed from git (a pull would overwrite the edits).
 *
 * The client never sees the token and never chooses the file: repo, branch and path are fixed in the config.
 *
 * Protocol (JSON POST, password in every call):
 *   {action:"fetch", password}            -> {ok, mode, html, sha}      current file + version marker
 *   {action:"save",  password, sha, html} -> {ok, mode, commit|backup}  sha must match what fetch returned
 */

define( 'SP_GUIDE_FILE',    __DIR__ . '/style-guide.html' );
define( 'SP_GUIDE_BACKUPS', __DIR__ . '/style-guide-backups' );
define( 'SP_GUIDE_KEEP',    30 );

header( 'Content-Type: application/json; charset=utf-8' );
header( 'Cache-Control: no-store' );

function sp_out( $code, $data ) {
	http_response_code( $code );
	echo json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
	exit;
}

if ( $_SERVER['REQUEST_METHOD'] !== 'POST' ) {
	sp_out( 405, array( 'error' => 'POST only' ) );
}

// ---- config: next to this script, or one level up (outside the web root)
foreach ( array( __DIR__ . '/style-guide-config.php', dirname( __DIR__ ) . '/style-guide-config.php' ) as $sp_cfg ) {
	if ( is_file( $sp_cfg ) ) {
		require $sp_cfg;
		break;
	}
}
if ( ! defined( 'SP_GUIDE_PASSWORD_HASH' ) || strpos( SP_GUIDE_PASSWORD_HASH, '$2y$' ) !== 0 ) {
	sp_out( 500, array( 'error' => 'style-guide-config.php is missing or has no bcrypt hash — see style-guide-config.example.php' ) );
}
$sp_github = defined( 'SP_GUIDE_GITHUB_TOKEN' ) && SP_GUIDE_GITHUB_TOKEN !== '' && strpos( SP_GUIDE_GITHUB_TOKEN, 'PASTE' ) === false;
if ( $sp_github ) {
	if ( ! defined( 'SP_GUIDE_GITHUB_REPO' ) )   define( 'SP_GUIDE_GITHUB_REPO', 'conceptly/sweet-pepper-bar' );
	if ( ! defined( 'SP_GUIDE_GITHUB_BRANCH' ) ) define( 'SP_GUIDE_GITHUB_BRANCH', 'main' );
	if ( ! defined( 'SP_GUIDE_GITHUB_PATH' ) )   define( 'SP_GUIDE_GITHUB_PATH', 'style-guide.html' );
}
$mode = $sp_github ? 'github' : 'local';

// ---- request + password
$in = json_decode( file_get_contents( 'php://input' ), true );
if ( ! is_array( $in ) ) {
	sp_out( 400, array( 'error' => 'Bad request body' ) );
}
if ( ! isset( $in['password'] ) || ! password_verify( (string) $in['password'], SP_GUIDE_PASSWORD_HASH ) ) {
	usleep( 500000 ); // slow down guessing
	sp_out( 401, array( 'error' => 'Wrong password' ) );
}
$action = isset( $in['action'] ) ? $in['action'] : 'save';

// ---- GitHub helper: returns array( http code, decoded json )
function sp_github( $method, $url, $body = null ) {
	$headers = array(
		'Authorization: Bearer ' . SP_GUIDE_GITHUB_TOKEN,
		'Accept: application/vnd.github+json',
		'X-GitHub-Api-Version: 2022-11-28',
		'User-Agent: sweet-pepper-style-guide',
	);
	$payload = null;
	if ( $body !== null ) {
		$payload   = json_encode( $body );
		$headers[] = 'Content-Type: application/json';
	}
	if ( function_exists( 'curl_init' ) ) {
		$ch = curl_init( $url );
		curl_setopt_array( $ch, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_CUSTOMREQUEST  => $method,
			CURLOPT_HTTPHEADER     => $headers,
			CURLOPT_TIMEOUT        => 90,
		) );
		if ( $payload !== null ) {
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
		}
		$res  = curl_exec( $ch );
		$code = (int) curl_getinfo( $ch, CURLINFO_RESPONSE_CODE );
		$err  = curl_error( $ch );
		curl_close( $ch );
		if ( $res === false ) {
			return array( 0, array( 'message' => 'Could not reach api.github.com: ' . $err ) );
		}
	} else {
		$ctx = stream_context_create( array( 'http' => array(
			'method'        => $method,
			'header'        => implode( "\r\n", $headers ),
			'content'       => $payload === null ? '' : $payload,
			'ignore_errors' => true,
			'timeout'       => 90,
		) ) );
		$res  = @file_get_contents( $url, false, $ctx );
		$code = 0;
		if ( isset( $http_response_header[0] ) && preg_match( '/\s(\d{3})\s/', $http_response_header[0], $m ) ) {
			$code = (int) $m[1];
		}
		if ( $res === false ) {
			return array( 0, array( 'message' => 'Could not reach api.github.com (no curl, and the https stream failed)' ) );
		}
	}
	$j = json_decode( $res, true );
	return array( $code, is_array( $j ) ? $j : array( 'message' => substr( (string) $res, 0, 200 ) ) );
}
function sp_github_error( $code, $j, $what ) {
	$msg = isset( $j['message'] ) ? $j['message'] : ( 'HTTP ' . $code );
	sp_out( 502, array( 'error' => "GitHub $what failed: $msg" ) );
}
$sp_api      = 'https://api.github.com/repos/' . SP_GUIDE_GITHUB_REPO;
$sp_contents = $sp_api . '/contents/' . implode( '/', array_map( 'rawurlencode', explode( '/', SP_GUIDE_GITHUB_PATH ) ) );

// ---- fetch: current file + version marker
if ( $action === 'fetch' ) {
	if ( $mode === 'github' ) {
		// Contents API omits the body above 1 MB, so take the sha from the metadata and the bytes from the blob.
		list( $c, $meta ) = sp_github( 'GET', $sp_contents . '?ref=' . rawurlencode( SP_GUIDE_GITHUB_BRANCH ) );
		if ( $c !== 200 || empty( $meta['sha'] ) ) {
			sp_github_error( $c, $meta, 'read' );
		}
		list( $c2, $blob ) = sp_github( 'GET', $sp_api . '/git/blobs/' . $meta['sha'] );
		if ( $c2 !== 200 || ! isset( $blob['content'] ) ) {
			sp_github_error( $c2, $blob, 'blob read' );
		}
		$html = base64_decode( str_replace( "\n", '', $blob['content'] ) );
		sp_out( 200, array( 'ok' => true, 'mode' => 'github', 'html' => $html, 'sha' => $meta['sha'] ) );
	}
	if ( ! is_file( SP_GUIDE_FILE ) ) {
		sp_out( 500, array( 'error' => 'style-guide.html not found next to this script' ) );
	}
	clearstatcache();
	sp_out( 200, array( 'ok' => true, 'mode' => 'local', 'html' => file_get_contents( SP_GUIDE_FILE ), 'sha' => (string) filemtime( SP_GUIDE_FILE ) ) );
}
if ( $action !== 'save' ) {
	sp_out( 400, array( 'error' => 'Unknown action' ) );
}

// ---- save: sanity checks shared by both modes
$html = isset( $in['html'] ) ? $in['html'] : '';
$sha  = isset( $in['sha'] ) ? (string) $in['sha'] : '';
if ( ! is_string( $html ) || strpos( ltrim( $html ), '<!DOCTYPE html>' ) !== 0 || strpos( $html, '</html>' ) === false ) {
	sp_out( 400, array( 'error' => 'Payload is not the guide' ) );
}
if ( $sha === '' ) {
	sp_out( 400, array( 'error' => 'Missing version marker — reload the page and try again' ) );
}
$new = strlen( $html );

if ( $mode === 'github' ) {
	$blocks  = isset( $in['blocks'] ) ? (int) $in['blocks'] : 0;
	$message = 'Style guide: text edited in place' . ( $blocks ? " ($blocks block" . ( $blocks > 1 ? 's' : '' ) . ')' : '' );
	list( $c, $r ) = sp_github( 'PUT', $sp_contents, array(
		'message' => $message,
		'content' => base64_encode( $html ),
		'sha'     => $sha,
		'branch'  => SP_GUIDE_GITHUB_BRANCH,
	) );
	if ( $c === 409 || $c === 422 ) {
		sp_out( 409, array( 'error' => 'The file changed on GitHub since you opened the page — someone else saved first. Reload and redo your edits.' ) );
	}
	if ( $c !== 200 && $c !== 201 ) {
		sp_github_error( $c, $r, 'commit' );
	}
	$commit = isset( $r['commit']['sha'] ) ? substr( $r['commit']['sha'], 0, 7 ) : null;
	sp_out( 200, array( 'ok' => true, 'mode' => 'github', 'bytes' => $new, 'commit' => $commit ) );
}

// ---- local mode: write next to this script
if ( ! is_file( SP_GUIDE_FILE ) ) {
	sp_out( 500, array( 'error' => 'style-guide.html not found next to this script' ) );
}
clearstatcache();
$cur = filesize( SP_GUIDE_FILE );
if ( $new < $cur * 0.5 || $new > $cur * 2 ) {
	sp_out( 400, array( 'error' => "Size sanity check failed ($new vs $cur bytes)" ) );
}
if ( (int) $sha !== filemtime( SP_GUIDE_FILE ) ) {
	sp_out( 409, array( 'error' => 'The file changed on the server since you opened it. Reload the page and redo your edits.' ) );
}
if ( ! is_writable( SP_GUIDE_FILE ) || ! is_writable( __DIR__ ) ) {
	sp_out( 500, array( 'error' => 'The server cannot write style-guide.html — check file permissions' ) );
}
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
$tmp = SP_GUIDE_FILE . '.tmp';
if ( file_put_contents( $tmp, $html ) === false ) {
	sp_out( 500, array( 'error' => 'Write failed' ) );
}
if ( ! rename( $tmp, SP_GUIDE_FILE ) ) {
	@unlink( $tmp );
	sp_out( 500, array( 'error' => 'Could not replace style-guide.html' ) );
}
clearstatcache();
sp_out( 200, array( 'ok' => true, 'mode' => 'local', 'bytes' => $new, 'backup' => $backup ) );
