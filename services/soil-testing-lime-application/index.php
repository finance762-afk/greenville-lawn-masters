<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/soil-testing-lime-application/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page (config.php $servicePages type 'service'):
   servicesOnPage('soil-testing-lime-application') returns exactly one
   service, so there is no OfferCatalog here — the page is one subject,
   soil chemistry, told in eight editorial sections.

   WHAT IS AND IS NOT ASSERTED (this is the whole reason for the comments):
   - The soil-science claims below (Piedmont clay runs acidic, pH 6.0-7.0 is
     the general turf band, centipede prefers 5.0-6.0, pH is logarithmic,
     phosphorus binds and aluminium turns soluble below ~5.5, over-liming
     locks iron/manganese, dolomitic vs calcitic, buffer capacity sets the
     rate) are checkable agronomy for the SC Upstate. They are safe to state.
   - NO lime RATE in pounds is ever given. The rate is a test result that
     depends on buffer capacity; printing one for an unseen lawn would be
     advice we cannot stand behind, so every reference to "rate" points back
     at the soil test instead of a number.
   - NO lab AFFILIATION is claimed. Clemson's Agricultural Service Laboratory
     is named only as the public route SC samples actually travel — a fact —
     never as a partner, endorser, or certifier. Intake supplied no
     certifications, licenses, or insurance, so none appear anywhere in
     client-facing copy (only in these comments, explaining the omission).
   - NO reviews, ratings, prices, or invented statistics. config.php $reviews
     is empty and $phone is empty; both are handled as absences, not filled
     with placeholders.

   File shape mirrors /services/lawn-care-services/index.php: two PHP blocks,
   $pageSchema built BEFORE head.php, then head/header, <style>, markup, footer.
   ============================================================ */

$pageSlug    = 'soil-testing-lime-application';
$currentPage = 'services';

$servicesHere = servicesOnPage($pageSlug);          // exactly one service
$service      = $servicesHere[0] ?? [];             // the soil-testing service row
$media        = servicePagePhotos($pageSlug);       // hero + body + photo_gap => true
$heroImg      = heroPhoto($media['hero']);          // 'front_lawn' rendition

$pageTitle       = 'Soil Testing & Lime Application in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Soil testing and lime application in Mauldin, SC. Cores pulled zone by zone, pH read, lime applied at the tested rate. Written estimate in 24 hours.';   // 148 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];                // preload the LCP hero background

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';   // $phone is empty in intake

/* ── pH scale geometry for the signature gauge (§ Signature Section) ──
   The gauge is calibrated 4.5 → 8.0. Every position is computed here so the
   markup carries only percentages (geometry, not colour) — the gauge colour
   comes entirely from brand tokens in <style>. These are pH values, which the
   build rules explicitly permit; no rate, no cost, no invented number. */
$phMin  = 4.5;
$phMax  = 8.0;
$phSpan = $phMax - $phMin;                                  // 3.5 pH units across the bar
$phPct  = static fn(float $v): float => round((($v - $phMin) / $phSpan) * 100, 2);
$phTicks = [4.5, 5.0, 5.5, 6.0, 6.5, 7.0, 7.5, 8.0];        // labelled ticks
$turfBand = ['left' => $phPct(6.0), 'width' => $phPct(7.0) - $phPct(6.0)];   // most turf 6.0-7.0
$cenBand  = ['left' => $phPct(5.0), 'width' => $phPct(6.0) - $phPct(5.0)];   // centipede 5.0-6.0
$clayMark = $phPct(5.2);   // untreated Upstate Piedmont clay typically sits acidic (~5.0-5.5)

/* ── Telltale signs (§2 problem statement) ───────────────────
   Symptoms a homeowner can verify by walking the yard, each tied to soil
   chemistry rather than to urgency. Moss deliberately hedged — it flags shade
   and compaction at least as much as low pH, and overclaiming it would be the
   exact guess this page argues against. */
$signs = [
    ['icon' => 'trending-down', 'title' => 'You feed it yearly, nothing changes', 'body' => 'A lawn fertilised on schedule that still looks hungry is often locked below pH 5.5, where the nutrients are present in the soil but chemically unavailable to the roots.'],
    ['icon' => 'sprout',        'title' => 'Moss and acid-loving weeds move in',  'body' => 'Moss and acid-tolerant weeds take hold where turf is weak. They can flag low pH — though moss also signals shade, compaction, and moisture, which is why the soil gets read, not assumed.'],
    ['icon' => 'leaf',          'title' => 'Yellowing that feeding will not fix',  'body' => 'Turf that yellows no matter how it is fed may sit at the wrong pH entirely: too acidic to use nitrogen, or pushed too high until iron and manganese are locked away.'],
    ['icon' => 'tree-pine',     'title' => 'Thin grass under pines and oaks',      'body' => 'Ground beneath pines and oaks runs more acidic and more shaded across the Upstate. Grass there struggles first, and a blanket lime dose rarely fixes it without a reading.'],
];

/* ── Differentiators (§3 expert positioning) ─────────────────
   Every item is a process the crew performs or a horticultural fact — never a
   credential. Intake recorded none, so none is implied. */
