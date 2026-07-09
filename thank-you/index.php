<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';
?>
<?php
/* ============================================================
   /thank-you/index.php — Phase 5
   Greenville Lawn Masters · Mauldin, SC

   The `_next` target of every form on the site. Both the homepage hero
   form ("/thank-you") and the contact form ("/thank-you/") land here:
   Apache's mod_dir issues a 301 from the unslashed form to the directory,
   so both resolve. robots.txt also disallows /thank-you/.

   noindex + nofollow. A thank-you page in the index is a thank-you page
   that shows up in search results for the brand name, which means visitors
   arriving to be thanked for a form they never filled in — and conversion
   analytics that count them.

   ── REVIEW REQUEST LINK ────────────────────────────────────────
   CLAUDE.md v6.1 wants a "Leave us a Google review" button pointing at
   https://search.google.com/local/writereview?placeid=[PLACE_ID].
   $gbpPlaceId is EMPTY in config.php, and that URL with no place_id
   lands on a Google error page. So the button renders ONLY when the
   place_id exists. It will appear on its own the moment intake lands.

   Everything on this page that promises a timeframe promises exactly one:
   a written estimate within 24 hours of the walkthrough. That is the only
   commitment build-plan.json recorded. No "we'll call you within an hour",
   no "expect a response by end of day" — those would be invented, and this
   is the page where a broken promise is noticed first.
   ============================================================ */

$currentPage = 'thank-you';
$noindex     = true;   // head.php → <meta name="robots" content="noindex,nofollow">

$pageTitle       = 'Thank You | Greenville Lawn Masters';
$pageDescription = 'Your request has reached Greenville Lawn Masters. Here is what happens next.';

$canonicalUrl = $siteUrl . '/thank-you/';

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';
$hasReviewLink = $gbpPlaceId !== '';

/* What happens next. Three steps, no invented timings. */
$next = [
    [
        'icon'  => 'inbox',
        'title' => 'Your request is in',
        'body'  => 'It went straight to Greenville Lawn Masters — not to a lead broker, not to a call '
                 . 'centre, and not into a list that gets resold. Check your inbox for a copy.',
    ],
    [
        'icon'  => 'footprints',
        'title' => 'Someone walks the property',
        'body'  => 'Grass type, slope, drainage, gate access, and the corners that always struggle get '
                 . 'looked at in person. The walkthrough is free, and you are under no obligation after it.',
    ],
    [
        'icon'  => 'file-text',
        'title' => 'A written estimate, within 24 hours',
        'body'  => 'Itemised by service, so you can accept all of it or part of it. Nothing is scheduled '
                 . 'and nothing is billed until you say yes to a number you have read.',
    ],
];

/* Three service pages worth reading while you wait. Deterministic, not random —
   a random pick changes the internal link graph on every request. */
$suggested = array_slice($servicePages, 0, 3);

/* No schema. The page is noindex; a WebPage node for a page excluded from the
   index is markup nobody will ever consume. */
$pageSchema = [];

include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
?>
<style>
/* ============================================================
   Thank You — page-scoped styles
   Every class prefixed .ty-. All colour, shadow, spacing, radius and
   timing values are var() tokens.

   Techniques used (design-system.md Part C):
     C1  layered ground — gradient + noise ::after
     C3  SVG divider (soft wave)
     C7  signature — the drawn check mark, stroke-animated on load,
         used nowhere else in the build
     C10 floating decorative accents at 4-6% opacity
   ============================================================ */

.ty-hero {
  min-height: calc(100vh - var(--nav-height));
  display: flex;
  align-items: center;
  text-align: center;
  background: linear-gradient(160deg, var(--color-primary-dark) 0%, var(--color-dark) 100%);
  isolation: isolate;
}
.ty-hero::after {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.8' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.05'/%3E%3C/svg%3E");
  opacity: 0.36;
  pointer-events: none;
  z-index: 0;
}
/* C10 · floating accent */
.ty-hero::before {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 560px;
  height: 560px;
  transform: translate(-50%, -50%);
  border-radius: var(--radius-full);
  background: var(--color-accent);
  opacity: 0.05;
  filter: blur(var(--space-12));
  z-index: 0;
}
.ty-hero__inner {
  position: relative;
  z-index: 2;
  max-width: 46rem;
  margin-inline: auto;
  padding-block: var(--space-16);
}

