<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$pageTitle = 'Cookie Policy | Greenville Lawn Masters | Mauldin, SC';
$pageDescription = 'Cookie Policy for Greenville Lawn Masters. Learn about the cookies and tracking technologies we use on our website and how to manage your preferences.';
$canonicalUrl = 'https://greenville-lawn-masters.pageone.cloud/cookie-policy/';
$currentPage = 'legal';
?>
<?php
/* ============================================================
   /cookie-policy/index.php — Phase 5 (compliance)
   Greenville Lawn Masters · Mauldin, SC

   INDEXABLE. Linked from the footer legal row and from the cookie
   banner (includes/cookie-banner.php).

   ── THE TABLE BELOW DESCRIBES WHAT THIS SITE ACTUALLY DOES ─────
   Every row was verified against the code, not copied from the
   template. A cookie policy that lists cookies the site does not set,
   and omits the storage it does, is a false disclosure — which is the
   one thing a cookie policy cannot be.

   VERIFIED, as of this build:
     • assets/js/effects.js line 17 sets localStorage key
       `glm_cookie_notice_dismissed`. It is localStorage, NOT a cookie —
       it is never transmitted to any server. Disclosed as such.
     • includes/head.php ships the GA4 snippet COMMENTED OUT with the
       placeholder ID G-XXXXXXXXXX. No _ga / _gid cookie is set today.
       Disclosed as "configured but currently disabled", so the text is
       already correct the moment it is switched on.
     • Google Fonts (head.php) and unpkg/Lucide (footer.php) are
       subresource requests. They do not set cookies on this domain, but
       they do expose the visitor's IP to those hosts. Disclosed.
     • The Google Maps iframe on /contact/ DOES set Google cookies, and
       only on that page. Disclosed with that qualification.

   ⚠ WHEN GA4 IS ENABLED: uncomment the snippet in head.php AND flip the
   "currently disabled" language in the table row + section 2 below. The
   two must never drift apart.
   ============================================================ */

$currentPage = 'legal';

$pageTitle       = 'Cookie Policy | Greenville Lawn Masters, Mauldin SC';
$pageDescription = 'Which cookies and browser storage the Greenville Lawn Masters website uses, '
                 . 'what each one does, and how to control or remove them in your browser.';   // 152 chars

$canonicalUrl = $siteUrl . '/cookie-policy/';
$ogImage      = $logoUrl;

$lastUpdated  = date('F j, Y');

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';
$hasEmail     = $email !== '';

/* ── The actual storage inventory ──────────────────────────────
   `type` drives the badge colour. `status` empty means active. */
$cookieRows = [
    [
        'name'     => 'glm_cookie_notice_dismissed',
        'type'     => 'necessary',
        'kind'     => 'Local storage (not a cookie)',
        'setby'    => 'This site',
        'purpose'  => 'Remembers that you dismissed the cookie notice, so it does not reappear on every page. Stored in your browser and never sent to any server.',
        'duration' => 'Until you clear site data',
        'status'   => '',
    ],
    [
        'name'     => 'PHP session cookie',
        'type'     => 'necessary',
        'kind'     => 'First-party cookie',
        'setby'    => 'This site',
        'purpose'  => 'Set by the web server only if a page needs a session. Carries no personal information and is not used for tracking.',
        'duration' => 'Until you close the browser',
        'status'   => '',
    ],
    [
        'name'     => '_ga, _ga_*',
        'type'     => 'analytics',
        'kind'     => 'First-party cookie',
        'setby'    => 'Google Analytics 4',
        'purpose'  => 'Distinguishes visitors and sessions so we can see which pages are read and which are not.',
        'duration' => 'Up to 2 years',
        'status'   => 'Currently disabled',
    ],
    [
        'name'     => 'NID, CONSENT, and similar',
        'type'     => 'third-party',
        'kind'     => 'Third-party cookie',
        'setby'    => 'Google Maps',
        'purpose'  => 'Set by the map embedded on our contact page, when and only when you load that page. Governed by Google\'s own privacy policy, not ours.',
        'duration' => 'Varies (set by Google)',
        'status'   => 'Contact page only',
    ],
];

