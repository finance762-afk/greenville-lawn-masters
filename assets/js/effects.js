/* ============================================
   Page One Insights — Effects
   Cookie banner + visual effects library
   ============================================ */

(function () {
  'use strict';

  /* === Cookie banner ===
     The banner ships [hidden] and is revealed here only when the visitor has
     no stored dismissal. That ordering matters: if this script fails to load,
     the visitor sees no banner at all rather than one they cannot dismiss.

     localStorage access is wrapped — Safari private mode and some embedded
     webviews throw on read/write instead of returning null, which would
     otherwise take down everything after it in this file. */
  var STORAGE_KEY = 'glm_cookie_notice_dismissed';

  function storageGet(key) {
    try { return window.localStorage.getItem(key); } catch (err) { return null; }
  }
  function storageSet(key, value) {
    try { window.localStorage.setItem(key, value); } catch (err) { /* quota / private mode */ }
  }

  function initCookieBanner() {
    var banner = document.querySelector('[data-cookie-banner]');
    if (!banner) return;

    if (storageGet(STORAGE_KEY) === 'true') return;   // dismissed on an earlier visit

    banner.hidden = false;

    // Two frames: one to commit the translateY(140%) start state now that the
    // element is displayed, one to flip the class so the slide-up transition
    // has something to animate from.
    requestAnimationFrame(function () {
      requestAnimationFrame(function () { banner.classList.add('is-visible'); });
    });

    var dismiss = banner.querySelector('[data-cookie-dismiss]');
    if (!dismiss) return;

    dismiss.addEventListener('click', function () {
      storageSet(STORAGE_KEY, 'true');
      banner.classList.remove('is-visible');
      window.setTimeout(function () { banner.hidden = true; }, 450);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCookieBanner);
  } else {
    initCookieBanner();
  }

  // Parallax, particle, and other visual effects can be added here.
})();
