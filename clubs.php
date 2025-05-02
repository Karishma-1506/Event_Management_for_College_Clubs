<?php
include 'db.php';
$result = $conn->query("SELECT * FROM clubs");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Clubs | EventHive</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <img src="event logo.png" class="logo" alt="EventHive Logo">
    <nav>
      <a href="index.php">Home</a>
      <a href="clubs.php" class="active">Clubs</a>
      <a href="profile.php">Profile</a>
      
    </nav>
  </header>

  <div class="container">
    <div class="top-bar">
      <h2>Clubs</h2>
      <a href="add_club.php" class="btn">+ Add Club</a>
    </div>
    <div class="club-list">
      <?php while($club = $result->fetch_assoc()): ?>
        <a href="events.php?club_name=<?= urlencode($club['name']) ?>" class="club-box">
          <img src="uploads/<?= htmlspecialchars($club['image']) ?>" alt="<?= htmlspecialchars($club['name']) ?>">
          <h3><?= htmlspecialchars($club['name']) ?></h3>
          <p><?= htmlspecialchars($club['description']) ?></p>
        </a>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>

















<!-- <?php
include 'db.php';
$result = $conn->query("SELECT * FROM clubs");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Clubs | EventHive</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: #1a1a5e url('bg.jpg') no-repeat center center/cover;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      color: white;
    }
    header {
      display: flex;
      align-items: center;
      padding: 15px 30px;
    }
    nav {
      margin-left: auto;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-weight: bold;
    }
    nav a.active {
      background: white;
      color: #1a1a5e;
      padding: 5px 10px;
      border-radius: 10px;
    }
    .container {
      max-width: 1100px;
      margin: 40px auto;
      padding: 20px;
    }
    .top-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .top-bar h2 {
      margin: 0;
    }
    .top-bar a {
      background: white;
      color: #1a1a5e;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
    }
    .club-list {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }
    .club-box {
      background: white;
      color: black;
      padding: 20px;
      border-radius: 12px;
      transition: 0.3s;
      text-align: center;
      text-decoration: none;
    }
    .club-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }
    .club-box img {
      max-width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    .club-box h3, .club-box p {
      margin: 0;
    }
  </style>
</head>
<body>
  <header>
    <img src="event logo.png" alt="EventHive Logo" height="50">
    <nav>
      <a href="index.php">Home</a>
      <a href="clubs.php" class="active">Clubs</a>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="container">
    <div class="top-bar">
      <h2>Clubs</h2>
      <a href="add_club.php">+ Add Club</a>
    </div>
    <div class="club-list">
      <?php while ($club = $result->fetch_assoc()): ?>
        <a href="events.php?club_id=<?= $club['id'] ?>" class="club-box">
          <img src="uploads/<?= $club['image'] ?>" alt="<?= htmlspecialchars($club['name']) ?>">
          <h3><?= htmlspecialchars($club['name']) ?></h3>
          <p><?= htmlspecialchars($club['description']) ?></p>
        </a>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
 -->