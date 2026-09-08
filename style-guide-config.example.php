<?php
/**
 * Sweet Pepper style guide — password for the in-page edit mode.
 *
 * Copy this file to style-guide-config.php (git ignores that name) and paste a bcrypt hash below.
 * Make the hash on the Mac — it prompts for the password twice and prints one line starting with $2y$:
 *
 *     htpasswd -nBC 10 x | cut -d: -f2
 *
 * Upload style-guide-config.php next to style-guide-save.php, or one folder above the web root.
 * The plain password is never stored anywhere.
 */

define( 'SP_GUIDE_PASSWORD_HASH', '$2y$10$PASTE-THE-HASH-HERE' );
