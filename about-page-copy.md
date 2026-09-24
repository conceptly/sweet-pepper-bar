# About — English working copy

*Consolidated 16 September 2026 from the current page, `about-copy-review-en.md` and the author's decisions. This is the working copy for final review, not a record of published changes.*

**Selected wording:** Step-free · IN THE HEART OF THE CITY *(23 Sep 2026; was IN THE VERY HEART OF THE BEST CITY)* · WANT TO JOIN THE FAMILY?

The proposed revisions are incorporated below. Factual checks and a few conditional labels remain explicitly marked; they do not need to be resolved now. Forms, booking copy and interactions stay unchanged. No build or Figma changes are part of this update.

**Page order:** Hero → Concept → How it feels → Perks → Story → Guests → Team → Careers → Location → Entrance photo → Visit.

Brand voice follows `design.md` §1.1; component behaviour and layout follow `website-brief.md`. The [previous document](docs/archive/about-page-copy-before-consolidation-2026-09-16.md) preserves historical copy, the Home teaser and component explorations. Its retired Mission / Photo Library sections and old page order are not current instructions. Home copy is outside this pass.

## 1. Hero

**Eyebrow:** KIROVA ST. 10/25, YAROSLAVL

**Headline:** SHAKE & COOK SINCE {confirmed year}

**Lead:**

A proper meal, a favourite drink and a place to settle in. Get to know the people, the stories and the room behind Sweet Pepper.

**Section navigation:** Food & drink · Story · People · Careers · Location

*Final review: Figma/default copy says 2014; the inspected local field says 2018. Keep the headline wording and settle the year later. Check the longer Food & drink label on mobile. People leads to Guests, followed by Team.*

## 2. Concept

**Eyebrow:** BAR × KITCHEN

**Headline:** YOUR LOCAL GASTROBAR

**Body:**

Eggs and coffee, a proper lunch or a cocktail with something to share. Here, the kitchen and bar belong at the same table. Every dish has a drink to go with it — with or without alcohol.

**CTA:** See the full menu

### Pairing picker

**Heading:** TRY IT YOURSELF

**Prompt:** Pick a plate — see what the bar suggests.

**Result label:** Your match

**Random-pick control:** Shake It!

**Accessible control label:** Pick a random dish

**Drink CTA:** See this drink

**Item-level copy:**

- Pumpkin soup: Started as a special. Stayed by popular demand.
- Local-favourite label, only where supported: A Kirova Street favourite
- Drink names: A shot of Finlandia vodka · A glass of Ararat brandy · A shot of sea buckthorn infusion

*Bar-reply draft, not an attributed quotation:* “I'd put a shot of Finlandia beside that.” Use only for the matching, bar-approved pairing. Do not create new pairings through this wording pass.

*Build note, 18 Sep 2026: the About picker now shows the menu page's six pairings from one shared list (`inc/pairings.php`, author's call), so the item-level copy above is **not on the page at the moment** — the shared list still carries the menu's draft wording ("The legend of the Kirova street" on all six; "A shot of the Finlandia"). Open: move the reviewed wording into the shared list, and settle Chicken Pasta's drink (this doc: Ararat brandy; the menu list: Jim Beam on ice — and Ararat is on the wings there).*

*Final review: confirm official dish names (including Pepper Roast / Yaroslavl Roast), serving terminology and each pairing. The current three-pairing implementation is distinct from earlier plans for 4–6 chips and daypart sets; this copy update does not expand the feature.*

## 3. How it feels

**Eyebrow:** IN YOUR WORDS

**Headline:** HOW IT FEELS

**CTA:** Add your word

**Optional helper, only if the interaction needs it:** Pick a word. Read the story behind it.

**Source label:** Russian original

**Source-link label:** Read the Russian original

Use the Russian originals and faithful English translations in `about-reviews.md`. Preserve guest wording, including reservations; do not rewrite quotations as marketing copy. The older Figma samples are not the current quote pool. Word-cloud vocabulary must remain connected to the source reviews; frequency claims require an actual tally.

*Component note: retain the current field layout and source-linked quote interaction. The five-second demo heartbeat ends for the visit after any interaction; the eight-second release resets visuals only, not autoplay. Reduced motion retains manual interaction. See `website-brief.md` for current sizing, quote-pool and motion decisions; archived layout candidates are not new requirements.*

## 4. Perks

**Eyebrow:** WHAT TO EXPECT

**Headline:** BEYOND SHAKE & COOK

