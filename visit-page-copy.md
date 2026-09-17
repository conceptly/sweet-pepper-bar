# Visit — Copy & Strategy Draft (English-first, per design.md)

> **Copy review, 16 September 2026:** current-source review in [visit-copy-review-en.md](visit-copy-review-en.md), working [EN copy](visit-page-copy-en.md) and [RU draft](visit-page-copy-ru-draft.md). These proposals follow the built three-section order; this document retains component decisions and older explorations. Canonical address is 10/25; older 10-only strings below are historical. Form/booking wording remains deferred. No build or Figma edits.

*Voice: Molot for headlines (short bursts, 3–7 words), Golos for everything read. Sourced from sweet_pepper_bar_brief.md, website-brief.md, design.md — nothing invented beyond phrasing; flagged items need founder confirmation.*

*IA (v1): Today's status → Getting here → Reserve → Good to know → Closing slip. Changes from the first sketch: reserve pulled out of Getting here; Neighbourhood folded into Getting here as landmark directions; Before-you-come + Accessibility merged; Social updates cut as a section; Contact merged into the footer ticket.*

*IA (v2, final — Jul 2026): **three sections.** 1) **Hero** — status band + hours slip + Get-in-touch card (absorbs the old Reserve beat; the Reserve edge tab/panel carries booking site-wide). 2) **Getting here** — map (Yandex, four-pin cap), landmark directions, route chips, and 2–3 Good-to-know slips. 3) **We're all ears** — the feedback form + fast-lane redirect. Footer = short sign-off slip only (hero owns contact now). Good to know is no longer a section — see the assignment rule below.*

## Journey/stay rule & the Good-to-know component (decided Jul 2026)

**If it affects the journey to the door, it's Visit; if it affects the stay, it's About.** One content source, two renderings — never a copied section:

- **Storage:** ACF "house facts" repeater — label, About line (voice register), Visit line (practical register), icon, tag: `journey` / `stay` / `both`.
- **About** renders stay + both as the "Beyond shake & cook" stamp strip (existing).
- **Visit** renders journey + both as small Lemon **Good-to-know slips inside Getting here** — 2–3 max, no section heading. Current set: pedestrian-only/parking, accessible entrance, 18+ after 22:00 🔶 *(policy still needs founder confirmation)*, dog-friendly (`both`). Peak hours phrased as invitation, not warning: "quietest 12:00–16:00."
- Wi-Fi, terrace, kids stay About-only (`stay`).

## Theming — fixed composition (revised Aug 2026, supersedes "Day mode")

**Visit does not theme by time.** It is a **fixed dark · light · dark composition** closing on the Lime footer: dark hero → Getting here light → We're all ears dark → footer. The page is authored once and looks the same at 9am and 11pm.

