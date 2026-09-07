<?php
/**
 * Denvonbay - Navbar Include
 * Sticky responsive navigation with active link detection
 */

if (!defined('BASE_URL')) {
    require_once dirname(__DIR__) . '/config/config.php';
}

$current_page = basename($_SERVER['PHP_SELF'], '.php');

function nav_active(string $page, string $current): string {
    return ($page === $current) ? 'active' : '';
}

$b = BASE_URL; // shorthand
?>
<header id="site-header" class="site-header">
    <nav class="navbar navbar-expand-lg" id="mainNavbar" aria-label="Denvonbay main navigation">
        <div class="container navbar-inner">

            <!-- Brand -->
            <a class="navbar-brand brand-logo" href="<?php echo $b; ?>/" aria-label="Denvonbay Home">
                <span class="brand-icon"><i class="bi bi-water"></i></span>
                <span class="brand-text">Denvon<span class="brand-accent">bay</span></span>
            </a>

            <!-- Mobile toggler -->
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarMain"
                    aria-controls="navbarMain" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="toggler-icon"><i class="bi bi-list"></i></span>
            </button>

            <!-- Nav links -->
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav mx-auto gap-1" role="list">
                    <li class="nav-item">
                        <a class="nav-link <?php echo nav_active('index', $current_page); ?>"
                           href="<?php echo $b; ?>/"
                           <?php if ($current_page === 'index') echo 'aria-current="page"'; ?>>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo nav_active('about', $current_page); ?>"
                           href="<?php echo $b; ?>/about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo nav_active('rooms', $current_page); ?>"
                           href="<?php echo $b; ?>/rooms.php">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo nav_active('packages', $current_page); ?>"
                           href="<?php echo $b; ?>/packages.php">Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo nav_active('explore', $current_page); ?>"
                           href="<?php echo $b; ?>/explore.php">Explore</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo nav_active('amenities', $current_page); ?>"
                           href="<?php echo $b; ?>/amenities.php">Amenities</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo nav_active('faq', $current_page); ?>"
                           href="<?php echo $b; ?>/faq.php">FAQ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo nav_active('contact', $current_page); ?>"
                           href="<?php echo $b; ?>/contact.php">Contact</a>
                    </li>
                </ul>

                <div class="navbar-cta">
                    <a href="<?php echo $b; ?>/booking.php" class="btn btn-book" id="navBookBtn">
                        <i class="bi bi-calendar2-check me-1"></i>Book Your Stay
                    </a>
                </div>
            </div>
        </div>
    </nav>
</header>