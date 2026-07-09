<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   The services HUB: one card per SERVICE PAGE (11 of them), then a
   complete index of all 22 individual services grouped under the page
   each one lives on. This is the page CLAUDE.md requires to expose
   every service, so nothing is truncated here.

   The 11-page list and the 22-service list are BOTH read from config.php
   ($servicePages, $services) — never hardcoded. Two group pages
   (lawn-care-services, tree-shrub-services) cover multiple services;
   the other nine are solo. servicesOnPage() resolves which is which.

   Nothing on this page is invented. No prices, no review quotes, no star
   ratings, no "Licensed & Insured", no jobs-completed count, no
   certifications — intake supplied none of them (config.php $missingIntake,
   $reviews). The only business facts asserted are the ones build-plan.json
   recorded: founded 2024, based in Mauldin 29662, 25-mile radius across
   Greenville County, one crew, free walkthrough, written estimate within
   24 hours. The horticultural claims are checkable facts about the SC
   Piedmont, not marketing.
   ============================================================ */

$currentPage = 'services';

$pageTitle       = 'Lawn & Landscape Services in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Browse the 22 lawn and landscape services from Greenville Lawn Masters '
                 . 'in Mauldin, SC: mowing, fertilization, aeration, mulch, sod, '
                 . 'and seasonal cleanup.';   // 153 chars

$canonicalUrl     = $siteUrl . '/services/';
$ogImage          = $ogImageUrl;

/* Hero uses the front-lawn photo's 1600px rendition as a CSS background-image;
   preload the same file so it is the LCP head start, not a late fetch. */
$heroImg          = heroPhoto('front_lawn');
$heroImagePreload = $heroImg['src'];

/* Phone is empty in intake. Compute $hasPhone honestly — a tel: button with no
   number, or a fabricated one, is worse than routing to the estimate form. */
$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

$totalServices = count($services);        // 22
$totalPages    = count($servicePages);    // 11


/* ── FAQs — conversational, about CHOOSING and BUNDLING services ──
   40-80 words, answer-first, full company name early in each. Rendered
   visibly below AND passed to generateFAQSchema(); schema that does not
   mirror visible content is a guidelines violation. No pricing anywhere —
   none was supplied, and an invented range amplified through FAQPage schema
   is a misrepresentation to Google, not a placeholder. */
$faqs = [
    [
        'question' => 'Do I have to sign up for every service, or can I pick just one?',
        'answer'   => 'Greenville Lawn Masters lets you pick just one. Every service is priced separately on '
                    . 'the written estimate, so you can book a single mowing route, one seasonal cleanup, or the '
                    . 'full recurring program. Nothing is bundled by default, and you can add services later as '
                    . 'your Mauldin property needs them.',
    ],
    [
        'question' => 'Should I bundle mowing with fertilization and weed control?',
        'answer'   => 'It usually helps. When Greenville Lawn Masters handles both, the mowing height and the '
                    . 'feeding and pre-emergent schedule are coordinated on one calendar, so the lawn is never '
                    . 'scalped before a treatment or fed at the wrong point in the Upstate season. You can still '
                    . 'keep the two separate if you prefer.',
    ],
    [
        'question' => 'How do I know whether my lawn needs aeration, dethatching, or both?',
        'answer'   => 'Aeration and dethatching fix different problems. Aeration opens compacted Piedmont clay so '
                    . 'roots can breathe; dethatching pulls the dead layer between grass and soil that blocks water. '
                    . 'Greenville Lawn Masters checks compaction and thatch depth on foot during the walkthrough and '
                    . 'recommends one, both, or neither based on what your Mauldin lawn shows.',
    ],
    [
        'question' => 'Can one crew handle both my lawn and my landscaping?',
        'answer'   => 'Yes. Greenville Lawn Masters runs mowing, fertilization, beds, mulch, hedges, small trees, '
                    . 'gutters, and pressure washing with the same crew, so you are not coordinating three vendors '
                    . 'for one property. The crew that cuts your Mauldin lawn is the crew that mulched the beds and '
                    . 'cleared the gutters.',
    ],
    [
        'question' => 'How does the free walkthrough and 24-hour estimate work?',
        'answer'   => 'Greenville Lawn Masters walks your property in person, identifies grass type and problem '
                    . 'areas, and notes which services fit. A written, itemised estimate follows within 24 hours, '
                    . 'priced by service so you can take all of it or part of it. There is no charge and no '
                    . 'obligation for the walkthrough.',
    ],
    [
        'question' => 'Which services does a brand-new Mauldin home usually need first?',
        'answer'   => 'New construction in Mauldin often sits on stripped, compacted subsoil. Greenville Lawn '
                    . 'Masters typically starts with soil testing and lime, then grading and sod or seeding, '
                    . 'followed by a mowing and fertilization schedule once the lawn establishes. Mulch and bed '
                    . 'planting round out the curb appeal when you are ready.',
    ],
];

