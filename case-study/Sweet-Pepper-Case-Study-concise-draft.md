# Sweet Pepper — Brand & UX Case Study

**Gastrobar identity system + website · Yaroslavl, Russia**
Role: Brand & Web Designer (solo) · Timeline: June–October 2026 · Status: live on the bar's domain in Russian and English, style guide live; not yet opened to search engines · Concise draft, updated October 20

Sweet Pepper runs breakfast, business lunch, an after-work bar and a late-night cocktail scene out of one room, every day. I turned twelve years of loved but unsystematised assets into a brand system, then designed and built a site that changes with the time of day — and kept building after launch, where the real findings were.

**Six chapters, in the order they happened:** the bar and the brief · the system, balanced · strategy for the site · Figma, prototypes, findings · building with AI · real use.

---

## 1 · The bar and the brief

Sweet Pepper was never a café that also pours, or a bar that does brunch. It was built to do both, all day, with a 50/50 kitchen-to-bar split held for years. That duality was the design problem: one homepage that reads as a breakfast spot, a lunch place, an evening bar and a late-night hang, with none of those guests feeling like an afterthought.

**Who shows up.** Review mining (Google, TripAdvisor, Yandex, 2GIS) plus founder interviews, before any layout. 4.6/5 across 1,300+ reviews; four segments — regulars, the lunch and breakfast crowd, event guests, and fellow venue owners and local creatives. The most common word, on every platform, is *уютный* — cosy. It wasn't manufactured: long-tenured staff, social media written by the floor team, dishes made permanent because guests campaigned for them. The site's job was to earn that word, not claim it.

**Four problems, one homepage.**
1. No system, only artifacts — years of logos, posters and menus with no shared colour logic or type hierarchy.
2. A palette that fights itself — chili, lime and lemon are loud alone; saturated colour-on-colour fails contrast and tires the eye.
3. One venue, four identities — each needs its own tone, imagery and call to action, inside one hero.
4. Template gravity — early drafts kept defaulting to hero photo, headline, card grid.

## 2 · The system, balanced

**Colour.** Every brand colour is a tint or shade of exactly three hues — red, green, yellow — plus neutrals. A new shade moves along an existing hue line; a new hue is never added. One rule turned a chaotic set of loud colours into something provably harmonious. Deep Chili was added so red text passes AA at small sizes.

**Type.** Molot — heavy, condensed, all caps — for every headline; Golos Text, a warm grotesque with strong Cyrillic, for everything meant to be read. No serif, no second display face: hierarchy comes from size, colour, case and position, as on a Constructivist poster.

**Logo.** The chili-and-shaker mark and the bottle-cap seal had years of recognition; research gave no reason to replace them. The work was consolidation: six lockups, one clear-space rule, minimum sizes, defined backgrounds.

**The rules ledger.** A living system removes and narrows rules as deliberately as it adds them. Every change below was made in daylight, with its reasoning written down.

| Added | Removed | Narrowed |
|---|---|---|
| Soft Peppercorn — a four-point luminance lift for night texture | Dark Olive — never found its job | "Colour-blind safe" → *no colour carries meaning alone* (Chili and Olive collapse under protanopia) |
| A form label / form hint pair, kept apart from Caption | The day photo wash — photos run at full saturation; day energy comes from tilt, keylines and the Lemon band | "Exactly three tappable styles" → a *closed* exception list; the value was the list being closed, not the number |
| A 4:1 divider ratio, admitted when the menu page produced the job | The social icon single-colour rule — they are contacts, so the official marks | The pill ban → no tappable-looking object inside a link; the scrolling-text ban → never navigation, one job per page |

**The style guide ships as a product.** One bilingual HTML file, EN and RU as layers with a switch; an app-style shell below 768px; A4 PDFs (EN 27 pages, RU 30) from a scripted pipeline; an edit mode that commits text fixes to the repo from the live page. Every margin and gap is snapped to a 4px grid by a checker script — the guide obeys the system it documents. The clear-space rule became a figure drawn at load time from the artwork, after a teammate missed it in text: if a rule gets missed, draw it. The Figma library mirrors the guide, with a Russian edition of all 27 pages.

## 3 · Strategy for the site

**Heat = time.** Nine hero drafts proved the assets worked together and the layout logic was still template thinking: one static headline trying to represent an all-day venue. The reframe: the venue already changes identity four times a day, so the site does the same, tied to the guest's real local time. One hospitality principle shaped the mechanic — the **no-clock rule**: good service makes guests lose track of time, so the hero may never show a clock or a countdown. Heat, not time, became the metaphor; the status line, "the kitchen's on — no rush", stays informative without ever counting down.

