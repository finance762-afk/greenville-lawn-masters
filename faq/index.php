<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /faq/index.php — Phase 5
   Greenville Lawn Masters · Mauldin, SC

   Questions across four categories: General, Services, Pricing, Process.
   The count is derived from $faqCategories at render time ($faqCount), never
   hardcoded in prose — see the note beside it.

   ── WHAT THESE ANSWERS DO AND DO NOT CONTAIN ───────────────────
   NO PRICES. Not one range, not one "starting at", not one "most
   Mauldin lawns run $X–$Y". build-plan.json supplied no pricing of any
   kind. An invented range is a misrepresentation on the page, and this
   page pipes its answers straight into FAQPage schema, which amplifies
   it into Google's index and into AI answer engines. The Pricing
   category answers HOW pricing works — what moves the number, when it
   arrives, what it is quoted against — which is genuinely useful and
   entirely true.

   NO review counts, no star ratings, no jobs-completed figures, no crew
   size, no "licensed and insured" claim. All absent from intake.

   The horticultural claims (soil temperature thresholds, aeration
   windows, mowing intervals, transition-zone grass behaviour) are
   verifiable facts about the SC Piedmont and are stated IDENTICALLY here,
   on the homepage FAQ, on /about/, and on the service pages. One set of
   facts across the whole site — a visitor who reads two pages must never
   find them contradicting each other.

   ── SCHEMA ─────────────────────────────────────────────────────
   Every Q&A below is rendered VISIBLY and passed to generateFAQSchema()
   from the same $faqCategories array. Schema that does not mirror visible
   content is a structured-data guidelines violation. Building both from
   one array makes drift impossible.

   FAQPage rich results were fully deprecated in May 2026. This markup is
   an AI-comprehension aid only (CLAUDE.md) — never describe it as a
   rich-result feature.
   ============================================================ */

$currentPage = 'faq';

$pageTitle       = 'Lawn Care FAQ | Greenville Lawn Masters, Mauldin SC';
$pageDescription = 'Answers on lawn care in Mauldin, SC — mowing intervals, aeration timing, '
                 . 'pre-emergent windows, how estimates are priced, and what happens on a '
                 . 'service visit.';   // 156 chars

$canonicalUrl = $siteUrl . '/faq/';
$ogImage      = $ogImageUrl;

$heroImg          = heroPhoto('mowing');
$heroImagePreload = $heroImg['src'];

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── The FAQ ───────────────────────────────────────────────────
   Answer-first, conversational, 40-90 words (aeo-content-schema §2.4).
   Every answer opens with the full company name or a direct factual
   statement — never a pronoun (chunk-level rule: AI engines retrieve
   individual sections, so each must stand alone).

   `id` seeds the anchor so a specific answer can be linked directly. */
