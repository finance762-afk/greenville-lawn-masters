<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/flower-bed-shrub-planting/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page: one service (config.php $services →
   'flower-bed-shrub-planting') gets its own /services/{slug}/ page.

   Nothing here is invented. No prices or "starting at" figures, no
   review quotes or star ratings, no beds/plants-installed count, no
   "licensed and insured", no certification or "master gardener"
   claim, no plant warranty, no supplier/nursery brand — intake
   (build-plan.json) supplied none of them, and config.php records
   $reviews as empty and phone/email/hours as intake gaps.

   The horticulture below is verifiable fact about USDA zone 7b-8a,
   the SC Piedmont, and Greenville County — checkable, not asserted
   about this business. The business facts are limited to what the
   build actually recorded: founded 2024, based in Mauldin 29662,
   25-mile radius across Greenville County, one crew, free
   walkthrough, written itemised estimate within 24 hours.
   ============================================================ */

$pageSlug    = 'flower-bed-shrub-planting';
$currentPage = 'services';

/* This is a solo page, so servicesOnPage() returns exactly one row —
   the config.php entry whose 'page' equals this slug. We read its
   committed description rather than restate one, so the page and the
   sitemap never drift. */
$serviceRows = servicesOnPage($pageSlug);
$service     = $serviceRows[0] ?? ['name' => 'Flower Bed & Shrub Planting', 'description' => ''];

$media   = servicePagePhotos($pageSlug);   // hero => backyard, body => backyard,mulch_bed,hedges
$heroImg = heroPhoto($media['hero']);

$pageTitle       = 'Flower Bed & Shrub Planting in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Flower bed and shrub planting in Mauldin, SC. Beds cleaned out, soil amended for Piedmont clay, plants sited by sun. Written estimate within 24 hours.';   // 150 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

/* Phone is an intake gap (config.php $phone = ''). formatPhone/phoneHref
   return '' for empty input; $hasPhone gates every tel: button below so a
   placeholder or fabricated number never renders. */
$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Telltale signs (problem statement) ──────────────────────
   Symptoms a homeowner can verify by walking the beds, each tied to the
   horticultural cause. No urgency theatre, no invented statistics. */
$signs = [
    ['icon' => 'shrub',    'title' => 'Shrubs swallowing the windows', 'body' => 'Foundation shrubs set by how they looked the day they were planted grow into what the plant tag promised — mature width, not day-one width — and end up blocking windows and paths within a few seasons.'],
    ['icon' => 'ruler',    'title' => 'Beds with no defined edge',      'body' => 'A bed that bleeds into the lawn was never cut a real edge. Without a clean spade line or a hard border, mulch washes into the grass and turf creeps back into the bed.'],
    ['icon' => 'sun',      'title' => 'The right plant in the wrong light', 'body' => 'A shade plant baking in Upstate afternoon sun scorches; a sun-lover stuck in shade grows leggy and never blooms. Light needs are the first thing that decides where a plant goes.'],
    ['icon' => 'droplets', 'title' => 'Water standing in the hole',     'body' => 'Dig a hole in heavy Piedmont clay, backfill it with bagged potting soil, and it becomes a bathtub — water collects, roots circle and rot instead of spreading into the surrounding soil.'],
];

/* ── Expert differentiators ──────────────────────────────────
   Each is a practice we perform or a fact about the site — never a
   credential. Intake recorded no license, certification, or award. */
$diffs = [
    ['icon' => 'ruler',         'title' => 'Spaced for the plant it becomes', 'body' => 'Shrubs are set to their mature width, not to fill the bed on planting day. It looks a little sparse the first year and correct for the next ten, instead of the reverse.'],
    ['icon' => 'shovel',        'title' => 'The bed is amended, not the hole', 'body' => 'In heavy clay, enriching a single planting hole builds a bathtub around the roots. The whole bed is turned and amended so roots spread out, and plants sit at or slightly above grade.'],
    ['icon' => 'calendar-days', 'title' => 'Planted on the Upstate calendar',  'body' => 'Fall — roughly October into November — is the strongest planting window here: roots establish through a mild winter before summer heat arrives. Spring is second best; midsummer planting demands constant watering.'],
];

/* ── What the service includes ───────────────────────────────*/
$includes = [
    ['icon' => 'scissors',      'title' => 'Bed design & cleanout',   'body' => 'Existing beds are cleared of weeds and spent plants, edges re-cut to a clean line, and new bed shapes drawn to the house, the walkways, and where the sun actually falls.'],
    ['icon' => 'shovel',        'title' => 'Soil amendment',          'body' => 'The whole bed is turned and amended rather than the individual hole, so Piedmont clay does not seal each plant into a pocket that holds water and starves roots of air.'],
    ['icon' => 'flower-2',      'title' => 'Planting',                'body' => 'Flowers, shrubs, and small trees are set at the right depth with the root flare at grade, spaced for mature size. Root-bound nursery stock is scored so it roots out instead of strangling itself.'],
    ['icon' => 'layers',        'title' => 'Mulching',                'body' => 'Two to three inches of mulch goes down and is pulled back from every stem and trunk — never volcanoed against the bark — to hold moisture without rotting the crown.'],
    ['icon' => 'repeat',        'title' => 'Ongoing bed maintenance', 'body' => 'Optional return visits keep each plant pruned on its own clock, refresh mulch, and pull weeds, so the bed still reads as planted a year and two years on.'],
];

