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

// Handle file upload
if (isset($_POST['upload_timetable'])) {
  $level = trim($_POST['level']);
  $semester = trim($_POST['semester']);

  if (isset($_FILES['timetable_file']) && $_FILES['timetable_file']['error'] == 0) {
    $file_name = $_FILES['timetable_file']['name'];
    $file_tmp = $_FILES['timetable_file']['tmp_name'];
    $file_size = $_FILES['timetable_file']['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
    
    if (!in_array($file_ext, $allowed)) {
      $_SESSION['message'] = "❌ Only PDF and image files are allowed!";
      header("Location: upload_timetable.php");
      exit();
    }

    if ($file_size > 5242880) {
      $_SESSION['message'] = "❌ File size must be less than 5MB!";
      header("Location: upload_timetable.php");
      exit();
    }

    if (!file_exists('timetables')) {
      mkdir('timetables', 0777, true);
    }

    $new_filename = 'timetable_' . $level . '_' . time() . '.' . $file_ext;
    $upload_path = 'timetables/' . $new_filename;

    if (move_uploaded_file($file_tmp, $upload_path)) {
      // Check if timetable exists for this level/semester
      $check_query = "SELECT * FROM timetables WHERE level='$level' AND semester='$semester' LIMIT 1";
      $check_result = mysqli_query($connection, $check_query);

      if (mysqli_num_rows($check_result) > 0) {
        // Update existing
        $old_file = mysqli_fetch_assoc($check_result)['timetable_file_path'];
        if (file_exists($old_file)) {
          unlink($old_file);
        }
        $query = "UPDATE timetables SET timetable_file_path='$upload_path', posted_by='$staff_id', created_at=NOW() 
                  WHERE level='$level' AND semester='$semester'";
      } else {
        // Insert new
        $query = "INSERT INTO timetables (level, semester, timetable_file_path, posted_by) 
                  VALUES ('$level', '$semester', '$upload_path', '$staff_id')";
      }

      if (mysqli_query($connection, $query)) {
        $_SESSION['message'] = "✅ Timetable uploaded successfully!";
      } else {
        $_SESSION['message'] = "❌ Database error: " . mysqli_error($connection);
      }
    } else {
      $_SESSION['message'] = "❌ Failed to upload file!";
    }
  } else {
    $_SESSION['message'] = "❌ Please select a file to upload!";
  }

  header("Location: upload_timetable.php");
  exit();
}

// Get all timetables
$timetables_query = "SELECT * FROM timetables ORDER BY created_at DESC";
$timetables = mysqli_query($connection, $timetables_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Upload Timetable</title>
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
        <h1 class="logo">Upload Timetable</h1>
      </div>
      <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="admin_logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h2>🗓️ Upload Timetable</h2>
  </section>

  <section class="dashboard-container" style="padding:40px 20px;max-width:1100px;margin:auto;">
    <div style="display:flex;flex-wrap:wrap;gap:30px;">
      
      <!-- Upload Form -->
      <div class="card" style="flex:1 1 400px;">
        <h3 style="color:#8B0000;">Upload Timetable</h3>
        <form method="POST" action="upload_timetable.php" enctype="multipart/form-data" class="profile-form">
          
          <label>Level:</label>
          <select name="level" required style="width:100%;padding:12px;border:1px solid #ddd;border-radius:6px;font-size:15px;">
            <option value="">-- Select Level --</option>
            <option value="100 Level">100 Level</option>
            <option value="200 Level">200 Level</option>
            <option value="300 Level">300 Level</option>
            <option value="400 Level">400 Level</option>
            <option value="500 Level">500 Level</option>
          </select>

          <label>Semester:</label>
          <select name="semester" required style="width:100%;padding:12px;border:1px solid #ddd;border-radius:6px;font-size:15px;">
            <option value="">-- Select Semester --</option>
            <option value="First Semester">First Semester</option>
            <option value="Second Semester">Second Semester</option>
          </select>

          <label>Select File (PDF or Image):</label>
          <input type="file" name="timetable_file" accept=".pdf,.jpg,.jpeg,.png" required 
                 style="padding:10px;border:1px solid #ddd;border-radius:6px;"/>

          <p style="font-size:0.9em;color:#666;margin-top:5px;">
            * Maximum file size: 5MB<br/>
            * Allowed: PDF, JPG, JPEG, PNG
          </p>

          <button type="submit" name="upload_timetable" class="btn-save" style="background:#8B0000;">Upload Timetable</button>
        </form>
      </div>

      <!-- Uploaded Timetables -->
      <div class="card" style="flex:1 1 400px;">
        <h3 style="color:#8B0000;">Uploaded Timetables</h3>
        <div style="max-height:400px;overflow-y:auto;margin-top:15px;">
          <?php if (mysqli_num_rows($timetables) > 0): ?>
            <?php while($tt = mysqli_fetch_assoc($timetables)): ?>
              <div style="padding:15px;margin-bottom:15px;border:1px solid #eee;border-radius:8px;">
                <h4 style="margin:0 0 8px 0;color:#8B0000;"><?php echo htmlspecialchars($tt['level']); ?></h4>
                <p style="margin:0 0 8px 0;font-size:0.9em;"><?php echo htmlspecialchars($tt['semester']); ?></p>
                <p style="margin:0 0 10px 0;font-size:0.8em;color:#999;">
                  Uploaded: <?php echo date('M d, Y', strtotime($tt['created_at'])); ?>
                </p>
                <a href="<?php echo $tt['timetable_file_path']; ?>" target="_blank" 
                   class="btn-view" style="text-decoration:none;display:inline-block;padding:6px 12px;font-size:0.9em;">View File</a>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p style="color:#888;">No timetables uploaded yet.</p>
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