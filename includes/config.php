<?php
/* ============================================================
   includes/config.php
   Greenville Lawn Masters — site-wide configuration
   Source of truth: build-plan.json (Phase 1 scaffold)

   Every page includes this FIRST, then sets its own $canonicalUrl
   before including head.php. $canonicalUrl is never set here.
   ============================================================ */

/* ── Identity ─────────────────────────────────────────────── */

// Must equal this build's directory name and site_build_intakes.client_slug.
$slug = 'greenville-lawn-masters';

// build-plan.json `company_name` was the slug itself, not a display name.
// Derived from the slug + tagline. VERIFY WITH CLIENT BEFORE LAUNCH.
$siteName = 'Greenville Lawn Masters';
$tagline  = "Greenville's Lawn Perfected";

$tier     = 'premium';
$industry = 'lawn_care';

/* ── Domain / URLs ────────────────────────────────────────── */

// build-plan.json has no `production_domain` field. Its `domain` key holds
// the slug ("greenville-lawn-masters"), not a hostname. Falling back to the
// preview host per the Phase 1 domain rule. Swap to the launch domain as soon
// as it is confirmed — and update robots.txt Sitemap:, llms.txt, and any
// hardcoded absolute URLs at the same time (seo-aeo-2026.md).
$domain  = $slug . '.pageone.cloud';
$siteUrl = 'https://' . $domain;

/* ── Contact / NAP ────────────────────────────────────────── */
// INTAKE GAPS — all four were empty in build-plan.json. Left empty rather
// than fabricated: a wrong phone number or address on a live local-business
// site is worse than a visibly missing one, and LocalBusiness schema
// (Phase 3) needs the real values. Must be filled before Phase 2 ships nav
// or footer, which render the phone in the sticky CTA bar and entity block.

$phone          = '';   // REQUIRED — click-to-call, sticky bar, schema, footer NAP
$phoneSecondary = '';
$email          = '';   // REQUIRED — footer entity block, consent copy

$address = [
    'street' => '',        // REQUIRED for LocalBusiness schema streetAddress
    'city'   => 'Mauldin',
    'state'  => 'SC',
    'zip'    => '29662',
];

$yearEstablished = 2024;   // build-plan content.years = 2, as of 2026
$yearsInBusiness = 2;

/* ── Hours / geo / Google Business Profile ────────────────── */
// INTAKE GAPS. Phase 2's LocalBusiness schema emits openingHoursSpecification,
// geo, and hasMap ONLY when these are populated (seo-aeo-2026.md marks geo +
// hasMap required). Absent keys are omitted from the JSON-LD rather than
// guessed — invented coordinates or hours are worse than missing ones.
//
// $businessHours: 'Mo'|'Tu'|'We'|'Th'|'Fr'|'Sa'|'Su' => ['08:00','17:00'].
// $geo: ['lat' => float, 'lng' => float]. Extract from the GBP map embed URL —
//       !3d is LATITUDE, !2d is LONGITUDE (seo-aeo-2026.md line 178).
$businessHours = [];     // REQUIRED — schema openingHoursSpecification, footer hours column
$geo           = null;   // REQUIRED — schema geo
$gbpUrl        = '';     // REQUIRED — schema hasMap (GBP Share → Copy link)
$gbpPlaceId    = '';     // REQUIRED — review link + directions link (ChIJ...)

/* ── Legal entity ─────────────────────────────────────────── */
// Phase 5 (compliance pages) needs these. CLAUDE.md lists both under "Required
// Intake Questions"; build-plan.json supplied NEITHER.
//
// $companyEntityType stays EMPTY rather than guessed. "Greenville Lawn Masters,
// LLC" printed on a Terms of Service page is a representation about corporate
// form — if the business is actually a sole proprietorship, that statement is
// false in the one document where falsity is most expensive. The legal pages
// render $legalEntityName, which degrades to the plain trading name until the
// real entity type lands here.
$companyEntityType = '';   // REQUIRED — 'LLC' | 'Inc.' | 'Corporation' | 'Sole Proprietorship'…

// State/county of OPERATION, taken from the business address — not a claim about
// where the entity was formed. The Terms governing-law clause is written against
// these because South Carolina is verifiably where the work is performed and
// where a dispute over that work would be heard. If the entity was formed in
// another state, the governing-law clause must be revisited with counsel.
$companyState     = 'South Carolina';
$companyStateAbbr = 'SC';
$companyCounty    = 'Greenville';

