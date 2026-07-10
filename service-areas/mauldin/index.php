<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /service-areas/mauldin/index.php — Phase 6
   Greenville Lawn Masters · Mauldin, SC

   The dedicated area page for the home-base city — the only entry
   in config.php $serviceAreas. footer.php has linked
   /service-areas/mauldin/ since Phase 2.

   LOCAL SPECIFICS, all verifiable and all false if the city name
   were swapped (CLAUDE.md's city-swap rule):
     • Mauldin anchors the Golden Strip — the I-385 corridor it
       shares with Simpsonville and Fountain Inn
     • BridgeWay Station, the mixed-use development on I-385
     • the Mauldin Cultural Center and its outdoor amphitheater on
       East Butler Road (the former Mauldin High School)
     • Sunset Park, the city park
     • Lake Conestee Nature Preserve on the Reedy River at the
       city's northwest edge
     • Butler Road-corridor subdivisions such as Knollwood Heights
       and Forrester Woods, largely 1970s–90s housing stock
     • red Cecil clay — South Carolina's state soil — and the
       transition-zone turf split (bermuda/zoysia in sun, tall
       fescue under canopy)

   Business claims stay inside what intake recorded: founded 2024,
   based in 29662, one crew, 25-mile radius, free walkthrough,
   written itemised estimate within 24 hours, debris hauled off,
   22 services. No pricing, no license/certification claims, no
   review counts — none were supplied.
   ============================================================ */

$areaSlug    = 'mauldin';
$currentPage = 'service-areas';

$area = null;
foreach ($serviceAreas as $candidate) {
    if ($candidate['slug'] === $areaSlug) {
        $area = $candidate;
        break;
    }
}
/* A missing registry entry is a build bug — fail loudly, never render a
   half-page (same contract as photo() and serviceCardMeta()). */
if ($area === null) {
    throw new RuntimeException("Area '{$areaSlug}' is not in config.php \$serviceAreas");
}

$heroImg = heroPhoto('mowing');   // the crew actually mowing a Mauldin backyard — the honest hero for this page

$pageTitle       = 'Mauldin, SC Lawn Care & Yard Maintenance | Greenville Lawn Masters';   // homepage owns "Lawn Care in Mauldin, SC | …" — titles must be unique sitewide
$pageDescription = 'Lawn care in Mauldin, SC from a crew based in 29662 — mowing, fertilization, aeration, and seasonal cleanup across the Golden Strip. Free estimate in 24 hours.';   // 158 chars

$canonicalUrl     = $siteUrl . '/service-areas/' . $areaSlug . '/';
$ogImage          = $ogImageUrl;
$heroImagePreload = $heroImg['src'];

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

/* ── Local growing conditions (bento cards) ───────────────────
   Each card ties a checkable Mauldin/Upstate condition to the
   service page that answers it — condition first, sales second. */
$conditions = [
    ['icon' => 'mountain',   'title' => 'Red Cecil clay underfoot',        'href' => '/services/soil-testing-lime-application/', 'link' => 'Soil testing & lime',
     'body' => 'Most yards in the city sit on Cecil clay — South Carolina\'s state soil. It compacts hard, sheds water, and runs acidic, which is why aeration and lime do more here than another bag of fertilizer.'],
    ['icon' => 'trees',      'title' => 'Mature canopy over 1970s–90s streets', 'href' => '/services/tree-shrub-services/', 'link' => 'Tree & shrub services',
     'body' => 'Subdivisions like Knollwood Heights and Forrester Woods have had decades to grow their oaks. That shade pushes lawns toward tall fescue — and buries them in leaves every November.'],
    ['icon' => 'sun',        'title' => 'Transition-zone turf, both kinds',     'href' => '/services/lawn-care-services/', 'link' => 'Lawn care programs',
     'body' => 'Mauldin sits where bermuda and zoysia thrive in full sun while tall fescue carries the shade — two grasses on one street, on opposite mowing heights and feeding calendars.'],
    ['icon' => 'cloud-rain', 'title' => 'Hot, wet Upstate summers',             'href' => '/services/lawn-care-services/', 'link' => 'Grub & disease treatment',
     'body' => 'Around 50 inches of rain a year plus humid summer nights is brown-patch and grub weather. Catching disease pressure early is a walkthrough habit, not an upsell.'],
];

/* ── The Mauldin ledger (signature section) ───────────────────
   What the crew reads on a Mauldin property, each line connected
   to the service that answers it. Every left-hand entry is a real
   condition of this specific city. */
$ledger = [
    ['read' => 'Compacted red clay under thinning turf',            'href' => '/services/lawn-care-services/',                  'answer' => 'Aeration & overseeding'],
    ['read' => 'Fescue shaded by a 40-year oak canopy',             'href' => '/services/lawn-care-services/',                  'answer' => 'Grass seeding & lawn repair'],
    ['read' => 'November leaf drop across the whole yard',          'href' => '/services/spring-fall-cleanup/',                 'answer' => 'Spring & fall cleanup'],
    ['read' => 'Beds gone hard beside the front walk',              'href' => '/services/mulch-installation/',                  'answer' => 'Mulch installation'],
    ['read' => 'Acidic soil reading on the pH test',                'href' => '/services/soil-testing-lime-application/',       'answer' => 'Soil testing & lime application'],
    ['read' => 'Algae film on the driveway after a wet spring',     'href' => '/services/pressure-washing/',                    'answer' => 'Pressure washing'],
    ['read' => 'Gutters loaded from the fall canopy',               'href' => '/services/gutter-cleaning/',                     'answer' => 'Gutter cleaning'],
    ['read' => 'Fence line disappearing into overgrowth',           'href' => '/services/fence-line-clearing-debris-hauling/',  'answer' => 'Fence line clearing & hauling'],
];

/* ── Why Mauldin homeowners pick the local crew ───────────────
   Process commitments from intake only — never a credential. */
$whyUs = [
    ['icon' => 'home',           'title' => 'Based inside the city, not routed through it', 'body' => 'The equipment parks in 29662. When rain shuffles the week, a Mauldin address is the easiest one on the schedule to make right — home base is minutes away, not a county over.'],
    ['icon' => 'users',          'title' => 'One crew, the whole property',                  'body' => 'The same people who mow handle the beds, the hedges, and the haul-off. Nothing is subcontracted to a second truck you never met, and nothing is left bagged at the curb.'],
    ['icon' => 'file-text',      'title' => 'A written number within 24 hours',              'body' => 'Every estimate starts with a walkthrough on foot — not a satellite quote — and lands in writing, itemised, within a day. You compare it line by line, on your own time.'],
    ['icon' => 'calendar-range', 'title' => 'Timed to the Upstate calendar',                 'body' => 'Pre-emergent when the soil nears 55°F, fescue seeding in the fall window, bermuda cutbacks before green-up. The schedule follows Greenville County\'s seasons, not a franchise manual.'],
];

/* ── FAQs — visible below AND mirrored in FAQPage schema ──────*/
$faqs = [
    [
        'question' => 'Does Greenville Lawn Masters serve all of Mauldin, SC?',
        'answer'   => 'Yes — Greenville Lawn Masters is based inside Mauldin (29662), so the whole city sits at the '
                    . 'center of its 25-mile service radius: the subdivisions off East and West Butler Road, the '
                    . 'streets around the Mauldin Cultural Center, and the newer construction near BridgeWay Station. '
                    . 'Homeowners searching for lawn care near me in Mauldin are usually a short drive from where the '
                    . 'crew starts its day.',
    ],
    [
        'question' => 'How fast can I get a lawn care estimate in Mauldin?',
        'answer'   => 'Greenville Lawn Masters walks Mauldin properties for free and returns a written, itemised '
                    . 'estimate within 24 hours. Because the crew is based in the city, walkthroughs are easy to '
                    . 'schedule — there is no waiting for a truck to be "in the area," because it already is.',
    ],
    [
        'question' => 'What grass do Mauldin lawns actually grow?',
        'answer'   => 'Both kinds — Mauldin sits in the transition zone. Bermuda and zoysia carry the full-sun front '
                    . 'yards, while tall fescue holds the shade under the mature oaks in older subdivisions like '
                    . 'Knollwood Heights and Forrester Woods. Greenville Lawn Masters mows, feeds, and seeds each on '
                    . 'its own calendar rather than treating every lawn as the same grass.',
    ],
    [
        'question' => 'Do you handle one-time projects in Mauldin, or only recurring mowing?',
        'answer'   => 'Both. Greenville Lawn Masters runs weekly and biweekly mowing routes through Mauldin and takes '
                    . 'on one-time work from the same 22-service list — mulch installation, sod, spring and fall '
                    . 'cleanups, pressure washing, gutter cleaning, and fence line clearing with debris hauled off '
                    . 'the property when the job ends.',
    ],
];

/* ── Schema ───────────────────────────────────────────────────
   The build prompt asked for "LocalBusiness with areaServed" here,
   but CLAUDE.md's enforcement layer forbids duplicating the
   LocalBusiness node off the homepage — every other page references
   its @id. So this page follows the committed sitewide pattern:
   a Service node (lawn care in Mauldin) whose provider is the
   homepage @id and whose areaServed is THIS city, which is the
   area-specific signal the prompt is after without the duplicate. */
$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        '@id'         => $canonicalUrl . '#service-area-' . $areaSlug,
        'name'        => 'Lawn Care in Mauldin, SC',
        'serviceType' => 'Lawn care and landscape maintenance',
        'description' => 'Recurring mowing, fertilization and weed control, aeration and overseeding, '
                       . 'seasonal cleanup, and landscape maintenance for homes and businesses in Mauldin, SC.',
        'provider'    => ['@id' => organizationId()],
        'url'         => $canonicalUrl,
        'areaServed'  => [
            '@type'             => 'City',
            'name'              => $area['city'],
            'containedInPlace'  => [
                '@type' => 'AdministrativeArea',
                'name'  => 'Greenville County, South Carolina',
            ],
        ],
    ],
    generateFAQSchema($faqs),
    generateBreadcrumbSchema([
        ['name' => 'Home',          'url' => '/'],
        ['name' => 'Service Areas', 'url' => '/service-areas/'],
        ['name' => 'Mauldin, SC',   'url' => '/service-areas/' . $areaSlug . '/'],
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
   Mauldin area page — page-scoped styles
   Every rule is prefixed .mld- so nothing collides with another
   page's <style> block. All values are var() tokens; the only hex
   lives in the hero's SVG noise data-URI (texture, not colour).

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + 62deg gradient ::before (angle unique
         to this page) + noise ::after
     C3  two distinct SVG dividers — a two-tone layered diagonal and
         an offset soft wave; neither repeats another page's pair
     C4  editorial drop-cap on the local-story lead paragraph
     C5  bento grid of growing conditions, uneven last span
     C6  asymmetric 1.25/0.75 local-story split with an overlapped
         image stack (C11 offset frame on the secondary photo)
     C7  SIGNATURE — the Mauldin ledger: dotted leader lines running
         from each property condition to the service that answers
         it, like a surveyor's index. Appears on no other page.
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────*/
.mld-hero {
  min-height: 74vh;
  min-height: 74svh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-lawn-mowing.jpg');
  background-size: cover;
  background-position: center 62%;
  isolation: isolate;
}
.mld-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(
    62deg,
    rgba(var(--color-dark-rgb), 0.94) 0%,
    rgba(var(--color-primary-dark-rgb), 0.8) 38%,
    rgba(var(--color-primary-rgb), 0.48) 70%,
    rgba(var(--color-accent-rgb), 0.24) 100%
  );
  z-index: 0;
}
.mld-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.27;
  z-index: 0;
  pointer-events: none;
}
.mld-hero__inner {
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 61rem;
  padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-16);
}
.mld-hero .breadcrumb {
  animation: mldFade 0.5s ease both;
}
.mld-hero__eyebrow {
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
  animation: mldFade 0.55s ease 0.08s both;
}
.mld-hero__eyebrow i,
.mld-hero__eyebrow svg {
  width: 15px;
  height: 15px;
}
.mld-hero h1 {
  color: var(--color-white);
  font-size: clamp(2.3rem, 4.8vw, 4rem);
  line-height: 1.06;
  letter-spacing: -0.03em;
  text-wrap: balance;
  margin-bottom: var(--space-5);
  animation: mldRise 0.6s ease 0.16s both;
}
.mld-hero h1 .text-accent {
  color: var(--color-accent);
}
.mld-hero .hero-answer {
  margin-inline: 0;
  max-width: 58ch;
  color: rgba(var(--color-white-rgb), 0.9);
  margin-bottom: var(--space-8);
  animation: mldRise 0.6s ease 0.26s both;
}
.mld-hero__actions {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-4);
  margin-bottom: var(--space-10);
  animation: mldRise 0.6s ease 0.36s both;
}
.mld-hero__trust {
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-3) var(--space-6);
  animation: mldRise 0.6s ease 0.46s both;
}
.mld-hero__trust span {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  color: rgba(var(--color-white-rgb), 0.86);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.mld-hero__trust i,
.mld-hero__trust svg {
  width: 17px;
  height: 17px;
  color: var(--color-accent);
  flex-shrink: 0;
}
/* Above-fold entrance is pure CSS — never reveal classes (opacity:0 risk). */
@keyframes mldFade {
  from { opacity: 0; }
  to   { opacity: 1; }
}
@keyframes mldRise {
  from { opacity: 0; transform: translateY(18px); }
  to   { opacity: 1; transform: none; }
}

/* ── C6 · The local story — asymmetric split + image stack ────*/
.mld-story {
  background: var(--color-white);
}
.mld-story__layout {
  display: grid;
  grid-template-columns: 1.25fr 0.75fr;
  gap: var(--space-16);
  align-items: center;
}
.mld-story h2 {
  text-wrap: balance;
  margin-bottom: var(--space-5);
}
.mld-story .answer-block {
  margin-inline: 0;
}
.mld-story__prose p {
  color: var(--color-gray-dark);
  line-height: 1.75;
  margin-bottom: var(--space-5);
  max-width: 64ch;
}
.mld-story__prose p:last-child {
  margin-bottom: 0;
}
/* C4 — editorial drop-cap on the first paragraph of the story */
.mld-story__prose p.mld-dropcap::first-letter {
  font-family: var(--font-heading);
  font-weight: 900;
  font-size: 3.2em;
  line-height: 0.8;
  float: left;
  padding-right: var(--space-3);
  padding-top: var(--space-1);
  color: var(--color-primary);
}
/* C11 — overlapped two-photo stack, offset accent frame on the lower one */
.mld-stack {
  position: relative;
  padding-bottom: var(--space-16);
  padding-right: var(--space-10);
}
.mld-stack figure {
  margin: 0;
}
.mld-stack__main img {
  width: 100%;
  aspect-ratio: 4 / 3;
  object-fit: cover;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg);
}
.mld-stack__floats {
  position: absolute;
  right: 0;
  bottom: 0;
  width: 58%;
}
.mld-stack__floats::before {
  content: '';
  position: absolute;
  inset: calc(-1 * var(--space-3));
  border: 1px solid rgba(var(--color-accent-rgb), 0.5);
  border-radius: var(--radius-lg);
  transform: translate(var(--space-2), var(--space-2));
  pointer-events: none;
}
.mld-stack__floats img {
  width: 100%;
  aspect-ratio: 5 / 4;
  object-fit: cover;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow-xl);
}
.mld-stack figcaption {
  margin-top: var(--space-3);
  font-size: var(--font-size-xs);
  color: var(--color-gray);
  line-height: 1.6;
}