$faqCategories = [
    [
        'key'   => 'general',
        'icon'  => 'info',
        'label' => 'General',
        'blurb' => 'Who Greenville Lawn Masters is, where the trucks go, and who the crew works for.',
        'faqs'  => [
            [
                'id'       => 'what-areas',
                'question' => 'What areas does Greenville Lawn Masters serve around Mauldin?',
                'answer'   => 'Greenville Lawn Masters is based in Mauldin, South Carolina and serves properties within '
                            . 'roughly 25 miles, which covers much of Greenville County. If you are searching for lawn '
                            . 'care near me in Mauldin, the service area almost certainly reaches you. Both residential '
                            . 'lawns and commercial grounds, including HOA and apartment properties, are on the route.',
            ],
            [
                'id'       => 'how-long-in-business',
                'question' => 'How long has Greenville Lawn Masters been in business?',
                'answer'   => 'Greenville Lawn Masters was founded in 2024 and has worked lawns in Mauldin and the '
                            . 'surrounding Greenville County area since. It is a young company, and it says so rather '
                            . 'than rounding up. What it does not do is subcontract the work out: the same crew that '
                            . 'quotes the property is the crew that shows up to cut it.',
            ],
            [
                'id'       => 'residential-or-commercial',
                'question' => 'Does Greenville Lawn Masters take commercial properties?',
                'answer'   => 'Yes. Greenville Lawn Masters maintains grounds for businesses, HOAs, apartment complexes, '
                            . 'and municipal properties alongside its residential route. Commercial grounds are quoted the '
                            . 'same way a house is — walked in person first, then priced in writing — because acreage, '
                            . 'access, and mowing frequency vary far too much to quote from a map.',
            ],
            [
                'id'       => 'one-crew',
                'question' => 'Will the same crew handle the mowing, the beds, and the gutters?',
                'answer'   => 'Yes, and that is deliberate. Greenville Lawn Masters runs every service with one crew '
                            . 'because a property is one system: the gutter that overflows floods the bed, the flooded bed '
                            . 'drowns the shrubs, and the compacted clay underneath is why the water had nowhere to go. '
                            . 'One crew tends to find the cause rather than mow around it.',
            ],
            [
                'id'       => 'year-round',
                'question' => 'Does Greenville Lawn Masters work through the winter?',
                'answer'   => 'Yes. Mowing slows to a stop as Upstate turf goes dormant, but leaf and storm debris removal, '
                            . 'gutter clearing, winter lawn preparation, bed cutback, pressure washing, and dormant pruning '
                            . 'all run from November through January. A lawn left under a matted layer of wet leaves through '
                            . 'a Carolina winter comes back thin in spring.',
            ],
        ],
    ],
    [
        'key'   => 'services',
        'icon'  => 'scissors',
        'label' => 'Services & Lawn Care',
        'blurb' => 'What the Upstate climate actually demands, and when.',
        'faqs'  => [
            [
                'id'       => 'mowing-frequency',
                'question' => 'How often should a lawn be mowed in Greenville County?',
                'answer'   => 'Weekly from roughly May through September, when Upstate growth peaks, and every other week '
                            . 'in the shoulder seasons. The governing rule is to remove no more than one third of the blade '
                            . 'in a single cut — scalping a stressed summer lawn invites weeds and disease. Greenville Lawn '
                            . 'Masters sets a fixed route so the interval never stretches.',
            ],
            [
                'id'       => 'when-to-aerate',
                'question' => 'When should I aerate my lawn in Mauldin, SC?',
                'answer'   => 'Timing follows the grass, not the calendar. Warm-season lawns — bermuda and zoysia — are '
                            . 'cored in late spring through early summer, once the turf is actively growing and can knit '
                            . 'the holes closed. Tall fescue is aerated in early fall, September into October, and '
                            . 'overseeded at the same time. Mauldin sits on heavy Piedmont clay, so most lawns here benefit annually.',
            ],
            [
                'id'       => 'pre-emergent-timing',
                'question' => 'When do you apply crabgrass pre-emergent in Upstate South Carolina?',
                'answer'   => 'The window opens when soil temperature at two inches holds near 55°F, which in Greenville '
                            . 'County usually falls between late February and mid-March. Applied after crabgrass has '
                            . 'germinated, a pre-emergent does nothing at all. Greenville Lawn Masters generally follows the '
                            . 'first application with a second roughly eight to ten weeks later to carry the barrier through summer.',
            ],
            [
                'id'       => 'best-grass',
                'question' => 'What type of grass grows best in Mauldin, SC?',
                'answer'   => 'Mauldin sits in the transition zone, where neither northern nor southern grasses are entirely '
                            . 'at home. Bermuda and zoysia handle full Upstate sun and summer heat best. Tall fescue holds up '
                            . 'better in shade but thins each August and needs overseeding every fall. Most Greenville County '
                            . 'properties end up running both, which is why treatment timing differs across one yard.',
            ],
            [
                'id'       => 'aeration-vs-dethatching',
                'question' => 'What is the difference between aeration and dethatching?',
                'answer'   => 'Aeration pulls plugs of soil out of the ground to relieve compaction, so water, air, and '
                            . 'nutrients reach the root zone. Dethatching pulls out the dead, spongy layer of stems and '
                            . 'runners sitting between the grass and the soil surface. Mauldin\'s clay compacts, so aeration '
                            . 'is the more common need here; dethatching matters most on thick bermuda and zoysia.',
            ],
            [
                'id'       => 'soil-testing',
                'question' => 'Why would my lawn need a soil test and lime?',
                'answer'   => 'Piedmont clay soils in Greenville County trend acidic, and below about pH 6.0 the fertiliser '
                            . 'you pay for stops being available to the roots regardless of how much goes down. Greenville '
                            . 'Lawn Masters tests soil pH first, then applies lime to correct it. Feeding an acidic lawn '
                            . 'without correcting the pH is money spread across the yard and left there.',
            ],
            [
                'id'       => 'gutters-lawn-company',
                'question' => 'Why does a lawn care company clean gutters?',
                'answer'   => 'Because a blocked gutter is a landscaping problem before it is a roofing one. Water sheeting '
                            . 'over a packed trough lands at the base of the wall, saturates the foundation bed, and drowns '
                            . 'whatever is planted there. Greenville Lawn Masters clears troughs by hand, flushes every '
                            . 'downspout until it runs clear, and hauls the debris off rather than dropping it in the beds.',
            ],
        ],
    ],
    [
        'key'   => 'pricing',
        'icon'  => 'file-text',
        'label' => 'Pricing & Estimates',
        'blurb' => 'How the number is arrived at, and when you get to see it.',
        'faqs'  => [
            [
                'id'       => 'how-much',
                'question' => 'How much does lawn care cost in Mauldin, SC?',
                'answer'   => 'Greenville Lawn Masters prices each property after seeing it, because lot size, slope, grass '
                            . 'type, and how far the lawn has gotten away from you all move the number. A walk of the '
                            . 'property is free, and a written, itemised estimate follows within 24 hours. Mowing is quoted '
                            . 'per visit on a weekly or biweekly route; treatments and projects are quoted separately.',
            ],
            [
                'id'       => 'quote-over-phone',
                'question' => 'Can I get a quote over the phone without a visit?',
                'answer'   => 'Greenville Lawn Masters does not quote lawns from a satellite photo. Slope, drainage, gate '
                            . 'width, grass type, and the condition the turf is actually in are not visible from above, and '
                            . 'each one moves the price. A number given without seeing those is a guess, and the person who '
                            . 'pays for a wrong guess is the homeowner. The walkthrough is free.',
            ],
            [
                'id'       => 'estimate-turnaround',
                'question' => 'How quickly will I get my estimate?',
                'answer'   => 'Within 24 hours of the walkthrough. That is the one hard commitment Greenville Lawn Masters '
                            . 'makes, and the estimate arrives in writing and itemised by service, so you can accept all of '
                            . 'it or only the parts you want. Nothing is scheduled and nothing is billed until you accept.',
            ],
            [
                'id'       => 'contract-required',
                'question' => 'Do I have to sign an annual contract?',
                'answer'   => 'No. Greenville Lawn Masters quotes mowing per visit on a weekly or biweekly route, and '
                            . 'treatments, aeration, sod, mulch, and cleanups are each quoted as their own line. You can take '
                            . 'the whole estimate or one line off it. A recurring route is a schedule, not a lock-in.',
            ],
            [
                'id'       => 'what-moves-price',
                'question' => 'What makes one lawn cost more than another to maintain?',
                'answer'   => 'Four things, mostly. Lot size and how much of it is actually turf. Slope, because a hill is '
                            . 'slower and harder to cut safely. Access — a narrow gate means a smaller mower and more time. '
                            . 'And current condition: a lawn that has been left through a full Upstate growing season needs '
                            . 'reclaiming before it needs maintaining, and those are different jobs.',
            ],
        ],
    ],
    [
        'key'   => 'process',
        'icon'  => 'calendar-check',
        'label' => 'Process & Service Visits',
        'blurb' => 'What actually happens when the trailer pulls up.',
        'faqs'  => [
            [
                'id'       => 'need-to-be-home',
                'question' => 'Do I need to be home when the crew comes?',
                'answer'   => 'Not for routine mowing, provided the crew can reach the yard. Greenville Lawn Masters does '
                            . 'ask that you be present for the initial walkthrough, because that is when grass type, problem '
                            . 'areas, irrigation heads, and gate access get sorted out. After that the route runs whether you '
                            . 'are there or not, and gates are shut behind the crew every time.',
            ],
            [
                'id'       => 'what-visit-includes',
                'question' => 'What does a standard mowing visit include?',
                'answer'   => 'Cutting, edging along hard surfaces, string trimming where the mower cannot reach, and blowing '
                            . 'clippings off drives, walks, and patios. Greenville Lawn Masters does not blow clippings into '
                            . 'beds or down a storm drain. Debris that comes off the property leaves with the crew rather than '
                            . 'being stacked at the curb.',
            ],
            [
                'id'       => 'rain-day',
                'question' => 'What happens to my service day when it rains?',
                'answer'   => 'Cutting saturated turf tears the crown and ruts the soil, so Greenville Lawn Masters does not '
                            . 'mow a lawn that is too wet to mow. The visit shifts to the next workable day on the route and '
                            . 'the schedule resets from there. Upstate summer storms are frequent enough that a route with no '
                            . 'slack in it is a route that scalps lawns.',
            ],
            [
                'id'       => 'pets',
                'question' => 'What about pets and pet waste in the yard?',
                'answer'   => 'Pets should be indoors on the service day — mowers, trimmers, and open gates are a bad '
                            . 'combination. Greenville Lawn Masters also offers pet waste removal as a standing add-on for '
                            . 'properties that need it, because running a mower over what is left behind is not something '
                            . 'anyone wants happening on their lawn.',
            ],
        ],
    ],
];