// Trading name + entity suffix, once known. Used verbatim in legal prose.
$legalEntityName = $siteName . ($companyEntityType !== '' ? ', ' . $companyEntityType : '');

/* ── Intake gap guard ─────────────────────────────────────── */
// Anything listed here renders as *absent*, never as a placeholder: no fake
// phone in the sticky CTA bar, no fake street in the footer NAP, no fake
// telephone in LocalBusiness schema. head.php renders a loud banner while this
// array is non-empty so the gap cannot survive CM's browser-review gate. The
// banner disappears on its own the moment the values land in this file.
$missingIntake = [];
if ($phone === '')             { $missingIntake[] = 'phone'; }
if ($email === '')             { $missingIntake[] = 'email'; }
if ($address['street'] === '') { $missingIntake[] = 'address.street'; }
if (empty($businessHours))     { $missingIntake[] = 'businessHours'; }
if ($geo === null)             { $missingIntake[] = 'geo (lat/lng)'; }
if ($gbpUrl === '')            { $missingIntake[] = 'googleBusinessProfileUrl'; }
if ($companyEntityType === '') { $missingIntake[] = 'companyEntityType'; }

/* ── Lead form ────────────────────────────────────────────── */

// RESOLVED IN PHASE 3 (was flagged unresolved in Phase 2).
// build-plan.json `form_action` said https://design.pageone.cloud/api/leads/{slug}.
// CLAUDE.md, SKILL.md, and the Phase 3 build prompt all independently mandate
// https://db.pageone.cloud/functions/v1/leads/{slug}. CLAUDE.md is the
// enforcement layer and wins over a data field. Both hosts answer (GET → 405
// "method not allowed", i.e. the route exists and wants POST), so the probe
// could not break the tie on its own; the documented contract did.
//
// STILL VERIFY WITH A LIVE TEST SUBMISSION BEFORE LAUNCH. If leads land in the
// Portal, this is right. If they don't, the other host is the live one.
$formAction = 'https://db.pageone.cloud/functions/v1/leads/' . $slug;

// Hidden field `_consent_version` on every form (CLAUDE.md TCPA section).
$consentVersion = 'v2.1';

/* ── Analytics ────────────────────────────────────────────── */

$googleAnalyticsId = 'G-XXXXXXXXXX';   // placeholder — swap post-launch

/* ── Brand ────────────────────────────────────────────────── */
// Logo analysis run in Phase 2 because it was never run in Phase 0 and
// build-plan.json shipped design.colors with extracted_from_logo = false —
// generic portal defaults (navy #1a2b3c / slate #4d5e6f / cyan #06b6d4), with
// no green anywhere, on a brand whose logo is green. CLAUDE.md: "Phase 0 logo
// analysis drives ALL color and nav decisions — never guess colors."
//
// Source: the logo PNG, 313x200 (1.57:1 → combination mark → 50-60px nav logo).
// Colors measured, not guessed (`convert logo.png -colors 8 histogram:info:-`):
//   #2C6F2F  forest green  — script "Greenville" + badge ring   (8,278 px)
//   #020202  near-black    — "LAWN MASTERS" wordmark           (44,143 px)
//   #3D4543  dark slate    — the dog's apron                    (1,341 px)
//
// `accent` is a lighter tint of the measured brand green, NOT an invented hue:
// the logo contains no third color. If the brand wants a warm complement
// (amber/clay) for CTAs, that is a design call for CM, not an assumption here.
//
// Contrast verified against WCAG 2.1 AA:
//   white on primary          6.14:1   nav links, footer text
//   primary on white          6.14:1   body links
//   primary-dark on white     9.30:1   nav CTA button label
//   accent on dark            5.19:1   footer credit link
$colors = [
    'primary'      => '#2C6F2F',
    'primary_dark' => '#1F5122',
    'secondary'    => '#3D4543',
    'accent'       => '#4E9C52',
    'dark'         => '#161A17',   // footer / dark sections (near-black, green cast)
];

// design-aesthetics-2026.md §A3.3 has no Premium row for landscaping — only
// "Landscaping / tree service | Standard | Bricolage Grotesque | Figtree".
// Interpolated: Fraunces is the §A3.3 Premium-tier heading default and its soft
// serif echoes the logo's script wordmark; Figtree stays as the industry body
// pick. Two families total (CLAUDE.md: "No more than 2 fonts"). Both variable.
// FLAG FOR CM: this is a judgment call, not a table lookup.
$fonts = [
    'heading' => 'Fraunces',
    'body'    => 'Figtree',
];