/* ── C5 · Growing-conditions bento ────────────────────────────*/
.mld-conditions {
  background: var(--color-light);
}
.mld-conditions__grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-5);
  margin-top: var(--space-12);
}
.mld-condition {
  grid-column: span 1;
  display: flex;
  flex-direction: column;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.1);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.mld-condition:last-child {
  grid-column: span 1;
}
.mld-condition:first-child {
  grid-column: span 2;
}
.mld-condition:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-card);
}
.mld-condition__icon {
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
.mld-condition__icon i,
.mld-condition__icon svg {
  width: 22px;
  height: 22px;
}
.mld-condition h3 {
  font-size: var(--font-size-lg);
  text-wrap: balance;
  margin-bottom: var(--space-2);
  color: var(--color-primary-dark);
}
.mld-condition p {
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.65;
  margin: 0 0 var(--space-4);
}
.mld-condition a {
  margin-top: auto;
  font-size: var(--font-size-sm);
  font-weight: 700;
  color: var(--color-accent);
}
.mld-condition a::after {
  content: ' →';
  display: inline-block;
  transition: transform var(--transition-base);
}
.mld-condition a:hover::after {
  transform: translateX(3px);
}

/* ── C7 · SIGNATURE — the Mauldin ledger ──────────────────────
   A surveyor's index for the city: each row reads a real Mauldin
   property condition on the left, runs a dotted leader line across,
   and lands on the service that answers it. Built from tokens only;
   no other page in the build uses this device. */
.mld-ledger {
  background: var(--color-dark);
}
.mld-ledger .section-header h2 {
  color: var(--color-white);
}
.mld-ledger .answer-block {
  color: rgba(var(--color-white-rgb), 0.78);
}
.mld-ledger__sheet {
  max-width: 56rem;
  margin: var(--space-12) auto 0;
  padding: var(--space-8) var(--space-10);
  border-radius: var(--radius-xl);
  background: rgba(var(--color-white-rgb), 0.04);
  border: 1px solid rgba(var(--color-white-rgb), 0.1);
}
.mld-ledger__head {
  display: flex;
  justify-content: space-between;
  gap: var(--space-6);
  padding-bottom: var(--space-4);
  margin-bottom: var(--space-2);
  border-bottom: 1px solid rgba(var(--color-accent-rgb), 0.35);
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
}
.mld-ledger__head span:first-child {
  color: rgba(var(--color-white-rgb), 0.6);
}
.mld-ledger__head span:last-child {
  color: var(--color-accent);
}
.mld-ledger__rows {
  list-style: none;
  margin: 0;
  padding: 0;
}
.mld-ledger__row {
  display: flex;
  align-items: baseline;
  gap: var(--space-4);
  padding: var(--space-4) 0;
}
.mld-ledger__row + .mld-ledger__row {
  border-top: 1px solid rgba(var(--color-white-rgb), 0.06);
}
.mld-ledger__read {
  color: rgba(var(--color-white-rgb), 0.88);
  font-size: var(--font-size-sm);
  line-height: 1.5;
  flex-shrink: 1;
}
/* The dotted leader line — flexes to fill whatever space remains */
.mld-ledger__leader {
  flex: 1;
  min-width: var(--space-8);
  border-bottom: 2px dotted rgba(var(--color-accent-rgb), 0.45);
  transform: translateY(-4px);
}
.mld-ledger__answer {
  font-size: var(--font-size-sm);
  font-weight: 700;
  color: var(--color-accent);
  text-align: right;
  white-space: nowrap;
  transition: color var(--transition-base);
}
.mld-ledger__answer:hover {
  color: var(--color-white);
}
.mld-ledger__foot {
  margin: var(--space-6) auto 0;
  max-width: 56rem;
  text-align: center;
  font-size: var(--font-size-xs);
  color: rgba(var(--color-white-rgb), 0.55);
  line-height: 1.7;
}
.mld-ledger__foot a {
  color: var(--color-accent);
  font-weight: 600;
}

/* ── Services in Mauldin — full link grid ─────────────────────*/
.mld-services {
  background: var(--color-white);
}
.mld-services__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-4);
  margin-top: var(--space-12);
}
.mld-service-link {
  display: flex;
  align-items: center;
  gap: var(--space-4);
  padding: var(--space-4) var(--space-5);
  border-radius: var(--radius-lg);
  border: 1px solid rgba(var(--color-primary-rgb), 0.12);
  transition: transform var(--transition-base), box-shadow var(--transition-base), border-color var(--transition-base);
}
.mld-service-link:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-card);
  border-color: rgba(var(--color-accent-rgb), 0.5);
}
.mld-service-link__icon {
  width: 40px;
  height: 40px;
  flex-shrink: 0;
  display: grid;
  place-items: center;
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-primary);
  box-shadow: var(--shadow-sm);
}
.mld-service-link__icon i,
.mld-service-link__icon svg {
  width: 20px;
  height: 20px;
}
.mld-service-link strong {
  display: block;
  font-family: var(--font-heading);
  font-size: var(--font-size-base);
  color: var(--color-primary-dark);
  line-height: 1.25;
  text-wrap: balance;
}
.mld-service-link small {
  display: block;
  margin-top: 2px;
  font-size: var(--font-size-xs);
  color: var(--color-gray);
  line-height: 1.4;
}

