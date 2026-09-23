# Sweet Pepper Website — Project Report

> **Last updated:** 2026-09-23 (menu picker hint — 364px cap off on desktop; menu pickers in Russian — «Спросите Гастробота» + bar / kitchen hints; RU food-menu connectors on /menu/ — eleven words, hero still EN pending a re-export; «Ваш выбор», «ГАСТРОБАРИМ С 2014», «Легенда улицы Кирова»; About RU draft on the site — 17 SCF fields, fallbacks, picker strings; About RU — the author's answers applied: capitals, «Без ступенек» everywhere incl. the page, screen-reader name, ё; Tabasco Bar — ул. Свободы, 9; About RU draft — the author's voice pass and edits reviewed (Concept «МЕСТО, ГДЕ ВСЕ СВОИ», «Спросите Гастробота», perks, founder name confirmed); RU food-menu connectors exported from Figma — 12 words, not yet wired; About story ¶1 and three menu hero lines rewritten in the RU drafts; Food-menu RU connectors — author's editing pass, match-maker line «Пара от бара — вместе вкуснее!»; media topics — «Темы» labels on images; pairings record renamed «Гастробот»; test-site database steps for the day; Menu store decided — Б: all 253 rows in «Блюда» / «Напитки», placed by «Разделы меню»; every section template reads the store; RU twins from menu.md; option А removed from the build and archived in the brief; 2026-09-22: `tools/field-update.php` — field changes for the test site's database; perks stamps — stronger hover, card-recipe pressed; author's RU About copy edits applied to SCF; About hero headline in two fields — stacked two-colour below 992; perks detail row top-aligned on tablets; How it feels — RU cloud words, review links on RU cards, cloud type scales with its column below ~1280, CTA gap 48; About Visit CTA — default RU copy seeded; About hero connector above the fold when logged in; Guests CTA RU → «Фото в VK»; About RU connectors wired — nine RU SVGs, stem map in `template-parts/about/connector.php`; Pairings record («Подбор пары») + Russian UI strings file; About page fully on SCF fields — ten tabs, both languages seeded; Team tab — 6 / 8 members, tenure printed from a year, photos as attachments; Language on the URL built — `/` RU, `/en/` EN, `inc/lang.php`, pill = link; Molot webfont rebuilt with Cyrillic from the OTF; About extraction started — Careers and the shared Location headline read from SCF fields, `sp_field()` / `sweet_pepper_lang()`, Polylang displaced; Home Highlights headline → "& LOCAL HITS" and a phone headline line-count sweep; Test-site round: connector SVGs `preserveAspectRatio="none"` for the WebKit reflection-width fault, drawer descriptions Body 16 from 768, Shake It! 64 in the tablet band, How it feels quote slots + phone cloud unclipped, then the phone commit — chosen word centres, twelve words on phones, field height follows the words, dim 50%; Rail tremble confirmed fixed on the phones, `?debug=` code removed; Rail tremble found — section-level `overflow-x: clip` from the reveal engine, now only on sections with a mask-right element; Rail tremble persists after the split — `?debug=` switches to isolate it on the phone; Rail tremble: real cause found in the author's recording — sticky + scroll container, split in two; iOS phone-number auto-link off; 2026-09-20: Menu storage: А rows compacted to one line, Б size/price in Quick Edit; closed call button Lemon; Menu rail tremble: whole-pixel geometry, to confirm on device; Day reflections at full opacity below 992px; Phone bento: equal row gap whichever tile is lit; night-red options on a contact sheet; Header chip = language switch height; home hero 32px air floor + height-aware tiles; Menu rail: entrance + idle nudge applied, flag removed; Menu rail: 8px below the words as above; Reveal engine: parked headline fix — box-less roots released, `reveal:check` on a section switch; Menu rail: current word = nav word on phones, idle-nudge prototype behind `?rail=nudge`; Nav drawer: descriptions to Caption 13, icon centred on the text; Home contacts: message buttons shortened to the drawers' labels; Bar hours settings: four fields on Bar Settings, code defaults, one source for hero / drawer / Visit / footer; Menu storage: dishes store built for Soups — `dish` posts + `menu_list` Relationship lists, `?menu_store=dishes`; Home hero closed state built — parked lit tile, welcoming copy, `?closed=` override; small hours fixed; Visit hero Sunday rule; One bar clock: home hero, reserve drawer and Visit hero all read Europe/Moscow via `bar-clock.js`; 2026-09-19: Test site test.sweetpepper.bar: theme live from a synced copy — the host refused the symlink; next session recorded under *Next Up* — real-browser layout issues, home hero closed state; Dish picker: Shake It! between the photos, the photos roll, one pairings list for menu + About; 2026-09-18: Menu storage: repeater store built for Soups — `menu_section` records, generated field group, seeder; Platform decisions: SCF, WP Super Cache, Timeweb, menu storage narrowed; Menu section pass + ride suppression + photo-band drift; Menu hero idle sweep + daypart opening frame; Menu hero entrance; Visit hero entrance + scroll-in; dish-picker ticket prints on a pick; About scroll-in + reveal engine reworked to layout triggering; About hero page-load entrance; home motion: page-load entrance, first-paint theme, headline scramble, scroll-in reveals, count-up, photo drift, replay from below; 14px Secondary retired; tablet type mode; home tile radii; connector parallax scoped to heads; icon-beside-text rule)  
> Read this before writing any code. Then read `design.md` and `website-brief.md`.

---

## RU menu connectors on the page; three RU leftovers filled — 23 September 2026

**Connectors (author: "isn't the hero menu connector a part of the copy?" — yes; the earlier "not ready" was too broad).** `inc/menu-sections.php`: `sweet_pepper_menu_connectors_ru()` (EN stem → RU stem + alt, sentence case like About's) and `sweet_pepper_menu_connector_lang()`, called by `template-parts/components/section-link-word.php`: on a Russian request of the **food** menu a kitchen connector swaps to its twin in `kitchen-{day,night}/ru/`, only when **both** files exist, so a word never changes language between day and night. Not on the drinks page — it reuses two kitchen files (the match-maker reflection, YOU'LL LIKE IT) and its RU row is undecided. **Eleven words on `/menu/`:** ТОЛЬКО ЭТОЙ ОСЕНЬЮ, НАЧАТЬ ДЕНЬ СО ВКУСОМ, ЛУЧШИЕ ОБЕДЫ В ГОРОДЕ, ДЕЛИТЬСЯ НЕ ОБЯЗАТЕЛЬНО, КЛАССИКА И ХИТЫ ОТ ПЕРЦЕВ, ЛУЧШИЕ БУБЛИКИ В ГОРОДЕ, ВОСТОРГ В КАЖДОЙ ЛОЖКЕ, СЫТНО, ВКУСНО, УЮТНО, ДАЁШЬ СЛАДКУЮ ЖИЗНЬ!, ПАРА ОТ БАРА — ВМЕСТЕ ВКУСНЕЕ (word, phone tail word and the reflection the author exported at 18:01), ВАМ ЗДЕСЬ ПОНРАВИТСЯ. **Verified:** the RU food page changes in exactly 13 connector images (26 lines: src + alt); drinks and both `/en/` pages byte-identical; in headless Chrome all 26 RU files load by day and by night, at 1440 and 402 (Cyrillic file names served as-is); heights at 1440 49–99 px, at 402 the match-maker 16 px (the length test's number). The desktop picker has no reflection shown — same as EN. Every export rasterised and read: each file says what its name says; the match-maker was exported **without «!»**, Desserts **with** it. **The hero stays FOOD MENU:** `кухня от перцев.svg` is filled, one colour (#869438), not the outlined connector every other file is (#737D3A day) — likely the wrong layer; no night file, no reflection. Needs an outlined re-export (day, night, reflection) as `кухняОтПерцев.svg`; then one line in the map (the hero's paths are `foodMenu` / `foodMenu-reflection`).

**Three RU lines (author):** the picker ticket's «Your Match» → **«Ваш выбор»** (`ru_RU.l10n.php`, both pickers); the Story eyebrow, an empty RU field that printed SINCE 2014 → **«ГАСТРОБАРИМ С 2014»** (`tools/field-updates/2026-09-23-about-ru-eyebrow.json` + `data/about/story.php`); the picker's dish line, «The legend of the Kirova street» in all six rows, still a placeholder → **«Легенда улицы Кирова»** for the five rows with no RU line (`…-gastrobot-ru.json` + `data/pairings.php`); the soup keeps «Был сезонным. Остался по вашим просьбам.». Applied on Local, then "done". `tools/field-update.php` accepts `"post_type"` for a one-record type. Checked: RU About / Menu show the three, EN pages unchanged. **Menu pickers (author, same day):** the heading and hint were typed English in `pairing-station.php` / `pairing-station-bar.php` — now `__()` strings: «Find Your Match!» → **«Спросите Гастробота»** on both menu pages (the About name, one name everywhere); hints **«Выберите блюдо — и получите рекомендацию от бара!»** (food) and **«Выберите напиток — и получите рекомендацию от кухни!»** (drinks) — the menu draft's older НАЙДИТЕ СВОЮ ПАРУ! / «…посмотрите, что предложит бар» replaced. Diffed: the two RU menu pages change in exactly these two lines each; `/en/` identical. Measured: heading one line at 1440 / 1024 / 768 (64 / 64 / 48 px), two lines on phones (36 px) — EN FIND YOUR MATCH! is one; the hint two lines at every width (EN one); nothing clipped, no page overflow. **The hint's 364px cap (author: "why 364 on desktop?")** — in `dish-picker.css` since the first build, no comment, no doc; likely a Figma text-box width (author: maybe the vertical picker); not a grid width (4 columns 357, 5 → 452). About's picker hint never had one, phones already undid it. **Removed from desktop, kept for the tablet band** (768–991, the stacked picker) until the Figma frame is checked; the phone rule that only undid it is gone. Rebuilt — CSS changes in exactly these rules, JS byte-identical (renamed with the CSS hash). Measured: RU hint one line from 992 up (1120 wide at 1440, 904 at 992), both menus; EN unchanged; tablet RU two lines at 364; phones RU two lines at full width. **The legend line stays** as the placeholder until the real lines are written (author) — the menu draft said «без повторяющейся легенды»; that returns with the real copy.

## About RU copy on the site — 23 September 2026

The author's finished draft (`about-page-copy-ru-draft.md`) is on the Russian About page.
- **SCF, 17 fields in 10 groups** — `tools/field-updates/2026-09-23-about-ru-draft.json`, generated from the database's current values (old) and the draft (new; every value checked against the draft word for word): hero lead; Concept headline **МЕСТО, / ГДЕ ВСЕ СВОИ** (two fields, as before) + text; perks ДЛЯ МАЛЕНЬКИХ ПЕРЦЕВ, ДЛЯ ЧЕТВЕРОНОГИХ ДРУЗЕЙ; Story ¶1–3; **founder name «Юрий Примышев.»** — the RU field was empty, so the Russian page had printed "Iurii Primyshev."; the founder photo's RU alt «Юрий Примышев за барной стойкой Sweet Pepper» (**mine** — the draft has no alt text; its EN twin is "…behind the bar at Sweet Pepper"); 2009 «Жаркое начало»; Guests eyebrow + text; Careers; Location; closing invitation. Applied on Local, second run "done".
- **Typed fallbacks** (`data/about/*.php`) carry the same values — every old value found once, in one file. **Picker strings** (`languages/ru_RU.l10n.php`, About only — the menu page's picker has its own copy): «Спросите Гастробота», «Выберите блюдо — и получите рекомендацию от бара!»; the shake button's screen-reader name was already «Выбрать случайное блюдо». Not built: the draft's «Фото ВКонтакте» for a standalone button — the page has only the button beside the VK mark («Фото в VK»).
- **Checked** on `/about/` at 1440 / 1280 / 1024 / 768 / 402 / 360: no page overflow, no heading clipped by the new copy; «СПРОСИТЕ ГАСТРОБОТА» and МЕСТО, / ГДЕ ВСЕ СВОИ on one line each at every width; Story ¶1 5 lines at 1440, 8 at 1024, 9–10 on phones (section 1155 px at 1440). `/en/about/` unchanged. The Location headline clips at 1024 — the known 🔶 (brief → *The Location headline cannot hold two lines*), not this copy.
- **English still showing on the Russian page (not in the draft, found in the screenshots):** the Story eyebrow «SINCE 2014»; «YOUR MATCH» on the picker's ticket (the draft notes it has no Russian); the dish line «The legend of the Kirova street» under Жаркое — the «Гастробот» row's RU line. *(All three filled the same day — entry above.)* The counters still show placeholders (numbers pending the team).

## About RU draft — the author's voice pass and edits, reviewed — 23 September 2026

Two rounds in `about-page-copy-ru-draft.md`, both the author's: a commit (`98a71e1`, "conversational tone" — hero, Concept, Story ¶1–3, Guests, Careers, Location, the closing CTA, in the voice of the bar's posts) and edits on top (`20da6f2`). **Draft only: SCF still holds the previous RU on every field** — applying it on Local and the test site is a `tools/field-updates/` file once the author calls the draft done.

**What changed.** Hero text drops «Забегайте» and opens «Вкусно перекусить…». Concept: headline **МЕСТО, ГДЕ ВСЕ СВОИ** (was ГАСТРОБАР, ГДЕ ТЫ Свой); text ends «Градус и острота на ваш вкус!». Picker: heading **«Спросите Гастробота»** (was ПОПРОБУЙТЕ САМИ) — the admin name now faces guests (brief → *Picker pairings*); hint «…и получите рекомендацию от бара!»; screen-reader name «Перемешать». Perks: «ДЛЯ МАЛЕНЬКИХ Перцев», «Для чутвероногих друзей», «Без ступенек / ВХОД БЕЗ СТУПЕНЕк». Story: ¶1 retold (2009, ул. Свободы → Кирова); ¶2 «Собственно, название…»; ¶3 the seasonal dishes that stayed; founder signature **Юрий Примышев** (confirmed by the author — the placeholder is gone); 2009 caption **«Жаркое начало»**. Guests: eyebrow «ЗНАКОМЫЕ все ЛИЦА», «(привет, 2014-й!)», button «Фото ВКонтакте». Careers, Location and CTA reworded warmer («обязательная остановка», «разлетаются они быстро»).

**Fixed since the last review:** «Давным-давно» and its commas; «никуда не делись» settles the old agreement point.

**The author's answers, same day — applied** (`about-page-copy-ru-draft.md`): typos fixed (четвероногих, СТУПЕНЕК, подтверждено); the mixed-case lines were typed in progress — now in capitals (ДЛЯ МАЛЕНЬКИХ ПЕРЦЕВ, ДЛЯ ЧЕТВЕРОНОГИХ ДРУЗЕЙ, ЗНАКОМЫЕ ВСЕ ЛИЦА, СПРОСИТЕ ГАСТРОБОТА); **«Без ступенек» everywhere** («без ступеней» — nobody says it): the draft's two notes, `data/about/perks.php` and the three SCF values on Local through `tools/field-updates/2026-09-23-about-ru.json` (applied, then "done"; the page shows it); screen-reader name back to «Выбрать случайное блюдо»; **Tabasco Bar was at ул. Свободы, 9** — noted under the Story, the EN twin stays "Kirova Street" until the author refines the English, last; «Жаркое начало» has one meaning in Russian (my double reading withdrawn); the author changed ¶1's «чуть слаще» to **«чуть мягче»**, so ¶2 keeps it alone; **ё** added where it was missing — «найдётся» (Concept), «далёкой» (Story), «найдёте» (Guests); «веселыми» stays — it quotes a guest's review, which the draft does not correct. **`tools/field-update.php`:** a field inside a repeater row has no key of its own, so the tool now writes such a field by its saved name (`about_perks_5_title_ru`); the 22 Sep file re-run reports all ten groups "done". ¶1's length and the rest of the draft: done — entry above (*About RU copy on the site*).

**For the author (the review as first written):**
- **Typos:** «чутвероногих» → четвероногих; «ВХОД БЕЗ СТУПЕНЕк» → СТУПЕНЕК; «потдтверждено» (the note under the signature).
- **Capitals:** the perks' expanded headings, the Guests eyebrow and the picker heading are now mixed case («ДЛЯ МАЛЕНЬКИХ Перцев», «Для чутвероногих друзей», «ЗНАКОМЫЕ все ЛИЦА», «Спросите Гастробота») while their neighbours are set in capitals — intended, or typed in progress?
- **Stale note:** under the perks table, «**Без ступеней** — короткий вариант для круга» — the circle label is now «Без ступенек».
- **Screen-reader name «Перемешать»** says less than «Выбрать случайное блюдо»: a screen-reader user hears only the name, without seeing the dishes move — it should say what the button does.
- **Still open from the last review:** the EN twin puts Tabasco Bar on Kirova Street (RU: Свободы → Кирова); ¶1 ends «Перец в названии стал чуть слаще» and ¶2 still opens «всё ещё с перцем, но чуть слаще»; ¶1's length in the Story column.
- **«Жаркое начало»** reads two ways — a hot start, and «жаркое», the roast on the menu. Probably a gift; noted in case it isn't meant.
- **ё:** the draft mixes «найдется», «далекой», «найдете» with «найдётся» elsewhere — pick one before it goes to SCF.

## RU food-menu connectors exported; About and menu copy edits — 23 September 2026

**Connectors.** The author exported the RU food-menu connectors from Figma: `assets/sectionLinks/menu/kitchen-day/ru/` (12) and `kitchen-night/ru/` (11) — Cyrillic camelCase file names, as the home RU set. The table in `menu-copy-ru-draft.md` → «Коннекторы кухни» now records **what was exported**, with the file per row; two lines differ from the table as it stood: Salads **КЛАССИКА И ХИТЫ ОТ ПЕРЦЕВ** (was …И ШЕДЕВРЫ…) and after the picker **ВАМ ЗДЕСЬ ПОНРАВИТСЯ** (was ВАМ ПОНРАВИТСЯ); Hero **КУХНЯ ОТ ПЕРЦЕВ**. The export is read as the author's choice; the exclamation marks and the match-maker's length stay on test in Figma. **Measured from the viewBoxes** (a connector stretches to its column, so a long line sets low): at ≈1092 px the RU words are 48–97 px tall against EN 62–110; lowest ПАРА ОТ БАРА — ВМЕСТЕ ВКУСНЕЕ! 48 (EN 68), then salads 54 and bagels 58; on a 370 phone the match-maker is ≈16 px against EN 23. **Missing before wiring:** the hero's night file and its reflection (EN `foodMenu-reflection.svg`, `page-menu.php`), the match-maker's reflection (EN `tryTheMatchMaker-reflection.svg`, the picker's head); the hero file's name has spaces (`кухня от перцев.svg`). `favoritesTheyFinish.svg` is used nowhere, so it needs no twin. Nothing wired: the templates still point at the EN files in both languages.

**Copy (drafts only — not in SCF or the theme yet).**
- `about-page-copy-ru-draft.md` → Story ¶1 rewritten by the author: Tabasco Bar from 2009 on ул. Свободы, the kitchen added, the move to Кирова, «перец… чуть слаще», the fire kept. The year matches the timeline (2009). **Open:** (1) the EN twin (and the SCF value `about_story_p1_en`) still says "Tabasco Bar on Kirova Street" — the two languages now state different facts; (2) ¶2 opens «всё ещё с перцем, но чуть слаще», which ¶1 now says too; (3) small typing: «Давным-давно» (hyphen), «улица Свободы» (capital, second mention), «характер и порох… так и остались» (two subjects); (4) the paragraph is ~2.5× the old one — check it in the Story column on desktop and phone. SCF `about_story_p1_ru` still holds the old text; applying it on the test site needs a `tools/field-updates/` file.
- `menu-copy-ru-draft.md` → hero paragraphs for **Breakfast** («Проснулись к обеду?…»), **Sandwiches** (the sandwich set: a sandwich, fries and a sauce) and **Desserts** («Вам можно!…»). The RU hero descriptions are not in the theme at all yet (`inc/menu-sections.php` holds EN only) — they go in when the menu page's section copy moves to «Разделы меню».

## Drinks-menu connectors — RU options, 23 September 2026

The drinks inventory was empty. Added eleven current EN connector entries and rough RU options to `menu-copy-ru-draft.md` → «Коннекторы бара», including hero, seasonal highlights, seven categories and the pairing entrance/exit. All new bar selections remain unapproved; noted the existing YOU’LL LIKE IT placeholder and shared dish-first picker. `connector-copy.md` links to the editable draft. Documentation only; no theme, SVG or CMS changes.

## Food-menu RU connectors — author's editing pass — 23 September 2026

**The author finished editing the table** (`menu-copy-ru-draft.md` → «Коннекторы кухни»). One line changed: the lead-in to the dish picker (EN TRY THE MATCH MAKER) is now **«Пара от бара — вместе вкуснее!»** — the author's own, after the ideas round (С ЧЕМ ЭТО ПЬЮТ?, БЛЮДО ИЩЕТ ПАРУ, СОВЕТ ДА ЛЮБОВЬ, ВДВОЁМ ВКУСНЕЕ… and the rhyme ВКУСНАЯ ПАРА ДЛЯ КУХНИ ОТ БАРА set aside as too childish); its row is marked as the author's choice. The other eleven rows kept their wording and their «Первый перевод» status — finishing the pass is not read as approving them; the Hero row (КУХНЯ ОТ ПЕРЦЕВ) is still marked undecided. **Before the SVGs:** (1) the new line is typed in sentence case while every connector is set in capitals (ПАРА ОТ БАРА — ВМЕСТЕ ВКУСНЕЕ!); (2) **on test in Figma (author, same day):** the exclamation marks — on it and on Desserts' ДАЁШЬ СЛАДКУЮ ЖИЗНЬ!, which feels right to the author but gets tested first; the Home and About RU rows avoided them (`home-copy-ru-review.md` → current connector row) — and the length: at 29 characters it is the longest food connector; the author holds a fallback line if it doesn't fit, and wants the chosen lines tested first. Nothing exported or wired: the RU food-menu connector SVGs are the next step once the rows are approved (Next Up → 0).

### Earlier the same day — editable inventory

**Follow-up, author request:** moved the full editable table into `menu-copy-ru-draft.md` → «Коннекторы кухни»; `connector-copy.md` now links there to avoid competing copies. All twelve rows, alternatives and draft statuses preserved.

Added the twelve discussed EN/RU food-menu connector rows to `connector-copy.md` → Menu page — food state, with draft status, the author's hero alternatives (no selection inferred), printed-menu wording references, and the endpoint interpretation. Linked from `menu-copy-ru-draft.md`. Documentation only; no copy published or assets changed.

## Media topics — labels instead of folders — 23 September 2026

Author: "is there a way to organise the media library — folders by page/theme?" WordPress has none; a folders plugin would spend the free plugin slot on an admin nicety, so the theme adds **labels** (`website-brief.md` → Platform → *Media topics*).
- **`inc/media-topics.php`** (new, required from `functions.php`): taxonomy `media_topic` on attachments — hierarchical (checkboxes, not a tag box), not public, `query_var` `media_topic`, admin column on, generic term count (attachments are `inherit`). Default topics **Еда · Бар · Команда · Гости · События · Интерьер · Логотип и бренд** made on the first admin load (`sp_media_topics_seeded` option — once, so a deleted topic stays deleted); Media → Темы to rename or add.
- **Where the team meets it:** «Тема» checkboxes in an image's details (`attachment_fields_to_edit` / `_save`; WordPress's own comma-separated slug box removed); a «Все темы» filter in the grid toolbar and every picker (`wp_enqueue_media` → an `AttachmentFilters` subclass added to `AttachmentsBrowser`'s toolbar; the attachment AJAX query passes the taxonomy's query var itself); a list-view dropdown with counts; list-view bulk actions «Тема: …» (added, not replaced) and «Тема: снять все».
- **`tools/media-topics.php`** (new): labels unlabelled images by the field they sit in — keys matched whole, never by value, because an attachment ID can equal a price (the survey found 65 = Ararat's ID = a dish price). Locally all 35: Еда 6 · Бар 6 · Команда 14 · Гости 8 · бренд 1.
- **Verified (CLI):** the `media_topic=bar` query returns the six drink photos; checkboxes tick / untick; bulk add; list dropdown. **Not seen:** the grid / picker filter — media-views JS, needs a wp-admin login.
- **Deferred by the author:** image position (focal point) — after the menu's section content moves into «Разделы меню»; plan in the brief (a *Фото* field + a vertical slider driving `--img-y`).

## Pairings record renamed «Гастробот»; test-site steps for the day — 23 September 2026

- **«Гастробот»** (a team member's name for it, easier for the team): the author had renamed the SCF group in its panel, but the sidebar is the post type's label and the group file is generated — a re-run would have put «Подбор пары» back. Changed at the sources: `inc/cpt.php` labels, `tools/page-field-groups.py` title (regenerated; the panel save's extra keys dropped), the seeder's record title; the Local record renamed. `tools/page-seed.php pairings` now renames a record still titled «Подбор пары» and leaves its rows alone (tested: renamed, six rows kept). Guest-facing picker copy unchanged.
- **Docs audit of the session** found the test-site database steps only in the chat — now in the brief, in order: SCF *Sync available* («Блюдо», «Раздел меню — списки блюд», «Гастробот»; delete the old «Раздел меню» group if listed) → `menu-seed.php all` → `page-seed.php pairings` → `media-topics.php`. Each safe to run twice (checked).

## Menu store decided — Б, the whole menu in, two lists — 23 September 2026

**Decision (author, after two usability sessions — `testing.md` → Decided):** option Б. Both participants chose it: harder to mix up dishes, and they change price / size / sometimes a description, rarely the layout; they would rather search than dive into А's nested repeater. Rationale, and А archived with how to bring it back: `website-brief.md` → Content editing → *Menu storage*.

- **Two lists** (author's question: "would it make sense to create 2 lists for Food and Drinks?" — yes): new post type **`drink`** («Напитки», `dashicons-coffee`, position 7) beside **`dish`** («Блюда», 6); `menu_list` relabelled **«Разделы меню»** (8), key unchanged. One field group for both (`group_sp_dish.json`, location dish OR drink — `scf_fields.group()` now takes a list of locations). A section's Relationship picker offers only its own type (`sweet_pepper_dish_relationship_query()`); `sweet_pepper_menu_item_type( $slug )` = drink for the seven bar sections. Tables: same columns and Quick Edit on both, plus a **«Раздел» dropdown** (`restrict_manage_posts`; `post__in` from the placements map; «— не в меню» lists unplaced items).
- **Every section reads the store.** A one-off extractor lifted the 247 typed `dish-row` calls (14 templates + Breakfast in `page-menu.php`) into `data/menu/<slug>.php`; each template's columns block is now one `menu-section-columns` call (−2,500 lines). The component learned three shapes the templates had: a **headerless list renders bare** (Infusions — no `menu-section__subsection` wrapper, so no extra 8px), **`divider`** starts a new pair of columns under `menu-section__coffee-tea-divider` (Tea & Coffee), **`note`** prints `menu-section__remark` under a subsection (Kids). Subsection fields gained `note_ru` / `note_en` / `divider`.
- **Russian twins** for all 247 rows: names and descriptions from `menu.md` where the print menu has the item; otherwise drafted to `russian-website-voice.md` and marked `// draft — not in menu.md` in the data file (all 57 spirits descriptions, most infusion / kids / coffee lines, new subsection titles, «Лето’26!» labels). Seeded, they are the RU default; refine them in admin against the page.
- **Seeded locally** (`tools/menu-seed.php all`): 16 records (Soups kept, 20 Sep), 91 dishes, 162 drinks. Records titled in Russian (Завтраки … Чай и кофе); the seeder renames an English-titled record it meets. Local DB backed up before the seed (session scratchpad).
- **Removed (А):** `menu_section` type, `group_sp_menu_section.json` + generator block + the row-only branches of `dish_fields()`, `sweet_pepper_menu_fill_dish_ids()`, `sweet_pepper_menu_store()` / `?menu_store=`, `sweet_pepper_menu_section_post()`, the seeder's repeater branch and `--dishes` flag. Last commit with А: `8b08196`.
- **Verified** (worktree theme rendered from the CLI against the Local DB, `template_directory` filter pre-seeded): templates → data files: markup identical on `/menu/`, `?menu=drinks`, `/en/menu/`, `/en/menu/?menu=drinks` (comments/whitespace stripped). From the database: EN identical except four typed values the number fields normalise — `+65-.` → `65-.` (Breakfast «+ veggie milk?»), `455-./ 645-.` → `455-. / 645-.`, `165 / 225-.` → `165-. / 225-.`, `3 / 5 pcs` → `3 pcs / 5 pcs`. RU: 91 / 162 rows, no row overflow, no name over one line, no subsection title clipped, no page overflow at 1440 and 402; Kids note, Tea & Coffee divider and add-on cards eyeballed. CLI: picker type per section, placements (253), Quick Edit save on a drink (applied, restored). **Not seen: the admin screens** — no login from the CLI.
- **For the author (RU findings, nothing changed):** prices differ from `menu.md` — Turkey roll 325 vs 345, Shrimp roll 325 vs 425, Robinson's Breakfast 335 vs 325; in `menu.md`, not on the site — fries / wedges 185, warm pasta salad 325, baked cod 555, Atxa vermouth 150, the Spritz trio 425, tea add-ons; placeholder English descriptions `'description'` on Ravioli and Horseradish (typo "Horseraddish"); Turkey and Shrimp roll EN descriptions both say "chicken filling"; Chicken / Turkey / Salmon Club are all «Классика жанра» in `menu.md`, so three dishes share one Russian title in «Блюда»; `menu.md` scan errors read as «Xepec» → Херес, «Тарараса» → Tarapaca; icons `egg`, `fish`, `spicy-1` (no such files, never rendered) dropped. The section headlines, eyebrows and deal cards are still English on `/` — template copy, not the store.
- **Test site after deploy:** SCF → *Sync available* («Блюдо», «Раздел меню — списки блюд»), then `cd ~/repository-test && WP_ROOT=~/SweetPepper-test/public_html php tools/menu-seed.php all`. The deleted group «Раздел меню» (А) may linger in SCF's list there — delete it by hand if it does.

## Home RU draft — voice pass, 23 September 2026

Refined `home-copy-ru-draft.md` against the author's posts/voice guide and connector discussion. Preserved the six connectors already edited by the author, hero headlines, dish ingredients, booking/form and status copy. Revised hero supporting lines, highlights introduction, infusion descriptions, the whole-About teaser, social-offers introduction and navigation descriptions; filled the previously confirmed email. Review rationale and an explicitly unadopted voice-rule exception appended to `home-copy-ru-review.md`; conversation findings added to `russian-website-voice.md`. Draft proposals only: no theme, CMS, SVG, Figma or EN edits, and no visual-fit verification. Older connector inventories are historical; the current Home RU sequence is in the clean draft §9.

## Deploy: field changes travel as a file — 22 September 2026

SCF values stay in each site's database, so today's About edits (hero headline split into two fields, the RU invitation copy, the author's seven RU edits) would not reach the test site with the theme. `tools/field-update.php <file>` applies a dated set — `tools/field-updates/2026-09-22-about-ru.json` — group by group, all-or-nothing, and only where every field still holds its expected old value; anything edited in admin since is SKIPPED and printed, a group already applied reports "done" (run twice locally: all "done"; a wrong old value: SKIPPED, field untouched). Keys follow the generator (`field_sp_` + name), so it also writes the new `about_hero_headline_2_*` before anyone has saved the tab. Also: `russian-website-voice.md` brought up to date (all nine About connectors on the page; «Перец» confirmed as the bar's short name). Left out of git: `Sweet posts examples.pdf` (source of the voice guide — contains private trainee feedback).

## Perks stamps — hover and pressed — 22 September 2026

`about.css` → stamp. **Hover** (hover devices): leans 8° (was a half-straighten to 2°, which read as less motion), rises 6px (`--lift`, composed in the one transform: translateY · rotate · scale), label takes the ring colour, and a glow in the stamp's own colour — the dark-card hover (`0 0 16px` at 50%) with `color-mix(… var(--stamp) 50%, transparent)` where cards use Lime; glow ≥768 only (the phone layout draws the ring on the icon). The selected stamp stays upright and keeps its own glow, it only rises. **Pressed**: the dark-card recipe — border solid in the stamp colour + `inset 2px -2px 8px` at 25% — plus the stamp goes flat, drops its lift, 0.94; label in the ring colour; on phones the same lands on the icon ring. A `:not(.is-active):active` twin matches the hover rule's weight (first pass: pressing a hovered stamp kept the 8° and the glow). Verified by computed style at 1440 and 390. Note: the inset shadow is near-invisible on Peppercorn with a transparent stamp — the solid ring and the scale carry the press.

## Author's RU About copy edits → SCF — 22 September 2026

Seven edits from `about-page-copy-ru-draft.md` written to the About page's RU fields (each only if the field still held the old draft text — none had been edited in admin) and to the typed fallbacks in `data/about/`: hero lead (`about_hero_lead_ru`), Bar × Kitchen text, Story p1, founder caption («Основатель, 18 лет за баром.» — the period kept, as the EN twin has it), Guests text, Team eyebrow «ЗНАЮТ, ЧТО ВЫ ЛЮБИТЕ», Careers text. EN untouched. Checked on `/about/`: all seven print; the longer hero lead keeps the connector on screen at 1440×900, 1280×720, 1024×768, 820×1180, 390×844. Review notes to the author: «чуть слаще» and «Название» now open Story p1 and p2 both; «18 лет» vs the timeline's 2009 (17 years) and it goes stale yearly; phone line breaks «бокальчик-/другой» and a hanging «с».

## About hero headline — two lines on tablets and phones; perks row — 22 September 2026

- **Hero headline = two fields**, as Figma draws it (sectionTitle 2559:70744: SHAKE & COOK / SINCE 2014). `tools/page-field-groups.py` → «Заголовок · строка 1 / строка 2» (`about_hero_headline_2_ru/_en` new; regenerated `acf-json/group_sp_about.json`, only the hero fields changed). `sweet_pepper_about_hero()` reads both through `sp_headline()`; `hero.php` prints two spans in the one `<h1>`. Desktop: they run on as one Chili line (unchanged look). ≤991: stacked, line 2 Paprika — the section-header's two-colour title. The band's `text-wrap: balance` is gone (it only kept the year from being orphaned; the break is now authored). Typed copy + DB split where the value still matched: RU «Shake & Cook» / «с 2014 года», EN "Shake & Cook" / "Since 2014". Checked RU 390 / 1440, EN 820.
- **Perks detail row, tablets:** `.about-perks__detail` `align-items: flex-start` in the 768–991 band (author). The description wraps to two lines there; centred, the ——— TITLE - - - header floated to its middle. Phones were already top-aligned (column); desktop is one line, unchanged.

## How it feels — Russian cloud words and review links — 22 September 2026

- **Cloud words, RU.** Each word in `template-parts/about/how-it-feels.php` gains `'ru'`; the English `text` stays the key that quotes link to (`data-key` / `data-word`), so the JS and the fields are untouched. Base: the RU heading word per quote in `about-reviews.md`, as adverbs (the cloud answers КАК ЗДЕСЬ БЫВАЕТ). Cyrillic Molot runs ~40% wider than the English set: with the ledger words as they are, 1440 dropped 3 words ("no room in the field") and two spilled out. Swapped the widest for shorter words the quotes also support — ГОСТЕПРИИМНО → РАДУШНО, РАСПОЛАГАЮЩЕ → ТЕПЛО, ПО-ДРУЖЕСКИ → ДРУЖНО, ВОСХИТИТЕЛЬНО → ЧУДЕСНО, ДОБРОЖЕЛАТЕЛЬНО → ВЕЖЛИВО; ЛЮБИМО → ДУШЕВНО for sound. Table with the basis per word: RU About draft §3. Checked: 1440, 1280, 820 and 390 place every word. A trial of an area-based height floor on the desktop field (as phones have) was reverted: 930px tall at 1440, and it grew the English section too.
- **Pre-existing, not fixed: 992–1100px.** The cloud column is 340 wide there; English already drops 4 words at 1024, Russian drops 6 (ДРУЖЕЛЮБНО alone is 365 at 56px).
- **CTA gap:** `.about-how-it-feels__cta` margin-top 24 → **48** at ≥768 (author); phones keep 36. Rebuilt.
- **Cloud pile below ~1200px, both languages — fixed by scaling the words (author's pick, 22 Sep).** The quote column is a fixed 540, so the cloud column narrows below ~1280 (327 at 1006) while the words didn't; words with no free spot were parked on the field's centre — RU 6 at 1006, EN 3. `about.css` (≥768): `.about-how-it-feels__cloud` is an inline-size container; tiers `clamp(40px, 10.53cqw, 56px)` / `clamp(26px, 6.77cqw, 36px)` / `clamp(18px, 4.51cqw, 24px)` — 56/36/24 from a 532 column up, the phone sizes as floors, tier ratio kept. No JS change: the script measures rendered words and already re-places on resize. Checked RU + EN at 992, 1006, 1100, 1239, 1440, 820 (tablet, 56 — unchanged) and 390 (phone sizes untouched): 0 piles. The idle drift still lets a pair touch now and then (RU 992; EN 1440 did before).
- **Review link on RU cards:** «Yandex · Читать в источнике» (draft wording), the same slot and class as EN "· Russian original"; no aria-label override in RU, the link text says it all. String in `languages/ru_RU.l10n.php` ('Read the review').

## About Visit CTA — default RU copy — 22 September 2026

The last About section had no RU twin: the Russian page borrowed COME SIT WITH US. Now **ДО ВСТРЕЧИ В ПЕРЦЕ** + body (`data/about/cta.php` → `ru`; seeded into the empty `about_cta_headline_ru` / `about_cta_body_ru` only, EN fields untouched) and the buttons in `languages/ru_RU.l10n.php`: Get your table → **Забронировать** (as on home), See the menu → **Смотреть меню** (the Visit CTA uses the same string, so it changes there too). Checked on `/about/` at 1440 and 390, `/en/about/` at 390: headline one line on desktop, two on phone; buttons fit. The RU draft §10 is no longer marked deferred; it carries two alternatives, including one that deliberately breaks §1.1. Open: evenings + weekends (EN About) vs Friday–Saturday evenings (RU home). EN "The room is small" sits beside "two rooms" in Location.

## About hero under the admin bar; Guests CTA label — 22 September 2026

- **Hero connector below the fold, logged in only.** The 32px WP admin bar pushed the `100vh` About hero down, so ЗДЕСЬ МОЖНО ВСЁ (and BETTER TOGETHER on `/en/`) sat ~32px under the fold at desktop widths; visitors never saw it. `about.css`: `body.admin-bar .about-hero` at ≥992 takes `calc(100vh - admin-bar height)`, as home and menu heroes already did; ≤991 keeps its own rule. Checked at 1440×900 and 1690×930 with the admin-bar class: connector ends at the viewport floor. Rebuilt.
- **Guests CTA, RU:** «Смотреть фотоальбомы» wrapped to two lines → **«Фото в VK»** (`languages/ru_RU.l10n.php`; EN unchanged).
- **«Перец» is the bar's short name** (author): RU connector alt now «Все дороги ведут в Перец»; the RU About draft's open note on it is closed.

## About RU connectors wired — 22 September 2026

The author's nine RU exports (`sweet-pepper-theme/assets/sectionLinks/about/ru/`, 8 words + 8 reflections + ЗАБЕГАЙТЕ НА ОГОНЁК word-only) rasterised and checked: wording matches the RU draft, each file's fill/outline pairing matches its EN twin. `template-parts/about/connector.php` now swaps the EN stem for `ru/<stem>` and the RU alt on a Russian request; the About templates are untouched. Verified on the Local site: `/about/` prints the nine RU words, `/en/about/` the EN ones; all 17 RU files resolve via `file_exists`; Cyrillic Molot renders; live-text sizes 48–88px at 1120, 16–29px at 370 (EN 65–101). Docs: RU About draft (rows 8–9 uppercased, wiring note, measurements), `connector-copy.md` (rows 8–9 filled, row 9 EN corrected to NOW IT'S YOUR TURN), brief.

## Careers connector — 22 September 2026

Recorded ТВОЁ МЕСТО В КОМАНДЕ as the author-selected RU Team → Careers connector in the inventory, RU About draft, voice guide and brief. The section headline and other copy remain unchanged. Documentation only.

## About team connector - 22 September 2026

Recorded ЗВЁЗДЫ КАЖДОЙ СМЕНЫ as provisional in the connector inventory, RU draft, voice guide and brief. Includes floor, bar and kitchen; preserves personal-apron context. Final review remains open. No website or asset changes.

## Russian voice reference and About connector choices — 22 September 2026

Created `russian-website-voice.md` in Russian for editorial handover, based on the 35-page author-supplied post collection and connector conversations. Separates public-facing examples, draft alternatives and private trainee feedback; records vocabulary, affectionate exaggeration, guest participation and practical editing guidance. The author sees the trainee as a likely future website maintainer. Recorded the first five provisional RU About connectors, including ГЛАВНЫЕ ГЕРОИ ЗА СТОЛИКАМИ, and preserved all four story candidates sent to Iurii. Updated connector inventory, RU About draft and links in design/brief. The stricter first-person rule is explicitly unresolved, not silently amended. No theme, CMS, Figma or SVG edits.

## Pairings record and the Russian UI strings — 21 September 2026

- **«Подбор пары»** — `pairings` post type (`inc/cpt.php`, one record, `create_posts` denied), `group_sp_pairings` (generator), `inc/pairings.php` rewritten to read it (typed fallback `data/pairings.php`, Russian from `menu.md` + the draft), `sweet_pepper_pairing_index()` now honours «Открывается первой». Temporary copy fields for dish and drink — the brief records why and what replaces them (Content editing → Picker pairings). `dish-picker.php` takes photo URLs (attachments via `sweet_pepper_photo_url()`), its four strings wrapped in `__()`. Seeded: record 55, six pairs, 12 photos. Checked on About and the menu page's pairing station, both languages, fallback and seeded; a tag click through the JS swaps dish, photo, reply and link.
- **Fixed in passing:** `dish-picker.js` built "See this drink" from `location.pathname` — right on `/menu/`, wrong on About (`/about/?menu=drinks#…`); now `spLang.root + '/menu/?menu=drinks#' + section`.
- **`languages/ru_RU.l10n.php`** (new) + `load_theme_textdomain()` in `functions.php`: the About buttons and labels, picker, header chip and drawer title, a11y boilerplate. The nav labels and drawer descriptions are wrapped in `__()` (header, footer, drawer) and still English — no Russian in the drafts. Checked: `/` prints Всё меню · Написать команде · Отправить резюме · Построить маршрут · Смотреть фотоальбомы · ВАМ СЮДА · Что нового · Забронировать; `/en/` unchanged.

## About extraction — the whole page, ten tabs — 21 September 2026

Author's call: finish About today, test tomorrow. Everything the *About fields* table promised is built and seeded in both languages (`website-brief.md` → About fields → *The whole page*).
- **`tools/page-field-groups.py`** rewritten as one block per section in page order, with `tab()` / `hint()` / `repeater()` helpers; Careers and Team keys unchanged (asserted — their saved values survive). 115 fields.
- **`inc/about-data.php`:** `sweet_pepper_about_rows()` (saved rows, or typed rows in repeater shape) and `sweet_pepper_about_text()` shared by the eight new functions — hero, concept, reviews (+ `sweet_pepper_about_fill_quote_ids()` on save), perks (colour dealt by position), story (third milestone year = `date('Y')`), guests (first eight), location, cta; plus the one-time removal of the hand-clicked hero group's database copy (`sweet_pepper_about_group_folded` option). `acf-json/group_6aa221f88c4c6.json` deleted.
- **`data/about/`:** hero, concept, reviews (generated from the template's own array — 20 cards verbatim), perks, story, guests (generated + the draft's captions), location, cta. **Templates:** all eight parts take args; `page-about.php` resolves `$about_id` once. The Perks stamp ids are now `<icon>-<index>` (nothing keyed on the old ones — checked).
- **`tools/page-seed.php`:** one generic path (`sp_seed_about_tab()`, `sp_seed_rows()`) for every tab; `about` seeds all. Re-seeding Team and Careers through it produced byte-identical records (JSON compared). 23 attachments.
- **Verified:** fallback render (before seeding) and seeded render on `/` and `/en/` — every headline, the stamps, milestones (2009 / 2014 / 2026), counters, quotes (20, ids y01…y15), guest pills, the CTA; no PHP notices; 32 upload URLs per page after seeding; screenshots of hero, concept, perks, story, guests, CTA at 1440 and 375 in Russian, perks in English. Div depth clean on every part.
- 🔶 The 12-card cap vs 16 words, and undated cards — the author's call (brief). The stale "TWELVE YEARS" ledger label is now a two-line field pair, editable, not computed.

## About extraction — the Team tab — 21 September 2026

Second tab of `group_sp_about` (`website-brief.md` → About fields → 7 and *Team as built*). Both languages seeded and checked at once.
- **`tools/page-field-groups.py`:** «Команда» — header (no description), the wall repeater (table layout: photo 3:2 · year), the members repeater (block: photo · name ⇄ · since · chip select · role ⇄ · genitive name shown only for the «Пара слов от …» chip · message ⇄), min 6 / max 8, hints in Russian.
- **`inc/images.php`** (new): `sp-square` 600 / `sp-3x2` 900×600 hard-cropped; `sweet_pepper_photo_url( $id, $size, $fallback )`.
- **`inc/about-data.php`:** `sweet_pepper_about_team()`, `sweet_pepper_team_chips()`, `sweet_pepper_years_since()` (RU plurals), the parity validator. **`data/about/team.php`:** the typed copy, RU header and roles from the draft, since-years back-computed from the typed "· N years" (Kostya 2018, Lera 2019, Lenya 2020, Anton 2021, Stas 2018, Alex 2021, Max 2018, Johnny 2014).
- **`template-parts/about/team.php`** takes args; the wall's pin colour / tilt alternate by index instead of a typed `variant`. **`tools/page-seed.php about-team`** imports the photos (`sp_seed_attachment()`), 14 attachments.
- **Verified:** fallback and seeded renders identical in structure on `/` and `/en/`; tenure «8 лет» / "8 years"; chips «Спросите меня…» / «Мой выбор»; 23 upload URLs per page after seeding; `acf_validate_value` 6 → valid, 7 → rejected with the Russian message, 8 → valid; screenshots at 1440 / 834 / 375 in RU, 1440 in EN — the section is unchanged to the eye.
- 🔶 Open, in the brief: the `ask` chip's Russian is mine; portraits are 262px sources.

## Language on the URL — `/` Russian, `/en/` English — 21 September 2026

The routing half of the one-document model (`website-brief.md` → Content editing → Language model — the *what* and the checks are there). One file, `inc/lang.php`, no plugin:
- **`sweet_pepper_lang()` moved here from `inc/fields.php`** and reads the request URI (`/en/` or `/en` after the home path → `en`, else `ru`) — it has to answer before WordPress parses the request, because the locale is set first. `SWEET_PEPPER_DEFAULT_LANG = 'ru'` is the unprefixed URL; `SWEET_PEPPER_LANGS` maps codes to locales. Outside a request (CLI, cron) it is the default.
- **Rewrite twins** via `rewrite_rules_array`: `en/` + every rule, query + `&sp_lang=en`; `^en/?$` → the home. 337 rules in the database now, 169 of them twins. **Flushed by version**, not by hand: `init` compares `sweet_pepper_rewrite_version` with the constant and flushes once — bump the constant when the rules change.
- **`locale`** → `ru_RU` / `en_US` on the front end (admin, ajax and CLI keep the site language). No `ru_RU` core pack is installed, so nothing but `<html lang>` changes yet.
- **`home_url`** → `/en` in front, on an English request, for everything except `wp-json` / `wp-admin` / `wp-login` / `wp-content` / `wp-includes` / `xmlrpc`; the nine typed `/menu/…` and `/about` links in `front-page.php` now go through `home_url()`; the daypart engine's four `btnHref`s get `window.spLang.root` in front (printed in `inc/daypart-head.php` beside `spBar`).
- **hreflang** ru / en / x-default in `wp_head`; WordPress's own canonical follows the filtered permalink, so `/en/about/` is canonical to itself.
- **`sweet_pepper_lang_switch()`** replaces the two dead `<button>` pairs (header, drawer): the active code is a `<span aria-current>`, the other an `<a hreflang>` to the twin URL; `header.css` drops `cursor: pointer` and adds `display: inline-block; text-decoration: none` so the box is unchanged (checked, 1440, both languages).
- **Verified:** status codes, redirects, 404, both feeds and the news archive, link prefixes on home / About / Menu, `<html lang>`, hreflang, canonical, the pill's targets, Careers + Location + Soups in Russian on `/` and English on `/en/`, oEmbed / REST unprefixed, CLI context unchanged (`home_url` unfiltered, lang `ru`).
- **Owed:** the `navigator.language` first-visit nudge; page `<title>` twins; a `ru_RU` `.po` for the `__()` strings; the test site's `sweet_pepper_rewrite_version` option flushes itself on the first request after the sync.

## About extraction, first build — Careers + the shared Location headline — 21 September 2026

Plan, field table and open items: `website-brief.md` → Content editing → *About fields*. Decisions the same day (author): fields live **on the About page** (tabs per section), not on new records; **lists first, prose after**; team 6 or 8 members, no hide switch; one Location headline for three pages; **the shared-record language model stays — Polylang displaced** (Plugin cap → 2), back only if the theme can't handle something.
- **Generators:** `tools/scf_fields.py` (new) holds what the generators share — `field()`, the presets, `group()`, `write_groups()`; `tools/menu-field-group.py` imports it (**its three groups came out byte-identical** — "unchanged" ×3); `tools/page-field-groups.py` (new) writes `group_sp_about.json` (Page Template = About; one tab so far, «Вакансии») and `group_sp_location.json` (Bar Settings, under the hours). `twins()` = an RU / EN pair at 50 / 50; `section_header()` = eyebrow, headline 1–2, description.
- **`inc/fields.php`** (new): `sweet_pepper_lang()` — the one answer to "which language", `'en'` until the URL decides; `sweet_pepper_pick()` (the menu's twin pick, shared); `sp_field( $name, $fallback, $post_id )`; `sp_headline()` — both lines from one language; `sweet_pepper_typed()`. `sweet_pepper_menu_lang()` now returns `sweet_pepper_lang()`, and the three templates that asked `get_locale()` (`about/how-it-feels.php`, `visit/hero.php`, `visit/location.php`) call it too — no visible change (the site's locale is `en_US`).
- **Careers:** `data/about/careers.php` (typed copy — fallback and seed source), `inc/about-data.php` → `sweet_pepper_about_careers( $page_id )`, `page-about.php` passes the result as args, `template-parts/about/careers.php` no longer holds content or a `$has_openings` switch: **no visible role is the empty state**. Typed roles stand in only while the repeater has never been saved (`metadata_exists`). A card prints "View role on hh.ru" only with a link (the placeholders' `#` links are gone). Departments are a select, EN twins in `sweet_pepper_about_departments()`.
- **Location headline:** `data/location.php`, `inc/location.php` → `sweet_pepper_location_headline()`, read by `about/location.php`, `menu-sections/location.php` (its "at the very heart" → **"in"**) and `visit/location.php`. `location.css`: `.location__title-mid` and the per-breakpoint span swap deleted; two typed lines are the break below 992, and from 992 they flow as one sentence.
- **`inc/acf-setup.php`:** the owed purge hook — `acf/save_post` on `options` → `wp_cache_clear_cache()` when WP Super Cache is there.
- **`tools/page-seed.php`** (new): `about-careers`, `location`; leaves a saved target alone without `--force`; ~~writes English and author-approved Russian only~~ **since the same evening writes the RU draft as the default Russian copy (author)** — `data/about/careers.php` → `ru`, from `about-page-copy-ru-draft.md` → 8. Работа; re-seeded locally with `--force` after checking the record was untouched since the first seed. Seeded locally: page 9, three roles in both languages; Bar Settings headline in both languages.
- **Verified (local, headless Chrome + CLI):** before seeding — typed fallback on all three pages, no PHP notices; after — same markup from fields. Careers at 1440 and 375 with 3 roles; 4 roles; every role hidden → the no-openings box; zero saved rows → the box, not the placeholders; restored with `--force` and re-checked. Location: two lines at 834 and 402, three at 1440 on About and Menu (as before the change), two on Visit. PHP lint and div-depth clean on every touched template. **Not seen: the admin screens** — no login from the CLI.
- **Russian render checked once** (`sweet_pepper_lang()` flipped to `'ru'` for the shots, then put back): Careers holds at 1440 / 834 / 375 — one-line headline, no borrowed THE FAMILY?, cards and pills fit; the CV row's button stays English (a `.po` string).
- ~~🔴 Found — the shipped Molot has no Cyrillic~~ **Fixed the same evening:** `tools/molot-webfont.py` (new; needs `fonttools` + `brotli` in a venv — not installed on this Mac) builds `src/fonts/Molot.woff2` + `Molot.woff` from `design/fonts/Molot.otf`, with the kit's vertical metrics, a codepoint for "%" and the nbsp / hyphen aliases restored; `main.css` `@font-face` → woff2 then woff. Verified: 398 Molot runs × (home, About, Menu, Visit) × (1440, 375) before / after — no line count, height or baseline changed, widths +0.07% at most; Russian Careers and Location render in Molot. Real Russian widths and what they mean for the Location headline: brief → About fields → Open. `src/fonts/Molot-webfont.woff` is no longer referenced (left on disk; a copy stays in the kit). `design/fonts/Molot.otf` is tracked, so the script re-runs from a clone.
- 🔶 **Found — the Location headline can't hold two lines on desktop at any wording tried** (copy column 472 at 1440, 337 at 1100, against 627 / 571 for the two lines; the Russian 662 / 735). Dropping "very" fixes phones only. Figures and the two layout ways out: brief → About fields → Open.
- 🔶 **Found — four roles break the Careers row** (262px cards; the schedule runs into the pill). Cap or wrap — open in the brief.
- **Next:** author's first look at «Вакансии» and Bar Settings in admin → Team (6 / 8, even-count validation) → Guests → counters → quotes (trim 20 → 12 first) → prose tabs; the hand-clicked hero group `group_6aa221f88c4c6` folds into the Hero tab then. Language routing (rewrite rule, `locale` filter, head tags) is its own step.

## Home Highlights headline shortened; phone headline line-count sweep — 21 September 2026

**Copy.** Home Highlights `headline_2` "& LOCAL FAVOURITES" → **"& LOCAL HITS"** (`front-page.php`), so the pair holds two lines on every phone (it ran three — "& LOCAL" / "FAVOURITES"). Synced in `home-copy-en.md` and `home-copy-review-en.md`. *Open: the review doc's rationale still argues "local favourites" over "community hits", and the card below carries the "Community hit!" badge — one noun, two modifiers in one section; the RU draft's "И ЛЮБИМОЕ" tracks "favourites", not "hits".*

**Sweep.** Every Molot run >= 24px on all four pages (the menu measured with all 9 food / 7 bar sections forced visible — 117 and 91 runs), visual lines counted from client-rect tops at 360 / 375 / 390 / 402 / 430. **Exactly one headline takes three lines: the Location title.** At 36px "at the very heart" measures **359px** and "in the very heart" about 353, against columns of 328 / 343 / 358 / 370 / 398 — so Menu and About break at <= 390, Visit at <= 375, and all three are two lines from 402 up. That is why the 17 Sep fix read as done: it was checked at 402. Everything else tops out at two lines, all intended: About hero "SHAKE & COOK SINCE 2014", menu "Summer Menu Highlights", "THE DREAM GUESTS" (one line from 402), "COME SIT WITH US" (two at 360 only) and the three closed-hours hero headlines.

## Test-site round — reflection widths, drawer type, Shake It!, How it feels — 21 September 2026

Five findings from the author's phone and iPad on test.sweetpepper.bar.
- **Reflections narrower / wider than their word (home, day, iPhone + iPad).** Not layout (boxes identical, 370.0 at 402), not the files (ink fills each viewBox; server copies byte-identical), not reproducible in Chrome at any width or pixel ratio — a WebKit paint fault, amplified by the format: a ~14:1 SVG fitted with *meet* loses ~14px of width per pixel of missing height. Forcing the reflection's box 0.86px short in Chrome draws it at 357px from x=22 — the iPhone screenshot's numbers. Day only because the day word's viewBox is 2 wider than its reflection's (2px vs 1px stroke) so the two err differently; night pairs share a viewBox. **Fix:** `preserveAspectRatio="none"` on the root of all 93 files in `assets/sectionLinks/` — the word always spans the box; verified in Chrome that a short box now paints the full 370. **Owed: the author's eyes on the phone** (private tab — the SVG URLs are unversioned); re-add the attribute after any Figma re-export (`website-brief.md` → Section connectors).
- **Drawer descriptions:** Body 16 / 0% from 768 (`mobile-drawer.css`), Caption stays on phones; icon pad 7 → 9 with the taller line. Supersedes the 20 Sep "every drawer width"; noted beside `design.md` §3.3.
- **Shake It! 64 / Symbol 32 in the 768–991 band** (`dish-picker.css`): size and icon are now `--shake-size` / `--shake-icon`, the centring offsets read them. Measured on About and Menu: 48 / 40 / 24 at 402 and 1440, 64 / 56 / 32 at 768 and 991, dead centre on the photos' seam in all eight.
- **How it feels, quote rail (< 992):** neighbours showed as slivers under short quotes. `sizeViewport()` sets `--quote-slot` (viewport height − 8) on the track and `.about-quote-card__wrap` takes it as `min-height`; with every quote centred in turn the nearest neighbour stays 24px outside at 402, 375 and 834.
- **How it feels, phone cloud:** words placed by the spiral's inset-0 fallback orbited past `overflow: hidden` (PERFECT −3.1px at 402; four words at 375). Phones now `overflow: visible`.
- **How it feels, second pass the same day (author): the chosen word centres on phones, inactive words at 50%.** The desktop commit switched on as-is collided on nearly every tap (WELCOMING × INVITING 148×9) — the 380px field was 67–76% full. `how-it-feels.js`: phone field height = 1.7 × the words' gapped area ÷ width (`FIELD_AREA_PHONE`; 435 / 469 / 490 at 402 / 375 / 360, and the 360 rest-state pile is gone); `commitField()` now tries a chain (full centre, margin 12 → 4, then 60% / 30% of the way, then none) over a `solveCommit()` that clamps no tighter than a word's home and asks no pair for more gap than it rests with; phones calm the orbit to a third while a word is chosen and cap each rest orbit at half the nearest gap. Tap-tested all 16 words at 402 / 375 / 360: no overlaps; rest: ≤ 2px of box over 12 s. `about.css`: `.has-focus` dim 0.3 → 0.5, every width. **Cost:** cloud + card no longer fit one screen on 375×667 / 360×740 (701 of 591, 722 of 664) — flagged in the brief. Parameters came from a Node port of the placement + commit maths swept over 288–398px, not from rebuild-and-tap.
- **How it feels, third pass (author: fewer words on phones):** the simulation says width, not count, costs height — the four small words are filler, the four widest mids (WONDERFUL, CHARMING, PLEASANT, MAGNETIC) are the saving: field 380 / 410 / 429 at 402 / 375 / 360 (sixteen words: 435 / 469 / 490). `how-it-feels.php`: `'phone' => false` per word → `data-phone="off"` on the word and on its quotes; `how-it-feels.js` removes those nodes at load below 768 (12 words / 16 quotes), `FIELD_AREA_PHONE` 1.7 → 2.0 for this list, and `measureAndPlace()` grows the phone field 20px at a time if a word can't be seated. Float range back to 7–12px per word (it had dropped to ~1.5px on touching pairs under the neighbour cap — the author saw it). Fits one screen at 360×740 (661 of 664), not at 375×667 (642 of 591; ten words would). Tried and dropped: a runtime search over heights and spiral start angles — 60–250 ms on this Mac, a second on a phone. The sweep lives in `tools/how-it-feels-field-sim.mjs`.
- **How it feels, cloud → card gap 0 on phones (author, on trial):** `about.css` phone block, `.about-how-it-feels__inner` gap 24 → 0; lowest word → card 59–77 → 35–53px (the rest of that blank is the field inset, the spiral's slack, the viewport padding and the slot centring — breakdown in the brief). Tablet keeps 24.
- **Prototype, not a decision — the hero's "now" word behind `?hl=1`** (`daypart-engine.js` `markNowWord()`, `hero.css` PROTOTYPE block at the file's end). Night ≤ 991: Cream / Lemon (every tablet, per the author). Day ≤ 991: `&hlday=green|red|red2|red3`. Desktop: `&hld=a|b|c|d` (b and c corrected the same day: the lit word is Chili in both modes — the author read a Paprika COCKTAIL as the unlit word). Without the flag nothing changes (checked at 402 and 1440, both modes). Pairs, contrast figures and the read of each in the brief → Mobile — home hero → Colour roles; contact sheet in `Claude outputs/headline-pairs-contact-sheet.png`. Also: the cloud hue comment in `about.css` quoted contrasts taken against white; recomputed on Parchment (Avocado 2.8 and Paprika 2.5 are under 3:1).
- **Dark Olive out of the build** — `design.md` §2.2 removed it in July and Figma lost it in August, but `variables.css` still defined `--dark-olive` and ten rules used it (`components.css` `.section-description`; `location.css` description + map ground; `about.css` light-section description, team card message, the night-pinned Location description; `footer.css` copyright (a raw hex), phone-layout links, hours day, phone number). All → `var(--peppercorn)`; token deleted; no reference left in `src/`. Visible change: body-size text a shade more neutral (12.8:1 → 16:1 on Parchment).
- **Shake It! wording corrected:** "the same on every width" was never the author's decision; the brief now says responsive.

## Menu storage — the dishes store, built for Soups — 20 September 2026

Second half of the brief's Soups test (`website-brief.md` → Content editing → Open → *Menu storage*; `testing.md`). Built as the **hybrid** — `dish` posts placed by ordered Relationship lists — because it contains the plain-CPT candidate: the «Б - Блюда» table *is* that screen. Both stores hold Soups at once and are independent; the decision is still the manager session's.
- **`dish` post type reworked** (`inc/cpt.php`): Russian labels («Б - Блюда»), **not public** (it had `public` + `has_archive` — live `/dish/` URLs with no template), revisions on; title = the Russian name, **Draft = off the site**, post ID = the stable id. **The Categories / Dietary Tags taxonomies are removed** — nothing read them and neither store uses them (section = the list, dietary = the icons field); they would have been two English no-op boxes on the form under test.
- **`menu_list` post type** («Б - Меню Макет») — `menu_section`'s twin: one record per section, slug = section slug, not public, revisions, admin-only creation. A separate type rather than a second group on `menu_section`, so both stores can hold Soups and location rules stay `post_type ==` (no database IDs in `acf-json/`).
- **Field groups:** `tools/menu-field-group.py` now writes three — the dish fields are defined once (`dish_fields()`) and used by the repeater row and by `group_sp_dish.json`, so the test compares structure, not forms; a post drops the three fields it has of its own (RU name, hide switch, id). `group_sp_menu_list.json`: subsections (same header fields) → a Relationship field, search filter only, returns IDs. `group_sp_menu_section.json` byte-identical (checked by diff).
- **`inc/menu-data-dishes.php`** (new): `sweet_pepper_menu_list_rows( $slug )` hands back rows **in the repeater's shape**, so `sweet_pepper_menu_subsections()` renders both stores through its one loop. Also: the Relationship picker and the «Б - Блюда» table show `220 г · 255-.` beside the name (Soups has two «Тыквенный суп» and two «Грибная кружка» — indistinguishable otherwise); table columns «Выход и цена» and «Раздел меню» (linked; «— не в меню» for a dish no list places — the hybrid's two-step add made visible), sorted A–Z; the two-icon validation.
- **Same-name dishes (author's question, same day):** size and price only separate the two «Тыквенный суп» for someone who knows the portions, and the leaf icon can't separate the two «Грибная кружка» (both veg, same subsection). What does, in every pair, is what the guest reads: the **description**. The «Б - Блюда» table gained an «Описание» column (RU) and «Раздел меню» now reads `Soups · вегетарианские`; the Relationship picker appends the first 40 characters of the description. **Carries over to store A:** the hand-built dish dropdown for highlights / previews / pairings will list the same twins and needs the same label.
- **Sidebar labels for the session (author):** «А - Меню Все в одном» (`menu_section`), «Б - Блюда» (`dish`), «Б - Меню Макет» (`menu_list`) — the letters group each variant's screens; the winner goes back to a plain name when the test is decided. **Sidebar order is set by `menu_position` 6 / 7 / 8** (А, Б - Блюда, Б - Меню Макет, between Posts and Media): the first build used 5 / 6 / 6, position 5 is Posts', and WordPress bumps a taken slot past its neighbours — А landed between the two Бs (author's screenshot). Блюда above Макет is a choice (most edits; create, then place), not a constraint.
- **Switch:** `?menu_store=dishes` (`sweet_pepper_menu_store()` in `inc/menu-data.php`) renders the dishes store; without it the page is the repeater store. Test-only — it goes with the losing store, before any page cache.
- **Seeder:** `tools/menu-seed.php soups --dishes` (same parsing; `--force` deletes the section's dish posts and recreates them). Seeded locally: list 24, dishes 25–30.
- **Verified:** Soups markup identical — baseline / repeater / dishes (diff). Through the CLI on the dishes store: price change, Draft hides a dish and keeps its place, reordering the list reorders the page, the repeater store unaffected; all restored and re-diffed. Field groups attach to the right post types; an Editor can edit dishes and cannot add a list. **Not seen: the admin screens themselves** — no login from the CLI; first look is the author's.
- **Removal, if the repeater wins:** `inc/menu-data-dishes.php` + its `require`, the `dish` and `menu_list` registrations, the two JSON groups and their block in the generator, the seeder's `--dishes` branch, the store switch. If the dishes store wins: `menu_section`, its group, `dish_id` filling, and `menu_list` is renamed into its place.

## Rail tremble — confirmed fixed; diagnostic code removed — 21 September 2026

The author confirmed on the phones: the plain URL is still, no switch needed. Removed all of the temporary `?debug=` code — the class-setting lines and their comment in `inc/daypart-head.php`, the *Diagnostics* block in `main.css`, the early returns in `reveal.js` and `menu-rail-nudge.js`; `?debug=all` now does nothing (checked: no `debug` string in the bundle or the served page). Also confirmed by the author the same day: the Lemon closed call button, the rail's entrance and 2.5 s nudge timing, the Visit page's phone number colour in Safari. `website-brief.md`'s rail paragraph rewritten from a three-attempt running account into the settled cause, the fix and three rules to carry. **What stays from the two attempts that weren't the cause:** whole-pixel rail geometry, and the sticky bar / scrolling row split — both correct in themselves.

## Rail tremble — found: a section-level `overflow-x: clip` — 21 September 2026

The switches did their job. On the author's phones **`?debug=noreveal` and `?debug=noclip` stop the tremble; `norail` and `noscrollanim` don't.** Common to the two: `.has-reveal { overflow-x: clip }`, which `reveal.js → arm()` added to the section of *every* reveal root. The clip is there for `mask-right` only (parked 100% to the right, it would widen the page); `rise`, `mask-up`, `mask-down` and `mask-left` cannot. `arm()` now tags a section only when the root or a nested reveal is `mask-right`. Result per page — home: bar-preview, about-preview · menu: pairing-station, location · drinks: pairing-station-bar, location · about: concept, story, team, location · visit: visit-map; no menu section. Verified at 402 / 768 / 992 / 1280 / 1440 on all five URLs, at load (everything parked) and scrolling through: `scrollWidth === innerWidth`, no `mask-right` element outside a clipped section. `#page`'s clip (≤ 991) stays — `noreveal` left it on and the rail was still; `?debug=nopageclip` added in case. *(Confirmed on the phones and the `?debug=` code deleted the same day — entry above.)*

## Rail tremble, round three — diagnostic switches — 21 September 2026

Splitting the sticky bar from the scrolling row (entry below) did **not** cure the tremble on the phones. The measurement stands — a sticky layer placed a few pixels off, in proportion to scroll speed, while the fixed header is still — so the working theory is now: **something makes WebKit commit a new layer tree from the main thread while the page is scrolling, and each commit places the sticky layer with a stale scroll offset** (a fixed layer has no scroll term, which is why the header never moves). The author suspects the nudge; it fits the mechanism but runs 1.1 s in every 2.5, and the first recording trembles continuously. Other things that work on every scroll frame in the rail's own section: the photo band's `band-drift` (a scroll-driven animation of a *custom property* driving `object-position` — main-thread in any engine; Safari 26 now runs `animation-timeline`, a Mac's Chrome keeps sticky on the compositor regardless), the connector parallax, `reveal.js`'s scroll listener, and two `overflow-x: clip` ancestors (`#page`, `.has-reveal`). **No simulator here, so the phone decides:** `?debug=norail | noscrollanim | noreveal | noclip` (comma-separated, or `all`) — `inc/daypart-head.php` sets `html.debug-*` before paint; `main.css` → *Diagnostics*, `reveal.js`, `menu-rail-nudge.js` honour them. Each verified locally to switch off exactly its own suspect. *(Temporary; deleted 21 Sep once the cause was confirmed.)*

## Menu rail tremble — the real cause; iOS phone-number colour — 21 September 2026

**Rail.** The whole-pixel fix (entry below) did not cure it: still trembling on two iPhones, Safari and Chrome. The author sent a screen recording; with no ffmpeg on this Mac it was served by a small Range-capable Node server, stepped at 1/60 s in headless Chrome and read through a canvas: rows carrying Chili ink → the wordmark 363–421 **on every frame**, the rail's word 540–552, 544 at rest — ±4 CSS px, tracking scroll speed. A sticky layer repositioned a frame late: WebKit handles `sticky` on the scrolling thread unless the element is also a scroll container. `menu-section.css`: `.menu-section-rail` keeps sticky / background / 8px padding and loses all overflow; `.menu-section-rail__nav` (was `display: contents` at every width) becomes `display: flex` below 992 and takes `overflow-x: auto`, `overflow-y: hidden`, the snap, the gap and the 16px lead-in. `menu-single-section.js → alignRail()` and `menu-rail-nudge.js` address the row. Regression: all 16 sections at 360 / 402 / 768 — rail 54, 8 above and below, word at the gutter, no page overflow; stuck top 76; a sideways swipe on the stuck rail snaps SOUPS to 16; reveal flows, entrance, nudge, reduced motion and 1280 unchanged. *(It was not the cause — the tremble persisted; see the two entries above. The split stays, it is the right structure.)*

**Rail timing, tuned on the phone the same day.** `menu-rail-nudge.js`: `EVERY` 5000 → 2500; the entrance no longer waits for 140 ms of scroll rest (momentum scrolling on a phone delayed it until the rail was already stuck) — it fires from a rAF-throttled scroll handler as the rail crosses 66% of the viewport. Simulated continuous scroll at 1500 and 720 px/s: entrance starts with the rail at 63–64% and all 172px of the photo visible, 19 frames before sticking at the higher speed; nudges at ≈ 2.8 / 5.3 / 7.8 s.

**Phone number.** iOS Safari auto-links phone numbers found in plain text, in its own colour: the Visit hero's "+7 (4852) 911-202" went near-black on Peppercorn. `header.php`: `<meta name="format-detection" content="telephone=no, date=no, address=no, email=no">` — every such line already has a real action beside it (tel: link, copy button, map link); `main.css`: `a[x-apple-data-detectors] { color: inherit … }` as a fallback. A Mac never does this, which is why Local looked right.

## Menu storage test — А rows compacted, Б prices in Quick Edit; closed call button Lemon — 20 September 2026

After the team's first look at both stores (price is the most frequent edit). **А:** `tools/menu-field-group.py` → `dish_fields()` lays a repeater ROW out as one line — **name 50 · price 18 · price 2 18 · hide 14** — and moves everything else into one closed accordion «Подробнее», the two sizes first (4 × 25). *(First pass kept amount and unit on the line at 8–9%: "300" read as "30" and «Выход 2» wrapped — author's screenshot, fixed the same evening.)* a `dish` post keeps its reading-order form. The hint above the rows explains the two prices, and the row's «Цена» is now **required** (all 233 dishes in the templates carry one); «Цена 2» only for a second size. Keys unchanged, so no values move — checked: Soups still reads 2 subsections, 6 dishes, ids intact. The generator now leaves an unchanged group's file alone (`modified` is what triggers SCF's "Sync available"), so only `group_sp_menu_section.json` changed. **Б:** new `inc/dish-quick-edit.php` — `quick_edit_custom_box` under the «Выход и цена» column, values handed over as `data-*` on a hidden span the column prints, `save_post_dish` with nonce + `edit_post` check writing by field KEY. Tested through WordPress on a real local dish: save applies (incl. "0,5" → 0.5), a nonsense price is dropped, a bad nonce and a plain save change nothing, values restored. Not checked: the Quick Edit panel in a browser (wp-admin needs the author's login). **Test site after deploy:** SCF → *Sync available* on «Раздел меню».

**Call button, closed state:** `.btn-call--closed` label and icons `#fff` → `var(--lemon)` — the primary button's pairing, and pure white is not in the palette. Lemon on Chili is 3.42:1 (white was 4.13:1) — the same figure every Reserve button already carries. Left alone: the busy state is still `#fff` on an off-palette orange `#E8751A` (3.00:1).

## Menu rail — tremble while stuck: whole-pixel geometry — 20 September 2026

Author, on the device: the stuck rail jitters 1–2px vertically while scrolling. Sampled per frame in headless Chrome during touch scrolls (DPR 2 and 3, 400+ frames): rail top 76, word offset 8, header bottom 76 — constant, so not layout; but the rail measured **53.8px** and the section photo **172.29px**. `menu-section.css`: rail items `line-height: 38px` (was 1.05) → rail 54.00; `.menu-section__hero` height `round(down, 100vw × 90 / 210, 1px)` behind `@supports`; rail `overflow-y: hidden` (it computed to `auto`). Verified at 402 / 390 / 375 / 360 / 768: rail 54, photo 172 / 167 / 160 / 154 / 329, `scrollHeight === clientHeight`. *(Not the cause — the tremble persisted; found 21 Sep, entries above. The whole-pixel geometry stays.)*

## Day reflections at full opacity below 992px — 20 September 2026

`components.css`: inside `@media (max-width: 991px)`, `html:not([data-theme="night"]) .section-link-word--reflection` → `opacity: 1`, excluding the menu page's four upright foot-word classes that borrow `--reflection` for their 50% (the list `reveal.css` already keeps). Tallied per page: home day 6 reflections 0.5 → 1 at 402 and 900; menu day 2 reflections → 1, 13 foot words still 0.5; night unchanged (1 on phones, 0.3 at 900); 1280 unchanged (0.5 / 0.3). About and Visit have no such elements — their live-text reflections were already at 1 on light grounds.

## Phone bento — equal row gap for every lit tile; night red on a contact sheet — 20 September 2026

`hero.css` (bento block): `.daypart-grid` gets `row-gap: 20px` (tablet block: 32) and `.daypart-tile.is-active` `margin-bottom: -8px`. Before → after, visible gap between the two photo rows: breakfast / lunch lit 18–20 → 18–20; **dinner / party lit 10–12 → 18–20**, at 360, 402 and 768. Grid height (333 at 402) and headline position unchanged, so taps don't shift the copy. **Night red:** the author found the night hero too red on phones (wordmark + headline + Reserve, over red photography). Five options injected into the live page — `Claude outputs/night-red-contact-sheet.png`. **On trial (author's call, after Cream was built first): night bento headline `var(--lemon)`, subhead `var(--parchment)`** — two `html[data-theme="night"]` rules in the bento block of `hero.css`; day unchanged (Chili / Ash), desktop unchanged (Chili both modes). Checked at 402 and 768 portrait: dinner `rgb(255,237,0)` / `rgb(243,233,210)`, lunch Chili / Ash; 1280 Chili. Open if it stays: the Now pill is Lemon too. *Earlier the same day:* the bento headline took `--text-highlight` — Chili by day, Cream by night; desktop stays Chili in both modes. Checked: 402 and 768 portrait lunch `rgb(227,67,20)` / dinner `rgb(255,246,137)`, 1280 Chili both, and a tap from lunch to party flips it. Contrast re-computed: Cream 16.5:1 and Lemon 15.3:1 on Peppercorn. Reasoning against Lemon in `website-brief.md` → Mobile — home hero → Colour roles.

## Header controls equal; home hero keeps its air on short screens — 20 September 2026

Two findings from the test site on an iPad Air (landscape). **Header:** `.header-utils` → `align-items: stretch`; the What's new chip now matches the language switch (40.4 / 40.4 by night, was 34 / 40.4). Figma `additional` 1048:36376 draws them 32 and 36 — not equal either; flagged in the brief. **Hero:** `.hero-content` gets `padding-block: var(--hero-air)` (32px) and `.daypart-tile --tile` a height limit, `max(168px, calc(100vh - 612px))`. Measured header → eyebrow / CTAs → foot word, before → after: 1440×900 64 → 64 · 1280×800 14 → 32 (tile 224 → 188, still one viewport) · 1280×720 0 → 32 · 1180×820 35 → 35 · 1180×690 (the iPad Air with Chrome's bars) 0 → 32 · 1133×744 2 → 32 · 1024×768 27 → 34 · 1024×650 0 → 32. CTAs in view at every size. Phones and the portrait bento are untouched (their own block sets the tile geometry).

## Menu rail — entrance + idle nudge applied — 20 September 2026

The `?rail=` prototypes are chosen and built in: **both**, by default, flag removed (`src/js/menu-rail-nudge.js`, called from `main.js`; CSS in `menu-section.css` → `.is-parked` / `.is-entering` / `.is-nudging`, `@keyframes rail-enter`, `rail-nudge`). Entrance once per section when the rail is above 66% of the viewport and the scroll has rested 140 ms; nudge every 5 s for an untouched rail, never within 5 s of the entrance; both end for the visit at the first touch (`sessionStorage spRailLearned`). Verified on the plain URL, food and drinks: parked at the top of the page and at 85%, entering 260 ms after coming to rest at 50%, nudges at ≈ 5.3 / 10.3 s, none after a touch; nothing parked under reduced motion or at 1280. Spec: `website-brief.md` → Mobile — Menu page → the rail; Motion language → the fourth "stops for good" exception.

## Menu rail — the current word is the nav word; idle-nudge prototype — 20 September 2026

Found on the test site (iPhone): in the phone rail "SANDWICHES & BAGELS" filled the row, no next word peeked, and the word differed from the one tapped. `menu-section-rail.php` now prints both the desktop headline and the nav label inside the `<h2>` when they differ (`.menu-section-rail__long` / `__short`); `menu-section.css` shows the short one at ≤ 991. Affects Sandwiches, Salads, Kids; desktop unchanged (checked). Next-word peek measured for all 16 sections at 402 and 360: ≥ 104px everywhere. **Prototypes, flag only — `?rail=nudge | enter | both`** (the second and third added later the same day). `enter`: the first time each section's rail is in view, the links after the current word play `rail-enter` (from 72px / opacity 0, `--dur-gentle` on the spring, 80 ms stagger via `--rail-i`), once per section per page load, re-checked on scroll and on `reveal:check`; sampled: starts at 72px, settled by ≈ 330–400 ms, does not replay on return. `both`: entrance, then nudges at 5.0 / 10.0 s; nothing after a touch. **Entrance timing fixed after the author's first look** (it played while the rail was still at the fold): it now needs the rail above 66% of the viewport height *and* 140 ms without a scroll event, and the arriving links are parked (`.is-parked`: opacity 0, +72px) from init so they don't blink out first; a touch un-parks everything. Checked by placing the rail at 95% / 85% / 60%: parked, parked, enters 140 ms after coming to rest. `nudge` — `src/js/menu-rail-nudge.js` + `@keyframes rail-nudge`: the rail on show slides 14px left and back every 5 s (first at 2.5 s), stops for the visit at the first touch / wheel / key on a rail (`sessionStorage`), never under reduced motion, above 991, off-screen or at the rail's end. Sampled per frame: bursts at 2.0 / 7.0 / 12.0 s, −14px, `scrollLeft` untouched; none after a touch, without the flag, or with reduced motion. Not decided — see `website-brief.md` → Mobile — Menu page → the rail.

## Menu rail — equal padding above and below the words — 20 September 2026

`menu-section.css`: `.menu-section-rail` padding `8px gutter 0` → `8px gutter`. Stuck under the header the band now has 8 above and 8 below the words (measured; rail 46 → 54px, the figure the brief already quoted for the sticky cost). Unstuck the eyebrow sits 8px lower — accepted by the author. Figma's rail is 46: re-sync the frame.

## Reveal engine — a parked headline could stay parked (menu rail with no current word) — 20 September 2026

Author's report: in Chrome the phone rail showed no active word. Two holes in `reveal.js`, both about the page changing under a still viewport:

1. **A root that loses its box.** At desktop width the menu headline's reveal root is its wrapper, `.section-title`; at ≤ 991 that wrapper is `display: contents`. Load wide, go narrow (DevTools' device toolbar — or a tablet turning from landscape to portrait) and the root is armed but box-less; `check()` skipped box-less roots forever, so the `<h2>` inside stayed at `translate: 0 100%` behind its clip. Now an **armed root without a box is released** (handed back unplayed — the file's own rule: "if a resize shows it later, it is simply there").
2. **A section switch fires no scroll.** Every phone section lands on the same scroll position, and the engine only looks again on scroll / resize / load. `menu-single-section.js → show()` now dispatches **`reveal:check`**, which `reveal.js` listens for.

Reproduced first (headless: load at 1280 → 450 → `#breakfast`: `is-armed`, clip `inset(0 -24px 100%)`), then re-run: fixed, along with rail taps, the hero commit button, hash loads and the away-and-back path. Regression at 1280 on all four pages: reveals still arm at load (45 / 53 / 83 / 15), play on scroll, nothing left parked in view.

## Nav drawer — descriptions to Caption, icon centred on the text — 20 September 2026

Found on the test site: the drawer's item descriptions (Body 16) wrapped to two lines on phones. `mobile-drawer.css`: `.mobile-drawer__link-desc` → `var(--text-caption)` / 4% tracking, `text-wrap: balance`, 4px bottom pad; `.mobile-drawer__link-icon` bottom pad 8 → 7 so the 12px icon centres on the description's last line (measured 0.1px off, every row, every width). `mobile-drawer.php`: "late‑night" with U+2011. One line per item at 402 and 768; **still two lines at 360 (About, Menu) and 320 (+ Visit)** — the list is 312px and the copy needs 327 / 337; shorter descriptions are a copy-review question. `website-brief.md` → Top nav → Mobile.

## Home contacts — message buttons shortened — 20 September 2026

Found on the test site: on phones "Message on VK · Message on Instagram" overflowed the two-up row in the home Contacts block (the Instagram icon hung outside its button). `front-page.php` now uses the labels the nav drawer, the reserve drawer and the Visit CTA already carry — **VK message · Instagram DM**. The nav drawer's "Vk Message" was the one odd casing of the four; aligned to "VK message" (`mobile-drawer.php`). The row only renders below 768, so nothing changes on desktop. Measured at 320 / 360 / 402: one line, no overflow (136 / 156 / 177px buttons). `home-copy-en.md` updated; RU has no line for these buttons yet.

## Bar hours settings — regular week — 20 September 2026

The door hours left the code. **Bar Settings** (SCF options page, empty until now) has four time pickers — opens Mon–Sat, opens Sunday, closes Sun–Thu nights, closes Fri/Sat nights (`acf-json/group_sp_bar_hours.json`, RU labels). Defaults 08:30 · 10:00 · 02:00 · 02:00 live in the code, so with nothing saved the site is unchanged. Spec, reasoning and the holiday repeater (specified, not built): `website-brief.md` → Platform → *Bar hours settings*.

- New `inc/bar-hours.php` — `sweet_pepper_bar_hours()` (minutes; a close after midnight is stored past 24:00; per-field sanity check with fallback), `sweet_pepper_bar_hours_rows()` for print. Required in `functions.php` before `daypart-head.php`.
- `inc/daypart-head.php` — prints the hours and defines `window.spBar = { hours, status() }`; `status()` → `{ day, mins, open, opens, closed }` on the bar's clock, and knows a night belongs to the day its doors opened. The daypart thresholds and the 04:00 switch stay here.
- `src/js/bar-clock.js` — now `getBarStatus()`, `getBarHours()`, `formatBarTime()` (8:30 · 10 · 12). `getBarTime()` is gone. `reserve-drawer.js`, `visit-hero.js`, `daypart-engine.js` all ask it; none holds a door time any more (Visit's kitchen stages and the drawer's rush hour still do).
- Times inside copy follow the settings: the three closed subheads and the drawer's two closed lines (`{opens}`). Side effect: the drawer no longer says "from 8:30" on a Sunday morning.
- `footer.php`, `template-parts/visit/hero.php` — hours printed from the helper; a Fri–Sat row appears only if that night ends differently.
- Verified: frozen-clock suite on defaults — identical to the constants at every boundary (Mon 01:30 → Sun 10:00). Then with test values saved locally (opens 09:15, Fri/Sat close 04:30, and a nonsense "closes 14:00"): 09:15 everywhere incl. copy, Sat 03:00 still open on Friday's night, three printed rows, the nonsense value fell back to 02:00. Test values deleted afterwards.
- **Test site:** SCF → *Sync available* for the new group.

## Home hero closed state — built — 20 September 2026

Bar and kitchen shut, on the bar's clock: **02:00 → 04:00** night theme, party tile parked and lit, GOOD NIGHT, YAROSLAVL / See you for breakfast at 8:30 (Sundays: 10); **04:00 → 08:30** day theme, breakfast lit, YOU'RE UP BEFORE THE BAR! / Eggs and coffee from 8:30; **Sunday 04:00 → 10:00** A LITTLE SUNDAY POLISH / Back at 10, spotless. No Now marker while closed; other tiles preview as usual and the parked tile brings the closed copy back. The word "closed" stays out of the hero. Decisions and what was tried: `website-brief.md` → Desktop — home hero → Open → Closed state.

- `inc/daypart-head.php` — reads the bar's weekday, hour and minute; sets `<html data-closed="night|morning|sunday">` and parks `data-now`. **00:00 → 02:00 is now party** (was breakfast, by day). `?closed=night|morning|sunday` forces a window at any hour — kept for checking.
- `daypart-engine.js` — `closedCopy` merged over the parked tile's data in `activateTile()`; skips `.is-now-daypart` while closed. `hero.css` unchanged.
- Route taken: contact sheet on the live page (`Claude outputs/closed-state-contact-sheet.png`: all inactive · parked lit · rule-breaker with the opening time in the Now pill's slot) → URL-flag prototype with the pill → author dropped the pill (repeats the subhead) → real hours.
- Verified in headless Chrome with `Date` frozen and the visitor's zone set to Los Angeles: Mon 01:30 party/open · 02:00 and 03:59 night · 04:00 and 08:29 morning · 08:30 breakfast/open · Sun 03:00 night "at 10" · Sun 09:30 sunday · Sun 10:00 open. Visit hero and drawer read closed / closed / open at the same instants.
- **Not done:** ~~hours are still constants in three files~~ (done the same day — entry above); RU closed copy is drafted, not built; the state is not drawn in Figma; a shorter "YOU'RE UP BEFORE THE BAR!" is parked for the final copy review.

## One bar clock — 20 September 2026

Found in real-browser testing: the pages and the drawer disagreed about the hour. The home hero (`inc/daypart-head.php`) and the reserve drawer read the visitor's clock; only the Visit hero read Moscow's. **Decided (author): everything follows the bar's clock** — the site shows the bar's state, not the guest's afternoon.

- New `src/js/bar-clock.js` — `getBarTime()` → `{ day, hour, minute }` in `Europe/Moscow` (`BAR_TIME_ZONE`) *(replaced later the same day by `getBarStatus()` — see Bar hours settings)*. `reserve-drawer.js` and `visit-hero.js` import it; `visit-hero.js` lost its private `getMoscowTime()`.
- `inc/daypart-head.php` is inline and can't import: it reads the same zone through `Intl`, falling back to the visitor's clock if the zone isn't supported.
- The drawer's weekday (Sunday 10:00 opening, Fri/Sat busy) is now the bar's weekday too.
- Verified in headless Chrome with the visitor's zone overridden (Los Angeles 10:15, Tokyo 02:15 · Moscow Sun 20:15): home `data-now="dinner"`, night theme, drawer `available`, Visit bar/kitchen `open` in both.

**Visit hero, Sunday (same day):** `getVenueState()` now opens at 10:00 on Sundays (`day === 0`) — bar and kitchen closed for cleaning till 10, the drawer's rule. ~~**Found, not changed:** the hour thresholds in `daypart-head.php` still send 00:00–12:00 to breakfast~~ — fixed the same day with the closed state (next entry). Recorded in (`website-brief.md` → *Open (desktop hero)* → Closed state).

## Test site — test.sweetpepper.bar — 19 September 2026

Docs only; no theme code changed. Recorded in `website-brief.md` → Platform → *Test site*; cross-reference in `styleGuide-report.md` §9.3.
- **Decided:** team-only test site on a subdomain (separate Timeweb site), not the main domain behind a password — the style guide stays open, the test place outlives launch, test data stays out of the launch database.
- **Done by the author:** subdomain, fresh WordPress, SCF; **worktree + theme link (19 Sep)** — `~/repository-test` on `wip` at `528bd3c`, tracking `origin/wip`, linked into `~/SweetPepper-test`. The first attempt failed ("Not a valid object name: 'origin/wip'") because `~/repository` tracked `main` only; fixed with `git remote set-branches --add origin wip` — the corrected command is in the brief.
- **Symlink refused by the host (19 Sep):** the linked theme listed under its folder name and `functions.php` never ran (no templates, no CPT menus); 755/644 on the worktree didn't cure it — probably `open_basedir`, unverified. Route is now a **copy** in `…/themes/sweet-pepper-test/`, refreshed by `git pull --ff-only && rsync -a --delete --chmod=D755,F644 …` (git writes `rw-------` here, so the chmod is what keeps new `dist/` files servable). Pages About / Menu / Visit created with their templates; Home is the static front page.
- **Open:** Soups `menu_section` record not seeded on the test site yet (`WP_ROOT=… php ~/repository-test/tools/menu-seed.php soups`); dead link `…/themes/sweet-pepper-theme` to remove.
- **Open:** `~/wordpress_so89h` is the installer's original of the test site and **shares its database** (`cb47162573_so89h` in both configs, confirmed 19 Sep) — files-only deletion, never the panel's "delete database"; check no domain is still bound to it; the installer's extra plugins (two `ai-provider-*`, Akismet, Hello Dolly) still to be removed.
- **Deploy route:** a git worktree of the server's existing `~/repository` on `wip` at `~/repository-test` (reuses the style guide's repo access), with `sweet-pepper-theme/` copied into the test site's themes folder after each pull (the symlink first planned was refused — above); updates are push `wip` → pull + rsync in `~/repository-test`.
- **Still to do:** SSL + PHP 8.2, theme activation, pages/templates/front page/permalinks, SCF sync and re-entered values, basic-auth team password + discourage search engines, Editor accounts for testers. SCF only — no page cache on the test site.

## Dish picker — Shake It! between the photos, the photo roll, one pairings list — 18–19 September 2026

Brief → Mobile — menu → *Pairing station*; Motion language (third stop-for-good exception; the `translate` corollary under Scroll-in); Content editing → Open → *Picker pairings*. The phone labels row was the trigger (the pinned "or Shake It!" chip left the tag rail 240px of 402); five arrangements were mocked on the live page and the author chose the rule-breaker: the button takes the place of the "x".

- **`dish-picker.php`:** the labels row holds the tags only; `.dish-picker__shake > button.dish-picker__shake-it > .dish-picker__shake-disc > .dish-picker__shake-icon` sits inside `.dish-picker__photos` where the `x` span was. No visible label — `aria-label="Shake it — pick a random dish"`. `.dish-picker__x`, `.dish-picker__or` and `.dish-picker__shake-label` no longer exist anywhere.
- **`dish-picker.css`:** Figma `shakeItContainer-desktop` / `-mobile` (2437:71646 / 2437:72125) — 48px button = 4px ring in the ground + 40px disc, Symbol 24px; hover 52 / pressed 52 + inset / delay 56 as `transform: scale`; `--shake-fill / -ground / -border / -shadow / -glow` on `.dish-picker` (night set under `html[data-theme="night"]`, About sets the night set in every theme with a Soft Peppercorn ring — `about.css`). Lemon by day is the author's call over the frame's Cream; the ring takes the real ground (`--surface`), not the frame's Peppercorn. Glow on a `::after` layer (opacity only). Slot centred by `calc(50% − 24px)` offsets. Photos `gap: 8px` with nothing between them: 172 → 181px at 402, picker 622 → 631px header to ticket foot (625 at 390, 618 at 375). Phone rail: gutter to gutter, gap 8, two-ended mask gated by `.has-more-start` / `.has-more-end`.
- **`dish-picker.js`:** Shake spin (one turn, 900 ms, Gentle spring, `rotate` on the icon); touch idle hint = the delay state on the 5 s heartbeat (first beat 2.5 s after the photos are 60% in view; a tag pick seizes it 8 s; the first Shake ends it for the visit; `(hover: none)` only; none under reduced motion); `markRail()`; **`rollPhoto()`** — see the file table. The 350 ms crossfade and the 350 ms pick lock noted in the entry below are gone (the crossfade survives as the reduced-motion path).
- **`reveal.js`:** the `pop` selector and its 350 ms delay moved from `.dish-picker__x` to `.dish-picker__shake` (About and Menu plans). **`reveal.css`:** comment only — the positioning corollary.
- **`inc/pairings.php`** (new, required from `functions.php`): `sweet_pepper_food_pairings()`, `sweet_pepper_pairing_index()`. `pairing-station.php` and `about/concept.php` both read it; About went from its own three dishes to the menu's six (two tag rows on desktop, picker ≈ 40px taller; the phone rail scrolls as on the menu). About's reviewed item copy is off the page until it is folded into the shared list — noted in `about-page-copy.md`; the author has parked it for the final copy review.
- **Verified** in headless Chrome at 375 × 667, 390 × 844, 402 × 874, 820 × 1180, 1440 × 900, day and night, menu and About: no horizontal scroll, no console errors; entrance sampled per frame (button centre 0px off the seam throughout, 0 → 52.7 → 48px); roll sampled per frame (strip contiguous at frame height + 8, 0px overshoot, no ghosts left); five Shakes 120 ms apart end with tag, photos and ticket in agreement. `(hover: none)` had to be forced through a `matchMedia` shim — headless Chrome reports `hover: hover` at phone widths. **Not yet on a real device** — the height with browser chrome showing is the open question (cheapest 12px back: the ticket's bottom padding 36 → 24).
- **Owed:** Figma re-sync (picker frames still draw the `x` and the chip; the button frames draw a Cream day disc and a Peppercorn night ring; the mobile set has a day *hover* where the day *delay* belongs); subtitle copy that mentions the shake, RU twin with it.

## Menu storage — the repeater store, built for Soups — 18 September 2026

First half of the brief's Soups test (`website-brief.md` → Content editing → Open → *Menu storage*; test logged in `testing.md`). The decision stays open until a manager has tried it; the hybrid store (CPT + Relationship lists) ~~is not built~~ was built on 20 Sep — entry above.
- **Soups renders from WordPress.** `soups.php` calls `template-parts/components/menu-section-columns.php`, which loops over `sweet_pepper_menu_subsections( 'soups' )` (`inc/menu-data.php`). Rows come from the section's `menu_section` record, or from `data/menu/soups.php` while the record is empty — a section converts without the page going blank. `dish-row.php` untouched. Rendered markup verified identical: before / fallback / from the database.
- **One `menu_section` post per section**, not an options page — revisions, edit lock, cache purge on save. Not public; only an admin can add one.
- **Row fields (author):** price is a number, the theme adds `-.`; one size or two (amount + unit dropdown + price); icons two at most, never the same twice — **leaf = vegetarian, fire = hit, pepper = spicy, Yaroslavl logo = local dish** (now in `design.md` §5.2). Horseradish infusion corrected to fire + Yaroslavl.
- **Form rule (author):** no notes inside the row grid; a note on a RU field is repeated on its EN twin.
- **Tooling:** `tools/menu-field-group.py` generates `acf-json/group_sp_menu_section.json` (fixed keys); `tools/menu-seed.php <slug>` seeds a record through Local's PHP + MySQL socket — no `wp` needed.
- **Found on the way:** the menu has **253** typed dish rows, not 239 — Breakfast's 14 live in `page-menu.php`, outside `template-parts/menu-sections/`. Two typed prices were malformed (`165 / 225-.`, `455-./ 645-.`). Two leftovers contradict the icon legend: `front-page.php` tags fire as "Spicy"; a Breakfast row asks for a `spicy-1` icon that does not exist.
- Detail and what is not built yet: *Next Up → Shared / Backend → 2*.

## Platform decisions — SCF, cache, host, menu storage — 18 September 2026

Docs only; no theme code changed. Recorded in `website-brief.md` → Platform.
- **SCF replaces ACF** (Plugin cap → 1). Author installed it on the Local site in place of free ACF 6.8.9; the About field group and the Bar Settings options page work unchanged. ACF Pro not taken: update delivery to a Russian host is unverified, and the licence would be tied to the author's card.
- **Page cache: WP Super Cache** (Plugin cap → 3). Timeweb's WordPress guide recommends plugin caching only and mentions no server-side HTML cache; a support ticket is filed to confirm. Installed at launch, not on Local; enable its gzip only if the host isn't already compressing. Owed with the extraction: a purge hook in `inc/` for SCF options-page saves.
- **Host: Timeweb shared, "WordPress Старт"**, to 5 Sep 2027 (new subsection *Hosting — Timeweb*). Set PHP 8.2 to match Local; support question drafted.
- **Menu storage narrowed, not decided** (Content editing → Open → *Menu storage*). Settled: one record per dish, referenced by highlights, home previews and the picker; split admin pages; the losing structure is removed. Candidates: repeater with row IDs (author leaning), `dish` CPT, or CPT plus ordered Relationship lists per section. Test: Soups built each way.
- Status lines below brought up to date: phones and tablets are built on all four pages, so the next build phase is the About extraction.

## Menu motion — hero idle sweep and daypart opening frame — 18 September 2026

Brief → Menu page → *Idle behaviour* (→ *As built*). All in `src/js/menu-hero.js`; no CSS, no PHP.

- **Opening frame.** `OPENING` maps `<html data-now>` (or `?daypart=`) to a section per room; `defaultSection` is now a `let` and becomes the answer, so hover-leave returns to it. Silent when `sinceFirstPaint() <= --in-photo` (the home engine's test, `cssMs()` copied for the minifier's `1.1s`), with `--in-fill` re-timed **on the word, not the hero** — the door's pop reads the same property and has already started. Late → `settle()` first, then an ordinary crossfade. `settle()` now also strips the inline `--in-fill`. Runs before `initMenuSingleSection()`, which reads `hero.dataset.currentSection`, so below 992 the section on show follows.
- **Sweep.** `SWEEP_STEP = 4000`, first step at `2600 + 2 × step`; a `setTimeout` chain, gated by `(min-width: 992px)` and no reduced motion. A step advances only while the hero is ≥ 50% in view (IntersectionObserver) and the tab is visible; otherwise it just re-arms. `setActiveNav(slug, true)` moves `.is-active` without touching `aria-current`. `stopDemo()` — nav / photo `pointerenter`, hero `focusin` / `touchstart` / `keydown`, word and door `mouseenter`, `menu-hero:preview`, or the query no longer matching — is permanent.
- **Confirmed (author):** dinner → `hot-dishes`; weekends run the weekday schedule. **Still proposals:** party → `bar-snacks`; the 4 s step (author testing).
- **Checked** in headless Chrome: 1440 × 900 `?daypart=dinner` opens on Hot Dishes (silent path), first step at ≈ 10.6 s → Desserts → Kids, `aria-current` stays, URL and scroll untouched; hovering Salads takes over, leaving returns to Hot Dishes and nothing moves in the next 10 s. Drinks `?daypart=breakfast` wraps Tea & Coffee → Infusions. Reduced motion: answer frame, no sweep. `#soups` deep link: hero off-screen, no advance. 402 and 820: the section on show is the answer, no sweep. Not yet on a real device.
- **Photo card link (same day).** `menu-hero.php`: `.menu-hero__photo-frame` is now an `<a href="#slug" aria-label="Label">` (was a `div`); `menu-hero.css`: `display: block` + a `:focus-visible` ring (Olive / night Lime, the panel words' ring). `menu-hero.js`: `showSection()`'s two copies of the swap are one `swap()`, which also writes the link's `href` / `aria-label` when the slug is a section on the page (so not for the door's intro); a click handler rides `gentleScrollTo`. Checked: the link follows the sweep (`#hot-dishes` → `#desserts`), a door hover leaves it, a click at 1440 lands the section at top 0, a tap at 402 switches the single section and lands it under the header (top 76); pill text undecorated.
- **Word transitions — trial.** `.menu-hero__nav-label` and `.menu-hero__nav-arrow`: `0.8s var(--ease-bouncy)` → `var(--dur-gentle) var(--ease-gentle-flat)` (Motion language → *Colour-only transitions*). Carries into the jump-nav panel, which reuses the classes. The door's colour transitions are still Bouncy.
- **Word hover — the snap, the pace, the spring (same day).** Sampled per rAF: `-webkit-text-stroke-width` (discrete) flipped to 0 on frame one with the fill at 0.016 alpha — a blink, not an easing problem. `menu-hero.css`: `@property --menu-word-stroke` (`<length>`, non-inheriting, 1.5px); the label's stroke is `var(--menu-word-stroke) <colour>`, states set the variable (`0px`) and `-webkit-text-stroke-color: currentColor` instead of the shorthand; the night rule sets only the stroke *colour*; `menu-word-fill`'s `from` sets the variable. Transitions list `color`, `-webkit-text-stroke-color`, `--menu-word-stroke` on `--menu-word-dur` (1100ms, flat curve) — both knobs are on `.menu-hero__nav-item`. Arrow: `translate: -16px 0` → `0 0` on `--ease-bouncy` over `--menu-arrow-dur` (900ms); a `prefers-reduced-motion: reduce` block removes the travel. Re-sampled: width 1.5 → 1.17 → 0.51 → 0 alongside the fill, arrow peaks at +1.48px at ≈ 600ms, entrance fill unchanged (day and drinks). Not changed: the door label's identical snap; the photo's mid-fade `src` cut at ≈ 0.42 opacity.
- **Found — hours disagree.** Copy: lunch till 4, evening kitchen from 4, "weekday lunch 12–16". Code (`daypart-head.php`, and the table below): lunch → dinner and day → night at 17:00. Not changed — it moves the home hero too. Also: the hour themes the home page only; the brief says site-wide.

## Menu motion — section pass, ride suppression, photo-band drift — 18 September 2026

Brief → Motion language → *Scroll-in — Menu pages*. `reveal.js`: `MENU` plan (scope `.menu-highlights, .menu-section, .menu-pairing-station, .menu-visit-cta` plus `.page-template-page-menu .menu-location / .menu-entrance-img`, so the shared bands stay on their own plans elsewhere); dish rows and sub-heads are deliberately absent. **Engine:** `RIDE = 4` viewports per second, measured per check from `performance.now()`; while riding nothing is batched (photos are still woken), any armed root whose layout box is entirely above the screen is `release()`d unplayed — this also covers instant anchor arrivals — and a 120 ms follow-up check catches a ride whose last frame was a fast one. `reveal.css`: `@property --band-drift` (`<percentage>`), `.menu-section__hero { view-timeline: --band }`, the image's `object-position` rebuilt as `var(--img-x, 50%) clamp(0%, calc(var(--img-y, 50%) + var(--band-drift)), 100%)` and animated 12% → −12% over `cover`. Measured on Desserts: 62% → 53% → 44% as the band's top moves from the fold to the top of the screen. Verified: full-page step-through on both menu states at 1440 × 900 and the food state at 820 and 402; a hero-word ride to Desserts played Highlights (at departure) and Desserts only; Home, About and Visit re-run clean, Home's replay check too. Harness note: below 992px the hidden sections' lazy band photos report as "unloaded" — they are `display: none` until switched to. Nothing committed.

## Menu motion — hero page-load entrance — 18 September 2026

Brief → Motion language → *Page-load entrance — Menu hero*. CSS at the end of `menu-hero.css`: delay custom properties on `.menu-hero` (`--in-sheet / -words / -photo / -copy / -mark / -fill`), `--menu-word-outline` (Olive / night Lime) for the fill's start state, `--i` per `.menu-hero__nav-item` (nine), keyframes `menu-sheet-in`, `menu-word-in`, `menu-word-fill`, `menu-sheet-fan` plus the shared `hero-*`. The sheet fan sits in its own `(min-width: 992px)` block — its start state assumes the desktop geometry (sheets centred on the stack, frame 10px left of centre at −1°); below that the sheets only fade. `.menu-hero__wordmark .molot-text` becomes `inline-block` so it can rise; below 992px `.menu-hero__connector .section-link-word img` rises instead and is `loading="eager"` (`menu-hero.php`). `menu-hero.js`: `.is-settled` on first `pointerenter` / `focusin` / `touchstart` in the nav or after 2.6 s, which switches off the two `.is-active`-scoped animations (label fill, arrow). Verified with seeked frames at 1440 × 900 (food day, drinks night), 820 × 1180 and 402 × 874, and the gate by dispatching a hover at 0.6 s and at 3 s. Still to build on this page: section furniture + photo-band drift (the band replaces the reflection at every section head), pairing station, ride suppression in `reveal.js`, Location band. The brief's idle sweep is not in the build. Nothing committed.

## Visit motion — hero entrance and scroll-in — 18 September 2026

Brief → Motion language → *Page-load entrance — Visit hero, and Visit scroll-in*. **Hero:** a `prefers-reduced-motion: no-preference` block at the end of `visit.css` — delay custom properties on `.visit-hero` (`--in-eyebrow / -headline / -lead / -band / -pills / -hours / -card / -word`), shared keyframes from `hero.css` plus `visit-band-lay` (clip-path wipe on `.visit-hero__band` and the phone `.visit-hero__rail`), `visit-print` (`translate` + `clip-path` on `.visit-hero__hours-card-container`, Gentle), `visit-drop` (card and its `::before` pin, Bouncy), `visit-dot-on`. Nothing uses `transform`, because band, card, pin and the phone slip all own one. No JS, no template change. **Scroll:** `VISIT` plan added to `PLANS` in `reveal.js` (scope `.visit-location, .visit-cta`); the room photo is matched twice (`.visit-cta__photo`, `.visit-band`) and the hidden one is skipped by the engine's no-box rule. Verified: seeked hero frames at 1440 × 900 and 402 × 874; full-page step-through at 1440 / 820 / 402. Harness note: the hidden duplicate of `door-entrance.jpg` reports as "unloaded" below desktop — it is `display: none`. Nothing committed.

## Dish picker — the ticket prints on a pick — 18 September 2026

`dish-picker.js`: `reprint(write)` — Web Animations on the children of `.dish-picker__card-wrap` (top edge, card, bottom rugged edge), `translate` 0 → −(wrap height + 8) over 220 ms ease-in, then `write()` swaps name / description / pairing / CTA href out of sight, then −height → 0 over `--dur-gentle` on `--ease-gentle` (both read from `:root`; the duration's unit is parsed because the minifier may emit `.8s`). A run counter drops a superseded print; a new pick reads the paper's current `translate` and retracts from there. Photos keep their 350 ms crossfade and the 350 ms pick lock. *(Superseded 19 Sep 2026 — the photos roll and the lock is gone; entry above.)* Reduced motion or no `Element.animate`: `write()` runs at once. `reveal.css`: `mask-down` now takes `--dur-gentle` / `--ease-gentle`. Sampled per frame on About at 1440 and 402 and on `/menu/` at 1440: text changes only while the paper is out, overshoot ≈ +9px, settles at 0, no leftover animations, an interrupting second pick ends on the second pick's text. Brief → The bartender's ticket → Motion. Nothing committed.

## About motion — scroll-in, ticket print, entrance drift; reveal engine reworked — 18 September 2026

Brief → Motion language → *Scroll-in entrances — About*. **`reveal.js` changed underneath both pages:**
- **Plans:** `PLANS = [HOME, ABOUT]`; a plan may carry `delays` (selector → ms added to the batch stagger). `ABOUT.scope` is `.page-about …` so shared components stay still on the menu page.
- **Trigger: layout position, not IntersectionObserver.** `layoutTop()` sums `offsetTop` up the `offsetParent` chain; `check()` runs on scroll / resize / load through one rAF. Line at 88% of the viewport, lazy photos switched to eager at 2.5 viewports, replay re-park at 2 viewports. Why: a parked element is clipped to nothing inside `overflow: hidden` parents, and the observer's verdict flipped on a pixel of clip margin (`.dish-picker__photo-food` never played after its clip was tightened). The three observers are gone.
- **Roots and nested reveals:** only elements with no `[data-reveal]` ancestor are tracked; children are armed with their root and played off it (+550 ms). State per root: `armed → playing → done`.
- **Inline titles:** a matched element with `display: inline` hands its effect to its parent block.
- **`reveal.css`:** effects use `translate` / `scale` (compose with owned transforms — tilted cards, stamps, the ×); new `mask-down`; parked clips are 0 on the leading side; `transitionend` is matched on `translate|scale`. New CSS scroll-driven rules: `link-text-close` for `.section-link--reflection .section-link__text` (on `translate`, the reflection owns `scaleY(-1)`), and `entrance-drift` (`object-position` 70% → 30%) on `.page-about .menu-entrance-img__inner img` riding the frame's named `--entrance` timeline.

No template changes on About for this pass. Verified in headless Chrome at 1440 × 900, 820 × 1180, 402 × 874 (full-page step-through), down → up → down at 1440 on both pages, and the Concept sequence frame by frame. Harness note: the check script reports `.about-story.is-armed` as "still armed" — that class is the Story's own, not the engine's. Nothing committed.

## About motion — hero page-load entrance — 18 September 2026

First piece of the About motion pass (brief → Motion language → *Page-load entrance — About hero*). CSS only: a `prefers-reduced-motion: no-preference` block in `about.css` directly after the hero rules — delay custom properties on `.about-hero` (`--in-eyebrow / -headline / -lead / -cards / -word`), `--i` per `.about-hero__filmstrip-item`, and the **home hero's keyframes reused** (`hero-fade`, `hero-lift`, `hero-mask-rise`, `hero-tile-in`, `hero-pop`, `hero-word-rise` live in `hero.css`; both files are one bundle). Photo + overlay slide inside `.about-hero__filmstrip-img-wrap`; the pill uses `hero-pop` (fades to its own resting 90%, `scale` so it composes); the foot word is live text, so the clip sits on `.section-link` and the rise on `.section-link__text`. `about/hero.php`: card photos `loading="eager"`. No JS. Checked with seeked frames at 1440 × 900 and 402 × 874; the only pixels on the fold before the word rises are the connector's own 1px rule. Still to build on this page: scroll-in plan for `reveal.js`, ticket print on entry, entrance-photo drift, connector lag for live-text reflections (needs `translate`, the reflection already uses `transform: scaleY(-1)`). Nothing committed.

## Home motion — load entrance, first-paint theme, scramble, scroll-in — 18 September 2026

Decisions and reasoning live in `website-brief.md` → Motion language (*Page-load entrance*, *Headline swap*, *Scroll-in entrances*). This is the build side.

**Hero page-load entrance.** Pure CSS, end of `hero.css`: `backwards`-filled keyframes start with the first paint, scoped to `.home-hero:not(.is-settled)`, all inside `prefers-reduced-motion: no-preference`. Delays are custom properties on `.home-hero` (`--in-eyebrow / -headline / -subhead / -tiles / -ctas / -word / -light / -nudge`), literal ms because the script reads two of them — and the minifier rewrites `1100ms` as `1.1s`, so `daypart-engine.js` parses the unit. The bento query overrides the set (tiles lead). Engine side: `activateOnLoad()` swaps the server's breakfast tile with `.is-booting` on the hero (transitions off, no FLIP) if it runs before `--in-tiles`, re-times `--in-light`, and adds `.is-settled` when `hero.getAnimations({subtree})` have all finished; a tile tap settles first. The language nudge slides in last (`--in-nudge: 2000ms`, desktop only — it is hidden on the bento). Hero tile photos and the hero's foot word are `loading="eager"` (`section-link-word.php` gained a `loading` arg): an image parked outside a clip never intersects, so a lazy one would not load until it had slid in empty.

**First-paint theme.** `inc/daypart-head.php` prints blocking inline JS at `wp_head` priority 0: sets `<html data-now>` and, by the engine's own rules, `data-theme="night"` before paint. **The hour thresholds live only there** — `daypart-engine.js` reads `html.dataset.now` and no longer calls `getHours()`. If that script is ever missing the hero stays on the server's breakfast state. Measured: zero theme writes by the engine on load on `/`, `/?daypart=party`, `/?daypart=lunch`, `/menu/?menu=drinks`.

**Headline scramble.** `src/js/scramble-text.js`, `scrambleTo(el, text, 600)`, called by the engine on tile taps only (load writes the text directly). Pool = the target's own letters minus narrow glyphs; `min-height` held at the taller of the two strings, `nowrap` when both are one line; interruptible; `aria-label` carries the target for the ride.

**Scroll-in reveals.** `src/js/reveal.js` + `src/css/reveal.css`. The home plan (effect → selectors) is the `HOME` object at the top of `reveal.js`; the script writes `data-reveal` on matches, arms them (`.is-armed`), *(superseded the same day — see the entry above: triggering is now by layout position)* one `IntersectionObserver` (`rootMargin: 0px 100% -12% 100%`) plays them (`.is-in`, `--reveal-delay` = batch index × 120 ms) and strips both classes on `transitionend` (2.4 s fallback timer). Second observer (`150%` margins) flips lazy images to eager ahead of arrival. Sections holding armed elements get `.has-reveal { overflow-x: clip }`. Nested reveals are played by their parent (+550 ms). Swipe rails (phone Highlights / Events) get one `rise` on the rail. Dispatches `reveal:in` (`detail.delay`) on each element. **Replay (trial):** `REPLAY = /^mask-(left|right)$/` — a third observer (`rootMargin: 0px 100% 100% 100%`) re-arms finished containers once they are a full screen below the fold; `null` = once only.

**Count-up.** `src/js/count-up.js`; `data-count-up` on the "12 years" label in `front-page.php` (the only template attribute of the pass). Listens for `reveal:in` on the nearest armed ancestor; waits 600 ms, counts 2.4 s on ease-out quad; digit span keeps its final width.

**Photo drift and connector parallax.** Both CSS scroll-driven in `reveal.css` behind `@supports (animation-timeline: view())` and `no-preference`. Drift: the frames (`.menu-preview-img-wrap`, `.about-preview-image`) name `view-timeline: --photo` because `overflow: hidden` makes them scroll containers; the images ride it at `scale(1.12)`, ±4%. Parallax: see the next entry for its scoping fix.

**Found, not changed:** `/menu/` never themes by the hour in the build although the brief's table says it does; the home hero uses the visitor's clock while `visit-hero.js` uses Moscow time *(closed 20 Sep 2026 — one bar clock, see the entry at the top)*. Both are recorded in the brief.

Verified in headless Chrome (1440 × 900, 820 × 1180, 402 × 874; JS off; reduced motion; down → up → down for replay). Not yet on a real device. Nothing committed.

## Type: 14px retired, tablet mode; home tile radii; parallax fix — 18 September 2026

**Home hero tiles.** Near sheet radius 2 → 4 (mid and far stay 2). The corner sliver on the active tile was a radius mismatch, not scale: the wrapper is 4px with a 2px keyline, so its inner clip curves at 2px, and `.tile-img` carried its own 4px. The image and `.tile-overlay` now have no radius — the wrapper clips. Checked at 4× in headless Chrome. Brief → Desktop — home hero → Active tile → Radii.

**Secondary 14 retired.** Twelve hardcoded rules moved onto the existing tokens: to `--text-caption` (13 / 0.52px) — `.event-card-date span`, `.about-team__card-role`, `.about-perks__stamp-label`, `.about-story__counter-label` (phone override removed; its desktop 13 had 14's 0.56px tracking), `.call-status`; to `--text-body` (16 / no tracking) — `.dish-description`, `.dish-option-text`, `.about-team__card-message`, `.section-description--mobile`, `.contact-form__subtitle`, `.reserve-footer-text` and the phone `.reserve-subtitle`. Measured first: menu page +1% in length. The team message box is `calc(1.4em * 3)` (was 60px); the card stays 392. No `font-size: 14px` or `0.56px` remains in `src/css`. Opens (brief → Typography on the web): Lera's 98-character line clips on desktop; the event date is 13 / 500 by day (Form Label's look, not Caption's); the reserve sheet scrolls 51px at 375 × 667 (it scrolled ≈ 41 before).

**Tablet type mode.** `variables.css` gains `@media (min-width: 768px) and (max-width: 991px)`: `--text-display: 64px`, `--text-h1: 48px`; nothing else moves, sizes stay px, token names unchanged. Two raw 76px headlines now take `--text-display` (`.about-hero__headline`, and `.hero-headline` — the landscape-tablet row was still 76 and wrapping). `.about-hero__headline` gets `text-wrap: balance` in the band (64 orphaned "2018" at 768). Fixed-pixel tracking → `0.04em` on `.visit-hero__headline` (2.56px — 7% at the phone 36, live until now), `.about-hero__headline`, `.about-visit-cta__headline`. Checked 768 and 991 on all four pages, 820 × 700, 1440 and 375: single-line H1s, no horizontal overflow. `design.md` §3.3 has the Tablet column and the reasoning (why 48; Caption 12 / 14, Body 18 and rem weighed and not taken).

**Connector parallax — heads only.** `reveal.css` animated every `.section-link-word--reflection`, but on the menu page the upright foot words wear that class for its 50% opacity, so they sank half their height behind the next section (seen on the menu hero's "food menu"). The rule now excludes `.menu-hero__connector`, `.menu-highlights__link-word`, `.menu-section__bottom-link-word`, `.pairing-station__link-word`. Debt: the class means two things; a `--faded` modifier would let the parallax target heads positively (~25 template calls, not done).

**Icon beside text.** New rule in `design.md` §5.2: top-align the row, offset the icon to the capitals' centre of line one (Body 16 / 140%: cap centre 11.6px → 16px icon 4px, 8px bullet 8px). Footer `.contact-item i` gets `margin-top: 4px` (was 0; measured icon centre 8.0 → 12.0 against 11.6); `.dish-option-bullet` 6 → 8px, a knock-on of the 14 → 16 change above. `.contact-item__icon` and `.visit-hero__event-icon` already carried 4px.

Figma owed: Tablet mode in `Typography`; delete `Body/Secondary` and `Body/Secondary Highlights`. Nothing committed.

## Menu copy review — 16 September 2026

Created `menu-copy-review-en.md`, `menu-copy-en.md` and `menu-copy-ru-draft.md`; linked them from the existing hero transcription. Covers sixteen hero descriptions, light section-label edits, the Horseraddish/description placeholder (working copy: Horseradish — For the brave — a taste of Yaroslavl's hot side), pairing wording and documented offer conditions. Item catalogues, recipes, prices, booking copy and connectors remain unchanged. Recorded pairing/photo mismatches for later review. No theme or Figma edits; existing code still awaits the copy implementation pass. Photo inventory unchanged: missing light.jpg and logo.jpg, no stale/differing matches, no sync.

## Contact icons — inlined SVG sweep — 16 September 2026

Every icon in a contact or booking control now inlines an SVG from `assets/icons/` instead of rendering the Phosphor webfont: the contact form and team form field marks (`c-mail`, `c-phone`), the reserve drawer's ticket copy chip, phone CTA, social arrows and three bar-state marks, and the home Contacts block's phone CTA and status line. Same library — `assets/icons/` is the Phosphor set exported from Figma, and the `c-*` files draw in `currentColor` — so this is a delivery change, not a second icon library; recorded in `design.md` §5.2 → Delivery. Icons now swap by CSS showing one of two inlined SVGs; `reserve-drawer.js` no longer builds `<i>` elements or toggles `ph-` classes, and the state table lost `statusIconClass`/`statusIconColor`. Two marks are deliberately not icons: *busy* is a CSS dot (the set has no plain circle, and the Visit rail already draws status dots that way) and *closed* takes the daypart `sleep` glyph, replacing a clock that sat against the no-clock rule. The webfont stays for dialog closes, the home stat chips and the button component's fallback. Root cause of the sweep: a copy handler had been rewriting a chip's `innerHTML`, which dropped the inline SVG and left a typeface ✓ — now forbidden by rule in `website-brief.md` → Interaction rule → Chip success state. Address chips also moved off a hand-written `all 0.15s ease` onto the house flat bezier. Separately, this pass had been adding raw `file_get_contents` echoes against the standing inline rule; all 23 in `visit/hero.php`, `visit/location.php`, `front-page.php`, `contact-form.php` and `contact-item.php` are now `sweet_pepper_inline_svg()`, and two hoisted-variable cases (one helper call echoed six times in a loop) became per-instance calls. The rendered Visit page now carries no duplicate SVG ids.

## About tablet — hero floor, text rhythm, Add your word — 17 September 2026

Sweep at 768 / 820 / 991 (no overflow, no clipped text; every section as the brief records it) found one fault: the hero's `min-height: 100vh` was running on top of the 76px fixed-bar offset in the band, so the connector on its floor sat 76px below the fold at 820 and 991 and 130 at 768 while the content ended above it. The phone's `100dvh − 76` floor (and its admin-bar variant) moved from the `≤767` block into a `≤991` block in `about.css`; `visit.css` takes the same correction in its `≤991` block. After: on the fold at 820 × 1180, 39 below at 991 × 1200, 90 below at 768 × 1024 — what remains is the desktop 80 / 80 rhythm, deferred with the tablet typography (brief → Tablet — About page → Cost and opens). Also in the tablet block: `.about-hero__content { gap: 0 }` (the 20px gap was stacking on the lead's `<p>` margin) and 12px under the eyebrow; `.about-how-it-feels__cta` left-aligned at ≤991 per the single-button rule. Measured at 402 and 1280: unchanged.

## Home tablet — bento hero, nudge in flow, email domain — 17 September 2026

Home hero at 768–991: the phone bento now runs on portrait tablets — the phone block's query in `hero.css` is phones or `(min-width: 768px) and (max-width: 991px) and (min-height: 1000px)`, the reduced-motion block widened to ≤ 991, and a tablet block carries what differs from the phone (eyebrow and second CTA back, headline 64 on one line, subhead 20, gap 24 with the span formula adjusted, primary button at natural width; the nudge hidden as on phones; the headline colour is the base `--accent`, Chili in both modes at every width — author, 17 Sep: the desktop is the correct one, the mobile frames' Olive / Lemon is the one to re-sync; the active tile's 2px Peppercorn keyline is decided as built, the brief's `--accent-2` wording corrected). `daypart-engine.js` gates the FLIP on the same query; a tap at 820 was verified (dinner into the wide slot, theme to night, lunch back). Measured: active photo 473 × 320 / 499 × 335 / 584 × 392 at 768 / 820 / 991, hero one viewport at 768 × 1024 and 820 × 1180, the row kept at 991 × 744 by the height guard; 402 and 1280 unchanged. Argument and costs in website-brief.md → Grid → Tablet → *The home hero in the band*. Sweep of the rest of the band: no overflow, no clipped text. The kitchen preview's CTA is left-aligned at natural width in the ≤991 block of `menu-preview.css` (its desktop right-alignment had survived the stack; the bar and About previews already sat left) — the band's rule for a single button, recorded in the brief; the footer's 768 limit is noted there too. **Language nudge in flow** (`.lang-nudge-wrapper`: flex, right-aligned, was absolute above the hero footer) — it had been overlapping the CTA buttons whenever the hero's content exceeded the section minimum, measured at 991 × 744, 1280 × 700 and 1440 × 800; overlap now 0 at all four, hero and foot word still on the fold at 1280 × 900 and 1440 × 800, dismissal still collapses the wrapper. **Email:** every `hello@sweetpepper.ru` (footer) and `hello@sweetpepperbar.ru` (visit hero, contact item, contact and team forms, careers) is `hello@sweetpepper.bar` — the author's domain, decided 17 Sep 2026.

## Visit tablet — second pass — 17 September 2026

Hero at 768–991: the two cards are a centred 80% column (author's call, a recorded break of Grid → Short copy; full width, a capped flush-left ticket and the desktop row with the phone card skin were all built, measured and rejected — website-brief.md → Tablet — Visit page), the phone running rail replaces the desktop band across the band (its tilt margin is `0.8727vw` now, width × sin 1° ÷ 2), and the hero's three fixed 24px gutters take the site ramp. The frame is `flex: 1 0 auto` below 1120 (was `none`): grows to the 100vh floor, never clips. The `transform: none` tilt reset moved from the ≤1119 block into a 768–1119 block — it had been cancelling the phone card's 1° rest tilt from later in the cascade. Location: the badge list's `flex: 0 0 360px` had become a 360px height in the stacked container (Chrome stretched the rows to 121 / 103, Safari showed the rest as a gap); `flex: none`, `minmax(0, 1fr)` columns and `grid-auto-rows: 1fr` so all six cells are 60px. Edges: `.site-footer` painted Lime so the strip-to-main seam can only show Lime (the body on Visit is Peppercorn — that was the dark hairline), the hours card carries a 1px Peppercorn top border with the top scallop strip at `top: 0` so the dark → Parchment boundary is one element's border and background, and the Visit footer bites are Soft Peppercorn on phones, where the section above ends on the full-bleed form. Measured at 402 / 768 / 820 / 991 / 992 / 1119 / 1280 in the pane and at 2× in headless Chrome; 1280 unchanged.

## Visit Getting here — map route switching + desktop layout — 16 September 2026

The six landmark badges became route switches: each carries the id of a Google My Map whose walking-route layer is on by default, and tapping it reloads the embed with that map (`location-map.js` → `initVisitMapRoutes`). A My Maps embed is a cross-origin iframe, so its own layer checkboxes cannot be driven from the page — one map per route is the only handle, which is why the base map's direction layers stay off. Wired: the door (base map), Znamenskaya Tower, Sovetskaya square, Strelka, Bogoyavlenskaya sq. and the closest bus stop; parking is deferred (several options, embedding still to be worked out). Google only — RU guests get the Yandex widget, which has no My Maps equivalent, so the badges are inert for them. Desktop rebuilt to `Location` 1990:124846: a 360 badge column beside a 736 × 440 map, the active badge Cream with its hint line, a Paper chip bar on the map's foot (map "labels" 2391:76528) and no address ribbon — the badges carry the address. Chips follow the page language, EN Google/Yandex, RU Yandex/2GIS, plus Copy address on desktop only. The Good-to-know slip moved above the map on phones now the connector closes the section.

## Visit page mobile build — 16 September 2026

Built the Visit page at ≤ 767px from `Visit-Mobile-opt2` 1441:72385 and the refined `Visit-hero` 2363:75509, in one pass on `visit.css` plus template changes. Hero: running Lime status rail (the two states only, no lead word; 2.5 s hold, 22 s loop, 8 s pause on touch, static under reduced motion) replacing the desktop band; hours ticket with square corners, the bottom scallop row overlapped 1px and the tiling phase-shifted so the end circles are whole at 370; contact card at 1° settling to 0° on scroll-in, rows ≥ 48px with a uniform ↗. Rail state colours taken from the Molot variants of `barState-mobile` 1460:73436 / `kitchenState-mobile` 1460:73472 — Olive dots alive, Paprika transitional, Chili closed — with both closed states set to Chili Deep, since the kitchen component's Paprika measures 1.9:1 on Lime. Section connectors adopted at both seams (YOUR ROUTE TO PEPPER, DROP A LITTLE NOTE) via a new shared `components/connector.php`; the About part now delegates to it, so one `$live_text` flag decides SVG-vs-text for both fixed-composition pages. The phone scroll-down link was dropped as a second device announcing the same section, closing its row in `testing.md`. We're all ears opens on the 21:9 photo with its reflection hidden, matching the menu and About pages where the entrance photo stands between two sections alone. Form gains optional topic chips and an "or" title prefix. **Defect found and fixed the same day:** two markup edits left six stray `</div>` in `template-parts/visit/location.php`; PHP lint passed and the page rendered, but the browser closed the section early and the foot connector fell outside it. Div-nesting is now checked explicitly after markup edits.

## Visit route-hint follow-up — 16 September 2026

Restored the existing Znamenskaya hint, Towards Pervomaiskaya / «В сторону Первомайской», in the EN/RU working copy after author feedback. Added a Sovetskaya Square candidate from the author's directions: Across Andropova, past the fountains / «Через Андропова, мимо фонтанов». The government-building alternative remains in the review. No route measurements, website or Figma changes.

## Visit copy review — 16 September 2026

Created `visit-copy-review-en.md`, `visit-page-copy-en.md` and `visit-page-copy-ru-draft.md` from current code, docs and the saved Visit screenshot. Live Figma canvas inspection was blocked by computer-use permissions; the local site was unreachable, so no fresh rendered-page comparison is claimed. Keeps JOIN THE PARTY, proposes shorter practical hero/contact wording, OPENING HOURS and the previously selected IN THE VERY HEART OF THE BEST CITY / «В самом сердце любимого города». Records the Sunday-hours mismatch in the Visit status engine, conflicting last-order meanings, stale 10-only clipboard address and Google-only route controls. Form/booking wording remains deferred; WE'RE ALL EARS is retained as a working choice with its voice-rule exception explicitly raised. Linked new docs from the existing strategy document without rewriting its history. Photo check: missing light.jpg and logo.jpg, no stale/differing matches; no sync. No theme or Figma changes.

## Home clean-copy documents — 16 September 2026

Created `home-copy-en.md`; renamed the previous Russian draft to `home-copy-ru-review.md`, preserving its notes and parked alternatives; created a clean `home-copy-ru-draft.md`. The clean pair carries current EN hero headlines, the selected bar/kitchen connectors, the adopted final JOIN THE PARTY connector (RU candidate «ПРИСОЕДИНЯЙТЕСЬ»), and the canonical 10/25 address. Unconfirmed data stays in placeholders. Deferred form/booking/phone-status rewrites stay in the reviews. Updated review and brief references. No website or Figma changes.

## Russian About draft — 16 September 2026

Created `about-page-copy-ru-draft.md` from the consolidated English document, adapting the prose and component labels into Russian. Preserved «В самом сердце любимого города» and the family meaning; proposed «Без ступеней» for the compact access label. Russian connectors are explicitly provisional. Original quotations remain source-controlled, facts remain for final review, and the closing invitation plus form/booking wording are deferred as instructed. Linked the draft from the English master. No theme or Figma changes.

## About copy consolidation — 16 September 2026

Updated `about-page-copy.md` into the current page order, incorporating the English review and selected Step-free / IN THE VERY HEART OF THE BEST CITY / WANT TO JOIN THE FAMILY? wording. Preserved founder and guest quotation sources, held forms and booking copy unchanged, and separated factual checks and conditional labels from working prose. Older copy and component explorations are preserved in `docs/archive/about-page-copy-before-consolidation-2026-09-16.md`; the review now points to the consolidated document. No theme, Figma or Russian-page changes.

## Home copy review — 15 September 2026

Author feedback recorded in `website-brief.md` → Copy and contact interactions and both Home copy documents. Current hero headlines stay. Horseradish gets a bravery / Yaroslavl heat direction at final copy review. Author will handle the repeated THAT'S ICONIC connector SVGs. Form/booking wording and interactions are explicitly on hold: mobile calling versus desktop copying is contextual; a date/time composer was too much interaction for a copy line and remains future work. Website address settled as **Kirova 10/25**; email domain candidates **sweetpepper.bar / sweetpepperbar.ru**, mailbox undecided. Social posts are intentional placeholders; location-dependent platform routing and other open questions wait for final review. No theme or Figma edits made.

Home connector follow-up: English pair selected as **FOR A WELL-EARNED POUR / FOR A PROPER APPETITE**. Longer kitchen wording avoids the oversized height of COME HUNGRY at full container width. Russian pair remains provisional; copy notes and `connector-copy.md` updated, SVGs/build unchanged.

## Stack & Environment

**About author selections (16 September):** **Step-free** inside the circular access stamp; **IN THE VERY HEART OF THE BEST CITY** for Location (RU direction «В самом сердце любимого города»); retain **WANT TO JOIN THE FAMILY?** for Careers. The latter two preserve intentional local humour and the venue's atmosphere, including relationships formed there. Rationale recorded in the brief and About copy docs; generic replacement proposals withdrawn. Only these selections are settled; remaining proposals and form/booking copy stay for final review. No theme or Figma edits.

**About copy review (15 September 2026):** `about-copy-review-en.md` compares the current desktop Figma, local page and copy/brand docs; proposes English revisions following the built section order. Focus: separate Hero/Concept/Story, replace repeated positioning claims with the documented guest-driven permanent-menu story, refine perks/guests/careers/location. Founder and guest quotes preserved; staff/job placeholders acknowledged, not replaced in the build. Forms/booking copy held unchanged per the author. Existing About copy doc points to the review while preserving historical decisions. No theme/Figma changes; Russian About copy awaits the English review.

| Item | Detail |
|---|---|
| **Framework** | Classic WordPress PHP theme (no page builders). Block editor is disabled for the `page` post type and the classic content box is removed (`functions.php`), so the page edit screen shows title + ACF fields only. Posts/CPTs untouched |
| **Build** | Vite — CSS/JS bundled from `src/`, dev server at `localhost:5173`. `vite.config.js` sets `base: './'` so built CSS references fonts/images relative to itself in `dist/assets/` (the Vite default `/assets/…` resolves to the site root and 404s under WordPress). Rebuild with `npx vite build` after any `src/` change; `inc/vite-enqueue.php` reads `dist/.vite/manifest.json` |
| **Theme src** | `sweet-pepper-theme/` (project root) |
| **LocalWP path** | `/Users/etual/Local Sites/sweet-pepper-bar/app/public/wp-content/themes/sweet-pepper-theme` (symlinked from project) |
| **Figma file** | `P7jYklzRIIFP8yGawnZPia` |
| **Icons** | Phosphor Icons (CDN in `header.php`) for generic UI + custom 12×12 SVGs in `assets/icons/`. Theme-adaptive variants prefixed `c-` use `fill="currentColor"` for inline SVG embedding. `arrowDown.svg` also uses `currentColor` (was hardcoded Lemon, fixed to inherit Lime from parent). **Sep 2026 (menu hero on phones):** `c-kebab.svg`, `c-coffee.svg`, `c-food.svg`, `c-cocktail.svg`, `c-wine.svg`, `c-burger.svg`, `c-soup.svg`, `c-glass.svg`, `c-beer.svg` — currentColor twins of the Figma `Icons` set (the Lemon-filled originals stay for the home hero); **Sep 2026:** `c-hamburger.svg` (mobile header toggle, `currentColor`), `c-close.svg` (drawer close, `currentColor` twin of `close.svg`) and `wordmark.svg` (flat Chili "SWEET PEPPER" 158.9×16 from the Figma mobile lockup — distinct from `horizontal.svg`, which carries the stamp and is not for small sizes per `design.md` §4) |
| **Logos** | `design/logos/website` |

---

## File Map

### CSS (`src/css/`)
| File | Purpose |
|---|---|
| `variables.css` | Color literals (chili, olive, lime, paprika, avocado…), semantic day/night tokens, type scale (h1–caption; **Mobile mode ≤ 767px: `--text-display` 64, `--text-h1` 36** — the Figma `Typography` collection's Mobile mode, Sep 2026; nothing else moves), font-family defs; **motion tokens (Sep 2026)**: `--dur-gentle: 800ms`, `--ease-gentle` = `cubic-bezier(0.33, 0.57, 0.08, 1.19)` (least-squares fit of the Figma Gentle spring over 800 ms — 72% at 200 ms, ~3% overshoot), `--ease-gentle-flat` = `cubic-bezier(0.4, 0, 0.2, 1)` (same duration, no overshoot — for colour / opacity / shadow / border, which flicker if a curve passes 100%), `--ease-bouncy` = `cubic-bezier(0.34, 1.56, 0.64, 1)` (Figma Bouncy, only where the prototype says so), `--ease-out-expo` = `cubic-bezier(0.16, 1, 0.3, 1)` (home hero tiles) **`--lime-light` #D4E671 added Sep 2026** (footer bottom row, drawer current-item description; five files had used it with a fallback only). |
| `main.css` | **21 Sep 2026:** `a[x-apple-data-detectors]` inherits colour and font — fallback for `header.php`'s `format-detection` meta (iOS auto-links plain-text phone numbers). Global resets, `.container` max-width (1280px, padding **16px phones (< 768) / 24px tablet / 80px desktop (≥ 992)** — the 16px step added Sep 2026 for the mobile build, Figma mobile frames are 370 content in 402), base typography. **≤ 991px (Sep 2026):** `#page { overflow-x: clip }` — pins the mobile layout viewport to device width (see Known Issues), and `body { padding-top: 76px }` for the fixed header **Sep 2026:** `section[id] { scroll-margin-top: 76px }` ≤ 991px so anchor landings (native and `gentle-scroll.js`) clear the fixed header |
| `header.css` | Top nav layout, logo hover animation, nav links (day: soft-peppercorn→avocado hover→olive active 750wt; night: paper→cream hover→lemon active 750wt), what's-on chip (olive/lime-light label, mushroom/ash border), lang toggle (Molot, chili bg, parchment/cream text, 8px radius, 0.64px tracking). **About + Visit pages**: header is `position: absolute; top: 0` (transparent overlay on dark hero) — hero sections must account for this with internal padding rather than relying on header flow height. **Mobile header (Sep 2026, ≤ 991px; Figma `topNavContainer` 1164:48786, breakpoint=mobile, logo=full)**: 16px vertical padding around a 44px bar (76 total), `border-radius: 0 0 8px 8px` (Parchment bar over the Paper page by day; Peppercorn by night via the existing `--bg` rule), desktop nav + utils hidden; lockup = 32px Symbol + 16px gap + 16px-tall Chili `wordmark.svg` (`.logo-wordmark`, hidden on desktop; Chili in both modes so no `c-` variant); `.menu-toggle` = 44×44 tap target, 24px inline `c-hamburger.svg` right-aligned, Olive by day / Lemon by night. The logo hover rotate is scoped to `.logo-symbol` so the wordmark stays put. Only the two "full" states are built; the "symbol"-only mobile variant is not used. **Fixed** at ≤ 991px (`top: var(--wp-admin--admin-bar--height, 0)`); body carries the 76px offset in `main.css`. About/Visit keep their absolute-transparent desktop header but go fixed + Peppercorn ground on mobile so the bar has a ground once the page scrolls — **and it did not, until Sep 2026:** the desktop About/Visit override sat later in the file at equal specificity and beat the mobile block, so the phone bar was static and transparent over the body's Paper offset. The desktop rule is now inside `@media (min-width: 992px)`, and `body.page-template-page-about` / `-visit` take a Peppercorn ground ≤ 991px so the bar's 8px corners don't cut a Paper notch into the hero. One ground at every section (decided; the ground-aware alternative is recorded in the brief). Scroll-away / return on scroll-up is a later task. Verified in headless Chrome at 402×874, both themes |
| `hero.css` | **20 Sep 2026:** desktop row — `--hero-air` 32px floor above/below the copy, `--tile` also limited by height (`max(168px, 100vh − 612px)`); bento — `row-gap` 20 (tablet 32) with the active tile's `margin-bottom: -8px`, night headline Lemon + subhead Parchment *on trial*. 100vh hero section, daypart image grid, tile color stack, Now badge, CTAs, lang-nudge slide-out. Background: `--surface` (day) / `--bg` (night). Headline margin-bottom: 0 (flush with subhead). Subhead max-width: 800px. **Mobile bento (Sep 2026, ≤ 767px; Figma `home-hero-bento-stack` 2048:126962 / day 2048:127658):** hero `min-height: calc(100dvh − 76px)` + `padding-top: 24px` so nav + hero = one viewport with a 24px minimum gap; the content block is one unit centred between nav and connector (`.hero-content { justify-content: center }`, author's call after seeing it in the browser): tiles → 32 → Molot 32/1.04/4% headline, Olive day / **Lemon** night → 12 → Golos 16 `--text-muted` copy → 32 → full-width Reserve, bell trailing via `order` → 36 (`.hero-footer` padding) → connector flush with the hero bottom. The slack splits above and below the block; the nav → grid gap floors at 24px (measured: 113 at 402×874 with 125 below the CTA; 24 / 36 at 375×667 where there is no slack). **Headline size (open):** the final bento frame sets the headline as a raw 32px, not bound to `mealTime/HeadlineFontSize` (56, Party 52) — that variable belongs to the earlier display-sized hero; built at 32 pending the author's call. Tiles: CSS grid `repeat(3, 1fr)`, 12px gap, 2 rows, **two geometries** picked by `data-active` on `.daypart-grid` (set in `daypart-engine.js`): A `"b b l" / "d p p"` for breakfast/party active, B `"b l l" / "d d p"` for lunch/dinner active — the active tile takes the 2-column slot of its row and the other wide slot sits diagonally opposite. Wide inactive = landscape 3:2 (`--img-w`), narrow inactive = portrait 2:3 centred, active = the existing `.is-active` container (`--active-w`); every size derives from the wide span `--span = 2 cols + 1 gap` via `cqw`, so the desktop colour-stack recipes carry over untouched (402 → 234×156 photo, 104×156 portraits). The inactive tile's **colour stack** (not the tile) is `overflow: hidden`, globally — the invisible sheets are `--active-w` wide and pushed the document scroll width on narrow tiles; the clip is delayed past the fade with a discrete `overflow` transition (`allow-discrete`), so a deactivating tile's sheets still fade. Eyebrow, second CTA and the lang-nudge are `display: none` on mobile (the nudge isn't in the frames — open). **Motion (Sep 2026):** `daypart-engine.js` FLIPs the re-placement on phones — every tile and its image wrapper start from their old box (translate for position, inline width/height for size) and the mobile transitions carry width / height / transform on `--ease-gentle` 800ms, with the dim overlay, colour stack and keyline (an inset `outline` on mobile, so it can fade) on `--ease-gentle-flat`; hero ground and headline/copy colours cross-fade on the same clock. Reduced motion: no FLIP, no transitions. Verified by sampling boxes at 30–1000ms after a tap (breakfast → party and breakfast → lunch): continuous interpolation, spring overshoot ≤ 1px, no inline styles left at rest, document width still 402, desktop boxes unchanged. Component diff kept on purpose (author, Sep 2026): the Figma `meal-home-container-opt-2` variants use one sheet order and −1° for every daypart and a level Now pill; the build follows the desktop per-daypart recipes, alternating tilt and riding pill. The Lunch variant's wide inactive tile is 242×161 in the file where every other variant uses 234×156 — built as 234×156. Measured: hero 798 tall at 402×874, fits 390×844 and 430×932, overruns 375×667 by 4px (content-driven) **Page-load entrance (18 Sep 2026):** the last block of the file — keyframes `hero-*`, delay custom properties on `.home-hero`, `.is-booting` (transitions off during the load swap), everything scoped to `:not(.is-settled)`; see the top entry. |
| `buttons.css` | `.btn-primary` / `.btn-secondary` / `.btn-primary-green` component styles, day/night variants, colour/shadow/border transitions on `var(--dur-gentle) var(--ease-gentle-flat)` (the no-overshoot twin — buttons never move), `.btn-icon svg` forced 16×16 |
| `components.css` | Shared: rugged edge pattern (centred tiling — see *Rugged Edge Component*), section-link-word (full-width SVG + day/night swap + reflection 50%/30% opacity — **below 992px the day reflection is at 1 since 20 Sep 2026**, heads only; night is 1 on phones; `height: auto` resolves against the `<img>` width/height attributes so the band reserves its height before the lazy SVG loads), section-header (two-column: title block + CTA slot) **Section header on phones (Sep 2026, ≤ 767px):** column, title block full width, CTAs full width under it; eyebrow keeps H3 18 and the desktop colours (Olive / Cream). Optional `.section-description--mobile` (from `section-header.php` → `description_mobile`) replaces the desktop paragraph ≤ 767px via `:has()`. **Sep 2026:** `.section-link-word--reflection` is opacity 1 by night ≤ 767px (desktop keeps 0.3) — the desktop SVGs scale to a third of their stroke weight on phones and the night dimming turned them dark grey on Peppercorn; the night files carry their own gradient fade |
| `highlights.css` | Menu Highlights section: alternating bg, highlights grid (flex row, gap 24px), highlight card (rounded-12, shadow states, night lime strokes), card image/content/tag styles **Phones (Sep 2026, Figma 2048:126987):** 48px rhythm, `.section-header` dissolved with `display: contents` so the CTAs order under the cards, `.highlights-grid` becomes a snap rail (`overflow-x: auto`, `scroll-snap-type: x mandatory`, bleeds across the 16px gutters, scrollbar hidden), cards `flex: 0 0 min(320px, 100%)`. |
| `menu-preview.css` | Bar & Kitchen preview sections: alternating bg, two-column flex layout (text-left / image-left), dish row component, image badges **Night title fix (Sep 2026):** `.menu-preview-title` Lemon by night at every width (was missing). **Phones (Figma 2048:127019):** column, photo first (`order: -1`), 36px gap, CTA full width, caption label inset 16. Badge re-synced to the `img` component `pill`: no tilt, radius 4, 90% opacity, Golos 400, inset 24 desktop / 16 phones. |
| `menu-section.css` | **20 Sep 2026 (phone rail):** current word = nav word (`__long` / `__short`), 8px padding above and below, whole-pixel geometry against the stuck-rail tremble (38px line → rail 54, photo height `round()`ed, `overflow-y: hidden`), entrance + idle nudge (`.is-parked` / `.is-entering` / `.is-nudging`). Full menu page section layout: hero (4:1 aspect inside `.container`, bottom-only 12px radius, `--img-pos` custom property for per-image focal point), title row (66%/flex-1 with eyebrow + headline + deal slot), two-column dish layout (gap-48), subsection headers (Molot H2, chili-deep → paprika night), deal component (w-352, cream bg, rugged edge top, chili-deep shadow), addons component (w-536, cream bg, gradient-based dashed olive top border with 8px dash/gap, rugged edge bottom), bottom link word border, alternating section bg (`--bg`/`--surface` via `:nth-of-type(even)`, exposed as `--section-bg` so deal/addons rugged edges follow it), remark text style. Night overrides: subsection titles → paprika, eyebrow → cream, addons card text pinned to dark colors on cream bg **Phones (≤ 767px, Sep 2026, Figma `menu-food-mobile-day` 2109:130225):** one column; the title-row wrappers dissolve (`display: contents`) and the pieces are ordered photo → rail → eyebrow → deal → columns; photo, rail and eyebrow each paint a slice of a full-bleed top block on `--section-top-bg` (the *other* ground, i.e. the previous section's), photo 7:3 radius 4, eyebrow closes with 8px radii; deal full width; columns at 24px; section gap 36. **Rail** (`.menu-section-rail`, all widths): the `<h2>` plus, ≤ 767px, the other section words as a snap rail (36px, outlined Olive / Lime night, `scroll-padding-inline` 16, scrollbar hidden); desktop hides the nav **One section at a time (phones, Sep 2026):** `body.menu-single-section .menu-section:not(.is-current) { display: none }`, striping fixed (`--section-bg: --bg`, `--section-top-bg: --surface` for every section), per-section bottom connectors hidden (`:has(> .menu-section__bottom-link-word)`), `.menu-sections-tail` and `.pairing-station__top-word` shown **Rail sticky on phones (Sep 2026):** `position: sticky; top: 76px; z-index: 5` (admin bar: +46); columns `align-items: stretch` + `width: 100%` (a `flex-start` column shrank to its rows' content — the Caesar rows at 683px); tail connector `padding-top: 36px`, no bottom padding, so the word sits on the picker |
| `menu-highlights.css` | Menu page seasonal strip: horizontal snap rail of tilted `menu-highlight-card`s (262 wide, ±1°, un-tilt on hover), bleeds to the viewport edge, bottom connector rule. **Phones (≤ 767px, Sep 2026, Figma 2109:130202):** 2-up grid (16px gaps) instead of the rail, `padding-top: 48px`, card shadow 1 1 2, titles ellipsised, `.menu-highlight-card__link-label--mobile` shown / `--desktop` hidden Eyebrow Avocado at every width (menu-page colour, both Figma frames); phones: container gap 24 with 24 above the connector (title → 24 → grid → 48), card tilts by `nth-child` as the frame's checkerboard; `.menu-highlights__headline-2` (a span in the headline, page-menu.php) is Paprika and block ≤ 767px by night |
| `about-preview.css` | About Preview section: alternating bg, two-column flex (text-left + image-right), stats chips **Phones (Sep 2026, Figma 2048:127039):** `.about-preview-text` dissolved with `display: contents`, pieces ordered title → photo → description → stats (12px icons) → full-width CTA at 36px. Stat labels Golos 400 at every width (were 500). |
| `events.css` | Events/News section: alternating bg, 3-col CSS grid, full-bleed event card (overlaid badge/date/title, gradient scrim), events-link-card, hover states **Phones (Sep 2026, Figma 2048:127051 + card 1260:40711):** header dissolved, CTAs under the rail; `.events-grid` a snap rail of fixed 240×300 cards; body overlay 16px / 82px, one-line ellipsised title, pill inset 16, hover layer parked; day card Parchment + house shadow + Peppercorn title + Soft Peppercorn date + overlay to Parchment 43%; pinned 2px Lemon, no glow; link tile blurred photo under a 75% scrim, Lime text by night. |
| `contacts.css` | Contacts section: split layout (map + form), Google Maps embed, address bar chips, 3-state form (email/phone/success), inline error labels, autofill overrides, `contact-item` component (4-state copy interaction, icon top-aligned `flex-start` + 4px top padding to balance text line-height) **Phones (Sep 2026, Figma 1198:53132):** form, social CTAs and address bar hidden; `.contacts-reserve` booking block, `.contacts-map-wrap` as a "Get directions" band on the other ground (`--bg` day / `--surface` night, bleeds across the gutters) with the map at `clamp(360px, 100dvh − 352px, 400px)` and Golos Medium 13 pill chips, `.contacts-more` Visit pointer. Section padding 48, container gap 24. |
| `mobile-drawer.css` | **Mobile nav drawer (Sep 2026; Figma `Drawer-4-Home-Day` 1341:51991 / `Drawer-4-Menu-Night` 1341:51696).** Full-screen fixed sheet on `--bg`, `display: flex` only ≤ 991px, column with `justify-content: space-between`, padding `16px 24px 34px` (Figma's 62px top includes the iOS status bar; 16px puts the drawer's header row exactly where the site header's is, so the lockup stays put and the × lands on the hamburger's spot). Children `flex-shrink: 0`, sheet scrolls on short viewports (375×667 scrolls ~14px). Header row: same 32px Symbol + 16px wordmark lockup as the header (design draws Molot 22px text — same visual size, one asset), close = 44×44 box with a 12px `c-close.svg` right-aligned, Ash day / **Lemon night as drawn** (brief flags Lemon as highlight-only — open). Nav list: Molot H2 24 / 1.25 / 5% title, Golos 16 description `pb 2px`, 12px trailing icon `pb 8px`, gap 12, `align-items: flex-end`; current item = `aria-current` + `.is-current`: Chili title + Paprika description + Chili `c-Pepper` marker by day, Lime / Lime-light / Lime pepper by night; others Ash / Mushroom. Venue card: `--surface` ground (Parchment + 1px Mushroom border by day, Soft Peppercorn borderless by night), 16px padding, 8px radius, first row 44px; "Kirova 10/25" links the Yandex route URL, VK/IG are 44px icon buttons with the 24px official marks. `.lang-switch--green`: outer border + Mushroom outlined РУС, Olive-filled EN (night: Soft Peppercorn РУС, Lime EN, Mushroom outer). Booking block: Molot H3 Olive / Lime-light title, full-width `btn-primary-green` `tel:` + two `btn-secondary` (`flex: 1`, 12px side padding, nowrap) to vk.me / ig.me. Motion: opacity + 8px rise on the Gentle tokens, off under reduced motion. **Theme rule:** Home and Menu follow `data-theme`; About and Visit get `.mobile-drawer--dark` from the template part (fixed dark hero → dark drawer in every theme, Figma `Drawer-4-Home` 1227:56007). Every night selector is written `:is(html[data-theme="night"], .mobile-drawer--dark) …`, and the modifier re-points `--bg` / `--surface` locally plus mirrors the night `.btn-secondary` (Lime outline). `header.css` turns the hamburger Lemon on those two page templates for the same reason. Verified in headless Chrome: About day/night, Visit day, Home day, Menu night. Mockup-vs-brief items built as drawn (order Home · About · Menu · Visit, bare-chili marker, "News & Events" label, 10/25) — all four still open in `website-brief.md` → Top nav → Mobile |
| `reserve-drawer.css` | **20 Sep 2026:** closed call button's label and icons Lemon (were `#fff`). Drawer overlay, ticket card (top/bottom rugged edges), phone CTA states, copy feedback, social buttons. **≤ 991px (Sep 2026):** the fixed right-edge Reserve tab is `display: none` — no persistent Reserve on mobile per the brief; the hero button, the nav drawer's booking block and Contacts carry it. The drawer itself still opens from those triggers (its mobile sheet layout is pending) **Phones (≤ 767px, Sep 2026, Figma reserveModal-mobile 1198:53322):** bottom sheet — `transform: translateY(100%)` → none on the house spring, 8px top radii, 34/16 padding, 36px between blocks, ticket last (`order`), 64px ×, `max-height: calc(100dvh − 24px)` with internal scroll, safe-area padding. Ground/ticket colours via `--reserve-ground` / `--reserve-card` (the rugged edges read them): desktop Parchment/Paper + Soft Peppercorn by night; phones `--bg` + Parchment. ↗ on the messenger links at every width. `.call-status` is `--text-muted` (Mushroom by night; was Ash). |
| `footer.css` | Footer layout, rugged edge top (in-flow, lime bg, page-specific circle colours via CSS: Paper default for menu day, Soft Peppercorn for menu night via `[data-theme="night"]`, Peppercorn for About and Visit pages via `.page-template-page-about` / `.page-template-page-visit`), stamp logo rotation, nav columns, hours (body-size day labels, semibold ash times), bottom bar. `.contact-item` re-declaration uses `align-items: flex-start` (matching `contacts.css` component definition) **Phones (≤ 767px, Sep 2026, Figma footer-mobile 1245:39505):** Lime block 24/16/20, `.footer-mobile-top` (24px Symbol + Molot H2 wordmark + "Top" link), `.footer-nav` a 2-column grid (GO TO / HOURS, hours labels above values) with `.footer-col--visit` spanning both as the contacts row (grid: phone + address left, 44px social targets right; title, icons and email hidden), 0.5px Ash rules, bottom row `--lime-light` with the copyright centred, 34px + safe-area below. **Home** rugged edge now Parchment / Peppercorn (`.home` override) to match Contacts. **Sep 2026:** menu page ≤ 767px by night the top edge is Peppercorn (the page ends on the phone-only closer, not Location) |
| `menu-hero.css` | Menu page hero: full-viewport section (100vh − header), two-column flex (nav panel + photo stack), photo cross-fade transition, nav item states (outlined/active/hover — fill/stroke/arrow transitions on `--ease-bouncy` 800ms, per the Figma prototype's Bouncy smart-animate), DRINKS door (ticket-day + ticket-night variants), FOOD door (ticket-kitchen variant), FOOD/DRINKS wordmark (absolute bottom-right). Night overrides via `[data-theme="night"]`: section bg → Peppercorn, nav bg → Soft Peppercorn, nav strokes Olive→Lime, active fill Chili→Lime, door inverts (Lime bg / Peppercorn text), description Ash→Mushroom, wordmark Avocado→Lemon. Drinks state overrides via `[data-menu-state="drinks"]`: nav dual-variant active (default=Chili, non-alco=Lime), door ticket-kitchen (Cream bg / Olive text, hover Lemon/Avocado), wordmark Lime. All hover transitions use Figma's Bouncy easing `0.8s cubic-bezier(0.34, 1.56, 0.64, 1)` **Phones (≤ 767px, Sep 2026, Figma 2109:130201):** one column, `padding-top: 24px`, no min-height; nav panel hidden (scoped `.menu-hero__inner > .menu-hero__nav` — the jump panel's sheet shares the class); flush-left `.menu-hero__page-nav` opener (`btn-primary-green`, radii 0 4 4 0); photo level with sheets in an 8px bottom-right pocket (0 / −0.5 / −1°); `.menu-hero__commit` full-width primary; wordmark hidden; `.menu-hero__connector` (foodMenu / drinksMenu SVG, 0.5px Mushroom rule) and `.menu-hero-reflection` (page-menu.php, on `--surface`) Hero = one viewport on phones: `min-height: calc(100dvh − 76px)`, opener `margin-top: auto` + content `margin-bottom: auto` centre the block, connector on the floor Phone stack recipe B via `.menu-hero[data-current-section=…]` (salads / soups / desserts / beer / no-buzz: Chili mid-slot at `left: 4px`, Lemon far); drinks-state description Parchment on phones **Page-load entrance (18 Sep 2026):** the last block of the file plus a separate `(min-width: 992px)` block for the sheet fan — delay custom properties on `.menu-hero`, `--menu-word-outline`, keyframes `menu-sheet-in / -word-in / -word-fill / -sheet-fan`, the label fill and arrow scoped to `.menu-hero:not(.is-settled)`; `.menu-hero__wordmark .molot-text` is `inline-block` there so it can rise. |
| `menu-jump-nav.css` | Menu page sticky jump-nav (Sep 2026): left-edge tab (twin of the Reserve tab — 0×0 fixed anchor at `top: 50%`, `.btn` rotated −90°, edge-side radii 0 / visible side 8px, house shadow rotated into the local frame `-1px 1px 4px`), scrim, and the slide-in panel (`translateX(-100%)` → 0, house Gentle token, ground = sheet colour with a hard-stop 8px Lime strip on the right, plus a 32px off-screen extension for the spring's overshoot). The sheet reuses `.menu-hero__nav` and its children, so the word list, door and every day/night/drinks override come from `menu-hero.css`. `.menu-jump__scroll` holds list + door with auto-margin centring (falls back to top-aligned + scroll on short viewports; the close × stays put). `prefers-reduced-motion`: transitions off **Phones (≤ 767px, Sep 2026):** edge tab `display: none`; panel full width, scroll region 24px gutters — opens from the hero's `.js-menu-jump-open` button only Phone sheet from `kitchen-drawer-day` 1341:49297: Lime edge on the left (gradient + `-32px` Lime extension), sheet `margin-left: 8px` with a 4px top-left radius, scroll region `48 72 48 48`, 16px × in a 40px box at 8 / 9, active word's arrow hidden |
| `dish-picker.css` | Pairing station section (gap-64 inner, gap-48 content) + dish picker component: tag pills (avocado border, olive text, peppercorn active fill), photos pair (gap-8) with the **Shake It! button on their seam** (18 Sep 2026 — replaced the "x" and the "or Shake It!" chip; Figma 2437:71646 / 2437:72125: 48px = 4px ring in the ground + 40px disc, Lemon by day / Cream + 0.5px Lemon hairline by night, Symbol 24px; hover 52 · pressed 52 + the house inset · delay 56 — all `transform: scale`; the slot is centred by `calc(50% − 24px)` offsets, **not `translate`** — `reveal.css` sets `translate: none` while an entrance plays, and the pop landed at the right photo's edge until 18 Sep; GlowYellow `0 0 8px` on a `::after` layer — at rest by night on hover-capable pointers, during the delay beat on touch; values ride `--shake-*` custom properties on `.dish-picker`, About sets the night set in every theme and rings in Soft Peppercorn), ticket card (reserve-drawer pattern: top rugged edge abs, card in flow, bottom rugged edge in flow), card inner elements (YOUR MATCH label, dish name, pairing CTA). Night: title→lime, subtitle→parchment, card bg→cream, shake disc→cream, bottom-edge→cream `!important`. `--img-pos` custom property for focal point control on hero images **Phones (≤ 767px, Sep 2026, Figma 2109:130226):** 48px rhythm, tags as a scroll rail across the gutters, result column (photos then ticket, both full width), bottom connector hidden as the frame draws Re-synced to the frames Sep 2026: section padding 0 (reflection flush at top, connector ends the section), connector shown, ticket wrap radius 8 + card `padding-top: 48px`, night ticket + bottom rugged edge Parchment Phones (18 Sep 2026): `.dish-picker__labels` is the scroller, gutter edge to gutter edge (row `margin: 0 −16px`, padding `0 16px`, gap 8); a two-ended `mask-image` whose 32px fades open only under `.has-more-start` / `.has-more-end` — the pinned `or` + Shake is gone, the rail is 402 wide where it was 240 `.pairing-station__title` tracking `0.04em` (was a fixed 2.56px — wrong at the phone 36) |
| `location.css` | Entrance image (4:1 aspect, bottom-12px radius, `--img-pos` focal point) + Location section (paper bg, 80px vertical padding). **Shared between menu and About pages** — About page reuses `.menu-location`, `.location__*`, `.menu-entrance-img` classes directly. Inner: flex, gap-48. Copy: subheading (avocado H3), title (chili H1 + paprika H1), description (dark-olive body), optional `.location__cta` (margin-top 8px, used on About page for "Get directions" button). Map: 600×400, dark-olive bg, mushroom border, 12px radius, shadow. Night: both sections→soft-peppercorn bg, subheading→lemon, title stays chili/paprika, description→parchment **Phones (≤ 767px, Sep 2026):** entrance photo full-bleed 21:9 no radius; section 48px padding, column at 48px, map 100% × 400 Re-synced to the frames Sep 2026: entrance radius 4, Location Parchment (night Soft Peppercorn) at 48 / 34 with inner gap 24, `.location__title-mid` ("of the": Chili on desktop, Paprika + line break before it on phones); **`.menu-visit-cta`** phone-only closer (Paper / Peppercorn, 48 / 34, text gap 16, 40 to the full-width `primary-green` Reserve button) Title tracking `0.04em` instead of a fixed 2.56px — at the phone H1 (36) the fixed value was 7%, wrapping the headline to four lines; `.location__title` is block flow (was a flex column, which put the new middle span on its own row) with `line2` as a block on desktop and `line1` as the block on phones — desktop still renders its three lines in the 472px copy column, phones two |
| `about.css` | About page, 11 numbered blocks in page order: Hero, Concept (+ dish-picker portrait override), **How It Feels** (word cloud: rows fallback, outline→fill tier colours, `has-focus` 50% dim (30% until 21 Sep 2026), Field layout `.about-cloud--field.is-placed` = absolute words driven by `transform`, no transform transition; quote wheel: snap viewport, ±1° tilted cards, Cream centred card), **Perks stamps** (dark section, per-stamp colour via `--stamp-color` CSS var — Lime/Lemon/Paprika cycle; 120px circles, dashed border + tilt at rest `--tilt: calc(var(--lean) * 4deg)` (`--lean` ±1 alternates by parity, phones flip it; hover halves the angle, active zeroes it), `:active` press `--press: .94`, solid border + Peppercorn fill + lime glow `0 0 16px` active; icons inlined from `assets/icons/` (wifi/kids/dog/sun/star/accessible, `path { fill: currentColor }`) at 24px; label pair `--long` (desktop) / `--short` (phone word); message row: solid line + Molot title + dashed line + Golos description at 90% parchment opacity), **Story** (Parchment/surface bg; text gap 40px, Peppercorn body; founder layout: staggered img-wrap `pr-12 mb-[-12]` + quote-wrap `pl-12`, quote card `rotate(1deg)`, 4px image radius, two-line source attribution; heat-line timeline: Ash axis at 35% on `--axis-top` 28px, Chili `__timeline-heat` sized by `--heat-start`/`--heat-end`, Molot 16 Avocado year labels, outlined `--past` markers that fill on hover/`.is-lit`, filled `--now`; milestone-1 at 24px fixed (not %); entrance pre-states only under `.about-story.is-armed`, played by `.is-in` / `.is-heated`; counter ledger: Paper card + mushroom border, 128px gap, H3 18 Olive label, Paprika 44px counter numbers 1.76px tracking, 13px Ash counter labels 0.56px tracking; `.is-dim`, slot rotation `.is-out`; reduced-motion block), **Dream Guests** (Soft Peppercorn bg via `.about-section--surface-dark`, Cream eyebrow override; 4×2 CSS grid of photo cards linking to VK albums; card: 1:1 aspect, 4px radius, absolute cover image + Lemon/Peppercorn caption pill bottom-left at 90% opacity; 3-state: transparent border default → lime glow `0 0 16px` + `0.5px lime` border + `scale(1.02)` image hover → inset `2px -2px 8px` pressed; `--ease-gentle-flat` 800ms shadow/border transitions, `--ease-bouncy` 800ms image scale; `@media (hover: hover)` gated), **Dream Team** (Parchment/surface light bg; drift strip: `overflow-x: auto` horizontal scroll, hidden scrollbar, `max-content` flex track, 48px gap, `padding-left: max(80px, calc((100vw - 1120px)/2))` aligns with container content edge, 4px Olive `::before` clothesline at pin centre; wall card component: 356px × 3:2, two variants v1 Lime pin `rotate(1deg)` photo `rotate(-1deg)` / v2 Paprika pin `rotate(-1deg)` photo `rotate(1deg)`, hover straightens to 0° `--ease-bouncy` 800ms; Lemon year pill; "To be continued" end card: Soft Peppercorn bg, 8px radius, Light Lime Molot H2; team card grid: 4×2, 24px gap; team card: 260×392px, Parchment bg, 8px radius, 3-state shadow: default `1px 1px 4px` → hover `4px 4px 16px` → fact `1px 1px 4px` Paper bg; 1:1 photo top, Molot 20px name, Golos 14px Ash role, chip pill `16px radius` Avocado border / Olive text; card hover: shadow deepens `--ease-gentle-flat` 800ms, info gap tightens 16→12px 300ms, chip flips to Paprika/semibold/py-2px (card-level `:hover`, not just chip `:hover`), `:active` gives the chip the same Paprika lift as a pressed state at every width (Sep 2026); fact state `.is-active`: Paper bg, `← Name Says` header + Golos 14px message, toggled by `about-team.js`), **Careers** (dark section, Peppercorn bg via `.about-section--dark`, Cream eyebrow override; two-state `jobContent` component via `$has_openings` PHP boolean: **default state** = 3 position cards in flex row + CTA row; **empty state** = single bordered "not hiring" box. Position card: Soft Peppercorn bg, 1px Ash border, 8px radius, 32px padding, 240px fixed height, flex-col justify-between; department pill (Peppercorn bg, Lemon caption text, 90% opacity, 4px radius), meta text (12px 500wt Mushroom), Molot H3 Parchment title, body Mushroom description (2-line `-webkit-line-clamp`), Lime semibold "Apply on hh.ru →" link + 12px `c-arrow-right-outline.svg` arrow; 3-state: Ash border default → Lime border + `0 0 16px` lime glow hover → Lime border + inset `2px -2px 8px` pressed; `--ease-gentle-flat` 800ms transitions, `@media (hover: hover)` gated. CTA row: flex space-between items-start, Paper text (semibold first line + regular second line, max 643px), `btn-secondary` "Send your resume" + `c-mail.svg`. Empty state: Soft Peppercorn bg, Ash border, 8px radius, 48px padding, 240px height, flex center space-between; Molot H2 Lemon title, body Paper description (640px), `btn-primary-green` "Send your resume →" + arrow), **Location** (shares `menu-location` / `location__*` classes from `location.css`; About page adds `location__cta` with `btn-primary-green` "Get directions" + arrow; **night pinned to day (Sep 2026):** `html[data-theme="night"] .page-about …` outranks location.css's night rules so Location keeps Paper (Parchment on phones), Avocado subheading, Dark Olive body and the entrance band Peppercorn — About is a fixed composition, and the light-ground connectors at Location's head and foot need the light ground), **Entrance photo** (shares `menu-entrance-img` from `location.css`; `.menu-entrance-img--dark` override sets Peppercorn bg for About page context between two dark sections), **Visit CTA** (dark section, Peppercorn bg, centered layout; Molot display 76px Lime headline `3.04px` tracking `1.1` line-height, 20px Lime subtitle body `736px` max-width, 16px gap; buttons row: `btn-primary-green` "Reserve a table" + `c-phone.svg` phone icon `.js-reserve-trigger` + `btn-secondary--dark` "See the menu" + `c-arrow-right-outline.svg` arrow; dark `.btn-secondary` overrides: lime border/text, hover cream bg/peppercorn text). Fixed composition — no daypart theming on this page. **Phones (Sep 2026, ≤ 767px, Figma `About-mobile-opt2` 1490:78249) — one block at the end of the file:** connectors at every width (global rules before the phone block: 80px margins on desktop, 48 on phones, `section:has(> .about-connector--head/--foot)` drops the section padding on that side; reflection opacity keyed to the ground it opens — `.about-section--dark > .about-connector--head` 0.3 / 1 on phones, otherwise 0.5; the hero's container gives up `min-height`/`padding-bottom` so the connector sits on the 100vh floor); **hero** = `calc(100dvh − 76px)`, column gap 16 with the lead's `<p>` margins zeroed, 36 to a 6-column grid (items 1–2 span 3 at 3:2, 3–5 span 2 at 1:1, 12px gap), overlay transparent + Lemon pill at rest, 48 to the connector; **pressed state at every width** = Lime 1px + `inset 2px -2px 8px` 25% on the overlay (the shared card recipe; the hero's old 24px inset / 4→8 radius is gone) and the hover rules gated `(hover: hover)`; **concept** dissolves its two columns (`display: contents`) and orders header → picker (Soft Peppercorn band bleeding the gutters, `flex: none`) → CTA; **how-it-feels** = cloud over one card (Sep 2026): `.about-how-it-feels__inner` column at 24, the cloud forced static (`position: static; height: auto`, rows `display: contents`, words static/untransformed) as a centred wrapping flex with 12/2 gaps and 3/2 word padding, tier sizes 40 / 26 / 18 via `--cloud-size-phone` (the template's inline `--cloud-size` would beat a plain override), stroke 1px — the static/wrap rules are scoped to `.about-cloud:not(.is-placed)` so the field's placed state wins once JS has run; the viewport height comes from JS (tallest card + 8); CTA 36 below; **perks** 3-col grid of 120px-min cells, dashed 72px circle on the icon span, the phone word under it, the whole button tilting (even +4° / odd −4°, the phone frame's lean), colour from `--stamp-color-phone` (per-row deal from the template), 36 from the title and 24 to the detail column; **story** dissolves inner/text/body and orders header → founder → ¶1 → timeline → ¶2 → ¶3 → ledger, timeline = year control in a Parchment tray drawn by `::before` (the milestones are `display: contents`), Paper segments radius 4, `.is-current` Chili + Lemon, name H1 + wit shown for the current only, axis/heat/ticks hidden, no card border; ledger = borderless Paper card rotated 1°, `rugged-edge` top (Parchment) and bottom (Paper) at ±1px, Mushroom rule under the header, rows number-left (Molot 24) / label-right (Golos 14) bottom-aligned on Avocado rules; founder `<img>` gets `height: auto` globally so the attribute height can't pin it; title group `display: block` with the two headline parts inline so it runs one line where it fits; founder quote card `gap: 16px` (mark → text); **guests** 2-col, header gap 24 (frame), title parts inline as Story; **team** drift at 240 / 24 gap; the card grid is a **column of row cards** (Sep 2026): `.about-team__card-default` as a row (88px photo, 12px padding, info gap 8), chip hidden on cards without a message, `.about-team__card-active` always in the box as a `grid-template-rows: 0fr` reveal (1fr + `visibility` when `.is-active`, 300ms flat; its photo and name-row hidden, message padded to the text column at 116px), card Paper when active; **chip open state (17 Sep 2026)** — `[aria-expanded="true"]` holds Paprika border/text and turns the chevron 90° to point down (transform on `--ease-gentle`, the chip is entry and exit on phones — the desktop face's back arrow is hidden here); `max-width: none` on the card — the tablet pass's 260 cap had reached phones and clipped the chips at 430 (found and fixed 17 Sep 2026); **careers** stacked; **visit CTA** left-aligned, buttons stacked. Verified in headless Chrome at 402×874 (full page), 375×667 (hero overruns by 4px, same as home) and 1280×900 (no phone rule leaks) **Hero page-load entrance (18 Sep 2026):** a `no-preference` block directly after the hero rules, reusing the `hero-*` keyframes from `hero.css`; CSS only. |
| `visit.css` | Visit page — fixed dark · light · dark composition (no day/night theming). **Page-level**: no `scroll-behavior: smooth` any more (Sep 2026) — in-page anchors ride a Figma-Gentle spring in `gentle-scroll.js`; the CSS rule was the browser's own short ease and would also have smoothed the script's per-frame `scrollTo()` on top of the spring. Formerly: `scroll-behavior: smooth` scoped to `.page-template-page-visit` for in-page anchor scrolling (Directions → `#visit-map`). **Hero** (100vh, Peppercorn bg): site header is `position: absolute` (transparent overlay), so hero fills full viewport. `.visit-hero__frame` flex-col with `justify-content: center` vertically centres the entire header+content composition; `margin-bottom: 80px` for breathing room. Header overlap via `margin-bottom: -40px` on `.visit-hero__header` (CSS doesn't support negative flex gap; Figma's -52px adjusted for CSS tilt geometry). heroMessage (Lime-light eyebrow, Chili headline, Paper description, flex row gap-48, `padding: 132px 80px 48px` — top clears the absolute nav 96px + 36px gap, bottom 48px for balance with the band); statesContainer band (`height: 44px, rotate(1deg)`, Lime bg, full-width, `--band-lead` text + bar/kitchen state pills — band tilts clockwise, opposite to contacts card's `-1deg`); heroSplit (hours card + contacts card, flex row gap-48, natural height, max-width 1280px centred). **State pills**: bar = Peppercorn bg, kitchen = Soft Peppercorn bg; Molot 16px 0.64px tracking; label colours Lime/Lemon for alive states, Paprika for closed; dot colours Lime/Lemon default, Orange `#e8751a` transitional, Paprika closed; icon SVG colour overrides for closed state. **Hours card** — rugged ticket pattern (same as reserve-drawer + dish-picker): container `overflow: hidden; isolation: isolate`, top edge `position: absolute; top: -1px` z-3, card in flow z-2, bottom edge in flow z-1; edge colours: top = Peppercorn (section bg bites in), bottom = Parchment (card extends out); card = Parchment bg, 8px radius, pt-24 pb-36 gap-24; hoursContainer (gap-16 pt-24 px-24), list-group (gap-24 between regularHours and nextEvent), hours-block (gap-12 per group); next-event (Cream bg, 4px radius, py-8 px-16), party icon fill overridden to Chili Deep; CTA (Olive Golos SemiBold, `c-arrow-right-outline` icon, links to Instagram EN / VK RU via `get_locale()`). **Contacts card**: Soft Peppercorn bg, 1px Ash border, 8px radius, `rotate(-1deg)`, 48px padding; Chili chip pseudo-element top, Lemon Molot title, contact sections (phone/VK/IG/email/location), Lime action links; Directions link anchors to `#visit-map` with `arrowDown.svg` icon (`currentColor` fill); hover: card straightens `rotate(0deg)` + lime glow `drop-shadow(0 0 4px rgba(212,230,113,0.5))`, pin adjusts `rotate(2deg)→rotate(1deg)`, `--ease-bouncy` 800ms, `@media (hover: hover)` gated; scoped dark colour overrides for contact-item (icon→Lime, text→Paper, supportive→Mushroom). **Location section** (`id="visit-map"`, 100vh, Parchment bg, 80px vertical padding): header row `align-items: center`; deal chip reuses `menu-section__deal` component (no bespoke CSS); map container fills remaining height via flex chain; `.visit-location__map` parent frame keeps `border: 1px solid mushroom, border-radius: 12px`; inner `.location__map` overridden to strip its 600px width, border, radius, box-shadow for flush fit. **CTA section** (Peppercorn bg, 80px padding): two-column split (gap-48, `align-items: center`). Left closure: Lime Molot H1 headline, 3:2 photo (`door-entrance.jpg`, 4px radius), Lime body copy, CTA buttons row (btn-primary-green "See the menu" + btn-secondary--dark "More about Sweet"). Right: contact form with scoped dark overrides (visit page doesn't use `data-theme="night"`): `.visit-cta .contact-form` Peppercorn bg, `.contact-form__title` Lime, `.contact-form__subtitle` Paper, `.contact-field__label` Paper, `.contact-field__input-wrap` transparent bg, `.contact-field__input` Paper, autofill overrides (Peppercorn inset shadow + Paper text), counter/toggle-helper Paper; success state: badge Avocado, title Lime, body Parchment, info-box Ash border, info-label Mushroom. Custom subtitle via `$args['subtitle']`. **Sep 2026 (Visit mobile):** phone block built from `Visit-Mobile-opt2` 1441:72385 — running status rail, ticket with square corners + phase-shifted scallops, contact-card settle, Getting here reordered (title → slip → map → chips → badges), landmark badges as route switches, 21:9 photo band, booking block, full-bleed form. Plus a Connectors block (both widths) for the two seams **Hero page-load entrance (18 Sep 2026):** the last block of the file — `visit-band-lay`, `visit-print`, `visit-drop`, `visit-dot-on` plus the shared `hero-*` keyframes; all on `translate` / `scale` / `clip-path` because band, card, pin and the phone slip own a `transform`; CSS only. |
| `reveal.css` | **21 Sep 2026:** `.has-reveal { overflow-x: clip }` is now only on sections that hold a `mask-right` element — never above a `position: sticky` element (the iOS rail tremble). **18 Sep 2026.** Scroll-in entrances (`[data-reveal]` × `.is-armed` / `.is-in`: `rise`, `mask-up`, `mask-down`, `mask-left`, `mask-right`, `pop`; single-element stationary masks — `translate` + `clip-path` on one curve, so they compose with an element's own transform, resting clip −24px so shadows aren't shaved), `.has-reveal` overflow guard, `.count-up__n`, and the two CSS scroll-driven effects: connector parallax (heads only) and preview photo drift. All inside `prefers-reduced-motion: no-preference` Later the same day: effects moved from `transform` to `translate` / `scale`; parked clips 0 on the leading side; `mask-down` on the Gentle spring (the ticket); `link-text-close` for live-text reflections (About, Visit); `entrance-drift` (About's "The way in", `object-position`); `@property --band-drift` + `band-drift` for the menu section photo bands, whose focal point is now `--img-x` / `--img-y`. |

### JS (`src/js/`)
| File | Purpose |
|---|---|
| `daypart-engine.js` | **20 Sep 2026:** closed state — reads `<html data-closed>`, gives the parked tile the closed headline/subhead, no Now marker while closed. Reads the current daypart from `<html data-now>` (set before paint by `inc/daypart-head.php` — the engine no longer computes the hour; 18 Sep 2026), runs the load swap for the hero entrance (`activateOnLoad`, `.is-booting`, `.is-settled`), scrambles the headline on tile taps (`scramble-text.js`), tile click → `.is-active` swap (+ `data-active` on `.daypart-grid` for the mobile bento geometry), day/night theme toggle, hero copy updates, lang-nudge slide-out dismiss. **URL overrides:** `?theme=night` forces night mode on any page; `?daypart=dinner` (or `party`/`breakfast`/`lunch`) selects a specific daypart, overriding the clock. URL takes priority → tile click → clock default |
| `bar-clock.js` | The modules' door to `window.spBar` (set by `inc/daypart-head.php`): `getBarStatus()` → `{ day, mins, open, opens, closed }` on the bar's clock and hours, `getBarHours()`, `formatBarTime()`. Every state engine asks here (20 Sep 2026). |
| `reserve-drawer.js` | Drawer open/close, bar state engine (available/busy/closed, on the bar's clock via `bar-clock.js`), copy-to-clipboard with visual feedback **Sep 2026:** the drawer is a dialog — `inert` + `aria-hidden` while shut, focus to the × on open and back to the opener on close, Escape closes, Tab trapped. Bar state applies to every `.phone-cta-wrapper` on the page (the drawer and, on phones, the home Contacts block). **Sep 2026:** no longer builds icons — all three status marks ship in the markup and CSS shows the one `[data-bar-state]` names; the copy handler only swaps the label. |
| `contact-form.js` | Contact form: email↔phone toggle, textarea char counter, client-side validation with inline errors, clipboard helper, contact-item copy interaction (4 states), success state transition + reset |
| `mobile-drawer.js` | Mobile nav drawer (rewritten Sep 2026): `.js-drawer-open` (header hamburger) opens `#mobile-drawer`, `.js-drawer-close` / Escape close; `inert` + `aria-hidden` while closed, `aria-expanded` mirrored on the openers, focus trap (Tab / Shift-Tab wrap, same pattern as `menu-jump-nav.js`), body scroll lock, focus returns to the opener, and a `matchMedia(min-width: 992px)` listener closes it if the viewport grows past the nav breakpoint |
| `menu-hero.js` | Menu hero hover interaction: on mouseenter transfers active state to hovered nav item, cross-fades photo (500ms opacity), swaps caption + description. On mouseleave reverts to default section (200ms debounce). On click smooth-scrolls to section anchor. **18 Sep 2026:** opening frame = daypart answer; desktop idle sweep, stops for good on first use (see the 18 Sep entry). Preloads all section images on init **Sep 2026:** keeps `hero.dataset.currentSection`; listens for `menu-hero:preview` (from the phone drawer) — swaps photo / caption / description and the phone commit button's label + `href` (`sections_json` now carries `label`) `updateCommit()` swaps label, `href` and the glyph (`.btn-icon-left` innerHTML) **Entrance gate (18 Sep 2026):** adds `.is-settled` to the hero on the first `pointerenter` / `focusin` / `touchstart` in the nav, or after 2.6 s, so a hovered (or swept) word never replays the load fill. |
| `menu-jump-nav.js` | Menu page jump-nav: IntersectionObserver on `.menu-hero__nav` shows the edge tab only once the hero nav has scrolled *above* the viewport (`!isIntersecting && bottom < 0`) and hides it again on the way back (closing the panel if open). Panel open/close by tab, ×, scrim, Esc; focus trap (Tab/Shift-Tab wrap), body scroll lock, focus returns to the tab. Picking a word closes first, then `gentleScrollTo()` (house spring, overshoot-capped; instant under reduced motion). A second observer (band `rootMargin: -45% 0 -50% 0`) keeps the active word (`.is-active` + `aria-current`) on the section in view **Sep 2026:** every `.js-menu-jump-open` opens the panel (edge tab + the phone hero button); focus returns to the tab only when it is visible and rendered, else to the opener Phones (`matchMedia ≤ 767px`): a word closes the panel and dispatches `menu-hero:preview` instead of scrolling; `open()` syncs the active word to the hero's section On phones the section-anchor interceptor in `menu-single-section.js` skips links inside the panel, so drawer words keep previewing |
| `menu-rail-nudge.js` | **20–21 Sep 2026.** Phone menu rail discoverability: once-per-section entrance as the rail crosses 66% of the viewport (words parked until then), idle nudge every 2.5 s for an untouched rail; both end for the visit at the first touch (`sessionStorage spRailLearned`). Addresses the scrolling ROW (`.menu-section-rail__nav`), not the sticky bar. |
| `menu-single-section.js` | **Menu page on phones — one section at a time (Sep 2026).** Below 768px sets `body.menu-single-section` and `.is-current` on one `section.menu-section`; initial = URL hash if it names a section, else `hero.dataset.currentSection`. A capture-phase click listener catches every same-page anchor to a section (rail words, hero commit button, highlight cards — not the jump-nav panel) and switches + `gentleScrollTo()` instead of the plain scroll (`stopImmediatePropagation` keeps gentle-scroll's binder off it); `menu-hero:preview` switches without scrolling; `hashchange` follows back/forward; `replaceState` keeps the hash current. Crossing the breakpoint removes the class and shows every section. Measured: food page 17,490 → 6,035px, drinks 22,256 → 4,656px at 402×874 `alignRail(section)` sets the rail's `scrollLeft` to the current word's `offsetLeft − 16` on every switch and on load |
| `dish-picker.js` | Dish picker interaction: tag click → swap photos + **re-print the ticket** (18 Sep 2026: retract → write out of sight → print on the Gentle spring; interruptible; reduced motion swaps in place), `.is-active` state on tags. **19 Sep 2026 — the photos roll:** `rollPhoto()` clones the outgoing photo as `.dish-picker__photo-ghost` (decoded, so it covers while the new `src` decodes), parks the real `<img>` behind the mask, then rolls both by frame height + 8px on `translate` — plate down, glass up + 80 ms, 900 ms `--ease-out-expo`; a pick mid-roll continues from the strip's current offset, a pick mid-decode keeps the ghost and changes what is coming; the `isTransitioning` lock is gone (`currentIndex` is set at once, last pick wins); reduced motion keeps the crossfade. Shake It! button → random pick; **18 Sep 2026:** the shaker spins one turn (900 ms, Gentle spring, overshoots ≈ 372° and settles; `rotate` on the icon), and on `(hover: none)` the **delay state runs as an idle hint** — first beat 2.5 s after the photos are 60% in view, then every 5 s; a tag pick seizes it for 8 s, the first Shake ends it for the visit; none under reduced motion. `markRail()` toggles the rail's `has-more-start` / `has-more-end` on scroll, resize and `fonts.ready`. Reads pairing data from inline JSON. Updates `src`/`alt` on food and bar images, card dish name, description, pairing text, and CTA link **Sep 2026:** `alignTags()` scrolls the picked tag to the 16px gutter of the phone tag rail (instant on load, smooth on a pick, no-op when the row doesn't scroll) — the default pick was off-screen on phones aligns `.dish-picker__labels` (not the row) and re-runs on `document.fonts.ready` |
| `location-map.js` | Geo-detected map provider. Checks `Intl.DateTimeFormat().resolvedOptions().timeZone` against Russian timezone prefixes + `navigator.language` fallback. Russian locale → Yandex Maps widget embed; everyone else → Google Maps custom "My Maps" embed (`mid=1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY`). Injects `<iframe>` into `.location__map` container at DOMContentLoaded. No API keys needed **Sep 2026:** the injected iframe is no longer `loading="lazy"` — a script-inserted lazy iframe is fetched only when the browser judges it near the viewport, which is unreliable for inserted frames (WebKit) and stalls in a hidden document; the author saw an empty dark-olive box on the phone menu page. Verified rendering in headless Chrome with both providers (Google; Yandex via a Europe/Moscow timezone override). **Sep 2026:** also exports `initVisitMapRoutes()` — the Visit landmark badges reload the embed with a per-route My Map id; sets `data-provider` on the container and no-ops when the provider is Yandex |
| `contacts.css` (team-form dialog) | **Sep 2026:** `.team-form-dialog` gets `max-width: calc(100vw - 32px)`. It is fixed, 558 wide and centred; while hidden it still poked 78px past a 375 viewport and WebKit grew the layout viewport to its right edge (453) — the About page rendered wide, header included. Chromium never showed it. Phone design for the dialog itself still owed (footer row overflows the capped width) |
| `how-it-feels.js` | About → How It Feels: quote wheel (3-card snap viewport, 3N cloned cards for the infinite loop, one 3.5 s clock, 8 s seizure on any interaction) + **Field word cloud (layout B)**: measures words in the row layout, spiral-places them (largest first, no overlaps), orbits them around their homes, leans them toward the pointer; click fills + centres a word and runs a make-room relaxation so nothing sits behind it; release eases everyone home. Constants at the top: `FIELD_INSET 16`, `WORD_GAP 12`, `COMMIT_MARGIN 28`, `FIELD_MIN_H 480`, `MOBILE_BP 768`. **Sep 2026:** the viewport is re-measured on `document.fonts.ready` — sized once at init, the cards re-wrapped when Golos swapped in and the third card was clipped at phone widths. **Phones (< `MOBILE_BP`):** `sizeViewport()` fits **one card** at the tallest original's height (+8); the field runs at every width (the `< MOBILE_BP` early return is gone; `FIELD_MIN_H_PHONE 380`; orbit amplitude halves below the breakpoint), a word tap adds `has-focus` (dim the rest) instead of `commitField`, and `advanceNext` / the 8 s release clear it — nothing moves on phones. Resize always re-places. Hue is the template's `data-hue`, not the tier. **Timing (Sep 2026):** `CLOCK_INTERVAL 5000` (was 3500), `ROLL_MS 900`; `scrollToQuote()` tweens `scrollTop` through `gentleEase()` (the `--ease-gentle` bezier solved by Newton iteration — overshoots, settles) with snap and `scroll-behavior` off for the tween and restored a frame after; `cancelRoll()` on wheel/pointerdown. `seizeClock()` sets `userTookOver` and `startClock()` refuses forever after (the IntersectionObserver re-entry included); the `SEIZED_PAUSE` timeout now only releases the field / `has-focus`. See *How It Feels* section below |
| `about-perks.js` | About → Beyond Shake & Cook: reads perk data from an inline JSON script, stamp click → `.is-active` + detail area (title + description) update |
| `about-story.js` | About → The Pepper Story: one-shot entrance keyed off the **timeline** at 50% in view (was the section at 35% — never reached on short phones), the ledger clock keyed off the ledger's own visibility; entrance (axis draws → ticks/labels pop → arrowhead lands → heat line runs 2009 → arrowhead → counters count up), milestone hover (outline → fill, heat retracts to the hovered year, ledger dims on `data-dims-ledger`), counter-slot rotation on a 4 s section clock (only when the JSON pool has more entries than slots), 8 s seizure on ledger hover, clock paused off-screen. Constants at the top: `ROTATE_MS 4000`, `SEIZE_MS 8000`, `COUNT_MS 1400`, `HEAT_DELAY 500`, `COUNT_DELAY 1300`. **Phones (Sep 2026):** marks one milestone `.is-current` (starts on `--now`, a tap on a year moves it) for the segmented year control in `about.css`; desktop CSS ignores the class, and the ledger dim on the 2009 tap applies < 768 only. See *The Pepper Story* section below |
| `about-team.js` | About → Dream Team: chip click toggles `.is-active` on the card (one open at a time), back arrow closes; the class drives both layouts — desktop CSS swaps the default face for the active one, phone CSS keeps the row and reveals the active layer under it — so JS moves only the active layer's `hidden` and the chip's `aria-expanded` — on phones that attribute is also what the chip's open state (Paprika, chevron down) is keyed to, since the back arrow is hidden there |
| `team-form.js` | About → Dream Team: "Write to the Team" form modal. Open/close (`.js-team-form-trigger` → `.is-open` on overlay + dialog, Escape key, body scroll lock). Name chips (All master toggle + individual toggle, at least one always active). Validation mirrors `contact-form.js` (name required, email regex, message required → `.contact-field--error`). Textarea 0/500 counter. Submit → `data-form-state='success'`. Reset → compose state, clear errors/chips. Client-side only |
| `visit-hero.js` | Visit page hero state engine. Reads the bar's clock (`bar-clock.js`) (or `?visit-state=open\|last-orders\|bar-snacks\|last-call\|closed` override), sets `data-bar-state` + `data-kitchen-state` attributes on the state pills, updates band-lead copy and pill labels. **Corrected 20 Sep 2026 to match the code** (this row had carried an older draft's slots and leads): open → 22:00 bar open / kitchen on, "Good news!" · 22:00–01:00 kitchen last orders, "Still time to eat" · 01:00–01:30 bar winding down / bar snacks only, "Winding down" · 01:30–close bar winding down / kitchen closed · closed → "See you soon". Doors (opening, close, Sunday 10:00) come from Bar Settings via `bar-clock.js`; the kitchen stages are still constants in this file. |
| `gentle-scroll.js` | **Site-wide in-page scroll (Sep 2026).** `gentleScrollTo(el)` integrates Figma's **Gentle** spring (mass 1, stiffness 100, damping 15; ζ = 0.75) with semi-implicit Euler in 1 ms sub-steps per rAF frame, writing `scrollTo({behavior:'instant'})` each frame. On a 720px jump: 72% at 200 ms, 94% at 300 ms, settled by ~800 ms — vs Chrome's native smooth scroll, which is shorter and stops dead. **Overshoot is capped at 24px:** Gentle overshoots ~2.8% of the distance, fine for a screen, a 200px lurch on a 7000px menu jump — so damping is raised per ride to keep the landing ≤ 24px (attack and settle time unchanged; measured 21px on 7100px and 7900px rides). Any wheel / touch / key input cancels it; `prefers-reduced-motion` jumps instantly; anchors `pushState` their hash on arrival. `initGentleScroll()` binds every `a[href^="#"]` except `.skip-link` (must move focus, not animate) and the hero words (bound in `menu-hero.js`); `menu-hero.js` and `menu-jump-nav.js` call `gentleScrollTo()` directly. No `scroll-behavior: smooth` anywhere except the How-It-Feels quote wheel's own snap viewport **Sep 2026:** subtracts the target's computed `scroll-margin-top` (fixed mobile header) |
| `reveal.js` | **20–21 Sep 2026:** an armed root that loses its box is released; listens for `reveal:check` (a change with no scroll — the phone menu swapping its section); `arm()` tags a section `.has-reveal` only for `mask-right`. **18 Sep 2026.** Scroll-in entrance engine — page plans (`HOME`, `ABOUT`, `VISIT`, `MENU`: effect → selectors, optional `delays`) at the top, tuning constants under them (`REPLAY`, `STAGGER`, `NESTED_AFTER`, `FALLBACK`, `LINE`, `WAKE`, `REPARK`, `RIDE`), **ride suppression** (nothing plays above 4 viewports / s; roots left above the screen are released unplayed), inline two-part titles handed to their parent block; registered last in `main.js` with `count-up.js` after it; arms / plays / releases each element once, **triggered by layout position (offsetTop chain), not IntersectionObserver**, batch stagger 120 ms, lazy-image wake-up, nested reveals sequenced off their parent, `reveal:in` event, and the replay-from-below trial (`REPLAY`). Does nothing under reduced motion. See the top entry |
| `count-up.js` | **18 Sep 2026.** `[data-count-up]` numbers count from 0 once when their armed ancestor fires `reveal:in` (600 ms wait, 2.4 s ease-out quad, width held). Must init after `initReveal()` |
| `scramble-text.js` | **18 Sep 2026.** `scrambleTo(el, target, duration)` — dependency-free scramble for Molot: pool from the target's letters, box held, interruptible, reduced-motion and screen-reader safe. Used by the home headline on tile taps |

### PHP Components (`template-parts/components/`)
| File | Purpose |
|---|---|
| `mobile-drawer.php` | Mobile nav drawer markup (rendered by `header.php` right after `</header>`, hidden ≥ 992px by CSS). `role="dialog"`, `aria-modal`, starts `inert`. Nav items are a PHP array (label / guest-voice description / url / current-page test mirroring the header's), current item gets `aria-current="page"` and the chili marker instead of the arrow. Buttons via `button.php` (`primary-green` + `icon_left_svg`) "You are here" marker inlined via `sweet_pepper_inline_svg()` (Sep 2026). Inline icons via `sweet_pepper_inline_svg()` (Sep 2026 — see Custom SVG Icon System → Inline rule) |
| `reserve-drawer.php` | Fixed Reserve tab (hidden ≤ 991px) + scrim + `#reserve-drawer` dialog (`role="dialog"`, `aria-modal`, starts `inert`): header, ticket (rugged edges read `--reserve-ground` / `--reserve-card`), phone CTA, VK / Instagram links with ↗, footer line. Desktop right-edge panel, phone bottom sheet — see `reserve-drawer.css`. Rendered by `footer.php` after `#page` |
| `button.php` | Reusable button with `icon_left` / `icon_right` (Phosphor) + `icon_left_svg` / `icon_right_svg` (inline SVG via `file_get_contents`). SVG icons support `currentColor` for theme adaptation **Sep 2026:** inline SVGs go through `sweet_pepper_inline_svg()` (per-instance unique ids — see `inc/inline-svg.php`). |
| `components/connector.php` | **New Sep 2026.** Shared section-connector part for the fixed compositions (About, Visit). Args: `set` ('about' \| 'visit' → `assets/sectionLinks/{set}/`), `word` (file stem), `position` ('foot' = the word, 'head' = its reflection), `alt`. Emits `.{set}-connector--{position}` so each page's CSS owns rhythm and reflection opacity. One `$live_text` flag here switches both pages between the SVG exports and the live-text prototype |
| `section-link-word.php` | Full-width SVG text with day/night image swap, optional `class` for reflection modifier. Each `<img>` carries `width`/`height` read from the SVG's viewBox (`sweet_pepper_svg_dimensions()`) so the connector reserves its height before the lazy file loads — without it anchor scrolls on the menu page land short by the height of every connector above the target (fixed 2026-09-10) First use of `foodMenu` / `drinksMenu` and their `-reflection` SVGs: the phone hero connector (Sep 2026). About page: wrapped by `template-parts/about/connector.php` (below) **18 Sep 2026:** optional `loading` arg (`lazy` default, `eager` for a word in the first viewport — the hero's foot word). |
| `about/connector.php` | About connectors, both widths (Sep 2026). `word` (file stem in `assets/sectionLinks/about/`, nine words + `-reflection` twins, **~1080-wide exports of the Figma `SectionLink` desktop component with colours baked per ground** — one file per word/state for day and night, About being a fixed composition) + `position` (`foot` = the word ending this section, `head` = its reflection opening the next). Emits `.container.about-connector--{head,foot}` around `section-link-word.php` with the same file for both themes; skips silently if the SVG is missing. The exports came out of `download_assets` *in context* (canvas rect, holder fill, frame border, a 50% wrapper) and were reduced to the bare text group + gradient defs with a script, ids suffixed per file; re-export the same way if a word changes. The earlier 370-wide `SectionLinkMobile` set is retired (2.3× the ink of a home connector at phone width). **Sep 2026:** now a thin wrapper over `components/connector.php` |
| `menu-section-rail.php` | **Sep 2026.** The menu section headline at every width: `<h2 class="section-headline">` + a `<nav>` of the other section words as same-page anchors (rendered ≤ 767px as the phone rail, `display: none` on desktop). Args `current` (slug) and optional `headline` (Kids "For Little Peppers", Salads "Pepper's Salads", Sandwiches "Sandwiches & Bagels"). **Canonical order with the `<h2>` in place** (Sep 2026; the earlier current-first wrap-around made the previous section unreachable); `menu-single-section.js → alignRail()` scrolls the current word to the 16px gutter. State (food / drinks) derived from the slug via `sweet_pepper_menu_state_for()`. Replaced the `.section-title-lines > h2` block in all 16 section files and page-menu.php |
| `menu-sections-tail.php` | **Sep 2026, phones only.** The single "try the match maker" connector rendered after the last section of each state (`menu_state` arg; the bar uses the kitchen-night SVG in both themes — no bar export of this word); `pairing-station.php` / `-bar.php` carry the matching phone-only top reflection (`.pairing-station__top-word`) |
| `menu-highlight-card.php` | Seasonal-strip card (photo 3:2, Molot 20 title, section link). **Sep 2026:** optional `link_label_mobile` (rendered as a second span; CSS swaps ≤ 767px) Inline icons via `sweet_pepper_inline_svg()` (Sep 2026 — see Custom SVG Icon System → Inline rule) |
| `section-header.php` | Two-column: title block (eyebrow + headline + headline_2 + description) + CTA slot **`description_mobile` (Sep 2026):** optional shorter paragraph rendered as `.section-description--mobile`, shown ≤ 767px in place of `description`. |
| `contact-form.php` | 3-state form card (email/phone/success). Email↔phone toggle pills, inline error labels in label row (Paprika), autofill bg overrides, success state with contact-item components. Day/night themed. Accepts optional `subtitle` prop via `$args` (default: "We'll get back to you within 24 hours.") — visit page passes a longer page-specific variant. **Sep 2026:** optional `topics` (topic chips, mirrored into a hidden `topic` field for email triage) and `title_prefix_mobile` (the Visit page's "or " before "Send a message"); both off unless passed |
| `contact-item.php` | Reusable contact row (Figma: `contactItem-day` 1819-128718). Props: `icon_svg`, `contact`, `copy_text`, `supportive_text`. 4 CSS+JS states: default (chip hidden via overflow-clip), hover (chip reveals), hover2 (chip bg → lemon), success (Copied! + pepper icon, 2s revert) |
| `team-form.php` | "Write to the Team" centred modal dialog. Two states via `data-form-state`: "compose" (Molot H2 Chili title, To: row with name chips `All/Lera/Lenya/Iura/Anton`, three `.contact-field` inputs: name/email/message, CTA row with hint text + btn-primary-green Send) and "success" (Avocado badge, Molot 36px Olive title, body copy, two `.team-form__info-box` with `contact-item` for email + phone, full-width btn-secondary reset). Fixed overlay scrim + dialog card (558px, Paper bg, 12px radius). Opened by `.js-team-form-trigger`, closed by `.js-team-form-close` / scrim / Escape. Managed by `team-form.js` |
| `highlight-card.php` | Dish card: image (3:2), title + price row, description, tag (inline SVG icon + label) |
| `dish-row.php` | Menu row: name + icons + seasonal badge + quantity, description, options (bulleted), price. `highlight` bool prop → olive/lime name color for hits & seasonal items Inline icons via `sweet_pepper_inline_svg()` (Sep 2026 — see Custom SVG Icon System → Inline rule) |
| `rugged-edge.php` | Scalloped edge pattern (12px height, radial-gradient, 48px tile). `color` prop sets `--rugged-color` to any token (e.g. `'cream'`, `'paper'`). Inside `.menu-section` pass `'section-bg'` — the section's striped ground — never `'bg'`/`'surface'` directly |
| `menu-preview.php` | Two-column section: text side (title + dish rows + CTA) + image side. `layout` prop flips order |
| `event-card.php` | Full-bleed image card: category badge (event/promo/community), date line ("Today!" auto-detection), title overlay, gradient scrim. Links to VK/IG post **Phones (Sep 2026):** the date row trails the source's brand mark (`vk.svg` / `insta.svg`, 16px, decorative — hidden on desktop) since touch has no hover layer. |
| `events-link-card.php` | "See all events →" tile: background photo + dark overlay + centered link text. 6th slot in events grid |
| `menu-hero.php` | Menu hero "Side-Nav Poster": left nav panel (9 food / 7 bar section links + cross-menu door) + right photo stack with caption pill + description. `menu_state` prop switches between food and drinks: swaps section data, door label/href/variant, and wordmark. Each nav item carries `data-nav-variant` (`default` or `non-alco`) for dual active-fill colors on bar page. Outputs per-section data (image, caption, description) as inline JSON for JS hover interaction. Uses `c-arrow-right-outline.svg` (inline, `currentColor`) for nav arrows at 24×24px, mirrored via CSS `scaleX(-1)` for the door's left arrow. Prefetches all section images **Sep 2026, phones:** `.menu-hero__page-nav` opener (`btn-primary-green`, `icon_left_svg` `icons/c-kebab.svg` — currentColor twin of the author's `kebab.svg`), `.menu-hero__commit` full-width primary to `#<section>`, `.menu-hero__connector` (foodMenu / drinksMenu SVG); section JSON carries `label`; word lists come from `inc/menu-sections.php` Commit button label + glyph per section (`cta_label`, `icon_left_svg` `icons/c-<icon>.svg`); `sections_json` carries `ctaLabel` and the inlined `iconSvg` so the preview can swap them Arrow glyphs (word list + door) now go through `sweet_pepper_inline_svg()` per instance — the shared `file_get_contents` copy clipped to nothing on phones because its `clipPath` id resolved to the first copy, inside the hidden hero nav (fixed Sep 2026) **18 Sep 2026:** the phone / tablet connector word is `loading="eager"` (the entrance parks it under a clip). |
| `menu-jump-nav.php` | Sticky jump-nav (`website-brief.md` → Sticky jump-nav; Figma `btnFixed-left` 820:29398): edge tab (`button.php`, `primary-green`, `icon_right` fork-knife / martini, label "Food Menu" / "Drinks Menu"), scrim, and `#menu-jump-panel` (`role=dialog`). Rendered by `menu-hero.php` right after the hero `</section>` with the hero's own `$sections` / door args — one data source, no second copy Arrows inlined per instance via `sweet_pepper_inline_svg()` (Sep 2026; see menu-hero.php) |
| `menu-section-columns.php` | **18 Sep 2026; every section since 23 Sep.** A menu section's two columns from `sweet_pepper_menu_subsections()`: list or card (add-ons) subsections; a headerless list renders bare (Infusions); `divider` starts a new pair of columns under `menu-section__coffee-tea-divider` (Tea & Coffee); `note` prints `menu-section__remark` (Kids) |
| `dish-picker.php` | Reusable picker component: tags row (tag pills) + result area (photo pair with the Shake It! button in `.dish-picker__shake` on their seam + ticket card). Accepts `pairings` array and `default_index`. Outputs pairing data as inline JSON for JS. Card follows reserve-drawer ticket pattern (top edge absolute, card in flow, bottom edge in flow). Used on food menu (pairing-station.php) and bar menu (pairing-station-bar.php) with swapped data |

### Page Templates
| File | Purpose |
|---|---|
| `front-page.php` | Home page — all sections composed via `get_template_part()` **18 Sep 2026:** hero tile photos `loading="eager" decoding="async"`, the hero's foot word `loading => 'eager'`, and `data-count-up` on the About preview's "12 years" label — the motion pass's only template edits on this page. |
| `page-menu.php` | Menu page template — hero, then `if/else` on `$menu_state` (`?menu=drinks`): **food** → highlights strip + 9 food sections + pairing-station; **drinks** → highlights strip (same cards, Sep 2026) + 7 bar sections + pairing-station-bar. After `endif`: entrance image + location section (shared). Auto-created on `init` by `sweet_pepper_create_pages()` **Sep 2026:** the Breakfast headline goes through `menu-section-rail.php`; phone-only `.menu-hero-reflection` after the hero (foodMenu / drinksMenu `-reflection.svg`); highlight cards get `link_label_mobile` Phone-only `menu-sections-tail.php` after the last section of each state (the single "try the match maker" connector) Phone-only `menu-sections/visit-cta.php` after Location (Sep 2026) **Sep 2026:** the Seasonal Highlights strip moved to `menu-sections/highlights.php` and renders in **both** states (it was food-only; the bar page had no strip) — this shifts the bar sections' `nth-of-type` parity, so Infusions is now on `--bg` like Breakfast |
| `page-about.php` | About page — fixed composition, no daypart theming; dark/light sections alternate in the order set by `website-brief.md`. Composes `template-parts/about/`: hero, concept, how-it-feels, perks, story, guests, team, careers, location, entrance, visit-cta. **Phones (Sep 2026):** every one of the nine seams carries a connector via `about/connector.php` (head reflection as the section's first child, foot word as its last, outside `.container`); `how-it-feels` eyebrow is PEOPLE SPEAK (the connector above it says WORD OF MOUTH); `story.php` carries two `rugged-edge` blocks inside the ledger for the phone ticket edge. **Sep 2026 passes:** `perks.php` inlines the six `assets/icons/` SVGs via `sweet_pepper_inline_svg` (no Phosphor), carries a `label` (desktop) / `word` (phone) pair per perk, deals `--stamp-color-phone` per row `(i − ⌊i/3⌋) mod 3`, and writes the one-liners with spaced em dashes tied to the preceding word by a no-break space; `story.php` opens ¶2 with the naming sentences (copy doc order); `guests.php` labels shortened to "12th Bday!" / "9th Bday!" so every pill clears the 16px inset at 375; `team.php` carries placeholder lines for seven members (marked in the file and in about-page-copy.md) **18 Sep 2026:** `about/hero.php` card photos are `loading="eager"` for the hero entrance; no other template change for the About motion pass. |
| `page-visit.php` | Visit page — fixed dark · light · dark composition closing on the Lime footer. Three sections: hero (heroMessage + statesContainer band + heroSplit with hours card and contacts card), location (map + deal card), CTA (contact form + photo). Composes `template-parts/visit/`: hero, location, cta. State engine (`visit-hero.js`) drives bar/kitchen status in the band. No daypart theming. **Sep 2026:** section connectors at both seams via `components/connector.php`; the 21:9 photo band is phone-only and lives inside the CTA section |
| `footer.php` | Site footer on every page: rugged top edge, stamp, GO TO / HOURS / VISIT columns, bottom bar. **Sep 2026:** phone-only `.footer-mobile-top` row (Symbol + wordmark + "Top"), column hooks (`footer-col--nav/--hours/--visit`, `contact-item--address/--phone/--email`), VK leads Instagram in the social row at every width |

### Backend includes (`inc/`)
| File | Purpose |
|---|---|
| `vite-enqueue.php` | Enqueues built CSS/JS from the Vite manifest (`IS_VITE_DEVELOPMENT` flag switches to the HMR dev server). Adds `type="module"` to the main script |
| `bar-hours.php` | **20 Sep 2026.** Bar Settings → hours in minutes, with code defaults and a sanity fallback; rows for the printed hours. |
| `daypart-head.php` | **20 Sep 2026:** hands the hours to the scripts as `window.spBar`; bar's clock (Europe/Moscow), closed windows → `data-closed`, 00:00–02:00 → party, `?closed=` override. **18 Sep 2026.** `sweet_pepper_daypart_head()` on `wp_head` priority 0 — blocking inline JS that sets `<html data-now>` and the first-paint `data-theme`. **The only place the daypart hour thresholds are stated**; the hand-over point for ACF hours later. `is_front_page()` gates theming by the hour (home only, mirroring the engine) |
| `cpt.php` | Custom post types: **`dish`** «Блюда» and **`drink`** «Напитки» (23 Sep 2026 — the menu store; not public, Russian labels, revisions), **`menu_list`** «Разделы меню» (one record per menu section, admin-only creation, listed in menu order), `pairings`, `news`. `menu_section` (option А) removed 23 Sep 2026 |
| `dish-quick-edit.php` | **20 Sep 2026; both tables since 23 Sep.** Size and price in the «Блюда» / «Напитки» tables' Quick Edit: `quick_edit_custom_box` under «Выход и цена», values from `data-*` on a hidden span the column prints, `save_post_dish` / `save_post_drink` (nonce, `edit_post`, `update_field()` by key). |
| `menu-data-dishes.php` | **The menu store** (20 Sep 2026, decided 23 Sep): `sweet_pepper_menu_list_rows( $slug )` (a `menu_list` record's Relationship lists → rows), `sweet_pepper_menu_item_type()` (dish / drink per section), the picker's size-price-description labels and its per-section type, both tables' columns, A–Z order and «Раздел» filter |
| `menu-data.php` | **18 Sep 2026.** `sweet_pepper_menu_subsections( $slug )` — a section's subsections (title, column, style, divider, note) → dish-row args in one language, from its `menu_list` record, falling back to `data/menu/<slug>.php`. `sweet_pepper_menu_format_sizes()` builds the price and quantity strings (`260-. / 420-.`, `350 g / 0.5 L`; units twinned RU/EN in `sweet_pepper_menu_units()`). Validates two icons at most. (The repeater's `dish_id` filling went with option А, 23 Sep 2026) |
| `pairings.php` | **21 Sep 2026.** `sweet_pepper_food_pairings()` reads the one «Гастробот» record (named «Подбор пары» until 23 Sep) (typed fallback `data/pairings.php`), one language; `sweet_pepper_pairing_index()` — the row marked «Открывается первой». *(18 Sep 2026:* the six pairings typed here, **one list for the menu page's pairing station and About's Concept picker** (About carried its own three-dish copy with different wording and one different pairing; the two had drifted). `sweet_pepper_pairing_index( $pairings, $slug )` gives the default pick by slug — both pages open on `roast`. Phase 2: an ACF repeater / dish relationship. |
| `lang.php` | **21 Sep 2026.** Language on the URL: `sweet_pepper_lang()` (the one answer to "which language", from the request URI — `/` RU, `/en/` EN), rewrite twins flushed by version, the `locale` and `home_url` filters, hreflang, `sweet_pepper_lang_url()` and the pill `sweet_pepper_lang_switch()`. |
| `fields.php` | **21 Sep 2026.** Two languages in one record: `sweet_pepper_pick()` (RU / EN twin, the other stands in for an empty one), `sp_field()`, `sp_headline()` (both lines from one language), `sweet_pepper_typed()`. |
| `media-topics.php` | **23 Sep 2026.** «Темы» on images: `media_topic` taxonomy on attachments, default topics made on first admin load, checkboxes in an image's details, «Все темы» filter (grid, pickers, list view), list-view bulk actions. First labels: `tools/media-topics.php` |
| `about-data.php` | **21 Sep 2026.** The About page's fields → template-part args in one language, typed fallback in `data/about/`. Careers (`sweet_pepper_about_careers()`, departments) and Team (`sweet_pepper_about_team()`, chips, `sweet_pepper_years_since()`, the 6 / 8 parity validator). |
| `images.php` | **21 Sep 2026.** Team-replaceable photos: hard-cropped sizes `sp-square` (1:1) and `sp-3x2`; `sweet_pepper_photo_url()` — an image field's URL at a size, or the typed asset while empty. |
| `location.php` | **21 Sep 2026.** `sweet_pepper_location_headline()` — the one Location headline for About, Menu and Visit (Bar Settings; fallback `data/location.php`). |
| `acf-setup.php` | "Bar Settings" ACF options page; pins ACF Local JSON save/load to `acf-json/` so field groups are tracked in Git; hides theme-filled fields (`.sp-field-hidden`, the dish row id) from the form |
| `svg-dimensions.php` | `sweet_pepper_svg_dimensions( $rel_path )` → `['width','height']` from an SVG's viewBox (falls back to root width/height attributes; fractional boxes scaled ×100 to keep the ratio as integers). Reads only the first 2 KB of the file; memoised per request and in the object cache keyed on the file's mtime, so re-exported assets are picked up automatically. Returns `null` for a missing or unparsable file (the component then omits the attributes). Used by `section-link-word.php` |
| `inline-svg.php` | `sweet_pepper_inline_svg( $rel_path )` — inlines an SVG with every `id` (and its `url(#…)` / `href="#…"` references) suffixed per instance. Figma exports share `clipPath` ids across files; the first copy in the DOM wins, and a hidden or differently-sized first copy blanks the others (seen Sep 2026: the bar-preview CTA's `Pepper.svg` vanished on phones behind the drawer marker's `c-Pepper.svg`). Used by `button.php` and the drawer marker; other `file_get_contents` call sites still raw |
| `menu-sections.php` | **Sep 2026.** `sweet_pepper_menu_sections( $state )` — the nine food / seven bar section arrays (label, image, caption, description, nav_variant), moved out of `menu-hero.php` so the hero nav, the jump-nav panel and the phone rail read one list; `sweet_pepper_menu_state_for( $slug )` Each section also carries `cta_label` and `icon` (phone hero commit button), captions and descriptions synced to `menu-hero-copy.md` (Sep 2026) |

### ACF editability (experiment, started 2026-09-10)
- First field wired end-to-end: `about_hero_headline` (text, field group `acf-json/group_6aa221f88c4c6.json`, shown on Pages → About) → `template-parts/about/hero.php`.
- Pattern to reuse: read fields at the top of the template part into variables, guard with `function_exists( 'get_field' )`, fall back to the hardcoded copy, `esc_html()` on output. Keep markup free of `get_field()` calls.
- `functions.php` disables the block editor for pages (`use_block_editor_for_post_type`) and removes `editor` post-type support on `init`, so pages are ACF-only. Both are two lines and reversible.

### Food Menu Section Templates (`template-parts/menu-sections/`)
| File | Section | Deal | Addons | Link Word |
|---|---|---|---|---|
| `lunch.php` | Lunch (weekdays 12pm – 4pm) | Drinks deal! | — | THE BEST IN THE CITY |
| `bar-snacks.php` | Bar Snacks (share with friends) | perfect together + CTA link | Favorite Sauces (right col) | FINGER-LICKING FOOD |
| `salads.php` | Pepper's Salads (fresh & crisp) | — | — | FRESH AS IT GETS |
| `sandwiches.php` | Sandwiches & Bagels (house-made sesame bagels) | — | — | STACKED WITH LOVE |
| `soups.php` | Soups (warm & comforting) | — | — | SPOON THERAPY |
| `hot-dishes.php` | Hot Dishes (from the kitchen) | — | Favorite Sauces (left col) | COMFORT FOOD |
| `desserts.php` | Desserts (always room for something sweet) | — | — | SWEET LIKE PEPPER |
| `kids.php` | For Little Peppers (favorites they finish) | — | Kids Sauces (right col) | TRY THE MATCH MAKER (was FAVORITES THEY'LL FINISH — the last food section sits on the picker, Sep 2026) |
| `pairing-station.php` | Pairing Station — "Find Your Match!" (food → drink). Tags = food dishes, card = drink pairing. Pairings from `sweet_pepper_food_pairings()` (`inc/pairings.php`, shared with About's Concept since 18 Sep 2026); default pick by slug (`roast`), not by index | — | — | YOU'LL LIKE IT |
| `pairing-station-bar.php` | Pairing Station (bar) — tags = drinks, card = food pairing. Swapped data from food version. Always night mode | — | — | YOU'LL LIKE IT |
| `location.php` | Entrance image (door-entrance.jpg, 4:1, bottom-12px radius) + Location "Find the Pepper" section (copy left + geo-detected map right). Shared by both food/bar menus Title split into three spans (`line1` / `mid` / `line2`) so the break and colour boundary can move per breakpoint (Sep 2026) |
| `highlights.php` (menu-sections) | **Sep 2026.** Seasonal Menu Highlights for both menu states (`menu_state` arg): section header, six `menu-highlight-card`s, the "get it while it lasts" connector (`bar/` SVG in the drinks state). Same six kitchen cards in both states for now — the bar's own seasonal cards are the team's job, same data shape; on the drinks page the card links are full URLs to the food page's sections |
| `visit-cta.php` (menu-sections) | **Sep 2026, phones only** (Figma Visit CTA 2109:130264): "join the party" eyebrow, "Come sit with us" H1, the About visit copy, one `primary-green` "Reserve a table" button with `c-phone.svg` trailing, `js-reserve-trigger` → reserve sheet. `display: none` above 767px |

### Bar Menu Section Templates (`template-parts/menu-sections/bar/`)
| File | Section | Deal | Addons | Link Word |
|---|---|---|---|---|
| `infusions.php` | Infusions (14 items, flat two-col, no subsections) | 3+1 Deal! | — | THE HOUSE SECRET |
| `cocktails.php` | Cocktails (World Classics, Only at Pepper, Seasonal, Long/Mixed/Shots) | Spritz Time! | — | THE BEST IN THE CITY |
| `wine.php` | Wine (White, Red, Sparkling, Sherry & Fortified, Vermouths) | It's Wine O'Clock! | — | UNCORK THE MOMENT |
| `beer.php` | Beer (Bottled, On Tap) | — | — | COLD AND HONEST |
| `spirits.php` | Spirits (11 subsections: Scotch/American/Irish/World Whisky, Vodka, Gin, Rum, Cognac & Brandy, Tequila & Mezcal, Bitter & Herbal, Liqueurs) | — | — | WORLD AND LOCAL HITS |
| `no-buzz.php` | No Buzz (Virgin Cocktails, Milkshakes, Smoothies, Juices & Lemonades, Soft Drinks, Kids Drinks) | — | — | CLEAR HEADS WELCOME |
| `tea-coffee.php` | Tea & Coffee (Coffee top / Tea bottom, dashed olive divider) | Lunch Offer! | Vegan Milk (left col) | SURPRISINGLY GOOD |

**Sep 2026:** every section's `<h2>` is rendered by `menu-section-rail.php` (the phone rail — see Menu Sections → Mobile). Eyebrows reviewed against the Figma `Subtitle` variables: Lunch, Desserts, Kids and Infusions ("Home-made, since 2014", was "available to order") changed; the rest already matched. Header photos: Infusions → `bar/infusions/infusions-lenya-11-4-1.jpg` (a dedicated 4:1 crop — the 3:2 subject spans the frame, so a focal point alone could not keep rims and berries; hero uses the 3:2 `infusions-lenya-11.jpg`; a 21:9 crop is in the folder too), Cocktails → `bar/cocktails/manhattan-4-1.jpg` ("Manhattan", was shots-3 "Furious Shots"), No Buzz → `bar/cocktails-non-alco/smoothie-1.jpg` ("Berry smoothie" — the pill had read "Iconic Pumpkin Soup" over a milkshake). Both photos come from `photos/menu-website/bar/` (Manhattan also in 1:1, 3:2 and 21:9 crops).

---

## Motion — Gentle Is the Default (Sep 2026)

One easing vocabulary for the site, per `website-brief.md` → Motion language ("spring easing … transforms only"). Figma's **Gentle** spring (mass 1 / stiffness 100 / damping 15) is the default; everything else is an explicit exception.

| Where | Implementation |
|---|---|
| In-page scrolling (hero words, jump-nav picks, Directions, Back to top, any `#anchor`) | Real spring integrated in JS — `src/js/gentle-scroll.js`; overshoot capped at 24px on long rides |
| Things that move (drawer / panel / tab slides, footer stamp spin, card lifts, chapter transforms) | `transition: <prop> var(--dur-gentle) var(--ease-gentle)` — bezier fitted to the spring |
| Colour, opacity, shadow, border | `var(--ease-gentle-flat)` — same 800 ms, no overshoot (an overshooting bezier flickers past the end colour) |
| Figma says Bouncy (menu hero word fill, dish picker, Visit hero pops, About stamps) | `var(--ease-bouncy)` |
| Home hero daypart tiles, contacts panel | `var(--ease-out-expo)` |
| **Masked entrances** (hero tiles and headline on load, `mask-*` reveals) | `var(--ease-out-expo)` — a spring's overshoot would carry the content past its mask and open a gap |
| Unmasked entrances (copy `rise`, sheet fan, foot word, nudge) · pills | Gentle · `var(--ease-bouncy)` |

**What was wrong before (fixed Sep 2026):** two different curves were both labelled "Gentle" — Material's `0.4, 0, 0.2, 1` (buttons, events) and the overshooting `0.34, 1.56, 0.64, 1` (footer stamp), while the menu hero used that same overshooting curve under the name "Bouncy". Scrolls used native `scrollIntoView` / `scroll-behavior: smooth`, whose timing the browser owns. All literal beziers in `src/css` are now tokens (the four About-page `0.22, 1, 0.36, 1` heat-line/timeline curves and the header logo's `0.175, 0.885, 0.32, 1.275` are left as deliberate one-offs). The 47 short `ease` hover transitions (0.2–0.3 s) are untouched.

**Overshoot at a viewport edge:** the Reserve drawer and jump-nav panel overshoot their slide-in by ~3% (≈13px past the edge and back). A solid 32px off-screen `box-shadow` extension (on `.reserve-drawer`, and on `.menu-jump__panel` — not its sheet, which clips overflow) paints sheet colour past the edge so that moment shows sheet, not scrim; the panel ground is Parchment / Soft Peppercorn with a hard-stop Lime strip in its last 8px, so the sub-pixel seam at a fractional transform has no Lime to reveal. The jump tab's overshoot is 2px — left as is.

**Open:** `website-brief.md` → Motion language says spring easing for "prints, rolls and snap-backs"; the build now applies it site-wide. Widen the rule there (one line) so the doc matches the default. Also: the Bar Snacks deal links to `#bar-menu`, which doesn't exist on the page — it should point at the drinks menu (`/menu/?menu=drinks`) or a real anchor.

---

## Day/Night Mechanic

- Pure client-side. `data-theme="night"` on `<html>` flips CSS variables.
- **Day** (breakfast/lunch): `--bg: paper`, `--surface: parchment`, `--text: peppercorn`, `--accent-2: olive`
- **Night** (dinner/party): `--bg: peppercorn`, `--surface: soft-peppercorn`, `--text: parchment`, `--accent-2: lime`
- Switching is triggered by daypart-engine clicking a tile.
- **First paint (18 Sep 2026):** `inc/daypart-head.php` sets `data-theme` (and `data-now`) from inline JS in `<head>`, so a night page no longer paints in day clothes and flips; the engine finds the theme already right.
- **URL overrides** (Sep 2026): `?theme=night` forces night on any page; `?daypart=dinner|party|breakfast|lunch` selects a specific daypart; `?closed=night|morning|sunday` (20 Sep 2026) shows a closed window of the home hero at any hour. Priority chain: URL → tile click → clock. Implements the `website-brief.md` spec "The override travels on the link" (`/menu?daypart=dinner`).

### Section Background Alternation
| Section | Day | Night |
|---|---|---|
| Hero | `--surface` (parchment) | `--bg` (peppercorn) |
| Highlights | `--bg` (paper) | `--surface` (soft-peppercorn) |
| Bar Preview | `--surface` (parchment) | `--bg` (peppercorn) |
| Kitchen Preview | `--bg` (paper) | `--surface` (soft-peppercorn) |
| About Preview | `--surface` (parchment) | `--bg` (peppercorn) |
| Events | `--bg` (paper) | `--surface` (soft-peppercorn) |
| Contacts | `--surface` (parchment) | `--bg` (peppercorn) |

### Daypart Time Ranges
*Source of truth: the inline script in `inc/daypart-head.php` (the bar's clock, `Europe/Moscow` — 20 Sep 2026; was the visitor's). The engine reads `data-now` and `data-closed`.*

| Daypart | Hours | Mode |
|---|---|---|
| Party | 00:00 – 01:59 | Night |
| Closed · night (parked on party) | 02:00 – 03:59 | Night |
| Closed · morning (parked on breakfast) | 04:00 – 08:29 · Sundays – 09:59 | Day |
| Breakfast | 08:30 (Sun 10:00) – 11:59 | Day |
| Lunch | 12:00 – 16:59 | Day |
| Dinner | 17:00 – 20:59 | Night |
| Party | 21:00 – 23:59 | Night |

---

## Design Tokens (`variables.css`)

### Color Literals
| Token | Hex | Usage |
|---|---|---|
| `--chili` | #E34314 | Headlines, accent, buttons |
| `--chili-deep` | #9B2705 | Deep chili variant |
| `--paprika` | #EF6D44 | Section headline line 2 |
| `--lemon` | #FFED00 | Badges, night tile accent |
| `--cream` | #FFF689 | Night eyebrow text |
| `--olive` | #737D3A | Day card titles, dish names, tag labels |
| `--avocado` | #869438 | Dish row prices (both modes), day eyebrow |
| `--lime` | #C1DB34 | Night card titles, night accents, night card strokes |
| `--peppercorn` | #151317 | Dark backgrounds, day body text |
| `--soft-peppercorn` | #201E22 | Night surface background |
| `--paper` | #FCF7E8 | Light backgrounds |
| `--parchment` | #F3E9D2 | Day surface, night description text |
| `--ash` | #54513F | Day muted text, night borders |
| `--mushroom` | #9E9789 | Day borders, night muted text |
| `--dark-olive` | #242614 | Day description text |
| `--lime-light` | #D4E671 | Footer bottom row (phones), drawer current-item description — added Sep 2026 |

### Type Scale
| Token | Size |
|---|---|
| `--text-h1` | 64px |
| `--text-h2` | 24px |
| `--text-h3` | 18px |
| `--text-body` | 16px |
| `--text-caption` | 13px |

---

## Hero Section Architecture

### HTML Structure (`front-page.php`)
```
section.home-hero                          ← min-height: calc(100vh - 78px), flex column
  └── div.container.hero-container         ← flex: 1, flex column, position: relative
        ├── div.hero-content               ← flex: 1, justify-content: center
        │     ├── span.hero-eyebrow
        │     ├── h1#hero-headline
        │     ├── p#hero-subhead
        │     ├── div.daypart-grid         ← flex row, gap: 24px
        │     │     └── button.daypart-tile (×4)
        │     └── div.hero-ctas
        └── div.hero-footer               ← position: relative
              ├── div.lang-nudge-wrapper   ← in flow, right-aligned, overflow: hidden (since 17 Sep 2026)
              │     └── div.lang-nudge
              └── div.section-link-word    ← in flow, full container width
```

### Daypart Image Grid — Key CSS Details

**Tile states:**
- `.daypart-tile` (inactive): 224×224px square (20 Sep 2026: also limited by the screen's height — `max(168px, 100vh − 612px)` — so short screens keep 32px of air; 188 at 1280 × 800), 4px radius, dark overlay (33%) — raised from 156 in Sep 2026 after the hero spacing/subhead pass freed room; 224 (not 240) so the row fits the content column, and so the active tile is also the tallest
- `.daypart-tile.is-active`: 368px wide (= 360px image + 8px padding), padding-right: 8px, padding-bottom: 8px, `overflow: visible`, renders 368×248
- `.daypart-tile.is-now-daypart`: shows the Now badge (dot when inactive, pill when active)

**Active tile colour stack — per-daypart recipes (Sep 2026).** Ported from the menu-page mobile card `imgContainer-menu` (Figma 1341:49804): the three sheet *slots* keep fixed geometry, and each daypart decides a **direction** and which colour sits in which slot. `--dir: 1` tilts the photo −1° and fans the sheets below-left; `--dir: -1` mirrors the whole stack (photo +1°). **The mirror is taken about the photo, not the container** — the container's 8px padding sits right/bottom only, so a sheet at x peeks −x on the left and x+8 on the right and its mirror sits at −(x+8) (`--sx` in `hero.css`); mirroring about the container instead pushed the near sheet 14px out on one side and hid it on the other (seen in the browser, Sep 2026). Angles flip sign, y stays. Tilt alternates along the row so neighbours lean apart. Slot classes in markup: `.tile-bg--near / --mid / --far`; per-slot `--x / --y / --a`, colours via `--sheet-near / --sheet-mid / --sheet-far`, direction via `--dir` (derives `--tilt`), all set on `.daypart-tile[data-daypart=…]`. **Sheet size (Sep 2026):** `width: 100%; aspect-ratio: 3/2` of the stack (the tile's padding box) instead of `--active-w × --sheet-h` — identical at rest (368 × 245.3 on desktop), but on mobile the sheets now follow the tile's width while it transitions instead of sitting at final size from the first frame.

| Slot | Z | x (dir 1 / dir −1) | y | rotate (× dir) |
|---|---|---|---|---|
| near | 3 | -6px / -2px | -4px | -1deg |
| mid | 2 | -4px / -4px | -2px | -1.5deg |
| far | 1 | -2px / -6px | 0 | -2deg |

| Daypart | dir / photo tilt | near · mid · far | Figma twin |
|---|---|---|---|
| Breakfast | 1 / −1° | Lime · Lemon · Chili | variant=breakfast (also snacks, sandwiches) |
| Lunch | −1 / +1° | Lemon · Lime · Chili | variant=lunch (tilt added; Figma's 0° was a miss) |
| Dinner | 1 / −1° | Lime · Chili · Lemon | variant=salads (colour order; tilt alternated) |
| Party | −1 / +1° | Chili · Lime · Lemon | none — Chili nearest = the hot end (agreed Sep 2026) |

All sheets: `--active-w` × `--active-w / 1.5` (368 × 245.33), border-radius: 2px.

**Geometry is derived from one custom property**, `--tile`: `--img-h = --tile + 16`, `--img-w = --img-h × 1.5`, `--active-w = --img-w + 8`. Changing `--tile` rescales the whole stack. Full size: 3×224 + 368 + 3×24 gap = 1112px inside the 1120px content column (1280 − 2×80); 240 squares were tried first and overshot the right grid edge by 40px.

**Responsive (Sep 2026, ≥ 700px):** `.daypart-grid` is an inline-size container and `--tile: min(224px, calc((100cqw - 104px) / 4.5))` — the row is 4.5 tiles + 104px of fixed chrome (16px height step ×1.5, 8px padding, 3×24 gap), solved for the column width and capped at 224. No intermediate breakpoints; the row's right edge lands on the column edge at every width (measured 1440 → 700). Sheet offsets stay in px. Below 700px the mobile grid takes over (built in Figma, not yet in code). Measured tiles: 1280 → 222, 1100 → 182, 992 → 158, 991 → 183, 800 → 141, 700 → 118.

**Known, not the hero's:** (1) `.container` padding steps 80 → 24 at 992px (`main.css`), so tiles *grow* 158 → 183 as the viewport narrows past it — a `clamp()` on the container padding would remove the step. (2) The fixed Reserve edge tab overlaps the party tile below ~1000px, because the column's 24px gutter is narrower than the tab.

**Image wrapper** (active): `--img-w × --img-h` (360×240, 3:2), `rotate(var(--tilt))`, `border: 2px solid var(--peppercorn)`, z-index: 4. The Now pill also rotates by `--tilt` (it rides on the photo, as in Figma; previously counter-rotated +1°).

### Daypart ↔ Image Mapping
| Daypart | Image path |
|---|---|
| Breakfast | `food/breakfast/pepper-breakfast-2.jpg` |
| Lunch | `food/lunch/pumpkin.png` |
| Dinner | `food/dinner/zharkoe-1.jpg` |
| Party | `bar/cocktails/moscow-mull-2.jpg` |

### Language Nudge — Slide-In / Slide-Out
0. On load it slides in from the right, masked by the wrapper, last of the hero entrance (`hero-nudge-in`, `--in-nudge: 2000ms`, Gentle) — the dismissal reversed. Desktop only.
1. User clicks ×
2. `.is-dismissed` class added → `transform: translateX(110%); opacity: 0` (masked by wrapper's `overflow: hidden`)
3. On `transitionend`, JS collapses wrapper height to 0 with a `0.3s` transition

---

## Menu Hero Architecture (`page-menu.php`)

The menu hero serves both food and drinks states from a single template (`menu-hero.php`). State is set by `?menu=drinks` query param; default is `food`. The bar (drinks) state is **always dark** (`website-brief.md`). **Section data lives in `inc/menu-sections.php`** (`sweet_pepper_menu_sections( $state )`, Sep 2026) and is shared with the jump-nav panel and the phone rail; per section: `label`, `cta_label`, `icon`, `image`, `caption`, `description`, `nav_variant`, all synced to `menu-hero-copy.md`.

### HTML Structure
```
section.menu-hero                              ← min-height: calc(100vh - 78px), position: relative
  ├── script.menu-hero__data                   ← inline JSON: per-section label/ctaLabel/iconSvg/image/caption/description
  ├── link[rel="prefetch"] × N                 ← preload off-screen section images
  ├── div.menu-hero__page-nav                  ← PHONES ONLY: flush-left btn-primary-green "More plates" / "More pours", c-kebab glyph, .js-menu-jump-open
  ├── div.menu-hero__inner                     ← flex row, gap 48px, align-items: center, max-width: 1280px
  │     ├── div.menu-hero__nav                 ← nav panel (Paper/Soft-Peppercorn bg + Lime offset)
  │     │     ├── div.menu-hero__nav-bg--lime   (behind, offset 8px right/bottom)
  │     │     ├── div.menu-hero__nav-bg--parchment (behind, fills panel)
  │     │     ├── nav.menu-hero__nav-list      ← word list (9 food or 7 bar section links)
  │     │     │     └── a.menu-hero__nav-item (×N)
  │     │     │           ├── data-nav-variant="default|non-alco"
  │     │     │           ├── span.menu-hero__nav-label.molot-text
  │     │     │           └── span.menu-hero__nav-arrow (inline SVG, 24px)
  │     │     └── a.menu-hero__door            ← cross-menu door (ticket-day/night/kitchen)
  │     │           ├── data-door-target="drinks|food"
  │     │           ├── span.menu-hero__door-hinge (half-circle, left)
  │     │           ├── span.menu-hero__door-icon (SVG, mirrored scaleX(-1))
  │     │           └── span.menu-hero__door-label.molot-text
  │     └── div.menu-hero__content             ← flex column, gap 24px
  │           ├── div.menu-hero__photo         ← photo stack (sheets + frame + pill)
  │           ├── p.menu-hero__description     ← section description text
  │           └── div.menu-hero__commit        ← PHONES ONLY: full-width btn-primary to #<section>, label = cta_label, glyph = c-<icon>.svg
  ├── div.menu-hero__wordmark                  ← position: absolute, bottom: 0, max-width: 1280px (hidden on phones)
  │     └── span.molot-text                    ← "FOOD" / "DRINKS", 122px
  └── div.container.menu-hero__connector       ← PHONES ONLY: foodMenu / drinksMenu SVG connector (its reflection follows in page-menu.php → .menu-hero-reflection)
```

On phones (≤ 767px) the hero is one viewport (`calc(100dvh − 76px)`), one column, nav panel hidden, opener + content centred in the slack, connector on the floor — `website-brief.md` → Mobile — Menu page.

### Nav Item States (Night — food + bar)
| State | `non-alco` variant | `default` variant (bar only) |
|---|---|---|
| **Default** | `transparent` + `--lime` 1.5px stroke | same |
| **Hover** | `--paprika` filled | `--paprika` filled |
| **Active** | `--lime` filled + `--lime` arrow | `--chili` filled + `--chili` arrow |

### Door Variants
| Variant | Used in | Label | Default bg | Default text | Hover bg | Hover text |
|---|---|---|---|---|---|---|
| **ticket-day** | Food day | "Drinks" | `--peppercorn` | `--lime` outlined | `--peppercorn` | `--lime` filled |
| **ticket-night** | Food night | "Drinks" | `--lime` | `--peppercorn` outlined | `--lime` | `--peppercorn` filled |
| **ticket-kitchen** | Bar (always night) | "Food" | `--cream` | `--olive` filled | `--lemon` | `--avocado` filled |

### Hover Interaction (JS: `menu-hero.js`)
1. **mouseenter** on nav item → `setActiveNav(slug)` transfers `.is-active` class, `showSection(slug)` cross-fades photo
2. **Photo cross-fade**: add `.is-fading` → opacity drops to 0.3 (500ms CSS), swap `src`/alt/pill/description at 250ms midpoint, remove `.is-fading`
3. **mouseleave** → 200ms debounce, then revert to `data-default-section`. Moving between items cancels the debounce
4. **click** → `gentleScrollTo(#section-slug)` — the house Gentle spring (`gentle-scroll.js`), overshoot capped at 24px on long rides; replaced native `scrollIntoView` Sep 2026
5. **Door hover** → `setActiveNav(null)` (deactivates all), `showSection(doorTarget)` (reads `data-door-target`). Mouseleave reverts
6. **Phones (Sep 2026)** — the hero listens for `menu-hero:preview` (`detail.slug`), dispatched by the jump-nav panel: `setActiveNav` + `showSection` + `updateCommit` (label, `href`, glyph). No revert timer — a tap is a choice. The hero keeps `data-current-section` up to date; `menu-hero.css` keys the phone sheet recipe on it.

### Section Data — Bar (`inc/menu-sections.php`, copy from `menu-hero-copy.md`, synced Sep 2026)
| Section | nav_variant | Image | Caption | CTA (phones) | Glyph |
|---|---|---|---|---|---|
| infusions | default | `bar/infusions/infusions-lenya-11.jpg` (was infusions-18, Sep 2026) | Berry festival | Homemade Infusions | cocktail |
| cocktails | default | `bar/cocktails/manhattan-3-2.jpg` | Manhattan | Cocktails | cocktail |
| wine | default | `bar/wine/red-2.jpg` | Tonight's red | Wine | wine |
| beer | default | `bar/beer/beer-05.jpg` | Ring for a beer | Beer | beer |
| spirits | default | `bar/hard-drinks/jim-beam-1.jpg` | The bourbon shelf | Spirits | cocktail |
| no-buzz | non-alco | `bar/cocktails-non-alco/smoothie-1.jpg` | Berry smoothie | No Buzz | glass |
| tea-coffee | non-alco | `bar/coffee/cappuccino-icecream-1.jpg` | Iconic Pepper's Cappuccino | Tea & Coffee | coffee |

Food CTAs / glyphs: Breakfast · coffee, Lunch · food, Bar Snacks · cocktail, Salads · food, Sandwiches & Bagels · burger, Soups · soup, Hot Dishes · wine, Desserts · coffee, For Kids · food. Food captions now: Pepper's breakfast, Bagel lunch set, Meat set 2026, The iconic Cobb, Pepper's chicken club (`sweet-130.jpg` — it always was the club), Iconic Pumpkin soup, Yaroslavl-style roast, Raspberry Mille-feuille, Home-made nuggets.

### Layout Key Dimensions
- Hero: `min-height: calc(100vh - 78px)`, `position: relative`, `overflow: hidden`
- Inner: `max-width: 1280px`, `padding-right: 80px`, `align-items: center`
- Nav panel: `padding: 44px 36px 44px 80px`, `gap: 48px` (list → door)
- Content: `gap: 24px` (photo → description)
- Wordmark: `position: absolute; bottom: 0`, own `max-width: 1280px; padding-right: 80px`, clipped to 96px height
- Header bg override: day = `--paper`, night/drinks = `--peppercorn`
- Phones: hero `min-height: calc(100dvh − 76px)`, `padding-top: 24px`, `gap: 24px`; content `padding: 0 16px 8px`; photo pocket `0 8px 8px 0`; description Parchment in the drinks state (Mushroom by night on desktop — author testing)

---

## Menu Jump-Nav — Edge Tab + Panel (Sep 2026)

`website-brief.md` → Menu page → Sticky jump-nav, built. Figma: `btnFixed-left` (820:29398) for the tab; the panel is the hero nav panel coming back, so it is built from the hero's own classes rather than a second component.

### HTML Structure (rendered by `menu-hero.php` after the hero section)
```
div.menu-jump__tab-wrap.js-menu-jump-open   ← fixed, left: 0, top: 50%, 0×0 anchor; .is-visible slides it in
  └── button.btn.btn-primary-green.menu-jump__tab   ← "Food Menu" / "Drinks Menu" + ph-fork-knife / ph-martini
div.menu-jump__scrim.js-menu-jump-close     ← Peppercorn 50%
div.menu-jump__panel#menu-jump-panel        ← fixed, 448px (440 sheet + 8 Lime edge), role=dialog, .is-open
  └── div.menu-hero__nav.menu-jump__sheet   ← hero nav classes reused verbatim
        ├── div.menu-hero__nav-bg--lime     (display: none here — the panel ground is the Lime edge)
        ├── div.menu-hero__nav-bg--parchment
        ├── button.menu-jump__close         ← absolute top/right 24px, ph-x
        └── div.menu-jump__scroll           ← overflow-y: auto; list + door, auto-margin centred
              ├── nav.menu-hero__nav-list → a.menu-hero__nav-item × N
              └── a.menu-hero__door
```

### Behaviour
- **Trigger:** the tab is hidden while the hero's nav panel is in or below the viewport and slides in once the panel has scrolled *above* it (the brief's reason: while the hero side-nav is visible the tab would duplicate it). Scrolling back up slides it out and closes an open panel. The "second section scrolls into view" moment is earlier than this and would overlap the hero nav.
- **Dismiss:** ×, scrim, Esc, or picking a word (closes, then smooth-scrolls to the anchor). Focus trapped while open; returns to the tab on close.
- **Active word** tracks the section in view; hover uses the hero's Paprika fill.
- **Reduced motion:** tab, scrim and panel transitions off; scroll is instant.

### Tab construction (subclass on the shared `.btn`, like the Reserve tab)
- `transform: rotate(-90deg) translateY(50%)` — local top edge lands on the viewport edge; text reads bottom-to-top, icon on top.
- `border-radius: 0 0 8px 8px` — edge-side corners squared, visible corners 8px (Figma container). The Reserve tab still has the button's default 4px on its visible side — a 4px twin mismatch, not yet settled against the Figma `btnFixed` node.
- **Shadow:** the house card shadow `1px 1px 4px rgba(21,19,23,.15)` expressed in the rotated frame as `-1px 1px 4px` (screen +x = local +y, screen +y = local −x). Applied to the Reserve tab too (`reserve-drawer.css`), replacing its `0 -4px 10px` black — the only non-house shadow in the theme. Disappears on Peppercorn at night, per `design.md` §2.6.
- 44px thick vs 42 in Figma: the shared `.btn` keeps a 1px transparent border for outline states; the Reserve tab carries the same 2px.

### Phones (≤ 767px, Sep 2026 — Figma `kitchen-drawer-day` 1341:49297)
No edge tab (`display: none`); the panel opens from the hero's `.menu-hero__open` button only. Full-width sheet, Lime edge on the **left** (8px), top-left radius 4, padding 48 / 72 / 48 / 48, list + door centred, × at 8 / 9 in a 40px box. **A word previews the hero instead of jumping**: `close()` → `setActive(slug)` → `hero.dispatchEvent(menu-hero:preview)`; no scroll, no hash. `open()` syncs the active word to `hero.dataset.currentSection`. The active word has no arrow (`.menu-hero__nav-arrow` hidden) and the door stays a real link to the other menu. Arrows are inlined per instance (`sweet_pepper_inline_svg()`) — the shared copy clipped to nothing once the hero nav was hidden.

### Verified (headless Chrome, both menus × both themes)
Tab hidden at top / shown after the hero; open, ×, scrim, Esc; focus trap and return; pick → scroll with the active word updating; drinks state label/icon/door; 560px-tall viewport scrolls the list with the × fixed. **Phones (402×874):** opener → panel; Lunch / Sandwiches / No Buzz / Beer taps swap photo, pill, description, button label + glyph + `href` with `scrollY` 0 and no hash; door `href` is the other menu; door arrow 24×24 with unique clip ids. Note: the in-app Browser pane reports `document.hidden`, so smooth scroll and IntersectionObserver don't advance there — use headless Chrome (see the `local-dev-verification` memory).

---

## Highlights Section

### HTML Structure
```
section#menu-highlights.home-highlights     ← bg: paper/soft-peppercorn
  └── div.container                         ← flex column, gap 80px
        ├── .section-link-word--reflection   (AT SWEET PEPPER, 50%/30% opacity; below 992px: 1 by day, and 1 by night on phones)
        ├── .section-header                  (eyebrow + headline×2 + description | CTAs)
        ├── .highlights-grid                 (flex row, gap 24px, 3× cards)
        │     └── .highlight-card (×3)       (rounded-12, shadow, 3:2 image, text+tag)
        └── .section-link-word               (MORE FROM MENU)
```

### Highlight Card States
| State | Day | Night |
|---|---|---|
| Default | shadow `1px 1px 4px`, paper bg | + `1px solid transparent` border |
| Hover | shadow `4px 4px 16px` | + `0.5px solid lime` border |
| Pressed | inset shadow `2px -2px 8px`, paper bg | + `1px solid lime` border |

### Mobile (Sep 2026, Figma `HighlightsSection` 2048:126987)
- 48px rhythm; `.section-header` is `display: contents` so `.section-ctas` can take `order: 1` under the cards and the bottom connector `order: 2`.
- `.highlights-grid` → snap rail: cards stay 320 wide (`flex: 0 0 min(320px, 100%)`), `scroll-snap-align: start`, rail margin `−4px −16px −8px` / padding `4px 16px 8px` (bleeds across the gutters, keeps the shadow unclipped), scrollbar hidden. Verified: snaps in 344px steps, page never scrolls sideways.
- Eyebrow stays H3 18 (author, Sep 2026 — the frame's Molot 16 `Heading/Captions` is not sanctioned); colours as desktop.

---

## Bar & Kitchen Preview Sections

### HTML Structure (both sections share `menu-preview.php`)
```
section.home-bar-preview / .home-kitchen-preview
  └── div.container                         ← flex column, gap 80px
        ├── .section-link-word--reflection
        ├── .menu-preview-content            ← flex row, gap 36px
        │     ├── .menu-preview-text         (title + dish rows + CTA)
        │     │     ├── h2.menu-preview-title
        │     │     ├── .dishes-container    (stacked .dish-row components)
        │     │     └── .menu-preview-cta
        │     └── .menu-preview-image        (3:2 image + optional badge)
        └── .section-link-word
```

- **Bar**: text-left, image-right. Title: "HOME MADE INFUSIONS".
- **Kitchen**: image-left, text-right (CSS `order: -1`). Title: "FAMOUS LUNCH MENU!".
- Dish data is currently hardcoded in `front-page.php` arrays.

### Mobile (Sep 2026, Figma `AboutSection` 2048:127019 — misnamed, it is the bar preview)
- Column at 36px: photo first (`.menu-preview-image { order: -1 }` for both layouts), title + rows, 48px, CTA full width. 48px section rhythm. Kitchen has no frame; it stacks the same way.
- Caption label is the `img` component `pill` everywhere now: no tilt, radius 4, 90%, Golos 400, inset 24 desktop / 16 phones.
- Bar CTA pepper icon was invisible on phones — duplicate `clipPath` id with the drawer marker; fixed by `inc/inline-svg.php`.

---

## Menu Sections (Food Menu Page)

Each food menu section follows the same layout pattern. Sections alternate `--bg` / `--surface` backgrounds via `.menu-section:nth-of-type(even)`, and each section exposes its ground as `--section-bg` (Sep 2026). **Order-dependent — known:** the alternation is positional, so any `<section>` inserted among the menu sections (a seasonal rail, a bar's-note band) flips every section below it. `nth-of-type` (not `nth-child`) is used so non-section siblings in `<main>` — the jump-nav tab, scrim and panel — don't shift it; see Known Issues.

### HTML Structure (shared by all 9 sections)
```
section#[slug].menu-section                  ← bg: bg/surface (alternating)
  └── div.container.menu-section__content    ← flex column, gap 48px
        ├── .menu-section__hero              (4:1 aspect, bottom-12px radius, overflow clip, --img-pos focal point)
        │     ├── img                        (object-fit: cover)
        │     └── span.menu-section__hero-pill  (lemon bg, 0.9 opacity, bottom-left)
        ├── .menu-section__title-row         ← flex row, gap 24px
        │     ├── .menu-section__title-text  (66% width, eyebrow + headline — the headline is menu-section-rail.php)
        │     └── .menu-section__title-right (flex-1, deal slot or empty)
        ├── .menu-section__columns           ← flex row, gap 48px
        │     ├── .menu-section__column--left  (gap 36px between subsections)
        │     │     └── .menu-section__subsection (×N)
        │     │           ├── .menu-section__subsection-header (Molot H2)
        │     │           └── .menu-section__dishes (stacked dish-row components)
        │     └── .menu-section__column--right (gap 16px between subsections)
        │           └── (same subsection structure)
        └── div.container                    (bottom link word with border-bottom)
              └── section-link-word.php
```

### Mobile (Sep 2026, Figma `menu-food-mobile-day` 2109:130225 — all 16 sections)
- `.menu-section__content` gap 0; `.menu-section__title-row`, `__title-text`, `.section-title` and `__title-right` are `display: contents`, and the pieces are ordered: hero photo (1) → rail (2) → eyebrow (3) → deal (4) → columns (5). Section gap 36 to the connector.
- **Top block on the other ground** (`--section-top-bg` = `--surface`, even sections `--bg` — i.e. the previous section's colour): the photo full-bleed at 7:3 with radius 4 and caption inset 16, the rail, and the eyebrow closing with 8px bottom radii. Each piece paints its own slice (`margin: 0 −16px` + background).
- **Rail** (`menu-section-rail.php`): `<nav>` of all the words in canonical order, the current one an `<h2 class="section-headline">` in place, the others same-page anchors; scrolled so the current word sits at the gutter (`alignRail()`); sticky under the header on phones. 36px Molot, links outlined Olive (Lime by night), 24px gaps, `scroll-snap-type: x mandatory`, `scroll-padding-inline: 16px`, scrollbar hidden, trailing 16px gutter. Desktop hides the `<nav>`. Links ride `gentle-scroll.js`'s site-wide binder; landings clear the fixed header via `section[id] { scroll-margin-top: 76px }` (main.css) which `gentleScrollTo()` now reads.
- Deal full width (card `flex: 1`, shadow `calc(100% − 2px)`), columns stacked at 24px, add-ons card 100%. Component anatomy (deal, add-ons, dish rows) otherwise unchanged — next pass.

### Deal Component (Lunch, Bar Snacks)
```
.menu-section__deal                          ← w-352, rounded-4, relative, isolation
  └── .menu-section__deal-inner              ← flex row
        ├── .menu-section__deal-card         ← cream bg, w-348, z-2
        │     ├── rugged-edge.php (color=section-bg)  ← top scalloped edge, matches the section ground
        │     ├── .menu-section__deal-title   (Molot H3, chili-deep)
        │     ├── .menu-section__deal-divider (2px olive bar)
        │     └── .menu-section__deal-desc   (main text + optional link)
        └── .menu-section__deal-shadow       ← chili-deep, z-1, bottom-right peek
```

### Addons Component (Bar Snacks, Hot Dishes, Kids)
```
.menu-section__addons                        ← rotate(1deg)
  └── .menu-section__addons-card             ← cream bg, w-536
        ├── gradient top border              (olive, 2px, 8px dash / 8px gap via repeating-linear-gradient)
        ├── .menu-section__subsection-header  (Molot H2, chili-deep)
        ├── dish-row.php (no border)          (price color: avocado)
        └── rugged-edge.php (color=section-bg) ← bottom, scaleY(-1), matches the section ground
```

### Night Mode Overrides (menu-section.css)
| Element | Day | Night |
|---|---|---|
| Section bg | `--bg` (paper) | `--bg` (peppercorn) |
| Section bg (even) | `--surface` (parchment) | `--surface` (soft-peppercorn) |
| Eyebrow | `--avocado` | `--cream` |
| Subsection titles | `--chili-deep` | `--paprika` |
| Deal/addons card bg | `--cream` | `--cream` (same) |
| Addons card text | Inherited (dark) | Pinned to dark (peppercorn/ash/chili-deep) |
| Remark text | `--ash` | `--mushroom` |

### Section Order & Data
| # | Section ID | Eyebrow | Hero Photo | Deal | Addons |
|---|---|---|---|---|---|
| 1 | breakfast | whenever your morning starts | breakfast/pepper-breakfast-2.jpg | Morning Bubbles! | Pick Your Topping |
| 2 | lunch | weekdays 12:00–16:00 | lunch/bagel-lunch-1.jpg | Drinks deal! | — |
| 3 | bar-snacks | share with friends | dinner/wings-2.jpg | perfect together | Favorite Sauces (R) |
| 4 | salads | fresh & crisp | lunch/cobb-1.jpg | — | — |
| 5 | sandwiches | house-made sesame bagels | lunch/sweet-130.jpg | — | — |
| 6 | soups | warm & comforting | lunch/pumpkin.png | — | — |
| 7 | hot-dishes | from the kitchen | dinner/zharkoe-1.jpg | — | Favorite Sauces (L) |
| 8 | desserts | sweet ending | dessert/napoleon-1.jpg | — | — |
| 9 | kids | kids menu | kids/kids-nuggets-2.jpg | — | Kids Sauces (R) |

### Bar Section Order & Data (always night mode)
| # | Section ID | Eyebrow | Hero Photo | Deal | Addons |
|---|---|---|---|---|---|
| 1 | infusions | available to order | bar/infusions/infusions-18.jpg | 3+1 Deal! | — |
| 2 | cocktails | shake & stir | bar/cocktails/shots-3.jpg | Spritz Time! | — |
| 3 | wine | by the glass or bottle | bar/wine/red-2.jpg | It's Wine O'Clock! | — |
| 4 | beer | cold & crisp | bar/beer/beer-05.jpg | — | — |
| 5 | spirits | neat or on the rocks | bar/hard-drinks/jim-beam-1.jpg | — | — |
| 6 | no-buzz | zero proof, full flavour | bar/cocktails-non-alco/veggie-milkshakes-3.jpg | — | — |
| 7 | tea-coffee | brewed with love | bar/coffee/cappuccino-icecream-1.jpg | Lunch Offer! | Vegan Milk (L) |

**Tea & Coffee special structure:** Two sets of columns separated by a full-width dashed olive divider (`.menu-section__coffee-tea-divider`, 2px, `repeating-linear-gradient`, same 8/8 pattern as addons top border). Top = coffee subsections + addons, bottom = tea subsections.

**Bar link word SVGs:** Single set in `assets/sectionLinks/menu/bar/` (no day/night variants — bar is always dark). Same path passed for both `day_img` and `night_img`.

---

## About Preview Section

### HTML Structure
```
section#about-preview.home-about-preview     ← bg: surface/bg
  └── div.container                          ← flex column, gap 80px
        ├── .section-link-word--reflection   (THAT'S ICONIC, shared seam with Kitchen)
        ├── .about-preview-content           ← flex row, gap 36px
        │     ├── .about-preview-text        (eyebrow + headline×2 + description + stats + CTA)
        │     │     ├── span.section-eyebrow ("THE PEPPER STORY")
        │     │     ├── .section-headline-group
        │     │     ├── p.section-description
        │     │     ├── .about-preview-stats  (stat-chip × 2; the "12 years" label carries data-count-up)
        │     │     └── .about-preview-cta    (btn-secondary)
        │     └── .about-preview-image       (3:2, shots-2.jpg)
        └── .section-link-word               (SEE WHAT'S NEW)
```

### Mobile (Sep 2026, Figma `AboutSection` 2048:127039)
- `.about-preview-text` → `display: contents`; order: eyebrow + headlines (headline group `margin-top: −28px` = 8px under the 36px gap) → photo → description → stats (12px icons) → CTA full width. Stat labels Golos 400 at every width.

---

## Events / News Section

### HTML Structure
```
section#events.home-events                   ← bg: bg/surface
  └── div.container                          ← flex column, gap 80px
        ├── .section-link-word--reflection   (SEE WHAT'S NEW, shared seam with About)
        ├── .section-header                  (eyebrow + headline×2 + description | social CTAs)
        ├── .events-grid                     (CSS grid 3×2, gap 24px)
        │     ├── .event-card (×5)           (full-bleed image, badge, scrim, date, title)
        │     └── .events-link-card          ("See all events →")
        └── .section-link-word               (JOIN THE PARTY)
```

### Event Card States & Anatomy
- Bordered card container: mushroom border (day + night default), rounded-8, card bg (parchment day / peppercorn night)
- Image: 4:5 aspect ratio, `margin-bottom: -98px` (pulls body overlay up over image bottom; pinned uses -106px)
- Category pill: on the image (event=Chili/Paper, promo=Lemon/Peppercorn, community=Lime/Peppercorn)
- Body overlay: gradient div (paper→transparent day, peppercorn→transparent night)
- Date: Golos Medium 14px (day) / Golos 13px lime (night)
- Title: Molot H3 18px, olive (day) / paper (night)
- **3 states:**
  - **Default** — mushroom border, no shadow
  - **Hover** — shadow (4px 4px 16px day / 0 0 16px lime glow night), date hides, CTA "See it on Instagram →" reveals
  - **Pinned** — lemon border + lemon glow `0 0 8px`, night gets 2px lemon border
- Card data is hardcoded — Phase 2 replaces with News CPT, Phase 3 adds VK importer

### Mobile (Sep 2026, Figma `eventsSection-mobile` 2048:127051, card `instagram-feed-cards-mobile` 1260:40711)
- Header dissolved, Follow CTAs under the rail; `.events-grid` → snap rail of fixed 240×300 cards (264px steps), five cards + the link tile.
- Card: body overlay 16px padding / 82px, date row `space-between` with the source's brand mark (16px), title one line with ellipsis (intentional — social titles are unpredictable), pill inset 16, hover layer parked (`opacity` pinned). Day: Parchment + `1px 1px 4px` shadow, Peppercorn title, Soft Peppercorn caption date, overlay clear → Parchment at 42.8%. Night: Lime date, Paper title, overlay Peppercorn to 63% → clear at 90%. Pinned: 2px Lemon, no glow, night overlay Peppercorn to 65.9% → 30%. "Today!" keeps Chili / Lemon.
- Link tile: photo `blur(2px)` + `scale(1.04)`, 75% Peppercorn scrim, Lime 600 text by night.

---

## Reserve Drawer — Bar State Engine

3 states driven by time of day:

| State | Condition | Color | Status text |
|---|---|---|---|
| Available | Default open hours | Lime | "All good — admin is on the phone" |
| Busy | Fri/Sat after 22:00 | Orange `#E8751A` | "Might take a minute, it's loud in here." |
| Closed *(label and icons Lemon since 20 Sep 2026 — the primary pairing; were white)* | Outside the Bar Settings hours, on the bar's clock (default 02:00–08:30, 10:00 Sun) — `bar-clock.js`, 20 Sep 2026 | Chili | "We'll pick up from {opens}." — the next opening from Bar Settings: 8:30, Sundays 10 |

**Fixed tab shadow (Sep 2026):** `.btn-fixed-wrapper .btn` now uses the house card shadow rotated into its local frame (`-1px 1px 4px rgba(21,19,23,.15)`), matching the menu jump tab — see *Menu Jump-Nav*.

**Slide easing (Sep 2026):** the drawer slides on `right var(--dur-gentle) var(--ease-gentle)` (was `0.4s` expo-out). The spring overshoots ~3% inward, so `.reserve-drawer` carries a solid `32px 0 0 var(--surface)` box-shadow extension off-screen to the right — that frame shows drawer, not scrim. Overlay fade stays `0.3s`.

**Phone sheet (Sep 2026, Figma `reserveModal-mobile` 1198:53322):** ≤ 767px the panel becomes a bottom sheet — `transform: translateY(100%)` → `none` on `--ease-gentle`, `visibility` toggled with the transition, `box-shadow: 0 −4px 20px … , 0 32px 0 var(--reserve-ground)` (the solid extension covers the overshoot below), 8px top radii, `max-height: calc(100dvh − 24px)` with the content scrolling, safe-area bottom padding. Content order on phones: header → phone CTA → messengers → footer line → ticket (`order: 10`). 64px × with a 16px glyph. Tablets (768–991) keep the 420px right panel. Ground tokens: `--reserve-ground` / `--reserve-card` — desktop `--surface` / `--paper` (Soft Peppercorn by night), phones `--bg` / `--parchment`; the rugged edges pass `'reserve-ground'` / `'reserve-card'` so they always match. Title Chili by day / Paprika by night on phones. ↗ (`ph-arrow-up-right`) on VK / Instagram at every width — the desktop mockup's → is the one to correct.

**Dialog semantics (Sep 2026, every width):** `role="dialog"`, `aria-modal`, `inert` + `aria-hidden` while shut; open moves focus to the ×, close returns it to the opener; Escape closes; Tab is trapped. Bar state now applies to every `.phone-cta-wrapper` (the home Contacts block reuses the markup on phones).

---

## Rugged Edge Component

- `radial-gradient(circle at 24px 0, color 11.5px, transparent 12px)`, `background-size: 48px 12px`, `background-position: center top`, `repeat-x`, height: 12px.
- **Centred tiling (Sep 2026):** the circle sits in the middle of its 48px tile and the tiling is anchored to the horizontal centre, so circle centres land at `W/2 ± 48n` for any element width. The pattern is mirror-symmetric and the two end circles are always trimmed equally — no lone chopped circle at one side. This mirrors Figma, where the 1280px `ruggedEdge` instance is centre-aligned in its container (on the 548px hours card both give circles at 34px and 514px, 22px margin each side). Before this the tile was anchored `top left` with the circle at 12px, so the phase depended on the width and the right edge was arbitrary.
- **Footer top edge**: in normal flow inside `.footer-rugged-top` (lime bg), circles coloured `--parchment` (day) / `--peppercorn` (night, via `!important` override on inline style). Creates scalloped transition from preceding section. `.site-footer` itself is Lime (Sep 2026), so the seam between the strip and `.footer-main` can only ever show Lime. Visit on phones passes Soft Peppercorn — the section above ends on the full-bleed form, not the section ground.
- **Reserve drawer edges**: top = `position: absolute; top: -1px`, bottom = in flow, flush with card (`gap: 0`).
- **Visit hours card**: same ticket pattern as reserve-drawer/dish-picker. Container = `overflow: hidden; isolation: isolate`. Top edge = `position: absolute; top: 0; left: 0; right: 0; z-index: 3` (Peppercorn circles bite into the Parchment card from above); the card carries a `1px solid var(--peppercorn)` top border and the strip's centre row sits on it, so the dark → Parchment boundary is painted by one element (border + background in one pass) and cannot open a hairline at a fractional y (Sep 2026; 11px of bite as before). Card = in flow, `z-index: 2`. Bottom edge = in flow, `z-index: 1` (Parchment circles extend out from card into the dark section). Edge wrappers must be full width — a centred flex column shrinks an empty wrapper to 0 and the edge disappears.
- **Menu deal / add-ons edges (fixed Sep 2026):** every deal top edge and add-ons bottom edge passes `'section-bg'`, which `.menu-section` sets to `--bg` or `--surface` per the striping. They used to hardcode `'bg'`, so in even sections the scallops were Paper on Parchment (day) / Peppercorn on Soft Peppercorn (night). Audited: all 24 edges across food + drinks × day + night now equal their section background.
- Card padding handles spacing between edges and content.

---

## Contacts Section

### HTML Structure
```
section#contacts.home-contacts               ← bg: surface/bg
  └── div.container                          ← flex column, gap 80px
        ├── .section-link-word--reflection   (JOIN THE PARTY, shared seam with Events)
        ├── .section-header                  (eyebrow + headline + description | VK + Instagram CTAs)
        ├── .contacts-split                  (flex row, gap 24px)
        │     ├── .contacts-map-wrap
        │     │     └── .contacts-map        (rounded-8, overflow hidden)
        │     │           ├── .contacts-map__embed  (Google Maps iframe, min-height 300px)
        │     │           └── .contacts-map__bar    (address + chips)
        │     │                 ├── .contacts-map__address  (pin icon + text)
        │     │                 └── .contacts-map__chips    (Copy + Directions chips)
        │     └── .contacts-form-wrap
        │           └── contact-form.php     (form card component)
        └── .section-link-word               (PEPPER IS COOKING)
```

### Map Embeds
- **Google Maps** (active): `mid=1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY`
- **Yandex Maps** (available): constructor ID `973359c7561447517446291b28c1cd04a30ecf57d5755c1ec248cd53388c4b95`

### Map Address Bar Chips
| Chip | Icon SVG | Action |
|---|---|---|
| Copy | `c-copy.svg` | Copies "Yaroslavl, Kirova 10/25" to clipboard |
| Directions | `c-navigate.svg` | Opens Google Maps directions link |

### Contact Form — 3 States (`data-form-state`)
| State | Content |
|---|---|
| `email` | Name + Email + toggle pills (Email active, Phone inactive) + Message + Submit |
| `phone` | Name + Phone + toggle pills (Phone active, Email inactive) + Message + Submit |
| `success` | Checkmark badge + title + body + 2× contact-item (email + phone) + Reset btn |

### Form Error Handling
- Error text sits **inline in the label row** (right-aligned, same line as label)
- Uses `var(--paprika)` color
- Form height stays constant — no layout shift
- Class: `.contact-field--error` on the field wrapper

### Autofill Override
- `:-webkit-autofill` box-shadow trick to replace browser's blue background
- Day: `parchment` inset bg + `peppercorn` text
- Night: `peppercorn` inset bg + `paper` text

### Success State — Day/Night Colors
| Element | Day | Night |
|---|---|---|
| Badge border | `--avocado` | `--lime` |
| Badge bg | `rgba(134,148,56, 0.15)` | `rgba(193,219,52, 0.15)` |
| Badge/title color | `--olive` / `--avocado` | `--lime` |
| Body text | `--ash` | `--paper` |
| Info box bg | `--parchment` | `--soft-peppercorn` |
| Info label | `--ash` | `--mushroom` |
| Contact text/icons | `--soft-peppercorn` | `--paper` |

### Contact-Item Component (Figma: `contactItem-day`, 1819-128718)

Reusable across success state and future contact page.

**Props:**
| Prop | Type | Description |
|---|---|---|
| `icon_svg` | string | Path from `assets/` to leading icon (e.g. `icons/c-mail.svg`) |
| `contact` | string | Contact text displayed (e.g. `hello@sweetpepper.bar`) |
| `copy_text` | string | Text copied to clipboard (defaults to `contact`) |
| `supportive_text` | string | Optional second line (e.g. "fastest reply — usually minutes") |

**Interaction States:**
| State | Trigger | Visual |
|---|---|---|
| Default | — | Icon (`--avocado` day / `--lime` night) + text. Copy chip hidden (`opacity: 0; transform: translateX(8px); pointer-events: none`) |
| Hover | Row hover | Chip appears (`opacity: 1; transform: translateX(0)`) with cream bg |
| Hover2 | Chip hover | Chip bg → `var(--lemon)` |
| Success | Click | `.is-copied` class → label "Copied!" + fire icon (`fire.svg`, `currentColor` fill). Reverts after 2s |

### Custom SVG Icon System (`assets/icons/c-*.svg`)

**Inline rule (Sep 2026): every inline SVG goes through `sweet_pepper_inline_svg()`, never a raw `file_get_contents` echo.** Most Figma exports carry a `clipPath` with a per-file id; a browser resolves a repeated id to the *first* copy in the document, and if that copy sits in a `visibility: hidden` subtree the clip region is empty — every later raw copy of the same file renders as nothing. The phone nav drawer (every page, before the content, hidden on phones) was that first copy for the arrow and the ×, which is why the menu highlight cards lost their arrows and the jump-nav door its glyph. Converted: `mobile-drawer.php` (arrow, ×, card link), `menu-hero.php`, `menu-jump-nav.php`, `menu-highlight-card.php`, `bar-snacks.php` (deal arrow), `dish-row.php` (veg / fish / egg…), `about/careers.php`, `visit/hero.php` (hours link). Still raw and unconverted (their first copy is visible today, so they render): `visit/hero.php` state / event / contact icons, `visit/location.php`, `contact-item.php`, `contact-form.php`, `team-form.php`, `highlight-card.php` tag icon, `header.php` hamburger, `front-page.php` map chips. Move them over as touched.

Icons with hardcoded `fill="#FFED00"` have `currentColor` variants prefixed `c-`:
| Original | Variant | Usage |
|---|---|---|
| `copy.svg` | `c-copy.svg` | Copy chips (map bar + contact-item); ticket chip; phone CTA |
| `navigate.svg` | `c-navigate.svg` | Directions chip |
| `pin.svg` | `c-pin.svg` | Map address bar |
| `checkmark.svg` | `c-checkmark.svg` | Success badge; chip "Copied!" state; booking status *available* mark |
| `mail.svg` | `c-mail.svg` | Email icon + reset button; contact-form and team-form email fields |
| `phone.svg` | `c-phone.svg` | Phone icon; contact-form phone field; phone CTA |
| `Pepper.svg` | `c-Pepper.svg` | Copied! feedback icon |
| `arrow-right-outline.svg` | `c-arrow-right-outline.svg` | CTA right arrow (VK/Instagram buttons); Visit landmark badges |
| `arrow-out.svg` | `c-arrow-out.svg` | Hands-off ↗: contact-card rows, reserve-drawer social buttons, map chips |

**Standalone `currentColor` SVGs** (no `c-` variant needed):
| File | Usage |
|---|---|
| `Pepper.svg` | Bar menu "See the full bar card" button icon (uses `currentColor`) |
| `food.svg` | Kitchen menu "See the full kitchen menu" button icon (uses `currentColor`) |
| `fire.svg` | Contact-item "Copied!" success icon (uses `currentColor` via CSS override) |

Brand icons (`vk.svg`, `insta.svg`) keep their original colors — not `currentColor`.

`button.php` uses `icon_left_svg` / `icon_right_svg` params to inline SVGs via `file_get_contents()`, so `currentColor` SVGs inherit the button's CSS `color` and adapt to day/night + hover states. All SVGs inside `.btn-icon` are forced to 16×16 by CSS.

### Mobile (Sep 2026, Figma `Contacts` 1198:53132)
- The form is dropped on phones (author: it made the section too long); desktop keeps it. `.home-contacts .section-ctas`, `.contacts-form-wrap` and `.contacts-map__bar` are hidden ≤ 767px; three phone-only blocks (`display: none` above 767px) take over:
  - `.contacts-reserve` — the drawer's booking block in the flow: `.phone-cta-wrapper` (same markup, bar-state driven) → `.contacts-reserve__row` (VK / Instagram `btn-secondary`, half width each) → "Usually answer in 20 minutes" status line.
  - `.contacts-map-wrap` becomes the "Get directions" band: `margin: 0 −16px; padding: 24px 16px`, ground `--bg` day / `--surface` night (the *other* ground — the alternation stays as on desktop), `h2.contacts-subtitle` (Olive / Cream), the same Google iframe at `clamp(360px, 100dvh − 352px, 400px)` (band fits one screen under the header; "Looking for more?" fits too from ~750px tall), `.contacts-map__chips--phone`: "Copy Address" (`c-copy.svg`) and "Yandex Maps" (`c-arrow-out.svg`, `yandex.ru/maps/?rtext=~57.6261,39.8845`) as Golos Medium 13 pills (8/16, radius 100, Soft Peppercorn fill by night).
  - `.contacts-more` — "Looking for more?" H2, "Parking, city sights, directions, hours:" (Body/Semibold) and a "Visit Page →" link (Olive / Lime 600, 12px arrow) to `/visit/`.
- Phone description via `section-header.php` → `description_mobile` ("Walk-ins always welcome — booking matters Friday–Saturday evenings.", Body 16 since 18 Sep 2026; was Body/Secondary 14, retired).
- Section: `padding-bottom: 48px`, container gap 24 with the header pushed 24 down (48 from the connector).

---

## How It Feels (About page) — Field Word Cloud + Quote Wheel

Spec: `about-page-copy.md` → How it feels (+ *Cloud layout candidates*). Pipeline and implementation rules: `website-brief.md` → "How it feels" → Part 3. Motion studies (A Rows / B Field / C Bands / D Still / E Pile): `design-examples/how-it-feels-cloud-studies/`. **Built with layout B (Field), Sep 2026.**

### HTML Structure
```
section#how-it-feels.about-how-it-feels          ← surface bg (Parchment), padding 80px 0
  └── .container
        ├── .section-header                         (WORD OF MOUTH / HOW IT FEELS)
        └── .about-how-it-feels__inner              ← flex, gap 48px
              ├── .about-how-it-feels__cloud        ← flex: 1, stretches to the rail's height
              │     └── .about-cloud.about-cloud--field
              │           └── .about-cloud__row × 5  (no-JS / pre-hydration state)
              │                 └── .about-cloud-word[data-key][data-tier][style=font-size]
              └── .about-how-it-feels__quotes       ← flex: 0 0 540px
                    ├── .about-how-it-feels__quotes-viewport   (height set by JS = 3 cards)
                    │     └── .about-how-it-feels__quotes-track
                    │           └── div.about-quote-card__wrap[data-quote-id][data-word] × N (+2N clones)
                    │                 └── div.about-quote-card  (mark + text + source; content gap 12px)
                    └── .about-how-it-feels__cta    (btn-primary-green "Add your word ↗")
```

### Data (still hard-coded in `how-it-feels.php`)
- `$cloud_rows`: 16 words in 5 rows, `tier` ∈ top/mid/low with sizes **56 / 36 / 24** tied 1:1 to tier (the copy doc's 64 / 40 / 26 does not fit the column — open item in `about-page-copy.md`). `$default_active = 'welcoming'` renders filled server-side. 4 top-tier words with 2 reviews each (cosy, welcoming, friendly, inviting); 7 mid-tier (beloved, happy, perfect, magnetic, sociable, wonderful, pleasant, charming); 4 low-tier (attentive, lively, kind, inclusive).
- `$quotes`: 20 excerpts from `about-reviews.md` (15 Yandex + 5 Google; RU original + EN, platform, footnote, review link, `word` key). Words with several reviews cycle on repeat-click. Cards are `<div>` (not links); only the "original in RU" link inside the source line is clickable.
- Planned home: `inc/how-it-feels.php` + `data/how-it-feels.json` + ACF quotes (see `website-brief.md`). PHP is fetch-and-hand-over only.

### Word states (CSS)
| State | Selector | Look |
|---|---|---|
| Idle | `.about-cloud-word` | transparent fill, 1.5px `-webkit-text-stroke` in the tier colour (Chili / Olive / Ash) |
| Hover (pointer only) | `.about-cloud--field .about-cloud-word:hover` | stroke → 2.5px (the rows-layout `scale(1.08)` hover is not used in the field) |
| Active | `.is-active` | stroke 0, filled in the tier colour, `z-index: 2` |
| Dimmed | `.about-cloud.has-focus .about-cloud-word:not(.is-active)` | opacity 0.3 |
| Placing | `.about-cloud--field.is-placing .about-cloud-word` | `visibility: hidden` for the first frame (no 0,0 flash) |
| Placed | `.about-cloud--field.is-placed .about-cloud-word` | `position: absolute; left: 0; top: 0`, `will-change: transform`, **transition on colour/stroke/opacity only — never transform** (the rAF loop writes transform every frame) |

### Field lifecycle (`how-it-feels.js`)
1. **Gate.** `document.fonts.load('56px Molot')` raced against a 1.5 s timeout (never `fonts.ready` — it waits for Golos over the network); bail if the cloud has no width; below `MOBILE_BP` (768) keep the rows.
2. **Measure in the row layout.** `offsetWidth`/`offsetHeight` per word, `cloudW` from the cloud, and **`cloudH = max(column wrapper height, rows height, FIELD_MIN_H 480)`**. The wrapper (`.about-how-it-feels__cloud`) stretches to the quote rail, so the field gets the rail's ~530 px. *This was the "words pile up" bug (fixed 2026-09-08): the height was taken from the row layout (~280 px for 4 rows); a spiral needs roughly twice the area of packed rows, so 6 of 11 words found no legal spot and silently fell back to the centre.*
3. **Spiral placement**, largest area first: r = s × 0.9 px, θ = θ₀ + s × 0.35 (θ₀ hashed from the word list, stable across visits), scaled by `kx = min(1, W/H)`, `ky = min(1, H/W)` so the walk fills a portrait column. First spot inside `FIELD_INSET` with `WORD_GAP` to every placed box wins. If none in 3000 steps: retry with half gap → no gap → no inset, and only then land on the centre with a `console.warn` naming the word and the field size.
4. **Switch.** `cloud.style.height = cloudH`, add `is-placed`, write every transform while still `is-placing`, drop `is-placing` next frame.
5. **Idle loop (rAF).** Each word eases (8 %/frame) toward home + two slow sines (9–19 s, 6–12 px) + a lean of up to 12 px toward a pointer within 170 px. Loop pauses off-screen (same `IntersectionObserver` as the clock). `prefers-reduced-motion`: no loop.
6. **Commit (click on a word or on a card).** Fill; seize the clock 8 s; target = column centre; cleared zone = the word's box + `COMMIT_MARGIN` 28; 200-iteration relaxation on copies of the homes — pull home 4 % (first 120 iterations only) → push out of the zone radially 8 px → clamp to inset → if still in the zone step 8 px vertically → pairwise AABB separation with the gap (**last**) → clamp. Results become targets; the loop eases into them. Checked for every word as the centred one: no neighbour in the zone, no overlaps, nothing outside the inset.
7. **Release** (clock resumes or the heartbeat fills the next word): targets = homes, `has-focus` off. The heartbeat only ever fills — it never centres.
8. **Resize** (200 ms debounce): re-size the rail viewport; field → rows below 768, else reset (`is-placed` off, height and transforms cleared) and re-run 1–5.

### Quote wheel (unchanged from the rail studies)
3 cards visible; `scroll-snap-type: y mandatory`; originals sit between a prepended and an appended clone set, and a settle on a clone jumps instantly (snap + smooth disabled for two frames) to its original. Centred card ↔ its word are one state: scrolling fills the word, clicking a word scrolls its first card, clicking an edge card pulls it to centre (only the centred card's link navigates).

---

## The Pepper Story (About page) — Heat-line timeline + counter ledger

Spec: `about-page-copy.md` → The Story (timeline divider + counter ledger). Decision record: `website-brief.md` → The Pepper Story. Interaction studies (A By the book / B Heat line / C Printed slip / D Poster number): Claude Design canvas *The Pepper Story · Interaction Studies*, 2026-09-08. **Built with option B (Heat line), Sep 2026.**

### HTML Structure
```
section#story.about-section--light.about-section--surface.about-story    ← classes added by JS: is-armed → is-in → is-heated
    └── .container
        ├── .about-story__inner                   (section-header + 3 ¶ | founder: img-wrap[pr-12 mb-[-12]] + quote-wrap[pl-12] with 1° tilted quote card, two-line source attribution)
        ├── .about-story__timeline                ← position: relative; --axis-top: 28px
        │     ├── .about-story__timeline-line     (Ash 35 %, 1px, scaleX 0 → 1 on entrance)
        │     ├── .about-story__timeline-heat     (Chili 3px; left: --heat-start (24px); width: --heat-end − --heat-start)
        │     ├── .about-story__timeline-cap      (1×9 Chili at the left end)
        │     ├── .about-story__timeline-arrow    (CSS-border arrowhead past the last marker)
        │     └── .about-story__milestone--{1,2,3}.--past|--now[style=left:N;--enter-delay][data-left][data-dims-ledger] × 3
        │           (Molot 16 Avocado year, Chili H3 name, Ash caption wit; milestone-1 at 24px fixed)
        └── .about-story__counters                ← Paper card + mushroom border, 128px gap; .is-dim while hovering 2009
              ├── h3.about-story__counters-label  (TWELVE YEARS, <br> COUNTED IN ORDERS — Molot H3 Olive, flex-shrink: 0)
              ├── .about-story__counters-row      (justify-content: space-between)
              │     └── .about-story__counter × 3   → __counter-number[data-count=int] (Molot 44 Paprika 1.76px tracking) + __counter-label (13px Ash 0.56px tracking)
              └── script.about-story__counter-pool  (application/json: the full pool, [{number, label}])
```

### Data (hard-coded in `story.php`)
- `$milestones`: 2009 TABASCO BAR (`--past`, `dims => true`, left: 24px) · 2014 SWEET PEPPER (`--past`, left: 34%) · 2026 STILL HERE (`--now`, left: 77%). `--enter-delay` = index × 120 ms staggers the pop.
- `$counters`: integers, rendered server-side with `number_format($n, 0, '', ' ')` (space thousands, RU style); the same formatting is reproduced in JS. Three slots are shown; the pool is emitted as JSON. **Currently 128 400 / 41 200 / 96 700** — values updated to match Figma.

### States (CSS)
| State | Selector | Look |
|---|---|---|
| Past marker | `.about-story__milestone--past .about-story__milestone-name` | transparent fill, 1px Chili `-webkit-text-stroke` |
| Lit / hover | `.about-story__milestone--past.is-lit …-name`, `:hover` under `@media (hover: hover)` | filled Chili, stroke transparent; tick `scaleY(2)`; wit Ash → Peppercorn |
| Current marker | `.about-story__milestone--now` | always filled (filled = current, per the motion language) |
| Armed | `.about-story.is-armed` | axis + heat `scaleX(0)`; cap, years, ticks, names, wits `opacity 0; translateY(8px)`; arrow `translateX(−12px)` |
| In | `.about-story.is-in` | axis draws 700 ms; labels pop with `500 ms + --enter-delay` (tick +50, name +100, wit +150); arrow lands at 900 ms (spring) |
| Heated | `.about-story.is-in.is-heated` | heat `scaleX(1)` over 900 ms; hover afterwards animates `width` 500 ms |
| Ledger dim | `.about-story__counters.is-dim` | opacity 0.4, 400 ms |
| Slot out | `.about-story__counter.is-out` | number + label `opacity 0; translateY(−8px)` 250 ms; return springs from below |
| Reduced motion | `@media (prefers-reduced-motion: reduce)` | every armed pre-state neutralised, no transitions; JS also writes final numbers directly |

### Lifecycle (`about-story.js`)
1. **No JS / no `IntersectionObserver`:** the server-rendered state is the finished state (all labels visible, heat full, final numbers). The observer-less branch only wires hover and (if the pool allows) the clock.
2. **Arm.** Add `is-armed`; unless reduced motion, write `0` into every counter.
3. **Enter (threshold 0.35, once).** `is-in` → after `HEAT_DELAY` `is-heated` → after `COUNT_DELAY` each slot counts up (ease-out cubic, 1.4 s, 120 ms stagger) → `entranceDone` → clock starts if `pool.length > slots.length`.
4. **Hover a marker.** `--heat-end` = its `data-left` %, `is-lit` on it, `is-dim` on the ledger when `data-dims-ledger="1"`; leaving restores the heat to the arrowhead.
5. **Clock.** Every 4 s one slot goes `is-out`, swaps to the next pool item, counts up over 1 s. Ledger hover stops the clock; it resumes 8 s after leaving. Off-screen stops it; re-entering restarts it unless a resume timer is pending.

---

## Dream Guests (About page) — Photo Card Grid

Spec: `about-page-copy.md` → The People → Guests / Community. Figma frame node `323-6801`. Built Sep 2026.

### HTML Structure
```
section#guests.about-section--dark.about-section--surface-dark.about-guests  ← Soft Peppercorn bg
  └── .container
        ├── .section-header                  (COMMUNITY FIRST / THE DREAM GUESTS + description | VK Photo albums CTA)
        └── .about-guests__grid              (CSS grid 4×2, gap 24px)
              └── a.about-guests__card (×8)  (VK album link, target=_blank)
                    ├── img.about-guests__card-img  (absolute cover, 4px radius)
                    └── .about-guests__card-pill    (Lemon/Peppercorn caption, 90% opacity, bottom-left)
```

### Card Data (hard-coded in `guests.php`)
| # | Label | Image | VK Album ID |
|---|---|---|---|
| 1 | Pepper's 12th Bday! | `eventCovers/12y.jpg` | `308753763` |
| 2 | Mexican Party! | `eventCovers/mex-25.jpg` | `306320532` |
| 3 | Halloween 2025! | `eventCovers/halloween-25.jpg` | `307968926` |
| 4 | St. Valentine 25! | `eventCovers/val-25.jpg` | `305100418` |
| 5 | Pepper's 9th Bday! | `eventCovers/9years.jpg` | `289731109` |
| 6 | Teachers Day! | `eventCovers/teachers-24.jpg` | `296448131` |
| 7 | Bartenders Day! | `eventCovers/bartenders-2022.jpg` | `281391602` |
| 8 | Halloween 2023! | `eventCovers/Halloween-23.jpg` | `297622926` |

All VK URLs: `https://vk.ru/album-64582467_{ID}`. Section CTA links to all albums: `https://vk.ru/albums-64582467`.

### Card States
| State | Border | Shadow | Image | Transition |
|---|---|---|---|---|
| Default | `1px solid transparent` | none | — | — |
| Hover (`@media (hover: hover)`) | `1px solid var(--lime)` | `0 0 16px rgba(212,230,113,0.5)` (lime glow) | `scale(1.02)` | 800ms `--ease-gentle-flat` (shadow/border), 800ms `--ease-bouncy` (transform) |
| Pressed (`:active`) | `1px solid var(--lime)` | `inset 2px -2px 8px rgba(21,19,23,0.25)` | `scale(1)` | — |

### Section Specifics
- **Background:** `.about-section--surface-dark` = Soft Peppercorn, distinct from the standard `.about-section--dark` (Peppercorn). Inherits all dark section typography overrides (Chili headline, Paprika headline_2, Lime CTA).
- **Eyebrow:** Cream (`#FFF689`) via `.about-section--surface-dark .section-eyebrow` override — not Lime (the standard dark section eyebrow). Matches the Figma frame.
- **CTA:** `btn-secondary` dark variant with VK icon left (`icons/vk.svg`) + arrow right (`icons/c-arrow-right-outline.svg`).
- **Image source:** `photos/menu-website/eventCovers/` → synced to `sweet-pepper-theme/assets/images/eventCovers/`. 11 files in the source; 8 used in the grid.

---

## Dream Team (About page) — Drift Strip + Team Card Grid

**Section:** `#team`, class `about-section about-section--light about-section--surface about-team`
**Background:** Parchment (`#F3E9D2`)
**Headline:** Single-line "THE DREAM TEAM" (Chili), eyebrow "THE ONES WHO KNOW YOUR ORDER" (Avocado)
**CTA:** "Write to the team" → `#contact` (btn-primary-green, arrow right)
**JS:** `about-team.js` — card message toggle (chip click → fact state, back arrow → default, one-at-a-time)

### HTML Structure

```
section.about-section.about-section--light.about-section--surface.about-team
├── div.container
│   └── section-header (eyebrow + single H1 + CTA)
├── div.about-team__drift                          ← horizontal scroll, outside container
│   └── div.about-team__drift-track                ← flex row, max-content width, clothesline ::before
│       ├── div.about-team__wall-card.--v1|--v2    ← 7 photo cards (2019–2025)
│       │   ├── div.about-team__wall-pin.--lime|--paprika
│       │   └── div.about-team__wall-photo-wrap    ← tilted ±1°, straightens on hover
│       │       ├── img.about-team__wall-photo
│       │       └── div.about-team__wall-pill > span (year)
│       └── div.about-team__wall-card.--tbc        ← "To be continued…" end card
└── div.container
    └── div.about-team__grid                       ← 4×2 CSS grid
        └── div.about-team__card (.--has-message if data exists)
            ├── div.about-team__card-default        ← visible by default
            │   ├── div.about-team__card-photo-wrap > img
            │   └── div.about-team__card-info
            │       ├── div.about-team__card-member-info (name + role)
            │       └── button.about-team__card-chip (label + arrow SVG)
            └── div.about-team__card-active [hidden] ← shown on chip click
                ├── div.about-team__card-photo-wrap > img
                └── div.about-team__card-info
                    └── div.about-team__card-member-info
                        ├── div.about-team__card-name-row (back + name + "Says")
                        └── p.about-team__card-message
```

### Drift Strip — Wall Photos

| # | Year | Photo file | Variant | Pin colour | Photo tilt |
|---|------|-----------|---------|------------|------------|
| 1 | 2019 | `team/group/2019.jpg` | v1 | Lime | -1° |
| 2 | 2020 | `team/group/2020.jpg` | v2 | Paprika | +1° |
| 3 | 2021 | `team/group/2021.jpg` | v1 | Lime | -1° |
| 4 | 2022 | `team/group/2022.jpg` | v2 | Paprika | +1° |
| 5 | 2023 | `team/group/2023-1.jpg` | v1 | Lime | -1° |
| 6 | 2024 | `team/group/2024.jpg` | v2 | Paprika | +1° |
| 7 | 2025 | `team/group/2025.jpg` | v1 | Lime | -1° |
| 8 | — | (none) | tbc | Paprika | — |

- **Clothesline:** 4px Olive `::before` pseudo-element spanning the full track at `top: 8px` (pin vertical centre)
- **Hover:** photo wrap tilt transitions to 0° (`--ease-bouncy`, 800ms)
- **Track alignment:** `padding-left: max(80px, calc((100vw - 1120px) / 2))` matches container content edge

### Team Card Data (8 members)

| # | Name | Role | Photo | Chip | Message |
|---|------|------|-------|------|---------|
| 1 | Kostya | General Manager · 8 years | `team/kostya.jpg` | Ask me about… | *placeholder* |
| 2 | Lera | Floor · 7 years | `team/lera.jpg` | Ask me about… | Start with the salted caramel infusion… |
| 3 | Lenya | Floor Manager · 6 years | `team/lenya.jpg` | What I pick at the bar | *placeholder* |
| 4 | Anton | Bar chef · 5 years | `team/anton.jpg` | Ask me about… | *placeholder* |
| 5 | Stas | Unforgettable waiter · 8 years | `team/stas.jpg` | Ask me about… | *placeholder* |
| 6 | Alex | Bartender · 5 years | `team/alex.jpg` | Ask me about… | *placeholder* |
| 7 | Max | Chef · 8 years | `team/iura/iura-1.jpg` ⚠️ | Ask me about… | *placeholder* |
| 8 | Johnny | Sous-chef · 12 years | `team/iura/iura-1.jpg` ⚠️ | Ask me about… | *placeholder* |

⚠️ Max & Johnny use Iura's photo as placeholder — awaiting real portraits. *Placeholder* lines (Sep 2026) exist only so every phone row has a chip and a reveal to judge the layout by; the members' own words come from about-page-copy.md → Dream Team.

### Team Card States

| State | Trigger | Visual |
|-------|---------|--------|
| Default | — | Parchment bg, `1px 1px 4px` shadow, 16px info gap, chip: Avocado border / Olive text / py-4px |
| Hover | Card `:hover` | Parchment bg, `4px 4px 16px` shadow (`--ease-gentle-flat`, 800ms), 12px info gap (300ms), chip: Paprika border+text / semibold / py-2px (300ms) |
| Fact | Chip click (JS) | Paper bg, `1px 1px 4px` shadow, `← Name Says` + message text, `.is-active` class |
| Fact — phones | Chip click (JS), same chip closes | Row stays; message reveals under it (`0fr → 1fr`, 300ms flat); card Paper; chip `aria-expanded="true"` → Paprika border/text, chevron rotated 90° to point down (Sep 2026). Back arrow and second photo hidden |

### Section Specifics
- **Background:** `.about-section--surface` = Parchment — light section. Page order: Story (Parchment) → Guests (Soft Peppercorn) → **Team (Parchment)** → Careers (Peppercorn).
- **Headline:** Single-line "THE DREAM TEAM" — differs from Guests/Story which use two-line headlines.
- **Drift strip alignment:** The drift sits outside `.container` for full-bleed horizontal scroll. Left edge aligns with container content edge via `max()`. Right side scrolls beyond viewport.
- **Image source:** `photos/menu-website/team/` → synced to `sweet-pepper-theme/assets/images/team/` (portraits + group subfolder + iura/lenya subfolders).

---

## Footer (every page)

Desktop: rugged top edge (page-specific circle colour), stamp (rotates 180° on hover), GO TO / HOURS / VISIT columns, bottom bar (copyright + Back to top). Rendered by `footer.php`; the reserve drawer is output after `#page`.

### Mobile (Sep 2026, Figma `footer-mobile` 1245:39505)
```
footer#colophon.site-footer                  ← lime, padding-bottom 34px + safe-area
  ├── .footer-rugged-top                     (circles = preceding section: home Parchment/Peppercorn, menu Paper/Soft Peppercorn, About/Visit Peppercorn)
  ├── .footer-main                           ← padding 24px 0 20px, radius 0 0 8px 8px
  │     └── .container                       ← column, gap 20px
  │           ├── .footer-mobile-top          (Symbol 24px + Molot H2 "SWEET PEPPER BAR" Chili | "Top" link 13px ↑, 44px tall)
  │           ├── .footer-stamp               (hidden)
  │           └── .footer-nav                 ← grid 1fr 1fr, gap 20px 16px, 0.5px Ash rule above
  │                 ├── .footer-col--nav      (GO TO — H3 18, links Golos 16 Dark Olive, gap 6)
  │                 ├── .footer-col--hours    (HOURS — day 600 Dark Olive above time 400 Peppercorn, gap 1 / 6)
  │                 └── .footer-col--visit    ← spans both columns, grid 1fr auto, 0.5px Ash rule above
  │                       ├── .contact-item--phone    (600 Dark Olive)   .footer-socials (VK, Instagram — 44px targets, 24px marks)
  │                       └── .contact-item--address  (Caption 13)
  └── .footer-bottom                         ← --lime-light, padding 12px 0, copyright centred Caption 13 Ash; Back to top hidden
```
- `arrow-up.svg` ships with a Lemon fill — `.footer-top-link__icon svg path { fill: currentColor }`.
- VK leads Instagram at every width (website-brief.md → News/social feed); the desktop mockup had Instagram first.

---

## Known Issues / Open Items

- **Status corrected 18 Sep 2026:** phones and tablets (768–991) are built on all four pages (Home, Menu, About, Visit) — see the per-page *Mobile —* / *Tablet —* sections in `website-brief.md` and Grid → Tablet. The paragraph below is the historical record from mid-September; its "About and Visit pages pending" and "Tablets … unmocked" lines are superseded.
- Responsive / mobile layout in progress (Sep 2026): **home page complete on phones** — header, drawer, hero bento, reserve sheet, Highlights, Bar / Kitchen previews, About preview, Events, Contacts, footer (all recorded per section above and in `website-brief.md` → Mobile — …). Tablets (768–991) still get the desktop sections inside 24px gutters, unmocked. **Menu page layout built on phones (Sep 2026)** — one-viewport hero with drawer preview + commit button, one section at a time with a sticky canonical-order rail, highlights 2-up grid (both states, night title split), picker (gutter-to-gutter tag rail; Shake It! between the photos since 18 Sep 2026 — the refinement pass), entrance photo, location (eager map embed), the phone-only "Come sit with us" closer (`website-brief.md` → Mobile — Menu page); its components still show their desktop anatomy at 370 (deal, add-ons, highlight card, ticket) — next pass. Nine per-section connector words are unused on phones (one tail word serves all). About and Visit pages pending. Mobile hero open items: lang-nudge hidden (no mobile design), FLIP move for the tapped tile, 375×667 overruns the viewport by 4px. **Viewport rule (measured Sep 2026):** the unbuilt desktop-only sections (footer columns 594px, highlight cards, event cards) overflow a 402px viewport, and mobile Chrome then widens the *layout viewport* to the document's min-content width (595px) — every fixed element (header, drawer) stretches with it and the hamburger lands off-screen. `overflow-x: clip` / `hidden` on `html` does **not** prevent it; `contain: inline-size` on `#page` doesn't either; `#page { overflow-x: clip }` (or `hidden`, or `body { overflow-x: hidden }`) does. Kept the `#page` clip in `main.css`; it can stay after the sections are rebuilt. Working breakpoints: nav collapses ≤ 991px; phone gutter < 768px. Figma source frame: `home-browser-1-bento-day-final` 2048:127656 (night: 2048:126960).
- **Content placeholders for the author's final review (spotted Sep 2026):** Infusions → Horseradish row's description reads "description"; Highlights title "Summer Menu Highlights" is a placeholder that follows the season; the bar page's highlight cards are the kitchen's six until the team supplies the bar's; captions "Berry festival" (Infusions) and "The legend of the Kirova street" (every picker dish) are unverified.
- **Bar Snacks deal link is a dead anchor (spotted Sep 2026, not fixed):** `template-parts/menu-sections/bar-snacks.php` links to `#bar-menu`, which no element has; the spring-scroll binder skips unknown anchors, so the click does nothing. It should point at the drinks menu (`/menu/?menu=drinks`) or a real section id.
- **Motion rule in the brief is narrower than the build (Sep 2026):** `website-brief.md` → Motion language sanctions spring easing for "prints, rolls and snap-backs"; the theme now applies Figma Gentle site-wide (scroll, slides, transforms — see *Motion — Gentle Is the Default*). Widen that line in the brief so doc and build agree.
- **Section striping is order-dependent (noted Sep 2026, not fixed).** `.menu-section:nth-of-type(even)` picks `--surface` by position. The jump-nav's three sibling `<div>`s in `<main>` already flipped it once (caught: Breakfast went Parchment; `nth-child` → `nth-of-type` fixed that). It will flip again if any `<section>` is inserted among the menu sections — the seasonal rail before the menu sections is the live case; check parity whenever the page order changes. Proper fix: a per-section modifier class or striping computed once in PHP, so the ground is declared, not positional. Deal/add-ons rugged edges follow `--section-bg`, so they survive a flip either way.
- **Desktop-visible side effects of the mobile pass (Sep 2026), all deliberate and recorded in the brief:** reserve drawer messenger links draw ↗ (was →); drawer status line `--text-muted` (Mushroom by night, was Ash); bar/kitchen preview title Lemon by night (was Chili); preview caption label untilted and re-synced to the `pill` component; About-preview stat labels Golos 400 (was 500); footer social row VK first; `--lime-light` token; reserve drawer is a real dialog (`inert`, focus, Escape). Every other change sits inside `@media (max-width: 767px)`.
- **Inline SVG ids:** ~~`contact-item.php`, `front-page.php`~~ — converted Sep 2026 along with `visit/hero.php`, `visit/location.php` and `contact-form.php` (23 raw echoes). `dish-row.php`, `highlight-card.php`, `menu-hero.php`, `header.php` and the menu sections still inline with raw `file_get_contents` (duplicate ids are in the DOM today and happen to render). Move them over as touched. **Also watch the hoisted-variable form:** calling the helper once and echoing the result in a loop defeats it — every copy carries the same suffixed id. Call it per instance (the Visit landmark badges and map chips were fixed this way).
- Contact form is client-side only — no WordPress backend (no `wp_mail()` or AJAX handler yet). Not rendered on phones on the home page (the mobile Contacts frame dropped it); still rendered on desktop and on the Visit page.
- Image `about-preview.jpg` returns 404 (referenced in About section, not yet synced).
- Dish data in bar/kitchen previews is hardcoded — needs WordPress editability (ACF Repeater or CPT).
- Events section uses hardcoded placeholder cards — needs News CPT (Phase 2) and VK importer (Phase 3).
- VK API token exists (community ID 64582467) — store in `wp-config.php`, never in Git. Phase 3 work.
- ~~Menu anchor scrolls land short~~ — fixed 2026-09-10: hero-nav and jump-nav `scrollIntoView` could stop ~250px above the target because the lazy-loaded connector SVGs had no reserved height (0px until fetched, so the page grew as they loaded). Fix: `<img>` width/height from the SVG viewBox via `inc/svg-dimensions.php`. Verified in headless Chrome with cache disabled: connector heights at DOMContentLoaded equal loaded heights; `#soups` and `#desserts` land at top = 0 via instant jump and smooth scroll. Rule recorded in `website-brief.md` → Section connectors.
- ~~Fonts return 404~~ — fixed 2026-09-10: cause was Vite's default root-relative asset base; see Build row. Chrome masked it by falling back to the Molot/Golos copies installed on the dev Mac; Safari (and every visitor without the fonts installed) showed sans-serif. Always check fonts in Safari or a browser without them installed.
- About hero headline: ACF value on the local site says "SHAKE & COOK SINCE 2018" while the ACF default, the hero fallback and the footer stamp say 2014. Settle the year and update the field.
- The Pepper Story: counter numbers differ between the template (22 200 / 56 340) and the Figma frame (41 200 / 96 700) — confirm the kitchen-approved set. The pool holds only the three shown, so rotation never runs until more are added. Outlined Molot at 18 px is thin — check on the live page, raise the stroke to 1.25 px if it reads weak. Milestone hover is pointer-only (markers aren't focusable; nothing essential is revealed). Mobile layout (Figma: segmented year control + ticket-style ledger) not built.
- Visit page mobile (spotted Sep 2026, not fixed): in the hours card's Next Up row the event name and the time both have `white-space: nowrap`, so they collide below ~400px; the band lead ("Still can get it!") wraps one word per line and bleeds out of the 44px Lime band. Check both against the Figma mobile variant before the mobile pass.
- **Visit route maps — open (Sep 2026):** the closest-parking badge has no map yet (several car parks; embedding approach undecided), the bus-stop badge's "250 m · 4 min" is **computed from coordinates, not measured** (read the real figure off that badge's own route layer), and all six maps should share one saved view or the embed jumps between taps. RU guests get the Yandex widget, where the badges do nothing — a per-landmark Yandex route widget needs landmark coordinates.
- **Two success glyphs for one action (Sep 2026):** the address chips confirm a copy with the checkmark, `contact-item`'s chip with the fire glyph; both appear in one view on the Visit page. Pick one.
- **One street, two spellings (Sep 2026):** Znamenskaya's badge hint reads "towards Pervomaiskaya", the bus-stop badge "Pervomayskaya" (Google's transliteration). Settle one.
- **Form subtitle promises an SLA nobody agreed to (Sep 2026):** the build's desktop line and the Figma mobile line both say "within 24 hours"; `visit-page-copy.md` specs the descriptive "A person reads this — usually same day." Neither surface is right yet.
- How It Feels: word/quote data is hard-coded in the template (16 words, 20 quotes) — the `inc/how-it-feels.php` + JSON + ACF split from `website-brief.md` is not built. Cloud tier sizes are 56/36/24 in the build vs 64/40/26 in the copy doc (documented as open there). The field cloud is desktop-only (rows below 768 px); the mobile treatment of the whole section is unspecified. Quote card footnotes are in the PHP data but not rendered (deferred until handwritten responses are ready).

---

## Next Up

### Next session — recorded 20 September 2026 (replaces the 19 Sep list)
0. ~~**Menu storage — test with the team, then decide.**~~ **Decided 23 Sep 2026: Б, whole menu seeded, two lists** — entry at the top. **RU food-menu connectors:** on `/menu/` since 23 Sep, all but the hero (entry at the top). Hero: an outlined re-export (day, night, reflection) as `кухняОтПерцев.svg`, then one map line. Russian for the menu picker's heading and subtitle. **About story ¶1:** fix the EN twin's facts (ул. Свободы → Кирова), then a field-update file for SCF. Next: first look at «Блюда» / «Напитки» / «Разделы меню» in admin; review the drafted Russian and the RU findings list; the section-level copy (headline, eyebrow, deal card, hero pill) still typed in English in the templates; then the pairings' dish / drink dropdowns (the brief → *Picker pairings* → "When the menu migrates"). *(The stuck-rail tremble: fixed and confirmed on the phones, 21 Sep.)*
1. **Decide on the device, then clean up.** (a) Night bento headline: **Lemon (on trial) or Cream (fallback)** — if Lemon stays, move the Now pip to Lime at night or retire the pip rule; either way remove the "on trial" wording from `hero.css`, the brief and this file. (b) ~~Menu rail entrance + nudge on the iPhone~~ — tuned and approved by the author on the phone, 21 Sep (fires on crossing 66%, nudge every 2.5 s). (c) Hero air on the iPad Air / mini in landscape: 32px floor, tiles down to 168 — or a 24px floor with larger tiles. (d) Nav drawer descriptions at 360 (About and Menu still take two lines).
2. **Bar Settings.** On the test site: SCF → *Sync available* for "Часы работы бара"; walk a manager through it (`testing.md` → open row). **Build the holiday exceptions repeater before December** — spec in `website-brief.md` → Platform → *Bar hours settings*; first public holiday 4 November. Confirm the Fri/Sat closing time with Iurii.
3. **Closed state leftovers:** RU copy (drafts in the brief → Closed lines), the Figma `Closed` state, the GOOD NIGHT, YAROSLAVL window if a night ever ends after 04:00.
4. **Final copy review list so far:** drawer descriptions (one line at 360), a shorter "YOU'RE UP BEFORE THE BAR!", the RU breakfast line's double «с», SANDWICHES / SANDWICHES (rail word over the first subsection), Visit's "SUNDAY SCRUB" vs the hero's "Sunday polish".
5. **Figma re-syncs from today:** rail 46 → 54; What's new chip (32) and language switch (36) equal; night bento headline; bento row gap 20.
6. **Missing component states** — sweep the other components for states that were never drawn or built; list them before building any. *(The home hero closed state is done.)*
7. **Test site, remaining setup:** seed the menu (`cd ~/repository-test && WP_ROOT=~/SweetPepper-test/public_html php tools/menu-seed.php all`, after SCF *Sync available*), remove the dead theme link, delete the four installer plugins, SCF *Sync available* + re-enter field values, permalinks → Post name, **basic auth + discourage search engines before the URL is shared** (the site is public until then), Editor accounts for testers.
8. **Main site deploy: manual** (decided 19 Sep) — same pull + rsync route from `~/repository` on `main`, by a script run on purpose, never from the cron. Nothing to build until launch.

### Menu Page (complete — hero + food + bar + pairing station + location)
1. **Food menu sections** — ✓ done (Sep 2026). All 9 food menu sections built (Breakfast, Lunch, Bar Snacks, Salads, Sandwiches, Soups, Hot Dishes, Desserts, Kids). Each section follows a consistent layout: 4:1 hero image (bottom-only 12px radius, `--img-pos` CSS custom property for per-image focal point control), title row (eyebrow + headline + optional deal), two-column dish layout with subsection headers, optional addons card, and SVG link word separator. Sections alternate `--bg`/`--surface` backgrounds via `:nth-of-type(even)` (exposed as `--section-bg`; order-dependent — see Known Issues). Breakfast is inline in `page-menu.php`; the other 8 are separate template parts in `template-parts/menu-sections/`.
2. **Night mode** — ✓ done (Sep 2026). Full night support for menu sections: subsection titles → paprika, eyebrow → cream, dish rows inherit semantic token overrides, deal/addons cards pin text to dark colors on cream bg. Hero, highlights, and all section variants render correctly in both themes.
3. **Bar menu page** — ✓ done (Sep 2026). DRINKS hero variant + 7 bar section templates in `template-parts/menu-sections/bar/` (Infusions, Cocktails, Wine, Beer, Spirits, No Buzz, Tea & Coffee). Single `page-menu.php` with `if/else` on `$menu_state` (`?menu=drinks`). Always dark. Bar link word SVGs in `assets/sectionLinks/menu/bar/` (single set, no day/night variants). Tea & Coffee uses a special two-part layout with dashed olive divider between coffee and tea subsections.
4. **Pairing Station** — ✓ done (Sep 2026). "Find Your Match!" interactive section at the food→bar seam. Reusable `dish-picker.php` component: tag pills, "Shake It!" random pick, photo pair, ticket card (reserve-drawer pattern). Two variants: `pairing-station.php` (food→drink) and `pairing-station-bar.php` (drink→food, swapped data). Night mode: title→lime, card bg→cream, bottom-edge→cream `!important`, subheading→parchment.
5. **Location Section** — ✓ done (Sep 2026). "Find the Pepper" — entrance photo (4:1, `sweet-space/door-entrance.jpg`) + split layout (copy left, interactive map right). Map provider geo-detected: Russian locale (timezone/language) → Yandex Maps; everyone else → Google Maps (custom "My Maps" embed `mid=1yEPiD45iDKxBcyhGVZagMvjYmjBl7NY`). No API keys. Both entrance + location share `--paper` bg (day) / `--soft-peppercorn` (night). Placed after `endif` — shared by food and bar menus.
6. **Image focal points** — on the section-head bands (`.menu-section__hero`) the knob is **`--img-y`** (and `--img-x`): `reveal.css` rebuilds their `object-position` from those plus the scroll drift, so a `--img-pos` set there is overridden wherever the drift runs. `--img-pos` still works on `.menu-entrance-img__inner`. Unset everywhere — needs a per-image pass. **Author, 23 Sep 2026:** do it as an admin control (a *Фото* field + vertical slider on each «Разделы меню» record) after the section content moves there — `website-brief.md` → Platform → *Media topics*.

### Desktop pages (breadth-first)
1. **About page** — in progress (Sep 2026): all 11 sections scaffolded in `page-about.php`; **How It Feels built with the Field cloud** and **The Pepper Story built with the heat-line timeline (option B)** (see sections above). Remaining: real data plumbing for words/quotes, the perks/team copy passes, the counter numbers decision, and the sizes decision.
2. **Visit page** — desktop and phones built (Sep 2026): all three sections, section connectors at both seams, Getting here rebuilt with the landmark badge column and route-switching map. Remaining: the parking route map, RU route switching, and the form backend. Earlier scaffolding note kept below. Page template + hero scaffolded in `page-visit.php`. Hero section refined: heroMessage + statesContainer band + heroSplit (hours card + contacts card). State engine (`visit-hero.js`) drives bar/kitchen state pills on the band. Hours card uses the rugged "ticket" pattern. Contacts card done. Remaining: contactsContainer interaction refinement, Location section (map), CTA section, responsive.

### Mobile breakpoint (depth-first)
1. **Home mobile** — ✓ complete (Sep 2026): header, drawer, hero bento, reserve bottom sheet, Highlights + Events as snap rails, menu previews + About preview stacked, Contacts with the inline booking block + directions band + Visit pointer (form dropped on phones), footer two-column. Open items live in `website-brief.md` under each *Mobile — …* section. ~~Next: Menu page mobile, then About and Visit; tablet pass~~ — all done Sep 2026. **Next phase: ACF (SCF) extraction of the About page** — `website-brief.md` → Content editing → Order. (Was: hero bento (colour stack kept on mobile), highlights + events as horizontal card rails, menu preview / about stack, contacts with the inline reserve block + directions block, footer two-column.

### Shared / Backend
1. **Contact form backend** — wire form submission to `wp_mail()` via AJAX, add nonce + honeypot spam protection.
2. WordPress editability for dish rows — SCF (replaces ACF, 18 Sep 2026). **Decided 23 Sep 2026: the hybrid (Б) — `dish` / `drink` posts placed by `menu_list` Relationship lists; all sections migrated** (entry at the top; `website-brief.md` → *Menu storage*). The list below is the history of the repeater store (А), removed the same day:
   - `inc/menu-data.php` — `sweet_pepper_menu_subsections( $slug )` returns subsections → dish-row args in one language; falls back to the typed rows in `data/menu/<slug>.php` while the admin record is missing or empty. Also fills a random stable `dish_id` per row on save (not from the name — Soups has two "Pumpkin soup" rows, and two «Грибная кружка» in RU).
   - `template-parts/components/menu-section-columns.php` — the two-column loop (subsection `style` = list, or card for add-ons like Favorite Sauces). `soups.php` calls it; `dish-row.php` untouched. Rendered Soups markup verified identical before / fallback / from the database.
   - `menu_section` post type (`inc/cpt.php`) — one record per section, slug = section slug; not public; revisions on; only an admin can add one. A post, not an options page: revisions, edit lock, cache purge on save.
   - `acf-json/group_sp_menu_section.json` — generated by `tools/menu-field-group.py` (fixed `field_sp_menu_*` keys; re-run after editing the script); Russian labels; nested repeater subsections → dishes. Per dish: name RU/EN + hide toggle; size 1 and optional size 2 (amount number, unit dropdown г/мл/л/шт, price number); description RU/EN; then an accordion with icons (checkbox, max 2 — leaf = vegetarian, fire = hit, pepper = spicy, Yaroslavl = local dish — validated in `inc/menu-data.php`), highlight, seasonal RU/EN, options RU/EN (one per line). `sweet_pepper_menu_format_sizes()` builds the strings dish-row prints: `260-. / 420-.`, `350 g / 0.5 L` (RU: `350 г / 0,5 л`).
   - Form layout rule: no notes inside the row grid (they misalign the columns) — the price input carries a `-.` suffix, hints are placeholders, the drag/hide explanation is one message above the repeater, `instruction_placement: field`. **Never press Update on a form opened before a field-shape change** — a stale form saved blank sizes over Soups once (18 Sep); re-seeded.
   - `tools/menu-seed.php <slug>` — seeds a record from `data/menu/<slug>.php` through Local's PHP + MySQL socket (no `wp` on PATH); parses typed prices and quantities into sizes (tolerates the two malformed prices and `2 / 4 pcs`); skips a section that already has rows unless `--force`, which wipes the record's rows and re-issues dish ids. Soups seeded locally (post 21).
   - **Store B built for Soups, 20 Sep 2026** — `dish` posts + `menu_list` Relationship lists: `inc/menu-data-dishes.php`, `acf-json/group_sp_dish.json` + `group_sp_menu_list.json` (same generator), `tools/menu-seed.php <slug> --dishes`, page at `?menu_store=dishes`. Detail and what each outcome deletes: *Menu storage — the dishes store*, top of this file.
   - Not built yet: ~~hybrid store B for the comparison;~~ ~~the other 14 sections~~ (done 23 Sep); dish photo field; the reference dropdown for highlights / previews / picker; section-level content (hero photo, pill, eyebrow, deal card).
3. News CPT + manual card entry (Phase 2 of social feed plan).
4. VK `wall.get` importer as WP cron feeding News CPT drafts (Phase 3).
5. Image sync check (`photos/menu-website/` → `sweet-pepper-theme/assets/images/`).
