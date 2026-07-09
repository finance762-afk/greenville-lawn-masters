<?php
/* ============================================================
   includes/functions.php
   Greenville Lawn Masters — shared helpers

   Pure functions only. No output, no side effects at include
   time. config.php is the data layer; this is the logic layer.
   ============================================================ */

/* ── Escaping ─────────────────────────────────────────────── */

/** Escape for HTML text/attribute context. Use on every dynamic echo. */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/* ── Navigation ───────────────────────────────────────────── */

/**
 * True when $page is the page currently rendering.
 * Pages set $currentPage before including head.php / header.php.
 */
function isActivePage(string $page): bool
{
    global $currentPage;
    return isset($currentPage) && $currentPage === $page;
}

/** `aria-current="page"` on the active nav link, empty string otherwise. */
function activeAria(string $page): string
{
    return isActivePage($page) ? ' aria-current="page"' : '';
}

/** `class="is-active"` on the active nav link, empty string otherwise. */
function activeClass(string $page, string $base = ''): string
{
    $classes = trim($base . (isActivePage($page) ? ' is-active' : ''));
    return $classes === '' ? '' : ' class="' . e($classes) . '"';
}

/* ── Phone ────────────────────────────────────────────────── */

/**
 * Display format for a US phone number: "(864) 555-0123".
 * Returns '' for empty input — callers must treat '' as "no phone,
 * render nothing" rather than substituting a placeholder.
 */
function formatPhone(string $phone): string
{
    $digits = preg_replace('/\D+/', '', $phone);

    if (strlen($digits) === 11 && $digits[0] === '1') {
        $digits = substr($digits, 1);
    }
    if (strlen($digits) !== 10) {
        return '';   // not a US 10-digit number — don't guess at a format
    }

    return sprintf('(%s) %s-%s',
        substr($digits, 0, 3),
        substr($digits, 3, 3),
        substr($digits, 6, 4)
    );
}

/** E.164 form for `tel:` and `sms:` hrefs — "+18645550123". '' if unusable. */
function phoneHref(string $phone): string
{
    $digits = preg_replace('/\D+/', '', $phone);

    if (strlen($digits) === 10) {
        $digits = '1' . $digits;
    }
    if (strlen($digits) !== 11 || $digits[0] !== '1') {
        return '';
    }

    return '+' . $digits;
}

/* ── Slugs ────────────────────────────────────────────────── */

/** "Fertilization & Weed Control" → "fertilization-weed-control" */
function slugify(string $text): string
{
    $slug = strtolower(trim($text));
    $slug = str_replace('&', ' ', $slug);           // "&" is a word break, not a letter
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    return trim($slug, '-');
}

/**
 * Slug for a service. Prefers the slug already committed in config.php's
 * $services so URLs never drift from the sitemap; falls back to slugify().
 */
function getServiceSlug(string $name): string
{
    global $services;

    foreach ($services ?? [] as $service) {
        if (strcasecmp($service['name'], $name) === 0) {
            return $service['slug'];
        }
    }
    return slugify($name);
}

/** Slug for a service-area city, preferring the committed $serviceAreas slug. */
function getAreaSlug(string $city): string
{
    global $serviceAreas;

    foreach ($serviceAreas ?? [] as $area) {
        if (strcasecmp($area['city'], $city) === 0) {
            return $area['slug'];
        }
    }
    return slugify($city);
}

/** The service page a given service lives on: /services/{page}/ */
function getServicePageUrl(string $name): string
{
    global $services;

    foreach ($services ?? [] as $service) {
        if (strcasecmp($service['name'], $name) === 0) {
            return '/services/' . $service['page'] . '/';
        }
    }
    return '/services/';
}

/** Every service whose 'page' matches $pageSlug, in config order. */
function servicesOnPage(string $pageSlug): array
{
    global $services;

    return array_values(array_filter(
        $services ?? [],
        fn(array $s): bool => $s['page'] === $pageSlug
    ));
}

/* ── URLs ─────────────────────────────────────────────────── */

