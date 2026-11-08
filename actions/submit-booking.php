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

    // Send email notification to hello@denonbay.com
    $toEmail = get_setting($pdo, 'contact_email', 'hello@denonbay.com');
    if (empty($toEmail) || $toEmail === 'hello@denvonbay.com') {
        $toEmail = 'hello@denonbay.com';
    }

    $roomName = !empty($room['name']) ? $room['name'] : 'Coastal Stay';
    $bookingSubject = "New Booking Request [" . $bookingRef . "] - " . $guestName;
    $bookingBody = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 24px; color: #1e293b; }
            .card { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
            .header { background: #0B2A5B; padding: 24px 28px; color: #ffffff; }
            .badge { display: inline-block; background: #42CFE8; color: #0B2A5B; font-weight: 800; font-size: 11px; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; margin-bottom: 6px; }
            .header h1 { margin: 0; font-size: 20px; font-weight: 700; color: #ffffff; }
            .body { padding: 28px; }
            .grid { display: table; width: 100%; margin-bottom: 16px; }
            .col { display: table-cell; width: 50%; vertical-align: top; padding-bottom: 12px; }
            .label { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; letter-spacing: 0.05em; margin-bottom: 4px; }
            .value { font-size: 14px; font-weight: 600; color: #0f172a; }
            .total-box { background: #EFF6FF; border: 1px solid #BFDBFE; padding: 14px 18px; border-radius: 8px; margin-top: 14px; margin-bottom: 14px; }
            .total-label { font-size: 12px; color: #1E40AF; font-weight: 600; }
            .total-val { font-size: 20px; color: #1266F1; font-weight: 800; }
            .footer { background: #f8fafc; padding: 16px 28px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="header">
                <span class="badge">New Reservation</span>
                <h1>' . htmlspecialchars($bookingRef, ENT_QUOTES, 'UTF-8') . '</h1>
                <p style="margin:4px 0 0; opacity:0.85; font-size:12px; color:#ffffff;">Submitted via Denvonbay booking system</p>
            </div>
            <div class="body">
                <div class="grid">
                    <div class="col">
                        <div class="label">Guest Name</div>
                        <div class="value">' . htmlspecialchars($guestName, ENT_QUOTES, 'UTF-8') . '</div>
                    </div>
                    <div class="col">
                        <div class="label">Phone / WhatsApp</div>
                        <div class="value">' . htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') . '</div>
                    </div>
                </div>
                <div class="grid">
                    <div class="col">
                        <div class="label">Email Address</div>
                        <div class="value"><a href="mailto:' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '</a></div>
                    </div>
                    <div class="col">
                        <div class="label">Room</div>
                        <div class="value">' . htmlspecialchars($roomName, ENT_QUOTES, 'UTF-8') . '</div>
                    </div>
                </div>
                <div class="grid">
                    <div class="col">
                        <div class="label">Check-In</div>
                        <div class="value">' . htmlspecialchars($checkIn, ENT_QUOTES, 'UTF-8') . '</div>
                    </div>
                    <div class="col">
                        <div class="label">Check-Out</div>
                        <div class="value">' . htmlspecialchars($checkOut, ENT_QUOTES, 'UTF-8') . ' (' . (int)$nights . ' night' . ($nights > 1 ? 's' : '') . ')</div>
                    </div>
                </div>
                <div class="grid">
                    <div class="col">
                        <div class="label">Guests</div>
                        <div class="value">' . (int)$guests . ' Guest(s)</div>
                    </div>
                </div>
                <div class="total-box">
                    <div class="total-label">Estimated Total</div>
                    <div class="total-val">$' . number_format($totalPrice, 2) . '</div>
                </div>
                ' . (!empty($specialRequests) ? '
                <div>
                    <div class="label">Special Requests</div>
                    <div style="background:#f8fafc; padding:10px 14px; border-radius:6px; font-size:13px; color:#334155;">' . nl2br(htmlspecialchars($specialRequests, ENT_QUOTES, 'UTF-8')) . '</div>
                </div>' : '') . '
            </div>
            <div class="footer">
                Review this booking in the Denvonbay Admin Panel or reply directly to ' . htmlspecialchars($guestName, ENT_QUOTES, 'UTF-8') . '.
            </div>
        </div>
    </body>
    </html>';

    send_system_email($toEmail, $bookingSubject, $bookingBody, $email, $guestName);

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
