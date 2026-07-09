<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/dethatching/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page (one of the 22 services, its own page).

   Nothing here is invented. No price ranges, no review quotes, no
   star ratings, no "licensed and insured", no jobs-completed count,
   no certifications, no equipment brand names — intake supplied none
   of them (see config.php $missingIntake, $reviews). The agronomy is
   fact about the SC Piedmont / transition zone and is checkable; the
   business claims are limited to what build-plan.json recorded:
   founded 2024, 25-mile radius across Greenville County, written
   estimate within 24 hours, one crew, debris hauled off, 22 services.

   THE HONEST ANGLE OF THIS PAGE (a real differentiator, not spin):
   dethatching is over-sold in this trade. Many Upstate lawns do not
   need it, and tall fescue — a bunch grass — rarely does. Intake's
   process is "walk the property before pricing it," so the whole page
   is built to MEASURE the thatch first and to say plainly that if the
   lawn does not need dethatching, it is not sold, and that core
   aeration is sometimes the right call instead. Overselling a service
   the customer does not need is the trust liability we are avoiding.

   PHOTO GAP (config.php $servicePhotos['dethatching']['photo_gap']):
   NOT ONE photograph in the library shows thatch, a dethatcher, a power
   rake, a verticutter, or a soil/thatch core. Every assigned frame is a
   mowing shot or a finished property. So captions here describe ONLY
   what is in the frame, no caption implies a photo shows dethatching,
   and the proof section carries an honest .photo-note disclosure
   (CLAUDE.md CLIENT PHOTO GATE). A caption claiming an unrelated lawn
   photo "shows dethatching" would be a fabricated claim in an accessible
   attribute — worse than a visibly missing photo.
   ============================================================ */

$pageSlug    = 'dethatching';
$currentPage = 'services';

/* servicesOnPage() returns every service whose 'page' === the slug. For a solo
   page that is exactly one row; grab it rather than re-typing the copy. */
$servicesHere = servicesOnPage($pageSlug);
$service      = $servicesHere[0];            // config.php canonical name + description

$media   = servicePagePhotos($pageSlug);     // hero=mowing, body=[mowing,front_lawn,backyard], photo_gap=true
$heroImg = heroPhoto($media['hero']);        // /assets/images/hero-mauldin-lawn-mowing.jpg

$pageTitle       = 'Dethatching in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Dethatching in Mauldin, SC. The thatch layer is measured before anything runs, then verticut and hauled off if needed. Written estimate in 24 hours.';   // 148 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

/* $phone is empty in config.php. Compute a boolean and render the tel: button
   only when it is true — never a placeholder or fabricated number. */
$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

$totalServices = count($services);           // 22, read from config — never hardcoded

/* ── Telltale signs (section 2) ──────────────────────────────
   Symptoms a homeowner can verify on foot, each tied to what excess thatch
   actually does. These are real thatch signatures, not urgency theatre. */
$signs = [
    ['icon' => 'footprints', 'title' => 'The lawn feels spongy underfoot', 'body' => 'A springy, mattress-like give when you walk across the turf is the classic sign. You are feeling a layer of dead stems and roots between the green blades and the soil, not the soil itself.'],
    ['icon' => 'droplets',   'title' => 'Water beads and runs off',       'body' => 'A thick thatch layer sheds water instead of letting it soak in. Irrigation and rain sheet across the surface toward the driveway while the roots below stay dry and drought-prone.'],
    ['icon' => 'scissors',   'title' => 'The mower scalps easily',        'body' => 'When the deck rides up on the springy layer it cuts into the crowns and leaves pale, shaved patches. Scalping on flat ground is often a thatch problem, not a mowing mistake.'],
    ['icon' => 'sprout',     'title' => 'Roots grow in the thatch',       'body' => 'Grass that roots into the spongy layer instead of the soil loses its anchor and its water reserve. That lawn browns fast in an Upstate July and recovers slowly.'],
];

/* ── What a dethatch actually involves (section 4) ───────────*/
$steps = [
    ['icon' => 'ruler',        'phase' => 'First',     'title' => 'Measure the layer',        'body' => 'A small wedge is cut or a core pulled to read the brown spongy band between soil and green growth. Under about a half inch is beneficial and gets left alone; the machine only comes out above that.'],
    ['icon' => 'circle-check', 'phase' => 'Then',      'title' => 'Confirm it is worth doing','body' => 'Grass type is identified zone by zone. Tall fescue is a bunch grass and rarely builds thatch, so a fescue lawn is usually left alone. Bermuda and zoysia are the thatch builders and get the closer look.'],
    ['icon' => 'settings',     'phase' => 'The work',  'title' => 'Verticut at the right depth','body' => 'A verticutter or power rake is set to the depth of the thatch and run only when the lawn is in active growth, so it can knit back together. Dethatching a dormant or heat-stressed lawn is genuinely damaging, so timing is not negotiable.'],
    ['icon' => 'truck',        'phase' => 'After',     'title' => 'Collect, haul, recover',    'body' => 'The torn material is raked up and hauled off the property the same visit. Because dethatching thins a lawn on purpose, it is often paired with overseeding or a short recovery window, and a light topdressing can feed the microbes that keep thatch down.'],
];

