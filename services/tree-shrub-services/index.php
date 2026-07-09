<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /services/tree-shrub-services/index.php — Phase 4
   Greenville Lawn Masters · Mauldin, SC

   The pruning-and-cleanup group page: 5 of the 22 services
   (edging, leaf/storm cleanup, hedge & shrub trimming, small
   tree trimming & brush removal, pet waste removal).

   Nothing on this page is invented. No prices or "starting at",
   no review quotes or star ratings, no "licensed and insured",
   no ISA/arborist credential, no jobs-completed or trees-trimmed
   count — build-plan.json supplied none of them (see config.php
   $missingIntake and the $reviews note). The horticultural claims
   are checkable facts about the SC Piedmont / zone 7b-8a; the
   business claims are limited to what intake recorded: founded
   2024, based in Mauldin 29662, 25-mile radius, one crew, free
   walkthrough, written itemised estimate within 24 hours.

   PHOTO HONESTY: only ONE photo on this page ('hedges') shows this
   kind of work being performed — a crew member shaping foundation
   hedges. There is NO photo of tree trimming, leaf removal, or pet
   waste removal, so no caption or alt attribute claims one exists.
   The other two frames ('backyard', 'mulch_bed') are honest outcome
   shots and are captioned as exactly what is in frame.
   ============================================================ */

$pageSlug    = 'tree-shrub-services';
$currentPage = 'services';

$servicesHere = servicesOnPage($pageSlug);   // 5 services, config.php order
$media        = servicePagePhotos($pageSlug); // hero=hedges, body=[hedges,backyard,mulch_bed]
$heroImg      = heroPhoto($media['hero']);

$pageTitle       = 'Tree & Shrub Services in Mauldin, SC | Greenville Lawn Masters';
$pageDescription = 'Tree and shrub services in Mauldin, SC: hedge trimming, small tree pruning, leaf and storm debris cleanup, and edging. Written estimate within 24 hours.';   // 152 chars (CLAUDE.md: 140-160)

$canonicalUrl     = $siteUrl . '/services/' . $pageSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];   // /assets/images/hero-mauldin-hedge-trimming.jpg

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Telltale signs (problem statement) ───────────────────────
   Symptoms a homeowner can verify by walking the yard, each tied to the
   horticultural cause. No urgency theatre — specificity instead. */
$signs = [
    ['icon' => 'home',           'title' => 'Hedges have swallowed the windows',   'body' => 'Foundation shrubs left to run climb over sills and into the gutter line, trapping moisture against siding and blocking the light the front rooms used to get.'],
    ['icon' => 'cloud-lightning','title' => 'A limb is hung up in the canopy',      'body' => 'A branch snapped by an Upstate thunderstorm but still lodged overhead is a "widowmaker." It does not belong to a ladder and it will not fall where you expect.'],
    ['icon' => 'layers',         'title' => 'Leaves are matting over the fescue',   'body' => 'A wet leaf blanket left on tall fescue through a Piedmont winter shades out the crown and invites snow mold, so the shade lawn comes up thin in March.'],
    ['icon' => 'flower-2',       'title' => 'A shrub stopped blooming',             'body' => 'An azalea or forsythia that leafs out but never flowers was almost always sheared at the wrong time of year — the buds for this spring were cut off last winter.'],
];

/* ── Service → Lucide icon (all different, per CLAUDE.md) ──────
   Keyed by config slug so the map can never drift from the service list. */
$serviceIcons = [
    'edging-string-trimming'            => 'scissors',
    'leaf-removal-storm-debris-cleanup' => 'wind',
    'hedge-shrub-trimming'              => 'shrub',
    'tree-trimming-brush-removal'       => 'tree-pine',
    'pet-waste-removal'                 => 'dog',
];

/* ── Differentiators (expert positioning) ─────────────────────
   Every one is a horticultural practice we perform, never a credential.
   Intake supplied no license, insurance, or certification, so none is
   claimed here or anywhere else on the page. */
$differentiators = [
    ['icon' => 'calendar-check', 'title' => 'Every shrub is pruned on its own bloom clock', 'body' => 'Spring bloomers are cut right after the flowers fade, before next year\'s buds set. Summer bloomers and crape myrtle are cut in late winter while dormant. One blanket "trim everybody" date guarantees half the yard is done at the wrong moment.'],
    ['icon' => 'scissors',       'title' => 'Crape myrtles are pruned, never topped',       'body' => 'Topping a crape myrtle to knuckled stubs — "crape murder" — forces weak, whippy regrowth that flops under its own flowers. The cut instead removes crossing branches and suckers at the collar so the tree keeps its natural frame.'],
    ['icon' => 'shield-check',   'title' => 'No more than about a quarter comes off at once', 'body' => 'Taking more than roughly 25% of a shrub\'s canopy in one season stresses it into a survival flush. Cuts are made just outside the branch collar and left to seal on their own — wound paint traps moisture and is no longer recommended.'],
];

/* ── Process timeline (rendered on the vertical rail) ─────────*/
$timeline = [
    ['phase' => 'Visit 1',    'title' => 'Plant-by-plant walkthrough', 'body' => 'Each shrub and small tree is read on foot — species, bloom time, crossing or dead wood, and any storm damage hung up overhead. What can be pruned now and what should wait for its window are both noted, out loud.'],
    ['phase' => 'Within 24h', 'title' => 'Written, itemised estimate', 'body' => 'The estimate lands within a day of the walkthrough, priced line by line. Hedge work, tree and brush removal, leaf cleanup, edging, and pet waste service are quoted separately, so you can take the whole list or a single item.'],
    ['phase' => 'Scheduled',  'title' => 'Timed to the plant, not the truck', 'body' => 'Anything bloom-sensitive is booked to its month rather than whenever the route reaches you. Storm and brush cleanup, edging, and leaf removal are scheduled as soon as the property needs them.'],
    ['phase' => 'On the day', 'title' => 'Cut clean, then clean up', 'body' => 'Cuts are made at the branch collar with sharp tools. Hung-up limbs are brought down from the ground, never off a ladder. Debris leaves the property and every drive, walk, and patio is blown clean before the crew does.'],
];

