<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   index.php — Homepage (Phase 3)
   Greenville Lawn Masters · Mauldin, SC

   Content sourced only from build-plan.json + includes/config.php.
   Nothing on this page is invented: no review quotes, no star
   rating, no jobs-completed count, no "Licensed & Insured" claim,
   no price ranges. Every one of those was absent from intake, and
   a fabricated one is a legal or trust liability, not a placeholder.
   See the REVIEWS section and the notes in config.php.
   ============================================================ */

$currentPage = 'home';

$pageTitle       = 'Lawn Care in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Lawn care in Mauldin, SC from Greenville Lawn Masters: mowing, '
                 . 'fertilization, weed control, aeration, mulch, and seasonal cleanup. '
                 . 'Free estimate in 24 hours.';   // 155 chars — cap is 160

$canonicalUrl = $siteUrl . '/';

/* og:image points at the Supabase copy, not /assets/. $siteUrl is still the
   placeholder host, so an absolute URL beneath it would 404 for every scraper
   that tries to fetch the card image. Swap to the local asset at launch. */
$ogImage = $ogImageUrl;

/* Root-relative on purpose. An absolute preload href under the placeholder
   $siteUrl would resolve to a dead host on the preview domain and cost the
   hero its LCP head start instead of buying one. */
$heroImagePreload = $photoLibrary['hero']['src'];

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* Swiper loads only when there is something to put in the carousel. */
$useSwiper = !empty($reviews);

/* ── Homepage service grid ─────────────────────────────────────
   8 of the 22 services, chosen for search intent and for having a real
   photograph behind them. Tints rotate 1→2→3 and icons never repeat between
   adjacent cards (CLAUDE.md Required Components). `service` is matched against
   config.php's $services by getServicePageUrl(), so a card can never link to a
   page that does not exist — grouped services resolve to their group page. */
$homeServices = [
    [
        'service' => 'Lawn Mowing',
        'icon'    => 'scissors',
        'photo'   => 'mowing',
        'desc'    => 'Scheduled mowing, edging, and blow-off on a weekly or biweekly route.',
        'bullets' => ['Weekly or biweekly routes', 'Edging and string trimming', 'Drives and walks blown clean'],
    ],
    [
        'service' => 'Fertilization & Weed Control',
        'icon'    => 'sprout',
        'photo'   => 'front_lawn',
        'desc'    => 'Seasonal feeding paired with pre-emergent and post-emergent weed control.',
        'bullets' => ['Crabgrass pre-emergent timing', 'Broadleaf weed treatment', 'Season-long feeding schedule'],
    ],
    [
        'service' => 'Aeration & Overseeding',
        'icon'    => 'shovel',
        'photo'   => 'backyard',
        'desc'    => 'Core aeration to open compacted clay, then overseeding to fill thin turf.',
        'bullets' => ['Relieves compacted Piedmont clay', 'Fills bare and thin spots', 'Timed to your grass type'],
    ],
    [
        'service' => 'Hedge & Shrub Trimming',
        'icon'    => 'leaf',
        'photo'   => 'hedges',
        'desc'    => 'Shaping and pruning for hedges, foundation shrubs, and small ornamentals.',
        'bullets' => ['Clean, even shaping', 'Clippings cleaned up and hauled', 'Keeps windows and walks clear'],
    ],
    [
        'service' => 'Mulch Installation',
        'icon'    => 'flower-2',
        'photo'   => 'mulch_bed',
        'desc'    => 'Fresh mulch over cleaned, re-edged beds around foundations and trees.',
        'bullets' => ['Beds cleaned and re-edged', 'Even depth, crisp bed lines', 'Holds moisture through summer'],
    ],
    [
        'service' => 'Spring & Fall Cleanup',
        'icon'    => 'wind',
        'photo'   => 'backyard',
        'desc'    => 'Leaf removal, bed cleanout, and debris haul-off at each change of season.',
        'bullets' => ['Leaf and storm debris removal', 'Beds cleared and re-edged', 'Hauled off, not left curbside'],
    ],
    [
        'service' => 'Pressure Washing',
        'icon'    => 'spray-can',
        'photo'   => 'driveway',
        'desc'    => 'Surface cleaning for driveways, sidewalks, patios, and walkways.',
        'bullets' => ['Driveways and sidewalks', 'Lifts algae and weather stains', 'Pressure matched to concrete'],
    ],
    [
        'service' => 'Sod Installation',
        'icon'    => 'layers',
        'photo'   => 'front_lawn',
        'desc'    => 'New sod laid over graded, prepared soil for an instantly established lawn.',
        'bullets' => ['Grading and soil preparation', 'Warm-season sod varieties', 'Watering plan on handover'],
    ],
];

/* ── Named process ─────────────────────────────────────────────
   Step 2 is the one hard commitment intake actually recorded
   (build-plan.json content.usps: "fast estimate within 24 hours"). */
$processSteps = [
    ['title' => 'Walk the property',      'body' => 'Grass type, soil, drainage, bed lines, and the spots that always struggle — looked at in person, before any number is quoted.'],
    ['title' => 'Estimate within 24 hours','body' => 'A written estimate lands within a day of the visit, itemised by service so you can take all of it or part of it.'],
    ['title' => 'Set the schedule',        'body' => 'Mowing goes on a weekly or biweekly route. Treatments, aeration, and cleanups are booked to the calendar the grass actually keeps.'],
    ['title' => 'Cut, treat, clean up',    'body' => 'Every visit ends the same way: edges cut, clippings off the concrete, gates shut, debris hauled off the property.'],
];

/* ── FAQs ──────────────────────────────────────────────────────
   Answer-first, 40-80 words, conversational phrasing (aeo-content-schema §2.4).
   These answer horticultural questions about the SC Piedmont, which are
   verifiable, rather than business claims that intake never supplied. No
   pricing appears anywhere: none was provided, and an invented range in a
   FAQPage answer is a misrepresentation the schema then amplifies.

   Rendered visibly below AND passed to generateFAQSchema() — schema that does
   not mirror visible content is a guidelines violation. */
