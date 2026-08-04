<?php
/**
 * edit-mode.php — Page One inline preview editor (runtime markers).
 *
 * Included by includes/head.php. Emits an in-browser editor ONLY when the page
 * is served on a preview host (preview-<slug>.pageone.cloud) AND ?edit=1 is set.
 * On the launch/production domain it emits NOTHING, so production output is
 * byte-identical. Edits are plain-text only and post a message to the parent
 * Design Portal window, which saves via PATCH /content (occurrence-indexed).
 *
 * Expects config.php scalars in scope (it is included from head.php, which runs
 * after config.php). All references are guarded so missing vars never fatal.
 */

$__p1_host = $_SERVER['HTTP_HOST'] ?? '';
$__p1_isPreview = (bool) preg_match('/^preview-[a-z0-9-]+\.pageone\.cloud$/i', $__p1_host);

if (!empty($_GET['edit']) && $__p1_isPreview):

    // Page file relative to docroot, matching the /content extractor's keys.
    $__p1_pageFile = ltrim($_SERVER['SCRIPT_NAME'] ?? '', '/');

    // Config scalars / NAP interpolated at render time. Two tiers:
    //   HARD — sensitive identifiers (phone/email/license/street/zip). A bare
    //          atom (the whole element is essentially this value, label+punct
    //          aside) must never be inline-editable.
    //   SOFT — brand/place mentions (name/tagline/owner/domain/city/state).
    //          Locked ONLY when the element's text IS exactly this value;
    //          ordinary prose that merely mentions the brand or city stays
    //          editable. The server's PHP/script mask is the backstop for any
    //          interpolated value that slips through.
    $__p1_norm = function ($v) { return (is_string($v) && trim($v) !== '') ? trim($v) : null; };
    $__p1_hard = [];
    foreach ([
        $phone ?? null, $phoneSecondary ?? null,
        $email ?? null, $contactEmail ?? null,
        $licenseNumber ?? null,
        ($address['street'] ?? null), ($address['zip'] ?? null),
    ] as $__v) { if ($__n = $__p1_norm($__v)) $__p1_hard[] = $__n; }
    $__p1_soft = [];
    foreach ([
        $siteName ?? null, $tagline ?? null, $ownerName ?? null, $domain ?? null,
        ($address['city'] ?? null), ($address['state'] ?? null),
    ] as $__v) { if ($__n = $__p1_norm($__v)) $__p1_soft[] = $__n; }
    $__p1_hard = array_values(array_unique($__p1_hard));
    $__p1_soft = array_values(array_unique($__p1_soft));
