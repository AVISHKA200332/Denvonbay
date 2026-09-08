<?php
/**
 * Denvonbay - Admin Bookings Management
 */

$adminTitle = 'Bookings';
require_once __DIR__ . '/admin-header.php';

// Handle status updates
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $bookId = (int)$_GET['id'];

    if ($action === 'confirm') {
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'confirmed' WHERE id = ?");
        $stmt->execute([$bookId]);
        set_flash('success', 'Booking marked as confirmed.');
    } elseif ($action === 'cancel') {
        $stmt = $pdo->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ?");
        $stmt->execute([$bookId]);
        set_flash('warning', 'Booking marked as cancelled.');
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$bookId]);
        set_flash('danger', 'Booking record deleted.');
    }
    header('Location: bookings.php');
    exit;
}

$statusFilter = $_GET['status'] ?? 'all';

$sql = "
    SELECT b.*, r.name AS room_name
    FROM bookings b
    LEFT JOIN rooms r ON b.room_id = r.id
";
$params = [];

if ($statusFilter !== 'all' && in_array($statusFilter, ['pending', 'confirmed', 'cancelled'])) {
    $sql .= " WHERE b.status = ?";
    $params[] = $statusFilter;
}

$sql .= " ORDER BY b.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$bookings = $stmt->fetchAll();
?>

<div class="container admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="admin-header-title">Guest Bookings</h1>
            <p class="admin-header-desc">Manage room and package reservations.</p>
        </div>

        <!-- Filter pills -->
        <div class="btn-group" role="group">
            <a href="bookings.php?status=all" class="btn btn-sm <?= ($statusFilter === 'all') ? 'btn-primary' : 'btn-outline-secondary' ?>">All</a>
            <a href="bookings.php?status=pending" class="btn btn-sm <?= ($statusFilter === 'pending') ? 'btn-primary' : 'btn-outline-secondary' ?>">Pending</a>
            <a href="bookings.php?status=confirmed" class="btn btn-sm <?= ($statusFilter === 'confirmed') ? 'btn-primary' : 'btn-outline-secondary' ?>">Confirmed</a>
            <a href="bookings.php?status=cancelled" class="btn btn-sm <?= ($statusFilter === 'cancelled') ? 'btn-primary' : 'btn-outline-secondary' ?>">Cancelled</a>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Ref #</th>
                        <th>Guest Info</th>
                        <th>Room</th>
                        <th>Dates</th>
                        <th>Guests</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bookings)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No reservations matching filter.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bookings as $b): ?>
                            <tr>
                                <td><strong><?= e($b['booking_ref']) ?></strong></td>
                                <td>
                                    <strong><?= e($b['guest_name']) ?></strong><br>
                                    <small class="text-muted"><i class="bi bi-envelope"></i> <?= e($b['email']) ?></small><br>
                                    <small class="text-muted"><i class="bi bi-whatsapp"></i> <?= e($b['phone']) ?></small>
                                </td>
                                <td><?= e($b['room_name'] ?? 'N/A') ?></td>
                                <td>
                                    <?= format_date($b['check_in']) ?><br>
                                    <small class="text-muted">to <?= format_date($b['check_out']) ?></small>
                                </td>
                                <td><?= (int)$b['guests'] ?></td>
                                <td><strong><?= format_price($b['total_price']) ?></strong></td>
                                <td>
                                    <span class="badge-status badge-<?= e($b['status']) ?>">
                                        <?= e($b['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="booking-view.php?id=<?= (int)$b['id'] ?>" class="btn btn-outline-secondary" title="View details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php if ($b['status'] !== 'confirmed'): ?>
                                            <a href="bookings.php?action=confirm&id=<?= (int)$b['id'] ?>" class="btn btn-outline-success" title="Mark confirmed">
                                                <i class="bi bi-check-lg"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($b['status'] !== 'cancelled'): ?>
                                            <a href="bookings.php?action=cancel&id=<?= (int)$b['id'] ?>" class="btn btn-outline-warning" title="Mark cancelled">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="bookings.php?action=delete&id=<?= (int)$b['id'] ?>" class="btn btn-outline-danger btn-confirm-delete" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
