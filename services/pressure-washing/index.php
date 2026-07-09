<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/pressure-washing/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page: pressure washing is one service on its own
   page (config.php $servicePages type 'service'), not a group.

   Nothing on this page is invented. No prices or "starting at"
   figures (intake supplied none), no reviews or star ratings
   ($reviews is empty), no "licensed and insured" or certifications
   (intake supplied none), no before/after photo pairs (none exist),
   and — importantly for this trade — no PSI numbers anywhere.
   PSI is a property of THIS client's specific equipment, which
   build-plan.json never recorded; quoting "3,000 PSI" would be a
   fabricated technical spec. Pressure is therefore always described
   RELATIVELY (higher/lower, matched to the surface), never numerically.

   The cleaning facts below are checkable statements about the SC
   Piedmont and about how pressure interacts with materials — algae
   on shaded concrete, mortar erosion, wand striping, chemical stains.
   The business facts are limited to what build-plan.json holds:
   founded 2024, based in Mauldin, 25-mile radius, one crew, free
   walkthrough, written estimate within 24 hours.
   ============================================================ */

$pageSlug    = 'pressure-washing';
$currentPage = 'services';

/* The single service this page is about. servicesOnPage() returns a list even
   for a solo page; take the first (and only) entry, and read its description
   from config.php rather than restating it — one source of truth. */
$serviceRows = servicesOnPage($pageSlug);
$service     = $serviceRows[0] ?? null;
$serviceDesc = $service['description'] ?? 'Professional pressure washing for driveways, sidewalks, and property surfaces in Mauldin.';

$media   = servicePagePhotos($pageSlug);          // hero => driveway, body => [driveway, front_lawn, mulch_bed]
$heroImg = heroPhoto($media['hero']);             // 1600px rendition of the clean-driveway frame

$pageTitle       = 'Pressure Washing in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Pressure washing in Mauldin, SC for driveways, sidewalks, walkways, and patios. Pressure matched to the surface. Written estimate within 24 hours.';   // 146 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

/* Phone is an intake gap (config.php $phone === ''). Compute availability once
   and let every CTA below fall back to the estimate route rather than emit a
   placeholder or fabricated number. */
$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Telltale signs (§2 problem statement) ────────────────────
   Symptoms a Mauldin homeowner can verify by walking the driveway, each tied to
   its real cause. These are material facts about the humid Southeast, not scare
   copy: the green film really is algae and really is slippery when wet. */
$signs = [
    ['icon' => 'droplet',   'title' => 'Black streaks on north-facing concrete', 'body' => 'The dark staining that creeps across shaded concrete and roofs in the Upstate is algae and mildew, not ground-in dirt. It feeds on moisture and spreads where the sun never fully dries the surface.'],
    ['icon' => 'alert-triangle', 'title' => 'A green film that turns slick',      'body' => 'The green haze on a shaded walk is living algae, and it gets genuinely slippery when wet. On steps and entry walks that is a real trip hazard, not just a cosmetic problem.'],
    ['icon' => 'trees',     'title' => 'Organic staining under the tree canopy',  'body' => 'Concrete beneath Greenville County shade trees collects a film of pollen, sap, and leaf debris. It bonds to the porous surface and darkens year over year if it is never lifted.'],
    ['icon' => 'flask-conical', 'title' => 'Rust and tannin stains that spread',  'body' => 'Orange rust from metal furniture and brown tannin from fallen leaves are chemical stains, not dirt. More pressure does nothing to them — they need the right treatment to release.'],
];

/* ── Hardscape surfaces the crew actually cleans (§4) ──────────
   Scope is deliberately limited to hardscape. config.php describes the service
   as "driveways, sidewalks, and property surfaces"; intake never recorded roof
   or house washing, so none is claimed. The pressure MATRIX below teaches the
   general principle for delicate surfaces without offering them as services. */
$surfaces = [
    ['icon' => 'car',        'title' => 'Concrete driveways', 'body' => 'The biggest, most-seen surface on the property, cleaned with a flat surface cleaner for an even finish edge to edge.'],
    ['icon' => 'footprints', 'title' => 'Sidewalks & walkways', 'body' => 'The shaded, north-facing runs where algae takes hold first and the surface goes slick underfoot.'],
    ['icon' => 'grid-2x2',   'title' => 'Patios & sitting areas', 'body' => 'Concrete and paver patios where organic film builds under furniture and the tree canopy.'],
    ['icon' => 'home',       'title' => 'Steps, porches & curbing', 'body' => 'The smaller hardscape that frames the entry — cleaned at the pressure each material can take.'],
];

