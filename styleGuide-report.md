# Sweet Pepper style guide — process report

Handoff note for any agent (Cowork, Antigravity, Claude Code) picking up the style-guide work. Read `design.md` first — it is the source of truth; this file explains how the guide artefacts were produced from it and where they stand as of 2026-09-04.

## 1. What exists

| Artefact | Path / location | Role |
|---|---|---|
| `design.md` | repo root | System source of truth. Every guide artefact must match it. If the guide and `design.md` disagree, fix the guide (or flag). |
| `website-brief.md` | repo root | Website-specific decisions (grid, day/night mechanic, image ratios). Not a style-guide input except §6 Layout. |
| `style-guide-draft.html` | repo root (~1.5 MB, single file) | Interactive guide, EN + RU in one file with a language switch; app-style mobile layout ≤768px (see §6). Everything inline: base64 Molot, flattened logo SVGs with Copy-SVG buttons, embedded photos/icons/ticket screenshots, tokens in `:root`, print CSS. Sections 00–10. |
| `sweet-pepper-style-guide.pdf` · `-ru.pdf` | repo root | A4 portrait renders of the HTML (EN 29 pp, RU 34 pp). Peppercorn cover, Paper pages, full bleed. |
| `tools/i18n/` | tools/ | `inject.py` (builds the bilingual HTML, Copy-SVG buttons and the mobile shell), `strings-ru.json` (all Russian text), `mobile-shell.html` (mobile home screen + section router). `_old/` holds the retired index-keyed files — delete. See §6. |
| `team-docs/design-guide.md` · `design-guide-ru.md` | team-docs/ | Short team-facing guide for new designers / SMM (EN + RU). Derived from `design.md`; no open questions, no history. Update when a rule changes. |
| `figmaScreenshotws/ticketExamples/` | figmaScreenshotws/ | Source PNGs for the bartender's-ticket examples embedded in the HTML (cards, deal chip, four footers). |
| `tools/render-style-guide-pdf.py` | tools/ | Render pipeline, `--lang en|ru` (see §4). |
| Figma **Sweet Pepper Style Guide** | file key `Ymf85QTDs0Ttf2rGrx9ter` | Token-driven layout system for the guide: variables → text styles → components → pages. Pages built so far: Cover, Contents, Logo (P04–P07). |
| Figma website file | file key `P7jYklzRIIFP8yGawnZPia` | Website design tokens/components. **Do not modify** its paragraph styles from guide work. |
| `design/logos/2026/` | design/ | Logo set: horizontal, rectangular, stacked, stamp, symbol (svg/png/jpg), `rectangular-web.svg` (Lime ground), `favicon.svg`, `*-spacing.svg` clear-space constructions. |
| `design/icons/website/` (47 SVGs), `design/icons/social-media/`, `yaroslavl-bear.svg` | design/ | Icon set (Phosphor Fill + official full-colour social logos + bespoke). |
| `design/fonts/Golos_Text/`, `Molot.otf` | design/ | Fonts (Golos variable TTF embedded in HTML/PDF). |

## 2. Decisions baked into the guide (summary — details in `design.md`)

- **Type:** Molot (single weight) for all headings, H1 down to H3; Golos Text body; JetBrains Mono for hex. No serif, no Adelle, no Inter/Roboto.
- **Colour:** three monochromatic pepper ramps — red (Chili / Deep Chili / Paprika), green (Lime / Light Lime / Avocado / Olive), yellow (Lemon / Cream) — plus neutrals (Peppercorn / Soft Peppercorn / Ash / Mushroom / Parchment / Paper). Saturated hue = banner, not surface. No pure white; grounds are Paper / Parchment / Cream / Peppercorn. Ash is an addition made during guide work and kept.
- **Modes:** Night (Peppercorn ground) and Day (Parchment/Paper) as semantic tokens; auto-switched screens must still be reviewed by eye.
- **Icons (corrected 2026-09-03):** Phosphor Fill is the default, not an absolute — outline where it clearly reads better (arrows), consistently. Social logos are the **official full-colour marks** (never Simple Icons, never single-colour): they are contacts, and the colour separates them from supporting icons. Bespoke = Yaroslavl bear + shaker; the veggie leaf is the Phosphor leaf (the two-tone one was print-menu only).
- **Bartender's ticket / rugged edge:** slip + scalloped edge in the ground colour; 24 px circles, 24 px gap, 12 px visible (48 px unit); the footer borrows the edge only. Theme component `template-parts/components/rugged-edge.php`.
- **Accessibility:** colour-blind safe pairs only; Chili/Olive on Lemon = large text/UI only; on Lime only Peppercorn/Ash; Deep Chili is day-only.
- **Logo:** one clear-space unit `h` = pepper-shaker height in that lockup. Horizontal/Rectangular/Stacked ½h all sides; Stamp ¼h; Symbol ¼h top/bottom, ½h sides. Favicon: **open** — construction file says ¼h all sides, `design.md` §4 says ¼h/½h. Min sizes: Horizontal ≥180 px, Rectangular ≥120, Stacked ≥96, Stamp ≥56, Symbol ≥24, favicon 16–32.
- **Document format:** A4 portrait only (landscape tested and rejected). 40 pt page margin, 16 pt gutter, 12 pt row gap.

