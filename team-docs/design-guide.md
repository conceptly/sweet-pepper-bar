# Sweet Pepper — Brand & Design Guide

*Team edition · September 2026 · For new designers and social media creators*
*Shake & Cook · Good food & drink since 2014 · Kirova St. 10, Yaroslavl*

This is the short, practical version of the Sweet Pepper visual system. It tells you what the brand looks like, which rules matter, and where the files are. The full spec with reasoning lives in `design.md`; website-specific decisions live in `website-brief.md`; the illustrated reference is `sweet-pepper-style-guide.pdf`.

**Two kinds of rules.** *Brand core* rarely changes: Molot as the display face, the three-ramp pepper palette, the cosy↔spicy tension, photography shot in the bar. Everything else is a *working rule* — it can be revised for a real reason, but update the doc when you do; don't quietly drift.

---

## 1. Who we are

A hybrid gastrobar: a serious all-day kitchen fused with a craft cocktail bar, run as a neighbourhood anchor. The look holds two moods at once:

- **Cosy** — warm, soulful, familiar. The half that brings people back.
- **Spicy** — loud, playful, a little rough. The pepper energy that makes it memorable.

Every decision sits somewhere between the two. When in doubt: keep the energy, add warmth and air. Refine the loudness, never sanitise it — the slight roughness is part of the brand.

---

## 2. Voice

Write from the **guest's side**, not ours:

| Say | Not |
|---|---|
| Your route to Pepper | Find us |
| Your fav drink | Our drinks |
| Your table for Friday | Book a table with us |

Headings, labels, buttons and captions all use the guest's "your". The bar speaks as "we" in exactly one place: **replies** — order-slip/ticket messages, status lines, comment answers. The guest owns the questions; the bar owns the replies.

Russian and English are **register twins**, not literal translations — match the tone, not the words.

---

## 3. Colour

### 3.1 The palette

Everything is a tint or shade of **three hues** — chili red, green, yellow — plus warm neutrals. Never add a fourth hue. Need a new shade? Make an existing colour lighter or darker at the same hue.

**Red line**

| Name | Hex | Role |
|---|---|---|
| Chili | `#E34314` | Hero red · primary accent · headings by day |
| Paprika | `#EF6D44` | Support orange |
| Deep Chili | `#9B2705` | Small red text on light grounds (day only) |

**Green line**

| Name | Hex | Role |
|---|---|---|
| Lime | `#C1DB34` | Signature green (cocktail) · highlight on dark |
| Light Lime | `#D4E671` | Lightest green tint |
| Avocado | `#869438` | Support green |
| Olive | `#737D3A` | Secondary green · prices by day |

**Yellow line**

| Name | Hex | Role |
|---|---|---|
| Lemon | `#FFED00` | Highlight only — small doses |
| Cream | `#FFF689` | Block tint · highlight text on dark |

**Neutrals**

| Name | Hex | Role |
|---|---|---|
| Peppercorn | `#151317` | Brand black — the night ground |
| Soft Peppercorn | `#201E22` | Raised dark surface (cards on Peppercorn) |
| Ash | `#54513F` | Muted text on light |
| Mushroom | `#9E9789` | Muted text on dark |
| Parchment | `#F3E9D2` | Warm off-white surface · body text on dark |
| Paper | `#FCF7E8` | Lightest surface — **there is no pure white** |

Print: Peppercorn = `C15 M23 Y0 K95` · Parchment = `C5 M11 Y40 K0` · Cream = `C0 M0 Y60 K0`.

### 3.2 Night and Day

Loud colours never carry a layout on their own — a neutral ground does the work. Two modes:

- **Night** — bar, cocktails, evening, posters, most social. Ground Peppercorn. Text Parchment (body) and Cream (highlight). Chili leads, Lime/Lemon highlight, Paprika supports. High energy, maximum contrast.
- **Day** — kitchen, breakfast/lunch, daytime menu. Surface Parchment or Paper. Body Peppercorn, headings Chili, prices Olive, blocks Cream. Calm, warm, appetising.

