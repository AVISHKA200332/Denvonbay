<?php
/**
 * Denvonbay - Amenities
 * ---------------------
 * Overview of property facilities and guest amenities.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Amenities & Facilities | Denvonbay Hiriketiya';
$pageDescription = 'Enjoy high-speed Wi-Fi, surfboard storage, outdoor tropical showers, daily breakfast, and relaxed garden spaces at Denvonbay.';
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
    <link rel="stylesheet" href="assets/css/amenities.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-stars"></i> Amenities</span>
        <h1 class="page-hero-title">Thoughtful Comforts</h1>
        <p class="page-hero-subtitle">Everything you need for an easy, comfortable, and refreshing tropical holiday.</p>
    </div>
</section>

<main id="main-content">

    <section class="amenities-page-section">
        <div class="container">

            <!-- Stay Essentials -->
            <h2 class="amenity-category-title" data-reveal="up">
                <i class="bi bi-house-check"></i> Stay Essentials
            </h2>
            <div class="amenities-grid-full">
                <div class="amenity-card-item" data-reveal="up" data-reveal-delay="0">
                    <div class="amenity-card-icon"><i class="bi bi-wifi"></i></div>
                    <div>
                        <h3 class="amenity-card-heading">High-Speed Wi-Fi</h3>
                        <p class="amenity-card-desc">Reliable fiber internet throughout rooms and garden lounge for remote workers and travelers.</p>
                    </div>
                </div>
                <div class="amenity-card-item" data-reveal="up" data-reveal-delay="100">
                    <div class="amenity-card-icon"><i class="bi bi-snow"></i></div>
                    <div>
                        <h3 class="amenity-card-heading">Air Conditioning</h3>
                        <p class="amenity-card-desc">Whisper-quiet climate control in rooms for deep, restful sleep after warm days in the sun.</p>
                    </div>
                </div>
                <div class="amenity-card-item" data-reveal="up" data-reveal-delay="200">
                    <div class="amenity-card-icon"><i class="bi bi-droplet-fill"></i></div>
                    <div>
                        <h3 class="amenity-card-heading">Rain Showers & Solar Hot Water</h3>
                        <p class="amenity-card-desc">Refreshing hot and cold showers powered by sustainable eco-friendly solar heating.</p>
                    </div>
                </div>
            </div>

            <!-- Surf & Coastal Living -->
            <h2 class="amenity-category-title" data-reveal="up">
                <i class="bi bi-tsunami"></i> Surf & Beach Friendly
            </h2>
            <div class="amenities-grid-full">
                <div class="amenity-card-item" data-reveal="up" data-reveal-delay="0">
                    <div class="amenity-card-icon"><i class="bi bi-water"></i></div>
                    <div>
                        <h3 class="amenity-card-heading">Board Storage & Wash Area</h3>
                        <p class="amenity-card-desc">Dedicated padded surfboard racks and outdoor freshwater rinse stations for salty gear.</p>
                    </div>
                </div>
                <div class="amenity-card-item" data-reveal="up" data-reveal-delay="100">
                    <div class="amenity-card-icon"><i class="bi bi-cup-hot"></i></div>
                    <div>
                        <h3 class="amenity-card-heading">Morning Breakfast</h3>
                        <p class="amenity-card-desc">Fresh tropical fruits, eggs cooked to order, Sri Lankan tea, and rich coffee to start your day.</p>
                    </div>
                </div>
                <div class="amenity-card-item" data-reveal="up" data-reveal-delay="200">
                    <div class="amenity-card-icon"><i class="bi bi-tree"></i></div>
                    <div>
                        <h3 class="amenity-card-heading">Tropical Garden Lounge</h3>
                        <p class="amenity-card-desc">Lush outdoor terrace surrounded by palms and birdsong, perfect for reading and winding down.</p>
                    </div>
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
