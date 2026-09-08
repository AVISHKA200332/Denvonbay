<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    set_flash('error', 'Invalid review ID.');
    redirect('reviews.php');
}

$stmt = $pdo->prepare("SELECT * FROM reviews WHERE id = ?");
$stmt->execute([$id]);
$rev = $stmt->fetch();

if (!$rev) {
    set_flash('error', 'Review not found.');
    redirect('reviews.php');
}

$errors = [];
$guest_name = $rev['guest_name'];
$location = $rev['location'] ?? '';
$rating = (int)$rev['rating'];
$comment = $rev['comment'];
$is_approved = (int)$rev['is_approved'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $guest_name = trim($_POST['guest_name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $rating = (int)($_POST['rating'] ?? 5);
    $comment = trim($_POST['comment'] ?? '');
    $is_approved = isset($_POST['is_approved']) ? 1 : 0;

    if (empty($guest_name)) {
        $errors[] = 'Guest name is required.';
    }
    if (empty($comment)) {
        $errors[] = 'Review comment is required.';
    }
    if ($rating < 1 || $rating > 5) {
        $rating = 5;
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE reviews SET guest_name = ?, location = ?, rating = ?, comment = ?, is_approved = ? WHERE id = ?");
        $stmt->execute([$guest_name, $location, $rating, $comment, $is_approved, $id]);

        set_flash('success', 'Review updated successfully.');
        redirect('reviews.php');
    }
}

$page_title = "Edit Review";
require_once __DIR__ . '/admin-header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="reviews.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Reviews
            </a>
            <span class="badge bg-light text-dark border">Review #<?= $id ?></span>
        </div>

        <div class="admin-card">
            <h3 class="h4 mb-4 fw-bold text-dark">Edit Guest Review</h3>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0 ps-3">
                        <?php foreach ($errors as $err): ?>
                            <li><?= htmlspecialchars($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST">
                <?= csrf_field() ?>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Guest Name <span class="text-danger">*</span></label>
                        <input type="text" name="guest_name" class="form-control" value="<?= htmlspecialchars($guest_name) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Guest Location / Country</label>
                        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($location) ?>">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Star Rating (1 - 5)</label>
                        <select name="rating" class="form-select">
                            <option value="5" <?= $rating == 5 ? 'selected' : '' ?>>★★★★★ (5 Stars - Exceptional)</option>
                            <option value="4" <?= $rating == 4 ? 'selected' : '' ?>>★★★★☆ (4 Stars - Great)</option>
                            <option value="3" <?= $rating == 3 ? 'selected' : '' ?>>★★★☆☆ (3 Stars - Good)</option>
                            <option value="2" <?= $rating == 2 ? 'selected' : '' ?>>★★☆☆☆ (2 Stars - Fair)</option>
                            <option value="1" <?= $rating == 1 ? 'selected' : '' ?>>★☆☆☆☆ (1 Star - Poor)</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_approved" name="is_approved" value="1" <?= $is_approved ? 'checked' : '' ?>>
                            <label class="form-check-label fw-semibold" for="is_approved">Approve & Publish to Website</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Guest Comment / Testimonial <span class="text-danger">*</span></label>
                    <textarea name="comment" class="form-control" rows="4" required><?= htmlspecialchars($comment) ?></textarea>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="reviews.php" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Update Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
