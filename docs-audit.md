# Sweet Pepper — documentation audit

*Aug 2026, before the theme build starts. Findings only — nothing in any doc has been changed.*

Eleven files read in full and cross-checked: `website-brief.md`, `design.md`, `CLAUDE.md`, `menu.md`, `menu-en.md`, `menu-hero-copy.md`, `about-page-copy.md`, `visit-page-copy.md`, `connector-copy.md`, `testing.md`, `sweet_pepper_bar_brief.md`. Contrast ratios and colour-blind claims were recomputed from the hex values rather than read from the tables, per `CLAUDE.md`.

**How to use this.** Section A is what would become a bug or a wrong guest-facing fact if the build started today. Section B is what blocks a specific build phase. Section C is hygiene. Section D is the numbers audit. Section E lists what came back clean, so you know what you can trust.

Nothing here is a design opinion. Where two docs disagree, the finding names both and says which looks current — the call is yours.

---

## A. Fix before the first line of code

### A1. The Interaction rule is false as written

`website-brief.md` → Interaction rule states **"Exactly three container styles signal 'tappable'"**, reinforced in Don't (web-specific): *"doors the only state switches. No fourth tappable style."*

The docs police this well in five places — the Lemon caption label, the edge tab, the Visit scroll-down link, the drawer's Molot instructional line, the Good-to-know badges. But five shipped specs sit outside the rule with nothing reconciling them:

| What | Where | Why it breaks the rule |
|---|---|---|
| Daypart tiles | `website-brief.md` → Mobile — home hero → Behaviour: *"This is now the mobile day/night control — tapping a dinner or party tile darkens the site."* | Doors are declared the *only* state switches, "nothing else may be door-shaped" |
| About perk stamps | `about-page-copy.md` → What to expect: *"click/tap = the stamp 'presses' — dashed→solid ring, ink fill, small scale-down"* | A fourth tappable container, with its own press state. About never cites the rule |
| Word cloud + quote wheel | `about-page-copy.md`: *"click = the word steps to the cloud column's centre"*; edge cards *"clickable to pull to centre"* | Tappable text, none of the three |
| EN/RU pill | `website-brief.md` → Top nav | The docs acknowledge the *shape* collision with the caption label, never that the control itself is a fourth style |
| Molot words with trailing arrows | Menu word list; drawer nav list | Not boxed, not chip, not door |

**Why this is A-severity:** the rule is the thing that makes your component library enforceable, and it's the first thing you'd hand an agent. As written it forbids things you've already designed, so it will be violated on day one and then quietly ignored.

**Proposed fix:** rewrite the rule as *"three container styles signal tappable; these named exceptions are sanctioned and closed"* and list the five. The value is in the list being closed, not in the number being three.

---

### A2. The ticker is retired and still load-bearing in four places

Retirement: `website-brief.md` → Menu page → Hero — *"The former ticker is retired for navigation … The running word-loop survives only as a display motif candidate."*

Still treated as shipping:

- → Day / night pairings: *"day energy comes from tilt, hard Peppercorn keylines, and **the Lemon ticker band** instead of a wash"*
- → Menu page → Hero: *"Day menu = Lemon display ticker; Visit mobile = Lime status rail"*
- → Seasonal & specials: *"on day the ticker band and the deals band are both Lemon"*
- → Shared sections — the green rule: *"the ticker word (Lime/Olive)"* carries section-ownership state

**The last one is the real problem** — a ticker word signalling shared-section state *is* navigation, which the retirement forbids outright. That section was written when the ticker was still the nav and was never rewritten for the edge-tab jump-nav.

Related, in the same document four lines apart: → Word list roles says *"there is no day band anymore"* while three other lines spec a day Lemon band. Either "band" means two objects, or one line is stale.

---

### A3. The Interaction rule's sibling: "one colour-block moment per page" doesn't survive its own specs

`website-brief.md` → Section striping → Day: *"a saturated band (Lemon) used sparingly as **the one 'colour-block moment'**."*

On a day menu page: the hero's *"offset Lemon + Chili sheets"*, the ticker band, the deals band, and the site-wide Lime footer. Three or four, against a rule of one. The brief flags two of them (Seasonal & specials; "Double-Lemon on day" in Open) but never counts the footer, which is the newest decision and applies to **every** page in both modes.

