# Sweet Pepper style guide — process report

Handoff note for any agent (Cowork, Antigravity, Claude Code) picking up the style-guide work. Read `design.md` first — it is the source of truth; this file explains how the guide artefacts were produced from it and where they stand as of 2026-09-08.

## 1. What exists

| Artefact | Path / location | Role |
|---|---|---|
| `design.md` | repo root | System source of truth. Every guide artefact must match it. If the guide and `design.md` disagree, fix the guide (or flag). |
| `website-brief.md` | repo root | Website-specific decisions (grid, day/night mechanic, image ratios). Not a style-guide input except §6 Layout. |
| `style-guide.html` | repo root (~1.5 MB, single file) · live at `sweetpepper.bar/style-guide.html` | **The live guide since 2026-09-08.** Interactive guide, EN + RU in one file with a language switch; app-style mobile layout ≤768px (see §6). Everything inline: base64 Molot, flattened logo SVGs with Copy-SVG buttons, embedded photos/icons/ticket screenshots, tokens in `:root`, print CSS. Sections 00–09 (Notes & open questions removed 2026-09-05 — the guide is audience-facing; open items live in this report and `design.md`). Text is edited in place on the live page — §10. |
| `style-guide-draft.html` | repo root | Frozen copy of the guide as of 2026-09-08 — backup only, do not edit. Previously live at `sweetpepper.bar/style-guide-draft.html`. |
| `style-guide-edit.js` · `style-guide-save.php` | repo root | In-page edit mode and its save endpoint (§10). Deployed by the host's cron next to `style-guide.html`. |
| `style-guide-config.example.php` → `style-guide-config.php` | repo root (template) / server only (filled) | Password hash + GitHub token for the edit mode. The filled file is git-ignored and was uploaded by hand to `public_html` (§10). |
| `sweet-pepper-style-guide.pdf` · `-ru.pdf` | repo root | A4 portrait renders of the HTML (EN 28 pp, RU 31 pp). Peppercorn cover, Paper pages, full bleed. |
| `tools/i18n/` | tools/ | `inject.py` (builds the bilingual HTML, Copy-SVG buttons and the mobile shell), `strings-ru.json` (all Russian text), `mobile-shell.html` (mobile home screen + section router), `grid4.py` (4 px-grid checker/fixer). `_old/` holds the retired index-keyed files — delete. See §6. **`inject.py` and `strings-ru.json` are retired for the live file since 2026-09-08 (§10)** — they still target `style-guide-draft.html` and must not be pointed at `style-guide.html`. |
| `team-docs/design-guide.md` · `design-guide-ru.md` | team-docs/ | Short team-facing guide for new designers / SMM (EN + RU). Derived from `design.md`; no open questions, no history. Update when a rule changes. |
| `figmaScreenshotws/ticketExamples/` | figmaScreenshotws/ | Source PNGs for the bartender's-ticket examples embedded in the HTML (cards, deal chip, four footers). |
| `tools/render-style-guide-pdf.py` | tools/ | Render pipeline, `--lang en|ru` (see §4). |
| Figma **Sweet Pepper Style Guide** | file key `Ymf85QTDs0Ttf2rGrx9ter` | Token-driven layout system for the guide: variables → text styles → components → pages. Pages built so far: Cover, Contents, Brand essence (P03), Logo (P04–P07), Colour (P08–P12). |
| Figma website file | file key `P7jYklzRIIFP8yGawnZPia` | Website design tokens/components. **Do not modify** its paragraph styles from guide work. |
| `design/logos/2026/` | design/ | Logo set: horizontal, rectangular, stacked, stamp, symbol (svg/png/jpg), `rectangular-web.svg` (Lime ground), `favicon.svg`, `*-spacing.svg` clear-space constructions. |
| `design/icons/website/` (47 SVGs), `design/icons/social-media/`, `yaroslavl-bear.svg` | design/ | Icon set (Phosphor Fill + official full-colour social logos + bespoke). |
| `design/fonts/Golos_Text/`, `Molot.otf` | design/ | Fonts (Golos variable TTF embedded in HTML/PDF). |

## 2. Decisions baked into the guide (summary — details in `design.md`)

