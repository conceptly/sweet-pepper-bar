# Sweet Pepper — Testing & Validation Log

*Working doc · tracks usability/A-B testing across the project — both what's been run and what's still queued. Full design rationale stays where the decision lives (`design.md`, `website-brief.md`, the case study); this doc is the index so a test doesn't get stranded inside whatever section prompted it.*

**When a new "should we test X" moment comes up mid-decision:** log it below first, then reference it inline (`*(open test — see testing.md)*`) instead of writing the plan into the surrounding section.

---

## VK home feed — connection evidence and pending integration checks (24 September 2026)

Plan: `website-brief.md` → *News/social feed*. RU automatic VK previews; EN manual and independent. No importer built yet.

| Check | Status / evidence |
|---|---|
| Local API access | Passed: service key, `wall.get` 5.199, community 64582467, owner filter, ten returned posts. Nine had photos and text; one had neither. |
| Timeweb PHP API access | Passed with the earlier key: author's SSH-console screenshot shows `SUCCESS: received 10 posts from VK.` |
| Replacement credential | Passed locally with ten posts; the exposed first key revoked (author, 25 Sep). **In the main site's `wp-config.php` (counted 26 Sep, never printed).** The test site's line not shown yet. Never include key values in evidence. |
| Image download and card preview | **Passed (live wall, 25 Sep):** 8 real covers downloaded from VK's CDN through `media_handle_sideload`, the 4:5 size (720×900) served, one attachment per photo id; a changed photo replaces the cover (fixture). **Pending:** the author's look at five real cards (multi-photo cover = the first photo, crop, caption cuts, the month abbreviation on `/`). |
| Repeat imports and source edits | **Passed (fixture, 25 Sep):** re-run → 3 unchanged, no new records or media; an edited post → 1 updated; a caption retyped by hand survived the edit; a hidden record left the cards. Repeat on the test site with the live wall. |
| Filtering and source deletions | **Passed (fixture, 25 Sep):** repost, wordless and photo-less posts skipped before the five are chosen; a post gone from the wall → marked, Draft on the second successful miss, back to publish when it returned. A failed request marks nothing (it never reaches that step). Repeat on the test site. |
| API/image failure | **Built, not yet provoked:** a failed or key-less request writes nothing and records `sp_vk_last_error`; the page keeps the records; the status line above «Посты ВКонтакте» shows the last success and the error without secrets; a failed photo download leaves the record without a hash so the next run retries it. Provoke on the test site (a wrong key, briefly). |
| Language isolation | **Built:** `/en/` reads the tab's rows and never the feed; `/` reads the feed and falls back to the rows only before the first import. **Pending:** eyes on both pages after the first live run. |
| Scheduling and caching | **Set up 26 Sep:** `DISABLE_WP_CRON` in the main site's `wp-config.php`; two Timeweb cron tasks (PHP 8.2, hourly) on each site's `wp-cron.php`. **Confirmed by the author (30 Sep 2026): the VK feed has been updating by itself over the last 2–3 days (checked twice)** — the hourly Timeweb task runs WordPress's jobs, so the vacancy sweep and WP Super Cache's garbage collection ride it too (the plugin's «CRON отключен» notice only sees `DISABLE_WP_CRON` and is to be ignored). *Was pending:* the first run with no page visits on either site — the status line under «Посты ВКонтакте» an hour after the task's start; no duplicate events (`wp_next_scheduled` guard); WP Super Cache purged after a change (built, untested — no page cache installed as far as known). |

---

## Vacancies — the term, the archive, the contacts (25 September 2026)

Plan: `website-brief.md` → Content editing → *Vacancies*. Built and CLI-tested locally; the admin screens and the hosting cron are pending.

| Check | Status / evidence |
|---|---|
| Term rules | **Passed (CLI, 25 Sep):** same term re-saved → dates unchanged; 2 → 4 weeks → counted again from today; «В архиве» → closed now, `until` 0; a term on an archived record → open again, `closed` 0. |
| Sweep | **Passed (CLI):** a posting with a past date was closed at render time before the sweep, and flipped to «В архиве» by `sweet_pepper_vacancy_sweep()` (1 closed, `closed` = its date). Event scheduled daily. **Pending on hosting:** the system cron on `wp-cron.php` (the VK feed's), a posting left to expire, the page cache purged. |
| The About list | **Passed:** three records → three cards linking to their pages; one closed → two; the row wraps at four. **28 Sep, four states (Figma 1970:123894):** 3 / 2 / 1 / 0 open roles at 1440 · 834 · 402, RU and EN — the CV card fills the free columns, the row only under a full row, no overflow (roles opened and archived from the CLI as a save would, then put back). |
| Templates | **Seeded locally (28 Sep):** Официант posted 4 weeks, Бармен and Повар-универсал in the archive, the three placeholders in the trash; the waiter / bartender posters on `/` only. **Pending:** the team republishing a template from admin (pick a term → «Обновить») and changing pay / schedule; SCF → *Sync* for the new «Фото» field on both sites. |
| Closed page | **Passed:** `/en/vacancies/cleaner/` kept its URL, printed the "filled" line and the two open roles, `noindex`; JobPosting JSON-LD only while open. |
| Contacts | **Passed:** the bar's channels from Bar Settings (seeded), a person from the list with the bar as second block (a test row, removed), a pick whose row is gone → the bar. **Pending:** the admin form — the «Контакт» dropdown listing the people, the note under «На сайте», the Открытые / Архив views (no login from the CLI). |
| Languages | **Passed:** `/` and `/en/` at 1440 / 834 / 402, Russian strings for the page's own labels; the card's Message / DM / Write follow the Visit card's open decision. |
| Slug | **Passed:** «Менеджер зала» + "Floor manager" → `floor-manager`. **Pending:** a record saved with no English title (→ `role-<id>`), and the team typing a Russian title first and the English later (the slug is set on the first save with a Latin result). |

---

## Page loader — the name's look on phones, tablets and desktops (1 October 2026)

Plan and rules: `website-brief.md` → Motion language → *Page loader* → *On trial*. Six looks live behind `?pick=a…f` (`?pick=auto` lets go; the pick holds for the browser tab). Films of the four phone options: `Claude outputs/page-loader-videos/` (RU and EN).

| Look | Name | Fill |
|---|---|---|
| a | SWEET PEPPER | every line under the knob |
| b | SWEET PEPPER | a word at a time |
| c | poster — SWEET / PEPPER / BAR | under the knob |
| d | poster | a word at a time |
| e | SWEET PEPPER BAR in one row (wide screens; the poster on a phone) | under the knob |
| f | the same row | a word at a time |

| Check | Status / evidence |
|---|---|
| Phones — which of a–d | **3 of 3 testers picked d from the films** (author, 1 Oct). **On the real site, same day: d again** — "just feels more balanced"; the owner picked it at once, twice, from pairs of films (against a two-line option, then against c). d stays the phone's default. Testing continues. |
| Phones — the bottom edge | **Pending (never checked — headless Chrome only):** does Safari's toolbar or the home indicator cover the last line? |
| Desktop — placement | **Decided:** the group in the middle, not on the bottom edge (author + one guest, local site, 1 Oct). |
| Desktop — BAR or not | **a, the default, after the first day (1 Oct):** participants called the three-word looks too long. The author's observation: the speed is the same — with three words they *expected* a longer wait. The prototypes (c–f) stay behind `?pick=` while testing continues. |
| Tablets — SWEET PEPPER or the poster | **First day (1 Oct), iPad mini and 11-inch iPad Air: a, or the two fitted lines from the iPad mini screenshot — not the poster.** The author's lean (their own, "biased"): upright, the two fitted lines look more balanced. **Pending: the 13-inch iPad Pro.** A screen recording proved a limited way to test, so the two-line look is now the upright tablets' default (next row) — easier to judge on the big iPads and by resizing a browser. |
| Tablets held upright — the two fitted lines | **Built as the default, 1 Oct (author):** every upright screen up to 1100 wide takes the stacked layout on the bottom edge — phones d, tablets from 600 **b** (SWEET / PEPPER, a word at a time: 166 / 138px letters on the mini, 185 / 154 on the 11-inch Air, 228 / 190 on the 13-inch Pro). On its side a tablet takes the centred row, a. *How it came:* the author's "I like the sweet pepper version in tablets (word by word)" was said of an iPad mini upright on the build before `fb4f46b`, where the phone layout reached 767; I read it as the centred row and ended the phone layout at 599, which took the look off that iPad. **Pending:** the 13-inch Pro; `?pick=a` (both lines under the knob) against b; whether the poster (`?pick=d`, BAR 295px on the Air) needs a cap if it stays in the running. |
| The breakpoints, after more testers | **Holding (author):** each screen's default reads as its most balanced option. A participant on the phone picked the three-word poster "because I prefer to see something in the middle of the page, and two words make me think that I need to scroll to the end" — the author's own feeling, put into words. The upright iPad is the same story from the other side: two words put the slider near the middle, three push it high and take all the attention. Few participants own an iPad, so the tablet call rests mostly on the author's observation. |
| **The footer replay as a toy** | **Open — on by default since 1 Oct (layout 3, the author's pick so far); `?egg=1` and `?egg=2` show the other two for the browser tab, `?egg=0` the plain replay, `?egg=auto` lets go** (`page-loader.js`). A participant opened the loader from the footer, called it "like an Easter egg" and tried to drag the knob. **Common to both:** the show plays (at the replay's own pace since 1 Oct — the next row) and stays on «Подано!»; the × is there from the start, the shaker and the wide screens' button come in then — or at once if the slider is touched — and the knob nudges left and back every 4 s until the slider is touched. **On a touch screen the shaker beats 1.3 s after each nudge — the dish picker's idle beat (swell, rattle, glow by night) — until the first shake; a touch on the slider quiets it for 8 s (built later on 1 Oct; to judge on a phone: do two hints in turn read as "drag, or shake", or as too much?). The × comes in and tints on Gentle; its press answers in 100 ms.** The knob drags at any time (or tap the track; ← →); every new daypart brings a new line; the end serves «Подано!». On a touch screen — or in a window up to 767 wide, so it can be checked from a desktop's responsive mode — the footer's «Поддать жару!» heats and cools on and off while it is in view — 0.8 s change, 0.8 s rest (Figma NavItemsFooter → delay-mobile; it heated once and stopped before 1 Oct 2026 — check it keeps going on a phone). Real waits between pages are untouched. **`?egg=1`:** a row above the words — the dish picker's Shake It! at the left with its own states (hover 52, pressed with the inset, the night glow; it starts the show over with other lines), × at the row's right end on desktops and tablets, in the top corner on phones; × is a 48px disc that tints on hover and sinks when pressed. **`?egg=2`** (wide screens; upright ones keep the row): the author's Figma frame 2792:75652 — «Назад» / Go back (secondary) and «Встряхнуть!» / Shake it! (Lime) under the name, and the label turns to «Выбирай огонёк!» / Pick your heat! once the guest plays (RU drafts mine). **Layout 3, the default** (wide screens at least 560 tall; the rest keep the row): the author's second frame, 2792:75651 — a shaker centred above the slider (a 64px disc on every screen: the frame's 84 is the name's own cap height and took the eye from the slider; the picker's 40 "felt dead" on a phone), one button under the name, «Вернуться на сайт» / Back to the website, and × in the top corner; the same invite label. Built as drawn where it departs from the system: the disc is Lemon by night (the dish picker's night disc is Cream with a Lemon keyline) and × is Parchment. **The author's concern:** the way back on desktops and tablets — a cross in the top corner is a phone-and-drawer habit. **To find out:** which of the three gets guests back without the browser's Back; with the big shaker, do guests still try the knob or only press the shaker; is the nudge enough to discover the drag; is the shaker read as "again"; does the heated footer item get tapped more. **Still on the table (author's notes):** a hidden button fixed to a screen edge that slides in and hides on a delay — weighed against the point that a button, even a hidden one, stops it being an Easter egg; a mini game; a "you found it" message or a reward to share. |
| **The replay's pace** | **Decided, 1 Oct (author: "Let's keep the auto, please, it feels better").** The replay "feels too slow, especially on mobile" — measured: «Подано!» and the controls at 7.0 s, half the track at 2.45 s, the knob down to a ninth of its speed; the Figma prototype ends at 3.1 s. **Built and kept:** the end at 3.3 s, a line every 1.2 s, the × on screen from the start. Three others were tried behind `?pace=` and deleted with the switch: the old pace, the prototype's timing, the whole track in one spring. **Watch on phones:** are the long lines readable in 1.2 s? |
| **The lines in admin — «Пасхалка»** | **Open (built 1 Oct; the admin screen not seen by Claude — it needs a login):** the record opens with 16 filled rows; a row drags; a new line shows on the site after «Обновить» (footer → «Поддать жару!», shake until it comes); a 35-character Russian line is refused with the message; «Скрыть» takes a line off; an Editor (not only an admin) can save. Then the same on the test site and the main site after their sync + seed. |
| The line beside the flame | **Watch:** in that screenshot the line is empty. Most likely caught between two lines (the swap takes ~0.2 s); if it stays empty on a device it is a bug. |

**Links** — open one, scroll to the footer, tap «Поддать жару!» (the full run, as in the films). English: the same with `/en/` before the `?`. Main site: `sweetpepper.bar` in place of `test.sweetpepper.bar`.

- `https://test.sweetpepper.bar/?pick=auto` — the defaults (phones upright d · tablets upright b · everything on its side or wider than 1100 a)
- `https://test.sweetpepper.bar/?pick=a` · `?pick=b` · `?pick=c` · `?pick=d` · `?pick=e` · `?pick=f`
- Held open at 50% to study the layout (Esc closes it; on a phone or tablet only Back does): `https://test.sweetpepper.bar/?loader=stay&p=0.5&pick=d` (any letter)

---

## 404 page — three layouts on trial (1 October 2026)

Build record: `report.md` → *404 page*; rules and open points: `website-brief.md` → *404 page — on trial*. Any address that doesn't exist shows it; `?nf=` picks the layout (not `?pick=` — that one is the page loader's).

| Layout | RU | EN |
|---|---|---|
| 0 — the Figma draft | `http://sweet-pepper-bar.local/nothing/` | `http://sweet-pepper-bar.local/en/nothing/` |
| a — the ticket | `…/nothing/?nf=a` | `…/en/nothing/?nf=a` |
| b — the number in the footer | `…/nothing/?nf=b` | `…/en/nothing/?nf=b` |
| bt — b with the ticket | `…/nothing/?nf=bt` | `…/en/nothing/?nf=bt` |

| Question | Result |
|---|---|
| Layout 0 — the notice line above or under the number | **Under (author, 1 Oct, in the browser):** above, it argued with the top nav. Built; the Figma frame follows |
| Which layout | Open — **the author is between 0 and b (1 Oct, evening):** b "has a better hierarchy, especially on mobile" |
| Layout b — the Chili level rising in the digits | Open — Claude's suggestion; plain outlines are the alternative |
| Layout b — the number against the copy | **Fixed, 1 Oct (author, in the inspector: "there is no 48px gap", then on the Russian page "it looks even negative"):** 48px from the copy column in both languages, 52–54 from the widest line seen; the column is typed per language (400 EN, 480 RU), so the Russian number is smaller (323 against 366 at 1280 and up). Owed: retune when the Russian headline changes |
| Layout b — how deep the number stands in the footer | **0.1em (author, 1 Oct: "let's use 0.1em")**, was 0.16; the author's own try was 0.04. The glyphs decide — at 0.16 / 0.13 a stroke lies on the Lime edge, under 0.08 the 0 is cut through its curve. Sheet: `Claude outputs/nf-sink/`. To judge on a phone: the 4's bar is ~6px above the Lime there |
| Layout 0 on phones — "very messy" (author, 1 Oct, iPhone) | **Rebuilt to the Figma mobile frame** (2827:79374): smaller digits, the gaps above and under them as drawn, balanced copy. Owed: the author's look on a real phone |
| Layout 0 — the digits as an idle loop or on hover | Open — built as a 6 s idle loop (an assumption) |
| The footer's «Наверх» / Back to top on the 404 | **Gone (author, 1 Oct):** "it doesn't make sense … on a page without scroll" — neither link is printed on any 404 layout; other pages keep them |
| Always dark | Open — assumed |
| The copy, both languages | Open — drafts in `data/not-found.php` |

Seen in headless Chrome (402 to 1920 wide) and, layout b before these fixes, on the author's iPhone on sweetpepper.bar (1 Oct). Owed: Safari on a desktop, reduced motion, a phone look at the new depth.

---

## Team wall lightbox — built (1 October 2026)

Build record: `report.md` → *Team wall lightbox* (built, and the prototype under it); rules: `website-brief.md` → *Team wall lightbox*. Click a group photo on the About wall: `http://sweet-pepper-bar.local/about/` · `http://sweet-pepper-bar.local/en/about/`. Below 768px wide the lightbox is a column — narrow the window to see it on a computer. The prototype's `?lightbox` switch is gone.

| Question | Result |
|---|---|
| Which direction of the five | **A — the wall, closer (author, 1 Oct, from the contact sheet)** |
| The ground | **Dark, see-through, no blur (author, 1 Oct, in the browser)** — the blurred version was tried and dropped |
| The phone layout | **A column, the open print edge to edge, on the cord (author, 1 Oct, in the browser)** — prints 16px in, and no cord, were tried and dropped |
| The cursor on the prints | **The hand (author, 1 Oct)** — the pepper cursor was built first |
| The opening | **The print flies from the strip (author, 1 Oct)** — settling in the middle was tried and dropped |
| Does 1.7× on a phone show the faces | Open — a real phone; a sideways pan at 3.3× was the alternative on the first sheet |
| Photo sharpness at 960px | Open — the uploads are 1080 × 720; 1440 or more wanted |

Seen in headless Chrome only (375 to 1440 wide, RU and EN; reduced motion, touch and no-JS emulated). Owed: Safari, a real phone, a screen reader, the test and main sites after the deploy.

---

## Phone menu navigation — the bar or the rail (1 October 2026)

Build record: `report.md` → *Phone menu navigation*; rules and open points: `website-brief.md` → *Mobile — Menu page → Navigation between sections*. Phones and tablets up to 991px wide. The choice is remembered for the visit, so the door to the other menu keeps it; open the other link to switch.

| What | RU | EN |
|---|---|---|
| The default — the bar at the foot of the screen | `http://sweet-pepper-bar.local/menu/food/` · `…/menu/bar/` | `http://sweet-pepper-bar.local/en/menu/food/` · `…/en/menu/bar/` |
| The draft — the sticky rail | `…/menu/food/?nav=rail` | `…/en/menu/food/?nav=rail` |
| Back to the default after the draft | `…/menu/food/?nav=edge` | `…/en/menu/food/?nav=edge` |

| Question | Result |
|---|---|
| Which of the ten on the sheet | **The drawer's sheet peeking — "the sheet's edge" (author, 1 Oct, from the contact sheet)** |
| The drawer — full screen, or a two-column bottom sheet | **Full screen, as it was (author, 1 Oct):** the shorter versions look too dense |
| Which side the opener sits on | **Left, the section word right (author, 1 Oct, in the browser)** — the drawer comes in from that side, and the hero has its opener there |
| The bar or the rail | Open — the bar is the default; the author compares the two on devices |
| Is the bar found without being shown | Open |
| Two taps to another section (bar → word) against the rail's one — does it slow anyone down | Open |
| Does the bar sit clear of Safari's own bottom bar and the home indicator | Open — never checked (headless Chrome only) |
| The bar menu in Russian: the label drops to the kebab alone beside «Без алкоголя» (and «Чай и кофе» on a 360 phone) — noticed? | Open — a shorter label than «Вся барная карта» would remove it |
| First visit: the cookie notice covers the bar until «Понятно» | Open — watch whether anyone looks for the sections before dismissing it |

Seen in headless Chrome only (320 to 1440 wide, RU and EN). Owed: Safari, real phones and a tablet, the test site (not deployed).

---

## Language switch — one thumb (1 October 2026)

Build record: `report.md` → *Language switch — one thumb*; rules: `website-brief.md` → Interaction rule → *Language switch — one thumb*. In the header on a computer, in the drawer on a phone: `http://sweet-pepper-bar.local/` · `http://sweet-pepper-bar.local/en/`. The five ideas it was chosen from: `Claude outputs/lang-switch-ideas/lang-switch-ideas.html`.

| Question | Result |
|---|---|
| Which of the five | **A — one thumb (author, 1 Oct, from the board)** |
| Where it sits in the drawer | **On its own, where it was (author, 1 Oct):** less risk of an accidental tap, hierarchy, proximity — the row inside the venue card was turned down |
| The move carried over the page load | **Passed in headless Chrome** on real navigations (the arriving page picks the thumb up on the same curve). Open on the test site: a real network, Safari |
| The press, 100ms | Open — on a phone: is the outline + inset seen under a thumb, and is 100ms right (25 Sep: a fast press read "too fast") |
| The drawer's tap target, 44px | Open — on a phone |
| «Переключить» in the language nudge starts the same move | Open — written, not exercised |
| Keyboard: Enter on the other code | Open — not exercised |
| The hover outline at the house 0.8s (the board showed 300ms) | Open — the author's eye, on a computer |
| The drawer's day thumb: Parchment on Avocado, 2.76:1 | Open — Olive gives 3.68:1 |

Seen in headless Chrome only (1440 and 402). Owed: an iPhone, Safari, the test site (not deployed).

---

## Event cards — the frosted band (1 October 2026)

Build record: `report.md` → *Event cards — the phone band regrouped*; rule and open point: `website-brief.md` → *Frosted band — on trial*. Home → «Что нового», phones and desktop. The switch is per address — it is not remembered.

| What | RU | EN |
|---|---|---|
| The default — the plain band (phones: regrouped, 70px) | `http://sweet-pepper-bar.local/#events` | `http://sweet-pepper-bar.local/en/#events` |
| The test — the frosted band | `http://sweet-pepper-bar.local/?band=frost#events` | `http://sweet-pepper-bar.local/en/?band=frost#events` |

| Question | Result |
|---|---|
| Phone spacing — does the regrouped band read as balanced? | **Default since 1 Oct (author, from the contact sheet)** — to confirm on a phone |
| Tablet band (768–991): the phone card's body in the 3 × 2 grid | **Built 1 Oct from the author's iPad screenshot** — to confirm on the iPad |
| Landscape iPad (≥ 992, touch): the phone card's body wherever nothing hovers | **Built 1 Oct (author: "I would use the phone body for iPads")** — to confirm on the iPad, on its side, with and without a trackpad |
| Frost or plain, phones | Open |
| Frost or plain, desktop — at rest and on hover (the photo leans in under the band) | Open |
| Does the rail scroll as smoothly with five blurred bands (an older iPhone / Android)? | Open |
| Safari: are the band's bottom corners clean inside the card's radius? | Open |

Seen in headless Chrome only (360, 402, 768, 834, 991, 992 and 1440 wide, RU and EN, day and night; touch emulated at 1024, 1180 and 1366). Owed: Safari, real phones, the test site (not deployed).

---

## Mobile drawer and button hover speed (1 October 2026)

Build record: `report.md` → *Mobile drawer — the header stays*; rules: `website-brief.md` → Mobile — the drawer → *Opening and closing*, Motion language → *Quick*. From a tester's note: hovers and the hamburger menu feel slow against a design that reads fast.

The drawer is the default — any page, the hamburger (phones and tablets up to 991). **The hover trial is closed (1 Oct): the Gentle spring is the site's colour curve, 800ms kept; `?hover=` and `?ease=` are gone.** Tried on the way: 400 / 250 / 150ms on a quick curve, the same on the flat curve, and at 800ms a no-overshoot fit of the spring, expo-out and the spring itself.

| Question | Result |
|---|---|
| Drawer: does the bar hold still, and does the icon read as one thing turning? | Built 1 Oct — to confirm on a phone |
| Drawer: Gentle (the default since later on 1 Oct — 800ms on the spring, half there at ~165ms) or the first build's 200ms in / 150ms out (`…/?drawer=quick`; `…/?drawer=gentle` to go back)? | Open — on a phone |
| Drawer: the × at 17px in the hamburger's colour (the mockup: 12px, Ash) | Open |
| Drawer: content on the 16px page gutter (the mockup: 24px) | Open |
| Hover: which speed and curve? | **The Gentle spring at 800ms, for every colour transition on the site (author, 1 Oct)** — half done at ~150ms, was 281. 250ms: "feels like no easing"; 400ms and the no-overshoot fit set aside |
| Do nav links, text links, chips and cards follow the buttons? | **Yes — everything on the colour token moved with it.** About forty transitions written with their own time and a plain `ease` did not; a sweep is open |
| The ≈60 transitions off the house curves — which match, which keep their own? | **38 matched (author, 1 Oct), 25 kept** — the logo's hover among the kept ("feels better than I have in Figma"); the form fields among the matched. To look at by eye: the home hero tiles' hover, a theme change, the form field's keyline on focus |
| The entrances' fades start faster on the new curve — still right on load? | Open — not judged by eye |
| The same tester, after the change: does it now match the design's energy? | Open |

Seen in headless Chrome only (360, 402, 768 and 1440 wide, RU and EN, day and night). Owed: Safari, real phones, VoiceOver, the test site (not deployed).

---

## Open — planned, not yet run

| Question | Affects | Plan | Prediction on record |
|---|---|---|---|
| Event cards — could the VK caption run to two lines without breaking the hover layer? | Home → «Что нового», `events.css` → Title | The author's own ideas on `/?title-lines=2` (kept for this); the hover stack (title rises, «Смотреть во ВКонтакте» rises in under it) is the constraint — two lines push it above the 98px band. | One line stays unless the hover layer gets its own treatment (a taller body on hover, or the CTA replacing the date instead of stacking). *1 Oct 2026:* the second treatment was mocked on the live page — the link fades in on the date's line, the title stays put, band 98 → 124px (`Claude outputs/event-card-ideas/sheet-desktop.png`, option 2) — and not taken: the author keeps the desktop card ("the hover animation worked well during my testing"). |
| Bar Settings → hours: can a manager change an opening time and read the four fields without help — and does "a time after midnight is the end of the same night" land? | Platform → *Bar hours settings* (`website-brief.md`) | With the **Editor** role on the test site: "on Friday we close at 4 — set it", then "put it back". Watch for the closing-time fields; note any value the sanity fallback had to catch. Run before the holiday repeater is built, so its form learns from it. | The opening fields are fine; the two closing fields are where a slip happens. |
| Drop the "Home" nav label and let the interactive logo alone serve as the home link? | Top nav (`website-brief.md`) | Two measures, separately: (1) home-return success from deep pages, label vs. no label; (2) logo-interaction discovery, label on/off × idle-shake on/off | Idle-shake moves discovery more than removing Home does, at zero nav cost — if it holds, keep both |
| "Bar Snacks" vs. "To Share" vs. "Snacks & Boards" | Menu page → Section labels 🔶 (`website-brief.md`) | Run a "find the cheese plate" task, then decide and propagate in one pass: nav, `menu-hero-copy.md`, `menu-en.md`, RU pairing | — |
| ~~Scroll-down link under the mobile contact card: one bundled line ("Map, city sights & contact form ↓") vs. a directions-only link with the form reached by scrolling~~ **Closed Sep 2026 — the link was dropped when the hero-foot connector landed (a second device announcing the same section); nothing left to test** | Visit page → Mobile layout (`visit-page-copy.md`) | Two variants, same task set: (1) "find the map", (2) "write to the bar about a lost jacket". Watch whether the bundled line's three nouns create an expectation the landing section doesn't meet, and whether variant B's guests still reach the form | Author's prediction on record: the bundled line won't confuse — the page is short and the words run in the same order as the sections below, so it reads as a preview of the rest of the page rather than a single anchor |
| Mobile status rail: running Lime band vs. static one-line band | Visit page → Mobile layout (`visit-page-copy.md`) | Interrupt-style task — show the page mid-loop and ask "can you eat right now?". The failure mode to catch is a guest reading only one of the two states. Fallback copy is already drafted (five one-line states) | Prior evidence points the other way twice (menu hero, ticker jump-nav both lost to static layouts) — so this is a genuine test, not a confirmation |

---

## Decided — validated

| Question | Method | Result | Full rationale |
|---|---|---|---|
| Hero layout: side-nav poster vs. carousel/ticker vs. split-screen | Stakeholder A/B + usability testing, KPI = time-to-dish | Side-nav poster (concept B) won — cleaner, easier to navigate, clearer interactions, less information-heavy | `website-brief.md` → Menu page → Hero; case study "The menu page: tested, not guessed" |
| Soups: own section, or filed under Hot dishes? | Usability task (Jul 2026) | Participants *could* find soups under Hot dishes but agreed it doesn't belong there — kept as its own web section (print still files it under hot dishes; accepted web↔print divergence) | `website-brief.md` → Menu page → Section labels |
| Seasonal: own nav section, or a tag? | Historical print performance (not a live usability test — years of separate seasonal print pieces vs. integrated dishes) | Seasonal is a tag, not a section; surfaced via a "Seasonal now" rail | `website-brief.md` → Seasonal & specials |
| Menu storage: a repeater per section (А) vs. `dish` posts placed by Relationship lists (Б) — which admin screen does the team find easier? | Usability test, two participants, on the test site (Sep 2026); first look 20 Sep (team fine with either, price is the most frequent edit) | **Б, 23 Sep 2026 — both participants.** Harder to mix up dishes in Б's table; they change price / size, sometimes the description, rarely the layout, and would rather search than open a section, scroll and read А's nested repeater (fields without hierarchy). Both said А could work. Prediction on record (repeater wins the batch reprice) was not borne out. Small sample, accepted for a reversible choice; А archived | `website-brief.md` → Content editing → *Menu storage* |
| Spice-slider mechanic: which interaction metaphor | AI-prototyped 6 divergent variants, sorted against brand/hospitality rules (not user-tested — a design-side usability screen) | Kept: the label transition (solid→chili→outline), the now-marker. Rejected on principle: the hour ruler (reintroduces a literal clock). Parked: matchstick gradient (off-palette), status card (undercuts "one control, three jobs"). Proportional real-hours segments flagged as a candidate for next iteration | case study "AI-assisted exploration: six ways to feel the heat" |

---

*Evidence-type note: "usability testing" above means actual participants; the seasonal and slider rows are decisions backed by other evidence (performance data, internal rule-sorting) and are labelled as such rather than dressed up as user tests.*
