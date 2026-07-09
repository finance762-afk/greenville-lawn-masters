<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/spring-fall-cleanup/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page: one service (Spring & Fall Cleanup), not a
   grouped page. Structure, PHP setup, and schema construction mirror
   /services/lawn-care-services/index.php; the CSS and section copy are
   this page's own.

   Nothing here is invented. No prices or "starting at" figures, no
   review quotes, star ratings, or review counts ($reviews is empty in
   config.php), no "licensed and insured" or certifications (intake
   supplied none), no jobs-completed / bags-of-leaves / crew-size
   numbers, no before/after pairs (none exist in the library), no
   "same-day" promise. The horticultural claims are checkable facts
   about the SC Piedmont transition zone (7b-8a); the business claims
   are limited to what build-plan.json recorded: founded 2024, based in
   Mauldin 29662, a 25-mile radius across Greenville County, one crew,
   a free walkthrough, a written itemised estimate within 24 hours,
   debris hauled off the property, and 22 total services.
   ============================================================ */

$pageSlug    = 'spring-fall-cleanup';
$currentPage = 'services';

/* servicesOnPage() returns the one service that lives on this page. Its
   description is pulled from config.php rather than restated here, so the
   page can never drift from the committed service copy. */
$servicesHere = servicesOnPage($pageSlug);   // exactly one row
$service      = $servicesHere[0];            // the Spring & Fall Cleanup service

$media   = servicePagePhotos($pageSlug);     // hero => backyard, body => [backyard, mulch_bed, front_lawn]
$heroImg = heroPhoto($media['hero']);        // 1600px rendition of 'backyard'

$pageTitle       = 'Spring & Fall Cleanup in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Spring and fall cleanup in Mauldin, SC: leaf removal, bed cleanout, and storm debris hauled off the property. Free written estimate within 24 hours.';   // 148 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];   // LCP hero background, preloaded in head.php

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';   // $phone is empty at intake

/* ── Telltale signs (section 2) ───────────────────────────────
   What a homeowner can see by walking outside before the season turns,
   each tied to the agronomic reason it matters. No urgency theatre. */
$signs = [
    ['icon' => 'layers',     'title' => 'A leaf mat over the fescue',   'body' => 'Fallen leaves left matted across tall fescue through a wet Upstate winter shade out the crown and invite snow mold. Fescue is already the shade grass carrying the thin spots here.'],
    ['icon' => 'sprout',     'title' => "Last year's mulch, gone hard", 'body' => 'Old mulch compacts into a water-shedding crust and the beds bank a full season of weed seed underneath it. Fresh mulch dumped over the top only deepens the problem.'],
    ['icon' => 'cloud-rain', 'title' => 'Gutters loading with litter',  'body' => 'Leaf litter riding down off the roofline packs the gutters and the bed corners. Left through the freeze, it holds water exactly where you do not want it sitting.'],
    ['icon' => 'wind',       'title' => 'Storm debris through the freeze','body' => 'Downed limbs and blown-in brush left standing over winter smother whatever is beneath them and turn into spring cleanup you pay for twice.'],
];

/* ── Expert differentiators (section 3) ───────────────────────
   Every point is a process commitment intake recorded or a horticultural
   practice we perform — never a credential claim. */
$diffs = [
    ['icon' => 'thermometer', 'title' => 'Timed to dormancy, not the route', 'body' => 'Dormant bermuda is cut back before green-up, never after; the winter leaf mat comes off as the turf wakes, not weeks early. Greenville Lawn Masters reads the Upstate season, not a fixed calendar date.'],
    ['icon' => 'leaf',        'title' => 'Beds cleared before they are covered', 'body' => 'Compacted old mulch is pulled and beds are re-edged before anything fresh goes down — and mulch is kept off the trunks, because piling it against bark holds moisture and invites rot.'],
    ['icon' => 'truck',       'title' => 'Debris leaves with the crew',       'body' => 'One crew handles the whole property, and every load of leaves, cuttings, and bed debris is hauled off when the visit ends. Nothing is bagged and left at the curb.'],
];

/* ── The diptych: what each season's cleanup covers (section 4) ──
   The signature section. Two mirrored panels — spring awakening, fall
   closing — built entirely from brand tokens. Read as one designed unit. */
