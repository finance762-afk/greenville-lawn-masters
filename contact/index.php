<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /contact/index.php — Phase 5
   Greenville Lawn Masters · Mauldin, SC

   ── FORM CONTRACT ──────────────────────────────────────────────
   Posts to $formAction (https://db.pageone.cloud/functions/v1/leads/{slug}),
   resolved in Phase 3. build-plan.json's `form_action` key names a different
   host (design.pageone.cloud); CLAUDE.md is the enforcement layer and names
   db.pageone.cloud in three separate places, so it wins. See config.php.

   Field names are the CRM contract and are NOT free to restyle:
     name  email  phone     — required; the endpoint rejects a submission missing any
     service                 — optional, drives AI lead value estimation
     message                 — optional
     _honey                  — the spam trap. The Phase 5 prompt calls this
                               "_honeypot"; the endpoint keys on "_honey". A
                               renamed trap is a trap that never fires, silently,
                               forever. CLAUDE.md's markup block is authoritative.
     _next                   — thank-you redirect
     _consent_version        — stamped into consent_records for legal defence
     _consent_page           — which URL the consent was given on

   ── CONSENT (TCPA 2025/2026 · Texas TCPA Sept 2025) ────────────
   THREE separate checkboxes, unbundled, none pre-checked:
     email_opt_in    optional
     sms_opt_in      optional   — carries the four mandated disclosures
     terms_accepted  REQUIRED
   references/legal-compliance.md still shows the older SINGLE bundled
   `tcpa_consent` box. That pattern is what Texas outlawed in Sept 2025, and
   CLAUDE.md explicitly supersedes it ("These must be SEPARATE, UNBUNDLED, NOT
   pre-checked"). CLAUDE.md wins over the reference file, by its own rule.

   ── INTAKE GAPS ────────────────────────────────────────────────
   phone, email, street address, and business hours are ALL empty in
   build-plan.json. On a contact page that is not a cosmetic problem — it is
   the page. Every channel below renders ONLY when config.php holds a real
   value. Nothing is stubbed with a placeholder number, a fake inbox, or
   invented hours. The form is therefore the only live channel today, and the
   page says so out loud rather than pretending otherwise.

   ── MAP ────────────────────────────────────────────────────────
   $gbpUrl, $gbpPlaceId, $geo, and the street address are all empty, so a
   pinned business-location embed cannot be built. Rather than ship a fake
   pin, the embed below shows the SERVICE AREA — Mauldin, SC 29662 — which is
   a fact we actually have. The GBP-pinned embed and the "Get Directions"
   deep link are stubbed in comments, ready the moment place_id lands.
   ============================================================ */

$currentPage = 'contact';

$pageTitle       = 'Contact Greenville Lawn Masters | Free Lawn Care Estimate in Mauldin, SC';
$pageDescription = 'Request a free lawn care estimate in Mauldin, SC. Tell Greenville Lawn Masters '
                 . 'what your property needs and get a written, itemised estimate within 24 hours.';   // 157 chars

$canonicalUrl = $siteUrl . '/contact/';
$ogImage      = $ogImageUrl;

$heroImg          = heroPhoto('front_lawn');
$heroImagePreload = $heroImg['src'];

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';
$hasEmail     = $email !== '';
$hasStreet    = $address['street'] !== '';
$hasHours     = !empty($businessHours);

/* Full day names for the hours table. $businessHours is keyed 'Mo','Tu',… per
   config.php, matching schema.org's dayOfWeek short forms. */
$dayNames = [
    'Mo' => 'Monday',    'Tu' => 'Tuesday',  'We' => 'Wednesday',
    'Th' => 'Thursday',  'Fr' => 'Friday',   'Sa' => 'Saturday',
    'Su' => 'Sunday',
];

/* ── What happens after you submit (section 3) ────────────────
   Each step is a commitment intake actually recorded, or a mechanical fact
   about the form pipeline. No response-time promise beyond the 24-hour
   written estimate, which is the one hard commitment in build-plan.json. */
$afterSteps = [
    ['n' => '01', 'icon' => 'send',           'title' => 'The request lands',      'body' => 'Your details go straight to Greenville Lawn Masters. Nothing is shared with a lead broker and nothing is sold on.'],
    ['n' => '02', 'icon' => 'footprints',     'title' => 'The property is walked', 'body' => 'Someone comes out and looks at the grass type, the slope, the drainage, and the corners that always struggle. Free, and no obligation.'],
    ['n' => '03', 'icon' => 'file-text',      'title' => 'A written estimate, within 24 hours', 'body' => 'Itemised by service, so you can take all of it or part of it. In writing, so you can hold us to the number.'],
    ['n' => '04', 'icon' => 'calendar-check', 'title' => 'The schedule gets set',  'body' => 'Mowing joins a weekly or biweekly route. Treatments, aeration, and cleanups are booked to the calendar the grass keeps.'],
];

/* ── Schema ────────────────────────────────────────────────────
   ContactPage + BreadcrumbList. `mainEntity` references the homepage
   LocalBusiness @id instead of restating NAP (CLAUDE.md). No aggregateRating,
   no fabricated openingHours — generateLocalBusinessSchema() already omits
   hours while $businessHours is empty, and this page must not contradict it. */
$pageSchema = [
    generateBreadcrumbSchema([
        ['name' => 'Home',    'url' => '/'],
        ['name' => 'Contact', 'url' => '/contact/'],
    ]),
    [
        '@context'    => 'https://schema.org',
        '@type'       => 'ContactPage',
        '@id'         => $canonicalUrl . '#webpage',
        'url'         => $canonicalUrl,
        'name'        => $pageTitle,
        'description' => $pageDescription,
        'mainEntity'  => ['@id' => organizationId()],
        'speakable'   => [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => ['.hero-answer', 'h1'],
        ],
    ],
];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   Contact — page-scoped styles
   Every class prefixed .ct-. Colour, shadow, spacing, radius and timing
   are var() tokens without exception. Raw px only for icon boxes,
   hairline borders, and checkbox sizing.

   Techniques used (design-system.md Part C):
     C1  layered hero — photo + gradient ::before + noise ::after
     C3  two distinct SVG dividers (chevron notch, soft wave)
     C5  asymmetric grid — form column 1.25fr against channels 0.75fr
     C7  signature section — the numbered "what happens next" ladder
     C9  floating-label form fields with animated focus states
     C10 floating decorative accents at 4-6% opacity
     C11 responsive map embed with aspect-ratio box
   ============================================================ */

/* ── C1 · Layered hero ────────────────────────────────────────*/
.ct-hero {
  min-height: 56vh;
  display: flex;
  align-items: center;
  background-image: url('/assets/images/hero-mauldin-front-lawn.jpg');
  background-size: cover;
  background-position: center 62%;
  isolation: isolate;
}
.ct-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background:
    linear-gradient(
      98deg,
      rgba(var(--color-dark-rgb), 0.94) 0%,
      rgba(var(--color-dark-rgb), 0.80) 45%,
      rgba(var(--color-primary-dark-rgb), 0.55) 78%,
      rgba(var(--color-primary-rgb), 0.34) 100%
    );
  z-index: 0;
}
.ct-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.32;
  pointer-events: none;
  z-index: 0;
}
.ct-hero__inner {
  position: relative;
  z-index: 2;
  max-width: 58rem;
  padding-block: calc(var(--nav-height) + var(--space-10)) var(--space-16);
}
@keyframes ctFade {
  from { opacity: 0; transform: translateY(14px); }
  to   { opacity: 1; transform: none; }
}
.ct-hero .breadcrumb  { animation: ctFade 0.5s ease both; }
.ct-hero__eyebrow     { animation: ctFade 0.6s ease 0.06s both; }
.ct-hero h1           { animation: ctFade 0.6s ease 0.12s both; }
.ct-hero .hero-answer { animation: ctFade 0.6s ease 0.20s both; }

