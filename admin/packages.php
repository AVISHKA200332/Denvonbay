<?php
/**
 * Denvonbay - Admin Packages Management
 * -------------------------------------
 * Manage coastal packages, durations, features, and pricing.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

// Handle POST actions (Delete, Toggle Active Status)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token     = $_POST['csrf_token'] ?? '';
    $action    = $_POST['action'] ?? '';
    $packageId = (int)($_POST['id'] ?? 0);

    if (!verify_csrf_token($token)) {
        set_flash('danger', 'Security validation failed (invalid CSRF token).');
        header('Location: packages.php');
        exit;
    }

    if ($action === 'toggle_active' && $packageId > 0) {
        $stmt = $pdo->prepare("UPDATE packages SET is_active = NOT is_active WHERE id = ?");
        $stmt->execute([$packageId]);
        set_flash('success', 'Package active status updated.');
    } elseif ($action === 'delete' && $packageId > 0) {
        $stmt = $pdo->prepare("DELETE FROM packages WHERE id = ?");
        $stmt->execute([$packageId]);
        set_flash('danger', 'Package deleted successfully.');
    }

    header('Location: packages.php');
    exit;
}

$packages = $pdo->query("SELECT * FROM packages ORDER BY id ASC")->fetchAll();

$adminTitle = 'Packages';
require_once __DIR__ . '/admin-header.php';
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Stay & Surf Packages</h2>
        <p class="admin-page-desc">Manage packages and experiences presented on the public website.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="package-add.php" class="admin-btn admin-btn-primary">
            <i class="bi bi-plus-lg"></i>
            <span>Add New Package</span>
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Package Name</th>
                    <th>Duration</th>
                    <th>Subtitle</th>
                    <th>Badge</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($packages)): ?>
                    <tr>
                        <td colspan="7">
                            <div class="admin-empty-state">
                                <div class="admin-empty-icon"><i class="bi bi-boxes"></i></div>
                                <div class="admin-empty-title">No packages created yet</div>
                                <div class="admin-empty-desc">Create vacation, getaway, or surf packages for visitors.</div>
                                <a href="package-add.php" class="admin-btn admin-btn-primary">Add Package</a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($packages as $p): ?>
                        <tr>
                            <td>
                                <div>
                                    <div class="fw-bold text-dark fs-6"><?= e($p['title']) ?></div>
                                    <div class="text-muted small">Slug: <code><?= e($p['slug']) ?></code></div>
                                </div>
                            </td>
                            <td><?= e($p['duration']) ?></td>
                            <td class="text-muted small"><?= e($p['subtitle'] ?: '-') ?></td>
                            <td>
                                <?php if (!empty($p['badge'])): ?>
                                    <span class="badge bg-light text-primary border"><?= e($p['badge']) ?></span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-bold text-dark fs-6"><?= format_price($p['price']) ?></td>
                            <td>
                                <form method="POST" action="packages.php" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                                    <input type="hidden" name="action" value="toggle_active">
                                    <button type="submit" class="badge-status border-0 <?= $p['is_active'] ? 'badge-confirmed' : 'badge-inactive' ?>" style="cursor: pointer;" title="Click to toggle status">
                                        <?= $p['is_active'] ? 'Active' : 'Hidden' ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="admin-actions-cell">
                                    <a href="../packages.php#<?= e($p['slug']) ?>" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary admin-btn-sm" title="View on customer site">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>

                                    <a href="package-edit.php?id=<?= (int)$p['id'] ?>" class="admin-btn admin-btn-primary admin-btn-sm" title="Edit package">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    <form method="POST" action="packages.php" class="d-inline form-confirm-delete" data-confirm-msg="Are you sure you want to delete '<?= e(addslashes($p['title'])) ?>'?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete package">
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
