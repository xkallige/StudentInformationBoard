<?php
session_start();

// Redirect to login if not logged in as admin
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

// Get statistics
$total_students_query = "SELECT COUNT(*) as total FROM groupseven";
$total_students_result = mysqli_query($connection, $total_students_query);
$total_students = mysqli_fetch_assoc($total_students_result)['total'];

$total_results_query = "SELECT COUNT(*) as total FROM student_results";
$total_results_result = mysqli_query($connection, $total_results_query);
$total_results = mysqli_fetch_assoc($total_results_result)['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
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
        <h1 class="logo">Admin Dashboard</h1>
      </div>
      <button class="navbar-toggle" aria-label="Open navigation menu" onclick="document.querySelector('.navbar ul').classList.toggle('show-nav')">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <ul>
        <li><a href="admin_dashboard.php" class="active">Dashboard</a></li>
        <li><a href="view_students.php">View Students</a></li>
        <li><a href="upload_result.php">Upload Result</a></li>
        <li><a href="manage_results.php">Manage Results</a></li>
        <li><a href="admin_logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h2>Welcome, Admin 👋</h2>
    <p>Staff ID: <span style="color:#8B0000;font-weight:600;"><?php echo htmlspecialchars($staff_id); ?></span></p>
  </section>

  <section class="dashboard-container" style="padding:40px 20px;max-width:1100px;margin:auto;">
    <div class="dashboard-grid" style="display:flex;flex-wrap:wrap;gap:30px;justify-content:center;">

      <!-- Statistics Card -->
      <div class="card" style="flex:1 1 300px;min-width:280px;">
        <h3 style="color:#8B0000;">📊 Statistics</h3>
        <div style="margin:20px 0;">
          <p style="font-size:1.1em;margin:15px 0;"><strong>Total Students:</strong> <?php echo $total_students; ?></p>
          <p style="font-size:1.1em;margin:15px 0;"><strong>Total Results Uploaded:</strong> <?php echo $total_results; ?></p>
        </div>
      </div>

      <!-- Quick Actions Card -->
      <div class="card" style="flex:1 1 300px;min-width:280px;">
        <h3 style="color:#8B0000;">⚡ Quick Actions</h3>
        <div style="display:flex;flex-direction:column;gap:15px;margin-top:20px;">
          <a href="view_students.php" class="btn-view" style="text-decoration:none;display:block;text-align:center;">👥 View All Students</a>
          <a href="upload_result.php" class="btn-save" style="text-decoration:none;display:block;text-align:center;background:#8B0000;">📤 Upload New Result</a>
          <a href="manage_results.php" class="btn-view" style="text-decoration:none;display:block;text-align:center;">📋 Manage Results</a>
        </div>
      </div>
        
        <!-- Content Management Card -->
      <div class="card" style="flex:1 1 300px;min-width:280px;">
        <h3 style="color:#8B0000;">📢 Content Management</h3>
        <div style="display:flex;flex-direction:column;gap:15px;margin-top:20px;">
          <a href="upload_announcement.php" class="btn-view" style="text-decoration:none;display:block;text-align:center;">📣 Upload Announcement</a>
          <a href="upload_event.php" class="btn-view" style="text-decoration:none;display:block;text-align:center;">📅 Upload Event</a>
          <a href="upload_timetable.php" class="btn-view" style="text-decoration:none;display:block;text-align:center;">🗓️ Upload Timetable</a>
        </div>
      </div>

      <!-- Recent Activity Card -->
      <div class="card" style="flex:1 1 300px;min-width:280px;">
        <h3 style="color:#8B0000;">🕒 Recent Activity</h3>
        <?php
        $recent_query = "SELECT sr.*, g.username FROM student_results sr 
                        JOIN groupseven g ON sr.regno = g.regno 
                        ORDER BY sr.uploaded_at DESC LIMIT 5";
        $recent_result = mysqli_query($connection, $recent_query);
        
        if (mysqli_num_rows($recent_result) > 0):
        ?>
          <div style="margin-top:15px;">
            <?php while($row = mysqli_fetch_assoc($recent_result)): ?>
              <div style="padding:10px 0;border-bottom:1px solid #eee;">
                <p style="margin:5px 0;font-size:0.9em;"><strong><?php echo htmlspecialchars($row['username']); ?></strong></p>
                <p style="margin:5px 0;font-size:0.85em;color:#666;">
                  <?php echo $row['semester']; ?> - <?php echo $row['session']; ?>
                </p>
                <p style="margin:5px 0;font-size:0.8em;color:#999;">
                  <?php echo date('M d, Y', strtotime($row['uploaded_at'])); ?>
                </p>
              </div>
            <?php endwhile; ?>
          </div>
        <?php else: ?>
          <p style="color:#888;margin-top:20px;">No recent activity.</p>
        <?php endif; ?>
      </div>

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