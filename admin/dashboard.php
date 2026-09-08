<?php
/**
 * Denvonbay - Admin Dashboard
 */

$adminTitle = 'Dashboard';
require_once __DIR__ . '/admin-header.php';

// Fetch aggregate counts
$totalBookings   = (int)$pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$pendingBookings = (int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
$totalRooms      = (int)$pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
$unreadMessages  = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();

// Fetch 5 most recent bookings with room name
$recentStmt = $pdo->query("
    SELECT b.*, r.name AS room_name
    FROM bookings b
    LEFT JOIN rooms r ON b.room_id = r.id
    ORDER BY b.created_at DESC
    LIMIT 5
");
$recentBookings = $recentStmt->fetchAll();
?>

<div class="container admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="admin-header-title">Welcome, <?= e($_SESSION['admin_username'] ?? 'Admin') ?></h1>
            <p class="admin-header-desc">Overview of Denvonbay property activity and reservations.</p>
        </div>
        <div>
            <a href="bookings.php" class="btn btn-sm btn-primary">
                <i class="bi bi-calendar-check me-1"></i> View All Bookings
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="admin-stats-grid">
        <div class="admin-stat-card">
            <div class="admin-stat-icon blue"><i class="bi bi-calendar2-check"></i></div>
            <div>
                <div class="admin-stat-num"><?= $totalBookings ?></div>
                <div class="admin-stat-label">Total Bookings</div>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon orange"><i class="bi bi-hourglass-split"></i></div>
            <div>
                <div class="admin-stat-num"><?= $pendingBookings ?></div>
                <div class="admin-stat-label">Pending Requests</div>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon green"><i class="bi bi-door-open"></i></div>
            <div>
                <div class="admin-stat-num"><?= $totalRooms ?></div>
                <div class="admin-stat-label">Available Rooms</div>
            </div>
        </div>

        <div class="admin-stat-card">
            <div class="admin-stat-icon purple"><i class="bi bi-envelope"></i></div>
            <div>
                <div class="admin-stat-num"><?= $unreadMessages ?></div>
                <div class="admin-stat-label">New Messages</div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings Card -->
    <div class="admin-card">
        <div class="admin-card-title">
            <span><i class="bi bi-clock-history me-2 text-primary"></i> Recent Booking Requests</span>
            <a href="bookings.php" class="btn btn-sm btn-outline-primary" style="font-size: 0.8rem;">See All</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Check-in / Check-out</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentBookings)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No reservations recorded yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recentBookings as $b): ?>
                            <tr>
                                <td><strong><?= e($b['booking_ref']) ?></strong></td>
                                <td>
                                    <?= e($b['guest_name']) ?><br>
                                    <small class="text-muted"><?= e($b['phone']) ?></small>
                                </td>
                                <td><?= e($b['room_name'] ?? 'Custom / Package') ?></td>
                                <td>
                                    <?= format_date($b['check_in']) ?> — <?= format_date($b['check_out']) ?>
                                </td>
                                <td><strong><?= format_price($b['total_price']) ?></strong></td>
                                <td>
                                    <span class="badge-status badge-<?= e($b['status']) ?>">
                                        <?= e($b['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="booking-view.php?id=<?= (int)$b['id'] ?>" class="btn btn-sm btn-outline-secondary py-1 px-2" style="font-size: 0.8rem;">
                                        View
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Bootstrap 5 JS & Admin JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
