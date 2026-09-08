<?php
/**
 * Denvonbay - Edit Room
 * ---------------------
 * Update room details, pricing, and photos with live website synchronization.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

$roomId = (int)($_GET['id'] ?? 0);

if ($roomId <= 0) {
    set_flash('danger', 'Invalid room identifier.');
    header('Location: rooms.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$roomId]);
$room = $stmt->fetch();

if (!$room) {
    set_flash('danger', 'Room not found.');
    header('Location: rooms.php');
    exit;
}

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
    $imageUrl       = sanitize($_POST['image_url'] ?? $room['image_url']);
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

    if (empty($slug)) {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    }

    // Handle optional replacement file upload
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

    // Check slug uniqueness excluding this room
    if (empty($errors)) {
        $chk = $pdo->prepare("SELECT COUNT(*) FROM rooms WHERE slug = ? AND id != ?");
        $chk->execute([$slug, $roomId]);
        if ($chk->fetchColumn() > 0) {
            $slug .= '-' . rand(10, 99);
        }

        try {
            $upStmt = $pdo->prepare("
                UPDATE rooms SET
                    name = ?,
                    slug = ?,
                    tag = ?,
                    price_per_night = ?,
                    capacity = ?,
                    bed_type = ?,
                    image_url = ?,
                    description = ?,
                    amenities = ?,
                    is_available = ?
                WHERE id = ?
            ");
            $upStmt->execute([
                $name,
                $slug,
                $tag ?: null,
                $price,
                $capacity,
                $bedType,
                $imageUrl,
                $description,
                $amenities,
                $isAvailable,
                $roomId
            ]);

            set_flash('success', 'Room "' . $name . '" updated successfully. Customer-facing pages now reflect these changes.');
            header('Location: rooms.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = 'Database error: ' . $e->getMessage();
        }
    }
}

$adminTitle = 'Edit Room';
require_once __DIR__ . '/admin-header.php';
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Edit: <?= e($room['name']) ?></h2>
        <p class="admin-page-desc">Modify room details, rate per night, amenities, and availability.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="../room-details.php?id=<?= $roomId ?>" target="_blank" rel="noopener" class="admin-btn admin-btn-secondary">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>Preview Live</span>
        </a>
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
    <form method="POST" action="room-edit.php?id=<?= $roomId ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="row g-3">
            <div class="col-md-8">
                <div class="admin-form-group">
                    <label class="admin-label">Room Name *</label>
                    <input type="text" name="name" class="admin-input" value="<?= e($_POST['name'] ?? $room['name']) ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Slug</label>
                    <input type="text" name="slug" class="admin-input" value="<?= e($_POST['slug'] ?? $room['slug']) ?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Price per Night (USD) *</label>
                    <input type="number" step="0.01" min="1" name="price_per_night" class="admin-input" value="<?= e($_POST['price_per_night'] ?? $room['price_per_night']) ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Max Guest Capacity</label>
                    <input type="number" min="1" max="10" name="capacity" class="admin-input" value="<?= e($_POST['capacity'] ?? $room['capacity']) ?>" required>
                </div>
            </div>

            <div class="col-md-4">
                <div class="admin-form-group">
                    <label class="admin-label">Bed Type</label>
                    <input type="text" name="bed_type" class="admin-input" value="<?= e($_POST['bed_type'] ?? $room['bed_type']) ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-form-group">
                    <label class="admin-label">Highlight Tag (optional)</label>
                    <input type="text" name="tag" class="admin-input" placeholder="e.g., Most Popular" value="<?= e($_POST['tag'] ?? $room['tag']) ?>">
                </div>
            </div>

            <div class="col-md-6">
                <div class="admin-form-group">
                    <label class="admin-label">Image Path / URL</label>
                    <input type="text" name="image_url" class="admin-input" value="<?= e($_POST['image_url'] ?? $room['image_url']) ?>">
                </div>
            </div>

            <!-- Current Image Preview & Replacement File Upload -->
            <div class="col-12">
                <div class="admin-form-group">
                    <label class="admin-label">Current Photo & Replacement</label>
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <?php
                        $thumb = $room['image_url'];
                        if (strpos($thumb, 'http') !== 0 && strpos($thumb, '../') !== 0) {
                            $thumb = '../' . ltrim($thumb, '/');
                        }
                        ?>
                        <img src="<?= e($thumb) ?>" alt="<?= e($room['name']) ?>" class="admin-thumb" style="width: 72px; height: 72px; border-radius: 10px;" onerror="this.src='../assets/images/logo/appicon.png'">
                        <div class="flex-1">
                            <input type="file" name="room_image" class="admin-input" accept="image/jpeg,image/png,image/webp">
                            <div class="admin-help-text">Select a new image (JPG, PNG, WEBP) to replace the current photo.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="admin-form-group">
                    <label class="admin-label">Room Amenities (comma separated)</label>
                    <input type="text" name="amenities" class="admin-input" value="<?= e($_POST['amenities'] ?? $room['amenities']) ?>">
                </div>
            </div>

            <div class="col-12">
                <div class="admin-form-group">
                    <label class="admin-label">Full Description</label>
                    <textarea name="description" rows="4" class="admin-textarea"><?= e($_POST['description'] ?? $room['description']) ?></textarea>
                </div>
            </div>

            <div class="col-12">
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" name="is_available" id="isAvailableEditSwitch" value="1" <?= ($room['is_available']) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold text-dark" for="isAvailableEditSwitch">
                        Room is available for customer bookings on website
                    </label>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="admin-btn admin-btn-primary">
                <i class="bi bi-check-lg"></i>
                <span>Save Changes</span>
            </button>
            <a href="rooms.php" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
