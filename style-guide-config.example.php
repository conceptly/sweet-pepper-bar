<?php
/**
 * Sweet Pepper style guide — secrets for the in-page edit mode.
 *
 * Copy this file to style-guide-config.php (git ignores that name), fill it in, and upload it by hand next to
 * style-guide-save.php or one folder above the web root. It is never deployed from git.
 *
 * 1. Editor password, as a bcrypt hash. Make it on the Mac (prompts twice, prints one line starting with $2y$):
 *        htpasswd -nBC 10 x | cut -d: -f2
 *
 * 2. GitHub token, so Save commits style-guide.html to the repo and the host's cron deploys it.
 *    github.com → Settings → Developer settings → Fine-grained tokens → Generate:
 *    Repository access: only this repository · Permissions: Contents = Read and write · nothing else.
 *    Leave the token empty to fall back to writing the file locally (only for hosts not deployed from git).
 */

define( 'SP_GUIDE_PASSWORD_HASH', '$2y$10$PASTE-THE-HASH-HERE' );

define( 'SP_GUIDE_GITHUB_TOKEN',  'PASTE-THE-TOKEN-HERE' );
define( 'SP_GUIDE_GITHUB_REPO',   'conceptly/sweet-pepper-bar' );
define( 'SP_GUIDE_GITHUB_BRANCH', 'main' );
define( 'SP_GUIDE_GITHUB_PATH',   'style-guide.html' );
