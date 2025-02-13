<?php 
session_start();
include('header.php'); 
include('db_config.php'); 

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$user_info = null;

if ($user_id) {
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $user_info = $result->fetch_assoc();
    }
}
?>



<link rel="stylesheet" href="style1.css">

<main>
    <section class="header-buttons">
        <?php if (!$user_id): ?>
            <a href="login.php" class="cta-button">Login</a>
            <a href="register.php" class="cta-button">Sign Up</a>
        <?php else: ?>
            <a href="profile.php" class="cta-button">My Profile</a>
            <a href="logout.php" class="cta-button">Logout</a>
        <?php endif; ?>
    </section>

    <section class="intro">
        <h2>Welcome to the Pilot Management System</h2>
        <p>Your all-in-one platform for managing flight operations, passenger details, fuel calculations, and aircraft maintenance logs.</p>
    </section>

    <section class="overview">
        <h2>System Features</h2>
        <div class="feature">
            <h3>Fuel Calculation</h3>
            <p>Calculate fuel requirements based on aircraft type, distance, and fuel rate.</p>
        </div>
        <div class="feature">
            <h3>Passenger Management</h3>
            <p>Easily manage passenger lists and assign seat numbers for your flights.</p>
        </div>
        <div class="feature">
            <h3>Flight Information</h3>
            <p>Record and view flight details such as departure, arrival, and flight schedules.</p>
        </div>
    </section>
</main>

<?php include('footer.php'); ?>

<style>
/* Body */
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(135deg, #4c7df5, #00c6ff); /* Smooth gradient */
    height: 100vh;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background-attachment: fixed; /* Smooth transition effect */
}

/* Header Buttons (Profile, Login, etc.) */
.header-buttons {
    position: absolute;
    top: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    gap: 10px;
}

.cta-button {
    background-color: #4c7df5;
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 16px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.cta-button:hover {
    background-color: #3b6cd4;
}

/* Main Intro Section */
.intro {
    text-align: center;
    padding: 80px 20px 40px;
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
    border-radius: 10px;
    max-width: 80%;
    margin: 0 auto;
    backdrop-filter: blur(5px); /* Smooth background blur */
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.intro h2 {
    font-size: 30px;
    font-weight: bold;
    margin-bottom: 15px;
    letter-spacing: 1px;
}

.intro p {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.8);
    line-height: 1.6;
    margin-bottom: 40px;
}

/* Overview Section */
.overview {
    display: flex;
    justify-content: space-around;
    padding: 40px 20px;
    background-color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    margin: 0 20px;
}

.feature {
    width: 30%;
    padding: 25px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.feature:hover {
    transform: translateY(-5px);
}

.feature h3 {
    font-size: 20px;
    margin-bottom: 10px;
    color: #333;
    font-weight: 600;
}

.feature p {
    font-size: 14px;
    color: #777;
    line-height: 1.5;
}

.feature h3, .feature p {
    margin: 0 0 10px 0;
}

/* General Improvements */
h2, h3 {
    font-family: 'Arial', sans-serif;
}

/* Footer */
footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px;
    font-size: 14px;
}

/* Responsive Design Adjustments */
@media (max-width: 768px) {
    .overview {
        flex-direction: column;
        align-items: center;
    }

    .feature {
        width: 80%;
        margin-bottom: 20px;
    }
}


</style>