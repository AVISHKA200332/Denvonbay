<?php
/**
 * Setup SQLite Database for Denvonbay
 * This creates database/denvonbay.sqlite as a self-contained fallback database
 * for Vercel / Cloud serverless preview deployment.
 */

$dbPath = __DIR__ . '/denvonbay.sqlite';

// If exists, remove to start fresh
if (file_exists($dbPath)) {
    unlink($dbPath);
}

try {
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables
    $db->exec("
        CREATE TABLE IF NOT EXISTS admin_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS rooms (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            tag TEXT DEFAULT NULL,
            price_per_night REAL NOT NULL,
            capacity INTEGER NOT NULL DEFAULT 2,
            bed_type TEXT NOT NULL DEFAULT 'King Bed',
            image_url TEXT NOT NULL,
            description TEXT NOT NULL,
            amenities TEXT DEFAULT NULL,
            is_available INTEGER NOT NULL DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS packages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT NOT NULL,
            slug TEXT NOT NULL UNIQUE,
            subtitle TEXT DEFAULT NULL,
            duration TEXT NOT NULL,
            price REAL NOT NULL,
            badge TEXT DEFAULT NULL,
            icon TEXT DEFAULT 'bi-sun',
            features TEXT DEFAULT NULL,
            is_active INTEGER NOT NULL DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS bookings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            booking_ref TEXT NOT NULL UNIQUE,
            room_id INTEGER DEFAULT NULL,
            package_id INTEGER DEFAULT NULL,
            guest_name TEXT NOT NULL,
            email TEXT NOT NULL,
            phone TEXT NOT NULL,
            check_in DATE NOT NULL,
            check_out DATE NOT NULL,
            guests INTEGER NOT NULL DEFAULT 1,
            total_price REAL NOT NULL DEFAULT 0.00,
            special_requests TEXT DEFAULT NULL,
            status TEXT NOT NULL DEFAULT 'pending',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE SET NULL,
            FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL
        );

        CREATE TABLE IF NOT EXISTS contact_messages (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL,
            subject TEXT DEFAULT NULL,
            message TEXT NOT NULL,
            is_read INTEGER NOT NULL DEFAULT 0,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS reviews (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            guest_name TEXT NOT NULL,
            location TEXT DEFAULT 'Sri Lanka',
            rating INTEGER NOT NULL DEFAULT 5,
            comment TEXT NOT NULL,
            is_approved INTEGER NOT NULL DEFAULT 1,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );

        CREATE TABLE IF NOT EXISTS site_settings (
            setting_key TEXT PRIMARY KEY,
            setting_value TEXT NULL,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
    ");

    // Insert Admin User
    $stmt = $db->prepare("INSERT INTO admin_users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute(['Admin', 'admin@denvonbay.com', '$2y$10$DrWnkYuUZCQYBjUFOnCVburyl4PwJfTJdBSTnWym/gF9XRIg1L.9.']);

    // Insert Rooms
    $roomStmt = $db->prepare("INSERT INTO rooms (id, name, slug, tag, price_per_night, capacity, bed_type, image_url, description, amenities, is_available) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $rooms = [
        [1, 'The Cozy Room', 'cozy', 'Perfect for Solo', 40.00, 1, 'Single Bed', 'assets/images/explore/Surfboard_logo_detail_macro_shot_202607210209.jpg', 'A thoughtfully designed quiet retreat for the solo traveler who values simplicity and calm.', 'High-Speed Wi-Fi, Ceiling Fan, Work Desk, Private Bathroom, Daily Housekeeping', 1],
        [2, "The Couple's Retreat", 'couples', 'Most Popular', 65.00, 2, 'Queen Bed', 'assets/images/explore/Woman_posing_in_bikini_2K_202607210231.jpg', 'A romantic coastal escape designed for two - comfortable, private and just steps from the beach.', 'Air Conditioning, High-Speed Wi-Fi, Balcony, Private En-suite, Mini Fridge, Breakfast Included', 1],
        [3, "The Friends' Stay", 'friends', 'Great for Groups', 90.00, 4, '2 Double Beds', 'assets/images/explore/Friends_walking_on_beach_202607210209.jpg', 'Spacious, social and fun. The ideal base for a group trip to the south coast surf scene.', 'Air Conditioning, High-Speed Wi-Fi, Board Rack, Spacious Lounge, Garden View', 1],
        [4, 'Family Room', 'family', 'Spacious & Bright', 110.00, 5, '1 King + 2 Singles', 'assets/images/explore/Tote_bag_with_branding_202607210209.jpg', 'Generously sized accommodation perfect for families traveling together, offering safety and comfort.', 'Air Conditioning, Fast Wi-Fi, Full En-suite, Kid-Friendly, Tea & Coffee Station', 1],
        [5, 'Garden Suite', 'suite', 'Peaceful Outlook', 80.00, 2, 'King Bed', 'assets/images/explore/White_spa_slippers_on_beach_202607210209.jpg', 'Overlooking our lush tropical coastal greenery with a private terrace and refreshing breeze.', 'Tropical Garden Terrace, Air Conditioning, Rain Shower, Wi-Fi, Outdoor Seating', 1]
    ];
    foreach ($rooms as $r) {
        $roomStmt->execute($r);
    }

    // Insert Packages
    $pkgStmt = $db->prepare("INSERT INTO packages (id, title, slug, subtitle, duration, price, badge, icon, features, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $packages = [
        [1, 'Day Escape', 'day-escape', 'Beach day base camp', 'Daytime Stay', 25.00, null, 'bi-sun', 'Lounge access, Fresh towels, Secure luggage storage, Shower access, Refreshing welcome drink', 1],
        [2, 'One Night Getaway', 'one-night', 'Overnight coastal reset', '1 Night', 55.00, 'Most Booked', 'bi-moon-stars', '1 night accommodation, Coastal breakfast, Beach towel service, Wi-Fi access, Flexible check-in', 1],
        [3, 'Weekend Escape', 'weekend', 'Friday to Sunday surf vibe', '2 Nights', 110.00, 'Popular', 'bi-calendar2-week', '2 nights accommodation, Daily breakfast, 1 guided surf spot tour, Late Sunday checkout, Free board storage', 1],
        [4, 'Slow Island Stay', 'slow-stay', 'Extended tropical living', '3+ Nights', 160.00, 'Best Value', 'bi-tropical-storm', '3+ nights stay, Daily breakfast, Scooter rental discount, Laundry service, Surf & cafe guide', 1]
    ];
    foreach ($packages as $p) {
        $pkgStmt->execute($p);
    }

    // Insert Reviews
    $revStmt = $db->prepare("INSERT INTO reviews (id, guest_name, location, rating, comment, is_approved) VALUES (?, ?, ?, ?, ?, ?)");
    $reviews = [
        [1, 'Sophie & Liam', 'Melbourne, Australia', 5, 'We came for two nights and ended up staying four. The vibe is so relaxed and the team genuinely looked after us. It felt like a home away from home. Perfect for a surf trip or just slowing down.', 1],
        [2, 'Marco R.', 'Milan, Italy', 5, 'Great value, great location and great atmosphere. Only 5 rooms means it never feels crowded. Woke up to beautiful tropical mornings every day. Will definitely be back next season.', 1],
        [3, 'Elena K.', 'Berlin, Germany', 5, 'Super clean, super quiet and five minutes walk to Hiriketiya bay. The staff gave great recommendations for secret surf spots and food. Absolutely loved it!', 1]
    ];
    foreach ($reviews as $rev) {
        $revStmt->execute($rev);
    }

    // Insert Site Settings
    $setStmt = $db->prepare("INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)");
    $settings = [
        ['site_name', 'Denvonbay'],
        ['site_tagline', 'Your Relaxed Stay in Hiriketiya, Sri Lanka'],
        ['contact_email', 'hello@denvonbay.com'],
        ['contact_phone', '+94 77 123 4567'],
        ['contact_whatsapp', '94771234567'],
        ['contact_location', 'Hiriketiya, Dickwella, Sri Lanka'],
        ['instagram_url', 'https://instagram.com'],
        ['facebook_url', 'https://facebook.com']
    ];
    foreach ($settings as $s) {
        $setStmt->execute($s);
    }

    echo "SQLite database successfully created at: " . $dbPath . "\n";

} catch (Exception $e) {
    echo "Error creating SQLite database: " . $e->getMessage() . "\n";
    exit(1);
}
