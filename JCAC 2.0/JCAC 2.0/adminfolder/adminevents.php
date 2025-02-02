<?php
session_start();
include '../conn.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Handle event deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM events_tbl WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "Event deleted successfully";
        exit();
    } else {
        echo "Error deleting event: " . $stmt->error;
    }
}

// Fetch events from the database
$query = "SELECT id, event_name, location, events_pic, date_event FROM events_tbl";
$result = $conn->query($query);

$upcomingEvents = [];
$previousEvents = [];
$currentDate = date('Y-m-d');

while ($row = $result->fetch_assoc()) {
    if ($row['date_event'] >= $currentDate) {
        $upcomingEvents[] = $row;
    } else {
        $previousEvents[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $location = $_POST['location'];
    $date_event = $_POST['date_event'];

    // Handle file upload
    $target_dir = "eventspic/";  // Changed back to original path
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    if (isset($_FILES["events_pic"]) && $_FILES["events_pic"]["error"] == 0) {
        $file_extension = strtolower(pathinfo($_FILES["events_pic"]["name"], PATHINFO_EXTENSION));
        $new_filename = uniqid() . '.' . $file_extension; // Generate unique filename
        $target_file = $target_dir . $new_filename;
        
        // Try to move the uploaded file
        if (move_uploaded_file($_FILES["events_pic"]["tmp_name"], $target_file)) {
            $db_path = $target_file; // Store the same path in database
            
            // Insert into database
            $insert_query = "INSERT INTO events_tbl (event_name, location, events_pic, date_event) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            
            if ($stmt) {
                $stmt->bind_param("ssss", $event_name, $location, $db_path, $date_event);
                if ($stmt->execute()) {
                    header("Location: adminevents.php?success=1");
                    exit();
                } else {
                    die("Error executing statement: " . $stmt->error);
                }
            } else {
                die("Error preparing statement: " . $conn->error);
            }
        } else {
            die("Error moving uploaded file");
        }
    } else {
        die("Error with file upload: " . $_FILES["events_pic"]["error"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="events.css">
    <title>Events</title>
    <?php include 'adminheader.php'; ?>
</head>
<body>
    <div class="events-header">
        <h1>EVENTS</h1>
        <p>Lorem Ipsum dolor lorem Ipsum dolor lorem Ipsum</p>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search by event..." onkeyup="filterEvents()">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>
    <button class="add-event-button" onclick="toggleForm()">+</button>
    <div id="eventForm" style="display:none;">
        <form action="adminevents.php" method="POST" enctype="multipart/form-data">
            <input type="text" name="event_name" placeholder="Event Name" required>
            <input type="text" name="location" placeholder="Event Location" required>
            <input type="date" name="date_event" required>
            <input type="file" name="events_pic" accept="image/*" required>
            <button type="submit">Add Event</button>
        </form>
    </div>

    <h2>Upcoming Events</h2>
    <div class="events-container">
        <?php foreach ($upcomingEvents as $event): ?>
            <div class="event-card" data-id="<?php echo $event['id']; ?>">
                <button class="delete-button" onclick="confirmDelete(<?php echo $event['id']; ?>)">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <div class="event-date">
                    <span><?php echo date('j', strtotime($event['date_event'])); ?></span>
                    <small><?php echo date('F', strtotime($event['date_event'])); ?></small>
                </div>
                <div class="event-info">
                    <h2><?php echo htmlspecialchars($event['event_name']); ?></h2>
                    <p class="event-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($event['location']); ?></p>
                    <img src="<?php echo htmlspecialchars($event['events_pic']); ?>" alt="Event Image" class="event-image" style="width:100%;">
                    <a href="#" onclick="showDetails('<?php echo htmlspecialchars($event['event_name']); ?>', '<?php echo htmlspecialchars($event['location']); ?>', '<?php echo htmlspecialchars($event['events_pic']); ?>', '<?php echo date('F j, Y', strtotime($event['date_event'])); ?>')">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h2>Previous Events</h2>
    <div class="events-container">
        <?php foreach ($previousEvents as $event): ?>
            <div class="event-card" data-id="<?php echo $event['id']; ?>">
                <button class="delete-button" onclick="confirmDelete(<?php echo $event['id']; ?>)">
                    <i class="fas fa-trash-alt"></i>
                </button>
                <div class="event-date">
                    <span><?php echo date('j', strtotime($event['date_event'])); ?></span>
                    <small><?php echo date('F', strtotime($event['date_event'])); ?></small>
                </div>
                <div class="event-info">
                    <h2><?php echo htmlspecialchars($event['event_name']); ?></h2>
                    <p class="event-location"><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($event['location']); ?></p>
                    <img src="<?php echo htmlspecialchars($event['events_pic']); ?>" alt="Event Image" class="event-image" style="width:100%;">
                    <a href="#" onclick="showDetails('<?php echo htmlspecialchars($event['event_name']); ?>', '<?php echo htmlspecialchars($event['location']); ?>', '<?php echo htmlspecialchars($event['events_pic']); ?>', '<?php echo date('F j, Y', strtotime($event['date_event'])); ?>')">View Details</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="eventDetailsModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h1 id="modalEventName"></h1>
            <p id="modalEventLocation"></p>
            <img id="modalEventImage" src="" alt="Event Image" style="width:100%;">
            <p id="modalEventDate"></p>
        </div>
    </div>

    <div id="confirmDeleteModal" class="modal" style="display:none;">
        <div class="modal-content">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this event?</p>
            <div class="button-container">
                <button id="confirmDeleteButton" class="confirm-button">Yes</button>
                <button onclick="closeConfirmModal()" class="cancel-button">No</button>
            </div>
        </div>
    </div>

    <div id="addSuccessModal" class="success-modal">
        <div class="modal-content">
            <div class="success-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
            </div>
            <h3>Event Added Successfully!</h3>
        </div>
    </div>

    <div id="deleteSuccessModal" class="success-modal">
        <div class="modal-content">
            <div class="success-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
            </div>
            <h3>Event Deleted Successfully!</h3>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Force reflow and restart animations
        const eventCards = document.querySelectorAll('.event-card');
        eventCards.forEach(card => {
            card.style.animation = 'none';
            card.offsetHeight; // Trigger reflow
            card.style.animation = '';  // Remove the 'none' to let CSS animation take over
        });
    });

    function toggleForm() {
        const form = document.getElementById('eventForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function showDetails(name, location, image, date) {
        document.getElementById('modalEventName').innerText = name;
        document.getElementById('modalEventLocation').innerText = location;
        document.getElementById('modalEventImage').src = image;
        document.getElementById('modalEventDate').innerText = 'Date: ' + date;
        document.getElementById('eventDetailsModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('eventDetailsModal').style.display = 'none';
    }

    function adjustTextColor() {
        const images = document.querySelectorAll('.event-image');
        images.forEach(img => {
            img.onload = function() {
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.width = img.width;
                canvas.height = img.height;
                context.drawImage(img, 0, 0, img.width, img.height);
                const imageData = context.getImageData(0, 0, img.width, img.height);
                const data = imageData.data;
                let r, g, b, avg;
                let colorSum = 0;

                for (let x = 0, len = data.length; x < len; x += 4) {
                    r = data[x];
                    g = data[x + 1];
                    b = data[x + 2];
                    avg = Math.floor((r + g + b) / 3);
                    colorSum += avg;
                }

                const brightness = Math.floor(colorSum / (img.width * img.height));
                const textColor = brightness > 125 ? 'black' : 'white';
                img.parentElement.style.color = textColor;
            };
        });
    }

    window.onload = adjustTextColor;

    window.onclick = function(event) {
        const form = document.getElementById('eventForm');
        const button = document.querySelector('.add-event-button');
        const modal = document.getElementById('eventDetailsModal');
        if (event.target !== form && !form.contains(event.target) && event.target !== button && form.style.display === 'block') {
            form.style.display = 'none';
        }
        if (event.target === modal) {
            closeModal();
        }
    }

    let deleteId = null;

    function confirmDelete(id) {
        deleteId = id;
        document.getElementById('confirmDeleteModal').style.display = 'flex';
    }

    function closeConfirmModal() {
        document.getElementById('confirmDeleteModal').style.display = 'none';
        deleteId = null;
    }

    document.getElementById('confirmDeleteButton').onclick = function() {
        if (deleteId !== null) {
            fetch(`adminevents.php?delete_id=${deleteId}`)
            .then(response => response.text())
            .then(data => {
                if (data.includes("Event deleted successfully")) {
                    const eventCard = document.querySelector(`.event-card[data-id='${deleteId}']`);
                    if (eventCard) {
                        eventCard.remove();
                    }
                    closeConfirmModal();
                    showSuccessModal('deleteSuccessModal');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    };

    function filterEvents() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const eventCards = document.querySelectorAll('.event-card');

        eventCards.forEach((card, index) => {
            const eventName = card.querySelector('h2').textContent.toLowerCase();
            const eventMonth = card.querySelector('.event-date small').textContent.toLowerCase();
            const eventDay = card.querySelector('.event-date span').textContent;
            const fullDate = card.querySelector('a').getAttribute('onclick');
            const dateMatch = fullDate.match(/(\w+)\s+\d+,\s+(\d{4})/);
            const eventYear = dateMatch ? dateMatch[2] : '';
            
            // Check if matches event name, month name, year, or day
            if (eventName.includes(filter) || 
                eventMonth.includes(filter) || 
                eventYear.includes(filter) || 
                eventDay.includes(filter) ||
                // Check for month numbers (e.g., "1" for January)
                (getMonthNumber(eventMonth) + '').includes(filter)) {
                
                card.style.display = '';
                // Restart animation
                card.style.animation = 'none';
                card.offsetHeight;
                card.style.animation = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Helper function to get month number (1-12) from month name
    function getMonthNumber(monthName) {
        const months = {
            'january': 1,
            'february': 2,
            'march': 3,
            'april': 4,
            'may': 5,
            'june': 6,
            'july': 7,
            'august': 8,
            'september': 9,
            'october': 10,
            'november': 11,
            'december': 12
        };
        return months[monthName.toLowerCase()] || '';
    }

    function showSuccessModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'flex';
        setTimeout(() => {
            modal.style.display = 'none';
            if (modalId === 'addSuccessModal') {
                window.location.reload();
            }
        }, 2000);
    }

    // Update form submission
    document.querySelector('#eventForm form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('adminevents.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            toggleForm();
            showSuccessModal('addSuccessModal');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });

    // Update delete confirmation
    document.getElementById('confirmDeleteButton').onclick = function() {
        if (deleteId !== null) {
            fetch(`adminevents.php?delete_id=${deleteId}`)
            .then(response => response.text())
            .then(data => {
                if (data.includes("Event deleted successfully")) {
                    const eventCard = document.querySelector(`.event-card[data-id='${deleteId}']`);
                    if (eventCard) {
                        eventCard.remove();
                    }
                    closeConfirmModal();
                    showSuccessModal('deleteSuccessModal');
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    };
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
</body>
</html>
