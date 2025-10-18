<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
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

// Get current user data
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$regno = $_SESSION['regno'];
$email = $_SESSION['email'];
$firstName = explode(' ', $username)[0];

// Handle Profile Update
if (isset($_POST['update_profile'])) {
  $new_username = trim($_POST['fullname']);
  $new_regno = trim($_POST['regno']);
  $new_email = trim($_POST['email']);

  // Validate regno length
  if (!preg_match('/^\d{11}$/', $new_regno)) {
    $_SESSION['message'] = "❌ Registration number must be exactly 11 digits!";
    header("Location: dashboard.php");
    exit();
  }

  // Validate email
  if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "❌ Please enter a valid email address!";
    header("Location: dashboard.php");
    exit();
  }

  // Update database
  $query = "UPDATE groupseven SET username='$new_username', regno='$new_regno', email='$new_email' WHERE id='$user_id'";
  $update = mysqli_query($connection, $query);

  if ($update) {
    // Update session variables
    $_SESSION['username'] = $new_username;
    $_SESSION['regno'] = $new_regno;
    $_SESSION['email'] = $new_email;
    $_SESSION['message'] = "✅ Profile updated successfully!";
  } else {
    $_SESSION['message'] = "❌ Profile update failed: " . mysqli_error($connection);
  }

  header("Location: dashboard.php");
  exit();
}

// Handle Password Change
if (isset($_POST['change_password'])) {
  $current_password = $_POST['current_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  // Fetch current password from database
  $query = "SELECT password FROM groupseven WHERE id='$user_id' LIMIT 1";
  $result = mysqli_query($connection, $query);
  $user = mysqli_fetch_assoc($result);

  // Verify current password
  if (!password_verify($current_password, $user['password'])) {
    $_SESSION['message'] = "❌ Current password is incorrect!";
    header("Location: dashboard.php");
    exit();
  }

  // Check if new passwords match
  if ($new_password !== $confirm_password) {
    $_SESSION['message'] = "❌ New passwords do not match!";
    header("Location: dashboard.php");
    exit();
  }

  // Validate password strength
  if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/', $new_password)) {
    $_SESSION['message'] = "❌ Password must contain more than 8 characters, a letter and a number!";
    header("Location: dashboard.php");
    exit();
  }

  // Update password
  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
  $query = "UPDATE groupseven SET password='$hashed_password' WHERE id='$user_id'";
  $update = mysqli_query($connection, $query);

  if ($update) {
    $_SESSION['message'] = "✅ Password changed successfully!";
  } else {
    $_SESSION['message'] = "❌ Password change failed: " . mysqli_error($connection);
  }

  header("Location: dashboard.php");
  exit();
}

// Fetch student results
$results_query = "SELECT * FROM student_results WHERE regno='$regno' LIMIT 1";
$results_result = mysqli_query($connection, $results_query);
$student_result = mysqli_fetch_assoc($results_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Dashboard</title>
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
        <h1 class="logo">Student Dashboard</h1>
      </div>
      <button class="navbar-toggle" aria-label="Open navigation menu" onclick="document.querySelector('.navbar ul').classList.toggle('show-nav')">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <ul>
        <li><a href="dashboard.php" class="dashboard-link active">👤 <?php echo htmlspecialchars($firstName); ?></a></li>
        <li><a href="index.php">Home</a></li>
        <li><a href="announcements.php">Announcements</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="timetable.php">Timetable</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h2>Welcome, <span style="color:#228B22;"><?php echo htmlspecialchars($username); ?></span> 👋</h2>
    <p>Manage your personal profile and download results here.</p>
  </section>

  <section class="dashboard-container" style="padding:40px 20px;max-width:1100px;margin:auto;">
    <div class="dashboard-grid" style="display:flex;flex-wrap:wrap;gap:30px;justify-content:center;">

      <!-- Profile Information -->
      <div class="card" style="flex:1 1 300px;min-width:280px;">
        <h3 style="color:#228B22;">📝 Profile Information</h3>
        <form method="POST" action="dashboard.php" class="profile-form">
          <label>Full Name:</label>
          <input type="text" name="fullname" value="<?php echo htmlspecialchars($username); ?>" required />

          <label>Registration Number:</label>
          <input type="text" name="regno" value="<?php echo htmlspecialchars($regno); ?>" required />

          <label>Email:</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required />

          <button type="submit" name="update_profile" class="btn-save">Save Changes</button>
        </form>
      </div>

      <!-- Password Section -->
      <div class="card" style="flex:1 1 300px;min-width:280px;">
        <h3 style="color:#228B22;">🔒 Change Password</h3>
        <form method="POST" action="dashboard.php" class="profile-form">
          <label>Current Password:</label>
          <input type="password" name="current_password" required />

          <label>New Password:</label>
          <input type="password" name="new_password" required />

          <label>Confirm Password:</label>
          <input type="password" name="confirm_password" required />

          <button type="submit" name="change_password" class="btn-save">Update Password</button>
        </form>
      </div>

      <!-- Results Section -->
      <div class="card" style="flex:1 1 300px;min-width:280px;">
        <h3 style="color:#228B22;">📄 My Results</h3>
        <?php if ($student_result): ?>
          <div style="text-align:left;margin:15px 0;">
            <p><strong>Semester:</strong> <?php echo htmlspecialchars($student_result['semester']); ?></p>
            <p><strong>Session:</strong> <?php echo htmlspecialchars($student_result['session']); ?></p>
            <p><strong>Uploaded:</strong> <?php echo date('M d, Y', strtotime($student_result['uploaded_at'])); ?></p>
          </div>
          <a href="download_results.php" class="btn-view" style="text-decoration:none;display:inline-block;">📥 Download Result (PDF)</a>
        <?php else: ?>
          <p style="color:#888;margin:20px 0;">No results available yet. Check back later!</p>
        <?php endif; ?>
      </div>

    </div>
  </section>

  <div style="text-align:center;margin:40px 0;">
    <a href="index.php" class="btn-view" style="text-decoration:none;display:inline-block;">⬅️ Back to Home</a>
  </div>

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