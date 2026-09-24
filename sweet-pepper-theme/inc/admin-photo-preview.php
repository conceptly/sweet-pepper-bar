<?php
/**
 * Admin — photo fields previewed at the ratio the site crops them to (author, 25 Sep 2026:
 * "is it correct that we can't show this ratio in the WordPress admin panel?" — it isn't).
 *
 * WordPress shows a photo field as uploaded; the site never does. On the menu pages, the
 * dish forms and the door tabs the preview takes the site's shape instead, and the two
 * sliders drive it live:
 *
 *   sec_<slug>_photo       + sec_<slug>_photo_y     → the 4:1 band, the photo sliding under it
 *                                                    exactly as reveal.css moves it (--img-y)
 *   sec_<slug>_hero_photo  + sec_<slug>_hero_focus  → the 3:2 hero photo with the tablet's
 *                                                    21:9 window drawn over it (menu-hero.css
 *                                                    keeps 64% of the height; the slider says which)
 *   photo (dish / drink), menu_door_photo, menu_door_night_photo → a 3:2 centre crop
 *
 * Fields are found by name (SCF prints data-name on every field wrapper), so a regenerated
 * group needs nothing here. Ratios: inc/images.php (sp-4x1, sp-hero, sp-3x2).
 *
 * @package Sweet_Pepper
 */

/**
 * Only where these fields live: the two menu pages, dishes and drinks.
 */
function sweet_pepper_admin_photo_preview_wanted() {
    $screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
    return $screen && 'post' === $screen->base && in_array( $screen->post_type, [ 'page', 'dish', 'drink' ], true );
}

function sweet_pepper_admin_photo_preview_css() {
    if ( ! sweet_pepper_admin_photo_preview_wanted() ) {
        return;
    }
    ?>
<style>
/* A photo field previewed at the site's ratio (inc/admin-photo-preview.php). */
.acf-field-image.sp-preview .image-wrap { position: relative; width: 100%; max-width: 100% !important; overflow: hidden; border-radius: 4px; background: #1e1e1e; }
.acf-field-image.sp-preview .image-wrap img { display: block; width: 100%; height: 100%; max-width: none; object-fit: cover; object-position: 50% var(--sp-y, 50%); }
.acf-field-image.sp-preview--band .image-wrap { aspect-ratio: 4 / 1; }
.acf-field-image.sp-preview--hero .image-wrap,
.acf-field-image.sp-preview--3x2  .image-wrap { aspect-ratio: 3 / 2; }
/* The hero keeps its 3:2 frame; the tablet's 21:9 window is drawn over it and moves with the slider. */
.acf-field-image.sp-preview--hero .image-wrap img { object-position: 50% 50%; }
.acf-field-image.sp-preview--hero .sp-crop-window {
    position: absolute; left: 0; right: 0; height: 64.29%; /* (9/21) ÷ (2/3) */
    top: calc((100% - 64.29%) * var(--sp-y-frac, 0.5));
    box-shadow: 0 0 0 999px rgba(20, 20, 16, 0.55); outline: 2px solid #f5e04a; outline-offset: -2px;
    pointer-events: none; transition: top 120ms ease-out;
}
.acf-field-image.sp-preview--hero .sp-crop-window::after {
    content: "планшет"; position: absolute; left: 8px; bottom: 6px;
    font: 500 11px/1 -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; color: #f5e04a; letter-spacing: .02em;
}
.acf-field-image.sp-preview .image-wrap .acf-actions { z-index: 2; }
.acf-field-image.sp-preview .sp-preview-note { margin: 6px 0 0; color: #646970; font-size: 12px; }
</style>
    <?php
}
add_action( 'acf/input/admin_head', 'sweet_pepper_admin_photo_preview_css' );

function sweet_pepper_admin_photo_preview_js() {
    if ( ! sweet_pepper_admin_photo_preview_wanted() ) {
        return;
    }
    ?>
<script>
(function () {
    // Which preview a photo field gets, by its name; the slider that drives it, if any.
    function kind(name) {
        if (/^sec_.+_hero_photo$/.test(name)) return { cls: 'sp-preview--hero', slider: name.replace(/_hero_photo$/, '_hero_focus'), note: 'На компьютере — весь кадр 3:2; рамка — что останется на планшете (ползунок справа).' };
        if (/^sec_.+_photo$/.test(name))      return { cls: 'sp-preview--band', slider: name.replace(/_photo$/, '_photo_y'),      note: 'Так полоса 4:1 выглядит на сайте; ползунок справа двигает фото в ней.' };
        if (name === 'photo' || name === 'menu_door_photo' || name === 'menu_door_night_photo') return { cls: 'sp-preview--3x2', slider: null, note: 'Так фото обрезается на сайте (3:2, по центру).' };
        return null;
    }
    function apply(photoField, y) {
        var wrap = photoField.querySelector('.image-wrap');
        if (!wrap) return;
        wrap.style.setProperty('--sp-y', y + '%');
        wrap.style.setProperty('--sp-y-frac', (y / 100).toString());
    }
    function setup(photoField) {
        if (photoField.dataset.spPreview) return;
        var k = kind(photoField.dataset.name || '');
        if (!k) return;
        photoField.dataset.spPreview = '1';
        photoField.classList.add('sp-preview', k.cls);
        var wrap = photoField.querySelector('.image-wrap');
        if (wrap && k.cls === 'sp-preview--hero' && !wrap.querySelector('.sp-crop-window')) {
            var win = document.createElement('div'); win.className = 'sp-crop-window'; wrap.appendChild(win);
        }
        var note = document.createElement('p'); note.className = 'sp-preview-note'; note.textContent = k.note;
        (photoField.querySelector('.acf-input') || photoField).appendChild(note);
        if (!k.slider) return;
        // The slider field sits in the same row: found by name within the same parent.
        var sliderField = photoField.parentElement.querySelector('.acf-field[data-name="' + k.slider + '"]');
        if (!sliderField) return;
        var inputs = sliderField.querySelectorAll('input[type="range"], input[type="number"]');
        var read = function () { var v = parseFloat(inputs[0] && inputs[0].value); apply(photoField, isNaN(v) ? 50 : v); };
        inputs.forEach(function (i) { i.addEventListener('input', read); i.addEventListener('change', read); });
        read();
    }
    function scan(root) { (root || document).querySelectorAll('.acf-field-image[data-name]').forEach(setup); }
    if (window.acf && acf.addAction) {
        acf.addAction('ready', function () { scan(); });
        acf.addAction('append', function ($el) { scan($el && $el[0]); });
        // A newly chosen photo re-renders the wrap: the window and the position are restored.
        acf.addAction('ready_field/type=image', function (field) { setup(field.$el[0]); });
        acf.addAction('change', function () { scan(); });
    } else {
        document.addEventListener('DOMContentLoaded', function () { scan(); });
    }
})();
</script>
    <?php
}
add_action( 'acf/input/admin_footer', 'sweet_pepper_admin_photo_preview_js' );
