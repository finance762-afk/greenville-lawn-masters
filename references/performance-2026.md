# Performance Standard — 2026 (v6.2)

Mobile performance, asset discipline, and the JS diet for client sites. Companion to `design-system.md` (visual standard) and `seo-aeo-2026.md` (Core Web Vitals are a ranking tiebreaker; mobile is the measured experience).

**Load this file for:** Phase 1 (head.php, fonts), Phase 2 (CSS/animation architecture), image work in any phase, Phase 7 QA, performance AI edits.

---

## Part A — Performance Budget (QA-enforceable)

Every build ships within this budget. The first two columns are enforced by `qa_audit.py` statically; the render-time metrics are measured in the Puppeteer QA phase on a throttled mobile profile.

| Metric | Budget | Where enforced |
|---|---|---|
| LCP (mobile) | ≤ 2.0s | render phase (Puppeteer) |
| INP | < 200ms | render phase (Puppeteer) |
| CLS | < 0.1 | render phase (Puppeteer) |
| Total JS shipped | ≤ 100KB (uncompressed, sum of all .js + inline scripts) | qa_audit.py (static) |
| Largest hero image file | ≤ 150KB | qa_audit.py (static) |

The static budget is a **blocker on new builds**. Pre-v6.2 sites audit these as warnings (`--legacy` flag) until backported.

---

## Part B — Responsive Images (REQUIRED)

Hero and card images are generated at **480 / 960 / 1600 widths** as webp (sharp at build time) and served via `srcset` + `sizes`:

```html
<img src="/assets/images/hero-960.webp"
     srcset="/assets/images/hero-480.webp 480w,
             /assets/images/hero-960.webp 960w,
             /assets/images/hero-1600.webp 1600w"
     sizes="100vw"
     width="1600" height="900"
     alt="..." loading="eager" fetchpriority="high">
```

- Card/grid images: `sizes` reflects the rendered slot (e.g. `(max-width: 700px) 100vw, 33vw`).
- `<picture>` is reserved for **art direction** (different crops per breakpoint) — not for format/width switching, which `srcset` handles.
- Explicit `width`/`height` on every image, always (existing rule — prevents CLS).
- CSS `background-image` heroes use `image-set()` with the same three widths.

---

## Part C — JavaScript Diet

### Icons: inline SVG at build time

Icons are **inlined as SVG markup during the build** (the lucide-icons set lives in `~/crm/references/lucide-icons/`). **NEVER runtime icon injection** — no `<i data-lucide="...">` + `lucide.createIcons()`, no synchronous icon scripts. Runtime injection costs a render-blocking script, a layout shift per icon, and breaks no-JS rendering (see `aeo-crawlability.md`).

### Third-party JS: every external script must justify itself

- **No vanilla-tilt CDN.** If the card-tilt technique (design-system C10.1) is used, inline a ~30-line equivalent in the page's script block.
- **Simple carousels use CSS scroll-snap**, not Swiper. Swiper is permitted only when the build genuinely needs its features (free-mode momentum, complex pagination, synced galleries) — and then self-hosted, not CDN.
- Analytics/embeds load `defer` or after interaction; nothing third-party loads synchronously in `<head>`.

### Reveal animations: CSS first

Prefer **CSS scroll-driven animations** behind `@supports`, with the existing IntersectionObserver reveal system as the fallback:

```css
@supports (animation-timeline: view()) {
  .reveal {
    animation: reveal-up 0.6s ease both;
    animation-timeline: view();
    animation-range: entry 0% entry 40%;
  }
}
/* IO fallback (.reveal + .visible classes) stays for non-supporting browsers */
```

Both paths respect `prefers-reduced-motion` (existing rule).

---

## Part D — Fonts

- **Self-hosted woff2 subsets** in `/assets/fonts/`, declared via `@font-face` with `font-display: swap`.
- Preload the two above-the-fold faces (heading + body regular):
  `<link rel="preload" href="/assets/fonts/[file].woff2" as="font" type="font/woff2" crossorigin>`
- **No Google Fonts CDN on new builds** (`fonts.googleapis.com` / `fonts.gstatic.com`). Pre-v6.2 sites keep it until backported; their preconnect rule still applies.
- **Max 6 font files** total. Variable fonts preferred — one file covers the weight range.

---

## Part E — Enforcement Summary (v6.2 additions to qa_audit.py)

| Check | Severity (new build) | Severity (--legacy) |
|---|---|---|
| srcset+sizes on hero/card images | blocker | warning |
| Runtime icon injection (data-lucide / createIcons) | blocker | warning |
| Sync third-party scripts in head | blocker | warning |
| Google Fonts CDN | blocker | warning |
| Total JS > 100KB | blocker | warning |
| Hero image > 150KB | blocker | warning |
| Bare 100vh hero (no svh fallback) | warning | warning |
| LCP / INP / CLS | render phase (Puppeteer) | render phase |

---

*Canonical copy: `~/crm/references/performance-2026.md`. The pageone-web-builder skill references it via symlink.*