/* ── Expert positioning differentiators (section 3) ──────────
   The not-oversell angle, stated plainly. Each is TRUE to the intake process. */
$diffs = [
    ['icon' => 'ruler',       'title' => 'The layer is measured before anything is sold', 'body' => 'Greenville Lawn Masters cuts a wedge and reads the thatch depth on foot. A lawn under roughly a half inch is cushioned, not clogged, and is left alone rather than raked for the sake of raking.'],
    ['icon' => 'leaf',        'title' => 'Fescue lawns are usually left alone',           'body' => 'Tall fescue is a bunch grass that almost never builds problem thatch. If your lawn is fescue, the honest answer is often that no dethatching is needed at all — and that is what you will hear.'],
    ['icon' => 'shovel',      'title' => 'Sometimes the answer is aeration, not raking',  'body' => 'Core aeration and dethatching are not the same job. For moderate thatch over compacted Piedmont clay, pulling plugs is frequently the better first move, and it is the one that gets recommended.'],
];

/* ── Comparison (section 6) ──────────────────────────────────
   Left = common practice in the trade, NOT a named competitor. Every right-hand
   row is a process commitment intake recorded or an agronomic practice — never a
   credential. Note the whole table leans on "measure first, don't oversell." */
$comparison = [
    ['them' => 'Dethatches every lawn on the spring schedule, thatch or not',   'us' => 'Measures the thatch layer first and removes it only when it runs past about a half inch'],
    ['them' => 'Runs the machine on whatever lawn is booked, fescue included',   'us' => 'Leaves tall fescue alone — a bunch grass that rarely builds problem thatch'],
    ['them' => 'Rakes a dormant or heat-stressed lawn in early spring',          'us' => 'Waits for full green-up and active growth so the lawn can recover from the tearing'],
    ['them' => 'Leaves the pulled thatch lying on the lawn',                     'us' => 'Collects the torn debris and hauls it off the property the same visit'],
    ['them' => 'Treats dethatching and aeration as the same job',               'us' => 'Recommends core aeration instead when compaction, not thatch, is the real problem'],
    ['them' => 'Quotes over the phone from the lot size',                        'us' => 'Walks the property first, then sends a written, itemised estimate within 24 hours'],
];

/* ── FAQs — conversational, 40-80 words (aeo-content-schema §2.4) ──
   Rendered visibly below AND passed to generateFAQSchema(); schema that does not
   mirror visible copy is a guidelines violation. No pricing (none supplied). Full
   company name opens most answers per the chunk-level retrieval rule. */
$faqs = [
    [
        'question' => 'What is lawn thatch, exactly?',
        'answer'   => 'Thatch is the layer of dead and living stems, crowns, stolons, and roots that '
                    . 'builds up between the green blades and the soil surface. It is not grass clippings '
                    . '— clippings are mostly water and break down quickly. A thin layer under about a '
                    . 'half inch is beneficial: it cushions the turf, insulates the crowns, and holds '
                    . 'moisture. Thatch only becomes a problem when it gets thicker than that.',
    ],
    [
        'question' => 'How do I know if my lawn has too much thatch?',
        'answer'   => 'Walk it first. Turf with excess thatch feels spongy underfoot, sheds water so '
                    . 'irrigation runs off, and scalps easily because the mower rides up on the springy '
                    . 'layer. To confirm, cut a small wedge and look at the brown layer between soil and '
                    . 'green growth: under a half inch is fine, over three-quarters of an inch is serious '
                    . 'and worth removing.',
    ],
    [
        'question' => 'When is the best time to dethatch a lawn in Mauldin, SC?',
        'answer'   => 'Timing follows the grass and must hit active growth so the lawn can recover. '
                    . 'Warm-season lawns — bermuda and zoysia, the thatch builders in the Upstate — are '
                    . 'dethatched in late spring through early summer, after full green-up. Greenville '
                    . 'Lawn Masters will not rake a dormant or heat-stressed lawn: dethatching at the '
                    . 'wrong time is genuinely damaging and sets the turf back instead of helping it.',
    ],
    [
        'question' => 'Does my fescue lawn need dethatching?',
        'answer'   => 'Usually not. Tall fescue is a bunch grass — it grows in clumps rather than '
                    . 'spreading by aggressive stolons and rhizomes, so it rarely produces significant '
                    . 'thatch. Bermuda and zoysia are the grasses that build it fastest in Greenville '
                    . 'County. If your lawn is mostly fescue, Greenville Lawn Masters will usually tell '
                    . 'you it does not need dethatching rather than sell you a service it does not need.',
    ],
    [
        'question' => 'Is dethatching the same as core aeration?',
        'answer'   => 'No. Aeration pulls small plugs of soil to relieve compaction and, over time, helps '
                    . 'organic matter break down. Dethatching mechanically tears the thatch layer out with '
                    . 'a verticutter or power rake. For moderate thatch over the compacted Piedmont clay '
                    . 'around Mauldin, aeration is often the better first move — which is why Greenville '
                    . 'Lawn Masters measures before recommending either one.',
    ],
    [
        'question' => 'Will dethatching hurt my lawn?',
        'answer'   => 'Done at the wrong time, yes. Dethatching is aggressive by design — it tears out '
                    . 'material and thins the lawn temporarily. Run on a dormant, drought-stressed, or '
                    . 'fescue lawn it does real harm. Done during active growth on a warm-season lawn that '
                    . 'genuinely has excess thatch, the turf knits back stronger, and it is often paired '
                    . 'with overseeding or a short recovery period.',
    ],
    [
        'question' => 'Do grass clippings cause thatch?',
        'answer'   => 'No — that is a common myth. Grass clippings are mostly water and decompose quickly, '
                    . 'returning nutrients to the soil, so mulching them does not build thatch. Thatch '
                    . 'comes from tougher, slow-to-rot stems, crowns, and roots, and it accumulates '
                    . 'fastest under over-fertilization, over-watering, compaction, and low soil pH that '
                    . 'suppresses the microbes which break organic matter down.',
    ],
];