/* ── C7 · SIGNATURE — the drawn check ─────────────────────────
   An SVG stroke-dashoffset draw, not a static icon. It is the one moment
   of celebration in the build, and it belongs on exactly this page. */
.ty-check {
  width: 96px;
  height: 96px;
  margin: 0 auto var(--space-8);
  border-radius: var(--radius-full);
  background: rgba(var(--color-accent-rgb), 0.14);
  border: 2px solid rgba(var(--color-accent-rgb), 0.35);
  display: grid;
  place-items: center;
}
.ty-check svg { width: 46px; height: 46px; overflow: visible; }
.ty-check path {
  fill: none;
  stroke: var(--color-accent);
  stroke-width: 3.5;
  stroke-linecap: round;
  stroke-linejoin: round;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: tyDraw 0.7s cubic-bezier(0.65, 0, 0.35, 1) 0.25s forwards;
}
@keyframes tyDraw { to { stroke-dashoffset: 0; } }

/* The framework reset already kills animation for prefers-reduced-motion by
   crushing duration to 0.01ms. That would leave the check UNDRAWN at
   dashoffset 48 — an empty circle. Draw it instantly instead. */
@media (prefers-reduced-motion: reduce) {
  .ty-check path { stroke-dashoffset: 0; }
}

@keyframes tyRise {
  from { opacity: 0; transform: translateY(16px); }
  to   { opacity: 1; transform: none; }
}
.ty-check      { animation: tyRise 0.6s ease both; }
.ty-hero h1    { animation: tyRise 0.6s ease 0.10s both; }
.ty-lede       { animation: tyRise 0.6s ease 0.18s both; }
.ty-hero__cta  { animation: tyRise 0.6s ease 0.26s both; }

.ty-hero h1 {
  font-size: var(--fs-h2);
  color: var(--color-white);
  line-height: 1.1;
  text-wrap: balance;
  margin-bottom: var(--space-5);
}
.ty-lede {
  color: rgba(var(--color-white-rgb), 0.78);
  font-size: var(--font-size-lg);
  line-height: 1.75;
  max-width: 56ch;
  margin: 0 auto var(--space-10);
}
.ty-hero__cta {
  display: flex;
  gap: var(--space-4);
  justify-content: center;
  flex-wrap: wrap;
}

/* ── What happens next ────────────────────────────────────────*/
.ty-next { background: var(--color-white); }
.ty-next__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.ty-step {
  position: relative;
  padding: var(--space-8);
  border-radius: var(--radius-lg);
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.ty-step:hover { transform: translateY(-4px); box-shadow: var(--shadow-card); }
.ty-step__icon {
  width: 52px; height: 52px;
  border-radius: var(--radius-md);
  background: var(--color-white);
  box-shadow: var(--shadow-sm);
  display: grid;
  place-items: center;
  color: var(--color-primary);
  margin-bottom: var(--space-5);
}
.ty-step__icon i, .ty-step__icon svg { width: 24px; height: 24px; }
.ty-step h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-xl);
  color: var(--color-primary-dark);
  margin-bottom: var(--space-3);
  text-wrap: balance;
}
.ty-step p {
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.7;
  margin: 0;
}

/* Spam-folder note. The single most common reason a lead thinks they were
   ignored is that the reply landed in spam. Worth one line. */
.ty-note {
  display: flex;
  gap: var(--space-3);
  align-items: flex-start;
  max-width: 62ch;
  margin: var(--space-12) auto 0;
  padding: var(--space-5);
  border-radius: var(--radius-md);
  background: var(--color-card-tint-2);
  color: var(--color-gray-dark);
  font-size: var(--font-size-sm);
  line-height: 1.65;
}
.ty-note i, .ty-note svg { width: 18px; height: 18px; flex-shrink: 0; color: var(--color-primary); margin-top: 2px; }