$typeLabels = [
    'necessary'   => 'Strictly necessary',
    'analytics'   => 'Analytics',
    'third-party' => 'Third-party embed',
];

$pageSchema = [
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'WebPage',
        '@id'         => $canonicalUrl . '#webpage',
        'url'         => $canonicalUrl,
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'about'       => ['@id' => organizationId()],
        'dateModified'=> date('Y-m-d'),
    ],
    generateBreadcrumbSchema([
        ['name' => 'Home',          'url' => '/'],
        ['name' => 'Cookie Policy', 'url' => '/cookie-policy/'],
    ]),
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   Cookie Policy — page-scoped styles
   Shared legal shell lives in framework.css. What is HERE is unique to
   this page: the storage inventory table with its type badges, and the
   browser-control card row. All var() tokens.

   Techniques used (design-system.md Part C):
     C7  signature — the full-bleed storage inventory table with colour-
         coded type badges, which no other page carries
     C10 floating decorative accent at 5% opacity
     C12 responsive table that reflows to labelled stacked rows on mobile
   ============================================================ */

.ck-body { background: var(--color-white); }
.ck-body::before {
  content: '';
  position: absolute;
  top: var(--space-12);
  right: calc(var(--space-16) * -1);
  width: 300px;
  height: 300px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  opacity: 0.05;
  pointer-events: none;
}

/* ── C7 · SIGNATURE — the storage inventory ───────────────────
   Escapes the 65ch prose column, because a five-column table cannot live
   inside one. Centred against the wider container instead. */
.ck-inventory {
  max-width: 68rem;
  margin: var(--space-8) auto var(--space-16);
}
.ck-inventory__title {
  font-family: var(--font-heading);
  font-size: var(--font-size-2xl);
  color: var(--color-primary);
  text-align: center;
  text-wrap: balance;
  margin-bottom: var(--space-2);
  scroll-margin-top: calc(var(--nav-height) + var(--space-6));
}
.ck-inventory__sub {
  text-align: center;
  color: var(--color-gray);
  font-size: var(--font-size-sm);
  margin-bottom: var(--space-8);
}

.ck-table {
  width: 100%;
  border-collapse: collapse;
  font-size: var(--font-size-sm);
  border: 1px solid var(--color-gray-light);
  border-radius: var(--radius-lg);
  overflow: hidden;
  box-shadow: var(--shadow-card);
}
.ck-table thead { background: var(--color-primary); }
.ck-table th {
  text-align: left;
  padding: var(--space-4);
  color: var(--color-white);
  font-family: var(--font-heading);
  font-weight: 600;
  white-space: nowrap;
}
.ck-table td {
  padding: var(--space-4);
  border-top: 1px solid var(--color-gray-light);
  color: var(--color-gray-dark);
  vertical-align: top;
  line-height: 1.6;
}
.ck-table tbody tr { transition: background var(--transition-fast); }
.ck-table tbody tr:nth-child(even) { background: var(--color-light); }
.ck-table tbody tr:hover { background: var(--color-card-tint-1); }
.ck-table__name {
  font-family: var(--font-heading);
  font-weight: 700;
  color: var(--color-black);
  word-break: break-word;
}
.ck-table__kind {
  display: block;
  font-size: var(--font-size-xs);
  color: var(--color-gray);
  font-family: var(--font-body);
  font-weight: 400;
  margin-top: var(--space-1);
}

