<?php
/**
 * Visit data: the closing section around the form — headline, text and the entrance photo.
 * The form itself and the phone booking block are deferred by the draft and stay in the
 * template. Fallback for sweet_pepper_visit_cta() and the seed source.
 *
 *   ru — from visit-page-copy-ru-draft.md → 3. Обратная связь. ПЕРЦАМ in capitals on purpose:
 *        the bar's short name (author, 24 Sep 2026).
 *
 * @package Sweet_Pepper
 */

return [
    'headline' => "we're all ears",
    'body'     => 'Something to share about your visit, an idea or a question? Leave a note for the team.',
    'photo'    => 'sweet-space/door-entrance.jpg',
    'alt'      => 'Sweet Pepper entrance, with the pepper logo on the door',
    'ru'       => [
        'headline' => 'Напишите ПЕРЦАМ!',
        'body'     => 'Хотите рассказать о визите, поделиться идеей или задать вопрос? Оставьте пару слов для команды.',
        'alt'      => 'Вход в Sweet Pepper: дверь с логотипом-перцем',
    ],
];
