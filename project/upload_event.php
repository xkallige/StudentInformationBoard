<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: login.php");
  exit();
}

$lhost = 'sql300.infinityfree.com';
$dbuser = 'if0_40184676';
$pass = 'ejikegoodness01';
$db = 'if0_40184676_citwebsite';

$connection = mysqli_connect($lhost, $dbuser, $pass, $db);

if (!$connection) {
  die("Database connection failed: " . mysqli_connect_error());
}

$staff_id = $_SESSION['admin_staff_id'];

// Handle form submission
if (isset($_POST['post_event'])) {
  $title = trim($_POST['title']);
  $description = trim($_POST['description']);
  $event_date = $_POST['event_date'];
  $location = trim($_POST['location']);

  $query = "INSERT INTO events (title, description, event_date, location, posted_by) 
            VALUES ('$title', '$description', '$event_date', '$location', '$staff_id')";
  
  if (mysqli_query($connection, $query)) {
    $_SESSION['message'] = "✅ Event posted successfully!";
  } else {
    $_SESSION['message'] = "❌ Failed to post event: " . mysqli_error($connection);
  }
  
  header("Location: upload_event.php");
  exit();
}

// Get all events
$events_query = "SELECT * FROM events ORDER BY event_date DESC";
$events = mysqli_query($connection, $events_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Upload Event</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="popup.css" />
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="navbar-first">
        <div class="navbar-logos">
          <img src="futo_logo.png" alt="FUTO Logo" class="logo-img" />
          <img src="nacos.png" alt="NACOSS Logo" class="logo-img" />
        </div>
        <h1 class="logo">Upload Event</h1>
      </div>
      <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="admin_logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h2>📅 Post New Event</h2>
  </section>

  <section class="dashboard-container" style="padding:40px 20px;max-width:1100px;margin:auto;">
    <div style="display:flex;flex-wrap:wrap;gap:30px;">
      
      <!-- Post Form -->
      <div class="card" style="flex:1 1 400px;">
        <h3 style="color:#8B0000;">Create Event</h3>
        <form method="POST" action="upload_event.php" class="profile-form">
          <label>Event Title:</label>
          <input type="text" name="title" placeholder="Event title" required />

          <label>Description:</label>
          <textarea name="description" rows="4" placeholder="Event description..." 
                    required style="width:100%;padding:12px;border:1px solid #ddd;border-radius:6px;font-size:15px;font-family:inherit;"></textarea>

          <label>Event Date:</label>
          <input type="date" name="event_date" required />

          <label>Location:</label>
          <input type="text" name="location" placeholder="Event location" required />

          <button type="submit" name="post_event" class="btn-save" style="background:#8B0000;">Post Event</button>
        </form>
      </div>

      <!-- Recent Events -->
      <div class="card" style="flex:1 1 400px;">
        <h3 style="color:#8B0000;">Upcoming Events</h3>
        <div style="max-height:400px;overflow-y:auto;margin-top:15px;">
          <?php if (mysqli_num_rows($events) > 0): ?>
            <?php while($event = mysqli_fetch_assoc($events)): ?>
              <div style="padding:15px;margin-bottom:15px;border:1px solid #eee;border-radius:8px;">
                <h4 style="margin:0 0 10px 0;color:#8B0000;"><?php echo htmlspecialchars($event['title']); ?></h4>
                <p style="margin:0 0 8px 0;font-size:0.9em;"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                <p style="margin:0 0 5px 0;font-size:0.85em;color:#666;">
                  📅 <?php echo date('M d, Y', strtotime($event['event_date'])); ?>
                </p>
                <p style="margin:0;font-size:0.85em;color:#666;">
                  📍 <?php echo htmlspecialchars($event['location']); ?>
                </p>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p style="color:#888;">No events yet.</p>
          <?php endif; ?>
        </div>
      </div>

    </div>

    <div style="text-align:center;margin:30px 0;">
      <a href="admin_dashboard.php" class="btn-view" style="text-decoration:none;display:inline-block;">⬅️ Back to Dashboard</a>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Department of Computer Science</p>
  </footer>

  <script src="popup.js"></script>
</body>
</html>

<?php if (!empty($_SESSION['message'])): ?>
  <div id="popup" class="popup" style="display:flex;">
    <div class="popup-content">
      <span id="close-popup" class="close">&times;</span>
      <p><?php echo $_SESSION['message']; ?></p>
    </div>
  </div>
  <?php unset($_SESSION['message']); ?>
<?php endif; ?>