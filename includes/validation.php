<?php
/**
 * Denvonbay - Validation Helpers
 * ------------------------------
 * Simple server-side validation functions.
 */

/**
 * Check if a field has a non-empty value
 */
function validate_required($value) {
    return !empty(trim((string)$value));
}

/**
 * Validate an email address format
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate a date string (YYYY-MM-DD)
 */
function validate_date($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Validate a phone number (digits, +, -, spaces allowed, minimum 7 characters)
 */
function validate_phone($phone) {
    $cleaned = preg_replace('/[^0-9+]/', '', (string)$phone);
    return strlen($cleaned) >= 7;
}
