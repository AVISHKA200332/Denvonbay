<?php
/**
 * Denvonbay - Header Include
 * Reusable HTML head section with meta tags, CSS links, and fonts
 */

// Load config if not already loaded
if (!defined('BASE_URL')) {
    require_once dirname(__DIR__) . '/config/config.php';
}

// Default page meta values
$page_title       = $page_title       ?? 'Denvonbay | Hiriketiya Coastal Accommodation';
$page_description = $page_description ?? 'Affordable, comfortable stays near Hiriketiya Beach, Sri Lanka. Perfect for couples, solo travelers, friends and families exploring the south coast.';
$page_keywords    = $page_keywords    ?? 'Denvonbay, Hiriketiya, Sri Lanka accommodation, beach stay, surf retreat, coastal holiday, Dickwella';
$canonical_url    = $canonical_url    ?? BASE_URL . '/';
$body_class       = $body_class       ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- SEO Meta Tags -->
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta name="keywords"    content="<?php echo htmlspecialchars($page_keywords); ?>">
    <meta name="author"      content="Denvonbay">
    <meta name="robots"      content="index, follow">

    <!-- Open Graph -->
    <meta property="og:type"        content="website">
    <meta property="og:title"       content="<?php echo htmlspecialchars($page_title); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($page_description); ?>">
    <meta property="og:url"         content="<?php echo htmlspecialchars($canonical_url); ?>">
    <meta property="og:site_name"   content="Denvonbay">

    <!-- Canonical -->
    <link rel="canonical" href="<?php echo htmlspecialchars($canonical_url); ?>">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Main Stylesheet (uses dynamic BASE_URL so path is always correct) -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/style.css">

    <?php if (isset($extra_css)) echo $extra_css; ?>
</head>
<body class="<?php echo htmlspecialchars($body_class); ?>">