/* ── Seasonal pruning calendar (signature section) ────────────
   The horticulture is verifiable for Upstate SC / zone 7b-8a. The primary
   keyword — "leaf removal & storm debris cleanup" — lands honestly in Fall,
   which is when that work actually happens. */
$calendar = [
    [
        'season' => 'Winter',
        'icon'   => 'snowflake',
        'tag'    => 'Dormant season',
        'items'  => [
            'Summer-blooming shrubs pruned',
            'Crape myrtle shaped — collar cuts, no topping',
            'Crossing and dead wood removed',
            'Spring bloomers left alone',
        ],
    ],
    [
        'season' => 'Spring',
        'icon'   => 'flower-2',
        'tag'    => 'Right after bloom',
        'items'  => [
            'Azalea, forsythia, loropetalum',
            'Cut within weeks of flowers fading',
            'Done before next year\'s buds set',
            'Shape held light',
        ],
    ],
    [
        'season' => 'Summer',
        'icon'   => 'sun',
        'tag'    => 'Light touch only',
        'items'  => [
            'Minor shaping and stray growth',
            'No hard cuts in the heat',
            'Storm limbs cleared as they fall',
            'Shearing kept to a minimum',
        ],
    ],
    [
        'season' => 'Fall',
        'icon'   => 'leaf',
        'tag'    => 'Cleanup, not cutting',
        'items'  => [
            'Leaf removal & storm debris cleanup',
            'Shearing stopped early',
            'Frost-tender growth avoided',
            'Beds cleared before winter',
        ],
    ],
];

/* ── Comparison (them vs us) ──────────────────────────────────
   Left column = common trade practice, never a named competitor. Every
   right-hand row is a pruning practice or a process commitment intake
   recorded — nothing on the right is a credential claim. */
$comparison = [
    ['them' => 'Every shrub sheared into the same box on one visit', 'us' => 'Pruning timed to each plant\'s bloom cycle, so spring bloomers keep next year\'s flowers'],
    ['them' => 'Crape myrtles topped to knuckled stubs',            'us' => 'Crossing branches and suckers removed at the collar — no topping, ever'],
    ['them' => 'Cuts sealed with wound paint',                      'us' => 'A clean cut just outside the branch collar, left to seal itself'],
    ['them' => 'Half a shrub taken off in a single pass',           'us' => 'No more than about a quarter of the canopy removed in a season'],
    ['them' => 'Storm limbs dragged down off a ladder',             'us' => 'Hung-up limbs and widowmakers brought down from the ground'],
    ['them' => 'Clippings and leaves left on the beds and drive',   'us' => 'Debris hauled off and every hard surface blown clean before we leave'],
];

/* ── FAQs — conversational, 40-80 words ───────────────────────
   Rendered visibly below AND passed to generateFAQSchema(); schema that
   does not mirror visible content is a guidelines violation. No pricing,
   no fabricated scope: this crew does small residential trees and brush,
   not large-tree removal, and the answers say so plainly. */
$faqs = [
    [
        'question' => 'When should I prune flowering shrubs in Greenville County?',
        'answer'   => 'It depends on when the shrub blooms. Spring bloomers — azalea, forsythia, loropetalum — set next year\'s buds within weeks of flowering, so they are pruned right after the flowers fade. Summer bloomers and crape myrtle flower on new wood and are pruned in late winter while dormant. Greenville Lawn Masters prunes each plant to its own window rather than one blanket date.',
    ],
    [
        'question' => 'Is it bad to "top" a crape myrtle?',
        'answer'   => 'Yes. Topping a crape myrtle to thick stubs — often called "crape murder" — forces a burst of weak, whippy shoots that bend under their flowers and ruin the tree\'s frame. Greenville Lawn Masters prunes crape myrtles the way they are meant to be pruned: crossing branches, rubbing wood, and suckers removed at the collar, leaving the natural silhouette intact.',
    ],
    [
        'question' => 'When should leaves be cleared off a Mauldin lawn?',
        'answer'   => 'Before a wet Upstate winter sets in. Fallen leaves left matted over tall fescue shade out the crown and invite snow mold, so the shade lawn comes back thin in spring. Greenville Lawn Masters removes leaves in fall through early winter, blowing beds and turf clear, and hauls the debris off rather than piling it at the curb.',
    ],
    [
        'question' => 'Can you clear storm-damaged limbs after a wind event?',
        'answer'   => 'Yes, within reason. Greenville Lawn Masters clears downed limbs, hung-up branches, and brush from Mauldin properties after Upstate storms, working from the ground rather than a ladder. A limb still lodged high in a large canopy — a true "widowmaker" — is a job for a full tree-removal outfit with aerial equipment, and we will tell you so plainly if that is what you have.',
    ],
    [
        'question' => 'How much of a shrub can be cut back at one time?',
        'answer'   => 'As a rule, no more than about a quarter of the canopy in a single season. Take more and the shrub throws a stressed survival flush instead of healthy growth. Badly overgrown plants are brought back over two or three seasons rather than butchered in one pass, so they stay full instead of going leggy and bare at the base.',
    ],
    [
        'question' => 'Do you paint or seal the pruning cuts?',
        'answer'   => 'No — and that is deliberate. Research retired wound paint years ago; sealing a cut traps moisture against the wound and can slow healing rather than help it. A clean cut made just outside the branch collar, with a sharp blade, closes over on its own. Greenville Lawn Masters prunes to the collar and leaves the cut open to seal naturally.',
    ],
    [
        'question' => 'What size trees does Greenville Lawn Masters handle?',
        'answer'   => 'Small residential trees, ornamentals, and brush — the pruning, shaping, and removal a homeowner can reach without a bucket truck. Greenville Lawn Masters trims low canopies, clears crossing wood, and hauls brush across Mauldin and Greenville County. Large-tree felling and high-canopy work that needs a climber or crane fall outside our scope, and we refer those out.',
    ],
];

