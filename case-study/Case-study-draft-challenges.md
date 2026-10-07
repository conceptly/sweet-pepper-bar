# Sweet Pepper: Case Study Plan (Challenge & Pivot)
*Target: Canadian Market (Emphasis on Systems, Bilingual Architecture, and Privacy)*

## 1. The Hook (TL;DR & The Output)
*Start with the delicious finished product and the business reality.*
* **The Problem:** 1 venue, 4 distinct daily identities (breakfast, lunch, bar, club), and a 50/50 food/drink revenue split.
* **The Constraints:** A bilingual audience and complex privacy/data laws requiring custom consent UI.
* **The Output:** A 30-second looping video/GIF of the day-to-night transition, the responsive grid, and the live site.

## 2. Challenge A: The "No-Clock" Hospitality Rule (UX & Iteration)
*Show them you understand users and are willing to kill your darlings.*
* **The Concept:** Hospitality dictates guests shouldn't think about time. So, how do you show 4 dayparts without a clock?
* **The Pivot:** Show the 6 AI-generated "Heat = Time" spice sliders. Then, explain how **usability testing killed it**. It was too complex.
* **The Solution:** The resilient 4-tile photo grid. You kept the slider as a delightful "page loader" Easter egg, proving you balance usability with brand joy.

## 3. Challenge B: The Bilingual Architecture
*This is where you win the Canadian hiring manager. Connect RU/EN directly to how you would handle EN/FR.*
* **The Rule:** "Register Twins, not translations." Explain how you designed the system to accommodate different language lengths, rhythms, and tones without breaking the UI.
* **The Implementation:** One document, two languages rendered server-side. No lazy auto-translate plugins. Show the UI adapting seamlessly between English and Russian, proving you know how to build UI components that survive bilingual expansion.

## 4. Challenge C: The Accessibility Audit (AODA/WCAG Readiness)
*Canada has strict accessibility laws. Show them you audit your own work.*
* **The Problem:** The brand was loud (reds, greens, yellows). Initial checks assumed it was "colour-blind safe."
* **The Audit:** You recomputed the contrast ratios manually and found the claim was false under protanopia.
* **The Solution:** The new rule: *"No color carries meaning alone."* Show how you separated state changes into outlines and fills, rather than just color swaps. This proves deep systems maturity.

## 5. Challenge D: The Privacy & Consent UX
*Turn legal constraints into good design. Show modern AI workflows.*
* **The Problem:** Legal requirements (cookie banners, privacy policies) usually ruin the visual experience and frustrate users.
* **The AI Workflow:** Explain how you used an AI agent to rapid-prototype the complex logic of dual-consent (Analytics vs. Maps) to quickly solve the "blank page" problem.
* **The Human Polish:** Show the Figma frames. Explain how you applied Gestalt principles (proximity) and strict brand rules (typography hierarchy, Lime focus states, 6-second success timers) to make the consent dialog feel native and premium.
* **The Result:** A fully compliant, accessible privacy hub that users can actually navigate.

## 6. Reflection: The Browser as the Drawing Board
*Close with how you work.*
* Explain your philosophy of moving out of Figma and into the browser for final decisions.
* Highlight the `testing.md` log—show that you record your assumptions, predictions, and failures in daylight.
