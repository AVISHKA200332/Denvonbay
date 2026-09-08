<?php
/**
 * Denvonbay - Contact Us
 * ----------------------
 * Contact details, location, and inquiry form.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Contact Us | Denvonbay Hiriketiya';
$pageDescription = 'Get in touch with Denvonbay. Located in Hiriketiya, Sri Lanka. Send an inquiry or reach us directly via WhatsApp or email.';

$flash = get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo/favicon.png">
    <link rel="apple-touch-icon" href="assets/images/logo/appicon.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/contact.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-chat-dots"></i> Get In Touch</span>
        <h1 class="page-hero-title">Contact Denvonbay</h1>
        <p class="page-hero-subtitle">We are here to help make your stay in Hiriketiya seamless and memorable.</p>
    </div>
</section>

<main id="main-content">

    <section class="contact-page-section">
        <div class="container">

            <?php if ($flash): ?>
                <div class="alert-flash alert-<?= e($flash['type']) ?> mb-4" data-reveal="up">
                    <i class="bi bi-info-circle-fill"></i>
                    <span><?= e($flash['message']) ?></span>
                </div>
            <?php endif; ?>

            <div class="row gy-5">

                <!-- Left Column: Contact Methods -->
                <div class="col-lg-5" data-reveal="left">
                    <div class="contact-info-card">
                        <h2 class="contact-info-title">Say Hello</h2>
                        <p class="contact-info-desc">
                            Feel free to reach out for availability inquiries, customized stay packages, surf guidance, or transport assistance.
                        </p>

                        <div class="contact-items-list">
                            <div class="contact-method-item">
                                <div class="contact-method-icon"><i class="bi bi-geo-alt-fill"></i></div>
                                <div>
                                    <div class="contact-method-label">Our Location</div>
                                    <p class="contact-method-val">Hiriketiya, Dickwella, Southern Province, Sri Lanka</p>
                                </div>
                            </div>

                            <div class="contact-method-item">
                                <div class="contact-method-icon"><i class="bi bi-whatsapp"></i></div>
                                <div>
                                    <div class="contact-method-label">WhatsApp Direct</div>
                                    <p class="contact-method-val">
                                        <a href="https://wa.me/94771234567" target="_blank" rel="noopener" class="text-white">
                                            +94 77 123 4567
                                        </a>
                                    </p>
                                </div>
                            </div>

                            <div class="contact-method-item">
                                <div class="contact-method-icon"><i class="bi bi-envelope-fill"></i></div>
                                <div>
                                    <div class="contact-method-label">Email Us</div>
                                    <p class="contact-method-val">
                                        <a href="mailto:hello@denvonbay.com" class="text-white">hello@denvonbay.com</a>
                                    </p>
                                </div>
                            </div>

                            <div class="contact-method-item">
                                <div class="contact-method-icon"><i class="bi bi-instagram"></i></div>
                                <div>
                                    <div class="contact-method-label">Follow Us</div>
                                    <p class="contact-method-val">
                                        <a href="https://instagram.com" target="_blank" rel="noopener" class="text-white">@denvonbay</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <a href="https://wa.me/94771234567" target="_blank" rel="noopener" class="btn btn-cta-whatsapp w-100 text-center">
                            <i class="bi bi-whatsapp me-2"></i> Chat on WhatsApp
                        </a>
                    </div>
                </div>

                <!-- Right Column: Contact Form -->
                <div class="col-lg-7" data-reveal="right">
                    <div class="contact-form-card">
                        <h2 class="section-heading-dark" style="font-size: 1.75rem; margin-bottom: 8px;">Send a Message</h2>
                        <p class="section-subtext-dark" style="margin: 0 0 28px 0; max-width: 100%;">
                            Fill out the form below and we will respond promptly within 24 hours.
                        </p>

                        <form id="contactForm" action="actions/submit-contact.php" method="POST">
                            <div class="row g-3">
                                <div class="col-md-6 form-group">
                                    <label for="contactName" class="form-label">Your Name *</label>
                                    <input type="text" id="contactName" name="name" class="form-control" required placeholder="e.g. Maya Lin">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="contactEmail" class="form-label">Email Address *</label>
                                    <input type="email" id="contactEmail" name="email" class="form-control" required placeholder="name@example.com">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contactSubject" class="form-label">Subject</label>
                                <input type="text" id="contactSubject" name="subject" class="form-control" placeholder="e.g. Room Inquiry / Transport Booking">
                            </div>

                            <div class="form-group">
                                <label for="contactMessage" class="form-label">Message *</label>
                                <textarea id="contactMessage" name="message" class="form-control" rows="5" required placeholder="How can we help make your stay special?"></textarea>
                            </div>

                            <button type="submit" class="btn btn-hero-primary" style="padding: 14px 32px;">
                                <i class="bi bi-send me-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Scripts -->
<script src="assets/js/common.js"></script>
<script src="assets/js/contact.js"></script>

</body>
</html>
