<?php
/**
 * Denvonbay - Home Page
 * ---------------------
 * Premium coastal accommodation in Hiriketiya, Sri Lanka.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Denvonbay | Your Relaxed Stay in Hiriketiya, Sri Lanka';
$pageDescription = "Stay at Denvonbay, Hiriketiya's most relaxed coastal retreat. Affordable rooms, flexible packages, beach access and tropical mornings on Sri Lanka's south coast.";

$flash = get_flash();

// Dynamic content from database
$featuredRooms = $pdo->query("SELECT * FROM rooms WHERE is_available = 1 ORDER BY id ASC LIMIT 3")->fetchAll();
$featuredPackages = $pdo->query("SELECT * FROM packages WHERE is_active = 1 ORDER BY id ASC LIMIT 4")->fetchAll();
$featuredReviews = get_approved_reviews($pdo, 3);
$whatsappNumber = get_setting($pdo, 'whatsapp_number', '94771234567');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="keywords" content="Denvonbay, Hiriketiya accommodation, Sri Lanka beach stay, surf retreat, coastal guesthouse, Dickwella">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo/favicon.png">
    <link rel="apple-touch-icon" href="assets/images/logo/appicon.png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="assets/css/common.css">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body>

<?php include 'header.php'; ?>

<main id="main-content">

  <?php if ($flash): ?>
    <div class="container mt-3">
      <div class="alert-flash alert-<?= e($flash['type']) ?>">
        <i class="bi bi-info-circle-fill"></i>
        <span><?= e($flash['message']) ?></span>
      </div>
    </div>
  <?php endif; ?>

  <!-- ===== HERO SECTION ===== -->
  <section class="hero-section" id="hero" aria-label="Hero section">
    <div class="container hero-container">
      <div class="row align-items-center hero-row">
        <div class="col-lg-6 hero-content" data-reveal="left">
          <p class="hero-accent-label"><i class="bi bi-water me-2"></i>Stay by the Coast</p>
          <h1 class="hero-heading">Your Relaxed Stay in <span class="hero-heading-accent">Hiriketiya.</span></h1>
          <p class="hero-subtext">Affordable, comfortable stays near the beach for couples, solo travelers, friends and families exploring Sri Lanka's south coast.</p>
          <div class="hero-buttons">
            <a href="rooms.php" class="btn btn-hero-primary" id="heroExploreRoomsBtn">Explore Our Rooms <i class="bi bi-arrow-right ms-2"></i></a>
            <a href="booking.php" class="btn btn-hero-secondary" id="heroBookBtn">Book Your Stay</a>
          </div>
          <div class="hero-pills">
            <span class="hero-pill"><i class="bi bi-house-door me-1"></i>Only 5 unique rooms</span>
            <span class="hero-pill"><i class="bi bi-calendar2 me-1"></i>Flexible stay packages</span>
            <span class="hero-pill"><i class="bi bi-cup-hot me-1"></i>Breakfast available</span>
          </div>
        </div>
        <div class="col-lg-6 hero-visual" data-reveal="right">
          <div class="hero-image-wrap">
            <img src="assets/images/explore/Female_surfer_walking_tropical_b…_202607210158.jpg"
                 alt="Female surfer walking on a tropical beach near Hiriketiya, Sri Lanka"
                 class="hero-main-img" loading="eager" fetchpriority="high">
            <div class="hero-float-badge"><i class="bi bi-star-fill text-warning me-1"></i><span>Hiriketiya's Favourite Stay</span></div>
            <div class="hero-float-pill"><i class="bi bi-geo-alt-fill me-1"></i>South Coast, Sri Lanka</div>
          </div>
        </div>
      </div>
    </div>
    <div class="hero-wave" aria-hidden="true">
      <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#1266F1"/>
      </svg>
    </div>
  </section>

  <!-- ===== BRAND WAVE / MARQUEE ===== -->
  <section class="brand-wave-section" id="brand-wave" aria-hidden="true">
    <div class="brand-wave-inner">
      <div class="brand-marquee-wrap">
        <div class="brand-marquee">
          <span class="brand-marquee-item">DENVONBAY</span>
          <span class="brand-marquee-dot">·</span>
          <span class="brand-marquee-item brand-marquee-aqua">HIRIKETIYA</span>
          <span class="brand-marquee-dot">·</span>
          <span class="brand-marquee-item">SRI LANKA</span>
          <span class="brand-marquee-dot">·</span>
          <span class="brand-marquee-item brand-marquee-aqua">COASTAL STAYS</span>
          <span class="brand-marquee-dot">·</span>
          <span class="brand-marquee-item">DENVONBAY</span>
          <span class="brand-marquee-dot">·</span>
          <span class="brand-marquee-item brand-marquee-aqua">HIRIKETIYA</span>
          <span class="brand-marquee-dot">·</span>
          <span class="brand-marquee-item">SRI LANKA</span>
          <span class="brand-marquee-dot">·</span>
          <span class="brand-marquee-item brand-marquee-aqua">COASTAL STAYS</span>
          <span class="brand-marquee-dot">·</span>
        </div>
      </div>
    </div>
    <div class="brand-wave-bottom" aria-hidden="true">
      <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#ffffff"/>
      </svg>
    </div>
  </section>

  <!-- ===== FEATURED LIFESTYLE IMAGE ===== -->
  <section class="featured-image-section" id="featured-lifestyle">
    <div class="container">
      <div class="featured-image-wrap" data-reveal="up">
        <img src="assets/images/explore/Lady_surfing_on_beach_2K_202607061446.jpg"
             alt="Lady surfing a wave at Hiriketiya beach, Sri Lanka"
             class="featured-lifestyle-img" loading="lazy">
        <div class="featured-image-overlay">
          <div class="featured-image-label">
            <span class="featured-label-accent">South Coast Living</span>
            <h2 class="featured-label-heading">Waves. Warmth. Wonder.</h2>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== EXPERIENCES SECTION ===== -->
  <section class="experiences-section" id="experiences" aria-label="Experiences at Denvonbay">
    <div class="container">
      <div class="section-header text-center" data-reveal="up">
        <p class="section-eyebrow">What Awaits You</p>
        <h2 class="section-heading text-white">Experiences</h2>
        <p class="section-subtext text-white-75">More than just a place to sleep.</p>
      </div>
      <div class="experiences-grid">

        <article class="exp-card" data-reveal="up" data-reveal-delay="0">
          <div class="exp-card-image-wrap">
            <img src="assets/images/explore/Lady_surfing_on_Sri_Lankan_202607061450.jpg"
                 alt="Lady surfing at a Sri Lankan beach near Hiriketiya" class="exp-card-img" loading="lazy">
          </div>
          <div class="exp-card-label">
            <div class="exp-card-label-icon"><i class="bi bi-tsunami"></i></div>
            <div class="exp-card-label-body">
              <h3 class="exp-card-title">Surfing</h3>
              <p class="exp-card-desc">Catch waves and enjoy the relaxed surf culture of the south coast.</p>
            </div>
            <div class="exp-card-arrow"><i class="bi bi-arrow-right"></i></div>
          </div>
        </article>

        <article class="exp-card" data-reveal="up" data-reveal-delay="100">
          <div class="exp-card-image-wrap">
            <img src="assets/images/explore/Woman_lying_on_beach_towel_202607210218.jpg"
                 alt="Relaxed coastal lifestyle near Hiriketiya beach" class="exp-card-img" loading="lazy">
          </div>
          <div class="exp-card-label">
            <div class="exp-card-label-icon"><i class="bi bi-cup-straw"></i></div>
            <div class="exp-card-label-body">
              <h3 class="exp-card-title">Dining</h3>
              <p class="exp-card-desc">Discover local cafes, Sri Lankan dishes and laid-back coastal dining.</p>
            </div>
            <div class="exp-card-arrow"><i class="bi bi-arrow-right"></i></div>
          </div>
        </article>

        <article class="exp-card" data-reveal="up" data-reveal-delay="200">
          <div class="exp-card-image-wrap">
            <img src="assets/images/explore/Woman_practicing_yoga_on_rooftop_202607210327.jpg"
                 alt="Woman practicing yoga on a rooftop with ocean views" class="exp-card-img" loading="lazy">
          </div>
          <div class="exp-card-label">
            <div class="exp-card-label-icon"><i class="bi bi-heart-pulse"></i></div>
            <div class="exp-card-label-body">
              <h3 class="exp-card-title">Yoga</h3>
              <p class="exp-card-desc">Slow down with peaceful mornings and mindful movement.</p>
            </div>
            <div class="exp-card-arrow"><i class="bi bi-arrow-right"></i></div>
          </div>
        </article>

        <article class="exp-card" data-reveal="up" data-reveal-delay="300">
          <div class="exp-card-image-wrap">
            <img src="assets/images/explore/White_spa_slippers_on_beach_202607210209.jpg"
                 alt="Comfortable coastal accommodation - spa slippers on beach" class="exp-card-img" loading="lazy">
          </div>
          <div class="exp-card-label">
            <div class="exp-card-label-icon"><i class="bi bi-house-heart"></i></div>
            <div class="exp-card-label-body">
              <h3 class="exp-card-title">Accommodation</h3>
              <p class="exp-card-desc">Comfortable rooms designed for easy, relaxed coastal stays.</p>
            </div>
            <div class="exp-card-arrow"><i class="bi bi-arrow-right"></i></div>
          </div>
        </article>

      </div>
    </div>
    <div class="experiences-wave-bottom" aria-hidden="true">
      <svg viewBox="0 0 1440 70" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,35 C360,70 1080,0 1440,35 L1440,70 L0,70 Z" fill="#ffffff"/>
      </svg>
    </div>
  </section>

  <!-- ===== WHY STAY WITH US ===== -->
  <section class="why-section" id="why-denvonbay" aria-label="Why choose Denvonbay">
    <div class="container">
      <div class="why-header" data-reveal="up">
        <p class="section-eyebrow-dark">The Denvonbay Difference</p>
        <h2 class="section-heading-dark">Why Travelers Choose Denvonbay</h2>
      </div>
      <div class="why-grid">
        <div class="why-item" data-reveal="up" data-reveal-delay="0">
          <div class="why-number">01</div>
          <div class="why-body">
            <h3 class="why-title">Only Five Rooms</h3>
            <p class="why-desc">A smaller property means a quieter and more personal stay. No crowded hallways. No resort chaos.</p>
          </div>
        </div>
        <div class="why-item" data-reveal="up" data-reveal-delay="100">
          <div class="why-number">02</div>
          <div class="why-body">
            <h3 class="why-title">Flexible Packages</h3>
            <p class="why-desc">Choose daytime, overnight, weekend or longer-stay options. We fit around your travel style.</p>
          </div>
        </div>
        <div class="why-item" data-reveal="up" data-reveal-delay="200">
          <div class="why-number">03</div>
          <div class="why-body">
            <h3 class="why-title">Close to the Coast</h3>
            <p class="why-desc">Enjoy easy access to Hiriketiya, beaches, cafes and surf culture right at your doorstep.</p>
          </div>
        </div>
        <div class="why-item" data-reveal="up" data-reveal-delay="300">
          <div class="why-number">04</div>
          <div class="why-body">
            <h3 class="why-title">Affordable Comfort</h3>
            <p class="why-desc">Relax in comfortable, thoughtfully-styled rooms without paying premium resort prices.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== ROOMS PREVIEW ===== -->
  <section class="rooms-section" id="rooms-preview" aria-label="Room preview">
    <div class="container">
      <div class="section-header text-center" data-reveal="up">
        <p class="section-eyebrow-dark">Your Space</p>
        <h2 class="section-heading-dark">Five Rooms. Five Ways to Stay.</h2>
        <p class="section-subtext-dark">Choose a room that matches your travel style.</p>
      </div>
      <div class="row gy-4 rooms-grid">
        <?php if (!empty($featuredRooms)): ?>
          <?php foreach ($featuredRooms as $idx => $fRoom): 
            $delay = $idx * 150;
            $isPopular = ($idx === 1);
            $cardClass = $isPopular ? "room-card room-card--featured" : "room-card";
            $badgeClass = $isPopular ? "room-card-badge room-card-badge--blue" : "room-card-badge";
            $btnClass = $isPopular ? "btn btn-room-view btn-room-view--primary" : "btn btn-room-view";
            $roomTag = $fRoom['tag'] ?? ($fRoom['capacity'] == 1 ? 'Perfect for Solo' : ($fRoom['capacity'] == 2 ? 'Most Popular' : 'Great for Groups'));
          ?>
            <div class="col-lg-4 col-md-6" data-reveal="up" data-reveal-delay="<?= $delay ?>">
              <article class="<?= $cardClass ?>" id="room-<?= e($fRoom['slug']) ?>">
                <div class="room-card-image-wrap">
                  <img src="<?= e($fRoom['image_url']) ?>"
                       alt="<?= e($fRoom['name']) ?> at Denvonbay" class="room-card-img" loading="lazy">
                  <div class="<?= $badgeClass ?>"><?= e($roomTag) ?></div>
                </div>
                <div class="room-card-body">
                  <h3 class="room-card-title"><?= e($fRoom['name']) ?></h3>
                  <p class="room-card-desc"><?= e($fRoom['description']) ?></p>
                  <div class="room-card-meta">
                    <span class="room-meta-item"><i class="bi bi-person-fill me-1"></i><?= (int)$fRoom['capacity'] ?> Guest<?= $fRoom['capacity'] > 1 ? 's' : '' ?></span>
                    <span class="room-meta-item"><i class="bi bi-wifi me-1"></i>Wi-Fi</span>
                    <span class="room-meta-item"><i class="bi bi-geo-alt me-1"></i>Near Beach</span>
                  </div>
                  <a href="rooms.php#<?= e($fRoom['slug']) ?>" class="<?= $btnClass ?>">View Room <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
              </article>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-lg-4 col-md-6" data-reveal="up" data-reveal-delay="0">
            <article class="room-card" id="room-cozy">
              <div class="room-card-image-wrap">
                <img src="assets/images/explore/Surfboard_logo_detail_macro_shot_202607210209.jpg"
                     alt="The Cozy Room - comfortable single room at Denvonbay" class="room-card-img" loading="lazy">
                <div class="room-card-badge">Perfect for Solo</div>
              </div>
              <div class="room-card-body">
                <h3 class="room-card-title">The Cozy Room</h3>
                <p class="room-card-desc">A thoughtfully designed quiet retreat for the solo traveler who values simplicity and calm.</p>
                <div class="room-card-meta">
                  <span class="room-meta-item"><i class="bi bi-person-fill me-1"></i>1 Guest</span>
                  <span class="room-meta-item"><i class="bi bi-wifi me-1"></i>Wi-Fi</span>
                  <span class="room-meta-item"><i class="bi bi-moon-stars me-1"></i>Peaceful</span>
                </div>
                <a href="rooms.php#cozy" class="btn btn-room-view" id="viewCozyRoomBtn">View Room <i class="bi bi-arrow-right ms-1"></i></a>
              </div>
            </article>
          </div>

          <div class="col-lg-4 col-md-6" data-reveal="up" data-reveal-delay="150">
            <article class="room-card room-card--featured" id="room-couples">
              <div class="room-card-image-wrap">
                <img src="assets/images/explore/Woman_posing_in_bikini_2K_202607210231.jpg"
                     alt="The Couple's Retreat room at Denvonbay" class="room-card-img" loading="lazy">
                <div class="room-card-badge room-card-badge--blue">Most Popular</div>
              </div>
              <div class="room-card-body">
                <h3 class="room-card-title">The Couple's Retreat</h3>
                <p class="room-card-desc">A romantic coastal escape designed for two - comfortable, private and just steps from the beach.</p>
                <div class="room-card-meta">
                  <span class="room-meta-item"><i class="bi bi-people-fill me-1"></i>2 Guests</span>
                  <span class="room-meta-item"><i class="bi bi-wifi me-1"></i>Wi-Fi</span>
                  <span class="room-meta-item"><i class="bi bi-heart me-1"></i>Romantic</span>
                </div>
                <a href="rooms.php#couples" class="btn btn-room-view btn-room-view--primary" id="viewCouplesRoomBtn">View Room <i class="bi bi-arrow-right ms-1"></i></a>
              </div>
            </article>
          </div>

          <div class="col-lg-4 col-md-6" data-reveal="up" data-reveal-delay="300">
            <article class="room-card" id="room-friends">
              <div class="room-card-image-wrap">
                <img src="assets/images/explore/Friends_walking_on_beach_202607210209.jpg"
                     alt="The Friends' Stay room at Denvonbay" class="room-card-img" loading="lazy">
                <div class="room-card-badge">Great for Groups</div>
              </div>
              <div class="room-card-body">
                <h3 class="room-card-title">The Friends' Stay</h3>
                <p class="room-card-desc">Spacious, social and fun. The ideal base for a group trip to the south coast surf scene.</p>
                <div class="room-card-meta">
                  <span class="room-meta-item"><i class="bi bi-people-fill me-1"></i>3-4 Guests</span>
                  <span class="room-meta-item"><i class="bi bi-wifi me-1"></i>Wi-Fi</span>
                  <span class="room-meta-item"><i class="bi bi-sun me-1"></i>Lively</span>
                </div>
                <a href="rooms.php#friends" class="btn btn-room-view" id="viewFriendsRoomBtn">View Room <i class="bi bi-arrow-right ms-1"></i></a>
              </div>
            </article>
          </div>
        <?php endif; ?>
      </div>
      <div class="text-center mt-5" data-reveal="up">
        <a href="rooms.php" class="btn btn-view-all" id="viewAllRoomsBtn">View All Rooms <i class="bi bi-arrow-right ms-2"></i></a>
      </div>
    </div>
  </section>

  <!-- ===== PACKAGES PREVIEW ===== -->
  <section class="packages-section" id="packages-preview" aria-label="Stay packages">
    <div class="packages-bg">
      <div class="container">
        <div class="section-header text-center" data-reveal="up">
          <p class="section-eyebrow">Your Options</p>
          <h2 class="section-heading text-white">Stay Your Way</h2>
          <p class="section-subtext text-white-75">From a quick escape to a longer island slow-down - we have the right package for you.</p>
        </div>
        <div class="packages-grid">
          <?php if (!empty($featuredPackages)): ?>
            <?php 
              $icons = ['bi-sun', 'bi-moon-stars', 'bi-calendar2-week', 'bi-tropical-storm'];
              foreach ($featuredPackages as $pIdx => $fPkg): 
                $pDelay = $pIdx * 100;
                $isHighlight = ($pIdx === 1);
                $pCardClass = $isHighlight ? "pkg-card pkg-card--highlight" : "pkg-card";
                $pBtnClass = $isHighlight ? "btn btn-pkg-primary" : "btn btn-pkg";
                $icon = $icons[$pIdx % count($icons)];
            ?>
              <article class="<?= $pCardClass ?>" data-reveal="up" data-reveal-delay="<?= $pDelay ?>">
                <?php if ($isHighlight): ?>
                  <div class="pkg-card-popular-badge">Most Booked</div>
                <?php endif; ?>
                <div class="pkg-card-icon"><i class="bi <?= $icon ?>"></i></div>
                <h3 class="pkg-card-title"><?= e($fPkg['name']) ?></h3>
                <p class="pkg-card-duration"><i class="bi bi-clock me-1"></i><?= e($fPkg['duration']) ?></p>
                <p class="pkg-card-desc"><?= e($fPkg['description']) ?></p>
                <a href="packages.php#<?= e($fPkg['slug']) ?>" class="<?= $pBtnClass ?>">Explore Package</a>
              </article>
            <?php endforeach; ?>
          <?php else: ?>
            <article class="pkg-card" data-reveal="up" data-reveal-delay="0">
              <div class="pkg-card-icon"><i class="bi bi-sun"></i></div>
              <h3 class="pkg-card-title">Day Escape</h3>
              <p class="pkg-card-duration"><i class="bi bi-clock me-1"></i>Daytime stay</p>
              <p class="pkg-card-desc">Enjoy the Denvonbay experience without an overnight stay. Perfect for beach day explorers.</p>
              <a href="packages.php#day-escape" class="btn btn-pkg" id="pkgDayBtn">Explore Package</a>
            </article>

            <article class="pkg-card pkg-card--highlight" data-reveal="up" data-reveal-delay="100">
              <div class="pkg-card-popular-badge">Most Booked</div>
              <div class="pkg-card-icon"><i class="bi bi-moon-stars"></i></div>
              <h3 class="pkg-card-title">One Night Getaway</h3>
              <p class="pkg-card-duration"><i class="bi bi-clock me-1"></i>1 Night</p>
              <p class="pkg-card-desc">Arrive, unwind, wake up to the coast. The ideal short escape from everyday life.</p>
              <a href="packages.php#one-night" class="btn btn-pkg-primary" id="pkgOneNightBtn">Explore Package</a>
            </article>

            <article class="pkg-card" data-reveal="up" data-reveal-delay="200">
              <div class="pkg-card-icon"><i class="bi bi-calendar2-week"></i></div>
              <h3 class="pkg-card-title">Weekend Escape</h3>
              <p class="pkg-card-duration"><i class="bi bi-clock me-1"></i>2 Nights</p>
              <p class="pkg-card-desc">Two full days of beaches, surf and tropical living. The perfect long weekend.</p>
              <a href="packages.php#weekend" class="btn btn-pkg" id="pkgWeekendBtn">Explore Package</a>
            </article>

            <article class="pkg-card" data-reveal="up" data-reveal-delay="300">
              <div class="pkg-card-icon"><i class="bi bi-tropical-storm"></i></div>
              <h3 class="pkg-card-title">Slow Island Stay</h3>
              <p class="pkg-card-duration"><i class="bi bi-clock me-1"></i>3+ Nights</p>
              <p class="pkg-card-desc">Linger longer. Explore deeper. The full south coast slow-travel experience.</p>
              <a href="packages.php#slow-stay" class="btn btn-pkg" id="pkgSlowBtn">Explore Package</a>
            </article>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="packages-wave-bottom" aria-hidden="true">
      <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#F7F8FA"/>
      </svg>
    </div>
  </section>

  <!-- ===== EXPLORE HIRIKETIYA ===== -->
  <section class="explore-section" id="explore-hiriketiya" aria-label="Explore Hiriketiya and the south coast">
    <div class="container">
      <div class="row align-items-center gy-5">
        <div class="col-lg-6" data-reveal="left">
          <div class="explore-image-wrap">
            <img src="assets/images/explore/Surfer_carving_ocean_barrel_2K_202607210258.jpg"
                 alt="Surfer carving through an ocean barrel wave at Hiriketiya"
                 class="explore-img" loading="lazy">
            <div class="explore-img-badge"><i class="bi bi-geo-alt-fill me-1"></i>Hiriketiya, Sri Lanka</div>
          </div>
        </div>
        <div class="col-lg-6" data-reveal="right">
          <div class="explore-content">
            <p class="section-eyebrow-dark">Explore the South Coast</p>
            <h2 class="section-heading-dark explore-heading">Beach Days, Surf Sessions &amp; Slow Mornings.</h2>
            <p class="explore-text">Spend your days at the beach, try surfing, discover local cafes, explore nearby coastal attractions and enjoy the relaxed rhythm of Hiriketiya. The south coast is yours to discover.</p>
            <div class="explore-chips" role="list" aria-label="Nearby destinations">
              <span class="explore-chip" role="listitem"><i class="bi bi-water me-1"></i>Hiriketiya Beach</span>
              <span class="explore-chip" role="listitem"><i class="bi bi-water me-1"></i>Dickwella Beach</span>
              <span class="explore-chip" role="listitem"><i class="bi bi-water me-1"></i>Blue Beach Island</span>
              <span class="explore-chip" role="listitem"><i class="bi bi-cup-hot me-1"></i>Local Cafes</span>
            </div>
            <a href="explore.php" class="btn btn-explore-cta" id="exploreNearbyBtn">Explore Nearby <i class="bi bi-arrow-right ms-2"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== AMENITIES STRIP ===== -->
  <section class="amenities-strip" id="amenities-strip" aria-label="Denvonbay amenities">
    <div class="container">
      <div class="amenities-strip-inner">
        <div class="amenity-item" data-reveal="up" data-reveal-delay="0">
          <div class="amenity-icon-wrap"><i class="bi bi-wifi" aria-hidden="true"></i></div>
          <span class="amenity-label">High-Speed Wi-Fi</span>
        </div>
        <div class="amenity-divider" aria-hidden="true"></div>
        <div class="amenity-item" data-reveal="up" data-reveal-delay="80">
          <div class="amenity-icon-wrap"><i class="bi bi-cup-hot" aria-hidden="true"></i></div>
          <span class="amenity-label">Breakfast Available</span>
        </div>
        <div class="amenity-divider" aria-hidden="true"></div>
        <div class="amenity-item" data-reveal="up" data-reveal-delay="160">
          <div class="amenity-icon-wrap"><i class="bi bi-house-heart" aria-hidden="true"></i></div>
          <span class="amenity-label">Comfortable Rooms</span>
        </div>
        <div class="amenity-divider" aria-hidden="true"></div>
        <div class="amenity-item" data-reveal="up" data-reveal-delay="240">
          <div class="amenity-icon-wrap"><i class="bi bi-calendar2-check" aria-hidden="true"></i></div>
          <span class="amenity-label">Flexible Packages</span>
        </div>
        <div class="amenity-divider" aria-hidden="true"></div>
        <div class="amenity-item" data-reveal="up" data-reveal-delay="320">
          <div class="amenity-icon-wrap"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i></div>
          <span class="amenity-label">Prime Location</span>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== TESTIMONIALS ===== -->
  <section class="testimonials-section" id="testimonials" aria-label="Guest testimonials">
    <div class="container">
      <div class="section-header text-center" data-reveal="up">
        <p class="section-eyebrow-dark">Guest Reviews</p>
        <h2 class="section-heading-dark">Loved by Travelers</h2>
        <p class="section-subtext-dark">Small Stay. Big Memories.</p>
      </div>
      <div class="row gy-4 testimonials-grid">
        <?php if (!empty($featuredReviews)): ?>
          <?php foreach ($featuredReviews as $rIdx => $rev): 
            $rDelay = $rIdx * 150;
            $rFeatured = ($rIdx === 1) ? 'testi-card testi-card--featured' : 'testi-card';
          ?>
            <div class="col-lg-4 col-md-6" data-reveal="up" data-reveal-delay="<?= $rDelay ?>">
              <article class="<?= $rFeatured ?>">
                <div class="testi-quote-mark" aria-hidden="true">&ldquo;</div>
                <blockquote class="testi-text"><?= e($rev['comment']) ?></blockquote>
                <footer class="testi-footer">
                  <div class="testi-stars" aria-label="<?= (int)$rev['rating'] ?> out of 5 stars">
                    <?php for ($s = 1; $s <= 5; $s++): ?>
                      <i class="bi bi-star<?= $s <= $rev['rating'] ? '-fill' : '' ?>"></i>
                    <?php endfor; ?>
                  </div>
                  <p class="testi-author"><?= e($rev['guest_name']) ?></p>
                  <?php if (!empty($rev['location'])): ?>
                    <p class="testi-location"><i class="bi bi-geo-alt me-1"></i><?= e($rev['location']) ?></p>
                  <?php endif; ?>
                </footer>
              </article>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="col-lg-4 col-md-6" data-reveal="up" data-reveal-delay="0">
            <article class="testi-card">
              <div class="testi-quote-mark" aria-hidden="true">&ldquo;</div>
              <blockquote class="testi-text">Absolutely loved our stay at Denvonbay. The location is perfect - just minutes from Hiriketiya beach. The room was clean, cozy and had everything we needed. Highly recommend for anyone visiting the south coast.</blockquote>
              <footer class="testi-footer">
                <div class="testi-stars" aria-label="5 out of 5 stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="testi-author">Sophie &amp; Liam</p>
                <p class="testi-location"><i class="bi bi-geo-alt me-1"></i>Melbourne, Australia</p>
              </footer>
            </article>
          </div>

          <div class="col-lg-4 col-md-6" data-reveal="up" data-reveal-delay="150">
            <article class="testi-card testi-card--featured">
              <div class="testi-quote-mark" aria-hidden="true">&ldquo;</div>
              <blockquote class="testi-text">We came for two nights and ended up staying four. The vibe is so relaxed and the team genuinely looked after us. It felt like a home away from home. Perfect for a surf trip or just slowing down.</blockquote>
              <footer class="testi-footer">
                <div class="testi-stars" aria-label="5 out of 5 stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="testi-author">Marco R.</p>
                <p class="testi-location"><i class="bi bi-geo-alt me-1"></i>Milan, Italy</p>
              </footer>
            </article>
          </div>

          <div class="col-lg-4 col-md-6" data-reveal="up" data-reveal-delay="300">
            <article class="testi-card">
              <div class="testi-quote-mark" aria-hidden="true">&ldquo;</div>
              <blockquote class="testi-text">Great value, great location and great atmosphere. Only 5 rooms means it never feels crowded. Woke up to beautiful tropical mornings every day. Will definitely be back next season.</blockquote>
              <footer class="testi-footer">
                <div class="testi-stars" aria-label="5 out of 5 stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="testi-author">Elena K.</p>
                <p class="testi-location"><i class="bi bi-geo-alt me-1"></i>Berlin, Germany</p>
              </footer>
            </article>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ===== FINAL CTA ===== -->
  <section class="final-cta-section" id="final-cta" aria-label="Book your stay at Denvonbay">
    <div class="container">
      <div class="final-cta-inner" data-reveal="up">
        <p class="final-cta-eyebrow"><i class="bi bi-water me-2"></i>Hiriketiya Awaits</p>
        <h2 class="final-cta-heading">Your Hiriketiya Stay<br><span class="final-cta-accent">Starts Here.</span></h2>
        <p class="final-cta-text">Choose your room, find the package that suits your trip, and make Denvonbay part of your Sri Lankan adventure.</p>
        <div class="final-cta-buttons">
          <a href="booking.php" class="btn btn-cta-primary" id="finalCtaCheckBtn"><i class="bi bi-calendar2-check me-2"></i>Check Availability</a>
          <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $whatsappNumber) ?>" target="_blank" rel="noopener" class="btn btn-cta-whatsapp" id="finalCtaWhatsappBtn" aria-label="Book via WhatsApp"><i class="bi bi-whatsapp me-2"></i>Book via WhatsApp</a>
        </div>
      </div>
    </div>
  </section>

</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Scripts -->
<script src="assets/js/common.js"></script>
<script src="assets/js/home.js"></script>

</body>
</html>