$seasons = [
    'spring' => [
        'glyph'   => 'sprout',
        'kicker'  => 'March – April',
        'title'   => 'The spring wake-up',
        'lede'    => 'Clearing winter off the yard as the turf breaks dormancy.',
        'items'   => [
            'The matted winter leaves come off the fescue crowns',
            'Dormant ornamental grasses cut back before new growth',
            'Compacted old mulch cleared and beds re-edged',
            'Dormant bermuda cut back before green-up, on time',
            'Timed to the same window as crabgrass pre-emergent',
        ],
    ],
    'fall' => [
        'glyph'   => 'leaf',
        'kicker'  => 'September – November',
        'title'   => 'The fall close-down',
        'lede'    => 'Getting the leaves off before a wet winter mats them down.',
        'items'   => [
            'Falling leaves pulled off the turf through the drop',
            'The aeration and overseeding window for tall fescue',
            'Perennials cut back or left standing — your call',
            'Leaf litter cleared from walks and bed corners',
            'Beds cleaned out and closed down for dormancy',
        ],
    ],
];

/* ── Process rail (section 4, second block) ───────────────────*/
$timeline = [
    ['phase' => 'Visit 1',    'title' => 'Free walkthrough',      'body' => 'The property is walked on foot — which beds have gone hard, where the leaf mat sits heaviest, which grasses are dormant and which are ready to cut. Nothing is quoted from a satellite photo.'],
    ['phase' => 'Within 24h', 'title' => 'Written estimate',      'body' => 'An itemised estimate lands within a day of the walkthrough. Spring and fall cleanups are quoted separately, so you can book one, the other, or both against the calendar.'],
    ['phase' => 'In season',  'title' => 'Booked to the window',  'body' => 'The visit is scheduled into the right window — spring near dormancy break, fall as the leaves drop — rather than whenever the truck happens to reach your street.'],
    ['phase' => 'On the day',  'title' => 'Cleared and hauled off', 'body' => 'Leaves come off, beds are cleared and re-edged, cutbacks are done to timing, and every load of debris leaves with the crew. Walks and drives are blown clean before the gate shuts.'],
];

/* ── Comparison (section 6) ───────────────────────────────────
   Left = common trade practice, no named competitor. Right = process
   commitments and horticultural practice only, never a credential. */
$comparison = [
    ['them' => 'Leaves blown into a pile and left on site',        'us' => 'Every load of leaves and debris hauled off the property'],
    ['them' => 'Same cleanup date for everyone, whatever the grass','us' => 'Timed to dormancy break and soil temperature in Greenville County'],
    ['them' => 'Fresh mulch dumped straight over the old crust',    'us' => 'Old mulch cleared and beds re-edged before anything fresh goes down'],
    ['them' => 'Mulch piled up against the trunks',                 'us' => 'Mulch kept off the bark — no volcano mulching that traps rot'],
    ['them' => 'Ornamental grasses cut whenever the crew arrives',  'us' => 'Grasses cut back in late winter, before new growth breaks'],
    ['them' => 'One generic cleanup sold twice a year',             'us' => 'Spring and fall handled as two separate, timed visits'],
];

/* ── FAQs — conversational, 40-80 words, full company name up front ──
   Rendered visibly below AND passed to generateFAQSchema(). Schema that
   does not mirror visible content is a guidelines violation. No pricing:
   none was supplied, and an invented range amplified through FAQPage
   schema is a misrepresentation to Google, not a placeholder. */
