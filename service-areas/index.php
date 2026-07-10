<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /service-areas/index.php — Phase 6
   Greenville Lawn Masters · Mauldin, SC

   The service-area OVERVIEW page. header.php and footer.php have
   linked /service-areas/ since Phase 2, so this page lives here —
   NOT at /service-area.php or /areas/ (flat .php files in
   subdirectories are a CLAUDE.md anti-pattern, and moving the URL
   now would 404 the committed internal link graph).

   config.php $serviceAreas holds exactly ONE city: Mauldin, the
   home base, resolved from zip 29662 at intake. So this page is
   honest about what it is: one dedicated area page (Mauldin) plus
   the 25-mile radius build-plan.json recorded ($targetRadius),
   visualised as a coverage diagram. The surrounding communities
   named below are verifiable geography — real Greenville County
   cities that sit inside a 25-mile circle around 29662 — and none
   of them gets a fake dedicated page or an invented local claim.
   When the client confirms more cities, they land in config.php
   $serviceAreas and this page's card grid grows on its own.

   Distances shown are approximate straight-line miles from central
   Mauldin (29662) and are labelled as such on the page.
   ============================================================ */

$currentPage = 'service-areas';

$heroImg = heroPhoto('hedges');   // 1600px rendition; tree-shrub page uses it too — reuse is allowed, treatment differs

$pageTitle       = 'Lawn Care Service Areas Across Greenville County | Greenville Lawn Masters';
$pageDescription = 'Greenville Lawn Masters serves Mauldin, SC and a 25-mile radius of Greenville County — Simpsonville, Five Forks, and the Golden Strip. Estimates in 24 hours.';   // 156 chars

$canonicalUrl     = $siteUrl . '/service-areas/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Radius communities ───────────────────────────────────────
   Real Greenville County places inside the recorded 25-mile radius.
   `mi` is approximate straight-line distance from central Mauldin
   (29662); `x`/`y` are percentage coordinates on the coverage
   diagram (50/50 = Mauldin, 2% per mile). Geography, not service
   claims: the only service-area commitment intake recorded is the
   radius itself, and that is exactly what these illustrate. */
$radiusCommunities = [
    ['name' => 'Simpsonville',   'mi' => 5,  'x' => 57.0, 'y' => 57.0],
    ['name' => 'Five Forks',     'mi' => 6,  'x' => 61.0, 'y' => 45.5],
    ['name' => 'Greenville',     'mi' => 9,  'x' => 37.0, 'y' => 37.0],
    ['name' => 'Fountain Inn',   'mi' => 10, 'x' => 60.0, 'y' => 67.0],
    ['name' => 'Piedmont',       'mi' => 10, 'x' => 31.5, 'y' => 58.0],
    ['name' => 'Taylors',        'mi' => 12, 'x' => 59.0, 'y' => 28.0],
    ['name' => 'Greer',          'mi' => 15, 'x' => 71.0, 'y' => 29.0],
    ['name' => 'Travelers Rest', 'mi' => 17, 'x' => 37.0, 'y' => 19.0],
];

/* ── How the radius actually works (bento cards) ──────────────
   Every statement is a process fact from intake (one crew, based in
   29662, 24-hour written estimate, 25-mile radius) — no coverage
   promise is invented for any specific street. */
$radiusFacts = [
    ['icon' => 'map-pin',        'title' => 'Based in 29662, not routed in', 'body' => 'The crew starts every day inside Mauldin. No dispatch center two counties away, no "we\'re in your area on Thursdays" window — the service radius is drawn around where the equipment actually parks.'],
    ['icon' => 'circle-dot',     'title' => 'One radius, one standard',      'body' => 'A property in Travelers Rest gets the same walkthrough, the same written estimate, and the same crew as one three streets from home base. Distance changes the drive, not the work.'],
    ['icon' => 'clock',          'title' => 'Estimates in 24 hours, radius-wide', 'body' => 'The free walkthrough and the written, itemised estimate within 24 hours apply across the whole circle — Simpsonville to Travelers Rest, not just the streets around Butler Road.'],
    ['icon' => 'circle-help',    'title' => 'On the edge? Just ask',         'body' => 'The 25-mile line is a planning tool, not a wall. If your property sits near the boundary, send the address — the answer is a quick yes or no, never a surcharge invented on the spot.'],
];

