<?php
session_start();
include("db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Prevent SQL injection
  $username = mysqli_real_escape_string($conn, $username);
  $password = mysqli_real_escape_string($conn, $password);

  // Simple check — replace with password hashing in production
  $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = mysqli_query($conn, $query);

  if (mysqli_num_rows($result) == 1) {
    $_SESSION['username'] = $username;
    echo "<script>alert('Login successful!'); window.location.href='clubs.php';</script>";
  } else {
    echo "<script>alert('Invalid username or password. Please try again.'); window.location.href='login.php';</script>";
  }
}
?>
