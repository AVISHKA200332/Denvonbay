<?php
/**
 * Denvonbay - Add New Room
 * ------------------------
 * Create a new room with image upload and live website synchronization.
 */

$adminTitle = 'Add New Room';
require_once __DIR__ . '/admin-header.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token          = $_POST['csrf_token'] ?? '';
    $name           = sanitize($_POST['name'] ?? '');
    $slug           = sanitize($_POST['slug'] ?? '');
    $tag            = sanitize($_POST['tag'] ?? '');
    $price          = (float)($_POST['price_per_night'] ?? 0);
    $capacity       = (int)($_POST['capacity'] ?? 2);
    $bedType        = sanitize($_POST['bed_type'] ?? 'King Bed');
    $description    = trim($_POST['description'] ?? '');
    $amenities      = sanitize($_POST['amenities'] ?? '');
    $imageUrl       = sanitize($_POST['image_url'] ?? '');
    $isAvailable    = isset($_POST['is_available']) ? 1 : 0;

    if (!verify_csrf_token($token)) {
        $errors[] = 'Security token invalid. Please resubmit the form.';
    }

    if (empty($name)) {
        $errors[] = 'Please provide a room name.';
    }

    if ($price <= 0) {
        $errors[] = 'Please enter a valid price per night.';
    }

    // Auto-generate slug if empty
    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    }

    // Handle optional file upload
    if (isset($_FILES['room_image']) && $_FILES['room_image']['error'] !== UPLOAD_ERR_NO_FILE) {
        try {
            $uploaded = upload_image_file($_FILES['room_image'], __DIR__ . '/../uploads/rooms');
            if ($uploaded) {
                $imageUrl = 'uploads/rooms/' . $uploaded;
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }

    if (empty($imageUrl)) {
        $imageUrl = 'assets/images/explore/Surfboard_logo_detail_macro_shot_202607210209.jpg'; // default
    }

    // Check slug uniqueness
    if (empty($errors)) {
        $chk = $pdo->prepare("SELECT COUNT(*) FROM rooms WHERE slug = ?");
        $chk->execute([$slug]);
        if ($chk->fetchColumn() > 0) {
            $slug .= '-' . rand(10, 99);
        }

        try {
            $stmt = $pdo->prepare("
                INSERT INTO rooms (name, slug, tag, price_per_night, capacity, bed_type, image_url, description, amenities, is_available)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $name,
                $slug,
                $tag ?: null,
                $price,
                $capacity,
                $bedType,
                $imageUrl,
                $description,
                $amenities,
                $isAvailable
            ]);

            set_flash('success', 'Room "' . $name . '" created successfully and is now active.');
            header('Location: rooms.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Create Room</h2>
        <p class="admin-page-desc">Add a new coastal stay room to the Denvonbay property directory.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="rooms.php" class="admin-btn admin-btn-secondary">
            <i class="bi bi-arrow-left"></i>
            <span>Back to Rooms</span>
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

<div class="admin-card" style="max-width: 860px;">
    <form method="POST" action="room-add.php" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-8">
                <div class="admin-form-group">
                    <label class="admin-label">Room Name *</label>
                    <input type="text" name="name" class="admin-input" placeholder="e.g., The Sunset Penthouse" value="<?= e($_POST['name'] ?? '') ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Slug (URL identifier)</label>
                    <input type="text" name="slug" class="admin-input" placeholder="e.g., sunset-penthouse" value="<?= e($_POST['slug'] ?? '') ?>">
                    <div class="admin-help-text">Leave blank to auto-generate.</div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Price per Night (USD) *</label>
                    <input type="number" step="0.01" min="1" name="price_per_night" class="admin-input" placeholder="e.g., 75.00" value="<?= e($_POST['price_per_night'] ?? '') ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Max Guest Capacity</label>
                    <input type="number" min="1" max="10" name="capacity" class="admin-input" value="<?= e($_POST['capacity'] ?? '2') ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Bed Type</label>
                    <input type="text" name="bed_type" class="admin-input" placeholder="e.g., King Bed, Queen Bed" value="<?= e($_POST['bed_type'] ?? 'Queen Bed') ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-form-group">
                    <label class="admin-label">Highlight Tag (optional)</label>
                    <input type="text" name="tag" class="admin-input" placeholder="e.g., Most Popular, Perfect for Solo" value="<?= e($_POST['tag'] ?? '') ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-form-group">
                    <label class="admin-label">Existing Image Path (optional)</label>
                    <input type="text" name="image_url" class="admin-input" placeholder="assets/images/explore/..." value="<?= e($_POST['image_url'] ?? '') ?>">
                    <div class="admin-help-text">Or upload a new photo below.</div>
                </div>
            </div>

            <div class="col-12">
                <div class="admin-form-group">
                    <label class="admin-label">Upload Room Photo (JPG, PNG, WEBP)</label>
                    <input type="file" name="room_image" class="admin-input" accept="image/jpeg,image/png,image/webp">
                </div>
            </div>

            <div class="col-12">
                <div class="admin-form-group">
                    <label class="admin-label">Room Amenities (comma separated)</label>
                    <input type="text" name="amenities" class="admin-input" placeholder="High-Speed Wi-Fi, Air Conditioning, Balcony, Rain Shower, Breakfast Included" value="<?= e($_POST['amenities'] ?? 'High-Speed Wi-Fi, Air Conditioning, Private Bathroom, Daily Housekeeping') ?>">
                </div>
            </div>

            <div class="col-12">
                <div class="admin-form-group">
                    <label class="admin-label">Full Description</label>
                    <textarea name="description" rows="4" class="admin-textarea" placeholder="A detailed, welcoming description of the room..."><?= e($_POST['description'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="is_available" id="isAvailableSwitch" value="1" <?= (!isset($_POST['is_available']) || $_POST['is_available']) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold text-dark" for="isAvailableSwitch">
                        Make available for booking on public website immediately
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="admin-btn admin-btn-primary">
                <i class="bi bi-check-lg"></i>
                <span>Save Room</span>
            </button>
            <a href="rooms.php" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
