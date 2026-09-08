<?php
/**
 * Denvonbay - Edit Package
 */

$adminTitle = 'Edit Package';
require_once __DIR__ . '/admin-header.php';

$pkgId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->execute([$pkgId]);
$pkg = $stmt->fetch();

if (!$pkg) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Package not found. <a href='packages.php'>Return to Packages</a></div></div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = sanitize($_POST['title'] ?? '');
    $slug     = sanitize($_POST['slug'] ?? '');
    $subtitle = sanitize($_POST['subtitle'] ?? '');
    $duration = sanitize($_POST['duration'] ?? '');
    $price    = (float)($_POST['price'] ?? 0);
    $badge    = sanitize($_POST['badge'] ?? '');
    $icon     = sanitize($_POST['icon'] ?? 'bi-sun');
    $features = sanitize($_POST['features'] ?? '');
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    try {
        $uStmt = $pdo->prepare("
            UPDATE packages
            SET title = ?, slug = ?, subtitle = ?, duration = ?, price = ?, badge = ?, icon = ?, features = ?, is_active = ?
            WHERE id = ?
        ");
        $uStmt->execute([$title, $slug, $subtitle, $duration, $price, $badge, $icon, $features, $isActive, $pkgId]);
        set_flash('success', 'Package updated successfully.');
        header('Location: packages.php');
        exit;
    } catch (PDOException $e) {
        set_flash('danger', 'Error updating package: ' . $e->getMessage());
    }
}
?>

<div class="container admin-container" style="max-width: 800px;">
    <div class="mb-4">
        <a href="packages.php" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Back to Packages
        </a>
        <h1 class="admin-header-title">Edit Package: <?= e($pkg['title']) ?></h1>
    </div>

    <div class="admin-card">
        <form method="POST" action="package-edit.php?id=<?= $pkgId ?>">
            <div class="row g-3">
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Package Title *</label>
                    <input type="text" name="title" class="form-control" required value="<?= e($pkg['title']) ?>">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Slug *</label>
                    <input type="text" name="slug" class="form-control" required value="<?= e($pkg['slug']) ?>">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Subtitle</label>
                    <input type="text" name="subtitle" class="form-control" value="<?= e($pkg['subtitle']) ?>">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Duration *</label>
                    <input type="text" name="duration" class="form-control" required value="<?= e($pkg['duration']) ?>">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Price ($) *</label>
                    <input type="number" step="0.01" name="price" class="form-control" required value="<?= (float)$pkg['price'] ?>">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Popular Badge</label>
                    <input type="text" name="badge" class="form-control" value="<?= e($pkg['badge']) ?>">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Icon</label>
                    <input type="text" name="icon" class="form-control" value="<?= e($pkg['icon']) ?>">
                </div>
                <div class="col-12 admin-form-group">
                    <label class="admin-label">Features Included (one per line)</label>
                    <textarea name="features" class="form-control" rows="5"><?= e($pkg['features']) ?></textarea>
                </div>
                <div class="col-12 admin-form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" id="activeCheck" <?= $pkg['is_active'] ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="activeCheck">
                            Package is Active & Visible
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Package</button>
                <a href="packages.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
