<?php
// Current active page detection for nav link highlighting
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!-- ===== SITE HEADER & NAVIGATION ===== -->
<header id="site-header" class="site-header">
    <nav class="navbar navbar-expand-lg" id="mainNavbar">
        <div class="container navbar-inner">

            <!-- Brand / Logo -->
            <a href="index.php" class="navbar-brand brand-logo">
                <img src="assets/images/logo/PrimaryLogo.png" alt="Denvonbay" class="brand-logo-img">
            </a>

            <!-- Mobile Hamburger Button -->
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
                        <a class="nav-link <?= ($currentPage === 'index' || $currentPage === '') ? 'active' : '' ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'about') ? 'active' : '' ?>" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'rooms' || $currentPage === 'room-details') ? 'active' : '' ?>" href="rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'packages') ? 'active' : '' ?>" href="packages.php">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'explore') ? 'active' : '' ?>" href="explore.php">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'amenities') ? 'active' : '' ?>" href="amenities.php">Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'gallery') ? 'active' : '' ?>" href="gallery.php">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'faq') ? 'active' : '' ?>" href="faq.php">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage === 'contact') ? 'active' : '' ?>" href="contact.php">Contact</a>
                    </li>
                </ul>

                <!-- Book Now CTA -->
                <div class="navbar-cta">
                    <a href="booking.php" class="btn btn-book" id="navBookBtn">
                        <i class="bi bi-calendar2-check me-1"></i>Book Your Stay
                    </a>
                </div>
            </div>

        </div>
    </nav>
</header>
