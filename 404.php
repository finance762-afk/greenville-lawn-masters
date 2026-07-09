<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /404.php — Phase 5
   Greenville Lawn Masters · Mauldin, SC

   The ONE page in the build that is deliberately a flat root-level
   .php file rather than a directory/index.php. .htaccess line 54 says
   `ErrorDocument 404 /404.php` and Apache resolves that path literally;
   CLAUDE.md's subdirectory rule exempts it by name ("Every page except
   homepage and 404.php").

   ── STATUS CODE ────────────────────────────────────────────────
   http_response_code(404) is set explicitly and BEFORE any output.
   Apache's ErrorDocument does pass the 404 through for a static file,
   but a PHP handler that ends up reached directly (or via a rewrite)
   would otherwise return 200 with "not found" text in the body — a
   soft 404. Google treats those as thin duplicate content and will
   happily index a few thousand of them.

   ── SEARCH ─────────────────────────────────────────────────────
   The search box posts to Google's site: operator rather than to a
   nonexistent internal /search endpoint. This build has no search
   backend, and a form that silently 404s from a 404 page is worse
   than no form. GET, method-visible, no JS required.
   ============================================================ */

http_response_code(404);

$currentPage = '404';
$noindex     = true;   // head.php → <meta name="robots" content="noindex,nofollow">

$pageTitle       = 'Page Not Found | Greenville Lawn Masters';
$pageDescription = 'That page has moved or never existed. Find lawn care services, service '
                 . 'areas, and contact details for Greenville Lawn Masters in Mauldin, SC.';

$canonicalUrl = $siteUrl . '/404.php';

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* The six destinations that cover essentially every reason someone lands here:
   a stale service URL, a bookmark, a typo, or a link from an old listing. */
$popular = [
    ['icon' => 'home',           'title' => 'Homepage',            'desc' => 'Start over from the top.',                                  'url' => '/'],
    ['icon' => 'list',           'title' => 'All Services',        'desc' => 'All ' . count($servicePages) . ' service pages in one place.', 'url' => '/services/'],
    ['icon' => 'scissors',       'title' => 'Lawn Care Services',  'desc' => 'Mowing, feeding, weed control, aeration.',                   'url' => '/services/lawn-care-services/'],
    /* No question count in this description. It would be a second place to keep in
       sync with the FAQ page's $faqCategories, and it is exactly the place nobody
       remembers to update. */
    ['icon' => 'help-circle',    'title' => 'FAQ',                 'desc' => 'Straight answers about Upstate lawns.',                      'url' => '/faq/'],
    ['icon' => 'leaf',           'title' => 'About Us',            'desc' => 'Who works on your property, and how.',                       'url' => '/about/'],
    ['icon' => 'clipboard-list', 'title' => 'Free Estimate',       'desc' => 'Written and itemised, within 24 hours.',                     'url' => '/contact/'],
];

/* No schema on a 404. It is noindex, it represents no entity, and a
   BreadcrumbList for a page that does not exist is nonsense. */
$pageSchema = [];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   404 — page-scoped styles
   Every class prefixed .nf-. All colour, shadow, spacing, radius and
   timing values are var() tokens.

   Techniques used (design-system.md Part C):
     C1  layered treatment — gradient ground + noise ::after (no photo:
         a hero image behind an error message reads as a stock apology)
     C3  SVG divider (soft wave)
     C7  signature — the oversized outlined "404" watermark, used nowhere else
     C10 floating decorative accents at 4-8% opacity
   ============================================================ */

.nf-hero {
  min-height: calc(100vh - var(--nav-height));
  display: flex;
  align-items: center;
  text-align: center;
  background: linear-gradient(150deg, var(--color-dark) 0%, var(--color-primary-dark) 100%);
  isolation: isolate;
}
.nf-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.4;
  pointer-events: none;
  z-index: 0;
}
.nf-hero__inner {
  position: relative;
  z-index: 2;
  max-width: 46rem;
  margin-inline: auto;
  padding-block: var(--space-16);
}

/* ── C7 · SIGNATURE — the outlined 404 watermark ──────────────
   Stroked, not filled, so the copy stacked over it stays legible. */
