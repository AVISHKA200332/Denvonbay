<?php
/**
 * Denvonbay - Admin Login
 * -----------------------
 * Secure session authentication.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Redirect if already logged in
if (is_admin_logged_in()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        if (login_admin($pdo, $email, $password)) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid email or password. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Denvonbay</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Admin Stylesheet -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="admin-login-wrap">
        <div class="text-center mb-4">
            <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--admin-dark);">
                <i class="bi bi-water text-primary me-1"></i> Denvon<span class="text-primary">bay</span>
            </h1>
            <p class="text-muted" style="font-size: 0.875rem;">Admin Management Portal</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert" style="font-size: 0.875rem;">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> <?= e($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="admin-form-group">
                <label for="adminEmail" class="admin-label">Email Address</label>
                <input type="email" id="adminEmail" name="email" class="form-control" required placeholder="admin@denvonbay.com" value="<?= e($_POST['email'] ?? '') ?>">
            </div>

            <div class="admin-form-group">
                <label for="adminPassword" class="admin-label">Password</label>
                <input type="password" id="adminPassword" name="password" class="form-control" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 mt-3" style="background: var(--admin-primary); border-radius: 8px;">
                Sign In to Dashboard
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top" style="font-size: 0.8rem; color: var(--admin-muted);">
            <a href="../index.php" class="text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i> Return to Website
            </a>
        </div>
    </div>

</body>
</html>
