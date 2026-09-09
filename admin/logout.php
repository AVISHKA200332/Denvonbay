<?php
/**
 * Denvonbay - Admin Logout
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

logout_admin();

// Start a fresh session to hold the logout confirmation notice
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
set_flash('success', 'You have been signed out successfully. Please log in with your credentials to access the admin dashboard.');
header('Location: login.php');
exit;
