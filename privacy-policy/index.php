<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$pageTitle = 'Privacy Policy | Greenville Lawn Masters | Mauldin, SC';
$pageDescription = 'Privacy Policy for Greenville Lawn Masters. Learn how we collect, use, and protect your personal information in accordance with CCPA, CPRA, and other privacy laws.';
$canonicalUrl = 'https://greenville-lawn-masters.pageone.cloud/privacy-policy/';
$currentPage = 'legal';
?>
<?php
/* ============================================================
   /privacy-policy/index.php — Phase 5 (compliance)
   Greenville Lawn Masters · Mauldin, SC

   INDEXABLE. Legal disclosures must be findable; no $noindex here.
   Linked only from the footer legal row (CLAUDE.md), never from nav
   or a body CTA.

   `#ccpa-rights` is a load-bearing anchor: footer.php links
   "/privacy-policy/#ccpa-rights" from EVERY page on the site as the
   "Do Not Sell or Share My Personal Information" link. If the id on
   that <h2> is renamed, the CCPA link on every page silently dumps
   the visitor at the top of the document instead.

   ── PROCESSOR DISCLOSURE ───────────────────────────────────────
   The processors named in section 4 are the ones this build actually
   uses, verified against the code rather than copied from the template:
     • Page One Insights CRM  — includes/config.php $formAction posts
       every form to db.pageone.cloud/functions/v1/leads/{slug}
     • Google Fonts           — includes/head.php $fontHref
     • unpkg.com (Lucide)     — includes/footer.php <script src>
     • Google Maps            — /contact/ map embed iframe
     • Google Analytics 4     — head.php, CURRENTLY COMMENTED OUT
     • Hostinger              — hosting

   legal-compliance.md's template names "Formsubmit.co" as the form
   processor. This build does not use Formsubmit — CLAUDE.md replaced it
   with the CRM endpoint. Naming a processor that never touches the data,
   while omitting the one that does, is exactly the kind of error a
   privacy disclosure exists to prevent. Corrected below.

   GA4 is disclosed as "when enabled" because head.php ships it commented
   out with a placeholder measurement ID. The moment it is uncommented,
   this text is already correct.

   ── ENTITY TYPE ────────────────────────────────────────────────
   $companyEntityType is EMPTY in config.php (intake never supplied it),
   so $legalEntityName degrades to the trading name. Do not hardcode
   "LLC" here — see the note in config.php.

   ⚠ Contact channels: $phone and $email are both empty. The rights
   sections below therefore route to the contact form, which is a real
   and working channel, rather than to a fabricated inbox. A privacy
   policy that tells a California resident to email an address that does
   not exist is worse than useless — it is an unfulfillable CCPA promise.
   ============================================================ */

$currentPage = 'legal';

$pageTitle       = 'Privacy Policy | Greenville Lawn Masters, Mauldin SC';
$pageDescription = 'Greenville Lawn Masters privacy practices, data collection, CCPA rights, '
                 . 'SMS consent terms, and how we protect your information in Mauldin, SC.';   // 158 chars

$canonicalUrl = $siteUrl . '/privacy-policy/';
$ogImage      = $logoUrl;

$pageTitle       = 'Privacy Policy | Greenville Lawn Masters, Mauldin SC';
$pageDescription = 'How Greenville Lawn Masters collects, uses, and protects your information — '
                 . 'contact forms, cookies, SMS consent, and your privacy rights in South Carolina '
                 . 'and California.';   // 159 chars

$canonicalUrl = $siteUrl . '/privacy-policy/';
$ogImage      = $logoUrl;

$lastUpdated  = date('F j, Y');

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';
$hasEmail     = $email !== '';

/* ── Schema ────────────────────────────────────────────────────
   WebPage + BreadcrumbList only. No FAQPage, no Service, no LocalBusiness
   restatement (CLAUDE.md → compliance page rules). */
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
        ['name' => 'Home',           'url' => '/'],
        ['name' => 'Privacy Policy', 'url' => '/privacy-policy/'],
    ]),
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   Privacy Policy — page-scoped styles
   The shared legal shell (.hero--legal, .legal-prose, .legal-disclaimer,
   .legal-contact, .legal-stamp) lives in framework.css because four pages
   use it. What is HERE is unique to this page: the rights cards, the
   processor table, and the data-collection ledger. All var() tokens.

   Techniques used (design-system.md Part C):
     C3  SVG divider (soft wave)
     C7  signature — the rights card deck, used on no other legal page
     C10 floating decorative accent at 5% opacity
     C12 responsive data table that reflows to stacked rows on mobile
   ============================================================ */

