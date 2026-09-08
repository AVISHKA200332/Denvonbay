<?php
/**
 * Denvonbay - Admin Logout
 */

require_once __DIR__ . '/../includes/auth.php';

logout_admin();
header('Location: login.php');
exit;
