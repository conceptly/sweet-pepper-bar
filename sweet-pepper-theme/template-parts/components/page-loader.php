<?php
/**
 * Page loader — the heat slider as the wait screen (inc/page-loader.php).
 *
 * Figma: page-loader-heat 2729:72296 (night / day × three positions), page frames
 * Page-load-night 2731:72573 / Page-load-day 2731:72838.
 *
 * `--p` (0–1) is the only moving part: the knob's place, the track's lit length and the
 * name's filled share all read it. The knob wears its daypart by `data-stop`
 * (breakfast → lunch → dinner → party, the hero slider's four stops), set by the script.
 *
 * On every page, the same markup for every guest: it arms on a navigation, and the footer's
 * [data-loader-replay] button plays it on the spot.
 *
 * `data-mode` (day | night) is the loader's own, by the hour — see the inline script.
 *
 * The inline script after the markup is the new page's half: when the page before it showed
 * the loader, it opens this one already showing, at the same place, before anything else
 * paints; src/js/page-loader.js then finishes and lifts it. A CSS timeout lifts it anyway if
 * the module never runs.
 *
 * @package Sweet_Pepper
 */

$copy = $args;
// The pool, flat, plus its chains as runs of positions (data/page-loader.php → an array is a chain)
$lines  = [];
$chains = [];
foreach ( $copy['lines'] as $entry ) {
    $start = count( $lines );
    foreach ( (array) $entry as $text ) {
        $lines[] = $text;
    }
    if ( count( $lines ) - $start > 1 ) {
        $chains[] = range( $start, count( $lines ) - 1 );
    }
}
$icon = static function ( $name ) {
    return '<span class="page-loader__icon page-loader__icon--' . esc_attr( $name ) . '">'
        . sweet_pepper_inline_svg( "assets/icons/c-{$name}.svg" ) . '</span>';
};
// The bar's name, the same in both languages: one SVG per word, so they sit in a row on a
// row or in lines, each fitted to the column, and BAR shows only in the looks that carry it
// (page-loader.css → data-name). A word's viewBox is its own cap box —
// Molot at 100: caps 70 high, SWEET 286.7 wide, PEPPER 343.7, BAR 179.1 — and textLength
// holds it to that box whatever font answers.
$word_svgs = static function ( $class ) {
    $out = '';
    foreach ( [ 'sweet' => '286.7', 'pepper' => '343.7', 'bar' => '179.1' ] as $word => $w ) {
        $out .= '<svg class="page-loader__word-svg page-loader__word-svg--' . $word . ' ' . $class . '" viewBox="0 0 ' . $w . ' 70" aria-hidden="true" focusable="false">'
            . '<text x="0" y="70" textLength="' . $w . '" lengthAdjust="spacingAndGlyphs">' . strtoupper( $word ) . '</text></svg>';
    }
    return $out;
};
?>
<div class="page-loader" data-page-loader hidden
     data-lines="<?php echo esc_attr( wp_json_encode( $lines ) ); ?>"
     data-chains="<?php echo esc_attr( wp_json_encode( $chains ) ); ?>"
     data-done="<?php echo esc_attr( $copy['done'] ); ?>">
    <p class="screen-reader-text" role="status"><?php echo esc_html( $copy['status'] ); ?></p>

    <div class="page-loader__stage" aria-hidden="true">
        <div class="page-loader__slider">
            <span class="page-loader__track"></span>
            <span class="page-loader__rest"></span>
            <span class="page-loader__knob" data-stop="breakfast">
                <span class="page-loader__romb">
                    <?php echo $icon( 'coffee' ) . $icon( 'soup' ) . $icon( 'wine' ) . $icon( 'cocktail' ); // one shows per stop ?>
                </span>
            </span>
        </div>
        <div class="page-loader__foot">
            <p class="page-loader__label"><?php echo esc_html( $copy['label'] ); ?></p>
            <p class="page-loader__message">
                <span class="page-loader__fire"><?php echo sweet_pepper_inline_svg( 'assets/icons/fire.svg' ); ?></span>
                <span class="page-loader__line"></span><?php // the script opens each run on a pool line ?>
            </p>
        </div>
    </div>

    <div class="page-loader__word" aria-hidden="true">
        <div class="page-loader__word-lines"><?php echo $word_svgs( 'page-loader__word-svg--outline' ); ?></div>
        <div class="page-loader__word-lines page-loader__word-heat"><?php echo $word_svgs( 'page-loader__word-svg--heat' ); ?></div>
    </div>
