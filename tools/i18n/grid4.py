"""Snap every margin / padding / gap px value to the 4px grid (nearest multiple of 4, ties round up).
Usage: python3 tools/i18n/grid4.py [--check]   — applies to style-guide-draft.html, tools/i18n/inject.py,
tools/i18n/mobile-shell.html and tools/i18n/strings-ru.json; --check only reports."""
import re,sys,os,json
ROOT=os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
PROP=re.compile(r'(?<![-\w])(margin(?:-(?:top|bottom|left|right))?|padding(?:-(?:top|bottom|left|right))?|gap|row-gap|column-gap)\s*:\s*([^;}"\'\\]+)')
PX=re.compile(r'(?<![\w.])(\d+(?:\.\d+)?)px')
report=[]
def snap(v):
    f=float(v)
    if f==0: return v
    n=int((f+2)//4)*4  # ties round up
    if n==0: n=4
    return str(n)
def fix_value(m):
    prop,val=m.group(1),m.group(2)
    def r(px):
        old=px.group(1); new=snap(old)
        if new!=old.rstrip('0').rstrip('.') and float(new)!=float(old): report.append(f'{prop}: {old}px -> {new}px')
        return new+'px'
    return prop+':'+PX.sub(r,val)
def process(text): return PROP.sub(fix_value,text)
check='--check' in sys.argv
files=['style-guide-draft.html','tools/i18n/inject.py','tools/i18n/mobile-shell.html','tools/i18n/strings-ru.json']
for f in files:
    p=os.path.join(ROOT,f); s=open(p).read(); n0=len(report); t=process(s)
    print(f, len(report)-n0, 'changes')
    if not check and t!=s: open(p,'w').write(t)
from collections import Counter
for k,c in sorted(Counter(report).items()): print(f'  {c:3d} × {k}')
