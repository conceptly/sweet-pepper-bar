<?php
/**
 * The bar's contact channels — the values typed into the templates so far (the Visit
 * hero's contact card, the home Contacts section, the footer), gathered in one place.
 *
 * Fallback for sweet_pepper_bar_contacts() while Bar Settings → «Контакты» has never been
 * saved, and the seed source for tools/page-seed.php contacts. The hiring contacts (who
 * answers for a vacancy) are not typed: nobody's phone number belongs in the theme — the
 * team adds people in Bar Settings.
 *
 * @package Sweet_Pepper
 */

return [
    'phone'     => '+7 (4852) 911-202',
    'email'     => 'hello@sweetpepper.bar',
    'telegram'  => '',
    'vk'        => 'https://vk.com/sweetpepperbar',
    // The community's messages — where «Написать» on VK goes (author, 28 Sep 2026)
    'vk_messages' => 'https://vk.ru/im/convo/-64582467?entrypoint=community_page&tab=all',
    'instagram' => 'https://instagram.com/barsweetpepper',
];
