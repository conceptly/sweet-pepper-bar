# Visit — English copy review

*16 September 2026 · Proposals for author review · No website or Figma changes.*

Working texts: [EN](visit-page-copy-en.md) · [RU draft](visit-page-copy-ru-draft.md). The existing [copy and strategy document](visit-page-copy.md) retains component decisions and historical explorations.

## Sources and limits

Read the current Visit templates (`hero.php`, `location.php`, `cta.php`), `page-visit.php` structure, `visit-hero.js`, relevant contact-state and map code, `visit-page-copy.md`, `website-brief.md` and `design.md`. Visually inspected the saved `figmaScreenshotws/visit/visit-page.png`.

The supplied [Figma frame](https://www.figma.com/design/P7jYklzRIIFP8yGawnZPia/Sweet-Pepper-Website?node-id=892-31050) opened in an in-app browser, but its canvas could not be inspected; native Figma access returned “Computer Use permissions are not granted.” The local Visit URL was unreachable. This review compares current source with the saved design, not a freshly rendered page or verified current Figma text layers. Mobile observations come from source and documented decisions; proposed copy has not been fit-tested.

The saved design is visibly older: FIND YOUR ROUTE / LEAVE YOUR WORD and a single map differ from the current YOUR ROUTE TO PEPPER / DROP A LITTLE NOTE and route badges. Use the latter for this pass. Do not restore retired sections, the footer ticket or old day/night headline swaps.

## Editorial direction

Keep the three-section journey: status, hours and contact → getting here → feedback. Visit should answer practical questions, leaving the origin story and kitchen/bar positioning to Home and About. Exact opening and last-order times are appropriate here under `website-brief.md` → The no-clock rule; no countdown is needed.

Carry forward the canonical **Kirova 10/25**, the undecided email mailbox/domain, and the intentional social/event placeholders. Form, reservation, phone-status and copyable-request wording remains on hold. No new promises about reply times, parking availability, age restrictions or access facilities.

## 1. Hero

**Keep JOIN THE PARTY.** It has character and is the current fixed-page headline. It need not change with the clock or imply a scheduled event. The accompanying text should make daytime visits equally welcome.

**PROUDLY LOCAL FROM 2014 → PROUDLY LOCAL SINCE {confirmed year}.** “Since” is the natural construction. Keep the year in the existing final-review queue; don't infer it from the repeated 2014 defaults.

Replace the “one of the only places” paragraph and “night sets” promise with:

> Lunch on Kirova, a drink after a walk, or an evening with friends. Check the hours, choose your route and make yourself comfortable.

This supplies the page's purpose without another positioning claim or a suggestion that DJ sets happen every night.

## 2. Status and hours

**PARTY HOURS → OPENING HOURS.** This table includes breakfast-time opening, so the plain label is more useful. Preserve the visible Mon–Sat 08:30–02:00 / Sunday 10:00–02:00 schedule as current source data, pending the existing final check and any holiday exceptions.

| Surface | Current | Working proposal |
|---|---|---|
| Open lead | Good News! | GOOD NEWS! — keep |
| Kitchen last-orders lead | still can get it! | STILL TIME TO EAT |
| Snacks-only lead | late bar mode | SOMETHING TO NIBBLE |
| Bar winding-down lead | last drink! | WINDING DOWN |
| Closed lead | see you tmrw! | SEE YOU SOON |
| Bar open | bar's open | Bar's open — keep |
| Bar closing | bar's wrapping up | Bar's winding down |
| Bar closed | bar's closed | Bar's closed — keep |
| Kitchen open | kitchen's on | Kitchen's on — keep |
| Kitchen last orders | kitchen last orders | Kitchen last orders — keep |
| Snacks only | bar snacks only | Bar snacks only — keep |
| Kitchen closed | kitchen's closed | Kitchen's closed — keep |

For the generic winding-down state use **WINDING DOWN** in the clean draft; LAST CALL needs its own confirmed service meaning. The lead is desktop-only; the mobile rail keeps the two actual states. Do not add another text layer to the phone rail.

**The state labels cannot resolve the conflicting schedule:**

- The hours card says Sunday opens at 10:00. `visit-hero.js` uses 08:30 every day, so it reports open on Sunday between 08:30 and 10:00. The separate contact-state code does account for Sunday. One guest can therefore see two different answers.
- The Visit engine marks kitchen last orders from 22:00, snacks only at 01:00, closed at 01:30. The strategy notes say kitchen service until 01:30 and last orders at 01:00. Preserve the distinction between *accepting an order* and *finishing service*; don't advertise the full menu until 01:30 if ordering ends earlier.
- “See you tomorrow” is wrong after 02:00 when the next opening is later that same day. “See you soon” avoids that error; a precise “Back at {next opening}” can be used once the shared schedule is authoritative.
- The test override for snacks-only uses an open bar, while the scheduled snacks-only interval has the bar winding down. Don't use override previews as proof of the production state matrix.

These are final implementation checks, not edits made in this copy pass.

### The event slot

“Friday Cocktail Hour / Starts on Friday, lasts all weekend!” is a placeholder, not a confirmed event. Do not invent its replacement.

For the documented evergreen version, propose **WHAT'S ON** with **News, parties and specials — on social.** The exit becomes **See what's new**, which doesn't imply something is happening right now. A real event can instead use its supplied title, date and time. This is an editorial candidate for the existing slot, not a new feed or a change to social routing.

## 3. Contact card

Keep **GET IN TOUCH**. Shorten the repeated hints rather than adding a verb to every mobile row; the glyph-only mobile treatment was deliberate.

| Item | Proposal |
|---|---|
| Book or Feedback | TABLES & QUESTIONS — page-label candidate for the later booking-copy pass; held out of the clean draft |
| Phone hint | Leave current wording for the agreed phone/booking pass |
| VK “fastest reply — usually minutes” | Remove the unconfirmed speed claim at final contact review; do not replace it with a different SLA |
| Instagram “DM & latest updates” | Omit the hint; the account and icon already identify the channel |
| EVERYTHING ELSE | EMAIL |
| Email hint | Feedback, ideas, partnerships. |
| FIND SWEET | YOUR WAY HERE |
| Address hint | On Kirova's pedestrian street. |
| Desktop map jump | Directions — keep |

“2 min from Sovetskaya square” conflicts with the route badge's “350 m · 5 min.” Replace the estimate in the contact card with useful orientation; measure the route separately before approving the badge.

**Contact facts remain unresolved:** displayed Instagram handle and target account differ; the hero's VK account differs from the booking block's; the hard-coded `hello@…` mailbox is not an approved choice. Preserve these as checks, not guesses. A “Message” label must lead to messaging; the current hero VK link is a profile. Phone/mobile calling and desktop copying remain contextual, as previously agreed.

## 4. Getting here

**FIND THE PEPPER → YOUR DESTINATION.** This matches the About location section without repeating the full route connector.

**AT THE VERY HEART OF THE BEST CITY → IN THE VERY HEART OF THE BEST CITY.** Carry the author's selected wording across pages. Preserve “very,” “best city” and the Russian **«В самом сердце любимого города»**.

Keep **GOOD TO KNOW**. Proposed slip:

> Kirova is pedestrian-only.
> The last part of the journey is on foot.

This is more useful than “park nearby and come in!” while parking guidance is still being prepared. It doesn't promise a space or a particular legal parking location. Add actual approach guidance only after the author supplies it.

### Route badges

Keep the short **The door** in the built component. “Just show me the door” from the frame is playful but competes with the badge's small footprint. If revisited, treat it as a label-length choice, not a grammar correction.

Use consistent proper-name capitalisation: **Znamenskaya Tower · Sovetskaya Square · Strelka · Bogoyavlenskaya Square · Nearest bus stop**. “Nearest” is a small, natural improvement over “Closest.” A full place name can be supplied as an accessible label if the visible badge must abbreviate Square to Sq.

- Door hint: **Kirova 10/25**.
- Strelka hint: **Where the rivers meet** — retain as orientation, subject to the route check.
- **Author follow-up, 16 September:** keep the existing Znamenskaya Tower hint **Towards Pervomaiskaya** / **В сторону Первомайской**. The earlier recommendation to omit it is withdrawn.
- **Sovetskaya Square — working hint from the author's direction:** **Across Andropova, past the fountains** / **Через Андропова, мимо фонтанов**. This is the shorter option for the badge. The author also supplied the regional government building as a landmark; a longer alternative is **Across Andropova, behind the regional government building** / **Через Андропова, за зданием областного правительства**. Keep the full institutional name out of the compact hint unless testing shows it is needed. These are author-supplied directions, not independently measured routes.
- “and the old Kremlin” is incomplete and doesn't explain how to reach the bar. Omit rather than inventing a sightseeing description.
- Keep distance/time fields pending measurement. Existing source values are 350 m / 5 min for both Znamenskaya and Sovetskaya, 1.3 km / 16 min for Strelka, 900 m / 12 min for Bogoyavlenskaya. They are not newly verified here. The bus stop is a temporary replacement for the unresolved parking slot.

**Map actions:** keep compact **Copy · Yandex · Google** on mobile. Use accessible **Copy address**, with **Address copied** feedback. The clipboard value must be **Ярославль, ул. Кирова, 10/25** in both locales under the existing taxi-address decision. The current map button still copies `Кирова 10, Ярославль`; display and copy payload must be reconciled later.

The route badges currently switch Google maps only; the Yandex path returns without changing the map. Russian copy must not promise working route selection until this is resolved. The clean RU therefore includes route labels but no “tap to build your route” instruction. Map providers and routing are outside this wording pass.

The old prose about the church and convent isn't in the current layout; don't add it back. Likewise, Wi-Fi, kids and terrace belong on About. A short entrance note can be added to Visit if needed, using the selected *Step-free* meaning, but no extra slip is introduced here.

## 5. Feedback section

Keep the existing **WE'RE ALL EARS** as the personality-led working choice, with the rule exception discussed below. Its content should be about feedback rather than reintroducing bookings:

> Something to share about your visit, an idea or a question? Leave a note for the team.

This avoids “a real person answers either way” beside a menu link and doesn't suggest that this is the booking form. It is the outer section paragraph only. The mobile booking redirect, topic chips, form title/helper/fields/success/errors and response promises are on hold. Do not insert the earlier “same day,” director-reading or 24-hour claims as approved text.

**See the menu** stays. **More about Sweet → More about Sweet Pepper** uses the full name consistently. Shorter button candidate if required by fit: **About Sweet Pepper**.

Keep the entrance photo. Proposed meaningful alt text: **Sweet Pepper entrance, with the pepper logo on the door**. The saved photo supports that description. The phone band is currently marked decorative; do not imply a new accessibility implementation through this copy document.

## Connectors

Keep the current **YOUR ROUTE TO PEPPER / DROP A LITTLE NOTE**. Each introduces the section below. Russian proposals: **ВАШ МАРШРУТ В SWEET PEPPER / ПАРА СЛОВ ОТ ВАС**. These need visual fit checks; they are not approved SVG replacements.

## The deliberately rule-breaking option

**Keep WE'RE ALL EARS.** It already breaks `design.md` §1.1: a normal heading speaks as the venue outside ticket replies or status bands. Here I think the phrase earns a narrow exception: this section is explicitly the team listening, and the idiom is warm without promising a reply time. Document a feedback-invitation exception if the author chooses to retain it; this review does not silently amend the rule.

The rule-compliant alternative is **A WORD WITH THE TEAM**. It is clear, but loses some of the existing warmth. Russian can keep the invitation naturally as **ЕСТЬ ЧТО СКАЗАТЬ?**, without adopting first-person house voice.

## Final-review queue

Confirm the schedule and last-order meanings once; reconcile their engines. Confirm the founding year, contact identities, parking, routes and bus stop. Check longer EN/RU labels in the actual mobile components. Forms and booking wording remain deferred. No fresh factual claims about policies, map distances or contact response times are approved here.

Photo inventory checked: source files `sweet-space/light.jpg` and `sweet-space/logo.jpg` are missing from the theme; no stale or differing matching files. The entrance photo exists in both. No photo sync performed.
