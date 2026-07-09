<?php
/* ============================================================
   includes/service-card.php
   ONE `.service-card-with-image` card — the component CLAUDE.md
   mandates under "Required Components → Services Section".

   Rendered by BOTH call sites so the markup cannot drift:
     • /services/index.php            — the full services grid
     • /services/{slug}/index.php     — "Other Services You May Need"

   Callers set, then include:
     $cardPage      array  a $servicePages entry: ['slug' => …, 'title' => …]
     $cardRotation  int    1|2|3 — tint + reveal-delay. Callers pass ($i % 3) + 1
                           so no two ADJACENT cards share a background.

   Structure is fixed by CLAUDE.md and validated by QA on class name:
   image on top → icon overlapping the image edge → h3 → one-sentence
   description → EXACTLY three bullets → "Learn more" CTA.

   The photo is that page's own first body photo. Five service pages carry a
   `photo_gap` (no photograph of the service exists yet); their cards still
   show a real Mauldin frame with its own honest alt text, never captioned as
   the linked service. Alt comes from $photoLibrary, which describes what is
   actually in the frame.
   ============================================================ */

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$cardMetaEntry = serviceCardMeta($cardPage['slug']);
$cardImg       = photo(servicePagePhotos($cardPage['slug'])['body'][0]);
$cardRotation  = $cardRotation ?? 1;
?>
<article class="service-card-with-image card-tint-<?php echo (int) $cardRotation; ?> reveal-up reveal-delay-<?php echo (int) $cardRotation; ?>">
    <div class="service-card__image">
        <img src="<?php echo e($cardImg['src']); ?>"
             alt="<?php echo e($cardImg['alt']); ?>"
             width="<?php echo e((string) $cardImg['w']); ?>"
             height="<?php echo e((string) $cardImg['h']); ?>"
             loading="lazy" decoding="async">
    </div>
    <div class="service-card__body">
        <div class="service-card__icon"><i data-lucide="<?php echo e($cardMetaEntry['icon']); ?>" aria-hidden="true"></i></div>
        <h3><?php echo e($cardPage['title']); ?></h3>
        <p class="service-card__desc"><?php echo e($cardMetaEntry['desc']); ?></p>
        <ul>
            <?php foreach ($cardMetaEntry['bullets'] as $cardBullet): ?>
                <li><?php echo e($cardBullet); ?></li>
            <?php endforeach; ?>
        </ul>
        <a href="/services/<?php echo e($cardPage['slug']); ?>/" class="service-card__cta">
            Learn more<span class="sr-only"> about <?php echo e($cardPage['title']); ?></span>
        </a>
    </div>
</article>
