<?php
/**
 * Denvonbay - Explore Sri Lanka
 * ------------------------------
 * Premium destination discovery guide for Sri Lanka.
 * Eight handpicked destinations from the southern coast and beyond.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

$pageTitle = 'Explore Sri Lanka | Beaches, Wildlife & Attractions | Denvonbay';
$pageDescription = "Discover Sri Lanka's beautiful beaches, Blue Beach Island, Hummanaya Blow Hole, Turtle View Point, Ella, Yala National Park and more with Denvonbay.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="keywords" content="explore Sri Lanka, Blue Beach Island, Turtle View Point, Hummanaya Blow Hole, Ella, Yala National Park, Dickwella Beach, Denvonbay">

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
    <link rel="stylesheet" href="assets/css/explore.css">
</head>
<body>

<?php include 'header.php'; ?>

<main id="main-content">

    <!-- ===== DESTINATION INTRODUCTION ===== -->
    <section class="explore-intro-section" id="explore-intro" aria-label="Discover the beauty of Sri Lanka">
        <div class="container">
            <div class="explore-intro-inner" data-reveal="up">
                <span class="explore-intro-eyebrow"><i class="bi bi-compass me-1" aria-hidden="true"></i>Destination Guide</span>
                <h1 class="explore-intro-heading">Discover the Beauty of Sri Lanka</h1>
                <p class="explore-intro-text mb-0">From tropical beaches and hidden coastal escapes to ancient temples, wildlife adventures and misty hill-country landscapes. Discover quiet beaches, remarkable natural landmarks, Sri Lankan culture and unforgettable journeys through the island — beginning with the beautiful southern coast around Denvonbay.</p>
            </div>
        </div>
    </section>

    <!-- ===== SECTION C: CATEGORY FILTERS ===== -->
    <section class="explore-filters-section" aria-label="Filter destinations by category">
        <div class="container">
            <div class="filter-tabs" role="group" aria-label="Destination category filters" id="filterTabs">
                <button type="button" class="filter-tab is-active" data-filter="all" aria-pressed="true">
                    <i class="bi bi-grid-3x3-gap me-1" aria-hidden="true"></i>All Destinations
                </button>
                <button type="button" class="filter-tab" data-filter="beaches" aria-pressed="false">
                    <i class="bi bi-water me-1" aria-hidden="true"></i>Beaches &amp; Islands
                </button>
                <button type="button" class="filter-tab" data-filter="nature" aria-pressed="false">
                    <i class="bi bi-tree me-1" aria-hidden="true"></i>Nature &amp; Wildlife
                </button>
                <button type="button" class="filter-tab" data-filter="culture" aria-pressed="false">
                    <i class="bi bi-building me-1" aria-hidden="true"></i>Culture &amp; Heritage
                </button>
                <button type="button" class="filter-tab" data-filter="hills" aria-pressed="false">
                    <i class="bi bi-cloud-sun me-1" aria-hidden="true"></i>Hill Country
                </button>
            </div>
        </div>
    </section>

    <!-- ===== SECTION D: DESTINATIONS GRID ===== -->
    <section class="destinations-section" id="destinations" aria-label="Destinations to explore">
        <div class="container">

            <div class="destinations-grid" id="destinationsGrid">

                <!-- DESTINATION 01: Blue Beach Island -->
                <div class="dest-grid-item" data-categories="all beaches" data-reveal="up" data-reveal-delay="0">
                    <a href="destination-details.php?slug=blue-beach" class="dest-card" aria-label="Explore Blue Beach Island">
                        <div class="dest-card-image-wrap">
                            <img
                                src="assets/images/explore/dest-blue-beach-island.jpg"
                                alt="Blue Beach Island — pristine natural sandbar and turquoise waters at Nilwella, Sri Lanka"
                                loading="lazy"
                            >
                            <span class="dest-card-category-badge">Beaches &amp; Islands</span>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Nilwella</div>
                            <h2 class="dest-card-title">Blue Beach Island</h2>
                            <p class="dest-card-desc">A hidden natural sandbar emerging from turquoise Indian Ocean waters — walk across the sandbar and explore coastal scenery.</p>
                            <div class="dest-card-cta">
                                <span class="dest-card-link">Explore Destination</span>
                                <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- DESTINATION 02: Turtle View Point -->
                <div class="dest-grid-item" data-categories="all nature" data-reveal="up" data-reveal-delay="80">
                    <a href="destination-details.php?slug=turtle-view" class="dest-card" aria-label="Explore Turtle View Point">
                        <div class="dest-card-image-wrap">
                            <img
                                src="assets/images/explore/dest-turtle-view-point.jpg"
                                alt="Turtle View Point — coastal scenery and swimming sea turtles near Hiriketiya Dickwella"
                                loading="lazy"
                            >
                            <span class="dest-card-category-badge">Nature &amp; Wildlife</span>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Hiriketiya / Dickwella</div>
                            <h2 class="dest-card-title">Turtle View Point</h2>
                            <p class="dest-card-desc">A special encounter with marine life where sea turtles may be observed swimming in their natural coastal habitat.</p>
                            <div class="dest-card-cta">
                                <span class="dest-card-link">Explore Destination</span>
                                <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- DESTINATION 03: Wewurukannala Temple -->
                <div class="dest-grid-item" data-categories="all culture" data-reveal="up" data-reveal-delay="160">
                    <a href="destination-details.php?slug=wewurukannala" class="dest-card" aria-label="Explore Wewurukannala Temple">
                        <div class="dest-card-image-wrap">
                            <img
                                src="assets/images/explore/dest-wewurukannala-temple.jpg"
                                alt="Wewurukannala Temple — 160-foot seated Buddha statue and sacred Buddhist artwork in Dickwella"
                                loading="lazy"
                            >
                            <span class="dest-card-category-badge">Culture &amp; Heritage</span>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Dickwella</div>
                            <h2 class="dest-card-title">Wewurukannala Temple</h2>
                            <p class="dest-card-desc">Discover Sri Lanka's spiritual heritage featuring an approximately 160-foot seated Buddha statue and traditional sacred murals.</p>
                            <div class="dest-card-cta">
                                <span class="dest-card-link">Explore Destination</span>
                                <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- DESTINATION 04: Hummanaya Blow Hole -->
                <div class="dest-grid-item" data-categories="all nature" data-reveal="up" data-reveal-delay="0">
                    <a href="destination-details.php?slug=hummanaya" class="dest-card" aria-label="Explore Hummanaya Blow Hole">
                        <div class="dest-card-image-wrap">
                            <img
                                src="assets/images/explore/dest-hummanaya-blowhole.jpg"
                                alt="Hummanaya Blow Hole — powerful seawater geyser eruption through rock fissure at Kudawella"
                                loading="lazy"
                            >
                            <span class="dest-card-category-badge">Nature &amp; Wildlife</span>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Kudawella</div>
                            <h2 class="dest-card-title">Hummanaya Blow Hole</h2>
                            <p class="dest-card-desc">Witness the spectacular power of the Indian Ocean as seawater erupts through a natural rock formation in a remarkable coastal display.</p>
                            <div class="dest-card-cta">
                                <span class="dest-card-link">Explore Destination</span>
                                <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- DESTINATION 05: Dickwella Beach -->
                <div class="dest-grid-item" data-categories="all beaches" data-reveal="up" data-reveal-delay="80">
                    <a href="destination-details.php?slug=dickwella-beach" class="dest-card" aria-label="Explore Dickwella Beach">
                        <div class="dest-card-image-wrap">
                            <img
                                src="assets/images/explore/dest-dickwella-beach.jpg"
                                alt="Dickwella Beach — expansive golden sands and tropical sunset views in Southern Province"
                                loading="lazy"
                            >
                            <span class="dest-card-category-badge">Beaches &amp; Islands</span>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Southern Province</div>
                            <h2 class="dest-card-title">Dickwella Beach</h2>
                            <p class="dest-card-desc">A peaceful coastal paradise of golden sandy shores, beautiful ocean views and the relaxed, unhurried atmosphere of Sri Lanka's south coast.</p>
                            <div class="dest-card-cta">
                                <span class="dest-card-link">Explore Destination</span>
                                <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- DESTINATION 06: Rekawa Turtle Beach -->
                <div class="dest-grid-item" data-categories="all nature" data-reveal="up" data-reveal-delay="160">
                    <a href="destination-details.php?slug=rekawa" class="dest-card" aria-label="Explore Rekawa Turtle Beach">
                        <div class="dest-card-image-wrap">
                            <img
                                src="assets/images/explore/dest-rekawa-turtle-beach.jpg"
                                alt="Rekawa Turtle Beach — natural sea turtle conservation and nesting beach in Tangalle"
                                loading="lazy"
                            >
                            <span class="dest-card-category-badge">Nature &amp; Wildlife</span>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Tangalle</div>
                            <h2 class="dest-card-title">Rekawa Turtle Beach</h2>
                            <p class="dest-card-desc">Discover the world of sea turtle conservation at one of Sri Lanka's most important natural nesting beaches, guided by local experts.</p>
                            <div class="dest-card-cta">
                                <span class="dest-card-link">Explore Destination</span>
                                <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- DESTINATION 07: Ella -->
                <div class="dest-grid-item" data-categories="all hills" data-reveal="up" data-reveal-delay="0">
                    <a href="destination-details.php?slug=ella" class="dest-card" aria-label="Explore Ella Hill Country">
                        <div class="dest-card-image-wrap">
                            <img
                                src="assets/images/explore/dest-ella-hill-country.jpg"
                                alt="Ella Hill Country — iconic Nine Arch Bridge surrounded by lush tea hills and jungle"
                                loading="lazy"
                            >
                            <span class="dest-card-category-badge">Hill Country</span>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Sri Lanka's Hill Country</div>
                            <h2 class="dest-card-title">Ella</h2>
                            <p class="dest-card-desc">Where mountains, mist and adventure meet — discover the iconic Nine Arch Bridge, scenic train journeys, tea plantations and hiking trails.</p>
                            <div class="dest-card-cta">
                                <span class="dest-card-link">Explore Destination</span>
                                <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- DESTINATION 08: Yala National Park -->
                <div class="dest-grid-item" data-categories="all nature" data-reveal="up" data-reveal-delay="80">
                    <a href="destination-details.php?slug=yala" class="dest-card" aria-label="Explore Yala National Park">
                        <div class="dest-card-image-wrap">
                            <img
                                src="assets/images/explore/dest-yala-national-park.jpg"
                                alt="Yala National Park — Sri Lankan leopard in its natural wilderness habitat"
                                loading="lazy"
                            >
                            <span class="dest-card-category-badge">Nature &amp; Wildlife</span>
                        </div>
                        <div class="dest-card-body">
                            <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> Southeastern Sri Lanka</div>
                            <h2 class="dest-card-title">Yala National Park</h2>
                            <p class="dest-card-desc">An unforgettable wildlife safari excursion home to leopards, elephants, crocodiles and rich birdlife in pristine national wilderness.</p>
                            <div class="dest-card-cta">
                                <span class="dest-card-link">Explore Destination</span>
                                <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>

            </div><!-- /destinations-grid -->

            <!-- Empty State (shown when filters return no results) -->
            <div class="dest-empty-state" id="destEmptyState" style="display:none;" role="status" aria-live="polite">
                <i class="bi bi-compass" aria-hidden="true"></i>
                <p>No destinations match this filter. Try selecting a different category.</p>
            </div>

        </div>
    </section>

    <!-- ===== FINAL CTA: EXPLORE SRI LANKA. STAY AT DENVONBAY. ===== -->
    <section class="explore-cta-section" id="explore-cta" aria-label="Book your stay at Denvonbay">
        <div class="container">
            <div class="explore-cta-inner" data-reveal="up">
                <span class="explore-cta-eyebrow"><i class="bi bi-water me-2" aria-hidden="true"></i>Your Coastal Base</span>
                <h2 class="explore-cta-heading">Explore Sri Lanka.<br>Stay at Denvonbay.</h2>
                <p class="explore-cta-text">Make Denvonbay your coastal base while discovering the natural beauty and unforgettable experiences of Sri Lanka. Ask us about exploring the area.</p>
                <div class="explore-cta-buttons">
                    <a href="booking.php" class="btn-cta-book" id="exploreCtaBookBtn">
                        <i class="bi bi-calendar2-check" aria-hidden="true"></i>Book Your Stay
                    </a>
                    <a href="contact.php" class="btn-cta-contact-outline" id="exploreCtaContactBtn">
                        <i class="bi bi-chat-dots" aria-hidden="true"></i>Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- ===== DESTINATION DETAIL MODAL ===== -->
<div class="dest-modal-overlay" id="destModalOverlay" role="dialog" aria-modal="true" aria-labelledby="destModalTitle" aria-hidden="true">
    <div class="dest-modal" id="destModal">
        <div class="dest-modal-hero" id="destModalHero">
            <img src="" alt="" id="destModalHeroImg" loading="lazy">
            <div class="dest-modal-hero-overlay"></div>
            <button class="dest-modal-close" id="destModalClose" aria-label="Close destination detail">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>
            <div class="dest-modal-hero-info">
                <span class="dest-modal-category" id="destModalCategory"></span>
                <h2 class="dest-modal-title" id="destModalTitle"></h2>
                <p class="dest-modal-location" id="destModalLocation">
                    <i class="bi bi-geo-alt-fill me-1" aria-hidden="true"></i><span></span>
                </p>
            </div>
        </div>

        <div class="dest-modal-body">
            <p class="dest-modal-desc" id="destModalDesc"></p>

            <div class="dest-highlights" id="destModalHighlightsWrap">
                <h3 class="dest-highlights-title">Highlights</h3>
                <ul class="dest-highlights-list" id="destModalHighlights" aria-label="Destination highlights"></ul>
            </div>

            <div class="dest-modal-tip" id="destModalTipWrap" style="display:none;">
                <div class="dest-modal-tip-title"><i class="bi bi-lightbulb me-2" aria-hidden="true"></i>Visitor Guidance</div>
                <p class="dest-modal-tip-text" id="destModalTip"></p>
            </div>

            <div class="dest-modal-actions">
                <a href="booking.php" class="btn-modal-book" id="destModalBookBtn">
                    <i class="bi bi-calendar2-check" aria-hidden="true"></i>Book Your Stay
                </a>
                <a href="contact.php" class="btn-modal-contact" id="destModalContactBtn">
                    <i class="bi bi-chat-dots" aria-hidden="true"></i>Ask Us About This Area
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Common JS -->
<script src="assets/js/common.js?v=<?= file_exists('assets/js/common.js') ? filemtime('assets/js/common.js') : '2.0' ?>"></script>
<!-- Explore JS -->
<script src="assets/js/explore.js?v=<?= file_exists('assets/js/explore.js') ? filemtime('assets/js/explore.js') : '2.0' ?>"></script>

<script>
/* Immediate inline filter engine for 100% reliable category switching */
(function() {
    function initFilters() {
        var tabs = document.querySelectorAll('.filter-tab');
        var items = document.querySelectorAll('.dest-grid-item');
        var empty = document.getElementById('destEmptyState');
        if (!tabs.length || !items.length) return;

        tabs.forEach(function(tab) {
            tab.addEventListener('click', function(e) {
                if (e) e.preventDefault();
                var filter = this.getAttribute('data-filter') || 'all';

                tabs.forEach(function(t) {
                    t.classList.remove('is-active');
                    t.setAttribute('aria-pressed', 'false');
                });
                this.classList.add('is-active');
                this.setAttribute('aria-pressed', 'true');

                var visibleCount = 0;
                items.forEach(function(item) {
                    var cats = (item.getAttribute('data-categories') || '').toLowerCase().split(/\s+/);
                    var match = (filter === 'all') || (cats.indexOf(filter) !== -1);
                    if (match) {
                        item.style.display = 'flex';
                        item.classList.add('is-visible');
                        item.style.opacity = '1';
                        item.style.transform = 'translate(0, 0)';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (empty) {
                    empty.style.display = (visibleCount === 0) ? 'block' : 'none';
                }
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFilters);
    } else {
        initFilters();
    }
})();
</script>

</body>
</html>
