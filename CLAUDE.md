# CLAUDE.md — Page One Insights Build Standards

> Claude Code reads this file automatically on every build. All rules here are **mandatory** unless explicitly overridden by the build prompt.

---

## How This File Works

CLAUDE.md is the **enforcement layer** — it defines what a build must contain and what's forbidden. The **how** lives in reference files. Read the references before writing code:

- `~/crm/references/design-system.md` — visual architecture, CSS tokens, premium technique library, visual vocabulary archetypes (**READ FIRST**)
- `~/crm/references/seo-aeo-2026.md` — SEO + AEO specifications, schema markup, sitemap.php, llms.txt patterns
- `~/crm/references/build-phases.md` — PHP architecture, build phase order, deployment pipeline
- `~/crm/references/blog-standard.md` — blog registry, post anatomy, topic clusters (Premium builds)

Rules below win when they conflict with anything in references.

---

## Tier Visual Quality Matrix (MANDATORY — ENFORCED BY QA)

Every build is assigned a tier in the build prompt. The tier determines the visual bar.

| Tier | CSS lines/page (inline `<style>`) | Distinct techniques/page | QA enforcement on failure |
|---|---|---|---|
| **Premium** | **≥ 400** | **≥ 6** from technique library | **FAIL HARD** — build cannot deploy |
| **Standard** | **≥ 200** | **≥ 4** from technique library | WARN — logged but build proceeds |
| **Basic** | **≥ 100** | **≥ 2** from technique library | WARN — logged but build proceeds |

### Automatic-fail conditions (ALL tiers)

- A page with **zero** inline `<style>` blocks fails regardless of tier
- A page that reuses CSS class names from another page's `<style>` block without visual differentiation (just copying) fails
- A page using only default/global `styles.css` classes with no page-specific work fails
- A page where `<style>` contains hardcoded colors, shadows, or spacing values (not `var()` tokens) fails

### Required techniques (per-page minimum)

Each page must use techniques from `design-system.md` Part C. The per-page requirements in C12 define which techniques are mandatory on which page types. At a minimum, every page includes:

- Layered hero (C1) with `::before` gradient overlay + `::after` noise texture
- At least 2 different section divider styles (C3)
- Text-wrap: balance on every heading
- No two consecutive sections with identical layout or background treatment
- One signature section (C7) that doesn't repeat elsewhere on the page

### Why this exists

Without quantitative enforcement, builds produced by AI agents drift toward the minimum — pages with zero custom CSS technically meet qualitative "use premium techniques" rules. The line count and technique count are the floor. Hitting them does not guarantee quality, but falling below them guarantees failure.

---

## Legal & Compliance Requirements (REQUIRED — EVERY BUILD)

Every Page One Insights client website MUST include the following legal and compliance elements. These are non-negotiable and required for TCPA 2025/2026, CCPA/CPRA, ADA WCAG 2.1 AA, and multi-state privacy law compliance. Missing any of these items is an automatic QA fail.

### Four Required Legal Pages (All Tiers)

All pages use subdirectory/index.php pattern:

- `/privacy-policy/index.php` — CCPA/CPRA + 19 other state rights, SMS terms, data processor disclosure
- `/terms/index.php` — Governing law from client's state of formation
- `/cookie-policy/index.php` — GA4, Fonts, Maps, CDN cookies disclosed
- `/accessibility/index.php` — WCAG 2.1 AA conformance statement

Legal pages are linked ONLY from the footer legal row. Never in top nav or body CTAs.

### Footer Legal Row (Every Page)

Above the copyright line in `includes/footer.php`:

```
Privacy Policy | Terms of Service | Cookie Policy | Accessibility | Do Not Sell or Share My Personal Information | Sitemap
```

"Do Not Sell or Share" links to `/privacy-policy/#ccpa-rights` anchor.

### Contact Form: Dual Consent Checkboxes (TCPA 2025/2026)

Contact forms MUST include THREE separate checkboxes:

1. **Email opt-in (optional)** — receives marketing emails from company
2. **SMS opt-in (optional)** — receives text messages; includes "Consent is not a condition of purchase," "Message and data rates may apply," "Reply STOP to unsubscribe"
3. **Terms acceptance (REQUIRED)** — agreement to Privacy Policy and Terms of Service

