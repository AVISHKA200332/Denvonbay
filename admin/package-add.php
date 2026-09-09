<?php
/**
 * Denvonbay - Add Package
 * -----------------------
 * Create a new stay / surf package.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token       = $_POST['csrf_token'] ?? '';
    $title       = sanitize($_POST['title'] ?? '');
    $slug        = sanitize($_POST['slug'] ?? '');
    $subtitle    = sanitize($_POST['subtitle'] ?? '');
    $duration    = sanitize($_POST['duration'] ?? '');
    $price       = (float)($_POST['price'] ?? 0);
    $badge       = sanitize($_POST['badge'] ?? '');
    $features    = trim($_POST['features'] ?? '');
    $isActive    = isset($_POST['is_active']) ? 1 : 0;

    if (!verify_csrf_token($token)) {
        $errors[] = 'Security token invalid. Please resubmit the form.';
    }

    if (empty($title)) {
        $errors[] = 'Please enter a package title.';
    }

    if (empty($duration)) {
        $errors[] = 'Please enter a duration (e.g., 2 Nights).';
    }

    if ($price <= 0) {
        $errors[] = 'Please enter a valid price.';
    }

    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title), '-'));
    }

    if (empty($errors)) {
        $chk = $pdo->prepare("SELECT COUNT(*) FROM packages WHERE slug = ?");
        $chk->execute([$slug]);
        if ($chk->fetchColumn() > 0) {
            $slug .= '-' . rand(10, 99);
        }

        try {
            $stmt = $pdo->prepare("
                INSERT INTO packages (title, slug, subtitle, duration, price, badge, icon, features, is_active)
                VALUES (?, ?, ?, ?, ?, ?, 'bi-sun', ?, ?)
            ");
            $stmt->execute([
                $title,
                $slug,
                $subtitle ?: null,
                $duration,
                $price,
                $badge ?: null,
                $features,
                $isActive
            ]);

            set_flash('success', 'Package "' . $title . '" created successfully.');
            header('Location: packages.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

$adminTitle = 'Add New Package';
require_once __DIR__ . '/admin-header.php';
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Create Package</h2>
        <p class="admin-page-desc">Add a holiday or surf stay package to the customer website.</p>
    </div>
    <div class="d-flex gap-2">
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
    <form method="POST" action="package-add.php">
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-8">
                <div class="admin-form-group">
                    <label class="admin-label">Package Title *</label>
                    <input type="text" name="title" class="admin-input" placeholder="e.g., Weekend Surf Escape" value="<?= e($_POST['title'] ?? '') ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Slug</label>
                    <input type="text" name="slug" class="admin-input" placeholder="e.g., weekend-escape" value="<?= e($_POST['slug'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-form-group">
                    <label class="admin-label">Subtitle / Hook</label>
                    <input type="text" name="subtitle" class="admin-input" placeholder="e.g., Friday to Sunday surf reset" value="<?= e($_POST['subtitle'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Duration *</label>
                    <input type="text" name="duration" class="admin-input" placeholder="e.g., 2 Nights" value="<?= e($_POST['duration'] ?? '') ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Total Price (USD) *</label>
                    <input type="number" step="0.01" min="1" name="price" class="admin-input" placeholder="e.g., 110.00" value="<?= e($_POST['price'] ?? '') ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Badge (optional)</label>
                    <input type="text" name="badge" class="admin-input" placeholder="e.g., Popular, Most Booked, Best Value" value="<?= e($_POST['badge'] ?? '') ?>">
                </div>
            </div>

            <div class="col-12">
                <div class="admin-form-group">
                    <label class="admin-label">Package Features (one per line or comma separated)</label>
                    <textarea name="features" rows="5" class="admin-textarea" placeholder="2 nights accommodation&#10;Daily breakfast&#10;Guided surf spot tour&#10;Free board storage"><?= e($_POST['features'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActiveSwitch" value="1" <?= (!isset($_POST['is_active']) || $_POST['is_active']) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold text-dark" for="isActiveSwitch">
                        Package is active and visible on the website
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="admin-btn admin-btn-primary">
                <i class="bi bi-check-lg"></i>
                <span>Save Package</span>
            </button>
            <a href="packages.php" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