$designStyle = 'elegant';   // build-plan design.style; archetype not yet assigned
$cssVersion  = 5;           // bumped: Phase 5 added legal-page + contact-form shared components

$logoUrl = 'https://db.pageone.cloud/storage/v1/object/public/client-assets/'
         . 'greenville-lawn-masters/logo/1783619426197-14ls2z-qt_q_95.png';

/* ── SEO ──────────────────────────────────────────────────── */

$primaryKeyword = 'lawn care mauldin sc';

$secondaryKeywords = [
    'lawn mowing mauldin sc',
    'lawn care near me mauldin sc',
    'landscaping mauldin sc',
    'lawn fertilization mauldin sc',
    'weed control mauldin sc',
    'lawn aeration mauldin sc',
    'grass seeding mauldin sc',
    'tree trimming mauldin sc',
    'pressure washing mauldin sc',
    'lawn cleanup mauldin sc',
    'lawn care greenville sc',
    'residential lawn care mauldin sc',
];

/* ── Services ─────────────────────────────────────────────── */
// All 22 services from build-plan.json. `page` is the service page each one
// lives on, per build-plan.json service_grouping (22 services → 11 pages).
// Solo services own their page; grouped services are sections within one.

$services = [
    [
        'name'        => 'Lawn Mowing',
        'slug'        => 'lawn-mowing',
        'page'        => 'lawn-care-services',
        'description' => 'Professional lawn mowing services in Mauldin, SC for weekly, biweekly, or one-time maintenance. Keep your lawn healthy and neatly trimmed year-round.',
        'keywords'    => ['lawn mowing Mauldin SC', 'professional lawn care Mauldin', 'weekly lawn service', 'yard maintenance Greenville area'],
    ],
    [
        'name'        => 'Fertilization & Weed Control',
        'slug'        => 'fertilization-weed-control',
        'page'        => 'lawn-care-services',
        'description' => 'Comprehensive lawn health services including fertilization, weed control, and crabgrass prevention. Professional treatments keep your Mauldin lawn green and vibrant.',
        'keywords'    => ['lawn fertilization Mauldin SC', 'weed control service', 'crabgrass prevention Greenville', 'lawn treatment South Carolina'],
    ],
    [
        'name'        => 'Grub Control & Lawn Disease Treatment',
        'slug'        => 'grub-control-lawn-disease-treatment',
        'page'        => 'lawn-care-services',
        'description' => 'Specialized grub and disease treatments protect your lawn from damaging pests and infections. Professional-grade solutions for healthy grass.',
        'keywords'    => ['grub control Mauldin SC', 'lawn disease treatment', 'pest control Greenville', 'lawn health services'],
    ],
    [
        'name'        => 'Aeration & Overseeding',
        'slug'        => 'aeration-overseeding',
        'page'        => 'lawn-care-services',
        'description' => 'Lawn aeration and overseeding improve soil penetration and fill bare spots with healthy grass. Revitalize thin or struggling lawns.',
        'keywords'    => ['lawn aeration Mauldin SC', 'overseeding service Greenville', 'lawn renovation', 'aeration South Carolina'],
    ],
    [
        'name'        => 'Winter Lawn Preparation',
        'slug'        => 'winter-lawn-preparation',
        'page'        => 'lawn-care-services',
        'description' => 'Prepare your Mauldin lawn for winter with professional seasonal treatments. Ensure grass survives cold months and thrives in spring.',
        'keywords'    => ['winter lawn prep Mauldin SC', 'seasonal maintenance service', 'winter landscaping Greenville', 'lawn care South Carolina'],
    ],
    [
        'name'        => 'Grass Seeding & Overseeding',
        'slug'        => 'grass-seeding-overseeding',
        'page'        => 'lawn-care-services',
        'description' => 'Expert grass seeding for bare spots, patchy areas, and complete lawn installation. Professional seeding ensures healthy, uniform grass growth.',
        'keywords'    => ['grass seed Mauldin SC', 'seeding service Greenville', 'lawn seeding', 'grass installation South Carolina'],
    ],
    [
        'name'        => 'Lawn Repair & Leveling',
        'slug'        => 'lawn-repair-leveling',
        'page'        => 'lawn-care-services',
        'description' => 'Professional patch repair, bare spot solutions, and topdressing for damaged lawn areas. Expert leveling for seamless results.',
        'keywords'    => ['lawn repair Mauldin SC', 'patch repair service Greenville', 'bare spot repair', 'lawn restoration South Carolina'],
    ],
    [
        'name'        => 'Commercial Lawn Care',
        'slug'        => 'commercial-lawn-care',
        'page'        => 'lawn-care-services',
        'description' => 'Professional lawn maintenance for businesses, HOAs, apartments, and municipal properties. Reliable scheduled service for professional grounds.',
        'keywords'    => ['commercial lawn care Mauldin SC', 'HOA landscaping Greenville', 'business grounds maintenance', 'facility lawn service'],
    ],

    [
        'name'        => 'Edging & String Trimming',
        'slug'        => 'edging-string-trimming',
        'page'        => 'tree-shrub-services',
        'description' => 'Expert edging and weed eating services that keep your lawn lines crisp and clean. Includes debris blowing from sidewalks, driveways, and patios.',
        'keywords'    => ['lawn edging Mauldin SC', 'string trimming service', 'weed eating Greenville', 'lawn trimming South Carolina'],
    ],
    [
        'name'        => 'Leaf Removal & Storm Debris Cleanup',
        'slug'        => 'leaf-removal-storm-debris-cleanup',
        'page'        => 'tree-shrub-services',
        'description' => 'Professional leaf removal and storm debris cleanup for Mauldin properties. Keep your yard clean and safe after weather events.',
        'keywords'    => ['leaf removal Mauldin SC', 'debris cleanup service', 'storm cleanup Greenville', 'yard cleanup South Carolina'],
    ],
    [
        'name'        => 'Hedge & Shrub Trimming',
        'slug'        => 'hedge-shrub-trimming',
        'page'        => 'tree-shrub-services',
        'description' => 'Expert hedge and shrub trimming maintains neat, healthy landscaping. Professional pruning keeps your Mauldin property looking manicured.',
        'keywords'    => ['hedge trimming Mauldin SC', 'shrub trimming Greenville', 'pruning service', 'landscape maintenance South Carolina'],
    ],
    [
        'name'        => 'Tree Trimming & Brush Removal',
        'slug'        => 'tree-trimming-brush-removal',
        'page'        => 'tree-shrub-services',
        'description' => 'Small tree trimming and brush removal services for residential landscapes. Keep your Mauldin property clear and professionally maintained.',
        'keywords'    => ['tree trimming Mauldin SC', 'brush removal service Greenville', 'tree pruning', 'landscaping cleanup South Carolina'],
    ],
    [
        'name'        => 'Pet Waste Removal',
        'slug'        => 'pet-waste-removal',
        'page'        => 'tree-shrub-services',
        'description' => 'Regular pet waste removal service keeps your Mauldin yard clean and hygienic. Convenient add-on for busy pet owners.',
        'keywords'    => ['pet waste removal Mauldin SC', 'pet cleanup service Greenville', 'yard sanitation', 'pet care services'],
    ],

    [
        'name'        => 'Spring & Fall Cleanup',
        'slug'        => 'spring-fall-cleanup',
        'page'        => 'spring-fall-cleanup',
        'description' => 'Seasonal cleanup services including spring preparation and fall leaf removal. Comprehensive yard maintenance throughout the year in Mauldin.',
        'keywords'    => ['spring cleanup Mauldin SC', 'fall cleanup service', 'seasonal yard maintenance', 'property care Greenville SC'],
    ],
    [
        'name'        => 'Mulch Installation',
        'slug'        => 'mulch-installation',
        'page'        => 'mulch-installation',
        'description' => 'Professional mulch installation for flower beds and landscaping areas. Enhance curb appeal while protecting plant health.',
        'keywords'    => ['mulch installation Mauldin SC', 'landscape mulch service Greenville', 'flower bed mulch', 'landscaping South Carolina'],
    ],
    [
        'name'        => 'Flower Bed & Shrub Planting',
        'slug'        => 'flower-bed-shrub-planting',
        'page'        => 'flower-bed-shrub-planting',
        'description' => 'Complete flower bed cleanup, planting, and maintenance for flowers, shrubs, and small trees. Professional landscaping to enhance property beauty.',
        'keywords'    => ['flower planting Mauldin SC', 'shrub planting Greenville', 'landscaping service', 'garden maintenance South Carolina'],
    ],
    [
        'name'        => 'Sod Installation',
        'slug'        => 'sod-installation',
        'page'        => 'sod-installation',
        'description' => 'Professional sod installation for instant green lawns in Mauldin, SC. Perfect for new properties or complete lawn renovation projects.',
        'keywords'    => ['sod installation Mauldin SC', 'new lawn installation Greenville', 'sod service', 'grass installation South Carolina'],
    ],
    [
        'name'        => 'Pressure Washing',
        'slug'        => 'pressure-washing',
        'page'        => 'pressure-washing',
        'description' => 'Professional pressure washing for driveways, sidewalks, and property surfaces in Mauldin. Remove dirt and stains safely and effectively.',
        'keywords'    => ['pressure washing Mauldin SC', 'driveway cleaning Greenville', 'power washing service', 'property cleaning South Carolina'],
    ],
    [
        'name'        => 'Gutter Cleaning',
        'slug'        => 'gutter-cleaning',
        'page'        => 'gutter-cleaning',
        'description' => 'Professional gutter cleaning maintains proper water drainage around your Mauldin home. Preventative maintenance for property protection.',
        'keywords'    => ['gutter cleaning Mauldin SC', 'gutter service Greenville', 'home maintenance', 'property care South Carolina'],
    ],
    [
        'name'        => 'Fence Line Clearing & Debris Hauling',
        'slug'        => 'fence-line-clearing-debris-hauling',
        'page'        => 'fence-line-clearing-debris-hauling',
        'description' => 'Clear fence lines and remove yard debris with professional hauling services. Keep your Mauldin property clean and well-maintained.',
        'keywords'    => ['debris hauling Mauldin SC', 'fence clearing Greenville', 'yard cleanup service', 'property maintenance South Carolina'],
    ],
    [
        'name'        => 'Soil Testing & Lime Application',
        'slug'        => 'soil-testing-lime-application',
        'page'        => 'soil-testing-lime-application',
        'description' => "Professional soil testing determines your lawn's needs, followed by targeted lime application and nutrient treatments. Optimize soil for lush growth.",
        'keywords'    => ['soil testing Mauldin SC', 'lime application service', 'soil amendment Greenville', 'lawn chemistry South Carolina'],
    ],
    [
        'name'        => 'Dethatching',
        'slug'        => 'dethatching',
        'page'        => 'dethatching',
        'description' => 'Professional thatch removal improves water and nutrient absorption in your lawn. Keep your Mauldin grass healthier and more resilient.',
        'keywords'    => ['dethatching Mauldin SC', 'thatch removal service', 'lawn care Greenville', 'dethatching South Carolina'],
    ],
];