/* ── Review request (renders only with a real place_id) ───────*/
.ty-review {
  background: var(--color-light);
  text-align: center;
}
.ty-review h2 { color: var(--color-primary); font-size: var(--fs-h2); text-wrap: balance; margin-bottom: var(--space-5); }
.ty-review p { color: var(--color-gray-dark); max-width: 56ch; margin: 0 auto var(--space-8); }
.ty-review__stars {
  display: inline-flex;
  gap: var(--space-1);
  margin-bottom: var(--space-6);
  color: var(--color-star);
}
.ty-review__stars i, .ty-review__stars svg { width: 24px; height: 24px; fill: var(--color-star); }

/* ── Suggested reading ────────────────────────────────────────*/
.ty-read { background: var(--color-dark); }
.ty-read h2 { color: var(--color-white); }
.ty-read .hero-answer { color: rgba(var(--color-white-rgb), 0.72); }
.ty-read .eyebrow-label { color: var(--color-accent); }
.ty-read__grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: var(--space-6);
  margin-top: var(--space-12);
}
.ty-card {
  display: block;
  padding: var(--space-6);
  border-radius: var(--radius-lg);
  background: rgba(var(--color-white-rgb), 0.04);
  border: 1px solid rgba(var(--color-white-rgb), 0.09);
  transition: background var(--transition-base), transform var(--transition-base), border-color var(--transition-base);
}
.ty-card:hover {
  background: rgba(var(--color-white-rgb), 0.07);
  border-color: var(--color-accent);
  transform: translateY(-4px);
}
.ty-card__icon {
  width: 44px; height: 44px;
  border-radius: var(--radius-md);
  background: rgba(var(--color-accent-rgb), 0.14);
  display: grid;
  place-items: center;
  color: var(--color-accent);
  margin-bottom: var(--space-4);
}
.ty-card__icon i, .ty-card__icon svg { width: 20px; height: 20px; }
.ty-card h3 {
  font-family: var(--font-heading);
  font-size: var(--font-size-lg);
  color: var(--color-white);
  margin-bottom: var(--space-2);
  text-wrap: balance;
}
.ty-card p {
  color: rgba(var(--color-white-rgb), 0.66);
  font-size: var(--font-size-sm);
  line-height: 1.65;
  margin: 0;
}
.ty-card__more {
  display: inline-flex;
  align-items: center;
  gap: var(--space-2);
  margin-top: var(--space-4);
  color: var(--color-accent);
  font-size: var(--font-size-sm);
  font-weight: 600;
}
.ty-card__more i, .ty-card__more svg { width: 15px; height: 15px; transition: transform var(--transition-base); }
.ty-card:hover .ty-card__more i, .ty-card:hover .ty-card__more svg { transform: translateX(3px); }

/* ── Responsive ───────────────────────────────────────────────*/
@media (max-width: 1024px) {
  .ty-next__grid, .ty-read__grid { grid-template-columns: 1fr; }
}
@media (max-width: 768px) {
  .ty-hero { min-height: auto; padding-block: calc(var(--nav-height) + var(--space-16)) var(--space-16); }
  .ty-check { width: 80px; height: 80px; }
  .ty-check svg { width: 38px; height: 38px; }
}
@media (max-width: 600px) {
  .ty-hero__cta .btn { width: 100%; }
}

/* ── Focus states ─────────────────────────────────────────────*/
.ty-card:focus-visible {
  outline: 2px solid var(--color-accent);
  outline-offset: 3px;
  background: rgba(var(--color-white-rgb), 0.07);
  transform: translateY(-4px);
}
.ty-hero__cta .btn:focus-visible {
  outline: 2px solid var(--color-white);
  outline-offset: 3px;
}
.ty-review .btn:focus-visible {
  outline: 2px solid var(--color-primary-dark);
  outline-offset: 3px;
}

/* ── Short viewports ──────────────────────────────────────────
   The confirmation must be visible without scrolling — that is the whole
   job of this page. On a landscape phone a 100vh hero pushes the check
   mark and the headline apart. */