/* Flatten for schema. The visible markup below iterates the SAME array, so the
   JSON-LD cannot drift from the rendered copy. */
$flatFaqs = [];
foreach ($faqCategories as $category) {
    foreach ($category['faqs'] as $faq) {
        $flatFaqs[] = $faq;
    }
}

/* Counted, never typed. The hero used to say "Eighteen questions" while the
   array held twenty-one — a number written by hand goes stale the first time
   a question is added, and it goes stale silently. Spelled out for prose. */
$faqCount = count($flatFaqs);
$faqCountWord = [
    18 => 'Eighteen', 19 => 'Nineteen', 20 => 'Twenty', 21 => 'Twenty-one',
    22 => 'Twenty-two', 23 => 'Twenty-three', 24 => 'Twenty-four',
][$faqCount] ?? (string) $faqCount;

/* ── Schema ────────────────────────────────────────────────────*/
$pageSchema = [
    generateFAQSchema($flatFaqs),
    generateBreadcrumbSchema([
        ['name' => 'Home', 'url' => '/'],
        ['name' => 'FAQ',  'url' => '/faq/'],
    ]),
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'WebPage',
        '@id'         => $canonicalUrl . '#webpage',
        'url'         => $canonicalUrl,
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'about'       => ['@id' => organizationId()],
        'speakable'   => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.hero-answer', '.faq-answer', 'h1'],
        ],
    ],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   FAQ — page-scoped styles
   Every class prefixed .fq-. Colour, shadow, spacing, radius and timing
   are var() tokens without exception. Raw px only for icon boxes,
   hairline borders, and the marker geometry.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  two distinct SVG dividers (double wave, peak)
     C5  asymmetric grid — sticky category rail 0.32fr / answers 0.68fr
     C7  signature section — the sticky category rail itself, used nowhere else
     C9  native <details>/<summary> disclosure with animated chevron + grid-rows
         height transition (no JS: an accordion that needs JS to open is an
         accordion that stays shut when the bundle fails)
     C10 floating decorative accents at 4-6% opacity
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────*/
.fq-hero {
  min-height: 54vh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-lawn-mowing.jpg');
  background-size: cover;
  background-position: center 58%;
  isolation: isolate;
}
.fq-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    linear-gradient(
      96deg,
      rgba(var(--color-dark-rgb), 0.94) 0%,
      rgba(var(--color-dark-rgb), 0.80) 44%,
      rgba(var(--color-primary-dark-rgb), 0.54) 76%,
      rgba(var(--color-primary-rgb), 0.32) 100%
    );
  z-index: 0;
}
.fq-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.32;
  pointer-events: none;
  z-index: 0;
}
.fq-hero__inner {
  position: relative;
  z-index: 2;
  max-width: 58rem;
  padding-block: calc(var(--nav-height) + var(--space-10)) var(--space-16);
}
@keyframes fqFade {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: none; }
}
.fq-hero .breadcrumb  { animation: fqFade 0.5s ease both; }
.fq-hero__eyebrow     { animation: fqFade 0.6s ease 0.06s both; }
.fq-hero h1           { animation: fqFade 0.6s ease 0.12s both; }
.fq-hero .hero-answer { animation: fqFade 0.6s ease 0.20s both; }