/* ── Service pages ────────────────────────────────────────── */
// The 11 pages Phase 4 builds under /services/{slug}/index.php.
// Nav, sitemap.php, and Related Services cards read from this — never
// hardcode a service-page list anywhere else.

$servicePages = [
    ['slug' => 'lawn-care-services',                 'title' => 'Lawn Care Services',                 'type' => 'service_group', 'primary_keyword' => 'grub control & lawn disease treatment Mauldin SC'],
    ['slug' => 'tree-shrub-services',                'title' => 'Tree & Shrub Services',              'type' => 'service_group', 'primary_keyword' => 'leaf removal & storm debris cleanup Mauldin SC'],
    ['slug' => 'spring-fall-cleanup',                'title' => 'Spring & Fall Cleanup',              'type' => 'service',       'primary_keyword' => 'spring & fall cleanup Mauldin SC'],
    ['slug' => 'mulch-installation',                 'title' => 'Mulch Installation',                 'type' => 'service',       'primary_keyword' => 'mulch installation Mauldin SC'],
    ['slug' => 'flower-bed-shrub-planting',          'title' => 'Flower Bed & Shrub Planting',        'type' => 'service',       'primary_keyword' => 'flower bed & shrub planting Mauldin SC'],
    ['slug' => 'sod-installation',                   'title' => 'Sod Installation',                   'type' => 'service',       'primary_keyword' => 'sod installation Mauldin SC'],
    ['slug' => 'pressure-washing',                   'title' => 'Pressure Washing',                   'type' => 'service',       'primary_keyword' => 'pressure washing Mauldin SC'],
    ['slug' => 'gutter-cleaning',                    'title' => 'Gutter Cleaning',                    'type' => 'service',       'primary_keyword' => 'gutter cleaning Mauldin SC'],
    ['slug' => 'fence-line-clearing-debris-hauling', 'title' => 'Fence Line Clearing & Debris Hauling','type' => 'service',      'primary_keyword' => 'fence line clearing & debris hauling Mauldin SC'],
    ['slug' => 'soil-testing-lime-application',      'title' => 'Soil Testing & Lime Application',    'type' => 'service',       'primary_keyword' => 'soil testing & lime application Mauldin SC'],
    ['slug' => 'dethatching',                        'title' => 'Dethatching',                        'type' => 'service',       'primary_keyword' => 'dethatching Mauldin SC'],
];

