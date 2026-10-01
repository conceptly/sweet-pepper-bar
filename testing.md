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
| **The footer replay as a toy** | **Open — on by default since 1 Oct (layout 3, the author's pick so far); `?egg=1` and `?egg=2` show the other two for the browser tab, `?egg=0` the plain replay, `?egg=auto` lets go** (`page-loader.js`). A participant opened the loader from the footer, called it "like an Easter egg" and tried to drag the knob. **Common to both:** the show plays as before but stays on «Подано!»; the controls come in then — or at once if the slider is touched — and the knob nudges left and back every 4 s until the slider is touched. The knob drags at any time (or tap the track; ← →); every new daypart brings a new line; the end serves «Подано!». On a touch screen — or in a window up to 767 wide, so it can be checked from a desktop's responsive mode — the footer's «Поддать жару!» takes its heat look 0.8 s after it comes into view (Figma NavItemsFooter → delay-mobile). Real waits between pages are untouched. **`?egg=1`:** a row above the words — the dish picker's Shake It! at the left with its own states (hover 52, pressed with the inset, the night glow; it starts the show over with other lines), × at the row's right end on desktops and tablets, in the top corner on phones; × is a 48px disc that tints on hover and sinks when pressed. **`?egg=2`** (wide screens; upright ones keep the row): the author's Figma frame 2792:75652 — «Назад» / Go back (secondary) and «Встряхнуть!» / Shake it! (Lime) under the name, and the label turns to «Выбирай огонёк!» / Pick your heat! once the guest plays (RU drafts mine). **Layout 3, the default** (wide screens at least 560 tall; the rest keep the row): the author's second frame, 2792:75651 — a shaker centred above the slider (a 64px disc on every screen: the frame's 84 is the name's own cap height and took the eye from the slider; the picker's 40 "felt dead" on a phone), one button under the name, «Вернуться на сайт» / Back to the website, and × in the top corner; the same invite label. Built as drawn where it departs from the system: the disc is Lemon by night (the dish picker's night disc is Cream with a Lemon keyline) and × is Parchment. **The author's concern:** the way back on desktops and tablets — a cross in the top corner is a phone-and-drawer habit. **To find out:** which of the three gets guests back without the browser's Back; with the big shaker, do guests still try the knob or only press the shaker; is the nudge enough to discover the drag; is the shaker read as "again"; does the heated footer item get tapped more. **Still on the table (author's notes):** a hidden button fixed to a screen edge that slides in and hides on a delay — weighed against the point that a button, even a hidden one, stops it being an Easter egg; a mini game; a "you found it" message or a reward to share. |
| The line beside the flame | **Watch:** in that screenshot the line is empty. Most likely caught between two lines (the swap takes ~0.2 s); if it stays empty on a device it is a bug. |

**Links** — open one, scroll to the footer, tap «Поддать жару!» (the full run, as in the films). English: the same with `/en/` before the `?`. Main site: `sweetpepper.bar` in place of `test.sweetpepper.bar`.

- `https://test.sweetpepper.bar/?pick=auto` — the defaults (phones upright d · tablets upright b · everything on its side or wider than 1100 a)
- `https://test.sweetpepper.bar/?pick=a` · `?pick=b` · `?pick=c` · `?pick=d` · `?pick=e` · `?pick=f`
- Held open at 50% to study the layout (Esc closes it; on a phone or tablet only Back does): `https://test.sweetpepper.bar/?loader=stay&p=0.5&pick=d` (any letter)

---

## Open — planned, not yet run

| Question | Affects | Plan | Prediction on record |
|---|---|---|---|
| Event cards — could the VK caption run to two lines without breaking the hover layer? | Home → «Что нового», `events.css` → Title | The author's own ideas on `/?title-lines=2` (kept for this); the hover stack (title rises, «Смотреть во ВКонтакте» rises in under it) is the constraint — two lines push it above the 98px band. | One line stays unless the hover layer gets its own treatment (a taller body on hover, or the CTA replacing the date instead of stacking). |
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
