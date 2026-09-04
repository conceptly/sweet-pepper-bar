# Sweet Pepper — Website brief

*Working decisions for the website. Changes often.*
*System source of truth: `design.md` — brand essence, full colour ramps, logo, motifs, photography live there, not here.*

Gastrobar in Yaroslavl (Kirova 10). "Shake & cook": a serious all-day kitchen fused with a craft cocktail bar — open 8:30 till late.

## Platform

**WordPress (self-hosted) + a fully custom theme + Advanced Custom Fields (ACF).** Not Webflow: Webflow is a US company bound by OFAC sanctions, cannot serve Russian accounts or payments, and Webflow-hosted sites don't reliably surface to visitors physically in Russia. Self-hosted WordPress has no foreign vendor in the loop and can be hosted anywhere, including Russia — the resilient choice given the client's market.

The theme is hand-coded to this spec in full — day/night mechanic, spice slider, image ratio system, section striping. WordPress is the admin layer underneath; it doesn't constrain the design.

**ACF scopes day-to-day editing to the team**, not the designer, without exposing layout to accidental breakage:
- Hours — an ACF options page (day-by-day fields, plus a repeater for holiday exceptions)
- Menu items — a custom post type (name, price, photo at 3:2, category, dietary tags)
- News — a custom post type (photo, caption, category, date — see below)

Note: ACF has an active free fork, Secure Custom Fields, following a dispute between WP Engine and Automattic. Both work; SCF avoids the WP Engine dependency if that becomes a concern later.

### Theme type — classic PHP, not a block theme (decided Aug 2026)

**A classic PHP theme** — `functions.php`, `header.php` / `footer.php`, page templates, `template-parts/` — not a block theme. Block themes (FSE, `theme.json`, Gutenberg templates) hand layout control to the editor, which is the opposite of what a spec this tight is for. Here the team edits *content* (hours, dishes, news) and never layout; a `theme.json` is carried only to colour the editor, not to build pages.

**Build tooling: Vite for the theme's CSS and JS.** Modern JS, hot reload, tokens compiled from `design.md` — the pleasant part of the framework world, taken without the architecture. Templates stay PHP.

### PHP stays thin (decided Aug 2026)

**PHP is a data layer, not an expressive one.** Everything that carries the design — layout, state, motion, theming — lives in CSS and JS, where the author works fastest. PHP's whole job is to fetch content and hand it to markup. This is an architectural constraint, not a preference: it's what keeps the build inside the author's competence and keeps the theme readable by whoever inherits it.

- **Templates contain a loop, an `if`, and holes.** No business logic in a template file. A template pulls its data at the top and the markup below is HTML with values printed into it.
- **Logic lives in small named functions in `inc/`,** called from templates — never inlined into markup.
- **`get_template_part()` with args is the component call.** Template parts take their data as arguments, like props; they never reach for globals or query the database themselves.
- **The daypart engine is JS, not PHP.** It has to be client-side anyway (the page cache would otherwise serve the wrong hour), so it never becomes PHP to maintain. Same for the day/night peek, the drawer, the jump-nav panel and all motion.
- **Escape on output** — `esc_html()` / `esc_url()` / `esc_attr()` at every hole, no exceptions. It's the one PHP habit that isn't optional.
- **Where PHP does more than fetch** (the hours model, the status-line lookup, schema output), it's a named function in `inc/` with one job, not logic scattered across templates.

### Plugin cap — four, each justified in writing (decided Aug 2026)

The 2016-era failure mode this project is designed against is not one bad plugin; it's the absence of a rule about adding them. **Four plugins, named here. Anything proposed later must displace one, in writing, in this section.**

1. **ACF (or SCF)** — hours options page, `dish` CPT fields, News fields. The content model depends on it.
2. **Polylang** — RU/EN structure for posts, taxonomies and ACF fields (see Top nav → EN/RU switch).
3. **A page cache** — chosen at build; must be compatible with the client-side daypart rule above.
4. **Backups** — non-negotiable on a self-hosted install the author maintains.

- **No page builder, no theme framework, no plugin that emits front-end markup or CSS.** Nothing installed may fight the theme's styles, because nothing installed should produce any.
- **Auto-updates off for plugins; update on staging first.** Automatic core/plugin updates are the current default and are the one genuinely *new* risk since the author's last WordPress project.
- SEO and analytics are deliberately *not* on the list — meta tags and Restaurant schema come from the theme, off the same ACF hours data as the footer. Revisit only if the client needs an editing UI for meta.

### Rejected: headless (Astro / Next) — Aug 2026

Headless means WordPress stays the admin and the database but stops rendering; a JS framework builds the pages from its API. Evaluated seriously, because the site doubles as a portfolio piece for a Canadian audience.

- **Next rejected outright.** React everywhere, for a site that is text, photographs and four interactive mechanics. It wants a Node host, and the frictionless one (Vercel) is a US company — the same OFAC problem that ruled out Webflow above.
- **Astro was the credible one:** static HTML output, zero JS by default, islands for the interactive mechanics only, hosts on any plain RU server with no Node, no foreign vendor in the loop.
- **Rejected anyway, on operations rather than taste.** Two systems to maintain instead of one. Content changes wait on a rebuild — a manager fixing a price and refreshing for a minute is a bad failure mode for a team still learning the CMS. And handover narrows from "any WordPress freelancer in Yaroslavl" to the author, permanently.
- **The day/night and daypart mechanics are client-side JS in every option.** No framework makes them easier; that is not an argument on either side and shouldn't be used as one later.
- **The Astro appetite is real and goes elsewhere:** the case-study site (`case-study/`) is the place to build it — same learning, no client risk.

### Rejected: Tilda and low-code — Aug 2026

Considered as the RU-market answer to the Webflow rejection above — Russian company, no sanctions exposure, Zero Block freeform canvas, custom code blocks, source export on the Business plan. **Rejected on the design, not the politics.** No theme-token layer for the day/night mechanic; no custom content model for menu items carrying section, dietary, seasonal and special tags; no component-with-properties for the six image ratios or the Lemon caption label; and the three tappable grammars (Interaction rule) stop being structurally enforceable and become something re-applied by hand, block by block, until they drift. Every mechanic would arrive as custom JS bolted into a builder that doesn't want it — more code than the theme costs, with less control over it.

Second reason, recorded so it isn't reopened: the project exists to produce a real web design piece. A builder caps both what can be built and what can be shown.

## News/social feed — content plan

Content goes into the News post type manually, by the team, mirroring what they already post to Instagram and VK — not pulled live via API.

- Instagram's Graph API requires Business Verification + App Review — a heavier process for a business tied to a blocked jurisdiction, with no guarantee of a smooth review.
- A Russia-hosted server may sit behind the same network-level blocks affecting ordinary users reaching Meta's API — a live pull could silently fail at the infrastructure level, independent of any API permissions.
- The team already writes this content in-house for Instagram/VK; pasting it a second time into WordPress costs seconds and has zero dependency on either platform's API surviving.

Despite Instagram being blocked in Russia since 2022, VPN adoption is high (~41–46% of Russian users) and Instagram retains real reach among Sweet Pepper's audience — so it stays a genuine content source, just not a live technical integration.

If partial automation is wanted later: VK's simpler, non-sanctioned API (register an app, `wall.get` with a token) is realistic to auto-pull from a Russian server. Instagram content would stay manual.

