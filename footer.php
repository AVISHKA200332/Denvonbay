<?php
// Dynamic footer settings if functions & pdo are loaded
$f_phone = isset($pdo) ? get_setting($pdo, 'contact_phone', '+94 77 123 4567') : '+94 77 123 4567';
$f_wa = isset($pdo) ? get_setting($pdo, 'whatsapp_number', '94771234567') : '94771234567';
$f_email = isset($pdo) ? get_setting($pdo, 'contact_email', 'hello@denvonbay.com') : 'hello@denvonbay.com';
$f_address = isset($pdo) ? get_setting($pdo, 'hotel_address', 'Hiriketiya, Dickwella, Sri Lanka') : 'Hiriketiya, Dickwella, Sri Lanka';
$f_insta = isset($pdo) ? get_setting($pdo, 'instagram_url', 'https://instagram.com') : 'https://instagram.com';
$f_fb = isset($pdo) ? get_setting($pdo, 'facebook_url', 'https://facebook.com') : 'https://facebook.com';
$f_wa_digits = preg_replace('/[^0-9]/', '', $f_wa);
?>
<!-- ===== SITE FOOTER ===== -->
<footer class="site-footer" role="contentinfo">
    <div class="footer-main">
        <div class="container">
            <div class="row gy-5">

                <!-- Brand + Tagline + Social Links -->
                <div class="col-lg-4 col-md-6">
                    <a href="index.php" class="footer-brand" aria-label="Denvonbay Home">
                        <img src="assets/images/logo/horizontal.png" alt="Denvonbay" class="footer-brand-img">
                    </a>
                    <p class="footer-tagline">
                        Affordable stays. Tropical mornings.<br>Hiriketiya at your doorstep.
                    </p>
                    <div class="footer-socials">
                        <a href="<?= htmlspecialchars($f_insta) ?>" target="_blank" rel="noopener" class="footer-social-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="<?= htmlspecialchars($f_fb) ?>" target="_blank" rel="noopener" class="footer-social-link" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="https://wa.me/<?= $f_wa_digits ?>" target="_blank" rel="noopener" class="footer-social-link" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="footer-social-link" aria-label="TripAdvisor"><i class="bi bi-star-fill"></i></a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h3 class="footer-heading">Navigate</h3>
                    <ul class="footer-nav-list">
                        <li><a href="index.php" class="footer-nav-link">Home</a></li>
                        <li><a href="about.php" class="footer-nav-link">About</a></li>
                        <li><a href="rooms.php" class="footer-nav-link">Rooms</a></li>
                        <li><a href="packages.php" class="footer-nav-link">Packages</a></li>
                        <li><a href="explore.php" class="footer-nav-link">Explore</a></li>
                        <li><a href="amenities.php" class="footer-nav-link">Amenities</a></li>
                        <li><a href="gallery.php" class="footer-nav-link">Gallery</a></li>
                        <li><a href="faq.php" class="footer-nav-link">FAQ</a></li>
                        <li><a href="contact.php" class="footer-nav-link">Contact</a></li>
                    </ul>
                </div>

                <!-- Room Links -->
                <div class="col-lg-2 col-md-6 col-6">
                    <h3 class="footer-heading">Rooms</h3>
                    <ul class="footer-nav-list">
                        <li><a href="rooms.php#cozy" class="footer-nav-link">The Cozy Room</a></li>
                        <li><a href="rooms.php#couples" class="footer-nav-link">The Couple's Retreat</a></li>
                        <li><a href="rooms.php#friends" class="footer-nav-link">The Friends' Stay</a></li>
                        <li><a href="rooms.php#family" class="footer-nav-link">Family Room</a></li>
                        <li><a href="rooms.php#suite" class="footer-nav-link">Garden Suite</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6">
                    <h3 class="footer-heading">Get in Touch</h3>
                    <ul class="footer-contact-list">
                        <li class="footer-contact-item">
                            <i class="bi bi-geo-alt-fill footer-contact-icon"></i>
                            <span><?= htmlspecialchars($f_address) ?></span>
                        </li>
                        <li class="footer-contact-item">
                            <i class="bi bi-whatsapp footer-contact-icon"></i>
                            <a href="https://wa.me/<?= $f_wa_digits ?>" class="footer-contact-link"><?= htmlspecialchars($f_phone) ?></a>
                        </li>
                        <li class="footer-contact-item">
                            <i class="bi bi-envelope-fill footer-contact-icon"></i>
                            <a href="mailto:<?= htmlspecialchars($f_email) ?>" class="footer-contact-link"><?= htmlspecialchars($f_email) ?></a>
                        </li>
                        <li class="footer-contact-item">
                            <i class="bi bi-instagram footer-contact-icon"></i>
                            <a href="<?= htmlspecialchars($f_insta) ?>" target="_blank" rel="noopener" class="footer-contact-link">Instagram</a>
                        </li>
                    </ul>
                    <a href="booking.php" class="btn btn-book-footer mt-3">
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
                <p class="footer-copyright">&copy; <?= date('Y') ?> <strong>Denvonbay</strong>. All rights reserved.</p>
                <p class="footer-sub-text">Designed for slow days by the coast.</p>
            </div>
        </div>
    </div>
</footer>