/* ── Service page card copy ───────────────────────────────── */
// Icon, one-line description, and exactly three benefit bullets for the
// mandated `.service-card-with-image` component (CLAUDE.md → Required
// Components). Keyed by $servicePages slug, so a card can never describe a
// page that does not exist.
//
// Lives here, not in services/index.php, because TWO call sites render this
// component: the services listing grid and the "Other Services You May Need"
// block at the foot of all eleven service pages. Both read it through
// includes/service-card.php, so the pattern cannot drift between them.
//
// Bullets are 3-6 words and benefit-driven; descriptions are one sentence of
// ≤14 words saying what the page actually is. Icons are ordered so no two
// ADJACENT cards repeat one when $servicePages renders in config order.

$serviceCardMeta = [
    'lawn-care-services' => [
        'icon'    => 'scissors',
        'desc'    => 'Recurring mowing, feeding, weed control, aeration, and repair on one schedule.',
        'bullets' => ['Weekly or biweekly routes', 'Feeding timed to grass type', 'Eight services, one crew'],
    ],
    'tree-shrub-services' => [
        'icon'    => 'tree-pine',
        'desc'    => 'Trimming, pruning, and cleanup for hedges, shrubs, small trees, and brush.',
        'bullets' => ['Hedges shaped off windows', 'Storm debris cleared fast', 'Clippings hauled, not left'],
    ],
    'spring-fall-cleanup' => [
        'icon'    => 'wind',
        'desc'    => 'Seasonal leaf removal, bed cleanout, and debris haul-off twice a year.',
        'bullets' => ['Leaf and storm debris removed', 'Beds cleared and re-edged', 'Hauled off, not curbside'],
    ],
    'mulch-installation' => [
        'icon'    => 'flower-2',
        'desc'    => 'Fresh mulch spread over cleaned, re-edged beds around foundations and trees.',
        'bullets' => ['Beds cleaned and re-edged', 'Even depth, crisp lines', 'Holds moisture through summer'],
    ],
    'flower-bed-shrub-planting' => [
        'icon'    => 'sprout',
        'desc'    => 'Bed cleanup, planting, and care for flowers, shrubs, and small trees.',
        'bullets' => ['Plants matched to sun', 'Beds cleaned before planting', 'Curb appeal that lasts'],
    ],
    'sod-installation' => [
        'icon'    => 'layers',
        'desc'    => 'New sod laid over graded, prepared soil for an instant lawn.',
        'bullets' => ['Soil graded and prepped', 'Warm-season sod varieties', 'Watering plan on handover'],
    ],
    'pressure-washing' => [
        'icon'    => 'spray-can',
        'desc'    => 'Surface cleaning for driveways, sidewalks, patios, and property walkways.',
        'bullets' => ['Driveways and sidewalks', 'Lifts algae and stains', 'Pressure matched to concrete'],
    ],
    'gutter-cleaning' => [
        'icon'    => 'droplets',
        'desc'    => 'Clearing gutters and downspouts to keep water moving off the roof.',
        'bullets' => ['Downspouts flushed clear', 'Protects fascia and foundation', 'Debris bagged and removed'],
    ],
    'fence-line-clearing-debris-hauling' => [
        'icon'    => 'trash-2',
        'desc'    => 'Overgrowth cleared along fence lines and yard debris hauled off-site.',
        'bullets' => ['Overgrown fence lines cleared', 'Brush and debris hauled', 'Property lines reclaimed'],
    ],
    'soil-testing-lime-application' => [
        'icon'    => 'flask-conical',
        'desc'    => 'Soil tested for pH, then lime and nutrients applied to correct it.',
        'bullets' => ['Soil pH measured first', 'Lime corrects clay acidity', 'Feeds stronger root growth'],
    ],
    'dethatching' => [
        'icon'    => 'shovel',
        'desc'    => 'Dead thatch pulled so water and nutrients reach the soil again.',
        'bullets' => ['Thick thatch pulled out', 'Water reaches the roots', 'Stronger, more resilient turf'],
    ],
];

