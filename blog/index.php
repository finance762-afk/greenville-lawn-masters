<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/functions.php';

$pageTitle = 'Lawn Care Blog | Greenville Lawn Masters | Mauldin, SC';
$pageDescription = 'Expert lawn care tips, seasonal guides, and landscaping advice for Mauldin and Greenville area homeowners.';
$canonicalUrl = 'https://greenville-lawn-masters.pageone.cloud/blog/';
$currentPage = 'blog';
$noindex = true; // Blog not ready for indexing yet
?>
<!DOCTYPE html>
<html lang="en">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/head.php'; ?>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/nav.php'; ?>

<main id="main-content">
    <section class="hero hero--simple">
        <div class="container">
            <h1>Lawn Care Blog</h1>
            <p class="hero-subtitle">Expert tips and seasonal guides for Mauldin area homeowners</p>
        </div>
    </section>

    <section class="section">
        <div class="container prose-centered">
            <p>Our blog is coming soon! Check back for lawn care tips, seasonal maintenance guides, and local landscaping advice.</p>
            <p><a href="/" class="btn-primary">Return to Homepage</a></p>
        </div>
    </section>
</main>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php'; ?>
</body>
</html>
