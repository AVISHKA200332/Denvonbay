<?php
/**
 * Denvonbay - Booking Confirmation
 * --------------------------------
 * Displayed upon successful booking request submission.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$bookingRef = isset($_GET['ref']) ? sanitize($_GET['ref']) : '';
$lastBooking = $_SESSION['last_booking'] ?? null;

$pageTitle = 'Booking Request Received | Denvonbay';
$pageDescription = 'Your booking request at Denvonbay Hiriketiya has been successfully submitted.';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">

    <!-- Favicon & Icons -->
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
    <link rel="stylesheet" href="assets/css/booking.css">
</head>
<body>

<?php include 'header.php'; ?>

<main id="main-content" style="padding: 80px 0; background-color: var(--off-white);">
    <div class="container">
        <div class="booking-success-box" data-reveal="up">
            <div class="success-icon-circle">
                <i class="bi bi-check-lg"></i>
            </div>

            <span class="section-eyebrow-dark">Thank You</span>
            <h1 class="section-heading-dark" style="font-size: 2.25rem;">Booking Request Received!</h1>
            <p class="about-text" style="margin: 0 auto; max-width: 500px;">
                We have received your reservation request. Our team will verify room availability and confirm with you via WhatsApp and email within a few hours.
            </p>

            <?php if (!empty($bookingRef)): ?>
                <div class="booking-ref-badge">
                    REFERENCE: <strong><?= e($bookingRef) ?></strong>
                </div>
            <?php endif; ?>

            <?php if ($lastBooking): ?>
                <div class="p-4 bg-light rounded-3 text-start mb-4" style="font-size: 0.9rem;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Guest:</span>
                        <strong><?= e($lastBooking['guest_name']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Dates:</span>
                        <strong><?= format_date($lastBooking['check_in']) ?> — <?= format_date($lastBooking['check_out']) ?></strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Duration:</span>
                        <strong><?= (int)$lastBooking['nights'] ?> night(s)</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Estimated Total:</span>
                        <strong class="text-primary"><?= format_price($lastBooking['total']) ?></strong>
                    </div>
                </div>
            <?php endif; ?>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="index.php" class="btn btn-hero-secondary">
                    <i class="bi bi-house me-1"></i> Return Home
                </a>
                <a href="https://wa.me/94771234567?text=<?= urlencode('Hi Denvonbay, I just placed booking reference ' . $bookingRef) ?>"
                   target="_blank" rel="noopener" class="btn btn-hero-primary">
                    <i class="bi bi-whatsapp me-1"></i> Chat with Us
                </a>
            </div>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Common JS -->
<script src="assets/js/common.js"></script>

</body>
</html>
