<?php
include '../conn.php'; // Include the database connection file

// Start the session
ob_start();
session_start();

$error_message = '';

// Redirect if already logged in
if (isset($_SESSION['loggedin'])) {
    header("Location: admindashboard.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT admin_id, user, pass, status FROM adminlogin_tbl WHERE user = ?");
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password === $row['pass']) {
            // Allow login if user is admin_id 1 OR status is approved
            if ($row['admin_id'] == 1 || $row['status'] === 'approved') {
                $_SESSION['loggedin'] = $row['admin_id'];
                $_SESSION['username'] = $row['user'];
                header("Location: admindashboard.php");
                exit();
            } else if ($row['status'] === 'pending') {
                $error_message = "Your account is pending approval. Please wait for an administrator to approve your account.";
            } else {
                $error_message = "Your account has not been approved yet.";
            }
        } else {
            $error_message = "Password does not match.";
        }
    } else {
        $error_message = "No user found with that username.";
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="registerstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <div class="register-container">
        <h2>Login to Your Account</h2>
        <?php if ($error_message): ?>
            <div class="notification error">
                <i class="fas fa-times-circle"></i>
                <span><?php echo $error_message; ?></span>
            </div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <input type="text" id="login-username" name="username" placeholder="Enter Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="login-password" name="password" placeholder="Enter Password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('login-password', this)">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <button type="submit" class="sign-in-button">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