$faqs = [
    [
        'question' => 'How much does lawn care cost in Mauldin, SC?',
        'answer'   => 'Greenville Lawn Masters prices each property after seeing it, because lot size, '
                    . 'slope, grass type, and how far the lawn has gotten away from you all move the number. '
                    . 'A walk of the property is free, and a written, itemised estimate follows within 24 hours. '
                    . 'Mowing is quoted per visit on a weekly or biweekly route; treatments and projects are quoted separately.',
    ],
    [
        'question' => 'When should I aerate my lawn in Mauldin, SC?',
        'answer'   => 'Timing follows the grass, not the calendar. Warm-season lawns — bermuda and zoysia — '
                    . 'are cored in late spring through early summer, once the turf is actively growing and can '
                    . 'knit the holes closed. Tall fescue is aerated in early fall, September into October, and '
                    . 'overseeded at the same time. Mauldin sits on heavy Piedmont clay, so most lawns here benefit annually.',
    ],
    [
        'question' => 'When do you apply crabgrass pre-emergent in Upstate South Carolina?',
        'answer'   => 'The window opens when soil temperature at two inches holds near 55°F, which in Greenville '
                    . 'County usually falls between late February and mid-March. Applied after crabgrass has '
                    . 'germinated, a pre-emergent does nothing at all. Greenville Lawn Masters generally follows '
                    . 'the first application with a second roughly eight to ten weeks later to carry the barrier through summer.',
    ],
    [
        'question' => 'What type of grass grows best in Mauldin, SC?',
        'answer'   => 'Mauldin sits in the transition zone, where neither northern nor southern grasses are '
                    . 'entirely at home. Bermuda and zoysia handle full Upstate sun and summer heat best. Tall '
                    . 'fescue holds up better in shade but thins each August and needs overseeding every fall. '
                    . 'Most Greenville County properties end up running both, which is why treatment timing differs across one yard.',
    ],
    [
        'question' => 'How often should a lawn be mowed in Greenville County?',
        'answer'   => 'Weekly from roughly May through September, when Upstate growth peaks, and every other week '
                    . 'in the shoulder seasons. The governing rule is to remove no more than one third of the blade '
                    . 'in a single cut — scalping a stressed summer lawn invites weeds and disease. Greenville Lawn '
                    . 'Masters sets a fixed route so the interval never stretches.',
    ],
    [
        'question' => 'What areas does Greenville Lawn Masters serve around Mauldin?',
        'answer'   => 'Greenville Lawn Masters is based in Mauldin, South Carolina and serves properties within '
                    . 'roughly 25 miles, covering much of the Greenville County area. If you are searching for lawn '
                    . 'care near me in Mauldin, the service area almost certainly reaches you. Both residential lawns '
                    . 'and commercial grounds, including HOA and apartment properties, are on the route.',
    ],
];

/* ── Schema ────────────────────────────────────────────────────
   head.php already prepends the LocalBusiness node and appends WebSite for the
   homepage — do not restate either here. This adds the FAQPage mirroring the
   visible FAQ, plus a WebPage node carrying Speakable (aeo-content-schema §1.2.5).
   The Speakable cssSelector values must exist in the markup below. */
$pageSchema = [
    generateFAQSchema($faqs),
    [
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        '@id'       => absoluteUrl('/') . '#webpage',
        'url'       => absoluteUrl('/'),
        'name'      => $pageTitle,
        'about'     => ['@id' => organizationId()],
        'primaryImageOfPage' => $ogImageUrl,
        'speakable' => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.hero-answer', '.faq-answer', 'h1'],
        ],
    ],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
?>
<style>
/* ============================================================
   Homepage-specific styles (Phase 3)
   Premium tier: 400+ lines, 6+ techniques from design-system.md Part C.
   Colour, shadow, and spacing values are var() tokens without exception —
   raw literals here are an automatic QA fail (CLAUDE.md tier matrix).
   ============================================================ */

/* ── C1.1 Layered hero ────────────────────────────────────────
   Photo, then a gradient pseudo-element, then a noise pseudo-element, then
   content. The source photograph is 370px wide upscaled to 1600px, so the
   overlay is doing double duty: text legibility and hiding softness. */
.hero-home {
  min-height: 100vh;    /* fallback for browsers without svh */
  min-height: 100svh;   /* excludes the mobile URL bar so the form stays in view */
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-front-lawn.jpg');
  background-size: cover;
  background-position: center 60%;
  isolation: isolate;
}
.hero-home::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    linear-gradient(
      100deg,
      rgba(var(--color-dark-rgb), 0.94) 0%,
      rgba(var(--color-dark-rgb), 0.82) 38%,
      rgba(var(--color-primary-rgb), 0.55) 68%,
      rgba(var(--color-primary-rgb), 0.32) 100%
    );
  z-index: 0;
}
.hero-home::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.35;
  z-index: 0;
  pointer-events: none;
}

.hero-grid {
  position: relative;
  z-index: 2;
  display: grid;
  grid-template-columns: 1.5fr 1fr;   /* 60 / 40 */
  gap: var(--space-12);
  align-items: center;
  width: 100%;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}

/* ── C2 Hero composition cascade ──────────────────────────────
   Entrance is pure CSS keyframes, never a reveal class: above-fold content must
   never depend on IntersectionObserver (CLAUDE.md). Worst case here is content
   that animated before you looked at it. */
.hero-eyebrow-badge {
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
  margin-bottom: var(--space-6);
  animation: heroDown 0.65s ease both;
}
.hero-eyebrow-badge i, .hero-eyebrow-badge svg { width: 15px; height: 15px; }

.hero-home .hero-title {
  font-size: clamp(2.4rem, 5.4vw, 4.4rem);
  line-height: 1.05;
  letter-spacing: -0.03em;
  color: var(--color-white);
  margin-bottom: var(--space-5);
  animation: heroUp 0.65s ease 0.12s both;
}
.hero-home .hero-title .text-accent { color: var(--color-accent); }

.hero-home .hero-subtitle {
  max-width: 54ch;
  margin: 0 0 var(--space-8);
  color: rgba(var(--color-white-rgb), 0.9);
  font-size: var(--font-size-lg);
  line-height: 1.7;
  animation: heroUp 0.65s ease 0.25s both;
}

.hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: heroUp 0.65s ease 0.38s both;
}

