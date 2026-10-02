"""Render the case-study deck to one HTML file, a page per slide, for headless
Chrome to print as the PDF — no PowerPoint or LibreOffice needed.

The deck is PptxGenJS output and uses little: rects, ellipses, lines, pictures
and single-run text boxes in Arial / Calibri. This script handles exactly that.

    python3 tools/case-study-deck-html.py case-study/Sweet-Pepper-Case-Study.pptx <outdir>
    "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome" --headless=new \
        --no-pdf-header-footer --print-to-pdf=<out.pdf> file://<outdir>/deck.html

Chrome may not exit after writing the file — stop it once the PDF's size is
stable. Pictures are resampled to twice their size on the slide (sips), and
those without transparency become JPEG, so the PDF stays a few MB."""
import math
import os
import re
import subprocess
import sys
import zipfile
import xml.etree.ElementTree as ET
from html import escape

src, out = sys.argv[1], sys.argv[2]
os.makedirs(os.path.join(out, 'media'), exist_ok=True)
z = zipfile.ZipFile(src)
NS = {'a': 'http://schemas.openxmlformats.org/drawingml/2006/main',
      'p': 'http://schemas.openxmlformats.org/presentationml/2006/main',
      'r': 'http://schemas.openxmlformats.org/officeDocument/2006/relationships'}
A, P, R = (f'{{{NS[k]}}}' for k in 'apr')
PX = 96 / 914400  # EMU -> CSS px
PT = 96 / 72


def px(v):
    return round(int(v) * PX, 2)


def colour(fill):
    """solidFill element -> css colour."""
    c = fill.find('a:srgbClr', NS)
    if c is None:
        return None
    h = c.get('val')
    al = c.find('a:alpha', NS)
    if al is not None:
        r, g, b = (int(h[i:i + 2], 16) for i in (0, 2, 4))
        return f'rgba({r},{g},{b},{int(al.get("val")) / 100000})'
    return '#' + h


def slide_order():
    pres = ET.fromstring(z.read('ppt/presentation.xml'))
    rels = ET.fromstring(z.read('ppt/_rels/presentation.xml.rels'))
    m = {r.get('Id'): r.get('Target') for r in rels}
    return ['ppt/' + m[s.get(R + 'id')] for s in pres.find('p:sldIdLst', NS)]


def text_html(sp):
    tx = sp.find('p:txBody', NS)
    if tx is None:
        return ''
    body = tx.find('a:bodyPr', NS)
    anchor = body.get('anchor', 't') if body is not None else 't'
    paras = []
    for p in tx.findall('a:p', NS):
        runs = p.findall('a:r', NS)
        if not runs:
            continue
        ppr = p.find('a:pPr', NS)
        algn = {'ctr': 'center', 'r': 'right', 'l': 'left'}.get(ppr.get('algn') if ppr is not None else None, 'left')
        rp0 = runs[0].find('a:rPr', NS)
        lat0 = rp0.find('a:latin', NS) if rp0 is not None else None
        nat = 1.22 if lat0 is not None and lat0.get('typeface') == 'Calibri' else 1.15
        fs = int(rp0.get('sz')) / 100 * PT if rp0 is not None and rp0.get('sz') else 24
        lh = nat
        if ppr is not None:
            pct = ppr.find('a:lnSpc/a:spcPct', NS)
            pts = ppr.find('a:lnSpc/a:spcPts', NS)
            if pct is not None:
                lh = nat * int(pct.get('val')) / 100000
        spans = []
        for r in runs:
            rp = r.find('a:rPr', NS)
            st = []
            if rp is not None:
                if rp.get('sz'):
                    st.append(f'font-size:{int(rp.get("sz")) / 100 * PT:.2f}px')
                if rp.get('b') == '1':
                    st.append('font-weight:700')
                if rp.get('i') == '1':
                    st.append('font-style:italic')
                if rp.get('spc'):
                    st.append(f'letter-spacing:{int(rp.get("spc")) / 100 * PT:.2f}px')
                f = rp.find('a:solidFill', NS)
                if f is not None and colour(f):
                    st.append('color:' + colour(f))
                lat = rp.find('a:latin', NS)
                if lat is not None:
                    st.append(f"font-family:'{lat.get('typeface')}',Arial,sans-serif")
            spans.append(f'<span style="{";".join(st)}">{escape(r.find("a:t", NS).text or "")}</span>')
        style = f'font-size:{fs:.2f}px;text-align:{algn};line-height:{lh:.3f}'
        if ppr is not None and ppr.find('a:lnSpc/a:spcPts', NS) is not None:
            style = f'font-size:{fs:.2f}px;text-align:{algn};line-height:{int(ppr.find("a:lnSpc/a:spcPts", NS).get("val")) / 100 * PT:.2f}px'
        paras.append(f'<p style="{style}">{"".join(spans)}</p>')
    if not paras:
        return ''
    jc = {'ctr': 'center', 'b': 'flex-end'}.get(anchor, 'flex-start')
    return f'<div class="tx" style="justify-content:{jc}">{"".join(paras)}</div>'