.pp-body { background: var(--color-white); }

/* C10 · floating accent behind the prose column */
.pp-body::before {
  content: '';
  position: absolute;
  top: var(--space-16);
  right: calc(var(--space-16) * -1);
  width: 340px;
  height: 340px;
  border-radius: var(--radius-full);
  background: var(--color-primary);
  opacity: 0.05;
  pointer-events: none;
}

/* ── Table of contents ────────────────────────────────────────*/
.pp-toc {
  max-width: 65ch;
  margin: 0 auto var(--space-16);
  padding: var(--space-6);
  border: 1px solid var(--color-gray-light);
  border-radius: var(--radius-lg);
  background: var(--color-light);
}
.pp-toc__title {
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--color-gray);
  margin-bottom: var(--space-4);
}
.pp-toc ol {
  margin: 0;
  padding-left: var(--space-5);
  columns: 2;
  column-gap: var(--space-8);
}
.pp-toc li { margin-bottom: var(--space-2); break-inside: avoid; }
.pp-toc a {
  color: var(--color-primary);
  font-size: var(--font-size-sm);
  border-bottom: 1px solid transparent;
  transition: border-color var(--transition-fast);
}
.pp-toc a:hover { border-bottom-color: var(--color-primary); }

/* ── C7 · SIGNATURE — the rights card deck ────────────────────
   Six CCPA/CPRA rights as scannable cards rather than a bullet list.
   These are the sentences a California resident actually came for, and
   a <ul> buries them. This composition appears on no other page. */
.pp-rights {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--space-4);
  margin: var(--space-6) 0 var(--space-8);
}
.pp-right {
  padding: var(--space-5);
  border-radius: var(--radius-md);
  border: 1px solid var(--color-gray-light);
  background: var(--color-white);
  transition: border-color var(--transition-base), transform var(--transition-base);
}
.pp-right:hover { border-color: var(--color-accent); transform: translateY(-2px); }
.pp-right__head {
  display: flex;
  align-items: center;
  gap: var(--space-3);
  margin-bottom: var(--space-2);
}
.pp-right__icon {
  width: 34px; height: 34px;
  flex-shrink: 0;
  border-radius: var(--radius-sm);
  background: var(--color-card-tint-1);
  display: grid;
  place-items: center;
  color: var(--color-primary);
}
.pp-right__icon i, .pp-right__icon svg { width: 17px; height: 17px; }
.pp-right h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-base);
  color: var(--color-primary-dark);
  margin: 0;
}
.pp-right p {
  font-size: var(--font-size-sm);
  line-height: 1.6;
  color: var(--color-gray-dark);
  margin: 0;
}

/* ── C12 · Processor table ────────────────────────────────────
   Reflows to stacked, labelled rows below 700px — a 3-column table on a
   375px viewport is unreadable at any font size. */
.pp-table-wrap { margin: var(--space-6) 0 var(--space-8); }
.pp-table {
  width: 100%;
  border-collapse: collapse;
  font-size: var(--font-size-sm);
  border: 1px solid var(--color-gray-light);
  border-radius: var(--radius-md);
  overflow: hidden;
}
.pp-table thead { background: var(--color-primary); }
.pp-table th {
  text-align: left;
  padding: var(--space-3) var(--space-4);
  color: var(--color-white);
  font-family: var(--font-heading);
  font-weight: 600;
}
.pp-table td {
  padding: var(--space-3) var(--space-4);
  border-top: 1px solid var(--color-gray-light);
  color: var(--color-gray-dark);
  vertical-align: top;
  line-height: 1.6;
}
.pp-table tbody tr:nth-child(even) { background: var(--color-light); }
.pp-table td strong { color: var(--color-black); }

