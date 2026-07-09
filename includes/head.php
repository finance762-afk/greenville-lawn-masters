<?php
/* ============================================================
   includes/head.php
   Doctype, <head>, meta, Open Graph, schema, CSS.

   Pages set these before including this file (all optional):
     $currentPage      string  nav active state + schema gating ('home', 'about', …)
     $pageTitle        string  full <title>; falls back to a generated one
     $pageDescription  string  meta description, 140-160 chars
     $canonicalUrl     string  absolute; falls back to the current request URI
     $ogImage          string  absolute; falls back to the logo
     $ogType           string  'website' (default) | 'article'
     $noindex          bool    true on /thank-you/ and 404
     $heroImagePreload string  absolute URL of the LCP hero image
     $pageSchema       array   array of schema arrays, each rendered as JSON-LD

   NOT emitted, deliberately — all three are forbidden by CLAUDE.md and would
   fail the Phase 5 QA audit, even though the Phase 2 build prompt asks for them:
     • <meta name="keywords">  — ignored by Google since 2009; forbidden tag
     • twitter:* card tags     — zero discovery value for local service; forbidden
     • aggregateRating         — "NEVER include … risks a manual action", and
                                 build-plan.json's reviews array is empty, so it
                                 could only be populated by inventing a rating
   ============================================================ */

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$currentPage = $currentPage ?? '';
$isHome      = $currentPage === 'home';

/* Title: "Page Topic | Company | City, State" (CLAUDE.md SEO → On-Page). */
$pageTitle = $pageTitle ?? sprintf(
    '%s | %s, %s',
    ucwords($primaryKeyword),          // "Lawn Care Mauldin Sc"
    $siteName,
    $address['state']
);

$pageDescription = $pageDescription ?? sprintf(
    '%s provides professional lawn care in %s, %s — mowing, fertilization, '
    . 'aeration, and seasonal cleanup. Free estimate within 24 hours.',
    $siteName, $address['city'], $address['state']
);

$canonicalUrl = $canonicalUrl ?? canonicalForRequest();
$ogImage      = $ogImage      ?? $logoUrl;
$ogType       = $ogType       ?? 'website';
$noindex      = $noindex      ?? false;
$pageSchema   = $pageSchema   ?? [];

/* Homepage carries the LocalBusiness node; every other page references its
   @id via `provider` instead of restating it (CLAUDE.md). */
if ($isHome) {
    array_unshift($pageSchema, generateLocalBusinessSchema());
    $pageSchema[] = [
        '@context' => 'https://schema.org',
        '@type'    => 'WebSite',
        'name'     => $siteName,
        'url'      => rtrim($siteUrl, '/') . '/',
        'publisher' => ['@id' => organizationId()],
    ];
}

/* Built as a URL, then escaped on output — a raw "&" in an href is invalid
   HTML even though browsers forgive it. e() turns each into &amp;. */
$fontHref = 'https://fonts.googleapis.com/css2'
          . '?family=' . rawurlencode($fonts['heading']) . ':opsz,wght@9..144,400..900'
          . '&family=' . rawurlencode($fonts['body']) . ':wght@300..900'
          . '&display=swap';

/* The intake banner sits in normal flow at the top of <body>, but .site-header
   is position:fixed — the banner would bury the navbar. This class un-fixes the
   header for exactly as long as the banner exists. */
$bodyClasses = [];
if (isset($bodyClass))      { $bodyClasses[] = $bodyClass; }
if (!empty($missingIntake)) { $bodyClasses[] = 'has-intake-warning'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php echo generateMetaTags($pageTitle, $pageDescription, $canonicalUrl, [
        'ogImage' => $ogImage,
        'ogType'  => $ogType,
        'noindex' => $noindex,
    ]); ?>

    <!-- Fonts. Variable families only (design-aesthetics-2026.md §A3.4).
         No woff2 <link rel="preload">: Google Fonts serves hash-versioned file
         URLs that rotate, so a hardcoded preload href goes stale and silently
         double-downloads. preconnect + display=swap is the reliable pairing. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="<?php echo e($fontHref); ?>">

    <link rel="dns-prefetch" href="//db.pageone.cloud">

<?php if (!empty($heroImagePreload)): ?>
    <link rel="preload" as="image" href="<?php echo e($heroImagePreload); ?>" fetchpriority="high">
<?php endif; ?>

    <link rel="stylesheet" href="/assets/css/framework.css?v=<?php echo e((string) $cssVersion); ?>">

    <link rel="icon" type="image/svg+xml" href="/assets/images/favicon.svg">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png">
    <meta name="theme-color" content="<?php echo e($colors['primary']); ?>">

    <!-- Google Analytics 4 — placeholder. Swap G-XXXXXXXXXX for the client's
         real measurement ID post-launch, then uncomment, push, hard refresh.
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e($googleAnalyticsId); ?>"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', '<?php echo e($googleAnalyticsId); ?>');
    </script>
    -->

<?php foreach ($pageSchema as $schemaBlock): ?>
    <?php echo jsonLdBlock($schemaBlock); ?>

<?php endforeach; ?>
</head>
<body<?php echo $bodyClasses ? ' class="' . e(implode(' ', $bodyClasses)) . '"' : ''; ?>>

<?php if (!empty($missingIntake)): ?>
<?php /* Renders only while config.php still has empty required intake fields.
         Deliberately loud: this build is missing its phone number, so it must
         not pass CM's browser-review gate looking finished. Self-clears. */ ?>
<div class="intake-warning" role="alert">
    <strong>BUILD INCOMPLETE — not deployable.</strong>
    Missing intake data in <code>includes/config.php</code>:
    <code><?php echo implode('</code>, <code>', array_map('e', $missingIntake)); ?></code>.
    Phone/email CTAs, the footer NAP, and LocalBusiness schema fields are
    omitted rather than faked. This banner disappears when the values land.
</div>
<?php endif; ?>