$diffs = [
    ['icon' => 'flask-conical',      'title' => 'The test comes before the lime',       'body' => 'Nothing is spread until a composite sample from your zones has been read for pH and nutrients. The correction follows the result, not the calendar.'],
    ['icon' => 'layers',             'title' => 'Sampled by zone, not by scoop',        'body' => 'Multiple cores from several spots per zone, pulled to a consistent depth of about four inches for turf and composited — because pH shifts across a single yard.'],
    ['icon' => 'sliders-horizontal', 'title' => 'The correction is matched, not defaulted', 'body' => 'Lime type and rate come from the analysis. Heavy clay resists pH change far more than sand, so two lawns reading the same pH can need very different corrections.'],
];

/* ── What the service includes (§4 service breakdown) ────────*/
$included = [
    ['icon' => 'layers',        'title' => 'Core sampling by zone', 'body' => 'Several cores are pulled from each area of the property to a consistent depth, then composited into a sample that represents the whole zone rather than one lucky scoop.'],
    ['icon' => 'flask-conical', 'title' => 'Laboratory analysis',   'body' => 'The composite is submitted for analysis of pH, buffer capacity, and nutrient levels — the numbers that actually decide the correction.'],
    ['icon' => 'gauge',         'title' => 'Reading pH and nutrients', 'body' => 'Results are interpreted against the grass you actually grow, since the target pH for centipede differs from the band most Upstate turf prefers.'],
    ['icon' => 'scale',         'title' => 'Lime at the tested rate', 'body' => 'Lime is applied at the rate and type the analysis calls for, calcitic or dolomitic, instead of a blanket seasonal dose that ignores what the soil holds.'],
    ['icon' => 'repeat',        'title' => 'Retest to confirm',      'body' => 'Because lime reacts over months, the soil is retested later to confirm the pH actually moved toward target rather than assuming the bag did its job.'],
];

/* ── Process timeline (§4 process rail — the signature vertical rail
     appears on the group page, so this page uses a stepped card row to stay
     visually distinct from lawn-care-services). */
$timeline = [
    ['phase' => 'Walkthrough', 'title' => 'Free property walkthrough', 'body' => 'The lawn is walked zone by zone, grass type identified, and problem areas noted. A written, itemised estimate follows within 24 hours.'],
    ['phase' => 'Sampling',    'title' => 'Cores pulled and submitted', 'body' => 'Composite samples are collected from each zone at a consistent depth and sent for analysis of pH, buffer capacity, and nutrients.'],
    ['phase' => 'Reading',     'title' => 'Results interpreted',       'body' => 'The numbers are read against your grass type and the reality of acidic Upstate Piedmont clay, not a one-size chart.'],
    ['phase' => 'Correction',  'title' => 'Lime applied to spec',      'body' => 'The right material goes down at the tested rate, ideally onto aerated soil in fall so it has months to dissolve and react.'],
    ['phase' => 'Retest',      'title' => 'pH confirmed later',        'body' => 'A follow-up test verifies the pH moved toward target, because lime works slowly and the proof is in the retest, not the receipt.'],
];

/* ── Comparison (§6) ─────────────────────────────────────────
   Left column is common trade practice, not a named competitor. Every
   right-hand row is a process commitment or a soil-science practice — nothing
   is a credential, price, or guaranteed pH result. */
$comparison = [
    ['them' => 'Lime spread every spring because it is spring', 'us' => 'Lime applied only when a soil test shows the pH needs it'],
    ['them' => 'One rate used for every lawn on the route',     'us' => 'Rate set by buffer capacity, which clay and sand change'],
    ['them' => 'Whatever lime is on the truck goes down',        'us' => 'Calcitic or dolomitic chosen from what the analysis shows'],
    ['them' => 'pH never actually measured',                     'us' => 'pH and nutrients read before anything is applied'],
    ['them' => 'Centipede limed like every other grass',         'us' => 'A lower target for centipede respected to avoid over-liming'],
    ['them' => 'Job called done the day lime goes down',         'us' => 'Soil retested later to confirm the pH moved toward target'],
];

/* ── FAQs — conversational, 40-80 words, mirrored into generateFAQSchema().
   No pricing (none supplied). Clemson named as a public resource only, with an
   explicit disclaimer of partnership inside the answer text itself. No lime
   rate, no turnaround days, no guaranteed result. */
