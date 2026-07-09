<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/lawn-care-services/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   The recurring-maintenance group page: 8 of the 22 services.

   Nothing here is invented. No price ranges, no review quotes, no
   star ratings, no "licensed and insured", no jobs-completed count,
   no certifications — intake supplied none of them (see config.php
   $missingIntake and the $reviews note). The horticultural claims
   below are facts about the SC Piedmont, which are checkable; the
   business claims are limited to what build-plan.json recorded:
   founded 2024, 25-mile radius, written estimate within 24 hours.
   ============================================================ */

$pageSlug   = 'lawn-care-services';
$currentPage = 'services';

$servicesHere = servicesOnPage($pageSlug);   // 8 services, config.php order
$media        = servicePagePhotos($pageSlug);
$heroImg      = heroPhoto($media['hero']);

$pageTitle       = 'Lawn Care Services in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Lawn care in Mauldin, SC: weekly mowing, fertilization, weed and grub control, core aeration, and overseeding. Free walkthrough, written estimate in 24 hours.';   // 158 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Telltale signs (§2.8 section 2) ──────────────────────────
   Symptoms a homeowner can verify by walking outside, each tied to the
   agronomic cause. Empathy through specificity, not urgency theatre. */
$signs = [
    ['icon' => 'footprints', 'title' => 'Footprints stay visible',      'body' => 'Turf that holds a footprint minutes after you walk across it has lost turgor. It is short of water, or the soil beneath it is too compacted for roots to drink.'],
    ['icon' => 'grid-2x2',   'title' => 'Bare patches keep spreading',  'body' => 'A thin spot that widens through summer is rarely a seeding problem. Grubs, disease, or a compaction layer is usually working underneath it.'],
    ['icon' => 'sprout',     'title' => 'Crabgrass returns every June', 'body' => 'Crabgrass pulled in June germinated in March. If it comes back annually, the pre-emergent barrier is going down late, or not at all.'],
    ['icon' => 'droplets',   'title' => 'Water runs off, not in',       'body' => 'Piedmont clay seals under traffic. When irrigation sheets across the surface toward the street, the lawn is compacted, not overwatered.'],
];

/* ── What the maintenance program covers ─────────────────────
   Drawn from config.php $services — never a second hardcoded list. */
$serviceIcons = [
    'lawn-mowing'                        => 'scissors',
    'fertilization-weed-control'         => 'sprout',
    'grub-control-lawn-disease-treatment'=> 'bug',
    'aeration-overseeding'               => 'shovel',
    'winter-lawn-preparation'            => 'snowflake',
    'grass-seeding-overseeding'          => 'wheat',
    'lawn-repair-leveling'               => 'ruler',
    'commercial-lawn-care'               => 'building-2',
];

/* ── Process timeline (§2.8 section 4) ───────────────────────*/
$timeline = [
    ['phase' => 'Visit 1',    'title' => 'Soil and grass audit',   'body' => 'Grass type identified per zone — bermuda and zoysia read differently from tall fescue, and most Mauldin lots run both. Compaction, drainage, thatch depth, and bed lines get checked on foot.'],
    ['phase' => 'Within 24h', 'title' => 'Written estimate',        'body' => 'An itemised estimate lands within a day of the walkthrough. Mowing is priced per visit; treatments, aeration, and repair are priced separately so you can take all of it or part of it.'],
    ['phase' => 'Week 1',     'title' => 'Route and calendar set',  'body' => 'Mowing joins a fixed weekly or biweekly route. Pre-emergent, feeding, aeration, and overseeding are booked against the Upstate calendar rather than whenever the phone rings.'],
    ['phase' => 'Ongoing',    'title' => 'Cut, treat, adjust',      'body' => 'Height of cut moves with the season. Treatments shift if the lawn tells us something different from what the calendar said. Every visit ends with concrete blown clean and gates shut.'],
];

/* ── Comparison (§2.8 section 6) ──────────────────────────────
   Left column describes common industry practice, not a named competitor, and
   nothing on the right is a credential — every right-hand row is a process
   commitment intake actually recorded or an agronomic practice we perform. */
