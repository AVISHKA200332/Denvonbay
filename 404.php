<?php
/**
 * Denvonbay - 404 Not Found
 * -------------------------
 * Error page when a requested URL cannot be found.
 */

http_response_code(404);

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Page Not Found | Denvonbay Hiriketiya';
$pageDescription = 'The page you are looking for cannot be found. Return to Denvonbay Hiriketiya.';
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
</head>
<body>

<?php include 'header.php'; ?>

<main id="main-content" style="padding: 120px 0; text-align: center; background-color: var(--off-white);">
    <div class="container" style="max-width: 600px;">
        <span class="section-eyebrow-dark">Error 404</span>
        <h1 class="section-heading-dark" style="font-size: 3.5rem; margin-bottom: 16px;">Lost at Sea?</h1>
        <p class="section-subtext-dark" style="margin-bottom: 32px; font-size: 1.1rem;">
            The page you are looking for might have moved, or the wave took it away.
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="index.php" class="btn btn-hero-primary">
                <i class="bi bi-house me-1"></i> Return Home
            </a>
            <a href="rooms.php" class="btn btn-hero-secondary">
                View Rooms
            </a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Common JS -->
<script src="assets/js/common.js"></script>

</body>
</html>