## 3. HTML guide — how it was built

Single-file HTML, English source with a Russian layer injected by `tools/i18n/inject.py` (§6). Tokens live in `:root` (`--chili`, `--lime`, `--peppercorn`, `--text-*`, `--font-display/--font-body`, …) and the whole guide references them — change a token there, not in section markup. Logos are inline SVG with `<style>` classes flattened to inline fills and ids scoped per logo (class/id collisions between logos otherwise recolour each other). Print CSS block at the end: `@page A4`, one `section` per page, `break-inside: avoid` on cards, `html,body{background:transparent}` (the page ground is added in the PDF step so no seam appears).

Sync rule: after any `design.md` edit, re-check the HTML sections it touches; the HTML has drifted three times and was resynced (Aug 2026: type scale, Mushroom/Soft Peppercorn roles, imgOverlayDark; Sep 2026: icon rules). Editing sequence now: edit English in the HTML → add/re-key the Russian in `strings-ru.json` → run `inject.py` → re-render both PDFs.

## 4. PDF pipeline

`tools/render-style-guide-pdf.py`: Playwright Chromium prints the HTML to A4 → pypdf + reportlab lay a full-bleed underlay per page (Peppercorn p1, Paper others) → output. Flags: `--lang en|ru` (RU sets `data-lang` before printing and writes `-ru.pdf`), `--out`, `--landscape-logo` (kept for reference; rejected). Playwright is **not** installed on the Mac — render in the Cowork cloud container (stage the HTML + `GolosText-VariableFont_wght.ttf`, `pip install pypdf reportlab`, run, commit the PDFs back). In the Sep 2026 container Chromium ran without extra libs; in an earlier sandbox it needed `LD_LIBRARY_PATH=<stub dir> PLAYWRIGHT_SKIP_VALIDATE_HOST_REQUIREMENTS=1` with a compiled `libXdamage.so.1` stub (apt is blocked); Google Fonts is blocked so Golos is injected via `@font-face` from `design/fonts/`; route handlers must be `async`. Orphan control was done by 3-col logo grids, flowing type specs/callouts and compaction (33 → 26 pages for the English text of Aug 2026; now 29 with the resource links and ticket examples, `section#team` on its own page). The Russian render is 34 pages and was not orphan-tuned: a few type-scale rows and one callout split across pages.

## 5. Figma style-guide file — structure

Pages: 🎨 Foundations (A4 Colour + Typography specimens), 🧩 Components, 📄 Pages.

**Variables** (all with WEB code syntax = hex/px):
- `Palette` (collection 3:2) — the 15 brand colours, ids 3:3–3:17 in the order Chili, Deep Chili, Paprika, Lime, Light Lime, Lemon, Avocado, Olive, Peppercorn, Soft Peppercorn, Ash, Mushroom, Parchment, Cream, Paper.
- `Doc` (3:18) — semantic aliases: bg/page 3:19, bg/surface 3:20, bg/cover 3:21, bg/dark 3:22, bg/dark-raised 3:23, text/primary 3:24, text/muted 3:25, text/on-dark 3:26, text/on-dark-muted 3:27, accent/primary 3:28, accent/rule 3:29, border/hairline 3:30.
- `Type` (3:31) — families 3:32–3:34; sizes cover 64 / section 26 / lead 13 / body 10.5 / table 9.5 / small 9 / label 8.5 (3:35–3:41).
- `Space` (3:42) — space/4…56 (3:43–3:50), margin/page 40 (3:51), margin/gutter 16 (3:52), radius/card 8, radius/chip 6.

