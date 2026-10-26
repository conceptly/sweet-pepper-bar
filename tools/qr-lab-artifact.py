#!/usr/bin/env python3
"""Build the shareable copy of the QR lab (sweet-pepper-theme/lab/qr.html) for a claude.ai artifact.

The artifact page runs in a locked frame: scripts only from a few CDNs, no other fetches, and the
publisher adds its own <html>/<head>/<body>. So the vendored libraries become pinned jsDelivr URLs,
Molot is inlined as a data URI, Golos Text comes from Google Fonts, and the wrapper tags go.
Usage: python3 tools/qr-lab-artifact.py OUT.html
"""
import base64, pathlib, re, sys

root = pathlib.Path(__file__).resolve().parent.parent
src = (root / 'sweet-pepper-theme/lab/qr.html').read_text()
molot = base64.b64encode((root / 'sweet-pepper-theme/src/fonts/Molot.woff2').read_bytes()).decode()

swaps = [
    ('<script src="vendor/qrcode-generator-2.0.4.js"></script>', '<script src="https://cdn.jsdelivr.net/npm/qrcode-generator@2.0.4/dist/qrcode.js"></script>'),
    ('<script src="vendor/jsqr-1.4.0.js"></script>', '<script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.js"></script>'),
    ("url('../src/fonts/Molot.woff2')", f"url('data:font/woff2;base64,{molot}')"),
    ("@font-face { font-family: 'Golos Text'; src: url('../src/fonts/GolosText-VariableFont_wght.ttf') format('truetype'); font-weight: 400 900; font-display: swap; }\n", ''),
    ('<title>QR lab</title>', '<title>Sweet Pepper QR Lab</title>\n<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Golos+Text:wght@400..900&display=swap">'),
]
for a, b in swaps:
    if a not in src:
        sys.exit(f'qr.html changed, update the swap for: {a[:60]}')
    src = src.replace(a, b)

src = re.sub(r'^<!doctype html>\n<!--.*?-->\n<html lang="en">\n<head>\n', '', src, flags=re.S)
src = re.sub(r'<meta charset="utf-8">\n<meta name="viewport"[^>]*>\n<meta name="robots"[^>]*>\n', '', src)
src = src.replace('</head>\n<body>\n', '').replace('</body>\n</html>\n', '')
if re.search(r'<(html|head|body)\b', src):
    sys.exit('wrapper tags left over')
pathlib.Path(sys.argv[1]).write_text(src)
print(f'{sys.argv[1]}: {len(src) // 1024} KB')
