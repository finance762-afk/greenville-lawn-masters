<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/mulch-installation/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page: mulch installation is its own page (config.php
   $servicePages), so there is no grouped-service list here — just the
   single service from servicesOnPage('mulch-installation').

   Nothing on this page is invented. No prices, no "$X per yard", no
   "starting at" — intake supplied no pricing, and a fabricated range
   amplified through Service or FAQPage schema is a misrepresentation to
   Google, not a placeholder. No reviews, testimonials, star ratings, or
   review counts (config.php $reviews is empty). No "licensed and insured",
   license numbers, certifications, crew size, or yards-installed figures —
   intake supplied none. The horticultural claims are checkable facts about
   the SC Piedmont (zone 7b-8a); the business claims are limited to what
   build-plan.json recorded: founded 2024, 25-mile radius across Greenville
   County, one crew, beds cleaned and re-edged, written estimate within 24h.

   This page is one of the lucky ones on photos: 'mulch_bed' and 'backyard'
   genuinely show finished mulch work, so captions may describe the mulched
   beds directly. No caption claims a photo shows the crew spreading mulch —
   no photo in the library depicts that (config.php $photoLibrary notes).
   ============================================================ */

$pageSlug    = 'mulch-installation';
$currentPage = 'services';

$servicesHere = servicesOnPage($pageSlug);   // exactly one: Mulch Installation
$service      = $servicesHere[0] ?? null;
$media        = servicePagePhotos($pageSlug);
$heroImg      = heroPhoto($media['hero']);   // hero-mauldin-mulch-bed.jpg, 1600px

$pageTitle       = 'Mulch Installation in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Mulch installation in Mauldin, SC. Beds cleaned, re-edged, and mulched to an even 2-3 inch depth, pulled back from trunks. Written estimate in 24 hours.';   // 152 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';   // $phone is empty at intake

/* ── Telltale signs (section 2, bento) ────────────────────────
   Each is something a Mauldin homeowner can verify by walking out to the bed,
   tied to the horticultural cause. Empathy through specificity, not urgency. */
$signs = [
    ['icon' => 'droplets',  'title' => 'Water runs off the bed',    'body' => 'Old mulch compacts into a crust that sheds water instead of holding it. On heavy Piedmont clay, rain and irrigation sheet straight off the surface and never reach the roots underneath.'],
    ['icon' => 'mountain',  'title' => 'Mulch volcanoes at the trunk','body' => 'Mulch heaped into a cone against a trunk holds moisture against the bark, invites rot and girdling roots, and gives rodents cover to chew. The flare of the trunk should be visible, not buried.'],
    ['icon' => 'unlink',    'title' => 'Beds bleed into the lawn',  'body' => 'When the spade edge disappears, mulch drifts into the turf and grass creeps into the bed. The line between the two blurs a little more every mow until nothing looks intentional.'],
    ['icon' => 'sprout',    'title' => 'Weeds push through',        'body' => 'Mulch spread too thin, or laid straight over living weeds, lets light through. Mulch suppresses seeds it shades — it does not kill what is already rooted, so thin cover just delays the problem.'],
];

/* ── What a mulch installation includes (section 4) ───────────
   Six concrete steps, each an honest description of the work — not a benefit
   claim. Icons differ between adjacent items (CLAUDE.md service-icon rule). */
$includes = [
    ['icon' => 'trash-2',    'title' => 'Bed cleanout',      'body' => 'Leaf litter, spent annuals, and last season’s compacted crust are cleared or broken up so new mulch sits on open soil, not on a water-shedding mat.'],
    ['icon' => 'sprout',     'title' => 'Weeding first',      'body' => 'Established weeds are pulled before anything goes down. Mulch blocks the light that new weed seeds need, but it cannot kill a weed that is already rooted.'],
    ['icon' => 'spline',     'title' => 'Re-edging',          'body' => 'A clean spade line is cut around each bed. That edge is what keeps mulch in the bed and turf out of it through the season.'],
    ['icon' => 'ruler',      'title' => 'Depth set to 2-3"',  'body' => 'Mulch is laid two to three inches deep. Deeper than about four inches suffocates roots and sheds water — more is not better.'],
    ['icon' => 'tree-pine',  'title' => 'Trunks kept clear',  'body' => 'Mulch is pulled back a few inches from every trunk, stem, and crown so bark can breathe and the root flare stays visible.'],
    ['icon' => 'wind',       'title' => 'Blow-down finish',   'body' => 'Walks, drives, and patios are blown clean and stray mulch is swept back into the bed before the crew leaves the property.'],
];