These must be SEPARATE, UNBUNDLED, NOT pre-checked. This is a Texas TCPA requirement (Sept 2025) and industry best practice everywhere.

Hidden form fields required:

- `_consent_version` — currently `"v2.1"`
- `_consent_page` — PHP: `<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>`

The edge function at `https://db.pageone.cloud/functions/v1/leads/{client_slug}` automatically captures IP, user agent, and timestamp, and writes to `consent_records` table for legal defense.

### Required Intake Questions

Intake MUST collect before building:

- Business entity type (LLC, Sole Proprietorship, Corporation, Partnership)
- State of formation (for Terms governing law)
- Does client run paid advertising (Google Ads, Meta Ads)?
- States where business operates

### Why These Are Non-Negotiable

- **TCPA violations** = $500–$1,500 per text. Settlements in 2024–2025 averaged $7–15M. Class actions common.
- **CCPA/CPRA** — $2,500–$7,500 per violation. Applies if any California resident visits.
- **ADA Title III lawsuits** — up 25% YoY. Small businesses targeted.
- **Texas TCPA (Sept 2025)** — requires separate unbundled checkbox specifically.
- **FCC Opt-Out Rule (April 2025)** — businesses must honor any reasonable opt-out method.
- **CCPA 2026 updates** — mandatory confirmation that opt-out was honored.

### Full Templates

Complete page templates, consent HTML/CSS, footer legal row, sitemap entries, Phase 4 audit checklist, retrofit prompt, and agency disclaimer are documented at:

`/home/calvin/crm/references/legal-compliance.md`

- Phase 2 (Header/Footer/Head) must include the footer legal row.
- Phase 4 (Inner Pages) must generate all 4 legal page subdirectories.
- Phase 5 (SEO/Final Polish) must ensure legal pages are in the sitemap.php page registry.
- QA must verify the compliance items in legal-compliance.md: four legal pages, footer legal row, cookie banner, TCPA consent checkboxes, sitemap entries.

---

## Lead Form Endpoint (REQUIRED — REPLACES FORMSUBMIT.CO)

All client website contact forms post to the Page One CRM endpoint. This is how leads reach the client's Portal, their CRM deal, and their email.

### Form action URL

```
https://db.pageone.cloud/functions/v1/leads/{client_slug}
```

Where `{client_slug}` is the client's slug (matches the build directory name in `~/client-sites/` and the `site_build_intakes.client_slug` column).

### Required form markup

```html
<form action="https://db.pageone.cloud/functions/v1/leads/example-client-slug" method="POST">

  <!-- Honeypot — MUST be hidden from users, bots fill it out -->
  <input type="text" name="_honey" style="display:none !important" tabindex="-1" autocomplete="off" aria-hidden="true">

  <!-- Thank-you redirect -->
  <input type="hidden" name="_next" value="/thank-you">

  <!-- Consent tracking -->
  <input type="hidden" name="_consent_version" value="v2.1">
  <input type="hidden" name="_consent_page" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">

  <!-- Required fields (names MUST match exactly) -->
  <label>
    <span>Your Name</span>
    <input type="text" name="name" required>
  </label>

  <label>
    <span>Email</span>
    <input type="email" name="email" required>
  </label>

  <label>
    <span>Phone</span>
    <input type="tel" name="phone" required>
  </label>

  <!-- Optional but strongly recommended -->
  <label>
    <span>Service Needed</span>
    <select name="service">
      <option value="">Select a service</option>
      <!-- Populate with client-specific service options from intake data -->
    </select>
  </label>

  <label>
    <span>Message</span>
    <textarea name="message" rows="4"></textarea>
  </label>

  <!-- ═══ SEPARATE CONSENT CHECKBOXES (TCPA 2025/2026 + Texas TCPA) ═══ -->

  <fieldset class="form-consent-fieldset">
    <legend class="form-consent-legend">Communication Consent</legend>

    <label class="form-consent-item">
      <input type="checkbox" name="email_opt_in" value="yes" class="consent-checkbox">
      <span class="consent-label">
        <strong>Email updates (optional):</strong> I agree to receive emails from
        <?php echo htmlspecialchars($siteName); ?> about my inquiry, services, promotions, and news. I understand I can unsubscribe anytime via the link in any email
        or by emailing <?php echo htmlspecialchars($contactEmail); ?>. Message frequency varies.
      </span>
    </label>

    <label class="form-consent-item">
      <input type="checkbox" name="sms_opt_in" value="yes" class="consent-checkbox">
      <span class="consent-label">
        <strong>SMS/Text messages (optional):</strong> I agree to receive text messages from
        <?php echo htmlspecialchars($siteName); ?> at the phone number I provided. Message types may include appointment reminders, service updates, and promotional
        offers. Message frequency varies. Message and data rates may apply. Reply STOP to unsubscribe, HELP for help.
        <strong>Consent is not a condition of purchase.</strong>
      </span>
    </label>

    <label class="form-consent-item form-consent-required">
      <input type="checkbox" name="terms_accepted" value="yes" class="consent-checkbox" required>
      <span class="consent-label">
        I have read and agree to the
        <a href="/privacy-policy/">Privacy Policy</a>
        and
        <a href="/terms/">Terms of Service</a>. <span class="required-star">*</span>
      </span>
    </label>

  </fieldset>

  <button type="submit">Send Message</button>
</form>
```

