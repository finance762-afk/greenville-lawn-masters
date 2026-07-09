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

/* ── Lead form ────────────────────────────────────────────── */

// Taken from build-plan.json `form_action`.
// NOTE: CLAUDE.md mandates https://db.pageone.cloud/functions/v1/leads/{slug}
// for all client forms. build-plan.json specifies a different host and path.
// Unresolved conflict — confirm the live endpoint before Phase 4 builds any
// form, or leads will post into the void.
$formAction = 'https://design.pageone.cloud/api/leads/' . $slug;

// Hidden field `_consent_version` on every form (CLAUDE.md TCPA section).
$consentVersion = 'v2.1';

/* ── Analytics ────────────────────────────────────────────── */

$googleAnalyticsId = 'G-XXXXXXXXXX';   // placeholder — swap post-launch

/* ── Brand ────────────────────────────────────────────────── */
// build-plan.json design.colors, extracted_from_logo = false.
// These are generic portal defaults (navy / slate / cyan) with no green —
// unusual for lawn care. Logo analysis (design-system.md Part B) has not run.
// Re-derive from the logo before Phase 2 writes framework.css tokens.

$colors = [
    'primary'   => '#1a2b3c',
    'secondary' => '#4d5e6f',
    'accent'    => '#06b6d4',
];

$designStyle = 'elegant';   // build-plan design.style; archetype not yet assigned
$cssVersion  = 1;           // increment on every framework.css change

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
