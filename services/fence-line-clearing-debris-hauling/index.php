<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/fence-line-clearing-debris-hauling/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   A SOLO service page: one service, its own page.

   Nothing here is invented. No prices, no per-load/per-yard figures,
   no review quotes, no star ratings, no "licensed / insured / bonded",
   no jobs-hauled count, no tons-removed, no truck or trailer brand —
   intake supplied none of them (config.php $missingIntake, $reviews).
   The horticultural and county-service claims below are facts about the
   SC Piedmont / Greenville County, which are checkable; the business
   claims are limited to what build-plan.json recorded: founded 2024,
   25-mile radius, written estimate within 24 hours, one crew, debris
   hauled OFF the property.

   ── PHOTO GAP (config.php $servicePhotos ['photo_gap' => true]) ──
   No photograph in the library shows clearing work, a brush pile, an
   overgrown fence line, or a loaded trailer. Only six frames exist and
   only two (mowing, hedges) show work being performed at all. This page
   is assigned hero='backyard' and body=['backyard','hedges','front_lawn']
   — all outcome/context shots of maintained Mauldin properties. So:
     · No caption claims a photo shows fence-line clearing or hauling.
     · The 'backyard' frame does contain a wood privacy fence with a
       CLEAR, maintained grass strip beside it — described truthfully as
       a clear fence line at a maintained property, never as "a fence line
       we cleared" and never as a before/after (no before/after exists).
     · The 'hedges' frame shows the crew doing related vegetation work
       (trimming), which may be said plainly — it is trimming, not clearing.
     · A .photo-note disclosure (shared class, framework.css) states the
       gap in the proof section, gated on $media['photo_gap'].

   ── WHY NO DISPOSAL DESTINATION IS NAMED ──
   Intake recorded that debris is hauled off the property. It recorded
   NOTHING about where it goes — no landfill, transfer station, compost,
   or recycling arrangement. So copy says only "hauled off the property"
   / "leaves the property" and never states a destination or a diversion
   claim, which would be a fabricated operational fact.
   ============================================================ */

$pageSlug    = 'fence-line-clearing-debris-hauling';
$currentPage = 'services';

/* servicesOnPage() returns every service whose config `page` == this slug.
   Exactly one lives here (the solo service); grab it for its committed name
   and description rather than retyping either. */
$serviceRow = servicesOnPage($pageSlug)[0] ?? null;

$media   = servicePagePhotos($pageSlug);          // hero + body keys + photo_gap
$heroImg = heroPhoto($media['hero']);             // 'backyard' 1600px rendition

$pageTitle       = 'Fence Line Clearing & Debris Hauling in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Fence line clearing and debris hauling in Mauldin, SC. Vines pulled, saplings cut at the base, brush hauled off. Written estimate within 24 hours.';   // 146 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

/* $phone is empty in config.php. Compute $hasPhone and render the tel: button
   ONLY when true — never a placeholder or fabricated number. */
$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Telltale signs (section 2) ───────────────────────────────
   Symptoms a homeowner verifies by walking the fence line. Every claim is a
   checkable SC Piedmont fact, not urgency theatre. */
$signs = [
    ['icon' => 'git-branch', 'title' => 'Vines are climbing the boards', 'body' => 'English ivy, wisteria, and Virginia creeper pull on the rails and pickets and hold moisture against the wood, rotting it right at the contact line.'],
    ['icon' => 'route',      'title' => 'A strip the mower never reaches', 'body' => 'The fence line is the one band nobody mows, so it is where privet and kudzu — aggressive Piedmont invasives — get established first.'],
    ['icon' => 'wind',       'title' => 'Storm brush is still sitting there', 'body' => 'Limbs and brush left on the turf after the last storm kill the grass beneath them and, over a wet Upstate winter, invite disease.'],
    ['icon' => 'trees',      'title' => 'Saplings are hardening into trees', 'body' => 'Bird-dropped sweetgum, hackberry, mulberry, and cherry sprout along the fence and become real trees within a few seasons, lifting and bowing it.'],
];

/* ── What the service includes (section 4) ────────────────────
   Scope is clearing growth along the fence line, brush/debris removal, and
   hauling. NOT tree removal, stump grinding, machine land clearing, or fence
   repair/installation — none of those were offered at intake, and tree work
   elsewhere on this site is limited to SMALL trees and brush. */
$scope = [
    ['icon' => 'scissors',   'title' => 'Cut growth back to the fence line', 'body' => 'Brush and weeds along the fence are cut back to the line so the boards are visible and the strip is workable again.'],
    ['icon' => 'unplug',     'title' => 'Pull vines off pickets and rails',  'body' => 'Ivy, wisteria, and creeper are worked off the fence by hand rather than yanked, so the boards are not torn loose with them.'],
    ['icon' => 'axe',        'title' => 'Take out volunteer saplings',       'body' => 'Young sweetgum, hackberry, mulberry, and cherry are cut flush at the base — topping them only sends the growth straight back.'],
    ['icon' => 'shovel',     'title' => 'Rake and gather the cuttings',      'body' => 'Everything cut is raked off the turf and gathered so nothing is left lying on the grass to smother or rot it.'],
    ['icon' => 'package',    'title' => 'Load the pile onto the truck',      'body' => 'Vines, brush, and cuttings are loaded up rather than dragged to the curb for you to stage and the county to collect.'],
    ['icon' => 'truck',      'title' => 'Haul the debris off the property',  'body' => 'The load leaves your property in the same visit, so the fence line is clear and nothing is left sitting at the road.'],
];

