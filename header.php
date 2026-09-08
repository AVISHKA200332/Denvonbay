<?php
// Current active page detection for nav link highlighting
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!-- ===== SITE HEADER & NAVIGATION ===== -->
<header id="site-header" class="site-header">
    <div class="header-container">

        <!-- Site Logo -->
        <a href="index.php" class="site-logo" aria-label="Denvonbay Home">
            <img src="assets/images/logo/PrimaryLogo.png" alt="Denvonbay" class="site-logo-img">
        </a>

        <!-- Desktop Navigation -->
        <nav class="desktop-nav" aria-label="Main navigation">
            <ul class="nav-list">
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
        </nav>

        <!-- Header Actions: CTA + Hamburger Toggle -->
        <div class="header-actions">
            <a href="booking.php" class="header-book-btn" id="navBookBtn">
                <span>Book Your Stay</span>
                <i class="bi bi-arrow-right-short"></i>
            </a>

            <button class="menu-toggle" id="menuToggle" type="button" aria-label="Toggle navigation" aria-expanded="false" aria-controls="mobileNav">
                <span class="hamburger-box">
                    <span class="hamburger-bar bar-top"></span>
                    <span class="hamburger-bar bar-mid"></span>
                    <span class="hamburger-bar bar-bot"></span>
                </span>
            </button>
        </div>

    </div>

    <!-- Mobile Navigation Backdrop Overlay -->
    <div class="mobile-nav-backdrop" id="mobileNavBackdrop" aria-hidden="true"></div>

    <!-- Mobile Navigation Drawer -->
    <nav class="mobile-nav" id="mobileNav" aria-label="Mobile navigation" aria-hidden="true">
        <div class="mobile-nav-header">
            <a href="index.php" class="mobile-nav-logo" aria-label="Denvonbay Home">
                <img src="assets/images/logo/PrimaryLogo.png" alt="Denvonbay" class="mobile-logo-img">
            </a>
            <button class="mobile-close-btn" id="mobileCloseBtn" type="button" aria-label="Close navigation">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="mobile-nav-body">
            <ul class="mobile-nav-list">
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'index' || $currentPage === '') ? 'active' : '' ?>" href="index.php">
                        <span>Home</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'about') ? 'active' : '' ?>" href="about.php">
                        <span>About</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'rooms' || $currentPage === 'room-details') ? 'active' : '' ?>" href="rooms.php">
                        <span>Rooms</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'packages') ? 'active' : '' ?>" href="packages.php">
                        <span>Packages</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'explore') ? 'active' : '' ?>" href="explore.php">
                        <span>Explore</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'amenities') ? 'active' : '' ?>" href="amenities.php">
                        <span>Amenities</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'gallery') ? 'active' : '' ?>" href="gallery.php">
                        <span>Gallery</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'faq') ? 'active' : '' ?>" href="faq.php">
                        <span>FAQ</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <li>
                    <a class="mobile-nav-link <?= ($currentPage === 'contact') ? 'active' : '' ?>" href="contact.php">
                        <span>Contact</span>
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>

            <div class="mobile-nav-footer">
                <a href="booking.php" class="mobile-book-btn">
                    <i class="bi bi-calendar2-check me-2"></i>Book Your Stay
                </a>
            </div>
        </div>
    </nav>
</header>