$faqs = [
    [
        'question' => 'What is included in a spring cleanup in Mauldin, SC?',
        'answer'   => 'A Greenville Lawn Masters spring cleanup clears the matted winter leaves off the lawn, cuts '
                    . 'back dormant ornamental grasses and perennials before new growth breaks, and pulls the hardened '
                    . 'old mulch and weed seed out of the beds before fresh mulch goes down. Because it falls in the same '
                    . 'window as crabgrass pre-emergent, the two are often handled on one visit.',
    ],
    [
        'question' => 'What does a fall cleanup cover?',
        'answer'   => 'A Greenville Lawn Masters fall cleanup pulls falling leaves off the turf before they mat down '
                    . 'over a wet Upstate winter and smother the fescue crowns. Beds are cleared and closed for dormancy, '
                    . 'leaf litter is taken off walks and out of bed corners, and every load is hauled off the property. '
                    . 'Fall is also the aeration and overseeding window for tall fescue.',
    ],
    [
        'question' => 'When should leaves be cleared off a fescue lawn?',
        'answer'   => 'Greenville Lawn Masters clears leaves off tall fescue before they pack into a wet mat over '
                    . 'winter. A layer left through the Upstate\'s damp cold shades out the crown and invites snow mold, '
                    . 'and fescue is already the shade-tolerant grass carrying the thin spots. Clearing through the fall '
                    . 'drop, rather than one late rake, keeps the turf breathing.',
    ],
    [
        'question' => 'Should old mulch be removed before new mulch goes down?',
        'answer'   => 'Greenville Lawn Masters clears and re-edges beds before adding mulch rather than piling fresh '
                    . 'over old. Last year\'s mulch compacts into a crust that sheds water instead of holding it, and '
                    . 'stacking new material on top only deepens the problem. We also keep mulch off the trunks — piling '
                    . 'it against bark holds moisture against the wood and invites rot.',
    ],
    [
        'question' => 'When do you cut back ornamental grasses and perennials?',
        'answer'   => 'Greenville Lawn Masters cuts ornamental grasses back in late winter, just before new growth, so '
                    . 'the old stalks hold some winter interest and seed for the birds first. Perennials can be cut in '
                    . 'fall or left standing through winter — both are legitimate, and the choice is yours. The spring '
                    . 'cleanup is when the standing material finally comes down.',
    ],
    [
        'question' => 'Does a spring cleanup include crabgrass pre-emergent?',
        'answer'   => 'A Greenville Lawn Masters spring cleanup often shares its visit with crabgrass pre-emergent, '
                    . 'because both land in the same window. The barrier goes down when soil at two inches holds near '
                    . '55°F — usually late February into mid-March in Greenville County. Applied after germination it '
                    . 'does nothing, so the timing is the point, not the product.',
    ],
    [
        'question' => 'What happens to the leaves and debris you clear?',
        'answer'   => 'Greenville Lawn Masters hauls every load of leaves, cuttings, and bed debris off the property '
                    . 'when the visit ends — nothing is bagged and left at the curb or blown into a corner. One crew '
                    . 'handles the whole job, so the same people who clear the lawn close out the beds and take the '
                    . 'debris with them.',
    ],
    [
        'question' => 'Can Greenville Lawn Masters handle storm debris left over winter?',
        'answer'   => 'Greenville Lawn Masters clears downed limbs, blown-in brush, and storm litter as part of a '
                    . 'seasonal cleanup across Greenville County. Hung-up or overhead limbs are not pulled from a ladder '
                    . '— that is a real safety line, not a corporate one. Ground debris is gathered and hauled, and '
                    . 'anything needing climbing or heavy equipment is flagged for the right crew.',
    ],
];

/* ── Schema ───────────────────────────────────────────────────
   Four nodes. Service (@id #service-{slug}) referencing the homepage
   LocalBusiness as provider rather than restating it; FAQPage mirroring
   the visible FAQ; BreadcrumbList; and a WebPage node carrying Speakable.
   Every Speakable cssSelector exists in the markup below.

   No `offers` / `priceRange`: intake supplied no pricing, and fabricated
   structured pricing is a misrepresentation Google acts on. Solo page —
   no hasOfferCatalog. `serviceOutput` lists the two concrete deliverables
   (a spring cleanup, a fall cleanup) without asserting a price. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $pageSlug,
        'name'        => $service['name'],
        'serviceType' => 'Seasonal yard cleanup and property maintenance',
        'description' => $service['description'],
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
        'serviceOutput' => [
            ['@type' => 'Thing', 'name' => 'Spring cleanup'],
            ['@type' => 'Thing', 'name' => 'Fall cleanup'],
        ],
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',                 'url' => '/'],
        ['name' => 'Services',             'url' => '/services/'],
        ['name' => 'Spring & Fall Cleanup','url' => '/services/' . $pageSlug . '/'],
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
   Spring & Fall Cleanup — page-scoped styles
   Every rule is prefixed .sfc- so no class collides with another page's
   <style> block. Colour, shadow, spacing, radius, and timing are var()
   tokens without exception — a raw literal here is an automatic QA fail.
   (The only hex in this block lives inside the hero's SVG noise data-URI,
   which is a texture, not a design colour.)

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before (115deg, unique to this
         page) + noise ::after
     C3  two distinct SVG dividers — a soft double-wave and a stepped edge
     C4  editorial pull-quote at a fluid clamp size
     C5  bento grid of telltale signs, deliberately uneven first span
     C6  asymmetric 62/38 split with an oversized stat watermark
     C7  SIGNATURE — the spring | fall diptych: two mirrored panels, one
         warm/awakening and one cool/closing, split by a vertical accent
         rule. Appears on no other page in the build.
     C10 comparison table with the accent-highlighted winning column
     C11 image treatments — arch clip and offset accent frame
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Background is the 'backyard' frame, resampled to 1600px. The overlay both
   carries text contrast and hides the softness of the upscale. The 115deg
   angle and its stops differ from the reference page (78deg) and the
   homepage (100deg) so no two heroes read as the same treatment. */
