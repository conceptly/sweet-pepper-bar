# Sweet Pepper — Design System

*Working spec · Draft v0.1 · English-first (translate final to RU later)*
*Shake & Cook · Good food & drink since 2014 · Kirova St. 10, Yaroslavl*

This document is the written source of truth for the Sweet Pepper visual system. The interactive reference lives in `style-guide-draft.html`. Current website decisions (day/night mechanic, spice slider, hero work) live in `website-brief.md`.

---

## 0. Using this document — a living system

This system documents everything from the start, but the goal of that documentation is **consistency, not boundaries.** A rule earns its place by keeping the work coherent — not by fencing off options. When a rule stops serving coherence, it's a candidate for change, not a wall.

Two tiers, treated differently:

- **Brand core — stable.** The things the identity *is*: no generic templates; Molot as the display face; the three-ramp pepper palette and its core pairings; the cosy↔spicy tension; shoot-in-the-bar photography. Changing these changes the brand, so they change rarely and deliberately.
- **Working rules — evolve.** Downstream decisions made to stay consistent *given* the core: section striping, a specific component's anatomy, "no separate photo archive in v1," image-ratio assignments, and most of `website-brief.md`. These are expected to move as the work teaches us more.

**Changing a rule is legitimate when there's a real reason** — new content, a case the rule didn't anticipate, or evidence it's costing more than it protects. When that happens, update the rule *here* (don't quietly violate it or leave a stale line), note what changed and why, and check nothing downstream depended on the old version. A documented, reasoned change is the system working as intended; an undocumented drift is the failure mode. (Example already in flight: "link out to VK, no self-hosted archive" is a working rule for v1 — a reasonable future case could promote an events archive, and that would be a legitimate revision, not a violation.)

---

## 1. Brand essence

A hybrid gastrobar: a serious all-day kitchen fused with a craft cocktail bar, run as a community anchor. The visual language holds two truths at once.

- **Cosy** — warm, soulful, familiar; the half that brings people back.
- **Spicy** — loud, playful, a little rough; the pepper energy that makes it memorable.

**Guiding tension:** every decision sits somewhere between *cosy* and *spicy*. When in doubt, keep the energy but add warmth and air. Refine the loudness — never sanitise it. The looseness is brand equity.

### 1.1 Voice — the guest-perspective rule (promoted from visit-page work, Jul 2026)

Copy is framed from the guest's side, continuing the house practice from social/print: **"Your route to Pepper," not "Find us"; "Your fav drink," not "Our drinks."** Labels, headings, and nav speak in the guest's "your." The venue speaks as "we" in exactly one register: **ticket/slip replies and status-band messages** — those are literally the bar answering, so first person lives there and nowhere else. Two voices, one handshake: the guest owns the questions, the bar owns the replies. Applies to every surface, web and print; RU and EN are register twins, never literal translations.

---

## 2. Colour

### 2.1 The core rule — three pepper ramps

Every colour is a tint or shade of **three hues**: red (chili), green, and yellow. On the colour wheel each family sits on one line from rim to centre — same hue, only saturation and lightness change. The palette is therefore **three monochromatic ramps plus neutrals**. Monochromatic ramps are inherently harmonious, so the only real tension is between the three anchor hues — which the neutral grounds reconcile. That is *why* a set of colours that "shouldn't" work does.

**Generative rule:** need a new shade? **Move along an existing hue line** — take a current colour, make it lighter or deeper at the *same hue*. Never introduce a new hue. Intermediate steps (e.g. the mid-chili `#EC572A` that lives only inside the logo) don't need to become brand tokens — they're points on a line you can sample anytime. Keep the named palette to the stops that carry a role.

### 2.2 Ramps & tokens

**Red · Chili line**

| Token | Hex | Role |
|---|---|---|
| Paprika | `#EF6D44` | orange / support |
| *(mid-chili)* | `#EC572A` | **logo-internal only — not a brand token** |
| Chili | `#E34314` | hero red / primary accent |
| Deep Chili | `#9B2705` | dark red for red **text** on Lemon/Lime/Light-lime |

**Green line**

| Token | Hex | Role |
|---|---|---|
| Light Lime | `#D4E671` | lightest green tint |
| Lime | `#C1DB34` | signature green (cocktail) |
| Avocado | `#869438` | support green |
| Olive | `#737D3A` | secondary green / prices |

