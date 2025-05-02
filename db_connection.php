<?php
$servername = "localhost";
$username = "root";
$password = ""; // Change if you have a DB password
$dbname = "eventhive"; // Make sure your DB is created

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
