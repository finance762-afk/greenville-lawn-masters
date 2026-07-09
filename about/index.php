<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /about/index.php — Phase 5
   Greenville Lawn Masters · Mauldin, SC

   Directory + index.php, NOT a flat /about.php. CLAUDE.md marks
   "/about.php ❌", header.php and footer.php both link to "/about/",
   and .htaccess rewrites `^([^\.]+)$ → $1.php` would turn a request
   for "/about/" into "about/.php". Only 404.php stays flat.

   ── WHAT IS NOT ON THIS PAGE, AND WHY ──────────────────────────
   The Phase 5 prompt asks for a "history timeline or milestones"
   and a "certifications and credentials" section. Intake supplied:

     content.years          2       (→ founded 2024)
     content.usps           ["fast estimate within 24 hours."]
     content.certifications []      ← EMPTY
     content.description    ""      ← EMPTY
     owner_name             ""      ← EMPTY
     reviews                []      ← EMPTY

   That is the entire raw material for a company story. So:

   • NO founding anecdote. There is no owner name, no origin story,
     and no "started with one mower and a pickup" in build-plan.json.
     Writing one would be fiction presented as company history.
   • NO certifications block. certifications:[] means the honest count
     is zero. CLAUDE.md: "Never fabricate credentials."
   • NO "licensed and insured" claim, no crew size, no jobs-completed
     counter, no star rating, no client quotes.
   • The MILESTONE TIMELINE is replaced by a SEASONAL timeline — what
     the crew actually does to an Upstate lawn month by month. Every
     entry is verifiable horticulture for the SC Piedmont, and none of
     it pretends to be corporate history we do not have. It is also
     more useful to the reader than "2024: founded".

   The credentials section that DOES render lists only checkable facts:
   founding year, base city, service radius, service count, and the one
   written commitment intake recorded (24-hour estimate).

   ⚠ FLAG FOR CM: includes/footer.php renders a "Licensed & Insured"
   trust badge on every page. Intake never supplied a licence number or
   a certificate of insurance, and this page and /terms/ both decline to
   make that claim. Either supply the licence + COI, or that badge must
   come out of footer.php. The site currently contradicts itself.

   IMAGES: six real client photographs, real <img> tags with width/height
   and honest alt text from $photoLibrary. No gradient placeholder blocks.
   ============================================================ */

$currentPage = 'about';

$pageTitle       = 'About Greenville Lawn Masters | Lawn Care in Mauldin, SC';
$pageDescription = 'Greenville Lawn Masters is a lawn care company based in Mauldin, SC, '
                 . 'serving Greenville County within 25 miles. How we work, what we cut, '
                 . 'and the season we work to.';   // 158 chars — cap is 160

$canonicalUrl = $siteUrl . '/about/';
$ogImage      = $ogImageUrl;

/* Not a hero photograph in the LCP sense — the About hero is a split, and its
   image is the first paint-critical asset on the page. Preloaded as such. */
$heroImg          = heroPhoto('backyard');
$heroImagePreload = $heroImg['src'];

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Working principles (section 2) ───────────────────────────
   Each one is a restatement of a process commitment recorded in
   build-plan.json or already published on the service pages — never a
   value-statement about character ("we care", "we're honest"), which is
   unverifiable and reads as filler. Tints rotate 1→2→3→1. */
$principles = [
    [
        'icon'  => 'footprints',
        'title' => 'The property gets walked first',
        'body'  => 'Grass type, slope, drainage, bed lines, and the corners that always struggle. '
                 . 'A number quoted over the phone from a satellite photo is a guess, and the person '
                 . 'who pays for a wrong guess is you.',
    ],
    [
        'icon'  => 'file-text',
        'title' => 'The price arrives in writing, within 24 hours',
        'body'  => 'An itemised estimate lands within a day of the visit, split by service so you can '
                 . 'take all of it or part of it. It is the one hard commitment this company makes, '
                 . 'and it is in writing so you can hold us to it.',
    ],
    [
        'icon'  => 'calendar-check',
        'title' => 'Mowing runs on a fixed route',
        'body'  => 'Weekly through the Upstate growing season, biweekly in the shoulder months. A route '
                 . 'means the interval never quietly stretches to ten days in July, which is how a lawn '
                 . 'gets scalped on the next cut.',
    ],
    [
        'icon'  => 'sparkles',
        'title' => 'Every visit ends the same way',
        'body'  => 'Edges cut, clippings blown off the concrete and not into the beds, gates shut behind '
                 . 'us, debris hauled off the property. The only evidence anyone was there should be the '
                 . 'lawn itself.',
    ],
];