**Dark Olive `#242614` — removed (Jul 2026).** Tested as a dark-surface alternative and failed (too close in value to Peppercorn to read darker, too hue-shifted to pass as neutral); its last candidate role (badge ground under Lime) was superseded by the outline-door treatment (`website-brief.md` → Menu page → Doors). Not a brand token; the hex remains a point on the green line if a role ever appears (generative rule, §2.1). **✓ Deleted from the Figma `Color` collection, Aug 2026** — it had survived the Jul decision as a live bindable variable marked only with an asterisk. The palette collection now holds the 15 named tokens plus `imgOverlayDark`.

**Yellow line**

| Token | Hex | Role |
|---|---|---|
| Lemon | `#FFED00` | highlight only |
| Cream | `#FFF689` | block tint / highlight text on dark |

**Neutrals & surfaces**

| Token | Hex | Role |
|---|---|---|
| Peppercorn | `#151317` | brand black — the identity ground |
| Soft Peppercorn | `#201E22` | alternate dark surface — same neutral family as Peppercorn (~12% luminance vs ~8%), used to break up long dark stretches in night mode without reopening section-to-section contrast |
| Ash | `#54513F` | warm grey — secondary / muted text on light |
| Mushroom | `#9E9789` | warm grey — secondary / muted text on dark (night twin of Ash; 6.4:1 on Peppercorn) |
| Parchment | `#F3E9D2` | warm off-white surface; body text on dark |
| Paper | `#FCF7E8` | lightest cream surface — **never pure white** |

**Print equivalents:** Peppercorn = rich black `C15 M23 Y0 K95` · Parchment text = `C5 M11 Y40 K0` · Cream = `C0 M0 Y60 K0`.

**One functional token, not a brand colour (documented Aug 2026):** `imgOverlayDark` — Peppercorn `#151317` at **33%**, laid over a photograph to render it **inactive**. This is the ground under the "dimmed → full strength" half of the state grammar (`website-brief.md` → Motion language): the home hero's unselected daypart cards, and any other place an image is present but not current. It is a *state* overlay, not a scrim for legibility — the dark-scrim caption treatment in `website-brief.md` → Image caption label is a separate thing and must not be bound to this token. Web-only; no print equivalent.

### 2.3 Two modes — Night / Day

The loud hues never carry a layout alone — a neutral ground does the harmonising. On the website the two modes are *states of one page*, switched by time of day (see `website-brief.md`); "Mode A/B" are the print-era names.

**Night (Mode A) — Bar · Posters**
Ground **Peppercorn** (black). Text in **Parchment** (body) and **Cream** (highlight). Accents: Chili leads, Lime/Lemon highlight, Paprika supports. High-energy, max contrast.

**Day (Mode B) — Kitchen · Daytime menu**
Surface **Parchment**. Body **Peppercorn**, headings **Chili**, prices **Olive**, blocks **Cream**. Calm, warm, appetising, readable.

### 2.4 Surfaces & backgrounds — the rule

A saturated pepper hue is a **banner colour, not a surface colour**. Over large areas it vibrates, fatigues, and breaks text contrast.

- **Editorial** (menus, brochures, long-form, web body): backgrounds **only** Peppercorn or Paper/Parchment.
- **Banners / promo blocks** (short bursts): a saturated fill is allowed **only** when the text on it passes contrast.
- **No pure white** — the lightest surface is Paper `#FCF7E8`. Light grounds are always a cream/parchment tint.

### 2.5 Accessibility (validated in Adobe Color)

- Palette is **colour-blind safe** (no conflicts across deuter/prot/tritanopia).
- **Lemon and Lime are not interchangeable as grounds** (re-measured Aug 2026 — the old rule lumped them together and was wrong for Lime):

| Text on… | Lemon `#FFED00` | Lime `#C1DB34` |
|---|---|---|
| Chili `#E34314` | 3.4 : 1 — large text / UI only | **2.65 : 1 — fails, don't use** |
| Olive `#737D3A` | 3.7 : 1 — large text / UI only | **2.86 : 1 — fails, don't use** |
| Peppercorn `#151317` | 15.3 : 1 ✓ | 11.8 : 1 ✓ |
| Ash `#54513F` | 6.6 : 1 ✓ | 5.1 : 1 ✓ |

  On **Lime**, only Peppercorn and Ash are safe — including for muted labels, which is the easy mistake (Olive reads as "quiet green on green" and is the value that fails). On **Lemon**, Chili and Olive clear the 3:1 floor for large text and UI, nothing smaller.