/* ── Service areas ────────────────────────────────────────── */
// build-plan.json service_areas held one entry with an empty `city` and
// zip 29662 — resolved to Mauldin from the business address.
// Premium tier builds /areas/{city}/index.php per city, and every area page
// needs 3+ verifiable local specifics. One city is not enough to justify the
// area-page structure. Confirm the real 25-mile service list before Phase 4.

$serviceAreas = [
    ['city' => 'Mauldin', 'state' => 'SC', 'zip' => '29662', 'slug' => 'mauldin', 'primary' => true],
];

$targetRadius = 25;   // miles

/* ── Social ───────────────────────────────────────────────── */
// None supplied at intake. footer.php renders only platforms the client uses.

$socialLinks = [];

/* ── Reviews ──────────────────────────────────────────────── */
// INTAKE GAP. build-plan.json `reviews` is an empty array and no Google rating,
// review count, or GBP URL was supplied.
//
// This stays empty. Testimonials are statements attributed to real named people:
// writing them is fabricating an endorsement, which the FTC Endorsement Guides
// treat as a deceptive practice, and CLAUDE.md separately forbids inventing
// review numbers or ratings. The homepage renders a real job-photo proof section
// in this slot until genuine reviews exist.
//
// Shape, once populated — the homepage carousel reads this directly:
//   ['name' => 'First L.', 'location' => 'Mauldin, SC', 'service' => 'Lawn Mowing',
//    'rating' => 5, 'text' => '…', 'date' => 'March 2026']
$reviews = [];