| Compact stamp label | Expanded title | Detail |
|---|---|---|
| Wi-Fi | WI-FI & POWER | Plug in, get comfortable. Wi-Fi and power sockets are available, with chargers at the bar. |
| Kids | KIDS' MENU & ACTIVITIES | A menu for smaller appetites, colouring books and cartoons at weekends. |
| Dogs | DOGS WELCOME | Your dog is welcome too. Water bowls are on the house. |
| Terrace | SUMMER TERRACE | Take your drink outside and settle into a swing chair. |
| Your way | JUST THE WAY YOU LIKE IT | Something to leave out or add? Ask the team about making it your way. |
| Step-free | STEP-FREE ENTRANCE | A step-free way in, with a ramp and help from the team if you need it. |

**Step-free is the selected label inside the circle.** The expanded access title is separate and remains a working proposal. The other compact labels above are the proposed shorter set; if longer labels are retained, use Dog-friendly rather than Dogs Friendly.

**Off-season replacement for the Terrace slot:**

- Expanded title: SEASONAL MENU
- Detail: A little of the season on your plate. Take a look at the latest dishes.

*The seasonal swap is controlled by the team, not an automatic date assumption. Keep the six-stamp interaction and expanded detail line. Facilities—including the entrance/ramp, chargers, activities and bowls—remain in the final factual check. “Step-free” describes entrance access; it is not a claim about every facility.*

## 5. Story

**Headline:** THE PEPPER STORY

**Body:**

Before Sweet Pepper, there was Tabasco Bar on Kirova Street. The next chapter kept the edge and added warmth, with a kitchen given as much care as the bar.

The name says it: still pepper, a little sweeter. Breakfast, lunch and cocktails became parts of the same place, with room for an ordinary Tuesday as well as a big night out.

The regulars helped shape what followed. Pumpkin soup, berry cheesecake and berry korzhik started as seasonal specials. Guests kept asking for them, so they stayed. Some of the best things on the menu are there because someone didn't want to say goodbye to them.

*Keep the three-paragraph structure. On mobile, the timeline sits between paragraphs one and two; the naming sentence intentionally opens paragraph two. No separate Mission section is introduced.*

### Founder card

**Quote — retain verbatim:**

> The main thing is to always know your limit. Otherwise you might drink less.

**Confirmed Russian wording:**

> Главное — всегда знать свою меру. Иначе можно выпить меньше.

**Working attribution:** Iurii Primyshev · Founder, still behind the bar

*Removing CEO is an editorial proposal, not a correction to his role. Retain the candid founder photograph and overlapping quote-card treatment. Store the supplied locale versions separately; do not machine-translate the joke.*

### Timeline

| Year — pending final confirmation | Label | Supporting line |
|---|---|---|
| 2009 | TABASCO BAR | Where the heat started |
| 2014 | SWEET PEPPER | Kept the heat, made it delicious |
| 2026 | STILL HERE | Same table, probably yours |

### Counter ledger

**Heading:** TWELVE YEARS, COUNTED IN ORDERS

**Labels:** cappuccinos served · pumpkin soups served · salted caramel shots poured

**Qualifier if the figures are estimates:** Kitchen estimates

*Keep the deliberate words-versus-digits treatment in the heading. Confirm the duration alongside the founding year, and use kitchen-approved figures only. This pass supplies no new numbers or motion decisions.*

## 6. Guests

**Working eyebrow:** GOOD TO SEE YOU AGAIN

**Headline:** THE DREAM GUESTS

**Body:**

Some faces have been here since the early days; others are here for the first time. Together, they make the place. Take a look through the nights, celebrations and familiar faces — you might spot yourself.

**CTA with the VK mark:** Browse the photo albums

**Standalone CTA:** Browse albums on VK

**Album-caption copy:** 12th Bday! · 9th Bday! · Valentine's 2025 · Teachers' Day · Bartenders' Day · Halloween 2025 · Halloween 2023 · Mexican Party

*Keep the short birthday labels chosen for mobile. Match dates and titles to the actual albums; check Valentine's 2025 in the narrowest tile without shrinking established caption type. Retain the current VK destination. No separate photo archive or location-dependent social routing is introduced.*

## 7. Team

**Eyebrow:** THE ONES WHO KNOW YOUR ORDER

**Headline:** THE DREAM TEAM

**CTA — unchanged:** Write to the team

**Photo-strip ending:** To be continued…

The portraits and group-photo strip carry this section; no additional body paragraph is needed.

**Card-label guidance for final review:**

- Front of house replaces Floor where it accurately describes the role.
- Head bartender replaces Bar chef only if that is the actual role.
- Unforgettable waiter stays if Stas likes it.
- A word from {name} suits a general personal message; My pick suits a recommendation. Match the label to what the interaction reveals.

Lera's existing line is documented as real and should remain verbatim. The other seven staff lines are layout placeholders: retain their placeholder status until the people supply their own words. Do not turn drafted lines into apparent quotations. Staff roles, tenure and reused portraits remain for final review. The team-contact dialog and its wording stay unchanged.