- For red text that must pass at small sizes on light grounds, use **Deep Chili** `#9B2705`. Day-only: Deep Chili on Peppercorn is 2.4:1 and fails at any size.
- Lemon and Lime are fills-behind-dark-text or accents on Peppercorn — never small text on a light surface.
- **Logo is exempt** — its Chili red reads fine on these grounds due to Molot's weight and because it isn't body copy.

### 2.6 Semantic tokens — Night / Day (dev handoff)

The primitive palette (§2.2) maps to a small set of **semantic tokens** with a Day and a Night value. This is the layer developers theme against — one toggle (`:root` = Day, `[data-theme="night"]` = Night). The palette was built for this: Ash↔Mushroom and Peppercorn↔Parchment are deliberate day/night twins.

| Semantic token | Day | Night |
|---|---|---|
| `--bg` (page ground) | Paper `#FCF7E8` | Peppercorn `#151317` |
| `--surface` (raised / cards) | Parchment `#F3E9D2` | Soft Peppercorn `#201E22` |
| `--text` (primary) | Peppercorn `#151317` | Parchment `#F3E9D2` |
| `--text-muted` | Ash `#54513F` | Mushroom `#9E9789` |
| `--text-highlight` | Chili `#E34314` | Cream `#FFF689` |
| `--accent` (primary) | Chili `#E34314` | Chili `#E34314` |
| `--accent-2` (secondary) | Olive `#737D3A` | Lime `#C1DB34` |

```css
:root {            /* Day */
  --bg: #FCF7E8; --surface: #F3E9D2; --text: #151317;
  --text-muted: #54513F; --text-highlight: #E34314;
  --accent: #E34314; --accent-2: #737D3A;
}
[data-theme="night"] {
  --bg: #151317; --surface: #201E22; --text: #F3E9D2;
  --text-muted: #9E9789; --text-highlight: #FFF689;
  --accent: #E34314; --accent-2: #C1DB34;
}
```

> **⚠️ Always review auto-switched screens by eye and for contrast — the mode switch is a starting point, not a finish line.** The map covers most surfaces and text, but expect exceptions that need an explicit **per-mode override** (a subclass), not a bent token. Known cases:
> - **Saturated accents used as text.** Lime/Lemon read on Peppercorn but *fail* on Paper — hence `--accent-2` is Olive by day, Lime by night. Any accent used as a text colour must be remapped per mode, not shared.
> - **Borders / hairlines.** A light hairline vanishes on dark; give it its own night value rather than inheriting.
> - **Shadows / elevation.** Shadows read on light and disappear on dark — signal elevation with `--surface` (Soft Peppercorn) instead of a shadow in night mode.
> - **Photography & baked-in backgrounds.** Images with a fixed ground don't switch — check they sit correctly in both modes.
>
> When a token doesn't hold in one mode, add a mode-specific override for that component — don't force the shared token to cover both.

---

## 3. Typography

### 3.1 Faces

- **Display — Molot.** Heavy, condensed, all-caps. The signature; the most recognisable thing we own. Display only — headlines, event titles, big numbers, signage. Never body text.
- **Body & UI — Golos Text.** Russian-first grotesque with native-quality Cyrillic and a touch of warmth; recedes behind Molot. Replaces the old Calibri pairing. Use the *Golos Text* cut, not display *Golos*.
- **No serif — decided.** No serif pairs with Molot; Adelle is not used. Two strong voices fight; one display face leads, a neutral grotesque (Golos) carries the rest. Golos covers all long-form, including the About page.

### 3.2 Display system — one face, hierarchy by size & colour

For posters/flyers, **don't pair Molot — let it run alone.** Build hierarchy from **size, colour, case, position**, not a second typeface. This is Constructivist poster logic (Rodchenko, the Stenbergs, El Lissitzky) — a lineage Molot already belongs to.

