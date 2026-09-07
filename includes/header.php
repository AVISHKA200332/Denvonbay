<?php
/**
 * Denvonbay - Header Include
 * --------------------------------------------------
 * Included at the top of every page.
 * Outputs the full <head> section.
 *
 * $base = the subfolder the site lives in.
 *   Localhost:   /Denvonbay
 *   Live domain: (empty string)
 *
 * Change ONLY $base below when you go live.
 * --------------------------------------------------
 */

// Base path for all internal links and asset URLs
$base = '/Denvonbay'; // <- Change to '' when deploying to a live domain

// Page meta defaults - override these BEFORE including this file
$pageTitle       = $pageTitle       ?? $page_title       ?? 'Denvonbay | Hiriketiya Coastal Accommodation';
$pageDescription = $pageDescription ?? $page_description ?? 'Affordable, comfortable stays near Hiriketiya Beach, Sri Lanka.';
$pageKeywords    = $pageKeywords    ?? $page_keywords    ?? 'Denvonbay, Hiriketiya, Sri Lanka accommodation, beach stay, surf retreat';
$bodyClass       = $bodyClass       ?? $body_class       ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title><?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
    <meta name="keywords"    content="<?= htmlspecialchars($pageKeywords) ?>">
    <meta name="author"      content="Denvonbay">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- =====================================================
         Project CSS Files
         style.css      - Global: variables, reset, buttons
         components.css - Navbar, footer, shared styles
         home.css       - Home page sections (hero, rooms etc.)
         responsive.css - All media queries
    ===================================================== -->
    <link rel="stylesheet" href="<?= $base ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/components.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/home.css">
    <link rel="stylesheet" href="<?= $base ?>/assets/css/responsive.css">

</head>
<body class="<?= htmlspecialchars($bodyClass) ?>">