### Field name rules

- `name`, `email`, `phone` — REQUIRED on every form. The CRM rejects submissions missing these. Field `name` attributes must match these strings exactly (lowercase).
- `service` — OPTIONAL but enables AI lead value estimation. Strongly recommended.
- `message` — OPTIONAL. Free-text field.
- `_honey` — REQUIRED. Spam protection. Must be visually hidden AND have `tabindex="-1"` and `autocomplete="off"`. Do NOT use `display:none` alone without `!important` — bots that parse CSS will skip it.
- `_next` — REQUIRED. Relative URL for thank-you redirect after submission. Default: `/thank-you`.

### What happens on submission

The CRM handles everything:
1. Lead saves to `portal_leads` table (client sees it in Portal realtime)
2. Linked to client's deal in Primary CRM (activity log entry)
3. Branded email sent to client with lead details + AI value estimate + Portal link
4. Customer Service CC'd on notification email (internal visibility)
5. User redirected to `_next` (the thank-you page)

### What NOT to include

- **NO** `_captcha`, `_subject`, `_template`, `_cc`, or any other formsubmit.co-legacy fields
- **NO** JavaScript for submission — native HTML form submit works and is more reliable
- **NO** external spam libraries (reCAPTCHA, hCaptcha) — honeypot + server-side rate limiting is sufficient
- **NO** mailto: action links — the CRM pipeline handles email delivery

### Thank-you page

Every build includes `/thank-you.php` with:
- `<meta name="robots" content="noindex,nofollow">` in head.php (via page-specific `$noindex = true`)
- Branded success message
- Phone number + CTA to call now
- Link back to home

---

## Footer Dofollow Link (REQUIRED — EVERY BUILD)

Every page must include via footer.php:

```html
<a href="https://pageoneinsights.com" rel="dofollow" target="_blank">Web Design & Hosting by Page One Insights, LLC</a>
```

No exceptions. Do not alter the anchor text. Do not add `rel="nofollow"`.

---

## PHP Include Path Rule (CRITICAL)

Every include across ALL .php files — root level and subdirectories — uses `$_SERVER['DOCUMENT_ROOT']`:

```php
include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php';
include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php';
```

**NEVER use relative paths** like `include 'includes/head.php'` or `include '../includes/head.php'`. Relative paths break on Hostinger when mod_rewrite rewrites the URL but PHP's working directory stays at the document root. Pages in real subdirectories (like `/services/`) will 404 or render broken.

`$_SERVER['DOCUMENT_ROOT']` is the only reliable method.

---

## .htaccess (Subdirectory-Safe)

The rewrite rules MUST exclude `/assets/` and `/includes/`, and MUST NOT use `!-d` (which breaks subdirectory pages on Hostinger):

```apache
RewriteEngine On

# Dynamic sitemap — /sitemap.xml is served by sitemap.php
RewriteRule ^sitemap\.xml$ /sitemap.php [L]

RewriteCond %{REQUEST_URI} !^/assets/
RewriteCond %{REQUEST_URI} !^/includes/
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^\.]+)$ $1.php [NC,L]
RewriteCond %{THE_REQUEST} /([^.]+)\.php [NC]
RewriteRule ^ /%1 [NC,L,R=301]
```

The `!-d` condition is intentionally removed. Without this fix, pages inside real subdirectories fail to resolve on Hostinger.

