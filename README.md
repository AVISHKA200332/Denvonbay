# Denvonbay — Coastal Accommodation Website

A clean, beginner-friendly coastal accommodation website for **Denvonbay**, located in Hiriketiya, Sri Lanka.

Built with a simple traditional PHP architecture: straightforward includes, direct CSS/JS linking, PDO MySQL database, and flat admin management.

---

## 🚀 Tech Stack

- **PHP 8+** (Clean, procedural, reusable includes)
- **HTML5 & Vanilla CSS3** (Organized per-page stylesheets)
- **Bootstrap 5 & Bootstrap Icons** (Grid layout and icons)
- **Vanilla JavaScript** (Navbar scroll effects, booking calculations, and mobile toggling)
- **MySQL / PDO** (Prepared statements for bookings, contact inquiries, and admin auth)

---

## 📁 Project Structure

```text
Denvonbay/
│
├── index.php                 # Home page
├── about.php                 # About story & ethos
├── rooms.php                 # 5 coastal rooms listing
├── room-details.php          # Single room details & booking widget
├── packages.php              # Stay & surf packages
├── explore.php               # Hiriketiya local area guide
├── amenities.php             # Facilities & comforts breakdown
├── faq.php                   # Frequently asked questions
├── contact.php               # Contact info & message form
├── booking.php               # Room reservation form
├── booking-success.php       # Booking confirmation screen
├── 404.php                   # Page not found error screen
│
├── header.php                # Reusable site navigation bar
├── footer.php                # Reusable site footer
│
├── config/
│   ├── database.php          # PDO database connection ONLY
│   └── config.php            # Site constants (email, phone, address)
│
├── includes/
│   ├── functions.php         # Procedural helpers (formatting, sanitize, flash)
│   ├── validation.php        # Input validation helpers
│   └── auth.php              # Admin session authentication helpers
│
├── actions/
│   ├── submit-booking.php    # Handles booking POST requests
│   ├── submit-contact.php    # Handles contact form POST requests
│   └── submit-review.php     # Handles review form POST requests
│
├── assets/
│   ├── css/
│   │   ├── common.css        # Shared tokens, reset, buttons, navbar, footer
│   │   ├── home.css          # Home page sections
│   │   ├── about.css         # About page styles
│   │   ├── rooms.css         # Rooms & details styles
│   │   ├── packages.css      # Packages grid styles
│   │   ├── explore.css       # Local guide styles
│   │   ├── amenities.css     # Amenities list styles
│   │   ├── faq.css           # FAQ accordion styles
│   │   ├── contact.css       # Contact form styles
│   │   ├── booking.css       # Booking form styles
│   │   └── admin.css         # Admin panel styling
│   │
│   ├── js/
│   │   ├── common.js         # Shared navigation, animations, smooth scroll
│   │   ├── home.js           # Home page scripts
│   │   ├── booking.js        # Live booking calculations
│   │   ├── contact.js        # Contact form validation
│   │   └── admin.js          # Admin confirmation prompts
│   │
│   └── images/
│       └── explore/          # Real photography assets
│
├── admin/
│   ├── login.php             # Admin login screen
│   ├── logout.php            # Session destroy and redirect
│   ├── dashboard.php         # Metric counters & recent reservations
│   ├── bookings.php          # Manage all reservations & status
│   ├── booking-view.php      # Full reservation detail view
│   ├── rooms.php             # Manage room listings
│   ├── room-add.php          # Add new room form
│   ├── room-edit.php         # Edit room details form
│   ├── packages.php          # Manage packages
│   ├── package-add.php       # Add package form
│   ├── package-edit.php      # Edit package form
│   ├── messages.php          # View & respond to contact messages
│   ├── reviews.php           # Moderate guest reviews
│   └── admin-header.php      # Admin navigation bar component
│
├── database/
│   └── denvonbay.sql         # Clean database schema & seed data
│
├── .htaccess                 # Security & 404 handler
├── .gitignore                # Excludes credentials and temp files
└── README.md                 # Documentation
```

---

## 💻 Local Development Setup (XAMPP)

1. Start **Apache** and **MySQL** in XAMPP.
2. Ensure the repository is located in:
   ```text
   C:\xampp\htdocs\Denvonbay\
   ```
3. Import the database:
   - Open **phpMyAdmin** (`http://localhost/phpmyadmin/`) or **MySQL Workbench**.
   - Import `database/denvonbay.sql`.
4. Open the website in your browser:
   ```text
   http://localhost/Denvonbay/
   ```
5. Access the Admin Panel:
   ```text
   http://localhost/Denvonbay/admin/login.php
   ```
   - **Email**: `admin@denvonbay.com`
   - **Password**: `admin123`

---

## 🛡️ Security & Best Practices

- **PDO Prepared Statements**: Used across all queries (`SELECT`, `INSERT`, `UPDATE`, `DELETE`) to eliminate SQL injection risks.
- **Output Escaping**: User content passed through `htmlspecialchars()` via helper function `e()`.
- **Password Hashing**: Admin passwords stored using native `password_hash()` and verified with `password_verify()`.
- **Session Protection**: All admin pages guarded by `require_admin()`.
