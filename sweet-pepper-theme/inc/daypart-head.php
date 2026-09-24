<?php
/**
 * Daypart — first-paint theme.
 *
 * daypart-engine.js is a deferred module: on its own, a night page paints in day
 * clothes first and flips when the script runs. This prints a few lines of blocking
 * inline JS at the top of <head> that work out the current daypart and set
 * <html data-now="…"> and, when the page opens at night, <html data-theme="night">
 * before anything paints. Client-side because of the page cache (website-brief.md →
 * PHP stays thin → "The daypart engine is JS, not PHP").
 *
 * The clock is the BAR's (Europe/Moscow), not the visitor's — the same zone as
 * src/js/bar-clock.js, which this inline script can't import. A guest abroad sees
 * the door the bar sees. Falls back to the visitor's clock without Intl time zones.
 *
 * The DAYPART thresholds (12 / 17 / 21, and the 04:00 night → morning switch while
 * closed) are stated HERE AND ONLY HERE. The DOOR hours are not: they come from Bar
 * Settings through inc/bar-hours.php (defaults 08:30 · Sun 10:00 · 02:00), and this
 * script is where PHP hands them to every engine — as window.spBar:
 *
 *   spBar.hours     { open, openSun, close, closeWeekend } — minutes; a close after
 *                   midnight is stored past 24:00 (02:00 → 1560)
 *   spBar.status()  { day, mins, open, opens, closed } on the bar's clock, right now.
 *                   `opens` is today's opening; `closed` is '' | night | morning | sunday
 *
 * src/js/bar-clock.js wraps it for the modules (reserve drawer, Visit hero, home engine),
 * so "is the bar open" is worked out in one place.
 *
 *   last night's close not reached      open — still last night (Fri/Sat nights may run longer)
 *   close → 04:00   CLOSED · night    → parked on party, night theme
 *   04:00 → opening CLOSED · morning  → parked on breakfast, day theme (Sundays: sunday)
 *   opening → 12 breakfast · → 17 lunch · → 21 dinner · → close party
 *
 * Closed sets <html data-closed="night|morning|sunday">; the engine gives the parked
 * tile the closed copy and drops the Now marker (website-brief.md → Desktop — home
 * hero → Closed state).
 *
 * Mirrors the engine's rules exactly, so the engine finds the theme already right:
 *   the bar menu page, /menu/bar/     → night (the bar is always dark; inc/menu-page.php)
 *   ?menu=drinks                      → night (the same, as a switch on any page)
 *   ?theme=night, ?daypart=dinner|party → night
 *   ?daypart=breakfast|lunch          → day
 *   ?closed=night|morning|sunday      → that closed window, at any hour (for checking)
 *   otherwise                         → by the hour, on the home page only
 *
 * @package Sweet_Pepper
 */

function sweet_pepper_daypart_head() {
    $themes_by_hour = is_front_page() ? 'true' : 'false';
    $bar_page       = 'drinks' === sweet_pepper_menu_state() ? 'true' : 'false';
    ?>
<script>
(function (d) {
    var H = <?php echo wp_json_encode( sweet_pepper_bar_hours() ); ?>;
    function status() {
        var t = new Date(), day = t.getDay(), mins = t.getHours() * 60 + t.getMinutes();
        try {
            var p = {};
            new Intl.DateTimeFormat('en-GB', { timeZone: 'Europe/Moscow', weekday: 'short', hour: 'numeric', minute: 'numeric', hour12: false })
                .formatToParts(t).forEach(function (x) { p[x.type] = x.value; });
            var m = (parseInt(p.hour, 10) % 24) * 60 + parseInt(p.minute, 10),
                wd = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].indexOf(p.weekday);
            if (!isNaN(m) && wd > -1) { mins = m; day = wd; }
        } catch (e) {}
        var closes = function (dy) { return dy === 5 || dy === 6 ? H.closeWeekend : H.close; },
            opens = day === 0 ? H.openSun : H.open,
            lastNight = closes((day + 6) % 7) - 1440, // > 0 when last night ran past midnight
            open = mins < lastNight || (mins >= opens && mins < closes(day));
        return {
            // the next opening: today's, or tomorrow's once a night has ended before midnight
            day: day, mins: mins, open: open, opens: !open && mins >= opens ? (day === 6 ? H.openSun : H.open) : opens,
            closed: open ? '' : mins >= opens || mins < 240 ? 'night' : day === 0 ? 'sunday' : 'morning'
        };
    }
    window.spBar = { hours: H, status: status };
    // The language on the URL (inc/lang.php): a script that builds an internal link prefixes it with spLang.root.
    window.spLang = { code: <?php echo wp_json_encode( sweet_pepper_lang() ); ?>, root: <?php echo wp_json_encode( rtrim( (string) parse_url( sweet_pepper_lang_root( sweet_pepper_lang() ), PHP_URL_PATH ), '/' ) ); ?> };

    var s = status(), mins = s.mins,
        q = new URLSearchParams(location.search),
        dp = q.get('daypart'),
        night = /^(dinner|party)$/,
        closed = q.get('closed'),
        now = mins < s.opens ? 'party' : mins < 720 ? 'breakfast' : mins < 1020 ? 'lunch' : mins < 1260 ? 'dinner' : 'party';
    if (!/^(night|morning|sunday)$/.test(closed)) closed = s.closed;
    if (closed) {
        now = closed === 'night' ? 'party' : 'breakfast';
        d.dataset.closed = closed;
    }
    d.dataset.now = now;
    if (<?php echo $bar_page; // phpcs:ignore WordPress.Security.EscapeOutput -- literal true/false ?> || q.get('menu') === 'drinks' || q.get('theme') === 'night' || night.test(dp) ||
        (<?php echo $themes_by_hour; // phpcs:ignore WordPress.Security.EscapeOutput -- literal true/false ?> && !/^(breakfast|lunch)$/.test(dp) && night.test(now))) {
        d.dataset.theme = 'night';
    }
})(document.documentElement);
</script>
    <?php
}
add_action( 'wp_head', 'sweet_pepper_daypart_head', 0 );