**The page, before the layout.** Seven sections mapped as an IA first: Hero → Community Hits → Home Made Infusions → Seasonal Kitchen → The Pepper Story → News → Find Us. Day alternates cleanly, light and dark, with one Lemon band. Night doesn't checkerboard — it commits to darkness, with Lime and Chili glowing out of it and one bright section as the mid-page point of light. Contact stays dark in both.

**Platform: a constraint no moodboard shows you.** Webflow is bound by US sanctions — no Russian accounts or payments, and its hosting doesn't reliably reach visitors in Russia. Tilda was rejected on the design: no token layer for day/night, no content model for tagged dishes. Headless (Next, Astro) was rejected on operations: two systems, rebuild-gated edits, handover narrowing to me. The call: self-hosted WordPress, a classic hand-coded theme, Secure Custom Fields (the free ACF fork, no foreign licence) for everything the team edits. PHP stays thin — "a loop, an `if`, and holes" — and the design lives in CSS and JS, with Vite compiling tokens straight from `design.md`. A **plugin cap of four** with a displacement rule: anything new must replace one, in writing. The 2016 failure wasn't a bad plugin; it was the absence of a rule about adding them. Polylang's slot was later freed the same way: one theme file routes Russian at `/` and English at `/en/`, every text a RU/EN pair, hreflang for the twin.

**Who edits what.** Rows (dishes, hours, quotes, news) are structured records in the admin; prose (leads, intros, the story) lives in fields, one group per page template, block editor off; structure (section order, ratios, the daypart engine) is code and never editable. Launch small, phase up: no News page at launch, manual cards next, importers as drafts a human approves last. Never a live Instagram embed — blocked for Russian visitors regardless of API.

## 4 · Figma, prototypes, findings

**The spice slider, and what outlived it.** A heat slider with four stops doubled as the day/night control: an icon per daypart, a separate NOW marker so a peek never overwrites the truth. Then usability testing did its job: a participant called it "too complicated", fairly — six pieces of chrome to say one fact. A/B against alternatives, a **four-tile photo grid** won, on mobile first and then everywhere: the selected tile large, size carrying state, a photo of eggs saying "morning here" faster than the word in either language. What survived is what mattered — heat = time, the state model, the status-line matrix, the day/night flip. The costs went on record beside the win: sixteen art-directed photos instead of four, and the layered-sheets device staying desktop-only.

**Six ways to feel the heat.** Before locking the interaction, Claude prototyped six working slider variants in an afternoon, each a different way to say heat = time. The sorting mattered more than the prototyping: one matched the shipped label rule exactly, one (real-hours segments) is a candidate for later; one reintroduced the literal clock and was rejected on principle; one's gradient sat outside the three-hue rule; one de-emphasised the slider and undercut the mechanic. Half quietly broke a rule the project had already earned.

**The menu page: tested, not guessed.** Three hero concepts — a ticker, a split screen, a side-nav poster — settled by stakeholder A/B and usability testing on a stated KPI, *time-to-dish*. The side-nav poster won with every section visible; the ticker survives as a motif. Soups earned a web section print files under hot dishes; seasonal became a tag, not a section. Crossing between food and drinks got the **door** — a Molot word on a tilted block, the only door-shaped thing on the site. Two axes stay independent: theme follows the clock, content state only defaults from it and the guest overrides freely; an explicit choice is remembered. Each menu later got its own address, because a page cache never caches a query string.

**Visit: three anxieties, in order.** Are you open → how do I find you → can I get a seat. The hero is a bartender's ticket, the interface printing today's status the way the bar would answer — always Paper, day or night. A journey/stay rule splits house facts from one source between Visit and About. A two-speed contact model on the founder's reasoning: fast lane (phone, DM) for tables, slow lane (form, email) for feedback, styled never to look like booking. The map was decided twice: Yandex on paper, Google in the build, because only Google My Maps carried the custom walking routes and the team confirmed from Russia that it loads.

**About: writing the story, not inventing it.** Hero → Story → Concept → Mission → People → Recognition → Location → Careers → Visit. The story got a face — the founder, with photo and quote. The people became the centrepiece, team and guests as equal halves, rhyming with the 50/50 concept without saying it. Recognition became "How it feels", a word cloud of the words guests actually use with real quotes beneath, on a curated pipeline with a written admission rule and a ledger. A voice rule came out of it and was promoted to the system: copy speaks from the guest's side, and the venue says "we" in one place only — ticket replies.

**Mobile: same rules, one hand.** The system mostly held; where it didn't, the rule was amended, not violated. The menu hero's no-CTA rule turned out to be scoped to pointer input: hover and click are two channels, touch has one, so on touch a word previews and a boxed action commits. Reserve's edge tab doesn't survive 390px — three placements tried, rejected and written down with their failure modes; the drawer and in-content actions carry it. The drawer themes by time like every surface, and phone leads the booking block, because Russian guests book by call.

