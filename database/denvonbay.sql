-- =====================================================
-- Denvonbay - Database Schema & Initial Data
-- Location: Hiriketiya, Sri Lanka
-- =====================================================

CREATE DATABASE IF NOT EXISTS `denvonbay`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `denvonbay`;

-- -----------------------------------------------------
-- Table: admin_users
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table: rooms
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `tag` VARCHAR(50) DEFAULT NULL,
  `price_per_night` DECIMAL(10,2) NOT NULL,
  `capacity` INT NOT NULL DEFAULT 2,
  `bed_type` VARCHAR(50) NOT NULL DEFAULT 'King Bed',
  `image_url` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `amenities` TEXT DEFAULT NULL,
  `is_available` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table: packages
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `packages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(100) NOT NULL,
  `slug` VARCHAR(100) NOT NULL UNIQUE,
  `subtitle` VARCHAR(150) DEFAULT NULL,
  `duration` VARCHAR(50) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `badge` VARCHAR(50) DEFAULT NULL,
  `icon` VARCHAR(50) DEFAULT 'bi-sun',
  `features` TEXT DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table: bookings
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bookings` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `booking_ref` VARCHAR(20) NOT NULL UNIQUE,
  `room_id` INT DEFAULT NULL,
  `package_id` INT DEFAULT NULL,
  `guest_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(30) NOT NULL,
  `check_in` DATE NOT NULL,
  `check_out` DATE NOT NULL,
  `guests` INT NOT NULL DEFAULT 1,
  `total_price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `special_requests` TEXT DEFAULT NULL,
  `status` ENUM('pending', 'confirmed', 'cancelled') NOT NULL DEFAULT 'pending',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`room_id`) REFERENCES `rooms`(`id`) ON DELETE SET NULL,
  FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table: contact_messages
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `subject` VARCHAR(150) DEFAULT NULL,
  `message` TEXT NOT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Table: reviews
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `guest_name` VARCHAR(100) NOT NULL,
  `location` VARCHAR(100) DEFAULT 'Sri Lanka',
  `rating` INT NOT NULL DEFAULT 5,
  `comment` TEXT NOT NULL,
  `is_approved` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------
-- Initial Data: Default Admin User (admin@denvonbay.com / admin123)
-- -----------------------------------------------------
INSERT INTO `admin_users` (`username`, `email`, `password`)
VALUES ('Admin', 'admin@denvonbay.com', '$2y$10$DrWnkYuUZCQYBjUFOnCVburyl4PwJfTJdBSTnWym/gF9XRIg1L.9.')
ON DUPLICATE KEY UPDATE `username` = VALUES(`username`);

-- -----------------------------------------------------
-- Initial Data: Rooms
-- -----------------------------------------------------
INSERT INTO `rooms` (`id`, `name`, `slug`, `tag`, `price_per_night`, `capacity`, `bed_type`, `image_url`, `description`, `amenities`, `is_available`)
VALUES
(1, 'The Cozy Room', 'cozy', 'Perfect for Solo', 40.00, 1, 'Single Bed', 'assets/images/explore/Surfboard_logo_detail_macro_shot_202607210209.jpg', 'A thoughtfully designed quiet retreat for the solo traveler who values simplicity and calm.', 'High-Speed Wi-Fi, Ceiling Fan, Work Desk, Private Bathroom, Daily Housekeeping', 1),
(2, 'The Couple\'s Retreat', 'couples', 'Most Popular', 65.00, 2, 'Queen Bed', 'assets/images/explore/Woman_posing_in_bikini_2K_202607210231.jpg', 'A romantic coastal escape designed for two - comfortable, private and just steps from the beach.', 'Air Conditioning, High-Speed Wi-Fi, Balcony, Private En-suite, Mini Fridge, Breakfast Included', 1),
(3, 'The Friends\' Stay', 'friends', 'Great for Groups', 90.00, 4, '2 Double Beds', 'assets/images/explore/Friends_walking_on_beach_202607210209.jpg', 'Spacious, social and fun. The ideal base for a group trip to the south coast surf scene.', 'Air Conditioning, High-Speed Wi-Fi, Board Rack, Spacious Lounge, Garden View', 1),
(4, 'Family Room', 'family', 'Spacious & Bright', 110.00, 5, '1 King + 2 Singles', 'assets/images/explore/Tote_bag_with_branding_202607210209.jpg', 'Generously sized accommodation perfect for families traveling together, offering safety and comfort.', 'Air Conditioning, Fast Wi-Fi, Full En-suite, Kid-Friendly, Tea & Coffee Station', 1),
(5, 'Garden Suite', 'suite', 'Peaceful Outlook', 80.00, 2, 'King Bed', 'assets/images/explore/White_spa_slippers_on_beach_202607210209.jpg', 'Overlooking our lush tropical coastal greenery with a private terrace and refreshing breeze.', 'Tropical Garden Terrace, Air Conditioning, Rain Shower, Wi-Fi, Outdoor Seating', 1)
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `price_per_night` = VALUES(`price_per_night`);

-- -----------------------------------------------------
-- Initial Data: Packages
-- -----------------------------------------------------
INSERT INTO `packages` (`id`, `title`, `slug`, `subtitle`, `duration`, `price`, `badge`, `icon`, `features`, `is_active`)
VALUES
(1, 'Day Escape', 'day-escape', 'Beach day base camp', 'Daytime Stay', 25.00, NULL, 'bi-sun', 'Lounge access, Fresh towels, Secure luggage storage, Shower access, Refreshing welcome drink', 1),
(2, 'One Night Getaway', 'one-night', 'Overnight coastal reset', '1 Night', 55.00, 'Most Booked', 'bi-moon-stars', '1 night accommodation, Coastal breakfast, Beach towel service, Wi-Fi access, Flexible check-in', 1),
(3, 'Weekend Escape', 'weekend', 'Friday to Sunday surf vibe', '2 Nights', 110.00, 'Popular', 'bi-calendar2-week', '2 nights accommodation, Daily breakfast, 1 guided surf spot tour, Late Sunday checkout, Free board storage', 1),
(4, 'Slow Island Stay', 'slow-stay', 'Extended tropical living', '3+ Nights', 160.00, 'Best Value', 'bi-tropical-storm', '3+ nights stay, Daily breakfast, Scooter rental discount, Laundry service, Surf & cafe guide', 1)
ON DUPLICATE KEY UPDATE `title` = VALUES(`title`), `price` = VALUES(`price`);

-- -----------------------------------------------------
-- Initial Data: Reviews
-- -----------------------------------------------------
INSERT INTO `reviews` (`id`, `guest_name`, `location`, `rating`, `comment`, `is_approved`)
VALUES
(1, 'Sophie & Liam', 'Melbourne, Australia', 5, 'We came for two nights and ended up staying four. The vibe is so relaxed and the team genuinely looked after us. It felt like a home away from home. Perfect for a surf trip or just slowing down.', 1),
(2, 'Marco R.', 'Milan, Italy', 5, 'Great value, great location and great atmosphere. Only 5 rooms means it never feels crowded. Woke up to beautiful tropical mornings every day. Will definitely be back next season.', 1),
(3, 'Elena K.', 'Berlin, Germany', 5, 'Super clean, super quiet and five minutes walk to Hiriketiya bay. The staff gave great recommendations for secret surf spots and food. Absolutely loved it!', 1)
ON DUPLICATE KEY UPDATE `guest_name` = VALUES(`guest_name`);