/* ── Schema (exactly 4 nodes) ─────────────────────────────────
   (a) CollectionPage carrying Speakable — this IS a hub/collection page.
   (b) ItemList of the 11 service pages, one ListItem each (iterating
       $servicePages, never a second hardcoded list).
   (c) FAQPage mirroring the visible FAQ.
   (d) BreadcrumbList Home > Services.
   LocalBusiness is NOT restated — every node points at organizationId(). */
$pageSchema = [
    [
        '@context'  => 'https://schema.org',
        '@type'     => 'CollectionPage',
        '@id'       => $canonicalUrl . '#webpage',
        'url'       => $canonicalUrl,
        'name'      => $pageTitle,
        'about'     => ['@id' => organizationId()],
        'speakable' => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.hero-answer', '.answer-block', '.faq-answer', 'h1'],
        ],
    ],
    [
        '@context'        => 'https://schema.org',
        '@type'           => 'ItemList',
        'name'            => 'Greenville Lawn Masters Services',
        'itemListElement' => array_map(
            fn(int $i, array $p): array => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $p['title'],
                'url'      => absoluteUrl('/services/' . $p['slug'] . '/'),
            ],
            array_keys($servicePages),
            array_values($servicePages)
        ),
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',     'url' => '/'],
        ['name' => 'Services', 'url' => '/services/'],
    ]),
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   /services/ hub — page-scoped styles
   Every rule prefixed .svc- so nothing collides with another page's
   <style> block. The shared services-grid / service-card-with-image
   classes are USED, never redefined — only page-specific work lives here.

   Colour, shadow, spacing, radius, and transition timing are var() tokens
   without exception (a raw hex here is an automatic QA fail). Small
   geometric px (icon sizes, hairline borders, marker offsets) follow the
   same convention the reference service page uses.

   Techniques (design-system.md Part C):
     C1  layered hero — photo + gradient ::before (118deg, unique to this
         page) + noise ::after
     C3  three distinct SVG dividers placed between sections
     C6  asymmetric intro with an oversized ghost numeral watermark
     C5  bento-style grouped index on a dark signature band (this page only)
     C7  signature section — the dark "all 22 services" index
     numbered decision rail with a single threaded accent line
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   118deg gradient — deliberately different from the reference page (78deg)
   and the homepage (100deg) so the three heroes never read as one image. */
.svc-hero {
  min-height: 66vh;
  min-height: 66svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-front-lawn.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.svc-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    118deg,
    rgba(var(--color-dark-rgb), 0.94) 0%,
    rgba(var(--color-dark-rgb), 0.80) 40%,
    rgba(var(--color-primary-rgb), 0.52) 76%,
    rgba(var(--color-primary-rgb), 0.28) 100%
  );
  z-index: 0;
}
.svc-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.32;
  z-index: 0;
  pointer-events: none;
}
.svc-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 64rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.svc-hero .breadcrumb { animation: svcFade 0.5s ease both; }

.svc-hero__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  background: rgba(var(--color-accent-rgb), 0.14);
  border: 1px solid rgba(var(--color-accent-rgb), 0.38);
  border-radius: var(--radius-full);
  padding: var(--space-1) var(--space-4);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2.5px;
  color: var(--color-accent);
  margin-bottom: var(--space-5);
  animation: svcFade 0.55s ease 0.08s both;
}
.svc-hero__eyebrow i, .svc-hero__eyebrow svg { width: 15px; height: 15px; }