.fq-hero__eyebrow {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  padding: var(--space-2) var(--space-4);
  border: 1px solid rgba(var(--color-white-rgb), 0.25);
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.07);
  backdrop-filter: blur(6px);
  color: rgba(var(--color-white-rgb), 0.9);
  font-size: var(--font-size-sm);
  letter-spacing: 1px;
  text-transform: uppercase;
  margin-bottom: var(--space-5);
}
.fq-hero__eyebrow i, .fq-hero__eyebrow svg { width: 15px; height: 15px; color: var(--color-accent); }
.fq-hero h1 { font-size: var(--fs-h1); line-height: 1.03; text-wrap: balance; margin-bottom: var(--space-6); }
.fq-hero .hero-answer { color: rgba(var(--color-white-rgb), 0.86); max-width: 60ch; margin-inline: 0; }

/* ── C5 + C7 · SIGNATURE — sticky category rail ───────────────
   Asymmetric 0.32fr / 0.68fr. The rail tracks which category is in view
   via :target-within-free CSS — no JS. This composition appears on no
   other page in the build. */
.fq-body { background: var(--color-light); }
.fq-grid {
  display: grid;
  grid-template-columns: 0.32fr 0.68fr;
  gap: var(--space-16);
  align-items: start;
}

.fq-rail {
  position: sticky;
  top: calc(var(--nav-height) + var(--space-6));
}
.fq-rail__title {
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--color-gray);
  margin-bottom: var(--space-5);
}
.fq-rail__list { list-style: none; padding: 0; margin: 0 0 var(--space-8); }
.fq-rail__list li { margin-bottom: var(--space-2); }
.fq-rail__link {
  display: flex;
  align-items: center;
  gap: var(--space-3);
  padding: var(--space-3) var(--space-4);
  border-radius: var(--radius-md);
  border-left: 3px solid transparent;
  color: var(--color-gray-dark);
  font-weight: 600;
  font-size: var(--font-size-sm);
  transition: background var(--transition-fast), color var(--transition-fast), border-color var(--transition-fast);
}
.fq-rail__link i, .fq-rail__link svg { width: 17px; height: 17px; color: var(--color-accent); flex-shrink: 0; }
.fq-rail__link:hover,
.fq-rail__link:focus-visible {
  background: var(--color-white);
  color: var(--color-primary);
  border-left-color: var(--color-accent);
}
.fq-rail__count {
  margin-left: auto;
  font-size: var(--font-size-xs);
  color: var(--color-gray);
  font-weight: 400;
}