$faqs = [
    [
        'question' => 'Why should soil be tested before lime is applied to a Mauldin lawn?',
        'answer'   => 'Because lime is a chemical correction, and correcting the wrong thing damages turf. A soil test reads the actual pH and the soil buffer capacity, which is what sets how much lime a lawn needs. Two Mauldin yards at the same pH can need very different amounts, so Greenville Lawn Masters tests first and lets the result decide.',
    ],
    [
        'question' => 'How does Greenville Lawn Masters collect a soil sample?',
        'answer'   => 'Greenville Lawn Masters pulls several small cores from different spots in each zone, to a consistent depth of about four inches for turf, then composites them into one representative sample. One scoop from one place tells you almost nothing, because pH varies across a single yard as sun, shade, slope, and old fill all shift it.',
    ],
    [
        'question' => 'What soil pH do lawns in Mauldin, South Carolina need?',
        'answer'   => 'Most turfgrasses take up nutrients best between roughly pH 6.0 and 7.0. Centipede is the exception and prefers a more acidic soil, around 5.0 to 6.0, and is easily harmed by over-liming. Because pH is a logarithmic scale, pH 5 is ten times more acidic than pH 6, so small numbers stand for large chemical differences.',
    ],
    [
        'question' => 'Can too much lime damage a lawn?',
        'answer'   => 'Yes. Over-liming pushes pH too high and locks up iron and manganese, which shows as yellowing between the leaf veins. It is much harder to reverse than a soil that is simply too acidic. This is exactly why Greenville Lawn Masters applies lime only at the rate the soil test calls for, never a blanket spring dose.',
    ],
    [
        'question' => 'Why does fertilizer stop working on an acidic lawn?',
        'answer'   => 'Below about pH 5.5, phosphorus becomes chemically bound and less available, and aluminium turns more soluble and can injure roots. The nutrients are physically in the soil but locked up, so feeding a strongly acidic lawn largely wastes the fertilizer. Correcting pH first is what lets the feeding you already pay for actually reach the grass.',
    ],
    [
        'question' => 'When is the best time to apply lime in the Upstate?',
        'answer'   => 'Fall is a strong time to lime, because the material reacts slowly and needs months to dissolve and change pH before spring green-up. Lime does not work overnight. Applying it to recently aerated soil helps, since aeration opens channels through heavy Piedmont clay so the lime reaches the root zone instead of sitting on the surface.',
    ],
    [
        'question' => 'Is dolomitic or calcitic lime better for my lawn?',
        'answer'   => 'That is a test result, not a default. Dolomitic lime supplies magnesium along with calcium; calcitic lime supplies mostly calcium. Which one a lawn needs depends on what the soil analysis shows it is short of. Greenville Lawn Masters chooses the material from the test rather than reaching for whatever bag is closest to the tailgate.',
    ],
    [
        'question' => 'Where are South Carolina soil samples analysed?',
        'answer'   => 'Soil samples from South Carolina are commonly analysed at the Clemson Agricultural Service Laboratory, with county Extension offices handling submission — a genuine public resource for Upstate homeowners. Greenville Lawn Masters interprets the results and applies the correction; the lab is simply the standard public place South Carolina soil is analysed, named here as that route and nothing more.',
    ],
];

/* ── Schema — exactly four nodes (build prompt) ───────────────
   (a) Service, @id #service-{slug}, provider → homepage LocalBusiness @id.
       serviceType + description + url + areaServed. NO offers / priceRange —
       no pricing was supplied and fabricated structured pricing is a
       misrepresentation Google acts on.
   (b) FAQPage mirroring the visible FAQ verbatim.
   (c) BreadcrumbList Home > Services > Soil Testing & Lime Application.
   (d) WebPage with Speakable selectors — all four exist in the markup below. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $pageSlug,
        'name'        => 'Soil Testing & Lime Application',
        'serviceType' => 'Soil testing and lime application',
        'description' => 'Soil testing and lime application in Mauldin, South Carolina. Composite soil '
                       . 'samples are pulled from multiple zones and analysed for pH and nutrients, then '
                       . 'lime is applied at the rate and type the test calls for to correct acidic '
                       . 'Upstate Piedmont clay.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',                          'url' => '/'],
        ['name' => 'Services',                      'url' => '/services/'],
        ['name' => 'Soil Testing & Lime Application','url' => '/services/' . $pageSlug . '/'],
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
   Soil Testing & Lime Application — page-scoped styles
   Every rule prefixed .stl- so nothing collides with another page's
   <style> block. Colour, shadow, spacing, radius, and transition timing are
   var() tokens without exception. Geometric px is used ONLY inside the pH
   gauge, clip-paths, and keyframes, where the build rules permit it.

   Techniques (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after (42deg,
         distinct from the reference 78deg, homepage 100deg, sod 118deg)
     C3  three distinct SVG dividers (torn, diagonal, wave)
     C4  editorial pull-quote
     C5  bento grid of telltale signs
     C6  asymmetric 62/38 split with an oversized stat watermark
     C7  SIGNATURE — the horizontal pH gauge (this page only)
     C10 comparison table with accent-highlighted winning column
     C11 image treatments — arch and offset frame on the proof strip
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Shares front_lawn with the sod page, so the overlay treatment differs hard:
   a 42deg angle and its own stop positions keep the two from reading alike. */
.stl-hero {
  min-height: 76vh;
  min-height: 76svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-front-lawn.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.stl-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    42deg,
    rgba(var(--color-dark-rgb), 0.94) 0%,
    rgba(var(--color-dark-rgb), 0.82) 38%,
    rgba(var(--color-primary-rgb), 0.52) 70%,
    rgba(var(--color-accent-rgb), 0.28) 100%
  );
  z-index: 0;
}
.stl-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.stl-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 64rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.stl-hero .breadcrumb { animation: stlFade 0.5s ease both; }

