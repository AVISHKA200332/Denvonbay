<?php
/**
 * Denvonbay - Room Details
 * ------------------------
 * Detailed view of a single room.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$roomId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$slug   = isset($_GET['slug']) ? sanitize($_GET['slug']) : '';

$room = null;
if ($roomId > 0) {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ? LIMIT 1");
    $stmt->execute([$roomId]);
    $room = $stmt->fetch();
} elseif (!empty($slug)) {
    $stmt = $pdo->prepare("SELECT * FROM rooms WHERE slug = ? LIMIT 1");
    $stmt->execute([$slug]);
    $room = $stmt->fetch();
}

// Fallback to room 1 if not found
if (!$room) {
    $stmt = $pdo->query("SELECT * FROM rooms ORDER BY id ASC LIMIT 1");
    $room = $stmt->fetch();
}

if (!$room) {
    $room = [
        'id' => 1,
        'name' => 'The Cozy Room',
        'slug' => 'cozy',
        'tag' => 'Perfect for Solo',
        'price_per_night' => 40.00,
        'capacity' => 1,
        'bed_type' => 'Single Bed',
        'image_url' => 'assets/images/explore/Surfboard_logo_detail_macro_shot_202607210209.jpg',
        'description' => 'A thoughtfully designed quiet retreat for the solo traveler who values simplicity and calm.',
        'amenities' => 'High-Speed Wi-Fi, Ceiling Fan, Work Desk, Private Bathroom, Daily Housekeeping'
    ];
}

$amenitiesList = array_map('trim', explode(',', $room['amenities'] ?? ''));

$pageTitle = e($room['name']) . ' | Denvonbay Hiriketiya';
$pageDescription = e($room['description']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDescription ?>">

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
    <link rel="stylesheet" href="assets/css/rooms.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="page-hero">
    <div class="container">
        <?php if (!empty($room['tag'])): ?>
            <span class="page-hero-badge"><i class="bi bi-tag"></i> <?= e($room['tag']) ?></span>
        <?php endif; ?>
        <h1 class="page-hero-title"><?= e($room['name']) ?></h1>
        <p class="page-hero-subtitle">Experience thoughtful coastal hospitality at Denvonbay.</p>
    </div>
</section>

<main id="main-content">

    <section class="room-details-section">
        <div class="container">
            <div class="row gy-5">

                <!-- Left Column: Media & Overview -->
                <div class="col-lg-8" data-reveal="left">
                    <img src="<?= e($room['image_url']) ?>"
                         alt="<?= e($room['name']) ?>"
                         class="room-gallery-main">

                    <h2 class="section-heading-dark" style="font-size: 1.75rem; margin-top: 12px;">Room Overview</h2>
                    <p class="about-text" style="font-size: 1.05rem; line-height: 1.8;">
                        <?= e($room['description']) ?>
                    </p>

                    <h3 class="mt-4 mb-3" style="font-size: 1.35rem; font-weight: 700;">Features & Amenities</h3>
                    <div class="room-amenities-list">
                        <?php foreach ($amenitiesList as $amenity): ?>
                            <?php if (!empty($amenity)): ?>
                                <div class="room-amenity-item">
                                    <i class="bi bi-check-circle-fill"></i>
                                    <span><?= e($amenity) ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <h3 class="mt-5 mb-3" style="font-size: 1.35rem; font-weight: 700;">Good to Know</h3>
                    <ul class="list-unstyled d-flex flex-column gap-2" style="font-size: 0.95rem; color: var(--text-grey);">
                        <li><i class="bi bi-clock me-2 text-primary"></i><strong>Check-in:</strong> 2:00 PM — 10:00 PM</li>
                        <li><i class="bi bi-clock-history me-2 text-primary"></i><strong>Check-out:</strong> 11:00 AM</li>
                        <li><i class="bi bi-droplet-half me-2 text-primary"></i><strong>Beach Access:</strong> 5-minute easy stroll to Hiriketiya bay</li>
                        <li><i class="bi bi-cup-hot me-2 text-primary"></i><strong>Breakfast:</strong> Available daily upon request</li>
                    </ul>
                </div>

                <!-- Right Column: Booking Widget Card -->
                <div class="col-lg-4" data-reveal="right">
                    <div class="booking-widget-card">
                        <div class="d-flex justify-content-between align-items-baseline mb-4">
                            <div>
                                <span style="font-size: 2rem; font-weight: 800; color: var(--navy);">
                                    <?= format_price($room['price_per_night']) ?>
                                </span>
                                <span style="font-size: 0.875rem; color: var(--text-grey);">/ night</span>
                            </div>
                            <span class="badge bg-light text-primary border px-3 py-2" style="border-radius: 50px;">
                                <i class="bi bi-shield-check me-1"></i> Best Rate
                            </span>
                        </div>

                        <div class="d-flex flex-column gap-2 mb-4 p-3 bg-light rounded-3" style="font-size: 0.875rem;">
                            <div class="d-flex justify-content-between">
                                <span><i class="bi bi-people me-1"></i> Capacity:</span>
                                <strong>Up to <?= (int)$room['capacity'] ?> Guests</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="bi bi-door-closed me-1"></i> Bed Type:</span>
                                <strong><?= e($room['bed_type']) ?></strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="bi bi-wifi me-1"></i> Wi-Fi:</span>
                                <strong class="text-success">Complimentary</strong>
                            </div>
                        </div>

                        <a href="booking.php?room=<?= (int)$room['id'] ?>" class="btn btn-hero-primary w-100 mb-3" style="border-radius: var(--radius-sm); padding: 14px;">
                            <i class="bi bi-calendar-check me-2"></i> Book This Room
                        </a>

                        <a href="https://wa.me/94771234567?text=<?= urlencode('Hi Denvonbay, I have an inquiry about ' . $room['name']) ?>"
                           target="_blank" rel="noopener"
                           class="btn btn-hero-secondary w-100" style="border-radius: var(--radius-sm); padding: 12px; font-size: 0.9rem;">
                            <i class="bi bi-whatsapp me-2 text-success"></i> Inquire via WhatsApp
                        </a>
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