/* ── Process / timeline (signature rail) ─────────────────────*/
$timeline = [
    ['phase' => 'Walkthrough', 'title' => 'Read the light and the soil', 'body' => 'The beds are walked before anything is quoted: how many hours of sun each spot gets, how the ground drains, what is already growing and worth keeping, and where the clay holds water.'],
    ['phase' => 'Within 24h',  'title' => 'Written estimate',            'body' => 'An itemised estimate lands within a day of the walkthrough — bed prep, plants, and mulch listed separately so you can take the whole plan or start with one bed.'],
    ['phase' => 'Planting day', 'title' => 'Prep, plant, mulch',         'body' => 'Beds are cleaned out and edged, the soil turned and amended, plants set at the right depth and spaced for mature size, then mulched and watered in the same visit.'],
    ['phase' => 'Season after', 'title' => 'Prune on the plant\'s clock', 'body' => 'Spring-blooming shrubs are pruned right after they flower, not in winter, so next year\'s buds survive. Maintenance visits keep the bed shaped rather than sheared back all at once.'],
];

/* ── Planting palette (signature section) ────────────────────
   A designed reference chart, NOT photography — we have no plant photos,
   and a stock plant image would violate the client-photo standard. Every
   plant listed is a reliable zone 7b/8a Upstate landscape plant; the light
   requirement and bloom window are horticultural fact. The colour "chips"
   are built from brand tokens (tints of primary/accent/secondary), never
   invented plant-colour hexes — this is a brand chart, not a seed catalog. */
$palette = [
    [
        'level'  => 'Full Sun',
        'note'   => 'Six or more hours of direct Upstate sun',
        'rail'   => 'fbp-group--sun',
        'plants' => [
            ['name' => 'Knockout Rose',  'light' => 'Full sun',          'bloom' => 'Spring to frost',    'chip' => 1],
            ['name' => 'Loropetalum',    'light' => 'Full to part sun',  'bloom' => 'Spring',             'chip' => 2],
            ['name' => 'Abelia',         'light' => 'Full sun',          'bloom' => 'Summer to fall',     'chip' => 3],
            ['name' => 'Daylily',        'light' => 'Full sun',          'bloom' => 'Early summer',       'chip' => 4],
            ['name' => 'Coneflower',     'light' => 'Full sun',          'bloom' => 'Summer',             'chip' => 2],
            ['name' => 'Muhly Grass',    'light' => 'Full sun',          'bloom' => 'Fall plume',         'chip' => 8],
        ],
    ],
    [
        'level'  => 'Part Shade',
        'note'   => 'Morning sun with afternoon shade',
        'rail'   => 'fbp-group--part',
        'plants' => [
            ['name' => 'Azalea',            'light' => 'Part shade',       'bloom' => 'Spring',                 'chip' => 4],
            ['name' => 'Bigleaf Hydrangea', 'light' => 'AM sun / PM shade','bloom' => 'Summer',                 'chip' => 7],
            ['name' => 'Gardenia',          'light' => 'Part sun',         'bloom' => 'Early summer',           'chip' => 1],
            ['name' => 'Camellia Sasanqua', 'light' => 'Part sun',         'bloom' => 'Fall',                   'chip' => 3],
            ['name' => 'Camellia Japonica', 'light' => 'Part shade',       'bloom' => 'Winter to early spring', 'chip' => 5],
        ],
    ],
    [
        'level'  => 'Shade',
        'note'   => 'Under four hours of direct sun',
        'rail'   => 'fbp-group--shade',
        'plants' => [
            ['name' => 'Hosta',    'light' => 'Shade',          'bloom' => 'Foliage; summer bloom', 'chip' => 6],
            ['name' => 'Heuchera', 'light' => 'Shade',          'bloom' => 'Spring',                'chip' => 5],
            ['name' => 'Fern',     'light' => 'Shade',          'bloom' => 'Foliage',               'chip' => 7],
            ['name' => 'Boxwood',  'light' => 'Shade tolerant', 'bloom' => 'Evergreen foliage',     'chip' => 2],
            ['name' => 'Liriope',  'light' => 'Sun to shade',   'bloom' => 'Late summer',           'chip' => 3],
        ],
    ],
];

/* ── Comparison ──────────────────────────────────────────────
   Left column is common trade practice, not a named competitor. Every
   right-hand row is a horticultural practice or a process commitment the
   build actually recorded — never a credential claim. */
$comparison = [
    ['them' => 'Shrubs spaced to fill the bed the day it is planted',   'us' => 'Shrubs spaced to their mature width, so they never swallow windows and walkways'],
    ['them' => 'Each planting hole backfilled with bagged potting soil', 'us' => 'The whole bed amended, not the hole — no clay bathtub collecting water around the roots'],
    ['them' => 'Root balls dropped in at whatever depth the pot was',    'us' => 'Holes dug 2-3 times as wide as the root ball, root flare set at or just above grade'],
    ['them' => 'Sun and shade plants mixed for the look on planting day','us' => 'Right plant, right place — light needs matched before anything goes in the ground'],
    ['them' => 'Root-bound nursery stock planted straight from the pot', 'us' => 'Circling roots scored and teased so the plant roots outward instead of strangling itself'],
    ['them' => 'Mulch piled thick and volcanoed against the stems',      'us' => 'Mulch two to three inches deep, pulled back from every trunk and stem'],
    ['them' => 'Whatever is blooming at the garden center that weekend', 'us' => 'Beds planted in the fall window so roots establish before the first Upstate summer'],
];

