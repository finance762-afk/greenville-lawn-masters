<?php
/* ============================================================
   includes/header.php
   Skip link, glassmorphism navbar, mobile overlay menu.
   Opens <main id="main-content"> — footer.php closes it.

   Phone-dependent CTAs (nav click-to-call, mobile menu call button)
   render ONLY when config.php has a real $phone. No placeholder number
   is ever emitted: a wrong phone number on a live local-business site
   is worse than a visibly missing one.
   ============================================================ */

require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$phoneDisplay = formatPhone($phone);
$phoneLink    = phoneHref($phone);
$hasPhone     = $phoneDisplay !== '' && $phoneLink !== '';
?>
<a href="#main-content" class="skip-link">Skip to main content</a>

<header class="site-header" data-header>
    <nav class="navbar" aria-label="Main navigation">
        <div class="navbar-inner container">

            <a href="/" class="navbar-logo" aria-label="<?php echo e($siteName); ?> — home">
                <span class="logo-mark" aria-hidden="true">G</span>
                <span class="logo-text">
                    <span class="logo-name"><?php echo e($siteName); ?></span>
                    <span class="logo-tagline"><?php echo e($tagline); ?></span>
                </span>
            </a>

            <ul class="navbar-links">
                <li>
                    <a href="/"<?php echo activeAria('home'); ?><?php echo isActivePage('home') ? ' class="is-active"' : ''; ?>>Home</a>
                </li>

                <li class="has-dropdown">
                    <a href="/services/"
                       <?php echo activeAria('services'); ?><?php echo isActivePage('services') ? ' class="is-active"' : ''; ?>
                       aria-haspopup="true"
                       aria-expanded="false">
                        Services
                        <i data-lucide="chevron-down" class="nav-caret" aria-hidden="true"></i>
                    </a>
                    <?php /* The inline style="display:none" is a MANDATORY failsafe (CLAUDE.md
                             → DROPDOWN — CRITICAL FAILSAFE). Hostinger caches CSS hard; without
                             it, a stale stylesheet renders this as a permanent bulleted list
                             under the navbar. The :hover/:focus-within rule uses !important to
                             beat the inline style. Do not remove. */ ?>
                    <ul class="dropdown" role="menu" style="display:none">
                        <?php foreach ($servicePages as $servicePage): ?>
                            <li role="none">
                                <a role="menuitem" href="/services/<?php echo e($servicePage['slug']); ?>/">
                                    <?php echo e($servicePage['title']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                        <li role="none" class="dropdown-all">
                            <a role="menuitem" href="/services/">View All Services</a>
                        </li>
                    </ul>
                </li>

                <li>
                    <a href="/service-areas/"<?php echo activeAria('service-areas'); ?><?php echo isActivePage('service-areas') ? ' class="is-active"' : ''; ?>>Service Area</a>
                </li>
                <li>
                    <a href="/about/"<?php echo activeAria('about'); ?><?php echo isActivePage('about') ? ' class="is-active"' : ''; ?>>About</a>
                </li>
                <li>
                    <a href="/contact/"<?php echo activeAria('contact'); ?><?php echo isActivePage('contact') ? ' class="is-active"' : ''; ?>>Contact</a>
                </li>
            </ul>

            <div class="navbar-cta">
                <?php if ($hasPhone): ?>
                    <a href="tel:<?php echo e($phoneLink); ?>" class="navbar-phone">
                        <i data-lucide="phone" aria-hidden="true"></i>
                        <span><?php echo e($phoneDisplay); ?></span>
                    </a>
                <?php endif; ?>
                <a href="/contact/" class="btn btn-nav">Free Estimate</a>
            </div>

            <button class="hamburger"
                    type="button"
                    aria-label="Open menu"
                    aria-controls="mobile-menu"
                    aria-expanded="false">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>

        </div>
    </nav>

    <div class="mobile-menu" id="mobile-menu" hidden>
        <ul class="mobile-menu-links">
            <li><a href="/">Home</a></li>
            <li>
                <a href="/services/">Services</a>
                <ul class="mobile-submenu">
                    <?php foreach ($servicePages as $servicePage): ?>
                        <li>
                            <a href="/services/<?php echo e($servicePage['slug']); ?>/">
                                <?php echo e($servicePage['title']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li><a href="/service-areas/">Service Area</a></li>
            <li><a href="/about/">About</a></li>
            <li><a href="/contact/">Contact</a></li>
        </ul>

        <div class="mobile-menu-cta">
            <?php if ($hasPhone): ?>
                <a href="tel:<?php echo e($phoneLink); ?>" class="btn btn-outline-white btn-lg">
                    <i data-lucide="phone" aria-hidden="true"></i>
                    Call <?php echo e($phoneDisplay); ?>
                </a>
            <?php endif; ?>
            <a href="/contact/" class="btn btn-accent btn-lg">Get a Free Estimate</a>
        </div>
    </div>
</header>

<main id="main-content">
