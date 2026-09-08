<?php
/**
 * Denvonbay - Add New Package
 */

$adminTitle = 'Add Package';
require_once __DIR__ . '/admin-header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = sanitize($_POST['title'] ?? '');
    $slug     = sanitize($_POST['slug'] ?? '');
    $subtitle = sanitize($_POST['subtitle'] ?? '');
    $duration = sanitize($_POST['duration'] ?? '');
    $price    = (float)($_POST['price'] ?? 0);
    $badge    = sanitize($_POST['badge'] ?? '');
    $icon     = sanitize($_POST['icon'] ?? 'bi-sun');
    $features = sanitize($_POST['features'] ?? '');

    if (empty($title) || empty($slug)) {
        set_flash('danger', 'Please enter title and slug.');
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO packages (title, slug, subtitle, duration, price, badge, icon, features, is_active)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)
            ");
            $stmt->execute([$title, $slug, $subtitle, $duration, $price, $badge, $icon, $features]);
            set_flash('success', 'Package added.');
            header('Location: packages.php');
            exit;
        } catch (PDOException $e) {
            set_flash('danger', 'Error adding package: ' . $e->getMessage());
        }
    }
}
?>

<div class="container admin-container" style="max-width: 800px;">
    <div class="mb-4">
        <a href="packages.php" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Back to Packages
        </a>
        <h1 class="admin-header-title">Add New Package</h1>
    </div>

    <div class="admin-card">
        <form method="POST" action="package-add.php">
            <div class="row g-3">
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Package Title *</label>
                    <input type="text" name="title" class="form-control" required placeholder="e.g. Surf Safari Week">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Slug *</label>
                    <input type="text" name="slug" class="form-control" required placeholder="e.g. surf-safari">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Subtitle / Description</label>
                    <input type="text" name="subtitle" class="form-control" placeholder="e.g. 5 days of guided wave hunting">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Duration Label *</label>
                    <input type="text" name="duration" class="form-control" required placeholder="e.g. 4 Nights / 5 Days">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Price ($) *</label>
                    <input type="number" step="0.01" name="price" class="form-control" required value="120.00">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Popular Badge</label>
                    <input type="text" name="badge" class="form-control" placeholder="e.g. Most Booked, Best Value">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Bootstrap Icon</label>
                    <input type="text" name="icon" class="form-control" value="bi-sun">
                </div>
                <div class="col-12 admin-form-group">
                    <label class="admin-label">Features Included (one per line)</label>
                    <textarea name="features" class="form-control" rows="5" placeholder="Daily breakfast&#10;Free board storage&#10;Guided surf tour"></textarea>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save Package</button>
                <a href="packages.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
