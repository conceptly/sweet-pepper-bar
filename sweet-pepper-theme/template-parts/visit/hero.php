<?php
/**
 * Visit Hero Section
 *
 * Dark section (Peppercorn bg). Structure from Figma:
 *  Contacts-hero-content (flex-col, gap: -52px, h: fill, clip)
 *    header (flex-col, shrink-0, w-full)
 *      heroMessage (flex-row, gap-48, items-end, pb-24, px-80)
 *      statesContainer (lime band, full width)
 *    content (flex-col, h-544, justify-center, px-80)
 *      heroSplit (flex-row, gap-48, items-center)
 *        hoursContainer (w-548)
 *        contactsContainer
 *
 * The -52px gap between header and content pulls the content
 * up so the contacts card visually sits on the lime status band.
 *
 * Fixed composition — no day/night theming.
 *
 * Words come as args from inc/visit-data.php — the Visit page's «Первый экран», «Статус бара»,
 * «Часы и новости» and «Контакты» tabs. The phone, the accounts, the email address and the map
 * link are facts, still typed here until they are confirmed for publishing.
 *
 * @param array $args hero · status · hours · contacts — see page-visit.php.
 *
 * @package Sweet_Pepper
 */

$hero     = $args['hero'];
$status   = $args['status'];
$hours    = $args['hours'];
$contacts = $args['contacts'];
$is_ru    = ( 'ru' === sweet_pepper_lang() );
?>
<section class="visit-hero">

    <?php // ── Contacts-hero-content: the main flex frame with -52px gap ── ?>
    <div class="visit-hero__frame">

        <?php // ── Header: heroMessage + statesContainer ── ?>
        <div class="visit-hero__header">

            <?php // heroMessage ?>
            <div class="visit-hero__hero-message">
                <div class="visit-hero__title-block">
                    <span class="visit-hero__eyebrow molot-text"><?php echo esc_html( $hero['eyebrow'] ); ?></span>
                    <h1 class="visit-hero__headline molot-text"><?php echo esc_html( $hero['headline'] ); ?></h1>
                </div>
                <p class="visit-hero__description">
                    <?php echo esc_html( $hero['description'] ); ?>
                </p>
            </div>

            <?php // statesContainer (lime band) — inside header, not separate ?>
            <?php // data-visit-words: every state's words, for src/js/visit-hero.js ?>
            <div class="visit-hero__band" data-visit-band data-visit-words="<?php echo esc_attr( wp_json_encode( $status ) ); ?>">
                <div class="visit-hero__band-inner">
                    <span class="visit-hero__band-lead molot-text" data-band-lead><?php echo esc_html( $status['lead']['open'] ); ?></span>
                    <div class="visit-hero__band-states">
                        <button class="visit-hero__state-pill visit-hero__state-pill--bar" data-bar-state="open" type="button">
                            <span class="visit-hero__state-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/cocktail.svg' ); ?></span>
                            <span class="visit-hero__state-label molot-text" data-bar-label><?php echo esc_html( $status['bar']['open'] ); ?></span>
                            <span class="visit-hero__state-dot" data-bar-dot></span>
                        </button>
                        <button class="visit-hero__state-pill visit-hero__state-pill--kitchen" data-kitchen-state="open" type="button">
                            <span class="visit-hero__state-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/food.svg' ); ?></span>
                            <span class="visit-hero__state-label molot-text" data-kitchen-label><?php echo esc_html( $status['kitchen']['open'] ); ?></span>
                            <span class="visit-hero__state-dot" data-kitchen-dot></span>
                        </button>
                    </div>
                </div>
            </div>

            <?php // statesContainer-mobile-running (1460:73653) — phones only. The same two states, no
                  // lead word and no pill grounds, tripled so the band can run. visit-page-copy.md →
                  // Status rail: both states visible at rest first, pauses on touch, static under
                  // prefers-reduced-motion. Only the first group is read out. ?>
            <div class="visit-hero__rail" data-visit-rail>
                <div class="visit-hero__rail-track">
                    <?php for ( $i = 0; $i < 3; $i++ ) : ?>
                    <div class="visit-hero__rail-group"<?php echo $i ? ' aria-hidden="true"' : ''; ?>>
                        <span class="visit-hero__rail-item" data-bar-state="open">
                            <span class="visit-hero__state-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/cocktail.svg' ); ?></span>
                            <span class="visit-hero__state-label molot-text" data-bar-label><?php echo esc_html( $status['bar']['open'] ); ?></span>
                            <span class="visit-hero__state-dot" data-bar-dot></span>
                        </span>
                        <span class="visit-hero__rail-item" data-kitchen-state="open">
                            <span class="visit-hero__state-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/food.svg' ); ?></span>
                            <span class="visit-hero__state-label molot-text" data-kitchen-label><?php echo esc_html( $status['kitchen']['open'] ); ?></span>
                            <span class="visit-hero__state-dot" data-kitchen-dot></span>
                        </span>
                    </div>
                    <?php endfor; ?>
                </div>
            </div>

        </div><?php // /.visit-hero__header ?>

        <?php // ── Content: heroSplit with -52px overlap ── ?>
        <div class="visit-hero__content">
            <div class="visit-hero__split">

                <?php // ── Left: Hours card ── ?>
                <div class="visit-hero__hours-wrap">
                    <div class="visit-hero__hours-card-container">
                        <div class="visit-hero__hours-edge-top">
                            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'peppercorn' ] ); ?>
                        </div>
                        <div class="visit-hero__hours-card">

                            <?php // hoursContainer: gap-16, pt-24, px-24 ?>
                            <div class="visit-hero__hours-section">
                                <div class="visit-hero__hours-list-group">

                                    <?php // regularHours ?>
                                    <div class="visit-hero__hours-block">
                                        <h2 class="visit-hero__hours-title molot-text" data-hours-title><?php echo esc_html( $hours['hours_title'] ); ?></h2>
                                        <div class="visit-hero__hours-list">
                                            <?php foreach ( sweet_pepper_bar_hours_rows() as $hours_row ) : // Bar Settings — inc/bar-hours.php ?>
                                            <div class="visit-hero__hours-item">
                                                <span class="visit-hero__hours-day"><?php echo esc_html( $hours_row[0] ); ?></span>
                                                <span class="visit-hero__hours-time"><?php echo esc_html( $hours_row[1] ); ?></span>
                                            </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <?php // Evergreen social slot — the working stand-in for the placeholder
                                          // event (visit-page-copy-en.md → Evergreen social slot). A supplied event
                                          // replaces it with its own title, date and time, and gets the --evergreen
                                          // modifier removed so the time column returns. ?>
                                    <div class="visit-hero__hours-block">
                                        <h2 class="visit-hero__hours-title molot-text"><?php echo esc_html( $hours['social_title'] ); ?></h2>
                                        <div class="visit-hero__next-event visit-hero__next-event--evergreen">
                                            <div class="visit-hero__event-info">
                                                <span class="visit-hero__event-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/party.svg' ); ?></span>
                                                <div class="visit-hero__event-text">
                                                    <span class="visit-hero__event-name"><?php echo esc_html( $hours['social_text'] ); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <?php // CTA — Instagram (EN) / VK (RU) ?>
                            <div class="visit-hero__hours-cta">
                                <?php $cta_url = $is_ru ? 'https://vk.ru/sweetpepperbar' : 'https://instagram.com/barsweetpepper'; ?>
                                <a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="visit-hero__hours-link">
                                    <?php echo esc_html( $hours['social_link'] ); ?>
                                    <span class="visit-hero__hours-link-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-right-outline.svg' ); ?></span>
                                </a>
                            </div>

                        </div>
                        <div class="visit-hero__hours-edge-bottom">
                            <?php get_template_part( 'template-parts/components/rugged-edge', null, [ 'color' => 'parchment' ] ); ?>
                        </div>
                    </div>
                </div>

                <?php // ── Right: Get In Touch card ── ?>
                <div class="visit-hero__contacts-wrap">
                    <div class="visit-hero__contacts-card">

                        <h2 class="visit-hero__contacts-title molot-text"><?php echo esc_html( $contacts['title'] ); ?></h2>

                        <div class="visit-hero__contacts-list">

                        <?php // Book or Feedback ?>
                        <div class="visit-hero__contacts-section">
                            <h3 class="visit-hero__contacts-heading molot-text"><?php echo esc_html( $contacts['book_heading'] ); ?></h3>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/c-phone.svg',
                                    'contact'         => '+7 (4852) 911-202',
                                    'copy_text'       => '+74852911202',
                                    'supportive_text' => $contacts['phone_note'],
                                ] ); ?>
                                <a href="tel:+74852911202" class="visit-hero__contact-action visit-hero__contact-action--phone-only" aria-label="<?php echo esc_attr( sprintf( __( 'Call %s', 'sweet-pepper' ), '+7 (4852) 911-202' ) ); ?>">
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                            </div>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/vk.svg',
                                    'contact'         => 'vk.com/sweetpepperbar',
                                    'copy_text'       => 'https://vk.ru/sweetpepperbar',
                                    'supportive_text' => $contacts['vk_note'],
                                ] ); ?>
                                <a href="https://vk.ru/sweetpepperbar" target="_blank" rel="noopener" class="visit-hero__contact-action" aria-label="<?php esc_attr_e( 'Message on VK', 'sweet-pepper' ); ?>">
                                    <span class="visit-hero__contact-action-label"><?php esc_html_e( 'Message', 'sweet-pepper' ); ?></span>
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                            </div>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/insta.svg',
                                    'contact'         => '@sweetpepperbar',
                                    'copy_text'       => 'https://instagram.com/barsweetpepper',
                                    'supportive_text' => $contacts['ig_note'],
                                ] ); ?>
                                <a href="https://instagram.com/barsweetpepper" target="_blank" rel="noopener" class="visit-hero__contact-action" aria-label="<?php esc_attr_e( 'DM on Instagram', 'sweet-pepper' ); ?>">
                                    <span class="visit-hero__contact-action-label"><?php esc_html_e( 'DM', 'sweet-pepper' ); ?></span>
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                            </div>
                        </div>

                        <?php // Everything Else ?>
                        <div class="visit-hero__contacts-section">
                            <h3 class="visit-hero__contacts-heading molot-text"><?php echo esc_html( $contacts['email_heading'] ); ?></h3>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/c-mail.svg',
                                    'contact'         => 'hello@sweetpepper.bar',
                                    'supportive_text' => $contacts['email_note'],
                                ] ); ?>
                                <a href="mailto:hello@sweetpepper.bar" class="visit-hero__contact-action visit-hero__contact-action--desktop-only">
                                    <span class="visit-hero__contact-action-label"><?php esc_html_e( 'Write', 'sweet-pepper' ); ?></span>
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                                <button type="button" class="visit-hero__contact-action visit-hero__contact-action--phone-only js-copy" data-copy-text="hello@sweetpepper.bar" data-copied-label="<?php esc_attr_e( 'Email address copied', 'sweet-pepper' ); ?>" aria-label="<?php esc_attr_e( 'Copy email address', 'sweet-pepper' ); ?>">
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                                </button>
                            </div>
                        </div>

                        <?php // Find Sweet ?>
                        <div class="visit-hero__contacts-section">
                            <h3 class="visit-hero__contacts-heading molot-text"><?php echo esc_html( $contacts['place_heading'] ); ?></h3>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/c-pin.svg',
                                    'contact'         => $contacts['address'],
                                    'copy_text'       => 'Ярославль, ул. Кирова, 10/25',
                                    'supportive_text' => $contacts['address_note'],
                                ] ); ?>
                                <a href="#visit-map" class="visit-hero__contact-action visit-hero__contact-action--desktop-only">
                                    <span class="visit-hero__contact-action-label"><?php esc_html_e( 'Directions', 'sweet-pepper' ); ?></span>
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/arrowDown.svg' ); ?></span>
                                </a>
                                <a href="https://yandex.ru/maps/?rtext=~57.626100%2C39.884500" target="_blank" rel="noopener noreferrer" class="visit-hero__contact-action visit-hero__contact-action--phone-only" aria-label="<?php esc_attr_e( 'Route in Yandex Maps', 'sweet-pepper' ); ?>">
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                            </div>
                        </div>

                        </div><?php // /.contacts-list ?>

                    </div>
                </div>

            </div><?php // /.visit-hero__split ?>
        </div><?php // /.visit-hero__content ?>

    </div><?php // /.visit-hero__frame ?>

    <?php // Connector at the hero's foot (visit-page 892:31050 — SectionLink 2368:76326): the word
          // names the section below. It replaced the phone-only "Map, city sights & contact form ↓"
          // line (Sep 2026) — two devices announcing the same section, and the word is the one the
          // home and About heroes chose over a tappable line. ?>
    <?php get_template_part( 'template-parts/visit/connector', null, [ 'word' => 'yourRouteToPepper', 'position' => 'foot', 'alt' => 'Your route to Pepper' ] ); ?>

</section>
