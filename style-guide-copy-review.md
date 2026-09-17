# Style guide — editorial review, 9 September 2026

The first RU/EN copy pass is in `style-guide.html`. It covers the introduction, sections 01–09 and the separate mobile contents screen. The live page was read before editing; the author's «06 — Композиция» change was preserved and carried into the mobile contents. This is a local revision for review; the public page and PDF exports have not been updated.

## Editorial choices for the author's final pass

- Natural Russian instructions, with shorter English alongside them. The guide addresses a designer or teammate using «используйте / выбирайте»; guest-facing examples retain «твой».
- «Уютно / остро» remains the central idea. The proposed first-person brand introduction was not adopted; the existing guest-perspective rule remains.
- Consistent terms: «чек бармена», «фигурный край», «цветные плашки», «основной текст», «второстепенный текст», «общие файлы». Palette tokens, font names and asset filenames stay unchanged.
- Removed abstract metaphors and unsupported superlatives from rewritten prose. The opening no longer relies on an ageing “ten years” claim. The sample May poster now says “May holidays / Майские” instead of “Labour Day / День труда”.
- Removed the stale “five versions” count from the logo introduction. The six named version types remain, with the rectangular web variant shown separately.
- Corrected the image-overlay wording to «непрозрачность 33%». No overlay value or appearance changed.
- Simplified the colour-family explanation and omitted the ambiguous “12% vs 8% luminance” aside. This is not a new colour-math validation.
- Kept technical tables, dimensions, prices, links, assets, styling and interaction logic. Only the mobile navigation's displayed strings changed inside its script.

## Existing technical passages still needing a separate decision

These are not editorial approvals. The disputed instructions remain in the guide pending a system review.

1. **Logo clear space:** “≥ 1 unit” conflicts with the nearby ½ h / ¼ h instructions. `design.md` §4 contains the same inconsistency. Also distinguish favicon internal padding from external clear space; the process report already flags a construction/spec discrepancy.
2. **Chili on Lime:** the Deep Chili paragraph still says ordinary Chili is suitable for large headings on Lemon, Lime and Light Lime, while the contrast table rejects Chili on Lime. Reconcile against `design.md` §2.5.
3. **Accessibility claims:** the blanket “colour-blind safe” statement, contrast numbers and logo explanation have not been independently validated in this copy pass. Their wording should be revisited with the technical evidence rather than polished into stronger claims.
4. **Type exceptions:** `design.md` §3.3 already flags HomeHero's mobile sizing and the scope of Molot Captions. The guide still displays the existing values; this pass does not resolve those exceptions.

## Checks

- All 674 source language blocks retained in the same order; edit mode still opens and identifies all 674 blocks.
- Browser check: Russian mobile contents and brand section; EN/RU switching; desktop layout; manual-edit toolbar.
- Links, images, controls, inline SVGs and styles retain their original attributes/content. Mobile routing and editing logic unchanged.
- No live save or publication performed. PDF regeneration should follow the author's final text pass.

## Photo sync check

Source: `photos/menu-website/` → theme: `sweet-pepper-theme/assets/images/`.

- Missing theme copies: `sweet-space/light.jpg`, `sweet-space/logo.jpg`.
- Stale theme files: none (excluding `.DS_Store`).
- No files copied or removed; sync requires the author's confirmation under the project instructions.