- One display face per surface — never pair Molot with another display face.
- Keep Molot to short bursts (3–7 words / numbers). Switch to **Golos** for anything long or small — addresses, the 18+ line, fine print.
- Lead with colour roles: Chili leads, Lemon/Lime highlight, Parchment/Cream carry the text on black.
- **Editorial exception:** Golos for body copy in brochures and menus — type for *reading*, not *seeing*.
- Keep the mood playful-industrial, not severe — warm tones and the pepper motif are the counterweight.
- Molot reads better at **moderate sizes** in blocks (texture/architecture) than at huge sizes.

### 3.3 Scale (synced with Figma text styles)

**Re-synced from the Figma file, Aug 2026.** The table below is now a transcription of the local text styles and the `Typography` variable collection, not a parallel spec. Where the two disagreed, Figma won and the corrections are noted.

| Style (Figma name) | Face / weight | Desktop | Mobile | Line height / tracking |
|---|---|---|---|---|
| Display — `Heading/Display` | Molot | 76 | 64 | 110% / 4% |
| Home hero — `Heading/HomeHero` | Molot | 76 | *content-sized, see below* | 104% / 4% |
| H1 — `Heading/H1` | Molot | **64** | **36** | 105% / 4% |
| H2 — `Heading/H2` | Molot | 24 | 24 | 125% / 5% |
| H3 — eyebrows — `Heading/H3` | Molot | 18 | 18 | 135% / 5% |
| Molot caption — `Heading/Captions` | Molot | 16 | 16 | 140% / 4% |
| Subtitle — `Body/Subtitle` | Golos 400 | 20 | 20 | 140% / 0% |
| Body — `Body/Regular` | Golos 400 | 16 | 16 | 140% / 0%, ¶ spacing 16 |
| Body semibold — `Body/Semibold` | Golos 600 | 16 | 16 | 140% / 0% |
| Secondary — `Body/Secondary` | Golos 400 | 14 | 14 | 140% / 4% |
| Secondary highlight — `Body/Secondary Highlights` | Golos 500 | 14 | 14 | 140% / 4% |
| Caption — `Body/Caption` | Golos **400** | 13 | 13 | 140% / 4% |
| Button — `UI/ButtonPrimary` | Golos 600 | 16 | 16 | 160% / 0% |
| Nav item — `UI/NavItem` | Golos 500 | 16 | 16 | 100% / 0% |
| Form label — `UI/Form Label` | Golos 500 | 13 | 13 | 140% / 4% |

**Corrections made in this sync (Aug 2026):** H1 was documented at 44 and is 64 — the doc was stale; line height 125%→105% and tracking 5%→4% with it. Display line height was documented at 120% and is 110%. **Caption is Golos 400, not 500** — this closes the open question in §9 and the "weight open" note in `website-brief.md` → Image caption label. Molot ships in a single weight (Regular); the weight ramp (400/500/600/700) is Golos only.

**Responsive rule — only the display levels move.** The `Typography` collection carries **Desktop** and **Mobile** modes, and just two sizes change: Display 76→64 and H1 64→36. H2, H3, Body, Caption and every UI style hold across breakpoints. That is the responsive type rule; there isn't a second one.

**Home hero is the exception, and it's fragile.** `Size/HomeHero` on mobile doesn't take a fixed value — it aliases `HeadlineFontSize` in the `mealTime` collection, which is 56 for every state except Party (52), sized around the longest English string. RU runs 10–15% longer, so this will break on translation. Replace the per-state pixel values with a fluid clamp or a fit-to-box rule before the RU pass. *(Open.)*

**Two Molot exceptions now exist, and only one is sanctioned.** `website-brief.md` → Sanctioned small-size exception permits Molot below display size in exactly one place (13–18px meal-period labels). `Heading/Captions` is Molot at 16 and is a second. Either sanction it explicitly with a named scope, or fold it into H3. *(Open.)*

Headings run Molot all the way down — hierarchy by size and colour (§3.2), never by switching face. Golos enters where reading starts: body, captions, UI. Web interaction typography (the three "tappable" styles) is specified in `website-brief.md` → Interaction rule.

---

## 4. Logo

The chili-and-shaker mark fuses kitchen and bar — the whole positioning in one symbol. Keep it; consolidate into a clear hierarchy.

Clean 2026 SVG set in `design/logos/2026/` (svg + png + jpg, plus `logo-sweet.ai`).