**URL shape rule:** ALL pages — including service pages — are built as `directory/index.php` with trailing-slash URLs (`/services/roof-repair/`). Never the dual flat-`.php` + directory-stub pattern (canonical/internal-link mismatch). See build-phases.md.

---

## Accessibility Baseline (REQUIRED)

Every build includes:

- **Skip-to-content link** as first element in nav.php:
  ```html
  <a href="#main-content" class="skip-link">Skip to main content</a>
  ```
  Visually hidden by default, visible on `:focus-visible`, positioned above navbar.
- `<main id="main-content">` wraps page content on every page
- All interactive elements: visible `:focus-visible` outline (2px solid `var(--color-accent)`, 2px offset)
- ARIA landmarks: `<nav aria-label="Main navigation">`, `<main>`, `<footer>`
- All form inputs: associated `<label>` element (floating label pattern satisfies this)
- Color contrast: minimum WCAG AA (4.5:1 body text, 3:1 large text) — verify brand colors meet this before finalizing palette
- Keyboard navigation: all interactive elements reachable and operable via keyboard
- `aria-expanded` toggled on mobile menu toggle button
- `aria-current="page"` on active nav link
- `prefers-reduced-motion` respected in CSS reset (see design-system.md Part A)

---

## Copy Quality Standards (REQUIRED)

### Banned phrases (never use)

- "quality service" / "quality workmanship"
- "trusted professionals"
- "contact us today" (as a headline — fine as button text)
- "your satisfaction is our priority"
- "we go above and beyond"
- "one-stop shop"
- "second to none"

### Required copy characteristics

- **Benefit-driven headlines** — what the customer gets, not what the company claims
- **Specific service language with local context** — reference neighborhoods, landmarks, regional conditions
- **Confident, direct tone** — no hedging, no marketing filler
- **Clear CTAs with urgency or specificity** — "Get Your Free Estimate" / "Call Now — Same-Day Available" (not "Contact Us")
- **Real numbers where possible** — cost ranges, timeframes, years in business, jobs completed
- **Answer-first paragraphs** — every service/area page opens with a direct answer in the first 50 words, not marketing fluff
- **Written for this specific business** — not templated. If the same copy could appear on a competitor's site, rewrite it.

---

## Design Anti-Patterns (STRICTLY FORBIDDEN)

- No generic centered text blocks repeated section after section
- No equal-height bland sections stacked with no visual variation
- No default/unstyled buttons — every button uses the button pattern from design-system.md (C9 and button patterns)
- No stock layout repetition across pages — each page uniquely composed
- No decorative-only animations — every animation serves UX
- No more than 2 fonts — one heading + one body (plus optional accent script/italic for specific use cases only)
- No weak hero sections — hero must feel premium immediately
- No flat depthless designs — use elevation system on all elements
- No unstyled form inputs — floating labels with animated focus states required
- No paragraphs wider than 65ch — all prose width-constrained via `.prose` or `.prose-centered`
- No raw rectangle images — all images use a composition treatment from design-system.md C11
- No meta keywords tag — Google has ignored it since 2009
- No Twitter/X card tags — no discovery value for local home service businesses
- No hardcoded colors, shadows, or spacing values in CSS — use `var()` tokens only

---

## Visual Restraint Rule (CRITICAL)

- Not every technique in the library should be used on every site
- Maximum of **3–4 major visual effects** per page (VanillaTilt, magnetic CTA, typed text, parallax, before/after slider each count as a major effect)
- Standard effects that do NOT count toward the limit: scroll fade-up reveals, image wipe reveal on scroll, ripple on click, card hover shift, Ken Burns hero, ticker strip
- If an effect does not enhance clarity or UX for this specific page, do not include it
- Prefer simplicity over stacking features
- Each site must feel intentionally designed, not feature-loaded

---

## Adaptive Design Flexibility

Claude Code MAY adjust:
- Spacing values within the token scale (choose appropriate `--space-*` per context)
- Section ordering (sequence of content sections on a page)
- Grid ratios (e.g. `2fr 1fr 1fr` vs `1fr 1fr 1fr` when appropriate)
- Visual accent placement (where floating elements, decorative corners, etc. land)
- Divider style selection (choose from design-system.md C3 based on archetype fit)

