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
    <title>Events - EventHive</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Upcoming Events</h1>
    <ul>
        <li><strong>Workshop on Web Development</strong> - April 25, 2025</li>
        <li><strong>AI Symposium</strong> - May 10, 2025</li>
        <li><strong>Hackathon 3.0</strong> - June 1, 2025</li>
    </ul>
</div>
</body>
</html>