"""Render style-guide-draft.html -> PDF (A4, full-bleed Paper pages, Peppercorn cover).
Usage:  python3 render-style-guide-pdf.py [--lang en|ru] [--landscape-logo] [--out NAME.pdf]
  --lang ru renders the Russian layer of the bilingual HTML (default en; default output name gets a -ru suffix).
Needs: playwright (chromium), pypdf, reportlab. Golos is embedded from design/fonts/Golos_Text/."""
import asyncio, io, os, sys
from playwright.async_api import async_playwright
from pypdf import PdfReader, PdfWriter
from reportlab.pdfgen import canvas
from reportlab.lib.colors import HexColor

ROOT=os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SRC="file://"+os.path.join(ROOT,"style-guide-draft.html")
GOLOS="file://"+os.path.join(ROOT,"design/fonts/Golos_Text/GolosText-VariableFont_wght.ttf")
RAW=os.path.join(ROOT,"tools/_raw.pdf")
PEPPERCORN="#151317"; PAPER="#FCF7E8"
LANDSCAPE_LOGO="--landscape-logo" in sys.argv
LANG=sys.argv[sys.argv.index("--lang")+1] if "--lang" in sys.argv else "en"
OUT=os.path.join(ROOT, sys.argv[sys.argv.index("--out")+1] if "--out" in sys.argv else ("sweet-pepper-style-guide-ru.pdf" if LANG=="ru" else "sweet-pepper-style-guide.pdf"))

# Experiment: named landscape page for the Logo section only
LANDSCAPE_CSS="""
@media print{
  @page wide{size:A4 landscape;margin:12mm 14mm;}
  section#logo{page:wide;}
  section#logo .logo-gallery{grid-template-columns:repeat(4,1fr);}
  section#logo .logo-gallery .wide{grid-column:1 / -1;}
  section#logo .lstage.wide svg{max-width:560px;}
  section#logo .cs-grid{grid-template-columns:repeat(4,1fr);}
}"""

async def handler(route):
    u=route.request.url
    if "googleapis" in u or "gstatic" in u: await route.abort()
    else: await route.continue_()

async def render():
    async with async_playwright() as p:
        b=await p.chromium.launch(args=["--no-sandbox","--disable-gpu","--allow-file-access-from-files"])
        pg=await b.new_page(); await pg.route("**/*", handler)
        await pg.goto(SRC+"?lang="+LANG, wait_until="load", timeout=120000)
        await pg.evaluate(f"document.documentElement.setAttribute('data-lang','{LANG}');document.documentElement.setAttribute('lang','{LANG}')")
        await pg.add_style_tag(content=f"@font-face{{font-family:'Golos Text';src:url('{GOLOS}') format('truetype');font-weight:100 900;}}")
        if LANDSCAPE_LOGO: await pg.add_style_tag(content=LANDSCAPE_CSS)
        await pg.emulate_media(media="print"); await pg.wait_for_timeout(2000)
        await pg.pdf(path=RAW, print_background=True, prefer_css_page_size=True)
        await b.close()

def underlay(hexc, w, h):
    buf=io.BytesIO(); c=canvas.Canvas(buf,pagesize=(w,h)); c.setFillColor(HexColor(hexc))
    c.rect(0,0,w,h,fill=1,stroke=0); c.showPage(); c.save(); buf.seek(0); return buf

def compose():
    raw=PdfReader(RAW); w=PdfWriter()
    for i,pg in enumerate(raw.pages):
        mb=pg.mediabox; pw,ph=float(mb.width),float(mb.height)
        base=PdfReader(underlay(PEPPERCORN if i==0 else PAPER, pw, ph)).pages[0]
        base.merge_page(pg); w.add_page(base)
    w.add_metadata({"/Title":"Sweet Pepper — Гайд по бренду и визуальному стилю" if LANG=="ru" else "Sweet Pepper — Brand & Visual Style Guide","/Author":"Etual F."})
    with open(OUT,"wb") as f: w.write(f)
    r=PdfReader(OUT)
    sizes=sorted({(round(float(p.mediabox.width)),round(float(p.mediabox.height))) for p in r.pages})
    print(f"OK -> {os.path.basename(OUT)} | {len(r.pages)} pages | {os.path.getsize(OUT)//1024} KB | page sizes: {sizes}")

if __name__=="__main__":
    asyncio.run(render()); compose()
