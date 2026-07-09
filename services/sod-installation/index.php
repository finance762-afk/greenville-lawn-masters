<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/sod-installation/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page: sod installation is its own page (config.php
   $servicePages), not a section in a group.

   Nothing on this page is invented. No prices, price ranges, or
   "$X per pallet" — intake supplied no pricing, and a fabricated
   figure amplified through Service/FAQ schema is a misrepresentation
   to Google, not a placeholder. No reviews, star ratings, or
   testimonials — config.php $reviews is empty and inventing an
   endorsement is an FTC Endorsement Guides problem. No "licensed &
   insured", no certifications, no warranty/guarantee, no sod-farm or
   supplier brand names, no square-footage-installed or jobs-count
   statistics — intake recorded none of them.

   The horticultural claims (warm-season sod timing, same-day laying,
   staggered running-bond pattern, rolling for soil contact, the
   two-week daily-water window, the tug test, the first-mow timing)
   are facts about SC Piedmont / Upstate turf culture, USDA zone 7b-8a,
   which are checkable. The business claims are limited to what
   build-plan.json recorded: founded 2024, one crew, 25-mile radius,
   free walkthrough, written itemised estimate within 24 hours, a
   watering plan handed over at completion, 22 total services.

   ⚠ PHOTO GAP: $servicePhotos['sod-installation'] carries
   photo_gap => true. Not one of the six client photographs shows sod
   being laid, a sod pallet, or bare graded soil — every frame is a
   finished, established property. So no caption or alt here claims a
   photo depicts sod work. See the PROOF section and the .photo-note
   disclosure below, both gated on that flag.
   ============================================================ */

$pageSlug    = 'sod-installation';
$currentPage = 'services';

$service = servicesOnPage($pageSlug)[0] ?? null;   // solo page → single service
$media   = servicePagePhotos($pageSlug);           // hero + body + photo_gap
$heroImg = heroPhoto($media['hero']);              // 'front_lawn' → 1600px rendition

$pageTitle       = 'Sod Installation in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Sod installation in Mauldin, SC. Soil graded and prepared, warm-season sod laid and rolled, watering plan at handover. Written estimate in 24 hours.';   // 148 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];   // LCP hero, preloaded in head.php

/* Phone is empty in config.php ($missingIntake). $hasPhone gates every tel:
   button — a "Call Now" link with no number, or an invented one, is worse than
   routing the visitor to the free-estimate form. */
$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Telltale signs (problem statement) ───────────────────────
   Symptoms a homeowner can verify by walking the property — the four cases
   where sod, not seed, is the honest answer. Tints rotate; no two adjacent. */
$signs = [
    ['icon' => 'sprout',       'title' => 'More weed than grass',          'body' => 'When a lawn is so far gone that pulling the weeds would leave bare dirt, overseeding has nothing to hold. Killing off the stand and laying fresh sod resets it in a day instead of over two thin seasons.'],
    ['icon' => 'layers',       'title' => 'Bare, compacted clay',          'body' => 'Piedmont clay packs down until seed washes off before it germinates. Sod arrives already rooted into its own soil mat, so it establishes on ground where broadcast seed simply never takes.'],
    ['icon' => 'construction', 'title' => 'A scraped new-construction lot', 'body' => 'Builders routinely haul the topsoil off and grade the lot to subsoil. A yard of raw clay and construction fill needs amended soil and sod, not a bag of seed thrown over the top.'],
    ['icon' => 'mountain',     'title' => 'Washouts on a slope',           'body' => 'Seed on a grade runs to the bottom with the first hard Upstate rain. Sod pins the slope the moment it is rolled down, stabilising the soil against erosion immediately.'],
];

/* ── What a sod installation includes (service breakdown) ─────
   Six steps that decide whether the sod ever roots. Horticultural facts, no
   claim to equipment or crew size beyond the one crew intake recorded. */
$includes = [
    ['icon' => 'trash-2',     'title' => 'Kill and strip the old lawn',   'body' => 'Existing weeds and dead turf are killed off and cleared so the new sod meets clean, workable soil instead of a mat of the exact vegetation you are replacing.'],
    ['icon' => 'move-3d',     'title' => 'Grade and correct drainage',    'body' => 'The ground is shaped to run water away from the house and off the low corners. Sod laid over a drainage problem inherits the drainage problem.'],
    ['icon' => 'layers-2',    'title' => 'Till and amend the soil',       'body' => 'Compacted clay is broken up and amended so roots can drive down. On scraped lots this is the difference between sod that knits in and sod that sits on top and dries out.'],
    ['icon' => 'grid-2x2',    'title' => 'Lay in a staggered pattern',    'body' => 'Pieces go down in a running-bond pattern, seams tight and offset like brickwork and staggered across any slope. Air gaps under a seam kill the sod above them.'],
    ['icon' => 'been-here',   'title' => 'Roll for soil contact',         'body' => 'The laid sod is rolled to press its roots into firm contact with the soil beneath. Contact is what lets roots cross from the sod mat into your ground.'],
    ['icon' => 'droplets',    'title' => 'Hand over a watering plan',     'body' => 'Every job ends with a written watering plan — how much, how often, and when to taper — because the first two weeks of watering decide whether the whole install roots or fails.'],
];

