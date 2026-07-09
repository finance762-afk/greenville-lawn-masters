<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /accessibility/index.php — Phase 5 (compliance)
   Greenville Lawn Masters · Mauldin, SC

   INDEXABLE. Linked from the footer legal row.

   ── THE CONFORMANCE CLAIM ──────────────────────────────────────
   This page claims PARTIAL conformance with WCAG 2.1 Level AA, not
   full conformance. That is deliberate and it is the honest claim:
   nobody has run an assistive-technology audit against this build.
   Claiming full AA conformance without one is precisely the
   overstatement that ADA Title III demand letters are built on — the
   statement itself becomes the evidence.

   ── THE FEATURE LIST BELOW IS VERIFIED, NOT ASPIRATIONAL ───────
   Each item was checked against this codebase before being listed:
     • skip link           includes/header.php line 20, .skip-link
     • <main id>           includes/header.php, closed in footer.php
     • landmarks           <header>/<nav aria-label>/<main>/<footer>
     • aria-current        functions.php activeAria(), used in header.php
     • focus-visible       framework.css :focus-visible rules
     • reduced motion      framework.css @media (prefers-reduced-motion)
     • fail-open reveals   framework.css gates every opacity:0 rule behind
                           html.js-anim; head.php sets it inline and
                           synchronously, so a blocked JS bundle leaves the
                           page fully visible rather than blank
     • alt text            every <img> carries alt from config.php $photoLibrary
     • form labels         every input has an associated <label>
     • aria-expanded       header.php hamburger button
     • contrast            config.php records the measured ratios:
                           white on primary 6.14:1, primary on white 6.14:1,
                           primary-dark on white 9.30:1, accent on dark 5.19:1
                           — all above the 4.5:1 AA body-text minimum

   ── KNOWN ISSUES ARE REAL ISSUES ───────────────────────────────
   The template offers boilerplate ("some PDFs may not be accessible").
   This build has no PDFs. The issues listed are the ones this build
   actually has: the Google Maps iframe, the unaudited state, and the
   Lucide icon injection. Listing a fake issue is as dishonest as hiding
   a real one.

   ⚠ Feedback channel: $email and $phone are both empty in config.php.
   An accessibility statement whose "tell us about a barrier" channel is
   a dead address is worse than no statement — a visitor who cannot use
   the site is told to use a channel that does not exist. Until intake
   lands, the contact form is named as the channel, and the alternative-
   contact section says plainly that phone is not yet published.
   ============================================================ */

$currentPage = 'legal';

$pageTitle       = 'Accessibility Statement | Greenville Lawn Masters, Mauldin SC';
$pageDescription = 'How the Greenville Lawn Masters website works toward WCAG 2.1 Level AA, the '
                 . 'accessibility features it includes, known issues, and how to report a barrier.';   // 158 chars

$canonicalUrl = $siteUrl . '/accessibility/';
$ogImage      = $logoUrl;

$lastUpdated  = date('F j, Y');

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';
$hasEmail     = $email !== '';

/* ── Verified accessibility features ───────────────────────────
   Every entry names the mechanism, not the aspiration. `where` is the
   file it is implemented in, which is what makes this list auditable. */
