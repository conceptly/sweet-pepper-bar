/* Sweet Pepper style guide — in-page edit mode.
   Loaded by style-guide.html only when the URL carries ?edit (e.g. style-guide.html?edit or ?lang=ru&edit).
   Every EN/RU text block (an element with a lang attribute) becomes click-to-edit; Save patches exactly those
   blocks into the file on the server through style-guide-save.php. Layout, SVGs, swatches, tables' structure and
   anything without a lang attribute stay locked. Nothing here is ever written into the file: Save asks the server for
   the current file (from GitHub, or the local copy), replaces the inner HTML of the changed blocks — each verified
   against the text this page loaded — and posts the result back; the server commits it to GitHub (the host's cron
   deploys it minutes later) or writes it locally, depending on style-guide-config.php. */
(function () {
  'use strict';
  var SAVE_URL = 'style-guide-save.php';
  var EXCLUDE = '#m-home,#m-top,#m-bottom,.lang-switch,#sp-edit-bar';
  var html = document.documentElement;

  /* ---- 1. Collect the editable blocks (document order == source order) ---- */
  var els = [].slice.call(document.querySelectorAll('body [lang]')).filter(function (el) { return !el.closest(EXCLUDE); });
  var orig = [], origText = [], current = null, busy = false;
  function norm(s) { return s.replace(/\s+/g, ' ').trim(); }
  function clean(h) {
    return h.replace(/<(\/?)b>/g, '<$1strong>').replace(/<(\/?)i>/g, '<$1em>')
      .replace(/\s(?:contenteditable|spellcheck|data-sp-n)="[^"]*"/g, '')
      .replace(/(?:\s|&nbsp;|<br\s*\/?>)+$/, '');            // trailing breaks are typing scaffolding, not content
  }
  els.forEach(function (el, n) {
    orig[n] = el.innerHTML; origText[n] = norm(el.textContent);
    el.setAttribute('contenteditable', 'true'); el.setAttribute('spellcheck', 'true');
    el.dataset.spN = n; el.classList.add('sp-ed');
  });
  html.classList.add('sp-editing');

  /* ---- 2. Toolbar ---- */
  var css = document.createElement('style');
  css.textContent =
    'html.sp-editing .sp-ed{outline:1px dashed rgba(227,67,20,.5);outline-offset:3px;cursor:text;border-radius:2px}' +
    'html.sp-editing .sp-ed[lang="ru"]{outline-color:rgba(115,125,58,.75)}' +
    'html.sp-editing .sp-ed:hover{outline-style:solid}' +
    'html.sp-editing .sp-ed:focus{outline:2px solid #E34314;box-shadow:0 0 0 6px rgba(227,67,20,.1)}' +
    'html.sp-editing .sp-ed[lang="ru"]:focus{outline-color:#737D3A;box-shadow:0 0 0 6px rgba(115,125,58,.14)}' +
    'html.sp-editing .sp-ed.sp-changed{background:rgba(255,237,0,.25)}' +
    'html.sp-editing .sp-ed:empty{min-width:2em;min-height:1em}' +
    'html.sp-editing .sp-ed a{cursor:text}' +
    'html.sp-editing[data-lang="both"] .sp-ed::before{content:attr(lang);text-transform:uppercase;font:700 9px/1 "Golos Text",system-ui,sans-serif;letter-spacing:.08em;color:#9E9789;border:1px solid currentColor;border-radius:3px;padding:1px 3px;margin-right:6px;vertical-align:middle;user-select:none}' +
    '#sp-edit-bar{position:fixed;left:50%;bottom:16px;transform:translateX(-50%);z-index:1001;display:flex;flex-wrap:wrap;align-items:center;justify-content:center;gap:8px 12px;max-width:calc(100vw - 32px);background:#151317;color:#F3E9D2;border:1px solid #3a3a26;border-radius:12px;padding:10px 14px;box-shadow:0 6px 24px rgba(0,0,0,.3);font:500 13px/1.3 "Golos Text",system-ui,sans-serif}' +
    '#sp-edit-bar .sp-title{font-family:Molot,"Golos Text",sans-serif;text-transform:uppercase;letter-spacing:.08em;color:#FFF689}' +
    '#sp-edit-bar .sp-lang{display:inline-flex;align-items:center;gap:6px;color:#9E9789}' +
    '#sp-edit-bar .sp-lang i{display:inline-block;width:10px;height:10px;border:2px dashed rgba(227,67,20,.9);border-radius:2px}' +
    '#sp-edit-bar .sp-lang i.ru{border-color:#9aa457}' +
    '#sp-edit-bar #sp-count{color:#9E9789}#sp-edit-bar #sp-count.on{color:#FFF689}' +
    '#sp-edit-bar label{display:inline-flex;align-items:center;gap:6px;cursor:pointer;color:#9E9789}' +
    '#sp-edit-bar input[type=password]{width:120px;background:#201E22;color:#F3E9D2;border:1px solid #3a3a26;border-radius:8px;padding:6px 8px;font:inherit}' +
    '#sp-edit-bar button{appearance:none;border:1px solid #3a3a26;background:#201E22;color:#F3E9D2;font:600 12px/1 "Golos Text",system-ui,sans-serif;letter-spacing:.04em;padding:8px 12px;border-radius:999px;cursor:pointer}' +
    '#sp-edit-bar button:hover{border-color:#9E9789}#sp-edit-bar button:disabled{opacity:.45;cursor:default}' +
    '#sp-edit-bar button.primary{background:#C1DB34;color:#151317;border-color:#C1DB34}#sp-edit-bar button.primary:hover{background:#D4E671}' +
    '#sp-edit-bar .sp-help{flex-basis:100%;text-align:center;color:#9E9789;font-size:11px;letter-spacing:.02em}' +
    '#sp-toast{position:fixed;left:50%;bottom:92px;transform:translateX(-50%);z-index:1002;max-width:calc(100vw - 32px);background:#C1DB34;color:#151317;border-radius:10px;padding:10px 14px;font:600 13px/1.4 "Golos Text",system-ui,sans-serif;box-shadow:0 4px 16px rgba(0,0,0,.25);transition:opacity .2s}' +
    '#sp-toast.err{background:#E34314;color:#F3E9D2}' +
    '@media print{#sp-edit-bar,#sp-toast{display:none!important}html.sp-editing .sp-ed{outline:none;background:none}}';
  document.head.appendChild(css);

  var bar = document.createElement('div'); bar.id = 'sp-edit-bar';
  bar.innerHTML =
    '<span class="sp-title">Editing</span>' +
    '<span class="sp-lang"><i></i>EN <i class="ru"></i>RU</span>' +
    '<span id="sp-count">no changes</span>' +
    '<label><input type="checkbox" id="sp-both"> show both languages</label>' +
    '<button type="button" id="sp-revert" disabled>Revert block</button>' +
    '<input type="password" id="sp-pass" placeholder="password" autocomplete="current-password" aria-label="Save password">' +
    '<button type="button" id="sp-save" class="primary">Save</button>' +
    '<button type="button" id="sp-exit">Exit</button>' +
    '<span class="sp-help">Click any text to edit · ⌘B bold · ⌘I italic · ⌘K link · Enter = line break · paste is plain text · ⌘S save</span>';
  document.body.appendChild(bar);
  var $ = function (id) { return document.getElementById(id); };
  var countEl = $('sp-count'), bothBox = $('sp-both'), revertBtn = $('sp-revert'), passInput = $('sp-pass'), saveBtn = $('sp-save');
  try { var stored = sessionStorage.getItem('sp-guide-pass'); if (stored) passInput.value = stored; } catch (e) { }

  var toastEl = null, toastTimer = null;
  function toast(msg, isErr) {
    if (!toastEl) { toastEl = document.createElement('div'); toastEl.id = 'sp-toast'; toastEl.setAttribute('role', 'status'); document.body.appendChild(toastEl); }
    toastEl.textContent = msg; toastEl.className = isErr ? 'err' : ''; toastEl.style.opacity = '1';
    clearTimeout(toastTimer); toastTimer = setTimeout(function () { toastEl.style.opacity = '0'; }, isErr ? 9000 : 4000);
  }

  /* ---- 3. Change tracking ---- */
  function isChanged(n) { return clean(els[n].innerHTML) !== clean(orig[n]); }
  function refresh(el) {
    var n = +el.dataset.spN; el.classList.toggle('sp-changed', isChanged(n));
    var c = 0; els.forEach(function (_, i) { if (isChanged(i)) c++; });
    countEl.textContent = c ? c + ' changed' : 'no changes'; countEl.classList.toggle('on', c > 0);
    revertBtn.disabled = !(current && isChanged(+current.dataset.spN));
    return c;
  }
  function refreshAll() { els.forEach(refresh); }
  function dirtyCount() { var c = 0; els.forEach(function (_, i) { if (isChanged(i)) c++; }); return c; }

  /* ---- 4. Twin peek: focusing a block reveals its translation next to it ---- */
  function twinOf(el) {
    var l = el.getAttribute('lang'), t = el.tagName, s;
    s = el.nextElementSibling; if (s && s.tagName === t && s.hasAttribute('lang') && s.getAttribute('lang') !== l) return s;
    s = el.previousElementSibling; if (s && s.tagName === t && s.hasAttribute('lang') && s.getAttribute('lang') !== l) return s;
    return null;
  }
  var twinTimer = null;
  function showTwin(el) {
    var tw = twinOf(el); if (!tw || bothBox.checked) return;
    tw.style.setProperty('display', getComputedStyle(el).display, 'important'); tw.classList.add('sp-twin');
  }
  function hideTwins() {
    var f = document.activeElement;
    document.querySelectorAll('.sp-twin').forEach(function (tw) {
      var partner = twinOf(tw);
      if (f === tw || f === partner) return;
      tw.style.removeProperty('display'); tw.classList.remove('sp-twin');
    });
  }
  document.addEventListener('focusin', function (e) {
    var el = e.target.closest && e.target.closest('.sp-ed'); if (!el) return;
    current = el; clearTimeout(twinTimer); hideTwins(); showTwin(el); refresh(el);
  });
  document.addEventListener('focusout', function (e) {
    if (!(e.target.closest && e.target.closest('.sp-ed'))) return;
    clearTimeout(twinTimer); twinTimer = setTimeout(hideTwins, 150);
  });

  /* ---- 5. Show both languages (data-lang="both" matches neither hide rule) ---- */
  var prevLang = 'en';
  function syncPill() {
    var l = html.getAttribute('data-lang');
    document.querySelectorAll('.lang-switch button').forEach(function (b) { b.setAttribute('aria-pressed', String(b.dataset.set === l)); });
  }
  bothBox.addEventListener('change', function () {
    if (bothBox.checked) { prevLang = html.getAttribute('data-lang') === 'ru' ? 'ru' : 'en'; html.setAttribute('data-lang', 'both'); hideTwins(); }
    else html.setAttribute('data-lang', prevLang);
    syncPill();
  });
  new MutationObserver(function () { if (html.getAttribute('data-lang') !== 'both') bothBox.checked = false; })
    .observe(html, { attributes: true, attributeFilter: ['data-lang'] });

  /* ---- 6. Editing behaviour ---- */
  document.addEventListener('input', function (e) { var el = e.target.closest && e.target.closest('.sp-ed'); if (el) refresh(el); });
  document.addEventListener('paste', function (e) {
    if (!(e.target.closest && e.target.closest('.sp-ed'))) return;
    e.preventDefault();
    var t = (e.clipboardData || window.clipboardData).getData('text/plain');
    if (t) document.execCommand('insertText', false, t);
  });
  document.addEventListener('click', function (e) {
    var a = e.target.closest && e.target.closest('a');
    if (a && a.closest('.sp-ed')) e.preventDefault();       // links are text while editing (⌘K edits the URL)
  });
  function editLink() {
    var sel = window.getSelection(); if (!sel.rangeCount) return;
    var node = sel.anchorNode, host = node && (node.nodeType === 1 ? node : node.parentElement);
    var block = host && host.closest('.sp-ed'); if (!block) return;
    var a = host.closest('a');
    if (a && block.contains(a)) {
      var u = prompt('Link URL (leave empty to remove the link)', a.getAttribute('href') || '');
      if (u === null) return;
      if (u === '') { while (a.firstChild) a.parentNode.insertBefore(a.firstChild, a); a.parentNode.removeChild(a); }
      else a.setAttribute('href', u);
    } else {
      if (sel.isCollapsed) { toast('Select the text you want to link first', true); return; }
      var url = prompt('Link URL'); if (!url) return;
      document.execCommand('createLink', false, url);
      var n2 = sel.anchorNode, h2 = n2 && (n2.nodeType === 1 ? n2 : n2.parentElement), a2 = h2 && h2.closest('a');
      if (a2 && /^https?:/i.test(url)) { a2.setAttribute('target', '_blank'); a2.setAttribute('rel', 'noopener'); }
    }
    refresh(block);
  }
  function lineBreak(el) {                                   // Enter = <br>, never a new paragraph (that is a layout change)
    var sel = window.getSelection(); if (!sel.rangeCount) return;
    var r = sel.getRangeAt(0); if (!el.contains(r.startContainer)) return;
    r.deleteContents();
    var br = document.createElement('br'); r.insertNode(br);
    if (!br.nextSibling || (br.nextSibling.nodeType === 3 && !br.nextSibling.data)) br.parentNode.insertBefore(document.createElement('br'), br.nextSibling); // trailing break needs a twin to show
    r.setStartAfter(br); r.collapse(true); sel.removeAllRanges(); sel.addRange(r);
  }
  document.addEventListener('keydown', function (e) {
    var meta = e.metaKey || e.ctrlKey;
    if (meta && (e.key === 's' || e.key === 'S')) { e.preventDefault(); save(); return; }
    var el = e.target.closest && e.target.closest('.sp-ed'); if (!el) return;
    if (e.key === 'Enter') { e.preventDefault(); lineBreak(el); refresh(el); }
    else if (meta && (e.key === 'k' || e.key === 'K')) { e.preventDefault(); editLink(); }
  });
  revertBtn.addEventListener('click', function () {
    if (!current) return; var n = +current.dataset.spN; current.innerHTML = orig[n]; refresh(current); current.focus();
  });
  window.addEventListener('beforeunload', function (e) { if (dirtyCount() > 0 && !leaving) { e.preventDefault(); e.returnValue = ''; } });
  var leaving = false;
  $('sp-exit').addEventListener('click', function () {
    if (dirtyCount() > 0 && !confirm('Discard unsaved changes?')) return;
    leaving = true; var u = new URL(location.href); u.searchParams.delete('edit'); location.href = u.href;
  });

  /* ---- 7. Patch the source file: find the n-th lang-tagged element, verify, replace its inner HTML ---- */
  function mask(t) {
    return t.replace(/<script\b[\s\S]*?<\/script>|<style\b[\s\S]*?<\/style>|<!--[\s\S]*?-->/g, function (m) { return new Array(m.length + 1).join(' '); });
  }
  function findClose(m, tag, from) {
    var re = new RegExp('<(\\/?)' + tag + '(?=[\\s>\\/])[^>]*>', 'gi'); re.lastIndex = from;
    var depth = 1, x;
    while ((x = re.exec(m))) { depth += x[1] ? -1 : 1; if (!depth) return x.index; }
    throw new Error('Unbalanced <' + tag + '> in the file');
  }
  function patch(src, edits) {
    var m = mask(src), re = /<([a-zA-Z0-9]+)(?=[\s>\/])[^>]*?\slang="(en|ru)"[^>]*>/g, list = [], x;
    while ((x = re.exec(m))) {
      if (x[1].toLowerCase() === 'html') continue;
      list.push({ tag: x[1].toLowerCase(), lang: x[2], end: x.index + x[0].length });
    }
    if (list.length !== els.length) throw new Error('Structure mismatch: the server file has ' + list.length + ' text blocks, this page has ' + els.length + '. Reload the page and redo your edits.');
    var tmp = document.createElement('div');
    var jobs = edits.map(function (e) {
      var it = list[e.n];
      if (!it || it.tag !== e.tag || it.lang !== e.lang) throw new Error('Block ' + e.n + ' does not line up with the server file. Reload and redo.');
      var close = findClose(m, it.tag, it.end);
      tmp.innerHTML = src.slice(it.end, close);
      if (norm(tmp.textContent) !== e.text) throw new Error('Block ' + e.n + ' (' + e.tag + '/' + e.lang + ') differs from the server copy — someone else may have saved. Reload and redo.');
      return { from: it.end, to: close, html: e.html };
    }).sort(function (a, b) { return b.from - a.from; });
    jobs.forEach(function (j) { src = src.slice(0, j.from) + j.html + src.slice(j.to); });
    return src;
  }

  /* ---- 8. Save ---- */
  function setBusy(b) { busy = b; saveBtn.disabled = b; saveBtn.textContent = b ? 'Saving…' : 'Save'; }
  function save() {
    if (busy) return;
    var edits = [];
    els.forEach(function (el, n) {
      if (!isChanged(n)) return;
      edits.push({ n: n, tag: el.tagName.toLowerCase(), lang: el.getAttribute('lang'), text: origText[n], html: clean(el.innerHTML) });
    });
    if (!edits.length) { toast('Nothing to save'); return; }
    var pass = passInput.value;
    if (!pass) { toast('Enter the password first', true); passInput.focus(); return; }
    setBusy(true);
    function call(body) {                                   // every call carries the password; the server holds the GitHub token
      return fetch(SAVE_URL, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(body) })
        .then(function (r) {
          return r.json().catch(function () { return { error: 'Server answered ' + r.status + ' without JSON — is style-guide-save.php uploaded next to the guide, and does the host run PHP?' }; })
            .then(function (j) { if (!r.ok || !j.ok) throw new Error(j.error || ('Request failed (' + r.status + ')')); return j; });
        });
    }
    call({ action: 'fetch', password: pass })
      .then(function (o) {
        var patched = patch(o.html, edits);
        return call({ action: 'save', password: pass, sha: o.sha, html: patched, blocks: edits.length });
      })
      .then(function (j) {
        edits.forEach(function (e) { orig[e.n] = els[e.n].innerHTML; origText[e.n] = norm(els[e.n].textContent); });
        refreshAll();
        try { sessionStorage.setItem('sp-guide-pass', pass); } catch (e) { }
        var what = edits.length + ' block' + (edits.length > 1 ? 's' : '');
        toast(j.mode === 'github'
          ? 'Committed ' + what + ' to GitHub' + (j.commit ? ' (' + j.commit + ')' : '') + ' · live on the site in about 5 minutes'
          : 'Saved ' + what + (j.backup ? ' · backup ' + j.backup : ''));
      })
      .catch(function (err) {
        if (/password/i.test(err.message)) { try { sessionStorage.removeItem('sp-guide-pass'); } catch (e) { } }
        toast(err.message, true);
      })
      .then(function () { setBusy(false); });
  }
  saveBtn.addEventListener('click', save);

  window.__spEdit = { els: els, patch: patch, clean: clean, count: dirtyCount }; // for checks in the console
  toast(els.length + ' text blocks are editable · ' + (document.querySelector('.lang-switch') ? 'use the EN/RU pill to switch language' : ''));
})();
