# Home — English copy review

Updated 15 September 2026 · Proposal for final copy review · No website or Figma copy changed.

## Author decisions — 15 September

- Keep the current hero headlines for now. The alternative headlines below are parked, not approved replacements.
- Horseradish direction: a playful invitation to Yaroslavl's hot side. Refined candidate: **For the brave — a taste of Yaroslavl's hot side.** This is voice copy, not an invented recipe note.
- Replacing the repeated “THAT'S ICONIC” connectors is agreed in principle; the author will handle the SVG changes. The full proposed connector sequence is still a candidate, not a final selection. *Sep 2026: the full sequence is adopted and built — FOR A WELL-EARNED POUR (Highlights → Bar), FOR A PROPER APPETITE (Bar → Kitchen), MORE THAN A MENU (Kitchen → About); the repeated THAT'S ICONIC is gone.*
- **Do not touch the form, booking copy or interactions now.** Their wording will be reviewed with the final copy. On mobile, the call action is intended to call (and the author reports it does); desktop copying can be useful. The earlier source observation does not establish that all phone surfaces behave alike. Verify each surface at the final implementation pass.
- The copyable booking line is deliberately a lightweight interaction, not an online booking system. A composer with day/time choices was tried and felt like too many actions just to obtain a line to copy. Preserve the existing example now; a composer remains a future possibility. The bracketed request and form rewrites below are parked alternatives.
- Canonical website address: **Kirova 10/25, Yaroslavl**. “Kirova, 10” is a familiar shorthand, not a competing address.
- Email will use **sweetpepper.bar** or **sweetpepperbar.ru** (domains supplied in the screenshot). Domain and mailbox name are not selected yet; don't invent an address.
- All social posts are intentional placeholders. Location-dependent Instagram/VK routing is a future decision; current platform mismatches stay in the final-review backlog.
- Other suggestions received positively; remaining open questions are deferred to the author's final copy pass. This is not an instruction to implement them now.

This is the first page in the page-by-page copy pass. Menu, About and Visit still need their own reviews before the complete Russian default copy is finalised. The original Russian companion, including editorial notes and parked alternatives, is now `home-copy-ru-review.md`. Clean working copies are available in `home-copy-en.md` and `home-copy-ru-draft.md`; neither is approved launch copy.

## Clean-copy consolidation — 16 September 2026

The clean EN retains all four current hero headlines, Community hit! and the adopted connector sequence from `website-brief.md`, ending JOIN THE PARTY. The MAKE YOURSELF AT HOME candidate below is not carried forward. The clean RU mirrors the retained hero meanings and offers «ПРИСОЕДИНЯЙТЕСЬ» for the last connector; all RU wording remains provisional. Unconfirmed service cutoffs are placeholders. Form/booking explanations, the request composer alternatives and phone-status rewrites remain parked here, not promoted into clean copy. Contacts retain the proposed page-level introduction; that does not authorize changing the booking interaction. The food-menu CTA assumes that destination; if routing changes to lunch only, use the specific lunch label from this review. No website or Figma changes.

## Sources and scope

