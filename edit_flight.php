<?php
include('db_config.php'); // Include DB connection

// Get flight ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM flight_plan WHERE id = $id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

// Update flight record
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $pilot_name = $_POST['pilot_name'];
    $flight_date = $_POST['flight_date'];
    $fuel_amount = $_POST['fuel_amount'];
    $passenger_count = $_POST['passenger_count'];
    $flight_duration = $_POST['flight_duration'];
    $destination = $_POST['destination'];

    $sql = "UPDATE flight_plan SET 
            pilot_name='$pilot_name', 
            flight_date='$flight_date', 
            fuel_amount='$fuel_amount', 
            passenger_count='$passenger_count', 
            flight_duration='$flight_duration', 
            destination='$destination' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_flights.php?update=success");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Flight</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Edit Flight Details</h1>
</header>

<main>
    <form method="POST" action="edit_flight.php">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        
        <label>Pilot Name:</label>
        <input type="text" name="pilot_name" value="<?php echo $row['pilot_name']; ?>" required>

        <label>Flight Date:</label>
        <input type="date" name="flight_date" value="<?php echo $row['flight_date']; ?>" required>

        <label>Fuel Amount:</label>
        <input type="number" name="fuel_amount" value="<?php echo $row['fuel_amount']; ?>" required>

        <label>Passenger Count:</label>
        <input type="number" name="passenger_count" value="<?php echo $row['passenger_count']; ?>" required>

        <label>Flight Duration:</label>
        <input type="number" step="0.1" name="flight_duration" value="<?php echo $row['flight_duration']; ?>" required>

        <label>Destination:</label>
        <input type="text" name="destination" value="<?php echo $row['destination']; ?>" required>

        <button type="submit" name="update">Update Flight</button>
    </form>
</main>

</body>
</html>