/* Type badges */
.ck-badge {
  display: inline-block;
  padding: var(--space-1) var(--space-3);
  border-radius: var(--radius-full);
  font-size: var(--font-size-xs);
  font-weight: 700;
  white-space: nowrap;
}
.ck-badge--necessary   { background: var(--color-card-tint-1); color: var(--color-primary-dark); }
.ck-badge--analytics   { background: var(--color-card-tint-3); color: var(--color-primary-dark); }
.ck-badge--third-party { background: var(--color-card-tint-neutral); color: var(--color-secondary); }

/* "Currently disabled" / "Contact page only" qualifier */
.ck-status {
  display: inline-flex;
  align-items: center;
  gap: var(--space-1);
  margin-top: var(--space-2);
  font-size: var(--font-size-xs);
  font-weight: 600;
  color: var(--color-primary);
}
.ck-status i, .ck-status svg { width: 13px; height: 13px; }

/* ── Browser control cards ────────────────────────────────────*/
.ck-browsers {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-4);
  margin: var(--space-6) 0 var(--space-8);
}
.ck-browser {
  display: block;
  padding: var(--space-5);
  border-radius: var(--radius-md);
  border: 1px solid var(--color-gray-light);
  text-align: center;
  transition: border-color var(--transition-base), transform var(--transition-base);
}
.ck-browser:hover { border-color: var(--color-accent); transform: translateY(-3px); }
.ck-browser i, .ck-browser svg {
  width: 22px; height: 22px;
  color: var(--color-primary);
  margin-bottom: var(--space-2);
}
.ck-browser span {
  display: block;
  font-family: var(--font-heading);
  font-weight: 600;
  font-size: var(--font-size-sm);
  color: var(--color-primary-dark);
}

/* Reset-the-banner callout */
.ck-reset {
  display: flex;
  gap: var(--space-4);
  align-items: flex-start;
  padding: var(--space-5);
  margin: var(--space-6) 0;
  border-radius: var(--radius-md);
  background: var(--color-card-tint-2);
  border-left: 3px solid var(--color-accent);
}
.ck-reset i, .ck-reset svg { width: 19px; height: 19px; flex-shrink: 0; margin-top: 3px; color: var(--color-primary); }
.ck-reset p { margin: 0; font-size: var(--font-size-sm); line-height: 1.7; color: var(--color-gray-dark); }
.ck-reset code {
  background: var(--color-white);
  border: 1px solid var(--color-gray-light);
  border-radius: var(--radius-sm);
  padding: 0 var(--space-1);
  font-size: 0.9em;
  word-break: break-all;
}

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .ck-browsers { grid-template-columns: repeat(2, 1fr); }
  .ck-body::before { display: none; }
}
@media (max-width: 820px) {
  /* Five columns cannot survive a phone. Each row becomes a labelled card. */
  .ck-table { box-shadow: none; border: 0; }
  .ck-table thead { display: none; }
  .ck-table, .ck-table tbody, .ck-table tr, .ck-table td { display: block; width: 100%; }
  .ck-table tr {
    border: 1px solid var(--color-gray-light);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-4);
    padding: var(--space-2);
    background: var(--color-white);
  }
  .ck-table tbody tr:nth-child(even) { background: var(--color-white); }
  .ck-table td { border-top: 0; padding: var(--space-2) var(--space-3); }
  .ck-table td::before {
    content: attr(data-label);
    display: block;
    font-family: var(--font-heading);
    font-size: var(--font-size-xs);
    letter-spacing: 1px;
    text-transform: uppercase;
    color: var(--color-primary);
    margin-bottom: var(--space-1);
  }
}
@media (max-width: 600px) {
  .ck-browsers { grid-template-columns: 1fr; }
}

/* ── Deep-linked section ──────────────────────────────────────*/
.legal-prose h2:target,
.legal-prose h3:target,
.ck-inventory__title:target { scroll-margin-top: calc(var(--nav-height) + var(--space-8)); }

/* ── List markers + inline code ───────────────────────────────
   The storage key names are literal strings a reader may need to type into
   devtools, so they are <code> and must look like it. */
