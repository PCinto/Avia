<?php
include('db_config.php'); // Include DB connection

$sql = "SELECT * FROM flight_plan";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Flights</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Flight Management System</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="view_flights.php">View Flights</a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="overview">
        <h2>Flight Records</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="flight-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pilot Name</th>
                        <th>Flight Date</th>
                        <th>Aircraft Type</th>
                        <th>Passenger Count</th>
                        <th>Crusing Height</th>
                        <th>Cruising Speed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['pilot_in_command']; ?></td>
                            <td><?php echo $row['created_at']; ?></td>
                            <td><?php echo $row['aircraft_type']; ?></td>
                            <td><?php echo $row['persons_on_board']; ?></td>
                            <td><?php echo $row['total_eet']; ?></td>
                            <td><?php echo $row['cruising_speed']; ?></td>
                            <td>
                                <a href="edit_flight.php?id=<?php echo $row['id']; ?>" class="edit-btn">Edit</a>
                                <a href="delete_flight.php?id=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No flight records found.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    <p>&copy; 2025 Pilot Management System</p>
</footer>

</body>
</html>

<?php $conn->close(); ?>