/* ── Data ledger ──────────────────────────────────────────────*/
.pp-ledger { list-style: none; margin: var(--space-6) 0 var(--space-8); padding: 0; }
.pp-ledger li {
  display: flex;
  gap: var(--space-4);
  align-items: flex-start;
  padding: var(--space-4) 0;
  border-bottom: 1px solid var(--color-gray-light);
}
.pp-ledger li:last-child { border-bottom: 0; }
.pp-ledger i, .pp-ledger svg {
  width: 18px; height: 18px;
  flex-shrink: 0;
  margin-top: 3px;
  color: var(--color-accent);
}
.pp-ledger p { margin: 0; font-size: var(--font-size-sm); line-height: 1.65; }
.pp-ledger strong { display: block; color: var(--color-black); margin-bottom: var(--space-1); }

/* The "we do not sell" statement earns its own treatment. */
.pp-nosale {
  display: flex;
  gap: var(--space-4);
  align-items: center;
  padding: var(--space-5) var(--space-6);
  border-radius: var(--radius-md);
  background: var(--color-card-tint-1);
  border: 1px solid var(--color-primary);
  margin: var(--space-6) 0;
}
.pp-nosale i, .pp-nosale svg { width: 26px; height: 26px; flex-shrink: 0; color: var(--color-primary); }
.pp-nosale p {
  margin: 0;
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  color: var(--color-primary-dark);
  line-height: 1.4;
  text-wrap: balance;
}

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 900px) {
  .pp-rights { grid-template-columns: 1fr; }
  .pp-toc ol { columns: 1; }
  .pp-body::before { display: none; }
}
@media (max-width: 700px) {
  .pp-table thead { display: none; }
  .pp-table, .pp-table tbody, .pp-table tr, .pp-table td { display: block; width: 100%; }
  .pp-table tr {
    border-top: 1px solid var(--color-gray-light);
    padding: var(--space-2) 0;
  }
  .pp-table td { border-top: 0; padding: var(--space-2) var(--space-4); }
  .pp-table td::before {
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

/* ── Deep-linked section ──────────────────────────────────────
   /privacy-policy/#ccpa-rights is linked from the footer of EVERY page.
   The framework's :target flash marks it; this clears the fixed navbar so
   the heading is not hidden behind it on arrival. */
.legal-prose h2:target,
.legal-prose h3:target { scroll-margin-top: calc(var(--nav-height) + var(--space-8)); }

/* ── List markers ─────────────────────────────────────────────*/
.legal-prose ul li::marker,
.legal-prose ol li::marker { color: var(--color-accent); }
.pp-ledger li::marker { content: none; }

/* Brand-green selection. */
.pp-body ::selection { background: rgba(var(--color-accent-rgb), 0.25); color: var(--color-black); }

/* ── Focus states ─────────────────────────────────────────────*/
.pp-toc a:focus-visible,
.legal-prose a:focus-visible,
.legal-contact a:focus-visible {
  outline: 2px solid var(--color-accent);
  outline-offset: 2px;
  border-radius: var(--radius-sm);
  border-bottom-color: transparent;
}
.pp-right:focus-within { border-color: var(--color-accent); }

/* ── Reduced motion ───────────────────────────────────────────
   Pointer-driven transforms the global duration reset cannot reach. */
@media (prefers-reduced-motion: reduce) {
  .pp-right:hover { transform: none; }
}

/* ── Windows High Contrast / forced-colors ────────────────────
   The "we do not sell" banner, the rights cards, and the zebra-striped
   table all carry meaning through background colour, which forced-colors
   discards wholesale. Restore each boundary as a real border. */
@media (forced-colors: active) {
  .pp-right, .pp-nosale, .pp-toc,
  .legal-contact, .legal-disclaimer { border: 1px solid CanvasText; }
  .pp-right__icon { border: 1px solid CanvasText; }
  .pp-table, .pp-table td, .pp-table th { border: 1px solid CanvasText; }
  .pp-table tbody tr:nth-child(even) { background: Canvas; }
  .legal-prose :target { animation: none; outline: 2px solid Highlight; }
}

/* ── Wide viewports ───────────────────────────────────────────
   The processor table wants more room than the 65ch prose column, and it
   is not prose. Let it breathe without breaking the reading measure. */
@media (min-width: 1200px) {
  .pp-table-wrap {
    width: calc(100% + var(--space-16));
    margin-inline: calc(var(--space-8) * -1);
  }
}

/* ── Print ────────────────────────────────────────────────────
   Legal documents get printed and taken to lawyers. Make that not terrible:
   expand link targets, keep the rights cards and the processor table whole,
   and never orphan a heading from the section it introduces. */
@media print {
  @page { margin: 2cm; }

  .site-header, .site-footer, .cookie-banner, .mobile-cta-bar,
  .back-to-top, .pp-toc, .hero--legal .breadcrumb { display: none !important; }

  .hero.hero--legal { min-height: auto; padding-block: var(--space-4); background: none; }
  .hero.hero--legal::after { display: none; }
  .hero--legal h1, .hero--legal .eyebrow-label, .legal-stamp { color: var(--color-black); }
  .legal-stamp { border: 1px solid var(--color-black); background: none; backdrop-filter: none; }
  .pp-body::before { display: none; }

  .legal-prose { max-width: none; }
  .legal-prose h2, .legal-prose h3 { break-after: avoid; }
  .legal-prose p, .legal-prose li { orphans: 3; widows: 3; }

  .pp-rights { display: block; }
  .pp-right, .pp-nosale, .pp-ledger li,
  .legal-contact, .legal-disclaimer { break-inside: avoid; border: 1px solid var(--color-black); background: none; }
  .pp-right { margin-bottom: var(--space-3); }

  .pp-table-wrap { width: auto; margin-inline: 0; break-inside: avoid; }
  .pp-table { box-shadow: none; }
  .pp-table thead { background: none; }
  .pp-table th { color: var(--color-black); border-bottom: 2px solid var(--color-black); }
  .pp-table tbody tr:nth-child(even) { background: none; }

  /* A printed hyperlink with no visible target is a dead reference. */
  .legal-prose a[href^="http"]::after { content: " (" attr(href) ")"; font-size: 0.85em; word-break: break-all; }
  .legal-prose a[href^="/"]::after    { content: " (<?php echo e($siteUrl); ?>" attr(href) ")"; font-size: 0.85em; word-break: break-all; }
  .legal-prose a { border-bottom: 0; color: var(--color-black); }
}
</style>

<!-- ══════════ HERO ══════════ -->
<section class="hero hero--legal" aria-label="Privacy Policy">
    <div class="container">

        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                <li><span aria-current="page">Privacy Policy</span></li>
            </ol>
        </nav>

        <span class="eyebrow-label">Legal</span>
        <h1>Privacy Policy</h1>

        <span class="legal-stamp">
            <i data-lucide="calendar" aria-hidden="true"></i>
            Effective &amp; Last Updated: <?php echo e($lastUpdated); ?>
        </span>

    </div>
</section>

<!-- ══════════ BODY ══════════ -->
<section class="pp-body" aria-label="Privacy Policy content">
    <div class="container">

        <nav class="pp-toc" aria-label="On this page">
            <p class="pp-toc__title">On this page</p>
            <ol>
                <li><a href="#introduction">Introduction</a></li>
                <li><a href="#what-we-collect">What we collect</a></li>
                <li><a href="#how-we-use">How we use it</a></li>
                <li><a href="#how-we-share">How we share it</a></li>
                <li><a href="#your-rights">Your privacy rights</a></li>
                <li><a href="#ccpa-rights">California rights</a></li>
                <li><a href="#sms">SMS &amp; phone (TCPA)</a></li>
                <li><a href="#retention">Data retention</a></li>
                <li><a href="#security">Data security</a></li>
                <li><a href="#children">Children's privacy</a></li>
                <li><a href="#third-party">Third-party links</a></li>
                <li><a href="#changes">Changes</a></li>
                <li><a href="#contact">Contact us</a></li>
            </ol>
        </nav>

        <article class="legal-prose">

            <h2 id="introduction">1. Introduction</h2>
            <p>
                This Privacy Policy explains how <strong><?php echo e($legalEntityName); ?></strong>
                ("Greenville Lawn Masters", "we", "us", "our") collects, uses, and protects your personal
                information when you visit <?php echo e($domain); ?> or contact us about lawn care services
                in <?php echo e($address['city']); ?>, <?php echo e($companyState); ?>.
            </p>
            <p>
                We are a lawn care and landscape maintenance company, not a data business. We collect what
                we need to walk your property, quote the work, and do the job.
            </p>

            <h2 id="what-we-collect">2. Information We Collect</h2>
            <ul class="pp-ledger">
                <li>
                    <i data-lucide="user" aria-hidden="true"></i>
                    <p>
                        <strong>Information you give us</strong>
                        Your name, phone number, email address, the service you are interested in, and
                        anything you type into the message field of a contact form. We also record which
                        consent checkboxes you ticked, the page you were on when you ticked them, and the
                        version of the consent language you agreed to.
                    </p>
                </li>
                <li>
                    <i data-lucide="map-pin" aria-hidden="true"></i>
                    <p>
                        <strong>Property information</strong>
                        The address and condition of the property to be serviced, gathered during the
                        estimate walkthrough and while performing work.
                    </p>
                </li>
                <li>
                    <i data-lucide="server" aria-hidden="true"></i>
                    <p>
                        <strong>Collected automatically when you submit a form</strong>
                        Your IP address, browser user-agent string, and a timestamp. These are recorded
                        alongside your consent choices as a record that consent was given, which is a
                        requirement of federal and state telemarketing law.
                    </p>
                </li>
                <li>
                    <i data-lucide="bar-chart-3" aria-hidden="true"></i>
                    <p>
                        <strong>Analytics, when enabled</strong>
                        Pages visited, referring URL, approximate region, device type. Google Analytics 4
                        is configured on this site but is currently disabled. If and when it is enabled,
                        it will set the cookies described in our <a href="/cookie-policy/">Cookie Policy</a>.
                    </p>
                </li>
                <li>
                    <i data-lucide="cookie" aria-hidden="true"></i>
                    <p>
                        <strong>Cookies and local storage</strong>
                        A single browser storage flag remembering that you dismissed the cookie notice.
                        See the <a href="/cookie-policy/">Cookie Policy</a> for the full list.
                    </p>
                </li>
            </ul>

            <h2 id="how-we-use">3. How We Use Your Information</h2>
            <ul>
                <li>To respond to your inquiry and schedule a property walkthrough.</li>
                <li>To prepare and send you a written estimate.</li>
                <li>To schedule, perform, and invoice the work you have accepted.</li>
                <li>To communicate with you during active work — including by phone call and, where you
                    have separately consented, by SMS text message.</li>
                <li>To send marketing emails, <strong>only</strong> if you ticked the optional email
                    consent box. You can withdraw that at any time.</li>
                <li>To keep a record of the consent you gave, as required by law.</li>
                <li>To understand how this website is used, and improve it.</li>
                <li>To comply with tax, insurance, and other legal obligations.</li>
            </ul>

            <h2 id="how-we-share">4. How We Share Your Information</h2>

            <div class="pp-nosale">
                <i data-lucide="shield-off" aria-hidden="true"></i>
                <p>We do not sell your personal information, and we never have.</p>
            </div>

            <p>
                We share information with the service providers listed below, each of which processes it
                only to provide their service to us. These are the providers this website actually uses:
            </p>

            <div class="pp-table-wrap">
                <table class="pp-table">
                    <caption class="sr-only">Third-party service providers used by this website</caption>
                    <thead>
                        <tr>
                            <th scope="col">Provider</th>
                            <th scope="col">What it does</th>
                            <th scope="col">What it receives</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td data-label="Provider"><strong>Page One Insights, LLC</strong></td>
                            <td data-label="What it does">Builds and hosts this website; operates the system that receives contact form submissions and forwards them to us.</td>
                            <td data-label="What it receives">Everything you submit through a form, plus the IP, user agent, and timestamp recorded with it.</td>
                        </tr>
                        <tr>
                            <td data-label="Provider"><strong>Hostinger</strong></td>
                            <td data-label="What it does">Web hosting.</td>
                            <td data-label="What it receives">Standard server logs, including IP addresses.</td>
                        </tr>
                        <tr>
                            <td data-label="Provider"><strong>Google Fonts</strong></td>
                            <td data-label="What it does">Serves the typefaces this site is set in.</td>
                            <td data-label="What it receives">Your IP address, as an unavoidable consequence of your browser requesting the font files.</td>
                        </tr>
                        <tr>
                            <td data-label="Provider"><strong>Google Maps</strong></td>
                            <td data-label="What it does">The service-area map embedded on our contact page.</td>
                            <td data-label="What it receives">Your IP address and Google cookies, only if you load the contact page.</td>
                        </tr>
                        <tr>
                            <td data-label="Provider"><strong>Google Analytics 4</strong></td>
                            <td data-label="What it does">Website usage analytics. <strong>Currently disabled on this site.</strong></td>
                            <td data-label="What it receives">Nothing at present. If enabled: pages visited, device type, approximate region.</td>
                        </tr>
                        <tr>
                            <td data-label="Provider"><strong>unpkg (Lucide)</strong></td>
                            <td data-label="What it does">Serves the icon library used across the site.</td>
                            <td data-label="What it receives">Your IP address, as a consequence of your browser requesting the script.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p>We may also disclose information:</p>
            <ul>
                <li><strong>To subcontractors and suppliers</strong>, only as necessary to complete work
                    you have accepted.</li>
                <li><strong>For legal compliance</strong>, where required by <?php echo e($companyState); ?>
                    or federal law, or in response to valid legal process.</li>
                <li><strong>In a business transfer</strong>, if the company is merged, acquired, or its
                    assets sold.</li>
            </ul>

            <h2 id="your-rights">5. Your Privacy Rights</h2>

            <h3>South Carolina and other state residents</h3>
            <p>
                You may ask us what personal information we hold about you, ask us to correct it, or ask
                us to delete it. Residents of Colorado, Virginia, Connecticut, Utah, Texas, and a growing
                number of other states have these rights under their own state privacy laws. Use the
                contact details in section 13 and we will respond.
            </p>

            <h2 id="ccpa-rights">6. California Residents (CCPA / CPRA)</h2>
            <p>
                If you are a California resident, the California Consumer Privacy Act as amended by the
                California Privacy Rights Act gives you the following rights. This section is what the
                "Do Not Sell or Share My Personal Information" link in our footer points to.
            </p>

            <div class="pp-rights">
                <div class="pp-right">
                    <div class="pp-right__head">
                        <div class="pp-right__icon"><i data-lucide="eye" aria-hidden="true"></i></div>
                        <h3>Right to know</h3>
                    </div>
                    <p>What personal information we collect about you, where it came from, why we have it, and who we disclose it to.</p>
                </div>
                <div class="pp-right">
                    <div class="pp-right__head">
                        <div class="pp-right__icon"><i data-lucide="trash-2" aria-hidden="true"></i></div>
                        <h3>Right to delete</h3>
                    </div>
                    <p>Have us delete the personal information we collected from you, subject to legal and warranty record-keeping exceptions.</p>
                </div>
                <div class="pp-right">
                    <div class="pp-right__head">
                        <div class="pp-right__icon"><i data-lucide="pencil" aria-hidden="true"></i></div>
                        <h3>Right to correct</h3>
                    </div>
                    <p>Have us fix personal information about you that is inaccurate.</p>
                </div>
                <div class="pp-right">
                    <div class="pp-right__head">
                        <div class="pp-right__icon"><i data-lucide="shield-off" aria-hidden="true"></i></div>
                        <h3>Right to opt out of sale or sharing</h3>
                    </div>
                    <p>We do not sell or share personal information for cross-context behavioural advertising. You may still submit an opt-out request, and we will record it.</p>
                </div>
                <div class="pp-right">
                    <div class="pp-right__head">
                        <div class="pp-right__icon"><i data-lucide="lock" aria-hidden="true"></i></div>
                        <h3>Right to limit sensitive information</h3>
                    </div>
                    <p>Restrict our use of sensitive personal information. We do not knowingly collect any.</p>
                </div>
                <div class="pp-right">
                    <div class="pp-right__head">
                        <div class="pp-right__icon"><i data-lucide="scale" aria-hidden="true"></i></div>
                        <h3>Right to non-discrimination</h3>
                    </div>
                    <p>We will not deny you service, charge you a different price, or give you a lesser service level because you exercised a privacy right.</p>
                </div>
            </div>

            <p>
                <strong>How to exercise these rights:</strong>
                <?php if ($hasEmail): ?>
                    Email <a href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a><?php if ($hasPhone): ?>,
                    call <a href="tel:<?php echo e($phoneLink); ?>"><?php echo e($phoneDisplay); ?></a>,<?php endif; ?>
                    or submit a request through our <a href="/contact/">contact form</a>.
                <?php elseif ($hasPhone): ?>
                    Call <a href="tel:<?php echo e($phoneLink); ?>"><?php echo e($phoneDisplay); ?></a> or submit a
                    request through our <a href="/contact/">contact form</a>.
                <?php else: ?>
                    <?php /* Both channels empty. We route to the form — a channel that demonstrably
                             works — rather than print an inbox that does not exist. A CCPA promise
                             we cannot receive is an unfulfillable promise. */ ?>
                    Submit a request through our <a href="/contact/">contact form</a>, stating that it is a
                    privacy rights request and which right you wish to exercise.
                <?php endif; ?>
                We will verify your identity before acting on the request, and will respond within
                <strong>45 days</strong> of receiving it, as the CCPA requires. If we need more time, we
                will tell you why within those 45 days.
            </p>
            <p>
                You may designate an authorised agent to make a request on your behalf. We will ask for
                written proof of that authorisation.
            </p>

            <h2 id="sms">7. SMS and Phone Communications (TCPA)</h2>
            <p>
                Our contact form asks for consent in three separate, unbundled checkboxes. None of them is
                pre-ticked, and <strong>only</strong> agreement to this Privacy Policy and our
                <a href="/terms/">Terms of Service</a> is required to submit the form.
            </p>
            <ul>
                <li><strong>Email consent is optional.</strong> Tick it and we may email you about our
                    services and promotions. Unsubscribe from any email using the link it contains.</li>
                <li><strong>SMS consent is optional and separate.</strong> Tick it and we may text you
                    appointment reminders, service updates, and promotional offers. Message frequency
                    varies. Message and data rates may apply.
                    <strong>Consent to receive text messages is not a condition of purchasing any
                    service.</strong> Reply <strong>STOP</strong> to any message to unsubscribe, or
                    <strong>HELP</strong> for help.</li>
                <li><strong>Neither consent is required</strong> to get an estimate, to hire us, or to be
                    contacted about a request you submitted.</li>
            </ul>
            <p>
                We honour any reasonable opt-out request, made through any reasonable method, as required
                by the FCC's April 2025 opt-out rule — including telling the crew, replying STOP,
                unsubscribing from an email, or contacting us through the form.
            </p>
            <p>
                We record the consent language version, the page you consented on, your IP address, your
                user agent, and the timestamp. That record exists to prove what you agreed to, and when.
            </p>

            <h2 id="retention">8. Data Retention</h2>
            <p>
                We keep contact form submissions and service records for as long as needed to provide the
                service and to satisfy legal, tax, and warranty obligations — typically five to seven
                years for business records. Consent records are retained for at least four years after the
                consent is withdrawn or the relationship ends, which is the federal limitations period for
                a TCPA claim. Marketing contact details are deleted on request.
            </p>

            <h2 id="security">9. Data Security</h2>
            <p>
                This site is served over HTTPS, and every form submission is encrypted in transit. Access
                to lead records is limited to the people who need it to do the work. No system is perfectly
                secure, and we do not claim otherwise; we take reasonable administrative, technical, and
                physical measures to reduce the risk.
            </p>

            <h2 id="children">10. Children's Privacy</h2>
            <p>
                This website is not directed to children under 13, and we do not knowingly collect personal
                information from them. If you believe a child has given us information, contact us and we
                will delete it.
            </p>

            <h2 id="third-party">11. Third-Party Links</h2>
            <p>
                This site links to third-party websites, including Google Maps and Page One Insights. We do
                not control those sites and are not responsible for their privacy practices. Read their
                policies separately.
            </p>

            <h2 id="changes">12. Changes to This Policy</h2>
            <p>
                We may update this Privacy Policy. The "Last Updated" date at the top of this page reflects
                the most recent change, and material changes will be posted prominently on the site.
            </p>

            <h2 id="contact">13. Contact Us</h2>
            <p>For privacy questions, or to exercise any right described above:</p>

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
                    This Privacy Policy is provided as a general template. We recommend reviewing this
                    document with a licensed <?php echo e($companyState); ?> attorney before publication to
                    ensure compliance with current state and federal privacy laws.
                </span>
            </div>

        </article>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