?>
<script>
(function () {
  "use strict";
  var PAGE_FILE = <?php echo json_encode($__p1_pageFile); ?>;
  // Only values >= 4 chars participate, to avoid over-locking on short tokens
  // (state codes, small numbers).
  function atLeast4(v) { return v && v.length >= 4; }
  var HARD = (<?php echo json_encode($__p1_hard); ?> || []).filter(atLeast4);
  var SOFT = (<?php echo json_encode($__p1_soft); ?> || []).filter(atLeast4);

  var SELECTOR = "h1,h2,h3,h4,h5,h6,p,li,blockquote,figcaption,span,em,strong";
  // Ancestors that make an element off-limits: structure, links, CTAs, forms,
  // and PHP-loop content. [data-p1-dynamic] is stamped by the build on loop
  // containers (service cards, reviews, FAQ, ticker, blog) — their text comes
  // from arrays the server can't match against, so it must never be marked
  // editable. The marker sits on the loop container, not the section, so the
  // section's own headings/intro prose stay editable.
  var SKIP_ANCESTOR = "nav,header,footer,a,button,form,select,option,textarea,script,style,[data-p1-dynamic],[data-p1-editable]";

  function hasElementChild(el) {
    for (var n = el.firstChild; n; n = n.nextSibling) if (n.nodeType === 1) return true;
    return false;
  }
  function nonSpaceLen(s) { return s.replace(/\s+/g, "").length; }
  // Lock an element only when its text IS a dynamic value, not when prose merely
  // mentions one. SOFT (brand/place): exact standalone match. HARD (NAP): also
  // locked when the atom DOMINATES the text (>=60% of non-space chars), i.e. a
  // bare phone/email/license/address dressed in only a label or punctuation.
  function isLockedNap(text) {
    for (var i = 0; i < SOFT.length; i++) if (text === SOFT[i]) return true;
    for (var j = 0; j < HARD.length; j++) {
      if (text === HARD[j]) return true;
      if (text.indexOf(HARD[j]) !== -1 &&
          nonSpaceLen(HARD[j]) / Math.max(1, nonSpaceLen(text)) >= 0.6) return true;
    }
    return false;
  }
  function isEditable(el) {
    if (el.closest(SKIP_ANCESTOR)) return false;   // nav/footer/links/CTAs/NAP wrappers
    if (hasElementChild(el)) return false;          // leaf text only (no inner markup)
    var t = (el.innerText || "").replace(/\s+/g, " ").trim();
    if (t.length < 2) return false;
    if (isLockedNap(t)) return false;               // standalone NAP / bare atom
    return true;
  }

  var editables = [];

  // Occurrence index = how many times origText already appears, as a substring,
  // in the visible text BEFORE this element (walking <main> in document order,
  // skipping script/style). This mirrors the server, which counts text-position
  // occurrences in the masked page source — so the Nth here == the Nth there,
  // even for non-editable duplicates (links, NAP, icon-adjacent text).
  function occurrenceIndex(el, origText) {
    var root = document.querySelector("main") || document.body;
    if (!root.contains(el)) root = document.body;
    var walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null);
    var before = "", node;
    while ((node = walker.nextNode())) {
      if (node.parentElement && node.parentElement.closest("script,style")) continue;
      if (el.contains(node)) break; // reached the edited element
      before += node.nodeValue;
    }
    var count = 0, from = 0, i;
    while ((i = before.indexOf(origText, from)) !== -1) { count++; from = i + origText.length; }
    return count;
  }

  // Inline markup the user may add via Ctrl+B / Ctrl+I / Enter. The server
  // re-sanitizes to exactly this subset and drops everything else, so this is a
  // hint, not a trust boundary.
  var ALLOWED_MARKUP = /<(?:br|em|strong|i|b)\b/i;
  function collapseWs(s) { return s.replace(/\s+/g, " "); }

  function onPaste(e) {
    e.preventDefault();
    var t = (e.clipboardData || window.clipboardData).getData("text/plain");
    document.execCommand("insertText", false, collapseWs(t));
  }
  function onKeydown(e) {
    // Enter inserts a line break, not a block element, so markup stays inline.
    if (e.key === "Enter") {
      e.preventDefault();
      document.execCommand("insertHTML", false, "<br>");
    }
  }
  function onBlur(e) {
    var el = e.target;
    var orig = el.__p1_orig;
    var plain = collapseWs(el.innerText || "").trim();
    var hasMarkup = ALLOWED_MARKUP.test(el.innerHTML);
    var hadMarkup = el.__p1_hadMarkup;
    el.__p1_hadMarkup = hasMarkup;
    if (!hasMarkup) {
      // Plain edit — strip any stray nodes the browser slipped in.
      if (el.innerText !== plain) el.textContent = plain;
    }
    if (!plain) return;                              // emptied — ignore
    if (!hasMarkup && !hadMarkup && plain === orig) return; // genuine no-op
    var msg = {
      source: "p1-inline-editor",
      action: "edit",
      pageFile: PAGE_FILE,
      text: orig,                       // original source text (match target)
      newText: plain,                   // plain text (fallback + revert signal)
      occurrenceIndex: occurrenceIndex(el, orig),
    };
    // Only carry markup when present; the server sanitizes it before write.
    if (hasMarkup) msg.html = collapseWs(el.innerHTML).trim();
    try { window.parent.postMessage(msg, "*"); } catch (err) {}
  }

  function mark(el) {
    el.__p1_orig = (el.innerText || "").replace(/\s+/g, " ").trim();
    el.__p1_hadMarkup = false;
    el.setAttribute("data-p1-editable", "1");
    // Rich (not plaintext-only) so Ctrl+B / Ctrl+I produce inline markup; paste
    // and Enter are tamed so only the allowed subset can appear.
    el.contentEditable = "true";
    el.addEventListener("paste", onPaste);
    el.addEventListener("keydown", onKeydown);
    el.addEventListener("blur", onBlur);
    el.spellcheck = false;
    editables.push(el);
  }

  function init() {
    var nodes = document.querySelectorAll(SELECTOR);
    for (var i = 0; i < nodes.length; i++) if (isEditable(nodes[i])) mark(nodes[i]);

    var style = document.createElement("style");
    style.textContent =
      '[data-p1-editable]{outline:1px dashed rgba(6,182,212,.45);outline-offset:2px;cursor:text;transition:outline .15s;}' +
      '[data-p1-editable]:hover{outline:2px dashed rgba(6,182,212,.9);}' +
      '[data-p1-editable]:focus{outline:2px solid #06b6d4;background:rgba(6,182,212,.06);}' +
      '#p1-edit-badge{position:fixed;bottom:12px;left:12px;z-index:2147483647;background:#06b6d4;color:#fff;' +
      'font:600 12px/1 system-ui,sans-serif;padding:7px 11px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.25);pointer-events:none;}';
    document.head.appendChild(style);

    var badge = document.createElement("div");
    badge.id = "p1-edit-badge";
    badge.textContent = "Edit mode — click prose to edit · Ctrl+B / Ctrl+I · Enter = line break";
    document.body.appendChild(badge);

    try {
      window.parent.postMessage({ source: "p1-inline-editor", action: "ready", pageFile: PAGE_FILE, count: editables.length }, "*");
    } catch (e) {}
  }

  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", init);
  else init();
})();
</script>
<?php endif; ?>
