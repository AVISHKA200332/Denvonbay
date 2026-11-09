<?php
/**
 * Denvonbay - Authentication Helper
 * ---------------------------------
 * Simple session-based admin authentication.
 */

if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    $tmpDir = sys_get_temp_dir();
    if ($tmpDir && is_dir($tmpDir) && is_writable($tmpDir)) {
        @session_save_path($tmpDir);
    }
    @session_start();
}

/**
 * ============================================================
 * HARDCODED ADMINISTRATOR CREDENTIALS
 * ============================================================
 * Modify these constants with your desired credentials.
 * They provide direct, resilient authentication across any server.
 */
defined('ADMIN_HARDCODED_EMAIL')    || define('ADMIN_HARDCODED_EMAIL', 'admin@denonbay.com');
defined('ADMIN_HARDCODED_PASSWORD') || define('ADMIN_HARDCODED_PASSWORD', 'denonbay123@');
defined('ADMIN_HARDCODED_USERNAME') || define('ADMIN_HARDCODED_USERNAME', 'Manager');

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
    $email = trim($email);

    // 1. Check Hardcoded Credentials
    if (defined('ADMIN_HARDCODED_EMAIL') && defined('ADMIN_HARDCODED_PASSWORD')) {
        if (strcasecmp($email, ADMIN_HARDCODED_EMAIL) === 0 && hash_equals((string)ADMIN_HARDCODED_PASSWORD, (string)$password)) {
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_regenerate_id(true);
            }
            $_SESSION['admin_id']       = 1;
            $_SESSION['admin_username'] = defined('ADMIN_HARDCODED_USERNAME') ? ADMIN_HARDCODED_USERNAME : 'Administrator';
            $_SESSION['admin_email']    = ADMIN_HARDCODED_EMAIL;
            return true;
        }
    }

    // 2. Fallback to Database authentication (if $pdo is connected)
    if ($pdo instanceof PDO) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
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
        } catch (\Throwable $e) {
            // Graceful fallback to false if database error
        }
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