/* ── Schema — exactly 4 nodes (per build prompt) ─────────────
   (a) Service (@id #service-dethatching), provider → homepage LocalBusiness @id.
       NO offers / priceRange: no pricing supplied, and fabricated structured
       pricing is a misrepresentation Google acts on.
   (b) FAQPage mirroring the visible FAQ.
   (c) BreadcrumbList: Home › Services › Dethatching.
   (d) WebPage with Speakable — every cssSelector exists in the markup below. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-dethatching',
        'name'        => 'Dethatching',
        'serviceType' => 'Lawn dethatching and thatch removal',
        'description' => 'Lawn dethatching in Mauldin, South Carolina. Greenville Lawn Masters measures '
                       . 'the thatch layer first and removes it — by verticutting or power raking at the '
                       . 'right depth during active growth — only when a warm-season lawn genuinely has '
                       . 'excess thatch. Debris is collected and hauled off. Fescue lawns, which rarely '
                       . 'build thatch, are typically left alone.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',        'url' => '/'],
        ['name' => 'Services',    'url' => '/services/'],
        ['name' => 'Dethatching', 'url' => '/services/' . $pageSlug . '/'],
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
   Dethatching — page-scoped styles
   Every rule prefixed .dt- so nothing collides with another page's <style>.
   Colour, shadow, spacing, radius, and timing are var() tokens without
   exception — a raw literal here is an automatic QA fail. Geometric px are
   used only inside the thatch-depth ruler diagram and keyframes, which the
   build prompt explicitly permits.

   Techniques (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after (unique angle)
     C3  two distinct SVG dividers (torn edge, double wave, diagonal)
     C4  editorial pull-quote
     C5  bento grid of telltale signs, deliberately uneven
     C6  asymmetric 60/40 split with oversized stat watermark
     C7  SIGNATURE — the thatch-depth ruler / turf cross-section (this page only)
     C10 comparison table with accent-highlighted commitment column
     C11 photo treatments — arch clip + offset frame
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Background is the mowing rendition (the only assigned hero frame). The
   gradient angle is 68deg — deliberately not the reference page's 78deg nor
   the homepage's 100deg, so the two heroes do not read as one template. The
   overlay also carries the softness of a 370px source upscaled to 1600px. */
.dt-hero {
  min-height: 76vh;
  min-height: 76svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-lawn-mowing.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.dt-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    68deg,
    rgba(var(--color-dark-rgb), 0.94) 0%,
    rgba(var(--color-dark-rgb), 0.80) 40%,
    rgba(var(--color-primary-rgb), 0.52) 72%,
    rgba(var(--color-primary-rgb), 0.26) 100%
  );
  z-index: 0;
}
.dt-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.dt-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.dt-hero .breadcrumb { animation: dtFade 0.5s ease both; }

.dt-hero__eyebrow {
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
  animation: dtFade 0.55s ease 0.08s both;
}
.dt-hero__eyebrow i, .dt-hero__eyebrow svg { width: 15px; height: 15px; }

.dt-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: dtRise 0.6s ease 0.16s both;
}
.dt-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres globally; in a left-aligned hero it must not. */
.dt-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: dtRise 0.6s ease 0.26s both;
}

