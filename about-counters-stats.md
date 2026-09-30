# About → Counter ledger — the bar's sales figures

> **Received:** 29 September 2026, from the bar manager (via the author).
> **Next refresh:** around September 2027 — ask the manager for the same list (how: the end of this file).
> **Used by:** About → The Pepper Story → counter ledger (`about-page-copy.md` → Counter ledger, `about-page-copy-ru-draft.md` → Счётчик заказов). Live values live in WordPress: About page → «История» tab → counters repeater; `sweet-pepper-theme/data/about/story.php` is only the fallback and seed.

## 29 September 2026

### As received (verbatim)

| # | Manager's name | Figure | Note from the author |
|---|---|---:|---|
| 1 | Капучино | 66 768 | |
| 2 | Тыквенный суп | 37 944 | |
| 3 | Настойка черносмородиновая | 101 583 | 40 ml pieces (shots) |
| 4 | Жаркое в горшочке по-ярославски | 53 152 | |
| 5 | Кобб салат | 41 440 | |
| 6 | Блины | 35 700 portions | ≈ 89 250 pancakes («примерно») — the site shows pieces |
| 7 | Ягодный коржик | 6 050 | |
| 8 | Сицилийский салат | 14 820 | |
| 9 | Латте | 32 772 | |
| 10 | Брокколи | 10 992 | |
| 11 | Цветная капуста | 31 896 | |
| 12 | Кесадилья | 74 736 | |
| 13 | B-52 | 11 352 | |
| 14 | Лонг Айленд | 24 204 | |
| 15 | Воин Дракона | 23 672 | On the menu only 3.5 years; the bar's most popular cocktail |

Total: 15 figures. The three placeholders they replace (128 400 cappuccinos · 41 200 pumpkin soups · 96 700 «Солёная карамель» shots) were never real numbers — retire them everywhere.

### Menu names (for labels)

| # | `menu.md` | `menu-en.md` |
|---|---|---|
| 3 | Легендарная Смородина (настойки) | Legendary Blackcurrant |
| 4 | Жаркое по-ярославски / Жаркое в горшочке — one dish, named by season | Yaroslavl-style roast |
| 6 | Блины | Pancakes (blini) |
| 7 | Ягодный Коржик | Berry korzhik |
| 8 | Сицилийский — с цыпленком, апельсинами и рукколой | Sicilian salad |
| 10 | Фирменная Брокколи / Брокколи в сухарях | Signature broccoli |
| 11 | Цветная капуста с чили и медом | Cauliflower with chili & honey |
| 14 | Лонг Айленд Айс Ти | Long Island Iced Tea |
| 15 | Воин Дракона | Dragon Warrior |

### Russian forms

The first draft agreed each label with its own number (32 772 чашки латте, 24 204 Лонг Айленда). The author chose colloquial forms instead, on purpose — the Labels table below is final. A label no longer needs re-checking when its figure changes.

### Answers (29 September 2026)

1. **Period.** The manager says twelve years; the author reads it as roughly eight — the bar moved from 1C to iiko around 2018 and older figures are unlikely to have survived. **The heading keeps TWELVE YEARS / ДВЕНАДЦАТЬ ЛЕТ** — it is the bar's age, and the ledger is an interaction, not a report.
2. **Blackcurrant infusion.** Pieces of 40 ml — the manager's words: «в штуках по 40мл, Я пересчитал все на штуки». Label it as shots / стопки.
3. **Pancakes.** Pieces — ≈ 89 250 блинов. Playful, not a tax form; no «Kitchen estimates» qualifier for this one.
4. **Lunch portions** are included in the totals; the kids' menu is not (and doesn't need to be).

### The heading's age — automatic

The bar's birthday is **14 January 2014**. The heading's «ДВЕНАДЦАТЬ ЛЕТ» / TWELVE YEARS turns into THIRTEEN on 14 January 2027 by itself (`SWEET_PEPPER_BIRTHDAY` in `inc/about-data.php`); leave the admin text as it is. The home page's "12 years" chip follows the same date.

### Labels (on the site since 29 Sep 2026 — «История» repeater; `data/about/story.php` is the fallback)

Typed in lower case; the site shows them in sentence case (30 Sep 2026). One line each at 375 px and on desktop — at Caption 13, and at Body 16 (30 Sep 2026) after five shorter names (`tools/field-updates/2026-09-30-about-counters-short-labels.json`) — «жаркого в горшочке» is the same dish as «по-ярославски», English keeps "Yaroslavl roasts". On 30 Sep 2026 three RU labels lost «порции / порций» («медовой капусты» is the guests' own name for the dish) and "berry korzhiks" became "berry pastries" (English readers don't know the korzhik) (`tools/field-updates/2026-09-30-about-counters-ru-labels.json`). Russian column edited by the author, 29 Sep 2026 — the colloquial forms are deliberate («чёрной смородины», «жаркого в горшочке» count shots and portions without saying so).

| Figure | EN | RU |
|---:|---|---|
| 66 768 | cappuccinos | чашек капучино |
| 37 944 | pumpkin soups | тыквенных супов |
| 101 583 | blackcurrant shots | чёрной смородины |
| 53 152 | Yaroslavl roasts | жаркого в горшочке |
| 41 440 | Cobb salads | кобб салатов |
| 89 250 | pancakes | блинчиков |
| 6 050 | berry pastries | ягодных коржиков |
| 14 820 | Sicilian salads | сицилийских салатов |
| 32 772 | lattes | чашек латте |
| 10 992 | crispy broccoli | брокколи в сухарях |
| 31 896 | honey cauliflower | медовой капусты |
| 74 736 | quesadillas | кесадилий |
| 11 352 | B-52 shots | шота B-52 |
| 24 204 | Long Islands | Лонг Айлендов |
| 23 672 | Dragon Warriors | Воинов Дракона |

### Direction (author, 29 Sep 2026)

All 15 go into the pool to show the gastrobar's range — food and drinks together, **not** tied to the time of day. Three prototypes tried; **built: the odometer roll**, random order, one slot every 4 s and on hover (a tap on phones). Details: `website-brief.md` → The Pepper Story.

### Next refresh — how

1. Add a new dated section above this one with the manager's list.
2. Edit the rows in admin (About → «История» → Счётчик заказов), or write a `tools/field-updates/` file with a "rows" group (old rows → new rows) and run it on each site.
3. Keep every label to one line on a 375 px phone.
