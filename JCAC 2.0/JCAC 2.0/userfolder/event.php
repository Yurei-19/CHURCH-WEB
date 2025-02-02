<?php
include 'header.php';
include '../conn.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch upcoming events (events with future dates)
$upcoming_query = "SELECT * FROM events_tbl WHERE date_event >= CURDATE() ORDER BY date_event ASC";
$upcoming_result = $conn->query($upcoming_query);

// Check if query was successful
if (!$upcoming_result) {
    die("Error in upcoming events query: " . $conn->error);
}

// Fetch past events (events with past dates)
$past_query = "SELECT * FROM events_tbl WHERE date_event < CURDATE() ORDER BY date_event DESC";
$past_result = $conn->query($past_query);

// Check if query was successful
if (!$past_result) {
    die("Error in past events query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Events Page</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        /* Header styles */
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-size: cover;
            padding: 10px 20px;
        }
        
        .logo {
            flex-shrink: 0;
            z-index: 1500;
        }
        
        .logo-img {
            margin-top: -10px;
            width: 200px;
            height: auto;
        }
        
        .nav {
            display: flex;
            gap: 50px;
            position: relative;
            left: -428px;
            z-index: 1500;
        }
        
        .nav a {
            margin-top: -25px;
            text-decoration: none;
            color: #694f36;
            font-weight: bold;
            position: relative;
        }
        
        .nav a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            background-color: #b49979;
            bottom: -2px;
            left: 0;
            transition: width 0.3s ease-in-out;
        }
    
        .nav a:hover::after {
            width: 100%;
        }
        
        .gives-button {
            margin-top: -25px;
            background-color: #f10707;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            z-index: 1500;
        }

        /* Events styles */
        .events-section {
            text-align: center;
            padding: 20px;
            margin-bottom: 40px;
        }

        .events-section h1 {
            color: #694f36;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .events-text p {
            color: #666;
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .upcoming-events, .past-events {
            margin: 40px 0;
            overflow: hidden;
        }

        .upcoming-events h2, .past-events h2 {
            color: #694f36;
            font-size: 2em;
            margin-bottom: 20px;
            text-align: center;
        }

        .events-container {
            display: flex;
            flex-wrap: nowrap;
            justify-content: flex-start;
            padding: 50px 30px;
            margin: 0 auto;
            overflow-x: scroll;
            overflow-y: hidden;
            width: 100%;
            position: relative;
            scrollbar-width: thin;
            scrollbar-color: #694f36 #ddd;
        }

        .events-container::-webkit-scrollbar {
            display: block;
            height: 8px;
        }

        .events-container::-webkit-scrollbar-track {
            background: #ddd;
            border-radius: 10px;
        }

        .events-container::-webkit-scrollbar-thumb {
            background-color: #694f36;
            border-radius: 10px;
            border: 2px solid #ddd;
        }

        .events-container::-webkit-scrollbar-thumb:hover {
            background-color: #7b634d;
        }

        .event-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08),
                        1px 1px 1px rgba(0, 0, 0, 0.05),
                        0 0 1px rgba(0, 0, 0, 0.03);
            width: 380px;
            height: 350px;
            overflow: hidden;
            position: relative;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform: rotate(-2deg);
            border: 1px solid rgba(0, 0, 0, 0.03);
            margin: 0 -20px;
            flex-shrink: 0;
            transform-origin: center 80%;
        }

        .event-card:nth-child(2n) {
            transform: rotate(2deg);
            z-index: 1;
            transform-origin: center 85%;
        }

        .event-card:nth-child(3n) {
            transform: rotate(-1deg);
            z-index: 2;
            transform-origin: center 75%;
        }

        .event-card:hover {
            transform: translateY(-20px) translateX(10px) rotate(3deg) !important;
            box-shadow: 15px 15px 20px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .event-card:hover::after {
            opacity: 1;
        }

        .event-date {
            background: #000000;
            color: white;
            padding: 6px 12px;
            text-align: center;
            position: absolute;
            top: 0;
            right: 0;
            border-radius: 0 15px 0 15px;
            z-index: 1;
            box-shadow: -1px 1px 2px rgba(0, 0, 0, 0.15);
        }

        .event-date span {
            font-size: 1.2em;
            font-weight: bold;
            display: block;
        }

        .event-date small {
            font-size: 0.8em;
        }

        .event-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
        }

        .event-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(
                to bottom,
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 0, 0, 0.9) 50%,
                rgba(0, 0, 0, 1) 100%
            );
            color: white;
            box-sizing: border-box;
        }

        .event-info h2 {
            color: white;
            font-size: 1.3em;
            margin: 8px 0 15px 0;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .event-info .event-location {
            margin-bottom: 15px;
            font-size: 1.1em;
            color: rgba(255, 255, 255, 0.9);
        }

        .event-info a {
            display: inline-block;
            padding: 10px 25px;
            background-color: #694f36;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .event-info a:hover {
            background-color: #7b634d;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .event-card {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
            overflow-y: auto;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-content h2 {
            color: #694f36;
            margin-bottom: 20px;
        }

        .modal-content img {
            width: 100%;
            height: auto;
            max-height: none;
            object-fit: contain;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .modal-content p {
            color: #666;
            margin: 10px 0;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 28px;
            cursor: pointer;
            color: #694f36;
        }

        .close:hover {
            color: #000;
        }

        @keyframes paperShuffle {
            0% {
                transform: translateY(0) rotate(-2deg);
            }
            50% {
                transform: translateY(-25px) translateX(15px) rotate(4deg);
            }
            100% {
                transform: translateY(-20px) translateX(10px) rotate(3deg);
            }
        }

        /* Search styles */
        .search-filter {
            display: flex;
            justify-content: center;
            margin: 20px auto;
            max-width: 600px;
            padding: 0 20px;
            position: relative;
        }

        .search-filter input {
            padding: 15px 20px;
            border: 2px solid #ddd;
            border-radius: 30px;
            font-size: 16px;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .search-filter input:focus {
            outline: none;
            border-color: #694f36;
            box-shadow: 0 2px 10px rgba(105, 79, 54, 0.2);
        }

        .search-filter i {
            position: absolute;
            right: 35px;
            top: 50%;
            transform: translateY(-50%);
            color: #694f36;
            cursor: pointer;
        }

        .search-filter input::placeholder {
            color: #999;
        }

        /* Hide elements with no matches */
        .event-card.hidden {
            display: none;
        }

        /* No results message */
        .no-results {
            text-align: center;
            color: #666;
            padding: 20px;
            font-style: italic;
        }

        @media (max-width: 425px) {
            .events-section {
                padding-left: 40px;
            }

            .events-section h1 {
                text-align: left;
                margin-left: 250px;
            }

            .events-text {
                text-align: left;
                margin-left: 120px;
                white-space: nowrap;
            }

            .search-filter {
                margin-left: 120px;
                width: 400px;
            }
            
            .events-container {
                display: flex;
                flex-wrap: nowrap;
                overflow-x: scroll;
                padding: 20px;
                padding-right: 200px;
                width: 300%;
                margin-left: -20px;
                scrollbar-width: thin;
                scrollbar-color: #694f36 #ddd;
            }

            .events-container::-webkit-scrollbar {
                display: block;
                height: 8px;
            }

            .events-container::-webkit-scrollbar-track {
                background: #ddd;
                border-radius: 10px;
            }

            .events-container::-webkit-scrollbar-thumb {
                background-color: #694f36;
                border-radius: 10px;
                border: 2px solid #ddd;
            }

            .events-container::-webkit-scrollbar-thumb:hover {
                background-color: #7b634d;
            }

            .event-card {
                flex: 0 0 auto;
                width: 300px;
                margin-right: 60px;
                transform: none !important;
            }

            .event-card:nth-child(2n),
            .event-card:nth-child(3n) {
                transform: none !important;
            }

            .upcoming-events, .past-events {
                overflow: hidden;
                padding-left: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->

    <div id="events" class="events-section">
        <h1>Events</h1>
        <div id="events-text" class="events-text">
            <p>Stay updated with our church events and activities</p>
        </div>
        
        <!-- Search Filter Section -->
        <div class="search-filter">
            <input type="text" id="eventSearch" placeholder="Search events by name, location, or date...">
            <i class="fas fa-search"></i>
        </div>
    </div>

    <?php
    // Fetch all events
    $upcoming_query = "SELECT * FROM events_tbl WHERE date_event >= CURDATE() ORDER BY date_event ASC";
    $past_query = "SELECT * FROM events_tbl WHERE date_event < CURDATE() ORDER BY date_event DESC";

    $upcoming_result = $conn->query($upcoming_query);
    $past_result = $conn->query($past_query);
    ?>

    <div id="upcoming-events" class="upcoming-events">
        <h2>Upcoming Events</h2>
        <div class="events-container">
            <?php
            if ($upcoming_result->num_rows > 0) {
                while($row = $upcoming_result->fetch_assoc()) {
                    $searchData = strtolower($row['event_name'] . ' ' . 
                                          $row['location'] . ' ' . 
                                          date('F j Y', strtotime($row['date_event'])));
                    echo '<div class="event-card" data-search="' . htmlspecialchars($searchData) . '">';
                    if (!empty($row['events_pic'])) {
                        echo '<img src="../adminfolder/' . htmlspecialchars($row['events_pic']) . '" alt="Event Image" class="event-image">';
                    }
                    echo '<div class="event-date">';
                    echo '<span>' . date('j', strtotime($row['date_event'])) . '</span>';
                    echo '<small>' . date('F', strtotime($row['date_event'])) . '</small>';
                    echo '</div>';
                    echo '<div class="event-info">';
                    echo '<h2>' . htmlspecialchars($row['event_name']) . '</h2>';
                    echo '<p class="event-location"><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($row['location']) . '</p>';
                    echo '<a href="#" onclick="showDetails(\'' . htmlspecialchars($row['event_name']) . '\', \'' . 
                         htmlspecialchars($row['events_pic']) . '\', \'' . date('F j, Y', strtotime($row['date_event'])) . '\', \'' . 
                         htmlspecialchars($row['location']) . '\')">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="no-results">No upcoming events scheduled.</p>';
            }
            ?>
        </div>
    </div>

    <div id="past-events" class="past-events">
        <h2>Past Events</h2>
        <div class="events-container">
            <?php
            if ($past_result->num_rows > 0) {
                while($row = $past_result->fetch_assoc()) {
                    $searchData = strtolower($row['event_name'] . ' ' . 
                                          $row['location'] . ' ' . 
                                          date('F j Y', strtotime($row['date_event'])));
                    echo '<div class="event-card" data-search="' . htmlspecialchars($searchData) . '">';
                    if (!empty($row['events_pic'])) {
                        echo '<img src="../adminfolder/' . htmlspecialchars($row['events_pic']) . '" alt="Event Image" class="event-image">';
                    }
                    echo '<div class="event-date">';
                    echo '<span>' . date('j', strtotime($row['date_event'])) . '</span>';
                    echo '<small>' . date('F', strtotime($row['date_event'])) . '</small>';
                    echo '</div>';
                    echo '<div class="event-info">';
                    echo '<h2>' . htmlspecialchars($row['event_name']) . '</h2>';
                    echo '<p class="event-location"><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($row['location']) . '</p>';
                    echo '<a href="#" onclick="showDetails(\'' . htmlspecialchars($row['event_name']) . '\', \'' . 
                         htmlspecialchars($row['events_pic']) . '\', \'' . date('F j, Y', strtotime($row['date_event'])) . '\', \'' . 
                         htmlspecialchars($row['location']) . '\')">View Details</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="no-results">No past events to display.</p>';
            }
            ?>
        </div>
    </div>

    <!-- Add modal div at the bottom of body -->
    <div id="eventDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalEventName"></h2>
            <img id="modalEventImage" src="" alt="Event Image">
            <p id="modalEventDate"></p>
            <p id="modalEventLocation"></p>
        </div>
    </div>

    <script>
        // Real-time search functionality
        document.getElementById('eventSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const eventCards = document.querySelectorAll('.event-card');
            let hasResults = false;

            eventCards.forEach(card => {
                const searchData = card.getAttribute('data-search');
                if (searchData.includes(searchTerm)) {
                    card.classList.remove('hidden');
                    hasResults = true;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Show/hide no results message
            const sections = ['upcoming-events', 'past-events'];
            sections.forEach(section => {
                const container = document.querySelector(`#${section} .events-container`);
                const visibleCards = container.querySelectorAll('.event-card:not(.hidden)').length;
                const noResultsMsg = container.querySelector('.no-results');
                
                if (visibleCards === 0) {
                    if (!noResultsMsg) {
                        const msg = document.createElement('p');
                        msg.className = 'no-results';
                        msg.textContent = 'No events found matching your search.';
                        container.appendChild(msg);
                    }
                } else {
                    if (noResultsMsg) {
                        noResultsMsg.remove();
                    }
                }
            });
        });

        function showDetails(name, image, date, location) {
            document.getElementById('modalEventName').innerText = name;
            document.getElementById('modalEventImage').src = '../adminfolder/' + image;
            document.getElementById('modalEventDate').innerText = 'Date: ' + date;
            document.getElementById('modalEventLocation').innerText = 'Location: ' + location;
            document.getElementById('eventDetailsModal').style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('eventDetailsModal').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('eventDetailsModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>

</body>
</html>