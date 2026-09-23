# Sweet Pepper — Testing & Validation Log

*Working doc · tracks usability/A-B testing across the project — both what's been run and what's still queued. Full design rationale stays where the decision lives (`design.md`, `website-brief.md`, the case study); this doc is the index so a test doesn't get stranded inside whatever section prompted it.*

**When a new "should we test X" moment comes up mid-decision:** log it below first, then reference it inline (`*(open test — see testing.md)*`) instead of writing the plan into the surrounding section.

---

## Open — planned, not yet run

| Question | Affects | Plan | Prediction on record |
|---|---|---|---|
| Bar Settings → hours: can a manager change an opening time and read the four fields without help — and does "a time after midnight is the end of the same night" land? | Platform → *Bar hours settings* (`website-brief.md`) | With the **Editor** role on the test site: "on Friday we close at 4 — set it", then "put it back". Watch for the closing-time fields; note any value the sanity fallback had to catch. Run before the holiday repeater is built, so its form learns from it. | The opening fields are fine; the two closing fields are where a slip happens. |
| Drop the "Home" nav label and let the interactive logo alone serve as the home link? | Top nav (`website-brief.md`) | Two measures, separately: (1) home-return success from deep pages, label vs. no label; (2) logo-interaction discovery, label on/off × idle-shake on/off | Idle-shake moves discovery more than removing Home does, at zero nav cost — if it holds, keep both |
| "Bar Snacks" vs. "To Share" vs. "Snacks & Boards" | Menu page → Section labels 🔶 (`website-brief.md`) | Run a "find the cheese plate" task, then decide and propagate in one pass: nav, `menu-hero-copy.md`, `menu-en.md`, RU pairing | — |
| ~~Scroll-down link under the mobile contact card: one bundled line ("Map, city sights & contact form ↓") vs. a directions-only link with the form reached by scrolling~~ **Closed Sep 2026 — the link was dropped when the hero-foot connector landed (a second device announcing the same section); nothing left to test** | Visit page → Mobile layout (`visit-page-copy.md`) | Two variants, same task set: (1) "find the map", (2) "write to the bar about a lost jacket". Watch whether the bundled line's three nouns create an expectation the landing section doesn't meet, and whether variant B's guests still reach the form | Author's prediction on record: the bundled line won't confuse — the page is short and the words run in the same order as the sections below, so it reads as a preview of the rest of the page rather than a single anchor |
| Mobile status rail: running Lime band vs. static one-line band | Visit page → Mobile layout (`visit-page-copy.md`) | Interrupt-style task — show the page mid-loop and ask "can you eat right now?". The failure mode to catch is a guest reading only one of the two states. Fallback copy is already drafted (five one-line states) | Prior evidence points the other way twice (menu hero, ticker jump-nav both lost to static layouts) — so this is a genuine test, not a confirmation |

---

## Decided — validated

| Question | Method | Result | Full rationale |
|---|---|---|---|
| Hero layout: side-nav poster vs. carousel/ticker vs. split-screen | Stakeholder A/B + usability testing, KPI = time-to-dish | Side-nav poster (concept B) won — cleaner, easier to navigate, clearer interactions, less information-heavy | `website-brief.md` → Menu page → Hero; case study "The menu page: tested, not guessed" |
| Soups: own section, or filed under Hot dishes? | Usability task (Jul 2026) | Participants *could* find soups under Hot dishes but agreed it doesn't belong there — kept as its own web section (print still files it under hot dishes; accepted web↔print divergence) | `website-brief.md` → Menu page → Section labels |
| Seasonal: own nav section, or a tag? | Historical print performance (not a live usability test — years of separate seasonal print pieces vs. integrated dishes) | Seasonal is a tag, not a section; surfaced via a "Seasonal now" rail | `website-brief.md` → Seasonal & specials |
| Menu storage: a repeater per section (А) vs. `dish` posts placed by Relationship lists (Б) — which admin screen does the team find easier? | Usability test, two participants, on the test site (Sep 2026); first look 20 Sep (team fine with either, price is the most frequent edit) | **Б, 23 Sep 2026 — both participants.** Harder to mix up dishes in Б's table; they change price / size, sometimes the description, rarely the layout, and would rather search than open a section, scroll and read А's nested repeater (fields without hierarchy). Both said А could work. Prediction on record (repeater wins the batch reprice) was not borne out. Small sample, accepted for a reversible choice; А archived | `website-brief.md` → Content editing → *Menu storage* |
| Spice-slider mechanic: which interaction metaphor | AI-prototyped 6 divergent variants, sorted against brand/hospitality rules (not user-tested — a design-side usability screen) | Kept: the label transition (solid→chili→outline), the now-marker. Rejected on principle: the hour ruler (reintroduces a literal clock). Parked: matchstick gradient (off-palette), status card (undercuts "one control, three jobs"). Proportional real-hours segments flagged as a candidate for next iteration | case study "AI-assisted exploration: six ways to feel the heat" |

---

*Evidence-type note: "usability testing" above means actual participants; the seasonal and slider rows are decisions backed by other evidence (performance data, internal rule-sorting) and are labelled as such rather than dressed up as user tests.*
