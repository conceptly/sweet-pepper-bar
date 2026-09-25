# Sweet Pepper — Brand & UX Case Study

**Gastrobar identity system + website UX · Yaroslavl, Russia**
Role: Brand & Web Designer (solo) · Timeline: June–September 2026 · Status: theme on test hosting, RU layer in progress, style guide live · Updated September 24

[IMAGE: cocktail-1.jpg — full-bleed hero]

Sweet Pepper is a gastrobar that runs breakfast, business lunch, an after-work bar, and a late-night cocktail scene out of one venue, every day. I led the brand system and website UX for its first real design refresh: turning twelve years of loved-but-unsystematized visual assets into a coherent identity, then designing a full homepage — in both day and night states — that could represent all four of its daily identities without picking one.

---

## The brief

Sweet Pepper wasn't a café that also serves drinks, or a bar that does brunch on weekends — it was built from day one to do both, all day, with a deliberate 50/50 kitchen-to-bar revenue split maintained for years. That structural duality was the whole design problem: how do you build one homepage that reads as a breakfast spot, a lunch destination, an evening bar, and a late-night hang, without any of those audiences feeling like an afterthought?

**Key context:**
- 4.6/5 rating across 1,300+ reviews; a small but intensely loyal regular base
- Four audience segments: community regulars, the lunch/breakfast crowd, event visitors, and a "collaborator" segment of fellow venue owners and local creatives
- The most common word guests use, across every review platform, is *уютный* — cosy

## Research

I combined public review-mining (Google, TripAdvisor, Yandex, 2GIS) with founder interviews to segment the audience before touching a single layout. The standout insight: the brand's "cosy community" reputation wasn't manufactured by marketing — it grew from how the place actually runs (long-tenured staff, social media managed in-house by the floor team, dishes made permanent because guests campaigned for them). The website's job was to earn that word, not just claim it.

[IMAGE: colors.jpeg — validated color ramps]

## The challenge

Four problems, one homepage:

1. **No system, just artifacts.** Years of logos, posters, and menus with no shared color logic or type hierarchy.
2. **A palette that fights itself.** Chili red, lime, and lemon are loud individually; unsystematized, saturated color-on-color fails contrast and fatigues the eye.
3. **One venue, four identities.** Breakfast, lunch, evening bar, and late-night party each need different tone, imagery, and calls to action — inside a single hero.
4. **Generic template gravity.** Early drafts kept defaulting to stock restaurant-site patterns: hero photo, headline, card grid — nothing specific to this bar.

## Building the brand system

**Color.** The generative rule: every brand color is a tint or shade of exactly three hues — red, green, yellow — plus neutrals. Need a new shade? Move along an existing hue line; never introduce a new one. That single rule turned a chaotic set of "loud" colors into something provably harmonious. (An early "colour-blind safe" claim was later audited and narrowed — see The audit below; the standing rule is that no colour carries meaning alone.) A dedicated "Deep Chili" token was added specifically so red text could pass AA contrast at small sizes.

**Type.** Molot (heavy, condensed, all-caps) leads every headline; Golos Text, a warm grotesque with strong Cyrillic support, carries everything meant for reading. No serif, no second display face — hierarchy comes from size, colour, case, and position, the same logic as a Constructivist poster. This pass added a dedicated **form label / form hint** style pair — kept separate from Caption so that role stays scoped to captions and fine print, not diluted into "whatever's small" — plus a `text-wrap: pretty` rule on body copy to avoid orphaned words now that the grid gives paragraphs a fixed measure.

**Logo.** The chili-and-shaker mark and the bottle-cap seal already had years of recognition and guest affection — research gave no reason to replace them. The work was consolidation: six defined lockups (horizontal, rectangular, stacked, stamp, symbol, favicon), one clear-space rule, minimum sizes, and defined backgrounds.

[IMAGE: logo-horizontal.png — consolidated wordmark]

## Designing the hero: nine drafts to find the idea

[IMAGE: opt2-crop.png / opt5-crop.png / opt7-crop.png — process row]