.nf-watermark {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-family: var(--font-heading);
  font-size: clamp(14rem, 34vw, 30rem);
  font-weight: 900;
  line-height: 1;
  letter-spacing: -0.04em;
  color: transparent;
  -webkit-text-stroke: 2px rgba(var(--color-accent-rgb), 0.16);
  pointer-events: none;
  user-select: none;
  z-index: 1;
  white-space: nowrap;
}

/* C10 · floating accents */
.nf-hero::before {
  content: '';
  position: absolute;
  top: 18%;
  left: 12%;
  width: 300px;
  height: 300px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  opacity: 0.05;
  filter: blur(var(--space-8));
  z-index: 0;
}

/* Above-fold, so a keyframe rather than a reveal class. */
@keyframes nfRise {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: none; }
}
.nf-badge   { animation: nfRise 0.6s ease both; }
.nf-hero h1 { animation: nfRise 0.6s ease 0.08s both; }
.nf-lede    { animation: nfRise 0.6s ease 0.16s both; }
.nf-search  { animation: nfRise 0.6s ease 0.24s both; }
.nf-actions { animation: nfRise 0.6s ease 0.32s both; }

.nf-badge {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  padding: var(--space-2) var(--space-4);
  border: 1px solid rgba(var(--color-white-rgb), 0.22);
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.07);
  backdrop-filter: blur(6px);
  color: rgba(var(--color-white-rgb), 0.88);
  font-size: var(--font-size-sm);
  letter-spacing: 1px;
  text-transform: uppercase;
  margin-bottom: var(--space-6);
}
.nf-badge i, .nf-badge svg { width: 15px; height: 15px; color: var(--color-accent); }

.nf-hero h1 {
  font-size: var(--fs-h2);
  color: var(--color-white);
  line-height: 1.1;
  text-wrap: balance;
  margin-bottom: var(--space-5);
}
.nf-lede {
  color: rgba(var(--color-white-rgb), 0.76);
  font-size: var(--font-size-lg);
  line-height: 1.75;
  max-width: 54ch;
  margin: 0 auto var(--space-10);
}

/* ── Search ───────────────────────────────────────────────────
   Posts to Google with a site: filter. No internal search backend exists,
   and pointing a form at one that does not would be a second dead end. */
.nf-search {
  display: flex;
  gap: var(--space-2);
  max-width: 34rem;
  margin: 0 auto var(--space-8);
}
.nf-search__field {
  position: relative;
  flex: 1;
}
.nf-search__field i, .nf-search__field svg {
  position: absolute;
  left: var(--space-4);
  top: 50%;
  transform: translateY(-50%);
  width: 18px; height: 18px;
  color: rgba(var(--color-white-rgb), 0.5);
  pointer-events: none;
}
.nf-search input {
  width: 100%;
  padding: var(--space-4) var(--space-4) var(--space-4) var(--space-12);
  border-radius: var(--radius-md);
  border: 1px solid rgba(var(--color-white-rgb), 0.22);
  background: rgba(var(--color-white-rgb), 0.08);
  color: var(--color-white);
  font-family: var(--font-body);
  font-size: var(--font-size-base);
  transition: border-color var(--transition-base), background var(--transition-base);
}
.nf-search input::placeholder { color: rgba(var(--color-white-rgb), 0.45); }
.nf-search input:hover { border-color: rgba(var(--color-white-rgb), 0.4); }
.nf-search input:focus {
  outline: none;
  border-color: var(--color-accent);
  background: rgba(var(--color-white-rgb), 0.12);
}
.nf-search input:focus-visible { outline: 2px solid var(--color-accent); outline-offset: 2px; }

.nf-actions {
  display: flex;
  gap: var(--space-4);
  justify-content: center;
  flex-wrap: wrap;
}