</div>
<script>
(function () {
    // Its own day and night, not the page's (author, 30 Sep 2026): Paper from 04:00 until
    // 17:00 on the bar's clock (spBar, inc/daypart-head.php) — the hour the site's home page
    // turns night (dinner) — Peppercorn after, so the loader
    // stays one colour from the page it leaves to the page it opens. `?loader=…&mode=day|night`
    // pins it for this browser tab to review the other one; `&mode=auto` lets go.
    var el = document.querySelector('[data-page-loader]'), pin;
    try {
        pin = new URLSearchParams(location.search).get('mode');
        if (pin === 'auto') sessionStorage.removeItem('spLoaderMode');
        else if (/^(day|night)$/.test(pin)) sessionStorage.setItem('spLoaderMode', pin);
        pin = sessionStorage.getItem('spLoaderMode');
    } catch (e) { pin = null; }
    el.spMode = function () {
        if (pin) return pin;
        var m = window.spBar ? spBar.status().mins : new Date().getHours() * 60;
        return m >= 240 && m < 1020 ? 'day' : 'night';
    };
    el.dataset.mode = el.spMode();

    // TRIAL (1 Oct 2026): the name's look — data-name and data-fill, read by page-loader.css
    // (the table is there). Each screen has its default: phones held upright the poster a
    // word at a time (d), tablets held upright SWEET / PEPPER a word at a time (b), every
    // other screen SWEET PEPPER under the knob (a). `?pick=a…f` shows one look on every screen
    // for this browser tab, `?pick=auto` lets go. Upright, the row with BAR (e, f) is the poster.
    var LOOKS = { a: ['short', 'together'], b: ['short', 'words'], c: ['poster', 'together'], d: ['poster', 'words'], e: ['row', 'together'], f: ['row', 'words'] },
        upright = window.matchMedia('(max-width: 1100px) and (orientation: portrait)'), // the stacked layout
        phone = window.matchMedia('(max-width: 599px)'),
        picked = null;
    try {
        picked = (new URLSearchParams(location.search).get('pick') || '').toLowerCase();
        if (picked === 'auto') sessionStorage.removeItem('spLoaderPick');
        else if (LOOKS[picked]) sessionStorage.setItem('spLoaderPick', picked);
        picked = sessionStorage.getItem('spLoaderPick');
    } catch (e) { picked = null; }
    function look() {
        var l = LOOKS[picked] || LOOKS[!upright.matches ? 'a' : phone.matches ? 'd' : 'b'];
        el.dataset.name = l[0] === 'row' && upright.matches ? 'poster' : l[0];
        el.dataset.fill = l[1];
    }
    look();
    // a turned screen, a resized window
    [upright, phone].forEach(function (m) { m.addEventListener ? m.addEventListener('change', look) : m.addListener(look); });

    // The new page's half: the page before showed the loader → open under it, in place.
    var s;
    try { s = JSON.parse(sessionStorage.getItem('spLoader') || 'null'); } catch (e) { s = null; }
    if (!s || Date.now() - s.at > 20000) return;
    el.hidden = false;
    el.classList.add('is-shown', 'is-carried');
    el.style.setProperty('--p', s.p);
    el.querySelector('.page-loader__knob').dataset.stop = s.stop || 'breakfast';
    // by index, not text: the language switch lands on the same line in the other language
    var line = JSON.parse(el.dataset.lines)[s.line];
    if (line) el.querySelector('.page-loader__line').textContent = line;
    document.documentElement.classList.add('is-page-loading');
})();
</script>
