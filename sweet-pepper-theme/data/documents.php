<?php
/**
 * The documents hub — the words (/documents/, page-documents.php; inc/documents.php).
 *
 * Built 3 Oct 2026 from option B + C of the contact sheet (author): the short version first —
 * three plain lines, each ending in its document — then a card per legal page, then the
 * privacy settings. The lines retell the owner's reviewed texts in the bar's voice; they are
 * not legal text, and the documents' own titles stay on their pages (the cards carry the short
 * names the footer and the settings dialog use). RU first draft by Claude, EN its twin — the
 * author's pass and the owner's nod on the lines are owed.
 *
 * `show_lines`: the short version is off since 3 Oct 2026 (author: to be made more compact and moved
 * under the cards, worked out in Figma first) — its words stay here; `lead_cards` is the lead
 * while it is off.
 *
 * `headlines`: the legal pages' big headline (page-privacy.php, author 3 Oct 2026 — option B):
 * a short name in Molot over the full legal title, which stays the page's <h1>. Keyed by slug;
 * a page without one shows its full title as the headline, as before.
 *
 * `lines`: icon (assets/icons/) · title · text · the linked document's slug and link words.
 * `cards`: keyed by the legal page's slug, in the order shown; a page that is not published is
 * left out. The version date comes from the page's «Дата редакции» field.
 *
 * @package Sweet_Pepper
 */

return [
    'show_lines' => false,
    'lead_cards' => 'The rules we follow with your data on this site.',
    'eyebrow'  => 'Site & your data',
    'title'    => 'Documents',
    'lead'     => 'First the short version, in plain words. The legally precise texts are below.',
    'lines'    => [
        [ 'icon' => 'mail.svg', 'title' => 'You write to us — we reply, that’s all', 'text' => 'Your name, contact and message from a form go to the team’s mailbox so we can answer. We don’t send advertising.', 'doc' => 'consent', 'link' => 'Forms consent' ],
        [ 'icon' => 'cursor-pepper.svg', 'title' => 'Metrica — only with your permission', 'text' => 'It shows the PEPPERS which pages get read and where the site is awkward. What you type in a form, Metrica doesn’t see.', 'doc' => 'consent-analytics', 'link' => 'Metrica consent' ],
        [ 'icon' => 'pin.svg', 'title' => 'Google Maps — also with your permission', 'text' => 'Until you load the map, the site doesn’t connect to Google.', 'doc' => 'privacy-policy', 'link' => 'Privacy policy' ],
    ],
    'full'     => 'The full texts',
    'cards'    => [
        'privacy-policy'    => [ 'kind' => 'Policy', 'name' => 'Personal data processing policy', 'text' => 'What we collect, why, where it’s kept and how to have it deleted.' ],
        'consent'           => [ 'kind' => 'Consent', 'name' => 'Consent for the website forms', 'text' => 'When you write to us through a form on the site.' ],
        'consent-analytics' => [ 'kind' => 'Consent', 'name' => 'Yandex Metrica consent', 'text' => 'When you allow Yandex Metrica.' ],
    ],
    'headlines' => [ 'privacy-policy' => 'Privacy policy', 'consent' => 'Forms consent', 'consent-analytics' => 'Metrica consent' ],
    'version'  => 'Version of %s',
    'settings' => 'Metrica and Google Maps only work with your permission. Change your choice at any time.',
    'button'   => 'Privacy settings',
    'ru'       => [
        'lead_cards' => 'Правила, по которым мы обращаемся с вашими данными на этом сайте.',
        'eyebrow'  => 'Сайт и данные',
        'title'    => 'Документы',
        'lead'     => 'Сначала коротко, своими словами. Юридически точные тексты — ниже.',
        'lines'    => [
            [ 'icon' => 'mail.svg', 'title' => 'Пишете нам — отвечаем, и всё', 'text' => 'Имя, контакт и текст из формы приходят на почту команды — чтобы ответить. Рекламных рассылок не делаем.', 'doc' => 'consent', 'link' => 'Согласие для форм' ],
            [ 'icon' => 'cursor-pepper.svg', 'title' => 'Метрика — только с вашего разрешения', 'text' => 'Так ПЕРЦЫ видят, какие страницы читают и где на сайте неудобно. Что вы пишете в формах, Метрика не видит.', 'doc' => 'consent-analytics', 'link' => 'Согласие на Метрику' ],
            [ 'icon' => 'pin.svg', 'title' => 'Карта Google — тоже с разрешения', 'text' => 'Пока вы не загрузили карту, сайт не соединяется с Google.', 'doc' => 'privacy-policy', 'link' => 'Политика' ],
        ],
        'full'     => 'Полные тексты',
        'cards'    => [
            'privacy-policy'    => [ 'kind' => 'Политика', 'name' => 'Политика обработки персональных данных', 'text' => 'Что мы собираем, зачем, где храним и как это удалить.' ],
            'consent'           => [ 'kind' => 'Согласие', 'name' => 'Согласие для форм сайта', 'text' => 'Когда вы пишете нам через форму на сайте.' ],
            'consent-analytics' => [ 'kind' => 'Согласие', 'name' => 'Согласие на Яндекс Метрику', 'text' => 'Когда вы разрешаете Яндекс Метрику.' ],
        ],
        'headlines' => [ 'privacy-policy' => 'Политика', 'consent' => 'Согласие для форм', 'consent-analytics' => 'Согласие на Метрику' ],
        'version'  => 'Редакция от %s',
        'settings' => 'Метрика и карты Google работают только с вашего разрешения. Поменять выбор можно в любой момент.',
        'button'   => 'Настройки приватности',
    ],
];