Claude Code MUST NOT skip or omit:
- PHP includes architecture (head.php, nav.php, footer.php)
- CSS variable system and token scale
- Schema markup requirements
- 3 CTAs per page
- Entity blocks and AEO content
- Accessibility features (skip-to-content, prefers-reduced-motion, alt tags, semantic HTML, focus-visible)
- Footer dofollow link
- Lead form endpoint configuration
- Tier-minimum CSS line count and technique count

This rule permits refinement of visual execution, not removal of structural requirements.

---

## Local Preview — PHP Required

Preview command is always:

```bash
php -S localhost:8000
```

Before running, verify PHP is installed:

```bash
which php && php -v
```

If PHP is not found, do NOT suggest `npx serve` or `python3 -m http.server` — these cannot process PHP includes and will render broken pages. Instead:

1. Offer to generate a single temporary static file (`index-preview.html`) with all includes inlined so the homepage can be visually verified
2. Inform the user to install PHP via Homebrew for full preview: `brew install php`

---

## Enforcement Pipeline

Builds pass through these checks in order:

1. **Phase 5 QA** — site-qa-agent skill runs 62+ checks + tier-specific CSS validation (file exists + line counts + technique detection). Generates structured JSON report.
2. **Fix All remediation (Premium only)** — if Premium build fails, Phase 6 auto-runs to bring failing pages up to standard by applying missing techniques page-by-page.
3. **Re-QA** — after Phase 6, full QA runs again. If still failing, build halts for manual review.
4. **Deployment** — only builds passing QA deploy to production.

See site-qa-agent/SKILL.md for validator implementation.

---

## Blog Standard (Premium — REQUIRED)

Every Premium build ships a blog. Full spec: `~/crm/references/blog-standard.md`. Enforcement summary:

- **Registry:** `includes/blog-data.php` — single `$blogPosts` array (slug, title, excerpt, image, alt, date, dateISO, category, readtime). The blog index, homepage preview, related-articles blocks, and sitemap.php ALL read from this registry. Hardcoded post lists anywhere = fail.
- **Structure:** `/blog/index.php` (editorial cards, category badges) + `/blog/{slug}/index.php` per post.
- **Homepage:** "From the Blog" preview section auto-pulling the latest registry post (featured card: image, category badge, date, read time, excerpt, CTA) + View All button.
- **Post anatomy:** answer-first intro (direct answer in first 50 words), TOC sidebar with anchors, sidebar CTA, Related Services block, Related Articles block (2-3 registry cards, same category first), ≥2 inline links to other posts and ≥2 to service pages in body copy.
- **Schema per post:** @graph — BlogPosting (author = Organization @id, datePublished/dateModified, keywords) + BreadcrumbList + FAQPage mirroring the visible FAQ.
- **SEO:** post titles ≤60 chars (no full brand suffix), unique descriptions, self-referencing canonical, auto-included in sitemap.php.
- **Content strategy:** topic clusters — 1 pillar + 4-7 supporting posts answering related long-tail questions, targeting DataForSEO keyword gaps.

---

## Pointers to Reference Files

For anything not covered above:

- **Visual architecture, CSS tokens, technique library, archetypes** → `~/crm/references/design-system.md`
- **SEO schema, meta tags, llms.txt, AEO content rules** → `~/crm/references/seo-aeo-2026.md`
- **PHP component structure, build phases, file organization, deployment** → `~/crm/references/build-phases.md`
- **Blog registry, post anatomy, topic clusters** → `~/crm/references/blog-standard.md`
- **Legal pages, TCPA consent, cookie banner, footer legal row** → `~/crm/references/legal-compliance.md`

If a requirement is not explicitly in this file and not in a reference file, it does not exist. Do not invent requirements.

---

## Required Components

This section defines reusable component patterns that MUST appear on every build, identical in structure across tiers. Brand colors, fonts, and copy are tier/client specific. Structure, class names, and HTML pattern are NOT.

QA validates these by class name. Builds missing these classes auto-fail.

---

### Services Section (REQUIRED — All Tiers, All Pages)

**Where it appears (mandatory):**
- Home page (the services overview)
- `/services/index.php` (the services listing page)
- Bottom of each individual service page (as "Related Services" — 3 cards)

**Where it does NOT appear:** legal pages, contact, thank-you.

**HTML pattern (exact class names — QA validates these):**

