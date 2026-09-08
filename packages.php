<?php
/**
 * Denvonbay - Stay Packages
 * -------------------------
 * Flexible holiday and surf packages in Hiriketiya.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Stay Packages | Denvonbay Hiriketiya';
$pageDescription = 'Choose from flexible coastal packages: Day escapes, one-night getaways, weekend surf trips, and slow tropical stays in Hiriketiya.';

$packages = get_packages($pdo);

if (empty($packages)) {
    $packages = [
        [
            'id' => 1,
            'title' => 'Day Escape',
            'slug' => 'day-escape',
            'subtitle' => 'Beach day base camp',
            'duration' => 'Daytime Stay',
            'price' => 25.00,
            'badge' => null,
            'icon' => 'bi-sun',
            'features' => "Lounge access\nFresh towels\nSecure luggage storage\nShower access\nRefreshing welcome drink"
        ],
        [
            'id' => 2,
            'title' => 'One Night Getaway',
            'slug' => 'one-night',
            'subtitle' => 'Overnight coastal reset',
            'duration' => '1 Night',
            'price' => 55.00,
            'badge' => 'Most Booked',
            'icon' => 'bi-moon-stars',
            'features' => "1 night accommodation\nCoastal breakfast\nBeach towel service\nWi-Fi access\nFlexible check-in"
        ],
        [
            'id' => 3,
            'title' => 'Weekend Escape',
            'slug' => 'weekend',
            'subtitle' => 'Friday to Sunday surf vibe',
            'duration' => '2 Nights',
            'price' => 110.00,
            'badge' => 'Popular',
            'icon' => 'bi-calendar2-week',
            'features' => "2 nights accommodation\nDaily breakfast\n1 guided surf spot tour\nLate Sunday checkout\nFree board storage"
        ],
        [
            'id' => 4,
            'title' => 'Slow Island Stay',
            'slug' => 'slow-stay',
            'subtitle' => 'Extended tropical living',
            'duration' => '3+ Nights',
            'price' => 160.00,
            'badge' => 'Best Value',
            'icon' => 'bi-tropical-storm',
            'features' => "3+ nights stay\nDaily breakfast\nScooter rental discount\nLaundry service\nSurf & cafe guide"
        ]
    ];
}
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
    <link rel="stylesheet" href="assets/css/packages.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-calendar2-check"></i> Stay Packages</span>
        <h1 class="page-hero-title">Stay Your Way</h1>
        <p class="page-hero-subtitle">Curated packages designed for surf seekers, weekend travelers, and slow-travel wanderers.</p>
    </div>
</section>

<main id="main-content">

    <section class="packages-page-section">
        <div class="container">

            <div class="row gy-4">
                <?php foreach ($packages as $pkg): ?>
                    <?php
                        $featuresList = array_filter(array_map('trim', explode("\n", $pkg['features'] ?? '')));
                        $isFeatured = !empty($pkg['badge']);
                    ?>
                    <div class="col-lg-3 col-md-6" data-reveal="up">
                        <div class="package-full-card <?= $isFeatured ? 'featured' : '' ?>" id="<?= e($pkg['slug']) ?>">
                            <?php if (!empty($pkg['badge'])): ?>
                                <div class="package-badge-tag"><?= e($pkg['badge']) ?></div>
                            <?php endif; ?>

                            <div class="package-header">
                                <div class="package-icon-wrap">
                                    <i class="bi <?= e($pkg['icon'] ?? 'bi-sun') ?>"></i>
                                </div>
                                <h3 class="package-name"><?= e($pkg['title']) ?></h3>
                                <div class="package-duration-pill">
                                    <i class="bi bi-clock me-1"></i><?= e($pkg['duration']) ?>
                                </div>
                                <div class="package-price-box">
                                    <span class="package-price-num"><?= format_price($pkg['price']) ?></span>
                                    <span class="package-price-sub">/ stay</span>
                                </div>
                            </div>

                            <div class="package-features">
                                <?php foreach ($featuresList as $feat): ?>
                                    <div class="package-feature-item">
                                        <i class="bi bi-check-lg"></i>
                                        <span><?= e($feat) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <a href="booking.php?package=<?= urlencode($pkg['slug']) ?>"
                               class="btn <?= $isFeatured ? 'btn-hero-primary' : 'btn-hero-secondary' ?> w-100 mt-auto">
                                Book Package
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Custom Stay Banner -->
            <div class="package-custom-callout" data-reveal="up">
                <h3 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 12px;">Looking for Long Term or Group Stay?</h3>
                <p style="opacity: 0.85; max-width: 580px; margin: 0 auto 28px;">
                    We offer custom discounts for digital nomads and surf crews staying longer than 1 week. Talk directly with us.
                </p>
                <a href="contact.php" class="btn btn-cta-primary">
                    Request Custom Quote <i class="bi bi-arrow-right ms-1"></i>
                </a>
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