.hero-trust-row {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: heroUp 0.65s ease 0.5s both;
}
.hero-trust-item {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.hero-trust-item i, .hero-trust-item svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

@keyframes heroDown {
  from { opacity: 0; transform: translateY(-14px); }
  to   { opacity: 1; transform: translateY(0); }
}
@keyframes heroUp {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* ── Hero lead-capture card (glassmorphism) ───────────────────*/
.hero-form-card {
  position: relative;
  background: rgba(var(--color-white-rgb), 0.1);
  backdrop-filter: blur(16px);
  -webkit-backdrop-filter: blur(16px);
  border: 1px solid rgba(var(--color-white-rgb), 0.18);
  border-radius: var(--radius-xl);
  padding: var(--space-8);
  box-shadow: var(--shadow-xl);
  animation: heroUp 0.65s ease 0.3s both;
  scroll-margin-top: calc(var(--nav-height) + var(--space-4));
}
.hero-form-title {
  font-family: var(--font-heading);
  font-weight: 800;
  line-height: 1.2;
  color: var(--color-white);
  font-size: var(--font-size-2xl);
  margin-bottom: var(--space-1);
  text-wrap: balance;
}
.hero-form-tagline {
  color: var(--color-accent);
  font-family: var(--font-heading);
  font-style: italic;
  font-size: var(--font-size-sm);
  margin-bottom: var(--space-6);
}

.hero-form .form-row { position: relative; margin-bottom: var(--space-4); }

/* Floating labels — a real <label>, not a placeholder masquerading as one.
   The `placeholder=" "` single space is what drives :placeholder-shown.
   Everything here is scoped to .form-row: an unscoped `.hero-form label` would
   also catch the consent checkbox's label and absolutely-position it. */
.hero-form .form-row input,
.hero-form .form-row select {
  width: 100%;
  padding: var(--space-5) var(--space-4) var(--space-2);
  font-family: var(--font-body);
  font-size: var(--font-size-base);
  color: var(--color-white);
  background: rgba(var(--color-dark-rgb), 0.42);
  border: 1px solid rgba(var(--color-white-rgb), 0.22);
  border-radius: var(--radius-md);
  transition: border-color var(--transition-base), background var(--transition-base);
  appearance: none;
  -webkit-appearance: none;
  min-height: 56px;   /* comfortable mobile touch target */
}
.hero-form .form-row input:hover,
.hero-form .form-row select:hover { border-color: rgba(var(--color-white-rgb), 0.4); }
.hero-form .form-row input:focus,
.hero-form .form-row select:focus {
  outline: none;
  border-color: var(--color-accent);
  background: rgba(var(--color-dark-rgb), 0.62);
}
.hero-form .form-row input:focus-visible,
.hero-form .form-row select:focus-visible { outline: 2px solid var(--color-accent); outline-offset: 2px; }

.hero-form .form-row label {
  position: absolute;
  left: var(--space-4);
  top: 50%;
  transform: translateY(-50%);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-base);
  pointer-events: none;
  transition: transform var(--transition-fast), font-size var(--transition-fast), color var(--transition-fast);
}
/* The select always displays an option, so its label stays raised. Text inputs
   raise theirs on focus or once filled — `placeholder=" "` drives the latter. */
.hero-form .form-row input:focus + label,
.hero-form .form-row input:not(:placeholder-shown) + label,
.hero-form .form-row select + label {
  top: var(--space-2);
  transform: translateY(0);
  font-size: var(--font-size-xs);
  color: var(--color-accent);
  letter-spacing: 0.04em;
}
.hero-form .form-row select {
  color: rgba(var(--color-white-rgb), 0.92);
  padding-right: var(--space-10);   /* clears the caret icon */
  cursor: pointer;
}
.hero-form .form-row select option { background: var(--color-dark); color: var(--color-white); }

.hero-form .select-caret {
  position: absolute;
  right: var(--space-4);
  top: 50%;
  transform: translateY(-50%);
  width: 18px; height: 18px;
  color: var(--color-accent);
  pointer-events: none;
}

/* Required TCPA terms checkbox. The two optional opt-ins (email, SMS) live on
   /contact — but the required one belongs on any form that captures a phone
   number, or `_consent_version` records a consent that was never given. */
.hero-form .form-consent-item {
  display: flex;
  align-items: flex-start;
  gap: var(--space-3);
  margin-bottom: var(--space-5);
}
/* Sits outside .form-row, so it never picks up the floating-label input styling
   (whose appearance:none would erase the control). Keep it that way. */
.hero-form .consent-checkbox {
  flex-shrink: 0;
  width: 20px;
  height: 20px;
  margin-top: 2px;
  accent-color: var(--color-accent);
  cursor: pointer;
}
.hero-form .consent-label {
  font-size: var(--font-size-xs);
  line-height: 1.55;
  color: rgba(var(--color-white-rgb), 0.78);
}
.hero-form .consent-label a { color: var(--color-accent); text-decoration: underline; }
.hero-form .required-star { color: var(--color-accent); }

.form-footnote {
  margin: var(--space-3) 0 0;
  font-size: var(--font-size-xs);
  line-height: 1.5;
  color: rgba(var(--color-white-rgb), 0.6);
  text-align: center;
}
.form-footnote a { color: rgba(var(--color-white-rgb), 0.85); text-decoration: underline; }

/* ── C8 Ticker strip ──────────────────────────────────────────*/
.ticker-outer {
  background: var(--color-primary);
  overflow: hidden;
  padding: var(--space-3) 0;
  border-top: 2px solid var(--color-accent);
  border-bottom: 2px solid rgba(var(--color-accent-rgb), 0.18);
}
.ticker-track-inner {
  display: flex;
  white-space: nowrap;
  width: max-content;
  animation: ticker-scroll 44s linear infinite;
}
.ticker-track-inner:hover { animation-play-state: paused; }
.ticker-item {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  padding: 0 var(--space-8);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: rgba(var(--color-white-rgb), 0.9);
  flex-shrink: 0;
}
.ticker-item i, .ticker-item svg { width: 15px; height: 15px; color: var(--color-accent); }
@media (prefers-reduced-motion: reduce) {
  .ticker-track-inner { animation: none; }
}

/* ── C5.1 Numbered section eyebrows ───────────────────────────*/
.numbered-section .section-num {
  display: block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--color-accent);
  margin-bottom: var(--space-2);
}
/* Oversized ghost numeral, bled off the section's top-right corner. */
.numbered-section::before {
  content: attr(data-num);
  position: absolute;
  top: var(--space-4);
  right: var(--space-6);
  font-family: var(--font-heading);
  font-size: clamp(6rem, 14vw, 13rem);
  font-weight: 900;
  line-height: 0.8;
  color: rgba(var(--color-primary-rgb), 0.05);
  pointer-events: none;
  z-index: 0;
}
.numbered-section > .container { position: relative; z-index: 1; }
.numbered-section--dark::before { color: rgba(var(--color-white-rgb), 0.045); }