.legal-prose ul li::marker,
.legal-prose ol li::marker { color: var(--color-accent); }
.legal-prose code {
  background: var(--color-light);
  border: 1px solid var(--color-gray-light);
  border-radius: var(--radius-sm);
  padding: 0 var(--space-1);
  font-size: 0.9em;
  word-break: break-all;
}

/* Brand-green selection. */
.ck-body ::selection { background: rgba(var(--color-accent-rgb), 0.25); color: var(--color-black); }

/* ── Focus states ─────────────────────────────────────────────*/
.ck-browser:focus-visible {
  outline: 2px solid var(--color-accent);
  outline-offset: 3px;
  transform: translateY(-3px);
}
.legal-prose a:focus-visible,
.legal-contact a:focus-visible {
  outline: 2px solid var(--color-accent);
  outline-offset: 2px;
  border-radius: var(--radius-sm);
  border-bottom-color: transparent;
}

/* ── Reduced motion ───────────────────────────────────────────*/
@media (prefers-reduced-motion: reduce) {
  .ck-browser:hover { transform: none; }
  .ck-table tbody tr { transition: none; }
}

/* ── Windows High Contrast / forced-colors ────────────────────
   The type badges are the whole legend of this table, and they encode
   their category in background colour alone. forced-colors erases that,
   so each badge needs a border and the table needs real gridlines. */
@media (forced-colors: active) {
  .ck-badge { border: 1px solid CanvasText; }
  .ck-table { box-shadow: none; }
  .ck-table, .ck-table td, .ck-table th { border: 1px solid CanvasText; }
  .ck-table tbody tr:nth-child(even) { background: Canvas; }
  .ck-table tbody tr:hover { background: Canvas; }
  .ck-browser, .ck-reset,
  .legal-contact, .legal-disclaimer { border: 1px solid CanvasText; }
  .legal-prose :target { animation: none; outline: 2px solid Highlight; }
}

/* ── Wide viewports ───────────────────────────────────────────*/
@media (min-width: 1400px) {
  .ck-inventory { max-width: 74rem; }
}

/* ── Print ────────────────────────────────────────────────────
   The inventory table is the reason anyone prints this page. Keep it whole,
   keep its gridlines, and drop the coloured badge fills for legible ink. */
@media print {
  @page { margin: 2cm; }

  .site-header, .site-footer, .cookie-banner, .mobile-cta-bar,
  .back-to-top, .ck-browsers, .hero--legal .breadcrumb { display: none !important; }

  .hero.hero--legal { min-height: auto; padding-block: var(--space-4); background: none; }
  .hero.hero--legal::after { display: none; }
  .hero--legal h1, .hero--legal .eyebrow-label, .legal-stamp { color: var(--color-black); }
  .legal-stamp { border: 1px solid var(--color-black); background: none; backdrop-filter: none; }
  .ck-body::before { display: none; }

  .legal-prose { max-width: none; }
  .legal-prose h2, .legal-prose h3 { break-after: avoid; }
  .legal-prose p, .legal-prose li { orphans: 3; widows: 3; }

  .ck-table { box-shadow: none; break-inside: avoid; }
  .ck-table thead { background: none; }
  .ck-table th { color: var(--color-black); border-bottom: 2px solid var(--color-black); }
  .ck-table td, .ck-table th { border: 1px solid var(--color-gray); }
  .ck-table tbody tr:nth-child(even) { background: none; }
  .ck-badge { background: none; border: 1px solid var(--color-black); color: var(--color-black); }

  .ck-reset, .legal-contact, .legal-disclaimer {
    break-inside: avoid;
    border: 1px solid var(--color-black);
    background: none;
  }

  .legal-prose a[href^="http"]::after { content: " (" attr(href) ")"; font-size: 0.85em; word-break: break-all; }
  .legal-prose a[href^="/"]::after    { content: " (<?php echo e($siteUrl); ?>" attr(href) ")"; font-size: 0.85em; word-break: break-all; }
  .legal-prose a { border-bottom: 0; color: var(--color-black); }
}
</style>