def web_image(part, shown_w):
    """Write a deck picture into <out>/media at twice its shown width; return the file name."""
    base = os.path.basename(part)
    path = os.path.join(out, 'media', base)
    with open(path, 'wb') as f:
        f.write(z.read(part))
    info = subprocess.run(['sips', '-g', 'pixelWidth', '-g', 'hasAlpha', path], capture_output=True, text=True).stdout
    width = int(re.search(r'pixelWidth: (\d+)', info).group(1))
    alpha = 'hasAlpha: yes' in info
    target = min(width, math.ceil(shown_w * 2))
    stem = f'{os.path.splitext(base)[0]}-{target}'
    dest = os.path.join(out, 'media', stem + ('.png' if alpha else '.jpg'))
    cmd = ['sips', '--resampleWidth', str(target)]
    if not alpha:
        cmd += ['-s', 'format', 'jpeg', '-s', 'formatOptions', '88']
    subprocess.run(cmd + [path, '--out', dest], capture_output=True, check=True)
    os.remove(path)
    return os.path.basename(dest)


def shape_html(sp, rels, kind):
    spPr = sp.find('p:spPr', NS)
    xf = spPr.find('a:xfrm', NS)
    off, ext = xf.find('a:off', NS), xf.find('a:ext', NS)
    x, y, w, h = px(off.get('x')), px(off.get('y')), px(ext.get('cx')), px(ext.get('cy'))
    geom = spPr.find('a:prstGeom', NS)
    prst = geom.get('prst') if geom is not None else 'rect'
    st = [f'left:{x}px;top:{y}px;width:{w}px;height:{h}px']
    ln = spPr.find('a:ln', NS)
    lnw, lnc, dash = 0, None, 'solid'
    if ln is not None and ln.find('a:solidFill', NS) is not None:
        lnw = max(px(ln.get('w', '9525')), 0.75)
        lnc = colour(ln.find('a:solidFill', NS))
        d = ln.find('a:prstDash', NS)
        if d is not None and d.get('val') != 'solid':
            dash = 'dashed' if 'ash' in d.get('val') else 'dotted'
    if prst == 'line':
        if h == 0:
            st.append(f'height:0;border-top:{lnw}px {dash} {lnc};margin-top:{-lnw / 2}px')
        else:
            st.append(f'width:0;border-left:{lnw}px {dash} {lnc};margin-left:{-lnw / 2}px')
        return f'<div class="sh" style="{";".join(st)}"></div>'
    if lnc:  # Office strokes are centred on the outline
        st.append(f'outline:{lnw}px {dash} {lnc};outline-offset:{-lnw / 2}px')
    if prst == 'ellipse':
        st.append('border-radius:50%')
    elif prst == 'roundRect':
        gd = geom.find('a:avLst/a:gd', NS)
        adj = int(gd.get('fmla').split()[-1]) if gd is not None else 16667
        st.append(f'border-radius:{min(w, h) * adj / 100000:.2f}px')
    sh = spPr.find('a:effectLst/a:outerShdw', NS)
    if sh is not None:
        dist, blur = px(sh.get('dist', '0')), px(sh.get('blurRad', '0'))
        ang = int(sh.get('dir', '0')) / 60000 * math.pi / 180
        # Chrome prints a blurred shadow as a hard block; stack unblurred spreads instead (vector, soft enough)
        c = sh.find('a:srgbClr', NS)
        al = int(c.find('a:alpha', NS).get('val')) / 100000 if c.find('a:alpha', NS) is not None else 1
        steps = [0.0, 0.15, 0.3, 0.45, 0.6, 0.8]
        st.append('box-shadow:' + ','.join(
            f'{dist * math.cos(ang):.2f}px {dist * math.sin(ang):.2f}px 0 {blur * k:.2f}px rgba(0,0,0,{al / len(steps):.4f})' for k in steps))
    inner = ''
    if kind == 'pic':
        bf = sp.find('p:blipFill', NS)
        target = rels[bf.find('a:blip', NS).get(R + 'embed')]
        sr = bf.find('a:srcRect', NS)
        l, r, t, b = ((int(sr.get(k, '0')) / 100000) if sr is not None else 0 for k in 'lrtb')
        iw, ih = w / (1 - l - r), h / (1 - t - b)
        name = web_image(os.path.normpath('ppt/slides/' + target), iw)
        st.append('overflow:hidden')
        inner = f'<img src="media/{name}" style="position:absolute;left:{-l * iw:.2f}px;top:{-t * ih:.2f}px;width:{iw:.2f}px;height:{ih:.2f}px">'
    else:
        f = spPr.find('a:solidFill', NS)
        if f is not None:
            st.append('background:' + colour(f))
        inner = text_html(sp)
    return f'<div class="sh" style="{";".join(st)}">{inner}</div>'


