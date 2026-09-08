<?php
/**
 * Denvonbay - Admin Router / Entrypoint
 */

require_once __DIR__ . '/../includes/auth.php';

if (is_admin_logged_in()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}
exit;