/* ── Why the local crew ───────────────────────────────────────*/
.mld-why {
  background: var(--color-light);
}
.mld-why__grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
  max-width: 58rem;
  margin-inline: auto;
}
.mld-why__item {
  display: grid;
  grid-template-columns: 52px 1fr;
  gap: var(--space-4);
  align-items: start;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: var(--color-white);
  box-shadow: var(--shadow-sm);
}
.mld-why__item i,
.mld-why__item svg {
  width: 26px;
  height: 26px;
  color: var(--color-accent);
  margin-top: var(--space-1);
}
.mld-why__item strong {
  display: block;
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  color: var(--color-primary-dark);
  text-wrap: balance;
  margin-bottom: var(--space-2);
}
.mld-why__item p {
  margin: 0;
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.65;
}

/* ── FAQ ──────────────────────────────────────────────────────*/
.mld-faq {
  background: var(--color-white);
}
.mld-faq__list {
  max-width: 55rem;
  margin: var(--space-12) auto 0;
  display: grid;
  gap: var(--space-4);
}
.mld-faq__item {
  background: var(--color-light);
  border-radius: var(--radius-lg);
  padding: var(--space-6) var(--space-8);
  border-left: 3px solid var(--color-accent);
}
.mld-faq__item h3 {
  font-size: var(--font-size-lg);
  text-wrap: balance;
  color: var(--color-primary-dark);
  margin-bottom: var(--space-3);
}
.mld-faq__item .faq-answer {
  margin: 0;
  color: var(--color-gray-dark);
  font-size: var(--font-size-base);
  line-height: 1.75;
}

