<?php
/**
 * Dream Team — "Write to the Team" form modal
 *
 * Composer dialog (centred modal) with two states:
 *   "compose" — form with name chips, three fields, Send CTA
 *   "success" — confirmation message with contact info
 *
 * Reuses the existing .contact-field component for inputs.
 * Modal open/close follows the reserve-drawer pattern.
 *
 * @package Sweet_Pepper
 */
?>

<!-- Scrim overlay -->
<div class="team-form-overlay js-team-form-close"></div>

<!-- Dialog card -->
<div class="team-form-dialog" id="team-form-dialog" data-form-state="compose" aria-modal="true" role="dialog" aria-label="<?php esc_attr_e( 'Write to the team', 'sweet-pepper' ); ?>">

    <!-- Close button -->
    <button class="team-form-dialog__close js-team-form-close" type="button" aria-label="<?php esc_attr_e( 'Close', 'sweet-pepper' ); ?>">
        <i class="ph ph-x"></i>
    </button>

    <!-- ── Compose state ── -->
    <div class="team-form__body">

        <h2 class="team-form__title molot-text"><?php esc_html_e( 'WRITE TO THE TEAM', 'sweet-pepper' ); ?></h2>

        <!-- To: row with name chips -->
        <div class="team-form__to-row">
            <span class="team-form__to-label"><?php esc_html_e( 'To:', 'sweet-pepper' ); ?></span>
            <div class="team-form__chips">
                <button type="button" class="team-form__chip is-active" data-recipient="all">
                    <span><?php esc_html_e( 'All', 'sweet-pepper' ); ?></span>
                    <svg class="team-form__chip-dismiss" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M1 1L7 7M7 1L1 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>
                <?php
                $recipients = [ 'Lera', 'Lenya', 'Iura', 'Anton' ];
                foreach ( $recipients as $name ) : ?>
                    <button type="button" class="team-form__chip" data-recipient="<?php echo esc_attr( strtolower( $name ) ); ?>">
                        <span><?php echo esc_html( $name ); ?></span>
                        <svg class="team-form__chip-dismiss" width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M1 1L7 7M7 1L1 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Form fields -->
        <form class="team-form__fields" id="team-form-el" novalidate>

            <!-- Name -->
            <div class="contact-field" data-field="name">
                <div class="contact-field__label-row">
                    <label class="contact-field__label" for="team-name">
                        <?php esc_html_e( 'Your name', 'sweet-pepper' ); ?><span class="contact-field__asterisk">*</span>
                    </label>
                    <span class="contact-field__error-text"><?php esc_html_e( 'Please enter your name', 'sweet-pepper' ); ?></span>
                </div>
                <div class="contact-field__input-wrap">
                    <input class="contact-field__input" type="text" id="team-name" name="name" autocomplete="name" required>
                </div>
            </div>

            <!-- Email -->
            <div class="contact-field" data-field="email">
                <div class="contact-field__label-row">
                    <label class="contact-field__label" for="team-email">
                        <?php esc_html_e( 'Your Email', 'sweet-pepper' ); ?><span class="contact-field__asterisk">*</span>
                    </label>
                    <span class="contact-field__error-text"><?php esc_html_e( 'Please enter a valid email', 'sweet-pepper' ); ?></span>
                </div>
                <div class="contact-field__input-wrap">
                    <span class="contact-field__icon"><?php echo sweet_pepper_inline_svg( 'assets/icons/c-mail.svg' ); ?></span>
                    <input class="contact-field__input" type="email" id="team-email" name="email" autocomplete="email" required>
                </div>
            </div>

            <!-- Message -->
            <div class="contact-field" data-field="message">
                <div class="contact-field__label-row">
                    <label class="contact-field__label" for="team-message">
                        <?php esc_html_e( 'Message', 'sweet-pepper' ); ?><span class="contact-field__asterisk">*</span>
                    </label>
                    <span class="contact-field__error-text"><?php esc_html_e( 'Please enter a message', 'sweet-pepper' ); ?></span>
                </div>
                <div class="contact-field__input-wrap contact-field__input-wrap--textarea">
                    <textarea class="contact-field__input" id="team-message" name="message" maxlength="500" required></textarea>
                </div>
                <span class="contact-field__counter"><span class="js-team-char-count">0</span>/500</span>
            </div>

        </form>

        <!-- CTA row -->
        <div class="team-form__cta-row">
            <span class="team-form__cta-hint"><?php esc_html_e( 'We answer within a day — faster by DM (VK / Telegram).', 'sweet-pepper' ); ?></span>
            <button type="submit" form="team-form-el" class="btn btn-primary-green team-form__submit">
                <span><?php esc_html_e( 'Send', 'sweet-pepper' ); ?></span>
                <span class="btn-icon btn-icon-right"><?php echo sweet_pepper_inline_svg( 'assets/icons/send.svg' ); ?></span>
            </button>
        </div>

    </div>

    <!-- ── Success state ── -->
    <div class="team-form__success">

        <!-- Badge -->
        <div class="team-form__success-badge">
            <span class="success-badge-icon"><?php echo file_get_contents( get_template_directory() . '/assets/icons/c-checkmark.svg' ); ?></span>
        </div>

        <!-- Content -->
        <div class="team-form__success-content">
            <h2 class="team-form__success-title molot-text"><?php esc_html_e( 'message has been sent!', 'sweet-pepper' ); ?></h2>
            <p class="team-form__success-body">
                <?php esc_html_e( 'We appreciate you taking the time to write to us. A real human from the bar will read your message and respond directly to your inbox within 24 hours.', 'sweet-pepper' ); ?>
            </p>

            <!-- Direct contact email -->
            <div class="team-form__info-box">
                <p class="team-form__info-label molot-text"><?php esc_html_e( 'Direct contact email', 'sweet-pepper' ); ?></p>
                <?php get_template_part( 'template-parts/components/contact-item', null, [
                    'icon_svg' => 'icons/c-mail.svg',
                    'contact'  => 'hello@sweetpepperbar.ru',
                ] ); ?>
            </div>

            <!-- Phone -->
            <div class="team-form__info-box">
                <p class="team-form__info-label molot-text"><?php esc_html_e( 'need instant assistance? give us a call!', 'sweet-pepper' ); ?></p>
                <?php get_template_part( 'template-parts/components/contact-item', null, [
                    'icon_svg' => 'icons/c-phone.svg',
                    'contact'  => '+7 (4852) 911-202',
                    'copy_text'=> '+74852911202',
                ] ); ?>
            </div>
        </div>

        <!-- Reset button -->
        <button type="button" class="btn btn-secondary team-form__reset-btn js-team-form-reset">
            <span class="btn-icon"><?php echo file_get_contents( get_template_directory() . '/assets/icons/c-mail.svg' ); ?></span>
            <?php esc_html_e( 'Send another message', 'sweet-pepper' ); ?>
        </button>

    </div>

</div>
