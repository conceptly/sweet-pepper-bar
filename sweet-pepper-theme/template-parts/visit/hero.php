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
 * @package Sweet_Pepper
 */
?>
<section class="visit-hero">

    <?php // ── Contacts-hero-content: the main flex frame with -52px gap ── ?>
    <div class="visit-hero__frame">

        <?php // ── Header: heroMessage + statesContainer ── ?>
        <div class="visit-hero__header">

            <?php // heroMessage ?>
            <div class="visit-hero__hero-message">
                <div class="visit-hero__title-block">
                    <span class="visit-hero__eyebrow molot-text">proudly local since 2014</span>
                    <h1 class="visit-hero__headline molot-text">Join the party</h1>
                </div>
                <p class="visit-hero__description">
                    Lunch on Kirova, a drink after a walk, or an evening with friends. Check the hours, choose your route and make yourself comfortable.
                </p>
            </div>

            <?php // statesContainer (lime band) — inside header, not separate ?>
            <div class="visit-hero__band" data-visit-band>
                <div class="visit-hero__band-inner">
                    <span class="visit-hero__band-lead molot-text" data-band-lead>Good news!</span>
                    <div class="visit-hero__band-states">
                        <button class="visit-hero__state-pill visit-hero__state-pill--bar" data-bar-state="open" type="button">
                            <span class="visit-hero__state-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/cocktail.svg' ); ?></span>
                            <span class="visit-hero__state-label molot-text" data-bar-label>bar's open</span>
                            <span class="visit-hero__state-dot" data-bar-dot></span>
                        </button>
                        <button class="visit-hero__state-pill visit-hero__state-pill--kitchen" data-kitchen-state="open" type="button">
                            <span class="visit-hero__state-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/food.svg' ); ?></span>
                            <span class="visit-hero__state-label molot-text" data-kitchen-label>kitchen's on</span>
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
                            <span class="visit-hero__state-label molot-text" data-bar-label>bar's open</span>
                            <span class="visit-hero__state-dot" data-bar-dot></span>
                        </span>
                        <span class="visit-hero__rail-item" data-kitchen-state="open">
                            <span class="visit-hero__state-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/food.svg' ); ?></span>
                            <span class="visit-hero__state-label molot-text" data-kitchen-label>kitchen's on</span>
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
                                        <h2 class="visit-hero__hours-title molot-text" data-hours-title>Opening hours</h2>
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
                                        <h2 class="visit-hero__hours-title molot-text">What's on</h2>
                                        <div class="visit-hero__next-event visit-hero__next-event--evergreen">
                                            <div class="visit-hero__event-info">
                                                <span class="visit-hero__event-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/party.svg' ); ?></span>
                                                <div class="visit-hero__event-text">
                                                    <span class="visit-hero__event-name">News, parties and specials — on social.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <?php // CTA — Instagram (EN) / VK (RU) ?>
                            <div class="visit-hero__hours-cta">
                                <?php
                                $is_ru    = ( 'ru' === sweet_pepper_lang() );
                                $cta_url  = $is_ru ? 'https://vk.ru/sweetpepperbar' : 'https://instagram.com/barsweetpepper';
                                ?>
                                <a href="<?php echo esc_url( $cta_url ); ?>" target="_blank" rel="noopener" class="visit-hero__hours-link">
                                    See what's new
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

                        <h2 class="visit-hero__contacts-title molot-text">get in touch</h2>

                        <div class="visit-hero__contacts-list">

                        <?php // Book or Feedback ?>
                        <div class="visit-hero__contacts-section">
                            <h3 class="visit-hero__contacts-heading molot-text">Book or Feedback</h3>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/c-phone.svg',
                                    'contact'         => '+7 (4852) 911-202',
                                    'copy_text'       => '+74852911202',
                                    'supportive_text' => 'can take longer during party hours',
                                ] ); ?>
                                <a href="tel:+74852911202" class="visit-hero__contact-action visit-hero__contact-action--phone-only" aria-label="Call +7 (4852) 911-202">
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                            </div>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/vk.svg',
                                    'contact'         => 'vk.com/sweetpepperbar',
                                    'copy_text'       => 'https://vk.ru/sweetpepperbar',
                                    'supportive_text' => 'fastest reply — usually minutes',
                                ] ); ?>
                                <a href="https://vk.ru/sweetpepperbar" target="_blank" rel="noopener" class="visit-hero__contact-action" aria-label="Message on VK">
                                    <span class="visit-hero__contact-action-label">Message</span>
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                            </div>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/insta.svg',
                                    'contact'         => '@sweetpepperbar',
                                    'copy_text'       => 'https://instagram.com/barsweetpepper',
                                    'supportive_text' => 'DM & latest updates',
                                ] ); ?>
                                <a href="https://instagram.com/barsweetpepper" target="_blank" rel="noopener" class="visit-hero__contact-action" aria-label="DM on Instagram">
                                    <span class="visit-hero__contact-action-label">DM</span>
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                            </div>
                        </div>

                        <?php // Everything Else ?>
                        <div class="visit-hero__contacts-section">
                            <h3 class="visit-hero__contacts-heading molot-text">email</h3>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/c-mail.svg',
                                    'contact'         => 'hello@sweetpepper.bar',
                                    'supportive_text' => 'Feedback, ideas, partnerships.',
                                ] ); ?>
                                <a href="mailto:hello@sweetpepper.bar" class="visit-hero__contact-action visit-hero__contact-action--desktop-only">
                                    <span class="visit-hero__contact-action-label">Write</span>
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-arrow-out.svg' ); ?></span>
                                </a>
                                <button type="button" class="visit-hero__contact-action visit-hero__contact-action--phone-only js-copy" data-copy-text="hello@sweetpepper.bar" data-copied-label="Email address copied" aria-label="Copy email address">
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-copy.svg' ); ?></span>
                                </button>
                            </div>
                        </div>

                        <?php // Find Sweet ?>
                        <div class="visit-hero__contacts-section">
                            <h3 class="visit-hero__contacts-heading molot-text">your way here</h3>
                            <div class="visit-hero__contact-row visit-hero__contact-row--with-action">
                                <?php get_template_part( 'template-parts/components/contact-item', null, [
                                    'icon_svg'        => 'icons/c-pin.svg',
                                    'contact'         => 'Kirova 10/25, Yaroslavl',
                                    'copy_text'       => 'Ярославль, ул. Кирова, 10/25',
                                    'supportive_text' => "On Kirova's pedestrian street.",
                                ] ); ?>
                                <a href="#visit-map" class="visit-hero__contact-action visit-hero__contact-action--desktop-only">
                                    <span class="visit-hero__contact-action-label">Directions</span>
                                    <span class="visit-hero__contact-action-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/arrowDown.svg' ); ?></span>
                                </a>
                                <a href="https://yandex.ru/maps/?rtext=~57.626100%2C39.884500" target="_blank" rel="noopener noreferrer" class="visit-hero__contact-action visit-hero__contact-action--phone-only" aria-label="Route in Yandex Maps">
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
    <?php get_template_part( 'template-parts/components/connector', null, [ 'set' => 'visit', 'word' => 'yourRouteToPepper', 'position' => 'foot', 'alt' => 'Your route to Pepper' ] ); ?>

</section>