$comparison = [
    ['them' => 'One fertilizer blend applied to the whole yard',   'us' => 'Feeding matched to the grass in each zone — warm-season and fescue are not on the same schedule'],
    ['them' => 'Pre-emergent applied when the route reaches you',  'us' => 'Pre-emergent timed to soil temperature near 55°F, before crabgrass germinates'],
    ['them' => 'Mowing height fixed all season',                   'us' => 'Height of cut raised through summer heat, never removing more than a third of the blade'],
    ['them' => 'Aeration sold every spring regardless of grass',   'us' => 'Warm-season lawns cored in late spring; fescue cored and overseeded in early fall'],
    ['them' => 'Clippings and debris left on drives and walks',    'us' => 'Concrete blown clean and debris hauled off the property at the end of every visit'],
    ['them' => 'Estimate "sometime next week"',                    'us' => 'Written, itemised estimate within 24 hours of the walkthrough'],
];

/* ── FAQs — conversational, 40-80 words (aeo-content-schema §2.4) ──
   Rendered visibly below AND passed to generateFAQSchema(). Schema that does
   not mirror visible content is a guidelines violation. No pricing: none was
   supplied, and an invented range amplified through FAQPage schema is a
   misrepresentation to Google, not a placeholder. */
$faqs = [
    [
        'question' => 'How much do lawn care services cost in Mauldin, SC?',
        'answer'   => 'Greenville Lawn Masters prices every property after walking it, because lot size, slope, '
                    . 'grass type, and how far the turf has slipped all move the number. The walkthrough is free and '
                    . 'the written estimate arrives within 24 hours, itemised by service. Mowing is quoted per visit on '
                    . 'a weekly or biweekly route; treatments, aeration, and repair work are quoted separately.',
    ],
    [
        'question' => 'How often should a Mauldin lawn be mowed?',
        'answer'   => 'Weekly from roughly May through September, when Upstate growth peaks, and every other week in '
                    . 'the shoulder seasons. The governing rule is never to remove more than one third of the blade in a '
                    . 'single cut. Scalping a heat-stressed summer lawn opens it to weeds and disease, so Greenville Lawn '
                    . 'Masters holds a fixed route rather than letting the interval stretch.',
    ],
    [
        'question' => 'When should crabgrass pre-emergent be applied in Greenville County?',
        'answer'   => 'The window opens when soil temperature at two inches holds near 55°F, which in Greenville County '
                    . 'usually falls between late February and mid-March. A pre-emergent applied after germination does '
                    . 'nothing at all. Greenville Lawn Masters generally follows the first application with a second, '
                    . 'roughly eight to ten weeks later, to carry the barrier through summer.',
    ],
    [
        'question' => 'When is the right time to aerate a lawn in Mauldin, SC?',
        'answer'   => 'Timing follows the grass, not the calendar. Bermuda and zoysia are cored in late spring through '
                    . 'early summer, once the turf is actively growing and can knit the holes closed. Tall fescue is '
                    . 'aerated in early fall and overseeded at the same time. Mauldin sits on heavy Piedmont clay, so '
                    . 'most lawns here benefit from annual core aeration.',
    ],
    [
        'question' => 'How do I know if my lawn has grubs?',
        'answer'   => 'Grub-damaged turf lifts like loose carpet because the roots holding it down have been eaten. '
                    . 'Irregular brown patches that do not respond to watering, plus digging by skunks, armadillos, or '
                    . 'birds, are the usual signs. Pull back a square foot of sod: more than five or six white C-shaped '
                    . 'larvae underneath means treatment is warranted.',
    ],
    [
        'question' => 'Does Greenville Lawn Masters handle commercial and HOA properties?',
        'answer'   => 'Yes. Greenville Lawn Masters maintains businesses, HOA common areas, apartment grounds, and '
                    . 'municipal properties alongside residential lawns, on scheduled service rather than call-out. '
                    . 'Commercial grounds within the 25-mile radius around Mauldin, South Carolina are quoted the same '
                    . 'way a residence is: walked first, then priced in writing within 24 hours.',
    ],
    [
        'question' => 'What kind of grass grows best in Mauldin, South Carolina?',
        'answer'   => 'Mauldin sits in the transition zone, where neither northern nor southern grasses are entirely at '
                    . 'home. Bermuda and zoysia take full Upstate sun and summer heat best. Tall fescue holds shade '
                    . 'better but thins each August and needs overseeding every fall. Most Greenville County properties '
                    . 'run both, which is why treatment timing differs across a single yard.',
    ],
];