@media (max-height: 620px) and (min-width: 769px) {
  .ty-hero { min-height: auto; padding-block: calc(var(--nav-height) + var(--space-12)) var(--space-12); }
  .ty-check { width: 72px; height: 72px; margin-bottom: var(--space-5); }
  .ty-check svg { width: 34px; height: 34px; }
  .ty-lede { margin-bottom: var(--space-6); }
}

/* ── Reduced motion ───────────────────────────────────────────
   The check-draw is handled above (pinned to dashoffset 0). These are the
   pointer-driven transforms the global reset cannot reach. */
@media (prefers-reduced-motion: reduce) {
  .ty-step:hover { transform: none; }
  .ty-card:hover { transform: none; }
  .ty-card:hover .ty-card__more i,
  .ty-card:hover .ty-card__more svg { transform: none; }
}

/* ── Windows High Contrast / forced-colors ────────────────────
   The check mark is an SVG stroke set with a custom property; forced-colors
   repaints it to CanvasText, which is correct. The tinted step cards and the
   translucent read cards lose their grounds entirely, so border them. */
@media (forced-colors: active) {
  .ty-check { border: 2px solid CanvasText; }
  .ty-check path { stroke: CanvasText; }
  .ty-step, .ty-card, .ty-note { border: 1px solid CanvasText; }
  .ty-step__icon, .ty-card__icon { border: 1px solid CanvasText; }
}

/* ── @supports fallbacks ──────────────────────────────────────*/
@supports not (aspect-ratio: 1 / 1) {
  .ty-check { min-height: 96px; }
}

/* Brand-green selection. */
.ty-next ::selection, .ty-review ::selection { background: rgba(var(--color-accent-rgb), 0.25); color: var(--color-black); }
.ty-hero ::selection, .ty-read ::selection { background: rgba(var(--color-accent-rgb), 0.4); color: var(--color-white); }

/* ── Wide viewports ───────────────────────────────────────────*/
@media (min-width: 1400px) {
  .ty-next__grid, .ty-read__grid { gap: var(--space-8); }
}

/* ── Print ────────────────────────────────────────────────────
   People do print a confirmation. Give them the three steps and the
   contact route, not a black gradient that empties a toner cartridge. */
@media print {
  @page { margin: 2cm; }

  .site-header, .site-footer, .cookie-banner, .mobile-cta-bar,
  .back-to-top, .ty-hero__cta, .ty-read, .ty-review,
  .svg-divider { display: none !important; }

  .ty-hero { min-height: auto; background: none; padding-block: var(--space-4); }
  .ty-hero::before, .ty-hero::after { display: none; }
  .ty-hero h1, .ty-lede { color: var(--color-black); }
  .ty-check { border-color: var(--color-black); background: none; }
  .ty-check path { stroke: var(--color-black); stroke-dashoffset: 0; animation: none; }

  .ty-next { background: none; }
  .ty-step { border: 1px solid var(--color-black); break-inside: avoid; }
  .ty-note { border: 1px solid var(--color-black); background: none; }
}
</style>

<!-- ══════════ 1 · CONFIRMATION ══════════ -->
<section class="hero ty-hero" aria-label="Request received">
    <div class="container">
        <div class="ty-hero__inner">

            <div class="ty-check" aria-hidden="true">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 16.5 L13 23 L26 9"/>
                </svg>
            </div>

            <h1>Request received. <span class="text-accent">Thank you.</span></h1>

            <p class="ty-lede">
                Greenville Lawn Masters has your details. Someone will be in touch to walk the property,
                and a written, itemised estimate follows within 24 hours of that visit. The walkthrough is
                free, and you are under no obligation after it.
            </p>

            <div class="ty-hero__cta">
                <a href="/" class="btn btn-accent btn-lg">
                    <i data-lucide="home" aria-hidden="true"></i>
                    Back to Homepage
                </a>
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        Call <?php echo e($phoneDisplay); ?>
                    </a>
                <?php else: ?>
                    <a href="/services/" class="btn btn-outline-white btn-lg">
                        <i data-lucide="list" aria-hidden="true"></i>
                        Browse All Services
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- Divider · soft wave into the white "what next" band -->
    <div class="svg-divider" style="height:64px" aria-hidden="true">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,34 C170,6 350,52 550,30 C750,8 920,48 1090,28 C1140,22 1175,24 1200,26 L1200,60 L0,60 Z" fill="var(--color-white)"/>
        </svg>
    </div>
