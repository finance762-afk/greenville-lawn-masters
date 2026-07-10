<?php
/* ============================================================
   includes/footer.php
   Closes <main>, renders footer, entity block, legal row,
   cookie banner, sticky mobile CTA bar, back-to-top, scripts.

   Pages may set before including:
     $useSwiper  bool  load Swiper CDN (reviews carousel)
     $useTilt    bool  load VanillaTilt CDN

   Swiper and VanillaTilt are gated behind those flags rather than
   loaded on every page: CLAUDE.md → PERFORMANCE SAFEGUARDS requires
   "Conditional CDN loading (Swiper/VanillaTilt/Typed only when
   $useSwiper/$useTilt/$useTyped flags set)". main.js already guards
   on `typeof Swiper !== 'undefined'`, so pages without the flag
   degrade cleanly.
   ============================================================ */

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';

$useSwiper = $useSwiper ?? false;
$useTilt   = $useTilt   ?? false;

/* 11 service pages split across two footer columns. */
$footerServicesLeft  = array_slice($servicePages, 0, 6);
$footerServicesRight = array_slice($servicePages, 6);
?>
</main>

<footer class="site-footer">
    <div class="footer-top">
        <div class="container">
            <div class="footer-grid">

                <!-- Col 1 — identity + trust -->
                <div class="footer-col footer-col--brand">
                    <div class="footer-logo">
                        <span class="logo-mark" aria-hidden="true">G</span>
                        <span class="logo-text">
                            <span class="logo-name"><?php echo e($siteName); ?></span>
                            <span class="logo-tagline"><?php echo e($tagline); ?></span>
                        </span>
                    </div>

                    <p>
                        <?php echo e($siteName); ?> keeps lawns in <?php echo e($address['city']); ?>
                        and the surrounding Greenville County area mowed, fed, and edged
                        year-round — from weekly mowing to aeration, sod, and seasonal cleanup.
                    </p>

                    <div class="footer-trust">
                        <span class="trust-badge">
                            <i data-lucide="shield-check" aria-hidden="true"></i>
                            Licensed &amp; Insured
                        </span>
                        <span class="trust-badge">
                            <i data-lucide="calendar-days" aria-hidden="true"></i>
                            <?php echo e((string) $yearsInBusiness); ?> Years Serving <?php echo e($address['city']); ?>
                        </span>
                        <span class="trust-badge">
                            <i data-lucide="clock" aria-hidden="true"></i>
                            Estimate Within 24 Hours
                        </span>
                    </div>
                </div>

                <!-- Col 2 — services -->
                <div class="footer-col">
                    <h4>Services</h4>
                    <ul>
                        <?php foreach ($footerServicesLeft as $servicePage): ?>
                            <li>
                                <a href="/services/<?php echo e($servicePage['slug']); ?>/">
                                    <?php echo e($servicePage['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Col 3 — more services + service areas -->
                <div class="footer-col">
                    <h4>More Services</h4>
                    <ul>
                        <?php foreach ($footerServicesRight as $servicePage): ?>
                            <li>
                                <a href="/services/<?php echo e($servicePage['slug']); ?>/">
                                    <?php echo e($servicePage['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <h4 class="footer-col__subhead">Service Area</h4>
                    <ul>
                        <?php foreach ($serviceAreas as $area): ?>
                            <li>
                                <a href="/service-areas/<?php echo e($area['slug']); ?>/">
                                    <?php echo e($area['city']); ?>, <?php echo e($area['state']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <li><a href="/service-areas/">View All Areas</a></li>
                    </ul>
                </div>

                <!-- Col 4 — contact -->
                <div class="footer-col">
                    <h4>Get In Touch</h4>

                    <?php if ($hasPhone): ?>
                        <a class="contact-item" href="tel:<?php echo e($phoneLink); ?>">
                            <i data-lucide="phone" aria-hidden="true"></i>
                            <?php echo e($phoneDisplay); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($email !== ''): ?>
                        <a class="contact-item" href="mailto:<?php echo e($email); ?>">
                            <i data-lucide="mail" aria-hidden="true"></i>
                            <?php echo e($email); ?>
                        </a>
                    <?php endif; ?>

                    <div class="contact-item">
                        <i data-lucide="map-pin" aria-hidden="true"></i>
                        <span>
                            <?php if ($address['street'] !== ''): ?>
                                <?php echo e($address['street']); ?><br>
                            <?php endif; ?>
                            <?php echo e($address['city']); ?>, <?php echo e($address['state']); ?> <?php echo e($address['zip']); ?>
                        </span>
                    </div>

                    <?php if (!empty($businessHours)): ?>
                        <div class="contact-item">
                            <i data-lucide="clock" aria-hidden="true"></i>
                            <span>
                                <?php foreach ($businessHours as $day => $window): ?>
                                    <?php echo e($day); ?>: <?php echo e($window[0]); ?>–<?php echo e($window[1]); ?><br>
                                <?php endforeach; ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <a href="/contact/" class="btn btn-accent footer-cta">Get a Free Estimate</a>
                </div>

            </div>

            <!-- AEO entity block — consistent NAP on every page.
                 Microdata mirrors the JSON-LD LocalBusiness node on the homepage.
                 telephone/street render only when real (see config.php $missingIntake). -->
            <div class="footer-entity aeo-entity" itemscope itemtype="https://schema.org/HomeAndConstructionBusiness">
                <meta itemprop="name" content="<?php echo e($siteName); ?>">
                <meta itemprop="url" content="<?php echo e(rtrim($siteUrl, '/') . '/'); ?>">
                <?php if ($hasPhone): ?>
                    <meta itemprop="telephone" content="<?php echo e($phoneLink); ?>">
                <?php endif; ?>
                <?php if ($email !== ''): ?>
                    <meta itemprop="email" content="<?php echo e($email); ?>">
                <?php endif; ?>

                <h4>About <?php echo e($siteName); ?></h4>
                <p itemprop="description">
                    <span itemprop="name"><?php echo e($siteName); ?></span> is a lawn care and
                    landscape maintenance company based in
                    <span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress"><?php
                        if ($address['street'] !== ''):
                            ?><span itemprop="streetAddress"><?php echo e($address['street']); ?></span>, <?php
                        endif;
                        ?><span itemprop="addressLocality"><?php echo e($address['city']); ?></span>,
                        <span itemprop="addressRegion"><?php echo e($address['state']); ?></span>
                        <span itemprop="postalCode"><?php echo e($address['zip']); ?></span></span>,
                    serving homeowners and businesses within <?php echo e((string) $targetRadius); ?> miles
                    of <?php echo e($address['city']); ?>. Founded in <?php echo e((string) $yearEstablished); ?>,
                    the company handles mowing, fertilization and weed control, aeration and
                    overseeding, sod installation, mulch, hedge and tree trimming, gutter
                    cleaning, pressure washing, and spring and fall cleanup.
                </p>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">

            <!-- Footer legal utility row — required above the copyright line -->
            <div class="footer-legal-row">
                <a href="/privacy-policy/">Privacy Policy</a>
                <span class="divider" aria-hidden="true">|</span>
                <a href="/terms/">Terms of Service</a>
                <span class="divider" aria-hidden="true">|</span>
                <a href="/cookie-policy/">Cookie Policy</a>
                <span class="divider" aria-hidden="true">|</span>
                <a href="/accessibility/">Accessibility</a>
                <span class="divider" aria-hidden="true">|</span>
                <a href="/privacy-policy/#ccpa-rights">Do Not Sell or Share My Personal Information</a>
                <span class="divider" aria-hidden="true">|</span>
                <?php /* /sitemap, not /sitemap.xml: no sitemap.xml rewrite exists in
                         .htaccess and nginx previews ignore .htaccess, so the .xml URL
                         404s in both environments. /sitemap → sitemap.php works in both. */ ?>
                <a href="/sitemap">Sitemap</a>
            </div>

            <div class="footer-bottom-bar">
                <p>&copy; <?php echo date('Y'); ?> <?php echo e($siteName); ?>. All rights reserved.</p>
                <p class="footer-credit">
                    <a href="https://pageoneinsights.com" rel="dofollow" target="_blank">Web Design &amp; Hosting by Page One Insights, LLC</a>
                </p>
            </div>

        </div>
    </div>
</footer>

<button type="button" class="back-to-top" aria-label="Back to top">
    <i data-lucide="arrow-up" aria-hidden="true"></i>
</button>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/cookie-banner.php'; ?>

<!-- Sticky mobile CTA bar. No SMS "Text Us" button: intake never recorded
     whether this client accepts texts, and texting a business that doesn't
     is a dead end for the visitor. Add a third sms: button once confirmed. -->
<div class="mobile-cta-bar">
    <?php if ($hasPhone): ?>
        <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-primary">
            <i data-lucide="phone" aria-hidden="true"></i> Call Now
        </a>
    <?php endif; ?>
    <a href="/contact/" class="btn btn-accent">
        <i data-lucide="clipboard-list" aria-hidden="true"></i> Free Estimate
    </a>
</div>

<!-- Lucide loads synchronously and BEFORE the deferred site scripts, so
     createIcons() has swapped every <i data-lucide> for an <svg> before
     animations.js or effects.js query the DOM (CLAUDE.md → LUCIDE ICONS). -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
<script>lucide.createIcons();</script>

<?php /* Vendor CDNs come BEFORE main.js. Deferred scripts execute in document
         order, and main.js gates its carousel init on `typeof Swiper !==
         'undefined'` — load Swiper after main.js and that guard always fails,
         silently leaving the reviews carousel as an unstyled stack. */ ?>
<?php if ($useSwiper): ?>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
<?php endif; ?>
<?php if ($useTilt): ?>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.8.1/dist/vanilla-tilt.min.js" defer></script>
<?php endif; ?>

<script src="/assets/js/main.js" defer></script>
<script src="/assets/js/animations.js" defer></script>
<script src="/assets/js/effects.js" defer></script>

</body>
</html>
