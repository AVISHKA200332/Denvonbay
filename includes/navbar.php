<?php
/**
 * Denvonbay - Navbar Include
 * --------------------------------------------------
 * Sticky top navigation bar.
 * Uses $base defined in header.php.
 * Detects the current page to highlight the active link.
 * --------------------------------------------------
 */

// Safety fallback: if included without header.php
if (!isset($base)) {
    $base = '/Denvonbay';
}

// Get current page filename without extension (e.g. "index", "rooms")
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<header id="site-header" class="site-header">
    <nav class="navbar navbar-expand-lg" id="mainNavbar">
        <div class="container navbar-inner">

            <!-- Brand / Logo -->
            <a href="<?= $base ?>/" class="navbar-brand brand-logo">
                <span class="brand-icon"><i class="bi bi-water"></i></span>
                <span class="brand-text">Denvon<span class="brand-accent">bay</span></span>
            </a>

            <!-- Mobile Hamburger -->
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarMain"
                    aria-controls="navbarMain"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="toggler-icon"><i class="bi bi-list"></i></span>
            </button>

            <!-- Nav Links -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'index')     ? 'active' : '' ?>" href="<?= $base ?>/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'about')     ? 'active' : '' ?>" href="<?= $base ?>/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'rooms')     ? 'active' : '' ?>" href="<?= $base ?>/rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'packages')  ? 'active' : '' ?>" href="<?= $base ?>/packages.php">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'explore')   ? 'active' : '' ?>" href="<?= $base ?>/explore.php">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'amenities') ? 'active' : '' ?>" href="<?= $base ?>/amenities.php">Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'faq')       ? 'active' : '' ?>" href="<?= $base ?>/faq.php">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'contact')   ? 'active' : '' ?>" href="<?= $base ?>/contact.php">Contact</a>
                    </li>
                </ul>

                <!-- Book Now Button -->
                <div class="navbar-cta">
                    <a href="<?= $base ?>/booking.php" class="btn btn-book" id="navBookBtn">
                        <i class="bi bi-calendar2-check me-1"></i>Book Your Stay
                    </a>
                </div>
            </div>

        </div>
    </nav>
</header>