/* ── Services ─────────────────────────────────────────────────*/
.services-section { background: var(--color-white); }
.services-section .section-header { max-width: 760px; margin-inline: auto; }
.services-section .section-header h2 { margin-bottom: var(--space-4); }
.services-cta { margin-top: var(--space-12); text-align: center; }

/* The answer paragraph is the AEO payload and the Speakable target — it must
   not inherit framework.css's narrow, muted `.section-header p` treatment. */
.section-header .hero-answer {
  max-width: 68ch;
  margin: 0 auto var(--space-5);
  color: var(--color-gray-dark);
  font-size: var(--font-size-lg);
  line-height: 1.7;
}

/* ── C6.3 Stats band with internal dividers ───────────────────*/
.stats-band {
  background: var(--color-primary);
  padding: var(--space-16) 0 var(--space-16);
}
.stats-row {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-4);
  text-align: center;
}
.stat-block {
  padding: var(--space-4);
  border-right: 1px solid rgba(var(--color-white-rgb), 0.14);
}
.stat-block:last-child { border-right: none; }
.stat-number-large {
  display: block;
  font-family: var(--font-heading);
  font-size: clamp(2.4rem, 5vw, 3.4rem);
  font-weight: 900;
  color: var(--color-white);
  line-height: 1;
  font-variant-numeric: tabular-nums;
}
.stat-label-text {
  display: block;
  font-size: var(--font-size-xs);
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: rgba(var(--color-white-rgb), 0.62);
  margin-top: var(--space-3);
  line-height: 1.5;
}

/* ── C9.1 Mid-page CTA, gradient + noise ──────────────────────*/
.cta-mid {
  background: linear-gradient(
    135deg,
    var(--color-primary-dark) 0%,
    var(--color-primary) 55%,
    var(--color-secondary) 100%
  );
  text-align: center;
}
.cta-mid::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.3;
  pointer-events: none;
}
.cta-mid .container { position: relative; z-index: 1; }
.cta-mid h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.cta-mid p {
  color: rgba(var(--color-white-rgb), 0.88);
  max-width: 60ch;
  margin: 0 auto var(--space-8);
}
.cta-phone-display {
  display: block;
  font-family: var(--font-heading);
  font-size: clamp(1.8rem, 4vw, 2.4rem);
  font-weight: 800;
  color: var(--color-accent);
  margin-bottom: var(--space-6);
  letter-spacing: -0.02em;
}
.cta-phone-display:hover { color: var(--color-white); }

/* ── C6.2 About split with overlapping badge (asymmetric) ─────*/
.about-section { background: var(--color-light); }
.about-layout {
  display: grid;
  grid-template-columns: 1.45fr 1fr;   /* broken grid — never 50/50 */
  gap: var(--space-16);
  align-items: start;
}
.about-copy > p { color: var(--color-gray-dark); max-width: 62ch; }

/* ── C6.5 Process steps, numbered circles ────────────────────*/
.process-steps {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  margin-top: var(--space-10);
  list-style: none;   /* it's an <ol> — the .step-num circles are the numbering */
  padding: 0;
}
.process-step {
  display: flex;
  align-items: flex-start;
  gap: var(--space-5);
  padding: var(--space-4);
  background: var(--color-white);
  border-radius: var(--radius-md);
  transition: background var(--transition-fast), box-shadow var(--transition-fast), transform var(--transition-fast);
}
.process-step:hover {
  background: rgba(var(--color-accent-rgb), 0.07);
  box-shadow: var(--shadow-sm);
  transform: translateX(4px);
}
.step-num {
  flex-shrink: 0;
  width: 38px; height: 38px;
  background: var(--color-primary);
  color: var(--color-white);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: var(--font-heading);
  font-weight: 800;
  font-size: var(--font-size-sm);
}
.process-step h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-1); }
.process-step p { font-size: var(--font-size-sm); color: var(--color-gray-dark); margin: 0; }

/* ── C11.1 Framed image with offset accent block ─────────────*/
.about-media { position: relative; padding: 0 var(--space-5) var(--space-5) 0; }
.about-media::before {
  content: '';
  position: absolute;
  inset: var(--space-5) 0 0 var(--space-5);
  background: var(--color-accent);
  border-radius: var(--radius-lg);
  z-index: 0;
}
/* 4/3 matches the 370x278 source. A taller crop (4/5) would throw away the sides
   and upscale what's left — this photo has no resolution to spare. */
.about-media img {
  position: relative;
  z-index: 1;
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
}
/* The overlap IS the technique — the badge breaks the image's bounding box. */
.about-stat-card {
  position: absolute;
  bottom: 0;
  right: 0;
  z-index: 2;
  background: var(--color-primary);
  color: var(--color-white);
  padding: var(--space-6) var(--space-8);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-xl);
  text-align: center;
  min-width: 150px;
}
.about-stat-card .year-label {
  display: block;
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  opacity: 0.88;
  margin-bottom: var(--space-2);
}
.about-stat-card .big-year {
  display: block;
  font-family: var(--font-heading);
  font-size: var(--font-size-4xl);
  font-weight: 900;
  line-height: 1;
}

/* ── C7 Signature section: dark proof gallery ────────────────
   This is the one layout that appears nowhere else on the page. */
.proof-section { background: var(--color-dark); }
.proof-section .section-header h2 { color: var(--color-white); }
.proof-section .hero-answer { color: rgba(var(--color-white-rgb), 0.75); }
.proof-section .section-num { color: var(--color-accent); }

.work-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
}
/* C6.4 glassmorphism cards on the dark section */
.work-card {
  background: rgba(var(--color-white-rgb), 0.05);
  backdrop-filter: blur(8px);
  -webkit-backdrop-filter: blur(8px);
  border: 1px solid rgba(var(--color-white-rgb), 0.09);
  border-radius: var(--radius-lg);
  overflow: hidden;
  transition: transform var(--transition-base), border-color var(--transition-base);
}
.work-card:hover { transform: translateY(-4px); border-color: rgba(var(--color-accent-rgb), 0.5); }
.work-card img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
}
.work-card figcaption {
  padding: var(--space-4) var(--space-5);
  font-size: var(--font-size-sm);
  color: rgba(var(--color-white-rgb), 0.72);
  line-height: 1.55;
}
.work-card figcaption strong {
  display: block;
  color: var(--color-white);
  font-family: var(--font-heading);
  margin-bottom: var(--space-1);
}

