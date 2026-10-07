#!/usr/bin/env python3
"""
Section connectors: one stroke weight on screen, whatever the file's size (author, 6 Oct 2026).

Figma exports a connector's OUTSIDE stroke as geometry — a filled outline, masked to the
outside of the letters — so its thickness is fixed in the file's own units and shrinks with
the file: a ~1094-wide export drawn 343 wide on a phone turned Figma's 2px / 1px into
0.63 / 0.31px, and the menu heroes (exported ~365 wide) into 0.9–1.9px. This rewrites each
file's outline as a real stroke of the letters with `vector-effect="non-scaling-stroke"`,
so the width is in screen pixels:

    desktop / tablet  — Figma's numbers: a day-ground word 2px, every other word and every
                        reflection 1px (night, bar, reflections; checked against the baked
                        geometry of all 152 files on 6 Oct 2026 — none off by more than 0.35)
    phone             — 1px everywhere (the author's Figma trial)

"Phone" is decided INSIDE the file: an SVG used as an <img> evaluates its own media queries
against the image's width, so `@media (max-width: 600px)` catches every phone connector
(≤ 400 wide) and no tablet one (≥ ~700). The mask still hides the inner half, so the
stroke-width is twice the visible outside width.

The viewBox gains PAD units on every side (the mask with it): the letters sat 1–2 units from
the edges, and a 1px stroke on a phone needs ~3–4, or the tops and bottoms of the letters
would be clipped thinner than their sides. The word stays width-matched to the container
(the band grows by the pad, ~0.5% wide).

Also adds preserveAspectRatio="none" when missing (the 21 Sep 2026 rule). Reflection inks are
NOT touched — recolour fresh exports as before (website-brief.md → Section connectors).

Run from the repo root; files already converted are skipped:
    python3 tools/connector-strokes.py sweet-pepper-theme/assets/sectionLinks/home sweet-pepper-theme/assets/sectionLinks/menu
"""

import re
import sys
from pathlib import Path

PAD = 3            # viewBox units added on each side
PHONE_MAX = 600    # image width (CSS px) at or below which the phone stroke applies
PHONE_PX = 1       # visible outside stroke on phones


def desktop_px(path: Path) -> int:
    """Figma's outside stroke: 2px for a day-ground word, 1px for everything else."""
    p = path.as_posix()
    day = '/dayMode/' in p or '/kitchen-day/' in p
    reflection = p.endswith('-reflection.svg') or p.endswith('-top.svg')
    return 2 if day and not reflection else 1


def num(x: float) -> str:
    return f'{x:.6f}'.rstrip('0').rstrip('.')


def convert(path: Path) -> str:
    s = path.read_text()
    if 'non-scaling-stroke' in s:
        return 'skip (done)'

    root = re.match(r'<svg\b[^>]*>', s)
    vb = re.search(r'viewBox="0 0 ([\d.]+) ([\d.]+)"', root.group(0)) if root else None
    mask = re.search(r'<mask id="([^"]+)"[^>]*>\s*<rect [^>]*/>\s*<path d="([^"]+)"/>\s*</mask>', s)
    stroke = re.search(r'<path d="[^"]+" fill="(#[0-9A-Fa-f]{6})" mask="url\(#([^)]+)\)"/>', s)
    if not (vb and mask and stroke and stroke.group(2) == mask.group(1)):
        raise SystemExit(f'{path}: unexpected structure — not converted')

    w, h = float(vb.group(1)), float(vb.group(2))
    x0, y0, W, H = -PAD, -PAD, w + 2 * PAD, h + 2 * PAD
    mid, glyph, ink = mask.group(1), mask.group(2), stroke.group(1)
    desk = desktop_px(path)

    tag = root.group(0)
    tag = re.sub(r'viewBox="[^"]+"', f'viewBox="{num(x0)} {num(y0)} {num(W)} {num(H)}"', tag)
    tag = re.sub(r'\bwidth="[\d.]+"', f'width="{num(W)}"', tag, count=1)
    tag = re.sub(r'\bheight="[\d.]+"', f'height="{num(H)}"', tag, count=1)
    if 'preserveAspectRatio' not in tag:
        tag = tag.replace('<svg ', '<svg preserveAspectRatio="none" ', 1)
    style = (f'<style>.sl{{stroke-width:{2 * desk}px}}'
             f'@media (max-width:{PHONE_MAX}px){{.sl{{stroke-width:{2 * PHONE_PX}px}}}}</style>')
    s = s.replace(root.group(0), tag + '\n' + style, 1)

    box = f'x="{num(x0)}" y="{num(y0)}" width="{num(W)}" height="{num(H)}"'
    s = s.replace(mask.group(0),
                  f'<mask id="{mid}" maskUnits="userSpaceOnUse" {box} fill="black">\n'
                  f'<rect fill="white" {box}/>\n<path d="{glyph}"/>\n</mask>', 1)
    s = s.replace(stroke.group(0),
                  f'<path class="sl" d="{glyph}" fill="none" stroke="{ink}" '
                  f'vector-effect="non-scaling-stroke" mask="url(#{mid})"/>', 1)
    path.write_text(s)
    return f'{desk}px desktop / {PHONE_PX}px phone'


if __name__ == '__main__':
    files = []
    for arg in sys.argv[1:] or ['sweet-pepper-theme/assets/sectionLinks/home', 'sweet-pepper-theme/assets/sectionLinks/menu']:
        p = Path(arg)
        files += sorted(p.rglob('*.svg')) if p.is_dir() else [p]
    for f in files:
        print(f'{convert(f):28} {f}')
