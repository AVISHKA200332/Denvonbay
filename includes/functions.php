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

/**
 * Fetch all active gallery items from database
 */
function get_gallery_items($pdo, $activeOnly = true) {
    try {
        $sql = "SELECT * FROM gallery";
        if ($activeOnly) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY id DESC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Fetch approved guest reviews from database
 */
function get_approved_reviews($pdo, $limit = 6) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM reviews WHERE is_approved = 1 ORDER BY id DESC LIMIT ?");
        $stmt->bindValue(1, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        return [];
    }
}

/**
 * Retrieve all site settings as an associative key => value array
 */
function get_site_settings($pdo) {
    static $cachedSettings = null;
    if ($cachedSettings !== null) {
        return $cachedSettings;
    }

    $cachedSettings = [];
    try {
        $stmt = $pdo->query("SELECT setting_key, setting_value FROM site_settings");
        while ($row = $stmt->fetch()) {
            $cachedSettings[$row['setting_key']] = $row['setting_value'];
        }
    } catch (PDOException $e) {
        // Fallback gracefully
    }
    return $cachedSettings;
}

/**
 * Retrieve a specific setting with a fallback
 */
function get_setting($pdo, $key, $default = '') {
    $settings = get_site_settings($pdo);
    return $settings[$key] ?? $default;
}

/**
 * Generate or get CSRF token
 */
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Output CSRF hidden input field
 */
function csrf_field() {
    return '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') . '">';
}

/**
 * Verify CSRF token from POST
 */
function verify_csrf_token($token) {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check if a room has a confirmed booking that overlaps with the requested date range
 * Overlap condition: existing.check_in < requested.check_out AND existing.check_out > requested.check_in
 */
function check_booking_overlap($pdo, $roomId, $checkIn, $checkOut, $excludeBookingId = 0) {
    if (!$roomId) return null;
    try {
        $sql = "
            SELECT * FROM bookings
            WHERE room_id = ?
              AND status = 'confirmed'
              AND id != ?
              AND check_in < ?
              AND check_out > ?
            LIMIT 1
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([(int)$roomId, (int)$excludeBookingId, $checkOut, $checkIn]);
        return $stmt->fetch();
    } catch (PDOException $e) {
        return null;
    }
}

/**
 * Secure file upload helper
 */
function upload_image_file($file, $targetDir, $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'], $allowedExts = ['jpg', 'jpeg', 'png', 'webp'], $maxBytes = 5242880) {
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Invalid file upload parameters.');
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            return null; // No file uploaded
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('File size exceeded the maximum upload limit (5MB).');
        default:
            throw new RuntimeException('Unknown upload error occurred.');
    }

    if ($file['size'] > $maxBytes) {
        throw new RuntimeException('File size exceeds the 5MB limit.');
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts, true)) {
        throw new RuntimeException('Invalid file extension. Only JPG, PNG, and WEBP are permitted.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);
    if (!in_array($mimeType, $allowedTypes, true)) {
        throw new RuntimeException('Invalid image content MIME type.');
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $safeName = sprintf('%s_%s.%s', date('Ymd_His'), bin2hex(random_bytes(4)), $ext);
    $destPath = rtrim($targetDir, '/\\') . DIRECTORY_SEPARATOR . $safeName;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        throw new RuntimeException('Failed to save the uploaded image file.');
    }

    return $safeName;
}
