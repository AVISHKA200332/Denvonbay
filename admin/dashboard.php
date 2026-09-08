<?php
/**
 * Denvonbay - Modern Admin Dashboard
 * -----------------------------------
 * Real-time metrics, quick reservations overview, and inquiries.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';
require_admin_login();

$adminTitle = 'Dashboard';
require_once __DIR__ . '/admin-header.php';

// Fetch real MySQL aggregate counts
$totalRooms        = (int)$pdo->query("SELECT COUNT(*) FROM rooms WHERE is_available = 1")->fetchColumn();
$pendingBookings   = (int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
$confirmedBookings = (int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'confirmed'")->fetchColumn();
$unreadMessages    = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
$approvedReviews   = (int)$pdo->query("SELECT COUNT(*) FROM reviews WHERE is_approved = 1")->fetchColumn();
$totalPackages     = (int)$pdo->query("SELECT COUNT(*) FROM packages WHERE is_active = 1")->fetchColumn();

// Fetch 5 most recent bookings with room details
$recentBookingsStmt = $pdo->query("
    SELECT b.*, r.name AS room_name
    FROM bookings b
    LEFT JOIN rooms r ON b.room_id = r.id
    ORDER BY b.created_at DESC
    LIMIT 5
");
$recentBookings = $recentBookingsStmt->fetchAll();

// Fetch 5 most recent messages
$recentMessagesStmt = $pdo->query("
    SELECT * FROM contact_messages
    ORDER BY created_at DESC
    LIMIT 5
");
$recentMessages = $recentMessagesStmt->fetchAll();
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Welcome back, <?= e($adminUsername) ?></h2>
        <p class="admin-page-desc">Here is the real-time operational overview of Denvonbay property activity.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="bookings.php" class="admin-btn admin-btn-primary">
            <i class="bi bi-calendar2-check"></i>
            <span>Manage Bookings</span>
        </a>
    </div>
</div>

<!-- ===== SUMMARY METRICS GRID (6 Real Data Cards) ===== -->
<div class="admin-stats-grid">
    <!-- Total Rooms -->
    <div class="admin-stat-card">
        <div class="admin-stat-top">
            <span class="admin-stat-label">Active Rooms</span>
            <div class="admin-stat-icon blue"><i class="bi bi-door-open"></i></div>
        </div>
        <div class="admin-stat-num"><?= $totalRooms ?></div>
        <div class="admin-help-text">Available on site</div>
    </div>

    <!-- Pending Bookings -->
    <div class="admin-stat-card">
        <div class="admin-stat-top">
            <span class="admin-stat-label">Pending</span>
            <div class="admin-stat-icon yellow"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="admin-stat-num"><?= $pendingBookings ?></div>
        <div class="admin-help-text">Awaiting confirmation</div>
    </div>

    <!-- Confirmed Bookings -->
    <div class="admin-stat-card">
        <div class="admin-stat-top">
            <span class="admin-stat-label">Confirmed</span>
            <div class="admin-stat-icon green"><i class="bi bi-check2-circle"></i></div>
        </div>
        <div class="admin-stat-num"><?= $confirmedBookings ?></div>
        <div class="admin-help-text">Active reservations</div>
    </div>

    <!-- New Messages -->
    <div class="admin-stat-card">
        <div class="admin-stat-top">
            <span class="admin-stat-label">New Messages</span>
            <div class="admin-stat-icon purple"><i class="bi bi-envelope"></i></div>
        </div>
        <div class="admin-stat-num"><?= $unreadMessages ?></div>
        <div class="admin-help-text">Unread inquiries</div>
    </div>

    <!-- Approved Reviews -->
    <div class="admin-stat-card">
        <div class="admin-stat-top">
            <span class="admin-stat-label">Reviews</span>
            <div class="admin-stat-icon cyan"><i class="bi bi-star"></i></div>
        </div>
        <div class="admin-stat-num"><?= $approvedReviews ?></div>
        <div class="admin-help-text">Approved & published</div>
    </div>

    <!-- Total Packages -->
    <div class="admin-stat-card">
        <div class="admin-stat-top">
            <span class="admin-stat-label">Packages</span>
            <div class="admin-stat-icon teal"><i class="bi bi-boxes"></i></div>
        </div>
        <div class="admin-stat-num"><?= $totalPackages ?></div>
        <div class="admin-help-text">Active stay offers</div>
    </div>
</div>

<div class="row g-4">
    <!-- ===== RECENT BOOKINGS ===== -->
    <div class="col-xl-8 col-lg-12">
        <div class="admin-card">
            <div class="admin-card-title">
                <span><i class="bi bi-calendar-event text-primary"></i> Recent Booking Requests</span>
                <a href="bookings.php" class="admin-btn admin-btn-secondary admin-btn-sm">View All Bookings</a>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Guests</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentBookings)): ?>
                            <tr>
                                <td colspan="8">
                                    <div class="admin-empty-state">
                                        <div class="admin-empty-icon"><i class="bi bi-calendar2-x"></i></div>
                                        <div class="admin-empty-title">No bookings yet</div>
                                        <div class="admin-empty-desc">When guests submit booking requests, they will appear here.</div>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentBookings as $b): ?>
                                <tr>
                                    <td>
                                        <a href="booking-view.php?id=<?= (int)$b['id'] ?>" class="fw-bold text-decoration-none text-primary">
                                            <?= e($b['booking_ref']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?= e($b['guest_name']) ?></div>
                                        <div class="admin-help-text" style="margin:0;"><?= e($b['phone']) ?></div>
                                    </td>
                                    <td>
                                        <?= e($b['room_name'] ?? 'Custom / Package') ?>
                                    </td>
                                    <td><?= format_date($b['check_in']) ?></td>
                                    <td><?= format_date($b['check_out']) ?></td>
                                    <td><?= (int)$b['guests'] ?></td>
                                    <td>
                                        <span class="badge-status badge-<?= e($b['status']) ?>">
                                            <?= e($b['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="booking-view.php?id=<?= (int)$b['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm" title="View details">
                                            <i class="bi bi-eye"></i> Details
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

    <!-- ===== RECENT MESSAGES ===== -->
    <div class="col-xl-4 col-lg-12">
        <div class="admin-card">
            <div class="admin-card-title">
                <span><i class="bi bi-chat-dots text-primary"></i> Recent Messages</span>
                <a href="messages.php" class="admin-btn admin-btn-secondary admin-btn-sm">Inbox</a>
            </div>

            <?php if (empty($recentMessages)): ?>
                <div class="admin-empty-state">
                    <div class="admin-empty-icon"><i class="bi bi-inbox"></i></div>
                    <div class="admin-empty-title">No messages yet</div>
                    <div class="admin-empty-desc">Inquiries sent via the website contact form will appear here.</div>
                </div>
            <?php else: ?>
                <div class="d-flex flex-direction-column gap-3">
                    <?php foreach ($recentMessages as $m): ?>
                        <div class="p-3 border rounded-3 bg-white" style="<?= !$m['is_read'] ? 'border-left: 4px solid var(--admin-primary) !important;' : '' ?>">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold text-dark" style="font-size: 0.9rem;"><?= e($m['name']) ?></span>
                                <span class="admin-help-text" style="margin:0;"><?= format_date($m['created_at']) ?></span>
                            </div>
                            <div class="text-muted small text-truncate mb-2" style="max-width: 280px;">
                                <?= e($m['subject'] ?: $m['message']) ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge-status <?= $m['is_read'] ? 'badge-inactive' : 'badge-pending' ?>">
                                    <?= $m['is_read'] ? 'Read' : 'New' ?>
                                </span>
                                <a href="message-view.php?id=<?= (int)$m['id'] ?>" class="text-primary text-decoration-none small fw-semibold">
                                    View Message <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
