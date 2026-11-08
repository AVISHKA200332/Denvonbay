<?php
/**
 * Denvonbay - Destination Details
 * -------------------------------
 * In-depth destination guide for Sri Lanka's southern coast & beyond.
 * Authentic information from the "Discover the Beauty of Sri Lanka" experience guide.
 */

require_once 'config/database.php';
require_once 'includes/functions.php';

// All 8 destinations with comprehensive, authentic data
$destinations = [
    'blue-beach' => [
        'id'          => 'blue-beach',
        'title'       => 'Blue Beach Island',
        'subtitle'    => 'A Hidden Island Escape Along Sri Lanka\'s Southern Coast',
        'location'    => 'Nilwella',
        'region'      => 'Southern Province',
        'category'    => 'Beaches & Islands',
        'category_slug' => 'beaches',
        'image'       => 'assets/images/explore/dest-blue-beach-island.jpg',
        'image_alt'   => 'Blue Beach Island — natural sandbar and turquoise Indian Ocean waters at Nilwella, Sri Lanka',
        'distance'    => '15 mins from Denvonbay',
        'travel_time' => '15-minute tuk-tuk or scooter ride',
        'best_time'   => 'Early morning or late afternoon (calmer tides & golden light)',
        'ideal_for'   => 'Coastal exploration, photography, tranquil swimming & snorkelling',
        'duration'    => '2 to 3 hours',
        'summary'     => 'A hidden natural sandbar emerging from turquoise Indian Ocean waters — walk across the sandbar and explore coastal scenery.',
        'description' => 'Blue Beach Island is one of Sri Lanka\'s most enchanting coastal secrets — a beautiful natural sandbar that emerges from the turquoise waters of the Indian Ocean near Nilwella on the southern coast. The island is surrounded by remarkable ocean scenery, rocky landscapes and the vivid colours of the Indian Ocean that give this special place its name.

Visitors can walk across the natural sandbar, explore the surrounding coastline and enjoy the extraordinary beauty of this hidden gem. The scenery makes it a truly special destination for photography and peaceful coastal exploration. When sea conditions are suitable, the clear waters may also offer rewarding snorkelling opportunities around the protective rocky shelves.',
        'highlights'  => [
            'Walk across the natural sandbar linking mainland to island',
            'Spectacular turquoise and sapphire Indian Ocean panoramas',
            'Explore pristine rocky headlands and hidden coastal coves',
            'Snorkelling in crystal clear waters when tides are calm',
            'Unrivalled coastal and sunset photography opportunities',
            'Peaceful coastal ambiance far removed from busy tourist spots'
        ],
        'tip'         => 'Sea conditions and sandbar accessibility vary with the tide and season. We recommend visiting during calmer weather and lower tides for the best walking and swimming experience. Speak with our team at Denvonbay before leaving so we can advise on the day\'s conditions.',
        'host_note'   => 'We can arrange a reliable local tuk-tuk for you right after breakfast at Denvonbay. Pack reef-safe sunscreen, a dry bag for cameras, and water shoes for the rocky sections.',
        'gallery'     => [
            [
                'url'     => 'assets/images/explore/gallery/blue-beach-1.jpg',
                'title'   => 'Sandbar & Coastal Panorama',
                'caption' => 'Aerial view of Blue Beach Island and its natural connecting sandbar at Nilwella.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/blue-beach-2.jpg',
                'title'   => 'Turquoise Ocean Waters',
                'caption' => 'The vivid sapphire and turquoise hues of the Indian Ocean surrounding Nilwella.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/blue-beach-3.jpg',
                'title'   => 'Island Shoreline & Rocky Headland',
                'caption' => 'Rocky headlands and tranquil coastal coves ideal for walking and photography.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/blue-beach-4.jpg',
                'title'   => 'Nilwella Coastal Sweep',
                'caption' => 'Sweeping coastal outlook across the bay and protective rocky reefs.'
            ]
        ]
    ],

    'turtle-view' => [
        'id'          => 'turtle-view',
        'title'       => 'Turtle View Point',
        'subtitle'    => 'A Special Encounter with Marine Life in Their Natural Habitat',
        'location'    => 'Hiriketiya / Dickwella',
        'region'      => 'Southern Province',
        'category'    => 'Nature & Wildlife',
        'category_slug' => 'nature',
        'image'       => 'assets/images/explore/dest-turtle-view-point.jpg',
        'image_alt'   => 'Turtle View Point — coastal scenery and swimming sea turtles near Hiriketiya, Sri Lanka',
        'distance'    => '5 mins walk from Denvonbay',
        'travel_time' => '5-minute stroll along the coast',
        'best_time'   => 'Morning between 7:30 AM and 10:30 AM',
        'ideal_for'   => 'Marine wildlife lovers, swimmers, nature photographers',
        'duration'    => '1 to 2 hours',
        'summary'     => 'A special encounter with marine life where sea turtles may be observed swimming in their natural coastal habitat.',
        'description' => 'Turtle View Point is a scenic coastal location near Hiriketiya and Dickwella where calm southern ocean currents create a haven in which sea turtles may regularly be observed swimming and feeding in their natural coastal habitat.

The point offers lovely panoramic ocean scenery, refreshing swimming when conditions allow, and the possibility of witnessing these magnificent marine creatures grazing peacefully in the shallow bay. The area\'s natural coastal beauty — with rocky outcrops, palm-fringed cliffs and clear ocean views — makes it a rewarding stop even when turtle sightings are not guaranteed on a given day.',
        'highlights'  => [
            'Regular sea turtle sightings in their natural wild habitat',
            'Calm shallow waters suitable for swimming in good conditions',
            'Snorkelling with marine fish along the bay\'s rocky reef edge',
            'Elevated cliffside vantage points for coastal photography',
            'Short scenic walk directly from Denvonbay along Hiriketiya',
            'Gentle, responsible eco-tourism encounter without cages or enclosures'
        ],
        'tip'         => 'Please observe sea turtles from a respectful distance (at least 3-4 meters). Never touch, chase, feed or disturb them while swimming or surfacing for air. Wild sightings depend entirely on sea conditions and tide levels.',
        'host_note'   => 'Because Turtle View Point is practically on Denvonbay\'s doorstep, our guests often visit early in the morning before breakfast when the waters are calmest and the beach is wonderfully quiet.',
        'gallery'     => [
            [
                'url'     => 'assets/images/explore/gallery/turtle-view-1.jpg',
                'title'   => 'Sea Turtle Encounter',
                'caption' => 'Wild green sea turtle swimming peacefully in the shallow waters near Dickwella.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/turtle-view-2.jpg',
                'title'   => 'Hiriketiya Coastal Point',
                'caption' => 'Elevated viewpoint looking across Hiriketiya bay and rocky headlands.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/turtle-view-3.jpg',
                'title'   => 'Reef Feeding Habitat',
                'caption' => 'Sea turtle grazing naturally along the coastal coral shelves.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/turtle-view-4.jpg',
                'title'   => 'Ocean Vantage & Rocks',
                'caption' => 'Panoramic coastal scenery along the southern ocean rocks near Denvonbay.'
            ]
        ]
    ],

    'wewurukannala' => [
        'id'          => 'wewurukannala',
        'title'       => 'Wewurukannala Temple',
        'subtitle'    => 'Discover Sri Lanka\'s Spiritual & Cultural Heritage',
        'location'    => 'Dickwella',
        'region'      => 'Southern Province',
        'category'    => 'Culture & Heritage',
        'category_slug' => 'culture',
        'image'       => 'assets/images/explore/dest-wewurukannala-temple.jpg',
        'image_alt'   => 'Wewurukannala Vihara Temple — 160-foot seated Buddha statue in Dickwella, Sri Lanka',
        'distance'    => '10 mins from Denvonbay',
        'travel_time' => '10-minute tuk-tuk ride inland',
        'best_time'   => 'Morning (8:00 AM – 11:00 AM) or late afternoon',
        'ideal_for'   => 'Culture enthusiasts, history lovers, architectural photography',
        'duration'    => '1.5 to 2 hours',
        'summary'     => 'Discover Sri Lanka\'s spiritual heritage featuring an approximately 160-foot seated Buddha statue and traditional sacred murals.',
        'description' => 'Wewurukannala Vihara is one of the most significant and visually impressive Buddhist temples on Sri Lanka\'s southern coast. Dating back to the era of King Rajadhi Rajasinghe in the 18th century, the complex is home to an approximately 160-foot seated Buddha statue — one of the largest in Sri Lanka.

Visitors can explore the eight-story museum building behind the statue, view vibrant traditional murals depicting Jataka stories of the Buddha\'s previous lives, and walk through the historic "Tunnel of Hell", which portrays cautionary Buddhist moral allegories. The temple also houses a working antique mechanical clock built in the 19th century by a skilled local craftsman, which continues to chime on the hour.',
        'highlights'  => [
            'Approximately 160-foot seated Buddha statue (one of Sri Lanka\'s tallest)',
            'Rich gallery of classical southern Sri Lankan Buddhist frescoes',
            'The legendary "Tunnel of Hell" featuring moral allegory dioramas',
            'Historic 19th-century mechanical clock with moving figures',
            'Elevated panoramic views over coconut estates from the temple tower',
            'An authentic active place of Buddhist worship with peaceful chanting'
        ],
        'tip'         => 'Wewurukannala is an active place of worship. Visitors must dress respectfully: shoulders and knees must be fully covered (light sarongs work well). Please remove footwear and hats before entering temple grounds.',
        'host_note'   => 'A morning visit here pairs beautifully with an afternoon surf or relaxation session at Denvonbay. We can arrange a local driver to wait for you while you explore.',
        'gallery'     => [
            [
                'url'     => 'assets/images/explore/gallery/wewurukannala-1.jpg',
                'title'   => '160-Foot Seated Buddha',
                'caption' => 'The celebrated 160-foot seated Buddha statue rising serenely above the temple complex.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/wewurukannala-2.jpg',
                'title'   => 'Historic Temple Entrance',
                'caption' => 'Traditional entrance gateway and architecture of Wewurukannala Vihara.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/wewurukannala-3.jpg',
                'title'   => 'Sacred Buddhist Murals',
                'caption' => 'Detailed classical southern Sri Lankan mural paintings narrating Jataka teachings.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/wewurukannala-4.jpg',
                'title'   => 'Temple Stupa & Shrine',
                'caption' => 'White pagoda stupa and shrine courtyard within the historic grounds.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/wewurukannala-5.jpg',
                'title'   => 'Temple Grounds & Sanctuary',
                'caption' => 'Tranquil gardens and architectural details of this active place of worship.'
            ]
        ]
    ],

    'hummanaya' => [
        'id'          => 'hummanaya',
        'title'       => 'Hummanaya Blow Hole',
        'subtitle'    => 'Witness the Incredible Power of the Indian Ocean',
        'location'    => 'Kudawella',
        'region'      => 'Southern Province',
        'category'    => 'Nature & Wildlife',
        'category_slug' => 'nature',
        'image'       => 'assets/images/explore/dest-hummanaya-blowhole.jpg',
        'image_alt'   => 'Hummanaya Blow Hole — dramatic seawater geyser erupting at Kudawella, Sri Lanka',
        'distance'    => '20 mins from Denvonbay',
        'travel_time' => '20-minute coastal drive eastward',
        'best_time'   => 'High tide; southwest monsoon months (May–October) offer highest plumes',
        'ideal_for'   => 'Nature lovers, photographers, geological sightseeing',
        'duration'    => '1.5 to 2 hours',
        'summary'     => 'Witness the spectacular power of the Indian Ocean as seawater erupts through a natural rock formation in a remarkable coastal display.',
        'description' => 'The Hummanaya Blow Hole at Kudawella is one of Sri Lanka\'s most dramatic natural coastal attractions and the second largest blowhole in Asia. When powerful ocean swells compress through a subterranean fissure deep in the volcanic rock, seawater is forced upward with roaring force, erupting through a narrow natural chimney.

The geyser can shoot water up to 25 to 30 meters into the air, accompanied by an awe-inspiring whistling acoustic roar — from which the Sinhala name "Hoo-manaya" is derived. Set against jagged black rocks and crashing turquoise waves, the viewing platforms provide panoramic views across the open Indian Ocean.',
        'highlights'  => [
            'Spectacular seawater geysers erupting up to 30 meters high',
            'The second largest geological blowhole formation in all of Asia',
            'Acoustic booming sound as ocean pressure builds under the rocks',
            'Panoramic cliffside viewpoints overlooking the open Indian Ocean',
            'Small marine museum detailing local coastal geology and sea life',
            'Scenic drive passing peaceful fishing harbors along Kudawella bay'
        ],
        'tip'         => 'Eruption height and frequency depend heavily on sea swell and tide. Remain strictly within designated safety railings as the surrounding black volcanic rocks are wet and slippery. Bring a light waterproof pouch for electronics.',
        'host_note'   => 'Ask our team about current swell conditions before heading out — high tide always offers the most spectacular eruptions!',
        'gallery'     => [
            [
                'url'     => 'assets/images/explore/gallery/hummanaya-1.jpg',
                'title'   => 'Seawater Geyser Eruption',
                'caption' => 'Dramatic ocean seawater erupting through the natural rock fissure high into the air at Kudawella.'
            ]
        ]
    ],

    'dickwella-beach' => [
        'id'          => 'dickwella-beach',
        'title'       => 'Dickwella Beach',
        'subtitle'    => 'A Peaceful Coastal Paradise of Golden Sandy Shores',
        'location'    => 'Dickwella',
        'region'      => 'Southern Province',
        'category'    => 'Beaches & Islands',
        'category_slug' => 'beaches',
        'image'       => 'assets/images/explore/dest-dickwella-beach.jpg',
        'image_alt'   => 'Dickwella Beach — expansive golden sands and tropical shores on Sri Lanka\'s southern coast',
        'distance'    => '5 mins from Denvonbay',
        'travel_time' => '5-minute walk or 2-minute ride',
        'best_time'   => 'Late afternoon and golden sunset hour (4:30 PM – 6:30 PM)',
        'ideal_for'   => 'Peaceful beach walks, relaxed swimming, sunset cocktails, slow living',
        'duration'    => 'Half day or full afternoon',
        'summary'     => 'A peaceful coastal paradise of golden sandy shores, beautiful ocean views and the relaxed, unhurried atmosphere of Sri Lanka\'s south coast.',
        'description' => 'Dickwella Beach is a broad, sweeping crescent of golden sand stretching along Sri Lanka\'s Southern Province. While nearby Hiriketiya is known for its energetic surf buzz, Dickwella offers a much quieter, open, and relaxed coastal atmosphere.

The beach features warm turquoise waters sheltered by shallow coral barriers at several points, making it wonderful for long barefoot walks, gentle ocean dips, and watching traditional outrigger fishing boats return with their catch. Uncluttered by large resort developments, it retains an authentic, unhurried Sri Lankan coastal charm.',
        'highlights'  => [
            'Kilometres of uncrowded golden sandy shoreline for long walks',
            'Gentler swimming zones protected by natural offshore reefs',
            'Relaxed beachfront cafes serving fresh king coconuts and seafood',
            'Magnificent sunset panoramas reflecting across wide shallow flats',
            'Traditional Sri Lankan wooden outrigger catamarans resting on sand',
            'Only minutes from Denvonbay, making multiple visits effortless'
        ],
        'tip'         => 'While the central and eastern sections are gentle, currents can become stronger near open headlands. Stick to the reef-sheltered sandy shallows for safe swimming. The beach is at its most magical during sunset.',
        'host_note'   => 'Guests love taking a sunset walk along Dickwella Beach before returning to Denvonbay for a quiet, relaxing tropical evening.',
        'gallery'     => [
            [
                'url'     => 'assets/images/explore/gallery/dickwella-beach-1.jpg',
                'title'   => 'Golden Shoreline & Palms',
                'caption' => 'The wide golden sandy crescent of Dickwella Beach with tranquil turquoise waters.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/dickwella-beach-2.jpg',
                'title'   => 'Peaceful Tropical Bay',
                'caption' => 'Uncrowded southern coastal shores sheltered by natural offshore coral formations.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/dickwella-beach-3.jpg',
                'title'   => 'Sunset Over Dickwella',
                'caption' => 'Golden twilight reflecting across the sand and waves along Dickwella Beach.'
            ]
        ]
    ],

    'rekawa' => [
        'id'          => 'rekawa',
        'title'       => 'Rekawa Turtle Beach',
        'subtitle'    => 'Discover the World of Sea Turtle Conservation',
        'location'    => 'Tangalle',
        'region'      => 'Southern Province',
        'category'    => 'Nature & Wildlife',
        'category_slug' => 'nature',
        'image'       => 'assets/images/explore/dest-rekawa-turtle-beach.jpg',
        'image_alt'   => 'Rekawa Turtle Beach — nocturnal sea turtle nesting sanctuary in Tangalle, Sri Lanka',
        'distance'    => '35 mins from Denvonbay',
        'travel_time' => '35-minute taxi or tuk-tuk drive eastward',
        'best_time'   => 'Night time: 8:00 PM – 11:30 PM (year-round nesting)',
        'ideal_for'   => 'Eco-travelers, families, wildlife enthusiasts, conservationists',
        'duration'    => '3 to 4 hours (evening excursion)',
        'summary'     => 'Discover the world of sea turtle conservation at one of Sri Lanka\'s most important natural nesting beaches, guided by local experts.',
        'description' => 'Rekawa Turtle Beach near Tangalle is one of the world\'s most significant natural sea turtle nesting grounds and a shining model of community-based marine conservation. Five of the world\'s seven marine turtle species — Green, Leatherback, Olive Ridley, Hawksbill, and Loggerhead — come ashore here to lay their eggs.

Unlike commercial hatcheries, Rekawa protects turtles in their purely natural, wild environment through the Turtle Conservation Project (TCP). Guided night walks led by local village volunteers allow visitors to quietly observe female turtles laying eggs or baby hatchlings making their journey to the ocean under moonlit skies.',
        'highlights'  => [
            'Observe wild nesting turtles in their untouched natural habitat',
            'Home to five distinct sea turtle species nesting throughout the year',
            'Guided exclusively by certified local conservation trackers',
            'Directly supports community-based marine anti-poaching initiatives',
            'Educational visitor center explaining life cycles and ocean threats',
            'Rare, ethical wildlife experience with no captive tanks or handling'
        ],
        'tip'         => 'Strict eco-guidelines apply: white lights, flashlights, and camera flashes are strictly forbidden as they disorient nesting mothers. Red-filtered lights are provided by official guides. Wear dark clothing and quiet footwear for walking on sand.',
        'host_note'   => 'This is a wonderful evening trip from Denvonbay. We can book a trusted driver who will wait for you at the conservation center and drive you safely back to Denvonbay afterwards.',
        'gallery'     => [
            [
                'url'     => 'assets/images/explore/gallery/rekawa-1.jpg',
                'title'   => 'Sea Turtle Nesting',
                'caption' => 'Endangered sea turtle on the natural protected nesting sands of Rekawa Beach.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/rekawa-2.jpg',
                'title'   => 'Conservation Coastline',
                'caption' => 'The pristine, untouched beach of Rekawa dedicated to ethical marine conservation.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/rekawa-3.jpg',
                'title'   => 'Baby Turtle Hatchling',
                'caption' => 'A newborn hatchling making its remarkable first journey into the Indian Ocean.'
            ]
        ]
    ],

    'ella' => [
        'id'          => 'ella',
        'title'       => 'Ella — Hill Country',
        'subtitle'    => 'Where Mountains, Mist and Highland Adventure Meet',
        'location'    => 'Ella, Badulla District',
        'region'      => 'Sri Lanka\'s Hill Country',
        'category'    => 'Hill Country',
        'category_slug' => 'hills',
        'image'       => 'assets/images/explore/dest-ella-hill-country.jpg',
        'image_alt'   => 'Ella Hill Country — iconic Nine Arch Bridge surrounded by lush tea hills and jungle',
        'distance'    => 'Day trip / Overnight excursion',
        'travel_time' => 'Approx. 2.5 – 3 hours by private car',
        'best_time'   => 'Year-round; mornings for hiking before afternoon highland mist',
        'ideal_for'   => 'Hikers, adventure seekers, railway enthusiasts, tea lovers',
        'duration'    => 'Full day excursion or 1–2 night extension',
        'summary'     => 'Where mountains, mist and adventure meet — discover the iconic Nine Arch Bridge, scenic train journeys, tea plantations and hiking trails.',
        'description' => 'Ella is Sri Lanka\'s mountain paradise — an atmospheric highland village nestled in a cloud-kissed gorge surrounded by endless emerald tea estates, cascading waterfalls, and pine forests. While Denvonbay offers warm coastal relaxation, Ella is the ultimate contrasting highland adventure.

The world-famous Nine Arch Bridge, built entirely of stone and brick without steel during British colonial times, is one of Asia\'s most iconic railway landmarks. Visitors can hike to Little Adam\'s Peak for 360-degree views of the Ella Gap, climb Ella Rock, visit the roaring Ravana Falls, and board the legendary blue train through misty mountain tunnels.',
        'highlights'  => [
            'The iconic Nine Arch Bridge with scenic blue trains crossing the gorge',
            'Hike Little Adam\'s Peak for sweeping mountain and valley panoramas',
            'Challenging trek up Ella Rock through tea plantations and eucalyptus forests',
            'Ravana Falls and ancient cave steeped in the Ramayana epic',
            'Historic Ceylon tea factories offering factory tours and tastings',
            'Cool, refreshing mountain climate providing a delightful contrast to the beach'
        ],
        'tip'         => 'Because Ella is a longer journey from the coast, we recommend departing Denvonbay by 6:00 AM for a full-day trip, or planning an overnight stay. Carry a light jacket or fleece as highland evenings can be cool.',
        'host_note'   => 'Denvonbay can arrange an air-conditioned private vehicle and driver for your Ella day-trip, or assist you with luggage storage if you plan an overnight mountain journey before returning to the coast.',
        'gallery'     => [
            [
                'url'     => 'assets/images/explore/gallery/ella-1.jpg',
                'title'   => 'Iconic Nine Arch Bridge',
                'caption' => 'The world-famous Nine Arch Bridge spanning a lush green valley in Ella.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/ella-2.jpg',
                'title'   => 'Highland Mountain Vista',
                'caption' => 'Panoramic mountain vistas and dramatic ravines characteristic of the central highlands.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/ella-3.jpg',
                'title'   => 'Scenic Viaduct Crossing',
                'caption' => 'Historic stone railway viaduct surrounded by towering forests and emerald hills.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/ella-4.jpg',
                'title'   => 'Ceylon Tea Hillside',
                'caption' => 'Rolling green Ceylon tea estates and walking trails in the mountains of Ella.'
            ]
        ]
    ],

    'yala' => [
        'id'          => 'yala',
        'title'       => 'Yala National Park',
        'subtitle'    => 'An Unforgettable Wildlife Safari Across Untamed Wilderness',
        'location'    => 'Southeastern Sri Lanka',
        'region'      => 'Southern & Uva Provinces',
        'category'    => 'Nature & Wildlife',
        'category_slug' => 'nature',
        'image'       => 'assets/images/explore/dest-yala-national-park.jpg',
        'image_alt'   => 'Yala National Park — Sri Lankan leopard in its natural wilderness habitat',
        'distance'    => 'Full-day safari excursion',
        'travel_time' => 'Approx. 2 hours by car to Palatupana entrance gate',
        'best_time'   => 'Morning safari (6:00 AM – 10:00 AM) or afternoon safari (2:30 PM – 6:00 PM)',
        'ideal_for'   => 'Safari enthusiasts, wildlife photographers, birdwatchers, families',
        'duration'    => 'Half-day game drive or full-day park safari',
        'summary'     => 'An unforgettable wildlife safari excursion home to leopards, elephants, crocodiles and rich birdlife in pristine national wilderness.',
        'description' => 'Yala National Park is Sri Lanka\'s premier wildlife sanctuary, encompassing almost 1,000 square kilometres of diverse tropical dry forest, open thorn savanna, coastal scrub, and freshwater lagoons opening onto the wild Indian Ocean.

Yala Block 1 boasts one of the highest leopard densities in the entire world (the endemic Sri Lankan leopard, Panthera pardus kotiya). An open-top 4x4 jeep safari also gives you the chance to encounter majestic herds of wild Asian elephants, elusive sloth bears, mugger crocodiles sunning on lagoon banks, spotted deer, wild boar, and over 215 bird species.',
        'highlights'  => [
            'World\'s highest density habitat for the endemic Sri Lankan leopard',
            'Thrilling open-top 4x4 safari with experienced park trackers',
            'Wild Asian elephant herds bathing in natural waterholes',
            'Saltwater lagoons teeming with flamingos, storks, and kingfishers',
            'Striking landscapes featuring giant rocky outcrops and untamed ocean dunes',
            'Conveniently accessible for an early-morning safari excursion from Denvonbay'
        ],
        'tip'         => 'Park regulations require all visitors to stay inside authorized safari jeeps. Wildlife sightings are authentic and never guaranteed. Bring binoculars, a zoom lens, sunglasses, and dust protection (a light scarf or bandana).',
        'host_note'   => 'We can organize an early-morning departure from Denvonbay (around 4:30 AM) with a packed breakfast, connecting you directly with trusted, respectful safari jeep drivers at the park gate.',
        'gallery'     => [
            [
                'url'     => 'assets/images/explore/gallery/yala-1.jpg',
                'title'   => 'Sri Lankan Leopard',
                'caption' => 'The majestic endemic Sri Lankan leopard resting in the wild at Yala National Park.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/yala-2.jpg',
                'title'   => 'Wild Safari Landscape',
                'caption' => 'Untamed savanna and thorny dry forests bordering coastal lagoons in Yala.'
            ],
            [
                'url'     => 'assets/images/explore/gallery/yala-3.jpg',
                'title'   => 'Wild Asian Elephant',
                'caption' => 'Wild elephant grazing peacefully in its natural protected habitat.'
            ]
        ]
    ]
];

