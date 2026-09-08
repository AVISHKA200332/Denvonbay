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

$activePage = basename($_SERVER['PHP_SELF'], '.php');
$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($adminTitle) ? e($adminTitle) . ' | ' : '' ?>Denvonbay Admin</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/logo/favicon.png">

    <!-- Admin Stylesheet -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="admin-body">

<header class="admin-navbar">
    <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="dashboard.php" class="admin-brand">
            <img src="../assets/images/logo/appicon.png" alt="Denvonbay Logo" width="30" height="30" style="border-radius: 6px;"> Denvon<span>bay</span> <small class="text-white-50 ms-1 fw-normal" style="font-size: 0.8rem;">Admin</small>
        </a>

        <nav class="admin-nav-links">
            <a href="dashboard.php" class="admin-nav-link <?= ($activePage === 'dashboard') ? 'active' : '' ?>">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
            <a href="bookings.php" class="admin-nav-link <?= (strpos($activePage, 'booking') !== false) ? 'active' : '' ?>">
                <i class="bi bi-calendar2-check me-1"></i> Bookings
            </a>
            <a href="rooms.php" class="admin-nav-link <?= (strpos($activePage, 'room') !== false) ? 'active' : '' ?>">
                <i class="bi bi-door-open me-1"></i> Rooms
            </a>
            <a href="packages.php" class="admin-nav-link <?= (strpos($activePage, 'package') !== false) ? 'active' : '' ?>">
                <i class="bi bi-boxes me-1"></i> Packages
            </a>
            <a href="messages.php" class="admin-nav-link <?= ($activePage === 'messages') ? 'active' : '' ?>">
                <i class="bi bi-envelope me-1"></i> Messages
            </a>
            <a href="reviews.php" class="admin-nav-link <?= ($activePage === 'reviews') ? 'active' : '' ?>">
                <i class="bi bi-star me-1"></i> Reviews
            </a>
            <a href="../index.php" target="_blank" class="admin-nav-link text-info">
                <i class="bi bi-box-arrow-up-right me-1"></i> View Site
            </a>
            <a href="logout.php" class="admin-nav-link text-danger">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </a>
        </nav>
    </div>
</header>

<div class="container mt-4">
    <?php if ($flash): ?>
        <div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert">
            <?= e($flash['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>
