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
// The default since 3 Oct 2026 (author, after the browser check): on phones a bottom sheet, the
// shorter note and a fade over the scrolling text while more lies below Save — for the dialog's
// height on small phones. `?sheet=0` shows the centred dialog with the longer note, to compare.
$sheet = ! ( isset( $_GET['sheet'] ) && '0' === $_GET['sheet'] );
?>
<dialog id="privacy-preferences" class="privacy-preferences<?php echo $sheet ? ' privacy-preferences--sheet' : ''; ?>" aria-labelledby="privacy-preferences-title" tabindex="-1">
    <form class="privacy-preferences__form" data-privacy-form>
        <div class="privacy-preferences__body">
            <h2 id="privacy-preferences-title"><?php echo $ru ? 'Настройки приватности' : 'Privacy settings'; ?></h2>
            <div class="privacy-option">
                <div class="privacy-option__row">
                    <div class="privacy-option__col">
                        <label class="privacy-option__name" for="privacy-analytics"><?php echo $ru ? 'Яндекс Метрика' : 'Yandex Metrica'; ?></label>
                        <p class="privacy-option__text" id="privacy-analytics-description"><?php echo $ru ? 'Помогает ПЕРЦАМ улучшать сайт: cookies и анализ действий. Содержимое полей форм скрыто.' : 'Helps the PEPPERS improve the site through cookies and interaction analysis. Form field contents are masked.'; ?></p>
                    </div>
                    <input type="checkbox" role="switch" name="analytics" id="privacy-analytics" aria-describedby="privacy-analytics-description">
                </div>
            </div>
            <div class="privacy-option">
                <div class="privacy-option__row">
                    <div class="privacy-option__col">
                        <label class="privacy-option__name" for="privacy-maps"><?php echo $ru ? 'Карты Google' : 'Google Maps'; ?></label>
                        <?php // U+2011, a non-breaking hyphen: «IP‑адрес» never splits at the line end ?>
                        <p class="privacy-option__text" id="privacy-maps-description"><?php echo $ru ? 'Показывают, как добраться. При загрузке Google получает IP‑адрес и сведения о браузере.' : 'Show you how to get here. Loading a map shares your IP address and browser information with Google.'; ?></p>
                    </div>
                    <input type="checkbox" role="switch" name="maps" id="privacy-maps" aria-describedby="privacy-maps-description">
                </div>
            </div>
            <p class="privacy-preferences__note"><?php
                if ( $sheet ) { // the shorter note: 2 lines on a phone, the old one 4 (−45px)
                    echo $ru ? 'Запомним выбор на 180 дней. Изменить его можно внизу сайта.' : 'We remember your choice for 180 days. Change it at the foot of the site.';
                } else {
                    echo $ru ? 'Запомним выбор на 180 дней. Изменить его можно в любой момент — ссылка «Настройки приватности» внизу сайта.' : 'We remember your choice for 180 days. Change it at any time with “Privacy settings” at the foot of the site.';
                } ?></p>
            <details class="privacy-preferences__details">
                <summary><?php echo $ru ? 'Подробнее о данных' : 'More about your data'; ?></summary>
                <p><?php echo $ru ? 'Вебвизор записывает действия на странице; содержимое полей форм скрыто. Яндекс получает IP‑адрес, сведения о браузере и устройстве, посещённых страницах и переходах. Google может использовать cookies и обрабатывать данные в разных странах. Отключение сервиса прекращает дальнейший сбор, но не удаляет уже переданные ему данные.' : 'Session Replay records on-page actions; form field contents are masked. Yandex receives your IP address, browser and device information, page visits and referral information. Google may use cookies and process data in different countries. Disabling a service stops further collection but does not delete data it has already received.'; ?></p>
                <?php if ( $policy_url || $consent_url ) : ?>
                <p class="privacy-preferences__docs">
                    <?php if ( $policy_url ) : ?><a href="<?php echo esc_url( $policy_url ); ?>"><?php echo $ru ? 'Политика конфиденциальности' : 'Privacy policy'; // as the footer and the notice ?></a><?php endif; ?>
                    <?php if ( $consent_url ) : ?><a href="<?php echo esc_url( $consent_url ); ?>"><?php echo $ru ? 'Согласие на Яндекс Метрику' : 'Yandex Metrica consent'; ?></a><?php endif; ?>
                </p>
                <?php endif; ?>
            </details>
        </div>
        <div class="privacy-preferences__footer">
            <button type="submit" class="btn btn-primary-green"><?php echo $ru ? 'Сохранить выбор' : 'Save choices'; ?></button>
        </div>
    </form>
    <?php // Last in the markup, top right on screen: focus opens on the first switch ?>
    <button type="button" class="privacy-preferences__close" data-privacy-close aria-label="<?php echo $ru ? 'Закрыть' : 'Close'; ?>"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-close.svg' ); // Figma Icons «close» (2856:37893), not the thinner Phosphor × ?></button>
</dialog>