- **Type:** Molot (single weight) for all headings, H1 down to H3, and for every all-caps label ("brow": section numbers, specimen labels, mode tags, Do/Don't, ramp labels) at 13–18 px with 6–8 % tracking; Golos Text body; JetBrains Mono for hex. No serif, no Adelle, no Inter/Roboto. Heading line-height 1.2; heading margins on the 4 px grid, bottom smaller than top. Type specimens show the face names ("Molot", "Golos Text") at 48 px.
- **Colour:** three monochromatic pepper ramps — red (Chili / Deep Chili / Paprika), green (Lime / Light Lime / Avocado / Olive), yellow (Lemon / Cream) — plus neutrals (Peppercorn / Soft Peppercorn / Ash / Mushroom / Parchment / Paper). Saturated hue = banner, not surface. No pure white; grounds are Paper / Parchment / Cream / Peppercorn. Ash is an addition made during guide work and kept.
- **Modes:** Night (Peppercorn ground) and Day (Parchment/Paper) as semantic tokens; auto-switched screens must still be reviewed by eye.
- **Icons (corrected 2026-09-03):** Phosphor Fill is the default, not an absolute — outline where it clearly reads better (arrows), consistently. Social logos are the **official full-colour marks** (never Simple Icons, never single-colour): they are contacts, and the colour separates them from supporting icons. Bespoke = Yaroslavl bear + shaker; the veggie leaf is the Phosphor leaf (the two-tone one was print-menu only).
- **Bartender's ticket / rugged edge:** slip + scalloped edge in the ground colour; 24 px circles, 24 px gap, 12 px visible (48 px unit); the footer borrows the edge only. Theme component `template-parts/components/rugged-edge.php`.
- **Accessibility:** colour-blind safe pairs only; Chili/Olive on Lemon = large text/UI only; on Lime only Peppercorn/Ash; Deep Chili is day-only.
- **Logo:** one clear-space unit `h` = pepper-shaker height in that lockup — now also shown as a four-card figure (units: Symbol, disc; examples: Stacked, Horizontal) because a teammate missed the rule in text. Horizontal/Rectangular/Stacked ½h all sides; Stamp ¼h; Symbol ¼h top/bottom, ½h sides. Favicon: **open** — construction file says ¼h all sides, `design.md` §4 says ¼h/½h. Min sizes: Horizontal ≥180 px, Rectangular ≥120, Stacked ≥96, Stamp ≥56, Symbol ≥24, favicon 16–32.
- **Document format:** A4 portrait only (landscape tested and rejected). 40 pt page margin, 16 pt gutter, 12 pt row gap.

## 3. HTML guide — how it was built

Single-file HTML, English source with a Russian layer injected by `tools/i18n/inject.py` (§6). Tokens live in `:root` (`--chili`, `--lime`, `--peppercorn`, `--text-*`, `--font-display/--font-body`, …) and the whole guide references them — change a token there, not in section markup. Logos are inline SVG with `<style>` classes flattened to inline fills and ids scoped per logo (class/id collisions between logos otherwise recolour each other). Print CSS block at the end: `@page A4`, one `section` per page, `break-inside: avoid` on cards, `html,body{background:transparent}` (the page ground is added in the PDF step so no seam appears).

Sync rule: after any `design.md` edit, re-check the HTML sections it touches; the HTML has drifted three times and was resynced (Aug 2026: type scale, Mushroom/Soft Peppercorn roles, imgOverlayDark; Sep 2026: icon rules). Editing sequence since 2026-09-08 (§10): **text in either language** is edited on the live page (`style-guide.html?edit`) and saved there — the server copy is the source for both languages; `strings-ru.json` and `inject.py` are retired for the live file. **Structure, CSS, images and SVGs** are still edited in the repo file: first pull the live file (`curl -o style-guide.html https://sweetpepper.bar/style-guide.html`) so no saved text is lost, edit, re-upload. Re-render both PDFs from the pulled file (§4, default source is now `style-guide.html`) and commit HTML + PDFs together.

## 4. PDF pipeline

`tools/render-style-guide-pdf.py`: Playwright Chromium prints the HTML to A4 → pypdf + reportlab lay a full-bleed underlay per page (Peppercorn p1, Paper others) → output. Source: `style-guide.html` by default (since 2026-09-08; `--src style-guide-draft.html` for the frozen copy) — pull the live file from the repo first (§3). Flags: `--lang en|ru` (RU sets `data-lang` before printing and writes `-ru.pdf`), `--out`, `--landscape-logo` (kept for reference; rejected). Playwright is **not** installed on the Mac — render in the Cowork cloud container (stage the HTML + `GolosText-VariableFont_wght.ttf`, `pip install pypdf reportlab`, run, commit the PDFs back). In the Sep 2026 container Chromium ran without extra libs; in an earlier sandbox it needed `LD_LIBRARY_PATH=<stub dir> PLAYWRIGHT_SKIP_VALIDATE_HOST_REQUIREMENTS=1` with a compiled `libXdamage.so.1` stub (apt is blocked); Google Fonts is blocked so Golos is injected via `@font-face` from `design/fonts/`; route handlers must be `async`. Orphan control was done by 3-col logo grids, flowing type specs/callouts and compaction (33 → 26 pages for the English text of Aug 2026; now 28 after the resource links, ticket examples, audience cleanup and the h-unit figure; `section#team` on its own page). The Russian render is 31 pages and was not orphan-tuned: a few type-scale rows and one callout split across pages.

## 5. Figma style-guide file — structure

Pages: 🎨 Foundations (A4 Colour + Typography specimens), 🧩 Components, 📄 Pages.

**Variables** (all with WEB code syntax = hex/px):
- `Palette` (collection 3:2) — the 15 brand colours, ids 3:3–3:17 in the order Chili, Deep Chili, Paprika, Lime, Light Lime, Lemon, Avocado, Olive, Peppercorn, Soft Peppercorn, Ash, Mushroom, Parchment, Cream, Paper.
- `Doc` (3:18) — semantic aliases: bg/page 3:19, bg/surface 3:20, bg/cover 3:21, bg/dark 3:22, bg/dark-raised 3:23, text/primary 3:24, text/muted 3:25, text/on-dark 3:26, text/on-dark-muted 3:27, accent/primary 3:28, accent/rule 3:29, border/hairline 3:30.
- `Type` (3:31) — families 3:32–3:34; sizes cover 64 / section 26 / lead 13 / body 10.5 / table 9.5 / small 9 / label 8.5 (3:35–3:41).
- `Space` (3:42) — space/4…56 (3:43–3:50), margin/page 40 (3:51), margin/gutter 16 (3:52), radius/card 8, radius/chip 6.

**Text styles** (15) bound to Type variables: Cover/*, Section/Number, Section/Title, Section/Lead, Heading/H3, Body/Regular, Body/Note, Label/Caption, Mono/Hex, etc. Section/Number and Heading/H3 = Molot Regular 10, caps, 8 % tracking (user decision).

**Components** (🧩): Page / A4 set 7:4 (Ground=Paper | Cover; 40 pt padding, vertical auto-layout); Section header 7:6 (Number / Title / Lead); Colour chip 7:11; Callout 7:24 (Type=Note | Warn, Text); Do / Don't card 7:36 (Kind, Items); Footer 9:36 (Type=Counter | Progress | Nav | Band; Section, Page, Prev, Next; nested exposed "Section strip" with Current=01…09 — reduced from 10 on 2026-09-05 when Notes was dropped and Team resources became 09); Panel 17:22 (Title, Body); Logo master set 2:151 (variant=horizontal | mobile-full | rectangular | stacked | stamp | symbol | favicon — plain frames, layoutMode NONE, SCALE constraints); Logo / doc set 20:60 (lockup=…, ≤200×100, for placing in pages); Logo tile set 26:164 (Ground=Parchment | Cream | Peppercorn × Lockup=…, Caption prop, aspect-locked FILL slot); imported Icons 2:1383, ruggedEdge 2:1505, img 2:1638, pill 2:1664.

**Pages built** (📄 Pages, row y = 1300, 655 apart): P01 Cover 27:137, P02 Contents 28:137 (nine sections, 01–09), P03 Brand essence 45:463, P04 Logo family 29:161, P05 hierarchy + do/don't + clear space 33:219, P06 clear-space constructions 37:322, P07 minimum sizes + favicon 39:382, P08 Colour palette & ramps 47:399 (ramp graphic 48:476 — three hue lines from design.md §2.2, mid-chili shown dashed as logo-only), P09 accent palette + neutrals 47:415, P10 imgOverlayDark + Night/Day mode cards 47:431, P11 contrast table + surfaces rule + banner 47:447, P12 semantic-token table + review-by-eye callout 52:512. Colour took five pages, not three: the overlay callout, the contrast table and the banner example each earn a block. Sample page 7:44 and closing page 11:55 (Lime band, now "09 · Team resources & contact") at y = 0. All footers read "/ 27" (EN PDF page count).

### Page-build pattern (repeat per page)

```js
// instance of Page/A4 → detach (instances can't take children)
const pageSet = await figma.getNodeByIdAsync('7:4');
let page = pageSet.children.find(c => c.name === 'Ground=Paper').createInstance();
pagesP.appendChild(page); page = page.detachInstance();
// text: setTextStyleIdAsync(styleId); fills via
//   figma.variables.setBoundVariableForPaint({type:'SOLID', color: realFallback}, 'color', variable)
// props: key = Object.keys(inst.componentProperties).find(k => k.startsWith('Title#'))
// rows: createAutoLayout('HORIZONTAL'), FILL width, itemSpacing bound to Space var
// bottom: FILL/FILL spacer frame, then Footer instance (Section, Page, strip Current)
// after detach: page.setBoundVariable('itemSpacing', space/12 = 3:45) — the Page/A4 default is 24
// header convention: Number = "02 · Logo", Title = the section name, Lead = intro paragraph
// figma.createAutoLayout() frames come with a WHITE fill — set fills=[] on every layout/row/column frame (invisible on Paper, glaring on Peppercorn)
// Golos has no ↔ glyph (renders as a gap); → is fine
// tables: VERTICAL frame of HORIZONTAL rows, cells FILL, row strokeBottomWeight=1 bound to border/hairline, Table/Header + Table/Cell styles
// overflow check: last child (Footer).y must be 780 with spacer ≥ 0; if not, rebalance blocks across pages before touching copy
```

Load `figma-use` + `figma-generate-library` skills before every `use_figma` call. Screenshot the page (`page.screenshot({scale:0.8})`) after each build and check row heights sum < page height.

### Figma gotchas learned (do not re-learn)

- Instances can't receive children — detach for content pages.
- Component-set-level text / instance-swap property defaults **override** per-variant content; set per instance, or make the axis a variant (that is why Lockup is a variant, not a swap).
- Never `resize()` a Logo tile instance — it freezes internal layout. Use FILL sizing only; to force a column width, wrap the tile in a fixed-width auto-layout frame and create the tile fresh inside it (moving an existing tile in collapses it).
- `rescale()` is not allowed on nested instances; auto-layout frames ignore SCALE constraints (set layoutMode NONE); `constraints` can't be set on children of an instance — only on the instance itself.
- Nodes inside a variant can't be removed directly — move to page, then remove.
- Bound paints need a real fallback colour (black fallback rendered black once); spreading `{...paint, opacity}` drops the opacity — set `fills[0].opacity` after.
- Cloned variants lose the Caption prop link — reset `text.componentPropertyReferences = {characters: key}`.
- Instances are named after the set ("Logo tile"), not the variant — identify by `getMainComponentAsync().name`.
- Imported components from the website file arrived with ~400 foreign bindings; all were rebound to local variables by exact value. `upload_assets` URLs are unreachable from the Cowork sandbox (proxy 403) — use `createNodeFromSvg` with an inlined string instead.

## 6. Sep 2026 changes — bilingual HTML, Copy SVG, mobile shell, cleanup, ticket examples

*(History — describes how the bilingual file was built; since 2026-09-08 the live file is `style-guide.html` and its text is edited in place, §10.)* `style-guide-draft.html` is now one file carrying both languages. Every text-bearing block exists twice as siblings — `<p lang="en">…</p><p lang="ru">…</p>` — and CSS on `html[data-lang]` hides the other language. Images, inline SVGs, swatches and hex values are not duplicated. A fixed EN/RU pill (top right, hidden in print) switches the language. Default = the system/browser language (`navigator.languages`, any `ru*` → RU, else EN) on every fresh visit; `?lang=ru|en` in the URL overrides it; a toggle click is remembered for that tab only (`sessionStorage`), so a new tab or a later visit goes back to the system language. Without JS the English layer shows.

- **Translations live in `tools/i18n/strings-ru.json`**, keyed by the whitespace-normalised English innerHTML of each text block (bs4 form: attributes sorted alphabetically, `&amp;` unescaped). Edit Russian text there, not in the HTML. When you add a new English block, add its key/value to the JSON; write anchor attributes in alphabetical order (`href rel style target`) so the key matches.
- **`python3 tools/i18n/inject.py`** (from the project root) rebuilds the bilingual file: it strips the previous injection, re-extracts the English leaves, and re-inserts the RU twins. Run it after any English edit in the HTML. It reports `STALE` for RU entries whose English no longer matches (re-key them in the JSON) and `MISS` for pattern failures (should not happen). Needs `beautifulsoup4` (present on the Mac); no Playwright for this step.
- `inject.py` also injects the **Copy SVG** buttons on the seven logo-gallery figures (a `<!-- COPY-SVG -->` block: serialises the inline `<svg>` with `xmlns`, strips `style`/`class`, copies to the clipboard; labels follow the language; hidden in print). Team-resource links (Yandex folders for logos/icons/photos/fonts, phosphoricons.com) are ordinary content in the HTML and in the JSON.
- **PDF:** see §4 — `--lang ru`.
- Icon rules in the HTML were corrected in the same pass (filled = default not absolute; social logos = official full-colour marks; veggie leaf dropped from the bespoke set) to match `design.md` §5.2.
- **Mobile shell (2026-09-04):** at ≤768px the page becomes an app-style guide — a home screen (Peppercorn cover + numbered list of the nine sections, "Using this guide" linked from the cover) and one section per page, routed by `#hash` (`#logo`, `#color`, …, `#home`). Fixed top bar (← Home, number + title, the EN/RU pill) and bottom bar (Previous · Home · Next). Desktop and print are untouched. All of it lives in `tools/i18n/mobile-shell.html` (CSS + JS, bilingual strings inline as `lang` spans) and is inserted by `inject.py` as the `<!-- MOBILE-SHELL -->` block; section names/descriptions for the menu are the `S` array in that file — keep them in step with the section headings. Mobile content tightening (padding, tables scroll horizontally, type-scale rows wrap) is in the same block. Verified at 390px in both languages: no horizontal overflow on any section.
- **Audience cleanup (2026-09-05):** the HTML is for other designers, not the author. Removed: section 09 Notes & open questions (Team resources is now 09), the "Two open items" and "Corrections from the Aug sync" callouts, the Dark Olive / Burnt Orange history, the Figma-sync notes, the Calibri/Inter/Roboto comparison and the "your Adelle question" framing (now a plain "No serif" rule), the "Retire from the artwork" note, and "Draft"/"synced to design.md" in the badge and footer. Long h3s shortened ("Type scale", "Neutrals & surfaces", "Display system — one face", "Two registers"). History and open items stay in `design.md` and §7 here.
- **Brows and h3 in Molot (2026-09-05):** all-caps labels ("brows") are Molot, not Golos bold: `h3` = Molot 18 / 1.2 / 6 % tracking, margin 32 0 12; `.section-num`, `.hero .badge`, `.mode-head .tag`, `.type-spec .label`, `.dd h4`, the ramp labels (`.brow`) and the mobile cover badge / bottom-bar labels = Molot 13–16 px, 6–8 % tracking; the Golos display heading in the type specimen is line-height 1.2, margin 12 0 16. All heading margins on the 4 px grid, bottom smaller than top. Rule of thumb from Etual: keep Molot labels to a few words.
- **4 px grid (2026-09-05):** every `margin`, `padding` and `gap` in the HTML, the inline styles, `inject.py`, `mobile-shell.html` and `strings-ru.json` was snapped to the nearest multiple of 4 (ties up) — 340 values. `python3 tools/i18n/grid4.py --check` lists violations; without the flag it fixes them in all four files. Run it after adding CSS. Positions (`top/left`), radii and font metrics are not touched.
- **h-unit figure (2026-09-06):** § Logo → Clear space now has a four-card figure (`.hunit`) right after the per-version list: row 1 = the two units (bare Symbol, Stamp disc), row 2 = the two examples (Stacked with the Symbol tinted, Horizontal with the badge tinted). The Lime tint, dashed outline, dimension bracket and italic Golos *h* are drawn at load time by a small inline `<script>` from `getBBox()` of the named groups (`#hu3_symbol`, `#hu4_stamp-2`), so they stay exact if a logo is swapped and they print (Chromium runs the script before `page.pdf`). The SVGs are copies of the gallery ones with ids re-prefixed `hu1_…hu4_` to avoid collisions. Cards are `display:flex; column; justify-content:space-between` so the captions share a baseline across each row whatever the artwork height (Etual's request 2026-09-06). Mobile: the two unit cards stay side by side, the two examples go full-width. Chosen by Etual from three mockups (A: three lockups; B: define-then-apply; C: inline) after a teammate missed the rule in text form.
- **Ticket examples (Sep 2026):** § Motifs now has "The bartender's ticket — examples" (seven PNGs from `figmaScreenshotws/ticketExamples/` embedded base64 on their intended grounds, plus a live-CSS slip) and "Rugged edge — the recipe" (24/24/12 px geometry, the theme's `radial-gradient` CSS, pointer to `template-parts/components/rugged-edge.php`).

## 7. Open items

1. **Favicon clear space** — reconcile `favicon-spacing.svg` (¼h all sides) with `design.md` §4 line "Symbol & Favicon ¼h/½h". P05 text follows design.md, P06 construction follows the file. Owner: Etual.
2. **Rectangular logo** — Figma "rectangular" master is the bare 158×73 art (identical lockup to Stacked). The framed Rectangular with Lime ground (`rectangular.svg` 255×141, `rectangular-web.svg`) is to be re-uploaded and swapped into master 2:151 → then Logo / doc, Logo tile and P04/P06 update automatically. Owner: Etual (upload), then agent (swap).
3. Remaining guide sections in Figma: Typography (2 pp; decide item 7 first), Motifs/Icons (3 pp — ticket examples + rugged edge are new), Layout (2), Do & Don't (1), Photography (2); Team resources = closing frame 11:55, just renumber/reposition. P03 has ~240 pt of empty space below the Voice note — candidate for a short Do/Don't or a review-quote pull. Reuse the pattern above; keep Progress footer with correct Section/Page/Current.
4. Optional: Night/Day Theme collection in the website Figma file; code syntax for Mushroom/Soft Peppercorn there; Do/Don't tints in the HTML are slightly off-palette; stray `tools/_raw.pdf`, `tools/_variant-landscape-logo.pdf`, `sweet-pepper-style-guide-PREVIEW.pdf`, `tools/i18n/_old/`, `tools/i18n/__pycache__/` can be deleted (agent deletes are not permitted).
5. **Deal chip shadow** — the drinks-deal screenshot carries a Deep Chili offset shadow (right/bottom); the system says flat by default. Decide: sanctioned "stacked paper" device or drop it. Owner: Etual.
6. **RU print pagination** — optional orphan tuning for the Russian PDF (see §4).
7. **Type scale rows** — the HTML scale still lists `Body/Secondary` (Golos 400 · 14) and `Secondary highlight`, which the website has largely replaced with Caption; the team guide already dropped them. Decide whether to remove the two rows here and in `design.md` §3.3 (and retire the Figma styles). Owner: Etual.
8. **Colour pages, small edits made while fitting (Sep 2026):** neutral chips carry short names only (roles are in the paragraph); P12 body says “Ash and Mushroom, Peppercorn and Parchment” instead of ↔ (glyph missing in Golos); the banner example runs Molot 20 pt. The Sample page 7:44 is now redundant with P08/P09 — delete or keep as the component demo. Footer totals still say 27 (EN PDF count) — recount once all sections are in Figma.
9. **Page 7 of the EN PDF** (favicon block) is mostly empty — a candidate for pulling the minimum-sizes list onto the same page. Cosmetic.
10. **"Draft" wording in the live file** — the `<title>`, the lang-switch script's two title strings and the hero badge/footer still say "Draft" / v0.3. The title strings are JS, not text blocks, so this is a repo edit, not an in-page one. Owner: Etual (decide the version label), then agent.
11. **Cron loop** — confirm the extended cron command from §9.3 is in place on the host; until then new versions of the editor/endpoint in the repo do not reach `public_html`.
12. **PDFs after in-page edits** — every editor commit changes `style-guide.html` but not the PDFs; re-render both (§4) before sharing PDFs, or accept that the PDFs lag.
13. **Editor limits to keep in mind** — text and links only; a new paragraph, section, image or table is a repo edit. Trailing line breaks are stripped on save; `<b>`/`<i>` become `<strong>`/`<em>`.

## 8. Working agreements

- `design.md` wins. Don't invent rules; flag conflicts with a section reference.
- Etual is the author: critique drafts, offer options (including at least one that deliberately breaks a rule), don't replace judgment.
- Concise, direct. English is the source language of the guide; the Russian layer is maintained in `tools/i18n/strings-ru.json`, register-twin not literal. Voice examples use «твой».
- Periodically re-verify the numbers in `design.md` (contrast ratios, token math) instead of trusting the tables.

## 9. Publishing — git and hosting (handoff for Claude Code / Antigravity)

Target repository: **`github.com/conceptly/sweet-pepper-bar`** — **live since Sep 2026**: `Sweet-Website` is the git root, `origin` is set over SSH, and pushes work from Claude Code on the Mac with Etual's credentials (Cowork sessions still cannot push). §9.1 below is kept as history of the first push.

### 9.1 First push — do exactly this

1. Run from the project root (`Sweet-Website`). Confirm `git status` is clean of noise: `.gitignore` is already in place and excludes `.DS_Store`, `__pycache__/`, `node_modules/`, `tools/_raw.pdf`, `tools/_variant-landscape-logo.pdf`, `tools/i18n/_old/`, `sweet-pepper-style-guide-PREVIEW.pdf`.
2. Before `git add`, check whether the remote already has commits (`git ls-remote origin` after step 4, or the GitHub page). If it is non-empty, `git pull origin main --allow-unrelated-histories` before pushing; do not force-push.
3. Init and commit — one commit, everything that is not ignored:
   ```
   git init
   git add .
   git commit -m "Sweet Pepper brand system: design.md, bilingual style guide (HTML + PDFs), team docs, WordPress theme"
   git branch -M main
   ```
4. Remote and push:
   ```
   git remote add origin git@github.com:conceptly/sweet-pepper-bar.git   # or the https URL
   git push -u origin main
   ```
5. Sanity check on GitHub: `style-guide-draft.html` (~1.5 MB), the two PDFs (~3.5 MB each), `design/`, `photos/`, `team-docs/`, `tools/i18n/` are present; `node_modules/` is not.

Notes for the agent doing this:
- Commit as Etual (the local git identity on the Mac), not as an agent identity.
- The two PDFs are build output but small enough to keep in git; they are committed on purpose so the team can download them from the repo. If Etual later wants them out, add them to `.gitignore` and `git rm --cached`.
- `sweet-pepper-theme/` ships in this same repo for now (it has its own `package.json`/Vite build; `dist/` is committed). Splitting it into its own repo is Etual's call, not a step here.
- Photos in `photos/` and screenshots in `figmaScreenshotws/` are part of the working files and go in.
- Nothing in the repo is secret; still, keep the repository **private** — the guide contains a personal phone number and internal open items.

### 9.2 Every later update

`git add -A && git commit -m "<what changed>" && git push`. Style-guide **text** no longer goes through git by hand — the in-page editor commits it (§10). For **structural** changes to the guide: `git pull` first (the editor may have committed), edit `style-guide.html`, re-render both PDFs (§4), commit HTML + PDFs together. Anything committed to `main` reaches the server on the next cron run (≤5 min).

### 9.3 Hosting the guide on the bar's domain

Decision: the guide is a **static file outside WordPress**, not a WP page. **Done (2026-09-08):** live at `https://sweetpepper.bar/style-guide.html` (HTTPS on), deep links `…/style-guide.html#logo`, language `…?lang=ru`, edit mode `…?edit`. The old draft URL still serves the frozen copy.

- **Deploy path:** the host's cron (every 5 min) pulls the repo into `$HOME/repository` and copies files into `$HOME/public_html`. The command must copy all guide files, not only the draft:
  ```
  cd "$HOME/repository" && git pull --ff-only origin main && for f in style-guide-draft.html style-guide.html style-guide-edit.js style-guide-save.php; do cp "$f" "$HOME/public_html/$f.tmp" && mv "$HOME/public_html/$f.tmp" "$HOME/public_html/$f"; done
  ```
  The first upload of the four files was done by hand through the hosting file manager (2026-09-08, permissions 600, which the host's PHP reads fine). `style-guide-config.php` lives only in `public_html`, never in git.
- The file carries `<meta name="robots" content="noindex, nofollow">`, `theme-color` and an Apple web-app title, so it stays out of search and "Add to Home Screen" gives the team an app-like icon. Etual is fine with the contact details being public; no basic auth on the folder (the `.htaccess` recipe from the earlier plan is dropped — the editor has its own password, and the guide itself is meant to be reachable).
- Optional, still open: a `/guide/` folder (`/guide/index.html`) for a nicer URL — move all four files together and keep `style-guide-save.php` next to the HTML; the editor uses relative paths. Also open: whether the PDFs go online (`/guide/en.pdf`, `/guide/ru.pdf`) — the Yandex hub already carries them.

## 10. In-page edit mode (2026-09-08)

Why: Etual wanted Webflow-style text editing on the page instead of VS Code + git for every wording change, and rejected a CMS rebuild (WordPress fields, Tilda, page builders) on scale — 674 EN/RU text blocks, layout that must not be touched by editors. The guide stays one static file; a small editor layer is loaded only on demand.

- **Enter:** open `style-guide.html?edit` (or `?lang=ru&edit`). A toolbar appears at the bottom; every element carrying a `lang` attribute (674 blocks: p, li, h2–h4, figcaption, span, a, strong, td/th, callouts, the footer line) becomes click-to-edit and is outlined — Chili dashed = EN, Olive dashed = RU. Nothing else is editable: swatches, hex values, SVGs, tables' structure, images, CSS.
- **Editing:** focusing a block reveals its translation next to it (twin peek); "show both languages" reveals all of them with EN/RU tags. ⌘B / ⌘I, ⌘K for links (on a link: edit or clear the URL; on a selection: create), Enter inserts a line break only (a new paragraph is a layout change — do it in the repo), paste is plain text, Revert block restores the original, changed blocks are tinted Lemon.
- **Save (⌘S):** the editor asks `style-guide-save.php` for the current file (from GitHub in GitHub mode, the local copy otherwise), finds the *n*-th lang-tagged element in the source (scripts, styles and comments masked), checks its tag, language and original text against what the page loaded, replaces only the inner HTML of the changed blocks, and posts the whole file back with the password and the version marker it received (GitHub blob sha, or the local mtime). Any mismatch aborts with a message instead of writing. `<b>`/`<i>` are normalised to `<strong>`/`<em>`.
- **Server (`style-guide-save.php`):** verifies the password against a bcrypt hash in `style-guide-config.php` (git-ignored; template `style-guide-config.example.php`; hash made on the Mac with `htpasswd -nBC 10 x | cut -d: -f2`, so the plain password is stored nowhere) and refuses to run without it. **GitHub mode (the live setup, 2026-09-08):** the config also holds a fine-grained GitHub token (this repo only, Contents read/write). `fetch` reads `style-guide.html` from `main` (metadata for the sha, blob API for the bytes — the Contents API omits bodies above 1 MB); `save` PUTs it back through the Contents API with that sha, so a save that raced another one is refused with 409. Every edit is a commit on `main` ("Style guide: text edited in place (n blocks)"); the host's cron pulls and copies it to `public_html` within ~5 minutes, which is the delay before an edit is live. The token never leaves the server. **Local mode** (no token in the config): writes the file next to the script, mtime check, rotating backups in `style-guide-backups/` (last 30) — only for a host that is not deployed from git, because a pull would overwrite the edits. Repo, branch and file name are fixed in the config; the client never chooses them.
- **Trust model:** one shared team password, sent over HTTPS (live since 2026-09-08), verified against a hash, half-second delay on a wrong guess; the endpoint can only overwrite the guide and always keeps a backup first. The password is remembered per browser tab only.
- **Deploy:** the host's cron (every 5 min) runs `git pull --ff-only` in `$HOME/repository` and copies files into `$HOME/public_html`. It must copy `style-guide.html`, `style-guide-edit.js` and `style-guide-save.php` (the draft copy can stay). `style-guide-config.php` is uploaded by hand once and is never touched by the cron.
- **Consequences:** in GitHub mode the repo is the source for both languages, as before — the editor is just another way to commit. `tools/i18n/inject.py` still targets `style-guide-draft.html` only and must never be run against the live file (it would strip the RU layer and rebuild it from the stale JSON). Before any repo-side edit or PDF render, pull the live file first (§3). `design.md` remains the source of rules and numbers — in-page edits are for wording, not for changing a rule. Pull before editing structure in the repo (`git pull`), since the editor commits to `main`.
- **Verified live (2026-09-08):** on `sweetpepper.bar` the config is not served as source (empty 200), the endpoint answers 405 on GET and 401 on a wrong password (PHP runs, config and hash load), and Etual's first real save committed to `main` through the GitHub API and deployed via the cron — "everything works". Earlier, **verified locally** against a Python stand-in for the PHP endpoint (both modes): block counts match between page and file (674/674, no tag/lang mismatch), a four-block EN+RU save changed exactly those blocks in the file, wrong password rejected, backup written. (The PHP could not be executed on the Mac — no PHP installed — hence the stand-in; the live run above closed that gap.)


## 2026-09-09 — RU/EN editorial pass (local review)

Refined the copy throughout `style-guide.html`, including the separate mobile navigation strings. Read the live file first and preserved the author's «06 — Композиция» edit. Changes are local: public page and PDFs still contain the earlier copy. The retired translation JSON and frozen draft were not edited. See `style-guide-copy-review.md` for editorial choices, unresolved technical contradictions and verification. The language-block order and count (674) remain compatible with in-page editing; no live save was performed.