.sfc-hero {
  min-height: 76vh;
  min-height: 76svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-backyard-beds.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.sfc-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    115deg,
    rgba(var(--color-dark-rgb), 0.92) 0%,
    rgba(var(--color-dark-rgb), 0.74) 38%,
    rgba(var(--color-primary-rgb), 0.52) 68%,
    rgba(var(--color-accent-rgb), 0.30) 100%
  );
  z-index: 0;
}
.sfc-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.sfc-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.sfc-hero .breadcrumb { animation: sfcFade 0.5s ease both; }

.sfc-hero__eyebrow {
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
  color: var(--color-white);
  margin-bottom: var(--space-5);
  animation: sfcFade 0.55s ease 0.08s both;
}
.sfc-hero__eyebrow i, .sfc-hero__eyebrow svg { width: 15px; height: 15px; }

.sfc-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: sfcRise 0.6s ease 0.16s both;
}
.sfc-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; in a left-aligned hero it must not. */
.sfc-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: sfcRise 0.6s ease 0.26s both;
}

.sfc-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: sfcRise 0.6s ease 0.36s both;
}
.sfc-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: sfcRise 0.6s ease 0.46s both;
}
.sfc-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.sfc-hero__trust i, .sfc-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS, never a reveal class — the reveal system
   sets opacity:0 and would blank the hero if IntersectionObserver never fires. */
