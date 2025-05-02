<?php 
session_start();
require 'db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "No user found";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 30px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .profile-header h2 {
            font-size: 24px;
            color: #333;
        }

        .profile-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 20px;
        }

        .profile-details div {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
        }

        .profile-details label {
            font-weight: bold;
        }

        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .profile-actions {
            text-align: center;
            margin-top: 20px;
        }
     </style>
</head>
<body>

    <div class="container">
        <div class="profile-header">
            <!-- Display Profile Image -->
            <?php
            // Check if the user has uploaded a profile image, and if not, use a default one
            $profile_image = $user['profile_image'] ? $user['profile_image'] : 'uploads/default_profile.jpg'; // Ensure the correct relative path
            ?>
            <img src="<?php echo $profile_image; ?>" alt="Profile Icon">
            <h2><?php echo $user['name']; ?>'s Profile</h2>
        </div>

        <div class="profile-details">
            <div>
                <label for="name">Name:</label>
                <p id="name"><?php echo $user['name']; ?></p>
            </div>
            <div>
                <label for="email">Email:</label>
                <p id="email"><?php echo $user['email']; ?></p>
            </div>
            <div>
                <label for="phone">Phone:</label>
                <p id="phone"><?php echo $user['phone']; ?></p>
            </div>
            <div>
                <label for="prn">PRN:</label>
                <p id="prn"><?php echo $user['prn']; ?></p>
            </div>
        </div>

        <div class="profile-actions">
            <a href="edit_profile.php" class="btn">Edit Profile</a>
            <a href="index.php" class="btn">Home</a>
        </div>
    </div>

</body>
</html>