**The audit before code.** All eleven project documents were read in full and cross-checked, with contrast and colour-vision claims recomputed from the hex values. The price colour failed AA in exactly the rows it was assigned to; the "three styles" rule was false as written; the colour-blind claim was measurably wrong. Findings only, both sides named where documents disagreed, the calls left to the author, sequenced as a work order against the build.

## 5 · Building with AI

**Files steer, not chat.** The theme was built one chat per section, with the model steered by files rather than conversation history: a living build report whose first line is "read this before writing any code", a design source of truth the build compiles tokens from, agent briefs per task, and a standing instruction in the project file — *give me the deliberately wrong version*: always offer one option that breaks a stated rule and argue whether it earns the exception. A validation log records a prediction before every test and labels the evidence — user-tested, measured, or rule-sorted — so decisions stop being stranded in whatever document prompted them. The docs stopped describing the design and became its interface.

**The bench.** Every check runs in headless Chrome over the DevTools protocol: phone, tablet and desktop sizes, day and night, both languages, with the cookie band removed before the shot. Trials are built in their own git worktrees behind URL flags, so the main checkout never carries a half-idea. For testers without screen recording, the site's animations were rendered to MP4 by stepping the page's clock frame by frame. Deploys to the test and main installs travel as files — field changes as JSON, pages seeded by script — so nothing is retyped by hand on a server.

**Figma through the MCP server.** The Figma file is read and written from the same sessions: the style guide's Russian edition (27 pages twinned from a hashed dictionary), the case-study deck built from nine components, styles and variables on the published guide library, and the catch-up of built decisions into the library. The rule I set: components and styles only — a change is one variable, one style or one component, never a hand-styled layer. Figma still comes first for anything with states (the privacy dialog, the 404 phone layout, the loader's replay) and follows the browser for layout trials, in a written list of debts.

**What the model did, and what I kept.**

| The model | Me |
|---|---|
| Theme code, section by section; the VK importer; the form backend | Every design decision, and the deliberately wrong options to argue against |
| Contrast and colour-vision maths; audits of docs and of the rendered site | Git — nothing is committed unprompted; server commands by hand |
| Contact sheets of options on the live page; the trial flags; the measurements | Device verdicts on a real iPhone and iPad; stakeholder and usability sessions |
| Russian drafts, checked against a voice document | The Russian voice itself — every RU line gets my pass |
| Screenshots, PDFs, the deck, the Figma twins | The owner, the lawyer, the team, the photographs |

**Judgment curates convergence.** Six working prototypes in an afternoon, half of them rule-breaking; an audit that changed nothing silently; a storage test whose prediction lost and whose log says so. The skill wasn't prompting; it was knowing which three to discard.

**The browser became the drawing board.** By the last phase a question takes three steps: the options are mocked on the live page and shot as one contact sheet, always including one that breaks a rule; one or two survivors become real code behind a URL flag; the winner becomes the default and the loser stays behind its flag until a real device has voted. The phone menu's navigation went through it (ten options on one sheet; a bar at the foot of the screen is the default), the 404 page (my Figma draft plus five directions, three built), the event cards' frosted band, the loader's six looks by screen size, the team wall's lightbox.

## 6 · Real use

**The law is a design constraint.** On the lawyer's advice Instagram appears only outside Russia: the Russian page never shows it, the English page hides it from Russian IP addresses down to the structured data, and the plan to proxy posts to Russian guests was withdrawn before it was built. Maps wait for a choice — the server renders the address and a short explanation instead of an iframe, a yes is remembered for 180 days and revocable from the footer; an exception that loaded maps without asking for US and Canadian visitors was built, then retired when the owner's policy came back. Privacy got a system of its own: a notice with a confirmation step, a settings dialog that is a bottom sheet on phones, three legal pages in the owner's reviewed words plus a Documents hub, each page headed by a short name over its legal title. Analytics stays out until the consent can be recorded in a provable form — the lawyer's condition, not a preference. Forms: one REST route, no plugin, no nonce (a nonce baked into a cached page goes stale), a honeypot and a minimum fill time instead.

