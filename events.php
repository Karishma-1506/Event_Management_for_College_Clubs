<?php
include 'db.php';

$club_name = $conn->real_escape_string($_GET['club_name'] ?? '');
// Fetch events by club_name
$stmt = $conn->prepare("SELECT * FROM events WHERE club_name = ? ORDER BY event_date");
$stmt->bind_param("s", $club_name);
$stmt->execute();
$res = $stmt->get_result();
// Collect dates for calendar
$dates = [];
foreach ($res as $row) {
    $dates[] = date('Y-m-d', strtotime($row['event_date']));
}
// Re-fetch for display
$stmt->execute();
$res = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Events - <?= htmlspecialchars($club_name) ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <img src="event logo.png" class="logo" alt="EventHive Logo">
    <nav>
      <a href="index.php">Home</a>
      <a href="clubs.php">Clubs</a>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
      <a href="events.php?club_name=<?= urlencode($club_name) ?>" class="active">Events</a>
    </nav>
  </header>

  <div class="container">
    <h2>Events for <?= htmlspecialchars($club_name) ?></h2>
    <a href="add_event.php?club_name=<?= urlencode($club_name) ?>" class="btn">+ Add Event</a>

    <div class="events-container">
      <?php while($e = $res->fetch_assoc()): ?>
        <div class="event-box">
          <img src="uploads/<?= htmlspecialchars($e['image']) ?>" alt="<?= htmlspecialchars($e['title']) ?>">
          <h3><?= htmlspecialchars($e['title']) ?></h3>
          <small><?= date('d M Y', strtotime($e['event_date'])) ?></small>
          <p><?= htmlspecialchars($e['description']) ?></p>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="calendar-container">
      <h3>Event Calendar</h3>
      <div id="calendar"></div>
    </div>
  </div>

  <script>
    const eventDates = <?= json_encode($dates) ?>;
    const cal = document.getElementById('calendar');
    const today = new Date(), y = today.getFullYear(), m = today.getMonth();
    const daysInMonth = new Date(y, m+1, 0).getDate();
    const firstDow = new Date(y, m, 1).getDay();
    let html = '<table><tr>';
    ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].forEach(d=> html += `<th>${d}</th>`);
    html += '</tr><tr>';
    for(let i=0;i<firstDow;i++) html += '<td></td>';
    for(let d=1; d<=daysInMonth; d++){
      const iso = `${y}-${String(m+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
      html += `<td${eventDates.includes(iso)?' class="red-dot"':''}>${d}</td>`;
      if((firstDow+d)%7===0) html+='</tr><tr>';
    }
    html += '</tr></table>';
    cal.innerHTML = html;
  </script>
</body>
</html>