| Version | Ratio | Use |
|---|---|---|
| Horizontal | ≈ 4.75 : 1 | wide spaces: signage, web header, social covers (primary) |
| Rectangular | ≈ 1.8 : 1 | framed/contained: cards, ads, ad blocks |
| Stacked | ≈ 2.1 : 1 | narrow layouts: posters, menus, columns |
| Stamp | 1 : 1 | round "Good Food & Drink Since 2014" seal — secondary |
| Symbol | ≈ 0.72 : 1 | shaker + chili alone (transparent) — avatars, small UI |
| Favicon | 1 : 1 | Symbol on a Lime disc, ¼-symbol-height internal padding — browser tabs, app icons (web); legible to 16 px |

**Decision rule:** wide → Horizontal; framed → Rectangular; narrow → Stacked; square/tiny → Stamp or Symbol; browser tab / app icon → Favicon.

**Clear space.** One unit across the whole system: **h = the height of the pepper-shaker mark** as it appears in that lockup (bare Symbol in the stacked/rectangular; sealed badge in the horizontal; the disc for the stamp). An exclusion zone, kept **symmetric** for the placed logos (a logo is a fixed object, so its buffer stays equal — unlike UI padding):

- **Horizontal, Rectangular & Stacked** — **½ h**, equal all sides.
- **Stamp** — **¼ h**, equal all sides (a circle wants equal radial clearance).
- **Symbol & Favicon** — **¼ h top & bottom, ½ h left & right** — a deliberate 2:1 that squares off the portrait mark for square avatars/favicons (the one place the UI-padding instinct applies).

Construction guides: `design/logos/2026/*-spacing.svg`. Lime web variant: `design/logos/2026/rectangular-web.svg`. Keep **≥ 1 unit, equal**, on every side; no type, edges, or other marks inside it. Exception: a logo *container* (header bar, chip) may use more horizontal than vertical padding, but the equal clear space must fit inside it.

**Minimum sizes** (web / print): Horizontal ≥ 180 px / 45 mm · Rectangular ≥ 120 px / 32 mm · Stacked ≥ 96 px / 24 mm · Stamp ≥ 56 px / 16 mm · Symbol ≥ 24 px (favicon 16–32 px uses the Symbol). Below the horizontal minimum, switch to Stacked or Symbol.

- Don't stack drop-shadow + outline + glow. Don't recolour the pepper (red pepper, green shaker, always).
- At small sizes, avoid the stamp-in-the-middle horizontal lockup (the word splits) — use the Symbol or Stacked version.
- **Backgrounds:** for web prefer **Peppercorn or Lemon** — the Lime ground that works in print didn't read well on screen.

---

## 5. Motifs & iconography

### 5.1 Motifs

- **Red chili + green shaker** — hero motif; use sparingly and at quality.
- **Bottle-cap / badge edge** — scalloped seal shape; good as a stamp or section marker.
- **Bartender's ticket** — an order-slip card on Paper with a bottle-cap scalloped tear-off edge; the kitchen–bar handshake made tangible. Started as a gut-feeling footer device, now a named component (spec in `website-brief.md`): the About pairing picker prints one. **No longer the footer base (Aug 2026)** — the footer is a saturated Lime band in both modes, and Lime out-brights Paper, so a slip there would lose the "brightest object in view" rule that makes it read as a receipt. The ticket stays a page-body component; the footer is the site's other closing device, and there is only one per page. The footer does borrow the ticket's *edge*: its top scallops take the colour of the section above (Parchment by day, Peppercorn by night). **Rugged-edge geometry (one spec everywhere):** 24 px circles, 24 px gap, 12 px visible — a 48 px repeating unit, painted in the ground colour; theme component `template-parts/components/rugged-edge.php`, examples in the style guide → Motifs.
- **Colour-block bars** — solid bands that carry text; the main "energy" device (replaces stacked effects).
- **Side rail** — the old vertical hashtag/socials/phone strip becomes a tasteful accent stripe on web.
- **Hot-pepper pattern** — current angry-pepper repeat is licensed stock; plan a **bespoke** pattern from our own chili-and-shaker language so the texture becomes ownable IP.

### 5.2 Icons

