<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/gutter-cleaning/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page: gutter-cleaning is the only service whose
   config.php `page` is 'gutter-cleaning', so servicesOnPage() returns
   exactly one row and there is no OfferCatalog to build (unlike the
   lawn-care-services group page).

   Nothing here is invented. No prices or ranges, no review quotes,
   no star ratings, no jobs-completed count, no crew size, no
   equipment brands, no guarantee. config.php $reviews is empty and
   intake supplied none of those numbers.

   DELIBERATELY ABSENT — and this matters MORE on a ladder-work page
   than anywhere else in the build: no "licensed", no "insured", no
   "bonded", no liability-coverage figure. Intake supplied none of
   them. A homeowner deciding whether to let a crew up a two-storey
   ladder is exactly the reader most likely to be swayed by an
   insurance claim, so fabricating one here would be the most harmful
   place in the whole site to do it. The honest substitutes are the
   process commitments build-plan.json actually recorded (one crew,
   free walkthrough, written estimate within 24 hours, debris bagged
   and hauled) and checkable facts about Upstate SC gutters. If the
   client later supplies real coverage, add it here — never before.

   PHOTO GAP (config.php $servicePhotos['gutter-cleaning'].photo_gap):
   not one of the six client photographs shows a gutter, a ladder, a
   downspout, or gutter work — every frame is a finished ground-level
   property. The proof section therefore captions the two real photos
   as the KIND of Mauldin homes the crew maintains, never as gutter
   work, and renders the shared .photo-note disclosure so the gap is
   stated out loud rather than papered over. See section 6 below.
   ============================================================ */

$pageSlug    = 'gutter-cleaning';
$currentPage = 'services';

$service = servicesOnPage($pageSlug)[0];      // the single Gutter Cleaning row
$media   = servicePagePhotos($pageSlug);      // hero=driveway, body=[driveway, front_lawn], photo_gap=true
$heroImg = heroPhoto($media['hero']);         // hero-mauldin-clean-driveway.jpg (1600px rendition)

$pageTitle       = 'Gutter Cleaning in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Gutter cleaning in Mauldin, SC. Troughs cleared by hand, downspouts flushed and checked, debris bagged and hauled off. Written estimate in 24 hours.';   // 148 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

/* Phone was empty at intake. formatPhone()/phoneHref() return '' for anything
   that is not a real US 10-digit number, so $hasPhone is the single guard that
   decides whether a tel: button renders at all — a placeholder number on a
   live local-business page is worse than a visibly missing one. */
$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Telltale signs (section 2) ───────────────────────────────
   Symptoms a Mauldin homeowner can verify from the ground in a storm or a
   walk around the house, each tied to the mechanical cause. Tints rotate so no
   two adjacent bento cards share a background. */
$signs = [
    ['icon' => 'cloud-rain',  'title' => 'Water sheets over the edge',   'body' => 'In a hard Piedmont downpour, water pouring over the front lip in a curtain — instead of running to the downspout — is the clearest sign the trough is packed and overflowing.'],
    ['icon' => 'sprout',      'title' => 'Seedlings in the trough',      'body' => 'Grass, maple seedlings, or moss growing along the gutter line means enough soil and rotting leaf litter has collected up there to hold a garden. That debris is holding water against the roof edge.'],
    ['icon' => 'droplet',     'title' => 'Stains streaking the fascia',  'body' => 'Dark vertical streaks or tiger-striping down the fascia and behind the gutter are dirty water finding its way over and behind a clogged trough instead of through it.'],
    ['icon' => 'bug',         'title' => 'Mosquitoes near the eaves',    'body' => 'Standing water trapped in a blocked trough breeds mosquitoes within days and adds dead weight that slowly pulls the gutter loose from the fascia board.'],
];

/* ── Water-path anatomy (section 3, the signature diagram) ────
   The four failure points the cutaway calls out, in the order water meets
   them on the way down. Legend copy pairs with the numbered markers drawn
   into the SVG so number 1 in the drawing is number 1 in the list. */
$failPoints = [
    ['n' => '1', 'title' => 'Overflow at the lip',         'body' => 'When the trough fills, water spills over the outer lip in a sheet instead of reaching the downspout — and it lands right against the base of the wall.'],
    ['n' => '2', 'title' => 'Standing water, wrong pitch', 'body' => 'A gutter should slope slightly toward the downspout. Water still sitting in the trough after it drains means the pitch is off or a hanger has sagged.'],
    ['n' => '3', 'title' => 'A clog in the elbow',          'body' => 'The downspout can look clear from the ground and still be packed solid at the elbow. Nothing leaves the trough until the elbow runs free.'],
    ['n' => '4', 'title' => 'Discharge at the foundation',  'body' => 'Even a clear downspout fails if it dumps at the base of the wall. The water has to be carried away from the house, not pooled against it.'],
];

