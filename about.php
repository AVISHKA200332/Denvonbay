<?php
/**
 * Denvonbay - About Us
 * --------------------
 * The story, philosophy, and hospitality of Denvonbay in Hiriketiya.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'About Us | Denvonbay Coastal Accommodation Hiriketiya';
$pageDescription = 'Learn the story behind Denvonbay, our relaxed 5-room coastal retreat just minutes from Hiriketiya Beach, Sri Lanka.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo/favicon.png">
    <link rel="apple-touch-icon" href="assets/images/logo/appicon.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/about.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-water"></i> Our Story</span>
        <h1 class="page-hero-title">About Denvonbay</h1>
        <p class="page-hero-subtitle">A calm, personal coastal retreat created for surfers, wanderers, and sun-seekers.</p>
    </div>
</section>

<main id="main-content">

    <!-- Intro Story Section -->
    <section class="about-intro-section">
        <div class="container">
            <div class="row align-items-center gy-5">
                <div class="col-lg-6" data-reveal="left">
                    <div class="about-img-wrap">
                        <img src="assets/images/explore/Lady_surfing_on_Sri_Lankan_202607061450.jpg"
                             alt="Coastal life near Hiriketiya" class="about-img">
                        <div class="about-badge">
                            <i class="bi bi-geo-alt-fill about-badge-icon"></i>
                            <div>
                                <strong>Hiriketiya Beach</strong>
                                <div style="font-size: 0.8rem; opacity: 0.8;">5 Minutes Walk</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-reveal="right">
                    <div class="about-content">
                        <span class="section-eyebrow-dark">Slow Living By The Ocean</span>
                        <h2 class="section-heading-dark">Born from a Love for Sri Lanka's South Coast.</h2>
                        <p class="about-lead">
                            Denvonbay was created with one simple conviction: traveling should feel restful, personal, and grounded in its surroundings.
                        </p>
                        <p class="about-text">
                            Tucked just a short walk away from the world-famous horseshoe curve of Hiriketiya Bay, Denvonbay offers a refuge from crowded mega-resorts. With only five thoughtfully appointed rooms, every guest receives genuine warmth and quiet comfort.
                        </p>
                        <p class="about-text">
                            Whether you start your morning catching early waves, enjoying a hot cup of Ceylon tea on your terrace, or reading under swaying palms, our home is designed to help you slow down.
                        </p>
                        <div class="d-flex gap-3 mt-4">
                            <a href="rooms.php" class="btn btn-hero-primary">View Our 5 Rooms <i class="bi bi-arrow-right ms-1"></i></a>
                            <a href="contact.php" class="btn btn-hero-secondary">Get In Touch</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Core Values -->
    <section class="values-section">
        <div class="container">
            <div class="section-header text-center" data-reveal="up">
                <span class="section-eyebrow-dark">What We Value</span>
                <h2 class="section-heading-dark">Hospitality with Heart</h2>
                <p class="section-subtext-dark">The guiding principles behind every stay at Denvonbay.</p>
            </div>
            <div class="values-grid">
                <div class="value-card" data-reveal="up" data-reveal-delay="0">
                    <div class="value-icon"><i class="bi bi-flower1"></i></div>
                    <h3 class="value-title">Peace & Simplicity</h3>
                    <p class="value-desc">No loud crowds, no unnecessary clutter. We focus on clean spaces, restful beds, and quiet coastal evenings.</p>
                </div>
                <div class="value-card" data-reveal="up" data-reveal-delay="100">
                    <div class="value-icon"><i class="bi bi-tsunami"></i></div>
                    <h3 class="value-title">Surf & Ocean Connection</h3>
                    <p class="value-desc">Hiriketiya is known worldwide for its forgiving beach break and scenic left reef point. We are here to help you ride your best wave.</p>
                </div>
                <div class="value-card" data-reveal="up" data-reveal-delay="200">
                    <div class="value-icon"><i class="bi bi-heart"></i></div>
                    <h3 class="value-title">Authentic Local Warmth</h3>
                    <p class="value-desc">Our team lives right here in the southern province. We share genuine tips on hidden beaches, secret cafes, and honest transport.</p>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Common JS -->
<script src="assets/js/common.js"></script>

</body>
</html>
