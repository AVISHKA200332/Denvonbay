<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

// Handle status toggle or delete via POST + CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    $action = $_POST['action'] ?? '';
    $id = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        if ($action === 'toggle') {
            $stmt = $pdo->prepare("UPDATE gallery SET is_active = 1 - is_active WHERE id = ?");
            $stmt->execute([$id]);
            set_flash('success', 'Photo visibility updated.');
        } elseif ($action === 'delete') {
            // Optional: delete image file if stored in uploads/
            $stmt = $pdo->prepare("SELECT image_url FROM gallery WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch();
            if ($item && !empty($item['image_url']) && strpos($item['image_url'], 'uploads/') === 0) {
                $filePath = __DIR__ . '/../' . $item['image_url'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
            $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
            set_flash('success', 'Photo deleted successfully.');
        }
    }
    redirect('gallery.php');
}

// Category filter
$category_filter = trim($_GET['category'] ?? '');
if (!empty($category_filter)) {
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE category = ? ORDER BY sort_order ASC, created_at DESC");
    $stmt->execute([$category_filter]);
    $gallery = $stmt->fetchAll();
} else {
    $gallery = $pdo->query("SELECT * FROM gallery ORDER BY sort_order ASC, created_at DESC")->fetchAll();
}

$categories = $pdo->query("SELECT DISTINCT category FROM gallery WHERE category IS NOT NULL AND category != ''")->fetchAll(PDO::FETCH_COLUMN);

$page_title = "Gallery Management";
require_once __DIR__ . '/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="h4 mb-1 fw-bold text-dark">Website Photo Gallery</h2>
        <p class="text-muted small mb-0">Manage photo showcase displayed on the customer-facing gallery page.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="gallery-add.php" class="btn btn-primary">
            <i class="bi bi-upload me-1"></i> Add Photo
        </a>
    </div>
</div>

<!-- Filters -->
<div class="admin-card mb-4 p-3">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <span class="small fw-semibold text-muted me-2">Filter Category:</span>
        <a href="gallery.php" class="btn btn-sm <?= empty($category_filter) ? 'btn-primary' : 'btn-outline-secondary' ?>">
            All (<?= count($pdo->query("SELECT id FROM gallery")->fetchAll()) ?>)
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="gallery.php?category=<?= urlencode($cat) ?>" class="btn btn-sm <?= $category_filter === $cat ? 'btn-primary' : 'btn-outline-secondary' ?>">
                <?= ucfirst(htmlspecialchars($cat)) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="row g-4">
    <?php if (empty($gallery)): ?>
        <div class="col-12">
            <div class="admin-card text-center py-5">
                <i class="bi bi-images fs-1 text-muted d-block mb-2"></i>
                <h5 class="text-muted">No gallery photos found.</h5>
                <p class="small text-muted mb-3">Upload your first photo to showcase on the website.</p>
                <a href="gallery-add.php" class="btn btn-primary btn-sm">Add Photo</a>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($gallery as $img): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="admin-card p-2 h-100 d-flex flex-column">
                    <div class="position-relative mb-2 rounded overflow-hidden" style="height: 180px; background: #000;">
                        <img src="../<?= htmlspecialchars($img['image_url']) ?>" alt="<?= htmlspecialchars($img['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                        <span class="badge position-absolute top-0 end-0 m-2 <?= $img['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                            <?= $img['is_active'] ? 'Active' : 'Hidden' ?>
                        </span>
                        <?php if (!empty($img['category'])): ?>
                            <span class="badge position-absolute bottom-0 start-0 m-2 bg-dark bg-opacity-75">
                                <?= ucfirst(htmlspecialchars($img['category'])) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="px-1 flex-grow-1">
                        <h6 class="fw-bold mb-1 text-truncate text-dark" title="<?= htmlspecialchars($img['title']) ?>">
                            <?= htmlspecialchars($img['title']) ?>
                        </h6>
                        <small class="text-muted d-block">Sort Order: <?= (int)$img['sort_order'] ?></small>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 mt-2 border-top">
                        <form method="POST" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $img['id'] ?>">
                            <input type="hidden" name="action" value="toggle">
                            <button type="submit" class="btn btn-sm btn-outline-secondary" title="Toggle visibility">
                                <i class="bi <?= $img['is_active'] ? 'bi-eye-slash' : 'bi-eye' ?>"></i> <?= $img['is_active'] ? 'Hide' : 'Show' ?>
                            </button>
                        </form>
                        <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this photo?');">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $img['id'] ?>">
                            <input type="hidden" name="action" value="delete">
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Photo">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
