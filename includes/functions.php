<?php
/**
 * Denvonbay - Helper Functions
 * ----------------------------
 * Simple, beginner-friendly procedural helpers.
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Sanitize string input
 */
function sanitize($data) {
    return htmlspecialchars(trim((string)$data), ENT_QUOTES, 'UTF-8');
}

/**
 * Safe HTML escape shortcut
 */
function e($string) {
    return htmlspecialchars((string)$string, ENT_QUOTES, 'UTF-8');
}

/**
 * Format a price with currency symbol
 */
function format_price($amount) {
    return '$' . number_format((float)$amount, 0);
}

/**
 * Format a date nicely (e.g., Oct 15, 2026)
 */
function format_date($date) {
    if (!$date) return '';
    return date('M j, Y', strtotime($date));
}

/**
 * Set a flash notification message
 */
function set_flash($type, $message) {
    $_SESSION['flash'] = [
        'type'    => $type, // 'success', 'danger', 'info', 'warning'
        'message' => $message
    ];
}

/**
 * Retrieve and clear the flash message
 */
function get_flash() {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/**
 * Fetch all available rooms from database
 */
function get_rooms($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM rooms WHERE is_available = 1 ORDER BY id ASC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Fetch all active packages from database
 */
function get_packages($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM packages WHERE is_active = 1 ORDER BY id ASC");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}