.ct-hero__eyebrow {
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
.ct-hero__eyebrow i, .ct-hero__eyebrow svg { width: 15px; height: 15px; color: var(--color-accent); }
.ct-hero h1 {
  font-size: var(--fs-h1);
  line-height: 1.03;
  text-wrap: balance;
  margin-bottom: var(--space-6);
}
.ct-hero .hero-answer {
  color: rgba(var(--color-white-rgb), 0.86);
  max-width: 60ch;
  margin-inline: 0;
}

/* ── C5 · Asymmetric form / channels split ────────────────────*/
.ct-main { background: var(--color-light); }
.ct-grid {
  display: grid;
  grid-template-columns: 1.25fr 0.75fr;
  gap: var(--space-12);
  align-items: start;
}

/* ── The form card ────────────────────────────────────────────*/
.ct-form-card {
  background: var(--color-white);
  border-radius: var(--radius-xl);
  box-shadow: var(--shadow-card);
  padding: var(--space-10);
  position: relative;
}
/* C10 · floating accent */
.ct-form-card::before {
  content: '';
  position: absolute;
  top: calc(var(--space-6) * -1);
  right: calc(var(--space-6) * -1);
  width: 120px;
  height: 120px;
  border-radius: var(--radius-full);
  background: var(--color-accent);
  opacity: 0.06;
  z-index: -1;
}
.ct-form-card h2 {
  font-family: var(--font-heading);
  font-size: var(--font-size-3xl);
  color: var(--color-primary);
  text-wrap: balance;
  margin-bottom: var(--space-2);
}
.ct-form-card__tagline {
  color: var(--color-gray);
  font-size: var(--font-size-sm);
  margin-bottom: var(--space-8);
}

/* ── C9 · Floating-label fields ───────────────────────────────
   Scoped to .ct-field so the consent-fieldset labels never inherit the
   absolutely-positioned floating-label rules and fly off the card. */
.ct-field { position: relative; margin-bottom: var(--space-5); }
.ct-field input,
.ct-field select,
.ct-field textarea {
  width: 100%;
  padding: var(--space-5) var(--space-4) var(--space-2);
  border: 1px solid var(--color-gray-light);
  border-radius: var(--radius-md);
  background: var(--color-white);
  color: var(--color-black);
  font-family: var(--font-body);
  font-size: var(--font-size-base);
  transition: border-color var(--transition-base), box-shadow var(--transition-base);
}
.ct-field textarea { resize: vertical; min-height: 130px; padding-top: var(--space-6); }
.ct-field input:hover,
.ct-field select:hover,
.ct-field textarea:hover { border-color: var(--color-accent); }
.ct-field input:focus,
.ct-field select:focus,
.ct-field textarea:focus {
  outline: none;
  border-color: var(--color-primary);
  box-shadow: 0 0 0 var(--space-1) rgba(var(--color-primary-rgb), 0.12);
}
.ct-field input:focus-visible,
.ct-field select:focus-visible,
.ct-field textarea:focus-visible {
  outline: 2px solid var(--color-accent);
  outline-offset: 2px;
}
.ct-field label {
  position: absolute;
  left: var(--space-4);
  top: 50%;
  transform: translateY(-50%);
  color: var(--color-gray);
  font-size: var(--font-size-base);
  pointer-events: none;
  transition: top var(--transition-fast), font-size var(--transition-fast), color var(--transition-fast), transform var(--transition-fast);
}
.ct-field textarea + label { top: var(--space-6); transform: none; }

/* Raised state: focused, filled, or a <select> (which always shows a value). */
.ct-field input:focus + label,
.ct-field input:not(:placeholder-shown) + label,
.ct-field textarea:focus + label,
.ct-field textarea:not(:placeholder-shown) + label,
.ct-field select + label {
  top: var(--space-2);
  transform: none;
  font-size: var(--font-size-xs);
  color: var(--color-primary);
  letter-spacing: 0.5px;
  text-transform: uppercase;
}
.ct-field select {
  appearance: none;
  cursor: pointer;
  padding-right: var(--space-10);
}
.ct-field .ct-caret {
  position: absolute;
  right: var(--space-4);
  top: 50%;
  transform: translateY(-50%);
  width: 18px; height: 18px;
  color: var(--color-gray);
  pointer-events: none;
}
.ct-field__req { color: var(--color-danger); }

.ct-form__footnote {
  margin: var(--space-5) 0 0;
  font-size: var(--font-size-xs);
  color: var(--color-gray);
  line-height: 1.6;
  text-align: center;
}
.ct-form__footnote a { color: var(--color-primary); text-decoration: underline; }

/* ── Channel rail (right column) ──────────────────────────────*/
.ct-rail { display: flex; flex-direction: column; gap: var(--space-6); }

.ct-channel {
  background: var(--color-white);
  border-radius: var(--radius-lg);
  border: 1px solid var(--color-gray-light);
  padding: var(--space-6);
  transition: transform var(--transition-base), box-shadow var(--transition-base), border-color var(--transition-base);
}
.ct-channel:hover {
  transform: translateY(-3px);
  box-shadow: var(--shadow-card);
  border-color: var(--color-accent);
}
.ct-channel__head {
  display: flex;
  align-items: center;
  gap: var(--space-3);
  margin-bottom: var(--space-3);
}
.ct-channel__icon {
  width: 42px; height: 42px;
  flex-shrink: 0;
  border-radius: var(--radius-md);
  background: var(--color-card-tint-1);
  display: grid;
  place-items: center;
  color: var(--color-primary);
}
.ct-channel__icon i, .ct-channel__icon svg { width: 20px; height: 20px; }
.ct-channel h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  color: var(--color-primary-dark);
  margin: 0;
}
.ct-channel p {
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.65;
  margin: 0;
}
.ct-channel__value {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  margin-top: var(--space-3);
  font-family: var(--font-heading);
  font-weight: 700;
  font-size: var(--font-size-lg);
  color: var(--color-primary);
  word-break: break-word;
}
.ct-channel__value:hover { color: var(--color-accent); text-decoration: underline; }

