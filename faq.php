<?php
/**
 * Denvonbay - Frequently Asked Questions
 * --------------------------------------
 * Helpful answers for travelers planning their stay.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'FAQ | Denvonbay Hiriketiya Accommodation';
$pageDescription = 'Find answers to common questions about staying at Denvonbay, check-in, surf spots, Wi-Fi, and transport in Hiriketiya, Sri Lanka.';

$faqs = [
    [
        'q' => 'How close is Denvonbay to Hiriketiya Beach?',
        'a' => 'We are located approximately 5 minutes on foot from Hiriketiya Bay (around 450 meters). You can comfortably walk down with your surfboard under your arm without needing a vehicle or tuk-tuk.'
    ],
    [
        'q' => 'What are the check-in and check-out times?',
        'a' => 'Standard check-in is from 2:00 PM onwards, and check-out is by 11:00 AM. If you arrive early or need a late departure, we have secure luggage storage and an outdoor shower so you can make the most of your beach day.'
    ],
    [
        'q' => 'Is breakfast included in the room rate?',
        'a' => 'Breakfast is included with selected room packages (like The Couple’s Retreat and our multi-night packages) and is available à la carte for all other rooms every morning between 7:30 AM and 10:30 AM.'
    ],
    [
        'q' => 'Is the Wi-Fi fast enough for remote work?',
        'a' => 'Yes! We have high-speed fiber internet coverage across all bedrooms and our garden lounge area, tested regularly for Zoom calls, upload/downloads, and remote work.'
    ],
    [
        'q' => 'Can you arrange airport transfers from Colombo (CMB)?',
        'a' => 'Absolutely. We partner with reliable, air-conditioned private taxi drivers who can pick you up directly from Bandaranaike International Airport (CMB) or Mattala Rajapaksa Airport (HRI). Journey time via the Southern Expressway is around 2.5 to 3 hours.'
    ],
    [
        'q' => 'Can you help arrange surfboard rentals or surf lessons?',
        'a' => 'Yes, our team can connect you with accredited, friendly local surf instructors in the bay, arrange surfboard hire suited to your skill level, and recommend the best tides each day.'
    ],
    [
        'q' => 'What is your cancellation policy?',
        'a' => 'We understand travel plans can shift. Cancellations made up to 7 days before your arrival date receive a full refund or free rescheduling. For last-minute changes, please contact us directly.'
    ]
];
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
    <link rel="stylesheet" href="assets/css/faq.css">
</head>
<body>

<?php include 'header.php'; ?>

<!-- Page Hero -->
<section class="page-hero">
    <div class="container">
        <span class="page-hero-badge"><i class="bi bi-question-circle"></i> Answers</span>
        <h1 class="page-hero-title">Frequently Asked Questions</h1>
        <p class="page-hero-subtitle">Everything you need to know about preparing for your stay at Denvonbay.</p>
    </div>
</section>

<main id="main-content">

    <section class="faq-page-section">
        <div class="container" style="max-width: 860px;">

            <?php foreach ($faqs as $faqIdx => $faq): ?>
                <article class="faq-card" data-reveal="up" data-reveal-delay="<?= $faqIdx * 60 ?>">
                    <button class="faq-question" type="button"
                            aria-expanded="false"
                            aria-controls="faq-answer-<?= $faqIdx ?>">
                        <span><?= e($faq['q']) ?></span>
                        <span class="faq-question-icon-wrap" aria-hidden="true">
                            <i class="bi bi-plus-lg"></i>
                        </span>
                    </button>
                    <div class="faq-answer-wrap" id="faq-answer-<?= $faqIdx ?>" role="region">
                        <p class="faq-answer"><?= e($faq['a']) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>

            <div class="faq-contact-card" data-reveal="up">
                <div style="position: relative; z-index: 1;">
                    <p style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.16em; text-transform: uppercase; color: var(--aqua); margin-bottom: 14px;">Still Have Questions?</p>
                    <h3 style="font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 800; color: var(--white); margin-bottom: 14px; letter-spacing: -0.03em;">We Are Here to Help.</h3>
                    <p style="color: rgba(255,255,255,0.72); margin-bottom: 32px; font-size: 1rem; max-width: 480px; margin-left: auto; margin-right: auto; line-height: 1.75;">
                        We are happy to assist with your itinerary, special requests, or transport.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="contact.php" class="btn btn-cta-primary" id="faqContactBtn">Contact Us</a>
                        <a href="https://wa.me/94771234567" target="_blank" rel="noopener" class="btn btn-cta-whatsapp" id="faqWhatsappBtn">
                            <i class="bi bi-whatsapp me-2" aria-hidden="true"></i>WhatsApp Us
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Common JS -->
<script src="assets/js/common.js"></script>

<!-- FAQ Accordion -->
<script>
(function () {
  'use strict';
  var faqCards = document.querySelectorAll('.faq-card');
  faqCards.forEach(function (card) {
    var btn    = card.querySelector('.faq-question');
    var wrap   = card.querySelector('.faq-answer-wrap');
    if (!btn || !wrap) return;

    btn.addEventListener('click', function () {
      var isOpen = card.classList.contains('is-open');
      // Close all
      faqCards.forEach(function (c) {
        c.classList.remove('is-open');
        var b = c.querySelector('.faq-question');
        if (b) b.setAttribute('aria-expanded', 'false');
      });
      // Open clicked (if it was closed)
      if (!isOpen) {
        card.classList.add('is-open');
        btn.setAttribute('aria-expanded', 'true');
      }
    });
  });
})();
</script>

</body>
</html>