/* Honest stand-in for the reviews carousel while intake has zero reviews. */
.proof-note {
  margin-top: var(--space-12);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
  background: rgba(var(--color-white-rgb), 0.04);
  border-radius: 0 var(--radius-md) var(--radius-md) 0;
  max-width: 70ch;
}
.proof-note p { color: rgba(var(--color-white-rgb), 0.72); font-size: var(--font-size-sm); margin: 0; }

/* ── FAQ ─────────────────────────────────────────────────────
   Both selectors carry two classes so they outrank framework.css's
   `.faq-item h3` and `.faq-item p`, which are one class + one type. */
.faq-section { background: var(--color-white); }
.faq-section .faq-item { align-items: flex-start; background: var(--color-card-tint-1); }
.faq-section .faq-question { font-size: var(--font-size-lg); margin-bottom: var(--space-2); }
.faq-section .faq-answer { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.7; margin: 0; }

/* ── C9.2 Closing CTA with radial glow ───────────────────────*/
.closing-cta {
  background: var(--color-primary);
  text-align: center;
}
.closing-cta::before {
  content: '';
  position: absolute;
  inset: 0;
  background: radial-gradient(ellipse at 50% 0%, rgba(var(--color-accent-rgb), 0.24) 0%, transparent 65%);
  pointer-events: none;
}
.closing-cta .container { position: relative; z-index: 1; }
.closing-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.closing-cta p {
  color: rgba(var(--color-white-rgb), 0.88);
  max-width: 58ch;
  margin: 0 auto var(--space-8);
}
.closing-actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ──────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .hero-grid { grid-template-columns: 1fr; gap: var(--space-10); }
  .hero-home { min-height: 0; }
  .hero-home .hero-subtitle { max-width: none; }
  .about-layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .about-media { max-width: 460px; }
  .work-grid { grid-template-columns: repeat(2, 1fr); }

  /* Keep the stat dividers legible once the band folds to 2x2 */
  .stats-row { grid-template-columns: repeat(2, 1fr); }
  .stat-block {
    border-right: none;
    border-bottom: 1px solid rgba(var(--color-white-rgb), 0.12);
    padding-bottom: var(--space-6);
  }
  .stat-block:nth-child(odd) { border-right: 1px solid rgba(var(--color-white-rgb), 0.12); }
  .stat-block:nth-last-child(-n+2) { border-bottom: none; }
}

@media (max-width: 768px) {
  /* Hero text first, form immediately beneath it — still above the fold on
     most handsets because the hero drops its 100svh floor at this width. */
  .hero-grid { padding-block: calc(var(--nav-height) + var(--space-8)) var(--space-12); }
  .hero-form-card { padding: var(--space-6); }
  .hero-actions { flex-direction: column; align-items: stretch; }
  .hero-actions .btn { width: 100%; }
  .work-grid { grid-template-columns: 1fr; }
  .numbered-section::before { font-size: clamp(4rem, 20vw, 7rem); opacity: 0.7; }
}

@media (max-width: 480px) {
  .hero-trust-row { gap: var(--space-2) var(--space-4); }
  .about-media { padding: 0 var(--space-4) var(--space-4) 0; }
  .about-stat-card { padding: var(--space-4) var(--space-5); min-width: 0; }
  .closing-actions { flex-direction: column; }
}
</style>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php'; ?>