/* ── Install process / timeline (rail) ────────────────────────*/
$timeline = [
    ['phase' => 'Visit 1',    'title' => 'Walkthrough and measure', 'body' => 'Every bed is walked and measured on foot, plant health is checked, and mulch type is talked through — shredded hardwood knits together and holds on slopes, pine bark nuggets float in heavy rain, and pine straw mats well and is common across the Upstate.'],
    ['phase' => 'Within 24h', 'title' => 'Written estimate',        'body' => 'An itemised estimate lands within a day of the walkthrough, broken out by bed and mulch type so you can mulch the whole property or only the beds that need it this year.'],
    ['phase' => 'Install day', 'title' => 'Cleanout and re-edge',   'body' => 'Beds are cleared, weeds pulled, and a fresh spade edge is cut before a single yard of mulch is opened. Skipping this is why re-mulched beds crust over and creep into the lawn.'],
    ['phase' => 'Install day', 'title' => 'Spread and finish',      'body' => 'Mulch is raked to an even two to three inches, pulled back from trunks and crowns, and the hard surfaces are blown clean. The bed looks finished because the prep underneath it was.'],
];

/* ── Comparison (section 6) ───────────────────────────────────
   Left column is common trade practice, NOT a named competitor. Every
   right-hand row is a process commitment intake recorded or a horticultural
   practice we perform — never a credential or a price claim. */
$comparison = [
    ['them' => 'Fresh mulch dumped straight onto last year’s crust',        'us' => 'Old compacted crust cleared or broken up so water and air reach the soil again'],
    ['them' => 'Piled deep for a "fresh" look',                             'us' => 'Held to a 2-3 inch depth so roots still get water and oxygen'],
    ['them' => 'Heaped against trunks and stems',                           'us' => 'Pulled back a few inches from every trunk, stem, and crown'],
    ['them' => 'Beds left to bleed into the surrounding turf',              'us' => 'Re-edged with a clean spade line that keeps mulch in and grass out'],
    ['them' => 'Spread over living weeds and left to push through',         'us' => 'Weeds pulled first, then mulch shades the seed that is left'],
    ['them' => 'Stray mulch and debris left on the walk',                   'us' => 'Walks, drives, and patios blown clean before the crew leaves'],
];

/* ── FAQs — conversational, 40-80 words (aeo-content-schema §2.4) ──
   Rendered visibly below AND passed to generateFAQSchema() so the schema
   mirrors the page. No pricing in any answer: none was supplied, and an
   invented range carried into FAQPage schema misrepresents the business. */
$faqs = [
    [
        'question' => 'How deep should mulch be in a Mauldin flower bed?',
        'answer'   => 'Two to three inches is the target across almost every landscape bed. That depth holds soil moisture through Upstate summers and blocks the light weed seeds need to germinate. Piled deeper than about four inches, mulch starts to suffocate roots and shed water rather than absorb it, so on mulch, more is genuinely not better.',
    ],
    [
        'question' => 'Is volcano mulching against the trunk really a problem?',
        'answer'   => 'Yes. Mulch mounded in a cone against a trunk traps moisture against the bark, which invites rot, encourages girdling roots that strangle the tree, and gives voles and mice cover to gnaw the base. Greenville Lawn Masters pulls mulch back a few inches from every trunk and crown so the root flare stays visible and the bark can dry.',
    ],
    [
        'question' => 'Do I need to remove old mulch before adding new?',
        'answer'   => 'Not always all of it, but the old layer cannot be ignored. Mulch that has compacted into a crust sheds water, so it is cleared or broken up before fresh mulch goes on top. Topping a hard crust year after year is how beds end up several inches deep, sour underneath, and shedding every rain onto the lawn.',
    ],
    [
        'question' => 'What kind of mulch is best for Upstate SC beds and slopes?',
        'answer'   => 'It depends on the bed. Shredded hardwood knits together and stays put on Greenville County slopes. Pine bark nuggets look clean but float and wash out in a hard rain. Pine straw is common and inexpensive across the Southeast and mats well on inclines. Greenville Lawn Masters talks the choice through at the walkthrough rather than defaulting to one product.',
    ],
    [
        'question' => 'Does mulch actually stop weeds?',
        'answer'   => 'It suppresses new ones. A 2-3 inch layer blocks the sunlight that weed seeds need to sprout, which is most of the battle. What mulch does not do is kill weeds that are already rooted — those simply grow up through it. That is why Greenville Lawn Masters pulls existing weeds before mulching instead of burying them.',
    ],
    [
        'question' => 'When is the best time to mulch in Greenville County?',
        'answer'   => 'Late spring, once the soil has warmed, is a reliable window across the Upstate. Mulch laid very early over cold, wet Piedmont clay actually slows the soil from warming up. Beyond timing, mulch can be refreshed whenever the layer has thinned below a couple of inches or faded, since color fades after a season of hard South Carolina sun.',
    ],
    [
        'question' => 'Do dyed mulches harm my plants?',
        'answer'   => 'The dye itself is generally a cosmetic issue, not the concern — colorant on hardwood mulch is there to slow fading, and it fades anyway within a season of Upstate sun. The thing worth asking about is the wood the mulch is made from, not the color. Greenville Lawn Masters is happy to skip dyed products entirely if you prefer a natural mulch.',
    ],
];

