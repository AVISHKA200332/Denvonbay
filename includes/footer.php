<?php
/**
 * Denvonbay - Footer Include
 * --------------------------------------------------
 * Outputs the footer HTML.
 * Also loads Bootstrap JS and main.js at page bottom.
 * Uses $base defined in header.php.
 * --------------------------------------------------
 */

// Safety fallback
if (!isset($base)) {
    $base = '/Denvonbay';
}
?>
<footer class="site-footer" role="contentinfo">
    <div class="footer-main">
        <div class="container">
            <div class="row gy-5">

                <!-- Brand + Tagline + Social Links -->
                <div class="col-lg-4 col-md-6">
                    <a href="<?= $base ?>/" class="footer-brand">
                        <span class="footer-brand-icon"><i class="bi bi-water"></i></span>
                        <span class="footer-brand-text">Denvon<span class="footer-brand-accent">bay</span></span>
                    </a>
                    <p class="footer-tagline">
                        Affordable stays. Tropical mornings.<br>Hiriketiya at your doorstep.
                    </p>
                    <div class="footer-socials">
                        <a href="#" class="footer-social-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="footer-social-link" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="footer-social-link" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="footer-social-link" aria-label="TripAdvisor"><i class="bi bi-star-fill"></i></a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h3 class="footer-heading">Navigate</h3>
                    <ul class="footer-nav-list">
                        <li><a href="<?= $base ?>/"              class="footer-nav-link">Home</a></li>
                        <li><a href="<?= $base ?>/about.php"     class="footer-nav-link">About</a></li>
                        <li><a href="<?= $base ?>/rooms.php"     class="footer-nav-link">Rooms</a></li>
                        <li><a href="<?= $base ?>/packages.php"  class="footer-nav-link">Packages</a></li>
                        <li><a href="<?= $base ?>/explore.php"   class="footer-nav-link">Explore</a></li>
                        <li><a href="<?= $base ?>/amenities.php" class="footer-nav-link">Amenities</a></li>
                        <li><a href="<?= $base ?>/faq.php"       class="footer-nav-link">FAQ</a></li>
                        <li><a href="<?= $base ?>/contact.php"   class="footer-nav-link">Contact</a></li>
                    </ul>
                </div>

                <!-- Room Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h3 class="footer-heading">Rooms</h3>
                    <ul class="footer-nav-list">
                        <li><a href="<?= $base ?>/rooms.php#cozy"    class="footer-nav-link">The Cozy Room</a></li>
                        <li><a href="<?= $base ?>/rooms.php#couples" class="footer-nav-link">The Couple's Retreat</a></li>
                        <li><a href="<?= $base ?>/rooms.php#friends" class="footer-nav-link">The Friends' Stay</a></li>
                        <li><a href="<?= $base ?>/rooms.php#family"  class="footer-nav-link">Family Room</a></li>
                        <li><a href="<?= $base ?>/rooms.php#suite"   class="footer-nav-link">Garden Suite</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6">
                    <h3 class="footer-heading">Get in Touch</h3>
                    <ul class="footer-contact-list">
                        <li class="footer-contact-item">
                            <i class="bi bi-geo-alt-fill footer-contact-icon"></i>
                            <span>Hiriketiya, Dickwella, Sri Lanka</span>
                        </li>
                        <li class="footer-contact-item">
                            <i class="bi bi-whatsapp footer-contact-icon"></i>
                            <a href="https://wa.me/94xxxxxxxxxx" class="footer-contact-link">+94 xx xxx xxxx</a>
                        </li>
                        <li class="footer-contact-item">
                            <i class="bi bi-envelope-fill footer-contact-icon"></i>
                            <a href="mailto:hello@denvonbay.com" class="footer-contact-link">hello@denvonbay.com</a>
                        </li>
                        <li class="footer-contact-item">
                            <i class="bi bi-instagram footer-contact-icon"></i>
                            <a href="#" class="footer-contact-link">@denvonbay</a>
                        </li>
                    </ul>
                    <a href="<?= $base ?>/booking.php" class="btn btn-book-footer mt-3">
                        <i class="bi bi-calendar2-check me-2"></i>Book Your Stay
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer Bottom Bar -->
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">&copy; 2026 <strong>Denvonbay</strong>. All rights reserved.</p>
                <p class="footer-sub-text">Designed for slow days by the coast.</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5 JS (required for mobile navbar, dropdowns) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Main JavaScript -->
<script src="<?= $base ?>/assets/js/main.js"></script>

</body>
</html>