/* ── Install-day sequence (process/timeline block) ────────────
   What one installation day looks like, front to back. Vertical rail. */
$process = [
    ['phase' => 'Before the truck', 'title' => 'Free walkthrough and written estimate', 'body' => 'The property is walked first — grass goal, sun and shade, slope, drainage, and how much soil the builder left behind. An itemised estimate follows within 24 hours, so the sod, the soil prep, and any grading are priced separately rather than rolled into one number.'],
    ['phase' => 'Same day it arrives', 'title' => 'Soil prepped, then sod laid', 'body' => 'Sod is a live, harvested crop that heats and rots on the pallet within a day or two of Upstate summer heat, so it goes down on prepared soil the same day it is delivered. Prep and laying happen in one visit — never a pallet left sitting over a weekend.'],
    ['phase' => 'Before the crew leaves', 'title' => 'Rolled, watered in, walked with you', 'body' => 'The finished lawn is rolled for soil contact and given its first deep soak. One crew handles the whole property start to finish, so the person who graded the lot is the person who hands you the watering plan and points out the corners to watch.'],
];

/* ── Sod-vs-drop comparison ───────────────────────────────────
   Left column = common trade practice, NOT a named competitor. Every right-hand
   row is a process commitment intake recorded or an agronomic practice we
   perform — never a credential, price, or guarantee claim. */
$comparison = [
    ['them' => 'Sod dropped straight onto whatever soil is there',       'us' => 'Soil killed off, graded, tilled, and amended before a single piece goes down'],
    ['them' => 'Pallets left sitting a day or two until there is time',   'us' => 'Sod laid the same day it is delivered, before it heats on the pallet'],
    ['them' => 'Seams butted loosely, ends lined up in rows',            'us' => 'Running-bond pattern, seams tight and staggered across the slope'],
    ['them' => 'Walked away once the last piece is down',                'us' => 'Rolled for soil contact and given a deep first watering before the crew leaves'],
    ['them' => '"Just keep it wet" and a wave goodbye',                  'us' => 'A written watering plan — amount, frequency, and when to taper — handed over at completion'],
    ['them' => 'Warm-season sod sold in any month a sale closes',        'us' => 'Warm-season sod timed to the growing season so it roots before dormancy'],
];

/* ── Sod establishment countdown (SIGNATURE — this page only) ──
   The horizontal day-by-day rail rendered below. `drops` (1-3) drives the
   watering-intensity indicator per stage; watering tapers left→right as roots
   go down. Unique to this page — nothing else in the build looks like it. */
$stages = [
    ['day' => 'Day 0',      'title' => 'Sod goes down',        'drops' => 3, 'body' => 'Laid on prepped soil, rolled, and soaked deeply the same day it arrives.'],
    ['day' => 'Days 1–14',  'title' => 'Daily watering',       'drops' => 3, 'body' => 'Watered deeply every day — often twice a day in summer heat — to keep the roots and the soil beneath them wet while they knit.'],
    ['day' => 'Weeks 2–3',  'title' => 'First mow & root check','drops' => 2, 'body' => 'Once rooted enough not to shift, the first cut goes on at a high deck, taking no more than a third of the blade. Watering tapers to less often but deeper.'],
    ['day' => 'Week 4+',    'title' => 'Knitted in',           'drops' => 1, 'body' => 'Roots have crossed into your soil. The lawn moves onto a normal, deeper, less frequent watering rhythm and joins the mowing calendar.'],
];

/* ── FAQs — conversational, 40-80 words (aeo-content-schema §2.4) ──
   Rendered visibly below AND passed to generateFAQSchema(); the two must match.
   Each opens with the full company name and a direct answer (chunk-level rule).
   No pricing anywhere — none was supplied, and an invented range echoed through
   FAQPage schema is a misrepresentation, not a placeholder. */
