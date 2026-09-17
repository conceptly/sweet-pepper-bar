# About — Copy Draft (English-first, per design.md)

> **Author selections, 16 September 2026:** access label inside the circular stamp = **Step-free**; Location = **IN THE VERY HEART OF THE BEST CITY** (RU direction: **«В самом сердце любимого города»**); Careers = **WANT TO JOIN THE FAMILY?**. “Family” is an intentional local joke and an atmosphere description, grounded in relationships formed at the venue; do not replace it with generic recruitment wording. These selections supersede the older labels/headlines below. Expanded access detail, other proposals and factual checks remain for final copy review. No build/Figma edits in this documentation pass.

> **Copy review, 15 September 2026:** see `about-copy-review-en.md` for proposed English revisions compared with the current desktop Figma and local build. This file retains earlier IA and copy decisions as history; the current section order is Hero → Concept → How it feels → Perks → Story → Guests → Team → Careers → Location → Entrance → Visit CTA. The separate Mission/Photo Library proposals below are not the built page. New prose is not approved or applied. Forms/booking wording remain on hold per the author; website address is settled as Kirova 10/25.

*Voice: Molot for headlines (short bursts, 3–7 words), Golos for everything read. Ground in Peppercorn/Parchment per mode. Sourced from sweet_pepper_bar_brief.md and design.md — nothing here is invented beyond phrasing; flagged items need founder confirmation.*

