# Privacy and consent — bilingual drafts and email evidence

29 September 2026. Current files:

- Russian policy: [privacy-policy-ru-draft.markdown](privacy-policy-ru-draft.markdown).
- English policy: [privacy-policy-en-draft.md](privacy-policy-en-draft.md).
- Russian consent: [consent-ru-draft.md](consent-ru-draft.md).
- English consent: [consent-en-draft.md](consent-en-draft.md).

These are review drafts, not a deployment or a declaration that every requirement has been met. The older privacy-policy-ru-draft.md remains an obsolete original. The English texts follow the same numbered provisions and do not add GDPR promises or a different processing arrangement.

## Additional enquiry mailbox — user confirmation

**Correction, later on 29 September 2026 (the author):** p020885@yandex.ru is the **director's** mailbox (Юрий Примышев, in charge of everything); Constantin742@yandex.ru is the **general manager's**, who handles most requests. His address is not published: both policies and both consents now name it by role only («рабочий почтовый ящик генерального менеджера в Яндекс Почте» / "the general manager's work mailbox on Yandex Mail"), and p020885 is described as the director's. The paragraph below predates this.

The user confirmed that Constantin742@yandex.ru also receives copies, sends replies and handles guests’ questions. Added to the receiving/storage descriptions in both policies and both consents. The screenshots establish the collector route for p020885@yandex.ru; the exact collection/forwarding mechanism for Constantin742@yandex.ru was not supplied, so it is not asserted. Existing designated privacy-request contacts and director Юрий Примышев’s responsibility remain unchanged. Deletion must include relevant copies in this additional mailbox. No mail routing or publication settings changed.

## Confirmed email route

The two user-supplied screenshots, `WhatsApp Image 2026-09-29 at 20.44.32.jpeg` and `WhatsApp Image 2026-09-29 at 20.45.00.jpeg`, show SMTP delivery via Timeweb to hello@sweetpepper.bar, followed by Yandex collection. `Received ... with POP3` and `X-Yandex-pop-server: imap.timeweb.ru` identify a collector, rather than merely an email-reading interface. The hostname includes “imap”, but the header explicitly says POP3. The timestamps are 30 September in the message headers; the user's local date is 29 September. No discrepancy needs correction on that basis.

Suggested accurate summary: **«Хостинг сайта, отправка и хранение почты — Timeweb; автоматический сбор, хранение копий и работа с письмами — Яндекс Почта».**

The website sends to hello@sweetpepper.bar; the manager receives collected messages in p020885@yandex.ru. Retention/deletion must cover both mailboxes and other relevant copies. The screenshots do not establish whether Timeweb originals are automatically deleted after collection, physical database/backup locations, contractual processor arrangements, or delivery of the newer consent-evidence line. Personal test-message contents and full headers have not been copied into these documents.

## What changed

- Reconciled the previously proposed three-year correspondence-history period with the policy. It is a separate purpose, limited to necessary correspondence, measured from the guest's last enquiry within that correspondence. Unrelated messages and automated replies do not justify indefinite retention. Other information is deleted after its own purpose ends; applicants are not retained for three years or added to a recruitment pool.
- Limited the form consent to enquiries and, where relevant, a specific vacancy application. It does not bundle advertising, photo publication, map permission or analytics.
- Added both Timeweb and Yandex collection/storage to the policy and consents. Identifying a service by its brand or working hostname does not establish its exact contracting entity.
- Replaced the obsolete statement that forms do not send mail. Source code checks show the current backend, required checkbox, email-based consent record, no separate archive of message bodies in WordPress, and an IP-hash rate-limit counter. The screenshots confirm the tested contact-email delivery route only.
- Updated both policies for the existing English/US–Canada automatic map-loading exception and absence of map settings in that case, including the fact that a stored refusal is not applied there. This describes the implementation, not its legal approval. Google remains under review as already agreed; no map behaviour changed here.
- Added `sp-nudge-off` and `sp-landed`, matching the recent language-nudge code. Retained the confirmed RKN registration and website-visitor categories.

## Only items needing attention before publication

1. **History retention:** confirm that three years is necessary and workable. It is the existing draft's proposal, not a statutory default. Separate optional permission for historical correspondence is preferable to making it a condition of a simple enquiry. The current form has one required checkbox; this review has not implemented a second checkbox or resolved the legal sufficiency of bundling these purposes. If history is omitted, remove clause 2.2 and the three-year provision in both consents and the corresponding policy row together.
2. **Provider arrangements:** check the account's actual Timeweb hosting/email contracting entity, processing terms, locations, backups and log retention. The previously supplied platform licence alone does not settle these. Yandex Mail terms clause 2.6 restrict ordinary use to personal/non-commercial use unless commercial use is under an appropriate agreement. Confirm that the manager's account is covered, or arrange the appropriate business service. A @yandex.ru address alone does not reveal which agreement is in place.
3. **Published text and evidence:** ensure /privacy-policy/, /en/privacy-policy/, /consent/ and /en/consent/ work without login; save the exact version of each consent language; set the version date accurately; verify a received test email records that version, time, IP and language. The screenshots do not show the consent record added by current code. A version/date in an email is useful evidence but is not proof of what text the visitor actually saw if text changes between page load and submission; preserve version snapshots and check that behaviour before treating the mechanism as fully verified.

Google's basis/cross-border review and actual deletion procedures remain the previously recorded issues, not new blank fields. This pass changes documents only, not the theme, database, mail configuration or publication state.

## Publication handoff

The page template already has separate `privacy_body_ru` and `privacy_body_en` fields and is reused for consent. Put the matching RU/EN bodies into each page's fields, excluding the editorial blockquotes and draft labels; keep both languages on revision 29.09.2026. Current `tools/page-seed.php privacy` and `consent` import only Russian; the new English files need to be placed in the English fields or a later importer update. Do not run a forced import into an approved/published page without reviewing its existing content. The texts have not been imported or published in this task.

## Sources reviewed

- [Article 9 of Law No. 152-FZ — consent](https://www.consultant.ru/document/cons_doc_LAW_61801/6c94959bc017ac80140621762d2ac59f6006b08c/): separate, specific and informed consent; ability to demonstrate consent. Do not indiscriminately apply the special written-consent particulars to every ordinary website checkbox.
- [Article 21 — cessation and destruction](https://www.consultant.ru/document/cons_doc_LAW_61801/d3fe43a7c415353b17faab255bc0de92bea127da/): applicable destruction deadlines and exceptions. A three-year history purpose is not created by these deadlines.
- [Yandex Mail collector instructions](https://yandex.ru/support/yandex-360/customers/mail/ru/web/preferences/collector): importing messages from another mailbox.
- [Yandex Mail terms](https://yandex.ru/legal/mail_termsofuse/ru/): clause 2.6 commercial-use restriction; clause 2.4 attachment storage terms.
- [Yandex 360 general terms](https://yandex.ru/legal/360_termsofuse/ru/): clause 1.5.4 provider definition, subject to the account agreement.
- [Timeweb email documentation](https://timeweb.com/ru/docs/pochta/) and [contract documents](https://timeweb.com/ru/support/documents/): service capabilities and applicable documents; public material does not establish which entity contracts with this account.
- Previously reviewed owner-supplied `oferta-tw.pdf`: platform licence; see privacy-policy-review-2026-09-28.md for the limitations of using it as evidence of hosting arrangements.