$faqs = [
    [
        'question' => 'When is the best time to lay sod in Mauldin, SC?',
        'answer'   => 'Greenville Lawn Masters lays warm-season sod — bermuda, zoysia, or centipede — from late spring through summer, while the grass is actively growing and can root before it goes dormant. Sod laid in late fall goes dormant before it knits down and can be lifted by winter frost heave. In the Upstate transition zone, timing to the growing season is what carries new sod through its first winter.',
    ],
    [
        'question' => 'How long before I can walk on or mow new sod?',
        'answer'   => 'Greenville Lawn Masters asks homeowners to stay off fresh sod for the first couple of weeks so the pieces do not shift before roots take hold. The first mow usually waits until about two to three weeks, once a gentle tug meets resistance, and goes on at a high deck setting removing no more than a third of the blade. Mowing too early tears sod loose at the seams.',
    ],
    [
        'question' => 'What kind of sod grows best in Greenville County?',
        'answer'   => 'Greenville Lawn Masters works with warm-season grasses that take full Upstate sun and summer heat: bermuda for durability, zoysia for a dense finish, and centipede as a low-input option well suited to the acidic Piedmont soils here. Tall fescue is normally seeded rather than sodded this far north. The right choice depends on sun, traffic, and how much upkeep the lawn will get.',
    ],
    [
        'question' => 'Do I really have to water new sod every day?',
        'answer'   => 'Yes. Greenville Lawn Masters hands over a watering plan at completion because the first two weeks decide everything. New sod needs deep daily watering — often twice a day in peak heat — to keep both the sod and the soil below it wet while roots cross over. After roughly two weeks the plan tapers to less frequent, deeper watering that pulls roots down.',
    ],
    [
        'question' => 'Can sod be installed on a slope or bare clay?',
        'answer'   => 'Yes, and those are the cases sod handles best. Greenville Lawn Masters grades and amends compacted Piedmont clay first, then lays and rolls the sod so it pins the ground immediately — seed would wash off a grade with the first hard rain. On slopes the pieces are staggered across the incline. Sod stabilises the soil against erosion the day it goes down.',
    ],
    [
        'question' => 'Is sod better than seed for a new-construction lawn?',
        'answer'   => 'For most new-construction lots around Mauldin, Greenville Lawn Masters finds sod the more reliable choice. Builders often scrape the topsoil off and leave graded subsoil, where broadcast seed struggles to hold. Sod arrives already rooted into its own soil mat and gives an established lawn in a day. Seed is cheaper up front but takes seasons to fill in and washes off bare clay.',
    ],
    [
        'question' => 'Why does sod have to be laid the same day it is delivered?',
        'answer'   => 'Sod is a live, harvested crop, and Greenville Lawn Masters treats it that way. Stacked on a pallet in Upstate summer heat, it begins to heat and rot within a day or two, and grass pulled from the middle of the stack yellows fast. Laying it onto prepared soil the same day it arrives is the difference between sod that roots and sod that arrives already dying.',
    ],
];

/* ── Schema — exactly 4 nodes ─────────────────────────────────
   (a) Service (@id #service-sod-installation), provider → homepage @id, no offers
   (b) FAQPage mirroring the visible FAQ
   (c) BreadcrumbList
   (d) WebPage with Speakable (every cssSelector exists in the markup below)

   No `offers` / `priceRange`: intake supplied no pricing, and fabricated
   structured pricing is a misrepresentation Google acts on. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $pageSlug,
        'name'        => 'Sod Installation',
        'serviceType' => 'Sod installation and new lawn establishment',
        'description' => $service['description']
                       ?? 'Professional sod installation in Mauldin, SC for new lawns and full lawn renovation.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',             'url' => '/'],
        ['name' => 'Services',         'url' => '/services/'],
        ['name' => 'Sod Installation', 'url' => '/services/' . $pageSlug . '/'],
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
   Sod Installation — page-scoped styles
   Every rule prefixed .sod- so nothing collides with another page's
   <style> block. Colour, shadow, spacing, radius, timing, and type are
   var() tokens without exception — a raw literal here is an automatic QA
   fail. Geometric px appear only inside clip-path, @keyframes, and the
   countdown rail, where they are explicitly permitted.

   Techniques (design-system.md Part C):
     C1  layered hero — photo + duotone gradient ::before + noise ::after
     C3  two distinct SVG dividers (torn edge, layered wave, diagonal)
     C4  editorial pull-quote
     C5  bento grid of telltale signs, deliberately uneven
     C6  asymmetric 62/38 split with an oversized stat watermark
     C7  SIGNATURE — the horizontal sod-establishment countdown rail
     C10 comparison table with the accent-highlighted winning column
     C11 image treatments — arch clip + offset frame
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Same source frame as the lawn-care page, so the overlay MUST read
   differently: a 118deg angle (not the reference's 78deg or the homepage's
   100deg), shifted stop positions, and a radial vignette layered on top for a
   deeper, duotone-ish cast. The overlay also hides the softness of an upscale. */
.sod-hero {
  min-height: 78vh;
  min-height: 78svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-front-lawn.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.sod-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    radial-gradient(120% 90% at 82% 8%, rgba(var(--color-accent-rgb), 0.30) 0%, rgba(var(--color-accent-rgb), 0) 46%),
    linear-gradient(
      118deg,
      rgba(var(--color-dark-rgb), 0.94) 0%,
      rgba(var(--color-dark-rgb), 0.86) 30%,
      rgba(var(--color-primary-dark-rgb, var(--color-primary-rgb)), 0.62) 62%,
      rgba(var(--color-primary-rgb), 0.30) 100%
    );
  z-index: 0;
}
.sod-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.sod-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.sod-hero .breadcrumb { animation: sodFade 0.5s ease both; }