/* ── FAQs — conversational, 40-80 words ──────────────────────
   Rendered visibly below AND passed to generateFAQSchema(); schema that
   does not mirror the page is a guidelines violation. No pricing appears
   anywhere — none was supplied, and a fabricated range amplified through
   FAQPage schema is a misrepresentation to Google, not a placeholder. */
$faqs = [
    [
        'question' => 'When is the best time to plant shrubs in the Upstate?',
        'answer'   => 'Fall — roughly October into November — is the strongest planting window around Greenville. Roots establish through a mild winter and the plant is anchored before summer heat arrives. Spring is the second-best window. Midsummer planting is possible but demands near-constant watering, so Greenville Lawn Masters steers larger installs toward fall whenever the schedule allows.',
    ],
    [
        'question' => 'Why do my new shrubs keep dying in Greenville clay?',
        'answer'   => 'Two causes account for most of it: planting too deep, and a hole backfilled with rich soil in heavy Piedmont clay. That rich pocket holds water like a bathtub and drowns the roots. The fix is to amend the whole bed rather than the hole, keep the root flare at or above grade, and let the plant root out into the native soil.',
    ],
    [
        'question' => 'How far apart should foundation shrubs be planted?',
        'answer'   => 'By the plant\'s mature width, not by how the bed looks the day it is planted. A shrub tagged for five feet needs close to five feet of room, even if that leaves gaps the first year. Spacing to fill the bed immediately is why so many foundation plantings end up sheared into boxes and crowding the windows within a few seasons.',
    ],
    [
        'question' => 'When should I prune spring-blooming shrubs like azaleas?',
        'answer'   => 'Right after they finish flowering, not in winter. Azaleas, loropetalum, and other spring bloomers set next year\'s flower buds within weeks of blooming, so a winter shearing removes the flowers before they ever open. Greenville Lawn Masters prunes each plant on its own clock instead of shearing the whole bed on one date.',
    ],
    [
        'question' => 'What flowers hold up best in Mauldin\'s summer heat?',
        'answer'   => 'In full sun, coneflower, daylily, black-eyed susan, and abelia take the heat and keep going. Knockout roses bloom from spring to frost. Bigleaf hydrangeas do well with morning sun and afternoon shade, while panicle hydrangeas tolerate more sun. Matching each plant to the light it actually gets matters more than the plant itself.',
    ],
    [
        'question' => 'Do you plant beds in shade?',
        'answer'   => 'Yes. Shade is not a dead zone — it is a different plant list. Hosta, heuchera, and ferns fill shaded beds for foliage, camellia japonica blooms through late winter, and boxwood holds structure year-round. The rule is the same as in sun: right plant, right place. A sun-lover forced into shade simply stretches and refuses to bloom.',
    ],
    [
        'question' => 'How deep should mulch go around new plants?',
        'answer'   => 'Two to three inches is the target, spread evenly and pulled back a few inches from every stem and trunk. Mulch volcanoed against the bark traps moisture, invites rot, and hides roots that should be breathing. A proper mulch layer holds soil moisture, moderates temperature, and keeps weeds down without smothering the crown.',
    ],
    [
        'question' => 'When can I put annual flowers out in Greenville?',
        'answer'   => 'After the last spring frost, which in the Greenville area typically falls in the first half of April. Tender annuals set out earlier can be caught by a late cold snap. Perennials and hardy shrubs go in far earlier — fall and early spring are ideal for them — but the frost-tender color waits until the danger has passed.',
    ],
];

/* ── Schema — exactly four nodes ──────────────────────────────
   (a) Service, @id #service-{slug}, provider → homepage LocalBusiness @id,
       areaServed from $serviceAreas. NO offers/priceRange — intake supplied
       no pricing, and fabricated structured pricing is a misrepresentation.
   (b) FAQPage mirroring the visible FAQ.
   (c) BreadcrumbList.
   (d) WebPage with Speakable. Every cssSelector below exists in the markup. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $pageSlug,
        'name'        => 'Flower Bed & Shrub Planting',
        'serviceType' => 'Flower bed and shrub planting',
        'description' => 'Flower bed and shrub planting in Mauldin, South Carolina: bed design and '
                       . 'cleanout, soil amendment for Piedmont clay, right-plant-right-place '
                       . 'installation of flowers, shrubs, and small trees, mulching, and ongoing '
                       . 'bed maintenance.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',                       'url' => '/'],
        ['name' => 'Services',                   'url' => '/services/'],
        ['name' => 'Flower Bed & Shrub Planting','url' => '/services/' . $pageSlug . '/'],
    ]),
    [
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        '@id'       => $canonicalUrl . '#webpage',
        'url'       => $canonicalUrl,
        'name'      => $pageTitle,
        'about'     => ['@id' => organizationId()],
        'speakable' => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.hero-answer', '.answer-block', '.faq-answer', 'h1'],
        ],
    ],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   Flower Bed & Shrub Planting — page-scoped styles
   Every rule prefixed .fbp- so nothing collides with another page's
   <style> block. Colour, shadow, spacing, radius, and timing are var()
   tokens without exception — a raw literal here is an automatic QA fail.
   The only hex on the page lives inside the hero ::after noise data-URI.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  three distinct SVG dividers (soft wave, torn edge, diagonal)
     C4  editorial pull-quote
     C5  bento grid of telltale signs, deliberately uneven spans
     C6  asymmetric 62/38 split with an oversized stat watermark
     C7  signature section — the PLANTING PALETTE reference chart
         (light-level rails + token-built colour chips; this page only)
     C10 comparison table, accent-highlighted winning column
     C11 image treatments — arch clip + offset frame on the proof strip
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   The 'backyard' frame resampled to 1600px; the overlay carries text
   contrast and hides the softness of the upscale. Gradient angle (122deg)
   and stops are deliberately unlike the reference page (78deg) and the
   homepage (100deg) so no two heroes read as the same composition. */