<!-- ══════════ HERO ══════════ -->
<section class="hero hero-home" aria-label="Lawn care in Mauldin, South Carolina">
    <div class="container hero-grid">

        <div class="hero-text">
            <span class="hero-eyebrow-badge">
                <i data-lucide="shield-check" aria-hidden="true"></i>
                Serving <?php echo e($address['city']); ?> Since <?php echo e((string) $yearEstablished); ?>
            </span>

            <h1 class="hero-title">
                Lawn Care in <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?>
                That <span class="text-accent">Looks Sharp</span> Between Visits
            </h1>

            <p class="hero-subtitle">
                <?php echo e($siteName); ?> keeps <?php echo e($address['city']); ?> and Greenville County
                properties mowed, fed, edged, and cleaned up — all from one crew, on a schedule you
                can plan around. Tell us what the yard needs and a written estimate follows within
                24 hours.
            </p>

            <div class="hero-actions">
                <a href="#estimate-form" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* No phone in intake. Rendering "Call Now" with no number, or a fake
                             one, is worse than sending the visitor to the services list. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust indicators are limited to facts intake actually recorded. There is
                     deliberately no "Licensed & Insured" badge and no Google rating here:
                     config.php has no licence number, no insurance record, and no GBP profile,
                     and both claims are ones a competitor or a regulator can check. */ ?>
            <div class="hero-trust-row">
                <span class="hero-trust-item">
                    <i data-lucide="map-pin" aria-hidden="true"></i>
                    Locally owned in <?php echo e($address['city']); ?>
                </span>
                <span class="hero-trust-item">
                    <i data-lucide="clock" aria-hidden="true"></i>
                    Estimate within 24 hours
                </span>
                <span class="hero-trust-item">
                    <i data-lucide="list-checks" aria-hidden="true"></i>
                    <?php echo e((string) count($services)); ?> services, one crew
                </span>
                <span class="hero-trust-item">
                    <i data-lucide="map" aria-hidden="true"></i>
                    <?php echo e((string) $targetRadius); ?>-mile service radius
                </span>
            </div>
        </div>

        <!-- Hero lead capture. Field names (name/email/phone/service) match the CRM
             contract exactly — the endpoint rejects a submission missing name, email,
             or phone, so email stays in even though this is the "short" form. -->
        <aside class="hero-form-card" id="estimate-form" aria-labelledby="estimate-form-title">
            <?php /* A <p>, not an <h2>. Every content H2 on the page is phrased as a
                     question (aeo-content-schema §1.1, enforced by QA); this is form
                     chrome, not content. aria-labelledby keeps the region named for
                     screen readers without polluting the heading outline. */ ?>
            <p class="hero-form-title" id="estimate-form-title">Get Your Free Estimate</p>
            <p class="hero-form-tagline">No obligation. Written estimate within 24 hours.</p>

            <form action="<?php echo e($formAction); ?>" method="POST" class="hero-form">

                <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">

                <input type="hidden" name="_next" value="/thank-you">
                <input type="hidden" name="_form_location" value="hero">
                <input type="hidden" name="_consent_version" value="<?php echo e($consentVersion); ?>">
                <input type="hidden" name="_consent_page" value="<?php echo e($_SERVER['REQUEST_URI'] ?? '/'); ?>">

                <div class="form-row">
                    <input type="text" id="hero-name" name="name" placeholder=" " autocomplete="name" required>
                    <label for="hero-name">Full name</label>
                </div>

                <div class="form-row">
                    <input type="tel" id="hero-phone" name="phone" placeholder=" " autocomplete="tel" required>
                    <label for="hero-phone">Phone number</label>
                </div>

                <div class="form-row">
                    <input type="email" id="hero-email" name="email" placeholder=" " autocomplete="email" required>
                    <label for="hero-email">Email address</label>
                </div>

                <div class="form-row">
                    <select id="hero-service" name="service">
                        <option value="">Not sure yet</option>
                        <?php foreach ($servicePages as $servicePage): ?>
                            <option value="<?php echo e($servicePage['title']); ?>"><?php echo e($servicePage['title']); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="hero-service">What do you need?</label>
                    <i data-lucide="chevron-down" class="select-caret" aria-hidden="true"></i>
                </div>

                <?php /* The one REQUIRED consent box. Email and SMS opt-ins are separate,
                         unbundled, and live on /contact (Texas TCPA, Sept 2025). Without this,
                         `_consent_version` would be written to consent_records against a
                         consent the visitor never actually gave. */ ?>
                <div class="form-consent-item">
                    <input type="checkbox" name="terms_accepted" id="hero-terms" value="yes" class="consent-checkbox" required>
                    <label for="hero-terms" class="consent-label">
                        I have read and agree to the <a href="/privacy-policy/">Privacy Policy</a>
                        and <a href="/terms/">Terms of Service</a>. <span class="required-star">*</span>
                    </label>
                </div>

                <!-- spam shield: signed render timestamp + JS interaction signal -->
                <?php $__ft_ts = (string) time(); ?>
                <input type="hidden" name="_ft" value="<?php echo $__ft_ts . '.' . hash_hmac('sha256', $__ft_ts, $leadsFormSecret); ?>">
                <input type="hidden" name="_js" value="" class="js-shield-field">
                <?php if (empty($GLOBALS['__js_shield'])) { $GLOBALS['__js_shield'] = 1; ?>
                <script>(function(){var d=document,f=function(){var i,e=d.querySelectorAll('.js-shield-field');for(i=0;i<e.length;i++)e[i].value='1';d.removeEventListener('pointerdown',f);d.removeEventListener('keydown',f);};d.addEventListener('pointerdown',f);d.addEventListener('keydown',f);})();</script>
                <?php } ?>
                <button type="submit" class="btn btn-accent btn-block btn-lg">Get My Free Estimate</button>

                <p class="form-footnote">
                    Prefer email? Opt in to updates and text messages on the
                    <a href="/contact/">full contact form</a>.
                </p>
            </form>
        </aside>
    </div>

    <!-- Divider 3.4 — torn paper edge, filled with the ticker's accent green -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,40 L60,42 L120,35 L200,45 L280,32 L360,48 L440,38 L540,45 L640,30 L740,42 L840,35 L940,45 L1040,32 L1140,42 L1200,38 L1200,60 Z" fill="var(--color-accent)"/>
        </svg>
    </div>
</section>

<!-- ══════════ C8 · TICKER ══════════ -->
<div class="ticker-outer" aria-hidden="true">
    <div class="ticker-track-inner">
        <?php
        $tickerItems = [
            ['scissors', 'Mowing, Edging &amp; Trimming'],
            ['sprout', 'Fertilization &amp; Weed Control'],
            ['shovel', 'Aeration &amp; Overseeding'],
            ['flower-2', 'Mulch Installation'],
            ['layers', 'Sod Installation'],
            ['wind', 'Leaf &amp; Storm Debris Cleanup'],
            ['droplets', 'Gutter Cleaning'],
            ['spray-can', 'Pressure Washing'],
            ['map-pin', 'Serving Mauldin &amp; Greenville County'],
            ['clock', 'Free Estimates Within 24 Hours'],
        ];
        /* Rendered twice — the -50% keyframe translate needs a duplicate run
           of the content to loop without a visible seam. */
        for ($pass = 0; $pass < 2; $pass++) {
            foreach ($tickerItems as [$icon, $labelHtml]) {
                echo '<span class="ticker-item"><i data-lucide="' . e($icon) . '"></i>' . $labelHtml . '</span>';
            }
        }
        ?>
    </div>
</div>

<!-- ══════════ 01 · SERVICES ══════════ -->
<section class="numbered-section services-section" data-num="01" aria-label="Lawn and landscape services">
    <div class="container">

        <div class="section-header reveal-up">
            <?php /* The numbered eyebrow and the .eyebrow-label sit stacked, so they must
                     not say the same thing. "What We Do" is the literal required by
                     CLAUDE.md for the eyebrow, so the numeral carries a different word. */ ?>
            <span class="section-num">01 / Services</span>
            <span class="eyebrow-label">What We Do</span>
            <h2>What lawn care services does <span class="text-accent">Greenville Lawn Masters</span> offer in Mauldin?</h2>

            <p class="hero-answer">
                Greenville Lawn Masters offers <?php echo e((string) count($services)); ?> lawn and landscape
                services across Mauldin and Greenville County, from weekly mowing and fertilization to
                aeration, sod, mulch, gutter cleaning, and pressure washing. One crew handles routine
                maintenance and seasonal projects, so you are not coordinating three vendors to keep
                one property looking right.
            </p>

            <span class="section-subtitle"><?php echo e($tagline); ?></span>

            <p class="prose prose-centered">
                Routine work runs on a fixed route. Seasonal work — aeration, overseeding, mulch,
                cleanups — is timed to the Upstate calendar rather than booked whenever the phone rings.
            </p>
        </div>

        <div class="services-grid">
            <?php foreach ($homeServices as $i => $card):
                /* Tints and stagger delays rotate 1→2→3 so no two adjacent cards match. */
                $rotation = ($i % 3) + 1;
                $photo    = $photoLibrary[$card['photo']];
            ?>
                <article class="service-card-with-image card-tint-<?php echo $rotation; ?> reveal-up reveal-delay-<?php echo $rotation; ?>">
                    <div class="service-card__image">
                        <img src="<?php echo e($photo['src']); ?>"
                             alt="<?php echo e($photo['alt']); ?>"
                             width="<?php echo e((string) $photo['w']); ?>"
                             height="<?php echo e((string) $photo['h']); ?>"
                             loading="lazy" decoding="async">
                    </div>
                    <div class="service-card__body">
                        <div class="service-card__icon"><i data-lucide="<?php echo e($card['icon']); ?>" aria-hidden="true"></i></div>
                        <h3><?php echo e($card['service']); ?></h3>
                        <p class="service-card__desc"><?php echo e($card['desc']); ?></p>
                        <ul>
                            <?php foreach ($card['bullets'] as $bullet): ?>
                                <li><?php echo e($bullet); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="<?php echo e(getServicePageUrl($card['service'])); ?>" class="service-card__cta">
                            Learn more<span class="sr-only"> about <?php echo e($card['service']); ?></span>
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="services-cta reveal-scale">
            <a href="/services/" class="btn btn-secondary btn-lg">
                View All <?php echo e((string) count($services)); ?> Services
            </a>
        </div>
    </div>

    <!-- Divider 3.3 — double wave, filled with the stats band's primary green -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-primary)" opacity="0.4"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-primary)"/>
        </svg>
    </div>
