> **Current baseline — accepted as a good starting point, 2 October 2026:** the current Lime banner asks for both Google Maps and Metrica. «На здоровье!» allows both; «Нет, спасибо» refuses both; underlined «Настроить» opens independent switches in one privacy dialog. Save applies choices, ×/Escape cancels. See `website-brief.md` → Analytics for the approved copy and behaviour. Earlier Got it and separate-settings plans below are historical.

# Sweet Pepper — cookie notice: copy and plan

*Historical exploration, 26 September 2026. The original proposals below have been superseded by the implemented shared privacy controls described above; see `website-brief.md` for current copy and `testing.md` for validation.*

Companion to [privacy-policy-ru-draft.md](privacy-policy-ru-draft.md) §5 and [privacy-policy-review.md](privacy-policy-review.md) (К01, К02, Т03–Т06). The placement mock-ups are in the contact sheet sent with this draft (`cookie-notice-placements.png`, not in the repo).

## 1. What the site does today — what the notice can honestly say

Facts from the theme source, not from an audit of the published site (the review's caveat stands: the source does not show plugins, hosting or WordPress's own cookies).

| What | Where | Nature |
|---|---|---|
| `sessionStorage` `spRailLearned` | `menu-rail-nudge.js` | Functional flag, tab session, never sent to the server |
| WordPress cookies for a plain visitor | not in the theme | Core sets none for an anonymous reader; the login and comment cookies are not a guest's case. **To confirm in a clean browser (Т03)** — WP Super Cache and SCF should set none, but that is an assumption until seen |
| Google Maps iframe | home Contacts (`home/contacts.php`), loads with the page | A request to Google with the guest's IP and browser data on every home visit; cookies inside the frame are Google's. Cross-border |
| Yandex map widget iframe | About and Menu Location, injected by `location-map.js` on load | Same, to Yandex (domestic) |
| Phosphor icon webfont | `header.php`, `unpkg.com` | A CDN request with the IP; no cookies. Could be self-hosted like Molot and Golos |
| Fonts | self-hosted | Nothing leaves |
| VK feed | server-side import | Nothing on the client |
| Contact / team forms | not yet wired to a sender | Their consent is a separate form line (Ф01), not this notice |

**So the site's only real third-party data flow is the two map embeds.** Everything else is either self-hosted or a functional flag. That is what decides the notice's shape.

## 2. What law and practice ask — short

- **Russia, 152-ФЗ.** No article says "show a cookie banner". The operator must inform about processing (art. 18.1, the policy) and needs a lawful basis for anything beyond running the site. Since the 2025 amendments and Roskomnadzor's practice, cookies and identifiers are treated as personal data, and lawyers advise a visible notice; the fines quoted for cross-border violations start at millions of roubles. Practitioner sources agree on three things: a bare «продолжая пользоваться сайтом, вы соглашаетесь» line is not consent; nothing non-essential may load before the choice; **purely technical cookies need a description in the policy, not a consent** (ZarLaw, ПоряДок, Feb 2026). *(A lawyer's sign-off is still owed — the review says so, and this draft does not replace it.)*
- **GOV.UK design system.** If a site sets only essential cookies, **no banner is needed at all** — a cookies page linked from the footer is enough. When a banner is needed: in flow at the top of the page (pushes content, never `position: fixed`, so it never covers the focused element — WCAG 2.2), `role="region"` with a label, real buttons, a confirmation that takes focus, the banner placed before the skip link in the DOM.
- **NN/g, cookie permissions.** Keep the overlay small; a big one goes at the top and pushes content rather than covering it; all options visible at once; equal buttons; plain words; no second overlay competing with it (their guideline 7 — the lang-nudge counts); users read a high-contrast "Accept" and a hidden "Reject" as manipulation and stop trusting the site.
- **Accessibility (Smashing, 2023).** Native `<button>`, a heading (visible or not), keyboard reachable, contrast, no focus trap unless it is a true modal, reduced motion respected.

## 3. The decision that comes first: the maps (К01)