</section>

<!-- ══════════ 2 · WHAT HAPPENS NEXT ══════════ -->
<section class="ty-next" aria-label="What happens next">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">What Happens Next</span>
            <h2>What should you expect from <span class="text-accent">Greenville Lawn Masters</span> now?</h2>
        </div>

        <div class="ty-next__grid">
            <?php foreach ($next as $i => $step): ?>
                <?php
                    $rotation = ($i % 3) + 1;
                    $dir      = ['reveal-up', 'reveal-scale', 'reveal-down'][$i % 3];
                ?>
                <article class="ty-step card-tint-<?php echo $rotation; ?> <?php echo $dir; ?> reveal-delay-<?php echo $rotation; ?>">
                    <div class="ty-step__icon"><i data-lucide="<?php echo e($step['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($step['title']); ?></h3>
                    <p><?php echo e($step['body']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>

        <p class="ty-note reveal-up">
            <i data-lucide="mail-search" aria-hidden="true"></i>
            <span>
                If a reply has not shown up, check the spam folder before assuming it never came —
                a first email from an unfamiliar domain lands there more often than it should.
            </span>
        </p>

    </div>
</section>

<?php if ($hasReviewLink): ?>
<?php /* Renders ONLY with a real $gbpPlaceId. A writereview URL with an empty
         placeid parameter lands on a Google error page, which is a worse
         experience than no button at all. Fill $gbpPlaceId in config.php
         (the ChIJ… string, not the map embed URL) and this appears. */ ?>
<!-- ══════════ 3 · REVIEW REQUEST ══════════ -->
<section class="ty-review" aria-label="Leave a Google review">
    <div class="container">
        <div class="ty-review__stars" aria-hidden="true">
            <?php for ($s = 0; $s < 5; $s++): ?>
                <i data-lucide="star"></i>
            <?php endfor; ?>
        </div>
        <h2 class="reveal-up">Already had work done by us?</h2>
        <p class="reveal-up reveal-delay-1">
            A Google review is the single most useful thing a happy customer can do for a small lawn
            care company in Mauldin. It takes about a minute.
        </p>
        <a href="https://search.google.com/local/writereview?placeid=<?php echo e($gbpPlaceId); ?>"
           class="btn btn-accent btn-lg reveal-up reveal-delay-2"
           target="_blank" rel="noopener">
            <i data-lucide="star" aria-hidden="true"></i>
            Leave Us a Google Review
        </a>
    </div>
</section>
<?php endif; ?>

<!-- ══════════ 4 · WHILE YOU WAIT ══════════ -->
<section class="ty-read" aria-label="Services to read about while you wait">
    <div class="container">

        <div class="section-header reveal-up">
            <span class="eyebrow-label">While You Wait</span>
            <h2>Which <span class="text-accent">services</span> might your property need?</h2>
            <p class="hero-answer">
                Greenville Lawn Masters runs <?php echo e((string) count($services)); ?> services with one crew across
                <?php echo e((string) count($servicePages)); ?> service pages. If the estimate should cover more than
                what you asked for, say so when the crew walks the property.
            </p>
        </div>

        <div class="ty-read__grid">
            <?php foreach ($suggested as $i => $servicePage): ?>
                <?php
                    $meta = serviceCardMeta($servicePage['slug']);
                    $dir  = ['reveal-left', 'reveal-up', 'reveal-right'][$i % 3];
                ?>
                <a class="ty-card <?php echo $dir; ?> reveal-delay-<?php echo $i + 1; ?>"
                   href="/services/<?php echo e($servicePage['slug']); ?>/">
                    <div class="ty-card__icon"><i data-lucide="<?php echo e($meta['icon']); ?>" aria-hidden="true"></i></div>
                    <h3><?php echo e($servicePage['title']); ?></h3>
                    <p><?php echo e($meta['desc']); ?></p>
                    <span class="ty-card__more">
                        Read more
                        <i data-lucide="arrow-right" aria-hidden="true"></i>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