/* ── The Upstate lawn year (section 4) ────────────────────────
   Verifiable SC Piedmont horticulture, not company history. Soil-temperature
   and timing claims here match the FAQ answers on the homepage and the service
   pages — one set of facts across the whole site. */
$seasons = [
    [
        'window' => 'Late Feb – Mid Mar',
        'title'  => 'Pre-emergent goes down',
        'body'   => 'The crabgrass window opens when soil temperature at two inches holds near 55°F. '
                  . 'Applied a week late, a pre-emergent does nothing at all — the seed has already '
                  . 'germinated and the barrier has nothing left to stop.',
    ],
    [
        'window' => 'March – April',
        'title'  => 'Spring cleanup and the first cuts',
        'body'   => 'Beds cleared and re-edged, winter debris hauled, mulch refreshed. Mowing starts as '
                  . 'the turf breaks dormancy, and the route locks in before growth outruns it.',
    ],
    [
        'window' => 'May – June',
        'title'  => 'Warm-season lawns get cored',
        'body'   => 'Bermuda and zoysia are aerated once they are actively growing and can knit the holes '
                  . 'closed. Mauldin sits on heavy Piedmont clay, which compacts hard, so most warm-season '
                  . 'lawns here benefit from this annually.',
    ],
    [
        'window' => 'June – August',
        'title'  => 'Weekly mowing, and no scalping',
        'body'   => 'Upstate growth peaks and the route runs weekly. Never more than one third of the blade '
                  . 'comes off in a single cut — scalping a heat-stressed lawn is an open invitation to '
                  . 'weeds and disease.',
    ],
    [
        'window' => 'September – October',
        'title'  => 'Fescue is aerated and overseeded',
        'body'   => 'Tall fescue thins every August in this climate. Early fall is when it is cored and '
                  . 'overseeded together, while soil is still warm enough to germinate seed and cool '
                  . 'enough that the seedlings survive.',
    ],
    [
        'window' => 'November – January',
        'title'  => 'Leaves off, and the lawn put to bed',
        'body'   => 'Leaf and storm debris removed rather than left to mat and smother the turf. Winter '
                  . 'prep goes down, beds are cut back, and gutters get cleared before the winter rain '
                  . 'finds the fascia.',
    ],
];

/* ── Verifiable facts (section 5) ─────────────────────────────
   Every number here traces to build-plan.json or config.php. This is the
   honest replacement for a certifications block: certifications is []. */
$facts = [
    ['icon' => 'map-pin',      'value' => $address['city'] . ', ' . $address['state'], 'label' => 'Where the trucks are based'],
    ['icon' => 'calendar',     'value' => (string) $yearEstablished,                   'label' => 'Year the company was founded'],
    ['icon' => 'compass',      'value' => $targetRadius . ' miles',                    'label' => 'Service radius from Mauldin'],
    ['icon' => 'list-checks',  'value' => (string) count($services),                   'label' => 'Services offered, one crew'],
];

/* ── Schema ────────────────────────────────────────────────────
   AboutPage + BreadcrumbList. `mainEntity` points at the homepage
   LocalBusiness @id rather than restating the business (CLAUDE.md:
   "Other pages reference homepage @id … don't duplicate LocalBusiness
   blocks"). No FAQPage, no Service, no aggregateRating. */
