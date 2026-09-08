<?php
/**
 * Denvonbay - Admin Rooms Management
 */

$adminTitle = 'Rooms Management';
require_once __DIR__ . '/admin-header.php';

// Handle toggle availability or delete
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $rId = (int)$_GET['id'];

    if ($action === 'toggle') {
        $stmt = $pdo->prepare("UPDATE rooms SET is_available = 1 - is_available WHERE id = ?");
        $stmt->execute([$rId]);
        set_flash('success', 'Room availability toggled.');
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->execute([$rId]);
        set_flash('danger', 'Room deleted.');
    }
    header('Location: rooms.php');
    exit;
}

$rooms = $pdo->query("SELECT * FROM rooms ORDER BY id ASC")->fetchAll();
?>

<div class="container admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="admin-header-title">Room Management</h1>
            <p class="admin-header-desc">Manage room listings, pricing, and availability.</p>
        </div>
        <div>
            <a href="room-add.php" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add New Room
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Room Name</th>
                        <th>Tag</th>
                        <th>Price / Night</th>
                        <th>Capacity</th>
                        <th>Bed Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rooms)): ?>
                        <tr><td colspan="8" class="text-center py-4 text-muted">No rooms created yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($rooms as $r): ?>
                            <tr>
                                <td><?= (int)$r['id'] ?></td>
                                <td><strong><?= e($r['name']) ?></strong></td>
                                <td><span class="badge bg-light text-dark border"><?= e($r['tag'] ?? 'Standard') ?></span></td>
                                <td><strong><?= format_price($r['price_per_night']) ?></strong></td>
                                <td><?= (int)$r['capacity'] ?> Guests</td>
                                <td><?= e($r['bed_type']) ?></td>
                                <td>
                                    <a href="rooms.php?action=toggle&id=<?= (int)$r['id'] ?>"
                                       class="badge text-decoration-none <?= $r['is_available'] ? 'bg-success' : 'bg-secondary' ?>"
                                       title="Click to toggle status">
                                        <?= $r['is_available'] ? 'Available' : 'Hidden' ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="room-edit.php?id=<?= (int)$r['id'] ?>" class="btn btn-outline-primary" title="Edit room">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="rooms.php?action=delete&id=<?= (int)$r['id'] ?>" class="btn btn-outline-danger btn-confirm-delete" title="Delete room">
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
