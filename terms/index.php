<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /terms/index.php — Phase 5 (compliance)
   Greenville Lawn Masters · Mauldin, SC

   INDEXABLE. Linked only from the footer legal row.

   ── DEVIATIONS FROM legal-compliance.md's TEMPLATE, AND WHY ────
   The reference template was written for a roofing contractor. Three of
   its clauses are actively wrong on a lawn care site, and one is a claim
   this build has no basis to make:

   1. §4 "We are licensed and insured to operate in the state of [State]"
      — REMOVED. build-plan.json supplied no licence number and no
      certificate of insurance. Asserting licensure in a contract document
      is the single most expensive place in the build to be wrong about it.
      Every other page in this build already declines to make the claim.
      ⚠ includes/footer.php still renders a "Licensed & Insured" trust
      badge on every page. That badge and this document contradict each
      other. Supply the licence + COI, or remove the badge.

   2. §8 "Insurance Claim Work" / public adjuster — REMOVED ENTIRELY.
      Lawn mowing is not insurance restoration work. The clause is
      meaningless here and its presence would suggest the company does
      storm-claim work it does not do.

   3. §7 Cancellation "after materials ordered / deposit forfeited" —
      REWRITTEN. That is a roofing payment structure. Lawn care is a
      recurring per-visit service plus discrete projects (sod, mulch,
      planting), and the cancellation terms below reflect that.

   4. §5 Warranties "manufacturer warranties pass through on completion"
      — REWRITTEN. There is no manufacturer. Living plant material has an
      establishment period, not a warranty, and that is what is stated.

   ── GOVERNING LAW ──────────────────────────────────────────────
   $companyState / $companyCounty in config.php are the state and county
   of OPERATION, taken from the verified business address. Intake never
   supplied the state of formation, and $companyEntityType is empty — so
   $legalEntityName renders as the trading name only. If the entity was
   formed outside South Carolina, §11 must be revisited with counsel.
   ============================================================ */

$currentPage = 'legal';

$pageTitle       = 'Terms of Service | Greenville Lawn Masters, Mauldin SC';
$pageDescription = 'The terms governing use of the Greenville Lawn Masters website and our lawn '
                 . 'care services in Mauldin, SC — estimates, scheduling, payment, and governing law.';   // 158 chars

$canonicalUrl = $siteUrl . '/terms/';
$ogImage      = $logoUrl;

$lastUpdated  = date('F j, Y');

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';
$hasEmail     = $email !== '';

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
        ['name' => 'Home',             'url' => '/'],
        ['name' => 'Terms of Service', 'url' => '/terms/'],
    ]),
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   Terms of Service — page-scoped styles
   Shared legal shell lives in framework.css. What is HERE is unique to
   this page: the numbered clause spine and the key-terms summary strip.
   All var() tokens.

   Techniques used (design-system.md Part C):
     C7  signature — the numbered clause spine (a counter-driven margin
         numeral beside each h2), used on no other page in the build
     C10 floating decorative accent at 5% opacity
     C12 key-terms summary cards above the legal text
   ============================================================ */

.tm-body { background: var(--color-white); }
.tm-body::before {
  content: '';
  position: absolute;
  top: var(--space-16);
  left: calc(var(--space-16) * -1);
  width: 320px;
  height: 320px;
  border-radius: var(--radius-full);
  background: var(--color-secondary);
  opacity: 0.05;
  pointer-events: none;
}

/* ── Key-terms strip ──────────────────────────────────────────
   The four things a homeowner actually needs to know, before the wall of
   clauses. Not a substitute for the terms — a map into them. */