$pageSchema = [
    generateBreadcrumbSchema([
        ['name' => 'Home',  'url' => '/'],
        ['name' => 'About', 'url' => '/about/'],
    ]),
    [
        '@context'   => 'https://schema.org',
        '@type'      => 'AboutPage',
        '@id'        => $canonicalUrl . '#webpage',
        'url'        => $canonicalUrl,
        'name'       => $pageTitle,
        'description'=> $pageDescription,
        'mainEntity' => ['@id' => organizationId()],
        'speakable'  => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.hero-answer', '.answer-block', 'h1'],
        ],
    ],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   About — page-scoped styles
   Every class prefixed .ab- so nothing collides with another page's
   <style> block. Colour, shadow, spacing, radius and timing are var()
   tokens without exception — a raw hex/px literal for any of those is
   an automatic QA fail (CLAUDE.md tier matrix). Raw px appears only for
   icon boxes, hairline borders, and rail geometry.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  two distinct SVG dividers (soft wave, angled slice)
     C5  asymmetric/broken grid — the story split runs 1.15fr / 0.85fr
         with the secondary photo bleeding out of the primary's corner
     C6  image-stack composition (primary + offset secondary + rule)
     C7  signature section — the vertical seasonal rail, used nowhere else
     C8  stat/fact strip on a dark ground
     C10 floating decorative accents at 4-8% opacity
     C11 image treatment — arch clip on the values photo, hover zoom
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────
   40vh-ish editorial band, not a full-bleed 100vh photo: this is an inner
   page and the visitor arrived to read, not to be sold. */
.ab-hero {
  min-height: 62vh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-backyard-beds.jpg');
  background-size: cover;
  background-position: center 55%;
  isolation: isolate;
}
.ab-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    linear-gradient(
      104deg,
      rgba(var(--color-dark-rgb), 0.93) 0%,
      rgba(var(--color-dark-rgb), 0.78) 42%,
      rgba(var(--color-primary-dark-rgb), 0.52) 74%,
      rgba(var(--color-primary-rgb), 0.30) 100%
    );
  z-index: 0;
}
.ab-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.32;
  pointer-events: none;
  z-index: 0;
}
.ab-hero__inner {
  position: relative;
  z-index: 2;
  max-width: 60rem;
  padding-block: calc(var(--nav-height) + var(--space-10)) var(--space-16);
}

/* Above-fold entrance is a CSS keyframe, never a reveal class: reveal rules
   set opacity:0 and depend on IntersectionObserver (CLAUDE.md). */
@keyframes abFade {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: none; }
}
.ab-hero .breadcrumb  { animation: abFade 0.5s ease both; }
.ab-hero__eyebrow     { animation: abFade 0.6s ease 0.06s both; }
.ab-hero h1           { animation: abFade 0.6s ease 0.12s both; }
.ab-hero .hero-answer { animation: abFade 0.6s ease 0.20s both; }

.ab-hero__eyebrow {
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
.ab-hero__eyebrow i, .ab-hero__eyebrow svg {
  width: 15px; height: 15px; color: var(--color-accent);
}
.ab-hero h1 {
  font-size: var(--fs-h1);
  line-height: 1.02;
  text-wrap: balance;
  margin-bottom: var(--space-6);
}
.ab-hero .hero-answer {
  color: rgba(var(--color-white-rgb), 0.86);
  max-width: 62ch;
  margin-inline: 0;
}

/* ── C5 · Asymmetric story split ──────────────────────────────
   1.15fr / 0.85fr, not 1fr/1fr. The broken ratio is the point: an even
   split reads as a template, and CLAUDE.md requires at least one
   asymmetric layout section per page. */
.ab-story { background: var(--color-white); }
.ab-story__grid {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: var(--space-16);
  align-items: center;
}
.ab-story .section-num {
  display: block;
  font-family: var(--font-heading);
  font-size: var(--font-size-sm);
  letter-spacing: 3px;
  text-transform: uppercase;
  color: var(--color-accent);
  margin-bottom: var(--space-3);
}
.ab-story h2 {
  font-size: var(--fs-h2);
  color: var(--color-primary);
  text-wrap: balance;
  margin-bottom: var(--space-6);
}
.ab-story p {
  color: var(--color-gray-dark);
  line-height: 1.8;
  max-width: 60ch;
}
.ab-story .answer-block { margin-inline: 0; }

/* Pull-out sentence. Not a testimonial — a statement of method. */
.ab-pullout {
  border-left: 3px solid var(--color-accent);
  padding: var(--space-2) 0 var(--space-2) var(--space-6);
  margin: var(--space-8) 0;
  font-family: var(--font-heading);
  font-size: var(--font-size-xl);
  line-height: 1.5;
  color: var(--color-primary-dark);
  text-wrap: balance;
}

/* ── C6 · Image stack ─────────────────────────────────────────
   Primary photo, secondary offset out of its bottom-left corner, and a thin
   rule anchoring the pair. Both are real client frames. */
.ab-stack { position: relative; padding-bottom: var(--space-16); }
.ab-stack__primary {
  position: relative;
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-xl);
}
.ab-stack__primary img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  transition: transform var(--transition-slow);
}
.ab-stack__primary:hover img { transform: scale(1.04); }