/* Hours table — renders only when $businessHours is populated. */
.ct-hours { list-style: none; margin: var(--space-3) 0 0; padding: 0; }
.ct-hours li {
  display: flex;
  justify-content: space-between;
  gap: var(--space-4);
  padding-block: var(--space-2);
  font-size: var(--font-size-sm);
  color: var(--color-gray-dark);
  border-bottom: 1px solid var(--color-gray-light);
}
.ct-hours li:last-child { border-bottom: 0; }
.ct-hours .ct-hours__day { font-weight: 600; color: var(--color-black); }

/* The gap disclosure. Renders while a channel is genuinely unavailable. */
.ct-gap {
  background: var(--color-card-tint-3);
  border: 1px dashed var(--color-primary);
  border-radius: var(--radius-lg);
  padding: var(--space-6);
  display: flex;
  gap: var(--space-4);
  align-items: flex-start;
}
.ct-gap i, .ct-gap svg {
  width: 20px; height: 20px; flex-shrink: 0;
  color: var(--color-primary);
  margin-top: 2px;
}
.ct-gap p {
  margin: 0;
  font-size: var(--font-size-sm);
  line-height: 1.65;
  color: var(--color-gray-dark);
}
.ct-gap strong { color: var(--color-primary-dark); }

/* ── C7 · SIGNATURE — the numbered ladder ─────────────────────
   Offset numeral plates climbing a dark ground. Used on no other page. */