## 8. Careers

**Eyebrow:** WORK AT SWEET PEPPER

**Headline — selected:** WANT TO JOIN THE FAMILY?

**Intro:**

A small team, familiar faces and room to learn. Take a look at the roles below — or get in touch about the work you'd like to do.

“Family” is intentional: a local joke and a description of the atmosphere, rooted in relationships formed here. Keep that specificity in later revisions. The personal stories supplied as context are not publication-ready testimonials.

### Draft role-card copy

These are wording examples for the existing placeholders, not confirmed vacancies.

| Role | Description |
|---|---|
| Floor manager | Keep service running smoothly, support the floor team and make every welcome count. |
| Cleaner | Help keep the rooms ready for the next guests, from the first table to the last detail. |
| Sous-chef | Support the chef, keep the kitchen organised and help every plate leave as it should. |

**CTA to a listing:** View role on hh.ru

**CTA only when the destination starts an application:** Apply on hh.ru

*Confirm roles, pay, hours and links later. If a confirmed schedule is 2/2, explain it as two days on, two days off for English readers.*

### Speculative application

**Heading:** No opening with your name on it?

**Body:** Send a little about yourself and the work you'd like to do.

**CTA:** Send your CV

### No-openings state

**Heading:** NO OPEN ROLES JUST NOW

**Body:** Interested in a future role? Send your CV and a little about the work you'd like to do.

*These are page-level copy proposals, not changes to a form or dialog. The mailbox and domain remain unselected; candidates are sweetpepper.bar and sweetpepperbar.ru. Do not invent an address or promise a response.*

## 9. Location and entrance

**Eyebrow:** YOUR DESTINATION

**Headline — selected:** IN THE HEART / OF THE CITY *(author, 23 Sep 2026: "very" and "best" dropped so it holds two lines; was IN THE VERY HEART OF THE BEST CITY)*

**Body:**

Your stop on Kirova Street: 10/25, in Yaroslavl's pedestrian centre. Two rooms with their own character, plus a summer terrace with swing chairs. A place to pause between a walk through the city and whatever comes next.

**CTA:** Get directions

**Entrance-photo caption:** The way in

**Canonical address:** Kirova 10/25, Yaroslavl

**Russian address:** Ярославль, ул. Кирова, 10/25

**Selected Russian headline direction:** В самом сердце любимого города

*“Very” and “best city” preserve the affectionate local joke. Use In rather than At. The alternative caption Entrance on Kirova Street is available only after confirming the entrance's position. Address 10/25 is settled, not an open question.*

## 10. Closing invitation — held unchanged

**Headline:** COME SIT WITH US

**Body:**

The room is small and fills up — book ahead for evenings and weekends. Or just walk in and take your chances; the bar seats are for exactly that.

**CTAs:** Get your table · See the menu

Booking drawer, team-contact form, call/copy controls and copyable booking request stay unchanged until final review. Mobile calling versus desktop copying is contextual. There is no online booking system now; the date/time composer remains a future possibility.

*Voice-rule issue retained for final review: COME SIT WITH US is an established invitation outside the first-person registers in `design.md` §1.1. Keeping it is the current hold decision, not a claim that the wording satisfies that rule. Resolve/document the narrow exception when reviewing the final copy.*

## Connectors — retain the current sequence

1. BETTER TOGETHER
2. WORD OF MOUTH
3. LITTLE THINGS MATTER
4. BACK TO THE FIRST POUR
5. IN GOOD COMPANY
6. THE USUAL SUSPECTS
7. ROOM FOR ONE MORE
8. MAKE YOURSELF AT HOME
9. NOW IT'S YOUR TURN

No alternative connector or export change is adopted in this pass. The longer final line preserves the author's proportion decision.

## Final-review queue

- Founding year, timeline dates, duration and counter figures.
- Official dish/drink names, servings and approved pairing replies; English name for berry korzhik.
- Facilities and precise entrance-access details.
- Real staff lines, roles, tenure and portraits; actual vacancies, schedules and application links.
- Final email mailbox/domain and social destinations; placeholder content remains intentional.
- Guest quotations reconciled to `about-reviews.md`, with actual sources, dates and links.
- Mobile fit of navigation, paragraphs, stamp details, job cards and album captions. These revisions have not been implemented or visually fit-tested.
- Forms and booking language, including the documented voice-rule exception, only in the later agreed pass.

A Russian working draft is now available in [about-page-copy-ru-draft.md](about-page-copy-ru-draft.md). It preserves the selected location line and founder quote, and keeps the closing invitation and form/booking language deferred. It is not final or published copy.
