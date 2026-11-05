<?php
/** No remote images, iframe, or request to Google until the visitor chooses. */
$ru = 'ru' === sweet_pepper_lang();
?>
<div class="map-placeholder">
    <p class="map-placeholder__title"><?php echo $ru ? 'Карта Google отключена.' : 'Google map is disabled.'; ?></p>
    <button type="button" class="btn btn-primary-green" data-map-allow hidden><?php echo $ru ? 'Загрузить карту' : 'Load map'; ?></button>
    <a class="contacts-chip map-placeholder__chip" href="https://maps.google.com/?q=Yaroslavl,+Kirova+10/25" target="_blank" rel="noopener noreferrer">
        <span class="chip-label"><?php echo $ru ? 'Открыть Google Карты' : 'Open Google Maps'; ?></span>
        <span class="chip-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
    </a>
</div>
