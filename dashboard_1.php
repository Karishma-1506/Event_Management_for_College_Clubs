<?php
session_start();
if (!isset($_SESSION['username'])) {
  echo "<script>alert('Please log in first'); window.location.href='login_1.html';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>EventHive - Dashboard</title>
  <link rel="stylesheet" href="home_1.css">
</head>
<body>

  <header>
    <h2 class="logo">EventHive</h2>
    <nav class="navigation">
      <a href="index.php">Home</a>
      <a href="about_us.html">About</a>
      <a href="register_1.html">Register</a>
      <a href="login_1.html">Login</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <section class="main">
    <div class="content">
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h1>
      <p>
        Explore and manage events effortlessly on EventHive. Stay tuned for updates, upcoming fests, and student activities!
      </p>
      <a href="#events" class="main-button">Explore Events</a>
    </div>
  </section>

</body>
</html>
