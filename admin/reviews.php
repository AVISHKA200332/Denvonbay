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
            $stmt = $pdo->prepare("UPDATE reviews SET is_approved = 1 - is_approved WHERE id = ?");
            $stmt->execute([$id]);
            set_flash('success', 'Review approval status updated.');
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
            $stmt->execute([$id]);
            set_flash('success', 'Review deleted successfully.');
        }
    }
    redirect('reviews.php');
}

$reviews = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC")->fetchAll();

$page_title = "Reviews Management";
require_once __DIR__ . '/admin-header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h2 class="h4 mb-1 fw-bold text-dark">Guest Testimonials & Reviews</h2>
        <p class="text-muted small mb-0">Manage reviews displayed on the customer-facing website.</p>
    </div>
    <a href="review-add.php" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add New Review
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="table admin-table align-middle mb-0">
            <thead>
                <tr>
                    <th>Guest</th>
                    <th>Location / Origin</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($reviews)): ?>
                    <tr><td colspan="7" class="text-center py-4 text-muted">No reviews recorded yet.</td></tr>
                <?php else: ?>
                    <?php foreach ($reviews as $rev): ?>
                        <tr>
                            <td>
                                <strong class="text-dark d-block"><?= htmlspecialchars($rev['guest_name']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($rev['location'] ?? '—') ?></td>
                            <td>
                                <span class="text-warning fw-bold">
                                    <?= str_repeat('★', (int)$rev['rating']) . str_repeat('☆', 5 - (int)$rev['rating']) ?>
                                </span>
                                <small class="text-muted ms-1">(<?= (int)$rev['rating'] ?>/5)</small>
                            </td>
                            <td style="max-width: 320px;">
                                <div class="text-truncate text-muted small" title="<?= htmlspecialchars($rev['comment']) ?>">
                                    "<?= htmlspecialchars($rev['comment']) ?>"
                                </div>
                            </td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= $rev['id'] ?>">
                                    <input type="hidden" name="action" value="toggle">
                                    <button type="submit" class="btn p-0 border-0 bg-transparent text-decoration-none" title="Click to toggle status">
                                        <?php if ($rev['is_approved']): ?>
                                            <span class="badge-status badge-confirmed cursor-pointer"><i class="bi bi-check-circle me-1"></i>Approved</span>
                                        <?php else: ?>
                                            <span class="badge-status badge-pending cursor-pointer"><i class="bi bi-clock me-1"></i>Pending</span>
                                        <?php endif; ?>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <span class="small text-muted"><?= date('M d, Y', strtotime($rev['created_at'])) ?></span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a href="review-edit.php?id=<?= $rev['id'] ?>" class="btn btn-sm btn-outline-secondary" title="Edit Review">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= $rev['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Review">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
