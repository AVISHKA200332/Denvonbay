<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

$errors = [];
$title = '';
$category = 'rooms';
$sort_order = 0;
$is_active = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'rooms');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($title)) {
        $errors[] = 'Photo title is required.';
    }

    $image_path = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload = upload_image_file($_FILES['image'], 'uploads/gallery');
        if ($upload['success']) {
            $image_path = $upload['path'];
        } else {
            $errors[] = $upload['error'];
        }
    } else {
        $errors[] = 'Please select an image file to upload.';
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO gallery (title, category, image_url, sort_order, is_active, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([$title, $category, $image_path, $sort_order, $is_active]);

        set_flash('success', 'Gallery photo uploaded successfully.');
        redirect('gallery.php');
    }
}

$page_title = "Add Gallery Photo";
require_once __DIR__ . '/admin-header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="gallery.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Gallery
            </a>
            <span class="badge bg-light text-dark border">Upload Photo</span>
        </div>

        <div class="admin-card">
            <h3 class="h4 mb-4 fw-bold text-dark">Add New Gallery Photo</h3>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Photo Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" placeholder="e.g. Sunset Surf Session at Weligama" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category" class="form-select">
                            <option value="rooms" <?= $category === 'rooms' ? 'selected' : '' ?>>Rooms & Suites</option>
                            <option value="surf" <?= $category === 'surf' ? 'selected' : '' ?>>Surf & Coast</option>
                            <option value="dining" <?= $category === 'dining' ? 'selected' : '' ?>>Dining & Café</option>
                            <option value="property" <?= $category === 'property' ? 'selected' : '' ?>>Property & Lounge</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Sort Order (Lower appears first)</label>
                        <input type="number" name="sort_order" class="form-control" value="<?= (int)$sort_order ?>">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Select Image File <span class="text-danger">*</span></label>
                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp" required>
                    <div class="form-text">Recommended size: 1200x800px or larger. Formats: JPG, PNG, WEBP. Max size: 5MB.</div>
                </div>

                <div class="mb-4">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" value="1" <?= $is_active ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="is_active">Publish immediately on website</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="gallery.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i> Upload & Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
