<?php
// Database connection using MySQLi
$servername = "localhost"; // database server 
$username = "root"; // database username
$password = ""; //  database password
$dbname = "jcac_db"; // database name

// Create connection with error handling
try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    // Log the error (you might want to use proper logging in production)
    error_log("Database connection error: " . $e->getMessage());
    
    // Show user-friendly message (in production, you might want to handle this differently)
    die("Unable to connect to the database. Please try again later.");
}
?>
