<?php
/**
 * Vacancy page — the body (Soft Peppercorn): the copy beside the contact card.
 *
 * The brief's rule for short copy (website-brief.md → Grid): the text flush-left in
 * 7 of 12 columns, and the leftover columns get a job — the contact card, sticky, so
 * it stays beside the text while the reader scrolls. The card is a full-width band on
 * tablets and sits in the flow on phones (vacancy.css).
 *
 * The description is three fixed lists (duties · requirements · conditions, the shape
 * every hh.ru posting has), each one item per line in the record; an empty list is
 * simply not printed. Structure in code, words in fields.
 *
 * @param array $args vacancy (sweet_pepper_vacancy())
 */

$v = $args['vacancy'];
?>
<section class="vacancy-body">
    <div class="container vacancy-body__grid">

        <div class="vacancy-copy">
            <?php if ( $v['lead'] ) : ?>
                <p class="vacancy-copy__lead"><?php echo esc_html( $v['lead'] ); ?></p>
            <?php endif; ?>

            <?php foreach ( $v['lists'] as $list ) : ?>
                <div class="vacancy-list vacancy-list--<?php echo esc_attr( $list['key'] ); ?>">
                    <h2 class="vacancy-list__title molot-text"><?php echo esc_html( $list['title'] ); ?></h2>
                    <ul class="vacancy-list__items">
                        <?php foreach ( $list['items'] as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <aside class="vacancy-aside">
            <?php get_template_part( 'template-parts/vacancy/contact-card', null, [ 'contact' => $v['contact'], 'hh' => $v['hh'] ] ); ?>
        </aside>

    </div>
</section>