**The team's WordPress.** The admin was usability-tested too: menu storage as a repeater per section versus dish posts was tried with two team members on the real admin, and dish posts won — harder to mix dishes up, and the team searches rather than scrolls, since price is the edit they make. My prediction lost, and the log says so. From there: the fall menu went in by script, records matched by section and name, retired dishes drafted never deleted; vacancies became the one public post type, with a term that closes the post by itself; the reserve ticket's ready-made messages and the page loader's waiting lines live in tables the team edits; every photo field previews at the site's own crop, with a note that the preview is a small copy; the VK feed imports itself hourly on both installs and has needed nobody since late September. The English feed stays manual by design — the two languages never share a pipeline. In October the team cards became the team's: eleven people, each with their own line and button text, typed in admin and carried to the servers as files, with the even-count rule that had refused an odd team removed. Three operating lessons came with them. A page that would not save was traced to a seeded year of 0 failing the field's own validation, found by running the validator from the command line. An admin tab opened before a scripted write saves the old values back, so the admin is reloaded after every write. And the live page is read before an update's expected values are written — the menu bands' sliders had never been saved on the servers, and the bands were served from a crop that left the slider nothing to move.

**What devices and testers found.** The nav drawer was 42px too tall on an iPhone 15 Pro; the drawer's title went screen-reader-only and the sheet fits exactly. The tablet split moved to 600px because an iPad mini is 744 wide. On a Windows machine with no mail client an email link does nothing, so desktops get a small chooser and phones keep the native behaviour. A tester said hover timing didn't match the design; measuring showed the build had kept the spring's 800ms and lost its attack — the Gentle spring became the one curve for movement and colour, and hover styles are applied only where a pointer can hover, enforced as a build step rather than a convention. Booking blocks got one rule after the bar-state colours drifted: Chili marks the best way to reach us right now, one per block; when the bar is closed, writing leads and the phone steps back. The Visit card's odd phone actions were traced to a decision that had never been recorded as answered — fixed, and the trace written down. Two more trials went through the browser in October: the page's scrollbar, four looks against a night page that a classic grey bar had been cutting into, settled on a slim pill once it worked in Safari; and the phone header stepping aside on scroll, built as a trial and made the default the same day an iPhone recording found a two-pixel gap on its return — the spring's overshoot, covered by a strip of the header's own ground.

**The slider comes back — as the wait.** The spice slider died as a control and returned as the page loader, where "watch the heat rise" is the whole task: the knob moves through the dayparts, the wordmark heats to Chili, the page arrives with «Подано!». It appears only when a navigation is still pending after 700ms. A tester called the footer replay "like an Easter egg" and tried to drag the knob, so it became a toy — then it was measured: the replay had borrowed the real wait's curve and took seven seconds; a replay knows its end, so it runs its own, 3.3 seconds, the close button there from the start.

**The audit ran again, on the rendered site.** Ten pages, 63 media items: no alt text in the library, Russian pages reading English alts, 60–90 inline icons per page exposed to screen readers, connector words read twice, no `<h1>` on the menu pages and two on About. Fixed at the source — icons decorative unless labelled, alt text as RU/EN twins, titles and descriptions per language, share cards, restaurant schema from the same hours data the footer reads. The bar's domain now serves the site: a production install beside the test one, each with its own hourly feed job.

## Where it stands

**Done:** the system, validated, audited and pruned; four pages in both states across phone, tablet and desktop, in two languages; heroes, menu storage and the admin usability-tested; the site on the bar's domain with a test install beside it; the fall menu in; the VK feed running itself; forms, consent and the legal pages published; the team cards with the team's own lines; vacancies, the page loader, the scrollbar pill, the phone header that steps aside, an SEO and accessibility pass; the bilingual style guide with PDFs, an edit mode and a Motion block; stack, plugins, maps and launch phasing closed.

**Next:** device verdicts still open (the phone menu bar or rail, the 404 layout, the loader and the lightbox on a real iPhone); the page cache on the main site, then search engines; analytics once its consent can be recorded; the hours-settings test with an Editor-role manager; the last RU passes; the Figma catch-up; the sixteen hero photos and the remaining team photos; this study's own restructure, with device mockups in place of the July frames.

## Six lessons

1. **Systemising beats redesigning.** The strongest move was keeping a logo guests loved and building rules around it.
2. **Constraints found the idea.** The no-clock rule looked like a limitation; it forced the heat metaphor and, later, the loader.
3. **The mechanic is the idea, not the widget.** The slider died and nothing important was lost; holding the concept loosely at the widget level is what let it survive.
4. **Amend rules in daylight.** Mobile, touch and the law each broke a rule; none was violated quietly, and each amendment carries its reasoning.
5. **A prediction is only honest if it can lose.** The log that admits the repeater lost is the only kind that counts as evidence.
6. **AI accelerates divergence; judgment curates convergence.** Half of six good prototypes broke a rule the project had earned. The skill was knowing which to discard — and building the files that let a model be steered instead of chatted with.

---

*Long version: Sweet-Pepper-Case-Study.md (8,000 words) · deck: 39 slides, PDF / PPTX · etualechka@gmail.com*