/* ── Schema ───────────────────────────────────────────────────
   Exactly four nodes, per the build spec:
     (a) Service (@id #service-mulch-installation), provider → homepage @id
     (b) FAQPage mirroring the visible FAQ
     (c) BreadcrumbList (Home › Services › Mulch Installation)
     (d) WebPage with Speakable — every cssSelector exists in the markup below

   No `offers` / `priceRange`: intake supplied no pricing, and fabricated
   structured pricing is a misrepresentation Google acts on. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-mulch-installation',
        'name'        => 'Mulch Installation',
        'serviceType' => 'Mulch installation and landscape bed care',
        'description' => 'Mulch installation in Mauldin, South Carolina: flower and landscape beds '
                       . 'cleaned out, weeded, and re-edged, then mulched to a 2-3 inch depth and '
                       . 'kept pulled back from trunks and crowns.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',              'url' => '/'],
        ['name' => 'Services',          'url' => '/services/'],
        ['name' => 'Mulch Installation', 'url' => '/services/' . $pageSlug . '/'],
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
   Mulch Installation — page-scoped styles
   Every rule is prefixed .mi- so no class collides with another page's
   <style> block. Colour, shadow, spacing, radius, and timing are var()
   tokens without exception — a raw literal here is an automatic QA fail.
   Geometric px inside the depth cross-section diagram, clip-paths, and
   @keyframes are intentional and allowed.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  three distinct SVG dividers (torn edge, wave, diagonal)
     C4  editorial pull-quote
     C5  bento grid of telltale signs, deliberately uneven spans
     C6  asymmetric 62/38 split with an oversized depth watermark
     C7  SIGNATURE — the mulch depth cross-section (this page only)
     C10 comparison table with accent-highlighted commitment column
     C11 image treatments — arch clip and offset frame
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Background is the finished-mulch-bed photo, resampled to 1600px. The overlay
   both lifts text contrast and hides the softness of the upscale. The gradient
   angle (118deg) and stop positions are deliberately unlike the homepage (100deg)
   and the lawn-care page (78deg) so no two heroes read as the same treatment. */
.mi-hero {
  min-height: 80vh;
  min-height: 80svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-mulch-bed.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.mi-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    118deg,
    rgba(var(--color-dark-rgb), 0.92) 0%,
    rgba(var(--color-dark-rgb), 0.80) 38%,
    rgba(var(--color-primary-rgb), 0.55) 70%,
    rgba(var(--color-primary-rgb), 0.28) 100%
  );
  z-index: 0;
}
.mi-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.mi-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.mi-hero .breadcrumb { animation: miFade 0.5s ease both; }

.mi-hero__eyebrow {
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
  animation: miFade 0.55s ease 0.08s both;
}
.mi-hero__eyebrow i, .mi-hero__eyebrow svg { width: 15px; height: 15px; }

.mi-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: miRise 0.6s ease 0.16s both;
}
.mi-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; in a left-aligned hero it must not. */
.mi-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: miRise 0.6s ease 0.26s both;
}

.mi-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: miRise 0.6s ease 0.36s both;
}
.mi-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: miRise 0.6s ease 0.46s both;
}
.mi-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.mi-hero__trust i, .mi-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS, never a reveal class — the reveal system
   sets opacity:0 and would blank the hero if IntersectionObserver never fires. */
@keyframes miFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes miRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.mi-problem { background: var(--color-light); }
.mi-problem__layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: var(--space-12);
  align-items: start;
}
.mi-problem__quote {
  max-width: 20ch;
  font-family: var(--font-heading);
  font-style: italic;
  font-weight: 600;
  font-size: clamp(1.5rem, 3vw, 2.5rem);
  line-height: 1.22;
  color: var(--color-primary-dark);
  border-left: 4px solid var(--color-accent);
  padding-left: var(--space-6);
  margin: 0;
}
.mi-problem__lead { color: var(--color-gray-dark); }
.mi-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Deliberately uneven: the first card spans two columns so the row does not
   read as four identical boxes. Tints rotate; no two adjacent cards match. */