/* ── Popular destinations ─────────────────────────────────────*/
.nf-popular { background: var(--color-light); }
.nf-popular .section-header h2 { color: var(--color-primary); }
.nf-popular__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.nf-card {
  display: flex;
  align-items: flex-start;
  gap: var(--space-4);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.nf-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.nf-card__icon {
  width: 46px; height: 46px;
  flex-shrink: 0;
  border-radius: var(--radius-md);
  background: var(--color-white);
  box-shadow: var(--shadow-sm);
  display: grid;
  place-items: center;
  color: var(--color-primary);
}
.nf-card__icon i, .nf-card__icon svg { width: 21px; height: 21px; }
.nf-card h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  color: var(--color-primary-dark);
  margin-bottom: var(--space-1);
  text-wrap: balance;
}
.nf-card p {
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  margin: 0;
}
.nf-card__arrow {
  margin-left: auto;
  align-self: center;
  width: 18px; height: 18px;
  color: var(--color-accent);
  flex-shrink: 0;
  transition: transform var(--transition-base);
}
.nf-card:hover .nf-card__arrow { transform: translateX(4px); }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .nf-popular__grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .nf-hero { min-height: auto; padding-block: calc(var(--nav-height) + var(--space-16)) var(--space-16); }
  .nf-watermark { font-size: clamp(10rem, 46vw, 18rem); }
  .nf-search { flex-direction: column; }
  .nf-search .btn { width: 100%; }
}
@media (max-width: 600px) {
  .nf-popular__grid { grid-template-columns: 1fr; }
  .nf-actions .btn { width: 100%; }
}

/* ── Focus states ─────────────────────────────────────────────
   The destination cards are <a> elements wrapping a heading and body copy.
   A focus ring on the card, not on the text inside it. */
.nf-card:focus-visible {
  outline: 2px solid var(--color-primary);
  outline-offset: 3px;
  transform: translateY(-4px);
  box-shadow: var(--shadow-card);
}
.nf-actions .btn:focus-visible,
.nf-search .btn:focus-visible {
  outline: 2px solid var(--color-white);
  outline-offset: 3px;
}

/* ── Short viewports ──────────────────────────────────────────
   A 100vh hero on a landscape phone (≈380px tall) buries the search box
   and both buttons below the fold, on the one page whose whole purpose is
   getting the visitor somewhere else. Release the height. */
@media (max-height: 620px) and (min-width: 769px) {
  .nf-hero { min-height: auto; padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-12); }
  .nf-watermark { font-size: clamp(8rem, 22vw, 16rem); }
  .nf-lede { margin-bottom: var(--space-6); }
}

/* ── Reduced motion ───────────────────────────────────────────
   The framework reset already crushes durations. What it cannot fix is
   the hover translate on the cards, which is a transform and not an
   animation — it fires on pointer, not on scroll. Drop it. */
@media (prefers-reduced-motion: reduce) {
  .nf-card:hover { transform: none; }
  .nf-card:hover .nf-card__arrow { transform: none; }
}

/* ── Windows High Contrast / forced-colors ────────────────────
   The stroked watermark is drawn with -webkit-text-stroke, which
   forced-colors does not repaint — it would vanish, which is fine, it is
   decorative. The tinted cards lose their backgrounds, so give them
   borders. */
@media (forced-colors: active) {
  .nf-watermark { display: none; }
  .nf-card { border: 1px solid CanvasText; }
  .nf-card__icon { border: 1px solid CanvasText; }
  .nf-search input { border: 1px solid CanvasText; }
}

/* ── @supports fallbacks ──────────────────────────────────────
   backdrop-filter is unsupported in Firefox without a flag. Without it the
   badge is a near-transparent pill on a photo-free gradient, which is
   legible — but the fallback makes it certain. */
@supports not (backdrop-filter: blur(6px)) {
  .nf-badge { background: rgba(var(--color-dark-rgb), 0.55); }
}
@supports not (-webkit-text-stroke: 1px black) {
  .nf-watermark { color: rgba(var(--color-accent-rgb), 0.10); }
}

/* Brand-green selection. */
.nf-popular ::selection { background: rgba(var(--color-accent-rgb), 0.25); color: var(--color-black); }
.nf-hero ::selection { background: rgba(var(--color-accent-rgb), 0.4); color: var(--color-white); }