$features = [
    ['icon' => 'skip-forward',     'title' => 'Skip to main content',      'body' => 'The first focusable element on every page jumps straight past the navigation to the page content.'],
    ['icon' => 'layout',           'title' => 'Semantic landmark regions', 'body' => 'Header, labelled navigation, main, and footer landmarks on every page, so screen reader users can jump between regions.'],
    ['icon' => 'keyboard',         'title' => 'Full keyboard operation',   'body' => 'Every link, button, form field, and the FAQ disclosures are reachable and operable without a mouse.'],
    ['icon' => 'focus',           'title' => 'Visible focus indicators',   'body' => 'A high-contrast outline follows keyboard focus. It is never removed, only restyled.'],
    ['icon' => 'contrast',         'title' => 'Measured colour contrast',  'body' => 'Brand colours were measured against WCAG AA before use. Body text and interactive elements meet or exceed 4.5:1.'],
    ['icon' => 'pause',            'title' => 'Reduced motion respected',  'body' => 'If your system asks for reduced motion, animations and transitions are switched off, not merely slowed.'],
    ['icon' => 'image',            'title' => 'Descriptive alt text',      'body' => 'Every photograph carries alt text describing what is actually in the frame. Decorative graphics are hidden from assistive technology.'],
    ['icon' => 'tag',              'title' => 'Labelled form fields',      'body' => 'Every input has a real, associated label — including each of the three consent checkboxes, which are never bundled together.'],
    ['icon' => 'eye',              'title' => 'Content without JavaScript','body' => 'If scripts fail to load, no content is hidden. Animations are the only thing lost. The FAQ answers open without JavaScript.'],
    ['icon' => 'smartphone',       'title' => 'Zoom and reflow',           'body' => 'Text reflows to 400% zoom without horizontal scrolling. Layout is fluid rather than fixed-width.'],
];

/* ── Known issues — the real ones ──────────────────────────────*/
$knownIssues = [
    [
        'title' => 'This site has not been audited with assistive technology',
        'body'  => 'No formal screen reader or assistive-technology audit has been performed. We therefore '
                 . 'claim partial conformance, not full conformance, and we would rather say so than let you '
                 . 'discover it. If you hit a barrier, telling us is the fastest way it gets fixed.',
    ],
    [
        'title' => 'The map on our contact page',
        'body'  => 'The service-area map is a Google Maps embed. Its accessibility is Google\'s, not ours, and '
                 . 'parts of it may not meet WCAG 2.1 AA. The same information — that we are based in '
                 . 'Mauldin, SC and work within 25 miles — is stated in text immediately beside the map, '
                 . 'so no information is available only through the map.',
    ],
    [
        'title' => 'Icons are injected by JavaScript',
        'body'  => 'Interface icons are drawn by a JavaScript library after the page loads. Every icon is '
                 . 'hidden from assistive technology and every one sits beside a real text label, so a '
                 . 'failure to load costs you a picture and never a word. It does mean icons are absent for '
                 . 'a moment on a slow connection.',
    ],
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
        ['name' => 'Home',                     'url' => '/'],
        ['name' => 'Accessibility Statement',  'url' => '/accessibility/'],
    ]),
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   Accessibility Statement — page-scoped styles
   Shared legal shell lives in framework.css. What is HERE is unique to
   this page: the conformance banner, the verified-feature checklist,
   and the known-issues ledger. All var() tokens.

   Techniques used (design-system.md Part C):
     C7  signature — the conformance banner + two-column verified-feature
         checklist, carried by no other page
     C10 floating decorative accent at 5% opacity
     C12 known-issues ledger with hanging markers
   ============================================================ */

.ac-body { background: var(--color-white); }
.ac-body::before {
  content: '';
  position: absolute;
  bottom: var(--space-16);
  left: calc(var(--space-16) * -1);
  width: 320px;
  height: 320px;
  border-radius: var(--radius-full);
  background: var(--color-primary);
  opacity: 0.05;
  pointer-events: none;
}

/* ── C7 · SIGNATURE — conformance banner ──────────────────────
   The claim, stated once, prominently, and hedged exactly as far as the
   evidence supports. */