/* ── Schema ───────────────────────────────────────────────────
   BreadcrumbList + an ItemList of the dedicated area pages (one
   today) + a WebPage node carrying Speakable. No LocalBusiness
   restatement: the homepage node owns the business entity and this
   page's ItemList/WebPage reference it (CLAUDE.md — other pages
   reference the homepage @id rather than duplicating the block). */
$pageSchema = [
    generateBreadcrumbSchema([
        ['name' => 'Home',          'url' => '/'],
        ['name' => 'Service Areas', 'url' => '/service-areas/'],
    ]),
    [
        '@context'        => 'https://schema.org',
        '@type'           => 'ItemList',
        '@id'             => $canonicalUrl . '#area-list',
        'name'            => $siteName . ' service areas',
        'itemListElement' => array_map(
            fn(array $area, int $i): array => [
                '@type'    => 'ListItem',
                'position' => $i + 1,
                'name'     => $area['city'] . ', ' . $area['state'],
                'url'      => absoluteUrl('/service-areas/' . $area['slug'] . '/'),
            ],
            $serviceAreas,
            array_keys($serviceAreas)
        ),
    ],
    [
        '@context'  => 'https://schema.org',
        '@type'     => 'WebPage',
        '@id'       => $canonicalUrl . '#webpage',
        'url'       => $canonicalUrl,
        'name'      => $pageTitle,
        'about'     => ['@id' => organizationId()],
        'speakable' => [
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
   Service Areas overview — page-scoped styles
   Every rule is prefixed .sa- so nothing collides with another
   page's <style> block. All colour, spacing, shadow, radius, and
   timing values are var() tokens — the only hex lives inside the
   hero's SVG noise data-URI, which is texture, not a design colour.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + 128deg gradient ::before (angle unique
         to this page) + noise ::after
     C3  two distinct SVG dividers — a single sweeping curve and a
         triple-peak angle; neither repeats a divider used elsewhere
     C4  editorial pull-line in the radius section
     C5  bento grid of radius facts, uneven first span
     C6  asymmetric 0.7/1.3 split with an oversized "25" watermark
     C7  SIGNATURE — the coverage radar: concentric token-built
         range rings around a pulsing Mauldin hub, each community
         chip placed at its approximate bearing and distance.
         Appears on no other page in the build.
     C11 image treatment — offset accent frame on the area card photo
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────*/
.sa-hero {
  min-height: 68vh;
  min-height: 68svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-hedge-trimming.webp');
  background-size: cover;
  background-position: center 40%;
  isolation: isolate;
}
.sa-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    128deg,
    rgba(var(--color-dark-rgb), 0.93) 0%,
    rgba(var(--color-primary-dark-rgb), 0.78) 42%,
    rgba(var(--color-primary-rgb), 0.5) 74%,
    rgba(var(--color-accent-rgb), 0.26) 100%
  );
  z-index: 0;
}
.sa-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.26;
  z-index: 0;
  pointer-events: none;
}
.sa-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 60rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.sa-hero .breadcrumb {
  animation: saFade 0.5s ease both;
}
.sa-hero__eyebrow {
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
  animation: saFade 0.55s ease 0.08s both;
}
.sa-hero__eyebrow i,
.sa-hero__eyebrow svg {
  width: 15px;
  height: 15px;
}
.sa-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.2rem, 4.6vw, 3.8rem);
  line-height: 1.08;
  letter-spacing: -0.03em;
  text-wrap: balance;
  margin-bottom: var(--space-5);
  animation: saRise 0.6s ease 0.16s both;
}
.sa-hero h1 .text-accent {
  color: var(--color-accent);
}
.sa-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: saRise 0.6s ease 0.26s both;
}
.sa-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: saRise 0.6s ease 0.36s both;
}
.sa-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: saRise 0.6s ease 0.46s both;
}
.sa-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.sa-hero__trust i,
.sa-hero__trust svg {
  width: 17px;
  height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}
/* Above-fold entrance is pure CSS, never a reveal class — the reveal
   system sets opacity:0 and would blank the hero if the observer never fires. */