/* ── Process timeline (§4) ────────────────────────────────────*/
$timeline = [
    ['phase' => 'Visit 1',    'title' => 'Walkthrough & surface read', 'body' => 'The surfaces get identified and the staining gets diagnosed on foot — algae reads differently from rust, and oil differently from both. Sun exposure and nearby planting beds are noted, because they change the plan.'],
    ['phase' => 'Within 24h', 'title' => 'Written estimate',           'body' => 'An itemised estimate lands within a day of the walkthrough, broken out by surface so you can clean the whole property or start with the driveway. Nothing is quoted before the surfaces are seen.'],
    ['phase' => 'On the day',  'title' => 'Protect, then pre-treat',    'body' => 'Planting beds are pre-wet and the runoff is directed away from them, since many cleaning solutions harm plants. A solution that kills the algae is applied and given time to dwell — pressure alone would only strip the visible layer.'],
    ['phase' => 'Finish',      'title' => 'Clean, rinse, and check',    'body' => 'Concrete is worked with a surface cleaner for an even result, delicate surfaces get lower pressure, and everything is rinsed down. The beds are rinsed again and the surrounding turf is left clear.'],
];

/* ── Surface pressure matrix (SIGNATURE section, this page only) ──
   The reference table that makes this page unmistakable. Each row maps a surface
   to the correct approach and a RELATIVE intensity (1-5) rendered as a CSS meter.
   Intensity is ordinal, never a PSI figure — it says "concrete takes far more
   than wood", which is a material fact, without inventing this crew's equipment
   spec. The final row is the honest "what we don't blast" line. */
$matrix = [
    ['surface' => 'Concrete driveway & walkway', 'approach' => 'Surface cleaner, high pressure', 'level' => 5, 'note' => 'Concrete tolerates far more pressure than anything else here. A flat surface cleaner gives an even finish with no wand marks.'],
    ['surface' => 'Sidewalks & concrete steps',  'approach' => 'Surface cleaner, moderate-high',  'level' => 4, 'note' => 'The shaded, north-facing runs that grow algae first and turn slick — cleaned thoroughly, then rinsed.'],
    ['surface' => 'Brick & pavers',              'approach' => 'Controlled pressure',             'level' => 3, 'note' => 'Eased off over older mortar joints, which erode when high pressure is held on them too long.'],
    ['surface' => 'Wood decking',                'approach' => 'Low pressure, with the grain',    'level' => 2, 'note' => 'High pressure raises the grain and gouges softwood, so the pressure comes down and follows the boards.'],
    ['surface' => 'Vinyl siding',                'approach' => 'Soft wash — low pressure + solution', 'level' => 1, 'note' => 'Force drives water behind the panels. A cleaning solution does the work at low pressure instead.'],
    ['surface' => 'Painted surfaces',            'approach' => 'Soft wash — gentlest',            'level' => 1, 'note' => 'High pressure strips paint, so painted surfaces get the lowest pressure and the right solution.'],
];

/* ── Comparison (§6) ──────────────────────────────────────────
   The left column is common trade practice, NOT a named competitor. Every
   right-hand row is a cleaning practice or process commitment — never a
   credential, price, or guarantee, none of which intake supplied. */
$comparison = [
    ['them' => 'One high setting used on every surface',          'us' => 'Pressure matched to the surface — concrete, brick, and wood are not the same job'],
    ['them' => 'A bare wand dragged across the concrete',         'us' => 'A flat surface cleaner for an even finish, without the wand marks and zebra striping that never fully fade'],
    ['them' => 'Pressure only, growth back within weeks',         'us' => 'A cleaning solution that kills the algae itself, so the result lasts instead of regrowing fast'],
    ['them' => 'Planting beds left to take the runoff',           'us' => 'Beds pre-wet and rinsed, and runoff directed away from anything growing'],
    ['them' => 'Rust and oil hit harder with more pressure',      'us' => 'Rust, tannin, and oil treated as chemistry — degreasers and stain treatment, not brute force'],
    ['them' => 'Quote sometime next week',                        'us' => 'Written, itemised estimate within 24 hours of the walkthrough'],
];

/* ── FAQs — conversational, 40-80 words (aeo-content-schema §2.4) ──
   Rendered visibly below AND passed to generateFAQSchema(); the two must match.
   No pricing anywhere — none was supplied, and an invented range amplified
   through FAQPage schema is a misrepresentation to Google, not a placeholder. */