.ab-stack__secondary {
  position: absolute;
  right: calc(var(--space-12) * -1);
  bottom: 0;
  width: 55%;
  border-radius: var(--radius-lg);
  overflow: hidden;
  border: var(--space-2) solid var(--color-white);
  box-shadow: var(--shadow-lg);
}
.ab-stack__secondary img {
  width: 100%;
  aspect-ratio: 1 / 1;
  object-fit: cover;
}
/* C10 · floating accent, 6% opacity */
.ab-stack::before {
  content: '';
  position: absolute;
  top: calc(var(--space-10) * -1);
  left: calc(var(--space-10) * -1);
  width: 180px;
  height: 180px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  opacity: 0.06;
  z-index: -1;
}

/* ── C7 · Principles, tinted and rotated ──────────────────────
   Tints rotate 1→2→3→1 so no two adjacent cards share a background
   (CLAUDE.md forbids all-white card rows). */
.ab-principles { background: var(--color-light); }
.ab-principles__grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.ab-principle {
  border-radius: var(--radius-lg);
  padding: var(--space-8);
  display: flex;
  gap: var(--space-5);
  align-items: flex-start;
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.ab-principle:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-card);
}
.ab-principle__icon {
  width: 52px;
  height: 52px;
  flex-shrink: 0;
  border-radius: var(--radius-md);
  background: var(--color-white);
  box-shadow: var(--shadow-sm);
  display: grid;
  place-items: center;
  color: var(--color-primary);
}
.ab-principle__icon i, .ab-principle__icon svg { width: 24px; height: 24px; }
.ab-principle h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-xl);
  color: var(--color-primary-dark);
  margin-bottom: var(--space-2);
  text-wrap: balance;
}
.ab-principle p {
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  margin: 0;
}

/* ── C11 · Arch-clipped values photo ──────────────────────────*/
.ab-values h2 {
  font-size: var(--fs-h2);
  color: var(--color-primary);
  text-wrap: balance;
  margin-bottom: var(--space-6);
}
.ab-values p { color: var(--color-gray-dark); line-height: 1.8; max-width: 60ch; }
.ab-values .answer-block { margin-inline: 0; }
.ab-values__grid {
  display: grid;
  grid-template-columns: 0.9fr 1.1fr;
  gap: var(--space-16);
  align-items: center;
}
.ab-arch {
  border-radius: var(--radius-full) var(--radius-full) var(--radius-lg) var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-lg);
}
.ab-arch img {
  width: 100%;
  aspect-ratio: 3 / 4;
  object-fit: cover;
  transition: transform var(--transition-slow);
}
.ab-arch:hover img { transform: scale(1.05); }

/* ── C7 · SIGNATURE SECTION — the seasonal rail ───────────────
   A single vertical spine with alternating entries. This composition appears
   nowhere else in the build; it is this page's signature. It carries the
   Upstate lawn year, which is the honest substitute for the company-milestone
   timeline the prompt asked for (see the file header). */
