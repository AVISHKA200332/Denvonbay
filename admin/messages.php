<?php
/**
 * Denvonbay - Admin Messages (Inquiries)
 * --------------------------------------
 * Manage customer inquiries submitted via the website contact form.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

// Handle POST actions (Toggle Read Status, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token     = $_POST['csrf_token'] ?? '';
    $action    = $_POST['action'] ?? '';
    $messageId = (int)($_POST['id'] ?? 0);

    if (!verify_csrf_token($token)) {
        set_flash('danger', 'Security validation failed (invalid CSRF token).');
        header('Location: messages.php');
        exit;
    }

    if ($action === 'toggle_read' && $messageId > 0) {
        $stmt = $pdo->prepare("UPDATE contact_messages SET is_read = NOT is_read WHERE id = ?");
        $stmt->execute([$messageId]);
        set_flash('success', 'Message status updated.');
    } elseif ($action === 'delete' && $messageId > 0) {
        $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$messageId]);
        set_flash('danger', 'Message deleted.');
    }

    header('Location: messages.php');
    exit;
}

$filter = $_GET['filter'] ?? 'all';
$sql = "SELECT * FROM contact_messages";
$params = [];

if ($filter === 'unread') {
    $sql .= " WHERE is_read = 0";
} elseif ($filter === 'read') {
    $sql .= " WHERE is_read = 1";
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$messages = $stmt->fetchAll();

$countUnread = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
$countAll    = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();

$adminTitle = 'Messages';
require_once __DIR__ . '/admin-header.php';
?>

<div class="admin-page-header">
    <div>
        <h2 class="admin-page-title">Guest Inquiries & Messages</h2>
        <p class="admin-page-desc">Messages submitted by potential guests through the contact form.</p>
    </div>
</div>

<!-- Filter Pills -->
<div class="admin-filter-bar">
    <div class="admin-filter-pills">
        <a href="messages.php" class="admin-filter-pill <?= ($filter === 'all') ? 'active' : '' ?>">
            All Messages (<?= $countAll ?>)
        </a>
        <a href="messages.php?filter=unread" class="admin-filter-pill <?= ($filter === 'unread') ? 'active' : '' ?>">
            Unread (<?= $countUnread ?>)
        </a>
        <a href="messages.php?filter=read" class="admin-filter-pill <?= ($filter === 'read') ? 'active' : '' ?>">
            Read (<?= $countAll - $countUnread ?>)
        </a>
    </div>
</div>

<div class="admin-card">
    <div class="admin-table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Sender Name</th>
                    <th>Email Address</th>
                    <th>Subject</th>
                    <th>Preview</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($messages)): ?>
                    <tr>
                        <td colspan="7">
                            <div class="admin-empty-state">
                                <div class="admin-empty-icon"><i class="bi bi-inbox"></i></div>
                                <div class="admin-empty-title">No messages in this folder</div>
                                <div class="admin-empty-desc">New guest inquiries from the contact page will show up here.</div>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($messages as $m): ?>
                        <tr style="<?= !$m['is_read'] ? 'background-color: #F8FAFC; font-weight: 500;' : '' ?>">
                            <td>
                                <form method="POST" action="messages.php" class="d-inline">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
                                    <input type="hidden" name="action" value="toggle_read">
                                    <button type="submit" class="badge-status border-0 <?= $m['is_read'] ? 'badge-inactive' : 'badge-pending' ?>" style="cursor: pointer;" title="Toggle read/unread">
                                        <?= $m['is_read'] ? 'Read' : 'New' ?>
                                    </button>
                                </form>
                            </td>
                            <td style="white-space: nowrap;"><?= format_date($m['created_at']) ?></td>
                            <td class="fw-bold text-dark"><?= e($m['name']) ?></td>
                            <td>
                                <a href="mailto:<?= e($m['email']) ?>" class="text-decoration-none text-primary">
                                    <?= e($m['email']) ?>
                                </a>
                            </td>
                            <td><?= e($m['subject'] ?: '(No Subject)') ?></td>
                            <td style="max-width: 260px;" class="text-truncate">
                                <?= e($m['message']) ?>
                            </td>
                            <td>
                                <div class="admin-actions-cell">
                                    <a href="message-view.php?id=<?= (int)$m['id'] ?>" class="admin-btn admin-btn-secondary admin-btn-sm" title="Read full message">
                                        <i class="bi bi-eye"></i> View
                                    </a>

                                    <a href="mailto:<?= e($m['email']) ?>?subject=Re:%20<?= urlencode($m['subject'] ?: 'Your inquiry to Denvonbay') ?>" class="admin-btn admin-btn-primary admin-btn-sm" title="Reply via email">
                                        <i class="bi bi-reply"></i>
                                    </a>

                                    <form method="POST" action="messages.php" class="d-inline form-confirm-delete" data-confirm-msg="Permanently delete this message?">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" title="Delete message">
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
