<?php
// Current active page detection for nav link highlighting
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>
<!-- Dark Mode Stylesheet -->
<link rel="stylesheet" href="assets/css/dark-mode.css?v=<?= file_exists('assets/css/dark-mode.css') ? filemtime('assets/css/dark-mode.css') : '2.0' ?>">

<!-- Theme Controller Script (Default is Light; persists user preference) -->
<script>
  (function() {
    window.setDenvonbayTheme = function(theme) {
      try {
        var isDark = (theme === 'dark');
        var html = document.documentElement;
        if (isDark) {
          html.setAttribute('data-theme', 'dark');
          html.classList.add('dark-theme');
        } else {
          html.setAttribute('data-theme', 'light');
          html.classList.remove('dark-theme');
        }
        try {
          localStorage.setItem('denvonbay_theme', isDark ? 'dark' : 'light');
        } catch(err) {}

        // Sync buttons
        var btn = document.getElementById('themeToggleBtn');
        if (btn) {
          btn.setAttribute('title', isDark ? 'Switch to light mode' : 'Switch to dark mode');
          btn.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
        }
        var mobBtn = document.getElementById('mobileThemeToggleBtn');
        if (mobBtn) {
          var label = mobBtn.querySelector('.theme-mode-text');
          if (label) label.textContent = isDark ? 'Light Mode' : 'Dark Mode';
          mobBtn.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
        }
      } catch(e) {}
    };

    var isThemeToggling = false;
    window.toggleDenvonbayTheme = function(e) {
      if (e) {
        if (typeof e.preventDefault === 'function') e.preventDefault();
        if (typeof e.stopPropagation === 'function') e.stopPropagation();
      }

      // Debounce protection: prevent double invocation
      if (isThemeToggling) return false;
      isThemeToggling = true;
      setTimeout(function() { isThemeToggling = false; }, 250);

      var current = document.documentElement.getAttribute('data-theme') || 'light';
      var next = (current === 'dark') ? 'light' : 'dark';
      window.setDenvonbayTheme(next);
      return false;
    };

    // Immediate Initialization: Default to LIGHT mode unless 'dark' is explicitly saved
    try {
      var storedTheme = localStorage.getItem('denvonbay_theme');
      if (storedTheme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        document.documentElement.classList.add('dark-theme');
      } else {
        document.documentElement.setAttribute('data-theme', 'light');
        document.documentElement.classList.remove('dark-theme');
      }
    } catch(e) {}

    // Bind event handler cleanly once DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
      var btn = document.getElementById('themeToggleBtn');
      if (btn) {
        btn.onclick = window.toggleDenvonbayTheme;
      }
      var mobBtn = document.getElementById('mobileThemeToggleBtn');
      if (mobBtn) {
        mobBtn.onclick = window.toggleDenvonbayTheme;
      }
      var cur = document.documentElement.getAttribute('data-theme') || 'light';
      window.setDenvonbayTheme(cur);
    });
  })();
</script>
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
                    <a class="nav-link <?= ($currentPage === 'explore' || $currentPage === 'destination-details') ? 'active' : '' ?>" href="explore.php">Explore</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($currentPage === 'amenities') ? 'active' : '' ?>" href="amenities.php">Amenities</a>
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
            <!-- Theme Toggle Button (Before Book Your Stay) -->
            <button class="theme-toggle-btn" id="themeToggleBtn" type="button" aria-label="Toggle dark mode" title="Switch theme">
                <span class="theme-icon-box">
                    <i class="bi bi-moon-stars-fill moon-icon"></i>
                    <i class="bi bi-sun-fill sun-icon"></i>
                </span>
            </button>

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
</header>

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
                <a class="mobile-nav-link <?= ($currentPage === 'explore' || $currentPage === 'destination-details') ? 'active' : '' ?>" href="explore.php">
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
            <button class="mobile-theme-toggle-btn" id="mobileThemeToggleBtn" type="button" aria-label="Toggle dark mode">
                <span class="mobile-theme-label">
                    <i class="bi bi-moon-stars-fill moon-icon"></i>
                    <i class="bi bi-sun-fill sun-icon"></i>
                    <span class="theme-mode-text">Dark Mode</span>
                </span>
                <span class="theme-switch-slider"></span>
            </button>
            <a href="booking.php" class="mobile-book-btn">
                <i class="bi bi-calendar2-check me-2"></i>Book Your Stay
            </a>
        </div>
    </div>
</nav>