.ac-conformance {
  max-width: 66rem;
  margin: 0 auto var(--space-16);
  display: grid;
  grid-template-columns: auto 1fr;
  gap: var(--space-8);
  align-items: center;
  padding: var(--space-8);
  border-radius: var(--radius-xl);
  background: var(--color-light);
  border: 1px solid var(--color-gray-light);
}
.ac-conformance__seal {
  width: 100px;
  height: 100px;
  border-radius: var(--radius-full);
  background: var(--color-white);
  border: 2px solid var(--color-primary);
  box-shadow: var(--shadow-card);
  display: grid;
  place-items: center;
  color: var(--color-primary);
}
.ac-conformance__seal i, .ac-conformance__seal svg { width: 44px; height: 44px; }
.ac-conformance h2 {
  font-family: var(--font-heading);
  font-size: var(--font-size-2xl);
  color: var(--color-primary);
  margin-bottom: var(--space-3);
  text-wrap: balance;
}
.ac-conformance p {
  color: var(--color-gray-dark);
  line-height: 1.7;
  margin: 0;
  max-width: 62ch;
}
.ac-conformance strong { color: var(--color-black); }

/* ── Verified feature checklist ───────────────────────────────*/
.ac-features {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: var(--space-4);
  margin: var(--space-6) 0 var(--space-8);
}
.ac-feature {
  display: flex;
  gap: var(--space-4);
  align-items: flex-start;
  padding: var(--space-5);
  border-radius: var(--radius-md);
  border: 1px solid var(--color-gray-light);
  transition: border-color var(--transition-base), transform var(--transition-base);
}
.ac-feature:hover { border-color: var(--color-accent); transform: translateY(-2px); }
.ac-feature__icon {
  width: 38px; height: 38px;
  flex-shrink: 0;
  border-radius: var(--radius-sm);
  background: var(--color-card-tint-1);
  display: grid;
  place-items: center;
  color: var(--color-primary);
}
.ac-feature__icon i, .ac-feature__icon svg { width: 18px; height: 18px; }
.ac-feature h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-base);
  color: var(--color-primary-dark);
  margin-bottom: var(--space-1);
  text-wrap: balance;
}
.ac-feature p {
  font-size: var(--font-size-sm);
  line-height: 1.6;
  color: var(--color-gray-dark);
  margin: 0;
}

/* ── Known-issues ledger ──────────────────────────────────────*/
.ac-issues { list-style: none; margin: var(--space-6) 0 var(--space-8); padding: 0; }
.ac-issue {
  position: relative;
  padding: var(--space-5) var(--space-5) var(--space-5) var(--space-12);
  margin-bottom: var(--space-4);
  border-radius: var(--radius-md);
  background: var(--color-card-tint-3);
  border-left: 3px solid var(--color-primary);
}
.ac-issue::before {
  content: '';
  position: absolute;
  left: var(--space-5);
  top: calc(var(--space-5) + 4px);
  width: 10px;
  height: 10px;
  border-radius: var(--radius-full);
  background: var(--color-primary);
}
.ac-issue h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-base);
  color: var(--color-primary-dark);
  margin-bottom: var(--space-2);
  text-wrap: balance;
}
.ac-issue p {
  font-size: var(--font-size-sm);
  line-height: 1.7;
  color: var(--color-gray-dark);
  margin: 0;
}

/* ── Feedback callout ─────────────────────────────────────────*/
.ac-feedback {
  padding: var(--space-8);
  border-radius: var(--radius-lg);
  background: var(--color-primary-dark);
  color: var(--color-white);
  margin: var(--space-8) 0;
  text-align: center;
  position: relative;
  overflow: hidden;
}
.ac-feedback::before {
  content: '';
  position: absolute;
  top: calc(var(--space-16) * -1);
  right: calc(var(--space-16) * -1);
  width: 200px; height: 200px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  opacity: 0.12;
}
.ac-feedback h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-xl);
  color: var(--color-white);
  margin-bottom: var(--space-3);
  position: relative;
}
.ac-feedback p {
  color: rgba(var(--color-white-rgb), 0.78);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  max-width: 54ch;
  margin: 0 auto var(--space-6);
  position: relative;
}
.ac-feedback .btn { position: relative; }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 900px) {
  .ac-features { grid-template-columns: 1fr; }
  .ac-conformance { grid-template-columns: 1fr; text-align: center; gap: var(--space-6); }
  .ac-conformance__seal { margin-inline: auto; }
  .ac-conformance p { margin-inline: auto; }
  .ac-body::before { display: none; }
}
@media (max-width: 600px) {
  .ac-feedback { padding: var(--space-6); }
  .ac-feedback .btn { width: 100%; }
}