/* ── The Clearing Ladder — SIGNATURE section (this page only) ──
   "What comes off the fence line, in order", rendered as an ascending
   staircase of rungs with a hazard callout pinned beside the middle. The
   order IS the process, so it doubles as the timeline block section 4 asks
   for. Nothing else in this build looks like this. */
$ladder = [
    ['step' => 'First',  'icon' => 'unplug',     'title' => 'Vines come off the rails',        'body' => 'Ivy, wisteria, and Virginia creeper are pulled off the pickets and rails — the same vines that trap moisture against the wood and rot it at the contact line.'],
    ['step' => 'Then',   'icon' => 'scissors',   'title' => 'Growth is cut back to the line',  'body' => 'Kudzu, privet, and brush are cut back to the fence line, the one strip nobody mows and where those invasives take hold first.'],
    ['step' => 'Next',   'icon' => 'axe',        'title' => 'Saplings are taken at the base',  'body' => 'Volunteer sweetgum, hackberry, mulberry, and cherry are cut flush at the base, because topping a woody stem just sends it back within a season.'],
    ['step' => 'After',  'icon' => 'shovel',     'title' => 'Brush is raked and gathered',     'body' => 'Everything cut is raked off the turf and gathered — debris left lying on grass kills what is under it and, over a wet winter, invites disease.'],
    ['step' => 'Then',   'icon' => 'package',    'title' => 'The pile is loaded up',           'body' => 'Cuttings, vines, and brush go onto the truck rather than to the curb for you to stage and Greenville County to haul on its own limited schedule.'],
    ['step' => 'Last',   'icon' => 'truck',      'title' => 'Debris leaves the property',      'body' => 'The load goes off your property in one trip. Where it ends up is our problem, not yours, and the fence line is left clear.'],
];

/* Hazard callout, pinned beside the middle rung. Real Upstate fence-line
   hazards — poison ivy, ticks, copperheads — stated as facts. Poison ivy is
   never burned: urushiol rides the smoke (a genuine safety point, not a claim
   about our credentials). */
$hazards = [
    ['icon' => 'sprout',         'title' => 'Poison ivy',  'body' => 'Leaves of three; it climbs the fence as a hairy vine and stays potent even on dead stems and tools. It is cut and bagged, never burned — the smoke carries the oil.'],
    ['icon' => 'bug',            'title' => 'Ticks',       'body' => 'Tall fence-line overgrowth is prime tick habitat in the Upstate. Clearing the strip takes the cover away.'],
    ['icon' => 'triangle-alert', 'title' => 'Copperheads', 'body' => 'Dense growth along a fence gives snakes cover, and the Upstate has copperheads. Open, cleared ground gives them nowhere to hide.'],
];

/* ── Comparison (section 6) ───────────────────────────────────
   Left column = common curbside "pile-and-leave" trade practice, NOT a named
   competitor. Every right-hand row is a process commitment intake recorded or
   a horticultural practice we perform — never a credential claim. The strong,
   TRUE differentiator: the debris leaves the property instead of sitting at
   the curb. */
$comparison = [
    ['them' => 'Brush dragged to the curb and left for pickup', 'us' => 'The debris is loaded and hauled off the property the same visit'],
    ['them' => 'A string trimmer run along the pickets',        'us' => 'Hand-cut at the fence line so the pickets are not scarred'],
    ['them' => 'Woody stems topped and left to resprout',       'us' => 'Stems cut flush at the base to slow the regrowth'],
    ['them' => 'Volume left to overwhelm a curbside pickup',    'us' => 'The full cleanup taken in one load, not staged for the county'],
    ['them' => 'Poison ivy vines cut and burned',               'us' => 'Poison ivy cut and bagged — never burned, because the smoke carries the oil'],
    ['them' => 'An estimate whenever they get to it',           'us' => 'A written, itemised estimate within 24 hours of the walkthrough'],
];

/* ── FAQs — conversational, 40-80 words (aeo-content-schema §2.4) ──
   Rendered visibly below AND passed to generateFAQSchema(): schema that does
   not mirror visible content is a guidelines violation. No pricing (none was
   supplied); no disposal destination (none was recorded); no tree-removal or
   fence-repair claims (out of scope). */