Early explorations proved the brand assets worked together, but the layout logic was still generic restaurant-template thinking — a centered hero, a card grid, a static headline. All of them made the same mistake: one static headline trying to represent an all-day venue.

**The reframe:** the venue already changes its whole identity four times a day. So let the website do the same thing — automatically, tied to the guest's real local time — instead of forcing one static moment to represent all of them. One hospitality principle shaped the mechanic more than anything else: the **no-clock rule** — good service makes guests lose track of time, so the hero could never show a literal clock or countdown. That constraint pushed the solution toward a metaphor (heat, not time) instead of a literal schedule widget.

## The solution: the spice slider, refined

[IMAGE: day-hero-crop.png / night-hero-crop.png — day/night hero pairing]

A heat slider with four stops — breakfast (mild), lunch (warm), dinner (spicy), party (on fire) — doubles as the site's day/night control. This pass locked down the interaction detail:

- **An icon per daypart.** The slider handle swaps icon as it moves — coffee cup, fork, wine glass, cocktail — so the metaphor reads at a glance, no label required.
- **"Now" is never lost.** A separate marker pins the real current daypart even while a guest drags the handle elsewhere to preview — the peek never overwrites the truth. This is the concrete answer to "how do you let guests explore without breaking the no-clock rule."
- **One status line, four meanings.** "The kitchen's on — no rush" persists across every state — informative without ever becoming a countdown.
- **A peek, not a switch.** A small day/night control lets guests preview the other state ("curious about tonight? →"); real time stays the source of truth and it auto-reverts.

[IMAGE: heat-control.jpg — detail states of the slider handle]

## AI-assisted exploration: six ways to feel the heat

Before locking the shipped interaction, I used Claude to rapid-prototype six divergent, fully-interactive variants of the heat slider in one afternoon — each pressure-testing a different way to express "heat = time" against the brand and hospitality rules already in place:

- **1a · Ember gradient** — the fill heats up left-to-right (olive → paprika → chili); heat read purely through color temperature.
- **1b · Proportional segments** — four bars sized to real opening-hour spans, not equal quarters — a more honest hours-of-operation gauge.
- **1c · Hour ruler** — literal tick marks from 07:00 to 02:00 with a live "HH:MM · daypart" readout above the thumb.
- **1d · Type scrubber** — the daypart words themselves are the UI: past labels solid, the active one chili-colored, future ones a faint outline.
- **1e · Matchstick burn** — a five-stop ember gradient (near-black → rust → chili → yellow) with a glowing flame thumb.
- **1f · Status card** — the slider shrinks to a thin scrubber beneath a dashboard readout: "Right now · time," a big daypart word, and a CTA pill that swaps text per daypart.

**Prototyping fast doesn't mean accepting fast.** Sorting the output against the project's own rules mattered more than the prototyping itself:

*Kept:* 1d's label transition matched the shipped spec exactly (solid → chili → outline) — good validation that the documented rule already reads correctly to an outside model. The separate "now" marker was confirmed as the right call; toggling it on and off made clear how much the "peek, don't switch" idea depends on that marker never disappearing. 1b's real-hours segments are a stronger metaphor than four equal quarters and are a solid candidate for the next iteration.

*Parked or rejected:* 1c's hour ruler reads great but reintroduces the literal clock the no-clock rule exists to prevent — rejected on principle, not execution. 1e's matchstick gradient is beautiful, but its rust and near-black stops sit outside the three-hue-ramp rule and would need rebuilding from existing chili-ramp tokens to stay compliant. 1f's status-card layout is a strong pattern, but de-emphasizing the slider undercuts the "one control, three jobs" mechanic — parked for a possible inner page, not the hero.

## Round two: the mechanic outlives the widget

Then usability testing did its job on the signature interaction itself. A participant called the slider "too complicated" — and fairly: the rail carried four labels, a knob, a now-marker, a status line and an instruction — six pieces of chrome to communicate one fact. A/B against alternatives, a **four-tile photo grid** won, first on mobile and then as the current desktop state: one tile per daypart, the selected tile large (size carries state — the grid *is* the scale), a photograph of eggs saying "morning here" faster than the word BREAKFAST, in both languages at once.