.stl-hero__eyebrow {
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
  animation: stlFade 0.55s ease 0.08s both;
}
.stl-hero__eyebrow i, .stl-hero__eyebrow svg { width: 15px; height: 15px; }

.stl-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: stlRise 0.6s ease 0.16s both;
}
.stl-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres globally; a left-aligned hero must reset that. */
.stl-hero .hero-answer {
  margin-inline: 0;
  max-width: 60ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: stlRise 0.6s ease 0.26s both;
}
.stl-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: stlRise 0.6s ease 0.36s both;
}
.stl-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: stlRise 0.6s ease 0.46s both;
}
.stl-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.stl-hero__trust i, .stl-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS keyframes, never a reveal-* class — the
   reveal system starts at opacity:0 and would blank the hero if its
   IntersectionObserver never fired. */
@keyframes stlFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes stlRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.stl-problem { background: var(--color-light); }
.stl-problem__layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: var(--space-12);
  align-items: start;
}
.stl-problem__quote {
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
.stl-problem__lead { color: var(--color-gray-dark); }
.stl-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   The first card spans two columns so the grid does not read as four identical
   boxes. Tints rotate; no two adjacent cards share a background. */
.stl-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.stl-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.stl-sign:first-child { grid-column: span 2; }
.stl-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.stl-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.stl-sign__icon i, .stl-sign__icon svg { width: 22px; height: 22px; }
.stl-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.stl-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.stl-expert { background: var(--color-white); }
.stl-expert__layout {
  display: grid;
  grid-template-columns: 0.62fr 1.38fr;   /* editorial, not 50/50 */
  gap: var(--space-16);
  align-items: center;
}
.stl-stat-watermark {
  position: relative;
  font-family: var(--font-heading);
  font-weight: 900;
  font-size: clamp(5.5rem, 12vw, 11rem);
  line-height: 0.82;
  letter-spacing: -0.05em;
  color: var(--color-primary);
  opacity: 0.14;
  user-select: none;
}
.stl-stat-watermark span {
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
  max-width: 14ch;
  line-height: 1.3;
}
.stl-expert h2 { margin-bottom: var(--space-5); }
.stl-expert .answer-block { margin-inline: 0; }
.stl-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.stl-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.stl-diff i, .stl-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.stl-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.stl-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ════════════════════════════════════════════════════════════
   SIGNATURE SECTION · the pH gauge  (this page only)
   A calibrated 4.5-8.0 scale. The bar gradient is built from BRAND TOKENS
   (secondary → accent → primary), not a rainbow of invented hexes. Positions
   arrive from PHP as inline percentages, so nothing here hardcodes geometry
   except the fixed track/tick heights, which the rules allow in the gauge.
   ════════════════════════════════════════════════════════════ */
.stl-ph { background: var(--color-dark); }
.stl-ph .eyebrow-label { color: var(--color-accent); }
.stl-ph h2 { color: var(--color-white); }
.stl-ph .answer-block { color: rgba(var(--color-white-rgb), 0.82); margin-inline: auto; }

.stl-gauge {
  max-width: 62rem;
  margin: var(--space-16) auto 0;
}
/* The calibrated bar. Acidic (dark slate) at the left, neutral-green at the
   right — a semantic ramp made only of the brand palette. */
.stl-gauge__track {
  position: relative;
  height: 34px;
  border-radius: var(--radius-full);
  background: linear-gradient(
    90deg,
    var(--color-secondary) 0%,
    var(--color-accent) 55%,
    var(--color-primary) 100%
  );
  box-shadow: var(--shadow-md);
}
/* Target bands sit on top of the bar as translucent white windows with a label
   flag above each. They mark WHERE a lawn wants to be, not a colour value. */
.stl-gauge__band {
  position: absolute;
  top: -6px;
  bottom: -6px;
  border-radius: var(--radius-sm);
  border: 2px solid rgba(var(--color-white-rgb), 0.85);
  background: rgba(var(--color-white-rgb), 0.14);
}
.stl-gauge__band-label {
  position: absolute;
  bottom: calc(100% + var(--space-2));
  left: 50%;
  transform: translateX(-50%);
  white-space: nowrap;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  letter-spacing: 0.5px;
  color: var(--color-white);
  background: rgba(var(--color-white-rgb), 0.1);
  padding: var(--space-1) var(--space-3);
  border-radius: var(--radius-full);
}
.stl-gauge__band--centipede { border-style: dashed; }

/* The clay marker: a vertical needle with a flag showing where untreated
   Upstate Piedmont clay typically sits — acidic, left of the target band. */
.stl-gauge__marker {
  position: absolute;
  top: -22px;
  bottom: -22px;
  width: 3px;
  transform: translateX(-50%);
  background: var(--color-white);
}
.stl-gauge__marker::after {
  content: '';
  position: absolute;
  top: -6px;
  left: 50%;
  width: 12px;
  height: 12px;
  transform: translateX(-50%) rotate(45deg);
  background: var(--color-white);
  border-radius: 2px;
}
.stl-gauge__marker-flag {
  position: absolute;
  top: calc(-1 * var(--space-12));
  left: 50%;
  transform: translateX(-50%);
  white-space: nowrap;
  font-family: var(--font-body);
  font-size: var(--font-size-xs);
  font-weight: 700;
  color: var(--color-dark);
  background: var(--color-white);
  padding: var(--space-1) var(--space-3);
  border-radius: var(--radius-full);
  box-shadow: var(--shadow-md);
}
/* Tick row under the bar. */
.stl-gauge__ticks {
  position: relative;
  height: 42px;
  margin-top: var(--space-2);
}
.stl-gauge__tick {
  position: absolute;
  top: 0;
  transform: translateX(-50%);
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--space-1);
}
.stl-gauge__tick::before {
  content: '';
  width: 2px;
  height: 10px;
  background: rgba(var(--color-white-rgb), 0.4);
}
.stl-gauge__tick-label {
  font-family: var(--font-heading);
  font-size: var(--font-size-sm);
  font-weight: 700;
  color: rgba(var(--color-white-rgb), 0.85);
}
/* Two problem callouts flank the gauge: what goes wrong below 5.5 and above
   the target band. */
