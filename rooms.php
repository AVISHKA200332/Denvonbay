<?php
/**
 * Denvonbay - Rooms Page
 * ----------------------
 * Browse all 5 coastal rooms in Hiriketiya.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Our Rooms | Denvonbay Hiriketiya';
$pageDescription = 'Discover our 5 peaceful rooms at Denvonbay. Cozy solo rooms, romantic couple retreats, and spacious group stays near Hiriketiya beach.';

// Fetch rooms from database
$rooms = get_rooms($pdo);

// Fallback if database empty
if (empty($rooms)) {
    $rooms = [
        [
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
        ],
        [
            'id' => 2,
            'name' => "The Couple's Retreat",
            'slug' => 'couples',
            'tag' => 'Most Popular',
            'price_per_night' => 65.00,
            'capacity' => 2,
            'bed_type' => 'Queen Bed',
            'image_url' => 'assets/images/explore/Woman_posing_in_bikini_2K_202607210231.jpg',
            'description' => 'A romantic coastal escape designed for two - comfortable, private and just steps from the beach.',
            'amenities' => 'Air Conditioning, High-Speed Wi-Fi, Balcony, Private En-suite, Mini Fridge, Breakfast Included'
        ],
        [
            'id' => 3,
            'name' => "The Friends' Stay",
            'slug' => 'friends',
            'tag' => 'Great for Groups',
            'price_per_night' => 90.00,
            'capacity' => 4,
            'bed_type' => '2 Double Beds',
            'image_url' => 'assets/images/explore/Friends_walking_on_beach_202607210209.jpg',
            'description' => 'Spacious, social and fun. The ideal base for a group trip to the south coast surf scene.',
            'amenities' => 'Air Conditioning, High-Speed Wi-Fi, Board Rack, Spacious Lounge, Garden View'
        ],
        [
            'id' => 4,
            'name' => 'Family Room',
            'slug' => 'family',
            'tag' => 'Spacious & Bright',
            'price_per_night' => 110.00,
            'capacity' => 5,
            'bed_type' => '1 King + 2 Singles',
            'image_url' => 'assets/images/explore/Tote_bag_with_branding_202607210209.jpg',
            'description' => 'Generously sized accommodation perfect for families traveling together, offering safety and comfort.',
            'amenities' => 'Air Conditioning, Fast Wi-Fi, Full En-suite, Kid-Friendly, Tea & Coffee Station'
        ],
        [
            'id' => 5,
            'name' => 'Garden Suite',
            'slug' => 'suite',
            'tag' => 'Peaceful Outlook',
            'price_per_night' => 80.00,
            'capacity' => 2,
            'bed_type' => 'King Bed',
            'image_url' => 'assets/images/explore/White_spa_slippers_on_beach_202607210209.jpg',
            'description' => 'Overlooking our lush tropical coastal greenery with a private terrace and refreshing breeze.',
            'amenities' => 'Tropical Garden Terrace, Air Conditioning, Rain Shower, Wi-Fi, Outdoor Seating'
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

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-house-door"></i> Accommodations</span>
        <h1 class="page-hero-title">Our Coastal Rooms</h1>
        <p class="page-hero-subtitle">Five unique spaces tailored for rest, coastal breezes, and slow mornings.</p>
    </div>
</section>

<main id="main-content">

    <section class="rooms-list-section">
        <div class="container">

            <?php foreach ($rooms as $index => $room): ?>
                <article class="room-full-card" id="<?= e($room['slug']) ?>" data-reveal="up">
                    <div class="row g-0 align-items-center">
                        <div class="col-lg-5">
                            <img src="<?= e($room['image_url']) ?>"
                                 alt="<?= e($room['name']) ?>"
                                 class="room-card-img-side" loading="lazy">
                        </div>
                        <div class="col-lg-7">
                            <div class="room-card-info">
                                <div>
                                    <?php if (!empty($room['tag'])): ?>
                                        <span class="room-tag"><?= e($room['tag']) ?></span>
                                    <?php endif; ?>
                                    <h2 class="room-title"><?= e($room['name']) ?></h2>
                                    <p class="room-desc"><?= e($room['description']) ?></p>

                                    <div class="room-specs">
                                        <span class="room-spec-item">
                                            <i class="bi bi-people-fill"></i> Up to <?= (int)$room['capacity'] ?> Guests
                                        </span>
                                        <span class="room-spec-item">
                                            <i class="bi bi-door-closed-fill"></i> <?= e($room['bed_type']) ?>
                                        </span>
                                        <span class="room-spec-item">
                                            <i class="bi bi-wifi"></i> Free Fast Wi-Fi
                                        </span>
                                        <span class="room-spec-item">
                                            <i class="bi bi-geo-alt"></i> Near Beach
                                        </span>
                                    </div>

                                    <?php if (!empty($room['amenities'])): ?>
                                        <p style="font-size: 0.8rem; color: var(--text-grey); margin-bottom: 20px;">
                                            <strong>Includes:</strong> <?= e($room['amenities']) ?>
                                        </p>
                                    <?php endif; ?>
                                </div>

                                <div class="room-footer">
                                    <div class="room-price">
                                        <span class="room-price-val"><?= format_price($room['price_per_night']) ?></span>
                                        <span class="room-price-unit">/ night</span>
                                    </div>
                                    <div class="room-actions">
                                        <a href="room-details.php?id=<?= (int)$room['id'] ?>" class="btn btn-hero-secondary" style="padding: 10px 20px; font-size: 0.875rem;">
                                            Details <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                        <a href="booking.php?room=<?= (int)$room['id'] ?>" class="btn btn-book" style="padding: 10px 22px;">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>

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