What matters is what survived: **heat = time, the state model, the status-line matrix, and the day/night flip all carry over** — tapping a dinner tile darkens the site, and the tile grid becomes the mobile day/night control outright. The NOW pip stays independent of selection, the same two axes the slider had; there's no auto-revert, because time proposes and memory disposes. The costs went on record next to the win: sixteen art-directed photos instead of four, maintained by the team; an all-day story less visible at a glance (mitigations noted, not built); and the layered-sheets device stays desktop-only — at mobile tile sizes a 4px offset reads as print misregistration, not depth.

**Final form (September): the visual slider is the hero at every width.** The call rests on three legs — responsiveness (the audience is mobile-first, and the rail always favoured desktop), usability, and A/B results. The last refinement came from the browser rather than Figma: the cards grew until the selected tile carried the composition, closing the "desktop as the mobile stack widened" complaint for good.

[IMAGE: design/process/home/img-slider/state=breakfast-half.png / state=diner-half.png — final hero, day and night states]

## From hero to full homepage

[IMAGE: home-ia.png — information architecture]

With the hero mechanic proven, the homepage grew to its full shape — seven sections, mapped as an IA before layout began: **Hero** (spice slider) → **Community Hits** (permanent-by-guest-demand menu items) → **Home Made Infusions** (the bar's signature craft proof) → **Seasonal Kitchen Menu** (the food's quiet-retention story) → **The Pepper Story** (About-page teaser) → **News, Parties, Promos** (manual social feed mirror) → **Find Us** (map, reservation form, hours, footer).

[IMAGE: strip-full-day.jpg / strip-full-night.jpg — full-page day/night scroll comparison]

Section grounds alternate on purpose — but the rhythm runs on different logic in each state, a decision that took real iteration to earn. **Day alternates cleanly**, light/dark down the page, with one Lemon band as the single colour-block moment (saturated hues stay banners, never full-page surfaces). **Night doesn't checkerboard — it commits.** Inverting the daytime-poster rhythm after dark read as mechanical; instead night goes immersively dark — "being in the bar after dark" — with Lime and Chili accents glowing out of shared darkness, long dark runs broken by a new **Soft Peppercorn** token (a ~4-point luminance lift over Peppercorn: texture without contrast), and one bright section left as the single mid-page point of light. Contact/footer stays dark in both modes — the wind-down zone at any hour.

The same work stress-tested the palette itself: Soft Peppercorn earned a permanent slot in the neutral ramp, while Dark Olive — a token that never found its job (too close to Peppercorn in value, too hue-shifted to be quiet) — was first demoted to "under consideration" and then, once the menu pages settled its last candidate role, removed outright. A living system removes tokens as deliberately as it adds them. The day state got its own correction later: the original "photo washed with Paper ~90%" rule flattened the photography and was retired — day photos now run at full saturation, with day energy coming from tilt, hard Peppercorn keylines, and the Lemon band instead of a wash.

## Content strategy: writing the About page

I drafted the full About page copy from the research brief and founder interviews, then restructured it once the material showed a better shape. The final arc: **Hero → Story → Concept → Mission → People → Recognition → Location → Careers → Visit.** Two moves matter most. **The Story got a face** — founder Iurii Primyshev, credited with photo and quote. And **The People became the centerpiece**, split into two equal halves: the Team (low turnover, in-house social voice, a "meet the team" card grid) and Our Guests — teasing a separate photo-library page built around the event photo sets guests already hunt for after every party. The equal split structurally rhymes with the 50/50 kitchen/bar concept without having to say it. Recognition evolved from a stats banner into "How it feels" — an interactive word cloud of the words guests actually use in reviews (уютный, душевный), with real quotes rotating beneath; perks became a stamp strip. A project-wide **voice rule** also came out of this content work, promoted to the design system by the founder: copy speaks from the guest's side ("Your route to Pepper," never "Find us"), while the venue says "we" in exactly one place — ticket replies, where the bar is literally answering. Every claim still traces to a source — nothing is invented beyond phrasing.

## Interaction system