On the website the mode switches automatically with the time of day; in social and print you choose it by content.

### 3.3 Surfaces

A saturated pepper colour is a **banner colour, not a background colour** — over a large area it vibrates and kills legibility. Long-form surfaces (menus, brochures, web body) are only Peppercorn, Parchment or Paper. Short promo blocks and bands may use a saturated fill *if* the text on it passes the pairings below.

### 3.4 Safe text pairings

The palette is colour-blind safe. What fails is contrast — use this table:

| Ground | Safe for any text | Large text / UI only | Don't |
|---|---|---|---|
| Peppercorn | Parchment, Cream, Mushroom, Chili, Lime, Lemon, Paprika | — | Deep Chili |
| Paper / Parchment | Peppercorn, Ash, Deep Chili | Chili (headings), Olive | Lime, Lemon, Cream, Paprika |
| Lemon | Peppercorn, Ash | Chili, Olive | anything else |
| Lime | Peppercorn, Ash | — | Chili, Olive, anything else |

The easy mistake: Olive on Lime looks like a tasteful "quiet green on green" and fails. On Lime, only Peppercorn and Ash. The logo is exempt — its red reads fine at logo weight.

---

## 4. Typography

**Two faces, no serif.**

- **Molot** — display. Heavy, condensed, all caps, one weight. Headlines, event titles, big numbers, prices on posters, signage. Keep it to short bursts (3–7 words). Never body text, never paired with another display face.
- **Golos Text** — everything you read: body, captions, addresses, fine print, buttons, the 18+ line. Use the *Golos Text* cut (not display Golos). Weights 400/500/600.

**Hierarchy comes from size, colour, case and position — not from switching typeface.** This is poster logic: one loud face, arranged. Chili leads, Lemon/Lime highlight, Parchment/Cream carry text on black. Molot works best at moderate sizes stacked in blocks; at huge sizes it loses texture.

**Web scale (from Figma)**

| Style | Face | Desktop / Mobile | Line height · tracking |
|---|---|---|---|
| Display | Molot | 76 / 64 | 110% · 4% |
| H1 | Molot | 64 / 36 | 105% · 4% |
| H2 | Molot | 24 | 125% · 5% |
| H3 / eyebrow | Molot | 18 | 135% · 5% |
| Subtitle | Golos 400 | 20 | 140% |
| Body | Golos 400 | 16 | 140% |
| Caption / form label | Golos 400 / 500 | 13 | 140% · 4% |
| Button | Golos 600 | 16 | 160% |

Only Display and H1 change size between desktop and mobile; everything else holds. Never set body copy or menus in all caps.

---

## 5. Logo

The chili-and-shaker mark says kitchen + bar in one symbol. Files: `design/logos/2026/` (svg, png, jpg, `.ai`).

| Version | Ratio | Use it for |
|---|---|---|
| Horizontal | ≈ 4.75 : 1 | Wide spaces — signage, web header, social covers (primary) |
| Rectangular | ≈ 1.8 : 1 | Framed spaces — cards, ads, ad blocks |
| Stacked | ≈ 2.1 : 1 | Narrow layouts — posters, menus, columns |
| Stamp | 1 : 1 | Round "Good Food & Drink Since 2014" seal — secondary |
| Symbol | ≈ 0.72 : 1 | Shaker + chili alone — avatars, small UI |
| Favicon | 1 : 1 | Symbol on a Lime disc — browser tabs, app icons (`favicon.svg`, use as-is) |

**Pick by shape:** wide → Horizontal · framed → Rectangular · narrow → Stacked · square/tiny → Stamp or Symbol.

**Clear space.** Unit **h** = the height of the shaker mark inside that lockup. Horizontal, Rectangular and Stacked: ½h on all sides. Stamp: ¼h on all sides. Symbol: ¼h top and bottom, ½h left and right. Nothing — type, edges, other marks — inside that zone. Construction guides: `design/logos/2026/*-spacing.svg`.

