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

            <?php foreach ($faqs as $faq): ?>
                <article class="faq-card" data-reveal="up">
                    <h2 class="faq-question">
                        <i class="bi bi-question-circle-fill"></i>
                        <span><?= e($faq['q']) ?></span>
                    </h2>
                    <p class="faq-answer"><?= e($faq['a']) ?></p>
                </article>
            <?php endforeach; ?>

            <div class="faq-contact-card" data-reveal="up">
                <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 8px;">Still Have Questions?</h3>
                <p style="opacity: 0.85; margin-bottom: 24px; font-size: 0.95rem;">
                    We are happy to assist with your itinerary, special requests, or transport.
                </p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="contact.php" class="btn btn-cta-primary">Contact Us</a>
                    <a href="https://wa.me/94771234567" target="_blank" rel="noopener" class="btn btn-cta-whatsapp">
                        <i class="bi bi-whatsapp me-2"></i>WhatsApp Us
                    </a>
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

</body>
</html>
