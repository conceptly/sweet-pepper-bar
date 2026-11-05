/**
 * Bar clock — the venue's time and the venue's hours, not the visitor's.
 *
 * Every state engine (home hero, Visit hero, reserve drawer) asks here, so a guest
 * abroad sees the same door the bar does and "is the bar open" is worked out once.
 *
 * The working-out itself lives in the inline head script (inc/daypart-head.php →
 * window.spBar): it has to run before first paint, it can't import a module, and it is
 * where PHP hands over the hours from Bar Settings (inc/bar-hours.php). This module is
 * the modules' door to it.
 *
 * @package Sweet_Pepper
 */

/**
 * The bar right now, on the bar's clock.
 *
 * @returns {{ day: number, mins: number, open: boolean, opens: number, closed: string }}
 *   day: 0=Sun … 6=Sat · mins: minutes since midnight · opens: the next opening, in
 *   minutes · closed: '' | 'night' | 'morning' | 'sunday' (the home hero's windows)
 */
export function getBarStatus() {
    if (window.spBar) return window.spBar.status();

    // Head script missing — nothing to go on, so don't shut the door on anyone
    const now = new Date();
    return { day: now.getDay(), mins: now.getHours() * 60 + now.getMinutes(), open: true, opens: 510, closed: '' };
}

/**
 * The regular week from Bar Settings, in minutes (see inc/bar-hours.php), or null.
 */
export function getBarHours() {
    return window.spBar ? window.spBar.hours : null;
}

/**
 * Minutes → the brief's clockless numerals: 8:30 · 10 · 12 — never 08:30, never AM/PM
 * (website-brief.md → State model → Status line format).
 */
export function formatBarTime(mins) {
    const h = Math.floor(mins / 60) % 24;
    const m = mins % 60;
    return m ? `${h}:${String(m).padStart(2, '0')}` : `${h}`;
}