/* ── Photo library ────────────────────────────────────────── */
// The six real client photos from build-plan.json, downloaded to /assets/images/
// rather than hotlinked from the Supabase bucket (the LCP hero must not depend on
// a third-party host). Source PNGs were 370x278; the hero is upscaled to 1600px.
//
// build-plan.json shipped every photo with alt:"", context:"other", and
// quality_score:null, and `recommended_hero_image` pointed at the LOGO file.
// The allocator clearly never ran on this build. Alt text below was written by
// looking at each image; the hero was chosen the same way.
// PHASE 4 CORRECTION: 'hero' is not a seventh photograph. It is an upscale of
// 'front_lawn' — pixel comparison puts them at RMSE 0.0027, i.e. the same image.
// Its alt said "Craftsman-style home" while front_lawn's said "a Mauldin, SC
// home" for the identical frame. Unified below. Never place both on one page.
//
// The library therefore holds SIX distinct photographs, and only TWO of them
// (mowing, hedges) show work actually being performed. The rest are outcome
// shots of finished properties. See $servicePhotos for what that costs us.
$photoLibrary = [
    'mowing'       => ['src' => '/assets/images/lawn-mowing-mauldin-sc.jpg',       'w' => 370, 'h' => 278, 'alt' => 'Greenville Lawn Masters crew member mowing a fenced backyard lawn in Mauldin, SC'],
    'hedges'       => ['src' => '/assets/images/hedge-trimming-mauldin-sc.jpg',    'w' => 370, 'h' => 278, 'alt' => 'Greenville Lawn Masters crew member trimming foundation hedges at a brick home in Mauldin, SC'],
    'front_lawn'   => ['src' => '/assets/images/front-lawn-mauldin-sc.jpg',        'w' => 370, 'h' => 278, 'alt' => 'Dense green front lawn and concrete driveway at a two-story home in a Mauldin, SC neighborhood'],
    'backyard'     => ['src' => '/assets/images/backyard-lawn-beds-mauldin-sc.jpg','w' => 370, 'h' => 278, 'alt' => 'Backyard turf running between mulched planting beds and a wood privacy fence at a Mauldin, SC home'],
    'mulch_bed'    => ['src' => '/assets/images/mulched-flower-bed-mauldin-sc.jpg','w' => 370, 'h' => 278, 'alt' => 'Freshly mulched flower bed beside the front walk of a Craftsman home in Mauldin, SC'],
    'driveway'     => ['src' => '/assets/images/clean-driveway-mauldin-sc.jpg',    'w' => 370, 'h' => 278, 'alt' => 'Clean concrete driveway and walkway at a two-story home in Mauldin, SC'],
];

