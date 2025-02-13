<?php
// db_config.php

$servername = "localhost";
$username = "root";  // Adjust as necessary for your setup
$password = "";      // Adjust if you have a password
$dbname = "pilot_management_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