pages = []
for path in slide_order():
    root = ET.fromstring(z.read(path))
    relp = path.replace('slides/', 'slides/_rels/') + '.rels'
    rels = {r.get('Id'): r.get('Target') for r in ET.fromstring(z.read(relp))}
    bg = root.find('p:cSld/p:bg/p:bgPr/a:solidFill', NS)
    items = []
    for el in root.find('p:cSld/p:spTree', NS):
        if el.tag == P + 'sp':
            items.append(shape_html(el, rels, 'sp'))
        elif el.tag == P + 'pic':
            items.append(shape_html(el, rels, 'pic'))
    pages.append(f'<section style="background:{colour(bg) if bg is not None else "#fff"}">{"".join(items)}</section>')

css = '''@page{size:1280px 720px;margin:0}
*{box-sizing:border-box;margin:0;padding:0}
html,body{background:#000;-webkit-print-color-adjust:exact;print-color-adjust:exact}
section{position:relative;width:1280px;height:720px;overflow:hidden;page-break-after:always;break-after:page;font-family:Arial,Helvetica,sans-serif;font-size:24px;color:#000}
section:last-child{page-break-after:auto;break-after:auto}
.sh{position:absolute}
.tx{position:absolute;inset:0;padding:4.8px 9.6px;display:flex;flex-direction:column}
.tx p{white-space:pre-wrap;overflow-wrap:break-word}
'''
html = f'<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Sweet Pepper — Brand &amp; UX Case Study</title><style>{css}</style></head><body>{"".join(pages)}</body></html>'
with open(os.path.join(out, 'deck.html'), 'w', encoding='utf-8') as f:
    f.write(html)
print(len(pages), 'slides ->', os.path.join(out, 'deck.html'))