A loud, playful brand risks every piece of text looking clickable, so I defined a closed vocabulary for interactivity — now exactly three styles: **boxed buttons** (Golos SemiBold 16, primary actions only), **inline chips** (Golos Medium 13 with an icon or arrow, secondary actions), and **doors** — a Molot word on a small tilted block with an always-visible arrow, used *only* for crossing between the food and drinks menus. Nothing else may be door-shaped. Everything else, including expressive copy like "Pick your heat!", stays in Molot and is visually tied to what it points at. The same logic extends to colour: in mixed rows, **Chili is reserved for the action** — heat means "act," content chips stay lime.

The system grew two site-wide devices this phase. **The bartender's ticket** — an order slip the interface "prints" to answer the guest (always Paper, day or night — a receipt is paper regardless of the hour; the reply is always a person speaking, never a template). It opens and closes the Visit page, powers the About pairing picker, and ends every page as the footer slip. And a **motion language**: outline→fill is the one state change everywhere; one idle clock per section; untouched sections demo themselves and any interaction seizes the clock; spring easing, transforms only; `prefers-reduced-motion` keeps state changes and drops the theatre. Accessibility carried through here too: Chili on Peppercorn measures roughly 3.4:1 — fine for large Molot headlines, but it fails small text, so small accent text on dark surfaces uses Paprika or Lemon instead.

## Systemizing further: grid and image ratios

**Grid.** A 1120px content width, 12 columns, 24px gutter. Body copy caps at 6 of 12 columns on desktop — even inside full-bleed sections — set by column count, not word count, so it stays predictable regardless of what copy lands in it. Leftover columns always get a job: short teasers pair with a stat or pull-quote; long-form splits into two reading columns instead of one narrow column plus dead space.

**Image ratios.** Fixed ratios, one per content job: **3:2** for art-directed photography (menu items, drinks, hero, events), **2:3** as its portrait counterpart (fixed across breakpoints, not stretched on mobile), **1:1** for general use, **21:9** for cinematic full-bleed environment banners only, and **4:5** for News/social cards specifically, matching Instagram's own crop norm. Deliberately excluded: 16:9 (a redundant middle ground) and 9:16 (a genuine mobile hero is a CSS sizing problem, not a fixed-ratio-component problem). A sixth ratio — **4:1** divider bands for information-dense pages — was admitted later when the menu page produced the content job for it: the system grows when a job appears, never per breakpoint.

## The menu page: tested, not guessed

One page holds both menus, built on two independent axes: **content state** (food/drinks) and **theme** (day/night). Theme follows the clock site-wide; state only *defaults* from it and the guest overrides freely — kitchen content at 9pm is kitchen content in night clothes. Time proposes, memory disposes: an explicit choice is remembered and never re-overridden.

The hero went through three competing concepts — a carousel/ticker, a split-screen, and a side-nav poster — and the call was made by **stakeholder A/B and usability testing**, not taste: the side-nav poster won on the page's stated KPI, *time-to-dish*, with all sections visible at once. The losing ticker survives only as a display motif; navigation that scrolls lost to navigation that stands still. Testing settled smaller questions too: soups earned a separate web section even though print files them under hot dishes — an accepted, documented web↔print divergence — and seasonal became a **tag, not a section** (years of separate seasonal print pieces underperformed integrated dishes). Crossing between menus got its own device — the **door** (see Interaction system) — and once the hero scrolls away, an edge tab slides the same nav panel back in: the hero's column returning, not a new mechanic to learn.

## Copy as a system: the status lines

The slider's status line grew into a full content system: four stops × five states — beginning, full swing, last call, off-hours, plus *closed* on the edge stops only, because the scale enumerates offers and closed isn't one. Overnight the knob parks on the next open door; the site points forward, never at a dark room. Every line follows one format, [fact] — [reassurance/wink] ("lunch till 4 — no rush"), in clockless numerals — "till 12", "1:30", never AM/PM — so the no-clock rule survives contact with an actual schedule. Weekends rewrite the second stop from the same ACF hours source: LUNCH becomes BRUNCH, and since no separate brunch menu exists, the copy frames that as generosity — "the brunch menu is the whole menu, that's the deal." On the build side the discipline holds too: only stop × mode × marker are Figma variants (16 max); every status line is a text prop, so the copy matrix never explodes the component set.