The notice cannot be written until the maps are decided, because the maps are the only thing a guest could be asked to consent to.

**Recommendation: option А — the map loads on the guest's tap.** Each map slot shows a placeholder card at the map's size (surface ground, the pin icon, the address, one line and a button); the iframe is created on tap, and the choice is remembered in this browser so the second visit loads it directly. The route chips next to it work regardless. Consequences:

1. The notice stops being a consent form. Nothing non-essential loads before a choice, so the page-level message is a **note**, with one button that acknowledges, not accepts. That also fits the guest-perspective voice better — the site is not asking for anything.
2. The consent happens where the data flows — on the map, in context, with a reason the guest can see. The NN/g research on why people click "Accept" without reading is about consent asked out of context.
3. К02 in the policy ("how to change the choice") gets a real answer: the placeholder comes back from a link in the footer or in the policy («Карты: показывать / спрашивать»).

Option Б (no embeds, links only) needs no notice beyond the footer link and is the cheapest; the home Contacts and the Location sections lose their map. Option В (keep auto-loading) turns the notice into a true two-button consent and blocks the maps until it is answered — the copy for that case is in §4.4, so the choice is the owner's, not the draft's.

## 4. Copy — RU leads, EN is the register twin

**Voice.** This is one of the two places the bar may say «мы» (`design.md` §1.1: ticket replies and status-band messages are the bar answering). The note is literally the bar speaking to the guest, so first person is sanctioned here; the author decides whether to use it or keep the impersonal «сайт».

### 4.1 Headline shortlist (Molot, H3 18, accent-2 — the eyebrow style)

| RU | EN twin | Note |
|---|---|---|
| **ЗА СВОИМИ НЕ СЛЕДЯТ** | **NO ONE'S KEEPING TABS** | Working choice. Ties to «МЕСТО, ГДЕ ВСЕ СВОИ»; a Russian saying turned to the topic, not a translated metaphor. EN plays on the bar tab |
| ПЕЧЕНЬКИ — ТОЛЬКО К КОФЕ | COOKIES ONLY WITH COFFEE | The obvious pun; works in both languages; risks reading as the joke every site makes |
| МЫ НЕ ПОДГЛЯДЫВАЕМ | WE DON'T PEEK | Warm, first person; softer than the others |
| НИКТО НЕ СЛЕДИТ. ДАЖЕ БАРМЕН | NOBODY'S WATCHING. NOT EVEN THE BARTENDER | Five words, the site's theatrical register; the longest — check it in the band on a 360 phone |

The headline is the wink; the sentence under it stays plain (the voice memo's rule: not a pun in every line, and the joke must never become a promise the sentence does not keep).

### 4.2 The note (recommended state — maps on tap, no tracking storage)

**RU, full (desktop):**
> Сайт не ставит следящих cookies и запоминает только ваш выбор в этом браузере. Карты Яндекса и Google загружаются по вашему клику. Подробнее — в [политике конфиденциальности].

**RU, short (phones, or one row):**
> Никаких следящих cookies. Карты — только по вашему клику. [Подробнее]

**Button:** «Понятно». *Not* «Принять» / «Согласен» — nothing is being asked, and a consent verb on a note would claim a consent that was never given. Alternatives: «Ясно», «Хорошо».

**EN, full:**
> This site sets no tracking cookies and remembers only your choice, in this browser. Yandex and Google maps load when you ask for them. Details in the [privacy policy].

**EN, short:**
> No tracking cookies. Maps load only when you ask. [Details]

**Button:** "Got it".

**What the words commit to** (each is a check before publishing): no analytics or ad pixels (Т05); no first-party cookies for a guest (Т03, clean-browser audit); the notice's own flag and the map choice live in `localStorage`, which the policy's §5.1 table must list; the maps really are click-to-load on every page that has one (home, About, both menu pages, Visit).

### 4.3 The map placeholder (in-context choice)

Card at the map's size, surface ground, Golos 16.

- RU: «Карта от Яндекса. Загрузится по вашему клику — Яндекс увидит ваш IP-адрес.» Button «Показать карту» (secondary). The route chips stay beside it.
- EN: "Map by Yandex. Loads when you tap — Yandex will see your IP address." Button "Show the map".
- Google: the same line with Google. Under the address, the existing «Маршрут ↗» chips already give the guest the way out without a map.
- Remembered: «Карта загружается сразу — вы разрешили это раньше. [Спрашивать снова]» in the policy page or the footer, for К02.

### 4.4 If the owner keeps auto-loading maps (option В) — a real consent

Two equal buttons, both secondary, neither pre-selected, nothing loads until answered:

- RU: «Карты на сайте — от Яндекса и Google. Загрузить карту — значит показать им ваш IP-адрес; без карты есть адрес и ссылки на маршрут.» Buttons: «Показывать карты» / «Только ссылки».
- EN: "Maps here come from Yandex and Google. Loading one shows them your IP address; without it you still get the address and route links." Buttons: "Show maps" / "Links only".

### 4.5 Footer, both languages

Bottom row, beside the copyright, Caption 13: «Политика конфиденциальности» · "Privacy policy". One link; the policy's §5 is the cookies page, so no second "Cookies" link is needed (GOV.UK's pattern, one document). The policy URL is Д10 (`/privacy-policy/` proposed; the page does not exist yet).