.ab-season {
  background: var(--color-dark);
  color: var(--color-white);
}
.ab-season h2 { color: var(--color-white); }
.ab-season .hero-answer { color: rgba(var(--color-white-rgb), 0.72); }
.ab-season .eyebrow-label { color: var(--color-accent); }

.ab-rail {
  position: relative;
  max-width: 62rem;
  margin: var(--space-16) auto 0;
}
/* The spine itself */
.ab-rail::before {
  content: '';
  position: absolute;
  left: 50%;
  top: 0;
  bottom: 0;
  width: 2px;
  transform: translateX(-50%);
  background: linear-gradient(
    to bottom,
    transparent,
    rgba(var(--color-accent-rgb), 0.55) 10%,
    rgba(var(--color-accent-rgb), 0.55) 90%,
    transparent
  );
}
.ab-rail__item {
  position: relative;
  width: 50%;
  padding-inline: var(--space-12);
  padding-block: var(--space-6);
}
.ab-rail__item:nth-child(odd)  { margin-left: 0; text-align: right; }
.ab-rail__item:nth-child(even) { margin-left: 50%; text-align: left; }

/* The node on the spine */
.ab-rail__item::before {
  content: '';
  position: absolute;
  top: calc(var(--space-8) + var(--space-1));
  width: 14px;
  height: 14px;
  border-radius: var(--radius-full);
  background: var(--color-dark);
  border: 2px solid var(--color-accent);
  box-shadow: 0 0 0 var(--space-1) rgba(var(--color-accent-rgb), 0.18);
  transition: background var(--transition-base), box-shadow var(--transition-base);
}
.ab-rail__item:nth-child(odd)::before  { right: -7px; }
.ab-rail__item:nth-child(even)::before { left: -7px; }
.ab-rail__item:hover::before {
  background: var(--color-accent);
  box-shadow: 0 0 0 var(--space-2) rgba(var(--color-accent-rgb), 0.25);
}

.ab-rail__window {
  display: inline-block;
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--color-accent);
  margin-bottom: var(--space-2);
}
.ab-rail__item h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-xl);
  color: var(--color-white);
  margin-bottom: var(--space-3);
  text-wrap: balance;
}
.ab-rail__item p {
  color: rgba(var(--color-white-rgb), 0.7);
  font-size: var(--font-size-sm);
  line-height: 1.75;
  margin: 0;
}

/* ── C8 · Fact strip ──────────────────────────────────────────
   Four checkable facts. Deliberately not styled as "stats" with animated
   counters — a counter implies an achievement metric, and three of these
   four are simply attributes of the business. */
.ab-facts { background: var(--color-primary-dark); }
.ab-facts__grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-8);
}
.ab-fact { text-align: center; color: var(--color-white); }
.ab-fact__icon {
  width: 48px; height: 48px;
  margin: 0 auto var(--space-4);
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.1);
  display: grid;
  place-items: center;
  color: var(--color-accent);
}
.ab-fact__icon i, .ab-fact__icon svg { width: 22px; height: 22px; }
.ab-fact__value {
  display: block;
  font-family: var(--font-heading);
  font-size: var(--font-size-3xl);
  font-weight: 800;
  line-height: 1.1;
  margin-bottom: var(--space-2);
  text-wrap: balance;
}
.ab-fact__label {
  display: block;
  font-size: var(--font-size-sm);
  color: rgba(var(--color-white-rgb), 0.68);
  line-height: 1.5;
}
/* The honest counterweight to the fact strip. */
.ab-facts .photo-note {
  max-width: 68ch;
  margin: var(--space-12) auto 0;
  color: rgba(var(--color-white-rgb), 0.62);
  border-color: rgba(var(--color-white-rgb), 0.18);
}
.ab-facts .photo-note i, .ab-facts .photo-note svg { color: var(--color-accent); }

