<?php
/**
 * Denvonbay - Booking Details View
 * --------------------------------
 * Comprehensive reservation inspector with status controls & overlap protection.
 */

$adminTitle = 'Booking Details';
require_once __DIR__ . '/admin-header.php';

$bookingId = (int)($_GET['id'] ?? 0);

if ($bookingId <= 0) {
    set_flash('danger', 'Invalid booking identifier.');
    header('Location: bookings.php');
    exit;
}

// Fetch booking record with room and package details
$stmt = $pdo->prepare("
    SELECT b.*, r.name AS room_name, r.price_per_night, p.title AS package_title, p.price AS package_price
    FROM bookings b
    LEFT JOIN rooms r ON b.room_id = r.id
    LEFT JOIN packages p ON b.package_id = p.id
    WHERE b.id = ?
");
$stmt->execute([$bookingId]);
$b = $stmt->fetch();

if (!$b) {
    set_flash('danger', 'Booking reservation not found.');
    header('Location: bookings.php');
    exit;
}

// Handle status change POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token     = $_POST['csrf_token'] ?? '';
    $action    = $_POST['action'] ?? '';
    $newStatus = $_POST['status'] ?? '';

    if (!verify_csrf_token($token)) {
        set_flash('danger', 'Security validation failed (invalid CSRF token).');
        header('Location: booking-view.php?id=' . $bookingId);
        exit;
    }

    if ($action === 'change_status' && in_array($newStatus, ['pending', 'confirmed', 'cancelled', 'completed'], true)) {
        // Double booking check when confirming
        if ($newStatus === 'confirmed' && $b['room_id']) {
            $conflict = check_booking_overlap($pdo, $b['room_id'], $b['check_in'], $b['check_out'], $bookingId);
            if ($conflict) {
                set_flash('danger', sprintf(
                    'Cannot confirm reservation: Room is already booked for %s (Ref: %s) from %s to %s.',
                    e($conflict['guest_name']),
                    e($conflict['booking_ref']),
                    format_date($conflict['check_in']),
                    format_date($conflict['check_out'])
                ));
                header('Location: booking-view.php?id=' . $bookingId);
                exit;
            }
        }

        $upStmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $upStmt->execute([$newStatus, $bookingId]);
        set_flash('success', 'Booking status updated to ' . ucfirst($newStatus) . '.');
        header('Location: booking-view.php?id=' . $bookingId);
        exit;
    }
}