**Filled, bold, single-colour** is the default, echoing Molot's weight — one palette colour (Peppercorn on light, Parchment on dark, Chili for emphasis). It is a strong recommendation, not an absolute: some glyphs simply read better outlined (arrows are the standing example), and nobody can predict every case. When you break it, do it deliberately and consistently across the surface. Multicolour is reserved for real brand logos (social marks, below).

- **UI / functional icons → Phosphor Icons (Fill).** Chosen over Material Sharp because Material's coverage gaps keep biting; Phosphor's ~9,000 icons include the food/bar set we need (even a pepper). One library, one weight.
- **Social / brand logos → official full-colour marks** (VK, Telegram, Instagram), taken from each brand's own kit (`design/icons/social-media/`). They have always been full colour, on purpose: social marks are almost always contacts, and the colour separates them from the single-colour *supporting* icons at a glance. Don't recolour or redraw them.
- **Bespoke brand icons → stay custom:** the Yaroslavl bear (city coat of arms) and the pepper-shaker motif. *(Corrected Sep 2026: the two-tone Olive/Avocado veggie leaf existed only in the print menu; the website uses the Phosphor leaf for consistency, so it is not part of the bespoke set.)*
- Don't mix two UI icon libraries. Don't redraw real brand logos by hand.

---

## 6. Layout & components

- **Ground every layout** in Peppercorn (night) or Parchment/Paper (day).
- **Generous margins** — let content breathe.
- **One focal point** per view — a dish, a drink, an event, a headline.
- **Colour-block, don't decorate** — solid bands replace shadows/outlines/glows.
- **Flat by default** — if an effect is needed, one subtle shadow, never three.

The concrete grid (1120px content width, 12 columns, 24px gutter) and the body-copy width cap live in `website-brief.md` → Grid — not duplicated here.

---

## 7. Photography

Two governing ideas: **shoot in the bar**, and **set the scene**. The photos are the palette in real life — warm woods and ambers, with fresh-green and chili-red accents, lit like the room.

- **Always shot in the bar** — real environment (wood counter, tables, back-bar bottle wall, terrace). Never studio sweeps, stock, or third-party backgrounds. The blurred bottle wall behind a drink is the signature.
- **Always set the scene** — a still-life of the dish's own ingredients/garnish, an appropriate backdrop (bar counter for drinks, terrace for a seasonal menu), and seasonal cues (pine in winter, fruit in summer).
- **Light:** warm, low-key, directional with real shadow — never flat, cold, or overexposed. Warm white balance.
- **Shallow depth of field** — hero sharp, environment melts to warm bokeh.
- **Leave a quiet/dark area for Molot type** — many shots double as poster/menu grounds.

**Two registers, tied to the colour modes:**
- *Dark & moody (Mode A)* — cocktails, spirits, wine, evening, social; deep shadow, bottle-wall bokeh, hands/craft.
- *Warm & lighter (Mode B)* — food, breakfast/lunch, desserts, daytime menu; wood tables, a touch brighter, appetising.

Consistency comes from **setting + grade**, not studio perfection. Casual, slightly imperfect beats stocky and sterile.

**Web image ratios** (3:2, 2:3, 1:1, 21:9, 4:5-Instagram) and which content type uses which live in `website-brief.md` → Image ratios — not duplicated here.

---

## 8. Do & Don't (summary)

**Do**
- Ground every layout in Peppercorn (night) or Parchment (day).
- Let Molot lead; keep body quiet and readable (Golos).
- Reserve Lemon for highlights.
- Make new shades by moving along an existing hue line.
- Keep the loud, warm, hand-made personality; generous space; one focal point.

**Don't**
- Run all colours at full saturation with no neutral.
- Use a saturated hue as an editorial surface, or pure white anywhere.
- Set body or menus in all-caps; pair Molot with a serif on the same surface.
- Stack shadow + outline + glow.
- Mix two UI icon libraries, or bake social icons into artwork.

---

## 9. Open questions / next steps

