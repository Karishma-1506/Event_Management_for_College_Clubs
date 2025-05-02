<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login_form.php");
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

// Handling the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $prn = $_POST['prn'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];

    // Handle the profile image upload (if any)
    $profile_image = $user['profile_image']; // Default to the existing image
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $image = $_FILES['profile_image'];
        $targetDir = "uploads/";  // Correct relative path to the uploads directory
        $targetFile = $targetDir . basename($image["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Validate if the file is an image
        $check = getimagesize($image["tmp_name"]);
        if ($check === false) {
            echo "<script>alert('File is not an image'); window.history.back();</script>";
            exit();
        }

        // Check file size (optional)
        if ($image["size"] > 500000) { // Limit to 500KB
            echo "<script>alert('Sorry, your file is too large.'); window.history.back();</script>";
            exit();
        }

        // Allow only certain image formats (JPG, PNG, JPEG)
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            echo "<script>alert('Only JPG, JPEG, and PNG files are allowed.'); window.history.back();</script>";
            exit();
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            $profile_image = $targetFile;  // Store relative path to the image
        } else {
            echo "<script>alert('Error uploading image'); window.history.back();</script>";
            exit();
        }
    }

    // Update the user's information in the database
    $stmt = $conn->prepare("UPDATE users SET name = ?, prn = ?, phone = ?, email = ?, username = ?, profile_image = ? WHERE username = ?");
    $stmt->bind_param("sssssss", $name, $prn, $phone, $email, $username, $profile_image, $username);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully'); window.location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Failed to update profile'); window.history.back();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - EventHive</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('background.jpg'); /* Set a background image */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent background for the form */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: grid;
            gap: 15px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .profile-image-preview {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-image-preview img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Profile</h2>
        <form action="edit_profile.php" method="post" enctype="multipart/form-data">
            <div>
                <label for="name">Full Name:</label>
                <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div>
                <label for="prn">PRN:</label>
                <input type="text" name="prn" value="<?php echo $user['prn']; ?>" required>
            </div>
            <div>
                <label for="phone">Phone Number:</label>
                <input type="text" name="phone" value="<?php echo $user['phone']; ?>" required>
            </div>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
            </div>
            <div>
                <label for="profile_image">Profile Picture:</label>
                <input type="file" name="profile_image" id="profile_image">
                <div class="profile-image-preview">
                    <small>Current image:</small>
                    <img src="<?php echo $user['profile_image']; ?>" alt="Current Profile Image">
                </div>
            </div>
            <button type="submit">Save Changes</button>
        </form>
        <a href="profile.php" class="back-link">Back to Profile</a>
    </div>

</body>
</html>
