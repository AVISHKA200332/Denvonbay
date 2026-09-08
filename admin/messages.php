<?php
/**
 * Denvonbay - Admin Messages (Inquiries)
 */

$adminTitle = 'Contact Messages';
require_once __DIR__ . '/admin-header.php';

// Handle mark read / delete
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $mId = (int)$_GET['id'];

    if ($action === 'read') {
        $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
        $stmt->execute([$mId]);
        set_flash('success', 'Message marked as read.');
    } elseif ($action === 'delete') {
        $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$mId]);
        set_flash('danger', 'Message deleted.');
    }
    header('Location: messages.php');
    exit;
}

$messages = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>

<div class="container admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h1 class="admin-header-title">Guest Messages & Inquiries</h1>
            <p class="admin-header-desc">Inquiries sent via the website contact form.</p>
        </div>
    </div>

    <div class="admin-card">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Sender</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($messages)): ?>
                        <tr><td colspan="6" class="text-center py-4 text-muted">No messages received yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($messages as $m): ?>
                            <tr class="<?= !$m['is_read'] ? 'fw-bold bg-light' : '' ?>">
                                <td style="white-space: nowrap;"><?= format_date($m['created_at']) ?></td>
                                <td>
                                    <?= e($m['name']) ?><br>
                                    <small class="text-muted fw-normal">
                                        <a href="mailto:<?= e($m['email']) ?>"><?= e($m['email']) ?></a>
                                    </small>
                                </td>
                                <td><?= e($m['subject'] ?? 'No Subject') ?></td>
                                <td style="max-width: 320px;">
                                    <div class="text-truncate fw-normal" title="<?= e($m['message']) ?>">
                                        <?= e($m['message']) ?>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge <?= $m['is_read'] ? 'bg-secondary' : 'bg-primary' ?>">
                                        <?= $m['is_read'] ? 'Read' : 'New' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <?php if (!$m['is_read']): ?>
                                            <a href="messages.php?action=read&id=<?= (int)$m['id'] ?>" class="btn btn-outline-success" title="Mark as read">
                                                <i class="bi bi-check2"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="mailto:<?= e($m['email']) ?>?subject=Re: <?= urlencode($m['subject'] ?? 'Inquiry') ?>" class="btn btn-outline-primary" title="Reply by email">
                                            <i class="bi bi-reply"></i>
                                        </a>
                                        <a href="messages.php?action=delete&id=<?= (int)$m['id'] ?>" class="btn btn-outline-danger btn-confirm-delete" title="Delete message">
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
