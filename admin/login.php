<?php
/**
 * Denvonbay - Premium Admin Login
 * --------------------------------
 * Secure session authentication with modern luxury hospitality aesthetic.
 */

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = 'Please enter both your administrator email and password.';
    } else {
        if (login_admin($pdo, $email, $password)) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid credentials. Please verify your email and password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Authentication | Denvonbay Surf & Stay</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../assets/images/logo/favicon.png">

    <style>
        :root {
            --brand-primary: #1266F1;
            --brand-primary-hover: #0d52c7;
            --brand-navy: #0B2A5B;
            --brand-dark: #071936;
            --brand-aqua: #42CFE8;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
            --font-main: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body.login-page {
            font-family: var(--font-main);
            min-height: 100vh;
            background: linear-gradient(135deg, #051429 0%, #0A2246 50%, #041021 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            color: var(--text-dark);
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glow Backdrop */
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.25;
            pointer-events: none;
            z-index: 0;
        }
        .glow-1 {
            background: #1266F1;
            top: -100px;
            left: -100px;
        }
        .glow-2 {
            background: #42CFE8;
            bottom: -150px;
            right: -100px;
        }

        /* Main Split Container */
        .login-card-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1040px;
            background: #FFFFFF;
            border-radius: 24px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            display: flex;
            min-height: 640px;
        }

        /* Left Showcase Column */
        .login-showcase-pane {
            flex: 1.1;
            position: relative;
            background-color: var(--brand-dark);
            background-image: url('../assets/images/explore/Lady_surfing_on_Sri_Lankan_202607061450.jpg');
            background-size: cover;
            background-position: center center;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #FFFFFF;
        }

        .login-showcase-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg, rgba(7, 25, 54, 0.94) 0%, rgba(11, 42, 91, 0.88) 50%, rgba(18, 102, 241, 0.75) 100%);
            backdrop-filter: blur(2px);
            z-index: 1;
        }

        .showcase-content {
            position: relative;
            z-index: 2;
        }

        .showcase-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--brand-aqua);
            margin-bottom: 24px;
            backdrop-filter: blur(8px);
        }

        .showcase-brand-title {
            font-size: 2.1rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.2;
            margin-bottom: 12px;
        }
        .showcase-brand-title span {
            color: var(--brand-aqua);
        }

        .showcase-brand-desc {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 32px;
            max-width: 400px;
        }

        .showcase-feature-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .showcase-feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
        }

        .showcase-feature-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(66, 207, 232, 0.15);
            border: 1px solid rgba(66, 207, 232, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--brand-aqua);
            font-size: 0.95rem;
            flex-shrink: 0;
        }

        .showcase-footer {
            position: relative;
            z-index: 2;
            padding-top: 32px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        /* Right Form Column */
        .login-form-pane {
            flex: 1;
            padding: 56px 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #FFFFFF;
        }

        .login-header {
            margin-bottom: 32px;
        }

        .login-logo-mobile {
            display: none;
            margin-bottom: 20px;
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--brand-dark);
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        /* Form Inputs */
        .custom-form-group {
            margin-bottom: 20px;
        }

        .custom-form-label {
            display: block;
            font-size: 0.825rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: #94A3B8;
            font-size: 1.1rem;
            pointer-events: none;
            transition: color 0.2s ease;
        }

        .custom-input {
            width: 100%;
            height: 52px;
            padding: 12px 16px 12px 46px;
            font-size: 0.95rem;
            font-family: inherit;
            color: var(--text-dark);
            background: #F8FAFC;
            border: 1.5px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.2s ease;
            outline: none;
        }

        .custom-input:focus {
            background: #FFFFFF;
            border-color: var(--brand-primary);
            box-shadow: 0 0 0 4px rgba(18, 102, 241, 0.12);
        }

        .custom-input:focus + .input-icon,
        .input-wrapper:focus-within .input-icon {
            color: var(--brand-primary);
        }

        /* Password Toggle */
        .password-toggle-btn {
            position: absolute;
            right: 14px;
            background: none;
            border: none;
            color: #94A3B8;
            cursor: pointer;
            padding: 6px;
            font-size: 1.1rem;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s;
        }

        .password-toggle-btn:hover {
            color: var(--brand-primary);
        }

        /* Demo Chip Button */
        .demo-chip-bar {
            margin-bottom: 24px;
            padding: 10px 14px;
            background: #F0F7FF;
            border: 1px dashed #BFDBFE;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.8rem;
        }
        .demo-chip-text {
            color: var(--brand-navy);
            font-weight: 500;
        }
        .demo-chip-btn {
            background: #FFFFFF;
            border: 1px solid #BFDBFE;
            color: var(--brand-primary);
            font-weight: 700;
            font-size: 0.75rem;
            padding: 4px 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .demo-chip-btn:hover {
            background: var(--brand-primary);
            color: #FFFFFF;
            border-color: var(--brand-primary);
        }

        /* Submit Button */
        .btn-submit-login {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, var(--brand-primary) 0%, #0C4CB9 100%);
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.3px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(18, 102, 241, 0.35);
            transition: all 0.25s ease;
        }

        .btn-submit-login:hover {
            background: linear-gradient(135deg, #0d55cd 0%, #093c93 100%);
            box-shadow: 0 6px 20px rgba(18, 102, 241, 0.45);
            transform: translateY(-1px);
        }

        .btn-submit-login:active {
            transform: translateY(0);
        }

        /* Bottom Return Link */
        .login-footer-links {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.825rem;
            color: var(--text-muted);
        }

        .return-link {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .return-link:hover {
            color: var(--brand-primary);
        }

        .security-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #10B981;
            font-weight: 600;
            font-size: 0.775rem;
        }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            .login-showcase-pane {
                display: none;
            }
            .login-card-container {
                max-width: 480px;
                min-height: auto;
            }
            .login-form-pane {
                padding: 40px 28px;
            }
            .login-logo-mobile {
                display: block;
            }
        }
    </style>
</head>
<body class="login-page">

    <div class="ambient-glow glow-1"></div>
    <div class="ambient-glow glow-2"></div>

    <div class="login-card-container">

        <!-- Left Showcase Pane (Desktop & Tablet) -->
        <div class="login-showcase-pane">
            <div class="login-showcase-overlay"></div>

            <div class="showcase-content">
                <div class="showcase-badge">
                    <i class="bi bi-shield-check"></i>
                    <span>Management Portal</span>
                </div>

                <h2 class="showcase-brand-title">
                    Denvon<span>bay</span>
                </h2>
                <p class="showcase-brand-desc">
                    Boutique coastal accommodation & hospitality control center in Hiriketiya, Sri Lanka.
                </p>

                <ul class="showcase-feature-list">
                    <li class="showcase-feature-item">
                        <div class="showcase-feature-icon"><i class="bi bi-calendar-check"></i></div>
                        <span>Live Reservation Management & Overlap Guard</span>
                    </li>
                    <li class="showcase-feature-item">
                        <div class="showcase-feature-icon"><i class="bi bi-door-open"></i></div>
                        <span>Real-Time Room Inventory & Pricing</span>
                    </li>
                    <li class="showcase-feature-item">
                        <div class="showcase-feature-icon"><i class="bi bi-chat-heart"></i></div>
                        <span>Guest Inquiries & Testimonial Moderation</span>
                    </li>
                </ul>
            </div>

            <div class="showcase-footer">
                <span><i class="bi bi-geo-alt me-1"></i>Hiriketiya Beach, Sri Lanka</span>
                <span>v2.0 • Secure Session</span>
            </div>
        </div>

        <!-- Right Form Pane -->
        <div class="login-form-pane">

            <div class="login-header">
                <div class="login-logo-mobile text-center">
                    <img src="../assets/images/logo/appicon.png" alt="Denvonbay Logo" width="56" height="56" style="border-radius: 14px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                </div>
                <h1 class="login-title">Sign In</h1>
                <p class="login-subtitle">Enter your verified credentials to access the Denvonbay management dashboard.</p>
            </div>

            <!-- Flash Notices -->
            <?php 
            $flash = get_flash();
            if ($flash): 
                $isSuccess = ($flash['type'] === 'success');
            ?>
                <div class="alert <?= $isSuccess ? 'alert-success' : 'alert-danger' ?> d-flex align-items-center gap-2 mb-3" role="alert" style="border-radius: 12px; font-size: 0.875rem;">
                    <i class="bi <?= $isSuccess ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill' ?>"></i>
                    <div><?= e($flash['message']) ?></div>
                </div>
            <?php endif; ?>

            <!-- Error Notice -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3" role="alert" style="border-radius: 12px; font-size: 0.875rem;">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div><?= e($error) ?></div>
                </div>
            <?php endif; ?>

            <!-- Quick Demo Credentials Filler -->
            <div class="demo-chip-bar">
                <div class="demo-chip-text">
                    <i class="bi bi-key-fill text-primary me-1"></i> Demo: <code>admin@denvonbay.com</code>
                </div>
                <button type="button" class="demo-chip-btn" id="fillDemoBtn" title="Fill credentials automatically">
                    Auto-Fill
                </button>
            </div>

            <!-- Login Form -->
            <form method="POST" action="login.php" id="loginForm">
                <div class="custom-form-group">
                    <label for="adminEmail" class="custom-form-label">Administrator Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="adminEmail" name="email" class="custom-input" required 
                               placeholder="e.g. admin@denvonbay.com" 
                               value="<?= e($_POST['email'] ?? '') ?>"
                               autocomplete="username" autofocus>
                        <i class="bi bi-envelope-at input-icon"></i>
                    </div>
                </div>

                <div class="custom-form-group mb-4">
                    <label for="adminPassword" class="custom-form-label">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="adminPassword" name="password" class="custom-input" required 
                               placeholder="••••••••••••" 
                               autocomplete="current-password">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <button type="button" class="password-toggle-btn" id="togglePasswordBtn" title="Toggle password visibility">
                            <i class="bi bi-eye" id="toggleEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit-login" id="submitBtn">
                    <i class="bi bi-box-arrow-in-right fs-5"></i>
                    <span>Sign In to Dashboard</span>
                </button>
            </form>

            <div class="login-footer-links">
                <a href="../index.php" class="return-link">
                    <i class="bi bi-arrow-left"></i>
                    <span>Back to Website</span>
                </a>
                <span class="security-badge">
                    <i class="bi bi-shield-shaded"></i> 256-Bit SSL Encrypted
                </span>
            </div>

        </div>

    </div>

    <!-- Interactive Vanilla JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Password Show/Hide Toggle
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('adminPassword');
            const eyeIcon = document.getElementById('toggleEyeIcon');

            if (toggleBtn && passwordInput && eyeIcon) {
                toggleBtn.addEventListener('click', function() {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.className = 'bi bi-eye-slash';
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.className = 'bi bi-eye';
                    }
                    passwordInput.focus();
                });
            }

            // Quick Auto-Fill Demo Credentials
            const fillDemoBtn = document.getElementById('fillDemoBtn');
            const emailInput = document.getElementById('adminEmail');

            if (fillDemoBtn && emailInput && passwordInput) {
                fillDemoBtn.addEventListener('click', function() {
                    emailInput.value = 'admin@denvonbay.com';
                    passwordInput.value = 'admin123';
                    emailInput.focus();
                });
            }
        });
    </script>
</body>
</html>
