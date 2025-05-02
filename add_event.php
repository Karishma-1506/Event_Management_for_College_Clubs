<?php
include 'db.php';

// Get club name from URL
$club_name = isset($_GET['club_name']) ? $_GET['club_name'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Gather form inputs
    $club_name   = $_POST['club_name'];
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $event_date  = $_POST['event_date'];

    // 1) Check for existing event on that date for this club
    $chk = $conn->prepare("
        SELECT COUNT(*) 
        FROM events 
        WHERE club_name = ? AND event_date = ?
    ");
    $chk->bind_param("ss", $club_name, $event_date);
    $chk->execute();
    $chk->bind_result($count);
    $chk->fetch();
    $chk->close();

    if ($count > 0) {
        // Conflict: show popup and go back to the events page for that club
        echo <<<JS
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  Swal.fire({
    icon: 'warning',
    title: 'Date Occupied',
    text: 'An event is already scheduled on {$event_date} for this club. Please choose another date.',
  }).then(() => {
    window.location.href = 'events.php?club_name=' + encodeURIComponent('{$club_name}');
  });
</script>
JS;
        exit; // Ensure no further processing or HTML output is sent
    }

    // 2) Handle image upload
    $image     = $_FILES['image']['name'];
    $tmp_path  = $_FILES['image']['tmp_name'];
    $target    = __DIR__ . '/uploads/' . basename($image);

    if (!move_uploaded_file($tmp_path, $target)) {
        echo <<<JS
<script>
  alert('Failed to upload image.');
  window.history.back();
</script>
JS;
        exit;
    }

    // 3) Insert the new event
    $stmt = $conn->prepare("
        INSERT INTO events (club_name, title, description, event_date, image)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("sssss", $club_name, $title, $description, $event_date, $image);
    $stmt->execute();
    $stmt->close();

    // 4) Success: redirect back to events page
    header("Location: events.php?club_name=" . urlencode($club_name));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Event | <?= htmlspecialchars($club_name) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body { background: #1a1a5e url('bg.jpg') center/cover no-repeat; font-family:'Segoe UI',sans-serif; margin:0; color:white; }
    header { display:flex; align-items:center; padding:15px 30px; background:rgba(0,0,0,0.4); }
    .logo { height:50px; margin-right:auto; }
    nav a { color:white; text-decoration:none; margin:0 15px; font-weight:600; }
    nav a.active { background:white; color:#1a1a5e; padding:5px 10px; border-radius:6px; }
    .form-container { max-width:600px; margin:50px auto; background:rgba(255,255,255,0.95); color:black; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.2); }
    .form-container h2 { text-align:center; margin-bottom:20px; }
    .form-container label { display:block; margin:12px 0 6px; font-weight:600; }
    .form-container input[type="text"],
    .form-container input[type="date"],
    .form-container textarea,
    .form-container input[type="file"] {
      width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:16px;
    }
    .form-container button {
      width:100%; padding:12px; margin-top:20px;
      background:#1a1a5e; color:white; border:none; border-radius:8px; font-size:18px; cursor:pointer;
    }
    .form-container button:hover { background:#3333a3; }
  </style>
</head>
<body>
  <header>
    <img src="event logo.png" alt="EventHive Logo" class="logo">
    <nav>
      <a href="index.php">Home</a>
      <a href="clubs.php">Clubs</a>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
      <a href="add_event.php?club_name=<?= urlencode($club_name) ?>" class="active">Add Event</a>
    </nav>
  </header>

  <div class="form-container">
    <h2>Add Event for “<?= htmlspecialchars($club_name) ?>”</h2>
    <form method="POST" enctype="multipart/form-data">
      <input type="hidden" name="club_name" value="<?= htmlspecialchars($club_name) ?>">

      <label for="title">Event Title:</label>
      <input type="text" id="title" name="title" required>

      <label for="description">Event Description:</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <label for="event_date">Event Date:</label>
      <input type="date" id="event_date" name="event_date" required>

      <label for="image">Event Image:</label>
      <input type="file" id="image" name="image" accept="image/*" required>

      <button type="submit">Add Event</button>
    </form>
  </div>
</body>
</html>