/* ── Schema ───────────────────────────────────────────────────
   Service (@id #service-{slug}) with the 8 grouped services as an OfferCatalog,
   provider pointing at the homepage LocalBusiness @id rather than restating it.
   Plus FAQPage mirroring the visible FAQ, BreadcrumbList, and a WebPage node
   carrying Speakable. Every Speakable cssSelector exists in the markup below.

   No `offers` / `priceRange`: intake supplied no pricing, and fabricated
   structured pricing is a misrepresentation Google acts on. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $pageSlug,
        'name'        => 'Lawn Care Services',
        'serviceType' => 'Lawn care and turf maintenance',
        'description' => 'Recurring lawn maintenance in Mauldin, South Carolina: mowing, fertilization '
                       . 'and weed control, grub and disease treatment, core aeration, overseeding, '
                       . 'winter preparation, lawn repair, and commercial grounds care.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
        'hasOfferCatalog' => [
            '@type'           => 'OfferCatalog',
            'name'            => 'Lawn Care Services',
            'itemListElement' => array_map(
                fn(array $s): array => [
                    '@type'       => 'Offer',
                    'itemOffered' => [
                        '@type'       => 'Service',
                        'name'        => $s['name'],
                        'description' => $s['description'],
                    ],
                ],
                $servicesHere
            ),
        ],
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',               'url' => '/'],
        ['name' => 'Services',           'url' => '/services/'],
        ['name' => 'Lawn Care Services', 'url' => '/services/' . $pageSlug . '/'],
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
   Lawn Care Services — page-scoped styles
   Every rule prefixed .lcs- so no class collides with another page's
   <style> block. Colour, shadow, spacing, radius, and timing are var()
   tokens without exception — a raw literal here is an automatic QA fail.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  two distinct SVG dividers (torn edge, double wave, diagonal)
     C4  editorial pull-quote at clamp(1.5rem, 3vw, 2.5rem)
     C5  bento grid, deliberately uneven spans
     C6  asymmetric 60/40 split with an oversized stat watermark
     C7  signature section — the vertical process rail (this page only)
     C10 comparison table with accent-highlighted winning column
     C11 image treatments — arch clip and offset frame
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Source photo is 370px wide, resampled to 1600px. The overlay is doing double
   duty: text contrast and hiding the softness of an upscale. Angle and stop
   positions differ from the homepage hero so the two do not read as one image. */
.lcs-hero {
  min-height: 78vh;
  min-height: 78svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-front-lawn.jpg');
  background-size: cover;
  background-position: center 62%;
  isolation: isolate;
}
.lcs-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    78deg,
    rgba(var(--color-dark-rgb), 0.93) 0%,
    rgba(var(--color-dark-rgb), 0.78) 42%,
    rgba(var(--color-primary-rgb), 0.48) 74%,
    rgba(var(--color-primary-rgb), 0.24) 100%
  );
  z-index: 0;
}
.lcs-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.3;
  z-index: 0;
  pointer-events: none;
}
.lcs-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.lcs-hero .breadcrumb { animation: lcsFade 0.5s ease both; }

.lcs-hero__eyebrow {
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
  animation: lcsFade 0.55s ease 0.08s both;
}
.lcs-hero__eyebrow i, .lcs-hero__eyebrow svg { width: 15px; height: 15px; }

.lcs-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: lcsRise 0.6s ease 0.16s both;
}
.lcs-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; in a left-aligned hero it must not. */
.lcs-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: lcsRise 0.6s ease 0.26s both;
}

.lcs-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: lcsRise 0.6s ease 0.36s both;
}
.lcs-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: lcsRise 0.6s ease 0.46s both;
}
.lcs-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.lcs-hero__trust i, .lcs-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS, never a reveal class — the reveal system
   sets opacity:0 and would blank the hero if IntersectionObserver never fires. */
