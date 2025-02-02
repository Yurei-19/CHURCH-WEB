<?php

// Check if the user is logged in
if (!isset($_SESSION['loggedin'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);
?>

<link rel="stylesheet" href="headercss.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<nav>
    <img src="../images/antioch.png" alt="Antioch Logo" class="logo">
    <ul>
        <li><a href="admindashboard.php" class="<?php echo ($current_page == 'admindashboard.php') ? 'active' : ''; ?>">Home</a></li>
        <li><a href="adminevents.php" class="<?php echo ($current_page == 'adminevents.php') ? 'active' : ''; ?>">Events</a></li>
        <li><a href="adminrequest.php" class="<?php echo ($current_page == 'adminrequest.php') ? 'active' : ''; ?>">Admin Request</a></li>
        <li><a href="adminprayer.php" class="<?php echo ($current_page == 'adminprayer.php') ? 'active' : ''; ?>">Prayer Request</a></li>
        <li>
            <a href="#" class="logout-button" onclick="confirmLogout(event)">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</nav>

<div id="logoutModal" class="logout-modal">
    <div class="logout-modal-content">
        <i class="fas fa-sign-out-alt"></i>
        <p>Are you sure you want to logout?</p>
        <div class="logout-modal-buttons">
            <button onclick="logout()">Yes, Logout</button>
            <button onclick="closeLogoutModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
function confirmLogout(event) {
    event.preventDefault();
    document.getElementById('logoutModal').style.display = 'flex';
}

function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
}

function logout() {
    window.location.href = 'logout.php';
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    var logoutModal = document.getElementById('logoutModal');
    if (event.target == logoutModal) {
        closeLogoutModal();
    }
});
</script>