```html
<section class="section" aria-label="{Industry} services">
  <div class="container">
    <div class="section-title reveal-up">
      <span class="eyebrow-label">What We Do</span>
      <h2>{Question-format heading specific to the business}</h2>
      <p class="hero-answer">{40-60 word direct answer paragraph that answers the H2}</p>
      <span class="section-subtitle">{tagline phrase}</span>
      <p class="prose">{1-2 sentence description of the company's service mix}</p>
    </div>

    <div class="services-grid">
      <!-- Repeat this card for each service. Tints rotate 1, 2, 3, 1, 2, 3... -->
      <article class="service-card-with-image card-tint-1 reveal-up reveal-delay-1">
        <div class="service-card__image">
          <img src="/assets/images/{photo}.jpg" alt="{descriptive alt}" width="600" height="360" loading="lazy">
        </div>
        <div class="service-card__body">
          <div class="service-card__icon"><i data-lucide="{lucide-icon-name}"></i></div>
          <h3>{Service Name}</h3>
          <p class="service-card__desc">{1-sentence description, no fluff}</p>
          <ul>
            <li>{benefit/feature 1 — 3-6 words}</li>
            <li>{benefit/feature 2 — 3-6 words}</li>
            <li>{benefit/feature 3 — 3-6 words}</li>
          </ul>
          <a href="/services/{slug}/" class="service-card__cta">Learn more</a>
        </div>
      </article>
    </div>
  </div>
</section>
```

**Tint rotation rule:** Cards cycle through `card-tint-1` → `card-tint-2` → `card-tint-3` → `card-tint-1` → ... Never place two cards with the same tint class adjacent in the source. The `reveal-delay-1/2/3` modifier follows the same rotation.

**Bullet rule:** EXACTLY 3 bullets per card. Not 2, not 4. Each bullet 3-6 words, scannable, benefit-driven (not feature-only). Examples: "Same-day install on most homes", "Insurance claim support", "20–30 year service life". Avoid: "We use the best materials" (vague), "High-quality professional service" (filler).

**Icon mapping:** Use Lucide icons appropriate to the service. Industry guidance:
- Roofing: `home`, `shield`, `cloud-rain`, `wrench`, `hammer`, `hard-hat`, `building-2`
- Gutters: `ruler`, `droplets`, `filter`, `wrench`, `shield`, `building-2`, `sparkles`
- Lawn/Landscape: `leaf`, `scissors`, `sprout`, `flower-2`, `tree-pine`, `sun`
- Tree Service: `tree-pine`, `axe`, `chainsaw`, `shovel`, `wrench`
- HVAC: `thermometer`, `wind`, `flame`, `snowflake`, `wrench`, `zap`
- Plumbing: `droplets`, `wrench`, `pipe`, `shower-head`, `bath`
- Electrical: `zap`, `lightbulb`, `plug`, `bolt`, `wrench`
- Cleaning: `sparkles`, `spray-can`, `brush`, `wind`
- Generic: `check-circle`, `star`, `award`, `tool`

Each card's icon must be different from adjacent cards.

**Image rule:** Every card MUST have a real client photo. The build pipeline pre-stages photos in `/assets/images/`. Reference the AVAILABLE CLIENT IMAGES manifest. NO gradient placeholders, NO blank divs. If no client photo exists for a service, fall back to Unsplash Source API as last resort.

**Copy rules:**
- Card title: just the service name (no qualifiers like "Premium" or "Affordable")
- Description: 1 sentence, max 14 words, says what it actually is — not what it does for the customer's emotions
- Section heading: phrase as a CONVERSATIONAL QUESTION using customer-search language. Examples:
  - "What construction services does {company name} offer?"
  - "Which roofing services are available in {city}?"
  - "How does {company name} handle commercial HVAC needs?"
  - DO NOT use generic "Our Services" / "What We Do" / "Services Overview" — these are banned by aeo-content-schema.md §1.1
  - Two-tone treatment: highlight 1-3 keywords with <span class="text-accent">...</span> within the question
- Section eyebrow: "What We Do" (literal, do not vary)

**Required CSS variables (add to `:root` in styles.css):**

