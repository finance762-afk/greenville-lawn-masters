<?php
/* ============================================================
   sitemap.php — dynamic XML sitemap.

   Canonical URL: /sitemap (extensionless). The existing clean-URL
   rewrite (Apache) and the preview host's pretty URLs (nginx) both
   resolve /sitemap → sitemap.php; /sitemap.xml resolves NOWHERE on
   this build because .htaccess has no `^sitemap\.xml$ → /sitemap.php`
   rule and nginx ignores .htaccess entirely. robots.txt and the
   footer legal row therefore link /sitemap. If the rewrite is ever
   added, /sitemap.xml starts working too — nothing here changes.

   Registry-driven: service pages and service areas are read from
   config.php ($servicePages, $serviceAreas), so a page added there
   appears here automatically. Static sitemap files are forbidden
   (skill: "Sitemaps: dynamic, registry-driven").

   Priorities per the Phase 5 build prompt:
     homepage 1.0 · services 0.8 · other pages 0.6 · legal 0.3/yearly

   <lastmod> is the real filemtime of each page's index.php — never a
   hardcoded date that goes stale.

   Image entries are embedded per-URL (image: namespace) and mirror
   what each page actually renders, sourced from $photoLibrary /
   $servicePhotos. Captions are the library alt text — which was
   written from what is IN each frame, so nothing here claims a photo
   shows work it doesn't (see config.php $servicePhotos preamble).

   Excluded on purpose:
     /thank-you/ (noindex), /404.php (error page)
   ============================================================ */

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

header('Content-Type: application/xml; charset=UTF-8');

/* ── Page registry ──────────────────────────────────────────
   [path, source file (for lastmod), changefreq, priority, photo keys] */

$urls = [];

$urls[] = ['/',               'index.php',                 'weekly',  '1.0', ['front_lawn', 'mowing', 'hedges', 'backyard', 'mulch_bed', 'driveway']];
$urls[] = ['/services/',      'services/index.php',        'monthly', '0.8', ['front_lawn', 'mowing', 'hedges', 'backyard', 'mulch_bed', 'driveway']];

foreach ($servicePages as $page) {
    $slug   = $page['slug'];
    $photos = array_values(array_unique(array_merge(
        [servicePagePhotos($slug)['hero']],
        servicePagePhotos($slug)['body']
    )));
    $urls[] = ['/services/' . $slug . '/', 'services/' . $slug . '/index.php', 'monthly', '0.8', $photos];
}

$urls[] = ['/service-areas/', 'service-areas/index.php',   'monthly', '0.6', ['mowing', 'front_lawn', 'backyard', 'mulch_bed']];
foreach ($serviceAreas as $area) {
    $urls[] = ['/service-areas/' . $area['slug'] . '/', 'service-areas/' . $area['slug'] . '/index.php', 'monthly', '0.6', ['backyard', 'mulch_bed']];
}

$urls[] = ['/about/',         'about/index.php',           'monthly', '0.6', ['mowing', 'hedges', 'mulch_bed']];
$urls[] = ['/contact/',       'contact/index.php',         'monthly', '0.6', []];
$urls[] = ['/faq/',           'faq/index.php',             'monthly', '0.6', []];

/* Legal pages — indexable, low priority, rarely change. */
foreach (['privacy-policy', 'terms', 'cookie-policy', 'accessibility'] as $legal) {
    $urls[] = ['/' . $legal . '/', $legal . '/index.php', 'yearly', '0.3', []];
}

/* ── Output ────────────────────────────────────────────────── */

$xml = function (string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_XML1, 'UTF-8');
};

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
<?php foreach ($urls as [$path, $file, $freq, $priority, $photoKeys]):
    $abs     = $_SERVER['DOCUMENT_ROOT'] . '/' . $file;
    $lastmod = is_file($abs) ? date('Y-m-d', filemtime($abs)) : date('Y-m-d');
?>
    <url>
        <loc><?php echo $xml(absoluteUrl($path)); ?></loc>
        <lastmod><?php echo $xml($lastmod); ?></lastmod>
        <changefreq><?php echo $xml($freq); ?></changefreq>
        <priority><?php echo $xml($priority); ?></priority>
<?php foreach ($photoKeys as $key):
        if (!isset($photoLibrary[$key])) { continue; }
        $img = $photoLibrary[$key];
?>
        <image:image>
            <image:loc><?php echo $xml(absoluteUrl($img['src'])); ?></image:loc>
            <image:title><?php echo $xml($img['alt']); ?></image:title>
        </image:image>
<?php endforeach; ?>
    </url>
<?php endforeach; ?>
</urlset>