// Calculate night duration
$d1 = new DateTime($b['check_in']);
$d2 = new DateTime($b['check_out']);
$nights = $d1->diff($d2)->days;
if ($nights <= 0) $nights = 1;
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Reservation #<?= e($b['booking_ref']) ?></h2>
        <p class="admin-page-desc">Submitted on <?= format_date($b['created_at']) ?> by <?= e($b['guest_name']) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="bookings.php" class="admin-btn admin-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Bookings</span>
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Main Reservation Details Card -->
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="admin-card-title">
                <span><i class="bi bi-file-earmark-person text-primary"></i> Guest & Reservation Info</span>
                <span class="badge-status badge-<?= e($b['status']) ?>"><?= ucfirst(e($b['status'])) ?></span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="admin-label">Full Name</label>
                    <div class="p-2 border rounded bg-light fw-bold"><?= e($b['guest_name']) ?></div>
                </div>

                <div class="col-md-6">
                    <label class="admin-label">Email Address</label>
                    <div class="p-2 border rounded bg-light">
                        <a href="mailto:<?= e($b['email']) ?>" class="text-decoration-none text-primary fw-semibold">
                            <i class="bi bi-envelope me-1"></i><?= e($b['email']) ?>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="admin-label">Phone / WhatsApp</label>
                    <div class="p-2 border rounded bg-light">
                        <a href="https://wa.me/<?= preg_replace('/\D/', '', $b['phone']) ?>" target="_blank" rel="noopener" class="text-decoration-none text-success fw-semibold">
                            <i class="bi bi-whatsapp me-1"></i><?= e($b['phone']) ?>
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="admin-label">Number of Guests</label>
                    <div class="p-2 border rounded bg-light"><?= (int)$b['guests'] ?> Guest(s)</div>
                </div>
            </div>

            <hr class="my-4" style="border-color: var(--admin-border);">

            <div class="admin-card-title">
                <span><i class="bi bi-calendar-check text-primary"></i> Stay Schedule</span>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="admin-label">Check-In Date</label>
                    <div class="p-2 border rounded bg-light fw-bold text-dark">
                        <i class="bi bi-box-arrow-in-right text-primary me-1"></i><?= format_date($b['check_in']) ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="admin-label">Check-Out Date</label>
                    <div class="p-2 border rounded bg-light fw-bold text-dark">
                        <i class="bi bi-box-arrow-right text-primary me-1"></i><?= format_date($b['check_out']) ?>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="admin-label">Total Duration</label>
                    <div class="p-2 border rounded bg-light fw-bold text-dark">
                        <?= $nights ?> Night<?= $nights > 1 ? 's' : '' ?>
                    </div>
                </div>
            </div>

            <!-- Special Requests / Notes -->
            <div class="mb-2">
                <label class="admin-label">Special Requests & Notes</label>
                <div class="p-3 border rounded bg-light">
                    <?= !empty($b['special_requests']) ? nl2br(e($b['special_requests'])) : '<span class="text-muted fst-italic">No special requests provided.</span>' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side Summary & Status Management Card -->
    <div class="col-lg-4">
        <!-- Room & Payment Summary -->
        <div class="admin-card">
            <div class="admin-card-title">
                <span><i class="bi bi-credit-card text-primary"></i> Financial Summary</span>
            </div>

            <div class="mb-3">
                <div class="text-muted small">Selected Room</div>
                <div class="fw-bold text-dark fs-5"><?= e($b['room_name'] ?? 'Not specified') ?></div>
                <?php if ($b['price_per_night']): ?>
                    <div class="text-muted small"><?= format_price($b['price_per_night']) ?> / night</div>
                <?php endif; ?>
            </div>

            <?php if ($b['package_title']): ?>
                <div class="mb-3">
                    <div class="text-muted small">Selected Package</div>
                    <div class="fw-bold text-primary"><?= e($b['package_title']) ?></div>
                </div>
            <?php endif; ?>

            <hr class="my-3" style="border-color: var(--admin-border);">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Stay Calculation</span>
                <span><?= $nights ?> night(s)</span>
            </div>

            <div class="d-flex justify-content-between align-items-center fs-5 fw-bold text-dark">
                <span>Total Amount</span>
                <span class="text-primary"><?= format_price($b['total_price']) ?></span>
            </div>
        </div>

        <!-- Quick Status Control Panel -->
        <div class="admin-card">
            <div class="admin-card-title">
                <span><i class="bi bi-toggles text-primary"></i> Update Status</span>
            </div>

            <p class="admin-help-text mb-3">Changing status updates the reservation and checks room availability in real-time.</p>

            <div class="d-flex flex-column gap-2">
                <?php if ($b['status'] !== 'confirmed'): ?>
                    <form method="POST" action="booking-view.php?id=<?= $bookingId ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="change_status">
                        <input type="hidden" name="status" value="confirmed">
                        <button type="submit" class="admin-btn admin-btn-primary w-100">
                            <i class="bi bi-check2-circle"></i> Confirm Booking
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($b['status'] !== 'completed' && $b['status'] === 'confirmed'): ?>
                    <form method="POST" action="booking-view.php?id=<?= $bookingId ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="change_status">
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="admin-btn admin-btn-secondary w-100" style="color: var(--admin-info); border-color: var(--admin-info);">
                            <i class="bi bi-check-all"></i> Mark Completed
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($b['status'] !== 'cancelled'): ?>
                    <form method="POST" action="booking-view.php?id=<?= $bookingId ?>" class="form-confirm-delete" data-confirm-msg="Are you sure you want to cancel this booking?">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="change_status">
                        <input type="hidden" name="status" value="cancelled">
                        <button type="submit" class="admin-btn admin-btn-danger w-100">
                            <i class="bi bi-x-circle"></i> Cancel Booking
                        </button>
                    </form>
                <?php endif; ?>

                <?php if ($b['status'] !== 'pending'): ?>
                    <form method="POST" action="booking-view.php?id=<?= $bookingId ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" name="action" value="change_status">
                        <input type="hidden" name="status" value="pending">
                        <button type="submit" class="admin-btn admin-btn-secondary w-100">
                            <i class="bi bi-arrow-counterclockwise"></i> Revert to Pending
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