</section>

<!-- ══════════ C6.3 · STATS ══════════ -->
<?php /* Four verifiable numbers. There is no "jobs completed" figure here because
         intake never supplied one and an estimated count presented as a counter
         animation reads as a hard fact. */ ?>
<section class="stats-band" aria-label="Greenville Lawn Masters by the numbers">
    <div class="container">
        <div class="stats-row">
            <div class="stat-block reveal-up">
                <span class="stat-number-large" data-counter="<?php echo e((string) $yearsInBusiness); ?>"><?php echo e((string) $yearsInBusiness); ?></span>
                <span class="stat-label-text">Years serving <?php echo e($address['city']); ?></span>
            </div>
            <div class="stat-block reveal-up reveal-delay-1">
                <span class="stat-number-large" data-counter="<?php echo e((string) count($services)); ?>"><?php echo e((string) count($services)); ?></span>
                <span class="stat-label-text">Lawn &amp; landscape services</span>
            </div>
            <div class="stat-block reveal-up reveal-delay-2">
                <span class="stat-number-large" data-counter="<?php echo e((string) $targetRadius); ?>" data-suffix=" mi"><?php echo e((string) $targetRadius); ?> mi</span>
                <span class="stat-label-text">Service radius from <?php echo e($address['city']); ?></span>
            </div>
            <div class="stat-block reveal-up reveal-delay-3">
                <span class="stat-number-large" data-counter="24" data-suffix=" hr">24 hr</span>
                <span class="stat-label-text">Estimate turnaround</span>
            </div>
        </div>
    </div>

    <!-- Divider 3.5 — stacked parallelograms, filled with the CTA's gradient start -->
    <div class="svg-divider" style="height:72px" aria-hidden="true">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
            <polygon fill="var(--color-primary-dark)" opacity="0.35" points="0,20 1200,40 1200,80 0,80"/>
            <polygon fill="var(--color-primary-dark)" points="0,40 1200,20 1200,80 0,80"/>
        </svg>
    </div>
</section>

<!-- ══════════ C9.1 · MID-PAGE CTA ══════════ -->
<section class="cta-mid" aria-label="Book a lawn care estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to get your Mauldin lawn on a schedule?</h2>

        <p class="reveal-up reveal-delay-1">
            In the Upstate, the crabgrass pre-emergent window opens when soil temperatures reach
            about 55°F — usually late February into March. Miss it and the rest of the year is spent
            pulling weeds instead of preventing them. Booking a walkthrough now puts your property
            on the route before the season turns.
        </p>

        <?php if ($hasPhone): ?>
            <a href="tel:<?php echo e($phoneLink); ?>" class="cta-phone-display reveal-scale"><?php echo e($phoneDisplay); ?></a>
        <?php endif; ?>

        <a href="#estimate-form" class="btn btn-accent btn-lg reveal-up reveal-delay-2">
            <i data-lucide="calendar-check" aria-hidden="true"></i>
            Book My Free Walkthrough
        </a>
    </div>

    <!-- Divider 3.2 — curved wave, filled with the about section's light background -->
    <div class="svg-divider" style="height:76px" aria-hidden="true">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
            <path d="M0,40 C300,80 900,0 1200,40 L1200,80 L0,80 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 02 · ABOUT + PROCESS ══════════ -->