/* ── What a gutter cleaning includes (section 4) ─────────────*/
$includes = [
    ['icon' => 'hand',        'title' => 'Troughs cleared by hand',    'body' => 'Every run is cleared by hand along its length, not just blown from one end — the packed, wet debris at the low corners is what a blower leaves behind.'],
    ['icon' => 'waves',       'title' => 'Downspouts flushed through',  'body' => 'Each downspout is flushed until water runs clear at the discharge, so a clog hiding in the elbow does not survive the visit.'],
    ['icon' => 'ruler',       'title' => 'Pitch and standing water checked', 'body' => 'While the ladder is up, the crew notes any standing water, sagging pitch, or loose hanger — the things you cannot see from the ground.'],
    ['icon' => 'trash-2',     'title' => 'Debris bagged and hauled',    'body' => 'The debris comes off the roof, into bags, and off the property — never blown into the beds below the eave to wash back in.'],
    ['icon' => 'sparkles',    'title' => 'Ground left clean',            'body' => 'Walks, drive, and beds under the work area are cleared down before the crew leaves, so the only sign anyone was there is a gutter that drains.'],
];

/* ── Process / timeline (section 4) ──────────────────────────*/
$timeline = [
    ['phase' => 'Step 1',     'title' => 'Free walkthrough',        'body' => 'The crew walks the full run of gutters, counts the downspouts, and checks access — the number of storeys and the pitch of the roof set how the work is done and are looked at before anything is quoted.'],
    ['phase' => 'Within 24h', 'title' => 'Written estimate',        'body' => 'An itemised estimate lands within a day of the walkthrough. You see the scope in writing — every run and every downspout — before any work is scheduled, not a number guessed over the phone.'],
    ['phase' => 'Cleaning day','title' => 'Clear, flush, verify',   'body' => 'Troughs are cleared by hand, downspouts flushed until they run clear, and pitch and standing water noted. Debris is bagged as the crew works rather than raining into the beds.'],
    ['phase' => 'Before we go','title' => 'Walk and report',        'body' => 'The ground gets cleared, and you hear anything worth knowing — a sagging hanger, a downspout dumping at the foundation, a run under heavy pine that will need looking at again sooner.'],
];

/* ── Comparison (section 7) ───────────────────────────────────
   Left column is common trade practice, NOT a named competitor. Every
   right-hand row is a process commitment intake recorded or a maintenance
   practice we perform — never a credential, and never an insurance claim. */
$comparison = [
    ['them' => 'Leaves blown off the roof and left in the beds below',        'us' => 'Every trough cleared by hand, debris bagged and hauled off the property'],
    ['them' => 'Only the visible trough scooped, downspouts left alone',      'us' => 'Each downspout flushed until water runs clear at the discharge'],
    ['them' => 'No check that water actually leaves the foundation',          'us' => 'Discharge checked so water is carried away from the wall, not against it'],
    ['them' => 'Standing water and sagging pitch ignored',                    'us' => 'Pitch, hangers, and standing water noted while the ladder is up'],
    ['them' => 'Whoever is free that day, if they show',                      'us' => 'The same one crew that maintains the rest of the property'],
    ['them' => 'A number quoted over the phone by roof size',                 'us' => 'Walked first, then a written, itemised estimate within 24 hours'],
];

/* ── FAQs — conversational, 40-80 words (aeo-content-schema §2.4) ──
   Rendered visibly below AND passed verbatim to generateFAQSchema(); schema
   that does not mirror visible copy is a guidelines violation. Each answer
   opens with the full company name (chunk-level rule) and carries no price:
   none was supplied, and an invented range amplified through FAQPage schema
   is a misrepresentation to Google, not a placeholder. */
$faqs = [
    [
        'question' => 'How much does gutter cleaning cost in Mauldin, SC?',
        'answer'   => 'Greenville Lawn Masters prices every gutter cleaning after walking the house, because the length of the runs, the number of downspouts, the roof pitch, and how many storeys the crew has to reach all move the number. The walkthrough is free and the written, itemised estimate arrives within 24 hours, so you approve the scope before any ladder goes up.',
    ],
    [
        'question' => 'How often should gutters be cleaned in the Upstate?',
        'answer'   => 'Greenville Lawn Masters generally recommends twice a year for most Greenville County homes — once after leaf drop in late fall, and again after spring seed and pollen. Under heavy tree canopy the cadence climbs. Pines are the worst offenders, shedding needles year-round, so a house tucked under them can need three or four visits to stay ahead of the clog.',
    ],
    [
        'question' => 'Why do clogged gutters matter so much on a Greenville County home?',
        'answer'   => 'Greenville Lawn Masters sees the damage start at the foundation. When a clogged trough overflows, the water lands against the wall, and Mauldin sits on heavy Piedmont clay that swells and drains slowly. That means saturated soil pressing on the crawl space or basement, plus eroded beds and mulch on the strip of ground the overflow keeps hitting.',
    ],
    [
        'question' => 'Do you clean the downspouts too, or just the gutters?',
        'answer'   => 'Greenville Lawn Masters flushes every downspout as part of the cleaning, not just the open troughs. A downspout can look perfectly clear from the ground and still be packed solid at the elbow, where the debris settles. The crew runs water through each one until it discharges clear, because a spotless trough that cannot drain has not actually been fixed.',
    ],
    [
        'question' => 'There is water standing in my gutter after it rains — is that a problem?',
        'answer'   => 'Greenville Lawn Masters treats standing water as a signal worth checking. A gutter is meant to slope slightly toward the downspout, so water left sitting in the trough after a rain usually means the pitch has drifted or a hanger has sagged. The crew flags it while the ladder is up so you know whether it is a clog to clear or an alignment issue to watch.',
    ],
    [
        'question' => 'I have gutter guards — do I still need them cleaned?',
        'answer'   => 'Greenville Lawn Masters still services homes with gutter guards, because guards reduce maintenance, they do not end it. Fine grit, shingle granules, pollen, and pine needles work past or pile on top of most guard systems over time, and a guard that traps debris on its surface can shed water right over the edge. They stretch the interval; they do not replace the visit.',
    ],
    [
        'question' => 'Can you clean the gutters on a two-story house?',
        'answer'   => 'Greenville Lawn Masters checks access and roof pitch during the free walkthrough, because the number of storeys and the steepness set how the work is safely done. Ladder work carries real fall risk, and wet or steep roofs are handled with extra care. If a run cannot be reached safely, the crew tells you plainly rather than forcing it — that is why the property is walked before anything is quoted.',
    ],
];