- Live Figma: [linked Home hero and the desktop Home sections below it](https://www.figma.com/design/P7jYklzRIIFP8yGawnZPia/Sweet-Pepper-Website?node-id=175-2214). Visually inspected hero, Highlights, bar/kitchen previews, About and social/contact sections at readable zoom. This was a visual read, not a text-layer export; no claim that every component variant was inspected.
- [Local built Home](http://sweet-pepper-bar.local/): rendered desktop text, link destinations and open booking drawer checked. Mobile-only strings and all four hero strings checked in the theme source; mobile Figma variants were not directly inspected in this pass.
- `report.md`, `design.md`, `website-brief.md`, `connector-copy.md`; relevant menu entries in `menu.md` / `menu-en.md`, history/context in `about-page-copy.md` / `sweet_pepper_bar_brief.md`.
- Build sources: `sweet-pepper-theme/front-page.php`, `src/js/daypart-engine.js`, `src/js/reserve-drawer.js`, `src/js/contact-form.js`, and the contact form, reserve drawer and mobile drawer template parts.

## Editorial direction

Keep the appetising, slightly rough voice. “YUMMY MORNING!”, “SHAKE & COOK” and “STEAL THE LINE” already have character. The bigger problem is repetition: Highlights, About and Events all tell the Tabasco origin story. Give each a job: something to order → something to drink → lunch → why this place → what's happening → how to visit.

Guest perspective follows `design.md` §1.1. This needn't mean inserting “your” into every label: plain menu names and direct invitations serve the guest too. House “we” remains in ticket replies/status messages. EN and RU should sound equally at home, without preserving each other's idioms.

Use sentence case for buttons and dish names. Display capitals remain a typography treatment. Prefer “favourites” / “favourite” consistently; this is an editorial proposal, not an existing brand rule. Use “Food menu” and “Drinks menu” for the two contents, matching the menu's FOOD / DRINKS doors; keep “kitchen” and “bar” in descriptive copy.

## Home section proposals

### 1. Hero

**On hold:** keep all current headlines. The proposed headline column is retained only as an exploration record.

Keep desktop eyebrow **SHAKE & COOK · YAROSLAVL**. Keep **Reserve** for the compact action. The drawer should explain that a booking requires a reply; opening it is not a confirmed reservation.

| Selection | Current headline | Proposed headline | Proposed evergreen body | Desktop menu CTA |
|---|---|---|---|---|
| Breakfast | YUMMY MORNING! | **YUMMY MORNING!** | Coffee, eggs and a good reason to get out of bed. | Breakfast menu |
| Lunch | PUMPKIN SOUP TIME! | **LUNCH LOOKS GOOD** | Soup, something hearty, a little break in your day. | Lunch menu |
| Dinner | READY FOR TONIGHT? | **READY FOR TONIGHT?** | Comfort food, cocktails and a table for your kind of evening. | Dinner menu |
| Party | IT'S COCKTAIL TIME! | **MAKE A NIGHT OF IT** | Start with your favourite cocktail. See where the evening goes. | Drinks menu |

These are selection-led invitations, not statements that service is currently available. They avoid “Kitchen is on” when a visitor browses dinner in the morning. The live service status is a separate conditional sentence within the existing body area; no new visual component is required. Phone copy must fit the existing short hero — review the longest body + status together after approval.

The pumpkin soup is documented as a permanent favourite, so it is not necessarily about to disappear; the reason to broaden the headline is that the tile represents all lunch. “Lunch's till 4” → “Lunch till 4”; “bar offers on the go” means takeaway/mobility in English, not offers currently running. Remove “best price” unless a specific comparison is intended and supported.

**Service-state copy needs the actual model before launch.** The brief specifies beginning/full swing/last call/off-hours/closed, weekday/weekend/holiday, brunch, and Sunday opening. The build currently has four fixed strings, uses the visitor's local hour, and does not implement that full matrix. At 16:30 it still selects Lunch although the copy says lunch ends at 4. A wording edit cannot fix this.

Conditional examples, to reconcile with `website-brief.md` → Status lines after hours are confirmed:

| Condition | Proposed status |
|---|---|
| Breakfast genuinely available all day | Breakfast stays all day. |
| Confirmed breakfast sparkling offer | Breakfast stays all day. The Bio Bio Bubbles offer ends at noon. |
| Weekday lunch available | Weekday lunch till 4. |
| Weekend lunch-tile selection | Weekend brunch — take your pick from the full menu. |
| Dinner actually available | The kitchen's on — take your time. |
| Kitchen approaching confirmed close | Still time to eat — kitchen orders till 1:30. |
| Venue closed | Closed for now — back at {next opening time}. |
| A selected offer is unavailable | {Offer} returns {next service day/time}. |

These examples are not a replacement for the full approved state matrix. Exact cutoffs fit the documented guest-anxiety exception to the no-clock rule; don't add countdowns. Resolve next opening in Yaroslavl time from the same hours as the footer. Never display a Now marker that implies the venue is open when it is closed.

### 2. Highlights

Current Figma and build: **YOU CAN'T MISS IT / PEPPER'S SPECIAL & COMMUNITY HITS**, followed by the origin story.

Proposed:

- Eyebrow: **A GOOD PLACE TO START**
- Headline: **HOUSE SPECIALS / & LOCAL FAVOURITES**
- Body: **A little sweet, a little heat. Start with house infusions, grilled wings or Pepper's pot roast.**
- Buttons: **Drinks menu** · **Food menu**

“Specials” fixes the singular possessive ambiguity; “local favourites” is more natural than “community hits.” The shorter, dish-led intro works at both widths and addresses the brief's concern that mobile visitors must scroll past too much prose before seeing food. “Local favourites” relies on the existing community/favourites positioning; if these three aren't the actual favourites, use **HOUSE PICKS / FOR YOUR TABLE** instead.

| Card | Proposed name | Proposed description | Note |
|---|---|---|---|
| Infusions | House infusions | From cranberry to raspberry gin. | “Seasonal hits” only for genuinely seasonal items; otherwise remove the tag or use the established favourite label after confirmation. |
| Wings | Grilled wings | Honey-glazed wings with sour cream, carrot and celery sticks. | Confirm sour cream is served alongside rather than part of the glaze. |
| Roast | Pepper's pot roast | Pork, potato wedges and vegetables in a spicy cream sauce. | “Pot roast” fits the documented жаркое в горшочке better than bare “roast”; keep the official RU dish name. |

Prices and dietary/spice labels are menu data, not editorial decoration. Keep them out of the prose approval and confirm them against the current menu separately. A category card displaying 150 while raspberry gin costs 190 should say **From 150 ₽**, if 150 remains the minimum; confirm serving size too.

### 3. Bar preview

**HOME MADE INFUSIONS** → **HOUSE INFUSIONS**. It gives the section and card one name and avoids the “homemade/home-made” distraction.

| Current | Proposed |
|---|---|
| Salted Caramel — Sweet, salty, irresistible. | **Salted caramel — Sweet, salty, irresistible.** |
| Horseraddish — desription | **Horseradish — For the brave — a taste of Yaroslavl's hot side.** Candidate refined from the author's 15 September direction; replace the placeholder in the final copy pass. |
| Raspberry Gin — Fruity gin infusion, premium. | **Raspberry gin — Gin infused with raspberries.** Confirm actual preparation before treating this as final. |
| See the full bar card | **Explore the drinks menu** |

The caption **Community hit!** was explicitly retained in the brief's Mobile — Bar & Kitchen previews section. Candidate **A local favourite** reads more naturally in English, but changes that recorded decision; author choice before propagation.

### 4. Kitchen preview

**FAMOUS LUNCH MENU!** → **YOUR LUNCH SORTED**. “Famous” is a boast; the replacement gives the same space a practical, warm purpose.

- **Pumpkin soup — Creamy pumpkin soup with chicken.** The current row has a vegetarian icon despite saying chicken. The menu docs list chicken and vegetarian versions separately. Resolve the actual row, price and icon together; do not simply delete chicken from the description.
- **Quesadilla — Chicken and cheese, or double cheese.**
- **Beef patty bagel — A beef patty, vegetables and pickles in a house-made bagel, with potato wedges and sauce.** Confirm the bread and official name; the existing copy says “buns” while the title/photo identify a bagel.
- CTA: **Explore the food menu**. If it goes specifically to Lunch, label it **See the lunch menu** instead.

### 5. About preview

Keep **THE PEPPER STORY / SHAKE & COOK / SINCE 2014**, with the year held for confirmation because the local About field reportedly says 2018.

Proposed body:

> From Tabasco Bar next door to Sweet Pepper: the same edge, a warmer welcome. A proper meal and a good drink belong at the same table — yours.

This keeps the origin here, removes “a kitchen finally worth showing up for” (which dismisses the earlier kitchen), and drops the unsupported city-wide comparison “one of the only places.” It keeps the kitchen/bar equality at the heart of the brand.

Keep **Read the full story**. Change **5.0 Yandex Rate** to **{verified rating} on Yandex**; the number needs a fresh source before publication. The About copy doc contains a different rating. Avoid an ageing **12 years** chip: use **Since {confirmed year}**, or drop it because the headline already says it.

### 6. Social entrance

Figma and build repeat the origin story below **NEWS, PARTIES, PROMOS**. The launch brief calls for an evergreen social entrance, not a pretend event feed.

- Eyebrow: **MAKE YOUR NEXT PLAN**
- Headline: **WHAT'S ON / AT PEPPER**
- Body: **Your next night out starts here. Check VK for news, parties and specials, or take a look on Instagram.**
- Buttons: **See what's on VK** · **View Instagram**
- Final link tile: **More on VK**

“Follow” opens a profile; it doesn't follow the account. The proposed labels describe the immediate action. Retire the repeated “Live DJ Set: Friday Night” and dynamic “Today!” placeholder before launch. Use the documented evergreen photos and social exits, or actual dated posts when supplied. Don't invent replacement events.

### 7. Contacts

- **FIND US IN THE HEART OF THE CITY** → **YOUR NEXT STOP: KIROVA** (guest perspective; no disputed building number in the eyebrow).
- Keep **SEE YOU SOON?**
- Desktop body: **Drop in, or arrange a table by phone or message. Planning a Friday or Saturday evening? Book ahead.**
- Phone body: **Drop in, or book ahead for Friday and Saturday evenings.**
- Social buttons: **Message on VK** · **Message on Instagram** (must point to messaging, not a mismatched profile).
- Directions heading: **Your route to Pepper**; action **Get directions**.
- **Copy Address** → **Copy address**. Feedback **Address copied**.
- **Looking for more? / Parking, city sights, directions, hours: / Visit Page** → **PLAN YOUR VISIT / Hours, parking and the way in. / Plan your visit**.

Remove unconfirmed response promises: the page currently says same day, the phone version says 20 minutes, and the form says 24 hours. Different channel promises could be valid, but must come from the team rather than from three templates.

## Shared booking, navigation and form copy

**Form/booking proposals parked by the author, 15 September.** Keep the existing copy and lightweight interaction now. Read the table as earlier alternatives for the final copy review, not an implementation checklist. Mobile calling and desktop copying may deliberately differ; a date/time composer remains future work.

| Surface | Recommended EN | Condition / rationale |
|---|---|---|
| Booking title | Your table | Keep. |
| Booking explanation | Call or send a message to arrange your table. Your booking is confirmed once you hear back. | Clarifies what Reserve actually does. |
| Ticket heading | Steal the line | Keep the character. |
| Copyable request | Hi! Could I book a table for [guests] on [date] at [time]? | Avoid silently copying “two, tomorrow, 21:00” as the guest's real booking. |
| Ticket helper | Add your details, then send by message. | The copy button does not send anything. |
| Ticket action / feedback | Copy message / Message copied | Specific action and result. |
| Phone button as currently implemented | Copy phone number | It copies; it does not place a call. Prefer a real “Call {number}” link on phones if implementation changes. |
| Open phone status | We're open — call or send a message. | Only if hours are correct; does not claim a staff member is available. |
| Busy status | It can get loud — try a message if there's no answer. | A time-based guess must not assert a live “Full house.” |
| Closed status | We're closed — back at {next opening time}. | Sunday's opening must not be overwritten by 8:30. |
| Home drawer description | A taste of Sweet Pepper | Replaces “What's on now & what to know.” |
| Menu drawer description | From breakfast to late-night drinks | Fixes singular “late drink.” |
| About drawer description | The place, the people, the story | More concrete than “philosophy.” |
| Visit drawer description | Hours, directions and contacts | Removes “all the.” |
| Form helper | Choose how you'd like a reply. | Replaces “Please, pick the preferred contact method.” |
| Submit action | Send message | Describes the action. |
| Form success title | Message sent | Only after confirmed server delivery. |
| Form success body | Your message is with the team. Expect a reply by your chosen contact method. | Proposed future copy; “inbox” is wrong for a phone reply. |
| Form failure | Your message couldn't be sent. Try again, or contact the bar by phone or message. | Requires an actual failure state. |
| Required errors | Enter your name. / Enter a valid email address. / Enter your phone number. / Enter a message. | Short, useful, consistent. |
| Footer | Home · Menu · About · Visit; Hours; Back to top | Keep the useful plain labels. |
| Language prompt | Prefer English? Switch to English → | Candidate for the RU default when English preference is detected. On EN: «Удобнее по-русски? Переключить →». |

The form currently goes straight to a success state without sending a request. Until the backend exists, hide it from a public launch or explicitly label a demonstration; do not ship “Message sent.” No form was submitted during this review.

## Connectors: review the whole run

Build inventory, taken from template alt text/asset references (not a Figma text-layer transcription): **AT SWEET PEPPER → MORE FROM MENU → THAT'S ICONIC → THAT'S ICONIC → SEE WHAT'S NEW → JOIN THE PARTY**.

Candidate run, each pointing forward as the Home rule requires:

| Seam | Proposal |
|---|---|
| Hero → Highlights | AT SWEET PEPPER |
| Highlights → Bar | FOR A WELL-EARNED POUR — selected |
| Bar → Kitchen | FOR A PROPER APPETITE — selected |
| Kitchen → About | MORE THAN A MENU |
| About → Social | SEE WHAT'S NEW |
| Social → Contacts | MAKE YOURSELF AT HOME |

The bar/kitchen English pair is selected: **FOR A WELL-EARNED POUR / FOR A PROPER APPETITE**. The longer kitchen line replaces COME HUNGRY because scaling that short phrase to container width makes the connector too tall. RU remains provisional: **ДЛЯ НАСТРОЕНИЯ И АППЕТИТА / ПЕРЕКУСИТЬ И ЗАКУСИТЬ**. Other rows remain candidates. The author handles the SVG exports; no build or Figma changes made here.

## The deliberately wrong version

**WE SAVED YOU A SEAT.** Use as the contact headline instead of “SEE YOU SOON?”

It deliberately breaks `design.md` §1.1: a normal section heading speaks as “we,” outside the ticket/status registers. It is warmer and more immediate, and the idea earns a test. But the literal promise suggests a table is already held, which this booking flow cannot support. My call: **don't grant this exception on Home**. A ticket reply **We've got a table for you** earns it after a real booking confirmation — exactly where the system already permits house voice.

## Decisions and discrepancies to carry forward

1. Address settled: **Kirova 10/25, Yaroslavl**. Founding year remains for final review. Email will use **sweetpepper.bar** or **sweetpepperbar.ru**; mailbox and final domain remain undecided. Social handles means account usernames (for example, `barsweetpepper`), which differ from choosing whether to send a guest to Instagram or VK; verify both in the future routing pass.
2. Confirm all-day breakfast, Bio Bio Bubbles terms, weekday lunch hours, weekend/brunch model and kitchen closing by day. Preserve current prices only as draft data.
3. Reconcile menu-button destinations: `#menu`, `#bar-menu`, `#kitchen-menu` have no corresponding Home targets. Hero changes its label but not its destination. Copy and links need one implementation pass after the route choice.
4. Reconcile actual event source and destination. Built cards announce Instagram but open VK; “Today!” is generated from today's date on a placeholder Friday event.
5. Review proposed wording before making it default. Then apply the EN/RU pair to Figma, fields/templates, JS states, labels, alt text and connector exports together; test both languages on a phone and desktop.
6. Next page passes: Menu (including item terminology and state copy), About (history, claims and long-form voice), Visit (hours/status/directions), then consolidate the approved Russian default document.

### Photo sync check

78 source files, 76 theme files; all existing matching files have identical content. Missing from theme: `sweet-space/light.jpg`, `sweet-space/logo.jpg`. No stale theme files. No sync performed; the project's image-sync instruction requires confirmation before copying.