/* ── Final CTA ────────────────────────────────────────────────*/
.mld-cta {
  background: linear-gradient(150deg, var(--color-primary-dark) 0%, var(--color-primary) 100%);
  text-align: center;
}
.mld-cta::before {
  content: '';
  position: absolute;
  top: -30%;
  right: -5%;
  width: 440px;
  height: 440px;
  border-radius: var(--radius-full);
  background: rgba(var(--color-white-rgb), 0.05);
  pointer-events: none;
}
.mld-cta .container {
  position: relative;
  z-index: 1;
}
.mld-cta h2 {
  color: var(--color-white);
  text-wrap: balance;
  margin-bottom: var(--space-4);
}
.mld-cta .answer-block {
  color: rgba(var(--color-white-rgb), 0.9);
  margin-inline: auto;
  margin-bottom: var(--space-8);
}
.mld-cta__actions {
  display: flex;
  gap: var(--space-4);
  justify-content: center;
  flex-wrap: wrap;
}

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .mld-story__layout {
    grid-template-columns: 1fr;
    gap: var(--space-12);
  }
  .mld-stack {
    max-width: 34rem;
  }
  .mld-conditions__grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .mld-condition:first-child {
    grid-column: span 2;
  }
  .mld-services__grid {
    grid-template-columns: repeat(2, 1fr);
  }
  .mld-why__grid {
    grid-template-columns: 1fr;
  }
}
@media (max-width: 700px) {
  .mld-hero {
    min-height: 0;
  }
  .mld-hero__actions .btn {
    width: 100%;
    justify-content: center;
  }
  .mld-conditions__grid {
    grid-template-columns: 1fr;
  }
  .mld-condition:first-child {
    grid-column: span 1;
  }
  .mld-services__grid {
    grid-template-columns: 1fr;
  }
  .mld-ledger__sheet {
    padding: var(--space-5) var(--space-5);
  }
  /* Ledger rows stack: condition above, answer below-right, leader hidden */
  .mld-ledger__row {
    flex-direction: column;
    align-items: flex-start;
    gap: var(--space-2);
  }
  .mld-ledger__leader {
    display: none;
  }
  .mld-ledger__answer {
    white-space: normal;
    text-align: left;
  }
  .mld-stack {
    padding-right: var(--space-6);
  }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero mld-hero" aria-label="Lawn care in Mauldin, South Carolina">
    <div class="container">
        <div class="mld-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><a href="/service-areas/">Service Areas</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Mauldin, SC</span></li>
                </ol>
            </nav>

            <span class="mld-hero__eyebrow">
                <i data-lucide="map-pin" aria-hidden="true"></i>
                Home Base &middot; Zip <?php echo e($area['zip']); ?>, Greenville County
            </span>

            <h1>Lawn Care in <span class="text-accent">Mauldin</span>, South Carolina</h1>

            <p class="hero-answer">
                Greenville Lawn Masters is a lawn care and landscape maintenance company based in
                Mauldin, SC — the crew's own city, at the center of its
                <?php echo e((string) $targetRadius); ?>-mile Greenville County service radius.
                Mowing, fertilization, aeration, cleanups, and 22 services in all, with a free
                walkthrough and a written estimate within 24 hours.
            </p>

            <div class="mld-hero__actions">
                <a href="/contact/" class="btn btn-accent btn-lg">
                    <i data-lucide="clipboard-list" aria-hidden="true"></i>
                    Get a Free Estimate in Mauldin
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <?php /* $phone is empty in config.php — no call button without a real number. */ ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        See All Services
                    </a>
                <?php endif; ?>
            </div>

            <?php /* Only intake-recorded claims — no license, rating, or job counts exist to cite. */ ?>
            <div class="mld-hero__trust">
                <span><i data-lucide="home" aria-hidden="true"></i> Locally based since <?php echo e((string) $yearEstablished); ?></span>
                <span><i data-lucide="clock" aria-hidden="true"></i> Written estimate within 24 hours</span>
                <span><i data-lucide="truck" aria-hidden="true"></i> Debris hauled off the property</span>
            </div>
        </div>
    </div>

    <!-- Divider — two-tone layered diagonal into the white story section -->
    <div class="svg-divider" style="height:72px" aria-hidden="true">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
            <path d="M0,80 L1200,22 L1200,80 Z" fill="var(--color-white)" opacity="0.4"/>
            <path d="M0,80 L1200,44 L1200,80 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · THE LOCAL STORY ══════════ -->
<section class="mld-story" aria-label="What makes Mauldin lawns different">
    <div class="container">
        <div class="mld-story__layout">

            <div class="mld-story__prose">
                <h2 class="reveal-left">What makes a <span class="text-accent">Mauldin</span> lawn different?</h2>
                <p class="answer-block reveal-left reveal-delay-1">
                    Mauldin lawns grow on red Cecil clay in the middle of the turf transition zone —
                    bermuda and zoysia in the sun, tall fescue under the older subdivisions' oak
                    canopy — with roughly 50 inches of rain a year feeding both the grass and the
                    fungus. Caring for them means working two grasses on two calendars, on soil that
                    compacts hard and runs acidic.
                </p>
                <p class="mld-dropcap reveal-left reveal-delay-2">
                    Mauldin anchors the Golden Strip — the run of I-385 it shares with Simpsonville
                    and Fountain Inn — and the city has two distinct generations of yard. Along East
                    and West Butler Road, subdivisions like Knollwood Heights and Forrester Woods went
                    in through the 1970s, '80s, and '90s, and their trees have had decades to close
                    the canopy: established fescue lawns, big fall leaf drops, and beds that have been
                    re-mulched thirty times. Around BridgeWay Station on the interstate side, newer
                    construction is still settling — builder-grade sod over graded clay that usually
                    needs aeration, soil correction, and patience before it looks like the older
                    streets.
                </p>
                <p class="reveal-left reveal-delay-3">
                    The city between those two edges is where the crew spends its days: the streets
                    around the Mauldin Cultural Center and its amphitheater on East Butler Road, the
                    neighborhoods backing up to Sunset Park, and the west side running toward Lake
                    Conestee Nature Preserve on the Reedy River. It is a compact city — one zip code,
                    <?php echo e($area['zip']); ?> — which is exactly why a crew based inside it can
                    hold a schedule that companies routing trucks down I-385 cannot.
                </p>
                <p class="reveal-left reveal-delay-4">
                    None of that is marketing texture; it is the working context for every estimate.
                    Clay that sheds water changes how often a lawn actually needs irrigation and
                    aeration. A canopy street needs a fescue program and a real leaf plan. A new
                    build near the interstate needs soil work before it needs anything else. The
                    walkthrough reads the yard first — then the estimate gets written.
                </p>
            </div>

            <div class="mld-stack reveal-right">
                <figure class="mld-stack__main">
                    <?php $storyMain = photo('backyard'); ?>
                    <img src="<?php echo e($storyMain['src']); ?>"
                         alt="<?php echo e($storyMain['alt']); ?>"
                         width="<?php echo e((string) $storyMain['w']); ?>"
                         height="<?php echo e((string) $storyMain['h']); ?>"
                         loading="lazy" decoding="async">
                </figure>
                <figure class="mld-stack__floats">
                    <?php $storyFloat = photo('mulch_bed'); ?>
                    <img src="<?php echo e($storyFloat['src']); ?>"
                         alt="<?php echo e($storyFloat['alt']); ?>"
                         width="<?php echo e((string) $storyFloat['w']); ?>"
                         height="<?php echo e((string) $storyFloat['h']); ?>"
                         loading="lazy" decoding="async">
                    <figcaption>Real Mauldin properties the crew maintains — not stock photography.</figcaption>
                </figure>
            </div>
        </div>
    </div>

    <!-- Divider — offset soft wave into the light conditions section -->
    <div class="svg-divider" style="height:70px" aria-hidden="true">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
            <path d="M0,52 C240,14 520,74 760,40 C940,16 1080,44 1200,30 L1200,80 L0,80 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 3 · GROWING CONDITIONS ══════════ -->
<section class="mld-conditions" aria-label="Growing conditions in Mauldin, South Carolina">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">On the Ground</span>
            <h2>What is <span class="text-accent">Mauldin grass</span> actually growing in?</h2>
            <p class="answer-block">
                Four conditions decide most of what a lawn here needs: red Cecil clay that
                compacts and runs acidic, a mature oak canopy over the older subdivisions, a
                transition-zone climate that splits yards between warm- and cool-season grasses,
                and hot, wet summers that favor fungus and grubs. Each points at a specific service
                — not a generic program.
            </p>
            <span class="section-subtitle"><?php echo e($tagline); ?></span>
        </div>

        <div class="mld-conditions__grid" data-p1-dynamic>
            <?php foreach ($conditions as $i => $condition): ?>
                <?php
                $tint = ['card-tint-1', 'card-tint-2', 'card-tint-3', 'card-tint-neutral'][$i % 4];
                $dir  = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-up'][$i % 4];
                ?>
                <article class="mld-condition <?php echo $tint; ?> <?php echo $dir; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <div class="mld-condition__icon"><i data-lucide="<?php echo e($condition['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($condition['title']); ?></h3>
                    <p><?php echo e($condition['body']); ?></p>
                    <a href="<?php echo e($condition['href']); ?>"><?php echo e($condition['link']); ?></a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Divider — two-tone layered diagonal (mirrored) into the dark ledger -->
    <div class="svg-divider" style="height:64px" aria-hidden="true">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
            <path d="M0,26 L1200,80 L0,80 Z" fill="var(--color-dark)" opacity="0.45"/>
            <path d="M0,48 L1200,80 L0,80 Z" fill="var(--color-dark)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · SIGNATURE — THE MAULDIN LEDGER ══════════ -->
<section class="mld-ledger" aria-label="Common Mauldin property conditions and the services that answer them">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Walkthrough</span>
            <h2>What does the crew look for on a <span class="text-accent">Mauldin walkthrough</span>?</h2>
            <p class="answer-block">
                Every estimate starts by reading the property on foot. These are the conditions that
                show up again and again across the city — and the service each one actually calls for.
                The walkthrough is free; the estimate is written and itemised within 24 hours.
            </p>
        </div>

        <div class="mld-ledger__sheet reveal-scale">
            <div class="mld-ledger__head">
                <span>What the yard shows</span>
                <span>What answers it</span>
            </div>
            <ul class="mld-ledger__rows" data-p1-dynamic>
                <?php foreach ($ledger as $row): ?>
                    <li class="mld-ledger__row">
                        <span class="mld-ledger__read"><?php echo e($row['read']); ?></span>
                        <span class="mld-ledger__leader" aria-hidden="true"></span>
                        <a class="mld-ledger__answer" href="<?php echo e($row['href']); ?>"><?php echo e($row['answer']); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mld-ledger__foot reveal-up">
            <p>
                Eight reads, not a fixed menu — the estimate covers what your yard shows, nothing
                more. All 22 services are on the <a href="/services/">services page</a>.
            </p>
        </div>
    </div>

    <!-- Divider — offset soft wave (flipped) into the white services grid -->
    <div class="svg-divider" style="height:70px" aria-hidden="true">
        <svg viewBox="0 0 1200 80" preserveAspectRatio="none">
            <path d="M0,36 C200,66 480,10 720,46 C920,74 1100,34 1200,52 L1200,80 L0,80 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 5 · SERVICES AVAILABLE IN MAULDIN ══════════ -->
<section class="mld-services" aria-label="Lawn and landscape services available in Mauldin">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">What We Do</span>
            <h2>Which services does <span class="text-accent">Greenville Lawn Masters</span> offer in Mauldin?</h2>
            <p class="answer-block">
                All of them — Mauldin is home base, so every one of the 22 services rides on the
                truck: recurring mowing and lawn health programs, tree and shrub work, and one-time
                projects from mulch and sod to pressure washing and gutter cleaning. Each page below
                covers scope, process, and timing.
            </p>
        </div>

        <div class="mld-services__grid" data-p1-dynamic>
            <?php foreach ($servicePages as $servicePage): ?>
                <?php $meta = serviceCardMeta($servicePage['slug']); ?>
                <a class="mld-service-link reveal-up" href="/services/<?php echo e($servicePage['slug']); ?>/">
                    <span class="mld-service-link__icon"><i data-lucide="<?php echo e($meta['icon']); ?>" aria-hidden="true"></i></span>
                    <span>
                        <strong><?php echo e($servicePage['title']); ?></strong>
                        <small><?php echo e($meta['desc']); ?></small>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 6 · WHY THE LOCAL CREW ══════════ -->
<section class="mld-why" aria-label="Why Mauldin homeowners choose Greenville Lawn Masters">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">The Difference</span>
            <h2>Why hire a crew <span class="text-accent">based in Mauldin</span> instead of one passing through?</h2>
            <p class="answer-block">
                Because the service radius is drawn around your street. A crew that starts its day in
                29662 holds its local schedule through rain weeks, walks properties instead of quoting
                satellites, and answers to neighbors — the same four commitments, every job.
            </p>
        </div>

        <div class="mld-why__grid" data-p1-dynamic>
            <?php foreach ($whyUs as $i => $why): ?>
                <div class="mld-why__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?> reveal-delay-<?php echo ($i % 4) + 1; ?>">
                    <i data-lucide="<?php echo e($why['icon']); ?>" aria-hidden="true"></i>
                    <div>
                        <strong><?php echo e($why['title']); ?></strong>
                        <p><?php echo e($why['body']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 7 · FAQ ══════════ -->
<section class="mld-faq" aria-label="Lawn care questions from Mauldin homeowners">
    <div class="container">
        <div class="section-header reveal-up">
            <span class="eyebrow-label">Before You Book</span>
            <h2>What do <span class="text-accent">Mauldin homeowners</span> ask first?</h2>
            <p class="answer-block">
                Straight answers on coverage across the city, how fast an estimate arrives, which
                grasses actually grow here, and whether one-time projects get the same treatment as
                the weekly mowing routes.
            </p>
        </div>

        <div class="mld-faq__list" data-p1-dynamic>
            <?php foreach ($faqs as $i => $faq): ?>
                <article class="mld-faq__item <?php echo ($i % 2 === 0) ? 'reveal-left' : 'reveal-right'; ?>">
                    <h3><?php echo e($faq['question']); ?></h3>
                    <p class="faq-answer"><?php echo e($faq['answer']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ══════════ 8 · FINAL CTA ══════════ -->
<section class="mld-cta" aria-label="Request a free lawn care estimate in Mauldin">
    <div class="container">
        <h2 class="reveal-up">Get a free estimate in Mauldin — walked, written, within 24 hours.</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            Greenville Lawn Masters walks your property for free, reads the clay, the canopy,
            and the grass it actually grows, and puts an itemised estimate in writing within 24 hours.
            The crew is already in the city — your street is on the way home.
        </p>
        <div class="mld-cta__actions reveal-up reveal-delay-2">
            <a href="/contact/" class="btn btn-accent btn-lg">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Get a Free Estimate in Mauldin
            </a>
            <?php if ($hasPhone): ?>
                <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                    <i data-lucide="phone" aria-hidden="true"></i>
                    Call <?php echo e($phoneDisplay); ?>
                </a>
            <?php else: ?>
                <a href="/service-areas/" class="btn btn-outline-white btn-lg">
                    <i data-lucide="map" aria-hidden="true"></i>
                    See the Full Service Area
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