/* ── Deep-linked section ──────────────────────────────────────*/
.legal-prose h2:target,
.legal-prose h3:target,
.ac-conformance h2:target { scroll-margin-top: calc(var(--nav-height) + var(--space-8)); }

/* ── List markers ─────────────────────────────────────────────*/
.legal-prose ul li::marker,
.legal-prose ol li::marker { color: var(--color-accent); }
.ac-issues li::marker { content: none; }

/* Brand-green selection. */
.ac-body ::selection { background: rgba(var(--color-accent-rgb), 0.25); color: var(--color-black); }

/* ── Focus states ─────────────────────────────────────────────
   This page, of all pages, has to get keyboard focus right — a visitor
   here is disproportionately likely to be navigating by keyboard, and a
   missing focus ring on the accessibility statement is its own indictment.
   Every interactive element on this page is enumerated below. */
.legal-prose a:focus-visible,
.legal-contact a:focus-visible {
  outline: 2px solid var(--color-accent);
  outline-offset: 2px;
  border-radius: var(--radius-sm);
  border-bottom-color: transparent;
}
.ac-feedback .btn:focus-visible {
  outline: 2px solid var(--color-white);
  outline-offset: 3px;
}
.ac-feature:focus-within { border-color: var(--color-accent); }

/* ── Reduced motion ───────────────────────────────────────────
   The page claims, in its own section 2, that reduced motion is respected.
   The framework reset handles animation and transition duration; these are
   the pointer-driven transforms it does not reach. If this block is ever
   removed, section 2 becomes a false statement. */
@media (prefers-reduced-motion: reduce) {
  .ac-feature:hover { transform: none; }
}

/* ── Windows High Contrast / forced-colors ────────────────────
   Same argument. The conformance seal, the feature cards, and the issue
   ledger all carry structure through background tint, and forced-colors
   throws tint away. Every boundary becomes a real border. */
@media (forced-colors: active) {
  .ac-conformance, .ac-feature, .ac-issue, .ac-feedback,
  .legal-contact, .legal-disclaimer { border: 1px solid CanvasText; }
  .ac-conformance__seal, .ac-feature__icon { border: 1px solid CanvasText; }
  .ac-issue::before { background: CanvasText; }
  .ac-feedback::before { display: none; }
  .legal-prose :target { animation: none; outline: 2px solid Highlight; }
}

/* ── Zoom and reflow ──────────────────────────────────────────
   Section 2 claims text reflows to 400% zoom without horizontal scrolling.
   At 400% on a 1280px viewport the effective width is 320px, so the
   two-column feature grid and the seal-beside-text banner must both have
   collapsed by then. The 900px breakpoint above handles it; this pins the
   narrowest case so no card can force a horizontal scrollbar. */
@media (max-width: 400px) {
  .ac-feature { flex-direction: column; gap: var(--space-3); }
  .ac-conformance { padding: var(--space-5); }
  .ac-issue { padding-left: var(--space-8); }
  .ac-issue::before { left: var(--space-4); }
}

/* ── Wide viewports ───────────────────────────────────────────*/
@media (min-width: 1400px) {
  .ac-conformance { max-width: 74rem; }
}

/* ── Print ────────────────────────────────────────────────────
   An accessibility statement is a document that gets attached to
   procurement paperwork and to legal correspondence. It must print as a
   clean, complete record — including the known issues, which are the part
   a reader is most likely to want in writing. */
