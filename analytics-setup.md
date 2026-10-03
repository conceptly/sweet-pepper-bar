# Sweet Pepper — analytics setup

Prepared 2 October 2026. Counter: **113329976**. Main domain: **sweetpepper.bar**.

**Interface status:** accepted by the author as a good starting point. Local working baseline; no deployment or policy publication. Current copy and interaction decisions are in `website-brief.md` → Analytics. The dialog keeps service summaries visible and recording/data details under a closed «Подробнее о данных» disclosure.

## Implementation

- Theme entry: `src/js/analytics.js`, initialized from `src/main.js`.
- Loads `https://mc.yandex.ru/metrika/tag.js?id=113329976` only after an explicit analytics choice. No preload, preconnect or noscript tracking image.
- Init: `ssr`, `webvisor`, `clickmap`, `accurateTrackBounce`, `trackLinks` true; `ecommerce` false; `disableYtm` true. URL and referrer follow the supplied snippet. Never put guest contact details or message contents in page URLs or custom events.
- Exactly `sweetpepper.bar`; localhost, staging and WordPress logged-in pages do not start it. The interface can still be reviewed locally.
- One shared banner (allow both/refuse both) with independent switches under Settings. Both switches default off; Save applies changes, ×/Escape discards them. One footer Privacy settings link. Map placeholders can grant maps alone. The English US/Canada map bypass has been removed. Existing per-service permissions remain independent in all countries/languages. `spAnalyticsPermission` stores version 1, a boolean choice and a 180-day expiry. Old `spNoticeSeen` never grants permission. Blocked browser storage uses a page-only choice.
- Withdrawal calls `ym(113329976, 'destruct')`. Re-enabling a destroyed recorder reloads the page. Withdrawal cannot retract data already transmitted. Existing provider cookies are not automatically erased; clearing them is a separate browser action.
- Script-load callback rechecks permission before initialization; revoking during download prevents initialization. Consent expiry is checked on visibility, pageshow and a bounded timer.
- Existing form inputs/textarea have `ym-disable-keys`; a runtime pass also marks fields before init and added fields. No `ym-record-keys` is allowed by that pass.

## Dashboard — intended settings; verify in the account

**Checked from the author's screenshots, 2 Oct 2026:** sweetpepper.bar only, subdomains off, Moscow time, automatic goals on (taps on the phone / email and form sends are now in the policy's data list), Webvisor on, ecommerce / content analytics / Tag Manager off, custom HTML unchecked — as intended. ~~**Mismatch:** Webvisor → «Записывать все поля» shows on~~ — **switched off by the author, 3 Oct 2026**; the theme's `ym-disable-keys` on every field stays as the second layer. **Seen 3 Oct (author's screenshots):** the one filter keeps only the site and its additional addresses (duplicates «принимать только с указанных адресов», harmless); «Не учитывать мои визиты» off — suggested on while the team tests; robot filtering off (Yandex's default); public access off, no individual users — only the owner's account sees the statistics (policy §5.4 can say so, the contractor bracket goes). Not yet seen: Advanced Matching (Счётчик tab), and that `www.` redirects to the bare domain (the counter accepts only sweetpepper.bar). Policy and consent drafts for the owner: `privacy-analytics-review/`.

- Main domain, Moscow time zone, accept only specified addresses.
- Include subdomains off. Automatic goals on.
- Webvisor on for launch/refinement; review whether it is useful after a month.
- Record all field contents off — **confirmed off by the author, 3 Oct 2026.** Check Advanced Matching is off; the supplied screenshots did not show this setting.
- Ecommerce, content analytics, tag manager off; custom HTML unchecked.

## Verification

Production build and PHP syntax passed. Isolated Chrome tests intercept all website and Yandex requests, using real template markup and built CSS, plus the source analytics/notice scripts. Passed: no pre-consent requests; old dismissed notice still prompts; refusal persists; allow initializes once; cross-tab withdrawal; corrupt/version-mismatched/expired records; local/staging exclusion; revocation during a delayed script load; blocked storage; RU/EN layouts at 360, 768 and 1280 px.

The final shared-dialog checks also passed: both switches initially off; ×/Escape discard unsaved edits; all four permission combinations persist; map-only loading leaves analytics unchanged; prior analytics-only permission does not grant maps; cross-tab map removal and analytics withdrawal.

These tests prove the local consent wrapper, not Yandex's server settings or the fidelity of actual Webvisor recordings. Full local WordPress was unavailable. Nothing deployed, and no test visits sent to Yandex.

## Before deployment

**3 Oct 2026 — handed over for both sites (author):** the main site is for internal use only — excluded from search engines and not announced until the final content changes — so the theme goes there now for testing. On `sweetpepper.bar` Metrica therefore runs for anyone who agrees in the banner (the team); logged-in WordPress users never load it. Before the public launch everything below still applies.

Update/publish the current policy in both languages, removing the retired English US/Canada automatic-map exception: analytics purpose, Yandex as recipient, technical and interaction data, cookies and event retention, explicit optional consent and withdrawal, and Webvisor with field contents masked. The existing policy drafts describe the pre-analytics site; do not publish the theme while that statement remains unchanged. Provider retention and dashboard settings must be checked rather than inferred from the 180-day local consent lifetime.

After deployment, verify receipt using Metrica diagnostics, check a consented test recording contains no form values, and confirm refusal/withdrawal on the actual site. Custom goals (drawer open, phone copy/call, directions, successful form delivery) remain a separate task; automatic form goals are not evidence of successful delivery or a confirmed booking.

## References

- [Initialization options](https://yandex.ru/support/metrica/ru/code/counter-initialize)
- [Field masking](https://yandex.ru/support/metrica/en/webvisor/settings)
- [Stopping a counter](https://yandex.ru/support/metrica/en/code/counter-spa-setup)

This implements the revised Webvisor decision; the 28 September privacy review is historical.