.tm-keys {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-4);
  max-width: 66rem;
  margin: 0 auto var(--space-16);
}
.tm-key {
  padding: var(--space-5);
  border-radius: var(--radius-lg);
  border: 1px solid var(--color-gray-light);
  transition: border-color var(--transition-base), transform var(--transition-base);
}
.tm-key:hover { border-color: var(--color-accent); transform: translateY(-3px); }
.tm-key__icon {
  width: 38px; height: 38px;
  border-radius: var(--radius-sm);
  background: var(--color-white);
  box-shadow: var(--shadow-sm);
  display: grid;
  place-items: center;
  color: var(--color-primary);
  margin-bottom: var(--space-4);
}
.tm-key__icon i, .tm-key__icon svg { width: 18px; height: 18px; }
.tm-key h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-base);
  color: var(--color-primary-dark);
  margin-bottom: var(--space-2);
  text-wrap: balance;
}
.tm-key p {
  font-size: var(--font-size-sm);
  line-height: 1.6;
  color: var(--color-gray-dark);
  margin: 0;
}

/* ── C7 · SIGNATURE — the numbered clause spine ───────────────
   A CSS counter drives the numeral, so a clause can be inserted or
   removed without renumbering thirteen headings by hand. The numeral
   hangs in the left margin on desktop and sits inline on mobile. */
.tm-clauses { counter-reset: clause; }
.tm-clauses > h2 {
  counter-increment: clause;
  position: relative;
  padding-left: var(--space-12);
}
.tm-clauses > h2::before {
  content: counter(clause, decimal-leading-zero);
  position: absolute;
  left: 0;
  top: 50%;
  transform: translateY(-50%);
  font-family: var(--font-heading);
  font-size: var(--font-size-2xl);
  font-weight: 800;
  line-height: 1;
  color: rgba(var(--color-accent-rgb), 0.35);
}
.tm-clauses > h2::after {
  content: '';
  position: absolute;
  left: var(--space-8);
  top: 50%;
  transform: translateY(-50%);
  width: 1px;
  height: var(--space-6);
  background: var(--color-gray-light);
}

/* A callout for the clauses that most often surprise people. */
.tm-callout {
  display: flex;
  gap: var(--space-4);
  align-items: flex-start;
  padding: var(--space-5);
  margin: var(--space-5) 0;
  border-radius: var(--radius-md);
  background: var(--color-card-tint-2);
  border-left: 3px solid var(--color-accent);
}
.tm-callout i, .tm-callout svg {
  width: 19px; height: 19px;
  flex-shrink: 0;
  margin-top: 3px;
  color: var(--color-primary);
}
.tm-callout p {
  margin: 0;
  font-size: var(--font-size-sm);
  line-height: 1.7;
  color: var(--color-gray-dark);
}

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .tm-keys { grid-template-columns: repeat(2, 1fr); }
  .tm-body::before { display: none; }
}
@media (max-width: 700px) {
  .tm-keys { grid-template-columns: 1fr; }

  /* The hanging numeral eats a third of a 375px line. Inline it. */
  .tm-clauses > h2 { padding-left: 0; }
  .tm-clauses > h2::before {
    position: static;
    transform: none;
    display: block;
    font-size: var(--font-size-lg);
    margin-bottom: var(--space-1);
  }
  .tm-clauses > h2::after { display: none; }
}

/* ── Clause table of contents ─────────────────────────────────
   Thirteen clauses is enough that "where is the cancellation policy"
   should not be a scroll hunt. Anchors match the h2 ids exactly. */
.tm-toc {
  max-width: 65ch;
  margin: 0 auto var(--space-12);
  padding: var(--space-6);
  border: 1px solid var(--color-gray-light);
  border-radius: var(--radius-lg);
  background: var(--color-light);
}
.tm-toc__title {
  font-family: var(--font-heading);
  font-size: var(--font-size-xs);
  letter-spacing: 2px;
  text-transform: uppercase;
  color: var(--color-gray);
  margin-bottom: var(--space-4);
}
.tm-toc ol {
  margin: 0;
  padding-left: var(--space-5);
  columns: 2;
  column-gap: var(--space-8);
  counter-reset: toc;
}
.tm-toc li { margin-bottom: var(--space-2); break-inside: avoid; }
.tm-toc a {
  color: var(--color-primary);
  font-size: var(--font-size-sm);
  border-bottom: 1px solid transparent;
  transition: border-color var(--transition-fast), color var(--transition-fast);
}
.tm-toc a:hover { border-bottom-color: var(--color-primary); }
.tm-toc a:focus-visible {
  outline: 2px solid var(--color-accent);
  outline-offset: 2px;
  border-radius: var(--radius-sm);
}