.fbp-hero {
  min-height: 80vh;
  min-height: 80svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-backyard-beds.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.fbp-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    122deg,
    rgba(var(--color-dark-rgb), 0.92) 0%,
    rgba(var(--color-dark-rgb), 0.74) 38%,
    rgba(var(--color-primary-rgb), 0.52) 68%,
    rgba(var(--color-accent-rgb), 0.30) 100%
  );
  z-index: 0;
}
.fbp-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.fbp-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.fbp-hero .breadcrumb { animation: fbpFade 0.5s ease both; }

.fbp-hero__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  background: rgba(var(--color-accent-rgb), 0.16);
  border: 1px solid rgba(var(--color-accent-rgb), 0.4);
  border-radius: var(--radius-full);
  padding: var(--space-1) var(--space-4);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2.5px;
  color: var(--color-accent);
  margin-bottom: var(--space-5);
  animation: fbpFade 0.55s ease 0.08s both;
}
.fbp-hero__eyebrow i, .fbp-hero__eyebrow svg { width: 15px; height: 15px; }

.fbp-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: fbpRise 0.6s ease 0.16s both;
}
.fbp-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; a left-aligned hero must undo that. */
.fbp-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: fbpRise 0.6s ease 0.26s both;
}

.fbp-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: fbpRise 0.6s ease 0.36s both;
}
.fbp-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: fbpRise 0.6s ease 0.46s both;
}
.fbp-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.fbp-hero__trust i, .fbp-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS @keyframes, never a reveal class — the reveal
   system sets opacity:0 and would blank the hero if the observer never fired. */
@keyframes fbpFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes fbpRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.fbp-problem { background: var(--color-light); }
.fbp-problem__layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: var(--space-12);
  align-items: start;
}
.fbp-problem__quote {
  max-width: 24ch;
  font-family: var(--font-heading);
  font-style: italic;
  font-weight: 600;
  font-size: clamp(1.5rem, 3vw, 2.5rem);
  line-height: 1.22;
  color: var(--color-primary-dark);
  border-left: 4px solid var(--color-accent);
  padding-left: var(--space-6);
}
.fbp-problem__lead { color: var(--color-gray-dark); }
.fbp-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Uneven on purpose: the first card spans two columns so the row does not
   read as four identical boxes. Tints rotate; no two adjacent match. */
.fbp-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.fbp-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.fbp-sign:first-child { grid-column: span 2; }
.fbp-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.fbp-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.fbp-sign__icon i, .fbp-sign__icon svg { width: 22px; height: 22px; }
.fbp-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.fbp-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──
   Watermark is the USDA hardiness zone for the Upstate — a checkable fact,
   not an invented business statistic. */
.fbp-expert { background: var(--color-white); }
.fbp-expert__layout {
  display: grid;
  grid-template-columns: 0.6fr 1.4fr;   /* not 50/50 — editorial asymmetry */
  gap: var(--space-16);
  align-items: center;
}
.fbp-stat-watermark {
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
.fbp-stat-watermark span {
  position: absolute;
  left: 0.06em;
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
.fbp-expert h2 { margin-bottom: var(--space-5); }
.fbp-expert .answer-block { margin-inline: 0; }
.fbp-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.fbp-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.fbp-diff i, .fbp-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.fbp-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.fbp-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── Service breakdown ────────────────────────────────────────*/
.fbp-breakdown { background: var(--color-light); }
.fbp-includes {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-5);
}
.fbp-include {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-top: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.fbp-include:hover {
  transform: translateY(-5px);
  border-top-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.fbp-include__icon {
  width: 52px; height: 52px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: rgba(var(--color-primary-rgb), 0.08);
  color: var(--color-primary);
}
.fbp-include__icon i, .fbp-include__icon svg { width: 26px; height: 26px; }
.fbp-include h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.fbp-include p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray); line-height: 1.6; }

/* ── Signature C7 · The vertical process rail ─────────────────
   One accent line threads the four phases; each marker sits on the line. */
.fbp-rail { position: relative; margin-top: var(--space-16); padding-left: var(--space-12); }
.fbp-rail::before {
  content: '';
  position: absolute;
  left: 13px;
  top: var(--space-2);
  bottom: var(--space-2);
  width: 2px;
  background: linear-gradient(
    to bottom,
    var(--color-accent) 0%,
    rgba(var(--color-accent-rgb), 0.35) 70%,
    transparent 100%
  );
}
.fbp-rail__step { position: relative; padding-bottom: var(--space-10); }
.fbp-rail__step:last-child { padding-bottom: 0; }
.fbp-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 6px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-light);
}
.fbp-rail__phase {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.fbp-rail__step h3 { font-size: var(--font-size-xl); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.fbp-rail__step p { margin: 0; max-width: 62ch; color: var(--color-gray-dark); line-height: 1.7; }

/* ══════════ SIGNATURE SECTION · PLANTING PALETTE ══════════
   A designed reference chart unique to this page. Plants are grouped by
   sun exposure; each group carries a light-level gradient rail that darkens
   from full sun down to shade. The colour chips are built entirely from
   brand tokens — tints and gradients of primary/accent/secondary — because
   this is a brand chart, not a plant-colour swatch book. No photos here by
   design: the build library holds none of these plants. */
.fbp-palette { background: var(--color-white); }
.fbp-palette__groups {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-8);
  margin-top: var(--space-12);
}
.fbp-group {
  display: grid;
  grid-template-columns: 10px 1fr;
  gap: var(--space-5);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-light);
  border: 1px solid rgba(var(--color-primary-rgb), 0.08);
}
/* The light-level rail: bright at the top for full sun, darker toward shade. */
.fbp-group__rail {
  border-radius: var(--radius-full);
  min-height: 100%;
}
.fbp-group--sun   .fbp-group__rail { background: linear-gradient(to bottom, var(--color-accent), var(--color-primary)); }
.fbp-group--part  .fbp-group__rail { background: linear-gradient(to bottom, var(--color-primary), var(--color-secondary)); }
.fbp-group--shade .fbp-group__rail { background: linear-gradient(to bottom, var(--color-secondary), var(--color-dark)); }