/* ── Schema — exactly 4 nodes ─────────────────────────────────
   (a) Service (@id #service-tree-shrub-services) with the 5 grouped services
       as an OfferCatalog; provider references the homepage LocalBusiness @id
       rather than restating it. NO offers/priceRange — no pricing was supplied,
       and fabricated structured pricing is a misrepresentation Google acts on.
   (b) FAQPage mirroring the visible FAQ exactly.
   (c) BreadcrumbList.
   (d) WebPage with Speakable. Every Speakable cssSelector exists in the markup. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-' . $pageSlug,
        'name'        => 'Tree & Shrub Services',
        'serviceType' => 'Tree, shrub, and pruning services',
        'description' => 'Tree and shrub care in Mauldin, South Carolina: hedge and shrub trimming, '
                       . 'small tree trimming and brush removal, leaf removal and storm debris '
                       . 'cleanup, edging and string trimming, and pet waste removal.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => array_map(
            fn(array $a): array => ['@type' => 'City', 'name' => $a['city']],
            $serviceAreas
        ),
        'hasOfferCatalog' => [
            '@type'           => 'OfferCatalog',
            'name'            => 'Tree & Shrub Services',
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
        ['name' => 'Home',                 'url' => '/'],
        ['name' => 'Services',             'url' => '/services/'],
        ['name' => 'Tree & Shrub Services','url' => '/services/' . $pageSlug . '/'],
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
   Tree & Shrub Services — page-scoped styles
   Every rule prefixed .tss- so no class collides with another page's
   <style> block. Colour, shadow, spacing, radius, and timing are var()
   tokens without exception — a raw literal here is an automatic QA fail
   (px inside clip-paths/keyframes and opacity/z-index numbers excepted).

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  two distinct SVG dividers (stacked hills, notched step)
     C4  editorial pull-quote
     C5  bento grid of telltale signs, deliberately uneven
     C6  asymmetric 62/38 split with an oversized stat watermark
     C7  signature section — the horizontal SEASONAL PRUNING CALENDAR
         band with a timeline rule threaded through it (this page only)
     C10 comparison table with the winning column tinted
     C11 image treatments — arch clip + offset accent frame
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   Background is the 'hedges' rendition (crew shaping foundation hedges).
   The gradient angle (118deg) and stop positions differ from the reference
   page (78deg) and the homepage (100deg) so the three heroes never read as
   one recycled image. */
.tss-hero {
  position: relative;
  min-height: 76vh;
  min-height: 76svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-hedge-trimming.jpg');
  background-size: cover;
  background-position: center 46%;
  isolation: isolate;
}
.tss-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    118deg,
    rgba(var(--color-dark-rgb), 0.94) 0%,
    rgba(var(--color-dark-rgb), 0.80) 38%,
    rgba(var(--color-primary-rgb), 0.52) 70%,
    rgba(var(--color-primary-rgb), 0.22) 100%
  );
  z-index: 0;
}
.tss-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.3;
  z-index: 0;
  pointer-events: none;
}
.tss-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 62rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
/* Above-fold entrance is pure CSS keyframes, never a reveal-* class — the
   reveal system sets opacity:0 and would blank the hero if the observer
   never fires (e.g. JS blocked). */
.tss-hero .breadcrumb { animation: tssFade 0.5s ease both; }
.tss-hero__eyebrow {
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
  animation: tssFade 0.55s ease 0.08s both;
}
.tss-hero__eyebrow i, .tss-hero__eyebrow svg { width: 15px; height: 15px; }
.tss-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  margin-bottom: var(--space-5);
  animation: tssRise 0.6s ease 0.16s both;
}
.tss-hero h1 .text-accent { color: var(--color-accent); }
/* .hero-answer centres itself globally; in this left-aligned hero it must not. */
.tss-hero .hero-answer {
  margin-inline: 0;
  max-width: 60ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: tssRise 0.6s ease 0.26s both;
}
.tss-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: tssRise 0.6s ease 0.36s both;
}
.tss-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: tssRise 0.6s ease 0.46s both;
}
.tss-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.tss-hero__trust i, .tss-hero__trust svg {
  width: 17px; height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}
@keyframes tssFade { from { opacity: 0; } to { opacity: 1; } }
@keyframes tssRise { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: none; } }