<section class="numbered-section about-section" data-num="02" aria-label="About Greenville Lawn Masters">
    <div class="container">
        <div class="about-layout">

            <div class="about-copy">
                <span class="section-num reveal-left">02 / Who We Are</span>
                <h2 class="reveal-left">What is it like to work with <span class="text-accent">Greenville Lawn Masters</span>?</h2>

                <p class="reveal-left reveal-delay-1">
                    Greenville Lawn Masters is a Mauldin-based lawn and landscape company that has
                    worked Greenville County properties since <?php echo e((string) $yearEstablished); ?>.
                    One crew handles the whole property — the mowing route, the fertilization program,
                    the beds, the gutters, the seasonal cleanup — so nothing gets handed off between
                    contractors and nothing falls between them.
                </p>

                <p class="reveal-left reveal-delay-2">
                    Lawns here sit in the transition zone. Bermuda and zoysia take the full sun,
                    tall fescue holds the shade, and heavy Piedmont clay sits under all of it. That
                    mix decides when a lawn gets cored, when it gets seeded, and when it gets fed —
                    which is why the schedule is built around the grass actually growing on your
                    property rather than a generic service calendar.
                </p>

                <ol class="process-steps">
                    <?php foreach ($processSteps as $i => $step): ?>
                        <li class="process-step reveal-left reveal-delay-<?php echo (($i % 4) + 1); ?>">
                            <span class="step-num" aria-hidden="true"><?php echo str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT); ?></span>
                            <div>
                                <h3><?php echo e($step['title']); ?></h3>
                                <p><?php echo e($step['body']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>

            <div class="about-media reveal-right">
                <img src="<?php echo e($photoLibrary['mulch_bed']['src']); ?>"
                     alt="<?php echo e($photoLibrary['mulch_bed']['alt']); ?>"
                     width="<?php echo e((string) $photoLibrary['mulch_bed']['w']); ?>"
                     height="<?php echo e((string) $photoLibrary['mulch_bed']['h']); ?>"
                     loading="lazy" decoding="async">
                <?php /* Label above the numeral so it reads "Serving Mauldin since / 2024"
                         top-to-bottom rather than backwards. */ ?>
                <div class="about-stat-card">
                    <span class="year-label">Serving <?php echo e($address['city']); ?> since</span>
                    <span class="big-year"><?php echo e((string) $yearEstablished); ?></span>
                </div>
            </div>

        </div>
    </div>

    <!-- Divider 3.1 — diagonal, filled with the proof section's dark background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-dark)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 03 · PROOF OF WORK (signature section) ══════════ -->
<?php /* ─────────────────────────────────────────────────────────────
     This slot is specified as a 5-card review carousel. build-plan.json
     `reviews` is an empty array, no Google rating or review count was
     supplied, and $gbpUrl is blank.

     Writing five testimonials would mean attributing invented quotes to
     invented customers — an FTC Endorsement Guides problem, not a
     placeholder. CLAUDE.md separately forbids fabricating review counts
     or ratings. So the slot instead shows the client's own job-site
     photography, which is real and which nothing else on the page uses
     at this scale.

     The carousel below is live code, not a stub: drop real entries into
     $reviews in config.php and it renders (and footer.php loads Swiper,
     because $useSwiper reads the same array).
   ───────────────────────────────────────────────────────────────── */ ?>
<section class="numbered-section numbered-section--dark proof-section" data-num="03" aria-label="Greenville Lawn Masters job site photography">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="section-num">03 / The Work</span>
            <h2>What does a <span class="text-accent">Greenville Lawn Masters</span> job actually look like?</h2>
            <p class="hero-answer">
                Greenville Lawn Masters uses its own job-site photography on this website — no stock
                images. The pictures below come from properties the crew has serviced in and around
                Mauldin, South Carolina, and show the actual standard of finish for mowing, hedge
                trimming, mulch installation, and driveway cleaning.
            </p>
        </div>

        <?php if (!empty($reviews)): ?>
            <?php /* Renders as soon as config.php's $reviews array has entries. */ ?>
            <div class="swiper reviews-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($reviews as $review): ?>
                        <div class="swiper-slide">
                            <article class="review-card">
                                <div class="review-stars" aria-label="<?php echo e((string) $review['rating']); ?> out of 5 stars">
                                    <?php for ($s = 0; $s < (int) $review['rating']; $s++): ?>
                                        <span class="star" aria-hidden="true">&#9733;</span>
                                    <?php endfor; ?>
                                </div>
                                <p class="review-text">&ldquo;<?php echo e($review['text']); ?>&rdquo;</p>
                                <div class="review-author">
                                    <span class="review-avatar" aria-hidden="true"><?php echo e(strtoupper(substr($review['name'], 0, 1))); ?></span>
                                    <div>
                                        <div class="review-name"><?php echo e($review['name']); ?></div>
                                        <div class="review-date"><?php echo e($review['location']); ?> &middot; <?php echo e($review['service']); ?></div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <button class="swiper-button-prev" type="button" aria-label="Previous review"></button>
                <button class="swiper-button-next" type="button" aria-label="Next review"></button>
            </div>
        <?php else: ?>
            <div class="work-grid">
                <?php
                $workPhotos = [
                    ['mowing',     'Weekly mowing',      'A backyard cut on the weekly route in Mauldin — striped, edged, and blown clean before the gate closes.'],
                    ['hedges',     'Hedge trimming',     'Foundation hedges shaped back off the windows and walkway at a brick home in Greenville County.'],
                    ['mulch_bed',  'Mulch installation', 'Beds re-edged and mulched to an even depth along the front walk of a Craftsman home.'],
                    ['backyard',   'Beds and borders',   'Backyard turf held tight against mulched planting beds, with the border lines kept crisp all season.'],
                    ['front_lawn', 'Full-property care', 'A front lawn carried through an Upstate summer on a mowing route and a fertilization program.'],
                    ['driveway',   'Pressure washing',   'Concrete driveway and walkway brought back after algae and weather staining.'],
                ];
                foreach ($workPhotos as $i => [$key, $label, $caption]):
                    $photo = $photoLibrary[$key];
                    $dir   = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
                ?>
                    <figure class="work-card <?php echo $dir; ?> reveal-delay-<?php echo (($i % 3) + 1); ?>">
                        <img src="<?php echo e($photo['src']); ?>"
                             alt="<?php echo e($photo['alt']); ?>"
                             width="<?php echo e((string) $photo['w']); ?>"
                             height="<?php echo e((string) $photo['h']); ?>"
                             loading="lazy" decoding="async">
                        <figcaption>
                            <strong><?php echo e($label); ?></strong>
                            <?php echo e($caption); ?>
                        </figcaption>
                    </figure>
                <?php endforeach; ?>
            </div>

            <div class="proof-note reveal-up">
                <p>
                    <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?>
                    and is still building its public review history. This space is reserved for
                    verified Google reviews rather than testimonials that cannot be attributed to
                    a real customer.
                </p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Divider 3.3 — double wave, filled with the FAQ section's white background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-white)" opacity="0.4"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 04 · FAQ ══════════ -->
<section class="numbered-section faq-section" data-num="04" aria-label="Frequently asked questions">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="section-num">04 / Questions</span>
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask before booking <span class="text-accent">lawn care</span>?</h2>
            <p class="prose prose-centered">
                Straight answers on timing, grass types, and how the Upstate calendar actually runs.
            </p>
        </div>

        <div class="faq-grid">
            <?php foreach ($faqs as $i => $faq): ?>
                <?php /* Direction alternates so the grid doesn't fade in as one block. */ ?>
                <article class="faq-item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <div class="faq-icon" aria-hidden="true"><i data-lucide="help-circle"></i></div>
                    <div>
                        <h3 class="faq-question"><?php echo e($faq['question']); ?></h3>
                        <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider 3.1 — diagonal, filled with the closing CTA's primary green -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-primary)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ C9.2 · CLOSING CTA ══════════ -->
<section class="closing-cta" aria-label="Request a lawn care estimate">
    <div class="container">
        <h2 class="reveal-up">Want the yard handled before the season turns?</h2>
        <p class="reveal-up reveal-delay-1">
            Tell <?php echo e($siteName); ?> what the property needs. Someone walks it, prices it,
            and sends a written estimate within 24 hours — mowing route, treatment program, or a
            one-off cleanup.
        </p>
        <div class="closing-actions reveal-up reveal-delay-2">
            <a href="#estimate-form" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Estimate
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
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
