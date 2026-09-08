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
    return !empty($_SESSION['admin_id']);
}

/**
 * Protect admin pages: redirects to login.php if not authenticated
 */
function require_admin() {
    if (!is_admin_logged_in()) {
        set_flash('danger', 'Access restricted. Please log in with your admin credentials to access the dashboard.');
        header('Location: login.php');
        exit;
    }
}

/**
 * Alias for require_admin
 */
function require_admin_login() {
    require_admin();
}

/**
 * Authenticate admin with email and password
 */
function login_admin($pdo, $email, $password) {
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ? LIMIT 1");
    $stmt->execute([trim($email)]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
        $_SESSION['admin_id']       = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_email']    = $user['email'];
        return true;
    }

    return false;
}

/**
 * Log out admin and completely destroy session
 */
function logout_admin() {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
}