/* ── C4 · Problem statement + pull quote ──────────────────────*/
.tss-problem { background: var(--color-light); }
.tss-problem__layout {
  display: grid;
  grid-template-columns: 0.85fr 1.15fr;
  gap: var(--space-12);
  align-items: start;
}
.tss-problem__quote {
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
.tss-problem__lead { color: var(--color-gray-dark); }
.tss-problem__lead .answer-block { margin-inline: 0; }

/* ── C5 · Bento grid of telltale signs ────────────────────────
   Deliberately uneven: the first card spans two columns so the grid never
   reads as four identical boxes. Tints rotate; no two adjacent match. */
.tss-signs {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.tss-sign {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.tss-sign:first-child { grid-column: span 2; }
.tss-sign:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.tss-sign__icon {
  width: 46px; height: 46px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.tss-sign__icon i, .tss-sign__icon svg { width: 22px; height: 22px; }
.tss-sign h3 { font-size: var(--font-size-lg); margin-bottom: var(--space-2); color: var(--color-primary-dark); }
.tss-sign p { color: var(--color-gray-dark); font-size: var(--font-size-sm); line-height: 1.65; margin: 0; }

/* ── C6 · Expert positioning, asymmetric with stat watermark ──*/
.tss-expert { background: var(--color-white); }
.tss-expert__layout {
  display: grid;
  grid-template-columns: 0.6fr 1.4fr;   /* not 50/50 — editorial rule */
  gap: var(--space-16);
  align-items: center;
}
.tss-stat-watermark {
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
.tss-stat-watermark span {
  position: absolute;
  left: 0.06em;
  bottom: -1.7em;
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
.tss-expert h2 { margin-bottom: var(--space-5); }
.tss-expert .answer-block { margin-inline: 0; }
.tss-diffs { list-style: none; margin-top: var(--space-8); display: grid; gap: var(--space-5); }
.tss-diff {
  display: grid;
  grid-template-columns: 30px 1fr;
  gap: var(--space-4);
  align-items: start;
}
.tss-diff i, .tss-diff svg { width: 22px; height: 22px; color: var(--color-accent); margin-top: 3px; }
.tss-diff strong { display: block; color: var(--color-primary-dark); font-family: var(--font-heading); font-size: var(--font-size-lg); }
.tss-diff p { margin: var(--space-1) 0 0; color: var(--color-gray); font-size: var(--font-size-sm); line-height: 1.65; }

/* ── Service breakdown grid ───────────────────────────────────*/
.tss-breakdown { background: var(--color-light); }
.tss-services {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: var(--space-5);
}
.tss-service {
  display: flex;
  flex-direction: column;
  gap: var(--space-3);
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  border-top: 3px solid transparent;
  transition: transform var(--transition-base), border-color var(--transition-base), box-shadow var(--transition-base);
}
.tss-service:hover {
  transform: translateY(-5px);
  border-top-color: var(--color-accent);
  box-shadow: var(--shadow-card);
}
.tss-service__icon { color: var(--color-primary); }
.tss-service__icon i, .tss-service__icon svg { width: 28px; height: 28px; }
.tss-service h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); }
.tss-service p { margin: 0; font-size: var(--font-size-sm); color: var(--color-gray); line-height: 1.6; }

/* ── Process rail (threads the four visit phases) ─────────────*/
.tss-rail { position: relative; margin-top: var(--space-16); padding-left: var(--space-12); }
.tss-rail::before {
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
.tss-rail__step { position: relative; padding-bottom: var(--space-10); }
.tss-rail__step:last-child { padding-bottom: 0; }
.tss-rail__step::before {
  content: '';
  position: absolute;
  left: calc(-1 * var(--space-12) + 7px);
  top: 6px;
  width: 14px; height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 4px var(--color-light);
}
.tss-rail__phase {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  color: var(--color-accent);
  margin-bottom: var(--space-1);
}
.tss-rail__step h3 { font-size: var(--font-size-xl); color: var(--color-primary-dark); margin-bottom: var(--space-2); }
.tss-rail__step p { margin: 0; max-width: 62ch; color: var(--color-gray-dark); line-height: 1.7; }

/* ── C7 · SIGNATURE: seasonal pruning calendar band ───────────
   A dark band no other page has. Four season columns share one horizontal
   accent timeline; each column hangs a marker on that line. Unmistakable. */
.tss-calendar { background: var(--color-dark); }
.tss-calendar .section-header h2,
.tss-calendar .tss-eyebrow { color: var(--color-white); }
.tss-calendar .answer-block { color: rgba(var(--color-white-rgb), 0.78); }
.tss-calendar__track {
  position: relative;
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-16);
  padding-top: var(--space-8);
}
/* The timeline rule — a single accent line across the top of all four seasons. */
.tss-calendar__track::before {
  content: '';
  position: absolute;
  top: 6px;
  left: 8%;
  right: 8%;
  height: 2px;
  background: linear-gradient(
    to right,
    rgba(var(--color-accent-rgb), 0.15) 0%,
    var(--color-accent) 18%,
    var(--color-accent) 82%,
    rgba(var(--color-accent-rgb), 0.15) 100%
  );
}
.tss-season { position: relative; text-align: center; }
.tss-season__marker {
  position: absolute;
  top: calc(-1 * var(--space-8) + 6px);
  left: 50%;
  transform: translate(-50%, -50%);
  width: 16px; height: 16px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 5px var(--color-dark);
}
.tss-season__card {
  margin-top: var(--space-6);
  padding: var(--space-6) var(--space-5) var(--space-8);
  border-radius: var(--radius-lg);
  background: rgba(var(--color-white-rgb), 0.05);
  border: 1px solid rgba(var(--color-white-rgb), 0.08);
  height: 100%;
  text-align: left;
  transition: transform var(--transition-base), border-color var(--transition-base);
}
.tss-season__card:hover { transform: translateY(-5px); border-color: rgba(var(--color-accent-rgb), 0.45); }
.tss-season__head { display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-4); }
.tss-season__icon {
  width: 42px; height: 42px;
  display: grid; place-items: center;
  border-radius: var(--radius-md);
  background: rgba(var(--color-accent-rgb), 0.16);
  color: var(--color-accent);
  flex-shrink: 0;
}
.tss-season__icon i, .tss-season__icon svg { width: 20px; height: 20px; }
.tss-season__name { font-family: var(--font-heading); font-size: var(--font-size-xl); font-weight: 800; color: var(--color-white); line-height: 1.1; }
.tss-season__tag {
  display: block;
  font-size: var(--font-size-xs);
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  color: var(--color-accent);
  margin-top: var(--space-1);
}
.tss-season ul { list-style: none; margin: 0; padding: 0; display: grid; gap: var(--space-3); }
.tss-season li {
  position: relative;
  padding-left: var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.5;
  color: rgba(var(--color-white-rgb), 0.82);
}
.tss-season li::before {
  content: '';
  position: absolute;
  left: 0;
  top: 7px;
  width: 8px; height: 8px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
}
/* The one season a homeowner searches for by name gets a solid highlight. */
.tss-season--feature .tss-season__card {
  background: rgba(var(--color-accent-rgb), 0.12);
  border-color: rgba(var(--color-accent-rgb), 0.5);
}

/* ── C11 · Proof strip, arch + offset frame treatments ────────*/
.tss-proof { background: var(--color-white); }
.tss-proof__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.tss-shot { margin: 0; }
.tss-shot img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-card);
  transition: transform var(--transition-slow);
}
.tss-shot--arch img { border-radius: 50% 50% var(--radius-lg) var(--radius-lg) / 22% 22% var(--radius-lg) var(--radius-lg); }
.tss-shot--frame { position: relative; }
.tss-shot--frame::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3)) calc(-1 * var(--space-3)) var(--space-3) var(--space-3);
  border: 1px solid rgba(var(--color-accent-rgb), 0.45);
  border-radius: var(--radius-lg);
  pointer-events: none;
}
.tss-shot:hover img { transform: scale(1.03); }
.tss-shot figcaption {
  margin-top: var(--space-4);
  color: var(--color-gray);
  font-size: var(--font-size-xs);
  line-height: 1.6;
}
.tss-shot figcaption strong { display: block; color: var(--color-primary-dark); font-size: var(--font-size-sm); margin-bottom: var(--space-1); }
.tss-proof__note {
  max-width: 65ch;
  margin: var(--space-12) auto 0;
  padding: var(--space-5) var(--space-6);
  border-radius: var(--radius-md);
  background: var(--color-light);
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  text-align: center;
}
.tss-proof__note p { margin: 0; }

