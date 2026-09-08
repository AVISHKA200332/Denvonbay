<?php
/**
 * Denvonbay - Submit Booking Action
 * ---------------------------------
 * Handles booking form POST submissions.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/validation.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../booking.php');
    exit;
}

// Retrieve and sanitize inputs
$roomId          = isset($_POST['room_id']) ? (int)$_POST['room_id'] : 0;
$guestName       = sanitize($_POST['guest_name'] ?? '');
$email           = sanitize($_POST['email'] ?? '');
$phone           = sanitize($_POST['phone'] ?? '');
$checkIn         = sanitize($_POST['check_in'] ?? '');
$checkOut        = sanitize($_POST['check_out'] ?? '');
$guests          = isset($_POST['guests']) ? (int)$_POST['guests'] : 1;
$specialRequests = sanitize($_POST['special_requests'] ?? '');

$errors = [];

// Validation checks
if (!validate_required($guestName)) {
    $errors[] = 'Please provide your full name.';
}

if (!validate_email($email)) {
    $errors[] = 'Please provide a valid email address.';
}

if (!validate_phone($phone)) {
    $errors[] = 'Please provide a valid phone number.';
}

if (!validate_date($checkIn) || !validate_date($checkOut)) {
    $errors[] = 'Please provide valid check-in and check-out dates.';
} elseif ($checkIn >= $checkOut) {
    $errors[] = 'Check-out date must be after check-in date.';
}

if ($guests < 1) {
    $guests = 1;
}

// Fetch room details to calculate pricing
$roomPrice = 50.00; // Fallback
if ($roomId > 0) {
    $stmt = $pdo->prepare("SELECT price_per_night, name FROM rooms WHERE id = ?");
    $stmt->execute([$roomId]);
    $room = $stmt->fetch();
    if ($room) {
        $roomPrice = (float)$room['price_per_night'];
    }
}

// If validation errors exist, store in session and redirect back
if (!empty($errors)) {
    set_flash('danger', implode(' ', $errors));
    header('Location: ../booking.php' . ($roomId ? "?room=$roomId" : ''));
    exit;
}

// Calculate total nights and price
$d1 = new DateTime($checkIn);
$d2 = new DateTime($checkOut);
$nights = $d1->diff($d2)->days;
if ($nights <= 0) $nights = 1;

$totalPrice = $nights * $roomPrice;

// Generate friendly booking reference (e.g., DVB-A1B2C3)
$bookingRef = 'DVB-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

try {
    $stmt = $pdo->prepare("
        INSERT INTO bookings (booking_ref, room_id, guest_name, email, phone, check_in, check_out, guests, total_price, special_requests, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')
    ");

    $stmt->execute([
        $bookingRef,
        $roomId > 0 ? $roomId : null,
        $guestName,
        $email,
        $phone,
        $checkIn,
        $checkOut,
        $guests,
        $totalPrice,
        $specialRequests
    ]);

    // Store in session for confirmation display
    $_SESSION['last_booking'] = [
        'ref'        => $bookingRef,
        'guest_name' => $guestName,
        'email'      => $email,
        'check_in'   => $checkIn,
        'check_out'  => $checkOut,
        'nights'     => $nights,
        'total'      => $totalPrice
    ];

    header('Location: ../booking-success.php?ref=' . urlencode($bookingRef));
    exit;

} catch (PDOException $e) {
    error_log('Booking insertion error: ' . $e->getMessage());
    set_flash('danger', 'Unable to process your booking at this time. Please contact us directly.');
    header('Location: ../booking.php');
    exit;
}