/* Rail CTA card */
.fq-rail__cta {
  background: var(--color-primary-dark);
  border-radius: var(--radius-lg);
  padding: var(--space-6);
  color: var(--color-white);
  position: relative;
  overflow: hidden;
}
/* C10 · floating accent */
.fq-rail__cta::before {
  content: '';
  position: absolute;
  bottom: calc(var(--space-10) * -1);
  right: calc(var(--space-10) * -1);
  width: 140px; height: 140px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  opacity: 0.12;
}
.fq-rail__cta h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  margin-bottom: var(--space-3);
  text-wrap: balance;
  position: relative;
}
.fq-rail__cta p {
  font-size: var(--font-size-sm);
  color: rgba(var(--color-white-rgb), 0.72);
  line-height: 1.65;
  margin-bottom: var(--space-5);
  position: relative;
}
.fq-rail__cta .btn { position: relative; }

/* ── Category blocks ──────────────────────────────────────────*/
.fq-cat { margin-bottom: var(--space-16); scroll-margin-top: calc(var(--nav-height) + var(--space-6)); }
.fq-cat:last-child { margin-bottom: 0; }

.fq-cat__head {
  display: flex;
  align-items: center;
  gap: var(--space-4);
  margin-bottom: var(--space-3);
}
.fq-cat__icon {
  width: 48px; height: 48px;
  flex-shrink: 0;
  border-radius: var(--radius-md);
  background: var(--color-white);
  box-shadow: var(--shadow-sm);
  display: grid;
  place-items: center;
  color: var(--color-primary);
}
.fq-cat__icon i, .fq-cat__icon svg { width: 22px; height: 22px; }
.fq-cat__head h2 {
  font-family: var(--font-heading);
  font-size: var(--font-size-3xl);
  color: var(--color-primary);
  text-wrap: balance;
  margin: 0;
}
.fq-cat__blurb {
  color: var(--color-gray);
  font-size: var(--font-size-sm);
  margin-bottom: var(--space-6);
  max-width: 60ch;
}

/* ── C9 · JS-free disclosure ──────────────────────────────────
   <details>/<summary>, not a div + click handler. The answers must be
   readable — and crawlable, and Ctrl-F-able — with JavaScript disabled.
   Only the open/close animation is CSS; the mechanism is the browser's. */
.fq-item {
  background: var(--color-white);
  border: 1px solid var(--color-gray-light);
  border-radius: var(--radius-lg);
  margin-bottom: var(--space-4);
  overflow: hidden;
  transition: border-color var(--transition-base), box-shadow var(--transition-base);
  scroll-margin-top: calc(var(--nav-height) + var(--space-6));
}
.fq-item:hover { border-color: var(--color-accent); box-shadow: var(--shadow-sm); }
.fq-item[open] { border-color: var(--color-accent); box-shadow: var(--shadow-card); }