.sod-hero__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  background: rgba(var(--color-accent-rgb), 0.16);
  border: 1px solid rgba(var(--color-accent-rgb), 0.40);
  border-radius: var(--radius-full);
  padding: var(--space-1) var(--space-4);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2.5px;
  color: var(--color-accent);
  margin-bottom: var(--space-5);
  animation: sodFade 0.55s ease 0.08s both;
}
.sod-hero__eyebrow i, .sod-hero__eyebrow svg { width: 15px; height: 15px; }

.sod-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: sodRise 0.6s ease 0.16s both;
}
.sod-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; in this left-aligned hero it must not. */
.sod-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.90);
  margin-bottom: var(--space-8);
  animation: sodRise 0.6s ease 0.26s both;
}

.sod-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: sodRise 0.6s ease 0.36s both;
}
.sod-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: sodRise 0.6s ease 0.46s both;
}
.sod-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.sod-hero__trust i, .sod-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS, never a reveal class — the reveal system
   sets opacity:0 and would blank the hero if IntersectionObserver never fires. */
@keyframes sodFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes sodRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.sod-problem { background: var(--color-light); }
.sod-problem__layout {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: var(--space-12);
  align-items: start;
}
.sod-problem__quote {
  max-width: 20ch;
  font-family: var(--font-heading);
  font-style: italic;
  font-weight: 600;
  font-size: clamp(1.5rem, 3vw, 2.5rem);
  line-height: 1.22;
  color: var(--color-primary-dark);
  border-left: 4px solid var(--color-accent);
  padding-left: var(--space-6);
}
.sod-problem__lead { color: var(--color-gray-dark); }
.sod-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Uneven on purpose: the last card spans two columns so the row does not read
   as four identical boxes. Tints rotate; no two adjacent cards match. */
.sod-signs {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.sod-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.10);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.sod-sign:last-child { grid-column: span 3; }
.sod-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.sod-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.sod-sign__icon i, .sod-sign__icon svg { width: 22px; height: 22px; }
.sod-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.sod-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.sod-expert { background: var(--color-white); }
.sod-expert__layout {
  display: grid;
  grid-template-columns: 0.62fr 1.38fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.sod-stat-watermark {
  position: relative;
  font-family: var(--font-heading);
  font-weight: 900;
  font-size: clamp(5rem, 12vw, 11rem);
  line-height: 0.82;
  letter-spacing: -0.05em;
  color: var(--color-primary);
  opacity: 0.14;
  user-select: none;
}
.sod-stat-watermark span {
  position: absolute;
  left: 0.08em;
  bottom: -1.9em;
  font-size: var(--font-size-sm);
  font-family: var(--font-body);
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  opacity: 1;
  color: var(--color-primary-dark);
  white-space: nowrap;
}
.sod-expert h2 { margin-bottom: var(--space-5); }
.sod-expert .answer-block { margin-inline: 0; }
.sod-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.sod-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.sod-diff i, .sod-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.sod-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.sod-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── Service breakdown grid ───────────────────────────────────*/
.sod-breakdown { background: var(--color-light); }
.sod-includes {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-5);
}
.sod-include {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-top: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.sod-include:hover {
  transform: translateY(-5px);
  border-top-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.sod-include__icon {
  width: 48px; height: 48px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: rgba(var(--color-primary-rgb), 0.08);
  color: var(--color-primary);
}
.sod-include__icon i, .sod-include__icon svg { width: 24px; height: 24px; }
.sod-include h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.sod-include p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray-dark); line-height: 1.6; }

/* Install-day process — a vertical rail. Deliberately a DIFFERENT orientation
   from the horizontal signature countdown below, so the two never read alike. */
.sod-rail { position: relative; margin-top: var(--space-16); padding-left: var(--space-12); }
.sod-rail::before {
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
.sod-rail__step { position: relative; padding-bottom: var(--space-10); }
.sod-rail__step:last-child { padding-bottom: 0; }
.sod-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 6px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-light);
}
.sod-rail__phase {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.sod-rail__step h3 { font-size: var(--font-size-xl); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.sod-rail__step p { margin: 0; max-width: 64ch; color: var(--color-gray-dark); line-height: 1.7; }

/* ── C7 · SIGNATURE: sod establishment countdown ──────────────
   A horizontal day-by-day rail: install → daily watering → first mow / root
   check → knitted in. A progress track threads the four stage dots; a wedge bar
   tapers left→right to picture watering intensity dropping as roots go down; a
   droplet meter repeats the same signal per stage; a tug-test callout sits at
   the point in the timeline where the test is done. This composition appears on
   NO other page in the build. Geometric px are permitted in this rail. */
.sod-establish { background: var(--color-dark); }
.sod-establish .section-header h2,
.sod-establish .section-header .eyebrow-label { color: var(--color-white); }
.sod-establish .section-header .answer-block { color: rgba(var(--color-white-rgb), 0.80); margin-inline: auto; }

.sod-countdown {
  position: relative;
  margin-top: var(--space-16);
  padding-top: 26px;   /* clears the dot row that sits on the track */
}
.sod-countdown__track {
  position: absolute;
  top: 6px;
  left: 6%;
  right: 6%;
  height: 3px;
  border-radius: var(--radius-full);
  background: linear-gradient(
    to right,
    var(--color-accent) 0%,
    rgba(var(--color-accent-rgb), 0.55) 55%,
    rgba(var(--color-accent-rgb), 0.20) 100%
  );
}
.sod-countdown__grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-6);
}
.sod-stage {
  position: relative;
  text-align: center;
  padding: 0 var(--space-2);
}
.sod-stage__dot {
  position: absolute;
  top: -26px;
  left: 50%;
  transform: translateX(-50%);
  width: 16px; height: 16px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 5px var(--color-dark), 0 0 0 6px rgba(var(--color-accent-rgb), 0.4);
}
.sod-stage__day {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-2);
}
.sod-stage h3 { color: var(--color-white); font-size: var(--font-size-lg); margin-bottom: var(--space-2); }
.sod-stage p { color: rgba(var(--color-white-rgb), 0.70); font-size: var(--font-size-sm); line-height: 1.6; margin: 0 auto; max-width: 30ch; }

