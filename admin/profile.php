<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

$admin_id = $_SESSION['admin_id'] ?? 0;
$stmt = $pdo->prepare("SELECT id, username, email FROM admin_users WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

if (!$admin) {
    set_flash('error', 'Admin user not found.');
    redirect('logout.php');
}

$errors = [];
$username = $admin['username'];
$email = $admin['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $new_username = trim($_POST['username'] ?? '');
    $new_email = trim($_POST['email'] ?? '');
    $current_pass = $_POST['current_password'] ?? '';
    $new_pass = $_POST['new_password'] ?? '';
    $confirm_pass = $_POST['confirm_password'] ?? '';

    if (empty($new_username)) {
        $errors[] = 'Username is required.';
    }
    if (empty($new_email) || !filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }

    // Check if username taken by someone else
    $chk = $pdo->prepare("SELECT id FROM admin_users WHERE username = ? AND id != ?");
    $chk->execute([$new_username, $admin_id]);
    if ($chk->fetch()) {
        $errors[] = 'Username is already taken by another administrator.';
    }

    // If changing password
    if (!empty($new_pass)) {
        // Must verify current password
        $pStmt = $pdo->prepare("SELECT password FROM admin_users WHERE id = ?");
        $pStmt->execute([$admin_id]);
        $currHash = $pStmt->fetchColumn();

        if (!password_verify($current_pass, $currHash)) {
            $errors[] = 'Current password is incorrect.';
        } elseif (strlen($new_pass) < 6) {
            $errors[] = 'New password must be at least 6 characters long.';
        } elseif ($new_pass !== $confirm_pass) {
            $errors[] = 'New password and confirmation do not match.';
        }
    }

    if (empty($errors)) {
        if (!empty($new_pass)) {
            $hashed = password_hash($new_pass, PASSWORD_DEFAULT);
            $uStmt = $pdo->prepare("UPDATE admin_users SET username = ?, email = ?, password = ? WHERE id = ?");
            $uStmt->execute([$new_username, $new_email, $hashed, $admin_id]);
        } else {
            $uStmt = $pdo->prepare("UPDATE admin_users SET username = ?, email = ? WHERE id = ?");
            $uStmt->execute([$new_username, $new_email, $admin_id]);
        }

        $_SESSION['admin_user'] = $new_username;
        $_SESSION['admin_email'] = $new_email;

        set_flash('success', 'Profile updated successfully.');
        redirect('profile.php');
    }
}

$page_title = "Admin Profile";
require_once __DIR__ . '/admin-header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h4 mb-1 fw-bold text-dark">Admin Profile & Security</h2>
                <p class="text-muted small mb-0">Update your account credentials and login password.</p>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="admin-card mb-4">
            <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">Account Details</h5>
            <form method="POST">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
                </div>

                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2 pt-2">Change Password <small class="text-muted fw-normal fs-6">(Optional)</small></h5>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Current Password</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Required only if changing password">
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">New Password</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Min 6 characters">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Confirm New Password</label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Repeat new password">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Save Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