.svc-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: svcRise 0.6s ease 0.16s both;
}
.svc-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; in this left-aligned hero it must not. */
.svc-hero .hero-answer {
  margin-inline: 0;
  max-width: 60ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: svcRise 0.6s ease 0.26s both;
}

.svc-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: svcRise 0.6s ease 0.36s both;
}
.svc-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: svcRise 0.6s ease 0.46s both;
}
.svc-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.svc-hero__trust i, .svc-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS, never a reveal class — the reveal system
   sets opacity:0 and would blank the hero if IntersectionObserver never fires. */
@keyframes svcFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes svcRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C6 · Intro, asymmetric with a ghost numeral watermark ────*/
.svc-intro { background: var(--color-light); }
.svc-intro__layout {
  display: grid;
  grid-template-columns: 0.7fr 1.3fr;   /* broken grid — never 50/50 */
  gap: var(--space-16);
  align-items: center;
}
.svc-intro__count {
  position: relative;
  font-family: var(--font-heading);
  font-weight: 900;
  font-size: clamp(6rem, 13vw, 12rem);
  line-height: 0.82;
  letter-spacing: -0.05em;
  color: var(--color-primary);
  opacity: 0.14;
  user-select: none;
}
.svc-intro__count span {
  position: absolute;
  left: 0.08em;
  bottom: -1.4em;
  font-size: var(--font-size-sm);
  font-family: var(--font-body);
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  opacity: 1;
  color: var(--color-primary-dark);
  white-space: nowrap;
}
.svc-intro h2 { margin-bottom: var(--space-5); }
.svc-intro .answer-block { margin-inline: 0; color: var(--color-gray-dark); }
.svc-intro__facts {
  list-style: none;
  margin-top: var(--space-8);
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-5);
}
.svc-intro__fact {
  display: grid;
  grid-template-columns: 26px 1fr;
  gap: var(--space-3);
  align-items: start;
}
.svc-intro__fact i, .svc-intro__fact svg {
  width: 20px; height: 20px;
  color: var(--color-accent);
  margin-top: 2px;
}
.svc-intro__fact strong {
  display: block;
  color: var(--color-primary-dark);
  font-family: var(--font-heading);
  font-size: var(--font-size-base);
  line-height: 1.3;
}
.svc-intro__fact span {
  color: var(--color-gray);
  font-size: var(--font-size-sm);
  line-height: 1.5;
}

/* ── Main 11-card grid section ────────────────────────────────*/
.svc-grid-section { background: var(--color-white); }
.svc-grid-header { max-width: 760px; margin: 0 auto var(--space-12); text-align: center; }
.svc-grid-header h2 { margin-bottom: var(--space-4); }
.svc-grid-header .answer-block {
  max-width: 68ch;
  margin: 0 auto var(--space-5);
  color: var(--color-gray-dark);
  font-size: var(--font-size-lg);
  line-height: 1.7;
}
.svc-grid-note {
  margin-top: var(--space-10);
  text-align: center;
}

/* ── C5/C7 · Signature dark index of all 22 services ──────────
   The one section that appears nowhere else on the site: a dark band
   with the full 22-service catalogue grouped under its 11 pages. Group
   cards alternate span widths so the grid never reads as identical boxes. */
.svc-index { background: var(--color-dark); }
.svc-index .svc-grid-header h2 { color: var(--color-white); }
.svc-index .svc-grid-header .answer-block { color: rgba(var(--color-white-rgb), 0.8); }
.svc-index__eyebrow { color: var(--color-accent); }

