<?php
/**
 * Denvonbay - Submit Contact Action
 * ---------------------------------
 * Handles contact message POST submissions.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../contact.php');
    exit;
}

$name    = sanitize($_POST['name'] ?? '');
$email   = sanitize($_POST['email'] ?? '');
$subject = sanitize($_POST['subject'] ?? 'Website Inquiry');
$message = sanitize($_POST['message'] ?? '');

$errors = [];

if (!validate_required($name)) {
    $errors[] = 'Please provide your name.';
}

if (!validate_email($email)) {
    $errors[] = 'Please provide a valid email address.';
}

if (!validate_required($message)) {
    $errors[] = 'Please enter your message.';
}

if (!empty($errors)) {
    set_flash('danger', implode(' ', $errors));
    header('Location: ../contact.php');
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO contact_messages (name, email, subject, message, is_read)
        VALUES (?, ?, ?, ?, 0)
    ");
    $stmt->execute([$name, $email, $subject, $message]);

    set_flash('success', 'Thank you! Your message has been received. We will get back to you shortly.');
    header('Location: ../contact.php?status=success');
    exit;

} catch (PDOException $e) {
    error_log('Contact message error: ' . $e->getMessage());
    set_flash('danger', 'Unable to send your message right now. Please message us via WhatsApp.');
    header('Location: ../contact.php');
    exit;
}