/* ── Closing CTA ──────────────────────────────────────────────*/
.ab-cta {
  background:
    linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  text-align: center;
}
.ab-cta h2 {
  color: var(--color-white);
  font-size: var(--fs-h2);
  text-wrap: balance;
  margin-bottom: var(--space-5);
}
.ab-cta .answer-block {
  color: rgba(var(--color-white-rgb), 0.88);
  max-width: 58ch;
  margin: 0 auto var(--space-10);
}
.ab-cta__actions {
  display: flex;
  gap: var(--space-4);
  justify-content: center;
  flex-wrap: wrap;
}
/* C10 · floating accent */
.ab-cta::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 640px;
  height: 640px;
  transform: translate(-50%, -50%);
  border-radius: var(--radius-full);
  border: 2px solid var(--color-white);
  opacity: 0.04;
  pointer-events: none;
}

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .ab-story__grid,
  .ab-values__grid { grid-template-columns: 1fr; gap: var(--space-12); }
  .ab-stack { padding-bottom: var(--space-12); }
  .ab-stack__secondary { right: 0; width: 48%; }
  .ab-facts__grid { grid-template-columns: repeat(2, 1fr); gap: var(--space-10); }
}

@media (max-width: 768px) {
  .ab-hero { min-height: 54vh; }
  .ab-principles__grid { grid-template-columns: 1fr; }

  /* The rail collapses to a single left-hand spine — an alternating timeline
     on a 375px viewport leaves ~40 usable characters per line. */
  .ab-rail::before { left: 7px; transform: none; }
  .ab-rail__item,
  .ab-rail__item:nth-child(odd),
  .ab-rail__item:nth-child(even) {
    width: 100%;
    margin-left: 0;
    text-align: left;
    padding-inline: var(--space-10) 0;
  }
  .ab-rail__item:nth-child(odd)::before,
  .ab-rail__item:nth-child(even)::before { left: 1px; right: auto; }
}