Directly contradicted on Visit: `visit-page-copy.md` → Day mode calls its Lime band *"the page's one colour-block moment"* — false as written, since the Lime footer shares that page.

**Proposed fix:** the striping rule predates the Lime footer. Re-scope it ("one colour-block moment per page *above the footer*") or drop the count and state the intent.

---

### A4. Two day-mode text tokens fail AA — and one of them is the price colour

Computed from the hex values, not read from a table:

| Token | Day value | On `--bg` Paper | On `--surface` Parchment | Verdict |
|---|---|---|---|---|
| `--text-highlight` | Chili `#E34314` | **3.86 : 1** | **3.43 : 1** | fails AA for normal text; large text / UI only |
| `--accent-2` | Olive `#737D3A` | **4.15 : 1** | **3.68 : 1** | fails AA for normal text |

`design.md` §2.2 assigns **Olive = prices**. Menu prices are small text, in two-column dotted-leader rows, on Parchment — the exact combination that measures 3.68:1. Nothing in the docs flags this; §2.5's accessibility section covers text on *Lemon and Lime* grounds thoroughly and never checks the semantic tokens against the day surfaces.

Night is clean throughout except `--accent` (Chili on Peppercorn, 4.47:1 — the docs already record this correction and it remains large-text/UI only).

**Proposed fix:** either prices move to Deep Chili `#9B2705` or a darker green step on the existing hue line (§2.1's generative rule allows it), or the docs state explicitly that Olive prices are display-size only. This is a token decision, so it belongs before the CSS custom properties are written.

---

### A5. "Colour-blind safe — no conflicts" is not accurate

`design.md` §2.5 opens: *"Palette is **colour-blind safe** (no conflicts across deuter/prot/tritanopia)."*

Simulating each brand colour under dichromatic vision and measuring the perceptual distance between every pair, several pairs that are far apart in normal vision collapse:

| Vision | Pair | ΔE normal → simulated |
|---|---|---|
| Protanopia | **Chili ~ Olive** | 78 → **10.2** |
| Protanopia | Paprika ~ Olive | 64 → **4.0** |
| Deuteranopia | Paprika ~ Avocado | 66 → **9.8** |
| Tritanopia | Lemon ~ Cream | 38 → **2.5** |
| Tritanopia | Light Lime ~ Lime | 20 → 8.6 |

**Chili ~ Olive under protanopia is the one that matters**: those are `--accent` and `--accent-2` in day mode, and on a menu row they sit next to each other — a Chili heading above Olive prices.

**Caveat, stated plainly:** this is a standard dichromat simulation plus a CIE76 distance, both approximations, and neither is a substitute for testing with real users. And the practical impact depends on whether colour ever carries meaning *alone* in your design — where it doesn't, a collision is cosmetic. But the blanket claim "no conflicts" is measurably false and shouldn't stand in a source-of-truth document.

**Proposed fix:** narrow the claim to what's true — *"no colour carries meaning alone; where two colours must be told apart, they also differ in value or form"* — and verify that second half holds for Chili/Olive on menu rows.

---

### A6. Guest-facing copy marked "final" contains claims no source supports

`about-page-copy.md` → What to expect is labelled **Final copy** and ships six perk stamps. Three make physical claims that appear in no other document:

| Claim | Where | What the source docs actually say |
|---|---|---|
| *"an access ramp"* | About, final copy | `sweet_pepper_bar_brief.md`: *"Wheelchair-accessible entrance **noted**"* — hedged, from public listings. No ramp anywhere |
| *"Outlets at every table, chargers at the bar"* | About, final copy | Brief says only *"Free Wi-Fi"*, *"Laptop-friendly"* |
| *"weekend cartoons"*, *"Colouring books"* | About, final copy | Brief confirms only *"Children's menu"*. `menu-hero-copy.md` says *"Crayons live behind the bar"* — a different object |
| *"a water bowl is on the house!"* | About, final copy | `visit-page-copy.md` flags the same fact: *"Water bowl on request." 🔶 [bowl line — confirm, don't invent policy]* |

Two more of the same kind:

- **18+ policy is invented twice, incompatibly.** `visit-page-copy.md` carries both *"18+ after 22:00"* 🔶 and *"After the kitchen closes, the bar is grown-ups only"* — and the doc labels the second *"invented"*. Kitchen close is 01:30, so the two versions differ by three and a half hours.
- **The founder is described two ways.** `sweet_pepper_bar_brief.md`: *"The founder is a **former** professional bartender"*; `about-page-copy.md` credit block: *"Iurii Primyshev · Founder, CEO — **still behind the bar**"*. A factual claim about a named person, on a live page.

**Why A-severity:** these ship to guests. A guest who arrives with a wheelchair expecting a ramp, or with a laptop expecting an outlet, has been told something by the site. Everything here needs one round with Iurii, and the "final copy" label should come off until it's had one.

---

### A7. The tag model was decided and never applied to the data

`website-brief.md` decides: *"Seasonal is a **tag, not a section**"*, specials carry *"a `special` tag with an end date"*, and both feed rails/bands as queries.

In the actual menu files:

- `menu-en.md` — the file that is supposed to be in website order — still carries **three seasonal sub-sections** inherited from print: `SEASONAL DRINKS`, `SEASONAL LEMONADES`, `NEW SUMMER HITS`
- **No item in either menu file carries any tag.** Not seasonal, not special, not an end date
- The *"SUMMER AT PEPPER"* rail heading the brief requires exists in neither file
- `Meat Set 2026` has a year in the dish name and no end date — precisely what the `special` mechanism exists for
- **Five of the eight house offers** in `menu-hero-copy.md` appear in no menu file at all: free infusion with select mains, Wednesday wine, birthday 10%, 10% off to go, weekly new cocktail. The Hot deals band is specced as a query over tagged items, and no item is tagged — **the band currently has no source**

The nav-word question the brief closed ("SUMMER dropped from the nav") is reopened one level down, where nobody looked.

---

## B. Blocks a specific build phase

### B1. Blocks the content model — the hours truth (needs Iurii)

The single ACF hours source feeds the footer, the Restaurant schema, the daypart engine's day-type logic, the Visit hours block, and the entire status-line matrix. It is currently contradictory:

| Question | The disagreement |
|---|---|
| All-day breakfast? | `menu-en.md`: *"EVERY DAY, ANY TIME"* · `menu-hero-copy.md`: *"don't reintroduce 'till 12' anywhere"* · vs `sweet_pepper_bar_brief.md` *"Breakfast 8:30–12:00 (weekdays)"*, `visit-page-copy.md` *"breakfast served till noon"*, and `website-brief.md` → no-clock rule *"breakfast cutoff may say 'served till noon'"* |
| Weekend breakfast? | Menu says every day; brief says weekdays; Visit flags it: *"don't let a weekend guest walk to a closed kitchen"* |
| **Saturday opening time?** | **Stated nowhere in any file.** Sunday's 10:00 is specced; Saturday is undefined while About and the footer promise *"8:30 … every day"* |
| "Every day" vs Sunday 10:00 | About: *"Open from 8:30 till late, every day."* vs the Sunday 10:00 exception encoded in the state model |
| Kitchen close | `visit-page-copy.md`: kitchen 1:30, **last orders 1:00** · `website-brief.md` Party last-call: *"last order 1:30"* — conflates close with order deadline |
| Bar close | `sweet_pepper_bar_brief.md`: *"2–3 AM"* · Visit: *"bar close 02:00 … drop the 3:00 variant"* · About: *"past 2am"* |
| Opening, inside one file | `about-page-copy.md` says both *"from 8 AM"* and *"the first coffee at 8:30"* |

**One conversation with Iurii answers all of it.** Until it happens the hours field structure can't be finalised — and question 5 decides schema shape: one kitchen-close value, or a per-night field.

### B2. Blocks the content model — item-card anatomy contradicts the CPT definition

- `website-brief.md` → Platform: *"Menu items — a custom post type (name, price, **photo at 3:2**, category, dietary tags)"* — a photo per dish
- `website-brief.md` → Menu page → Open: *"Item-card anatomy (photo-per-dish vs rows + one section photo) — **leaning rows + one 3:2 per section**"*

The menus hold roughly 300 items. If "rows + one section photo" wins, the photo moves off the item and onto the section taxonomy term — a different field on a different object — and the shoot scope changes from ~300 photographs to ~16. **Settle before registering the CPT.**

### B3. Blocks the content model — "Bar Snacks" is a taxonomy term, not just a label

It's simultaneously a nav word, a deep-link anchor (*"each section anchor is deep-linkable"*), a shared-section marker, an RU register twin, and a string in four files. Changing it after launch breaks live links.

Complete propagation list, for the one-pass rename the brief prescribes: `website-brief.md` ×4 · `menu-hero-copy.md` ×2 · `menu-en.md` ×2 · `testing.md` ×1 · `menu.md` `## ЗАКУСКИ` (the RU side has no working-name note and no candidate name recorded anywhere).

**Three things that block the test itself:** `menu-hero-copy.md` describes the section as *"boards, pickles, wings"* — the menu has no boards and no pickles. The naming argument turns on *"it re-demotes the boards"* — there is one meat set. And `testing.md` specifies *"Run a 'find the cheese plate' task"* — **there is no cheese plate on the menu, in either language.** Either the menu is missing items or the argument and the test describe an aspirational section.

### B4. Blocks the foundation — the daypart component has no "closed" axis

The brief flags this itself and calls the retrofit expensive: *"Decide before building the set — retrofitting an axis means rewiring every instance."*

It reaches further than the doc says: the same state model drives the mobile tiles, the desktop tiles, the Visit hours block, **and the JS daypart engine's state classes.** Choosing wrong means rewiring Figma *and* every CSS state hook.

### B5. Blocks the foundation — Caption weight (Golos 400 or 500 at 13px), circular as written

- `design.md` §9: Caption is specced 500, *"but the shipped image caption label … is set in Golos **400**"*
- `website-brief.md` → Image caption label: *"Golos 13 / 140% / 4% tracking (**weight open** — see `design.md` §9)"*

Each defers to the other; **neither states the weight.** design.md names the propagation list itself: Figma text styles, the `img` component, the ticket header, the status lines, form labels/hints. Note the collision — Form label (500) and Form hint (400) are the *same* 13px values differing only by weight, so deciding Caption = 400 collapses it into Form hint.

### B6. Blocks the foundation — no responsive rule for the grid or the type scale

`website-brief.md` → Grid: *"Narrower breakpoints get their own column rule (**not yet defined**); don't assume 6 columns holds below desktop."*

`design.md` §3.3 gives one fixed size per level (Display 76, H1 44, H2 24…) with no breakpoint or fluid rule, while all the mobile work is specced at 402px. These are the same missing decision and should be made together, before the scale compiles to CSS.

### B7. Blocks every page — three site-wide facts are unresolved

- **Address:** *"mockups say 'Kirova 10/25', the docs say Kirova 10 — confirm with Iurii"* (Iurii)
- **Phone:** every appearance is a mockup placeholder, `+7 (4852) 911-202` (Iurii)
- **Nav order:** decided Home · Menu · About · Visit; mockups run Home · About · Menu · Visit. *"Menu is the highest-intent destination — restore it to second, or record the reason it moved."*

Also referenced but absent: `visit-page-copy.md` points at a *"Reserve panel state matrix"* that exists in no file.

### B8. Blocks RU everywhere — the RU layer is essentially unwritten

`design.md` header says *"English-first (translate final to RU later)"* while `website-brief.md` says *"RU content leads"* and every voice line must be a register twin, never a translation.

Unwritten: all 20+ daypart status lines · the five Visit status-slip states · the Visit closing sign-off · the About timeline wit lines and counter labels · every section connector · the four drawer descriptions · the RU pairing for whatever Bar Snacks becomes.

**The structural consequence, flagged in `visit-page-copy.md`:** *"Cyrillic runs 10–15% longer, so the character ceiling has to survive RU before EN is judged."* Every measure-driven decision made on EN alone — nav slot widths, the four-column nav, chip labels, the status rail — is provisional until RU exists.

### B9. Also blocks the content model

- **`menu.md` can't be imported as-is.** RU leads, but the RU file is still print order: no Food/Drinks split, no web section names, no shared-section marks, no veg markers, and `## ЗАВТРАКИ` appears **twice** as two separate top-level sections
- **Six objects the pages need that Platform doesn't declare:** team members (no object at all), `review_quote` + a word-tag taxonomy, perk entries, the house-facts repeater, the menu-item extensions (`pairing_line`, `featured_in_about`, daypart tags), and seasonal/special tags with end dates
- **Two incompatible single-source models for the same facts.** `visit-page-copy.md` specs an ACF *"house facts"* repeater with a `journey`/`stay`/`both` tag; `about-page-copy.md` specs *"perk entries"* with a different field shape. Both claim to be the single source for WI-FI / KIDS / DOGS / TERRACE / ACCESSIBLE
- **Photo Library page** has a CTA shipping in About v1, no template spec, no post type, and no route — and it contradicts `design.md` §0's standing v1 rule: *"no separate photo archive in v1"*
- **Home hero tiles:** *"16 art-directed photos rather than the slider's four … Decide which tiles can be shared across dayparts before shooting"*

---

## C. Hygiene — cheap fixes, real consequences

### C1. One missing heading breaks eight references

**`### Section labels` does not exist in `website-brief.md`.** The content sits in an unheaded block (there's a double blank line where the heading was lost), and eight references from five files point at it: `website-brief.md` ×3, `testing.md` ×2, `connector-copy.md`, `menu-hero-copy.md`, `menu-en.md`.

One line of markdown clears all eight. **Do this one first.**

### C2. The soups "web↔print divergence" does not exist

Four documents state it: `website-brief.md` ×2, `menu-en.md`, `testing.md` — *"print still files it under hot dishes; accepted web↔print divergence"*, logged in `testing.md` under **Decided — validated** with a usability result.

`menu.md` actually has `## НА ПЕРВОЕ` as a **top-level section at the same level as `## ГОРЯЧИЕ БЛЮДА`, and ahead of it.** It is not nested, not a sub-head, not subordinate. The only sense in which the claim holds is that soups share a print *spread* with the hot food — page layout, not filing.

Consequences: the item mapping the brief says must be maintained for generate-print needs no mapping, and the testing log records a validated divergence that isn't there. Worth resolving before anyone builds generate-print against the documented model.

### C3. Stale slider references

The retention in `website-brief.md` → The spice slider is deliberate and correct — it's the daypart engine now. These are the leftovers that read as if the instrument is live:

- `CLAUDE.md` → Read these first: *"day/night mechanic, **spice slider**, grid, image ratios"*
- `design.md` preamble: *"day/night mechanic, **spice slider**, hero work"*
- `website-brief.md` → Platform: *"hand-coded to this spec in full — day/night mechanic, **spice slider**…"* — contradicted 22 lines later by the thin-PHP rule's *"The daypart engine is JS, not PHP"*
- → Sanctioned small-size exception attributes the Molot 13–18px style to *"the slider meal-period labels"*, but Mobile — home hero says *"**No meal labels on the tiles.** Tried and rejected"*. The exception is real; its only surviving home is the Visit hours block
- → no-clock rule: *"implied by **slider position**"* · → Motion language and → Section connectors both cite *"slider labels"* · `design.md` §3.3 *"H3 — eyebrows, slider labels"* · `visit-page-copy.md`: *"Reuses the slider grammar"*
- **`testing.md` is the worst case:** it logs the spice-slider mechanic under *Decided — validated* with no supersession note, and **the Aug 2026 test that actually killed the slider is absent from the file entirely** — against testing.md's own stated purpose, *"so a test doesn't get stranded inside whatever section prompted it"*

### C4. `visit-page-copy.md` is the file furthest behind

Its Strategy and footer sections predate three Aug 2026 decisions the brief and `design.md` have both absorbed:

- → Strategy: *"The ticket is the page's device. It opens the page and **closes it (footer slip)**"* and the whole of → 5. Closing slip — but the brief's *"Not the footer any more (Aug 2026)"* and `design.md` §5.1's matching revision retired that
- → Strategy: *"Mode: **dark in both modes**"* — contradicted by its own → Day mode section and by the brief's Jul 2026 scope revision (*"its day hero is light"*)
- Its IA v2 dissolved §3 Reserve and §5 Closing slip into the hero, and marks §4 as superseded — but §3 and §5 still stand with full contents and no marker

### C5. The connector claim is now half false

`website-brief.md` → Section connectors: *"**Copy lives in Figma only.** The home- and menu-page connector wording isn't in any project file yet."*

`connector-copy.md` exists and is the designated home — but its three tables are empty and it says so: *"Copy has not been transcribed from Figma yet."* So the second sentence is still true; the first is not, and the brief doesn't mention the file at all. One-way link.

**And the brief quotes a connector that file warns is misread:** the brief's example list says *"yummy morning"*; `connector-copy.md` says *"Do not reconstruct it from screenshots … one word read as 'yummy morning' is in fact `YUMMY MORNINGS`."*

### C6. Broken and drifting cross-references

All 33 numeric `§` references resolve correctly. These don't:

- `design.md` §7 lists the ratio set as five and **omits 4:1**, which the brief added in Aug 2026 and calls *"six fixed ratios"*
- `website-brief.md` cites *"the About chapter rail"* twice; `about-page-copy.md` has no chapter rail — it has a word cloud, quote wheel, timeline divider, counter ledger and stamp strip
- `website-brief.md` cites *"the one-primary-per-view rule"* — no such rule exists in either spec. Nearest is `design.md` §6's *"One focal point per view"*, which is a different claim
- `website-brief.md` → To confirm: *"(see note below)"* — it's the last bullet of the section; there is no note below
- Sunday status line claims it *"rhymes with SPOTLESS in the About word cloud"*; About specs the cloud as *"Real Russian review vocabulary (уютно, душевно, как дома…)"* and doesn't enumerate it — an English SPOTLESS isn't in the specced source
- **Numeric drift from duplication:** the brief rounds `design.md` §2.5's measured figures upward — 11.82 → *"12:1"*, 15.27 → *"≈16:1"*

### C7. Duplication with drift — five cases

| Content | Canonical | The redundant copy |
|---|---|---|
| Guest-perspective voice rule | `design.md` §1.1 (promoted Jul 2026) | `visit-page-copy.md` says *"this section defers to it"* and then keeps a full divergent copy; `connector-copy.md` restates it again |
| Connector rules | `website-brief.md` → Section connectors | `connector-copy.md` declares itself copy-only, then reproduces six rules |
| Contrast figures | `design.md` §2.5 (the only measured source) | `website-brief.md` ×2, both rounded |
| Perks / house facts | The ACF house-facts repeater in `visit-page-copy.md` | About's `perk entries` model + Visit's retained table |
| Hours | The ACF hours page per `website-brief.md` → State model | `visit-page-copy.md` hours block; `sweet_pepper_bar_brief.md` (known stale, fix already prescribed and unexecuted) |

### C8. Smaller factual corrections

- **Berry vs Blueberry cheesecake.** `about-page-copy.md` (guest-facing) says *"berry cheesecake"*; the menu says **Blueberry cheesecake** in both languages. `menu-hero-copy.md` gets it right. A guest can't find the dish About names
- **"Cherry smoothie" doesn't exist.** `menu-hero-copy.md` caption names it; NO BUZZ has exactly two smoothies, neither cherry — a direct breach of that file's own rule (*"Dish captions use real menu items"*)
- **`Тарараса Мерло` vs `Tarapaca Merlot`.** The RU wine list disagrees with the EN list *and with its own file's cocktail spec*, which says Tarapaca. A transcription error
- **Business lunch is described as a set, priced à la carte.** `menu-hero-copy.md`: *"salad, soup, a hot dish and a drink"* — the menu lists individually priced items with no combo price
- **Lunch "50% off drinks"** covers five named soft drinks with a hot dish, not "drinks"
- **The 3+1 fine print is EN-only** — *"all four must be the same flavour; Our Advocaat excluded"* has no RU twin. A material commercial condition in one language
- **Amex**: brief says accepted; Visit flags that foreign-issued cards generally don't work in 2026 RU
- **Beer prices and average spend in `sweet_pepper_bar_brief.md` are stale** research-era figures (170–240 ₽ vs an actual 225–450 ₽ range)
- **A third of the brief's "signature dishes" aren't on the menu** — no burgers, pizza, nachos, Ossetian pies or honey-mustard chicken
- **A "night menu" is promised** in Visit copy and exists in no menu file
- **"Quietest 12:00–16:00"** in Visit contradicts the brief's own business-lunch segment and the menu's dedicated lunch offer for that window
- **Telegram** appears in `design.md` §5.2's icon list; Visit confirms *"No Telegram"*
- **Landmarks:** copy names two (Elijah 350 m, Kazan 250 m), the build lists six, About substitutes the Monument for the Convent
- **Vegan and gluten-free** are claimed as *"labelled on menu"*; the only dietary marker in 1,389 lines of menu is 🍃 vegetarian — and dietary tags are a specced CMS field
- **Platform ratings** were retired from guest copy; the home teaser still prints *"4.6★ · 1,300+ reviews"*, which is one platform's score presented as a venue rating
- **`menu-en.md` contradicts itself on soups** — front-matter calls it open, its own body and three other docs call it decided

---

## D. The numbers audit

Recomputed from hex values per `CLAUDE.md`'s instruction not to trust the written tables.

**`design.md` §2.5 is accurate.** All eight figures verified to within rounding: Chili/Lemon 3.42, Chili/Lime 2.65, Olive/Lemon 3.68, Olive/Lime 2.85, Peppercorn/Lemon 15.27, Peppercorn/Lime 11.82, Ash/Lemon 6.61, Ash/Lime 5.12. The Aug 2026 re-measurement was done properly and the "Lemon and Lime are not interchangeable" correction is right.

Also verified: Mushroom on Peppercorn 6.37 ✓ · Deep Chili on Peppercorn 2.36 ✓ (correctly called a fail) · Chili on Peppercorn 4.47 ✓ (the corrected figure).

**The Soft Peppercorn claim is right but mislabelled.** `design.md` says *"~12% luminance vs ~8%"* and the brief says *"a ~4-point luminance lift"*. Those are **HSL lightness** values (8.2% and 12.5% — correct), not relative luminance, which is 0.69% and 1.35%. The design intent holds either way (contrast ratio 1.12:1 — texture without contrast, exactly as specified); it's the word that's wrong, and it matters because every other number in these docs *is* relative luminance.

**New findings:** the two failing day tokens (A4) and the colour-blind collisions (A5).

---

## E. What came back clean

So you know what you can trust:

- **Section names and counts** match exactly across `website-brief.md`, `menu-hero-copy.md` and `menu-en.md` — 9 food, 7 drinks, identical order
- **Complete RU/EN dish parity.** Every section reconciles item-for-item; no dish exists in one file and not the other
- **Zero price discrepancies** across all 236 priced rows, including the multi-column ones. `menu-en.md`'s claim that prices are unchanged from the print transcription holds
- **All 33 numeric `§` cross-references** resolve to real sections with the claimed content
- **`design.md` §2.5's contrast table** — measured correctly, corrections applied properly
- **Retired concepts that were retired cleanly:** the mirrored reflection, the Paper wash, Dark Olive. Each has a retirement note and no live references
- **The docs police their own Interaction rule in five places** — the caption label, the edge tab, the Visit scroll-down link, the drawer's Molot line, the Good-to-know badges. The rule's problem (A1) is its absoluteness, not carelessness
- **`design.md` §6 and §7 model the right pointer discipline** — *"live in `website-brief.md` → Grid — not duplicated here"*

---

## Suggested order

1. **`### Section labels` heading** — one line, clears eight broken references
2. **One conversation with Iurii** — hours (B1), address, phone, the invented policies (A6), the perk claims. Everything client-blocked is one call
3. **The rule rewrites** — Interaction rule (A1), colour-block count (A3), ticker leftovers (A2). These are yours alone and they're what an agent will read first
4. **The token decisions** — Olive prices and the day highlight (A4), the colour-blind claim (A5), Caption weight (B5), the responsive rule (B6). All before CSS
5. **Content-model decisions** — item-card anatomy (B2), Bar Snacks (B3), the closed axis (B4), the six undeclared objects (B9)
6. **Then build.** The rest can resolve as their page comes up

Steps 1–3 are an afternoon. Step 2 is the long pole — nothing client-blocked moves without it.