.ct-next { background: var(--color-dark); }
.ct-next h2 { color: var(--color-white); }
.ct-next .hero-answer { color: rgba(var(--color-white-rgb), 0.72); }
.ct-next .eyebrow-label { color: var(--color-accent); }

.ct-ladder {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-16);
}
.ct-step {
  position: relative;
  padding: var(--space-8) var(--space-6);
  border-radius: var(--radius-lg);
  background: rgba(var(--color-white-rgb), 0.04);
  border: 1px solid rgba(var(--color-white-rgb), 0.09);
  transition: transform var(--transition-base), background var(--transition-base);
}
/* Each rung sits a little higher than the last — the ladder climbs. */
.ct-step:nth-child(2) { transform: translateY(calc(var(--space-4) * -1)); }
.ct-step:nth-child(3) { transform: translateY(calc(var(--space-8) * -1)); }
.ct-step:nth-child(4) { transform: translateY(calc(var(--space-12) * -1)); }
.ct-step:hover { background: rgba(var(--color-white-rgb), 0.07); }
.ct-step:nth-child(1):hover { transform: translateY(calc(var(--space-2) * -1)); }
.ct-step:nth-child(2):hover { transform: translateY(calc(var(--space-6) * -1)); }
.ct-step:nth-child(3):hover { transform: translateY(calc(var(--space-10) * -1)); }
.ct-step:nth-child(4):hover { transform: translateY(calc(var(--space-16) * -1)); }

.ct-step__num {
  position: absolute;
  top: calc(var(--space-4) * -1);
  right: var(--space-5);
  font-family: var(--font-heading);
  font-size: var(--font-size-5xl);
  font-weight: 800;
  line-height: 1;
  color: rgba(var(--color-accent-rgb), 0.22);
  pointer-events: none;
}
.ct-step__icon {
  width: 46px; height: 46px;
  border-radius: var(--radius-md);
  background: rgba(var(--color-accent-rgb), 0.14);
  display: grid;
  place-items: center;
  color: var(--color-accent);
  margin-bottom: var(--space-5);
}
.ct-step__icon i, .ct-step__icon svg { width: 22px; height: 22px; }
.ct-step h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  color: var(--color-white);
  margin-bottom: var(--space-3);
  text-wrap: balance;
}
.ct-step p {
  color: rgba(var(--color-white-rgb), 0.68);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  margin: 0;
}