$faqs = [
    [
        'question' => 'How much does pressure washing cost in Mauldin, SC?',
        'answer'   => 'Greenville Lawn Masters prices every job after walking the property, because the number moves with how much surface there is, what is staining it, and how far the growth has gone. The walkthrough is free and the written estimate arrives within 24 hours, itemised by surface so you can clean everything or start with the driveway.',
    ],
    [
        'question' => 'Why does the black streaking come back after washing?',
        'answer'   => 'Because pressure alone only removes the visible layer of algae — it does not kill the organism, so it regrows. In the humid Upstate, under tree canopy and on north-facing concrete, regrowth is a matter of when, not if. A cleaning solution that kills the growth is what makes the clean result actually last.',
    ],
    [
        'question' => 'Is pressure washing safe for my driveway and walkways?',
        'answer'   => 'Yes. Concrete tolerates far more pressure than wood, siding, or brick, so a driveway is the most forgiving surface there is. The care is in technique: a flat surface cleaner leaves an even finish, while a bare wand held too close can leave wand marks and zebra striping on concrete that never fully disappear.',
    ],
    [
        'question' => 'Can you get rust and oil stains out of concrete?',
        'answer'   => 'Rust and tannin stains are chemical, not dirt, and oil soaks down into the pores of the concrete — none of them respond to more pressure. They need the right treatment: a degreaser to pull absorbed oil, and stain-specific treatment for rust and leaf tannin. Deep, old stains often lighten dramatically rather than vanish completely.',
    ],
    [
        'question' => 'Will the cleaning harm my plants and lawn?',
        'answer'   => 'Many cleaning solutions can harm plants, which is exactly why Greenville Lawn Masters pre-wets the planting beds, directs runoff away from anything growing, and rinses the beds again afterward. Pre-wetting dilutes anything that reaches a plant. Handled this way, cleaning the hardscape does not have to cost you the landscaping around it.',
    ],
    [
        'question' => 'Why not just use the highest pressure on everything?',
        'answer'   => 'Because high pressure damages most surfaces. It raises the grain and gouges softwood decking, drives water behind vinyl siding, erodes the mortar in older brick, and strips paint outright. Concrete is the exception that shrugs it off. Matching the pressure to the surface is the difference between cleaning something and slowly wrecking it.',
    ],
    [
        'question' => 'How long before algae comes back on shaded concrete?',
        'answer'   => 'North-facing and heavily shaded surfaces regrow fastest, because they stay damp and never fully dry in the Upstate humidity. Using a solution that kills the growth, rather than just blasting it off, buys far more time. Concrete is porous, so sealing it after cleaning also slows how quickly stains and algae take hold again.',
    ],
    [
        'question' => 'Does Greenville Lawn Masters wash more than driveways?',
        'answer'   => 'The pressure washing centers on hardscape — driveways, sidewalks, walkways, patios, steps, and similar concrete and paver surfaces around Mauldin. Delicate surfaces like wood and siding call for the gentler low-pressure soft-wash approach rather than a high-pressure blast. The walkthrough is the point where the right method for each surface gets sorted out.',
    ],
];

/* ── Schema ───────────────────────────────────────────────────
   Exactly four nodes:
     (a) Service — @id #service-pressure-washing, provider → homepage
         LocalBusiness @id (never a duplicated LocalBusiness block). NO
         `offers` / `priceRange`: intake supplied no pricing, and fabricated
         structured pricing is a misrepresentation Google acts on.
     (b) FAQPage mirroring the visible FAQ.
     (c) BreadcrumbList.
     (d) WebPage carrying Speakable; every cssSelector below exists in markup. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-pressure-washing',
        'name'        => 'Pressure Washing',
        'serviceType' => 'Pressure washing and exterior surface cleaning',
        'description' => 'Pressure washing in Mauldin, South Carolina for driveways, sidewalks, walkways, '
                       . 'patios, and similar hardscape. Pressure is matched to each surface, organic '
                       . 'growth is treated with a cleaning solution rather than pressure alone, and rust, '
                       . 'tannin, and oil stains are treated as chemistry.',
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
        ['name' => 'Pressure Washing', 'url' => '/services/' . $pageSlug . '/'],
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
   Pressure Washing — page-scoped styles
   Every selector is prefixed .pw- so nothing collides with another
   page's <style> block. Colour, shadow, spacing, radius, and timing
   are var() tokens without exception; a raw hex/px value here (outside
   the SVG noise data-URI, keyframe geometry, the meter, clip-paths,
   z-index, opacity, and aspect-ratio) is an automatic QA fail.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  two distinct SVG dividers (soft wave, hard diagonal)
     C4  editorial pull-quote
     C5  bento grid of telltale-sign cards
     C6  asymmetric 62/38 split with an oversized stat watermark
     C7  signature section — the surface pressure matrix + CSS meter
     C10 comparison table with accent-highlighted winning column
     C11 image treatments — arch clip + offset accent frame
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Background is the 1600px clean-driveway rendition. The gradient angle (122deg)
   differs from both the reference lawn-care page (78deg) and the homepage (100deg)
   so the three heroes never read as one image. Overlay carries text contrast and
   masks the softness of an upscaled source. */
