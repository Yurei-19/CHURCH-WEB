<?php
session_start();
include '../userfolder/connection.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Prepare and execute the delete query
    $stmt = $conn->prepare("DELETE FROM prayerreq_tbl WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'message' => 'Prayer request deleted successfully!',
            'type' => 'success'
        ];
    } else {
        $_SESSION['notification'] = [
            'message' => 'Error deleting prayer request.',
            'type' => 'error'
        ];
    }
    
    $stmt->close();
}

header("Location: adminprayer.php");
exit();
?> 