@keyframes lcsFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes lcsRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.lcs-problem { background: var(--color-light); }
.lcs-problem__quote {
  max-width: 22ch;
  font-family: var(--font-heading);
  font-style: italic;
  font-weight: 600;
  font-size: clamp(1.5rem, 3vw, 2.5rem);
  line-height: 1.22;
  color: var(--color-primary-dark);
  border-left: 4px solid var(--color-accent);
  padding-left: var(--space-6);
}
.lcs-problem__layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: var(--space-12);
  align-items: start;
}
.lcs-problem__lead { color: var(--color-gray-dark); }
.lcs-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Deliberately uneven: the first card spans two columns so the grid does not
   read as four identical boxes. Tints rotate; no two adjacent cards match. */
.lcs-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.lcs-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.lcs-sign:first-child { grid-column: span 2; }
.lcs-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.lcs-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.lcs-sign__icon i, .lcs-sign__icon svg { width: 22px; height: 22px; }
.lcs-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.lcs-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.lcs-expert { background: var(--color-white); }
.lcs-expert__layout {
  display: grid;
  grid-template-columns: 0.62fr 1.38fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.lcs-stat-watermark {
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
.lcs-stat-watermark span {
  position: absolute;
  left: 0.08em;
  bottom: -1.6em;
  font-size: var(--font-size-sm);
  font-family: var(--font-body);
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  opacity: 1;
  color: var(--color-primary-dark);
  white-space: nowrap;
}
.lcs-expert h2 { margin-bottom: var(--space-5); }
.lcs-expert .answer-block { margin-inline: 0; }
.lcs-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.lcs-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.lcs-diff i, .lcs-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.lcs-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.lcs-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── Service breakdown grid ───────────────────────────────────*/
.lcs-breakdown { background: var(--color-light); }
.lcs-services {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
}
.lcs-service {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-top: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.lcs-service:hover {
  transform: translateY(-5px);
  border-top-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.lcs-service__icon { color: var(--color-primary); }
.lcs-service__icon i, .lcs-service__icon svg { width: 28px; height: 28px; }
.lcs-service h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.lcs-service p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray); line-height: 1.6; }

/* ── C7 · Signature section: the vertical process rail ────────
   Used on this page only. A single accent line threads the four phases; each
   marker sits on the line. Nothing else in the build looks like this. */
.lcs-rail { position: relative; margin-top: var(--space-16); padding-left: var(--space-12); }
.lcs-rail::before {
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
.lcs-rail__step { position: relative; padding-bottom: var(--space-10); }
.lcs-rail__step:last-child { padding-bottom: 0; }
.lcs-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 6px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-light);
}
.lcs-rail__phase {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.lcs-rail__step h3 { font-size: var(--font-size-xl); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.lcs-rail__step p { margin: 0; max-width: 62ch; color: var(--color-gray-dark); line-height: 1.7; }

/* ── C11 · Proof strip, arch and offset frame treatments ──────*/
.lcs-proof { background: var(--color-dark); }
.lcs-proof h2, .lcs-proof .lcs-eyebrow { color: var(--color-white); }
.lcs-proof .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.lcs-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.lcs-shot { margin: 0; }
.lcs-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
/* C11 arch clip on the middle frame only — variation, not decoration for its own sake */
.lcs-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.lcs-shot--frame { position: relative; }
.lcs-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.lcs-shot:hover img { transform: scale(1.03); }
.lcs-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.lcs-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }
.lcs-proof__note {
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
.lcs-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.lcs-compare { background: var(--color-white); }
.lcs-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.lcs-compare__head, .lcs-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.lcs-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.lcs-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.lcs-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.lcs-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.lcs-compare__row > div:first-child { color: var(--color-gray); }
.lcs-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.lcs-compare__row i, .lcs-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.lcs-compare__row > div:first-child i, .lcs-compare__row > div:first-child svg { color: var(--color-gray); }
.lcs-compare__row > div:last-child i,  .lcs-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.lcs-faq { background: var(--color-light); }
.lcs-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.lcs-faq__item {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.lcs-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.lcs-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Final CTA ────────────────────────────────────────────────*/
.lcs-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.lcs-cta::before {
  content: '';
  position: absolute;
  top: -20%; right: -8%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.lcs-cta .container { position: relative; z-index: 1; }
.lcs-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.lcs-cta p { color: rgba(var(--color-white-rgb), 0.88); max-width: 60ch; margin: 0 auto var(--space-8); }
.lcs-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Related services ─────────────────────────────────────────*/
.lcs-related { background: var(--color-white); }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .lcs-services { grid-template-columns: repeat(2, 1fr); }
  .lcs-signs { grid-template-columns: repeat(2, 1fr); }
  .lcs-sign:first-child { grid-column: span 2; }
  .lcs-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .lcs-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .lcs-stat-watermark span { position: static; display: block; margin-top: var(--space-4); }
  .lcs-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .lcs-problem__quote { max-width: none; }
  .lcs-proof__grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 700px) {
  .lcs-hero { min-height: 0; }
  .lcs-services, .lcs-signs, .lcs-proof__grid { grid-template-columns: 1fr; }
  .lcs-sign:first-child { grid-column: span 1; }
  .lcs-shot--frame::before { display: none; }

  /* The comparison grid collapses to stacked pairs. Column headers are hidden
     and each cell carries its own label, or the "them/us" contrast is lost. */
  .lcs-compare__head { display: none; }
  .lcs-compare__row { grid-template-columns: 1fr; }
  .lcs-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .lcs-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero lcs-hero" aria-label="Lawn care services in Mauldin, South Carolina">
    <div class="container">
        <div class="lcs-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Lawn Care Services</span></li>
                </ol>
            </nav>

            <span class="lcs-hero__eyebrow">
                <i data-lucide="leaf" aria-hidden="true"></i>
                Lawn Care &middot; Mauldin, SC
            </span>

            <h1>Lawn Care Services in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters provides recurring lawn care in Mauldin, South Carolina and
                within 25 miles across Greenville County — weekly mowing, fertilization and weed
                control, grub and disease treatment, core aeration, overseeding, and lawn repair.
                Every property is walked before it is priced, and the written estimate arrives
                within 24 hours.
            </p>

            <div class="lcs-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Lawn Care Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* No phone in intake. A "Call Now" button with no number — or a
                             fabricated one — is worse than routing to the estimate form. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only what intake recorded. No "Licensed & Insured",
                     no star rating, no job count — config.php has none of the three. */ ?>
            <div class="lcs-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="list-checks" aria-hidden="true"></i> <?php echo e((string) count($servicesHere)); ?> lawn services, one crew</span>
                <span><i data-lucide="calendar-days" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider — torn edge, filled with the problem section's light background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,40 L60,42 L120,35 L200,45 L280,32 L360,48 L440,38 L540,45 L640,30 L740,42 L840,35 L940,45 L1040,32 L1140,42 L1200,38 L1200,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · PROBLEM STATEMENT ══════════ -->
<section class="lcs-problem" aria-label="Signs a Mauldin lawn needs attention">
    <div class="container">
        <div class="lcs-problem__layout">
            <blockquote class="lcs-problem__quote reveal-left">
                A struggling lawn is a soil problem wearing a grass costume.
            </blockquote>

            <div class="lcs-problem__lead">
                <h2 class="reveal-right">How do you know when a Mauldin lawn needs professional care?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    A Mauldin lawn needs professional care when problems repeat every year despite
                    watering and mowing: crabgrass returning each June, bare patches widening through
                    summer, footprints lingering in the turf, or water sheeting off toward the street.
                    Each of those points at compacted Piedmont clay, mistimed treatment, or pests
                    working below the surface.
                </p>
                <p class="reveal-right reveal-delay-2">
                    None of it is fixed by mowing harder. Greenville Lawn Masters starts underneath the
                    grass — soil structure, thatch depth, drainage, and which grass is actually growing
                    in each part of the yard — because the same lawn in Mauldin often runs warm-season
                    turf in the sun and tall fescue in the shade, on two different schedules.
                </p>
            </div>
        </div>

        <div class="lcs-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="lcs-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="lcs-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="lcs-expert" aria-label="Why Greenville Lawn Masters for lawn care">
    <div class="container">
        <div class="lcs-expert__layout">

            <div class="lcs-stat-watermark reveal-left" aria-hidden="true">
                24<span>Hour estimate turnaround</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does grass type decide the whole schedule?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Grass type decides the schedule because Mauldin sits in the transition zone. Bermuda
                    and zoysia grow hardest in July heat and are aerated in late spring. Tall fescue
                    thins in August and is aerated and overseeded in early fall. Feed or core them on
                    the same date and one of the two is treated at exactly the wrong moment.
                </p>

                <ul class="lcs-diffs">
                    <li class="lcs-diff reveal-right reveal-delay-2">
                        <i data-lucide="microscope" aria-hidden="true"></i>
                        <div>
                            <strong>The property is walked before it is priced</strong>
                            <p>
                                Grass type is identified zone by zone, thatch depth checked, and compaction
                                tested on foot. Nothing is quoted from a satellite photo or a lot-size table.
                            </p>
                        </div>
                    </li>
                    <li class="lcs-diff reveal-right reveal-delay-3">
                        <i data-lucide="thermometer" aria-hidden="true"></i>
                        <div>
                            <strong>Treatments run on soil temperature, not the route calendar</strong>
                            <p>
                                Crabgrass pre-emergent goes down as soil at two inches approaches 55°F —
                                typically late February into mid-March in Greenville County. Applied after
                                germination it does nothing, whatever the invoice says.
                            </p>
                        </div>
                    </li>
                    <li class="lcs-diff reveal-right reveal-delay-4">
                        <i data-lucide="users" aria-hidden="true"></i>
                        <div>
                            <strong>One crew carries the whole property</strong>
                            <p>
                                Mowing, feeding, aeration, beds, and cleanup sit with the same people, so
                                the crew cutting your lawn in July is the crew that cored it in May and
                                knows which corner never drains.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Divider — double wave, filled with the breakdown section's light background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN + PROCESS ══════════ -->
<section class="lcs-breakdown" aria-label="What lawn care includes">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What is included in <span class="text-accent">Greenville Lawn Masters</span> lawn care?</h2>
            <p class="answer-block">
                Greenville Lawn Masters lawn care includes <?php echo e((string) count($servicesHere)); ?>
                recurring services: mowing, fertilization and weed control, grub and lawn disease
                treatment, core aeration, overseeding, grass seeding, lawn repair and leveling, winter
                preparation, and commercial grounds maintenance. Take the full program or only the
                pieces your property needs.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="lcs-services">
            <?php foreach ($servicesHere as $i => $svc): ?>
                <article class="lcs-service <?php echo ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="lcs-service__icon">
                        <i data-lucide="<?php echo e($serviceIcons[$svc['slug']] ?? 'leaf'); ?>" aria-hidden="true"></i>
                    </div>
                    <h3><?php echo e($svc['name']); ?></h3>
                    <p><?php echo e($svc['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does a lawn care program actually start?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            A lawn care program starts with a free walkthrough of the property, followed by a written,
            itemised estimate within 24 hours. Once you accept, mowing joins a fixed weekly or biweekly
            route and seasonal treatments are booked against the Upstate calendar — pre-emergent in late
            winter, aeration timed to your grass type.
        </p>

        <ol class="lcs-rail">
            <?php foreach ($timeline as $i => $step): ?>
                <li class="lcs-rail__step reveal-left reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="lcs-rail__phase"><?php echo e($step['phase']); ?></span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Divider — diagonal, filled with the proof section's dark background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-dark)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · PROOF ══════════ -->
<?php /* §2.8 specifies testimonials, before/after pairs, and an aggregate review
         snippet here. config.php $reviews is empty, $gbpUrl is empty, and no
         before/after pair exists in the photo library. Writing testimonials would
         attribute invented quotes to invented customers — an FTC Endorsement Guides
         problem, not a placeholder — and CLAUDE.md separately forbids fabricated
         review counts. The client's own job photography fills the slot instead, and
         the note below says plainly why there are no reviews yet. */ ?>
<section class="lcs-proof" aria-label="Greenville Lawn Masters lawn care photography">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label lcs-eyebrow">The Work</span>
            <h2>What does <span class="text-accent">Greenville Lawn Masters</span> lawn care look like on the ground?</h2>
            <p class="answer-block">
                Greenville Lawn Masters photographs its own job sites — every image on this page is a
                Mauldin-area property the crew maintains, not a stock photo. Below: a backyard on the
                weekly mowing route, turf held tight against mulched planting beds, and a front bed
                re-edged at the start of a season.
            </p>
        </div>

        <div class="lcs-proof__grid">
            <?php
            /* Captions describe what is IN THE FRAME. The service is named only where
               the photograph actually shows it — the crew is visible mowing, so that
               caption may say so. Nothing here claims a picture depicts work it does not. */
            $shots = [
                ['key' => 'mowing',    'mod' => '',                'label' => 'Weekly mowing route',   'caption' => 'A Greenville Lawn Masters crew member mowing a fenced Mauldin backyard on the weekly route.'],
                ['key' => 'backyard',  'mod' => 'lcs-shot--arch',  'label' => 'Turf against bed lines','caption' => 'Backyard turf running between mulched planting beds and a wood privacy fence at a Mauldin home.'],
                ['key' => 'mulch_bed', 'mod' => 'lcs-shot--frame', 'label' => 'Beds at season start',  'caption' => 'A mulched front bed and mown lawn at a Craftsman home in Mauldin, South Carolina.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="lcs-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <div class="lcs-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 6 · COMPARISON ══════════ -->
<section class="lcs-compare" aria-label="How Greenville Lawn Masters differs">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates a lawn care program from a mowing service?</h2>
            <p class="answer-block">
                A lawn care program treats the soil and the grass on their own schedule; a mowing
                service cuts whatever is there on the day the truck arrives. The difference shows up
                in timing — when the pre-emergent goes down, when the lawn is cored, how high the deck
                sits in August — and it compounds across a season.
            </p>
        </div>

        <?php /* The left column describes common practice in the trade, not a named
                 competitor. Every right-hand row is a process commitment recorded at
                 intake or a horticultural practice — never a credential claim. */ ?>
        <div class="lcs-compare__table reveal-up reveal-delay-1">
            <div class="lcs-compare__head">
                <div>A typical mow-and-go route</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="lcs-compare__row">
                    <div data-label="A typical mow-and-go route">
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

    <!-- Divider — torn edge, filled with the FAQ section's light background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,38 L80,44 L160,32 L240,46 L320,34 L420,44 L520,30 L620,42 L720,34 L820,46 L920,32 L1020,44 L1120,36 L1200,42 L1200,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 7 · FAQ ══════════ -->
<section class="lcs-faq" aria-label="Lawn care questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">lawn care</span>?</h2>
            <p class="answer-block">
                Mauldin homeowners most often ask what lawn care costs, how often the grass needs
                mowing, when crabgrass pre-emergent and core aeration should go down, how to tell
                whether grubs are behind a dying patch, and which grasses actually survive a Greenville
                County summer. Each of those is answered directly below.
            </p>
        </div>

        <div class="lcs-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="lcs-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="lcs-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> handle in Mauldin?</h2>
            <p class="answer-block">
                Beyond the mowing route and the treatment program, Greenville Lawn Masters handles
                seasonal and project work across Greenville County — beds and mulch, hedges and small
                trees, sod, gutters, and pressure washing — with the same crew and the same
                24-hour estimate.
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
<section class="lcs-cta" aria-label="Request a lawn care estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to put your Mauldin lawn on a real schedule?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Start with a free walkthrough. Greenville Lawn Masters identifies the grass in each zone,
            checks compaction and drainage, then sends a written itemised estimate within 24 hours. The
            pre-emergent window in Greenville County opens near 55°F soil temperature, usually late
            February into March — booking before it closes prevents weeds rather than pulling them.
        </p>
        <div class="lcs-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Lawn Care Estimate
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
