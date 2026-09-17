# Menu — English copy review

*16 September 2026 · Documentation pass; no theme, Figma, recipe or price changes.*

Working texts: [EN](menu-copy-en.md) · [RU draft](menu-copy-ru-draft.md). Item catalogues remain `menu-en.md` and `menu.md`; this pass covers page-level copy and a few clearly identified rows, not a retranslation of every menu item.

## Sources and scope

Reviewed `menu-hero-copy.md`, `inc/menu-sections.php`, the menu hero/rail, section templates, pairing station, item catalogues and `website-brief.md` → Menu page. The code contains sixteen hero descriptions: nine food and seven drinks categories. Most section copy is indeed just an eyebrow, category title and occasional offer. No live Figma or rendered-page inspection is claimed here.

Preserve the short category navigation, selected Salads CTA, Desserts eyebrow and Manhattan caption. Keep booking/form wording on hold. Hero/section draft revisions are now in the clean files; existing bindings and historical transcription stay in `menu-hero-copy.md`.

## Horseradish — confirmed source problem

In `template-parts/menu-sections/bar/infusions.php`, the row currently says **Horseraddish** and its description is literally **description**. The English catalogue already spells **Horseradish (Khrenovukha)** correctly, and the Russian catalogue uses **Хреновуха**.

Use the same copy as the Home pass:

- **Horseradish — For the brave — a taste of Yaroslavl's hot side.**
- **Хреновуха — Для смелых — Ярославль с огоньком.**

The clean documents contain the correction. The actual PHP row remains unchanged until the implementation pass. Its prices, portions and spice icons are menu facts, not copy-editing decisions.

Nearby, replace **Fruity gin infusion, premium** with **Gin infused with raspberries**, subject to the already-open recipe check. Keep **Sweet, salty, irresistible.** for salted caramel.

## Light section pass

| Current wording | Working choice | Reason |
|---|---|---|
| Home-Made / Homemade Infusions | House Infusions | Matches the Home working copy. Short rail label remains Infusions. |
| Home-made, since 2014 | Made in-house | Avoids repeating the category and an unresolved year. |
| favorites they finish | Small plates, big favourites | British spelling; no promise that every child finishes a plate. |
| weekdays 12pm – 4pm | Weekdays 12 to 4 | Follows the documented numeral style; exact hours are allowed on this service page. |
| Most other eyebrows | Keep | Fresh & crisp, Shake & stir, Neat or on the rocks and similar short lines already work. |

Distinct headlines **Pepper's Salads**, **Sandwiches & Bagels**, **For Little Peppers** can stay. Don't force a long headline into every short navigation label. Russian equivalents are native phrases, with all lengths still to check in the actual rails.

## Hero descriptions

The clean pair gives one short paragraph per category. Main changes:

- Breakfast keeps the documented all-day/same-price premise, removes “we understand” and “for next to nothing.” The breakfast offer belongs in its own conditional line.
- Lunch no longer promises thirty-minute service or implies a compulsory set. The source rows are separately priced: “put together your weekday lunch” fits that better.
- Snacks returns to concrete sharing language. Salads loses “the vegetarian ones aren't an apology”; guests need an appetising choice, not a defence.
- Sandwiches loses “like we mean it”; Hot Dishes loses “the serious half,” which diminishes other food, and the unqualified all-day promise.
- Kids removes the under-14 restriction and guaranteed-finished-plate language from the hero. An actual age policy, if intended, should be confirmed separately.
- Infusions drops the unsupported pressure of “the deal knows you won't stop there”; the flavour range does the selling.
- Cocktails, Wine and Tea & Coffee keep their core invitation without making every paragraph carry a changing promotion. The documented offers remain available in a separate copy table.
- Beer retains the bell anecdote from the existing source; confirm the bell is still present at final review.
- No Buzz keeps its name and flavour-led voice. It doesn't need a claim about how designated drivers drink.

These are proposals, not a change to availability or a revocation of documented offers. `menu-hero-copy.md` records the owner's/Kostya's July offer decisions; those are source evidence. The final menu pass should reconcile them with later unresolved schedule notes instead of inventing new restrictions or silently broadening eligibility.

## Offers — keep the conditions with the promise

The infusions section currently says “Order 3 infusions, get the 4th free!” without the documented **same flavour** condition and **Advocaat exclusion**. Carry both into the working text. Don't change the recipe/price tables.

Keep the lunch discount tied to eligible drinks and a hot dish; don't suggest the whole bill is half price. Keep the takeaway offer scoped to drinks/the bar, not all food. The Wednesday “open bottles” language still needs a clear description of the qualifying servings. The birthday offer and free infusion with selected mains remain as recorded in the source; do not turn them into universal entitlements. No invented date cutoff or event is added.

## Pairing station

Keep **FIND YOUR MATCH!** and **Shake It!**. Use the same modest prompt as About: **Pick a plate — see what the bar suggests.**

The six repeated **The legend of the Kirova street** captions are boilerplate. Use the documented pumpkin story for that dish; use actual dish names for the rest until individual copy has a basis. Don't turn every dish into a claimed local favourite.

Straightforward label edits: **sea buckthorn**, **Jack Daniel's**, **Finlandia vodka**. Use **Ararat brandy** in EN; retain the official Russian menu name rather than treating the two languages as identical product-labelling systems. Serving size remains to confirm.

There are separate content mismatches: the beefsteak's Jack Daniel's label points at a Jim Beam image; the pasta's Jim Beam label points at a wine image. Record these for the pairing review; don't change a drink recommendation to make a photograph look correct. The proposed labels do not approve pairings or add new ones.

## Highlights and item-copy boundary

Use **MENU HIGHLIGHTS** if the selection is evergreen; retain **SUMMER MENU HIGHLIGHTS** for an actual summer menu. The current Gazpacho card references a pumpkin image. Treat that as a data/image check, not a reason to rewrite the recipe. Preserve Manhattan as the selected cocktail caption.

Use **See in {section}** on desktop and the established short **In {section}** on mobile. RU draft links need a real fit check: «В разделе “Десерты”» is longer than its English counterpart.

A few item descriptions deserve a later terminology pass—“A kids portion” → “A child's portion”; “home-made” → “house-made” consistently—but the source catalogues remain intact. Ingredients, allergens, portion units, dietary/spice icons and prices cannot be inferred from a smoother phrase.

## Deliberately outside the rule

A breakfast alternative: **WE DO LATE MORNINGS.** It breaks `design.md` §1.1 by speaking as the venue outside a ticket/status reply. It has warmth and brevity, but **Whenever your morning starts** already delivers that character from the guest's perspective. I would keep the existing eyebrow; no exception is needed here. The alternative is an exploration, not inserted into the clean copy.

## Deferred checks

Final menu names and caption/photo matches; recipes; offer eligibility and serving details; current service times; full EN/RU fit in hero, rails and cards. No connector sequence is revised. Booking copy is held unchanged.

Photo inventory: `sweet-space/light.jpg` and `sweet-space/logo.jpg` are missing from theme assets; no stale or differing matching files. No sync performed.
