<?php
/**
 * Denvonbay - Admin Reviews Management
 */

$adminTitle = 'Reviews Management';
require_once __DIR__ . '/admin-header.php';

// Handle approve / delete
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $revId = (int)$_GET['id'];

    if ($action === 'toggle') {
        $stmt = $pdo->prepare("UPDATE reviews SET is_approved = 1 - is_approved WHERE id = ?");
        $stmt->execute([$revId]);
        set_flash('success', 'Review visibility toggled.');
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->execute([$revId]);
        set_flash('danger', 'Review deleted.');
    }
    header('Location: reviews.php');
    exit;
}

$reviews = $pdo->query("SELECT * FROM reviews ORDER BY created_at DESC")->fetchAll();
?>

<div class="container admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="admin-header-title">Guest Reviews</h1>
            <p class="admin-header-desc">Manage testimonials and customer feedback displayed on the homepage.</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Guest</th>
                        <th>Location</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reviews)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No reviews found.</td></tr>
                    <?php else: ?>
                        <?php foreach ($reviews as $rev): ?>
                            <tr>
                                <td><strong><?= e($rev['guest_name']) ?></strong></td>
                                <td><?= e($rev['location']) ?></td>
                                <td>
                                    <span class="text-warning">
                                        <?= str_repeat('★', (int)$rev['rating']) ?>
                                    </span>
                                </td>
                                <td style="max-width: 320px;">
                                    <div class="text-truncate" title="<?= e($rev['comment']) ?>">
                                        <?= e($rev['comment']) ?>
                                    </div>
                                </td>
                                <td>
                                    <a href="reviews.php?action=toggle&id=<?= (int)$rev['id'] ?>"
                                       class="badge text-decoration-none <?= $rev['is_approved'] ? 'bg-success' : 'bg-warning text-dark' ?>"
                                       title="Click to toggle approval">
                                        <?= $rev['is_approved'] ? 'Approved' : 'Pending' ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="reviews.php?action=toggle&id=<?= (int)$rev['id'] ?>" class="btn btn-outline-secondary" title="Toggle visibility">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="reviews.php?action=delete&id=<?= (int)$rev['id'] ?>" class="btn btn-outline-danger btn-confirm-delete" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/admin.js"></script>
</body>
</html>
