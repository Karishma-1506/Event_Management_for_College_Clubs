<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login_form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - EventHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <p><a href="profile.php">View Profile</a> | <a href="clubs.php">Browse Events</a> | <a href="php/logout.php">Logout</a></p>
</div>
</body>
</html>