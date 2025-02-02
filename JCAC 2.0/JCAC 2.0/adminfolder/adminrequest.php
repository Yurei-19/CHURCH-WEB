<?php
session_start();
include '../userfolder/connection.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Fetch pending user registrations with error handling
try {
    $sql = "SELECT * FROM adminlogin_tbl WHERE status='pending' ORDER BY admin_id DESC";
    $result = $conn->query($sql);

    if ($result === false) {
        throw new Exception($conn->error);
    }
} catch (Exception $e) {
    $_SESSION['notification'] = [
        'message' => "Database error: " . $e->getMessage(),
        'type' => 'error'
    ];
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Requests</title>
    <link rel="stylesheet" href="prayer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <?php include 'adminheader.php'; ?>
</head>
<body>
    <?php if (isset($_SESSION['notification'])): ?>
        <div class="notification <?php echo $_SESSION['notification']['type']; ?>">
            <i class="fas <?php echo $_SESSION['notification']['type'] === 'success' ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
            <span><?php echo $_SESSION['notification']['message']; ?></span>
        </div>
        <?php unset($_SESSION['notification']); ?>
    <?php endif; ?>

    <div class="prayer-container">
        <h1>Pending Admin Registrations</h1>
        
        <div class="filter-section">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search admins...">
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td data-label='Username'>" . htmlspecialchars($row['user']) . "</td>";
                            echo "<td data-label='Status'><span class='status-badge pending'>Pending</span></td>";
                            echo "<td data-label='Actions' class='action-buttons'>
                                    <button class='accept-btn' onclick='acceptUser(" . $row['admin_id'] . ")'>
                                        <i class='fas fa-check'></i> Accept
                                    </button>
                                    <button class='reject-btn' onclick='rejectUser(" . $row['admin_id'] . ")'>
                                        <i class='fas fa-times'></i> Reject
                                    </button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        if ($result === null) {
                            echo "<tr><td colspan='3'>Error loading registrations. Please try again.</td></tr>";
                        } else {
                            echo "<tr><td colspan='3'>No pending registrations found</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="modal">
        <div class="delete-modal-content">
            <i class="fas fa-question-circle warning-icon"></i>
            <h2 id="confirmTitle">Confirm Action</h2>
            <p id="confirmMessage"></p>
            <div class="delete-modal-buttons">
                <button id="confirmActionBtn" class="delete-confirm-btn">Confirm</button>
                <button onclick="closeConfirmModal()" class="delete-cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <script>
    let selectedUserId = null;
    let actionType = null;

    function acceptUser(id) {
        selectedUserId = id;
        actionType = 'accept';
        document.getElementById('confirmTitle').textContent = 'Accept Registration';
        document.getElementById('confirmMessage').textContent = 'Are you sure you want to accept this admin registration?';
        document.getElementById('confirmActionBtn').className = 'accept-confirm-btn';
        document.getElementById('confirmModal').style.display = 'flex';
    }

    function rejectUser(id) {
        selectedUserId = id;
        actionType = 'reject';
        document.getElementById('confirmTitle').textContent = 'Reject Registration';
        document.getElementById('confirmMessage').textContent = 'Are you sure you want to reject this admin registration? This action cannot be undone.';
        document.getElementById('confirmActionBtn').className = 'delete-confirm-btn';
        document.getElementById('confirmModal').style.display = 'flex';
    }

    function closeConfirmModal() {
        document.getElementById('confirmModal').style.display = 'none';
    }

    document.getElementById('confirmActionBtn').addEventListener('click', function() {
        if (selectedUserId && actionType) {
            window.location.href = `process_registration.php?id=${selectedUserId}&action=${actionType}`;
        }
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let username = row.cells[0].textContent.toLowerCase();
            if (username.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('confirmModal');
        if (event.target == modal) {
            closeConfirmModal();
        }
    }
    </script>
</body>
</html> 