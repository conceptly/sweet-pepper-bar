# Page loader — copy (RU / EN)

The words of the screen a guest sees while the next page is slow (`website-brief.md` → Motion language → Page loader). **The source is `sweet-pepper-theme/data/page-loader.php`** — edit there; this file is the readable copy of it for review (tables generated from the data file, 30 Sep 2026). If the two ever disagree, the data file is what the site shows.

Voice: the bar is answering, so the lines speak as "we" (`design.md` §1.1 → status messages). RU and EN are register twins, not translations; RU lines are Claude's drafts unless marked as the team's — the author's pass is owed (`report.md` → Next Up 2).

## Fixed words

| Where | RU | EN |
|---|---|---|
| Molot label, while loading | Разогреваем! | Heating up! |
| Molot label, when the page is ready (fills letter by letter) | Подано! | Served! |
| The bar’s name under the slider — the same in both languages since 1 Oct 2026 (was SWEET PEPPER BAR / AT SWEET PEPPER along the bottom). Phones held upright add BAR: SWEET / PEPPER / BAR | SWEET PEPPER | SWEET PEPPER |
| Screen readers only | Загружаем страницу | Loading the page |
| Footer item that replays the loader (`ru_RU.l10n.php`) | Поддать жару! | Heat it up! |

## The pool — in random order; a run opens on its first line for 1.2 s, then one every 2.2 s

*No fixed opener since 30 Sep 2026 (author): «кухня работает — не спешите» / "the kitchen’s on — no rush" showed while the kitchen was closed.*

Characters in the last column (RU / EN). **One row needs up to ~35 characters** (measured on phones from 375px and on desktop: 34 RU / 40 EN fit; the 46-character «Пересолили. Готовим заново — придётся подождать» took two rows and made the slider jump). A **chain** (↳) always plays whole and in this order; in the data file a chain is a bracketed group. Keep RU and EN in the same order and shape — the language switch carries a line by its position.

| # | RU | EN | Chars |
|---|---|---|---|
| 1 | Ретикулируем перчики | Reticulating peppers | 20 / 20 |
| 2 | Уговариваем клюкву настояться | Convincing the cranberries to infuse | 29 / 36 |
| 3 | Даём настойкам подумать | Letting the infusions think it over | 23 / 35 |
| 4 | Прогреваем горшочки по-ярославски | Warming the pots for the pot roast | 33 / 34 |
| 5 | Договариваемся с медведем с герба | Negotiating with the Yaroslavl bear | 33 / 35 |
| 6 | Считаем горошины в перечнице | Counting peppercorns in the shaker | 28 / 34 |
| 7 | Успокаиваем крылышки | Reassuring the chicken wings | 20 / 28 |
| 8 | Натираем бокалы до скрипа | Polishing the glasses twice | 25 / 27 |
| 9 | Солим по вкусу. Пробуем. Солим ещё | Salting to taste. Tasting. Salting again | 34 / 40 |
| 10 | ↳ Пересолили. Готовим заново *(team)* | ↳ Oversalted. Starting over | 26 / 25 |
| 11 | ↳ Придётся немного подождать *(team)* | ↳ This may take a little longer | 26 / 29 |
| 12 | Вежливо просим шефа | Asking the chef nicely | 19 / 22 |
| 13 | Репетируем «вам как обычно?» | Rehearsing “the usual?” | 28 / 23 |
| 14 | Прибавляем огоньку | Turning the heat up a notch | 18 / 27 |
| 15 | Не трогаем термостат с 2009 года | Ignoring the thermostat since 2009 | 32 / 34 |
| 16 | Будим бармена с бодуна *(team)* | Waking the hungover bartender | 22 / 29 |

**Line 6 was «Пересчитываем горошины в перечнице» until 1 Oct 2026** — the only line in two rows on a 390–393px phone (author's iPhone), shortened to «Считаем горошины в перечнице».

**Why lines wrap sooner than the first check said (1 Oct 2026):** the loader's side padding grew from 16 to 32px, so a phone's column is its width less 64 — 296px at 360, 311 at 375, 326 at 390, 329 at 393, 338 at 402 — and a line needs its text plus 20px for the flame. Measured (Golos 16):

| Still in two rows | Needs | On phones |
|---|---|---|
| Прогреваем горшочки по-ярославски (4) | 320px | 375 and narrower |
| Договариваемся с медведем с герба (5) | 310px | 375 and narrower |
| Солим по вкусу. Пробуем. Солим ещё (9, the team's) | 316px | 375 and narrower |
| Salting to taste. Tasting. Salting again (9) | 312px | 375 and narrower |
| Convincing the cranberries to infuse (2) | 298px | 360 and narrower |
| Counting peppercorns in the shaker (6) | 295px | 360 and narrower |

From 390 up every line, Russian and English, holds one row. A second row no longer moves the slider (the words sit above it and grow upward), so this is looks only. Shorter candidates if 375px phones matter: «Греем горшочки по-ярославски» (270px), «Торгуемся с медведем с герба» (260px), «Солим. Пробуем. Солим ещё» (246px, the team's to decide), "Salting. Tasting. Salting again" (249px).

**Adding a line:** add it to both the `lines` list and the `ru` → `lines` list in `data/page-loader.php`, at the same position; run the fit check (or look at `?loader=stay` on a phone) — then add the row here. *Considered, not built:* the lines as an admin list («Экран загрузки» on Bar Settings), worth it if the team keeps adding.