/* ── C10 · Comparison table ───────────────────────────────────*/
.tss-compare { background: var(--color-light); }
.tss-compare__table {
  max-width: 62rem;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
  background: var(--color-white);
}
.tss-compare__head, .tss-compare__row {
  display: grid;
  grid-template-columns: 1fr 1fr;
}
.tss-compare__head > div {
  padding: var(--space-5) var(--space-6);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-base);
}
.tss-compare__head > div:first-child { background: var(--color-gray-light); color: var(--color-gray-dark); }
.tss-compare__head > div:last-child  { background: var(--color-primary); color: var(--color-white); }
.tss-compare__row > div {
  display: grid;
  grid-template-columns: 20px 1fr;
  gap: var(--space-3);
  align-items: start;
  padding: var(--space-5) var(--space-6);
  font-size: var(--font-size-sm);
  line-height: 1.6;
  border-top: 1px solid var(--color-gray-light);
}
.tss-compare__row > div:first-child { color: var(--color-gray); }
.tss-compare__row > div:last-child  { background: rgba(var(--color-accent-rgb), 0.06); color: var(--color-gray-dark); font-weight: 500; }
.tss-compare__row i, .tss-compare__row svg { width: 17px; height: 17px; margin-top: 2px; }
.tss-compare__row > div:first-child i, .tss-compare__row > div:first-child svg { color: var(--color-gray); }
.tss-compare__row > div:last-child i,  .tss-compare__row > div:last-child svg  { color: var(--color-accent); }

