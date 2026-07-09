<?php
/* ============================================================
   includes/cookie-banner.php
   Light dismissible cookie notice (legal-compliance.md).
   Single "Got it" button, suppressed on later visits via
   localStorage. Sits above the sticky mobile CTA bar.
   Shown/dismissed by effects.js — starts hidden, so a JS
   failure means no banner rather than an undismissable one.
   ============================================================ */
?>
<div class="cookie-banner" data-cookie-banner role="region" aria-label="Cookie notice" hidden>
    <p class="cookie-banner__text">
        We use cookies to run this site and understand how it's used.
        See our <a href="/cookie-policy/">Cookie Policy</a>.
    </p>
    <button type="button" class="cookie-banner__dismiss" data-cookie-dismiss>Got it</button>
</div>
