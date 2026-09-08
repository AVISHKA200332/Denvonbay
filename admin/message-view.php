<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    set_flash('error', 'Invalid message ID.');
    redirect('messages.php');
}

// Fetch message
$stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->execute([$id]);
$msg = $stmt->fetch();

if (!$msg) {
    set_flash('error', 'Message not found.');
    redirect('messages.php');
}

// Auto-mark as read if unread upon viewing
if ($msg['is_read'] == 0) {
    $pdo->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?")->execute([$id]);
    $msg['is_read'] = 1;
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');
    $action = $_POST['action'] ?? '';

    if ($action === 'toggle_read') {
        $new_status = $msg['is_read'] ? 0 : 1;
        $pdo->prepare("UPDATE contact_messages SET is_read = ? WHERE id = ?")->execute([$new_status, $id]);
        set_flash('success', $new_status ? 'Marked as read.' : 'Marked as unread.');
        redirect("message-view.php?id={$id}");
    } elseif ($action === 'delete') {
        $pdo->prepare("DELETE FROM contact_messages WHERE id = ?")->execute([$id]);
        set_flash('success', 'Message deleted successfully.');
        redirect('messages.php');
    }
}

$page_title = "Message: " . htmlspecialchars($msg['subject'] ?? 'Inquiry');
require_once __DIR__ . '/admin-header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="messages.php" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Messages
            </a>
            <div class="d-flex gap-2">
                <form method="POST" class="d-inline">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="toggle_read">
                    <button type="submit" class="btn btn-sm <?= $msg['is_read'] ? 'btn-outline-secondary' : 'btn-outline-success' ?>">
                        <i class="bi <?= $msg['is_read'] ? 'bi-envelope' : 'bi-envelope-check' ?> me-1"></i>
                        Mark as <?= $msg['is_read'] ? 'Unread' : 'Read' ?>
                    </button>
                </form>
                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="action" value="delete">
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="admin-card">
            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-4">
                <div>
                    <h3 class="h4 mb-1 fw-bold text-dark"><?= htmlspecialchars($msg['subject'] ?? 'Customer Inquiry') ?></h3>
                    <div class="text-muted small">
                        Received on <?= date('F d, Y \a\t h:i A', strtotime($msg['created_at'])) ?>
                        • Status: <?= $msg['is_read'] ? '<span class="badge-status badge-confirmed">Read</span>' : '<span class="badge-status badge-pending">Unread</span>' ?>
                    </div>
                </div>
            </div>

            <div class="row g-3 p-3 bg-light rounded-3 mb-4">
                <div class="col-md-6">
                    <label class="text-muted small d-block">Sender Name</label>
                    <strong class="text-dark fs-6"><?= htmlspecialchars($msg['name']) ?></strong>
                </div>
                <div class="col-md-6">
                    <label class="text-muted small d-block">Email Address</label>
                    <a href="mailto:<?= htmlspecialchars($msg['email']) ?>" class="fw-semibold text-primary">
                        <i class="bi bi-envelope me-1"></i><?= htmlspecialchars($msg['email']) ?>
                    </a>
                </div>
                <?php if (!empty($msg['phone'])): ?>
                <div class="col-md-6">
                    <label class="text-muted small d-block">Phone / WhatsApp</label>
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $msg['phone']) ?>" target="_blank" class="fw-semibold text-success">
                        <i class="bi bi-whatsapp me-1"></i><?= htmlspecialchars($msg['phone']) ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <label class="form-label text-muted small text-uppercase fw-semibold">Message Content</label>
                <div class="p-4 border rounded-3 bg-white" style="line-height: 1.7; font-size: 0.95rem; white-space: pre-line;">
                    <?= nl2br(htmlspecialchars($msg['message'])) ?>
                </div>
            </div>

            <div class="d-flex gap-2 pt-2 border-top">
                <a href="mailto:<?= htmlspecialchars($msg['email']) ?>?subject=Re: <?= urlencode($msg['subject'] ?? 'Inquiry at Denvonbay') ?>" class="btn btn-primary">
                    <i class="bi bi-reply-fill me-1"></i> Reply via Email
                </a>
                <?php if (!empty($msg['phone'])): ?>
                <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $msg['phone']) ?>?text=<?= urlencode("Hello " . $msg['name'] . ", regarding your inquiry at Denvonbay Surf & Stay:") ?>" target="_blank" class="btn btn-success">
                    <i class="bi bi-whatsapp me-1"></i> Reply via WhatsApp
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