/* ── Scroll progress rail ─────────────────────────────────────
   A CSS-only reading indicator down the left edge, driven by the scroll
   timeline. Gated behind @supports: where animation-timeline is not
   implemented the bar simply never grows, which is why it starts at
   scaleY(0) rather than at full height. No JS, no layout cost. */
@supports (animation-timeline: scroll()) {
  .tm-progress {
    position: fixed;
    top: var(--nav-height);
    left: 0;
    width: 3px;
    height: calc(100vh - var(--nav-height));
    transform-origin: top;
    transform: scaleY(0);
    background: linear-gradient(to bottom, var(--color-accent), var(--color-primary));
    z-index: 40;
    animation: tmProgress linear both;
    animation-timeline: scroll(root block);
  }
  @keyframes tmProgress { to { transform: scaleY(1); } }
}
@media (prefers-reduced-motion: reduce) {
  .tm-progress { display: none; }
}

/* ── Deep-linked clause ───────────────────────────────────────
   /terms/#cancellation is a link people actually send each other. The
   framework's generic :target flash handles the highlight; this pins the
   heading clear of the fixed navbar and marks it while it is the target. */
.tm-clauses > h2:target::before { color: var(--color-primary); }
.tm-clauses > h2:target {
  scroll-margin-top: calc(var(--nav-height) + var(--space-8));
}

/* ── List markers ─────────────────────────────────────────────
   Default disc markers on a legal document read as a checklist. Square,
   accent-coloured, and pulled clear of the text column. */
.tm-clauses ul { list-style: square; }
.tm-clauses ul li::marker { color: var(--color-accent); }
.tm-clauses ol li::marker { color: var(--color-accent); font-weight: 700; }

/* Selection colour — brand green rather than the OS blue. */
.tm-body ::selection {
  background: rgba(var(--color-accent-rgb), 0.25);
  color: var(--color-black);
}

/* ── Focus states for every interactive element on this page ──*/
.tm-key:focus-within { border-color: var(--color-accent); }
.legal-prose a:focus-visible,
.legal-contact a:focus-visible {
  outline: 2px solid var(--color-accent);
  outline-offset: 2px;
  border-radius: var(--radius-sm);
  border-bottom-color: transparent;
}

/* ── Windows High Contrast / forced-colors ────────────────────
   The tinted key cards and the callouts carry meaning through background
   colour alone, and forced-colors mode discards background colour. Give
   each one a real border so the grouping survives. */
@media (forced-colors: active) {
  .tm-key,
  .tm-callout,
  .legal-contact,
  .legal-disclaimer {
    border: 1px solid CanvasText;
  }
  .tm-clauses > h2::before { color: CanvasText; }
  .tm-progress { display: none; }
  .tm-key__icon { border: 1px solid CanvasText; }
}

/* ── Wide viewports ───────────────────────────────────────────
   Above 1400px the 65ch column floats in a sea of white. Nudge the key
   strip wider so the page still has a horizon. */
@media (min-width: 1400px) {
  .tm-keys { max-width: 74rem; }
}

/* ── Print ────────────────────────────────────────────────────
   This document gets printed and handed to an attorney. Make that legible:
   drop the chrome, expand link targets so a paper copy is not full of
   dead references, and never orphan a clause heading from its clause. */
