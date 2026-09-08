<?php
/**
 * Denvonbay - Edit Room
 */

$adminTitle = 'Edit Room';
require_once __DIR__ . '/admin-header.php';

$roomId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$roomId]);
$room = $stmt->fetch();

if (!$room) {
    echo "<div class='container mt-5'><div class='alert alert-warning'>Room not found. <a href='rooms.php'>Return to Rooms</a></div></div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = sanitize($_POST['name'] ?? '');
    $slug        = sanitize($_POST['slug'] ?? '');
    $tag         = sanitize($_POST['tag'] ?? '');
    $price       = (float)($_POST['price_per_night'] ?? 0);
    $capacity    = (int)($_POST['capacity'] ?? 2);
    $bedType     = sanitize($_POST['bed_type'] ?? 'King Bed');
    $imageUrl    = sanitize($_POST['image_url'] ?? '');
    $description = sanitize($_POST['description'] ?? '');
    $amenities   = sanitize($_POST['amenities'] ?? '');
    $isAvailable = isset($_POST['is_available']) ? 1 : 0;

    try {
        $uStmt = $pdo->prepare("
            UPDATE rooms
            SET name = ?, slug = ?, tag = ?, price_per_night = ?, capacity = ?, bed_type = ?, image_url = ?, description = ?, amenities = ?, is_available = ?
            WHERE id = ?
        ");
        $uStmt->execute([$name, $slug, $tag, $price, $capacity, $bedType, $imageUrl, $description, $amenities, $isAvailable, $roomId]);
        set_flash('success', 'Room updated successfully.');
        header('Location: rooms.php');
        exit;
    } catch (PDOException $e) {
        set_flash('danger', 'Error updating room: ' . $e->getMessage());
    }
}
?>

<div class="container admin-container" style="max-width: 800px;">
    <div class="mb-4">
        <a href="rooms.php" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Back to Rooms
        </a>
        <h1 class="admin-header-title">Edit Room: <?= e($room['name']) ?></h1>
    </div>

    <div class="admin-card">
        <form method="POST" action="room-edit.php?id=<?= $roomId ?>">
            <div class="row g-3">
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Room Name *</label>
                    <input type="text" name="name" class="form-control" required value="<?= e($room['name']) ?>">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Slug *</label>
                    <input type="text" name="slug" class="form-control" required value="<?= e($room['slug']) ?>">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Tag / Badge</label>
                    <input type="text" name="tag" class="form-control" value="<?= e($room['tag']) ?>">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Price per Night ($) *</label>
                    <input type="number" step="0.01" name="price_per_night" class="form-control" required value="<?= (float)$room['price_per_night'] ?>">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Guest Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="<?= (int)$room['capacity'] ?>" min="1">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Bed Type</label>
                    <input type="text" name="bed_type" class="form-control" value="<?= e($room['bed_type']) ?>">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Image Path</label>
                    <input type="text" name="image_url" class="form-control" value="<?= e($room['image_url']) ?>">
                </div>
                <div class="col-12 admin-form-group">
                    <label class="admin-label">Description *</label>
                    <textarea name="description" class="form-control" rows="4" required><?= e($room['description']) ?></textarea>
                </div>
                <div class="col-12 admin-form-group">
                    <label class="admin-label">Amenities (comma-separated)</label>
                    <input type="text" name="amenities" class="form-control" value="<?= e($room['amenities']) ?>">
                </div>
                <div class="col-12 admin-form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_available" id="availCheck" <?= $room['is_available'] ? 'checked' : '' ?>>
                        <label class="form-check-label fw-semibold" for="availCheck">
                            Room is Available for Booking
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Room</button>
                <a href="rooms.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