*(Superseded, kept as the record: the Jul 2026 decision had the Visit hero follow the site-wide day/night mechanic — "theme and title swap together, never one without the other" — on the reasoning that a standalone page themes by time like every other page. Aug 2026 settled the site-wide scope instead: only Home and the food menu theme; the drinks menu is always dark; About and Visit are fixed. See `website-brief.md` → The day/night concept → What themes and what doesn't.)*

**What survives from the day variant.** The per-mode overrides below were written for a themed page. Two of them are now simply *how the light section is built*, since the light middle still needs them; the third is unchanged. Read them as composition rules, not mode swaps:

- **Hours slip:** Paper on Paper vanishes — day slip gets a hard Peppercorn keyline + ~1° tilt (menu-page day-energy grammar), scallop edge keylined too.
- **Contact card:** Parchment surface + keyline by day (Soft Peppercorn by night).
- **Band:** Lime in both modes (banner exemption) — the page's one colour-block moment; copy per band-state table.
- **Copy:** H1 stays daypart-neutral (COME SIT WITH US); the band lead word carries the daypart wink (MORNING, SUNSHINE / GOOD NEWS! / …). Night H1 "JOIN THE PARTY" and the day H1 are a mode pair — RU written natively for both. "PARTY HOURS" heading steps to "OUR HOURS" by day.

---

## Mobile layout (decided Aug 2026)

*Reference frame: `Visit-Mobile-opt2` in Figma (402px). Side margins 16px, content column 370px. Nothing here overrides the page's copy or IA — it records how the three sections fold into one column.*

**Order, top to bottom:** nav → eyebrow + H1 + intro paragraph → status rail → hours slip → contact card → scroll-down link → Getting here (title · map + directions · Good-to-know slip) → 21:9 photo band → We're all ears (closure + booking block · form) → footer.

**Built (Sep 2026)** from `Visit-Mobile-opt2` 1441:72385, ≤ 767px, as drawn — `visit.css` → Phones. Where the build reads the frame differently, or leaves something for the content pass:

- **Status rail:** the desktop band's lead word (GOOD NEWS! / STILL CAN GET IT!) is not in the frame and does not ship on phones — the rail is the two states only. Runs after a 2.5 s hold with both states in view, 22 s per loop, pauses 8 s on touch, static under reduced motion. States are the **Molot variants only** of `barState-mobile` 1460:73436 / `kitchenState-mobile` 1460:73472 (the Golos variants are unused): Peppercorn ink, dots Olive alive · Paprika transitional · Chili closed. Closed ink: the bar set says Chili Deep, the kitchen set Paprika — Paprika on Lime is 1.9:1, so both closed states ship Chili Deep (4.9:1); re-sync the kitchen variant in Figma. The two sets also differ on icon ink (Peppercorn vs Soft Peppercorn) — invisible at 12px, built as Peppercorn.
- **Hours slip (refined from `Visit-hero` 2363:75509):** the card has no corner radius — the scallops are the boundary, as on the reserve ticket and the dish picker. Figma keeps 8px on the card only because its ruggedEdge is a 24px strip whose solid half overlaps the card by 13px and squares the corners; a bare half-circle row over a rounded corner leaves a dark wedge at each corner. The bottom row overlaps the card by 1px (WebKit draws a hairline at a flush fractional boundary), and on this card the tiling is phase-shifted half a tile so the end circles are whole at 370 (Figma's bottom row: 16 / 352). The rail reserves its rotated 51px box, so the 16px gap to the slip is measured from the band's lowest corner; hero top padding is the frame's 24.
- **Connectors (Sep 2026):** the About device at both seams — YOUR ROUTE TO PEPPER (hero foot / Location head), DROP A LITTLE NOTE (Location foot / CTA head), from `visit-page` 892:31050; exports in `assets/sectionLinks/visit/`, rendered by the shared `components/connector.php` (About's part now delegates to it, so the live-text-vs-SVG flag flips both pages at once). Rhythm: 36 under the hero content, 48 everywhere else (About runs 80 on desktop); phones 48 throughout. **The scroll-down link is gone** — with the word at the hero's foot it was a second device announcing the same section, and the word is the one the home and About heroes chose over a tappable line; the `testing.md` row for it is closed. On phones the 21:9 photo band moved inside We're all ears, under the reflection, so word and reflection stay adjacent on the seam. Both words name the section below them — see `website-brief.md` → Section connectors → direction. The Location head is the known Lime-on-Parchment reflection (1.15:1 as an SVG); the Olive recolour recommended for About applies to this export too.
- **Contact card:** the address row's ↗ hands off to a Yandex route (uniform ↗ rule below); the desktop "Directions ↓" stays desktop. Email keeps the copy glyph. The hint lines are still the long ones — trim at the content pass.
- **Getting here (refined Sep 2026, Location 1472:75737):** title → Good-to-know slip → map → chips → badges → connector. The slip moved up from the section's foot once the connector took the closing job (the desktop keeps it beside the title). The frame draws 24 between the connector and the content; the build keeps the site's phone rhythm of 48 (About and every other phone section) — say if Visit should be the exception. The map stays the same embed as desktop (tier still open below); the Paper chip bar sits on its foot (see the desktop note below). **Desktop built to `Location` 1990:124846 (Sep 2026):** the badges are a 360 column beside a 736 × 400 map — the frame's original layout, revived once the one-map-per-route answer made it buildable — with the Paper chip bar back on the map's foot (map "labels" 2391:76528: Copy · Yandex Maps · Google Maps in the chip component's own style, no address line — the badges carry the address and the hints; author, Sep 2026, after a day with a Cream address ribbon and the chips under the map). **The chips follow the page language** (the hero CTA's Instagram / VK pattern): EN — Google Maps · Yandex Maps · Copy address; RU — Yandex Maps · 2GIS · Copy address (2GIS deep-links to the venue card). 2GIS stays because it is still the country's second map service (Sensor Tower 2025: ~21–25M quarterly actives in Russia against Yandex Maps' 46M monthly; strongest in regional cities), Google because it is what EN guests carry. **Phones show the two apps only, brand names, in the 13px chip style:** two apps + "Copy address" measure 374 against the 338 available, and "Copy" alone misreads beside the route badges (author, Sep 2026). Consequence: there is no address copy on phones — the contact card's copy chip is hover-only and its address row hands off to Yandex. If that matters, the card's address row is the place to restore it. The phone decision above (Yandex · 2GIS · Copy under the map) is superseded. The map box is 440 tall. Badge anatomy at desktop: → · name · distance, the active one Cream with its hint line (towards Pervomaiskaya · where the rivers meet · and the old Kremlin · alongside Andropova st.; **Sovetskaya has no hint in the frame**, and its distance carries a stray "5 min"). The door reads "The door" at both widths — the frame's desktop label is **"Just show me the door"**, the author's call. Route chips take a trailing ↗ (the chip component's glyph). **The landmark badges switch the map:** each badge carries the id of a Google My Map whose walking-route layer is on by default, and tapping it reloads the embed with that map; the filled Cream badge is the map currently showing, the door at rest. A My Maps embed is a cross-origin iframe, so its own layer checkboxes cannot be driven from the page — one map per route is the only handle, which is why the base map's own direction layers stay off and each route gets its own map. Wired: the door (base map), Znamenskaya Tower, Sovetskaya square, Strelka and Bogoyavlenskaya sq.; and, in the parking slot for now, **the closest bus stop** (“Pervomayskaya”, 250 m · 4 min — **the distance is computed, not measured**: 203 m straight line from the stop’s coordinates, ×1.25 for the street grid, at the set’s own ~4.5 km/h; read the real figure off that badge’s own route layer and replace it). Sovetskaya square’s hint is “past the fountains” — chosen over “right behind the Government building”: three words in the set’s register (sensory, walking-directional, like “where the rivers meet”), where the longer line names an institution no guest is heading for and reads officious against the house voice. **Open — one street, two spellings:** Znamenskaya’s hint reads “towards Pervomaiskaya” and the bus stop “Pervomayskaya” (Google’s transliteration). Pick one and apply it to both. Parking is open: several options, the author is working out how to embed them. All six route maps want the same saved view, or the map jumps between taps. **Google only:** RU guests get the Yandex widget, which has no My Maps equivalent — the badges do nothing there. A Yandex route can be built from a `rtext=<from>~<to>&rtt=pd` widget URL per landmark if the coordinates are supplied; open. Names still truncate at 370 as in the frame, and the set still contradicts the copy (below).
- **We're all ears — checked against `Form` 1477:76522 (Sep 2026).** Matches the frame: section 48 / closure 24 / text 24 / cta 16; form full-bleed on Soft Peppercorn at 48 / 16 with a 32 stack; inputs 48, message 120, counter right at 13; Phone pill Avocado; no contact-method helper line on phones; four topic chips, the active one now carrying the frame's glow; Submit Chili on Lemon, full width. **The reflection is dropped on phones:** the 21:9 band opens the section (the frame draws it as a sibling of the Form), so the band carries the seam — the rule the menu and About pages already follow, where the entrance photo stands between two sections with no connector beside it. The seam is word → photo → 48 → headline; desktop keeps the reflection. Three deltas left as the author's call: the frame's **"Vk Message"** against the build's "VK message"; the frame's **bold** Call label against the build's semibold (`UI/ButtonPrimary` in the same file says SemiBold, so the frame looks like a local override); and the form subtitle, where the frame says "We'll get back to you within 24 hours" and the build keeps the longer desktop line — **both are the SLA nobody agreed to**, per the open item below.
- **We're all ears:** the body runs Mushroom on phones (the frame), Lime on desktop. Call sits on the drawer's bar-state engine (Lime → busy orange → closed Chili). The form's subtitle keeps the desktop line, not the frame's 24-hour one — both are wrong per the open item below. **Topic chips ship phone-only as drawn** (Private event · Press & Partners · Feedback · Any questions), mirrored into a hidden `topic` field; the set is still the open item below.

**The order is the anxiety order, not a layout preference.** Status → hours → contact is Strategy's "are you open right now → how do I find you → can I get a seat" rendered in one column. Recorded here so it doesn't get reopened as a matter of taste. The one case against — guests arriving from a VK/IG bio link or a maps card already want to dial — is answered by giving the phone a call affordance high in the card, not by reordering the hero.

### Status rail — standalone running band

The bar/kitchen states **left the hours slip**. The slip's `currentState` row is retired on mobile (hidden in the component); the states now ride a full-bleed Lime band sitting between the intro paragraph and the slip, ~51px tall.

- **Why it left.** Kept inside the slip, the Lime header has to grow tall enough to hold a lead line plus two state pills — and a saturated hue at that size is a surface, not a banner (`design.md` §2.4). Laying the two pills out horizontally inside 370px also fails on the longest state pairs (wrapping-up + last-orders).
- **The band runs** — the state pair scrolls horizontally rather than wrapping or stacking.
- **Known objection, accepted by the author.** Scrolling text has lost twice on this project (menu hero, concept B; the compact-ticker jump-nav) on the grounds that a loop re-reads one item at a time while a static layout shows the whole set at once. That argument is *stronger* here, not weaker: this band answers the page's first anxiety, and a guest arriving mid-loop can see only one of the two states. Three mitigations are required if the rail ships: **(a)** both states fully visible at rest before motion begins, **(b)** motion pauses on interaction per the idle-clock rule (Motion language), **(c)** `prefers-reduced-motion` renders it static with both states visible.
- **Consequence for the site:** scrolling text now has two jobs — the day menu's Lemon ticker band (display motif) and this Lime rail (status). Cross-referenced in `website-brief.md` → Menu page.
- **Fallback on the shelf, not discarded.** A containerless one-line band was drafted — one self-sufficient phrase per state, under ~30 characters, no pills, no dots, so it fits at 390px and reads in greyscale. Hold it as the replacement if the rail fails its test:

| State | Line |
|---|---|
| Bar open · kitchen on | FULL MENU, FULL BAR |
| Bar open · kitchen last orders | ORDER FOOD NOW, DRINK LATER |
| Bar open · snacks only | SNACKS AND COCKTAILS TILL LATE |
| Bar wrapping up · snacks only | LAST CALL — MAKE IT COUNT |
| Closed | WE'RE CLOSED — COFFEE AT 8:30 |

*(Sunday twin: SEE YOU AT 10 — SUNDAY SCRUB. RU written natively first — Cyrillic runs 10–15% longer, so the character ceiling has to survive RU before EN is judged.)*

### Contact card

- **Row anatomy:** leading channel icon · handle · optional hint line · trailing glyph. The whole row is the tap target, ≥48px, full card width — so a guest who misses the glyph still succeeds on the attempt.
- **Trailing glyph is a uniform ↗ on every row**, read as *"hands off to another app"* — dialer, VK, Instagram, mail client, maps. That reading removes the phone row's special case: a call leaves the browser exactly as an external link does. Email keeps the copy icon (clipboard doesn't leave).
- **Verb labels tested and rejected (Aug 2026).** Call / Write / DM were drawn at Caption size in two colour treatments. Mixed with the glyphs still on the email and address rows, the card ran two affordance systems at once and read unbalanced. If they're revived, they have to go on *every* row so no arrow remains inside the card — verbs inside, arrows outside.
- **Motion:** the card rests at 1° and settles to 0° on scroll-in (mobile) / hover (desktop). Transform only, house spring easing — a snap-back, per Motion language. It is scroll-driven rather than idle, so it does **not** count as a second clock against the running rail in the same view; it is decorative, so `prefers-reduced-motion` leaves the card at 0° with no settle.
- **Open — hint lines.** Two of the four restate their neighbours ("DM & latest updates" beside an Instagram handle; "feedback, offers, partnerships — or any DM above" beside the EVERYTHING ELSE heading). They cost three wrapped lines and are the card's real density problem. Trim at the content pass.

### Scroll-down link — retired (Sep 2026)

*Superseded by the hero-foot connector (Built, above). Kept as the record of the decision and its test.*

One line below the card: **"Map, city sights & contact form ↓"**, replacing the two in-card jump links.

- **Rationale on record:** the page is short and the words run in the same order as the sections below, so the line reads as a preview of the remaining page rather than a single anchor. Kept as one line rather than two competing controls.
- **Two variants going to test** — see `testing.md`. Variant B drops to a directions-only link and lets the form be reached by scrolling.
- **Grammar flag.** As drawn it is uncontained Lime text with a trailing arrow, which is none of the three tappable styles (`website-brief.md` → Interaction rule). Resolve deliberately at the test: either it becomes a chip, or the rule gains a fourth, named entry ("section-boundary link") — not by drift.

### Getting here — mobile

Built: section title · map + directions block · Good-to-know slip. Open items specific to mobile:

- **Map tier.** An embedded pannable map inside a scrolling page traps the finger on touch. Tier 3 (Static API image + route chips) may be the better *mobile* tier even if the Constructor embed stays on desktop — non-tappable pins cost nothing on a phone, where the guest opens Yandex or 2GIS anyway.
- **The frontage shot is missing.** §2 specs a 21:9 street/door photo for the "you'll recognise it" job. On mobile it outperforms the map — the guest is standing on Kirova looking at facades. If only one image survives on mobile, keep the door.
- **Landmarks contradict the copy.** The body names the Church of Elijah the Prophet and the Kazan Convent; the build lists Znamenskaya, Sovetskaya, Strelka, Bogoyavlenskaya and parking. Reconcile — and note that six rows re-imports the tourist-map problem the four-pin cap exists to prevent, if tapping a row recenters the map.
- **Route chips** won't sit three-across at 402 with full labels. Shorten to brand names and let ↗ carry "route"; order Yandex · 2GIS · Copy, since a deep link beats the clipboard on a phone.

### We're all ears — mobile

Built: heading + one-line body · booking block (Molot title, one filled primary, two secondary) · form. The booking block is the fast-lane redirect the Strategy section requires — it stays **above** the form, never below.

Open (form refinement, next session):

- **"We'll get back to you within 24 hours"** is an SLA nobody agreed to. The specced line is descriptive: "A person reads this — usually same day."
- **Credibility line missing** — "Goes to the team — and the director reads these too."
- **Topic chips** are Private event / Press & Partners / Feedback; the spec set is Feedback · Idea · Partnership · Something else. Reconcile, and note that "Private event" sits close to a booking, which the chip set deliberately excludes.
- **Contact-method toggle:** picking Phone should swap the field to a masked tel input, not leave an email field with an envelope icon.

### Photo band

21:9 full-bleed (402 × 172) between Getting here and We're all ears — the band ratio, not a content card. If it ever carries connector wording it inherits the open direction question (`website-brief.md` → Section connectors).

---

## Voice — guest-perspective rule (founder, Jul 2026)

Copy is framed from the guest's side, continuing the house practice from social/print: **"Your route to Pepper," not "Find us"; "Your fav drink," not "Our drinks."** Labels, headings, and nav speak in the guest's "your." The venue speaks as "we" in exactly one place: **ticket/slip replies and band messages** — those are literally the bar answering, so first person lives there and nowhere else. Two voices, one handshake: the guest owns the questions, the bar owns the replies.

✓ *Promoted to `design.md` §1.1 (Jul 2026) — project-wide rule; this section defers to it.*

## Strategy

**The page answers three anxieties, in order: are you open right now → how do I find you → can I get a seat.** Everything else is a chip. It is a service page: exact times are sanctioned here (the documented exemption to the no-clock rule) — this is the one page where the clock works *for* the guest.

- **Mode:** fixed composition, **dark · light · dark**, in every state (revised Aug 2026 — see Theming above; this bullet previously read "dark in both modes" under the old striping rule, and then went stale when Jul 2026 made the page theme by time). Break the dark hero's run with Soft Peppercorn where it gets long; Getting here is the light middle; We're all ears returns to dark before the Lime footer.
- **The ticket is the page's device.** It opens the page (status slip) and closes it (footer slip). Max one slip per viewport — the two must never share a view; the sections between guarantee that.
- **Two-speed contact model (revised Jul 2026 — supersedes the earlier "no form, no email" position).** Fast lane: phone + VK/IG DM, for tables and now-questions. Slow lane: email **and** a form, for feedback, ideas, partnerships, complaints. The founder's reasoning, recorded: bad experiences happen everywhere; a guest with a channel to complain to is a guest whose issue can be resolved — the bar historically published the director's direct contacts and kept a feedback mailbox at the entrance. The website continues that culture. Form and email feed the same inbox — zero extra cost to the team.
  - **The form must never look like the booking path:** redirect line with Call/DM chips *above* the form ("Need a table tonight? That's a call or a DM — minutes, not a day"); topic chips (Feedback · Idea · Partnership · Something else) with deliberately **no Booking option**; expectation line at the button ("A person reads this — usually same day"); credibility line: "Goes to the team — and the director reads these too."
  - **Confirmation = a bartender's ticket prints:** "Got it. A person will write back." (Add to the site-wide ticket candidates list.)
  - **Build:** SMTP plugin for deliverability (default WP mail lands in spam); anti-spam via Yandex SmartCaptcha or honeypot (not Google reCAPTCHA on a RU-hosted site); topic chip becomes the email subject for triage.
- **No feed.** Launch phasing has no News surface; social presence here is two chips in the closing slip (VK leading, IG second).
- **Maintenance budget: near zero.** Hours come from the ACF options page (incl. holiday repeater); everything else is evergreen. Nothing on this page needs weekly attention.
- **Map: Yandex Maps (decided Jul 2026), not Google.** Google's free embed is single-pin (multi-marker needs the paid JS API) and its Yaroslavl parking/POI data is weak; Yandex fits the RU audience and the no-foreign-vendor platform logic. Three tiers, in order of adoption:
  1. **Launch — Map Constructor:** no-code visual editor; custom placemarks with click-captions, iframe embed, edits propagate without redeploy. Limits: preset pin styles, no basemap restyling.
  2. **Phase 2 — JS API:** custom pin images (Chili pepper mark for the venue, muted pins for the rest), palette-obedient basemap. Adopt if the Constructor basemap clashes with Peppercorn in mockup.
  3. **Fallback — Static API:** map image with baked-in markers + route chips; lightest and fully on-palette, but pins aren't tappable.

  **Pin cap: four points max** — venue (dominant), 1–2 parking spots, at most the two landmarks the copy already names. Parking *must* be a pin (it's what people navigate to); landmarks work harder as words in the directions copy than as pins. The section's job is "you'll recognise it," not a tourist map of Kirova. Route-out chips (Yandex / 2GIS) stay regardless of tier.

---

## 1. Today's status (hero)

The hero *is* a bartender's ticket — the interface answers "are you open?" the way the bar would. Prints on load (house spring; `prefers-reduced-motion`: appears in place). State-aware via the ACF hours data + daypart logic.

**Eyebrow (Molot H3, Olive/Lime):** KIROVA ST. 10, YAROSLAVL

**H1 (Molot):** COME SIT WITH US

**Ticket copy — one line per daypart state (Golos; the reply is a person, never a template):**

| State | Slip reply |
|---|---|
| Morning (8:30–12) | "Kitchen's on — breakfast served till noon. Coffee's already ahead of you." |
| Lunch (12–16) | "Lunch hours. The fast kind, if you're on the clock — no rush if you're not." |
| Evening | "The kitchen's on and the bar's warming up. Come as you are." |
| Late | "Kitchen's winding down; the bar is very much not. Night menu till late." |
| Closed | "We're closed — back at 8:30 with coffee and eggs. First one in gets the window seat." |

*RU voice lines written natively per state, not translated — same rule as About quotes. Store per-locale in CMS.*

**Hours block — dayparts, not a bare table.** Reuses the slider grammar: four daypart rows (BREAKFAST · LUNCH · DINNER · PARTY in Molot small-size exception style), current one filled, others outline. Each row: daypart word · exact times (Golos) · deep-link chip into the matching menu anchor ("breakfast menu →" `/menu#breakfast`). Below, a Caption-style line for the full week + holiday exceptions from the ACF repeater.

- Breakfast — 8:30–12:00, weekdays 🔶 *[weekend breakfast: confirm — brief says weekdays only; if so the row must say it, don't let a weekend guest walk to a closed kitchen]*
- Lunch — 12:00–16:00
- Dinner — 16:00–01:30 ✓ *(confirmed Jul 2026: kitchen runs till 1:30, last orders 1:00 — "full menu till 01:30" in the band, "last orders 01:00" in the last-orders state)*
- Party — till 2:00 ✓ *(bar close 02:00 per current hours; drop the 3:00 variant unless the founder revives it)*

---

## 2. Getting here

**H2 (Molot):** FINDING US IS THE EASY PART

**Body (Golos, short — this section is spatial, not literary):**
> Kirova 10, right on Yaroslavl's pedestrian street — the local Arbat. If you can find the Church of Elijah the Prophet, you're 350 metres away; from the Kazan Convent it's 250. Look for the pepper.

**Layout:** one 21:9 frontage/street shot (the "you'll recognise it" job — shoot per §7, in situ, warm; leave a quiet zone for type) beside the map. On night mode this is the page's single point of light.

**Chips (contained inline actions):**
- 📋 Copy address — `Кирова 10, Ярославль` (copies RU string regardless of site language — that's what the taxi app wants)
- ↗ Route in Yandex Maps
- ↗ Route in 2GIS

**Practical caption (Golos Caption, muted):**
> Kirova is pedestrian-only — no cars up to the door. 🔶 *[Parking guidance needed from founder: nearest parking / which side street to approach from. This kills a real anxiety for drivers; don't ship the section without it.]*

---

## 3. Reserve

The right-edge Reserve tab lands here. Short beat — one headline, three ways in, no essay.

**H2 (Molot):** SAVE YOUR SEAT

**Body (Golos, 1–2 sentences):**
> Evenings and weekends fill up — booking ahead is the kind thing to do to your future self. Call, write, or book online; a person answers either way.

**Channels ✓ (confirmed Jul 2026): phone (voice calls only — no SMS/messengers on the number), VK messages, Instagram DM. No Telegram — the team doesn't use it for orders/booking; no booking widget.** Rank and state behaviour: see the Reserve panel state matrix (call = live during open hours, VK/IG take over at party hours and overnight; desktop shows the number + copy instead of tel:).

**Actions:**
- **Button (boxed action):** Book a table → opens the Reserve panel
- **Chips:** 📞 phone number 🔶 *[final number — mockups use +7 (4852) 911-202]* · VK message · IG DM

**Candidate (already on the ticket list):** confirmation prints a bartender's ticket — "Table for two, Friday 19:00 — we'll keep it warm." If built, it appears *here*, and the status slip must be scrolled away first (one slip per view).

*Group bookings / events: one Caption line pointing at phone ("Birthdays, corporates, full-hall — call and ask for the manager"), not a form.* 🔶 *[confirm wording with founder]*

---

## 4. Good to know — ⚠️ superseded by IA v2

*No longer a section. Journey items became the Getting-here slips; stay items live on About's stamp strip (see Journey/stay rule above). Table kept for copy reference:*

One chips row + short answers. Merged practical + amenities; every item is confirmed in the brief unless flagged. Chips are informational here — if a chip has nowhere to link, it's a **badge, not a chip** (don't dress non-interactive text as tappable; interaction rule).

| Item | Copy (Golos, one line) | Link? |
|---|---|---|
| Terrace | "Summer terrace with the swing-chairs everyone photographs." | badge (seasonal note from ACF?) |
| Kids | "Kids menu, and a corner of the food menu that's theirs." | chip → `/menu#kids` |
| Dog-friendly | "Dogs welcome. Water bowl on request." 🔶 *[bowl line — confirm, don't invent policy]* | badge |
| Accessible | "Wheelchair-accessible entrance." | badge |
| Wi-Fi & laptops | "Free Wi-Fi, laptop-friendly by day." | badge |
| Cards | "Visa, MC accepted." 🔶 *[Amex listed in the brief — verify it still holds in 2026 RU; foreign-issued cards generally don't work — say nothing rather than promise]* | badge |
| Takeaway & delivery | "Takeaway and delivery available." | chip → 🔶 *[delivery platform link?]* |
| 18+ | "After the kitchen closes, the bar is grown-ups only." 🔶 *[confirm actual policy — invented; the brief doesn't state one]* | badge |

---

## 5. Closing slip (footer)

Already specced in website-brief.md (the page ends as a slip); Visit is where it works hardest — on this page it's not a flourish, it's the summary the guest screenshots.

**Slip contents:** SWEET PEPPER · KIROVA 10 header (Caption tracking) · hours digest (one line: "8:30 till late, every day" 🔶 *[verify "every day"]*) · address RU+EN · phone · VK chip (leading) · Instagram chip · the sign-off line.

**Sign-off (the guest's line / bar's reply pair):**
> — So when should I come?
> — Whenever you're hungry. We're the ones with the pepper on the door.

*RU pair written natively, not translated.* 🔶

---

## Open (visit page)

- Re-run all drafted headings/labels through the guest-perspective voice rule ("Find Sweet" → "Your route to Pepper" direction) — one pass, EN+RU together. **Parked Aug 2026** — deliberately deferred to the content-refinement pass rather than fixed piecemeal; "FIND SWEET", "FIND THE PEPPER" and "Find directions and city sights" all wait for that single pass.
- Feedback form: SmartCaptcha vs honeypot at build (inbox ✓ — see above).

- Final phone number for the site (mockups: +7 (4852) 911-202).
- Weekend breakfast yes/no. *(Kitchen close ✓ 1:30 / last orders 1:00; party till 2:00 ✓; channels ✓ phone + VK + IG, no Telegram.)*
- Feedback form inbox ✓ (Jul 2026): goes to **Kostya's inbox** first; if volume proves out, relink to the admins' inbox — the topic-chip subject lines make that split easy later.
- Parking / approach guidance for drivers.
- 18+ late policy — currently invented, confirm or cut.
- Amex / card wording in 2026 reality.
- Map: ✓ Yandex, Constructor tier at launch (see Strategy). Remaining: test the Constructor basemap against Peppercorn in mockup — clash promotes JS API (or Static fallback).
- Parking pin(s): which lot(s) to mark — needs the founder's parking guidance (same 🔶 as Getting here).
- Terrace seasonality: hardcode "summer" or drive from an ACF flag?
- Status-slip copy ×5 states: RU versions to be written natively.