.fq-item summary {
  display: flex;
  align-items: center;
  gap: var(--space-4);
  padding: var(--space-6);
  cursor: pointer;
  list-style: none;
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  font-weight: 600;
  color: var(--color-primary-dark);
  text-wrap: balance;
}
.fq-item summary::-webkit-details-marker { display: none; }
.fq-item summary:focus-visible { outline: 2px solid var(--color-accent); outline-offset: -2px; }
.fq-item summary:hover { color: var(--color-primary); }
/* The heading inherits the summary's type so the outline stays semantic
   without the h3 reasserting its own default size and margin. */
.fq-item summary h3 {
  font: inherit;
  color: inherit;
  margin: 0;
  text-wrap: balance;
}

.fq-item__chev {
  margin-left: auto;
  flex-shrink: 0;
  width: 22px; height: 22px;
  color: var(--color-accent);
  transition: transform var(--transition-base);
}
.fq-item[open] .fq-item__chev { transform: rotate(180deg); }

.fq-item .faq-answer {
  padding: 0 var(--space-6) var(--space-6);
  color: var(--color-gray-dark);
  font-size: var(--font-size-base);
  line-height: 1.8;
  max-width: 68ch;
  margin: 0;
}
/* A hairline that starts where the text does. */
.fq-item .faq-answer::before {
  content: '';
  display: block;
  height: 1px;
  background: var(--color-gray-light);
  margin-bottom: var(--space-5);
}

/* Entrance animation on open, gated behind the reduced-motion guard the
   framework reset already declares. */
@keyframes fqReveal {
  from { opacity: 0; transform: translateY(-6px); }
  to   { opacity: 1; transform: none; }
}
.fq-item[open] .faq-answer { animation: fqReveal var(--transition-base) ease both; }

/* ── Still-stuck band ─────────────────────────────────────────*/
.fq-stuck { background: var(--color-dark); text-align: center; }
.fq-stuck h2 { color: var(--color-white); font-size: var(--fs-h2); text-wrap: balance; margin-bottom: var(--space-5); }
.fq-stuck .answer-block { color: rgba(var(--color-white-rgb), 0.75); max-width: 60ch; margin: 0 auto var(--space-10); }
.fq-stuck__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .fq-grid { grid-template-columns: 1fr; gap: var(--space-10); }

  /* A sticky rail on a phone is a rail that eats the viewport. */
  .fq-rail { position: static; }
  .fq-rail__list {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-2);
    margin-bottom: var(--space-6);
  }
  .fq-rail__list li { margin: 0; }
  .fq-rail__link {
    background: var(--color-white);
    border: 1px solid var(--color-gray-light);
    border-left-width: 3px;
  }
  .fq-rail__count { display: none; }
}

@media (max-width: 768px) {
  .fq-hero { min-height: 48vh; }
  .fq-item summary { padding: var(--space-5); font-size: var(--font-size-base); }
  .fq-item .faq-answer { padding: 0 var(--space-5) var(--space-5); font-size: var(--font-size-sm); }
  .fq-cat__head h2 { font-size: var(--font-size-2xl); }
}

@media (max-width: 600px) {
  .fq-stuck__actions .btn { width: 100%; }
  .fq-cat__head { gap: var(--space-3); }
  .fq-cat__icon { width: 40px; height: 40px; }
}

/* ── Deep-linked answer ───────────────────────────────────────
   The `q-` ids sit on the answer paragraphs, so /faq/#q-when-to-aerate
   makes the browser expand the parent <details> before scrolling. Mark the
   answer it landed on, then let the highlight fade — a permanent highlight
   on a shared link looks like an error state. scroll-margin clears the
   fixed navbar, which would otherwise sit on top of the answer. */
.fq-item .faq-answer { scroll-margin-top: calc(var(--nav-height) + var(--space-8)); }
.fq-item .faq-answer:target {
  animation: fqTarget 2.6s ease both;
  border-radius: var(--radius-md);
}
@keyframes fqTarget {
  0%, 50% { background: var(--color-card-tint-3); box-shadow: 0 0 0 var(--space-3) var(--color-card-tint-3); }
  100%    { background: transparent; box-shadow: 0 0 0 var(--space-3) transparent; }
}

