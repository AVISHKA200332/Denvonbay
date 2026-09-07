# Denvonbay — Coastal Accommodation Website

A modern, fast, and beginner-friendly coastal accommodation website for **Denvonbay**, located near Hiriketiya Beach, Sri Lanka.

---

## 🚀 Tech Stack

- **PHP 8+** (Clean, procedural, reusable includes)
- **HTML5 & Vanilla CSS3** (Modular, organized stylesheets)
- **Bootstrap 5** (Layout utilities, grid, icons, modal components)
- **Vanilla JavaScript** (Navbar scroll effects, mobile navigation, scroll-reveal animations)
- **MySQL / MySQL Workbench** (Database management for bookings and contact inquiries)

---

## 📁 Project Structure

```text
Denvonbay/
│
├── actions/                  # Form processing endpoints (POST handlers)
│   ├── submit-booking.php    # Handles booking submissions
│   └── submit-contact.php    # Handles contact message submissions
│
├── assets/
│   ├── css/                  # Modular external CSS stylesheets
│   │   ├── style.css         # Design tokens, reset, typography, buttons
│   │   ├── components.css    # Header, navbar, and footer styles
│   │   ├── home.css          # Home page section styles
│   │   └── responsive.css    # Mobile, tablet, and desktop media queries
│   ├── js/
│   │   └── main.js           # Client-side interactions & animations
│   └── images/
│       └── explore/          # Real photography assets
│
├── config/
│   └── config.php            # MySQL database connection ONLY (ignored in git)
│
├── database/
│   ├── denvonbay.sql         # Database schema
│   └── sample-data.sql       # Initial test data
│
├── includes/
│   ├── header.php            # HTML <head>, meta tags, $base path, CSS links
│   ├── navbar.php            # Sticky site navigation bar
│   └── footer.php            # Site footer, copyright, JS script tags
│
├── index.php                 # Home page
├── about.php                 # About us page
├── rooms.php                 # Rooms & accommodation
├── packages.php              # Stay packages & offers
├── explore.php               # Hiriketiya local guide
├── contact.php               # Contact & location
├── booking.php               # Booking request page
│
├── .gitignore                # Excludes credentials and temporary files
└── README.md                 # Project documentation
```

---

## 🎨 How CSS Works

Styles are organized into **4 focused stylesheets** loaded via standard `<link>` tags in `includes/header.php`:

1. **`style.css`**: Global design system — CSS custom properties (colors, fonts, shadows), resets, accessibility, utility classes, and buttons.
2. **`components.css`**: Reusable page components — Navigation bar and footer.
3. **`home.css`**: Home page sections — Hero, brand marquee, experiences, room previews, packages, amenities, and testimonials.
4. **`responsive.css`**: All media queries — Tablet, mobile, and small screen optimizations.

---

## 💻 Local Development (XAMPP)

1. **Install XAMPP** with Apache and MySQL.
2. Clone or copy this repository into your XAMPP web directory:
   ```text
   C:\xampp\htdocs\Denvonbay\
   ```
3. Start **Apache** and **MySQL** from the XAMPP Control Panel.
4. Open your browser and navigate to:
   ```text
   http://localhost/Denvonbay/
   ```

---

## 🌐 Deploying to Live Hosting

All internal links and asset paths use the `$base` variable defined in **`includes/header.php`**:

```php
// includes/header.php (line 17)
$base = '/Denvonbay'; // Localhost
```

When deploying to a live domain (e.g. `https://yourdomain.com/`):
```php
$base = ''; // Change to an empty string on production
```
Everything else (links, images, stylesheets, scripts) will update automatically.

---

## 🗄️ Database Setup

1. Open **phpMyAdmin** (`http://localhost/phpmyadmin/`) or **MySQL Workbench**.
2. Create a new database named `denvonbay`:
   ```sql
   CREATE DATABASE denvonbay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```
3. Configure your database credentials in `config/config.php`:
   ```php
   $dbHost     = "localhost";
   $dbUser     = "root";
   $dbPassword = "";
   $dbName     = "denvonbay";
   ```

---

## 🛡️ Security Best Practices

- `config/config.php` contains database credentials and is excluded by `.gitignore`.
- User input in form handlers (`actions/`) is validated and bound using prepared statements (`mysqli::prepare`).
- Output rendered in views is sanitized with `htmlspecialchars()` to prevent XSS.