.dt-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: dtRise 0.6s ease 0.36s both;
}
.dt-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: dtRise 0.6s ease 0.46s both;
}
.dt-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.dt-hero__trust i, .dt-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS, never a reveal class — the reveal system
   sets opacity:0 and would blank the hero if IntersectionObserver never fires. */
@keyframes dtFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes dtRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.dt-problem { background: var(--color-light); }
.dt-problem__layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: var(--space-12);
  align-items: start;
}
.dt-problem__quote {
  max-width: 20ch;
  font-family: var(--font-heading);
  font-style: italic;
  font-weight: 600;
  font-size: clamp(1.5rem, 3vw, 2.4rem);
  line-height: 1.22;
  color: var(--color-primary-dark);
  border-left: 4px solid var(--color-accent);
  padding-left: var(--space-6);
}
.dt-problem__lead { color: var(--color-gray-dark); }
.dt-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Deliberately uneven: the first card spans two columns so the row does not
   read as four identical boxes. Tints rotate; no two adjacent cards match. */
.dt-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.dt-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.dt-sign:first-child { grid-column: span 2; }
.dt-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.dt-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.dt-sign__icon i, .dt-sign__icon svg { width: 22px; height: 22px; }
.dt-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.dt-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C7 · SIGNATURE: the thatch-depth ruler ───────────────────
   A CSS-drawn vertical turf cross-section — green blades on top, the brown
   thatch layer in the middle, soil below — with a calibrated ruler down one
   side marked in quarter-inches, colour-banded from beneficial (under 1/2")
   through monitor to dethatch (over 3/4"). Built entirely from brand tokens;
   the fixed px are geometry inside the diagram, which the build prompt allows.
   This section appears on no other page in the build. */
.dt-gauge { background: var(--color-white); }
.dt-gauge__layout {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: var(--space-16);
  align-items: center;
  margin-top: var(--space-12);
}

/* The cross-section itself. 220px thatch zone = four 55px quarter-inch steps,
   so the ruler scale is honest and even. */
.dt-profile {
  position: relative;
  padding-left: 64px;                 /* room for the ruler gutter */
  max-width: 420px;
}
.dt-profile__stack {
  position: relative;
  border-radius: var(--radius-md);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}

/* Green blades — a repeating slice pattern reads as turf without an image. */
.dt-profile__blades {
  height: 96px;
  background:
    repeating-linear-gradient(
      96deg,
      var(--color-accent) 0 6px,
      var(--color-primary) 6px 12px
    );
  border-bottom: 2px solid rgba(var(--color-dark-rgb), 0.25);
}

/* The measured thatch zone. Bands stack top→bottom: dethatch (top, nearest the
   blades = thickest thatch) → monitor → beneficial (bottom, at the soil line). */
.dt-thatch { position: relative; }
.dt-band {
  height: 55px;                        /* one quarter-inch of the ruler */
  display: flex;
  align-items: center;
  padding-left: var(--space-4);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: var(--color-white);
}
/* Bands coloured with framework tokens — danger/warning/primary are all in :root. */
.dt-band--dethatch { background: var(--color-danger); }
.dt-band--monitor  { background: var(--color-warning); color: var(--color-dark); }
.dt-band--good     { height: 110px; background: var(--color-primary); }
.dt-band--good span { display: block; }

/* Soil base. */
.dt-profile__soil {
  height: 70px;
  background: linear-gradient(
    180deg,
    var(--color-secondary) 0%,
    var(--color-dark) 100%
  );
  display: flex;
  align-items: center;
  padding-left: var(--space-4);
  color: rgba(var(--color-white-rgb), 0.7);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* The ruler gutter — ticks aligned to the band boundaries. Positioned from the
   soil line (0") up to 1"+ at the top of the thatch zone. */
.dt-ruler {
  position: absolute;
  left: 0;
  top: 96px;                           /* starts at the bottom edge of the blades */
  width: 56px;
  height: 220px;                       /* the four quarter-inch steps */
  border-right: 2px solid var(--color-gray);
}
.dt-tick {
  position: absolute;
  right: 0;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: var(--space-2);
  transform: translateY(50%);
  font-family: var(--font-body);
  font-size: var(--font-size-xs);
  font-weight: 700;
  color: var(--color-gray-dark);
}
.dt-tick::after {
  content: '';
  width: 10px;
  height: 2px;
  background: var(--color-gray);
}
.dt-tick--0    { bottom: 0; }
.dt-tick--q1   { bottom: 55px; }
.dt-tick--half { bottom: 110px; color: var(--color-primary-dark); }
.dt-tick--q3   { bottom: 165px; color: var(--color-warning); }
.dt-tick--1    { bottom: 220px; color: var(--color-danger); }
.dt-tick strong { font-family: var(--font-heading); }

/* Legend + the "measure it yourself" callout beside the diagram. */
.dt-gauge__read h2 { margin-bottom: var(--space-5); }
.dt-gauge__read .answer-block { margin-inline: 0; }
.dt-legend { list-style: none; margin: var(--space-8) 0 0; display: grid; gap: var(--space-4); }
.dt-legend li {
  display: grid;
  grid-template-columns: 18px 1fr;
  gap: var(--space-3);
  align-items: start;
  font-size: var(--font-size-sm);
  color: var(--color-gray-dark);
  line-height: 1.6;
}
.dt-legend .dt-swatch {
  width: 18px; height: 18px;
  border-radius: var(--radius-sm);
  margin-top: 3px;
}
.dt-swatch--good     { background: var(--color-primary); }
.dt-swatch--monitor  { background: var(--color-warning); }
.dt-swatch--dethatch { background: var(--color-danger); }
.dt-legend strong { color: var(--color-primary-dark); }

.dt-measure {
  margin-top: var(--space-8);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-light);
  border: 1px dashed rgba(var(--color-primary-rgb), 0.35);
}
.dt-measure h3 {
  display: flex; align-items: center; gap: var(--space-2);
  font-size: var(--font-size-lg);
  color: var(--color-primary-dark);
  margin-bottom: var(--space-3);
}
.dt-measure h3 i, .dt-measure h3 svg { width: 20px; height: 20px; color: var(--color-accent); }
.dt-measure p { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.7; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.dt-expert { background: var(--color-light); }
.dt-expert__layout {
  display: grid;
  grid-template-columns: 0.62fr 1.38fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.dt-stat-watermark {
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
.dt-stat-watermark span {
  position: absolute;
  left: 0.05em;
  bottom: -1.7em;
  font-size: var(--font-size-sm);
  font-family: var(--font-body);
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  opacity: 1;
  color: var(--color-primary-dark);
  white-space: nowrap;
}
.dt-expert h2 { margin-bottom: var(--space-5); }
.dt-expert .answer-block { margin-inline: 0; }
.dt-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.dt-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.dt-diff i, .dt-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.dt-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.dt-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── Service breakdown / process rail ─────────────────────────*/
.dt-process { background: var(--color-white); }
.dt-rail { position: relative; margin-top: var(--space-16); padding-left: var(--space-12); }
.dt-rail::before {
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
.dt-rail__step { position: relative; padding-bottom: var(--space-10); }
.dt-rail__step:last-child { padding-bottom: 0; }
.dt-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 6px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-white);
}
.dt-rail__phase {
  display: inline-flex; align-items: center; gap: var(--space-2);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.dt-rail__phase i, .dt-rail__phase svg { width: 15px; height: 15px; }
.dt-rail__step h3 { font-size: var(--font-size-xl); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.dt-rail__step p { margin: 0; max-width: 62ch; color: var(--color-gray-dark); line-height: 1.7; }

/* ── C11 · Proof strip, arch + offset frame treatments ────────*/
.dt-proof { background: var(--color-dark); }
.dt-proof h2, .dt-proof .dt-eyebrow { color: var(--color-white); }
.dt-proof .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.dt-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.dt-shot { margin: 0; }
.dt-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
.dt-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.dt-shot--frame { position: relative; }
.dt-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.dt-shot:hover img { transform: scale(1.03); }
.dt-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.dt-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }

/* The proof section carries the photo-gap disclosure (.photo-note is a shared
   framework class) and the no-reviews-yet note. On a dark background the shared
   .photo-note grey reads fine, but nudge it lighter for contrast. */
.dt-proof .photo-note {
  color: rgba(var(--color-white-rgb), 0.62);
  border-left-color: rgba(var(--color-white-rgb), 0.25);
}
.dt-proof__note {
  max-width: 65ch;
  margin: var(--space-8) auto 0;
  padding: var(--space-5) var(--space-6);
  border-radius: var(--radius-md);
  background: rgba(var(--color-white-rgb), 0.05);
  color: rgba(var(--color-white-rgb), 0.6);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  text-align: center;
}
.dt-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.dt-compare { background: var(--color-light); }
.dt-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.dt-compare__head, .dt-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.dt-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.dt-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.dt-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.dt-compare__row > div {
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
.dt-compare__row > div:first-child { color: var(--color-gray); }
.dt-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.dt-compare__row i, .dt-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.dt-compare__row > div:first-child i, .dt-compare__row > div:first-child svg { color: var(--color-gray); }
.dt-compare__row > div:last-child i,  .dt-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.dt-faq { background: var(--color-white); }
.dt-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.dt-faq__item {
  background: var(--color-light);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.dt-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.dt-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.dt-related { background: var(--color-light); }

/* ── Final CTA ────────────────────────────────────────────────*/
.dt-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.dt-cta::before {
  content: '';
  position: absolute;
  top: -20%; right: -8%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.dt-cta .container { position: relative; z-index: 1; }
.dt-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.dt-cta .answer-block { color: rgba(var(--color-white-rgb), 0.88); margin-inline: auto; }
.dt-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; margin-top: var(--space-8); }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .dt-signs { grid-template-columns: repeat(2, 1fr); }
  .dt-sign:first-child { grid-column: span 2; }
  .dt-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .dt-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .dt-stat-watermark span { position: static; display: block; margin-top: var(--space-6); }
  .dt-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .dt-problem__quote { max-width: none; }
  .dt-gauge__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .dt-profile { margin-inline: auto; }
  .dt-proof__grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 700px) {
  .dt-hero { min-height: 0; }
  .dt-signs, .dt-proof__grid { grid-template-columns: 1fr; }
  .dt-sign:first-child { grid-column: span 1; }
  .dt-shot--frame::before { display: none; }

  /* Comparison grid collapses to stacked pairs; each cell keeps a label so the
     them/us contrast is not lost when the column headers are hidden. */
  .dt-compare__head { display: none; }
  .dt-compare__row { grid-template-columns: 1fr; }
  .dt-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .dt-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero dt-hero" aria-label="Dethatching in Mauldin, South Carolina">
    <div class="container">
        <div class="dt-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Dethatching</span></li>
                </ol>
            </nav>

            <span class="dt-hero__eyebrow">
                <i data-lucide="layers" aria-hidden="true"></i>
                Dethatching &middot; Mauldin, SC
            </span>

            <h1>Dethatching in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters measures the thatch layer before touching it. If your Mauldin
                lawn genuinely has too much — over about a half inch of dead stems and roots choking the
                soil — the crew removes it at the right depth and hauls the debris off. No lawn is
                dethatched just because it is spring.
            </p>

            <div class="dt-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Lawn Walkthrough
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

            <?php /* Trust row carries only what intake recorded — no "Licensed & Insured",
                     no star rating, no job count. config.php has none of the three. */ ?>
            <div class="dt-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Based in <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></span>
                <span><i data-lucide="ruler" aria-hidden="true"></i> Thatch measured before it is removed</span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="git-fork" aria-hidden="true"></i> Serving <?php echo e((string) $targetRadius); ?> miles across Greenville County</span>
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
<section class="dt-problem" aria-label="Signs a Mauldin lawn has too much thatch">
    <div class="container">
        <div class="dt-problem__layout">
            <blockquote class="dt-problem__quote reveal-left">
                A spongy lawn is not soft grass — it is a mat of dead stems the water can't get through.
            </blockquote>

            <div class="dt-problem__lead">
                <h2 class="reveal-right">How can you tell a Mauldin lawn has a thatch problem?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    A Mauldin lawn has a thatch problem when it feels spongy underfoot, sheds water so
                    irrigation runs off toward the street, scalps easily under the mower, and browns fast
                    in summer heat. Those four signs point to a mat of dead stems and roots — thatch —
                    thick enough to hold water and roots away from the soil.
                </p>
                <p class="reveal-right reveal-delay-2">
                    A thin thatch layer, under about a half inch, is actually good for the lawn: it
                    cushions the crowns, insulates against Upstate heat, and conserves moisture. The
                    problem is the extra — the part above that half inch — and the only way to know how
                    much you have is to measure it, which is where every Greenville Lawn Masters visit
                    starts.
                </p>
            </div>
        </div>

        <div class="dt-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="dt-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="dt-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · SIGNATURE — THATCH DEPTH RULER ══════════ -->
<section class="dt-gauge" aria-label="How much thatch is too much">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Half-Inch Rule</span>
            <h2>How much thatch is too much before it needs <span class="text-accent">removing</span>?</h2>
            <p class="answer-block">
                Thatch under about a half inch is beneficial and stays. Between a half and three-quarters
                of an inch is a monitor zone. Over three-quarters of an inch is serious — it holds water
                off the soil, harbours pests, and warrants removal. Greenville Lawn Masters reads that
                depth on every lawn before recommending anything.
            </p>
        </div>

        <div class="dt-gauge__layout">
            <!-- The CSS cross-section. Purely decorative to a screen reader; the
                 legend and callout beside it carry the same information in text. -->
            <div class="dt-profile reveal-left" role="img"
                 aria-label="Turf cross-section: green blades on top, a thatch layer banded from beneficial under a half inch, to a monitor zone, to a dethatch zone over three-quarters of an inch, above the soil.">
                <div class="dt-profile__stack" aria-hidden="true">
                    <div class="dt-profile__blades"></div>
                    <div class="dt-thatch">
                        <div class="dt-band dt-band--dethatch">Dethatch &mdash; over 3/4&Prime;</div>
                        <div class="dt-band dt-band--monitor">Monitor &mdash; 1/2 to 3/4&Prime;</div>
                        <div class="dt-band dt-band--good"><span>Beneficial &mdash; under 1/2&Prime;</span></div>
                    </div>
                    <div class="dt-profile__soil">Soil</div>
                </div>
                <div class="dt-ruler" aria-hidden="true">
                    <span class="dt-tick dt-tick--0"><strong>0</strong></span>
                    <span class="dt-tick dt-tick--q1"><strong>1/4&Prime;</strong></span>
                    <span class="dt-tick dt-tick--half"><strong>1/2&Prime;</strong></span>
                    <span class="dt-tick dt-tick--q3"><strong>3/4&Prime;</strong></span>
                    <span class="dt-tick dt-tick--1"><strong>1&Prime;+</strong></span>
                </div>
            </div>

            <div class="dt-gauge__read">
                <ul class="dt-legend reveal-right reveal-delay-1">
                    <li>
                        <span class="dt-swatch dt-swatch--good" aria-hidden="true"></span>
                        <span><strong>Under 1/2 inch — leave it.</strong> A thin layer cushions the turf, insulates the crowns against Upstate heat, and holds moisture. Removing it does more harm than good.</span>
                    </li>
                    <li>
                        <span class="dt-swatch dt-swatch--monitor" aria-hidden="true"></span>
                        <span><strong>1/2 to 3/4 inch — watch it.</strong> Not urgent, but worth correcting the cause: over-fertilization, over-watering, and compaction all push thatch build-up.</span>
                    </li>
                    <li>
                        <span class="dt-swatch dt-swatch--dethatch" aria-hidden="true"></span>
                        <span><strong>Over 3/4 inch — remove it.</strong> Now the layer sheds water, harbours insects and disease, and lets roots grow in the thatch instead of the soil. Time to verticut.</span>
                    </li>
                </ul>

                <div class="dt-measure reveal-right reveal-delay-2">
                    <h3><i data-lucide="scissors" aria-hidden="true"></i> How to measure it yourself</h3>
                    <p>
                        Cut a small wedge out of the lawn with a hand trowel, like a slice of cake, and
                        pull it up. Between the green blades and the darker soil you will see a spongy
                        brown band — that is the thatch. Hold a ruler against it. If that band is thicker
                        than about a half inch, it is worth a professional look before an Upstate summer
                        puts the lawn under stress.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Divider — double wave, filled with the expert section's light background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · EXPERT POSITIONING (the not-oversell angle) ══════════ -->
<section class="dt-expert" aria-label="Whether a Mauldin lawn actually needs dethatching">
    <div class="container">
        <div class="dt-expert__layout">

            <div class="dt-stat-watermark reveal-left" aria-hidden="true">
                &frac12;&Prime;<span>Where thatch stops helping</span>
            </div>

            <div>
                <h2 class="reveal-right">Does every lawn in the Upstate actually need dethatching?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    No — and that is the honest part. Many Greenville County lawns never build enough
                    thatch to justify the machine, and tall fescue, a bunch grass, almost never does.
                    Dethatching is aggressive: it tears out material and thins the lawn on purpose.
                    Greenville Lawn Masters only recommends it when the measured layer earns it.
                </p>

                <ul class="dt-diffs">
                    <?php foreach ($diffs as $i => $diff): ?>
                        <li class="dt-diff reveal-right reveal-delay-<?php echo $i + 2; ?>">
                            <i data-lucide="<?php echo e($diff['icon']); ?>" aria-hidden="true"></i>
                            <div>
                                <strong><?php echo e($diff['title']); ?></strong>
                                <p><?php echo e($diff['body']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <!-- Divider — diagonal, filled with the process section's white background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-white)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · SERVICE BREAKDOWN + PROCESS ══════════ -->
<section class="dt-process" aria-label="What a Greenville Lawn Masters dethatch involves">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What does <span class="text-accent">Greenville Lawn Masters</span> do to dethatch a lawn?</h2>
            <p class="answer-block">
                Greenville Lawn Masters dethatches in four moves: measure the layer, confirm the lawn
                actually needs it, verticut or power rake at the right depth during active growth, then
                collect and haul the debris off. Removal only happens on a warm-season lawn with genuine
                excess thatch, never by default.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <ol class="dt-rail">
            <?php foreach ($steps as $i => $step): ?>
                <li class="dt-rail__step <?php echo ['reveal-left', 'reveal-up', 'reveal-right', 'reveal-up'][$i % 4]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="dt-rail__phase">
                        <i data-lucide="<?php echo e($step['icon']); ?>" aria-hidden="true"></i>
                        <?php echo e($step['phase']); ?>
                    </span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Divider — torn edge, filled with the proof section's dark background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,38 L80,44 L160,32 L240,46 L320,34 L420,44 L520,30 L620,42 L720,34 L820,46 L920,32 L1020,44 L1120,36 L1200,42 L1200,60 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 6 · PROOF ══════════ -->
<?php /* THE PHOTO GAP LIVES HERE. Not one photograph in the library shows thatch,
         a dethatcher, or a power rake (config.php $servicePhotos, photo_gap=true).
         So the captions below describe ONLY what is in each frame — a mowing shot
         and two finished lawns — and none of them says or implies "dethatching."
         The .photo-note disclosure states this plainly, and the no-reviews note
         explains the empty testimonial slot. Fabricating either a "before/after"
         caption or a review would be a trust/FTC problem, not a placeholder. */ ?>
<section class="dt-proof" aria-label="Greenville Lawn Masters lawns in Mauldin">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label dt-eyebrow">The Work</span>
            <h2>What do the <span class="text-accent">Mauldin lawns</span> Greenville Lawn Masters maintains look like?</h2>
            <p class="answer-block">
                Greenville Lawn Masters photographs its own job sites, and every image below is a real
                Mauldin-area property the crew maintains — not stock photography. A crew member on the
                weekly mowing route, a dense green front lawn, and backyard turf held tight against
                mulched beds.
            </p>
        </div>

        <div class="dt-proof__grid">
            <?php
            /* Captions state ONLY what the frame contains. The service on this page —
               dethatching — is NOT shown in any photo, so no caption mentions it. The
               mowing frame shows a crew mowing, so that caption may say "mowing." */
            $shots = [
                ['key' => 'mowing',     'mod' => '',              'label' => 'On the mowing route', 'caption' => 'A Greenville Lawn Masters crew member mowing a fenced Mauldin backyard on the weekly route.'],
                ['key' => 'front_lawn', 'mod' => 'dt-shot--arch', 'label' => 'A maintained front lawn', 'caption' => 'A dense green front lawn and concrete driveway at a two-story home in a Mauldin neighborhood.'],
                ['key' => 'backyard',   'mod' => 'dt-shot--frame','label' => 'Turf against the beds', 'caption' => 'Backyard turf running between mulched planting beds and a wood privacy fence at a Mauldin home.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="dt-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <?php /* REQUIRED photo-gap disclosure. Gated on the config flag so it appears
                 only while no real dethatching photo exists. Uses the shared
                 .photo-note class (framework.css) and the camera-off icon. */ ?>
        <?php if (!empty($media['photo_gap'])): ?>
            <p class="photo-note reveal-up">
                <i data-lucide="camera-off" aria-hidden="true"></i>
                <span>
                    None of the photographs on this page shows dethatching, thatch, or a power rake &mdash;
                    Greenville Lawn Masters has not yet documented this work in the field. These are real
                    Mauldin lawns the crew maintains on its mowing route. Job-site photography of actual
                    thatch removal will replace these images once that work is captured.
                </span>
            </p>
        <?php endif; ?>

        <div class="dt-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 7 · COMPARISON ══════════ -->
<section class="dt-compare" aria-label="How Greenville Lawn Masters approaches dethatching">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates a careful dethatch from a spring rip-everything-out?</h2>
            <p class="answer-block">
                A careful dethatch starts with a measurement and often ends with the machine staying in
                the trailer. A rip-everything-out treats every lawn the same in April, fescue included,
                and rakes turf that was never going to benefit. The difference is whether the thatch was
                measured before the blades touched the grass.
            </p>
        </div>

        <?php /* Left column = common practice in the trade, not a named competitor.
                 Every right-hand row is a process commitment recorded at intake or an
                 agronomic practice — never a credential claim. */ ?>
        <div class="dt-compare__table reveal-up reveal-delay-1">
            <div class="dt-compare__head">
                <div>A typical spring dethatch-everything</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="dt-compare__row">
                    <div data-label="A typical spring dethatch-everything">
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

    <!-- Divider — diagonal, filled with the FAQ section's white background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-white)" points="0,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 8 · FAQ ══════════ -->
<section class="dt-faq" aria-label="Dethatching questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">dethatching</span>?</h2>
            <p class="answer-block">
                Straight answers on what thatch actually is, when it crosses the half-inch mark that
                calls for removal, the right season to dethatch in Mauldin, whether a fescue lawn needs
                it at all, how dethatching differs from core aeration, and whether grass clippings are
                what built the layer.
            </p>
        </div>

        <div class="dt-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="dt-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="dt-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> handle in Mauldin?</h2>
            <p class="answer-block">
                Dethatching is one of <?php echo e((string) $totalServices); ?> services Greenville Lawn
                Masters offers across Greenville County. The same crew handles the lawn-health work that
                keeps thatch in check in the first place — aeration, feeding, and seasonal care — on the
                same 24-hour written estimate.
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
<section class="dt-cta" aria-label="Request a lawn walkthrough">
    <div class="container">
        <h2 class="reveal-up">Ready to find out whether your Mauldin lawn actually needs dethatching?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Book a free walkthrough and Greenville Lawn Masters will measure the thatch, identify the
            grass, and tell you straight — dethatch, aerate, or leave it alone. The written, itemised
            estimate follows within 24 hours, and the machine only runs on a lawn that has earned it.
        </p>
        <div class="dt-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Lawn Walkthrough
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
