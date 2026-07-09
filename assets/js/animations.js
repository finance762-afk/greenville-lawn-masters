/* ============================================
   Page One Insights — Animations
   Directional scroll reveals + fail-open safety net
   (design-system.md C10.5)

   main.js owns the legacy [data-animate] observer.
   This file owns the .reveal-* directional system and the
   safety-net timeout that covers BOTH.
   ============================================ */

(function () {
  'use strict';

  /* First statement, per spec. head.php already set this inline so the gated
     opacity:0 rules apply before first paint; this is the idempotent backstop
     for any page that somehow renders without that inline script. */
  document.documentElement.classList.add('js-anim');

  var REVEAL_SELECTOR = '.reveal-up, .reveal-down, .reveal-left, .reveal-right, .reveal-scale';

  function revealAll(nodes) {
    Array.prototype.forEach.call(nodes, function (el) { el.classList.add('revealed'); });
  }

  function initReveals() {
    var targets = document.querySelectorAll(REVEAL_SELECTOR);

    /* No IntersectionObserver (or nothing to reveal): show everything now
       rather than leaving the page hidden behind the js-anim gate. */
    if (!('IntersectionObserver' in window)) {
      revealAll(targets);
      return;
    }

    var observer = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('revealed');
        observer.unobserve(entry.target);
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

    Array.prototype.forEach.call(targets, function (el) { observer.observe(el); });

    /* Safety net (MANDATORY). Two seconds after DOMContentLoaded, force every
       still-hidden element visible. Covers observer callbacks that never fire —
       zero-height parents, display:none ancestors, print, headless crawlers. */
    window.setTimeout(function () {
      revealAll(document.querySelectorAll(
        '[data-animate]:not(.animated):not(.revealed), ' +
        '.reveal-up:not(.revealed), .reveal-down:not(.revealed), ' +
        '.reveal-left:not(.revealed), .reveal-right:not(.revealed), ' +
        '.reveal-scale:not(.revealed)'
      ));
    }, 2000);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initReveals);
  } else {
    initReveals();
  }
})();
