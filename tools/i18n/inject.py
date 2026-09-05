"""Inject RU twins next to EN text blocks in style-guide-draft.html.
Usage: python3 tools/i18n/inject.py  (run from project root; idempotent — strips prior injection first)
Translations: tools/i18n/strings-ru.json, keyed by the whitespace-normalised English innerHTML of each text block.
After editing English in the HTML, rerun; STALE lines = RU entries whose English changed (re-key them), MISS = never expected.
"""
import re, json, sys, html as H, importlib.util, os
from bs4 import BeautifulSoup, Tag
ROOT=os.path.dirname(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
SRC=os.path.join(ROOT,'style-guide-draft.html')
raw=open(SRC).read()

# ---- 0. strip any previous injection (elements with lang="ru" + lang="en" attrs + switch block)
raw=re.sub(r'<!-- LANG-SWITCH -->.*?<!-- /LANG-SWITCH -->','',raw,flags=re.S)
raw=re.sub(r'<!-- LANG-CSS -->.*?<!-- /LANG-CSS -->','',raw,flags=re.S)
raw=re.sub(r'<!-- COPY-SVG -->.*?<!-- /COPY-SVG -->','',raw,flags=re.S)
raw=re.sub(r'<!-- MOBILE-SHELL -->.*?<!-- /MOBILE-SHELL -->','',raw,flags=re.S)
def strip_ru(s):
    # remove <tag ... lang="ru">...</tag> for leaf tags (no nesting of same tag inside our leaves except div/span callouts; handle by balanced scan)
    out=[];i=0
    pat=re.compile(r'<([a-z0-9]+)([^>]*)\slang="ru"([^>]*)>')
    while True:
        m=pat.search(s,i)
        if not m: out.append(s[i:]); break
        out.append(s[i:m.start()])
        tag=m.group(1); depth=1; j=m.end()
        tok=re.compile(r'<(/?)'+tag+r'\b[^>]*>')
        while depth:
            t=tok.search(s,j)
            if not t: raise SystemExit('unbalanced')
            depth+= -1 if t.group(1) else 1
            j=t.end()
        i=j
    return ''.join(out)
raw=strip_ru(raw)
raw=raw.replace(' lang="en">','>').replace('<html>','<html lang="en">')
# ensure html tag has lang (the replace above may have stripped it)
raw=re.sub(r'<html(?![^>]*lang=)',' <html lang="en"',raw,count=1).lstrip()

# ---- 1. load translations: {normalised EN innerHTML: RU innerHTML}
RU=json.load(open(os.path.join(ROOT,'tools/i18n/strings-ru.json')))

# ---- 2. extract EN leaf strings (same algorithm as extraction)
soup=BeautifulSoup(raw,'html.parser')
LEAF={'p','h1','h2','h3','h4','li','figcaption','td','th','strong','span','a'}
DIVCLS={'note','meta','k','k2','k3','mt','mi'}
out=[]; leaftags={}
def inner(el): return ''.join(str(c) for c in el.contents)
def walk(el):
    for c in list(el.children):
        if not isinstance(c,Tag) or c.name in ('svg','img'): continue
        cls=set(c.get('class') or [])
        if c.name=='div' and 'callout' in cls: out.append(inner(c)); leaftags.setdefault(norm(inner(c)),set()).add('div'); continue
        if c.name=='footer': w=c.find(class_='wrap'); out.append(inner(w)); leaftags.setdefault(norm(inner(w)),set()).add('div'); continue
        if (c.name in LEAF or (c.name=='div' and cls&DIVCLS)) and c.get_text(strip=True):
            if c.name=='a' and c.get('href','').startswith(('http','mailto')): continue
            if c.find(['p','ul','div','table','h3']): walk(c); continue
            out.append(inner(c)); leaftags.setdefault(norm(inner(c)),set()).add(c.name); continue
        walk(c)
def norm(s): return re.sub(r'\s+',' ',s).strip()
walk(soup.body)
seen=set(); items=[]
for o in out:
    n=norm(o)
    if n in seen or not n: continue
    seen.add(n); items.append(n)
print('items',len(items))

def mkpat(en):
    en=H.unescape(en.replace('&amp;','&'))
    parts=re.split(r'(\s+|<br/>|&)',en)
    buf=[]
    for p in parts:
        if not p: continue
        if p.isspace(): buf.append(r'\s+')
        elif p=='<br/>': buf.append(r'<br\s*/?>')
        elif p=='&': buf.append(r'&(?:amp;)?')
        else: buf.append(re.escape(p).replace(r'\>\<',r'>\s*<'))
    return '>\s*'+''.join(buf)+r'\s*<'

todo=[(i,items[i],RU[items[i]]) for i in range(len(items)) if items[i] in RU]
unused=[k for k in RU if k not in set(items)]
print('RU entries without an EN match:',len(unused))
for k in unused: print('  STALE',k[:90])
todo.sort(key=lambda t:-len(t[1]))
done=0; missed=[]
for i,en,ru in todo:
    pat=re.compile(mkpat(en))
    ms=list(pat.finditer(raw))
    if not ms: missed.append((i,en[:70])); continue
    for m in reversed(ms):
        gt=m.start(); lt_close=m.end()-1
        lt=raw.rfind('<',0,gt)
        open_tag=raw[lt:gt+1]
        if open_tag.startswith('</') or ' lang="' in open_tag: continue
        tag=re.match(r'<([a-z0-9]+)',open_tag).group(1)
        if tag not in leaftags.get(en,set()): continue
        cm=re.match(r'</([a-z0-9]+)>',raw[lt_close:])
        if not cm or cm.group(1)!=tag: continue
        close_tag=cm.group(0)
        en_inner=raw[gt+1:lt_close]
        en_open=open_tag[:-1]+' lang="en">'
        ru_open=open_tag[:-1]+' lang="ru">'
        block=en_open+en_inner+close_tag+ru_open+ru+close_tag
        raw=raw[:lt]+block+raw[lt_close+len(close_tag):]
        done+=1
print('replaced',done,'missed',len(missed))
for x in missed: print('MISS',x)

# ---- 3. contact block (attribute order differs from bs4) — manual
en412=raw[raw.find('<a href="https://wa.me/16472207402"'):]
seg_start=raw.rfind('<p class="muted" style="margin:0;line-height:1.7;">',0,raw.find('<a href="https://wa.me/16472207402"'))
seg_end=raw.find('</p>',seg_start)+4
seg=raw[seg_start:seg_end]
ru_seg=seg.replace('<p class="muted" style="margin:0;line-height:1.7;">','<p class="muted" style="margin:0;line-height:1.7;" lang="ru">').replace('— WhatsApp preferred, Telegram also fine','— лучше WhatsApp, Telegram тоже подойдёт')
en_seg=seg.replace('<p class="muted" style="margin:0;line-height:1.7;">','<p class="muted" style="margin:0;line-height:1.7;" lang="en">')
raw=raw[:seg_start]+en_seg+ru_seg+raw[seg_end:]

# ---- 4. CSS + switch + JS
css='''<!-- LANG-CSS -->
<style>
html[data-lang="en"] [lang="ru"],html:not([data-lang]) [lang="ru"]{display:none!important}
html[data-lang="ru"] [lang="en"]{display:none!important}
.lang-switch{position:fixed;top:14px;right:14px;z-index:1000;display:flex;gap:4px;background:#151317;border:1px solid #3a3a26;border-radius:999px;padding:4px;box-shadow:0 2px 10px rgba(0,0,0,.25)}
.lang-switch button{appearance:none;border:0;background:transparent;color:#9E9789;font:600 12px/1 "Golos Text",system-ui,sans-serif;letter-spacing:.08em;padding:8px 12px;border-radius:999px;cursor:pointer}
.lang-switch button[aria-pressed="true"]{background:#C1DB34;color:#151317}
.lang-switch button:hover{color:#F3E9D2}
.lang-switch button[aria-pressed="true"]:hover{color:#151317}
@media print{.lang-switch{display:none!important}}
</style>
<!-- /LANG-CSS -->
'''
switch='''<!-- LANG-SWITCH -->
<div class="lang-switch" role="group" aria-label="Language / Язык">
  <button type="button" data-set="en" aria-pressed="true">EN</button>
  <button type="button" data-set="ru" aria-pressed="false">RU</button>
</div>
<script>
(function(){
  var root=document.documentElement;
  function apply(l){
    root.setAttribute('data-lang',l); root.setAttribute('lang',l);
    document.querySelectorAll('.lang-switch button').forEach(function(b){b.setAttribute('aria-pressed',String(b.dataset.set===l));});
    document.title=(l==='ru')?'Sweet Pepper — Гайд по стилю (черновик)':'Sweet Pepper — Style Guide (Draft)';
    
  }
  // Default = the system / browser language (any 'ru' in the preference list -> RU, else EN).
  // ?lang=ru|en in the URL overrides it; a click on the toggle is remembered for this tab only (sessionStorage),
  // so a fresh visit always comes back to the system language.
  function systemLang(){
    var list=(navigator.languages&&navigator.languages.length)?navigator.languages:[navigator.language||navigator.userLanguage||''];
    for(var i=0;i<list.length;i++){ if(String(list[i]).toLowerCase().indexOf('ru')===0) return 'ru'; }
    return 'en';
  }
  var q=new URLSearchParams(location.search).get('lang'), saved=null;
  try{saved=sessionStorage.getItem('sp-guide-lang');}catch(e){}
  var l=(q==='ru'||q==='en')?q:(saved||systemLang());
  apply(l);
  document.querySelectorAll('.lang-switch button').forEach(function(b){b.addEventListener('click',function(){apply(b.dataset.set);try{sessionStorage.setItem('sp-guide-lang',b.dataset.set);}catch(e){}});});
})();
</script>
<!-- /LANG-SWITCH -->
'''

copysvg='''<!-- COPY-SVG -->
<style>
.lstage{position:relative}
.copy-svg{position:absolute;top:10px;right:10px;display:inline-flex;align-items:center;gap:8px;appearance:none;border:1px solid var(--hair);background:var(--paper);color:var(--ash);font:600 11px/1 "Golos Text",system-ui,sans-serif;letter-spacing:.04em;padding:8px 8px;border-radius:999px;cursor:pointer;opacity:.85;transition:opacity .15s,background .15s,color .15s}
.copy-svg svg{width:12px;height:12px;fill:currentColor;display:block}
.copy-svg:hover{opacity:1;background:#151317;color:#F3E9D2;border-color:#151317}
.copy-svg.done{background:#C1DB34;color:#151317;border-color:#C1DB34;opacity:1}
.lstage.dark .copy-svg{background:#201E22;color:#9E9789;border-color:#3a3a26}
.lstage.dark .copy-svg:hover{background:#F3E9D2;color:#151317;border-color:#F3E9D2}
@media print{.copy-svg{display:none!important}}
</style>
<script>
(function(){
  var L={en:{copy:'Copy SVG',done:'Copied',fail:'Copy failed'},ru:{copy:'Копировать SVG',done:'Скопировано',fail:'Не удалось'}};
  var ICON='<svg viewBox="0 0 16 16" aria-hidden="true"><path d="M5.5 1.5h7a2 2 0 0 1 2 2v7h-2v-7h-7z"/><rect x="1.5" y="5" width="9.5" height="9.5" rx="1.6"/></svg>';
  function t(k){var l=document.documentElement.getAttribute('data-lang')||'en';return (L[l]||L.en)[k];}
  function serialize(svg){
    var c=svg.cloneNode(true);
    if(!c.getAttribute('xmlns')) c.setAttribute('xmlns','http://www.w3.org/2000/svg');
    c.removeAttribute('style'); c.removeAttribute('class');
    return new XMLSerializer().serializeToString(c);
  }
  function copyText(txt){
    if(navigator.clipboard&&window.isSecureContext) return navigator.clipboard.writeText(txt);
    return new Promise(function(res,rej){var ta=document.createElement('textarea');ta.value=txt;ta.style.position='fixed';ta.style.opacity='0';document.body.appendChild(ta);ta.select();try{document.execCommand('copy')?res():rej();}catch(e){rej(e);}document.body.removeChild(ta);});
  }
  var buttons=[];
  document.querySelectorAll('.logo-gallery figure.lstage').forEach(function(fig){
    var svg=fig.querySelector(':scope > svg'); if(!svg) return;
    var b=document.createElement('button'); b.type='button'; b.className='copy-svg';
    b.innerHTML=ICON+'<span></span>'; b.setAttribute('aria-label','Copy SVG');
    b.addEventListener('click',function(){
      copyText(serialize(svg)).then(function(){b.classList.add('done');b.lastChild.textContent=t('done');},function(){b.lastChild.textContent=t('fail');})
      .then(function(){setTimeout(function(){b.classList.remove('done');b.lastChild.textContent=t('copy');},1600);});
    });
    fig.appendChild(b); buttons.push(b);
  });
  function relabel(){buttons.forEach(function(b){if(!b.classList.contains('done')) b.lastChild.textContent=t('copy');});}
  relabel();
  new MutationObserver(relabel).observe(document.documentElement,{attributes:true,attributeFilter:['data-lang']});
})();
</script>
<!-- /COPY-SVG -->
'''

raw=raw.replace('</style>','</style>\n'+css,1)
shell=open(os.path.join(ROOT,'tools/i18n/mobile-shell.html')).read()
raw=raw.replace('</body>',copysvg+shell+'</body>',1)
raw=raw.replace('<body>','<body>\n'+switch,1)
raw=re.sub(r'<html lang="en" data-lang="en">','<html lang="en">',raw,count=1)
open(SRC,'w').write(raw)
print('written',len(raw))