.stl-ph__callouts {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: var(--space-6);
  margin-top: var(--space-16);
}
.stl-callout {
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: rgba(var(--color-white-rgb), 0.05);
  border-top: 3px solid var(--color-accent);
}
.stl-callout__head {
  display: flex;
  align-items: center;
  gap: var(--space-3);
  margin-bottom: var(--space-3);
}
.stl-callout__head i, .stl-callout__head svg { width: 22px; height: 22px; color: var(--color-accent); }
.stl-callout h3 { color: var(--color-white); font-size: var(--font-size-lg); margin: 0; }
.stl-callout p { color: rgba(var(--color-white-rgb), 0.7); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C? · Service breakdown grid ──────────────────────────────*/
.stl-breakdown { background: var(--color-light); }
.stl-includes {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-5);
}
.stl-include {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-top: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.stl-include:hover {
  transform: translateY(-5px);
  border-top-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.stl-include__icon { color: var(--color-primary); }
.stl-include__icon i, .stl-include__icon svg { width: 28px; height: 28px; }
.stl-include h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.stl-include p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray); line-height: 1.6; }

/* ── Process — stepped horizontal cards (distinct from the group page rail) */
.stl-process {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: var(--space-4);
  margin-top: var(--space-16);
  counter-reset: stl-step;
}
.stl-step {
  position: relative;
  padding: var(--space-6) var(--space-5);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-top: 4px solid var(--color-accent);
}
.stl-step::before {
  counter-increment: stl-step;
  content: counter(stl-step);
  display: grid;
  place-items: center;
  width: 34px; height: 34px;
  border-radius: var(--radius-full);
  background: var(--color-primary);
  color: var(--color-white);
  font-family: var(--font-heading);
  font-weight: 800;
  font-size: var(--font-size-sm);
  margin-bottom: var(--space-4);
}
.stl-step__phase {
  display: block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.stl-step h3 { font-size: var(--font-size-base); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.stl-step p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray); line-height: 1.6; }

/* ── C11 · Proof strip, arch and offset-frame treatments ──────*/
.stl-proof { background: var(--color-dark); }
.stl-proof h2, .stl-proof .eyebrow-label { color: var(--color-white); }
.stl-proof .eyebrow-label { color: var(--color-accent); }
.stl-proof .answer-block { color: rgba(var(--color-white-rgb), 0.8); }
.stl-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.stl-shot { margin: 0; }
.stl-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
.stl-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.stl-shot--frame { position: relative; }
.stl-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.stl-shot:hover img { transform: scale(1.03); }
.stl-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.stl-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }

/* The photo-gap disclosure uses the SHARED .photo-note class (framework.css).
   On this dark section its default gray reads low, so lift it here — the copy
   still says plainly that no frame shows soil work. */
