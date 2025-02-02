<?php
session_start();
include '../conn.php'; // Include the database connection




// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date = $_POST['date'];
    $passage = $_POST['passage'];
    $content = $_POST['content'];

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO devotions (devotion_date, bible_verse, content) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $date, $passage, $content);

    // Execute the statement
    if ($stmt->execute()) {
        echo "<script>
            setTimeout(function() {
                var modal = document.getElementById('successModal');
                modal.style.display = 'flex';
                
                // Reset form
                document.querySelector('.devotion-form').reset();
                
                setTimeout(function() {
                    modal.style.opacity = '0';
                    setTimeout(function() {
                        modal.style.display = 'none';
                        modal.style.opacity = '1';
                    }, 300);
                }, 2000);
            }, 100);
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Your dashboard code here
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admindashboard.css">
    <title>Admin Dashboard</title>
    <?php include 'adminheader.php'; ?>
</head>
<body>
  
    <div class="dashboard">
        <div class="devotion-container">
            <div class="devotion-header">TODAY'S DEVOTION</div>
            <button class="devotion-button" onclick="location.href='#daily-devotion'">
                <span class="devotion-text">Devotion</span>
                <span class="arrow">→</span>
            </button>
        </div>
        <div class="left-container">
            <img src="../images/great.png" alt="Great" class="great-image">
            <div class="church-name">Jesus Christ Antioch Church</div>
        </div>
    </div>
  
    <div id="daily-devotion" class="daily-devotion">
        <img src="../images/devotion.jpg" alt="Devotion Banner" class="devotion-banner">
        <div class="banner-text">Daily Devotion</div>
        <h2>Daily Devotion</h2>
        <form class="devotion-form" method="POST" action="">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            
            <label for="passage">Passage:</label>
            <input type="text" id="passage" name="passage" required>
            
            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="4" required></textarea>
            
            <button type="submit">Submit</button>
        </form>
    </div>
  
    <script src="dashboard.js"></script>
    <div id="successModal" class="success-modal">
        <div class="success-modal-content">
            <div class="success-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                </svg>
            </div>
            <h3>Devotion Posted Successfully!</h3>
        </div>
    </div>
</body>
</html>