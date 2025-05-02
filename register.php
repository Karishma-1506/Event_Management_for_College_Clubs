<?php
require '../db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $name = $_POST['name'];
    $prn = $_POST['prn'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $created_at = date('Y-m-d H:i:s');

    // Handle Image Upload
    if (isset($_FILES['profile_image'])) {
        $image = $_FILES['profile_image'];
        $targetDir = "../uploads/";  // Directory where images will be stored
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
            // Insert user data and image file path into the database
            $stmt = $conn->prepare("INSERT INTO users (name, prn, phone, email, username, password, profile_image, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $name, $prn, $phone, $email, $username, $password, $targetFile, $created_at);

            if ($stmt->execute()) {
                echo "<script>alert('Registration successful'); window.location.href='../login_form.php';</script>";
            } else {
                echo "<script>alert('Registration failed'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Please upload a profile image.'); window.history.back();</script>";
    }
}
?>
