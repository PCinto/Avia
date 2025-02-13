<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pilot_management_system"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $priority = $_POST['priority'];
    $addressee = $_POST['addressee'];
    $filing_time = $_POST['filing_time'];
    $originator = $_POST['originator'];
    $identification = $_POST['identification'];
    $message_type = $_POST['message_type'];
    $aircraft_id = $_POST['aircraft_id'];
    $flight_rules = $_POST['flight_rules'];
    $number = $_POST['number'];
    $aircraft_type = $_POST['aircraft_type'];
    $wake_turbulence = $_POST['wake_turbulence'];
    $equipment = $_POST['equipment'];
    $type_of_flight = $_POST['type_of_flight'];
    $departure_aerodrome = $_POST['departure_aerodrome'];
    $departure_time = $_POST['departure_time'];
    $cruising_speed = $_POST['cruising_speed'];
    $level = $_POST['level'];
    $route = $_POST['route'];
    $destination_aerodrome = $_POST['destination_aerodrome'];
    $total_eet = $_POST['total_eet'];
    $altn_aerodrome = $_POST['altn_aerodrome'];
    $second_altn_aerodrome = $_POST['second_altn_aerodrome'];
    $other_information = $_POST['other_information'];
    $endurance = $_POST['endurance'];
    $persons_on_board = $_POST['persons_on_board'];
    $survival_equipment = implode(", ", $_POST['survival_equipment'] ?? []);
    $dinghies_number = $_POST['dinghies_number'];
    $dinghies_capacity = $_POST['dinghies_capacity'];
    $dinghies_cover = $_POST['dinghies_cover'];
    $dinghies_colour = $_POST['dinghies_colour'];
    $aircraft_colour = $_POST['aircraft_colour'];
    $remark = $_POST['remark'];
    $pilot_in_command = $_POST['pilot_in_command'];
    $filed_by = $_POST['filed_by'];
    $additional_requirements = $_POST['additional_requirements'];
    $contact_number = $_POST['contact_number'];

    // Insert into database
    $sql = "INSERT INTO flight_plan (priority, addressee, filing_time, originator, identification, message_type, aircraft_id, flight_rules, number, aircraft_type, wake_turbulence, equipment, type_of_flight, departure_aerodrome, departure_time, cruising_speed, level, route, destination_aerodrome, total_eet, altn_aerodrome, second_altn_aerodrome, other_information, endurance, persons_on_board, survival_equipment, dinghies_number, dinghies_capacity, dinghies_cover, dinghies_colour, aircraft_colour, remark, pilot_in_command, filed_by, additional_requirements, contact_number) VALUES ('$priority', '$addressee', '$filing_time', '$originator', '$identification', '$message_type', '$aircraft_id', '$flight_rules', '$number', '$aircraft_type', '$wake_turbulence', '$equipment', '$type_of_flight', '$departure_aerodrome', '$departure_time', '$cruising_speed', '$level', '$route', '$destination_aerodrome', '$total_eet', '$altn_aerodrome', '$second_altn_aerodrome', '$other_information', '$endurance', '$persons_on_board', '$survival_equipment', '$dinghies_number', '$dinghies_capacity', '$dinghies_cover', '$dinghies_colour', '$aircraft_colour', '$remark', '$pilot_in_command', '$filed_by', '$additional_requirements', '$contact_number')";

    if ($conn->query($sql) === TRUE) {
        echo "Flight plan submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