<!-- ══════════ HERO ══════════ -->
<section class="hero hero--legal" aria-label="Cookie Policy">
    <div class="container">

        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                <li><span aria-current="page">Cookie Policy</span></li>
            </ol>
        </nav>

        <span class="eyebrow-label">Legal</span>
        <h1>Cookie Policy</h1>

        <span class="legal-stamp">
            <i data-lucide="calendar" aria-hidden="true"></i>
            Effective &amp; Last Updated: <?php echo e($lastUpdated); ?>
        </span>

    </div>
</section>

<!-- ══════════ BODY ══════════ -->
<section class="ck-body" aria-label="Cookie Policy content">
    <div class="container">

        <article class="legal-prose">
            <h2 id="what-are-cookies">1. What Are Cookies?</h2>
            <p>
                Cookies are small text files a website asks your browser to store. They let a site
                remember things between page loads, and they let site owners see how the site is used.
                Related technologies — <strong>local storage</strong> in particular — do a similar job
                but are never transmitted to a server; they only ever live in your browser.
            </p>
            <p>
                This page lists everything <?php echo e($legalEntityName); ?> stores in your browser, what
                each item does, and how to get rid of it. It is a short list. We are a lawn care company.
            </p>
        </article>

        <!-- ══ SIGNATURE — the storage inventory ══ -->
        <div class="ck-inventory">
            <h2 class="ck-inventory__title" id="cookies-we-use">2. Exactly what this site stores</h2>
            <p class="ck-inventory__sub">
                Verified against the code of this website, not a template.
            </p>

            <table class="ck-table">
                <caption class="sr-only">
                    Cookies and browser storage used by the Greenville Lawn Masters website
                </caption>
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Set by</th>
                        <th scope="col">What it does</th>
                        <th scope="col">How long it lasts</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cookieRows as $row): ?>
                        <tr>
                            <td data-label="Name">
                                <span class="ck-table__name"><?php echo e($row['name']); ?></span>
                                <span class="ck-table__kind"><?php echo e($row['kind']); ?></span>
                            </td>
                            <td data-label="Category">
                                <span class="ck-badge ck-badge--<?php echo e($row['type']); ?>">
                                    <?php echo e($typeLabels[$row['type']]); ?>
                                </span>
                                <?php if ($row['status'] !== ''): ?>
                                    <span class="ck-status">
                                        <i data-lucide="info" aria-hidden="true"></i>
                                        <?php echo e($row['status']); ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Set by"><?php echo e($row['setby']); ?></td>
                            <td data-label="What it does"><?php echo e($row['purpose']); ?></td>
                            <td data-label="How long it lasts"><?php echo e($row['duration']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <article class="legal-prose">

            <h3>Strictly necessary</h3>
            <p>
                Required for the site to function. These cannot be switched off, because switching them
                off breaks the thing you asked for — including the flag that stops the cookie notice
                reappearing on every single page.
            </p>

            <h3>Analytics</h3>
            <p>
                Google Analytics 4 is configured on this site but is
                <strong>currently disabled</strong>: the tracking snippet is commented out and no
                measurement ID is live. No <code>_ga</code> cookie is being set today. When analytics is
                switched on, this page will be updated on the same day, and the cookie notice will
                continue to appear for new visitors.
            </p>

            <h3>Third-party embeds</h3>
            <p>
                The map on our <a href="/contact/">contact page</a> is served by Google Maps, and loading
                that page allows Google to set its own cookies under its own privacy policy. No other page
                on this site embeds a third-party frame.
            </p>
            <p>
                Two further services receive your IP address, because your browser has to ask them for
                files: <strong>Google Fonts</strong> serves the typefaces, and <strong>unpkg</strong>
                serves the icon library. Neither sets a cookie on this domain. Both are listed in our
                <a href="/privacy-policy/#how-we-share">Privacy Policy</a>.
            </p>

            <h2 id="control">3. How to Control Cookies</h2>
            <p>
                Every major browser lets you view, delete, and block cookies, and block third-party
                cookies specifically. Blocking everything may break parts of this and other websites.
            </p>

            <div class="ck-browsers">
                <a class="ck-browser" href="https://support.google.com/chrome/answer/95647" target="_blank" rel="noopener">
                    <i data-lucide="chrome" aria-hidden="true"></i>
                    <span>Chrome</span>
                </a>
                <a class="ck-browser" href="https://support.mozilla.org/kb/enhanced-tracking-protection-firefox-desktop" target="_blank" rel="noopener">
                    <i data-lucide="globe" aria-hidden="true"></i>
                    <span>Firefox</span>
                </a>
                <a class="ck-browser" href="https://support.apple.com/guide/safari/manage-cookies-sfri11471/mac" target="_blank" rel="noopener">
                    <i data-lucide="compass" aria-hidden="true"></i>
                    <span>Safari</span>
                </a>
                <a class="ck-browser" href="https://support.microsoft.com/microsoft-edge" target="_blank" rel="noopener">
                    <i data-lucide="globe-2" aria-hidden="true"></i>
                    <span>Edge</span>
                </a>
            </div>

            <h2 id="opt-out">4. Opting Out of Google Analytics</h2>
            <p>
                If and when analytics is enabled here, you can opt out of Google Analytics on every site
                you visit by installing the
                <a href="https://tools.google.com/dlpage/gaoptout" target="_blank" rel="noopener">Google
                Analytics Opt-out Browser Add-on</a>. Browser-level tracking protection and most content
                blockers also stop it.
            </p>

            <h2 id="our-notice">5. Our Cookie Notice</h2>
            <p>
                On your first visit, a small banner tells you this site uses cookies and links here.
                Dismissing it with "Got it" writes the local storage flag in the table above, and the
                banner does not return.
            </p>
            <div class="ck-reset">
                <i data-lucide="rotate-ccw" aria-hidden="true"></i>
                <p>
                    <strong>To bring the notice back:</strong> clear this site's data in your browser
                    settings, or delete the <code>glm_cookie_notice_dismissed</code> key from local
                    storage in your browser's developer tools. If your browser blocks local storage
                    entirely — private browsing mode, for instance — the banner will appear on every
                    visit, and dismissing it will still work for that session.
                </p>
            </div>

            <h2 id="changes">6. Changes to This Policy</h2>
            <p>
                We may update this Cookie Policy as the site changes. The "Last Updated" date at the top
                reflects the current version. If we begin setting a cookie that is not listed above, this
                page is updated before that cookie ships.
            </p>

            <h2 id="contact">7. Contact Us</h2>
            <p>Questions about cookies or browser storage on this site:</p>

            <div class="legal-contact">
                <p class="legal-contact__name"><?php echo e($legalEntityName); ?></p>
                <p>
                    <?php if ($address['street'] !== ''): ?>
                        <?php echo e($address['street']); ?><br>
                    <?php endif; ?>
                    <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?> <?php echo e($address['zip']); ?>
                </p>
                <?php if ($hasEmail): ?>
                    <p>Email: <a href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a></p>
                <?php endif; ?>
                <?php if ($hasPhone): ?>
                    <p>Phone: <a href="tel:<?php echo e($phoneLink); ?>"><?php echo e($phoneDisplay); ?></a></p>
                <?php endif; ?>
                <p>Online: <a href="/contact/">Contact form</a></p>
            </div>

            <div class="legal-disclaimer">
                <i data-lucide="triangle-alert" aria-hidden="true"></i>
                <span>
                    This Cookie Policy is provided as a general template. We recommend reviewing it with a
                    licensed <?php echo e($companyState); ?> attorney before publication.
                </span>
            </div>

        </article>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