/* Droplet meter — three drops per stage, faded when watering has tapered. */
.sod-stage__water {
  display: flex;
  justify-content: center;
  gap: var(--space-1);
  margin: var(--space-4) 0 var(--space-2);
}
.sod-stage__water i, .sod-stage__water svg { width: 16px; height: 16px; }
.sod-drop--on  { color: var(--color-accent); }
.sod-drop--off { color: rgba(var(--color-white-rgb), 0.18); }

/* Watering-intensity wedge — a decorative bar that tapers as the timeline runs,
   the visual echo of daily-water → deep-and-infrequent. clip-path px permitted. */
.sod-water-bar {
  position: relative;
  margin: var(--space-10) 6% 0;
  height: 40px;
  border-radius: var(--radius-sm);
  background: linear-gradient(to right, rgba(var(--color-accent-rgb), 0.85), rgba(var(--color-accent-rgb), 0.30));
  clip-path: polygon(0 0, 100% 62%, 100% 100%, 0 100%);
}
.sod-water-bar__label {
  position: absolute;
  bottom: calc(100% + var(--space-2));
  font-size: var(--font-size-xs);
  font-weight: 600;
  letter-spacing: 0.5px;
  text-transform: uppercase;
  color: rgba(var(--color-white-rgb), 0.62);
}
.sod-water-bar__label--start { left: 0; }
.sod-water-bar__label--end { right: 0; }

/* Tug-test callout — the field check that tells you the sod has rooted. */
.sod-tugtest {
  display: flex;
  align-items: flex-start;
  gap: var(--space-4);
  max-width: 60ch;
  margin: var(--space-12) auto 0;
  padding: var(--space-5) var(--space-6);
  border-radius: var(--radius-md);
  background: rgba(var(--color-white-rgb), 0.05);
  border-left: 3px solid var(--color-accent);
}
.sod-tugtest i, .sod-tugtest svg { width: 26px; height: 26px; color: var(--color-accent); flex-shrink: 0; margin-top: 2px; }
.sod-tugtest strong { display: block; color: var(--color-white); font-family: var(--font-heading); font-size: var(--font-size-lg); margin-bottom: var(--space-1); }
.sod-tugtest p { margin: 0; color: rgba(var(--color-white-rgb), 0.72); font-size: var(--font-size-sm); line-height: 1.7; }

