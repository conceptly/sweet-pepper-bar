<?php
/** No remote images, iframe, or request to Google until the visitor chooses. */
$ru = 'ru' === sweet_pepper_lang();
?>
<div class="map-placeholder">
    <p class="map-placeholder__title"><?php echo $ru ? 'Ваш маршрут к Перцам' : 'Your route to Pepper'; ?></p>
    <p><?php echo $ru ? 'Ярославль, ул. Кирова, 10/25' : 'Kirova 10/25, Yaroslavl'; ?></p>
    <p><?php echo $ru ? 'При загрузке карты Google получит IP-адрес и сведения о браузере и может использовать cookies и обрабатывать данные в разных странах. Ваш выбор для карт запомним на 180 дней; изменить его можно внизу сайта.' : 'Loading the map shares your IP address and browser information with Google, which may use cookies and process data in different countries. We remember your map choice for 180 days; change it in the footer.'; ?>
        <a href="https://policies.google.com/privacy?hl=<?php echo $ru ? 'ru' : 'en'; ?>" target="_blank" rel="noopener noreferrer"><?php echo $ru ? 'Политика Google ↗' : 'Google privacy policy ↗'; ?></a>
    </p>
    <?php // The site's components on their dark-ground states (author, 28 Sep 2026): the one boxed action
          // is the Lime button, leaving for Google Maps is a chip (the map bar's), the policy an inline link ?>
    <button type="button" class="btn btn-primary-green" data-map-allow hidden><?php echo $ru ? 'Разрешить и загрузить карту' : 'Allow and load map'; ?></button>
    <a class="contacts-chip map-placeholder__chip" href="https://maps.google.com/?q=Yaroslavl,+Kirova+10/25" target="_blank" rel="noopener noreferrer">
        <span class="chip-label"><?php echo $ru ? 'Открыть Google Карты' : 'Open Google Maps'; ?></span>
        <span class="chip-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
    </a>
</div>
