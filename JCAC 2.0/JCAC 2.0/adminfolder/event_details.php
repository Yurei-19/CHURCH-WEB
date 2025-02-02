<?php
include '../conn.php'; // Include the database connection

// Get the event ID from the URL
$event_id = $_GET['id'];

// Fetch event details from the database
$query = "SELECT event_name, events_pic, date_event FROM events_tbl WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="events.css">
    <title>Event Details</title>
</head>
<body>
    <div class="event-details">
        <h1><?php echo htmlspecialchars($event['event_name']); ?></h1>
        <img src="<?php echo htmlspecialchars($event['events_pic']); ?>" alt="Event Image" style="width:100%;">
        <p>Date: <?php echo date('F j, Y', strtotime($event['date_event'])); ?></p>
        <!-- Add more details here if needed -->
    </div>
</body>
</html> 