<?php
include('db_config.php');

if (isset($_POST['submit'])) {
    // Securely capture form data
    $pilot_name = trim($_POST['pilot_name']);
    $flight_date = $_POST['flight_date'];
    $fuel_amount = intval($_POST['fuel_amount']);
    $passenger_count = intval($_POST['passenger_count']);
    $flight_duration = floatval($_POST['flight_duration']);
    $destination = trim($_POST['destination']);

    // Prevent SQL Injection using Prepared Statements
    $sql = "INSERT INTO flight_plan (pilot_name, flight_date, fuel_amount, passenger_count, flight_duration, destination) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiiis", $pilot_name, $flight_date, $fuel_amount, $passenger_count, $flight_duration, $destination);

    if ($stmt->execute()) {
        echo "New flight record created successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

?>
