<?php
/**
 * Denvonbay - Add New Room
 */

$adminTitle = 'Add Room';
require_once __DIR__ . '/admin-header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = sanitize($_POST['name'] ?? '');
    $slug        = sanitize($_POST['slug'] ?? '');
    $tag         = sanitize($_POST['tag'] ?? '');
    $price       = (float)($_POST['price_per_night'] ?? 0);
    $capacity    = (int)($_POST['capacity'] ?? 2);
    $bedType     = sanitize($_POST['bed_type'] ?? 'King Bed');
    $imageUrl    = sanitize($_POST['image_url'] ?? 'assets/images/explore/Lady_surfing_on_Sri_Lankan_202607061450.jpg');
    $description = sanitize($_POST['description'] ?? '');
    $amenities   = sanitize($_POST['amenities'] ?? '');

    if (empty($name) || empty($slug)) {
        set_flash('danger', 'Please provide a room name and unique slug.');
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO rooms (name, slug, tag, price_per_night, capacity, bed_type, image_url, description, amenities, is_available)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)
            ");
            $stmt->execute([$name, $slug, $tag, $price, $capacity, $bedType, $imageUrl, $description, $amenities]);
            set_flash('success', 'Room added successfully.');
            header('Location: rooms.php');
            exit;
        } catch (PDOException $e) {
            set_flash('danger', 'Error adding room: ' . $e->getMessage());
        }
    }
}
?>

<div class="container admin-container" style="max-width: 800px;">
    <div class="mb-4">
        <a href="rooms.php" class="text-decoration-none text-muted mb-2 d-inline-block">
            <i class="bi bi-arrow-left me-1"></i> Back to Rooms
        </a>
        <h1 class="admin-header-title">Add New Room</h1>
    </div>

    <div class="admin-card">
        <form method="POST" action="room-add.php">
            <div class="row g-3">
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Room Name *</label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Ocean Breeze Suite">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Slug (URL friendly) *</label>
                    <input type="text" name="slug" class="form-control" required placeholder="e.g. ocean-breeze">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Badge / Tag</label>
                    <input type="text" name="tag" class="form-control" placeholder="e.g. Most Popular, Sea View">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Price per Night ($) *</label>
                    <input type="number" step="0.01" name="price_per_night" class="form-control" required value="60.00">
                </div>
                <div class="col-md-4 admin-form-group">
                    <label class="admin-label">Guest Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="2" min="1" max="10">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Bed Type</label>
                    <input type="text" name="bed_type" class="form-control" value="King Bed">
                </div>
                <div class="col-md-6 admin-form-group">
                    <label class="admin-label">Image Path</label>
                    <input type="text" name="image_url" class="form-control" value="assets/images/explore/Lady_surfing_on_Sri_Lankan_202607061450.jpg">
                </div>
                <div class="col-12 admin-form-group">
                    <label class="admin-label">Description *</label>
                    <textarea name="description" class="form-control" rows="4" required placeholder="Brief description of the room and its vibe..."></textarea>
                </div>
                <div class="col-12 admin-form-group">
                    <label class="admin-label">Amenities (comma-separated)</label>
                    <input type="text" name="amenities" class="form-control" placeholder="High-Speed Wi-Fi, Air Conditioning, Balcony, Rain Shower">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Save Room</button>
                <a href="rooms.php" class="btn btn-secondary ms-2">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