// Determine selected destination by slug or id
$requestedSlug = isset($_GET['slug']) ? sanitize($_GET['slug']) : (isset($_GET['id']) ? sanitize($_GET['id']) : '');
$currentDest = $destinations[$requestedSlug] ?? null;

// Graceful fallback to first destination if slug is invalid
if (!$currentDest) {
    $currentDest = reset($destinations);
}

// Select 3 related destinations (excluding the current one)
$relatedDestinations = [];
foreach ($destinations as $k => $d) {
    if ($k !== $currentDest['id']) {
        $relatedDestinations[] = $d;
        if (count($relatedDestinations) === 3) break;
    }
}

$pageTitle = e($currentDest['title']) . ' | Destination Guide | Denvonbay';
$pageDescription = e($currentDest['summary']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $pageTitle ?></title>
    <meta name="description" content="<?= $pageDescription ?>">
    <meta name="keywords" content="<?= e($currentDest['title']) ?>, <?= e($currentDest['location']) ?>, explore Sri Lanka, Denvonbay, south coast attractions">

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
    <link rel="stylesheet" href="assets/css/destination-details.css?v=<?= file_exists('assets/css/destination-details.css') ? filemtime('assets/css/destination-details.css') : '1.0' ?>">

    <style>
    /* Inline Critical Typography & Layout Protection */
    .dest-detail-page { background-color: #F8FAFC !important; }
    .dest-detail-card {
        background: #FFFFFF !important;
        border: 1px solid #E2E8F0 !important;
        border-radius: 20px !important;
        padding: 38px 40px !important;
        box-shadow: 0 4px 24px rgba(11, 42, 91, 0.04) !important;
        margin-bottom: 28px !important;
    }
    .dest-detail-card-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #1266F1;
        margin-bottom: 10px;
    }
    .dest-detail-section-title {
        font-size: 1.65rem !important;
        font-weight: 800 !important;
        color: #0B2A5B !important;
        letter-spacing: -0.02em !important;
        line-height: 1.25 !important;
        margin-bottom: 22px !important;
        padding-bottom: 14px !important;
        border-bottom: 1px solid #F1F5F9 !important;
    }
    .dest-lead {
        font-size: 1.125rem !important;
        line-height: 1.85 !important;
        color: #1E293B !important;
        font-weight: 500 !important;
        margin-bottom: 20px !important;
    }
    .dest-para {
        font-size: 1.025rem !important;
        line-height: 1.85 !important;
        color: #475569 !important;
        font-weight: 400 !important;
        margin-bottom: 20px !important;
    }
    .dest-highlights-grid {
        display: grid !important;
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 16px !important;
    }
    @media (max-width: 767.98px) {
        .dest-highlights-grid { grid-template-columns: 1fr !important; }
        .dest-detail-card { padding: 24px 20px !important; }
    }
    .dest-highlight-box {
        display: flex !important;
        flex-direction: row !important;
        align-items: flex-start !important;
        gap: 14px !important;
        background: #F8FAFC !important;
        border: 1px solid #E2E8F0 !important;
        border-radius: 14px !important;
        padding: 16px 18px !important;
    }
    .dest-hl-icon {
        width: 30px !important;
        height: 30px !important;
        border-radius: 50% !important;
        background: rgba(18, 102, 241, 0.12) !important;
        color: #1266F1 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        flex-shrink: 0 !important;
        margin-top: 2px !important;
    }
    .dest-hl-text {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        color: #0B2A5B !important;
        line-height: 1.5 !important;
        flex: 1 !important;
    }
    .dest-facts-card {
        background: #FFFFFF !important;
        border: 1px solid #E2E8F0 !important;
        border-radius: 20px !important;
        padding: 30px !important;
        box-shadow: 0 4px 24px rgba(11, 42, 91, 0.05) !important;
        margin-bottom: 24px !important;
    }
    .dest-facts-title {
        font-size: 1.25rem !important;
        font-weight: 800 !important;
        color: #0B2A5B !important;
        margin-bottom: 20px !important;
        padding-bottom: 14px !important;
        border-bottom: 1px solid #F1F5F9 !important;
        display: flex !important;
        align-items: center !important;
    }
    .dest-fact-item {
        display: flex !important;
        align-items: flex-start !important;
        gap: 14px !important;
        padding: 14px 0 !important;
        border-bottom: 1px solid #F1F5F9 !important;
    }
    .dest-fact-item:last-child {
        border-bottom: none !important;
        padding-bottom: 0 !important;
    }
    .dest-fact-icon {
        width: 38px !important;
        height: 38px !important;
        border-radius: 10px !important;
        background: #EFF6FF !important;
        color: #1266F1 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 1rem !important;
        flex-shrink: 0 !important;
        margin-top: 2px !important;
    }
    .dest-fact-content { flex: 1 !important; }
    .dest-fact-label {
        display: block !important;
        font-size: 0.72rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.08em !important;
        text-transform: uppercase !important;
        color: #64748B !important;
        margin-bottom: 4px !important;
    }
    .dest-fact-val {
        display: block !important;
        font-size: 0.95rem !important;
        font-weight: 700 !important;
        color: #0B2A5B !important;
        line-height: 1.4 !important;
    }
    .dest-tip-card {
        background: #FFFDF5 !important;
        border: 1px solid #FDE68A !important;
        border-left: 5px solid #F59E0B !important;
        border-radius: 16px !important;
        padding: 26px 30px !important;
        margin-bottom: 28px !important;
    }
    .dest-host-card {
        background: #F0F9FF !important;
        border: 1px solid #BAE6FD !important;
        border-left: 5px solid #0284C7 !important;
        border-radius: 16px !important;
        padding: 26px 30px !important;
        margin-bottom: 28px !important;
    }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<main id="main-content" class="dest-detail-page">

    <!-- ===== BREADCRUMB & TOP HEADER ===== -->
    <div class="dest-detail-header-wrap">
        <div class="container">

            <!-- Breadcrumb Navigation -->
            <nav class="dest-breadcrumb" aria-label="Breadcrumb">
                <a href="index.php"><i class="bi bi-house-door me-1"></i>Home</a>
                <span class="dest-breadcrumb-sep">/</span>
                <a href="explore.php">Explore Sri Lanka</a>
                <span class="dest-breadcrumb-sep">/</span>
                <span class="dest-breadcrumb-current"><?= e($currentDest['title']) ?></span>
            </nav>

            <!-- Page Title Block (Hero-free, clean boutique style) -->
            <div class="dest-detail-title-block" data-reveal="up">
                <div class="dest-detail-meta-pill">
                    <span class="dest-badge-cat"><i class="bi bi-compass me-1"></i><?= e($currentDest['category']) ?></span>
                    <span class="dest-meta-location"><i class="bi bi-geo-alt-fill me-1"></i><?= e($currentDest['location']) ?>, <?= e($currentDest['region']) ?></span>
                </div>
                <h1 class="dest-detail-h1"><?= e($currentDest['title']) ?></h1>
                <p class="dest-detail-sub"><?= e($currentDest['subtitle']) ?></p>
            </div>

        </div>
    </div>

    <!-- ===== MAIN CONTENT CONTAINER ===== -->
    <section class="dest-detail-body-section">
        <div class="container">

            <!-- Full-width Featured Image -->
            <div class="dest-detail-photo-wrap" data-reveal="up">
                <img
                    src="<?= e($currentDest['image']) ?>"
                    alt="<?= e($currentDest['image_alt']) ?>"
                    class="dest-detail-photo"
                    loading="eager"
                    fetchpriority="high"
                >
                <div class="dest-detail-photo-badge">
                    <i class="bi bi-camera-fill me-1"></i><?= e($currentDest['location']) ?>, Sri Lanka
                </div>
                <?php if (!empty($currentDest['gallery'])): ?>
                <a href="#photo-gallery" class="dest-detail-gallery-pill">
                    <i class="bi bi-images me-1"></i>View All <?= count($currentDest['gallery']) ?> Photos
                </a>
                <?php endif; ?>
            </div>

            <div class="row gy-5 mt-2">

                <!-- Left Column: Rich Editorial Story & Details -->
                <div class="col-lg-8" data-reveal="left">

                    <!-- Narrative Overview -->
                    <div class="dest-detail-card mb-4">
                        <span class="dest-detail-card-eyebrow"><i class="bi bi-water me-1"></i>Destination Story</span>
                        <h2 class="dest-detail-section-title">About <?= e($currentDest['title']) ?></h2>
                        <div class="dest-detail-prose">
                            <?php 
                            $paragraphs = array_filter(array_map('trim', explode("\n\n", $currentDest['description'])));
                            foreach ($paragraphs as $idx => $paragraph): 
                            ?>
                                <p class="<?= ($idx === 0) ? 'dest-lead' : 'dest-para' ?>"><?= nl2br(e($paragraph)) ?></p>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Key Highlights Grid -->
                    <div class="dest-detail-card mb-4">
                        <span class="dest-detail-card-eyebrow"><i class="bi bi-stars me-1"></i>Experience Highlights</span>
                        <h2 class="dest-detail-section-title">What Makes It Unforgettable</h2>
                        <div class="dest-highlights-grid">
                            <?php foreach ($currentDest['highlights'] as $hl): ?>
                                <div class="dest-highlight-box">
                                    <span class="dest-hl-icon" aria-hidden="true"><i class="bi bi-check-lg"></i></span>
                                    <span class="dest-hl-text"><?= e($hl) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Destination Photo Gallery Section -->
                    <?php if (!empty($currentDest['gallery'])): ?>
                    <div class="dest-detail-card mb-4" id="photo-gallery">
                        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                            <div>
                                <span class="dest-detail-card-eyebrow"><i class="bi bi-images me-1"></i>Authentic Photography</span>
                                <h2 class="dest-detail-section-title mb-0 border-0 pb-0">Photo Gallery: <?= e($currentDest['title']) ?></h2>
                            </div>
                            <span class="dest-gallery-count-pill"><i class="bi bi-camera me-1"></i><?= count($currentDest['gallery']) ?> Photos</span>
                        </div>
                        <p class="text-muted small mb-4">Real images from <?= e($currentDest['title']) ?>. Click any image to view in high resolution.</p>
                        
                        <div class="dest-photo-gallery-grid">
                            <?php foreach ($currentDest['gallery'] as $gIndex => $gItem): ?>
                                <div class="dest-gallery-item" onclick="openLightbox(<?= $gIndex ?>)" role="button" tabindex="0" aria-label="View photo: <?= e($gItem['title']) ?>">
                                    <img src="<?= e($gItem['url']) ?>" alt="<?= e($gItem['caption']) ?>" loading="lazy">
                                    <div class="dest-gallery-overlay">
                                        <div class="dest-gallery-info">
                                            <span class="dest-gallery-title"><?= e($gItem['title']) ?></span>
                                            <span class="dest-gallery-zoom" aria-hidden="true"><i class="bi bi-arrows-fullscreen"></i></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Visitor Guidance & Responsible Tourism -->
                    <?php if (!empty($currentDest['tip'])): ?>
                        <div class="dest-tip-card mb-4">
                            <div class="dest-tip-header">
                                <div class="dest-tip-icon" aria-hidden="true"><i class="bi bi-lightbulb-fill"></i></div>
                                <div>
                                    <h3 class="dest-tip-title">Visitor Guidance &amp; Responsible Travel</h3>
                                    <span class="dest-tip-sub">Essential tips from local experts for a safe &amp; respectful experience</span>
                                </div>
                            </div>
                            <p class="dest-tip-body"><?= e($currentDest['tip']) ?></p>
                        </div>
                    <?php endif; ?>

                    <!-- How to Explore from Denvonbay -->
                    <div class="dest-host-card">
                        <div class="dest-host-header">
                            <i class="bi bi-house-heart-fill dest-host-icon" aria-hidden="true"></i>
                            <div>
                                <h3 class="dest-host-title">Exploring from Denvonbay</h3>
                                <p class="dest-host-sub">Tips from your coastal hosts in Hiriketiya</p>
                            </div>
                        </div>
                        <p class="dest-host-text"><?= e($currentDest['host_note']) ?></p>
                    </div>

                </div>

                <!-- Right Column: Quick Travel Facts & Booking Sidebar -->
                <div class="col-lg-4" data-reveal="right">
                    <div class="dest-sidebar-sticky">

                        <!-- Quick Trip Facts Widget -->
                        <div class="dest-facts-card mb-4">
                            <h3 class="dest-facts-title"><i class="bi bi-info-circle-fill text-primary me-2" aria-hidden="true"></i>Trip Essentials</h3>

                            <div class="dest-fact-item">
                                <div class="dest-fact-icon" aria-hidden="true"><i class="bi bi-geo-alt-fill"></i></div>
                                <div class="dest-fact-content">
                                    <span class="dest-fact-label">Location</span>
                                    <span class="dest-fact-val"><?= e($currentDest['location']) ?></span>
                                </div>
                            </div>

                            <div class="dest-fact-item">
                                <div class="dest-fact-icon" aria-hidden="true"><i class="bi bi-clock-fill"></i></div>
                                <div class="dest-fact-content">
                                    <span class="dest-fact-label">Distance from Denvonbay</span>
                                    <span class="dest-fact-val"><?= e($currentDest['distance']) ?></span>
                                </div>
                            </div>

                            <div class="dest-fact-item">
                                <div class="dest-fact-icon" aria-hidden="true"><i class="bi bi-sun-fill"></i></div>
                                <div class="dest-fact-content">
                                    <span class="dest-fact-label">Best Time to Visit</span>
                                    <span class="dest-fact-val"><?= e($currentDest['best_time']) ?></span>
                                </div>
                            </div>

                            <div class="dest-fact-item">
                                <div class="dest-fact-icon" aria-hidden="true"><i class="bi bi-hourglass-split"></i></div>
                                <div class="dest-fact-content">
                                    <span class="dest-fact-label">Suggested Duration</span>
                                    <span class="dest-fact-val"><?= e($currentDest['duration']) ?></span>
                                </div>
                            </div>

                            <div class="dest-fact-item">
                                <div class="dest-fact-icon" aria-hidden="true"><i class="bi bi-activity"></i></div>
                                <div class="dest-fact-content">
                                    <span class="dest-fact-label">Ideal For</span>
                                    <span class="dest-fact-val"><?= e($currentDest['ideal_for']) ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Stay at Denvonbay CTA Card -->
                        <div class="dest-stay-widget">
                            <span class="dest-stay-eyebrow"><i class="bi bi-water me-1"></i>Your Coastal Base</span>
                            <h3 class="dest-stay-title">Explore Sri Lanka.<br>Stay at Denvonbay.</h3>
                            <p class="dest-stay-desc">Only five boutique rooms just minutes from Hiriketiya Beach. Make Denvonbay your tranquil base for south coast exploration.</p>

                            <div class="dest-stay-actions">
                                <a href="booking.php" class="btn btn-hero-primary w-100 mb-2">
                                    <i class="bi bi-calendar2-check me-2"></i>Book Your Stay
                                </a>
                                <a href="https://wa.me/94773011436?text=<?= urlencode('Hi Denvonbay, I would love some information about visiting ' . $currentDest['title'] . ' during my stay!') ?>"
                                   target="_blank" rel="noopener" class="btn btn-cta-whatsapp w-100 text-center">
                                    <i class="bi bi-whatsapp me-2"></i>Ask Us on WhatsApp
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ===== RELATED DESTINATIONS ===== -->
    <section class="dest-related-section">
        <div class="container">
            <div class="section-header text-center mb-5" data-reveal="up">
                <span class="section-eyebrow-dark"><i class="bi bi-compass me-1"></i>Discover More</span>
                <h2 class="section-heading-dark">More Places to Explore</h2>
                <p class="section-subtext-dark">Carefully selected Sri Lankan destinations easily reachable from your coastal home at Denvonbay.</p>
            </div>

            <div class="destinations-grid">
                <?php foreach ($relatedDestinations as $rDest): ?>
                    <div class="dest-grid-item" data-reveal="up">
                        <a href="destination-details.php?slug=<?= e($rDest['id']) ?>" class="dest-card" aria-label="Explore <?= e($rDest['title']) ?>">
                            <div class="dest-card-image-wrap">
                                <img src="<?= e($rDest['image']) ?>" alt="<?= e($rDest['image_alt']) ?>" loading="lazy">
                                <span class="dest-card-category-badge"><?= e($rDest['category']) ?></span>
                            </div>
                            <div class="dest-card-body">
                                <div class="dest-card-location"><i class="bi bi-geo-alt-fill" aria-hidden="true"></i> <?= e($rDest['location']) ?></div>
                                <h3 class="dest-card-title"><?= e($rDest['title']) ?></h3>
                                <p class="dest-card-desc"><?= e($rDest['summary']) ?></p>
                                <div class="dest-card-cta">
                                    <span class="dest-card-link">Explore Destination</span>
                                    <span class="dest-card-arrow" aria-hidden="true"><i class="bi bi-arrow-right"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-5" data-reveal="up">
                <a href="explore.php" class="btn btn-view-all">
                    <i class="bi bi-grid-3x3-gap me-2"></i>View All 8 Destinations
                </a>
            </div>
        </div>
    </section>

</main>

<?php include 'footer.php'; ?>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Common JS -->
<script src="assets/js/common.js?v=<?= file_exists('assets/js/common.js') ? filemtime('assets/js/common.js') : '2.0' ?>"></script>

<!-- Lightbox Modal -->
<div class="dest-lightbox" id="destLightbox" role="dialog" aria-modal="true" aria-label="Photo Lightbox">
    <button type="button" class="dest-lightbox-close" id="lightboxClose" aria-label="Close Lightbox">
        <i class="bi bi-x-lg"></i>
    </button>
    <button type="button" class="dest-lightbox-nav dest-lightbox-prev" id="lightboxPrev" aria-label="Previous photo">
        <i class="bi bi-chevron-left"></i>
    </button>
    <button type="button" class="dest-lightbox-nav dest-lightbox-next" id="lightboxNext" aria-label="Next photo">
        <i class="bi bi-chevron-right"></i>
    </button>

    <div class="dest-lightbox-content">
        <div class="dest-lightbox-img-wrap">
            <img src="" alt="" id="lightboxImg" class="dest-lightbox-img">
        </div>
        <div class="dest-lightbox-caption-wrap">
            <h4 id="lightboxTitle" class="dest-lightbox-title"></h4>
            <p id="lightboxCaption" class="dest-lightbox-caption"></p>
            <span id="lightboxCounter" class="dest-lightbox-counter"></span>
        </div>
    </div>
</div>

<script>
var galleryData = <?= json_encode($currentDest['gallery'] ?? []) ?>;
var currentLightboxIndex = 0;
var lightbox = document.getElementById('destLightbox');
var lightboxImg = document.getElementById('lightboxImg');
var lightboxTitle = document.getElementById('lightboxTitle');
var lightboxCaption = document.getElementById('lightboxCaption');
var lightboxCounter = document.getElementById('lightboxCounter');

function openLightbox(index) {
    if (!galleryData || !galleryData.length) return;
    currentLightboxIndex = (index >= 0 && index < galleryData.length) ? index : 0;
    renderLightboxItem();
    lightbox.classList.add('is-active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    if (!lightbox) return;
    lightbox.classList.remove('is-active');
    document.body.style.overflow = '';
}

function renderLightboxItem() {
    var item = galleryData[currentLightboxIndex];
    if (!item) return;
    lightboxImg.src = item.url;
    lightboxImg.alt = item.caption || item.title;
    lightboxTitle.textContent = item.title || '';
    lightboxCaption.textContent = item.caption || '';
    lightboxCounter.textContent = (currentLightboxIndex + 1) + ' / ' + galleryData.length;
}

function nextLightbox() {
    if (!galleryData.length) return;
    currentLightboxIndex = (currentLightboxIndex + 1) % galleryData.length;
    renderLightboxItem();
}

function prevLightbox() {
    if (!galleryData.length) return;
    currentLightboxIndex = (currentLightboxIndex - 1 + galleryData.length) % galleryData.length;
    renderLightboxItem();
}

document.getElementById('lightboxClose')?.addEventListener('click', closeLightbox);
document.getElementById('lightboxNext')?.addEventListener('click', nextLightbox);
document.getElementById('lightboxPrev')?.addEventListener('click', prevLightbox);

lightbox?.addEventListener('click', function(e) {
    if (e.target === lightbox || e.target.classList.contains('dest-lightbox-content')) {
        closeLightbox();
    }
});

document.addEventListener('keydown', function(e) {
    if (!lightbox || !lightbox.classList.contains('is-active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowRight') nextLightbox();
    if (e.key === 'ArrowLeft') prevLightbox();
});
</script>

</body>
</html>
