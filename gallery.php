<?php
/**
 * Denvonbay - Photo Gallery
 * -------------------------
 * Visual showcase of Denvonbay and the Hiriketiya coastline.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Photo Gallery | Denvonbay Hiriketiya';
$pageDescription = 'Browse photos of Denvonbay rooms, Hiriketiya beach surfing, tropical gardens, and coastal moments in Sri Lanka.';

$galleryItems = [
    [
        'img' => 'assets/images/explore/Lady_surfing_on_beach_2K_202607061446.jpg',
        'title' => 'Surfing Hiriketiya',
        'sub' => 'Beach Break'
    ],
    [
        'img' => 'assets/images/explore/Female_surfer_walking_tropical_b…_202607210158.jpg',
        'title' => 'Morning Beach Walks',
        'sub' => 'Golden Hour'
    ],
    [
        'img' => 'assets/images/explore/Woman_practicing_yoga_on_rooftop_202607210327.jpg',
        'title' => 'Rooftop Yoga',
        'sub' => 'Mindfulness & Movement'
    ],
    [
        'img' => 'assets/images/explore/Surfer_carving_ocean_barrel_2K_202607210258.jpg',
        'title' => 'Ocean Waves',
        'sub' => 'South Coast Swell'
    ],
    [
        'img' => 'assets/images/explore/White_spa_slippers_on_beach_202607210209.jpg',
        'title' => 'Coastal Relaxation',
        'sub' => 'Quiet Comfort'
    ],
    [
        'img' => 'assets/images/explore/Friends_walking_on_beach_202607210209.jpg',
        'title' => 'Friends by the Ocean',
        'sub' => 'Shared Moments'
    ],
    [
        'img' => 'assets/images/explore/Woman_lying_on_beach_towel_202607210218.jpg',
        'title' => 'Warm Tropical Sands',
        'sub' => 'Afternoon Sun'
    ],
    [
        'img' => 'assets/images/explore/Surfboard_logo_detail_macro_shot_202607210209.jpg',
        'title' => 'Surf Craft Detail',
        'sub' => 'Board Storage'
    ],
    [
        'img' => 'assets/images/explore/Tote_bag_with_branding_202607210209.jpg',
        'title' => 'Beach Essentials',
        'sub' => 'Pack Light'
    ]
];
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
    <link rel="stylesheet" href="assets/css/gallery.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-camera"></i> Visuals</span>
        <h1 class="page-hero-title">Moments at Denvonbay</h1>
        <p class="page-hero-subtitle">A glimpse into life around our property and the scenic bays of Hiriketiya.</p>
    </div>
</section>

<main id="main-content">

    <section class="gallery-page-section">
        <div class="container">
            <div class="gallery-grid">
                <?php foreach ($galleryItems as $item): ?>
                    <div class="gallery-item" data-reveal="up">
                        <img src="<?= e($item['img']) ?>"
                             alt="<?= e($item['title']) ?>"
                             class="gallery-img" loading="lazy">
                        <div class="gallery-caption">
                            <span class="gallery-caption-title"><?= e($item['title']) ?></span>
                            <span class="gallery-caption-sub"><?= e($item['sub']) ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
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