/** Absolute URL for a site-root-relative path. */
function absoluteUrl(string $path = '/'): string
{
    global $siteUrl;
    return rtrim($siteUrl, '/') . '/' . ltrim($path, '/');
}

/** Canonical URL for the current request, trailing slash on directories. */
function canonicalForRequest(): string
{
    $path = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    return absoluteUrl($path);
}

/* ── Schema ───────────────────────────────────────────────── */

/**
 * Encode a schema array as a JSON-LD <script> block.
 * Slashes unescaped so URLs stay readable; empty arrays render nothing.
 */
function jsonLdBlock(array $schema): string
{
    if (empty($schema)) {
        return '';
    }

    $json = json_encode(
        $schema,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );

    return '<script type="application/ld+json">' . "\n" . $json . "\n" . '</script>';
}

/**
 * The homepage LocalBusiness node's @id. Every other page's schema points at
 * this instead of restating the business (CLAUDE.md: don't duplicate
 * LocalBusiness blocks).
 */
function organizationId(): string
{
    return absoluteUrl('/') . '#organization';
}

/**
 * Service schema for a single service page, referencing the homepage
 * LocalBusiness as provider.
 *
 * Deliberately omits `offers` — no pricing was supplied at intake, and a
 * fabricated priceRange in structured data is a misrepresentation to Google.
 */
function generateServiceSchema(array $service): array
{
    global $address;

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => $service['name'],
        'description' => $service['description'] ?? '',
        'provider'    => ['@id' => organizationId()],
        'areaServed'  => [
            '@type' => 'City',
            'name'  => $address['city'],
        ],
    ];

    if (!empty($service['page'])) {
        $schema['url'] = absoluteUrl('/services/' . $service['page'] . '/');
    }

    return $schema;
}

/**
 * FAQPage schema from [['question' => ..., 'answer' => ...], ...].
 *
 * AI comprehension aid only — FAQ rich results were deprecated May 2026
 * (CLAUDE.md). The questions and answers passed in MUST also be visible on
 * the page; schema that doesn't mirror visible content is a guidelines
 * violation. Returns [] for empty input so jsonLdBlock() prints nothing.
 */
function generateFAQSchema(array $faqs): array
{
    if (empty($faqs)) {
        return [];
    }

    $entities = [];
    foreach ($faqs as $faq) {
        if (empty($faq['question']) || empty($faq['answer'])) {
            continue;
        }
        $entities[] = [
            '@type'          => 'Question',
            'name'           => $faq['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $faq['answer'],
            ],
        ];
    }

    if (empty($entities)) {
        return [];
    }

    return [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => $entities,
    ];
}

/**
 * BreadcrumbList from [['name' => ..., 'url' => '/path/'], ...].
 * Required on every non-homepage.
 */
function generateBreadcrumbSchema(array $crumbs): array
{
    if (empty($crumbs)) {
        return [];
    }

    $items = [];
    foreach (array_values($crumbs) as $i => $crumb) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $crumb['name'],
            'item'     => absoluteUrl($crumb['url']),
        ];
    }

    return [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}

/**
 * The homepage LocalBusiness node.
 *
 * @type is HomeAndConstructionBusiness, not the "LawnMaintenanceService" that
 * seo-aeo-2026.md line 181 offers first: LawnMaintenanceService is not a real
 * schema.org type and would fail validation. The same line sanctions
 * HomeAndConstructionBusiness as the alternative for lawn care.
 *
 * telephone / email / streetAddress / geo / hasMap / openingHoursSpecification
 * are emitted ONLY when config.php actually has them. Absent → omitted key.
 *
 * NO aggregateRating — ever. Self-serving AggregateRating on LocalBusiness
 * cannot produce SERP stars and risks a manual action (CLAUDE.md;
 * seo-aeo-2026.md §"AggregateRating — NEVER include"). build-plan.json's
 * reviews array is empty, so emitting one would also mean inventing a rating.
 */
