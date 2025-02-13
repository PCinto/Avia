<?php
include('db_config.php'); // Include DB connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM flight_plan WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_flights.php?delete=success");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
