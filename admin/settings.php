<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_admin_login();

// Current settings
$settings = get_site_settings($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf_token($_POST['csrf_token'] ?? '');

    $fields = [
        'hotel_name' => trim($_POST['hotel_name'] ?? 'Denvonbay Surf & Stay'),
        'hotel_tagline' => trim($_POST['hotel_tagline'] ?? ''),
        'contact_phone' => trim($_POST['contact_phone'] ?? ''),
        'contact_email' => trim($_POST['contact_email'] ?? ''),
        'whatsapp_number' => trim($_POST['whatsapp_number'] ?? ''),
        'hotel_address' => trim($_POST['hotel_address'] ?? ''),
        'instagram_url' => trim($_POST['instagram_url'] ?? ''),
        'facebook_url' => trim($_POST['facebook_url'] ?? ''),
        'checkin_time' => trim($_POST['checkin_time'] ?? '14:00'),
        'checkout_time' => trim($_POST['checkout_time'] ?? '11:00'),
    ];

    $stmt = $pdo->prepare("INSERT INTO site_settings (setting_key, setting_value, updated_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = NOW()");
    foreach ($fields as $key => $val) {
        $stmt->execute([$key, $val]);
    }

    set_flash('success', 'Site settings updated successfully.');
    redirect('settings.php');
}

$page_title = "Site Settings";
require_once __DIR__ . '/admin-header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h4 mb-1 fw-bold text-dark">Website & Hotel Settings</h2>
                <p class="text-muted small mb-0">Update contact details, social links, and hotel policies displayed across the website.</p>
            </div>
        </div>

        <form method="POST">
            <?= csrf_field() ?>

            <!-- General Info -->
            <div class="admin-card mb-4">
                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">General Information</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Hotel / Brand Name</label>
                        <input type="text" name="hotel_name" class="form-control" value="<?= htmlspecialchars($settings['hotel_name'] ?? 'Denvonbay Surf & Stay') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tagline</label>
                        <input type="text" name="hotel_tagline" class="form-control" value="<?= htmlspecialchars($settings['hotel_tagline'] ?? '') ?>" placeholder="e.g. Boutique Coastal Living & Surf Retreat">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Physical Location & Address</label>
                        <input type="text" name="hotel_address" class="form-control" value="<?= htmlspecialchars($settings['hotel_address'] ?? '') ?>" placeholder="e.g. 142 Beach Road, Weligama, Southern Province, Sri Lanka">
                    </div>
                </div>
            </div>

            <!-- Contact Channels -->
            <div class="admin-card mb-4">
                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">Direct Contact Channels</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Contact Phone</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                            <input type="text" name="contact_phone" class="form-control" value="<?= htmlspecialchars($settings['contact_phone'] ?? '') ?>" placeholder="+94 77 123 4567">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">WhatsApp Number</label>
                        <div class="input-group">
                            <span class="input-group-text text-success"><i class="bi bi-whatsapp"></i></span>
                            <input type="text" name="whatsapp_number" class="form-control" value="<?= htmlspecialchars($settings['whatsapp_number'] ?? '') ?>" placeholder="+94771234567">
                        </div>
                        <div class="form-text">Include country code without spaces for instant click-to-chat.</div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Contact Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" name="contact_email" class="form-control" value="<?= htmlspecialchars($settings['contact_email'] ?? '') ?>" placeholder="hello@denvonbay.com">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media & Policies -->
            <div class="admin-card mb-4">
                <h5 class="fw-bold mb-3 text-dark border-bottom pb-2">Social Links & Schedule</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Instagram URL</label>
                        <div class="input-group">
                            <span class="input-group-text text-danger"><i class="bi bi-instagram"></i></span>
                            <input type="url" name="instagram_url" class="form-control" value="<?= htmlspecialchars($settings['instagram_url'] ?? '') ?>" placeholder="https://instagram.com/denvonbay">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Facebook URL</label>
                        <div class="input-group">
                            <span class="input-group-text text-primary"><i class="bi bi-facebook"></i></span>
                            <input type="url" name="facebook_url" class="form-control" value="<?= htmlspecialchars($settings['facebook_url'] ?? '') ?>" placeholder="https://facebook.com/denvonbay">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Standard Check-In Time</label>
                        <input type="text" name="checkin_time" class="form-control" value="<?= htmlspecialchars($settings['checkin_time'] ?? '14:00') ?>" placeholder="14:00 (2:00 PM)">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Standard Check-Out Time</label>
                        <input type="text" name="checkout_time" class="form-control" value="<?= htmlspecialchars($settings['checkout_time'] ?? '11:00') ?>" placeholder="11:00 (11:00 AM)">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <button type="submit" class="btn btn-primary px-4 py-2">
                    <i class="bi bi-save me-1"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/admin-footer.php'; ?>