@keyframes saFade {
  from { opacity: 0; }
  to   { opacity: 1; }
}
@keyframes saRise {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: none; }
}

/* ── C6 · Radius explainer — asymmetric with "25" watermark ───*/
.sa-radius {
  background: var(--color-light);
}
.sa-radius__layout {
  display: grid;
  grid-template-columns: 0.7fr 1.3fr;
  gap: var(--space-16);
  align-items: center;
}
.sa-watermark {
  position: relative;
  font-family: var(--font-heading);
  font-weight: 900;
  font-size: clamp(6rem, 14vw, 13rem);
  line-height: 0.82;
  letter-spacing: -0.05em;
  color: var(--color-primary);
  opacity: 0.14;
  user-select: none;
}
.sa-watermark span {
  position: absolute;
  left: 0.06em;
  bottom: -1.6em;
  font-size: var(--font-size-sm);
  font-family: var(--font-body);
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
  opacity: 1;
  color: var(--color-primary-dark);
  white-space: nowrap;
}
.sa-radius h2 {
  text-wrap: balance;
  margin-bottom: var(--space-5);
}
.sa-radius .answer-block {
  margin-inline: 0;
}
.sa-radius__pull {
  font-family: var(--font-heading);
  font-style: italic;
  font-weight: 600;
  font-size: clamp(1.25rem, 2.2vw, 1.75rem);
  line-height: 1.3;
  color: var(--color-primary-dark);
  border-left: 4px solid var(--color-accent);
  padding-left: var(--space-6);
  margin-top: var(--space-8);
  max-width: 44ch;
}

/* ── C5 · Bento grid of radius facts ──────────────────────────*/
.sa-facts {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.sa-fact {
  grid-column: span 1;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.sa-fact:first-child {
  grid-column: span 2;
}
.sa-fact:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-card);
}
.sa-fact__icon {
  width: 46px;
  height: 46px;
  display: grid;
  place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
  margin-bottom: var(--space-4);
}
.sa-fact__icon i,
.sa-fact__icon svg {
  width: 22px;
  height: 22px;
}
.sa-fact h3 {
  font-size: var(--font-size-lg);
  text-wrap: balance;
  margin-bottom: var(--space-2);
  color: var(--color-primary-dark);
}
.sa-fact p {
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.65;
  margin: 0;
}

/* ── C7 · SIGNATURE — the coverage radar ──────────────────────
   Concentric range rings on the section's dark ground, a pulsing
   hub on Mauldin, and each community chip absolutely positioned at
   its approximate bearing and distance (2% per straight-line mile).
   Built entirely from brand tokens; nothing else in the build looks
   like this. On small screens it degrades to a wrapped chip list —
   the data is the content, the radar is the presentation. */
.sa-map {
  background: var(--color-dark);
}
.sa-map .section-header h2,
.sa-map .eyebrow-label--light {
  color: var(--color-white);
}
.sa-map .answer-block {
  color: rgba(var(--color-white-rgb), 0.78);
}
.sa-radar {
  position: relative;
  width: min(640px, 100%);
  aspect-ratio: 1 / 1;
  margin: var(--space-12) auto 0;
  border-radius: var(--radius-full);
  background:
    radial-gradient(circle,
      rgba(var(--color-accent-rgb), 0.08) 0%,
      rgba(var(--color-primary-rgb), 0.1) 45%,
      rgba(var(--color-dark-rgb), 0) 72%);
}
.sa-radar__ring {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  border: 1px dashed rgba(var(--color-accent-rgb), 0.38);
  border-radius: var(--radius-full);
  pointer-events: none;
}
.sa-radar__ring--1 {
  width: 40%;
  height: 40%;
}
.sa-radar__ring--2 {
  width: 70%;
  height: 70%;
}
.sa-radar__ring--3 {
  width: 100%;
  height: 100%;
  border-style: solid;
  border-color: rgba(var(--color-accent-rgb), 0.55);
}
/* Each label sits on its ring's top edge: rings are 40% / 70% / 100%
   of the container, so their top edges land at 30% / 15% / 0%. */