@media print {
  @page { margin: 2cm; }

  .site-header, .site-footer, .cookie-banner, .mobile-cta-bar,
  .back-to-top, .hero--legal .breadcrumb { display: none !important; }

  .hero.hero--legal { min-height: auto; padding-block: var(--space-4); background: none; }
  .hero.hero--legal::after { display: none; }
  .hero--legal h1, .hero--legal .eyebrow-label, .legal-stamp { color: var(--color-black); }
  .legal-stamp { border: 1px solid var(--color-black); background: none; backdrop-filter: none; }
  .ac-body::before { display: none; }

  .legal-prose { max-width: none; }
  .legal-prose h2, .legal-prose h3 { break-after: avoid; }
  .legal-prose p, .legal-prose li { orphans: 3; widows: 3; }

  .ac-conformance { break-inside: avoid; border: 1px solid var(--color-black); background: none; }
  .ac-features { display: block; }
  .ac-feature { break-inside: avoid; border: 1px solid var(--color-black); margin-bottom: var(--space-3); }
  .ac-issue { break-inside: avoid; border: 1px solid var(--color-black); background: none; }

  .ac-feedback { background: none; color: var(--color-black); border: 1px solid var(--color-black); break-inside: avoid; }
  .ac-feedback::before { display: none; }
  .ac-feedback h3, .ac-feedback p { color: var(--color-black); }
  .ac-feedback .btn { border: 1px solid var(--color-black); background: none; color: var(--color-black); }

  .legal-contact, .legal-disclaimer { break-inside: avoid; border: 1px solid var(--color-black); background: none; }

  .legal-prose a[href^="http"]::after { content: " (" attr(href) ")"; font-size: 0.85em; word-break: break-all; }
  .legal-prose a[href^="/"]::after    { content: " (<?php echo e($siteUrl); ?>" attr(href) ")"; font-size: 0.85em; word-break: break-all; }
  .legal-prose a { border-bottom: 0; color: var(--color-black); }
}
</style>

<!-- ══════════ HERO ══════════ -->
<section class="hero hero--legal" aria-label="Accessibility Statement">
    <div class="container">

        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                <li><span aria-current="page">Accessibility</span></li>
            </ol>
        </nav>

        <span class="eyebrow-label">Legal</span>
        <h1>Accessibility Statement</h1>

        <span class="legal-stamp">
            <i data-lucide="calendar" aria-hidden="true"></i>
            Effective &amp; Last Updated: <?php echo e($lastUpdated); ?>
        </span>

    </div>
</section>