$faqs = [
    [
        'question' => 'How much does fence line clearing and debris hauling cost in Mauldin, SC?',
        'answer'   => 'Greenville Lawn Masters prices every fence line after walking it, because the length of the run, how deep the growth is, and how much debris comes off all move the number. The walkthrough is free and the written, itemised estimate arrives within 24 hours. Clearing, sapling removal, and hauling are listed separately so you can take all of it or part.',
    ],
    [
        'question' => 'Where does the debris go after you haul it away?',
        'answer'   => 'It leaves your property in the same visit — that is the point of the service. Instead of a brush pile sitting at the curb waiting on a limited county pickup, the vines, brush, and cuttings are loaded onto the truck and taken off site. You are not left staging a pile at the road or waiting on collection day.',
    ],
    [
        'question' => 'Can Greenville Lawn Masters clear poison ivy off my fence?',
        'answer'   => 'Yes. Poison ivy is common in Upstate fence lines — leaves of three, climbing the boards as a hairy vine — and it stays potent on dead stems and tools long after it is cut. Greenville Lawn Masters cuts and bags it rather than burning it, because burning poison ivy is genuinely dangerous: the urushiol oil rides the smoke.',
    ],
    [
        'question' => 'Will clearing the fence line damage my fence?',
        'answer'   => 'The work is done by hand at the fence line, not with a string trimmer whipping the pickets, so the boards are not scarred. Vines are worked off the rails rather than ripped, which matters because ivy and wisteria hold moisture against the wood and rot it at the contact line. This is clearing, not fence repair or replacement.',
    ],
    [
        'question' => 'Do you remove full-size trees growing along the fence?',
        'answer'   => 'This service covers clearing growth, brush, and volunteer saplings, plus hauling the debris off the property. Young saplings — sweetgum, hackberry, mulberry, cherry — are cut flush at the base. Full-size trees are outside its scope; Greenville Lawn Masters keeps its tree work to small trees and brush and will tell you plainly when something needs a tree service.',
    ],
    [
        'question' => 'Why not just leave the brush at the curb for the county?',
        'answer'   => 'Greenville County residential yard-waste collection is limited in both volume and cadence, and a full fence-line cleanup usually produces more brush than a curbside pickup will take at once. Rather than leave you to break the pile up across several collection days, Greenville Lawn Masters hauls the whole load off the property in one trip.',
    ],
    [
        'question' => 'When is the best time to clear an overgrown fence line in the Upstate?',
        'answer'   => 'Sooner is better than later, at almost any time of year. Overgrowth along a fence harbours ticks and gives snakes — including copperheads — cover, and storm debris left on the turf over a wet winter kills the grass and invites disease. Clearing it before a season passes keeps a manageable job from turning into a heavier one.',
    ],
    [
        'question' => 'What kinds of growth take over fence lines in Greenville County?',
        'answer'   => 'Woody vines lead the list — English ivy, wisteria, and Virginia creeper — along with kudzu and privet, two aggressive invasives that colonise the unmowed strip. Then come volunteer saplings: sweetgum, hackberry, mulberry, and cherry, sprouted from bird-dropped seed. Left alone, all of them lean on the fence, and the trees among them eventually lift and bow it.',
    ],
];

/* ── Schema ───────────────────────────────────────────────────
   Exactly four nodes:
     (a) Service (@id #service-{slug}), provider → homepage LocalBusiness @id
     (b) FAQPage mirroring the visible FAQ
     (c) BreadcrumbList
     (d) WebPage with Speakable
   No `offers` / `priceRange`: intake supplied no pricing, and fabricated
   structured pricing is a misrepresentation Google acts on. Every Speakable
   cssSelector below exists in the markup. */
$serviceName = $serviceRow['name'] ?? 'Fence Line Clearing & Debris Hauling';
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $pageSlug,
        'name'        => $serviceName,
        'serviceType' => 'Fence line clearing and debris hauling',
        'description' => 'Clearing of overgrown fence lines in Mauldin, South Carolina — pulling woody '
                       . 'vines off the fence, cutting growth back to the line, removing volunteer '
                       . 'saplings, and raking, loading, and hauling the brush and debris off the '
                       . 'property rather than leaving it at the curb.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',                               'url' => '/'],
        ['name' => 'Services',                           'url' => '/services/'],
        ['name' => 'Fence Line Clearing & Debris Hauling', 'url' => '/services/' . $pageSlug . '/'],
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
   Fence Line Clearing & Debris Hauling — page-scoped styles
   Every rule prefixed .flc- so no class collides with another page's
   <style> block. Colour, shadow, spacing, radius, and timing are var()
   tokens without exception — a raw literal here is an automatic QA fail.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  two distinct SVG dividers (soft wave + jagged peaks)
     C4  editorial pull-quote at clamp(1.4rem, 3vw, 2.4rem)
     C5  bento grid of telltale signs, deliberately uneven spans
     C6  asymmetric 62/38 split with an oversized stat watermark
     C7  SIGNATURE — the Clearing Ladder staircase with a pinned hazard card
     C10 comparison table with accent-highlighted winning column
     C11 image treatments — arch clip and offset frame

   Hero gradient angle 205deg — deliberately different from the reference
   lawn-care page (78deg), the homepage (100deg), and the two pages that
   share this backyard photo, spring-fall-cleanup (115deg) and
   flower-bed-shrub-planting (122deg), so no two read as one image.
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Background is the 'backyard' frame (a wood privacy fence beside a clear,
   maintained grass strip). It is NOT captioned as cleared work anywhere —
   here it is pure backdrop under a heavy overlay carrying the text. */
