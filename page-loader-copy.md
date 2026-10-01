# Page loader — copy (RU / EN)

The words of the screen a guest sees while the next page is slow (`website-brief.md` → Motion language → Page loader). **The source is `sweet-pepper-theme/data/page-loader.php`** — edit there; this file is the readable copy of it for review (tables generated from the data file, 30 Sep 2026). If the two ever disagree, the data file is what the site shows.

Voice: the bar is answering, so the lines speak as "we" (`design.md` §1.1 → status messages). RU and EN are register twins, not translations; RU lines are Claude's drafts unless marked as the team's — the author's pass is owed (`report.md` → Next Up 2).

## Fixed words

| Where | RU | EN |
|---|---|---|
| Molot label, while loading | Разогреваем! | Heating up! |
| Molot label, when the page is ready (fills letter by letter) | Подано! | Served! |
| First line, always (1.2 s) | кухня работает — не спешите | the kitchen’s on — no rush |
| Wordmark along the bottom | SWEET PEPPER BAR | AT SWEET PEPPER |
| Screen readers only | Загружаем страницу | Loading the page |
| Footer item that replays the loader (`ru_RU.l10n.php`) | Поддать жару! | Heat it up! |

## The pool — after the first line, one every 2.2 s, in random order

Characters in the last column (RU / EN). **One row needs up to ~35 characters** (measured on phones from 375px and on desktop: 34 RU / 40 EN fit; the 46-character «Пересолили. Готовим заново — придётся подождать» took two rows and made the slider jump). A **chain** (↳) always plays whole and in this order; in the data file a chain is a bracketed group. Keep RU and EN in the same order and shape — the language switch carries a line by its position.

| # | RU | EN | Chars |
|---|---|---|---|
| 1 | Ретикулируем перчики | Reticulating peppers | 20 / 20 |
| 2 | Уговариваем клюкву настояться | Convincing the cranberries to infuse | 29 / 36 |
| 3 | Даём настойкам подумать | Letting the infusions think it over | 23 / 35 |
| 4 | Прогреваем горшочки по-ярославски | Warming the pots for the pot roast | 33 / 34 |
| 5 | Договариваемся с медведем с герба | Negotiating with the Yaroslavl bear | 33 / 35 |
| 6 | Пересчитываем горошины в перечнице | Counting peppercorns in the shaker | 34 / 34 |
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

At 320px «Пересчитываем горошины в перечнице» (6) breaks in two even rows; «Считаем горошины в перечнице» would hold one.

**Adding a line:** add it to both the `lines` list and the `ru` → `lines` list in `data/page-loader.php`, at the same position; run the fit check (or look at `?loader=stay` on a phone) — then add the row here. *Considered, not built:* the lines as an admin list («Экран загрузки» on Bar Settings), worth it if the team keeps adding.