/* ── Schema ───────────────────────────────────────────────────
   Exactly four nodes (per build prompt):
     (a) Service (@id #service-gutter-cleaning), provider → homepage @id,
         areaServed from $serviceAreas. No `offers` / `priceRange`: intake
         supplied no pricing and fabricated structured pricing is a
         misrepresentation Google acts on. No OfferCatalog — this is a solo
         service, not a group, so there is nothing to catalog.
     (b) FAQPage mirroring the visible FAQ.
     (c) BreadcrumbList (Home › Services › Gutter Cleaning).
     (d) WebPage with Speakable; every cssSelector below exists in the markup. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $pageSlug,
        'name'        => 'Gutter Cleaning',
        'serviceType' => 'Gutter cleaning and downspout flushing',
        'description' => 'Gutter cleaning in Mauldin, South Carolina: troughs cleared by hand, '
                       . 'downspouts flushed until they run clear, pitch and standing water checked, '
                       . 'and all debris bagged and hauled off the property.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',            'url' => '/'],
        ['name' => 'Services',        'url' => '/services/'],
        ['name' => 'Gutter Cleaning', 'url' => '/services/' . $pageSlug . '/'],
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
   Gutter Cleaning — page-scoped styles
   Every rule prefixed .gc- so no class collides with another page's
   <style> block. Colour, shadow, spacing, radius, and timing are var()
   tokens without exception — a raw hex/px literal for those is an
   automatic QA fail. Small geometric px (icon sizes, hairline borders,
   marker positioning, and the anatomy-diagram geometry) are the only
   raw numbers used, matching the reference page's discipline.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  three distinct SVG dividers (peak, diagonal, double wave)
     C4  editorial pull-quote
     C5  bento grid of telltale signs, deliberately uneven spans
     C6  asymmetric 62/38 split with an oversized stat watermark
     C7  SIGNATURE — the water-path anatomy cutaway (this page only)
     C10 comparison table with accent-highlighted winning column
     C11 image treatments — arch clip and offset frame
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Background photo is the clean-driveway frame (also used by the
   pressure-washing page). The overlay is intentionally DISTINCT from that
   page: a steep 165deg wash — dark at the top-left, brand green pooling at
   the lower-right — reading as water running DOWN the frame. The angle also
   differs from the lawn-care hero (78deg) and the homepage hero (100deg), so
   no two heroes read as the same treatment of the same shot. */
.gc-hero {
  min-height: 78vh;
  min-height: 78svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-clean-driveway.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.gc-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    165deg,
    rgba(var(--color-dark-rgb), 0.92) 0%,
    rgba(var(--color-dark-rgb), 0.74) 34%,
    rgba(var(--color-primary-rgb), 0.52) 72%,
    rgba(var(--color-primary-rgb), 0.28) 100%
  );
  z-index: 0;
}
.gc-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.gc-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.gc-hero .breadcrumb { animation: gcFade 0.5s ease both; }

.gc-hero__eyebrow {
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
  animation: gcFade 0.55s ease 0.08s both;
}
.gc-hero__eyebrow i, .gc-hero__eyebrow svg { width: 15px; height: 15px; }

.gc-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: gcRise 0.6s ease 0.16s both;
}
.gc-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; in a left-aligned hero it must not. */
.gc-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: gcRise 0.6s ease 0.26s both;
}

.gc-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: gcRise 0.6s ease 0.36s both;
}
.gc-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: gcRise 0.6s ease 0.46s both;
}
.gc-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.gc-hero__trust i, .gc-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS @keyframes, never a reveal-* class — the
   reveal system sets opacity:0 and would blank the hero if the observer
   never fired. Below the fold, reveals are safe and used freely. */