Testing also got its own instrument this phase: a **validation log** (`testing.md`) that tracks every open question with a prediction on record *before* the test runs, and labels the evidence honestly — what was user-tested versus decided on performance data or rule-sorting. Decisions stop getting stranded inside whatever document prompted them.

## Going mobile: same rules, one hand

The mobile pass was a stress test of the system, and the system mostly held — where it didn't, the rules were amended in daylight rather than quietly violated. The nav collapses into a full-screen **drawer** that themes by time like every other surface: Molot items with guest-voice descriptions, outline→fill marking "you are here" (readable in greyscale — colour never carries state alone), and a booking block where **phone leads**, because Russian guests book by call.

The sharpest finding: the menu hero's no-CTA rule turned out to be **scoped to pointer input**. Hover and click are two channels, so one word can carry both preview and commit; touch has one channel, so a word can't be both. On touch, tapping a word previews it and a boxed action commits — and the active word drops its trailing arrow, because on touch it isn't the action. The rule wasn't wrong; its scope was.

Reserve's right-edge tab doesn't survive a 390px screen. Three placements were tried, rejected, and **written down with their failure modes** so the ground never gets re-covered — current leaning: no persistent Reserve on mobile at all, with the drawer and in-content actions carrying it. Two older rules were formally narrowed the same way: the "never a pill" caption ban (the real risk was a tappable-looking object inside a link, not the pill shape) and the scrolling-text rule, restated as *never navigation, one job per page* when the Visit status rail gave scrolling text a second legitimate use.

## The Visit page: three anxieties, in order

The page answers *are you open right now → how do I find you → can I get a seat* — and it's the one page where the clock works **for** the guest (the documented service-page exemption to the no-clock rule). The hero *is* a bartender's ticket: the interface prints today's status the way the bar would answer.

Three calls worth showing. **A journey/stay rule** splits house facts between pages from one ACF source — if it affects the journey to the door it renders on Visit, if it affects the stay it renders on About; never a copied section. **A two-speed contact model**, on the founder's explicit reasoning that a guest with a channel to complain is a guest whose issue can be resolved: fast lane (phone, DM) for tables, slow lane (form + email) for feedback — with the form deliberately styled to never look like the booking path (no Booking topic chip, a redirect line above it, "a person reads this — usually same day"). And **Yandex Maps over Google**: Google's free embed is single-pin and its Yaroslavl data is weak; Yandex fits the audience and the no-foreign-vendor logic — capped at four pins, because the section's job is "you'll recognise it," not a tourist map.

## Platform decision: a constraint no moodboard would show you

**Why not Webflow.** Webflow is a US company bound by OFAC sanctions: it can't serve Russian accounts or payments, and Webflow-hosted sites don't reliably reach visitors physically in Russia. For a Yaroslavl gastrobar, that's not a technicality — it's the site failing to load for its own guests.

**The call.** Self-hosted WordPress, a fully custom hand-coded theme, and Advanced Custom Fields. No foreign vendor in the loop, hostable anywhere including Russia, and ACF scopes day-to-day editing — hours, menu items, news posts — to the team without exposing the layout to accidental breakage.

**The stack closed in August, with the rejections written down.** A *classic* PHP theme, not a block theme — the team edits content, never layout. PHP stays deliberately thin: a data layer whose templates hold "a loop, an `if`, and holes," while everything that carries the design lives in CSS and JS (the daypart engine is client-side by necessity — a page cache would serve the wrong hour). Vite compiles tokens straight from `design.md`. A **plugin cap of four** — ACF, Polylang, a page cache, backups — with a displacement rule: anything proposed later must replace one, in writing. The 2016 failure mode wasn't one bad plugin; it was the absence of a rule about adding them. **Headless was evaluated seriously and rejected on operations**: Next outright (React plus a US-host dependency for a site of text and photographs); Astro was the credible option but means two systems, rebuild-gated content edits, and handover narrowing from "any WordPress freelancer in Yaroslavl" to the author permanently — the Astro appetite goes to this case-study site instead. **Tilda was rejected on the design, not the politics**: no token layer for day/night, no content model for tagged dishes, and the three tappable grammars stop being structurally enforceable, block by block, until they drift.

