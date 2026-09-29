<?php
/** Always available independently of the dismissible information notice. */
if ( sweet_pepper_maps_open() ) {
    return; // no choice to change where the maps load without asking (inc/geo.php)
}
$ru = 'ru' === sweet_pepper_lang();
?>
<dialog id="map-preferences" class="map-preferences" aria-labelledby="map-preferences-title">
    <h2 id="map-preferences-title"><?php echo $ru ? 'Настройки карт' : 'Map settings'; ?></h2>
    <p><?php echo $ru ? 'Карты Google помогают найти нас. При их загрузке Google получает IP-адрес и сведения о браузере и может использовать cookies. Google может обрабатывать данные в разных странах. Сам сайт не запрашивает вашу геопозицию.' : 'Google maps help you find us. Loading them shares your IP address and browser information with Google, which may use cookies and process data in different countries. This site does not request your location.'; ?></p>
    <p><a href="https://policies.google.com/privacy?hl=<?php echo $ru ? 'ru' : 'en'; ?>" target="_blank" rel="noopener noreferrer"><?php echo $ru ? 'Политика Google ↗' : 'Google privacy policy ↗'; ?></a></p>
    <p data-map-status data-allowed="<?php echo $ru ? 'Загрузка карт разрешена.' : 'Map loading is allowed.'; ?>" data-blocked="<?php echo $ru ? 'Загрузка карт отключена.' : 'Map loading is disabled.'; ?>" role="status"></p>
    <p><?php echo $ru ? 'Запомним выбор в этом браузере на 180 дней. Отключение убирает встроенные карты и прекращает их загрузку на сайте; уже полученные Google данные оно не удаляет.' : 'We remember your choice in this browser for 180 days. Disabling maps removes the embeds and stops them loading on this site; it does not delete data Google has already received.'; ?></p>
    <div class="map-preferences__actions">
        <button type="button" class="btn btn-secondary" data-map-choice="allow"><?php echo $ru ? 'Разрешить карты' : 'Allow maps'; ?></button>
        <button type="button" class="btn btn-secondary" data-map-choice="block"><?php echo $ru ? 'Отключить карты' : 'Disable maps'; ?></button>
    </div>
    <form method="dialog"><button class="map-settings-link"><?php echo $ru ? 'Закрыть' : 'Close'; ?></button></form>
</dialog>