@keyframes gcFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes gcRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.gc-problem { background: var(--color-light); }
.gc-problem__layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: var(--space-12);
  align-items: start;
}
.gc-problem__quote {
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
.gc-problem__lead { color: var(--color-gray-dark); }
.gc-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Deliberately uneven: the first card spans two columns so the row does not
   read as four identical boxes. Tints rotate; no two adjacent cards match. */
.gc-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.gc-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.gc-sign:first-child { grid-column: span 2; }
.gc-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.gc-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.gc-sign__icon i, .gc-sign__icon svg { width: 22px; height: 22px; }
.gc-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.gc-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C7 · SIGNATURE: the water-path anatomy cutaway ───────────
   Used on this page only. A vertical cutaway of a raindrop's route — roof
   plane, trough, downspout, elbow, discharge — with four numbered failure
   points drawn straight into the SVG so the legend numbers always align.
   Nothing else in the build looks remotely like this. */
.gc-anatomy { background: var(--color-white); }
.gc-anatomy__layout {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: var(--space-16);
  align-items: center;
  margin-top: var(--space-12);
}
.gc-anatomy__figure {
  position: relative;
  background: var(--color-light);
  border-radius: var(--radius-xl);
  padding: var(--space-8);
  box-shadow: var(--shadow-card);
}
.gc-anatomy__figure svg { display: block; width: 100%; height: auto; }
.gc-anatomy__caption {
  margin-top: var(--space-4);
  text-align: center;
  font-size: var(--font-size-xs);
  color: var(--color-gray);
  font-style: italic;
}
/* Numbered failure-point legend, paired with the SVG markers by number */
.gc-fail { list-style: none; display: grid; gap: var(--space-5); margin-top: var(--space-6); }
.gc-fail__item {
  display: grid;
  grid-template-columns: 42px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.gc-fail__num {
  width: 42px; height: 42px;
  display: grid; place-items: center;
  border-radius: var(--radius-full);
  background: var(--color-primary);
  color: var(--color-white);
  font-family: var(--font-heading);
  font-weight: 800;
  font-size: var(--font-size-lg);
  box-shadow: var(--shadow-sm);
}
.gc-fail__item:nth-child(2) .gc-fail__num { background: var(--color-accent); }
.gc-fail__item:nth-child(3) .gc-fail__num { background: var(--color-secondary); }
.gc-fail__item:nth-child(4) .gc-fail__num { background: var(--color-primary-dark); }
.gc-fail__body strong {
  display: block;
  color: var(--color-primary-dark);
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  margin-bottom: var(--space-1);
}
.gc-fail__body p { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.gc-expert { background: var(--color-light); }
.gc-expert__layout {
  display: grid;
  grid-template-columns: 0.62fr 1.38fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.gc-stat-watermark {
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
.gc-stat-watermark span {
  position: absolute;
  left: 0.06em;
  bottom: -1.9em;
  font-size: var(--font-size-sm);
  font-family: var(--font-body);
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  opacity: 1;
  color: var(--color-primary-dark);
  max-width: 12ch;
  line-height: 1.4;
}
.gc-expert h2 { margin-bottom: var(--space-5); }
.gc-expert .answer-block { margin-inline: 0; }
.gc-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.gc-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.gc-diff i, .gc-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.gc-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.gc-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── Service breakdown grid (what a cleaning includes) ────────*/
.gc-breakdown { background: var(--color-white); }
.gc-includes {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-5);
}
/* The fourth and fifth cards centre under the first three rather than
   stranding two lonely boxes left-aligned in a new row. */
.gc-include {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-light);
  border-top: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.gc-include:hover {
  transform: translateY(-5px);
  border-top-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.gc-include__icon {
  width: 48px; height: 48px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
}
.gc-include__icon i, .gc-include__icon svg { width: 24px; height: 24px; }
.gc-include h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.gc-include p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray-dark); line-height: 1.6; }

/* ── Process rail (the visit, step by step) ──────────────────
   A single accent line threads the four steps; each marker sits on the line.
   Distinct from the anatomy cutaway above — this is a timeline, that is a
   cross-section. */
.gc-rail { position: relative; margin-top: var(--space-16); padding-left: var(--space-12); }
.gc-rail::before {
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
.gc-rail__step { position: relative; padding-bottom: var(--space-10); }
.gc-rail__step:last-child { padding-bottom: 0; }
.gc-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 6px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-white);
}
.gc-rail__phase {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.gc-rail__step h3 { font-size: var(--font-size-xl); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.gc-rail__step p { margin: 0; max-width: 62ch; color: var(--color-gray-dark); line-height: 1.7; }

/* ── C11 · Proof strip, arch and offset frame treatments ──────
   Two photos only — the frame does not show gutter work (photo gap), so
   the layout is built for a pair, centred, never padded out with a third. */
.gc-proof { background: var(--color-dark); }
.gc-proof h2, .gc-proof .gc-eyebrow { color: var(--color-white); }
.gc-proof .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.gc-proof__grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--space-8);
  max-width: 56rem;
  margin: var(--space-12) auto 0;
}
.gc-shot { margin: 0; }
.gc-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
/* C11 arch clip on the first frame only — variation, not decoration for its own sake */
.gc-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.gc-shot--frame { position: relative; }
.gc-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.gc-shot:hover img { transform: scale(1.03); }
.gc-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.gc-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }

/* Photo-gap disclosure uses the SHARED .photo-note class (framework.css); the
   only page-local job is to invert its palette for the dark proof section. */
.gc-proof .photo-note {
  border-left-color: rgba(var(--color-white-rgb), 0.25);
  color: rgba(var(--color-white-rgb), 0.7);
}
.gc-proof .photo-note i, .gc-proof .photo-note svg { color: var(--color-accent); }

.gc-proof__note {
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
.gc-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.gc-compare { background: var(--color-white); }
.gc-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.gc-compare__head, .gc-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.gc-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.gc-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.gc-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.gc-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.gc-compare__row > div:first-child { color: var(--color-gray); }
.gc-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.gc-compare__row i, .gc-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.gc-compare__row > div:first-child i, .gc-compare__row > div:first-child svg { color: var(--color-gray); }
.gc-compare__row > div:last-child i,  .gc-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.gc-faq { background: var(--color-light); }
.gc-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.gc-faq__item {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.gc-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.gc-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.gc-related { background: var(--color-white); }

/* ── Final CTA ────────────────────────────────────────────────*/
.gc-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.gc-cta::before {
  content: '';
  position: absolute;
  top: -20%; right: -8%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.gc-cta .container { position: relative; z-index: 1; }
.gc-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.gc-cta .answer-block { color: rgba(var(--color-white-rgb), 0.88); max-width: 60ch; margin: 0 auto var(--space-8); }
.gc-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .gc-includes { grid-template-columns: repeat(2, 1fr); }
  .gc-signs { grid-template-columns: repeat(2, 1fr); }
  .gc-sign:first-child { grid-column: span 2; }
  .gc-anatomy__layout { grid-template-columns: 1fr; gap: var(--space-10); }
  .gc-anatomy__figure { max-width: 26rem; margin-inline: auto; }
  .gc-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .gc-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .gc-stat-watermark span { position: static; display: block; margin-top: var(--space-6); max-width: none; }
  .gc-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .gc-problem__quote { max-width: none; }
}
@media (max-width: 700px) {
  .gc-hero { min-height: 0; }
  .gc-includes, .gc-signs, .gc-proof__grid { grid-template-columns: 1fr; }
  .gc-sign:first-child { grid-column: span 1; }
  .gc-shot--frame::before { display: none; }

  /* The comparison grid collapses to stacked pairs. Column headers hide and
     each cell carries its own label, or the them/us contrast is lost. */
  .gc-compare__head { display: none; }
  .gc-compare__row { grid-template-columns: 1fr; }
  .gc-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .gc-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero gc-hero" aria-label="Gutter cleaning in Mauldin, South Carolina">
    <div class="container">
        <div class="gc-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Gutter Cleaning</span></li>
                </ol>
            </nav>

            <span class="gc-hero__eyebrow">
                <i data-lucide="cloud-rain" aria-hidden="true"></i>
                Gutter Cleaning &middot; Mauldin, SC
            </span>

            <h1>Gutter Cleaning in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters clears clogged gutters for homes in Mauldin, South Carolina and
                within 25 miles across Greenville County — troughs cleared by hand, every downspout
                flushed until it runs clear, and all the debris bagged and hauled off. The property is
                walked first, and the written estimate arrives within 24 hours.
            </p>

            <div class="gc-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Gutter Estimate
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
                     no star rating, no job count — config.php has none of the three, and
                     an insurance claim is especially not asserted on a ladder-work page. */ ?>
            <div class="gc-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="users" aria-hidden="true"></i> One crew for the whole property</span>
                <span><i data-lucide="calendar-days" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider — peaked edge, filled with the problem section's light background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,40 L60,42 L120,35 L200,45 L280,32 L360,48 L440,38 L540,45 L640,30 L740,42 L840,35 L940,45 L1040,32 L1140,42 L1200,38 L1200,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · PROBLEM STATEMENT ══════════ -->
<section class="gc-problem" aria-label="Signs a Mauldin home has clogged gutters">
    <div class="container">
        <div class="gc-problem__layout">
            <blockquote class="gc-problem__quote reveal-left">
                A clogged gutter doesn't leak on the roof. It leaks on the foundation.
            </blockquote>

            <div class="gc-problem__lead">
                <h2 class="reveal-right">What are the early warning signs of a clogged gutter in Mauldin?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    The early signs of a clogged gutter in Mauldin are visible from the ground: water
                    sheeting over the front edge in a storm, grass or seedlings sprouting in the trough,
                    dark stains streaking down the fascia, and mosquitoes gathering near the eaves. Each
                    one means debris is holding water where it should be moving it toward the downspout.
                </p>
                <p class="reveal-right reveal-delay-2">
                    None of it fixes itself with one dry week. The debris that clogs an Upstate gutter —
                    oak and maple leaf litter, samaras, and year-round pine needles — packs down wet and
                    heavy, and the longer it sits the more it pulls the trough off its pitch and traps
                    standing water against the roof edge.
                </p>
            </div>
        </div>

        <div class="gc-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="gc-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="gc-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · SIGNATURE — WATER-PATH ANATOMY ══════════ -->
<?php /* The signature section, unique to this page. A CSS/SVG cutaway follows a
         raindrop from the roof plane to the beds, with the four points where a
         clogged gutter fails drawn in as numbered markers that pair with the
         legend list beside them. */ ?>
<section class="gc-anatomy" aria-label="How a clogged gutter fails, stage by stage">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label gc-eyebrow">Follow the Water</span>
            <h2>Where does rainwater actually fail when a <span class="text-accent">gutter clogs</span>?</h2>
            <p class="answer-block">
                Rainwater fails a clogged gutter at four points on its way down: it overflows the lip
                instead of reaching the downspout, sits in a trough that has lost its pitch, jams at the
                downspout elbow, and — even when the pipe is clear — discharges right at the foundation.
                Greenville Lawn Masters clears all four, not just the visible trough.
            </p>
        </div>

        <div class="gc-anatomy__layout">
            <figure class="gc-anatomy__figure reveal-left">
                <!-- Cross-section: roof plane → trough → downspout → elbow → discharge.
                     Geometry is raw px inside the SVG (permitted); every fill is a var()
                     token. Numbered circles 1-4 match the legend list to the right. -->
                <svg viewBox="0 0 360 500" role="img" aria-label="Cutaway diagram of rainwater running off a roof, through a gutter and downspout, to the ground, with four numbered failure points.">
                    <!-- sky / section backdrop stays transparent -->

                    <!-- house wall (right) -->
                    <rect x="256" y="150" width="104" height="300" fill="var(--color-gray-light)"/>
                    <!-- foundation strip at the base of the wall -->
                    <rect x="256" y="430" width="104" height="20" fill="var(--color-secondary)"/>

                    <!-- roof plane, sloping down toward the eave at right -->
                    <polygon points="8,118 300,150 300,176 8,144" fill="var(--color-secondary)"/>
                    <!-- shingle score lines -->
                    <line x1="60" y1="129" x2="60" y2="152" stroke="var(--color-dark)" stroke-width="1.5" opacity="0.35"/>
                    <line x1="130" y1="136" x2="130" y2="159" stroke="var(--color-dark)" stroke-width="1.5" opacity="0.35"/>
                    <line x1="200" y1="143" x2="200" y2="166" stroke="var(--color-dark)" stroke-width="1.5" opacity="0.35"/>

                    <!-- gutter trough hanging at the eave (U channel) -->
                    <path d="M244,150 L244,182 Q244,192 254,192 L312,192 Q322,192 322,182 L322,150"
                          fill="none" stroke="var(--color-primary)" stroke-width="5" stroke-linecap="round"/>
                    <!-- debris + trapped water sitting in the trough -->
                    <path d="M250,178 L250,184 Q250,188 254,188 L312,188 Q316,188 316,184 L316,178 Z" fill="var(--color-accent)" opacity="0.55"/>
                    <circle cx="266" cy="176" r="5" fill="var(--color-primary-dark)" opacity="0.7"/>
                    <circle cx="288" cy="178" r="6" fill="var(--color-primary-dark)" opacity="0.7"/>
                    <circle cx="306" cy="176" r="4" fill="var(--color-primary-dark)" opacity="0.7"/>

                    <!-- downspout down the wall face -->
                    <rect x="300" y="192" width="16" height="228" fill="var(--color-primary)"/>
                    <!-- elbow kicking out at the bottom -->
                    <path d="M300,420 L316,420 L316,432 Q316,444 304,444 L280,444 L280,430 L300,430 Z" fill="var(--color-primary)"/>

                    <!-- ground / soil band -->
                    <rect x="0" y="450" width="360" height="50" fill="var(--color-primary-dark)" opacity="0.85"/>
                    <!-- mulch bed texture under the eave -->
                    <path d="M120,458 q10,-6 20,0 q10,-6 20,0 q10,-6 20,0 q10,-6 20,0" fill="none" stroke="var(--color-accent)" stroke-width="2" opacity="0.5"/>

                    <!-- raindrop route: roof → trough → downspout → discharge (dashed accent) -->
                    <path d="M30,128 L296,158 L308,190 L308,420 L296,442 L262,452"
                          fill="none" stroke="var(--color-accent)" stroke-width="3" stroke-dasharray="6 6" stroke-linecap="round" opacity="0.9"/>
                    <!-- overflow spill over the outer lip toward the foundation (danger dashed) -->
                    <path d="M320,160 Q332,250 316,428" fill="none" stroke="var(--color-danger)" stroke-width="3" stroke-dasharray="4 7" stroke-linecap="round" opacity="0.85"/>

                    <!-- numbered failure markers -->
                    <g font-family="var(--font-heading)" font-weight="800" font-size="15" fill="var(--color-white)" text-anchor="middle">
                        <circle cx="336" cy="150" r="14" fill="var(--color-primary)"/>
                        <text x="336" y="155">1</text>
                        <circle cx="228" cy="182" r="14" fill="var(--color-accent)"/>
                        <text x="228" y="187">2</text>
                        <circle cx="300" cy="410" r="14" fill="var(--color-secondary)"/>
                        <text x="300" y="415">3</text>
                        <circle cx="250" cy="462" r="14" fill="var(--color-primary-dark)"/>
                        <text x="250" y="467">4</text>
                    </g>
                </svg>
                <figcaption class="gc-anatomy__caption">
                    Cross-section of a roof edge — the four points a clogged gutter fails, in the order water reaches them.
                </figcaption>
            </figure>

            <div class="reveal-right">
                <ol class="gc-fail">
                    <?php foreach ($failPoints as $i => $fp): ?>
                        <li class="gc-fail__item reveal-up reveal-delay-<?php echo ($i % 4) + 1; ?>">
                            <span class="gc-fail__num" aria-hidden="true"><?php echo e($fp['n']); ?></span>
                            <div class="gc-fail__body">
                                <strong><?php echo e($fp['title']); ?></strong>
                                <p><?php echo e($fp['body']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ 4 · EXPERT POSITIONING ══════════ -->
<section class="gc-expert" aria-label="Why gutter cleaning matters more on Upstate clay">
    <div class="container">
        <div class="gc-expert__layout">

            <div class="gc-stat-watermark reveal-left" aria-hidden="true">
                2&times;<span>Cleanings a year under Upstate canopy</span>
            </div>

            <div>
                <h2 class="reveal-right">Why do clogged gutters do more damage on Upstate clay soil?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Clogged gutters do more damage here because of what is under the house. When an
                    overflowing trough dumps water at the foundation, Mauldin's heavy Piedmont clay
                    swells and drains slowly, so the moisture lingers against the crawl space or basement
                    wall instead of soaking away. The gutter is a small problem; the saturated clay is a
                    slow, expensive one.
                </p>

                <ul class="gc-diffs">
                    <li class="gc-diff reveal-right reveal-delay-2">
                        <i data-lucide="waves" aria-hidden="true"></i>
                        <div>
                            <strong>Downspouts flushed, not just troughs scooped</strong>
                            <p>
                                A cleaning that stops at the open trough misses the clog that matters most —
                                the one packed into the downspout elbow. Every downspout is flushed through
                                until it runs clear at the discharge.
                            </p>
                        </div>
                    </li>
                    <li class="gc-diff reveal-right reveal-delay-3">
                        <i data-lucide="trash-2" aria-hidden="true"></i>
                        <div>
                            <strong>Debris bagged and hauled, not blown into the beds</strong>
                            <p>
                                Debris blown off the roof into the beds below just washes back toward the
                                downspouts in the next storm. It comes off the property instead, and the
                                ground under the work area is cleared before the crew leaves.
                            </p>
                        </div>
                    </li>
                    <li class="gc-diff reveal-right reveal-delay-4">
                        <i data-lucide="users" aria-hidden="true"></i>
                        <div>
                            <strong>One crew that already knows the property</strong>
                            <p>
                                The people clearing your gutters are the same crew that maintains the rest
                                of the property — so they already know which corner never drains and which
                                run sits under the pines that need looking at more often.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ 5 · SERVICE BREAKDOWN + PROCESS ══════════ -->
<section class="gc-breakdown" aria-label="What a gutter cleaning includes">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What does a <span class="text-accent">Greenville Lawn Masters</span> gutter cleaning include?</h2>
            <p class="answer-block">
                A Greenville Lawn Masters gutter cleaning includes clearing every trough by hand,
                flushing each downspout until it runs clear, checking the pitch and any standing water
                while the ladder is up, and bagging and hauling all the debris off the property — with
                the ground left clean before the crew leaves.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="gc-includes">
            <?php foreach ($includes as $i => $item): ?>
                <article class="gc-include <?php echo ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="gc-include__icon">
                        <i data-lucide="<?php echo e($item['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <h3><?php echo e($item['title']); ?></h3>
                    <p><?php echo e($item['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does a gutter cleaning visit actually work?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            A gutter cleaning visit starts with a free walkthrough — the crew counts the downspouts and
            checks access and roof pitch — followed by a written, itemised estimate within 24 hours. On
            cleaning day the troughs are cleared, the downspouts flushed, and the ground swept before
            anyone leaves, with anything worth watching flagged for you.
        </p>

        <ol class="gc-rail">
            <?php foreach ($timeline as $i => $step): ?>
                <li class="gc-rail__step reveal-left reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="gc-rail__phase"><?php echo e($step['phase']); ?></span>
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

<!-- ══════════ 6 · PROOF ══════════ -->
<?php /* PHOTO GAP. Not one of the six client photographs shows a gutter, a
         downspout, a ladder, or gutter work — every frame is a finished
         ground-level property. So this section does two honest things at once:
         it shows the TWO real photos config.php assigns to this page (driveway,
         front_lawn) captioned strictly as the KIND of Mauldin homes the crew
         maintains — never as gutter work — and it renders the shared .photo-note
         disclosure, gated on the photo_gap flag, that says so in plain words.
         config.php $reviews is empty, so the second note explains the missing
         reviews rather than inventing testimonials (an FTC problem, not a gap). */ ?>
<section class="gc-proof" aria-label="Mauldin properties Greenville Lawn Masters maintains">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label gc-eyebrow">The Homes We Keep Up</span>
            <h2>What kind of Mauldin properties does the crew look after?</h2>
            <p class="answer-block">
                Greenville Lawn Masters looks after everyday Mauldin homes — two-story houses on
                Piedmont lots with the kind of tree cover that fills a gutter twice a year. The photos
                below are real properties the crew maintains, shown honestly for what they are: the
                houses whose gutters this service keeps draining.
            </p>
        </div>

        <div class="gc-proof__grid">
            <?php
            /* Two photos only — designed for a pair, never padded to three. Captions
               describe WHAT IS IN THE FRAME (a driveway, a front lawn) and note these
               are the kinds of properties serviced. Neither caption, nor the alt text
               pulled from config.php, claims any image shows a gutter or gutter work. */
            $shots = [
                ['key' => 'driveway',   'mod' => 'gc-shot--arch',  'label' => 'A two-story Mauldin home',      'caption' => 'A clean driveway and walk leading up to a two-story Mauldin home — the kind of property whose gutters Greenville Lawn Masters keeps clear.'],
                ['key' => 'front_lawn', 'mod' => 'gc-shot--frame', 'label' => 'A maintained Greenville County lot', 'caption' => 'A dense front lawn and drive at a two-story house in a Mauldin neighborhood, one of the properties the crew services top to bottom.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-left', 'reveal-right'][$i % 2];
            ?>
                <figure class="gc-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <?php /* Honest photo-gap disclosure — REQUIRED because $media['photo_gap']
                 is true. Uses the EXISTING shared .photo-note class. Gated on the
                 flag so it disappears the moment real gutter-cleaning photography
                 lands in the library and the flag is removed from config.php. */ ?>
        <?php if (!empty($media['photo_gap'])): ?>
            <p class="photo-note reveal-up">
                <i data-lucide="camera-off" aria-hidden="true"></i>
                <span>
                    A note on these photos: none of them shows gutter work. They are real
                    <?php echo e($address['city']); ?> properties Greenville Lawn Masters maintains, shown
                    for the kind of homes this service keeps up — not for the cleaning itself. Job-site
                    photography of actual gutter cleaning will replace them as the crew documents this work.
                </span>
            </p>
        <?php endif; ?>

        <div class="gc-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 7 · COMPARISON ══════════ -->
<section class="gc-compare" aria-label="How Greenville Lawn Masters cleans gutters">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates a thorough gutter cleaning from a blow-and-go?</h2>
            <p class="answer-block">
                A thorough cleaning moves debris off the property and proves the water drains; a
                blow-and-go just clears what's visible and leaves. The difference shows up in the
                downspouts nobody flushed, the pitch nobody checked, and the pile of leaves left in the
                bed below the eave to wash right back in.
            </p>
        </div>

        <?php /* The left column describes common practice in the trade, not a named
                 competitor. Every right-hand row is a process commitment recorded at
                 intake or a maintenance practice — never a credential claim. */ ?>
        <div class="gc-compare__table reveal-up reveal-delay-1">
            <div class="gc-compare__head">
                <div>A typical blow-and-go clear</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="gc-compare__row">
                    <div data-label="A typical blow-and-go clear">
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

    <!-- Divider — double wave, filled with the FAQ section's light background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 8 · FAQ ══════════ -->
<section class="gc-faq" aria-label="Gutter cleaning questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">gutter cleaning</span>?</h2>
            <p class="answer-block">
                Straight answers on what gutter cleaning costs in Mauldin, how often gutters need clearing
                in the Upstate, whether downspouts are included, what standing water in a trough really
                means, whether gutter guards change anything, and how Greenville Lawn Masters reaches a
                two-story roofline.
            </p>
        </div>

        <div class="gc-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="gc-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="gc-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> handle around a Mauldin home?</h2>
            <p class="answer-block">
                Gutters are one part of keeping a property sound. Greenville Lawn Masters handles the
                rest of the exterior across Greenville County too — pressure washing, seasonal cleanups,
                beds and mulch, and the full lawn — with the same one crew and the same 24-hour estimate.
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
<section class="gc-cta" aria-label="Request a gutter cleaning estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to get the water running off your Mauldin roof again?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            The heaviest gutter load in the Upstate lands after leaf drop in late fall and again after
            spring seed and pollen. Book the free walkthrough before the next big storm and the written
            estimate is in your hands within 24 hours — troughs, downspouts, and all.
        </p>
        <div class="gc-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Gutter Estimate
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
