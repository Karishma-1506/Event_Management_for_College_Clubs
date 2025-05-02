<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = $_POST['name'];
    $description = $_POST['description'];
    $image       = $_FILES['image']['name'];
    $tmpPath     = $_FILES['image']['tmp_name'];
    $target      = __DIR__ . "/uploads/" . basename($image);

    if (move_uploaded_file($tmpPath, $target)) {
        $stmt = $conn->prepare(
            "INSERT INTO clubs (name, description, image) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $name, $description, $image);
        $stmt->execute();
        header("Location: clubs.php");
        exit;
    } else {
        $errorMsg = "Failed to upload image.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Club | EventHive</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
      background: rgba(0,0,0,0.4);
    }
    .logo {
      height: 50px;
      margin-right: auto;
    }
    nav a {
      color: white;
      text-decoration: none;
      margin: 0 15px;
      font-weight: 600;
    }
    nav a.active {
      background: white;
      color: #1a1a5e;
      padding: 5px 10px;
      border-radius: 6px;
    }
    .form-container {
      background: rgba(255,255,255,0.95);
      color: black;
      max-width: 600px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    .form-container label {
      display: block;
      margin: 12px 0 6px;
      font-weight: 600;
    }
    .form-container input[type="text"],
    .form-container textarea,
    .form-container input[type="file"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
    }
    .form-container button {
      margin-top: 20px;
      width: 100%;
      padding: 12px;
      background: #1a1a5e;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 18px;
      cursor: pointer;
    }
    .form-container button:hover {
      background: #3333a3;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <header>
    <img src="event logo.png" alt="EventHive Logo" class="logo">
    <nav>
      <a href="index.php">Home</a>
      <a href="clubs.php" class="active">Clubs</a>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <div class="form-container">
    <h2>Add New Club</h2>
    <?php if (!empty($errorMsg)): ?>
      <p class="error"><?= htmlspecialchars($errorMsg) ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
      <label for="name">Club Name:</label>
      <input type="text" id="name" name="name" required>

      <label for="description">Description:</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <label for="image">Club Image:</label>
      <input type="file" id="image" name="image" accept="image/*" required>

      <button type="submit">Add Club</button>
    </form>
  </div>
</body>
</html>