**Minimum sizes** (screen / print): Horizontal 180 px / 45 mm · Rectangular 120 px / 32 mm · Stacked 96 px / 24 mm · Stamp 56 px / 16 mm · Symbol 24 px. Smaller than the Horizontal minimum? Switch to Stacked or Symbol.

**Rules**

- Red pepper, green shaker — never recolour.
- No drop shadow, outline or glow on the logo.
- On screen, place it on Peppercorn or Lemon (the Lime ground works in print but not on screen; `rectangular-web.svg` is the exception).
- At small sizes avoid the horizontal lockup with the stamp in the middle — the wordmark splits. Use Symbol or Stacked.

---

## 6. Motifs & icons

**Motifs**

- **Chili + shaker** — the hero motif. Use sparingly, at quality.
- **Bottle-cap edge** — the scalloped seal shape. Good as a stamp or section marker.
- **Bartender's ticket** — an order slip on Parchment/Paper with a scalloped tear-off edge; the kitchen–bar handshake made physical. One per page, in the page body. The footer borrows only the edge (its scallops take the colour of the section above). Edge geometry: 24 px circles, 24 px gap, 12 px visible; examples and the CSS recipe are in the style guide → Motifs.
- **Colour-block bars** — solid bands carrying text. This is the main "energy" device; it replaces shadows, outlines and glows.
- **Side rail** — the vertical hashtag/socials/phone strip, kept as a thin accent stripe.
- **Pepper pattern** — the old angry-pepper repeat (`design/old-chili-peppers-pattern/`) is licensed stock. Don't use it in new work; a bespoke pattern from our own chili-and-shaker language is planned.

**Icons** — filled, bold, single colour by default, in one palette colour (Peppercorn on light, Parchment on dark, Chili for emphasis). That's a strong recommendation, not a hard rule: some glyphs read better outlined (arrows, for one). If you break it, do it on purpose and keep it consistent across the piece.

- UI and functional icons: **Phosphor Icons, Fill weight** (`design/icons/website/`).
- Social logos (VK, Telegram, Instagram): the **official full-colour brand marks** (`design/icons/social-media/`). They stay in colour on purpose — they're contacts, and the colour sets them apart from the supporting icons. Don't recolour or redraw them.
- Bespoke: the Yaroslavl bear and the shaker motif. (The veg label on the website is the Phosphor leaf, not a custom icon.)
- Don't mix UI icon libraries, don't redraw real brand logos by hand.

---

## 7. Photography

Two ideas govern every shot: **shoot in the bar** and **set the scene**. The photos are the palette in real life — warm wood and amber, with fresh-green and chili-red accents, lit like the room.

- Real environment only: wood counter, tables, the back-bar bottle wall, the terrace. No studio sweeps, no stock, no borrowed backgrounds. The blurred bottle wall behind a drink is our signature.
- Dress the scene: the dish's own ingredients and garnish, the right backdrop (counter for drinks, terrace for a seasonal menu), seasonal cues (pine in winter, fruit in summer).
- Light warm, low-key and directional, with real shadow. Warm white balance. Never flat, cold or overexposed.
- Shallow depth of field — hero sharp, room melts to warm bokeh.
- Leave a quiet or dark area for type; many shots double as poster and social grounds.

Two registers, matching the colour modes: **dark & moody** (cocktails, spirits, wine, evening) and **warm & lighter** (food, breakfast, desserts, daytime). Consistency comes from setting and grade, not studio perfection — casual and slightly imperfect beats sterile every time.

---

## 8. Layout

- Ground every layout in Peppercorn (night) or Parchment/Paper (day).
- Generous margins — let it breathe.
- One focal point per view: a dish, a drink, an event, a headline.
- Colour-block, don't decorate. Flat by default; if an effect is truly needed, one subtle shadow, never a stack.