.svc-index__groups {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.svc-index__group {
  background: rgba(var(--color-white-rgb), 0.05);
  border: 1px solid rgba(var(--color-white-rgb), 0.09);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  transition: transform var(--transition-base), border-color var(--transition-base);
}
.svc-index__group:hover {
  transform: translateY(-3px);
  border-color: rgba(var(--color-accent-rgb), 0.5);
}
/* Both group pages carry more services, so they earn the full-width row. */
.svc-index__group--wide { grid-column: 1 / -1; }
.svc-index__group-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: var(--space-4);
  padding-bottom: var(--space-4);
  margin-bottom: var(--space-4);
  border-bottom: 1px solid rgba(var(--color-white-rgb), 0.1);
}
.svc-index__group-head h3 {
  color: var(--color-white);
  font-size: var(--font-size-xl);
  margin: 0;
}
.svc-index__group-head h3 a { color: var(--color-white); }
.svc-index__group-head h3 a:hover { color: var(--color-accent); }
.svc-index__badge {
  flex-shrink: 0;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--color-accent);
  background: rgba(var(--color-accent-rgb), 0.12);
  border-radius: var(--radius-full);
  padding: var(--space-1) var(--space-3);
  white-space: nowrap;
}
.svc-index__list {
  list-style: none;
  display: grid;
  gap: var(--space-2) var(--space-6);
}
/* The two wide group cards spread their many services into two columns. */
.svc-index__group--wide .svc-index__list { grid-template-columns: 1fr 1fr; }
.svc-index__list li { margin: 0; }
.svc-index__list a {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.82);
  font-size: var(--font-size-sm);
  line-height: 1.5;
  transition: color var(--transition-fast), transform var(--transition-fast);
}
.svc-index__list a i, .svc-index__list a svg {
  width: 14px; height: 14px;
  color: var(--color-accent);
  flex-shrink: 0;
  transition: transform var(--transition-fast);
}
.svc-index__list a:hover { color: var(--color-white); }
.svc-index__list a:hover i, .svc-index__list a:hover svg { transform: translateX(3px); }

/* ── Signature decision rail ──────────────────────────────────
   A single accent line threads the numbered steps; each marker sits on it. */