**Text styles** (15) bound to Type variables: Cover/*, Section/Number, Section/Title, Section/Lead, Heading/H3, Body/Regular, Body/Note, Label/Caption, Mono/Hex, etc. Section/Number and Heading/H3 = Molot Regular 10, caps, 8 % tracking (user decision).

**Components** (🧩): Page / A4 set 7:4 (Ground=Paper | Cover; 40 pt padding, vertical auto-layout); Section header 7:6 (Number / Title / Lead); Colour chip 7:11; Callout 7:24 (Type=Note | Warn, Text); Do / Don't card 7:36 (Kind, Items); Footer 9:36 (Type=Counter | Progress | Nav | Band; Section, Page, Prev, Next; nested exposed "Section strip" with Current=01…10); Panel 17:22 (Title, Body); Logo master set 2:151 (variant=horizontal | mobile-full | rectangular | stacked | stamp | symbol | favicon — plain frames, layoutMode NONE, SCALE constraints); Logo / doc set 20:60 (lockup=…, ≤200×100, for placing in pages); Logo tile set 26:164 (Ground=Parchment | Cream | Peppercorn × Lockup=…, Caption prop, aspect-locked FILL slot); imported Icons 2:1383, ruggedEdge 2:1505, img 2:1638, pill 2:1664.

**Pages built** (📄 Pages, row y = 1300, 655 apart): P01 Cover 27:137, P02 Contents 28:137, P04 Logo family 29:161, P05 hierarchy + do/don't + clear space 33:219, P06 clear-space constructions 37:322, P07 minimum sizes + favicon 39:382. Sample page 7:44 and closing page 11:55 (Lime band) at y = 0.

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

## 6. Bilingual HTML, Copy SVG, ticket examples (Sep 2026)

`style-guide-draft.html` is now one file carrying both languages. Every text-bearing block exists twice as siblings — `<p lang="en">…</p><p lang="ru">…</p>` — and CSS on `html[data-lang]` hides the other language. Images, inline SVGs, swatches and hex values are not duplicated. A fixed EN/RU pill (top right, hidden in print) switches the language. Default = the system/browser language (`navigator.languages`, any `ru*` → RU, else EN) on every fresh visit; `?lang=ru|en` in the URL overrides it; a toggle click is remembered for that tab only (`sessionStorage`), so a new tab or a later visit goes back to the system language. Without JS the English layer shows.

- **Translations live in `tools/i18n/strings-ru.json`**, keyed by the whitespace-normalised English innerHTML of each text block (bs4 form: attributes sorted alphabetically, `&amp;` unescaped). Edit Russian text there, not in the HTML. When you add a new English block, add its key/value to the JSON; write anchor attributes in alphabetical order (`href rel style target`) so the key matches.
- **`python3 tools/i18n/inject.py`** (from the project root) rebuilds the bilingual file: it strips the previous injection, re-extracts the English leaves, and re-inserts the RU twins. Run it after any English edit in the HTML. It reports `STALE` for RU entries whose English no longer matches (re-key them in the JSON) and `MISS` for pattern failures (should not happen). Needs `beautifulsoup4` (present on the Mac); no Playwright for this step.
- `inject.py` also injects the **Copy SVG** buttons on the seven logo-gallery figures (a `<!-- COPY-SVG -->` block: serialises the inline `<svg>` with `xmlns`, strips `style`/`class`, copies to the clipboard; labels follow the language; hidden in print). Team-resource links (Yandex folders for logos/icons/photos/fonts, phosphoricons.com) are ordinary content in the HTML and in the JSON.
- **PDF:** see §4 — `--lang ru`.
- Icon rules in the HTML were corrected in the same pass (filled = default not absolute; social logos = official full-colour marks; veggie leaf dropped from the bespoke set) to match `design.md` §5.2.
- **Mobile shell (2026-09-04):** at ≤768px the page becomes an app-style guide — a home screen (Peppercorn cover + numbered list of the 10 sections, "Using this guide" linked from the cover) and one section per page, routed by `#hash` (`#logo`, `#color`, …, `#home`). Fixed top bar (← Home, number + title, the EN/RU pill) and bottom bar (Previous · Home · Next). Desktop and print are untouched. All of it lives in `tools/i18n/mobile-shell.html` (CSS + JS, bilingual strings inline as `lang` spans) and is inserted by `inject.py` as the `<!-- MOBILE-SHELL -->` block; section names/descriptions for the menu are the `S` array in that file — keep them in step with the section headings. Mobile content tightening (padding, tables scroll horizontally, type-scale rows wrap) is in the same block. Verified at 390px in both languages: no horizontal overflow on any section.
- **Ticket examples (Sep 2026):** § Motifs now has "The bartender's ticket — examples" (seven PNGs from `figmaScreenshotws/ticketExamples/` embedded base64 on their intended grounds, plus a live-CSS slip) and "Rugged edge — the recipe" (24/24/12 px geometry, the theme's `radial-gradient` CSS, pointer to `template-parts/components/rugged-edge.php`).

## 7. Open items

1. **Favicon clear space** — reconcile `favicon-spacing.svg` (¼h all sides) with `design.md` §4 line "Symbol & Favicon ¼h/½h". P05 text follows design.md, P06 construction follows the file. Owner: Etual.
2. **Rectangular logo** — Figma "rectangular" master is the bare 158×73 art (identical lockup to Stacked). The framed Rectangular with Lime ground (`rectangular.svg` 255×141, `rectangular-web.svg`) is to be re-uploaded and swapped into master 2:151 → then Logo / doc, Logo tile and P04/P06 update automatically. Owner: Etual (upload), then agent (swap).
3. Remaining guide sections in Figma, after rhythm approval on P04–P07: Brand essence, Colour, Typography, Motifs/Icons, Layout, Do & Don't, Photography, Notes, Team resources. Reuse the pattern above; keep Progress footer with correct Section/Page/Current.
4. Optional: Night/Day Theme collection in the website Figma file; code syntax for Mushroom/Soft Peppercorn there; Do/Don't tints in the HTML are slightly off-palette; stray `tools/_raw.pdf`, `tools/_variant-landscape-logo.pdf`, `sweet-pepper-style-guide-PREVIEW.pdf`, `tools/i18n/_old/`, `tools/i18n/__pycache__/` can be deleted (agent deletes are not permitted).
5. **Deal chip shadow** — the drinks-deal screenshot carries a Deep Chili offset shadow (right/bottom); the system says flat by default. Decide: sanctioned "stacked paper" device or drop it. Owner: Etual.
6. **RU print pagination** — optional orphan tuning for the Russian PDF (see §4).

## 8. Working agreements

- `design.md` wins. Don't invent rules; flag conflicts with a section reference.
- Etual is the author: critique drafts, offer options (including at least one that deliberately breaks a rule), don't replace judgment.
- Concise, direct. English is the source language of the guide; the Russian layer is maintained in `tools/i18n/strings-ru.json`, register-twin not literal. Voice examples use «твой».
- Periodically re-verify the numbers in `design.md` (contrast ratios, token math) instead of trusting the tables.

## 9. Publishing — git and hosting (handoff for Claude Code / Antigravity)

Target repository: **`github.com/conceptly/sweet-pepper-bar`** (exists, created by Etual). The `Sweet-Website` folder is **not yet a git repository** — no `.git` at the root and none inside `sweet-pepper-theme/`. Cowork sessions cannot push (no network from the Mac shell, and the cloud token is not bound to this repo), so this step runs in Claude Code or Antigravity on the Mac, where Etual's own GitHub credentials apply.

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

`git add -A && git commit -m "<what changed>" && git push`. For style-guide text changes follow §3's sequence first (English in HTML → `strings-ru.json` → `python3 tools/i18n/inject.py` → PDFs re-rendered), then commit the HTML, the JSON and both PDFs together so they never drift.

### 9.3 Hosting the guide on the bar's domain

Decision: the guide is a **static file outside WordPress**, not a WP page. Steps once the repo is up:

1. Copy `style-guide-draft.html` to the web root as **`/guide/index.html`** (rename on copy; the file is self-contained — fonts, logos, photos are inline, nothing else needs uploading). Deep links then work as `…/guide/#logo`, language as `…/guide/?lang=ru`.
2. The file already carries `<meta name="robots" content="noindex, nofollow">`, `theme-color` and an Apple web-app title, so it stays out of search and "Add to Home Screen" gives the team an app-like icon.
3. Optional, recommended for a public host: password-protect the folder with `.htaccess` basic auth (one shared team password is enough):
   ```
   AuthType Basic
   AuthName "Sweet Pepper — team guide"
   AuthUserFile /absolute/path/outside/webroot/.htpasswd
   Require valid-user
   ```
   Generate the file with `htpasswd -c .htpasswd team` (or an online htpasswd generator) and keep it outside the web root. Skip this if the host is nginx — use `auth_basic` in the server block instead.
4. Serve with `Content-Type: text/html; charset=utf-8` (default on any host) and, if the host allows, `gzip`/`brotli` for `.html` — the file compresses to roughly a third.
5. Keeping it current: after each `inject.py` run, re-copy the HTML to `/guide/index.html`. If the site is deployed from the repo by a script, add that copy to the deploy step so it is never forgotten.

Not done / open: choose a real URL and hosting path with Etual; decide whether the PDFs also go online (e.g. `/guide/en.pdf`, `/guide/ru.pdf`) — cheap to add, and the Yandex hub already carries them.