**Content ops: launch small, phase up.** The News page is deferred at launch entirely — no dead nav items, zero API dependencies, and the team learns WordPress on low-stakes content first. Phase 2 adds manual News cards (pasting posts they already write for VK/Instagram costs seconds). Phase 3 adds importers as drafts a human approves: VK's non-sanctioned API pulled directly, and Instagram via a small proxy *outside* Russia — importing self-hosts the images, so IG content becomes visible to Russian guests too, the one approach that serves both audiences. Never a live Instagram embed: blocked for RU visitors regardless of API status.

## The audit: recompute your own claims

Before the first line of theme code, all eleven project documents were read in full and cross-checked — with contrast ratios and colour-vision claims **recomputed from the hex values rather than read from the tables**, per the project's own standing instruction. The audit found real problems in the system's favourite sentences. The interaction rule — "exactly three tappable styles" — was false as written: five shipped specs (the daypart tiles, the perk stamps, the word cloud, the EN/RU pill, arrowed nav words) sat outside it, so the fix is a *closed, sanctioned exception list* — the value was never the number three, it's the list being closed. The price colour fails AA: Olive on Parchment measures 3.68:1 in exactly the small-text menu rows it was assigned to — a token decision now queued before any CSS variable is written. And the palette's "colour-blind safe — no conflicts" claim is measurably false: under protanopia, Chili and Olive — day mode's two accents, adjacent on every menu row — collapse from ΔE 78 to 10. The claim narrows to what's true and testable: **no colour carries meaning alone.**

The discipline matters as much as the findings: the audit changed nothing silently — findings only, both sides named where documents disagree, the calls left to the author — and it's sequenced as a work order, not a report card: A-items would become bugs or wrong guest-facing facts, B-items block specific build phases, C is hygiene, and a section lists what came back clean, so the rest of the system can still be trusted.

## From spec to code: the build

With the audit's A-list cleared, the theme build began — in exactly the shape the stack decision promised. A classic WordPress theme now runs locally with Vite compiling tokens straight from `design.md`; the day/night mechanic, the tile-grid hero, the side-nav menu hero with its doors, all nine food sections plus the bar menu, and the rugged-edge ticket component exist as working template parts. The AI workflow scaled with it: the theme is built one chat per section, steered by files rather than chat history — a living project report whose first line is "read this before writing any code," agent briefs, and subagents — with git pushes handled through Claude Code. The docs stopped being descriptions of the design and became its interface.

## The style guide ships as a product

The design system got its own audience-facing deliverable, live on the bar's domain: a **single-file bilingual style guide** — EN and RU as layers in one HTML file with a language switch — an app-style mobile shell below 768px, and A4 PDF renders (EN 28pp, RU 31pp) from a scripted pipeline. An in-page edit mode commits text fixes to the repo straight from the live page. Two details carry the philosophy. Every margin, padding and gap is snapped to a 4px grid by a checker script — the guide obeys the system it documents. And the logo clear-space rule became a drawn four-card figure, constructed at load time from the artwork itself, after a teammate missed the rule in text form: **if a rule gets missed, the fix is showing it, not restating it.** The same pass amended a rule in daylight — social icons are the official full-colour marks, because they're contacts, not supporting icons; the earlier single-colour rule was a misreading of the source. Alongside the guide: short team-facing design guides in both languages, derived from the system with no history and no open questions.

## Living content: systems that outlive launch day