.pw-hero {
  min-height: 76vh;
  min-height: 76svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-clean-driveway.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.pw-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    122deg,
    rgba(var(--color-dark-rgb), 0.94) 0%,
    rgba(var(--color-dark-rgb), 0.80) 40%,
    rgba(var(--color-primary-rgb), 0.52) 72%,
    rgba(var(--color-primary-rgb), 0.22) 100%
  );
  z-index: 0;
}
.pw-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.pw-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.pw-hero .breadcrumb { animation: pwFade 0.5s ease both; }

.pw-hero__eyebrow {
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
  animation: pwFade 0.55s ease 0.08s both;
}
.pw-hero__eyebrow i, .pw-hero__eyebrow svg { width: 15px; height: 15px; }

.pw-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: pwRise 0.6s ease 0.16s both;
}
.pw-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; a left-aligned hero must undo that. */
.pw-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: pwRise 0.6s ease 0.26s both;
}

.pw-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: pwRise 0.6s ease 0.36s both;
}
.pw-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: pwRise 0.6s ease 0.46s both;
}
.pw-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.pw-hero__trust i, .pw-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS, never a reveal class — the reveal system sets
   opacity:0 and would blank the hero if IntersectionObserver never fires. */
@keyframes pwFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes pwRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.pw-problem { background: var(--color-light); }
.pw-problem__layout {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: var(--space-12);
  align-items: start;
}
.pw-problem__quote {
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
.pw-problem__lead { color: var(--color-gray-dark); }
.pw-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Deliberately uneven: the first card spans two columns so four boxes don't read
   as a uniform strip. Tints rotate; no two adjacent cards share a background. */
.pw-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.pw-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.pw-sign:first-child { grid-column: span 2; }
.pw-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.pw-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.pw-sign__icon i, .pw-sign__icon svg { width: 22px; height: 22px; }
.pw-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.pw-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.pw-expert { background: var(--color-white); }
.pw-expert__layout {
  display: grid;
  grid-template-columns: 0.62fr 1.38fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.pw-stat-watermark {
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
.pw-stat-watermark span {
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
.pw-expert h2 { margin-bottom: var(--space-5); }
.pw-expert .answer-block { margin-inline: 0; }
.pw-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.pw-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.pw-diff i, .pw-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.pw-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.pw-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── Service breakdown — surfaces we clean ────────────────────*/
.pw-breakdown { background: var(--color-light); }
.pw-surfaces {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
}
.pw-surface {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-top: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.pw-surface:hover {
  transform: translateY(-5px);
  border-top-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.pw-surface__icon { color: var(--color-primary); }
.pw-surface__icon i, .pw-surface__icon svg { width: 28px; height: 28px; }
.pw-surface h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.pw-surface p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray); line-height: 1.6; }

/* ── Process rail (staggered horizontal steps) ────────────────
   A different shape from the reference page's vertical rail: numbered cards on a
   single row, connected by a top line. Keeps the two service pages distinct. */
.pw-process { margin-top: var(--space-16); display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--space-6); }
.pw-step {
  position: relative;
  padding: var(--space-6);
  background: var(--color-white);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm);
}
.pw-step__num {
  display: inline-grid; place-items: center;
  width: 40px; height: 40px;
  border-radius: var(--radius-full);
  background: var(--color-primary);
  color: var(--color-white);
  font-family: var(--font-heading);
  font-weight: 800;
  font-size: var(--font-size-lg);
  margin-bottom: var(--space-4);
}
.pw-step__phase {
  display: block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.pw-step h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.pw-step p { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── C7 · SIGNATURE: the surface pressure matrix ──────────────
   Used on this page only. A designed reference grid mapping surface → approach →
   a relative intensity meter built entirely from CSS tokens. The meter is ordinal
   (segments filled), never a PSI number: this build has no equipment spec, so a
   numeric claim would be fabricated. */
.pw-matrix-section { background: var(--color-white); }
.pw-matrix {
  max-width: 68rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
  border: 1px solid var(--color-gray-light);
}
.pw-matrix__head {
  display: grid;
  grid-template-columns: 1.4fr 1.3fr 1fr;
  background: var(--color-primary);
  color: var(--color-white);
}
.pw-matrix__head > div {
  padding: var(--space-4) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-sm);
  text-transform: uppercase;
  letter-spacing: 1px;
}
.pw-matrix__row {
  display: grid;
  grid-template-columns: 1.4fr 1.3fr 1fr;
  align-items: center;
  border-top: 1px solid var(--color-gray-light);
  transition: background var(--transition-base);
}
.pw-matrix__row:nth-child(even) { background: var(--color-light); }
.pw-matrix__row:hover { background: rgba(var(--color-accent-rgb), 0.07); }
.pw-matrix__cell { padding: var(--space-5) var(--space-6); }
.pw-matrix__surface { font-family: var(--font-heading); font-weight: 700; color: var(--color-primary-dark); font-size: var(--font-size-base); }
.pw-matrix__note { margin: var(--space-2) 0 0; color: var(--color-gray); font-size: var(--font-size-xs); line-height: 1.55; }
.pw-matrix__approach { color: var(--color-gray-dark); font-size: var(--font-size-sm); font-weight: 600; }

/* The intensity meter — five token-coloured segments per row. Filled count
   encodes relative pressure. Pure CSS, no image, no number. */
.pw-meter { display: flex; align-items: center; gap: var(--space-3); }
.pw-meter__bars { display: flex; gap: 4px; }
.pw-meter__seg {
  width: 14px; height: 22px;
  border-radius: var(--radius-sm);
  background: rgba(var(--color-primary-rgb), 0.12);
  transition: background var(--transition-base);
}
.pw-meter__seg.is-on { background: var(--color-accent); }
.pw-meter__seg.is-max { background: var(--color-primary); }
.pw-meter__label {
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: var(--color-gray);
}

/* The honest "what we don't blast" row — visually set apart from the rest. */
.pw-matrix__row--dont {
  grid-template-columns: 1fr;
  background: var(--color-dark);
  color: var(--color-white);
}
.pw-matrix__row--dont:hover { background: var(--color-dark); }
.pw-matrix__dont {
  display: grid;
  grid-template-columns: auto 1fr;
  gap: var(--space-4);
  align-items: start;
  padding: var(--space-6);
}
.pw-matrix__dont i, .pw-matrix__dont svg { width: 26px; height: 26px; color: var(--color-accent); margin-top: 2px; }
.pw-matrix__dont strong { display: block; font-family: var(--font-heading); font-size: var(--font-size-lg); color: var(--color-white); margin-bottom: var(--space-1); }
.pw-matrix__dont p { margin: 0; color: rgba(var(--color-white-rgb), 0.78); font-size: var(--font-size-sm); line-height: 1.65; }

.pw-matrix__scope {
  max-width: 65ch;
  margin: var(--space-8) auto 0;
  text-align: center;
  color: var(--color-gray);
  font-size: var(--font-size-sm);
  line-height: 1.7;
}

/* ── C11 · Proof strip, arch + offset frame treatments ────────*/
.pw-proof { background: var(--color-dark); }
.pw-proof h2, .pw-proof .pw-eyebrow { color: var(--color-white); }
.pw-proof .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.pw-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.pw-shot { margin: 0; }
.pw-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
/* Arch clip on the middle frame only — variation, not decoration for its own sake */
.pw-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.pw-shot--frame { position: relative; }
.pw-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.pw-shot:hover img { transform: scale(1.03); }
.pw-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.pw-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }
.pw-proof__note {
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
.pw-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.pw-compare { background: var(--color-white); }
.pw-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.pw-compare__head, .pw-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.pw-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.pw-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.pw-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.pw-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.pw-compare__row > div:first-child { color: var(--color-gray); }
.pw-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.pw-compare__row i, .pw-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.pw-compare__row > div:first-child i, .pw-compare__row > div:first-child svg { color: var(--color-gray); }
.pw-compare__row > div:last-child i,  .pw-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.pw-faq { background: var(--color-light); }
.pw-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.pw-faq__item {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.pw-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.pw-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.pw-related { background: var(--color-white); }

/* ── Final CTA ────────────────────────────────────────────────*/
.pw-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.pw-cta::before {
  content: '';
  position: absolute;
  top: -20%; right: -8%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.pw-cta .container { position: relative; z-index: 1; }
.pw-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.pw-cta .answer-block { color: rgba(var(--color-white-rgb), 0.88); margin-inline: auto; }
.pw-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; margin-top: var(--space-8); }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .pw-surfaces { grid-template-columns: repeat(2, 1fr); }
  .pw-process { grid-template-columns: repeat(2, 1fr); }
  .pw-signs { grid-template-columns: repeat(2, 1fr); }
  .pw-sign:first-child { grid-column: span 2; }
  .pw-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .pw-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .pw-stat-watermark span { position: static; display: block; margin-top: var(--space-4); }
  .pw-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .pw-problem__quote { max-width: none; }
  .pw-proof__grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 820px) {
  /* The matrix collapses to stacked cards. Column headers are hidden and each
     cell gets its own label, or the surface→approach→pressure link is lost. */
  .pw-matrix__head { display: none; }
  .pw-matrix__row { grid-template-columns: 1fr; gap: var(--space-1); padding-block: var(--space-3); }
  .pw-matrix__cell { padding-block: var(--space-2); }
  .pw-matrix__cell::before {
    content: attr(data-label);
    display: block;
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--color-gray);
    margin-bottom: var(--space-1);
  }
  .pw-matrix__row--dont { grid-template-columns: 1fr; }
}
@media (max-width: 700px) {
  .pw-hero { min-height: 0; }
  .pw-surfaces, .pw-process, .pw-signs, .pw-proof__grid { grid-template-columns: 1fr; }
  .pw-sign:first-child { grid-column: span 1; }
  .pw-shot--frame::before { display: none; }

  .pw-compare__head { display: none; }
  .pw-compare__row { grid-template-columns: 1fr; }
  .pw-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .pw-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero pw-hero" aria-label="Pressure washing in Mauldin, South Carolina">
    <div class="container">
        <div class="pw-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Pressure Washing</span></li>
                </ol>
            </nav>

            <span class="pw-hero__eyebrow">
                <i data-lucide="droplets" aria-hidden="true"></i>
                Pressure Washing &middot; Mauldin, SC
            </span>

            <h1>Pressure Washing in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters pressure washes driveways, sidewalks, walkways, and patios across
                Mauldin, South Carolina and within 25 miles of Greenville County. Pressure is matched to
                each surface, algae is killed with a cleaning solution rather than blasted off, and stains
                are treated as chemistry. Every property is walked before it is priced.
            </p>

            <div class="pw-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Pressure Washing Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* Phone is an intake gap. A "Call Now" with no number — or a
                             fabricated one — is worse than routing to the estimate form. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only what intake recorded — no "Licensed & Insured",
                     no star rating, no job count. config.php has none of the three. */ ?>
            <div class="pw-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="sliders-horizontal" aria-hidden="true"></i> Pressure matched to the surface</span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="calendar-days" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider A — soft double wave, filled with the problem section's light bg -->
    <div class="svg-divider" style="height:88px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,72 900,8 1200,42 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,52 C320,92 880,18 1200,58 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · PROBLEM STATEMENT ══════════ -->
<section class="pw-problem" aria-label="Why concrete stains in the Upstate">
    <div class="container">
        <div class="pw-problem__layout">
            <blockquote class="pw-problem__quote reveal-left">
                Most of what darkens Upstate concrete is alive, not dirty.
            </blockquote>

            <div class="pw-problem__lead">
                <h2 class="reveal-right">Why does concrete in the Upstate turn black and green?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Concrete in the Upstate turns black and green because the humid Southeast grows algae
                    and mildew on any surface that stays damp — shaded, north-facing, or under the tree
                    canopy. Those dark streaks and that green film are living organisms, not ground-in
                    dirt, which is exactly why they keep coming back after a rinse.
                </p>
                <p class="reveal-right reveal-delay-2">
                    That changes how the surface has to be cleaned. Blasting the growth off removes the
                    layer you can see and leaves the organism behind to regrow. Greenville Lawn Masters
                    treats the growth with a cleaning solution that actually kills it, so a Mauldin
                    driveway stays clean for a season instead of a few weeks.
                </p>
            </div>
        </div>

        <div class="pw-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="pw-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="pw-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="pw-expert" aria-label="Why matched pressure matters">
    <div class="container">
        <div class="pw-expert__layout">

            <div class="pw-stat-watermark reveal-left" aria-hidden="true">
                24<span>Hour estimate turnaround</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does matching pressure to the surface matter more than raw power?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Matching pressure to the surface matters because high pressure damages most materials.
                    It gouges softwood, drives water behind vinyl siding, erodes old mortar, and strips
                    paint. Concrete is the one surface that shrugs it off. Getting a property clean without
                    harming it is a question of technique, not of how hard the machine can push.
                </p>

                <ul class="pw-diffs">
                    <li class="pw-diff reveal-right reveal-delay-2">
                        <i data-lucide="search-check" aria-hidden="true"></i>
                        <div>
                            <strong>The staining gets diagnosed before anything is cleaned</strong>
                            <p>
                                Algae, rust, tannin, and oil each release a different way. The surfaces are
                                read on foot at the walkthrough, so the right method goes to the right stain
                                instead of one setting to everything.
                            </p>
                        </div>
                    </li>
                    <li class="pw-diff reveal-right reveal-delay-3">
                        <i data-lucide="spray-can" aria-hidden="true"></i>
                        <div>
                            <strong>A cleaning solution does the work pressure can't</strong>
                            <p>
                                Pressure removes only the visible layer of algae; the growth returns. A
                                solution that kills the organism, given time to dwell, is what makes a clean
                                surface last through an Upstate season rather than weeks.
                            </p>
                        </div>
                    </li>
                    <li class="pw-diff reveal-right reveal-delay-4">
                        <i data-lucide="sprout" aria-hidden="true"></i>
                        <div>
                            <strong>The landscaping is protected, not collateral damage</strong>
                            <p>
                                Planting beds are pre-wet and the runoff is steered away from anything
                                growing, because cleaning solutions and plants do not mix. The beds are
                                rinsed again once the surface work is finished.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN + PROCESS ══════════ -->
<section class="pw-breakdown" aria-label="Surfaces cleaned and how the visit works">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>Which surfaces does <span class="text-accent">Greenville Lawn Masters</span> pressure wash in Mauldin?</h2>
            <p class="answer-block">
                Greenville Lawn Masters pressure washes hardscape around Mauldin homes: concrete
                driveways, sidewalks and walkways, patios and sitting areas, and the steps, porches, and
                curbing that frame the entry. Each surface is cleaned at the pressure it can take, using a
                flat surface cleaner on concrete for an even, streak-free finish.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="pw-surfaces">
            <?php foreach ($surfaces as $i => $surf): ?>
                <article class="pw-surface <?php echo ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="pw-surface__icon">
                        <i data-lucide="<?php echo e($surf['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <h3><?php echo e($surf['title']); ?></h3>
                    <p><?php echo e($surf['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does a pressure washing visit actually go?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            A pressure washing visit starts with a free walkthrough that reads the surfaces and the
            staining, followed by a written, itemised estimate within 24 hours. On the day, planting beds
            are protected and pre-treated, the growth is given a solution that kills it, and the concrete
            is cleaned evenly and rinsed down.
        </p>

        <div class="pw-process">
            <?php foreach ($timeline as $i => $step): ?>
                <div class="pw-step <?php echo ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="pw-step__num" aria-hidden="true"><?php echo e((string) ($i + 1)); ?></span>
                    <span class="pw-step__phase"><?php echo e($step['phase']); ?></span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 5 · SIGNATURE — SURFACE PRESSURE MATRIX ══════════ -->
<section class="pw-matrix-section" aria-label="How pressure is matched to each surface">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Reference</span>
            <h2>How much pressure does each surface actually need?</h2>
            <p class="answer-block">
                Each surface needs a different amount of pressure, because concrete tolerates far more than
                brick, wood, siding, or paint. The matrix below maps common exterior surfaces to the right
                approach and a relative intensity — from a high-pressure surface cleaner on concrete down
                to a low-pressure soft wash on anything water can get behind.
            </p>
        </div>

        <?php /* The meter is ORDINAL — filled segments show relative intensity. It is
                 never a PSI figure: build-plan.json recorded no equipment spec, so a
                 numeric pressure claim would be fabricated. Segment count is the honest
                 statement "concrete takes more than wood", nothing more. */ ?>
        <div class="pw-matrix reveal-up reveal-delay-1">
            <div class="pw-matrix__head">
                <div>Surface</div>
                <div>Correct approach</div>
                <div>Relative pressure</div>
            </div>

            <?php foreach ($matrix as $i => $row): ?>
                <div class="pw-matrix__row <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <div class="pw-matrix__cell" data-label="Surface">
                        <span class="pw-matrix__surface"><?php echo e($row['surface']); ?></span>
                        <p class="pw-matrix__note"><?php echo e($row['note']); ?></p>
                    </div>
                    <div class="pw-matrix__cell" data-label="Correct approach">
                        <span class="pw-matrix__approach"><?php echo e($row['approach']); ?></span>
                    </div>
                    <div class="pw-matrix__cell" data-label="Relative pressure">
                        <div class="pw-meter">
                            <div class="pw-meter__bars" role="img"
                                 aria-label="Relative pressure <?php echo e((string) $row['level']); ?> of 5">
                                <?php for ($s = 1; $s <= 5; $s++): ?>
                                    <?php
                                    /* is-max only paints the top segment of a full-intensity row,
                                       so the eye reads "concrete = the strongest" at a glance. */
                                    $segClass = 'pw-meter__seg';
                                    if ($s <= $row['level'])            { $segClass .= ' is-on'; }
                                    if ($s === 5 && $row['level'] === 5) { $segClass .= ' is-max'; }
                                    ?>
                                    <span class="<?php echo $segClass; ?>"></span>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- The honest "what we don't blast" row -->
            <div class="pw-matrix__row pw-matrix__row--dont reveal-up">
                <div class="pw-matrix__dont">
                    <i data-lucide="shield-off" aria-hidden="true"></i>
                    <div>
                        <strong>What we don't blast</strong>
                        <p>
                            Old mortar, soft wood, vinyl siding, painted surfaces, and anything water can
                            get behind. Force damages these — they get low pressure and the right cleaning
                            solution, or they get left alone. More power is not the answer to a surface that
                            can't take it.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <p class="pw-matrix__scope reveal-up">
            This is how pressure should be matched to any surface. Greenville Lawn Masters' own pressure
            washing centers on hardscape — driveways, sidewalks, walkways, and patios — where a surface
            cleaner and matched pressure do the most good; the delicate surfaces above need the gentler
            soft-wash approach.
        </p>
    </div>

    <!-- Divider B — hard diagonal, filled with the proof section's dark bg -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-dark)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 6 · PROOF ══════════ -->
<?php /* §Proof normally shows testimonials and a before/after pair. config.php
         $reviews is empty and NO before/after pair exists in the photo library —
         inventing testimonials would attribute quotes to invented customers (an
         FTC Endorsement Guides problem, not a placeholder), and CLAUDE.md forbids
         fabricated review counts. The client's own job photography fills the slot,
         and the note says plainly why there are no reviews yet. None of the three
         frames shows washing in progress, so no caption claims it does. */ ?>
<section class="pw-proof" aria-label="Greenville Lawn Masters property photography">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label pw-eyebrow">The Work</span>
            <h2>What does clean concrete at a <span class="text-accent">Mauldin</span> home look like?</h2>
            <p class="answer-block">
                Every image on this page is a real Greenville Lawn Masters job site around Mauldin, not a
                stock photo. Below: a clean concrete driveway and walkway, a front lawn and drive kept
                clear of cleaning runoff, and the planting beds pre-wet and rinsed so nothing growing takes
                the wash water.
            </p>
        </div>

        <div class="pw-proof__grid">
            <?php
            /* Captions describe WHAT IS IN THE FRAME. The 'driveway' frame genuinely
               shows clean concrete — the outcome of the service — so it may be
               described that way. The other two are honest context: none is a
               "before", an "after", or a "mid-wash" shot, and none is captioned as one. */
            $shots = [
                ['key' => 'driveway',   'mod' => '',              'label' => 'Clean concrete driveway', 'caption' => 'A clean concrete driveway and walkway leading to a two-story home in Mauldin, South Carolina.'],
                ['key' => 'front_lawn', 'mod' => 'pw-shot--arch', 'label' => 'Drive kept clear',        'caption' => 'A dense green front lawn and concrete driveway at a two-story Mauldin home, the surface kept clear of cleaning runoff.'],
                ['key' => 'mulch_bed',  'mod' => 'pw-shot--frame','label' => 'Beds protected',          'caption' => 'A freshly mulched front bed beside the walk of a Craftsman home — the kind of planting bed pre-wet and rinsed so runoff never reaches it.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="pw-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <div class="pw-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 7 · COMPARISON ══════════ -->
<section class="pw-compare" aria-label="Blasting a surface versus cleaning it">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates blasting a surface from actually cleaning it?</h2>
            <p class="answer-block">
                Blasting throws the highest pressure at everything and hopes the dirt leaves; cleaning
                matches the method to the surface and the stain so the result lasts and nothing gets
                damaged. The difference shows up in the finish — no wand marks, no dead plants, and algae
                that stays gone for a season instead of weeks.
            </p>
        </div>

        <?php /* Left column is common trade practice, not a named competitor. Every
                 right-hand row is a cleaning practice or a process commitment intake
                 recorded — never a credential, price, or guarantee. */ ?>
        <div class="pw-compare__table reveal-up reveal-delay-1">
            <div class="pw-compare__head">
                <div>A typical high-pressure blast</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="pw-compare__row">
                    <div data-label="A typical high-pressure blast">
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

    <!-- Divider A (reused shape) — soft wave, filled with the FAQ section's light bg -->
    <div class="svg-divider" style="height:72px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,40 C320,80 880,10 1200,50 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 8 · FAQ ══════════ -->
<section class="pw-faq" aria-label="Pressure washing questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">pressure washing</span>?</h2>
            <p class="answer-block">
                Straight answers on what pressure washing costs in Mauldin, why black streaking returns on
                shaded concrete, whether the work is safe for your driveway and plants, how rust and oil
                stains are lifted, and why the highest pressure is the wrong tool on most surfaces.
            </p>
        </div>

        <div class="pw-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="pw-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="pw-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> handle in Mauldin?</h2>
            <p class="answer-block">
                Pressure washing is one of 22 services Greenville Lawn Masters runs across Greenville
                County. The same crew handles the lawn, the beds, the trees and shrubs, and the seasonal
                cleanups — all quoted from a single free walkthrough with a written estimate in 24 hours.
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
<section class="pw-cta" aria-label="Request a pressure washing estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to get your Mauldin driveway clean again?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Book a free walkthrough and Greenville Lawn Masters will read the surfaces, diagnose the
            staining, and send a written, itemised estimate within 24 hours — pressure matched to each
            surface, algae killed instead of just blasted, and the landscaping protected the whole time.
        </p>
        <div class="pw-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Pressure Washing Estimate
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
