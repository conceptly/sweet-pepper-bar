<?php
/** One settings dialog, two independent permissions; unchecked until explicitly saved.
 * Layout (2 Oct 2026): a scrolling body (title, switches, note, details) over a footer that
 * holds «Сохранить выбор», so Save stays in reach on a phone with the details open. Themed by
 * the site tokens; the fixed dark pages take the night values (privacy.css). */
$ru = 'ru' === sweet_pepper_lang();
$policy_page   = get_page_by_path( 'privacy-policy' );
$policy_url    = $policy_page && 'publish' === $policy_page->post_status ? get_permalink( $policy_page ) : '';
// The separate analytics consent (privacy-analytics-review/consent-analytics-*-draft.md): linked once its page is published
$consent_page  = get_page_by_path( 'consent-analytics' );
$consent_url   = $consent_page && 'publish' === $consent_page->post_status ? get_permalink( $consent_page ) : '';
?>
<dialog id="privacy-preferences" class="privacy-preferences" aria-labelledby="privacy-preferences-title" tabindex="-1">
    <form class="privacy-preferences__form" data-privacy-form>
        <div class="privacy-preferences__body">
            <h2 id="privacy-preferences-title"><?php echo $ru ? 'Настройки приватности' : 'Privacy settings'; ?></h2>
            <div class="privacy-option">
                <label class="privacy-option__label" for="privacy-analytics">
                    <span><?php echo $ru ? 'Яндекс Метрика' : 'Yandex Metrica'; ?></span>
                    <input type="checkbox" role="switch" name="analytics" id="privacy-analytics" aria-describedby="privacy-analytics-description">
                </label>
                <p class="privacy-option__text" id="privacy-analytics-description"><?php echo $ru ? 'Помогает ПЕРЦАМ улучшать сайт: cookies и анализ действий. Содержимое полей форм скрыто.' : 'Helps the PEPPERS improve the site through cookies and interaction analysis. Form field contents are masked.'; ?></p>
            </div>
            <div class="privacy-option">
                <label class="privacy-option__label" for="privacy-maps">
                    <span><?php echo $ru ? 'Карты Google' : 'Google Maps'; ?></span>
                    <input type="checkbox" role="switch" name="maps" id="privacy-maps" aria-describedby="privacy-maps-description">
                </label>
                <?php // U+2011, a non-breaking hyphen: «IP‑адрес» never splits at the line end ?>
                <p class="privacy-option__text" id="privacy-maps-description"><?php echo $ru ? 'Показывают, как добраться. При загрузке Google получает IP‑адрес и сведения о браузере.' : 'Show you how to get here. Loading a map shares your IP address and browser information with Google.'; ?></p>
            </div>
            <p class="privacy-preferences__note"><?php echo $ru ? 'Запомним выбор на 180 дней. Изменить его можно в любой момент — ссылка «Настройки приватности» внизу сайта.' : 'We remember your choice for 180 days. Change it at any time with “Privacy settings” at the foot of the site.'; ?></p>
            <details class="privacy-preferences__details">
                <summary><?php echo $ru ? 'Подробнее о данных' : 'More about your data'; ?></summary>
                <p><?php echo $ru ? 'Вебвизор записывает действия на странице; содержимое полей форм скрыто. Яндекс получает IP‑адрес, сведения о браузере и устройстве, посещённых страницах и переходах. Google может использовать cookies и обрабатывать данные в разных странах. Отключение сервиса прекращает дальнейший сбор, но не удаляет уже переданные ему данные.' : 'Session Replay records on-page actions; form field contents are masked. Yandex receives your IP address, browser and device information, page visits and referral information. Google may use cookies and process data in different countries. Disabling a service stops further collection but does not delete data it has already received.'; ?></p>
                <?php if ( $policy_url || $consent_url ) : ?>
                <p class="privacy-preferences__docs">
                    <?php if ( $policy_url ) : ?><a href="<?php echo esc_url( $policy_url ); ?>"><?php echo $ru ? 'Политика обработки данных' : 'Privacy policy'; ?></a><?php endif; ?>
                    <?php if ( $consent_url ) : ?><a href="<?php echo esc_url( $consent_url ); ?>"><?php echo $ru ? 'Согласие на Яндекс Метрику' : 'Yandex Metrica consent'; ?></a><?php endif; ?>
                </p>
                <?php endif; ?>
            </details>
        </div>
        <div class="privacy-preferences__footer">
            <button type="submit" class="btn btn-primary-green"><?php echo $ru ? 'Сохранить выбор' : 'Save choices'; ?></button>
        </div>
    </form>
    <?php // Last in the markup, top right on screen (as the mail chooser): focus opens on the first switch ?>
    <button type="button" class="privacy-preferences__close" data-privacy-close aria-label="<?php echo $ru ? 'Закрыть' : 'Close'; ?>"><?php echo sweet_pepper_ph( 'x' ); ?></button>
</dialog>