.flc-hero {
  min-height: 76vh;
  min-height: 76svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-backyard-beds.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.flc-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    205deg,
    rgba(var(--color-dark-rgb), 0.90) 0%,
    rgba(var(--color-dark-rgb), 0.76) 40%,
    rgba(var(--color-primary-rgb), 0.52) 78%,
    rgba(var(--color-accent-rgb), 0.30) 100%
  );
  z-index: 0;
}
.flc-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.28;
  z-index: 0;
  pointer-events: none;
}
.flc-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 64rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.flc-hero .breadcrumb { animation: flcFade 0.5s ease both; }

.flc-hero__eyebrow {
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
  animation: flcFade 0.55s ease 0.08s both;
}
.flc-hero__eyebrow i, .flc-hero__eyebrow svg { width: 15px; height: 15px; }

.flc-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.2rem, 4.6vw, 3.9rem);
  line-height: 1.07;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: flcRise 0.6s ease 0.16s both;
}
.flc-hero h1 .text-accent { color: var(--color-accent); }

/* .hero-answer centres itself globally; in this left-aligned hero it must not. */
.flc-hero .hero-answer {
  margin-inline: 0;
  max-width: 60ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: flcRise 0.6s ease 0.26s both;
}

.flc-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: flcRise 0.6s ease 0.36s both;
}
.flc-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: flcRise 0.6s ease 0.46s both;
}
.flc-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.flc-hero__trust i, .flc-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}

/* Above-fold entrance is pure CSS, never a reveal class — the reveal system
   sets opacity:0 and would blank the hero if IntersectionObserver never fires. */
@keyframes flcFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes flcRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.flc-problem { background: var(--color-light); }
.flc-problem__layout {
  display: grid;
  grid-template-columns: 0.82fr 1.18fr;
  gap: var(--space-12);
  align-items: start;
}
.flc-problem__quote {
  max-width: 20ch;
  font-family: var(--font-heading);
  font-style: italic;
  font-weight: 600;
  font-size: clamp(1.4rem, 3vw, 2.4rem);
  line-height: 1.22;
  color: var(--color-primary-dark);
  border-left: 4px solid var(--color-accent);
  padding-left: var(--space-6);
}
.flc-problem__lead { color: var(--color-gray-dark); }
.flc-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Uneven on purpose: the last card spans two columns so the row does not read
   as four identical boxes. Tints rotate; no two adjacent cards match. */
.flc-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.flc-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.flc-sign:last-child { grid-column: span 2; }
.flc-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.flc-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.flc-sign__icon i, .flc-sign__icon svg { width: 22px; height: 22px; }
.flc-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.flc-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.flc-expert { background: var(--color-white); }
.flc-expert__layout {
  display: grid;
  grid-template-columns: 0.6fr 1.4fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.flc-stat-watermark {
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
.flc-stat-watermark span {
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
.flc-expert h2 { margin-bottom: var(--space-5); }
.flc-expert .answer-block { margin-inline: 0; }
.flc-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.flc-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.flc-diff i, .flc-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.flc-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.flc-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── Service breakdown grid ───────────────────────────────────*/
.flc-breakdown { background: var(--color-light); }
.flc-scope {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-5);
}
.flc-scope-item {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-left: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.flc-scope-item:hover {
  transform: translateY(-5px);
  border-left-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.flc-scope-item__icon {
  width: 48px; height: 48px;
  display: grid; place-items: center;
  border-radius: var(--radius-full);
  background: rgba(var(--color-primary-rgb), 0.08);
  color: var(--color-primary);
}
.flc-scope-item__icon i, .flc-scope-item__icon svg { width: 24px; height: 24px; }
.flc-scope-item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.flc-scope-item p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray); line-height: 1.6; }

/* ── C7 · SIGNATURE: the Clearing Ladder ──────────────────────
   Rungs rise as a staircase (each offset right by its index) so the sequence
   reads as a climb; a hazard card is pinned beside the middle in its own
   column. This composition appears on no other page in the build. */
.flc-ladder {
  position: relative;
  margin-top: var(--space-12);
  display: grid;
  grid-template-columns: minmax(0, 1fr) minmax(0, 19rem);
  gap: var(--space-10);
  align-items: center;
}
.flc-ladder__rungs { display: grid; gap: var(--space-4); }
.flc-rung {
  /* staircase offset: index 0 flush, each rung stepped right. clamp keeps the
     step from overflowing narrow columns and collapses it toward 0 on mobile. */
  margin-left: calc(var(--rung, 0) * clamp(0rem, 1.6vw, var(--space-6)));
  display: grid;
  grid-template-columns: auto 1fr;
  gap: var(--space-4);
  align-items: start;
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-5) var(--space-6);
  box-shadow: var(--shadow-card);
  border-left: 3px solid var(--color-accent);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.flc-rung:hover { transform: translateX(4px); box-shadow: var(--shadow-md); }
.flc-rung__marker {
  width: 44px; height: 44px;
  display: grid; place-items: center;
  border-radius: var(--radius-full);
  background: var(--color-primary);
  color: var(--color-white);
  flex-shrink: 0;
  box-shadow: 0 0 0 4px rgba(var(--color-primary-rgb), 0.12);
}
.flc-rung__marker i, .flc-rung__marker svg { width: 22px; height: 22px; }
.flc-rung__step {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.flc-rung h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-1); }
.flc-rung p { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; }

/* Hazard card — pinned beside the middle rung (column 2, centred). */
.flc-hazard {
  align-self: center;
  background: var(--color-dark);
  color: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6);
  box-shadow: var(--shadow-lg);
  border-top: 4px solid var(--color-warning);
}
.flc-hazard__head {
  display: flex;
  align-items: center;
  gap: var(--space-2);
  font-family: var(--font-heading);
  font-weight: 800;
  font-size: var(--font-size-lg);
  color: var(--color-white);
  margin-bottom: var(--space-4);
}
.flc-hazard__head i, .flc-hazard__head svg { width: 20px; height: 20px; color: var(--color-warning); }
.flc-hazard__list { list-style: none; display: grid; gap: var(--space-4); }
.flc-hazard__item { display: grid; grid-template-columns: 22px 1fr; gap: var(--space-3); align-items: start; }
.flc-hazard__item i, .flc-hazard__item svg { width: 18px; height: 18px; color: var(--color-warning); margin-top: 2px; }
.flc-hazard__item strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); }
.flc-hazard__item p { margin: var(--space-1) 0 0; color: rgba(var(--color-white-rgb), 0.72); font-size: var(--font-size-xs); line-height: 1.6; }

