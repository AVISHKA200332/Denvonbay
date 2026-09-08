<?php
/**
 * Denvonbay - Authentication Helper
 * ---------------------------------
 * Simple session-based admin authentication.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Check if the admin is logged in
 */
function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}

/**
 * Protect admin pages: redirects to login.php if not authenticated
 */
function require_admin() {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Authenticate admin with email and password
 */
function login_admin($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ? LIMIT 1");
    $stmt->execute([trim($email)]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_id']       = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_email']    = $user['email'];
        return true;
    }

    return false;
}

/**
 * Log out admin
 */
function logout_admin() {
    unset($_SESSION['admin_id']);
    unset($_SESSION['admin_username']);
    unset($_SESSION['admin_email']);
    session_destroy();
}