/* ── C11 · Proof strip, arch + offset frame treatments ────────*/
.sod-proof { background: var(--color-white); }
.sod-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.sod-shot { margin: 0; }
.sod-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
.sod-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.sod-shot--frame { position: relative; }
.sod-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.sod-shot:hover img { transform: scale(1.03); }
.sod-shot figcaption {
  margin-top: var(--space-3);
  color: var(--color-gray);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.sod-shot figcaption strong { display: block; color: var(--color-primary-dark); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }
.sod-proof__note {
  max-width: 65ch;
  margin: var(--space-10) auto 0;
  padding: var(--space-5) var(--space-6);
  border-radius: var(--radius-md);
  background: var(--color-light);
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  text-align: center;
}
.sod-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.sod-compare { background: var(--color-light); }
.sod-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.sod-compare__head, .sod-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.sod-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.sod-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.sod-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.sod-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
  background: var(--color-white);
}
.sod-compare__row > div:first-child { color: var(--color-gray); }
.sod-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.sod-compare__row i, .sod-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.sod-compare__row > div:first-child i, .sod-compare__row > div:first-child svg { color: var(--color-gray); }
.sod-compare__row > div:last-child i,  .sod-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.sod-faq { background: var(--color-white); }
.sod-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.sod-faq__item {
  background: var(--color-light);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.sod-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.sod-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.sod-related { background: var(--color-light); }

/* ── Final CTA ────────────────────────────────────────────────*/
.sod-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.sod-cta::before {
  content: '';
  position: absolute;
  bottom: -22%; left: -8%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.sod-cta .container { position: relative; z-index: 1; }
.sod-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.sod-cta p { color: rgba(var(--color-white-rgb), 0.88); max-width: 60ch; margin: 0 auto var(--space-8); }
.sod-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .sod-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .sod-problem__quote { max-width: none; }
  .sod-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .sod-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .sod-stat-watermark span { position: static; display: block; margin-top: var(--space-6); }
  .sod-includes { grid-template-columns: repeat(2, 1fr); }
  .sod-signs { grid-template-columns: repeat(2, 1fr); }
  .sod-sign:last-child { grid-column: span 2; }
  .sod-proof__grid { grid-template-columns: 1fr 1fr; }

  /* The countdown stacks to a vertical rail on tablet; the horizontal track and
     tapering wedge only make sense across a wide row, so they are dropped. */
  .sod-countdown__grid { grid-template-columns: 1fr; gap: var(--space-8); text-align: left; }
  .sod-countdown__track, .sod-water-bar { display: none; }
  .sod-stage { text-align: left; padding-left: var(--space-8); }
  .sod-stage p { margin-inline: 0; }
  .sod-stage__dot { top: 4px; left: 0; transform: none; }
  .sod-stage__water { justify-content: flex-start; }
}
@media (max-width: 700px) {
  .sod-hero { min-height: 0; }
  .sod-includes, .sod-signs, .sod-proof__grid { grid-template-columns: 1fr; }
  .sod-sign:last-child { grid-column: span 1; }
  .sod-shot--frame::before { display: none; }
  .sod-hero__actions .btn { width: 100%; justify-content: center; }

  /* Comparison collapses to stacked pairs; hidden headers, per-cell labels. */
  .sod-compare__head { display: none; }
  .sod-compare__row { grid-template-columns: 1fr; }
  .sod-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero sod-hero" aria-label="Sod installation in Mauldin, South Carolina">
    <div class="container">
        <div class="sod-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Sod Installation</span></li>
                </ol>
            </nav>

            <span class="sod-hero__eyebrow">
                <i data-lucide="layout-grid" aria-hidden="true"></i>
                Sod Installation &middot; Mauldin, SC
            </span>

            <h1>Sod Installation in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters installs warm-season sod across Mauldin, South Carolina and
                within 25 miles of Greenville County — grading and amending the soil, laying the sod
                the same day it arrives, and rolling it in for an instantly established lawn. Every
                property is walked before it is priced, and the written estimate arrives within 24 hours.
            </p>

            <div class="sod-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Sod Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* No phone recorded at intake. A "Call Now" button with no number —
                             or a fabricated one — is worse than routing to the estimate form. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only what intake recorded — no "Licensed & Insured",
                     no star rating, no job count, no square-footage installed. */ ?>
            <div class="sod-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="sun" aria-hidden="true"></i> Warm-season sod for the Upstate</span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
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
<section class="sod-problem" aria-label="When sod is the right answer for a Mauldin lawn">
    <div class="container">
        <div class="sod-problem__layout">
            <blockquote class="sod-problem__quote reveal-left">
                Some lawns are past reseeding. They need a fresh start, not another bag of seed.
            </blockquote>

            <div class="sod-problem__lead">
                <h2 class="reveal-right">How do you know when a Mauldin lawn needs sod instead of seed?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    A Mauldin lawn needs sod rather than seed when there is nothing left worth saving:
                    a stand that is more weed than grass, bare compacted clay where seed washes off,
                    a new-construction lot scraped down to subsoil, or a slope that erodes before seed
                    can root. Sod gives an established lawn in a day where seed would take seasons.
                </p>
                <p class="reveal-right reveal-delay-2">
                    Greenville Lawn Masters starts by reading the ground underneath, because sod laid
                    over compacted clay or a drainage problem inherits that problem. On the SC Piedmont
                    the soil work — grading, tilling, amending — is what decides whether the sod ever
                    roots, and it happens before a single piece goes down.
                </p>
            </div>
        </div>

        <div class="sod-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background;
                   reveal directions are mixed rather than all fade-up. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="sod-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="sod-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="sod-expert" aria-label="Why Greenville Lawn Masters for sod installation">
    <div class="container">
        <div class="sod-expert__layout">

            <div class="sod-stat-watermark reveal-left" aria-hidden="true">
                1<span>Day to an established lawn</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does the calendar decide whether new sod survives?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    The calendar decides because warm-season sod — bermuda, zoysia, centipede — has to
                    root before it goes dormant. Laid from late spring through summer, it knits into the
                    soil and holds. Laid in late fall it goes dormant before it roots, and winter frost
                    heave lifts it out of the ground. Timing is not a preference; it is survival.
                </p>

                <ul class="sod-diffs">
                    <li class="sod-diff reveal-right reveal-delay-2">
                        <i data-lucide="calendar-check" aria-hidden="true"></i>
                        <div>
                            <strong>Sod timed to the growing season, not the sales calendar</strong>
                            <p>
                                Warm-season sod goes down when it can root before dormancy — so it enters
                                its first Upstate winter established, not loose on top of cold clay.
                            </p>
                        </div>
                    </li>
                    <li class="sod-diff reveal-right reveal-delay-3">
                        <i data-lucide="shovel" aria-hidden="true"></i>
                        <div>
                            <strong>The soil is prepped before the sod arrives</strong>
                            <p>
                                Grading, tilling, and amending come first. Sod set on unprepared Piedmont
                                clay sits on top, dries out, and never crosses its roots into the ground.
                            </p>
                        </div>
                    </li>
                    <li class="sod-diff reveal-right reveal-delay-4">
                        <i data-lucide="users" aria-hidden="true"></i>
                        <div>
                            <strong>One crew from grading to the watering plan</strong>
                            <p>
                                The same people prep the soil, lay and roll the sod, and hand over the
                                watering plan — so nothing is lost between a delivery crew and a follow-up.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Divider — layered wave, filled with the breakdown section's light background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN + INSTALL-DAY PROCESS ══════════ -->
<section class="sod-breakdown" aria-label="What sod installation includes">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What does a <span class="text-accent">Greenville Lawn Masters</span> sod installation include?</h2>
            <p class="answer-block">
                A Greenville Lawn Masters sod installation includes killing and stripping the old lawn,
                grading and correcting drainage, tilling and amending the soil, laying warm-season sod
                in a tight staggered pattern, rolling it for soil contact, and handing over a written
                watering plan. The soil work is the part that decides whether the sod roots.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="sod-includes">
            <?php foreach ($includes as $i => $step): ?>
                <article class="sod-include <?php echo ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up', 'reveal-scale', 'reveal-down'][$i % 6]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="sod-include__icon">
                        <i data-lucide="<?php echo e($step['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does an installation day actually unfold?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            An installation day runs in one visit: the soil is prepped, then the sod — delivered live
            that morning — is laid on it the same day, rolled for contact, and given a deep first soak
            before the crew leaves. Because sod heats and rots on the pallet within a day, prep and
            laying never split across two visits.
        </p>

        <ol class="sod-rail">
            <?php foreach ($process as $i => $step): ?>
                <li class="sod-rail__step reveal-left reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="sod-rail__phase"><?php echo e($step['phase']); ?></span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Divider — diagonal, filled with the countdown section's dark background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-dark)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · SIGNATURE — SOD ESTABLISHMENT COUNTDOWN ══════════ -->
<section class="sod-establish" aria-label="How new sod roots in over the first month">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The First Month</span>
            <h2>How does new sod root in over the first month?</h2>
            <p class="answer-block">
                New sod roots in over roughly four weeks: laid and soaked on day zero, watered deeply
                every day for the first two weeks, mowed for the first time and root-checked around
                weeks two to three, and knitted fully into the soil by week four. Watering starts heavy
                and tapers as the roots drive down.
            </p>
        </div>

        <div class="sod-countdown reveal-up">
            <div class="sod-countdown__track" aria-hidden="true"></div>

            <div class="sod-countdown__grid">
                <?php foreach ($stages as $i => $stage): ?>
                    <?php $dir = ['reveal-up', 'reveal-down', 'reveal-up', 'reveal-down'][$i % 4]; ?>
                    <div class="sod-stage <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                        <span class="sod-stage__dot" aria-hidden="true"></span>
                        <span class="sod-stage__day"><?php echo e($stage['day']); ?></span>
                        <h3><?php echo e($stage['title']); ?></h3>
                        <p><?php echo e($stage['body']); ?></p>
                        <?php /* Droplet meter mirrors the tapering watering intensity: full drops
                                 while roots knit, fading as the lawn moves to deep, infrequent water. */ ?>
                        <div class="sod-stage__water" role="img"
                             aria-label="Watering intensity: <?php echo e((string) $stage['drops']); ?> of 3">
                            <?php for ($d = 1; $d <= 3; $d++): ?>
                                <i data-lucide="droplet"
                                   class="<?php echo $d <= $stage['drops'] ? 'sod-drop--on' : 'sod-drop--off'; ?>"
                                   aria-hidden="true"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="sod-water-bar" aria-hidden="true">
                <span class="sod-water-bar__label sod-water-bar__label--start">Deep daily watering</span>
                <span class="sod-water-bar__label sod-water-bar__label--end">Less often, deeper</span>
            </div>

            <div class="sod-tugtest reveal-scale">
                <i data-lucide="hand" aria-hidden="true"></i>
                <div>
                    <strong>The tug test</strong>
                    <p>
                        At about two to three weeks, gently lift a corner of the sod. If it resists,
                        the roots have knitted into the soil below and the lawn is ready for its first
                        mow. If it lifts freely, it needs more time and more water before you cut it.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ 6 · PROOF ══════════ -->
<?php /* PHOTO GAP — the honest-photography rule for this page.
         $servicePhotos['sod-installation'] has photo_gap => true: not one of the
         six client photographs shows sod being laid, a sod pallet, or bare graded
         soil. Every frame is a finished, established property. So the captions and
         alt text below describe established Mauldin lawns and finished properties —
         NOT a "sod install we completed". Claiming otherwise would be a fabricated
         statement in an accessibility attribute that would also propagate into
         sitemap-images.xml at Phase 5. The .photo-note disclosure, gated on the
         flag, states plainly what these photos are and are not. */ ?>
<section class="sod-proof" aria-label="Greenville Lawn Masters lawns in Mauldin">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Work</span>
            <h2>What does a healthy, established lawn look like around Mauldin?</h2>
            <p class="answer-block">
                Greenville Lawn Masters maintains lawns across Mauldin and Greenville County — the
                kind of dense, even turf a new sod installation is meant to become. The properties
                below are established lawns the crew keeps up, shown here as the finished result sod
                is working toward.
            </p>
        </div>

        <div class="sod-proof__grid">
            <?php
            /* Captions describe WHAT IS IN THE FRAME — established lawns and finished
               properties. None claims to show sod being installed, because none does. */
            $shots = [
                ['key' => 'front_lawn', 'mod' => '',               'label' => 'An established front lawn',  'caption' => 'A dense, established front lawn and driveway at a two-story home in a newer Mauldin neighborhood — the finished look a sod lawn grows into.'],
                ['key' => 'backyard',   'mod' => 'sod-shot--arch',  'label' => 'Turf against bed lines',     'caption' => 'Backyard turf running between mulched planting beds and a wood privacy fence at a Mauldin home Greenville Lawn Masters maintains.'],
                ['key' => 'mulch_bed',  'mod' => 'sod-shot--frame', 'label' => 'A finished property',        'caption' => 'A freshly mulched front bed beside the walk of a Craftsman home in Mauldin, South Carolina.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="sod-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <?php /* Honest disclosure — rendered ONLY while the photo gap exists. Uses the
                 shared .photo-note class already defined in framework.css. Deleting
                 photo_gap in config.php (once real sod photos exist) removes this. */ ?>
        <?php if (!empty($media['photo_gap'])): ?>
            <p class="photo-note">
                <i data-lucide="camera-off" aria-hidden="true"></i>
                <span>
                    These photographs show established Mauldin lawns Greenville Lawn Masters maintains,
                    not a sod installation in progress. Job-site photography of sod work — pallets, soil
                    prep, and freshly laid sod — will replace them as projects are documented.
                </span>
            </p>
        <?php endif; ?>

        <div class="sod-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>

    <!-- Divider — torn edge, filled with the comparison section's light background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,38 L80,44 L160,32 L240,46 L320,34 L420,44 L520,30 L620,42 L720,34 L820,46 L920,32 L1020,44 L1120,36 L1200,42 L1200,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 7 · COMPARISON ══════════ -->
<section class="sod-compare" aria-label="How Greenville Lawn Masters installs sod differently">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates a sod drop from a real sod installation?</h2>
            <p class="answer-block">
                A sod drop lays green squares on whatever soil is there and leaves; a sod installation
                prepares the ground first, times the grass to the season, and stays until the lawn is
                rolled, watered, and handed over with a plan. The difference shows up weeks later, in
                whether the sod rooted or dried out at the seams.
            </p>
        </div>

        <?php /* Left column = common practice in the trade, not a named competitor.
                 Every right-hand row is a process commitment intake recorded or a
                 horticultural practice — never a credential, price, or guarantee. */ ?>
        <div class="sod-compare__table reveal-up reveal-delay-1">
            <div class="sod-compare__head">
                <div>A typical sod drop</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="sod-compare__row">
                    <div data-label="A typical sod drop">
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
</section>

<!-- ══════════ 8 · FAQ ══════════ -->
<section class="sod-faq" aria-label="Sod installation questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">sod installation</span>?</h2>
            <p class="answer-block">
                Mauldin homeowners most often ask when warm-season sod can be laid, how long and how
                often new sod must be watered, which grass suits their light and soil, whether sod or
                seed makes sense on a bare Upstate lot, and how soon a new lawn can be mown. Each is
                answered below.
            </p>
        </div>

        <div class="sod-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="sod-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="sod-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> handle in Mauldin?</h2>
            <p class="answer-block">
                A new sod lawn is one project among many. Greenville Lawn Masters handles seasonal and
                recurring property work across Greenville County — soil testing, seeding and repair,
                mulch and beds — with the same crew and the same 24-hour written estimate.
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

<!-- ══════════ 9 · FINAL CTA ══════════ -->
<section class="sod-cta" aria-label="Request a sod installation estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to trade bare clay for an established lawn?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Warm-season sod roots best laid from late spring through summer, while the grass is growing.
            Book the free walkthrough now and Greenville Lawn Masters will have an itemised estimate to
            you within 24 hours — soil prep, sod, and grading priced line by line.
        </p>
        <div class="sod-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Sod Estimate
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
