#!/usr/bin/env python3
"""Build the site's Molot webfont — Latin + Cyrillic — from design/fonts/Molot.otf.

    python3 -m venv /tmp/fontvenv && /tmp/fontvenv/bin/pip install fonttools brotli
    /tmp/fontvenv/bin/python tools/molot-webfont.py

Writes sweet-pepper-theme/src/fonts/Molot.woff2 and Molot.woff (main.css → @font-face).

Why not the font kit's Molot-webfont.woff: it is Font Squirrel's *macroman* subset — no
Cyrillic at all — and every Russian headline fell back to a system sans (found 21 Sep 2026).
The OTF carries the Russian alphabet (U+0410–044F, Ё / ё). Nothing is subset away here.

Three things the kit had and the OTF lacks, restored so the English pages do not move:
  1. Vertical metrics. The kit's are 1935 / −450 / 0 on 2048; the OTF's 945 / −200 / 30 on
     1000 would drop every baseline ~1% of the font size. Set to the kit's, scaled.
  2. "%" — the OTF draws the glyph but maps no codepoint to it ("50% off…" on the menu).
  3. No-break space, soft hyphen and the hyphen twins (U+2010–2012), as aliases of the
     space and the hyphen — same advances as the kit's. Its typographic spaces
     (U+2000–200A, 202F, 205F) and U+25FC are not carried over: the theme uses none.
Advance widths of every shared character are identical in the two files (checked), so no
English line changes width.
"""
from pathlib import Path
from fontTools.ttLib import TTFont

ROOT = Path(__file__).resolve().parent.parent
SRC = ROOT / "design/fonts/Molot.otf"
OUT = ROOT / "sweet-pepper-theme/src/fonts"

ALIASES = {0x25: "percent", 0xA0: "space", 0xAD: "hyphen", 0x2010: "hyphen", 0x2011: "hyphen", 0x2012: "hyphen"}

font = TTFont(SRC)
for table in font["cmap"].tables:
    if table.isUnicode():
        for codepoint, glyph in ALIASES.items():
            table.cmap.setdefault(codepoint, glyph)

# The kit's vertical metrics on a 1000 em: 1935 → 945, 450 → 220, 1638 → 800, 410 → 200.
font["hhea"].ascent, font["hhea"].descent, font["hhea"].lineGap = 945, -220, 0
os2 = font["OS/2"]
os2.usWinAscent, os2.usWinDescent = 945, 220
os2.sTypoAscender, os2.sTypoDescender, os2.sTypoLineGap = 800, -200, 0

for flavor in ("woff2", "woff"):
    font.flavor = flavor
    path = OUT / f"Molot.{flavor}"
    font.save(path)
    print(f"wrote {path.relative_to(ROOT)}  {path.stat().st_size} bytes")