.mi-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.mi-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.mi-sign:first-child { grid-column: span 2; }
.mi-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.mi-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.mi-sign__icon i, .mi-sign__icon svg { width: 22px; height: 22px; }
.mi-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.mi-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with a depth watermark ──*/
.mi-expert { background: var(--color-white); }
.mi-expert__layout {
  display: grid;
  grid-template-columns: 0.62fr 1.38fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.mi-depth-watermark {
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
.mi-depth-watermark span {
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
.mi-expert h2 { margin-bottom: var(--space-5); }
.mi-expert .answer-block { margin-inline: 0; }
.mi-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.mi-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.mi-diff i, .mi-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.mi-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.mi-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── C7 · SIGNATURE: the mulch depth cross-section ────────────
   A CSS-drawn side view of a bed profile — soil, root zone, the 2-3 inch mulch
   band, and the air above it — beside a depth ruler in inches, plus a callout
   contrasting correct depth against volcano-mulching at a trunk. Built entirely
   from divs and tokens; no images, no external SVG. It exists on no other page
   in the build. Geometric px below are intentional. */
.mi-depth { background: var(--color-dark); }
.mi-depth h2, .mi-depth .eyebrow-label { color: var(--color-white); }
.mi-depth .eyebrow-label { color: var(--color-accent); }
.mi-depth .answer-block { color: rgba(var(--color-white-rgb), 0.82); }
.mi-depth__diagram {
  max-width: 60rem;
  margin: var(--space-12) auto 0;
  display: grid;
  grid-template-columns: 1.5fr 1fr;
  gap: var(--space-8);
  align-items: stretch;
}

/* The cutaway itself — a light card so the strata read against the dark section */
.mi-cutaway {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
  padding: var(--space-6);
  display: grid;
  grid-template-columns: 54px 1fr;
  gap: var(--space-4);
}
.mi-caption-row {
  grid-column: 1 / -1;
  margin-top: var(--space-4);
  text-align: center;
  font-size: var(--font-size-xs);
  color: var(--color-gray);
  line-height: 1.6;
}

/* Depth ruler — inch marks 0 through 6, top of mulch = 0 */
.mi-ruler {
  position: relative;
  border-right: 2px solid var(--color-gray-light);
}
.mi-ruler__tick {
  position: absolute;
  right: 6px;
  transform: translateY(-50%);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  color: var(--color-gray-dark);
  white-space: nowrap;
}
.mi-ruler__tick::after {
  content: '';
  position: absolute;
  right: -8px;
  top: 50%;
  width: 6px;
  height: 2px;
  background: var(--color-gray-light);
}

/* The stacked strata. Heights are proportional to real depth, not literal px. */
.mi-profile {
  position: relative;
  border-radius: var(--radius-sm);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  min-height: 300px;
}
.mi-stratum {
  position: relative;
  display: flex;
  align-items: center;
  padding: 0 var(--space-4);
  font-size: var(--font-size-xs);
  font-weight: 600;
  letter-spacing: 0.5px;
}
.mi-stratum span {
  background: rgba(var(--color-white-rgb), 0.82);
  border-radius: var(--radius-full);
  padding: 2px 10px;
  color: var(--color-dark);
}
.mi-stratum--air {
  flex: 0 0 22%;
  background: repeating-linear-gradient(
    135deg,
    var(--color-light),
    var(--color-light) 10px,
    var(--color-gray-light) 10px,
    var(--color-gray-light) 11px
  );
  color: var(--color-gray);
  align-items: flex-start;
  padding-top: var(--space-2);
}
.mi-stratum--air span { background: transparent; padding: 0; }
/* The correct-depth band — highlighted, the whole point of the diagram */
.mi-stratum--mulch {
  flex: 0 0 20%;
  background: var(--color-secondary);
  color: var(--color-white);
  box-shadow: inset 0 0 0 2px var(--color-accent);
}
.mi-stratum--mulch span { color: var(--color-primary-dark); font-weight: 700; }
.mi-stratum--roots {
  flex: 0 0 26%;
  background: rgba(var(--color-primary-rgb), 0.32);
  color: var(--color-primary-dark);
}
.mi-stratum--soil {
  flex: 1 1 auto;
  background: var(--color-dark-alt);
  color: rgba(var(--color-white-rgb), 0.75);
}
/* The accent bracket marking the 2-3" zone on the profile */
.mi-depth-flag {
  position: absolute;
  left: var(--space-2);
  z-index: 2;
  display: inline-flex;
  align-items: center;
  gap: var(--space-1);
  font-family: var(--font-heading);
  font-weight: 800;
  font-size: var(--font-size-sm);
  color: var(--color-accent);
}

/* Right column — the trunk callout: correct vs volcano, side by side */
.mi-trunks {
  display: grid;
  grid-template-rows: 1fr 1fr;
  gap: var(--space-5);
}
.mi-trunk {
  position: relative;
  border-radius: var(--radius-lg);
  padding: var(--space-5) var(--space-5) var(--space-4);
  background: rgba(var(--color-white-rgb), 0.06);
  border: 1px solid rgba(var(--color-white-rgb), 0.1);
  display: flex;
  align-items: flex-end;
  gap: var(--space-4);
  min-height: 132px;
}
.mi-trunk__label {
  position: absolute;
  top: var(--space-3);
  left: var(--space-4);
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1px;
}
.mi-trunk__label i, .mi-trunk__label svg { width: 15px; height: 15px; }
.mi-trunk--right .mi-trunk__label { color: var(--color-accent); }
.mi-trunk--wrong .mi-trunk__label { color: var(--color-warning); }
/* The trunk: a tapering vertical bar with a visible root flare */
.mi-trunk__stem {
  position: relative;
  width: 26px;
  height: 84px;
  margin-left: var(--space-6);
  background: linear-gradient(to top, var(--color-secondary), var(--color-gray-dark));
  border-radius: 3px 3px 0 0;
  flex-shrink: 0;
}
.mi-trunk__stem::before {
  content: '';
  position: absolute;
  bottom: 0;
  left: -8px;
  right: -8px;
  height: 14px;
  background: var(--color-secondary);
  clip-path: polygon(20% 0, 80% 0, 100% 100%, 0 100%);
}
/* Correct: a shallow, even ring pulled BACK from the flare — a gap at the stem */
.mi-trunk--right .mi-trunk__mulch {
  position: relative;
  flex: 1;
  height: 16px;
  background: var(--color-primary);
  border-radius: var(--radius-sm) var(--radius-sm) 0 0;
  margin-left: 10px;   /* the pull-back gap */
}
/* Wrong: a tall cone heaped against the bark */
.mi-trunk--wrong .mi-trunk__stem { z-index: 1; }
.mi-trunk--wrong .mi-trunk__mulch {
  position: absolute;
  left: calc(var(--space-6) - 22px);
  bottom: var(--space-4);
  width: 74px;
  height: 66px;
  background: var(--color-warning);
  opacity: 0.85;
  clip-path: polygon(50% 0, 100% 100%, 0 100%);
}
.mi-trunk__note {
  position: absolute;
  right: var(--space-4);
  bottom: var(--space-3);
  max-width: 46%;
  font-size: var(--font-size-xs);
  line-height: 1.5;
  color: rgba(var(--color-white-rgb), 0.72);
  text-align: right;
}

/* ── Service breakdown (what's included) ──────────────────────*/
.mi-breakdown { background: var(--color-light); }
.mi-includes {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-5);
}
.mi-include {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-top: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.mi-include:hover {
  transform: translateY(-5px);
  border-top-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.mi-include__icon {
  width: 48px; height: 48px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: rgba(var(--color-primary-rgb), 0.09);
  color: var(--color-primary);
}
.mi-include__icon i, .mi-include__icon svg { width: 24px; height: 24px; }
.mi-include h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.mi-include p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray); line-height: 1.65; }

/* Install-day process rail — the accent line threading the four steps */
.mi-rail { position: relative; margin-top: var(--space-16); padding-left: var(--space-12); }
.mi-rail::before {
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
.mi-rail__step { position: relative; padding-bottom: var(--space-10); }
.mi-rail__step:last-child { padding-bottom: 0; }
.mi-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 6px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-light);
}
.mi-rail__phase {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.mi-rail__step h3 { font-size: var(--font-size-xl); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.mi-rail__step p { margin: 0; max-width: 62ch; color: var(--color-gray-dark); line-height: 1.7; }

/* ── C11 · Proof strip, arch and offset frame treatments ──────*/
.mi-proof { background: var(--color-dark); }
.mi-proof h2, .mi-proof .eyebrow-label { color: var(--color-white); }
.mi-proof .eyebrow-label { color: var(--color-accent); }
.mi-proof .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.mi-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.mi-shot { margin: 0; }
.mi-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
.mi-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.mi-shot--frame { position: relative; }
.mi-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.mi-shot:hover img { transform: scale(1.03); }
.mi-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.mi-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }
.mi-proof__note {
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
.mi-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.mi-compare { background: var(--color-white); }
.mi-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.mi-compare__head, .mi-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.mi-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.mi-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.mi-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.mi-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.mi-compare__row > div:first-child { color: var(--color-gray); }
.mi-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.mi-compare__row i, .mi-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.mi-compare__row > div:first-child i, .mi-compare__row > div:first-child svg { color: var(--color-gray); }
.mi-compare__row > div:last-child i,  .mi-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.mi-faq { background: var(--color-light); }
.mi-faq .answer-block { margin-inline: auto; text-align: center; }
.mi-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.mi-faq__item {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.mi-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.mi-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.mi-related { background: var(--color-white); }

/* ── Final CTA ────────────────────────────────────────────────*/
.mi-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.mi-cta::before {
  content: '';
  position: absolute;
  bottom: -22%; left: -6%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.mi-cta .container { position: relative; z-index: 1; }
.mi-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.mi-cta .answer-block { color: rgba(var(--color-white-rgb), 0.88); margin-inline: auto; text-align: center; }
.mi-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; margin-top: var(--space-8); }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .mi-includes { grid-template-columns: repeat(2, 1fr); }
  .mi-signs { grid-template-columns: repeat(2, 1fr); }
  .mi-sign:first-child { grid-column: span 2; }
  .mi-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .mi-depth-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .mi-depth-watermark span { position: static; display: block; margin-top: var(--space-4); }
  .mi-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .mi-problem__quote { max-width: none; }
  .mi-depth__diagram { grid-template-columns: 1fr; }
  .mi-proof__grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 700px) {
  .mi-hero { min-height: 0; }
  .mi-includes, .mi-signs, .mi-proof__grid { grid-template-columns: 1fr; }
  .mi-sign:first-child { grid-column: span 1; }
  .mi-shot--frame::before { display: none; }
  .mi-cutaway { grid-template-columns: 44px 1fr; }

  /* Comparison grid collapses to stacked pairs; each cell carries its own label
     via data-label, or the them/us contrast is lost when the headers hide. */
  .mi-compare__head { display: none; }
  .mi-compare__row { grid-template-columns: 1fr; }
  .mi-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .mi-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero mi-hero" aria-label="Mulch installation in Mauldin, South Carolina">
    <div class="container">
        <div class="mi-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Mulch Installation</span></li>
                </ol>
            </nav>

            <span class="mi-hero__eyebrow">
                <i data-lucide="layers" aria-hidden="true"></i>
                Mulch Installation &middot; Mauldin, SC
            </span>

            <h1>Mulch Installation in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters installs mulch in flower and landscape beds across Mauldin,
                South Carolina and within 25 miles of Greenville County. Beds are cleaned out, weeded,
                and re-edged, then mulched to the right two-to-three-inch depth and kept pulled back
                from trunks. Every bed is walked before it is priced, with a written estimate inside
                24 hours.
            </p>

            <div class="mi-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Mulch Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* No phone in intake (config.php $phone === ''). A "Call Now" button with no
                             number — or a fabricated one — is worse than routing to the estimate form. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only what intake recorded. No "Licensed & Insured", no star
                     rating, no job count — config.php has none of the three. */ ?>
            <div class="mi-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="ruler" aria-hidden="true"></i> Mulched to a 2-3 inch depth</span>
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
<section class="mi-problem" aria-label="Signs a Mauldin bed needs re-mulching">
    <div class="container">
        <div class="mi-problem__layout">
            <blockquote class="mi-problem__quote reveal-left">
                Most bad mulch jobs fail at the soil line, not the surface.
            </blockquote>

            <div class="mi-problem__lead">
                <h2 class="reveal-right">How do you know when a Mauldin flower bed needs re-mulching?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    A Mauldin bed needs attention when water runs off instead of soaking in, when mulch
                    has cones piled against trunks, when the spade edge has vanished and mulch bleeds into
                    the lawn, or when weeds push through a thin layer. Each of those is a preparation
                    problem the crust on top only hides.
                </p>
                <p class="reveal-right reveal-delay-2">
                    None of it is fixed by dumping another layer on top. Greenville Lawn Masters starts at
                    the soil line — clearing the old crust, pulling the weeds, and re-cutting the edge —
                    because a fresh two inches over a hard, sour mat looks tidy for a week and sheds every
                    rain onto the grass after that.
                </p>
            </div>
        </div>

        <div class="mi-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="mi-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="mi-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="mi-expert" aria-label="Why Greenville Lawn Masters for mulch installation">
    <div class="container">
        <div class="mi-expert__layout">

            <div class="mi-depth-watermark reveal-left" aria-hidden="true">
                2-3&Prime;<span>Inches, not more</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does the prep matter more than the mulch itself?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    The prep matters because mulch only performs on soil that can breathe and drink.
                    Laid over a compacted crust, living weeds, or a lost bed edge, even good mulch at the
                    right depth sheds water, grows weeds up through it, and drifts into the lawn. The bed
                    is only as good as what happens before the first yard is opened.
                </p>

                <ul class="mi-diffs">
                    <li class="mi-diff reveal-right reveal-delay-2">
                        <i data-lucide="spline" aria-hidden="true"></i>
                        <div>
                            <strong>Beds are cleaned and re-edged first</strong>
                            <p>
                                Old crust cleared, weeds pulled, and a clean spade line cut around every bed
                                before mulch goes down — the step most mulch drops skip.
                            </p>
                        </div>
                    </li>
                    <li class="mi-diff reveal-right reveal-delay-3">
                        <i data-lucide="ruler" aria-hidden="true"></i>
                        <div>
                            <strong>Depth is held to two or three inches</strong>
                            <p>
                                Enough to hold moisture through an Upstate summer and shade out weed seed,
                                not so much that it suffocates roots and sheds water past about four inches.
                            </p>
                        </div>
                    </li>
                    <li class="mi-diff reveal-right reveal-delay-4">
                        <i data-lucide="tree-pine" aria-hidden="true"></i>
                        <div>
                            <strong>Mulch is kept off trunks and crowns</strong>
                            <p>
                                Pulled back a few inches from every stem so bark can dry and the root flare
                                stays visible — no cones of moisture held against living wood.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Divider 2 — double wave, filled with the depth section's dark background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,30 C300,70 900,10 1200,40 L1200,100 L0,100 Z" fill="var(--color-dark)" opacity="0.45"/>
            <path d="M0,50 C300,90 900,20 1200,60 L1200,100 L0,100 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ SIGNATURE · MULCH DEPTH CROSS-SECTION ══════════
     A CSS-drawn cutaway of a bed profile — unique to this page. No images. -->
<section class="mi-depth" aria-label="How deep mulch should be">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Cross-Section</span>
            <h2>How deep should mulch actually be?</h2>
            <p class="answer-block">
                Mulch should sit two to three inches deep across nearly every bed. That band holds soil
                moisture through Upstate summers and blocks the light weed seeds need to sprout. Piled
                past four inches it suffocates roots and sheds water — and heaped against a trunk it
                rots the bark. The diagram reads the way a spade would cut it.
            </p>
        </div>

        <div class="mi-depth__diagram reveal-scale">

            <!-- The cutaway: depth ruler + stacked strata -->
            <div class="mi-cutaway" role="img"
                 aria-label="Cutaway of a mulched bed: about two to three inches of mulch over the root zone and soil, with the correct depth band highlighted against a six-inch ruler.">
                <div class="mi-ruler" aria-hidden="true">
                    <span class="mi-ruler__tick" style="top:2%">0&Prime;</span>
                    <span class="mi-ruler__tick" style="top:11%">1&Prime;</span>
                    <span class="mi-ruler__tick" style="top:22%">2&Prime;</span>
                    <span class="mi-ruler__tick" style="top:33%">3&Prime;</span>
                    <span class="mi-ruler__tick" style="top:48%">4&Prime;</span>
                    <span class="mi-ruler__tick" style="top:64%">5&Prime;</span>
                    <span class="mi-ruler__tick" style="top:82%">6&Prime;</span>
                </div>
                <div class="mi-profile" aria-hidden="true">
                    <div class="mi-stratum mi-stratum--air"><span>Air &amp; plant crowns</span></div>
                    <div class="mi-stratum mi-stratum--mulch">
                        <span class="mi-depth-flag">2-3&Prime; mulch</span>
                    </div>
                    <div class="mi-stratum mi-stratum--roots"><span>Root zone</span></div>
                    <div class="mi-stratum mi-stratum--soil"><span>Piedmont clay soil</span></div>
                </div>
                <p class="mi-caption-row">
                    The highlighted band is the whole point: shallow enough that roots breathe,
                    deep enough to hold water and shade out weed seed.
                </p>
            </div>

            <!-- The trunk callout: correct vs volcano -->
            <div class="mi-trunks">
                <div class="mi-trunk mi-trunk--right reveal-right reveal-delay-1">
                    <span class="mi-trunk__label"><i data-lucide="check-circle" aria-hidden="true"></i> Correct</span>
                    <div class="mi-trunk__stem" aria-hidden="true"></div>
                    <div class="mi-trunk__mulch" aria-hidden="true"></div>
                    <p class="mi-trunk__note">Even and pulled back — the root flare shows.</p>
                </div>
                <div class="mi-trunk mi-trunk--wrong reveal-right reveal-delay-2">
                    <span class="mi-trunk__label"><i data-lucide="alert-triangle" aria-hidden="true"></i> Volcano</span>
                    <div class="mi-trunk__stem" aria-hidden="true"></div>
                    <div class="mi-trunk__mulch" aria-hidden="true"></div>
                    <p class="mi-trunk__note">Heaped on the bark — traps rot and rodents.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Divider 3 — diagonal, filled with the breakdown section's light background -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <polygon fill="var(--color-light)" points="0,0 1200,60 0,60"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN + PROCESS ══════════ -->
<section class="mi-breakdown" aria-label="What mulch installation includes">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What is included in <span class="text-accent">Greenville Lawn Masters</span> mulch installation?</h2>
            <p class="answer-block">
                Greenville Lawn Masters mulch installation is more than a delivery: beds are cleaned out
                and weeded, re-edged with a clean spade line, then mulched to a two-to-three-inch depth
                and pulled back from trunks and crowns before every hard surface is blown clean. Take the
                whole property or only the beds that need it this year.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="mi-includes">
            <?php foreach ($includes as $i => $item): ?>
                <article class="mi-include <?php echo ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3]; ?> reveal-delay-<?php echo ($i % 3) + 1; ?>">
                    <div class="mi-include__icon">
                        <i data-lucide="<?php echo e($item['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <h3><?php echo e($item['title']); ?></h3>
                    <p><?php echo e($item['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does a mulch installation actually go?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            A mulch installation starts with a free walkthrough where beds are measured and mulch type is
            chosen, followed by a written itemised estimate within 24 hours. On install day the beds are
            cleaned and re-edged first, then mulch is spread to depth, pulled off the trunks, and the
            walks are blown clean.
        </p>

        <ol class="mi-rail">
            <?php foreach ($timeline as $i => $step): ?>
                <li class="mi-rail__step reveal-left reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="mi-rail__phase"><?php echo e($step['phase']); ?></span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Divider 1 (reprise) — torn edge, filled with the proof section's dark background -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,60 L0,38 L80,44 L160,32 L240,46 L320,34 L420,44 L520,30 L620,42 L720,34 L820,46 L920,32 L1020,44 L1120,36 L1200,42 L1200,60 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · PROOF ══════════ -->
<?php /* The build spec puts testimonials and a review snippet here. config.php
         $reviews is empty and no before/after pair exists in the photo library.
         Writing testimonials would attribute invented quotes to invented
         customers — an FTC Endorsement Guides problem, not a placeholder — and
         CLAUDE.md separately forbids fabricated review counts. The client's own
         job photography fills the slot instead. This page's two mulch frames
         genuinely show finished mulch work, so their captions describe the beds
         directly; none claims to show the crew spreading mulch, because no photo
         in the library does. The note below says plainly why there are no reviews. */ ?>
<section class="mi-proof" aria-label="Greenville Lawn Masters mulch photography">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Work</span>
            <h2>What does finished <span class="text-accent">mulch work</span> look like in Mauldin?</h2>
            <p class="answer-block">
                Greenville Lawn Masters photographs its own job sites — every image here is a Mauldin-area
                property the crew maintains, not a stock photo. Below: a mulched front bed at a Craftsman
                home, backyard turf held tight against mulched planting beds, and a finished front lawn
                and driveway a few doors down.
            </p>
        </div>

        <div class="mi-proof__grid">
            <?php
            /* Captions describe WHAT IS IN THE FRAME. 'mulch_bed' and 'backyard' show real
               finished mulch, so they may name it; 'front_lawn' is an honest context shot of
               the same neighbourhood and is captioned as such, not as a mulch job. */
            $shots = [
                ['key' => 'mulch_bed',  'mod' => '',              'label' => 'Mulched front bed',    'caption' => 'A freshly mulched flower bed beside the front walk of a Craftsman home in Mauldin, South Carolina, mown lawn wrapping the edge.'],
                ['key' => 'backyard',   'mod' => 'mi-shot--arch', 'label' => 'Beds against the turf', 'caption' => 'Backyard turf running between mulched planting beds and a wood privacy fence, with flowering perennials, at a Mauldin home.'],
                ['key' => 'front_lawn', 'mod' => 'mi-shot--frame','label' => 'Curb appeal, finished',  'caption' => 'A dense green front lawn and concrete driveway at a two-story Mauldin home — the neighbourhood these beds sit in.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="mi-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <div class="mi-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 6 · COMPARISON ══════════ -->
<section class="mi-compare" aria-label="How Greenville Lawn Masters mulch installation differs">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates a mulch installation from a mulch dump?</h2>
            <p class="answer-block">
                A mulch installation prepares the bed and controls the depth; a mulch dump spreads product
                over whatever is already there. The difference shows up in where the water goes, whether
                the trunks stay clear, and whether the beds still look intentional in August — and it
                compounds across a season.
            </p>
        </div>

        <?php /* Left column describes common practice in the trade, not a named competitor. Every
                 right-hand row is a process commitment recorded at intake or a horticultural
                 practice — never a credential claim and never a price. */ ?>
        <div class="mi-compare__table reveal-up reveal-delay-1">
            <div class="mi-compare__head">
                <div>A typical mulch drop</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="mi-compare__row">
                    <div data-label="A typical mulch drop">
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

    <!-- Divider 2 (reprise) — double wave, filled with the FAQ section's light background -->
    <div class="svg-divider" style="height:80px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,40 C300,80 900,20 1200,50 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.5"/>
            <path d="M0,60 C300,95 900,25 1200,65 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 7 · FAQ ══════════ -->
<section class="mi-faq" aria-label="Mulch questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">mulch</span>?</h2>
            <p class="answer-block">
                Straight answers on how deep mulch should go, why volcano mulching against a trunk causes
                rot, whether old mulch has to come off first, which mulch holds on an Upstate slope,
                whether dyed mulch harms plants, and the timing that actually works in Greenville County.
            </p>
        </div>

        <div class="mi-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="mi-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="mi-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> handle in Mauldin?</h2>
            <p class="answer-block">
                Mulch is usually one line on a larger property plan. Greenville Lawn Masters handles the
                rest of it across Greenville County — planting, cleanups, sod, and lawn care — with the
                same crew and the same written estimate within 24 hours.
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
<section class="mi-cta" aria-label="Request a mulch installation estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to have your Mauldin beds mulched the right way?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Late spring, once the Piedmont clay has warmed, is a reliable window to mulch across the
            Upstate. Book the free walkthrough and the beds get cleaned, re-edged, and mulched to depth
            before the summer heat sets in — with a written itemised estimate in your inbox inside 24
            hours.
        </p>
        <div class="mi-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Mulch Estimate
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