function generateLocalBusinessSchema(): array
{
    global $siteName, $tagline, $siteUrl, $logoUrl, $phone, $email,
           $address, $businessHours, $geo, $gbpUrl, $serviceAreas,
           $services, $yearEstablished;

    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'HomeAndConstructionBusiness',
        '@id'         => organizationId(),
        'name'        => $siteName,
        'slogan'      => $tagline,
        'url'         => rtrim($siteUrl, '/') . '/',
        'image'       => $logoUrl,
        'logo'        => $logoUrl,
        'description' => sprintf(
            '%s provides lawn care, landscaping, and seasonal property maintenance '
            . 'for homes and businesses in %s, %s and the surrounding Greenville County area.',
            $siteName, $address['city'], $address['state']
        ),
        'foundingDate' => (string) $yearEstablished,
    ];

    if ($phone !== '' && phoneHref($phone) !== '') {
        $schema['telephone'] = phoneHref($phone);
    }
    if ($email !== '') {
        $schema['email'] = $email;
    }

    // PostalAddress: streetAddress only when known. City/state/zip are real.
    $postal = [
        '@type'           => 'PostalAddress',
        'addressLocality' => $address['city'],
        'addressRegion'   => $address['state'],
        'postalCode'      => $address['zip'],
        'addressCountry'  => 'US',
    ];
    if ($address['street'] !== '') {
        $postal['streetAddress'] = $address['street'];
    }
    $schema['address'] = $postal;

    if (is_array($geo) && isset($geo['lat'], $geo['lng'])) {
        $schema['geo'] = [
            '@type'     => 'GeoCoordinates',
            'latitude'  => $geo['lat'],
            'longitude' => $geo['lng'],
        ];
    }
    if ($gbpUrl !== '') {
        $schema['hasMap'] = $gbpUrl;
    }

    if (!empty($businessHours)) {
        $spec = [];
        foreach ($businessHours as $day => $window) {
            $spec[] = [
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => 'https://schema.org/' . $day,
                'opens'     => $window[0],
                'closes'    => $window[1],
            ];
        }
        $schema['openingHoursSpecification'] = $spec;
    }

    $schema['areaServed'] = array_map(
        fn(array $area): array => ['@type' => 'City', 'name' => $area['city']],
        $serviceAreas ?? []
    );

    $schema['hasOfferCatalog'] = [
        '@type'           => 'OfferCatalog',
        'name'            => $siteName . ' Services',
        'itemListElement' => array_map(
            fn(array $s): array => [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name'  => $s['name'],
                    'url'   => absoluteUrl('/services/' . $s['page'] . '/'),
                ],
            ],
            $services ?? []
        ),
    ];

    return $schema;
}

/* ── SEO ──────────────────────────────────────────────────── */

/**
 * Title / description / canonical / Open Graph for one page.
 *
 * No <meta name="keywords"> — Google has ignored it since 2009 and CLAUDE.md
 * lists it as a forbidden tag. No twitter:* tags — also forbidden, zero
 * discovery value for a local service business.
 */
function generateMetaTags(string $title, string $description, string $canonical, array $opts = []): string
{
    global $siteName, $logoUrl;

    $ogImage = $opts['ogImage'] ?? $logoUrl;
    $ogType  = $opts['ogType']  ?? 'website';
    $noindex = !empty($opts['noindex']);

    $out = [];
    $out[] = '<title>' . e($title) . '</title>';
    $out[] = '<meta name="description" content="' . e($description) . '">';
    $out[] = '<link rel="canonical" href="' . e($canonical) . '">';

    if ($noindex) {
        $out[] = '<meta name="robots" content="noindex,nofollow">';
    } else {
        $out[] = '<meta name="robots" content="index,follow,max-image-preview:large">';
    }

    $out[] = '<meta property="og:type" content="' . e($ogType) . '">';
    $out[] = '<meta property="og:title" content="' . e($title) . '">';
    $out[] = '<meta property="og:description" content="' . e($description) . '">';
    $out[] = '<meta property="og:url" content="' . e($canonical) . '">';
    $out[] = '<meta property="og:image" content="' . e($ogImage) . '">';
    $out[] = '<meta property="og:site_name" content="' . e($siteName) . '">';
    $out[] = '<meta property="og:locale" content="en_US">';

    return implode("\n    ", $out);
}