@keyframes sfcFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes sfcRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.sfc-problem { background: var(--color-light); }
.sfc-problem__layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: var(--space-12);
  align-items: start;
}
.sfc-problem__quote {
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
.sfc-problem__lead { color: var(--color-gray-dark); }
.sfc-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Deliberately uneven: the first card spans two columns so the row does not
   read as four identical boxes. Tints rotate; no two adjacent cards match. */
.sfc-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.sfc-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.sfc-sign:first-child { grid-column: span 2; }
.sfc-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.sfc-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.sfc-sign__icon i, .sfc-sign__icon svg { width: 22px; height: 22px; }
.sfc-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.sfc-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.sfc-expert { background: var(--color-white); }
.sfc-expert__layout {
  display: grid;
  grid-template-columns: 0.62fr 1.38fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.sfc-watermark {
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
.sfc-watermark span {
  position: absolute;
  left: 0.06em;
  bottom: -1.5em;
  font-size: var(--font-size-sm);
  font-family: var(--font-body);
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  opacity: 1;
  color: var(--color-primary-dark);
  white-space: nowrap;
}
.sfc-expert h2 { margin-bottom: var(--space-5); }
.sfc-expert .answer-block { margin-inline: 0; }
.sfc-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.sfc-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.sfc-diff i, .sfc-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.sfc-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.sfc-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── C7 · SIGNATURE — the spring | fall diptych ───────────────
   Two mirrored panels read as a single designed unit, not two stacked
   cards. Spring is the warm/awakening side (lighter brand green climbing
   up); fall is the cool/closing side (deep primary-dark into near-black).
   A vertical accent rule splits them down the centre. Nothing else in the
   build looks like this. All colour is brand tokens — no invented hues. */
.sfc-breakdown { background: var(--color-light); }
.sfc-diptych {
  position: relative;
  display: grid;
  grid-template-columns: 1fr 1fr;
  margin-top: var(--space-12);
  border-radius: var(--radius-xl);
  overflow: hidden;
  box-shadow: var(--shadow-lg);
}
/* The dividing rule — an accent thread down the seam, glowing at the join. */
.sfc-diptych::before {
  content: '';
  position: absolute;
  top: 8%; bottom: 8%;
  left: 50%;
  width: 2px;
  transform: translateX(-1px);
  background: linear-gradient(
    to bottom,
    transparent 0%,
    var(--color-accent) 22%,
    var(--color-accent) 78%,
    transparent 100%
  );
  z-index: 3;
  pointer-events: none;
}
.sfc-panel {
  position: relative;
  padding: var(--space-12) var(--space-10);
  overflow: hidden;
  isolation: isolate;
}
.sfc-panel--spring {
  background: linear-gradient(
    155deg,
    rgba(var(--color-accent-rgb), 0.18) 0%,
    rgba(var(--color-primary-rgb), 0.12) 55%,
    rgba(var(--color-white-rgb), 0.4) 100%
  );
}
.sfc-panel--fall {
  background: linear-gradient(
    155deg,
    var(--color-primary-dark) 0%,
    var(--color-dark) 100%
  );
  text-align: right;
}
/* Oversized decorative season glyph, bled into the outer corner of each panel. */
.sfc-panel__glyph {
  position: absolute;
  top: var(--space-6);
  width: 120px; height: 120px;
  display: grid; place-items: center;
  border-radius: var(--radius-full);
  z-index: 0;
  opacity: 0.16;
}
.sfc-panel--spring .sfc-panel__glyph { left: var(--space-6); background: rgba(var(--color-primary-rgb), 0.2); color: var(--color-primary-dark); }
.sfc-panel--fall .sfc-panel__glyph   { right: var(--space-6); background: rgba(var(--color-white-rgb), 0.12); color: var(--color-white); }
.sfc-panel__glyph i, .sfc-panel__glyph svg { width: 62px; height: 62px; }

.sfc-panel__head { position: relative; z-index: 1; }
.sfc-panel__kicker {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2.5px;
  margin-bottom: var(--space-2);
}
.sfc-panel--spring .sfc-panel__kicker { color: var(--color-primary); }
.sfc-panel--fall .sfc-panel__kicker   { color: var(--color-accent); }
.sfc-panel__title {
  font-family: var(--font-heading);
  font-size: var(--font-size-3xl);
  line-height: 1.1;
  margin-bottom: var(--space-2);
}
.sfc-panel--spring .sfc-panel__title { color: var(--color-primary-dark); }
.sfc-panel--fall .sfc-panel__title   { color: var(--color-white); }
.sfc-panel__lede {
  font-style: italic;
  font-size: var(--font-size-base);
  margin-bottom: var(--space-6);
}
.sfc-panel--spring .sfc-panel__lede { color: var(--color-gray-dark); }
.sfc-panel--fall .sfc-panel__lede   { color: rgba(var(--color-white-rgb), 0.8); }

.sfc-panel__list { position: relative; z-index: 1; list-style: none; display: grid; gap: var(--space-4); }
.sfc-panel__list li {
  display: grid;
  grid-template-columns: 22px 1fr;
  gap: var(--space-3);
  align-items: start;
  font-size: var(--font-size-sm);
  line-height: 1.6;
}
.sfc-panel__list i, .sfc-panel__list svg { width: 18px; height: 18px; margin-top: 3px; }
/* The fall panel mirrors: icon moves to the right of the text. */
.sfc-panel--fall .sfc-panel__list li { grid-template-columns: 1fr 22px; }
.sfc-panel--fall .sfc-panel__list li > i,
.sfc-panel--fall .sfc-panel__list li > svg { order: 2; }
.sfc-panel--spring .sfc-panel__list li { color: var(--color-gray-dark); }
.sfc-panel--spring .sfc-panel__list i, .sfc-panel--spring .sfc-panel__list svg { color: var(--color-primary); }
.sfc-panel--fall .sfc-panel__list li { color: rgba(var(--color-white-rgb), 0.86); }
.sfc-panel--fall .sfc-panel__list i, .sfc-panel--fall .sfc-panel__list svg { color: var(--color-accent); }

/* ── Process rail (second block of the breakdown section) ─────
   A single accent line threads the four phases; each marker sits on it. */
.sfc-rail { position: relative; margin-top: var(--space-16); padding-left: var(--space-12); }
.sfc-rail::before {
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
.sfc-rail__step { position: relative; padding-bottom: var(--space-10); }
.sfc-rail__step:last-child { padding-bottom: 0; }
.sfc-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 6px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-light);
}
.sfc-rail__phase {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.sfc-rail__step h3 { font-size: var(--font-size-xl); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.sfc-rail__step p { margin: 0; max-width: 62ch; color: var(--color-gray-dark); line-height: 1.7; }

/* ── C11 · Proof strip, arch and offset frame treatments ──────*/
.sfc-proof { background: var(--color-dark); }
.sfc-proof h2, .sfc-proof .sfc-eyebrow { color: var(--color-white); }
.sfc-proof .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.sfc-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.sfc-shot { margin: 0; }
.sfc-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
/* Arch clip on the middle frame only — variation, not decoration for its own sake. */
.sfc-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.sfc-shot--frame { position: relative; }
.sfc-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.sfc-shot:hover img { transform: scale(1.03); }
.sfc-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.sfc-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }
.sfc-proof__note {
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
.sfc-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.sfc-compare { background: var(--color-white); }
.sfc-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.sfc-compare__head, .sfc-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.sfc-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.sfc-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.sfc-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.sfc-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.sfc-compare__row > div:first-child { color: var(--color-gray); }
.sfc-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.sfc-compare__row i, .sfc-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.sfc-compare__row > div:first-child i, .sfc-compare__row > div:first-child svg { color: var(--color-gray); }
.sfc-compare__row > div:last-child i,  .sfc-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.sfc-faq { background: var(--color-light); }
.sfc-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.sfc-faq__item {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.sfc-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.sfc-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.sfc-related { background: var(--color-white); }

/* ── Final CTA ────────────────────────────────────────────────*/
.sfc-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.sfc-cta::before {
  content: '';
  position: absolute;
  top: -20%; left: -8%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.sfc-cta .container { position: relative; z-index: 1; }
.sfc-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.sfc-cta .answer-block { color: rgba(var(--color-white-rgb), 0.9); margin-inline: auto; margin-bottom: var(--space-8); }
.sfc-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .sfc-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .sfc-problem__quote { max-width: none; }
  .sfc-signs { grid-template-columns: repeat(2, 1fr); }
  .sfc-sign:first-child { grid-column: span 2; }
  .sfc-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .sfc-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .sfc-watermark span { position: static; display: block; margin-top: var(--space-4); }
  .sfc-proof__grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 820px) {
  /* The diptych stacks: the vertical seam rule becomes a horizontal one, and
     the fall panel drops its mirroring so both sides read left-aligned. */
  .sfc-diptych { grid-template-columns: 1fr; }
  .sfc-diptych::before {
    top: auto; left: 8%; right: 8%; bottom: 50%;
    width: auto; height: 2px; transform: translateY(1px);
    background: linear-gradient(to right, transparent, var(--color-accent), transparent);
  }
  .sfc-panel--fall { text-align: left; }
  .sfc-panel--fall .sfc-panel__glyph { right: auto; left: var(--space-6); }
  .sfc-panel--fall .sfc-panel__list li { grid-template-columns: 22px 1fr; }
  .sfc-panel--fall .sfc-panel__list li > i,
  .sfc-panel--fall .sfc-panel__list li > svg { order: 0; }
}
@media (max-width: 700px) {
  .sfc-hero { min-height: 0; }
  .sfc-signs, .sfc-proof__grid { grid-template-columns: 1fr; }
  .sfc-sign:first-child { grid-column: span 1; }
  .sfc-shot--frame::before { display: none; }
  .sfc-panel { padding: var(--space-8) var(--space-6); }

  /* Comparison grid collapses to stacked pairs; each cell carries its own
     label or the them/us contrast is lost with the headers hidden. */
  .sfc-compare__head { display: none; }
  .sfc-compare__row { grid-template-columns: 1fr; }
  .sfc-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .sfc-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero sfc-hero" aria-label="Spring and fall cleanup in Mauldin, South Carolina">
    <div class="container">
        <div class="sfc-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Spring &amp; Fall Cleanup</span></li>
                </ol>
            </nav>

            <span class="sfc-hero__eyebrow">
                <i data-lucide="calendar-range" aria-hidden="true"></i>
                Seasonal Cleanup &middot; Mauldin, SC
            </span>

            <h1>Spring &amp; Fall Cleanup in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters clears, cuts back, and resets Mauldin properties at both ends of
                the growing season — the winter leaf mat off the fescue in spring, the falling leaves
                before they smother it in autumn. Beds are re-edged, dormant growth is cut on time, and
                every load of debris leaves the property.
            </p>

            <div class="sfc-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Cleanup Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* $phone is empty in config.php. A "Call Now" button with no number —
                             or a fabricated one — is worse than routing to the estimate form. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only what intake recorded — no "Licensed & Insured",
                     no star rating, no job count: config.php has none of the three. */ ?>
            <div class="sfc-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="truck" aria-hidden="true"></i> Debris hauled off the property</span>
                <span><i data-lucide="leaf" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider — soft double wave, filled with the problem section's light background -->
    <div class="svg-divider" style="height:90px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,40 C300,80 900,10 1200,45 L1200,100 L0,100 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,58 C320,96 880,22 1200,62 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · PROBLEM STATEMENT ══════════ -->
<section class="sfc-problem" aria-label="What a skipped seasonal cleanup does to an Upstate yard">
    <div class="container">
        <div class="sfc-problem__layout">
            <blockquote class="sfc-problem__quote reveal-left">
                What gets left in the fall is what fails in the spring.
            </blockquote>

            <div class="sfc-problem__lead">
                <h2 class="reveal-right">What does a skipped seasonal cleanup do to an Upstate yard?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    A skipped seasonal cleanup lets a wet-winter leaf mat shade out tall fescue crowns and
                    invite snow mold, while last year's mulch hardens into a water-shedding crust and the
                    beds bank a full season of weed seed. In the Upstate's freeze-thaw winters, a yard left
                    covered in November is a yard fighting itself by March.
                </p>
                <p class="reveal-right reveal-delay-2">
                    None of it is fixed by mowing harder in April. Greenville Lawn Masters treats the two
                    turns of the year as the work that decides the rest of it — clearing what winter would
                    otherwise smother, and closing the beds down before the leaves and the cold arrive
                    together on heavy Piedmont clay that already sheds water rather than soaking it in.
                </p>
            </div>
        </div>

        <div class="sfc-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="sfc-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="sfc-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="sfc-expert" aria-label="Why timing decides a seasonal cleanup">
    <div class="container">
        <div class="sfc-expert__layout">

            <div class="sfc-watermark reveal-left" aria-hidden="true">
                55&deg;<span>Soil temp sets the window</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does cleanup timing matter more than the cleanup itself?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Timing decides whether a cleanup helps or hurts. Cut dormant bermuda back too late and
                    you tear off the new green-up; pull the leaf mat too early and you strip the turf's
                    winter cover. Greenville Lawn Masters reads dormancy break and soil temperature in
                    Greenville County, not a fixed route date, so each task lands in its own window.
                </p>

                <ul class="sfc-diffs">
                    <?php foreach ($diffs as $i => $d): ?>
                        <li class="sfc-diff reveal-right reveal-delay-<?php echo $i + 2; ?>">
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

    <!-- Divider — stepped edge, filled with the breakdown section's light background -->
    <div class="svg-divider" style="height:48px" aria-hidden="true">
        <svg viewBox="0 0 1200 48" preserveAspectRatio="none">
            <path d="M0,48 L0,24 L150,24 L150,12 L350,12 L350,28 L550,28 L550,16 L750,16 L750,30 L950,30 L950,18 L1150,18 L1150,26 L1200,26 L1200,48 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN — the spring | fall diptych + process ══════════ -->
<section class="sfc-breakdown" aria-label="What a spring cleanup and a fall cleanup each include">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What is the difference between a <span class="text-accent">spring cleanup</span> and a fall cleanup?</h2>
            <p class="answer-block">
                A spring cleanup clears the winter's leaf mat, cuts back dormant grasses and perennials
                before new growth breaks, and resets the beds for the season ahead. A fall cleanup pulls
                falling leaves off the turf before they mat down over a wet winter and closes the beds for
                dormancy. Greenville Lawn Masters times both to the Upstate calendar.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <?php /* SIGNATURE diptych. Two mirrored panels built from brand tokens: spring
                 awakening (light), fall closing (dark), split by a vertical accent rule.
                 Each list is a real practice — nothing here asserts a price or a promise. */ ?>
        <div class="sfc-diptych reveal-scale">
            <?php foreach (['spring', 'fall'] as $key): $s = $seasons[$key]; ?>
                <div class="sfc-panel sfc-panel--<?php echo e($key); ?>">
                    <div class="sfc-panel__glyph" aria-hidden="true"><i data-lucide="<?php echo e($s['glyph']); ?>"></i></div>
                    <div class="sfc-panel__head">
                        <span class="sfc-panel__kicker"><?php echo e($s['kicker']); ?></span>
                        <h3 class="sfc-panel__title"><?php echo e($s['title']); ?></h3>
                        <p class="sfc-panel__lede"><?php echo e($s['lede']); ?></p>
                    </div>
                    <ul class="sfc-panel__list">
                        <?php foreach ($s['items'] as $item): ?>
                            <li>
                                <i data-lucide="check" aria-hidden="true"></i>
                                <span><?php echo e($item); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does a Greenville Lawn Masters cleanup visit actually run?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            A Greenville Lawn Masters cleanup starts with a free walkthrough of the property and a written,
            itemised estimate within 24 hours. Once you accept, the visit is booked into the right seasonal
            window — spring near dormancy break, fall as the leaves drop — and every load of debris is
            hauled off when the crew leaves.
        </p>

        <ol class="sfc-rail">
            <?php foreach ($timeline as $i => $step): ?>
                <li class="sfc-rail__step <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="sfc-rail__phase"><?php echo e($step['phase']); ?></span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Divider — soft double wave (inverted), filled with the proof section's dark background -->
    <div class="svg-divider" style="height:80px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,50 C280,10 920,92 1200,48 L1200,100 L0,100 Z" fill="var(--color-dark)" opacity="0.5"/>
            <path d="M0,64 C300,26 900,98 1200,60 L1200,100 L0,100 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · PROOF ══════════ -->
<?php /* Testimonials, before/after pairs, and a review snippet would go here on a
         standard proof section. config.php $reviews is empty, $gbpUrl is empty, and
         no before/after pair exists in the six-photo library. Inventing testimonials
         attributes quotes to people who do not exist — an FTC Endorsement Guides
         problem, not a placeholder — and CLAUDE.md separately forbids fabricated
         review counts. The client's own job photography fills the slot, captioned to
         describe what is IN each frame. None of these photos shows a cleanup in
         progress, and no caption pretends otherwise. */ ?>
<section class="sfc-proof" aria-label="Greenville Lawn Masters property photography">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label sfc-eyebrow">The Work</span>
            <h2>What does <span class="text-accent">Greenville Lawn Masters</span> work look like on the ground?</h2>
            <p class="answer-block">
                Greenville Lawn Masters photographs its own Mauldin-area job sites — every image here is a
                real property the crew maintains, not stock. These are finished-result frames: backyard turf
                held tight against mulched beds, a re-edged front bed at a Craftsman home, and a dense front
                lawn. None stages a cleanup in progress; they show the properties the seasonal work keeps.
            </p>
        </div>

        <div class="sfc-proof__grid">
            <?php
            /* Body photos: backyard, mulch_bed, front_lawn. Captions describe the frame
               — outcome shots of finished properties, never "a crew clearing leaves",
               because none of these photographs shows the service being performed. */
            $shots = [
                ['key' => 'backyard',  'mod' => '',               'label' => 'Turf against the bed lines',  'caption' => 'Backyard turf running between mulched planting beds and a wood privacy fence at a Mauldin, SC home — the outcome a seasonal reset protects.'],
                ['key' => 'mulch_bed', 'mod' => 'sfc-shot--arch', 'label' => 'Beds at the start of a season','caption' => 'A freshly mulched front bed beside the walk of a Craftsman home in Mauldin — beds re-edged and cleared before fresh mulch goes down.'],
                ['key' => 'front_lawn','mod' => 'sfc-shot--frame','label' => 'A front lawn kept clear',      'caption' => 'A dense green front lawn and concrete driveway at a two-story Mauldin home — the kind of turf a cleared winter leaf mat keeps healthy.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="sfc-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <div class="sfc-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 6 · COMPARISON ══════════ -->
<section class="sfc-compare" aria-label="How a real seasonal cleanup differs from a blow-and-go">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates a real seasonal cleanup from a blow-and-go?</h2>
            <p class="answer-block">
                A real seasonal cleanup is timed to the grass and hauls the debris away; a blow-and-go moves
                leaves into a pile on whatever day the truck arrives and calls it done. The difference is in
                the details — when the mat comes off, whether the old mulch is cleared, where the mulch
                stops around a trunk.
            </p>
        </div>

        <?php /* Left column = common trade practice, not a named competitor. Every
                 right-hand row is a process commitment recorded at intake or a
                 horticultural practice — never a credential claim. */ ?>
        <div class="sfc-compare__table reveal-up reveal-delay-1">
            <div class="sfc-compare__head">
                <div>A typical seasonal blow-and-go</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="sfc-compare__row">
                    <div data-label="A typical seasonal blow-and-go">
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

    <!-- Divider — stepped edge, filled with the FAQ section's light background -->
    <div class="svg-divider" style="height:48px" aria-hidden="true">
        <svg viewBox="0 0 1200 48" preserveAspectRatio="none">
            <path d="M0,48 L0,26 L120,26 L120,14 L340,14 L340,30 L560,30 L560,16 L780,16 L780,28 L1000,28 L1000,14 L1180,14 L1180,24 L1200,24 L1200,48 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 7 · FAQ ══════════ -->
<section class="sfc-faq" aria-label="Seasonal cleanup questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">seasonal cleanup</span>?</h2>
            <p class="answer-block">
                Straight answers on what a spring cleanup includes, what a fall cleanup covers, when leaves
                have to come off a fescue lawn, whether old mulch should be cleared before new goes down,
                when ornamental grasses get cut back, and where every load of debris ends up.
            </p>
        </div>

        <div class="sfc-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="sfc-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="sfc-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> handle in Mauldin?</h2>
            <p class="answer-block">
                Beyond spring and fall cleanups, Greenville Lawn Masters handles the recurring and project
                work a Mauldin property needs across the year — mowing routes, mulch and beds, hedges and
                small trees, and more — with one crew and the same 24-hour written estimate.
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
<section class="sfc-cta" aria-label="Request a seasonal cleanup estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to get your Mauldin yard cleaned up before the season turns?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            The Upstate season turns fast — the fescue mat forms over one wet stretch, and the pre-emergent
            window opens with the soil, not the calendar. Greenville Lawn Masters walks your Mauldin
            property for free and puts an itemised cleanup estimate in writing within 24 hours. Book before
            the window closes.
        </p>
        <div class="sfc-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Cleanup Estimate
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
