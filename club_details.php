<?php
session_start();
require 'db_config.php';

// Check if club_id is passed in the URL
if (!isset($_GET['club_id'])) {
    echo "Club ID is missing!";
    exit();
}

$club_id = $_GET['club_id'];

// Query to get club details using club_id
$stmt = $conn->prepare("SELECT * FROM clubs WHERE id = ?");
$stmt->bind_param("i", $club_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $club = $result->fetch_assoc();
} else {
    echo "Club not found!";
    exit();
}

// Query to get events for this club
$events_stmt = $conn->prepare("SELECT * FROM events WHERE club_id = ?");
$events_stmt->bind_param("i", $club_id);
$events_stmt->execute();
$events_result = $events_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $club['name']; ?> - Club Details</title>
    <link rel="stylesheet" href="club-style.css">
</head>
<body>

    <!-- Header -->
    <header>
        <div class="container">
            <nav>
                <a href="index.php">Home</a>
                <a href="clubs.php">Clubs</a>
                <a href="profile.php">Profile</a>
               
            </nav>
        </div>
    </header>

    <!-- Club Details -->
    <section class="club-details">
        <div class="container">
            <h1><?php echo $club['name']; ?></h1>
            <!-- Check if logo exists and display -->
            <?php if ($club['logo']): ?>
                <img src="uploads/<?php echo $club['logo']; ?>" alt="Logo">
            <?php else: ?>
                <p>No logo available.</p>
            <?php endif; ?>
            <p><?php echo $club['info']; ?></p>

            <h2>Upcoming and Past Events</h2>
            <div class="events">
                <?php while ($event = $events_result->fetch_assoc()) { ?>
                    <div class="event">
                        <h3><?php echo $event['event_name']; ?></h3>
                        <p><strong>Date:</strong> <?php echo $event['event_date']; ?></p>
                        <p><strong>Time:</strong> <?php echo $event['event_time']; ?></p>
                        <p><strong>Location:</strong> <?php echo $event['event_location']; ?></p>
                        <p><strong>Information:</strong> <?php echo $event['event_info']; ?></p>

                        <!-- Gallery Section: Fetch and display event photos from the gallery table -->
                        <h4>Event Gallery</h4>
                        <div class="gallery">
                            <?php
                            // Fetch images for the current event
                            $gallery_stmt = $conn->prepare("SELECT * FROM gallery WHERE event_id = ?");
                            $gallery_stmt->bind_param("i", $event['id']);
                            $gallery_stmt->execute();
                            $gallery_result = $gallery_stmt->get_result();

                            // Display images if any exist
                            if ($gallery_result && $gallery_result->num_rows > 0) {
                                while ($photo = $gallery_result->fetch_assoc()) {
                                    echo '<div class="gallery-item"><img src="uploads/' . $photo['image_name'] . '" alt="Event Photo"></div>';
                                }
                            } else {
                                echo '<p>No photos available for this event.</p>';
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <p>&copy; 2025 Club Management</p>
        </div>
    </footer>

</body>
</html>
