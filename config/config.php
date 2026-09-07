<?php
/**
 * Denvonbay - Application Configuration
 * Automatically detects the base URL for correct asset path resolution
 */

// Detect base URL dynamically so the site works on localhost/Denvonbay/ AND on a live domain
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host     = $_SERVER['HTTP_HOST'] ?? 'localhost';
$script   = $_SERVER['SCRIPT_NAME'] ?? '/index.php';

// Get the directory the script lives in (e.g. /Denvonbay)
$base_dir = rtrim(dirname($script), '/\\');

// BASE_URL: everything before the first PHP file path segment
// e.g. http://localhost/Denvonbay
define('BASE_URL', $protocol . '://' . $host . $base_dir);

// ASSETS_URL: shortcut for asset paths
define('ASSETS_URL', BASE_URL . '/assets');

// APP_NAME
define('APP_NAME', 'Denvonbay');

// APP_ROOT: absolute filesystem path to project root
define('APP_ROOT', dirname(__DIR__));