*IA (v2, agreed): Hero → The Story → The Concept → The Mission → The People (Team + Community) → Recognition band → The Location → Careers → Visit. Changes from v1: "local drinks & dishes" folded into Concept (it's the offering, not the place); The People splits into Team + Community, where Community teases a separate Photo Library page; Recognition demoted from a section to a banner; Careers kept as a short section, not a page; the "street / colleagues-not-competitors" section dropped for v1 (too repetitive with Location).*

*(v3): The Concept reframed guest-first — 50/50 strategy language retired from guest copy (pairing is what guests get; 50/50 is how we run it). The section now leads with pairing and carries the interactive pairing picker; component spec in `website-brief.md` (bartender's ticket).*

*(v4): Recognition band replaced by a full section — "How it feels" (word-of-mouth cloud + quote wheel). Platform metrics retired from guest copy (too few to impress); the playful counters (cups of coffee etc.) move to The Story. Perks ("Beyond shake & cook") specced as a stamp strip.*

*(v5): The Story finalized — founder card carries the "know your limit" quote (the manifesto folds into Story body copy); a three-marker timeline divides story from a counter ledger in a Paper card.*

---

## 1. HOME PAGE — About section (teaser)

This is the highlights version for the homepage — story + credibility, then hand off to the full page.

**Eyebrow (Molot H3, Olive/Lime):** OUR STORY

**Headline (Molot H1):** SHAKE & COOK SINCE 2014

**Body (Golos, 2–3 sentences):**
> Sweet Pepper grew out of Tabasco Bar next door — same edge, more warmth, and a kitchen finally worth showing up for. We're one of the only places in Yaroslavl running a serious breakfast-and-lunch kitchen and a craft cocktail bar as equals, all day, every day. Regulars don't come for one or the other — they come because the team knows their name and their order.

**Stat strip (Golos Caption, Olive):**
`4.6★ · 1,300+ reviews  —  Est. 2014  —  Kirova St. 10`

**Guest quote (Cream block tint):**
> "Every time I fall into a slump after studying, I come here and remember why life is worth living."
> — Google review

**CTA (chip):** Read our full story →

*Note: rotate 2–3 quotes here from the brief's review pool (душевный/уютный themes) rather than hardcoding one.*

---

## 2. ABOUT PAGE — full content

### Hero

**Eyebrow:** KIROVA ST. 10, YAROSLAVL

**H1:** SHAKE & COOK SINCE 2014

**Lead paragraph:**
> We run a kitchen and a bar that take each other seriously — not a café that pours drinks at night, not a bar that fries eggs on weekends. Sweet Pepper is built to be both, all day, from the first coffee at 8:30 to the last round past midnight.

---

### The Story

**H2:** FROM TABASCO TO SWEET PEPPER

> Sweet Pepper isn't our first place — it grew out of Tabasco Bar, our first venue on Yaroslavl's "Arbat." When it came time to build something new, we wanted to keep the edge but lose the aggression, and add a dimension Tabasco never had: real food.
>
> The name says the whole idea out loud. Sweet Pepper still has the heat — it just knows how to feed you too. The hybrid wasn't a hedge between two ideas we couldn't choose between. It was a bet that Yaroslavl was missing a place built from day one to do breakfast, lunch, and cocktails with equal seriousness — not as a side hustle to each other.
>
> A gastrobar isn't a compromise. It's the highest form of hospitality: being exactly what you need from 8 AM till 2 AM without changing your character.

*Paragraph break moved (author, Sep 2026): the naming sentences open ¶2 so that on phones they follow the timeline card, as the mobile frame draws it.*

*RU for the closing line: «Гастробар — это не компромисс. Это высшая форма гостеприимства: быть именно тем, что тебе нужно, с восьми утра до двух ночи — не меняя характера.»*
*[Watch the overlap with the hero lead ("not a café that pours drinks at night…") — same argument twice on one page; if it grates, trim this paragraph to the "8 AM till 2 AM without changing your character" half, which the hero doesn't say.]*

**Founder credit block** — photo with the quote card overlapping its bottom edge (−1° tilt, the site-wide quote-object language: Paper card, big Chili quote mark).

- **Photo:** `photos/team/iura/` — the candid karaoke/party-hat frame stays: real, in the bar, slightly imperfect (design.md §7).
- **Quote (Golos, 16–17 — quote text is reading, never Molot):**
> EN: "The main thing is to always know your limit. Otherwise you might drink less."
> RU: «Главное — всегда знать свою меру. Иначе можно выпить меньше.»
- **Attribution (inside the card):** Iurii Primyshev · Founder, CEO — still behind the bar
- Store quotes per-locale in the CMS; never machine-translate voice lines.

**Timeline divider** — a three-marker axis separating the story from the counters:

| Year (eyebrow style: Molot 14, Olive) | Label (Molot 18, Chili) | Wit line (Golos 13, Ash, sentence case) |
|---|---|---|
| 2009 | TABASCO BAR | Where the heat started |
| 2014 | SWEET PEPPER | Kept the heat, made it delicious |
| 2026 | STILL HERE | Same table, probably yours |

- Axis: Ash @ ~35% (time is neutral); Chili tick marks and an arrowhead that runs past the last marker (constancy by geometry). Marker spacing roughly proportional to real years.
- The current-year label can be mode-aware later (TODAY / TONIGHT) if STILL HERE ever rotates out.
- Jokes stay in Golos — Molot names things, Golos speaks.

**Counter ledger** — a Paper card under the timeline, aligned beneath the 2014→2026 span:

- Left slot (the empty pre-2014 span): the label, stacked two lines — "TWELVE YEARS, / COUNTED IN ORDERS" (Molot, Olive).
  *Phone frame (1490:78397) writes it "12 YEARS, COUNTED IN ORDERS" on one line; the words wrap to two on a phone. Kept the words (author, Sep 2026): they set the header apart from the digit rows beneath.*
- Three counters (Molot ~44): number + Golos 13 label ("cappuccinos poured" · "pumpkin soups served" · "salted caramel shots"). Pool of 5–6 rotates one slot at a time (~4s) with a count-up on entry — the section's only idle motion.
- Entrance (once, on scroll): axis draws left→right → ticks pop → arrowhead lands → counters count up → rotation begins.
- Numbers are kitchen-approved estimates; colour note: Olive numerals risk reading as prices (design.md §2.2 — Olive = prices), warm accent (Chili/Paprika) is the safer numeral colour.

---

### The Concept

**H2:** WHAT ARE YOU HAVING?

> The bar here was built by a bartender; the kitchen by cooks who were never asked to serve it. Order eggs at nine or a negroni at noon — nobody raises an eyebrow. Every dish is designed to sit next to a drink, alcoholic or not — and that's easier to taste than to explain.

*(The 50/50 business-split fact is retired from guest copy — it's the strategy, not the gift. It lives on in the case study / press kit.)*
>
> Our house-made infusions are the clearest proof of that craft — guests photograph them, name them in reviews unprompted, and the salted caramel infusion has become something people ask for by name.
>
> The food plays a quieter game. Comfort food, made well — no guest chefs, no trend menus — the kind of cooking you actually want on a Tuesday, with a seasonal layer to keep it alive. Familiar Russian anchors like жаркое в горшочке sit next to the pasta, the salads, and the breakfasts. The best evidence it works: **pumpkin soup, berry cheesecake, and berry korzhik all started as seasonal specials.** Guests kept asking until we made them permanent. The menu isn't something we decided alone — it's something the regulars voted for with their appetite.

**Pairing picker module** — the section's interactive proof: pick a plate, the bar answers.

- **Control:** 4–6 featured dishes as standard chips (the sanctioned inline-action style) under the Molot H2 — "WHAT ARE YOU HAVING?" doubles as the prompt.
- **Response:** a **bartender's ticket** prints below (component spec: `website-brief.md`) — the dish as an order line, then the bar's reply in its own voice: "unforgettable with a shot of the cranberry infusion."
- **Daypart sets:** dishes and pairings follow the site's dayparts — syrniki + filter coffee in the morning, tartare + martini at night. Non-alcoholic pairings by day prove the all-day claim without a word of strategy.
- **CMS:** menu-item post type gains `pairing_line` (one distinct bartender-voiced sentence), a `featured_in_about` flag, and daypart tags; the team rotates these seasonally.
- **Copy rule:** every line sounds like the bartender said it. "Pairs well with X" is banned. If copy runs thin, cut dishes rather than repeat lines.
- **Exit:** one chip on the ticket, pointing at the **answer** (the drink), deep-linked to its section in the drinks state — e.g. "A shot of the cranberry infusion — in the bar →". Deep links override the daypart default, so the CTA never inherits the clock. The dish gets no link: the guest just chose it, and "See the full menu" sits in the same viewport.
  - 🧪 **Usability test (before build):** watch whether guests try to tap the dish name on the ticket. If they do, the dish becomes a quiet text link (not a second chip) to its food-state section. One chip stays the rule — a receipt with two CTAs reads as a flyer, not a reply.

*Parked for the Menu page (bigger canvas, full catalogue): the "Yaroslavl table" top-down hotspot scene and the "No wrong orders" drag-match game.*

**CTA (chip):** See the full menu →

---

### The Mission

**H2:** A PLACE WHERE THE WORLD IS OK

> For our first five or six years, something was on every single day — Musical Wednesdays, foosball tournaments, a book club, an English-speaking club, local concerts, themed weekends. Not to maximise the crowd on any one night, but to be a place with a genuine reason to show up on a Tuesday.
>
> Circumstances have quieted the calendar since, but not what it was for. What matters hasn't changed: **a place where the world is ok for our guests.** That's not a slogan we picked for the wall — it's the reason the programming existed in the first place, and it's still the reason the door's open at 8:30am and past 2am.

*[Open question from brief: confirm which programmes — book club, English club, foosball nights — are still active vs. paused, so this section doesn't overpromise. Keep the tense soft until resolved.]*

---

### The People

*Two halves, given equal weight — a deliberate echo of the 50/50 concept. No bar exists without either one.*

**H2:** THE TEAM

> Ask anyone who comes back again and again why, and most won't mention a dish first — they'll mention a person. Our staff turnover is low for this industry; a lot of the team has been here for years, trained not just to pour and plate but in wine, whiskey, and infusions, with help from visiting sommeliers along the way.
>
> Our Instagram and VK are run by the same people working the floor — not an agency. So when you see a post, it's someone who already knows your order, not a marketing calendar.

**Meet the team module** — a grid of the people who make the room warm.

- **Card (per person):** photo (2:3 or 1:1, consistent crop across all cards) · name (Molot caption) · role + years here (Golos caption) · optional one-line "ask me about…" (their signature drink/dish, in Golos).
  *Placeholders (Sep 2026): seven lines were written into `team.php` so every card and phone row has a chip and a reveal to judge the layout by (Kostya's swing-chairs, Lenya's soup-and-sour, Anton's "the drink, not the night", Stas's 2019 order, Alex's jar, Max's eggs, Johnny's pepper recipe). Only Lera's is real. Replace with the members' own words before launch.*
- **Photos:** placeholders for v1. Existing event/social shots available now; a fresh team shoot is under consideration (a couple of photographers on hand) for a consistent, art-directed set — recommended, since matching crops and lighting across cards is what makes this module read as intentional rather than a scrapbook.
- **Order:** longest-tenured first is on-brand (the low-turnover story made visible).

*[Team is comfortable being featured — confirmed. Real names/roles/years to be supplied. Brief notes staff praised by name in reviews, e.g. a waitress, Valeria.]*

**H2:** OUR GUESTS

> Some of the people at these tables have been coming longer than some of us have worked here. A bar is nothing without them — so this page is partly theirs.
>
> We shoot the room at every event, and guests come looking for themselves afterwards. So the photos live here, in one place: nights, parties, and the small ordinary evenings in between.

**CTA (chip):** Browse the photo library →

*v1 scope: a short statement + a curated set of event photos, linking out to a dedicated **Photo Library** page (its own template — event sets, browsable, the thing guests already hunt for after each night). This About section is the teaser/entry point to that page.*
*[Future plan: named guest stories — the regulars, the couples who met here and married here (there are several). Needs guest consent first; parked for a later version.]*

---

### How it feels (replaces the Recognition band)

**Eyebrow:** WORD OF MOUTH

**H2:** HOW IT FEELS

**CTA (chip):** Add your word → (links to review platforms; the promise is literal — new review vocabulary feeds the tally)

Two-column section: word cloud left (6 cols), quote wheel right (6 cols).

**The word cloud** — review vocabulary set like a poster, honest by construction:
- **Size = frequency tier.** Three fixed sizes (64 / 40 / 26), assigned by how often the word actually appears in reviews. Never continuous scaling — "the bigger the word, the more often guests wrote it."
- ~~**Hue = tier.**~~ **Hue is a dealt palette, not a tier (revised Sep 2026, author).** Six stops across the red and green ramps plus Ash — Chili, Deep Chili, Paprika, Olive, Avocado, Ash — dealt round-robin over the word list, stable across visits. Reason: with hue tied to tier and the field seating the largest words first, every red sat in the centre and the range was three colours where the Figma cloud runs five. Size stays the only honesty carrier. Paprika is top-tier only (2.5:1 on Parchment); the section is a fixed light composition, so there is no night set.
- **Fill = state.** Every word idles as outline; only the active word fills. This rule is what keeps three hues calm.
- Real Russian review vocabulary (уютно, душевно, как дома…), 16–20 words, hard cap 25.
- Motion: gentle per-word drift; pointer parallax with tier-weighted depth (top words lead — the anchor effect); click = the word steps to the cloud column's centre, fills, others dim to ~30%. **Phones (Sep 2026):** the same field and drift at half amplitude in a 370 × 380 box; a tap fills + dims only — no centring, the box has no room to clear a zone.

**Cloud layout — three candidates (studied Sep 2026, undecided).** Live studies with a Night toggle per frame: `design-examples/how-it-feels-cloud-studies/` (working files; the saved canvas is the same thing rendered). Implementation rules for B and E: `website-brief.md` → Part 3 → Cloud layouts B and E.
- **A · Rows** — the brief as written: poster rows, drift 3–5 px, parallax where top-tier words move most, click steps the word to centre. System-legal, and easy to miss from across the room.
- **B · Field** — no rows. Words find their own spot on a spiral from the centre (largest first, no overlaps), orbit their home, and lean toward the pointer ("the room leans in"). Click pulls the word to the column's centre and *the others make room*: a cleared zone (the word's box + 28 px margin), neighbours nudged outward, the cloud re-settled with no overlaps, everyone drifting home on release. Breaks "set like a poster"; the size = frequency read gets weaker because placement looks random. Earns the exception only if the drift is the thing people remember.
- **E · Pile** — words spill in and settle like letter tiles on the counter; the pointer nudges them; click lifts a word to centre as a solid tile with 20 px of air around it (nothing can sit behind it); the next click drops it back. Breaks "honest by construction" and calm — a heap is not a poster. Kept as the gut-feel option: this is the section about how the room feels, and the room is not a pile.
- Both B and E keep the rules that matter: outline → fill, hue = tier, three fixed sizes, one clock (the heartbeat only ever fills; a human click is the only thing that moves a word to centre), the 8 s seizure, and reduced-motion = fill + quote swap only.
- **Sizes: 64 / 40 / 26 does not fit.** *(Phones run 40 / 26 / 18 — H1-ish / H2-ish / H3 — over one quote card; see `website-brief.md` → Mobile — About page.)* Five top-tier words at 64 px overflow a 6-col column (WELCOMING alone is ≈350 px in Molot). The Figma and the theme quietly compensated with five sizes and tier ≠ size, which breaks "size = frequency tier." The studies use **56 / 36 / 24**. Adopt these, or re-cut the top tier to ≤ 3 words, and fix the bullet above — one rule, not two. *(Open.)*

**The quote wheel** — a vertical belt of review cards. Centre card = hero state (Cream tint, −1° tilt); neighbours Paper; edge cards cropped and dimmed (the "many more" signal) and clickable to pull to centre.

**One clock.** A single heartbeat (~~3.5s~~ **5 s, Sep 2026**) fills the next word AND rolls its quote to centre. ~~Any click seizes the clock (auto-advance pauses ~8s, then resumes).~~ **Any touch ends the heartbeat for the visit (author, Sep 2026)** — a guest exploring the interaction is never interrupted by the demo; the 8 s pause only releases the visuals (undim, ease home). The heartbeat fills but never centres a word — only a human click earns centring. Repeat-click on a word deals its next quote (words map to several quotes). Fill/unfill runs 900 ms; the quote rolls 900 ms on the house spring.

**Default state:** opens mid-breath — the #1 tally word filled, its quote centred. Never all-inactive.

**Accessibility/perf:** transforms only, one rAF loop; prefers-reduced-motion removes drift/parallax/auto-advance but keeps click → fill → quote; touch is tap-only and fully functional.

**CMS:** `review_quote` post type — text (curated to 2–3 lines: a curation rule, not truncation), source platform, date, word tags. Pool hand-curated (15–20 quotes), order shuffled per visit; nothing pulled live, per the platform decisions in `website-brief.md`.

**Star ratings:** retired from this section. If proof-by-numbers is ever needed, it's one caption line under the wheel — never a band.

---

### What to expect (perks) — stamp strip

**Eyebrow:** WHAT TO EXPECT

**H2:** BEYOND SHAKE & COOK

Perks as rubber stamps (the Since-2014 seal lineage): dashed round badges — icon + one Molot word (WI-FI · KIDS · DOGS · TERRACE · YOUR WAY · NO STAIRS) — with a slight alternating tilt. Not cards: perks are quick assurances, not six equal stories, and a saturated card wall breaks design.md §2.4.

- **Interaction:** hover = slight rotation; click/tap = the stamp "presses" — dashed→solid ring, ink fill, small scale-down (no glow, per the flat-effects rule) — and a shared one-liner below the row updates (Molot title + leader dots + Golos description, left edge pinned so it doesn't jump between stamps).
- **Copy:** house voice, one distinct line per perk, no duplicates. Reviews stay out of this section — the guests already speak in "How it feels"; one voice per section.
- **Placement:** after The Concept or just before The Location; it can absorb Location's practical icon row so facts aren't listed twice.
- **CMS:** perk entries (icon, word, one-liner) — one source of truth shared with The Location.
- **As built (Sep 2026):** the stamp words above are the **phone** labels; desktop still shows the longer labels from the desktop frame (Kids Welcome, Dogs Friendly, The Way You Like, Accessible) in Golos, not Molot — both frames draw Golos Medium 14 although the text layer is named "restyle to Molot". Open for the author: one word at both widths per this doc, and Molot or Golos. The mobile frame says **Pets** where this doc says DOGS; built as Dogs (the one-liner is about dogs). Icons are the Figma `Icons` set, not Phosphor. The active stamp keeps the glow both Figma sets draw, against the "no glow" line above — decide which source wins.

**Final copy** — stamp word · expanded title (Molot, with leader dots) · one-liner (Golos, spaced em dashes):

- **WI-FI** · WI-FI & POWER — Outlets at every table, chargers at the bar, reliable Wi-Fi — you're all set.
- **KIDS** · KIDS' MENU & ACTIVITIES — Colouring books, a kids' menu, and weekend cartoons make it feel like home.
- **DOGS** · DOG-FRIENDLY BAR — Bring your favourite human and your favourite dog — a water bowl is on the house!
- **TERRACE** · SUMMER TERRACE — Open air and a drink that tastes better outside — take the best seat in town.
- **YOUR WAY** · THE WAY YOU LIKE IT — Shake it, skip it, add something extra — we're happy to make it yours.
- **NO STAIRS** · ACCESSIBLE — Step-free entrance, an access ramp, and a team that's always happy to help.

**Seasonal swap (Terrace → Seasonal Menu).** The Terrace stamp runs through terrace season (spring to ~early October). Once the terrace closes for the year, the same slot flips to a Seasonal Menu stamp so the strip never advertises a shut terrace:

- **SEASONAL** · SEASONAL MENU *(off-season, ~Oct–spring)* — The terrace is resting, but the kitchen leans into the season — warming plates and new specials worth coming in for. *(Icon: swap the sun/terrace glyph for a bowl or leaf, Phosphor Fill per design.md §5.2.)*

*Make it an ACF true/false the team flips at season's end, not a hardcoded date — the close date drifts with the weather. One field on the perk entry keeps the CMS single-source.*

---

### The Location

**H2:** HEART OF THE CITY

> We're on Kirova Street 10 — Yaroslavl's pedestrian "Arbat," a few minutes from the Church of Elijah the Prophet and the Monument to Yaroslav the Wise. Two halls inside, each with its own feel, and a summer terrace with swing-chairs that people remember long after the drink.
>
> Free Wi-Fi if you're working, a table for whoever you bring — including the dog — and a step-free way in.

*The practical layer renders via the perk stamps (see "What to expect") — don't list the facts twice. Terrace season runs spring to ~early October; off-season the Terrace stamp swaps to Seasonal Menu (see the swap note above).*

---

### Careers

**H2:** WE'RE USUALLY HIRING

> We're a small team and people tend to stay — but when a spot opens, we train from scratch: the floor, the bar, wine and infusions, all of it. If you want to learn this properly in a place that treats the work seriously, come talk to us.

**CTA pair:** See open roles → / Write to us →

*Short section by design — not a separate page. Hiring is regular but the team is small, so a full careers page would be too much for v1.*

---

### Visit

**H2:** COME SIT WITH US

> Open from 8:30 till late, every day. Book ahead for evenings and weekends — the room is small and fills up.

**CTA pair:** Reserve a table → / See the menu →

---

## Notes / gaps to close before final copy

- ~~**Founder's name**~~ — resolved: **Iurii Primyshev** (founder, bartender), credited in The Story with a photo from `photos/team/iura/`.
- ~~**Founder quote**~~ — resolved: the "know your limit" line (from Iurii, verbatim) on the founder card; the gastrobar manifesto folded into Story body copy.
- **Timeline + counter RU versions** — translate the wit lines and counter labels (voice lines, no machine translation).
- **Counter numbers** — replace estimates with kitchen-approved figures (2–3 real ones minimum).
- **Meet the team content** — module built; need real names / roles / years-here. Team OK with being featured. Decide: use existing event/social photos now, or commission a fresh consistent team shoot (recommended).
- **Current status of book club / English club / foosball nights** — affects tense and specificity in "The Mission."
- **Photo Library page** — needs its own template spec (event-set structure, browsability). About's "Our Guests" section links to it.
- **Guest stories + consent** — parked for a future version; v1 Community section is photos + a short statement only.
- ~~**Seasonal terrace opening months**~~ — resolved: season runs spring to ~early October; off-season the Terrace perk swaps to a Seasonal Menu perk (ACF toggle).
- **Pairing lines** — 4–6 bartender-voiced sentences needed from Iurii/the bar for the picker (one per featured dish, no templates).
- **Review vocabulary tally** — count word frequency across Google/Yandex/2GIS review exports before build; the cloud's sizes must be true. Re-tally seasonally so "Add your word" stays a real promise.
- **Quote pool** — curate 15–20 review quotes at 2–3 lines each, with word tags, for the wheel.
- **Story counters** — pick the 2–3 real numbers (cappuccinos, soups, years) worth counting up in The Story.
