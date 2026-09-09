<?php
/**
 * Denvonbay - Submit Review Action
 * --------------------------------
 * Handles guest review submissions.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$guestName = sanitize($_POST['guest_name'] ?? '');
$location  = sanitize($_POST['location'] ?? 'Guest');
$rating    = isset($_POST['rating']) ? (int)$_POST['rating'] : 5;
$comment   = sanitize($_POST['comment'] ?? '');

if ($rating < 1 || $rating > 5) {
    $rating = 5;
}

if (!validate_required($guestName) || !validate_required($comment)) {
    set_flash('danger', 'Please provide your name and your review message.');
    header('Location: ../index.php#testimonials');
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO reviews (guest_name, location, rating, comment, is_approved)
        VALUES (?, ?, ?, ?, 1)
    ");
    $stmt->execute([$guestName, $location, $rating, $comment]);

    set_flash('success', 'Thank you for sharing your experience with us!');
    header('Location: ../index.php#testimonials');
    exit;

} catch (PDOException $e) {
    error_log('Review submission error: ' . $e->getMessage());
    set_flash('danger', 'Unable to submit review. Please try again later.');
    header('Location: ../index.php#testimonials');
    exit;
}