- **Palette:** ✓ refined & validated in Adobe Color. Hexes locked here.
- **Body typeface:** ✓ Golos Text. Confirm weight set (400/500/600/700).
- **Caption weight — ✓ closed (Aug 2026): Caption is Golos 400.** Settled by re-syncing §3.3 against the Figma file, where `Body/Caption` has always been 400 and `UI/Form Label` is the 500 twin. The two 13px styles are now distinguished exactly as the Form text styles group intends — weight plus semantic name. **Consequence:** the brief's *Form hint* (Golos 400 · 13 / 140% / 4%) is pixel-identical to Caption; it keeps its own name inside the Forms group for readability, but it is one style, not two, and must not drift apart. Propagation still owed: the `img` component, the bartender's-ticket header line, the daypart status lines.
- **Adelle / serif:** ✓ decided — not used. Golos covers all long-form.
- **Ash vs Dark Olive:** ✓ resolved — Ash stays as secondary text on light; new neutral **Mushroom** `#9E9789` is its dark-ground twin (secondary text on Peppercorn, 6.4:1 AA).
- **Soft Peppercorn** `#201E22` added as the alternate dark-surface neutral (night mode section variation). **Dark Olive:** ✓ removed from the palette, Jul 2026 (see §2.2 note).
- **Icons:** ✓ Phosphor Fill (default, outline allowed where it reads better) + official full-colour social logos; bespoke bear/shaker stay custom. Veg label: ✓ Phosphor leaf on the website (the two-tone print leaf is retired).
- **Logo set:** ✓ clean 2026 SVG family in place with clear-space (X) + min sizes (`design/logos/2026/`).
- **Pattern:** design a bespoke pepper pattern to replace the licensed stock one.
- **Rich black:** confirm print formula (`C15 M23 Y0 K95`) and screen value (`#151317`).
- **Figma — variables audited Aug 2026.** Collections present: `Color` (17), `Typography` (13, Desktop/Mobile modes), `Sizes`, `Spacing`, `mealTime`. Findings still owed:
  - **No semantic token layer exists in Figma.** §2.6 defines `--bg` / `--surface` / `--text` / `--text-muted` / `--text-highlight` / `--accent` / `--accent-2` with Day and Night values, but `Color` has a single "Value" mode and holds primitives only. Typography got modes for breakpoint; colour never got them for theme, so every day/night variant is built by hand. **This is the next Figma job** — a Theme collection with Day/Night modes aliasing the palette, matching §2.6 exactly so the CSS and the file stay in step.
  - **`Neutral/Dark Olive*`** — ✓ deleted from the `Color` collection, Aug 2026. It had outlived the Jul decision as a live bindable variable marked only with an asterisk.
  - **`imgOverlayDark`** — ✓ typo fixed in the file and documented in §2.2. It is the **inactive-image dim** (Peppercorn at 33%), not a caption scrim; the two must stay separate tokens.
  - **Naming drift:** the file uses `Chili Deep` and `Lime Light`; §2.2 says *Deep Chili* and *Light Lime*. Harmless until CSS variable names are generated from one of them — pick one order and apply it in both.
  - **Scopes:** `Size/HomeHero`, `Icons`, `Spacing`, `Soft Peppercorn`, the overlay and every `mealTime` variable are set to `ALL_SCOPES`, which puts them in every property picker. Narrow them (`FONT_SIZE`, `GAP`, `WIDTH_HEIGHT`, `TEXT_FILL`…) before the file grows.
  - **`mealTime` holds the daypart *structure*; its strings are placeholder.** Ten flattened states carrying `Headline`, `CTA`, `kitchenState`, `nowState`, `Icon`, `MultilineState`. The structure is real and is what the hero components bind to; the copy is scaffolding (author's note, Aug 2026 — it will be written properly against the built page). **`website-brief.md`'s status-line matrix stays canonical for copy**, and the Figma strings get regenerated from it once hours are confirmed with Iurii. Two known gaps to close in that pass: the Figma model has no weekend/brunch variants, and `Closed` carries the Party kitchen line plus a literal `"String value"`.
  - **`nowState` is misnamed.** Its three values (`now` / `last call` / `off`) switch **body copy**, not the now-marker — the marker label is always `now` (The day/night concept → The now-marker). Rename it in Figma before anyone binds the marker to it and ships a card reading "off".

  Then hand off to a custom WordPress theme (+ ACF for staff-editable content) for the live build — see `website-brief.md` → Platform for why Webflow is ruled out (closed to Russian customers and visitors under OFAC sanctions).

---

*Compiled from founder context, original print/outdoor files, and the validated Adobe Color palette. Pairs with `style-guide-draft.html` and `website-brief.md`.*