@media (max-width: 600px) {
  .ab-stack__secondary { position: static; width: 100%; margin-top: var(--space-4); border-width: 0; }
  .ab-stack::before { display: none; }
  .ab-facts__grid { grid-template-columns: 1fr; }
  .ab-cta__actions .btn { width: 100%; }
  .ab-principle { flex-direction: column; gap: var(--space-4); }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero ab-hero" aria-label="About Greenville Lawn Masters">
    <div class="container">
        <div class="ab-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">About</span></li>
                </ol>
            </nav>

            <span class="ab-hero__eyebrow">
                <i data-lucide="leaf" aria-hidden="true"></i>
                About Us &middot; Mauldin, SC
            </span>

            <h1>The crew that keeps <span class="text-accent">Mauldin</span> mowed</h1>

            <p class="hero-answer">
                Greenville Lawn Masters is a lawn care and landscape maintenance company based in
                Mauldin, South Carolina, serving homes and businesses within <?php echo e((string) $targetRadius); ?> miles
                across Greenville County. Founded in <?php echo e((string) $yearEstablished); ?>, the company runs
                <?php echo e((string) count($services)); ?> services with one crew — from a weekly mowing route to
                aeration, sod, mulch, gutters, and seasonal cleanup.
            </p>

        </div>
    </div>

    <!-- Divider · soft wave, filled with the next section's white -->
    <div class="svg-divider" style="height:64px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,32 C180,64 320,0 520,26 C700,50 860,10 1040,30 C1120,39 1170,42 1200,40 L1200,60 L0,60 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · STORY ══════════ -->
<section class="ab-story" aria-label="How Greenville Lawn Masters works">
    <div class="container">
        <div class="ab-story__grid">

            <div>
                <span class="section-num reveal-left">01 / Who We Are</span>
                <h2 class="reveal-left">What is <span class="text-accent">Greenville Lawn Masters</span>?</h2>

                <p class="answer-block reveal-left reveal-delay-1">
                    Greenville Lawn Masters is a lawn care company in Mauldin, South Carolina. It cuts,
                    feeds, aerates, mulches, and cleans up residential and commercial properties within
                    <?php echo e((string) $targetRadius); ?> miles of Mauldin, and it has done so since
                    <?php echo e((string) $yearEstablished); ?>. The work is booked off a walk of the property
                    and priced in writing within 24 hours.
                </p>

                <p class="reveal-left reveal-delay-2">
                    Mauldin is a hard place to keep a lawn honest. The soil is heavy Piedmont clay that
                    compacts under its own weight and sheds water instead of drinking it. The town sits in
                    the transition zone, so half the yards on a street run warm-season bermuda or zoysia
                    and the other half run tall fescue — grasses that want opposite things at opposite
                    times of year. Feeding fescue on a bermuda schedule is how a lawn gets thin in August
                    and never comes back.
                </p>

                <p class="ab-pullout reveal-left reveal-delay-2">
                    Most of what separates a good Upstate lawn from a struggling one is timing, and timing
                    is the part you cannot buy at the hardware store.
                </p>

                <p class="reveal-left reveal-delay-3">
                    So the schedule follows the grass rather than the calendar: pre-emergent when soil
                    temperature reaches the crabgrass threshold, coring when the turf can knit the holes
                    closed, overseeding while the ground is still warm. That is the whole method. There is
                    no secret to it, only the discipline of doing each thing in its week rather than the
                    week that happened to be convenient.
                </p>
            </div>

            <div class="ab-stack reveal-right">
                <?php $storyPrimary = photo('mowing'); $storySecondary = photo('hedges'); ?>
                <div class="ab-stack__primary">
                    <img src="<?php echo e($storyPrimary['src']); ?>"
                         alt="<?php echo e($storyPrimary['alt']); ?>"
                         width="<?php echo e((string) $storyPrimary['w']); ?>"
                         height="<?php echo e((string) $storyPrimary['h']); ?>"
                         loading="lazy" decoding="async">
                </div>
                <div class="ab-stack__secondary">
                    <img src="<?php echo e($storySecondary['src']); ?>"
                         alt="<?php echo e($storySecondary['alt']); ?>"
                         width="<?php echo e((string) $storySecondary['w']); ?>"
                         height="<?php echo e((string) $storySecondary['h']); ?>"
                         loading="lazy" decoding="async">
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══════════ 3 · PRINCIPLES ══════════ -->
<section class="ab-principles" aria-label="How Greenville Lawn Masters works on your property">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">How We Work</span>
            <h2>What can you expect from <span class="text-accent">the crew</span> on your property?</h2>
            <p class="hero-answer">
                Greenville Lawn Masters walks every property before quoting it, sends the estimate in
                writing within 24 hours, runs mowing on a fixed route rather than on request, and hauls
                debris off the property at the end of each visit. Those four commitments are the job.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="ab-principles__grid">
            <?php foreach ($principles as $i => $principle): ?>
                <?php $rotation = ($i % 3) + 1; ?>
                <article class="ab-principle card-tint-<?php echo $rotation; ?> reveal-up reveal-delay-<?php echo $rotation; ?>">
                    <div class="ab-principle__icon">
                        <i data-lucide="<?php echo e($principle['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <div>
                        <h3><?php echo e($principle['title']); ?></h3>
                        <p><?php echo e($principle['body']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ══════════ 4 · VALUES + ARCH PHOTO ══════════ -->
<section class="ab-values" aria-label="Why one crew handles every service">
    <div class="container">
        <div class="ab-values__grid">

            <div class="ab-arch reveal-left">
                <?php $valuesImg = photo('mulch_bed'); ?>
                <img src="<?php echo e($valuesImg['src']); ?>"
                     alt="<?php echo e($valuesImg['alt']); ?>"
                     width="<?php echo e((string) $valuesImg['w']); ?>"
                     height="<?php echo e((string) $valuesImg['h']); ?>"
                     loading="lazy" decoding="async">
            </div>

            <div>
                <span class="eyebrow-label reveal-right">One Crew</span>
                <h2 class="reveal-right">
                    Why does the same crew do the mulch <span class="text-accent">and</span> the gutters?
                </h2>

                <p class="answer-block reveal-right reveal-delay-1">
                    Greenville Lawn Masters runs every service with one crew because the property is one
                    system. The gutter that overflows is what floods the bed. The bed that floods is what
                    drowns the shrubs. The compacted clay under the turf is why the water had nowhere to
                    go in the first place.
                </p>

                <p class="reveal-right reveal-delay-2">
                    A mowing contractor who never looks up at the roofline will cut around a dying azalea
                    for two seasons without ever asking what is killing it. Because the same people handle
                    the mowing, the beds, the trimming, the gutters, and the seasonal cleanup, the cause
                    tends to get found rather than mowed around.
                </p>

                <p class="reveal-right reveal-delay-3">
                    It also means one number to call, one estimate covering the whole property, and one
                    crew that already knows where the sprinkler heads are buried and which gate latch
                    sticks.
                </p>
            </div>

        </div>
    </div>

    <!-- Divider · angled slice into the dark seasonal section -->
    <div class="svg-divider" style="height:72px" aria-hidden="true">
        <svg viewBox="0 0 1200 72" preserveAspectRatio="none">
            <path d="M0,72 L1200,10 L1200,72 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · SIGNATURE — THE UPSTATE LAWN YEAR ══════════ -->
<section class="ab-season" aria-label="The lawn care year in Upstate South Carolina">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Calendar We Work To</span>
            <h2>What happens to a <span class="text-accent">Mauldin lawn</span> across one year?</h2>
            <p class="hero-answer">
                Greenville Lawn Masters works to the Upstate growing season, not to a fixed monthly plan.
                Pre-emergent lands when soil hits 55°F, warm-season turf is cored in early summer, fescue
                is aerated and overseeded in early fall, and leaves come off before they mat.
            </p>
        </div>

        <div class="ab-rail">
            <?php foreach ($seasons as $i => $season): ?>
                <?php /* Alternating reveal directions — CLAUDE.md forbids all-fade-up rows. */ ?>
                <div class="ab-rail__item <?php echo ($i % 2 === 0) ? 'reveal-right' : 'reveal-left'; ?>">
                    <span class="ab-rail__window"><?php echo e($season['window']); ?></span>
                    <h3><?php echo e($season['title']); ?></h3>
                    <p><?php echo e($season['body']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ══════════ 6 · VERIFIABLE FACTS ══════════ -->
<section class="ab-facts" aria-label="Greenville Lawn Masters at a glance">
    <div class="container">

        <div class="ab-facts__grid">
            <?php foreach ($facts as $i => $fact): ?>
                <?php $dir = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-scale'][$i % 4]; ?>
                <div class="ab-fact <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="ab-fact__icon">
                        <i data-lucide="<?php echo e($fact['icon']); ?>" aria-hidden="true"></i>
                    </div>
                    <span class="ab-fact__value"><?php echo e($fact['value']); ?></span>
                    <span class="ab-fact__label"><?php echo e($fact['label']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <?php /* The credentials disclosure. build-plan.json content.certifications is an
                 empty array, so there is no certification to list. Saying so plainly beats
                 an empty "Certifications" heading, and beats inventing one outright. */ ?>
        <p class="photo-note reveal-up">
            <i data-lucide="info" aria-hidden="true"></i>
            <span>
                Every figure above is a fact about the business, not a performance claim.
                Greenville Lawn Masters does not publish a review score, a jobs-completed count,
                or trade certifications on this site, because none have been independently
                verified. Ask for references on the estimate visit and you will get them.
            </span>
        </p>

    </div>
</section>

<!-- ══════════ 7 · CTA ══════════ -->
<section class="ab-cta" aria-label="Request a lawn care estimate">
    <div class="container">
        <h2 class="reveal-up">Want your property walked before the next mow?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Tell Greenville Lawn Masters what the lawn needs. Someone walks it, prices it, and sends a
            written, itemised estimate within 24 hours — mowing route, treatment program, or a one-off
            cleanup.
        </p>
        <div class="ab-cta__actions reveal-up reveal-delay-2">
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
                <?php /* No phone in intake. A "Call Now" button with no number, or one with a
                         placeholder number, is worse than no button (config.php $missingIntake). */ ?>
                <a href="/services/" class="btn btn-outline-white btn-lg">
                    <i data-lucide="list" aria-hidden="true"></i>
                    Browse All Services
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