/* ── Map section ──────────────────────────────────────────────*/
.ct-map { background: var(--color-white); }
.ct-map__grid {
  display: grid;
  grid-template-columns: 0.8fr 1.2fr;
  gap: var(--space-12);
  align-items: center;
}
.ct-map h2 {
  font-family: var(--font-heading);
  font-size: var(--fs-h2);
  color: var(--color-primary);
  text-wrap: balance;
  margin-bottom: var(--space-5);
}
.ct-map .answer-block { margin-inline: 0; }
.ct-map__areas {
  list-style: none;
  padding: 0;
  margin: var(--space-6) 0 0;
  display: flex;
  flex-wrap: wrap;
  gap: var(--space-2);
}
.ct-map__areas li {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  padding: var(--space-2) var(--space-4);
  border-radius: var(--radius-full);
  background: var(--color-card-tint-1);
  color: var(--color-primary-dark);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.ct-map__areas i, .ct-map__areas svg { width: 14px; height: 14px; color: var(--color-accent); }

/* ── Closing CTA ──────────────────────────────────────────────*/
.ct-cta {
  background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
  text-align: center;
}
.ct-cta h2 { color: var(--color-white); font-size: var(--fs-h2); text-wrap: balance; margin-bottom: var(--space-5); }
.ct-cta .answer-block { color: rgba(var(--color-white-rgb), 0.88); max-width: 58ch; margin: 0 auto var(--space-10); }
.ct-cta__actions { display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap; }
.ct-cta::before {
  content: '';
  position: absolute;
  top: 50%; left: 50%;
  width: 620px; height: 620px;
  transform: translate(-50%, -50%);
  border-radius: var(--radius-full);
  border: 2px solid var(--color-white);
  opacity: 0.04;
  pointer-events: none;
}

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .ct-grid { grid-template-columns: 1fr; gap: var(--space-10); }
  .ct-map__grid { grid-template-columns: 1fr; gap: var(--space-10); }

  /* The climbing offsets read as broken alignment once the ladder wraps. */
  .ct-ladder { grid-template-columns: repeat(2, 1fr); }
  .ct-step,
  .ct-step:nth-child(2),
  .ct-step:nth-child(3),
  .ct-step:nth-child(4) { transform: none; }
  .ct-step:hover,
  .ct-step:nth-child(1):hover,
  .ct-step:nth-child(2):hover,
  .ct-step:nth-child(3):hover,
  .ct-step:nth-child(4):hover { transform: translateY(calc(var(--space-2) * -1)); }
}

@media (max-width: 768px) {
  .ct-hero { min-height: 50vh; }
  .ct-form-card { padding: var(--space-6); }
  .ct-form-card::before { display: none; }
}

@media (max-width: 600px) {
  .ct-ladder { grid-template-columns: 1fr; }
  .ct-cta__actions .btn { width: 100%; }
  .ct-channel { padding: var(--space-5); }
}
</style>

<!-- ══════════ 1 · HERO ══════════ -->
<section class="hero ct-hero" aria-label="Contact Greenville Lawn Masters">
    <div class="container">
        <div class="ct-hero__inner">

            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li class="breadcrumb-sep" aria-hidden="true"><i data-lucide="chevron-right"></i></li>
                    <li><span aria-current="page">Contact</span></li>
                </ol>
            </nav>

            <span class="ct-hero__eyebrow">
                <i data-lucide="clipboard-list" aria-hidden="true"></i>
                Free Estimate &middot; Mauldin, SC
            </span>

            <h1>Get your lawn <span class="text-accent">walked and priced</span></h1>

            <p class="hero-answer">
                Tell Greenville Lawn Masters what your property in Mauldin, South Carolina needs.
                Someone walks the lawn in person, and a written, itemised estimate follows within
                24 hours. The walkthrough is free and there is no obligation to book.
            </p>

        </div>
    </div>

    <!-- Divider · chevron notch, filled with the next section's tint -->
    <div class="svg-divider" style="height:56px" aria-hidden="true">
        <svg viewBox="0 0 1200 56" preserveAspectRatio="none">
            <path d="M0,56 L0,20 L560,20 L600,0 L640,20 L1200,20 L1200,56 Z" fill="var(--color-light)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · FORM + CHANNELS ══════════ -->