Two content mechanics got operating rules, not just layouts. **"How it feels"** — the review word-cloud — runs on a curated pipeline instead of a live API, the same call as the News feed for the same reasons: a periodic tally of the words guests actually use, a 12-card quote wheel with a written admission rule (up to three new cards per update, each retiring the oldest; a quote whose word isn't in the cloud waits), and a ledger recording every card's added/retired dates so the wheel's history stays auditable. **The Pepper Story** timeline was chosen from four interaction studies that deliberately included a rule-breaking candidate — a giant live-ticking Molot numeral in a Lemon band — per the project's standing agent brief: always offer the option that breaks a stated rule and argue whether it earns the exception. The heat line won on system grounds: the timeline joins the outline→fill grammar the rest of the site already speaks, so a new section arrived without a new vocabulary.

## The content model: who edits what

The build forced the CMS question the docs had deferred, and sorting by content type dissolved most of it. Three tiers: **rows** (menu items, hours, quotes, news) live in the WordPress admin as structured data; **prose** (the story, hero leads, section intros) lives in ACF fields — one group per page template, block editor off; **structure** (section order, image ratios, the daypart engine) is code and never editable. A bespoke keyed store was considered and dropped: ACF is the store, and an in-place editor — a port of the style guide's — is a *later layer* over the same fields, built only if the admin form annoys the team. The 239 hardcoded dish rows were already structured template-part calls, so migration is a script, not a rewrite. Languages lean "one document, two languages" — one page per template, PHP rendering one language per request — with the Polylang decision deliberately pinned to a real extraction rather than made in the abstract. And the temptation got tested instead of resisted: a page-builder rebuild of About runs as a side experiment in a separate install, judged against criteria written down *before* it started.

## Responsive: the band between phone and desktop

The responsive pass produced its own findings-on-record. In the 768–991px band the desktop hero row read as thumbnails under a wrapping headline — "the desktop stack narrowed," the same fault as the desktop's empty right third — so portrait tablets get the phone bento instead, **guarded by height, not width** (`min-height: 1000px`), so a narrowed desktop window keeps the row. The page gutter became one fluid clamp, and its off-grid interpolated values got a written carve-out from the 4px rule — nothing aligns against a page margin — after a rounding variant was built and rejected for trading one 111px cliff for fourteen 8px sawteeth. The pass closed by cataloguing **the five responsive faults that kept recurring** as a checklist: the testing-log move again — record the pattern, stop re-finding it.

Copy got the same rigor. The Menu and Visit copy reviews open by declaring their evidence limits ("no live Figma inspection is claimed"), caught a shipped row reading "Horseraddish" with the literal word "description" as its copy — corrected in the clean files and flagged for the implementation pass, not hot-fixed — and started the RU layer as register twins: «Для смелых — Ярославль с огоньком» carries the wink of "For the brave — a taste of Yaroslavl's hot side," not its words.

## The Russian layer: a voice, not a translation

The RU side arrived as a system, not a file of translations. A dedicated **voice-and-vocabulary document** distils the bar's own editorial voice — the one the floor team already writes on social media — into rules a drafting session can be checked against, with a per-line test for new copy. RU and EN stay register twins: «Для смелых — Ярославль с огоньком» carries the wink of its English twin, never its words. One tension is recorded openly instead of resolved by fiat: the guest-perspective rule ("your route," "your order") and the venue's natural «мы» collide harder in Russian than in English, and the doc holds the contradiction where future drafts can see it. Even the display layer is bilingual by construction — the giant outlined Molot connectors now exist as separate RU-drawn SVGs for every section rather than swapped strings.

## Content ops, tested for real

Two calls this phase came from evidence gathered on the actual system, not mockups of it. **The admin got usability-tested too:** menu storage — a repeater per section versus dish posts placed by relationship lists — was tested with two team members on the real WordPress admin. Dish posts won: harder to mix up dishes in a table, and the team would rather search than scroll a nested repeater, since price is the edit they actually make. The prediction on record (that the repeater would win the batch reprice) **lost, and the log says so** — a prediction is only honest if it can lose. Small sample, accepted for a reversible choice; the loser archived, not deleted.

And the **VK feed importer** — the launch-phasing plan's automation step — was built for the Russian side with an evidence table before any live run: `wall.get` verified locally and on the host, images self-hosted at the 4:5 card ratio, re-imports idempotent (unchanged posts untouched, hand-edited captions surviving source edits), posts deleted from the wall demoted to draft gently on the second miss, and failures recorded without secrets in the error line. An exposed credential was revoked and replaced the day it happened. The EN feed stays manual and independent by design — the two languages never share a pipeline dependency.

## Where it stands

**Done:** the full design system, validated, audited, and pruned; all four pages designed and built in both states across phone, the tablet band, and desktop; heroes, menu storage, and the admin itself usability-tested; the theme on test hosting with the menu migrated to its decided storage; the VK feed importer built and evidence-verified; the RU voice document and first RU drafts; the bilingual style guide live with PDFs and an edit mode; stack, plugins, maps, and launch phasing closed.

**Next:** finish the RU layer; the first live VK run and the pending eyes-on checks; the hours-settings usability test with an Editor-role manager; the remaining Figma guide pages; the queued tests (Home label, "Bar Snacks" naming, mobile status rail); the sixteen hero photos and the team shoot; launch phase one.

## Reflection

- **Systemizing beats redesigning.** The strongest move was often restraint — keeping a logo guests already loved and building rules around it, instead of replacing it to prove originality.
- **Constraints found the idea.** The "no-clock" principle looked like a limitation; it's actually what forced the spice-slider metaphor instead of a literal schedule widget.
- **The best call isn't always a design call.** Ruling out Webflow had nothing to do with aesthetics — sanctions would have made the site invisible to its own market. Good UX work sometimes means researching infrastructure, not layouts.
- **Loud color needs more rules, not fewer.** A playful, saturated brand doesn't get to skip accessibility — it needs a stricter generative rule to stay usable at all.
- **Iterate the layout, not just the polish.** Early drafts look like incremental cleanup, but the real unlock required rethinking the hero's job, not its spacing.
- **Night mode isn't inverted day mode.** Flipping the same alternation after dark read as mechanical; night earned its own logic — immersion with points of light — while sharing every token with day.
- **Test the layout, trust the result.** Weeks of menu-hero exploration ended not with the prettiest concept but the one that won stakeholder A/B and usability testing on a stated KPI — and the retired concepts still paid rent as motifs and transitions.
- **Amend rules in daylight.** Mobile broke three desktop rules; none were violated quietly. Each got its scope examined — the no-CTA rule was pointer-scoped, the pill ban meant something narrower, Reserve's edge rule simply doesn't fit 390px — and the amendment written down with its reasoning. A system you can't revise honestly is a system people route around.
- **The mechanic is the idea, not the widget.** When a participant called the spice slider "too complicated," the slider died and nothing important was lost — heat = time, the state model, and the status copy all survived into the tile grid. Holding the concept loosely at the widget level is what let the concept survive at all.
- **Recompute your own claims.** The docs said "colour-blind safe"; re-deriving from the hex values said otherwise, and the price colour failed AA in the exact rows it was assigned to. An audit that changes nothing silently — findings sequenced against the build, calls left to the author — turned out to be the cheapest QA the project ran.
- **If a rule gets missed, draw it.** The clear-space rule existed in text and a teammate missed it; the fix was a figure constructed at load time from the artwork itself. Documentation failures are design problems, not reader problems — and a guide that obeys its own grid is the proof its rules are usable.
- **A prediction is only honest if it can lose.** The testing log records a prediction before every test — and the menu-storage test proved one wrong: the repeater didn't win, dish posts did, and the log admits it. A log that only ever confirms its author isn't evidence; it's decoration.
- **Development is a design review you can't argue with.** Being heavily involved in the build phase surfaced real-world limitations no mockup shows — a page cache that forces the daypart engine client-side, touch input that can't carry hover's double duty, sheet offsets that collapse into colour fringing at mobile sizes — and design decisions I was attached to had to be reconsidered because of them. The decisions that survived are stronger for having met the constraints; the ones that didn't were never going to survive contact with guests either.
- **AI accelerates divergence, judgment still curates convergence.** Six working slider prototypes from Claude in one afternoon — but half of them quietly broke a rule the project had already earned, like reintroducing a literal clock. The skill wasn't prompting; it was knowing which three to discard.

---

*Full deck available as [PDF] / [PPTX]. Get in touch: etualechka@gmail.com*
