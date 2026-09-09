<?php
/**
 * Denvonbay - Admin Header Component
 * ----------------------------------
 * Included by all authenticated admin pages.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

// Protect admin access
require_admin();

// Active page detection
$activePage = basename($_SERVER['PHP_SELF'], '.php');
$flash = get_flash();

// Real counts for badges and notifications
$navPendingBookings = 0;
$navUnreadMessages  = 0;
$navPendingReviews   = 0;

try {
    $navPendingBookings = (int)$pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
    $navUnreadMessages  = (int)$pdo->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
    $navPendingReviews  = (int)$pdo->query("SELECT COUNT(*) FROM reviews WHERE is_approved = 0")->fetchColumn();
} catch (PDOException $e) {
    // Graceful fallback
}

$adminUsername = $_SESSION['admin_username'] ?? 'Administrator';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($adminTitle) ? e($adminTitle) . ' | ' : '' ?>Denvonbay Admin Portal</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/logo/favicon.png">

    <!-- Admin Stylesheet -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">

<div class="admin-layout">

    <!-- Sidebar Component -->
    <?php include __DIR__ . '/admin-sidebar.php'; ?>

    <!-- Main Content Wrapper -->
    <div class="admin-main">

        <!-- Top Navigation Bar -->
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button class="admin-mobile-toggle" id="adminMobileToggle" type="button" aria-label="Toggle navigation menu">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1 class="admin-topbar-title"><?= isset($adminTitle) ? e($adminTitle) : 'Dashboard' ?></h1>
                    <p class="admin-topbar-breadcrumb">
                        <a href="dashboard.php" class="text-decoration-none text-muted">Admin</a>
                        <?php if (isset($adminTitle) && $adminTitle !== 'Dashboard'): ?>
                            <span class="mx-1">/</span>
                            <span><?= e($adminTitle) ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <div class="admin-topbar-right">
                <a href="../index.php" target="_blank" rel="noopener" class="admin-quick-link" title="Open customer website in a new tab">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>Live Site</span>
                </a>

                <a href="profile.php" class="admin-user-pill" title="View Admin Profile">
                    <div class="admin-user-avatar">
                        <?= strtoupper(substr($adminUsername, 0, 1)) ?>
                    </div>
                    <div class="admin-user-info d-none d-sm-block">
                        <div class="admin-user-name"><?= e($adminUsername) ?></div>
                        <div class="admin-user-role">Manager</div>
                    </div>
                </a>

                <a href="logout.php" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1 ms-1" style="border-radius: 8px; font-weight: 600; padding: 6px 12px;" title="Sign out of Admin Dashboard">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="d-none d-md-inline">Sign Out</span>
                </a>
            </div>
        </header>

        <!-- Main Body Content -->
        <main class="admin-content">

            <!-- Flash Notifications -->
            <?php if ($flash): ?>
                <div class="admin-alert admin-alert-<?= e($flash['type']) ?>" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <?php if ($flash['type'] === 'success'): ?>
                            <i class="bi bi-check-circle-fill fs-5"></i>
                        <?php elseif ($flash['type'] === 'danger'): ?>
                            <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                        <?php elseif ($flash['type'] === 'warning'): ?>
                            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                        <?php else: ?>
                            <i class="bi bi-info-circle-fill fs-5"></i>
                        <?php endif; ?>
                        <span><?= e($flash['message']) ?></span>
                    </div>
                    <button type="button" class="btn-close" onclick="this.parentElement.remove();" aria-label="Close"></button>
                </div>
            <?php endif; ?>
