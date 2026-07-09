# Blog Standard — Page One Insights

> Canonical copy: `~/crm/references/blog-standard.md`. The copy under
> `~/.claude/skills/pageone-web-builder/references/` is a symlink to this file.

Blogs are **REQUIRED on all Premium tier builds**. This pattern is modeled on the superior-home-builders v6.1 build. Basic and Standard tiers may add a blog as an upsell using the same pattern.

> **Reference Implementation:** `superior-home-builders` (`~/client-sites/superior-home-builders`, **staging** branch) is the canonical v6.1 example — blog registry (`includes/blog-data.php`), dynamic `sitemap.php` with per-URL image entries, `llms.txt`/`llms-full.txt`, directory-per-slug URLs, extracted template CSS in `framework.css`, Related Articles blocks. When building or fixing sites, consult its actual files for the working patterns rather than reconstructing them from spec.

---

## 1. The Registry — `includes/blog-data.php`

A single `$blogPosts` array is the only source of truth for blog content metadata. The blog index, homepage preview, related-articles blocks, and sitemap.php ALL read from this registry. **No hardcoded duplicates anywhere.** Adding a post = adding one array entry + one post directory.

```php
<?php
// includes/blog-data.php — single source of truth for all blog post metadata.
// Newest post FIRST. Every consumer (blog index, homepage preview, related
// articles, sitemap.php) reads this array. Never hardcode post lists elsewhere.

$blogPosts = [
    [
        'slug'     => 'off-grid-home-cost-eastern-oregon',
        'title'    => 'What an Off-Grid Home Costs in Eastern Oregon',   // ≤ 60 chars, no brand suffix
        'excerpt'  => '1-2 sentence summary used on cards and the index page.',
        'image'    => '/assets/images/blog/off-grid-home-cost.jpg',
        'alt'      => 'Descriptive alt with keyword + location',
        'date'     => 'June 6, 2026',          // display format
        'dateISO'  => '2026-06-06',            // schema + sitemap lastmod
        'category' => 'Off-Grid Building',
        'readtime' => '7 min read',
    ],
    // ...
];
```

---

## 2. Structure & URLs

```
/blog/index.php            ← listing page
/blog/{slug}/index.php     ← one directory per post (trailing-slash URLs, like every page)
```

**Blog index (`/blog/index.php`):**
- Editorial cards rendered by looping `$blogPosts` — image, category badge, date, read time, title, excerpt, link
- Category badges; visually consistent with the site's design system (tinted cards, reveal animations)
- Unique title/description; BreadcrumbList schema

**Homepage — "From the Blog" preview section (required):**
- Auto-pulls the **latest** post (`$blogPosts[0]`) from the registry
- Featured card: image, category badge, date, read time, excerpt, CTA to the post
- "View All Articles" button linking to `/blog/`

---

## 3. Post Anatomy (every post)

1. **Answer-first intro** — the direct answer to the post's core question appears in the first 50 words. No throat-clearing.
2. **TOC sidebar** — anchor links to each H2 (sticky on desktop).
3. **Sidebar CTA** — phone + estimate CTA block in the sidebar.
4. **Body internal links** — at least **2 inline links to other blog posts** and **2 inline links to service pages**, woven into the copy with descriptive anchor text.
5. **Related Services block** — links to relevant service pages + the service-area page + contact.
6. **Related Articles block** (bottom) — 2-3 cards pulled from the registry, same-category posts first, then most recent.
7. **Visible FAQ section** — mirrored exactly by FAQPage schema (see below).
8. Images: hosted on the site's own domain (or client Supabase bucket), width/height/loading/alt on all.

---

## 4. Schema (per post)

One `@graph` containing:

- **BlogPosting** — `headline`, `image`, `datePublished`/`dateModified` (from `dateISO`), `keywords`, `author` = the Organization `@id` (NOT a fake person), `publisher` = Organization `@id`, `mainEntityOfPage` = canonical URL
- **BreadcrumbList** — Home → Blog → Post
- **FAQPage** — question/answer pairs that mirror the **visible** on-page FAQ exactly. Never schema-only FAQs.

---

## 5. SEO Rules

- Post titles **≤ 60 characters** — do NOT append the full brand suffix ("| Company | City, State"); a short brand or none at all
- Unique meta description per post
- Self-referencing canonical (computed by head.php from request URI)
- Posts are auto-included in sitemap.php via the registry — never hand-edit sitemaps

---

## 6. Content Strategy — Topic Clusters

Posts are built as **topic clusters**, not isolated articles:

- **1 pillar post** — comprehensive guide on a head topic (e.g., "Off-Grid Living in Oregon: The Complete Guide")
- **4-7 supporting posts** — each answers one related long-tail question (cost, permits, water, septic, solar, heating...), interlinked with the pillar and each other
- Topics are chosen from **keyword gaps in the DataForSEO scan** — questions competitors rank for that the client doesn't, plus unanswered long-tail queries

**Rationale:** AI Overview citations overwhelmingly come from pages that already rank organically, and answer engines favor complete topic clusters over isolated articles. A cluster establishes topical authority that single posts can't.

**Phase placement:** Premium builds ship the registry, blog index, homepage preview, and the first full cluster in Phase 4B (see build-phases.md).