.sa-radar__ring-label {
  position: absolute;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: var(--font-size-xs);
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: rgba(var(--color-white-rgb), 0.55);
  background: var(--color-dark);
  padding: 0 var(--space-2);
  border-radius: var(--radius-sm);
  pointer-events: none;
}
.sa-radar__ring-label--1 { top: 30%; }
.sa-radar__ring-label--2 { top: 15%; }
.sa-radar__ring-label--3 { top: 0%; }
.sa-radar__hub {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: grid;
  place-items: center;
  gap: var(--space-1);
  z-index: 2;
  text-align: center;
}
.sa-radar__hub-dot {
  width: 16px;
  height: 16px;
  margin-inline: auto;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  box-shadow: 0 0 0 6px rgba(var(--color-accent-rgb), 0.25);
  position: relative;
}
.sa-radar__hub-dot::after {
  content: '';
  position: absolute;
  inset: -6px;
  border-radius: var(--radius-full);
  border: 2px solid rgba(var(--color-accent-rgb), 0.6);
  animation: saPulse 2.6s ease-out infinite;
}
@keyframes saPulse {
  0%   { transform: scale(1);    opacity: 0.9; }
  100% { transform: scale(2.4);  opacity: 0; }
}
.sa-radar__hub strong {
  font-family: var(--font-heading);
  font-size: var(--font-size-base);
  color: var(--color-white);
  white-space: nowrap;
}
.sa-radar__hub small {
  font-size: var(--font-size-xs);
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: rgba(var(--color-white-rgb), 0.6);
  white-space: nowrap;
}
.sa-radar__chips {
  list-style: none;
  margin: 0;
  padding: 0;
}
.sa-chip {
  position: absolute;
  transform: translate(-50%, -50%);
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  background: rgba(var(--color-white-rgb), 0.08);
  border: 1px solid rgba(var(--color-white-rgb), 0.18);
  border-radius: var(--radius-full);
  padding: var(--space-1) var(--space-3);
  font-size: var(--font-size-xs);
  font-weight: 600;
  color: rgba(var(--color-white-rgb), 0.92);
  white-space: nowrap;
  backdrop-filter: blur(4px);
  transition: border-color var(--transition-base), background var(--transition-base);
}
.sa-chip:hover {
  background: rgba(var(--color-accent-rgb), 0.2);
  border-color: rgba(var(--color-accent-rgb), 0.6);
}
.sa-chip small {
  font-weight: 400;
  color: rgba(var(--color-white-rgb), 0.55);
  font-size: inherit;
}
.sa-radar__note {
  max-width: 60ch;
  margin: var(--space-10) auto 0;
  text-align: center;
  color: rgba(var(--color-white-rgb), 0.55);
  font-size: var(--font-size-xs);
  line-height: 1.7;
}
.sa-radar__note p {
  margin: 0;
}

