<?php
/**
 * Denvonbay - Admin Bookings Management
 * -------------------------------------
 * Filter, search, and manage guest reservations with double-booking prevention.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

// Handle POST actions (Update Status, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token   = $_POST['csrf_token'] ?? '';
    $action  = $_POST['action'] ?? '';
    $bookId  = (int)($_POST['id'] ?? 0);

    if (!verify_csrf_token($token)) {
        set_flash('danger', 'Security validation failed (invalid CSRF token). Please try again.');
        header('Location: bookings.php');
        exit;
    }

    if ($action === 'update_status' && $bookId > 0) {
        $newStatus = $_POST['new_status'] ?? '';
        $allowed = ['pending', 'confirmed', 'cancelled', 'completed'];

        if (in_array($newStatus, $allowed, true)) {
            // If confirming, check for double booking conflicts
            if ($newStatus === 'confirmed') {
                $bStmt = $pdo->prepare("SELECT * FROM bookings WHERE id = ?");
                $bStmt->execute([$bookId]);
                $booking = $bStmt->fetch();

                if ($booking && $booking['room_id']) {
                    $conflict = check_booking_overlap($pdo, $booking['room_id'], $booking['check_in'], $booking['check_out'], $bookId);
                    if ($conflict) {
                        set_flash('danger', sprintf(
                            'Cannot confirm reservation: Room conflicts with existing confirmed booking for %s (Ref: %s, %s to %s).',
                            e($conflict['guest_name']),
                            e($conflict['booking_ref']),
                            format_date($conflict['check_in']),
                            format_date($conflict['check_out'])
                        ));
                        header('Location: bookings.php');
                        exit;
                    }
                }
            }

            $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
            $stmt->execute([$newStatus, $bookId]);
            set_flash('success', 'Booking status updated to ' . ucfirst($newStatus) . '.');
        }
    } elseif ($action === 'delete' && $bookId > 0) {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$bookId]);
        set_flash('danger', 'Booking record deleted.');
    }

    header('Location: bookings.php');
    exit;
}

// Search and Filter parameters
$statusFilter = $_GET['status'] ?? 'all';
$searchQuery  = trim($_GET['q'] ?? '');

$sql = "
    SELECT b.*, r.name AS room_name, p.title AS package_title
    FROM bookings b
    LEFT JOIN rooms r ON b.room_id = r.id
    LEFT JOIN packages p ON b.package_id = p.id
    WHERE 1=1
";
$params = [];

if ($statusFilter !== 'all' && in_array($statusFilter, ['pending', 'confirmed', 'cancelled', 'completed'], true)) {
    $sql .= " AND b.status = ?";
    $params[] = $statusFilter;
}

if (!empty($searchQuery)) {
    $sql .= " AND (b.guest_name LIKE ? OR b.email LIKE ? OR b.phone LIKE ? OR b.booking_ref LIKE ?)";
    $like = '%' . $searchQuery . '%';
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
}

$sql .= " ORDER BY b.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$bookings = $stmt->fetchAll();

// Count per status for filter tabs
$countPending   = (int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
$countConfirmed = (int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'confirmed'")->fetchColumn();
$countCompleted = (int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'completed'")->fetchColumn();
$countCancelled = (int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'cancelled'")->fetchColumn();
$countAll       = (int)$pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();

$adminTitle = 'Bookings';
require_once __DIR__ . '/admin-header.php';
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Guest Reservations</h2>
        <p class="admin-page-desc">Track, confirm, and manage all room and package booking requests.</p>
    </div>
</div>

<!-- ===== SEARCH & FILTER BAR ===== -->
<div class="admin-filter-bar">
    <div class="admin-filter-pills">
        <a href="bookings.php" class="admin-filter-pill <?= ($statusFilter === 'all') ? 'active' : '' ?>">
            All (<?= $countAll ?>)
        </a>
        <a href="bookings.php?status=pending" class="admin-filter-pill <?= ($statusFilter === 'pending') ? 'active' : '' ?>">
            Pending (<?= $countPending ?>)
        </a>
        <a href="bookings.php?status=confirmed" class="admin-filter-pill <?= ($statusFilter === 'confirmed') ? 'active' : '' ?>">
            Confirmed (<?= $countConfirmed ?>)
        </a>
        <a href="bookings.php?status=completed" class="admin-filter-pill <?= ($statusFilter === 'completed') ? 'active' : '' ?>">
            Completed (<?= $countCompleted ?>)
        </a>
        <a href="bookings.php?status=cancelled" class="admin-filter-pill <?= ($statusFilter === 'cancelled') ? 'active' : '' ?>">
            Cancelled (<?= $countCancelled ?>)
        </a>
    </div>

    <form method="GET" action="bookings.php" class="admin-search-wrap">
        <?php if ($statusFilter !== 'all'): ?>
            <input type="hidden" name="status" value="<?= e($statusFilter) ?>">
        <?php endif; ?>
        <i class="bi bi-search text-muted me-1"></i>
        <input type="text" name="q" placeholder="Search by name, email, ref..." value="<?= e($searchQuery) ?>">
        <?php if (!empty($searchQuery)): ?>
            <a href="bookings.php<?= $statusFilter !== 'all' ? '?status=' . urlencode($statusFilter) : '' ?>" class="text-muted ms-1 text-decoration-none">
                <i class="bi bi-x-circle"></i>
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- ===== BOOKINGS TABLE CARD ===== -->
<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Room / Package</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Guests</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($bookings)): ?>
                    <tr>
                        <td colspan="11">
                            <div class="admin-empty-state">
                                <div class="admin-empty-icon"><i class="bi bi-calendar2-x"></i></div>
                                <div class="admin-empty-title">No reservations found</div>
                                <div class="admin-empty-desc">
                                    <?= !empty($searchQuery) ? 'No bookings match your search query "' . e($searchQuery) . '".' : 'No bookings in this filter category.' ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td>
                                <a href="booking-view.php?id=<?= (int)$b['id'] ?>" class="fw-bold text-primary text-decoration-none">
                                    <?= e($b['booking_ref']) ?>
                                </a>
                            </td>
                            <td>
                                <div class="fw-bold text-dark"><?= e($b['guest_name']) ?></div>
                                <small class="text-muted"><?= e($b['email']) ?></small>
                            </td>
                            <td>
                                <a href="https://wa.me/<?= preg_replace('/\D/', '', $b['phone']) ?>" target="_blank" rel="noopener" class="text-decoration-none text-muted" title="Message on WhatsApp">
                                    <i class="bi bi-whatsapp text-success me-1"></i><?= e($b['phone']) ?>
                                </a>
                            </td>
                            <td>
                                <?php if ($b['room_name']): ?>
                                    <span class="badge bg-light text-dark border"><?= e($b['room_name']) ?></span>
                                <?php elseif ($b['package_title']): ?>
                                    <span class="badge bg-light text-primary border"><?= e($b['package_title']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">General</span>
                                <?php endif; ?>
                            </td>
                            <td style="white-space: nowrap;"><?= format_date($b['check_in']) ?></td>
                            <td style="white-space: nowrap;"><?= format_date($b['check_out']) ?></td>
                            <td><?= (int)$b['guests'] ?></td>
                            <td class="fw-bold text-dark"><?= format_price($b['total_price']) ?></td>
                            <td>
                                <span class="badge-status badge-<?= e($b['status']) ?>">
                                    <?= e($b['status']) ?>
                                </span>
                            </td>
                            <td style="white-space: nowrap;" class="text-muted small">
                                <?= format_date($b['created_at']) ?>
                            </td>
                            <td>
                                <div class="admin-actions-cell">
                                    <a href="booking-view.php?id=<?= (int)$b['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm" title="View details">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <?php if ($b['status'] === 'pending'): ?>
                                        <form method="POST" action="bookings.php" class="d-inline">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                                            <input type="hidden" name="action" value="update_status">
                                            <input type="hidden" name="new_status" value="confirmed">
                                            <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm" title="Confirm Reservation">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>

                                    <form method="POST" action="bookings.php" class="d-inline form-confirm-delete" data-confirm-msg="Are you sure you want to permanently delete this booking record?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete record">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
