<?php
/**
 * Denvonbay - Admin Packages Management
 */

$adminTitle = 'Packages Management';
require_once __DIR__ . '/admin-header.php';

if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $pId = (int)$_GET['id'];

    if ($action === 'toggle') {
        $stmt = $pdo->prepare("UPDATE packages SET is_active = 1 - is_active WHERE id = ?");
        $stmt->execute([$pId]);
        set_flash('success', 'Package status toggled.');
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM packages WHERE id = ?");
        $stmt->execute([$pId]);
        set_flash('danger', 'Package deleted.');
    }
    header('Location: packages.php');
    exit;
}

$packages = $pdo->query("SELECT * FROM packages ORDER BY id ASC")->fetchAll();
?>

<div class="container admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="admin-header-title">Package Management</h1>
            <p class="admin-header-desc">Manage holiday offers, surf packages, and special rates.</p>
        </div>
        <div>
            <a href="package-add.php" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i> Add New Package
            </a>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Package Title</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Badge</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($packages)): ?>
                        <tr><td colspan="7" class="text-center py-4 text-muted">No packages created yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($packages as $pkg): ?>
                            <tr>
                                <td><?= (int)$pkg['id'] ?></td>
                                <td>
                                    <strong><?= e($pkg['title']) ?></strong><br>
                                    <small class="text-muted"><?= e($pkg['subtitle'] ?? '') ?></small>
                                </td>
                                <td><?= e($pkg['duration']) ?></td>
                                <td><strong><?= format_price($pkg['price']) ?></strong></td>
                                <td><?= e($pkg['badge'] ?? '—') ?></td>
                                <td>
                                    <a href="packages.php?action=toggle&id=<?= (int)$pkg['id'] ?>"
                                       class="badge text-decoration-none <?= $pkg['is_active'] ? 'bg-success' : 'bg-secondary' ?>"
                                       title="Click to toggle status">
                                        <?= $pkg['is_active'] ? 'Active' : 'Inactive' ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="package-edit.php?id=<?= (int)$pkg['id'] ?>" class="btn btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="packages.php?action=delete&id=<?= (int)$pkg['id'] ?>" class="btn btn-outline-danger btn-confirm-delete" title="Delete">
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