```css
:root {
  /* Tinted card backgrounds — recipe: brand colors at 6-9% alpha */
  --color-card-tint-1: rgba({primary-rgb}, 0.08);   /* primary brand color */
  --color-card-tint-2: rgba({primary-dark-rgb}, 0.06); /* darker primary */
  --color-card-tint-3: rgba({accent-rgb}, 0.09);    /* accent color */
  --color-card-tint-neutral: rgba(245, 247, 250, 1);
}
```

**Required CSS rules (add to styles.css — these class names are non-negotiable):**

```css
/* Tint utility classes */
.card-tint-1 { background: var(--color-card-tint-1); box-shadow: none; }
.card-tint-2 { background: var(--color-card-tint-2); box-shadow: none; }
.card-tint-3 { background: var(--color-card-tint-3); box-shadow: none; }
.card-tint-neutral { background: var(--color-card-tint-neutral); box-shadow: none; }

/* Services grid layout */
.services-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: var(--space-md);
}
@media (max-width: 1199px) {
  .services-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .services-grid { grid-template-columns: 1fr; }
}

/* Tinted image card */
.service-card-with-image {
  border-radius: var(--radius-md);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  transition: transform var(--transition-base), box-shadow var(--transition-base);
}
.service-card-with-image:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-md);
}
.service-card__image {
  position: relative;
  aspect-ratio: 5 / 3;
  overflow: hidden;
}
.service-card__image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.service-card__body {
  padding: var(--space-lg) var(--space-md) var(--space-md);
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: var(--space-sm);
  position: relative;
}
.service-card__icon {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  background: #fff;
  box-shadow: var(--shadow-md);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: -44px;  /* overlaps the image edge */
  margin-bottom: var(--space-xs);
  color: var(--color-accent);
}
.service-card__icon i,
.service-card__icon svg {
  width: 26px;
  height: 26px;
}
.service-card-with-image h3 {
  font-family: var(--font-heading);
  color: var(--color-primary);
  margin: 0;
  font-size: 1.35rem;
  line-height: 1.2;
}
.service-card__desc {
  color: var(--color-text);
  margin: 0;
  font-size: 0.95rem;
  line-height: 1.55;
}
.service-card-with-image ul {
  list-style: none;
  padding: 0;
  margin: var(--space-xs) 0 0;
  width: 100%;
  text-align: left;
  display: flex;
  flex-direction: column;
  gap: var(--space-xs);
  border-top: 1px solid rgba(0,0,0,0.06);
  padding-top: var(--space-md);
}
.service-card-with-image ul li {
  font-size: 0.9rem;
  color: var(--color-text);
  padding-left: 1.25rem;
  position: relative;
}
.service-card-with-image ul li::before {
  content: "•";
  color: var(--color-accent);
  font-weight: 700;
  position: absolute;
  left: 0.25rem;
  top: 0;
}
.service-card__cta {
  margin-top: auto;
  padding-top: var(--space-sm);
  color: var(--color-accent);
  font-weight: 600;
  text-decoration: none;
  font-size: 0.95rem;
  border-top: 1px solid rgba(0,0,0,0.06);
  width: 100%;
  text-align: center;
  padding: var(--space-sm) 0 0;
  transition: color var(--transition-base);
}
.service-card__cta::after {
  content: " →";
  display: inline-block;
  transition: transform var(--transition-base);
}
.service-card__cta:hover { color: var(--color-primary); }
.service-card__cta:hover::after { transform: translateX(3px); }
```

**Service count handling:**
- 3 services: render 3 cards in a 3-column row at desktop (CSS handles this — first row only fills what exists)
- 4 services: 4-up grid as specified
- 5-7 services: fills first row + partial second row
- 8 services: two clean rows of 4
- 9+ services: render the first 8 in the home grid, then below the grid render `<a href="/services/" class="btn-secondary">View All {N} Services →</a>`. Render ALL services on `/services/index.php`.

**Reuse on individual service pages (Related Services):**
At the bottom of each `/services/{slug}/index.php` page, render 3 randomly-selected OTHER services in the same `services-grid` + `service-card-with-image` pattern. Section heading: "Other Services You May Need". Use the same tint rotation rule.

**DO NOT (these auto-fail QA):**
- Use the legacy class names: `service-card`, `service-card-image`, `service-card-content`, `service-card-cta`
- Render service cards without the image-on-top pattern
- Use icon-only or gradient-only cards
- Use more than 3 bullets per card
- Use the same tint on adjacent cards
- Use stock photos when client photos exist for that service

