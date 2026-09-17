# Menu hero & sections — per-state copy (EN draft)

*Expanded 2026-09-11 against the live Figma variables. English-first; RU versions should be register twins, not literal translations.*

Source: [Sweet Pepper — Figma variables](https://www.figma.com/design/P7jYklzRIIFP8yGawnZPia/Sweet-Pepper-Website?node-id=833-39100&view=variables). The values below began as a transcription of `menuFood` and `menuBar`, including casing and placeholders. Author-approved refinements on 2026-09-11: Salads CTA → `Salads`; Desserts eyebrow → `always room for something sweet` (supersedes the earlier `there’s room for dessert`); Cocktails caption → `Manhattan`. These refinements are recorded here and await propagation to Figma; **the website took the hero values from this file on 2026-09-11** (`inc/menu-sections.php`: `cta_label`, `icon`, `caption`, `description` — Salads reads `Salads`, Cocktails `Manhattan`), so this file and the build agree and Figma is the one still to sync. `Subtitle` (the section eyebrows) was reviewed the same day: Kids, Lunch (`weekdays 12pm – 4pm`, en dash), Desserts and Infusions took the values here; the other twelve already matched. Other strings remain drafts. Review notes are separate from the values. Figma and the website have not been edited in this pass.

> **16 September 2026 — copy refinement:** proposed [EN working copy](menu-copy-en.md), [RU draft](menu-copy-ru-draft.md) and [review](menu-copy-review-en.md) now cover all sixteen hero states, section labels, Horseradish and pairing microcopy. This file preserves the earlier variable transcription and documented offer conditions. The new text is not yet propagated to code or Figma; binding identifiers, prices and recipes remain unchanged.

## Variable map

| Variable | Where it belongs |
|---|---|
| `meal` / `drink` | Existing state string: `meal` in `menuFood`, `drink` in `menuBar`. Preserve the current values; do not assume these are website anchor IDs. |
| `ctaLabel` | Hero commit button: takes the guest to the section being previewed. Category labels follow the current Figma design. |
| `Icon` | Existing icon selector, included for complete variable coverage; not visible copy. Case preserved. |
| `DescriptionHero` | Hero paragraph below the photo: the state's pitch. |
| `imgCaption` | Label on the hero photo; should identify what is pictured. |
| `Subtitle` | Menu section's eyebrow (brow), paired with its heading. Not a second hero description and not the Golos `Body/Subtitle` type style. |

All six variables are recorded for each of the **9 food + 7 drinks modes**. Mode names below match Figma exactly; the section headings keep the brief's navigation names.

**Copy and display guidance.** Hero description target: roughly 20–28 words, with existing longer drafts retained. Check wrapping in the real mobile layout rather than promising two lines. Eyebrows are short Molot phrases; the build currently uses H3 18 at every width (`design.md` §3.3; `website-brief.md` → Section title on phones). Captions use Golos Caption and the shared, inert Lemon label shown in the screenshots; a dark scrim remains an allowed alternative (`website-brief.md` → Image caption label / Menu page → Hero). The old “no pill” note is superseded. A section's wide photo may show a different dish, so its caption must follow that photo rather than automatically reusing `imgCaption`.

## Food states — `menuFood`

### Breakfast

Figma mode: `breakfast`

- `meal`: `breakfast`
- `ctaLabel`: `Breakfast`
- `Icon`: `Coffee`
- `imgCaption`: `Pepper's breakfast`
- `Subtitle`: `whenever your morning starts`

`DescriptionHero`:
> Breakfast doesn't end here — some mornings start at noon, we understand. Same price whenever yours begins, and a glass of bubbles for next to nothing.

### Lunch

Figma mode: `lunch`

- `meal`: `lunch`
- `ctaLabel`: `Lunch`
- `Icon`: `Food`
- `imgCaption`: `Bagel lunch set`
- `Subtitle`: `weekdays 12pm - 4pm`

`DescriptionHero`:
> Weekday lunch, 12 to 4 — salad, soup, a hot dish and a drink. In and out in thirty minutes if you must; no rush if you needn't.

### Bar Snacks

Figma mode: `snacks`

- `meal`: `snacks`
- `ctaLabel`: `Bar Snacks`
- `Icon`: `Cocktail`
- `imgCaption`: `Meat set 2026`
- `Subtitle`: `share with friends`

`DescriptionHero`:
> Built to be the best pair — boards, pickles, wings, and things that hold a drink's hand. The bar has opinions about which drink; ask.

### Salads

Figma mode: `salads`

- `meal`: `salads`
- `ctaLabel`: `Salads`
- `Icon`: `Food`
- `imgCaption`: `The iconic Cobb`
- `Subtitle`: `fresh & crisp`

`DescriptionHero`:
> Big, honest salads — a proper Cobb, a Sicilian with oranges, three Caesars deep. The vegetarian ones aren't an apology.

### Sandwiches

Figma mode: `sandwiches`

- `meal`: `sandwiches`
- `ctaLabel`: `Sandwiches & Bagels`
- `Icon`: `Burger`
- `imgCaption`: `Pepper's chicken club`
- `Subtitle`: `house-made sesame bagels`

`DescriptionHero`:
> Bagels and sandwiches stacked like we mean it — lunch that fits in one hand, built in a kitchen that takes both seriously.

### Soups

Figma mode: `soups`

- `meal`: `soups`
- `ctaLabel`: `Soups`
- `Icon`: `soup`
- `imgCaption`: `Iconic Pumpkin soup`
- `Subtitle`: `warm & comforting`

`DescriptionHero`:
> Signature borscht with salo croutons, pumpkin cream, a mushroom mug — the first course is not negotiable around here.

### Hot dishes

Figma mode: `dinner`

- `meal`: `dinner`
- `ctaLabel`: `Hot Dishes`
- `Icon`: `Wine`
- `imgCaption`: `Yaroslavl-style roast`
- `Subtitle`: `from the kitchen`

`DescriptionHero`:
> Pastas, steaks, the grill, and the roast — the serious half of the kitchen, running all day, garnishes included.

### Desserts

Figma mode: `Desserts`

- `meal`: `desserts`
- `ctaLabel`: `Desserts`
- `Icon`: `Coffee`
- `imgCaption`: `Raspberry Mille-feuille`
- `Subtitle`: `always room for something sweet`

`DescriptionHero`:
> Apple strudel with ice cream, raspberry Napoleon, three cheesecakes to choose between. Save room — or don't, and take one home.

### Kids

Figma mode: `Kids`

- `meal`: `kids`
- `ctaLabel`: `For Kids`
- `Icon`: `Food`
- `imgCaption`: `Home-made nuggets`
- `Subtitle`: `favorites they finish`

`DescriptionHero`:
> For guests under 14 — real food from the same kitchen, smaller plates, kinder prices. Crayons live behind the bar; just ask.

## Drinks states — `menuBar`

### Infusions

Figma mode: `infusions`

- `drink`: `String value`
- `ctaLabel`: `Homemade Infusions`
- `Icon`: `cocktail`
- `imgCaption`: `Berry festival`
- `Subtitle`: `Home-made, since 2014`

`DescriptionHero`:
> Made in-house since 2014 — cranberry to salted caramel to raspberry gin. Start with one; the 3+1 deal knows you won't stop there.

### Cocktails

Figma mode: `cocktails`

- `drink`: `Cocktails`
- `ctaLabel`: `Cocktails`
- `Icon`: `cocktail`
- `imgCaption`: `Manhattan`
- `Subtitle`: `shake & stir`

`DescriptionHero`:
> Classics poured straight and twists poured loud — plus a new one on the board every week. Shaken ten steps from your dinner.

### Wine

Figma mode: `wine`

- `drink`: `Wine`
- `ctaLabel`: `Wine`
- `Icon`: `wine`
- `imgCaption`: `Tonight's red`
- `Subtitle`: `by the glass or bottle`

`DescriptionHero`:
> By the glass or by the bottle, with sherry and vermouth keeping company. Wednesdays the open bottles go 10% off — the loud corner of the quiet list.

### Beer

Figma mode: `beer`

- `drink`: `Beer`
- `ctaLabel`: `Beer`
- `Icon`: `beer`
- `imgCaption`: `Ring for a beer`
- `Subtitle`: `cold & crisp`

`DescriptionHero`:
> Bottled and on tap, cold enough to settle arguments. There's a bell on the counter that says "ring for a beer" — it works.

### Spirits

Figma mode: `spirits`

- `drink`: `Spirits`
- `ctaLabel`: `Spirits`
- `Icon`: `cocktail`
- `imgCaption`: `The bourbon shelf`
- `Subtitle`: `neat or on the rocks`

`DescriptionHero`:
> Whisky by country, tequila, gin and their friends — 40 ml of whatever the evening calls for. The back bar is deeper than it looks.

### No buzz

Figma mode: `No Buzz`

- `drink`: `No Buzz`
- `ctaLabel`: `No Buzz`
- `Icon`: `glass`
- `imgCaption`: `Berry smoothie`
- `Subtitle`: `zero proof, full flavour`

`DescriptionHero`:
> Smoothies, virgin cocktails, lemonades, milkshakes — full bar swagger, none of the proof. Designated drivers drink like kings here.

### Tea & Coffee

Figma mode: `coffee`

- `drink`: `Tea & Coffee`
- `ctaLabel`: `Tea & Coffee`
- `Icon`: `coffee`
- `imgCaption`: `Iconic Pepper's Cappuccino`
- `Subtitle`: `brewed with love`

`DescriptionHero`:
> Espresso to signature teas, first light till last call — the bar's other shift. Anything to go is 10% off, mornings included.

## House offers (source: owner + chef-manager Kostya, Jul 2026)

Feed these into the Hot deals band / `special` tags — the hero copy only hints at them. Kostya's list is an addition to the owner's, not a correction; all of the below are active.

- **All-day breakfast** — breakfast pricing is the same all day (revised Jul 2026: replaces the old "special price till 12" + second-coffee offer). Positioning: "morning starts whenever yours does" — for bar guests whose morning runs late. Paired with a **glass of sparkling (Bio Bio) at a special price** with breakfast. (Both referenced in the Breakfast state copy.)
- **Infusions 3+1** — all four must be the *same flavour*; Advocaat excluded. (Hero copy references the deal without the fine print — the fine print lives in the deals band / infusions section.)
- **Lunch** — 50% off drinks with a hot dish. (Candidate mention for the Lunch state copy once wording is settled.)
- **Free infusion of choice with select mains** — Yaroslavl roast; draniki (classic / bacon & tomato / salmon); borscht; pelmeni (with broth or baked with cheese). Strong candidate for the bar's-note slips on those exact dishes — it's already the kitchen–bar handshake in offer form.
- **Wednesday wine sale** — 10% off open bottles. (Referenced in the Wine state copy.)
- **Birthday** — 10% off *or* a complimentary slice of blueberry cheesecake.
- **10% off everything to go — the whole bar**, not just coffee: wine bottles, cocktails to go (popular in summer and when tables run out). Promote in two moments: tea/coffee-to-go mornings and evening promos. (Referenced in the Tea & Coffee state copy; also a candidate line for the Cocktails/Wine sections and the deals band.)
- **New cocktail every week.** (Referenced in the Cocktails state copy.)

## Review notes — not variable values

- **Unfilled structural values:** `menuBar` → infusions → `drink` and No Buzz → `Icon` still contain `String value`. These are transcribed placeholders, not proposed copy. Resolve their component bindings before assigning replacements. Food icons also merit checking: Soups currently uses `Burger`, Hot Dishes uses `Wine`; food and bar icon values differ in case.
- **CTA versus section name:** Figma uses `Salad Bar`, `Sandwiches & Bagels`, `For Kids`, and `Homemade Infusions`; the brief's nav names are Salads, Sandwiches, Kids, and Infusions. The author approved `Salads` here to avoid the self-service implication of “Salad Bar.” `For Kids` stays: “Kids menu” would repeat “menu” immediately above the mobile “Food menu” section connector. Other labels remain as drawn. The short category CTA also differs from the older “Breakfast menu” example; this is already open in `website-brief.md` → Mobile — Menu page.
- **Bar Snacks remains a working name** (`website-brief.md` → Menu page → Section labels). Its live description now begins “Built to be the best pair”; the previous draft began “Built for the middle of the table.” The previous opening is more concrete and more idiomatic; retain it as an alternative for the next copy decision.
- **Guest-perspective conflict:** Breakfast's “we understand” and Sandwiches' “like we mean it” predate `design.md` §1.1, which reserves the venue's first-person voice for slips and status messages. Preserved here because they remain live Figma copy; review them explicitly rather than silently treating them as sanctioned exceptions.
- **Lunch eyebrow:** current `weekdays 12pm - 4pm` differs from the brief's clockless numeral style (“never AM/PM,” Spice slider → State model). Suggested replacement: `weekdays 12 to 4`. Exact lunch hours are allowed on this service page (`website-brief.md` → The no-clock rule). Breakfast remains all-day; its default preview window is not a service cutoff.
- **Caption accuracy:** the newer Figma selections replace the old Syrniki, bagel, borscht, Old Cuban and flat-white captions. Preserve the new values, but check each against the actual selected photo. The author identified the cocktail as `Manhattan`, replacing “Seasonal Offer!” here in line with `website-brief.md` → Image caption label. “Berry festival” still needs a photo/item check and is not evidence of a new offer.
- **Dessert naming remains unresolved:** Figma says `Raspberry Mille-feuille`; `menu-en.md` says `Raspberry Napoleon`, and the hero description still uses Napoleon. Pick one name and propagate it to the menu and caption together.
- **Separate section photo:** the supplied Bar Snacks section screenshot labels its banner “Pepper's Stuffed Chicken,” while its hero variable says “Meat set 2026.” These are separate image contexts; the section caption is not another value of the hero variable.
- **Offers:** the house-offer list above retains its owner/manager provenance from July. The claims in existing hero descriptions are retained, not newly verified by this transcription. Breakfast sparkling terms still need reconciliation with the home status matrix, which mentions a noon cutoff.
- **RU pass:** match register, not words. Plain section names and the one-voiced-name-per-list rule remain as documented in `website-brief.md` → Menu page → Section labels; eyebrows do not rename the sections.