@media print {
  @page { margin: 2cm; }

  .site-header, .site-footer, .cookie-banner, .mobile-cta-bar,
  .back-to-top, .tm-keys, .tm-toc, .tm-progress,
  .hero--legal .breadcrumb { display: none !important; }

  .hero.hero--legal { min-height: auto; padding-block: var(--space-4); background: none; }
  .hero--legal h1, .hero--legal .eyebrow-label, .legal-stamp { color: var(--color-black); }
  .legal-stamp { border: 1px solid var(--color-black); background: none; backdrop-filter: none; }
  .tm-body::before { display: none; }

  .legal-prose { max-width: none; }
  .legal-prose p, .legal-prose li { orphans: 3; widows: 3; }

  .tm-clauses > h2 { break-after: avoid; break-inside: avoid; padding-left: 0; }
  .tm-clauses > h2::before { position: static; transform: none; margin-right: var(--space-2); color: var(--color-black); }
  .tm-clauses > h2::after { display: none; }
  .tm-callout, .legal-contact, .legal-disclaimer { break-inside: avoid; border: 1px solid var(--color-black); background: none; }

  /* A printed hyperlink with no visible target is a dead reference. */
  .legal-prose a[href^="http"]::after { content: " (" attr(href) ")"; font-size: 0.85em; word-break: break-all; }
  .legal-prose a[href^="/"]::after    { content: " (<?php echo e($siteUrl); ?>" attr(href) ")"; font-size: 0.85em; word-break: break-all; }
  .legal-prose a { border-bottom: 0; color: var(--color-black); }
}
</style>

<!-- ══════════ HERO ══════════ -->
<section class="hero hero--legal" aria-label="Terms of Service">
    <div class="container">

        <nav aria-label="Breadcrumb">
            <ol class="breadcrumb">
                <li><a href="/">Home</a></li>
                <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                <li><span aria-current="page">Terms of Service</span></li>
            </ol>
        </nav>

        <span class="eyebrow-label">Legal</span>
        <h1>Terms of Service</h1>

        <span class="legal-stamp">
            <i data-lucide="calendar" aria-hidden="true"></i>
            Effective &amp; Last Updated: <?php echo e($lastUpdated); ?>
        </span>

    </div>
</section>

<?php /* Scroll-progress rail. Purely decorative and CSS-only (scroll timeline),
         so it is aria-hidden and vanishes under prefers-reduced-motion. */ ?>
<div class="tm-progress" aria-hidden="true"></div>