// Backward compatibility: index.php (Phase 3) still reads $photoLibrary['hero'].
// Same frame as front_lawn, 1600px wide, so it stays addressable by that key.
$photoLibrary['hero'] = [
    'src' => '/assets/images/hero-mauldin-front-lawn.jpg',
    'w' => 1600, 'h' => 1202, 'alt' => $photoLibrary['front_lawn']['alt'],
];

/* ── Hero-size renditions ─────────────────────────────────────
   Every source photo is 370x278. A 370px file stretched across a 1920px hero
   is mush, so each hero photo is resampled to 1600x1202 (Lanczos, q82) exactly
   as Phase 3 produced hero-mauldin-front-lawn.jpg from front-lawn-mauldin-sc.jpg.
   These are interpolations, NOT extra detail — the heavy hero gradient overlay is
   what makes them read as sharp. Replace with real high-resolution originals when
   the client supplies them; nothing else has to change. */
$heroRenditions = [
    'front_lawn' => '/assets/images/hero-mauldin-front-lawn.jpg',
    'mowing'     => '/assets/images/hero-mauldin-lawn-mowing.jpg',
    'hedges'     => '/assets/images/hero-mauldin-hedge-trimming.jpg',
    'backyard'   => '/assets/images/hero-mauldin-backyard-beds.jpg',
    'mulch_bed'  => '/assets/images/hero-mauldin-mulch-bed.jpg',
    'driveway'   => '/assets/images/hero-mauldin-clean-driveway.jpg',
];

/* ── Service page → photo assignment ──────────────────────────
   Six photographs across eleven service pages. Reuse is unavoidable; dishonesty
   is not. A photo is assigned to a page only when the frame genuinely relates to
   that page's subject, and captions describe WHAT IS IN THE FRAME. No caption or
   alt attribute anywhere claims a photo shows a service being performed unless it
   does — that would be a fabricated claim in an accessibility attribute, and it
   would propagate into sitemap-images.xml at Phase 5.

   `photo_gap => true` marks a page with NO photograph depicting its service. Those
   pages use honest outcome/context imagery and say nothing about what the picture
   shows. CLAUDE.md's CLIENT PHOTO GATE blocks Phase 5 polish until real photos of
   these five services exist:
       gutter cleaning · sod installation · dethatching
       soil testing & lime application · fence line clearing & debris hauling */
$servicePhotos = [
    'lawn-care-services'                 => ['hero' => 'front_lawn', 'body' => ['mowing', 'backyard', 'mulch_bed']],
    'tree-shrub-services'                => ['hero' => 'hedges',     'body' => ['hedges', 'backyard', 'mulch_bed']],
    'spring-fall-cleanup'                => ['hero' => 'backyard',   'body' => ['backyard', 'mulch_bed', 'front_lawn']],
    'mulch-installation'                 => ['hero' => 'mulch_bed',  'body' => ['mulch_bed', 'backyard', 'front_lawn']],
    'flower-bed-shrub-planting'          => ['hero' => 'backyard',   'body' => ['backyard', 'mulch_bed', 'hedges']],
    'sod-installation'                   => ['hero' => 'front_lawn', 'body' => ['front_lawn', 'backyard', 'mulch_bed'], 'photo_gap' => true],
    'pressure-washing'                   => ['hero' => 'driveway',   'body' => ['driveway', 'front_lawn', 'mulch_bed']],
    'gutter-cleaning'                    => ['hero' => 'driveway',   'body' => ['driveway', 'front_lawn'],              'photo_gap' => true],
    'fence-line-clearing-debris-hauling' => ['hero' => 'backyard',   'body' => ['backyard', 'hedges', 'front_lawn'],    'photo_gap' => true],
    'soil-testing-lime-application'      => ['hero' => 'front_lawn', 'body' => ['front_lawn', 'backyard', 'mowing'],    'photo_gap' => true],
    'dethatching'                        => ['hero' => 'mowing',     'body' => ['mowing', 'front_lawn', 'backyard'],    'photo_gap' => true],
];

// Absolute, currently-resolvable URL for og:image. $siteUrl still points at a
// placeholder host, so an absolute URL under it would 404 for every scraper.
$ogImageUrl = 'https://db.pageone.cloud/storage/v1/object/public/client-assets/'
            . 'greenville-lawn-masters/photos/1783619518888-b5idvx-cr_w_370_h_278.png';