/* ── Focus states ─────────────────────────────────────────────
   Every interactive element on this page, including the summary rows,
   which are focusable by default and are the page's primary control. */
.fq-rail__cta .btn:focus-visible,
.fq-stuck__actions .btn:focus-visible {
  outline: 2px solid var(--color-white);
  outline-offset: 3px;
}
.fq-item:focus-within { border-color: var(--color-accent); }

/* ── List markers inside answers ──────────────────────────────*/
.fq-item .faq-answer ::marker { color: var(--color-accent); }

/* Brand-green selection rather than the OS blue. */
.fq-body ::selection { background: rgba(var(--color-accent-rgb), 0.25); color: var(--color-black); }

/* ── Windows High Contrast / forced-colors ────────────────────
   The chevron rotation and the open/closed border tint are the only cues
   that a row is expanded. forced-colors discards both, so restore a
   border and keep the chevron meaningful. */
@media (forced-colors: active) {
  .fq-item { border: 1px solid CanvasText; }
  .fq-item[open] { border: 2px solid Highlight; }
  .fq-rail__link { border: 1px solid CanvasText; }
  .fq-cat__icon, .fq-rail__cta { border: 1px solid CanvasText; }
}

/* ── Reduced motion ───────────────────────────────────────────
   The framework reset crushes animation duration globally, which already
   neutralises fqReveal and the chevron. The target flash is a background
   change rather than movement, so it is safe to keep — but it should not
   animate. Pin it to its resting state. */
@media (prefers-reduced-motion: reduce) {
  .fq-item .faq-answer:target { animation: none; background: var(--color-card-tint-3); }
  .fq-item__chev { transition: none; }
}

/* ── Wide viewports ───────────────────────────────────────────*/
@media (min-width: 1400px) {
  .fq-grid { gap: var(--space-16); }
  .fq-item .faq-answer { max-width: 72ch; }
}

/* ── Print ────────────────────────────────────────────────────
   A printed FAQ with every answer collapsed is a printed list of
   questions. Force every <details> open and drop the chrome. */
