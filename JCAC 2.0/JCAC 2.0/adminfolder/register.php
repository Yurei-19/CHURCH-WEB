<?php
session_start();
include '../conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="registerstyle.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Sign In</title>
</head>
<body>
    <?php if (isset($_SESSION['notification'])): ?>
        <div class="notification <?php echo $_SESSION['notification']['type']; ?>">
            <i class="fas <?php echo $_SESSION['notification']['type'] === 'success' ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
            <span><?php echo $_SESSION['notification']['message']; ?></span>
        </div>
        <?php unset($_SESSION['notification']); ?>
    <?php endif; ?>

    <div class="register-container">
        <h2>Create an Account</h2>
        <form action="register_process.php" method="POST" onsubmit="return validatePasswords()">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Create Password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('password', this)">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <div class="form-group">
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility('confirm-password', this)">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <button type="submit" class="sign-in-button">Sign In</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
    
    <script>
    function togglePasswordVisibility(fieldId, icon) {
        const field = document.getElementById(fieldId);
        const iconElement = icon.querySelector('i');
        if (field.type === "password") {
            field.type = "text";
            iconElement.classList.remove('fa-eye-slash');
            iconElement.classList.add('fa-eye');
        } else {
            field.type = "password";
            iconElement.classList.remove('fa-eye');
            iconElement.classList.add('fa-eye-slash');
        }
    }

    function validatePasswords() {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;
        if (password !== confirmPassword) {
            const notification = document.createElement('div');
            notification.className = 'notification error';
            notification.innerHTML = `
                <i class="fas fa-times-circle"></i>
                <span>Error: Passwords do not match.</span>
            `;
            document.body.appendChild(notification);
            setTimeout(() => {
                notification.remove();
            }, 3000);
            return false;
        }
        return true;
    }
    </script>
</body>
</html>
