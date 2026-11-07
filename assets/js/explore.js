/**
 * Denvonbay - Explore Sri Lanka JavaScript
 * -----------------------------------------
 * Destination category filters (Vanilla JS)
 * Destination detail modal with keyboard support
 * Smooth interactions and accessibility
 */

(function () {
  'use strict';

  /* ============================================================
     DESTINATION DATA
     All eight destinations from "Discover the Beauty of Sri Lanka"
     ============================================================ */
  var destinations = {
    'blue-beach': {
      title: 'Blue Beach Island',
      subtitle: 'A Hidden Island Escape Along Sri Lanka\'s Southern Coast',
      location: 'Nilwella',
      category: 'Beaches & Islands',
      image: 'assets/images/explore/dest-blue-beach-island.jpg',
      imageAlt: 'Blue Beach Island — natural sandbar and turquoise Indian Ocean waters, Nilwella, Sri Lanka',
      description: 'Blue Beach Island is one of Sri Lanka\'s most enchanting coastal secrets — a beautiful natural sandbar that emerges from the turquoise waters of the Indian Ocean near Nilwella on the southern coast. The island is surrounded by remarkable ocean scenery, rocky landscapes and the vivid colours of the Indian Ocean that give this special place its name. Visitors can walk across the natural sandbar, explore the surrounding coastline and enjoy the extraordinary beauty of this hidden gem. The scenery makes it a truly special destination for photography and peaceful coastal exploration. When sea conditions are suitable, the clear waters may also offer snorkelling opportunities.',
      highlights: [
        'Walk across the natural sandbar',
        'Beautiful Indian Ocean views',
        'Explore the surrounding coastline',
        'Snorkelling when conditions permit',
        'Coastal and sunset photography'
      ],
      tip: 'Sea conditions and sandbar accessibility can vary with the tide and season. We recommend visiting during calmer weather for the best experience. Ask us for local guidance before you go.'
    },
    'turtle-view': {
      title: 'Turtle View Point',
      subtitle: 'A Special Encounter with Marine Life',
      location: 'Hiriketiya / Dickwella',
      category: 'Nature & Wildlife',
      image: 'assets/images/explore/dest-turtle-view-point.jpg',
      imageAlt: 'Turtle View Point — coastal scenery along the southern Sri Lanka shoreline near Dickwella',
      description: 'Turtle View Point is a beautiful coastal location near Hiriketiya and Dickwella where the calm southern ocean waters create an environment in which sea turtles may be observed swimming in their natural habitat. The point offers lovely coastal scenery, refreshing swimming when conditions allow, and the possibility of witnessing these magnificent marine creatures in the sea around you. The area\'s natural beauty — with its clear waters, rocky outcrops and ocean views — makes it a rewarding destination even when turtle sightings are not guaranteed.',
      highlights: [
        'Potential turtle sightings in natural habitat',
        'Swimming depending on sea conditions',
        'Snorkelling when conditions are suitable',
        'Beautiful coastal scenery',
        'Marine wildlife observation'
      ],
      tip: 'Please observe sea turtles from a respectful distance. Never touch, feed or disturb them. Wildlife sightings are never guaranteed and depend entirely on natural conditions.'
    },
    'wewurukannala': {
      title: 'Wewurukannala Temple',
      subtitle: 'Discover Sri Lanka\'s Spiritual Heritage',
      location: 'Dickwella',
      category: 'Culture & Heritage',
      image: 'assets/images/explore/dest-wewurukannala-temple.jpg',
      imageAlt: 'Wewurukannala Vihara Temple — Buddhist heritage and large seated Buddha statue in Dickwella, Sri Lanka',
      description: 'Wewurukannala Vihara is one of the most significant and visually impressive Buddhist temples on Sri Lanka\'s southern coast. The temple is home to an approximately 160-foot seated Buddha statue — one of the largest in Sri Lanka — and an outstanding collection of traditional Buddhist murals, sculptures and religious art that narrate stories of Buddhist teaching. Visitors can explore the temple complex, view the remarkable artwork and walk through the famous Tunnel of Hell, which depicts scenes of Buddhist teachings on moral consequence. The temple also contains a historic mechanical clock. This is a place of active religious worship and a living cultural monument of great importance to the local community and to Sri Lankan heritage.',
      highlights: [
        'Approximately 160-foot seated Buddha statue',
        'Traditional murals and sculptures',
        'The famous Tunnel of Hell',
        'Historic mechanical clock',
        'Buddhist cultural and spiritual heritage'
      ],
      tip: 'Wewurukannala is an active place of worship. Please dress respectfully — shoulders and knees should be covered. Remove footwear before entering temple buildings. Behave quietly and respectfully throughout your visit.'
    },
    'hummanaya': {
      title: 'Hummanaya Blow Hole',
      subtitle: 'Witness the Incredible Power of the Indian Ocean',
      location: 'Kudawella',
      category: 'Nature & Wildlife',
      image: 'assets/images/explore/dest-hummanaya-blowhole.jpg',
      imageAlt: 'Hummanaya Blow Hole — powerful Indian Ocean seawater eruptions through natural rock formation at Kudawella',
      description: 'The Hummanaya Blow Hole at Kudawella is one of Sri Lanka\'s most dramatic natural coastal attractions and one of the largest blowholes in Asia. When ocean waves surge through an underwater cave system beneath the rocks, seawater is forced upward through a natural opening, erupting in spectacular jets that can reach impressive heights. The sight and sound of this geological phenomenon — set against the backdrop of the southern Indian Ocean — is an extraordinary experience. The surrounding coastal scenery, with its volcanic rock formations, crashing waves and panoramic ocean views, makes this a memorable destination for nature lovers and photographers.',
      highlights: [
        'Spectacular seawater eruptions through natural rock',
        'Unique geological coastal formation',
        'Beautiful southern coastal scenery',
        'Panoramic Indian Ocean views',
        'Photography opportunities'
      ],
      tip: 'Eruption height and frequency depend entirely on sea conditions and weather. Please remain within designated viewing areas at all times and follow any safety notices. The rocks can be slippery — take care near the edges.'
    },
    'dickwella-beach': {
      title: 'Dickwella Beach',
      subtitle: 'A Peaceful Coastal Paradise',
      location: 'Southern Province',
      category: 'Beaches & Islands',
      image: 'assets/images/explore/dest-dickwella-beach.jpg',
      imageAlt: 'Dickwella Beach — golden sandy shores and Indian Ocean views on Sri Lanka\'s southern coast',
      description: 'Dickwella Beach is a beautiful stretch of golden sandy shoreline along Sri Lanka\'s Southern Province, offering a peaceful coastal atmosphere away from the crowds. The beach\'s expansive golden sands, clear Indian Ocean waters and scenic coastal surroundings make it a wonderful destination for relaxed beach walks, swimming and simply enjoying the warmth and beauty of a tropical Sri Lankan shoreline. The surrounding area has a genuinely unhurried, local character that makes it a refreshing escape from busier tourist spots. It is an ideal destination for those who want to experience the natural beauty of the south coast at their own pace.',
      highlights: [
        'Expansive golden sandy shores',
        'Beautiful Indian Ocean views',
        'Peaceful beach walks',
        'Photography and coastal exploration',
        'Relaxed southern coastal atmosphere'
      ],
      tip: null
    },
    'rekawa': {
      title: 'Rekawa Turtle Beach',
      subtitle: 'Discover the World of Sea Turtle Conservation',
      location: 'Tangalle',
      category: 'Nature & Wildlife',
      image: 'assets/images/explore/dest-rekawa-turtle-beach.jpg',
      imageAlt: 'Rekawa Turtle Beach — natural nesting beach and sea turtle conservation near Tangalle, Sri Lanka',
      description: 'Rekawa Turtle Beach near Tangalle is one of Sri Lanka\'s most important sea turtle nesting sites and a destination for responsible marine conservation tourism. Five species of sea turtle nest on this pristine stretch of natural beach, making it a genuinely special place for wildlife observation and environmental education. Guided nighttime turtle watching visits allow visitors to witness nesting or hatching sea turtles, accompanied by knowledgeable local guides who help ensure the safety and wellbeing of both visitors and turtles. The experience offers a rare and meaningful connection with one of nature\'s most remarkable marine creatures and the conservation efforts that protect them.',
      highlights: [
        'Guided nighttime turtle watching visits',
        'Sea turtle conservation education',
        'Natural nesting environment',
        'Wildlife education with local guides',
        'Pristine natural coastal setting'
      ],
      tip: 'Turtle sightings are never guaranteed and depend entirely on natural nesting activity. Always follow the instructions of your qualified local guide. Flash photography and bright lights must be avoided near nesting areas, as they disturb and disorient turtles. Never touch turtles, hatchlings or nests.'
    },
    'ella': {
      title: 'Ella',
      subtitle: 'Where Mountains, Mist and Adventure Meet',
      location: 'Sri Lanka\'s Hill Country',
      category: 'Hill Country',
      image: 'assets/images/explore/dest-ella-hill-country.jpg',
      imageAlt: 'Ella Hill Country — scenic mountain landscapes, tea plantations and the iconic Nine Arch Bridge in Sri Lanka',
      description: 'Ella is one of Sri Lanka\'s most beloved destinations — a beautiful hill-country village surrounded by misty mountain landscapes, verdant tea plantations and dramatic natural scenery. It is a longer journey from the southern coast, best approached as a dedicated day trip or an overnight adventure, but the experience is genuinely unforgettable. The iconic Nine Arch Bridge, one of the most photographed railway structures in Asia, spans a lush green valley just outside the village. Hikers can explore Little Adam\'s Peak and Ella Rock for panoramic mountain views, visit Ravana Falls and enjoy the remarkable journey through the highlands by scenic train — widely considered one of the most beautiful train rides in the world.',
      highlights: [
        'The iconic Nine Arch Bridge',
        'Little Adam\'s Peak and Ella Rock hikes',
        'Ravana Falls',
        'Scenic highland train journeys',
        'Tea plantation landscapes and mountain panoramas'
      ],
      tip: 'Ella is a longer journey from the southern coast — plan it as a full-day trip or stay overnight to make the most of the experience. The scenic train journey from Kandy to Ella is one of the world\'s most beautiful rail routes. Book train tickets in advance during peak season.'
    },
    'yala': {
      title: 'Yala National Park',
      subtitle: 'An Unforgettable Wildlife Safari',
      location: 'Southeastern Sri Lanka',
      category: 'Nature & Wildlife',
      image: 'assets/images/explore/dest-yala-national-park.jpg',
      imageAlt: 'Yala National Park — guided jeep safari through Sri Lanka\'s most celebrated wildlife reserve',
      description: 'Yala National Park is Sri Lanka\'s most visited and celebrated wildlife reserve, covering an extraordinary area of diverse ecosystems in the southeastern corner of the island. The park is home to one of the highest densities of leopards in the world, as well as Sri Lankan elephants, saltwater crocodiles, sloth bears, abundant birdlife and a remarkable variety of other wildlife. A guided jeep safari through Yala\'s landscapes — from dense jungle and open grassland to coastal lagoons — is one of the most memorable natural experiences available in Sri Lanka. As a longer journey from Denvonbay on the southern coast, Yala is best approached as a dedicated full-day excursion or an overnight stay.',
      highlights: [
        'Guided jeep safari through diverse landscapes',
        'Sri Lankan leopard habitat',
        'Elephant and crocodile sightings',
        'Exceptional birdwatching',
        'Coastal lagoons and natural landscapes'
      ],
      tip: 'Wildlife sightings, including leopards, are never guaranteed. Always follow your guide\'s instructions for your safety and the welfare of the animals. Yala requires entry through a licensed jeep and guide — independent entry is not permitted. Book your safari in advance during peak season.'
    }
  };

  /* ============================================================
     CATEGORY FILTER SYSTEM
     ============================================================ */
  var filterTabs = document.querySelectorAll('.filter-tab');
  var destGridItems = document.querySelectorAll('.dest-grid-item');
  var destEmptyState = document.getElementById('destEmptyState');

  function applyFilter(filter) {
    var items = document.querySelectorAll('.dest-grid-item');
    var visibleCount = 0;

    items.forEach(function (item) {
      var cats = (item.dataset.categories || '').split(' ');
      var show = (filter === 'all') || cats.indexOf(filter) !== -1;
      item.style.display = show ? '' : 'none';
      if (show) visibleCount++;
    });

    if (destEmptyState) {
      destEmptyState.style.display = visibleCount === 0 ? '' : 'none';
    }
  }

    if (destEmptyState) {
      destEmptyState.style.display = visibleCount === 0 ? '' : 'none';
    }
  }

  filterTabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      var filter = this.dataset.filter || 'all';

      // Update active state
      filterTabs.forEach(function (t) {
        t.classList.remove('is-active');
        t.setAttribute('aria-pressed', 'false');
      });
      this.classList.add('is-active');
      this.setAttribute('aria-pressed', 'true');

      applyFilter(filter);
    });
  });

  /* ============================================================
     DESTINATION DETAIL MODAL
     ============================================================ */
  var modalOverlay = document.getElementById('destModalOverlay');
  var modal = document.getElementById('destModal');
  var modalClose = document.getElementById('destModalClose');
  var modalHeroImg = document.getElementById('destModalHeroImg');
  var modalCategory = document.getElementById('destModalCategory');
  var modalTitle = document.getElementById('destModalTitle');
  var modalLocationSpan = document.querySelector('#destModalLocation span');
  var modalDesc = document.getElementById('destModalDesc');
  var modalHighlights = document.getElementById('destModalHighlights');
  var modalTipWrap = document.getElementById('destModalTipWrap');
  var modalTip = document.getElementById('destModalTip');

  var previouslyFocused = null;
  var isModalOpen = false;

  function openModal(destKey) {
    var data = destinations[destKey];
    if (!data || !modalOverlay) return;

    // Populate modal content
    if (modalHeroImg) {
      modalHeroImg.src = data.image;
      modalHeroImg.alt = data.imageAlt || data.title;
    }
    if (modalCategory) modalCategory.textContent = data.category;
    if (modalTitle) modalTitle.textContent = data.title;
    if (modalLocationSpan) modalLocationSpan.textContent = data.location;
    if (modalDesc) modalDesc.textContent = data.description;

    // Highlights
    if (modalHighlights) {
      modalHighlights.innerHTML = '';
      (data.highlights || []).forEach(function (hl) {
        var li = document.createElement('li');
        li.className = 'dest-highlight-item';
        li.innerHTML = '<span class="dest-highlight-dot" aria-hidden="true"></span>' + escapeHTML(hl);
        modalHighlights.appendChild(li);
      });
    }

    // Visitor tip
    if (modalTipWrap && modalTip) {
      if (data.tip) {
        modalTip.textContent = data.tip;
        modalTipWrap.style.display = '';
      } else {
        modalTipWrap.style.display = 'none';
      }
    }

    // Open
    previouslyFocused = document.activeElement;
    document.body.style.overflow = 'hidden';
    modalOverlay.classList.add('is-open');
    modalOverlay.setAttribute('aria-hidden', 'false');
    isModalOpen = true;

    // Scroll modal to top
    if (modal) modal.scrollTop = 0;

    // Focus close button
    setTimeout(function () {
      if (modalClose) modalClose.focus();
    }, 50);
  }

  function closeModal() {
    if (!modalOverlay) return;
    modalOverlay.classList.remove('is-open');
    modalOverlay.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    isModalOpen = false;

    // Restore focus
    if (previouslyFocused) {
      setTimeout(function () {
        previouslyFocused.focus();
        previouslyFocused = null;
      }, 50);
    }
  }

  // Open modal when card is clicked or Enter/Space pressed
  document.querySelectorAll('.dest-card').forEach(function (card) {
    card.addEventListener('click', function () {
      var key = this.dataset.dest;
      if (key) openModal(key);
    });

    card.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        var key = this.dataset.dest;
        if (key) openModal(key);
      }
    });
  });

  // Close button
  if (modalClose) {
    modalClose.addEventListener('click', closeModal);
  }

  // Close on overlay click (outside modal panel)
  if (modalOverlay) {
    modalOverlay.addEventListener('click', function (e) {
      if (e.target === modalOverlay) closeModal();
    });
  }

  // Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && isModalOpen) closeModal();
  });

  // Focus trap inside modal
  if (modalOverlay) {
    modalOverlay.addEventListener('keydown', function (e) {
      if (e.key !== 'Tab' || !isModalOpen) return;
      var focusable = modalOverlay.querySelectorAll(
        'button:not([disabled]), a[href], input, textarea, select, [tabindex]:not([tabindex="-1"])'
      );
      var focusableArr = Array.prototype.slice.call(focusable);
      var first = focusableArr[0];
      var last = focusableArr[focusableArr.length - 1];

      if (e.shiftKey) {
        if (document.activeElement === first) {
          e.preventDefault();
          last.focus();
        }
      } else {
        if (document.activeElement === last) {
          e.preventDefault();
          first.focus();
        }
      }
    });
  }

  /* ============================================================
     HERO SCROLL INDICATOR
     Smooth scroll to destinations section on click
     ============================================================ */
  var scrollIndicator = document.querySelector('.explore-scroll-indicator');
  if (scrollIndicator) {
    scrollIndicator.addEventListener('click', function () {
      var target = document.getElementById('explore-intro');
      if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
    scrollIndicator.style.cursor = 'pointer';
  }

  /* ============================================================
     UTILITY
     ============================================================ */
  function escapeHTML(str) {
    var d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
  }

})();