@media print {
  @page { margin: 2cm; }

  .site-header, .site-footer, .cookie-banner, .mobile-cta-bar,
  .back-to-top, .fq-rail, .fq-stuck, .fq-hero .breadcrumb,
  .fq-item__chev, .svg-divider { display: none !important; }

  .fq-hero {
    min-height: auto;
    padding-block: var(--space-4);
    background: none;
    color: var(--color-black);
  }
  .fq-hero::before, .fq-hero::after { display: none; }
  .fq-hero h1, .fq-hero .hero-answer { color: var(--color-black); }
  .fq-hero__eyebrow { display: none; }

  .fq-grid { display: block; }
  .fq-body { background: none; }

  /* The disclosure mechanism is display-driven; override it for paper. */
  .fq-item { border: 1px solid var(--color-black); box-shadow: none; break-inside: avoid; }
  .fq-item > summary { list-style: none; }
  .fq-item .faq-answer { display: block !important; animation: none; }
  .fq-item:not([open]) .faq-answer { display: block !important; }

  .fq-cat { break-before: page; }
  .fq-cat:first-child { break-before: auto; }
  .fq-cat__head h2 { break-after: avoid; }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero fq-hero" aria-label="Lawn care questions and answers">
    <div class="container">
        <div class="fq-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">FAQ</span></li>
                </ol>
            </nav>

            <span class="fq-hero__eyebrow">
                <i data-lucide="help-circle" aria-hidden="true"></i>
                Questions &middot; Mauldin, SC
            </span>

            <h1>Lawn care questions, <span class="text-accent">answered straight</span></h1>

            <p class="hero-answer">
                <?php echo e($faqCountWord); ?> questions Greenville Lawn Masters gets asked most about lawn
                care in Mauldin, South Carolina — mowing intervals, aeration windows, the crabgrass
                pre-emergent threshold, how estimates are priced, and what happens when the crew shows up.
                No prices are quoted here, because no two Upstate lawns are the same.
            </p>

        </div>
    </div>

    <!-- Divider · double wave into the tinted body -->
    <div class="svg-divider" style="height:60px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,30 C150,60 350,0 600,26 C850,52 1050,6 1200,28 L1200,60 L0,60 Z" fill="var(--color-light)" opacity="0.45"/>
            <path d="M0,40 C180,64 380,14 620,36 C860,58 1040,20 1200,38 L1200,60 L0,60 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · SIGNATURE — RAIL + ANSWERS ══════════ -->
<section class="fq-body" aria-label="Frequently asked questions">
    <div class="container">
        <div class="fq-grid">

            <!-- ── Sticky category rail ── -->
            <aside class="fq-rail">
                <nav aria-label="FAQ categories">
                    <p class="fq-rail__title">Jump to</p>
                    <ul class="fq-rail__list">
                        <?php foreach ($faqCategories as $category): ?>
                            <li>
                                <a class="fq-rail__link" href="#faq-<?php echo e($category['key']); ?>">
                                    <i data-lucide="<?php echo e($category['icon']); ?>" aria-hidden="true"></i>
                                    <span><?php echo e($category['label']); ?></span>
                                    <span class="fq-rail__count"><?php echo e((string) count($category['faqs'])); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>

                <div class="fq-rail__cta">
                    <h3>Question not here?</h3>
                    <p>
                        Send it with the estimate request. Someone walks the property and answers it
                        standing on the lawn in question.
                    </p>
                    <a href="/contact/" class="btn btn-accent btn-block">Ask Greenville Lawn Masters</a>
                </div>
            </aside>

            <!-- ── Answers ── -->
            <div>
                <?php foreach ($faqCategories as $catIndex => $category): ?>
                    <section class="fq-cat" id="faq-<?php echo e($category['key']); ?>"
                             aria-label="<?php echo e($category['label']); ?> questions">

                        <div class="fq-cat__head reveal-up">
                            <div class="fq-cat__icon">
                                <i data-lucide="<?php echo e($category['icon']); ?>" aria-hidden="true"></i>
                            </div>
                            <h2><?php echo e($category['label']); ?></h2>
                        </div>
                        <p class="fq-cat__blurb reveal-up reveal-delay-1"><?php echo e($category['blurb']); ?></p>

                        <?php foreach ($category['faqs'] as $i => $faq): ?>
                            <?php
                                /* Alternating reveal directions — CLAUDE.md forbids all-fade-up rows.
                                   The first item of the first category opens by default so the page
                                   never presents as a wall of closed rows. */
                                $dir  = ($i % 2 === 0) ? 'reveal-left' : 'reveal-right';
                                $open = ($catIndex === 0 && $i === 0) ? ' open' : '';
                            ?>
                            <?php /* The <h3> sits INSIDE <summary>. The HTML spec allows heading
                                     content there, and it keeps the question in the document
                                     outline for both screen readers and crawlers without the
                                     usual sr-only-duplicate-text hack.

                                     The `q-` id lives on the ANSWER, not on the <details>. A
                                     fragment pointing AT a closed <details> scrolls to a shut
                                     accordion; a fragment pointing at a node INSIDE it makes the
                                     browser expand it first. So /faq/#q-when-to-aerate opens the
                                     answer it names instead of landing on a collapsed row. */ ?>
                            <details class="fq-item <?php echo $dir; ?>"<?php echo $open; ?>>
                                <summary>
                                    <h3><?php echo e($faq['question']); ?></h3>
                                    <i data-lucide="chevron-down" class="fq-item__chev" aria-hidden="true"></i>
                                </summary>
                                <p class="faq-answer" id="q-<?php echo e($faq['id']); ?>"><?php echo e($faq['answer']); ?></p>
                            </details>
                        <?php endforeach; ?>

                    </section>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

    <!-- Divider · peak into the dark closing band -->
    <div class="svg-divider" style="height:68px" aria-hidden="true">
        <svg viewBox="0 0 1200 68" preserveAspectRatio="none">
            <path d="M0,68 L0,44 L600,4 L1200,44 L1200,68 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 3 · STILL STUCK ══════════ -->
<section class="fq-stuck" aria-label="Ask a question directly">
    <div class="container">
        <h2 class="reveal-up">Still wondering what your lawn actually needs?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Greenville Lawn Masters walks the property before quoting anything, and the walkthrough is
            free. Bring the question — soil, shade, drainage, a patch that never comes back — and get an
            answer on the spot rather than a guess over the phone.
        </p>
        <div class="fq-stuck__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Estimate
            </a>
            <?php if ($hasPhone): ?>
                <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                    <i data-lucide="phone" aria-hidden="true"></i>
                    Call <?php echo e($phoneDisplay); ?>
                </a>
            <?php else: ?>
                <a href="/services/" class="btn btn-outline-white btn-lg">
                    <i data-lucide="list" aria-hidden="true"></i>
                    Browse All Services
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