/* ── Print ────────────────────────────────────────────────────
   Nobody prints a 404 on purpose. If a page is printed from a broken
   bookmark, at least give them the destination list in black on white. */
@media print {
  .nf-hero { min-height: auto; background: none; padding-block: var(--space-4); }
  .nf-hero::before, .nf-hero::after, .nf-watermark, .nf-search,
  .nf-actions, .svg-divider, .cookie-banner, .mobile-cta-bar,
  .back-to-top, .site-header { display: none !important; }
  .nf-hero h1, .nf-lede { color: var(--color-black); }
  .nf-badge { display: none; }
  .nf-popular { background: none; }
  .nf-card { border: 1px solid var(--color-black); break-inside: avoid; }
  .nf-card__arrow { display: none; }
  /* attr(href), not a constant — each card must print its OWN destination. */
  .nf-card::after {
    content: " <?php echo e($siteUrl); ?>" attr(href);
    font-size: 0.8em;
    word-break: break-all;
  }
}
</style>

<!-- ══════════ 1 · THE ERROR ══════════ -->
<section class="hero nf-hero" aria-label="Page not found">
    <span class="nf-watermark" aria-hidden="true">404</span>

    <div class="container">
        <div class="nf-hero__inner">

            <span class="nf-badge">
                <i data-lucide="search-x" aria-hidden="true"></i>
                Error 404
            </span>

            <h1>This page has been <span class="text-accent">mowed over</span></h1>

            <p class="nf-lede">
                The page you asked for has moved, been renamed, or never existed. Nothing is broken on
                your end. Search below, or take one of the paths back to solid ground.
            </p>

            <?php /* GET to Google with a site: filter. `q` carries the site: operator and the
                     visitor's terms; there is no internal search index to query, and a form
                     that posts to a nonexistent /search would be a second dead end. */ ?>
            <?php /* `as_q` (all these words) + `as_sitesearch` (restrict to domain) is the
                     pairing Google actually honours on /search. A hidden `q` holding
                     "site:domain" alongside a second field does NOT merge — the two
                     parameters fight and the site filter is dropped. */ ?>
            <form class="nf-search" action="https://www.google.com/search" method="GET" role="search">
                <input type="hidden" name="as_sitesearch" value="<?php echo e($domain); ?>">
                <div class="nf-search__field">
                    <i data-lucide="search" aria-hidden="true"></i>
                    <label for="nf-q" class="sr-only">Search Greenville Lawn Masters</label>
                    <input type="search" id="nf-q" name="as_q" placeholder="Search this site — try &quot;aeration&quot;" required>
                </div>
                <button type="submit" class="btn btn-accent">Search</button>
            </form>

            <div class="nf-actions">
                <a href="/" class="btn btn-accent btn-lg">
                    <i data-lucide="home" aria-hidden="true"></i>
                    Back to Homepage
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <a href="/contact/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="mail" aria-hidden="true"></i>
                        Contact Us
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- Divider · soft wave into the tinted destination grid -->
    <div class="svg-divider" style="height:64px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,36 C170,8 340,54 540,32 C740,10 900,50 1080,30 C1130,24 1170,26 1200,28 L1200,60 L0,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · POPULAR DESTINATIONS ══════════ -->
<section class="nf-popular" aria-label="Popular pages">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">Try One Of These</span>
            <h2>Where were you <span class="text-accent">headed</span>?</h2>
        </div>

        <div class="nf-popular__grid">
            <?php foreach ($popular as $i => $dest): ?>
                <?php
                    $rotation = ($i % 3) + 1;
                    $dir      = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
                ?>
                <a class="nf-card card-tint-<?php echo $rotation; ?> <?php echo $dir; ?> reveal-delay-<?php echo $rotation; ?>"
                   href="<?php echo e($dest['url']); ?>">
                    <div class="nf-card__icon">
                        <i data-lucide="<?php echo e($dest['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3><?php echo e($dest['title']); ?></h3>
                        <p><?php echo e($dest['desc']); ?></p>
                    </div>
                    <i data-lucide="arrow-right" class="nf-card__arrow" aria-hidden="true"></i>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
