<?php
session_start();
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    // Check if username already exists
    $check_stmt = $conn->prepare("SELECT user FROM adminlogin_tbl WHERE user = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['notification'] = [
            'message' => "Username already exists!",
            'type' => 'error'
        ];
        header("Location: register.php");
        exit();
    }
    
    // Insert new user with 'pending' status
    $stmt = $conn->prepare("INSERT INTO adminlogin_tbl (user, pass, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'message' => "Registration successful! Please wait for admin approval.",
            'type' => 'success'
        ];
        header("Location: register.php");
    } else {
        $_SESSION['notification'] = [
            'message' => "Registration failed! Please try again.",
            'type' => 'error'
        ];
        header("Location: register.php");
    }
    
    $stmt->close();
    $check_stmt->close();
    $conn->close();
}
?>