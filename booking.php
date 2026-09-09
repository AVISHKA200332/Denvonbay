<?php
/**
 * Denvonbay - Booking Request Form
 * --------------------------------
 * Reservation page for rooms and stay packages.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Book Your Stay | Denvonbay Hiriketiya';
$pageDescription = 'Reserve your stay at Denvonbay, Hiriketiya. Direct reservations for couples, solo surfers, and group retreats.';

$selectedRoomId = isset($_GET['room']) ? (int)$_GET['room'] : 0;
$rooms = get_rooms($pdo);

if (empty($rooms)) {
    $rooms = [
        ['id' => 1, 'name' => 'The Cozy Room', 'price_per_night' => 40.00, 'capacity' => 1],
        ['id' => 2, 'name' => "The Couple's Retreat", 'price_per_night' => 65.00, 'capacity' => 2],
        ['id' => 3, 'name' => "The Friends' Stay", 'price_per_night' => 90.00, 'capacity' => 4],
        ['id' => 4, 'name' => 'Family Room', 'price_per_night' => 110.00, 'capacity' => 5],
        ['id' => 5, 'name' => 'Garden Suite', 'price_per_night' => 80.00, 'capacity' => 2],
    ];
}

$flash = get_flash();
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
    <link rel="stylesheet" href="assets/css/contact.css">
    <link rel="stylesheet" href="assets/css/booking.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-calendar2-check"></i> Direct Reservation</span>
        <h1 class="page-hero-title">Book Your Stay at Denvonbay</h1>
        <p class="page-hero-subtitle">Secure your room near Hiriketiya beach. Simple, fast, and transparent.</p>
    </div>
</section>

<main id="main-content">

    <section class="booking-page-section">
        <div class="container">

            <?php if ($flash): ?>
                <div class="alert-flash alert-<?= e($flash['type']) ?> mb-4" data-reveal="up">
                    <i class="bi bi-info-circle-fill"></i>
                    <span><?= e($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <div class="row gy-5">

                <!-- Left Column: Booking Form -->
                <div class="col-lg-8" data-reveal="left">
                    <div class="booking-form-wrap">
                        <h2 class="section-heading-dark" style="font-size: 1.6rem; margin-bottom: 8px;">Reservation Details</h2>
                        <p class="section-subtext-dark" style="margin: 0 0 28px 0; max-width: 100%;">
                            No booking fees. Instant email confirmation and direct local assistance.
                        </p>

                        <form id="bookingForm" action="actions/submit-booking.php" method="POST">
                            
                            <!-- Room Choice -->
                            <div class="form-group mb-4">
                                <label for="bookingRoom" class="form-label">Select Room *</label>
                                <select id="bookingRoom" name="room_id" class="form-select" required>
                                    <?php foreach ($rooms as $r): ?>
                                        <option value="<?= (int)$r['id'] ?>"
                                                data-price="<?= (float)$r['price_per_night'] ?>"
                                                <?= ($selectedRoomId === (int)$r['id']) ? 'selected' : '' ?>>
                                            <?= e($r['name']) ?> - <?= format_price($r['price_per_night']) ?> / night (Max <?= (int)$r['capacity'] ?> Guests)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Dates -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6 form-group">
                                    <label for="checkIn" class="form-label">Check-in Date *</label>
                                    <input type="date" id="checkIn" name="check_in" class="form-control" required>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="checkOut" class="form-label">Check-out Date *</label>
                                    <input type="date" id="checkOut" name="check_out" class="form-control" required>
                                </div>
                            </div>

                            <!-- Guests -->
                            <div class="form-group mb-4">
                                <label for="bookingGuests" class="form-label">Number of Guests *</label>
                                <select id="bookingGuests" name="guests" class="form-select" required>
                                    <option value="1">1 Guest</option>
                                    <option value="2" selected>2 Guests</option>
                                    <option value="3">3 Guests</option>
                                    <option value="4">4 Guests</option>
                                    <option value="5">5 Guests</option>
                                </select>
                            </div>

                            <hr class="my-4 text-muted">

                            <!-- Guest Personal Info -->
                            <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--navy); margin-bottom: 20px;">
                                Guest Information
                            </h3>

                            <div class="row g-3">
                                <div class="col-md-12 form-group">
                                    <label for="guestName" class="form-label">Full Name *</label>
                                    <input type="text" id="guestName" name="guest_name" class="form-control" required placeholder="e.g. Elena Rostova">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="guestEmail" class="form-label">Email Address *</label>
                                    <input type="email" id="guestEmail" name="email" class="form-control" required placeholder="name@example.com">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="guestPhone" class="form-label">WhatsApp / Phone Number *</label>
                                    <input type="tel" id="guestPhone" name="phone" class="form-control" required placeholder="+1 234 567 8900">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label for="specialRequests" class="form-label">Special Requests (Optional)</label>
                                <textarea id="specialRequests" name="special_requests" class="form-control" rows="3" placeholder="Airport pickup, surf lesson advice, early arrival notes..."></textarea>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-hero-primary" style="padding: 16px 36px;">
                                    <i class="bi bi-check2-circle me-2"></i> Confirm Booking Request
                                </button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Right Column: Booking Estimate Summary -->
                <div class="col-lg-4" data-reveal="right">
                    <div class="booking-sidebar-card">
                        <h3 class="sidebar-heading">Booking Summary</h3>

                        <div class="sidebar-row">
                            <span>Selected Room:</span>
                            <strong id="summaryRoom" class="text-dark">Select a room</strong>
                        </div>

                        <div class="sidebar-row">
                            <span>Duration:</span>
                            <strong id="summaryNights" class="text-dark">1 night</strong>
                        </div>

                        <div class="sidebar-row">
                            <span>Nightly Rate:</span>
                            <strong id="summaryRate" class="text-dark">$0 / night</strong>
                        </div>

                        <div class="sidebar-row total">
                            <span>Estimated Total:</span>
                            <span id="summaryTotal" class="text-primary fs-4">$0</span>
                        </div>

                        <div class="mt-4 p-3 bg-light rounded-3" style="font-size: 0.825rem; color: var(--text-grey);">
                            <p class="mb-2"><i class="bi bi-shield-check text-success me-1"></i> No upfront payment required to submit a booking request.</p>
                            <p class="mb-0"><i class="bi bi-clock-history text-primary me-1"></i> Our team will confirm availability via WhatsApp &amp; email.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Scripts -->
<script src="assets/js/common.js"></script>
<script src="assets/js/booking.js"></script>

</body>
</html>