**Launch phasing (decided Jul 2026)** — the News/Events page is deferred so the launch stays small and the team learns WordPress on low-stakes content:
1. **Launch:** no News page, no feed. The home section ships as a static *social entrance* — own-design colour-block section, 3–4 evergreen bar photos, chips out to VK (leading) and Instagram. News drops out of the nav until its page exists (no dead nav items). Zero API dependencies at launch.
2. **Phase 2:** News CPT + manual cards on home (this *is* the team's WordPress practice — pasting posts they already wrote for VK/IG). Events page follows if the content cadence proves out.
3. **Phase 3:** importers as crons feeding the News CPT **as drafts** (human approves; automation is an importer behind our components, never an embedded widget). Two sources, same pipeline:
   - **VK** — `wall.get` direct from the RU server (non-sanctioned, simple).
   - **Instagram** (added Jul 2026 — the site doubles as a portfolio project for a Canadian audience, so automated IG is worth pursuing): a small proxy *outside* Russia (edge function) holds the token and pulls posts; WP cron fetches from the proxy. Importing self-hosts the images, so IG content becomes visible to RU guests too — the one approach that serves both audiences. Route: Instagram API with Instagram Login (Basic Display is dead since Dec 2024); risk is Meta's app review for a RU-tied business + token upkeep. If access fails, VK alone feeds the pipeline.
   
   **Never ship a live Instagram embed** — blocked for RU visitors without VPN regardless of API status; the importer supersedes it for every purpose, portfolio included.

## Typography on the web

Molot leads; hierarchy comes from size, colour, case, and position — never a second display face (`design.md` §3.2). Golos Text carries everything meant for reading. Four web-specific additions:

### Sanctioned small-size exception
The slider meal-period labels (BREAKFAST / LUNCH / DINNER / PARTY) are set in Molot at 13–18px — single words only — with a letter transition: inactive → outline → active fill. This is the one place Molot goes below display sizes.

### Interaction rule
Exactly three container styles signal "tappable":

1. **Boxed actions (buttons):** Golos Text SemiBold 16, always in a button container. Nothing else uses this style.
2. **Contained inline actions (chips):** Golos Text Medium 13 inside a chip container with an icon and/or trailing arrow, plus a hover state.
3. **Doors (menu-state switches):** a Molot word on a small tilted block with an always-visible arrow — spec in Menu page → Doors. Used *only* for crossing between the food and drinks menus; nothing else may be door-shaped.

Non-interactive text must never borrow these styles. Expressive or instructional text (e.g. "Pick your heat!") is set in Molot, tied visually to the element it points at — not in button typography.

### Line-wrapping
`text-wrap: pretty;` on all body copy (Golos Text reading content) — avoids orphans and ugly one-word last lines, keeping paragraph shape even now that the Grid section constrains body copy to a fixed measure. Browsers cap the algorithm's cost to a limited number of lines per block, which is a non-issue here since body copy is already scoped to short teasers or 2-column runs, never a single unbroken long block.

### Form text styles
A dedicated UI/Forms style group, not numbered Caption variants — keeps `Caption` scoped to its original role (captions, fine print, addresses) instead of diluting it into "whatever's small."

- **Form label** — Golos Medium 500, 13px/140%/4% tracking. Same values as Caption, distinct semantic name (e.g. field labels).
- **Form hint** — Golos Regular 400, 13px/140%/4% tracking. New weight variant; used for supporting/helper text and de-emphasized tags like "(optional)" — paired with the secondary/muted text colour (Ash on light, Mushroom on dark), never the primary text colour.

Reserve future small-UI needs (tags, table cells, tooltips) for new entries in this same group — not more Caption numbers.

Note for AI tools: Molot is a local font and will not render — substitute any heavy all-caps display sans and judge structure, not letterforms.

## Day / night pairings (web)

Full ramps, roles, and the generative colour rule: `design.md` §2. Website-state mapping:

| Role | Day | Night |
|---|---|---|
| Hero surface | Paper — photos at full saturation (wash retired, see note below) | Peppercorn (photo, dark) |
| Primary text | Peppercorn | Paper |
| Secondary text | Ash | Mushroom |
| Accent | Chili (unchanged) | Chili; Paprika/Lemon for small text |
| Eyebrow | Olive | Lime Light |

Contrast note (**re-measured Aug 2026 — the old figure was wrong**): Chili on Peppercorn is **4.47:1**, not 3.4:1. The conclusion holds but the margin is far tighter than it looked — it clears 3:1 for large Molot comfortably and misses the 4.5:1 body-text threshold by three hundredths, so it is not a safe small-text colour and shouldn't be rounded up to one. Small accent text on dark still uses Paprika or Lemon. *(The 3.4 figure appears to be Chili on **Lemon**, 3.42:1, transcribed onto the wrong pair — worth checking anywhere else that number was reused.)*

**Revision (menu-page work, Jul 2026):** the original day rule — "photo washed with Paper ~90%" — flattened the photography and made day heroes read foggy and lifeless. Retired. Day-mode photos run at full saturation (the day register is already bright per `design.md` §7); day energy comes from tilt, hard Peppercorn keylines, and the Lemon ticker band instead of a wash.

## The day/night concept

**Settled Aug 2026. The daypart grid is the only theme control; there is no day/night toggle anywhere on the site.**

The site reflects the actual time of day. Day state: cream palette, kitchen/breakfast content, menu-first CTA. Night state: dark palette, cocktails/events, reserve-first CTA. Greeting, copy, CTA pair, photography and palette all swap per daypart (breakfast / lunch / dinner / party).

**Time proposes, the guest disposes.** On load, the theme and the selected card follow the current daypart. The four photo cards in the home hero are the control: tapping one selects that daypart and the theme follows it — breakfast and lunch are day, dinner and party are night. Same mechanic at both breakpoints (Desktop — home hero, Mobile — home hero).

**Why no toggle.** Night is not a dark mode, it is the bar. A toggle would frame the theme as a *preference*, which contradicts the thing the theme is for — the room is dark after dark, and that's a fact about the venue, not a setting a guest chooses. Dropping it also removes a control that changed no information off the home page.

**The now-marker (decided Aug 2026).** The marker always sits on the card matching the real daypart, independent of what's selected (Mobile — home hero → NOW marker). It has two renderings:

- **Now card is the active one** — the default every guest lands on — the marker is a **labelled** state: the 8px Lemon dot plus `now` / «сейчас».
- **Now card is inactive** — the guest has moved — the marker is the **dot alone**, 8px Lemon, bottom-left, on the 4px grid.

**Why that way round and not the reverse.** The label sits in the state everyone sees first, so the dot is *taught* before it has to work alone; by the time a guest is displaced they have already met it. It also matches the drawing: the active card is at full strength and full size and can carry type, while inactive cards are dimmed (Mobile — home hero → Active tile marking) and would make a label muddy.

Tapping the marked card is the way home, and there is **no separate "Back to now" control** — being displaced costs the guest nothing, so a persistent control would imply a problem that doesn't exist.

### What themes and what doesn't (decided Aug 2026)

| Surface | Behaviour |
|---|---|
| **Home** | Themes. Driven by the daypart grid |
| **Menu — food state** | Themes day/night. The only inner page with two theme states |
| **Menu — drinks state** | **Always dark.** The bar's own register; it does not take a day treatment |
| **About**, **Visit** | **Fixed compositions.** Each page runs its own light and dark sections in a set order and does not theme by time |
| **Footer** | Always Lime, both modes, every page (Section striping) |

**This supersedes the Jul 2026 Visit decision** that the standalone Visit page *"themes by time like every other page — its day hero is light"*. Visit is a fixed **dark · light · dark** composition closing on the Lime footer. Section striping and `visit-page-copy.md` → Theming have both been corrected.

### The override travels on the link, not as sticky state

The hero CTA already renames itself with the selection ("Breakfast menu" / "Dinner menu"), so **that click carries the daypart** — `/menu?daypart=dinner`. Consequences:

- Arriving at the menu from the hero keeps the continuity the grid promises: pick dinner, land in the dinner menu in night clothes
- Arriving at the menu from the nav themes by time, like everything else
- **No persistent global theme state.** Nothing sticky to get lost in, and no orphaned dark page at 11am with no marker on it and no way back
- Deep links stay honest, which matters since every menu state and section anchor is specified as shareable

### Downstream

- **Edge positions.** The right edge now holds Reserve alone. The rule "edge positions keep stable meanings site-wide — left = section nav, right = act on the venue" (Top nav) should read as **right = Reserve**, and the desktop-scoping caveat it carried for the peek is moot.
- **The tiles are a state switch.** That collides with Don't (web-specific), which reserves state switches for doors. The Interaction rule needs the daypart grid added as a named sanctioned entry — the count stops being three and the *list* becomes the rule.

**Why the peek went, kept as a record.** Off the home page it toggled a palette, not content — the menu page's real axis is food ↔ drinks, which has its own control, and nothing a guest needs was reachable only in the other theme. The honest case against dropping it: day/night is a signature idea, and a guest who only visits at lunch never learns it exists — but that is a brand/portfolio argument, not a user-need one, and it lost to the toggle-implies-preference problem above. The drawer-only middle option went with it.

## Top nav (decided Jul 2026)

**Items: Home · Menu · About · Visit.** News/Events stays out until its page exists (no dead nav items — see Launch phasing).

- **Home label kept — default decision.** Logo links home too (implicit + explicit, per NN/g; «Главная» is also standing RU web convention, and Segments B/C are the logo-only-fails slice). First position. *(Open test — see `testing.md`.)*
- **Logo idle-shake** (candidate, motion language): the logo joins the idle self-demo vocabulary — an occasional shaker wiggle on the section's single idle clock — advertising its interactivity without withholding the Home affordance. Works on touch, where hover-discovery doesn't exist.
- **Social chip:** one chip, "See what's new" — VK glyph leading, IG second, links to VK (IG one step inside). Official full-colour brand marks (`design.md` §5.2) — the colour is what marks them as contacts, distinct from the single-colour supporting icons. This is also News' interim home while the page is deferred.
- **EN/RU switch:** text pill, both codes always visible, active filled, Caption size. System language proposes on first entry only (`navigator.language`); an explicit tap persists (localStorage) and is never re-overridden — the "time proposes, memory disposes" principle applied to language. RU content leads; EN/RU voice lines are register twins, never machine translations.
- **Day/night peek is not in the nav** — right-edge tab under Reserve (see The day/night concept). Edge positions keep stable meanings site-wide: left = section nav (menu page), right = act on the venue (Reserve + peek).

### Mobile — the drawer (decided Aug 2026)

Below the nav's desktop breakpoint the four items collapse into a **full-screen drawer**, opened from a hamburger at the right of the header (logo holds the left). The drawer themes by time like every other surface — Paper by day, Peppercorn by night — and is the mobile home of everything the desktop header carries, so nothing needs a second tap to reach.

**Anatomy, top to bottom:**

- **Header** — horizontal logo lockup left, close × right. The drawer is the only place a × appears in the top nav.
- **Nav list** — the four items in Molot, each with a one-line Golos description and a trailing arrow. Descriptions are guest-voice (`design.md` §1.1), not feature lists: they say what the guest gets, in the guest's "your."
- **Venue card** — a raised surface (Parchment by day, Soft Peppercorn by night) holding the route out to the map and the social row. This is where the desktop "See what's new" chip lives on mobile; the same launch-phasing rule applies — the label must not name a News/Events page while that page is deferred.
- **EN/RU pill** — unchanged from the desktop rule (both codes always visible, active filled). It lives in the drawer on mobile rather than in the collapsed header; that is a deliberate accepted cost, since the drawer is one tap and the alternative is crowding a 390px header.
- **Booking block** — a Molot instructional line ("Book your table") over one filled primary action and two outlined secondary actions. Molot here is sanctioned instructional text tied to the element it points at, not button typography (Interaction rule). **Phone leads** — RU guests book by call; messaging apps are the fallback, not the default.

**Current-item state — outline → fill, same as everywhere.** Inactive items are outlined Molot; the current page fills (Chili by day, Lime by night) and swaps its trailing arrow for a "you are here" marker. Colour alone never carries the state — the drawer must read correctly in greyscale, and outline→fill is the site's one state-change vocabulary (Motion language).

**Marker constraint:** the "you are here" mark cannot be a bare chili. The logo Symbol is shaker + chili together with a 24px floor (`design.md` §4), so a lone recoloured pepper is a new mark, not a house one. Either place the Symbol at ≥ 24px or use a non-logo device (filled notch, rule, block).

**Icons:** VK and Instagram appear up to three times in this drawer. All instances are the **official full-colour brand marks** (`design.md` §5.2) — never recoloured to the surface's text colour, so they read as contacts rather than as supporting icons. *(Corrected Sep 2026; the earlier single-colour rule here was a misreading of `design.md`.)*

**Open (mobile nav):**

- **Reserve on mobile — under consideration (Aug 2026), three placements tried and rejected.** The site-wide rule puts Reserve on the right viewport edge in all states; that rule does not survive a 390–402px screen. Findings on record so the ground isn't re-covered:
  - *Right-edge tab* — takes too much width and overlaps content. The edge affordance depends on a margin mobile doesn't have.
  - *Floating bottom button* — collides with the CTAs that already live at the bottom of sections (Submit, See the menu, the booking block).
  - *Persistent top-nav button* — the best of the three if Reserve must stay visible, but it crowds the header, and it goes redundant the moment an in-content Reserve is on screen (visible in the current home-hero mockup, where the nav button and the hero button sit in the same view — also two accent-filled primaries at once, against the one-primary-per-view rule).

  **Author's leaning:** no persistent Reserve on mobile. It lives in the drawer's booking block plus the sections where it's relevant, and phone leads in both. If it is later kept visible, the top nav is the placement — with the house yield rule attached: *a persistent control hides while an in-content control doing the same job is in view* (same pattern as the menu page's jump-nav, which only appears once the hero's side-nav has scrolled away). Parked until after the Visit page ships.

- **Day/night peek on mobile** — folded into the larger question of whether the peek survives at all; see The day/night concept → Under consideration.
- **Nav order.** Decided order is Home · Menu · About · Visit; current mockups run Home · About · Menu · Visit. Menu is the highest-intent destination — restore it to second, or record the reason it moved.
- **Descriptions — voice pass.** "Hours, map, and all the contacts" is a calque and "Get Directions" is venue-voice; the house line already exists ("Your route to Pepper"). Write the four lines as register twins in RU and EN, not translations.
- **Address:** mockups say "Kirova 10/25", the docs say Kirova 10 — confirm with Iurii and fix one of them.
- **Close × colour:** Lemon makes dismissal the brightest object in the header, and Lemon is highlight-only (`design.md` §2.2). Candidate: Parchment by night, Peppercorn by day.

## The spice slider

> **Status: superseded in the home hero, both breakpoints (Aug 2026).** The daypart tile grid replaced it on mobile first, then on desktop (see Desktop — home hero and Mobile — home hero). The slider is not in any current home-hero mockup.
>
> **This section stays, and is still load-bearing.** The state model, the closed-window parking rules, the day-type logic and the full status-line matrix below were never slider-specific — they describe *what the site knows about the hour*, and the tile grid consumes all of it unchanged. Read everything after "State model" as the daypart engine; read the paragraph immediately below as the retired instrument.
>
> Not deleted, because the decision is one round of testing old and the instrument may return on a surface with room for it (the slider reads well at desktop width; it lost on comprehension, not on fit). If it's still unused after the Visit page ships, retire the instrument paragraph and rename this section "The daypart engine."

The hero's central interactive element **(retired instrument — see status above)**: a heat slider with four stops — breakfast (mild), lunch (warm), dinner (spicy), party (on fire). Heat = time of day. It defaults to the current daypart and doubles as the day/night control. Dragging changes greeting, CTA pair, photography mood, and palette. Stop labels follow the Molot letter transition above. Planned: the knob is a pepper (or a circle containing one) that fills with red as heat rises; the giant SWEET PEPPER wordmark can fill in sync.

### Component variants (Figma)

Visual variants only — everything else is text properties, or the set explodes:

- **Active stop:** breakfast / lunch·brunch / dinner / party (4)
- **Mode:** day / night (2)
- **Marker:** at-now / displaced — now-marker visible (2)

Max 16 visual variants. The second stop's label (LUNCH ↔ BRUNCH) and every status line are **text props**, not variants.

**Gap to close:** the five states in the model below collapse to **two** visual variants plus copy — beginning / full swing / last call are the same frame with a different status line (which is why status lines are text props), leaving *displaced* and *closed* as the only ones that change the drawing. But **closed sits on no axis** in the list above. Either make Marker three-valued (at-now / displaced / closed → 24 combinations, 20 legal, since closed only exists on breakfast and party) or add it as a boolean and accept invalid combinations. Decide before building the set — retrofitting an axis means rewiring every instance.

### State model (logic layer)

- Per stop, five possible states: **beginning / full swing / last call / off-hours** (dragged to outside its window), plus **closed** on the two edge stops only (breakfast pre-open, party post-close). "Closed" is never a fifth stop — the scale enumerates offers, and closed isn't one.
- **Day-type** (weekday / weekend·holiday) comes from the ACF hours options page — same source as the footer hours; holidays follow the weekend rule via the exceptions repeater; Sunday's 10:00 opening is an hours exception, not component logic.
- **Now-marker:** Lemon track notch, visible only while the knob is displaced; hidden during closed hours (there's no "now" on the track when the room is dark).
- **Closed-window parking:** close → 05:00 parks on party (closed line); 05:00 → opening parks on breakfast (closed line; Sundays until 10:00). Overnight, the site points at the next open door.
- Status line format: [fact] — [reassurance/wink]. Golos caption. Numerals clockless style: till 12 · till 4 · 1:30 — never AM/PM.

### Status lines — weekday

| Stop | Beginning | Full swing | Last call | Off-hours | Closed |
|---|---|---|---|---|---|
| Breakfast | doors just opened — coffee's already on | the morning round — Bio Bio glass till 12 | breakfast stays all day — Bio Bio glass clocks out at 12 | eggs any hour — the morning glass returns at 8:30 | still closed — coffee and eggs are back at 8:30 |
| Lunch | lunch is on — the soup's already out | lunch till 4 — no rush | lunch till 4 — last call! | back tomorrow at noon *(Friday evening: back Monday at noon)* | — |
| Dinner | dinner's on — book for eight | the kitchen's on — no rush | still time for dinner — kitchen's good till 1:30 | the evening kitchen starts at 4 | — |
| Party | first cocktails poured — the night's warming up | the room's buzzing — kitchen till 1:30 | last order 1:30 — make it count | starts after six — you're early | closed for today — back at 8:30 |

### Status lines — weekend / holiday overrides

Second stop label → **BRUNCH** (no special menu exists — the copy frames that as generosity, pre-empting the "brunch specials?" expectation):

| State | Line |
|---|---|
| Beginning | brunch mode — the full kitchen's awake |
| Full swing | the brunch menu is the whole menu — that's the deal |
| Last call | brunch runs till four — Saturdays fill up, book or come early |
| Off-hours | brunch is a weekend thing — weekdays it's business lunch |

Sunday (10:00 opening, general cleaning):

- Closed / pre-open: "Sunday scrub — back at 10, spotless" *(rhymes with SPOTLESS in the About word cloud)*
- Breakfast beginning: "doors at 10 today — the room's just been cleaned within an inch of its life"

### To confirm / translate

- All lines need RU versions — voice copy, no machine translation.
- "Bio Bio glass" — confirm the offer's exact name and terms.
- Confirm all-day breakfast reality and weekend opening hours with Iurii, then fix `sweet_pepper_bar_brief.md` (hours section still says "Breakfast 8:30–12:00 weekdays").
- The busy-Saturday booking nudge lives only in brunch last-call — one nudge in the whole matrix, where waiting is a real risk.
- **Kitchen close time corrected (Jul 2026):** Dinner's last-call line said "kitchen till 11" — stale; kitchen actually runs till 1:30, matching Party's full-swing line. Both stops now state 1:30. Confirm this single close time covers every night, or if any night differs.
- **DJ line softened (Jul 2026):** Party's beginning/full-swing copy assumed a DJ every night ("DJ's setting up" / "DJ's on"). Revised to atmosphere-first ("the night's warming up" / "the room's buzzing") since a DJ isn't nightly and Party is really about room energy — music's on every evening regardless. If a DJ night should be called out specifically, that's a separate data-driven variant, not default copy (see note below).

## Desktop — home hero (current state, Aug 2026)

The desktop hero runs the **same daypart tile grid as mobile** — four tiles, one per daypart, tap to select, theme follows the selection. The mechanic, the state model and the status copy are shared; only the composition differs. Recorded here as *current state*, not as a settled layout: the composition has a live alternative under consideration (below).

### Composition

Single column, left-aligned, stacked top to bottom: eyebrow → headline → body copy → **a single horizontal row of four tiles** → CTA pair → language nudge → the giant Molot wordmark bleeding off the bottom of the section.

- **Eyebrow is present on desktop** — "SHAKE & COOK · YAROSLAVL", `--accent-2`. (Mobile drops it for space; this is a deliberate divergence, not drift.)
- **Headline is Chili in both modes** on desktop. Mobile runs `--accent-2` (Olive / Lemon). **Unresolved divergence** — see Open.
- **Active tile** — larger, with a keyline and the offset Lemon/Chili sheets. Desktop is where the layering language belongs: it has the width to give the sheets a real offset, which is exactly what mobile can't do (Mobile — home hero → Layering stays a desktop device).
- **NOW marker** — a small pip on the tile that is now when it isn't selected; a "Now" label on it when it is. Independent of selection, same two-axis rule as mobile.
- **CTA pair** — Reserve (Chili, primary) plus a **daypart-named menu button**: Breakfast menu / Lunch menu / Dinner menu / Bar menu, each with its own glyph. The button renames itself with the selection, which is a good detail — it promises the *part* of the menu the guest is already looking at rather than "the menu."
- **Mobile diverges here deliberately:** mobile carries Reserve only, with a named scroll cue doing the menu's job, because two buttons don't survive the viewport. Desktop has the room, and the menu is the highest-intent action on a restaurant site, so it keeps the button.
- **Language nudge** — first-entry only, `navigator.language` proposes and an explicit choice persists (Top nav → EN/RU switch). Currently sits bottom-right of the hero.

### Open (desktop hero)

- **Two-sided layout — the leading alternative.** Grid occupying one full side (left or right) as a column or block, copy on the other, instead of the current horizontal row under the text. Author's first instinct for the next pass, and it addresses the dead zone below directly.
- **The right third is empty.** Headline ends around 830px and the grid around 940px of a 1280px frame, so the current composition reads as the mobile stack widened rather than a desktop layout. This is the single biggest thing to fix, and the two-sided idea exists because of it.
- **The active tile's size advantage is much weaker than on mobile** — roughly 15–25% larger versus about double. Size was the primary state signal on mobile; on desktop the keyline and sheets are carrying nearly all of it. Either restore the size ratio or accept that desktop marks state differently and say so.
- **No "Back to now" anywhere.** The tiles don't auto-revert, and a displaced state (e.g. cocktails selected while the pip sits on lunch) currently has no way home. Same gap as mobile; see The day/night concept for the proposal to give the job to the edge tab.
- **The language nudge is unattached** — it floats in the empty right zone with no anchor, reading as an orphan rather than a system message. Likely resolves itself with the layout, since the dead zone is what it's floating in.
- **Copy pass pending**, deliberately deferred until the layout settles. Known issues on record so they aren't rediscovered: "Lunch's till 4" isn't idiomatic (→ "Lunch till 4"); "bar offers on the go" means portable, not running; "PUMPKIN SOUP TIME!" ties a headline to one dish and breaks the day it's off the menu; and three of four headlines are exclamations with two sharing an "X TIME!" construction — the set needs variety in shape, not only in words.

## Mobile — home hero (decided Aug 2026)

Below the desktop breakpoint the hero drops the slider and runs a **four-tile photo grid** instead — one tile per daypart. Same mechanic, different instrument: heat is still time of day, the guest can still move along it, and the state model and status copy are shared with the slider.

**Why it changed.** Usability testing: a participant called the slider "too complicated," and fairly — the rail carried four labels, a knob, a now-marker, a status line and an instruction, six pieces of chrome to communicate one fact. A/B against a vertical rail: participants preferred the grid, and so does the author. A photograph of eggs also says *morning here* faster than the word BREAKFAST, and says it in both languages at once.

**What it costs, recorded honestly.** The grid shows one daypart at a time, so the all-day story — the thing that separates Pepper from a bar or a café — is no longer visible at a glance the way four labelled stops made it. Mitigations available if testing shows it matters: one tile borrowed from another daypart with a caption ("also mornings →"), or leaning on the Menu highlights section below. Not currently built.

### Anatomy

- **Four tiles, one per daypart**, in an irregular grid. The **selected tile is the large one** — size carries state, so the grid *is* the scale and no separate track is drawn.
- **Tapping a tile selects that daypart:** hero copy, CTA and photography change, and the **theme flips with it** — breakfast/lunch → day, dinner/party → night.
- **No meal labels on the tiles.** Tried and rejected: too wordy at 402px, and they fight the NOW marker, which is the more useful of the two. The hero text names the daypart instead.
- **No eyebrow on mobile.** Also tried and rejected — with 16px body copy, real image sizes and a normal gap there isn't room, and it reads wordy. The logo carries the venue name; the headline carries the daypart. (Desktop keeps the eyebrow.)
- **NOW marker** — a pip on whichever tile is *now*, **independent of what's selected**. It sits on an inactive tile whenever the guest has moved. Selection and now are two axes, not one; the slider has the same split (knob vs now-marker).
- **Active tile marking** — keyline in `--accent-2`, plus the size difference. **Inactive tiles are dimmed** rather than the active one being brightened: same unlit → lit logic as outline → fill, no new device, and only one photo is ever at full strength, so an uneven photo set doesn't show four at once. *Current build uses an outline plus a glow; the glow is a selection halo that appears nowhere else in the system — restyle pending, not blocking.*
- **Layering stays a desktop device.** The offset Lemon/Chili sheets from the menu-page hero need roughly 14px of offset to read as stacked paper; at mobile tile sizes they shrink to ~4px and read as colour fringing, closer to a print misregistration than to depth. Mobile uses keyline + size only.

### Tile states

| | is now | not now |
|---|---|---|
| **selected** | large · keyline · NOW pip | large · keyline · "Back to now" appears |
| **not selected** | small · dimmed · NOW pip | small · dimmed |

### Behaviour

- The tapped tile **moves** into the large slot — never a crossfade. If the photo the guest touched dissolves, they lose track of what they just did.
- **No auto-revert.** An explicit choice is not overruled by the clock — "time proposes, memory disposes," same principle as the language switch. "Back to now" is the only way back, which argues for giving it a fixed home rather than a chip that appears and disappears in the hero.
- `prefers-reduced-motion`: instant swap, no theme cross-dissolve.
- **This is now the mobile day/night control** — tapping a dinner or party tile darkens the site. It therefore replaces the peek on mobile entirely, and feeds the open question in The day/night concept → Under consideration: the mobile hero now does what the peek tab was for.

### Colour roles in the hero

- **Headline and the active tile's keyline** take `--accent-2` — Olive by day, Lemon or Lime by night. **Desktop currently runs Chili headlines in both modes** — an unresolved divergence, flagged in Desktop — home hero → Open. The reasoning below (red flooding the frame) applies at both breakpoints, so this probably wants unifying rather than scoping.
- **Reserve is Chili in both modes.** One CTA colour across modes beats one optimised per mode: Lemon and Lime both fail as buttons on Parchment (too little separation from the ground), and a Peppercorn primary in day mode was rejected. Red therefore leaves the headline, which is also the fix for red flooding the frame — logo, button and headline were all Chili at once on top of red-heavy food photography.
- **The NOW pip takes the remaining accent, never the headline's.** A Lemon headline with a Lemon pip puts the largest type and the smallest state marker in the same colour, in the same viewport.

### CTAs

One button (Reserve) plus a **named scroll cue** — "What's cooking tonight ↓" — instead of a second menu button. The hero already shows four photographs of food, so appetite is served above the fold; the cue carries the menu path, which is why it must name its destination. "Scroll down for more" promises nothing and doesn't do that job.

**Condition attached:** the section below (Menu highlights) has to *open* with food. If it opens with a Molot headline and the photos sit another 200px down, a guest who scrolls once sees no menu content and the hero's missing menu CTA costs a visit.

### Cost to plan for

Four dayparts × four tiles is **16 art-directed photos** rather than the slider's four, maintained by the team in WordPress. Decide which tiles can be shared across dayparts before shooting. A bento is also only as good as its worst photo and shows several at once — the dimming rule above is partly insurance against that.

### Not carried over to mobile

- **The eyebrow** and **the second (menu) CTA** — both present on desktop, both cut here for space. See Desktop — home hero.
- **The giant Molot wordmark in the hero.** Its job is a section seam, not an introduction (Layout notes); asking it to name the venue above the fold is what made it look clipped by the browser chrome. It stays lower on the page, where its size is an asset rather than a fold problem.

### Open (mobile hero)

- **Text-first or grid-first** — headline above the grid or below it. Both fit inside a mobile browser viewport (~690px usable after Safari chrome); parked deliberately for a fresh look.
- Active-tile treatment — see the glow note above.

## The no-clock rule (hospitality principle)

Good service makes guests lose track of time — so no literal clocks or countdowns in the hero. Schedule is implied by slider position and soft copy ("the kitchen's on — no rush"). Exact times appear only where guest anxiety is real (breakfast cutoff may say "served till noon") and on service pages (menu, contacts).

## The bartender's ticket

A site-wide component: an order slip the interface "prints" to answer the guest — the kitchen–bar handshake made tangible. Motif lineage: the bottle-cap scalloped edge (`design.md` §5.1).

- **Anatomy:** Paper card · small-caps header line (SWEET PEPPER · KIROVA 10, Caption tracking) · the guest's line (Golos Medium, Peppercorn) · dashed rule · the bar's reply (Golos, Deep Chili) · optional chip exit link · bottom edge cut with the bottle-cap scallop.
- **Motion:** it *prints* — slides out from the control that produced it, with the house spring easing. Never fades in like a tooltip.
- **Modes:** always Paper, day and night — a receipt is paper regardless of the hour. On dark grounds it's the brightest object in the section, so max one per view.
- **Voice:** the reply is always a person speaking ("unforgettable with a shot of the cranberry infusion"), never a template ("pairs well with X").
- **Used in:** About — the pairing picker prints one (spec: `about-page-copy.md`, The Concept). Candidates later: reservation confirmation, menu specials.
- **Not the footer any more (Aug 2026).** The footer became a saturated Lime band in both modes (Section striping), and Lime out-brights Paper — a slip there loses the "brightest object in view" property the component depends on. Hours, address and "come sit with us" live in the footer as plain type instead. One closing device per page.

## Motion language

One vocabulary across the site, so every interactive section feels like one hand:

- **Outline → fill is the state change.** Slider meal labels, the About chapter rail, the word cloud, the heat-filling wordmark — "filled" always means active / current / hot. Photographic surfaces state it as **dimmed → full strength**: the mobile hero's daypart tiles unlit the three that aren't selected rather than haloing the one that is (Mobile — home hero). Same grammar, applied to images instead of letterforms.
- **One clock per section.** A single idle rhythm drives everything that moves in a view (About's heartbeat fills a word and turns the quote wheel together). Never two independent idle animations in one section.
- **Idle self-demo, human seizure.** Untouched sections demo themselves (heartbeat, an occasional shake); any interaction seizes the clock and pauses auto-motion for ~8s, then it resumes.
- **Spring easing** for prints, rolls, and snap-backs (bartender's ticket print, wheel roll); transforms only — never animate layout.
- **prefers-reduced-motion:** drift, parallax, and auto-advance off; state changes (fill, quote swap, ticket content) remain.

## Grid

Full-width/full-bleed sections use a 1120px content width (centered on the page, ~80px side margin at desktop), split into a 12-column grid with a 24px gutter (column ≈ 71px).

### Spacing — the 4px rule (documented Aug 2026, from the Figma file)

**Every spacing value is a multiple of 4.** That is the whole rule; there is no separate named-token vocabulary to learn, and nothing needs a name like `space-md`.

- **Spacing scale (Figma `Spacing` collection):** 4 · 8 · 12 · 16 · 24 · 36 · 44 · 52 · 64 · 80
- **Icon sizes (Figma `Sizes` → `Icons`):** xs 8 · s 12 · m 16 · l 24 · xl 36 · xxl 48

Both are subsets of the 4px grid, not separate systems. Use a scale value where one fits; any other multiple of 4 is legal when it doesn't. The now-marker's 8px dot (The day/night concept) is on this grid, as is the 24px column gutter above.

*Note for the Figma file, not for the build:* spacing and icon sizes are each modelled as **one variable with many modes** rather than many variables. It works, but modes are a theming axis — a frame sits in one spacing mode at a time, so nested elements needing different gaps need nested overrides. No effect on the CSS, which just gets the scale above.

**Body copy is capped by column count, not by character or word count.** A live word-count-driven rule renders inconsistently depending on the actual copy dropped in; a fixed column span stays predictable regardless of content.

**Desktop: body copy caps at 6 of 12 columns (548px)** inside full-width sections, even when the section itself is full-bleed — never the full 12. Narrower breakpoints get their own column rule (not yet defined); don't assume 6 columns holds below desktop.

The leftover columns get a job, not left blank — which one depends on how much copy there is:
- **Short copy** (2–4 sentence teasers, e.g. News cards): flush-left the text to the same grid start as the headline above it, and pair the remaining columns with a secondary element — a stat, a pull-quote, or social icons. Never centered — centering a narrow column in a wide section reads as an accident, not a choice.
- **Long-form copy** (blog posts, About page body, full menu item descriptions): split into two columns of running text side by side instead of one narrow column plus empty space — the standard editorial fix for reconciling full width with a readable measure.

## Layout notes

- The giant Molot wordmark can sit on the seam between sections: outlined on the dark side, filled crossing into the light side. Replaces the old mirrored-reflection idea.
- Section striping is a deliberate rhythm, but it's not one rule across both states — see Section striping (day / night) below.
- A persistent "Reserve" tab stays on the right edge in all states. On the menu page, past the hero, a matching menu-nav tab holds the left edge (Menu page → Sticky jump-nav).

### Section connectors ("link words")

Documented Aug 2026 — the device existed on the home and menu pages before it had an entry here. Giant outlined Molot set across the full-bleed photo band between sections ("yummy morning", "soul therapy", "the best in the city"). One component, used on both pages.

- **Must be SVG format**: These link words must ALWAYS be exported and placed as SVGs, not rendered as HTML text.
- **Request missing words**: If a particular section requires a link word and you don't have the SVG asset for it, you MUST stop and ask the user to provide it.
- **Width matching**: The width of the SVG link word MUST exactly match the width of the content container (in Figma, this is 80px margins from the viewport). SVGs should be given `width: 100%` inside the standard container.
- **Non-interactive — and that is the specification, not an omission.** A connector is not a link, not a section heading, and not the photo's caption. It must never acquire a hover fill, a trailing arrow, or a block: those are the three tappable grammars (Interaction rule), and borrowing one would make a decorative word claim to be a door or a chip.
- **Why outlined Molot here doesn't dilute outline → fill.** Elsewhere outline means *not current* and filling means *active*. Connectors never fill, so they'd be the one place outline is merely texture. The carve-out that resolves it is **scale register**: outline → fill governs Molot at *reading and interaction* sizes — word lists, slider labels, nav items, chapter rails. Giant display Molot that bleeds off the layout is a separate register where outline is a treatment, not a state. The room wordmark and the seam wordmark (above) already live in that register; connectors join it. Keep the two registers visibly far apart in size — if a connector ever shrinks to near-H1, it re-enters the state vocabulary and the carve-out stops protecting it.
- **Two jobs, one component (known, deliberate).** On the home page a connector is a forward invitation to the section below. On the menu page it supports the section it travels with. The author's call is that the menu-page reading is the better fit for a dense list page.
- **Open — the direction problem.** A word sitting *between* two sections has no inherent referent; position can't tell the guest whether it looks forward or back, so today it's resolved only by reading the words. Fix by pinning the referent structurally rather than semantically: either every connector band belongs to the section **below** it (becoming its epigraph, which also unifies with the home page), or every band belongs to the section **above**. Pick one, move the bands, and rewrite the copy that no longer fits. Until then, expect the odd misread on first visit.
- **Voice — review them as a set, not one at a time.** Section names are plain and each list gets exactly one voiced name; connectors are a separate register and aren't bound by that count. But eight-plus winks down a single page is a lot of personality per scroll, and the tone only reads as a set. Cut the weakest before launch rather than defending each on its own.
- **Copy lives in Figma only.** The home- and menu-page connector wording isn't in any project file yet — pull it in so it can be voiced in RU as register twins rather than translated late.

## Section striping (day / night)

The dark/light/accent section rhythm runs on different logic in each state (decided in the home-page IA work). Value alternation — not a literal colour swap — is what carries it, so a photographic section and a flat-colour section can share a value without reading as a repeated beat.

**Day — clean alternation.** Sections alternate light/dark down the page (Paper/Parchment ↔ Peppercorn), with a saturated band (Lemon) used sparingly as the one "colour-block moment" (§2.4 allows saturated fills for banners only). One sanctioned adjacency: the Hero and the section directly below it (Highlights) may both sit light — the Hero is photo-with-overlay, Highlights is flat cream, different enough in texture that it doesn't read as monotonous.

**Night — immersive dark.** Night does *not* checkerboard; it commits to darkness and lets Lime/Chili accents glow out of shared dark — "being in the bar after dark" rather than a daytime-poster rhythm. Break up long dark runs with **Soft Peppercorn** `#201E22` (`design.md` §2.2 — a ~4-point luminance lift over Peppercorn: texture without contrast), **not** Dark Olive. Let one bright section (e.g. Lunch) be the single point of light in the middle. Optional night softener: light sections that stay light at night can step Paper→Parchment to shrink the value jump at each seam — not required.

**Contact section — dark in both modes.** The closing zone reads as the wind-down regardless of daypart. At night this is simply consistent with everything around it; in day it's a deliberate exception (it accepts one two-dark run, News→Contact) chosen so Contact always feels like the wind-down zone. **Scope revision (Jul 2026):** this rule covers the *home page's closing section* only. **Corrected Aug 2026:** the Visit page does not theme by time either — the Jul revision assumed it did. Visit and About are **fixed compositions** (The day/night concept → What themes and what doesn't); Visit runs dark · light · dark into the Lime footer, in every state. Its sections don't swap clothes, so the striping rhythm is authored once rather than twice.

**Footer — saturated Lime in both modes (revised Aug 2026).** The footer used to fall under the rule above; it no longer does. It is the one place on the site that **stops theming altogether** — a fixed landmark at the end of every page, in both day and night. That's a more useful rule than a wind-down that changes clothes, and it gives the closing zone a single identity across the whole site.

- **The scalloped edge belongs to the section above (Aug 2026).** The footer's Lime ground never changes, but its scalloped top edge takes the colour of whatever section it meets — Paper, Parchment, Peppercorn or Soft Peppercorn. The seam is the last beat of the section it leaves rather than the first beat of the footer, which is what lets one fixed Lime band sit under every possible ground without a hard collision. The scallop is the bottle-cap motif (`design.md` §5.1); it is **not** a bartender's ticket and must not acquire slip anatomy — see the bullet below.
- **Consequences.** The footer is now the brightest object on any night page, so it can't also hold a bartender's ticket — the slip depends on being the brightest thing in view (`design.md` §5.1, revised to match). One closing device per page, and Lime is it. If the Peppercorn → Lime seam reads harsh at night, step the section directly above the footer to Soft Peppercorn so there's a beat before the green.
- **Text on Lime is constrained.** Peppercorn (12:1) and Ash (5.1:1) only. **Olive fails at 2.86:1** and Chili at 2.65:1 — see `design.md` §2.5, where the old "passes on Lemon/Lime" claim was corrected. Olive is the easy mistake here, since muted-green-on-green looks right and measures wrong.
- **GO TO mirrors the top nav (decided Aug 2026): Home · Menu · About · Visit.** Events is removed — it stays out of every nav, header and footer alike, until its page exists (Top nav; Launch phasing). Mockups carried an Events link in the footer; that is the one to correct, not the rule.
- **Mobile: two columns, not four stacked groups.** Stacking turns a ~350px desktop band into ~1,050px — 1.2 full screens of unbroken saturated green, at which point it stops reading as a band and starts reading as a page. Pairing GO TO with HOURS (both short) and running REACH US full width brings it to roughly 610px, which fits one screen and preserves the desktop proportion. Hours labels stack above their values rather than sitting beside them; that's what makes the two-column split fit at 402px.

## Image ratios

The image component ships six fixed ratios — one per content job, not one per breakpoint:

| Ratio | Use |
|---|---|
| **3:2** | Default for our own art-directed photography — menu items, drinks, hero, staged event photos. Landscape frame leaves room for the environment (bottle wall, bar counter) around the subject, per the photography rules in `design.md` §7. |
| **2:3** | Portrait counterpart to 3:2. Same ratio on every breakpoint — a portrait card doesn't need to get taller on mobile just because the phone screen is taller. |
| **1:1** | Square, general use. |
| **21:9** | Cinematic full-bleed banners only (≈2.35:1 — functionally the same, cleaner CSS fraction). Reserved for wide environment shots — bar counter, terrace, full room — not tight action shots (a pour, a close-up), which get squeezed or cropped out at this ratio. Never used for content cards. |
| **4:1** | Section divider bands on information-dense pages — the menu's per-section hero image (added Aug 2026). Same subject rules as 21:9 (wide environment and dish-in-context shots, never a content card), but chosen where 21:9's height pushes a long list too far down the page: at 4:1 the photograph reads as a divider and the text keeps the lead. Desktop-first; it can carry other band jobs where the same "photo serves the copy" logic applies. |
| **4:5 (Instagram)** | Default for News/social-feed cards specifically. These are reposts/links out to Instagram rather than our own photography, so the ratio follows current creator norm instead of the house system. |

**Deliberately excluded:**
- **16:9** — redundant middle ground between 3:2 and 21:9; no video-embed use case to justify a sixth ratio.
- **9:16** — a genuine full-bleed mobile hero is a `min-height: 100dvh` + `object-fit: cover` problem, not a fixed-ratio-component problem. Social cards link out rather than embedding native reels, so there's no source ratio to preserve either.

For the large/featured News card: split layout (image beside the copy, not stacked full-width above it) rather than a full-bleed banner — keeps 3:2/4:5 photography at a natural crop without needing an even wider ratio just to control card height.

**Two band ratios — watch for redundancy (open).** 21:9 (≈2.33) and 4:1 are now both "wide band" ratios, and 16:9 was excluded precisely for being a redundant middle ground. They're far enough apart to justify each other today: 21:9 is a cinematic full-bleed moment, 4:1 is a divider that yields to the copy. If the menu-page work ends with 4:1 doing all the band jobs, revisit at final review — the honest outcome then is to retire 21:9, not to keep both out of habit.

### Image caption label (the Lemon pill)

A named part of the `img` component, not a per-layout decision — a Lemon block naming the subject of the photo. Hidden by default; position (top / bottom) is a component property, chosen per image so the label never lands on the subject. Used site-wide, desktop and mobile.

- **Anatomy:** Lemon `#FFED00` ground, Peppercorn text, **Golos 400** · 13 / 140% / 4% tracking — the Caption style (weight closed Aug 2026 by re-syncing `design.md` §3.3 to the Figma file, where `Body/Caption` is and always was 400). No icon, no trailing arrow, no hover state.
- **The colour is sanctioned, not an exception.** Lemon behind Peppercorn text is an approved fill (`design.md` §2.5), and a caption is a short burst rather than an editorial surface (§2.4). Contrast ≈ 16:1.
- **It is not a chip, and must never become one.** A chip is Golos Medium 13 in a container **with an icon and/or trailing arrow and a hover state** (Interaction rule). The caption label deliberately has none of those three, and that absence is the whole reason the third tappable style stays unambiguous. Never add an icon, an arrow, or a hover to this label — if a photo's label needs to be tappable it becomes a chip and stops being this component.
- **Known collision, accepted:** the EN/RU switch is also a text pill and *is* tappable. The two never share a viewport (header/drawer vs. photo) and differ in ground, type and content, but pill-as-a-shape now means two things. Accepted as-is; if a third pill-shaped element appears, resolve the shape properly rather than adding a fourth.
- **Interactive images — the one restriction.** Where the photo is itself a link, a separately-edged bright object sitting inside a tap target it isn't will absorb mis-aimed taps and compete with the real action. There, either use the dark-scrim caption, or keep the label and make the whole card one tap target with the label visibly inert.

## Menu page

Decided in the menu-page work, Jul 2026. One page, `/menu`, holding both menus.

### States vs theme — two independent axes
The page has two **content states** — food (kitchen) and drinks (bar). State is not theme: theme (day/night) follows time of day site-wide; state only *defaults* from it (day → food first, evening → drinks first) and the guest overrides freely. Kitchen content at 9pm is kitchen content in night clothes — content and theme never lock. Every state × theme combination exists, so hero components carry three props: `slide` × `menu (food/drinks)` × `theme (day/night)`. Each state and each section anchor is deep-linkable.

### Hero — side-nav poster (concept B, validated Jul 2026)
Chosen over the carousel/ticker and the split-screen concepts after stakeholder A/B + usability testing: cleaner, easier to navigate, interactions clearer, less information-heavy. All sections visible at once — time-to-dish is the page's KPI.

**Anatomy.**
- **Nav panel (left):** a Parchment sheet with a Lime offset edge, bled off the left viewport edge, top-aligned with the photo stack's top line; its base **merges into the next section's Parchment band** — one continuous surface, so the column visibly belongs to the content it navigates. Holds the section word list and, as its last item, the door.
- **Photo stack (right):** 3:2 photo with a hard Peppercorn keyline on offset Lemon + Chili sheets, each rotated a degree differently, sheets smaller than the photo (placemats, not a container). Depth by colour-block layering — no shadows. Caption is **non-tappable** — either the dark-scrim treatment (Golos Caption on a small dark scrim, bottom corner) or the shared Lemon caption label. Photo card is the link to the active section, so whichever is used, the whole card is one tap target and the caption carries no edge of its own affordance. *(Revised Aug 2026: the original line read "never a pill" — an over-broad ban written before the `img` component's caption label was accounted for. The real risk is a separately-tappable-looking object inside a link, not the pill shape; narrowed accordingly. See Image caption label.)* Night twin: same stack, quiet dressing — Soft Peppercorn sheet + thin Chili edge ("the same table after dark"). If guests read a Polaroid into it, that's a free easter egg — never design toward it (no white frames, no handwriting).
- **Description** below the stack on the page ground (never on a mat), per-state component property. No CTA button **on pointer devices** — the word list's arrows are the actions; a button returns only if a state gets a non-navigation action.
  - **Touch exception (decided Aug 2026) — the no-CTA rule is scoped to pointer input, not retired.** On desktop, hover and click are two separate channels, so one word carries both *preview* (swap the photo) and *commit* (go to the section). Touch has one channel; a word cannot be both. Rather than drop the preview — the mechanic concept B won its test on — touch gives commit its own object: tapping a section word previews it, and a boxed action below the description commits ("Breakfast menu"). Consequences, all required together: the active word **drops its trailing arrow** at this breakpoint (the arrow means "this word is the action," and on touch it isn't); tapping the **already-active** word commits, so a second tap is never a dead end; the photo card stays a link to the active section, as on desktop.
- **Room wordmark:** giant Molot, bleeding off the corner, always the current room, always filled — colour is `--accent-2` (Olive by day, Lime by night), one rule across modes.

**Word list roles** — colour carries ownership, outline→fill carries state:
- Defaults: outline → active fills + trailing arrow (arrow may be hover/active-only on section words). Day: Chili outline (resolves the old Paprika-on-Lemon check — there is no day band anymore). Night bar state: Paprika outline, active Chili.
- Shared sections: Lime outline → fill Lime (day: Olive). One green only; Lemon never marks a word role.
- Hover on a word swaps the photo — a navigational preview (crossfade, preloaded), not decoration.

**Idle behaviour:** opening frame = daypart answer (kitchen: breakfast morning, lunch midday…; bar: tea & coffee morning → no buzz midday → infusions evening → cocktails late). Then the highlight sweeps in list order, wrapping; first frame holds ~2× the cycle step; any interaction stops the demo **permanently** for the visit (documented exception to the 8s-resume rule — nav must not wander after use). The demo never scrolls, never changes the URL. `prefers-reduced-motion`: no sweep, static daypart frame. **Time proposes only on first entry; session memory disposes after** — a guest's explicit room choice is remembered and never re-overridden by the clock.

**The former ticker** is retired for navigation: the sticky jump-nav is an edge tab + slide-in panel (see Sticky jump-nav below), decided with the section layouts, Jul 2026. The running word-loop survives only as a *display* motif candidate (e.g. an upsell strip) — never as navigation, so scrolling text never means two different things on one page.

**Amended Aug 2026 — scrolling text now has a second job.** The Visit page's mobile status rail runs the bar/kitchen states in a Lime band (`visit-page-copy.md` → Mobile layout). The original wording of this rule ("never means two different things") was written when the ticker's only rival job was navigation; the standing rule is narrower than it reads. State it as: **scrolling text is never navigation, and never carries more than one job per page.** Day menu = Lemon display ticker; Visit mobile = Lime status rail; the two never meet. If a third job appears, resolve the device properly rather than adding a fourth — same discipline as the pill shape (Image caption label).

### Doors — the third tappable style
A door is a Molot word standing on a small tilted block with an always-visible arrow; it means "cross to the other menu." Doors name **contents** (FOOD / DRINKS — "drinks" honestly promises the smoothie); wordmarks name places (KITCHEN / BAR if used). No "MENU" suffix — the page already says menu. Doors are postcards of their destination and never re-theme:

- **Primary door** (last item of the nav word list): the FOOD door is Cream fill + Peppercorn word, hover/focus-visible fills **Lemon**; the DRINKS door is Peppercorn ground + Lime word (outline → fill on hover) — including on the day page. On dark grounds the dark door needs its own separation — Lime hairline or scalloped edge (night override).
- **Secondary door** (in-list shortcut to a section of the other menu, if used): outline grammar — Cream outline frame + word at rest, fills Lemon with Peppercorn word on hover/focus. Secondary = unlit, primary = lit; same button logic as everywhere.
- **Mirroring:** DRINKS exits with →, FOOD returns with ← — direction encodes the room metaphor, keep it site-wide.
- **Motion:** hover nudges 2–3px toward the arrow (spring, transform only); on switch the page crossfades states (candidate payoff: the split-screen seam from concept A sweeping across as the transition). `prefers-reduced-motion`: instant swap. Candidate refinement: the bottle-cap scalloped tear on the block's edge ("tear here to switch menus").
- Touch has no hover: rest state must carry the affordance alone (block + arrow do this).

### Sticky jump-nav — edge tab + panel (decided Jul 2026)
The page is long; once the hero's side-nav has scrolled away, a jump-nav takes over. The compact-ticker candidate lost to this: a loop re-reads the list one word at a time, while the panel restores the whole list at once — same reason concept B won the hero.

- **Trigger:** a persistent tab on the **left** viewport edge — the menu-side twin of the right-edge Reserve tab. Lime ground, vertical label naming the current state ("Food menu" / "Drinks menu") plus a Phosphor icon. Appears only after the guest scrolls past the hero (from the second section on); while the hero side-nav is visible it would duplicate it. Present in **every state × theme combination** — the drinks list is shorter but its sections are just as long, and one behaviour keeps the mechanic learnable. Figma can't prototype scroll-gated appearance — this is documented build behaviour, mockups show both states.
- **Panel:** slides in from the left edge (transform only, house spring; `prefers-reduced-motion`: instant swap). Anatomy is a reprise of the hero nav panel — Parchment sheet, Lime offset edge — so it reads as the hero's column coming back, not a new device. Contents follow the existing grammar unchanged: the section word list (outline → fill active, green rule for shared sections) with the **door as its last item** (mirroring rule applies: DRINKS exits →, FOOD returns ←).
- **Dismiss:** close ×, scrim tap, Esc, or choosing a word — picking a word scrolls to its anchor and closes the panel. Focus is trapped while open.
- **Not a fourth tappable style:** the edge tab is the Reserve tab's established pattern; everything inside the panel uses existing word/door styles. Nothing new to sanction.


Nav words map to guest intentions; page structure maps to the kitchen. They need not be 1:1 (a nav word may anchor a sub-head).

- **Food (9):** Breakfast · Lunch · Bar Snacks 🔶 · Salads · Sandwiches · Soups · Hot dishes · Desserts · Kids.
  🔶 **Bar Snacks — working name, under consideration.** Renamed from "Snacks & Boards" for a measure reason (too long for the 4-column nav slot with the arrow) — a legitimate poster-logic edit, but two unresolved costs: it re-demotes the boards (the original objection to "snacks"), and the word "Bar" inside the kitchen list sits near the DRINKS door — possible cross-link misread. Runner-up to test-fit: **To Share** (shorter, elevates boards, registers with «На закуску»). Decide, then propagate in one pass: nav, menu-hero-copy.md, menu-en.md, RU pairing.
- **Drinks (7):** Infusions · Cocktails · Wine · Beer · Spirits · No buzz · Tea & Coffee. (Cross-link to food snacks travels via the shared section / secondary door, not a permanent eighth word.)
- **Voice rule:** section names are plain; each list gets exactly **one** voiced name — «На закуску» on the food side, «Без градуса» / No buzz on the bar side. RU and EN are register twins, not literal translations. No second wink.
- **SUMMER dropped from the nav** (decided Jul 2026): seasonal is a tag, and a tag in a section list over-promises. The season's name lives as the Seasonal rail's own Molot heading ("SUMMER AT PEPPER"), which must sit high enough on the page to do the announcing — if the rail sinks, reopen the nav-word question.
- **Soups stays a separate section** (tested Jul 2026): participants *could* find soups under Hot dishes, but agreed it doesn't belong there. Print still files it under hot dishes — an accepted, documented web↔print divergence; keep the item data mapped so generate-print still works.

### Kitchen structure
Course order is canonical (matches print — taxonomy stays identical across web and print for the future generate-print-from-WordPress option); dayparts are a navigation lens on top, never a filter that hides content. Merges vs print: sandwiches + bagels = one section; sauces fold in as an appendix under grill/hot (no anchor of their own); soups are a full section on the web (see Section labels — tested decision) while print keeps them inside hot dishes. Kids: last section in the food list with a `#kids` anchor — no separate page (thin page, and a separate surface is where the old kids sub-style drifted off-brand; kids styling stays inside the three ramps).

### Shared sections — the green rule
Two sections belong to both rooms, one in each direction: the **soft bar** (No buzz + Tea & Coffee) is owned by the bar, rendered in both states; **Bar Snacks** 🔶 (working name — see Section labels) is owned by the kitchen, rendered in both states (it's what people order with drinks). The green ramp marks sharedness on three coordinated levels: the ticker word (Lime/Olive), a value-stepped section ground (Soft Peppercorn at night — assign night's texture-break sections to the shared ones, so the striping rhythm gains meaning; Parchment card by day), and a header chip "also in the … menu ⇄" deep-linking to the same section in the other state.

### Seasonal & specials
Seasonal is a **tag, not a section**: the dish lives in its natural category with a Lime badge, and a "Seasonal now" rail near the top is a query over the tag (decided after years of separate seasonal print pieces — integrated seasonal dishes measurably outperform them). Holiday/weekend specials: a `special` tag with an end date feeds the **Hot deals band** — a Lemon colour-block moment. Check: on day the ticker band and the deals band are both Lemon; the striping rule wants one colour-block moment per page — resolve at build (candidates: deals band steps to Cream, or the two never share a viewport).

### Bar's notes & the pairing station
- **The bar's note:** a static Paper slip beside *select* sections (breakfast → coffee of the week, grill → infusions, desserts → sweet vermouth). Always a person speaking, never "pairs well with X." One per section max, not every section; on dark grounds it's the brightest object in view — max one per viewport.
- **The pairing station:** the page's one interactive element, at the food → drinks seam — the About pairing picker reused: pick a dish, the bar answers with a printed ticket ending "jump to it →" (it doubles as the transition into the drinks state). Signature dishes may carry a small "ask the bar" chip that scrolls to the station and pre-picks the dish — one mechanic, one location, many entrances. The menu lists themselves stay a fast reading surface.

### Menu lists
Dotted-leader rows never run the full 12 columns. Dense sections run **two columns of rows** (the Grid long-form rule applied to lists); the leftover zone gets a job — a section photo or a bar's note. Exact times are allowed here (service-page exemption to the no-clock rule): "served till 12", "weekday lunch 12–16".

### Open (menu page)
- "Bar Snacks" — working name (see Section labels 🔶): decide vs "To Share" / "Snacks & Boards". *(Open test — see `testing.md`.)*
- Night **kitchen** word colours: latest mockups run the kitchen list in the lemon/lime family at night while the bar list runs Paprika — either unify on Paprika defaults or sanction per-room accent families at night and document the rule (watch that shared-green stays distinguishable).
- Double-Lemon on day: photo-stack sheets vs deals band in one viewport (see Seasonal & specials).
- Scalloped door edge — liked, not yet committed.
- Item-card anatomy (photo-per-dish vs rows + one section photo) — leaning rows + one 3:2 per section.

## Don't (web-specific)

- No clocks, countdowns, or timers in the hero.
- No generic web-template layouts (default bento, stock hero-with-photo-right).
- Buttons are the only boxed actions; chips the only inline actions; doors the only state switches (Menu page → Doors). No fourth tappable style.

General brand do/don't: `design.md` §8.