.fbp-group__head { margin-bottom: var(--space-4); }
.fbp-group__level {
  display: block;
  font-family: var(--font-heading);
  font-weight: 800;
  font-size: var(--font-size-xl);
  color: var(--color-primary-dark);
}
.fbp-group__note {
  display: block;
  font-size: var(--font-size-xs);
  text-transform: uppercase;
  letter-spacing: 1px;
  color: var(--color-gray);
  margin-top: var(--space-1);
}
.fbp-swatches { display: flex; flex-direction: column; gap: var(--space-3); }
.fbp-swatch {
  display: grid;
  grid-template-columns: 34px 1fr;
  gap: var(--space-3);
  align-items: center;
  padding: var(--space-2) var(--space-3);
  border-radius: var(--radius-md);
  background: var(--color-white);
  border: 1px solid rgba(var(--color-primary-rgb), 0.06);
  transition: transform var(--transition-fast), box-shadow var(--transition-fast);
}
.fbp-swatch:hover { transform: translateX(3px); box-shadow: var(--shadow-sm); }
/* The colour chip. Rounded, tokened, purely decorative → aria-hidden in markup. */
.fbp-chip {
  width: 34px; height: 34px;
  border-radius: var(--radius-sm);
  box-shadow: inset 0 0 0 1px rgba(var(--color-dark-rgb), 0.12);
}
/* Eight chip variants, all derived from brand tokens — never a plant-colour hex. */
.fbp-chip--1 { background: linear-gradient(135deg, var(--color-accent), var(--color-primary)); }
.fbp-chip--2 { background: var(--color-primary); }
.fbp-chip--3 { background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark)); }
.fbp-chip--4 { background: rgba(var(--color-accent-rgb), 0.55); }
.fbp-chip--5 { background: linear-gradient(135deg, var(--color-primary-dark), var(--color-secondary)); }
.fbp-chip--6 { background: var(--color-secondary); }
.fbp-chip--7 { background: rgba(var(--color-primary-rgb), 0.32); }
.fbp-chip--8 { background: linear-gradient(135deg, var(--color-accent), var(--color-light)); }
.fbp-swatch__body { display: flex; flex-direction: column; gap: 1px; min-width: 0; }
.fbp-swatch__name {
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
  color: var(--color-primary-dark);
  line-height: 1.2;
}
.fbp-swatch__meta {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-1) var(--space-3);
  font-size: var(--font-size-xs);
  color: var(--color-gray);
}
.fbp-swatch__bloom { color: var(--color-accent); font-weight: 600; }
.fbp-palette__foot {
  max-width: 65ch;
  margin: var(--space-10) auto 0;
  text-align: center;
  color: var(--color-gray);
  font-size: var(--font-size-sm);
  line-height: 1.7;
}