.svc-decide { background: var(--color-light); }
.svc-decide__layout {
  display: grid;
  grid-template-columns: 1fr 1.15fr;
  gap: var(--space-16);
  align-items: start;
}
.svc-decide h2 { margin-bottom: var(--space-5); }
.svc-decide .answer-block { margin-inline: 0; color: var(--color-gray-dark); }
.svc-rail {
  position: relative;
  padding-left: var(--space-12);
  list-style: none;
}
.svc-rail::before {
  content: '';
  position: absolute;
  left: 13px;
  top: var(--space-2);
  bottom: var(--space-2);
  width: 2px;
  background: linear-gradient(
    to bottom,
    var(--color-accent) 0%,
    rgba(var(--color-accent-rgb), 0.35) 72%,
    transparent 100%
  );
}
.svc-rail__step { position: relative; padding-bottom: var(--space-8); }
.svc-rail__step:last-child { padding-bottom: 0; }
.svc-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 5px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-light);
}
.svc-rail__phase {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.svc-rail__step h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.svc-rail__step p { margin: 0; max-width: 58ch; color: var(--color-gray-dark); line-height: 1.65; }

/* ── FAQ ──────────────────────────────────────────────────────*/
.svc-faq { background: var(--color-white); }
.svc-faq__intro { max-width: 760px; margin: 0 auto var(--space-12); text-align: center; }
.svc-faq__intro h2 { margin-bottom: var(--space-4); }
.svc-faq__intro .answer-block { max-width: 66ch; margin: 0 auto; color: var(--color-gray-dark); }
.svc-faq__list { max-width: 55rem; margin: 0 auto; display: grid; gap: var(--space-4); }
.svc-faq__item {
  background: var(--color-light);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.svc-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.svc-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Final CTA ────────────────────────────────────────────────*/
.svc-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.svc-cta::before {
  content: '';
  position: absolute;
  top: -18%; left: -6%;
  width: 440px; height: 440px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.svc-cta .container { position: relative; z-index: 1; }
.svc-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.svc-cta .answer-block {
  color: rgba(var(--color-white-rgb), 0.88);
  max-width: 60ch;
  margin: 0 auto var(--space-8);
}
.svc-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .svc-intro__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .svc-intro__count { font-size: clamp(5rem, 22vw, 9rem); }
  .svc-intro__count span { position: static; display: block; margin-top: var(--space-4); }
  .svc-decide__layout { grid-template-columns: 1fr; gap: var(--space-10); }
}
@media (max-width: 700px) {
  .svc-hero { min-height: 0; }
  .svc-intro__facts { grid-template-columns: 1fr; }
  .svc-index__groups { grid-template-columns: 1fr; }
  .svc-index__group--wide { grid-column: auto; }
  .svc-index__group--wide .svc-index__list { grid-template-columns: 1fr; }
  .svc-index__group-head { flex-direction: column; align-items: flex-start; gap: var(--space-2); }
  .svc-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero svc-hero" aria-label="Lawn and landscape services in Mauldin, South Carolina">
    <div class="container">
        <div class="svc-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Services</span></li>
                </ol>
            </nav>

            <span class="svc-hero__eyebrow">
                <i data-lucide="layout-grid" aria-hidden="true"></i>
                <?php echo e((string) $totalServices); ?> Services &middot; <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?>
            </span>

            <h1>Lawn &amp; Landscape Services in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters provides <?php echo e((string) $totalServices); ?> lawn and landscape
                services across Mauldin and the surrounding Greenville County area — from weekly mowing,
                fertilization, and aeration to mulch, sod, gutter cleaning, and seasonal cleanup. One crew
                handles the whole property, and every job starts with a free walkthrough and a written
                estimate within 24 hours.
            </p>

            <div class="svc-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* No phone in intake. A "Call Now" button with no number — or a
                             fabricated one — is worse than sending the visitor to the form. */ ?>
                    <a href="/contact/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="mail" aria-hidden="true"></i>
                        Contact <?php echo e($siteName); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only facts intake recorded — no "Licensed & Insured",
                     no star rating, no job count: config.php has none of the three. */ ?>
            <div class="svc-hero__trust">
                <span><i data-lucide="grid-2x2" aria-hidden="true"></i> <?php echo e((string) $totalServices); ?> services across <?php echo e((string) $totalPages); ?> pages</span>
                <span><i data-lucide="users" aria-hidden="true"></i> One crew, whole property</span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider — torn edge, filled with the intro section's light background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,40 L60,42 L120,35 L200,45 L280,32 L360,48 L440,38 L540,45 L640,30 L740,42 L840,35 L940,45 L1040,32 L1140,42 L1200,38 L1200,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · INTRO / ANSWER ══════════ -->
<section class="svc-intro" aria-label="What Greenville Lawn Masters offers">
    <div class="container">
        <div class="svc-intro__layout">

            <div class="svc-intro__count reveal-left" aria-hidden="true">
                <?php echo e((string) $totalServices); ?><span><?php echo e((string) $totalPages); ?> service pages</span>
            </div>

            <div>
                <h2 class="reveal-right">What lawn and landscape services does Greenville Lawn Masters provide near Mauldin?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Greenville Lawn Masters provides <?php echo e((string) $totalServices); ?> lawn and landscape
                    services grouped into <?php echo e((string) $totalPages); ?> focused pages, covering everything
                    from weekly mowing and fertilization to mulch, sod, gutter cleaning, and seasonal cleanup.
                    Based in Mauldin, South Carolina and serving within <?php echo e((string) $targetRadius); ?> miles
                    across Greenville County, one crew handles the whole property on a single schedule.
                </p>

                <ul class="svc-intro__facts">
                    <li class="svc-intro__fact reveal-up reveal-delay-1">
                        <i data-lucide="repeat" aria-hidden="true"></i>
                        <div>
                            <strong>Routine work runs on a route</strong>
                            <span>Mowing, edging, and feeding stay on a fixed weekly or biweekly schedule.</span>
                        </div>
                    </li>
                    <li class="svc-intro__fact reveal-up reveal-delay-2">
                        <i data-lucide="calendar-days" aria-hidden="true"></i>
                        <div>
                            <strong>Seasonal work is timed to the grass</strong>
                            <span>Aeration, overseeding, mulch, and cleanup follow the Upstate calendar, not the phone.</span>
                        </div>
                    </li>
                    <li class="svc-intro__fact reveal-up reveal-delay-3">
                        <i data-lucide="handshake" aria-hidden="true"></i>
                        <div>
                            <strong>One crew, no handoffs</strong>
                            <span>The same team carries mowing, beds, gutters, and washing across the property.</span>
                        </div>
                    </li>
                    <li class="svc-intro__fact reveal-up reveal-delay-4">
                        <i data-lucide="file-check" aria-hidden="true"></i>
                        <div>
                            <strong>Free walkthrough, 24-hour estimate</strong>
                            <span>Every property is walked before it is priced, itemised by service.</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Divider — double wave, filled with the grid section's white background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-white)" opacity="0.45"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 3 · THE 11-CARD GRID ══════════ -->
<section class="svc-grid-section" aria-label="Greenville Lawn Masters service pages">
    <div class="container">

        <div class="svc-grid-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>Which service does your <span class="text-accent">Mauldin lawn</span> need first?</h2>
            <p class="answer-block">
                Start with what your Mauldin property struggles with most. Recurring work — mowing, feeding,
                weed control — runs on a route, while seasonal and project work like aeration, mulch, sod,
                and cleanup is booked to the Upstate calendar. Each card below opens the page that explains
                that service in full.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="services-grid">
            <?php foreach ($servicePages as $i => $page):
                /* One card per PAGE (not per service). Photo, icon, and copy all
                   resolve from config — never a hardcoded list. Tints + stagger
                   rotate 1→2→3 so no two adjacent cards share a background.
                   The card itself is includes/service-card.php, shared with the
                   "Other Services" block on every service page. */
                $cardPage     = $page;
                $cardRotation = ($i % 3) + 1;
                include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-card.php';
            endforeach; ?>
        </div>

        <div class="svc-grid-note reveal-scale">
            <a href="/contact/" class="btn btn-secondary btn-lg">
                <i data-lucide="calendar-check" aria-hidden="true"></i>
                Book a Free Walkthrough
            </a>
        </div>
    </div>

    <!-- Divider — diagonal, filled with the dark index section's background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-dark)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · COMPLETE 22-SERVICE INDEX (signature dark band) ══════════ -->
<?php /* The page CLAUDE.md designates to expose ALL 22 services. Iterates
         $servicePages, and for each renders servicesOnPage() — so the two group
         pages list their 8 and 5 services, the nine solo pages list their one.
         Every service name links to the page it lives on (built from the page
         slug, which equals the service's config `page`). No hardcoded list. */ ?>
<section class="svc-index" aria-label="All Greenville Lawn Masters services">
    <div class="container">

        <div class="svc-grid-header reveal-up">
            <span class="eyebrow-label svc-index__eyebrow">Full Catalogue</span>
            <h2>What are all <?php echo e((string) $totalServices); ?> services <span class="text-accent">Greenville Lawn Masters</span> offers?</h2>
            <p class="answer-block">
                Greenville Lawn Masters offers <?php echo e((string) $totalServices); ?> individual services
                grouped into <?php echo e((string) $totalPages); ?> service pages. The two group pages — lawn
                care and tree and shrub work — bundle related recurring tasks, while the remaining nine cover
                a single project each. Every service name below links to the page that explains it.
            </p>
        </div>

        <div class="svc-index__groups">
            <?php foreach ($servicePages as $i => $page):
                $onPage  = servicesOnPage($page['slug']);
                $isGroup = count($onPage) > 1;
                $dir     = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-left', 'reveal-right'][$i % 5];
            ?>
                <div class="svc-index__group <?php echo $isGroup ? 'svc-index__group--wide' : ''; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="svc-index__group-head">
                        <h3><a href="/services/<?php echo e($page['slug']); ?>/"><?php echo e($page['title']); ?></a></h3>
                        <span class="svc-index__badge">
                            <?php echo e((string) count($onPage)); ?> <?php echo count($onPage) === 1 ? 'service' : 'services'; ?>
                        </span>
                    </div>
                    <ul class="svc-index__list">
                        <?php foreach ($onPage as $svc): ?>
                            <li>
                                <a href="/services/<?php echo e($svc['page']); ?>/">
                                    <i data-lucide="chevron-right" aria-hidden="true"></i>
                                    <?php echo e($svc['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider — double wave, filled with the decide section's light background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · HOW WE DECIDE (rail) ══════════ -->
<section class="svc-decide" aria-label="How Greenville Lawn Masters decides what a property needs">
    <div class="container">
        <div class="svc-decide__layout">

            <div>
                <h2 class="reveal-left">How do you decide what a Mauldin property actually needs?</h2>
                <p class="answer-block reveal-left reveal-delay-1">
                    Greenville Lawn Masters decides what a property needs by walking it first. Grass type,
                    soil, drainage, thatch depth, and bed lines are checked in person, then a written,
                    itemised estimate follows within 24 hours. You take the full program or only the pieces
                    the walkthrough shows your Mauldin property actually needs.
                </p>
            </div>

            <ol class="svc-rail">
                <li class="svc-rail__step reveal-right reveal-delay-1">
                    <span class="svc-rail__phase">Step 1</span>
                    <h3>Walk the property</h3>
                    <p>Grass type is identified zone by zone — most Mauldin lots run warm-season turf in the sun and tall fescue in the shade. Compaction, thatch, drainage, and bed lines are checked on foot, never from a satellite photo.</p>
                </li>
                <li class="svc-rail__step reveal-right reveal-delay-2">
                    <span class="svc-rail__phase">Step 2</span>
                    <h3>Match services to the findings</h3>
                    <p>The walkthrough points to what the property needs — a mowing route, a pre-emergent and feeding schedule, aeration, mulch, or a one-off cleanup. Nothing is upsold that the lawn does not call for.</p>
                </li>
                <li class="svc-rail__step reveal-right reveal-delay-3">
                    <span class="svc-rail__phase">Step 3</span>
                    <h3>Written estimate within 24 hours</h3>
                    <p>An itemised estimate arrives within a day, priced per service so you can take all of it or part of it. Recurring work is quoted per visit; seasonal and project work is quoted separately.</p>
                </li>
                <li class="svc-rail__step reveal-right reveal-delay-4">
                    <span class="svc-rail__phase">Step 4</span>
                    <h3>Set the schedule</h3>
                    <p>Mowing joins a fixed route; treatments, aeration, and cleanups are booked against the calendar the Upstate grass keeps — pre-emergent in late winter, aeration timed to your grass type.</p>
                </li>
            </ol>
        </div>
    </div>

    <!-- Divider — torn edge, filled with the FAQ section's white background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,38 L80,44 L160,32 L240,46 L320,34 L420,44 L520,30 L620,42 L720,34 L820,46 L920,32 L1020,44 L1120,36 L1200,42 L1200,60 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 6 · FAQ ══════════ -->
<section class="svc-faq" aria-label="Questions about choosing lawn and landscape services">
    <div class="container">

        <div class="svc-faq__intro reveal-up">
            <span class="eyebrow-label">Choosing Services</span>
            <h2>How do Mauldin homeowners choose and combine <span class="text-accent">services</span>?</h2>
            <p class="answer-block">
                Most Mauldin homeowners combine one recurring service with a seasonal job or two. Greenville
                Lawn Masters walks the property, explains what each service does, and lets you take all of it
                or part of it. The questions below cover bundling, timing, and where to begin.
            </p>
        </div>

        <div class="svc-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="svc-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider — diagonal, filled with the CTA section's primary green -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-primary)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 7 · FINAL CTA ══════════ -->
<section class="svc-cta" aria-label="Request a lawn and landscape estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to match the right services to your property?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Tell Greenville Lawn Masters what your Mauldin property needs and someone walks it, prices it,
            and sends a written estimate within 24 hours — a single service, a recurring program, or a
            full-property plan across any of the <?php echo e((string) $totalServices); ?> services.
        </p>
        <div class="svc-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Estimate
            </a>
            <?php if ($hasPhone): ?>
                <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                    <i data-lucide="phone" aria-hidden="true"></i>
                    Call <?php echo e($phoneDisplay); ?>
                </a>
            <?php else: ?>
                <a href="/about/" class="btn btn-outline-white btn-lg">
                    <i data-lucide="info" aria-hidden="true"></i>
                    About <?php echo e($siteName); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