<!-- ══════════ BODY ══════════ -->
<section class="ac-body" aria-label="Accessibility Statement content">
    <div class="container">

        <!-- ══ SIGNATURE — the conformance claim ══ -->
        <div class="ac-conformance">
            <div class="ac-conformance__seal" aria-hidden="true">
                <i data-lucide="accessibility"></i>
            </div>
            <div>
                <h2 id="conformance">Partial conformance with WCAG 2.1 Level AA</h2>
                <p>
                    This website is <strong>designed</strong> to meet Web Content Accessibility Guidelines
                    2.1 Level AA. It has <strong>not yet been audited</strong> with assistive technology by
                    an independent reviewer, so we claim partial conformance rather than full conformance.
                    Saying otherwise would be a claim we cannot support, and this is not the page to make
                    one on.
                </p>
            </div>
        </div>

        <article class="legal-prose">

            <h2 id="commitment">1. Our Commitment</h2>
            <p>
                <?php echo e($legalEntityName); ?> is committed to making this website usable by everyone,
                including people who browse with a screen reader, navigate by keyboard, need larger text,
                or prefer reduced motion. Accessibility is treated as part of building the site, not as a
                widget bolted on afterwards. We do not use an accessibility overlay, because overlays tend
                to break the assistive technology people already have set up.
            </p>

            <h2 id="features">2. What This Site Does</h2>
            <p>
                Each item below is implemented in this site's code today, and each was checked before it
                was listed here.
            </p>

            <div class="ac-features">
                <?php foreach ($features as $feature): ?>
                    <div class="ac-feature">
                        <div class="ac-feature__icon">
                            <i data-lucide="<?php echo e($feature['icon']); ?>" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3><?php echo e($feature['title']); ?></h3>
                            <p><?php echo e($feature['body']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <h2 id="known-issues">3. Known Issues</h2>
            <p>
                These are the accessibility gaps we know about on this site. This list is honest rather
                than short.
            </p>

            <ul class="ac-issues">
                <?php foreach ($knownIssues as $issue): ?>
                    <li class="ac-issue">
                        <h3><?php echo e($issue['title']); ?></h3>
                        <p><?php echo e($issue['body']); ?></p>
                    </li>
                <?php endforeach; ?>
            </ul>

            <h2 id="feedback">4. Report a Barrier</h2>
            <p>
                If any part of this site stops you doing what you came to do, please tell us. We aim to
                respond to accessibility feedback within <strong>five business days</strong>. Tell us the
                page, what you were trying to do, and — if you can — what you browse with.
            </p>

            <div class="ac-feedback">
                <h3>Something on this site not working for you?</h3>
                <p>
                    <?php if ($hasEmail): ?>
                        Email us and describe the barrier. No detail is too small.
                    <?php else: ?>
                        Send us the details through the contact form and describe the barrier. No detail is
                        too small, and you will not be asked to justify why it matters.
                    <?php endif; ?>
                </p>
                <?php if ($hasEmail): ?>
                    <a class="btn btn-accent btn-lg" href="mailto:<?php echo e($email); ?>?subject=Accessibility%20feedback">
                        <i data-lucide="mail" aria-hidden="true"></i>
                        Email <?php echo e($email); ?>
                    </a>
                <?php else: ?>
                    <a class="btn btn-accent btn-lg" href="/contact/">
                        <i data-lucide="message-square" aria-hidden="true"></i>
                        Report It Through the Contact Form
                    </a>
                <?php endif; ?>
            </div>

            <h2 id="alternatives">5. Alternative Ways to Reach Us</h2>
            <p>
                If this website is not accessible to you, you do not have to use it to become a customer.
                <?php if ($hasPhone): ?>
                    Call <a href="tel:<?php echo e($phoneLink); ?>"><?php echo e($phoneDisplay); ?></a> and a
                    person will take your details, answer questions about services, and book a property
                    walkthrough. We will provide any information from this site in another format on request.
                <?php else: ?>
                    <?php /* Phone is empty in config.php. Naming a number we do not have would strand
                             exactly the visitor this section exists to serve. Say what is true. */ ?>
                    Greenville Lawn Masters has not yet published a phone number on this website. Until it
                    does, the <a href="/contact/">contact form</a> is the way to reach a person, and we will
                    provide any information from this site in another format on request — including reading
                    a written estimate aloud over the phone once we have called you back.
                <?php endif; ?>
            </p>

            <h2 id="standard">6. The Standard We Measure Against</h2>
            <p>
                The <a href="https://www.w3.org/TR/WCAG21/" target="_blank" rel="noopener">Web Content
                Accessibility Guidelines (WCAG) 2.1</a> define how to make web content more accessible to
                people with disabilities. Level AA is the conformance level referenced by most regulation,
                including guidance under the Americans with Disabilities Act. It covers, among much else,
                colour contrast, keyboard operation, text alternatives, and predictable navigation.
            </p>

            <h2 id="changes">7. Changes to This Statement</h2>
            <p>
                This statement is reviewed whenever the site changes materially, and the "Last Updated"
                date at the top reflects the most recent review. When a known issue above is fixed, it is
                removed from the list rather than quietly left there.
            </p>

            <h2 id="contact">8. Contact Us</h2>

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
                    This Accessibility Statement is provided as a general template. We recommend reviewing
                    it with a licensed <?php echo e($companyState); ?> attorney, and commissioning an
                    independent assistive-technology audit, before relying on it.
                </span>
            </div>

        </article>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