/* ── C11 · Proof strip, arch + offset frame treatments ────────*/
.fbp-proof { background: var(--color-dark); }
.fbp-proof h2, .fbp-proof .fbp-eyebrow { color: var(--color-white); }
.fbp-proof .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.fbp-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.fbp-shot { margin: 0; }
.fbp-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
.fbp-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.fbp-shot--frame { position: relative; }
.fbp-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.fbp-shot:hover img { transform: scale(1.03); }
.fbp-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.fbp-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }
.fbp-proof__note {
  max-width: 65ch;
  margin: var(--space-12) auto 0;
  padding: var(--space-5) var(--space-6);
  border-radius: var(--radius-md);
  background: rgba(var(--color-white-rgb), 0.05);
  color: rgba(var(--color-white-rgb), 0.6);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  text-align: center;
}
.fbp-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.fbp-compare { background: var(--color-white); }
.fbp-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.fbp-compare__head, .fbp-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.fbp-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.fbp-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.fbp-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.fbp-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.fbp-compare__row > div:first-child { color: var(--color-gray); }
.fbp-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.fbp-compare__row i, .fbp-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.fbp-compare__row > div:first-child i, .fbp-compare__row > div:first-child svg { color: var(--color-gray); }
.fbp-compare__row > div:last-child i,  .fbp-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.fbp-faq { background: var(--color-light); }
.fbp-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.fbp-faq__item {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.fbp-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.fbp-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.fbp-related { background: var(--color-white); }

/* ── Final CTA ────────────────────────────────────────────────*/
.fbp-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.fbp-cta::before {
  content: '';
  position: absolute;
  top: -20%; right: -8%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.fbp-cta .container { position: relative; z-index: 1; }
.fbp-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.fbp-cta .answer-block { color: rgba(var(--color-white-rgb), 0.88); max-width: 60ch; margin: 0 auto var(--space-8); }
.fbp-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .fbp-includes { grid-template-columns: repeat(2, 1fr); }
  .fbp-signs { grid-template-columns: repeat(2, 1fr); }
  .fbp-sign:first-child { grid-column: span 2; }
  .fbp-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .fbp-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .fbp-stat-watermark span { position: static; display: block; margin-top: var(--space-4); }
  .fbp-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .fbp-problem__quote { max-width: none; }
  .fbp-palette__groups { grid-template-columns: 1fr; }
  .fbp-proof__grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 700px) {
  .fbp-hero { min-height: 0; }
  .fbp-includes, .fbp-signs, .fbp-proof__grid { grid-template-columns: 1fr; }
  .fbp-sign:first-child { grid-column: span 1; }
  .fbp-shot--frame::before { display: none; }

  /* Comparison collapses to stacked pairs; each cell carries its own label
     or the them/us contrast is lost when the column headers are hidden. */
  .fbp-compare__head { display: none; }
  .fbp-compare__row { grid-template-columns: 1fr; }
  .fbp-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .fbp-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero fbp-hero" aria-label="Flower bed and shrub planting in Mauldin, South Carolina">
    <div class="container">
        <div class="fbp-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Flower Bed &amp; Shrub Planting</span></li>
                </ol>
            </nav>

            <span class="fbp-hero__eyebrow">
                <i data-lucide="flower-2" aria-hidden="true"></i>
                Bed &amp; Shrub Planting &middot; Mauldin, SC
            </span>

            <h1>Flower Bed &amp; Shrub Planting in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters designs, cleans out, and plants flower beds and shrubs across
                Mauldin, South Carolina and within 25 miles of Greenville County. Beds are shaped to
                the light, soil amended for heavy Piedmont clay, and every plant set at the right depth
                and spaced for its mature size. Written estimate within 24 hours.
            </p>

            <div class="fbp-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Planting Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* Phone is an intake gap. A "Call Now" button with no number — or a
                             fabricated one — is worse than routing to the estimate form. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only what intake recorded. No "Licensed & Insured",
                     no star rating, no jobs count — config.php has none of the three. */ ?>
            <div class="fbp-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="sprout" aria-hidden="true"></i> Right plant, right place</span>
                <span><i data-lucide="calendar-days" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider — soft wave, filled with the problem section's light background -->
    <div class="svg-divider" style="height:88px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,40 C280,90 520,10 760,44 C960,72 1080,30 1200,52 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · PROBLEM STATEMENT ══════════ -->
<section class="fbp-problem" aria-label="Signs a Mauldin planting bed went wrong">
    <div class="container">
        <div class="fbp-problem__layout">
            <blockquote class="fbp-problem__quote reveal-left">
                A failed bed is almost never the plant&rsquo;s fault &mdash; it is depth, spacing, and clay.
            </blockquote>

            <div class="fbp-problem__lead">
                <h2 class="reveal-right">How can you tell a Mauldin planting bed was installed wrong?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    A Mauldin bed was installed wrong when the same problems repeat: shrubs crowding the
                    windows within a few years, beds with no clean edge, sun plants scorching or shade
                    plants stretching, and water standing in the planting holes. Each points to spacing,
                    depth, light, or clay &mdash; not to a bad plant.
                </p>
                <p class="reveal-right reveal-delay-2">
                    None of it is fixed by buying more plants. Greenville Lawn Masters starts with the
                    conditions the bed actually has &mdash; how many hours of sun each spot gets, how the
                    ground drains, and how deep the clay sits &mdash; because in the Upstate those decide
                    whether a planting thrives or slowly declines.
                </p>
            </div>
        </div>

        <div class="fbp-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="fbp-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="fbp-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="fbp-expert" aria-label="Why Greenville Lawn Masters for bed and shrub planting">
    <div class="container">
        <div class="fbp-expert__layout">

            <div class="fbp-stat-watermark reveal-left" aria-hidden="true">
                7b<span>Upstate SC hardiness zone</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does planting in the Upstate come down to timing and clay?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Planting in the Upstate comes down to timing and clay because both are unforgiving.
                    Heavy Piedmont clay drowns roots when a rich hole is dug into it, and summer heat
                    punishes anything planted at the wrong time of year. Get the season and the soil
                    right, and the plant list gets a lot more forgiving.
                </p>

                <ul class="fbp-diffs">
                    <?php foreach ($diffs as $i => $d): ?>
                        <li class="fbp-diff reveal-right reveal-delay-<?php echo $i + 2; ?>">
                            <i data-lucide="<?php echo e($d['icon']); ?>" aria-hidden="true"></i>
                            <div>
                                <strong><?php echo e($d['title']); ?></strong>
                                <p><?php echo e($d['body']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Divider — torn edge, filled with the breakdown section's light background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,40 L60,42 L120,35 L200,45 L280,32 L360,48 L440,38 L540,45 L640,30 L740,42 L840,35 L940,45 L1040,32 L1140,42 L1200,38 L1200,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN + PROCESS ══════════ -->
<section class="fbp-breakdown" aria-label="What flower bed and shrub planting includes">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What does <span class="text-accent">Greenville Lawn Masters</span> flower bed and shrub planting include?</h2>
            <p class="answer-block">
                Greenville Lawn Masters flower bed and shrub planting includes bed design and cleanout,
                soil amendment for heavy clay, right-plant-right-place installation of flowers, shrubs,
                and small trees, mulching, and optional ongoing bed maintenance. Take the full plan or
                start with a single bed.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="fbp-includes">
            <?php foreach ($includes as $i => $item): ?>
                <article class="fbp-include <?php echo ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="fbp-include__icon"><i data-lucide="<?php echo e($item['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($item['title']); ?></h3>
                    <p><?php echo e($item['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does a bed planting project actually unfold?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            A bed planting project unfolds in four steps: a free walkthrough to read the light and soil,
            a written itemised estimate within 24 hours, a planting day where beds are prepped, planted,
            and mulched, and &mdash; if you want it &mdash; maintenance visits that keep each plant pruned
            on its own schedule.
        </p>

        <ol class="fbp-rail">
            <?php foreach ($timeline as $i => $step): ?>
                <li class="fbp-rail__step reveal-left reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="fbp-rail__phase"><?php echo e($step['phase']); ?></span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Divider — diagonal, filled with the palette section's white background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-white)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ SIGNATURE · PLANTING PALETTE ══════════ -->
<section class="fbp-palette" aria-label="Upstate South Carolina planting palette by sun exposure">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Palette</span>
            <h2>Which plants actually thrive in an <span class="text-accent">Upstate bed</span>?</h2>
            <p class="answer-block">
                Plants thrive in an Upstate bed when they are matched to the light a spot gets. This
                reference chart groups reliable zone 7b/8a landscape plants by sun exposure &mdash; full
                sun, part shade, and shade &mdash; with the bloom window for each, so the right plant lands
                in the right place from the start.
            </p>
            <span class="section-subtitle">Grouped by the sun a spot actually gets</span>
        </div>

        <?php /* A designed chart, not photography. The colour chips are brand tokens,
                 not plant colours; the light and bloom facts are what matters here. */ ?>
        <div class="fbp-palette__groups">
            <?php foreach ($palette as $g => $group): ?>
                <div class="fbp-group <?php echo e($group['rail']); ?> <?php echo ['reveal-up', 'reveal-scale', 'reveal-down'][$g % 3]; ?> reveal-delay-<?php echo $g + 1; ?>">
                    <span class="fbp-group__rail" aria-hidden="true"></span>
                    <div>
                        <div class="fbp-group__head">
                            <span class="fbp-group__level"><?php echo e($group['level']); ?></span>
                            <span class="fbp-group__note"><?php echo e($group['note']); ?></span>
                        </div>
                        <div class="fbp-swatches">
                            <?php foreach ($group['plants'] as $plant): ?>
                                <article class="fbp-swatch">
                                    <span class="fbp-chip fbp-chip--<?php echo (int) $plant['chip']; ?>" aria-hidden="true"></span>
                                    <div class="fbp-swatch__body">
                                        <span class="fbp-swatch__name"><?php echo e($plant['name']); ?></span>
                                        <span class="fbp-swatch__meta">
                                            <span><?php echo e($plant['light']); ?></span>
                                            <span class="fbp-swatch__bloom"><?php echo e($plant['bloom']); ?></span>
                                        </span>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <p class="fbp-palette__foot reveal-up">
            This is a starting palette for Greenville County, not the whole list. The final plan is drawn
            during the walkthrough, once the light, drainage, and existing plants in your beds are known.
        </p>
    </div>
</section>

<!-- ══════════ 5 · PROOF ══════════ -->
<?php /* No testimonials, no before/after pairs, no aggregate review snippet:
         config.php $reviews is empty, $gbpUrl is empty, and the photo library
         holds no before/after pair. Inventing quotes would attribute statements
         to customers who do not exist (an FTC Endorsement Guides problem), and
         CLAUDE.md separately forbids fabricated review counts. The client's own
         job photography fills the slot, and captions describe only what is in
         the frame — the 'hedges' shot shows established shrubs being TRIMMED,
         which is what its caption says; it never claims to show planting. */ ?>
<section class="fbp-proof" aria-label="Greenville Lawn Masters bed and shrub photography">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label fbp-eyebrow">The Work</span>
            <h2>What does <span class="text-accent">Greenville Lawn Masters</span> bed work look like on the ground?</h2>
            <p class="answer-block">
                Greenville Lawn Masters photographs its own job sites &mdash; every image here is a
                Mauldin-area property the crew maintains, not stock. Below: planted beds edged clean
                against the turf, a freshly mulched front bed, and established foundation shrubs being
                trimmed on a maintenance visit.
            </p>
        </div>

        <div class="fbp-proof__grid">
            <?php
            /* Captions describe WHAT IS IN THE FRAME. None claims a photo shows planting —
               no photo in the library depicts planting in progress. 'hedges' is a trimming
               shot, captioned as established shrubs being maintained. */
            $shots = [
                ['key' => 'backyard',  'mod' => '',                'label' => 'Planted beds, clean edges', 'caption' => 'Backyard turf running between mulched, planted beds and a wood privacy fence at a Mauldin home.'],
                ['key' => 'mulch_bed', 'mod' => 'fbp-shot--arch',  'label' => 'Mulched front bed',         'caption' => 'A freshly mulched flower bed beside the front walk of a Craftsman home in Mauldin, South Carolina.'],
                ['key' => 'hedges',    'mod' => 'fbp-shot--frame', 'label' => 'Established shrubs, kept up','caption' => 'A Greenville Lawn Masters crew member trimming established foundation shrubs at a brick Mauldin home.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="fbp-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
                    <img src="<?php echo e($img['src']); ?>"
                         alt="<?php echo e($img['alt']); ?>"
                         width="<?php echo e((string) $img['w']); ?>"
                         height="<?php echo e((string) $img['h']); ?>"
                         loading="lazy" decoding="async">
                    <figcaption>
                        <strong><?php echo e($shot['label']); ?></strong>
                        <?php echo e($shot['caption']); ?>
                    </figcaption>
                </figure>
            <?php endforeach; ?>
        </div>

        <div class="fbp-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>

    <!-- Divider — torn edge, filled with the comparison section's white background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,38 L80,44 L160,32 L240,46 L320,34 L420,44 L520,30 L620,42 L720,34 L820,46 L920,32 L1020,44 L1120,36 L1200,42 L1200,60 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 6 · COMPARISON ══════════ -->
<section class="fbp-compare" aria-label="How Greenville Lawn Masters plants differently">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What is the difference between a plant-and-go install and a designed bed?</h2>
            <p class="answer-block">
                A plant-and-go install drops whatever is blooming at the garden center into the ground
                that weekend; a designed bed matches plant to light, spaces for mature size, and preps the
                soil first. The difference shows up two and three years later, when one bed looks
                intentional and the other is overgrown.
            </p>
        </div>

        <?php /* Left column is common trade practice, not a named competitor. Every
                 right-hand row is a horticultural practice or a recorded process
                 commitment — never a credential claim. */ ?>
        <div class="fbp-compare__table reveal-up reveal-delay-1">
            <div class="fbp-compare__head">
                <div>A typical plant-and-go install</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="fbp-compare__row">
                    <div data-label="A typical plant-and-go install">
                        <i data-lucide="x" aria-hidden="true"></i>
                        <span><?php echo e($row['them']); ?></span>
                    </div>
                    <div data-label="Greenville Lawn Masters">
                        <i data-lucide="check" aria-hidden="true"></i>
                        <span><?php echo e($row['us']); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider — soft wave, filled with the FAQ section's light background -->
    <div class="svg-divider" style="height:88px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,52 C220,20 460,80 700,48 C920,20 1080,66 1200,40 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 7 · FAQ ══════════ -->
<section class="fbp-faq" aria-label="Flower bed and shrub planting questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">bed and shrub planting</span>?</h2>
            <p class="answer-block">
                Straight answers on when to plant in the Upstate, why new shrubs die in Greenville clay,
                how far apart foundation shrubs belong, when to prune spring bloomers like azaleas, which
                flowers hold up through a Mauldin summer, and how deep mulch should go around new plants.
            </p>
        </div>

        <div class="fbp-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="fbp-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="fbp-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> plant and maintain in Mauldin?</h2>
            <p class="answer-block">
                Beds are one piece of the property. Greenville Lawn Masters also handles mulch
                installation, spring and fall cleanups, hedge and small-tree work, and the lawn itself
                across Mauldin and the wider Greenville County service area &mdash; the same crew on every
                visit, and the same written estimate within 24 hours.
            </p>
        </div>

        <div class="services-grid">
            <?php foreach (relatedServicePages($pageSlug, 3) as $i => $rel):
                /* The SAME `.service-card-with-image` component the services grid
                   renders — image, icon, description, exactly three bullets, CTA.
                   Both call sites go through includes/service-card.php so the two
                   can never drift apart. Tints rotate 1→2→3, so no two adjacent
                   cards share a background. */
                $cardPage     = $rel;
                $cardRotation = ($i % 3) + 1;
                include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-card.php';
            endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 8 · FINAL CTA ══════════ -->
<section class="fbp-cta" aria-label="Request a flower bed and shrub planting estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to plant a bed that survives its first Upstate summer?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            The strongest planting window in the Upstate opens in fall, when roots establish before summer
            heat. Book the free walkthrough now and Greenville Lawn Masters can plan the beds, match the
            plants to the light, and get them in the ground on the right side of the calendar.
        </p>
        <div class="fbp-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Planting Estimate
            </a>
            <?php if ($hasPhone): ?>
                <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                    <i data-lucide="phone" aria-hidden="true"></i>
                    Call <?php echo e($phoneDisplay); ?>
                </a>
            <?php else: ?>
                <a href="/contact/" class="btn btn-outline-white btn-lg">
                    <i data-lucide="mail" aria-hidden="true"></i>
                    Contact Greenville Lawn Masters
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
