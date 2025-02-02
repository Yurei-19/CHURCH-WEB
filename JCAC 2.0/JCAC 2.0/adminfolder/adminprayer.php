<?php
session_start();
include '../userfolder/connection.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// Fetch prayer requests from database
$sql = "SELECT * FROM prayerreq_tbl ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prayer Requests</title>
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
        <h1>Prayer Requests</h1>
        
        <div class="filter-section">
            <div class="search-box">
                <i class="fas fa-search search-icon"></i>
                <input type="text" id="searchInput" placeholder="Search prayers...">
            </div>
            <div class="filter-buttons">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="today">Today</button>
                <button class="filter-btn" data-filter="week">This Week</button>
                <button class="filter-btn" data-filter="month">This Month</button>
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Wish 1</th>
                        <th>Wish 2</th>
                        <th>Wish 3</th>
                        <th>Prayer Request</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td data-label='Name'>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td data-label='Wish 1'>" . htmlspecialchars($row['wish1']) . "</td>";
                            echo "<td data-label='Wish 2'>" . htmlspecialchars($row['wish2']) . "</td>";
                            echo "<td data-label='Wish 3'>" . htmlspecialchars($row['wish3']) . "</td>";
                            echo "<td data-label='Prayer Request' class='prayer-text'>" . 
                                 "<span class='preview-text'>" . substr(htmlspecialchars($row['prayerreq']), 0, 50) . "...</span>" .
                                 "<span class='full-text' style='display:none'>" . htmlspecialchars($row['prayerreq']) . "</span>" .
                                 "<button class='read-more-btn' onclick='showPrayer(this.parentElement)'>Read More</button>" .
                                 "</td>";
                            echo "<td data-label='Actions'>" .
                                 "<button class='delete-btn' onclick='deletePrayer(" . $row['id'] . ")'>" .
                                 "<i class='fas fa-trash-alt'></i>" .
                                 "</button>" .
                                 "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No prayer requests found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="prayerModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Prayer Request</h2>
            <p id="modalText"></p>
        </div>
    </div>

    <div id="deleteConfirmModal" class="modal">
        <div class="delete-modal-content">
            <i class="fas fa-exclamation-triangle warning-icon"></i>
            <h2>Delete Prayer Request</h2>
            <p>Are you sure you want to delete this prayer request? This action cannot be undone.</p>
            <div class="delete-modal-buttons">
                <button id="deleteConfirmBtn" class="delete-confirm-btn">Delete</button>
                <button onclick="closeDeleteModal()" class="delete-cancel-btn">Cancel</button>
            </div>
        </div>
    </div>

    <script>
        let prayerIdToDelete = null;

        function deletePrayer(id) {
            prayerIdToDelete = id;
            const modal = document.getElementById('deleteConfirmModal');
            modal.style.display = 'flex';
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteConfirmModal');
            modal.style.display = 'none';
        }

        document.getElementById('deleteConfirmBtn').addEventListener('click', function() {
            if (prayerIdToDelete) {
                closeDeleteModal();
                window.location.href = 'delete_prayer.php?id=' + prayerIdToDelete;
            }
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            var prayerModal = document.getElementById('prayerModal');
            var deleteModal = document.getElementById('deleteConfirmModal');
            
            if (event.target == prayerModal) {
                prayerModal.style.display = "none";
            }
            if (event.target == deleteModal) {
                closeDeleteModal();
            }
        });

        var modal = document.getElementById("prayerModal");
        var modalText = document.getElementById("modalText");
        var span = document.getElementsByClassName("close")[0];

        function showPrayer(element) {
            var fullText = element.querySelector('.full-text').textContent;
            modalText.textContent = fullText;
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                // Get the name cell (first column)
                let nameCell = row.cells[0];
                let nameText = nameCell.textContent.toLowerCase();
                
                // Show/hide row based on name match
                if (nameText.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Filter buttons functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                const rows = document.querySelectorAll('tbody tr');
                
                rows.forEach(row => {
                    switch(filter) {
                        case 'all':
                            row.style.display = '';
                            break;
                        case 'today':
                            // Add your date filtering logic here
                            break;
                        case 'week':
                            // Add your week filtering logic here
                            break;
                        case 'month':
                            // Add your month filtering logic here
                            break;
                    }
                });
            });
        });

        // Auto remove notification after animation
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.querySelector('.notification');
            if (notification) {
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        });
    </script>
</body>
</html>