<section class="ct-main" aria-label="Request an estimate">
    <div class="container">
        <div class="ct-grid">

            <!-- ── Form column ── -->
            <div class="ct-form-card reveal-up">
                <h2>Request a free estimate</h2>
                <p class="ct-form-card__tagline">
                    Written, itemised, within 24 hours of the walkthrough. Fields marked
                    <span class="ct-field__req">*</span> are required.
                </p>

                <?php /* No `novalidate` attribute of any kind. `novalidate="false"` still
                         DISABLES native validation — the attribute is boolean, its value is
                         ignored — which would let a submission through without the required
                         terms_accepted box ticked. Native validation stays on. */ ?>
                <form action="<?php echo e($formAction); ?>" method="POST">

                    <?php /* Spam trap. `_honey` is the name the CRM endpoint keys on — do not
                             rename it. display:none needs !important because bots that parse
                             CSS skip a plainly-hidden field; tabindex/autocomplete/aria-hidden
                             keep it out of keyboard, autofill, and screen-reader flow. */ ?>
                    <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">

                    <input type="hidden" name="_next" value="/thank-you/">
                    <input type="hidden" name="_form_location" value="contact">
                    <input type="hidden" name="_consent_version" value="<?php echo e($consentVersion); ?>">
                    <input type="hidden" name="_consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? '/contact/', ENT_QUOTES, 'UTF-8'); ?>">

                    <div class="ct-field">
                        <input type="text" id="contact-name" name="name" placeholder=" " autocomplete="name" required>
                        <label for="contact-name">Your name <span class="ct-field__req">*</span></label>
                    </div>

                    <div class="ct-field">
                        <input type="tel" id="contact-phone" name="phone" placeholder=" " autocomplete="tel" required>
                        <label for="contact-phone">Phone number <span class="ct-field__req">*</span></label>
                    </div>

                    <div class="ct-field">
                        <input type="email" id="contact-email" name="email" placeholder=" " autocomplete="email" required>
                        <label for="contact-email">Email address <span class="ct-field__req">*</span></label>
                    </div>

                    <?php /* `service`, not `service_requested`. The CRM contract in CLAUDE.md
                             names this field `service` and uses it for lead value estimation;
                             a renamed field arrives as an unmapped extra and is dropped. */ ?>
                    <div class="ct-field">
                        <select id="contact-service" name="service">
                            <option value="">Not sure yet — help me work it out</option>
                            <?php foreach ($servicePages as $servicePage): ?>
                                <option value="<?php echo e($servicePage['title']); ?>"><?php echo e($servicePage['title']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="contact-service">Service needed</label>
                        <i data-lucide="chevron-down" class="ct-caret" aria-hidden="true"></i>
                    </div>

                    <div class="ct-field">
                        <textarea id="contact-message" name="message" placeholder=" " rows="4"></textarea>
                        <label for="contact-message">Tell us about the property</label>
                    </div>

                    <?php /* ══ THREE SEPARATE, UNBUNDLED CONSENT BOXES ══
                             TCPA 2025/2026 + Texas TCPA (Sept 2025). Neither opt-in is
                             pre-checked; only `terms_accepted` is `required`. The edge
                             function stamps IP, user agent, and timestamp into
                             consent_records alongside _consent_version and _consent_page. */ ?>
                    <fieldset class="form-consent-fieldset">
                        <legend class="form-consent-legend">Communication Consent</legend>

                        <label class="form-consent-item" for="contact-email-opt">
                            <input type="checkbox" name="email_opt_in" id="contact-email-opt" value="yes" class="consent-checkbox">
                            <span class="consent-label">
                                <strong>Email updates (optional):</strong> I agree to receive emails from
                                <?php echo e($siteName); ?> about my inquiry, services, promotions, and news.
                                I understand I can unsubscribe at any time using the link in any email<?php if ($hasEmail): ?>
                                or by emailing <a href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a><?php endif; ?>.
                                Message frequency varies.
                            </span>
                        </label>

                        <label class="form-consent-item" for="contact-sms-opt">
                            <input type="checkbox" name="sms_opt_in" id="contact-sms-opt" value="yes" class="consent-checkbox">
                            <span class="consent-label">
                                <strong>SMS/Text messages (optional):</strong> I agree to receive text messages from
                                <?php echo e($siteName); ?> at the phone number I provided. Message types may include
                                appointment reminders, service updates, and promotional offers. Message frequency varies.
                                Message and data rates may apply. Reply STOP to unsubscribe, HELP for help.
                                <strong>Consent is not a condition of purchase.</strong>
                            </span>
                        </label>

                        <label class="form-consent-item form-consent-required" for="contact-terms">
                            <input type="checkbox" name="terms_accepted" id="contact-terms" value="yes" class="consent-checkbox" required>
                            <span class="consent-label">
                                I have read and agree to the <a href="/privacy-policy/">Privacy Policy</a>
                                and <a href="/terms/">Terms of Service</a>. <span class="required-star">*</span>
                            </span>
                        </label>

                    </fieldset>

                    <button type="submit" class="btn btn-accent btn-block btn-lg">
                        <i data-lucide="send" aria-hidden="true"></i>
                        Send My Request
                    </button>

                    <p class="ct-form__footnote">
                        Your details go to Greenville Lawn Masters. They are never sold to a lead broker.
                        See the <a href="/privacy-policy/">Privacy Policy</a> for how long they are kept.
                    </p>

                </form>
            </div>

            <!-- ── Channel rail ── -->
            <div class="ct-rail">

                <?php if ($hasPhone): ?>
                    <div class="ct-channel reveal-right">
                        <div class="ct-channel__head">
                            <div class="ct-channel__icon"><i data-lucide="phone" aria-hidden="true"></i></div>
                            <h3>Call the crew</h3>
                        </div>
                        <p>Quickest way to get a walkthrough on the calendar.</p>
                        <a class="ct-channel__value" href="tel:<?php echo e($phoneLink); ?>"><?php echo e($phoneDisplay); ?></a>
                    </div>
                <?php endif; ?>

                <?php if ($hasEmail): ?>
                    <div class="ct-channel reveal-right reveal-delay-1">
                        <div class="ct-channel__head">
                            <div class="ct-channel__icon"><i data-lucide="mail" aria-hidden="true"></i></div>
                            <h3>Email us</h3>
                        </div>
                        <p>Send photos of the property and we will come back with questions.</p>
                        <a class="ct-channel__value" href="mailto:<?php echo e($email); ?>"><?php echo e($email); ?></a>
                    </div>
                <?php endif; ?>

                <?php /* Renders whenever a direct channel is missing. This is a live intake gap,
                         not a design choice — and a contact page that quietly omits its phone
                         number reads as a broken business, whereas one that explains itself
                         reads as an honest one. Deletes itself when config.php is filled in. */ ?>
                <?php if (!$hasPhone || !$hasEmail): ?>
                    <div class="ct-gap reveal-right">
                        <i data-lucide="info" aria-hidden="true"></i>
                        <p>
                            <strong>The form is the fastest way to reach us right now.</strong>
                            Greenville Lawn Masters has not published
                            <?php
                                $absent = [];
                                if (!$hasPhone) { $absent[] = 'a phone number'; }
                                if (!$hasEmail) { $absent[] = 'an email address'; }
                                echo e(implode(' or ', $absent));
                            ?>
                            on this site yet. Rather than show one that might be wrong, we show none —
                            send the form and someone will come back to you directly.
                        </p>
                    </div>
                <?php endif; ?>

                <div class="ct-channel reveal-right reveal-delay-2">
                    <div class="ct-channel__head">
                        <div class="ct-channel__icon"><i data-lucide="map-pin" aria-hidden="true"></i></div>
                        <h3>Where we work</h3>
                    </div>
                    <p>
                        Based in <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?>, working
                        properties within <?php echo e((string) $targetRadius); ?> miles across Greenville County.
                    </p>
                    <span class="ct-channel__value">
                        <?php if ($hasStreet): ?>
                            <?php echo e($address['street']); ?>,
                        <?php endif; ?>
                        <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?> <?php echo e($address['zip']); ?>
                    </span>
                </div>

                <div class="ct-channel reveal-right reveal-delay-3">
                    <div class="ct-channel__head">
                        <div class="ct-channel__icon"><i data-lucide="clock" aria-hidden="true"></i></div>
                        <h3><?php echo $hasHours ? 'Hours' : 'Response time'; ?></h3>
                    </div>

                    <?php if ($hasHours): ?>
                        <ul class="ct-hours">
                            <?php foreach ($businessHours as $day => $window): ?>
                                <li>
                                    <span class="ct-hours__day"><?php echo e($dayNames[$day] ?? $day); ?></span>
                                    <span><?php echo e($window[0]); ?> &ndash; <?php echo e($window[1]); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <?php /* $businessHours is empty. Publishing "Mon-Fri 8-5" here would be a
                                 guess that sends someone to a locked gate. The 24-hour estimate
                                 commitment IS recorded in intake, so that is what we state. */ ?>
                        <p>
                            Requests sent through this form are answered with a walkthrough, and a written
                            estimate follows within 24 hours of that visit. Opening hours are not yet
                            published on this site.
                        </p>
                    <?php endif; ?>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- ══════════ 3 · SIGNATURE — WHAT HAPPENS NEXT ══════════ -->
<section class="ct-next" aria-label="What happens after you send the form">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">After You Hit Send</span>
            <h2>What happens once <span class="text-accent">Greenville Lawn Masters</span> has your request?</h2>
            <p class="hero-answer">
                Greenville Lawn Masters receives the request directly, walks the property in person at no
                charge, sends a written and itemised estimate within 24 hours of that visit, and only then
                puts the work on a schedule. Nothing is billed before you accept the estimate.
            </p>
        </div>

        <div class="ct-ladder">
            <?php foreach ($afterSteps as $i => $step): ?>
                <?php $dir = ['reveal-up', 'reveal-scale', 'reveal-down', 'reveal-scale'][$i % 4]; ?>
                <article class="ct-step <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>">
                    <span class="ct-step__num" aria-hidden="true"><?php echo e($step['n']); ?></span>
                    <div class="ct-step__icon"><i data-lucide="<?php echo e($step['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Divider · soft wave into the white map section -->
    <div class="svg-divider" style="height:64px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,40 C160,10 300,54 480,34 C660,14 820,50 1000,32 C1090,23 1150,26 1200,30 L1200,60 L0,60 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 4 · MAP + SERVICE AREA ══════════ -->
<section class="ct-map" aria-label="Service area">
    <div class="container">
        <div class="ct-map__grid">

            <div>
                <span class="eyebrow-label reveal-left">Service Area</span>
                <h2 class="reveal-left">Does <span class="text-accent">Greenville Lawn Masters</span> come out to you?</h2>

                <p class="answer-block reveal-left reveal-delay-1">
                    Greenville Lawn Masters is based in Mauldin, South Carolina and serves properties within
                    roughly <?php echo e((string) $targetRadius); ?> miles, which covers most of Greenville County.
                    If you are searching for lawn care near me in Mauldin, the route almost certainly reaches
                    your street. Residential lawns and commercial grounds are both on it.
                </p>

                <ul class="ct-map__areas reveal-left reveal-delay-2">
                    <?php foreach ($serviceAreas as $area): ?>
                        <li>
                            <i data-lucide="map-pin" aria-hidden="true"></i>
                            <?php echo e($area['city']); ?>, <?php echo e($area['state']); ?>
                        </li>
                    <?php endforeach; ?>
                    <li>
                        <i data-lucide="compass" aria-hidden="true"></i>
                        <?php echo e((string) $targetRadius); ?>-mile radius
                    </li>
                </ul>
            </div>

            <?php /* SERVICE-AREA map, not a business-location pin.
                     $gbpUrl, $gbpPlaceId, $geo, and $address['street'] are all empty in
                     config.php, so there is no verified pin to drop. This iframe centres on
                     Mauldin, SC 29662 — a fact intake DID supply — and is labelled as the
                     service area, which is what it honestly shows.

                     AT LAUNCH, once place_id + the GBP embed land in config.php, swap the src
                     for the real GBP embed and uncomment the directions button:

                       <iframe src="[$gbpEmbedSrc from intake]" …></iframe>
                       <a class="btn btn-secondary"
                          href="https://www.google.com/maps/dir/?api=1&destination=place_id:<?php echo e($gbpPlaceId); ?>">
                         Get Directions
                       </a>

                     Width/height attributes are deliberately stripped — .map-embed drives the
                     box with aspect-ratio so it cannot overflow a phone. */ ?>
            <div class="map-embed reveal-right">
                <iframe
                    src="https://www.google.com/maps?q=Mauldin%2C%20SC%2029662&output=embed"
                    title="Map of the Greenville Lawn Masters service area centred on Mauldin, South Carolina"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen></iframe>
            </div>

        </div>
    </div>
</section>

<!-- ══════════ 5 · CTA ══════════ -->
<section class="ct-cta" aria-label="Browse services">
    <div class="container">
        <h2 class="reveal-up">Not sure which service the lawn actually needs?</h2>
        <p class="answer-block reveal-up reveal-delay-1">
            That is what the walkthrough is for. Leave the service field blank, send the form, and someone
            will tell you what the property needs — including the parts it does not.
        </p>
        <div class="ct-cta__actions reveal-up reveal-delay-2">
            <a href="/services/" class="btn btn-accent btn-lg">
                <i data-lucide="list" aria-hidden="true"></i>
                Browse All Services
            </a>
            <a href="/faq/" class="btn btn-outline-white btn-lg">
                <i data-lucide="help-circle" aria-hidden="true"></i>
                Read the FAQ
            </a>
        </div>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
