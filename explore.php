<?php
/**
 * Denvonbay - Explore Hiriketiya
 * ------------------------------
 * Guide to local beaches, surfing, dining, and activities.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Explore Hiriketiya | Denvonbay Area Guide';
$pageDescription = 'Your insider guide to Hiriketiya Beach, surfing breaks, hidden bays, local cafes, and coastal Sri Lanka experiences.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/explore.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-compass"></i> Local Guide</span>
        <h1 class="page-hero-title">Explore Hiriketiya & The South Coast</h1>
        <p class="page-hero-subtitle">World-class waves, serene coastal walks, vibrant beach cafes, and slow island life.</p>
    </div>
</section>

<main id="main-content">

    <section class="explore-page-section">
        <div class="container">

            <!-- Spot 1: Hiriketiya Bay -->
            <article class="explore-spot-card" data-reveal="up">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <img src="assets/images/explore/Lady_surfing_on_beach_2K_202607061446.jpg"
                             alt="Hiriketiya Beach surfing and horseshoe bay" class="explore-spot-img">
                    </div>
                    <div class="col-lg-6">
                        <div class="explore-spot-body">
                            <span class="explore-spot-distance"><i class="bi bi-geo-alt-fill"></i> 5 Mins Walk from Denvonbay</span>
                            <h2 class="explore-spot-title">Hiriketiya Bay (Horseshoe Bay)</h2>
                            <p class="explore-spot-desc">
                                Often called the jewel of the south coast, Hiriketiya is a picturesque horseshoe bay protected by lush palm-fringed headlands. It caters to every level of surfer: beginners can catch forgiving sandbar breaks in the center of the bay, while experienced surfers carve the famous left reef point.
                            </p>
                            <div class="explore-tips-box">
                                <h3 class="explore-tips-title"><i class="bi bi-lightbulb me-1"></i> Local Tip</h3>
                                <p class="explore-tips-text">The early morning session between 6:00 AM and 8:30 AM offers glassy water and fewer crowds.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Spot 2: Dickwella Beach -->
            <article class="explore-spot-card" data-reveal="up">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6 order-lg-2">
                        <img src="assets/images/explore/Surfer_carving_ocean_barrel_2K_202607210258.jpg"
                             alt="Dickwella Beach expansive coast" class="explore-spot-img">
                    </div>
                    <div class="col-lg-6 order-lg-1">
                        <div class="explore-spot-body">
                            <span class="explore-spot-distance"><i class="bi bi-geo-alt-fill"></i> 10 Mins Walk</span>
                            <h2 class="explore-spot-title">Dickwella Long Beach</h2>
                            <p class="explore-spot-desc">
                                If you crave wide open sand, gentle ocean breezes, and golden sunsets away from beach chairs, Dickwella Beach is right around the corner. A long, sweeping golden beach ideal for evening strolls, swimming, and quiet reflection.
                            </p>
                            <div class="explore-tips-box">
                                <h3 class="explore-tips-title"><i class="bi bi-lightbulb me-1"></i> Local Tip</h3>
                                <p class="explore-tips-text">Grab a fresh coconut from roadside vendors along the beach road as the sun dips below the horizon.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

            <!-- Spot 3: Yoga & Coastal Wellness -->
            <article class="explore-spot-card" data-reveal="up">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <img src="assets/images/explore/Woman_practicing_yoga_on_rooftop_202607210327.jpg"
                             alt="Yoga and mindfulness in Hiriketiya" class="explore-spot-img">
                    </div>
                    <div class="col-lg-6">
                        <div class="explore-spot-body">
                            <span class="explore-spot-distance"><i class="bi bi-geo-alt-fill"></i> In & Around Hiriketiya</span>
                            <h2 class="explore-spot-title">Yoga, Sound Baths & Wellness</h2>
                            <p class="explore-spot-desc">
                                Hiriketiya has developed into a peaceful hub for mindful living. You will find daily morning and sunset open-air yoga shalas, sound healing sessions, and traditional Ayurvedic massage centers scattered among the jungle paths.
                            </p>
                            <div class="explore-tips-box">
                                <h3 class="explore-tips-title"><i class="bi bi-lightbulb me-1"></i> Local Tip</h3>
                                <p class="explore-tips-text">Ask our front desk for recommended studios with drop-in class passes that suit your schedule.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </article>

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