.stl-proof .photo-note {
  color: rgba(var(--color-white-rgb), 0.6);
  border-left-color: rgba(var(--color-white-rgb), 0.2);
}
.stl-proof .photo-note i, .stl-proof .photo-note svg { color: var(--color-accent); }
.stl-proof__reviews {
  max-width: 65ch;
  margin: var(--space-6) auto 0;
  padding: var(--space-5) var(--space-6);
  border-radius: var(--radius-md);
  background: rgba(var(--color-white-rgb), 0.05);
  color: rgba(var(--color-white-rgb), 0.6);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  text-align: center;
}
.stl-proof__reviews p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.stl-compare { background: var(--color-white); }
.stl-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.stl-compare__head, .stl-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.stl-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.stl-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.stl-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.stl-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.stl-compare__row > div:first-child { color: var(--color-gray); }
.stl-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.stl-compare__row i, .stl-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.stl-compare__row > div:first-child i, .stl-compare__row > div:first-child svg { color: var(--color-gray); }
.stl-compare__row > div:last-child i,  .stl-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.stl-faq { background: var(--color-light); }
.stl-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.stl-faq__item {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.stl-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.stl-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.stl-related { background: var(--color-white); }

/* ── Final CTA ────────────────────────────────────────────────*/
.stl-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.stl-cta::before {
  content: '';
  position: absolute;
  top: -20%; left: -8%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.stl-cta .container { position: relative; z-index: 1; }
.stl-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.stl-cta .answer-block { color: rgba(var(--color-white-rgb), 0.88); margin-inline: auto; }
.stl-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; margin-top: var(--space-8); }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .stl-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .stl-problem__quote { max-width: none; }
  .stl-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .stl-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .stl-stat-watermark span { position: static; display: block; margin-top: var(--space-8); max-width: none; }
  .stl-signs { grid-template-columns: repeat(2, 1fr); }
  .stl-sign:first-child { grid-column: span 2; }
  .stl-includes { grid-template-columns: repeat(2, 1fr); }
  .stl-process { grid-template-columns: repeat(2, 1fr); }
  .stl-proof__grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 700px) {
  .stl-hero { min-height: 0; }
  .stl-signs, .stl-includes, .stl-process, .stl-proof__grid, .stl-ph__callouts { grid-template-columns: 1fr; }
  .stl-sign:first-child { grid-column: span 1; }
  .stl-shot--frame::before { display: none; }

  /* The gauge stays legible on a phone: hide the crowded intermediate ticks and
     let the band + marker flags carry the read. */
  .stl-gauge__tick:nth-child(even) { display: none; }

  /* Comparison collapses to stacked pairs; each cell then needs its own label. */
  .stl-compare__head { display: none; }
  .stl-compare__row { grid-template-columns: 1fr; }
  .stl-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .stl-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero stl-hero" aria-label="Soil testing and lime application in Mauldin, South Carolina">
    <div class="container">
        <div class="stl-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Soil Testing &amp; Lime Application</span></li>
                </ol>
            </nav>

            <span class="stl-hero__eyebrow">
                <i data-lucide="flask-conical" aria-hidden="true"></i>
                Soil Chemistry &middot; <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?>
            </span>

            <h1>Soil Testing &amp; Lime Application in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters tests your soil before applying any lime in Mauldin, South
                Carolina and across Greenville County. A composite sample is read for pH and nutrients,
                and lime is applied only at the rate and type the analysis calls for — because Upstate
                Piedmont clay runs acidic, and guessing wastes both the lime and the fertilizer.
            </p>

            <div class="stl-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Soil Assessment
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* $phone is empty in config.php. A "Call Now" button with no number — or a
                             fabricated one — is worse than routing to the estimate form. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only intake-verified facts: location, the 24-hour written
                     estimate, the service count, and the founding year. No "Licensed & Insured",
                     no certified-applicator claim, no rating — config.php has none of them. */ ?>
            <div class="stl-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="test-tube-diagonal" aria-hidden="true"></i> Tested first, then treated</span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="calendar-days" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider 1 — torn edge, filled with the problem section's light background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,40 L60,42 L120,35 L200,45 L280,32 L360,48 L440,38 L540,45 L640,30 L740,42 L840,35 L940,45 L1040,32 L1140,42 L1200,38 L1200,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · PROBLEM STATEMENT ══════════ -->
<section class="stl-problem" aria-label="Signs a Mauldin lawn has a soil chemistry problem">
    <div class="container">
        <div class="stl-problem__layout">
            <blockquote class="stl-problem__quote reveal-left">
                You cannot fix a soil problem by feeding the grass harder.
            </blockquote>

            <div class="stl-problem__lead">
                <h2 class="reveal-right">How can you tell a Mauldin lawn has a soil pH problem?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    You can tell a Mauldin lawn has a soil pH problem when fertilizer stops producing
                    results, moss and acid-loving weeds spread, turf yellows despite feeding, or grass
                    thins under pines and oaks. Each points at soil chemistry the eye cannot read —
                    which is why the soil gets sampled, not guessed.
                </p>
                <p class="reveal-right reveal-delay-2">
                    Upstate Piedmont soils are naturally acidic clay: decades of heavy rainfall leach
                    the bases out of the profile and pull the pH down over time. Below that surface,
                    nutrients you already paid for can be chemically locked away — present in the soil,
                    unavailable to the roots. Reading the pH first is the only way to know which
                    correction the lawn actually needs.
                </p>
            </div>
        </div>

        <div class="stl-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral; reveal direction rotates so the grid is not all
                   fade-up. No two adjacent cards share a tint or a direction. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="stl-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="stl-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="stl-expert" aria-label="Why Greenville Lawn Masters tests before liming">
    <div class="container">
        <div class="stl-expert__layout">

            <?php /* Watermark is a verifiable fact, not an invented statistic: pH is logarithmic, so
                     one point equals a tenfold change in acidity. */ ?>
            <div class="stl-stat-watermark reveal-left" aria-hidden="true">
                10&times;<span>more acidic per pH point down the scale</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does the soil test have to come before the lime?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    The soil test comes before the lime because lime is a correction, and the right
                    amount depends on the soil buffer capacity, not just its pH. Heavy clay resists pH
                    change far more than sand, so two Mauldin lawns reading the same pH can need very
                    different amounts. The test is what tells them apart.
                </p>

                <ul class="stl-diffs">
                    <?php foreach ($diffs as $i => $d): ?>
                        <li class="stl-diff reveal-right reveal-delay-<?php echo $i + 2; ?>">
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

    <!-- Divider 2 — diagonal, filled with the pH section's dark background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-dark)" points="0,60 1200,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ SIGNATURE · pH SCALE GAUGE ══════════ -->
<section class="stl-ph" aria-label="Where Upstate soils sit on the pH scale">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Read the Scale</span>
            <h2>Where does Upstate Piedmont clay sit on the pH scale?</h2>
            <p class="answer-block">
                Untreated Piedmont soils across Upstate South Carolina are typically acidic clay,
                sitting left of the range most turf prefers. Decades of heavy rainfall leach bases out
                of the profile and drop the pH. Most grasses want roughly 6.0 to 7.0; centipede is the
                exception, preferring a more acidic 5.0 to 6.0.
            </p>
        </div>

        <?php /* Gauge geometry (left/width %) comes from PHP so the markup holds no colour — the
                 bar gradient in <style> is built from --color-secondary / --color-accent /
                 --color-primary only. Values are pH numbers, which the rules permit; there is no
                 rate, cost, or guaranteed result anywhere in here. */ ?>
        <div class="stl-gauge reveal-up reveal-delay-1">
            <div class="stl-gauge__track">
                <div class="stl-gauge__band stl-gauge__band--centipede"
                     style="left: <?php echo $cenBand['left']; ?>%; width: <?php echo $cenBand['width']; ?>%;">
                    <span class="stl-gauge__band-label">Centipede 5.0&ndash;6.0</span>
                </div>
                <div class="stl-gauge__band stl-gauge__band--turf"
                     style="left: <?php echo $turfBand['left']; ?>%; width: <?php echo $turfBand['width']; ?>%;">
                    <span class="stl-gauge__band-label">Most turf 6.0&ndash;7.0</span>
                </div>
                <div class="stl-gauge__marker" style="left: <?php echo $clayMark; ?>%;">
                    <span class="stl-gauge__marker-flag">Untreated Upstate clay &asymp; 5.0&ndash;5.5</span>
                </div>
            </div>
            <div class="stl-gauge__ticks">
                <?php foreach ($phTicks as $t): ?>
                    <div class="stl-gauge__tick" style="left: <?php echo $phPct($t); ?>%;">
                        <span class="stl-gauge__tick-label"><?php echo e(number_format($t, 1)); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="stl-ph__callouts">
            <div class="stl-callout reveal-left reveal-delay-2">
                <div class="stl-callout__head">
                    <i data-lucide="arrow-down-left" aria-hidden="true"></i>
                    <h3>Below about pH 5.5</h3>
                </div>
                <p>
                    Phosphorus binds up and becomes less available, while aluminium turns soluble enough
                    to injure roots. The nutrients are in the soil but locked, so fertilizer applied here
                    is substantially wasted until the pH is corrected.
                </p>
            </div>
            <div class="stl-callout reveal-right reveal-delay-2">
                <div class="stl-callout__head">
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                    <h3>Above the target band</h3>
                </div>
                <p>
                    Push the pH too high and iron and manganese lock up, yellowing the turf between its
                    veins. Over-liming is much harder to reverse than under-liming — the reason the rate
                    always comes from a test, never from the season.
                </p>
            </div>
        </div>
    </div>

    <!-- Divider 3 — double wave, filled with the breakdown section's light background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN + PROCESS ══════════ -->
<section class="stl-breakdown" aria-label="What soil testing and lime application includes">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What does Greenville Lawn Masters soil testing and lime application include?</h2>
            <p class="answer-block">
                Greenville Lawn Masters soil testing and lime application includes core sampling from
                multiple zones, laboratory analysis of pH and nutrients, interpretation against the
                grass you grow, lime applied at the rate and type the test calls for, and a later
                retest. The reading drives every step, so nothing is spread on assumption.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="stl-includes">
            <?php foreach ($included as $i => $inc): ?>
                <article class="stl-include <?php echo ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="stl-include__icon">
                        <i data-lucide="<?php echo e($inc['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <h3><?php echo e($inc['title']); ?></h3>
                    <p><?php echo e($inc['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does a soil testing and lime job actually work?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            A soil job starts with a free walkthrough and a written estimate within 24 hours. Composite
            cores are pulled by zone and submitted for analysis. Results are read against your grass and
            Upstate clay, the right lime goes down at the tested rate, and the soil is retested later to
            confirm the pH moved toward target.
        </p>

        <div class="stl-process">
            <?php foreach ($timeline as $i => $step): ?>
                <div class="stl-step <?php echo ['reveal-up', 'reveal-down', 'reveal-scale', 'reveal-up', 'reveal-down'][$i % 5]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="stl-step__phase"><?php echo e($step['phase']); ?></span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider — diagonal, filled with the proof section's dark background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-dark)" points="0,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · PROOF ══════════ -->
<?php /* PHOTO GAP ($media['photo_gap'] === true): the library has NO frame showing a soil probe,
         test kit, core, spreader, or lime going down. Every photo here is a finished property or a
         mowing shot. So captions describe ONLY what is in frame — established Mauldin lawns the crew
         maintains — and never imply soil work. The honest .photo-note disclosure below (shared
         framework.css class) states this in plain language, gated on the photo_gap flag. Reviews:
         config.php $reviews is empty, so a static honesty note stands in rather than invented stars. */ ?>
<section class="stl-proof" aria-label="Greenville Lawn Masters Mauldin lawn photography">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Result</span>
            <h2>What do healthy Mauldin lawns say about their soil?</h2>
            <p class="answer-block">
                Every photograph below is a finished Mauldin-area lawn the crew maintains — not a picture
                of soil sampling or lime going down. Soil chemistry is invisible, so these frames show
                the result healthy pH supports: dense, evenly fed turf. Documented photography of the
                sampling and liming work will replace them.
            </p>
        </div>

        <div class="stl-proof__grid">
            <?php
            /* Body photos from servicePagePhotos(): front_lawn, backyard, mowing. Captions state the
               frame contents only. The mowing shot shows MOWING, explicitly not soil work — the
               caption says so rather than pretending otherwise. */
            $shots = [
                ['key' => 'front_lawn', 'mod' => '',              'label' => 'Even, well-fed front turf', 'caption' => 'A dense green front lawn at a two-story Mauldin home — the kind of even colour that healthy soil chemistry supports, photographed as a finished result, not a soil test.'],
                ['key' => 'backyard',   'mod' => 'stl-shot--arch', 'label' => 'Turf against bed lines',    'caption' => 'Backyard turf running between mulched beds and a wood privacy fence at a Mauldin home. This is an outcome shot; it does not depict sampling or liming.'],
                ['key' => 'mowing',     'mod' => 'stl-shot--frame','label' => 'On the maintenance route',  'caption' => 'A Greenville Lawn Masters crew member mowing a fenced Mauldin backyard. It shows mowing, not soil work — no photograph here shows a core or a spreader.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="stl-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <?php if (!empty($media['photo_gap'])): ?>
            <?php /* REQUIRED honest disclosure — this page's config entry carries photo_gap => true. */ ?>
            <p class="photo-note reveal-up">
                <i data-lucide="camera-off" aria-hidden="true"></i>
                <span>
                    A note on these photos: no image on this page shows soil sampling or lime being
                    applied. Soil work does not photograph well, and we would rather show honest
                    outcomes than stage a shot. These are established Mauldin lawns the crew already
                    maintains, and real job-site photography of the coring and liming will replace them
                    as it is captured.
                </span>
            </p>
        <?php endif; ?>

        <div class="stl-proof__reviews reveal-up reveal-delay-1">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 6 · COMPARISON ══════════ -->
<section class="stl-compare" aria-label="How Greenville Lawn Masters differs on lime">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates a soil test from guessing at lime?</h2>
            <p class="answer-block">
                A soil test separates a correction from a coin flip. Guess-and-spread lime treats the
                calendar; a test treats the actual pH, buffer capacity, and grass type. The difference
                is whether the lime moves your soil toward target or pushes it past — and past is far
                harder to walk back.
            </p>
        </div>

        <?php /* Left column is common trade practice, not a named competitor. Every right-hand row is
                 a process commitment or a soil-science practice — never a credential or a price. */ ?>
        <div class="stl-compare__table reveal-up reveal-delay-1">
            <div class="stl-compare__head">
                <div>A typical guess-and-spread routine</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="stl-compare__row">
                    <div data-label="A typical guess-and-spread routine">
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
<section class="stl-faq" aria-label="Soil testing and lime questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about soil testing and lime?</h2>
            <p class="answer-block">
                Straight answers on why soil is tested before any lime goes down, how Greenville Lawn
                Masters pulls a sample, the pH range Upstate grasses actually need, whether too much lime
                can damage a lawn, why fertilizer stops working on acidic soil, and where South Carolina
                samples are analysed.
            </p>
        </div>

        <div class="stl-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="stl-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="stl-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does Greenville Lawn Masters handle in Mauldin?</h2>
            <p class="answer-block">
                Soil work is one of <?php echo e((string) count($services)); ?> services Greenville Lawn
                Masters runs across Greenville County. Aeration opens heavy clay so lime reaches the root
                zone, feeding follows once the pH is right, and mowing keeps the corrected lawn honest —
                all handled by the same crew on the same 24-hour estimate.
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
<section class="stl-cta" aria-label="Request a soil assessment">
    <div class="container">
        <h2 class="reveal-up">Ready to find out what your Mauldin soil actually needs?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Fall gives lime months to react before spring green-up, and core aeration first helps it reach
            the root zone through Upstate clay. Book a free walkthrough with Greenville Lawn Masters now,
            and the correction can be timed to the season your soil is actually in, not the date on the
            calendar.
        </p>
        <div class="stl-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Soil Assessment
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