/* ── FAQ ──────────────────────────────────────────────────────*/
.tss-faq { background: var(--color-white); }
.tss-faq__list { max-width: 55rem; margin: var(--space-12) auto 0; display: grid; gap: var(--space-4); }
.tss-faq__item {
  background: var(--color-light);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.tss-faq__item h3 { font-size: var(--font-size-lg); color: var(--color-primary-dark); margin-bottom: var(--space-3); }
.tss-faq__item .faq-answer { margin: 0; color: var(--color-gray-dark); font-size: var(--font-size-base); line-height: 1.75; }

/* ── Related services ─────────────────────────────────────────*/
.tss-related { background: var(--color-light); }

/* ── Final CTA ────────────────────────────────────────────────*/
.tss-cta {
  position: relative;
  background: linear-gradient(135deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
  overflow: hidden;
}
.tss-cta::before {
  content: '';
  position: absolute;
  top: -22%; left: -6%;
  width: 460px; height: 460px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.tss-cta .container { position: relative; z-index: 1; }
.tss-cta h2 { color: var(--color-white); margin-bottom: var(--space-4); }
.tss-cta p { color: rgba(var(--color-white-rgb), 0.88); max-width: 60ch; margin: 0 auto var(--space-8); }
.tss-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .tss-services { grid-template-columns: repeat(2, 1fr); }
  .tss-signs { grid-template-columns: repeat(2, 1fr); }
  .tss-sign:first-child { grid-column: span 2; }
  .tss-expert__layout { grid-template-columns: 1fr; gap: var(--space-12); }
  .tss-stat-watermark { font-size: clamp(5rem, 22vw, 9rem); }
  .tss-stat-watermark span { position: static; display: block; margin-top: var(--space-4); max-width: none; }
  .tss-problem__layout { grid-template-columns: 1fr; gap: var(--space-8); }
  .tss-problem__quote { max-width: none; }
  .tss-proof__grid { grid-template-columns: 1fr 1fr; }

  /* Calendar drops to a 2x2 grid; the horizontal timeline rule and its
     markers stop making sense across two rows, so both are hidden. */
  .tss-calendar__track { grid-template-columns: repeat(2, 1fr); padding-top: 0; }
  .tss-calendar__track::before { display: none; }
  .tss-season__marker { display: none; }
  .tss-season__card { margin-top: 0; }
}
@media (max-width: 700px) {
  .tss-hero { min-height: 0; }
  .tss-services, .tss-signs, .tss-proof__grid, .tss-calendar__track { grid-template-columns: 1fr; }
  .tss-sign:first-child { grid-column: span 1; }
  .tss-shot--frame::before { display: none; }

  /* Comparison collapses to stacked pairs; the column headers disappear and
     each cell carries its own label, or the them/us contrast is lost. */
  .tss-compare__head { display: none; }
  .tss-compare__row { grid-template-columns: 1fr; }
  .tss-compare__row > div::after {
    content: attr(data-label);
    display: block;
    grid-column: 2;
    margin-top: var(--space-2);
    font-size: var(--font-size-xs);
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.65;
  }
  .tss-hero__actions .btn { width: 100%; justify-content: center; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero tss-hero" aria-label="Tree and shrub services in Mauldin, South Carolina">
    <div class="container">
        <div class="tss-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/services/">Services</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Tree &amp; Shrub Services</span></li>
                </ol>
            </nav>

            <span class="tss-hero__eyebrow">
                <i data-lucide="shrub" aria-hidden="true"></i>
                Tree &amp; Shrub &middot; Mauldin, SC
            </span>

            <h1>Tree &amp; Shrub Services in <span class="text-accent">Mauldin, South Carolina</span></h1>

            <p class="hero-answer">
                Greenville Lawn Masters handles tree and shrub work in Mauldin, South Carolina and within
                25 miles across Greenville County — hedge and shrub trimming, small tree trimming, brush and
                storm-debris removal, leaf cleanup, edging, and pet waste removal. Every shrub is pruned on
                its own bloom cycle, and the written estimate arrives within 24 hours.
            </p>

            <div class="tss-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Tree &amp; Shrub Estimate
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* config.php $phone is empty. A "Call Now" button with no number
                             — or a fabricated one — is worse than routing to the estimate
                             form, so the fallback links to the full service list instead. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust row carries only what intake recorded — no "Licensed & Insured",
                     no arborist credential, no star rating, no trees-trimmed count. */ ?>
            <div class="tss-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Locally owned in <?php echo e($address['city']); ?></span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="sprout" aria-hidden="true"></i> Pruned on the bloom cycle, not a blanket date</span>
                <span><i data-lucide="calendar-days" aria-hidden="true"></i> Serving <?php echo e($address['city']); ?> since <?php echo e((string) $yearEstablished); ?></span>
            </div>
        </div>
    </div>

    <!-- Divider A — stacked hills, filled with the problem section's light bg -->
    <div class="svg-divider" style="height:70px" aria-hidden="true">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
            <path d="M0,80 L0,44 C180,12 340,64 520,44 C700,24 860,68 1040,46 C1120,36 1170,44 1200,40 L1200,80 Z" fill="var(--color-light)" opacity="0.5"/>
            <path d="M0,80 L0,60 C200,34 360,74 560,58 C760,42 920,74 1120,58 C1160,54 1180,58 1200,56 L1200,80 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · PROBLEM STATEMENT ══════════ -->
<section class="tss-problem" aria-label="Signs a Mauldin landscape needs pruning">
    <div class="container">
        <div class="tss-problem__layout">
            <blockquote class="tss-problem__quote reveal-left">
                A shrub is not misbehaving. It is growing exactly on the schedule nobody set for it.
            </blockquote>

            <div class="tss-problem__lead">
                <h2 class="reveal-right">What goes wrong when hedges, limbs, and leaves go untended?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Left alone through an Upstate year, foundation hedges swallow the windows and gutter line,
                    storm-snapped limbs hang unsupported in the canopy, and a wet leaf mat smothers tall fescue
                    over winter. Worse, a shrub sheared in the wrong month loses the buds it already set — so
                    it leafs out fine and simply never blooms the next spring.
                </p>
                <p class="reveal-right reveal-delay-2">
                    None of it is fixed by cutting harder or faster. Greenville Lawn Masters reads each plant
                    first — what it is, when it flowers, where the crossing and dead wood sit — because in
                    Greenville County's transition-zone yards, the same hedge row can hold plants that want the
                    pruners in February and plants that would be ruined by it.
                </p>
            </div>
        </div>

        <div class="tss-signs">
            <?php foreach ($signs as $i => $sign): ?>
                <?php
                /* Tints rotate 1→2→3→neutral so no two adjacent cards share a background. */
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="tss-sign <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="tss-sign__icon"><i data-lucide="<?php echo e($sign['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($sign['title']); ?></h3>
                    <p><?php echo e($sign['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 3 · EXPERT POSITIONING ══════════ -->
<section class="tss-expert" aria-label="How Greenville Lawn Masters approaches pruning">
    <div class="container">
        <div class="tss-expert__layout">

            <div class="tss-stat-watermark reveal-left" aria-hidden="true">
                25%<span>Most canopy taken in one season</span>
            </div>

            <div>
                <h2 class="reveal-right">Why does timing decide whether a shrub ever blooms?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Timing decides everything because a spring-blooming shrub — azalea, forsythia, loropetalum —
                    sets next year's buds within weeks of flowering. Prune it in winter and you cut those buds
                    off. Summer bloomers and crape myrtle flower on new wood, so they are pruned in late winter.
                    Greenville Lawn Masters prunes each plant on its own clock, not one date.
                </p>

                <ul class="tss-diffs">
                    <?php
                    $diffDelays = ['reveal-delay-2', 'reveal-delay-3', 'reveal-delay-4'];
                    foreach ($differentiators as $i => $d):
                    ?>
                        <li class="tss-diff reveal-right <?php echo $diffDelays[$i] ?? 'reveal-delay-4'; ?>">
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

    <!-- Divider B — notched step edge, filled with the breakdown section's light bg -->
    <div class="svg-divider" style="height:48px" aria-hidden="true">
        <svg viewBox="0 0 1200 48" preserveAspectRatio="none">
            <path d="M0,48 L0,20 L150,20 L150,4 L400,4 L400,24 L650,24 L650,8 L900,8 L900,26 L1120,26 L1120,12 L1200,12 L1200,48 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SERVICE BREAKDOWN + PROCESS ══════════ -->
<section class="tss-breakdown" aria-label="What tree and shrub services include">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What tree and shrub services does <span class="text-accent">Greenville Lawn Masters</span> provide in Mauldin?</h2>
            <p class="answer-block">
                Greenville Lawn Masters provides <?php echo e((string) count($servicesHere)); ?> tree and shrub
                services in Mauldin: edging and string trimming, leaf removal and storm debris cleanup, hedge
                and shrub trimming, small tree trimming and brush removal, and pet waste removal. Take the whole
                list or only the pieces your property needs.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="tss-services">
            <?php foreach ($servicesHere as $i => $svc): ?>
                <article class="tss-service <?php echo ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up', 'reveal-scale'][$i % 5]; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="tss-service__icon">
                        <i data-lucide="<?php echo e($serviceIcons[$svc['slug']] ?? 'leaf'); ?>" aria-hidden="true"></i>
                    </div>
                    <h3><?php echo e($svc['name']); ?></h3>
                    <p><?php echo e($svc['description']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <h2 class="reveal-up" style="margin-top: var(--space-16); text-align: center;">
            How does a tree and shrub visit actually run?
        </h2>
        <p class="answer-block reveal-up reveal-delay-1" style="text-align: center;">
            A tree and shrub visit starts with a free walkthrough where each plant is assessed on foot — species,
            bloom time, crossing wood, and any storm damage hung up overhead. A written, itemised estimate follows
            within 24 hours. Cuts are made just outside the branch collar, and every visit ends with debris hauled
            off and hard surfaces blown clean.
        </p>

        <ol class="tss-rail">
            <?php foreach ($timeline as $i => $step): ?>
                <li class="tss-rail__step reveal-left reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <span class="tss-rail__phase"><?php echo e($step['phase']); ?></span>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </li>
            <?php endforeach; ?>
        </ol>
    </div>

    <!-- Divider A reprised — stacked hills, filled with the calendar band's dark bg -->
    <div class="svg-divider" style="height:70px" aria-hidden="true">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
            <path d="M0,80 L0,44 C180,12 340,64 520,44 C700,24 860,68 1040,46 C1120,36 1170,44 1200,40 L1200,80 Z" fill="var(--color-dark)" opacity="0.5"/>
            <path d="M0,80 L0,60 C200,34 360,74 560,58 C760,42 920,74 1120,58 C1160,54 1180,58 1200,56 L1200,80 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · SIGNATURE — SEASONAL PRUNING CALENDAR ══════════ -->
<section class="tss-calendar" aria-label="Seasonal pruning calendar for Greenville County">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label tss-eyebrow">The Pruning Calendar</span>
            <h2>When should each shrub be pruned in Greenville County?</h2>
            <p class="answer-block">
                In Greenville County's USDA zone 7b–8a, the right pruning month depends on the plant. Summer
                bloomers and crape myrtle are cut in late winter while dormant; spring bloomers are pruned right
                after their flowers fade; summer is for light shaping only; and fall is for leaf and storm-debris
                cleanup, not hard cuts that push frost-tender growth.
            </p>
        </div>

        <div class="tss-calendar__track">
            <?php
            /* Fall is the season homeowners search for by name ("leaf removal & storm
               debris cleanup"), so it carries the feature highlight. */
            $featureSeason = 'Fall';
            foreach ($calendar as $i => $season):
                $isFeature = $season['season'] === $featureSeason;
                $dir = ['reveal-up', 'reveal-down', 'reveal-up', 'reveal-scale'][$i % 4];
            ?>
                <div class="tss-season <?php echo $isFeature ? 'tss-season--feature' : ''; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
                    <span class="tss-season__marker" aria-hidden="true"></span>
                    <div class="tss-season__card">
                        <div class="tss-season__head">
                            <div class="tss-season__icon"><i data-lucide="<?php echo e($season['icon']); ?>" aria-hidden="true"></i></div>
                            <div>
                                <span class="tss-season__name"><?php echo e($season['season']); ?></span>
                                <span class="tss-season__tag"><?php echo e($season['tag']); ?></span>
                            </div>
                        </div>
                        <ul>
                            <?php foreach ($season['items'] as $item): ?>
                                <li><?php echo e($item); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider B reprised — notched step edge, filled with the proof section's white bg -->
    <div class="svg-divider" style="height:48px" aria-hidden="true">
        <svg viewBox="0 0 1200 48" preserveAspectRatio="none">
            <path d="M0,48 L0,20 L150,20 L150,4 L400,4 L400,24 L650,24 L650,8 L900,8 L900,26 L1120,26 L1120,12 L1200,12 L1200,48 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 6 · PROOF ══════════ -->
<?php /* The standard proof slot calls for testimonials + an aggregate review
         snippet. config.php $reviews is empty and $gbpUrl is empty, and only
         ONE of the six library photos ('hedges') shows this kind of work being
         performed. Fabricating quotes would attribute an endorsement to a
         non-existent customer (an FTC Endorsement Guides problem), and inventing
         a review count is separately forbidden. The client's own hedge photo
         leads the slot; the other two frames are honest outcome shots, captioned
         as exactly what is visible; and the note states plainly why there are no
         reviews yet. No caption claims a picture shows tree, leaf, or pet-waste
         work — no such photo exists. */ ?>
<section class="tss-proof" aria-label="Greenville Lawn Masters tree and shrub photography">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Work</span>
            <h2>What does <span class="text-accent">Greenville Lawn Masters</span> tree and shrub work look like up close?</h2>
            <p class="answer-block">
                Greenville Lawn Masters photographs its own Mauldin-area job sites. The first frame below shows a
                crew member shaping foundation hedges back off the windows at a brick home; the other two are
                finished properties on the maintenance route — turf held tight against mulched beds, and a
                re-edged front bed at a Craftsman home.
            </p>
        </div>

        <div class="tss-proof__grid">
            <?php
            /* 'hedges' is the only frame that shows this work happening, so it leads and
               its caption names the service. 'backyard' and 'mulch_bed' are outcome
               shots and are captioned strictly as what is in the frame. */
            $shots = [
                ['key' => 'hedges',    'mod' => '',               'label' => 'Foundation hedges, shaped back', 'caption' => 'A Greenville Lawn Masters crew member trimming foundation hedges back off the windows at a brick home in Mauldin, SC.'],
                ['key' => 'backyard',  'mod' => 'tss-shot--arch', 'label' => 'Beds kept clean-edged',          'caption' => 'Backyard turf running between mulched planting beds and a wood privacy fence at a Mauldin, SC home.'],
                ['key' => 'mulch_bed', 'mod' => 'tss-shot--frame','label' => 'Front bed re-edged',             'caption' => 'A freshly mulched and edged front bed beside the walk of a Craftsman home in Mauldin, South Carolina.'],
            ];
            foreach ($shots as $i => $shot):
                $img = photo($shot['key']);
                $dir = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
            ?>
                <figure class="tss-shot <?php echo $shot['mod']; ?> <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
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

        <div class="tss-proof__note reveal-up">
            <p>
                <?php echo e($siteName); ?> opened in <?php echo e((string) $yearEstablished); ?> and is still
                building its public review history. This space is reserved for verified Google reviews rather than
                testimonials that cannot be traced to a real customer.
            </p>
        </div>
    </div>
</section>

<!-- ══════════ 7 · COMPARISON ══════════ -->
<section class="tss-compare" aria-label="How Greenville Lawn Masters prunes differently">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>What separates careful pruning from a crew that just shears everything?</h2>
            <p class="answer-block">
                Careful pruning follows the plant: cuts are timed to the bloom cycle, made at the branch collar,
                and kept under about a quarter of the canopy in a season. A shear-everything crew boxes every
                shrub on the same day, tops crape myrtles to stubs, and leaves the beds full of clippings. The
                difference shows the following spring.
            </p>
        </div>

        <?php /* Left column is common practice in the trade, not a named competitor.
                 Every right-hand row is a pruning practice or a process commitment —
                 never a credential claim. */ ?>
        <div class="tss-compare__table reveal-up reveal-delay-1">
            <div class="tss-compare__head">
                <div>A shear-everything crew</div>
                <div>Greenville Lawn Masters</div>
            </div>
            <?php foreach ($comparison as $row): ?>
                <div class="tss-compare__row">
                    <div data-label="A shear-everything crew">
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
<section class="tss-faq" aria-label="Tree and shrub questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do Mauldin homeowners ask about <span class="text-accent">tree and shrub care</span>?</h2>
            <p class="answer-block">
                Mauldin homeowners most often ask when each shrub should be pruned, why a crape myrtle
                should never be topped, how much of a canopy can safely come off in one season, what to
                do with storm limbs hung up in a tree, and when leaves need clearing off the lawn. Each
                is answered below.
            </p>
        </div>

        <div class="tss-faq__list">
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="tss-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ RELATED SERVICES ══════════ -->
<section class="tss-related" aria-label="Other services">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>What else does <span class="text-accent">Greenville Lawn Masters</span> handle in Mauldin?</h2>
            <p class="answer-block">
                Beyond hedges and small trees, Greenville Lawn Masters handles the rest of the property across
                Greenville County — mowing and treatment, beds and mulch, sod, gutters, and pressure washing —
                with the same crew and the same 24-hour written estimate.
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
<section class="tss-cta" aria-label="Request a tree and shrub estimate">
    <div class="container">
        <h2 class="reveal-up">Ready to get your hedges and shrubs back in shape?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Bloom-sensitive shrubs have a narrow window, and storm debris does not wait for the calendar. Book a
            free walkthrough and Greenville Lawn Masters returns a written, itemised estimate within 24 hours —
            with each plant slotted to the month it should actually be pruned.
        </p>
        <div class="tss-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Tree &amp; Shrub Estimate
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