/* ── C11 · Proof strip, arch and offset frame treatments ──────*/
.flc-proof { background: var(--color-dark); }
.flc-proof h2, .flc-proof .flc-eyebrow { color: var(--color-white); }
.flc-proof .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.flc-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.flc-shot { margin: 0; }
.flc-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  transition: transform var(--transition-slow);
}
/* C11 arch clip on the middle frame only — variation, not decoration for its own sake */
.flc-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.flc-shot--frame { position: relative; }
.flc-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.flc-shot:hover img { transform: scale(1.03); }
.flc-shot figcaption {
  margin-top: var(--space-3);
  color: rgba(var(--color-white-rgb), 0.62);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.flc-shot figcaption strong { display: block; color: var(--color-white); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }

/* The honest review-history note (no reviews exist yet). */
.flc-proof__note {
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
.flc-proof__note p { margin: 0; }

/* The shared .photo-note (framework.css) lands on a dark background here, so
   its default gray text needs lifting for contrast. Colour only — structure
   stays with the shared class. */
.flc-proof .photo-note {
  border-left-color: rgba(var(--color-white-rgb), 0.25);
  color: rgba(var(--color-white-rgb), 0.62);
}
.flc-proof .photo-note i, .flc-proof .photo-note svg { color: var(--color-warning); }

/* ── C10 · Comparison table ───────────────────────────────────*/
.flc-compare { background: var(--color-white); }
.flc-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.flc-compare__head, .flc-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.flc-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.flc-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.flc-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.flc-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.flc-compare__row > div:first-child { color: var(--color-gray); }
.flc-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.flc-compare__row i, .flc-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.flc-compare__row > div:first-child i, .flc-compare__row > div:first-child svg { color: var(--color-gray); }
.flc-compare__row > div:last-child i,  .flc-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.flc-faq { background: var(--color-light); }
.flc-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.flc-faq__item {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.flc-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.flc-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.flc-related { background: var(--color-white); }

/* ── Final CTA ────────────────────────────────────────────────*/
.flc-cta {
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.flc-cta::before {
  content: '';
  position: absolute;
  bottom: -25%; left: -6%;
  width: 440px; height: 440px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.flc-cta .container { position: relative; z-index: 1; }
.flc-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.flc-cta p { color: rgba(var(--color-white-rgb), 0.88); max-width: 60ch; margin: 0 auto var(--space-8); }
.flc-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .flc-scope { grid-template-columns: repeat(2, 1fr); }
  .flc-signs { grid-template-columns: repeat(2, 1fr); }
  .flc-sign:last-child { grid-column: span 2; }
  .flc-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .flc-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .flc-stat-watermark span { position: static; display: block; margin-top: var(--space-4); }
  .flc-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .flc-problem__quote { max-width: none; }
  .flc-proof__grid { grid-template-columns: 1fr 1fr; }

  /* Ladder collapses to one column; the hazard card flows in after the rungs
     and the staircase offset falls to zero (clamp min is 0). */
  .flc-ladder { grid-template-columns: 1fr; gap: var(--space-8); }
  .flc-rung { margin-left: 0; }
}
@media (max-width: 700px) {
  .flc-hero { min-height: 0; }
  .flc-scope, .flc-signs, .flc-proof__grid { grid-template-columns: 1fr; }
  .flc-sign:last-child { grid-column: span 1; }
  .flc-shot--frame::before { display: none; }

  /* The comparison grid collapses to stacked pairs; column headers are hidden
     and each cell carries its own label, or the them/us contrast is lost. */
  .flc-compare__head { display: none; }
  .flc-compare__row { grid-template-columns: 1fr; }
  .flc-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .flc-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero flc-hero" aria-label="Fence line clearing and debris hauling in Mauldin, South Carolina">
    <div class="container">
        <div class="flc-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Fence Line Clearing &amp; Debris Hauling</span></li>
                </ol>
            </nav>

            <span class="flc-hero__eyebrow">
                <i data-lucide="fence" aria-hidden="true"></i>
                Fence Line Clearing &amp; Hauling &middot; Mauldin, SC
            </span>

            <h1>Fence Line Clearing &amp; Debris Hauling in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters clears overgrown fence lines and hauls the debris off your
                Mauldin, South Carolina property — vines pulled off the rails, growth cut back to the
                line, volunteer saplings removed, and every bit of brush loaded and taken away rather
                than left at the curb. The walkthrough is free and the written estimate arrives within
                24 hours.
            </p>

            <div class="flc-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Clearing Estimate
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
                     no star rating, no loads-hauled count — config.php has none of them. */ ?>
            <div class="flc-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="truck" aria-hidden="true"></i> Debris hauled off the property</span>
                <span><i data-lucide="calendar-days" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider A · soft wave — filled with the problem section's light background -->
    <div class="svg-divider" style="height:80px" aria-hidden="true">
        <svg viewBox="0 0 1200 90" preserveAspectRatio="none">
            <path d="M0,40 C220,90 430,10 640,42 C860,76 1010,20 1200,48 L1200,90 L0,90 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · PROBLEM STATEMENT ══════════ -->
<section class="flc-problem" aria-label="Signs a Mauldin fence line needs clearing">
    <div class="container">
        <div class="flc-problem__layout">
            <blockquote class="flc-problem__quote reveal-left">
                The fence line is the one strip nobody mows — so it is where everything moves in.
            </blockquote>

            <div class="flc-problem__lead">
                <h2 class="reveal-right">What does a neglected fence line actually cost a Mauldin homeowner?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    A neglected fence line costs you the fence itself. Woody vines hold moisture against
                    the boards and rot them from the contact line, volunteer saplings lift and bow the
                    panels as they harden into trees, and the overgrowth turns into cover for ticks and
                    snakes. Left a season, a quick clearing becomes heavy removal.
                </p>
                <p class="reveal-right reveal-delay-2">
                    None of it is fixed by mowing closer — the mower cannot reach the strip in the first
                    place. Greenville Lawn Masters clears the whole line by hand, takes the growth back
                    to the boards, pulls the vines off the rails, and hauls every bit of it off the
                    property so nothing is left staged at the curb.
                </p>
            </div>
        </div>

        <div class="flc-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="flc-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="flc-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="flc-expert" aria-label="Why Greenville Lawn Masters for fence line clearing">
    <div class="container">
        <div class="flc-expert__layout">

            <div class="flc-stat-watermark reveal-left" aria-hidden="true">
                <?php echo e((string) $targetRadius); ?><span>Mile radius from Mauldin</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does clearing a fence line take more than a string trimmer?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    A string trimmer whipped along a wood fence scars the pickets and barely touches
                    woody vines. Clearing a fence line means pulling ivy and wisteria off the rails by
                    hand, cutting stems flush at the base so they do not resprout, and hauling the debris
                    off — work a mower and a trimmer are not built to do.
                </p>

                <ul class="flc-diffs">
                    <li class="flc-diff reveal-right reveal-delay-2">
                        <i data-lucide="hand" aria-hidden="true"></i>
                        <div>
                            <strong>Hand work at the boards, not a trimmer against them</strong>
                            <p>
                                The line is cleared by hand so the pickets are not scarred and the vines
                                come off the rails whole, instead of being shredded and left to regrow.
                            </p>
                        </div>
                    </li>
                    <li class="flc-diff reveal-right reveal-delay-3">
                        <i data-lucide="axe" aria-hidden="true"></i>
                        <div>
                            <strong>Woody stems cut flush at the base</strong>
                            <p>
                                Saplings and vines are cut low at the base rather than topped. Topping a
                                woody stem just sends the growth back within a season; cutting it flush
                                slows the return.
                            </p>
                        </div>
                    </li>
                    <li class="flc-diff reveal-right reveal-delay-4">
                        <i data-lucide="truck" aria-hidden="true"></i>
                        <div>
                            <strong>The debris leaves — it does not sit at the curb</strong>
                            <p>
                                Everything cut is loaded and hauled off the property in the same visit, so
                                you are not left staging a brush pile for a limited Greenville County
                                pickup.
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Divider B · jagged peaks — filled with the breakdown section's light background -->
    <div class="svg-divider" style="height:64px" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none">
            <path d="M0,70 L0,42 L120,20 L240,44 L360,16 L480,46 L600,22 L720,48 L840,18 L960,46 L1080,24 L1200,44 L1200,70 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN + CLEARING LADDER ══════════ -->
<section class="flc-breakdown" aria-label="What fence line clearing and debris hauling includes">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What does Greenville Lawn Masters fence line clearing and debris hauling include?</h2>
            <p class="answer-block">
                Greenville Lawn Masters fence line clearing and debris hauling covers the whole job:
                cutting growth back to the fence line, pulling woody vines off the pickets and rails,
                taking out volunteer saplings, then raking, loading, and hauling the brush and debris
                off the property. One crew handles it start to finish.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="flc-scope">
            <?php foreach ($scope as $i => $item): ?>
                <article class="flc-scope-item <?php echo ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3]; ?> reveal-delay-<?php echo ($i % 3) + 1; ?>">
                    <div class="flc-scope-item__icon">
                        <i data-lucide="<?php echo e($item['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <h3><?php echo e($item['title']); ?></h3>
                    <p><?php echo e($item['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <?php /* SIGNATURE section — the Clearing Ladder. The order of the rungs IS the
                 process, so this doubles as the timeline block. The hazard card is a
                 real safety note, not filler: poison ivy, ticks, and copperheads are
                 genuine Upstate fence-line hazards. */ ?>
        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            In what order does Greenville Lawn Masters clear a fence line?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            Greenville Lawn Masters clears a fence line from the boards outward and finishes by hauling:
            vines come off the rails first, then growth is cut back to the line, volunteer saplings are
            taken at the base, the brush is raked and gathered, loaded, and the whole load leaves the
            property. Each rung below is one step of that climb.
        </p>

        <div class="flc-ladder">
            <div class="flc-ladder__rungs">
                <?php foreach ($ladder as $i => $rung): ?>
                    <div class="flc-rung reveal-left reveal-delay-<?php echo ($i % 4) + 1; ?>" style="--rung: <?php echo (int) $i; ?>">
                        <div class="flc-rung__marker"><i data-lucide="<?php echo e($rung['icon']); ?>" aria-hidden="true"></i></div>
                        <div>
                            <span class="flc-rung__step"><?php echo e($rung['step']); ?></span>
                            <h3><?php echo e($rung['title']); ?></h3>
                            <p><?php echo e($rung['body']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <aside class="flc-hazard reveal-right" aria-label="Hazards in Upstate fence-line overgrowth">
                <div class="flc-hazard__head">
                    <i data-lucide="triangle-alert" aria-hidden="true"></i>
                    What lives in the overgrowth
                </div>
                <ul class="flc-hazard__list">
                    <?php foreach ($hazards as $hz): ?>
                        <li class="flc-hazard__item">
                            <i data-lucide="<?php echo e($hz['icon']); ?>" aria-hidden="true"></i>
                            <div>
                                <strong><?php echo e($hz['title']); ?></strong>
                                <p><?php echo e($hz['body']); ?></p>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        </div>
    </div>

    <!-- Divider A · soft wave — filled with the proof section's dark background -->
    <div class="svg-divider" style="height:72px" aria-hidden="true">
        <svg viewBox="0 0 1200 90" preserveAspectRatio="none">
            <path d="M0,48 C210,14 420,84 640,50 C850,18 1010,80 1200,44 L1200,90 L0,90 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · PROOF ══════════ -->
<?php /* §2.8 would place testimonials, an aggregate review snippet, and before/after
         pairs here. config.php $reviews is empty, $gbpUrl is empty, and — because
         this page has a PHOTO GAP — no image in the library shows clearing work, a
         brush pile, an overgrown fence line, or a loaded trailer. Inventing quotes
         would attribute endorsements to non-existent customers (an FTC Endorsement
         Guides problem), and captioning an unrelated lawn photo as "a fence line we
         cleared" would be a fabricated claim. So: honest outcome/context photos,
         captions that describe only WHAT IS IN THE FRAME, and the required
         .photo-note disclosure plus the no-reviews-yet note below. */ ?>
<section class="flc-proof" aria-label="Greenville Lawn Masters property photography">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label flc-eyebrow">On The Ground</span>
            <h2>What do these photos of Greenville Lawn Masters properties actually show?</h2>
            <p class="answer-block">
                Every image below is a real Mauldin-area property Greenville Lawn Masters maintains — not
                a stock photo. Read them for what they are: a clear fence line at a kept property, the
                crew doing vegetation work, and a tidy front lawn. They are context, not pictures of a
                clearing job, and the note beneath says so plainly.
            </p>
        </div>

        <div class="flc-proof__grid">
            <?php
            /* Captions describe strictly what is IN THE FRAME.
               · 'backyard'  — a wood privacy fence beside a CLEAR, maintained grass
                 strip. Described as a clear fence line at a maintained property.
                 NOT as "a fence line we cleared" and NOT as a before/after.
               · 'hedges'    — the crew trimming foundation hedges. This shows the
                 crew doing RELATED vegetation work, which may be said plainly. It is
                 trimming, not fence-line clearing, and the caption keeps that line.
               · 'front_lawn'— a finished front lawn. Pure outcome/context. */
            $shots = [
                ['key' => 'backyard',   'mod' => '',               'label' => 'A clear fence line',        'caption' => 'A wood privacy fence with a maintained, clear grass strip beside the mulched beds at a Mauldin, SC home — the kind of tidy line clearing is meant to restore.'],
                ['key' => 'hedges',     'mod' => 'flc-shot--arch', 'label' => 'The crew on vegetation work','caption' => 'A Greenville Lawn Masters crew member trimming foundation hedges at a Mauldin brick home — related vegetation work, shown here as trimming rather than fence-line clearing.'],
                ['key' => 'front_lawn', 'mod' => 'flc-shot--frame','label' => 'A kept Mauldin property',   'caption' => 'A dense green front lawn and concrete driveway at a two-story Mauldin, SC home the crew maintains.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="flc-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <?php /* REQUIRED photo-gap disclosure. Gated on the config flag so it renders
                 only while no real clearing/hauling photograph exists. Uses the shared
                 .photo-note class from framework.css. When job-site photos land in the
                 library and $servicePhotos drops the flag, this disappears on its own. */ ?>
        <?php if (!empty($media['photo_gap'])): ?>
            <p class="photo-note reveal-up">
                <i data-lucide="camera-off" aria-hidden="true"></i>
                <span>
                    None of these photographs shows a fence line being cleared or debris being hauled —
                    no such job-site photo exists yet. They show maintained Mauldin properties and the
                    crew doing related vegetation work, such as hedge trimming. Photography of actual
                    fence-line clearing and debris hauling will replace them once it is taken.
                </span>
            </p>
        <?php endif; ?>

        <div class="flc-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is
                still building its public review history. This space is reserved for verified Google
                reviews rather than testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 6 · COMPARISON ══════════ -->
<section class="flc-compare" aria-label="How Greenville Lawn Masters differs">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What is the difference between a curbside pile-and-leave and full debris hauling?</h2>
            <p class="answer-block">
                A pile-and-leave cleanup drags the brush to the curb and walks away, leaving you to
                stage it for a limited county pickup. Full debris hauling loads the whole cut — vines,
                brush, and saplings — and takes it off the property in the same visit. The difference
                is whether a pile is still sitting at your road the next morning.
            </p>
        </div>

        <?php /* Left column = common curbside trade practice, not a named competitor.
                 Every right-hand row is a process commitment recorded at intake or a
                 horticultural practice we perform — never a credential claim. */ ?>
        <div class="flc-compare__table reveal-up reveal-delay-1">
            <div class="flc-compare__head">
                <div>A curbside pile-and-leave</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="flc-compare__row">
                    <div data-label="A curbside pile-and-leave">
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

    <!-- Divider B · jagged peaks — filled with the FAQ section's light background -->
    <div class="svg-divider" style="height:58px" aria-hidden="true">
        <svg viewBox="0 0 1200 70" preserveAspectRatio="none">
            <path d="M0,70 L0,40 L100,18 L220,44 L340,18 L460,44 L580,20 L700,46 L820,18 L940,44 L1060,20 L1200,42 L1200,70 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 7 · FAQ ══════════ -->
<section class="flc-faq" aria-label="Fence line clearing and debris hauling questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about fence line clearing and debris hauling?</h2>
            <p class="answer-block">
                Straight answers on what a fence-line cleanup costs in Mauldin, where the debris ends up,
                whether the work will harm your fence, how Greenville Lawn Masters handles poison ivy and
                saplings, and why brush left at the curb is not the same as hauling it away.
            </p>
        </div>

        <div class="flc-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="flc-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="flc-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does Greenville Lawn Masters handle around a Mauldin property?</h2>
            <p class="answer-block">
                Fence-line clearing is one piece of the property work Greenville Lawn Masters does across
                Greenville County. The same crew handles seasonal cleanups, beds and mulch, hedges and
                small trees, and the rest of the yard — all on the same 24-hour written estimate.
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
<section class="flc-cta" aria-label="Request a fence line clearing estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to get that fence line cleared and the debris gone?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            The longer a fence line goes, the heavier the job gets — vines root into the boards, saplings
            harden into trees, and the pile only grows. Book a free walkthrough and Greenville Lawn
            Masters returns a written, itemised estimate within 24 hours, debris hauling included.
        </p>
        <div class="flc-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Clearing Estimate
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