/* ── Area card grid ───────────────────────────────────────────*/
.sa-areas {
  background: var(--color-white);
}
.sa-areas__grid {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: var(--space-6);
  margin-top: var(--space-12);
  align-items: stretch;
}
.sa-area-card {
  display: flex;
  flex-direction: column;
  border-radius: var(--radius-xl);
  overflow: hidden;
  box-shadow: var(--shadow-card);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.sa-area-card:hover {
  transform: translateY(-5px);
  box-shadow: var(--shadow-lg);
}
.sa-area-card__media {
  position: relative;
  aspect-ratio: 16 / 9;
  overflow: hidden;
}
/* C11 — offset accent frame floating inside the photo edge */
.sa-area-card__media::after {
  content: '';
  position: absolute;
  inset: var(--space-3);
  border: 1px solid rgba(var(--color-white-rgb), 0.5);
  border-radius: var(--radius-md);
  pointer-events: none;
}
.sa-area-card__media img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform var(--transition-slow);
}
.sa-area-card:hover .sa-area-card__media img {
  transform: scale(1.04);
}
.sa-area-card__flag {
  position: absolute;
  top: var(--space-4);
  left: var(--space-4);
  z-index: 1;
  display: inline-flex;
  align-items: center;
  gap: var(--space-1);
  background: var(--color-primary-dark);
  color: var(--color-white);
  border-radius: var(--radius-full);
  padding: var(--space-1) var(--space-3);
  font-size: var(--font-size-xs);
  font-weight: 700;
  letter-spacing: 1px;
  text-transform: uppercase;
}
.sa-area-card__flag i,
.sa-area-card__flag svg {
  width: 13px;
  height: 13px;
}
.sa-area-card__body {
  display: flex;
  flex-direction: column;
  flex: 1;
  gap: var(--space-3);
  padding: var(--space-8);
}
.sa-area-card__body h3 {
  font-size: var(--font-size-2xl);
  color: var(--color-primary-dark);
  text-wrap: balance;
  margin: 0;
}
.sa-area-card__meta {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2) var(--space-4);
  font-size: var(--font-size-xs);
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  color: var(--color-gray);
}
.sa-area-card__body p {
  margin: 0;
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.7;
}
.sa-area-card__cta {
  margin-top: auto;
  padding-top: var(--space-4);
  color: var(--color-accent);
  font-weight: 700;
  font-size: var(--font-size-sm);
}
.sa-area-card__cta::after {
  content: ' →';
  display: inline-block;
  transition: transform var(--transition-base);
}
.sa-area-card:hover .sa-area-card__cta::after {
  transform: translateX(4px);
}
/* The companion panel: honest "your street next?" card, tinted */
.sa-next-card {
  display: flex;
  flex-direction: column;
  gap: var(--space-4);
  border-radius: var(--radius-xl);
  padding: var(--space-10) var(--space-8);
  border: 1px solid rgba(var(--color-primary-rgb), 0.12);
}
.sa-next-card h3 {
  font-size: var(--font-size-xl);
  color: var(--color-primary-dark);
  text-wrap: balance;
  margin: 0;
}
.sa-next-card p {
  margin: 0;
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.7;
}
.sa-next-card__list {
  list-style: none;
  margin: 0;
  padding: 0;
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2);
}
.sa-next-card__list li {
  background: var(--color-white);
  border: 1px solid rgba(var(--color-primary-rgb), 0.15);
  border-radius: var(--radius-full);
  padding: var(--space-1) var(--space-3);
  font-size: var(--font-size-xs);
  font-weight: 600;
  color: var(--color-gray-dark);
}
.sa-next-card .btn {
  align-self: flex-start;
  margin-top: auto;
}

/* ── Services strip ───────────────────────────────────────────*/
.sa-services {
  background: var(--color-light);
}

