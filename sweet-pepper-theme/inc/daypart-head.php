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
 * The hour thresholds are stated HERE AND ONLY HERE — the engine reads data-now and
 * no longer computes the hour itself. When hours move to the ACF options page, this
 * is where PHP hands them over.
 *
 * Mirrors the engine's rules exactly, so the engine finds the theme already right:
 *   ?menu=drinks                      → night (the bar state is always dark)
 *   ?theme=night, ?daypart=dinner|party → night
 *   ?daypart=breakfast|lunch          → day
 *   otherwise                         → by the hour, on the home page only
 *
 * @package Sweet_Pepper
 */

function sweet_pepper_daypart_head() {
    $themes_by_hour = is_front_page() ? 'true' : 'false';
    ?>
<script>
(function (d) {
    var h = new Date().getHours(),
        now = h < 12 ? 'breakfast' : h < 17 ? 'lunch' : h < 21 ? 'dinner' : 'party',
        q = new URLSearchParams(location.search),
        dp = q.get('daypart'),
        night = /^(dinner|party)$/;
    d.dataset.now = now;
    if (q.get('menu') === 'drinks' || q.get('theme') === 'night' || night.test(dp) ||
        (<?php echo $themes_by_hour; // phpcs:ignore WordPress.Security.EscapeOutput -- literal true/false ?> && !/^(breakfast|lunch)$/.test(dp) && night.test(now))) {
        d.dataset.theme = 'night';
    }
})(document.documentElement);
</script>
    <?php
}
add_action( 'wp_head', 'sweet_pepper_daypart_head', 0 );
