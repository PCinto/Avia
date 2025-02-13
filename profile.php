<?php
session_start();
include('db_config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

// Handle Profile Picture Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profile_picture"])) {
    $file_name = $_FILES["profile_picture"]["name"];
    $file_tmp = $_FILES["profile_picture"]["tmp_name"];
    $upload_dir = "imgs";

    move_uploaded_file($file_tmp, $upload_dir . $file_name);
    $profile_picture = $upload_dir . $file_name;

    $sql = "UPDATE users SET profile_picture = '$profile_picture' WHERE id = $user_id";
    $conn->query($sql);
    header("Location: profile.php");
    exit();
}

// Handle Profile Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_profile"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone_number"];
    $company = $_POST["company"];
    $residence = $_POST["residence"];

    $sql = "UPDATE users SET name='$name', email='$email', phone_number='$phone', company='$company', residence='$residence' WHERE id = $user_id";
    $conn->query($sql);
    header("Location: profile.php");
    exit();
}

// Handle Account Deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_account"])) {
    $sql = "DELETE FROM users WHERE id = $user_id";
    $conn->query($sql);
    session_destroy();
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
 
</head>
<body>
    <h2 class="profile-title">My Profile - <?php echo $user['name']; ?></h2>
    <div class="profile-container">
        <img src="<?php echo !empty($user['profile_picture']) ? $user['profile_picture'] : 'default.png'; ?>" class="profile-picture" alt="Profile Picture">
        <h3><?php echo $user['name']; ?></h3>

        <!-- Update Profile Picture -->
        <form method="POST" enctype="multipart/form-data">
            <label>Update Profile Picture:</label>
            <input type="file" name="profile_picture">
            <button type="submit" class="action-button save-button">Upload</button>
        </form>

        <!-- Editable Profile Form -->
        <form method="POST" class="profile-form">
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>

            <div class="form-group">
                <label>Phone Number:</label>
                <input type="text" name="phone_number" value="<?php echo $user['phone_number']; ?>" required>
            </div>

            <div class="form-group">
                <label>Company:</label>
                <input type="text" name="company" value="<?php echo $user['company']; ?>" required>
            </div>

            <div class="form-group">
                <label>Residence:</label>
                <input type="text" name="residence" value="<?php echo $user['residence']; ?>" required>
            </div>

            <div class="form-group">
                <label>User Type:</label>
                <input type="text" value="<?php echo ucfirst($user['user_type']); ?>" disabled>
            </div>

            <button type="submit" name="update_profile" class="action-button save-button">Save Changes</button>
        </form>

        <!-- Delete Account -->
        <form method="POST">
            <button type="submit" name="delete_account" class="action-button delete-button" onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.');">
                Delete Account
            </button>
        </form>

        <a href="index.php" class="back-button">Go Back</a>
    </div>
</body>
</html>