/* ── Final CTA ────────────────────────────────────────────────*/
.sa-cta {
  background: linear-gradient(120deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.sa-cta::before {
  content: '';
  position: absolute;
  bottom: -25%;
  right: -6%;
  width: 420px;
  height: 420px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.sa-cta .container {
  position: relative;
  z-index: 1;
}
.sa-cta h2 {
  color: var(--color-white);
  text-wrap: balance;
  margin-bottom: var(--space-4);
}
.sa-cta .answer-block {
  color: rgba(var(--color-white-rgb), 0.9);
  margin-inline: auto;
  margin-bottom: var(--space-8);
}
.sa-cta__actions {
  display: flex;
  gap: var(--space-4);
  justify-content: center;
  flex-wrap: wrap;
}

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .sa-radius__layout {
    grid-template-columns: 1fr;
    gap: var(--space-10);
  }
  .sa-watermark {
    font-size: clamp(5rem, 20vw, 9rem);
  }
  .sa-watermark span {
    position: static;
    display: block;
    margin-top: var(--space-4);
  }
  .sa-facts {
    grid-template-columns: repeat(2, 1fr);
  }
  .sa-fact:first-child {
    grid-column: span 2;
  }
  .sa-areas__grid {
    grid-template-columns: 1fr;
  }
}
@media (max-width: 700px) {
  .sa-hero {
    min-height: 0;
  }
  .sa-hero__actions .btn {
    width: 100%;
    justify-content: center;
  }
  .sa-facts {
    grid-template-columns: 1fr;
  }
  .sa-fact:first-child {
    grid-column: span 1;
  }
  /* The radar degrades to a wrapped chip list: rings and hub hide,
     chips flow statically, distances still readable on each chip. */
  .sa-radar {
    aspect-ratio: auto;
    border-radius: var(--radius-lg);
    background: rgba(var(--color-white-rgb), 0.04);
    padding: var(--space-6);
  }
  .sa-radar__ring,
  .sa-radar__ring-label,
  .sa-radar__hub-dot::after {
    display: none;
  }
  .sa-radar__hub {
    position: static;
    transform: none;
    margin-bottom: var(--space-5);
  }
  .sa-radar__chips {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-2);
    justify-content: center;
  }
  .sa-chip {
    position: static;
    transform: none;
  }
  .sa-area-card__body {
    padding: var(--space-6);
  }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero sa-hero" aria-label="Lawn care service areas across Greenville County, South Carolina">
    <div class="container">
        <div class="sa-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Service Areas</span></li>
                </ol>
            </nav>

            <span class="sa-hero__eyebrow">
                <i data-lucide="map" aria-hidden="true"></i>
                Where We Work &middot; Greenville County, SC
            </span>

            <h1>Lawn Care in <span class="text-accent">Mauldin</span> &amp; the Surrounding Greenville County Communities</h1>

            <p class="hero-answer">
                Greenville Lawn Masters is a lawn care and landscape maintenance company based in
                Mauldin, SC (29662), serving homes and businesses within a <?php echo e((string) $targetRadius); ?>-mile
                radius — Simpsonville, Five Forks, Greenville, Fountain Inn, and the rest of the
                Golden Strip corridor. One local crew, a free walkthrough, and a written estimate
                within 24 hours, anywhere in the circle.
            </p>

            <div class="sa-hero__actions">
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
                    <?php /* $phone is empty in config.php — route to the area page rather
                             than render a call button with no number behind it. */ ?>
                    <a href="/service-areas/mauldin/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="map-pin" aria-hidden="true"></i>
                        See the Mauldin Page
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Trust chips carry only what intake recorded — no license, rating,
                     or job-count claims exist in config.php to cite. */ ?>
            <div class="sa-hero__trust">
                <span><i data-lucide="map-pin" aria-hidden="true"></i> Home base: <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?> <?php echo e($address['zip']); ?></span>
                <span><i data-lucide="circle-dot" aria-hidden="true"></i> <?php echo e((string) $targetRadius); ?>-mile service radius</span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
            </div>
        </div>
    </div>

    <!-- Divider — single sweeping curve into the radius section's light ground -->
    <div class="svg-divider" style="height:84px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,100 C420,10 780,10 1200,100 L1200,100 L0,100 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · HOW THE RADIUS WORKS ══════════ -->
<section class="sa-radius" aria-label="How the Greenville Lawn Masters service radius works">
    <div class="container">
        <div class="sa-radius__layout">

            <div class="sa-watermark reveal-left" aria-hidden="true">
                <?php echo e((string) $targetRadius); ?><span>Miles from home base</span>
            </div>

            <div>
                <h2 class="reveal-right">How far does <span class="text-accent">Greenville Lawn Masters</span> travel for lawn care?</h2>
                <p class="answer-block reveal-right reveal-delay-1">
                    Greenville Lawn Masters works within about <?php echo e((string) $targetRadius); ?> miles of
                    central Mauldin, SC — a circle that takes in Simpsonville, Five Forks, Greenville,
                    Fountain Inn, Piedmont, Taylors, Greer, and Travelers Rest. Every property inside it
                    gets the same free walkthrough and a written, itemised estimate within 24 hours.
                </p>
                <p class="reveal-right reveal-delay-2">
                    The circle is drawn around where the crew actually starts the day, not around a
                    marketing map. Mauldin sits on the Golden Strip — the I-385 corridor it shares with
                    Simpsonville and Fountain Inn — which puts most of the radius within a short,
                    predictable drive and keeps scheduling honest: no "we'll fit you in when a truck is
                    nearby," because the truck is already based here.
                </p>
                <blockquote class="sa-radius__pull reveal-right reveal-delay-3">
                    Distance changes the drive, not the work.
                </blockquote>
            </div>
        </div>

        <div class="sa-facts" data-p1-dynamic>
            <?php foreach ($radiusFacts as $i => $fact): ?>
                <?php
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="sa-fact <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="sa-fact__icon"><i data-lucide="<?php echo e($fact['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($fact['title']); ?></h3>
                    <p><?php echo e($fact['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider — triple-peak angle into the dark radar section -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 56" preserveAspectRatio="none">
            <path d="M0,56 L200,18 L400,44 L600,10 L800,40 L1000,14 L1200,48 L1200,56 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 3 · SIGNATURE — COVERAGE RADAR ══════════ -->
<?php /* No GBP map embed exists yet ($gbpUrl and $geo are empty at intake), so
         the required coverage visual is built rather than embedded: token-drawn
         range rings around the 29662 hub with each community at its approximate
         bearing and distance. Swap in the real GBP embed on the contact page
         when intake supplies it — this diagram stays either way. */ ?>
<section class="sa-map" aria-label="Coverage diagram of the Greenville Lawn Masters service radius">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label eyebrow-label--light">The Coverage Circle</span>
            <h2>Which communities fall inside the <span class="text-accent">service radius</span>?</h2>
            <p class="answer-block">
                Inside the <?php echo e((string) $targetRadius); ?>-mile circle around Mauldin:
                Simpsonville and Five Forks in the first ring, Greenville, Fountain Inn, and Piedmont
                close behind, then Taylors, Greer, and Travelers Rest toward the edge. Mauldin —
                home base — has its own dedicated page below.
            </p>
        </div>

        <div class="sa-radar reveal-scale">
            <span class="sa-radar__ring sa-radar__ring--1" aria-hidden="true"></span>
            <span class="sa-radar__ring sa-radar__ring--2" aria-hidden="true"></span>
            <span class="sa-radar__ring sa-radar__ring--3" aria-hidden="true"></span>
            <span class="sa-radar__ring-label sa-radar__ring-label--1" aria-hidden="true">~10 mi</span>
            <span class="sa-radar__ring-label sa-radar__ring-label--2" aria-hidden="true">~18 mi</span>
            <span class="sa-radar__ring-label sa-radar__ring-label--3" aria-hidden="true"><?php echo e((string) $targetRadius); ?> mi</span>

            <div class="sa-radar__hub">
                <span class="sa-radar__hub-dot" aria-hidden="true"></span>
                <strong><?php echo e($address['city']); ?>, <?php echo e($address['state']); ?></strong>
                <small>Home base &middot; <?php echo e($address['zip']); ?></small>
            </div>

            <ul class="sa-radar__chips" aria-label="Communities inside the service radius, with approximate distance from Mauldin" data-p1-dynamic>
                <?php foreach ($radiusCommunities as $community): ?>
                    <li class="sa-chip"
                        style="left: <?php echo e((string) $community['x']); ?>%; top: <?php echo e((string) $community['y']); ?>%;">
                        <?php echo e($community['name']); ?>
                        <small>~<?php echo e((string) $community['mi']); ?> mi</small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="sa-radar__note reveal-up">
            <p>
                Distances are approximate straight-line miles from central Mauldin (29662), for
                orientation only. Near the <?php echo e((string) $targetRadius); ?>-mile line?
                <a href="/contact/">Send your address</a> — the answer is a quick yes or no.
            </p>
        </div>
    </div>

    <!-- Divider — single sweeping curve (inverted arc) into the white area-card section -->
    <div class="svg-divider" style="height:84px" aria-hidden="true">
        <svg viewBox="0 0 1200 100" preserveAspectRatio="none">
            <path d="M0,100 C300,24 900,24 1200,100 L1200,100 L0,100 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · AREA PAGES ══════════ -->
<section class="sa-areas" aria-label="Dedicated service area pages">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Area Guides</span>
            <h2>Where does <span class="text-accent">Greenville Lawn Masters</span> publish local lawn guides?</h2>
            <p class="answer-block">
                Every dedicated area page covers what actually grows there — the soil, the grass types,
                the neighborhoods, and the services that fit them. Mauldin, the home base, is first.
                As service in surrounding communities is confirmed, each gets its own page here rather
                than a copy with the city name swapped.
            </p>
        </div>

        <div class="sa-areas__grid">
            <?php
            /* One card per config.php $serviceAreas entry — the grid grows on its
               own when the confirmed city list lands in config. Photos and copy
               stay honest: front_lawn IS a Mauldin property. */
            $areaPhoto = photo('front_lawn');
            ?>
            <?php foreach ($serviceAreas as $area): ?>
                <a class="sa-area-card reveal-left" href="/service-areas/<?php echo e($area['slug']); ?>/">
                    <div class="sa-area-card__media">
                        <?php if (!empty($area['primary'])): ?>
                            <span class="sa-area-card__flag">
                                <i data-lucide="home" aria-hidden="true"></i>
                                Home Base
                            </span>
                        <?php endif; ?>
                        <img src="<?php echo e($areaPhoto['src']); ?>"
                             alt="<?php echo e($areaPhoto['alt']); ?>"
                             width="<?php echo e((string) $areaPhoto['w']); ?>"
                             height="<?php echo e((string) $areaPhoto['h']); ?>"
                             loading="lazy" decoding="async">
                    </div>
                    <div class="sa-area-card__body">
                        <h3><?php echo e($area['city']); ?>, <?php echo e($area['state']); ?></h3>
                        <div class="sa-area-card__meta">
                            <span><?php echo e($area['zip']); ?></span>
                            <span>Greenville County</span>
                            <span>The Golden Strip</span>
                        </div>
                        <p>
                            The city the crew calls home — Butler Road subdivisions, the growth around
                            BridgeWay Station, red Cecil clay, and transition-zone turf that carries both
                            bermuda and tall fescue. The Mauldin guide covers all of it.
                        </p>
                        <span class="sa-area-card__cta">Read the <?php echo e($area['city']); ?> lawn care guide</span>
                    </div>
                </a>
            <?php endforeach; ?>

            <div class="sa-next-card card-tint-3 reveal-right">
                <h3>In the circle, but no page for your city yet?</h3>
                <p>
                    The crew already works the full <?php echo e((string) $targetRadius); ?>-mile radius —
                    a dedicated page is a guide, not a gate. If your property is in or around any of
                    these communities, the free walkthrough and 24-hour written estimate apply today.
                </p>
                <ul class="sa-next-card__list" data-p1-dynamic>
                    <?php foreach ($radiusCommunities as $community): ?>
                        <li><?php echo e($community['name']); ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="/contact/" class="btn btn-primary">
                    <i data-lucide="send" aria-hidden="true"></i>
                    Check Your Address
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ══════════ 5 · SERVICES ACROSS THE RADIUS ══════════ -->
<section class="sa-services section" aria-label="Lawn care services available across the service area">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>Which services does <span class="text-accent">Greenville Lawn Masters</span> bring to every area?</h2>
            <p class="answer-block">
                All 22 services travel with the crew — recurring mowing and lawn health programs,
                tree and shrub work, and the one-time projects like mulch, sod, and pressure washing.
                Three of the most requested are below; the full list lives on the services page.
            </p>
        </div>

        <div class="services-grid" data-p1-dynamic>
            <?php
            /* The mandated `.service-card-with-image` component, via the same
               include both services call sites use. Deterministic picks, not
               random: the overview always shows the same three. */
            $overviewPicks = ['lawn-care-services', 'spring-fall-cleanup', 'mulch-installation'];
            foreach ($overviewPicks as $i => $pickSlug):
                $cardPage     = servicePageBySlug($pickSlug);
                $cardRotation = ($i % 3) + 1;
                include $_SERVER['DOCUMENT_ROOT'] . '/includes/service-card.php';
            endforeach;
            ?>
        </div>

        <div style="text-align: center; margin-top: var(--space-10);" class="reveal-up">
            <a href="/services/" class="btn btn-primary btn-lg">
                <i data-lucide="list" aria-hidden="true"></i>
                View All 22 Services
            </a>
        </div>
    </div>
</section>

<!-- ══════════ 6 · FINAL CTA ══════════ -->
<section class="sa-cta" aria-label="Request a free estimate anywhere in the service area">
    <div class="container">
        <h2 class="reveal-up">Inside the circle? Your estimate is a walkthrough away.</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            From the streets around Butler Road to the far edge of the
            <?php echo e((string) $targetRadius); ?>-mile line, the process is the same: Greenville
            Lawn Masters walks the property for free and puts an itemised estimate in writing within
            24 hours. No pressure, no "area surcharge" — just a clear number.
        </p>
        <div class="sa-cta__actions reveal-up reveal-delay-2">
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
                <a href="/service-areas/mauldin/" class="btn btn-outline-white btn-lg">
                    <i data-lucide="map-pin" aria-hidden="true"></i>
                    Read the Mauldin Guide
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
