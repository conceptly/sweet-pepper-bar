<?php
/**
 * Template part for the contact form card.
 *
 * Three states managed via [data-form-state]:
 *   "email"   — default, email contact field shown
 *   "phone"   — phone contact field shown
 *   "success" — confirmation message
 *
 * Figma: FormContactDark (269-3906) / FormContactLight (466-19626)
 *
 * Error text lives in the label row (right-aligned) per Figma,
 * so the form height stays constant regardless of error state.
 */
$subtitle = ! empty( $args['subtitle'] ) ? $args['subtitle'] : "We'll get back to you within 24 hours.";
// Phones on the Visit page (formContact-dark-mobile 1477:76531): "or Send a message" ties the
// form to the booking block above it; the prefix is hidden above 767px.
$title_prefix_mobile = $args['title_prefix_mobile'] ?? '';
// Topic chips (same frame). Rendered only when passed; the caller's CSS decides where they
// show. The set is still open — visit-page-copy.md → We're all ears — mobile.
$topics = $args['topics'] ?? [];
?>
<div class="contact-form" data-form-state="email" id="contact-form">

    <!-- ── Form Body (email + phone states) ── -->
    <div class="contact-form__body">

        <!-- Header -->
        <div class="contact-form__header">
            <h3 class="contact-form__title"><?php if ( $title_prefix_mobile ) : ?><span class="contact-form__title-prefix"><?php echo esc_html( $title_prefix_mobile ); ?></span><?php endif; ?>Send a message</h3>
            <p class="contact-form__subtitle"><?php echo esc_html( $subtitle ); ?></p>
        </div>

        <?php if ( $topics ) : ?>
        <!-- Topic chips — one active, mirrored into a hidden field for the email subject -->
        <div class="contact-form__topics" role="group" aria-label="Topic">
            <?php foreach ( $topics as $i => $topic ) : ?>
            <button type="button" class="contact-form__topic<?php echo 0 === $i ? ' is-active' : ''; ?>" data-topic="<?php echo esc_attr( $topic ); ?>" aria-pressed="<?php echo 0 === $i ? 'true' : 'false'; ?>"><?php echo esc_html( $topic ); ?></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- Fields -->
        <form class="contact-form__fields" id="contact-form-el" novalidate>
            <?php if ( $topics ) : ?>
            <input type="hidden" name="topic" class="js-topic-input" value="<?php echo esc_attr( $topics[0] ); ?>">
            <?php endif; ?>

            <!-- Name -->
            <div class="contact-field" data-field="name">
                <div class="contact-field__label-row">
                    <label class="contact-field__label" for="contact-name">
                        Name<span class="contact-field__asterisk">*</span>
                    </label>
                    <span class="contact-field__error-text">Please enter your name</span>
                </div>
                <div class="contact-field__input-wrap">
                    <input
                        class="contact-field__input"
                        type="text"
                        id="contact-name"
                        name="name"
                        autocomplete="name"
                        required
                    >
                </div>
            </div>

            <!-- Email / Phone toggle group -->
            <div class="contact-toggle-group">

                <!-- Email field -->
                <div class="contact-toggle-group__field contact-field" data-field="email" data-contact-type="email">
                    <div class="contact-field__label-row">
                        <label class="contact-field__label" for="contact-email">
                            Email<span class="contact-field__asterisk">*</span>
                        </label>
                        <span class="contact-field__error-text">Please enter a valid email</span>
                    </div>
                    <div class="contact-field__input-wrap">
                        <span class="contact-field__icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-mail.svg' ); ?></span>
                        <input
                            class="contact-field__input"
                            type="email"
                            id="contact-email"
                            name="email"
                            autocomplete="email"
                            required
                        >
                    </div>
                </div>

                <!-- Phone field (hidden by default) -->
                <div class="contact-toggle-group__field contact-field" data-field="phone" data-contact-type="phone" hidden>
                    <div class="contact-field__label-row">
                        <label class="contact-field__label" for="contact-phone">
                            Phone<span class="contact-field__asterisk">*</span>
                        </label>
                        <span class="contact-field__error-text">Please enter your phone number</span>
                    </div>
                    <div class="contact-field__input-wrap">
                        <span class="contact-field__icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-phone.svg' ); ?></span>
                        <input
                            class="contact-field__input"
                            type="tel"
                            id="contact-phone"
                            name="phone"
                            autocomplete="tel"
                            required
                        >
                    </div>
                </div>

                <!-- Toggle pills -->
                <div class="contact-toggle">
                    <button type="button" class="contact-toggle__pill contact-toggle__pill--active" data-toggle="email">Email</button>
                    <button type="button" class="contact-toggle__pill" data-toggle="phone">Phone</button>
                    <span class="contact-toggle__helper">Please, pick the preferred contact method</span>
                </div>

            </div>

            <!-- Message -->
            <div class="contact-field" data-field="message">
                <div class="contact-field__label-row">
                    <label class="contact-field__label" for="contact-message">
                        Message<span class="contact-field__asterisk">*</span>
                    </label>
                    <span class="contact-field__error-text">Please enter a message</span>
                </div>
                <div class="contact-field__input-wrap contact-field__input-wrap--textarea">
                    <textarea
                        class="contact-field__input"
                        id="contact-message"
                        name="message"
                        maxlength="500"
                        required
                    ></textarea>
                </div>
                <span class="contact-field__counter"><span class="js-char-count">0</span>/500</span>
            </div>

        </form>

        <!-- Submit -->
        <button type="submit" form="contact-form-el" class="btn btn-primary contact-form__submit">Submit</button>

    </div>

    <!-- ── Success State ── -->
    <div class="contact-form__success">

        <!-- Badge -->
        <div class="contact-form__success-badge">
            <span class="success-badge-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-checkmark.svg' ); ?></span>
        </div>

        <!-- Content -->
        <div class="contact-form__success-content">
            <h3 class="contact-form__success-title">Message has been sent!</h3>
            <p class="contact-form__success-body">
                We appreciate you taking the time to write to us. A real human from the bar will read your message and respond directly to your inbox within 24 hours.
            </p>

            <!-- Direct contact email -->
            <div class="contact-form__info-box">
                <p class="contact-form__info-label">Direct contact email</p>
                <?php get_template_part( 'template-parts/components/contact-item', null, [
                    'icon_svg' => 'icons/c-mail.svg',
                    'contact'  => 'hello@sweetpepper.bar',
                ] ); ?>
            </div>

            <!-- Phone -->
            <div class="contact-form__info-box">
                <p class="contact-form__info-label">Need instant assistance? Give us a call!</p>
                <?php get_template_part( 'template-parts/components/contact-item', null, [
                    'icon_svg' => 'icons/c-phone.svg',
                    'contact'  => '+7 (4852) 911-202',
                    'copy_text'=> '+74852911202',
                ] ); ?>
            </div>
        </div>

        <!-- Reset button -->
        <button type="button" class="btn btn-secondary contact-form__reset-btn js-form-reset">
            <span class="btn-icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-mail.svg' ); ?></span>
            Send another message
        </button>

    </div>

</div>
