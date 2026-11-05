<a href="https://sweetpepper.bar/en/"><img src=".github/readme/sweet-pepper-laptop.jpg" width="100%" alt="The Sweet Pepper website at night on a laptop in a café: “Ready for tonight?” above photos of dishes"></a>

# Sweet Pepper

The brand and website system for Sweet Pepper, a gastrobar in Yaroslavl open from breakfast to late-night cocktails. The site follows the guest’s time of day, from a mild breakfast to a late-night party. This repo holds the website, the system and the live style guide behind it. The [case study](https://www.conceptly.design/case/sweet-pepper) has the full story.

[Live site](https://sweetpepper.bar/en/) · [Style guide](https://sweetpepper.bar/style-guide.html) · [Case study](https://www.conceptly.design/case/sweet-pepper)

## The system

| Ramp | Tokens |
|---|---|
| Red · Chili | ![Paprika #EF6D44](https://img.shields.io/badge/Paprika%20%23EF6D44-EF6D44?style=flat) ![Chili #E34314](https://img.shields.io/badge/Chili%20%23E34314-E34314?style=flat) ![Deep Chili #9B2705](https://img.shields.io/badge/Deep%20Chili%20%239B2705-9B2705?style=flat) |
| Green · Lime | ![Light Lime #D4E671](https://img.shields.io/badge/Light%20Lime%20%23D4E671-D4E671?style=flat) ![Lime #C1DB34](https://img.shields.io/badge/Lime%20%23C1DB34-C1DB34?style=flat) ![Avocado #869438](https://img.shields.io/badge/Avocado%20%23869438-869438?style=flat) ![Olive #737D3A](https://img.shields.io/badge/Olive%20%23737D3A-737D3A?style=flat) ![Deep Olive #626B31](https://img.shields.io/badge/Deep%20Olive%20%23626B31-626B31?style=flat) |
| Yellow · Lemon | ![Lemon #FFED00](https://img.shields.io/badge/Lemon%20%23FFED00-FFED00?style=flat) ![Cream #FFF689](https://img.shields.io/badge/Cream%20%23FFF689-FFF689?style=flat) |
| Neutrals | ![Peppercorn #151317](https://img.shields.io/badge/Peppercorn%20%23151317-151317?style=flat) ![Parchment #F3E9D2](https://img.shields.io/badge/Parchment%20%23F3E9D2-F3E9D2?style=flat) ![Paper #FCF7E8](https://img.shields.io/badge/Paper%20%23FCF7E8-FCF7E8?style=flat) |

- **Type:** Molot for short all-caps headlines; Golos Text for body, menus and UI.
- **Spacing:** edges, gaps and icon sizes in multiples of 4px.
- **Day and night:** a light kitchen mode and a dark bar mode, with contrast checked in both.
- **Photography:** shot in the bar, warm directional light, shallow depth of field.

## The live style guide

**`style-guide.html`** is the guide the team opens on their phones, in English and Russian. Add `?edit` to the URL and every text block becomes editable; Save commits the change to this repo through the GitHub API, and the server picks it up within minutes. Layout, swatches and logos stay locked.

## What’s in this repo

```
sweet-pepper-theme/  the WordPress theme: PHP templates, SCF fields, Vite build
design.md            the system spec: tokens and rules, every change dated
website-brief.md     website decisions: day and night, page loader, pages
style-guide.html     the live style guide (EN/RU)
style-guide-edit.js  in-page edit mode, saved by style-guide-save.php
design/              colour, fonts, icons, logos
team-docs/           design guide for the team (EN/RU)
tools/               PDF renderer and translations
```

## How it was made

I was the bar’s graphic designer for years; in 2026 the owner came back for a website. I rebuilt the brand system first, designed the site in Figma and built it with an AI coding assistant. `design.md` is the record every session starts from: 42 commits and 10,000 words since September, each change dated and explained.

---

<sub>© Etual Fomina and Sweet Pepper. The logo, photos and texts are not for reuse.</sub>
