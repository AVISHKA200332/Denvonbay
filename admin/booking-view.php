<?php
/**
 * Denvonbay - View Booking Details
 */

$adminTitle = 'Booking Details';
require_once __DIR__ . '/admin-header.php';

$bookingId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("
    SELECT b.*, r.name AS room_name, r.price_per_night, r.bed_type
    FROM bookings b
    LEFT JOIN rooms r ON b.room_id = r.id
    WHERE b.id = ?
");
$stmt->execute([$bookingId]);
$booking = $stmt->fetch();

if (!$booking) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Booking not found. <a href='bookings.php'>Return to Bookings</a></div></div>";
    exit;
}

// Handle status update POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_status'])) {
    $newStatus = sanitize($_POST['new_status']);
    if (in_array($newStatus, ['pending', 'confirmed', 'cancelled'])) {
        $uStmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $uStmt->execute([$newStatus, $bookingId]);
        set_flash('success', "Booking status updated to $newStatus.");
        header("Location: booking-view.php?id=$bookingId");
        exit;
    }
}
?>

<div class="container admin-container" style="max-width: 860px;">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <a href="bookings.php" class="text-decoration-none text-muted mb-2 d-inline-block">
                <i class="bi bi-arrow-left me-1"></i> Back to Bookings
            </a>
            <h1 class="admin-header-title">Booking: <?= e($booking['booking_ref']) ?></h1>
        </div>
        <div>
            <span class="badge-status badge-<?= e($booking['status']) ?> fs-6 px-3 py-2">
                <?= e($booking['status']) ?>
            </span>
        </div>
    </div>

    <div class="admin-card">
        <h2 class="admin-card-title mb-4">Guest Information</h2>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="text-muted small">Guest Name</div>
                <div class="fw-bold fs-5"><?= e($booking['guest_name']) ?></div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Number of Guests</div>
                <div class="fw-bold fs-5"><?= (int)$booking['guests'] ?> Guests</div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Email Address</div>
                <div class="fw-semibold">
                    <a href="mailto:<?= e($booking['email']) ?>" class="text-decoration-none"><?= e($booking['email']) ?></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Phone / WhatsApp</div>
                <div class="fw-semibold">
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $booking['phone']) ?>" target="_blank" rel="noopener" class="text-success text-decoration-none">
                        <i class="bi bi-whatsapp me-1"></i> <?= e($booking['phone']) ?>
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <h2 class="admin-card-title mb-4">Reservation Details</h2>
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <div class="text-muted small">Assigned Room</div>
                <div class="fw-bold text-primary fs-5"><?= e($booking['room_name'] ?? 'Unassigned / Custom') ?></div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Total Estimated Price</div>
                <div class="fw-bold text-success fs-5"><?= format_price($booking['total_price']) ?></div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Check-in Date</div>
                <div class="fw-semibold"><?= format_date($booking['check_in']) ?></div>
            </div>
            <div class="col-md-6">
                <div class="text-muted small">Check-out Date</div>
                <div class="fw-semibold"><?= format_date($booking['check_out']) ?></div>
            </div>
        </div>

        <?php if (!empty($booking['special_requests'])): ?>
            <div class="p-3 bg-light rounded-3 mb-4">
                <div class="text-muted small fw-bold mb-1">Special Requests / Notes:</div>
                <div><?= nl2br(e($booking['special_requests'])) ?></div>
            </div>
        <?php endif; ?>

        <hr class="my-4">

        <!-- Status Form -->
        <h2 class="admin-card-title mb-3">Update Status</h2>
        <form method="POST" action="booking-view.php?id=<?= $bookingId ?>" class="d-flex align-items-center gap-3">
            <select name="new_status" class="form-select" style="max-width: 200px;">
                <option value="pending" <?= ($booking['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
                <option value="confirmed" <?= ($booking['status'] === 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
                <option value="cancelled" <?= ($booking['status'] === 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary">Save Status</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
