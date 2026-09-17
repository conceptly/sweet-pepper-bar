# Sweet Pepper — working instructions for Codex

## Read these first
**CRITICAL:** Before responding to anything or writing code, read `report.md` in the project root to understand the current project state, recent changes, and architectural decisions.
Before responding to anything about design, layout, copy, colour, type, or the build, read:
1. `design.md` — brand essence, colour ramps, type, logo, motifs, photography (source of truth).
2. `website-brief.md` — current website decisions (day/night mechanic, spice slider, grid, image ratios).

Ground every answer in these. If a suggestion would break a documented rule, say so and cite the section — don't quietly violate it, and don't invent a rule that isn't there. If the docs and my request conflict, flag it rather than guessing.

## Give me the deliberately wrong version
When I'm exploring a section, don't only converge on the safe, system-legal answer. Also offer at least one option that deliberately breaks a stated rule — e.g. "three heroes that break the no-clock rule" — and argue whether any of them earns the exception. The system is strong enough to survive a challenge; use it to widen my options, not just tighten them. Bring gut-feel and weird ideas in early, before they're system-legal.

## Review the recent process
When I ask, look back over recent sessions and the project files and give concise feedback on how the work and my use of AI are going — what's working, what's drifting, what to push on. Periodically re-verify the docs against themselves (contrast ratios, "colour-blind safe" claims, token math) rather than trusting the numbers already written in the tables.

## Style
Be concise and direct. I'm the author — critique my drafts, don't replace my judgment.

## Image sync
The source-of-truth folder for web-optimised photos is `photos/menu-website/` (preserving its subfolder structure: `bar/`, `food/`, etc.). The theme folder that WordPress serves from is `sweet-pepper-theme/assets/images/`. Whenever working on sections that use photos, or when I ask, check that:
1. Every file in `photos/menu-website/**` has a matching copy in `sweet-pepper-theme/assets/images/**` (same relative path + filename).
2. Any file in the theme images folder that no longer exists in the source folder is flagged for removal.
3. Report the diff concisely — new files to copy, stale files to remove — and execute the sync after my confirmation.

## Imported Claude Cowork project instructions
