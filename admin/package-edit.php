<?php
/**
 * Denvonbay - Edit Package
 * ------------------------
 * Update package duration, features, badge, and pricing.
 */

$adminTitle = 'Edit Package';
require_once __DIR__ . '/admin-header.php';

$packageId = (int)($_GET['id'] ?? 0);

if ($packageId <= 0) {
    set_flash('danger', 'Invalid package identifier.');
    header('Location: packages.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM packages WHERE id = ?");
$stmt->execute([$packageId]);
$package = $stmt->fetch();

if (!$package) {
    set_flash('danger', 'Package not found.');
    header('Location: packages.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token       = $_POST['csrf_token'] ?? '';
    $title       = sanitize($_POST['title'] ?? '');
    $slug        = sanitize($_POST['slug'] ?? '');
    $subtitle    = sanitize($_POST['subtitle'] ?? '');
    $duration    = sanitize($_POST['duration'] ?? '');
    $price       = (float)($_POST['price'] ?? 0);
    $badge       = sanitize($_POST['badge'] ?? '');
    $icon        = sanitize($_POST['icon'] ?? 'bi-sun');
    $features    = trim($_POST['features'] ?? '');
    $isActive    = isset($_POST['is_active']) ? 1 : 0;

    if (!verify_csrf_token($token)) {
        $errors[] = 'Security token invalid. Please resubmit the form.';
    }

    if (empty($title)) {
        $errors[] = 'Please enter a package title.';
    }

    if (empty($duration)) {
        $errors[] = 'Please enter a duration.';
    }

    if ($price <= 0) {
        $errors[] = 'Please enter a valid price.';
    }

    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    }

    if (empty($errors)) {
        $chk = $pdo->prepare("SELECT COUNT(*) FROM packages WHERE slug = ? AND id != ?");
        $chk->execute([$slug, $packageId]);
        if ($chk->fetchColumn() > 0) {
            $slug .= '-' . rand(10, 99);
        }

        try {
            $upStmt = $pdo->prepare("
                UPDATE packages SET
                    title = ?,
                    slug = ?,
                    subtitle = ?,
                    duration = ?,
                    price = ?,
                    badge = ?,
                    icon = ?,
                    features = ?,
                    is_active = ?
                WHERE id = ?
            ");
            $upStmt->execute([
                $title,
                $slug,
                $subtitle ?: null,
                $duration,
                $price,
                $badge ?: null,
                $icon,
                $features,
                $isActive,
                $packageId
            ]);

            set_flash('success', 'Package "' . $title . '" updated successfully. Customer pages now reflect the new details and pricing.');
            header('Location: packages.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Edit: <?= e($package['title']) ?></h2>
        <p class="admin-page-desc">Modify package features, pricing, and live availability.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="../packages.php#<?= e($package['slug']) ?>" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>Preview Live</span>
        </a>
        <a href="packages.php" class="admin-btn admin-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Packages</span>
        </a>
    </div>
</div>

<?php if (!empty($errors)): ?>
    <div class="admin-alert admin-alert-danger">
        <div>
            <strong>Please correct the following errors:</strong>
            <ul class="mb-0 mt-1 ps-3">
                <?php foreach ($errors as $err): ?>
                    <li><?= e($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <button type="button" class="btn-close" onclick="this.parentElement.remove();"></button>
    </div>
<?php endif; ?>

<div class="admin-card" style="max-width: 800px;">
    <form method="POST" action="package-edit.php?id=<?= $packageId ?>">
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-8">
                <div class="admin-form-group">
                    <label class="admin-label">Package Title *</label>
                    <input type="text" name="title" class="admin-input" value="<?= e($_POST['title'] ?? $package['title']) ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Slug</label>
                    <input type="text" name="slug" class="admin-input" value="<?= e($_POST['slug'] ?? $package['slug']) ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-form-group">
                    <label class="admin-label">Subtitle / Hook</label>
                    <input type="text" name="subtitle" class="admin-input" value="<?= e($_POST['subtitle'] ?? $package['subtitle']) ?>">
                </div>
            </div>

            <div class="col-md-3">
                <div class="admin-form-group">
                    <label class="admin-label">Duration *</label>
                    <input type="text" name="duration" class="admin-input" value="<?= e($_POST['duration'] ?? $package['duration']) ?>" required>
                </div>
            </div>

            <div class="col-md-3">
                <div class="admin-form-group">
                    <label class="admin-label">Total Price (USD) *</label>
                    <input type="number" step="0.01" min="1" name="price" class="admin-input" value="<?= e($_POST['price'] ?? $package['price']) ?>" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-form-group">
                    <label class="admin-label">Badge (optional)</label>
                    <input type="text" name="badge" class="admin-input" placeholder="e.g., Most Booked" value="<?= e($_POST['badge'] ?? $package['badge']) ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-form-group">
                    <label class="admin-label">Bootstrap Icon</label>
                    <input type="text" name="icon" class="admin-input" value="<?= e($_POST['icon'] ?? $package['icon']) ?>">
                </div>
            </div>

            <div class="col-12">
                <div class="admin-form-group">
                    <label class="admin-label">Package Features (one per line)</label>
                    <textarea name="features" rows="5" class="admin-textarea"><?= e($_POST['features'] ?? $package['features']) ?></textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActiveEditSwitch" value="1" <?= ($package['is_active']) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold text-dark" for="isActiveEditSwitch">
                        Package is active and visible on customer website
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="admin-btn admin-btn-primary">
                <i class="bi bi-check-lg"></i>
                <span>Save Changes</span>
            </button>
            <a href="packages.php" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
