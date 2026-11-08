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

    // Send email notification to hello@denonbay.com
    $toEmail = get_setting($pdo, 'contact_email', 'hello@denonbay.com');
    if (empty($toEmail) || $toEmail === 'hello@denvonbay.com') {
        $toEmail = 'hello@denonbay.com';
    }

    $mailSubject = "New Website Message from " . $name . ": " . $subject;
    $mailBody = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif; background: #f4f6f9; margin: 0; padding: 24px; color: #1e293b; }
            .card { max-width: 580px; margin: 0 auto; background: #ffffff; border-radius: 14px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.06); border: 1px solid #e2e8f0; }
            .header { background: #0B2A5B; padding: 24px 28px; color: #ffffff; }
            .header h1 { margin: 0; font-size: 18px; font-weight: 700; color: #ffffff; }
            .header p { margin: 4px 0 0; font-size: 12px; opacity: 0.8; color: #42CFE8; }
            .body { padding: 28px; }
            .meta-row { margin-bottom: 14px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9; }
            .label { font-size: 11px; text-transform: uppercase; font-weight: 700; color: #64748b; letter-spacing: 0.05em; margin-bottom: 4px; }
            .value { font-size: 14px; font-weight: 600; color: #0f172a; }
            .message-box { background: #f8fafc; border-left: 4px solid #1266F1; padding: 16px 18px; border-radius: 6px; font-size: 14px; line-height: 1.6; color: #334155; margin-top: 14px; }
            .footer { background: #f8fafc; padding: 16px 28px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
        </style>
    </head>
    <body>
        <div class="card">
            <div class="header">
                <h1>New Contact Form Message</h1>
                <p>Received via Denvonbay Website</p>
            </div>
            <div class="body">
                <div class="meta-row">
                    <div class="label">Sender Name</div>
                    <div class="value">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</div>
                </div>
                <div class="meta-row">
                    <div class="label">Sender Email</div>
                    <div class="value"><a href="mailto:' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . '</a></div>
                </div>
                <div class="meta-row">
                    <div class="label">Subject</div>
                    <div class="value">' . htmlspecialchars($subject, ENT_QUOTES, 'UTF-8') . '</div>
                </div>
                <div class="meta-row" style="border-bottom:none; margin-bottom:0;">
                    <div class="label">Message</div>
                    <div class="message-box">' . nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8')) . '</div>
                </div>
            </div>
            <div class="footer">
                You can reply directly to this email to respond to ' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '.
            </div>
        </div>
    </body>
    </html>';

    send_system_email($toEmail, $mailSubject, $mailBody, $email, $name);

    set_flash('success', 'Thank you! Your message has been received. We will get back to you shortly.');
    header('Location: ../contact.php?status=success');
    exit;

} catch (PDOException $e) {
    error_log('Contact message error: ' . $e->getMessage());
    set_flash('danger', 'Unable to send your message right now. Please message us via WhatsApp.');
    header('Location: ../contact.php');
    exit;
}