Web grid: 1120 px content width, 12 columns, 24 px gutter (details in `website-brief.md`).

---

## 9. Social media quick guide

**Formats.** Instagram feed 4:5; stories and reels 9:16; VK cover and web banners wide (3:2 or 21:9 for room shots). Landscape 3:2 and portrait 2:3 are the working photo ratios; 1:1 for avatars and the stamp.

**Pick the mode by content.** Cocktails, evening, events → Night (Peppercorn ground, Parchment/Cream text, Chili + Lime accents). Food, brunch, daytime → Day (Parchment/Paper ground, Chili headings, Olive prices). Don't mix modes in one post.

**Type on a post.** One Molot headline of 3–7 words in caps; details (date, price, address, 18+) in Golos. Hierarchy by size and colour, not by adding a font. A colour-block band behind the headline beats an outline or glow.

**Logo.** Symbol for the profile avatar, Horizontal for covers, Stamp as a small seal in a corner. Respect clear space and minimum sizes; don't put the logo over a busy part of the photo.

**Icons and social marks.** Supporting icons single colour from Phosphor; VK/Telegram/Instagram marks in their official full colour, never recoloured or hand-drawn.

**Photos.** Shot in the bar, warm light, room for type. If a photo doesn't have a quiet area, put the type on a colour band instead of over the image.

**Copy.** Guest's "your" in the post; "we" only when replying to comments and messages. RU and EN posts share a tone, not a translation.

---

## 10. Do & Don't

**Do**

- Ground layouts in Peppercorn or Parchment/Paper.
- Let Molot lead in short bursts; keep everything readable in Golos.
- Reserve Lemon for highlights.
- Make new shades by moving along an existing hue line.
- Keep it loud, warm and hand-made, with generous space and one focal point.

**Don't**

- Run every colour at full saturation with no neutral.
- Use a saturated hue as a large background, or pure white anywhere.
- Set body copy or menus in all caps; add a serif or a second display face.
- Stack shadow + outline + glow.
- Mix UI icon libraries, recolour social logos, or reuse the old stock pepper pattern.

---

## 11. Files & where to find them

| What | Where |
|---|---|
| **Asset cloud — fonts, logos, icons, photos (start here)** | [Yandex Disk](https://disk.yandex.com/d/qZYJDoH89S5ttg) |
| Fonts — Molot, Golos Text | [Yandex Disk › Fonts](https://disk.yandex.com/d/6tRMApbim44rYg) · `design/fonts/` |
| Logos — 2026 set, clear-space guides, favicon | [Yandex Disk › Logos](https://disk.yandex.com/d/4AnCJj12DiY0qg) · `design/logos/2026/` |
| Icons — website set, social logos, Yaroslavl bear | [Yandex Disk › Icons](https://disk.yandex.com/d/2Ggx_3QrFwl2gg) · `design/icons/` |
| Phosphor Icons — the UI icon library (Fill weight) | [phosphoricons.com](https://phosphoricons.com) |
| Palette swatches | `design/color/` |
| Photography | [Yandex Disk › Photos](https://disk.yandex.com/d/KVDn7UAQLpCC4A) · `photos/` |
| Illustrated style guide (HTML with EN/RU switch, PDF) | `style-guide-draft.html` · `sweet-pepper-style-guide.pdf` / `-ru.pdf` |
| Full design spec (with reasoning and history) | `design.md` |
| Website decisions — grid, day/night mechanic, image ratios | `website-brief.md` |
| Figma — Style Guide | [Sweet Pepper Style Guide](https://www.figma.com/design/Ymf85QTDs0Ttf2rGrx9ter/Sweet-Pepper-Style-Guide?node-id=4-18) |

Local paths in the table are relative to the `Sweet-Website` project folder; the same files are mirrored on the Yandex Disk link above.

Questions or a rule that isn't working for you? Raise it — a documented change is the system working; a silent workaround is not.