## 5. Placement — the options, ranked

Constraints that ruled things out are on the contact sheet with the shots.

1. **A band under the header, in flow, site-wide — recommended.** The only placement that is safe on every page (home, menu, About, Visit, a vacancy) at every width. Quiet recipe: `--surface` ground (Parchment by day, Soft Peppercorn by night — the raised surface, not a colour block), a 1px `--text-muted` hairline below, Molot H3 word in `--accent-2`, Golos 16 in `--text-muted`, the link in `--accent-2`, «Понятно» as `btn-secondary`; one row on desktop (word · sentence · button), two or three rows on phones. Same family as the lang-nudge's outline recipe, so the two read as siblings. **Cost:** on the first visit the page starts ~56px (desktop) / ~130px (phone) lower; the 100vh heroes either subtract the band's height (`--notice-h`) or accept the foot word under the fold once; About and Visit's absolute, transparent header needs its dark ground carried over the band (seen in the mock).
2. **Corner note under the language switch (home), in flow elsewhere.** Reads well on Home, where the top-right is empty; on Menu it covers the hero photo, on About the headline, and a Paper card is the brightest object on the dark hero. Would need a two-row version and a per-page rule — two behaviours for one component. Not recommended.
3. **One row with the lang-nudge (the author's idea).** Home only: a guest arriving at `/menu/` or `/visit/` from a search or a map link never sees it, and a notice must meet every entry. The nudge is hidden below 992, so phones have no row to join. Two dismissables side by side is NN/g's "competing overlays". And the note's height pushes the foot word out of a 900px viewport. Set aside, with the shot on record.
4. **Fixed bottom bar.** Covers the section foot words on every page, the phone hero's Reserve button, and the WCAG 2.2 focus-not-obscured rule says fixed banners are the wrong tool. Out, as the author found.
5. **No banner at all** (GOV.UK's essential-only case): footer link + map placeholders, nothing on first visit. Legally the thinnest ice in Russia today, where practitioners advise a visible notice; keep as the fallback if the lawyer says the note is unnecessary.

**The deliberately wrong versions, and whether they earn it.**
- *The Lime tape* — option 1 in the Visit status band's clothes (Lime, Molot words, a Chili dot). Strong on Home and Menu; on Visit it puts two Lime bands in one view and borrows the band's meaning («can I come now?») for a legal note. Does not earn the exception.
- *The bartender's ticket* — a Paper slip printing from under the language switch on the house spring, the bar answering before the guest asked. Breaks "one ticket per view" on Visit (the hours slip) and the pairing pages, and the slip's voice is a *reply*, not a first word. Does not earn it either; the closest legal cousin is the quiet band with the ticket's Caption header line («SWEET PEPPER · KIROVA 10») — a small nod, if wanted.
- *The foot word* — a connector reading «ПЕЧЕНЬКИ?» that prints the answer on tap. Connectors are non-interactive by rule, and a legal notice must not be a riddle. No.

## 6. Behaviour (for the build)

- **Markup** printed by PHP on every page, right after `wp_body_open()` and before the skip link (GOV.UK's DOM order: the note is the first thing a screen reader meets, the skip link the first focusable after it). `role="region"`, `aria-labelledby` the Molot line, a real `<button>`. Works without JS: the note is simply there.
- **First visit only, cache-safe.** The flag is `localStorage` `spNoticeSeen` (the rail's naming), never a cookie — or the sentence "no cookies" would be false. The inline head script (`inc/daypart-head.php`'s pattern, before first paint) sets `data-notice="seen"` on `<html>` when the flag exists, and CSS hides the band, so a cached page never flashes it. Private mode: the try/catch the rail uses; the note may show twice, no harm.
- **Dismiss** = set the flag, collapse the band on the lang-nudge's recipe (transform + height, `--ease-gentle`); reduced motion: instant. No focus move on show (GOV.UK moves focus only to a confirmation, and a note has none). Escape does nothing — it is not a dialog.
- **Not fixed, ever.** It scrolls away with the page.
- **Languages:** `__()` strings in `languages/ru_RU.l10n.php` (UI strings tier), both bodies; the policy URL per language from `sweet_pepper_lang_url()`.
- **Heroes:** `.home-hero`, `.visit-hero`, the About hero and the menu hero read `--notice-h` from the band (`ResizeObserver`, or the CSS `anchor-size` when it lands) and subtract it from their 100vh on the first visit — or the author accepts the foot word under the fold once. Decide when it is seen on a phone.
- **Maps (option А):** `location-map.js` and the home Contacts iframe become placeholder + `data-map` on the container; the tap creates the iframe (eager, as now), sets `localStorage` `spMapsOn`; the placeholder's text and button are `__()` strings; the footer's policy link is where «Спрашивать снова» lives.
- **Policy §5.1 table** gets three rows: `spNoticeSeen`, `spMapsOn`, and the maps' click-to-load description (К01 = А, К02 answered). Т03–Т06 remain the audit's.

## 7. Steps

1. Owner + lawyer: К01 (maps) and whether the note is wanted at all — this draft assumes А + a note.
2. Author: headline pick (§4.1), the «мы» / «сайт» register, «Понятно» vs alternatives, and the final RU sentences.
3. Build behind a URL flag (`?notice=band`): the band, the head-script flag, the dismiss, the hero `--notice-h`; shots at 1440 / 820 / 402 on all five templates, day and night.
4. Maps: placeholders on home, About, both menus, Visit; remember + reset.
5. Footer link; the policy page (Д10) once the policy is approved.
6. Clean-browser audit for Т03–Т06 before the words go live; then `report.md`, `website-brief.md` → a *Cookie notice* entry, the policy's §5 rows, `ru_RU.l10n.php`.

## 8. Open for the author

- Is the note wanted on the first visit at all, or is footer link + map placeholders enough? (§5, point 5.)
- Quiet band or one of the loud ones, having seen the sheet.
- Whether the 100vh heroes give up their fold on the first visit or subtract the band.
- The unpkg icon font: self-host it like the other fonts so the "nothing leaves" line is true without a footnote.
- The EN twin for the headline: "NO ONE'S KEEPING TABS" trades the «свои» idea for the bar-tab pun; the register matches, the image does not, which is the twin rule.

## Sources

- [NN/g — Cookie Permissions 101](https://www.nngroup.com/articles/cookie-permissions/) · [NN/g — 6 design guidelines (video)](https://www.nngroup.com/videos/cookie-permissions-guidelines/) · [NN/g — 5 user types (video)](https://www.nngroup.com/videos/cookie-permissions-user-types/)
- [GOV.UK Design System — Cookie banner](https://design-system.service.gov.uk/components/cookie-banner) · [Cookies page pattern](https://design-system.service.gov.uk/patterns/cookies-page/) · [WCAG 2.2 focus-not-obscured issue on the banner](https://github.com/alphagov/govuk-design-system/issues/3256)
- [Smashing Magazine — The potentially dangerous non-accessibility of cookie notices](https://www.smashingmagazine.com/2023/04/potentially-dangerous-non-accessibility-cookie-notices/)
- [ZarLaw — Cookie-баннер: требования 152-ФЗ и штрафы РКН](https://zarlaw.ru/articles/kuki-banner-nuzhen-ili-net/) · [ПоряДок — Cookie-баннер в России (5 Feb 2026)](https://poryadoc.ru/blog/cookie-banner-rossiya) · [b-152 — Cookie-файлы как персональные данные](https://b-152.ru/cookie-fajly-kak-personalnye-dannye) · [Mottor — 152-ФЗ и файлы cookie](https://lpmotor.ru/articles/152-fz-cookie-2511)
- Other results seen, not relied on: [Cookie Information](https://cookieinformation.com/resources/blog/cookie-banner-design-tips/), [WebToffee](https://www.webtoffee.com/blog/best-ui-ux-practices-for-cookie-banners/), [LogRocket](https://blog.logrocket.com/ux-design/cookie-ux/), [Pandectes](https://pandectes.io/blog/the-vital-role-of-accessibility-in-cookie-banners/), [Cookie-Script](https://cookie-script.com/guides/web-accessibility-and-cookie-banners-compliance-checklist), [Secure Privacy](https://secureprivacy.ai/blog/wcag-cookie-banner-requirements), [ic-tech](https://ic-tech.ru/blog/faq/questions-152fz-site/nuzhno-li-na-sayte-razmeschat-otdelnoe-okno-banner-o-soglasii-na-cookie-ili-dostatochno-teksta-v-politike-konfidentsialnosti/), [pod-ft](https://pod-ft.ru/baza-znaniy/cookie-banner-dlya-sayta-chto-eto-i-trebovaniya-po-152-fz/), [Qform](https://qform.biz/blog/yuridicheskie-nyuansyi-sbora-cookies-kak-soblyudat-152-fz-besplatnyij-skript).

## 9. Prototype — B and C, fixed, delayed (27 September 2026)

The author's call after the contact sheet: try both B (corner card) and C (band), **fixed at every width — overlap, never push** («users won't miss the message, and it will cost just a first visit and one click»), shown **after the page has finished loading plus 10–15 s**, sliding in; B themes with the page (dark on the dark theme and on the fixed dark pages). Built behind a URL flag; the site without the flag is unchanged.

- **Try it** *(the bottom band is the site's default since the same evening — the last note in this section; the flags now compare against it: `?notice=corner` for the card, `&pos=top` for the top)*: `/?notice=corner` · `/?notice=band` — any page; **`&pos=bottom`** puts the same note at the foot of the viewport (added 27 Sep 2026 to compare: the card bottom-right 16px in, the band flush to the bottom edge, both rising from below). `&delay=<seconds>` shortens the wait (`&delay=0` for a look), `&again` re-shows a dismissed note. The wait is `window.load` + **2 s** (`DELAY` in `src/js/cookie-notice.js`; 12 s at first — 1–2 s read better on the author's test). **The desktop band keeps 12px of air under the header** (77 touched the logo on a wide screen); the air closes as the header scrolls off.
- **Files:** `template-parts/components/cookie-notice.php` (printed from `footer.php` after the reserve drawer, only with the flag), `src/css/cookie-notice.css`, `src/js/cookie-notice.js`, six strings in `languages/ru_RU.l10n.php`, imports in `src/main.js`.
- **Recipe:** the lang-nudge family — `--surface` ground, 1px `--text-muted` keyline, 4px radius, Golos 16 muted, the Molot H3 word in `--accent-2`, the link in `--accent-2`, «Понятно» as `btn-secondary` at 4/12 padding. Night through the tokens; About / Visit / a vacancy take `.cookie-notice--dark` (Soft Peppercorn, Mushroom, Lime), as the header does. z-index 99: under the header (the band slides out from behind it) and under the drawers.
- **B · corner:** desktop 420px wide, under the language switch with 16px of air, off the right edge until shown (`translateX`), the full sentence. Phones and tablets: spans the 16px gutters under the fixed bar, the short line. It covers the top of the menu hero photo and the phone hero's tiles while it is up — the accepted cost.
- **C · band — Lime at every hour and on every page (author, 27 Sep 2026; B alone themes):** Lime ground, Peppercorn word with a Chili dot, Peppercorn text, link and outline button; hover fills Peppercorn with a Lime label. Full width, hangs from the header's bottom edge (`--cookie-top`, measured), slides down from behind it (`translateY`), the short line in one row with the word and the button; three rows on phones (146px). On desktop it takes the top of the viewport once the in-flow header has scrolled away (a passive scroll listener). On About it reads as a second bar under the transparent header.
- **Dismiss:** `localStorage` `spNoticeSeen` = 1 (never a cookie), slide out on `--ease-gentle`, then `hidden`. Reduced motion: no transition. `role="region"` labelled by the Molot line; a real `<button>`; no focus move on show, no focus trap. No JS = never shown (the aside is `hidden` in the markup).
- **Copy** is §4's working choice, RU and EN. It still says the maps load on click, which is not true until К01 is built — the words must not ship before the maps do.
- **Tablets and phones (author, 27 Sep 2026):** on 768–991 both notices set the word on its own row and the sentence and the button in one row, as on desktop (a two-column grid; the sentence holds one line at 768 and 820); the fallback, if a longer sentence ever breaks it, is the phone layout. On phones the button is full width under the sentence. The author leans to the bottom band; every variant stays until the final decision.
- **Bottom refinements (author, 27 Sep 2026 — only the bottom versions are still in the running, the band leading):** on desktop the bottom card spans the gutters up to 1280px, centred, in the tablet layout with the full sentence (the 420px card bottom-right did not read well at the foot of a wide page; the top card keeps 420). Tablets: the word-to-sentence gap is 4px, under the box's 12px padding. Phones: 16px padding on every side (12 read tight against the 16 gutters).
- **Glass strip and the tablet gap (author, 27 Sep 2026):** the desktop bottom card is now a card inside a glass wrapper that hugs it (not full width — author, same day: the card's 1120 plus 8px a side — 24 at first, 8 reads as a wide stroke rather than another container — centred, 16px off the bottom edge, 8px corners) — the page ground at 70% over a 16px blur — and the card is matched to the 1120px content column (a 1280 card ran wider than the content on big screens). One deliberate exception to "flat by default": the blur is the separation from the page. The markup gained an inner `.cookie-notice__box` (`display: contents` everywhere else). On tablets the button spans the word and the sentence rows (`"title ok" "text ok"`, row gap 0) — with the button in the sentence row it set that row's height and the word-to-sentence gap read as the padding.
- **Glass by day (author, 27 Sep 2026):** the wrapper mixes Parchment, not the Paper ground — Paper over Paper was invisible; night and the dark pages keep Peppercorn. Blur 16px and 70% stay until the author settles values (only the 8px ring shows them, and only over something with edges — the tiles, the foot word, the night photos). **Committed 27 Sep; the author tests the four variants on devices and returns with a decision.**
- **Not done:** the phone header's scroll-away, the reserve drawer opening over the note (the drawer wins by z-index; the note stays behind it), an `aria-live` announcement for screen readers (GOV.UK does not announce a banner either), the shots on the vacancy template.
- **The band at the foot of the viewport is the default (author, 27 Sep 2026):** it prints without a flag; `&pos=top` hangs it under the header to compare, `?notice=corner` keeps the card up for testing, `?notice=off` prints nothing. On desktop (≥ 992) the band's row sits on the content column — the `.cookie-notice__box` becomes a flex row, 1280 max with the gutters, centred — because the full-width row read unbalanced on a wide screen (the word at one edge, the button at the other); the Lime tape itself still runs edge to edge.
