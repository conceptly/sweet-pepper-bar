#!/usr/bin/env python3
"""Render a case-study markdown file to a single HTML page in the brand fonts, ready for
headless Chrome's --print-to-pdf (A4).

    python3 tools/case-study-md-html.py case-study/Sweet-Pepper-Case-Study-concise-draft.md out.html
    "/Applications/Google Chrome.app/Contents/MacOS/Google Chrome" --headless=new --disable-gpu \
        --no-pdf-header-footer --print-to-pdf=out.pdf file://$PWD/out.html   # kill Chrome once the file is stable

Markdown understood: #/## headings, paragraphs, **bold**, *italic*, `code`, pipe tables, ordered and
unordered lists, ---. Fonts are read from the main checkout's theme sources (Molot.woff2,
GolosText-VariableFont_wght.ttf) by absolute file:// path."""
import html, re, sys, pathlib

FONTS = pathlib.Path('/Users/Shared/Files From d.localized/Мои Художества/Sweet-Website/sweet-pepper-theme/src/fonts')

def inline(s):
    s = html.escape(s, quote=False)
    s = re.sub(r'`([^`]+)`', r'<code>\1</code>', s)
    s = re.sub(r'\*\*(.+?)\*\*', r'<strong>\1</strong>', s)
    s = re.sub(r'(?<![\w*])\*(?!\s)(.+?)(?<!\s)\*(?![\w*])', r'<em>\1</em>', s)
    return s

def convert(md):
    out, i, lines = [], 0, md.splitlines()
    while i < len(lines):
        ln = lines[i]
        if not ln.strip():
            i += 1; continue
        if ln.startswith('# '):
            out.append(f'<h1>{inline(ln[2:])}</h1>'); i += 1; continue
        if ln.startswith('## '):
            out.append(f'<h2>{inline(ln[3:])}</h2>'); i += 1; continue
        if ln.strip() == '---':
            out.append('<hr>'); i += 1; continue
        if ln.startswith('|'):
            rows = []
            while i < len(lines) and lines[i].startswith('|'):
                cells = [c.strip() for c in lines[i].strip().strip('|').split('|')]
                if not all(re.fullmatch(r':?-+:?', c) for c in cells):
                    rows.append(cells)
                i += 1
            head, body = rows[0], rows[1:]
            t = ['<table><thead><tr>' + ''.join(f'<th>{inline(c)}</th>' for c in head) + '</tr></thead><tbody>']
            for r in body:
                t.append('<tr>' + ''.join(f'<td>{inline(c)}</td>' for c in r) + '</tr>')
            t.append('</tbody></table>')
            out.append(''.join(t)); continue
        m = re.match(r'^(\d+)\. (.*)', ln)
        if m or ln.startswith('- '):
            tag = 'ol' if m else 'ul'
            items = []
            while i < len(lines) and (re.match(r'^\d+\. ', lines[i]) or lines[i].startswith('- ')):
                items.append(re.sub(r'^(\d+\. |- )', '', lines[i])); i += 1
            out.append(f'<{tag}>' + ''.join(f'<li>{inline(x)}</li>' for x in items) + f'</{tag}>'); continue
        para = []
        while i < len(lines) and lines[i].strip() and not re.match(r'^(#|\||---|\d+\. |- )', lines[i]):
            para.append(lines[i]); i += 1
        p = '<br>'.join(inline(x) for x in para)
        if len(para) == 1 and para[0].startswith('*') and not para[0].startswith('**') and para[0].endswith('*'):
            out.append(f'<p class="foot">{p}</p>')
        elif out and out[-1].startswith('<h1>'):
            out.append(f'<p class="kicker">{p}</p>')
        else:
            out.append(f'<p>{p}</p>')
    return '\n'.join(out)

CSS = f"""
@font-face {{ font-family: 'Molot'; src: url('file://{FONTS}/Molot.woff2') format('woff2'); }}
@font-face {{ font-family: 'Golos Text'; src: url('file://{FONTS}/GolosText-VariableFont_wght.ttf') format('truetype'); font-weight: 400 900; }}
@page {{ size: A4; margin: 18mm 18mm 20mm 18mm; }}
:root {{ --paper:#F7F0E1; --ink:#151317; --chili:#E34314; --deep:#B8360E; --olive:#6B7A1F; --ash:#5E5950; --mushroom:#9E9789; --hair:#D9D0BC; }}
html {{ background:#fff; }}
body {{ margin:0; font-family:'Golos Text', system-ui, sans-serif; font-weight:400; font-size:10.5pt; line-height:1.5; color:var(--ink); -webkit-print-color-adjust:exact; print-color-adjust:exact; text-wrap:pretty; }}
h1 {{ font-family:'Molot', sans-serif; font-weight:400; font-size:30pt; line-height:1.05; color:var(--chili); margin:0 0 8pt; letter-spacing:0.01em; text-transform:uppercase; }}
h2 {{ font-family:'Molot', sans-serif; font-weight:400; font-size:17pt; line-height:1.1; color:var(--ink); margin:22pt 0 8pt; padding-top:10pt; text-transform:uppercase; break-after:avoid; page-break-after:avoid; break-inside:avoid; page-break-inside:avoid; background:linear-gradient(var(--chili), var(--chili)) no-repeat 0 0 / 36pt 3pt; }}
p {{ margin:0 0 8pt; orphans:3; widows:3; }}
p.kicker {{ color:var(--ash); font-size:9.5pt; line-height:1.45; margin-bottom:12pt; border-bottom:1px solid var(--hair); padding-bottom:10pt; }}
p.kicker strong {{ color:var(--ink); font-weight:600; }}
p.foot {{ color:var(--mushroom); font-size:9pt; margin-top:14pt; }}
strong {{ font-weight:600; }}
em {{ font-style:italic; }}
code {{ font-family: ui-monospace, Menlo, monospace; font-size:0.92em; background:#F1EADB; padding:0 3px; border-radius:3px; }}
hr {{ border:0; border-top:1px solid var(--hair); margin:14pt 0; }}
ul, ol {{ margin:0 0 10pt; padding-left:18pt; }}
li {{ margin:0 0 3pt; }}
li::marker {{ color:var(--chili); font-weight:600; }}
table {{ width:100%; border-collapse:collapse; margin:4pt 0 12pt; font-size:9.5pt; line-height:1.4; break-inside:avoid; page-break-inside:avoid; }}
th {{ text-align:left; font-family:'Molot', sans-serif; font-weight:400; font-size:10pt; text-transform:uppercase; color:var(--olive); padding:0 8pt 5pt 0; border-bottom:1.5px solid var(--ink); }}
td {{ vertical-align:top; padding:5pt 8pt 5pt 0; border-bottom:1px solid var(--hair); }}
td:last-child, th:last-child {{ padding-right:0; }}
"""

def main(src, dst):
    body = convert(pathlib.Path(src).read_text(encoding='utf-8'))
    doc = f'<!doctype html><html lang="en"><head><meta charset="utf-8"><title>Sweet Pepper — Case Study</title><style>{CSS}</style></head><body>{body}</body></html>'
    pathlib.Path(dst).write_text(doc, encoding='utf-8')
    print(f'wrote {dst}')

if __name__ == '__main__':
    main(sys.argv[1], sys.argv[2])
