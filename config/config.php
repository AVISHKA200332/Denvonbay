<?php
/**
 * Denvonbay - Database Configuration
 * ------------------------------------
 * This file handles the database connection only.
 *
 * HOW TO USE:
 *   require_once __DIR__ . '/../config/config.php';
 *
 * SECURITY:
 *   Add this file to .gitignore before pushing to GitHub.
 *   Never commit real passwords to version control.
 * ------------------------------------
 */

$dbHost     = "localhost";
$dbUser     = "root";
$dbPassword = "";
$dbName     = "denvonbay";

$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

if ($conn->connect_error) {
    // Do NOT show the real error to users in production.
    // Log it instead: error_log($conn->connect_error);
    die("Something went wrong. Please try again later.");
}

// Use UTF-8 for all database communication
$conn->set_charset("utf8mb4");