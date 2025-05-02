<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us - EventHive</title>
  <link rel="stylesheet" href="css/about_us_1.css"> <!-- Adjusted for your structure -->
</head>
<body>

<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login_form.php");
    exit();
}
?>

<!-- Navigation Bar -->
<header>
  <div class="logo">
    <img src="event logo.png" alt="EventHive Logo">
  </div>
  <nav>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#" class="active">About Us</a></li>
      <li><a href="#">REGISTER/LOGIN</a></li>
      <li><a href="#">CLUBS</a></li>
      <li><a href="#">CONTACT US</a></li>
    </ul>
  </nav>
</header>

<!-- About Us Section -->
<section class="about-section">
  <div class="about-container">
    <div class="about-image">
      <img src="event_announcment.jpg" alt="Events Announcement">
    </div>
    <div class="about-text">
      <h1>About Us</h1>
      <p><strong>Welcome, <?php echo $_SESSION['username']; ?>!</strong></p>
      <p>Empowering College Clubs & Events with <strong>Seamless Management</strong>!<br>
      We simplify the process of organizing, discovering, and participating in college events, ensuring that students never miss an opportunity to engage, learn, and have fun.</p>

      <h3>Why Choose Us?</h3>
      <ul>
        <li>✅ <strong>All Events in One Place</strong> – Browse & register for upcoming college events effortlessly.</li>
        <li>✅ <strong>Simplified Club Management</strong> – Clubs can organize, promote, and manage their events seamlessly.</li>
        <li>✅ <strong>Stay Updated</strong> – Get real-time notifications & reminders for the events that matter.</li>
        <li>✅ <strong>Easy Collaboration</strong> – Faculty & students can connect and collaborate to create meaningful experiences.</li>
      </ul>

      <h3>Join Us in Transforming Campus Life!</h3>
      <p>Be a part of a <strong>dynamic</strong> college community where events bring people together.<br>
      💡 <strong>Ready to explore?</strong></p>

      <a href="#" class="get-started-btn">GET STARTED →</a><br><br>
      <a href="php/logout.php"><button>Logout</button></a>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="footer">
  <div class="footer-content">
    <h3>Contact Us</h3>
    <p>Email: eventhive@gmail.com | Phone: +91 98765 43210</p>
    <p>Follow us on:
      <a href="#">Instagram</a> |
      <a href="#">Facebook</a> |
      <a href="#">LinkedIn</a>
    </p>
    <p>&copy; 2025 EventHive. All rights reserved.</p>
  </div>
</footer>

</body>
</html>
