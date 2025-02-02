<?php
session_start();
include '../conn.php';

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $admin_id = $_GET['id'];
    $action = $_GET['action'];
    
    if ($action === 'accept') {
        error_log("Approving admin ID: " . $admin_id);
        
        $sql = "UPDATE adminlogin_tbl SET status = 'approved' WHERE admin_id = ?";
        $message = "Admin registration approved successfully!";
    } else if ($action === 'reject') {
        $sql = "DELETE FROM adminlogin_tbl WHERE admin_id = ?";
        $message = "Admin registration rejected and removed successfully!";
    }
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        $_SESSION['notification'] = [
            'message' => "Error preparing statement: " . $conn->error,
            'type' => 'error'
        ];
        header("Location: adminrequest.php");
        exit();
    }
    
    $stmt->bind_param("i", $admin_id);
    
    if ($stmt->execute()) {
        error_log("Status update successful for admin ID: " . $admin_id);
        $_SESSION['notification'] = [
            'message' => $message,
            'type' => 'success'
        ];
    } else {
        error_log("Error updating status: " . $stmt->error);
        $_SESSION['notification'] = [
            'message' => "Error processing registration: " . $stmt->error,
            'type' => 'error'
        ];
    }
    
    $stmt->close();
    header("Location: adminrequest.php");
    exit();
}

$conn->close();
?> 