<!-- ══════════ BODY ══════════ -->
<section class="tm-body" aria-label="Terms of Service content">
    <div class="container">

        <?php /* Key terms in plain English, before the legal text. The <h2> is sr-only:
                 these four cards are a summary OF the clauses below, so they need a
                 parent in the heading outline — but a visible "Key terms at a glance"
                 headline over four cards that already say what they are is chrome. */ ?>
        <h2 class="sr-only">Key terms at a glance</h2>
        <div class="tm-keys">
            <div class="tm-key card-tint-1 reveal-up">
                <div class="tm-key__icon"><i data-lucide="file-text" aria-hidden="true"></i></div>
                <h3>Estimates are non-binding until signed</h3>
                <p>A verbal number is not a contract. Only a written, signed agreement is.</p>
            </div>
            <div class="tm-key card-tint-2 reveal-up reveal-delay-1">
                <div class="tm-key__icon"><i data-lucide="calendar-x" aria-hidden="true"></i></div>
                <h3>No annual lock-in</h3>
                <p>Recurring mowing can be cancelled with notice. It is a schedule, not a term contract.</p>
            </div>
            <div class="tm-key card-tint-3 reveal-up reveal-delay-2">
                <div class="tm-key__icon"><i data-lucide="sprout" aria-hidden="true"></i></div>
                <h3>Plants are living things</h3>
                <p>Sod, seed, and plantings carry an establishment period, not a survival guarantee.</p>
            </div>
            <div class="tm-key card-tint-1 reveal-up reveal-delay-3">
                <div class="tm-key__icon"><i data-lucide="gavel" aria-hidden="true"></i></div>
                <h3>South Carolina law governs</h3>
                <p>Disputes are heard in the courts of <?php echo e($companyCounty); ?> County, <?php echo e($companyState); ?>.</p>
            </div>
        </div>

        <nav class="tm-toc" aria-label="On this page">
            <p class="tm-toc__title">The clauses</p>
            <ol>
                <li><a href="#agreement">Agreement to these Terms</a></li>
                <li><a href="#website-use">Use of this website</a></li>
                <li><a href="#estimates">Estimates and quotes</a></li>
                <li><a href="#the-work">The work</a></li>
                <li><a href="#scheduling">Scheduling, weather, access</a></li>
                <li><a href="#warranties">Warranties and living material</a></li>
                <li><a href="#payment">Payment terms</a></li>
                <li><a href="#cancellation">Cancellation</a></li>
                <li><a href="#chemicals">Chemical application</a></li>
                <li><a href="#liability">Limitation of liability</a></li>
                <li><a href="#ip">Intellectual property</a></li>
                <li><a href="#governing-law">Governing law and disputes</a></li>
                <li><a href="#changes">Changes to these Terms</a></li>
                <li><a href="#contact">Contact us</a></li>
            </ol>
        </nav>

        <article class="legal-prose tm-clauses">

            <h2 id="agreement">Agreement to These Terms</h2>
            <p>
                By using <?php echo e($domain); ?> or engaging
                <strong><?php echo e($legalEntityName); ?></strong> ("Greenville Lawn Masters", "we", "us")
                for services, you agree to these Terms of Service. If you do not agree, do not use this
                site and do not engage us.
            </p>

            <h2 id="website-use">Use of This Website</h2>
            <ul>
                <li>You may use this site for personal, non-commercial purposes: to learn about our
                    services and to contact us.</li>
                <li>You may not use it for any unlawful purpose, attempt to access systems that are not
                    public, scrape or republish its content without written permission, submit false
                    information through our forms, or use automated systems to extract data from it.</li>
            </ul>

            <h2 id="estimates">Estimates and Quotes</h2>
            <p>
                Every estimate is based on what was visible and what you told us at the time of the
                property walkthrough. Final pricing may differ if the scope of work changes, if conditions
                not visible at the walkthrough are discovered — buried irrigation, unmarked utilities,
                stumps, debris under overgrowth — or if material costs move between the estimate and the
                start of work.
            </p>
            <div class="tm-callout">
                <i data-lucide="info" aria-hidden="true"></i>
                <p>
                    Verbal quotes are not binding on either of us. Only a written agreement, accepted by
                    you, constitutes a final contract for work. Our written estimate is delivered within
                    24 hours of the walkthrough and is itemised by service.
                </p>
            </div>

            <h2 id="the-work">The Work</h2>
            <ul>
                <li>Each job is governed by the written estimate you accepted, which sets out the scope.</li>
                <li>We comply with applicable <?php echo e($companyState); ?> state and local ordinances
                    governing lawn maintenance, chemical application, noise, and yard-waste disposal.</li>
                <li>Work is performed by Greenville Lawn Masters personnel and, where necessary, by
                    qualified subcontractors engaged by us.</li>
                <li>You are responsible for marking or disclosing anything buried and breakable —
                    irrigation heads, invisible pet fencing, low-voltage lighting, shallow utilities and
                    septic components — before work begins. We cannot see them, and a mower cannot avoid
                    what nobody flagged.</li>
                <li>Pets should be secured indoors on service days.</li>
            </ul>

            <h2 id="scheduling">Scheduling, Weather, and Access</h2>
            <p>
                Recurring mowing runs on a route. Weather moves it. Cutting saturated turf tears the crown
                and ruts the soil, so we will not mow a lawn that is too wet to mow; the visit shifts to the
                next workable day and the schedule resets from there. Upstate South Carolina produces enough
                summer thunderstorms that this will happen during any normal season.
            </p>
            <p>
                If our crew cannot access the property on a scheduled visit — a locked gate, an unsecured
                dog, a blocked driveway — we may charge for the visit, because the crew and the equipment
                were there.
            </p>

            <h2 id="warranties">Warranties and Living Material</h2>
            <p>
                We warrant that our work will be performed in a workmanlike manner. Any warranty specific
                to a project is set out in the written estimate you accepted.
            </p>
            <div class="tm-callout">
                <i data-lucide="sprout" aria-hidden="true"></i>
                <p>
                    Sod, seed, plants, shrubs, and trees are living material. We warrant that they were
                    healthy and correctly installed at the time of installation. We cannot warrant that
                    they will live. Establishment depends almost entirely on watering, which is in your
                    hands after we leave — and we hand over a watering schedule at completion for exactly
                    this reason. Losses caused by under-watering, over-watering, pets, pests, disease,
                    drought, freeze, or later work by others are not covered.
                </p>
            </div>
            <p>
                Warranties do not cover damage from neglect, from alteration by others, from acts of God,
                or from pre-existing conditions disclosed to you before work began.
            </p>

            <h2 id="payment">Payment Terms</h2>
            <p>
                Payment terms are set out in your accepted estimate. Recurring mowing is generally billed
                per visit or monthly in arrears. Projects — sod, mulch, planting, cleanups — may require a
                deposit at acceptance, with the balance due on completion. Past-due balances may accrue
                interest at the maximum rate permitted by <?php echo e($companyState); ?> law, and we may
                suspend recurring service on an account that is past due.
            </p>

            <h2 id="cancellation">Cancellation</h2>
            <ul>
                <li><strong>Recurring services.</strong> Either of us may cancel a recurring mowing or
                    treatment schedule with reasonable notice — we ask for notice before the next scheduled
                    visit. There is no annual contract and no cancellation penalty. Work already performed
                    remains payable.</li>
                <li><strong>Individual visits.</strong> Cancelling less than 24 hours before a scheduled
                    visit may incur a charge, because the route was built around it.</li>
                <li><strong>Projects, before materials are purchased.</strong> Your deposit is refunded
                    less any administrative or design costs already incurred.</li>
                <li><strong>Projects, after materials are purchased.</strong> Materials bought for your job
                    — sod, plants, mulch, seed — are perishable and are charged to you. They become your
                    property.</li>
                <li><strong>Projects, after work begins.</strong> Payment is due for work completed and
                    materials supplied to that point.</li>
            </ul>

            <h2 id="chemicals">Fertiliser, Herbicide, and Chemical Application</h2>
            <p>
                Products are applied according to their labels and to applicable
                <?php echo e($companyState); ?> regulations. Keep people and pets off treated areas for the
                period stated on the product label or on the notice we leave. Tell us in advance about
                anyone with a chemical sensitivity, about vegetable gardens, about beehives, and about
                ponds or fish on the property, so we can adjust or exclude an area.
            </p>
            <p>
                We do not guarantee the eradication of any weed, pest, or turf disease. Lawn treatment is
                suppression and management across seasons, not a one-visit cure — and any company that
                promises otherwise is selling you something.
            </p>

            <h2 id="liability">Limitation of Liability</h2>
            <p>
                To the maximum extent permitted by <?php echo e($companyState); ?> law, the total liability of
                Greenville Lawn Masters for any claim arising out of this website or our services shall not
                exceed the amount you paid for the specific service that gave rise to the claim. We are not
                liable for indirect, incidental, special, punitive, or consequential damages.
            </p>
            <p>
                Nothing in these Terms limits liability that cannot be limited under
                <?php echo e($companyState); ?> law.
            </p>

            <h2 id="ip">Intellectual Property</h2>
            <p>
                All content on this site — text, photographs, graphics, and the Greenville Lawn Masters
                name and logo — is owned by us or used with permission, and is protected by copyright and
                trademark law. You may not reproduce, distribute, or create derivative works from it
                without written permission.
            </p>

            <h2 id="governing-law">Governing Law and Disputes</h2>
            <p>
                These Terms are governed by the laws of the State of <?php echo e($companyState); ?>, without
                regard to its conflict-of-laws principles. Any dispute arising out of these Terms or our
                services shall be brought exclusively in the state or federal courts located in
                <?php echo e($companyCounty); ?> County, <?php echo e($companyState); ?>, and you consent to the
                jurisdiction of those courts.
            </p>

            <h2 id="changes">Changes to These Terms</h2>
            <p>
                We may update these Terms at any time. The "Last Updated" date at the top of this page
                reflects the current version. Continuing to use the site after an update constitutes
                acceptance of the revised Terms. Work already contracted is governed by the Terms in force
                when you accepted the estimate.
            </p>

            <h2 id="contact">Contact Us</h2>
            <p>Questions about these Terms:</p>

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
                    This Terms of Service document is provided as a general template. We recommend
                    reviewing it with a licensed <?php echo e($companyState); ?> attorney before publication.
                </span>
            </div>

        </article>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
