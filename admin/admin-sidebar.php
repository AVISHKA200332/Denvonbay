<?php
/**
 * Denvonbay - Admin Sidebar Component
 * -----------------------------------
 * Reusable navigation sidebar for all admin views.
 */

// Active page identification
$activePage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!-- ===== ADMIN SIDEBAR ===== -->
<aside class="admin-sidebar" id="adminSidebar" aria-label="Admin Navigation">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="admin-sidebar-brand">
        <img src="../assets/images/logo/appicon.png" alt="Denvonbay Logo" width="34" height="34">
        <span class="admin-sidebar-brand-text">Denvon<span>bay</span></span>
        <span class="admin-sidebar-tag">Admin</span>
    </a>

    <!-- Navigation Menu -->
    <nav class="admin-sidebar-menu">
        <span class="admin-sidebar-heading">Main Menu</span>

        <a href="dashboard.php" class="admin-nav-item <?= ($activePage === 'dashboard') ? 'active' : '' ?>">
            <span class="admin-nav-item-content">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </span>
        </a>

        <a href="bookings.php" class="admin-nav-item <?= (strpos($activePage, 'booking') !== false) ? 'active' : '' ?>">
            <span class="admin-nav-item-content">
                <i class="bi bi-calendar2-check"></i>
                <span>Bookings</span>
            </span>
            <?php if (!empty($navPendingBookings) && $navPendingBookings > 0): ?>
                <span class="admin-nav-badge badge-warning" title="<?= $navPendingBookings ?> pending bookings"><?= $navPendingBookings ?></span>
            <?php endif; ?>
        </a>

        <a href="rooms.php" class="admin-nav-item <?= (strpos($activePage, 'room') !== false) ? 'active' : '' ?>">
            <span class="admin-nav-item-content">
                <i class="bi bi-door-open"></i>
                <span>Rooms</span>
            </span>
        </a>

        <a href="packages.php" class="admin-nav-item <?= (strpos($activePage, 'package') !== false) ? 'active' : '' ?>">
            <span class="admin-nav-item-content">
                <i class="bi bi-boxes"></i>
                <span>Packages</span>
            </span>
        </a>

        <span class="admin-sidebar-heading">Content & Inquiries</span>

        <a href="messages.php" class="admin-nav-item <?= (strpos($activePage, 'message') !== false) ? 'active' : '' ?>">
            <span class="admin-nav-item-content">
                <i class="bi bi-envelope"></i>
                <span>Messages</span>
            </span>
            <?php if (!empty($navUnreadMessages) && $navUnreadMessages > 0): ?>
                <span class="admin-nav-badge badge-warning" title="<?= $navUnreadMessages ?> unread messages"><?= $navUnreadMessages ?></span>
            <?php endif; ?>
        </a>

        <a href="reviews.php" class="admin-nav-item <?= (strpos($activePage, 'review') !== false) ? 'active' : '' ?>">
            <span class="admin-nav-item-content">
                <i class="bi bi-star"></i>
                <span>Reviews</span>
            </span>
            <?php if (!empty($navPendingReviews) && $navPendingReviews > 0): ?>
                <span class="admin-nav-badge badge-primary" title="<?= $navPendingReviews ?> pending moderation"><?= $navPendingReviews ?></span>
            <?php endif; ?>
        </a>

        <span class="admin-sidebar-heading">Management</span>

        <a href="settings.php" class="admin-nav-item <?= ($activePage === 'settings') ? 'active' : '' ?>">
            <span class="admin-nav-item-content">
                <i class="bi bi-gear"></i>
                <span>Site Settings</span>
            </span>
        </a>

        <a href="profile.php" class="admin-nav-item <?= ($activePage === 'profile') ? 'active' : '' ?>">
            <span class="admin-nav-item-content">
                <i class="bi bi-person-gear"></i>
                <span>Admin Profile</span>
            </span>
        </a>
    </nav>

    <!-- Sidebar Bottom Actions -->
    <div class="admin-sidebar-footer">
        <a href="../index.php" target="_blank" rel="noopener" class="admin-nav-item text-view-site">
            <span class="admin-nav-item-content">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>View Live Site</span>
            </span>
        </a>

        <a href="logout.php" class="admin-nav-item text-logout">
            <span class="admin-nav-item-content">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
            </span>
        </a>
    </div>
</aside>
