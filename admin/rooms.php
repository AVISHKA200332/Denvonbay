<?php
/**
 * Denvonbay - Admin Room Management
 * ---------------------------------
 * Manage room inventory, pricing, availability, and photographic assets.
 */

$adminTitle = 'Rooms';
require_once __DIR__ . '/admin-header.php';

// Handle POST actions (Delete, Toggle Availability)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token  = $_POST['csrf_token'] ?? '';
    $action = $_POST['action'] ?? '';
    $roomId = (int)($_POST['id'] ?? 0);

    if (!verify_csrf_token($token)) {
        set_flash('danger', 'Security validation failed (invalid CSRF token).');
        header('Location: rooms.php');
        exit;
    }

    if ($action === 'toggle_availability' && $roomId > 0) {
        $stmt = $pdo->prepare("UPDATE rooms SET is_available = NOT is_available WHERE id = ?");
        $stmt->execute([$roomId]);
        set_flash('success', 'Room availability status updated.');
    } elseif ($action === 'delete' && $roomId > 0) {
        $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->execute([$roomId]);
        set_flash('danger', 'Room deleted successfully.');
    }

    header('Location: rooms.php');
    exit;
}

$rooms = $pdo->query("SELECT * FROM rooms ORDER BY id ASC")->fetchAll();
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Room Inventory</h2>
        <p class="admin-page-desc">Manage coastal rooms displayed on the customer-facing website.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="room-add.php" class="admin-btn admin-btn-primary">
            <i class="bi bi-plus-lg"></i>
            <span>Add New Room</span>
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Room Name</th>
                    <th>Tag</th>
                    <th>Capacity</th>
                    <th>Bed Type</th>
                    <th>Price / Night</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($rooms)): ?>
                    <tr>
                        <td colspan="8">
                            <div class="admin-empty-state">
                                <div class="admin-empty-icon"><i class="bi bi-door-closed"></i></div>
                                <div class="admin-empty-title">No rooms added yet</div>
                                <div class="admin-empty-desc">Create your first coastal room to display on the public website.</div>
                                <a href="room-add.php" class="admin-btn admin-btn-primary">Add Room</a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rooms as $r): ?>
                        <tr>
                            <td>
                                <?php
                                $imgSrc = $r['image_url'];
                                if (strpos($imgSrc, 'http') !== 0 && strpos($imgSrc, '../') !== 0) {
                                    $imgSrc = '../' . ltrim($imgSrc, '/');
                                }
                                ?>
                                <img src="<?= e($imgSrc) ?>" alt="<?= e($r['name']) ?>" class="admin-thumb" onerror="this.src='../assets/images/logo/appicon.png'">
                            </td>
                            <td>
                                <div class="fw-bold text-dark fs-6"><?= e($r['name']) ?></div>
                                <div class="text-muted small">Slug: <code><?= e($r['slug']) ?></code></div>
                            </td>
                            <td>
                                <?php if (!empty($r['tag'])): ?>
                                    <span class="badge bg-light text-primary border"><?= e($r['tag']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <i class="bi bi-people me-1 text-muted"></i><?= (int)$r['capacity'] ?> Guest(s)
                            </td>
                            <td><?= e($r['bed_type']) ?></td>
                            <td class="fw-bold text-dark fs-6">
                                <?= format_price($r['price_per_night']) ?>
                            </td>
                            <td>
                                <form method="POST" action="rooms.php" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                    <input type="hidden" name="action" value="toggle_availability">
                                    <button type="submit" class="badge-status border-0 <?= $r['is_available'] ? 'badge-confirmed' : 'badge-inactive' ?>" style="cursor: pointer;" title="Click to toggle availability">
                                        <?= $r['is_available'] ? 'Available' : 'Unavailable' ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="admin-actions-cell">
                                    <a href="../room-details.php?id=<?= (int)$r['id'] ?>" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary admin-btn-sm" title="Preview on live website">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>

                                    <a href="room-edit.php?id=<?= (int)$r['id'] ?>" class="admin-btn admin-btn-primary admin-btn-sm" title="Edit room details">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form method="POST" action="rooms.php" class="d-inline form-confirm-delete" data-confirm-msg="Are you sure you want to permanently delete '<?= e(addslashes($r['name'])) ?>'?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete room">
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
